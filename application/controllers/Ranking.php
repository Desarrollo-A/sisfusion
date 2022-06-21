<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ranking extends CI_Controller {
	public function __construct() {
		parent::__construct();
        $this->load->model(array('Ranking_model', 'Clientes_model', 'General_model'));
        $this->load->library(array('session','form_validation', 'get_menu', 'Email'));
		$this->load->helper(array('url','form'));
		$this->load->database('default');
        date_default_timezone_set('America/Mexico_City');
        $this->validateSession();
	}

    public function validateSession(){
        if($this->session->userdata('id_usuario')=="" || $this->session->userdata('id_rol')==""){
            redirect(base_url() . "index.php/login");
        }
    }

    public function ranking(){
        $this->load->view("dashboard/ranking/ranking");
    }

    public function getAllRankings(){
        $year = date("Y");
        $general = $this->input->post('general');
        $tipoRanking = $this->input->post('tipoChart');
        $beginDate = $this->input->post("beginDate") != null ? date("Y-m-d", strtotime($this->input->post("beginDate"))) : "$year-01-01";
        $endDate = $this->input->post("endDate") != null ? date("Y-m-d", strtotime($this->input->post("endDate"))) : date("Y-m-d");
        $sede = $this->input->post("sede");
        if ( $general){
            $data['Apartados'] = $this->Ranking_model->getRankingApartados( $beginDate, $endDate, $sede)->result_array();
            $data['Contratados']= ($this->Ranking_model->getRankingContratados( $beginDate, $endDate, $sede )->result_array());
            $data['ConEnganche'] = $this->Ranking_model->getRankingConEnganche( $beginDate, $endDate, $sede )->result_array();
            $data['SinEnganche'] = $this->Ranking_model->getRankingSinEnganche( $beginDate, $endDate, $sede )->result_array();
        }
        else if( $tipoRanking ==  'Apartados' ){
            $data['Apartados']= $this->Ranking_model->getRankingApartados( $beginDate, $endDate, $sede )->result_array();
        }
        else if( $tipoRanking ==  'Contratados' ){
            $data['Contratados']= $this->Ranking_model->getRankingContratados( $beginDate, $endDate, $sede )->result_array();
        }
        else if( $tipoRanking ==  'ConEnganche' ){
            $data['ConEnganche'] = $this->Ranking_model->getRankingConEnganche( $beginDate, $endDate, $sede )->result_array();
        }
        else if( $tipoRanking ==  'SinEnganche' ){
            $data['SinEnganche'] = $this->Ranking_model->getRankingSinEnganche( $beginDate, $endDate, $sede )->result_array();
        }

        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }
}
 
