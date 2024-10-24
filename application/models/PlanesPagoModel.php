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

    public function savePlanPago($idPlanPago, $dumpPlan){
        $query = "UPDATE planes_pago
        SET
            dumpPlan = '$dumpPlan'
        WHERE
            idPlanPago = $idPlanPago";

        return $this->db->query($query);
    }

    public function insertDeposito($deposito){
        $query = "INSERT INTO depositos_planes_pago
        (
            idLote,
            fechaDeposito,
            montoDeposito,
            folioNeodata
        ) VALUES (
            $deposito->idLote,
            '$deposito->fechaDeposito',
            $deposito->montoDeposito,
            $deposito->folioNeodata
        )";

        return $this->db->query($query);
    }
}

?>