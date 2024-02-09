<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Reestructura_model extends CI_Model
{
    function __construct()
    {
        $this->load->library('email');
        parent::__construct();
        $this->load->model(array('Comisiones_model','General_model'));
    }

    public function getListaClientesReubicar() {
        $id_usuario = $this->session->userdata('id_usuario');
        $id_rol = $this->session->userdata('id_rol');
        $tipo = $this->session->userdata('tipo');
        $id_lider = $this->session->userdata('id_lider');
        $validacionAdicional = "";

        if ($id_rol == 15) { // JURÍDICO
            if (in_array($id_usuario, array(2762, 2747, 13691))) // ES DANI, CARLITOS O CECI
                $validacionAdicional = "AND lo.estatus_preproceso IN (2) AND lo.id_juridico_preproceso = $id_usuario "; /* AND dxc2.flagProcesoJuridico = 0 */
            else
                $validacionAdicional = "AND lo.estatus_preproceso IN (2) "; /* AND dxc2.flagProcesoJuridico = 0 */
        }
        else if (in_array($id_rol, array(17, 70, 71, 73))) // CONTRALORÍA
            $validacionAdicional = "AND lo.estatus_preproceso IN (2)"; /* AND dxc2.flagProcesoContraloria = 0 */
        else if ($id_rol == 6 && $tipo == 2) // ASISTENTE GERENCIA && ES OOAM
            $validacionAdicional = "AND lo.estatus_preproceso IN (0, 1, 2, 3, 4, 5, 6) AND u6.id_lider = $id_lider";
        else if ($id_rol == 3 && $tipo == 2) // GERENTE && ES OOAM
            $validacionAdicional = "AND lo.estatus_preproceso IN (0, 1) AND u6.id_lider = $id_usuario";
        else if ((in_array($id_rol, array(2, 5)) && $tipo == 2) || $id_usuario == 1980) // SUBDIRECTOR / ASISTENTE SUBDIRECTOR && ES OOAM || ES FAB 1980
            $validacionAdicional = "AND lo.estatus_preproceso IN (0, 1)";
        else if ($id_rol == 7 && $tipo == 2) // ASESOR && ES OOAM
            $validacionAdicional = "AND lo.id_usuario_asignado = $id_usuario AND lo.estatus_preproceso NOT IN (7)";
        else if ($id_rol == 4) // ASISTENTE SUBDIRECCION
            $validacionAdicional = "AND lo.estatus_preproceso IN (0, 1, 2, 3, 4, 5, 6)";

       return $this->db->query("SELECT lf.rescision,cl.plan_comision, lo.registro_comision,lf.idLotePvOrigen, lf.idFusion, lf.origen, lf.destino, dxc2.id_dxc, dxc2.rescision as rescisioncl ,cl.proceso, lr.idProyecto, lo.idLote, lo.nombreLote, lo.idCliente, UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)) AS cliente,
        CONVERT(VARCHAR, cl.fechaApartado, 20) as fechaApartado, co.nombre AS nombreCondominio, re.nombreResidencial,
        CASE WHEN u0.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) END nombreAsesor,
        CASE WHEN u1.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)) END nombreCoordinador,
        CASE WHEN u2.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)) END nombreGerente,
        CASE WHEN u3.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)) END nombreSubdirector,
        CASE WHEN u4.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)) END nombreRegional,
        CASE WHEN u5.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u5.nombre, ' ', u5.apellido_paterno, ' ', u5.apellido_materno)) END nombreRegional2, lo.sup, 
        (ISNULL(lo.totalNeto2, 0.00) / lo.sup) costom2f, ISNULL(lo.totalNeto2, 0.00) total,
        oxc1.nombre estatusPreproceso, lo.estatus_preproceso id_estatus_preproceso, pxl3.totalCorridasNumero, pxl3.totalContratoNumero, pxl3.totalPropuestas,
        pxl1.totalCorridas, pxl2.totalContratos, dxc.totalRescision, dxc2.idLote AS idLoteXcliente,
        CASE WHEN u6.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u6.nombre, ' ', u6.apellido_paterno, ' ', u6.apellido_materno)) END nombreAsesorAsignado,
        HD.expediente as contratoFirmado, HD.idDocumento as idContratoFirmado, co.idCondominio, hdcount.totalContratoFirmado, hdcountlf.totalContratoFirmadoFusion,
        lf1.totalCorridaFusion, lf2.totalCorridasFusionNumero, lf3.totalContratosFusion, lf4.totalContratoFusionNumero, lf5.totalContratoFirmadoFusionNumero, lf6.totalRescisionFusion,
        lf7.totalRescisionFusionNumero,
        hpl.comentario, ISNULL(hpl.estatus, 1) AS id_estatus_modificacion, ISNULL(oxc2.nombre, 'NUEVO') AS estatus_modificacion, 
        ISNULL(oxc2.color, '#1B4F72') AS estatus_modificacion_color, lo.id_juridico_preproceso, ISNULL(se.nombre, 'SIN ESPECIFICAR') sedeAsesorAsignado, u6.id_usuario idAsesorAsignado, u6.id_lider,
        CASE WHEN u7.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u7.nombre, ' ', u7.apellido_paterno, ' ', u7.apellido_materno)) END nombreEjecutivoJuridico, lo.idStatusLote, lo.tipo_estatus_regreso,
        (SELECT CASE WHEN (count(idDocumento)>0) THEN count(idDocumento) ELSE 0 END FROM lotesFusion lf2
		INNER JOIN historial_documento hd ON hd.idLote = lf2.idLote
		WHERE lf2.destino=1 AND hd.tipo_doc=30 AND hd.expediente!='' AND lf2.idLotePvOrigen=lf.idLotePvOrigen
		GROUP BY lf2.idLotePvOrigen) as contratoFirmadoFusion, 
        ISNULL(dxc2.flagProcesoContraloria, 0) flagProcesoContraloria, ISNULL(dxc2.flagProcesoJuridico, 0) flagProcesoJuridico, 
        dxc2.cantidadTraspaso, dxc2.comentario comentarioTraspaso, hpl3.fechaUltimoEstatus, lo.fechaVencimiento, ISNULL(pxl4.id_lotep, 0) lotePreseleccionado, ISNULL(lo2.nombreLote, 'SIN ESPECIFICAR') nombreLotePreseleccionado,
        CASE WHEN ISNULL(dxc2.banderaProcesoUrgente, 0) = 0 THEN 'NO APLICA' ELSE 'URGENTE' END banderaProcesoUrgenteTexto,
        ISNULL(dxc2.banderaProcesoUrgente, 0) banderaProcesoUrgente
        FROM lotes lo
        LEFT JOIN clientes cl ON cl.id_cliente = lo.idCliente AND cl.idLote = lo.idLote AND cl.status = 1 AND cl.proceso NOT IN (2, 3, 4, 5, 6)
        LEFT JOIN datos_x_cliente dxc2 ON dxc2.idLote = lo.idLote
        INNER JOIN condominios co ON lo.idCondominio = co.idCondominio
        INNER JOIN residenciales re ON co.idResidencial = re.idResidencial
        LEFT JOIN (SELECT DISTINCT(idProyecto) idProyecto FROM loteXReubicacion WHERE estatus = 1) lr ON lr.idProyecto = re.idResidencial
        LEFT JOIN usuarios u0 ON u0.id_usuario = cl.id_asesor
        LEFT JOIN usuarios u1 ON u1.id_usuario = cl.id_coordinador
        LEFT JOIN usuarios u2 ON u2.id_usuario = cl.id_gerente
        LEFT JOIN usuarios u3 ON u3.id_usuario = cl.id_subdirector  
        LEFT JOIN usuarios u4 ON u4.id_usuario = cl.id_regional
        LEFT JOIN usuarios u5 ON u5.id_usuario = cl.id_regional_2
        INNER JOIN usuarios u6 ON u6.id_usuario = lo.id_usuario_asignado
        INNER JOIN opcs_x_cats oxc1 ON oxc1.id_opcion = lo.estatus_preproceso AND oxc1.id_catalogo = 106
        LEFT JOIN historial_preproceso_lote hpl ON hpl.idLote = lo.idLote AND hpl.idHistoPreproceso = (
	        SELECT MAX(hpl2.idHistoPreproceso) FROM historial_preproceso_lote hpl2 WHERE hpl2.idLote = hpl.idLote
        ) 
        LEFT JOIN opcs_x_cats oxc2 ON oxc2.id_opcion = hpl.estatus AND oxc2.id_catalogo = 108
        LEFT JOIN (SELECT idLote, COUNT(*) AS totalCorridasNumero, COUNT(*) AS totalContratoNumero, COUNT(*) totalPropuestas FROM propuestas_x_lote GROUP BY idLote) pxl3 ON pxl3.idLote = lo.idLote
        LEFT JOIN (SELECT idLotePvOrigen, COUNT(*) AS totalCorridasFusionNumero FROM lotesFusion WHERE destino=1  GROUP BY idLotePvOrigen) lf2 ON lf2.idLotePvOrigen = lo.idLote
        LEFT JOIN (SELECT idLote, COUNT(*) totalCorridas FROM propuestas_x_lote WHERE corrida IS NOT NULL GROUP BY idLote) pxl1 ON pxl1.idLote = lo.idLote
		LEFT JOIN (SELECT idLote, COUNT(*) totalContratos FROM propuestas_x_lote WHERE contrato IS NOT NULL GROUP BY idLote) pxl2 ON pxl2.idLote = lo.idLote
		LEFT JOIN (SELECT idLote, COUNT(*) totalRescision FROM datos_x_cliente WHERE rescision IS NOT NULL GROUP BY idLote) dxc ON dxc.idLote = lo.idLote
		LEFT JOIN (SELECT idLote, COUNT(*) totalContratoFirmado, idcliente FROM historial_documento WHERE tipo_doc = 30 AND expediente IS NOT NULL AND status = 1 GROUP BY idLote, idcliente) hdcount ON hdcount.idLote = lo.idLote AND hdcount.idcliente = cl.id_cliente
		
		LEFT JOIN (SELECT idLotePvOrigen, COUNT(*) totalCorridaFusion FROM lotesFusion WHERE destino=1 AND corrida IS NOT NULL GROUP BY idLotePvOrigen) lf1 ON  lf1.idLotePvOrigen = lo.idLote
		LEFT JOIN (SELECT idLotePvOrigen, COUNT(*) totalContratosFusion FROM lotesFusion WHERE destino=1 AND contrato IS NOT NULL GROUP BY idLotePvOrigen) lf3 ON lf3.idLotePvOrigen = lo.idLote
		LEFT JOIN (SELECT idLotePvOrigen, COUNT(*) AS totalContratoFirmadoFusionNumero FROM lotesFusion WHERE origen=1 GROUP BY idLotePvOrigen) lf5 ON lf5.idLotePvOrigen = lo.idLote
		LEFT JOIN (SELECT idLotePvOrigen, COUNT(*) AS totalContratoFusionNumero FROM lotesFusion WHERE destino=1 GROUP BY idLotePvOrigen) lf4 ON lf4.idLotePvOrigen = lo.idLote
		LEFT JOIN lotesFusion lf ON lf.idLote=lo.idLote 
    	LEFT JOIN (SELECT lf.idLotePvOrigen, COUNT(*) totalContratoFirmadoFusion FROM historial_documento hd2 INNER JOIN lotesFusion lf ON lf.idLote = hd2.idLote WHERE hd2.tipo_doc=30  AND lf.origen=1 AND hd2.expediente  IS NOT NULL GROUP BY lf.idLotePvOrigen) hdcountlf ON hdcountlf.idLotePvOrigen = lf.idLote
		LEFT JOIN (SELECT idLotePvOrigen, COUNT(*) totalRescisionFusion FROM lotesFusion WHERE rescision IS NOT NULL GROUP BY idLotePvOrigen) lf6 ON lf6.idLotePvOrigen = lo.idLote
		LEFT JOIN (SELECT idLotePvOrigen, COUNT(*) totalRescisionFusionNumero FROM lotesFusion WHERE origen=1 GROUP BY idLotePvOrigen) lf7 ON lf7.idLotePvOrigen = lo.idLote
		LEFT JOIN historial_documento HD ON HD.idLote = lo.idLote AND HD.tipo_doc = 30 AND HD.status = 1 AND HD.idCliente = cl.id_cliente
        LEFT JOIN usuarios u7 ON u7.id_usuario = lo.id_juridico_preproceso
        LEFT JOIN sedes se ON CAST(se.id_sede AS varchar(45)) = u6.id_sede
        LEFT JOIN (SELECT idLote, idCliente, MAX(fecha_modificacion) fechaUltimoEstatus FROM historial_preproceso_lote GROUP BY idLote, idCliente) hpl3 ON hpl3.idLote = lo.idLote AND hpl3.idCliente = cl.id_cliente
        LEFT JOIN (SELECT idLote, id_lotep FROM propuestas_x_lote WHERE estatusPreseleccion = 1) pxl4 ON pxl4.idLote = lo.idLote
        LEFT JOIN lotes lo2 ON lo2.idLote = pxl4.id_lotep
        WHERE lo.liberaBandera = 1 AND lo.status = 1 $validacionAdicional AND lo.solicitudCancelacion != 2")->result_array();
    }

    public function getDatosClienteTemporal($idLote) {
        return $this->db->query(
            "SELECT 
                dxc.nombre, 
                dxc.apellido_paterno, 
                dxc.apellido_materno, 
                dxc.telefono1, 
                dxc.correo, 
                dxc.domicilio_particular, 
                dxc.estado_civil AS idEstadoC, 
                oxc.nombre AS estado_civil, 
                ocupacion, 
                dxc.ine,
                ISNULL(dxc.banderaProcesoUrgente, 0) banderaProcesoUrgente,
                ISNULL(dxc.impresionEn, 0) impresionEn
            FROM 
                datos_x_cliente dxc 
                INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = dxc.estado_civil AND oxc.id_catalogo = 18 
            WHERE 
                dxc.idLote = $idLote"
        )->row();
    }

    public function getCliente($idCliente) {
        return $this->db->query(
            "SELECT 
                cl.nombre, 
                cl.apellido_paterno, 
                cl.apellido_materno, 
                ISNULL(cl.telefono1, '') telefono1, 
                ISNULL(cl.correo, '') correo, 
                cl.domicilio_particular, 
                cl.estado_civil AS idEstadoC, 
                oxc.nombre as estado_civil, 
                ocupacion, 
                '' ine,
                0 banderaProcesoUrgente
            FROM 
                clientes cl 
                INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = cl.estado_civil AND oxc.id_catalogo = 18 
            WHERE 
                id_cliente = $idCliente"
        )->row();
    }

    public function getProyectosDisponibles($proyecto, $superficie, $flagFusion){
        $unionQuery = '';
        if($proyecto == 21){
            $unionQuery = '
            UNION ALL 
            SELECT lr.proyectoReubicacion, UPPER(CAST((CONCAT(re.nombreResidencial, \' - \', re.descripcion)) AS NVARCHAR(100))) descripcion, COUNT(*) disponibles
                    FROM loteXReubicacion lr
            INNER JOIN residenciales re ON re.idResidencial = lr.proyectoReubicacion AND re.status = 1
            INNER JOIN condominios co ON co.idResidencial = re.idResidencial
            INNER JOIN lotes lo ON lo.idCondominio = co.idCondominio AND lo.idStatusLote = 21 AND lo.status = 1
            WHERE lr.idProyecto = '.$proyecto.'
            GROUP BY lr.proyectoReubicacion, UPPER(CAST((CONCAT(re.nombreResidencial, \' - \', re.descripcion)) AS NVARCHAR(100)))';
        }
        return $this->db->query("SELECT t.proyectoReubicacion, descripcion, SUM(disponibles) disponibles FROM (
            SELECT lr.proyectoReubicacion, UPPER(CAST((CONCAT(re.nombreResidencial, ' - ', re.descripcion)) AS NVARCHAR(100))) descripcion, COUNT(*) disponibles
                    FROM loteXReubicacion lr
                    INNER JOIN residenciales re ON re.idResidencial = lr.proyectoReubicacion AND re.status = 1
                    INNER JOIN condominios co ON co.idResidencial = re.idResidencial
                    INNER JOIN lotes lo ON lo.idCondominio = co.idCondominio AND lo.idStatusLote = 15 AND lo.status = 1
                    WHERE lr.idProyecto = $proyecto
                    GROUP BY lr.proyectoReubicacion, UPPER(CAST((CONCAT(re.nombreResidencial, ' - ', re.descripcion)) AS NVARCHAR(100)))
            UNION ALL
            SELECT lr.proyectoReubicacion, UPPER(CAST((CONCAT(re.nombreResidencial, ' - ', re.descripcion)) AS NVARCHAR(100))) descripcion, COUNT(*) disponibles
                    FROM loteXReubicacion lr
                    INNER JOIN residenciales re ON re.idResidencial = lr.proyectoReubicacion AND re.status = 1
                    INNER JOIN condominios co ON co.idResidencial = re.idResidencial
                    INNER JOIN lotes lo ON lo.idCondominio = co.idCondominio AND lo.idStatusLote = 1 AND lo.status = 1
                    WHERE lr.idProyecto = $proyecto
                    GROUP BY lr.proyectoReubicacion, UPPER(CAST((CONCAT(re.nombreResidencial, ' - ', re.descripcion)) AS NVARCHAR(100)))
            $unionQuery
        ) t
        GROUP BY t.proyectoReubicacion, descripcion")->result_array();
    }

    public function getCondominiosDisponibles($proyecto, $superficie, $flagFusion){
        $validacionSL = '';
        if($proyecto == 21){
            $validacionSL = ', 21'; //validación statusLote
        }
        $query = $this->db->query("SELECT lo.idCondominio, co.nombre, COUNT(*) disponibles
        FROM condominios co
        INNER JOIN lotes lo ON lo.idCondominio = co.idCondominio
        WHERE lo.idStatusLote IN (1, 15 $validacionSL) AND lo.status = 1
        AND co.idResidencial = $proyecto
        GROUP BY lo.idCondominio, co.nombre");
        return $query->result();
    }

    public function getLotesDisponibles($condominio, $superficie, $flagFusion, $idProyecto){
        $validacionSL = '';
        if($idProyecto == 21){
            $validacionSL = ', 21'; //validación statusLote
        }
        $query = $this->db->query("SELECT CASE 
		WHEN (lo.sup = $superficie) THEN op1.nombre
		WHEN (lo.sup - $superficie) <= lo.sup * 0.05 THEN op2.nombre
		ELSE op3.nombre END a_favor, lo.idLote, lo.nombreLote, lo.sup, lo.precio, lo.total, lo.tipo_estatus_regreso 
		FROM lotes lo 
		INNER JOIN opcs_x_cats op1 ON op1.id_catalogo = 105 AND op1.id_opcion = 1
		INNER JOIN opcs_x_cats op2 ON op2.id_catalogo = 105 AND op2.id_opcion = 2
		INNER JOIN opcs_x_cats op3 ON op3.id_catalogo = 105 AND op3.id_opcion = 3
		WHERE lo.idCondominio = $condominio AND lo.idStatusLote IN (1, 15 $validacionSL) AND lo.status = 1");
        return $query->result();
    }


    function get_catalogo_reestructura(){
        return $this->db->query("SELECT id_opcion, nombre, fecha_creacion FROM opcs_x_cats WHERE id_catalogo = 100 and estatus = 1");
    }

    function  insertOpcion($id_catalogo){
        return $this->db->query("SELECT TOP (1) id_opcion + 1 AS lastId FROM opcs_x_cats WHERE id_catalogo = $id_catalogo ORDER BY id_opcion DESC")->row();
    }

    public function get_valor_lote($id_proyecto){
        ini_set('memory_limit', -1);
        $estatus = $this->session->userdata('id_rol') == 55 ? " AND lo.idStatusLote=18" : " AND lo.idStatusLote NOT IN(18)"; 
        return $this->db->query("SELECT re.nombreResidencial, co.nombre nombreCondominio, lo.nombreLote,
        lo.idLote, lo.sup superficie, FORMAT(lo.precio, 'C') precio, 
        CASE WHEN cl.id_cliente IS NULL THEN '-' ELSE UPPER(CONCAT(cl.nombre,' ',cl.apellido_paterno,' ',cl.apellido_materno)) END nombreCliente,
        ISNULL(oxc.nombre, 'Sin especificar') estatus,oxc.id_opcion as idCatalogo, lo.idStatusLote,
        lo.comentarioReubicacion, lo.liberadoReubicacion, lo.liberaBandera,
        sl.nombre estatusContratacion, sl.background_sl, sl.color
        FROM lotes lo
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re on re.idResidencial = co.idResidencial
        LEFT JOIN opcs_x_cats oxc on oxc.id_opcion = lo.opcionReestructura AND oxc.id_catalogo = 100
        INNER JOIN (SELECT DISTINCT(proyectoReubicacion) proyectoReubicacion FROM loteXReubicacion WHERE proyectoReubicacion IN ($id_proyecto)) lotx ON lotx.proyectoReubicacion = co.idResidencial
        LEFT JOIN clientes cl ON cl.id_cliente = lo.idCliente and cl.status IN (1)
        INNER JOIN statuslote sl ON sl.idStatusLote = lo.idStatusLote
        WHERE lo.status = 1 $estatus")->result();
    }

    public function getLotesRegistros($id_proyecto){
        ini_set('memory_limit', -1);
        return $this->db->query("SELECT re.nombreResidencial, co.nombre nombreCondominio, lo.nombreLote,
        lo.idLote, lo.sup superficie, FORMAT(lo.precio, 'C') precio, 
        CASE WHEN cl.id_cliente IS NULL THEN '-' ELSE UPPER(CONCAT(cl.nombre,' ',cl.apellido_paterno,' ',cl.apellido_materno)) END nombreCliente,
        ISNULL(oxc.nombre, 'Sin especificar') estatus,oxc.id_opcion as idCatalogo, lo.idStatusLote,
        lo.comentarioReubicacion, lo.liberadoReubicacion, lo.liberaBandera,
        sl.nombre estatusContratacion, sl.background_sl, sl.color
        FROM lotes lo
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re on re.idResidencial = co.idResidencial
        LEFT JOIN opcs_x_cats oxc on oxc.id_opcion = lo.opcionReestructura AND oxc.id_catalogo = 100
        INNER JOIN (SELECT DISTINCT(proyectoReubicacion) proyectoReubicacion FROM loteXReubicacion WHERE proyectoReubicacion IN ($id_proyecto)) lotx ON lotx.proyectoReubicacion = co.idResidencial
        LEFT JOIN clientes cl ON cl.id_cliente = lo.idCliente and cl.status IN (1)
        INNER JOIN statuslote sl ON sl.idStatusLote = lo.idStatusLote
        WHERE lo.status = 1 AND lo.idStatusLote NOT IN(18)")->result();
    }

    public function historialModel($idLote){
        return $this->db->query("(SELECT aud.id_auditoria, oxc.nombre, oxcs.nombre as nombreNuevo, aud.fecha_creacion, CONCAT(usu.nombre,' ', usu.apellido_paterno,' ', usu.apellido_materno) AS creado_por from auditoria aud
        INNER JOIN opcs_x_cats  oxc on oxc.id_opcion = aud.anterior and oxc.id_catalogo = 100 and aud.col_afect = 'opcionReestructura'
        INNER JOIN opcs_x_cats  oxcs on oxcs.id_opcion = aud.nuevo and oxcs.id_catalogo = 100 and aud.col_afect = 'opcionReestructura'
        INNER JOIN usuarios usu on usu.id_usuario = aud.creado_por
        where aud.anterior != 'NULL' AND tabla = 'lotes' and col_afect = 'opcionReestructura' and id_parametro = $idLote)
        UNION ALL
        (SELECT aud.id_auditoria, aud.anterior, aud.nuevo, aud.fecha_creacion, CONCAT(usu.nombre,' ', usu.apellido_paterno,' ', usu.apellido_materno) AS creado_por from auditoria aud
        INNER JOIN usuarios usu on usu.id_usuario = aud.creado_por
        where aud.anterior != 'NULL' AND tabla = 'lotes'  and col_afect = 'comentarioReubicacion' and id_parametro = $idLote)");
    }

    public function aplicaLiberacion($datos) {
        $modificado_por = $this->session->userdata('id_usuario');
        $comentarioLiberacion = $datos['tipoLiberacion'] == 7 ? 'LIBERADO POR REUBICACIÓN' : ( $datos['tipoLiberacion'] == 9 ? 'LIBERACIÓN JURÍDICA' : ($datos['tipoLiberacion'] == 8 ? 'LIBERADO POR REESTRUCTURA' : $datos['obsLiberacion']));
        $observacionLiberacion = $datos['tipoLiberacion'] == 7 ? 'LIBERADO POR REUBICACIÓN' : ( $datos['tipoLiberacion'] == 9 ? 'LIBERACIÓN JURÍDICA' : ($datos['tipoLiberacion'] == 8 ? 'LIBERADO POR REESTRUCTURA' : 'CANCELACIÓN DE CONTRATO') );
        $datos["comentarioLiberacion"] = $comentarioLiberacion;
        $datos["observacionLiberacion"] = $observacionLiberacion;
        $datos["fechaLiberacion"] = date('Y-m-d H:i:s');
        $datos["modificado"] = date('Y-m-d H:i:s');
        $datos["status"] = 1;
        $datos["userLiberacion"] = ($datos['tipoLiberacion'] == 7 &&  $this->session->userdata('id_rol') == 17 ) ? 1 : $this->session->userdata('id_usuario');
        $datos["tipo"] = $datos['tipoLiberacion'];
        $tipo_estatus_regreso = $datos['tipoLiberacion'] == 9 ? 1 : 0; // SI ES LIBERACIÓN DE YOLA (ES EL INVENTARIO ESPECIAL PARA EL PROYECTO DE REESTRUCURA) SE MANDA BANDERA EN 1 SINO 0

        $row = $this->db->query("SELECT idLote, nombreLote, status, sup,precio,ubicacion,idStatusLote,  
        (CASE WHEN totalNeto2 IS NULL THEN 0.00 ELSE totalNeto2 END) totalNeto2,
        (CASE WHEN idCliente = 0  OR idCliente IS NULL THEN 0 ELSE idCliente END) idCliente,registro_comision,
        (CASE WHEN tipo_venta IS NULL THEN 0 ELSE tipo_venta END) tipo_venta FROM lotes WHERE idLote=".$datos['idLote']." AND status = 1")->result_array();
        $registro_comision = ($datos['tipo'] == 8 || $datos['tipo'] == 9) ? 9 : 8;
        $idStatusLote = $datos['tipo'] == 9 ? 15 :($datos['tipo'] == 8  ? 3 :( $datos['tipo'] == 7 ? 19 : 18));
        $sqlIdCliente = $datos['tipo'] == 8 ? ' AND id_cliente='.$row[0]['idCliente'] : '';
        $sqlIdClienteAnt = isset($datos["idClienteAnterior"]) ? 'AND idCliente = '.$datos["idClienteAnterior"] : '';
        $this->db->trans_begin();
        if($row[0]['idStatusLote'] == 8 || $row[0]['idCliente'] == NULL){
                $arregloLote = array();
                $arregloLote = array(
                    "idStatusLote" => 15,
                    "fecha_modst" => date("Y-m-d H:i:s"),
                    "userstatus" => $datos["userLiberacion"],
                    "usuario" => $datos["userLiberacion"],
                    "liberaBandera" => 1,
                    "tipo_estatus_regreso" => 1
                );
                $this->General_model->updateRecord('lotes',$arregloLote , 'idLote',$datos['idLote']);
                if ($this->db->trans_status() === FALSE){
                    $this->db->trans_rollback();
                    return false;
                } else {
                    $this->db->trans_commit();
                    return true;
                }
                exit;
        }
        
        $banderaComisionCl = (in_array($datos['tipo'],array(7,8,9))) ? ' ,banderaComisionCl ='.$row[0]['registro_comision'] : '';
        $id_cliente = $this->db->query("SELECT id_cliente,plan_comision, oxc.nombre as tipoCancelacion FROM clientes 
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = tipoCancelacion AND id_catalogo = 117
        WHERE status = 1 AND idLote IN (" . $row[0]['idLote'] . ") ")->result_array();
        $this->db->query("UPDATE historial_documento SET status = 0 WHERE status = 1 AND idLote IN (".$row[0]['idLote'].") ");
        $this->db->query("UPDATE prospectos SET tipo = 0, estatus_particular = 4, modificado_por = 1, fecha_modificacion = GETDATE() WHERE id_prospecto IN (SELECT id_prospecto FROM clientes WHERE status = 1 AND idLote = ".$row[0]['idLote'].")");
        $this->db->query("UPDATE clientes SET status = 0, fecha_modificacion = GETDATE(), modificado_por = '$modificado_por', tipoLiberacion = ".$datos['tipo'].", totalNeto2Cl = ".$row[0]['totalNeto2']." $banderaComisionCl WHERE status = 1 AND idLote IN (".$row[0]['idLote'].") $sqlIdCliente ");
        $this->db->query("UPDATE historial_enganche SET status = 0, comentarioCancelacion = 'LOTE LIBERADO' WHERE status = 1 AND idLote IN (".$row[0]['idLote'].") $sqlIdClienteAnt");
        $this->db->query("UPDATE historial_lotes SET status = 0 WHERE status = 1 AND idLote IN (".$row[0]['idLote'].") ");

        $datos['tipo'] == 8 ? $this->db->query("UPDATE clientes SET idLote=".$datos['idLote'].",modificado_por='".$modificado_por."' WHERE id_cliente=".$datos['idClienteNuevo'].";")  : '' ;
        
        if(!in_array($row[0]['registro_comision'],array(7))){
            $comisionesNuevas = $this->Comisiones_model->porcentajes($id_cliente[0]['id_cliente'],$row[0]["totalNeto2"],$id_cliente[0]['plan_comision'])->result_array();
            $comisiones = $this->db->query("SELECT id_comision,id_lote,comision_total,id_usuario,rol_generado,porcentaje_decimal FROM comisiones where id_lote=".$row[0]['idLote']." AND estatus=1")->result_array();

            if(in_array($row[0]['registro_comision'],array(8,0))){
                for ($i=0; $i < count($comisionesNuevas) ; $i++) { 
                    $this->db->query("INSERT INTO comisionesReubicadas VALUES(".$comisionesNuevas[$i]['id_usuario'].",".$comisionesNuevas[$i]['comision_total'].",".$comisionesNuevas[$i]['porcentaje_decimal'].",".$comisionesNuevas[$i]['id_rol'].",".$id_cliente[0]['id_cliente'].",".$row[0]['idLote'].",'".$datos['userLiberacion']."','".date("Y-m-d H:i:s")."','".$row[0]['nombreLote']."')"); 
                }
            }else{
                if(count($comisiones) == 0){
                    for ($i=0; $i < count($comisionesNuevas) ; $i++) { 
                        $this->db->query("INSERT INTO comisionesReubicadas VALUES(".$comisionesNuevas[$i]['id_usuario'].",".$comisionesNuevas[$i]['comision_total'].",".$comisionesNuevas[$i]['porcentaje_decimal'].",".$comisionesNuevas[$i]['id_rol'].",".$id_cliente[0]['id_cliente'].",".$row[0]['idLote'].",'".$datos['userLiberacion']."','".date("Y-m-d H:i:s")."','".$row[0]['nombreLote']."')"); 
                    }
                }else{
                    for ($i=0; $i <count($comisiones) ; $i++) {
                        $sumaxcomision=0;
                        $pagos_ind = $this->db->query("SELECT * FROM pago_comision_ind WHERE id_comision=".$comisiones[$i]['id_comision']."")->result_array();
                        for ($j=0; $j <count($pagos_ind) ; $j++) {
                            $sumaxcomision = $sumaxcomision + $pagos_ind[$j]['abono_neodata'];
                        }
                        if(($datos['tipo'] == 7 || $datos['tipo'] == 8) && $row[0]['registro_comision'] == 1){
                            $nuevaComision = $comisiones[$i]['comision_total'] - $sumaxcomision;
                            $this->db->query("INSERT INTO comisionesReubicadas VALUES(".$comisiones[$i]['id_usuario'].",".$nuevaComision.",".$comisiones[$i]['porcentaje_decimal'].",".$comisiones[$i]['rol_generado'].",".$row[0]['idCliente'].",".$row[0]['idLote'].",'".$datos['userLiberacion']."','".date("Y-m-d H:i:s")."','".$row[0]['nombreLote']."')");
                        }
                        $this->db->query("UPDATE comisiones SET modificado_por='" . $datos['userLiberacion'] . "',comision_total=$sumaxcomision,estatus=8 where id_comision=".$comisiones[$i]['id_comision']." ");
                    }
                    $this->db->query("UPDATE pago_comision SET bandera=0,total_comision=0,abonado=0,pendiente=0,ultimo_pago=0,modificado_por='".$modificado_por."'  WHERE id_lote=".$row[0]['idLote']." ");
                }
            }
        }else{
            $comisiones = $this->db->query("SELECT id_comision,id_lote,comision_total,id_usuario,rol_generado,porcentaje_decimal FROM comisiones where id_lote=".$row[0]['idLote']." AND estatus=1")->result_array();
            for ($i=0; $i <count($comisiones) ; $i++) {
                $this->db->query("UPDATE comisiones SET modificado_por='" . $datos['userLiberacion'] . "',estatus=8 where id_comision=".$comisiones[$i]['id_comision']." ");
            }
            $this->db->query("UPDATE pago_comision SET bandera=0,total_comision=0,abonado=0,pendiente=0,ultimo_pago=0,modificado_por='".$modificado_por."'  WHERE id_lote=".$row[0]['idLote']." ");
        }
        
        if($row[0]['tipo_venta'] == 1){
            if($datos['tipo'] == 7 || $datos['tipo'] == 8){
                if( $datos['tipo'] == 7 && $datos['banderaFusion'] == 0){
                    $clausula = $this->db->query("SELECT TOP 1 id_clausula,nombre FROM clausulas WHERE id_lote = ".$datos['idLote']." ORDER BY id_clausula DESC")->result_array();
                    $this->db->query("INSERT INTO clausulas VALUES(".$datos['idLoteNuevo'].",'".$clausula['nombre']."',1,GETDATE(),'".$datos['userLiberacion']."');");
                    $this->db->query("UPDATE clausulas SET estatus = 0 WHERE id_lote=".$datos['idLote']." AND estatus = 1");
                }
            }
        }

        //LOTES FUSIÓN
        if($datos["tipo"] == 7 && $datos['banderaFusion'] == 1){
            $datosFusion = $this->db->query("SELECT idLotePvOrigen FROM lotesFusion WHERE idLote=".$datos['idLote'])->result_array();
            $idLotePv = $datosFusion[0]['idLotePvOrigen'];
            $this->db->query("UPDATE lotesFusion SET banderaComision=".$row[0]['registro_comision'].",totalNeto2=".$row[0]['totalNeto2'].",modificadoPor=".$datos['userLiberacion'].",fechaModificacion='".$datos['modificado']."' WHERE idLote=".$datos['idLote']." AND idCliente=".$row[0]['idCliente']." ");
            $this->db->query("UPDATE lotesFusion SET nombreLotes=CONCAT(nombreLotes,',','".$row[0]['nombreLote']."'),modificadoPor=".$datos['userLiberacion'].",fechaModificacion='".$datos['modificado']."' WHERE idLotePvOrigen=".$idLotePv." AND destino=1");
        }



        $data_l = array(
            'nombreLote'=> $row[0]['nombreLote'],
            'comentarioLiberacion'=> $datos['comentarioLiberacion'],
            'observacionLiberacion'=> $datos['observacionLiberacion'],
            'precio'=> $row[0]['precio'],
            'fechaLiberacion'=> $datos['fechaLiberacion'],
            'modificado'=> $datos['modificado'],
            'status'=> $datos['status'],
            'idLote'=> $row[0]['idLote'],
            'tipo'=> $datos['tipo'],
            'userLiberacion'=> $datos['userLiberacion'],
            'id_cliente' => (count($id_cliente)>=1 ) ? $id_cliente[0]['id_cliente'] : 0
        );

        $this->db->insert('historial_liberacion',$data_l);

        $idStatusContratacion = $datos["tipo"] == 8 ? 1 : 0;
        $idClienteNuevo = $datos["tipo"] == 8 ? $datos['idClienteNuevo'] : 0 ;
        $idMovimiento = $datos["tipo"] == 8 ? 31 : 0;
        $tipo_venta = $datos["tipo"] == 8 ? $row[0]['tipo_venta'] : 0;
        $ubicacion = $datos["tipo"] == 8 ? $row[0]['ubicacion'] : 0;
        $motivo_change_status =  $datos["tipoLiberacion"] == 3 ? $datos['obsLiberacion'] : 'LOTE LIBERADO';
        $this->db->query("UPDATE lotes SET idStatusContratacion = $idStatusContratacion,
                    idMovimiento = $idMovimiento, comentario = 'NULL', idCliente = $idClienteNuevo, usuario = '".$modificado_por."', perfil = 'NULL ', 
                    fechaVenc = null, modificado = null, status8Flag = 0, 
                    ubicacion = 0, totalNeto = 0, totalNeto2 = 0,
                    casa = (CASE WHEN idCondominio IN (759, 639) THEN 1 ELSE 0 END),
                    totalValidado = 0, validacionEnganche = 'NULL', 
                    fechaSolicitudValidacion = null, 
                    fechaRL = null, 
                    motivo_change_status='$motivo_change_status',
                    registro_comision = $registro_comision,
                    tipo_venta = $tipo_venta, 
                    observacionContratoUrgente = null,
                    firmaRL = 'NULL', comentarioLiberacion = '".$datos['comentarioLiberacion']."', 
                    observacionLiberacion = '".$datos['observacionLiberacion']."', liberadoReubicacion = '".$datos['observacionLiberacion']."' , idStatusLote = $idStatusLote, 
                    fechaLiberacion = GETDATE(), 
                    userLiberacion = '".$datos['userLiberacion']."',
                    precio = ".$row[0]['precio'].", total = ((".$row[0]['sup'].") * ".$row[0]['precio']."),
                    enganche = (((".$row[0]['sup'].") * ".$row[0]['precio'].") * 0.1), 
                    saldo = (((".$row[0]['sup'].") * ".$row[0]['precio'].") - (((".$row[0]['sup'].") * ".$row[0]['precio'].") * 0.1)),
                    asig_jur = 0, tipo_estatus_regreso = $tipo_estatus_regreso, solicitudCancelacion = 0
                    WHERE idLote IN (".$datos['idLote'].") and status = 1");
                    
                    if(!in_array($datos["tipo"],array(7, 8, 9))) {
                        $this->email
                            ->initialize()
                            ->from('Ciudad Maderas')
                            ->to('programador.analista12@ciudadmaderas.com')
                            ->subject('Notificación de liberación')
                            ->view($this->load->view('mail/reestructura/mailLiberacion', [
                                'lote' => $row[0]['nombreLote'],
                                'fechaApartado' => $datos['fechaLiberacion'],
                                'Observaciones' => $datos['obsLiberacion'],
                                'tipoCancelacion' => $id_cliente[0]['tipoCancelacion']
                            ], true));
                
                        $this->email->send();
                    }

        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }

    }

    public function setReestructura($datos){
        $this->db->trans_begin();
        $fecha = date('Y-m-d H:i:s');
        $creado_por = $this->session->userdata('id_usuario');
        $this->db->query("INSERT INTO ventas_compartidas VALUES(".$datos['idCliente'].",".$datos['id_asesor'].",0,".$datos['id_gerente'].",2,'$fecha',$creado_por,".$datos['id_subdirector'].",'$fecha','$creado_por',0,NULL)");
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function obtenerDocumentacionActiva($idLote, $idCliente)
    {
        $query = $this->db->query("SELECT * FROM historial_documento WHERE idLote = $idLote AND idCliente = $idCliente AND status = 1 AND expediente != ''");
        return $query->result_array();
    }

    public function obtenerLotePorId($idLote)
    {
        $query = $this->db->query("SELECT lo.*,
            cl.personalidad_juridica
            FROM lotes lo
            LEFT JOIN clientes cl ON lo.idLote = cl.idLote
            WHERE lo.idLote = $idLote AND cl.status = 1");
        return $query->row();
    }

    public function obtenerDocumentacionPorReubicacion($personalidadJuridica)
    {
        $idCatalogo = ($personalidadJuridica == 1) ? 101 : 98;
        $query = $this->db->query("SELECT * FROM opcs_x_cats WHERE id_catalogo = $idCatalogo AND estatus = 1");
        return $query->result_array();
    }

    public function obtenerDocumentacionOriginal($personalidadJuridica)
    {
        $idCatalogo = ($personalidadJuridica == 1) ? 32 : 31;
        $query = $this->db->query("SELECT * FROM opcs_x_cats WHERE id_catalogo = $idCatalogo AND estatus = 1 AND id_opcion NOT IN (29, 30)");
        return $query->result_array();
    }

    public function obtenerDocumentacionPorReestructura()
    {
        $query = $this->db->query('SELECT * FROM opcs_x_cats WHERE id_catalogo = 102 AND estatus = 1');
        return $query->result_array();
    }

    public function obtenerDSPorIdCliente($idCliente)
    {
        $query = $this->db->query("SELECT * FROM deposito_seriedad WHERE id_cliente = $idCliente");
        return $query->row();
    }

    public function obtenerResidencialPorIdCliente($idCliente)
    {
        $query = $this->db->query("SELECT re.* 
            FROM clientes cl 
            INNER JOIN lotes lo ON cl.idLote = lo.idLote
            INNER JOIN condominios co ON lo.idCondominio = co.idCondominio
            INNER JOIN residenciales re ON co.idResidencial = re.idResidencial
            WHERE id_cliente = $idCliente
        ");
        return $query->row();
    }

    public function obtenerCopropietariosPorIdCliente($idCliente)
    {
        $query = $this->db->query("SELECT * FROM copropietarios WHERE id_cliente IN ($idCliente)");
        return $query->result_array();
    }

    public function buscarLoteAnteriorPorIdClienteNuevo($idCliente)
    {
        $query = $this->db->query("SELECT * FROM lotes WHERE idLote = (SELECT idLote FROM clientes WHERE id_cliente = (SELECT id_cliente_reubicacion_2 FROM clientes WHERE id_cliente = $idCliente))");
        return $query->row();
    }

    public function getSelectedSup($idLote){
        $query = $this->db->query("SELECT idLote, sup, nombreLote, idCondominio FROM lotes WHERE idLote IN ($idLote)");
        return $query;
    }

    public function loteLiberadoPorReubicacion($idLote): bool
    {
        $query = $this->db->query("SELECT * FROM historial_liberacion WHERE idLote = $idLote AND tipo = 7");
        return count($query->result_array()) > 0;
    }

    public function obtenerClientePorId($idCliente)
    {
        $query = $this->db->query("SELECT * FROM clientes WHERE id_cliente = $idCliente");
        return $query->row();
    }

    public function getLotes($id_proyecto) {
        return $this->db->query(
            "SELECT 
                re.idResidencial, 
                re.nombreResidencial, 
                co.nombre nombreCondominio, 
                lo.nombreLote, 
                lo.idLote, 
                lo.sup superficie, 
                FORMAT(lo.precio, 'C') precio, 
                CASE WHEN cl.id_cliente IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)) END nombreCliente, 
                lo.observacionLiberacion AS observacion,
                CASE WHEN lo.liberaBandera = 1 THEN 'LIBERADO' ELSE 'SIN LIBERAR' END estatusLiberacion,
                lo.liberaBandera
            FROM 
                lotes lo 
                INNER JOIN condominios co ON co.idCondominio = lo.idCondominio 
                INNER JOIN residenciales re ON re.idResidencial = co.idResidencial AND re.idResidencial IN ($id_proyecto)
                LEFT JOIN clientes cl ON cl.id_cliente = lo.idCliente AND cl.status IN (1) AND cl.proceso IN (0, 1) 
            WHERE 
                lo.status = 1 
                AND idStatusLote IN (2, 3)
                AND lo.solicitudCancelacion != 2"
        )->result();
    }

    public function getLotesEstatusSeisSinTraspaso(){
        return $this->db->query("SELECT re.nombreResidencial, co.nombre nombreCondominio, lo.nombreLote, lo.idLote, lo.referencia, lo.sup,
        UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)) nombreCliente, FORMAT(lo.totalNeto, 'C') totalATraspasar,
        ISNULL(tv.tipo_venta, 'Sin especificar') tipo_venta, ISNULL(oxc0.nombre, 'Normal') tipo_proceso
        FROM lotes lo
        INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente AND cl.idLote = lo.idLote AND cl.status = 1 AND cl.proceso IN (2, 3, 4, 5, 6)
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes 
        WHERE status = 1 AND idStatusContratacion = 6 AND idMovimiento = 36 GROUP BY idLote, idCliente) hl
        ON hl.idLote = lo.idLote AND hl.idCliente = cl.id_cliente
        LEFT JOIN tipo_venta tv ON tv.id_tventa = lo.tipo_venta
        LEFT JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = cl.proceso AND oxc0.id_catalogo = 97
        WHERE lo.status  = 1 AND ISNULL(lo.validacionEnganche, 'NULL') NOT IN ('VALIDADO')");
    }

    public function getListaAsignacionCartera() {
        ini_set('memory_limit', -1);
        $id_usuario = $this->session->userdata('id_usuario');
        $filtroSede = '';
        if( $this->session->userdata('id_rol') != 2 && $this->session->userdata('id_rol') != 5 ){
            $filtroSede = 'AND sede_residencial = ' . $this->session->userdata('id_sede');
        }

        return $this->db->query("SELECT lf.idLotePvOrigen, lf.idFusion, cl.proceso, lr.idProyecto, lo.idLote, lo.nombreLote, lo.idCliente, UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)) AS cliente, 
        CONVERT(VARCHAR, cl.fechaApartado, 20) as fechaApartado, co.nombre AS nombreCondominio, re.nombreResidencial,
        CASE WHEN u0.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) END nombreAsesor,
        CASE WHEN u1.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)) END nombreCoordinador,
        CASE WHEN u2.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)) END nombreGerente,
        CASE WHEN u3.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)) END nombreSubdirector,
        CASE WHEN u4.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)) END nombreRegional,
        CASE WHEN u5.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u5.nombre, ' ', u5.apellido_paterno, ' ', u5.apellido_materno)) END nombreRegional2, lo.sup, 
        CASE WHEN u6.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u6.nombre, ' ', u6.apellido_paterno, ' ', u6.apellido_materno)) END nombreAsesorAsignado, 
        (ISNULL(lo.totalNeto2, 0.00) / lo.sup) costom2f, ISNULL(lo.totalNeto2, 0.00) total, ISNULL(u6.id_usuario, 0) idAsesorAsignado, 
        oxc1.nombre estatusPreproceso, lo.estatus_preproceso id_estatus_preproceso, lo.totalNeto2
        FROM lotes lo
        INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente AND cl.idLote = lo.idLote AND cl.status = 1 AND cl.proceso NOT IN (2, 3, 4, 5, 6)
        INNER JOIN condominios co ON lo.idCondominio = co.idCondominio
        INNER JOIN residenciales re ON co.idResidencial = re.idResidencial
        INNER JOIN (SELECT DISTINCT(idProyecto) idProyecto FROM loteXReubicacion WHERE estatus = 1) lr ON lr.idProyecto = re.idResidencial
        INNER JOIN usuarios u0 ON u0.id_usuario = cl.id_asesor
        LEFT JOIN usuarios u1 ON u1.id_usuario = cl.id_coordinador
        LEFT JOIN usuarios u2 ON u2.id_usuario = cl.id_gerente
        LEFT JOIN usuarios u3 ON u3.id_usuario = cl.id_subdirector
        LEFT JOIN usuarios u4 ON u4.id_usuario = cl.id_regional
        LEFT JOIN usuarios u5 ON u5.id_usuario = cl.id_regional_2
        INNER JOIN opcs_x_cats oxc1 ON oxc1.id_opcion = lo.estatus_preproceso AND oxc1.id_catalogo = 106
        LEFT JOIN usuarios u6 ON u6.id_usuario = id_usuario_asignado
        LEFT JOIN lotesFusion lf ON lf.idLote = lo.idLote
        WHERE lo.liberaBandera = 1 AND lo.status = 1 AND lo.estatus_preproceso IN(1, 0) $filtroSede AND lo.solicitudCancelacion != 2")->result_array();
    }

    public function getListaUsuariosParaAsignacion() {
        $filtro = '';
        if($this->session->userdata('id_rol') == 3){
            $filtro = ' AND id_lider='.$this->session->userdata('id_usuario');
        }
        return $this->db->query("SELECT id_usuario, UPPER(CONCAT(nombre , ' ', apellido_paterno, ' ', apellido_materno)) nombreUsuario 
        FROM usuarios 
        WHERE estatus = 1 AND tipo = 2 AND id_rol = 7 $filtro
        ORDER BY UPPER(CONCAT(nombre , ' ', apellido_paterno, ' ', apellido_materno, ' '))")->result_array();
    }

    function banderaLiberada($clave , $data){
        try {
            $this->db->where('idLote', $clave);
            $this->db->update('lotes', $data);
            $afftectedRows = $this->db->affected_rows();
            return $afftectedRows > 0 ? TRUE : FALSE ;
        }
        catch(Exception $e) {
            return $e->getMessage();
        }

    }
    function getListaLotesArchivosReestrucura(){
        $query = $this->db->query("SELECT l.nombreLote, dxc.* FROM datos_x_cliente dxc INNER JOIN lotes l ON l.idLote = dxc.idLote");
        return $query->result_array();
    }
    function getOpcionesLote($idLote,$banderaFusion = 0){
        $tabla='propuestas_x_lote';
        $columna='id_lotep';
        $columnExtra='';
        $coumnExtra = '';
        $columnWhere='idLote';
        if($banderaFusion != 0){
            $tabla='lotesFusion';
            $columna='idLote';
            $columnWhere='idLotePvOrigen';
            $columnExtra = ',pxl.origen,pxl.destino,pxl.idFusion id_pxl';
        }
        $query = $this->db->query("SELECT l.nombreLote, pxl.*, dxc.rescision as rescisioncl,l.idStatusLote,
        CONCAT(dxc.nombre,' ', dxc.apellido_paterno,' ', dxc.apellido_materno) AS nombreCliente,
        oxc.nombre AS estadoCivil, dxc.ine, dxc.domicilio_particular,
        dxc.correo, dxc.telefono1, dxc.ocupacion, 5 tipo_proceso $columnExtra
        FROM $tabla pxl 
        INNER JOIN lotes l ON l.idLote=pxl.$columna
        left JOIN datos_x_cliente dxc ON pxl.$columnWhere=dxc.idLote
        left JOIN opcs_x_cats oxc ON oxc.id_opcion = dxc.estado_civil AND oxc.id_catalogo=18
        WHERE pxl.$columnWhere=".$idLote);
        return $query->result_array();
    }
    function checkDocumentacion($idLote){
        $query = $this->db->query("SELECT dxc.id_dxc, dxc.rescision, pxl.* FROM propuestas_x_lote pxl INNER JOIN datos_x_cliente dxc ON pxl.idLote=dxc.idLote WHERE pxl.idLote=".$idLote);
        return $query->result_array();
    }
    function obtenerPropuestasXLote($idLote, $flagFusion){
        if($flagFusion){
            $query = $this->db->query("SELECT lf.idFusion as id_pxl, lf.idLotePvOrigen as idLote, lf.idLote as id_lotep,
		lo.nombreLote, lo.sup, lo.idCondominio, lo.tipo_estatus_regreso
		FROM lotesFusion lf
		INNER JOIN lotes lo ON lo.idLote = lf.idLote
		INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
		WHERE destino=1 AND lf.idLotePvOrigen =$idLote");
        }else{
            $query = $this->db->query("SELECT pl.id_pxl, pl.idLote, pl.id_lotep, lo.nombreLote, lo.sup, lo.idCondominio, lo.tipo_estatus_regreso
            FROM propuestas_x_lote pl
            INNER JOIN lotes lo ON pl.id_lotep = lo.idLote
		    INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
              WHERE pl.idLote = $idLote;");
        }

        return $query;
    }

    function getNuevaPropuesta($idLote, $lotesPropuestos){
        return $this->db->query("SELECT * FROM propuestas_x_lote WHERE idLote = $idLote AND id_lotep NOT IN ($lotesPropuestos)");
    }    
    public function expedienteReubicacion($idLote){
        $query = $this->db->query("SELECT * FROM propuestas_x_lote WHERE idLote = $idLote AND estatus = 1");
        
        return $query->row();
    }

    public function expedienteFusionDestino($idLotePivote, $idLoteDestino){
        $query = $this->db->query("SELECT * FROM lotesFusion WHERE idLotePvOrigen = $idLotePivote AND idLote = $idLoteDestino");
        return $query->row();
    }

    public function obtenerDatosClienteReubicacion($idLote)
    {
        $query = $this->db->query("SELECT * FROM datos_x_cliente WHERE idLote = $idLote");
        return $query->row();
    }

    public function obtenerTotalPropuestas($idLoteAnterior, $flagFusion)
    {
        if($flagFusion==1){
            $query = $this->db->query("SELECT COUNT(*) AS total_propuestas FROM lotesFusion WHERE idLotePvOrigen = $idLoteAnterior AND destino=1");
        }else{
            $query = $this->db->query("SELECT COUNT(*) AS total_propuestas FROM propuestas_x_lote WHERE idLote = $idLoteAnterior");
        }
        return $query->row();
    }

    public function copiarDatosXCliente($idLote){
        $query = $this->db->query("SELECT * FROM datos_x_cliente WHERE idLote = $idLote");
        return $query->row();
    }

    public function setSeleccionPropuesta($idLote, $idLoteSelected){
        $id_usuario = $this->session->userdata('id_usuario');

        return $this->db->query("UPDATE propuestas_x_lote SET estatus = 1, modificado_por = $id_usuario where idLote = $idLote and id_lotep = $idLoteSelected");
    }

    public function getNotSelectedLotes($idLote){
        $query = $this->db->query("SELECT pxl.*, lo.tipo_estatus_regreso 
		FROM propuestas_x_lote pxl
		INNER JOIN lotes lo ON pxl.id_lotep = lo.idLote
		WHERE pxl.idLote = $idLote AND pxl.estatus = 0");
        return $query->result_array();
    }

    public function getInventario() {
        return $this->db->query("SELECT UPPER(CAST(re.descripcion AS varchar(100))) nombreResidencial, co.nombre nombreCondominio,  lo.nombreLote, lo.idLote, 
        lo.sup, oxc1.nombre tipoLote, FORMAT(lo.precio, 'C') preciom2, FORMAT(lo.total, 'C') total,
        ISNULL(oxc2.nombre, 'Sin especificar') estatus, sl.nombre estatusContratacion, sl.background_sl, sl.color,
        lo.tipo_estatus_regreso, 'EXCLUSIVO REESTRUCTURA' tipo
        FROM lotes lo
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        INNER JOIN (SELECT DISTINCT(proyectoReubicacion) proyectoReubicacion FROM loteXReubicacion WHERE estatus = 1) lxr ON lxr.proyectoReubicacion = re.idResidencial
        INNER JOIN opcs_x_cats oxc1 ON oxc1.id_opcion = co.tipo_lote AND oxc1.id_catalogo = 27
        LEFT JOIN opcs_x_cats oxc2 on oxc2.id_opcion = lo.opcionReestructura AND oxc2.id_catalogo = 100
        INNER JOIN statuslote sl ON sl.idStatusLote = lo.idStatusLote
        WHERE lo.idStatusLote IN (15, 16) AND lo.status = 1
        UNION ALL
        SELECT UPPER(CAST(re.descripcion AS varchar(100))) nombreResidencial, co.nombre nombreCondominio,  lo.nombreLote, lo.idLote, 
        lo.sup, oxc1.nombre tipoLote, FORMAT(lo.precio, 'C') preciom2, FORMAT(lo.total, 'C') total,
        'NA' estatus, sl.nombre estatusContratacion, sl.background_sl, sl.color,
        lo.tipo_estatus_regreso, 'ABIERTO' tipo
        FROM lotes lo
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        INNER JOIN opcs_x_cats oxc1 ON oxc1.id_opcion = co.tipo_lote AND oxc1.id_catalogo = 27
        INNER JOIN statuslote sl ON sl.idStatusLote = lo.idStatusLote
        WHERE lo.idStatusLote IN (1) AND lo.status = 1
        ORDER BY UPPER(CAST(re.descripcion AS varchar(100))), co.nombre,  lo.nombreLote")->result_array();
    }

    public function getReporteVentas() {
        $id_rol = $this->session->userdata('id_rol');
        $id_usuario = $id_rol == 6 ? $this->session->userdata('id_lider') : $this->session->userdata('id_usuario');
        $validacionExtra = in_array($id_rol, array(3, 6)) ? "AND cl.id_gerente = $id_usuario" : ( $this->session->userdata('id_rol') == 7 ? "AND cl.id_asesor = $id_usuario" : "");
        return $this->db->query(
            "SELECT
                oxc0.nombre tipoProceso,
                UPPER(CAST(re.descripcion AS varchar(150))) nombreResidencial,
                co.nombre nombreCondominio,
                lo.nombreLote,
                lo.idLote,
                UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)) nombreCliente,
                CASE WHEN u0.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) END nombreAsesor,
                CASE WHEN u2.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)) END nombreGerente,
                CASE WHEN u3.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)) END nombreSubdirector,
                cl.fechaApartado,
                sl.nombre estatusLote,
                sc.nombreStatus estatusContratacion,
                mo.descripcion detalleUltimoEstatus
            FROM lotes lo
                INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente AND cl.idLote = lo.idLote AND cl.proceso >= 2 AND cl.status = 1 $validacionExtra
                INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                INNER JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = cl.proceso AND oxc0.id_catalogo = 97
                INNER JOIN usuarios u0 ON u0.id_usuario = cl.id_asesor
                INNER JOIN usuarios u2 ON u2.id_usuario = cl.id_gerente
                INNER JOIN usuarios u3 ON u3.id_usuario = cl.id_subdirector
                INNER JOIN statuslote sl ON sl.idStatusLote = lo.idStatusLote
                INNER JOIN statuscontratacion sc ON sc.idStatusContratacion = lo.idStatusContratacion
                INNER JOIN movimientos mo ON mo.idMovimiento = lo.idMovimiento
            WHERE lo.status = 1
            ORDER BY UPPER(CAST(re.descripcion AS varchar(100))), co.nombre,  lo.nombreLote"
        )->result_array();
    }

    public function checarDisponibleRe($idLote, $idProyecto){
        $validacionStatus = '';
        if($idProyecto == 21){
            $validacionStatus = 'OR idStatusLote = 21';
        }
        $query = $this->db->query("SELECT * FROM lotes WHERE (idStatusLote = 15 OR idStatusLote = 1 OR idStatusLote = 2 ".$validacionStatus.") AND idLote=".$idLote);
        return $query->result_array();
    }

    public function getListaUsuariosReasignacionJuridico() {
        return $this->db->query("SELECT id_usuario, UPPER(CONCAT(nombre , ' ', apellido_paterno, ' ', apellido_materno)) nombreUsuario 
        FROM usuarios 
        WHERE estatus = 1 AND id_usuario IN (2762, 2747, 13691)
        ORDER BY UPPER(CONCAT(nombre , ' ', apellido_paterno, ' ', apellido_materno, ' '))")->result_array();
    }

    public function getReporteReubicaciones() {
        return $this->db->query("SELECT UPPER(CAST(re.descripcion AS varchar(75))) nombreResidencial, co.nombre nombreCondominio, lo.nombreLote, lo.idLote,
        CASE WHEN cl.id_cliente IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)) END nombreCliente,
        CASE WHEN u0.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) END nombreAsesor,
        CASE WHEN u2.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)) END nombreGerente,
        CASE WHEN u3.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)) END nombreSubdirector,
        oxc.nombre estatusPreproceso, CASE WHEN pxl.idLote IS NULL THEN 'NO SE HA SELECCIONADO NINGUNA PROPUESTA' ELSE 'PROPUESTA FINAL SELECCIONADA' END procesoVenta,
		UPPER(ISNULL(CAST(re2.descripcion AS varchar(75)), 'SIN ESPECIFICAR')) nombreResidencial2, ISNULL(co2.nombre, 'SIN ESPECIFICAR') nombreCondominio2, 
        ISNULL(lo2.nombreLote, 'SIN ESPECIFICAR') nombreLote2, 
        CASE WHEN oxc1.nombre IS NOT NULL THEN oxc1.nombre ELSE CASE WHEN pxl.idLote = pxl.id_lotep THEN 'REESTRUCTURA' ELSE 'REUBICACIÓN' END END tipo_proceso
        FROM lotes lo
        LEFT JOIN clientes cl ON cl.id_cliente = lo.idCliente AND cl.idLote = lo.idLote AND cl.status = 1
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        INNER JOIN usuarios u0 ON u0.id_usuario = lo.id_usuario_asignado
        LEFT JOIN usuarios u2 ON u2.id_usuario = u0.id_lider
        LEFT JOIN usuarios u3 ON u3.id_usuario = u2.id_lider
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = lo.estatus_preproceso AND oxc.id_catalogo = 106
        LEFT JOIN (SELECT idLote, id_lotep FROM propuestas_x_lote WHERE estatus = 1 GROUP BY idLote, id_lotep) pxl ON pxl.idLote = lo.idLote
		LEFT JOIN lotes lo2 ON lo2.idLote = pxl.id_lotep
		LEFT JOIN condominios co2 ON co2.idCondominio = lo2.idCondominio
        LEFT JOIN residenciales re2 ON re2.idResidencial = co2.idResidencial
        LEFT JOIN opcs_x_cats oxc1 ON oxc1.id_opcion = cl.proceso AND oxc1.id_catalogo = 97
        WHERE lo.estatus_preproceso != 0
        ORDER BY lo.estatus_preproceso")->result_array();
    }

    public function obtenerCopropietariosReubicacion($idLote)
    {
        $query = $this->db->query("SELECT * FROM datos_x_copropietario WHERE idLote = $idLote");
        return $query->result_array();
    }

    public function eliminarCopropietarios($ids)
    {
        $this->db->query("DELETE FROM datos_x_copropietario WHERE id_dxcop IN ($ids)");
    }

    public function revisarCFDocumentos($idLote, $idCliente){
        $query = $this->db->query("SELECT * FROM historial_documento WHERE tipo_doc=30  AND idLote=".$idLote." AND idCliente=".$idCliente);

        return $query->result_array();
    }

    public function getCopropietariosReestructura($idLote){
        $query = $this->db->query("SELECT dxc.*, opc.nombre as estado_civil 
        FROM datos_x_copropietario dxc
        LEFT JOIN opcs_x_cats opc ON opc.id_opcion = dxc.estado_civil
        AND opc.id_catalogo=18
        WHERE idLote=".$idLote);
        return $query->result_array();
    }

    public function obtenerLotesLiberar($id_proyecto)
    {
        return $this->db->query("SELECT res.nombreResidencial,con.nombre AS condominio, lot.nombreLote,
                lot.idLote ,lot.sup AS superficie, lot.precio, CONCAT(cli.nombre,' ',cli.apellido_paterno,' ',cli.apellido_materno) nombreCliente,
                lot.liberadoReubicacion AS observacion, oxc.nombre AS nombreOp, 
                lot.comentarioReubicacion, lot.liberadoReubicacion ,
                lot.liberaBandera 
            FROM lotes lot
            INNER JOIN condominios con ON con.idCondominio = lot.idCondominio
            INNER JOIN residenciales res on res.idResidencial = con.idResidencial
            LEFT JOIN opcs_x_cats oxc on oxc.id_opcion = lot.opcionReestructura and id_catalogo = 100
            INNER JOIN loteXReubicacion lotx ON lotx.proyectoReubicacion = con.idResidencial and lotx.idProyecto in ($id_proyecto)
            LEFT JOIN clientes cli ON cli.id_cliente = lot.idCliente and cli.status in (1,0)
            WHERE lot.idStatusLote in (15,2,3)")
            ->result();
    }

    public function getEstadoCivil(){
        $query = $this->db->query("SELECT id_opcion, nombre FROM opcs_x_cats WHERE id_catalogo = 18");
        return $query->result_array();
    }

    function nuevaOpcion($datos){
        return $this->db->query("INSERT INTO opcs_x_cats values(".$datos['id'].",100,'".$datos['nombre']."',1,'".$datos['fecha_creacion']."',1,NULL)");
    }

    public function actualizarValidacion($datos)
    {
        return $this->db->query("UPDATE lotes SET opcionReestructura = ".$datos['opcionReestructura'].", comentarioReubicacion = '".$datos['comentario']."', usuario = ".$datos['userLiberacion']." where idLote = ".$datos['idLote']." ");
    }

    public function insertarCliente($datos)
    {
        return $this->db->query("INSERT INTO datos_x_cliente ([idLote],[nombre],[apellido_paterno],[apellido_materno],[estado_civil],[ine],[domicilio_particular],[correo],[telefono1],[ocupacion],[rescision],[fecha_creacion],[creado_por],[fecha_modificacion],[modificado_por], [tipo_proceso]) VALUES (".$datos['idLote'].", '".$datos['nombre']."', '".$datos['apellido_paterno']."', '".$datos['apellido_materno']."', ".$datos['estado_civil'].", '".$datos['ine']."', '".$datos['domicilio_particular']."', '".$datos['correo']."', '".$datos['telefono1']."', '".$datos['ocupacion']."', null, GETDATE(), 1, GETDATE(), 1, ".$datos['tipo_proceso'].") ");
    }

    public function borrarOpcionModel($id_catalogo,$idOpcion){
        return $this->db->query("UPDATE opcs_x_cats SET estatus = 0 WHERE id_catalogo = $id_catalogo AND id_opcion = $idOpcion ");
    }

    public function editarOpcionModel($datos){
        return $this->db->query("UPDATE opcs_x_cats set nombre = '".$datos['editarCatalogo']."' where id_opcion = ".$datos['idOpcionEdit']." and id_catalogo = 100");
    }

    function get_proyecto_lista_yola() {
        return $this->db->query("SELECT lotx.idProyecto AS idResidencial,
        CONCAT(re.nombreResidencial, ' - ' , re.descripcion) AS descripcion  
        FROM loteXReubicacion lotx
		INNER JOIN residenciales re ON re.idResidencial = lotx.idProyecto AND re.idResidencial IN (14, 21, 22, 25)
		GROUP BY lotx.idProyecto, CONCAT(re.nombreResidencial, ' - ' , re.descripcion)");
    }

    function get_proyecto_lista(){
        return $this->db->query("SELECT lotx.proyectoReubicacion AS idResidencial, CONCAT(res.nombreResidencial, ' - ' , res.descripcion) AS descripcion  
        FROM loteXReubicacion lotx
		INNER JOIN residenciales res ON res.idResidencial = lotx.proyectoReubicacion
		GROUP BY lotx.proyectoReubicacion, CONCAT(res.nombreResidencial, ' - ' , res.descripcion)");
    }

    function get_proyecto_listaCancelaciones(){
        return $this->db->query("SELECT lotx.idProyecto AS idResidencial, CONCAT(res.nombreResidencial, ' - ' , res.descripcion) AS descripcion  
        FROM loteXReubicacion lotx
		INNER JOIN residenciales res ON res.idResidencial = lotx.idProyecto 
		GROUP BY lotx.idProyecto,CONCAT(res.nombreResidencial, ' - ' , res.descripcion)");
    }

    public function validarEstatusContraloriaJuridico($idLote){
        return $this->db->query("SELECT flagProcesoContraloria, flagProcesoJuridico FROM datos_x_cliente WHERE idLote = $idLote")->row();
    }

    function getFusion($idLote, $tipo){
        if ($tipo == 1){
            $tipoOrigenDestino = 'AND origen = 1';
        }
        else if($tipo == 0){
            $tipoOrigenDestino = 'AND destino = 1';
        }
        else{
            $tipoOrigenDestino = '';
        }

        $query = $this->db->query("SELECT lf.*, l.sup, lf.idCliente, l.nombreLote nombreLoteDO, l.idCondominio, co.originales,
        hd.expediente, hd.idDocumento, c.nombre AS nombreCondominio, r.nombreResidencial
        FROM lotesFusion lf
        INNER JOIN lotes l ON l.idLote = lf.idLote
        LEFT JOIN historial_documento hd ON hd.idLote=l.idLote AND hd.tipo_doc=30
        LEFT JOIN condominios c ON c.idCondominio=l.idCondominio
        LEFT JOIN residenciales r ON r.idResidencial = c.idResidencial
        LEFT JOIN (SELECT lf2.idLotePvOrigen , COUNT(idLotePvOrigen) as originales FROM lotesFusion lf2  WHERE origen=1 GROUP BY lf2.idLotePvOrigen ) co ON co.idLotePvOrigen = lf.idLotePvOrigen
        WHERE lf.idLotePvOrigen=".$idLote." $tipoOrigenDestino");
        return $query->result_array();
    }

    public function validateLote($idLote){
        $this->db->where("idLote", $idLote);
        $this->db->where_in('idStatusLotee', array('1', '101', '102', '16'));
        $this->db->where("(idStatusContratacion = 0 OR idStatusContratacion IS NULL)");
        $query = $this->db->get('lotes');
        $valida = (empty($query->result())) ? 0 : 1;
        return $valida;
    }

    public function getListaLotesPendienteTraspasoNormales() {
        return $this->db->query("SELECT re.nombreResidencial nombreResidencialOrigen, co.nombre nombreCondominioOrigen, lo.nombreLote nombreLoteOrigen, lo.referencia referenciaOrigen, lo.idLote idLoteOrigen,
        UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)) nombreCliente, dxc.id_dxc, cl.proceso, ISNULL(oxc0.nombre, 'Normal') tipo_proceso, dxc.cantidadTraspaso, dxc.comentario comentarioTraspaso,
        re2.nombreResidencial nombreResidencialDestino, co2.nombre nombreCondominioDestino, lo2.nombreLote nombreLoteDestino, lo2.referencia referenciaDestino, lo2.idLote idLoteDestino,
        co2.idCondominio idCondominioDestino, cl.id_cliente idClienteDestino, 1 tipo, pxl.corrida
        FROM propuestas_x_lote pxl
        INNER JOIN lotes lo ON lo.idLote = pxl.idLote AND lo.liberaBandera = 1 AND lo.status = 1 AND lo.solicitudCancelacion != 2
        INNER JOIN condominios co ON lo.idCondominio = co.idCondominio
        INNER JOIN residenciales re ON co.idResidencial = re.idResidencial
        INNER JOIN datos_x_cliente dxc ON dxc.idLote = lo.idLote AND dxc.estatusTraspaso = 0
        INNER JOIN lotes lo2 ON lo2.idLote = pxl.id_lotep
        INNER JOIN condominios co2 ON lo2.idCondominio = co2.idCondominio
        INNER JOIN residenciales re2 ON co2.idResidencial = re2.idResidencial
        INNER JOIN clientes cl ON cl.id_cliente = lo2.idCliente AND cl.idLote = lo2.idLote AND cl.status = 1 AND cl.proceso IN (2, 3, 4, 5, 6)
        INNER JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = cl.proceso AND oxc0.id_catalogo = 97
        WHERE pxl.estatus = 1
        ORDER BY lo.nombreLote")->result_array();
    }
    public function getLotesFusion($idLote){
        $query = $this->db->query("SELECT * FROM lotesFusion WHERE idLotePvOrigen IN(SELECT idLotePvOrigen FROM lotesFusion where idLote=$idLote) AND origen=1");
        return $query->result_array();
    }
    public function get_catalogo_restructura($id_catalogo){
        return $this->db->query("SELECT id_opcion, nombre FROM opcs_x_cats WHERE id_catalogo = $id_catalogo AND estatus=1");
    }
    public function removeLoteFusion($idFusion,$id_usuario){
        return $this->db->query("UPDATE lotesFusion SET idLote=0,idCliente=0,idLotePvOrigen=0,modificadoPor=$id_usuario WHERE idFusion=$idFusion");
    }
    public function getListaLotesPendienteTraspasoFusion() {
        return $this->db->query("SELECT tb.nombreResidencialOrigen, tb.nombreCondominioOrigen, tb.nombreLoteOrigen, tb.referenciaOrigen, tb.idLoteOrigen,
        UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)) nombreCliente, cl.proceso, ISNULL(oxc0.nombre, 'Normal') tipo_proceso, lf2.cantidadTraspaso, lf2.comentario comentarioTraspaso,
        re2.nombreResidencial nombreResidencialDestino, co2.nombre nombreCondominioDestino, lo2.nombreLote nombreLoteDestino, lo2.referencia referenciaDestino, lo2.idLote idLoteDestino,
        co2.idCondominio idCondominioDestino, cl.id_cliente idClienteDestino, 2 tipo, lf2.corrida
        FROM (
        SELECT lf1.idLotePvOrigen, STRING_AGG (re.nombreResidencial, ', ') nombreResidencialOrigen, STRING_AGG(co.nombre, ', ') nombreCondominioOrigen, STRING_AGG(lo.nombreLote, ', ') nombreLoteOrigen, 
        STRING_AGG(lo.referencia, ', ') referenciaOrigen, STRING_AGG(lo.idLote, ', ') idLoteOrigen
        FROM lotesFusion lf1
        INNER JOIN lotes lo ON lo.idLote = lf1.idLote AND lo.liberaBandera = 1 AND lo.status = 1 AND lo.solicitudCancelacion != 2
        INNER JOIN condominios co ON lo.idCondominio = co.idCondominio
        INNER JOIN residenciales re ON co.idResidencial = re.idResidencial
        WHERE lf1.estatusTraspaso = 0 AND lf1.origen = 1 AND lf1.destino = 0
        GROUP BY lf1.idLotePvOrigen) tb
        INNER JOIN lotesFusion lf2 ON lf2.idLotePvOrigen = tb.idLotePvOrigen AND lf2.estatusTraspaso = 0
        INNER JOIN lotes lo2 ON lo2.idLote = lf2.idLote AND lf2.origen = 0 AND lf2.destino = 1
        INNER JOIN condominios co2 ON lo2.idCondominio = co2.idCondominio
        INNER JOIN residenciales re2 ON co2.idResidencial = re2.idResidencial
        INNER JOIN clientes cl ON cl.id_cliente = lo2.idCliente AND cl.idLote = lf2.idLote AND cl.status = 1 AND cl.proceso IN (5, 6)
        INNER JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = cl.proceso AND oxc0.id_catalogo = 97")->result_array();
    }
    public function getReporteEstatus() {
        return $this->db->query("SELECT CASE WHEN CAST(pxl.idLote AS varchar(150)) = STRING_AGG(pxl.id_lotep, ', ') THEN 'Reestructura' ELSE 'Reubicación' END tipo_proceso,
        re.nombreResidencial nombreResidencialOrigen, co.nombre nombreCondominioOrigen, lo.nombreLote nombreLoteOrigen, lo.referencia referenciaOrigen, lo.idLote idLoteOrigen,
        STRING_AGG(re2.nombreResidencial, ', ') nombreResidencialDestino, STRING_AGG(co2.nombre, ', ') nombreCondominioDestino, STRING_AGG(lo2.nombreLote, ', ') nombreLoteDestino, STRING_AGG(lo2.referencia, ', ') referenciaDestino, 
        STRING_AGG(lo2.idLote, ', ') idLoteDestino, CASE WHEN (lo2.validacionEnganche = 'NULL' OR lo2.validacionEnganche IS NULL) THEN 'PENDIENTE' ELSE 'CONFIRMADO' END validacionAdministracion, 1 tipo, STRING_AGG(oxc0.nombre, ', ') estatusProceso
        FROM propuestas_x_lote pxl
        INNER JOIN lotes lo ON lo.idLote = pxl.idLote AND lo.liberaBandera = 1 AND lo.solicitudCancelacion != 2
        INNER JOIN condominios co ON lo.idCondominio = co.idCondominio
        INNER JOIN residenciales re ON co.idResidencial = re.idResidencial
        LEFT JOIN lotes lo2 ON lo2.idLote = pxl.id_lotep
        LEFT JOIN condominios co2 ON lo2.idCondominio = co2.idCondominio
        LEFT JOIN residenciales re2 ON co2.idResidencial = re2.idResidencial
		INNER JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = lo.estatus_preproceso AND oxc0.id_catalogo = 106
        GROUP BY re.nombreResidencial, co.nombre, lo.nombreLote, lo.referencia, lo.idLote, pxl.idLote, lo2.validacionEnganche, oxc0.nombre
        UNION ALL
        SELECT 'Reubicación' tipo_proceso, tb.nombreResidencialOrigen, tb.nombreCondominioOrigen, tb.nombreLoteOrigen, tb.referenciaOrigen, tb.idLoteOrigen,
        STRING_AGG(re2.nombreResidencial, ', ') nombreResidencialDestino, STRING_AGG(co2.nombre, ', ') nombreCondominioDestino, STRING_AGG(lo2.nombreLote, ', ') nombreLoteDestino, 
        STRING_AGG(lo2.referencia, ', ') referenciaDestino, STRING_AGG(lo2.idLote, ', ') idLoteDestino, tb.validacionAdministracion, 2 tipo, STRING_AGG(oxc0.nombre, ', ') estatusProceso
        FROM (
        SELECT lf1.idLotePvOrigen, re.nombreResidencial nombreResidencialOrigen, co.nombre nombreCondominioOrigen, lo.nombreLote nombreLoteOrigen, 
        lo.referencia referenciaOrigen, lo.idLote idLoteOrigen, CASE WHEN (lo.validacionEnganche = 'NULL' OR lo.validacionEnganche IS NULL) THEN 'PENDIENTE' ELSE 'CONFIRMADO' END validacionAdministracion
        FROM lotesFusion lf1
        INNER JOIN lotes lo ON lo.idLote = lf1.idLote AND lo.liberaBandera = 1 AND lo.status = 1 AND lo.solicitudCancelacion != 2
        INNER JOIN condominios co ON lo.idCondominio = co.idCondominio
        INNER JOIN residenciales re ON co.idResidencial = re.idResidencial
        WHERE lf1.origen = 1 AND lf1.destino = 0) tb
        INNER JOIN lotesFusion lf2 ON lf2.idLotePvOrigen = tb.idLotePvOrigen AND lf2.estatusTraspaso = 0
        INNER JOIN lotes lo2 ON lo2.idLote = lf2.idLote AND lf2.origen = 0 AND lf2.destino = 1
        INNER JOIN condominios co2 ON lo2.idCondominio = co2.idCondominio
        INNER JOIN residenciales re2 ON co2.idResidencial = re2.idResidencial
		INNER JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = lo2.estatus_preproceso AND oxc0.id_catalogo = 106
        GROUP BY tb.nombreResidencialOrigen, tb.nombreCondominioOrigen, tb.nombreLoteOrigen, tb.referenciaOrigen, tb.idLoteOrigen, tb.validacionAdministracion
        ORDER BY nombreLoteDestino")->result_array();
    }

    public function getHistorialPorLote($idLote){
        return $this->db->query("SELECT CONCAT (CASE
        WHEN hp.id_preproceso = 2 AND pr.fecha_modificacion < '2023-12-04 00:00:00.000' THEN 'Elaboración de corridas' WHEN hp.id_preproceso = 2 AND pr.fecha_modificacion > '2023-12-04 00:00:00.000' THEN 'Elaboración de corridas, contrato y rescisión'
        WHEN hp.id_preproceso = 3 AND pr.fecha_modificacion < '2023-12-04 00:00:00.000' THEN 'Elaboración de contrato y resicisión' WHEN hp.id_preproceso = 3 AND pr.fecha_modificacion > '2023-12-04 00:00:00.000' THEN 'Recepción de documentación'
        WHEN hp.id_preproceso = 4 AND pr.fecha_modificacion < '2023-12-04 00:00:00.000' THEN 'Documentación entregada' WHEN hp.id_preproceso = 4 AND pr.fecha_modificacion > '2023-12-04 00:00:00.000' THEN 'Obtención de firma del cliente'
        WHEN hp.id_preproceso = 5 AND pr.fecha_modificacion < '2023-12-04 00:00:00.000' THEN 'Recepción de documentos confirmada' WHEN hp.id_preproceso = 5 AND pr.fecha_modificacion > '2023-12-04 00:00:00.000' THEN 'Contrato firmado confirmado, pendiente traspaso de recurso'
        ELSE oxc0.nombre END, ' (', oxc1.nombre, ')') movimiento, 
        CONCAT(UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)), ' (', oxc2.nombre, ')') nombreUsuario, hp.fecha_modificacion fechaEstatus
        FROM historial_preproceso_lote hp
        INNER JOIN propuestas_x_lote pr ON pr.idLote = hp.idLote
        INNER JOIN lotes lo ON lo.idLote = pr.idLote
        INNER JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = hp.id_preproceso AND oxc0.id_catalogo = 106
        INNER JOIN opcs_x_cats oxc1 ON oxc1.id_opcion = hp.estatus AND oxc1.id_catalogo = 108
        INNER JOIN usuarios u0 ON u0.id_usuario = hp.modificado_por
        INNER JOIN opcs_x_cats oxc2 ON oxc2.id_opcion = u0.id_rol AND oxc2.id_catalogo = 1
        WHERE hp.idLote = $idLote
        ORDER BY lo.idLote, hp.fecha_modificacion")->result_array();
    }
    public function borrarPXL($id_lote){
        $this->db->query('DELETE FROM propuestas_x_lote WHERE id_lotep = '.$id_lote.' AND idLote='.$id_lote);
        return $this->db->affected_rows();
    }

    public function coopropietarioPorDR($idLote){
        $query = $this->db->query('SELECT * FROM datos_x_copropietario WHERE idLote='.$idLote);
        return $query->result_array();
    }

    public function EstatusLote(){
        $query = $this->db->query('SELECT idStatusContratacion, nombreStatus FROM statuscontratacion WHERE idStatusContratacion not in (4, 12)');
        return $query;
    }

    public function reestructuraLotes($id_proyecto){
        ini_set('memory_limit', -1);
        $query = $this->db-> query("SELECT cl.nombre, cl.apellido_paterno, cl.apellido_materno,
		l.nombreLote, l.perfil, res.nombreResidencial, cond.nombre as nombreCondominio,
		l.ubicacion, ISNULL(tv.tipo_venta, 'Sin especificar') tipo_venta, l.firmaRL, 
        CASE WHEN u0.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) END nombreAsesor,
        CASE WHEN u1.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)) END nombreCoordinador,
        CASE WHEN u2.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)) END nombreGerente,
        opx.nombre as RL, cond.idCondominio, mov.descripcion as movimientoLote, se.nombre as nombreSede, stcon.nombreStatus, ISNULL(oxc0.nombre, 'Normal') tipo_proceso
		FROM lotes l
		INNER JOIN clientes cl ON cl.id_cliente = l.idCliente AND cl.idLote = l.idLote AND cl.proceso NOT IN (1,0)
		INNER JOIN condominios cond ON l.idCondominio=cond.idCondominio
		INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
		LEFT JOIN usuarios u0 ON cl.id_asesor = u0.id_usuario
		LEFT JOIN usuarios u1 ON cl.id_coordinador = u1.id_usuario
		LEFT JOIN usuarios u2 ON cl.id_gerente = u2.id_usuario
		LEFT JOIN opcs_x_cats opx ON cl.rl  = opx.id_opcion AND opx.id_catalogo = 77
		LEFT JOIN sedes se ON se.id_sede = l.ubicacion
		LEFT JOIN tipo_venta tv ON tv.id_tventa = l.tipo_venta
        LEFT JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = cl.proceso AND oxc0.id_catalogo = 97
		LEFT JOIN movimientos mov ON mov.idMovimiento = l.idMovimiento
		LEFT JOIN statuscontratacion stcon ON stcon.idStatusContratacion = l.idStatusContratacion
		WHERE l.status = 1 AND l.idStatusContratacion IN ($id_proyecto)
		GROUP BY cl.nombre, cl.apellido_paterno, cl.apellido_materno,
		l.nombreLote, l.perfil, cond.nombre, res.nombreResidencial, l.ubicacion,
		tv.tipo_venta, l.firmaRL,
		concat(u0.nombre,' ', u0.apellido_paterno, ' ', u0.apellido_materno),
		concat(u1.nombre,' ', u1.apellido_paterno, ' ', u1.apellido_materno),
		concat(u2.nombre,' ', u2.apellido_paterno, ' ', u2.apellido_materno),opx.nombre ,u0.id_usuario,u1.id_usuario,u2.id_usuario,
		cond.idCondominio, ISNULL(oxc0.nombre, 'Normal'),mov.descripcion,stcon.nombreStatus,se.nombre
		ORDER BY l.nombreLote");
        return $query->result();
    }
    function getProyectoIdByLote($idLote){
        $query = $this->db->query("SELECT re.idResidencial as idProyecto, co.idCondominio, lo.idLote
        FROM lotes lo
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        WHERE lo.idLote=".$idLote);
        return $query->result_array();
    }
        
    public function getProyectosByIdLote($idLoteOriginal){//Reubicación reestructura excedente
        $query = $this->db->query("SELECT re.idResidencial as idProyectoOriginal, pxl.idLote as idLoteOriginal, pl1.idResidencial as idProyectoPropuesta,
        pxl.id_lotep as idLotePropuesta
        FROM lotes lo
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        INNER JOIN propuestas_x_lote pxl ON pxl.idLote = lo.idLote
        LEFT JOIN (SELECT lot.idLote, res.idResidencial FROM lotes lot INNER JOIN condominios cond ON cond.idCondominio = lot.idCondominio INNER JOIN residenciales res ON res.idResidencial = cond.idResidencial) pl1 ON pl1.idLote = pxl.id_lotep
        WHERE lo.idLote=".$idLoteOriginal);
        return $query->result_array();
    }

    public function getLotesDetail($idLotes){
        $query = $this->db->query("SELECT lo.idLote, lo.idStatusLote, re.idResidencial FROM lotes lo
        INNER JOIN condominios co ON co.idCondominio= lo.idCondominio
        INNER JOIN residenciales re ON co.idResidencial = re.idResidencial
        WHERE lo.idLote in ($idLotes)");
        
        return $query->result_array();
    }

    public function getReporteCancelaciones() {
        $validacionCancelacionEnProceso = $this->session->userdata('id_rol') == 33 ? "OR (lo.solicitudCancelacion = 2)" : "";
        return $this->db->query(
            "SELECT 
                re.nombreResidencial, 
                co.nombre nombreCondominio, 
                lo.nombreLote, 
                CASE WHEN hl.idLiberacion IS NULL THEN lo.comentarioLiberacion ELSE hl.comentarioLiberacion END comentarioLiberacion, 
                lo.idLote, 
                cl.id_cliente, 
                CASE WHEN cl.id_cliente IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', apellido_materno)) END nombreCliente,
                ISNULL(oxc0.nombre, 'SIN ESPECIFICAR') tipoCancelacion,
                lo.idStatusLote, 
                lo.solicitudCancelacion,
                lo.comentarioReubicacion,
                CASE WHEN lo.solicitudCancelacion = 2 THEN 'PENDIENTE VALIDACIÓN' ELSE 'CANCELADA' END estatusCancelacion
            FROM 
                lotes lo 
                INNER JOIN condominios co ON co.idCondominio = lo.idCondominio 
                INNER JOIN residenciales re ON re.idResidencial = co.idResidencial 
                LEFT JOIN historial_liberacion hl ON hl.idLote = lo.idLote AND hl.observacionLiberacion = 'CANCELACIÓN DE CONTRATO'
                LEFT JOIN clientes cl ON cl.id_cliente = hl.id_cliente AND cl.idLote = hl.idLote 
                LEFT JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = tipoCancelacion AND oxc0.id_catalogo = 117
            WHERE 
                lo.idStatusLote IN (18) $validacionCancelacionEnProceso
            ORDER BY CASE WHEN lo.solicitudCancelacion = 2 THEN 0 ELSE lo.solicitudCancelacion END, lo.nombreLote"
            )->result();
    }

    public function getLotesParaCargarContratoFirmado() {
        return $this->db->query(
            "SELECT 
                re.nombreResidencial abreviaturaNombreResidencial,
                re.descripcion nombreResidencial,
                co.nombre nombreCondominio,
                lo.nombreLote,
                lo.idLote,
                CASE WHEN cl.id_cliente IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)) END nombreCliente,
                cl.fechaApartado,
                hd.idDocumento,
                hd.movimiento rama,
                hd.expediente nombreDocumento,
                oxc.nombre estatusPreproceso,
                CASE WHEN hd.expediente IS NULL THEN 'PENDIENTE' ELSE 'CARGADO' END estatusContratoFirmado,
                hd.tipo_doc tipoDocumento,
                lo.idCliente
            FROM lotes lo
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
            INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
            INNER JOIN (SELECT DISTINCT(idProyecto) idProyecto FROM loteXReubicacion ) lxr ON lxr.idProyecto = re.idResidencial
            LEFT JOIN clientes cl ON cl.id_cliente = lo.idCliente AND cl.idLote = lo.idLote AND cl.status = 1
            INNER JOIN historial_documento hd ON hd.idLote = lo.idLote AND hd.tipo_doc = 30 AND hd.status = 1
            LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = lo.estatus_preproceso AND oxc.id_catalogo = 106
            WHERE
                lo.status = 1
                AND lo.estatus_preproceso IN (0, 1, 2) 
                AND lo.id_usuario_asignado != 0
                AND lo.idStatusLote IN (2, 3)
            ORDER BY lo.nombreLote"
        )->result_array();
    }

    public function getSedes(){
        $query = $this->db->query("SELECT * FROM sedes WHERe estatus=1;");
        return $query->result_array();
    }

    public function getLotesParaCargarContratoReubFirmado() {
        return $this->db->query(
            "SELECT 
                re.nombreResidencial abreviaturaNombreResidencial,
                re.descripcion nombreResidencial,
                co.nombre nombreCondominio,
                lo.nombreLote,
                lo.idLote,
                CASE WHEN cl.id_cliente IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)) END nombreCliente,
                cl.fechaApartado,
                hd.idDocumento,
                hd.movimiento rama,
                hd.expediente nombreDocumento,
                oxc.nombre estatusPreproceso,
                CASE WHEN hd.expediente IS NULL THEN 'PENDIENTE' ELSE 'CARGADO' END estatusContratoReubicacionFirmado,
                hd.tipo_doc tipoDocumento,
                lo.idCliente
            FROM lotes lo
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
            INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
            INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente AND cl.idLote = lo.idLote AND cl.status = 1 AND cl.proceso NOT IN (0, 1)
            INNER JOIN historial_documento hd ON hd.idLote = lo.idLote AND hd.tipo_doc = 44 AND hd.status = 1
            INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = cl.proceso AND oxc.id_catalogo = 97
		    WHERE lo.status = 1 AND lo.idStatusContratacion <= 8
            ORDER BY lo.nombreLote"
        )->result_array();
    }

    public function setSolicitudCancelacion($dataPost){
        $usuario = $this->session->userdata('id_usuario');
        $idLote = $dataPost['idLote'];
        $obsSolicitudCancel = $dataPost['obsSolicitudCancel'];
        $nombreLote = $dataPost['nombreLote'];

        $tipoCancelacion = isset($dataPost['tipoCancelacion']) ? $dataPost['tipoCancelacion'] : 0;
        $tipoCancelacionNombre = $tipoCancelacion == 0 ? '' : $dataPost['tipoCancelacionNombre'];
        
        $this->db->trans_begin();
        $this->db->query("UPDATE lotes SET solicitudCancelacion = '2', comentarioReubicacion = '" . $obsSolicitudCancel . "', usuario = ".$usuario." where idLote = ".$idLote." ");
        $data = $this->db->query("UPDATE clientes SET tipoCancelacion = $tipoCancelacion where idLote = ".$idLote." and status = 1");
        
        $this->email
            ->initialize()
            ->from('Ciudad Maderas')
            ->to('programador.analista12@ciudadmaderas.com')
            ->subject('Notificación de solicitud de cancelación reestructura')
            ->view($this->load->view('mail/reestructura/mailSolicitudCancelacion', [
                'lote' => $nombreLote,
                'Observaciones' => $obsSolicitudCancel,
                'tipoCancelacion' => $tipoCancelacionNombre
            ], true));
        $this->email->send();

        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function returnToRestructure($data){
        $comentarioReubicacion = $data['observaciones'];
		$idLote = $data['idLote'];
		$idUsuario = $this->session->userdata('id_usuario');

        $this->db->trans_begin();
        $this->db->query("UPDATE lotes SET solicitudCancelacion = '1', comentarioReubicacion = '" . $comentarioReubicacion . "', usuario = ".$idUsuario." where idLote = ".$idLote." ");
        $this->db->query("UPDATE clientes SET tipoCancelacion = 0 where idLote = ".$idLote." and status = 1");
        
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }
}
