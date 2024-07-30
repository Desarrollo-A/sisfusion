<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ComisionesNeo extends CI_Controller{

    private $gph;
    public function __construct(){
        parent::__construct();
        $this->load->model('ComisionesNeo_model');
        $this->load->model('asesor/Asesor_model');
        $this->load->library(array('session', 'form_validation'));
        $this->load->helper(array('url', 'form'));
        $this->load->database('default');
        $this->gphsis = $this->load->database('GPHSIS', TRUE);
        $this->programacion = $this->load->database('programacion', TRUE);
    }

    public function index(){
        redirect(base_url());
    }

    public function getStatusNeodata($lote){
        echo json_encode($this->ComisionesNeo_model->getStatusNeodata($lote)->result_array(),JSON_NUMERIC_CHECK);
    }

    public function getGeneralStatusFromNeodataAdmon(){
        $datos = $this->ComisionesNeo_model->getLotesAAA();
        if(COUNT($datos) > 0){
            $data = array();
            for($i = 0; $i < COUNT($datos); $i++){
                $data[$i] = $this->ComisionesNeo_model->getGeneralStatusFromNeodata($datos[$i]['referencia'], $datos[$i]['idResidencial']);
                if($data[$i]->Aplicado == '0.00'){
                    echo $datos[$i]['idLote'].',<br>';
                }
            }
        }
        else{
            echo json_encode(array("data" => ''));
        }
    }

    public function getGeneralStatusFromNeodata($proyecto, $condominio){
        $datos = $this->ComisionesNeo_model->getLotesByAdviser($proyecto, $condominio);
        if(COUNT($datos) > 0){
            $data = array();
            $final_data = array();
            $contador = 0;
            for($i = 0; $i < COUNT($datos); $i++){
                $data[$i] = $this->ComisionesNeo_model->getGeneralStatusFromNeodata($datos[$i]['referencia'], $datos[$i]['idResidencial']);
                    $final_data[$contador] = $this->ComisionesNeo_model->getLoteInformation($datos[$i]['idLote']);
                    $final_data[$contador]->reason = $data[$i]->Marca;
                    $contador ++;
            }
            if (COUNT($final_data) > 0) {
                echo json_encode(array("data" => $final_data));
            } else {
                echo json_encode(array("data" => ''));
            }
        }
        else{
            echo json_encode(array("data" => ''));
        }
    }
}
