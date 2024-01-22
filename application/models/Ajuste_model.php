<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajuste_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function getDatosFechas() {
        $this->db->query("SET LANGUAGE Español;");
        $result = $this->db->query("
            SELECT
                *,
                CONVERT(VARCHAR, fechaInicio, 23) AS fechaInicioSinHora,
                CONVERT(VARCHAR, fechaFinGeneral, 23) AS fechaFinGeneralSinHora,
                CONVERT(VARCHAR, fechaTijuana, 23) AS fechaTijuanaSinHora,
                DATENAME(MONTH, DATEADD(MONTH, MONTH(fechaInicio) - 1, '1900-01-01')) AS nombreMes
            FROM fechasCorte;
        ");
        return $result;
    }

    public function editarFecha($idFechaCorte, $nuevaFechaInicio, $nuevaFechaFinGeneral, $nuevaFechaTijuana) {

        $nuevaFechaInicio = date('Y-m-d 00:00:00.000', strtotime($nuevaFechaInicio));
        $nuevaFechaFinGeneral = date('Y-m-d 13:59:59.000', strtotime($nuevaFechaFinGeneral));
        $nuevaFechaTijuana = date('Y-m-d 15:59:59.000', strtotime($nuevaFechaTijuana));

        $data = array(
            'fechaInicio' => $nuevaFechaInicio,
            'fechaFinGeneral' => $nuevaFechaFinGeneral,
            'fechaTijuana' => $nuevaFechaTijuana
        );
    
        $this->db->where('idFechaCorte', $idFechaCorte);
        $this->db->update('fechasCorte', $data);
    }
    

}