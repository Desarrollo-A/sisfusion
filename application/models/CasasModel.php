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
            idModificacion = $idModificacion,
            tipoMovimiento = $tipoMovimiento
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
        AND cli.status = 1";

        return $this->db->query($query)->result();
    }

    public function getListaAsignacion(){
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
            AND cli.status = 1";

        return $this->db->query($query)->result();
    }

    public function addLoteToAsignacion($idLote, $idGerente, $comentario){
        $query = "INSERT INTO proceso_casas
        (
            idLote,
            idGerente,
            comentario
        )
        VALUES
        (
            $idLote,
            $idGerente,
            '$comentario'
        )";

        $result = $this->db->query($query);

        if($result){
            $query = "SELECT TOP 1 * FROM proceso_casas ORDER BY idProcesoCasas DESC";
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
            estatus = 1
        AND id_rol = 3
        AND tipo = 2";

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
        AND id_rol = 7";

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

    public function getListaConcentradoAdeudos(){
        $query = "SELECT pc.*,
        CASE
            WHEN pc.adeudoOOAM IS NULL THEN 'Sin registro'
            ELSE CONCAT('$', pc.adeudoOOAM) 
        END AS adOOAM,
        CASE
            WHEN pc.adeudoADM IS NULL THEN 'Sin registro'
            ELSE CONCAT('$', pc.adeudoADM) 
        END AS adADM,
        CASE
            WHEN pc.adeudoGPH IS NULL THEN 'Sin registro'
            ELSE CONCAT('$', pc.adeudoGPH) 
        END AS adGPH,
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
        WHERE pc.proceso = 2 AND pc.status = 1 AND cli.status = 1";

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
        LEFT JOIN (SELECT COUNT(*) AS documentos, idProcesoCasas FROM documentos_proceso_casas WHERE tipo IN (2,3,4,5,6,7,8,10,11,12,13,14,15,27) AND archivo IS NOT NULL GROUP BY idProcesoCasas) doc ON doc.idProcesoCasas = pc.idProcesoCasas
        INNER JOIN clientes cli ON cli.idLote = lo.idLote 
        LEFT JOIN usuarios us_gere ON us_gere.id_usuario = pc.idGerente
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
        INNER JOIN residenciales resi ON resi.idResidencial = con.idResidencial 
        LEFT JOIN usuarios us ON us.id_usuario = pc.idAsesor
        LEFT JOIN opcs_x_cats oxc ON oxc.id_catalogo = 136 AND oxc.id_opcion = pc.tipoMovimiento
        WHERE
            pc.proceso = 3
        AND pc.status = 1 AND cli.status = 1";

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
        AND tipo IN (2,3,4,5,6,7,8,9,10,11,12,13,14,15,26,23,27)";

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

    /*
    public function getListaCargaTitulos(){
        $query = "SELECT
        pc.*,
        lo.nombreLote,
        doc.archivo,
        doc.documento,
        doc.idDocumento,
        pro.propuestas,
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
        LEFT JOIN documentos_proceso_casas doc ON doc.idProcesoCasas = pc.idProcesoCasas AND tipo = 17
        LEFT JOIN 
            (SELECT COUNT(*) AS propuestas, idProcesoCasas 
            FROM propuestas_proceso_casas 
            GROUP BY idProcesoCasas) pro ON pro.idProcesoCasas = pc.idProcesoCasas
        INNER JOIN clientes cli ON cli.idLote = lo.idLote 
        LEFT JOIN usuarios us_gere ON us_gere.id_usuario = pc.idGerente
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
        INNER JOIN residenciales resi ON resi.idResidencial = con.idResidencial 
        LEFT JOIN usuarios us ON us.id_usuario = pc.idAsesor
        WHERE
            pc.proceso = 5
        AND pc.status = 1 AND cli.status = 1";

        return $this->db->query($query)->result();
    }
    */

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
            pc.proceso = 6
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
        doc.documentos
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
        WHERE
            pc.proceso = 5
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
            pc.proceso = 7
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
        AND pc.status = 1 AND cli.status = 1";

        return $this->db->query($query)->result();
    }

    public function getListaCierreCifras(){
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
        LEFT JOIN usuarios us_gere ON us_gere.id_usuario = pc.idGerente
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
        INNER JOIN residenciales resi ON resi.idResidencial = con.idResidencial 
        LEFT JOIN usuarios us ON us.id_usuario = pc.idAsesor
        LEFT JOIN documentos_proceso_casas doc ON doc.idProcesoCasas = pc.idProcesoCasas AND doc.tipo = 25
        LEFT JOIN opcs_x_cats oxc ON oxc.id_catalogo = 136 AND oxc.id_opcion = pc.tipoMovimiento
        WHERE
            pc.proceso = 10
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
        AND pc.status = 1 AND cli.status = 1";

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

    public function setAdeudo($idProcesoCasas, $adeudoOoam, $adeudoAdm, $adeudoGph){
        $query = "UPDATE proceso_casas
                  SET adeudoOOAM = $adeudoOoam, adeudoADM = $adeudoAdm, adeudoGPH = $adeudoGph
                  WHERE idProcesoCasas = $idProcesoCasas";

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

    public function updatePropuesta($idPropuesta, $fechaFirma1, $fechaFirma2, $fechaFirma3){
        $query = "UPDATE propuestas_proceso_casas
        SET
            fechaFirma1 = NULLIF('$fechaFirma1', ''),
            fechaFirma2 = NULLIF('$fechaFirma2', ''),
            fechaFirma3 = NULLIF('$fechaFirma3', '')
        WHERE
            idPropuesta = $idPropuesta";

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
        AND tipo IN (17, 28, 29, 30, 31, 32)";

        return $this->db->query($query)->result();
    }
}