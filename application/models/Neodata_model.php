<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Neodata_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function getCondominio($nombre_condominio){
        $query = $this->db->query("SELECT idCondominio FROM condominios WHERE nombre_condominio = $nombre_condominio");

        return $query->result_array();

    }

}
