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
            END AS gerente
        FROM proceso_casas pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        LEFT JOIN proceso_pagos pp ON pp.idProcesoCasas = pc.idProcesoCasas
        LEFT JOIN usuarios us ON us.id_usuario = pc.idAsesor
        LEFT JOIN clientes cli ON cli.idLote = lo.idLote AND cli.status = 1
        LEFT JOIN usuarios us_gere ON us_gere.id_usuario = pc.idGerente
        LEFT JOIN condominios con ON con.idCondominio = lo.idCondominio 
        LEFT JOIN residenciales resi ON resi.idResidencial = con.idResidencial
        WHERE
            pc.proceso = 16
        AND pc.status = 1
        AND pc.finalizado = 1
        AND pp.idProcesoCasas IS NULL";

        return $this->db->query($query)->result();
    }

    public function addLoteToProcesoPagos($idLote, $idProcesoCasas, $comentario){
        $query = "INSERT INTO proceso_pagos
        (
            idLote,
            idProcesoCasas,
            idCreacion,
            comentario,
            fechaProceso
        )
        VALUES
        (
            $idLote,
            $idProcesoCasas,
            $this->idUsuario,
            '$comentario',
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

    public function inserDocumentsToProceso($idProcesoPagos, $tipo, $documento){
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
                WHEN asesor.nombre IS NOT NULL THEN CONCAT(asesor.nombre, ' ', asesor.apellido_paterno, ' ', asesor.apellido_materno)
                ELSE 'Sin asignar'
            END AS nombreAsesor,
            CASE
                 WHEN pc.idGerente IS NULL THEN 'SIN ESPECIFICAR'
                 ELSE CONCAT(gerente.nombre, ' ', gerente.apellido_paterno, ' ', gerente.apellido_materno)
            END AS gerente
        FROM proceso_pagos pp
        LEFT JOIN proceso_casas pc ON pc.idProcesoCasas = pp.idProcesoCasas
        LEFT JOIN lotes lo ON lo.idLote = pp.idLote
        LEFT JOIN condominios con ON con.idCondominio = lo.idCondominio
        LEFT JOIN residenciales resi ON resi.idResidencial = con.idResidencial
        LEFT JOIN clientes cli ON cli.idLote = lo.idLote AND cli.status = 1
        LEFT JOIN usuarios asesor ON asesor.id_usuario = pc.idAsesor
        LEFT JOIN usuarios gerente ON gerente.id_usuario = pc.idGerente
        LEFT JOIN (SELECT COUNT(*) AS documentos, idProcesoPagos FROM documentos_proceso_pagos WHERE tipo IN (1,2,3,4,5,6) AND archivo IS NOT NULL GROUP BY idProcesoPagos) doc ON doc.idProcesoPagos = pp.idProcesoPagos
        WHERE
            pp.proceso = 1
        AND pp.status = 1";

        return $this->db->query($query)->result();
    }

    public function editMontos($idProcesoPagos, $costoConstruccion, $montoDepositado){
        $query = "UPDATE proceso_pagos
        SET
            costoConstruccion = $costoConstruccion,
            montoDepositado = $montoDepositado
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
                WHEN asesor.nombre IS NOT NULL THEN CONCAT(asesor.nombre, ' ', asesor.apellido_paterno, ' ', asesor.apellido_materno)
                ELSE 'Sin asignar'
            END AS nombreAsesor,
            CASE
                 WHEN pc.idGerente IS NULL THEN 'SIN ESPECIFICAR'
                 ELSE CONCAT(gerente.nombre, ' ', gerente.apellido_paterno, ' ', gerente.apellido_materno)
            END AS gerente
        FROM proceso_pagos pp
        LEFT JOIN lotes lo ON lo.idLote = pp.idLote
        LEFT JOIN proceso_casas pc ON pc.idProcesoCasas = pp.idProcesoCasas
        LEFT JOIN condominios con ON con.idCondominio = lo.idCondominio
        LEFT JOIN residenciales resi ON resi.idResidencial = con.idResidencial
        LEFT JOIN clientes cli ON cli.idLote = lo.idLote AND cli.status = 1
        LEFT JOIN usuarios asesor ON asesor.id_usuario = pc.idAsesor
        LEFT JOIN usuarios gerente ON gerente.id_usuario = pc.idGerente
        WHERE
            pp.proceso = 2
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
                WHEN asesor.nombre IS NOT NULL THEN CONCAT(asesor.nombre, ' ', asesor.apellido_paterno, ' ', asesor.apellido_materno)
                ELSE 'Sin asignar'
            END AS nombreAsesor,
            CASE
                 WHEN pc.idGerente IS NULL THEN 'SIN ESPECIFICAR'
                 ELSE CONCAT(gerente.nombre, ' ', gerente.apellido_paterno, ' ', gerente.apellido_materno)
            END AS gerente
        FROM proceso_pagos pp
        LEFT JOIN lotes lo ON lo.idLote = pp.idLote
        LEFT JOIN proceso_casas pc ON pc.idProcesoCasas = pp.idProcesoCasas
        LEFT JOIN condominios con ON con.idCondominio = lo.idCondominio
        LEFT JOIN residenciales resi ON resi.idResidencial = con.idResidencial
        LEFT JOIN clientes cli ON cli.idLote = lo.idLote AND cli.status = 1
        LEFT JOIN usuarios asesor ON asesor.id_usuario = pc.idAsesor
        LEFT JOIN usuarios gerente ON gerente.id_usuario = pc.idGerente
        WHERE
            pp.proceso = 3
        AND pp.status = 1";

        return $this->db->query($query)->result();
    }

    public function getListaConfirmarPago(){
        $query = "SELECT
            pp.*,
            lo.nombreLote,
            app.avance,
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
        LEFT JOIN proceso_casas pc ON pc.idProcesoCasas = pp.idProcesoCasas
        LEFT JOIN condominios con ON con.idCondominio = lo.idCondominio
        LEFT JOIN residenciales resi ON resi.idResidencial = con.idResidencial
        LEFT JOIN clientes cli ON cli.idLote = lo.idLote AND cli.status = 1
        LEFT JOIN usuarios asesor ON asesor.id_usuario = pc.idAsesor
        LEFT JOIN usuarios gerente ON gerente.id_usuario = pc.idGerente
        WHERE
            pp.proceso = 4
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

    public function getListaCargaComplemento(){
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
        LEFT JOIN proceso_casas pc ON pc.idProcesoCasas = pp.idProcesoCasas
        LEFT JOIN condominios con ON con.idCondominio = lo.idCondominio
        LEFT JOIN residenciales resi ON resi.idResidencial = con.idResidencial
        LEFT JOIN clientes cli ON cli.idLote = lo.idLote AND cli.status = 1
        LEFT JOIN usuarios asesor ON asesor.id_usuario = pc.idAsesor
        LEFT JOIN usuarios gerente ON gerente.id_usuario = pc.idGerente
        WHERE
            pp.proceso = 5
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

    public function getListaValidarPago(){
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
        LEFT JOIN proceso_casas pc ON pc.idProcesoCasas = pp.idProcesoCasas
        LEFT JOIN condominios con ON con.idCondominio = lo.idCondominio
        LEFT JOIN residenciales resi ON resi.idResidencial = con.idResidencial
        LEFT JOIN clientes cli ON cli.idLote = lo.idLote AND cli.status = 1
        LEFT JOIN usuarios asesor ON asesor.id_usuario = pc.idAsesor
        LEFT JOIN usuarios gerente ON gerente.id_usuario = pc.idGerente
        WHERE
            pp.proceso = 6
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
        LEFT JOIN proceso_casas pc ON pc.idProcesoCasas = pp.idProcesoCasas
        LEFT JOIN condominios con ON con.idCondominio = lo.idCondominio
        LEFT JOIN residenciales resi ON resi.idResidencial = con.idResidencial
        LEFT JOIN clientes cli ON cli.idLote = lo.idLote AND cli.status = 1
        LEFT JOIN usuarios asesor ON asesor.id_usuario = pc.idAsesor
        LEFT JOIN usuarios gerente ON gerente.id_usuario = pc.idGerente
        WHERE
            pp.proceso = 7
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
        LEFT JOIN proceso_casas pc ON pc.idProcesoCasas = pp.idProcesoCasas
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
        LEFT JOIN proceso_casas pc ON pc.idProcesoCasas = pp.idProcesoCasas
        LEFT JOIN condominios con ON con.idCondominio = lo.idCondominio
        LEFT JOIN residenciales resi ON resi.idResidencial = con.idResidencial
        LEFT JOIN clientes cli ON cli.idLote = lo.idLote AND cli.status = 1
        LEFT JOIN usuarios asesor ON asesor.id_usuario = pc.idAsesor
        LEFT JOIN usuarios gerente ON gerente.id_usuario = pc.idGerente
        LEFT JOIN opcs_x_cats proceso ON proceso.id_catalogo = 141 AND proceso.id_opcion = pp.proceso
        WHERE
            pp.proceso IN ($proceso)
        AND pp.status = 1
        AND pc.finalizado IN ($finalizado)";

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
        LEFT JOIN proceso_casas pc ON pc.idProcesoCasas = pp.idProcesoCasas
        LEFT JOIN lotes lo ON lo.idLote = pp.idLote
        LEFT JOIN condominios con ON con.idCondominio = lo.idCondominio
        LEFT JOIN residenciales resi ON resi.idResidencial = con.idResidencial
        LEFT JOIN clientes cli ON cli.idLote = lo.idLote AND cli.status = 1
        LEFT JOIN usuarios asesor ON asesor.id_usuario = pc.idAsesor
        LEFT JOIN usuarios gerente ON gerente.id_usuario = pc.idGerente
        WHERE
            app.idProcesoPagos = $idProcesoPagos";

        return $this->db->query($query)->result();
    }

    public function setProcesoFinalizado($idProcesoPagos, $comentario){
        $query = "UPDATE proceso_pagos
        SET
            proceso = 8,
            comentario = '$comentario',
            finalizado = 1,
            fechaProceso = GETDATE(),
            fechaModificacion = GETDATE(),
            idModificacion = $this->idUsuario
        WHERE
            idProcesoPagos = $idProcesoPagos";

        return $this->db->query($query);
    }

    public function getProcesosOptions(){
        $query = "SELECT
            id_opcion AS value,
            nombre AS label
        FROM opcs_x_cats
        WHERE
            id_catalogo = 141
        AND estatus = 1";

        return $this->db->query($query)->result();
    }
}