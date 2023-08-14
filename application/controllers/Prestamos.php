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
    $this->load->library(array('session', 'form_validation', 'get_menu', 'Jwt_actions','permisos_sidebar'));
    $this->load->helper(array('url', 'form'));
    $this->load->database('default');
    $this->jwt_actions->authorize('8271', $_SERVER['HTTP_HOST']);
    $this->validateSession();

    $val =  $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
    $_SESSION['rutaController'] = str_replace('' . base_url() . '', '', $val);
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

public function getInformacionData($lote,$valor)
{
  echo json_encode($this->Prestamos_model->getInformacionData($lote,$valor)->result_array());
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
      $comision = $this->Prestamos_model->obtenerID($id)->result_array();
      if($valor == 2){
        $dat =  $this->Prestamos_model->update_descuentoEsp($id,$Restante,$comentario, $this->session->userdata('id_usuario'),$valor,$usuario);
      $dat =  $this->Prestamos_model->insertar_descuentoEsp($usuario,$montoAinsertar,$comision[0]['id_comision'],$comentario,$this->session->userdata('id_usuario'),$pago_neodata,$valor);
      
      }else{
        $num = $i +1;
        if($comentario == 0 && floatval($valor) == 3){
          $nameLote = $formatear[3];

          $comentario = "DESCUENTO UNIVERSIDAD MADERAS LOTES INVOLUCRADOS:  $LotesInvolucrados (TOTAL DESCUENTO: $desc ), ".$num."° LOTE A DESCONTAR $nameLote, MONTO DISPONIBLE: $".number_format(floatval($monto), 2, '.', ',').", DESCUENTO DE: $".number_format(floatval($montoAinsertar), 2, '.', ',').", RESTANTE: $".number_format(floatval($Restante), 2, '.', ',')."    ";
        }else{
          $comentario = $this->input->post("comentario");
        }
        $dat =  $this->Prestamos_model->update_descuento($id,$montoAinsertar,$comentario, $saldo_comisiones, $this->session->userdata('id_usuario'),$valor,$usuario,$pagos_apli);
      $dat =  $this->Prestamos_model->insertar_descuento($usuario,$Restante,$comision[0]['id_comision'],$comentario,$this->session->userdata('id_usuario'),$pago_neodata,$valor);
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
      $dat = $this->Prestamos_model->update_descuento($id,0,$comentario, $saldo_comisiones, $this->session->userdata('id_usuario'),$valor,$usuario, $pagos_apli);
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

      $comision = $this->Prestamos_model->obtenerID($id)->result_array();

      if($valor == 2){

      $dat =  $this->Prestamos_model->update_descuentoEsp($id,$montoAinsertar,$comentario, $this->session->userdata('id_usuario'),$valor,$usuario);
        $dat =  $this->Prestamos_model->insertar_descuentoEsp($usuario,$Restante,$comision[0]['id_comision'],$comentario,$this->session->userdata('id_usuario'),$pago_neodata,$valor);
      }else{
        $dat =  $this->Prestamos_model->update_descuento($id,$descuento,$comentario, $saldo_comisiones, $this->session->userdata('id_usuario'),$valor,$usuario,$pagos_apli);
        $dat =  $this->Prestamos_model->insertar_descuento($usuario,$montoAinsertar,$comision[0]['id_comision'],$comentario,$this->session->userdata('id_usuario'),$pago_neodata,$valor);

      }
  }
  echo json_encode($dat);    
}

 

}