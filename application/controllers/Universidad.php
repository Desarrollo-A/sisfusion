<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Universidad extends CI_Controller
{
  public function __construct() {
    parent::__construct();
    $this->load->model('Universidad_model');
    $this->load->library(array('session', 'form_validation', 'get_menu', 'Jwt_actions','permisos_sidebar'));
    $this->load->helper(array('url', 'form'));
    $this->load->database('default');
    $this->jwt_actions->authorize('1900', $_SERVER['HTTP_HOST']);
    $this->validateSession();
    $val =  $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
    $_SESSION['rutaController'] = str_replace('' . base_url() . '', '', $val);
    $rutaUrl = substr($_SERVER["REQUEST_URI"],1);
    $this->permisos_sidebar->validarPermiso($this->session->userdata('datos'),$rutaUrl,$this->session->userdata('opcionesMenu'));
}

    public function validateSession() {
        if ($this->session->userdata('id_usuario') == "" || $this->session->userdata('id_rol') == "")
        redirect(base_url() . "index.php/login");
    }

    public function index(){
        redirect(base_url());
    }

    function conglomerado_descuentos(){
        $datos = array();
        $datos["certificaciones"] = $this->Universidad_model->getCertificaciones();
        $this->load->view('template/header');
        $this->load->view("universidad/conglomerado",$datos);
    }

    function getDescuentosUniversidad($tipoDescuento){
        $data['data']= $this->Universidad_model->getDescuentosUniversidad($tipoDescuento);
        
        if ($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
        exit;
    }

    function toparDescuentoUniversidad(){
        $respuesta = array($this->Universidad_model->toparDescuentoUniversidad($this->input->post("usuarioTopar"), $this->input->post("comentarioTopar") ));
        echo json_encode( $respuesta );
    }

    public function altaNuevoDescuentoUM(){
        $usuario = $this->input->post("usuarios");
        $montoDescuento = str_replace(",",'',$this->input->post('montoDescuento'));
        $montoFinalDescuento = str_replace("$",'',$montoDescuento);
        $numeroMeses = $this->input->post("numeroMeses"); 
        $montoMensualidad = str_replace(",",'',$this->input->post('montoMensualidad'));
        $montoFinalMensualidad = str_replace("$",'',$montoMensualidad);
        $descripcionAltaDescuento = $this->input->post("descripcionAltaDescuento"); 
        $voBoUsuario = $this->Universidad_model->validarNuevoDescuentoUM($usuario);
    
        if($voBoUsuario > 0){
        $data = 0;
        }else{
        $data = $this->Universidad_model->altaNuevoDescuentoUM($usuario, $montoFinalDescuento, $numeroMeses, $montoFinalMensualidad, $descripcionAltaDescuento, $this->session->userdata('id_usuario')); 
        }
        echo json_encode($data);
    }

    public function get_lista_roles()
    {
      echo json_encode($this->Universidad_model->get_lista_roles()->result_array());
    }

    public function getUsuariosUM($rol){
        echo json_encode($this->Universidad_model->getUsuariosUM($rol)->result_array());
    }

    public function getCommentsDU($user){
        echo json_encode($this->Universidad_model->getCommentsDU($user)->result_array());
    }

    public function getPagosByUser($user,$mes,$anio){
        $dat =  $this->Universidad_model->getPagosByUser($user,$mes,$anio)->result_array();
        echo json_encode( $dat);
    }

    public function getLotesDescuentosUniversidad($user,$valor){
      echo json_encode($this->Universidad_model->getLotesDescuentosUniversidad($user,$valor));
    } 
   
  public function aplicarDescuentoUMComisiones() {
    $saldo_comisiones = $this->input->post('saldoComisiones');
    $LotesInvolucrados = "";
    $datos =  $this->input->post("arrayLotes[]");
    $desc =  $this->input->post("montoaDescontar");
    $usuario = $this->input->post("usuarioId");
    $comentario = $this->input->post("comentario");

    $cuantosLotes = count($datos);
    $comentario=0;
    for($i=0; $i <$cuantosLotes ; $i++) 
    { 
        $formatear = explode(",",$datos[$i]);
        $nameLoteComent = $formatear[3];
        $LotesInvolucrados =  $LotesInvolucrados." ".$nameLoteComent.",\n"; // Disponible: $".number_format($montoComent, 2, '.', ',')."\n"; 
    }

    $descuent0 = str_replace(",",'',$desc);
    $descuento = str_replace("$",'',$descuent0);

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
          $comision = $this->Universidad_model->obtenerID($id)->result_array();
        
          $num = $i +1;
          $nameLote = $formatear[3];
          $comentario = "DESCUENTO UNIVERSIDAD MADERAS LOTES INVOLUCRADOS:  $LotesInvolucrados (TOTAL DESCUENTO: $desc ), ".$num."° LOTE A DESCONTAR $nameLote, MONTO DISPONIBLE: $".number_format(floatval($monto), 2, '.', ',').", DESCUENTO DE: $".number_format(floatval($montoAinsertar), 2, '.', ',').", RESTANTE: $".number_format(floatval($Restante), 2, '.', ',')."    ";
          $dat =  $this->Universidad_model->update_descuento($id,$montoAinsertar,$comentario, $saldo_comisiones, $this->session->userdata('id_usuario'),$usuario);
          $dat =  $this->Universidad_model->insertar_descuento($usuario,$Restante,$comision[0]['id_comision'],$comentario,$this->session->userdata('id_usuario'),$pago_neodata);
        
        }else{
          $formatear = explode(",",$datos[$i]);
          $id=$formatear[0];
          $monto = $formatear[1]; 
          $pago_neodata = $formatear[2];
          $nameLote = $formatear[3];
          $num = $i +1;
          $comentario = "DESCUENTO UNIVERSIDAD MADERAS LOTES INVOLUCRADOS:  $LotesInvolucrados ( TOTAL DESCUENTO $desc ), ".$num."° LOTE A DESCONTAR $nameLote, MONTO DISPONIBLE: $".number_format(floatval($monto), 2, '.', ',').", DESCUENTO DE: $".number_format(floatval($monto), 2, '.', ',').", RESTANTE: $".number_format(floatval(0), 2, '.', ',')." ";
          $dat = $this->Universidad_model->update_descuento($id,0,$comentario, $saldo_comisiones, $this->session->userdata('id_usuario'),$usuario);
          $sumaMontos = $sumaMontos + $monto;
        }
      }
    } else{
        $formatear = explode(",",$datos[0]);
        $id = $formatear[0];
        $monto = $formatear[1];
        $pago_neodata = $formatear[2];
        $montoAinsertar = $monto - $descuento;
        $Restante = $monto - $montoAinsertar;
        $comision = $this->Universidad_model->obtenerID($id)->result_array();
        $dat =  $this->Universidad_model->update_descuento($id,$descuento,$comentario, $saldo_comisiones, $this->session->userdata('id_usuario'),$usuario);
        $dat =  $this->Universidad_model->insertar_descuento($usuario,$montoAinsertar,$comision[0]['id_comision'],$comentario,$this->session->userdata('id_usuario'),$pago_neodata);
    }
    echo json_encode($dat);    
  }


}