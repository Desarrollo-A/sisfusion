<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

use PhpOffice\PhpSpreadsheet\Spreadsheet;


class Prestamos extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Prestamos_model');
    $this->load->library(array('session', 'form_validation', 'get_menu', 'Jwt_actions'));
    $this->load->helper(array('url', 'form'));
    $this->load->database('default');
    $this->jwt_actions->authorize('8271', $_SERVER['HTTP_HOST']);
    $this->validateSession();

    $val =  $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
    $_SESSION['rutaController'] = str_replace('' . base_url() . '', '', $val);
  }
   public function index(){
    redirect(base_url());
  }

  public function validateSession() {
    if ($this->session->userdata('id_usuario') == "" || $this->session->userdata('id_rol') == "")
      redirect(base_url() . "index.php/login");
  }

  public function activos() {
    if ($this->session->userdata('id_rol') == FALSE)
        redirect(base_url());
        $datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'), $this->session->userdata('id_usuario'), $this->session->userdata('estatus'));
        $this->load->view('template/header');
        $this->load->view("prestamos/activos-view", $datos);
  }

  public function historial() {
    if ($this->session->userdata('id_rol') == FALSE) {
        redirect(base_url());
    }
    $this->load->view('template/header');
    $this->load->view("prestamos/historial-view");
  }

  public function getPrestamos()
  {
    $data["data"] = $this->Prestamos_model->getPrestamos()->result_array();
    echo json_encode($data);
  }

  public function getDetallePrestamo($idPrestamo)
  {
      $general = $this->Prestamos_model->getGeneralDataPrestamo($idPrestamo);
      $detalle = $this->Prestamos_model->getDetailPrestamo($idPrestamo);
      echo json_encode(array(
          'general' => $general,
          'detalle' => $detalle
      ));
  }

  public function lista_estatus_descuentos()
  {
    echo json_encode($this->Prestamos_model->lista_estatus_descuentos()->result_array());
  }
 
  public function getRoles()
  {
    $catalogo = $this->input->post("catalogo");
    $roles = $this->input->post("roles");
    echo json_encode($this->Prestamos_model->getRoles($catalogo,$roles)->result_array());
  }

  public function getUsuariosRol($rol,$opc = '')
  {
    if($opc == ''){
      echo json_encode($this->Prestamos_model->getUsuariosRol($rol)->result_array());
    }else{
      echo json_encode($this->Prestamos_model->getUsuariosRol($rol,$opc)->result_array());

    }
  }


  public function savePrestamo()
  {
    $this->input->post("pago");
    $monto = $this->input->post("monto");
    $NumeroPagos = $this->input->post("numeroP");
    $IdUsuario = $this->input->post("usuarioPrestamos");
    $comentario = $this->input->post("comentario");
    $tipo = $this->input->post("tipo");
    $idUsu = intval($this->session->userdata('id_usuario')); 
    $pesos = str_replace(",", "", $monto);

    $dato = $this->Prestamos_model->getPrestamoxUser($IdUsuario ,$tipo)->result_array();

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
              'tipo'            => $tipo
            );
            $respuesta =  $this->Prestamos_model->insertar_prestamos($insertArray);
            echo json_encode($respuesta);
    }else{
            $respuesta = 3;
            echo json_encode($respuesta);
    }
  }

  public function getLotesOrigen($user,$valor)
  {
    echo json_encode($this->Prestamos_model->getLotesOrigen($user,$valor)->result_array());
  }


  public function editarPrestamo (){
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

      $update = $this->Prestamos_model->editarPrestamo($id_prestamo  , $arr_update);
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



public function BorrarPrestamo(){
  $respuesta =  $this->Prestamos_model->BorrarPrestamo($this->input->post("idPrestamo"));
echo json_encode($respuesta);

}

}