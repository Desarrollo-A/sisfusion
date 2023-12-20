<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Descuentos extends CI_Controller
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
    $this->load->model('Descuentos_model');
    $this->load->library(array('session', 'form_validation', 'get_menu', 'Jwt_actions','permisos_sidebar'));
    $this->load->helper(array('url', 'form'));
    $this->load->database('default');
    $this->jwt_actions->authorize('0606', $_SERVER['HTTP_HOST']);
    $this->validateSession();
    $rutaUrl = explode($_SESSION['rutaActual'], $_SERVER["REQUEST_URI"]);
    $this->permisos_sidebar->validarPermiso($this->session->userdata('datos'),$rutaUrl[1],$this->session->userdata('opcionesMenu'));
    }

    public function index(){
    redirect(base_url());
    }

    public function validateSession(){
        if ($this->session->userdata('id_usuario') == "" || $this->session->userdata('id_rol') == "")
        redirect(base_url() . "index.php/login");
    }
    public function historial_prestamos(){
    $this->load->view('template/header');
    $this->load->view("descuentos/historial_prestamo_view");
    }


    public function panel_descuentos(){
        $datos["descuentos"] =  $this->Descuentos_model->lista_estatus_descuentos()->result_array();
        $this->load->view('template/header');
        $this->load->view("descuentos/panel_descuentos", $datos);
    }
 
    public function lista_estatus_descuentos(){
        echo json_encode($this->Descuentos_model->lista_estatus_descuentos()->result_array());
    }

    
    public function getUsuariosRol($rol,$opc = ''){
    if($opc == ''){
        echo json_encode($this->Descuentos_model->getUsuariosRol($rol)->result_array());
    } else{
        echo json_encode($this->Descuentos_model->getUsuariosRol($rol,$opc)->result_array());
    }
    }

    public function savePrestamo(){
        $this->input->post("pagoDescuento");
        $monto = $this->input->post("montoDescuentos");
        $NumeroPagos = $this->input->post("numeroP");
        $IdUsuario = $this->input->post("usuarioidDescuento");
        $comentario = $this->input->post("comentarioDescuento");
        $tipo = $this->input->post("tipo");
        $idUsu = intval($this->session->userdata('id_usuario')); 
        $pesos = str_replace(",", "", $monto);
        $dato = $this->Descuentos_model->getPrestamoxUser($IdUsuario ,$tipo)->result_array();
        
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
            
            $respuesta =  $this->Descuentos_model->insertar_prestamos($insertArray);
            echo json_encode($respuesta);
        } else{
            $respuesta = 3;
            echo json_encode($respuesta);
        }
        }
    
        public function getLotesOrigen($user,$valor){
            echo json_encode($this->Descuentos_model->getLotesOrigen($user,$valor)->result_array());
        }
        public function getInformacionData($lote,$valor){
            echo json_encode($this->Descuentos_model->getInformacionData($lote,$valor)->result_array());
        }



        
    public function saveDescuento($valor) {
        $saldo_comisiones = $this->input->post('saldoComisiones');
        $LotesInvolucrados = "";

        if(floatval($valor) == 1){
        $datos =  $this->input->post("idloteorigen[]");
        $descuento = $this->input->post("montoContraloria");
        $usuario = $this->input->post("usuarioid");
        $comentario = $this->input->post("comentarioDescuentoM2");
        $descuent0 = str_replace(",",'',$descuento);
        $descuento = str_replace("$",'',$descuent0);
        }else if(floatval($valor) == 2){
        $datos =  $this->input->post("idloteorigen2[]");
        $descuento = $this->input->post("monto2");
        $usuario = $this->input->post("usuarioid2");
        $comentario = $this->input->post("comentario2");
        $descuent0 = str_replace(",",'',$descuento);
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
            $comision = $this->Descuentos_model->obtenerID($id)->result_array();
            
            if($valor == 2){
                $dat =  $this->Descuentos_model->update_descuentoEsp($id,$Restante,$comentario, $this->session->userdata('id_usuario'),$valor,$usuario);
                $dat =  $this->Descuentos_model->insertar_descuentoEsp($usuario,$montoAinsertar,$comision[0]['id_comision'],$comentario,$this->session->userdata('id_usuario'),$pago_neodata,$valor);
            } else{
                $num = $i +1;
                $dat =  $this->Descuentos_model->update_descuento($id,$montoAinsertar,$comentario, $saldo_comisiones, $this->session->userdata('id_usuario'),$valor,$usuario);
                $dat =  $this->Descuentos_model->insertar_descuento($usuario,$Restante,$comision[0]['id_comision'],$comentario,$this->session->userdata('id_usuario'),$pago_neodata,$valor);
            }
            } else{
            $formatear = explode(",",$datos[$i]);
            $id=$formatear[0];
            $monto = $formatear[1]; 
            $pago_neodata = $formatear[2];
            $dat = $this->Descuentos_model->update_descuento($id,0,$comentario, $saldo_comisiones, $this->session->userdata('id_usuario'),$valor,$usuario);
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
        $comision = $this->Descuentos_model->obtenerID($id)->result_array();
        
        if($valor == 2){
            $dat =  $this->Descuentos_model->update_descuentoEsp($id,$montoAinsertar,$comentario, $this->session->userdata('id_usuario'),$valor,$usuario);
            $dat =  $this->Descuentos_model->insertar_descuentoEsp($usuario,$Restante,$comision[0]['id_comision'],$comentario,$this->session->userdata('id_usuario'),$pago_neodata,$valor);
        } else{
            $dat =  $this->Descuentos_model->update_descuento($id,$descuento,$comentario, $saldo_comisiones, $this->session->userdata('id_usuario'),$valor,$usuario);
            $dat =  $this->Descuentos_model->insertar_descuento($usuario,$montoAinsertar,$comision[0]['id_comision'],$comentario,$this->session->userdata('id_usuario'),$pago_neodata,$valor);
        }
        }
        echo json_encode($dat);    
    }
}