<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once './dist/js/jwt/JWT.php';

use Firebase\JWT\JWT;

class GenerateToken extends CI_Controller
{

    public function __construct()
    {
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Headers: Content-Type,Origin, authorization, X-API-KEY');
            parent::__construct();
            date_default_timezone_set('America/Mexico_City');
            $this->load->helper(array('form'));
            $this->load->library(array('jwt_actions'));
    }

    public function generate($controller){
        // $data = json_decode(file_get_contents("php://input"));
        if (!isset($controller))
            echo json_encode(array("status" => 400, "message" => "Algún parámetro no viene informado."), JSON_UNESCAPED_UNICODE);
        else {
            $JwtSecretKey = $this->jwt_actions->getSecretKey($controller);
            $time = time();
            $data = array(
                "iat" => $time, // Tiempo en que inició el token
                "exp" => $time + (24 * 60 * 60), // Tiempo en el que expirará el token (24 horas)
                "data" => array("id_rol" => "1", "id_usuario" => "1", "id" => "", "username" => "suma_outs_9346", "descripcion" => ""),
            );
            $token = JWT::encode($data, $JwtSecretKey);
            echo json_encode(array("id_token" => $token));
        }
    }
}