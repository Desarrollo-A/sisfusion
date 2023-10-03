<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

use PhpOffice\PhpSpreadsheet\Spreadsheet;


class Comisiones extends CI_Controller
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
    $this->jwt_actions->authorize('7396', $_SERVER['HTTP_HOST']);
    $this->validateSession();
    $rutaUrl = explode($_SESSION['rutaActual'], $_SERVER["REQUEST_URI"]);
    $this->permisos_sidebar->validarPermiso($this->session->userdata('datos'),$rutaUrl[1],$this->session->userdata('opcionesMenu'));
   }

  public function index(){
    redirect(base_url());
  }
  

  public function validateSession() {
    if ($this->session->userdata('id_usuario') == "" || $this->session->userdata('id_rol') == "")
      redirect(base_url() . "index.php/login");
  }

  // dispersion-view complete

  public function dispersion() {
    if ($this->session->userdata('id_rol') == FALSE)
        redirect(base_url());
        
        $datos["controversias"] = $this->Comisiones_model->getMotivosControversia();
        $this->load->view('template/header');
        $this->load->view("comisiones/dispersion-view", $datos);
  }


  public function getDataDispersionPago() {
    $data['data'] = $this->Comisiones_model->getDataDispersionPago()->result_array();
    echo json_encode($data);
  }
    

  public function getPlanesComisiones($val = ''){

      $data = array();
      if(empty($val)){
        $data = $this->Comisiones_model->getPlanesComisiones();
      }else{
        $data = $this->Comisiones_model->getPlanesComisiones($val);
      }
      
      if ($data != null) {
        echo json_encode($data);
      } else {
        echo json_encode(array());
      }
    }
    
  public function updateBandera(){
    $response = $this->Comisiones_model->updateBandera( $_POST['id_pagoc'], $_POST['param']);
    echo json_encode($response);
  }

  public function activas() {
    if ($this->session->userdata('id_rol') == FALSE)
    redirect(base_url());
    $datos["controversias"] = $this->Comisiones_model->getMotivosControversia();
    $this->load->view('template/header');
    $this->load->view("comisiones/activas-view", $datos);
  }

  public function getDataActivasPago() {
    $data['data'] = $this->Comisiones_model->getDataActivasPago()->result_array();
    echo json_encode($data);
  }

  public function liquidadas() {
    if ($this->session->userdata('id_rol') == FALSE)
    redirect(base_url());
    $this->load->view('template/header');
    $this->load->view("comisiones/liquidadas-view");
  }

  public function getDataLiquidadasPago() {
    $data['data'] = $this->Comisiones_model->getDataLiquidadasPago()->result_array();
    echo json_encode($data);
  }

  public function especiales() {
    if ($this->session->userdata('id_rol') == FALSE)
    redirect(base_url());
    $datos["controversias"] = $this->Comisiones_model->getMotivosControversia();
    $this->load->view('template/header');
    $this->load->view("comisiones/especiales-view",$datos);
  }

  public function getDataDispersionPagoEspecial() {
    $data['data'] = $this->Comisiones_model->getDataDispersionPagoEspecial()->result_array();
    echo json_encode($data);
  }
 
  
  // dispersion-view complete-end

  public function usuariosIncidencias()
  {
    $this->load->view('template/header');
    $this->load->view("ventas/usuariosIncidencias");
  }



  
  public function getDataDispersionPago2()
  {
    $datos = array();
    $datos = $this->Comisiones_model->getDataDispersionPago2();
    if ($datos != null) {
      echo json_encode($datos);
    } else {
      echo json_encode(array());
    }
  }

  

  public function enganche_comision()
  {
    $respuesta = array(FALSE);
    if ($this->input->post("ideLotenganche")) {
      $ideLotep = $this->input->post("ideLotenganche");
      $selectOption = $this->input->post("planSelect");
      $respuesta = $this->Comisiones_model->update_enganche_comision($ideLotep, $selectOption);
    }
    echo json_encode($respuesta);
  }

  public function getPlanesEnganche($idLote)
  {
    echo json_encode($this->Comisiones_model->getPlanesEnganche($idLote)->result_array());
  }


  public function getValNeodata($param)
  {
    echo json_encode($this->Comisiones_model->getValNeodata($param)->result_array());
  }
  // ------------------------------------------------------****************----------------------------------------


  // ------------------------------------------------------PASO 1 CONTRALORIA----------------------------------------
 
  // ------------------------------------------------------****************----------------------------------------


  // ------------------------------------------------------CONFIRMAR PAGO CONTRALORIA----------------------------------------
  public function confirmar_pago()
  {
    $this->load->view('template/header');
    $this->load->view("ventas/confirmar_pago");
  }

  public function getDatosConfirmarPago()
  {
    $datos = array();
    $datos = $this->Comisiones_model->getDatosConfirmarPago();
    if ($datos != null) {
      echo json_encode($datos);
    } else {
      echo json_encode(array());
    }
  }


  public function setConfirmarPago()
  {
    $respuesta = array(FALSE);
    if ($this->input->post("idPagoInd")) {
      $idPagoInd = $this->input->post("idPagoInd");
      $respuesta = $this->Comisiones_model->setConfirmarPago($idPagoInd);
    }
    echo json_encode($respuesta);
  }


  // ------------------------------------------------------****************----------------------------------------


    // ------------------------------------------------------CONFIRMAR PAGO CONTRALORIA----------------------------------------
    public function revision_cobranza()
    {
      $this->load->view('template/header');
      $this->load->view("ventas/revision_cobranza_mktd");
    }
  
 
    public function getDatosNuevasMktd_pre(){
      $dat =  $this->Comisiones_model->getDatosNuevasMktd_pre()->result_array();
     for( $i = 0; $i < count($dat); $i++ ){
         $dat[$i]['pa'] = 0;
     }
     echo json_encode( array( "data" => $dat));
    }
    public function insertar_codigo_postal(){
      $cp = $this->input->post('cp');
      $nuevoCp = $this->input->post('nuevoCp');
      $respuesta = $this->Comisiones_model->insertar_codigo_postal($cp, $nuevoCp);
    }

    public function consulta_codigo_postal(){
      $resolt = $this->Comisiones_model->consulta_codigo_postal($this->session->userdata('id_usuario'))->result_array();
      echo json_encode($resolt);
    }

    public function pagos_codigo_postal(){
      $respuesta = $this->Comisiones_model->pagos_codigo_postal($this->session->userdata('id_usuario'))->result_array();
      echo json_encode($respuesta);
    }
    
    function aprobar_comision(){
      $id_pago= $_POST['id_pago'];
      $id_comision = $_POST['id_comision'];
      $precio_lote = $_POST['precio_lote'];
      $id_lote = $_POST['id_lote'];
 

      $validar = $this->Comisiones_model->validar_precio_agregado($id_lote);

      if($validar == 1){
        echo json_encode($this->Comisiones_model->aprobar_comision($id_pago, $id_comision, $id_lote, $precio_lote, 1));
      }
      else if($validar == 2){
        echo json_encode($this->Comisiones_model->aprobar_comision($id_pago, $id_comision, $id_lote, $precio_lote, 2));
      }

    }
  
    public function getDatosRevisionAsimilados($proyecto,$condominio){
      $dat =  $this->Comisiones_model->getDatosRevisionAsimilados($proyecto,$condominio)->result_array();
     for( $i = 0; $i < count($dat); $i++ ){
         $dat[$i]['pa'] = 0;
     }
     echo json_encode( array( "data" => $dat));
    }
    
    public function getReporteEmpresa(){
      echo json_encode($this->Comisiones_model->report_empresa()->result_array());
  }
  
  
    public function revision_factura()
    {

      switch($this->session->userdata('id_rol')){
        case '31':
        $this->load->view('template/header');
        $this->load->view("ventas/revision_INTMEXfactura");
        break;

        default:
        $this->load->view('template/header');
        $this->load->view("ventas/revision_factura");
        break;
      }

    }
 
    public function getDatosRevisionFactura($proyecto,$condominio){
      $dat =  $this->Comisiones_model->getDatosRevisionFactura($proyecto,$condominio)->result_array();
     for( $i = 0; $i < count($dat); $i++ ){
         $dat[$i]['pa'] = 0;
     }
     echo json_encode( array( "data" => $dat));
    }
  



        public function enviadas_cobranza()
    {
      $this->load->view('template/header');
      $this->load->view("ventas/enviadas_cobranza");
    }

    
    // ------------------------------------------------------****************----------------------------------------
  

  // ------------------------------------------------------HISTORIAL GENERAL CONTRALORIA----------------------------------------
  public function historial_comisiones()
  {
    $this->load->view('template/header');

     switch($this->session->userdata('id_rol')){
      case '28':
      case '18':
      $this->load->view('template/header');
      $this->load->view("ventas/historial_Marketing");
      break;
      default:
      $this->load->view('template/header');
      $this->load->view("ventas/historial_contraloria");
      break;
    }
  }
  
  public function acepto_internomex_factura(){
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
              'comentario' =>  'CONTRALORÍA ENVÍO PAGO A INTERNOMEX' 
            );
             array_push($data,$row_arr);


          }
          $id_pago_i = rtrim($id_pago_i, $sep);
      
            $up_b = $this->Comisiones_model->update_acepta_contraloria($id_pago_i);
            $ins_b = $this->Comisiones_model->insert_phc($data);
      
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
 


function enviar_solicitud(){
  $respuesta = array( FALSE );
  if($this->input->post("id_usuario")){
     $respuesta = array( $this->Comisiones_model->update_estatus_facturas( $this->input->post("id_usuario"), $this->input->post("id_residencial")));
  }
  echo json_encode( $respuesta );
}

function despausar_solicitud(){
  $respuesta = array( FALSE );
  // <input type="hidden" name="value_pago" value="2">
  if($this->input->post("value_pago")){
    $validate = $this->input->post("value_pago");

    switch($validate){
      case 1:
        $respuesta = array($this->Comisiones_model->update_estatus_pausa($this->input->post("id_pago_i"), $this->input->post("observaciones"), $this->input->post("estatus") ));
        break;

        case 2:
        $respuesta = array($this->Comisiones_model->update_estatus_despausa($this->input->post("id_pago_i"), $this->input->post("observaciones"), $this->input->post("estatus")));
        break;

        case 3:

        $validate =  $this->db->query("SELECT registro_comision from lotes l where l.idLote in (select c.id_lote from comisiones c WHERE c.id_comision IN (SELECT p.id_comision FROM pago_comision_ind p WHERE p.id_pago_i = ".$this->input->post("id_pago_i")."))");

        // echo $validate->row()->registro_comision.' *COMISION'.$validate->row()->registro_comision;
        if($validate->row()->registro_comision == 7){
          $respuesta = FALSE;
           // echo 'no entra';
        }else{
          // echo 'si entra';
         $respuesta = array($this->Comisiones_model->update_estatus_edit($this->input->post("id_pago_i"), $this->input->post("observaciones")));
       }
        break;
    }  
  }
  echo json_encode( $respuesta );
}


function borrar_factura(){
  $respuesta = array( FALSE );
  if($this->input->post("delete_fact")){
     $respuesta = array( $this->Comisiones_model->borrar_factura( $this->input->post("delete_fact")));
  }
  echo json_encode( $respuesta );
}

function refresh_solicitud(){
  $respuesta = array( FALSE );
  if($this->input->post("id_pago_i")){
     $respuesta = array( $this->Comisiones_model->update_estatus_refresh( $this->input->post("id_pago_i")));
  }
  echo json_encode( $respuesta );
}

function update_estatus(){
  $respuesta = array( FALSE );
  if($this->input->post("motivo_change")){
    $desc_01 = $this->input->post("motivo_change");
    $select_01 = $this->input->post("RegresoSelect");
    $pago_01 = $this->input->post("PagoRechazo");
     $respuesta = array( $this->Comisiones_model->update_estatus_coorporativa($desc_01 , $select_01 , $pago_01 ));
  }
  echo json_encode( $respuesta );
}

  // ------------------------------------------------------****************----------------------------------------


  // ------------------------------------------------------ABONO TEMPORAL CONTRALORIA----------------------------------------
  public function dispersion_com_contraloria()
  {
    $this->load->view('template/header');
    $this->load->view("ventas/dispersion_contraloria");
  }
  // ------------------------------------------------------****************----------------------------------------


  // ------------------------------------------------------SOLICITUDES ASESOR ----------------------------------------
  public function comisiones_colaborador()
  {
    $id_user = $this->session->userdata('id_usuario');
    $datos = array();
    $datos["opn_cumplimiento"] = $this->Usuarios_modelo->Opn_cumplimiento($this->session->userdata('id_usuario'))->result_array();
    $this->load->view('template/header');
    switch($this->session->userdata('id_rol')){
      case '1':
      case '2':
        $this->session->userdata('tipo') == 1 ? $this->load->view("ventas/comisiones_colaboradorRigel", $datos) : $this->load->view("ventas/comisiones_colaborador", $datos);
      break;
      default:
      $this->load->view("ventas/comisiones_colaborador", $datos);
      break;
    }
  }


  public function getDatosComisionesRigel($proyecto,$condominio,$estado)
  {
    $dat =  $this->Comisiones_model->getDatosComisionesRigel($proyecto,$condominio,$estado)->result_array();
    echo json_encode(array("data" => $dat));
  }

  public function asesores_baja()
  {
    $this->load->view('template/header');
    $this->load->view("ventas/comisiones_colaborador_externo");
  }

  public function getDatosFactura($uuid, $id_res){
    if($uuid){
         $consulta_sol = $this->Comisiones_model->factura_comision($uuid, $id_res)->row();
         if (!empty($consulta_sol)) {
            $datos['datos_solicitud'] = $this->Comisiones_model->factura_comision($uuid, $id_res)->row(); 
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

  public function getDatosComisionesAsesor($a)
  {
    $dat =  $this->Comisiones_model->getDatosComisionesAsesor($a)->result_array();
    for ($i = 0; $i < count($dat); $i++) {
      $dat[$i]['pa'] = 0;
    }
    echo json_encode(array("data" => $dat));
  }

  public function getDatosComisionesAsesorBaja($a)
  {
    $dat =  $this->Comisiones_model->getDatosComisionesAsesorBaja($a)->result_array();
    for ($i = 0; $i < count($dat); $i++) {
      $dat[$i]['pa'] = 0;
    }
    echo json_encode(array("data" => $dat));
  }

  public function getDatosComisionesHistorial()
  {
    $dat =  $this->Comisiones_model->getDatosComisionesHistorial()->result_array();
    echo json_encode(array("data" => $dat));
  }

  public function acepto_comisiones_user(){
    $this->load->model("Comisiones_model");
    $id_user_Vl = $this->session->userdata('id_usuario');
    $formaPagoUsuario = $this->session->userdata('forma_pago');
    $sol=$this->input->post('idcomision');  
    $consulta_comisiones = $this->db->query("SELECT id_pago_i FROM pago_comision_ind where id_pago_i IN (".$sol.")");
    $opinionCumplimiento = $this->Comisiones_model->findOpinionActiveByIdUsuario($id_user_Vl);
    $mesActual = $this->db->query("SELECT MONTH(GETDATE()) AS mesActual")->row()->mesActual;
    $consultaFechasCorte = $this->db->query("SELECT * FROM fechasCorte WHERE mes=$mesActual")->result_array();
    $obtenerFechaSql = $this->db->query("select FORMAT(CAST(FORMAT(SYSDATETIME(), N'yyyy-MM-dd HH:mm:ss') AS datetime2), N'yyyy-MM-dd HH:mm:ss') as sysdatetime")->row()->sysdatetime;
    if( $consulta_comisiones->num_rows() > 0 ){
      $validar_sede = $this->session->userdata('id_sede');
      $fecha_actual = strtotime($obtenerFechaSql);
      $fechaInicio = strtotime($consultaFechasCorte[0]['fechaInicio']);
      $fechaFin = $validar_sede == 8 ? strtotime($consultaFechasCorte[0]['fechaTijuana']) : strtotime($consultaFechasCorte[0]['fechaFinGeneral']) ;
        if($formaPagoUsuario == 3){
          $consultaCP = $this->Comisiones_model->consulta_codigo_postal($id_user_Vl)->result_array();
        }

        if(($fecha_actual >= $fechaInicio && $fecha_actual <= $fechaFin) || ($id_user_Vl == 7689)){
          if( $formaPagoUsuario == 3 && ( $this->input->post('cp') == '' || $this->input->post('cp') == 'undefined' ) ){
            $data_response = 3;
            echo json_encode($data_response);
          }
          else if( $formaPagoUsuario == 3 && ( $this->input->post('cp') != '' || $this->input->post('cp') != 'undefined' ) &&  $consultaCP[0]['estatus'] == 0 ){
            $data_response = 4;
            echo json_encode($data_response);
          }
          else{
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
            $up_b = $this->Comisiones_model->update_acepta_solicitante($id_pago_i);
            $ins_b = $this->Comisiones_model->insert_phc($data);
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
      }
      else{
        $data_response = 0;
      echo json_encode($data_response);
      }
  }
 
  public function acepto_comisiones_resguardo(){
 
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
              'comentario' =>  'ENVÍO A SU RESGUARDO PERSONAL' 
            );
             array_push($data,$row_arr);


          }
          $id_pago_i = rtrim($id_pago_i, $sep);
      
            $up_b = $this->Comisiones_model->update_acepta_resguardo($id_pago_i);
            $ins_b = $this->Comisiones_model->insert_phc($data);
      
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
              'comentario' =>  'CONTRALORÍA ENVÍO PAGO A INTERNOMEX' 
            );
             array_push($data,$row_arr);


          }
          $id_pago_i = rtrim($id_pago_i, $sep);
      
            $up_b = $this->Comisiones_model->update_acepta_contraloria($id_pago_i);
            $ins_b = $this->Comisiones_model->insert_phc($data);
      
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
      
            $up_b = $this->Comisiones_model->update_contraloria_especial($id_pago_i);
            $ins_b = $this->Comisiones_model->insert_phc($data);
      
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

    public function pago_internomex(){
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
              'comentario' =>  'INTERNOMEX APLICÓ PAGO' 
            );
             array_push($data,$row_arr);


          }
          $id_pago_i = rtrim($id_pago_i, $sep);
      
            $up_b = $this->Comisiones_model->update_acepta_INTMEX($id_pago_i);
            $ins_b = $this->Comisiones_model->insert_phc($data);
      
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


    public function despausar_historial(){
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
              'comentario' =>  'CONTRALORÍA REGRESÓ A NUEVAS' 
            );
             array_push($data,$row_arr);


          }
          $id_pago_i = rtrim($id_pago_i, $sep);
      
            $up_b = $this->Comisiones_model->update_acepta_PAUSADA($id_pago_i);
            $ins_b = $this->Comisiones_model->insert_phc($data);
      
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

  public function acepto_comisiones_contra(){
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
              'comentario' =>  'CONTRALORÍA SOLICITO PAGO DE USUARIO BAJA' 
            );
             array_push($data,$row_arr);


          }
          $id_pago_i = rtrim($id_pago_i, $sep);
      
            $up_b = $this->Comisiones_model->update_acepta_solicitante($id_pago_i);
            $ins_b = $this->Comisiones_model->insert_phc($data);
      
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

 

  public function acepto_comisiones_usermktd_dos($sol){
    $this->load->model("Comisiones_model");   
     $consulta_comisiones = $this->db->query("SELECT id_pago_mk FROM pago_comision_mktd where id_pago_mk IN (".$sol.")");
   
      if( $consulta_comisiones->num_rows() > 0 ){
        $consulta_comisiones = $consulta_comisiones->result_array();
  
        $id_user_Vl = $this->session->userdata('id_usuario');
  
    for( $i = 0; $i < count($consulta_comisiones ); $i++){
           $this->Comisiones_model->update_acepta_solicitante_mk($consulta_comisiones[$i]['id_pago_mk']);
  
           $this->db->query("INSERT INTO historial_com_mktd VALUES (".$consulta_comisiones[$i]['id_pago_mk'].", ".$id_user_Vl.", GETDATE(), 1, 'COLABORADOR ENVÍO A CONTRALORÍA')");
           $this->db->query("UPDATE pago_comision_mktd SET fecha_pago_intmex = GETDATE() WHERE id_pago_mk = ".$consulta_comisiones[$i]['id_pago_mk']."");
        }
      }
      else{
        $consulta_comisiones = array();
      }
  } 
  
  public function getDesarrolloSelect($a = ''){

    $validar_user = $this->session->userdata('id_usuario');
    $validar_sede = $this->session->userdata('id_sede');
    $mesActual = $this->db->query("SELECT MONTH(GETDATE()) AS mesActual")->row()->mesActual;
    $consultaFechasCorte = $this->db->query("SELECT * FROM fechasCorte WHERE mes=$mesActual")->result_array();
    $obtenerFechaSql = $this->db->query("select FORMAT(CAST(FORMAT(SYSDATETIME(), N'yyyy-MM-dd HH:mm:ss') AS datetime2), N'yyyy-MM-dd HH:mm:ss') as sysdatetime")->row()->sysdatetime;   
    $fecha_actual = strtotime($obtenerFechaSql);
    $fechaInicio = strtotime($consultaFechasCorte[0]['fechaInicio']);
    $fechaFin = $validar_sede == 8 ? strtotime($consultaFechasCorte[0]['fechaTijuana']) : strtotime($consultaFechasCorte[0]['fechaFinGeneral']) ;
      //fecha inicio
      if(($fecha_actual >= $fechaInicio && $fecha_actual <= $fechaFin))
          {
            if($a == ''){
              echo json_encode($this->Comisiones_model->getDesarrolloSelect()->result_array());

            }else{
              echo json_encode($this->Comisiones_model->getDesarrolloSelect($a)->result_array());

            }
          }else{
            echo json_encode(3);
          }
  }

  function getDatosProyecto($idlote,$id_usuario = ''){
    if($id_usuario == ''){
      echo json_encode($this->Comisiones_model->getDatosProyecto($idlote)->result_array());

    }else{
      echo json_encode($this->Comisiones_model->getDatosProyecto($idlote,$id_usuario)->result_array());

    }
  }


  public function historial_colaborador()
  {
    $this->load->view('template/header');
      $this->load->view("ventas/historial_contraloria");    
  }


    public function historial_baja()
  {
    $this->load->view('template/header');
    $this->load->view("ventas/historial_comisiones_Baja");
  }


  public function getDatosComisionesHistorialRigel($proyecto,$condominio)
  {
    $dat =  $this->Comisiones_model->getDatosComisionesHistorialRigel($proyecto,$condominio)->result_array();
    echo json_encode(array("data" => $dat));
  }

  public function getDatosComisionesHistorialBaja($proyecto,$condominio)
  {
    $dat =  $this->Comisiones_model->getDatosComisionesHistorialBaja($proyecto,$condominio)->result_array();
    echo json_encode(array("data" => $dat));
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
        $datos_xml = $this->Comisiones_model->leerxml( $xml_subido, TRUE );
        if( $datos_xml['version'] >= 3.3){
          $responsable_factura = $this->Comisiones_model->verificar_uuid( $datos_xml['uuidV'] );
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
              $datos_xml = $this->Comisiones_model->leerxml( $xml_subido['full_path'], TRUE );
              $nuevo_nombre = date("my")."_";
              $nuevo_nombre .= str_replace( array(",", ".", '"'), "", str_replace( array(" ", "/"), "_", limpiar_dato($datos_xml["nameEmisor"]) ))."_";
              $nuevo_nombre .= date("Hms")."_";
              $nuevo_nombre .= rand(4, 100)."_";
              $nuevo_nombre .= substr($datos_xml["uuidV"], -5).".xml";
              rename( $xml_subido['full_path'], "./UPLOADS/XMLS/".$nuevo_nombre );
              $datos_xml['nombre_xml'] = $nuevo_nombre;
              $id_com = $id_comision;
              $this->Comisiones_model->insertar_factura($id_com, $datos_xml);
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


    public function guardar_solicitud2($usuario = ''){
      $validar_user = $this->session->userdata('id_usuario');
      $validar_sede =   $usuarioid =$this->session->userdata('id_sede');
      $mesActual = $this->db->query("SELECT MONTH(GETDATE()) AS mesActual")->row()->mesActual;
      $consultaFechasCorte = $this->db->query("SELECT * FROM fechasCorte WHERE mes=$mesActual")->result_array();
      $obtenerFechaSql = $this->db->query("select FORMAT(CAST(FORMAT(SYSDATETIME(), N'yyyy-MM-dd HH:mm:ss') AS datetime2), N'yyyy-MM-dd HH:mm:ss') as sysdatetime")->row()->sysdatetime;   
      $fecha_actual = strtotime($obtenerFechaSql);
      $fechaInicio = strtotime($consultaFechasCorte[0]['fechaInicio']);
      $fechaFin = $validar_sede == 8 ? strtotime($consultaFechasCorte[0]['fechaTijuana']) : strtotime($consultaFechasCorte[0]['fechaFinGeneral']) ;

      if(($fecha_actual >= $fechaInicio && $fecha_actual <= $fechaFin) )
      {

      
      if($usuario != ''){
        $usuarioid = $usuario;
      }else{
        $usuarioid =$this->session->userdata('id_usuario');
      }
     // $datos = explode(",",$pagos);
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
            $datos_xml = $this->Comisiones_model->leerxml( $xml_subido['full_path'], TRUE );

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
                  $this->Comisiones_model->insertar_factura($id_com, $datos_xml,$usuarioid);
                  $this->Comisiones_model->update_acepta_solicitante($id_com);
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

      public function getComments($pago){
        echo json_encode($this->Comisiones_model->getComments($pago)->result_array());
    }


    public function getCommentsDU($user){
        echo json_encode($this->Comisiones_model->getCommentsDU($user)->result_array());
    }
    
    public function getDataMarketing($lote, $cliente){
        echo json_encode($this->Comisiones_model->getDataMarketing($lote, $cliente)->result_array());
    }


  // ------------------------------------------------------****************----------------------------------------
  
  
  // ------------------------------------------DISPERSION MARKETING DIGITAL ----------------------------------------
  public function dispersion_mktd()
  {
    $this->load->view('template/header');
    $this->load->view("ventas/comisiones_dispersion_mktd");
  }

  
  public function getDatosNuevasMktd(){
    $dat =  $this->Comisiones_model->getDatosNuevasMktd()->result_array();
   for( $i = 0; $i < count($dat); $i++ ){
       $dat[$i]['pa'] = 0;
   }
   echo json_encode( array( "data" => $dat));
  }
  
  public function getDatosNuevasMktd2(){
    $dat =  $this->Comisiones_model->getDatosNuevasMktd2()->result_array();
   for( $i = 0; $i < count($dat); $i++ ){
       $dat[$i]['pa'] = 0;
   }
   echo json_encode( array( "data" => $dat));
  }

  public function getDatosPlanesMktd(){
    $dat =  $this->Comisiones_model->getDatosPlanesMktd()->result_array();
    echo json_encode( array( "data" => $dat));
  }

  function getDatosColabMktd($sede, $plan){
    echo json_encode($this->Comisiones_model->getDatosColabMktd($sede, $plan)->result_array());
  }

  function getDatosSumaMktd($sede, $plen, $empresa, $res){
    echo json_encode($this->Comisiones_model->getDatosSumaMktd($sede, $plen, $empresa, $res)->result_array());
  }

    function getDatosSumaMktdComp($sede, $plen, $empresa, $s1, $s2){
    echo json_encode($this->Comisiones_model->getDatosSumaMktdComp($sede, $plen, $empresa, $s1, $s2)->result_array());
  }

  
  function getDatosColabMktd2($sede, $lote){
    echo json_encode($this->Comisiones_model->getDatosColabMktd2($sede, $lote)->result_array());
  }

  function getDatosUsersMktd($val){
    echo json_encode($this->Comisiones_model->getDatosUsersMktd($val)->result_array());
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
      $respuesta =  $this->Comisiones_model->nueva_mktd_comision($values_send,$id_usuario[$i],$abono_mktd[$i],$pago_mktd,$this->session->userdata('id_usuario'), $num_plan,$empresa);
      }
    }

     for($i=0;$i<sizeof($array_up);$i++){
      $respuesta =  $this->Comisiones_model->updatePagoInd($array_up[$i]);
      // echo $array_up[$i];
     }
    

     
  echo json_encode($respuesta);
  }
  
  // ------------------------------------------------------****************----------------------------------------

// ------------------------------------------DISPERSION MARKETING DIGITAL ----------------------------------------
public function dispersion_club()
{
  $this->load->view('template/header');
  $this->load->view("ventas/comisiones_dispersion_club");
}


public function getDatosNuevasSNL(){
  $dat =  $this->Comisiones_model->getDatosNuevasSNL()->result_array();
 for( $i = 0; $i < count($dat); $i++ ){
     $dat[$i]['pa'] = 0;
 }
 echo json_encode( array( "data" => $dat));
}
public function getDatosNuevasQro(){
  $dat =  $this->Comisiones_model->getDatosNuevasQro()->result_array();
 for( $i = 0; $i < count($dat); $i++ ){
     $dat[$i]['pa'] = 0;
 }
 echo json_encode( array( "data" => $dat));
}

public function getDatosNuevasPen(){
  $dat =  $this->Comisiones_model->getDatosNuevasPen()->result_array();
 for( $i = 0; $i < count($dat); $i++ ){
     $dat[$i]['pa'] = 0;
 }
 echo json_encode( array( "data" => $dat));
}

public function getDatosNuevasCDMX(){
  $dat =  $this->Comisiones_model->getDatosNuevasCDMX()->result_array();
 for( $i = 0; $i < count($dat); $i++ ){
     $dat[$i]['pa'] = 0;
 }
 echo json_encode( array( "data" => $dat));
}
public function getDatosNuevasLeon(){
  $dat =  $this->Comisiones_model->getDatosNuevasLeon()->result_array();
 for( $i = 0; $i < count($dat); $i++ ){
     $dat[$i]['pa'] = 0;
 }
 echo json_encode( array( "data" => $dat));
}
public function getDatosNuevasCan(){
  $dat =  $this->Comisiones_model->getDatosNuevasCan()->result_array();
 for( $i = 0; $i < count($dat); $i++ ){
     $dat[$i]['pa'] = 0;
 }
 echo json_encode( array( "data" => $dat));
}

public function getDatosPlanesClub(){
  $dat =  $this->Comisiones_model->getDatosPlanesClub()->result_array();
  echo json_encode( array( "data" => $dat));
}

function getDatosUsersClub($val){
  echo json_encode($this->Comisiones_model->getDatosUsersClub($val)->result_array());
}

function getDatosColabClub($sede, $lote){
  
  echo json_encode($this->Comisiones_model->getDatosColabClub($sede, $lote)->result_array());
}


public function nueva_club_comision(){
  $respuesta = "";
  /*------USUARIO PARA BONOS---------------------*/
  $userclub = $this->input->post("userclub");
  $abono_clubEje = $this->input->post("abono_clubEje");

   $userClubCoA = $this->input->post("userCoA");
 $abonoClubCoA = $this->input->post("abono_clubCoA");

  $pago_id = $this->input->post("pago_id");
  $com_value = $this->input->post("com_value");
  $abono_mktd = $this->input->post("abono_mktd[]");
  $pago_club = $this->input->post("pago_club");
  $id_usuario = $this->input->post("user_mktd[]");
  $respuesta =  $this->Comisiones_model->nueva_club_comision($com_value,$userClubCoA,$abonoClubCoA,$pago_club,$this->session->userdata('id_usuario'));

  $respuesta =  $this->Comisiones_model->nueva_club_comision($com_value,$userclub,$abono_clubEje,$pago_club,$this->session->userdata('id_usuario'));

  for($i=0;$i<sizeof($abono_mktd);$i++){
    $respuesta =  $this->Comisiones_model->nueva_club_comision($com_value,$id_usuario[$i],$abono_mktd[$i],$pago_club,$this->session->userdata('id_usuario'));
  }
  $respuesta =  $this->Comisiones_model->updatePagoInd($pago_id);
echo json_encode($respuesta);
}



public function bonos_club()
{
  $this->load->view('template/header');
  $this->load->view("ventas/bonos_club");
}

public function getDatosComisionesNuevas_dos_bonos($proyecto, $condominio){
  $dat =  $this->Comisiones_model->getDatosComisionesNuevas_dos_bonos($proyecto, $condominio)->result_array();
 for( $i = 0; $i < count($dat); $i++ ){
     $dat[$i]['pa'] = 0;
 }
 echo json_encode( array( "data" => $dat));
}

 
public function getDatosComisionesNuevasNivel2()
{
  $dat =  $this->Comisiones_model->getDatosComisionesNuevasNivel2()->result_array();
  for ($i = 0; $i < count($dat); $i++) {
    $dat[$i]['pa'] = 0;
  }
  echo json_encode(array("data" => $dat));
}

public function getDatosComisionesRecibidasNivel2()
{
  $dat =  $this->Comisiones_model->getDatosComisionesRecibidasNivel2()->result_array();
  for ($i = 0; $i < count($dat); $i++) {
    $dat[$i]['pa'] = 0;
  }
  echo json_encode(array("data" => $dat));
}


public function insertar_gph_maderas_new(){
  $dat =  $this->Comisiones_model->insertar_gph_maderas_new();
 echo json_encode($dat);
}
  // ------------------------------------------------------****************----------------------------------------



// ------------------------------------------ABONO TEMPORAL CONTRALORIA ----------------------------------------
public function getDatosComisionesDispersarContraloria(){
  $dat =  $this->Comisiones_model->getDatosComisionesDispersarContraloria()->result_array();
  echo json_encode( array( "data" => $dat));
}

public function getDirector(){
    echo json_encode($this->Comisiones_model->getDirector()->result_array());
}
public function getsubDirector(){
    echo json_encode($this->Comisiones_model->getsubDirector()->result_array());
}
public function getGerente(){
    echo json_encode($this->Comisiones_model->getGerenteT()->result_array());
}
public function getCoordinador(){
    echo json_encode($this->Comisiones_model->getCoordinador()->result_array());
}
public function getAsesor(){
    echo json_encode($this->Comisiones_model->getAsesor()->result_array());
}
public function getMktd(){
  echo json_encode($this->Comisiones_model->getMktd()->result_array());
}
public function getEjectClub(){
echo json_encode($this->Comisiones_model->getEjectClub()->result_array());
}
public function getSubClub(){
echo json_encode($this->Comisiones_model->getSubClub()->result_array());
}
public function getGreen(){
echo json_encode($this->Comisiones_model->getGreen()->result_array());
}
public function getsubDirector2(){
  echo json_encode($this->Comisiones_model->getsubDirector2()->result_array());
}
public function getGerente2(){
  echo json_encode($this->Comisiones_model->getGerente2T()->result_array());
}
public function getCoordinador2(){
  echo json_encode($this->Comisiones_model->getCoordinador2()->result_array());
}
public function getAsesor2(){
  echo json_encode($this->Comisiones_model->getAsesor2()->result_array());
}
public function getsubDirector3(){
echo json_encode($this->Comisiones_model->getsubDirector3()->result_array());
}
public function getGerente3(){
echo json_encode($this->Comisiones_model->getGerente3T()->result_array());
}
public function getCoordinador3(){
echo json_encode($this->Comisiones_model->getCoordinador3()->result_array());
}
public function getAsesor3(){
echo json_encode($this->Comisiones_model->getAsesor3()->result_array());
}
public function getUserMk(){
echo json_encode($this->Comisiones_model->getUserMk()->result_array());
}
public function getPlazasMk(){
echo json_encode($this->Comisiones_model->getPlazasMk()->result_array());
}
public function getSedeMk(){
echo json_encode($this->Comisiones_model->getSedeMk()->result_array());
}

public function agregar_precioNeto(){

 $respuesta = array( FALSE );
 if($this->input->post("lote")){
  $new_total =  $this->input->post("precio_Neto");
  $new_lote =  $this->input->post("lote");
  $respuesta = array($this->Comisiones_model->update_precio($new_total, $new_lote));
}
echo json_encode( $respuesta );
}

public function agregar_pago(){
  
 $respuesta = array( FALSE );

 if($this->input->post("idComision")){
   
   $comision = $this->input->post("idComision");
   $user = $this->input->post("idUsuario");
   $monto = $this->input->post("montodisponible");

   $respuesta = $this->Comisiones_model->insert_nuevo_pago($comision,$user,$monto);
}
echo json_encode( $respuesta );
}


public function liquidar_comision(){
  
 $respuesta = array( FALSE );
 if($this->input->post("ideLotep")){
   $ideLotep = $this->input->post("ideLotep");
   $estatus = $this->input->post("estatusL");
   if($estatus == 7){
    $estado=7;
    $comentario='SE MARCÓ COMO PAGADO '.$ideLotep;
   }else{
    $comentarioPago = $this->input->post("Motivo");
    $estado=8;
    $comentario='SE PAUSÓ '.$ideLotep;
   }
   $respuesta = $this->Comisiones_model->update_pagada_comision($ideLotep,$estado,$comentario,$comentarioPago);
}
echo json_encode( $respuesta );
}


function getDatosDispersar($idlote){
  echo json_encode($this->Comisiones_model->getDatosDispersar($idlote)->result_array());
}


public function agregar_comision(){

  $replace = ["$", ","];

     $respuesta = array( FALSE );
     if($this->input->post("precioLote")){

      $precioLote = $this->input->post("precioLote");
      $ideLote = $this->input->post("ideLote");
      $directorSelect = $this->input->post("directorSelect");
      $porcentajeDir = $this->input->post("porcentajeDir");
      $abonadoDir = str_replace($replace,"",$this->input->post("abonadoDir"));
      $pendienteDir = str_replace($replace,"",$this->input->post("pendienteDir"));
      $totalDir = str_replace($replace,"",$this->input->post("totalDir"));

      $subdirectorSelect = $this->input->post("subdirectorSelect");
      $porcentajesubDir = $this->input->post("porcentajesubDir");
      $abonadosubDir = str_replace($replace,"",$this->input->post("abonadosubDir"));
      $pendientesubDir = str_replace($replace,"",$this->input->post("pendientesubDir"));
      $totalsubDir = str_replace($replace,"",$this->input->post("totalsubDir"));

      $gerenteSelect = $this->input->post("gerenteSelect");
      $porcentajeGerente = $this->input->post("porcentajeGerente");
      $abonadoGerente = str_replace($replace,"",$this->input->post("abonadoGerente"));
      $pendienteGerente = str_replace($replace,"",$this->input->post("pendienteGerente"));
      $totalGerente = str_replace($replace,"",$this->input->post("totalGerente"));

      $coordinadorSelect = $this->input->post("coordinadorSelect");
      $porcentajeCoordinador = $this->input->post("porcentajeCoordinador");
      
      $asesorSelect = $this->input->post("asesorSelect");
      $porcentajeAsesor = $this->input->post("porcentajeAsesor");
      $abonadoAsesor = str_replace($replace,"",$this->input->post("abonadoAsesor"));
      $pendienteAsesor = str_replace($replace,"",$this->input->post("pendienteAsesor"));
      $totalAsesor = str_replace($replace,"",$this->input->post("totalAsesor"));
      ////////////////////////////////////
      $MKTDSelect = $this->input->post("MKTDSelect");
      $porcentajeMKTD = $this->input->post("porcentajeMKTD");
      $abonadoMKTD = str_replace($replace,"",$this->input->post("abonadoMKTD"));
      $pendienteMKTD = str_replace($replace,"",$this->input->post("pendienteMKTD"));
      $totalMKTD = str_replace($replace,"",$this->input->post("totalMKTD"));

      $SubClubSelect = $this->input->post("SubClubSelect");
      $porcentajeSubClub = $this->input->post("porcentajeSubClub");
      $abonadoSubClub = str_replace($replace,"",$this->input->post("abonadoSubClub"));
      $pendienteSubClub = str_replace($replace,"",$this->input->post("pendienteSubClub"));
      $totalSubClub = str_replace($replace,"",$this->input->post("totalSubClub"));

      $EjectClubSelect = $this->input->post("EjectClubSelect");
      $porcentajeEjectClub = $this->input->post("porcentajeEjectClub");
      $abonadoEjectClub = str_replace($replace,"",$this->input->post("abonadoEjectClub"));
      $pendienteEjectClub = str_replace($replace,"",$this->input->post("pendienteEjectClub"));
      $totalEjectClub = str_replace($replace,"",$this->input->post("totalEjectClub"));

      $GreenSelect = $this->input->post("GreenSelect");
      $porcentajeGreenham = $this->input->post("porcentajeGreenham");
      $abonadoGreenham = str_replace($replace,"",$this->input->post("abonadoGreenham"));
      $pendienteGreenham = str_replace($replace,"",$this->input->post("pendienteGreenham"));
      $totalGreenham = str_replace($replace,"",$this->input->post("totalGreenham"));

      ////////////////////////////////////

      $referencia = $this->input->post("referencia");
      $idDesarrollo = $this->input->post("idDesarrollo");

      if($directorSelect==''||$directorSelect=='undefinded' || $directorSelect ==0 || $directorSelect==null){
        $respuesta = array( TRUE );
      }
      else{
        $respuesta = array($this->Comisiones_model->update_comisionesDir($ideLote, $directorSelect, $abonadoDir, $totalDir, $porcentajeDir));
      }

      if($subdirectorSelect==''||$subdirectorSelect=='undefinded' || $subdirectorSelect ==0 || $subdirectorSelect==null){
        $respuesta = array( TRUE );
      }
      else{
        $respuesta = array($this->Comisiones_model->update_comisionessubDir($ideLote, $subdirectorSelect, $abonadosubDir, $totalsubDir, $porcentajesubDir));      
      }

      if($gerenteSelect==''||$gerenteSelect=='undefinded' || $gerenteSelect ==0 || $gerenteSelect==null){
        $respuesta = array( TRUE );
      }
      else{
        $respuesta = array($this->Comisiones_model->update_comisionesGer($ideLote, $gerenteSelect, $abonadoGerente, $totalGerente, $porcentajeGerente));
      }

      if($coordinadorSelect==''||$coordinadorSelect=='undefinded' || $coordinadorSelect ==0 || $coordinadorSelect==null){
        $abonadoCoordinador = ($this->input->post("abonadoCoordinador")) == '' ? 0:$this->input->post("abonadoCoordinador");
        $pendienteCoordinador = ($this->input->post("pendienteCoordinador")) == '' ? 0:$this->input->post("pendienteCoordinador");
        $totalCoordinador = ($this->input->post("totalCoordinador"))== '' ? 0:$this->input->post("totalCoordinador");
        $respuesta = array( TRUE );
      }
      else{
        $abonadoCoordinador = str_replace($replace,"",$this->input->post("abonadoCoordinador"));
        $pendienteCoordinador = str_replace($replace,"",$this->input->post("pendienteCoordinador"));
        $totalCoordinador = str_replace($replace,"",$this->input->post("totalCoordinador"));
        $respuesta = array($this->Comisiones_model->update_comisionesCoord($ideLote, $coordinadorSelect, $abonadoCoordinador, $totalCoordinador, $porcentajeCoordinador));
      }

      if($asesorSelect==''||$asesorSelect=='undefinded' || $asesorSelect ==0 || $asesorSelect==null){
        $respuesta = array( TRUE );
      }
      else{
        $respuesta = array($this->Comisiones_model->update_comisionesAse($ideLote, $asesorSelect, $abonadoAsesor, $totalAsesor, $porcentajeAsesor));
      }

///////////////////////////////////////////////////////////////////////////////////////////////////////////777

      if($MKTDSelect==''||$MKTDSelect=='undefinded' || $MKTDSelect ==0 || $MKTDSelect==null){
        $respuesta = array( TRUE );
      }
      else{
        $respuesta = array($this->Comisiones_model->update_comisioneMKTD($ideLote, $MKTDSelect, $abonadoMKTD, $totalMKTD, $porcentajeMKTD));
      }
      if($SubClubSelect==''||$SubClubSelect=='undefinded' || $SubClubSelect ==0 || $SubClubSelect==null){
        $respuesta = array( TRUE );
      }
      else{
        $respuesta = array($this->Comisiones_model->update_comisionesSUBCLUB($ideLote, $SubClubSelect, $abonadoSubClub, $totalSubClub, $porcentajeSubClub));
      }
      if($EjectClubSelect==''||$EjectClubSelect=='undefinded' || $EjectClubSelect ==0 || $EjectClubSelect==null){
        $respuesta = array( TRUE );
      }
      else{
        $respuesta = array($this->Comisiones_model->update_comisionesEJECTCLUB($ideLote, $EjectClubSelect, $abonadoEjectClub, $totalEjectClub, $porcentajeEjectClub));
      }


      if($GreenSelect==''||$GreenSelect=='undefinded' || $GreenSelect ==0 || $GreenSelect==null){
        $respuesta = array( TRUE );
      }
      else{
        $respuesta = array($this->Comisiones_model->update_comisionesGreenham($ideLote, $GreenSelect, $abonadoGreenham, $totalGreenham, $porcentajeGreenham));
      }


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////7

      $TOTALCOMISION = ($totalDir+$totalsubDir+$totalGerente+$totalCoordinador+$totalAsesor+$totalMKTD+$totalSubClub+$totalGreenham);
      $ABONOCONTRALORIA = ($abonadoDir+$abonadosubDir+$abonadoGerente+$abonadoCoordinador+$abonadoAsesor+$abonadoMKTD+$abonadoSubClub+$abonadoGreenham);
      $PENDICONTRALORIA = ($TOTALCOMISION-$ABONOCONTRALORIA);
      $PORCETOTAL = ($porcentajeDir+$porcentajesubDir+$porcentajeGerente+$porcentajeCoordinador+$porcentajeAsesor+$porcentajeMKTD+$porcentajeSubClub+$porcentajeEjectClub+$porcentajeGreenham);

      $respuesta = array($this->Comisiones_model->update_pago_comision($ideLote, $TOTALCOMISION, $PORCETOTAL, $ABONOCONTRALORIA, $PENDICONTRALORIA));
      $respuesta = array($this->Comisiones_model->update_lote_registro_comision($ideLote));
  }
  echo json_encode( $respuesta );
}


function getDatosAbonado($idlote){
  echo json_encode($this->Comisiones_model->getDatosAbonado($idlote)->result_array());
}
function getDatosAbonadoDispersion($idlote,$ooam){
  echo json_encode($this->Comisiones_model->getDatosAbonadoDispersion($idlote, $ooam)->result_array());
}

function getDatosAbonadoSuma1($idlote){
  echo json_encode($this->Comisiones_model->getDatosAbonadoSuma1($idlote)->result_array());
}
function getDatosAbonadoSuma11($idlote,$ooam){
  echo json_encode($this->Comisiones_model->getDatosAbonadoSuma11($idlote,$ooam)->result_array());
}
 





 
public function nuevo_abono_comision(){
  $respuesta = array( FALSE );
  if($this->input->post("ideLote")){
    $ideLote = $this->input->post("ideLote");
    $referencia = $this->input->post("referencia");
    $idDesarrollo = $this->input->post("idDesarrollo");
    $abono_nuevo = $this->input->post("abono_nuevo[]");
    $rol = $this->input->post("rol[]");
    $id_comision = $this->input->post("id_comision[]");
    $suma = 0;
    $replace = [",","$"];
     for($i=0;$i<sizeof($id_comision);$i++){   
       $var_n = str_replace($replace,"",$abono_nuevo[$i]);

       $respuesta = $this->Comisiones_model->insert_pago_individual($id_comision[$i], $rol[$i], $var_n);
      }

    for($i=0;$i<sizeof($abono_nuevo);$i++){
      $var_n = str_replace($replace,"",$abono_nuevo[$i]);

      $suma = $suma + $var_n ;
    }
        // $respuesta = $this->Comisiones_model->update_neodata($referencia, $idDesarrollo, $suma);
    $respuesta = $this->Comisiones_model->update_pago_general($suma, $ideLote);
 }
echo json_encode( $respuesta );
}

public function agregar_comisionvc(){
  $replace = ["$", ","];
  $respuesta = array( FALSE );
  if($this->input->post("precioLote")){
   // echo "si entro";
   $precioLote = $this->input->post("precioLote");
   $ideLote = $this->input->post("ideLote");
  
   $directorSelect = $this->input->post("directorSelect");
   $porcentajeDir = $this->input->post("porcentajeDir");
  
   $subdirectorSelect = $this->input->post("subdirectorSelect");
   $porcentajesubDir = $this->input->post("porcentajesubDir");
  
   $gerenteSelect = $this->input->post("gerenteSelect");
   $porcentajeGerente = $this->input->post("porcentajeGerente");
   
   $coordinadorSelect = $this->input->post("coordinadorSelect");
   $porcentajeCoordinador = $this->input->post("porcentajeCoordinador");
  
   $asesorSelect = $this->input->post("asesorSelect");
   $porcentajeAsesor = $this->input->post("porcentajeAsesor");
    
   ///////////////////////////////////77
  
  
   $subdirectorSelect21 = $this->input->post("subdirectorSelect21");
   $porcentajesubDir21 = $this->input->post("porcentajesubDir21");
   
  
   $gerenteSelect21 = $this->input->post("gerenteSelect21");
   $porcentajeGerente21 = $this->input->post("porcentajeGerente21");
  
  
   $coordinadorSelect21 = $this->input->post("coordinadorSelect21");
   $porcentajeCoordinador21 = $this->input->post("porcentajeCoordinador21");
  
  
   $asesorSelect21 = $this->input->post("asesorSelect21");
   $porcentajeAsesor21 = $this->input->post("porcentajeAsesor21");
  
   ////////////////////////////7
  
  
    $subdirectorSelect31 = $this->input->post("subdirectorSelect31");
   $porcentajesubDir31 = $this->input->post("porcentajesubDir31");
   
  
   $gerenteSelect31 = $this->input->post("gerenteSelect31");
   $porcentajeGerente31 = $this->input->post("porcentajeGerente31");
  
  
   $coordinadorSelect31 = $this->input->post("coordinadorSelect31");
   $porcentajeCoordinador31 = $this->input->post("porcentajeCoordinador31");
  
  
   $asesorSelect31 = $this->input->post("asesorSelect31");
   $porcentajeAsesor31 = $this->input->post("porcentajeAsesor31");
   
  
         ////////////////////////////////////
         $MKTDSelect = $this->input->post("MKTDSelect");
         $porcentajeMKTD = $this->input->post("porcentajeMKTD");
         
   
         $SubClubSelect = $this->input->post("SubClubSelect");
         $porcentajeSubClub = $this->input->post("porcentajeSubClub");
        
   
         $EjectClubSelect = $this->input->post("EjectClubSelect");
         $porcentajeEjectClub = $this->input->post("porcentajeEjectClub");
        

         $GreenSelect = $this->input->post("GreenSelect");
         $porcentajeGreenham = $this->input->post("porcentajeGreenham");
        
  
   $referencia = $this->input->post("referencia");
   $idDesarrollo = $this->input->post("idDesarrollo");
  
  
   if($directorSelect==''||$directorSelect=='undefinded' || $directorSelect ==0 || $directorSelect==null){
    $abonadoDir = $this->input->post("abonadoDir");
    $pendienteDir = $this->input->post("pendienteDir");
    $totalDir = $this->input->post("totalDir");
     $respuesta = array( TRUE );
   }
   else{
    $abonadoDir = str_replace($replace,"",$this->input->post("abonadoDir"));
    $pendienteDir = str_replace($replace,"",$this->input->post("pendienteDir"));
    $totalDir = str_replace($replace,"",$this->input->post("totalDir"));
     $respuesta = array($this->Comisiones_model->update_comisionesDir($ideLote, $directorSelect, $abonadoDir, $totalDir, $porcentajeDir));
   }
  
   if($subdirectorSelect==''||$subdirectorSelect=='undefinded' || $subdirectorSelect ==0 || $subdirectorSelect==null){
    $abonadosubDir = $this->input->post("abonadosubDir");
    $pendientesubDir = $this->input->post("pendientesubDir");
    $totalsubDir = $this->input->post("totalsubDir");
     $respuesta = array( TRUE );
   }
   else{
    $abonadosubDir = str_replace($replace,"",$this->input->post("abonadosubDir"));
    $pendientesubDir = str_replace($replace,"",$this->input->post("pendientesubDir"));
    $totalsubDir = str_replace($replace,"",$this->input->post("totalsubDir"));
     $respuesta = array($this->Comisiones_model->update_comisionessubDir($ideLote, $subdirectorSelect, $abonadosubDir, $totalsubDir, $porcentajesubDir));      
   }
  
   if($gerenteSelect==''||$gerenteSelect=='undefinded' || $gerenteSelect ==0 || $gerenteSelect==null){
    $abonadoGerente = $this->input->post("abonadoGerente");
    $pendienteGerente = $this->input->post("pendienteGerente");
    $totalGerente = $this->input->post("totalGerente");
     $respuesta = array( TRUE );
   }
   else{
    $abonadoGerente = str_replace($replace,"",$this->input->post("abonadoGerente"));
    $pendienteGerente = str_replace($replace,"",$this->input->post("pendienteGerente"));
    $totalGerente = str_replace($replace,"",$this->input->post("totalGerente"));
     $respuesta = array($this->Comisiones_model->update_comisionesGer($ideLote, $gerenteSelect, $abonadoGerente, $totalGerente, $porcentajeGerente));
   }
  
   if($coordinadorSelect==''||$coordinadorSelect=='undefinded' || $coordinadorSelect ==0 || $coordinadorSelect==null){
    $abonadoCoordinador = ($this->input->post("abonadoCoordinador")) == '' ? 0:$this->input->post("abonadoCoordinador");
    $pendienteCoordinador = ($this->input->post("pendienteCoordinador")) == '' ? 0:$this->input->post("pendienteCoordinador");
    $totalCoordinador = ($this->input->post("totalCoordinador"))== '' ? 0:$this->input->post("totalCoordinador");
     $respuesta = array( TRUE );
   }
   else{
    $abonadoCoordinador = str_replace($replace,"",$this->input->post("abonadoCoordinador"));
    $pendienteCoordinador = str_replace($replace,"",$this->input->post("pendienteCoordinador"));
    $totalCoordinador = str_replace($replace,"",$this->input->post("totalCoordinador"));
     $respuesta = array($this->Comisiones_model->update_comisionesCoord($ideLote, $coordinadorSelect, $abonadoCoordinador, $totalCoordinador, $porcentajeCoordinador));
   }
  
   if($asesorSelect==''||$asesorSelect=='undefinded' || $asesorSelect ==0 || $asesorSelect==null){
    $abonadoAsesor = $this->input->post("abonadoAsesor");
    $pendienteAsesor =$this->input->post("pendienteAsesor");
    $totalAsesor = $this->input->post("totalAsesor");
     $respuesta = array( TRUE );
   }
   else{
    $abonadoAsesor = str_replace($replace,"",$this->input->post("abonadoAsesor"));
    $pendienteAsesor = str_replace($replace,"",$this->input->post("pendienteAsesor"));
    $totalAsesor = str_replace($replace,"",$this->input->post("totalAsesor"));
   
     $respuesta = array($this->Comisiones_model->update_comisionesAse($ideLote, $asesorSelect, $abonadoAsesor, $totalAsesor, $porcentajeAsesor));
   }
  
  
  ///////////////////////////////////7
  
  
  
    if($subdirectorSelect21==''||$subdirectorSelect21=='undefinded' || $subdirectorSelect21 ==0 || $subdirectorSelect21==null){
      $abonadosubDir21 = $this->input->post("abonadosubDir21");
    $pendientesubDir21 = $this->input->post("pendientesubDir21");
    $totalsubDir21 = $this->input->post("totalsubDir21");
     $respuesta = array( TRUE );
   }
   else{
    $abonadosubDir21 = str_replace($replace,"",$this->input->post("abonadosubDir21"));
    $pendientesubDir21 = str_replace($replace,"",$this->input->post("pendientesubDir21"));
    $totalsubDir21 = str_replace($replace,"",$this->input->post("totalsubDir21"));
     $respuesta = array($this->Comisiones_model->update_comisionessubDir($ideLote, $subdirectorSelect21, $abonadosubDir21, $totalsubDir21, $porcentajesubDir21));      
   }
  
   if($gerenteSelect21==''||$gerenteSelect21=='undefinded' || $gerenteSelect21 ==0 || $gerenteSelect21==null){
    $abonadoGerente21 = $this->input->post("abonadoGerente21");
    $pendienteGerente21 = $this->input->post("pendienteGerente21");
    $totalGerente21 = $this->input->post("totalGerente21");
     $respuesta = array( TRUE );
   }
   else{
    $abonadoGerente21 = str_replace($replace,"",$this->input->post("abonadoGerente21"));
    $pendienteGerente21 = str_replace($replace,"",$this->input->post("pendienteGerente21"));
    $totalGerente21 = str_replace($replace,"",$this->input->post("totalGerente21"));
     $respuesta = array($this->Comisiones_model->update_comisionesGer($ideLote, $gerenteSelect21, $abonadoGerente21, $totalGerente21, $porcentajeGerente21));
   }
  
   if($coordinadorSelect21==''||$coordinadorSelect21=='undefinded' || $coordinadorSelect21 ==0 || $coordinadorSelect21==null){
    $abonadoCoordinador21 = ($this->input->post("abonadoCoordinador21")) == '' ? 0:$this->input->post("abonadoCoordinador21");
    $pendienteCoordinador21 = ($this->input->post("pendienteCoordinador21")) == '' ? 0:$this->input->post("pendienteCoordinador21");
    $totalCoordinador21 = ($this->input->post("totalCoordinador21"))== '' ? 0:$this->input->post("totalCoordinador21");
     $respuesta = array( TRUE );
   }
   else{
    $abonadoCoordinador21 = str_replace($replace,"",$this->input->post("abonadoCoordinador21"));
    $pendienteCoordinador21 = str_replace($replace,"",$this->input->post("pendienteCoordinador21"));
    $totalCoordinador21 = str_replace($replace,"",$this->input->post("totalCoordinador21"));
     $respuesta = array($this->Comisiones_model->update_comisionesCoord($ideLote, $coordinadorSelect21, $abonadoCoordinador21, $totalCoordinador21, $porcentajeCoordinador21));
   }
  
   if($asesorSelect21==''||$asesorSelect21=='undefinded' || $asesorSelect21 ==0 || $asesorSelect21==null){
    $abonadoAsesor21 = $this->input->post("abonadoAsesor21");
    $pendienteAsesor21 = $this->input->post("pendienteAsesor21");
    $totalAsesor21 = $this->input->post("totalAsesor21");
     $respuesta = array( TRUE );
   }
   else{
    $abonadoAsesor21 = str_replace($replace,"",$this->input->post("abonadoAsesor21"));
    $pendienteAsesor21 = str_replace($replace,"",$this->input->post("pendienteAsesor21"));
    $totalAsesor21 = str_replace($replace,"",$this->input->post("totalAsesor21"));
     $respuesta = array($this->Comisiones_model->update_comisionesAse($ideLote, $asesorSelect21, $abonadoAsesor21, $totalAsesor21, $porcentajeAsesor21));
   }
  
  
   ////////////////////////////////////////////77
  
  
  
   ///////////////////////////////////7
  
  
  if($subdirectorSelect31==''||$subdirectorSelect31=='undefinded' || $subdirectorSelect31 ==0 || $subdirectorSelect31==null){
    $abonadosubDir31 = $this->input->post("abonadosubDir31");
    $pendientesubDir31 = $this->input->post("pendientesubDir31");
    $totalsubDir31 = $this->input->post("totalsubDir31");
     $respuesta = array( TRUE );
   }
   else{
    $abonadosubDir31 = str_replace($replace,"",$this->input->post("abonadosubDir31"));
    $pendientesubDir31 = str_replace($replace,"",$this->input->post("pendientesubDir31"));
    $totalsubDir31 = str_replace($replace,"",$this->input->post("totalsubDir31"));
     $respuesta = array($this->Comisiones_model->update_comisionessubDir($ideLote, $subdirectorSelect31, $abonadosubDir31, $totalsubDir31, $porcentajesubDir31));      
   }
  
   if($gerenteSelect31==''||$gerenteSelect31=='undefinded' || $gerenteSelect31 ==0 || $gerenteSelect31==null){
    $abonadoGerente31 = $this->input->post("abonadoGerente31");
    $pendienteGerente31 = $this->input->post("pendienteGerente31");
    $totalGerente31 = $this->input->post("totalGerente31");
     $respuesta = array( TRUE );
   }
   else{
    $abonadoGerente31 = str_replace($replace,"",$this->input->post("abonadoGerente31"));
    $pendienteGerente31 = str_replace($replace,"",$this->input->post("pendienteGerente31"));
    $totalGerente31 = str_replace($replace,"",$this->input->post("totalGerente31"));
     $respuesta = array($this->Comisiones_model->update_comisionesGer($ideLote, $gerenteSelect31, $abonadoGerente31, $totalGerente31, $porcentajeGerente31));
   }
  
   if($coordinadorSelect31==''||$coordinadorSelect31=='undefinded' || $coordinadorSelect31 ==0 || $coordinadorSelect31==null){
    $abonadoCoordinador31 = ($this->input->post("abonadoCoordinador31")) == '' ? 0:$this->input->post("abonadoCoordinador31");
    $pendienteCoordinador31 = ($this->input->post("pendienteCoordinador31")) == '' ? 0:$this->input->post("pendienteCoordinador31");
    $totalCoordinador31 = ($this->input->post("totalCoordinador31"))== '' ? 0:$this->input->post("totalCoordinador31");
     $respuesta = array( TRUE );
   }
   else{
    $abonadoCoordinador31 = str_replace($replace,"",$this->input->post("abonadoCoordinador31"));
    $pendienteCoordinador31 = str_replace($replace,"",$this->input->post("pendienteCoordinador31"));
    $totalCoordinador31 = str_replace($replace,"",$this->input->post("totalCoordinador31"));
     $respuesta = array($this->Comisiones_model->update_comisionesCoord($ideLote, $coordinadorSelect31, $abonadoCoordinador31, $totalCoordinador31, $porcentajeCoordinador31));
   }
  
   if($asesorSelect31==''||$asesorSelect31=='undefinded' || $asesorSelect31 ==0 || $asesorSelect31==null){
    $abonadoAsesor31 = $this->input->post("abonadoAsesor31");
    $pendienteAsesor31 = $this->input->post("pendienteAsesor31");
    $totalAsesor31 = $this->input->post("totalAsesor31");
     $respuesta = array( TRUE );
   }
   else{
    $abonadoAsesor31 = str_replace($replace,"",$this->input->post("abonadoAsesor31"));
    $pendienteAsesor31 = str_replace($replace,"",$this->input->post("pendienteAsesor31"));
    $totalAsesor31 = str_replace($replace,"",$this->input->post("totalAsesor31"));
     $respuesta = array($this->Comisiones_model->update_comisionesAse($ideLote, $asesorSelect31, $abonadoAsesor31, $totalAsesor31, $porcentajeAsesor31));
   }
  
  
   ////////////////////////////////////////////77



   if($MKTDSelect==''||$MKTDSelect=='undefinded' || $MKTDSelect ==0 || $MKTDSelect==null){
    $abonadoMKTD = $this->input->post("abonadoMKTD");
    $pendienteMKTD =$this->input->post("pendienteMKTD");
    $totalMKTD = $this->input->post("totalMKTD");
    $respuesta = array( TRUE );
  }
  else{
    $abonadoMKTD = str_replace($replace,"",$this->input->post("abonadoMKTD"));
    $pendienteMKTD = str_replace($replace,"",$this->input->post("pendienteMKTD"));
    $totalMKTD = str_replace($replace,"",$this->input->post("totalMKTD"));
    $respuesta = array($this->Comisiones_model->update_comisioneMKTD($ideLote, $MKTDSelect, $abonadoMKTD, $totalMKTD, $porcentajeMKTD));
  }
  if($SubClubSelect==''||$SubClubSelect=='undefinded' || $SubClubSelect ==0 || $SubClubSelect==null){
    $abonadoSubClub = $this->input->post("abonadoSubClub");
    $pendienteSubClub = $this->input->post("pendienteSubClub");
    $totalSubClub = $this->input->post("totalSubClub");
    $respuesta = array( TRUE );
  }
  else{
    $abonadoSubClub = str_replace($replace,"",$this->input->post("abonadoSubClub"));
    $pendienteSubClub = str_replace($replace,"",$this->input->post("pendienteSubClub"));
    $totalSubClub = str_replace($replace,"",$this->input->post("totalSubClub"));
    $respuesta = array($this->Comisiones_model->update_comisionesSUBCLUB($ideLote, $SubClubSelect, $abonadoSubClub, $totalSubClub, $porcentajeSubClub));
  }
  if($EjectClubSelect==''||$EjectClubSelect=='undefinded' || $EjectClubSelect ==0 || $EjectClubSelect==null){
    $abonadoEjectClub = $this->input->post("abonadoEjectClub");
    $pendienteEjectClub = $this->input->post("pendienteEjectClub");
    $totalEjectClub = $this->input->post("totalEjectClub");
    $respuesta = array( TRUE );
  }
  else{
    $abonadoEjectClub = str_replace($replace,"",$this->input->post("abonadoEjectClub"));
    $pendienteEjectClub = str_replace($replace,"",$this->input->post("pendienteEjectClub"));
    $totalEjectClub = str_replace($replace,"",$this->input->post("totalEjectClub"));
    $respuesta = array($this->Comisiones_model->update_comisionesEJECTCLUB($ideLote, $EjectClubSelect, $abonadoEjectClub, $totalEjectClub, $porcentajeEjectClub));
  }


  if($GreenSelect==''||$GreenSelect=='undefinded' || $GreenSelect ==0 || $GreenSelect==null){
    $abonadoGreenham = $this->input->post("abonadoGreenham");
    $pendienteGreenham = $this->input->post("pendienteGreenham");
    $totalGreenham = $this->input->post("totalGreenham");
    $respuesta = array( TRUE );
  }
  else{
    $abonadoGreenham = str_replace($replace,"",$this->input->post("abonadoGreenham"));
    $pendienteGreenham = str_replace($replace,"",$this->input->post("pendienteGreenham"));
    $totalGreenham = str_replace($replace,"",$this->input->post("totalGreenham"));
    $respuesta = array($this->Comisiones_model->update_comisionesGreenham($ideLote, $GreenSelect, $abonadoGreenham, $totalGreenham, $porcentajeGreenham));
  }

   ////////////////////////////////////////////////////////////////////////
  
  
  $TO1 = ($totalDir+$totalsubDir+$totalGerente+$totalCoordinador+$totalAsesor);
  $TO2 = ($totalsubDir21+$totalGerente21+$totalCoordinador21+$totalAsesor21);
  $TO3 = ($totalsubDir31+$totalGerente31+$totalCoordinador31+$totalAsesor31);
  $TO4 = ($totalMKTD+$totalSubClub+$totalEjectClub+$totalGreenham);
  
  $AB1 = ($abonadoDir+$abonadosubDir+$abonadoGerente+$abonadoCoordinador+$abonadoAsesor);
  $AB2 = ($abonadosubDir21+$abonadoGerente21+$abonadoCoordinador21+$abonadoAsesor21);
  $AB3 = ($abonadosubDir31+$abonadoGerente31+$abonadoCoordinador31+$abonadoAsesor31);
  $AB4 = ($abonadoMKTD+$abonadoSubClub+$abonadoEjectClub+$abonadoGreenham);
  
  $PO1 = ($porcentajeDir+$porcentajesubDir+$porcentajeGerente+$porcentajeCoordinador+$porcentajeAsesor);
  $PO2 = ($porcentajesubDir21+$porcentajeGerente21+$porcentajeCoordinador21+$porcentajeAsesor21);
  $PO3 = ($porcentajesubDir31+$porcentajeGerente31+$porcentajeCoordinador31+$porcentajeAsesor31);
  $PO4 = ($porcentajeMKTD+$porcentajeSubClub+$porcentajeEjectClub+$porcentajeGreenham);
  
   $TOTALCOMISION = ($TO1+$TO2+$TO3+$TO4);
   $ABONOCONTRALORIA = ($AB1+$AB2+$AB3+$AB4);
   $PENDICONTRALORIA = ($TOTALCOMISION-$ABONOCONTRALORIA);
   $PORCETOTAL = ($PO1+$PO2+$PO3+$PO4);
  
   $respuesta = array($this->Comisiones_model->update_pago_comision($ideLote, $TOTALCOMISION, $PORCETOTAL, $ABONOCONTRALORIA, $PENDICONTRALORIA));
   $respuesta = array($this->Comisiones_model->update_lote_registro_comision($ideLote));
  
  }
  echo json_encode( $respuesta );
  }
    
  function getDatosDispersarCompartidas($idlote){
    echo json_encode($this->Comisiones_model->getDatosDispersarCompartidas($idlote)->result_array());
  }
  



public function getSettledCommissions(){
      $datos = array();
      $datos = $this->Comisiones_model->getSettledCommissions();
      if ($datos != null) {
          echo json_encode($datos);
      } else {
          echo json_encode(array());
      }
  }

  function validateSettledCommissions($idlote){
    $response = $this->Comisiones_model->validateSettledCommissions($idlote)->result_array();
    if(count($response) == 0) {
        $response[0]['finalAnswer'] = 0; // NO REGRESÓ RESULTADOS
        echo json_encode($response);
    } else {
        $response[0]['finalAnswer'] = 1; // REGRESÓ ALGO
        echo json_encode($response);
    }
}

public function getDatosNuevasXContraloria($proyecto,$condominio){
  $dat =  $this->Comisiones_model->getDatosNuevasXContraloria($proyecto,$condominio)->result_array();
 for( $i = 0; $i < count($dat); $i++ ){
     $dat[$i]['pa'] = 0;
 }
 echo json_encode( array( "data" => $dat));
}

public function getDatosNuevasAContraloria($proyecto,$condominio){
  $dat =  $this->Comisiones_model->getDatosNuevasAContraloria($proyecto,$condominio)->result_array();
 for( $i = 0; $i < count($dat); $i++ ){
     $dat[$i]['pa'] = 0;
 }
 echo json_encode( array( "data" => $dat));
}

public function getDatosNuevasFContraloria($proyecto,$condominio){
  $dat =  $this->Comisiones_model->getDatosNuevasFContraloria($proyecto,$condominio)->result_array();
 for( $i = 0; $i < count($dat); $i++ ){
     $dat[$i]['pa'] = 0;
 }
 echo json_encode( array( "data" => $dat));
}

public function getDatosHistorialPagoRP($id_usuario){
  ini_set('max_execution_time', 900);
  set_time_limit(900);
  ini_set('memory_limit','2048M');

  $dat =  $this->Comisiones_model->getDatosHistorialPagoRP($id_usuario)->result_array();
  for( $i = 0; $i < count($dat); $i++ ){
      $dat[$i]['pa'] = 0;
  }
  echo json_encode( array( "data" => $dat));
}

public function getDatosHistorialPago($proyecto = null,$condominio = null ) {      
  $dat =  $this->Comisiones_model->getDatosHistorialPago($proyecto,$condominio)->result_array();
  echo json_encode( array( "data" => $dat));
}

public function getDatosHistorialCancelacion($proyecto,$condominio){
  $dat =  $this->Comisiones_model->getDatosHistorialCancelacion($proyecto,$condominio)->result_array();
  echo json_encode( array( "data" => $dat));
}

public function getDatosHistorialPagoM($proyecto,$condominio){
  ini_set('max_execution_time', 900);
  set_time_limit(900);
  ini_set('memory_limit','2048M');
  $dat =  $this->Comisiones_model->getDatosHistorialPagoM($proyecto,$condominio)->result_array();
  for( $i = 0; $i < count($dat); $i++ ){
    $dat[$i]['pa'] = 0;
  }
  
  echo json_encode( array( "data" => $dat));
}

public function getDatosHistorialPagado($proyecto,$condominio){
  $dat =  $this->Comisiones_model->getDatosHistorialPagado($proyecto,$condominio)->result_array();
 for( $i = 0; $i < count($dat); $i++ ){
     $dat[$i]['pa'] = 0;
 }
 echo json_encode( array( "data" => $dat));
}


public function getDatosHistorialDU($proyecto,$condominio){
  $dat =  $this->Comisiones_model->getDatosHistorialDU($proyecto,$condominio)->result_array();
 for( $i = 0; $i < count($dat); $i++ ){
     $dat[$i]['pa'] = 0;
 }
 echo json_encode( array( "data" => $dat));
}

  

public function getDatosInternomexContraloria($proyecto){
  $dat =  $this->Comisiones_model->getDatosInternomexContraloria($proyecto)->result_array();
 for( $i = 0; $i < count($dat); $i++ ){
     $dat[$i]['pa'] = 0;
 }
 echo json_encode( array( "data" => $dat));
}




public function addFileControversia(){

  $idCliente=$this->input->post('idCliente');
  $doc_controversia= preg_replace('[^A-Za-z0-9]', '',$_FILES["doc_controversia"]["name"]);

  $fileExt = strtolower(substr($doc_controversia, strrpos($doc_controversia, '.') + 1));
  $date= date('dmYHis');
  $name_doc=  $idCliente.'_'.$date.'.'.$fileExt;
  
  $result = $this->Comisiones_model->verify_controversia($idCliente);
  $veryfy =  (empty($result)) ? TRUE : FALSE;
  
  if ($veryfy == TRUE){

      if ($fileExt == 'pdf'){

          $move = move_uploaded_file($_FILES["doc_controversia"]["tmp_name"],"static/documentos/cliente/controversia/".$name_doc);
          $validaMove = $move == FALSE ? 0 : 1;

          if ($validaMove == 1) {

            $arreglo=array();
            $arreglo["documento"] = $name_doc;
            $arreglo["idCliente"] = $idCliente;
            $arreglo["idUser"]= $this->session->userdata('id_usuario');

            $arreglo2=array();
            $arreglo2["id_usuario"]= $this->session->userdata('id_usuario');
            $arreglo2["comentario"]= 'SE ADJUNTO CONTROVERSIA';
            $arreglo2["id_pago_i"]= 0;
            $arreglo2["estatus"]= 0;

            $this->Comisiones_model->insert_HCD_A($arreglo);
            $this->Comisiones_model->insert_HCD($arreglo2);

            $response['message'] = 'OK';
            echo json_encode($response);

          } else if ($validaMove == 0){
            $response['message'] = 'ERROR';
            echo json_encode($response);
          } else {
            $response['message'] = 'ERROR';
            echo json_encode($response);
          }

      } else {
          $response['message'] = 'ERROR';
          echo json_encode($response);
      }

  } else {
    
      $file = "./static/documentos/cliente/controversia/".$result[0]["documento"];

      if(file_exists($file)){
        unlink($file);

              if ($fileExt == 'pdf'){

                $move = move_uploaded_file($_FILES["doc_controversia"]["tmp_name"],"static/documentos/cliente/controversia/".$name_doc);
                $validaMove = $move == FALSE ? 0 : 1;

                if ($validaMove == 1) {

                  $arreglo=array();
                  $arreglo["documento"] = $name_doc;
                  $arreglo["idUser"]= $this->session->userdata('id_usuario');
                  $arreglo["fecha_creacion"]=date("Y-m-d H:i:s");

                  $arreglo2=array();
                  $arreglo2["id_usuario"]= $this->session->userdata('id_usuario');
                  $arreglo2["comentario"]= 'SE ADJUNTO CONTROVERSIA';
                  $arreglo2["id_pago_i"]= 0;
                  $arreglo2["estatus"]= 0;

                  $this->Comisiones_model->update_HCD_A($idCliente,$arreglo);
                  $this->Comisiones_model->insert_HCD($arreglo2);

                  $response['message'] = 'OK';
                  echo json_encode($response);

                } else if ($validaMove == 0){
                  $response['message'] = 'ERROR';
                  echo json_encode($response);
                } else {
                  $response['message'] = 'ERROR';
                  echo json_encode($response);
                }

            } else {
                $response['message'] = 'ERROR';
                echo json_encode($response);
            }

      }
  }
}


public function solicitar_controversia()
{
  $this->load->view('template/header');
  $this->load->view("ventas/solicitar_controversia");
}

///////////////////////////////////////////////////////////////////////

function update_stC(){

    $idCliente=$this->input->post('idCliente');

    $arreglo=array();
    $arreglo["estatus"] = 2;

    $validate = $this->Comisiones_model->update_HCD_A($idCliente,$arreglo);

  if ($validate == TRUE){
    $response['message'] = 'OK';
    echo json_encode($response);

  } else {
    $response['message'] = 'ERROR';
    echo json_encode($response);
  }

}

public function getDataIncidencias()
{
  $datos = array();
  $datos = $this->Comisiones_model->getDataIncidencias();
  if ($datos != null) {
    echo json_encode($datos);
  } else {
    echo json_encode(array());
  }
}

function getDatosDocumentos($id_comision, $id_pj){
  echo json_encode($this->Comisiones_model->getDatosDocumentos($id_comision, $id_pj)->result_array());
}

public function LiquidarLote(){
  $lote = $this->input->post("lote");
 
   $respuesta = $this->Comisiones_model->LiquidarLote($this->session->userdata('id_usuario'),$lote);
     
     echo json_encode($respuesta);
 
 }



    public function getAllCommissions()
    {
        $datos = array();
        $datos = $this->Comisiones_model->getAllCommissions();
        if ($datos != null) {
            echo json_encode($datos);
        } else {
            echo json_encode(array());
        }
    }

   
    public function getCommissionsWithoutPaymentInNeodata(){
        $this->load->view('template/header');
        $this->load->view("ventas/commissions_without_payment");
    }

    public function validateRegion(){
        $this->load->view('template/header');
        $this->load->view("ventas/validate_region");
    }

    public function getCommissionsToValidate(){
        $id_usuario = $this->session->userdata('id_usuario');
        $data['data'] = $this->Comisiones_model->getCommissionsToValidate($id_usuario)->result_array();
        echo json_encode($data);
    }

    public function updatePlaza($sol, $plaza){
        $consulta_comisiones = $this->db->query("SELECT id_pago_i FROM pago_comision_ind where id_pago_i IN (".$sol.")");
        $lotes = $this->db->query("SELECT idLote FROM lotes WHERE idLote IN (SELECT id_lote FROM comisiones WHERE id_comision IN (SELECT id_comision FROM pago_comision_ind WHERE id_pago_i IN (".$sol.")))");
        if( $consulta_comisiones->num_rows() > 0 ){
            $consulta_comisiones = $consulta_comisiones->result_array();
            $lotes = $lotes->result_array();
            $id_user_Vl = $this->session->userdata('id_usuario');
            for( $i = 0; $i < count($consulta_comisiones ); $i++){
                if($plaza == 0) { // SÓLO SE MARCA COMO RECHAZADA Y NO SE ACTUALIZA LOTE
                    if($id_user_Vl == 1981)$estatus = 61; // ES MARICELA
                    else if($id_user_Vl == 1988)$estatus = 62; // ES FERNANDA
                    $this->Comisiones_model->updateIndividualCommission($consulta_comisiones[$i]['id_pago_i'], $estatus);
                    $this->db->query("INSERT INTO historial_comisiones VALUES (".$consulta_comisiones[$i]['id_pago_i'].", ".$id_user_Vl.", GETDATE(), 1, 'RECHAZO SUBDIRECTOR MKTD')");
                    echo json_encode(1); // RECHAZADO
                } else {
                    if($id_user_Vl == 1981)$estatus = 51; // ES MARICELA
                    else if($id_user_Vl == 1988)$estatus = 52; // ES FERNANDA
                    $this->Comisiones_model->updateIndividualCommission($consulta_comisiones[$i]['id_pago_i'], $estatus);
                    $this->db->query("INSERT INTO historial_comisiones VALUES (".$consulta_comisiones[$i]['id_pago_i'].", ".$id_user_Vl.", GETDATE(), 1, 'VALIDÓ SUBDIRECTOR MKTD')");
                    $this->Comisiones_model->updateLotes($lotes[$i]['idLote'], $plaza);
                    echo json_encode(2); // LOTE ASIGNADO
                }
            }
        }
        else{ // SIN LOTES
            $consulta_comisiones = array();
            echo json_encode(3); // NO ENCONTRÓ NADA, ERROR.
        }
    }

    

    public function asigno_region_uno($sol){
      $this->load->model("Comisiones_model");
      $consulta_comisiones = $this->db->query("SELECT id_pago_i FROM pago_comision_ind where id_pago_i IN (".$sol.")");

      if( $consulta_comisiones->num_rows() > 0 ){
        $consulta_comisiones = $consulta_comisiones->result_array();

        $id_user_Vl = $this->session->userdata('id_usuario');

        for( $i = 0; $i < count($consulta_comisiones ); $i++){
          $this->Comisiones_model->update_acepta_solicitante_uno($consulta_comisiones[$i]['id_pago_i']);

          $this->db->query("INSERT INTO historial_comisiones VALUES (".$consulta_comisiones[$i]['id_pago_i'].", ".$id_user_Vl.", GETDATE(), 1, 'COBRANZA ENVIO A REGIÓN 1')");
// $this->db->query("UPDATE pago_comision_ind SET fecha_pago_intmex = GETDATE() WHERE id_pago_i = ".$consulta_comisiones[$i]['id_pago_i']."");
        }
      }
      else{
        $consulta_comisiones = array();
      }
    }

    public function asigno_region_dos($sol){
      $this->load->model("Comisiones_model");
      $consulta_comisiones = $this->db->query("SELECT id_pago_i FROM pago_comision_ind where id_pago_i IN (".$sol.")");

      if( $consulta_comisiones->num_rows() > 0 ){
        $consulta_comisiones = $consulta_comisiones->result_array();

        $id_user_Vl = $this->session->userdata('id_usuario');

        for( $i = 0; $i < count($consulta_comisiones ); $i++){
          $this->Comisiones_model->update_acepta_solicitante_dos($consulta_comisiones[$i]['id_pago_i']);

          $this->db->query("INSERT INTO historial_comisiones VALUES (".$consulta_comisiones[$i]['id_pago_i'].", ".$id_user_Vl.", GETDATE(), 1, 'COBRANZA ENVIO A REGIÓN 2')");
// $this->db->query("UPDATE pago_comision_ind SET fecha_pago_intmex = GETDATE() WHERE id_pago_i = ".$consulta_comisiones[$i]['id_pago_i']."");
        }
      }
      else{
        $consulta_comisiones = array();
      }
    }


    public function EnviarDesarrollos()
    {
      if($this->input->post("desarrolloSelect2") == 1000){
        $formaPago = $this->Comisiones_model->GetFormaPago($this->session->userdata('id_usuario'))->result_array();
        if($formaPago[0]['forma_pago'] == 3 || $formaPago[0]['forma_pago'] == 4){
          $respuesta = $this->Comisiones_model->ComisionesEnviar($this->session->userdata('id_usuario'),0,1);
        }else{
          $respuesta = $this->Comisiones_model->ComisionesEnviar($this->session->userdata('id_usuario'),0,2);
        }
      }else{
        $formaPago = $this->Comisiones_model->GetFormaPago($this->session->userdata('id_usuario'))->result_array();
        if($formaPago[0]['forma_pago'] == 3 || $formaPago[0]['forma_pago'] == 4){
          $respuesta = $this->Comisiones_model->ComisionesEnviar($this->session->userdata('id_usuario'),$this->input->post("desarrolloSelect2"),3);
        }else{
          $respuesta = $this->Comisiones_model->ComisionesEnviar($this->session->userdata('id_usuario'),$this->input->post("desarrolloSelect2"),4);
        }
      }
      echo json_encode($respuesta);
    }

    
    public function getDatosEnviadasmkContraloria(){
      $dat =  $this->Comisiones_model->getDatosEnviadasmkContraloria()->result_array();
     for( $i = 0; $i < count($dat); $i++ ){
         $dat[$i]['pa'] = 0;
     }
     echo json_encode( array( "data" => $dat));
    }
    
    
    public function getDatosEnviadasADirectorMK($as){
      ini_set('max_execution_time', 900);
      set_time_limit(900);
      ini_set('memory_limit','2048M');

      $dat =  $this->Comisiones_model->getDatosEnviadasADirectorMK($as)->result_array();
     for( $i = 0; $i < count($dat); $i++ ){
         $dat[$i]['pa'] = 0;
     }
     echo json_encode( array( "data" => $dat));
    }
    
 
    public function getDatosNuevasRContraloria($proyecto,$condominio){
      $dat =  $this->Comisiones_model->getDatosNuevasRContraloria($proyecto,$condominio)->result_array();
     for( $i = 0; $i < count($dat); $i++ ){
         $dat[$i]['pa'] = 0;
     }
     echo json_encode( array( "data" => $dat));
    }

    public function getDatosEspecialRContraloria(){
      $dat =  $this->Comisiones_model->getDatosEspecialRContraloria()->result_array();
     for( $i = 0; $i < count($dat); $i++ ){
         $dat[$i]['pa'] = 0;
     }
     echo json_encode( array( "data" => $dat));
    }

    public function resguardos(){
      $this->load->view('template/header');
      $this->load->view("ventas/revision_resguardo");
    }
 
    public function getDatosResguardoContraloria($user,$condominio){
      $dat =  $this->Comisiones_model->getDatosResguardoContraloria($user,$condominio)->result_array();
     for( $i = 0; $i < count($dat); $i++ ){
         $dat[$i]['pa'] = 0;
     }
     echo json_encode( array( "data" => $dat));
    }

    public function retiros(){
      $this->load->view('template/header');
      $this->load->view("ventas/retiros");
    }
 
    public function getDatosRetirosContraloria($proyecto,$condominio){
      $dat =  $this->Comisiones_model->getDatosRetirosContraloria($proyecto,$condominio)->result_array();
     for( $i = 0; $i < count($dat); $i++ ){
        $dat[$i]['pa'] = 0;
     }
     echo json_encode( array( "data" => $dat));
    }
    public function historial_retiros()
    {
      $this->load->view('template/header');
      $this->load->view("ventas/retiros_historial");
    }
 
    public function getDatoshistorialResguardoContraloria($proyecto,$condominio){
      $dat =  $this->Comisiones_model->getDatoshistorialResguardoContraloria($proyecto,$condominio)->result_array();
     for( $i = 0; $i < count($dat); $i++ ){
         $dat[$i]['pa'] = 0;
     }
     echo json_encode( array( "data" => $dat));
    }

       /**--------------------------------------BONOS---------------------------------------- */
     
     


    /**--------------------------------------BONOS Y PRESTAMOS------------------------------------ */
  
    public function savePrestamo()
    {
      $this->input->post("pago");
      // $file = $_FILES["evidencia"];
      $monto = $this->input->post("monto");
      $NumeroPagos = $this->input->post("numeroP");
      $IdUsuario = $this->input->post("usuarioid");
      $comentario = $this->input->post("comentario");
      $tipo = $this->input->post("tipo");
      $idUsu = intval($this->session->userdata('id_usuario')); 
      $pesos = str_replace(",", "", $monto);

      $dato = $this->Comisiones_model->getPrestamoxUser($IdUsuario ,$tipo)->result_array();
     
      if(empty($dato)){
              $pesos=str_replace("$", "", $monto);
        $comas =str_replace(",", "", $pesos);
        $pago = $comas;
              $pagoCorresp = $pago / $NumeroPagos;
        $pagoCorresReal = $pagoCorresp;
              $insertArray = array(
                'id_usuario'      => $IdUsuario,
                'monto'           => $pago,
                'num_pagos'       => $NumeroPagos, 
                'pago_individual' => $pagoCorresReal,
                'comentario'      => $comentario,
                'estatus'         => 1,
                'pendiente'       => 0,
                'creado_por'      => $idUsu ,
                'fecha_creacion'  => date("Y-m-d H:i:s"),
                'modificado_por'  => $idUsu ,
                'fecha_modificacion'   => date("Y-m-d H:i:s"),
                'tipo'            => $tipo,
                // 'evidenciaDocs'    => "$expediente",
                                );
              $respuesta =  $this->Comisiones_model->insertar_prestamos($insertArray);
              echo json_encode($respuesta);
      }else{
              $respuesta = 3;
              echo json_encode($respuesta);
      }
      // }else{
      //   $respuesta = 4;
      //   echo json_encode($respuesta);
      // }
      // }

    }


  public function TienePago($id){
      $respuesta = $this->Comisiones_model->TienePago($id)->result_array();
    if(count($respuesta) > 0)
    {
      echo json_encode(1);
    }else{
      echo json_encode(0);
    }
      
 
  
  }

  public function BorrarPrestamo(){
    $respuesta =  $this->Comisiones_model->BorrarPrestamo($this->input->post("idPrestamo"));
  echo json_encode($respuesta);
  
  }
  public function InsertPago()
  { 
    $id_prestamo = $this->input->post('id_prestamo');

    $pago = $this->input->post('pago');
     $usuario = $this->input->post('id_usuario');

     $dato = $this->Comisiones_model->PagoCerrado($this->input->post('id_prestamo'))->result_array();
      if(!empty($dato)){
        $monto = $dato[0]['monto'];
        $abonado = $dato[0]['suma'];
       
      
      if($abonado >= $monto -.10 && $abonado <= $monto + .10){
        
        $row = $this->Comisiones_model->UpdatePrestamo($id_prestamo);
        $row=2;
        echo json_encode($row);
  
      }else{

        $row = $this->Comisiones_model->InsertPago($id_prestamo,$usuario,$pago,$this->session->userdata('id_usuario'));

        $dato = $this->Comisiones_model->PagoCerrado($this->input->post('id_prestamo'))->result_array();
        $monto = $dato[0]['monto'];
        $abonado = $dato[0]['suma'];
        if($abonado >= $monto -.10 && $abonado <= $monto + .10){
        
          $row = $this->Comisiones_model->UpdatePrestamo($id_prestamo);
          $row=2;
          //echo json_encode($row);
    
        }else{
          $row =1;
        }


        echo json_encode($row); 
      }
      }else{
        $row = $this->Comisiones_model->InsertPago($id_prestamo,$usuario,$pago,$this->session->userdata('id_usuario'));
        echo json_encode($row); 
      }

     

    
  }

  public function getHistorialPrestamo($id)
  {
    echo json_encode($this->Comisiones_model->getHistorialPrestamo($id)->result_array());
  }

  public function prestamo_colaborador()
  {
    $this->load->view('template/header');
    $this->load->view("ventas/PanelPrestamo");
  }
  public function prestamos_historial()
  {
    $this->load->view('template/header');
    $this->load->view("ventas/prestamos_historial");
  }

  public function getPrestamoPorUser($estado)
  {

   $res["data"] = $this->Comisiones_model->getPrestamoPorUser($this->session->userdata('id_usuario'),$estado)->result_array();

    echo json_encode($res);
  }
  public function UpdateRevisionPagos()
  { 
    $id_prestamo = $this->input->post('id_prestamo');    
        $row = $this->Comisiones_model->UpdateRevisionPagos($id_prestamo);
    echo json_encode($row);
  }
  public function getHistorialPrestamo2($id)
  {
    echo json_encode($this->Comisiones_model->getHistorialPrestamo2($id)->result_array());
  }

  public function getPrestamosAllUser($estado)
  {

   $res["data"] = $this->Comisiones_model->getPrestamosAllUser($estado)->result_array();

    echo json_encode($res);
  }

  public function getHistorialPrestamoContra($id)
  {
    echo json_encode($this->Comisiones_model->getHistorialPrestamoContra($id)->result_array());
  }
  public function solicitudes_prestamo()
  {
    $this->load->view('template/header');
    $this->load->view("ventas/prestamos_solicitados");
  }
  public function bonos_historial_colaborador()
  {
    $this->load->view('template/header');
    $this->load->view("ventas/bonos_historial_colaborador");
  }

  public function getBonosX_User()
  {

   $res["data"] = $this->Comisiones_model->getBonosX_User( $this->session->userdata('id_usuario'))->result_array();

    echo json_encode($res);
  }

  public function bonos_contraloria()
  {
    $this->load->view('template/header');
    $this->load->view("ventas/bonos");
  }

  public function bonos_historial()
  {
    $this->load->view('template/header');
    $this->load->view("ventas/bonos_historial");
  }
  public function bonos_colaborador()
  {
    $this->load->view('template/header');
    $this->load->view("ventas/PanelBonos");
  }
  public function prestamos()
  {
    $this->load->view('template/header');
    $this->load->view("ventas/prestamos");
  }

  public function saveBono()
  {
    $user =  $this->input->post("usuarioid");
    $dato = $this->db->query("SELECT id_usuario FROM bonos WHERE id_usuario = $user AND estatus = 1")->result_array();
    if(count($dato) <= 0){

      $pago=str_replace("$", "", $this->input->post("pago"));
      $comas =str_replace(",", "", $pago);

      $monto=str_replace("$", "", $this->input->post("monto"));
      $coma2 =str_replace(",", "", $monto);

      $pago = $comas;
      $monto = $coma2;

      $pagoCorresp = $coma2 / $this->input->post("numeroP");
      $pagoCorresReal = number_format($pagoCorresp, 2, '.', '');

      $dat =  $this->Comisiones_model->insertar_bono($this->input->post("usuarioid"),$this->input->post("roles"),$monto,$this->input->post("numeroP"),$pagoCorresReal,$this->input->post("comentario"),$this->session->userdata('id_usuario') );

      echo json_encode($dat);
    }else{
      $data = 3;
      echo json_encode($data);
    }
  }



  public function getHistorialAbono($id)
  {
    echo json_encode($this->Comisiones_model->getHistorialAbono($id)->result_array());
  }
  public function getHistorialAbono2($id)
  {
    echo json_encode($this->Comisiones_model->getHistorialAbono2($id)->result_array());
  }

 
  public function InsertAbono()
  { 
    $id_bono = $this->input->post('id_bono');
    
    $pago = $this->input->post('pago');
     $usuario = $this->input->post('id_usuario');

     $dato = $this->Comisiones_model->BonoCerrado($this->input->post('id_bono'))->result_array();
    // echo var_dump($dato);
      if(!empty($dato)){
       
        $abonado = 0;
        for ($i=0; $i <count($dato) ; $i++) { 
         
        $abonado = $abonado + $dato[$i]['suma'];
        }
   //     echo $abonado;
        $monto = $dato[0]['monto'];
         $cuantos = count($dato);
        $n_p=($dato[$cuantos -1]['n_p'] +1);
       
      
      if($abonado >= $monto -.30 && $abonado <= $monto + .30){
        
        $row = $this->Comisiones_model->UpdateAbono($id_bono);
        $row=2;
        echo json_encode($row);
  
      }else{

        $row = $this->Comisiones_model->InsertAbono($id_bono,$usuario,$pago,$this->session->userdata('id_usuario'),$n_p);

        $dato = $this->Comisiones_model->BonoCerrado($this->input->post('id_bono'))->result_array();
        $monto = $dato[0]['monto'];
        $abonado = 0;
        for ($i=0; $i <count($dato) ; $i++) { 
         
        $abonado = $abonado + $dato[$i]['suma'];
        }
        if($abonado >= $monto -.30 && $abonado <= $monto + .30){
        
          $row = $this->Comisiones_model->UpdateAbono($id_bono);
          $row=2;
          //echo json_encode($row);
    
        }else{
          $row =1;
        }


        echo json_encode($row); 
      }
      }else{
        $row = $this->Comisiones_model->InsertAbono($id_bono,$usuario,$pago,$this->session->userdata('id_usuario'),1);
        echo json_encode($row); 
      }

     

    
  }

  public function UpdateRevision()
  { 
    $id_bono = $this->input->post('id_abono');    
        $row = $this->Comisiones_model->UpdateRevision($id_bono);
    echo json_encode($row);
  }
  public function getBonos()
  {
   $res["data"] = $this->Comisiones_model->getBonos()->result_array();

    echo json_encode($res);
  }
  public function getBonosPorUser($estado)
  {

   $res["data"] = $this->Comisiones_model->getBonosPorUser($this->session->userdata('id_usuario'),$estado)->result_array();

    echo json_encode($res);
  }
 

  public function getBonosAllUser($a,$b){
    $dat =  $this->Comisiones_model->getBonosAllUser($a,$b)->result_array();
   for( $i = 0; $i < count($dat); $i++ ){
       $dat[$i]['pa'] = 0;
   }
   echo json_encode( array( "data" => $dat));
  }
  
  public function prestamos_contraloria()
  {
    $this->load->view('template/header');
    $this->load->view("ventas/prestamos");
  }
  public function getPrestamos()
  {
        
   $res["data"] = $this->Comisiones_model->getPrestamos()->result_array();

   echo json_encode($res);
 }
 public function getPrestamosXporUsuario(){
   
   $res["data"] = $this->Comisiones_model->getPrestamosXporUsuario()->result_array();

    echo json_encode($res);
  }
  public function getUsuariosRol($rol,$opc = '')
  {
    if($opc == ''){
      echo json_encode($this->Comisiones_model->getUsuariosRol($rol)->result_array());
    }else{
      echo json_encode($this->Comisiones_model->getUsuariosRol($rol,$opc)->result_array());

    }
  }
  public function getUsuariosRol2($rol)
  {
    echo json_encode($this->Comisiones_model->getUsuariosRol2($rol)->result_array());
  }

public function getUsuariosRolBonos($rol)
  {
    echo json_encode($this->Comisiones_model->getUsuariosRolBonos($rol)->result_array());
  }

public function getUsuariosRolDU($rol)
  {
    echo json_encode($this->Comisiones_model->getUsuariosRolDU($rol)->result_array());
  }


  public function TieneAbonos($id){

 
   $respuesta = $this->Comisiones_model->TieneAbonos($id)->result_array();


  if(count($respuesta) > 0)
  {
    echo json_encode(1);
  }else{
    echo json_encode(0);
  }
     

 
 }

 public function BorrarBono(){
  // echo $this->input->post("id_bono");

  $respuesta =  $this->Comisiones_model->BorrarBono($this->input->post("id_bono"));
echo json_encode($respuesta);

}




    /**-------------------------------FIN DE BONOS Y PRESTAMOS--------------------------------------------- */
   



    /**.----------------------INICIO DESCUENTOS-------------------------------- */

public function descuentos_contraloria()
  {
    $this->load->view('template/header');
    $this->load->view("ventas/descuentos");
  }
  public function descuentos_contra()
  {
    $this->load->view('template/header');
    $this->load->view("ventas/descuentos_contra");
  }
public function descuentos_historial()
  {
    $this->load->view('template/header');
    $this->load->view("ventas/historial_descuentos");
  }


  public function getLotesOrigen($user,$valor)
  {
    echo json_encode($this->Comisiones_model->getLotesOrigen($user,$valor)->result_array());
  }
  public function getLotesOrigen2($user,$valor)
  {
    
    echo json_encode($this->Comisiones_model->getLotesOrigen2($user,$valor));
  } 

   public function getLotesOrigenResguardo($user)
  {
    echo json_encode($this->Comisiones_model->getLotesOrigenResguardo($user)->result_array());
  }

  public function getInformacionData($lote,$valor)
  {
    echo json_encode($this->Comisiones_model->getInformacionData($lote,$valor)->result_array());
  }

   public function getInformacionDataResguardo($lote)
  {
    echo json_encode($this->Comisiones_model->getInformacionDataResguardo($lote)->result_array());
  }


  
   
   
  public function saveDescuento($valor) {
      $saldo_comisiones = $this->input->post('saldo_comisiones');

    
      $LotesInvolucrados = "";

  if(floatval($valor) == 1){
    $datos =  $this->input->post("idloteorigen[]");
    $descuento = $this->input->post("monto");
    $usuario = $this->input->post("usuarioid");
    $comentario = $this->input->post("comentario");
    $pagos_apli = 0;
    $descuent0 = str_replace(",",'',$descuento);
    $descuento = str_replace("$",'',$descuent0);
    
  }else if(floatval($valor) == 2){

    $datos =  $this->input->post("idloteorigen2[]");
    $descuento = $this->input->post("monto2");
    $usuario = $this->input->post("usuarioid2");
    $comentario = $this->input->post("comentario2");
    $pagos_apli = 0;
    $descuent0 = str_replace(",",'',$descuento);
  $descuento = str_replace("$",'',$descuent0);
  
  }
  else if(floatval($valor) == 3){
    /**DESCUENTOS UNIVERSIDAD*/
    $datos =  $this->input->post("idloteorigen[]");
    $desc =  $this->input->post("monto");
    $usuario = $this->input->post("usuarioid");
    $comentario = $this->input->post("comentario");
    if($comentario == 'DESCUENTO UNIVERSIDAD MADERAS'){
      $cuantosLotes = count($datos);
      $comentario=0;
      for($i=0; $i <$cuantosLotes ; $i++) 
      { 
          $formatear = explode(",",$datos[$i]);
          $idComent = $formatear[0]; 
          $montoComent = $formatear[1];
          $pago_neodataComent = $formatear[2];
          $nameLoteComent = $formatear[3];
          $LotesInvolucrados =  $LotesInvolucrados." ".$nameLoteComent.",\n"; // Disponible: $".number_format($montoComent, 2, '.', ',')."\n"; 
      }
    }
    $pagos_apli = intval($this->input->post("pagos_aplicados"));
        $descuent0 = str_replace(",",'',$desc);
      $descuento = str_replace("$",'',$descuent0);
  }

      $cuantos = count($datos); 
      if($cuantos > 1){
        $sumaMontos = 0;
        for($i=0; $i <$cuantos ; $i++) { 
          if($i == $cuantos-1){
            $formatear = explode(",",$datos[$i]);
            $id = $formatear[0]; 
            $monto = $formatear[1];
            $pago_neodata = $formatear[2];
          $montoAinsertar = $descuento - $sumaMontos;
          $Restante = $monto - $montoAinsertar;
          $comision = $this->Comisiones_model->obtenerID($id)->result_array();
          if($valor == 2){
            $dat =  $this->Comisiones_model->update_descuentoEsp($id,$Restante,$comentario, $this->session->userdata('id_usuario'),$valor,$usuario);
          $dat =  $this->Comisiones_model->insertar_descuentoEsp($usuario,$montoAinsertar,$comision[0]['id_comision'],$comentario,$this->session->userdata('id_usuario'),$pago_neodata,$valor);
          
          }else{
            $num = $i +1;
            if($comentario == 0 && floatval($valor) == 3){
              $nameLote = $formatear[3];

              $comentario = "DESCUENTO UNIVERSIDAD MADERAS LOTES INVOLUCRADOS:  $LotesInvolucrados (TOTAL DESCUENTO: $desc ), ".$num."° LOTE A DESCONTAR $nameLote, MONTO DISPONIBLE: $".number_format(floatval($monto), 2, '.', ',').", DESCUENTO DE: $".number_format(floatval($montoAinsertar), 2, '.', ',').", RESTANTE: $".number_format(floatval($Restante), 2, '.', ',')."    ";
            }else{
              $comentario = $this->input->post("comentario");
            }
            $dat =  $this->Comisiones_model->update_descuento($id,$montoAinsertar,$comentario, $saldo_comisiones, $this->session->userdata('id_usuario'),$valor,$usuario,$pagos_apli);
          $dat =  $this->Comisiones_model->insertar_descuento($usuario,$Restante,$comision[0]['id_comision'],$comentario,$this->session->userdata('id_usuario'),$pago_neodata,$valor);
          }
          }else{
            $formatear = explode(",",$datos[$i]);
            $id=$formatear[0];
            $monto = $formatear[1]; 
            $pago_neodata = $formatear[2];
            if($comentario == 0 && floatval($valor) == 3){
            $nameLote = $formatear[3];
            
              $num = $i +1;
              $comentario = "DESCUENTO UNIVERSIDAD MADERAS LOTES INVOLUCRADOS:  $LotesInvolucrados ( TOTAL DESCUENTO $desc ), ".$num."° LOTE A DESCONTAR $nameLote, MONTO DISPONIBLE: $".number_format(floatval($monto), 2, '.', ',').", DESCUENTO DE: $".number_format(floatval($monto), 2, '.', ',').", RESTANTE: $".number_format(floatval(0), 2, '.', ',')." ";
            }else{
              $comentario = $this->input->post("comentario");
            }
          $dat = $this->Comisiones_model->update_descuento($id,0,$comentario, $saldo_comisiones, $this->session->userdata('id_usuario'),$valor,$usuario, $pagos_apli);
          $sumaMontos = $sumaMontos + $monto;
          }

    
        }
  

      }else{
          $formatear = explode(",",$datos[0]);
          $id = $formatear[0];
          $monto = $formatear[1];
          $pago_neodata = $formatear[2];
          $montoAinsertar = $monto - $descuento;
          $Restante = $monto - $montoAinsertar;

          $comision = $this->Comisiones_model->obtenerID($id)->result_array();

          if($valor == 2){

          $dat =  $this->Comisiones_model->update_descuentoEsp($id,$montoAinsertar,$comentario, $this->session->userdata('id_usuario'),$valor,$usuario);
            $dat =  $this->Comisiones_model->insertar_descuentoEsp($usuario,$Restante,$comision[0]['id_comision'],$comentario,$this->session->userdata('id_usuario'),$pago_neodata,$valor);
          }else{
            $dat =  $this->Comisiones_model->update_descuento($id,$descuento,$comentario, $saldo_comisiones, $this->session->userdata('id_usuario'),$valor,$usuario,$pagos_apli);
            $dat =  $this->Comisiones_model->insertar_descuento($usuario,$montoAinsertar,$comision[0]['id_comision'],$comentario,$this->session->userdata('id_usuario'),$pago_neodata,$valor);
  
          }
      }
      echo json_encode($dat);    
    }

public function getDescuentos2()
{
  $res["data"] = $this->Comisiones_model->getDescuentos2()->result_array();
  echo json_encode($res);
}

public function saveDescuentoch()
{
    $usuario = $this->input->post("usuarioid2");
    $descuento = $this->input->post("descuento");
    $comentario = $this->input->post("comentario2"); 
    $monto0 = str_replace(",",'',$this->input->post('pago_ind01'));
    $monto = str_replace("$",'',$monto0);
    $dat =  $this->Comisiones_model->insertar_descuentoch($usuario, $descuento, $comentario,  $monto, $this->session->userdata('id_usuario')); 
    echo json_encode($dat);
}
    public function getDescuentos()
    {
      $res["data"] = $this->Comisiones_model->getDescuentos()->result_array();
      echo json_encode($res);
    }
    public function getDescuentosCapital()
    {
      $res["data"] = $this->Comisiones_model->getDescuentosCapital()->result_array();
      echo json_encode($res);
    }

    public function getDescuentosCapitalpagos(){
        echo json_encode( $this->Comisiones_model->getDescuentosCapital( $this->input->post("id_usuario") ) );
    }

    public function getRetiros($user,$opc)
    {
      $res["data"] = $this->Comisiones_model->getRetiros($user,$opc)->result_array();
      echo json_encode($res);
    }

    public function getHistorialDescuentos($proyecto,$condominio)
    {
      $res["data"] = $this->Comisiones_model->getHistorialDescuentos($proyecto,$condominio)->result_array();
      echo json_encode($res);
    }

    public function getHistorialRetiros($proyecto,$condominio)
    {
      $res["data"] = $this->Comisiones_model->getHistorialRetiros($proyecto,$condominio)->result_array();
      echo json_encode($res);
    }

    


     public function BorrarDescuento(){

  $respuesta =  $this->Comisiones_model->BorrarDescuento($this->input->post("id_descuento"));
echo json_encode($respuesta);

}

     public function UpdateDescuento(){

  $respuesta =  $this->Comisiones_model->UpdateDescuento($this->input->post("id_descuento"));
echo json_encode($respuesta);

}
public function UpdateRetiro(){
  
  $opcion =  $this->input->post("opcion");
  $id = $this->input->post("id_descuento");
  $data = [];
  if($opcion == 'Autorizar'){
    $data = ['estatus' => 2];
  }elseif($opcion == 'Borrar'){
    $motivo =  $this->input->post("motivodelete");
    $data = ['estatus' => 3,
            'motivodel' => $motivo];
  }elseif($opcion == 'Rechazar'){
    $motivo =  $this->input->post("motivodelete");
    $data = ['estatus' => 4,
            'motivodel' => $motivo];
  }elseif($opcion == 'Actualizar'){
    $monto =  $this->input->post("monto");
    $concepto = $this->input->post("conceptos");
    $estado = $this->input->post("estatus");
    
    $data = ['monto' => $monto,
              'conceptos' => $concepto,
              'estatus' => $estado];
  }

  $respuesta =  $this->Comisiones_model->UpdateRetiro($data,$id,$opcion);
echo json_encode($respuesta);

}

   public function getDatosHistorialPostventa()
  {
   $res["data"] = $this->Comisiones_model->getDatosHistorialPostventa()->result_array();

    echo json_encode($res);
  }

  public function comisionistasPorLote($idLote){
    $res = $this->Comisiones_model->comisionistasPorLote($idLote)->result_array();
    echo json_encode($res);
  }
  
  public function historialTotalLote()
  {
    $this->load->view('template/header');
    $this->load->view("ventas/historial_postventa");
  }

  /**REPORTE JOSH */
  public function reportPz()
  {
    $this->load->view('template/header');
    $this->load->view("ventas/reportAllpzr28");
  }


  
  public function getDataDispersionPagoReport()
  {
    $datos = array();
    $datos = $this->Comisiones_model->getDataDispersionPagoReport();
    if ($datos != null) {
      echo json_encode($datos);
    } else {
      echo json_encode(array());
    }
  }
  /**-------------- */




    public function cobranza_reporte()
  {
    $this->load->view('template/header');
    $this->load->view("ventas/cobranza_reporte");
  }

      public function cobranza_ranking()
  {
    $this->load->view('template/header');
    $this->load->view("ventas/cobranza_ranking");
  }


    public function getDatosCobranzaRanking($a,$b)
  {
    $datos = array();
    $datos = $this->Comisiones_model->getDatosCobranzaRanking($a,$b);
    if ($datos != null) {
      echo json_encode($datos);
    } else {
      echo json_encode(array());
    }
  }

   public function getDatosCobranzaReporte($a,$b)
  {
    $datos = array();
    $datos = $this->Comisiones_model->getDatosCobranzaReporte($a,$b);
    if ($datos != null) {
      echo json_encode($datos);
    } else {
      echo json_encode(array());
    }
  }




    public function cobranza_dinamic()
  {
    $this->load->view('template/header');
    $this->load->view("ventas/cobranza_dinamic");
  }

 


   public function getDatosCobranzaDimamic($a,$b,$c,$d){
      $dat =  $this->Comisiones_model->getDatosCobranzaDimamic($a,$b,$c,$d)->result_array();
     for( $i = 0; $i < count($dat); $i++ ){
         $dat[$i]['pa'] = 0;
     }
     echo json_encode( array( "data" => $dat));
    }



        public function cobranza_indicador()
  {
    $this->load->view('template/header');
    $this->load->view("ventas/cobranza_indicador");
  }

 


   public function getDatosCobranzaIndicador($a,$b){
      $dat =  $this->Comisiones_model->getDatosCobranzaIndicador($a,$b)->result_array();
     for( $i = 0; $i < count($dat); $i++ ){
         $dat[$i]['pa'] = 0;
     }
     echo json_encode( array( "data" => $dat));
    }
    

  public function listSedes()
    {
        echo json_encode($this->Comisiones_model->listSedes()->result_array());
    }

  public function listGerentes($sede)
    {
        echo json_encode($this->Comisiones_model->listGerentes($sede)->result_array());
    }

    
 function agregar_comentarios(){
  $respuesta = array( FALSE );
  if($this->input->post("comentario")){
     $respuesta = array($this->Comisiones_model->agregar_comentarios($this->input->post("lote"), $this->input->post("cliente"), 0, $this->input->post("fecha"), $this->input->post("comentario")));
  }
  echo json_encode( $respuesta );
}


    public function getDirectivos() {

        $data = $this->Comisiones_model->getDirectivos();
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
        exit;
//      for ($i=0; $i < count($data['condominios']); $i++) {
//          echo "<option idCondominio='".$data['condominios'][$i]['idCondominio']."' value='".$data['condominios'][$i]['idCondominio']."'>".$data['condominios'][$i]['nombre']." "."(".$data['condominios'][$i]['nombreResidencial'].")"."</option>";
//      }
    }
  


      public function getDirectivos2() {

        $data = $this->Comisiones_model->getDirectivos2();
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
        exit;
//      for ($i=0; $i < count($data['condominios']); $i++) {
//          echo "<option idCondominio='".$data['condominios'][$i]['idCondominio']."' value='".$data['condominios'][$i]['idCondominio']."'>".$data['condominios'][$i]['nombre']." "."(".$data['condominios'][$i]['nombreResidencial'].")"."</option>";
//      }
    }
  

    public function changeCommissionAgent()
    {
        $this->load->view('template/header');
        $this->load->view("ventas/changeCommissionAgent");
    }

    public function getMktdCommissionsList()
    {
        $datos = array();
        $datos = $this->Comisiones_model->getMktdCommissionsList();
        if ($datos != null) {
            echo json_encode($datos);
        } else {
            echo json_encode(array());
        }
    }

    public function addRemoveMktd()
    {
        $type_transaction = $this->input->post("type_transaction");
        $comments = $this->input->post("comments");
        $id_lote = $this->input->post("id_lote");
        $id_cliente = $this->input->post("id_cliente");
        $clientes_data = array(
            "fecha_modificacion" => date("Y-m-d H:i:s"),
            "modificado_por" => $this->session->userdata('id_usuario')
        );

        $lote_data = $this->Comisiones_model->getLoteInformation($id_lote);
        $insert_comisiones_data = array(
            "id_lote" => $lote_data[0]['idLote'],
            "id_usuario" => $type_transaction == 1 ? 4394 : 4824,
            "comision_total" => $lote_data[0]['totalNeto2'] * 0.01,
            "estatus" => 1,
            "observaciones" => $comments,
            "evidencia" => NULL,
            "factura" => NULL,
            "creado_por" => $this->session->userdata('id_usuario'),
            "fecha_creacion" => date("Y-m-d H:i:s"),
            "porcentaje_decimal" => 1,
            "fecha_autorizacion" => date("Y-m-d H:i:s"),
            "rol_generado" => $type_transaction == 1 ? 38 : 45,
            "descuento" => 0,
            "modificado_por" =>$this->session->userdata('id_usuario')
        );
        if ($type_transaction == 1) { // ADD MKTD

          $commission_data = $this->Comisiones_model->getCommisionInformation($id_lote); // MJ: SE OBTIENEN TODOS LOS REGISTROS DE COMISIÓN
          if (COUNT($commission_data) > 0) { // MJ: SE ENCONTRÓ REGISTRO EN COMISIONES
              //$cce_data = $this->Comisiones_model->getCompanyCommissionEntry($id_lote, 4394); // MJ: SE BUSCA EL REGISTRO DE COMISIÓN DE EMPRESA SI HAY UNO YA NO SE INSERTA
              $cce_data = $this->Comisiones_model->getCompanyCommissionEntryEmpMktd($id_lote);
              if (COUNT($cce_data) <= 0) { // MJ: SI HAY REGISTRO DE COMISIONES, ENTONCES NO INSERTAMOS LA EMPRESA SINO SÍ 
                $this->Comisiones_model->addRecord("comisiones", $insert_comisiones_data); // MJ: LLEVA 2 PARÁMETROS $table, $data                
              } else {
                $countRegister = count($cce_data);
                if(count($cce_data) == 1){
                    if($cce_data[0]['id_usuario'] == 4824){
                      //EMPRESA
                      //VERIFICAR SI HAY PAGOS DE EMPREA, SI HAY PAGOS QUE NO SEAN NUEVOS, SE TOPA LA EMPRESA SI NO SE CAMBIOA DE USUARIO
                      $pci_data = $this->Comisiones_model->getIndividualPaymentInformation($id_lote, 4824);
                      if (COUNT($pci_data) > 0) { // MJ: SE ENCONTRARON REGISTROS EN pago_comision_ind CON ESTATUS PAGADO
                       $respuesta = $this->Comisiones_model->ToparComision($pci_data[0]['id_comision'],$comments);
                         $this->Comisiones_model->addRecord("comisiones", $insert_comisiones_data); // MJ: LLEVA 2 PARÁMETROS $table, $data                
                      } else{
                       // MJ: SE OBTIENEN TODOS LOS PAGOS DISTINTOS A 11 Y 8
                       $pci_others_data = $this->Comisiones_model->getIndividualPaymentWPInformation($id_lote, 4824);

                        if(count($pci_others_data) > 0){
                          //HAY PAGOS QUE SE PUEDEN EDITAR
                          $update_pago_data = array(
                            "id_usuario" => 4394,
                            "modificado_por" =>$this->session->userdata('id_usuario')

                          );
                          $update_comisiones_data = array(
                            "id_usuario" => 4394,
                            "rol_generado" => 38,
                            "modificado_por" =>$this->session->userdata('id_usuario')    
                          );
                      $this->Comisiones_model->updateRecord("pago_comision_ind", $update_pago_data, "id_comision", $pci_others_data[0]['id_comision']); // MJ: LLEVA 4 PARÁMETROS $table, $data, $key, $value
                      $this->Comisiones_model->updateRecord("comisiones", $update_comisiones_data, "id_comision", $pci_others_data[0]['id_comision']); // MJ: LLEVA 4 PARÁMETROS $table, $data, $key, $value
                        }else{
                          $update_comisiones_data = array(
                            "id_usuario" => 4394,
                            "rol_generado" => 38,
                            "modificado_por" =>$this->session->userdata('id_usuario')    
                          );
                          $this->Comisiones_model->updateRecord("comisiones", $update_comisiones_data, "id_comision", $pci_others_data[0]['id_comision']); // MJ: LLEVA 4 PARÁMETROS $table, $data, $key, $value
                        }
                    }
                    }else{

                    }
                }
                
              }
            }
            // UPDATE CLIENT PROSPECTING PLACE
            $clientes_data["lugar_prospeccion"] = 6;
            $clientes_data["plan_comision"] = 0;
            $this->Comisiones_model->updateRecord("clientes", $clientes_data, "id_cliente", $lote_data[0]['idCliente']); // MJ: LLEVA 4 PARÁMETROS $table, $data, $key, $value
            echo json_encode(1);   
        } else if ($type_transaction == 2) { // REMOVE MKTD
          date_default_timezone_set('America/Mexico_City');
          $flag=0;
          $hoy = date('Y-m-d H:i:s');
          $controversia = $this->Comisiones_model->getEvidenceInformation($id_lote,$lote_data[0]['idCliente']);

            $commission_data = $this->Comisiones_model->getCommisionInformation($id_lote); // MJ: SE OBTIENEN TODOS LOS REGISTROS DE COMISIÓN
            if (COUNT($commission_data) > 0) { // MJ: SE ENCONTRARON REGISTROS EN pago_comision_ind CON ESTATUS PAGADO
              //MO - SI SE ENCONTRO REGISTRO EN COMISIONES SE TOPA LA COMISIÓN 
                for ($i=0; $i <count($commission_data) ; $i++) { 
                  if($commission_data[$i]['id_usuario'] == 4394){
                    $this->Comisiones_model->ToparComision($commission_data[$i]['id_comision'],$comments);
                  }
                  if($commission_data[$i]['id_usuario'] == 4824){
                    $flag =1;

                  }
                }
                if($flag == 0){
                  $this->Comisiones_model->addRecord("comisiones", $insert_comisiones_data,1); // MJ: LLEVA 2 PARÁMETROS $table, $data 
                }

                //ACTUALIZAR CLIENTES Y PROSPECTOS
                if(count($controversia) > 0)  
            {
              $this->Comisiones_model->updateControversia($id_lote,$lote_data[0]['idCliente']);
            }
             
                $update_client_data = array(
                  "lugar_prospeccion" => 11,
                  "modificado_por" => 1,
                  "fecha_modificacion" => $hoy        
                );
                $this->Comisiones_model->updateRecord("clientes", $update_client_data, "id_cliente", $lote_data[0]['idCliente']); // MJ: LLEVA 4 PARÁMETROS $table, $data, $key, $value
                $this->Comisiones_model->updateRecord("prospectos", $update_client_data, "id_prospecto", $lote_data[0]['id_prospecto']); // MJ: LLEVA 4 PARÁMETROS $table, $data, $key, $value

                // MJ: SE TOPA LA COMISIÓN DE MKTD TOMANDO EN CUANTO EL TOTAL DE ABONOS EN ESTATUS 11
            } else{ // MJ: NO SE ENCONTRARON REGISTROS EN pago_comision_ind CON ESTATUS PAGADO
             
            //     
            if(count($controversia) > 0)  
            {
              $this->Comisiones_model->updateControversia($id_lote,$lote_data[0]['idCliente']);
            }
                        
              $update_client_data = array(
                "lugar_prospeccion" => 11,
                "modificado_por" => 1,
                "fecha_modificacion" => $hoy        
              );
              $this->Comisiones_model->updateRecord("clientes", $update_client_data, "id_cliente", $lote_data[0]['idCliente']); // MJ: LLEVA 4 PARÁMETROS $table, $data, $key, $value
              $this->Comisiones_model->updateRecord("prospectos", $update_client_data, "id_prospecto", $lote_data[0]['id_prospecto']); // MJ: LLEVA 4 PARÁMETROS $table, $data, $key, $value

              }
            // MJ: INSERT PARA AGREGAR LA EMPRESA A COMISIONES

            // MJ: SE CAMBIA LUGAR DE PROSPECCIÓN DEL CLIENTE DE 6 A 11
            if ($this->session->userdata('id_rol') == 19 || $this->session->userdata('id_rol') == 20 || $this->session->userdata('id_rol') == 28) {
              $insert_comentariosMktd_data = array('idLote' => $id_lote, 'observacion' => $comments, 'fecha_creacion' => date('Y-m-d H:i:s'), 'creado_por' => $this->session->userdata('id_usuario'), 'id_cliente' => $id_cliente);
              $this->Comisiones_model->addRecord("comentariosMktd", $insert_comentariosMktd_data); // MJ: LLEVA 2 PARÁMETROS $table, $data
            }

            echo json_encode(1);
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

      public function carga_listado_factura(){
        echo json_encode( $this->Comisiones_model->get_solicitudes_factura( $this->input->post("idResidencial"), $this->input->post("id_usuario") ) );
    }

 /**-------------------------MKTD COMPARTIDAS------------------------ */

 public function MKTD_compartida()
 {

   /**SE VERIFICA SI MKTD TIENE PAGOS DE ESTE LOTE EN OTROS ESTATUS QUE NO SEA NUEVO */
   $verificar = $this->Comisiones_model->VerificarMKTD($this->input->post('idLote'))->result_array();
//print_r ($verificar);
   if(count($verificar) == 0){
     $row = $this->Comisiones_model->MKTD_compartida($this->input->post('idLote'),$this->input->post('plaza1'),$this->input->post('plaza2'),$this->session->userdata('id_usuario'));

   }else{
$row = 3;
   }


   echo json_encode($row);
 }
 public function getDatosNuevasCompartidas(){
   $dat =  $this->Comisiones_model->getDatosNuevasCompartidas()->result_array();
  for( $i = 0; $i < count($dat); $i++ ){
      $dat[$i]['pa'] = 0;
  }
  echo json_encode( array( "data" => $dat));
 }
 /**----------------------------------------------------- */
/**-------------------------------------PRECIO LOTE MKTD--------------------------------- */
public function SavePrecioLoteMKTD(){
  $precio = str_replace(",",'',$this->input->post('precioL'));
  $idLote = $this->input->post('idLote');
  $Consulta = $this->Comisiones_model->getPrecioMKTD($idLote)->result_array();
  if(count($Consulta) == 0){
    //INSERT
    $row = $this->Comisiones_model->insert_MKTD_precioL($idLote,$precio,$this->session->userdata('id_usuario'));

  }else{
    //UPDATE
    $row = $this->Comisiones_model->Update_MKTD_precioL($idLote,$precio,$this->session->userdata('id_usuario'));

  }
  echo json_encode($row);
}




 function getDatosColabMktdCompartida($sede, $plan,$sede1,$sede2){
    $datos = $this->Comisiones_model->getDatosColabMktdCompartida($sede, $plan,$sede1,$sede2)->result_array();
    $cuantos19=0;
    for ($i=0; $i < count($datos) ; $i++) {
      if($datos[$i]['id_opcion'] == 19) 
      $cuantos19=$cuantos19+1;
    }
 $datos[0]['valor'] = $cuantos19;
    echo json_encode($datos);
  }
/**---------------------------------------------------------------------------------------- */

  /**RESGUARDO */
  public function saveRetiro()
  {
    $opcion = $this->input->post("opc");
    $replace = [",","$"];
  
        
    $descuento = str_replace($replace,"",$this->input->post("monto"));
    
    $usuario = $this->input->post("usuarioid");
    $comentario = $this->input->post("comentario");
   $dat =  $this->Comisiones_model->insertar_retiro($usuario,$descuento,$comentario,$this->session->userdata('id_usuario'),$opcion);
   
     echo json_encode($dat);
    
    
    }
  
  
  
  
  public function getHistoriRetiros($id)
      {
          echo json_encode($this->Comisiones_model->getHistoriRetiros($id)->result_array());
      }
  
  
  

    /**-----------------------REUBICACIÓN-------------------------- */

public function lista_lote($condominio){
  echo json_encode($this->Asesor_model->get_lote_lista($condominio)->result_array());
}

public function SaveReubicacion(){

  $datos = explode(",",$this->input->post('filtro55'));
  $loteNuevo = $datos[0];
  $precioNuevo = $datos[1];
  $idloteAnterior = $this->input->post('idlote1');
  $comentario = $this->input->post('comentarioR');
  $row = $this->Comisiones_model->Update_lote_reubicacion($loteNuevo,$idloteAnterior,$precioNuevo,$this->session->userdata('id_usuario'),$comentario);
echo json_encode($row);
}
public function getComisionesLoteSelected($idLote){
  echo json_encode($this->Comisiones_model->getComisionesLoteSelected($idLote)->result_array());
}
/**------------------------------------------------------------- */
/**-------------------------------BONOS BAJAS-------------------------------------------- */
public function BonosBaja()
{
  $this->load->view('template/header');
  $this->load->view("ventas/BonosBaja");
}
/**-------------------------------------------------------------------------------------- */
function getDatosNuevo(){
  echo json_encode($this->Comisiones_model->getDatosNuevo()->result_array());
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


public function getMontoDispersado(){
  echo json_encode($this->Comisiones_model->getMontoDispersado()->result_array(), JSON_NUMERIC_CHECK);
}

public function getPagosDispersado(){
  echo json_encode($this->Comisiones_model->getPagosDispersado()->result_array(), JSON_NUMERIC_CHECK);
}

public function getLotesDispersado(){
  echo json_encode($this->Comisiones_model->getLotesDispersado()->result_array(), JSON_NUMERIC_CHECK);
}


public function getMontoDispersadoDates(){
  $fechaInicio = explode('/', $this->input->post("fecha1"));
  $fechaFin = explode('/', $this->input->post("fecha2"));
  $fecha1 = date("Y-m-d", strtotime("{$fechaInicio[2]}-{$fechaInicio[1]}-{$fechaInicio[0]}"));
  $fecha2 = date("Y-m-d", strtotime("{$fechaFin[2]}-{$fechaFin[1]}-{$fechaFin[0]}"));

  $datos["datos_monto"] = $this->Comisiones_model->getMontoDispersadoDates($fecha1, $fecha2)->result_array();
  $datos["datos_pagos"] = $this->Comisiones_model->getPagosDispersadoDates($fecha1, $fecha2)->result_array();
  $datos["datos_lotes"] = $this->Comisiones_model->getLotesDispersadoDates($fecha1, $fecha2)->result_array();

  echo json_encode($datos);

}


  public function historial_pagado()
  {
    $this->load->view('template/header');
    $this->load->view("ventas/historial_pagadoMKTD");
  }



// public function getPagosDispersadoDates($fecha1, $fecha2){
//   echo json_encode($this->Comisiones_model->getPagosDispersadoDates($fecha1, $fecha2)->result_array(), JSON_NUMERIC_CHECK);
// }

// public function getLotesDispersadoDates($fecha1, $fecha2){
//   echo json_encode($this->Comisiones_model->getLotesDispersadoDates($fecha1, $fecha2)->result_array(), JSON_NUMERIC_CHECK);
// }


public function lista_proyecto($param)
{
  // $this->validateSession();
  $id_user = $this->session->userdata('id_usuario');

  if($param == 0){
    $filtro_00 = '';
  }else{
    $filtro_00 = ' AND pci.estatus = $param';
  }

  switch ($this->session->userdata('id_rol')) {
    case '1':
    case '2':
    case '3':
    case '7':
    case '9':
    // case '1':
      $filtro_post = ' WHERE res.status = 1 AND com.id_usuario = '.$id_user.' '.$filtro_00;
      break;
    
    default:
      $filtro_post = ' WHERE res.status = 1 '.$filtro_00;
      break; 
  }


    echo json_encode($this->Comisiones_model->get_proyectos_comisiones($filtro_post)->result_array());
}


 public function lista_roles()
    {
      echo json_encode($this->Comisiones_model->get_lista_roles()->result_array());
    }
public function lista_sedes()
    {
      echo json_encode($this->Comisiones_model->get_lista_sedes()->result_array());
    }
        /**-----------------FACTURAS----------------------------------------- */
        public function SubirPDF(){
          if($this->input->post('opc') == 3){
           $idpago = $this->input->post('id2');
         
         
          }elseif( $this->input->post('opc') == 2 ){
            //ya no aplica
           $uuid = $this->input->post('uuid2');
           $motivo = $this->input->post('motivo');
           $datos = $this->Comisiones_model->RegresarFactura($uuid,$motivo);
         
         
         
           //echo $this->input->post('uuid2');
         if($datos == true){
           echo json_encode(1);
         }else{
           echo json_encode(0);
         }
         
         }else if($this->input->post('opc') == 1){
             $uploadFileDir = './UPLOADS/PDF/';
                 date_default_timezone_set('America/Mexico_City');
                 $datos = explode(".",$this->input->post('xmlfile'));
                 $uuid = $this->input->post('uuid');
                 $nombrefile = $datos[0];
                 //$hoy = date("Y-m-d");
            
           $datos = $this->Comisiones_model->BanderaPDF($uuid);
         
         
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
                                 
           }elseif($this->input->post('opc') == 4){
         
             $id_user = $this->input->post('id_user');
             $motivo = $this->input->post('motivo');
           $uuid =$this->input->post('uuid2');
           $datos = $this->Comisiones_model->GetPagosFacturas($uuid)->result_array();
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
                  $datos_xml = $this->Comisiones_model->leerxml( $xml_subido['full_path'], TRUE );
                  
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
                      $this->Comisiones_model->update_refactura($id_com, $datos_xml,$id_user,$datos[$i]['id_factura']);
                      //$this->Comisiones_model->update_acepta_solicitante($id_com);
                    $this->db->query("INSERT INTO historial_comisiones VALUES (".$id_com.", ".$this->session->userdata('id_usuario').", GETDATE(), 1, 'CONTRALORÍA REFACTURÓ, MOTIVO: ".$motivo." ')");
         
                    }
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
         
                //$this->Usuarios_modelo->Update_OPN($this->session->userdata('id_usuario'));
                if($resultado){
                 echo json_encode( 1 );
         
                }else{
                 echo json_encode(0);
         
                }
           }
                                 //$response = $this->Usuarios_modelo->SaveCumplimiento($this->session->userdata('id_usuario'),$newFileName);
                                 
         
         }
         
        function pausar_solicitud(){
          $respuesta = array( FALSE );
          if($this->input->post("id_pago")){
              $respuesta = array( $this->Comisiones_model->update_estatus_pausa( $this->input->post("id_pago_i"), $this->input->post("observaciones")));
          }
            echo json_encode( $respuesta );
        }
        function pausar_solicitudM(){
          $respuesta = array( FALSE );
          if($this->input->post("id_pago")){
            $respuesta = array( $this->Comisiones_model->update_estatus_pausaM( $this->input->post("id_pago_i"), $this->input->post("observaciones")));
          }
          echo json_encode( $respuesta );
        }
        /**---------------------------------------- */
    
    
    
  public function saldos_Intmex()
  {
    $this->load->view('template/header');
    $this->load->view("ventas/saldos_Intmex");
  }

    public function listEmpresa()
    {
        echo json_encode($this->Comisiones_model->listEmpresa()->result_array());
    }

        public function listRegimen()
    {
        echo json_encode($this->Comisiones_model->listRegimen()->result_array());
    }




   public function getDatosSaldosIntmex($a,$b){
      $dat =  $this->Comisiones_model->getDatosSaldosIntmex($a,$b)->result_array();
     for( $i = 0; $i < count($dat); $i++ ){
         $dat[$i]['pa'] = 0;
     }
     echo json_encode( array( "data" => $dat));
    }
    

    /**CAMBIAR PRECIO LOTE */
    public function Ajustes()
{
  $this->load->view('template/header');
  $this->load->view("ventas/UpdatePrecioLote");
}


public function getPagosByComision($id_comision)
{
  $respuesta = $this->Comisiones_model->getPagosByComision($id_comision);
  echo json_encode($respuesta); 
}
public function ToparComision($id_comision,$idLote = '')
{
  $comentario = $this->input->post("comentario");
  $respuesta = $this->Comisiones_model->ToparComision($id_comision,$comentario);
 // if($idLote != '' ){
  //  $this->Comisiones_model->RecalcularMontos($idLote);
 //}
  echo json_encode($respuesta); 
}




public function SaveAjuste($opc = '')
{
 $id_comision = $this->input->post('id_comision');
 $id_usuario = $this->input->post('id_usuario');
 $id_lote =    $this->input->post('id_lote');
 $porcentaje = $pesos=str_replace("%", "", $this->input->post('porcentaje'));
 $porcentaje_ant = $this->input->post('porcentaje_ant');

 $comision_total = $pesos=str_replace(",", "", $this->input->post('comision_total'));

 $respuesta = $this->Comisiones_model->SaveAjuste($id_comision,$id_lote,$id_usuario,$porcentaje,$porcentaje_ant,$comision_total,$opc);

 
 echo json_encode($respuesta); 
}



    public function historialDescuentos()
{
  $this->load->view('template/header');
  $this->load->view("ventas/historialCapitalFechas");
}




function topar_descuentos(){
  // $respuesta = array( FALSE );

  // if($this->input->post("id_pago_i")){
    $respuesta = array($this->Comisiones_model->update_DU_topar($this->input->post("id_pago"), $this->input->post("observaciones"), $this->input->post("monto") ));
  // }
  echo json_encode( $respuesta );
}



public function getPagosFacturasBaja()
{
  $dat =  $this->Comisiones_model->getPagosFacturasBaja()->result_array();
  for ($i = 0; $i < count($dat); $i++) {
    $dat[$i]['pa'] = 0;
  }
  echo json_encode(array("data" => $dat));
}


public function getPagosByProyect($proyect = '',$formap = ''){
  if(empty($proyect)){
    echo json_encode($this->Comisiones_model->getPagosByProyect());

  }else{
    echo json_encode($this->Comisiones_model->getPagosByProyect($proyect,$formap));

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

      $up_b = $this->Comisiones_model->update_acepta_INTMEX($id_pago_i);
      $ins_b = $this->Comisiones_model->insert_phc($data);

    if($up_b == true && $ins_b == true){
    $data_response = 1;
    echo json_encode($data_response);
    } else {
    $data_response = 0;
    echo json_encode($data_response);
    }
  }

public function getDesarrolloSelectINTMEX($a = ''){
  if($a == ''){
    echo json_encode($this->Comisiones_model->getDesarrolloSelectINTMEX()->result_array());

  }else{
    echo json_encode($this->Comisiones_model->getDesarrolloSelectINTMEX($a)->result_array());

  }
}
 
  public function getLideres($lider)
  {
    echo json_encode($this->Comisiones_model->getLideres($lider)->result_array());
  }
  public function AddVentaCompartida(){
    $datosAse = explode(",",$this->input->post('usuarioid5'));
    $coor = $this->input->post('usuarioid6');
    $ger = $this->input->post('usuarioid7');
    $sub = $this->input->post('usuarioid8');
    $id_cliente = $this->input->post('id_cliente');
    $id_lote = $this->input->post('id_lote');
    $respuesta = array($this->Comisiones_model->AddVentaCompartida($datosAse[0],$coor,$ger,$sub,$id_cliente,$id_lote));
    echo json_encode($respuesta[0]);
  }


  public function CancelarDescuento(){
    $id_pago = $this->input->post('id_pago');
    $motivo =  $this->input->post('motivo');
    $monto =  $this->input->post('monto');
    $respuesta = array($this->Comisiones_model->CancelarDescuento($id_pago,$motivo,$monto));
    echo json_encode( $respuesta[0]);
  
  }







 public function general_Intmex()
  {
    $this->load->view('template/header');
    $this->load->view("ventas/general_Intmex");
  }


      public function getDatosGralInternomex(){
      $dat =  $this->Comisiones_model->getDatosGralInternomex()->result_array();
     for( $i = 0; $i < count($dat); $i++ ){
         $dat[$i]['pa'] = 0;
     }
     echo json_encode( array( "data" => $dat));
    }




  public function lista_estatus()
  {
    $data = $this->Comisiones_model->getListaEstatusHistorialEstatus();
    echo json_encode($data);
  }

public function getDatosHistorialPagoEstatus($proyecto, $condominio, $usuario) {

      ini_set('max_execution_time', 900);
      set_time_limit(900);
      ini_set('memory_limit','2048M');

      
  $dat =  $this->Comisiones_model->getDatosHistorialPagoEstatus($proyecto,$condominio, $usuario)->result_array();
 for( $i = 0; $i < count($dat); $i++ ){
     $dat[$i]['pa'] = 0;
 }
 echo json_encode( array( "data" => $dat));
}


 public function historial_estatus()
  {
    $this->load->view('template/header');
    $this->load->view("ventas/historial_estatus");
  }
 
 

     public function InsertNeo(){
      $lote_1 =  $this->input->post("idLote");
      $bonificacion =  $this->input->post("bonificacion");
      $penalizacion = $this->input->post("penalizacion");
      $nombreLote =  $this->input->post("nombreLote");
      $disparador =  $this->input->post("id_disparador");
      $ooam = $this->input->post("ooamValor");
      $nombreOtro = $this->input->post("nombreOtro");

      $responses = $this->Comisiones_model->validateDispersionCommissions($lote_1);
      $totalFilas = $responses->num_rows(); 
 
      if((!empty($responses) && $totalFilas == 0 && ($disparador == '0' || $disparador == 0))||($disparador == '1' || $disparador == 1)||($disparador == '' || $disparador == 3)) {
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
        // 1.- validar tipo venta
        if($tipo_venta_insert <= 6 || $tipo_venta_insert == 11 || $tipo_venta_insert == 13){
          if($porcentaje_abono < 8){
            $PorcentajeAsumar = 8 - $porcentaje_abono;
            $banderita=1;
            $porcentaje_abono =8;
          }
        }
        
        $pivote=0;

        for ($i=0; $i <count($id_usuario) ; $i++) { 

          if($banderita == 1 && $id_rol[$i] == 45){
            $banderita=0;
            $comision_total[$i] = $totalNeto2 * (($porcentaje[$i] + $PorcentajeAsumar) / 100 );  
            $porcentaje[$i] = $porcentaje[$i] + $PorcentajeAsumar;
          }

          if($id_rol[$i] == 1){
            $pivote=str_replace($replace,"",$comision_total[$i]);
          }

          if($penalizacion == 1 && ($id_rol[$i] == 3 || $id_rol[$i] == 7 || $id_rol[$i] == 9)){
            $respuesta = $this->Comisiones_model->InsertNeoPenalizacion($lote_1,$id_usuario[$i],str_replace($replace,"",$comision_total[$i]),$this->session->userdata('id_usuario'),$porcentaje[$i],str_replace($replace,"",$comision_dar[$i]),str_replace($replace,"",$pago_neo),$id_rol[$i],$idCliente,$tipo_venta_insert,$nombreLote);
          } else{
            $respuesta = $this->Comisiones_model->InsertNeo($lote_1,$id_usuario[$i],str_replace($replace,"",$comision_total[$i]),$this->session->userdata('id_usuario'),$porcentaje[$i],str_replace($replace,"",$comision_dar[$i]),str_replace($replace,"",$pago_neo),$id_rol[$i],$idCliente,$tipo_venta_insert,$ooam, $nombreOtro);
          }
          // echo '<br>'.$respuesta.'<br>';
        }
        
        $respuesta = $this->Comisiones_model->UpdateLoteDisponible($lote_1);
        $respuesta = $this->Comisiones_model->InsertPagoComision($lote_1,str_replace($replace,"",$total_comision),str_replace($replace,"",$abonado),$porcentaje_abono,str_replace($replace,"",$pendiente),$this->session->userdata('id_usuario'),str_replace($replace,"",$pago_neo),str_replace($replace,"",$bonificacion)); 
        
        $banderita = in_array($plan_comision,array(64,65,66)) ? 0 : $banderita;
        if($banderita == 1){
          $total_com = $totalNeto2 * (($PorcentajeAsumar) / 100 );
          $respuesta = $this->Comisiones_model->InsertNeo($lote_1,4824,$total_com,$this->session->userdata('id_usuario'),$PorcentajeAsumar,($pivote*$PorcentajeAsumar),str_replace($replace,"",$pago_neo),45,$idCliente,$tipo_venta_insert,$ooam, $nombreOtro);
        }
        //TERMINA PRIMERA VALIDACION DE DISPERSION

        if ($respuesta === FALSE || $this->db->trans_status() === FALSE){
          $this->db->trans_rollback();
          $respuesta = false;
        }else{
          $this->db->trans_commit();
          $respuesta = true;
        }
      
      } else if($responses->row()->bandera == 0 && ($disparador == '2' || $disparador == 2)){
        $this->db->trans_begin();
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
        
        for($i=0;$i<sizeof($id_comision);$i++){
          $var_n = str_replace($replace,"",$abono_nuevo[$i]);
          
          if($penalizacion == 1 && ($val_rol[$i] == 3 || $val_rol[$i] == 7 || $val_rol[$i] == 9)){
            $respuesta = $this->Comisiones_model->insert_penalizacion_individual($id_comision[$i], $id_usuario[$i], $val_rol[$i], $var_n, $pago, $idCliente);
          }else{
            $respuesta = $this->Comisiones_model->insert_dispersion_individual($id_comision[$i], $id_usuario[$i], $var_n, $pago);
          }
        }
        
        for($i=0;$i<sizeof($abono_nuevo);$i++){
          $var_n = str_replace($replace,"",$abono_nuevo[$i]);
          $suma = $suma + $var_n;
        }
        
        $resta = $pending_1 - $pago;
        if($suma > 0){
          $respuesta = $this->Comisiones_model->UpdateLoteDisponible($lote_1);
          $respuesta = $this->Comisiones_model->update_pago_dispersion($suma, $lote_1, $pago);
        }

        if ($respuesta === FALSE || $this->db->trans_status() === FALSE){
          $this->db->trans_rollback();
          $respuesta = false;
        }else{
          $this->db->trans_commit();
          $respuesta = true;
        }
      }
      else if($responses->row()->bandera != 0) {
        $respuesta[0] = 2;
      } else{
        $respuesta[0] = 3;
      } 
    echo json_encode( $respuesta );
    }

  
    public function porcentajes(){
      $plan_comision = $this->input->post("plan_comision");
      $totalNeto2 = $this->input->post("totalNeto2");
      $cliente = $this->input->post("idCliente");
      $clienteReubicacion = $this->input->post("id_cliente_reubicacion_2");
      $reubicadas = $this->input->post("reubicadas");
      
      if($clienteReubicacion!=null && $reubicadas!= 0){
        echo json_encode($this->Comisiones_model->porcentajesReubicacion($clienteReubicacion)->result_array(),JSON_NUMERIC_CHECK);
      }else{
        echo json_encode($this->Comisiones_model->porcentajes($cliente,$totalNeto2,$plan_comision)->result_array(),JSON_NUMERIC_CHECK);
      }
    }
      public function ReporteTotalMktd($mes,$anio){
        $resultado = array();
  
        $estatus='1,13';
        $estatusBonos='2,6';
        $fechaIninio = 0;
        $fechaFin = 0;
        if($mes != 0 && $anio != 0){
          $estatus='11';
          $estatusBonos=3;
  
              if($mes < 10 && $mes > 0){
                $mes="0".$mes;
              }
              $fechaIninio = date($anio."-".$mes."-01");
              $fechaFin = date($anio."-".$mes."-28");
        }
  
      //  echo $fechaIninio;
       // echo $fechaFin;
       
        //OBTENER LOS USUARIOS QUE COMISIONAM EN MKTD DEL CORTE ACTUAL
        $usuarios = $this->Comisiones_model->GetUserMktd($estatus,$fechaIninio,$fechaFin)->result_array();
  $comentario='';
  
        for ($i=0; $i <count($usuarios); $i++) { 
          $sumaTotal=0;
          $Pagadas = $this->Comisiones_model->getComisionesPagadas($usuarios[$i]['id_usuario'],$fechaIninio,$fechaFin)->result_array();
          //OBTENER LOS BONOS DE USUARIO POR USUARIO
          $resultado[$i]['id_usuario'] = $usuarios[$i]['id_usuario']; 
          $resultado[$i]['nombre'] = $usuarios[$i]['nombre']; 
          $resultado[$i]['comision'] = $usuarios[$i]['comision']; 
          $sumaTotal=$sumaTotal+$usuarios[$i]['comision'];
          $resultado[$i]['pagado_mktd'] = $Pagadas[0]['pagado_mktd']; 
          $comentario='BONO NUSKAH - MKTD 5 MENSUALIDADES';
          $resultado[$i]['pagadoBono1'] = 0; 
  
          $BonoPagado1 = $this->Comisiones_model->getBonosPagados($usuarios[$i]['id_usuario'],$comentario,$fechaIninio,$fechaFin)->result_array();
          $resultado[$i]['pagadoBono1'] = $BonoPagado1[0]['pagado']; 
  
          $NUSKAH = $this->Comisiones_model->getBonoXUser($usuarios[$i]['id_usuario'],$comentario,$estatusBonos,$fechaIninio,$fechaFin)->result_array();
          $Bono1=0;
          $resultado[$i]['bono1']=0;
          $resultado[$i]['pagado1']=0;
          for($j=0;$j<count($NUSKAH);$j++){
            $Bono1=$Bono1+$NUSKAH[$j]['impuesto1'];
            $sumaTotal=$sumaTotal+$NUSKAH[$j]['impuesto1'];
            $resultado[$i]['bono1'] = $NUSKAH[0]['monto']; 
            $resultado[$i]['pagado1'] = $NUSKAH[0]['pagado']; 
            $resultado[$i]['id_sede'] = $NUSKAH[0]['id_sede']; 
            $resultado[$i]['impuesto'] = $NUSKAH[0]['impuesto']; 
            $resultado[$i]['forma_pago'] = $NUSKAH[0]['forma_pago']; 
          }
        
          $resultado[$i]['bono_1'] = $NUSKAH; 
          $resultado[$i]['sumaBono1'] = $Bono1; 
          $comentario='BONO MARKETING - COMISIONES SIN EVIDENCIA DISPERSADO A 12 MESES ENTRE TODOS LOS INVOLUCRADOS';
          $BonoPagado2 = $this->Comisiones_model->getBonosPagados($usuarios[$i]['id_usuario'],$comentario,$fechaIninio,$fechaFin)->result_array();
          $resultado[$i]['pagadoBono2'] = $BonoPagado2[0]['pagado']; 
  
          $MKTD = $this->Comisiones_model->getBonoXUser($usuarios[$i]['id_usuario'],$comentario,$estatusBonos,$fechaIninio,$fechaFin)->result_array();
         
  
          $resultado[$i]['bono_2'] = $MKTD;
          $Bono2=0;
          $resultado[$i]['bono2'] = 0; 
          $resultado[$i]['pagado2']=0;
  
          for($j=0;$j<count($MKTD);$j++){
            $Bono2=$Bono2+$MKTD[$j]['impuesto1'];
            $sumaTotal=$sumaTotal+$MKTD[$j]['impuesto1'];
            $resultado[$i]['bono2'] = $MKTD[0]['monto'];
            $resultado[$i]['pagado2'] = $MKTD[0]['pagado']; 
            $resultado[$i]['id_sede'] = $MKTD[0]['id_sede']; 
            $resultado[$i]['impuesto'] = $MKTD[0]['impuesto']; 
            $resultado[$i]['forma_pago'] = $MKTD[0]['forma_pago']; 
   
          }
          
          $resultado[$i]['sumaBono2'] = $Bono2; 
  
          $resultado[$i]['Total'] = $sumaTotal; 
  
        }
        //echo json_encode($resultado);
        echo json_encode( array( "data" => $resultado));
  
  
  
      }
  
      public function ReporteRevisionMKTD(){
        $this->load->view('template/header');
        $this->load->view("ventas/ReporteRevisionMKTD");
    }


        public function historial_nuevas()
    {
        $this->load->view('template/header');
        $this->load->view("ventas/historial_nuevas");      
    }

    public function getDatosNuevasMontos($proyecto,$condominio){
      $dat =  $this->Comisiones_model->getDatosNuevasMontos($proyecto,$condominio)->result_array();
      for( $i = 0; $i < count($dat); $i++ ){
        $dat[$i]['pa'] = 0;
      }
      echo json_encode( array( "data" => $dat));
    }


    public function usuarios_nuevas() {
      echo json_encode($this->Comisiones_model->usuarios_nuevas($this->input->post("id_rol"), $this->input->post("id_catalogo"))->result_array());
    }

    public function ReporteRevisionMKTD2(){
      $this->load->view('template/header');
      $this->load->view("ventas/ReporteRevisionMKTD3");
  }

  public function ReporteTotalMktdFINAL($mes,$anio){
    $resultado = array();
    $sumaTotalBono1=0;
    $sumaTotalBono2=0;
    $sumaTotalComision=0;
    $numeroMayorNUS=0;
    $numeroMayorMKTD=0;
    $estatus='1,13';
    $estatusBonos='2,6';
    $fechaIninio = 0;
    $fechaFin = 0;
    if($mes != 0 && $anio != 0){
      $estatus='11';
      $estatusBonos=3;
          if($mes < 10 && $mes > 0){
            $mes="0".$mes;
          }
          $fechaIninio = date($anio."-".$mes."-01");
          $fechaFin = date($anio."-".$mes."-28");
    }
    //OBTENER LOS USUARIOS QUE COMISIONAM EN MKTD DEL CORTE ACTUAL
    $usuarios = $this->Comisiones_model->GetUserMktd($estatus,$fechaIninio,$fechaFin)->result_array();
$comentario='';
    for ($i=0; $i <count($usuarios); $i++) { 
      $sumaTotal=0;
      $Pagadas = $this->Comisiones_model->getComisionesPagadas($usuarios[$i]['id_usuario'],$fechaIninio,$fechaFin)->result_array();
      //OBTENER LOS BONOS DE USUARIO POR USUARIO
      $resultado[$i]['id_usuario'] = $usuarios[$i]['id_usuario']; 
      $resultado[$i]['nombre'] = $usuarios[$i]['nombre']; 
      $resultado[$i]['comision'] = $usuarios[$i]['comision']; 
      $sumaTotalComision = $sumaTotalComision +$usuarios[$i]['comision'];
      $sumaTotal=$sumaTotal+$usuarios[$i]['comision'];
      $resultado[$i]['pagado_mktd'] = $Pagadas[0]['pagado_mktd']; 
      $comentario='BONO NUSKAH - MKTD 5 MENSUALIDADES';
      $resultado[$i]['pagadoBono1'] = 0; 
      $BonoPagado1 = $this->Comisiones_model->getBonosPagados($usuarios[$i]['id_usuario'],$comentario,$fechaIninio,$fechaFin)->result_array();
      $resultado[$i]['pagadoBono1'] = $BonoPagado1[0]['pagado']; 
      $NUSKAH = $this->Comisiones_model->getBonoXUser($usuarios[$i]['id_usuario'],$comentario,$estatusBonos,$fechaIninio,$fechaFin)->result_array();
      $Bono1=0;
      $resultado[$i]['bono1']=0;
      $resultado[$i]['pagado1']=0;
      for($j=0;$j<count($NUSKAH);$j++){
        if($i==0){
          $numeroMayorNUS = count($NUSKAH);
        }else{
          if($numeroMayorNUS < count($NUSKAH)){
            $numeroMayorNUS = count($NUSKAH);
          }
        }
        $Bono1=$Bono1+$NUSKAH[$j]['impuesto1'];
        $sumaTotalBono1 = $sumaTotalBono1+$NUSKAH[$j]['impuesto1'];
        $sumaTotal=$sumaTotal+$NUSKAH[$j]['impuesto1'];
        $resultado[$i]['bono1'] = $NUSKAH[0]['monto']; 
        $resultado[$i]['pagado1'] = $NUSKAH[0]['pagado']; 
        $resultado[$i]['id_sede'] = $NUSKAH[0]['id_sede']; 
        $resultado[$i]['impuesto'] = $NUSKAH[0]['impuesto']; 
        $resultado[$i]['forma_pago'] = $NUSKAH[0]['forma_pago']; 
      }
      $resultado[$i]['bono_1'] = $NUSKAH; 
      $resultado[$i]['sumaBono1'] = $Bono1; 
      $comentario='BONO MARKETING - COMISIONES SIN EVIDENCIA DISPERSADO A 12 MESES ENTRE TODOS LOS INVOLUCRADOS';
      $BonoPagado2 = $this->Comisiones_model->getBonosPagados($usuarios[$i]['id_usuario'],$comentario,$fechaIninio,$fechaFin)->result_array();
      $resultado[$i]['pagadoBono2'] = $BonoPagado2[0]['pagado']; 
      $MKTD = $this->Comisiones_model->getBonoXUser($usuarios[$i]['id_usuario'],$comentario,$estatusBonos,$fechaIninio,$fechaFin)->result_array();
      $resultado[$i]['bono_2'] = $MKTD;
      $Bono2=0;
      $resultado[$i]['bono2'] = 0; 
      $resultado[$i]['pagado2']=0;
      for($j=0;$j<count($MKTD);$j++){
        if($i==0){
          $numeroMayorMKTD = count($MKTD);
        }else{
          if($numeroMayorMKTD < count($MKTD)){
            $numeroMayorMKTD = count($MKTD);
          }
        }
        $Bono2=$Bono2+$MKTD[$j]['impuesto1'];
        $sumaTotalBono2 = $sumaTotalBono2+$MKTD[$j]['impuesto1'];
        $sumaTotal=$sumaTotal+$MKTD[$j]['impuesto1'];
        $resultado[$i]['bono2'] = $MKTD[0]['monto'];
        $resultado[$i]['pagado2'] = $MKTD[0]['pagado']; 
        $resultado[$i]['id_sede'] = $MKTD[0]['id_sede']; 
        $resultado[$i]['impuesto'] = $MKTD[0]['impuesto']; 
        $resultado[$i]['forma_pago'] = $MKTD[0]['forma_pago']; 
      }
      $resultado[$i]['sumaBono2'] = $Bono2; 
      $resultado[$i]['Total'] = $sumaTotal; 
    }
    $NuevoArr = array();
    $ARRPAGOS = array();
    for ($m=0; $m <count($resultado) ; $m++) { 
      $NuevoArr[$m] = [$resultado[$m]['nombre'],$resultado[$m]['comision']];
      $cadena = '';
      $cadena2 = '';
      $NuevoArr[$m] = [$resultado[$m]['nombre'],$resultado[$m]['comision']];  
      for ($n=0; $n < $numeroMayorNUS ; $n++) {
        $evaluar = $resultado[$m]['bono_1'];
        if(isset($evaluar[$n]['n_p'])){
          if($n == $numeroMayorNUS -1){
            $cadena = $cadena.$evaluar[$n]['n_p'].'/'.$evaluar[$n]['num_pagos'].','.$evaluar[$n]['impuesto1'];
          }else{
            $cadena = $cadena.$evaluar[$n]['n_p'].'/'.$evaluar[$n]['num_pagos'].','.$evaluar[$n]['impuesto1'].',';
          }
        } else{
          if($n == $numeroMayorNUS -1 ){
            $cadena = $cadena.'0/0,0';
          }else{
            $cadena = $cadena.'0/0,0'.',';
          }
         
        }
      } 
      for ($n=0; $n < $numeroMayorMKTD ; $n++) {
        $evaluar = $resultado[$m]['bono_2'];
        if(isset($evaluar[$n]['n_p'])){
          if($n == $numeroMayorMKTD-1){
            $cadena2 = $cadena2.$evaluar[$n]['n_p'].'/'.$evaluar[$n]['num_pagos'].','.$evaluar[$n]['impuesto1'];

          }else{
            $cadena2 = $cadena2.$evaluar[$n]['n_p'].'/'.$evaluar[$n]['num_pagos'].','.$evaluar[$n]['impuesto1'].',';
          }
        } else{
          if($n == $numeroMayorMKTD-1){
            $cadena2 = $cadena2.'0/0,0';
          }else{
            $cadena2 = $cadena2.'0/0,0'.',';
          }
         
        }
      }  
      $uno = explode(",", $cadena);
      $dos = explode(",", $cadena2);   
if($numeroMayorNUS != 0){
for ($d=0; $d <count($uno) ; $d++) { 
  array_push($NuevoArr[$m],$uno[$d]);
}
}
if($numeroMayorMKTD != 0){
for ($d=0; $d <count($dos) ; $d++) { 
  array_push($NuevoArr[$m],$dos[$d]);
}
}

      array_push($NuevoArr[$m],$resultado[$m]['Total']);
      array_push($NuevoArr[$m],$resultado[$m]['sumaBono1']);
      array_push($NuevoArr[$m],$resultado[$m]['sumaBono2']);

    }

    echo json_encode(  array( "data" => $NuevoArr,
    "numeroMayorNUS" => $numeroMayorNUS,
    "numeroMayorMKTD" => $numeroMayorMKTD,
     "sumaBono1" => $sumaTotalBono1,
     "sumaBono2" => $sumaTotalBono2,
     "sumaTotalComision" => $sumaTotalComision ));
  }

  public function getPagosByUser($user,$mes,$anio){
    $dat =  $this->Comisiones_model->getPagosByUser($user,$mes,$anio)->result_array();
   echo json_encode( $dat);
  }



  public function liquidadosDescuentos()
    {
      $this->load->view('template/header');
      $this->load->view("ventas/liquidadosDescuentos");
    }

  public function getDescuentosLiquidados()
    {
      $res["data"] = $this->Comisiones_model->getDescuentosLiquidados()->result_array();
      echo json_encode($res);
    }


    /************************/


    function reporte_pagos(){
        $this->load->view('template/header');
        $this->load->view("comisiones/reporte_pagos");
    }

    function getByTypeOU($userType){
        $data = $this->Comisiones_model->getByTypeOU($userType);
        if($data != null) {
            echo json_encode($data);
        }else{
            echo json_encode(array());
        }
        exit;
    }

    function inforReporteAsesor(){
      $id_asesor = $this->session->userdata('id_usuario');

        $data['data']= $this->Comisiones_model->inforReporteAsesor($id_asesor);
        if ($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
        exit;
    }

    function conglomerado_descuentos(){
      $datos = array();
      $datos["certificaciones"] = $this->Comisiones_model->getCertificaciones();
      $this->load->view('template/header');
      $this->load->view("ventas/conglomerado",$datos);
  }

    function fusionAcLi(){
        $data['data']= $this->Comisiones_model->fusionAcLi();
        if ($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
        exit;
    }

    public function flujo_comisiones() {
      $this->load->view('template/header');
      $this->load->view('ventas/flujo_comisiones');
    }

    public function getDatosFlujoComisiones() {
      $data = $this->Comisiones_model->getDatosFlujoComisiones()->result_array();
      echo json_encode(array('data' => $data));
    }

      public function getDataDetenidas()
    {
      $datos = array();
      $datos = $this->Comisiones_model->getDataDetenidas();
      if ($datos != null) {
        echo json_encode($datos);
      } else {
        echo json_encode(array());
      }
    }

 
    
    public function detenidas() {
      $this->load->view('template/header');
      $this->load->view('comisiones/detenidas-view');
    }


    public function panel_prestamos()
    {
      $datos["descuentos"] =  $this->Comisiones_model->lista_estatus_descuentos()->result_array();
      $this->load->view('template/header');
      $this->load->view("ventas/panel_prestamos", $datos);
    }
    public function viewHistorialPrestamos()
    {
        $this->load->view('template/header');
        $this->load->view("ventas/historial_prestamos");
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

        $resultUpdate = $this->Comisiones_model->massiveUpdateEstatusComisionInd(implode(',', $idPagos), $estatus);
        $resultMassiveInsert = $this->Comisiones_model->insert_phc($historiales);

        echo ($resultUpdate && $resultMassiveInsert);
    }

    public function getUsersName()
    {
        $result = $this->Comisiones_model->getUsersName();
        echo json_encode($result);
    }

    public function getPuestoByIdOpts()
    {
        $result = $this->Comisiones_model->getPuestoByIdOpts('3,7,9');
        echo json_encode($result);
    }
    public function getDetallePrestamo($idPrestamo)
    {
        $general = $this->Comisiones_model->getGeneralDataPrestamo($idPrestamo);
        $detalle = $this->Comisiones_model->getDetailPrestamo($idPrestamo);
        echo json_encode(array(
            'general' => $general,
            'detalle' => $detalle
        ));
    }
    public function getPrestamosTable($mes=0, $anio=0)
    {
        $data = $this->Comisiones_model->getPrestamosTable($mes, $anio);
        echo json_encode(array('data' => $data));
    }
    public function lista_estatus_descuentos()
    {
      echo json_encode($this->Comisiones_model->lista_estatus_descuentos()->result_array());
    }

    public function getTotalPagoFaltanteUsuario($usuarioId)
    {
        $data = $this->Comisiones_model->getTotalPagoFaltanteUsuario($usuarioId);
        echo json_encode($data);
    }
    public function reactivarPago()
    {
        $idDescuento = $_POST['id_descuento'];
        $fechaActivacion = strtotime($_POST['fecha']);
        $diaActivacion = date('d', $fechaActivacion);
        $mesActivacion = date('m', $fechaActivacion);
        $anioActivacion = date('Y', $fechaActivacion);
        $mesActual = date('m');
        $anioActual = date('Y');

        if ($diaActivacion >= 1 && $diaActivacion <= 5) {
            if ($mesActivacion === $mesActual) {
                if ($anioActivacion === $anioActual) {
                    $result = $this->Comisiones_model->updatePagoReactivadoMismoDiaMes($idDescuento,
                        date('Y-m-d H:i:s', $fechaActivacion));
                } else {
                    $result = $this->Comisiones_model->updatePagoReactivadoFechaDiferente($idDescuento,
                        date('Y-m-d H:i:s', $fechaActivacion));
                }
            } else {
                $result = $this->Comisiones_model->updatePagoReactivadoFechaDiferente($idDescuento,
                    date('Y-m-d H:i:s', $fechaActivacion));
            }
        } else if ($mesActivacion === $mesActual) {
            $result = $this->Comisiones_model->updatePagoReactivadoMismoMes($idDescuento,
                date('Y-m-d H:i:s', $fechaActivacion));
        } else {
            $result = $this->Comisiones_model->updatePagoReactivadoFechaDiferente($idDescuento,
                date('Y-m-d H:i:s', $fechaActivacion));
        }

        echo json_encode($result);
    }

    public function viewAsistentesGerencia()
    {
        $this->load->view('template/header');
        $this->load->view("ventas/seguimiento_comisiones_asistente");
    }

    public function getUsuariosByComisionesAsistentes($idUsuarioSelect, $proyecto, $estatus)
    {
        $data = $this->Comisiones_model->getUsuariosByComisionesAsistentes($idUsuarioSelect, $proyecto, $estatus);
        for($i = 0; $i < count($data); $i++ ){
            $data[$i]['pa'] = 0;
        }
        echo json_encode(array('data' => $data));
    }

    public function getPuestoComisionesAsistentes()
    {
        $data = $this->Comisiones_model->getOpcionCatByIdCatAndIdOpt(1, '3,7,9');
        echo json_encode($data);
    }

    public function findUsuariosByPuestoAsistente($puesto) {
      $data = $this->Comisiones_model->findUsuariosByPuestoAsistente($puesto, $this->session->userdata('id_lider'), $this->session->userdata('id_usuario'));
      echo json_encode($data);
    }

    public function findAllResidenciales()
    {
        $data = $this->Comisiones_model->findAllResidenciales();
        echo json_encode($data);
    }

    public function getEstatusComisionesAsistentes()
    {
        $data = $this->Comisiones_model->get_lista_estatus()->result_array();
        echo json_encode($data);
    }

    

    public function getDetallePlanesComisiones($idPlan)
    {
        $data = $this->Comisiones_model->getDetallePlanesComisiones($idPlan);
        $info = array();
        $info['id_plan'] = $data->id_plan;
        $info['descripcion'] = $data->descripcion;
        $info['comisiones'][] = array(
            'puesto' => $data->director,
            'com' => $data->comDi,
            'neo' => $data->neoDi
        );
        $info['comisiones'][] = array(
            'puesto' => $data->regional,
            'com' => $data->comRe,
            'neo' => $data->neoRe
        );
        $info['comisiones'][] = array(
            'puesto' => $data->subdirector,
            'com' => $data->comSu,
            'neo' => $data->neoSu
        );
        $info['comisiones'][] = array(
            'puesto' => $data->gerente,
            'com' => $data->comGe,
            'neo' => $data->neoGe
        );
        $info['comisiones'][] = array(
            'puesto' => $data->coordinador,
            'com' => $data->comCo,
            'neo' => $data->neoCo
        );
        $info['comisiones'][] = array(
            'puesto' => $data->asesor,
            'com' => $data->comAs,
            'neo' => $data->neoAs
        );
        $info['comisiones'][] = array(
            'puesto' => $data->otro,
            'com' => $data->comOt,
            'neo' => $data->neoOt
        );
        $info['comisiones'][] = array(
            'puesto' => $data->mktd,
            'com' => $data->comMk,
            'neo' => $data->neoMk
        );
        $info['comisiones'][] = array(
            'puesto' => $data->otro2,
            'com' => $data->comOt2,
            'neo' => $data->neoOt2
        );

        echo json_encode($info);
    }

    public function viewVentasCanceladas()
    {
        $this->load->view('template/header');
        $this->load->view("ventas/ventas_canceladas");
    }

    public function getVentasCanceladas()
    {
        $data = $this->Comisiones_model->getVentasCanceladas();
        echo json_encode(array('data' => $data));
    }

    public function getDetailVentaCancelada($idLote, $idCliente)
    {
        $cantidades = $this->Comisiones_model->getVentCanceladaSuma($idLote, $idCliente);
        $detalle = $this->Comisiones_model->getVentaCanceladaDetalle($idLote, $idCliente);
        echo json_encode(array(
            'cantidades' => $cantidades,
            'detalle' => $detalle
        ));
    }

    public function updateBanderaDetenida() {
      $idLote     = $this->input->post('idLote');
      $bandera     = true;
      
      $datosRegistro = $this->Comisiones_model->ultimoRegistro($idLote);
      $nuevoRegistroComision = $datosRegistro->anterior;
      var_dump($nuevoRegistroComision);
     $response = $this->Comisiones_model->updateBanderaDetenida($idLote , $bandera, $nuevoRegistroComision);
     echo json_encode($response);
    }

    public function changeLoteToStopped()
    {
      $id_pagoc     = $this->input->post('id_pagoc');
      $id_usuario   = $this->session->userdata('id_usuario');
      $idLote       = $this->input->post('idLote');
      $estatus      = 1;
      $descripcion  = $this->input->post('descripcion'); 
      $tabla        = 'pago_comision';
      $motivo       =  $this->input->post('motivo'); 

      //se cambio a esta forma para limpiar el insert y teneer claro los datos que se envian
      $response = $this->Comisiones_model->insertHistorialLog( $id_pagoc,  $id_usuario, $estatus, $descripcion, $tabla, $motivo);
        if ($response) {
          $bandera = false;

          $response = $this->Comisiones_model->updateBanderaDetenida( $id_pagoc, $bandera, $motivo);
        }

         echo json_encode($response);
    }

    public function getFormasPago()
    {
        $data = $this->Comisiones_model->getFormasPago();
        echo json_encode($data);
    }

    public function getTotalComisionAsesor()
    {
        $idUsuario = $this->session->userdata('id_usuario');
        $data = $this->Comisiones_model->getTotalComisionAsesor($idUsuario);
        echo json_encode($data);
    }

    public function getComprobantesExtranjero()
    {
        $data = $this->Comisiones_model->getComprobantesExtranjero();
        echo json_encode(array('data' => $data));
    }

    public function getDatosNuevasEContraloria($proyecto,$condominio){
      $dat =  $this->Comisiones_model->getDatosNuevasEContraloria($proyecto,$condominio)->result_array();
      for( $i = 0; $i < count($dat); $i++ ){
        $dat[$i]['pa'] = 0;
      }
      echo json_encode( array( "data" => $dat));
    }

    public function getDataConglomerado($tipoDescuento)
    {
        $data = $this->Comisiones_model->fusionAcLi($tipoDescuento);
        echo json_encode(array('data' => $data));
    }

    public function eliminarDescuentoUniversidad($idDescuento)
    {
        $this->Comisiones_model->eliminarDescuentoUniversidad($idDescuento);
        echo json_encode(true);
    }

    public function obtenerDescuentoUniversidad($idDescuento)
    {
        $comision = $this->Comisiones_model->obtenerDescuentoUniversidad($idDescuento);
        echo json_encode($comision);
    }

    public function actualizarDescuentoUniversidad()
    {
        $idDescuento = $this->input->post('id_descuento');
        $data = array(
            'monto' => $this->input->post('descuento'),
            'pago_ind' => str_replace(',', '', $this->input->post('pago_ind'))
        );

        $this->Comisiones_model->actualizarDescuentoUniversidad($idDescuento, $data);

        echo json_encode(true);
    }
    public function getHistorialPrestamoAut($idRelacion) {
      $data = $this->Comisiones_model->getHistorialPrestamoAut($idRelacion);
      echo json_encode($data);
  }

  public function sendCommissionToPay() {
    for ($i = 0; $i < count($this->input->post("id_lote")); $i++) {
      $insertToData[$i] = array(
          "id_lote" => $_POST['id_lote'][$i],
          "precio" => 0,
          "dispersion" => 1,
          "estatus" => 1,
          "creado_por" => $this->session->userdata('id_usuario'),
          "fecha_creacion" => date("Y-m-d H:i:s")
      );
    }
    $insertResponse = $this->General_model->insertBatch("reportes_marketing", $insertToData);
    echo json_encode($insertResponse);
  }

  public function getInfoReporteDevolucion(){
    $query = $this->input->post("query");
    $respuesta['data']  = $this->Comisiones_model->getInfoReportePagos($query);
    echo json_encode($respuesta);
  }
  public function reporteDevolucion(){
    $this->load->view('template/header');
    $this->load->view("comisiones/reporte_devolucion_view");
  }


  public function UpdateDescuent(){
    $id_descuento       = $this->input->post('id_descuento');
    $monto              = $this->input->post('monto');
    $pago_individual    = $this->input->post('pago_individual');
    $comentario         = 'Descuento aplicado';
    $pagos_activos         =  $this->input->post('pagos_activos');
                        $arr_update = array(                      
                            "pagos_activos"   => $pagos_activos,
                            "monto"           =>  $monto,
                            "pago_individual" =>  $pago_individual,
                            "detalles"      =>  $comentario
                                  );
    $update = $this->Comisiones_model->descuentos_universidad($id_descuento,$arr_update);                           
    if($update){
      $d=  array(
        "response_code" => 200, 
        "response_type" => 'success',
        "message" => "Descuento actualizado satisfactoriamente");
    }else{
      $d=  array(
        "response_code" => 400, 
        "response_type" => 'error',
        "message" => "Descuento no actualizado, intentalo más tarde");
    }
    echo json_encode ($d);
  }  




          // INSTALACIÓN PENALIZACIONES
           public function changeLoteToPenalizacion()
    {
      // echo $_POST['id_lote'];
      // echo $_POST['id_cliente'];
      
        $response = $this->Comisiones_model->insertHistorialLog($_POST['id_lote'], $this->session->userdata('id_usuario'), 1, 'SE ACEPTÓ PENALIZACIÓN',
                'penalizaciones', 'NULL');
        if ($response) {
          $response = $this->Comisiones_model->updatePenalizacion($_POST['id_lote'], $_POST['id_cliente']);
        }
        if($response){
          $response = $this->Comisiones_model->insertHistorialComentario($_POST['id_lote'], $this->session->userdata('id_usuario'), $_POST['comentario_aceptado']);
        }
         echo json_encode($response);
    }

    public function changeLoteToPenalizacionCuatro()
    {
        $response = $this->Comisiones_model->insertHistorialLog($_POST['id_lote'], $this->session->userdata('id_usuario'), 1, 'SE ACEPTÓ PENALIZACIÓN + 160 DÍAS',
                'penalizaciones', 'NULL');
        if ($response) {
          $response = $this->Comisiones_model->updatePenalizacionCuatro($_POST['id_lote'], $_POST['id_cliente'], $_POST['asesor'], $_POST['coordinador'], $_POST['gerente']);
        }
        if($response){
          $response = $this->Comisiones_model->insertHistorialCancelado($_POST['id_lote'], $this->session->userdata('id_usuario'), $_POST['comentario_rechazado']);
        }

         echo json_encode($response);
    }


    public function cancelLoteToPenalizacion()
    {
        $response = $this->Comisiones_model->insertHistorialLog($_POST['id_lote'], $this->session->userdata('id_usuario'), 1, 'SE CANCELÓ PENALIZACIÓN', 'penalizaciones', 'NULL');
        if ($response) {
          $response = $this->Comisiones_model->updatePenalizacionCancel($_POST['id_lote'], $_POST['id_cliente']);
        }

         echo json_encode($response);
    }

      public function insertCertificacion(){
      $id_descuento       = $this->input->post('id_descuento');
      $monto              = $this->input->post('monto');
      $pago_individual    = $this->input->post('pago_individual');
      $certificacionX     = $this->input->post('certificacionX');
      $comentario         = 'Descuento ingreso por';
      $pagos_activos         =  $this->input->post('pagos_activos');
    }
   
    public function descuentoUpdateCertificaciones(){

      $banderaSoloEstatus     = $this->input->post('banderaSoloEstatus');
      $statu                  = $this->input->post('statu'); 
      $estatus                = $this->input->post('estatus');
      $id_descuento           = $this->input->post('id_descuento');
      $monto                  = $this->input->post('monto');
      $pago_individual        = $this->input->post('pago_individual');
      $estatus_certificacion  = $this->input->post('estatus_certificacion');
      $comentario             = 'Descuento aplicado ';
      $fechaSeleccionada      =  $this->input->post('fechaSeleccionada');
      $banderaPagosActivos    =  $this->input->post('banderaPagosActivos');
      $complemento            = '01:01:00.000';
      $fecha_modificacion = $fechaSeleccionada.' '.$complemento;
      if($banderaSoloEstatus != 'false' ){
        // var_dump('entrando a 1 ');
        $arr_update = array( 
          "estatus_certificacion" => $estatus_certificacion,          
        );
        

      }else{
        // var_dump('entrando a 2');
        if($estatus === '1'){

          // uno es cuando viene de baja
      //  if del estatus es el tipo de filtrado
                          $arr_update = array( 
                            "estatus"   => 1,
                            "monto"           =>  $monto,
                            "pago_individual" =>  $pago_individual,
                            "detalles"      =>  $comentario,
                            "estatus_certificacion" => $estatus_certificacion,
                            );
  
                            if($banderaPagosActivos == 1 ){
                              $pagos_activos = 1;
                              $fecha_modificacion = $fechaSeleccionada.' '.$complemento;
                              // $estatus = 5;  
                              $arr_update["estatus"] = $estatus ;
                              $arr_update["pagos_activos"] = $pagos_activos ;
                              $arr_update["fecha_modificacion"] =  $fechaSeleccionada.' '.$complemento;
                            }
                            else if($banderaPagosActivos == 2){
                              $pagos_activos = 0;
                              $fecha_modificacion = $fechaSeleccionada.' '.$complemento;
                              $estatus = 5;  
                              $arr_update["estatus"] = $estatus ;
                              $arr_update["pagos_activos"] = $pagos_activos ;
                              $arr_update["fecha_modificacion"] =  $fechaSeleccionada.' '.$complemento;


                            }
                            else{
                    
                            }
        }else {
         
          $arr_update = array(    
            
            // "pagos_activos"   => $pagos_activos,
            "monto"           =>  $monto,
            "pago_individual" =>  $pago_individual,
            "detalles"      =>  $comentario,
            "estatus_certificacion" => $estatus_certificacion,                  
          );
          if($banderaPagosActivos == 1 ){
            $pagos_activos = 1;
            $fecha_modificacion = $fechaSeleccionada.' '.$complemento;
            // $estatus = 5;  
            $arr_update["pagos_activos"] = $pagos_activos ;
            $arr_update["fecha_modificacion"] = $fecha_modificacion;
          }
          else  if($banderaPagosActivos == 2){
            $pagos_activos = 0;
            $estatus = 5;  
            $arr_update["estatus"] = $estatus ;
            $arr_update["pagos_activos"] = $pagos_activos ;
            $arr_update["fecha_modificacion"] = $fecha_modificacion  ;
  
          }
          else{
  
          }
        }
     
      }
     
      // $pagos_activos      =  $this->input->post('pagos_activos');
        // enviamos la info al model si se realiza un cambio esperamos respuesta
    
      $update = $this->Comisiones_model->descuentos_universidad($id_descuento,$arr_update);                           
      if($update){
        $respuesta =  array(
          "response_code" => 200, 
          "response_type" => 'success',
          "message" => "Descuento actualizado satisfactoriamente");
      }else{
        $respuesta =  array(
          "response_code" => 400, 
          "response_type" => 'error',
          "message" => "Descuento no actualizado, inténtalo más tarde ");
      }
      echo json_encode ($respuesta);
    } 


    public function historial_prestamos()
    {
      $this->load->view('template/header');
        $this->load->view("ventas/historial_prestamo_view");    
    }
   
    public function updatePrestamos (){
      $pagoEdit       = $this->input->post('pagoEdit');
      $Numero_pagos   = $this->input->post('numeroPagos');
      $montoPagos     = $this->input->post('montoPagos');
      $comentario     = $this->input->post('comentario');
      $id_prestamo    = $this->input->post('prestamoId');
      $tipoD          = $this->input->post('tipoD');

          $arr_update = array( 
                            "monto"                 =>  $pagoEdit,
                            "num_pagos"             =>  $Numero_pagos,
                            "pago_individual"       =>  $montoPagos,
                  "comentario"            =>  $comentario,
                  "modificado_por"        => 1,
                  "tipo"                  => $tipoD, 
                            );
                            
        $update = $this->Comisiones_model->updatePrestamosEdit($id_prestamo  , $arr_update);
        if($update){
          $respuesta =  array(
            "response_code" => 200, 
            "response_type" => 'success',
            "message" => "Préstamo actualizado");
        }else{
          $respuesta =  array(
            "response_code" => 400, 
            "response_type" => 'error',
            "message" => "Préstamo no actualizado, inténtalo más tarde ");
    }
        echo json_encode ($respuesta);

}

    


public function lista_usuarios($rol,$forma_pago){
  echo json_encode($this->Comisiones_model->get_lista_usuarios($rol,$forma_pago)->result_array());
}
  
public function descuentosCapitalHumano(){
    $this->load->view('template/header');
    $this->load->view("ventas/add_descuento");
  }

  public function getPuestosDescuentos(){
  echo json_encode($this->Comisiones_model->getPuestosDescuentos()->result_array());
  }

  public function getDisponbleResguardoP($user,$opc = ''){
    if($opc == ''){
      $datos = $this->Comisiones_model->getDisponbleResguardo($user)->result_array();
      $extras = $this->Comisiones_model->getDisponbleExtras($user)->result_array();
      //$suma =($datos[0]['suma']+$extras[0]['extras']);
      $suma =$datos[0]['suma'];
    }else{
      $datos = $this->Comisiones_model->getDisponbleResguardo($user)->result_array();
     // $extras = $this->Comisiones_model->getDisponbleExtras($user)->result_array();
     $suma =($datos[0]['suma']);
    }
    
    
    echo json_encode($suma);
  }


  public function lotes(){
    $lotes = $this->Comisiones_model->lotes();
    
    $pagos = $this->Comisiones_model->pagos();
    
    $monto = $this->Comisiones_model->monto();

    $dispersion[ "lotes"] = $lotes->nuevo_general; 
    $dispersion["pagos"] = $pagos->nuevo_general;
    $dispersion["monto"] = $monto->nuevo_general;

    echo json_encode(  $dispersion);
    }

    public function revision_bonos()
    {
      $this->load->view('template/header');
      if($this->session->userdata('id_rol') == 31){
         $this->load->view("pagos/bonos_intmex_view");
         //  se cambio la vista  
         }else{
           $this->load->view("pagos/bonos_solicitados_view");
         }
         //  se cambio la vista 
    }
    public function ultimoRegistro (){

      $idLote   = $this->input->post('idLote');
      $respusta = $this->comisiones_model->ultimoRegistro($idLote);
      var_dump($respusta);
    }

    public function ultimaDispersion (){

      $lote_1 =  $this->input->post("idLote");
      $insertArray = array(
          'ultima_dispersion' => date('Y-m-d H:i:s'),
                  );
      $respuesta =  $this->Comisiones_model->ultimaDispersion($lote_1,$insertArray);

      if($respuesta){
        $d=  array(
          "response_code" => 200, 
          "response_type" => 'success',
          "message" => "");
      }else{
        $d=  array(
          "response_code" => 400, 
          "response_type" => 'danger',
          "message" => "");  
      }
        return $d;
    }


    public function ultimoLlenado(){
      $respuesta = $this->Comisiones_model->ultimoLlenado();
      if($respuesta == FALSE  ){
        $array_respuesta = array(
          "response_code" => 400,
          "response_type" => 'danger',
          "message"       => 'Upss,Error en consulta favor volver a intentarlo.',
          "date"          => 'Null'
        );
      }{
        $array_respuesta = array(
          "response_code" => 200,
          "response_type" => 'success',
          "message"       => 'ok',
          "date"          => $respuesta
        );
      }

     echo  json_encode( $array_respuesta);
    }


    public function nuevoLlenadoPlan(){
      $fecha_reinicio = $this->input->post("fecha_reinicio");
        $fecha_Sistema =  date('Y-m-d H:i:s');
      
       $respuesta = $this->Comisiones_model->nuevoLlenadoPlan();
     
    
      
  
     echo  json_encode( $respuesta);
    }


    public function enviarBonosMex($idbono){
      $estatus=6;
      if($this->session->userdata('id_rol') == 31){
       $estatus=3;
     }else if($this->session->userdata('id_rol') == 18){
       $estatus=2;
     }
     $ids = explode(',',$idbono);
     for ($i=0; $i <count($ids) ; $i++) { 
   
      $result = $this->Pagos_model->UpdateINMEX($ids[$i],$estatus);
     }
     echo json_encode($result);
     }
    public function bajarReubicados(){

      $lo6te_1 =  $this->input->post("idLote");


    }

    public function comisionesReubicaciones (){
      $idCliente =  $this->input->post("idCliente");
      // var_dump($idCliente);
      $resulto = $this->Comisiones_model->reubicadas($idCliente);
      echo json_encode($resulto);


    }

  public function getHistorialDescuentosPorUsuario() {      
    echo json_encode(array( "data" => $this->Comisiones_model->getHistorialDescuentosPorUsuario()));
  }

}
