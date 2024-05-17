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
            lo.nombreLote
        FROM proceso_casas pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        LEFT JOIN proceso_pagos pp ON pp.idProcesoCasas = pc.idProcesoCasas
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
            id_catalogo = 121
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
            doc.documentos
        FROM proceso_pagos pp
        LEFT JOIN lotes lo ON lo.idLote = pp.idLote
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
            lo.nombreLote
        FROM proceso_pagos pp
        LEFT JOIN lotes lo ON lo.idLote = pp.idLote
        WHERE
            pp.proceso = 2
        AND pp.status = 1";

        return $this->db->query($query)->result();
    }

    public function getListaValidarDeposito(){
        $query = "SELECT
            pp.*,
            lo.nombreLote
        FROM proceso_pagos pp
        LEFT JOIN lotes lo ON lo.idLote = pp.idLote
        WHERE
            pp.proceso = 3
        AND pp.status = 1";

        return $this->db->query($query)->result();
    }

    public function getListaConfirmarPago(){
        $query = "SELECT
            pp.*,
            lo.nombreLote,
            app.avance
        FROM proceso_pagos pp
        LEFT JOIN lotes lo ON lo.idLote = pp.idLote
        LEFT JOIN avances_proceso_pagos app ON app.idProcesoPagos = pp.idProcesoPagos AND pagado = 0
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
            app.complementoXML
        FROM proceso_pagos pp
        LEFT JOIN lotes lo ON lo.idLote = pp.idLote
        LEFT JOIN avances_proceso_pagos app ON app.idProcesoPagos = pp.idProcesoPagos AND pagado = 0
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
            app.complementoXML
        FROM proceso_pagos pp
        LEFT JOIN lotes lo ON lo.idLote = pp.idLote
        LEFT JOIN avances_proceso_pagos app ON app.idProcesoPagos = pp.idProcesoPagos AND pagado = 0
        WHERE
            pp.proceso = 6
        AND pp.status = 1";

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
            app.monto
        FROM proceso_pagos pp
        LEFT JOIN lotes lo ON lo.idLote = pp.idLote
        LEFT JOIN avances_proceso_pagos app ON app.idProcesoPagos = pp.idProcesoPagos AND pagado = 0
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
            avance = $avance,
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
            app.monto
        FROM proceso_pagos pp
        LEFT JOIN lotes lo ON lo.idLote = pp.idLote
        LEFT JOIN avances_proceso_pagos app ON app.idProcesoPagos = pp.idProcesoPagos AND pagado = 0
        WHERE
            pp.proceso = 8
        AND pp.status = 1";

        return $this->db->query($query)->result();
    }
}