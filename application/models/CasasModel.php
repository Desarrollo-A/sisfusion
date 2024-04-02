<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class CasasModel extends CI_Model
{
    function __construct(){
        parent::__construct();
    }

    public function getResidencialesOptions(){
        $query = "SELECT
            CONCAT(nombreResidencial, ' - ', UPPER(CONVERT(VARCHAR(50), descripcion))) AS label,
            idResidencial AS value
        FROM residenciales
        WHERE
            status = 1";

        return $this->db->query($query)->result();
    }

    public function getCondominiosOptions($idResidencial){
        $query = "SELECT
            nombre AS label,
            idCondominio AS value
        FROM condominios
        WHERE
            status = 1
        AND idResidencial = $idResidencial";

        return $this->db->query($query)->result();
    }

    public function getCarteraLotes($idCondominio){
        $query = "SELECT
            idLote,
            nombreLote
        FROM lotes
        WHERE
            idMovimiento = 45
        AND idStatusContratacion = 15
        AND idCondominio = $idCondominio";

        return $this->db->query($query)->result();
    }

    public function getListaAsignacion(){
        $query = "SELECT
            pc.*,
            lo.nombreLote,
            us.nombre as nombreAsesor
        FROM proceso_casas pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        LEFT JOIN usuarios us ON us.id_usuario = pc.idAsesor
        WHERE
            pc.proceso = 0";

        return $this->db->query($query)->result();
    }

    public function addLoteToAsignacion($idLote){
        $query = "INSERT INTO proceso_casas
        (idLote)
        VALUES
        ($idLote)";

        return $this->db->query($query);
    }

    public function getAsesoresOptions(){
        $query = "SELECT
            nombre AS label,
            id_usuario AS value
        FROM usuarios
        WHERE
            estatus = 1
        AND id_rol = 7";

        return $this->db->query($query)->result();
    }

    public function asignarAsesor($idProcesoCasas, $idAsesor){
        $query = "UPDATE proceso_casas
        SET
            idAsesor = $idAsesor
        WHERE
            idProcesoCasas = $idProcesoCasas";

        return $this->db->query($query);
    }
}