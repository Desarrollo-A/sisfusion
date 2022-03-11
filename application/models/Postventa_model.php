<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 */
class Postventa_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function getProyectos()
    {
        return $this->db->query("SELECT * FROM residenciales WHERE status = 1");
    }

    function getCondominios($idResidencial)
    {
        return $this->db->query("SELECT * FROM condominios WHERE status = 1 AND idResidencial = $idResidencial");
    }

    function getLotes($idCondominio)
    {
        return $this->db->query("SELECT * FROM lotes WHERE idCondominio = $idCondominio AND idStatusContratacion = 15 AND idMovimiento = 45 AND idStatusLote = 2");
    }

    function getClient($idLote)
    {
        return $this->db->query("SELECT c.id_cliente, CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre, c.ocupacion,
        oxc.nombre nacionalidad, oxc2.nombre estado_civil, oxc3.nombre regimen_matrimonial, c.correo, c.domicilio_particular, c.rfc, c.telefono1, c.telefono2 
        FROM lotes l 
        INNER JOIN clientes c ON c.id_cliente = l.idCliente 
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = c.nacionalidad AND oxc.id_catalogo = 11
        INNER JOIN opcs_x_cats oxc2 ON oxc2.id_opcion = c.estado_civil AND oxc2.id_catalogo = 18
        INNER JOIN opcs_x_cats oxc3 ON oxc3.id_opcion = c.regimen_matrimonial AND oxc3.id_catalogo = 19
        WHERE l.idLote = $idLote");
    }

    function setEscrituracion($idLote, $idCliente)
    {
        $idUsuario = $this->session->userdata('id_usuario');
        $rol = $this->session->userdata('id_rol');

        $this->db->query("INSERT INTO solicitud_escrituracion (idLote, idCliente, estatus, fecha_creacion
        , creado_por, fecha_modificacion, modificado_por, idArea) VALUES($idLote, $idCliente, 0, GETDATE(), $idUsuario, GETDATE(),$idUsuario, $rol);");
        $insert_id = $this->db->insert_id();
        $opciones = $this->db->query("SELECT * FROM opcs_x_cats WHERE id_catalogo = 60")->result_array();
        foreach ($opciones as $row) {
            $opcion = $row['id_opcion'];
            $this->db->query("INSERT INTO documentos_escrituracion VALUES('creacion de rama', null, GETDATE(), 1,  $insert_id,
            $idUsuario, $opcion, $idUsuario, $idUsuario, GETDATE(), NULL, NULL);");
        }

        return $this->db->query("INSERT INTO control_estatus VALUES(0, 59, 4, GETDATE(), 1,$insert_id, $rol,0,'','');");
    }

    function getSolicitudes($begin, $end)
    {

        $idUsuario = $this->session->userdata('id_usuario');
        $rol = $this->session->userdata('id_rol');

        return $this->db->query("SELECT oxc2.nombre area, se.idSolicitud, oxc.nombre estatus, se.fecha_creacion, l.nombreLote, se.estatus idEstatus,
        CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre, cond.nombre nombreCondominio, r.nombreResidencial, de.expediente,
        ctrl.tipo_documento, de.idDocumento, ctrl.permisos, de2.result, ce.tipo, ce.comentarios, mr.motivo motivos_rechazo, de2.estatusValidacion, de3.Spresupuesto
        FROM solicitud_escrituracion se 
        INNER JOIN clientes c ON c.id_cliente = se.idCliente AND c.status = 1
        INNER JOIN lotes l ON se.idLote = l.idLote 
        INNER JOIN condominios cond ON cond.idCondominio = l.idCondominio 
        INNER JOIN residenciales r ON r.idResidencial = cond.idResidencial 
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = se.estatus AND oxc.id_catalogo = 59 
        INNER JOIN opcs_x_cats oxc2 ON oxc2.id_opcion = se.idArea AND oxc2.id_catalogo = 1 
        INNER JOIN control_procesos ctrl ON ctrl.estatus = se.estatus AND ctrl.idRol = $rol
        LEFT JOIN documentos_escrituracion de ON de.idSolicitud=se.idSolicitud AND de.tipo_documento = ctrl.tipo_documento
        LEFT JOIN (SELECT idSolicitud, CASE WHEN COUNT(*) != COUNT(CASE WHEN expediente IS NOT NULL THEN 1 END) 
		THEN 0 ELSE 1 END result, 
		CASE WHEN COUNT(*) != COUNT(CASE WHEN estatus_validacion = 1 THEN 1 END) THEN 0 ELSE 1 END estatusValidacion 
		FROM documentos_escrituracion WHERE tipo_documento NOT IN (7,9,10, 11, 12, 13,14,15,16,17) GROUP BY idSolicitud) de2 ON de2.idSolicitud = se.idSolicitud
        LEFT JOIN (SELECT idSolicitud,  CASE WHEN COUNT(*) != COUNT(CASE WHEN expediente IS NOT NULL THEN 1 END) THEN 0 ELSE 1 END Spresupuesto
		FROM documentos_escrituracion WHERE tipo_documento = 11 GROUP BY idSolicitud) de3 ON de3.idSolicitud = se.idSolicitud
        LEFT JOIN control_estatus ce ON ce.fecha_creacion = (SELECT max(fecha_creacion) FROM control_estatus WHERE ce.idEscrituracion = se.idSolicitud AND ce.newStatus = se.estatus)
        LEFT JOIN motivos_rechazo mr ON mr.id_motivo = ce.motivos_rechazo
        LEFT JOIN usuarios us ON us.id_usuario = de.validado_por
        WHERE se.fecha_creacion BETWEEN '$begin 00:00:00' AND '$end 23:59:59'");
    }

    function changeStatus($id_solicitud, $type, $comentarios, $motivos_rechazo)
    {
        $idUsuario = $this->session->userdata('id_usuario');
        $rol = $this->session->userdata('id_rol');

        $estatus = $this->db->query("SELECT estatus FROM solicitud_escrituracion WHERE idSolicitud = $id_solicitud")->row()->estatus;

        if ($type == 1) { //OK
            if ($estatus == 90) {
                $newStatus = 17;
                $next = $newStatus + 1;
            } else {
                $newStatus = $estatus + 1;
                $next = $newStatus + 1;
            }
        } elseif ($type == 2) {//REJECT
            $newStatus = $estatus - 1;
            $next = $newStatus + 1;
        } elseif ($type == 3) {//comodin fecha
            if ($estatus == 90) {
                $newStatus = 15;
                $next = $newStatus + 1;
            } else {
                $newStatus = 90;
                $next = 15;
            }
        }

        $this->db->query("UPDATE solicitud_escrituracion SET estatus = ($newStatus), idArea = $rol  WHERE idSolicitud = $id_solicitud");
        return $this->db->query("INSERT INTO control_estatus VALUES(($estatus), 59, $type, GETDATE(), ($next), $id_solicitud, $rol, ($newStatus), '$comentarios', $motivos_rechazo);");
    }

    function generateFilename($idSolicitud, $tipoDoc)
    {
        return $this->db->query("SELECT CONCAT(r.nombreResidencial, '_', SUBSTRING(cn.nombre, 1, 4), '_', l.idLote, 
        '_', c.id_cliente,'_TDOC_', REPLACE(oxc.nombre, ' ', '_'), SUBSTRING(de.movimiento, 1, 4),
        '_', UPPER(REPLACE(REPLACE(CONVERT(varchar, GETDATE(),109), ' ', ''), ':', ''))) fileName, de.idDocumento, de.expediente FROM solicitud_escrituracion se 
		INNER JOIN lotes l ON se.idLote =l.idLote
		INNER JOIN clientes c ON c.idLote = l.idLote AND c.id_cliente = se.idCliente
        INNER JOIN condominios cn ON cn.idCondominio = l.idCondominio
        INNER JOIN residenciales r ON r.idResidencial = cn.idResidencial
        LEFT JOIN documentos_escrituracion de ON de.idSolicitud = se.idSolicitud AND de.tipo_documento = $tipoDoc
		LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = $tipoDoc AND oxc.id_catalogo = 60
		WHERE se.idSolicitud = $idSolicitud");
    }

    function generateFilename2($idDoc)
    {
        return $this->db->query("SELECT CONCAT(r.nombreResidencial, '_', SUBSTRING(cn.nombre, 1, 4), '_', l.idLote, 
        '_', c.id_cliente,'_TDOC_', REPLACE(oxc.nombre, ' ', '_'), SUBSTRING(de.movimiento, 1, 4),
        '_', UPPER(REPLACE(REPLACE(CONVERT(varchar, GETDATE(),109), ' ', ''), ':', ''))) fileName, de.idDocumento, de.expediente, de.tipo_documento FROM solicitud_escrituracion se 
		INNER JOIN lotes l ON se.idLote =l.idLote
		INNER JOIN clientes c ON c.idLote = l.idLote AND c.id_cliente = se.idCliente
        INNER JOIN condominios cn ON cn.idCondominio = l.idCondominio
        INNER JOIN residenciales r ON r.idResidencial = cn.idResidencial
        LEFT JOIN documentos_escrituracion de ON de.idSolicitud = se.idSolicitud 
		LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = de.tipo_documento AND oxc.id_catalogo = 60
		WHERE de.idDocumento = $idDoc");
    }

    function updateDocumentBranch($documentName, $idSolicitud, $idUsuario, $documentType)
    {
        // print_r("INSERT INTO documentos_escrituracion VALUES('$documentName', '$documentName', GETDATE(), 1, $idSolicitud,
        // $idUsuario, $documentType, $idUsuario, $idUsuario, GETDATE());");
        $response = $this->db->query("INSERT INTO documentos_escrituracion VALUES('$documentName', '$documentName', GETDATE(), 1, $idSolicitud,
        $idUsuario, $documentType, $idUsuario, $idUsuario, GETDATE());");
        if (!$response) {
            return 0;
        } else {
            return 1;
        }
    }

    function getFilename($idDocumento)
    {
        return $this->db->query("SELECT * FROM documentos_escrituracion WHERE idDocumento = $idDocumento");
    }

    function replaceDocument($updateDocumentData, $idDocumento)
    {
        $response = $this->db->update("documentos_escrituracion", $updateDocumentData, "idDocumento = $idDocumento");
        if (!$response) {
            return 0;
        } else {
            return 1;
        }
    }

    function getMotivosRechazos($tipoDocumento)
    {
        $query = $this->db->query("SELECT * FROM motivos_rechazo WHERE producto = 2 AND tipo_documento = $tipoDocumento");
        return $query->result();
    }

    function getDocumentsClient($idSolicitud)
    {
        $query = $this->db->query("SELECT de.idDocumento, oxc.nombre, de.expediente, de.tipo_documento, de.idSolicitud,
        CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) creado_por, de.fecha_creacion, se.estatus estatusActual,
        (CASE WHEN de.estatus_validacion IS NULL THEN 'Sin validar' WHEN de.estatus_validacion = 1 THEN 'Validado OK' WHEN de.estatus_validacion = 2 THEN 'Rechazado' END) estatus_validacion,
        (CASE WHEN de.estatus_validacion IS NULL THEN '#566573' WHEN de.estatus_validacion = 1 THEN '#239B56' WHEN de.estatus_validacion = 2 THEN '#C0392B' END) colour,
        (CASE WHEN CONCAT(us2.nombre, ' ', us2.apellido_paterno, ' ', us2.apellido_materno) = '' THEN 'Sin especificar' ELSE CONCAT(us2.nombre, ' ', us2.apellido_paterno, ' ', us2.apellido_materno) END) validado_por,
        de.estatus_validacion ev,
		(CASE 
		WHEN de.estatus_validacion = 2 THEN STRING_AGG (CONCAT('<span class=\"label\" style=\"background:#A569BD\">', mr.motivo, '</span><br><br>'), '')
		ELSE '<span class=\"label\" style=\"background:#5499C7\">SIN  MOTIVOS DE RECHAZO</span>'
		END) motivos_rechazo
        FROM documentos_escrituracion de 
        INNER JOIN solicitud_escrituracion se ON se.idSolicitud = de.idSolicitud
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = de.tipo_documento AND oxc.id_catalogo = 60
        LEFT JOIN usuarios us ON us.id_usuario = de.creado_por
        LEFT JOIN usuarios us2 ON us2.id_usuario = de.validado_por
        LEFT JOIN motivos_rechazo_x_documento mrxd ON mrxd.id_documento = de.idDocumento AND mrxd.estatus = 1 
        LEFT JOIN motivos_rechazo mr ON mr.id_motivo = mrxd.id_motivo
        WHERE de.idSolicitud = $idSolicitud AND de.tipo_documento NOT IN (7, 11, 12, 13, 14, 15, 16, 17)
        GROUP BY
        de.idDocumento, oxc.nombre, de.expediente, de.tipo_documento, de.idSolicitud,
        CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno), de.fecha_creacion, se.estatus,
        (CASE WHEN de.estatus_validacion IS NULL THEN 'Sin validar' WHEN de.estatus_validacion = 1 THEN 'Validado OK' WHEN de.estatus_validacion = 2 THEN 'Rechazado' END),
        (CASE WHEN de.estatus_validacion IS NULL THEN '#566573' WHEN de.estatus_validacion = 1 THEN '#239B56' WHEN de.estatus_validacion = 2 THEN '#C0392B' END) ,
        (CASE WHEN CONCAT(us2.nombre, ' ', us2.apellido_paterno, ' ', us2.apellido_materno) = '' THEN 'Sin especificar' ELSE CONCAT(us2.nombre, ' ', us2.apellido_paterno, ' ', us2.apellido_materno) END),
        de.estatus_validacion");
        return $query->result();
    }

    function getNotarias()
    {
        $query = $this->db->query("SELECT * FROM Notarias");
        return $query->result();
    }

    function getValuadores(){
        $query = $this->db->query("SELECT * FROM Valuadores");
        return $query->result();
    }

    function getNotaria($idNotaria){
        $query = $this->db->query("SELECT * FROM Notarias WHERE idNotaria = $idNotaria");
        return $query->result();
    }

    function getValuador($idValuador){
        $query = $this->db->query("SELECT * FROM Valuadores WHERE idValuador = $idValuador");
        return $query->result();
    }

    function getBudgetInfo($idSolicitud){
        return $this->db->query("SELECT se.*, CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre, hl.modificado FROM solicitud_escrituracion se 
        INNER JOIN clientes c ON c.id_cliente = se.idCliente
        INNER JOIN (SELECT idLote, MAX(modificado) modificado FROM historial_lotes WHERE idStatusContratacion = 15 AND idMovimiento = 45 GROUP BY idLote) hl ON hl.idLote=se.idLote
        WHERE se.idSolicitud = $idSolicitud");
    }

    function savePresupuesto($nombreT, $fechaCA, $cliente, $superficie, $catastral, $rfcDatos, $construccion,
                             $nombrePresupuesto2, $id_solicitud, $estatusPago)
    {

        print_r("UPDATE solicitud_escrituracion SET nombre_escrituras='$nombrePresupuesto2', estatus_pago=$estatusPago,
        superficie=$superficie, clave_catastral=$catastral, estatus_construccion=$construccion, cliente_anterior=$cliente,
        nombre_anterior='$nombreT', fecha_anterior=$fechaCA, RFC='$rfcDatos' WHERE idSolicitud=$id_solicitud");

        return $this->db->query("UPDATE solicitud_escrituracion SET nombre_escrituras='$nombrePresupuesto2', estatus_pago=$estatusPago,
        superficie=$superficie, clave_catastral=$catastral, estatus_construccion=$construccion, cliente_anterior=$cliente,
        nombre_anterior='$nombreT', fecha_anterior=$fechaCA, RFC='$rfcDatos' WHERE idSolicitud=$id_solicitud");
    }

    function updatePresupuesto($data, $id_solicitud)
    {
        $response = $this->db->update("solicitud_escrituracion", $data, "idSolicitud = $id_solicitud");
        if (!$response)
            return $finalAnswer = 0;
        else
            return $finalAnswer = 1;
    }

function checkBudgetInfo($idSolicitud){
        return $this->db->query("SELECT se.*, CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre, hl.modificado, l.nombreLote, 
        cond.nombre nombreCond, r.nombreResidencial, n.correo correoN, v.correo correoV
                FROM solicitud_escrituracion se 
                INNER JOIN clientes c ON c.id_cliente = se.idCliente
                INNER JOIN (SELECT idLote, MAX(modificado) modificado FROM historial_lotes WHERE idStatusContratacion = 15 AND idMovimiento = 45 GROUP BY idLote) hl ON hl.idLote=se.idLote
                INNER JOIN lotes l ON l.idLote = se.idLote
                INNER JOIN condominios cond ON cond.idCondominio = l.idCondominio
                INNER JOIN residenciales r ON r.idResidencial = cond.idResidencial
                LEFT JOIN Notarias n ON n.idNotaria = se.idNotaria
                LEFT JOIN Valuadores v ON v.idValuador = se.idValuador
                WHERE se.idSolicitud =$idSolicitud");
    }

    function getInfoNotaria($idSolicitud, $idNotaria)
    {
        return $this->db->query("SELECT se.*, de.*, n.* FROM solicitud_escrituracion se
		INNER JOIN documentos_escrituracion de ON de.idSolicitud = se.idSolicitud
		INNER JOIN Notarias n ON n.idNotaria = $idNotaria
		WHERE se.idSolicitud = $idSolicitud");
    }

    function saveDate($signDate, $idSolicitud)
    {
        return $this->db->query("UPDATE solicitud_escrituracion SET fechaFirma = '$signDate' WHERE idSolicitud = $idSolicitud");
    }

    function getFileNameByDoctype($idSolicitud, $docType)
    {
        return $this->db->query("SELECT * FROM documentos_escrituracion WHERE idSolicitud = $idSolicitud AND tipo_documento = $docType");
    }

    function getInfoSolicitud($idSolicitud)
    {
        return $this->db->query("SELECT * FROM solicitud_escrituracion WHERE idSolicitud = $idSolicitud");
    }
    
    function insertNotariaValuador($idNotaria, $idValuador, $idSolicitud){
        return $this->db->query("UPDATE solicitud_escrituracion SET idNotaria= $idNotaria, idValuador = $idValuador WHERE idSolicitud = $idSolicitud;");
    }

    //INSERT NUEVA NOTARIA
    function insertNewNotaria($nombre_notaria, $nombre_notario, $direccion, $correo, $telefono){
        $this->db->query("INSERT INTO Notarias(nombre_notaria, nombre_notario, direccion, correo, telefono, sede, pertenece)
        VALUES('$nombre_notaria', '$nombre_notario', '$direccion', '$correo', '$telefono', 0, 2);");
        $insert_id = $this->db->insert_id();
        $idSolicitud = $_POST['idSolicitud'];
        //print_r("UPDATE solicitud_escrituracion SET idNotaria= $insert_id WHERE idSolicitud = $idSolicitud;");
        $this->db->query("UPDATE solicitud_escrituracion SET idNotaria= $insert_id WHERE idSolicitud = $idSolicitud;");
    }

    //GESTION NOTARIA CLIENTE
    function getNotariaClient($idSolicitud)
    {
        $idSolicitud = $_GET['idSolicitud'];
        //print_r("SELECT n.idNotaria, n.nombre_notaria, n.nombre_notario, n.direccion, n.correo, n.telefono FROM Notarias n INNER JOIN solicitud_escrituracion se ON se.idNotaria = n.idNotaria WHERE se.idSolicitud = $idSolicitud");
        return $this->db->query("SELECT n.idNotaria, n.nombre_notaria, n.nombre_notario, n.direccion, n.correo, n.telefono FROM Notarias n INNER JOIN solicitud_escrituracion se ON se.idNotaria = n.idNotaria WHERE se.idSolicitud = '$idSolicitud'");
        
    }

    function updateObservacionesPostventa($idSolicitud){
        $this->db->query("UPDATE solicitud_escrituracion SET estatus= 10 WHERE idSolicitud = $idSolicitud;");
    }

}