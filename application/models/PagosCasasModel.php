<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class PagosCasasModel extends CI_Model
{
    function __construct(){
        parent::__construct();

        $this->load->library(['session']);
    }

    public function getListaIniciarProceso(){
        $query = "SELECT
            pc.*,
            lo.nombreLote
        FROM proceso_casas pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        WHERE
            pc.proceso = 16
        AND pc.status = 1
        AND pc.finalizado = 1";

        return $this->db->query($query)->result();
    }
}