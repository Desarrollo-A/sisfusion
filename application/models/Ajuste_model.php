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



    function autorizaciones(){
        $cmd = "SELECT CONCAT(u.nombre,' ' ,u.apellido_paterno,' ',u.apellido_materno) AS colaborador,
        ac.id_autorizacion, ac.id_usuario, 
        ac.bandera, ac.fecha_modificacion, ac.bandera
         FROM  autorizacionesCorte ac, usuarios u
        where u.id_usuario = ac.id_usuario";
        return $this->db->query ($cmd );
    }

    public function addEditarAutorizacion($idFechaCorte, $nuevaFechaInicio, $nuevaFechaFinGeneral, $nuevaFechaTijuana) {
        $data = array(
            'fechaInicio' => $nuevaFechaInicio,
            'fechaFinGeneral' => $nuevaFechaFinGeneral,
            'fechaTijuana' => $nuevaFechaTijuana
        );
    
        $this->db->where('idFechaCorte', $idFechaCorte);
        $this->db->update('fechasCorte', $data);
    }
    public function editarAutorizacion($bandera , $data) {
        try {
    
            $this->db->where('id_autorizacion', $bandera);
            if( $this->db->update('autorizacionesCorte', $data))
            {
                return TRUE;
            }else{
                return FALSE;
            }       
        }
        catch(Exception $e) {
            return $e->getMessage();
        }     
    }

    public function getanios(){
        $cmd = "SELECT * FROM opcs_x_cats WHERE id_catalogo = 115";
        return $this->db->query ($cmd );
    }
}