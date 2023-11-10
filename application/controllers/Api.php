<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once './dist/js/jwt/JWT.php';

use Firebase\JWT\JWT;

class Api extends CI_Controller
{

    public function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type,Origin, authorization, X-API-KEY');
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->helper(array('form'));
        $this->load->library(array('jwt_key', 'get_menu', 'jwt_actions'));
        $this->load->model(array('Api_model', 'General_model', 'Internomex_model', 'Clientes_model', 'Usuarios_modelo', 'Ooam_model'));
        $this->load->model([
            'opcs_catalogo/valores/AutorizacionClienteOpcs',
            'opcs_catalogo/valores/TipoAutorizacionClienteOpcs'
        ]);
    }

    function getToken() {
        $data = json_decode(file_get_contents("php://input"));
        if (!isset($data->id))
            echo json_encode(array("status" => -1, "message" => "Algún parámetro no viene informado."), JSON_UNESCAPED_UNICODE);
        else {
            if ($data->id == "")
                echo json_encode(array("status" => -1, "message" => "Algún parámetro no tiene un valor especificado."), JSON_UNESCAPED_UNICODE);
            else {
                if (!in_array($data->id, array(9860, 8134, 5918, 6489, 9347)))
                    echo json_encode(array("status" => -1, "message" => "Sistema no reconocido."), JSON_UNESCAPED_UNICODE);
                else {
                    if ($data->id == 9860) // DRAGON
                        $arrayData = array("username" => "ojqd58DY3@", "password" => "I2503^831NQqHWxr");
                    else if ($data->id == 8134) // INTERNOMEX
                        $arrayData = array("username" => "1NT43506MX", "password" => "BWII239.9DEJDINT3N@");
                    else if ($data->id == 5918) // ARCUS
                        $arrayData = array("username" => "9m1%6n7DfR", "password" => "7%5bea3K&B^fMhfOw8Rj");
                    else if ($data->id == 9347) // OOAM COMISIONES
                        $arrayData = array("username" => "004M_COM502", "password" => "2235&832SDVW");
                    else if ($data->id == 6489) // CAJA
                        $arrayData = array("username" => "caja");
                    $time = time();
                    $JwtSecretKey = $this->jwt_actions->getSecretKey($data->id);
                    $data = array(
                        "iat" => $time, // Tiempo en que inició el token
                        "exp" => $time + (24 * 60 * 60), // Tiempo en el que expirará el token (24 horas)
                        "data" => $arrayData,
                    );
                    $token = JWT::encode($data, $JwtSecretKey);
                    echo json_encode(array("id_token" => $token));
                }
            }
        }
    }

    function addLeadRecord() {
        if (!isset(apache_request_headers()["Authorization"]))
            echo json_encode(array("status" => 400, "message" => "La petición no cuenta con el encabezado Authorization."), JSON_UNESCAPED_UNICODE);
        else {
            if (apache_request_headers()["Authorization"] == "")
                echo json_encode(array("status" => 400, "message" => "Token no especificado dentro del encabezado Authorization."), JSON_UNESCAPED_UNICODE);
            else {
                $token = apache_request_headers()["Authorization"];
                $JwtSecretKey = $this->jwt_actions->getSecretKey(9860);
                $valida_token = json_decode($this->validateToken($token, 9860));
                if ($valida_token->status !== 200)
                    echo json_encode($valida_token);
                else {
                    $result = JWT::decode($token, $JwtSecretKey, array('HS256'));
                    $valida_token = Null;
                    foreach ($result->data as $key => $value) {
                        if(($key == "username" || $key == "password") && (is_null($value) || str_replace(" ","",$value) == '' || empty($value)))
                            $valida_token = false;
                    }
                    if(is_null($valida_token))
                        $valida_token = true;
                    if(!empty($result->data) && $valida_token)
                        $checkSingup = $this->jwt_actions->validateUserPass($result->data->username, $result->data->password);
                    else {
                        $checkSingup = null;
                        echo json_encode(array("status" => 400, "message" => "Algún parámetro (usuario y/o contraseña) no vienen informados. Verifique que ambos parámetros sean incluidos."), JSON_UNESCAPED_UNICODE);
                    }
                    if(!empty($checkSingup) && json_decode($checkSingup)->status == 200){
                        $data = json_decode(file_get_contents("php://input"));
                        if(!isset($data->APELLIDOPATERNO))
                            $data->APELLIDOPATERNO = '';
                        if (!isset($data->APELLIDOMATERNO))
                            $data->APELLIDOMATERNO = ''; 
                        if (!isset($data->NOMBRE) || !isset($data->Mail) || !isset($data->Phone) || !isset($data->Comments) || !isset($data->iScore) || !isset($data->ProductID) || !isset($data->CampaignID) || !isset($data->Source) || !isset($data->Owner) || !isset($data->IDDRAGON))
                            echo json_encode(array("status" => 400, "message" => "Algún parámetro no viene informado. Verifique que todos los parámetros requeridos se incluyan en la petición."), JSON_UNESCAPED_UNICODE);
                        else {
                            if ($data->NOMBRE == '' || $data->Mail == '' || $data->Phone == '' || $data->Comments == '' || $data->iScore == '' || $data->ProductID == '' || $data->CampaignID == '' || $data->Source == '' || $data->Owner == '' || $data->IDDRAGON == '')
                                echo json_encode(array("status" => 400, "message" => "Algún parámetro no tiene un valor especificado. Verifique que todos los parámetros contengan un valor especificado."), JSON_UNESCAPED_UNICODE);
                            else {
                                $result = $this->Api_model->getAdviserLeaderInformation($data->Owner);
                                if ($result->id_rol != 7)
                                    echo json_encode(array("status" => 400, "message" => "El valor ingresado para OWNER no corresponde a un ID de usuario con rol de asesor."), JSON_UNESCAPED_UNICODE);
                                else {
                                    $data = array(
                                        "id_sede" => $result->id_sede,
                                        "id_asesor" => $data->Owner,
                                        "id_coordinador" => $result->id_coordinador,
                                        "id_gerente" => $result->id_gerente,
                                        "id_subdirector" => $result->id_subdirector,
                                        "id_regional" => $result->id_regional,
                                        "personalidad_juridica" => 2,
                                        "nombre" => $data->NOMBRE,
                                        "apellido_paterno" => $data->APELLIDOPATERNO,
                                        "apellido_materno" => $data->APELLIDOMATERNO,
                                        "correo" => $data->Mail,
                                        "telefono" => $data->Phone,
                                        "lugar_prospeccion" => 42,
                                        "otro_lugar" => $data->CampaignID,
                                        "plaza_venta" => 0,
                                        "fecha_creacion" => date("Y-m-d H:i:s"),
                                        "creado_por" => 1,
                                        "fecha_modificacion" => date("Y-m-d H:i:s"),
                                        "modificado_por" => 1,
                                        "fecha_vencimiento" => date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . "+ 30 days")),
                                        "observaciones" => $data->Comments,
                                        "desarrollo" => $data->ProductID,
                                        "score" => $data->iScore,
                                        "source" => $data->Source,
                                        "id_dragon" => $data->IDDRAGON
                                    );
                                    $dbTransaction = $this->General_model->addRecord("prospectos", $data); // MJ: LLEVA 2 PARÁMETROS $table, $data
                                    if ($dbTransaction) // SUCCESS TRANSACTION
                                        echo json_encode(array("status" => 200, "message" => "Registro guardado con éxito.", "resultado" => $result), JSON_UNESCAPED_UNICODE);
                                    else // ERROR TRANSACTION
                                        echo json_encode(array("status" => 503, "message" => "Servicio no disponible. El servidor no está listo para manejar la solicitud. Por favor, inténtelo de nuevo más tarde."), JSON_UNESCAPED_UNICODE);
                                }
                            }
                        }
                    } else
                        echo json_encode($checkSingup);
                }
            }
        }
    }

    function getFolderFile($documentType)
    {
        if ($documentType == 7) $folder = "static/documentos/cliente/corrida/";
        else if ($documentType == 8) $folder = "static/documentos/cliente/contrato/";
        else $folder = "static/documentos/cliente/expediente/";
        return $folder;
    }

    function validateToken($token, $controller = null)
    {
        $time = time();
        if (is_null($controller))
            $JwtSecretKey = $this->jwt_key->getSecretKey();
        else
            $JwtSecretKey = $this->jwt_actions->getSecretKey($controller);
            $result = JWT::decode($token, $JwtSecretKey, array('HS256'));
        if (in_array($result, array('ALR001', 'ALR003', 'ALR004', 'ALR005', 'ALR006', 'ALR007', 'ALR008', 'ALR009', 'ALR010', 'ALR012', 'ALR013'))) {
            return json_encode(array("timestamp" => $time, "status" => 503, "error" => "Servicio no disponible", "exception" => "Servicio no disponible", "message" => "El servidor no está listo para manejar la solicitud. Por favor, inténtelo de nuevo más tarde."));
        } else if ($result == 'ALR002') {
            return json_encode(array("timestamp" => $time, "status" => 400, "error" => "Solicitud incorrecta", "exception" => "Número incorrecto de parámetros", "message" => "Verifique la estructura del token enviado."));
        } else if ($result == 'ALR011') {
            return json_encode(array("timestamp" => $time, "status" => 401, "error" => "No autorizado", "exception" => "Verificación de firma fallida", "message" => "Estructura no válida del token enviado."));
        } else if ($result == 'ALR014') {
            return json_encode(array("timestamp" => $time, "status" => 401, "error" => "No autorizado", "exception" => "Token caducado", "message" => "El tiempo de vida del token ha expirado."));
        } else {
            return json_encode(array("status" => 200, "message" => "Autenticado con éxito."));
        }
    }

    function deleteFile()
    {
        $time = time();
        $tokenResponse = $this->validateToken(apache_request_headers()["Authorization"]);
        $data = json_decode($tokenResponse);
        if ($data->status != 200) // IT'S AN ERROR
            echo $tokenResponse;
        else {
            if ($_POST['idDocumento'] == '' || $_POST['documentType'] == '' || $_POST['typeTransaction'] == '' || $_POST['clientName'] == '') {
                echo json_encode(array("timestamp" => $time, "status" => 400, "error" => "Bad request", "exception" => "Some parameter does not have a specified value.", "message" => "Verify that all parameters contain a specified value."));
            } else {
                $idDocumento = $this->input->post('idDocumento');
                $documentType = $this->input->post('documentType');
                $updateDocumentData = array(
                    "expediente" => NULL,
                    "modificado" => date('Y-m-d H:i:s'),
                    "idUser" => $this->input->post('typeTransaction') == 2 ? $this->input->post('clientName') : $this->session->userdata('id_usuario')
                );
                $filename = $this->Api_model->getFilename($idDocumento)->row()->expediente;
                $folder = $this->getFolderFile($documentType);
                $file = $folder . $filename;
                if (file_exists($file)) {
                    unlink($file);
                }
                $response = $this->Api_model->updateDocumentBranch($updateDocumentData, $idDocumento);
                if ($response == 1) // SUCCESS TRANSACTION
                    echo json_encode(array("status" => 200, "message" => "Record updated successfully."));
                else // ERROR TRANSACTION
                    echo json_encode(array("timestamp" => $time, "status" => 503, "error" => "Service Unavailable", "exception" => "Service Unavailable", "message" => "The server is not ready to handle the request. Please try again later."));
            }
        }
    }

    public function setStatusContratacion()
    {
        $objDatos = json_decode(base64_decode(file_get_contents("php://input")), true);
        //$newDatos = json_decode($objDatos, true);
        // echo var_dump($objDatos);
        // echo $objDatos['idusuario'];
        $datos = array('status_contratacion' => $objDatos['bandera'],
            'fecha_modificacion' => date("Y-m-d H:i:s"),
            'modificado_por' => $objDatos['modificado_por']);
        $result = $this->Api_model->updateUserContratacion($datos, $objDatos['idusuario']);


        //  echo $result;
        if ($result == 1) {
            $row = json_encode(array('resultado' => true));
        } else {
            $row = json_encode(array('resultado' => false));
        }

        echo base64_encode($row);
    }

    function generateToken()
    {
        $JwtSecretKey = $this->jwt_key->getSecretKey();
        $time = time();
        $data = array(
            "iat" => $time, // Tiempo en que inició el token
            "exp" => $time + (24 * 60 * 60), // Tiempo en el que expirará el token (24 horas)
            "userData" => array("id_asesor" => $this->input->post("id_asesor"), "id_gerente" => $this->input->post("id_gerente")),
        );
        $token = JWT::encode($data, $JwtSecretKey);
        if ($token != "") {

            $file = $_FILES["uploaded_file"];
            $documentName = $time . "_" . ($time + (24 * 60 * 60)) . "_" . $this->input->post("id_asesor") . "_" . $this->input->post("id_gerente") . "." . substr(strrchr($_FILES["uploaded_file"]["name"], "."), 1);
            $upload_file_response = move_uploaded_file($file["tmp_name"], "static/documentos/evidence_token/" . $documentName);
            if ($upload_file_response == true) {
                $data = array("token" => $token, "para" => $this->input->post("id_asesor"), "estatus" => 0, "creado_por" => $this->input->post("id_gerente"), "fecha_creacion" => date("Y-m-d H:i:s"), "nombre_archivo" => $documentName);
                $response = $this->General_model->addRecord("tokens", $data); // MJ: LLEVA 2 PARÁMETROS $table, $data
                if ($response == 1)
                    echo json_encode(array("status" => 200, "message" => "El token se ha generado de manera exitosa.", "id_token" => $token));
                else
                    echo json_encode(array("status" => 500, "message" => "No se ha podido insertar el token en la base de datos."));
            } else
                echo json_encode(array("status" => 500, "message" => "No se ha podido subir el archivo."));
        } else
            echo json_encode(array("status" => 500, "message" => "No se ha podido generar el token."));
    }

    public function verifyUser()
    {
        $objDatos = json_decode(base64_decode(file_get_contents("php://input")), true);
        $result = $this->Api_model->login_user($objDatos['username'], $objDatos['password']);


        if (count($result) > 0) {
            $row = json_encode(array("resultado" => true,
                "id_usuario" => $result[0]['id_usuario'],
                "estatus" => $result[0]['estatus']
            ));
        } else {
            $row = json_encode(array('resultado' => false));
        }

        echo base64_encode($row);
//print_r($result);

    }

    /**------------FUNCIÓN PARA MANDAR SERVICIO PARA EL SISTEMA DE TICKETS */
    public function ServicePostTicket()
    {
        $url = 'https://dashboard.gphsis.com/back/paginainicio';

        $name = $this->session->userdata('nombre') . ' ' . $this->session->userdata('apellido_paterno') . ' ' . $this->session->userdata('apellido_materno');
        $data = array(
            "idcrea" => $this->session->userdata('id_usuario'),
            "nombre" => $name,
            "sistema" => "CRM"
        );

        $ch = curl_init($url);
        # Setup request to send json via POST.
        $payload = json_encode($data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        # Return response instead of printing.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        # Send request.
        $result = curl_exec($ch);
        curl_close($ch);
        //$row = array('html' =>$result);
        echo json_encode($result);
    }

    /**--------------------------FIN----------------------- */

    function validateTokenApartados()
    {
        $data = json_decode(file_get_contents("php://input"));
        if (!isset($data->token))
            echo json_encode(array("status" => 400, "message" => "Algún parámetro no tiene un valor especificado o no viene informado."));
        else {
            if ($data->token == "")
                echo json_encode(array("status" => 400, "message" => "Algún parámetro no tiene un valor especificado o no viene informado."));
            else {
                $response = json_decode($this->validateToken($data->token));
                if ($response->status != 200) // IT'S AN ERROR
                    echo json_encode(array("status" => $response->status, "message" => $response->message));
                else
                    echo json_encode(array("status" => 200, "message" => "Token vigente."));
            }
        }
    }

    function generateTokenDropbox(){
        $time = time();
        $JwtSecretKey = $this->jwt_key->getSecretKey();
        $data = array(
            "iat" => $time, // Tiempo en que inició el token
            "exp" => $time + (24 * 60 * 60), // Tiempo en el que expirará el token (24 horas)
            "data" => array("idLote" => $_POST['idLote'], "idCliente" => $_POST['idCliente'],"nombreCl" => $_POST['nombreCl'],
            "nombreAs"=>$_POST['nombreAs'],"fechaApartado"=>$_POST['fechaApartado'],"nombreResidencial"=>$_POST['nombreResidencial'],"nombreCondominio"=>$_POST['nombreCondominio'],
            "nombreLote"=>$_POST['nombreLote'], "tipo" => 1),
        );
        $token = JWT::encode($data, $JwtSecretKey);
        echo json_encode($token);
    }

    function clientsInformation()
    {
        $data = $this->Api_model->getClientsInformation();
        if ($data != null)
            echo json_encode($data);
        else
            echo json_encode(array("status" => 200, "message" => "Información no disponible, inténtalo más tarde."));
    }

    function validateToken_dashboard($token)
    {
        $time = time();
        $JwtSecretKey = '571335_8549+3668_';
        $result = JWT::decode($token, $JwtSecretKey, array('HS256'));
        if (in_array($result, array('ALR001', 'ALR003', 'ALR004', 'ALR005', 'ALR006', 'ALR007', 'ALR008', 'ALR009', 'ALR010', 'ALR012', 'ALR013'))) {
            return json_encode(array("timestamp" => $time, "status" => 503, "error" => "Servicio no disponible", "exception" => "Servicio no disponible", "message" => "El servidor no está listo para manejar la solicitud. Por favor, inténtelo de nuevo más tarde."));
        } else if ($result == 'ALR002') {
            return json_encode(array("timestamp" => $time, "status" => 400, "error" => "Solicitud incorrecta", "exception" => "Número incorrecto de parámetros", "message" => "Verifique la estructura del token enviado."));
        } else if ($result == 'ALR011') {
            return json_encode(array("timestamp" => $time, "status" => 401, "error" => "No autorizado", "exception" => "Verificación de firma fallida", "message" => "Estructura no válida del token enviado."));
        } else if ($result == 'ALR014') {
            return json_encode(array("timestamp" => $time, "status" => 401, "error" => "No autorizado", "exception" => "Token caducado", "message" => "El tiempo de vida del token ha expirado."));
        } else {
            $validate= true;
        
            if($result->data->id_rol != 1 || $result->data->id_usuario != 1){
                $validate = false;
            }
            if($validate == 1){                
                return json_encode(array("status" => 200, "message" => "Autenticado con éxito.", "data"=> $result));
            }else{
                return json_encode(array("timestamp" => $time, "status" => 401, "error" => "No autorizado", "exception" => "Verificación de firma fallida", "message" => "Estructura no válida del token enviado."));
            }
        }
    }

   
    public function external_dashboard(){
        $response = $this->validateToken_dashboard($_GET['tkn']);
        $res = json_decode($response);
        if($res->status == 200){
            $this->session->set_userdata(array(
                'id_rol'  => 1,
                'id_usuario' => 2,
                'id_lider' => 0
            ));
            $datos['sub_menu'] = $this->get_menu->get_submenu_data($this->session->userdata('id_rol'), $this->session->userdata('id_usuario'));
            $datos['external'] = true;
            $this->load->view('template/header');
            $this->load->view("dashboard/base/base", $datos);
        }else{
            die("Inicio de sesion caducado.");
        }
    }

    function consultaInformacionContratos($rows_number = '') {
        if (!isset(apache_request_headers()["Authorization"]))
            echo json_encode(array("status" => -1, "message" => "La petición no cuenta con el encabezado Authorization."), JSON_UNESCAPED_UNICODE);
        else {
            if (apache_request_headers()["Authorization"] == "")
                echo json_encode(array("status" => -1, "message" => "Token no especificado dentro del encabezado Authorization."), JSON_UNESCAPED_UNICODE);
            else {
                $token = apache_request_headers()["Authorization"];
                $JwtSecretKey = $this->jwt_actions->getSecretKey(8134);
                $valida_token = json_decode($this->validateToken($token, 8134));
                if ($valida_token->status !== 200)
                    echo json_encode($valida_token);
                else {
                    $result = JWT::decode($token, $JwtSecretKey, array('HS256'));
                    $valida_token = Null;
                    foreach ($result->data as $key => $value) {
                        if(($key == "username" || $key == "password") && (is_null($value) || str_replace(" ","",$value) == '' || empty($value)))
                            $valida_token = false;
                    }
                    if(is_null($valida_token))
                        $valida_token = true;
                    if(!empty($result->data) && $valida_token)
                        $checkSingup = $this->jwt_actions->validateUserPass($result->data->username, $result->data->password);
                    else {
                        $checkSingup = null;
                        echo json_encode(array("status" => -1, "message" => "Algún parámetro (usuario y/o contraseña) no vienen informados. Verifique que ambos parámetros sean incluidos."), JSON_UNESCAPED_UNICODE);
                    }
                    if(!empty($checkSingup) && json_decode($checkSingup)->status == 200) {
                        $year = date('Y');
                        $month = date('n');
                        $year = $month == 1 ? $year -1 : $year;
                        $dbTransaction = $this->Internomex_model->getInformacionContratos($rows_number, $year, $month - 1);
                        $data2 = array();
                        for ($i = 0; $i < COUNT($dbTransaction); $i++) {
                            $data2[$i]['cliente']['tipo_persona'] = $dbTransaction[$i]['tipo_persona'];
                            $data2[$i]['cliente']['actividad_sector'] = $dbTransaction[$i]['actividad_sector'];
                            $data2[$i]['cliente']['nombre_denominacion'] = $dbTransaction[$i]['nombre_denominacion'];
                            $data2[$i]['cliente']['apellido_paterno'] = $dbTransaction[$i]['apellido_paterno'];
                            $data2[$i]['cliente']['apellido_materno'] = $dbTransaction[$i]['apellido_materno'];
                            $data2[$i]['cliente']['fecha_nacimiento_constitucion'] = $dbTransaction[$i]['fecha_nacimiento_constitucion'];
                            $data2[$i]['cliente']['curp'] = $dbTransaction[$i]['curp'];
                            $data2[$i]['cliente']['rfc'] = $dbTransaction[$i]['rfc'];
                            $data2[$i]['cliente']['nacionalidad'] = $dbTransaction[$i]['nacionalidad'];
                            $data2[$i]['cliente']['direccion'] = $dbTransaction[$i]['direccion'];
                            $data2[$i]['propiedad']['tipo_propiedad'] = $dbTransaction[$i]['tipo_propiedad'];
                            $data2[$i]['propiedad']['nombrePropiedad'] = $dbTransaction[$i]['nombrePropiedad'];
                            $data2[$i]['propiedad']['tamanio_terreno'] = $dbTransaction[$i]['tamanio_terreno'];
                            $data2[$i]['propiedad']['costo'] = $dbTransaction[$i]['costo'];
                            $data2[$i]['propiedad']['empresa'] = $dbTransaction[$i]['empresa'];
                            $data2[$i]['propiedad']['fechaEstatus9'] = $dbTransaction[$i]['fechaEstatus9'];
                            $data2[$i]['propiedad']['fechaEstatus7'] = $dbTransaction[$i]['fechaEstatus7'];
                            $data2[$i]['pagos']['forma_pago'] = implode(', ', array_unique(explode(',', $dbTransaction[$i]['forma_pago'])));
                            $data2[$i]['pagos']['monto_enganche'] = $dbTransaction[$i]['monto_enganche'];
                            $data2[$i]['pagos']['fecha_pago_comision'] = $dbTransaction[$i]['fecha_pago_comision'];
                            $data2[$i]['pagos']['monto_comision'] = $dbTransaction[$i]['monto_comision'];
                        }
                        if ($dbTransaction) // SUCCESS TRANSACTION
                            echo json_encode(array("status" => 1, "message" => "Consulta realizada con éxito.", "data" => $data2), JSON_UNESCAPED_UNICODE);
                        else // ERROR TRANSACTION
                            echo json_encode(array("status" => -1, "message" => "Servicio no disponible. El servidor no está listo para manejar la solicitud. Por favor, inténtelo de nuevo más tarde."), JSON_UNESCAPED_UNICODE);
                    } 
                    else
                        echo json_encode($checkSingup);
                }
            }
        }
    }

    function consultaInfoSedesResidenciales() {
        if (!isset(apache_request_headers()["Authorization"]))
            echo json_encode(array("status" => 400, "message" => "La petición no cuenta con el encabezado Authorization."), JSON_UNESCAPED_UNICODE);
        else {
            if (apache_request_headers()["Authorization"] == "")
                echo json_encode(array("status" => 400, "message" => "Token no especificado dentro del encabezado Authorization."), JSON_UNESCAPED_UNICODE);
            else {
                $token = apache_request_headers()["Authorization"];
                $JwtSecretKey = $this->jwt_actions->getSecretKey(9860);
                $valida_token = json_decode($this->validateToken($token, 9860));
                if ($valida_token->status !== 200)
                    echo json_encode($valida_token);
                else {
                    $result = JWT::decode($token, $JwtSecretKey, array('HS256'));
                    $valida_token = NULL;
                    foreach ($result->data as $key => $value) {
                        if(($key == "username" || $key == "password") && (is_null($value) || str_replace(" ","",$value) == '' || empty($value)))
                            $valida_token = false;
                    }
                    if(is_null($valida_token))
                        $valida_token = true;
                    if(!empty($result->data) && $valida_token){
                        $checkSingup = $this->jwt_actions->validateUserPass($result->data->username, $result->data->password);
                    }else {
                        $checkSingup = null;
                        echo json_encode(array("status" => 400, "message" => "Algún parámetro (usuario y/o contraseña) no vienen informados. Verifique que ambos parámetros sean incluidos."), JSON_UNESCAPED_UNICODE);
                    }if(!empty($checkSingup) && json_decode($checkSingup)->status == 200){
                        $dbTransaction = $this->Api_model->getInformationOfficesAndResidences();
                        if ($dbTransaction) // SUCCESS TRANSACTION
                            echo json_encode(array("status" => 200, "message" => "Consulta realizada con éxito.", "resultado" => $dbTransaction), JSON_UNESCAPED_UNICODE);
                        else // ERROR TRANSACTION
                            echo json_encode(array("status" => 503, "message" => "Servicio no disponible. El servidor no está listo para manejar la solicitud. Por favor, inténtelo de nuevo más tarde."), JSON_UNESCAPED_UNICODE);
                    } else
                        echo ($checkSingup);
                }
            }
        }
    }
    
    public function validarAutorizacionCorreo(int $idCliente)
    {
        $codigo = $this->input->get('codigo');
        if (!isset($codigo)) {
            $this->load->view('template/header');
            $this->load->view('clientes/autorizacion-cliente', [
                'titulo' => 'ERROR',
                'mensaje' => 'No hay un código de verificación.'
            ]);
            return;
        }

        $cliente = $this->Clientes_model->clienteAutorizacion($idCliente);

        if (!isset($cliente)) {
            $this->load->view('template/header');
            $this->load->view('clientes/autorizacion-cliente', [
                'titulo' => 'ERROR',
                'mensaje' => 'No existe el cliente.'
            ]);
            return;
        }

        if (is_null($cliente->autorizacion_correo) && is_null($cliente->codigo_correo)) {
            $this->load->view('template/header');
            $this->load->view('clientes/autorizacion-cliente', [
                'titulo' => 'INFORMACIÓN',
                'mensaje' => 'El link ya no está activo.'
            ]);
            return;
        }

        if ($cliente->autorizacion_correo == AutorizacionClienteOpcs::VALIDADO) {
            $this->load->view('template/header');
            $this->load->view('clientes/autorizacion-cliente', [
                'titulo' => 'INFORMACIÓN',
                'mensaje' => 'El registro ya fue anteriormente validado.'
            ]);
            return;
        }

        if ($cliente->codigo_correo !== $codigo) {
            $this->load->view('template/header');
            $this->load->view('clientes/autorizacion-cliente', [
                'titulo' => 'ERROR',
                'mensaje' => 'El código no coincide con el registro.'
            ]);
            return;
        }

        $this->General_model->deleteRecord('codigo_autorizaciones', ['id_aut_clientes' => $cliente->id_aut_correo]);
        $this->General_model->updateRecord(
            'clientes', ['autorizacion_correo' => AutorizacionClienteOpcs::VALIDADO],
            'id_cliente', $idCliente
        );

        $this->load->view('template/header');
        $this->load->view('clientes/autorizacion-cliente', [
            'titulo' => 'PROCESO EXITOSO',
            'mensaje' => 'Gracias por autorizar y verificar la información.'
        ]);
    }

    public function autorizacionSms(int $idCliente)
    {
        $codigo = $this->input->get('codigo');

        if (!isset($codigo)) {
            $this->load->view('template/header');
            $this->load->view('clientes/autorizacion-cliente-sms', [
                'code' => 400,
                'titulo' => 'ERROR',
                'mensaje' => 'No hay un código de verificación.'
            ]);
            return;
        }

        $cliente = $this->Clientes_model->clienteAutorizacion($idCliente);

        if (!isset($cliente)) {
            $this->load->view('template/header');
            $this->load->view('clientes/autorizacion-cliente-sms', [
                'code' => 400,
                'titulo' => 'ERROR',
                'mensaje' => 'No existe el cliente.'
            ]);
            return;
        }

        if (is_null($cliente->autorizacion_sms) && is_null($cliente->codigo_sms)) {
            $this->load->view('template/header');
            $this->load->view('clientes/autorizacion-cliente-sms', [
                'code' => 400,
                'titulo' => 'INFORMACIÓN',
                'mensaje' => 'El link ya no está activo.'
            ]);
            return;
        }

        if ($cliente->autorizacion_sms == AutorizacionClienteOpcs::VALIDADO) {
            $this->load->view('template/header');
            $this->load->view('clientes/autorizacion-cliente-sms', [
                'code' => 400,
                'titulo' => 'INFORMACIÓN',
                'mensaje' => 'El registro ya fue anteriormente validado.'
            ]);
            return;
        }

        if ($cliente->codigo_sms !== $codigo) {
            $this->load->view('template/header');
            $this->load->view('clientes/autorizacion-cliente-sms', [
                'code' => 400,
                'titulo' => 'ERROR',
                'mensaje' => 'El código no coincide con el registro.'
            ]);
            return;
        }

        $this->load->view('template/header');
        $this->load->view('clientes/autorizacion-cliente-sms', ['code' => 200, 'idCliente' => $idCliente]);
    }

    public function validarAutorizacionSms()
    {
        $codigo = $this->input->post('codigo');
        $idCliente = $this->input->post('idCliente');

        if (!isset($codigo)) {
            echo json_encode(['code' => 400, 'mensaje' => 'No hay un código de verificación.']);
            return;
        }

        $cliente = $this->Clientes_model->clienteAutorizacion($idCliente);

        if (!isset($cliente)) {
            echo json_encode(['code' => 400, 'mensaje' => 'No existe el cliente.']);
            return;
        }

        if (is_null($cliente->autorizacion_sms) && is_null($cliente->codigo_sms)) {
            echo json_encode(['code' => 400, 'mensaje' => 'El link ya no está activo.']);
            return;
        }

        if ($cliente->autorizacion_sms == AutorizacionClienteOpcs::VALIDADO) {
            echo json_encode(['code' => 400, 'mensaje' => 'El registro ya fue anteriormente validado.']);
            return;
        }

        if ($cliente->codigo_sms !== $codigo) {
            echo json_encode(['code' => 400, 'mensaje' => 'El código no coincide con el registro.']);
            return;
        }

        $this->General_model->deleteRecord('codigo_autorizaciones', ['id_aut_clientes' => $cliente->id_aut_sms]);
        $this->General_model->updateRecord(
            'clientes', ['autorizacion_sms' => AutorizacionClienteOpcs::VALIDADO],
            'id_cliente', $idCliente
        );

        echo json_encode(['code' => 200, 'mensaje' => 'Gracias por autorizar y verificar la información.']);
    }

    function addLeadRecordArcus() {
        if (!isset(apache_request_headers()["Authorization"]))
            echo json_encode(array("status" => -1, "message" => "La petición no cuenta con el encabezado Authorization."), JSON_UNESCAPED_UNICODE);
        else {
            if (apache_request_headers()["Authorization"] == "")
                echo json_encode(array("status" => -1, "message" => "Token no especificado dentro del encabezado Authorization."), JSON_UNESCAPED_UNICODE);
            else {
                $token = apache_request_headers()["Authorization"];
                $JwtSecretKey = $this->jwt_actions->getSecretKey(5918);
                $valida_token = json_decode($this->validateToken($token, 5918));
                if ($valida_token->status !== 200)
                    echo json_encode($valida_token);
                else {
                    $result = JWT::decode($token, $JwtSecretKey, array('HS256'));
                    $valida_token = Null;
                    foreach ($result->data as $key => $value) {
                        if(($key == "username" || $key == "password") && (is_null($value) || str_replace(" ","",$value) == '' || empty($value)))
                            $valida_token = false;
                    }
                    if(is_null($valida_token))
                        $valida_token = true;
                    if(!empty($result->data) && $valida_token)
                        $checkSingup = $this->jwt_actions->validateUserPass($result->data->username, $result->data->password);
                    else {
                        $checkSingup = null;
                        echo json_encode(array("status" => -1, "message" => "Algún parámetro (usuario y/o contraseña) no vienen informados. Verifique que ambos parámetros sean incluidos."), JSON_UNESCAPED_UNICODE);
                    }
                    if(!empty($checkSingup) && json_decode($checkSingup)->status == 200) {
                        $data = json_decode(file_get_contents("php://input"));
                        if (!isset($data->nombreCompleto) || !isset($data->telefono) || !isset($data->email) || !isset($data->origenReferido) || !isset($data->asesorAsignado) || !isset($data->ciudadInteres) || !isset($data->desarrolloInteres) || !isset($data->uid) || !isset($data->idAsesor))
                            echo json_encode(array("status" => -1, "message" => "Algún parámetro no viene informado. Verifique que todos los parámetros requeridos se incluyan en la petición."), JSON_UNESCAPED_UNICODE);
                        else {
                            if (($data->nombreCompleto == '') || ($data->telefono == '') || ($data->email == '') || ($data->origenReferido == '') || ($data->asesorAsignado == '') || ($data->ciudadInteres == '') || ($data->desarrolloInteres == '') || ($data->uid == '') || ($data->idAsesor == ''))
                                echo json_encode(array("status" => -1, "message" => "Algún parámetro no tiene un valor especificado. Verifique que todos los parámetros contengan un valor especificado."), JSON_UNESCAPED_UNICODE);
                            else {
                                $result = $this->Api_model->getAdviserLeaderInformation($data->idAsesor);
                                if(empty($result) || $result == '')
                                    echo json_encode(array("status" => -1, "message" => "El valor ingresado para IdAsesor no corresponde a un asesor."), JSON_UNESCAPED_UNICODE);
                                else {
                                    if ($result->id_rol != 7)
                                        echo json_encode(array("status" => -1, "message" => "El valor ingresado para IdAsesor no corresponde a un ID de usuario con rol de asesor."), JSON_UNESCAPED_UNICODE);
                                    else {
                                        $data = array(
                                            "id_sede" => $result->id_sede,
                                            "id_asesor" => $data->idAsesor,
                                            "id_coordinador" => $result->id_coordinador,
                                            "id_gerente" => $result->id_gerente,
                                            "id_subdirector" => $result->id_subdirector,
                                            "id_regional" => $result->id_regional,
                                            "personalidad_juridica" => 2,
                                            "nombre" => $data->nombreCompleto,
                                            "apellido_paterno" => '',
                                            "apellido_materno" => '',
                                            "correo" => $data->email,
                                            "telefono" => $data->telefono,
                                            "lugar_prospeccion" => 47,
                                            "otro_lugar" => 0,
                                            "plaza_venta" => 0,
                                            "fecha_creacion" => date("Y-m-d H:i:s"),
                                            "creado_por" => 1,
                                            "fecha_modificacion" => date("Y-m-d H:i:s"),
                                            "modificado_por" => 1,
                                            "fecha_vencimiento" => date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . "+ 30 days")),
                                            "observaciones" => '',
                                            "id_arcus"  =>  $data->uid,
                                            "origen_referido"   =>  $data->origenReferido,
                                            "asesor_asignado"   =>  $data->asesorAsignado,
                                            "ciudad_interes"   =>  $data->ciudadInteres,
                                            "desarrollo_interes"   =>  $data->desarrolloInteres
                                        );
                                        $dbTransaction = $this->General_model->addRecord("prospectos", $data); // MJ: LLEVA 2 PARÁMETROS $table, $data
                                        if ($dbTransaction){ // SUCCESS TRANSACTION
                                            echo json_encode(array("status" => 1, "message" => "Registro guardado con éxito."), JSON_UNESCAPED_UNICODE);
                                            header('Content-Type: application/json');
                                        }
                                        else{ // ERROR TRANSACTION
                                            echo json_encode(array("status" => -1, "message" => "Servicio no disponible. El servidor no está listo para manejar la solicitud. Por favor, inténtelo de nuevo más tarde."), JSON_UNESCAPED_UNICODE);
                                            header('Content-Type: application/json');
                                        }
                                    }
                                }
                            }
                        }
                    } 
                    else
                        echo ($checkSingup);
                        header('Content-Type: application/json');
                }
            }
        }
    }

    function sendLeadInfoRecord() {
        $data = json_decode(file_get_contents('php://input'));
        if(!isset($data->fechaDeCompra) || !isset($data->propiedadRelacionada) || !isset($data->uid) || !isset($data->id) || !isset($data->montoDelNegocio))
            echo json_encode(array("status" => 400, "message" => "Algún parámetro no viene informado."), JSON_UNESCAPED_UNICODE);
        else {
            $JwtSecretKey = $this->jwt_actions->getSecretKey(5918);
            $time = time();
            $datos = array(
                "iat" => $time, // Tiempo en que inició el token
                "exp" => $time + (24 * 60 * 60), // Tiempo en el que expirará el token (24 horas)
                "data" => array("username" => "9m1%6n7DfR", "password" => "7%5bea3K&B^fMhfOw8Rj"),
            );
            $token = '';
            // $url = curl_init('https://prueba.gphsis.com/sisfusion/api/exitoArcus');
            $url = curl_init();
            curl_setopt($url, CURLOPT_URL, 'https://hook.us1.make.com/l3mh2xcfdsxob8l2ip28iv53ctikfwbm');
            curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($url, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Authorization:'. $token
            ));
            $data->montoDelNegocio = doubleval($data->montoDelNegocio);
            curl_setopt($url, CURLOPT_POSTFIELDS, json_encode($data));
            $response = curl_exec($url);
            $status = curl_getinfo($url, CURLINFO_HTTP_CODE);
            curl_close($url);
            $result = array(
                'response'  =>  $response,
                'status'    =>  $status
            );
            echo json_encode($result);
        }
    }

    //funcion de prueba para el servicio de Arcus, borrar despues de pruebas y Vo.Bo.
    function exitoArcus() {
        if (!isset(apache_request_headers()["authorization"]))
            echo json_encode(array("status" => 400, "message" => "La petición no cuenta con el encabezado Authorization."), JSON_UNESCAPED_UNICODE);
        else {
            if (apache_request_headers()["authorization"] == "")
                echo json_encode(array("status" => 400, "message" => "Token no especificado dentro del encabezado Authorization."), JSON_UNESCAPED_UNICODE);
            else{
                $token = apache_request_headers()["authorization"];
                $JwtSecretKey = $this->jwt_actions->getSecretKey(5918);
                $valida_token = json_decode($this->validateToken($token, 5918));
                if ($valida_token->status !== 200)
                    echo json_encode($valida_token);
                else {
                    $result = JWT::decode($token, $JwtSecretKey, array('HS256'));
                    $valida_token = NULL;
                    foreach ($result->data as $key => $value) {
                        if(($key == "username" || $key == "password") && (is_null($value) || str_replace(" ","",$value) == '' || empty($value)))
                            $valida_token = false;
                    }
                    if(is_null($valida_token))
                        $valida_token = true;
                    if(!empty($result->data) && $valida_token)
                        $checkSingup = $this->jwt_actions->validateUserPass($result->data->username, $result->data->password);
                    else {
                        $checkSingup = null;
                        echo json_encode(array("status" => 400, "message" => "Algún parámetro (usuario y/o contraseña) no vienen informados. Verifique que ambos parámetros sean incluidos."), JSON_UNESCAPED_UNICODE);
                    } if(!empty($checkSingup) && json_decode($checkSingup)->status == 200) {
                        $data = file_get_contents("php://input");
                        echo json_encode(array("status" => 200, "message" => "Consulta realizada con éxito.", "datos"   =>  $data), JSON_UNESCAPED_UNICODE);
                    }
                }
            }
        }

    }

    function getAsesoresArcus($fecha = '') {
        if (!isset(apache_request_headers()["Authorization"]))
            echo json_encode(array("status" => -1, "message" => "La petición no cuenta con el encabezado Authorization."), JSON_UNESCAPED_UNICODE);
        else {
            if (apache_request_headers()["Authorization"] == "")
                echo json_encode(array("status" => -1, "message" => "Token no especificado dentro del encabezado Authorization."), JSON_UNESCAPED_UNICODE);
            else {
                $token = apache_request_headers()["Authorization"];
                $JwtSecretKey = $this->jwt_actions->getSecretKey(5918);
                $valida_token = json_decode($this->validateToken($token, 5918));
                if ($valida_token->status !== 200)
                    echo json_encode($valida_token);
                else {
                    $result = JWT::decode($token, $JwtSecretKey, array('HS256'));
                    $valida_token = Null;
                    foreach ($result->data as $key => $value) {
                        if(($key == "username" || $key == "password") && (is_null($value) || str_replace(" ","",$value) == '' || empty($value)))
                            $valida_token = false;
                    }
                    if(is_null($valida_token))
                        $valida_token = true;
                    if(!empty($result->data) && $valida_token)
                        $checkSingup = $this->jwt_actions->validateUserPass($result->data->username, $result->data->password);
                    else {
                        $checkSingup = null;
                        echo json_encode(array("status" => -1, "message" => "Algún parámetro (usuario y/o contraseña) no vienen informados. Verifique que ambos parámetros sean incluidos."), JSON_UNESCAPED_UNICODE);
                    }
                    if(!empty($checkSingup) && json_decode($checkSingup)->status == 200) {
                        $dbQueryResult = $this->Api_model->getAsesoresList($fecha);
                        if ($dbQueryResult) // SUCCESS TRANSACTION
                            echo json_encode(array("status" => 1, "message" => "Consulta realizada con éxito.", "data" => $dbQueryResult), JSON_UNESCAPED_UNICODE);
                        else // ERROR TRANSACTION
                            echo json_encode(array("status" => -1, "message" => "Servicio no disponible. El servidor no está listo para manejar la solicitud. Por favor, inténtelo de nuevo más tarde."), JSON_UNESCAPED_UNICODE);
                    } 
                    else
                        echo ($checkSingup);
                }
            }
        }
    }

    function consultaInfoProspecto(){

        if (!isset(apache_request_headers()["Authorization"]))
            echo json_encode(array("status" => -1, "message" => "La petición no cuenta con el encabezado Authorization."), JSON_UNESCAPED_UNICODE);
        else {
            if (apache_request_headers()["Authorization"] == "")
                echo json_encode(array("status" => -1, "message" => "Token no especificado dentro del encabezado Authorization."), JSON_UNESCAPED_UNICODE);
            else {
                $token = apache_request_headers()["Authorization"];
                $JwtSecretKey = $this->jwt_actions->getSecretKey(5918);
                $valida_token = json_decode($this->validateToken($token, 5918));
                if ($valida_token->status !== 200)
                    echo json_encode($valida_token);
                else {
                    $result = JWT::decode($token, $JwtSecretKey, array('HS256'));
                    $valida_token = Null;
                    foreach ($result->data as $key => $value) {
                        if(($key == "username" || $key == "password") && (is_null($value) || str_replace(" ","",$value) == '' || empty($value)))
                            $valida_token = false;
                    }
                    if(is_null($valida_token))
                        $valida_token = true;
                    if(!empty($result->data) && $valida_token)
                        $checkSingup = $this->jwt_actions->validateUserPass($result->data->username, $result->data->password);
                    else {
                        $checkSingup = null;
                        echo json_encode(array("status" => -1, "message" => "Algún parámetro (usuario y/o contraseña) no vienen informados. Verifique que ambos parámetros sean incluidos."), JSON_UNESCAPED_UNICODE);
                    }
                    if(!empty($checkSingup) && json_decode($checkSingup)->status == 200) {
                        $year = $this->input->post("year", true);
                        $month = $this->input->post("month", true);


                        $consulta = $this->Api_model->getInformacionProspectos($year, $month);
                        echo json_encode($consulta);
                        exit;
                        $this->output->set_content_type('application/json');
                        $this->output->set_output(json_encode($consulta));
                    } 
                    else
                        echo ($checkSingup);
                        header('Content-Type: application/json');
                }
            }
        }

    }

    function getCatalogos() {
        if (!isset(apache_request_headers()["Authorization"]))
            echo json_encode(array("status" => -1, "message" => "La petición no cuenta con el encabezado Authorization."), JSON_UNESCAPED_UNICODE);
        else {
            if (apache_request_headers()["Authorization"] == "")
                echo json_encode(array("status" => -1, "message" => "Token no especificado dentro del encabezado Authorization."), JSON_UNESCAPED_UNICODE);
            else {
                $token = apache_request_headers()["Authorization"];
                $JwtSecretKey = $this->jwt_actions->getSecretKey(9347);
                $valida_token = json_decode($this->validateToken($token, 9347));
                if ($valida_token->status !== 200)
                    echo json_encode($valida_token);
                else {
                    $result = JWT::decode($token, $JwtSecretKey, array('HS256'));
                    $valida_token = Null;
                    foreach ($result->data as $key => $value) {
                        if(($key == "username" || $key == "password") && (is_null($value) || str_replace(" ","",$value) == '' || empty($value)))
                            $valida_token = false;
                    }
                    if(is_null($valida_token))
                        $valida_token = true;
                    if(!empty($result->data) && $valida_token)
                        $checkSingup = $this->jwt_actions->validateUserPass($result->data->username, $result->data->password);
                    else {
                        $checkSingup = null;
                        echo json_encode(array("status" => -1, "message" => "Algún parámetro (usuario y/o contraseña) no vienen informados. Verifique que ambos parámetros sean incluidos."), JSON_UNESCAPED_UNICODE);
                    }
                    if(!empty($checkSingup) && json_decode($checkSingup)->status == 200) {
                        $dbTransaction = $this->Api_model->getCatalogos();
                        $data['formas_pago'] = array();
                        $data['sedes'] = array();
                        $data['roles'] = array();
                        for ($i = 0; $i < COUNT($dbTransaction); $i++) {
                            if ($dbTransaction[$i]['id_catalogo'] == 16) // FORMAS DE PAGO
                                array_push($data['formas_pago'], ['id_opcion' => $dbTransaction[$i]['id_opcion'], 'nombre' => $dbTransaction[$i]['nombre']]);
                            if ($dbTransaction[$i]['id_catalogo'] == 0) // SEDES
                                array_push($data['sedes'], ['id_opcion' => $dbTransaction[$i]['id_opcion'], 'nombre' => $dbTransaction[$i]['nombre']]);
                            if ($dbTransaction[$i]['id_catalogo'] == 1) // ROLES
                                array_push($data['roles'], ['id_opcion' => $dbTransaction[$i]['id_opcion'], 'nombre' => $dbTransaction[$i]['nombre']]);
                        }
                        if ($dbTransaction) // SUCCESS TRANSACTION
                            echo json_encode(array("status" => 1, "message" => "Consulta realizada con éxito.", "data" => $data), JSON_UNESCAPED_UNICODE);
                        else // ERROR TRANSACTION
                            echo json_encode(array("status" => -1, "message" => "Servicio no disponible. El servidor no está listo para manejar la solicitud. Por favor, inténtelo de nuevo más tarde."), JSON_UNESCAPED_UNICODE);
                    } else
                        echo json_encode($checkSingup);
                }
            }
        }
    }

    function agregarUsuarioOoam() {
        if (!isset(apache_request_headers()["Authorization"]))
            echo json_encode(array("status" => -1, "message" => "La petición no cuenta con el encabezado Authorization."), JSON_UNESCAPED_UNICODE);
        else {
            if (apache_request_headers()["Authorization"] == "")
                echo json_encode(array("status" => -1, "message" => "Token no especificado dentro del encabezado Authorization."), JSON_UNESCAPED_UNICODE);
            else {
                $token = apache_request_headers()["Authorization"];
                $JwtSecretKey = $this->jwt_actions->getSecretKey(9347);
                $valida_token = json_decode($this->validateToken($token, 9347));
                if ($valida_token->status !== 200)
                    echo json_encode($valida_token);
                else {
                    $result = JWT::decode($token, $JwtSecretKey, array('HS256'));
                    $valida_token = Null;
                    foreach ($result->data as $key => $value) {
                        if(($key == "username" || $key == "password") && (is_null($value) || str_replace(" ","",$value) == '' || empty($value)))
                            $valida_token = false;
                    }
                    if(is_null($valida_token))
                        $valida_token = true;
                    if(!empty($result->data) && $valida_token)
                        $checkSingup = $this->jwt_actions->validateUserPass($result->data->username, $result->data->password);
                    else {
                        $checkSingup = null;
                        echo json_encode(array("status" => -1, "message" => "Algún parámetro (usuario y/o contraseña) no vienen informados. Verifique que ambos parámetros sean incluidos."), JSON_UNESCAPED_UNICODE);
                    }
                    if(!empty($checkSingup) && json_decode($checkSingup)->status == 200){
                        $data = json_decode(file_get_contents("php://input"));
                        if (!isset($data->forma_pago) || !isset($data->nombre) || !isset($data->apellido_paterno) || !isset($data->correo) || !isset($data->usuario) || !isset($data->contrasena) || !isset($data->id_sede) || !isset($data->id_lider) || !isset($data->id_rol) || !isset($data->telefono))
                            echo json_encode(array("status" => -1, "message" => "Algún parámetro no viene informado. Verifique que todos los parámetros requeridos se incluyan en la petición."), JSON_UNESCAPED_UNICODE);
                        else {
                            if ($data->forma_pago == '' || $data->nombre == '' || $data->apellido_paterno == '' || $data->correo == '' || $data->usuario == '' || $data->contrasena == '' || $data->id_sede == '' || $data->id_lider == '' || $data->id_rol == '')
                                echo json_encode(array("status" => -1, "message" => "Algún parámetro no tiene un valor especificado. Verifique que todos los parámetros contengan un valor especificado."), JSON_UNESCAPED_UNICODE);
                            else {
                                $result = $this->Api_model->verificarExistenciaUsuario($data->usuario);
                                if (count($result) > 0) // EXISTE EL REGISTRO
                                    echo json_encode(array("status" => -1, "message" => "El nombre de usuario asignado ya existe, inténtalo con otro valor."), JSON_UNESCAPED_UNICODE);
                                else {
                                    $data = array(
                                        "fecha_creacion" => date("Y-m-d H:i:s"),
                                        "creado_por" => 1,
                                        "fecha_modificacion" => date("Y-m-d H:i:s"),
                                        "modificado_por" => 1,
                                        "rfc" => $data->rfc,
                                        "sesion_activa" => 0,
                                        "estatus" => 1,
                                        "tipo" => 3,
                                        "forma_pago" => $data->forma_pago,
                                        "nombre" => $data->nombre,
                                        "apellido_paterno" => $data->apellido_paterno,
                                        "apellido_materno" => $data->apellido_materno,
                                        "correo" => $data->correo,
                                        "telefono" => $data->telefono,
                                        "usuario" => $data->usuario,
                                        "contrasena" => encriptar($data->contrasena),
                                        "id_sede" => $data->id_sede,
                                        "id_lider" => $data->id_lider,
                                        "id_rol" => $data->id_rol
                                    );
                                    $dbTransaction = $this->Api_model->agregarUsuarioOoam($data); // MJ: LLEVA 2 PARÁMETROS $table, $data
                                    if ($dbTransaction) // SUCCESS TRANSACTION
                                        echo json_encode(array("status" => 1, "message" => "Registro guardado con éxito.", "data" => ['id_usuario' => $dbTransaction[0]['id_usuario']]), JSON_UNESCAPED_UNICODE);
                                    else // ERROR TRANSACTION
                                        echo json_encode(array("status" => -1, "message" => "Servicio no disponible. El servidor no está listo para manejar la solicitud. Por favor, inténtelo de nuevo más tarde."), JSON_UNESCAPED_UNICODE);
                                }
                            }
                        }
                    } else
                        echo json_encode($checkSingup);
                }
            }
        }
    }

    function desactivarUsuarioOoam() {
        if (!isset(apache_request_headers()["Authorization"]))
            echo json_encode(array("status" => -1, "message" => "La petición no cuenta con el encabezado Authorization."), JSON_UNESCAPED_UNICODE);
        else {
            if (apache_request_headers()["Authorization"] == "")
                echo json_encode(array("status" => -1, "message" => "Token no especificado dentro del encabezado Authorization."), JSON_UNESCAPED_UNICODE);
            else {
                $token = apache_request_headers()["Authorization"];
                $JwtSecretKey = $this->jwt_actions->getSecretKey(9347);
                $valida_token = json_decode($this->validateToken($token, 9347));
                if ($valida_token->status !== 200)
                    echo json_encode($valida_token);
                else {
                    $result = JWT::decode($token, $JwtSecretKey, array('HS256'));
                    $valida_token = Null;
                    foreach ($result->data as $key => $value) {
                        if(($key == "username" || $key == "password") && (is_null($value) || str_replace(" ","",$value) == '' || empty($value)))
                            $valida_token = false;
                    }
                    if(is_null($valida_token))
                        $valida_token = true;
                    if(!empty($result->data) && $valida_token)
                        $checkSingup = $this->jwt_actions->validateUserPass($result->data->username, $result->data->password);
                    else {
                        $checkSingup = null;
                        echo json_encode(array("status" => -1, "message" => "Algún parámetro (usuario y/o contraseña) no vienen informados. Verifique que ambos parámetros sean incluidos."), JSON_UNESCAPED_UNICODE);
                    }
                    if(!empty($checkSingup) && json_decode($checkSingup)->status == 200){
                        $data = json_decode(file_get_contents("php://input"));
                        if (!isset($data->id_usuario))
                            echo json_encode(array("status" => -1, "message" => "Algún parámetro no viene informado. Verifique que todos los parámetros requeridos se incluyan en la petición."), JSON_UNESCAPED_UNICODE);
                        else {
                            if ($data->id_usuario == '')
                                echo json_encode(array("status" => -1, "message" => "Algún parámetro no tiene un valor especificado. Verifique que todos los parámetros contengan un valor especificado."), JSON_UNESCAPED_UNICODE);
                            else {                
                                $dataUpdate = array(
                                    "fecha_modificacion" => date("Y-m-d H:i:s"),
                                    "modificado_por" => 1,
                                    "estatus" => 3
                                );
                                $dbTransaction = $this->General_model->updateRecord('usuarios', $dataUpdate, 'id_usuario', $data->id_usuario);
                                if ($dbTransaction) // SUCCESS TRANSACTION
                                    echo json_encode(array("status" => 1, "message" => "Registro actualizado con éxito."), JSON_UNESCAPED_UNICODE);
                                else // ERROR TRANSACTION
                                    echo json_encode(array("status" => -1, "message" => "Servicio no disponible. El servidor no está listo para manejar la solicitud. Por favor, inténtelo de nuevo más tarde."), JSON_UNESCAPED_UNICODE);
                            }
                        }
                    } else
                        echo json_encode($checkSingup);
                }
            }
        }
    }


    function insertComisionesOoam() {
        if (!isset(apache_request_headers()["Authorization"]))
            echo json_encode(array("status" => -1, "message" => "La petición no cuenta con el encabezado Authorization."), JSON_UNESCAPED_UNICODE);
        else {
            if (apache_request_headers()["Authorization"] == "")
                echo json_encode(array("status" => -1, "message" => "Token no especificado dentro del encabezado Authorization."), JSON_UNESCAPED_UNICODE);
            else {
                $token = apache_request_headers()["Authorization"];
                $JwtSecretKey = $this->jwt_actions->getSecretKey(9347);
                $valida_token = json_decode($this->validateToken($token, 9347));
                if ($valida_token->status !== 200)
                    echo json_encode($valida_token);
                else {
                    $result = JWT::decode($token, $JwtSecretKey, array('HS256'));
                    $valida_token = Null;
                    foreach ($result->data as $key => $value) {
                        if(($key == "username" || $key == "password") && (is_null($value) || str_replace(" ","",$value) == '' || empty($value)))
                            $valida_token = false;
                    }
                    if(is_null($valida_token))
                        $valida_token = true;
                    if(!empty($result->data) && $valida_token)
                        $checkSingup = $this->jwt_actions->validateUserPass($result->data->username, $result->data->password);
                    else {
                        $checkSingup = null;
                        echo json_encode(array("status" => -1, "message" => "Algún parámetro (usuario y/o contraseña) no vienen informados. Verifique que ambos parámetros sean incluidos."), JSON_UNESCAPED_UNICODE);
                    }
                    if(!empty($checkSingup) && json_decode($checkSingup)->status == 200){
                        $dataReturn = json_decode(file_get_contents("php://input"));
                        if (!isset($dataReturn->referencia) || !isset($dataReturn->empresa) || !isset($dataReturn->estatusContratacion) || !isset($dataReturn->totalLote) || !isset($dataReturn->idCliente) || !isset($dataReturn->nombreCliente))
                            echo json_encode(array("status" => -1, "message" => "Algún parámetro no viene informado. Verifique que todos los parámetros requeridos se incluyan en la petición."), JSON_UNESCAPED_UNICODE);
                        else {
                            if (($dataReturn->referencia == '') || ($dataReturn->empresa == '') || ($dataReturn->estatusContratacion == '') || ($dataReturn->totalLote == '') || ($dataReturn->idCliente == '') ||($dataReturn->nombreCliente  == ''))
                                echo json_encode(array("status" => -1, "message" => "Algún parámetro no tiene un valor especificado. Verifique que todos los parámetros contengan un valor especificado."), JSON_UNESCAPED_UNICODE);
                            else {
                                $getLoteComision = $this->Ooam_model->validaLoteComision($dataReturn->referencia, $dataReturn->empresa, $dataReturn->nombreLote);
                                if(count($getLoteComision) > 0 )
                                    echo (json_encode(array("result" => false, "message" => "El Lote ingresado ya se encuentra registrado.")));
                                    else {
                                        $consultarReferencia = $this->Ooam_model->getInfoLote($dataReturn->referencia, $dataReturn->empresa, $dataReturn->nombreLote);
                                        if(empty($consultarReferencia))
                                        echo (json_encode(array("result" => false, "message" => "Alguno de los datos (referencia, empresa, nombre de Lote) no se encuentra registrada.")));
                                    
                                    else {
                                        $datosComisionistas = count($dataReturn->comisionistas);
                                        $totalLote = json_decode($dataReturn->totalLote);
                                        $dataComisiones = array();
                                        $generalComisiones = 0;
                                        $porcentajesComisiones = 0;
                                        $dataPago = array();
                                        $getInfoLote = $this->Ooam_model->getInfoLote($dataReturn->referencia, $dataReturn->empresa, $dataReturn->nombreLote);
                                        
                                        for($i = 0; $i < $datosComisionistas; $i++ ){
                                            $getPlanComision = $this->Ooam_model->getPlanComision($dataReturn->comisionistas[$i]->rolGenerado,1);
                                            $porcentajeComision = json_decode($getPlanComision->porcentajeComision);
                                            $comisionTotal = (($porcentajeComision/100)*$totalLote);
                                            $generalComisiones =  $generalComisiones + $comisionTotal;
                                            $porcentajesComisiones =  $porcentajesComisiones + $porcentajeComision;
                                            $dataComisiones['id_lote'] = $getInfoLote->idLote;                            
                                            $dataComisiones['id_usuario'] = $dataReturn->comisionistas[$i]->idUsuario;      
                                            $dataComisiones['comision_total'] = $comisionTotal;                                  
                                            $dataComisiones['estatus'] = 1; 
                                            $dataComisiones['observaciones'] = "COMISION OOAM";                                 
                                            $dataComisiones['porcentaje_decimal'] = $porcentajeComision;                             
                                            $dataComisiones['rol_generado'] = $dataReturn->comisionistas[$i]->rolGenerado;    
                                            $dataComisiones['descuento'] = 0;                                              
                                            $dataComisiones['idCliente'] = $dataReturn->idCliente;                          
                                            $dataComisiones['modificado_por'] = 1;                                              
                                            $dataComisiones['fecha_modificado'] = date("Y-m-d H:i:s");
                                            $dataComisiones['fecha_creacion'] = date("Y-m-d H:i:s");
                                            $dataComisiones['fecha_autorizacion'] = date("Y-m-d H:i:s");
                                            $dataComisiones['creado_por'] = 1;                                                
                                            
                                            if (isset($dataComisiones) && !empty($dataComisiones)) {
                                                $dbTransaction = $this->Ooam_model->insertComisionOOAM('comisiones_ooam',$dataComisiones);
                                                if($dbTransaction != 1){
                                                    echo (json_encode($dbTransaction));
                                                }
                                            }
                                        }
                                        
                                            $dataPago['id_lote'] = $getInfoLote->idLote;                       
                                            $dataPago['total_comision'] = $generalComisiones; 
                                            $dataPago['abonado'] = 0;                    
                                            $dataPago['porcentaje_abono'] = $porcentajeComision; 
                                            $dataPago['pendiente'] = $generalComisiones;                                
                                            $dataPago['creado_por'] = 1;  
                                            $dataPago['fecha_modificacion'] = date("Y-m-d H:i:s");                             
                                            $dataPago['fecha_abono'] = date("Y-m-d H:i:s");
                                            $dataPago['bandera'] = 0;
                                            $dataPago['ultimo_pago'] = 0;
                                            $dataPago['bonificacion'] = 0; 
                                            $dataPago['fecha_neodata'] = date("Y-m-d H:i:s"); 
                                            $dataPago['new_neo'] = 0; 
                                            $dataPago['monto_anticipo'] = 0; 
                                            $dataPago['numero_dispersion'] = 0; 
                                            $dataPago['ultima_dispersion'] = date("Y-m-d H:i:s"); 
                                            $dataPago['plan_comision'] = 1; 
                                            $dataPago['nombreCliente'] = $dataReturn->nombreCliente;
                                            $dataPago['estatusContratacion'] = $dataReturn->estatusContratacion;
                                            $dataPago['totalLote'] = $dataReturn->totalLote;
                                            
                                            if (isset($dataPago) && !empty($dataPago)) {
                                                $dbTransactionPago = $this->Ooam_model->insertComisionOOAM('pago_ooam',$dataPago);
                                                if($dbTransactionPago != 1){
                                                    echo (json_encode($dbTransactionPago));
                                                } 
                                                }
                                                
                                                if ($dbTransaction&&$dbTransactionPago){ // SUCCESS TRANSACTION
                                                    echo json_encode(array("status" => 1, "message" => "Registro guardado con éxito."), JSON_UNESCAPED_UNICODE);
                                                    header('Content-Type: application/json');
                                                } else{ // ERROR TRANSACTION
                                                    echo json_encode(array("status" => -1, "message" => "Servicio no disponible. El servidor no está listo para manejar la solicitud. Por favor, inténtelo de nuevo más tarde."), JSON_UNESCAPED_UNICODE);
                                                    header('Content-Type: application/json');
                                                }
                                            }
                                        }
                                    }
                                    }
                                } else
                        echo json_encode($checkSingup);
                    }
                }
            }
    }

}