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
    public function descuentos_historial()
    {
        $this->load->view('template/header');
        $this->load->view("descuentos/descuentos_historial_view");
    }

    // vistas fin de las vistas de este controlador

    public function lista_estatus_descuentos(){
        echo json_encode($this->Descuentos_model->lista_estatus_descuentos()->result_array());
    }
    public function lista_estatus_descuentosEspecificos(){
        echo json_encode($this->Descuentos_model->lista_estatus_descuentosEspecificos()->result_array());
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

        $dato = $this->Descuentos_model->getPrestamoxUser($IdUsuario ,$tipo)->result_array();
        
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
            $respuesta =  $this->Descuentos_model->insertar_prestamos($insertArray);
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
        $saldo_comisiones = $this->input->post('saldo_comisiones');
        $LotesInvolucrados = "";
        $dat = 0;
        //incia INCIA EVIDENCIA 
        if($valor == 1 ){
            $nombreVariable = "evidencia";
        }else if($valor == 2 ){
            $nombreVariable = "evidencia2";
        }

        $file = $_FILES["$nombreVariable"];
        $bandera_move = 0;
        $bandera_subir = 0;
            if($_FILES["$nombreVariable"]["name"] != '' && $_FILES["$nombreVariable"]["name"] != null){
                $bandera_subir = 1;
                $aleatorio = rand(100,1000);
                $namedoc  = preg_replace('[^A-Za-z0-9]', '',$_FILES["$nombreVariable"]["name"]); 
                $date = date('dmYHis');
                $expediente = $date."_".$aleatorio."_".$namedoc;
                $ruta = "static/documentos/evidencia_prestamo_auto/";
                if(move_uploaded_file($_FILES["$nombreVariable"]["tmp_name"], $ruta.$expediente)){
                    $bandera_move = 1;
                    $bandera_subir = 1;    
                
                }else{
                    $bandera_move = 0;
                    $respuesta =  array(
                        "valor" => 0, 
                        "response_code" => 801, 
                        "response_type" => 'error',
                        "message" => "Documento subido inccorrectamente. inténtelo más tarde o comunicar a sistemas.");
                }       
            }else{
            $bandera_subir = 0;
            $respuesta =  array(
                "valor" => 0, 
                "response_code" => 800, 
                "response_type" => 'error',
                "message" => "Error Al subir el documento,  inténtelo más tarde o comunicar a sistemas.");
            }
    //finaliza EVIDENCIA

    // var_dump($bandera_subir);
    // var_dump('bandera_subir');
    // var_dump($bandera_move);
    // var_dump('bandera_move');
    // var_dump($valor);
    // var_dump('valor');
    if(($bandera_subir == 1 && $bandera_move == 1) || ($valor == 2)){ //inicio de bandera subir
        $tipo = $this->input->post('tipo');
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
            }//FIN DE UNIVERSIDAD



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
                    $dat1 =  $this->Descuentos_model->update_descuentoEsp($id,$Restante,$comentario, $this->session->userdata('id_usuario'),$valor,$usuario);
                    $dat =  $this->Descuentos_model->insertar_descuentoEsp($usuario,$montoAinsertar,$comision[0]['id_comision'],$comentario,$this->session->userdata('id_usuario'),$pago_neodata,$valor,$expediente,$tipo);
                    if($dat1 == 1 && $dat2 == 1 ){
                        $respuesta =  array(
                            "valor" => 1, 
                            "response_code" => 200, 
                            "response_type" => 'success',
                            "message" => "Todo correcto continuar.");
                    }else{
                        $respuesta =  array(
                            "valor" => 0, 
                            "response_code" => 901, 
                            "response_type" => 'error',
                            "message" => "Error, por favor intentarlo nuevamente .");
                    }
                }else{
                    $num = $i +1;
                    if($comentario == 0 && floatval($valor) == 3){
                        $nameLote = $formatear[3];
                        $comentario = "DESCUENTO UNIVERSIDAD MADERAS LOTES INVOLUCRADOS:  $LotesInvolucrados (TOTAL DESCUENTO: $desc ), ".$num."° LOTE A DESCONTAR $nameLote, MONTO DISPONIBLE: $".number_format(floatval($monto), 2, '.', ',').", DESCUENTO DE: $".number_format(floatval($montoAinsertar), 2, '.', ',').", RESTANTE: $".number_format(floatval($Restante), 2, '.', ',')."    ";
                    }else{
                        $comentario = $this->input->post("comentario");
                    }
                    $dat3 =  $this->Descuentos_model->update_descuento($id,$montoAinsertar,$comentario, $saldo_comisiones, $this->session->userdata('id_usuario'),$valor,$usuario,$pagos_apli);
                    $dat4 =  $this->Descuentos_model->insertar_descuento($usuario,$Restante,$comision[0]['id_comision'],$comentario,$this->session->userdata('id_usuario'),$pago_neodata,$valor,$expediente,$tipo);
                    if($dat4 == 1 && $dat3 == 1 ){
                        $respuesta =  array(
                            "valor" => 1, 
                            "response_code" => 200, 
                            "response_type" => 'success',
                            "message" => "Todo correcto continuar.");
                    }else{
                        $respuesta =  array(
                            "valor" => 0, 
                            "response_code" => 901, 
                            "response_type" => 'error',
                            "message" => "Error, por favor intentarlo nuevamente .");
                    }
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
                }else{ $comentario = $this->input->post("comentario"); }
                    $dat = $this->Descuentos_model->update_descuento($id,0,$comentario, $saldo_comisiones, $this->session->userdata('id_usuario'),$valor,$usuario, $pagos_apli);
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
                    $dat5 =  $this->Descuentos_model->update_descuentoEsp($id,$montoAinsertar,$comentario, $this->session->userdata('id_usuario'),$valor,$usuario);
                    $dat6 =  $this->Descuentos_model->insertar_descuentoEsp($usuario,$Restante,$comision[0]['id_comision'],$comentario,$this->session->userdata('id_usuario'),$pago_neodata,$valor,$expediente,$tipo);
                    if($dat5 == 1 && $dat6 == 1 ){
                        $respuesta =  array(
                            "valor" => 1, 
                            "response_code" => 200, 
                            "response_type" => 'success',
                            "message" => "Todo correcto continuar.");
                    }else{
                        $respuesta =  array(
                            "valor" => 0, 
                            "response_code" => 901, 
                            "response_type" => 'error',
                            "message" => "Error, por favor intentarlo nuevamente .");
                    }

                }else{
                    $dat7 =  $this->Descuentos_model->update_descuento($id,$descuento,$comentario, $saldo_comisiones, $this->session->userdata('id_usuario'),$valor,$usuario,$pagos_apli);
                    $dat8 =  $this->Descuentos_model->insertar_descuento($usuario,$montoAinsertar,$comision[0]['id_comision'],$comentario,$this->session->userdata('id_usuario'),$pago_neodata,$valor,$expediente,$tipo);
                    if($dat8 == 1 && $dat7 == 1 ){
                        $respuesta =  array(
                            "valor" => 1, 
                            "response_code" => 200, 
                            "response_type" => 'success',
                            "message" => "Todo correcto continuar.");
                    }else{
                        $respuesta =  array(
                            "valor" => 0, 
                            "response_code" => 901, 
                            "response_type" => 'error',
                            "message" => "Error, por favor intentarlo nuevamente .");
                    }

                    }
            }
    } // fin  de if bandera subir 
    else {
        $respuesta =  array(
            "valor" => 0, 
            "response_code" => 808, 
            "response_type" => 'error',
            "message" => "No entro al if mayor cominicarse.");
    }

    echo json_encode($respuesta);  
    }
    // FIN DE saveDescuento
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
        $beginDate = $this->input->post("beginDate") != 0 ?  date("Y-m-d", strtotime($this->input->post("beginDate"))) : 0;
        $endDate = $this->input->post("endDate") != 0 ? date("Y-m-d", strtotime($this->input->post("endDate"))) : 0;
        $res["data"] = $this->Descuentos_model->getPrestamos($beginDate,$endDate)->result_array();
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
                    "creado_por" => 1,
                    "estatus"   => 1
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

    public function motivosOpc(){
        echo json_encode($this->Descuentos_model->motivosOpc());
    }
    public function toparPrestamo(){
        echo json_encode($this->Descuentos_model->toparPrestamo($this->input->post("id_prestamo"),$this->input->post("pagado"),$this->session->userdata('id_usuario')));
    }
    public function getDatosView(){
        $data = array(
            "puestos" => $this->General_model->getCatOptionsEspecific(1,'1,2,3,7,9,38,59')->result_array(),
            "usuarios" => $this->General_model->getUsers('1,2,3,7,9','1,3')->result_array(),
            "tipoDescuento" => $this->Descuentos_model->lista_estatus_descuentos()->result_array(),
        );
        echo json_encode($data);
    }


    public function updateMotivo (){

        $file = $_FILES["evidencia"];
        $id_motivo = $this->input->post("id_motivo");
        $descripcion = $this->input->post("descripcion");
        $id_opcion = $this->input->post("id_opcion");
        
        if($_FILES["evidencia"]["name"] != '' && $_FILES["evidencia"]["name"] != null){
            $aleatorio = rand(100,1000);
            $namedoc  = preg_replace('[^A-Za-z0-9]', '',$_FILES["evidencia"]["name"]); 
            $date = date('dmYHis');
            $expediente = $date."_".$aleatorio."_".$namedoc;
            $ruta = "UPLOADS/EvidenciaGenericas/";
            if(move_uploaded_file($_FILES["evidencia"]["tmp_name"], $ruta.$expediente)){
                $bandera = 1;
                $UpdateArrayMotivo = array(
                    'estatus' => 0,
                    'modificado_por' => $this->session->userdata('id_usuario'),
                    'fecha_modificacion' => date("Y-m-d H:i:s")   
                );

            $motivosARRAY =  $this->Descuentos_model->updateMotivo($id_opcion,$UpdateArrayMotivo);

            }else{
                $bandera = 0;
                $respuesta =  array(
                    "response_code" => 800, 
                    "response_type" => 'error',
                    "message" => "Error Al subir el documento, inténtalo más tarde ");
                    
                }



            if ($bandera == 1 && $motivosARRAY  ) {
                $insertArray = array(
                    
                'id_opcion' => $id_opcion,
                'evidencia'    => "$expediente",
                'descripcion' => $descripcion ,
                'fecha_modificacion' => date("Y-m-d H:i:s"),
                'fecha_creacion' => date("Y-m-d H:i:s"),
                'modificado_por' => $this->session->userdata('id_usuario'),
                'creado_por'    => $this->session->userdata('id_usuario'),
                'estatus'       => 1,
                );
                $respuestas =  $this->Descuentos_model->insertarMotivoRelacion($insertArray);
                if($respuestas){
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
            }
        }
        echo json_encode ($respuesta);
        }

        public function dadoDeBajaMotivo (){
        $id_opcion = $this->input->post("id_opcion");
        if ( $id_opcion != '' ) {
            $insertArray = array(
            'estatus'    => 0
            );
            $existeDescuento = $this->Descuentos_model->validar($id_opcion);

            if($existeDescuento){
                $respuestas =  $this->Descuentos_model->dadoDeBajaMotivo($id_opcion,23,$insertArray);
                if($respuestas){
                    $respuesta =  array(
                        "response_code" => 200, 
                        "response_type" => 'success',
                        "message" => "Motivo dado de baja actualizado");
                }else{
                    $respuesta =  array(
                        "response_code" => 400, 
                        "response_type" => 'danger',
                        "message" => "Motivo no actualizado, inténtalo más tarde ");
                }
            }else {
                $respuesta =  array(
                    "response_code" => 450, 
                    "response_type" => 'warning',
                    "message" => "Imposible dar de baja el tipo, ya que se tienen descuentos activos");
            }
            
        }else {
            $respuesta =  array(
                "response_code" => 420, 
                "response_type" => 'warning',
                "message" => "Faltan datos al enviarse, inténtalo más tarde o comunicarse a sistemas");
        }
            
        echo json_encode ($respuesta);
        }

        public function historial_evidencia_general(){
            echo json_encode($this->Descuentos_model->historial_evidencia_general($this->input->post("id_opcion")));
        }


        public function UpdateDescuento(){
            $respuesta =  $this->Comisiones_model->UpdateDescuento($this->input->post("id_descuento"));
            echo json_encode($respuesta);
        }




}