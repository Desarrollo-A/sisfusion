<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class OperacionesPorCatalogo_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    function get_lista_opcs_x_cats_by_77(){
        return $this->db->query("SELECT * FROM opcs_x_cats WHERE id_catalogo = 77 AND estatus = 1");
    }
    
}