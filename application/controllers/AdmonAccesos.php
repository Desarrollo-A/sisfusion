<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class AdmonAccesos extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model(array('AdmonAccesos_model', 'General_model'));
        $this->load->library(array('session', 'form_validation', 'Jwt_actions', 'get_menu'));
        $this->load->helper(array('url', 'form'));
        $this->load->database('default');
    }

    public function index() {}

    function base64url_encode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
        
    function base64url_decode($data) {
      return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }
      
    /* Contraseña que se compartirá a los sistemas para la desencriptación de las url */
    //define('ENCRYPTION_KEY', 'P4$$_Cr4d3nc14135CM#');
    function encryptCreds($string = null, $salt = null) { // this is an unique salt per entry and directly stored within a password
        $string ='{"param_user":"ANA.CASTILLO","param_pass":"CASTILLO21","vigencia":"2023-05-18 21:46:42.000"}';
        if($salt === null)
            $salt = hash('sha256', uniqid(mt_rand(), true));
        echo base64_encode(openssl_encrypt($string, 'AES-256-CBC', 'P4$$_Cr4d3nc14135CM#', 0, str_pad(substr($salt, 0, 16), 16, '0', STR_PAD_LEFT))).':'.$salt;
    }

    function decryptCreds($string = null) {
        //$string = "b25EUFlJQWYxWUlLSDBpQXpURGQ3R3hFT3FDeGJSYTJud2N6YmNDdjc2OFoxcStIUGl4K2RZTDhEYVlkY1ZRaS81c1lnUXdkV2tpY0Q2c0JJZXNTMVJNWUZxTDJYZDhaRWNZbWFmbzNWcXRCVmdaS2FwbVVSNW5VMzZ2Y25zT2g=:eaab8b381959b784becf0d12024d9e10ac7ba2edffbc5107cb54296f9e2e13ed";
        if( count(explode(':', $string)) !== 2 )
            return $string;
        $salt = explode(":",$string)[1]; $string = explode(":",$string)[0]; // read salt from entry
        return openssl_decrypt(base64_decode($string), 'AES-256-CBC', 'P4$$_Cr4d3nc14135CM#', 0, str_pad(substr($salt, 0, 16), 16, '0', STR_PAD_LEFT));
    }

    public function validateUserAccess() {
        $token = file_get_contents("php://input");
        if ($token == '')
            echo json_encode(array("status" => -1, "msj" => "No existe un token."), JSON_UNESCAPED_UNICODE);
        else {
            $data = json_decode($this->decryptCreds($token));
            if (!isset($data->param_user) || !isset($data->param_pass))
                echo json_encode(array("status" => -1, "msj" => "Algún parámetro no viene informado. Verifique que todos los parámetros requeridos se incluyan en la petición."), JSON_UNESCAPED_UNICODE);
            else {
                if ($data->param_user == '' || $data->param_pass == '')
                    echo json_encode(array("status" => -1, "msj" => "Algún parámetro no tiene un valor especificado. Verifique que todos los parámetros contengan un valor especificado."), JSON_UNESCAPED_UNICODE);
                else {
                    $result = $this->AdmonAccesos_model->getUserInformation($data->param_user, encriptar($data->param_pass));
                    if (!isset($result->id_usuario))
                        echo json_encode(array("status" => -1, "msj" => "No se logró autenticar el usuario."), JSON_UNESCAPED_UNICODE);
                    else
                        echo json_encode(array("status" => 1, "msj" => "Autenticado exitosamente."), JSON_UNESCAPED_UNICODE);
                }
            }
        }
    }

}