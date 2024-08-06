<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PlanesPagoModel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getPlanesPagoOriginal($idLote){
        $query = "SELECT * FROM plan_pago_original
        WHERE
            idLote = $idLote
        AND estatus = 1";

        return $this->db->query($query)->result();
    }

    public function getPlanesPago($idLote){
        $query = "SELECT * FROM planes_pago
        WHERE
            idLote = $idLote
        AND estatus = 1";

        return $this->db->query($query)->result();
    }
}

?>