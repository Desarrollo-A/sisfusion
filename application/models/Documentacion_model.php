<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 */
class Documentacion_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function getResidencialesList()
    {
        return $this->db->query("SELECT idResidencial, nombreResidencial, UPPER(CAST(descripcion AS VARCHAR(75))) descripcion FROM residenciales WHERE status = 1 ORDER BY nombreResidencial ASC")->result_array();
    }

    function getCondominiosList($idResidencial)
    {
        return $this->db->query("SELECT idCondominio, UPPER(nombre) nombre FROM condominios WHERE status = 1 AND idResidencial = $idResidencial ORDER BY nombre ASC")->result_array();
    }

    function getLotesList($idCondominio)
    {
        return $this->db->query("SELECT idLote, UPPER(nombreLote) nombreLote, idStatusLote FROM lotes WHERE status = 1 AND idCondominio = $idCondominio")->result_array();
    }

    function getClientInformation($idLote)
    {
        return $this->db->query("SELECT l.idStatusContratacion, l.idMovimiento,
        CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno) clientName FROM lotes l
        INNER JOIN clientes cl ON cl.idLote = l.idLote AND cl.status = 1
        WHERE L.idLote = $idLote");
    }

    function getDocumentTree($idLote)
    {
        return $this->db->query("SELECT hd.idCliente, hd.idLote, hd.idDocumento, UPPER(hd.movimiento) name, ISNULL(hd.expediente, '0') fileName, hd.modificado lastModify, estatus_validacion,
        UPPER(CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno)) userName, hd.tipo_doc documentType,
		(CASE WHEN (l.idMovimiento IN (35, 22, 62, 75, 94) AND hd.tipo_doc = 7) THEN 1 ELSE 0 END) userPermissions,
        (CASE WHEN l.idMovimiento IN (35, 22, 62, 75, 94) THEN 1 ELSE 0 END) validatePermissions, cl.lugar_prospeccion
        FROM historial_documento hd 
        LEFT JOIN usuarios u ON u.id_usuario = hd.idUser
        INNER JOIN lotes l ON l.idLote = hd.idLote
        INNER JOIN clientes cl ON cl.idLote = l.idLote AND cl.status = 1
        WHERE hd.idLote = $idLote AND hd.status = 1 ORDER BY (CASE hd.tipo_doc WHEN 1 THEN 4 WHEN 2 THEN 1 WHEN 3 THEN 2 WHEN 4 THEN 3 ELSE hd.tipo_doc END)");
    }

    function getdp($idLote)
    {
        return $this->db->query("SELECT TOP(1) l.idCliente, l.idLote, ds.id idDocumento, 'DEPÓSITO DE SERIEDAD' name, '1' fileName, ds.fechaCrate lastModify, 
        ds.estatus_validacion, 'VENTAS-ASESOR' userName, '30' documentType, 
		'0' userPermissions, (CASE WHEN l.idMovimiento IN (35, 22, 62, 75, 94) THEN 1 ELSE 0 END) validatePermissions, cl.lugar_prospeccion
		FROM clientes cl
		INNER JOIN lotes l ON l.idLote = cl.idLote AND l.idLote = $idLote AND l.status = 1
		INNER JOIN deposito_seriedad ds ON ds.id_cliente = cl.id_cliente AND ds.desarrollo IS NOT NULL
		INNER JOIN condominios cond ON cond.idCondominio = l.idCondominio
		INNER JOIN residenciales res ON res.idResidencial = cond.idResidencial
        WHERE cl.status = 1;");
    }

    function getdp_DS($idLote)
    {
        return $this->db->query("SELECT TOP(1) l.idCliente, l.idLote, ds.id idDocumento, 'DEPÓSITO DE SERIEDAD' name, '1' fileName, ds.fechaCrate lastModify, 
        ds.estatus_validacion, 'VENTAS-ASESOR' userName, '31' documentType, 
		'0' userPermissions, (CASE WHEN l.idMovimiento IN (35, 22, 62, 75, 94) THEN 1 ELSE 0 END) validatePermissions, '0' lugar_prospeccion
		FROM cliente_consulta cl
		INNER JOIN lotes_consulta l ON l.idLote = cl.idLote AND l.idLote = $idLote AND l.status = 1
		INNER JOIN deposito_seriedad_consulta ds ON ds.idCliente = cl.idCliente
		INNER JOIN condominios cond ON cond.idCondominio = l.idCondominio
		INNER JOIN residenciales res ON res.idResidencial = cond.idResidencial
        WHERE cl.status = 1;");
    }

    function getAuthorizations($idLote)
    {
        return $this->db->query("SELECT TOP(1) l.idCliente, l.idLote, aut.id_autorizacion idDocumento, 'AUTORIZACIONES' name, '1' fileName, aut.fecha_creacion lastModify, 
        aut.estatus_validacion, 'VENTAS-ASESOR' userName, '32' documentType, 
        '0' userPermissions, (CASE WHEN l.idMovimiento IN (35, 22, 62, 75, 94) THEN 1 ELSE 0 END) validatePermissions, cl.lugar_prospeccion
		FROM autorizaciones aut
		INNER JOIN lotes l ON l.idLote = aut.idLote AND l.idLote = $idLote
		INNER JOIN clientes cl ON aut.idCliente = cl.id_cliente AND cl.status = 1
		INNER JOIN condominios cond ON cond.idCondominio = l.idCondominio
		INNER JOIN residenciales res ON res.idResidencial = cond.idResidencial
		LEFT JOIN usuarios as asesor ON aut.id_sol = asesor.id_usuario
        LEFT JOIN usuarios as users1 ON aut.id_aut = users1.id_usuario");
    }

    function getLead($idLote)
    {
        return $this->db->query("SELECT l.idCliente, l.idLote, ps.id_prospecto idDocumento, 'PROSPECTO' name, '1' fileName, ps.fecha_creacion lastModify, 
		ps.estatus_validacion, 'VENTAS-ASESOR' userName, '33' documentType, 
		'0' userPermissions, (CASE WHEN l.idMovimiento IN (35, 22, 62, 75, 94) THEN 1 ELSE 0 END) validatePermissions, ps.lugar_prospeccion
		FROM clientes cl
		INNER JOIN lotes l ON l.idLote = cl.idLote AND l.status = 1 AND l.idLote = $idLote
		INNER JOIN condominios cond ON cond.idCondominio = l.idCondominio
		INNER JOIN residenciales res ON res.idResidencial = cond.idResidencial
		INNER JOIN prospectos ps ON cl.id_prospecto = ps.id_prospecto
		WHERE cl.status = 1");
    }

    function getMktdEvidence($idLote)
    {
        return $this->db->query("SELECT l.idCliente, l.idLote, ec.id_evidencia idDocumento, 'EVIDENCIA MKTD' name, ec.evidencia fileName, ec.fecha_modificado lastModify, 
		ec.estatus_validacion, 'VENTAS-ASESOR' userName, '34' documentType, 
		'0' userPermissions, (CASE WHEN l.idMovimiento IN (35, 22, 62, 75, 94) THEN 1 ELSE 0 END) validatePermissions, cl.lugar_prospeccion
        FROM clientes cl
        INNER JOIN lotes l ON l.idLote = cl.idLote AND l.status = 1 AND l.idLote = $idLote
        INNER JOIN usuarios asesor ON asesor.id_usuario = cl.id_asesor
        INNER JOIN condominios cond ON cond.idCondominio = l.idCondominio
        INNER JOIN residenciales res ON res.idResidencial = cond.idResidencial
        INNER JOIN evidencia_cliente ec ON cl.id_cliente = ec.idCliente AND ec.estatus = 3
        WHERE cl.status = 1");
    }

    function generateFilename($idLote, $idDocumento)
    {
        return $this->db->query("SELECT CONCAT(r.nombreResidencial, '_', SUBSTRING(cn.nombre, 1, 4), '_', l.idLote, 
        '_', c.id_cliente,'_TDOC', hd.tipo_doc, SUBSTRING(hd.movimiento, 1, 4),
        '_', UPPER(REPLACE(REPLACE(CONVERT(varchar, GETDATE(),109), ' ', ''), ':', ''))) fileName FROM lotes l 
        INNER JOIN clientes c ON c.idLote = l.idLote
        INNER JOIN condominios cn ON cn.idCondominio = l.idCondominio
        INNER JOIN residenciales r ON r.idResidencial = cn.idResidencial
        INNER JOIN historial_documento hd ON hd.idLote = l.idLote AND hd. idDocumento = $idDocumento
        WHERE l.idLote = $idLote");
    }

    function updateDocumentBranch($updateDocumentData, $idDocumento)
    {
        $response = $this->db->update("historial_documento", $updateDocumentData, "idDocumento = $idDocumento");
        if (!$response) {
            return 0;
        } else {
            return 1;
        }
    }

    function getFilename($idDocumento)
    {
        return $this->db->query("SELECT * FROM historial_documento WHERE idDocumento = $idDocumento");
    }

    function getRejectionReasons($tipo_proceso)
    {
        return $this->db->query("SELECT id_motivo, tipo_documento, motivo, tipo_proceso FROM motivos_rechazo WHERE estatus = 1 AND tipo_proceso = $tipo_proceso")->result_array();
    }

    function saveRejectionReasons($data)
    {
        $response = $this->db->insert_batch("motivos_rechazo_x_documento", $data);
        if (!$response) {
            return 0;
        } else {
            return 1;
        }
    }

    function getRejectReasons($idDocumento, $idLote, $documentType)
    {
        $and = "AND mrxd.tipo = $documentType";
        if ($documentType == 30) $clause = "INNER JOIN deposito_seriedad main ON main.id_cliente = cl.id_cliente";
        else if ($documentType == 32) $clause = "INNER JOIN autorizaciones main ON main.idCliente = cl.id_cliente";
        else if ($documentType == 33) $clause = "INNER JOIN prospectos main ON main.id_prospecto = cl.id_prospecto";
        else if ($documentType == 34) $clause = "INNER JOIN evidencia_cliente main ON main.idCliente = cl.id_cliente";
        else {
            $clause = "INNER JOIN historial_documento main ON main.idLote = l.idLote AND main.status = 1 AND main.idDocumento = $idDocumento";
            $and = "";
        }

        return $this->db->query("SELECT mrxd.id_mrxdoc, mr.motivo, UPPER(CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno)) userValidacion FROM lotes l 
        INNER JOIN clientes cl ON cl.idLote = l.idLote AND cl.status = 1
        $clause
        INNER JOIN usuarios u ON u.id_usuario = main.validado_por
        INNER JOIN motivos_rechazo_x_documento mrxd ON mrxd.id_documento = $idDocumento AND mrxd.estatus = 1 $and
        INNER JOIN motivos_rechazo mr ON mr.id_motivo = mrxd.id_motivo
        WHERE l.status = 1 AND l.idLote = $idLote");
    }

    function getRejectReasonsTwo($idDocumento, $idSolicitud, $documentType)
    {
        return $this->db->query("SELECT mrxd.id_mrxdoc, mr.motivo, UPPER(CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno)) userValidacion 
        FROM solicitud_escrituracion se      
        INNER JOIN documentos_escrituracion de ON de.idSolicitud = se.idSolicitud
        INNER JOIN usuarios u ON u.id_usuario = de.validado_por
        INNER JOIN motivos_rechazo_x_documento mrxd ON mrxd.id_documento = $idDocumento AND mrxd.estatus = 1 AND mrxd.tipo = $documentType
        INNER JOIN motivos_rechazo mr ON mr.id_motivo = mrxd.id_motivo
        WHERE se.idSolicitud = $idSolicitud");
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


    function getDocumentsInformation_Escrituracion($idLote){
        return $this->db->query("SELECT se.idSolicitud, de.* FROM solicitud_escrituracion se
        INNER JOIN documentos_escrituracion de ON de.idSolicitud = se.idSolicitud
        WHERE se.idLote = $idLote");
    }

    function getLotesList_escrituracion($idCondominio){
        return $this->db->query("SELECT * FROM lotes lo
        INNER JOIN solicitud_escrituracion se ON se.idLote = lo.idLote
        WHERE lo.idCondominio = $idCondominio");
    }
    function getCatalogOptions()
    {
        return $this->db->query("SELECT id_documento as id_opcion,descripcion as nombre,id_documento as id_catalago FROM documentacion_escrituracion");
    }

    public function getClientesPorLote($idLote) {
		$result = $this->db->query("SELECT id_cliente, UPPER(CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno)) nombreCliente, status FROM clientes WHERE idLote = $idLote AND isNULL(noRecibo, '') != 'CANCELADO' ORDER BY status DESC")->result_array();
		return count($result) > 0 ? $result: array();
	}

    /**
     * Función para buscar el path donde se encuentra el archivo en los diferentes tipos de proceso de contratación
     *
     * @param $tipoDocumento
     * @param $tipoContratacion
     * @param $nombreLote
     * @param bool $eliminarArchivo bandera para saber si se eliminará el archivo o no para no afectar los archivos del patch viejo
     * @param $nombreDocumento
     * @return string
     */
    public function getCarpetaArchivo($tipoDocumento, $tipoContratacion = 1, $nombreLote = '', $nombreDocumento = '', $eliminarArchivo = false): string
    {
        if (!in_array($tipoDocumento, [41, 35, 7, 8, 46, 47]) || (in_array($tipoDocumento, [7, 8, 46, 47]) && in_array($tipoContratacion, [0, 1])))
            return $this->obtenerPathViejoContratacion($tipoDocumento);
        else
            return $this->obtenerPathNuevoContratacion($nombreLote);
        return '';
    }

    private function obtenerPathViejoContratacion($tipoDocumento): string
    {
        $pathBase = 'static/documentos/cliente/';
        if ($tipoDocumento == 7 || $tipoDocumento == 39) // CORRIDA FINANCIERA: CONTRALORÍA
            return "{$pathBase}corrida/";
        if ($tipoDocumento == 8 || $tipoDocumento == 40) // CONTRATO: JURÍDICO
            return "{$pathBase}contrato/";
        if ($tipoDocumento == 30) // CONTRATO FIRMADO: CONTRALORÍA
            return "{$pathBase}contratoFirmado/";
        if ($tipoDocumento == 50) // ANEXO VENTA DE PARTICUALES: POSTVENTA
            return "{$pathBase}anexo_vp/";
        // EL RESTO DE DOCUMENTOS SE GUARDAN EN LA CARPETA DE EXPEDIENTES
        return "{$pathBase}expediente/";
    }

    private function obtenerPathNuevoContratacion($nombreLote/*, $tipoContratacion*/): string
    {
        $pathBase = 'static/documentos/';
        return "{$pathBase}contratacion-reubicacion/$nombreLote/";
    }

    public function getTotalFilesIsNotBucket(){
        $query = "SELECT COUNT(*) AS total
        FROM historial_documento";

        return $this->db->query($query)->row();
    }

    public function getDocument($idDocumento){
        $query = "SELECT *
        FROM historial_documento
        WHERE
            idDocumento = $idDocumento
        AND bucket NOT IN (1)
        AND status IN (1)";

        return $this->db->query($query)->row();
    }

    public function updateDocumentToBucket($idDocumento){
        $query = "UPDATE historial_documento SET bucket=1 WHERE idDocumento = $idDocumento";

        return $this->db->query($query);
    }

    public function getLastDocument(){
        $query = "SELECT TOP 1
            hd.idDocumento,
            hd.movimiento,
            hd.expediente,
            lo.idLote,
            lo.nombreLote,
            lo2.nombreLote AS anteriorLote,
            lo3.nombreLote AS fusionLote
        FROM historial_documento hd
        LEFT JOIN lotes lo ON lo.idLote=hd.idLote
        LEFT JOIN propuestas_x_lote pxl ON pxl.id_lotep=hd.idLote AND estatus=1
        LEFT JOIN lotes lo2 ON lo2.idLote=pxl.idLote
        LEFT JOIN lotesFusion lf ON lf.idLote=hd.idLote
        LEFT JOIN lotes lo3 ON lo3.idLote=lf.idLotePvOrigen
        WHERE
            hd.bucket = 0
        AND hd.expediente IS NOT NULL
        AND hd.expediente != ''
        ORDER BY hd.modificado DESC";

        return $this->db->query($query)->row();
    }

    public function updateDocument($idDocumento, $expediente){
        $query = "UPDATE historial_documento
        SET
            expediente='$expediente',
            bucket=1
        WHERE idDocumento=$idDocumento";

        return $this->db->query($query);
    }

    public function insertNoBucket($document){
        $query = "INSERT INTO documentos_no_bucket(
            idDocumento,
            movimiento,
            expediente,
            idLote,
            nombreLote,
            anteriorLote,
            fusionLote
        )
        VALUES(
            $document->idDocumento,
            '$document->movimiento',
            '$document->expediente',
            '$document->idLote',
            '$document->nombreLote',
            '$document->anteriorLote',
            '$document->fusionLote'
        )";

        return $this->db->query($query);
    }

    public function getPXLDocument(){
        $query = "SELECT TOP 1
            pxl.id_pxl,
            lo.idLote, 
            lo.nombreLote, 
            pxl.corrida, 
            pxl.contrato 
        FROM propuestas_x_lote pxl
        LEFT JOIN lotes lo ON lo.idLote = pxl.idLote
        WHERE
            bucket = 0
        AND pxl.contrato IS NOT NULL
        AND pxl.corrida IS NOT NULL";

        return $this->db->query($query)->row();
    }

    public function updatePXL($id_pxl){
        $query = "UPDATE propuestas_x_lote
        SET
            bucket=1
        WHERE id_pxl=$id_pxl";

        return $this->db->query($query);
    }

    public function getDXCDocument(){
        $query = "SELECT TOP 1
            dxc.id_dxc AS id,
            dxc.idLote,
            dxc.rescision,
            dxc.bucket,
            lo.nombreLote AS lote
        FROM datos_x_cliente dxc
        LEFT JOIN propuestas_x_lote pxl ON pxl.idLote = dxc.idLote
        LEFT JOIN lotes lo ON lo.idLote = pxl.id_lotep
        WHERE
            dxc.bucket != 1
        AND dxc.rescision IS NOT NULL
        AND dxc.rescision != ''";

        return $this->db->query($query)->row();
    }

    public function updateDXC($id_dxc){
        $query = "UPDATE datos_x_cliente
        SET
            bucket=1
        WHERE id_dxc=$id_dxc";

        return $this->db->query($query);
    }

    public function getLFDocument(){
        $query = "SELECT TOP 1
            lf.idFusion AS id,
            lo.idLote,
            lo.nombreLote,
            lf.corrida, 
            lf.contrato,
            lf.rescision
        FROM lotesFusion lf
        LEFT JOIN lotes lo ON lo.idLote = lf.idLotePvOrigen
        WHERE
            lf.bucket = 0";

        return $this->db->query($query)->row();
    }

    public function updateLF($idFusion){
        $query = "UPDATE lotesFusion
        SET
            bucket=1
        WHERE idFusion=$idFusion";

        return $this->db->query($query);
    }
}