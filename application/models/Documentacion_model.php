<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 */
class Documentacion_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }

    public function generateFilename($idLote, $idDocumento) {
        return $this->db->query("SELECT CONCAT(r.nombreResidencial, '_', SUBSTRING(cn.nombre, 1, 4), '_', l.idLote, 
        '_', c.id_cliente,'_TDOC', hd.tipo_doc, SUBSTRING(hd.movimiento, 1, 4),
        '_', UPPER(REPLACE(REPLACE(CONVERT(varchar, GETDATE(),109), ' ', ''), ':', ''))) fileName FROM lotes l 
        INNER JOIN clientes c ON c.idLote = l.idLote
        INNER JOIN condominios cn ON cn.idCondominio = l.idCondominio
        INNER JOIN residenciales r ON r.idResidencial = cn.idResidencial
        INNER JOIN historial_documento hd ON hd.idLote = l.idLote AND hd. idDocumento = $idDocumento
        WHERE l.idLote = $idLote");
    }

    public function getFilename($idDocumento) {
        return $this->db->query("SELECT * FROM historial_documento WHERE idDocumento = $idDocumento");
    }

    /**---------------ESCRITURACIÓN------------- */
    function getCatalogOptions()
    {
        return $this->db->query("SELECT id_documento as id_opcion,descripcion as nombre,id_documento as id_catalago FROM documentacion_escrituracion");
    }
    function getReasonsForRejectionByDocument($id_documento, $tipo_proceso)
    {
        return $this->db->query("SELECT id_motivo, 
        CASE WHEN oxc.descripcion IS NULL THEN 'POR SOLICITUD' ELSE oxc.descripcion END nombre_documento, 
        mr.motivo, mr.estatus,
                CASE mr.estatus WHEN 1 THEN '<span class=\"label\" style=\"background:#81C784\">ACTIVO</span>'
                ELSE '<span class=\"label\" style=\"background:#E57373\">INACTIVO</span>' END estatus_motivo
                FROM motivos_rechazo mr 
                LEFT JOIN documentacion_escrituracion oxc ON oxc.id_documento = mr.tipo_documento 
        WHERE mr.tipo_documento = $id_documento AND mr.tipo_proceso = $tipo_proceso");
    }
    function getRejectionReasons($tipo_proceso)
    {
        return $this->db->query("SELECT id_motivo, tipo_documento, motivo, tipo_proceso FROM motivos_rechazo WHERE estatus = 1 AND tipo_proceso = $tipo_proceso")->result_array();
    }

}
