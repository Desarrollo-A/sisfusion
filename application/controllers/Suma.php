<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Suma extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Suma_model', 'General_model', 'Comisiones_model', 'PagoInvoice_model', 'Usuarios_modelo'));
        $this->load->library(array('session', 'form_validation', 'Jwt_actions', 'get_menu','permisos_sidebar'));
        $this->load->helper(array('url', 'form'));
        $this->load->database('default');
        // $this->jwt_actions->authorize_externals('3450', apache_request_headers()["Authorization"]);

        $val =  $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        $_SESSION['rutaController'] = str_replace('' . base_url() . '', '', $val);
        $rutaUrl = explode($_SESSION['rutaActual'], $_SERVER["REQUEST_URI"]);
        $this->permisos_sidebar->validarPermiso($this->session->userdata('datos'),$rutaUrl[1],$this->session->userdata('opcionesMenu'));
    }
    public function index() {}
    public function validateUserAccess() {
        $data = json_decode(file_get_contents("php://input"));
        if (!isset($data->id_asesor) || !isset($data->contrasena))
            echo json_encode(array("status" => 401, "message" => "Algún parámetro no viene informado. Verifique que todos los parámetros requeridos se incluyan en la petición."), JSON_UNESCAPED_UNICODE);
        else {
            if ($data->id_asesor == '' || $data->contrasena == '')
                echo json_encode(array("status" => 401, "message" => "Algún parámetro no tiene un valor especificado. Verifique que todos los parámetros contengan un valor especificado."), JSON_UNESCAPED_UNICODE);
            else {
                $result = $this->Suma_model->getUserInformation($data->id_asesor, encriptar($data->contrasena));
                if (!isset($result->rol_asesor))
                    echo json_encode(array("status" => 401, "message" => "No se logró autenticar el usuario."), JSON_UNESCAPED_UNICODE);
                else {
                    if ($result->rol_asesor != 7)
                        echo json_encode(array("status" => 401, "message" => "Los datos ingresados no corresponde a un ID de usuario con rol de asesor."), JSON_UNESCAPED_UNICODE);
                    else {
                        if ($result->estatus != 1)
                            echo json_encode(array("status" => 401, "message" => "El usuario ingresado no se encuentra activo."), JSON_UNESCAPED_UNICODE);
                        else {
                            echo json_encode(array("status" => 200, "message" => "Autenticado exitosamente.", 
                            "id_asesor" => $result->id_asesor, "nombre_asesor" => $result->nombre_asesor,
                            "id_coordinador" => $result->id_coordinador, "nombre_coordinador" => $result->nombre_coordinador,
                            "id_gerente" => $result->id_gerente, "nombre_gerente" => $result->nombre_gerente,
                            "id_subdirector" => $result->id_subdirector, "nombre_subdirector" => $result->nombre_subdirector,
                            "id_regional" => $result->id_regional, "nombre_regional" => $result->nombre_regional), JSON_UNESCAPED_UNICODE);
                        }
                    }
                }
            }
        }
    }
    public function validateWeek(){
        $date = new DateTime();
        $week = $date->format("W");
        $user = $this->session->userdata('id_usuario');
        $data = $this->Suma_model->validateWeek($week, $user)->result_array();
        
        echo json_encode($data);
    }
    public function comisiones_suma(){
        $datos["opn_cumplimiento"] = $this->Usuarios_modelo->Opn_cumplimiento($this->session->userdata('id_usuario'))->result_array();
        $this->load->view('template/header');
        $this->load->view("ventas/comisiones_suma", $datos);
    }
    public function getComisionesByStatus(){
        $user = $this->session->userdata('id_usuario');
        $data = $this->Suma_model->getComisionesByStatus($_POST['estatus'], $user);
        echo json_encode($data);
    }
    public function getAllComisionesByUser(){
        $user = $this->session->userdata('id_usuario');
        $year = $_POST['anio'];
        $data = $this->Suma_model->getAllComisionesByUser($user, $year);
        echo json_encode($data);
    }
    public function getAllComisiones(){
        $year = $_POST['anio'];
        $data = $this->Suma_model->getAllComisiones($year);
        echo json_encode($data);
    }
    public function sumServ(){
        $data_json = json_decode((file_get_contents("php://input")));
        $request = array();
        $primerFiltro = false;
        $stringReferencias = '';
        foreach ($data_json as &$data) {
            if (!isset($data->id_cliente) || !isset($data->total_venta) || !isset($data->comisionistas) || !isset($data->nombre_cliente) || !isset($data->id_pago) || !isset($data->referencia)){
                $detalle[] = (object) ['idPagoSuma' => $idPago, 'idComisionCRM' => 0, 'status' => 404, 'referencia' => $referencia ];
            }
            else {
                //Evaluar SI SOLO contiene espacios en blanco
                $idCliente = trim($data->id_cliente);
                $totalVenta = trim($data->total_venta);
                $nombreCliente = trim($data->nombre_cliente);
                $idPago = trim($data->id_pago);
                $referencia = trim($data->referencia);
                $comisionistas = $data->comisionistas;
                
                if ($idCliente == "" || $totalVenta == "" || $nombreCliente == "" || $idPago == ""|| $referencia == ""){
                    $detalle[] = (object) ['idPagoSuma' => $idPago, 'idComisionCRM' => 0, 'status' => 405, 'referencia' => $referencia ];
                }
                else {
                    if( count($comisionistas) == 0 ){
                        $detalle[] = (object) ['idPagoSuma' => $idPago, 'idComisionCRM' => 0, 'status' => 406, 'referencia' => $referencia ];
                    }
                    else{
                        $arrayComisiones[] = array(
                            'total_venta' => $totalVenta,
                            'id_cliente' => $idCliente,
                            'nombre_cliente' => $nombreCliente,
                            'id_pago' => $idPago,
                            'referencia' => $referencia
                        );
                        
                        foreach ($comisionistas as $comisionista) {
                            if ( !isset($comisionista->id_rol) || !isset($comisionista->id_usuario) || !isset($comisionista->porcentaje_comision) || !isset($comisionista->total_comision) ){
                                $detalle[] = (object) ['idPagoSuma' => $idPago, 'idComisionCRM' => 0, 'status' => 407, 'referencia' => $referencia ];
                            }
                            else{
                                $idRol = trim($comisionista->id_rol);
                                $idUsuario = trim($comisionista->id_usuario);
                                $porcentaje = trim($comisionista->porcentaje_comision);
                                $totalComision = trim( $comisionista->total_comision);
                                
                                if ($idRol == "" || $idUsuario == "" || $porcentaje == "" || $totalComision == "" ){
                                    $detalle[] = (object) ['idPagoSuma' => $idPago, 'idComisionCRM' => 0, 'status' => 408, 'referencia' => $referencia ];
                                }
                                else{
                                    $primerFiltro = true;
                                    $arrayPagos[] = array(
                                        'id_rol' => $idRol,
                                        'id_usuario' => $idUsuario,
                                        'porcentaje_comision' => $porcentaje,
                                        'total_comision' => $totalComision,
                                        'referencia' => $referencia
                                    );
                                }
                            }
                        }
                        if($primerFiltro){
                            $stringReferencias .= "'" . $referencia . "', ";
                        }
                    }
                }
            }
        }
        //Obtenemos todas las referencias de las comisiones mandadas en el array
        if ($stringReferencias != '' ){
            $stringReferencias = substr($stringReferencias, 0, -2);
            $dataDuplicados = $this->Suma_model->duplicateReference($stringReferencias)->result_array();
            foreach ($dataDuplicados as $objDuplicado ){
                $refDup = $objDuplicado['referencia'];
                $filteredArrayComisiones = 
                    array_filter($arrayComisiones, function($element) use($refDup){
                    return $element['referencia'] == $refDup;
                });
                $filteredArrayPagos =
                    array_filter($arrayPagos, function($element) use($refDup){
                    return $element['referencia'] == $refDup;
                });
                foreach ($filteredArrayComisiones as $key => $posicion) {
                    $detalle[] = (object) ['idPagoSuma' => $posicion['id_pago'], 'idComisionCRM' => 0, 'status' => 409, 'referencia' => $refDup ];
                    unset($arrayComisiones[$key]);
                }
                foreach ($filteredArrayPagos as $key => $posicion) {
                    unset($arrayPagos[$key]);
                }
            }
            $arrayComisiones = array_values($arrayComisiones); 
            $arrayPagos = array_values($arrayPagos); 
        }
        if(count($arrayComisiones) > 0) {
            list($result, $ids) = $this->Suma_model->setComisionesPagos($arrayComisiones, $arrayPagos);
            if($result){
                foreach($arrayComisiones as $objComision){
                    $detalle[] = (object) ['idPagoSuma' => $objComision['id_pago'], 'idComisionCRM' => $ids, 'status' => 402, 'referencia' => $objComision['referencia']];
                    $ids += 1;
                }
                echo(json_encode(array("status" => 402, "mensaje" => "Todo exitoso.", "detalle" => $detalle), JSON_UNESCAPED_UNICODE));
            }
            else {
                foreach($arrayComisiones as $objComision){
                    $detalle[] = (object) ['idPagoSuma' => $objComision['id_pago'], 'idComisionCRM' => 0, 'status' => 403, 'referencia' => $objComision['referencia']];
                }
                echo(json_encode(array("status" => 403, "mensaje" => "Hubo algún error.", "detalle" => $detalle), JSON_UNESCAPED_UNICODE));
            }
        }
        else
            echo(json_encode(array("status" => 403, "mensaje" => "Hubo algún error.", "detalle" => $detalle), JSON_UNESCAPED_UNICODE));
    }
    public function getHistorial($pago){
        echo json_encode($this->Suma_model->getHistorial($pago)->result_array());
    }
    public function acepto_comisiones_user(){
        $id_user_Vl = $this->session->userdata('id_usuario');
        $formaPagoUsuario = $this->session->userdata('forma_pago');
        $sol=$this->input->post('idcomision');  
        $consulta_comisiones = $this->db->query("SELECT id_pago_suma FROM pagos_suma where id_pago_suma IN (".$sol.")");
        $opinionCumplimiento = $this->Comisiones_model->findOpinionActiveByIdUsuario($id_user_Vl);
        if( ($opinionCumplimiento != NULL && $formaPagoUsuario == 5) || $formaPagoUsuario != 5){
            if( $consulta_comisiones->num_rows() > 0 ){
                $consulta_comisiones = $consulta_comisiones->result_array();
                $sep = ',';
                $id_pago_i = '';
                $data=array();
                $pagoInvoice = array();
                foreach ($consulta_comisiones as $row) {
                    $id_pago_i .= implode($sep, $row);
                    $id_pago_i .= $sep;
                    $row_arr=array(
                        'id_pago' => $row['id_pago_suma'],
                        'id_usuario' =>  $id_user_Vl,
                        'fecha_movimiento' => date('Y-m-d H:i:s'),
                        'estatus' => 2,
                        'comentario' =>  'COLABORADOR ENVÍO A DTO. SUMA' 
                    );
                    array_push($data,$row_arr);
                    if ($formaPagoUsuario == 5) { // Pago extranjero
                        $pagoInvoice[] = array(
                            'id_pago_suma' => $row['id_pago_suma'],
                            'nombre_archivo' => $opinionCumplimiento->archivo_name,
                            'estatus' => 1,
                            'modificado_por' => $id_user_Vl,
                            'fecha_registro' => date('Y-m-d H:i:s')
                        );
                    }
                }
                $id_pago_i = rtrim($id_pago_i, $sep);
                $up_b = $this->Suma_model->update_acepta_solicitante($id_pago_i);
                $ins_b = $this->Suma_model->insert_historial($data);
                if ($formaPagoUsuario == 5) {
                    $this->PagoInvoice_model->insertManySuma($pagoInvoice);
                }
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
        else{
            $data_response = 2;
            echo json_encode($data_response);
        }
    }
    public function guardar_solicitud($usuario = ''){
        $validar_user = $this->session->userdata('id_usuario');
        $validar_sede =   $usuarioid =$this->session->userdata('id_sede');
        $date = new DateTime();
        $week = $date->format("W");
        date_default_timezone_set('America/Mexico_City');       
        $numDia =  date('N', time());
        $hora = date('H');
        if( $numDia == '1' || ( $numDia == '2' && $hora <= '14' ) ){
            if($usuario != ''){
                $usuarioid = $usuario;
            }
            else{
                $usuarioid =$this->session->userdata('id_usuario');
            }
            $datos = explode(",",$this->input->post('pagos'));
            $resultado = array("resultado" => TRUE);
            if( (isset($_POST) && !empty($_POST)) || ( isset( $_FILES ) && !empty($_FILES) ) ){
                $this->db->trans_begin();
                $responsable = $this->session->userdata('id_usuario');
                $resultado = TRUE;
                if( isset( $_FILES ) && !empty($_FILES) ){
                    $config['upload_path'] = './UPLOADS/XMLS_SUMA/';
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
                            rename( $xml_subido['full_path'], "./UPLOADS/XMLS_SUMA/".$nuevo_nombre );
                            $datos_xml['nombre_xml'] = $nuevo_nombre;
                            ini_set('max_execution_time', 0);
                            for ($i=0; $i <count($datos) ; $i++) { 
                                if(!empty($datos[$i])){
                                    $id_com =  $datos[$i];
                                    $this->Suma_model->insertar_factura($id_com, $datos_xml,$usuarioid, $week);
                                    $this->Suma_model->update_acepta_solicitante($id_com);
                                    $this->db->query("INSERT INTO historial_suma VALUES (".$id_com.", ".$this->session->userdata('id_usuario').", GETDATE(), 1, 'COLABORADOR ENVÍO FACTURA A DTO. SUMA')");
                                }
                            }
                        } 
                        else {
                            $this->db->trans_rollback();
                            echo json_encode(4);
                            return;
                        }
                    }
                    else {
                        $resultado["mensaje"] = $this->upload->display_errors();
                    }
                }
                if ( $resultado === FALSE || $this->db->trans_status() === FALSE){
                    $this->db->trans_rollback();
                    $resultado = array("resultado" => FALSE);
                }
                else{
                    $this->db->trans_commit();
                    $resultado = array("resultado" => TRUE);
                }
            }
            $this->Usuarios_modelo->Update_OPN($this->session->userdata('id_usuario'));
            echo json_encode( $resultado );
        }
        else{
            echo json_encode(3);
        }
    }
    public function revision_asimilados(){
        $this->load->view('template/header');
        $this->load->view("ventas/revision_asimilados_suma");
    }
    public function revision_remanentes(){
        $this->load->view('template/header');
        $this->load->view("ventas/revision_remanentes_suma");
    }
    public function revision_facturas(){
        $this->load->view('template/header');
        $this->load->view("ventas/revision_factura_suma");
    }
    public function revision_extranjero(){
        $this->load->view('template/header');
        $this->load->view("ventas/revision_extranjero_suma");
    }
    public function revision_xml(){
        $this->load->view('template/header');
        $this->load->view("ventas/revision_xml_suma");
    }
    public function revision_asimilados_intmex(){
        $this->load->view('template/header');
        $this->load->view("ventas/revision_INTMEXasimilados_suma");
    }
    public function revision_remanentes_intmex(){
        $this->load->view('template/header');
        $this->load->view("ventas/revision_INTMEXremanente_suma");
    }
    public function revision_factura_intmex(){
        $this->load->view('template/header');
        $this->load->view("ventas/revision_INTMEXfactura_suma");
    }
    public function revision_extranjeros_intmex(){
        $this->load->view('template/header');
        $this->load->view("ventas/revision_INTMEXextranjero_suma");
    }
    public function historial_comisiones(){
        $this->load->view('template/header');
        $this->load->view("ventas/historial_comisiones_suma");
    }
    public function getRevisionIntMex(){
        $idRol = $this->input->post("idRol");
        $idUsuario = $this->input->post("idUsuario");
        $formaPago = $this->input->post("formaPago");
        echo json_encode($this->Suma_model->getRevisionIntMex($idRol, $idUsuario, $formaPago)->result_array());
    }
    public function getRevision(){
        $formaPago = $this->input->post("formaPago");
        echo json_encode($this->Suma_model->getRevision($formaPago)->result_array());
    }
    public function getFacturaRevision(){
        echo json_encode($this->Suma_model->getFacturaRevision()->result_array());
    }
    public function getFacturaExtranjeroRevision(){
        echo json_encode($this->Suma_model->getFacturaExtranjeroRevision()->result_array());
    }
    public function setPausarDespausarComision(){
        $idUsuario = $this->session->userdata('id_usuario');
        $idRol= $this->session->userdata('id_rol');
        $idPago = $this->input->post("id_pago");
        $estatus = $this->input->post("estatus");
        $obs = $this->input->post("observaciones");
        if( $estatus == 2 && $idRol == 68 )
            $estatus = 4;
        elseif( $estatus == 3 && $idRol == 31 )
            $estatus = 5;
        elseif( $estatus == 5 )
            $estatus = 3;
        else
            $estatus = 2;
        $respuesta = $this->Suma_model->setPausarDespausarComision($estatus, $idPago, $idUsuario, $obs);
        echo json_encode( $respuesta );
    }
    public function aceptoInternomexAsimilados(){
        $idUsuario = $this->session->userdata('id_usuario');
        $idsComisiones = explode(",",$this->input->post('idcomision'));
        for ($i = 0; $i < count($idsComisiones); $i++) {
            $updateArrayData[] = array(
                'id_pago_suma' => $idsComisiones[$i],
                'estatus' => 3
            );
            $insertArrayData[]=array(
                'id_pago' => $idsComisiones[$i],
                'id_usuario' =>  $idUsuario,
                'fecha_movimiento' => date('Y-m-d H:i:s'),
                'estatus' => 3,
                'comentario' =>  'SUMA ENVÍO A INTERNOMEX' 
            );
        }
        $reponse = $this->Suma_model->setAsimiladosInternomex($updateArrayData, $insertArrayData);
        echo json_encode( $reponse );
    }
    public function pago_internomex(){
        $idUsuario = $this->session->userdata('id_usuario');
        $idsComisiones = explode(",",$this->input->post('idcomision'));
        for ($i = 0; $i < count($idsComisiones); $i++) {
            $updateArrayData[] = array(
                'id_pago_suma' => $idsComisiones[$i],
                'estatus' => 6
            );
            $insertArrayData[]=array(
                'id_pago' => $idsComisiones[$i],
                'id_usuario' =>  $idUsuario,
                'fecha_movimiento' => date('Y-m-d H:i:s'),
                'estatus' => 6,
                'comentario' =>  'INTERNOMEX APLICÓ PAGO' 
            );
        }
        $reponse = $this->Suma_model->setPagosInternomex($updateArrayData, $insertArrayData);
        echo json_encode( $reponse );
    }
    public function getDatosNuevasXSuma(){
    $datos =  $this->Suma_model->getDatosNuevasXSuma()->result_array();
    echo json_encode( array( "data" => $datos));
    }
    public function lista_roles(){
    echo json_encode($this->Suma_model->get_lista_roles()->result_array());
    }
    public function lista_usuarios($rol,$forma_pago){
    echo json_encode($this->Suma_model->get_lista_usuarios($rol, $forma_pago)->result_array());
    }
    public function carga_listado_factura(){
        echo json_encode( $this->Suma_model->get_solicitudes_factura($this->input->post("id_usuario") ) );
    }
    public function getDatosFactura($uuid, $id_res){
        if($uuid){
            $consulta_sol = $this->Suma_model->factura_comision($uuid, $id_res)->row();
            if (!empty($consulta_sol)) {
                $datos['datos_solicitud'] = $this->Suma_model->factura_comision($uuid, $id_res)->row(); 
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
    public function GetDescripcionXML($xml){
        error_reporting(0);
    
        $xml=simplexml_load_file("".base_url()."UPLOADS/XMLS_SUMA/".$xml."") or die("Error: Cannot create object");
    
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
    public function updateClientName(){
        $data = json_decode((file_get_contents("php://input")));
        if (!isset($data->id_cliente))
            echo json_encode(array("status" => 400, "message" => "Algún parámetro no tiene un valor especificado o no viene informado."), JSON_UNESCAPED_UNICODE);
        else {
            if ($data->nombre_cliente=="")
                echo json_encode(array("status" => 400, "message" => "Algún parámetro no tiene un valor especificado o no viene informado..."), JSON_UNESCAPED_UNICODE);
            else {
                $updateData = array(
                    "id_cliente" => $data->id_cliente,
                    "nombre_cliente" => $data->nombre_cliente
                );
                $result = $this->General_model->updateRecord("comisiones_suma", $updateData, "id_cliente", $data->id_cliente);
                if ($result == true)
                    echo json_encode(array("status" => 200, "message" => "El registro se ha actualizado de manera exitosa."), JSON_UNESCAPED_UNICODE);
                else
                    echo json_encode(array("status" => 400, "message" => "Oops, algo salió mal. Inténtalo más tarde."), JSON_UNESCAPED_UNICODE);
            }
        }
    }
    public function getTotalComisionAsesor(){
        $idUsuario = $this->session->userdata('id_usuario');
        $data = $this->Suma_model->getTotalComisionAsesor($idUsuario);
        echo json_encode($data);
    }
    public function getAsesoresDisponibles(){
        $datos["asesor"] = $this->Suma_model->allAsesor();
        if ($datos != null) {
            echo json_encode($datos);
        } else {
            echo json_encode(array());
        }
    }
    public function cargaxml2($id_user = ''){
        $user =   $usuarioid =$this->session->userdata('id_usuario');
        $this->load->model('Usuarios_modelo');
        if(empty($id_user)){
        $RFC = $this->Usuarios_modelo->getPersonalInformation()->result_array();
        }
        else{
        $RFC = $this->Usuarios_modelo->getPersonalInformation2($id_user)->result_array();
        }
        $respuesta = array( "respuesta" => array( FALSE, "HA OCURRIDO UN ERROR") );
        if( isset( $_FILES ) && !empty($_FILES) ){
            $config['upload_path'] = './UPLOADS/XMLS_SUMA/';
            $config['allowed_types'] = 'xml';
            //CARGAMOS LA LIBRERIA CON LAS CONFIGURACIONES PREVIAS -----$this->upload->display_errors()
            $this->load->library('upload', $config);
            if( $this->upload->do_upload("xmlfile") ){
                $xml_subido = $this->upload->data()['full_path'];
                $datos_xml = $this->Comisiones_model->leerxml( $xml_subido, TRUE );
                if( $datos_xml['version'] >= 3.3){
                    $responsable_factura = $this->Suma_model->verificar_uuid( $datos_xml['uuidV'] );
                    if($responsable_factura->num_rows()>=1){
                        $respuesta['respuesta'] = array( FALSE, "ESTA FACTURA YA SE SUBIÓ ANTERIORMENTE AL SISTEMA");
                    }
                    else{
                        if($datos_xml['rfcreceptor'][0]=='ICE211215685'){//VALIDAR UNIDAD
                            if($datos_xml['claveProdServ'][0]=='80131600' || ($user == 6578 && $datos_xml['claveProdServ'][0]=='83121703')){//VALIDAR UNIDAD
                                $diasxmes = date('t');
                                $fecha1 = date('Y-m-').'0'.(($diasxmes - $diasxmes) +1);
                                $fecha2 = date('Y-m-').$diasxmes;
                                if($datos_xml['fecha'][0] >= $fecha1 && $datos_xml['fecha'][0] <= $fecha2){
                                    if($datos_xml['rfcemisor'][0] == $RFC[0]['rfc']){
                                        if($datos_xml['regimenFiscal'][0]=='612' || ($user == 6578 && $datos_xml['regimenFiscal'][0]=='601')){//VALIDAR REGIMEN FISCAL
                                            if($datos_xml['formaPago'][0]=='03' || $datos_xml['formaPago'][0]=='003'){//VALIDAR FORMA DE PAGO Transferencia electrónica de fondos
                                                if($datos_xml['usocfdi'][0]=='G03'){//VALIDAR USO DEL CFDI
                                                    if($datos_xml['metodoPago'][0]=='PUE'){//VALIDAR METODO DE PAGO
                                                        if($datos_xml['claveUnidad'][0]=='E48'){//VALIDAR UNIDAD
                                                            $respuesta['respuesta'] = array( TRUE );
                                                            $respuesta['datos_xml'] = $datos_xml;
                                                        }
                                                        else{
                                                            $respuesta['respuesta'] = array( FALSE, "LA UNIDAD NO ES 'E48 (UNIDAD DE SERVICIO)', VERIFIQUE SU FACTURA.");
                                                        }//FINAL DE UNIDAD
                                                    }
                                                    else{
                                                        $respuesta['respuesta'] = array( FALSE, "EL METODO DE PAGO NO ES 'PAGO EN UNA SOLA EXHIBICIÓN (PUE)', VERIFIQUE SU FACTURA.");
                                                    }//FINAL DE METODO DE PAGO
                                                }
                                                else{
                                                    $respuesta['respuesta'] = array( FALSE, "EL USO DEL CFDI NO ES 'GASTOS EN GENERAL (G03)', VERIFIQUE SU FACTURA.");
                                                }//FINAL DE USO DEL CFDI
                                            }
                                            else{
                                                $respuesta['respuesta'] = array( FALSE, "LA FORMA DE PAGO NO ES 'TRANSFERENCIA ELECTRÓNICA DE FONDOS (03)', VERIFIQUE SU FACTURA.");
                                            }//FINAL DE FORMA DE PAGO
                                        }
                                        else{
                                            $respuesta['respuesta'] = array( FALSE, "EL REGIMEN NO ES, 'PERSONAS FÍSICAS CON ACTIVIDADES EMPRESARIALES (612)");
                                        }//FINAL DE REGIMEN FISCAL
                                    }
                                    else{
                                    $respuesta['respuesta'] = array( FALSE, "ESTA FACTURA NO CORRESPONDE A TU RFC.");
                                    }//FINAL DE RFC VALIDO
                                }
                                else{
                                $respuesta['respuesta'] = array( FALSE, "FECHA INVALIDA, SOLO SE ACEPTAN FACTURAS CON FECHA DE ESTE MES, VERIFICA TU XML");
                                }          
                            }
                            else{
                                $respuesta['respuesta'] = array( FALSE, "LA CLAVE DE TU FACTURA NO CORRESPONDE A 'VENTA DE PROPIEDADES Y EDIFICIOS' (80131600).");
                            }
                        }
                        else{
                            $respuesta['respuesta'] = array( FALSE, "EL RFC NO CORRESPONDE A INTERNOMEX, DEBE SER ICE211215685");
                        }
                    }
                }
                else{
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
    public function SubirPDFExtranjero($id = '')
    {
        $id_usuario = $this->session->userdata('id_usuario');
        $nombre = $this->session->userdata('nombre');
        $opc = 0;
        if ($id != '') {
            $opc = 1;
            $id_usuario = $this->input->post("id_usuario");
            $nombre = $this->input->post("nombre");
        }
        date_default_timezone_set('America/Mexico_City');
        $hoy = date("Y-m-d");
        $fileTmpPath = $_FILES['file-upload-extranjero']['tmp_name'];
        $fileName = $_FILES['file-upload-extranjero']['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        $newFileName = $nombre . $hoy . md5(time() . $fileName) . '.' . $fileExtension;
        $uploadFileDir = './static/documentos/extranjero_suma/';
        $dest_path = $uploadFileDir . $newFileName;
        move_uploaded_file($fileTmpPath, $dest_path);
        $response = $this->Usuarios_modelo->SaveCumplimiento($id_usuario, $newFileName, $opc, 'SUMA');
        echo json_encode($response);
    }
}