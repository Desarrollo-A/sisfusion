<?php
  defined('BASEPATH') or exit('No direct script access allowed');

  use PhpOffice\PhpSpreadsheet\Spreadsheet;
  class Internomex extends CI_Controller
  {
    private $gph;
    public function __construct()
    {
      parent::__construct();
      $this->load->model(array('Internomex_model', 'asesor/Asesor_model', 'General_model'));
      $this->load->library(array('session','form_validation', 'get_menu', 'Jwt_actions', 'Formatter','permisos_sidebar'));
      $this->load->helper(array('url', 'form'));
      $this->load->database('default');

        $val =  $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        $_SESSION['rutaController'] = str_replace('' . base_url() . '', '', $val);
        $rutaUrl = explode($_SESSION['rutaActual'], $_SERVER["REQUEST_URI"]);
        $this->permisos_sidebar->validarPermiso($this->session->userdata('datos'),$rutaUrl[1],$this->session->userdata('opcionesMenu'));
    }

    public function index(){
      if ($this->session->userdata('id_rol') == false || $this->session->userdata('id_rol') != '31') {
        redirect(base_url() . 'login');
      }
      $this->load->view('template/header');
      $this->load->view('template/home');
      $this->load->view('template/footer');
    }

    public function nuevos(){
      $this->load->view('template/header');
      $this->load->view("internomex/nuevos");
    }

    public function getDatosNuevasInternomex($proyecto,$condominio){
      $dat =  $this->Internomex_model->getDatosNuevasInternomex($proyecto,$condominio)->result_array();
      for( $i = 0; $i < count($dat); $i++ ){
        $dat[$i]['pa'] = 0;
      }
      echo json_encode( array( "data" => $dat));
    }

    public function aplicados()
    {
      $this->load->view('template/header');
      $this->load->view("internomex/aplicados");
    }

    public function getDatosAplicadosInternomex($proyecto,$condominio){
      $dat =  $this->Internomex_model->getDatosAplicadosInternomex($proyecto,$condominio)->result_array();
      for( $i = 0; $i < count($dat); $i++ ){
        $dat[$i]['pa'] = 0;
      }
      echo json_encode( array( "data" => $dat));
    }

    public function historial(){
      $this->load->view('template/header');
      $this->load->view("internomex/historial");
    }

    public function getDatosHistorialInternomex($proyecto,$condominio){
      $dat =  $this->Internomex_model->getDatosHistorialInternomex($proyecto,$condominio)->result_array();
      for( $i = 0; $i < count($dat); $i++ ){
        $dat[$i]['pa'] = 0;
      }
      echo json_encode( array( "data" => $dat));
    }


    public function aplico_internomex_pago($sol){
      $this->load->model("Internomex_model");   
      $consulta_comisiones = $this->db->query("SELECT id_pago_i FROM pago_comision_ind where id_pago_i IN (".$sol.")");
      
      if( $consulta_comisiones->num_rows() > 0 ){
        $consulta_comisiones = $consulta_comisiones->result_array();
        for( $i = 0; $i < count($consulta_comisiones ); $i++){
          $this->Internomex_model->update_aplica_intemex($consulta_comisiones[$i]['id_pago_i']);
        }
      } else{
        $consulta_comisiones = array();
      }
    }

    public function loadFinalPayment() {
      $this->load->view('template/header');
      $this->load->view("internomex/load_final_payment");
    }

    public function getPaymentsListByCommissionAgent($tipo_pago){
      $data = $this->Internomex_model->getCommissions($tipo_pago)->result_array();
      echo json_encode($data);
    }

    public function getPagosFinal() {
      $beginDate = $this->input->post('beginDate');
      $endDate = $this->input->post('endDate');
      $data['data'] = $this->Internomex_model->getPagosFinal($beginDate, $endDate)->result_array();
      echo json_encode($data);
    }

    public function insertInformation($tipo_pago) {
      if (!isset($_POST))
        echo json_encode(array("status" => 400, "message" => "Algún parámetro no viene informado."));
      else {
        if ($this->input->post("data") == "")
          echo json_encode(array("status" => 400, "message" => "Algún parámetro no tiene un valor especificado."), JSON_UNESCAPED_UNICODE);
        else {
          $data = $this->input->post("data");
          $decodedData = $this->jwt_actions->decodeData('4582', $data);
          if (in_array($decodedData, array('ALR001', 'ALR003', 'ALR004', 'ALR005', 'ALR006', 'ALR007', 'ALR008', 'ALR009', 'ALR010', 'ALR012', 'ALR013', 'ALR002', 'ALR011', 'ALR014')))
            echo json_encode(array("status" => 500, "message" => "No se logró decodificar la data."), JSON_UNESCAPED_UNICODE);
          else {
            $insertArrayData = array();
            $reinsertArrayData = array();
            $flag = false;
            $flagB = false; 
            $decodedData = json_decode($decodedData); // SE CONVIERTE A UN ARRAY
            $insertAuditoriaData = array("fecha_creacion" => date("Y-m-d H:i:s"), "creado_por" => (int)$this->session->userdata('id_usuario')); // SE CREA ARREGLO CON DATOS BASE (QUE LLEVAN TODOS LOS REGISTROS)
            if (count($decodedData) > 0) { // SE VALIDA QUE EL ARRAY AL MENOS TENGA DATOS
              $id_usuario = array();
              for ($i = 0; $i < count($decodedData); $i++) { // CICLO PARA VALIDACIÓN DE DATOS (CHECAR QUE LOS REGISTROS NOS SE HAYAN INSERTADO YA)
                // SE VERIFICA QUE LA FILA DE DATOS CONTEGA LA INFORMACIÓN QUE SE VA A INSERTAR Y QUE NO VENGA VACÍA
                if (isset($decodedData[$i]->id_usuario) && !empty($decodedData[$i]->id_usuario) && isset($decodedData[$i]->formaPago) && !empty($decodedData[$i]->formaPago) && isset($decodedData[$i]->montoSinDescuentos) && !empty($decodedData[$i]->montoSinDescuentos) &&
                  isset($decodedData[$i]->montoConDescuentosSede) && !empty($decodedData[$i]->montoConDescuentosSede) && isset($decodedData[$i]->montoFinal) && !empty($decodedData[$i]->montoFinal) && isset($decodedData[$i]->comentario))
                  $id_usuario[$i] = (int)$decodedData[$i]->id_usuario;
                else {
                  unset($decodedData[$i]); // SE ELIMINA LA POSICIÓN QUE YA SE INSERTÓ ANTERIORMENTE
                  $decodedData = array_values($decodedData); // SE REORDENA EL ARRAY
                }
              }
            
              $verifiedData = array();
              if (count($id_usuario) > 0) {
                $id_usuario = implode(", ", $id_usuario); // SE CONVIERTE ARRAY DE ID DE USARIO A UN STRING SEPARADO POR COMMA PARA LA CONSULTA
                $verifiedData = $this->Internomex_model->verifyData($id_usuario);
              }
              for ($i = 0; $i < count($decodedData); $i++) { // CICLO PARA RECORRER ARRAY DE DATOS Y ARMAR ARRAY PARA EL BATCH INSERT
                $commonData = array();
                if (count($verifiedData) > 0) { // SE ENCONTRARON REGISTROS YA INSERTADOS EN EL MES
                  for($e = 0; $e < count($verifiedData); $e++){
                    if((int)$decodedData[$i]->id_usuario === (int)$verifiedData[$e]->id_usuario){
                      //  $reinsertArrayData[$i] =  (int)$decodedData[$i];
                      $flag = true;
                      $flagB = false;
                      unset($decodedData[$i]); // SE ELIMINA LA POSICIÓN QUE YA SE INSERTÓ ANTERIO  RMENTE
                      $decodedData = array_values($decodedData); // SE REORDENA EL ARRAY
                    }
                  }
                }
                if (count($decodedData) > 0) {
                  $commonData += array("id_usuario" => (int)$decodedData[$i]->id_usuario, 
                    "forma_pago" => (int)$this->formatter->convertPaymentMethod($decodedData[$i]->formaPago),
                    "monto_sin_descuento" => (float)$this->formatter->removeNumberFormat($decodedData[$i]->montoSinDescuentos), 
                    "monto_con_descuento" => (float)$this->formatter->removeNumberFormat($decodedData[$i]->montoConDescuentosSede), 
                    "monto_internomex" => (float)$this->formatter->removeNumberFormat($decodedData[$i]->montoFinal),
                    "comentario" => $decodedData[$i]->comentario,
                    "tipo_pago" => $tipo_pago
                  );
                  $commonData += $insertAuditoriaData; // SE CONCATENA LA DATA BASE + LA DATA DEL ARRAY PRINCIPAL
                  array_push($insertArrayData, $commonData);
                }
              }
              if ($flag) {
                $flagB = false;
                echo json_encode(array("status" => 301, "message" => "Es posible que más de un dato ya estuviera registrado en este mes"), JSON_UNESCAPED_UNICODE);
              }
              if (count($insertArrayData) > 0) { // AL TERMINAR EL CICLO SE EVALÚA SI EL ARRAY DE DATOS PARA EL BATCH INSERT TIENE DATA VA Y TIRA EL BATCH
                $insertResponse = $this->General_model->insertBatch("pagos_internomex", $insertArrayData);
                if ($insertResponse) // SE EVALÚA LA RESPUSTA DE LA TRANSACCIÓN OK
                  echo json_encode(array("status" => 200, "message" => "Todos los registros se han insertado con éxito."), JSON_UNESCAPED_UNICODE);
                else // FALLÓ EL BATCH
                  echo json_encode(array("status" => 500, "message" => "No se logró procesar la petición."), JSON_UNESCAPED_UNICODE);
              } else if($flag){
                if ($flagB) {
                  // echo json_encode(array("status" => 301, "message" => "Es posible que más de un dato ya estuviera registrado en este mes"), JSON_UNESCAPED_UNICODE);
                }
              } else {
                echo json_encode(array("status" => 500, "message" => "No hay información para procesar (vacío)."), JSON_UNESCAPED_UNICODE);
              }
            }
            else // ARRAY VACÍO
              echo json_encode(array("status" => 500, "message" => "No hay información para procesar (inicio)."), JSON_UNESCAPED_UNICODE);
            }
          }
        }
      }
  
      public function updateMontoInternomex(){
        if(!isset($_POST)){
          echo json_encode(array("status" => 500, "message" => "No hay información para procesar (inicio)."), JSON_UNESCAPED_UNICODE);
        } else{
          $updateData = array(
            "monto_internomex" => (float)$this->formatter->removeNumberFormat($this->input->post("monto")) ,
            "fecha_modificacion" => date('Y-m-d H:m:s'),
            "modificado_por" =>  (int)$this->session->userdata('id_usuario')
          );
          $reuslt = $this->General_model->updateRecord("pagos_internomex", $updateData, "id_pagoi", $this->input->post("id_pago"));
          if ($reuslt == true)
            echo json_encode(array("status" => 200, "message" => "El registro se ha actualizado de manera exitosa."), JSON_UNESCAPED_UNICODE);
          else
            echo json_encode(array("status" => 400, "message" => "Oops, algo salió mal. Inténtalo más tarde."), JSON_UNESCAPED_UNICODE);
          }
      }

    public function getBitacora($id_pago){
      echo json_encode($this->Internomex_model->getBitacora($id_pago)->result_array());
  }


// ----------------------------------------------------------------------------------------------------------------------------------------

// FUNCION PARA LANZAR LA VISTA DE DETALLE DE ENGANCHES
  public function detEnganche() {
		$this->load->view('template/header');
		$datos["rol"] = $this->session->userdata('id_rol');
		$this->load->view("internomex/detEnganche", $datos);
	}

  // FUNCION PARA CONSULTAR LA LISTA DE LOTES FILTRADOS POR PROYECTO CONDOMINIO Y SELCCIONAR UN PARA VALIDAR EL ENGANCHE
  public function getRegistroLotesEng() {
    $data = json_decode(file_get_contents("php://input"));
    $index_condominio = $this->input->post('index_condominio');
    $dato = $this->Internomex_model->getRegistrosLotesEnganche($index_condominio);
    if ($dato != null)
        echo json_encode($dato);
    else
        echo json_encode(array());
  }

  // FUNCION PARA TRAER LOS CATALOGOS Y ENGANCHES REGISTRADOS DEL DETALLE DE ENGANCHE DEL LOTE
  public function catalogosEnganche() {
    $response = array("status"=>-1,"mensaje"=>"Ha ocurrido un error a","data"=>[]);
    $data = json_decode( file_get_contents('php://input') );
    $idLote = $this->input->post('idLote');
    $dtoCatalogos = $this->Internomex_model->getCatalogos()->result_array();
    $dtoEnganches = $this->Internomex_model->getEnganches($idLote)->result_array();
    if(count($dtoCatalogos) > 0)
      $response = array( "status" => 1, "mensaje"=>"Exito al traer los catalogos", "dtoCatalogos"=> $dtoCatalogos, "dtoEnganches"=> $dtoEnganches );
    else
      $response = array( "status" => 0, "mensaje"=>"Error al traer los catalogos", "dtoCatalogos"=> []);
    echo json_encode($response);
  }

    // FUNCION PARA AGREGAR ENGANCHE Y DETALLE DE ENGANCHE
	public function guardarEnganches() {
    $data = $this->input->post('dtoEnganche');
    $dtoInstrumentoMonetario=[];
    $response=$response = array( "status" => 3, "mensaje"=>"Error no entro a validaciones");
    try {
      $this->db->trans_begin();
      if(array_key_exists('enganchesGuardados', $data)) {
        foreach ($data['enganchesGuardados'] as $key => $dto) {
              $objActualizarDetEnganche[]=array(
                "id_det_enganche"=>$dto['id_det_enganche'],
                "instrumento_monetario"=>$dto['instrumento_monetario'],
                "moneda_divisa"=>$dto['moneda_divisa'],
                "fecha_pago"=>$dto['fecha_pago'],
                "estatus"=>"1",
                "idEnganche"=>$dto['idEnganche']
              );
        }
        if(count($objActualizarDetEnganche) > 0)
          $dtoInstrumentoMonetario = $this->General_model->updateBatch('det_enganche', $objActualizarDetEnganche, 'id_det_enganche');
      }
      if (array_key_exists('nuevoEnganche', $data)) {
        foreach ($data['nuevoEnganche'] as $key => $dtoN) {
          $objNuevoEnganche=[];
          $objNuevoDetEnganche=[];
          $objNuevoEnganche[]=array(
            "forma_pago"=>$dtoN['forma_pago'],
            "id_lote"=>$dtoN['id_lote'],
            "fecha_creacion"=>date('Y-m-d\TH:i:s'),
            "id_creacion"=>$this->session->userdata('id_usuario'),
            "fecha_modificacion"=>NULL,
            "id_modificacion"=>NULL,
            "estatus"=>"1"
          );
          if (count($objNuevoEnganche)) {
            $dtoNuevoEnganche = $this->General_model->addRecord("enganche", $objNuevoEnganche); // MJ: LLEVA 2 PARÁMETROS $table
            $idEnganche = $this->db->insert_id();
            if(!empty($idEnganche)) {
              $objNuevoDetEnganche[]=array(
                "instrumento_monetario"=>$dtoN['instrumento_monetario'],
                "moneda_divisa"=>$dtoN['moneda_divisa'],
                "fecha_pago"=>$dtoN['fecha_pago'],
                "estatus"=>1,
                "idEnganche"=>$idEnganche
              );
              $dtoNuevoDetEnganche = $this->General_model->addRecord("det_enganche", $objNuevoDetEnganche); // MJ: LLEVA 2 PARÁMETROS
            } else
              $response = array( "status" => 2, "mensaje"=>"Error al obtener el id del enganche");
          } else
              $response = array( "status" => 2, "mensaje"=>"Error al llenar arreglo de nuevo enganche");            
        }
      }
      if ($dtoInstrumentoMonetario || $response['status']!=2 || $this->db->trans_status() === TRUE ) {
        $this->db->trans_commit();
        $response = array( "status" => 1, "mensaje"=>"Exito al traer los catalogos");
      } else  {
        $this->db->trans_rollback();
        $response = array( "status" => 0, "mensaje"=>"Error al traer los catalogos");
      }
    } catch (\Throwable $th) {
      $response = array( "status" => 0, "mensaje"=>"Error al ejecutar funcion de guardar enganche", "error"=> $th);
    }
    echo json_encode($response);
	}

// ----------------------------------------------------------------------------------------------------------------------------------------

}
