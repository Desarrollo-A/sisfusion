<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Asesor_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
    }
    function getinfoCliente($id_cliente) {
        return $this->db->query("SELECT cl.correo, cl.nombre, cl.apellido_paterno, oc3.nombre as regimen_valor, oc2.nombre as estado_valor, cl.domicilio_particular, oc.nombre as 
            nacionalidad_valor, cl.apellido_materno, cl.rfc, cl.personalidad_juridica, cl.fecha_nacimiento, cl.telefono_empresa, cl.tipo_vivienda, cl.telefono1, cl.telefono2, cl.telefono3, 
            cl.correo, lot.idLote, lot.nombreLote, lot.sup, lot.precio, res.nombreResidencial, con.nombre as nombreCondominio, con.idCondominio, ds.id as idDeposito, ds.clave,res.idResidencial as desarrollo, 
            con.tipo_lote as tipoLote, ds.idOficial_pf, ds.idDomicilio_pf, ds.actaConstitutiva_pm, ds.idOficialApoderado_pm, ds.poder_pm, ds.actaMatrimonio_pf, ds.idDomicilio_pm, cl.nombre_conyuge, 
            cl.nacionalidad, cl.originario_de as originario, cl.estado_civil, cl.regimen_matrimonial, cl.ocupacion, cl.empresa, cl.puesto, cl.antiguedad, cl.edadFirma, cl.domicilio_empresa, ds.noRefPago, 
            ds.costoM2, ds.costoM2_casas, ds.proyecto, ds.municipio as municipioDS, ds.importOferta, ds.letraImport, ds.cantidad, ds.letraCantidad, ds.saldoDeposito, aportMensualOfer, ds.fecha1erAport, 
            ds.plazo, ds.fechaLiquidaDepo, ds.fecha2daAport, ds.municipio2, ds.dia, ds.mes, ds.anio, ds.observacion, ds.nombreFirmaAsesor, ds.fechaCrate, ds.id_cliente, lot.referencia, 
            ds.costom2f, oc4.nombre AS reg_nom, cl.cp_fac FROM clientes cl  
        INNER JOIN lotes lot ON cl.idLote = lot.idLote 
        INNER JOIN condominios con ON con.idCondominio = lot.idCondominio  
        INNER JOIN residenciales res ON res.idResidencial = con.idResidencial  
        INNER JOIN deposito_seriedad ds ON ds.id_cliente = cl.id_cliente
        LEFT JOIN opcs_x_cats oc ON oc.id_opcion = cl.nacionalidad AND oc.id_catalogo = 11
        LEFT JOIN opcs_x_cats oc2 ON oc2.id_opcion = cl.estado_civil AND oc2.id_catalogo = 18
        LEFT JOIN opcs_x_cats oc3 ON oc3.id_opcion = cl.regimen_matrimonial AND oc3.id_catalogo = 19
        LEFT JOIN opcs_x_cats oc4 ON oc4.id_opcion = cl.regimen_fac AND oc4.id_catalogo = 92  
        WHERE cl.id_cliente = $id_cliente");
    }

    function getinfoCopropietario($id_cliente){
        return $this->db->query("SELECT id_copropietario, id_cliente, regimen_matrimonial as regimen_valor, estado_civil as estado_valor, co.nacionalidad as nacionalidad_valor, co.nombre as nombre_cop, apellido_paterno, apellido_materno, telefono, telefono_2, correo, fecha_nacimiento, originario_de, conyuge, domicilio_particular, personalidad_juridica, ocupacion, empresa, posicion,  antiguedad, edadFirma, direccion, tipo_vivienda, rfc
        FROM copropietarios co 
        WHERE co.estatus = 1 AND co.id_cliente =" . $id_cliente);
    }

	function getMenu($rol) {
        $idUsuario = $this->session->userdata('id_usuario');
        if ($this->existeUsuarioMenuEspecial($idUsuario)) {
            return $this->getMenuPadreEspecial($idUsuario);
        }
		if ($this->session->userdata('estatus') == 3)  { // ES GREENHAM , COREANO, BADABUM, CONTACT CENTER
        $complemento='';
            return $this->db->query("SELECT * FROM Menu2 WHERE rol=".$rol." AND nombre IN ('Inicio', 'Comisiones' $complemento) AND estatus = 1 order by orden asc");
        } else {
                        return $this->db->query("SELECT * FROM Menu2 WHERE rol=" . $rol . " AND estatus = 1 ORDER BY orden ASC");           
        }
    }

    function getMenuHijos($rol)
    {
        $idUsuario = $this->session->userdata('id_usuario');
        if ($this->existeUsuarioMenuEspecial($idUsuario)) {
            return $this->getMenuHijoEspecial($idUsuario);
        }
        return $this->db->query("SELECT * FROM Menu2 WHERE rol=" . $rol . " AND padre > 0 AND estatus = 1  order by orden asc");
    }

    function getActiveBtn($var, $rol) {
        return $this->db->query("SELECT padre FROM Menu2 WHERE pagina='" . $var . "' AND rol=" . $rol . " ");
    }
    public function existeUsuarioMenuEspecial($idUsuario)
    {
        $query = $this->db->query("SELECT id_menu_u FROM menu_usuario WHERE id_usuario = $idUsuario");
        $result = $query->result_array();
        return count($result) > 0;
    }
    public function getMenuPadreEspecial($idUsuario)
    {
        return $this->db->query("SELECT * FROM Menu2 WHERE idmenu IN 
            (SELECT value FROM menu_usuario CROSS APPLY STRING_SPLIT(menu, ',') 
                    WHERE id_usuario = $idUsuario AND es_padre = 1) AND estatus=1 ORDER BY orden");
    }
    public function getMenuHijoEspecial($idUsuario)
    {
        return $this->db->query("SELECT * FROM Menu2 WHERE idmenu IN 
            (SELECT value FROM menu_usuario CROSS APPLY STRING_SPLIT(menu, ',') 
            WHERE id_usuario = $idUsuario AND es_padre = 0) AND estatus=1 ORDER BY orden");
    }
    public function getDataDs1($id_cliente) { // DATA FROM DEPOSITO_SERIEDAD
        ini_set('max_execution_time', 300);
        set_time_limit(300);
        $query = $this->db->query("SELECT '1' qry, '1' dsType, cl.id_cliente, id_asesor, id_coordinador, id_gerente, cl.id_sede, cl.correo, cl.telefono2,
        UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)) nombreCliente, cl.status ,cl.idLote, convert(varchar,fechaApartado,20) as fechaApartado, fechaVencimiento, cl.usuario, cond.idCondominio, cl.fecha_creacion, 
        cl.creado_por, cl.fecha_modificacion, cl.modificado_por, cond.nombre as nombreCondominio, residencial.nombreResidencial as nombreResidencial,
        cl.status, nombreLote, lotes.comentario, lotes.idMovimiento, convert(varchar,lotes.fechaVenc,20) as fechaVenc, lotes.modificado, lotes.observacionContratoUrgente as vl, lotes.idStatusContratacion, cl.concepto, cl.id_prospecto,
        cl.flag_compartida, aut.estatus,
        CASE WHEN u0.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) END asesor,
        CASE WHEN u1.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)) END coordinador,
        CASE WHEN u2.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)) END gerente,
        CASE WHEN u3.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)) END subdirector,
        CASE WHEN u4.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)) END regional,
        CASE WHEN u5.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u5.nombre, ' ', u5.apellido_paterno, ' ', u5.apellido_materno)) END regional2,
        cl.tipo_comprobanteD, cl.autorizacion_correo, cl.autorizacion_sms,
        ISNULL(tipo_correo_aut.total, 0) AS total_sol_correo_aut, ISNULL(tipo_correo_pend.total, 0) AS total_sol_correo_pend, 
        ISNULL(tipo_correo_rech.total, 0) AS total_sol_correo_rech,
	    ISNULL(tipo_sms_aut.total, 0) AS total_sol_sms_aut, ISNULL(tipo_sms_pend.total, 0) AS total_sol_sms_pend,
	    ISNULL(tipo_sms_rech.total, 0) AS total_sol_sms_rech
		FROM clientes as cl
        LEFT JOIN lotes as lotes ON lotes.idLote=cl.idLote
        LEFT JOIN condominios as cond ON lotes.idCondominio=cond.idCondominio
        LEFT JOIN residenciales as residencial ON cond.idResidencial=residencial.idResidencial
        LEFT JOIN usuarios u0 ON u0.id_usuario = cl.id_asesor
        LEFT JOIN usuarios u1 ON u1.id_usuario = cl.id_coordinador
        LEFT JOIN usuarios u2 ON u2.id_usuario = cl.id_gerente
        LEFT JOIN usuarios u3 ON u3.id_usuario = cl.id_subdirector
        LEFT JOIN usuarios u4 ON u4.id_usuario = cl.id_regional
        LEFT JOIN usuarios u5 ON u5.id_usuario = cl.id_regional_2
        LEFT JOIN autorizaciones AS aut ON cl.id_cliente = aut.idCliente AND lotes.idLote = aut.idLote
        LEFT JOIN codigo_autorizaciones acc ON cl.id_cliente = acc.id_cliente AND acc.tipo = 2
        LEFT JOIN codigo_autorizaciones acs ON cl.id_cliente = acs.id_cliente AND acs.tipo = 3
        LEFT JOIN (SELECT COUNT(*) AS total, idCliente, idLote
            FROM autorizaciones
            WHERE id_tipo = 2 AND estatus = 0
            GROUP BY idCliente, idLote) tipo_correo_aut ON tipo_correo_aut.idCliente = $id_cliente AND tipo_correo_aut.idLote = lotes.idLote
        
        LEFT JOIN (SELECT COUNT(*) AS total, idCliente, idLote
            FROM autorizaciones
            WHERE id_tipo = 2 AND estatus = 1
            GROUP BY idCliente, idLote) tipo_correo_pend ON tipo_correo_pend.idCliente = $id_cliente AND tipo_correo_pend.idLote = lotes.idLote
		    
        LEFT JOIN (SELECT COUNT(*) AS total, idCliente, idLote
            FROM autorizaciones
            WHERE id_tipo = 2 AND estatus = 2
            GROUP BY idCliente, idLote) tipo_correo_rech ON tipo_correo_rech.idCliente = $id_cliente AND tipo_correo_rech.idLote = lotes.idLote
        
        LEFT JOIN (SELECT COUNT(*) AS total, idCliente, idLote
            FROM autorizaciones
            WHERE id_tipo = 3 AND estatus = 0
            GROUP BY idCliente, idLote) tipo_sms_aut ON tipo_sms_aut.idCliente = $id_cliente AND tipo_sms_aut.idLote = lotes.idLote
        
        LEFT JOIN (SELECT COUNT(*) AS total, idCliente, idLote
            FROM autorizaciones
            WHERE id_tipo = 3 AND estatus = 1
            GROUP BY idCliente, idLote) tipo_sms_pend ON tipo_sms_pend.idCliente = $id_cliente AND tipo_sms_pend.idLote = lotes.idLote
		    
        LEFT JOIN (SELECT COUNT(*) AS total, idCliente, idLote
            FROM autorizaciones
            WHERE id_tipo = 3 AND estatus = 2
            GROUP BY idCliente, idLote) tipo_sms_rech ON tipo_sms_rech.idCliente = $id_cliente AND tipo_sms_rech.idLote = lotes.idLote
        INNER JOIN deposito_seriedad as ds ON ds.id_cliente = cl.id_cliente
        WHERE lotes.idStatusLote = 3 AND cl.status = 1 AND cl.id_cliente = $id_cliente AND ds.desarrollo IS NOT NULL");
        return $query->result();
    }
    public function getDataDs2($id_cliente)
    { // DATA FROM DEPOSITO_SERIEDAD_CONSULTA
        ini_set('max_execution_time', 300);
        set_time_limit(300);
        $query = $this->db->query("SELECT '2' qry, '2' dsType, cl.idCliente as id_cliente, cl.idAsesor id_asesor, '0' id_coordinador,cl.idGerente id_gerente, '0' id_sede, CONCAT(cl.primerNombre, ' ', cl.segundoNombre) nombre, cl.apellidoPaterno apellido_paterno, cl.correo, cl.telefono2, 
        cl.apellidoMaterno apellido_materno, cl.status ,cl.idLote, convert(varchar,cl.fechaApartado,20) as fechaApartado, convert(varchar,cl.fechaVencimiento,20) as fechaVencimiento, cl.usuario, cond.idCondominio, cl.fechaApartado fecha_creacion, 
        cl.creado_por, cl.fechaApartado fecha_modificacion, cl.usuario modificado_por, cond.nombre as nombreCondominio, residencial.nombreResidencial as nombreResidencial,
        cl.status, nombreLote, lotes.comentario, lotes.idMovimiento, convert(varchar,lotes.fechaVenc,20) as fechaVenc, lotes.modificado, lotes.observacionContratoUrgente as vl, lotes.idStatusContratacion, cl.concepto, '666' as id_prospecto,
        cl.flag_compartida, 'SIN ESPECIFICAR' asesor, 'SIN ESPECIFICAR' coordinador, 'SIN ESPECIFICAR' gerente, 'SIN ESPECIFICAR' subdirector, 'SIN ESPECIFICAR' regional, 'SIN ESPECIFICAR' regional2, 
        aut.estatus as estatus, 'NULL' as tipo_comprobanteD, c.autorizacion_correo, c.autorizacion_sms,
        ISNULL(tipo_correo_aut.total, 0) AS total_sol_correo_aut, ISNULL(tipo_correo_pend.total, 0) AS total_sol_correo_pend, 
        ISNULL(tipo_correo_rech.total, 0) AS total_sol_correo_rech,
	    ISNULL(tipo_sms_aut.total, 0) AS total_sol_sms_aut, ISNULL(tipo_sms_pend.total, 0) AS total_sol_sms_pend,
	    ISNULL(tipo_sms_rech.total, 0) AS total_sol_sms_rech
		FROM cliente_consulta as cl
        INNER JOIN clientes c ON cl.idCliente = c.id_cliente 
        LEFT JOIN lotes as lotes ON lotes.idLote=cl.idLote
        LEFT JOIN condominios as cond ON lotes.idCondominio=cond.idCondominio
        LEFT JOIN residenciales as residencial ON cond.idResidencial=residencial.idResidencial
        INNER JOIN deposito_seriedad_consulta as ds ON ds.idCliente = cl.idCliente
        LEFT JOIN autorizaciones AS aut ON cl.idCliente = aut.idCliente AND lotes.idLote = aut.idLote
		LEFT JOIN codigo_autorizaciones acc ON cl.idCliente = acc.id_cliente AND acc.tipo = 2
        LEFT JOIN codigo_autorizaciones acs ON cl.idCliente = acs.id_cliente AND acs.tipo = 3
		LEFT JOIN (SELECT COUNT(*) AS total, idCliente, idLote
            FROM autorizaciones
            WHERE id_tipo = 2 AND estatus = 0
            GROUP BY idCliente, idLote) tipo_correo_aut ON tipo_correo_aut.idCliente = $id_cliente AND tipo_correo_aut.idLote = lotes.idLote
        
        LEFT JOIN (SELECT COUNT(*) AS total, idCliente, idLote
            FROM autorizaciones
            WHERE id_tipo = 2 AND estatus = 1
            GROUP BY idCliente, idLote) tipo_correo_pend ON tipo_correo_pend.idCliente = $id_cliente AND tipo_correo_pend.idLote = lotes.idLote
		    
        LEFT JOIN (SELECT COUNT(*) AS total, idCliente, idLote
            FROM autorizaciones
            WHERE id_tipo = 2 AND estatus = 2
            GROUP BY idCliente, idLote) tipo_correo_rech ON tipo_correo_rech.idCliente = $id_cliente AND tipo_correo_rech.idLote = lotes.idLote
        
        LEFT JOIN (SELECT COUNT(*) AS total, idCliente, idLote
            FROM autorizaciones
            WHERE id_tipo = 3 AND estatus = 0
            GROUP BY idCliente, idLote) tipo_sms_aut ON tipo_sms_aut.idCliente = $id_cliente AND tipo_sms_aut.idLote = lotes.idLote
        
        LEFT JOIN (SELECT COUNT(*) AS total, idCliente, idLote
            FROM autorizaciones
            WHERE id_tipo = 3 AND estatus = 1
            GROUP BY idCliente, idLote) tipo_sms_pend ON tipo_sms_pend.idCliente = $id_cliente AND tipo_sms_pend.idLote = lotes.idLote
		    
        LEFT JOIN (SELECT COUNT(*) AS total, idCliente, idLote
            FROM autorizaciones
            WHERE id_tipo = 3 AND estatus = 2
            GROUP BY idCliente, idLote) tipo_sms_rech ON tipo_sms_rech.idCliente = $id_cliente AND tipo_sms_rech.idLote = lotes.idLote
        WHERE lotes.idStatusLote = 3 AND cl.status = 1 AND cl.idCliente = $id_cliente");
        return $query->result();
    }
    public function getDataDs3($id_cliente)
    { // DATA FROM DEPOSITO_SERIEDAD WHEN NO ENCONTRÓ NOTHING IN getDataDs1 & getDataDs2
        ini_set('max_execution_time', 300);
        set_time_limit(300);
        $query = $this->db->query("SELECT '3' qry, '1' dsType, cl.id_cliente, id_asesor, id_coordinador, id_gerente, cl.id_sede, cl.correo, cl.telefono2,
        UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)) nombreCliente,
        cl.status ,cl.idLote, convert(varchar,fechaApartado,20) as fechaApartado , convert(varchar,fechaVencimiento,20) as fechaVencimiento, cl.usuario, cond.idCondominio, convert(varchar,cl.fecha_creacion,20) as fecha_creacion, 
        cl.creado_por, cl.fecha_modificacion, cl.modificado_por, cond.nombre as nombreCondominio, residencial.nombreResidencial as nombreResidencial, cl.status, nombreLote, lotes.comentario, lotes.idMovimiento, convert(varchar,lotes.fechaVenc,20) as fechaVenc , lotes.modificado, lotes.observacionContratoUrgente as vl, lotes.idStatusContratacion, cl.concepto, cl.id_prospecto,
        cl.flag_compartida, aut.estatus as estatus,
        CASE WHEN u0.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) END asesor,
        CASE WHEN u1.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)) END coordinador,
        CASE WHEN u2.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)) END gerente,
        CASE WHEN u3.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)) END subdirector,
        CASE WHEN u4.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)) END regional,
        CASE WHEN u5.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u5.nombre, ' ', u5.apellido_paterno, ' ', u5.apellido_materno)) END regional2,
        cl.tipo_comprobanteD, cl.autorizacion_correo, cl.autorizacion_sms, 
	    ISNULL(tipo_correo_aut.total, 0) AS total_sol_correo_aut, ISNULL(tipo_correo_pend.total, 0) AS total_sol_correo_pend, 
        ISNULL(tipo_correo_rech.total, 0) AS total_sol_correo_rech,
	    ISNULL(tipo_sms_aut.total, 0) AS total_sol_sms_aut, ISNULL(tipo_sms_pend.total, 0) AS total_sol_sms_pend,
	    ISNULL(tipo_sms_rech.total, 0) AS total_sol_sms_rech 
		FROM clientes as cl
        LEFT JOIN lotes as lotes ON lotes.idLote=cl.idLote
        LEFT JOIN condominios as cond ON lotes.idCondominio=cond.idCondominio
        LEFT JOIN residenciales as residencial ON cond.idResidencial=residencial.idResidencial
        INNER JOIN deposito_seriedad as ds ON ds.id_cliente = cl.id_cliente
        LEFT JOIN usuarios u0 ON u0.id_usuario = cl.id_asesor
        LEFT JOIN usuarios u1 ON u1.id_usuario = cl.id_coordinador
        LEFT JOIN usuarios u2 ON u2.id_usuario = cl.id_gerente
        LEFT JOIN usuarios u3 ON u3.id_usuario = cl.id_subdirector
        LEFT JOIN usuarios u4 ON u4.id_usuario = cl.id_regional
        LEFT JOIN usuarios u5 ON u5.id_usuario = cl.id_regional_2
        LEFT JOIN autorizaciones AS aut ON cl.id_cliente = aut.idCliente AND lotes.idLote = aut.idLote
		LEFT JOIN codigo_autorizaciones acc ON cl.id_cliente = acc.id_cliente AND acc.tipo = 2
        LEFT JOIN codigo_autorizaciones acs ON cl.id_cliente = acs.id_cliente AND acs.tipo = 3
		LEFT JOIN (SELECT COUNT(*) AS total, idCliente, idLote
            FROM autorizaciones
            WHERE id_tipo = 2 AND estatus = 0
            GROUP BY idCliente, idLote) tipo_correo_aut ON tipo_correo_aut.idCliente = $id_cliente AND tipo_correo_aut.idLote = lotes.idLote
        
        LEFT JOIN (SELECT COUNT(*) AS total, idCliente, idLote
            FROM autorizaciones
            WHERE id_tipo = 2 AND estatus = 1
            GROUP BY idCliente, idLote) tipo_correo_pend ON tipo_correo_pend.idCliente = $id_cliente AND tipo_correo_pend.idLote = lotes.idLote
		    
        LEFT JOIN (SELECT COUNT(*) AS total, idCliente, idLote
            FROM autorizaciones
            WHERE id_tipo = 2 AND estatus = 2
            GROUP BY idCliente, idLote) tipo_correo_rech ON tipo_correo_rech.idCliente = $id_cliente AND tipo_correo_rech.idLote = lotes.idLote
        
        LEFT JOIN (SELECT COUNT(*) AS total, idCliente, idLote
            FROM autorizaciones
            WHERE id_tipo = 3 AND estatus = 0
            GROUP BY idCliente, idLote) tipo_sms_aut ON tipo_sms_aut.idCliente = $id_cliente AND tipo_sms_aut.idLote = lotes.idLote
        
        LEFT JOIN (SELECT COUNT(*) AS total, idCliente, idLote
            FROM autorizaciones
            WHERE id_tipo = 3 AND estatus = 1
            GROUP BY idCliente, idLote) tipo_sms_pend ON tipo_sms_pend.idCliente = $id_cliente AND tipo_sms_pend.idLote = lotes.idLote
    
		LEFT JOIN (SELECT COUNT(*) AS total, idCliente, idLote
            FROM autorizaciones
            WHERE id_tipo = 3 AND estatus = 2
            GROUP BY idCliente, idLote) tipo_sms_rech ON tipo_sms_rech.idCliente = $id_cliente AND tipo_sms_rech.idLote = lotes.idLote
        WHERE lotes.idStatusLote = 3 AND cl.status = 1 AND cl.id_cliente = $id_cliente");
        return $query->result();
    }
    public function get_info_prospectos($id_asesor) {
        $query = $this->db->query("SELECT p.*, UPPER(lp.nombre) as lugar_prospeccion, UPPER(pv.nombre) as plaza_venta,
        UPPER(nac.nombre) as nacionalidad
        FROM prospectos p
        LEFT JOIN opcs_x_cats lp ON lp.id_opcion=p.lugar_prospeccion AND lp.id_catalogo = 9
        LEFT JOIN opcs_x_cats pv ON pv.id_opcion=p.plaza_venta AND pv.id_catalogo = 5
        LEFT JOIN opcs_x_cats nac ON nac.id_opcion=p.nacionalidad AND nac.id_catalogo = 11
        WHERE p.estatus = 1 AND id_asesor = $id_asesor AND p.lugar_prospeccion != 6");
        return $query->result();
    }
    public function getProspectInfoById($id_prospecto)
    {
        $query = $this->db->query("SELECT * FROM prospectos WHERE  id_prospecto=" . $id_prospecto);
        return $query->result();
    }
    public function update_client_from_prospect($id_cliente, $data_update)
    {
        $this->db->where("id_cliente", $id_cliente);
        $this->db->update('clientes', $data_update);
        return $this->db->affected_rows();
    }
    function getinfoReferencias($id_cliente)
    {
        return $this->db->query("SELECT rf.nombre, rf.telefono, oc.nombre as parentezco FROM referencias rf 
                                INNER JOIN opcs_x_cats oc ON oc.id_opcion = rf.parentesco WHERE oc.id_catalogo = 26 AND rf.id_cliente = " . $id_cliente . "");
    }
    function getProspectingPlaces()
    {
        return $this->db->query("SELECT id_opcion, nombre FROM opcs_x_cats WHERE id_catalogo = 9 AND estatus = 1 ORDER BY nombre");
    }
    function getNationality()
    {
        return $this->db->query("SELECT id_opcion, nombre FROM opcs_x_cats WHERE id_catalogo = 11 AND estatus = 1 ORDER BY nombre");
    }
    function getLegalPersonality()
    {
        return $this->db->query("SELECT id_opcion, nombre FROM opcs_x_cats WHERE id_catalogo = 10 AND estatus = 1 ORDER BY nombre");
    }
    function getAdvertising()
    {
        return $this->db->query("SELECT id_opcion, nombre FROM opcs_x_cats WHERE id_catalogo = 7 AND estatus = 1 ORDER BY nombre");
    }
    function getSalesPlaza()
    {
        return $this->db->query("SELECT id_opcion, nombre FROM opcs_x_cats WHERE id_catalogo = 5 AND estatus = 1 ORDER BY nombre");
    }
    function getCivilStatus()
    {
        return $this->db->query("SELECT id_opcion, nombre FROM opcs_x_cats WHERE id_catalogo = 18 AND estatus = 1 ORDER BY nombre");
    }
    function getMatrimonialRegime()
    {
        return $this->db->query("SELECT id_opcion, nombre FROM opcs_x_cats WHERE id_catalogo = 19 AND estatus = 1 ORDER BY nombre");
    }
    function getFiscalRegime()
    {
        return $this->db->query("SELECT id_opcion, nombre FROM opcs_x_cats WHERE id_catalogo = 92 AND estatus = 1 ORDER BY nombre");
    }
    function getState()
    {
        return $this->db->query("SELECT id_estado, nombre FROM estados ORDER BY nombre");
    }
    function getParentesco()
    {
        return $this->db->query("SELECT id_opcion, nombre FROM opcs_x_cats WHERE id_catalogo = 26 AND estatus = 1 ORDER BY nombre");
    }
    function get_proyecto_lista()
    {
        return $this->db->query("SELECT * FROM residenciales WHERE status = 1");
    }
    function get_condominio_lista($proyecto)
    {
        return $this->db->query("SELECT * FROM condominios WHERE status = 1 AND idResidencial = " . $proyecto . "");
    }
    function get_lote_lista($condominio)
    {
        return $this->db->query("SELECT * FROM lotes WHERE status = 1 AND idCondominio = " . $condominio . " AND idCliente in (SELECT idCliente FROM clientes) AND (idCliente <> 0 AND idCliente <>'') ");
    }
    function get_datos_tipo()
    {
        return $this->db->query("SELECT * FROM opciones_catalogo WHERE estatus = 1 AND id_catalogo = 2");
    }
    public function getLotesInfoCorrida($lote)
    {
        if ($this->session->userdata('id_rol') == 6) {
            $query = $this->db->query("SELECT lot.idLote, nombreLote, total, sup, precio, porcentaje, enganche, lot.msi as msni, 
            descSup1, descSup2, referencia, db.banco, db.cuenta, db.empresa, db.clabe, lot.casa, (
            CASE lot.casa
            WHEN 0 THEN ''
            WHEN 1 THEN  casas.casasDetail
            END) casasDetail, idStatusLote, cl.fechaApartado, cl.id_cliente
            FROM lotes lot LEFT JOIN condominios con ON lot.idCondominio = con.idCondominio LEFT JOIN residenciales res 
            ON con.idResidencial = res.idResidencial LEFT JOIN datosbancarios db ON con.idDBanco = db.idDBanco 
            LEFT JOIN (SELECT id_lote, CONCAT( '{''total_terreno'':''', total_terreno, ''',', tipo_casa, '}') casasDetail 
            FROM casas WHERE estatus = 1) casas ON casas.id_lote = lot.idLote
            LEFT JOIN clientes cl ON lot.idLote = cl.idLote AND cl.status=1
            WHERE lot.idLote = " . $lote . " AND idStatusLote IN(1,3)");
        } 
        else {
            $query = $this->db->query("SELECT lot.idLote, nombreLote, total, sup, precio, porcentaje, enganche, lot.msi as msni, 
            descSup1, descSup2, referencia, db.banco, db.cuenta, db.empresa, db.clabe, lot.casa, (
            CASE lot.casa
            WHEN 0 THEN ''
            WHEN 1 THEN  casas.casasDetail
            END) casasDetail, idStatusLote, cl.fechaApartado, cl.id_cliente, lot.idStatusContratacion, lot.idMovimiento
            FROM lotes lot LEFT JOIN condominios con ON lot.idCondominio = con.idCondominio LEFT JOIN residenciales res 
            ON con.idResidencial = res.idResidencial LEFT JOIN datosbancarios db ON con.idDBanco = db.idDBanco 
            LEFT JOIN (SELECT id_lote, CONCAT( '{''total_terreno'':''', total_terreno, ''',', tipo_casa, '}') casasDetail 
            FROM casas WHERE estatus = 1) casas ON casas.id_lote = lot.idLote
            LEFT JOIN clientes cl ON lot.idLote = cl.idLote AND cl.status=1
            WHERE lot.idLote = " . $lote . " AND idStatusLote IN(1, 2, 3)") ; /*1: original*/
        }
        if ($query) {
            $query = $query->result_array();
            return $query;
        }
    }
    function getLotesInfoCorridaE($lote){
        if($this->session->userdata('id_rol') == 6){
            $query =  $this->db->query("SELECT lot.idLote, nombreLote, total, sup, precio, porcentaje, enganche, con.msni, descSup1, descSup2, referencia, db.banco, db.cuenta, db.empresa, db.clabe, lot.casa, (
            CASE lot.casa
            WHEN 0 THEN ''
            WHEN 1 THEN  casas.casasDetail
            END) casasDetail, idStatusLote, cl.fechaApartado, cl.id_cliente
            FROM lotes lot LEFT JOIN condominios con ON lot.idCondominio = con.idCondominio LEFT JOIN residenciales res 
            ON con.idResidencial = res.idResidencial LEFT JOIN datosbancarios db ON con.idDBanco = db.idDBanco 
            LEFT JOIN (SELECT id_lote, CONCAT( '{''total_terreno'':''', total_terreno, ''',', tipo_casa, '}') casasDetail 
            FROM casas WHERE estatus = 1) casas ON casas.id_lote = lot.idLote
            LEFT JOIN clientes cl ON lot.idLote = cl.idLote AND cl.status=1
            WHERE lot.idLote = " . $lote . " AND idStatusLote IN(1,3)");
        } else {
            $query =  $this->db->query("SELECT lot.idLote, nombreLote, total, sup, precio, porcentaje, enganche, con.msni, descSup1, descSup2, referencia, db.banco, db.cuenta, db.empresa, db.clabe, lot.casa, (
            CASE lot.casa
            WHEN 0 THEN ''
            WHEN 1 THEN  casas.casasDetail
            END) casasDetail, idStatusLote, cl.fechaApartado, cl.id_cliente, lot.idStatusContratacion, lot.idMovimiento
            FROM lotes lot LEFT JOIN condominios con ON lot.idCondominio = con.idCondominio LEFT JOIN residenciales res 
            ON con.idResidencial = res.idResidencial LEFT JOIN datosbancarios db ON con.idDBanco = db.idDBanco 
            LEFT JOIN (SELECT id_lote, CONCAT( '{''total_terreno'':''', total_terreno, ''',', tipo_casa, '}') casasDetail 
            FROM casas WHERE estatus = 1) casas ON casas.id_lote = lot.idLote
            LEFT JOIN clientes cl ON lot.idLote = cl.idLote AND cl.status=1
            WHERE lot.idLote = " . $lote . " AND idStatusLote IN(1, 2, 3)"); /*original: 1*/
        }
        if($query){
            $query = $query->result_array();
            return $query;
        }
    }
    public function registroCliente()
    {
        $this->db->select("cl.id_cliente, id_asesor, id_coordinador, id_gerente, cl.id_sede, cl.nombre, cl.apellido_paterno, 
        cl.apellido_materno ,personalidad_juridica ,cl.nacionalidad ,cl.rfc ,curp ,cl.correo ,telefono1
        ,telefono2 ,telefono3 ,fecha_nacimiento ,lugar_prospeccion ,medio_publicitario ,otro_lugar ,plaza_venta ,
        tp.tipo ,estado_civil ,regimen_matrimonial ,nombre_conyuge ,tipo_vivienda ,ocupacion ,cl.empresa ,
        puesto ,edadFirma ,antiguedad ,domicilio_empresa ,telefono_empresa ,noRecibo,engancheCliente ,
        concepto ,fechaEnganche ,cl.idTipoPago ,expediente ,cl.status ,cl.idLote ,fechaApartado ,convert(varchar,fechaVencimiento,20) as fechaVencimiento, 
        cl.usuario, cond.idCondominio, cl.fecha_creacion, cl.creado_por, cl.fecha_modificacion, cl.modificado_por, 
        cond.nombre as nombreCondominio, residencial.nombreResidencial as nombreResidencial, cl.status, 
        nombreLote,(SELECT CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)) AS asesor, 
        (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_gerente=id_usuario ) AS gerente ,
        (SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) FROM usuarios WHERE cl.id_coordinador=id_usuario) AS coordinador");
        $this->db->join('usuarios as us', 'cl.id_asesor=us.id_usuario', 'LEFT');
        $this->db->join('lotes as lotes', 'lotes.idLote=cl.idLote', 'LEFT');
        $this->db->join('condominios as cond', 'lotes.idCondominio=cond.idCondominio', 'LEFT');
        $this->db->join('residenciales as residencial', 'cond.idResidencial=residencial.idResidencial', 'LEFT');
        $this->db->join('referencias as ref', 'ref.id_cliente=cl.id_cliente', 'LEFT');
        $this->db->join('tipopago as tp', 'cl.idTipoPago=tp.idTipoPago', 'LEFT');
        $query = $this->db->get('clientes as cl');
        $query = $this->db->get('ventas_compartidas vc');
        return $query->result();
    }
    public function selectDS($cliente)
    {
        $query = $this->db->query("SELECT cl.correo, cl.nombre, cl.apellido_paterno, cl.domicilio_particular, cl.apellido_materno, cl.rfc, cl.personalidad_juridica, cl.fecha_nacimiento, cl.telefono_empresa, cl.tipo_vivienda, cl.telefono1, cl.telefono2, cl.telefono3, cl.correo, lot.idLote, lot.nombreLote, lot.sup, FORMAT(TRY_CAST(lot.precio AS float),'C') as precio, res.nombreResidencial, con.nombre as nombreCondominio, con.idCondominio, ds.id as idDeposito, ds.clave, res.idResidencial as desarrollo, con.tipo_lote as tipoLote, ds.idOficial_pf, ds.idDomicilio_pf, ds.actaConstitutiva_pm, ds.idOficialApoderado_pm, ds.poder_pm, ds.actaMatrimonio_pf, ds.idDomicilio_pm, cl.nombre_conyuge, cl.nacionalidad, cl.originario_de as originario, cl.estado_civil, cl.regimen_matrimonial, cl.ocupacion, cl.empresa, cl.puesto, cl.antiguedad, cl.edadFirma, cl.domicilio_empresa, ds.noRefPago, FORMAT(TRY_CAST(ds.costoM2 AS float),'C') as costoM2, ds.proyecto, ds.municipio as municipioDS, FORMAT(TRY_CAST(ds.importOferta AS float),'C') as importOferta, ds.letraImport, FORMAT(TRY_CAST( ds.cantidad AS float),'C') as cantidad, ds.letraCantidad, FORMAT(TRY_CAST(ds.saldoDeposito AS float),'C') AS saldoDeposito, FORMAT(TRY_CAST(REPLACE(ds.aportMensualOfer, ',', '') AS decimal(16,2)),'C') AS aportMensualOfer, ds.fecha1erAport, ds.plazo, ds.fechaLiquidaDepo, ds.fecha2daAport,ds.municipio2, ds.dia, ds.mes, ds.anio, ds.observacion, ds.nombreFirmaAsesor, ds.fechaCrate, ds.id_cliente, lot.referencia, FORMAT(TRY_CAST(ds.costom2f AS float),'C') as costom2f, cl.lugar_prospeccion, ds.fecha_modificacion, ds.costoM2_casas, cl.descuento_mdb, tipo_nc, printPagare, tipo_comprobanteD, cl.regimen_fac, cl.cp_fac FROM clientes cl INNER JOIN lotes lot ON cl.idLote = lot.idLote INNER JOIN condominios con ON con.idCondominio = lot.idCondominio INNER JOIN residenciales res ON res.idResidencial = con.idResidencial INNER JOIN deposito_seriedad ds ON ds.id_cliente = cl.id_cliente WHERE cl.id_cliente = " . $cliente . "");
        return $query->result();
    }
    public function selectDSCopropiedad($cliente)
    {
        $query =  $this->db->query("SELECT id_copropietario, id_cliente, regimen_matrimonial as regimen_valor, estado_civil as estado_valor, 
                                    co.nacionalidad as nacionalidad_valor, co.nombre as 
                                    nombre_cop, apellido_paterno, apellido_materno, telefono, telefono_2, correo, fecha_nacimiento, 
                                    originario_de, conyuge, domicilio_particular, 
                                    ocupacion, empresa, posicion,  antiguedad, edadFirma, direccion, tipo_vivienda, rfc
                                    FROM copropietarios co 
                                    WHERE co.estatus = 1 AND co.id_cliente =" . $cliente);
        return $query->result();
    }
    public function selectDSCopropiedadCount($cliente)
    {
        $query = $this->db->query("SELECT count(*) as valor_propietarios FROM copropietarios co 
                                WHERE co.estatus = 1 AND co.id_cliente = " . $cliente);
        return $query->result();
    }
    public function selectDSR($cliente)
    {
        $query = $this->db->query("SELECT * FROM referencias WHERE id_cliente = '" . $cliente . "'");
        return $query->result();
    }
    public function selectDSAsesor($cliente)
    {
        $query = $this->db->query("
            SELECT asesor.id_usuario, CONCAT(asesor.nombre,' ',asesor.apellido_paterno,' ',asesor.apellido_materno) AS nombreAsesor, 
            CONCAT(coordinador.nombre,' ',coordinador.apellido_paterno,' ',coordinador.apellido_materno) AS nombreCoordinador,
            CONCAT(gerente.nombre,' ',gerente.apellido_paterno,' ',gerente.apellido_materno) AS nombreGerente,
            asesor.id_lider, gerente.id_usuario, asesor.correo
            FROM clientes cl 
            LEFT JOIN usuarios asesor ON cl.id_asesor = asesor.id_usuario
            LEFT JOIN usuarios coordinador ON cl.id_coordinador = coordinador.id_usuario
            LEFT JOIN usuarios gerente ON cl.id_gerente = gerente.id_usuario WHERE cl.id_cliente= " . $cliente . "");
        return $query->result();
    }
    public function selectDSAsesor1($cliente){
        return $query = $this->db->query("
        SELECT asesor.id_usuario, CONCAT(asesor.nombre,' ',asesor.apellido_paterno,' ',asesor.apellido_materno) AS nombreAsesor, 
        CONCAT(coordinador.nombre,' ',coordinador.apellido_paterno,' ',coordinador.apellido_materno) AS nombreCoordinador,
        CONCAT(gerente.nombre,' ',gerente.apellido_paterno,' ',gerente.apellido_materno) AS nombreGerente,
        asesor.id_lider, gerente.id_usuario, asesor.correo
        FROM clientes cl 
        LEFT JOIN usuarios asesor ON cl.id_asesor = asesor.id_usuario
        LEFT JOIN usuarios coordinador ON cl.id_coordinador = coordinador.id_usuario
        LEFT JOIN usuarios gerente ON cl.id_gerente = gerente.id_usuario WHERE cl.id_cliente= ".$cliente."");
    }
    public function selectDSAsesorCompartido($cliente)
    {
        $query = $this->db->query("SELECT vc.id_asesor, 
            CONCAT(asesor.nombre,' ',asesor.apellido_paterno,' ',asesor.apellido_materno) AS nombreAsesor, asesor.id_lider, gerente.id_usuario, 
            CONCAT(gerente.nombre,' ',gerente.apellido_paterno,' ',gerente.apellido_materno) AS  nombreGerente ,
            CONCAT(coordinador.nombre,' ',coordinador.apellido_paterno,' ',coordinador.apellido_materno) AS  nombreCoordinador 
            FROM clientes cl 
            LEFT JOIN ventas_compartidas vc ON vc.id_cliente = cl.id_cliente  
            LEFT JOIN usuarios asesor ON asesor.id_usuario = vc.id_asesor 
            LEFT JOIN usuarios gerente ON gerente.id_usuario = vc.id_gerente 
            LEFT JOIN usuarios coordinador ON vc.id_coordinador = coordinador.id_usuario 
            WHERE cl.id_cliente = " . $cliente . " AND vc.estatus=1");
        return $query->result();
    }
    public function selectDSAsesorCompartido1($cliente)
    {
        return $query = $this->db->query("SELECT vc.id_asesor, 
            CONCAT(asesor.nombre,' ',asesor.apellido_paterno,' ',asesor.apellido_materno) AS nombreAsesor, asesor.id_lider, gerente.id_usuario, 
            CONCAT(gerente.nombre,' ',gerente.apellido_paterno,' ',gerente.apellido_materno) AS  nombreGerente ,
            CONCAT(coordinador.nombre,' ',coordinador.apellido_paterno,' ',coordinador.apellido_materno) AS  nombreCoordinador 
            FROM clientes cl 
            LEFT JOIN ventas_compartidas vc ON vc.id_cliente = cl.id_cliente  
            LEFT JOIN usuarios asesor ON asesor.id_usuario = vc.id_asesor 
            LEFT JOIN usuarios gerente ON gerente.id_usuario = vc.id_gerente 
            LEFT JOIN usuarios coordinador ON vc.id_coordinador = coordinador.id_usuario 
            WHERE cl.id_cliente = " . $cliente . " AND vc.estatus=1");
    }
    public function selectDSA($cliente)
    {
        $query = $this->db->query("SELECT cl.correo, cl.nombre, cl.apellido_paterno, cl.apellido_materno, cl.rfc, cl.personalidad_juridica, cl.fecha_nacimiento, cl.telefono_empresa, cl.tipo_vivienda, 
                                    cl.telefono1, cl.telefono2, cl.telefono3, cl.correo, lot.idLote, lot.nombreLote, lot.sup, lot.precio, res.nombreResidencial, con.nombre as nombreCondominio, 
                                    oc3.nombre as regimen_valor, con.idCondominio, ds.id as idDeposito, ds.clave, ds.desarrollo, ds.tipoLote, ds.idOficial_pf, ds.idDomicilio_pf, ds.actaConstitutiva_pm, ds.idOficialApoderado_pm, 
                                    ds.poder_pm, ds.actaMatrimonio_pf, ds.idDomicilio_pm, cl.nombre_conyuge, cl.nacionalidad, cl.originario, cl.estado_civil, cl.regimen_matrimonial, cl.ocupacion, cl.empresa, cl.puesto, 
                                    cl.antiguedad, cl.edadFirma, cl.domicilio_empresa, ds.noRefPago, ds.costoM2, ds.proyecto, ds.municipio as municipioDS, ds.importOferta, ds.letraImport, ds.cantidad, ds.letraCantidad, 
                                    ds.saldoDeposito, aportMensualOfer, ds.fecha1erAport, ds.plazo, ds.fechaLiquidaDepo, ds.fecha2daAport,ds.municipio2, ds.dia, ds.mes, ds.anio, ds.observacion, ds.nombreFirmaAsesor, 
                                    ds.fechaCrate, ds.id_cliente, lot.referencia, ds.costom2f FROM clientes WHERE cl.id_cliente = " . $cliente . "");
        return $query->result();
    }
    public function getInventarioTodosc()
    {
        $query = $this->db->query("SELECT res.idResidencial, res.nombreResidencial,
        CAST(res.descripcion AS NVARCHAR(100)) descripcion , con.nombre as nombreCondominio,
        lot.nombreLote, lot.sup, con.msni as mesesn, lot.precio, lot.total
        FROM residenciales res
        JOIN condominios con ON con.idResidencial = res.idResidencial
        JOIN lotes lot ON lot.idCondominio = con.idCondominio
        WHERE lot.idStatusLote in(1) AND lot.status in(1)
        GROUP BY res.idResidencial, res.nombreResidencial, CAST(res.descripcion AS NVARCHAR(100)),  con.nombre,
        lot.nombreLote, lot.sup, con.msni, lot.precio, lot.total
        ORDER BY res.idResidencial");
        return $query->result();
    }
    public function editaRegistroClienteDS($id_cliente, $arreglo_cliente, $arreglo_ds, $id_referencia1, $arreglo_referencia1, $id_referencia2, $arreglo_referencia2){
        $this->db->where("id_cliente",$id_cliente);
        $this->db->update('clientes',$arreglo_cliente);
        $this->db->where("id_cliente",$id_cliente);
        $this->db->update('deposito_seriedad',$arreglo_ds);
        $this->db->where("id_referencia",$id_referencia1);
        $this->db->update('referencias',$arreglo_referencia1);
        $this->db->where("id_referencia",$id_referencia2);
        $this->db->update('referencias',$arreglo_referencia2);
        return true;
    }
    public function editaRegistroClienteDS_2($id_cliente, $arreglo_cliente, $arreglo_ds)
    {
        $this->db->where("id_cliente",$id_cliente);
        $this->db->update('clientes',$arreglo_cliente);
        $this->db->where("id_cliente",$id_cliente);
        $this->db->update('deposito_seriedad',$arreglo_ds);
        return true;
    }
    public function checkExistRefrencias($id_cliente)
    {
        $query = $this->db->get_where('referencias', array('id_cliente' => $id_cliente));
        return $query->result();
    }
    public function insertnewRef($data)
    {
        $query = $this->db->insert('referencias', $data);
        return true;
    }
    public function getCondominioDesc($residencial)
    {
        $query = $this->db->query("SELECT con.idCondominio, con.nombre, res.idResidencial, res.nombreResidencial, CAST(res.descripcion AS NVARCHAR(100)) descripcion   
            FROM residenciales res
            JOIN condominios con ON con.idResidencial = res.idResidencial
            WHERE con.status in(1) AND con.idResidencial =" . $residencial . " ORDER BY con.nombre");
        return $query->result();
    }
    public function getCondominioDescTodos()
    {
        $query = $this->db->query("SELECT con.idCondominio, con.nombre, res.idResidencial, res.nombreResidencial, CAST(res.descripcion AS NVARCHAR(100)) descripcion
            FROM residenciales res
            JOIN condominios con ON con.idResidencial = res.idResidencial
            WHERE con.status in(1) ORDER BY con.nombre");
        return $query->result();
    }
    public function getSupOne($residencial)
    {
        $query = $this->db->query("SELECT DISTINCT(lot.sup), res.idResidencial, res.nombreResidencial, CAST(res.descripcion AS NVARCHAR(100)) descripcion   
            FROM residenciales res
            JOIN condominios con ON con.idResidencial = res.idResidencial
            JOIN lotes lot ON lot.idCondominio = con.idCondominio
            WHERE lot.idStatusLote in(1) AND lot.status in(1) AND res.idResidencial =" . $residencial . "
            ORDER BY lot.sup ASC");
        return $query->result();
    }
    public function getSupOneTodos()
    {
        $query = $this->db->query("SELECT DISTINCT(lot.sup), res.idResidencial, res.nombreResidencial, CAST(res.descripcion AS NVARCHAR(100)) descripcion
            FROM residenciales res
            JOIN condominios con ON con.idResidencial = res.idResidencial
            JOIN lotes lot ON lot.idCondominio = con.idCondominio
            WHERE lot.idStatusLote in(1) AND lot.status in(1)
            ORDER BY lot.sup ASC");
        return $query->result();
    }
    public function getPrecio($residencial)
    {
        $query = $this->db->query("SELECT DISTINCT(lot.precio), res.idResidencial, res.nombreResidencial, CAST(res.descripcion AS NVARCHAR(100)) descripcion   
            FROM residenciales res
            JOIN condominios con ON con.idResidencial = res.idResidencial
            JOIN lotes lot ON lot.idCondominio = con.idCondominio
            WHERE lot.idStatusLote in(1) AND lot.status in(1) AND res.idResidencial in(" . $residencial . ")
            ORDER BY lot.precio ASC");
        return $query->result();
    }
    public function getPrecioTodos()
    {
        $query = $this->db->query("SELECT DISTINCT(lot.precio), res.idResidencial, res.nombreResidencial, CAST(res.descripcion AS NVARCHAR(100)) descripcion
            FROM residenciales res
            JOIN condominios con ON con.idResidencial = res.idResidencial
            JOIN lotes lot ON lot.idCondominio = con.idCondominio
            WHERE lot.idStatusLote in(1) AND lot.status in(1)
            ORDER BY lot.precio ASC");
        return $query->result();
    }
    public function getTotal($residencial)
    {
        $query = $this->db->query("SELECT DISTINCT(lot.total), res.idResidencial, res.nombreResidencial, CAST(res.descripcion AS NVARCHAR(100)) descripcion   
            FROM residenciales res
            JOIN condominios con ON con.idResidencial = res.idResidencial
            JOIN lotes lot ON lot.idCondominio = con.idCondominio
            WHERE lot.idStatusLote in(1) AND lot.status in(1) AND res.idResidencial in(" . $residencial . ")
            ORDER BY lot.total ASC");
        return $query->result();
    }
    public function getTotalTodos()
    {
        $query = $this->db->query("SELECT DISTINCT(lot.total), res.idResidencial, res.nombreResidencial, CAST(res.descripcion AS NVARCHAR(100)) descripcion
            FROM residenciales res
            JOIN condominios con ON con.idResidencial = res.idResidencial
            JOIN lotes lot ON lot.idCondominio = con.idCondominio
            WHERE lot.idStatusLote in(1) AND lot.status in(1)
            ORDER BY lot.total ASC");
        return $query->result();
    }
    public function getMeses($id, $type)
    {
        //$type 1: residencial
        //$type 2: condominio
        if($type == 1){
            $condicion = "AND res.idResidencial in(" . $id . ")";
        }else if($type == 2){
            $condicion = "AND con.idCondominio in(" . $id . ")";
        }
        $query = $this->db->query("SELECT DISTINCT(lot.msi) as msni
            FROM residenciales res
            JOIN condominios con ON con.idResidencial = res.idResidencial
            JOIN lotes lot ON lot.idCondominio = con.idCondominio
            WHERE lot.idStatusLote in(1) AND lot.status in(1) ".$condicion."
            ORDER BY lot.msi ASC");
        return $query->result();
    }
    public function getMesesTodos()
    {
        $query = $this->db->query("SELECT DISTINCT(lot.msi) as msni
            FROM residenciales res
            JOIN condominios con ON con.idResidencial = res.idResidencial
            JOIN lotes lot ON lot.idCondominio = con.idCondominio
            WHERE lot.idStatusLote in(1) AND lot.status in(1)
            ORDER BY lot.msi ASC");
        return $query->result();
    }
    function getModalidad()
    {
        return $this->db->query("SELECT id_opcion, nombre FROM opcs_x_cats WHERE id_catalogo = 28 AND estatus = 1 ORDER BY nombre");
    }
    function getMediosVenta()
    {
        return $this->db->query("SELECT id_opcion, nombre FROM opcs_x_cats WHERE id_catalogo = 30 AND estatus = 1 ORDER BY nombre");
    }
    function getPlan()
    {
        return $this->db->query("SELECT id_opcion, nombre FROM opcs_x_cats WHERE id_catalogo = 29 AND estatus = 1 ORDER BY nombre");
    }
    public function get_autorizaciones () {
        /*id_autorizacion, autorizaciones.fecha_creacion,autorizaciones.autorizacion,*/
        $query = $this->db->query(
            "SELECT residencial.nombreResidencial, condominio.nombre as nombreCondominio, 
            lotes.nombreLote, MAX(autorizaciones.estatus) as estatus,
            MAX(id_autorizacion) as id_autorizacion,
            CONVERT(varchar, MAX(autorizaciones.fecha_creacion), 20) as fecha_creacion,
            MAX(autorizaciones.autorizacion) as autorizacion, 
            UPPER(CONCAT(users.nombre, ' ', users.apellido_paterno, ' ', users.apellido_materno)) as sol, 
            UPPER(CONCAT(users1.nombre, ' ', users1.apellido_paterno, ' ', users1.apellido_materno)) as aut,  
            autorizaciones.idLote,
            UPPER(CONCAT_WS(' ', cli.nombre, cli.apellido_paterno, cli.apellido_materno)) AS nombreCliente,
            CASE 
                WHEN u1.id_usuario IS NULL THEN
                    'SIN ESPECIFICAR'
                ELSE 
                    UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno))
            END AS coordinador, 
            CASE 
                WHEN u2.id_usuario IS NULL THEN
                    'SIN ESPECIFICAR'
                ELSE 
                    UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno))
            END AS gerente,
            CASE 
                WHEN u3.id_usuario IS NULL THEN
                    'SIN ESPECIFICAR'
                ELSE
                    UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)) 
            END AS subdirector,
            CASE 
                WHEN u4.id_usuario IS NULL THEN
                    'SIN ESPECIFICAR'
                ELSE
                    UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno))
            END AS regional,
            CASE 
                WHEN u5.id_usuario IS NULL THEN
                    'SIN ESPECIFICAR'
                ELSE
                    UPPER(CONCAT(u5.nombre, ' ', u5.apellido_paterno, ' ', u5.apellido_materno))
            END AS regional2
            FROM autorizaciones
            INNER JOIN lotes on lotes.idLote = autorizaciones.idLote 
            INNER JOIN condominios as condominio on condominio.idCondominio = lotes.idCondominio 
            INNER JOIN residenciales as residencial on residencial.idResidencial = condominio.idResidencial
            INNER JOIN usuarios as users on autorizaciones.id_sol = users.id_usuario
            INNER JOIN usuarios as users1 on autorizaciones.id_aut = users1.id_usuario
            INNER JOIN clientes as cli on autorizaciones.idCliente = cli.id_cliente
            LEFT JOIN usuarios u1 ON u1.id_usuario = cli.id_coordinador
            LEFT JOIN usuarios u2 ON u2.id_usuario = cli.id_gerente
		    LEFT JOIN usuarios u3 ON u3.id_usuario = cli.id_subdirector
		    LEFT JOIN usuarios u4 ON u4.id_usuario = cli.id_regional
            LEFT JOIN usuarios u5 ON u5.id_usuario = cli.id_regional_2
            WHERE autorizaciones.id_sol = " . $this->session->userdata('id_usuario'). "
            GROUP BY residencial.nombreResidencial, condominio.nombre, 
            lotes.nombreLote, 
            UPPER(CONCAT(users.nombre, ' ', users.apellido_paterno, ' ', users.apellido_materno)), 
            UPPER(CONCAT(users1.nombre, ' ', users1.apellido_paterno, ' ', users1.apellido_materno)),
            UPPER(CONCAT_WS(' ', cli.nombre, cli.apellido_paterno, cli.apellido_materno)),
            UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)),
            UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)),
            UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)),
            UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)),
            UPPER(CONCAT(u5.nombre, ' ', u5.apellido_paterno, ' ', u5.apellido_materno)),
            u1.id_usuario,
            u2.id_usuario,
            u3.id_usuario,
            u4.id_usuario,
            u5.id_usuario,
            autorizaciones.idLote");
        return $query->result();
    }
    public function get_sol_aut()
    {
        if( $this->session->userdata('id_rol') == 6 ){
            $filterByRol =  'AND cliente.id_gerente = '. $this->session->userdata('id_lider');
            $filterInner = 'INNER JOIN usuarios us ON us.id_usuario = cliente.id_asesor AND us.estatus IN (0,3)';
        }
        else{
            $filterByRol = 'AND cliente.id_asesor = ' . $this->session->userdata('id_usuario');
            $filterInner = '';
        }
        $query = $this->db->query(
            "SELECT cliente.id_cliente, 
            nombreLote, cliente.rfc, nombreResidencial, condominio.nombre as nombreCondominio, 
            cliente.status, cliente.id_asesor, condominio.idCondominio, lotes.idLote, 
            cliente.autorizacion,
            CONVERT(varchar, cliente.fechaApartado, 20) as fechaApartado,
            lotes.idStatusContratacion, lotes.idMovimiento,
            UPPER(CONCAT(cliente.nombre,' ',cliente.apellido_paterno, ' ',cliente.apellido_materno)) AS nombreCliente,
            CASE 
                WHEN u1.id_usuario IS NULL THEN
                    'SIN ESPECIFICAR'
                ELSE 
                    UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno))
            END AS coordinador, 
            CASE 
                WHEN u2.id_usuario IS NULL THEN
                    'SIN ESPECIFICAR'
                ELSE 
                    UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno))
            END AS gerente,
            CASE 
                WHEN u3.id_usuario IS NULL THEN
                    'SIN ESPECIFICAR'
                ELSE
                    UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)) 
            END AS subdirector,
            CASE 
                WHEN u4.id_usuario IS NULL THEN
                    'SIN ESPECIFICAR'
                ELSE
                    UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno))
            END AS regional,
            CASE 
                WHEN u5.id_usuario IS NULL THEN
                    'SIN ESPECIFICAR'
                ELSE
                    UPPER(CONCAT(u5.nombre, ' ', u5.apellido_paterno, ' ', u5.apellido_materno))
            END AS regional2
            FROM clientes as cliente
            INNER JOIN lotes ON cliente.idLote = lotes.idLote
            INNER JOIN condominios as condominio ON lotes.idCondominio = condominio.idCondominio
            INNER JOIN residenciales as residencial ON condominio.idResidencial = residencial.idResidencial
            INNER JOIN deposito_seriedad ON deposito_seriedad.id_cliente = cliente.id_cliente
            LEFT JOIN usuarios u1 ON u1.id_usuario = cliente.id_coordinador
            LEFT JOIN usuarios u2 ON u2.id_usuario = cliente.id_gerente
		    LEFT JOIN usuarios u3 ON u3.id_usuario = cliente.id_subdirector
		    LEFT JOIN usuarios u4 ON u4.id_usuario = cliente.id_regional
            LEFT JOIN usuarios u5 ON u5.id_usuario = cliente.id_regional_2
            $filterInner
            WHERE cliente.status = 1 $filterByRol
            GROUP BY lotes.idLote,
            cliente.id_cliente, nombreLote, cliente.rfc, nombreResidencial, condominio.nombre, 
            cliente.status, cliente.id_asesor, condominio.idCondominio, lotes.idLote, 
            cliente.autorizacion, cliente.fechaApartado, lotes.idStatusContratacion, lotes.idMovimiento,
            UPPER(CONCAT(cliente.nombre,' ',cliente.apellido_paterno, ' ',cliente.apellido_materno)),
            UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)), 
            UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)),
            UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)), 
            UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)),
            UPPER(CONCAT(u5.nombre, ' ', u5.apellido_paterno, ' ', u5.apellido_materno)),
            u1.id_usuario,
            u2.id_usuario,
            u3.id_usuario,
            u4.id_usuario,
            u5.id_usuario
            ORDER BY cliente.fechaApartado DESC");
        return $query->result_array();
    }
    public function insertAutorizacion($data)
    {
        return $this->db->insert('autorizaciones', $data);
    }
    public function registroClienteDS($id_condominio) {
        ini_set('max_execution_time', 300);
        set_time_limit(300);
        $id_asesor = $this->session->userdata('id_usuario');
        if ($id_condominio != 0 && $id_asesor == 9651)
            $where = "AND cond.idCondominio = $id_condominio";
        else
            $where = "";
		$query = $this->db-> query("SELECT cl.id_cliente, id_asesor, id_coordinador, id_gerente, cl.id_sede, cl.nombre, cl.apellido_paterno, 
        cl.apellido_materno, cl.status ,cl.idLote, fechaApartado ,fechaVencimiento , cl.usuario, cond.idCondominio, cl.fecha_creacion, 
        cl.creado_por, cl.fecha_modificacion, cl.modificado_por, cond.nombre as nombreCondominio, residencial.nombreResidencial as nombreResidencial,
        cl.status, nombreLote, lotes.comentario, lotes.idMovimiento, convert(varchar,lotes.fechaVenc,20) as fechaVenc, lotes.modificado, 1 estatus
        FROM clientes AS cl			
        INNER JOIN usuarios AS us ON cl.id_asesor = us.id_usuario
        INNER JOIN lotes AS lotes ON lotes.idLote = cl.idLote AND lotes.idCliente = cl.id_cliente AND lotes.idStatusLote = 3
        INNER JOIN condominios AS cond ON lotes.idCondominio = cond.idCondominio $where
        INNER JOIN residenciales AS residencial ON cond.idResidencial=residencial.idResidencial
        LEFT JOIN deposito_seriedad AS ds ON ds.id_cliente = cl.id_cliente	
        WHERE cl.id_coordinador NOT IN (2562, 2541) AND cl.id_asesor = $id_asesor
        AND idStatusContratacion IN (1, 2, 3) AND idMovimiento IN (31, 85, 20, 63, 73, 82, 92, 96, 99, 102, 104, 107, 108, 109, 111) AND 
        cl.status = 1 ORDER BY cl.id_cliente ASC");
		return $query->result_array();
	}
    public function validateSt2($idLote) {
        $this->db->where("idLote", $idLote);
        $this->db->where_in('idStatusLote', 3);
        $this->db->where("(idStatusContratacion IN (1, 2, 3) AND idMovimiento IN (31, 85, 20, 63, 73, 82, 92, 96, 102, 104, 107, 108, 109, 111))");
        $query = $this->db->get('lotes');
        $valida = (empty($query->result())) ? 0 : 1;
        return $valida;
    }
    public function updateSt($idLote, $arreglo, $arreglo2)
    {
        $this->db->trans_begin();
        $this->db->where("idLote", $idLote);
        $this->db->update('lotes', $arreglo);
        $this->db->insert('historial_lotes', $arreglo2);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }
    function getInfoUserById($id_usuario)
    {
        $this->db->select("*");
        $this->db->where('id_usuario', $id_usuario);
        $this->db->where('estatus', 1);
        $query = $this->db->get('usuarios');
        return $query->result();
    }
    public function get_auts_by_lote($idLote)
    {
        $query = $this->db->query(
            'SELECT residencial.nombreResidencial, condominio.nombre as nombreCondominio, 
            lotes.nombreLote, autorizaciones.estatus, autorizaciones.autorizacion,
            CONVERT(VARCHAR,autorizaciones.fecha_creacion,20) AS fecha_creacion, users.usuario as sol, 
            users1.usuario as aut, id_autorizacion, autorizaciones.idLote
		    FROM autorizaciones 
            INNER JOIN lotes on lotes.idLote = autorizaciones.idLote 
            INNER JOIN condominios as condominio on condominio.idCondominio = lotes.idCondominio 
            INNER JOIN residenciales as residencial on residencial.idResidencial = condominio.idResidencial
            INNER JOIN usuarios as users on autorizaciones.id_sol = users.id_usuario
            INNER JOIN usuarios as users1 on autorizaciones.id_aut = users1.id_usuario
            INNER JOIN clientes as cl on cl.id_cliente = autorizaciones.idCliente
            WHERE cl.status = 1 AND autorizaciones.id_sol = ' . $this->session->userdata('id_usuario') . ' AND lotes.idLote=' . $idLote);
        return $query->result_array();
    }
    function getAllFoldersPDF()
    {
        $this->db->select("*");
        $this->db->where('estatus', 1);
        $query = $this->db->get('archivos_carpetas');
        return $query->result();
    }
    public function saveCarpeta($data)
    {
        $query = $this->db->insert('archivos_carpetas', $data);
        if (!$query) {
            return 0;
        } else {
            return 1;
        }
    }
    function updateCarpeta($data, $id_carpeta)
    {
        $response = $this->db->update("archivos_carpetas", $data, "id_archivo = $id_carpeta");
        if (!$response) {
            return 0;
        } else {
            return 1;
        }
    }
    public function getCarpetas()
    {
        return $this->db->query("SELECT id_archivo, nombre, UPPER(descripcion) AS descripcion, UPPER(archivo) AS archivo, estatus, usuario, CONVERT(VARCHAR,fecha_creacion,120) AS fecha_creacion, CONVERT(VARCHAR,fecha_modificacion,120) AS fecha_modificacion FROM archivos_carpetas");
    }
    function getInfoCarpeta($id_carpeta)
    {
        $query = $this->db->query("SELECT * FROM archivos_carpetas WHERE id_archivo = " . $id_carpeta . "");
        return $query->result_array();
    }
    function getAllFoldersManual()
    {
        $this->db->select("*");
        $this->db->where('estatus', 1);
        $query = $this->db->get('archivos_manuales');
        return $query->result();
    }
//nueva funcion para tabla inventario disponible
    public function get_info_tabla($datos)
    {
        for ($x = 0; $x < count($datos); $x++) {
            if (isset($datos[$x]['filtro3'])) {
                $datos[$x]['res.idResidencial'] = $datos[$x]['filtro3'];
                unset($datos[$x]['filtro3']);
            }
            if (isset($datos[$x]['filtro4'])) {
                $datos[$x]['co.idCondominio'] = $datos[$x]['filtro4'];
                unset($datos[$x]['filtro4']);
            }
            if (isset($datos[$x]['filtro5'])) {
                $datos[$x]['lo.sup2'] = $datos[$x]['filtro5'];
                unset($datos[$x]['filtro5']);
            }
            if (isset($datos[$x]['filtro6'])) {
                $datos[$x]['lo.sup'] = $datos[$x]['filtro6'];
                unset($datos[$x]['filtro6']);
            }
            if (isset($datos[$x]['filtro7'])) {
                $datos[$x]['lo.precio'] = $datos[$x]['filtro7'];
                unset($datos[$x]['filtro7']);
            }
            if (isset($datos[$x]['filtro8'])) {
                $datos[$x]['lo.total'] = $datos[$x]['filtro8'];
                unset($datos[$x]['filtro8']);
            }
            if (isset($datos[$x]['filtro9'])) {
                $datos[$x]['lo.msi'] = $datos[$x]['filtro9'];
                unset($datos[$x]['filtro9']);
            }
        }
        $where = 'lo.idStatusLote in(1) AND lo.status in(1)';
        for ($y = 0; $y < count($datos); $y++) {
            $implode = implode('', array_keys($datos[$y]));
            if ($implode == 'res.idResidencial') {
                if ($datos[$y][$implode] != 0) {
                    $where .= ' AND ' . $implode . " ='" . $datos[$y][$implode] . "'";
                    ($y + 1 < count($datos)) ? $where .= " " : $where .= ";";
                }
            } elseif ($implode == 'lo.sup2') {
                if ($datos[$y][$implode] == 1) {
                    $where .= ' AND ' . '(lo.sup < 200)';
                } elseif ($datos[$y][$implode] == 2) {
                    $where .= ' AND ' . '(lo.sup >= 200 AND lo.sup <300)';
                } else {
                    $where .= ' AND ' . '(lo.sup >= 300)';
                }
                ($y + 1 < count($datos)) ? $where .= " " : $where .= ";";
            } else {
                $where .= ' AND ' . $implode . " IN (";
                for ($w = 0; $w < count($datos[$y][$implode]); $w++) {
                    $where .= "'" . $datos[$y][$implode][$w] . "'";
                    ($w + 1 < count($datos[$y][$implode])) ? $where .= ", " : $where .= "";
                }
                ($y + 1 < count($datos)) ? $where .= ") " : $where .= ");";
            }
        }
        $query = $this->db->query("SELECT res.idResidencial, res.nombreResidencial, CAST(res.descripcion AS NVARCHAR(100)) descripcion,
	co.nombre as nombreCondominio, lo.nombreLote, lo.sup, lo.msi as mesesn,
	precio, total, porcentaje, enganche, saldo, lo.tipo_venta, lo.idLote
	FROM residenciales res
	JOIN condominios co ON co.idResidencial = res.idResidencial
	JOIN lotes lo ON lo.idCondominio = co.idCondominio
	WHERE $where");
        return $query->result_array();
    }
    /**nuevos modelos al 090421**/
    public function getClientsByMKTDG()
    {
        $current_id = $this->session->userdata('id_usuario');
        $condicion = '';
        if ($current_id == 1981 || $current_id == 2042) { /*Yoss y Marisela*/
            $condicion = "AND asesor.id_sede IN ('2', '3', '4', '6')";
        } elseif ($current_id == 1988 || $current_id == 5363) { /*Fernanda y Paulina*/
            $condicion = "AND asesor.id_sede IN ('1', '5', '8', '9')";
        }
        $query = $this->db->query("SELECT CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno) as nombreCliente, l.nombreLote, CONVERT(VARCHAR,cl.fechaApartado,20) AS fechaApartado,
                CONCAT(asesor.nombre,' ',asesor.apellido_paterno,' ', asesor.apellido_materno) as nombreAsesor, cl.id_cliente, l.idLote, cl.telefono1,
                ec.id_evidencia, '1' rowType, s.nombre sedeAsesor, ISNULL(oxc.nombre, 'Sin especificar') lugarProspeccion FROM lotes l
                INNER JOIN clientes cl ON l.idLote = cl.idLote
                INNER JOIN usuarios asesor ON cl.id_asesor = asesor.id_usuario $condicion
                INNER JOIN prospectos p ON p.id_prospecto = cl.id_prospecto AND p.fecha_creacion <= '2022-01-20 00:00:00.000'
                LEFT JOIN evidencia_cliente ec ON ec.idCliente = cl.id_cliente 
                INNER JOIN sedes s ON s.id_sede = asesor.id_sede
                LEFT JOIN comentariosMktd cm ON cm.idLote = l.idLote AND cm.id_cliente=cl.id_cliente AND cm.bandera_estatus = 1
                LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = cl.lugar_prospeccion AND oxc.id_catalogo = 9
                WHERE cl.fecha_creacion > '2020-12-31 11:59:00' AND cl.lugar_prospeccion IN (6, 29) AND cl.status = 1 AND l.status = 1 
                AND ec.id_evidencia IS NULL AND cm.id_coment IS NULL 
                AND l.idLote NOT IN (48729, 12735, 49644, 26655, 49957, 50079, 51495, 50891, 52093, 51289, 53164, 53165, 53980, 26120, 55593, 55621, 56495, 56893, 57072, 52398, 59767, 59349, 59866, 60002, 60015, 55241, 56209, 57122, 44767, 44768, 11290, 63250, 27235, 66821, 59650, 63526)
                UNION ALL
                SELECT CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno) as nombreCliente, l.nombreLote, CONVERT(VARCHAR,cl.fechaApartado,20) AS fechaApartado,
                CONCAT(asesor.nombre,' ',asesor.apellido_paterno,' ', asesor.apellido_materno) as nombreAsesor, cl.id_cliente, l.idLote, cl.telefono1,
                ec.id_evidencia, (CASE cn.tipo WHEN 1 THEN 11 WHEN 2 THEN 22 WHEN 3 THEN 33 WHEN 4 THEN 44 WHEN 5 THEN 55 END) rowType, s.nombre sedeAsesor, 
                ISNULL(oxc.nombre, 'Sin especificar') lugarProspeccion FROM lotes l
                INNER JOIN clientes cl ON l.idLote = cl.idLote AND cl.status = 1
                INNER JOIN usuarios asesor ON cl.id_asesor = asesor.id_usuario $condicion
				INNER JOIN controversias cn ON cn.id_lote = l.idLote AND cn.estatus = 1
                LEFT JOIN evidencia_cliente ec ON ec.idCliente = cl.id_cliente 
                INNER JOIN sedes s ON s.id_sede = asesor.id_sede
                LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = cl.lugar_prospeccion AND oxc.id_catalogo = 9
                LEFT JOIN comentariosMktd cm ON cm.idLote = l.idLote AND cm.id_cliente=cl.id_cliente AND cm.bandera_estatus = 1
                WHERE l.status = 1 AND ec.id_evidencia IS NULL AND cm.id_coment IS NULL
                -- AND l.idLote NOT IN (48729, 12735, 49644, 26655, 49957, 50079, 51495, 50891, 52093, 51289, 53164, 53165, 53980, 26120, 55593, 55621, 56495, 56893, 57072, 52398, 59767, 59349, 59866, 60002, 60015, 55241, 56209, 57122, 44767, 44768, 11290, 63250, 27235, 66821, 59650, 63526)  ");
        return $query->result_array();
    }
    public function getEvidenciaGte()
    {
        $id_usuario = $this->session->userdata('id_usuario');
        if ($id_usuario == 2042 || $id_usuario == 1981)
            $where = "AND asesor.id_sede IN ('4', '3', '6', '2')";
        else if ($id_usuario == 5363 || $id_usuario == 1988)
            $where = "AND asesor.id_sede IN ('5', '1', '8', '9')";
        $query = $this->db->query("SELECT CONCAT(cl.nombre,' ', cl.apellido_paterno, ' ', cl.apellido_materno) as cliente,
                l.idLote, l.nombreLote, CONCAT(solicitante.nombre,' ', solicitante.apellido_paterno,' ', solicitante.apellido_materno) as solicitante, ec.estatus,
                ec.id_evidencia, cl.id_cliente, ec.evidencia, ec.fecha_modificado,  cl.fechaApartado, s.nombre plaza,
                CONVERT(VARCHAR,he1.fecha_creacion,20) AS fechaValidacionGerente, CONVERT(VARCHAR,he2.fecha_creacion,20) AS fechaValidacionCobranza, CONVERT(VARCHAR,he3.fecha_creacion,20) AS fechaValidacionContraloria,
                CONVERT(VARCHAR,he10.fecha_creacion,20) AS fechaRechazoCobranza, CONVERT(VARCHAR,he20.fecha_creacion,20) AS fechaRechazoContraloria, he200.comentario_autorizacion, 
                (CASE cn.tipo WHEN 1 THEN 11 WHEN 2 THEN 22 WHEN 3 THEN 33 WHEN 4 THEN 44 WHEN 5 THEN 55 ELSE 1 END) rowType, cn.tipo,
                cm.id_coment, CASE WHEN (ec.comentario_autorizacion LIKE '%null%' OR CAST(ec.comentario_autorizacion AS VARCHAR(500)) = '' OR ec.comentario_autorizacion IS NULL) 
                THEN 'Comentario no especificado' ELSE ec.comentario_autorizacion END lastComment, ISNULL(oxc.nombre, 'Sin especificar') lugarProspeccion
                FROM lotes l
                INNER JOIN clientes cl ON l.idCliente = cl.id_cliente AND cl.lugar_prospeccion IN (6, 29) AND cl.status = 1
                INNER JOIN usuarios asesor ON cl.id_asesor = asesor.id_usuario $where
                LEFT JOIN prospectos p ON p.id_prospecto = cl.id_prospecto AND p.fecha_creacion <= '2022-01-20 00:00:00.000'
                INNER JOIN sedes s ON s.id_sede = asesor.id_sede
                INNER JOIN evidencia_cliente ec ON l.idLote=ec.idLote AND ec.idCliente = cl.id_cliente
                INNER JOIN usuarios solicitante ON solicitante.id_usuario = ec.id_sol
                INNER JOIN opcs_x_cats opxc ON opxc.id_opcion = ec.id_rolAut AND opxc.id_catalogo = 1
                LEFT JOIN controversias cn ON cn.id_lote = l.idLote AND cn.estatus = 1
                LEFT JOIN (SELECT MAX(fecha_creacion) fecha_creacion, id_evidencia, estatus FROM historial_evidencias GROUP BY id_evidencia, estatus) he1 ON he1.id_evidencia = ec.id_evidencia AND he1.estatus = 1 -- GERENTE ENVÍA
                LEFT JOIN (SELECT MAX(fecha_creacion) fecha_creacion, id_evidencia, estatus FROM historial_evidencias GROUP BY id_evidencia, estatus) he2 ON he2.id_evidencia = ec.id_evidencia AND he2.estatus = 2 -- COBRANZA VALIAD OK
                LEFT JOIN (SELECT MAX(fecha_creacion) fecha_creacion, id_evidencia, estatus FROM historial_evidencias GROUP BY id_evidencia, estatus) he3 ON he3.id_evidencia = ec.id_evidencia AND he3.estatus = 3 -- CONTRALORÍA VALIDA OK
                LEFT JOIN (SELECT MAX(fecha_creacion) fecha_creacion, id_evidencia, estatus FROM historial_evidencias GROUP BY id_evidencia, estatus) he10 ON he10.id_evidencia = ec.id_evidencia AND he10.estatus = 10 -- COBRANZA RECHAZA
                LEFT JOIN (SELECT MAX(fecha_creacion) fecha_creacion, id_evidencia, estatus FROM historial_evidencias GROUP BY id_evidencia, estatus) he20 ON he20.id_evidencia = ec.id_evidencia AND he20.estatus = 20 -- CONTRALORÍA RECHAZA
                LEFT JOIN (SELECT id_evidencia, estatus, fecha_creacion, CAST(comentario_autorizacion AS NVARCHAR(100)) comentario_autorizacion FROM historial_evidencias) he200 ON he20.id_evidencia = he200.id_evidencia AND he200.estatus = 20 AND he200.fecha_creacion = he20.fecha_creacion -- CONTRALORÍA RECHAZA
                LEFT JOIN comentariosMktd cm ON cm.idLote = l.idLote AND cm.id_cliente=cl.id_cliente AND cm.bandera_estatus = 1
                LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = cl.lugar_prospeccion AND oxc.id_catalogo = 9
                WHERE cm.id_coment IS NULL
                AND l.idLote NOT IN (48729, 12735, 49644, 26655, 49957, 50079, 51495, 50891, 52093, 51289, 53164, 53165, 53980, 26120, 55593, 55621, 56495, 56893, 57072, 52398, 59767, 59349, 59866, 60002, 60015, 55241, 56209, 57122, 44767, 44768, 11290, 63250, 27235, 66821, 59650, 63526)
                UNION ALL 
                SELECT CONCAT(cl.nombre,' ', cl.apellido_paterno, ' ', cl.apellido_materno) as cliente,
                l.idLote, l.nombreLote, CONCAT(solicitante.nombre,' ', solicitante.apellido_paterno,' ', solicitante.apellido_materno) as solicitante, ec.estatus,
                ec.id_evidencia, cl.id_cliente, ec.evidencia, ec.fecha_modificado, cl.fechaApartado, s.nombre plaza,
                CONVERT(VARCHAR,he1.fecha_creacion,20) AS fechaValidacionGerente, CONVERT(VARCHAR,he2.fecha_creacion,20) AS fechaValidacionCobranza, CONVERT(VARCHAR,he3.fecha_creacion,20) AS fechaValidacionContraloria,
                CONVERT(VARCHAR,he10.fecha_creacion,20) AS fechaRechazoCobranza, CONVERT(VARCHAR,he20.fecha_creacion,20) AS fechaRechazoContraloria, he200.comentario_autorizacion, 
                (CASE cn.tipo WHEN 1 THEN 11 WHEN 2 THEN 22 WHEN 3 THEN 33 WHEN 4 THEN 44 WHEN 5 THEN 55 ELSE 1 END) rowType, cn.tipo,
                cm.id_coment, CASE WHEN (ec.comentario_autorizacion LIKE '%null%' OR CAST(ec.comentario_autorizacion AS VARCHAR(500)) = '' OR ec.comentario_autorizacion IS NULL) 
                THEN 'Comentario no especificado' ELSE ec.comentario_autorizacion END lastComment, ISNULL(oxc.nombre, 'Sin especificar') lugarProspeccion
                FROM lotes l
                INNER JOIN clientes cl ON l.idCliente = cl.id_cliente AND cl.lugar_prospeccion NOT IN (6, 29) AND cl.status = 1
                INNER JOIN usuarios asesor ON cl.id_asesor = asesor.id_usuario $where
                INNER JOIN sedes s ON s.id_sede = asesor.id_sede
                INNER JOIN evidencia_cliente ec ON l.idLote=ec.idLote AND ec.idCliente = cl.id_cliente
                INNER JOIN usuarios solicitante ON solicitante.id_usuario = ec.id_sol
                INNER JOIN opcs_x_cats opxc ON opxc.id_opcion = ec.id_rolAut AND opxc.id_catalogo = 1
                INNER JOIN controversias cn ON cn.id_lote = l.idLote AND cn.estatus = 1
                LEFT JOIN (SELECT MAX(fecha_creacion) fecha_creacion, id_evidencia, estatus FROM historial_evidencias GROUP BY id_evidencia, estatus) he1 ON he1.id_evidencia = ec.id_evidencia AND he1.estatus = 1 -- GERENTE ENVÍA
                LEFT JOIN (SELECT MAX(fecha_creacion) fecha_creacion, id_evidencia, estatus FROM historial_evidencias GROUP BY id_evidencia, estatus) he2 ON he2.id_evidencia = ec.id_evidencia AND he2.estatus = 2 -- COBRANZA VALIAD OK
                LEFT JOIN (SELECT MAX(fecha_creacion) fecha_creacion, id_evidencia, estatus FROM historial_evidencias GROUP BY id_evidencia, estatus) he3 ON he3.id_evidencia = ec.id_evidencia AND he3.estatus = 3 -- CONTRALORÍA VALIDA OK
                LEFT JOIN (SELECT MAX(fecha_creacion) fecha_creacion, id_evidencia, estatus FROM historial_evidencias GROUP BY id_evidencia, estatus) he10 ON he10.id_evidencia = ec.id_evidencia AND he10.estatus = 10 -- COBRANZA RECHAZA
                LEFT JOIN (SELECT MAX(fecha_creacion) fecha_creacion, id_evidencia, estatus FROM historial_evidencias GROUP BY id_evidencia, estatus) he20 ON he20.id_evidencia = ec.id_evidencia AND he20.estatus = 20 -- CONTRALORÍA RECHAZA
                LEFT JOIN (SELECT id_evidencia, estatus, fecha_creacion, CAST(comentario_autorizacion AS NVARCHAR(100)) comentario_autorizacion FROM historial_evidencias) he200 ON he20.id_evidencia = he200.id_evidencia AND he200.estatus = 20 AND he200.fecha_creacion = he20.fecha_creacion -- CONTRALORÍA RECHAZA
                LEFT JOIN comentariosMktd cm ON cm.idLote = l.idLote AND cm.id_cliente=cl.id_cliente AND cm.bandera_estatus = 1
                LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = cl.lugar_prospeccion AND oxc.id_catalogo = 9
                WHERE cm.id_coment IS NULL
                AND l.idLote NOT IN (48729, 12735, 49644, 26655, 49957, 50079, 51495, 50891, 52093, 51289, 53164, 53165, 53980, 26120, 55593, 55621, 56495, 56893, 57072, 52398, 59767, 59349, 59866, 60002, 60015, 55241, 56209, 57122, 44767, 44768, 11290, 63250, 27235, 66821, 59650, 63526)
                UNION ALL
                
                SELECT CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno) cliente, l.idLote, l.nombreLote, 'Sin especificar' solicitante, NULL estatus,
				NULL id_evidencia, cl.id_cliente, NULL evidencia, NULL fecha_modificado, cl.fechaApartado, s.nombre plaza,
				NULL fechaValidacionGerente, NULL fechaValidacionCobranza, NULL fechaValidacionContraloria,
                NULL fechaRechazoCobranza, NULL fechaRechazoContraloria, 'Sin especificar' comentario_autorizacion, 
				'1' rowType, NULL tipo, NULL id_coment, 'Sin especificar' lastComment, ISNULL(oxc.nombre, 'Sin especificar') lugarProspeccion
                FROM lotes l
                INNER JOIN clientes cl ON l.idLote = cl.idLote
                INNER JOIN usuarios asesor ON cl.id_asesor = asesor.id_usuario $where
                INNER JOIN prospectos p ON p.id_prospecto = cl.id_prospecto AND p.fecha_creacion <= '2022-01-20 00:00:00.000'
                LEFT JOIN evidencia_cliente ec ON ec.idCliente = cl.id_cliente 
                INNER JOIN sedes s ON s.id_sede = asesor.id_sede
                LEFT JOIN comentariosMktd cm ON cm.idLote = l.idLote AND cm.id_cliente=cl.id_cliente AND cm.bandera_estatus = 1
                LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = cl.lugar_prospeccion AND oxc.id_catalogo = 9
                WHERE cl.fecha_creacion > '2020-12-31 11:59:00' AND cl.lugar_prospeccion IN (6, 29) AND cl.status = 1 AND l.status = 1 
                AND ec.id_evidencia IS NULL AND cm.id_coment IS NULL 
                AND l.idLote NOT IN (48729, 12735, 49644, 26655, 49957, 50079, 51495, 50891, 52093, 51289, 53164, 53165, 53980, 26120, 55593, 55621, 56495, 56893, 57072, 52398, 59767, 59349, 59866, 60002, 60015, 55241, 56209, 57122, 44767, 44768, 11290, 63250, 27235, 66821, 59650, 63526)
                UNION ALL
                SELECT CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno) cliente, l.idLote, l.nombreLote, 'Sin especificar' solicitante, NULL estatus,
				NULL id_evidencia, cl.id_cliente, NULL evidencia, NULL fecha_modificado, cl.fechaApartado, s.nombre plaza,
				NULL fechaValidacionGerente, NULL fechaValidacionCobranza, NULL fechaValidacionContraloria,
                NULL fechaRechazoCobranza, NULL fechaRechazoContraloria, 'Sin especificar' comentario_autorizacion, 
				(CASE cn.tipo WHEN 1 THEN 11 WHEN 2 THEN 22 WHEN 3 THEN 33 WHEN 4 THEN 44 WHEN 5 THEN 55 ELSE 1 END) rowType, 
				NULL tipo, NULL id_coment, 'Sin especificar' lastComment, ISNULL(oxc.nombre, 'Sin especificar') lugarProspeccion
				FROM lotes l
                INNER JOIN clientes cl ON l.idLote = cl.idLote AND cl.status = 1
                INNER JOIN usuarios asesor ON cl.id_asesor = asesor.id_usuario $where
				INNER JOIN controversias cn ON cn.id_lote = l.idLote AND cn.estatus = 1
                LEFT JOIN evidencia_cliente ec ON ec.idCliente = cl.id_cliente 
                INNER JOIN sedes s ON s.id_sede = asesor.id_sede
                LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = cl.lugar_prospeccion AND oxc.id_catalogo = 9
                WHERE l.status = 1 AND ec.id_evidencia IS NULL
				AND l.idLote NOT IN (48729, 12735, 49644, 26655, 49957, 50079, 51495, 50891, 52093, 51289, 53164, 53165, 53980, 26120, 55593, 55621, 56495, 56893, 57072, 52398, 59767, 59349, 59866, 60002, 60015, 55241, 56209, 57122, 44767, 44768, 11290, 63250, 27235, 66821, 59650, 63526)
                ORDER BY l.nombreLote");
        return $query->result_array();
    }
    public function insertEvidencia($data)
    {
        $this->db->insert('evidencia_cliente', $data);
        return $this->db->affected_rows();
    }
    public function insertHistorialEvidencia($data)
    {
        $this->db->insert('historial_evidencias', $data);
        return $this->db->affected_rows();
    }
    public function getAutsEvidencia($id_evidencia)
    {
        $query = $this->db->query("SELECT he.id_histevi, he.id_evidencia, CONVERT(VARCHAR,he.fecha_creacion,20) AS fecha_creacion, he.estatus, he.creado_por, he.evidencia, he.comentario_autorizacion, e.estatus as estatus_evidencia, 
        CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) as creado_por
        FROM historial_evidencias he 
        INNER JOIN evidencia_cliente e ON he.id_evidencia = e.id_evidencia 
        INNER JOIN usuarios u ON u.id_usuario=he.creado_por
        WHERE he.id_evidencia=" . $id_evidencia . " ORDER BY id_histevi DESC");
        return $query->result_array();
    }
    public function getAutsForCobranza()
    {
        $region1 = "'4', '3', '6', '2'";
        $region2 = "'5', '1'";
        $id_rol_current = $this->session->userdata('id_rol');
        if ($this->session->userdata('id_usuario') == 2042 || $this->session->userdata('id_usuario') == 1981) // JOSS Y MARICELA
        {
            $query = $this->db->query("SELECT c.id_cliente, l.idLote, ec.id_evidencia, l.nombreLote, ec.estatus, CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) as nombreCliente,
            CONCAT(asesor.nombre,' ', asesor.apellido_paterno,' ', asesor.apellido_materno) as nombreSolicitante, 
            ec.evidencia, ec.comentario_autorizacion, s.nombre plaza, c.fechaApartado, (CASE cn.tipo WHEN 1 THEN 11 WHEN 2 THEN 22 WHEN 3 THEN 33 ELSE 1 END) rowType,
            cm.id_coment
            FROM lotes l
            INNER JOIN clientes c ON c.id_cliente=l.idCliente AND c.lugar_prospeccion = 6 AND c.status = 1
            INNER JOIN usuarios asesor ON c.id_asesor=asesor.id_usuario AND asesor.id_sede IN ($region1)
            INNER JOIN sedes s ON s.id_sede = asesor.id_sede
            INNER JOIN evidencia_cliente ec ON l.idLote=ec.idLote AND ec.estatus IN (1) AND ec.idCliente = c.id_cliente
            LEFT JOIN comentariosMktd cm ON cm.idLote = l.idLote
            LEFT JOIN controversias cn ON cn.id_lote = l.idLote AND cn.estatus = 1
            WHERE l.status = 1 AND cm.id_coment IS NULL
            UNION ALL
            SELECT c.id_cliente, l.idLote, ec.id_evidencia, l.nombreLote, ec.estatus, CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) as nombreCliente,
            CONCAT(asesor.nombre,' ', asesor.apellido_paterno,' ', asesor.apellido_materno) as nombreSolicitante, ec.evidencia, 
            ec.comentario_autorizacion, s.nombre plaza, c.fechaApartado, (CASE cn.tipo WHEN 1 THEN 11 WHEN 2 THEN 22 WHEN 3 THEN 33 END) rowType,
            cm.id_coment
            FROM lotes l
            INNER JOIN clientes c ON c.id_cliente=l.idCliente AND c.status = 1
            INNER JOIN usuarios asesor ON c.id_asesor=asesor.id_usuario AND asesor.id_sede IN ($region1)
            INNER JOIN sedes s ON s.id_sede = asesor.id_sede
            INNER JOIN evidencia_cliente ec ON l.idLote=ec.idLote AND ec.estatus IN (1) AND ec.idCliente = c.id_cliente
            INNER JOIN controversias cn ON cn.id_lote = l.idLote AND cn.estatus = 1
            LEFT JOIN comentariosMktd cm ON cm.idLote = l.idLote 
            WHERE cm.id_coment IS NULL");
        } else if ($this->session->userdata('id_usuario') == 5363 || $this->session->userdata('id_usuario') == 1988) //Paulina prod 5363 - Local: 4969  // se añade
        {
            $query = $this->db->query("SELECT c.id_cliente, l.idLote, ec.id_evidencia, l.nombreLote, ec.estatus, CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) as nombreCliente,
            CONCAT(asesor.nombre,' ', asesor.apellido_paterno,' ', asesor.apellido_materno) as nombreSolicitante, 
            ec.evidencia, ec.comentario_autorizacion, s.nombre plaza, c.fechaApartado, (CASE cn.tipo WHEN 1 THEN 11 WHEN 2 THEN 22 WHEN 3 THEN 33 ELSE 1 END) rowType,
            cm.id_coment
            FROM lotes l
            INNER JOIN clientes c ON c.id_cliente=l.idCliente AND c.lugar_prospeccion = 6 AND c.status = 1
            INNER JOIN usuarios asesor ON c.id_asesor=asesor.id_usuario AND asesor.id_sede IN ($region2)
            INNER JOIN sedes s ON s.id_sede = asesor.id_sede
            INNER JOIN evidencia_cliente ec ON l.idLote=ec.idLote AND ec.estatus IN (1) AND ec.idCliente = c.id_cliente
            LEFT JOIN comentariosMktd cm ON cm.idLote = l.idLote
            LEFT JOIN controversias cn ON cn.id_lote = l.idLote AND cn.estatus = 1
            WHERE l.status = 1 AND cm.id_coment IS NULL
            UNION ALL
            SELECT c.id_cliente, l.idLote, ec.id_evidencia, l.nombreLote, ec.estatus, CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) as nombreCliente,
            CONCAT(asesor.nombre,' ', asesor.apellido_paterno,' ', asesor.apellido_materno) as nombreSolicitante, ec.evidencia, 
            ec.comentario_autorizacion, s.nombre plaza, c.fechaApartado, (CASE cn.tipo WHEN 1 THEN 11 WHEN 2 THEN 22 WHEN 3 THEN 33 END) rowType,
            cm.id_coment
            FROM lotes l
            INNER JOIN clientes c ON c.id_cliente=l.idCliente
            INNER JOIN usuarios asesor ON c.id_asesor=asesor.id_usuario AND asesor.id_sede IN ($region2)
            INNER JOIN sedes s ON s.id_sede = asesor.id_sede
            INNER JOIN evidencia_cliente ec ON l.idLote=ec.idLote
            INNER JOIN controversias cn ON cn.id_lote = l.idLote AND ec.estatus IN (1) AND ec.idCliente = c.id_cliente AND cn.estatus = 1
            LEFT JOIN comentariosMktd cm ON cm.idLote = l.idLote 
            WHERE cm.id_coment IS NULL
            ORDER BY l.nombreLote");
        }
        return $query->result_array();
    }
    public function getSolicitudEvidencia($id_evidencia)
    {
        $query = $this->db->query("SELECT * FROM evidencia_cliente WHERE id_evidencia=" . $id_evidencia);
        return $query->result_array();
    }
    function updateSolEvidencia($id_evidencia, $data_update)
    {
        $this->db->where("id_evidencia", $id_evidencia);
        $this->db->update('evidencia_cliente', $data_update);
        return $this->db->affected_rows();
    }
    function insertHistSolEv($data_insert_historial)
    {
        $this->db->insert('historial_evidencias', $data_insert_historial);
        return $this->db->affected_rows();
    }
    function getAutsForContraloria()
    {
        $query = $this->db->query("SELECT CONCAT(cl.nombre,' ', cl.apellido_paterno, ' ', cl.apellido_materno) as cliente,
        ec.idLote, l.nombreLote, CONCAT(solicitante.nombre,' ', solicitante.apellido_paterno,' ', solicitante.apellido_materno) as solicitante, ec.estatus,
        ec.id_evidencia, cl.id_cliente, ec.evidencia, ec.fecha_modificado, cl.fechaApartado, s.nombre plaza,
        he1.fecha_creacion fechaValidacionGerente, he2.fecha_creacion fechaValidacionCobranza, he3.fecha_creacion fechaValidacionContraloria,
        he10.fecha_creacion fechaRechazoCobranza, he20.fecha_creacion fechaRechazoContraloria, he200.comentario_autorizacion, 
        (CASE cn.tipo WHEN 1 THEN 11 WHEN 2 THEN 22 WHEN 3 THEN 33 WHEN 4 THEN 44 WHEN 5 THEN 55 ELSE 1 END) rowType
        FROM evidencia_cliente ec
        INNER JOIN clientes cl ON ec.idCliente = cl.id_cliente AND cl.lugar_prospeccion IN (6, 29) AND cl.status = 1
        INNER JOIN usuarios asesor ON cl.id_asesor = asesor.id_usuario
        LEFT JOIN prospectos p ON p.id_prospecto = cl.id_prospecto AND p.fecha_creacion <= '2022-01-20 00:00:00.000'
        INNER JOIN sedes s ON CONVERT(VARCHAR(12), s.id_sede) = CONVERT(VARCHAR(12), asesor.id_sede)
        INNER JOIN usuarios solicitante ON solicitante.id_usuario = ec.id_sol
        INNER JOIN opcs_x_cats opxc ON opxc.id_opcion = ec.id_rolAut
        INNER JOIN lotes l ON l.idLote=ec.idLote
        LEFT JOIN controversias cn ON cn.id_lote = l.idLote AND cn.estatus = 1
        LEFT JOIN (SELECT MAX(fecha_creacion) fecha_creacion, id_evidencia, estatus FROM historial_evidencias GROUP BY id_evidencia, estatus) he1 ON he1.id_evidencia = ec.id_evidencia AND he1.estatus = 1 -- GERENTE ENVÍA
        LEFT JOIN (SELECT MAX(fecha_creacion) fecha_creacion, id_evidencia, estatus FROM historial_evidencias GROUP BY id_evidencia, estatus) he2 ON he2.id_evidencia = ec.id_evidencia AND he2.estatus = 2 -- COBRANZA VALIAD OK
        LEFT JOIN (SELECT MAX(fecha_creacion) fecha_creacion, id_evidencia, estatus FROM historial_evidencias GROUP BY id_evidencia, estatus) he3 ON he3.id_evidencia = ec.id_evidencia AND he3.estatus = 3 -- CONTRALORÍA VALIDA OK
        LEFT JOIN (SELECT MAX(fecha_creacion) fecha_creacion, id_evidencia, estatus FROM historial_evidencias GROUP BY id_evidencia, estatus) he10 ON he10.id_evidencia = ec.id_evidencia AND he10.estatus = 10 -- COBRANZA RECHAZA
        LEFT JOIN (SELECT MAX(fecha_creacion) fecha_creacion, id_evidencia, estatus FROM historial_evidencias GROUP BY id_evidencia, estatus) he20 ON he20.id_evidencia = ec.id_evidencia AND he20.estatus = 20 -- CONTRALORÍA RECHAZA
        LEFT JOIN (SELECT id_evidencia, estatus, fecha_creacion, CAST(comentario_autorizacion AS NVARCHAR(100)) comentario_autorizacion FROM historial_evidencias) he200 ON he20.id_evidencia = he200.id_evidencia AND he200.estatus = 20 AND he200.fecha_creacion = he20.fecha_creacion -- CONTRALORÍA RECHAZA
        WHERE opxc.id_catalogo = 1 AND ec.estatus IN (2, 3, 20)
        AND l.idLote NOT IN (48729, 12735, 49644, 26655, 49957, 50079, 51495, 50891, 52093, 51289, 53164, 53165, 53980, 26120, 55593, 55621, 56495, 56893, 57072, 52398, 59767, 59349, 59866, 60002, 60015, 55241, 56209, 57122, 44767, 44768, 11290, 63250, 27235, 66821, 59650, 63526)
        UNION ALL 
        SELECT CONCAT(cl.nombre,' ', cl.apellido_paterno, ' ', cl.apellido_materno) as cliente,
        ec.idLote, l.nombreLote, CONCAT(solicitante.nombre,' ', solicitante.apellido_paterno,' ', solicitante.apellido_materno) as solicitante, ec.estatus,
        ec.id_evidencia, cl.id_cliente, ec.evidencia, ec.fecha_modificado, cl.fechaApartado, s.nombre plaza,
        he1.fecha_creacion fechaValidacionGerente, he2.fecha_creacion fechaValidacionCobranza, he3.fecha_creacion fechaValidacionContraloria,
        he10.fecha_creacion fechaRechazoCobranza, he20.fecha_creacion fechaRechazoContraloria, he200.comentario_autorizacion, 
        (CASE cn.tipo WHEN 1 THEN 11 WHEN 2 THEN 22 WHEN 3 THEN 33 WHEN 4 THEN 44 WHEN 5 THEN 55 ELSE 1 END) rowType
        FROM evidencia_cliente ec
        INNER JOIN clientes cl ON ec.idCliente = cl.id_cliente AND cl.lugar_prospeccion NOT IN (6, 29) AND cl.status = 1
        INNER JOIN usuarios asesor ON cl.id_asesor = asesor.id_usuario
        INNER JOIN sedes s ON CONVERT(VARCHAR(12), s.id_sede) = CONVERT(VARCHAR(12), asesor.id_sede)
        INNER JOIN usuarios solicitante ON solicitante.id_usuario = ec.id_sol
        INNER JOIN opcs_x_cats opxc ON opxc.id_opcion = ec.id_rolAut
        INNER JOIN lotes l ON l.idLote=ec.idLote
        INNER JOIN controversias cn ON cn.id_lote = l.idLote AND cn.estatus = 1
        LEFT JOIN (SELECT MAX(fecha_creacion) fecha_creacion, id_evidencia, estatus FROM historial_evidencias GROUP BY id_evidencia, estatus) he1 ON he1.id_evidencia = ec.id_evidencia AND he1.estatus = 1 -- GERENTE ENVÍA
        LEFT JOIN (SELECT MAX(fecha_creacion) fecha_creacion, id_evidencia, estatus FROM historial_evidencias GROUP BY id_evidencia, estatus) he2 ON he2.id_evidencia = ec.id_evidencia AND he2.estatus = 2 -- COBRANZA VALIAD OK
        LEFT JOIN (SELECT MAX(fecha_creacion) fecha_creacion, id_evidencia, estatus FROM historial_evidencias GROUP BY id_evidencia, estatus) he3 ON he3.id_evidencia = ec.id_evidencia AND he3.estatus = 3 -- CONTRALORÍA VALIDA OK
        LEFT JOIN (SELECT MAX(fecha_creacion) fecha_creacion, id_evidencia, estatus FROM historial_evidencias GROUP BY id_evidencia, estatus) he10 ON he10.id_evidencia = ec.id_evidencia AND he10.estatus = 10 -- COBRANZA RECHAZA
        LEFT JOIN (SELECT MAX(fecha_creacion) fecha_creacion, id_evidencia, estatus FROM historial_evidencias GROUP BY id_evidencia, estatus) he20 ON he20.id_evidencia = ec.id_evidencia AND he20.estatus = 20 -- CONTRALORÍA RECHAZA
        LEFT JOIN (SELECT id_evidencia, estatus, fecha_creacion, CAST(comentario_autorizacion AS NVARCHAR(100)) comentario_autorizacion FROM historial_evidencias) he200 ON he20.id_evidencia = he200.id_evidencia AND he200.estatus = 20 AND he200.fecha_creacion = he20.fecha_creacion -- CONTRALORÍA RECHAZA
        WHERE opxc.id_catalogo = 1 AND ec.estatus IN (2, 3, 20) 
        AND l.idLote NOT IN (48729, 12735, 49644, 26655, 49957, 50079, 51495, 50891, 52093, 51289, 53164, 53165, 53980, 26120, 55593, 55621, 56495, 56893, 57072, 52398, 59767, 59349, 59866, 60002, 60015, 55241, 56209, 57122, 44767, 44768, 11290, 63250, 27235, 66821, 59650, 63526)
        ORDER BY l.nombreLote");
        return $query->result_array();
    }
    function sendMailReportER()
    {
        $query = $this->db->query("SELECT CONCAT(cl.nombre,' ', cl.apellido_paterno, ' ', cl.apellido_materno) as cliente,
                ec.idLote, l.nombreLote, CONCAT(solicitante.nombre,' ', solicitante.apellido_paterno,' ', solicitante.apellido_materno) as solicitante, ec.estatus,
                ec.id_evidencia, cl.id_cliente, ec.evidencia, ec.fecha_modificado
                FROM evidencia_cliente ec
                INNER JOIN clientes cl ON ec.idCliente = cl.id_cliente
                INNER JOIN usuarios solicitante ON solicitante.id_usuario = ec.id_sol
                INNER JOIN opcs_x_cats opxc ON opxc.id_opcion=ec.id_rolAut
                INNER JOIN lotes l ON l.idLote=ec.idLote
                WHERE opxc.id_catalogo=1  AND ec.id_sol=1981");
        return $query->result_array();
    }
    function getSedes()
    {
        $query = $this->db->query("SELECT * FROM sedes WHERE estatus=1");
        return $query->result_array();
    }
    function getEviRecBySede($id_sede)
    {
        $query = $this->db->query("SELECT c.id_cliente, l.idLote, ec.id_evidencia, l.nombreLote, ec.estatus, CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) as nombreCliente,
        CONCAT(solicitante.nombre,' ', solicitante.apellido_paterno,' ', solicitante.apellido_materno) as nombreSolicitante, ec.evidencia, ec.comentario_autorizacion, ec.fecha_creacion
        FROM evidencia_cliente ec
        INNER JOIN clientes c ON c.id_cliente=ec.idCliente
        INNER JOIN usuarios solicitante ON ec.id_sol=solicitante.id_usuario
        INNER JOIN usuarios asesor ON c.id_asesor=asesor.id_usuario
        INNER JOIN lotes l ON l.idLote=ec.idLote
        WHERE asesor.id_sede IN ('" . $id_sede . "') AND ec.estatus IN (10, 20)");
        return $query->result_array();
    }
    function getEvidenciasProspectosChat($id_prospecto)
    {
        $query = $this->db->query("SELECT * FROM evidencias WHERE id_prospecto=" . $id_prospecto);
        return $query->result_array();
    }
    function getidLoteByClient($id_cliente)
    {
        $query = $this->db->query("SELECT idLote FROM clientes WHERE id_cliente=" . $id_cliente);
        return $query->result_array();
    }
    function insertRegDelMKTDFList($data_insert)
    {
        $this->db->insert('comentariosMktd', $data_insert);
        return $this->db->affected_rows();
    }
    function getClientByLote($idLote)
    {
        $query = $this->db->query("SELECT id_cliente FROM clientes WHERE status=1 AND idLote=" . $idLote);
        return $query->result_array();
    }
    function updateClienteLP($data_update, $id_cliente)
    {
        $this->db->where("id_cliente", $id_cliente);
        $this->db->update('clientes', $data_update);
        return $this->db->affected_rows();
    }
    function getDeletedLotesEV()
    {
        $query = $this->db->query("SELECT 
        id_coment, cm.idLote, cm.observacion, CONVERT(VARCHAR,cm.fecha_creacion,20) AS fecha_creacion,
        l.nombreLote, CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno) as nombreCliente,
        CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) as nombreSolicitante
        FROM comentariosMktd cm
        INNER JOIN lotes l ON l.idLote=cm.idLote
        INNER JOIN clientes cl ON cl.id_cliente=l.idCliente
        INNER JOIN usuarios u ON u.id_usuario=cm.creado_por;");
        return $query->result_array();
    }
    function getIdProspectByCl($id_cliente)
    {
        $query = $this->db->query("SELECT  id_prospecto FROM clientes WHERE id_cliente=" . $id_cliente);
        return $query->result_array();
    }
    function updateProspectLP($data_update, $id_prospecto)
    {
        $this->db->where("id_prospecto", $id_prospecto);
        $this->db->update('prospectos', $data_update);
        return $this->db->affected_rows();
    }
    public function getLegalPersonalityByLote($idLote)
    {
        $query = $this->db->query("SELECT id_cliente, idLote, personalidad_juridica FROM clientes WHERE idLote IN ($idLote) AND status = 1");
        return $query->result_array();
    }
    public function validateDocumentation($idLote, $legalPersonality, $tipo_comprobante)
    {
        /*
        LEGAL PERSONALITY VALUES
            1 PM
            2   PF
        */
        $cd=', 3';//comprobante domicilio
        if($tipo_comprobante==1){
            $cd = '';
        }
        if ($this->session->userdata('id_rol') == 17)
            $documentOptions = $legalPersonality == 2 ? '2'.$cd : '2 '.$cd.', 4, 10, 11';
        else
            $documentOptions = $legalPersonality == 2 ? '2'.$cd.', 4' : '2'.$cd.', 4, 10, 11, 12';
        $query = $this->db->query("SELECT expediente, idCliente, tipo_doc FROM historial_documento WHERE idLote IN ($idLote) AND 
        status = 1 AND expediente IS NOT NULL AND tipo_doc IN ($documentOptions)
        UNION ALL
        SELECT 'SÍ HAY DS', id_cliente, '55' tipo_doc FROM deposito_seriedad WHERE id_cliente IN 
        (SELECT id_cliente FROM clientes WHERE idLote = $idLote AND status = 1) AND desarrollo IS NOT NULL");
        return $query->result_array();
    }
    //Se verifica si el lote fue prospectado por marketing digital
    public function verificarMarketing($idLote)
    {
        $query = $this->db->query("SELECT l.idLote, l.nombreLote, c.id_cliente, c.lugar_prospeccion FROM lotes l 
        INNER JOIN clientes c ON c.idLote = l.idLote AND c.status = 1 AND c.lugar_prospeccion NOT IN (6, 29)
        WHERE l.status = 1 AND l.idLote IN ($idLote)
        UNION ALL
        SELECT l.idLote, l.nombreLote, c.id_cliente, c.lugar_prospeccion FROM lotes l 
        INNER JOIN clientes c ON c.idLote = l.idLote AND c.status = 1 AND c.lugar_prospeccion IN (6, 29)
        INNER JOIN prospectos p ON p.id_prospecto = c.id_prospecto AND p.fecha_creacion > '2022-01-19'
        WHERE l.status = 1 AND l.idLote IN ($idLote)");
        return $query->result_array();
    }
    public function verificarControversia($idLote)
    {
        $query = $this->db->query("SELECT * FROM controversias WHERE id_lote = $idLote AND estatus = 1");
        return $query->result_array();
    }
    public function insertControversia($data)
    {
        $this->db->insert('controversias', $data);
        return $this->db->affected_rows();
    }
    public function getControversy()
    {
        if ($this->session->userdata('id_usuario') == 2042 || $this->session->userdata('id_usuario') == 1981) // JOSS Y MARICELA
            $region = "'2', '3', '4', '6'";
        else if ($this->session->userdata('id_usuario') == 5363 || $this->session->userdata('id_usuario') == 1988)
            $region = "'1', '5', '8', '9'";
        return $this->db->query("SELECT l.idLote, l.nombreLote, CONVERT(VARCHAR,c.fechaApartado,20) AS fechaApartado, s.nombre plaza,
            CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombreCliente,
            cn.tipo, cn.comentario, CONVERT(VARCHAR,cn.fecha_creacion,20) AS fecha_creacion,
            CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) creado_por
            FROM controversias cn 
            INNER JOIN lotes l ON l.idLote = cn.id_lote AND l.status = 1
            INNER JOIN clientes c ON c.idLote = l.idLote AND c.status = 1
            LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor AND u.id_sede IN ($region)
            LEFT JOIN usuarios us ON us.id_usuario = cn.creado_por
            LEFT JOIN sedes s ON s.id_sede = u.id_sede
            /*LEFT JOIN comentariosMktd cm ON cm.idLote = l.idLote AND cm.id_cliente=c.id_cliente
            WHERE cm.id_coment IS NULL*/
            WHERE l.idLote NOT IN (48729, 12735, 49644, 26655, 49957, 50079, 51495, 50891, 52093, 51289, 53164, 53165, 53980, 26120, 55593, 55621, 56495, 56893, 57072, 52398, 59767, 59349, 59866, 60002, 60015, 55241, 56209, 57122, 44767, 44768, 11290, 63250, 27235, 66821, 59650, 63526)
            ORDER BY cn.fecha_creacion")->result_array();
    }
    function getCatalogs()
    {
        return $this->db->query("SELECT id_catalogo, id_opcion, nombre FROM opcs_x_cats WHERE id_catalogo IN (11, 18, 19, 26, 92) AND estatus = 1 ORDER BY id_catalogo, id_opcion");
    }
    public function getAsesores($idUsuario)
    {
        return $this->db->query("SELECT id_usuario,  CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) as nombre FROM usuarios WHERE id_rol IN (7,9) AND estatus IN (1,3) AND id_usuario NOT IN ($idUsuario)")->result_array();
    }
    public function getInfoCasasByLote($idLote){
        $query =  $this->db->query("SELECT id_lote,  tipo_casa FROM casas WHERE id_lote=".$idLote." AND estatus=1;");
        return $query->result_array();
    }
    public function getAutorizaciones($idLote, $id_cliente){
        return $this->db->query("SELECT * FROM autorizaciones WHERE idLote = ".$idLote." AND estatus=1 AND idCliente=".$id_cliente)->result_array();
        //return $query->result_array();
    }
    function getlotesRechazados(){
        $id_currentUser = $this->session->userdata('id_usuario');
        $lider_currentUser = $this->session->userdata('id_lider');
        $current_rol = $this->session->userdata('id_rol');
        $filter = '';
        switch ($current_rol) {
            case 1:
            { #DIRECTOR   - RIGEL
                $filter = '';
                break;
            }
            case 4:
            { #ASISTENTE DIRECTOR ASISTENTE RIGEL
                $filter = '';
                break;
            }
            case 3:
            { #GERENTE
                $filter = ' AND cl.id_gerente=' . $id_currentUser;
                break;
            }
            case 6:
            { #ASISTENTE GERENTE
                $filter = ' AND cl.id_gerente=' . $lider_currentUser;
                break;
            }
            case 2:
            { #SUBDIRECCIÓN
                $filter = ' AND cl.id_subdirector=' . $id_currentUser;
                break;
            }
            case 5:
            { #ASISTENTE SUBDIRECCIÓN
                $filter = ' AND cl.id_subdirector=' . $lider_currentUser;
                break;
            }
            case 9:
            { #COORDINADOR
                $filter = ' AND cl.id_coordinador=' . $id_currentUser;
                break;
            }
            case 59:
            { #DIRECTOR REGIONAL
                $filter = ' AND cl.id_regional=' . $id_currentUser;
                break;
            }
            case 60:
            { #ASISTENTE DIRECTOR REGIONAL
                $filter = ' AND cl.id_regional=' . $lider_currentUser;
                break;
            }
            default:
            {
                $filter = '';
                break;
            }
        }
        $query = $this->db->query("SELECT re.descripcion nombreResidencial, co.nombre nombreCondominio, lo.nombreLote, lo.idLote, 
        CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno) nombreCliente, cl.fechaApartado, sc.nombreStatus estatusActual,
        mo.descripcion
                FROM clientes cl
                INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.idCliente = cl.id_cliente AND lo.idStatusLote = 3
                INNER JOIN condominios co ON lo.idCondominio = co.idCondominio
                INNER JOIN residenciales re ON co.idResidencial = re.idResidencial
                INNER JOIN usuarios ae ON ae.id_usuario = cl.id_asesor
                INNER JOIN usuarios cr ON cr.id_usuario = cl.id_coordinador
                INNER JOIN usuarios ge ON ge.id_usuario = cl.id_gerente
                INNER JOIN statuscontratacion sc ON sc.idStatusContratacion = lo.idStatusContratacion
                INNER JOIN movimientos mo ON mo.idMovimiento = lo.idMovimiento
                WHERE cl.status = 1 AND
                (lo.idStatusContratacion = 2 OR lo.idStatusContratacion = 1) AND lo.idMovimiento IN (85, 20, 63, 73, 82, 92, 96) AND cl.status = 1 ".$filter."
        ORDER BY cl.id_Cliente ASC");
        return $query->result_array();
    }
    function getInfoCFByCl($id_cliente){
        $query = $this->db->query("
        SELECT * FROM corridas_financieras cf
        INNER JOIN lotes l ON l.idLote = cf.id_lote
        INNER JOIN clientes cl ON l.idCliente = cl.id_cliente
        WHERE l.idCliente = $id_cliente AND cf.status=1;
        ");
        return $query->row();
    }
    function getDescsByCF($id_corrida){
        $query = $this->db->query("SELECT id_pf, porcentaje, precio_t, precio_m, ahorro, idLote, co.descripcion as aplicable_a, pf.id_corrida  FROM precios_finales pf 
        INNER JOIN condiciones co ON pf.id_condicion = co.id_condicion
        WHERE id_corrida=".$id_corrida);
        return $query->result_array();
    }
    function getLineOfACG($id_lote){
        $query = $this->db->query("SELECT CONCAT(asesor.nombre, ' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) as asesor, asesor.id_usuario as id_asesor, asesor.id_rol as rol_asesor,
        CONCAT(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno) as coordinador, coordinador.id_usuario as id_coordinador, coordinador.id_rol as rol_coord,
        CONCAT(gerente.nombre, ' ', gerente.apellido_paterno, ' ', gerente.apellido_materno) as gerente, gerente.id_usuario as id_gerente, gerente.id_rol as rol_gerente
        FROM lotes l 
        INNER JOIN clientes cl ON cl.id_cliente=l.idCliente 
        LEFT JOIN usuarios asesor ON asesor.id_usuario=cl.id_asesor
        LEFT JOIN usuarios coordinador ON coordinador.id_usuario=asesor.id_lider
        LEFT JOIN usuarios gerente ON gerente.id_usuario=coordinador.id_lider
        WHERE l.idLote=".$id_lote);
        return $query->result_array();
    }
    function getGerenteById($id_gerente){
        $query = $this->db->query("SELECT u.id_lider, u.id_rol, u.estatus, u.id_usuario idGerente, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreGerente  
                                    FROM usuarios u WHERE id_usuario=".$id_gerente);
        return $query->row();
    }
    function getCoordinadorById($id_coordinador){
        $query = $this->db->query("SELECT u.id_lider, u.id_rol, u.estatus, u.id_usuario idCoordinador, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreCoordinador  
                                    FROM usuarios u WHERE id_usuario=".$id_coordinador);
        return $query->row();
    }
    function getAsesorById($id_asesor){
        $query = $this->db->query("SELECT u.id_lider, u.id_rol, u.estatus, u.id_usuario idAsesor, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreAsesor  
                                    FROM usuarios u WHERE id_usuario=".$id_asesor);
        return $query->row();
    }
    function reporteAsesor(){
        if ($this->session->userdata('id_rol') == 17 || $this->session->userdata('id_usuario') == 1875){ //Contraloria y Vicky 
            $where = "";
        } else if ($this->session->userdata('id_rol') == 3 || $this->session->userdata('id_rol') == 6){ //Gerente y Asistente
            $where = "AND DATEDIFF(MONTH, ase.fecha_creacion, GETDATE()) <= 5";
        } else if ($this->session->userdata('id_rol') == 2 || $this->session->userdata('id_rol') == 5 ){ //Subdirector y Asistente
            $where = "AND DATEDIFF(MONTH, ase.fecha_creacion, GETDATE()) >= 6 AND DATEDIFF(MONTH, ase.fecha_creacion, GETDATE()) <= 8";
        } else if ($this->session->userdata('id_rol') == 1 || $this->session->userdata('id_rol') == 4){ //Direccion Comercial y Asistentes
            $where = "AND DATEDIFF(MONTH, ase.fecha_creacion, GETDATE()) >= 9";
        }
        return $this->db->query("SELECT CONCAT(ase.nombre,' ',ase.apellido_paterno,' ',ase.apellido_materno) AS asesor, ase.id_usuario, ase.fecha_creacion,
                                CASE WHEN SUM(lot.totalNeto2) = '0.00' THEN SUM(lot.total) WHEN SUM(lot.totalNeto2) IS NULL THEN SUM(lot.total) ELSE SUM(lot.totalNeto2) END AS monto_vendido,
                                DATEDIFF(MONTH, ase.fecha_creacion, GETDATE()) meses, ase.estatus
                                FROM lotes lot
                                INNER JOIN clientes cl ON cl.id_cliente = lot.idCliente AND cl.status = 1
                                INNER JOIN usuarios ase ON ase.id_usuario = cl.id_asesor
                                WHERE ase.fecha_creacion >= cl.fechaApartado $where
                                GROUP BY CONCAT(ase.nombre,' ',ase.apellido_paterno,' ',ase.apellido_materno), ase.id_usuario, ase.fecha_creacion, ase.estatus
                                HAVING SUM(CASE WHEN lot.totalNeto2 = '0.00' THEN lot.total WHEN lot.totalNeto2 IS NULL THEN lot.total ELSE lot.totalNeto2 END) <= '500000.00'");
        
    }
    function getWstatus1($id_lote){
        $query = $this->db->query("SELECT * FROM autorizaciones WHERE estatus=1 AND idLote=".$id_lote);
        return $query->result_array();
    }
    function revisaOU($idLote){
        //esta funcion revisa si el lote esta en ObservacionContratoUrgente
        $query = $this->db->query("SELECT * FROM lotes WHERE observacionContratoUrgente='1' AND idLote=".$idLote);
        return $query->result_array();
    }
    function informacionVerificarCliente($idCliente){
        $query = $this->db->query("SELECT * FROM clientes cl
        INNER JOIN lotes l ON cl.id_cliente=l.idCliente
        WHERE cl.status=1 AND cl.id_cliente=".$idCliente);
        return $query->row();
    }
    function revisarCartaVerif($id_cliente, $tipo_documento){
        $query = $this->db->query("SELECT * FROM historial_documento WHERE idCliente=".$id_cliente." AND status=1 AND tipo_doc=".$tipo_documento);
        return $query->result_array();
    }
    function getTipoVenta($idLote){
        $query = $this->db->query("SELECT * FROM lotes WHERE idLote=".$idLote);
        return $query->result_array();
    }
    function getInicioMensualidadAut($idLote, $id_cliente){
        $query = $this->db->query("SELECT * FROM corridas_financieras cf
        INNER JOIN historial_documento hd ON hd.idLote = cf.id_lote
        WHERE cf.id_lote=".$idLote." AND cf.id_cliente=".$id_cliente." AND hd.tipo_doc=31");
        return $query->result_array();
    }

    function getSubdirs(){
        $query = $this->db->query("SELECT id_usuario as id_subdir, 
            UPPER(CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno)) AS nombre_subdir 
            FROM usuarios WHERE id_rol = 2 AND estatus = 1 
            ORDER BY UPPER(CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno)) ASC");
        return $query->result_array();
    }

    function eliminarCodigoAutorizaciones($idCliente, $tipo)
    {
        $this->db->query("DELETE FROM codigo_autorizaciones WHERE id_cliente = $idCliente AND tipo = $tipo");
    }
}
