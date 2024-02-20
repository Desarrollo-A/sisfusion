<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class PlanesModel extends CI_Model{

    function __construct(){
        parent::__construct();
    }

    public function getPlanesComision(){
        $query = "SELECT
            idPlan,
            nombre,
            fechaActualizado,
            prioridad,
            estatus
        FROM planes_comision
        ORDER BY prioridad";

        return $this->db->query($query)->result_array();
    }

}