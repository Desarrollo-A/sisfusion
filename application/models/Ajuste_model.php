<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajuste_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function getDatosFechas(){

        return $this->db->query("SELECT
        *,
        CONVERT(VARCHAR, fechaInicio, 23) AS fechaInicioSinHora,
        CONVERT(VARCHAR, fechaFinGeneral, 23) AS fechaFinGeneralSinHora,
        CONVERT(VARCHAR, fechaTijuana, 23) AS fechaTijuanaSinHora,
        CASE
            WHEN mes = 1 THEN 'Enero'
            WHEN mes = 2 THEN 'Febrero'
            WHEN mes = 3 THEN 'Marzo'
            WHEN mes = 4 THEN 'Abril'
            WHEN mes = 5 THEN 'Mayo'
            WHEN mes = 6 THEN 'Junio'
            WHEN mes = 7 THEN 'Julio'
            WHEN mes = 8 THEN 'Agosto'
            WHEN mes = 9 THEN 'Septiembre'
            WHEN mes = 10 THEN 'Octubre'
            WHEN mes = 11 THEN 'Noviembre'
            WHEN mes = 12 THEN 'Diciembre'
        END AS nombreMes
    FROM fechasCorte;");
    }

    public function editarFecha($idFechaCorte, $nuevaFechaInicio, $nuevaFechaFinGeneral, $nuevaFechaTijuana) {
        $data = array(
            'fechaInicio' => $nuevaFechaInicio,
            'fechaFinGeneral' => $nuevaFechaFinGeneral,
            'fechaTijuana' => $nuevaFechaTijuana
        );
    
        $this->db->where('idFechaCorte', $idFechaCorte);
        $this->db->update('fechasCorte', $data);
    }
    

}