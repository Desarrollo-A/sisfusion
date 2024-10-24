<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class CasasDirectoModel extends CI_Model
{
    function __construct(){
        parent::__construct();

        $this->load->library(['session']);
    }

    public function getDocumentoCreditoDirecto($id_documento){
        $query = $this->db->query("SELECT * FROM opcs_x_cats 
        WHERE id_catalogo = 149 AND id_opcion = ?", $id_documento);

        return $query;
    }

    public function insertDocProcesoCreditoDirecto($idProceso, $name_documento, $filename, $id_documento, $tipoDocumento, $id_usuario){
        if($tipoDocumento === 1){
            $name = isset($filename) ? "'$filename'" : 'NULL';
            $query = "INSERT INTO documentos_proceso_credito_directo
            (
                idProceso,
                documento,
                archivo,
                tipo,
                fechaCreacion,
                idCreacion, 
                fechaModificacion,
                idModificacion
            )
            VALUES
            (
                $idProceso,
                '$name_documento',
                $name,
                $id_documento,
                GETDATE(),
                '$id_usuario',
                GETDATE(),
                '$id_usuario'
            )";
        }else{
            $name = isset($filename) ? "archivo = '$filename'," : '';
            $query = "UPDATE documentos_proceso_credito_directo 
            SET documento = '$name_documento', $name fechaModificacion = GETDATE(), idModificacion = '$id_usuario'
            WHERE idProceso = $idProceso AND tipo = $id_documento AND documento = '$name_documento'";
        }

        return $this->db->query($query);
    }

    public function addHistorial($idProcesoCasas, $procesoAnterior, $procesoNuevo, $descripcion, $esquema, $idCliente){
        $idMovimiento = $this->session->userdata('id_usuario');

        $query = "INSERT INTO historial_proceso_casas
        (
            idProcesoCasas,
            procesoAnterior,
            procesoNuevo,
            idMovimiento,
            creadoPor,
            descripcion,
            esquemaCreditoProceso,
            idCliente
            
        )
        VALUES
        (
            $idProcesoCasas,
            $procesoAnterior,
            $procesoNuevo,
            $idMovimiento,
            $idMovimiento,
            '$descripcion',
            $esquema,
            $idCliente
            
        )";

        return $this->db->query($query);
    }

    public function getProcesoDirecto($idProceso) {
        $query = "SELECT pc.*, lo.nombreLote 
        FROM proceso_casas_directo pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        WHERE pc.idProceso = $idProceso";

        return $this->db->query($query)->row();
    }

    public function getTipoPersona($idCliente) {
        $query = $this->db->query(
            "SELECT
                personalidad_juridica
            FROM
                clientes
            WHERE
                id_cliente = $idCliente"
        )->row();

        return $query;
    }

    public function getListaDocumentosClienteDirecto($idProceso, $docs) {
        $in = implode(',', $docs);

        $query = "SELECT
        dpc.idProceso, 
        dpc.idDocumento,
        CASE WHEN dpc.archivo IS NULL THEN 'Sin archivo' ELSE archivo END AS archivo, dpc.documento,
        dpc.tipo, dpc.fechaModificacion
        FROM documentos_proceso_credito_directo dpc
        WHERE dpc.idProceso = $idProceso
        AND dpc.tipo IN ($in)
        ";

        return $this->db->query($query)->result();
    }

    public function lotesCreditoDirecto($proceso, $tipoDocumento, $nombreDocumento){

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
            dpc.documento,
            dpc2.documentos as documentosMoral,
            dpc3.documentos as documentosFisica,
            vpc.adm,
            vpc.proyectos,
            vpc.asiGerencia
        FROM proceso_casas_directo pcd
        INNER JOIN lotes lo ON lo.idLote = pcd.idLote
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = pcd.tipoMovimiento AND id_catalogo = 108
        LEFT JOIN documentos_proceso_credito_directo dpc ON dpc.idProceso = pcd.idProceso AND dpc.tipo IN($tipoDocumento) AND dpc.documento LIKE '%$nombreDocumento%'
		LEFT JOIN (SELECT COUNT(*) AS documentos, idProceso FROM documentos_proceso_credito_directo WHERE tipo IN (10,11,12,7,8,30,22,23,24,25) AND archivo IS NOT NULL GROUP BY idProceso) AS dpc2 ON dpc2.idProceso = pcd.idProceso
		LEFT JOIN (SELECT COUNT(*) AS documentos, idProceso FROM documentos_proceso_credito_directo WHERE tipo IN (2,3,4,7,8,30) AND archivo IS NOT NULL GROUP BY idProceso) AS dpc3 ON dpc3.idProceso = pcd.idProceso
        LEFT JOIN vobos_proceso_casas_directo vpc ON vpc.idProceso = pcd.idProceso
        WHERE pcd.proceso IN ($placeholders) AND pcd.estatus IN(1) AND pcd.finalizado = 0", $procesoArray, 1);

        return $query;
    }

    public function insertVoboDirecto($idProceso, $paso) {
        $query = $this->db->query(
            "BEGIN
                IF NOT EXISTS (SELECT * FROM  vobos_proceso_casas_directo WHERE idProceso = ? AND paso = ?)
                BEGIN
                    INSERT INTO vobos_proceso_casas_directo (idProceso, paso, adm, proyectos, asiGerencia, modificadoPor)
                    VALUES (?, ?, ?, ?, ?, ?)
                END
            END",
            array($idProceso, $paso, $idProceso, $paso, 0, 0, 0, 1)
        );

        return $query;
    }

    public function updateVobosDirecto($idProceso, $paso, $data){
        $query = "SELECT * FROM vobos_proceso_casas_directo WHERE idProceso = $idProceso";

        $vobo = $this->db->query($query)->row();

        if($vobo){
            $this->db->update('vobos_proceso_casas_directo', $data, "idVobo = $vobo->idVobo");
        } else{
            $data['idProceso'] = $idProceso;
            $data['paso'] = $paso;

            $this->db->insert('vobos_proceso_casas_directo', $data);
        }

        return $this->db->query($query)->row();
    }

    public function getDocumentoPersonaMoral($idDocumento) {
        $query = $this->db->query("SELECT * FROM opcs_x_cats 
        WHERE id_catalogo = 32 AND id_opcion = ?", $idDocumento)->row();

        return $query;
    }

    public function getDocumentoPersonaFisica($idDocumento) {
        $query = $this->db->query("SELECT * FROM opcs_x_cats 
        WHERE id_catalogo = 31 AND id_opcion = ?", $idDocumento)->row();

        return $query;
    }

    public function getPasos($idProceso, $bandera){

        $query = "SELECT TOP 1 fj.pasoActual, fj.ultimoPaso, fj.avance, oxc.id_opcion AS tipoMovimiento 
        FROM proceso_casas_directo pc
        INNER JOIN historial_proceso_casas hpc ON hpc.idProcesoCasas = pc.idProceso AND hpc.esquemaCreditoProceso = 1
        INNER JOIN flujo_proceso_casas_directo fj ON fj.pasoActual = hpc.procesoNuevo AND fj.ultimoPaso = hpc.procesoAnterior AND fj.tipoPaso = $bandera
        INNER JOIN opcs_x_cats oxc ON oxc.id_catalogo = 108 AND oxc.id_opcion = fj.tipoMovimiento 
        WHERE pc.idProceso = $idProceso AND hpc.procesoAnterior != hpc.procesoNuevo 
        ORDER BY hpc.idHistorial DESC;
        ";

        return $this->db->query($query)->row();
    }
}