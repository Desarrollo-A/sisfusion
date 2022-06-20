<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ranking_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function getRankingApartados($beginDate, $endDate){
        ini_set('max_execution_time', 300);
        set_time_limit(300);
        return $this->db->query("SELECT id_usuario, nombre, apellido_paterno, apellido_materno, telefono, correo, usuario FROM usuarios");
    }

    public function getRankingContratados($beginDate, $endDate){
        ini_set('max_execution_time', 300);
        set_time_limit(300);
        return $this->db->query("SELECT id_usuario, nombre, apellido_paterno, apellido_materno, telefono, correo, usuario FROM usuarios");
    }

    public function getRankingConEnganche($beginDate, $endDate){
        ini_set('max_execution_time', 300);
        set_time_limit(300);
        return  $this->db->query("SELECT id_usuario, nombre, apellido_paterno, apellido_materno, telefono FROM usuarios");
    }

    public function getRankingSinEnganche($beginDate, $endDate){
        ini_set('max_execution_time', 300);
        set_time_limit(300);
        return  $this->db->query("SELECT id_usuario, nombre, apellido_paterno, apellido_materno, telefono FROM usuarios");
    }
}
