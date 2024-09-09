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
        FROM proceso_casas_banco pc
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

    public function getGerente($id) {
        $query = "SELECT TOP 1 
            nombre AS nombre,
            id_usuario AS idUsuario
            FROM usuarios WHERE id_usuario = $id";

            return $this->db->query($query)->row();
    }

    public function setProcesoTo($idProcesoCasas, $proceso, $comentario, $tipoMovimiento){
        $idModificacion = $this->session->userdata('id_usuario');

        $query = "UPDATE proceso_casas_banco
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
            idMovimiento,
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
            $idMovimiento,
            '$descripcion',
            $esquema
        )";

        return $this->db->query($query);
    }

    public function insertVobo($idProcesoCasas, $paso){
        $query = $this->db->query(
            "BEGIN
                IF NOT EXISTS (SELECT *FROM vobos_proceso_casas WHERE idProceso = ? AND paso = ?)
                
                BEGIN 
                    INSERT INTO vobos_proceso_casas (idProceso, paso, adm, ooam, proyectos) 
                        VALUES(?, ?, ?, ?, ?)
                END
            END", array($idProcesoCasas, $paso, $idProcesoCasas, $paso, 0, 0, 0)                
        );

        return $query;
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
        return $this->db->query(
            "SELECT 
                lo.idLote, 
                lo.nombreLote, 
                lo.sup,
                co.nombre condominio, 
                re.descripcion proyecto, 
                CASE WHEN cl.id_cliente IS NULL THEN 'SIN ESPECIFICAR' ELSE CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno) END cliente, 
                UPPER(REPLACE(ISNULL(oxc.nombre, 'SIN ESPECIFICAR'), ' (especificar)', '')) AS lugar_prospeccion,
                FORMAT(ISNULL(lo.totalNeto2, '0.00'), 'C') precioTotalLote,
                CASE WHEN cl.telefono1 IS NULL THEN 'SIN ESPECIFICAR' ELSE cl.telefono1 END telefono1,
                CASE WHEN cl.telefono2 IS NULL THEN 'SIN ESPECIFICAR' ELSE cl.telefono2 END telefono2,
                CASE WHEN cl.telefono3 IS NULL THEN 'SIN ESPECIFICAR' ELSE cl.telefono3 END telefono3,
                CASE WHEN cl.correo IS NULL THEN 'SIN ESPECIFICAR' ELSE cl.correo END correo,
                CASE WHEN cl.id_gerente_c IS NULL THEN 'SIN ESPECIFICAR' ELSE CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno) END gerente,
                ISNULL(cl.id_cliente, 0) idCliente, CASE WHEN cl.id_cliente IS NULL THEN 0 ELSE 1 END AS clienteExistente, 
                CASE WHEN cl.id_cliente IS NOT NULL THEN CASE WHEN cl.id_cliente = lo.idCliente THEN '1' ELSE '0' END END AS clienteNuevoEditar, 
                cl.nombre AS nombreCliente, cl.apellido_paterno  AS apePaterno, cl.apellido_materno AS apeMaterno, cl.telefono1, cl.correo, cl.domicilio_particular,
                cl.estado_civil, cl.ocupacion

            FROM 
                lotes lo 
            LEFT JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 1 
            LEFT JOIN usuarios u2 ON u2.id_usuario = cl.id_gerente_c 
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio AND co.idCondominio = $idCondominio 
            INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
            LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = cl.lugar_prospeccion AND oxc.id_catalogo = 9 
            WHERE 
                lo.idStatusLote = 2            
            AND (cl.pre_proceso_casas = 0 OR cl.pre_proceso_casas IS NULL)
            ORDER BY lo.idLote
            ")->result();
    }

    public function getListaAsignacion(){
        $query = $this->db->query("SELECT 
            cli.id_cliente,
            CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno) AS cliente,
            UPPER(REPLACE(ISNULL(oxc.nombre, 'SIN ESPECIFICAR'), ' (especificar)', '')) AS lugar_prospeccion,
            FORMAT(ISNULL(lo.totalNeto2, '0.00'), 'C') precioTotalLote,
            CASE WHEN cli.telefono1 IS NULL THEN 'SIN ESPECIFICAR' ELSE cli.telefono1 END telefono1,
            CASE WHEN cli.telefono2 IS NULL THEN 'SIN ESPECIFICAR' ELSE cli.telefono2 END telefono2,
            CASE WHEN cli.telefono3 IS NULL THEN 'SIN ESPECIFICAR' ELSE cli.telefono3 END telefono3,
            CASE WHEN cli.correo IS NULL THEN 'SIN ESPECIFICAR' ELSE cli.correo END correo,
            CASE 
                WHEN cli.id_asesor_c = 0 THEN 'SIN ASESOR' ELSE CONCAT(usA.nombre, ' ', usA.apellido_paterno, ' ', usA.apellido_materno)
            END AS nombreAsesor,
            usA.id_usuario AS idAsesor,
            lo.idLote,
            lo.nombreLote,
            lo.sup,
            co.nombre AS condominio,
            re.nombreResidencial AS proyecto,
            CONCAT(usG.nombre, ' ', usG.apellido_paterno, ' ', usG.apellido_materno) AS gerente, lo.idLote
            FROM clientes cli
            INNER JOIN lotes lo ON lo.idLote = cli.idLote
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
            INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
            INNER JOIN usuarios usG ON usG.id_usuario = cli.id_gerente_c
            LEFT JOIN usuarios usA ON usA.id_usuario = cli.id_asesor_c
            LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = cli.lugar_prospeccion AND oxc.id_catalogo = 9 
            WHERE cli.id_gerente_c = ? AND cli.id_asesor_c = ?", array($this->idUsuario, 0));
        
        return $query;
    }

    public function getListaAsignacionEsquema(){
        $query = $this->db->query("SELECT 
            cli.id_cliente,
            CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno) AS cliente,
            UPPER(REPLACE(ISNULL(oxc.nombre, 'SIN ESPECIFICAR'), ' (especificar)', '')) AS lugar_prospeccion,
            FORMAT(ISNULL(lo.totalNeto2, '0.00'), 'C') precioTotalLote,
            CASE WHEN cli.telefono1 IS NULL THEN 'SIN ESPECIFICAR' ELSE cli.telefono1 END telefono1,
            CASE WHEN cli.telefono2 IS NULL THEN 'SIN ESPECIFICAR' ELSE cli.telefono2 END telefono2,
            CASE WHEN cli.telefono3 IS NULL THEN 'SIN ESPECIFICAR' ELSE cli.telefono3 END telefono3,
            CASE WHEN cli.correo IS NULL THEN 'SIN ESPECIFICAR' ELSE cli.correo END correo,
            CASE 
                WHEN cli.id_asesor_c = 0 THEN 'SIN ASESOR' ELSE CONCAT(usA.nombre, ' ', usA.apellido_paterno, ' ', usA.apellido_materno)
            END AS nombreAsesor,
            usA.id_usuario AS idAsesor,
            lo.idLote,
            lo.nombreLote,
            lo.sup,
            co.nombre AS condominio,
            re.descripcion AS proyecto,
            CONCAT(usG.nombre, ' ', usG.apellido_paterno, ' ', usG.apellido_materno) AS gerente,
            cli.id_subdirector_c, cli.id_gerente_c
            FROM clientes cli
            INNER JOIN lotes lo ON lo.idLote = cli.idLote
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
            INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
            INNER JOIN usuarios usG ON usG.id_usuario = cli.id_gerente_c
            LEFT JOIN usuarios usA ON usA.id_usuario = cli.id_asesor_c
            LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = cli.lugar_prospeccion AND oxc.id_catalogo = 9 
            WHERE cli.id_asesor_c = ? AND cli.esquemaCreditoCasas IN (0,1) AND cli.pre_proceso_casas = 2
            AND cli.idPropuestaCasa IS NULL", array($this->idUsuario));
        
        return $query;
    }

    public function addLoteToAsignacion($idLote, $comentario, $idUsuario){
        $query = "INSERT INTO proceso_casas_banco
        (
            idLote,
            comentario,
            creadoPor
        )
        VALUES
        (
            $idLote,
            '$comentario',
            $idUsuario
        )";

        $result = $this->db->query($query);

        if($result){
            $query = "SELECT TOP 1 * FROM proceso_casas_banco ORDER BY idProcesoCasas DESC";
            return $this->db->query($query)->row();
        }else{
            return null;
        }
    }

    public function addLoteToAsignacionDirecto($idLote, $comentario, $idUsuario){
        $query = "INSERT INTO proceso_casas_directo
        (
            idLote,
            comentario,
            creadoPor
        )
        VALUES
        (
            $idLote,
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
            idProcesoCasas = $idProcesoCasas AND cpc.archivo IS NOT NULL
        AND status = 1";

        return $this->db->query($query)->result();
    }

    public function asignarAsesor($idProcesoCasas, $idAsesor){
        $query = "UPDATE proceso_casas_banco
        SET
            idAsesor = $idAsesor
        WHERE
            idProcesoCasas = $idProcesoCasas";

        return $this->db->query($query);
    }

    public function setProcesoToCartaAuth($idProcesoCasas){
        $query = "UPDATE proceso_casas_banco
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
        vpc.*,
        cli.id_cliente,
        con.nombre AS condominio,
        resi.descripcion AS proyecto,
        CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno) AS cliente,
        (CASE
            WHEN cli.id_asesor_c IS NOT NULL THEN CONCAT(us_asesor.nombre, ' ', us_asesor.apellido_paterno, ' ', us_asesor.apellido_materno)
            ELSE 'Sin asignar'
        END) AS nombreAsesor,
        CASE
            WHEN DATEDIFF(DAY, GETDATE() , pc.fechaProceso) < 0 THEN CAST(CONCAT(0, ' ', 'DIA(S)') AS VARCHAR) ELSE CAST(CONCAT(DATEDIFF(DAY, GETDATE() , pc.fechaProceso), ' ', 'DIA(S)') AS VARCHAR)
        END AS tiempoProceso,
        CASE
        WHEN cli.id_gerente_c IS NULL THEN 'SIN ESPECIFICAR'
        ELSE CONCAT(us_gere.nombre, ' ', us_gere.apellido_paterno, ' ', us_gere.apellido_materno)

		END AS gerente,
        oxc.nombre AS movimiento
        FROM proceso_casas_banco pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        INNER JOIN clientes cli ON cli.idLote = lo.idLote 
        LEFT JOIN usuarios us_gere ON us_gere.id_usuario = cli.id_gerente_c
        LEFT JOIN usuarios us_asesor ON us_asesor.id_usuario = cli.id_asesor_c
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
        INNER JOIN residenciales resi ON resi.idResidencial = con.idResidencial
        LEFT JOIN opcs_x_cats oxc ON oxc.id_catalogo = 136 AND oxc.id_opcion = pc.tipoMovimiento
        LEFT JOIN vobos_proceso_casas vpc ON vpc.idVobo = pc.idProcesoCasas
        LEFT JOIN documentos_proceso_casas doc ON doc.idProcesoCasas = pc.idProcesoCasas AND doc.tipo = 1 AND (doc.proveedor = 0 OR doc.proveedor IS NULL)
        WHERE pc.proceso = 1
        AND pc.status = 1
        AND cli.status = 1
        AND cli.id_asesor_c != 0
        AND cli.id_gerente_c != 0";

        return $this->db->query($query)->result();
    }

    public function cancelProcess($idProcesoCasas, $comentario){
        $query = "UPDATE proceso_casas_banco
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
            modificadoPor = $idModificacion
        WHERE
            idDocumento = $idDocumento";

        return $this->db->query($query);
    }

    public function getVobos($idProceso, $paso){

        $id = (int) $idProceso;

        $query = "SELECT * FROM vobos_proceso_casas WHERE idProceso =$id AND paso = $paso";

        return $this->db->query($query)->row();
    }

    public function updateVobos($idProceso, $paso, $data){
        $query = "SELECT * FROM vobos_proceso_casas WHERE idProceso =$idProceso AND paso = $paso";

        $vobo = $this->db->query($query)->row();

        if($vobo){
            $is_ok = $this->db->update('vobos_proceso_casas', $data, "idVobo = $vobo->idVobo");
        }else{
            $data['idProceso'] = $idProceso;
            $data['paso'] = $paso;

            $is_ok = $this->db->insert('vobos_proceso_casas', $data);
        }

        return $this->db->query($query)->row();
    }

    public function getListaConcentradoAdeudos($rol){
        $vobo = "";
        $extraColumns = "";
        $columnName = "";
        $tableName = "";
        $estatus = "";
        $tableSeparator = "";
        if($rol == 99 || $rol == 11 || $rol == 33) {
            $extraColumns = "CASE
                WHEN pc.adeudoOOAM IS NULL THEN 'Sin registro'
                ELSE CONCAT('$', pc.adeudoOOAM) 
                END AS adOOAM,
                CASE
                WHEN pc.adeudoADM IS NULL THEN 'Sin registro'
                ELSE CONCAT('$', pc.adeudoADM) 
                END AS adADM,";
            $columnName = "idProcesoCasas";
            $tableName = "proceso_casas_banco";
            $estatus = "status";
            $tableSeparator = " 1 AS separator";
            if($rol == 99){
			    $vobo  = "AND vb.ooam = 0";
            }else if($rol == 11 || $rol == 33){
                $vobo = "AND vb.adm = 0";
            }
        }
        if($rol == 62) {
            $tableName = "proceso_casas_directo";
            $columnName = "idProceso";
            $estatus = "estatus";
            $tableSeparator = " 2 AS separator";
        }
        $query = "SELECT pc.*,
        
        lo.nombreLote,
        con.nombre AS condominio,
        resi.descripcion AS proyecto,
        $extraColumns
        CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno) AS cliente,
        (CASE
            WHEN us.nombre IS NOT NULL THEN CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)
            ELSE 'Sin asignar'
        END) AS nombreAsesor,
        CASE
			 WHEN cli.id_gerente_c IS NULL THEN 'SIN ESPECIFICAR'
			 ELSE CONCAT(us_gere.nombre, ' ', us_gere.apellido_paterno, ' ', us_gere.apellido_materno)
		END AS gerente,
        oxc.nombre AS movimiento,
        doc.documentos, 
        CASE WHEN se.id_lote = lo.idLote THEN 0 ELSE 1 END AS cargaRequerida,
        COALESCE(doc2.cuentaDocumentos, 0) cuentaDocumentos, se.id_estatus, $tableSeparator
        FROM $tableName pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        INNER JOIN clientes cli ON cli.idLote = lo.idLote 
        LEFT JOIN usuarios us_gere ON us_gere.id_usuario = cli.id_gerente_c
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
        INNER JOIN residenciales resi ON resi.idResidencial = con.idResidencial 
        LEFT JOIN usuarios us ON us.id_usuario = cli.id_asesor_c
        LEFT JOIN solicitudes_escrituracion se ON se.id_lote  = lo.idLote
        LEFT JOIN opcs_x_cats oxc ON oxc.id_catalogo = 136 AND oxc.id_opcion = pc.tipoMovimiento

        LEFT JOIN vobos_proceso_casas vb ON vb.idProceso = pc.$columnName AND vb.paso = 2
        LEFT JOIN (SELECT COUNT(*) AS documentos, idProcesoCasas FROM documentos_proceso_casas WHERE tipo IN (13,14,15) AND archivo IS NOT NULL AND proveedor = 0 GROUP BY idProcesoCasas) doc ON doc.idProcesoCasas = pc.$columnName
        LEFT JOIN (SELECT COUNT(*) AS cuentaDocumentos, idProcesoCasas FROM documentos_proceso_casas WHERE tipo = 11 AND archivo IS NOT NULL GROUP BY idProcesoCasas) doc2 ON doc2.idProcesoCasas = pc.$columnName
        WHERE pc.proceso IN (2, 3) AND pc.$estatus = 1 AND cli.status = 1 $vobo";

        

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
            WHEN cli.id_asesor_c IS NOT NULL THEN CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)
            ELSE 'Sin asignar'
        END AS nombreAsesor,
        CASE
            WHEN cli.id_gerente_c IS NULL THEN 'SIN ESPECIFICAR'
            ELSE CONCAT(us_gere.nombre, ' ', us_gere.apellido_paterno, ' ', us_gere.apellido_materno)
        END AS gerente,
        oxc.nombre AS movimiento,
        doc2.documentos
    FROM 
        proceso_casas_banco pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        INNER JOIN clientes cli ON cli.idLote = lo.idLote 
        LEFT JOIN usuarios us_gere ON us_gere.id_usuario = cli.id_gerente_c
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
        INNER JOIN residenciales resi ON resi.idResidencial = con.idResidencial 
        LEFT JOIN usuarios us ON us.id_usuario = cli.id_asesor_c
        LEFT JOIN opcs_x_cats oxc ON oxc.id_catalogo = 136 AND oxc.id_opcion = pc.tipoMovimiento
        LEFT JOIN vobos_proceso_casas vb ON vb.idProceso = pc.idProcesoCasas AND vb.paso = 2
        LEFT JOIN (SELECT COUNT(*) AS documentos, idProcesoCasas FROM documentos_proceso_casas WHERE tipo IN (13,14,15) AND archivo IS NOT NULL AND proveedor = 0 GROUP BY idProcesoCasas) doc2 ON doc2.idProcesoCasas = pc.idProcesoCasas
    WHERE 
        pc.proceso IN (2, 3) 
        AND pc.status = 1 
        AND cli.status = 1
        AND vb.proyectos != 1";

        return $this->db->query($query)->result();
    }

    public function inserDocumentsToProceso($idProcesoCasas, $tipo, $documento){
        $creadoPor = $this->session->userdata('id_usuario');

        $query = "BEGIN
            IF NOT EXISTS (SELECT * FROM documentos_proceso_casas 
                           WHERE tipo = $tipo
                           AND idProcesoCasas = $idProcesoCasas
                           AND proveedor = 0)
            BEGIN
                INSERT INTO documentos_proceso_casas (idProcesoCasas, tipo, documento, creadoPor)
                VALUES ($idProcesoCasas, $tipo, '$documento', $creadoPor)
            END
        END";

        return $this->db->query($query);
    }

    public function insertDocumentosProveedorToProceso($idProcesoCasas, $tipo, $documento){
        $creadoPor = $this->session->userdata('id_usuario');

        $query = "BEGIN
            IF NOT EXISTS (SELECT * FROM documentos_proceso_casas 
                           WHERE tipo = $tipo
                           AND idProcesoCasas = $idProcesoCasas
                           AND proveedor = 1)
            BEGIN
                INSERT INTO documentos_proceso_casas (idProcesoCasas, tipo, documento, creadoPor, proveedor)
                VALUES ($idProcesoCasas, $tipo, '$documento', $creadoPor, 1)
            END
        END";

        return $this->db->query($query);
    }

    public function insertCotizacion($idProcesoCasas){
        $creadoPor = $this->session->userdata('id_usuario');

        $query = "BEGIN
            IF (SELECT COUNT(*) FROM cotizacion_proceso_casas WHERE idProcesoCasas = $idProcesoCasas) < 3
                BEGIN
                    INSERT INTO cotizacion_proceso_casas (idProcesoCasas, nombre, status, fechaCreacion, idModificacion)
                    VALUES ($idProcesoCasas, '', 1, GETDATE(), $creadoPor)
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
			 WHEN cli.id_gerente_c IS NULL THEN 'SIN ESPECIFICAR'
			 ELSE CONCAT(us_gere.nombre, ' ', us_gere.apellido_paterno, ' ', us_gere.apellido_materno)
		END AS gerente,
        oxc.nombre AS movimiento
        FROM proceso_casas_banco pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        LEFT JOIN (SELECT COUNT(*) AS documentos, idProcesoCasas FROM documentos_proceso_casas WHERE tipo IN (2,3,4,5,6,7,8,10,11,12,13,14,15) AND archivo IS NOT NULL AND proveedor = 0 GROUP BY idProcesoCasas) doc ON doc.idProcesoCasas = pc.idProcesoCasas
        INNER JOIN clientes cli ON cli.idLote = lo.idLote 
        LEFT JOIN usuarios us_gere ON us_gere.id_usuario = cli.id_gerente_c
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
        INNER JOIN residenciales resi ON resi.idResidencial = con.idResidencial 
        LEFT JOIN usuarios us ON us.id_usuario = cli.id_asesor_c
        LEFT JOIN opcs_x_cats oxc ON oxc.id_catalogo = 136 AND oxc.id_opcion = pc.tipoMovimiento
        WHERE
            pc.proceso IN (4) 
        AND pc.status = 1
        AND cli.status = 1
        AND cli.id_gerente_c IN ($gerentes)";

        return $this->db->query($query)->result();
    }

    public function getListaDocumentosCliente($idProcesoCasas, $docs){
        $in = implode(',', $docs);

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
        AND tipo IN ($in)
        AND proveedor = 0";

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
			 WHEN cli.id_gerente_c IS NULL THEN 'SIN ESPECIFICAR'
			 ELSE CONCAT(us_gere.nombre, ' ', us_gere.apellido_paterno, ' ', us_gere.apellido_materno)
		END AS gerente
        FROM proceso_casas_banco pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        LEFT JOIN (SELECT COUNT(*) AS documentos, idProcesoCasas FROM documentos_proceso_casas WHERE tipo IN (13,14,15) AND archivo IS NOT NULL AND proveedor = 0 GROUP BY idProcesoCasas) doc ON doc.idProcesoCasas = pc.idProcesoCasas
        INNER JOIN clientes cli ON cli.idLote = lo.idLote 
        LEFT JOIN usuarios us_gere ON us_gere.id_usuario = cli.id_gerente_c
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
        INNER JOIN residenciales resi ON resi.idResidencial = con.idResidencial 
        LEFT JOIN usuarios us ON us.id_usuario = cli.id_asesor_c
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
        AND tipo IN (13,14,15)
        AND proveedor = 0";

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
             WHEN cli.id_gerente_c IS NULL THEN 'SIN ESPECIFICAR'
             ELSE CONCAT(us_gere.nombre, ' ', us_gere.apellido_paterno, ' ', us_gere.apellido_materno)
        END AS gerente,
        oxc.nombre AS movimiento
        FROM proceso_casas_banco pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        LEFT JOIN (SELECT COUNT(*) AS documentos, idProcesoCasas FROM documentos_proceso_casas WHERE tipo IN (16) AND archivo IS NOT NULL AND proveedor = 0 GROUP BY idProcesoCasas) doc ON doc.idProcesoCasas = pc.idProcesoCasas
        INNER JOIN clientes cli ON cli.idLote = lo.idLote 
        LEFT JOIN usuarios us_gere ON us_gere.id_usuario = cli.id_gerente_c
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
        INNER JOIN residenciales resi ON resi.idResidencial = con.idResidencial 
        LEFT JOIN usuarios us ON us.id_usuario = cli.id_asesor_c
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
        AND tipo IN (13,14,15,16)
        AND proveedor = 0";

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
        CASE
            WHEN DATEDIFF(DAY, GETDATE() , pc.fechaProceso) < 0 THEN CAST(CONCAT(0, ' ', 'DIA(S)') AS VARCHAR) ELSE CAST(CONCAT(DATEDIFF(DAY, GETDATE() , pc.fechaProceso), ' ', 'DIA(S)') AS VARCHAR)
        END AS tiempoProceso,
        cpc.idCotizacion AS cotizacionElegida,
        con.nombre AS condominio,
        resi.descripcion AS proyecto,
        CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno) AS cliente,
        (CASE
            WHEN cli.id_asesor_c IS NOT NULL THEN CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)
            ELSE 'Sin asignar'
        END) AS nombreAsesor,
        CASE
			 WHEN cli.id_gerente_c IS NULL THEN 'SIN ESPECIFICAR'
			 ELSE CONCAT(us_gere.nombre, ' ', us_gere.apellido_paterno, ' ', us_gere.apellido_materno)
		END AS gerente,
        oxc2.nombre AS movimiento
        FROM proceso_casas_banco pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        LEFT JOIN documentos_proceso_casas doc ON doc.idProcesoCasas = pc.idProcesoCasas AND tipo = 18 AND proveedor = 0
        LEFT JOIN propuestas_proceso_casas pro ON pro.idProcesoCasas = pc.idProcesoCasas AND pro.status = 1
        LEFT JOIN cotizacion_proceso_casas cpc ON cpc.idProcesoCasas = pc.idProcesoCasas AND cpc.idCotizacion = pc.cotizacionElegida
        LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = pc.notaria AND oxc.id_catalogo = 129
        INNER JOIN clientes cli ON cli.idLote = lo.idLote 
        LEFT JOIN usuarios us_gere ON us_gere.id_usuario = cli.id_gerente_c
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
        INNER JOIN residenciales resi ON resi.idResidencial = con.idResidencial 
        LEFT JOIN usuarios us ON us.id_usuario = cli.id_asesor_c
        LEFT JOIN opcs_x_cats oxc2 ON oxc2.id_catalogo = 136 AND oxc2.id_opcion = pc.tipoMovimiento
        WHERE
            pc.proceso = 9
        	AND pc.status = 1 
            AND cli.status = 1";

        return $this->db->query($query)->result();
    }

    public function setProcesoToValidacionContraloria($idProcesoCasas){
        $query = "UPDATE proceso_casas_banco
        SET
            proceso = 7,
            fechaProceso = GETDATE()
        WHERE
            idProcesoCasas = $idProcesoCasas";

        return $this->db->query($query);
    }

    public function getListaPropuestaFirma($rol){

        if($rol == 57){
            $query = "WITH UltimoValor AS (
              SELECT
                procesoAnterior,
                procesoNuevo, 
                fechaMovimiento, 
                idProcesoCasas, 
                ROW_NUMBER() OVER ( PARTITION BY idProcesoCasas ORDER BY fechaMovimiento DESC) AS rn 
              FROM historial_proceso_casas hpc 
              WHERE esquemaCreditoProceso = 1
            )
            
            SELECT
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
                    WHEN cli.id_asesor_c IS NOT NULL THEN CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)
                    ELSE 'Sin asignar'
                END) AS nombreAsesor,
                CASE
                        WHEN cli.id_gerente_c IS NULL THEN 'SIN ESPECIFICAR'
                        ELSE CONCAT(us_gere.nombre, ' ', us_gere.apellido_paterno, ' ', us_gere.apellido_materno)
                END AS gerente,
            oxc.nombre AS movimiento,
            doc.documentos,
            doc2.documentos AS titulacion,
            doc3.idDocumento,
            doc3.documento,
            doc3.archivo,
            oxc2.nombre AS nombreArchivo,
            coti.cotizacionCargada,
            u.*
            FROM proceso_casas_banco pc
            LEFT JOIN lotes lo ON lo.idLote = pc.idLote
            LEFT JOIN propuestas_proceso_casas pro ON pro.idProcesoCasas = pc.idProcesoCasas AND pro.status = 1
            INNER JOIN clientes cli ON cli.idLote = lo.idLote 
            LEFT JOIN usuarios us_gere ON us_gere.id_usuario = cli.id_gerente_c
            INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
            INNER JOIN residenciales resi ON resi.idResidencial = con.idResidencial 
            LEFT JOIN usuarios us ON us.id_usuario = cli.id_asesor_c
            LEFT JOIN (SELECT count(*) AS archivos_faltantes, idProcesoCasas FROM cotizacion_proceso_casas WHERE status = 1 AND archivo IS NULL GROUP BY idProcesoCasas) cpc ON cpc.idProcesoCasas = pc.idProcesoCasas
            LEFT JOIN opcs_x_cats oxc ON oxc.id_catalogo = 136 AND oxc.id_opcion = pc.tipoMovimiento
            LEFT JOIN (SELECT COUNT(*) AS documentos, idProcesoCasas FROM documentos_proceso_casas WHERE tipo IN (17) AND archivo IS NOT NULL AND proveedor = 0 GROUP BY idProcesoCasas) doc ON doc.idProcesoCasas = pc.idProcesoCasas
            LEFT JOIN (SELECT COUNT(*) AS documentos, idProcesoCasas FROM documentos_proceso_casas WHERE tipo IN (17) AND archivo IS NOT NULL AND proveedor = 0 GROUP BY idProcesoCasas) doc2 ON doc2.idProcesoCasas = pc.idProcesoCasas
            LEFT JOIN documentos_proceso_casas doc3 ON doc3.idProcesoCasas = pc.idProcesoCasas AND doc3.tipo = 17 AND doc3.proveedor = 0
            LEFT JOIN opcs_x_cats oxc2 ON oxc2.id_opcion = 17 AND oxc2.id_catalogo = 126
            LEFT JOIN UltimoValor u ON u.idProcesoCasas = pc.idProcesoCasas and u.rn = 1
            LEFT JOIN (SELECT idProcesoCasas, COUNT(*) AS cotizacionCargada  FROM cotizacion_proceso_casas WHERE archivo IS NOT NULL GROUP BY idProcesoCasas ) coti ON coti.idProcesoCasas = pc.idProcesoCasas 
            WHERE pc.proceso = 8
            AND pc.status = 1 AND cli.status = 1";

        }else if($rol == 101){

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
                    WHEN cli.id_asesor_c IS NOT NULL THEN CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)
                    ELSE 'Sin asignar'
                END) AS nombreAsesor,
                CASE
                        WHEN cli.id_gerente_c IS NULL THEN 'SIN ESPECIFICAR'
                        ELSE CONCAT(us_gere.nombre, ' ', us_gere.apellido_paterno, ' ', us_gere.apellido_materno)
                END AS gerente,
            oxc.nombre AS movimiento,
            doc.documentos,
            doc2.documentos AS constancia,
            doc3.idDocumento,
            doc3.documento,
            doc3.archivo,
            oxc2.nombre AS nombreArchivo,
            coti.cotizacionCargada
            FROM proceso_casas_banco pc
            LEFT JOIN lotes lo ON lo.idLote = pc.idLote
            LEFT JOIN propuestas_proceso_casas pro ON pro.idProcesoCasas = pc.idProcesoCasas AND pro.status = 1
            INNER JOIN clientes cli ON cli.idLote = lo.idLote 
            LEFT JOIN usuarios us_gere ON us_gere.id_usuario = cli.id_gerente_c
            INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
            INNER JOIN residenciales resi ON resi.idResidencial = con.idResidencial 
            LEFT JOIN usuarios us ON us.id_usuario = cli.id_asesor_c
            LEFT JOIN (SELECT count(*) AS archivos_faltantes, idProcesoCasas FROM cotizacion_proceso_casas WHERE status = 1 AND archivo IS NULL GROUP BY idProcesoCasas) cpc ON cpc.idProcesoCasas = pc.idProcesoCasas
            LEFT JOIN opcs_x_cats oxc ON oxc.id_catalogo = 136 AND oxc.id_opcion = pc.tipoMovimiento
            LEFT JOIN (SELECT COUNT(*) AS documentos, idProcesoCasas FROM documentos_proceso_casas WHERE tipo IN (17, 28) AND archivo IS NOT NULL AND proveedor = 0 GROUP BY idProcesoCasas) doc ON doc.idProcesoCasas = pc.idProcesoCasas
            LEFT JOIN (SELECT COUNT(*) AS documentos, idProcesoCasas FROM documentos_proceso_casas WHERE tipo IN (28) AND archivo IS NOT NULL AND proveedor = 0 GROUP BY idProcesoCasas) doc2 ON doc2.idProcesoCasas = pc.idProcesoCasas
            LEFT JOIN documentos_proceso_casas doc3 ON doc3.idProcesoCasas = pc.idProcesoCasas AND doc3.tipo = 28 AND doc3.proveedor = 0
            LEFT JOIN opcs_x_cats oxc2 ON oxc2.id_opcion = 28 AND oxc2.id_catalogo = 126
            LEFT JOIN (SELECT idProcesoCasas, COUNT(*) AS cotizacionCargada  FROM cotizacion_proceso_casas WHERE archivo IS NOT NULL GROUP BY idProcesoCasas ) coti ON coti.idProcesoCasas = pc.idProcesoCasas 
            LEFT JOIN (SELECT TOP 1 * FROM vobos_proceso_casas vb WHERE vb.paso = 3) vb ON vb.idProceso = pc.idProcesoCasas 
            WHERE pc.proceso = 8
            AND pc.status = 1 AND cli.status = 1 AND vb.gph = 0";
        }

        

        return $this->db->query($query)->result();
    }

    public function getListaCargaKitBancario(){
        $query = "SELECT
        pc.*,
        vb.*,
        lo.nombreLote,
        con.nombre AS condominio,
        resi.descripcion AS proyecto,
        CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno) AS cliente,
        (CASE
            WHEN cli.id_asesor_c IS NOT NULL THEN CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)
            ELSE 'Sin asignar'
        END) AS nombreAsesor,
        CASE
			 WHEN cli.id_gerente_c IS NULL THEN 'SIN ESPECIFICAR'
			 ELSE CONCAT(us_gere.nombre, ' ', us_gere.apellido_paterno, ' ', us_gere.apellido_materno)
		END AS gerente,
        CASE
            WHEN DATEDIFF(DAY, GETDATE() , pc.fechaProceso) < 0 THEN CAST(CONCAT(0, ' ', 'DIA(S)') AS VARCHAR) ELSE CAST(CONCAT(DATEDIFF(DAY, GETDATE() , pc.fechaProceso), ' ', 'DIA(S)') AS VARCHAR)
        END AS tiempoProceso,
        oxc2.nombre AS nombreArchivo,
        doc.documentos AS kit,
        doc2.idDocumento,
        doc2.documento,
        doc2.archivo,
        oxc.nombre AS movimiento
        FROM proceso_casas_banco pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        INNER JOIN clientes cli ON cli.idLote = lo.idLote 
        LEFT JOIN usuarios us_gere ON us_gere.id_usuario = cli.id_gerente_c
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
        INNER JOIN residenciales resi ON resi.idResidencial = con.idResidencial 
        LEFT JOIN usuarios us ON us.id_usuario = cli.id_asesor_c
        LEFT JOIN opcs_x_cats oxc ON oxc.id_catalogo = 136 AND oxc.id_opcion = pc.tipoMovimiento
        LEFT JOIN (SELECT COUNT(*) AS documentos, idProcesoCasas FROM documentos_proceso_casas WHERE tipo IN (31) AND archivo IS NOT NULL AND proveedor = 0 GROUP BY idProcesoCasas) doc ON doc.idProcesoCasas = pc.idProcesoCasas
        LEFT JOIN documentos_proceso_casas doc2 ON doc2.idProcesoCasas = pc.idProcesoCasas AND doc2.tipo = 31 AND doc2.proveedor = 0
        LEFT JOIN opcs_x_cats oxc2 ON oxc2.id_opcion = 31 AND oxc2.id_catalogo = 126
        LEFT JOIN vobos_proceso_casas vb ON vb.idProceso = pc.idProcesoCasas AND vb.paso = 2
        WHERE pc.proceso IN (11, 12)
        AND pc.status = 1 AND cli.status = 1
        AND vb.comercializacion != 1";

        return $this->db->query($query)->result();
    }

    public function getListaValidaContraloria(){
        $query = " SELECT
        pc.*,
        cli.id_cliente,
        lo.nombreLote,
        con.nombre AS condominio,
        resi.descripcion AS proyecto,
        CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno) AS cliente,
        (CASE
            WHEN cli.id_asesor_c IS NOT NULL THEN CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)
            ELSE 'Sin asignar'
        END) AS nombreAsesor,
        CASE
            WHEN DATEDIFF(DAY, GETDATE() , pc.fechaProceso) < 0 THEN CAST(CONCAT(0, ' ', 'DIA(S)') AS VARCHAR) ELSE CAST(CONCAT(DATEDIFF(DAY, GETDATE() , pc.fechaProceso), ' ', 'DIA(S)') AS VARCHAR)
        END AS tiempoProceso,
        CASE
			 WHEN cli.id_gerente_c IS NULL THEN 'SIN ESPECIFICAR'
			 ELSE CONCAT(us_gere.nombre, ' ', us_gere.apellido_paterno, ' ', us_gere.apellido_materno)
		END AS gerente,
        oxc2.nombre AS nombreArchivo,
        doc2.idDocumento,
        doc2.documento,
        doc2.archivo,
        oxc.nombre AS movimiento
        FROM proceso_casas_banco pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        INNER JOIN clientes cli ON cli.idLote = lo.idLote 
        LEFT JOIN usuarios us_gere ON us_gere.id_usuario = cli.id_gerente_c
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
        INNER JOIN residenciales resi ON resi.idResidencial = con.idResidencial 
        LEFT JOIN usuarios us ON us.id_usuario = cli.id_asesor_c
        LEFT JOIN opcs_x_cats oxc ON oxc.id_catalogo = 136 AND oxc.id_opcion = pc.tipoMovimiento
        LEFT JOIN (SELECT COUNT(*) AS documentos, idProcesoCasas FROM documentos_proceso_casas WHERE tipo IN (30) AND archivo IS NOT NULL AND proveedor = 0 GROUP BY idProcesoCasas) doc ON doc.idProcesoCasas = pc.idProcesoCasas
        LEFT JOIN documentos_proceso_casas doc2 ON doc2.idProcesoCasas = pc.idProcesoCasas AND doc2.tipo = 30 AND doc2.proveedor = 0
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
        $query = "UPDATE proceso_casas_banco
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
    			 WHEN cli.id_gerente_c IS NULL THEN 'SIN ESPECIFICAR'
    			 ELSE CONCAT(us_gere.nombre, ' ', us_gere.apellido_paterno, ' ', us_gere.apellido_materno)
    		END AS gerente,
            oxc.nombre AS movimiento
        FROM proceso_casas_banco pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        LEFT JOIN (SELECT COUNT(*) AS documentos, idProcesoCasas FROM documentos_proceso_casas WHERE tipo IN (19,20,21,22) AND archivo IS NOT NULL AND proveedor = 0 GROUP BY idProcesoCasas) doc ON doc.idProcesoCasas = pc.idProcesoCasas
        INNER JOIN clientes cli ON cli.idLote = lo.idLote 
        LEFT JOIN usuarios us_gere ON us_gere.id_usuario = cli.id_gerente_c
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
        INNER JOIN residenciales resi ON resi.idResidencial = con.idResidencial 
        LEFT JOIN usuarios us ON us.id_usuario = cli.id_asesor_c
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
        AND tipo IN ($tipos)
        AND proveedor = 0";

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
                 WHEN cli.id_gerente_c IS NULL THEN 'SIN ESPECIFICAR'
                 ELSE CONCAT(us_gere.nombre, ' ', us_gere.apellido_paterno, ' ', us_gere.apellido_materno)
            END AS gerente,
            oxc.nombre AS movimiento,
            doc.documentos
        FROM proceso_casas_banco pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        INNER JOIN clientes cli ON cli.idLote = lo.idLote 
        LEFT JOIN usuarios us_gere ON us_gere.id_usuario = cli.id_gerente_c
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
        INNER JOIN residenciales resi ON resi.idResidencial = con.idResidencial 
        LEFT JOIN usuarios us ON us.id_usuario = cli.id_asesor_c
        LEFT JOIN opcs_x_cats oxc ON oxc.id_catalogo = 136 AND oxc.id_opcion = pc.tipoMovimiento
        LEFT JOIN (SELECT COUNT(*) AS documentos, idProcesoCasas FROM documentos_proceso_casas WHERE tipo IN (19,20,21,22) AND archivo IS NOT NULL AND proveedor = 0 GROUP BY idProcesoCasas) doc ON doc.idProcesoCasas = pc.idProcesoCasas
        WHERE
            pc.proceso IN (8,9)
        AND pc.status = 1
        AND cli.status = 1
        AND cli.id_gerente_c IN ($gerentes)";

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
	            WHEN cli.id_asesor_c IS NOT NULL THEN CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)
	            ELSE 'Sin asignar'
	        END) AS nombreAsesor,
	        CASE
				 WHEN cli.id_gerente_c IS NULL THEN 'SIN ESPECIFICAR'
				 ELSE CONCAT(us_gere.nombre, ' ', us_gere.apellido_paterno, ' ', us_gere.apellido_materno)
			END AS gerente,
            CASE
                WHEN DATEDIFF(DAY, GETDATE() , pc.fechaProceso) < 0 THEN CAST(CONCAT(0, ' ', 'DIA(S)') AS VARCHAR) ELSE CAST(CONCAT(DATEDIFF(DAY, GETDATE() , pc.fechaProceso), ' ', 'DIA(S)') AS VARCHAR)
            END AS tiempoProceso,
            oxc.nombre AS movimiento,
            oxc2.nombre AS nombreArchivo
        FROM proceso_casas_banco pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        INNER JOIN clientes cli ON cli.idLote = lo.idLote 
        LEFT JOIN usuarios us_gere ON us_gere.id_usuario = cli.id_gerente_c
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
        INNER JOIN residenciales resi ON resi.idResidencial = con.idResidencial 
        LEFT JOIN usuarios us ON us.id_usuario = cli.id_asesor_c
        LEFT JOIN documentos_proceso_casas doc ON doc.idProcesoCasas = pc.idProcesoCasas AND doc.tipo = 38 AND doc.proveedor = 0
        LEFT JOIN (SELECT COUNT(*) AS documentos, idProcesoCasas FROM documentos_proceso_casas WHERE tipo IN (11) AND archivo IS NOT NULL AND proveedor = 0 GROUP BY idProcesoCasas) doc2 ON doc2.idProcesoCasas = pc.idProcesoCasas
        LEFT JOIN opcs_x_cats oxc ON oxc.id_catalogo = 136 AND oxc.id_opcion = pc.tipoMovimiento
        LEFT JOIN documentos_proceso_casas doc3 ON doc3.idProcesoCasas = pc.idProcesoCasas AND doc3.tipo = 31 AND doc3.proveedor = 0
        LEFT JOIN vobos_proceso_casas vb ON vb.idProceso = pc.idProcesoCasas AND vb.paso = 2
         LEFT JOIN opcs_x_cats oxc2 ON oxc2.id_opcion = 38 AND oxc2.id_catalogo = 126
        WHERE
            pc.proceso IN (11, 12)
        AND pc.status = 1 AND cli.status = 1
        AND vb.contraloria != 1";

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
				 WHEN cli.id_gerente_c IS NULL THEN 'SIN ESPECIFICAR'
				 ELSE CONCAT(us_gere.nombre, ' ', us_gere.apellido_paterno, ' ', us_gere.apellido_materno)
			END AS gerente,
            oxc.nombre AS movimiento
        FROM proceso_casas_banco pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        INNER JOIN clientes cli ON cli.idLote = lo.idLote 
        LEFT JOIN documentos_proceso_casas doc ON doc.idProcesoCasas = pc.idProcesoCasas AND doc.tipo = 25 AND doc.proveedor = 0
         LEFT JOIN usuarios us_gere ON us_gere.id_usuario = cli.id_gerente_c
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
        INNER JOIN residenciales resi ON resi.idResidencial = con.idResidencial 
        LEFT JOIN usuarios us ON us.id_usuario = cli.id_asesor_c
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
				 WHEN cli.id_gerente_c IS NULL THEN 'SIN ESPECIFICAR'
				 ELSE CONCAT(us_gere.nombre, ' ', us_gere.apellido_paterno, ' ', us_gere.apellido_materno)
			END AS gerente,
            oxc.nombre AS movimiento
        FROM proceso_casas_banco pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        INNER JOIN clientes cli ON cli.idLote = lo.idLote 
        LEFT JOIN usuarios us_gere ON us_gere.id_usuario = cli.id_gerente_c
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
        INNER JOIN residenciales resi ON resi.idResidencial = con.idResidencial 
        LEFT JOIN usuarios us ON us.id_usuario = cli.id_asesor_c
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
                 WHEN cli.id_gerente_c IS NULL THEN 'SIN ESPECIFICAR'
                 ELSE CONCAT(us_gere.nombre, ' ', us_gere.apellido_paterno, ' ', us_gere.apellido_materno)
            END AS gerente,
            oxc.nombre AS movimiento
        FROM proceso_casas_banco pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        INNER JOIN clientes cli ON cli.idLote = lo.idLote 
        LEFT JOIN usuarios us_gere ON us_gere.id_usuario = cli.id_gerente_c
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
        INNER JOIN residenciales resi ON resi.idResidencial = con.idResidencial 
        LEFT JOIN usuarios us ON us.id_usuario = cli.id_asesor_c
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
				 WHEN cli.id_gerente_c IS NULL THEN 'SIN ESPECIFICAR'
				 ELSE CONCAT(us_gere.nombre, ' ', us_gere.apellido_paterno, ' ', us_gere.apellido_materno)
			END AS gerente,
            oxc.nombre AS movimiento
        FROM proceso_casas_banco pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        INNER JOIN clientes cli ON cli.idLote = lo.idLote 
        LEFT JOIN usuarios us_gere ON us_gere.id_usuario = cli.id_gerente_c
	    INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
	    INNER JOIN residenciales resi ON resi.idResidencial = con.idResidencial 
	    LEFT JOIN usuarios us ON us.id_usuario = cli.id_asesor_c
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
				 WHEN cli.id_gerente_c IS NULL THEN 'SIN ESPECIFICAR'
				 ELSE CONCAT(us_gere.nombre, ' ', us_gere.apellido_paterno, ' ', us_gere.apellido_materno)
			END AS gerente,
            oxc.nombre AS movimiento
        FROM proceso_casas_banco pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        INNER JOIN clientes cli ON cli.idLote = lo.idLote 
        LEFT JOIN usuarios us_gere ON us_gere.id_usuario = cli.id_gerente_c
	    INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
	    INNER JOIN residenciales resi ON resi.idResidencial = con.idResidencial 
	    LEFT JOIN usuarios us ON us.id_usuario = cli.id_asesor_c
        LEFT JOIN opcs_x_cats oxc ON oxc.id_catalogo = 136 AND oxc.id_opcion = pc.tipoMovimiento
        WHERE
            pc.proceso = 15
        AND pc.status = 1
        AND cli.status = 1
        AND cli.id_gerente_c IN ($gerentes)";

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
                 WHEN cli.id_gerente_c IS NULL THEN 'SIN ESPECIFICAR'
                 ELSE CONCAT(us_gere.nombre, ' ', us_gere.apellido_paterno, ' ', us_gere.apellido_materno)
            END AS gerente,
            oxc.nombre AS movimiento
        FROM proceso_casas_banco pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        INNER JOIN clientes cli ON cli.idLote = lo.idLote 
        LEFT JOIN usuarios us_gere ON us_gere.id_usuario = cli.id_gerente_c
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
        INNER JOIN residenciales resi ON resi.idResidencial = con.idResidencial 
        LEFT JOIN usuarios us ON us.id_usuario = cli.id_asesor_c
        LEFT JOIN opcs_x_cats oxc ON oxc.id_catalogo = 136 AND oxc.id_opcion = pc.tipoMovimiento
        WHERE
            pc.proceso = 16
        AND pc.finalizado IN ($in)
        AND pc.status = 1 AND cli.status = 1";

        return $this->db->query($query)->result();
    }

    public function markProcesoFinalizado($idProcesoCasas){
        $query = "UPDATE proceso_casas_banco
        SET
            finalizado = 1,
            tipoMovimiento = 3,
            fechaProceso = GETDATE()
        WHERE
            idProcesoCasas = $idProcesoCasas";

        return $this->db->query($query);
    }

    public function setAdeudo($idProcesoCasas, $adeudo, $cantidad){
        $query = "UPDATE proceso_casas_banco
        SET $adeudo = $cantidad
        WHERE idProcesoCasas = $idProcesoCasas";

        return $this->db->query($query);
    }

    public function setProceso3($idProcesoCasas){
        $query = "UPDATE proceso_casas_banco
        SET proceso = 3
        WHERE idProcesoCasas = $idProcesoCasas";

        return $this->db->query($query);
    }

    public function getAdeudosValid($idProcesoCasas){
        $query = "SELECT adeudoOOAM, adeudoADM 
        FROM proceso_casas_banco 
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
            creadoPor,
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
            creadoPor,
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

        $query = "UPDATE proceso_casas_banco
        SET
            cotizacionElegida = $idCotizacion
        WHERE
            idProcesoCasas = $idProcesoCasas";

        return $this->db->query($query);
    }

    public function setTipoCredito($idProcesoCasas, $tipoCredito, $notaria){
        $query = "UPDATE proceso_casas_banco
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
                 WHEN cli.id_gerente_c IS NULL THEN 'SIN ESPECIFICAR'
                 ELSE CONCAT(us_gere.nombre, ' ', us_gere.apellido_paterno, ' ', us_gere.apellido_materno)
            END AS gerente,
            oxc.nombre AS procesoNombre,
            oxc2.nombre AS movimiento
        FROM proceso_casas_banco pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        INNER JOIN clientes cli ON cli.idLote = lo.idLote 
        LEFT JOIN usuarios us_gere ON us_gere.id_usuario = cli.id_gerente_c
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
        INNER JOIN residenciales resi ON resi.idResidencial = con.idResidencial 
        LEFT JOIN usuarios us ON us.id_usuario = cli.id_asesor_c
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
        AND tipo IN (17)
        AND proveedor = 0";

        return $this->db->query($query)->result();
    }

    public function setVoboToProceso($idProcesoCasas, $column){
        $query = "UPDATE proceso_casas_banco
        SET
            $column = 1
        WHERE
            idProcesoCasas = $idProcesoCasas";

        return $this->db->query($query);
    }

    public function resetVoBos($idProcesoCasas){
        $query = "UPDATE proceso_casas_banco
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
        FROM proceso_casas_banco pc
        INNER JOIN lotes lo ON lo.idLote = pc.idLote
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        INNER JOIN usuarios usA ON usA.id_usuario = cl.id_asesor_c 
        INNER JOIN usuarios usG ON usG.id_usuario = cl.id_gerente_c 
        LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = pc.tipoMovimiento AND id_catalogo = 136
		LEFT JOIN documentos_proceso_casas dpc ON dpc.idProcesoCasas = pc.idProcesoCasas AND dpc.tipo IN($tipoDocumento) AND dpc.proveedor = 0
        WHERE pc.proceso IN ($placeholders) AND pc.status IN(1) AND pc.finalizado = 0 $condicionExtra", $procesoArray, 1);

        return $query;
    }

    public function getVoboCierreCifras($proceso, $tipoDocumento, $condicionExtra, $column){
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
        FROM proceso_casas_banco pc
        INNER JOIN lotes lo ON lo.idLote = pc.idLote
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        INNER JOIN usuarios usA ON usA.id_usuario = cl.id_asesor_c
        INNER JOIN usuarios usG ON usG.id_usuario = cl.id_gerente_c
        LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = pc.tipoMovimiento AND id_catalogo = 136
		LEFT JOIN documentos_proceso_casas dpc ON dpc.idProcesoCasas = pc.idProcesoCasas AND dpc.tipo IN($tipoDocumento) AND dpc.proveedor = 0
        LEFT JOIN vobos_proceso_casas vb ON vb.idProceso = pc.idProcesoCasas AND vb.paso = 4
        WHERE $column pc.proceso IN ($placeholders) AND pc.status IN(1) AND pc.finalizado = 0 $condicionExtra", $procesoArray, 1);

        return $query;
    }

    public function getDocumentoCreditoBanco($id_documento){
        $query = $this->db->query("SELECT *FROM opcs_x_cats 
        WHERE id_catalogo = 126 AND id_opcion = ?", $id_documento)->row();

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
                modificadoPor
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
            SET archivo = '$filename', fechaModificacion = GETDATE(), modificadoPor = '$id_usuario'
            WHERE idProcesoCasas = $idProceso AND tipo = $id_documento";
        }

        return $this->db->query($query);
    }

    public function setVoBoSaldos($columna, $idProcesoCasas, $idUsuario){
        $query = $this->db->query("UPDATE proceso_casas_banco SET ". $columna ." = ?, fechaProceso = GETDATE(), fechaModificacion = GETDATE(), modificadoPor = ? WHERE idProcesoCasas = ?", array(1, $idUsuario, $idProcesoCasas));

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
        AND proveedor = 1";

        return $this->db->query($query)->result();
    }

    public function getDocumentosContratos($idProcesoCasas, $documentos){
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
        AND tipo IN ($documentos)
        AND proveedor = 0";

        return $this->db->query($query)->result();
    }

    public function countDocumentos($documentos, $proceso, $validacionExtra){
        $documentosArray = explode(',', $documentos);
        $placeholders = implode(',', array_fill(0, count($documentosArray), '?'));

        $query = $this->db->query("WITH UltimoValor AS (
              SELECT 
                procesoAnterior,
                procesoNuevo, 
                fechaMovimiento, 
                idProcesoCasas, 
                ROW_NUMBER() OVER ( PARTITION BY idProcesoCasas ORDER BY fechaMovimiento DESC) AS rn 
              FROM historial_proceso_casas hpc 
              WHERE esquemaCreditoProceso = 1
            )

            SELECT 
            pc.*,
            u.*,
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
                WHEN cli.id_asesor_c IS NOT NULL THEN CONCAT(usA.nombre, ' ', usA.apellido_paterno, ' ', usA.apellido_materno)
                ELSE 'Sin asignar'
            END AS nombreAsesor,
            CASE
                WHEN cli.id_gerente_c IS NULL THEN 'SIN ESPECIFICAR'
                ELSE CONCAT(usG.nombre, ' ', usG.apellido_paterno, ' ', usG.apellido_materno)
            END AS gerente,
            oxc.nombre AS movimiento,
            doc2.documentos,
            CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno) AS nombreCliente,
            CONCAT(usA.nombre, ' ', usA.apellido_paterno, ' ', usA.apellido_materno) AS nombreAsesor,
            CONCAT(usG.nombre, ' ', usG.apellido_paterno, ' ', usG.apellido_materno) AS nombreGerente,
            pc.tipoMovimiento, cli.idPropuestaCasa, cli.id_cliente
        FROM
            proceso_casas_banco pc
            LEFT JOIN lotes lo ON lo.idLote = pc.idLote
            INNER JOIN clientes cli ON cli.idLote = lo.idLote
            INNER JOIN condominios con ON con.idCondominio = lo.idCondominio
            INNER JOIN residenciales resi ON resi.idResidencial = con.idResidencial
            INNER JOIN usuarios usA ON usA.id_usuario = cli.id_asesor_c
            INNER JOIN usuarios usG ON usG.id_usuario = cli.id_gerente_c
            LEFT JOIN UltimoValor u ON u.idProcesoCasas = pc.idProcesoCasas and u.rn = 1
            LEFT JOIN opcs_x_cats oxc ON oxc.id_catalogo = 136 AND oxc.id_opcion = pc.tipoMovimiento
            LEFT JOIN (SELECT COUNT(*) AS documentos, idProcesoCasas FROM documentos_proceso_casas WHERE tipo IN (" . $placeholders . ") AND archivo IS NOT NULL AND proveedor = 0 GROUP BY idProcesoCasas) doc2 ON doc2.idProcesoCasas = pc.idProcesoCasas
        WHERE 
            pc.proceso IN (" . $proceso . ")
            AND pc.status = 1 
            AND cli.status = 1 $validacionExtra", $documentosArray);

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
        AND tipo IN (2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 23, 36, 37, 38)
        AND proveedor = 0";

        return $this->db->query($query)->result();
    }

    public function rechazoPaso12($idProceso){
        $query = $this->db->query("UPDATE vobos_proceso_casas SET comercializacion = ? WHERE idProceso = ? AND paso = ?", array(0, $idProceso, 2));

        return $query;
    }

    public function removerBanderaPaso12($idVobo){
        $query = $this->db->query("UPDATE vobos_proceso_casas SET contraloria = 0 WHERE idVobo = ?", $idVobo);

        return $query;
    }

    public function getEsquemaOptions(){
        $query = $this->db->query("SELECT nombre AS label, id_opcion AS value FROM opcs_x_cats WHERE id_catalogo = ? AND id_opcion != ?", array(151, 0));

        return $query;
    }

    public function getModeloOptions(){
        $query = $this->db->query("SELECT UPPER(CONCAT(modelo, ', Sup (', sup, ')')) label, idModelo AS value FROM modelos_casas");

        return $query;
    }

    function insertProceso($procesoData, $tabla){
        $this->db->insert($tabla, $procesoData);
        $insert_id = $this->db->insert_id();
     
        return $insert_id;
    }

    public function setTipoProveedor($idProcesoCasas, $tipoProveedor){
        return $this->db->query("UPDATE proceso_casas_banco 
            SET tipoProveedor=$tipoProveedor
            WHERE idProcesoCasas=$idProcesoCasas");
    }

    public function insertDocumentosProveedor($idProcesoCasas, $tipoProveedor){
        $id_catalogo = 157;
        if($tipoProveedor == 2){
            $id_catalogo = 158;
        }

        // Eliminamos los documentos anteriores
        $this->db->query("DELETE FROM documentos_proceso_casas WHERE idProcesoCasas=$idProcesoCasas AND proveedor = 1");

        // Obtenemos los nuevos documentos
        $documentos = $this->db->query("SELECT * FROM opcs_x_cats WHERE id_catalogo = $id_catalogo AND estatus = 1")->result();

        // Agregamos los nuevos documentos
        foreach ($documentos as $key => $documento) {
            $this->db->query("INSERT INTO documentos_proceso_casas (
                idProcesoCasas,
                documento,
                tipo,
                proveedor,
                creadoPor,
                fechaCreacion
            ) VALUES (
                $idProcesoCasas,
                '$documento->nombre',
                $documento->id_opcion,
                1,
                $this->idUsuario,
                GETDATE()
            )");
        }
    }

    public function modeloOptions($idModelo){
        $query = $this->db->query("SELECT *, FORMAT(costom2, 'C')costoFinal FROM modelos_casas
        WHERE idModelo IN ($idModelo)");
        return $query;
    }

    public function getListaTipoProveedor(){
        $query = "SELECT 
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
                WHEN cli.id_asesor_c IS NOT NULL THEN CONCAT(usA.nombre, ' ', usA.apellido_paterno, ' ', usA.apellido_materno)
                ELSE 'Sin asignar'
            END AS nombreAsesor,
            CASE
                WHEN cli.id_gerente_c IS NULL THEN 'SIN ESPECIFICAR'
                ELSE CONCAT(usG.nombre, ' ', usG.apellido_paterno, ' ', usG.apellido_materno)
            END AS gerente,
            oxc.nombre AS movimiento,
            CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno) AS nombreCliente,
            CONCAT(usA.nombre, ' ', usA.apellido_paterno, ' ', usA.apellido_materno) AS nombreAsesor,
            CONCAT(usG.nombre, ' ', usG.apellido_paterno, ' ', usG.apellido_materno) AS nombreGerente,
            pc.tipoMovimiento,
            CASE
                WHEN pc.tipoProveedor = 1 THEN 10
                WHEN pc.tipoProveedor = 2 THEN 4
                ELSE NULL
            END AS num_documentos,
            CASE
                WHEN pc.tipoProveedor = 1 THEN doc.documentos
                WHEN pc.tipoProveedor = 2 THEN doc2.documentos
                ELSE NULL
            END AS documentos_subidos
        FROM
            proceso_casas_banco pc
            LEFT JOIN lotes lo ON lo.idLote = pc.idLote
            INNER JOIN clientes cli ON cli.idLote = lo.idLote
            INNER JOIN condominios con ON con.idCondominio = lo.idCondominio
            INNER JOIN residenciales resi ON resi.idResidencial = con.idResidencial
            INNER JOIN usuarios usA ON usA.id_usuario = cli.id_asesor_c
            INNER JOIN usuarios usG ON usG.id_usuario = cli.id_gerente_c
            LEFT JOIN opcs_x_cats oxc ON oxc.id_catalogo = 136 AND oxc.id_opcion = pc.tipoMovimiento
            LEFT JOIN (SELECT COUNT(*) AS documentos, idProcesoCasas FROM documentos_proceso_casas WHERE tipo IN (1,2,3,4,5,6,7,8,9,10) AND archivo IS NOT NULL AND proveedor = 1 GROUP BY idProcesoCasas) doc ON doc.idProcesoCasas = pc.idProcesoCasas AND pc.tipoProveedor = 1
            LEFT JOIN (SELECT COUNT(*) AS documentos, idProcesoCasas FROM documentos_proceso_casas WHERE tipo IN (1,2,3,4) AND archivo IS NOT NULL AND proveedor = 1 GROUP BY idProcesoCasas) doc2 ON doc2.idProcesoCasas = pc.idProcesoCasas AND pc.tipoProveedor = 2
            LEFT JOIN vobos_proceso_casas vobo ON vobo.paso = 4 AND vobo.idProceso = pc.idProcesoCasas
        WHERE 
            pc.proceso IN (4)
            AND pc.status = 1
            AND cli.status = 1
            AND (vobo.proyectos = 0 OR vobo.proyectos IS NULL)";

        return $this->db->query($query)->result();
    }

    public function selectTipoProveedor($idProcesoCasas, $tipoProveedor){
        return $this->db->query("UPDATE proceso_casas_banco
            SET
                tipoProveedor = $tipoProveedor
            WHERE
                idProcesoCasas = $idProcesoCasas");
    }

    public function getListaDocumentosProveedor($idProcesoCasas)
    {
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
        AND tipo IN (1,2,3,4,5,6,7,8,9,10)
        AND proveedor = 1";

        return $this->db->query($query)->result();
    }

    public function getListaOrdenCompraFirma(){
        $query = "SELECT 
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
                WHEN cli.id_asesor_c IS NOT NULL THEN CONCAT(usA.nombre, ' ', usA.apellido_paterno, ' ', usA.apellido_materno)
                ELSE 'Sin asignar'
            END AS nombreAsesor,
            CASE
                WHEN cli.id_gerente_c IS NULL THEN 'SIN ESPECIFICAR'
                ELSE CONCAT(usG.nombre, ' ', usG.apellido_paterno, ' ', usG.apellido_materno)
            END AS gerente,
            oxc.nombre AS movimiento,
            CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno) AS nombreCliente,
            CONCAT(usA.nombre, ' ', usA.apellido_paterno, ' ', usA.apellido_materno) AS nombreAsesor,
            CONCAT(usG.nombre, ' ', usG.apellido_paterno, ' ', usG.apellido_materno) AS nombreGerente,
            pc.tipoMovimiento,
            doc.documentos, 
            cli.idPropuestaCasa, cli.id_cliente
        FROM
            proceso_casas_banco pc
            LEFT JOIN lotes lo ON lo.idLote = pc.idLote
            INNER JOIN clientes cli ON cli.idLote = lo.idLote
            INNER JOIN condominios con ON con.idCondominio = lo.idCondominio
            INNER JOIN residenciales resi ON resi.idResidencial = con.idResidencial
            INNER JOIN usuarios usA ON usA.id_usuario = cli.id_asesor_c
            INNER JOIN usuarios usG ON usG.id_usuario = cli.id_gerente_c
            LEFT JOIN opcs_x_cats oxc ON oxc.id_catalogo = 136 AND oxc.id_opcion = pc.tipoMovimiento
            LEFT JOIN (SELECT COUNT(*) AS documentos, idProcesoCasas FROM documentos_proceso_casas WHERE tipo IN (2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 23, 36, 37, 38) AND archivo IS NOT NULL AND proveedor = 0 GROUP BY idProcesoCasas) doc ON doc.idProcesoCasas = pc.idProcesoCasas
            LEFT JOIN vobos_proceso_casas vobo ON vobo.paso = 4 AND vobo.idProceso = pc.idProcesoCasas
        WHERE 
            pc.proceso IN (4)
            AND pc.status = 1 
            AND cli.status = 1
            AND (vobo.comercializacion = 0 OR vobo.comercializacion IS NULL)";

        return $this->db->query($query)->result();
    }

    public function getListaElaborarContrato($contrato, $vobo, $documentos)
    {
        $query = "SELECT 
            pc.*, 
            oxc.color, 
            oxc.nombre AS nombreMovimiento, 
            CASE WHEN DATEDIFF(
                DAY, 
                GETDATE(), 
                pc.fechaProceso
            ) < 0 THEN CAST(
                CONCAT('LLEVA', ' ', 0, ' ', 'DIA(S)') AS VARCHAR
            ) ELSE CAST(
                CONCAT(
                      DATEDIFF(
                            DAY, 
                            GETDATE(), 
                            pc.fechaProceso
                      ), 
                      ' ', 
                      'DIA(S)'
                ) AS VARCHAR
            ) END AS tiempoProceso, 
            lo.idLote, 
            lo.nombreLote, 
            co.nombre AS condominio, 
            re.descripcion AS proyecto, 
            doc.documentos,
            CONCAT(
                cl.nombre, ' ', cl.apellido_paterno, 
                ' ', cl.apellido_materno
            ) AS nombreCliente, 
            CONCAT(
                usA.nombre, ' ', usA.apellido_paterno, 
                ' ', usA.apellido_materno
            ) AS nombreAsesor, 
            CONCAT(
                usG.nombre, ' ', usG.apellido_paterno, 
                ' ', usG.apellido_materno
            ) AS nombreGerente, 
            pc.tipoMovimiento 
        FROM 
            proceso_casas_banco pc 
            INNER JOIN lotes lo ON lo.idLote = pc.idLote 
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio 
            INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente 
            INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
            INNER JOIN usuarios usA ON usA.id_usuario = cl.id_asesor_c 
            INNER JOIN usuarios usG ON usG.id_usuario = cl.id_gerente_c 
            LEFT JOIN vobos_proceso_casas vobo ON vobo.idProceso = pc.idProcesoCasas AND vobo.paso = 14
            LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = pc.tipoMovimiento AND id_catalogo = 136 
            LEFT JOIN (SELECT COUNT(*) AS documentos, idProcesoCasas FROM documentos_proceso_casas WHERE tipo IN ($documentos) AND archivo IS NOT NULL AND proveedor = 0 GROUP BY idProcesoCasas) doc ON doc.idProcesoCasas = pc.idProcesoCasas
        WHERE 
            pc.proceso = 14
            AND pc.status = 1
            AND pc.finalizado = 0
            AND $contrato = 0
            AND vobo.$vobo = 0";

        return $this->db->query($query)->result();
    }

    public function getListaDocumentosClienteDirecto($idProceso, $docs) {
        $in = implode(',', $docs);

        $query = "SELECT
        idProceso, 
        idDocumento
        CASE WHEN archivo IS NULL THEN 'Sin archivo' ELSE archivo, END AS archivo, documento,
        tipo, fechaModificacion
        FROM documentos_proceso_casas_directo
        WHERE idProceso = $idProceso
        AND tipo IN ($in)
        ";

        return $this->db->query($query)->result();
    }

    public function getProcesoDirecto($idProceso) {
        $query = "SELECT pc.*, lo.nombreLote 
        FROM proceso_casas_directo pc
        LEFT JOIN lotes lo ON lo.idLote = pc.idLote
        WHERE pc.idProceso = $idProceso";

        return $this->db->query($query)->row();
    }

    public function checkPreproceso($idLote, $tableName) {
        if($tableName == 'proceso_casas_banco'){
            $query = "SELECT idProcesoCasas FROM $tableName WHERE idLote = $idLote";
        }
        elseif($tableName == 'proceso_casas_directo') {
            $query = "SELECT idProceso AS idProcesoCasasBanco FROM $tableName WHERE idLote = $idLote";
        }
        return $this->db->query($query)->row();
    }
}