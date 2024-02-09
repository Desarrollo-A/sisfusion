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


    // vistas inicio de las vistas de este controlador
    public function historial_prestamos(){
    $this->load->view('template/header');
    $this->load->view("descuentos/historial_prestamo_view");
    }

    public function descuentos_contraloria(){
        $this->load->view('template/header');
        $this->load->view("descuentos/descuentos_contraloria_view");
        }
    public function panel_descuentos(){
        $datos["descuentos"] =  $this->Descuentos_model->lista_estatus_descuentos()->result_array();
        $this->load->view('template/header');
        $this->load->view("descuentos/panel_descuentos", $datos);
    }

    public function historial_descuento(){
        $datos["descuentos"] =  $this->Descuentos_model->lista_estatus_descuentos()->result_array();
        $this->load->view('template/header');
        $this->load->view("descuentos/historial_descuento", $datos);
    }

    public function anticipo_pago(){
        $datos["descuentos"] =  $this->Descuentos_model->lista_estatus_descuentos()->result_array();
        $this->load->view('template/header');
        $this->load->view("descuentos/anticipo_pago_view", $datos);
    }
    public function panel_prestamos(){
        $datos["descuentos"] =  $this->Descuentos_model->lista_estatus_descuentos()->result_array();
        $this->load->view('template/header');
        $this->load->view("descuentos/panel_prestamos_view", $datos);
    }

    // vistas fin de las vistas de este controlador

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
        $bandera = 0;

        $tipo = $this->input->post("tipo");
        
        $banderaEvidencia = $this->input->post("banderaEvidencia");
        $file = $_FILES["evidencia"];
        $this->input->post("pago");
        $monto = $this->input->post("monto");
        $NumeroPagos = $this->input->post("numeroP");
        $IdUsuario = $this->input->post("usuarioid");
        $comentario = $this->input->post("comentario");
        $tipo = $this->input->post("tipo");
        $idUsu = intval($this->session->userdata('id_usuario')); 
        $pesos = str_replace(",", "", $monto);

        $dato = $this->Comisiones_model->getPrestamoxUser($IdUsuario ,$tipo)->result_array();
        
        if($_FILES["evidencia"]["name"] != '' && $_FILES["evidencia"]["name"] != null){
            $aleatorio = rand(100,1000);
            $namedoc  = preg_replace('[^A-Za-z0-9]', '',$_FILES["evidencia"]["name"]); 
            $date = date('dmYHis');
            $expediente = $date."_".$aleatorio."_".$namedoc;
            $ruta = "static/documentos/evidencia_prestamo_auto/";
            if(move_uploaded_file($_FILES["evidencia"]["tmp_name"], $ruta.$expediente)){
                $bandera = 1;
                
            }else{
                $bandera = 0;
                $respuesta =  array(
                    "response_code" => 800, 
                    "response_type" => 'error',
                    "message" => "Error Al subir el documento, inténtalo más tarde ");
                    var_dump('entro en 2');
                }
        }else if($banderaEvidencia == 0){
            $bandera = 2;
            $expediente = '';
            
        }else{
            
            $respuesta =  array(
                "response_code" => 810, 
                "response_type" => 'error',
                "message" => "Error con el documento, inténtalo más tarde ");
            }
        

        if ($bandera == 1 || $bandera == 2 ) {
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
                'evidenciaDocs'    => "$expediente"
            );
            $respuesta =  $this->Comisiones_model->insertar_prestamos($insertArray);
                if($respuesta){
                    $respuesta =  array(
                    "response_code" => 200, 
                    "response_type" => 'success',
                    "message" => "Préstamo se ha dado de alta correctamente");
                }else{
                    $respuesta =  array(
                        "response_code" => 811, 
                        "response_type" => 'error',
                        "message" => "El préstamo no se ha podido insertar, inténtalo más tarde");
                }
                
        
            } else{
                $respuesta =  array(
                    "response_code" => 803, 
                    "response_type" => 'warning',
                    "message" => "El usuario seleccionado ya tiene un préstamo activo, inténtalo más tarde ");
            }
        } else{
            
            $respuesta =  array(
                "response_code" => 803, 
                "response_type" => 'warning',
                "message" => "No entra en ninguna bandera, inténtalo más tarde ");
            
        }
        echo json_encode($respuesta);
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

    public function getDetallePrestamo($idPrestamo){
        $general = $this->Descuentos_model->getGeneralDataPrestamo($idPrestamo);
        $detalle = $this->Descuentos_model->getDetailPrestamo($idPrestamo);
        echo json_encode(array(
            'general' => $general,
            'detalle' => $detalle
            ));
    }

    public function getHistorialPrestamos(){
        $res["data"] = $this->Descuentos_model->getHistorialPrestamo()->result_array();
        echo json_encode($res);
    }

    public function getPrestamos(){
            $res["data"] = $this->Descuentos_model->getPrestamos()->result_array();
            echo json_encode($res);
    }

    public function updatePrestamos (){
        $pagoEdit = $this->input->post('pagoEdit');
        $Numero_pagos = $this->input->post('numeroPagos'); 
        $montoPagos = $this->input->post('montoPagos');
        $comentario = $this->input->post('comentario');
        $id_prestamo = $this->input->post('prestamoId');
        $tipoD = $this->input->post('tipoD');
        $arr_update = array(
            "monto" => $pagoEdit,
            "num_pagos" => $Numero_pagos,
            "pago_individual" => $montoPagos,
            "comentario" => $comentario,
            "modificado_por" => 1,
            "tipo" => $tipoD
        );
        
        $update = $this->Descuentos_model->updatePrestamosEdit($id_prestamo  , $arr_update);
        if($update){
            $respuesta =  array(
            "response_code" => 200, 
            "response_type" => 'success',
            "message" => "Préstamo actualizado");
        } else{
            $respuesta =  array(
            "response_code" => 400, 
            "response_type" => 'error',
            "message" => "Préstamo no actualizado, inténtalo más tarde ");
        }
        
        echo json_encode ($respuesta);
        }
    
        
        public function BorrarPrestamo(){
            $respuesta =  $this->Descuentos_model->BorrarPrestamo($this->input->post("idPrestamo"));
            echo json_encode($respuesta);
        }

        
        public function altaMotivo (){
            $MotivoAlta = $this->input->post('MotivoAlta');
            $valorCheck = $this->input->post('valorCheck'); 
            $descripcionAlta = $this->input->post('descripcionAlta');
            $respuesta  =  $this->Descuentos_model->traerElUltimo();
            $ID_OPCION  = ($respuesta->id_opcion+1);
            $archivo    = $this->input->post('archivo');
            $color = $this->input->post('textoPruebas');
            $bandera = 0;
            $expediente = '';
            if($valorCheck == 'true' ){
                $valorCheck = 'true'; 
                $bandera = 2;
            }else{
                if($_FILES["evidencia"]["name"] != '' && $_FILES["evidencia"]["name"] != null){
                    $aleatorio = rand(100,1000);
                    $namedoc  = preg_replace('[^A-Za-z0-9]', '',$_FILES["evidencia"]["name"]); 
                    $date = date('dmYHis');
                    $expediente = $date."_".$aleatorio."_".$namedoc;
                    $ruta = "UPLOADS/EvidenciaGenericas/";
                }

                if (move_uploaded_file($_FILES["evidencia"]["tmp_name"], $ruta.$expediente)) {
                    $bandera = 1;
                } // llave para subir el documento
                else{
                    $bandera = 0;
                    $respuesta =  array(
                        "response_code" => 600, 
                        "response_type" => 'error',
                        "message" => "Error en Al subir el documento, inténtalo más tarde ");
                
                }
            }
            if($bandera == 1 || $bandera == 2 ){
                $insert = array(
                    "id_opcion" => ($ID_OPCION),
                    "id_catalogo" => 23,
                    "nombre" => $MotivoAlta,
                    "estatus"     => 1,
                    "fecha_creacion" => date("Y-m-d H:i:s"),
                    "creado_por"  => 1,
                    "color" => $color
                );
    
                $idigreso =  $this->Descuentos_model->insertarMotivo($insert);

                if($valorCheck == 'true'){
                    
                }else if($valorCheck == 'false' ||  $valorCheck == 0  ){
                    
                    $valorCheck = $expediente;
                    
                }
                
                if($idigreso != 0){
                $insertRelacion = array(                
                    "id_opcion" => ($ID_OPCION),
                    "evidencia" => $valorCheck,
                    "descripcion" => $descripcionAlta,
                    "fecha_creacion" => date("Y-m-d H:i:s"),
                    "fecha_modificacion" => date("Y-m-d H:i:s"),
                    "modificado_por"  => 1,
                    "creado_por" => 1
                );
                $respuestaMotivoRelacion =  $this->Descuentos_model->insertarMotivoRelacion($insertRelacion);
                
                    if($respuestaMotivoRelacion){
                        $respuesta =  array(
                        "response_code" => 200, 
                        "response_type" => 'success',
                        "message" => "Se agregó el nuevo motivo");
                    } else{
                        $respuesta =  array(
                        "response_code" => 411, 
                        "response_type" => 'error',
                        "message" => "Error en insertar en motivo-relación, inténtalo más tarde ");
                    }
    
                }else{
                    $respuesta =  array(
                        "response_code" => 410, 
                        "response_type" => 'error',
                        "message" => "Error en ingresar el Motivo, inténtalo más tarde ");
                }
            }

            echo json_encode ($respuesta);
            }



    
    public function idOpcionMotivosRelacionPrestamos(){
        $respuesta =  $this->Descuentos_model->getRelacionPrestamos($this->input->post("id_opcion"));

        echo json_encode($respuesta);
    }


    public function getDescuentos(){
        $res["data"] = $this->Descuentos_model->getDescuentos()->result_array();
        echo json_encode($res);
    }

}