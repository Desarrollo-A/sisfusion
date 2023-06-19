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
        $datos = $this->get_menu->get_menu_data($this->session->userdata('id_rol'), $this->session->userdata('id_usuario'));
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

  // public function getListaRetiros($id)
  // {
  //     echo json_encode($this->Prestamos_model->getListaRetiros($id)->result_array());
  // }

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
    $IdUsuario = $this->input->post("usuarioid");
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

}