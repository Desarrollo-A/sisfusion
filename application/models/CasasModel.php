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

    public function getAsesor($id){
        $query = "SELECT TOP 1
            nombre AS nombre,
            id_usuario AS idUsuario
        FROM usuarios
        WHERE
            id_usuario = $id";

        return $this->db->query($query)->row();
    }

    public function setProcesoTo($idProcesoCasas, $proceso){
        $idModificacion = $this->session->userdata('id_usuario');

        $query = "UPDATE proceso_casas
        SET
            proceso = $proceso,
            fechaProceso = GETDATE(),
            fechaModificacion = GETDATE(),
            idModificacion = $idModificacion
        WHERE
            idProcesoCasas = $idProcesoCasas";

        return $this->db->query($query);
    }

    public function addHistorial($idProcesoCasas, $procesoAnterior, $procesoNuevo, $descripcion){
        $idMovimiento = $this->session->userdata('id_usuario');

        $query = "INSERT INTO historial_proceso_casas
        (
            idProcesoCasas,
            procesoAnterior,
            procesoNuevo,
            idMovimiento,
            descripcion
        )
        VALUES
        (
            $idProcesoCasas,
            $procesoAnterior,
            $procesoNuevo,
            $idMovimiento,
            '$descripcion'
        )";

        return $this->db->query($query);
    }

    public function getDocumentos($docs){
        $documents = implode(",", $docs);

        $query = "SELECT
            id_opcion AS tipo,
            nombre
        FROM opcs_x_cats
        WHERE
            id_catalogo = 118
        AND estatus = 1
        AND id_opcion IN ($documents)";

        return $this->db->query($query)->result();
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
        (
            idLote
        )
        VALUES
        (
            $idLote
        )";

        $result = $this->db->query($query);

        if($result){
            $query = "SELECT TOP 1 * FROM proceso_casas ORDER BY idProcesoCasas DESC";
            return $this->db->query($query)->row();
        }else{
            return null;
        }
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

    public function getNotariasOptions(){
        $query = "SELECT
            nombre AS label,
            id_usuario AS value
        FROM usuarios
        WHERE
            estatus = 1
        AND id_rol = 7";

        return $this->db->query($query)->result();
    }

    public function getPropuestasOptions($idProcesoCasas){
        $query = "SELECT
            fechaFirma AS label,
            idPropuesta AS value
        FROM propuestas_proceso_casas
        WHERE
            idProcesoCasas = $idProcesoCasas";

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

    public function getListaCargaTitulos(){
        $query = "SELECT
            pc.*,
            lo.nombreLote,
            doc.archivo,
            doc.documento,
            doc.idDocumento
        FROM proceso_casas pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        LEFT JOIN documentos_proceso_casas doc ON doc.idProcesoCasas = pc.idProcesoCasas AND tipo = 17
        WHERE
            pc.proceso = 5
        AND pc.status = 1";

        return $this->db->query($query)->result();
    }

    public function getListaEleccionPropuestas(){
        $query = "SELECT
            pc.*,
            lo.nombreLote,
            doc.archivo,
            doc.documento,
            doc.idDocumento,
            pro.idPropuesta,
            pro.notaria,
            pro.fechaFirma,
            pro.costo
        FROM proceso_casas pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        LEFT JOIN documentos_proceso_casas doc ON doc.idProcesoCasas = pc.idProcesoCasas AND tipo = 18
        LEFT JOIN propuestas_proceso_casas pro ON pro.idPropuesta = pc.idPropuesta AND pro.status = 1
        WHERE
            pc.proceso = 6
        AND pc.status = 1";

        return $this->db->query($query)->result();
    }

    public function setProcesoToValidacionContraloria($idProcesoCasas){
        $query = "UPDATE proceso_casas
        SET
            proceso = 7,
            fechaProceso = GETDATE()
        WHERE
            idProcesoCasas = $idProcesoCasas";

        return $this->db->query($query);
    }

    public function getListaPropuestaFirma(){
        $query = "SELECT
            pc.*,
            lo.nombreLote,
            pro.idPropuesta,
            pro.notaria,
            pro.fechaFirma,
            pro.costo
        FROM proceso_casas pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        LEFT JOIN propuestas_proceso_casas pro ON pro.idPropuesta = pc.idPropuesta AND pro.status = 1
        WHERE
            pc.proceso > 6
        AND pc.proceso < 8
        AND pc.status = 1";

        return $this->db->query($query)->result();
    }

    public function getListaValidaContraloria(){
        $query = "SELECT
            pc.*,
            lo.nombreLote
        FROM proceso_casas pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        WHERE
            pc.proceso = 7
        AND pc.status = 1";

        return $this->db->query($query)->result();
    }

    public function getListaDocumentosValidaContraloria($idProcesoCasas){
        $query = "SELECT
            idProcesoCasas,
            idDocumento,
            archivo,
            documento,
            tipo,
            fechaModificacion
        FROM documentos_proceso_casas
        WHERE
            idProcesoCasas = $idProcesoCasas";

        return $this->db->query($query)->result();
    }

    public function setProcesoToSolicitudContratos($idProcesoCasas){
        $query = "UPDATE proceso_casas
        SET
            proceso = 8,
            fechaProceso = GETDATE()
        WHERE
            idProcesoCasas = $idProcesoCasas";

        return $this->db->query($query);
    }

    public function getListaSolicitarContratos(){
        $query = "SELECT
            pc.*,
            lo.nombreLote,
            doc.documentos
        FROM proceso_casas pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        LEFT JOIN (SELECT COUNT(*) AS documentos, idProcesoCasas FROM documentos_proceso_casas WHERE tipo IN (19,20,21,22) AND archivo IS NOT NULL GROUP BY idProcesoCasas) doc ON doc.idProcesoCasas = pc.idProcesoCasas
        WHERE
            pc.proceso = 8
        AND pc.status = 1";

        return $this->db->query($query)->result();
    }

    public function getListaContratos($idProcesoCasas){
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
        AND tipo IN (19,20,21,22,23,24)";

        return $this->db->query($query)->result();
    }

    public function getListaRecepcionContratos(){
        $query = "SELECT
            pc.*,
            lo.nombreLote
        FROM proceso_casas pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        WHERE
            pc.proceso IN (8,9)
        AND pc.status = 1";

        return $this->db->query($query)->result();
    }

    public function getListaCierreCifras(){
        $query = "SELECT
            pc.*,
            lo.nombreLote,
            doc.archivo,
            doc.documento,
            doc.idDocumento
        FROM proceso_casas pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        LEFT JOIN documentos_proceso_casas doc ON doc.idProcesoCasas = pc.idProcesoCasas AND tipo = 25
        WHERE
            pc.proceso = 10
        AND pc.status = 1";

        return $this->db->query($query)->result();
    }

    public function getListaVoBoCifras(){
        $query = "SELECT
            pc.*,
            lo.nombreLote,
            doc.archivo,
            doc.documento,
            doc.idDocumento
        FROM proceso_casas pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        LEFT JOIN documentos_proceso_casas doc ON doc.idProcesoCasas = pc.idProcesoCasas AND tipo = 25
        WHERE
            pc.proceso = 11
        AND pc.status = 1";

        return $this->db->query($query)->result();
    }

    public function getListaExpedienteCliente(){
        $query = "SELECT
            pc.*,
            lo.nombreLote
        FROM proceso_casas pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        WHERE
            pc.proceso = 12
        AND pc.status = 1";

        return $this->db->query($query)->result();
    }

    public function getListaEnvioAFirma(){
        $query = "SELECT
            pc.*,
            lo.nombreLote
        FROM proceso_casas pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        WHERE
            pc.proceso = 13
        AND pc.status = 1";

        return $this->db->query($query)->result();
    }

    public function getListaFirmaContrato(){
        $query = "SELECT
            pc.*,
            lo.nombreLote
        FROM proceso_casas pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        WHERE
            pc.proceso = 14
        AND pc.status = 1";

        return $this->db->query($query)->result();
    }

    public function getListaRecepcionContrato(){
        $query = "SELECT
            pc.*,
            lo.nombreLote
        FROM proceso_casas pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        WHERE
            pc.proceso = 15
        AND pc.status = 1";

        return $this->db->query($query)->result();
    }

    public function getListaFinalizar($in){
        $query = "SELECT
            pc.*,
            lo.nombreLote
        FROM proceso_casas pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        WHERE
            pc.proceso = 16
        AND pc.finalizado IN ($in)
        AND pc.status = 1";

        return $this->db->query($query)->result();
    }

    public function markProcesoFinalizado($idProcesoCasas){
        $query = "UPDATE proceso_casas
        SET
            finalizado = 1,
            fechaProceso = GETDATE()
        WHERE
            idProcesoCasas = $idProcesoCasas";

        return $this->db->query($query);
    }

    public function setAdeudo($idProcesoCasas, $columna, $adeudo){
        $query = "UPDATE proceso_casas
        SET
            $columna = $adeudo
        WHERE
            idProcesoCasas = $idProcesoCasas";

        return $this->db->query($query);
    }

    public function getPropuestas($idProcesoCasas){
        $query = "SELECT
            *
        FROM propuestas_proceso_casas
        WHERE
            idProcesoCasas = $idProcesoCasas";

        return $this->db->query($query)->result();
    }

    public function addPropuesta($idProcesoCasas, $notaria, $fechaFirma, $costo){
        $idModificacion = $this->session->userdata('id_usuario');

        $query = "INSERT INTO propuestas_proceso_casas
        (
            idProcesoCasas,
            notaria,
            fechaFirma,
            costo,
            idCreacion,
            idModificacion,
            fechaModificacion
        )
        VALUES
        (
            $idProcesoCasas,
            $notaria,
            '$fechaFirma',
            $costo,
            $idModificacion,
            $idModificacion,
            GETDATE()
        )";

        return $this->db->query($query);
    }

    public function updatePropuesta($idPropuesta, $notaria, $fechaFirma, $costo){
        $query = "UPDATE propuestas_proceso_casas
        SET
            notaria = $notaria,
            fechaFirma = '$fechaFirma',
            costo = $costo
        WHERE
            idPropuesta = $idPropuesta";

        return $this->db->query($query);
    }

    public function setPropuesta($idProcesoCasas, $idPropuesta){
        $query = "UPDATE proceso_casas
        SET
            idPropuesta = $idPropuesta
        WHERE
            idProcesoCasas = $idProcesoCasas";

        return $this->db->query($query);
    }
}