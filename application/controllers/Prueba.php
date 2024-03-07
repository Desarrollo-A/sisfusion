<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);


class Prueba extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library(array('session', 'form_validation', 'Jwt_actions', 'get_menu'));
        $this->load->helper(array('url', 'form'));
        $this->load->database('default');
        $this->jwt_actions->authorize('1561', $_SERVER['HTTP_HOST']);
		date_default_timezone_set('America/Mexico_City');
		$val =  $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        $_SESSION['rutaController'] = str_replace('' . base_url() . '', '', $val);
		$rutaUrl = substr($_SERVER["REQUEST_URI"],1);
    }

    public function Prueba(){
        echo 'Ahhhhh';
    }
    
    public function index() {
        echo 'ora';
    }
}