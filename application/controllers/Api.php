<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once './dist/js/jwt/JWT.php';

use Firebase\JWT\JWT;

class Api extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Authorization, X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        date_default_timezone_set('America/Mexico_City');
        $this->load->helper(array('form'));
        $this->load->library(array('jwt_key'));
        $this->load->model('Api_model');
    }

    function Authenticate()
    {
        $JwtSecretKey = $this->jwt_key->getSecretKey();
        $result = $this->Api_model->verifyUser($this->input->post('username'), encriptar($this->input->post('password')));
        $time = time();
        if ($result != "User not found!") {
            $data = array(
                "iat" => $time, // Tiempo en que inició el token
                "exp" => $time + (60 * 60), // Tiempo en el que expirará el token (2 minutos)
                "userData" => $result->usuario,
            );
            $token = JWT::encode($data, $JwtSecretKey);
            echo json_encode(array("id_token" => $token));
        } else {
            echo json_encode(array("timestamp" => $time, "status" => 400, "error" => "Bad request", "exception" => "Error authentication", "message" => "Invalid username or password"));
        }
    }

    function addLeadRecord()
    {
        $time = time();
        $token = apache_request_headers()["Authorization"];
        $JwtSecretKey = $this->jwt_key->getSecretKey();
        $result = JWT::decode($token, $JwtSecretKey, array('HS256'));
        if (in_array($result, array('ALR001', 'ALR003', 'ALR004', 'ALR005', 'ALR006', 'ALR007', 'ALR008', 'ALR009', 'ALR010', 'ALR012', 'ALR013'))) {
            echo json_encode(array("timestamp" => $time, "status" => 503, "error" => "Service Unavailable", "exception" => "Service Unavailable", "message" => "The server is not ready to handle the request. Please try again later."));
        } else if ($result == 'ALR002') {
            echo json_encode(array("timestamp" => $time, "status" => 400, "error" => "Bad request", "exception" => "Wrong number of segments", "message" => "Check the structure of the authorization token sent."));
        } else if ($result == 'ALR011') {
            echo json_encode(array("timestamp" => $time, "status" => 401, "error" => "Unauthorized", "exception" => "Signature verification failed", "message" => "Invalid structure of the authorization token sent."));
        } else if ($result == 'ALR014') {
            echo json_encode(array("timestamp" => $time, "status" => 401, "error" => "Unauthorized", "exception" => "Expired token", "message" => "The lifetime of the sent token has expired."));
        } else {
            if ($_POST['id_usuario'] == '' || $_POST['nombre'] == '' || $_POST['apellido_paterno'] == '' || $_POST['apellido_materno'] == '' || $_POST['correo'] == '' || $_POST['telefono'] == '' || $_POST['medio'] == '') {
                echo json_encode(array("timestamp" => $time, "status" => 400, "error" => "Bad request", "exception" => "Some parameter does not have a specified value.", "message" => "Verify that all parameters contain a specified value."));
            } else {
                $result = $this->Api_model->getAdviserLeaderInformation($_POST['id_usuario']);
                $data = array(
                    "id_sede" => $result->id_sede,
                    "id_asesor" => $_POST['id_usuario'],
                    "id_coordinador" => $result->id_coordinador,
                    "id_gerente" => $result->id_gerente,
                    "personalidad_juridica" => 2,
                    "nombre" => $_POST['nombre'],
                    "apellido_paterno" => $_POST['apellido_paterno'],
                    "apellido_materno" => $_POST['apellido_materno'],
                    "correo" => $_POST['correo'],
                    "telefono" => $_POST['telefono'],
                    "lugar_prospeccion" => 6,
                    "otro_lugar" => "Calixta (" . $_POST['medio'] . ")",
                    "plaza_venta" => $result->id_sede,
                    "fecha_creacion" => date("Y-m-d H:i:s"),
                    "creado_por" => 1,
                    "fecha_modificacion" => date("Y-m-d H:i:s"),
                    "modificado_por" => 1,
                    "fecha_vencimiento" => date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . "+ 30 days"))
                );
                $dbTransaction = $this->Api_model->addRecord("prospectos", $data); // MJ: LLEVA 2 PARÁMETROS $table, $data
                if ($dbTransaction == 1) // SUCCESS TRANSACTION
                    echo json_encode(array("status" => 200, "message" => "Record saved successfully."));
                else // ERROR TRANSACTION
                    echo json_encode(array("timestamp" => $time, "status" => 503, "error" => "Service Unavailable", "exception" => "Service Unavailable", "message" => "The server is not ready to handle the request. Please try again later."));
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

    function validateToken($token)
    {
        $time = time();
        $JwtSecretKey = $this->jwt_key->getSecretKey();
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
                $response = $this->Api_model->addRecord("tokens", $data); // MJ: LLEVA 2 PARÁMETROS $table, $data
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
                "id_usuario" => $result[0]['id_usuario']));
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

}
