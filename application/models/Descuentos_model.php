
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Descuentos_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    function lista_estatus_descuentos(){
        return $this->db->query(" SELECT * FROM opcs_x_cats WHERE id_catalogo=23 AND id_opcion in(18,19,20,21,22,23,24,25,26,29,30)");
    }


}