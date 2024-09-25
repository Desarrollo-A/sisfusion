<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class PagosCasasModel extends CI_Model
{
    private $idUsuario;

    function __construct(){
        parent::__construct();

        $this->load->library(['session']);

        $this->idUsuario = $this->session->userdata('id_usuario');
    }

    public function getProceso($idProcesoPagos){
        $query = "SELECT
            pp.*,
            lo.nombreLote
        FROM proceso_pagos pp
        LEFT JOIN lotes lo ON lo.idLote = pp.idLote
        WHERE
            pp.idProcesoPagos = $idProcesoPagos";
        return $this->db->query($query)->row();
    }

    public function setProcesoTo($idProcesoPagos, $proceso, $comentario){
        $query = "UPDATE proceso_pagos
        SET
            proceso = $proceso,
            comentario = '$comentario',
            fechaProceso = GETDATE(),
            fechaModificacion = GETDATE(),
            idModificacion = $this->idUsuario
        WHERE
            idProcesoPagos = $idProcesoPagos";

        return $this->db->query($query);
    }

    public function getListaIniciarProceso(){
        $query = "SELECT
            pc.*,
            pp.idProcesoPagos,
            pp.montoDepositado,
            lo.nombreLote,
            con.nombre AS condominio,
            resi.descripcion AS proyecto,
            CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno) AS cliente,
            (CASE
                WHEN us.nombre IS NOT NULL THEN CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)
                ELSE 'Sin asignar'
            END) AS nombreAsesor,
            CASE
                    WHEN cli.id_gerente_c IS NULL THEN 'SIN ESPECIFICAR'
                    ELSE CONCAT(us_gere.nombre, ' ', us_gere.apellido_paterno, ' ', us_gere.apellido_materno)
            END AS gerente,
            doc.archivo
            FROM proceso_casas_banco pc
            LEFT JOIN lotes lo ON lo.idLote = pc.idLote
            LEFT JOIN proceso_pagos pp ON pp.idProcesoCasas = pc.idProcesoCasas
            LEFT JOIN clientes cli ON cli.idLote = lo.idLote AND cli.status = 1
            LEFT JOIN usuarios us ON us.id_usuario = cli.id_asesor_c
            LEFT JOIN usuarios us_gere ON us_gere.id_usuario = cli.id_gerente_c
            LEFT JOIN condominios con ON con.idCondominio = lo.idCondominio 
            LEFT JOIN residenciales resi ON resi.idResidencial = con.idResidencial
            LEFT JOIN documentos_proceso_pagos doc ON doc.idProcesoPagos = pp.idProcesoPagos AND doc.tipo = 7
            WHERE
                pc.proceso >= 15
            AND pc.status = 1
            AND (pp.proceso = 1 OR pp.proceso IS NULL)";

        return $this->db->query($query)->result();
    }

    public function addLoteToProcesoPagos($idLote, $idProcesoCasas){
        $query = "SELECT * FROM proceso_pagos WHERE idProcesoCasas = $idProcesoCasas AND status = 1";

        $result = $this->db->query($query)->row();

        if($result){
            return $result;
        }

        $query = "INSERT INTO proceso_pagos
        (
            idLote,
            idProcesoCasas,
            idCreacion,
            fechaProceso
        )
        VALUES
        (
            $idLote,
            $idProcesoCasas,
            $this->idUsuario,
            GETDATE()
        )";

        $result = $this->db->query($query);

        if($result){
            $query = "SELECT TOP 1 * FROM proceso_pagos ORDER BY idProcesoPagos DESC";
            return $this->db->query($query)->row();
        }else{
            return null;
        }
    }

    public function getDocumento($idProcesoPagos, $tipo){
        $query = "SELECT *FROM documentos_proceso_pagos
        WHERE
            idProcesoPagos = $idProcesoPagos
        AND tipo = $tipo";

        return $this->db->query($query)->row();
    }

    public function getDocumentos($docs){
        $documents = implode(",", $docs);

        $query = "SELECT
            id_opcion AS tipo,
            nombre
        FROM opcs_x_cats
        WHERE
            id_catalogo = 140
        AND estatus = 1
        AND id_opcion IN ($documents)";

        return $this->db->query($query)->result();
    }

    public function updateDocumentRow($idDocumento, $archivo){
        $idModificacion = $this->session->userdata('id_usuario');

        $query = "UPDATE documentos_proceso_pagos
        SET
            archivo = '$archivo',
            fechaModificacion = GETDATE(),
            idModificacion = $idModificacion
        WHERE
            idDocumento = $idDocumento";

        return $this->db->query($query);
    }

    public function insertDocumentsToProceso($idProcesoPagos, $tipo, $documento){
        $query = "BEGIN
            IF NOT EXISTS (SELECT * FROM documentos_proceso_pagos 
                           WHERE tipo = $tipo
                           AND idProcesoPagos = $idProcesoPagos)
            BEGIN
                INSERT INTO documentos_proceso_pagos (idProcesoPagos, tipo, documento, idCreacion)
                VALUES ($idProcesoPagos, $tipo, '$documento', $this->idUsuario)
            END
        END";

        return $this->db->query($query);
    }

    public function getListaDocumentacion(){
        $query = "SELECT
            pp.*,
            lo.nombreLote,
            doc.documentos,
            con.nombre AS condominio,
            resi.descripcion AS proyecto,
            CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno) AS cliente,
            CASE
                WHEN cli.id_asesor_c IS NOT NULL THEN CONCAT(asesor.nombre, ' ', asesor.apellido_paterno, ' ', asesor.apellido_materno)
                ELSE 'Sin asignar'
            END AS nombreAsesor,
            CASE
                 WHEN cli.id_gerente_c IS NULL THEN 'SIN ESPECIFICAR'
                 ELSE CONCAT(gerente.nombre, ' ', gerente.apellido_paterno, ' ', gerente.apellido_materno)
            END AS gerente
        FROM proceso_pagos pp
        LEFT JOIN proceso_casas_banco pc ON pc.idProcesoCasas = pp.idProcesoCasas
        LEFT JOIN lotes lo ON lo.idLote = pp.idLote
        LEFT JOIN condominios con ON con.idCondominio = lo.idCondominio
        LEFT JOIN residenciales resi ON resi.idResidencial = con.idResidencial
        LEFT JOIN clientes cli ON cli.idLote = lo.idLote AND cli.status = 1
        LEFT JOIN usuarios asesor ON asesor.id_usuario = cli.id_asesor_c
        LEFT JOIN usuarios gerente ON gerente.id_usuario = cli.id_gerente_c
        LEFT JOIN (SELECT COUNT(*) AS documentos, idProcesoPagos FROM documentos_proceso_pagos WHERE tipo IN (1,2,3,4,5,6) AND archivo IS NOT NULL GROUP BY idProcesoPagos) doc ON doc.idProcesoPagos = pp.idProcesoPagos
        WHERE
            pp.proceso = 3
        AND pp.status = 1";

        return $this->db->query($query)->result();
    }

    public function editMontos($idProcesoPagos, $costoConstruccion){
        $query = "UPDATE proceso_pagos
        SET
            costoConstruccion = $costoConstruccion
        WHERE
            idProcesoPagos = $idProcesoPagos";

        return $this->db->query($query);
    }

    public function getListaSubirDcoumentos($idProcesoPagos){
        $query = "SELECT
            idProcesoPagos,
            idDocumento,
            archivo,
            documento,
            tipo,
            fechaModificacion
        FROM documentos_proceso_pagos
        WHERE
            idProcesoPagos = $idProcesoPagos
        AND tipo IN (1,2,3,4,5,6)";

        return $this->db->query($query)->result();
    }

    public function getListaValidaDocumentacion(){
        $query = "SELECT
            pp.*,
            lo.nombreLote,
            con.nombre AS condominio,
            resi.descripcion AS proyecto,
            CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno) AS cliente,
            CASE
                WHEN cli.id_asesor_c IS NOT NULL THEN CONCAT(asesor.nombre, ' ', asesor.apellido_paterno, ' ', asesor.apellido_materno)
                ELSE 'Sin asignar'
            END AS nombreAsesor,
            CASE
                 WHEN cli.id_gerente_c IS NULL THEN 'SIN ESPECIFICAR'
                 ELSE CONCAT(gerente.nombre, ' ', gerente.apellido_paterno, ' ', gerente.apellido_materno)
            END AS gerente
        FROM proceso_pagos pp
        LEFT JOIN lotes lo ON lo.idLote = pp.idLote
        LEFT JOIN proceso_casas_banco pc ON pc.idProcesoCasas = pp.idProcesoCasas
        LEFT JOIN condominios con ON con.idCondominio = lo.idCondominio
        LEFT JOIN residenciales resi ON resi.idResidencial = con.idResidencial
        LEFT JOIN clientes cli ON cli.idLote = lo.idLote AND cli.status = 1
        LEFT JOIN usuarios asesor ON asesor.id_usuario = cli.id_asesor_c
        LEFT JOIN usuarios gerente ON gerente.id_usuario = cli.id_gerente_c
        WHERE
            pp.proceso = 4
        AND pp.status = 1";

        return $this->db->query($query)->result();
    }

    public function getListaValidarDeposito(){
        $query = "SELECT
            pp.*,
            lo.nombreLote,
            con.nombre AS condominio,
            resi.descripcion AS proyecto,
            CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno) AS cliente,
            CASE
                WHEN cli.id_asesor_c IS NOT NULL THEN CONCAT(asesor.nombre, ' ', asesor.apellido_paterno, ' ', asesor.apellido_materno)
                ELSE 'Sin asignar'
            END AS nombreAsesor,
            CASE
                 WHEN cli.id_gerente_c IS NULL THEN 'SIN ESPECIFICAR'
                 ELSE CONCAT(gerente.nombre, ' ', gerente.apellido_paterno, ' ', gerente.apellido_materno)
            END AS gerente
        FROM proceso_pagos pp
        LEFT JOIN lotes lo ON lo.idLote = pp.idLote
        LEFT JOIN proceso_casas_banco pc ON pc.idProcesoCasas = pp.idProcesoCasas
        LEFT JOIN condominios con ON con.idCondominio = lo.idCondominio
        LEFT JOIN residenciales resi ON resi.idResidencial = con.idResidencial
        LEFT JOIN clientes cli ON cli.idLote = lo.idLote AND cli.status = 1
        LEFT JOIN usuarios asesor ON asesor.id_usuario = cli.id_asesor_c
        LEFT JOIN usuarios gerente ON gerente.id_usuario = cli.id_gerente_c
        WHERE
            pp.proceso = 2
        AND pp.status = 1";

        return $this->db->query($query)->result();
    }

    public function getListaConfirmarPago($idProceso){
        $query = "SELECT
            pp.*,
            app.idAvance,
            app.avance,
            app.complementoPDF,
            app.complementoXML,
            app.monto,
            lo.nombreLote,
            con.nombre AS condominio,
            resi.descripcion AS proyecto,
            CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno) AS cliente,
            CASE
                WHEN cli.id_asesor_c IS NOT NULL THEN CONCAT(asesor.nombre, ' ', asesor.apellido_paterno, ' ', asesor.apellido_materno)
                ELSE 'Sin asignar'
            END AS nombreAsesor,
            CASE
                 WHEN cli.id_gerente_c IS NULL THEN 'SIN ESPECIFICAR'
                 ELSE CONCAT(gerente.nombre, ' ', gerente.apellido_paterno, ' ', gerente.apellido_materno)
            END AS gerente
        FROM proceso_pagos pp
        LEFT JOIN lotes lo ON lo.idLote = pp.idLote
        LEFT JOIN avances_proceso_pagos app ON app.idProcesoPagos = pp.idProcesoPagos AND pagado = 0
        LEFT JOIN proceso_casas_banco pc ON pc.idProcesoCasas = pp.idProcesoCasas
        LEFT JOIN condominios con ON con.idCondominio = lo.idCondominio
        LEFT JOIN residenciales resi ON resi.idResidencial = con.idResidencial
        LEFT JOIN clientes cli ON cli.idLote = lo.idLote AND cli.status = 1
        LEFT JOIN usuarios asesor ON asesor.id_usuario = cli.id_asesor_c
        LEFT JOIN usuarios gerente ON gerente.id_usuario = cli.id_gerente_c
        WHERE
            pp.proceso = $idProceso
        AND pp.status = 1";

        return $this->db->query($query)->result();
    }

    public function insertarAvance($idProcesoPagos, $avance, $monto){
        $query = "INSERT INTO avances_proceso_pagos
        (
            idProcesoPagos,
            avance,
            monto,
            idCreacion
        )
        VALUES
        (
            $idProcesoPagos,
            $avance,
            $monto,
            $this->idUsuario
        )";

        return $this->db->query($query);
    }

    public function getListaCargaComplemento($paso){
        $query = "SELECT
            pp.*,
            lo.nombreLote,
            app.idAvance,
            app.avance,
            app.complementoPDF,
            app.complementoXML,
            app.monto,
            con.nombre AS condominio,
            resi.descripcion AS proyecto,
            CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno) AS cliente,
            CASE
                WHEN cli.id_asesor_c IS NOT NULL THEN CONCAT(asesor.nombre, ' ', asesor.apellido_paterno, ' ', asesor.apellido_materno)
                ELSE 'Sin asignar'
            END AS nombreAsesor,
            CASE
                 WHEN cli.id_gerente_c IS NULL THEN 'SIN ESPECIFICAR'
                 ELSE CONCAT(gerente.nombre, ' ', gerente.apellido_paterno, ' ', gerente.apellido_materno)
            END AS gerente
        FROM proceso_pagos pp
        LEFT JOIN lotes lo ON lo.idLote = pp.idLote
        LEFT JOIN avances_proceso_pagos app ON app.idProcesoPagos = pp.idProcesoPagos AND pagado = 0
        LEFT JOIN proceso_casas_banco pc ON pc.idProcesoCasas = pp.idProcesoCasas
        LEFT JOIN condominios con ON con.idCondominio = lo.idCondominio
        LEFT JOIN residenciales resi ON resi.idResidencial = con.idResidencial
        LEFT JOIN clientes cli ON cli.idLote = lo.idLote AND cli.status = 1
        LEFT JOIN usuarios asesor ON asesor.id_usuario = cli.id_asesor_c
        LEFT JOIN usuarios gerente ON gerente.id_usuario = cli.id_gerente_c
        WHERE
            pp.proceso = $paso 
        AND pp.status = 1";

        return $this->db->query($query)->result();
    }

    public function setComplementosAvance($idAvance, $complementoPDF, $complementoXML){
        $query = "UPDATE avances_proceso_pagos
        SET
            complementoPDF = '$complementoPDF',
            complementoXML = '$complementoXML',
            idModificacion = $this->idUsuario,
            fechaModificacion = GETDATE()
        WHERE
            idAvance = $idAvance";

        return $this->db->query($query);
    }

    public function getListaValidarPago($paso){
        $query = "SELECT
            pp.*,
            lo.nombreLote,
            app.idAvance,
            app.avance,
            app.complementoPDF,
            app.complementoXML,
            app.monto,
            con.nombre AS condominio,
            resi.descripcion AS proyecto,
            CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno) AS cliente,
            CASE
                WHEN cli.id_asesor_c IS NOT NULL THEN CONCAT(asesor.nombre, ' ', asesor.apellido_paterno, ' ', asesor.apellido_materno)
                ELSE 'Sin asignar'
            END AS nombreAsesor,
            CASE
                 WHEN cli.id_gerente_c IS NULL THEN 'SIN ESPECIFICAR'
                 ELSE CONCAT(gerente.nombre, ' ', gerente.apellido_paterno, ' ', gerente.apellido_materno)
            END AS gerente
        FROM proceso_pagos pp
        LEFT JOIN lotes lo ON lo.idLote = pp.idLote
        LEFT JOIN avances_proceso_pagos app ON app.idProcesoPagos = pp.idProcesoPagos AND pagado = 0
        LEFT JOIN proceso_casas_banco pc ON pc.idProcesoCasas = pp.idProcesoCasas
        LEFT JOIN condominios con ON con.idCondominio = lo.idCondominio
        LEFT JOIN residenciales resi ON resi.idResidencial = con.idResidencial
        LEFT JOIN clientes cli ON cli.idLote = lo.idLote AND cli.status = 1
        LEFT JOIN usuarios asesor ON asesor.id_usuario = cli.id_asesor_c
        LEFT JOIN usuarios gerente ON gerente.id_usuario = cli.id_gerente_c
        WHERE
            pp.proceso = $paso 
        AND pp.status = 1
        AND pp.finalizado = 0";

        return $this->db->query($query)->result();
    }

    public function setPagadoAvance($idAvance){
        $query = "UPDATE avances_proceso_pagos
        SET
            pagado = 1,
            idModificacion = $this->idUsuario,
            fechaModificacion = GETDATE()
        WHERE
            idAvance = $idAvance";

        return $this->db->query($query);
    }

    public function getListaSolicitarAvance(){
        $query = "SELECT
            pp.*,
            lo.nombreLote,
            app.idAvance,
            app.avance AS nuevo_avance,
            app.monto,
            con.nombre AS condominio,
            resi.descripcion AS proyecto,
            CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno) AS cliente,
            CASE
                WHEN cli.id_asesor_c IS NOT NULL THEN CONCAT(asesor.nombre, ' ', asesor.apellido_paterno, ' ', asesor.apellido_materno)
                ELSE 'Sin asignar'
            END AS nombreAsesor,
            CASE
                 WHEN cli.id_gerente_c IS NULL THEN 'SIN ESPECIFICAR'
                 ELSE CONCAT(gerente.nombre, ' ', gerente.apellido_paterno, ' ', gerente.apellido_materno)
            END AS gerente
        FROM proceso_pagos pp
        LEFT JOIN lotes lo ON lo.idLote = pp.idLote
        LEFT JOIN avances_proceso_pagos app ON app.idProcesoPagos = pp.idProcesoPagos AND pagado = 0
        LEFT JOIN proceso_casas_banco pc ON pc.idProcesoCasas = pp.idProcesoCasas
        LEFT JOIN condominios con ON con.idCondominio = lo.idCondominio
        LEFT JOIN residenciales resi ON resi.idResidencial = con.idResidencial
        LEFT JOIN clientes cli ON cli.idLote = lo.idLote AND cli.status = 1
        LEFT JOIN usuarios asesor ON asesor.id_usuario = cli.id_asesor_c
        LEFT JOIN usuarios gerente ON gerente.id_usuario = cli.id_gerente_c
        WHERE
            pp.proceso = 8
        AND pp.status = 1";

        return $this->db->query($query)->result();
    }

    public function updateAvance($idAvance, $avance, $monto){
        $query = "UPDATE avances_proceso_pagos
        SET
            avance = $avance,
            monto = $monto,
            idModificacion = $this->idUsuario,
            fechaModificacion = GETDATE()
        WHERE
            idAvance = $idAvance";

        return $this->db->query($query);
    }

    public function setAvanceToProceso($idProcesoPagos, $avance){
        $query = "UPDATE proceso_pagos
        SET
            avanceObra = $avance,
            idModificacion = $this->idUsuario,
            fechaModificacion = GETDATE()
        WHERE
            idProcesoPagos = $idProcesoPagos";

        return $this->db->query($query);
    }

    public function getListaValidarAvance(){
        $query = "SELECT
            pp.*,
            lo.nombreLote,
            app.idAvance,
            app.avance AS nuevo_avance,
            app.monto,
            con.nombre AS condominio,
            resi.descripcion AS proyecto,
            CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno) AS cliente,
            CASE
                WHEN asesor.nombre IS NOT NULL THEN CONCAT(asesor.nombre, ' ', asesor.apellido_paterno, ' ', asesor.apellido_materno)
                ELSE 'Sin asignar'
            END AS nombreAsesor,
            CASE
                 WHEN pc.idGerente IS NULL THEN 'SIN ESPECIFICAR'
                 ELSE CONCAT(gerente.nombre, ' ', gerente.apellido_paterno, ' ', gerente.apellido_materno)
            END AS gerente
        FROM proceso_pagos pp
        LEFT JOIN lotes lo ON lo.idLote = pp.idLote
        LEFT JOIN avances_proceso_pagos app ON app.idProcesoPagos = pp.idProcesoPagos AND pagado = 0
        LEFT JOIN proceso_casas_banco pc ON pc.idProcesoCasas = pp.idProcesoCasas
        LEFT JOIN condominios con ON con.idCondominio = lo.idCondominio
        LEFT JOIN residenciales resi ON resi.idResidencial = con.idResidencial
        LEFT JOIN clientes cli ON cli.idLote = lo.idLote AND cli.status = 1
        LEFT JOIN usuarios asesor ON asesor.id_usuario = pc.idAsesor
        LEFT JOIN usuarios gerente ON gerente.id_usuario = pc.idGerente
        WHERE
            pp.proceso = 8
        AND pp.status = 1";

        return $this->db->query($query)->result();
    }

    public function getListaReportePagos($proceso, $finalizado){
        $query = "SELECT
            pp.*,
            lo.nombreLote,
            app.idAvance,
            app.avance AS nuevo_avance,
            app.monto,
            con.nombre AS condominio,
            resi.descripcion AS proyecto,
            CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno) AS cliente,
            CASE
                WHEN asesor.nombre IS NOT NULL THEN CONCAT(asesor.nombre, ' ', asesor.apellido_paterno, ' ', asesor.apellido_materno)
                ELSE 'Sin asignar'
            END AS nombreAsesor,
            CASE
                 WHEN pc.idGerente IS NULL THEN 'SIN ESPECIFICAR'
                 ELSE CONCAT(gerente.nombre, ' ', gerente.apellido_paterno, ' ', gerente.apellido_materno)
            END AS gerente,
            proceso.nombre AS procesoNombre
        FROM proceso_pagos pp
        LEFT JOIN lotes lo ON lo.idLote = pp.idLote
        LEFT JOIN avances_proceso_pagos app ON app.idProcesoPagos = pp.idProcesoPagos AND pagado = 0
        LEFT JOIN proceso_casas_banco pc ON pc.idProcesoCasas = pp.idProcesoCasas
        LEFT JOIN condominios con ON con.idCondominio = lo.idCondominio
        LEFT JOIN residenciales resi ON resi.idResidencial = con.idResidencial
        LEFT JOIN clientes cli ON cli.idLote = lo.idLote AND cli.status = 1
        LEFT JOIN usuarios asesor ON asesor.id_usuario = pc.idAsesor
        LEFT JOIN usuarios gerente ON gerente.id_usuario = pc.idGerente
        LEFT JOIN opcs_x_cats proceso ON proceso.id_catalogo = 141 AND proceso.id_opcion = pp.proceso
        WHERE
            pp.proceso IN ($proceso)
        AND pp.status = 1
        AND pc.finalizado IN ($finalizado)
        ORDER BY pp.fechaCreacion";

        return $this->db->query($query)->result();
    }

    public function getListaAvances($idProcesoPagos){
        $query = "SELECT
            app.*,
            lo.idLote,
            lo.nombreLote,
            con.nombre AS condominio,
            resi.descripcion AS proyecto,
            CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno) AS cliente,
            CASE
                WHEN asesor.nombre IS NOT NULL THEN CONCAT(asesor.nombre, ' ', asesor.apellido_paterno, ' ', asesor.apellido_materno)
                ELSE 'Sin asignar'
            END AS nombreAsesor,
            CASE
                 WHEN pc.idGerente IS NULL THEN 'SIN ESPECIFICAR'
                 ELSE CONCAT(gerente.nombre, ' ', gerente.apellido_paterno, ' ', gerente.apellido_materno)
            END AS gerente
        FROM avances_proceso_pagos app
        LEFT JOIN proceso_pagos pp ON pp.idProcesoPagos = app.idProcesoPagos
        LEFT JOIN proceso_casas_banco pc ON pc.idProcesoCasas = pp.idProcesoCasas
        LEFT JOIN lotes lo ON lo.idLote = pp.idLote
        LEFT JOIN condominios con ON con.idCondominio = lo.idCondominio
        LEFT JOIN residenciales resi ON resi.idResidencial = con.idResidencial
        LEFT JOIN clientes cli ON cli.idLote = lo.idLote AND cli.status = 1
        LEFT JOIN usuarios asesor ON asesor.id_usuario = pc.idAsesor
        LEFT JOIN usuarios gerente ON gerente.id_usuario = pc.idGerente
        WHERE
            app.idProcesoPagos = $idProcesoPagos
        ORDER BY app.fechaCreacion";

        return $this->db->query($query)->result();
    }

    public function setProcesoFinalizado($idProcesoPagos, $comentario){
        $query = "UPDATE proceso_pagos
        SET
            proceso = 11,
            comentario = '$comentario',
            finalizado = 1,
            fechaProceso = GETDATE(),
            fechaModificacion = GETDATE(),
            idModificacion = $this->idUsuario
        WHERE
            idProcesoPagos = $idProcesoPagos";

        return $this->db->query($query);
    }

    public function getProcesosOptions($finalizado = ''){
        $extra = '';
        if($finalizado == 1) {
            $extra = " AND id_opcion != 8";
        }
        $query = "SELECT
            id_opcion AS value,
            nombre AS label
        FROM opcs_x_cats
        WHERE
            id_catalogo = 141
        AND estatus = 1 $extra";

        return $this->db->query($query)->result();
    }

    public function setMontoDepositado($idProcesoPagos, $montoDepositado){
        $query = "UPDATE proceso_pagos
        SET
            montoDepositado = $montoDepositado
        WHERE
            idProcesoPagos = $idProcesoPagos";

        return $this->db->query($query);
    }

    public function getHistorialPagosCasas($idProceso, $estatus) {
        $query = "SELECT 
        hpc.idHistorial, 
        hpc.procesoAnterior,
        hpc.procesoNuevo,
        CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno, ' (',oxc.nombre, ')')AS nombreUsuario,
        hpc.idMovimiento,
        hpc.fechaMovimiento,
        CASE WHEN CHARINDEX('$', CONVERT(VARCHAR(MAX), descripcion)) > 0  THEN LEFT(CONVERT(VARCHAR(MAX), descripcion), CHARINDEX('$', CONVERT(VARCHAR(MAX), descripcion)) - 1)
        + '$' + FORMAT( TRY_CAST(SUBSTRING(CONVERT(VARCHAR(MAX), descripcion), CHARINDEX('$', CONVERT(VARCHAR(MAX), descripcion)) + 1, LEN(CONVERT(VARCHAR(MAX), descripcion))) 
        AS MONEY), 'N', 'es-MX') 
        ELSE CONVERT(VARCHAR(MAX), descripcion) END AS descripcionFinal,
        CASE WHEN hpc.procesoAnterior = hpc.procesoNuevo THEN '1' ELSE '0' END AS cambioStatus
        FROM historial_proceso_pago_casas hpc
        LEFT JOIN usuarios us ON us.id_usuario = hpc.idMovimiento
        LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = us.id_rol AND oxc.id_catalogo = 1
        WHERE hpc.idProcesoCasas = $idProceso
        ORDER BY idHistorial DESC
        ";

        $query = $this->db->query($query);
        return $query->result_array(); 
    }

    public function addHistorial($idProceso, $procesoAnterior, $procesoNuevo, $descripcion) {
        $idMovimiento = $this->session->userdata('id_usuario');
        
        $query = "INSERT INTO historial_proceso_pago_casas
        (idProcesoCasas, procesoAnterior, procesoNuevo, idMovimiento, descripcion, creadoPor)
        VALUES ($idProceso, $procesoAnterior, $procesoNuevo, $idMovimiento, '$descripcion', $idMovimiento)";

         return $this->db->query($query);
    }
} 