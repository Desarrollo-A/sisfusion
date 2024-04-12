<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;


class ScheduleTasks_Universidad extends CI_Controller
{

    public function __construct(){
        parent::__construct();
        $this->load->library(array('session', 'form_validation'));
        $this->load->helper(array('url', 'form'));
        $this->load->database('default');
        $this->load->library('email');
        $this->load->model('Comisiones_model');
    }

    public function index(){
        redirect(base_url());
    }


    function descuentos_universidad(){
        ini_set('max_execution_time', 99999999999);
        set_time_limit(99999999999);
        ini_set('memory_limit','10240M');
        $hoy = date("Y-m-d");
        $arrayCorreo = array();
        $arrayDatosCorreo = array();

        /*CONSULTAMOS LOS PRÉSTAMOS*/
        $data = $this->db->query("SELECT * FROM vista_Descuentos_Universidad")->result_array();

    for ($contador_de_consulta = 0; $contador_de_consulta <count($data); $contador_de_consulta++){
        if($data[$contador_de_consulta]['estatus'] == 2 ){

        }else{
            if($data[$contador_de_consulta]['saldo_comisiones'] >= $data[$contador_de_consulta]['pago_individual']){
                if( ($data[$contador_de_consulta]['fecha_creacion'] >= $data[$contador_de_consulta]['fecha_3meses']) 
                &&  ($data[$contador_de_consulta]['estatus'] == 1 || $data[$contador_de_consulta]['banderaReactivado'] == 1)
                &&  ($data[$contador_de_consulta]['pendiente'] > 1 )
                &&  ($data[$contador_de_consulta]['estado_usuario'] == 1)){
                    // aqui va la comparacion de la fecha cuando se genera nuevo 
                    
                }   else{
                    // aqui entra cuando si puede realizarse el descuento
                    $valor = ($data[$contador_de_consulta]['saldo_comisiones']/$data[$contador_de_consulta]['pago_individual']);
                    $pendiente = ($data[$contador_de_consulta]['pendiente']/$data[$contador_de_consulta]['pago_individual']);
                    $pagosDescontar = $valor>$pendiente ? $pendiente : $valor*$data[$contador_de_consulta]['pago_individual'];



                    
                    // echo ($pagosDescontar);
                    echo json_encode($data[$contador_de_consulta] );
                }
                
                
            } //llave para saldo de comisione >= pago_individual 
        }   //llave para el else estatus 2
    }


}

}