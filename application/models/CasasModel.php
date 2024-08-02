<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class CasasModel extends CI_Model
{
    private $idUsuario;

    function __construct(){
        parent::__construct();

        $this->load->library(['session']);

        $this->idUsuario = $this->session->userdata('id_usuario');
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

    public function getLastNotarias(){
        $query = "SELECT TOP 1 * 
        FROM opcs_x_cats 
        WHERE id_catalogo = 129 
        ORDER BY id_opcion DESC;";

        return $this->db->query($query)->row();
    }

    public function getNotarias(){
        $query = "SELECT id_opcion AS value, nombre AS label, estatus  FROM opcs_x_cats WHERE id_catalogo = 129";

        return $this->db->query($query)->result();
    }

    public function updateNotaria($id_opcion, $estatus){
        $query = "UPDATE opcs_x_cats
        SET
            estatus = $estatus
        WHERE
            id_opcion = $id_opcion AND id_catalogo = 129";

        return $this->db->query($query);
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

    public function setProcesoTo($idProcesoCasas, $proceso, $comentario, $tipoMovimiento){
        $idModificacion = $this->session->userdata('id_usuario');

        $query = "UPDATE proceso_casas
        SET
            proceso = $proceso,
            comentario = '$comentario',
            fechaProceso = GETDATE(),
            fechaModificacion = GETDATE(),
            modificadoPor = $idModificacion,
            tipoMovimiento = $tipoMovimiento
        WHERE
            idProcesoCasas = $idProcesoCasas";

        return $this->db->query($query);
    }

    public function addHistorial($idProcesoCasas, $procesoAnterior, $procesoNuevo, $descripcion, $esquema){
        $idMovimiento = $this->session->userdata('id_usuario');

        $query = "INSERT INTO historial_proceso_casas
        (
            idProcesoCasas,
            procesoAnterior,
            procesoNuevo,
            creadoPor,
            descripcion,
            esquemaCreditoProceso
        )
        VALUES
        (
            $idProcesoCasas,
            $procesoAnterior,
            $procesoNuevo,
            $idMovimiento,
            '$descripcion',
            $esquema
        )";

        return $this->db->query($query);
    }

    public function insertVobo($idProcesoCasas, $paso){

        $query = "INSERT INTO vobos_proceso_casas
        (
            idProceso,
            paso,
            adm,
            ooam,
            proyectos
        )
        VALUES
        (
            $idProcesoCasas,
            $paso,
            0,
            0,
            0
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
            id_catalogo = 126
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
        pc.status,
        con.nombre AS condominio,
        resi.descripcion AS proyecto,
        CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno) AS cliente,
        CASE
        WHEN cli.id_asesor IS NULL THEN 'SIN ESPECIFICAR'
        ELSE CONCAT(us_ases.nombre, ' ', us_ases.apellido_paterno, ' ', us_ases.apellido_materno)
        END AS asesor,
        CASE
        WHEN cli.id_coordinador IS NULL THEN 'SIN ESPECIFICAR'
        ELSE CONCAT(us_coord.nombre, ' ', us_coord.apellido_paterno, ' ', us_coord.apellido_materno)
        END AS coordinador,
        CASE
        WHEN pc.idGerente IS NULL THEN 'SIN ESPECIFICAR'
        ELSE CONCAT(us_gere.nombre, ' ', us_gere.apellido_paterno, ' ', us_gere.apellido_materno)
        END AS gerente,
        CASE
        WHEN cli.id_subdirector IS NULL THEN 'SIN ESPECIFICAR'
        ELSE CONCAT(us_sub.nombre, ' ', us_sub.apellido_paterno, ' ', us_sub.apellido_materno)
        END AS subdirector,
        CASE
        WHEN cli.id_regional IS NULL THEN 'SIN ESPECIFICAR'
        ELSE CONCAT(us_regi.nombre, ' ', us_regi.apellido_paterno, ' ', us_regi.apellido_materno)
        END AS regional,
        CASE
        WHEN cli.id_regional_2 IS NULL THEN 'SIN ESPECIFICAR'
        ELSE CONCAT(us_regi2.nombre, ' ', us_regi2.apellido_paterno, ' ', us_regi2.apellido_materno)
        END AS regional2
        FROM lotes lo
        LEFT JOIN proceso_casas pc ON pc.idLote = lo.idLote AND pc.status = 1
        INNER JOIN clientes cli ON cli.idLote = lo.idLote 
        LEFT JOIN usuarios us_ases ON us_ases.id_usuario = cli.id_asesor  
        LEFT JOIN usuarios us_coord ON us_coord.id_usuario = cli.id_coordinador 
        LEFT JOIN usuarios us_gere ON us_gere.id_usuario = pc.idGerente
        LEFT JOIN usuarios us_sub ON us_sub.id_usuario = cli.id_subdirector 
        LEFT JOIN usuarios us_regi On us_regi.id_usuario = cli.id_regional 
        LEFT JOIN usuarios us_regi2 On us_regi2.id_usuario = cli.id_regional_2
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
        INNER JOIN residenciales resi ON resi.idResidencial = con.idResidencial 
        WHERE
        lo.idMovimiento = 45
        AND lo.idStatusContratacion = 15
        AND lo.idCondominio = $idCondominio
        AND pc.status IS NULL
        AND cli.status = 1
        AND lo.esquemaCreditoCasas = 0";

        return $this->db->query($query)->result();
    }

    public function getListaAsignacion(){
        $query = "SELECT
        1 AS tipoEsquema,
        pc.proceso,
        pc.idProcesoCasas,
        pc.idLote,
        pc.idAsesor,
        pc.tipoMovimiento,
        lo.nombreLote,
        lo.esquemaCreditoCasas,
        con.nombre AS condominio,
        resi.descripcion AS proyecto,
        CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno) AS cliente,
        (CASE
            WHEN us.nombre IS NOT NULL THEN CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)
            ELSE 'Sin asignar'
        END) AS nombreAsesor,
        CASE
			 WHEN pc.idGerente IS NULL THEN 'SIN ESPECIFICAR'
			 ELSE CONCAT(us_gere.nombre, ' ', us_gere.apellido_paterno, ' ', us_gere.apellido_materno)
		END AS gerente,
        oxc.nombre AS movimiento,
        oxc.color
        FROM proceso_casas pc
        LEFT JOIN usuarios us ON us.id_usuario = pc.idAsesor
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        INNER JOIN clientes cli ON cli.idLote = lo.idLote 
        LEFT JOIN usuarios us_gere ON us_gere.id_usuario = pc.idGerente
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
        INNER JOIN residenciales resi ON resi.idResidencial = con.idResidencial
        LEFT JOIN opcs_x_cats oxc ON oxc.id_catalogo = 136 AND oxc.id_opcion = pc.tipoMovimiento
        WHERE
            pc.proceso = 0
            AND pc.status = 1
            AND pc.idGerente = $this->idUsuario
            AND cli.status = 1
        UNION ALL
        SELECT
        2 AS tipoEsquema,
        pcd.proceso,
        pcd.idProceso AS idProcesoCasas,
        pcd.idLote,
        pcd.idAsesor,
        pcd.tipoMovimiento,
        lo.nombreLote,
        lo.esquemaCreditoCasas,
        con.nombre AS condominio,
        resi.descripcion AS proyecto,
        CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno) AS cliente,
        (CASE
            WHEN us.nombre IS NOT NULL THEN CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)
            ELSE 'Sin asignar'
        END) AS nombreAsesor,
        CASE
			 WHEN pcd.idGerente IS NULL THEN 'SIN ESPECIFICAR'
			 ELSE CONCAT(us_gere.nombre, ' ', us_gere.apellido_paterno, ' ', us_gere.apellido_materno)
		END AS gerente,
        oxc.nombre AS movimiento,
        oxc.color
        FROM proceso_casas_directo pcd
        LEFT JOIN usuarios us ON us.id_usuario = pcd.idAsesor
        LEFT JOIN lotes lo ON lo.idLote = pcd.idLote
        INNER JOIN clientes cli ON cli.idLote = lo.idLote 
        LEFT JOIN usuarios us_gere ON us_gere.id_usuario = pcd.idGerente
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
        INNER JOIN residenciales resi ON resi.idResidencial = con.idResidencial
        LEFT JOIN opcs_x_cats oxc ON oxc.id_catalogo = 108 AND oxc.id_opcion = pcd.tipoMovimiento
        WHERE
            pcd.proceso = 0
            AND pcd.estatus = 1
            AND pcd.idGerente = $this->idUsuario
            AND cli.status = 1
        ";

        return $this->db->query($query)->result();
    }

    public function addLoteToAsignacion($idLote, $idGerente, $comentario, $idUsuario){
        $query = "INSERT INTO proceso_casas
        (
            idLote,
            idGerente,
            comentario,
            creadoPor
        )
        VALUES
        (
            $idLote,
            $idGerente,
            '$comentario',
            $idUsuario
        )";

        $result = $this->db->query($query);

        if($result){
            $query = "SELECT TOP 1 * FROM proceso_casas ORDER BY idProcesoCasas DESC";
            return $this->db->query($query)->row();
        }else{
            return null;
        }
    }

    public function addLoteToAsignacionDirecto($idLote, $idGerente, $comentario, $idUsuario){
        $query = "INSERT INTO proceso_casas_directo
        (
            idLote,
            idGerente,
            comentario,
            creadoPor
        )
        VALUES
        (
            $idLote,
            $idGerente,
            '$comentario',
            $idUsuario
        )";

        $result = $this->db->query($query);

        if($result){
            $query = "SELECT TOP 1 * FROM proceso_casas_directo ORDER BY idProceso DESC";
            return $this->db->query($query)->row();
        }else{
            return null;
        }
    }

    public function getGerentesOptions(){
        $query = "SELECT
            concat(nombre, ' ', apellido_paterno) AS label,
            id_usuario AS value
        FROM usuarios
        WHERE
            id_usuario IN (671, 75, 207, 1853)";

        // Cambiar por tipo 3

        return $this->db->query($query)->result();
    }

    public function getAsesoresOptions(){
        $query = "SELECT
            concat(nombre, ' ', apellido_paterno) AS label,
            id_usuario AS value
        FROM usuarios
        WHERE
            estatus = 1
        AND id_rol = 7
        AND id_lider = $this->idUsuario";

        return $this->db->query($query)->result();
    }

    public function getTiposCreditoOptions(){
        $query = "SELECT
            oxc.nombre AS label,
            oxc.id_opcion AS value
        FROM opcs_x_cats oxc
        WHERE
            oxc.estatus = 1
        AND oxc.id_catalogo = 130";

        return $this->db->query($query)->result();
    }

    public function getNotariasOptions(){
        $query = "SELECT
            oxc.nombre AS label,
            oxc.id_opcion AS value
        FROM opcs_x_cats oxc
        WHERE
            oxc.estatus = 1
        AND oxc.id_catalogo = 129";

        return $this->db->query($query)->result();
    }

    public function getCotizacionesOptions($idProcesoCasas){
        $query = "SELECT
            'Cotizacion' AS title,
            cpc.nombre AS subtitle,
            cpc.idCotizacion AS value,
            cpc.archivo AS archivo
        FROM cotizacion_proceso_casas cpc
        WHERE
            idProcesoCasas = $idProcesoCasas
        AND status = 1";

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
        doc.idDocumento,
        con.nombre AS condominio,
        resi.descripcion AS proyecto,
        CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno) AS cliente,
        (CASE
            WHEN us.nombre IS NOT NULL THEN CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)
            ELSE 'Sin asignar'
        END) AS nombreAsesor,
        CASE
			 WHEN pc.idGerente IS NULL THEN 'SIN ESPECIFICAR'
			 ELSE CONCAT(us_gere.nombre, ' ', us_gere.apellido_paterno, ' ', us_gere.apellido_materno)
		END AS gerente,
        oxc.nombre AS movimiento
        FROM proceso_casas pc
        LEFT JOIN usuarios us ON us.id_usuario = pc.idAsesor
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        LEFT JOIN documentos_proceso_casas doc ON doc.idProcesoCasas = pc.idProcesoCasas AND doc.tipo = 1
        INNER JOIN clientes cli ON cli.idLote = lo.idLote 
        LEFT JOIN usuarios us_gere ON us_gere.id_usuario = pc.idGerente
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
        INNER JOIN residenciales resi ON resi.idResidencial = con.idResidencial
        LEFT JOIN opcs_x_cats oxc ON oxc.id_catalogo = 136 AND oxc.id_opcion = pc.tipoMovimiento
        WHERE
            pc.proceso = 1
        AND pc.status = 1
        AND cli.status = 1";

        return $this->db->query($query)->result();
    }

    public function cancelProcess($idProcesoCasas, $comentario){
        $query = "UPDATE proceso_casas
        SET
            status = 0,
            comentario = '$comentario'
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

    public function getVobos($idProceso, $paso){

        $id = (int) $idProceso;

        $query = "SELECT * FROM vobos_proceso_casas WHERE idProceso =$id AND paso = $paso";

        return $this->db->query($query)->row();
    }

    public function getListaConcentradoAdeudos($tipoDoc, $rol){

        if($rol == 99){
			$vobo  = "AND vb.ooam = 0";
		}else if($rol == 11 || $rol == 33){
			$vobo = "AND vb.adm = 0";
		}

        $query = "SELECT pc.*,
        CASE
            WHEN pc.adeudoOOAM IS NULL THEN 'Sin registro'
            ELSE CONCAT('$', pc.adeudoOOAM) 
        END AS adOOAM,
        CASE
            WHEN pc.adeudoADM IS NULL THEN 'Sin registro'
            ELSE CONCAT('$', pc.adeudoADM) 
        END AS adADM,
        lo.nombreLote,
        con.nombre AS condominio,
        resi.descripcion AS proyecto,
        CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno) AS cliente,
        (CASE
            WHEN us.nombre IS NOT NULL THEN CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)
            ELSE 'Sin asignar'
        END) AS nombreAsesor,
        CASE
			 WHEN pc.idGerente IS NULL THEN 'SIN ESPECIFICAR'
			 ELSE CONCAT(us_gere.nombre, ' ', us_gere.apellido_paterno, ' ', us_gere.apellido_materno)
		END AS gerente,
        oxc.nombre AS movimiento,
		doc.archivo,
        doc.documento,
        doc.idDocumento,
        doc2.documentos
        FROM proceso_casas pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        INNER JOIN clientes cli ON cli.idLote = lo.idLote 
        LEFT JOIN usuarios us_gere ON us_gere.id_usuario = pc.idGerente
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
        INNER JOIN residenciales resi ON resi.idResidencial = con.idResidencial 
        LEFT JOIN usuarios us ON us.id_usuario = pc.idAsesor
        LEFT JOIN opcs_x_cats oxc ON oxc.id_catalogo = 136 AND oxc.id_opcion = pc.tipoMovimiento
		LEFT JOIN documentos_proceso_casas doc ON doc.idProcesoCasas = pc.idProcesoCasas AND doc.tipo = $tipoDoc
        LEFT JOIN vobos_proceso_casas vb ON vb.idProceso = pc.idProcesoCasas AND vb.paso = 1
        LEFT JOIN (SELECT COUNT(*) AS documentos, idProcesoCasas FROM documentos_proceso_casas WHERE tipo IN (13,14,15) AND archivo IS NOT NULL GROUP BY idProcesoCasas) doc2 ON doc2.idProcesoCasas = pc.idProcesoCasas
        WHERE pc.proceso IN (2, 3) AND pc.status = 1 AND cli.status = 1 $vobo";

        return $this->db->query($query)->result();
    }

    public function getConcentracionAdeudos(){
        $query = "SELECT 
        pc.*,
        CASE
            WHEN pc.adeudoOOAM IS NULL THEN 'Sin registro'
            ELSE CONCAT('$', pc.adeudoOOAM) 
        END AS adOOAM,
        lo.nombreLote,
        con.nombre AS condominio,
        resi.descripcion AS proyecto,
        CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno) AS cliente,
        CASE
            WHEN us.nombre IS NOT NULL THEN CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)
            ELSE 'Sin asignar'
        END AS nombreAsesor,
        CASE
            WHEN pc.idGerente IS NULL THEN 'SIN ESPECIFICAR'
            ELSE CONCAT(us_gere.nombre, ' ', us_gere.apellido_paterno, ' ', us_gere.apellido_materno)
        END AS gerente,
        oxc.nombre AS movimiento,
        doc2.documentos
    FROM 
        proceso_casas pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        INNER JOIN clientes cli ON cli.idLote = lo.idLote 
        LEFT JOIN usuarios us_gere ON us_gere.id_usuario = pc.idGerente
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
        INNER JOIN residenciales resi ON resi.idResidencial = con.idResidencial 
        LEFT JOIN usuarios us ON us.id_usuario = pc.idAsesor
        LEFT JOIN opcs_x_cats oxc ON oxc.id_catalogo = 136 AND oxc.id_opcion = pc.tipoMovimiento
        LEFT JOIN vobos_proceso_casas vb ON vb.idProceso = pc.idProcesoCasas AND vb.paso = 1
        LEFT JOIN (SELECT COUNT(*) AS documentos, idProcesoCasas FROM documentos_proceso_casas WHERE tipo IN (13,14,15) AND archivo IS NOT NULL GROUP BY idProcesoCasas) doc2 ON doc2.idProcesoCasas = pc.idProcesoCasas
    WHERE 
        pc.proceso IN (2, 3) 
        AND pc.status = 1 
        AND cli.status = 1
        AND vb.proyectos != 1";

        return $this->db->query($query)->result();
    }

    public function inserDocumentsToProceso($idProcesoCasas, $tipo, $documento){
        $idCreacion = $this->session->userdata('id_usuario');

        $query = "BEGIN
            IF NOT EXISTS (SELECT * FROM documentos_proceso_casas 
                           WHERE tipo = $tipo
                           AND idProcesoCasas = $idProcesoCasas)
            BEGIN
                INSERT INTO documentos_proceso_casas (idProcesoCasas, tipo, documento, creadoPor)
                VALUES ($idProcesoCasas, $tipo, '$documento', $idCreacion)
            END
        END";

        return $this->db->query($query);
    }

    public function insertCotizacion($idProcesoCasas){
        $idCreacion = $this->session->userdata('id_usuario');

        $query = "BEGIN
            IF NOT EXISTS (SELECT * FROM cotizacion_proceso_casas
                           WHERE idProcesoCasas = $idProcesoCasas)
            BEGIN
                INSERT INTO cotizacion_proceso_casas (idProcesoCasas, nombre, status, fechaCreacion, idModificacion)
                VALUES ($idProcesoCasas, 'Cotización', 1, GETDATE(), $idCreacion)
            END
        END";

        return $this->db->query($query);
    }

    public function getListaProcesoDocumentos(){
        $gerentes = implode(',', [$this->idUsuario]);

        if($this->idUsuario == 11650){
            $gerentes = implode(',', [671, 75, 207, 1853]);
        }

        $query = "SELECT
        pc.*,
        lo.nombreLote,
        doc.documentos,
        con.nombre AS condominio,
        resi.descripcion AS proyecto,
        CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno) AS cliente,
        (CASE
            WHEN us.nombre IS NOT NULL THEN CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)
            ELSE 'Sin asignar'
        END) AS nombreAsesor,
        CASE
			 WHEN pc.idGerente IS NULL THEN 'SIN ESPECIFICAR'
			 ELSE CONCAT(us_gere.nombre, ' ', us_gere.apellido_paterno, ' ', us_gere.apellido_materno)
		END AS gerente,
        oxc.nombre AS movimiento
        FROM proceso_casas pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        LEFT JOIN (SELECT COUNT(*) AS documentos, idProcesoCasas FROM documentos_proceso_casas WHERE tipo IN (2,3,4,5,6,7,8,10,11,12,13,14,15) AND archivo IS NOT NULL GROUP BY idProcesoCasas) doc ON doc.idProcesoCasas = pc.idProcesoCasas
        INNER JOIN clientes cli ON cli.idLote = lo.idLote 
        LEFT JOIN usuarios us_gere ON us_gere.id_usuario = pc.idGerente
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
        INNER JOIN residenciales resi ON resi.idResidencial = con.idResidencial 
        LEFT JOIN usuarios us ON us.id_usuario = pc.idAsesor
        LEFT JOIN opcs_x_cats oxc ON oxc.id_catalogo = 136 AND oxc.id_opcion = pc.tipoMovimiento
        WHERE
            pc.proceso IN (2, 3) 
        AND pc.status = 1
        AND cli.status = 1
        AND pc.idGerente IN ($gerentes)";

        return $this->db->query($query)->result();
    }

    public function getListaDocumentosCliente($idProcesoCasas){
        $query = "SELECT
            idProcesoCasas,
            idDocumento,
            CASE
                WHEN archivo IS NULL THEN 'Sin archivo'
                ELSE archivo
            END AS archivo,
            documento,
            tipo,
            fechaModificacion
        FROM documentos_proceso_casas
        WHERE
            idProcesoCasas = $idProcesoCasas
        AND tipo IN (13, 14, 15)";

        return $this->db->query($query)->result();
    }

    public function getListaProyectoEjecutivo(){
        $query = "SELECT
        pc.*,
        lo.nombreLote,
        doc.documentos,
        con.nombre AS condominio,
        resi.descripcion AS proyecto,
        CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno) AS cliente,
        (CASE
            WHEN us.nombre IS NOT NULL THEN CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)
            ELSE 'Sin asignar'
        END) AS nombreAsesor,
        CASE
			 WHEN pc.idGerente IS NULL THEN 'SIN ESPECIFICAR'
			 ELSE CONCAT(us_gere.nombre, ' ', us_gere.apellido_paterno, ' ', us_gere.apellido_materno)
		END AS gerente
        FROM proceso_casas pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        LEFT JOIN (SELECT COUNT(*) AS documentos, idProcesoCasas FROM documentos_proceso_casas WHERE tipo IN (13,14,15) AND archivo IS NOT NULL GROUP BY idProcesoCasas) doc ON doc.idProcesoCasas = pc.idProcesoCasas
        INNER JOIN clientes cli ON cli.idLote = lo.idLote 
        LEFT JOIN usuarios us_gere ON us_gere.id_usuario = pc.idGerente
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
        INNER JOIN residenciales resi ON resi.idResidencial = con.idResidencial 
        LEFT JOIN usuarios us ON us.id_usuario = pc.idAsesor
        WHERE
            pc.proceso = 3
        AND pc.status = 1 AND cli.status = 1";

        return $this->db->query($query)->result();
    }

    public function getListaDocumentosProyectoEjecutivo($idProcesoCasas){
        $query = "SELECT
            idProcesoCasas,
            idDocumento,
            CASE
                WHEN archivo IS NULL THEN 'Sin archivo'
                ELSE archivo
            END AS archivo,
            documento,
            fechaModificacion,
            tipo
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
        doc.documentos,
        con.nombre AS condominio,
        resi.descripcion AS proyecto,
        CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno) AS cliente,
        (CASE
            WHEN us.nombre IS NOT NULL THEN CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)
            ELSE 'Sin asignar'
        END) AS nombreAsesor,
        CASE
             WHEN pc.idGerente IS NULL THEN 'SIN ESPECIFICAR'
             ELSE CONCAT(us_gere.nombre, ' ', us_gere.apellido_paterno, ' ', us_gere.apellido_materno)
        END AS gerente,
        oxc.nombre AS movimiento
        FROM proceso_casas pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        LEFT JOIN (SELECT COUNT(*) AS documentos, idProcesoCasas FROM documentos_proceso_casas WHERE tipo IN (16) AND archivo IS NOT NULL GROUP BY idProcesoCasas) doc ON doc.idProcesoCasas = pc.idProcesoCasas
        INNER JOIN clientes cli ON cli.idLote = lo.idLote 
        LEFT JOIN usuarios us_gere ON us_gere.id_usuario = pc.idGerente
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
        INNER JOIN residenciales resi ON resi.idResidencial = con.idResidencial 
        LEFT JOIN usuarios us ON us.id_usuario = pc.idAsesor
        LEFT JOIN opcs_x_cats oxc ON oxc.id_catalogo = 136 AND oxc.id_opcion = pc.tipoMovimiento
        WHERE
            pc.proceso = 4
        AND pc.status = 1 AND cli.status = 1";

        return $this->db->query($query)->result();
    }

    public function getListaDocumentosComiteEjecutivo($idProcesoCasas){
        $query = "SELECT
            idProcesoCasas,
            idDocumento,
            CASE
                WHEN archivo IS NULL THEN 'Sin archivo'
                ELSE archivo
            END AS archivo,
            documento,
            tipo,
            fechaModificacion
        FROM documentos_proceso_casas
        WHERE
            idProcesoCasas = $idProcesoCasas
        AND tipo IN (13,14,15,16)";

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
        oxc.nombre AS notaria,
        pro.fechaElegida,
        pro.fechaFirma1,
        pro.fechaFirma2,
        pro.fechaFirma3,
        cpc.idCotizacion AS cotizacionElegida,
        con.nombre AS condominio,
        resi.descripcion AS proyecto,
        CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno) AS cliente,
        (CASE
            WHEN us.nombre IS NOT NULL THEN CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)
            ELSE 'Sin asignar'
        END) AS nombreAsesor,
        CASE
			 WHEN pc.idGerente IS NULL THEN 'SIN ESPECIFICAR'
			 ELSE CONCAT(us_gere.nombre, ' ', us_gere.apellido_paterno, ' ', us_gere.apellido_materno)
		END AS gerente,
        oxc2.nombre AS movimiento
        FROM proceso_casas pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        LEFT JOIN documentos_proceso_casas doc ON doc.idProcesoCasas = pc.idProcesoCasas AND tipo = 18
        LEFT JOIN propuestas_proceso_casas pro ON pro.idProcesoCasas = pc.idProcesoCasas AND pro.status = 1
        LEFT JOIN cotizacion_proceso_casas cpc ON cpc.idProcesoCasas = pc.idProcesoCasas AND cpc.idCotizacion = pc.cotizacionElegida
        LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = pc.notaria AND oxc.id_catalogo = 129
        INNER JOIN clientes cli ON cli.idLote = lo.idLote 
        LEFT JOIN usuarios us_gere ON us_gere.id_usuario = pc.idGerente
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
        INNER JOIN residenciales resi ON resi.idResidencial = con.idResidencial 
        LEFT JOIN usuarios us ON us.id_usuario = pc.idAsesor
        LEFT JOIN opcs_x_cats oxc2 ON oxc2.id_catalogo = 136 AND oxc2.id_opcion = pc.tipoMovimiento
        WHERE
            pc.proceso = 9
        	AND pc.status = 1 
            AND cli.status = 1";

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
        pro.fechaFirma1,
        pro.fechaFirma2,
        pro.fechaFirma3,
        CASE
            WHEN DATEDIFF(DAY, GETDATE() , pc.fechaProceso) < 0 THEN CAST(CONCAT(0, ' ', 'DIA(S)') AS VARCHAR) ELSE CAST(CONCAT(DATEDIFF(DAY, GETDATE() , pc.fechaProceso), ' ', 'DIA(S)') AS VARCHAR)
        END AS tiempoProceso,
        CASE WHEN cpc.archivos_faltantes > 0 THEN 0 ELSE 1 END AS cotizaciones,
        con.nombre AS condominio,
            resi.descripcion AS proyecto,
            CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno) AS cliente,
            (CASE
                WHEN us.nombre IS NOT NULL THEN CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)
                ELSE 'Sin asignar'
            END) AS nombreAsesor,
            CASE
                    WHEN pc.idGerente IS NULL THEN 'SIN ESPECIFICAR'
                    ELSE CONCAT(us_gere.nombre, ' ', us_gere.apellido_paterno, ' ', us_gere.apellido_materno)
            END AS gerente,
        oxc.nombre AS movimiento,
        doc.documentos,
        doc2.documentos AS constancia,
        doc3.idDocumento,
        doc3.documento,
        doc3.archivo,
        oxc2.nombre AS nombreArchivo
        FROM proceso_casas pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        LEFT JOIN propuestas_proceso_casas pro ON pro.idProcesoCasas = pc.idProcesoCasas AND pro.status = 1
        INNER JOIN clientes cli ON cli.idLote = lo.idLote 
        LEFT JOIN usuarios us_gere ON us_gere.id_usuario = pc.idGerente
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
        INNER JOIN residenciales resi ON resi.idResidencial = con.idResidencial 
        LEFT JOIN usuarios us ON us.id_usuario = pc.idAsesor
        LEFT JOIN (SELECT count(*) AS archivos_faltantes, idProcesoCasas FROM cotizacion_proceso_casas WHERE status = 1 AND archivo IS NULL GROUP BY idProcesoCasas) cpc ON cpc.idProcesoCasas = pc.idProcesoCasas
        LEFT JOIN opcs_x_cats oxc ON oxc.id_catalogo = 136 AND oxc.id_opcion = pc.tipoMovimiento
        LEFT JOIN (SELECT COUNT(*) AS documentos, idProcesoCasas FROM documentos_proceso_casas WHERE tipo IN (17) AND archivo IS NOT NULL GROUP BY idProcesoCasas) doc ON doc.idProcesoCasas = pc.idProcesoCasas
        LEFT JOIN (SELECT COUNT(*) AS documentos, idProcesoCasas FROM documentos_proceso_casas WHERE tipo IN (28) AND archivo IS NOT NULL GROUP BY idProcesoCasas) doc2 ON doc2.idProcesoCasas = pc.idProcesoCasas
        LEFT JOIN documentos_proceso_casas doc3 ON doc3.idProcesoCasas = pc.idProcesoCasas AND doc3.tipo = 28
        LEFT JOIN opcs_x_cats oxc2 ON oxc2.id_opcion = 28 AND oxc2.id_catalogo = 126
        WHERE
            pc.proceso = 8
        AND pc.status = 1 AND cli.status = 1";

        return $this->db->query($query)->result();
    }

    public function getListaCargaKitBancario(){
        $query = "SELECT
        pc.*,
        lo.nombreLote,
        con.nombre AS condominio,
        resi.descripcion AS proyecto,
        CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno) AS cliente,
        (CASE
            WHEN us.nombre IS NOT NULL THEN CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)
            ELSE 'Sin asignar'
        END) AS nombreAsesor,
        CASE
			 WHEN pc.idGerente IS NULL THEN 'SIN ESPECIFICAR'
			 ELSE CONCAT(us_gere.nombre, ' ', us_gere.apellido_paterno, ' ', us_gere.apellido_materno)
		END AS gerente,
        oxc2.nombre AS nombreArchivo,
        doc.documentos AS kit,
        doc2.idDocumento,
        doc2.documento,
        doc2.archivo,
        oxc.nombre AS movimiento
        FROM proceso_casas pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        INNER JOIN clientes cli ON cli.idLote = lo.idLote 
        LEFT JOIN usuarios us_gere ON us_gere.id_usuario = pc.idGerente
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
        INNER JOIN residenciales resi ON resi.idResidencial = con.idResidencial 
        LEFT JOIN usuarios us ON us.id_usuario = pc.idAsesor
        LEFT JOIN opcs_x_cats oxc ON oxc.id_catalogo = 136 AND oxc.id_opcion = pc.tipoMovimiento
        LEFT JOIN (SELECT COUNT(*) AS documentos, idProcesoCasas FROM documentos_proceso_casas WHERE tipo IN (31) AND archivo IS NOT NULL GROUP BY idProcesoCasas) doc ON doc.idProcesoCasas = pc.idProcesoCasas
        LEFT JOIN documentos_proceso_casas doc2 ON doc2.idProcesoCasas = pc.idProcesoCasas AND doc2.tipo = 31
        LEFT JOIN opcs_x_cats oxc2 ON oxc2.id_opcion = 31 AND oxc2.id_catalogo = 126
        WHERE
            pc.proceso = 11
        AND pc.status = 1 AND cli.status = 1";

        return $this->db->query($query)->result();
    }

    public function getListaValidaContraloria(){
        $query = " SELECT
        pc.*,
        lo.nombreLote,
        con.nombre AS condominio,
        resi.descripcion AS proyecto,
        CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno) AS cliente,
        (CASE
            WHEN us.nombre IS NOT NULL THEN CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)
            ELSE 'Sin asignar'
        END) AS nombreAsesor,
        CASE
			 WHEN pc.idGerente IS NULL THEN 'SIN ESPECIFICAR'
			 ELSE CONCAT(us_gere.nombre, ' ', us_gere.apellido_paterno, ' ', us_gere.apellido_materno)
		END AS gerente,
        oxc2.nombre AS nombreArchivo,
        doc2.idDocumento,
        doc2.documento,
        doc2.archivo,
        oxc.nombre AS movimiento
        FROM proceso_casas pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        INNER JOIN clientes cli ON cli.idLote = lo.idLote 
        LEFT JOIN usuarios us_gere ON us_gere.id_usuario = pc.idGerente
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
        INNER JOIN residenciales resi ON resi.idResidencial = con.idResidencial 
        LEFT JOIN usuarios us ON us.id_usuario = pc.idAsesor
        LEFT JOIN opcs_x_cats oxc ON oxc.id_catalogo = 136 AND oxc.id_opcion = pc.tipoMovimiento
        LEFT JOIN (SELECT COUNT(*) AS documentos, idProcesoCasas FROM documentos_proceso_casas WHERE tipo IN (30) AND archivo IS NOT NULL GROUP BY idProcesoCasas) doc ON doc.idProcesoCasas = pc.idProcesoCasas
        LEFT JOIN documentos_proceso_casas doc2 ON doc2.idProcesoCasas = pc.idProcesoCasas AND doc2.tipo = 30
        LEFT JOIN opcs_x_cats oxc2 ON oxc2.id_opcion = 30 AND oxc2.id_catalogo = 126
        WHERE
            pc.proceso = 10
        AND pc.status = 1 AND cli.status = 1";

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
            doc.documentos,
            con.nombre AS condominio,
            resi.descripcion AS proyecto,
            CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno) AS cliente,
            (CASE
                WHEN us.nombre IS NOT NULL THEN CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)
                ELSE 'Sin asignar'
            END) AS nombreAsesor,
            CASE
    			 WHEN pc.idGerente IS NULL THEN 'SIN ESPECIFICAR'
    			 ELSE CONCAT(us_gere.nombre, ' ', us_gere.apellido_paterno, ' ', us_gere.apellido_materno)
    		END AS gerente,
            oxc.nombre AS movimiento
        FROM proceso_casas pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        LEFT JOIN (SELECT COUNT(*) AS documentos, idProcesoCasas FROM documentos_proceso_casas WHERE tipo IN (19,20,21,22) AND archivo IS NOT NULL GROUP BY idProcesoCasas) doc ON doc.idProcesoCasas = pc.idProcesoCasas
        INNER JOIN clientes cli ON cli.idLote = lo.idLote 
        LEFT JOIN usuarios us_gere ON us_gere.id_usuario = pc.idGerente
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
        INNER JOIN residenciales resi ON resi.idResidencial = con.idResidencial 
        LEFT JOIN usuarios us ON us.id_usuario = pc.idAsesor
        LEFT JOIN opcs_x_cats oxc ON oxc.id_catalogo = 136 AND oxc.id_opcion = pc.tipoMovimiento
        WHERE
            pc.proceso = 8
        AND pc.status = 1 AND cli.status = 1";

        return $this->db->query($query)->result();
    }

    public function getListaContratos($idProcesoCasas){
        $tipos = "19, 20, 21, 22, 23, 24";

        // Usuarios de OOAM
        if(in_array($this->idUsuario, [15891, 15892, 15893])){
            $tipos = "23";
        }
        
        // Usuarios de PV
        if(in_array($this->idUsuario, [2896, 12072, 12112, 15900])){
            $tipos = "24";
        }

        // Usuarios de Titulacion
        if(in_array($this->idUsuario, [10846, 10849, 10862, 10865])){
            $tipos = "19, 20, 21, 22";
        }

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
        AND tipo IN ($tipos)";

        return $this->db->query($query)->result();
    }

    public function getListaRecepcionContratos(){
        $gerentes = implode(',', [$this->idUsuario]);

        if($this->idUsuario == 11650){
            $gerentes = implode(',', [671, 75, 207, 1853]);
        }

        $query = "SELECT
            pc.*,
            lo.nombreLote,
             con.nombre AS condominio,
            resi.descripcion AS proyecto,
            CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno) AS cliente,
            (CASE
                WHEN us.nombre IS NOT NULL THEN CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)
                ELSE 'Sin asignar'
            END) AS nombreAsesor,
            CASE
                 WHEN pc.idGerente IS NULL THEN 'SIN ESPECIFICAR'
                 ELSE CONCAT(us_gere.nombre, ' ', us_gere.apellido_paterno, ' ', us_gere.apellido_materno)
            END AS gerente,
            oxc.nombre AS movimiento,
            doc.documentos
        FROM proceso_casas pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        INNER JOIN clientes cli ON cli.idLote = lo.idLote 
        LEFT JOIN usuarios us_gere ON us_gere.id_usuario = pc.idGerente
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
        INNER JOIN residenciales resi ON resi.idResidencial = con.idResidencial 
        LEFT JOIN usuarios us ON us.id_usuario = pc.idAsesor
        LEFT JOIN opcs_x_cats oxc ON oxc.id_catalogo = 136 AND oxc.id_opcion = pc.tipoMovimiento
        LEFT JOIN (SELECT COUNT(*) AS documentos, idProcesoCasas FROM documentos_proceso_casas WHERE tipo IN (19,20,21,22) AND archivo IS NOT NULL GROUP BY idProcesoCasas) doc ON doc.idProcesoCasas = pc.idProcesoCasas
        WHERE
            pc.proceso IN (8,9)
        AND pc.status = 1
        AND cli.status = 1
        AND pc.idGerente IN ($gerentes)";

        return $this->db->query($query)->result();
    }

    public function getListaCierreCifras(){
        $query = "SELECT
            pc.*,
            lo.nombreLote,
            doc.archivo,
            doc.documento,
            doc.idDocumento,
            doc3.archivo AS kitBancario,
            con.nombre AS condominio,
	        resi.descripcion AS proyecto,
	        CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno) AS cliente,
	        (CASE
	            WHEN us.nombre IS NOT NULL THEN CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)
	            ELSE 'Sin asignar'
	        END) AS nombreAsesor,
	        CASE
				 WHEN pc.idGerente IS NULL THEN 'SIN ESPECIFICAR'
				 ELSE CONCAT(us_gere.nombre, ' ', us_gere.apellido_paterno, ' ', us_gere.apellido_materno)
			END AS gerente,
            oxc.nombre AS movimiento
        FROM proceso_casas pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        INNER JOIN clientes cli ON cli.idLote = lo.idLote 
        LEFT JOIN usuarios us_gere ON us_gere.id_usuario = pc.idGerente
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
        INNER JOIN residenciales resi ON resi.idResidencial = con.idResidencial 
        LEFT JOIN usuarios us ON us.id_usuario = pc.idAsesor
        LEFT JOIN documentos_proceso_casas doc ON doc.idProcesoCasas = pc.idProcesoCasas AND doc.tipo = 25
        LEFT JOIN (SELECT COUNT(*) AS documentos, idProcesoCasas FROM documentos_proceso_casas WHERE tipo IN (11) AND archivo IS NOT NULL GROUP BY idProcesoCasas) doc2 ON doc2.idProcesoCasas = pc.idProcesoCasas
        LEFT JOIN opcs_x_cats oxc ON oxc.id_catalogo = 136 AND oxc.id_opcion = pc.tipoMovimiento
        LEFT JOIN documentos_proceso_casas doc3 ON doc3.idProcesoCasas = pc.idProcesoCasas AND doc3.tipo = 31
        WHERE
            pc.proceso IN (11, 12)
        AND pc.status = 1 AND cli.status = 1";

        return $this->db->query($query)->result();
    }

    public function getListaVoBoCifras(){
        $query = "SELECT
            pc.*,
            lo.nombreLote,
            doc.archivo,
            doc.documento,
            doc.idDocumento,
            con.nombre AS condominio,
	        resi.descripcion AS proyecto,
	        CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno) AS cliente,
	        (CASE
	            WHEN us.nombre IS NOT NULL THEN CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)
	            ELSE 'Sin asignar'
	        END) AS nombreAsesor,
	        CASE
				 WHEN pc.idGerente IS NULL THEN 'SIN ESPECIFICAR'
				 ELSE CONCAT(us_gere.nombre, ' ', us_gere.apellido_paterno, ' ', us_gere.apellido_materno)
			END AS gerente,
            oxc.nombre AS movimiento
        FROM proceso_casas pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        INNER JOIN clientes cli ON cli.idLote = lo.idLote 
        LEFT JOIN documentos_proceso_casas doc ON doc.idProcesoCasas = pc.idProcesoCasas AND doc.tipo = 25
         LEFT JOIN usuarios us_gere ON us_gere.id_usuario = pc.idGerente
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
        INNER JOIN residenciales resi ON resi.idResidencial = con.idResidencial 
        LEFT JOIN usuarios us ON us.id_usuario = pc.idAsesor
        LEFT JOIN opcs_x_cats oxc ON oxc.id_catalogo = 136 AND oxc.id_opcion = pc.tipoMovimiento
        WHERE
            pc.proceso = 11
        AND pc.status = 1 AND cli.status = 1";

        return $this->db->query($query)->result();
    }

    public function getListaExpedienteCliente(){
        $query = "SELECT
            pc.*,
            lo.nombreLote,
            con.nombre AS condominio,
	        resi.descripcion AS proyecto,
	        CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno) AS cliente,
	        (CASE
	            WHEN us.nombre IS NOT NULL THEN CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)
	            ELSE 'Sin asignar'
	        END) AS nombreAsesor,
	        CASE
				 WHEN pc.idGerente IS NULL THEN 'SIN ESPECIFICAR'
				 ELSE CONCAT(us_gere.nombre, ' ', us_gere.apellido_paterno, ' ', us_gere.apellido_materno)
			END AS gerente,
            oxc.nombre AS movimiento
        FROM proceso_casas pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        INNER JOIN clientes cli ON cli.idLote = lo.idLote 
        LEFT JOIN usuarios us_gere ON us_gere.id_usuario = pc.idGerente
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
        INNER JOIN residenciales resi ON resi.idResidencial = con.idResidencial 
        LEFT JOIN usuarios us ON us.id_usuario = pc.idAsesor
        LEFT JOIN opcs_x_cats oxc ON oxc.id_catalogo = 136 AND oxc.id_opcion = pc.tipoMovimiento
        WHERE
            pc.proceso = 12
        AND pc.status = 1 AND cli.status = 1";

        return $this->db->query($query)->result();
    }

    public function getListaEnvioAFirma(){
        $query = "SELECT
            pc.*,
            lo.nombreLote,
            con.nombre AS condominio,
            resi.descripcion AS proyecto,
            CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno) AS cliente,
            (CASE
                WHEN us.nombre IS NOT NULL THEN CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)
                ELSE 'Sin asignar'
            END) AS nombreAsesor,
            CASE
                 WHEN pc.idGerente IS NULL THEN 'SIN ESPECIFICAR'
                 ELSE CONCAT(us_gere.nombre, ' ', us_gere.apellido_paterno, ' ', us_gere.apellido_materno)
            END AS gerente,
            oxc.nombre AS movimiento
        FROM proceso_casas pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        INNER JOIN clientes cli ON cli.idLote = lo.idLote 
        LEFT JOIN usuarios us_gere ON us_gere.id_usuario = pc.idGerente
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
        INNER JOIN residenciales resi ON resi.idResidencial = con.idResidencial 
        LEFT JOIN usuarios us ON us.id_usuario = pc.idAsesor
        LEFT JOIN opcs_x_cats oxc ON oxc.id_catalogo = 136 AND oxc.id_opcion = pc.tipoMovimiento
        WHERE
            pc.proceso = 13
        AND pc.status = 1 AND cli.status = 1";

        return $this->db->query($query)->result();
    }

    public function getListaFirmaContrato(){
        $query = "SELECT
            pc.*,
            lo.nombreLote,
            con.nombre AS condominio,
	        resi.descripcion AS proyecto,
	        CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno) AS cliente,
	        (CASE
	            WHEN us.nombre IS NOT NULL THEN CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)
	            ELSE 'Sin asignar'
	        END) AS nombreAsesor,
	        CASE
				 WHEN pc.idGerente IS NULL THEN 'SIN ESPECIFICAR'
				 ELSE CONCAT(us_gere.nombre, ' ', us_gere.apellido_paterno, ' ', us_gere.apellido_materno)
			END AS gerente,
            oxc.nombre AS movimiento
        FROM proceso_casas pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        INNER JOIN clientes cli ON cli.idLote = lo.idLote 
        LEFT JOIN usuarios us_gere ON us_gere.id_usuario = pc.idGerente
	    INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
	    INNER JOIN residenciales resi ON resi.idResidencial = con.idResidencial 
	    LEFT JOIN usuarios us ON us.id_usuario = pc.idAsesor
        LEFT JOIN opcs_x_cats oxc ON oxc.id_catalogo = 136 AND oxc.id_opcion = pc.tipoMovimiento
        WHERE
            pc.proceso = 14
        AND pc.status = 1 AND cli.status = 1";

        return $this->db->query($query)->result();
    }

    public function getListaRecepcionContrato(){
        $gerentes = implode(',', [$this->idUsuario]);

        if($this->idUsuario == 11650){
            $gerentes = implode(',', [671, 75, 207, 1853]);
        }

        $query = "SELECT
            pc.*,
            lo.nombreLote,
            con.nombre AS condominio,
    	    resi.descripcion AS proyecto,
    	    CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno) AS cliente,
	        (CASE
	            WHEN us.nombre IS NOT NULL THEN CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)
	            ELSE 'Sin asignar'
	        END) AS nombreAsesor,
	        CASE
				 WHEN pc.idGerente IS NULL THEN 'SIN ESPECIFICAR'
				 ELSE CONCAT(us_gere.nombre, ' ', us_gere.apellido_paterno, ' ', us_gere.apellido_materno)
			END AS gerente,
            oxc.nombre AS movimiento
        FROM proceso_casas pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        INNER JOIN clientes cli ON cli.idLote = lo.idLote 
        LEFT JOIN usuarios us_gere ON us_gere.id_usuario = pc.idGerente
	    INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
	    INNER JOIN residenciales resi ON resi.idResidencial = con.idResidencial 
	    LEFT JOIN usuarios us ON us.id_usuario = pc.idAsesor
        LEFT JOIN opcs_x_cats oxc ON oxc.id_catalogo = 136 AND oxc.id_opcion = pc.tipoMovimiento
        WHERE
            pc.proceso = 15
        AND pc.status = 1
        AND cli.status = 1
        AND pc.idGerente IN ($gerentes)";

        return $this->db->query($query)->result();
    }

    public function getListaFinalizar($in){
        $query = "SELECT
            pc.*,
            lo.nombreLote,
            con.nombre AS condominio,
            resi.descripcion AS proyecto,
            CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno) AS cliente,
            (CASE
                WHEN us.nombre IS NOT NULL THEN CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)
                ELSE 'Sin asignar'
            END) AS nombreAsesor,
            CASE
                 WHEN pc.idGerente IS NULL THEN 'SIN ESPECIFICAR'
                 ELSE CONCAT(us_gere.nombre, ' ', us_gere.apellido_paterno, ' ', us_gere.apellido_materno)
            END AS gerente,
            oxc.nombre AS movimiento
        FROM proceso_casas pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        INNER JOIN clientes cli ON cli.idLote = lo.idLote 
        LEFT JOIN usuarios us_gere ON us_gere.id_usuario = pc.idGerente
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
        INNER JOIN residenciales resi ON resi.idResidencial = con.idResidencial 
        LEFT JOIN usuarios us ON us.id_usuario = pc.idAsesor
        LEFT JOIN opcs_x_cats oxc ON oxc.id_catalogo = 136 AND oxc.id_opcion = pc.tipoMovimiento
        WHERE
            pc.proceso = 16
        AND pc.finalizado IN ($in)
        AND pc.status = 1 AND cli.status = 1";

        return $this->db->query($query)->result();
    }

    public function markProcesoFinalizado($idProcesoCasas){
        $query = "UPDATE proceso_casas
        SET
            finalizado = 1,
            tipoMovimiento = 3,
            fechaProceso = GETDATE()
        WHERE
            idProcesoCasas = $idProcesoCasas";

        return $this->db->query($query);
    }

    public function setAdeudo($idProcesoCasas, $adeudo, $cantidad){
        $query = "UPDATE proceso_casas
        SET $adeudo = $cantidad
        WHERE idProcesoCasas = $idProcesoCasas";

        return $this->db->query($query);
    }

    public function setProceso3($idProcesoCasas){
        $query = "UPDATE proceso_casas
        SET proceso = 3
        WHERE idProcesoCasas = $idProcesoCasas";

        return $this->db->query($query);
    }

    public function getAdeudosValid($idProcesoCasas){
        $query = "SELECT adeudoOOAM, adeudoADM 
        FROM proceso_casas 
        WHERE idProcesoCasas = $idProcesoCasas AND adeudoOOAM IS NOT null AND adeudoADM IS NOT null";

        return $this->db->query($query);
    }

    public function getCotizaciones($idProcesoCasas){

        $query = "SELECT
            cpc.idCotizacion,
            cpc.idProcesoCasas,
            cpc.archivo,
            CASE
                 WHEN cpc.nombre IS NULL THEN 'COTIZACIÓN NO SUBIDA'
                 ELSE cpc.nombre
            END AS nombre
        FROM cotizacion_proceso_casas cpc
        WHERE
            cpc.idProcesoCasas = $idProcesoCasas
        AND status = 1";

        return $this->db->query($query)->result();
    }

    public function addPropuesta($idProcesoCasas){
        $query = "UPDATE propuestas_proceso_casas
        SET
            status = 0,
            idModificacion = $this->idUsuario,
            fechaModificacion = GETDATE()
        WHERE
            idProcesoCasas = $idProcesoCasas";

        $this->db->query($query);

        $query = "INSERT INTO propuestas_proceso_casas
        (
            idProcesoCasas,
            idCreacion,
            idModificacion,
            fechaModificacion
        )
        VALUES
        (
            $idProcesoCasas,
            $this->idUsuario,
            $this->idUsuario,
            GETDATE()
        )";

        return $this->db->query($query);
    }

    public function removeCotizaciones($idProcesoCasas){
        $query = "UPDATE cotizacion_proceso_casas
        SET
            status = 0,
            idModificacion = $this->idUsuario,
            fechaModificacion = GETDATE()
        WHERE
            idProcesoCasas = $idProcesoCasas";

        $this->db->query($query);
    }

    public function addCotizacion($idProcesoCasas){
        $idModificacion = $this->session->userdata('id_usuario');

        $query = "INSERT INTO cotizacion_proceso_casas
        (
            idProcesoCasas,
            idCreacion,
            idModificacion,
            fechaModificacion
        )
        VALUES
        (
            $idProcesoCasas,
            $idModificacion,
            $idModificacion,
            GETDATE()
        )";

        return $this->db->query($query);
    }

    public function getProuesta($idProcesoCasas){

        $query = "SELECT * FROM propuestas_proceso_casas WHERE idProcesoCasas = $idProcesoCasas";

        return $this->db->query($query);
    }

    public function updatePropuesta($idProcesoCasas, $fechaFirma1, $fechaFirma2, $fechaFirma3){
        
        $query = "UPDATE propuestas_proceso_casas
        SET
            fechaFirma1 = NULLIF('$fechaFirma1', ''),
            fechaFirma2 = NULLIF('$fechaFirma2', ''),
            fechaFirma3 = NULLIF('$fechaFirma3', '')
        WHERE
            idProcesoCasas = $idProcesoCasas";

        return $this->db->query($query);
    }

    public function setPropuesta($idProcesoCasas, $idPropuesta, $fechaElegida, $idCotizacion ){
        $query = "UPDATE propuestas_proceso_casas
        SET
            fechaElegida = $fechaElegida
        WHERE
            idProcesoCasas = $idProcesoCasas
        AND idPropuesta = $idPropuesta
        AND status = 1";

        $this->db->query($query);

        $query = "UPDATE proceso_casas
        SET
            cotizacionElegida = $idCotizacion
        WHERE
            idProcesoCasas = $idProcesoCasas";

        return $this->db->query($query);
    }

    public function setTipoCredito($idProcesoCasas, $tipoCredito, $notaria){
        $query = "UPDATE proceso_casas
        SET
            tipoCredito = $tipoCredito,
            notaria = $notaria
        WHERE
            idProcesoCasas = $idProcesoCasas";

        return $this->db->query($query);
    }

    public function updateCotizacion($idCotizacion, $nombre, $archivo){
        $query = "UPDATE cotizacion_proceso_casas
        SET
            nombre = '$nombre',
            archivo = NULLIF('$archivo', '')
        WHERE
            idCotizacion = $idCotizacion";

        return $this->db->query($query);
    }

    public function getListaReporteCasas($proceso, $finalizado){
        $query = " SELECT
            pc.*,
            lo.nombreLote,
            con.nombre AS condominio,
            resi.descripcion AS proyecto,
            CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno) AS cliente,
            (CASE
                WHEN us.nombre IS NOT NULL THEN CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)
                ELSE 'Sin asignar'
            END) AS nombreAsesor,
            CASE
                 WHEN pc.idGerente IS NULL THEN 'SIN ESPECIFICAR'
                 ELSE CONCAT(us_gere.nombre, ' ', us_gere.apellido_paterno, ' ', us_gere.apellido_materno)
            END AS gerente,
            oxc.nombre AS procesoNombre,
            oxc2.nombre AS movimiento
        FROM proceso_casas pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        INNER JOIN clientes cli ON cli.idLote = lo.idLote 
        LEFT JOIN usuarios us_gere ON us_gere.id_usuario = pc.idGerente
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
        INNER JOIN residenciales resi ON resi.idResidencial = con.idResidencial 
        LEFT JOIN usuarios us ON us.id_usuario = pc.idAsesor
        LEFT JOIN opcs_x_cats oxc ON oxc.id_catalogo = 135 AND oxc.id_opcion = pc.proceso
        LEFT JOIN opcs_x_cats oxc2 ON oxc2.id_catalogo = 136 AND oxc2.id_opcion = pc.tipoMovimiento
        WHERE
            pc.status = 1
        AND cli.status = 1
        AND pc.proceso IN ($proceso)
        AND pc.finalizado IN ($finalizado)
        ORDER BY pc.fechaCreacion";

        return $this->db->query($query)->result();
    }

    public function getListaHistorial($idProcesoCasas){
        $query = " SELECT
            h.*,
            CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) AS usuarioMovimiento
        FROM historial_proceso_casas h
        LEFT JOIN usuarios us ON h.idMovimiento = us.id_usuario
        WHERE
            idProcesoCasas = $idProcesoCasas";

        return $this->db->query($query)->result();
    }

    public function getProcesosOptions(){
        $query = "SELECT
            id_opcion AS value,
            nombre AS label
        FROM opcs_x_cats
        WHERE
            id_catalogo = 135
        AND estatus = 1";

        return $this->db->query($query)->result();
    }

    public function getListaArchivosTitulos($idProcesoCasas){
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
        AND tipo IN (17)";

        return $this->db->query($query)->result();
    }

    public function setVoboToProceso($idProcesoCasas, $column){
        $query = "UPDATE proceso_casas
        SET
            $column = 1
        WHERE
            idProcesoCasas = $idProcesoCasas";

        return $this->db->query($query);
    }

    public function resetVoBos($idProcesoCasas){
        $query = "UPDATE proceso_casas
        SET
            voboADM = NULL,
            voboOOAM = NULL,
            voboGPH = NULL,
            voboPV = NULL
        WHERE
            idProcesoCasas = $idProcesoCasas";

        return $this->db->query($query);
    }

    public function lotesCreditoDirecto($proceso, $tipoDocumento){

        $procesoArray = explode(',', $proceso);
        $placeholders = implode(',', array_fill(0, count($procesoArray), '?'));

        $query = $this->db->query("SELECT 
            pcd.*,
            oxc.color,
            oxc.nombre AS nombreMovimiento,
            CASE
                WHEN DATEDIFF(DAY, GETDATE() , pcd.fechaAvance) < 0 THEN CAST(CONCAT(0, ' ', 'DIA(S)') AS VARCHAR) ELSE CAST(CONCAT(DATEDIFF(DAY, GETDATE() , pcd.fechaAvance), ' ', 'DIA(S)') AS VARCHAR)
            END AS tiempoProceso,
            lo.idLote,  
            lo.nombreLote,
            co.nombre AS condominio,
            re.descripcion AS proyecto,
			dpc.archivo,
            dpc.documento
        FROM proceso_casas_directo pcd
        INNER JOIN lotes lo ON lo.idLote = pcd.idLote
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = pcd.tipoMovimiento AND id_catalogo = 108
		LEFT JOIN documentos_proceso_credito_directo dpc ON dpc.idProceso = pcd.idProceso AND dpc.tipo IN($tipoDocumento)
        WHERE pcd.proceso IN ($placeholders) AND pcd.estatus IN(1) AND pcd.finalizado = 0", $procesoArray, 1);

        return $query;
    }

    public function getDocumentoCreditoDirecto($id_documento){
        $query = $this->db->query("SELECT * FROM opcs_x_cats 
        WHERE id_catalogo = 149 AND id_opcion = ?", $id_documento);

        return $query;
    }

    public function insertDocProcesoCreditoDirecto($idProceso, $name_documento, $filename, $id_documento, $tipoDocumento){
        
        if($tipoDocumento === 0){
            $query = "INSERT INTO documentos_proceso_credito_directo
            (
                idProceso,
                documento,
                archivo,
                tipo
            )
            VALUES
            (
                $idProceso,
                '$name_documento',
                '$filename',
                $id_documento
            )";
        }else{
            $query = "UPDATE documentos_proceso_credito_directo 
            SET documento = '$name_documento', archivo = '$filename' 
            WHERE idProceso = $idProceso AND tipo = $id_documento";
        }

        return $this->db->query($query);
    }

    public function getReporteProcesoCredito($proceso, $finalizado){
        $query = "SELECT
            pcd.idProceso,
            lo.idLote,  
            lo.nombreLote,
            pcd.estatus,
            pcd.proceso,
            pcd.comentario,
            pcd.voBoOrdenCompra,
            pcd.voBoAdeudoTerreno,
            pcd.voBoValidacionEnganche,
            pcd.voBoContrato,
            pcd.adeudo,
            co.nombre AS condominio,
            re.descripcion AS proyecto,
            pcd.voBoOrdenCompra,
            pcd.voBoValidacionEnganche,
            pcd.voBoContrato,
            pcd.voBoOrdenCompra,
            pcd.finalizado,
            oxc.color,
            oxc.nombre AS nombreMovimiento,
            CASE
                WHEN DATEDIFF(DAY, GETDATE() , pcd.fechaAvance) < 0 THEN CAST(CONCAT(0, ' ', 'DIA(S)') AS VARCHAR) ELSE CAST(CONCAT(DATEDIFF(DAY, GETDATE() , pcd.fechaAvance), ' ', 'DIA(S)') AS VARCHAR)
            END AS tiempoProceso,
            CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno) AS nombreCliente,
            CONCAT(usA.nombre, ' ', usA.apellido_paterno, ' ', usA.apellido_materno) AS nombreAsesor,
            CONCAT(usG.nombre, ' ', usG.apellido_paterno, ' ', usG.apellido_materno) AS nombreGerente,
            CASE
                WHEN pcd.idAsesor IS NULL AND pcd.proceso = 0 THEN 'ASIGNACIÓN DE ASESOR'
                ELSE oxc2.nombre
            END AS nombreProceso,
            pcd.fechaCreacion,
            pcd.fechaAvance
        FROM proceso_casas_directo pcd
        INNER JOIN lotes lo ON lo.idLote = pcd.idLote
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente
        INNER JOIN usuarios usA ON usA.id_usuario = cl.id_asesor
        INNER JOIN usuarios usG ON usG.id_usuario = cl.id_gerente
        LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = pcd.tipoMovimiento AND oxc.id_catalogo = 108
        LEFT JOIN opcs_x_cats oxc2 ON oxc2.id_opcion = pcd.proceso AND oxc2.id_catalogo = 150
        WHERE pcd.proceso IN ($proceso)
        AND pcd.finalizado IN ($finalizado)";

        return $this->db->query($query)->result();
    }

    public function getHistorialCreditoActual($idProceso, $tipoEsquema)
    {
        $query = $this->db->query("SELECT 
	        hpc.*,
	        CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno, ' (', oxc.nombre, ')' ) as nombreUsuario
	        FROM historial_proceso_casas hpc
	        INNER JOIN usuarios us ON us.id_usuario = hpc.idMovimiento
            INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = us.id_rol AND oxc.id_catalogo = 1
	        WHERE idProcesoCasas = ?
	        AND esquemaCreditoProceso = ?", array($idProceso, $tipoEsquema));
            
        return $query->result_array();
    }

    public function getProcesosOptionsDirecto(){
        $query = "SELECT
            id_opcion AS value,
            nombre AS label
        FROM opcs_x_cats
        WHERE
            id_catalogo = 150
        AND estatus = 1";

        return $this->db->query($query)->result();
    }

    public function getLotesProcesoBanco($proceso, $tipoDocumento, $condicionExtra){
        $procesoArray = explode(',', $proceso);
        $placeholders = implode(',', array_fill(0, count($procesoArray), '?'));

        $query = $this->db->query("SELECT
            pc.*,
            oxc.color,
            oxc.nombre AS nombreMovimiento,
            CASE
                WHEN DATEDIFF(DAY, GETDATE() , pc.fechaProceso) < 0 THEN CAST(CONCAT('LLEVA', ' ', 0, ' ', 'DIA(S)') AS VARCHAR) ELSE CAST(CONCAT(DATEDIFF(DAY, GETDATE() , pc.fechaProceso), ' ', 'DIA(S)') AS VARCHAR)
            END AS tiempoProceso,
            lo.idLote,  
            lo.nombreLote,
            co.nombre AS condominio,
            re.descripcion AS proyecto,
			dpc.archivo,
            dpc.documento,
            dpc.tipo,
            CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno) AS nombreCliente,
            CONCAT(usA.nombre, ' ', usA.apellido_paterno, ' ', usA.apellido_materno) AS nombreAsesor,
            CONCAT(usG.nombre, ' ', usG.apellido_paterno, ' ', usG.apellido_materno) AS nombreGerente,
            pc.tipoMovimiento
        FROM proceso_casas pc
        INNER JOIN lotes lo ON lo.idLote = pc.idLote
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        INNER JOIN usuarios usA ON usA.id_usuario = cl.id_asesor 
        INNER JOIN usuarios usG ON usG.id_usuario = cl.id_gerente 
        LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = pc.tipoMovimiento AND id_catalogo = 136
		LEFT JOIN documentos_proceso_casas dpc ON dpc.idProcesoCasas = pc.idProcesoCasas AND dpc.tipo IN($tipoDocumento)
        WHERE pc.proceso IN ($placeholders) AND pc.status IN(1) AND pc.finalizado = 0 $condicionExtra", $procesoArray, 1);

        return $query;
    }

    public function getDocumentoCreditoBanco($id_documento){
        $query = $this->db->query("SELECT *FROM opcs_x_cats 
        WHERE id_catalogo = 126 AND id_opcion = ?", $id_documento);

        return $query;
    }

    public function insertDocProcesoCreditoBanco($idProceso, $name_documento, $filename, $id_documento, $tipoDocumento, $id_usuario){
        if($tipoDocumento === 0){
            $query = "INSERT INTO documentos_proceso_casas
            (
                idProcesoCasas,
                documento,
                archivo,
                tipo,
                fechaCreacion,
                creadoPor,
                fechaModificacion,
                idModificacion
            )
            VALUES
            (
                $idProceso,
                '$name_documento',
                '$filename',
                $id_documento,
                GETDATE(),
                $id_usuario,
                GETDATE(),
                $id_usuario
            )";
        }else{
            $query = "UPDATE documentos_proceso_casas
            SET archivo = '$filename', fechaModificacion = GETDATE(), idModificacion = '$id_usuario'
            WHERE idProcesoCasas = $idProceso AND tipo = $id_documento";
        }

        return $this->db->query($query);
    }

    public function setVoBoSaldos($columna, $idProcesoCasas, $idUsuario){
        $query = $this->db->query("UPDATE proceso_casas SET ". $columna ." = ?, fechaProceso = GETDATE(), fechaModificacion = GETDATE(), modificadoPor = ? WHERE idProcesoCasas = ?", array(1, $idUsuario, $idProcesoCasas));

        return $query;
    }

    public function getDocumentosProveedor($idProcesoCasas){
        $query = "SELECT
            idProcesoCasas,
            idDocumento,
            CASE
                WHEN archivo IS NULL THEN 'Sin archivo'
                ELSE archivo
            END AS archivo,
            documento,
            tipo,
            fechaModificacion
        FROM documentos_proceso_casas
        WHERE
            idProcesoCasas = $idProcesoCasas
        AND tipo IN (39,40,41,42,43,44,45,46,47,48)";

        return $this->db->query($query)->result();
    }

    public function getDocumentosContratos($idProcesoCasas){
        $query = "SELECT
            idProcesoCasas,
            idDocumento,
            CASE
                WHEN archivo IS NULL THEN 'Sin archivo'
                ELSE archivo
            END AS archivo,
            documento,
            tipo,
            fechaModificacion
        FROM documentos_proceso_casas
        WHERE
            idProcesoCasas = $idProcesoCasas
        AND tipo IN (33, 34, 35)";

        return $this->db->query($query)->result();
    }

    public function countDocumentos($documentos, $proceso){
        $documentosArray = explode(',', $documentos);
        $placeholders = implode(',', array_fill(0, count($documentosArray), '?'));

        $query = $this->db->query("SELECT 
        pc.*,
        oxc.color,
        oxc.nombre AS nombreMovimiento,
        CASE
            WHEN DATEDIFF(DAY, GETDATE() , pc.fechaProceso) < 0 THEN CAST(CONCAT('LLEVA', ' ', 0, ' ', 'DIA(S)') AS VARCHAR) ELSE CAST(CONCAT(DATEDIFF(DAY, GETDATE() , pc.fechaProceso), ' ', 'DIA(S)') AS VARCHAR)
        END AS tiempoProceso,
        CASE
            WHEN pc.adeudoOOAM IS NULL THEN 'Sin registro'
            ELSE CONCAT('$', pc.adeudoOOAM) 
        END AS adOOAM,
        lo.nombreLote,
        con.nombre AS condominio,
        resi.descripcion AS proyecto,
        CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno) AS cliente,
        CASE
            WHEN us.nombre IS NOT NULL THEN CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)
            ELSE 'Sin asignar'
        END AS nombreAsesor,
        CASE
            WHEN pc.idGerente IS NULL THEN 'SIN ESPECIFICAR'
            ELSE CONCAT(us_gere.nombre, ' ', us_gere.apellido_paterno, ' ', us_gere.apellido_materno)
        END AS gerente,
        oxc.nombre AS movimiento,
        doc2.documentos,
        CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno) AS nombreCliente,
        CONCAT(usA.nombre, ' ', usA.apellido_paterno, ' ', usA.apellido_materno) AS nombreAsesor,
        CONCAT(usG.nombre, ' ', usG.apellido_paterno, ' ', usG.apellido_materno) AS nombreGerente,
        pc.tipoMovimiento
    FROM 
        proceso_casas pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        INNER JOIN clientes cli ON cli.idLote = lo.idLote 
        LEFT JOIN usuarios us_gere ON us_gere.id_usuario = pc.idGerente
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
        INNER JOIN residenciales resi ON resi.idResidencial = con.idResidencial
        INNER JOIN usuarios usA ON usA.id_usuario = cli.id_asesor 
        INNER JOIN usuarios usG ON usG.id_usuario = cli.id_gerente 
        LEFT JOIN usuarios us ON us.id_usuario = pc.idAsesor
        LEFT JOIN opcs_x_cats oxc ON oxc.id_catalogo = 136 AND oxc.id_opcion = pc.tipoMovimiento
        LEFT JOIN (SELECT COUNT(*) AS documentos, idProcesoCasas FROM documentos_proceso_casas WHERE tipo IN (".$placeholders.") AND archivo IS NOT NULL GROUP BY idProcesoCasas) doc2 ON doc2.idProcesoCasas = pc.idProcesoCasas
    WHERE 
        pc.proceso IN (". $proceso .")
        AND pc.status = 1 
        AND cli.status = 1", $documentosArray);

        return $query->result();
    }

    public function getListaDocumentosClienteCompleto($idProcesoCasas){
        $query = "SELECT
            idProcesoCasas,
            idDocumento,
            CASE
                WHEN archivo IS NULL THEN 'Sin archivo'
                ELSE archivo
            END AS archivo,
            documento,
            tipo,
            fechaModificacion
        FROM documentos_proceso_casas
        WHERE
            idProcesoCasas = $idProcesoCasas
        AND tipo IN (2, 4, 5, 6, 7, 8, 9, 10, 11, 12, 23, 36, 37, 38)";

        return $this->db->query($query)->result();
    }
}


   