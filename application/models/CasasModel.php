<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class CasasModel extends CI_Model
{
    function __construct(){
        parent::__construct();

        $this->load->library(['session']);
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

    public function getDocumentosCartaAuth(){
        $query = "SELECT
            id_opcion AS tipo,
            nombre
        FROM opcs_x_cats
        WHERE
            id_catalogo = 118
        AND estatus = 1
        AND id_opcion IN (1)";

        return $this->db->query($query)->row();
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
            doc.archivo,
            doc.documento,
            doc.idDocumento
        FROM proceso_casas pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        LEFT JOIN documentos_proceso_casas doc ON doc.idProcesoCasas = pc.idProcesoCasas AND tipo = 1
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

    public function updateDocumentRow($idDocumento, $archivo){
        $idModificacion = $this->session->userdata('id_usuario');

        $query = "UPDATE documentos_proceso_casas
        SET
            archivo = '$archivo',
            fechaModificacion = GETDATE(),
            idModificacion = $idModificacion
        WHERE
            idDocumento = $idDocumento";

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

    public function getDocumentosCliente(){
        $query = "SELECT
            id_opcion AS tipo,
            nombre
        FROM opcs_x_cats 
        WHERE
            id_catalogo = 118
        AND estatus = 1
        AND id_opcion IN (2,3,4,5,6,7,8,9,10,11,12,13,14,15)";

        return $this->db->query($query)->result();
    }

    public function inserDocumentsToProceso($idProcesoCasas, $tipo, $documento){
        $idCreacion = $this->session->userdata('id_usuario');

        $query = "BEGIN
            IF NOT EXISTS (SELECT * FROM documentos_proceso_casas 
                           WHERE tipo = $tipo
                           AND idProcesoCasas = $idProcesoCasas)
            BEGIN
                INSERT INTO documentos_proceso_casas (idProcesoCasas, tipo, documento, idCreacion)
                VALUES ($idProcesoCasas, $tipo, '$documento', $idCreacion)
            END
        END";

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

    public function getListaProcesoDocumentos(){
        $query = "SELECT
            pc.*,
            lo.nombreLote,
            doc.documentos
        FROM proceso_casas pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        LEFT JOIN (SELECT COUNT(*) AS documentos, idProcesoCasas FROM documentos_proceso_casas WHERE tipo IN (2,3,4,5,6,7,8,10,11,12,13,14,15) AND archivo IS NOT NULL GROUP BY idProcesoCasas) doc ON doc.idProcesoCasas = pc.idProcesoCasas
        WHERE
            pc.proceso = 3
        AND pc.status = 1";

        return $this->db->query($query)->result();
    }

    public function backToAdeudos($idProcesoCasas){
        $query = "UPDATE proceso_casas
        SET
            proceso = 2,
            fechaProceso = GETDATE()
        WHERE
            idProcesoCasas = $idProcesoCasas";

        return $this->db->query($query);
    }

    public function getListaDocumentosCliente($idProcesoCasas){
        $query = "SELECT
            idProcesoCasas,
            idDocumento,
            archivo,
            documento,
            tipo,
            fechaModificacion
        FROM documentos_proceso_casas
        WHERE
            idProcesoCasas = $idProcesoCasas
        AND tipo IN (2,3,4,5,6,7,8,9,10,11,12,13,14,15)";

        return $this->db->query($query)->result();
    }

    public function getListaProyectoEjecutivo(){
        $query = "SELECT
            pc.*,
            lo.nombreLote,
            doc.documentos
        FROM proceso_casas pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        LEFT JOIN (SELECT COUNT(*) AS documentos, idProcesoCasas FROM documentos_proceso_casas WHERE tipo IN (13,14,15) AND archivo IS NOT NULL GROUP BY idProcesoCasas) doc ON doc.idProcesoCasas = pc.idProcesoCasas
        WHERE
            pc.proceso = 3
        AND pc.status = 1";

        return $this->db->query($query)->result();
    }

    public function getListaDocumentosProyectoEjecutivo($idProcesoCasas){
        $query = "SELECT
            idProcesoCasas,
            idDocumento,
            archivo,
            documento,
            fechaModificacion
        FROM documentos_proceso_casas
        WHERE
            idProcesoCasas = $idProcesoCasas
        AND tipo IN (13,14,15)";

        return $this->db->query($query)->result();
    }

    public function setProcesoToValidaComite($idProcesoCasas){
        $query = "UPDATE proceso_casas
        SET
            proceso = 4,
            fechaProceso = GETDATE()
        WHERE
            idProcesoCasas = $idProcesoCasas";

        return $this->db->query($query);
    }

    public function getDocumentoAnexosTecnicos(){
        $query = "SELECT
            id_opcion AS tipo,
            nombre
        FROM opcs_x_cats
        WHERE
            id_catalogo = 118
        AND estatus = 1
        AND id_opcion IN (16)";

        return $this->db->query($query)->row();
    }

    public function getListaValidaComite(){
        $query = "SELECT
            pc.*,
            lo.nombreLote,
            doc.documentos
        FROM proceso_casas pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        LEFT JOIN (SELECT COUNT(*) AS documentos, idProcesoCasas FROM documentos_proceso_casas WHERE tipo IN (16) AND archivo IS NOT NULL GROUP BY idProcesoCasas) doc ON doc.idProcesoCasas = pc.idProcesoCasas
        WHERE
            pc.proceso = 4
        AND pc.status = 1";

        return $this->db->query($query)->result();
    }

    public function backToDocumentos($idProcesoCasas){
        $query = "UPDATE proceso_casas
        SET
            proceso = 3,
            fechaProceso = GETDATE()
        WHERE
            idProcesoCasas = $idProcesoCasas";

        return $this->db->query($query);
    }

    public function getListaDocumentosComiteEjecutivo($idProcesoCasas){
        $query = "SELECT
            idProcesoCasas,
            idDocumento,
            archivo,
            documento,
            tipo,
            fechaModificacion
        FROM documentos_proceso_casas
        WHERE
            idProcesoCasas = $idProcesoCasas
        AND tipo IN (13,14,15,16)";

        return $this->db->query($query)->result();
    }

    public function getDocumentoTitulacion(){
        $query = "SELECT
            id_opcion AS tipo,
            nombre
        FROM opcs_x_cats
        WHERE
            id_catalogo = 118
        AND estatus = 1
        AND id_opcion IN (17)";

        return $this->db->query($query)->row();
    }

    public function setProcesoToTitulacion($idProcesoCasas){
        $query = "UPDATE proceso_casas
        SET
            proceso = 5,
            fechaProceso = GETDATE()
        WHERE
            idProcesoCasas = $idProcesoCasas";

        return $this->db->query($query);
    }
}