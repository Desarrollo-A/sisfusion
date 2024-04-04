<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class CasasModel extends CI_Model
{
    function __construct(){
        parent::__construct();
    }

    public function getProceso($idProcesoCasas){
        $query = "SELECT
            pc.*,
            lo.nombreLote
        FROM proceso_casas pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        WHERE
            pc.idProcesoCasas = $idProcesoCasas";

        return $this->db->query($query)->row();
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
            lo.idLote,
            lo.nombreLote,
            pc.status
        FROM lotes lo
        LEFT JOIN proceso_casas pc ON pc.idLote = lo.idLote AND pc.status = 1
        WHERE
            lo.idMovimiento = 45
        AND lo.idStatusContratacion = 15
        AND lo.idCondominio = $idCondominio
        AND pc.status IS NULL";

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
            pc.proceso = 0
        AND pc.status = 1";

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

    public function setProcesoToCartaAuth($idProcesoCasas){
        $query = "UPDATE proceso_casas
        SET
            proceso = 1,
            fechaProceso = GETDATE()
        WHERE
            idProcesoCasas = $idProcesoCasas";

        return $this->db->query($query);
    }

    public function getListaCartaAuth(){
        $query = "SELECT
            pc.*,
            lo.nombreLote,
            doc.nombre AS cartaAuth
        FROM proceso_casas pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        LEFT JOIN documentos_proceso_casas doc ON doc.idDocumento = pc.idCartaAuth
        WHERE
            pc.proceso = 1
        AND pc.status = 1";

        return $this->db->query($query)->result();
    }

    public function cancelProcess($idProcesoCasas){
        $query = "UPDATE proceso_casas
        SET
            status = 0
        WHERE
            idProcesoCasas = $idProcesoCasas";

        return $this->db->query($query);
    }

    public function backToAsignacion($idProcesoCasas){
        $query = "UPDATE proceso_casas
        SET
            proceso = 0
        WHERE
            idProcesoCasas = $idProcesoCasas";

        return $this->db->query($query);
    }

    public function addDocumentRow($idProcesoCasas, $nombre, $documento){
        $data = [
            'idProcesoCasas' => $idProcesoCasas,
            'nombre' => $nombre,
            'documento' => $documento,
        ];

        $this->db->insert('documentos_proceso_casas', $data);

        return $this->db->insert_id();
    }

    public function setCartaAuth($idProcesoCasas, $idCartaAuth){
        $query = "UPDATE proceso_casas
        SET
            idCartaAuth = $idCartaAuth
        WHERE
            idProcesoCasas = $idProcesoCasas";

        return $this->db->query($query);
    }

    public function setProcesoToConcentrarAdeudos($idProcesoCasas){
        $query = "UPDATE proceso_casas
        SET
            proceso = 2,
            fechaProceso = GETDATE()
        WHERE
            idProcesoCasas = $idProcesoCasas";

        return $this->db->query($query);
    }

    public function getListaConcentradoAdeudos(){
        $query = "SELECT
            pc.*,
            lo.nombreLote
        FROM proceso_casas pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        WHERE
            pc.proceso = 2
        AND pc.status = 1";

        return $this->db->query($query)->result();
    }

    public function backToCartaAutorizacion($idProcesoCasas){
        $query = "UPDATE proceso_casas
        SET
            proceso = 1,
            fechaProceso = GETDATE()
        WHERE
            idProcesoCasas = $idProcesoCasas";

        return $this->db->query($query);
    }

    public function setProcesoToDocumentacionCliente($idProcesoCasas){
        $query = "UPDATE proceso_casas
        SET
            proceso = 3,
            fechaProceso = GETDATE()
        WHERE
            idProcesoCasas = $idProcesoCasas";

        return $this->db->query($query);
    }
}