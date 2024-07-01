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
    public function panel_descfuentos(){
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
    

    // 
    // 
    // aqui vamos 
    
    public function anticipo()
    {
        $this->load->view('template/header');
        switch($this->session->userdata('id_rol')){
            case '7':
            case '9':
            case '3':
            // $datos["controversias"] = $this->Comisiones_model->getMotivosControversia();
            $this->load->view("descuentos/anticipo/anticipo_descuento_view");
            break;
            case '2':
            case '5':
                // $datos["controversias"] = $this->Comisiones_model->getMotivosControversia();
                $this->load->view("descuentos/anticipo/solicitudes_view");
            break;
            case '4':
            case '1':    
                $this->load->view("descuentos/anticipo/anticipo_descuento_dc_view");
            break;
                
            default:
                
        
        break;
        }
    }
    
    public function getComments($id){
        // $id_pago = $this->input->post("id_pago");
        echo json_encode($this->Descuentos_model->getComments($id));
    }

    // 
    // 




    // vistas fin de las vistas de este controlador

    public function lista_estatus_descuentos(){
        echo json_encode($this->Descuentos_model->lista_estatus_descuentos()->result_array());
    }
    public function lista_estatus_descuentosEspecificos(){
        echo json_encode($this->Descuentos_model->lista_estatus_descuentosEspecificos()->result_array());
    }

    public function lista_descuentosEspecificos(){
        echo json_encode($this->Descuentos_model->lista_descuentosEspecificos()->result_array());
    }

    public function busqueda_true($data){
        $dat = $this->Descuentos_model->busqueda_true($data);
        echo json_encode($dat);
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
        echo json_encode($this->Descuentos_model->getLotesOrigen($user,$valor));
    }
    public function getInformacionData($lote,$valor){
        echo json_encode($this->Descuentos_model->getInformacionData($lote,$valor)->result_array());
    }
    
    public function saveDescuento($valor) {
        $saldo_comisiones = $this->input->post('saldo_comisiones');
        $motivos = $this->input->post("motivo");
        $LotesInvolucrados = "";

       
        if($valor == 1 ){
            $nombreVariable = 'evidenciaSwitch';
        }else if($valor == 2 ){
            $nombreVariable = 'evidenciaSwitchDIV2';
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
                    $expediente = null;
                    $respuesta =  array(
                        "valor" => 0, 
                        "response_code" => 801, 
                        "response_type" => 'error',
                        "message" => "Documento subido inccorrectamente. inténtelo más tarde o comunicar a sistemas.");
                   
                }       
            }else{
            $bandera_subir = 0;
            $expediente = null;
            $respuesta =  array(
                "valor" => 0, 
                "response_code" => 800, 
                "response_type" => 'error',
                "message" => "Error Al subir el documento,  inténtelo más tarde o comunicar a sistemas.");
            }

  
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
            // Viene con mas de un pago
            // creas un variable 
          $sumaMontos = 0;
       
          for($i=0; $i <$cuantos ; $i++) { 
            $bandera = $i;
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
            
            }else{
              $num = $i +1;
              if($comentario == 0 && floatval($valor) == 3){
                $nameLote = $formatear[3];
  
                $comentario = "DESCUENTO UNIVERSIDAD MADERAS LOTES INVOLUCRADOS:  $LotesInvolucrados (TOTAL DESCUENTO: $desc ), ".$num."° LOTE A DESCONTAR $nameLote, MONTO DISPONIBLE: $".number_format(floatval($monto), 2, '.', ',').", DESCUENTO DE: $".number_format(floatval($montoAinsertar), 2, '.', ',').", RESTANTE: $".number_format(floatval($Restante), 2, '.', ',')."    ";
              }else{
                $comentario = $this->input->post("comentario");
              }
            $dat =  $this->Descuentos_model->update_descuento($id,$montoAinsertar,$comentario, $saldo_comisiones, $this->session->userdata('id_usuario'),$valor,$usuario,$pagos_apli,$this->input->post("motivo"),$this->input->post("prestamos"),$this->input->post("descuento"),$expediente,$descuento,$bandera);
            $dat =  $this->Descuentos_model->insertar_descuento($usuario,$Restante,$comision[0]['id_comision'],$comentario,$this->session->userdata('id_usuario'),$pago_neodata,$valor);
            $dat =  $this->Descuentos_model->update_estatus_prestamo();
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
            $dat = $this->Descuentos_model->update_descuento($id,0,$comentario, $saldo_comisiones, $this->session->userdata('id_usuario'),$valor,$usuario, $pagos_apli,$this->input->post("motivo"),$this->input->post("prestamos"),$this->input->post("descuento"),$expediente,$descuento,$bandera);
            $sumaMontos = $sumaMontos + $monto;
            
            }
  
      
          }
    
  
        }else{
            
            // Viene por un solo pago
            $bandera = -1;
            
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
            }else{
               

              $dat =  $this->Descuentos_model->update_descuento($id,$descuento,$comentario, $saldo_comisiones, $this->session->userdata('id_usuario'),$valor,$usuario,$pagos_apli,$this->input->post("motivo"),$this->input->post("prestamos"),$this->input->post("descuento"),$expediente,$cuantos,$bandera);
              $dat =  $this->Descuentos_model->insertar_descuento($usuario,$montoAinsertar,$comision[0]['id_comision'],$comentario,$this->session->userdata('id_usuario'),$pago_neodata,$valor);
            //   $dat =  $this->Descuentos_model->update_estatus_prestamo();
    
            }
        }
        echo json_encode($dat);    
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
            $respuesta =  $this->Descuentos_model->UpdateDescuento($this->input->post("id_descuento"));
            echo json_encode($respuesta);
        }


// 
// anticipo de pagos

        public function anticipo_pago_insert()
        {
            
            $this->db->trans_begin();

            
                // $insertArray
                $insertArray = array(
                'id_usuario'            => $this->session->userdata('id_usuario'),
                'monto'                 => $this->input->post('limpioMonto'),
                'comentario'            => $this->input->post('descripcionMotivo'),
                'estatus'               => 1,
                'proceso'               => 2,
                'impuesto'              => 3,
                'fecha_registro'        => date("Y-m-d H:i:s"),
                'prioridad'             => 1,
                'evidencia'             => '',
                'numero_mensualidades'    =>  $this->input->post('numeroPagosParcialidad')
                );
                
                $idAnticipo = $this->Descuentos_model->insertAdelanto($insertArray);
                // nace un anticipo
            
                // REVISAMOS EL TIPO DE ANTICIPO
                if($this->input->post('procesoTipo') != 1){
                    // viene por  apoyo se crea parcialidades  no se crea prestamo 
                    $insertArray_pran = array(
                        'id_anticipo'           =>  intval($idAnticipo) ,
                        'catalogo'              =>  intval($this->input->post('tiempo_de_pago')),
                        'fecha_creacion'        =>  date("Y-m-d H:i:s"),
                        'mensualidades'         =>  intval($this->input->post('numeroPagosParcialidad')) ,
                        'monto_parcialidad'     =>  $this->input->post('montoPrestadoParcialidad')
                    );
                    $tablaGenerica = 'parcialidad_relacion_anticipo' ;
                    $respuesta_PRA = $this->Descuentos_model->insertAdelantoGenerico($insertArray_pran,$tablaGenerica);
                }else{
                    // viene por prestamo.
                    $respuesta_PRA = true;
                }



                $insertArrayHistorial = array(
                'id_anticipo' => $idAnticipo,
                'id_usuario'  => $this->session->userdata('id_usuario'),
                'proceso'     => 1,
                'comentario'  => $this->input->post('descripcionMotivo'),
                'fecha_movimiento'        =>  date("Y-m-d H:i:s")            
                );

                $tablaHistorial = 'historial_anticipo' ;
                $respuestaHistorial = $this->Descuentos_model->insertAdelantoGenerico($insertArrayHistorial,$tablaHistorial);

                $insertArrayHistorial = array(
                    'id_anticipo' => $idAnticipo,
                    'id_usuario'  => $this->session->userdata('id_usuario'),
                    'proceso'     => 2,
                    'comentario'  => $this->input->post('descripcionMotivo')  ,
                    'fecha_movimiento'        =>  date("Y-m-d H:i:s")              
                    );
                    $tablaHistorial = 'historial_anticipo' ;
                    $respuestaHistorial1 = $this->Descuentos_model->insertAdelantoGenerico($insertArrayHistorial,$tablaHistorial);
                
                if($respuestaHistorial1 && $respuestaHistorial && $respuesta_PRA){
                    $respuesta =  array(
                        "response_code" => 200, 
                        "response_type" => 'success',
                        "message" => "Se ha dado de alta el anticipo puedes revisar el avance apartado  PROCESOS");
                        $this->db->trans_commit();  
                }else{
                    $respuesta =  array(
                        "response_code" => 400, 
                        "response_type" => 'danger',
                        "message" => "Error NO se ha dado el alta del anticipo");
                        $this->db->trans_rollback();  
                    }

                echo json_encode($respuesta);


        }


        public function historial_anticipo_avance()
        {
            $respuestaHistorial = $this->Descuentos_model->historial_anticipo_avance($insertArrayHistorial,$tablaHistorial);
        }

        public function todos_los_pasos()
        {
            $todos_los_pasos = $this->Descuentos_model->todos_los_pasos();
            echo json_encode($todos_los_pasos);
        }
        // public function 
        public function solicitudes_por_aticipo()
        {
            
            
            $todos_los_pasos = $this->Descuentos_model->solicitudes_por_aticipo();
            echo json_encode($todos_los_pasos);
        }
        public function solicitudes_generales_dc()
        {
            
            $todos_los_pasos = $this->Descuentos_model->solicitudes_generales_dc();
            echo json_encode($todos_los_pasos);
        }
        public function solicitudes_generales_reporte()
        {
            $bandera = $this->input->post('bandera');
            $todos_los_pasos = $this->Descuentos_model->solicitudes_generales_reporte($bandera);
            echo json_encode($todos_los_pasos);
        }
// anticipo de pagos
// 


        public function anticipo_update_generico(){
            $monto =  $this->input->post('monto');
            $id_anticipo =  $this->input->post('idAnticipo_Aceptar');
            $bandera= 1;
            $usuarioid = $this->session->userdata('id_usuario');
            if($this->input->post('proceso') != 0 ){
            
                if($this->input->post('bandera_a') == 1 ){  
                    $file = $_FILES["evidenciaNueva"];
                    if($_FILES["evidenciaNueva"]["name"] != '' && $_FILES["evidenciaNueva"]["name"] != null){
                    $aleatorio = rand(100,1000);
                    $namedoc  = preg_replace('[^A-Za-z0-9]', '',$_FILES["evidenciaNueva"]["name"]); 
                    $date = date('dmYHis');
                    $expediente = $date."_".$aleatorio."_".$namedoc;
                    $ruta = "static/documentos/solicitudes_anticipo/";
                    if(move_uploaded_file($_FILES["evidenciaNueva"]["tmp_name"], $ruta.$expediente)){
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
                    
                }
                }else{
                    $expediente = '';
                }
    
                if($this->input->post('proceso') ==6){
                    if($this->session->userdata('forma_pago') == 2){
                        // si aqui mero ocupamos la factura
                        if( isset( $_FILES ) && !empty($_FILES) ){
                            $config['upload_path'] = './UPLOADS/XML_Anticipo/';
                            $config['allowed_types'] = 'xml';
                            $this->load->library('upload', $config);
                            $resultado = $this->upload->do_upload("xmlfile");
                            
                            if( $resultado ){
                                $xml_subido = $this->upload->data();
                                $datos_xml = $this->Descuentos_model->leerxml( $xml_subido['full_path'], TRUE );
                                //var_dump($datos_xml['rfcreceptor'][0]);
                                //var_dump($datos_xml);
                                $nuevo_nombre = date("my")."_";
                                $nuevo_nombre .= str_replace( array(",", ".", '"'), "", str_replace( array(" ", "/"), "_", limpiar_dato($datos_xml["nameEmisor"]) ))."_";
                                $nuevo_nombre .= date("Hms")."_";
                                $nuevo_nombre .= rand(4, 100)."_";
                                $nuevo_nombre .= substr($datos_xml["uuidV"], -5)."_REFACTURA".".xml";
                                rename( $xml_subido['full_path'], "./UPLOADS/XML_Anticipo/".$nuevo_nombre );
                                $datos_xml['nombre_xml'] = $nuevo_nombre;
                                $this->Descuentos_model->insertar_factura($id_anticipo, $datos_xml,$usuarioid);

                            }

                        }
                        // $datos_xml = $this->Descuentos_model->leerxml( $xml_subido, TRUE );



                    }else{
                        // solo nos llevamos los pagos normales

                    }

                    
                    $insertArray = array(
                        'monto'         => $monto,
                        'estatus'       => $this->input->post('estatus'),
                        // 'evidencia'     => $expediente,
                        'proceso'       => $this->input->post('proceso'),
                        'prioridad'     => $this->input->post('seleccion')
                        );
                }else{
                    $insertArray = array(
                        'monto'         => $monto,
                        'evidencia'     => $expediente,
                        'proceso'       => $this->input->post('proceso'),
                        'prioridad'     => $this->input->post('seleccion')
                        );
                }
            }else{
                // cancelado
                
                $insertArray = array(
                    'estatus'       => 0,
                    // 'evidencia'     => $expediente,
                    'proceso'       => 0);

                    
            }
            
                
            
            $clave =  $id_anticipo;
            $llave = 'id_anticipo';
            $tabla = 'anticipo';
            $tabla_insert = 'historial_anticipo';


            $insertHistorial = array(
                'id_anticipo'       =>  intval( $id_anticipo),
                'id_usuario'        =>  intval($this->input->post('id_usuario')),
                'proceso'           =>  intval($this->input->post('proceso')),
                'comentario'        =>  $this->input->post('motivoDescuento_aceptar'),
                'fecha_movimiento'  =>  date("Y-m-d H:i:s")
                );

                $respuestaHistorial = $this->Descuentos_model->update_generico_aticipo($clave,$llave,$tabla,$insertArray);
                

                $respuestaHistorial2 = $this->Descuentos_model->insertAdelantoGenerico($insertHistorial, $tabla_insert);
                if($respuestaHistorial){
                    $respuesta =  array(
                        "response_code" => 200, 
                        "response_type" => 'success',
                        "message" => "Se cambio el estatus del anticipo");
                }else{
                    $respuesta =  array(
                        "response_code" => 400, 
                        "response_type" => 'danger',
                        "message" => "Error NO se ha dado el alta del anticipo");
                }
                echo json_encode($respuesta);
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
                $config['upload_path'] = './UPLOADS/XML_Anticipo';
                $config['allowed_types'] = 'xml';
              //CARGAMOS LA LIBRERIA CON LAS CONFIGURACIONES PREVIAS -----$this->upload->display_errors()
                $this->load->library('upload', $config);
            if( $this->upload->do_upload("xmlfile") ){
                $xml_subido = $this->upload->data()['full_path'];
                $datos_xml = $this->Descuentos_model->leerxml( $xml_subido, TRUE );
                    if( $datos_xml['version'] >= 3.3){
                    $responsable_factura = $this->Descuentos_model->verificar_uuid( $datos_xml['uuidV'] );
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
                            $respuesta['respuesta'] = array( FALSE, "LA UNIDAD NO ES 'E48 (UNIDAD DE SERVICIO)', VERIFIQUE SU FACTURA.");
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




            public function guardar_solicitud2($usuario = ''){
                if($usuario != ''){
                    $usuarioid = $usuario;
                }else{
                    $usuarioid = $this->session->userdata('id_usuario');
                }
                $validar_sede =  $this->session->userdata('id_sede');
                $mesActual = $this->db->query("SELECT MONTH(GETDATE()) AS mesActual")->row()->mesActual;
            
                $consultaTipoUsuario = $this->db->query("SELECT (CASE WHEN tipo = 2 THEN 1 ELSE 0 END) tipo FROM usuarios WHERE id_usuario IN (".$usuarioid.")")->result_array();
                $consultaFechasCorte = $this->db->query("SELECT * FROM fechasCorte WHERE estatus = 1 AND corteOoam = ".$consultaTipoUsuario[0]['tipo']." AND YEAR(GETDATE()) = YEAR(fechaInicio) /*AND DAY(GETDATE()) = DAY(fechaInicio)*/ AND mes = $mesActual")->result_array();
            
                $obtenerFechaSql = $this->db->query("select FORMAT(CAST(FORMAT(SYSDATETIME(), N'yyyy-MM-dd HH:mm:ss') AS datetime2), N'yyyy-MM-dd HH:mm:ss') as sysdatetime")->row()->sysdatetime;   
                $fecha_actual = strtotime($obtenerFechaSql);
                $fechaInicio = strtotime($consultaFechasCorte[0]['fechaInicio']);
                $fechaFin = $validar_sede == 8 ? strtotime($consultaFechasCorte[0]['fechaTijuana']) : strtotime($consultaFechasCorte[0]['fechaFinGeneral']) ;
                
                if(($fecha_actual >= $fechaInicio && $fecha_actual <= $fechaFin) ) {

                  $datos = explode(",",$this->input->post('pagos'));
                  $resultado = array("resultado" => TRUE);
                  if((isset($_POST) && !empty($_POST)) || ( isset( $_FILES ) && !empty($_FILES) ) ){
                    $this->db->trans_begin();
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
                      } else{
                        $resultado["mensaje"] = $this->upload->display_errors();
                      }
                    }
                    
                    if($resultado === FALSE || $this->db->trans_status() === FALSE){
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

            public function descargar_XML(){
                if( $this->session->userdata('id_rol') == 31 ){
                    $filtro = " ant.proceso IN (8) ";
                } else{
                    $filtro = " ant.proceso  IN (7) ";
                }

                $facturas_disponibles = array();
                $facturas_disponibles = $this->db->query("SELECT DISTINCT(fa.nombre_archivo) 
                from facturas_anticipos fa
                INNER JOIN anticipo ant ON fa.id_anticipo = ant.id_anticipo
                WHERE $filtro
                GROUP BY fa.nombre_archivo
                ORDER BY fa.nombre_archivo");

                if( $facturas_disponibles->num_rows() > 0 ){
                    $this->load->library('zip');
                    $nombre_documento = 'FACTURAS_INTERNOMEX_'.date("YmdHis").'.zip';
                foreach( $facturas_disponibles->result() as $row ){
                    $this->zip->read_file( './UPLOADS/XML_Anticipo/'.$row->nombre_archivo );
                }

                    $this->zip->archive( $nombre_documento );
                    $this->zip->download( $nombre_documento );
                }else{
                    echo 'no entra';
                }
            }



        public function pausar_prestamo(){
            $estatus = $this->input->post('estatusP') ;    

            if ($estatus == 6){
                $estatus= 1;
                }else{
                    $estatus= 6;
                }

            $updateArray = array(
                'estatus'       => $estatus    
                );
            $respuesta = $this->Descuentos_model->pausar_prestamo($updateArray , $this->input->post('prestamoIdPausar'));
                
            if($respuesta )
            {
                $respuesta =  array(
                    "response_code" => 200, 
                    "response_type" => 'success',
                    "message" => "Se pauso correctamente el préstamo");
            }else{
                $respuesta =  array(
                    "response_code" => 401, 
                    "response_type" => 'error',
                    "message" => "El préstamo no se ha podido detener, inténtalo más tarde");
            }

                // nace un anticipo
             echo json_encode($respuesta);
        }



        public function descuentos_masivos()
        {
            $array_prestamos_aut = array();
                if (!isset($_POST))
                {    
                // echo json_encode(array("status" => 400, "message" => "Algún parámetro no viene informado."));
                }
                else {
                    
                    // var_dump($this->input->post("data" ));

                    if ($this->input->post("data" ) == "")
                    {
                    // echo json_encode(array("status" => 400, "message" => "El archivo viene vacio."), JSON_UNESCAPED_UNICODE);
                    }   
                    else {

                        // $decodedData = $this->jwt_actions->decodeData('4582', $data);
                        $data = $this->input->post("data");
                        $decodedData = json_decode($data);
                        // var_dump($decodedData);

                        
                        if (count($decodedData) > 0) { // SE VALIDA QUE EL ARRAY AL MENOS TENGA DATOS
                            
                            // echo('general ya entro al primero ');
                            // $id_usuario = array();
                            for ($i = 0; $i < count($decodedData); $i++) { 
                                // var_dump($decodedData[$i]->id_usuario);
                                // var_dump($decodedData[$i]->monto);
                                // var_dump($decodedData[$i]->num_pagos);
                                // var_dump($decodedData[$i]->pago_individual);
                                // var_dump($decodedData[$i]->comentarios);
                                // var_dump($decodedData[$i]->tipo);

                                if(
                                isset($decodedData[$i]->id_usuario) && 
                                !empty($decodedData[$i]->id_usuario) && 
                                isset($decodedData[$i]->monto) && 
                                !empty($decodedData[$i]->monto) && 
                                isset($decodedData[$i]->num_pagos) && 
                                !empty($decodedData[$i]->num_pagos) &&
                                isset($decodedData[$i]->pago_individual) && 
                                !empty($decodedData[$i]->pago_individual) && 
                                isset($decodedData[$i]->comentarios) && 
                                !empty($decodedData[$i]->comentarios) && 
                                isset($decodedData[$i]->tipo) &&
                                !empty($decodedData[$i]->tipo)
                                )
                                {// inicio de llave if
                                    
                                    //aqui validamos la información 
                                    // array_push($array_prestamos_aut,);
                                    // array_push($stack, "apple", "raspberry");
                                    
                                    
                                    $insertArray = array(
                                        'id_usuario'            =>  $decodedData[$i]->id_usuario,
                                        'monto'                 =>  $decodedData[$i]->monto,
                                        'num_pagos'             =>  $decodedData[$i]->num_pagos,
                                        'pago_individual'       =>  $decodedData[$i]->pago_individual,
                                        'comentario'            =>  $decodedData[$i]->comentarios,
                                        'estatus'               =>  1,
                                        'pendiente'             =>  $decodedData[$i]->monto,
                                        'creado_por'            =>  $this->session->userdata('id_usuario'),
                                        'fecha_creacion'        =>  date("Y-m-d H:i:s"),
                                        'modificado_por'        =>  0,
                                        'fecha_modificacion'    =>  date("Y-m-d H:i:s"),
                                        'n_p'                   =>  0,
                                        'tipo'                  =>  $decodedData[$i]->tipo,
                                        'id_cliente'            =>  null,
                                        'evidenciaDocs'         =>  null,
                                    );

                                    $array_prestamos_aut[$i] = $insertArray;

                            


                                    // ae ae ae ae eae  ae ea ae
                                
                                }// fin  llave del if
                                else{
                                    // echo json_encode(array("status" => 400, "message" => "Algún parámetro no viene informado."));
                                }

                            }
                            // var_dump('vemos cuantos entran');
                            
                            // var_dump($array_prestamos_aut);
                            // var_dump(count($array_prestamos_aut));
                            
                            $array_respuesta_positivas = array();
                            $array_respuesta_negativas = array();
                            $contadorPositivo = 0;
                            $contadorNegativo = 0;
                            
                            // or ($i = 0; $i < count($decodedData); $i++) {
                            // var_dump($array_prestamos_aut[1]);
                            for($contador = 0; $contador < count($array_prestamos_aut) ; $contador++){
                            $this->db->trans_begin();
                            // echo('<br>');
                            // echo('<br>');
                            // echo('<br>');
                            // echo('<br>');
                            //     var_dump(75757575757575757575757);
                            //     var_dump($array_prestamos_aut[$contador]);
                                $respuesta =  $this->Descuentos_model->insertar_prestamos($array_prestamos_aut[$contador] );
                                
                                // var_dump();
                                
                                if($respuesta){

                                    $array_respuesta_positivas[$contadorPositivo] = $array_prestamos_aut[$contador]['id_usuario'];
                                    
                                    $contadorPositivo ++;
                                    $this->db->trans_commit();  
                                }else{
                                    $array_respuesta_negativas[$contadorNegativo] = $array_prestamos_aut[$contador]['id_usuario'];
                                    // $respuesta =  array(
                                    //     "response_code" => 811, 
                                    //     "response_type" => 'error',
                                    //     "message" => "El préstamo no se ha podido insertar, inténtalo más tarde");
                                    $contadorNegativo++;
                                    $this->db->trans_rollback();    
                                }
                            }

                            $respuesta =  array(
                                "response_code" => 200, 
                                "response_type" => 'success',
                                "message"       => "El proceso se ha realizado correctamente."
                                );
                                $respuesta['correctas'] =  $array_respuesta_positivas;           
                                $respuesta['incorrectas'] = $array_respuesta_negativas; 

                            echo json_encode($respuesta);

                        }else{
                            echo json_encode(array("status" => 400, "message" => "Algún parámetro no viene informado."));
                        }
                    }
                    
                }
        }

        public function todos_los_tipos(){

            $todos_los_pasos = $this->Descuentos_model->todos_los_tipos();

            echo json_encode($todos_los_pasos);
        
        }


}