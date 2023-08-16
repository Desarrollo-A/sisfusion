<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once './dist/js/jwt/JWT.php';

use Firebase\JWT\JWT;

class Internomex_consulta extends CI_Controller
{
    public function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Content-Type,Origin, authorization, X-API-KEY');
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->helper(array('form'));
        $this->load->library(array('jwt_key', 'get_menu', 'jwt_actions','permisos_sidebar'));
        $this->load->model(array('Api_model', 'General_model', 'Internomex_model'));
        $val =  $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        $_SESSION['rutaController'] = str_replace('' . base_url() . '', '', $val);
        $rutaUrl = explode($_SESSION['rutaActual'], $_SERVER["REQUEST_URI"]);
        $this->permisos_sidebar->validarPermiso($this->session->userdata('datos'),$rutaUrl[1],$this->session->userdata('opcionesMenu'));
    }

    function authenticate()
    {
        $data = json_decode(file_get_contents("php://input"));
        if (!isset($data->username) || !isset($data->password))// contraseña antes de ser encriptada: I2503^831NQqHWxr, usuario : ojqd58DY3@
            echo json_encode(array("status" => 400, "message" => "Algún parámetro no viene informado."), JSON_UNESCAPED_UNICODE);
        else {
            if ($data->username == "" || $data->password == "")
                echo json_encode(array("status" => 400, "message" => "Algún parámetro no tiene un valor especificado."), JSON_UNESCAPED_UNICODE);
            else {
                //$JwtSecretKey = $this->jwt_actions->getSecretKey('9860');
                //$result = $this->Api_model->verifyUser($data->username, encriptar($data->password));
                $time = time();
                $result = true;
                if ($result != false) { // MJ: SE ENCONTRÓ REGISTRO DE USUARIO ACTIVO
                    $data = array(
                        "iat" => $time, // Tiempo en que inició el token
                        "exp" => $time + (24 * 60 * 60), // Tiempo en el que expirará el token (24 horas)
                        //"data" => array("id" => $result->id_eu, "username" => $result->usuario, "descripcion" => $result->descripcion),
                        "data" => array("username" => "aQec6TVjo6cHLqb2c0P6lw==", "password" => "MsxRmMdCqRLMLE3varV8Qw=="),
                    );
                    $token = JWT::encode($data, 'vZ6ZlvUJY0J7Kf/UdXt8yw==');
                    echo json_encode(array("id_token" => $token));
                } else
                    echo json_encode(array("status" => 403, "message" => "Usuario o contraseña inválido."), JSON_UNESCAPED_UNICODE);
            }
        }
    }

    function addLeadRecord()
    {
        if (!isset(apache_request_headers()["Authorization"]))
            echo json_encode(array("status" => 400, "message" => "La petición no cuenta con el encabezado Authorization."), JSON_UNESCAPED_UNICODE);
        else {
            if (apache_request_headers()["Authorization"] == "")
                echo json_encode(array("status" => 400, "message" => "Token no especificado dentro del encabezado Authorization."), JSON_UNESCAPED_UNICODE);
            else {
                $token = apache_request_headers()["Authorization"];
                $JwtSecretKey = $this->jwt_actions->getSecretKey(8134);
                $valida_token = json_decode($this->validateToken($token, 8134));
                if ($valida_token->status !== 200){
                    echo json_encode($valida_token);
                }else {
                    $result = JWT::decode($token, $JwtSecretKey, array('HS256'));
                    $valida_token = Null;
                    foreach ($result->data as $key => $value) {
                        if(($key == "username" || $key == "password") && (is_null($value) || str_replace(" ","",$value) == '' || empty($value)))
                            $valida_token = false;
                    }
                    if(is_null($valida_token))
                        $valida_token = true;
                    if(!empty($result->data) && $valida_token){
                        $checkSingup = $this->jwt_actions->validateUserPass($result->data->username, $result->data->password);
                    }else{
                        $checkSingup = null;
                        echo json_encode(array("status" => 400, "message" => "Algún parámetro (usuario y/o contraseña) no vienen informados. Verifique que ambos parámetros sean incluidos."), JSON_UNESCAPED_UNICODE);
                    }
                    if(!empty($checkSingup) && json_decode($checkSingup)->status == 200){
                        $data = json_decode(file_get_contents("php://input"));
                        if(!isset($data->empresa) || $data->empresa === ''){
                            echo json_encode(array("status" => 400, "message" => "Algún parámetro (usuario y/o contraseña) no vienen informados. Verifique que ambos parámetros sean incluidos."), JSON_UNESCAPED_UNICODE);
                        }else{
                            $result = $this->Internomex_model->getInformacionR($data->empresa);

                            foreach ($result as &$fila) {
                                foreach ($fila as $clave => &$valor) {
                                    if (is_null($valor)) {
                                        $valor = 0;
                                    }
                                }
                            }
                            
                            unset($fila, $valor);
                        }
                        
                        if (count($result) != 0) // SUCCESS TRANSACTION
                            echo json_encode($result);
                        else // ERROR TRANSACTION
                            echo json_encode(array("status" => 503,
                                                   "message" => "Servicio no disponible. El servidor no está listo para manejar la solicitud.
                                                                 Por favor, inténtelo de nuevo más tarde."),
                                                    JSON_UNESCAPED_UNICODE);
                    }else{
                        echo json_encode($checkSingup);
                    }
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
                $data = array("token" => $token, "para" => $this->input->post("id_asesor"), "estatus" => 1, "creado_por" => $this->input->post("id_gerente"), "fecha_creacion" => date("Y-m-d H:i:s"), "nombre_archivo" => $documentName);
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

}
