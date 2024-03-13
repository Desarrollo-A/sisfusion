<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

use PhpOffice\PhpSpreadsheet\Spreadsheet;


class Bonos extends CI_Controller
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
        $this->load->model('Bonos_model');
        $this->load->library(array('session', 'form_validation', 'get_menu', 'Jwt_actions','permisos_sidebar'));
        $this->load->helper(array('url', 'form'));
        $this->load->database('default');
        $this->jwt_actions->authorize('0202', $_SERVER['HTTP_HOST']);
        $this->validateSession();
        $val =  $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        $_SESSION['rutaController'] = str_replace('' . base_url() . '', '', $val);
        $rutaUrl = substr($_SERVER["REQUEST_URI"],1); //explode($_SESSION['rutaActual'], $_SERVER["REQUEST_URI"]);
        $this->permisos_sidebar->validarPermiso($this->session->userdata('datos'),$rutaUrl,$this->session->userdata('opcionesMenu'));
    
    }

    public function index(){
        redirect(base_url());
    }


    public function validateSession() {
        if ($this->session->userdata('id_usuario') == "" || $this->session->userdata('id_rol') == "")
        redirect(base_url() . "index.php/login");
    }  


    //  incio vistas

    public function bonos_contraloria(){
        $this->load->view('template/header');
        $this->load->view("bonos/bonos_contraloria_view");
    }


    public function bonos_historial()
    {
        $this->load->view('template/header');
        $this->load->view("bonos/bonos_historial_view");
    }


    // fin de vistas
// servicios


    public function getBonos()
    {
        $res["data"] = $this->Bonos_model->getBonos()->result_array();
        echo json_encode($res);
    }
    public function saveBono()
    {
    $user =  $this->input->post("usuarioid");
    $dato = $this->db->query("SELECT id_usuario FROM bonos WHERE id_usuario = $user AND estatus = 1")->result_array();
    if(count($dato) <= 0){

        $pago=str_replace("$", "", $this->input->post("pago"));
        $comas =str_replace(",", "", $pago);
        $monto=str_replace("$", "", $this->input->post("monto"));
        $coma2 =str_replace(",", "", $monto);

        $pago = $comas;
        $monto = $coma2;  
        $pagoCorresp = $coma2 / $this->input->post("numeroP");
        $pagoCorresReal = number_format($pagoCorresp, 2, '.', '');
        $dat =  $this->Bonos_model->insertar_bono($this->input->post("usuarioid"),$this->input->post("roles"),$monto,$this->input->post("numeroP"),$pagoCorresReal,$this->input->post("comentario"),$this->session->userdata('id_usuario') );
        echo json_encode($dat);
    }else{
        $data = 3;
        echo json_encode($data);
    }
    }


    public function getHistorialAbono($id)
    {
        echo json_encode($this->Bonos_model->getHistorialAbono($id)->result_array());
    }



    public function TieneAbonos($id){
        $respuesta = $this->Bonos_model->TieneAbonos($id)->result_array();
        if(count($respuesta) > 0)
        {
            echo json_encode(1);
        }else{
            echo json_encode(0);
        }
    }



    public function InsertAbono()
    { 
        $id_bono = $this->input->post('id_bono');
        $pago = $this->input->post('pago');
        $usuario = $this->input->post('id_usuario');
        $dato = $this->Bonos_model->BonoCerrado($this->input->post('id_bono'))->result_array();
      // echo var_dump($dato);
        if(!empty($dato)){
            $abonado = 0;
            for ($i=0; $i <count($dato) ; $i++) { 
            $abonado = $abonado + $dato[$i]['suma'];
            }
     //     echo $abonado;
            $monto = $dato[0]['monto'];
            $cuantos = count($dato);
            $n_p=($dato[$cuantos -1]['n_p'] +1);
        if($abonado >= $monto -.30 && $abonado <= $monto + .30){

            $row = $this->Bonos_model->UpdateAbono($id_bono);
            $row=2;
            echo json_encode($row);
    
        }else{

        $row = $this->Bonos_model->InsertAbono($id_bono,$usuario,$pago,$this->session->userdata('id_usuario'),$n_p);

        $dato = $this->Bonos_model->BonoCerrado($this->input->post('id_bono'))->result_array();
        $monto = $dato[0]['monto'];
        $abonado = 0;
        for ($i=0; $i <count($dato) ; $i++) { 
        $abonado = $abonado + $dato[$i]['suma'];
        }
        if($abonado >= $monto -.30 && $abonado <= $monto + .30){
            $row = $this->Bonos_model->UpdateAbono($id_bono);
            $row=2;
            //echo json_encode($row);
        }else{
            $row =1;
        }
            echo json_encode($row); 
        }
        }else{
            $row = $this->Bonos_model->InsertAbono($id_bono,$usuario,$pago,$this->session->userdata('id_usuario'),1);
            echo json_encode($row); 
        }
    }


    public function BorrarBono(){
        // echo $this->input->post("id_bono"); 
        $respuesta =  $this->Bonos_model-->BorrarBono($this->input->post("id_bono"));
        echo json_encode($respuesta);
    
        }


    public function getUsuariosRolBonos($rol)
    {
        echo json_encode($this->Bonos_model->getUsuariosRolBonos($rol)->result_array());
    }


    public function getBonosAllUser($a,$b){
        $dat =  $this->Bonos_model->getBonosAllUser($a,$b)->result_array();
        for( $i = 0; $i < count($dat); $i++ ){
            $dat[$i]['pa'] = 0;
        }
    echo json_encode( array( "data" => $dat));
    }

    public function getHistorialAbono2($id)
    {
        echo json_encode($this->Bonos_model->getHistorialAbono2($id)->result_array());
    }
    
// servicios

}


