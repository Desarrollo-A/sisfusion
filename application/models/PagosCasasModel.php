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

    public function setProcesoTo($idProcesoPagos, $proceso){
        $query = "UPDATE proceso_pagos
        SET
            proceso = $proceso,
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

    public function addLoteToProcesoPagos($idLote, $idProcesoCasas){
        $query = "INSERT INTO proceso_pagos
        (
            idLote,
            idProcesoCasas,
            idCreacion
        )
        VALUES
        (
            $idLote,
            $idProcesoCasas,
            $this->idUsuario
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
}