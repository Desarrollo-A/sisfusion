<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comisiones_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function getDataActivasPago($val = '') {
        $this->db->query("SET LANGUAGE Español;");
        ini_set('memory_limit', -1);
        $query = $this->db->query("SELECT DISTINCT(l.idLote), res.nombreResidencial, cond.nombre as nombreCondominio, l.nombreLote, 
        CONCAT(cl.nombre,' ',cl.apellido_paterno,' ',cl.apellido_materno) nombreCliente,
        (CASE WHEN l.tipo_venta = 1 THEN 'Particular' WHEN l.tipo_venta = 2 THEN 'NORMAL' WHEN l.tipo_venta = 7 THEN 'ESPECIAL' ELSE ' SIN DEFINIR' END) tipo_venta,
        (CASE WHEN l.tipo_venta = 1 THEN 'lbl-warning' WHEN l.tipo_venta = 2 THEN 'lbl-green' WHEN l.tipo_venta = 7 THEN 'lbl-violetDeep' ELSE 'lbl-gray' END) claseTipo_venta,
        (CASE WHEN cl.proceso = 0 THEN '' ELSE oxc0.nombre END) procesoCl,
        (CASE WHEN cl.proceso = 0 THEN '' ELSE 'label lbl-violetBoots' END) colorProcesoCl,
        vc.id_cliente AS compartida, l.idStatusContratacion, l.totalNeto2, pc.fecha_modificacion, 
        convert(nvarchar, pc.ultima_dispersion, 6) ultima_dispersion, 
        convert(nvarchar, pc.fecha_modificacion, 6) fecha_sistema, 
        convert(nvarchar, pc.fecha_neodata, 6) fecha_neodata, convert(nvarchar, cl.fechaApartado, 6) fechaApartado, se.nombre as sede, l.registro_comision, l.referencia, cl.id_cliente,            
        CONCAT(ae.nombre, ' ', ae.apellido_paterno, ' ', ae.apellido_materno) as asesor,
        CONCAT(co.nombre, ' ', co.apellido_paterno, ' ', co.apellido_materno) as coordinador,
        CONCAT(ge.nombre, ' ', ge.apellido_paterno, ' ', ge.apellido_materno) as gerente,
        CONCAT(su.nombre, ' ', su.apellido_paterno, ' ', su.apellido_materno) as subdirector, 
        (CASE WHEN re.id_usuario IN (0) OR re.id_usuario IS NULL THEN 'NA' ELSE CONCAT(re.nombre, ' ', re.apellido_paterno, ' ', re.apellido_materno) END) regional,
        CONCAT(di.nombre, ' ', di.apellido_paterno, ' ', di.apellido_materno) as director, 
        (CASE WHEN cl.plan_comision IN (0) OR cl.plan_comision IS NULL THEN '-' ELSE pl.descripcion END) AS plan_descripcion, cl.plan_comision,cl.id_subdirector, cl.id_sede, cl.id_prospecto, cl.lugar_prospeccion,
        (CASE WHEN ooam.total > 1 THEN 1 ELSE 0 END) ooam,
		(CASE WHEN ventas.total > 1 THEN 1 ELSE 0 END) ventas
        FROM lotes l
        INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
        INNER JOIN condominios cond ON l.idCondominio=cond.idCondominio
        INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
        INNER JOIN usuarios ae ON ae.id_usuario = cl.id_asesor
        LEFT JOIN pago_comision pc ON pc.id_lote = l.idLote
        LEFT JOIN (SELECT id_cliente FROM ventas_compartidas WHERE estatus = 1) AS vc ON vc.id_cliente = cl.id_cliente
        LEFT JOIN usuarios co ON co.id_usuario = cl.id_coordinador
        LEFT JOIN usuarios ge ON ge.id_usuario = cl.id_gerente
        LEFT JOIN usuarios su ON su.id_usuario = cl.id_subdirector
        LEFT JOIN usuarios re ON re.id_usuario = cl.id_regional
        LEFT JOIN usuarios di ON di.id_usuario = 2
        LEFT JOIN plan_comision pl ON pl.id_plan = cl.plan_comision
        LEFT JOIN sedes se ON se.id_sede = cl.id_sede 
        LEFT JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = cl.proceso AND oxc0.id_catalogo = 97
        LEFT JOIN (select COUNT(*) total, id_lote FROM comisiones WHERE ooam = 1 GROUP BY id_lote) ooam ON ooam.id_lote = l.idLote
        LEFT JOIN (select COUNT(*) total, id_lote FROM comisiones WHERE ooam = 2 GROUP BY id_lote) ventas ON ventas.id_lote = l.idLote

        LEFT JOIN (SELECT idLote, idCliente, MAX(modificado) modificado, idStatusContratacion, idMovimiento FROM historial_lotes WHERE idStatusContratacion = 9 AND idMovimiento = 39 
        GROUP BY idLote, idCliente, idStatusContratacion, idMovimiento) hl ON hl.idLote = l.idLote AND hl.idCliente = l.idCliente
        WHERE ((hl.idStatusContratacion = 9 AND hl.idMovimiento = 39) OR l.idLote IN (7167, 7168, 10304,  17231, 18338, 18549, 23730, 27250) AND l.registro_comision not in (7)) AND l.idStatusContratacion >= 9 AND cl.status = 1 AND l.status = 1 AND l.registro_comision in (1) AND pc.bandera in (1, 5, 55, 110, 150) AND tipo_venta IS NOT NULL AND tipo_venta IN (1,2,7)
        ORDER BY l.idLote");
        return $query;
    }

    public function getAllCommissions(){
        $this->db->query("SET LANGUAGE Español;");
        $query = $this->db->query("(SELECT DISTINCT(l.idLote), l.idStatusContratacion, l.registro_comision, cl.id_cliente, CONCAT(cl.nombre,' ',cl.apellido_paterno,' ',cl.apellido_materno) nombre_cliente, l.nombreLote, l.idStatusContratacion, res.nombreResidencial, cond.nombre as nombreCondominio, l.tipo_venta, l.referencia, vc.id_cliente AS compartida, l.totalNeto, l.totalNeto2, l.plan_enganche, plane.nombre as enganche_tipo, cl.lugar_prospeccion, pc.fecha_modificacion, convert(nvarchar, pc.fecha_modificacion, 6) date_final, pc.bandera FROM  lotes l
        INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
        INNER JOIN condominios cond ON l.idCondominio=cond.idCondominio
        INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
        LEFT JOIN pago_comision pc ON pc.id_lote = l.idLote
        LEFT JOIN opcs_x_cats plane ON plane.id_opcion= l.plan_enganche AND plane.id_catalogo = 39
        LEFT JOIN (SELECT id_cliente FROM ventas_compartidas WHERE estatus = 1) AS vc ON vc.id_cliente = cl.id_cliente
        WHERE l.idStatusContratacion BETWEEN 9 AND 15 AND cl.status = 1 AND l.status = 1 AND pc.bandera in (0,55,7,1,8) AND tipo_venta IS NOT NULL AND tipo_venta IN (1, 2))
        UNION
        (SELECT DISTINCT(l.idLote), l.idStatusContratacion, l.registro_comision, cl.id_cliente, CONCAT(cl.nombre,' ',cl.apellido_paterno,' ', cl.apellido_materno) nombre_cliente, l.nombreLote, l.idStatusContratacion, res.nombreResidencial, cond.nombre as nombreCondominio, l.tipo_venta, l.referencia, vc.id_cliente AS compartida, l.totalNeto, l.totalNeto2, l.plan_enganche, plane.nombre as enganche_tipo, cl.lugar_prospeccion, pc.fecha_modificacion, convert(nvarchar, pc.fecha_modificacion, 6) date_final, CASE WHEN l.registro_comision = '0' THEN 9 WHEN l.registro_comision = '8' THEN 8 ELSE 0 END bandera
        FROM  lotes l
        INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
        INNER JOIN condominios cond ON l.idCondominio=cond.idCondominio
        INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
        LEFT JOIN pago_comision pc ON pc.id_lote = l.idLote
        LEFT JOIN opcs_x_cats plane ON plane.id_opcion= l.plan_enganche AND plane.id_catalogo = 39
        LEFT JOIN (SELECT id_cliente FROM ventas_compartidas WHERE estatus = 1) AS vc ON vc.id_cliente = cl.id_cliente
        WHERE l.idStatusContratacion BETWEEN 9 AND 15 AND cl.status = 1 AND l.status = 1 AND l.registro_comision in (0,8) AND tipo_venta IS NOT NULL AND tipo_venta IN (1, 2)) ORDER BY l.idLote");
        return $query->result();
    }

    function update_acepta_resguardo($idsol) {
        $this->db->query("UPDATE pago_comision_ind SET estatus = 3, fecha_pago_intmex = GETDATE(), modificado_por = '".$this->session->userdata('id_usuario')."' WHERE id_pago_i IN (".$idsol.")");
        return true;
    }

    function getUsuariosRol($rol,$opc = ''){
        if($rol == 38){
          return $this->db->query("SELECT 1988 as id_usuario, 'MKTD Plaza Fernanda (León, San Luis Potosí)' as name_user  UNION  SELECT 1981 as id_usuario, 'MKTD Plaza Maricela (Querétaro, CDMX, Peninsula)' as name_user");
        }
        else{
            $complemento = 'and forma_pago != 2';
            if($opc != ''){
                $complemento = '';
            }
            return $this->db->query("SELECT id_usuario, CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) as name_user FROM usuarios WHERE estatus in (0,1,3) $complemento AND id_rol = $rol");
        }
    }

    function getUsuariosRol2($rol){
        return $this->db->query("SELECT SUM(d.monto) as monto, u.id_usuario, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) as name_user 
        FROM usuarios u inner join descuentos_universidad d on d.id_usuario = u.id_usuario
        WHERE u.id_rol = $rol AND d.estatus = 1
        GROUP BY u.id_usuario, u.nombre, u.apellido_paterno, u.apellido_materno
        ORDER BY u.nombre");
    }

    function getUsuariosRolBonos($rol){
        if($rol == 20){
            $cadena = ' in (18, 19, 20, 25, 26, 27, 28, 30, 36) ';
        } else{
            $cadena = ' in ('.$rol.') ';
        }
        return $this->db->query("SELECT id_usuario,CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) as name_user FROM usuarios WHERE id_usuario NOT IN (SELECT id_usuario FROM bonos) AND id_rol $cadena");
    }

    function getUsuariosRolDU($rol) {
        return $this->db->query("SELECT id_usuario,CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) as name_user, estatus FROM usuarios WHERE id_usuario NOT IN (SELECT id_usuario FROM descuentos_universidad) AND estatus = 1 AND id_rol = $rol ORDER BY name_user");
    }

    function getDatosComisionesHistorialRigel($proyecto,$condominio){
        $USER_SESSION = $this->session->userdata('id_usuario');
        if($condominio == 0){
                return $this->db->query("SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote, re.nombreResidencial as proyecto, co.nombre as condominio,lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, pci1.estatus, pci1.fecha_abono fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) user_names ,pci1.id_usuario, oprol.nombre as puesto, cl.personalidad_juridica, u.forma_pago, f.id_comision as factura, pac.porcentaje_abono, oxcest.nombre as estatus_actual, oxcest.id_opcion id_estatus_actual, pci1.descuento_aplicado, cl.lugar_prospeccion, lo.referencia, com.estatus
                 FROM pago_comision_ind pci1 
                 LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE (estatus in (11,3) OR descuento_aplicado = 1) 
                 GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
                 INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                 INNER JOIN lotes lo ON lo.idLote = com.id_lote
                 INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                 INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                 INNER JOIN clientes cl ON cl.idLote = lo.idLote
                 INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
                 INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado
                 INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                 INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus 
                 LEFT JOIN facturas f ON f.id_comision = com.id_comision
                 WHERE pci1.estatus IN (1, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12) AND re.idResidencial = $proyecto AND com.id_usuario = $USER_SESSION AND com.estatus in (1,8) AND oprol.id_catalogo = 1 AND oxcest.id_catalogo = 23 AND lo.status = 1 AND cl.status = 1
                 GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial, co.nombre, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, cl.personalidad_juridica, u.forma_pago, f.id_comision, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, pci1.descuento_aplicado, cl.lugar_prospeccion, lo.referencia, com.estatus ORDER BY lo.nombreLote");
            }else{
                return $this->db->query("SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote, re.nombreResidencial as proyecto, co.nombre as condominio,lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, pci1.estatus, pci1.fecha_abono fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) user_names ,pci1.id_usuario, oprol.nombre as puesto, cl.personalidad_juridica, u.forma_pago, f.id_comision as factura, pac.porcentaje_abono, oxcest.nombre as estatus_actual, oxcest.id_opcion id_estatus_actual, pci1.descuento_aplicado, cl.lugar_prospeccion, lo.referencia, com.estatus
                 FROM pago_comision_ind pci1 
                 LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE (estatus in (11,3) OR descuento_aplicado = 1) 
                 GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
                 INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                 INNER JOIN lotes lo ON lo.idLote = com.id_lote
                 INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                 INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                 INNER JOIN clientes cl ON cl.idLote = lo.idLote
                 INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
                 INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado
                 INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                 INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus 
                 LEFT JOIN facturas f ON f.id_comision = com.id_comision
                 WHERE pci1.estatus IN (1, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12) AND co.idCondominio = $condominio AND com.id_usuario = $USER_SESSION AND com.estatus in (1,8) AND oprol.id_catalogo = 1 AND oxcest.id_catalogo = 23 AND lo.status = 1 AND cl.status = 1
                 GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial, co.nombre, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, cl.personalidad_juridica, u.forma_pago, f.id_comision, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, pci1.descuento_aplicado, cl.lugar_prospeccion, lo.referencia, com.estatus ORDER BY lo.nombreLote");
            }
    }

    function getDatosComisionesRigel($proyecto,$condominio,$estado){
        $user_data = $this->session->userdata('id_usuario');
        switch($this->session->userdata('id_usuario')){
            case 2:
            case 3:
            case 1980:
            case 1981:
            case 1982:
                $sede = 2;
                break;
            case 4:
                $sede = 5;
                break;
            case 5:                           
                $sede = 3;
                break;
            case 607:
                $sede = 1;
                break;
           default:
                $sede = $this->session->userdata('id_sede');
                break;
            }
            if($condominio == 0){
                $add_fil = ' AND com.id_usuario = '.$user_data.' AND re.idResidencial = '.$proyecto.'';
            } else{
                $add_fil = ' AND com.id_usuario = '.$user_data.' AND co.idCondominio = '.$condominio.'';
            }

            return $this->db->query("(SELECT pci1.id_pago_i, pci1.id_comision,(CASE WHEN com.ooam = 2 THEN CONCAT(lo.nombreLote,'</b> <i>(',com.loteReubicado,')</i><b>') ELSE lo.nombreLote END) lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, pci1.fecha_abono fecha_creacion, pci1.id_usuario, oxcpj.nombre as pj_name, u.forma_pago, pac.porcentaje_abono, 0 as factura, 1 expediente, (CASE WHEN com.ooam = 1 THEN ' (OOAM)' ELSE oxcC.nombre END) estatus_actual, (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, pac.bonificacion, 0 lugar_prospeccion, rol.nombre as rol_generado
                    FROM pago_comision_ind pci1 
                    INNER JOIN comisiones com ON pci1.id_comision = com.id_comision 
                    INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1
                    INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                    INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                    INNER JOIN usuarios u ON u.id_usuario = com.id_usuario  
                    INNER JOIN opcs_x_cats oxcpj ON oxcpj.id_opcion = u.forma_pago AND oxcpj.id_catalogo = 16 
                    INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                    INNER JOIN opcs_x_cats oxcC ON pci1.estatus = oxcC.id_opcion and oxcC.id_catalogo = 23
                    LEFT JOIN sedes sed ON sed.id_sede in ($sede) and sed.estatus = 1
                    LEFT JOIN opcs_x_cats rol ON rol.id_opcion = com.rol_generado and rol.id_catalogo = 1
                    WHERE pci1.estatus IN ($estado) AND ( (lo.idStatusContratacion < 9 AND com.estatus IN (1,8)) OR (lo.idStatusContratacion > 8 AND com.estatus IN (8))) $add_fil
                    GROUP BY pci1.id_comision,com.ooam,com.loteReubicado, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, 
                    com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata,
                    pci1.estatus, pci1.fecha_abono, pci1.id_usuario, oxcpj.nombre, 
                    u.forma_pago,pci1.id_pago_i, pac.porcentaje_abono, oxcC.nombre, sed.impuesto, pac.bonificacion,rol.nombre)
                    UNION
                    (SELECT pci1.id_pago_i, pci1.id_comision, (CASE WHEN com.ooam = 2 THEN CONCAT(lo.nombreLote,'</b> <i>(',com.loteReubicado,')</i><b>') ELSE lo.nombreLote END) lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, pci1.fecha_abono fecha_creacion, pci1.id_usuario, oxcpj.nombre as pj_name, u.forma_pago, pac.porcentaje_abono, 0 as factura, 1 expediente, (CASE WHEN com.ooam = 1 THEN ' (OOAM)' ELSE oxcC.nombre END) estatus_actual, (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, pac.bonificacion, cl.lugar_prospeccion, rol.nombre as rol_generado
                    FROM pago_comision_ind pci1 
                    INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                    INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1
                    INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                    INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                    INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 1
                    INNER JOIN usuarios u ON u.id_usuario = com.id_usuario  
                    INNER JOIN opcs_x_cats oxcpj ON oxcpj.id_opcion = u.forma_pago AND oxcpj.id_catalogo = 16 
                    INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                    INNER JOIN opcs_x_cats oxcC ON pci1.estatus = oxcC.id_opcion and oxcC.id_catalogo = 23
                    INNER JOIN sedes sed ON sed.id_sede in ($sede) and sed.estatus = 1
                    LEFT JOIN opcs_x_cats rol ON rol.id_opcion = com.rol_generado and rol.id_catalogo = 1
                    WHERE pci1.estatus IN ($estado) AND com.estatus in (1) AND lo.idStatusContratacion > 8 $add_fil
                    GROUP BY pci1.id_comision,com.ooam,com.loteReubicado, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, 
                    com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata,
                    pci1.estatus, pci1.fecha_abono, pci1.id_usuario, oxcpj.nombre, 
                    u.forma_pago,pci1.id_pago_i, pac.porcentaje_abono, oxcC.nombre, sed.impuesto, pac.bonificacion, cl.lugar_prospeccion,rol.nombre)");
    }

    public function getDataDispersionPago() {
        $this->db->query("SET LANGUAGE Español;");

        $query = $this->db->query("SELECT DISTINCT(l.idLote), cl.id_cliente_reubicacion, res.nombreResidencial, cond.nombre as nombreCondominio,
        l.nombreLote,
        (CASE WHEN l.tipo_venta = 1 THEN 'Particular' WHEN l.tipo_venta = 2 THEN 'NORMAL' ELSE ' SIN DEFINIR' END) tipo_venta,
        (CASE WHEN l.tipo_venta = 1 THEN 'lbl-warning' WHEN l.tipo_venta = 2 THEN 'lbl-green' ELSE 'lbl-gray' END) claseTipo_venta,
        (CASE WHEN cl.proceso = 0 THEN '' ELSE oxc0.nombre END) procesoCl,
        (CASE WHEN cl.proceso = 0 THEN '' ELSE 'label lbl-violetBoots' END) colorProcesoCl,
        cl.proceso, 
        CONCAT(cl.nombre,' ',cl.apellido_paterno,' ',cl.apellido_materno) nombreCliente, vc.id_cliente AS compartida, l.idStatusContratacion, l.totalNeto2, pc.fecha_modificacion, 
        convert(nvarchar, pc.ultima_dispersion, 6) ultima_dispersion, convert(nvarchar, pc.fecha_modificacion, 6) fecha_sistema, convert(nvarchar, pc.fecha_neodata, 6) fecha_neodata, se.nombre as sede, l.referencia, cl.id_cliente, 
        CONCAT(ae.nombre, ' ', ae.apellido_paterno, ' ', ae.apellido_materno) as asesor, 
        CONCAT(co.nombre, ' ', co.apellido_paterno, ' ', co.apellido_materno) as coordinador,
        CONCAT(ge.nombre, ' ', ge.apellido_paterno, ' ', ge.apellido_materno) as gerente, 
        CONCAT(su.nombre, ' ', su.apellido_paterno, ' ', su.apellido_materno) as subdirector, (CASE WHEN re.id_usuario IN (0) OR re.id_usuario IS NULL THEN 'NA' ELSE CONCAT(re.nombre, ' ', re.apellido_paterno, ' ', re.apellido_materno) END) regional,
        CONCAT(di.nombre, ' ', di.apellido_paterno, ' ', di.apellido_materno) as director, (CASE WHEN cl.plan_comision IN (0) OR cl.plan_comision IS NULL THEN '-' ELSE pl.descripcion END) AS plan_descripcion, cl.plan_comision,cl.id_subdirector, cl.id_sede, 
        cl.id_prospecto, cl.lugar_prospeccion,(CASE WHEN pe.id_penalizacion IS NOT NULL AND pe.estatus not in (3) THEN 1 ELSE 0 END) penalizacion, pe.bandera as bandera_penalizacion, pe.id_porcentaje_penalizacion,l.referencia, pe.dias_atraso, 
        
        (CASE WHEN clr.plan_comision IN (0) OR clr.plan_comision IS NULL THEN '-' ELSE plr.descripcion END) AS descripcion_planReu, clr.plan_comision plan_comisionReu, clr.totalNeto2Cl, 

        (CASE WHEN (liquidada2-liquidada) = 0 THEN 1 ELSE 0 END) AS validaLiquidadas, 
        (CASE WHEN clr.banderaComisionCl in (0,8) AND l.registro_comision IN (9) THEN 1
		WHEN clr.banderaComisionCl = 1 AND l.registro_comision IN (9) THEN 2 
		WHEN clr.banderaComisionCl = 7 AND l.registro_comision IN (9) THEN 3 ELSE 0 END) AS bandera_dispersion, 
        l.registro_comision, cl.id_cliente_reubicacion_2, ISNULL(reub.reubicadas, 0) reubicadas, CONCAT(l.nombreLote,'</b> <i>(',lor.nombreLote,')</i><b>') as nombreLoteReub, ISNULL(ooamDis.dispersar, 0) banderaOOAM, lor.nombreLote as nombreOtro

        FROM lotes l
        INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
        INNER JOIN condominios cond ON l.idCondominio = cond.idCondominio
        INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
        INNER JOIN usuarios ae ON ae.id_usuario = cl.id_asesor
        LEFT JOIN pago_comision pc ON pc.id_lote = l.idLote AND pc.bandera in (0,100)
        LEFT JOIN (SELECT id_cliente FROM ventas_compartidas WHERE estatus = 1) AS vc ON vc.id_cliente = cl.id_cliente
        LEFT JOIN usuarios co ON co.id_usuario = cl.id_coordinador
        LEFT JOIN usuarios ge ON ge.id_usuario = cl.id_gerente
        LEFT JOIN usuarios su ON su.id_usuario = cl.id_subdirector
        LEFT JOIN usuarios re ON re.id_usuario = cl.id_regional
        LEFT JOIN usuarios di ON di.id_usuario = 2
        LEFT JOIN plan_comision pl ON pl.id_plan = cl.plan_comision
        LEFT JOIN sedes se ON se.id_sede = cl.id_sede       
        LEFT JOIN penalizaciones pe ON pe.id_lote = l.idLote AND pe.id_cliente = l.idCliente
        LEFT JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = cl.proceso AND oxc0.id_catalogo = 97
        LEFT JOIN clientes clr ON clr.id_cliente = cl.id_cliente_reubicacion_2
        LEFT JOIN plan_comision plr ON plr.id_plan = clr.plan_comision
        LEFT JOIN lotes lor ON lor.idLote = clr.idLote
        LEFT JOIN (select COUNT(*) liquidada, id_lote FROM comisiones WHERE liquidada = 1 GROUP BY id_lote) liq ON liq.id_lote = l.idLote
		LEFT JOIN (select COUNT(*) liquidada2, id_lote FROM comisiones WHERE ooam = 2 GROUP BY id_lote) liq2 ON liq2.id_lote = l.idLote
        LEFT JOIN (select COUNT(*) reubicadas, idCliente FROM comisionesReubicadas GROUP BY idCliente) reub ON reub.idCliente = clr.id_cliente
        LEFT JOIN (select COUNT(*) dispersar, id_lote FROM comisiones WHERE ooam = 1 GROUP BY id_lote) ooamDis ON ooamDis.id_lote = l.idLote
        WHERE (l.idLote IN (13969,7167,7168,10304,17231,18338,18549,23730,27250,31850,32573,73591) 
        AND l.registro_comision not in (7) 
        AND pc.bandera in (0)) OR (l.idStatusContratacion >= 9 
        AND cl.status = 1 
        AND l.status = 1 
        AND (l.registro_comision in (0,8,2,9) or (l.registro_comision in (1,8,9) 
        AND pc.bandera in (0))) 
        AND (l.tipo_venta IS NULL OR l.tipo_venta IN (0,1,2)) 
        AND cl.fechaApartado >= '2020-03-01' 
        AND (cl.id_subdirector IS NOT NULL AND cl.id_subdirector != '' AND cl.id_subdirector != 0 )

        AND ISNULL(l.totalNeto2, 0) > 0) ORDER BY l.idLote");

        return $query;
    }

    public function update_enganche_comision($idLote, $opcionSelect) {
        $id_user_Vl = $this->session->userdata('id_usuario');
        $this->db->query("INSERT INTO historial_comisiones VALUES (0, ".$id_user_Vl.", GETDATE(), 2, 'SE AGREGÓ PLAN DE ENGANCHE ".$opcionSelect.' - '.$idLote." ','".$this->session->userdata('id_usuario')."')");
        return $this->db->query("UPDATE lotes SET plan_enganche = ".$opcionSelect." WHERE idLote IN (".$idLote.")");
    }

    public function getPlanesEnganche($idLote){
        $var_review = $this->db->query("SELECT c.lugar_prospeccion FROM lotes l INNER JOIN clientes c ON c.idLote = l.idLote WHERE c.status = 1 AND l.status = 1 AND l.idLote = $idLote");
        switch($var_review->row()->lugar_prospeccion){
            case '6':
                return $this->db->query("SELECT op1.id_opcion id_usuario, op1.nombre as name_user FROM  opcs_x_cats op1 WHERE op1.id_catalogo = 39 AND op1.id_opcion in (13, 14, 15, 16, 17, 18)");
                break;
            case '12':
                return $this->db->query("SELECT op1.id_opcion id_usuario, op1.nombre as name_user FROM  opcs_x_cats op1 WHERE op1.id_catalogo = 39 AND op1.id_opcion in (2, 4, 6, 9, 10, 12)");
                break;
            default:
                return $this->db->query("SELECT op1.id_opcion id_usuario, op1.nombre as name_user FROM  opcs_x_cats op1 WHERE op1.id_catalogo = 39 AND op1.id_opcion in (1, 3, 5, 7, 8, 11)");
            break;
        }
    }

    public function getValNeodata(){
        return $this->db->query("SELECT op1.id_opcion id_usuario, op1.nombre as name_user FROM  opcs_x_cats op1 WHERE op1.id_catalogo = 39 ");

    }

    public function getDatosConfirmarPago(){ 
        ini_set('memory_limit', -1);
        $query = $this->db->query("SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, pci1.estatus, pci1.fecha_abono fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) user_names ,pci1.id_usuario, oprol.nombre as puesto, cl.personalidad_juridica, u.forma_pago, f.id_comision as factura, pac.porcentaje_abono 
        FROM pago_comision_ind pci1 
        LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE (estatus in (11,3) OR descuento_aplicado = 1) 
        GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
        INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
        INNER JOIN lotes lo ON lo.idLote = com.id_lote
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        INNER JOIN clientes cl ON cl.idLote = lo.idLote
        INNER JOIN porcentajes_comisiones pc ON pc.relacion_prospeccion = cl.lugar_prospeccion
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
        INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado
        INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
        LEFT JOIN facturas f ON f.id_comision = com.id_comision
        WHERE pci1.estatus = 9 AND com.estatus in (1,8) AND oprol.id_catalogo = 1 
        GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, cl.personalidad_juridica, u.forma_pago, f.id_comision, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre ORDER BY lo.nombreLote");
        return $query->result();
    }

    function getDatosHistorialPago($anio,$proyecto) {
        ini_set('memory_limit', -1);
        $filtro_00 = ' AND re.idResidencial = '.$proyecto.' AND YEAR(pci1.fecha_abono) = '.$anio.' ';
        $filtro_estatus = ' pci1.estatus IN (0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,51,52,88,16,17,41,42,18,19,20,21,22,23,24,25,26,27,28,29) ';
        switch ($this->session->userdata('id_rol')) {
            case 1:
            case 2:
            case 3:
            case 7:
            case 9:
                $filtro_02 = ' AND com.id_usuario = '.$this->session->userdata('id_usuario').' '.$filtro_00;
                break;
            case 31:
                $filtro_02 = ' '.$filtro_00;
                $filtro_estatus = ' pci1.estatus IN (8,11,88) AND pci1.pago_neodata > 0 AND pci1.descuento_aplicado != 1 ';
                break;
            default:
                $filtro_02 = ' '.$filtro_00;
                break;
        }
        return $this->db->query("SELECT pci1.id_pago_i, pci1.id_comision, (CASE WHEN com.ooam = 2 THEN CONCAT(lo.nombreLote,' <i>(',com.loteReubicado,')</i>') ELSE lo.nombreLote END) nombreLote,
                 re.nombreResidencial as proyecto, co.nombre as condominio,lo.totalNeto2 precio_lote, com.comision_total, 

        com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, pci1.estatus, pci1.fecha_abono fecha_creacion, 
        CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) user_names ,pci1.id_usuario, CASE WHEN cl.estructura = 1 THEN UPPER(oprol2.nombre) ELSE UPPER(oprol.nombre) END as puesto, 
        (CASE WHEN com.ooam = 1 THEN  CONCAT(oxcest.nombre,' (OOAM)') ELSE oxcest.nombre END) estatus_actual, oxcest.id_opcion id_estatus_actual, 
        pci1.descuento_aplicado, (CASE WHEN cl.lugar_prospeccion IS NULL THEN 0 ELSE cl.lugar_prospeccion END) lugar_prospeccion, lo.referencia, pac.bonificacion, u.estatus as activo, 
        (CASE WHEN pe.id_penalizacion IS NOT NULL THEN 1 ELSE 0 END) penalizacion, oxcest.color 
        FROM pago_comision_ind pci1 
        LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision 
        FROM pago_comision_ind WHERE (estatus in (11,3) OR descuento_aplicado = 1) 
        GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
        INNER JOIN comisiones com ON pci1.id_comision = com.id_comision and com.estatus = 1
        INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
        LEFT JOIN clientes cl ON cl.id_cliente = lo.idCliente AND cl.status = 1 AND lo.idStatusContratacion > 8 AND com.estatus = 1
        INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
        INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
        INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23
        LEFT JOIN penalizaciones pe ON pe.id_lote = lo.idLote AND pe.id_cliente = lo.idCliente
        LEFT JOIN opcs_x_cats oprol2 ON oprol2.id_opcion = com.rol_generado AND oprol2.id_catalogo = 83
        WHERE (($filtro_estatus) OR (pci1.estatus = 0 AND pci1.descuento_aplicado = 1)) $filtro_02 
        GROUP BY pci1.id_comision,com.ooam,com.loteReubicado, lo.nombreLote, re.nombreResidencial, co.nombre, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, pci1.id_pago_i, u.nombre, u.apellido_paterno, u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, pci1.descuento_aplicado, cl.lugar_prospeccion, lo.referencia, com.estatus, pac.bonificacion, u.estatus,pe.id_penalizacion, oxcest.color, cl.estructura, oprol2.nombre ORDER BY lo.nombreLote");
    }

    function getDatosHistorialCancelacion($anio,$proyecto) {
        ini_set('memory_limit', -1);       
        $filtro_00 = ' AND re.idResidencial = '.$proyecto.' AND YEAR(pci1.fecha_abono) = '.$anio.' ';
        $filtro_estatus = ' pci1.estatus IN (0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,51,52,88,16,17,41,42,18,19,20,21,22,23,24,25,26,27,28) ';
        switch ($this->session->userdata('id_rol')) {
            case 1:
            case 2:
            case 3:
            case 7:
            case 9:
                $filtro_02 = ' AND com.id_usuario = '.$this->session->userdata('id_usuario').' '.$filtro_00;
                break;
            case 31:
                $filtro_02 = ' '.$filtro_00;
                $filtro_estatus = ' pci1.estatus IN (8,11,88) AND pci1.pago_neodata > 0 AND pci1.descuento_aplicado != 1 ';
                break;
            default:
                $filtro_02 = ' '.$filtro_00;
                break;
        }
        return $this->db->query("SELECT pci1.id_pago_i, pci1.id_comision, (CASE WHEN com.ooam = 2 THEN CONCAT(lo.nombreLote,' <i>(',com.loteReubicado,')</i>') ELSE lo.nombreLote END) nombreLote,
         re.nombreResidencial as proyecto, co.nombre as condominio,lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, 
        pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, pci1.estatus, pci1.fecha_abono fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) user_names,
        pci1.id_usuario, CASE WHEN cl.estructura = 1 THEN UPPER(oprol2.nombre) ELSE UPPER(oprol.nombre) END as puesto, (CASE WHEN com.ooam = 1 THEN  CONCAT(oxcest.nombre,' (OOAM)') ELSE oxcest.nombre END) estatus_actual, oxcest.id_opcion id_estatus_actual, pci1.descuento_aplicado,
        (CASE WHEN cl.lugar_prospeccion IS NULL THEN 0 ELSE cl.lugar_prospeccion END) lugar_prospeccion, lo.referencia, pac.bonificacion, u.estatus as activo, (CASE WHEN pe.id_penalizacion IS NOT NULL THEN 1 ELSE 0 END) penalizacion, oxcest.color 
        FROM pago_comision_ind pci1 
        LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision 
        FROM pago_comision_ind WHERE (estatus in (11,3) OR descuento_aplicado = 1) 
        GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
        INNER JOIN comisiones com ON pci1.id_comision = com.id_comision and com.estatus = 8
        INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
        LEFT JOIN clientes cl ON cl.id_cliente = lo.idCliente AND cl.status = 1 AND lo.idStatusContratacion > 8 AND com.estatus = 1
        INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
        INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
        INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23
        LEFT JOIN penalizaciones pe ON pe.id_lote = lo.idLote AND pe.id_cliente = lo.idCliente
        LEFT JOIN opcs_x_cats oprol2 ON oprol2.id_opcion = com.rol_generado AND oprol2.id_catalogo = 83
        WHERE (($filtro_estatus) OR (pci1.estatus = 0 AND pci1.descuento_aplicado = 1)) $filtro_02 
        GROUP BY pci1.id_comision,com.ooam,com.loteReubicado, lo.nombreLote, re.nombreResidencial, co.nombre, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, pci1.estatus, pci1.fecha_abono, 
        pci1.id_usuario, pci1.id_pago_i, u.nombre, u.apellido_paterno, u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, pci1.descuento_aplicado, cl.lugar_prospeccion, lo.referencia, com.estatus, pac.bonificacion, 
        u.estatus,pe.id_penalizacion, oxcest.color, cl.estructura, oprol2.nombre ORDER BY lo.nombreLote");
    }


    function getDatosHistorialPagoRP($id_usuario){
         $filtro_02 = ' AND com.id_usuario = '.$id_usuario;
         $filtro_estatus = ' pci1.estatus IN (1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 51, 52, 88,16,17, 41,42) ';
         return $this->db->query("(SELECT pci1.id_pago_i, pci1.id_comision, (CASE WHEN com.ooam = 2 THEN CONCAT(lo.nombreLote,' <i>(',com.loteReubicado,')</i>') ELSE lo.nombreLote END) nombreLote, 
         re.nombreResidencial as proyecto, co.nombre as condominio,lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, pci1.estatus, pci1.fecha_abono fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) user_names ,pci1.id_usuario, UPPER(oprol.nombre) as puesto, (CASE WHEN com.ooam = 1 THEN  CONCAT(oxcest.nombre,' (OOAM)') ELSE oxcest.nombre END) estatus_actual, oxcest.id_opcion id_estatus_actual, pci1.descuento_aplicado, 0 lugar_prospeccion, lo.referencia, pac.bonificacion, u.estatus as activo
         FROM pago_comision_ind pci1 
         LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE (estatus in (11,3) OR descuento_aplicado = 1) 
         GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
         INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
         INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
         INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
         INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
         INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
         INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
         INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
         INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23
         WHERE (($filtro_estatus) OR (pci1.estatus = 0 AND pci1.descuento_aplicado = 1) ) 
         AND ( (lo.idStatusContratacion < 9 AND com.estatus IN (1,8)) OR (lo.idStatusContratacion > 8 AND com.estatus IN (8))) $filtro_02
         GROUP BY pci1.id_comision,com.ooam,com.loteReubicado, lo.nombreLote, re.nombreResidencial, co.nombre, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, 
         pci2.abono_pagado, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, pci1.id_pago_i, u.nombre,
         u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, pci1.descuento_aplicado, lo.referencia, com.estatus, pac.bonificacion, u.estatus)
        UNION 
         (SELECT pci1.id_pago_i, pci1.id_comision,(CASE WHEN com.ooam = 2 THEN CONCAT(lo.nombreLote,' <i>(',com.loteReubicado,')</i>') ELSE lo.nombreLote END) nombreLote, re.nombreResidencial as proyecto, co.nombre as condominio,lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, pci1.estatus, pci1.fecha_abono fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) user_names ,pci1.id_usuario, UPPER(oprol.nombre) as puesto, (CASE WHEN com.ooam = 1 THEN  CONCAT(oxcest.nombre,' (OOAM)') ELSE oxcest.nombre END) estatus_actual, oxcest.id_opcion id_estatus_actual, pci1.descuento_aplicado, cl.lugar_prospeccion, lo.referencia, pac.bonificacion, u.estatus as activo
         FROM pago_comision_ind pci1 
         LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE (estatus in (11,3) OR descuento_aplicado = 1) 
         GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
         INNER JOIN comisiones com ON pci1.id_comision = com.id_comision AND com.estatus in (1)
         INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
         INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
         INNER JOIN residenciales re ON re.idResidencial = co.idResidencial 
         INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 1
         INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
         INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
         INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
         INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23
         WHERE (($filtro_estatus) OR (pci1.estatus = 0 AND pci1.descuento_aplicado = 1) ) 
         AND lo.idStatusContratacion > 8 
         $filtro_02
         GROUP BY pci1.id_comision,com.ooam,com.loteReubicado, lo.nombreLote, re.nombreResidencial, co.nombre, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, pci1.id_pago_i, u.nombre, u.apellido_paterno, u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, pci1.descuento_aplicado, cl.lugar_prospeccion, lo.referencia, com.estatus, pac.bonificacion, u.estatus) ORDER BY nombreLote");
    }
    
    function getDatosHistorialPagoM($proyecto,$condominio){
        if($condominio == 0){
            $filtro_00 = ' AND re.idResidencial = '.$proyecto.' ';
        } else{
            $filtro_00 = ' AND co.idCondominio = '.$condominio.' ';
        }
        $filtro_estatus = ' pci1.estatus IN (1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 51, 52, 88,16,17, 41,42) ';

        switch ($this->session->userdata('id_rol')) {
            case 28:
            case 18:
                $filtro_02 = ' AND com.id_usuario = 4394 '.$filtro_00;
            break;
            default:
                $filtro_02 = ' '.$filtro_00;
             break;
         }
 
         return $this->db->query("(SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote, re.nombreResidencial as proyecto, co.nombre as condominio,lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, pci1.estatus, pci1.fecha_abono fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) user_names ,pci1.id_usuario, oprol.nombre as puesto, (CASE WHEN com.ooam = 1 THEN  CONCAT(oxcest.nombre,' (OOAM)') ELSE oxcest.nombre END) estatus_actual, oxcest.id_opcion id_estatus_actual, pci1.descuento_aplicado, 0 lugar_prospeccion, lo.referencia, pac.bonificacion, u.estatus as activo, se.nombre as sede_plaza, s2.nombre as sede_pplaza
         FROM pago_comision_ind pci1 
         LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE (estatus in (11,3) OR descuento_aplicado = 1) 
         GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
         INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
         INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
         INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
         INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
         INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
         INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
         INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
         INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23
         LEFT JOIN sedes se ON se.id_sede = lo.ubicacion_dos
         LEFT JOIN sedes s2 ON s2.id_sede = lo.ubicacion_dos
         WHERE (($filtro_estatus) OR (pci1.estatus = 0 AND pci1.descuento_aplicado = 1) ) 
         AND ( (lo.idStatusContratacion < 9 AND com.estatus IN (1,8)) OR (lo.idStatusContratacion > 8 AND com.estatus IN (8))) $filtro_02
         GROUP BY pci1.id_comision,com.ooam, lo.nombreLote, re.nombreResidencial, co.nombre, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, pci1.id_pago_i, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, pci1.descuento_aplicado, lo.referencia, pac.bonificacion, u.estatus,se.nombre, s2.nombre)
         UNION 
         (SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote, re.nombreResidencial as proyecto, co.nombre as condominio,lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, pci1.estatus, pci1.fecha_abono fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) user_names ,pci1.id_usuario, oprol.nombre as puesto, (CASE WHEN com.ooam = 1 THEN  CONCAT(oxcest.nombre,' (OOAM)') ELSE oxcest.nombre END) estatus_actual, oxcest.id_opcion id_estatus_actual, pci1.descuento_aplicado, cl.lugar_prospeccion, lo.referencia, pac.bonificacion, u.estatus as activo,se.nombre as sede_plaza, s2.nombre as sede_pplaza
         FROM pago_comision_ind pci1 
         LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE (estatus in (11,3) OR descuento_aplicado = 1) 
         GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
         INNER JOIN comisiones com ON pci1.id_comision = com.id_comision AND com.estatus in (1)
         INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
         INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
         INNER JOIN residenciales re ON re.idResidencial = co.idResidencial 
         INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 1
         INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
         INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
         INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
         INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23
         LEFT JOIN sedes se ON se.id_sede = lo.ubicacion_dos
         LEFT JOIN sedes s2 ON s2.id_sede = lo.ubicacion_dos
         WHERE (($filtro_estatus) OR (pci1.estatus = 0 AND pci1.descuento_aplicado = 1) ) AND lo.idStatusContratacion > 8 $filtro_02
         GROUP BY pci1.id_comision,com.ooam, lo.nombreLote, re.nombreResidencial, co.nombre, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, pci1.id_pago_i, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, pci1.descuento_aplicado, cl.lugar_prospeccion, lo.referencia, pac.bonificacion, u.estatus, se.nombre, s2.nombre) ORDER BY lo.nombreLote");   
    }

    function getDatosCobranzaRanking($a,$b){ 
        $cadena = '';
        if($a == 0){ 
            $cadena = '';
        } else{
            $cadena = "AND MONTH(cl.fechaApartado)=".$a;
        }
        
        if( $this->session->userdata('id_usuario') == 2042 ){
            $filtro = " AND (ase.id_sede like '%2%' OR ase.id_sede like '%3%'OR ase.id_sede like '%4%'OR ase.id_sede like '%6%') ";
        } else{
            $filtro = "  AND (ase.id_sede like '%1%' OR ase.id_sede like '%5%') ";
        }
        
        $this->db->query("SET LANGUAGE Español;");
        $query = $this->db->query("SELECT cmktd.idc_mktd, l.idLote, res.nombreResidencial, con.nombre AS condominio, l.nombreLote, l.totalNeto2, cl.fechaApartado, convert(nvarchar, cl.fechaApartado, 6) mes, CONCAT(cl.nombre,' ',cl.apellido_paterno,' ',cl.apellido_materno) AS cliente, se.nombre as plaza, CONCAT(ase.nombre,' ',ase.apellido_paterno,' ',ase.apellido_materno) AS asesor, CONCAT(ger.nombre,' ',ger.apellido_paterno,' ',ger.apellido_materno) AS gerente, stl.nombre as estatus,
                CASE WHEN pro.otro_lugar = '0' THEN 'Sin especificar' WHEN pro.otro_lugar IS NULL THEN 'Sin especificar' ELSE pro.otro_lugar END as evidencia, cl.status, cl.id_cliente,l.idStatusContratacion,l.idLote,rm.precio, sd1.nombre as sd1,sd2.nombre as sd2, com.comision_total, pci2.abono_pagado, cmktd.idc_mktd, pc.bandera, pci3.abono_dispersado, convert(nvarchar, pc.fecha_modificacion, 6) date_final
                FROM lotes l
                INNER JOIN clientes cl ON cl.id_cliente = l.idCliente AND cl.status = 1 AND lugar_prospeccion = 6
                INNER JOIN condominios con ON con.idCondominio = l.idCondominio
                INNER JOIN residenciales res ON res.idResidencial = con.idResidencial
                INNER JOIN statuslote stl ON stl.idStatusLote = l.idStatusLote
                INNER JOIN usuarios ase ON ase.id_usuario = cl.id_asesor
                INNER JOIN sedes se ON se.id_sede = ase.id_sede $cadena
                LEFT JOIN comisiones com ON com.id_lote = l.idLote AND com.estatus = 1 AND rol_generado = 38
                LEFT JOIN pago_comision pc ON pc.id_lote = l.idLote
                LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE (estatus in (11,3) OR descuento_aplicado = 1) GROUP BY id_comision) pci2 ON com.id_comision = pci2.id_comision
                LEFT JOIN (SELECT SUM(abono_neodata) abono_dispersado, id_comision FROM pago_comision_ind GROUP BY id_comision) pci3 ON com.id_comision = pci3.id_comision
                LEFT JOIN usuarios ger ON ger.id_usuario = cl.id_gerente
                LEFT JOIN prospectos pro ON pro.id_prospecto = cl.id_prospecto
                LEFT JOIN reportes_marketing rm on rm.id_lote=l.idLote
                LEFT join compartidas_mktd cmktd on l.idLote=cmktd.id_lote
                LEFT join sedes sd1 on sd1.id_sede=cmktd.sede1
                LEFT join sedes sd2 on sd2.id_sede=cmktd.sede2
                WHERE l.status = 1 AND year(cl.fechaApartado) = $b $filtro GROUP BY cmktd.idc_mktd, l.idLote, res.nombreResidencial, con.nombre, l.nombreLote, l.totalNeto2, cl.fechaApartado, cl.fechaApartado, cl.nombre, cl.apellido_paterno, cl.apellido_materno, se.nombre, ase.nombre, ase.apellido_paterno, ase.apellido_materno, ger.nombre, ger.apellido_paterno, ger.apellido_materno, stl.nombre, pro.otro_lugar, cl.status, cl.id_cliente, l.idStatusContratacion, l.idLote, rm.precio, sd1.nombre, sd2.nombre, com.comision_total, pci2.abono_pagado, cmktd.idc_mktd, pc.bandera, pci3.abono_dispersado, pc.fecha_modificacion");
                return $query->result();
    }
    
    function getDatosCobranzaReporte($a,$b){ 
        $filtroPau = '';
        $filtroPau2 = '';
        $cadena = '';
        if($a == 0){
            $cadena = '';
        }else{
            $cadena = "AND MONTH(cl.fechaApartado)=".$a;
        }
        
        if( $this->session->userdata('id_usuario') == 2042 ){
            $filtro = " AND (ase.id_sede like '%2%' OR ase.id_sede like '%3%'OR ase.id_sede like '%4%'OR ase.id_sede like '%6%') ";
        } else{
            $filtro = "  AND (ase.id_sede like '%1%' OR ase.id_sede like '%5%') ";
            $filtroPau = 'CAST(ase.id_sede AS VARCHAR(MAX)) AS id_sede,';
            $filtroPau2 = 'CAST(ase.id_sede AS VARCHAR(MAX)),';
        }
        
        $this->db->query("SET LANGUAGE Español;");
        $query = $this->db->query("SELECT $filtroPau cmktd.idc_mktd,l.idLote, FORMAT(l.total, 'C') total_sindesc, res.nombreResidencial, con.nombre AS condominio, l.nombreLote, l.totalNeto2, cl.fechaApartado, convert(nvarchar, cl.fechaApartado, 6) mes, CONCAT(cl.nombre,' ',cl.apellido_paterno,' ',cl.apellido_materno) AS cliente, se.nombre as plaza, CONCAT(ase.nombre,' ',ase.apellido_paterno,' ',ase.apellido_materno) AS asesor, CONCAT(ger.nombre,' ',ger.apellido_paterno,' ',ger.apellido_materno) AS gerente, stl.nombre as estatus, l.referencia, 
                CASE WHEN pro.otro_lugar = '0' THEN 'Sin especificar' WHEN pro.otro_lugar IS NULL THEN 'Sin especificar' ELSE pro.otro_lugar END as evidencia, cl.status, cl.id_cliente,l.idStatusContratacion,l.idLote,rm.precio, sd1.nombre as sd1,sd2.nombre as sd2, com.comision_total, pci2.abono_pagado, cmktd.idc_mktd, pc.bandera, pci3.abono_dispersado, convert(nvarchar, pc.fecha_modificacion, 6) date_final, cl.descuento_mdb, REPLACE(oxc.nombre, ' (especificar)', '') lugar_prospeccion
                FROM lotes l
                INNER JOIN clientes cl ON cl.id_cliente = l.idCliente AND cl.status = 1 AND (cl.lugar_prospeccion = 6 OR cl.descuento_mdb = 1)
                INNER JOIN condominios con ON con.idCondominio = l.idCondominio
                INNER JOIN residenciales res ON res.idResidencial = con.idResidencial
                INNER JOIN statuslote stl ON stl.idStatusLote = l.idStatusLote
                INNER JOIN usuarios ase ON ase.id_usuario = cl.id_asesor
                INNER JOIN sedes se ON se.id_sede = ase.id_sede $cadena
                LEFT JOIN comisiones com ON com.id_lote = l.idLote AND com.estatus = 1 AND rol_generado = 38
                LEFT JOIN pago_comision pc ON pc.id_lote = l.idLote
                LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE (estatus in (11,3) OR descuento_aplicado = 1) GROUP BY id_comision) pci2 ON com.id_comision = pci2.id_comision
                LEFT JOIN (SELECT SUM(abono_neodata) abono_dispersado, id_comision FROM pago_comision_ind GROUP BY id_comision) pci3 ON com.id_comision = pci3.id_comision
                LEFT JOIN usuarios ger ON ger.id_usuario = cl.id_gerente
                LEFT JOIN prospectos pro ON pro.id_prospecto = cl.id_prospecto
                LEFT JOIN reportes_marketing rm on rm.id_lote=l.idLote
                LEFT join compartidas_mktd cmktd on l.idLote=cmktd.id_lote
                LEFT join sedes sd1 on sd1.id_sede=cmktd.sede1
                LEFT join sedes sd2 on sd2.id_sede=cmktd.sede2
                LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = cl.lugar_prospeccion AND oxc.id_catalogo = 9
                WHERE l.status = 1 AND year(cl.fechaApartado) = $b $filtro GROUP BY $filtroPau2 cmktd.idc_mktd, l.idLote, res.nombreResidencial, con.nombre, l.nombreLote, l.totalNeto2, cl.fechaApartado, cl.fechaApartado, cl.nombre, cl.apellido_paterno, cl.apellido_materno, se.nombre, ase.nombre, ase.apellido_paterno, ase.apellido_materno, ger.nombre, ger.apellido_paterno, ger.apellido_materno, stl.nombre, pro.otro_lugar, cl.status, cl.id_cliente, l.idStatusContratacion, l.idLote, rm.precio, sd1.nombre, sd2.nombre, com.comision_total, pci2.abono_pagado, cmktd.idc_mktd, pc.bandera, pci3.abono_dispersado, pc.fecha_modificacion, l.referencia, l.total, cl.descuento_mdb, REPLACE(oxc.nombre, ' (especificar)', '')");
                return $query->result();       
    }
    
    function getDatosCobranzaDimamic($a,$b,$c,$d){
        if($a != 0 && $b != 0 && $c == 0 && $d == 0){
            $filtro = " AND MONTH(cl.fechaApartado) = $a AND year(cl.fechaApartado) = $b ";
        }else if($a != 0 && $b != 0 && $c != 0 && $d == 0){
            $filtro = " AND MONTH(cl.fechaApartado) = $a AND year(cl.fechaApartado) = $b AND ase.id_sede like '%".$c."'";
        }else if($a != 0 && $b != 0 && $c != 0 && $d != 0){
            $filtro = " AND MONTH(cl.fechaApartado) = $a AND year(cl.fechaApartado) = $b AND ase.id_sede like '%".$c."' AND cl.id_gerente = $d ";
        }else {
            $filtro = " ";
        }
        
        return $this->db->query("(SELECT COUNT(l.idLote) lotes_vendidos, CASE WHEN SUM(l.totalNeto2) = '0' THEN 0 WHEN SUM(l.totalNeto2) IS NULL THEN 0 ELSE  SUM(l.totalNeto2) END as monto_vendido, ase.id_usuario, cl.status,
                CONCAT(ase.nombre,' ',ase.apellido_paterno,' ',ase.apellido_materno) as asesor,
                CONCAT(ger.nombre,' ',ger.apellido_paterno,' ',ger.apellido_materno) as gerente,se.nombre
                FROM lotes l
                INNER JOIN clientes cl ON cl.id_cliente = l.idCliente AND cl.status = 1 AND lugar_prospeccion = 6
                INNER JOIN condominios con ON con.idCondominio = l.idCondominio
                INNER JOIN residenciales res ON res.idResidencial = con.idResidencial
                INNER JOIN statuslote stl ON stl.idStatusLote = l.idStatusLote
                INNER JOIN usuarios ase ON ase.id_usuario = cl.id_asesor
                INNER JOIN sedes se ON se.id_sede = ase.id_sede
                LEFT JOIN usuarios ger ON ger.id_usuario = cl.id_gerente
                LEFT JOIN prospectos pro ON pro.id_prospecto = cl.id_prospecto
                WHERE l.status = 1 $filtro
                GROUP BY ase.id_usuario, ase.nombre, ase.apellido_paterno, ase.apellido_materno, ger.nombre, 
                ger.apellido_paterno, ger.apellido_materno,se.nombre, cl.status
                HAVING COUNT(l.idLote) > 0)
                UNION
                (SELECT COUNT(l.idLote) lotes_vendidos, CASE WHEN SUM(l.totalNeto2) = '0' THEN 0 WHEN SUM(l.totalNeto2) IS NULL THEN 
                0 ELSE  SUM(l.totalNeto2) END as monto_vendido, ase.id_usuario, cl.status,
                CONCAT(ase.nombre,' ',ase.apellido_paterno,' ',ase.apellido_materno) as asesor,
                CONCAT(ger.nombre,' ',ger.apellido_paterno,' ',ger.apellido_materno) as gerente,se.nombre
                FROM lotes l
                INNER JOIN clientes cl ON cl.idLote = l.idLote AND cl.status = 0 AND lugar_prospeccion = 6
                INNER JOIN condominios con ON con.idCondominio = l.idCondominio
                INNER JOIN residenciales res ON res.idResidencial = con.idResidencial
                INNER JOIN statuslote stl ON stl.idStatusLote = l.idStatusLote
                INNER JOIN usuarios ase ON ase.id_usuario = cl.id_asesor
                INNER JOIN sedes se ON se.id_sede = ase.id_sede
                LEFT JOIN usuarios ger ON ger.id_usuario = cl.id_gerente
                LEFT JOIN prospectos pro ON pro.id_prospecto = cl.id_prospecto
                WHERE l.status = 1 $filtro
                GROUP BY ase.id_usuario, ase.nombre, ase.apellido_paterno, ase.apellido_materno, ger.nombre, 
                ger.apellido_paterno, ger.apellido_materno,se.nombre, cl.status
                HAVING COUNT(l.idLote) > 0)");
    }

    function getDatosCobranzaIndicador($a,$b){
        $cadena = '';
        if($a == 0){
            $cadena = ' AND year(cl.fechaApartado) = '.$b.' ';
        }else{
            $cadena = ' AND MONTH(cl.fechaApartado) =  '.$a.' AND year(cl.fechaApartado) = '.$b.' ';
        }
        return $this->db->query("(SELECT COUNT(l.idLote) lotes_vendidos, CASE WHEN SUM(l.totalNeto2) = '0' THEN 0 WHEN SUM(l.totalNeto2) IS NULL THEN 0 ELSE SUM(l.totalNeto2) END as monto_vendido, cl.status, se.nombre
        FROM lotes l
        INNER JOIN clientes cl ON cl.id_cliente = l.idCliente AND cl.status = 1 AND cl.lugar_prospeccion = 6
        INNER JOIN sedes se ON se.id_sede = l.ubicacion
        WHERE l.status = 1 AND MONTH(cl.fechaApartado) = $a AND year(cl.fechaApartado) = $b
        GROUP BY se.nombre, cl.status
        HAVING COUNT(l.idLote) > 0)
        UNION
        (SELECT COUNT(l.idLote) lotes_vendidos, CASE WHEN SUM(l.totalNeto2) = '0' THEN 0 WHEN SUM(l.totalNeto2) IS NULL THEN 0 ELSE SUM(l.totalNeto2) END as monto_vendido, cl.status, se.nombre
        FROM lotes l
        INNER JOIN clientes cl ON cl.idLote = l.idLote AND cl.status = 0 AND cl.lugar_prospeccion = 6
        INNER JOIN sedes se ON se.id_sede = l.ubicacion
        WHERE l.status = 1 $cadena
        GROUP BY se.nombre, cl.status
        HAVING COUNT(l.idLote) > 0)");
    }
    
    function getDatosComisionesNuevasNivel2(){
        return $this->db->query("SELECT pcm.id_pago_mk, pcm.fecha_abono, pcm.estatus, pcm.abono_marketing, pcm.pago_mktd, CONCAT(us.nombre,' ',us.apellido_paterno,' ',us.apellido_materno) AS colaborador, oxc.nombre as puesto, 3 as forma_pago, 1 as expediente
        FROM pago_comision_mktd pcm
        INNER JOIN usuarios us ON us.id_usuario = pcm.id_usuario
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = us.id_rol
        WHERE oxc.id_catalogo = 1 AND pcm.estatus = 1 AND pcm.id_usuario =  ".$this->session->userdata('id_usuario')."");
    }

    function getDatosComisionesRecibidasNivel2(){
        return $this->db->query("SELECT pcm.id_pago_mk, pcm.fecha_abono, pcm.estatus, pcm.abono_marketing, pcm.pago_mktd,
        CONCAT(us.nombre,' ',us.apellido_paterno,' ',us.apellido_materno) AS colaborador, oxc.nombre as puesto, 3 as forma_pago, 1 as expediente
        FROM pago_comision_mktd pcm
        INNER JOIN usuarios us ON us.id_usuario = pcm.id_usuario
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = us.id_rol
        WHERE oxc.id_catalogo = 1 AND pcm.estatus = 4 AND pcm.id_usuario =  ".$this->session->userdata('id_usuario')."");
    }
                
    function getDatosComisionesHistorialNivel2(){
        $this->db->query("SELECT pcm.id_pago_mk, pcm.fecha_abono, pcm.estatus, pcm.abono_marketing, pcm.pago_mktd,
        CONCAT(us.nombre,' ',us.apellido_paterno,' ',us.apellido_materno) AS colaborador,
        oxc.nombre as puesto
        FROM pago_comision_mktd pcm
        INNER JOIN usuarios us ON us.id_usuario = pcm.id_usuario
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = us.id_rol
        WHERE oxc.id_catalogo = 1 AND pcm.estatus = 11 AND pcm.id_usuario =  ".$this->session->userdata('id_usuario')."");
    }

    function getDatosComisionesAsesor($estado){
        $user_data = $this->session->userdata('id_usuario');
        $sede = $this->session->userdata('id_sede');
        
        return $this->db->query("(SELECT pci1.id_pago_i, pci1.id_comision, (CASE WHEN com.ooam = 2 THEN CONCAT(lo.nombreLote,' <i>(',com.loteReubicado,')</i>') ELSE lo.nombreLote END) lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, pci1.fecha_abono fecha_creacion, pci1.id_usuario, oxcpj.nombre as pj_name, u.forma_pago, pac.porcentaje_abono, 0 as factura, 1 expediente, (CASE WHEN com.ooam = 1 THEN ' (OOAM)' ELSE '' END) estatus_actual, (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, pac.bonificacion, 0 lugar_prospeccion,
            pci1.fecha_abono, opt.fecha_creacion as fecha_opinion, opt.estatus as estatus_opinion
            FROM pago_comision_ind pci1 
            INNER JOIN comisiones com ON pci1.id_comision = com.id_comision 
            INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
            INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
            INNER JOIN usuarios u ON u.id_usuario = com.id_usuario  
            INNER JOIN opcs_x_cats oxcpj ON oxcpj.id_opcion = u.forma_pago AND oxcpj.id_catalogo = 16 
            LEFT JOIN pago_comision pac ON pac.id_lote = com.id_lote
            INNER JOIN opcs_x_cats oxcC ON pci1.estatus = oxcC.id_opcion and oxcC.id_catalogo = 23
            LEFT JOIN sedes sed ON sed.id_sede = $sede and sed.estatus = 1
            LEFT JOIN (SELECT id_usuario, fecha_creacion, estatus FROM opinion_cumplimiento WHERE estatus = 1) opt ON opt.id_usuario = com.id_usuario
            WHERE pci1.estatus IN ($estado) AND ( (lo.idStatusContratacion < 9 AND com.estatus IN (1,8)) OR (lo.idStatusContratacion > 8 AND com.estatus IN (8))) AND com.id_usuario = $user_data
            GROUP BY pci1.id_comision,com.ooam,com.loteReubicado, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, oxcpj.nombre, u.forma_pago,pci1.id_pago_i, pac.porcentaje_abono, oxcC.nombre, sed.impuesto, pac.bonificacion, opt.fecha_creacion, opt.estatus)
            UNION
            (SELECT pci1.id_pago_i, pci1.id_comision, (CASE WHEN com.ooam = 2 THEN CONCAT(lo.nombreLote,' <i>(',com.loteReubicado,')</i>') ELSE lo.nombreLote END) lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, pci1.fecha_abono fecha_creacion, pci1.id_usuario, oxcpj.nombre as pj_name, u.forma_pago, pac.porcentaje_abono, 0 as factura, 1 expediente, (CASE WHEN com.ooam = 1 THEN ' (OOAM)' ELSE '' END) estatus_actual, (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, pac.bonificacion, cl.lugar_prospeccion,
            pci1.fecha_abono, opt.fecha_creacion AS fecha_opinion, opt.estatus as estatus_opinion
            FROM pago_comision_ind pci1 
            INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
            INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
            INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
            INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 1
            INNER JOIN usuarios u ON u.id_usuario = com.id_usuario  
            INNER JOIN opcs_x_cats oxcpj ON oxcpj.id_opcion = u.forma_pago AND oxcpj.id_catalogo = 16 
            LEFT JOIN pago_comision pac ON pac.id_lote = com.id_lote
            INNER JOIN opcs_x_cats oxcC ON pci1.estatus = oxcC.id_opcion and oxcC.id_catalogo = 23
            INNER JOIN sedes sed ON sed.id_sede = $sede and sed.estatus = 1
            LEFT JOIN (SELECT id_usuario, fecha_creacion, estatus FROM opinion_cumplimiento WHERE estatus = 1) opt ON opt.id_usuario = com.id_usuario
            WHERE pci1.estatus IN ($estado) AND com.estatus in (1) AND lo.idStatusContratacion > 8   AND com.id_usuario = $user_data
            GROUP BY pci1.id_comision,com.ooam,com.loteReubicado, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, oxcpj.nombre, u.forma_pago,pci1.id_pago_i, pac.porcentaje_abono, oxcC.nombre, sed.impuesto, pac.bonificacion, cl.lugar_prospeccion, opt.fecha_creacion, opt.estatus)");
    }

    function getDatosComisionesAsesorBaja($estado){
        $filtro = 'AND u.estatus = 0 AND u.id_rol IN (3,9,7,42)';
        $sede = $this->session->userdata('id_sede');
        return $this->db->query("(SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, pci1.fecha_abono fecha_creacion, pci1.id_usuario, oxcpj.nombre as pj_name, u.forma_pago, pac.porcentaje_abono, 0 as factura, 1 expediente, (CASE WHEN com.ooam = 1 THEN  CONCAT(oxcC.nombre,' (OOAM)') ELSE oxcC.nombre END) estatus_actual, (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, pac.bonificacion, 0 lugar_prospeccion, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) as user_names, oxcrol.nombre as puesto
                    FROM pago_comision_ind pci1 
                    INNER JOIN comisiones com ON pci1.id_comision = com.id_comision 
                    INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1
                    INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                    INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                    INNER JOIN usuarios u ON u.id_usuario = com.id_usuario  
                    INNER JOIN opcs_x_cats oxcrol ON oxcrol.id_opcion = u.id_rol AND oxcrol.id_catalogo = 1 
                    INNER JOIN opcs_x_cats oxcpj ON oxcpj.id_opcion = u.forma_pago AND oxcpj.id_catalogo = 16 
                    INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                    INNER JOIN opcs_x_cats oxcC ON pci1.estatus = oxcC.id_opcion and oxcC.id_catalogo = 23
                    LEFT JOIN sedes sed ON sed.id_sede = $sede and sed.estatus = 1
                    WHERE pci1.estatus IN ($estado) AND ( (lo.idStatusContratacion < 9 AND com.estatus IN (1,8)) OR (lo.idStatusContratacion > 8 AND com.estatus IN (8))) $filtro
                    GROUP BY pci1.id_comision,com.ooam, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, 
                    com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, oxcpj.nombre, u.forma_pago,pci1.id_pago_i, pac.porcentaje_abono, oxcC.nombre, sed.impuesto, pac.bonificacion, u.nombre, u.apellido_paterno, u.apellido_materno, oxcrol.nombre)
                    UNION
                    (SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, pci1.fecha_abono fecha_creacion, pci1.id_usuario, oxcpj.nombre as pj_name, u.forma_pago, pac.porcentaje_abono, 0 as factura, 1 expediente, (CASE WHEN com.ooam = 1 THEN  CONCAT(oxcC.nombre,' (OOAM)') ELSE oxcC.nombre END) estatus_actual, (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, pac.bonificacion, cl.lugar_prospeccion, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) as user_names, oxcrol.nombre as puesto
                    FROM pago_comision_ind pci1 
                    INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                    INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1
                    INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                    INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                    INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 1
                    INNER JOIN usuarios u ON u.id_usuario = com.id_usuario  
                    INNER JOIN opcs_x_cats oxcrol ON oxcrol.id_opcion = u.id_rol AND oxcrol.id_catalogo = 1 
                    INNER JOIN opcs_x_cats oxcpj ON oxcpj.id_opcion = u.forma_pago AND oxcpj.id_catalogo = 16 
                    INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                    INNER JOIN opcs_x_cats oxcC ON pci1.estatus = oxcC.id_opcion and oxcC.id_catalogo = 23
                    INNER JOIN sedes sed ON sed.id_sede = $sede and sed.estatus = 1
                    WHERE pci1.estatus IN ($estado) AND com.estatus in (1) AND lo.idStatusContratacion > 8 $filtro 
                    GROUP BY pci1.id_comision,com.ooam, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, 
                    com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata,
                    pci1.estatus, pci1.fecha_abono, pci1.id_usuario, oxcpj.nombre, 
                    u.forma_pago,pci1.id_pago_i, pac.porcentaje_abono, oxcC.nombre, sed.impuesto, pac.bonificacion, cl.lugar_prospeccion, u.nombre, u.apellido_paterno, u.apellido_materno,oxcrol.nombre)");
    }
    
    function factura_comision( $uuid, $id_res){
        return $this->db->query("SELECT DISTINCT CAST(uuid AS VARCHAR(MAX)) AS uuid, u.nombre, u.apellido_paterno, u.apellido_materno, res.nombreResidencial as nombreLote, f.fecha_factura, f.folio_factura, f.metodo_pago, f.regimen, f.forma_pago, f.cfdi, f.unidad, f.claveProd, f.total, f.total as porcentaje_dinero, f.nombre_archivo, CAST(f.descripcion AS VARCHAR(MAX)) AS descrip, f.fecha_ingreso
        FROM facturas f 
        INNER JOIN usuarios u ON u.id_usuario = f.id_usuario
        INNER JOIN pago_comision_ind pci ON pci.id_pago_i = f.id_comision
        INNER JOIN comisiones com ON com.id_comision = pci.id_comision
        INNER JOIN lotes l ON l.idLote = com.id_lote
        INNER JOIN condominios con ON con.idCondominio = l.idCondominio
        INNER JOIN residenciales res ON res.idResidencial = con.idResidencial and res.idResidencial = $id_res
        WHERE /*MONTH(f.fecha_ingreso) >= 4 AND*/ f.uuid = '".$uuid."' ");
    }
    
    function update_acepta_solicitante($idsol) {
        $this->db->query("UPDATE pago_comision_ind SET estatus = 4, fecha_pago_intmex = GETDATE(),modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_i IN (".$idsol.")");
        return true;
    }
    
    function update_acepta_solicitante_mk($idsol) {
        return $this->db->query("UPDATE pago_comision_mktd SET estatus = 4 WHERE id_pago_mk IN (".$idsol.")");
    }
    
    function update_acepta_solicitante_uno($idsol) {
        return $this->db->query("UPDATE pago_comision_ind SET estatus = 42,modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_i IN (".$idsol.")");
    }
    
    function update_acepta_solicitante_dos($idsol) {
        return $this->db->query("UPDATE pago_comision_ind SET estatus = 41,modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_i IN (".$idsol.")");
    }
    
    function getDesarrolloSelect($a = ''){
        if($a == ''){
            $usuario = $this->session->userdata('id_usuario');
        }else{
            $usuario = $a;
        }
        return $this->db->query("SELECT res.idResidencial id_usuario, concat(res.nombreResidencial,' ',res.descripcion)  as name_user FROM residenciales res WHERE res.idResidencial NOT IN 
        (SELECT re.idResidencial FROM residenciales re INNER JOIN condominios co ON re.idResidencial = co.idResidencial INNER JOIN lotes lo ON lo.idCondominio = co.idCondominio INNER JOIN comisiones com ON com.id_lote = lo.idLote AND com.estatus in (1,8) INNER JOIN pago_comision_ind pci ON pci.id_comision = com.id_comision INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (2) WHERE pci.estatus IN (4) AND u.id_usuario = $usuario GROUP BY re.idResidencial) AND res.status = 1 AND res.idResidencial IN         
        (SELECT re.idResidencial FROM residenciales re INNER JOIN condominios co ON re.idResidencial = co.idResidencial INNER JOIN lotes lo ON lo.idCondominio = co.idCondominio INNER JOIN comisiones com ON com.id_lote = lo.idLote AND com.estatus in (1,8) INNER JOIN pago_comision_ind pci ON pci.id_comision = com.id_comision INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (2) WHERE pci.estatus IN (1) AND u.id_usuario = $usuario GROUP BY re.idResidencial)");
    }

    public function getDatosProyecto($idlote,$id_usuario = ''){
        if($id_usuario == ''){
            $id_user_V3 = $this->session->userdata('id_usuario');
        }else{
            $id_user_V3 = $id_usuario;
        }
        return $this->db->query("SELECT pci.id_pago_i, pci.pago_neodata, pci.abono_neodata  ,res.idResidencial , lot.nombreLote, res.nombreResidencial , res.idResidencial
        FROM pago_comision_ind pci
        INNER JOIN comisiones com ON com.id_comision = pci.id_comision
        INNER JOIN lotes lot ON lot.idLote = com.id_lote
        INNER JOIN condominios con ON con.idCondominio = lot.idCondominio
        INNER JOIN residenciales res ON res.idResidencial = con.idResidencial
        WHERE pci.estatus = 1 AND pci.id_usuario = $id_user_V3 AND res.idResidencial = $idlote");     
    }
    
    function leerxml( $xml_leer, $cargar_xml ){
        $str = '';
        if( $cargar_xml ){
            rename( $xml_leer, "./UPLOADS/XMLS/documento_temporal.txt" );
            $str = file_get_contents( "./UPLOADS/XMLS/documento_temporal.txt" );
            if( substr ( $str, 0, 3 ) == 'o;?' ){
                $str = str_replace( "o;?", "", $str );
                file_put_contents( './UPLOADS/XMLS/documento_temporal.txt', $str );
            }
            rename( "./UPLOADS/XMLS/documento_temporal.txt", $xml_leer );
        }
        libxml_use_internal_errors(true);
        $xml = simplexml_load_file( $xml_leer, null, true );
        $datosxml = array(
            "version" => $xml ->xpath('//cfdi:Comprobante')[0]['Version'],
            "regimenFiscal" => $xml ->xpath('//cfdi:Emisor')[0]['RegimenFiscal'],
            "formaPago" => $xml -> xpath('//cfdi:Comprobante')[0]['FormaPago'],
            "usocfdi" => $xml -> xpath('//cfdi:Receptor')[0]['UsoCFDI'],
            "metodoPago" => $xml -> xpath('//cfdi:Comprobante')[0]['MetodoPago'],
            "claveUnidad" => $xml -> xpath('//cfdi:Concepto')[0]['ClaveUnidad'],
            "unidad" => $xml -> xpath('//cfdi:Concepto')[0]['Unidad'],
            "claveProdServ" => $xml -> xpath('//cfdi:Concepto')[0]['ClaveProdServ'],
            "descripcion" => $xml -> xpath('//cfdi:Concepto')[0]['Descripcion'],
            "subTotal" => $xml -> xpath('//cfdi:Comprobante')[0]['SubTotal'],
            "total" => $xml -> xpath('//cfdi:Comprobante')[0]['Total'],
            "rfcemisor" => $xml -> xpath('//cfdi:Emisor')[0]['Rfc'],
            "nameEmisor" => $xml -> xpath('//cfdi:Emisor')[0]['Nombre'],
            "rfcreceptor" => $xml -> xpath('//cfdi:Receptor')[0]['Rfc'],
            "namereceptor" => $xml -> xpath('//cfdi:Receptor')[0]['Nombre'],
            "TipoRelacion"=> $xml->xpath('//@TipoRelacion'),
            "uuidV" =>$xml->xpath('//@UUID')[0],
            "fecha"=> $xml -> xpath('//cfdi:Comprobante')[0]['Fecha'],
            "folio"=> $xml -> xpath('//cfdi:Comprobante')[0]['Folio'],
        );
        $datosxml["textoxml"] = $str;
        return $datosxml;
    }
     
    function verificar_uuid( $uuid ){
        return $this->db->query("SELECT * FROM facturas WHERE uuid = '".$uuid."'");
    }
    
    function insertar_factura( $id_comision, $datos_factura,$usuarioid){
        $VALOR_TEXT = $datos_factura['textoxml'];
        $data = array(
            "fecha_factura"  => $datos_factura['fecha'],
            "folio_factura"  => $datos_factura['folio'],
            "descripcion" => $datos_factura['descripcion'],
            "subtotal" => $datos_factura['subTotal'],
            "total"  => $datos_factura['total'],
            "metodo_pago"  => $datos_factura['metodoPago'],
            "uuid" => $datos_factura['uuidV'],
            "nombre_archivo" => $datos_factura['nombre_xml'],
            "id_usuario" => $usuarioid,
            "id_comision" => $id_comision,
            "regimen" => $datos_factura['regimenFiscal'],
            "forma_pago" => $datos_factura['formaPago'],
            "cfdi" => $datos_factura['usocfdi'],
            "unidad" => $datos_factura['claveUnidad'],
            "claveProd" => $datos_factura['claveProdServ']
        );
        return $this->db->insert("facturas", $data);
    }
 
    function getDatosPlanesMktd(){
        return $this->db->query("SELECT * FROM planes_mktd");
    }
    
    function getDatosColabMktd($sede, $plan){
        if($plan == 9 || $plan == 11  || $plan == 12 || $plan == 13){
            $filtro_1 = ' , 28';
            $filtro_2 = " UNION (SELECT pk.id_plan, pk.fecha_plan, getdate() as fin_plan, u.id_usuario, CONCAT(u.nombre,' ' ,u.apellido_paterno,' ',u.apellido_materno) AS colaborador, op1.nombre AS rol, pcm.porcentaje, u.id_sede, op1.id_opcion, (CASE op1.id_opcion WHEN '18' THEN 1 WHEN '19' THEN 2 WHEN '20 ' THEN 3 WHEN '25' THEN 4 ELSE op1.id_opcion END) as rol_dos FROM planes_mktd pk INNER JOIN porcentajes_mktd pcm ON pcm.numero_plan = pk.id_plan INNER JOIN usuarios u ON u.id_usuario = pcm.id_usuario INNER JOIN opcs_x_cats op1 ON op1.id_opcion = pcm.rol WHERE op1.id_catalogo = 1 AND pcm.rol IN (28) AND pcm.id_plaza IN (2) AND pk.id_plan = $plan) ";
        } else{
            $filtro_1 = ' ';
            $filtro_2 = ' ';
        }
    
        return $this->db->query("(SELECT pk.id_plan, pk.fecha_plan, getdate() as fin_plan, u.id_usuario, CONCAT(u.nombre,' ' ,u.apellido_paterno,' ',u.apellido_materno) AS colaborador, op1.nombre AS rol, pcm.porcentaje, u.id_sede, op1.id_opcion, (CASE op1.id_opcion WHEN '18' THEN 1 WHEN '10' THEN 2 WHEN '19' THEN 3 WHEN '37' THEN 4 WHEN '25 ' THEN 5 WHEN '29' THEN 6 WHEN '30' THEN 7 WHEN '20' THEN 8 WHEN '28' THEN 9 ELSE op1.id_opcion END) as rol_dos
        FROM planes_mktd pk INNER JOIN porcentajes_mktd pcm ON pcm.numero_plan = pk.id_plan INNER JOIN usuarios u ON u.id_usuario = pcm.id_usuario INNER JOIN opcs_x_cats op1 ON op1.id_opcion = pcm.rol WHERE op1.id_catalogo = 1 AND pcm.rol NOT IN (19, 20 ".$filtro_1.") AND pk.id_plan = $plan)
        UNION (SELECT pk.id_plan, pk.fecha_plan, getdate() as fin_plan, u.id_usuario, CONCAT(u.nombre,' ' ,u.apellido_paterno,' ',u.apellido_materno) AS colaborador, op1.nombre AS rol, pcm.porcentaje, u.id_sede, op1.id_opcion, (CASE op1.id_opcion WHEN '18' THEN 1 WHEN '19' THEN 2 WHEN '20 ' THEN 3 WHEN '25' THEN 4 ELSE op1.id_opcion END) as rol_dos FROM planes_mktd pk INNER JOIN porcentajes_mktd pcm ON pcm.numero_plan = pk.id_plan INNER JOIN usuarios u ON u.id_usuario = pcm.id_usuario INNER JOIN opcs_x_cats op1 ON op1.id_opcion = pcm.rol WHERE op1.id_catalogo = 1 AND pcm.rol IN (20) AND pcm.id_sede IN ($sede) AND pk.id_plan = $plan) ".$filtro_2."
        UNION (SELECT pk.id_plan, pk.fecha_plan, getdate() as fin_plan, u.id_usuario, CONCAT(u.nombre,' ' ,u.apellido_paterno,' ',u.apellido_materno) AS colaborador, op1.nombre AS rol, pcm.porcentaje, u.id_sede, op1.id_opcion, (CASE op1.id_opcion WHEN '18' THEN 1 WHEN '19' THEN 2 WHEN '20 ' THEN 3 WHEN '25' THEN 4 ELSE op1.id_opcion END) as rol_dos FROM planes_mktd pk INNER JOIN porcentajes_mktd pcm ON pcm.numero_plan = pk.id_plan INNER JOIN usuarios u ON u.id_usuario = pcm.id_usuario INNER JOIN opcs_x_cats op1 ON op1.id_opcion = pcm.rol WHERE op1.id_catalogo = 1 AND pcm.rol IN (19) AND pcm.id_plaza IN (2) AND pk.id_plan = $plan) order by rol_dos");
    }

    function getDatosColabMktd2($sede, $plan){
        if($plan == 9 || $plan == 11  || $plan == 12 || $plan == 13){
            $filtro_1 = ' , 28';
            $filtro_2 = " UNION (SELECT pk.id_plan, pk.fecha_plan, getdate() as fin_plan, u.id_usuario, CONCAT(u.nombre,' ' ,u.apellido_paterno,' ',u.apellido_materno) AS colaborador, op1.nombre AS rol, pcm.porcentaje, u.id_sede, op1.id_opcion, (CASE op1.id_opcion WHEN '18' THEN 1 WHEN '19' THEN 2 WHEN '20 ' THEN 3 WHEN '25' THEN 4 ELSE op1.id_opcion END) as rol_dos FROM planes_mktd pk INNER JOIN porcentajes_mktd pcm ON pcm.numero_plan = pk.id_plan INNER JOIN usuarios u ON u.id_usuario = pcm.id_usuario INNER JOIN opcs_x_cats op1 ON op1.id_opcion = pcm.rol WHERE op1.id_catalogo = 1 AND pcm.rol IN (28) AND pcm.id_plaza IN (3) AND pk.id_plan = $plan) ";
        } else{
            $filtro_1 = ' ';
            $filtro_2 = ' ';
        }
        return $this->db->query("(SELECT pk.id_plan, pk.fecha_plan, getdate() as fin_plan, u.id_usuario, CONCAT(u.nombre,' ' ,u.apellido_paterno,' ',u.apellido_materno) AS colaborador, op1.nombre AS rol, pcm.porcentaje, u.id_sede, op1.id_opcion, (CASE op1.id_opcion WHEN '18' THEN 1 WHEN '10' THEN 2 WHEN '19' THEN 3 WHEN '37' THEN 4 WHEN '25 ' THEN 5 WHEN '29' THEN 6 WHEN '30' THEN 7 WHEN '20' THEN 8 WHEN '28' THEN 9 ELSE op1.id_opcion END) as rol_dos
        FROM planes_mktd pk INNER JOIN porcentajes_mktd pcm ON pcm.numero_plan = pk.id_plan INNER JOIN usuarios u ON u.id_usuario = pcm.id_usuario INNER JOIN opcs_x_cats op1 ON op1.id_opcion = pcm.rol WHERE op1.id_catalogo = 1 AND pcm.rol NOT IN (19, 20 ".$filtro_1.") AND pk.id_plan = $plan)
        UNION (SELECT pk.id_plan, pk.fecha_plan, getdate() as fin_plan, u.id_usuario, CONCAT(u.nombre,' ' ,u.apellido_paterno,' ',u.apellido_materno) AS colaborador, op1.nombre AS rol, pcm.porcentaje, u.id_sede, op1.id_opcion, (CASE op1.id_opcion WHEN '18' THEN 1 WHEN '19' THEN 2 WHEN '20 ' THEN 3 WHEN '25' THEN 4 ELSE op1.id_opcion END) as rol_dos FROM planes_mktd pk INNER JOIN porcentajes_mktd pcm ON pcm.numero_plan = pk.id_plan INNER JOIN usuarios u ON u.id_usuario = pcm.id_usuario INNER JOIN opcs_x_cats op1 ON op1.id_opcion = pcm.rol WHERE op1.id_catalogo = 1 AND pcm.rol IN (20) AND pcm.id_sede IN ($sede) AND pk.id_plan = $plan) ".$filtro_2."
        UNION (SELECT pk.id_plan, pk.fecha_plan, getdate() as fin_plan, u.id_usuario, CONCAT(u.nombre,' ' ,u.apellido_paterno,' ',u.apellido_materno) AS colaborador, op1.nombre AS rol, pcm.porcentaje, u.id_sede, op1.id_opcion, (CASE op1.id_opcion WHEN '18' THEN 1 WHEN '19' THEN 2 WHEN '20 ' THEN 3 WHEN '25' THEN 4 ELSE op1.id_opcion END) as rol_dos FROM planes_mktd pk INNER JOIN porcentajes_mktd pcm ON pcm.numero_plan = pk.id_plan INNER JOIN usuarios u ON u.id_usuario = pcm.id_usuario INNER JOIN opcs_x_cats op1 ON op1.id_opcion = pcm.rol WHERE op1.id_catalogo = 1 AND pcm.rol IN (19) AND pcm.id_plaza IN (3) AND pk.id_plan = $plan) order by rol_dos");
    }
 
    function getDatosSumaMktd($sede, $PLAN,$empresa, $res){
        return $this->db->query("SELECT SUM (pci.abono_neodata) suma_f01, STRING_AGG(pci.id_pago_i, ', ') AS valor_obtenido, res.empresa, res.nombreResidencial
        FROM pago_comision_ind pci 
        INNER JOIN comisiones com ON com.id_comision = pci.id_comision
        INNER JOIN lotes lo ON lo.idLote = com.id_lote
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio
        INNER JOIN residenciales res ON res.idResidencial = con.idResidencial
        INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente
        INNER JOIN planes_mktd plm ON plm.fecha_plan <= cl.fechaApartado AND plm.fin_plan >= cl.fechaApartado
        INNER JOIN sedes s ON s.id_sede = lo.ubicacion_dos
        INNER JOIN usuarios us ON us.id_usuario = pci.id_usuario
        WHERE pci.estatus IN (1, 41, 42, 51, 52, 61, 62, 12) AND lo.idLote IN (select id_lote from reportes_marketing WHERE estatus = 1 AND dispersion = 1) AND pci.id_usuario = 4394 AND lo.status = 1 AND lo.idLote NOT IN (select id_lote from compartidas_mktd) AND cl.status = 1 AND lo.ubicacion_dos IN (".$sede.") AND plm.id_plan = ".$PLAN." AND res.empresa = '".$empresa."' AND res.idResidencial = '".$res."'
        GROUP BY plm.id_plan, pci.id_usuario, lo.ubicacion_dos, s.nombre, us.nombre, us.apellido_paterno, res.empresa, res.nombreResidencial
        ORDER by plm.id_plan");
    }
 
    function getDatosSumaMktdComp($sede, $PLAN,$empresa, $s1, $s2){
        return $this->db->query("SELECT SUM (pci.abono_neodata) suma_f01, STRING_AGG(pci.id_pago_i, ', ') AS valor_obtenido, res.empresa
        FROM pago_comision_ind pci 
        INNER JOIN comisiones com ON com.id_comision = pci.id_comision
        INNER JOIN lotes lo ON lo.idLote = com.id_lote
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio
        INNER JOIN residenciales res ON res.idResidencial = con.idResidencial
        INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente
        INNER JOIN planes_mktd plm ON plm.fecha_plan <= cl.fechaApartado AND plm.fin_plan >= cl.fechaApartado
        INNER JOIN sedes s ON s.id_sede = lo.ubicacion_dos
        INNER JOIN usuarios us ON us.id_usuario = pci.id_usuario
        INNER JOIN compartidas_mktd cmktd on com.id_lote=cmktd.id_lote
        INNER JOIN sedes s1 on s1.id_sede=cmktd.sede1 
        INNER JOIN sedes s2 on s2.id_sede=cmktd.sede2
        WHERE pci.estatus IN (1, 41, 42, 51, 52, 61, 62, 12) AND lo.idLote IN (select id_lote from reportes_marketing WHERE estatus = 1 AND dispersion = 1) AND pci.id_usuario = 4394 AND lo.status = 1 AND cl.status = 1 AND plm.id_plan = ".$PLAN." AND res.empresa =  '".$empresa."' AND s1.id_sede = ".$s1." and s2.id_sede = ".$s2." 
        GROUP BY plm.id_plan, pci.id_usuario, lo.ubicacion_dos, s.nombre, us.nombre, us.apellido_paterno, res.empresa
        ORDER by plm.id_plan");
    }
 
    function getDatosUsersMktd($val){
        return $this->db->query("SELECT pk.id_porcentaje, pk.id_usuario, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) usuario,rol.id_opcion, rol.nombre as puesto, pk.porcentaje, 
        plaza.nombre as plaza, sede.nombre as sede, pk.numero_plan, pk.rol
        FROM porcentajes_mktd pk 
        LEFT JOIN usuarios u ON u.id_usuario = pk.id_usuario
        LEFT JOIN opcs_x_cats rol ON rol.id_opcion = pk.rol
        LEFT JOIN opcs_x_cats plaza ON plaza.id_opcion = pk.id_plaza
        LEFT JOIN sedes sede ON sede.id_sede = pk.id_sede
        WHERE rol.id_catalogo = 1 AND plaza.id_catalogo = 36 AND pk.numero_plan = ".$val."
        ORDER BY pk.id_plaza");
    }

    function nueva_mktd_comision($values_send,$id_usuario,$abono_mktd,$pago_mktd,$user, $num_plan,$empresa){
        $respuesta = $this->db->query("INSERT INTO pago_comision_mktd (id_list, id_usuario, abono_marketing, fecha_abono, fecha_pago_intmex, pago_mktd, estatus, creado_por, comentario,empresa) VALUES ('$values_send', $id_usuario, $abono_mktd, GETDATE(), GETDATE(), $pago_mktd, 1, $user, 'DISPERSIÓN MKTD $num_plan','$empresa')");
        if (! $respuesta ) {
            return false;
        } else {
            return true;
        }
    }
 
    function updatePagoInd($pago_id){
        $respuesta =  $this->db->query("UPDATE pago_comision_ind SET estatus = 13,fecha_pago_intmex=GETDATE(),modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_i = ".$pago_id."");
        if (! $respuesta ) {
            return false;
        } else {
            return true;
        }
    }
    
    function getDatosNuevasSNL(){
        return $this->db->query("SELECT pci1.id_comision, pci1.id_pago_i, pci1.id_usuario, lo.nombreLote as lote, re.nombreResidencial as proyecto, sed.nombre, sed.id_sede, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, oxc.nombre as lugar_prosp, pci1.estatus, cl.personalidad_juridica, pac.porcentaje_abono, contrato.expediente, com.id_lote,cl.fechaApartado, CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)nombreCliente
        FROM pago_comision_ind pci1 
        LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE (estatus in (11,3) OR descuento_aplicado = 1) 
        GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
        INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
        INNER JOIN lotes lo ON lo.idLote = com.id_lote
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        INNER JOIN clientes cl ON cl.idLote = lo.idLote
        INNER JOIN porcentajes_comisiones pc ON pc.relacion_prospeccion = cl.lugar_prospeccion
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = pc.medio_comision
        INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
        INNER JOIN sedes sed ON sed.id_sede = lo.ubicacion
        INNER JOIN (SELECT expediente, idCliente FROM historial_documento WHERE tipo_doc in (8) 
        AND status = 1 GROUP BY idCliente, expediente) contrato ON contrato.idCliente = cl.id_cliente
        WHERE pci1.estatus = 1 AND com.estatus in (1,8) AND oxc.id_catalogo = 30   AND com.rol_generado = 42 AND lo.ubicacion in (1)
        GROUP BY pci1.id_comision, cl.fechaApartado,lo.nombreLote, re.nombreResidencial, sed.nombre, sed.id_sede, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, com.comision_total-pci2.abono_pagado, oxc.nombre, pci1.estatus, cl.personalidad_juridica, pac.porcentaje_abono, contrato.expediente, com.id_lote, pci1.id_pago_i, pci1.id_usuario,CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno) 
        ORDER BY lo.nombreLote");
    }

    function getDatosNuevasQro(){
        return $this->db->query("SELECT pci1.id_comision, pci1.id_pago_i, pci1.id_usuario, lo.nombreLote as lote, re.nombreResidencial as proyecto, sed.nombre, sed.id_sede, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, oxc.nombre as lugar_prosp, pci1.estatus, cl.personalidad_juridica, pac.porcentaje_abono, contrato.expediente, com.id_lote,cl.fechaApartado, CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)nombreCliente
        FROM pago_comision_ind pci1 
        LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE (estatus in (11,3) OR descuento_aplicado = 1) 
        GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
        INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
        INNER JOIN lotes lo ON lo.idLote = com.id_lote
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        INNER JOIN clientes cl ON cl.idLote = lo.idLote
        INNER JOIN porcentajes_comisiones pc ON pc.relacion_prospeccion = cl.lugar_prospeccion
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = pc.medio_comision
        INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
        INNER JOIN sedes sed ON sed.id_sede = lo.ubicacion
        INNER JOIN (SELECT expediente, idCliente FROM historial_documento WHERE tipo_doc in (8) AND status = 1 GROUP BY idCliente, expediente) contrato ON contrato.idCliente = cl.id_cliente
        WHERE pci1.estatus = 1 AND com.estatus in (1,8) AND oxc.id_catalogo = 30   AND com.rol_generado = 42 AND lo.ubicacion in (2) 
        GROUP BY pci1.id_comision, cl.fechaApartado,lo.nombreLote, re.nombreResidencial, sed.nombre, sed.id_sede, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, com.comision_total-pci2.abono_pagado, oxc.nombre, pci1.estatus, cl.personalidad_juridica, pac.porcentaje_abono, contrato.expediente, com.id_lote, pci1.id_pago_i, pci1.id_usuario,CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno) ORDER BY lo.nombreLote");
    }

    function getDatosNuevasPen(){
        return $this->db->query("SELECT pci1.id_comision, pci1.id_pago_i, pci1.id_usuario, lo.nombreLote as lote, re.nombreResidencial as proyecto, sed.nombre, sed.id_sede, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, oxc.nombre as lugar_prosp, pci1.estatus, cl.personalidad_juridica, pac.porcentaje_abono, contrato.expediente, com.id_lote,cl.fechaApartado, CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)nombreCliente
        FROM pago_comision_ind pci1 
        LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE (estatus in (11,3) OR descuento_aplicado = 1) 
        GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
        INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
        INNER JOIN lotes lo ON lo.idLote = com.id_lote
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        INNER JOIN clientes cl ON cl.idLote = lo.idLote
        INNER JOIN porcentajes_comisiones pc ON pc.relacion_prospeccion = cl.lugar_prospeccion
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = pc.medio_comision
        INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
        INNER JOIN sedes sed ON sed.id_sede = lo.ubicacion
        INNER JOIN (SELECT expediente, idCliente FROM historial_documento WHERE tipo_doc in (8) AND status = 1 GROUP BY idCliente, expediente) contrato ON contrato.idCliente = cl.id_cliente
        WHERE pci1.estatus = 1 AND com.estatus in (1,8) AND oxc.id_catalogo = 30   AND com.rol_generado = 42 AND lo.ubicacion in (3) 
        GROUP BY pci1.id_comision, cl.fechaApartado,lo.nombreLote, re.nombreResidencial, sed.nombre, sed.id_sede, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, com.comision_total-pci2.abono_pagado, oxc.nombre, pci1.estatus, cl.personalidad_juridica, pac.porcentaje_abono, contrato.expediente, com.id_lote, pci1.id_pago_i, pci1.id_usuario,CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno) ORDER BY lo.nombreLote");
    }

    function getDatosNuevasCDMX(){
        return $this->db->query("SELECT pci1.id_comision, pci1.id_pago_i, pci1.id_usuario, lo.nombreLote as lote, re.nombreResidencial as proyecto, sed.nombre, sed.id_sede, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, oxc.nombre as lugar_prosp, pci1.estatus,  cl.personalidad_juridica, pac.porcentaje_abono, contrato.expediente, com.id_lote,cl.fechaApartado, CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)nombreCliente
        FROM pago_comision_ind pci1 
        LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE (estatus in (11,3) OR descuento_aplicado = 1) 
        GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
        INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
        INNER JOIN lotes lo ON lo.idLote = com.id_lote
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        INNER JOIN clientes cl ON cl.idLote = lo.idLote
        INNER JOIN porcentajes_comisiones pc ON pc.relacion_prospeccion = cl.lugar_prospeccion
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = pc.medio_comision
        INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
        INNER JOIN sedes sed ON sed.id_sede = lo.ubicacion
        INNER JOIN (SELECT expediente, idCliente FROM historial_documento WHERE tipo_doc in (8) AND status = 1 GROUP BY idCliente, expediente) contrato ON contrato.idCliente = cl.id_cliente
        WHERE pci1.estatus = 1 AND com.estatus in (1,8) AND oxc.id_catalogo = 30   AND com.rol_generado = 42 AND lo.ubicacion in (4) 
        GROUP BY pci1.id_comision, cl.fechaApartado,lo.nombreLote, re.nombreResidencial, sed.nombre, sed.id_sede, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, com.comision_total-pci2.abono_pagado, oxc.nombre, pci1.estatus, cl.personalidad_juridica, pac.porcentaje_abono, contrato.expediente, com.id_lote, pci1.id_pago_i, pci1.id_usuario,CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno) ORDER BY lo.nombreLote");
    }

    function getDatosNuevasLeon(){
        return $this->db->query("SELECT pci1.id_comision, pci1.id_pago_i, pci1.id_usuario, lo.nombreLote as lote, re.nombreResidencial as proyecto, sed.nombre, sed.id_sede, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, oxc.nombre as lugar_prosp, pci1.estatus, cl.personalidad_juridica, pac.porcentaje_abono , contrato.expediente, com.id_lote,cl.fechaApartado, CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)nombreCliente 
        FROM pago_comision_ind pci1 
        LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE (estatus in (11,3) OR descuento_aplicado = 1) 
        GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
        INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
        INNER JOIN lotes lo ON lo.idLote = com.id_lote
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        INNER JOIN clientes cl ON cl.idLote = lo.idLote
        INNER JOIN porcentajes_comisiones pc ON pc.relacion_prospeccion = cl.lugar_prospeccion
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = pc.medio_comision
        INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
        INNER JOIN sedes sed ON sed.id_sede = lo.ubicacion
        INNER JOIN (SELECT expediente, idCliente FROM historial_documento WHERE tipo_doc in (8) 
        AND status = 1 GROUP BY idCliente, expediente) contrato ON contrato.idCliente = cl.id_cliente
        WHERE pci1.estatus = 1 AND com.estatus in (1,8) AND oxc.id_catalogo = 30   AND com.rol_generado = 42 AND lo.ubicacion in (5)
        GROUP BY pci1.id_comision, cl.fechaApartado,lo.nombreLote, re.nombreResidencial, sed.nombre, sed.id_sede, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, com.comision_total-pci2.abono_pagado, oxc.nombre, pci1.estatus, cl.personalidad_juridica, pac.porcentaje_abono, contrato.expediente, com.id_lote, pci1.id_pago_i, pci1.id_usuario,CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno) ORDER BY lo.nombreLote");
    }

    function getDatosNuevasCan(){
        return $this->db->query("SELECT pci1.id_comision, pci1.id_pago_i, pci1.id_usuario, lo.nombreLote as lote, re.nombreResidencial as proyecto, sed.nombre, sed.id_sede, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, oxc.nombre as lugar_prosp, pci1.estatus, cl.personalidad_juridica, pac.porcentaje_abono, contrato.expediente, com.id_lote,cl.fechaApartado, CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)nombreCliente
        FROM pago_comision_ind pci1 
        LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE (estatus in (11,3) OR descuento_aplicado = 1) 
        GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
        INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
        INNER JOIN lotes lo ON lo.idLote = com.id_lote
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        INNER JOIN clientes cl ON cl.idLote = lo.idLote
        INNER JOIN porcentajes_comisiones pc ON pc.relacion_prospeccion = cl.lugar_prospeccion
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = pc.medio_comision
        INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
        INNER JOIN sedes sed ON sed.id_sede = lo.ubicacion
        INNER JOIN (SELECT expediente, idCliente FROM historial_documento WHERE tipo_doc in (8) AND status = 1 GROUP BY idCliente, expediente) contrato ON contrato.idCliente = cl.id_cliente
        WHERE pci1.estatus = 1 AND com.estatus in (1,8)  AND oxc.id_catalogo = 30   AND com.rol_generado = 42 AND lo.ubicacion in (6) 
        GROUP BY pci1.id_comision, cl.fechaApartado,lo.nombreLote, re.nombreResidencial, sed.nombre, sed.id_sede, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, com.comision_total-pci2.abono_pagado, oxc.nombre, pci1.estatus, cl.personalidad_juridica, pac.porcentaje_abono, contrato.expediente, com.id_lote, pci1.id_pago_i, pci1.id_usuario,CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno) ORDER BY lo.nombreLote");
    }
    
    function getDatosPlanesClub(){
        return $this->db->query("SELECT * FROM planes_club");
    }
        
    function getDatosUsersClub($val){
        return $this->db->query("SELECT pk.id_porcentajecl, pk.id_usuario, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) usuario,rol.id_opcion, rol.nombre as puesto, pk.porcentaje, plaza.nombre as plaza, sede.nombre as sede, pk.numero_plan, pk.rol
        FROM porcentajes_club pk 
        LEFT JOIN usuarios u ON u.id_usuario = pk.id_usuario
        LEFT JOIN opcs_x_cats rol ON rol.id_opcion = pk.rol
        LEFT JOIN opcs_x_cats plaza ON plaza.id_opcion = pk.id_plaza
        LEFT JOIN sedes sede ON sede.id_sede = pk.id_sede
        WHERE rol.id_catalogo = 1 AND plaza.id_catalogo = 36 AND pk.numero_plan = ".$val."
        ORDER BY pk.id_plaza");
    }
    
    function getDatosColabClub($sede, $lote){
        $consulta = $this->db->query("SELECT lo.idLote, cl.fechaApartado
        FROM clientes cl
        INNER JOIN lotes lo ON lo.idLote = cl.idLote
        WHERE cl.status in (1) AND lo.idLote = ".$lote."");
    
        $consulta_FINAL = $consulta->row()->fechaApartado;
    
        return $this->db->query("(SELECT pk.id_plancl, pk.fecha_plan, pk.fin_plan, u.id_usuario, CONCAT(u.nombre,' ' ,u.apellido_paterno,' ',u.apellido_materno) AS colaborador, op1.nombre AS rol, pcm.porcentaje, u.id_sede
        FROM planes_club pk
        INNER JOIN porcentajes_club pcm ON pcm.numero_plan = pk.id_plancl
        INNER JOIN usuarios u ON u.id_usuario = pcm.id_usuario
        INNER JOIN opcs_x_cats op1 ON op1.id_opcion = pcm.rol
        WHERE op1.id_catalogo = 1 AND pcm.rol  IN (22) AND (pcm.id_sede IN (".$sede.") OR pcm.id_sede = 0) AND pk.fecha_plan <= '".$consulta_FINAL."' /*AND pk.fin_plan >= '".$consulta_FINAL."'*/)
        UNION
        (SELECT pk.id_plancl, pk.fecha_plan, pk.fin_plan, u.id_usuario, CONCAT(u.nombre,' ' ,u.apellido_paterno,' ',u.apellido_materno) AS colaborador, op1.nombre AS rol, pcm.porcentaje, u.id_sede
        FROM planes_club pk
        INNER JOIN porcentajes_club pcm ON pcm.numero_plan = pk.id_plancl
        INNER JOIN usuarios u ON u.id_usuario = pcm.id_usuario
        INNER JOIN opcs_x_cats op1 ON op1.id_opcion = pcm.rol
        WHERE op1.id_catalogo = 1 AND u.id_rol IN (44) AND pcm.id_sede IN (2) AND pk.fecha_plan <= '".$consulta_FINAL."' /*AND pk.fin_plan >= '".$consulta_FINAL."'*/)
        UNION
        (SELECT pk.id_plancl, pk.fecha_plan, pk.fin_plan, u.id_usuario, CONCAT(u.nombre,' ' ,u.apellido_paterno,' ',u.apellido_materno) AS colaborador, op1.nombre AS rol, pcm.porcentaje, u.id_sede
        FROM planes_club pk
        INNER JOIN porcentajes_club pcm ON pcm.numero_plan = pk.id_plancl
        INNER JOIN usuarios u ON u.id_usuario = pcm.id_usuario
        INNER JOIN opcs_x_cats op1 ON op1.id_opcion = pcm.rol
        WHERE op1.id_catalogo = 1 AND u.id_rol IN (43, /*35,*/ 44) AND pcm.id_sede IN (2) AND pk.fecha_plan <= '".$consulta_FINAL."' /*AND pk.fin_plan >= '".$consulta_FINAL."'*/)
        UNION
        (SELECT pk.id_plancl, pk.fecha_plan, pk.fin_plan, u.id_usuario, CONCAT(u.nombre,' ' ,u.apellido_paterno,' ',u.apellido_materno) AS colaborador, op1.nombre AS rol, pcm.porcentaje, u.id_sede
        FROM planes_club pk
        INNER JOIN porcentajes_club pcm ON pcm.numero_plan = pk.id_plancl
        INNER JOIN usuarios u ON u.id_usuario = pcm.id_usuario
        INNER JOIN opcs_x_cats op1 ON op1.id_opcion = pcm.rol
        WHERE op1.id_catalogo = 1 AND u.id_rol IN (23) AND pcm.id_plaza IN (2) AND pk.fecha_plan <= '".$consulta_FINAL."' /*AND pk.fin_plan >= '".$consulta_FINAL."'*/)
        order by rol");
    }
    
    function nueva_club_comision($com_value,$id_usuario,$abono_mktd,$pago_mktd,$user){
        $respuesta = $this->db->query("INSERT INTO pago_comision_ind (id_comision, id_usuario, abono_neodata, fecha_abono, fecha_pago_intmex, estatus, pago_neodata, creado_por, comentario,modificado_por) VALUES (".$com_value.", ".$id_usuario.", ".$abono_mktd.", GETDATE(), GETDATE(), 2, ".$pago_mktd.", ".$user.", 'DISPERSION CLUB',".$this->session->userdata('id_usuario').",'".$this->session->userdata('id_usuario')."')");
        $insert_id_2 = $this->db->insert_id();
        $respuesta = $this->db->query("INSERT INTO  historial_comisiones VALUES ($insert_id_2, ".$this->session->userdata('id_usuario').", GETDATE(), 1, 'DISPERSÓ CLUB MADERAS')");

        if (! $respuesta ) {
            return false;
        } else {
            return true;
        }
    }
 
    function getDatosComisionesNuevas_dos_bonos($proyecto, $condominio){
        if($condominio == 0){
            switch($this->session->userdata('id_rol')){
                case '18':
                case '19':
                case '20':
                case '25':
                case '27':
                case '28':
                case '30':
                case '36':
                case '22':
                case '23':
                case '43':
                case '44':
                    return $this->db->query("SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, oxc.nombre as lugar_prosp, pci1.estatus, pci1.fecha_abono fecha_creacion, pci1.id_usuario, oxcpj.nombre as pj_name, cl.personalidad_juridica, u.forma_pago, pac.porcentaje_abono ,f.id_comision as factura, contrato.expediente, (CASE WHEN com.ooam = 1 THEN  CONCAT(oxcC.nombre,' (OOAM)') ELSE oxcC.nombre END) estatus_actual
                    FROM pago_comision_ind pci1 
                    LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE (estatus in (11,3) OR descuento_aplicado = 1) GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
                    INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                    INNER JOIN lotes lo ON lo.idLote = com.id_lote
                    INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                    INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                    INNER JOIN clientes cl ON cl.idLote = lo.idLote
                    INNER JOIN porcentajes_comisiones pc ON pc.relacion_prospeccion = cl.lugar_prospeccion
                    INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = pc.medio_comision
                    INNER JOIN usuarios u ON u.id_usuario = com.id_usuario  
                    INNER JOIN opcs_x_cats oxcpj ON oxcpj.id_opcion = u.forma_pago
                    INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                    LEFT JOIN facturas f ON f.id_comision = pci1.id_pago_i
                    INNER JOIN (SELECT expediente, idCliente FROM historial_documento WHERE tipo_doc in (8) AND status = 1 GROUP BY idCliente, expediente) contrato ON contrato.idCliente = cl.id_cliente
                    LEFT JOIN opcs_x_cats oxcC ON pci1.estatus = oxcC.id_opcion and oxcC.id_catalogo = 23
                    WHERE re.idResidencial = $proyecto AND  pci1.id_usuario = 4688 AND pci1.estatus IN (2,3) AND com.estatus in (1,8) AND oxcpj.id_catalogo = 16 AND oxc.id_catalogo = 30   
                    GROUP BY pci1.id_comision,com.ooam, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, oxc.nombre, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, oxcpj.nombre, cl.personalidad_juridica, u.forma_pago,pci1.id_pago_i, pac.porcentaje_abono, f.id_comision, contrato.expediente, oxcC.nombre");
                    break;
    
                    default:
                    return $this->db->query("SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, oxc.nombre as lugar_prosp, pci1.estatus, pci1.fecha_abono fecha_creacion, pci1.id_usuario, oxcpj.nombre as pj_name, cl.personalidad_juridica, u.forma_pago, pac.porcentaje_abono ,f.id_comision as factura, contrato.expediente, (CASE WHEN com.ooam = 1 THEN  CONCAT(oxcC.nombre,' (OOAM)') ELSE oxcC.nombre END) estatus_actual
                    FROM pago_comision_ind pci1 
                    LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE (estatus in (11,3) OR descuento_aplicado = 1) 
                    GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
                    INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                    INNER JOIN lotes lo ON lo.idLote = com.id_lote
                    INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                    INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                    INNER JOIN clientes cl ON cl.idLote = lo.idLote
                    INNER JOIN porcentajes_comisiones pc ON pc.relacion_prospeccion = cl.lugar_prospeccion
                    INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = pc.medio_comision
                    INNER JOIN usuarios u ON u.id_usuario = com.id_usuario  
                    INNER JOIN opcs_x_cats oxcpj ON oxcpj.id_opcion = u.forma_pago
                    INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                    LEFT JOIN facturas f ON f.id_comision = pci1.id_pago_i
                    INNER JOIN (SELECT expediente, idCliente FROM historial_documento WHERE tipo_doc in (8) AND status = 1 GROUP BY idCliente, expediente) contrato ON contrato.idCliente = cl.id_cliente
                    LEFT JOIN opcs_x_cats oxcC ON pci1.estatus = oxcC.id_opcion and oxcC.id_catalogo = 23
                    WHERE re.idResidencial = $proyecto AND com.id_usuario = 4688 AND pci1.estatus IN (1,3) AND com.estatus in (1,8) AND oxcpj.id_catalogo = 16 AND oxc.id_catalogo = 30 AND pc.id_rol = 44
                    GROUP BY pci1.id_comision,com.ooam, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, oxc.nombre, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, oxcpj.nombre, cl.personalidad_juridica, u.forma_pago,pci1.id_pago_i, pac.porcentaje_abono, f.id_comision, contrato.expediente, oxcC.nombre");
                    break;
                }
            } else {
                switch($this->session->userdata('id_rol')){
                    case '18':
                    case '19':
                    case '20':
                    case '25':
                    case '27':
                    case '28':
                    case '30':
                    case '36':
                    case '22':
                    case '23':
                    case '43':
                    case '44':
                        return $this->db->query("SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, oxc.nombre as lugar_prosp, pci1.estatus, pci1.fecha_abono fecha_creacion, pci1.id_usuario, oxcpj.nombre as pj_name, cl.personalidad_juridica, u.forma_pago, pac.porcentaje_abono ,f.id_comision as factura, contrato.expediente, (CASE WHEN com.ooam = 1 THEN  CONCAT(oxcC.nombre,' (OOAM)') ELSE oxcC.nombre END) estatus_actual
                        FROM pago_comision_ind pci1 
                        LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE (estatus in (11,3) OR descuento_aplicado = 1) 
                        GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
                        INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                        INNER JOIN lotes lo ON lo.idLote = com.id_lote
                        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                        INNER JOIN clientes cl ON cl.idLote = lo.idLote
                        INNER JOIN porcentajes_comisiones pc ON pc.relacion_prospeccion = cl.lugar_prospeccion
                        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = pc.medio_comision
                        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario  
                        INNER JOIN opcs_x_cats oxcpj ON oxcpj.id_opcion = u.forma_pago
                        INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                        LEFT JOIN facturas f ON f.id_comision = pci1.id_pago_i
                        INNER JOIN (SELECT expediente, idCliente FROM historial_documento WHERE tipo_doc in (8) AND status = 1 GROUP BY idCliente, expediente) contrato ON contrato.idCliente = cl.id_cliente
                        LEFT JOIN opcs_x_cats oxcC ON pci1.estatus = oxcC.id_opcion and oxcC.id_catalogo = 23
                        WHERE  co.idCondominio = $condominio AND  pci1.id_usuario = ".$this->session->userdata('id_usuario')." AND pci1.estatus IN (1,3) AND com.estatus in (1,8) AND oxcpj.id_catalogo = 16 AND oxc.id_catalogo = 30   
                        GROUP BY pci1.id_comision,com.ooam, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, oxc.nombre, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, oxcpj.nombre, cl.personalidad_juridica, u.forma_pago,pci1.id_pago_i, pac.porcentaje_abono, f.id_comision, contrato.expediente, oxcC.nombre");
                    break;
    
                    default:
                        return $this->db->query("SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, oxc.nombre as lugar_prosp, pci1.estatus, pci1.fecha_abono fecha_creacion, pci1.id_usuario, oxcpj.nombre as pj_name, cl.personalidad_juridica, u.forma_pago, pac.porcentaje_abono ,f.id_comision as factura, contrato.expediente, (CASE WHEN com.ooam = 1 THEN  CONCAT(oxcC.nombre,' (OOAM)') ELSE oxcC.nombre END) estatus_actual
                        FROM pago_comision_ind pci1 
                        LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE (estatus in (11,3) OR descuento_aplicado = 1) 
                        GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
                        INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                        INNER JOIN lotes lo ON lo.idLote = com.id_lote
                        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                        INNER JOIN clientes cl ON cl.idLote = lo.idLote
                        INNER JOIN porcentajes_comisiones pc ON pc.relacion_prospeccion = cl.lugar_prospeccion
                        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = pc.medio_comision
                        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario  
                        INNER JOIN opcs_x_cats oxcpj ON oxcpj.id_opcion = u.forma_pago
                        INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                        LEFT JOIN facturas f ON f.id_comision = pci1.id_pago_i
                        INNER JOIN (SELECT expediente, idCliente FROM historial_documento WHERE tipo_doc in (8) AND status = 1 GROUP BY idCliente, expediente) contrato ON contrato.idCliente = cl.id_cliente
                        LEFT JOIN opcs_x_cats oxcC ON pci1.estatus = oxcC.id_opcion and oxcC.id_catalogo = 23
                        WHERE co.idCondominio = $condominio AND com.id_usuario = ".$this->session->userdata('id_usuario')." AND pci1.estatus IN (1,3) AND com.estatus in (1,8) AND oxcpj.id_catalogo = 16 AND oxc.id_catalogo = 30   AND pc.id_rol = ".$this->session->userdata('id_rol')." 
                        GROUP BY pci1.id_comision,com.ooam, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, oxc.nombre, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, oxcpj.nombre, cl.personalidad_juridica, u.forma_pago,pci1.id_pago_i, pac.porcentaje_abono, f.id_comision, contrato.expediente, oxcC.nombre");
                    break;
            }
        }
    }

    public function getDatosDispersar($idlote){
        return $this->db->query("SELECT l.idLote, l.referencia, r.idResidencial, l.nombreLote, c.nombre as nombreCondominio, r.nombreResidencial, cl.nombre, cl.apellido_paterno, cl.apellido_materno, l.totalNeto2, ae.id_usuario as id_asesor, CONCAT(ae.nombre, ' ', ae.apellido_paterno, ' ', ae.apellido_materno) as asesor, co.id_usuario as id_coordinador, CONCAT(co.nombre, ' ', co.apellido_paterno, ' ', co.apellido_materno) as coordinador, ge.id_usuario as id_gerente, CONCAT(ge.nombre, ' ', ge.apellido_paterno, ' ', ge.apellido_materno) as gerente, su.id_usuario as id_subdirector, CONCAT(su.nombre, ' ', su.apellido_paterno, ' ', su.apellido_materno) as subdirector, di.id_usuario as id_director, CONCAT(di.nombre, ' ', di.apellido_paterno, ' ', di.apellido_materno) as director, cl.fechaApartado
        FROM lotes l
        INNER JOIN condominios c ON c.idCondominio = l.idCondominio
        INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
        INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
        INNER JOIN  usuarios ae ON ae.id_usuario = cl.id_asesor
        LEFT JOIN usuarios co ON co.id_usuario = cl.id_coordinador
        LEFT JOIN usuarios ge ON ge.id_usuario = cl.id_gerente
        LEFT JOIN usuarios su ON su.id_usuario = cl.id_subdirector
        LEFT JOIN usuarios di ON di.id_usuario = su.id_lider
        WHERE l.idStatusContratacion BETWEEN 9 AND 15 AND l.idLote = ".$idlote."");
    }

    function update_lote_registro_comision($ideLote){
        $this->db->query("DELETE FROM comisiones WHERE comision_total = 0");
        $this->db->query("DELETE FROM pago_comision_ind WHERE abono_neodata = 0");
        return $this->db->query("UPDATE lotes SET registro_comision = 1 WHERE idLote =  ".$ideLote."");
    }

    public function getDatosAbonado($idlote){
        return $this->db->query("SELECT com.id_comision, com.id_usuario, lo.idLote, res.idResidencial, lo.referencia, com.id_lote, lo.nombreLote, com.porcentaje_decimal, CONCAT(us.nombre,' ' ,us.apellido_paterno,' ',us.apellido_materno) colaborador, oxc.nombre as rol, com.comision_total, pci.abono_pagado, com.rol_generado
        FROM comisiones com
        LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind 
        WHERE (estatus in (11,3) OR descuento_aplicado = 1) GROUP BY id_comision) pci ON pci.id_comision = com.id_comision
        INNER JOIN lotes lo ON lo.idLote = com.id_lote 
        INNER JOIN usuarios us ON us.id_usuario = com.id_usuario
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = com.rol_generado
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio
        INNER JOIN residenciales res ON res.idResidencial = con.idResidencial
        WHERE oxc.id_catalogo = 1 AND com.id_lote = ".$idlote." ORDER BY com.rol_generado asc");
    }

    public function getDatosAbonadoDispersion($idlote,$ooam){
        $request = $this->db->query("SELECT lugar_prospeccion, estructura FROM clientes WHERE idLote = $idlote AND status = 1")->row();
        $estrucura = $request->estructura;
       
        if($ooam == 1 || $ooam == 2){
            $filtroOOAM = 'AND ooam in ('.$ooam.')';
        } else {
            $filtroOOAM = ' ';
        }
           
        return $this->db->query("SELECT com.id_comision, com.id_usuario, lo.totalNeto2, lo.idLote, res.idResidencial, lo.referencia, lo.tipo_venta, com.id_lote, lo.nombreLote, com.porcentaje_decimal, CONCAT(us.nombre,' ' ,us.apellido_paterno,' ',us.apellido_materno) colaborador, CASE WHEN $estrucura = 1 THEN oxc2.nombre ELSE oxc.nombre END as rol, com.comision_total, pci.abono_pagado, com.rol_generado,/* pc.porcentaje_saldos, (CASE us.id_usuario WHEN 832 THEN 25  ELSE pc.porcentaje_saldos END) porcentaje_saldos,*/com.descuento
        FROM comisiones com
        LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind 
        GROUP BY id_comision) pci ON pci.id_comision = com.id_comision
        INNER JOIN lotes lo ON lo.idLote = com.id_lote 
        INNER JOIN usuarios us ON us.id_usuario = com.id_usuario
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = com.rol_generado AND oxc.id_catalogo = 1
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio
        INNER JOIN residenciales res ON res.idResidencial = con.idResidencial
        LEFT JOIN opcs_x_cats oxc2 ON oxc2.id_opcion = com.rol_generado AND oxc2.id_catalogo = 83
        WHERE com.id_lote = $idlote AND com.estatus = 1 $filtroOOAM  ORDER BY com.rol_generado asc");
    }

    public function getDatosAbonadoSuma1($idlote){
        return $this->db->query("SELECT sum(comision_total) val FROM comisiones where id_lote = ".$idlote." 
        union all
        SELECT sum(abono_neodata) val FROM pago_comision_ind where id_comision in (SELECT id_comision FROM comisiones where id_lote = ".$idlote.")");
    }

    public function getDatosAbonadoSuma11($idlote,$ooam){
        // validar 
        return $this->db->query("SELECT SUM(pci.abono_neodata) abonado, pac.total_comision, c2.abono_pagado, lo.totalNeto2, cl.lugar_prospeccion
        FROM lotes lo
        INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente
        INNER JOIN comisiones c1 ON lo.idLote = c1.id_lote AND c1.estatus = 1
        LEFT JOIN (SELECT SUM(comision_total) abono_pagado, id_comision FROM comisiones WHERE descuento in (1) AND estatus = 1 GROUP BY id_comision) c2 ON c1.id_comision = c2.id_comision
        INNER JOIN pago_comision pac ON pac.id_lote = lo.idLote
        LEFT JOIN pago_comision_ind pci on pci.id_comision = c1.id_comision
        WHERE lo.status = 1 AND cl.status = 1 AND c1.estatus = 1 AND lo.idLote in ($idlote)
        GROUP BY lo.idLote, lo.referencia, pac.total_comision, lo.totalNeto2, cl.lugar_prospeccion, c2.abono_pagado");
    }

    function update_pago_comision($ideLote, $TOTALCOMISION, $PORCETOTAL, $ABONOCONTRALORIA, $PENDICONTRALORIA){
        return $this->db->query("INSERT INTO pago_comision ([id_lote],[total_comision],[abonado],[porcentaje_abono],[pendiente],[creado_por],[fecha_modificacion],[fecha_abono]) VALUES (".$ideLote.", ".$TOTALCOMISION.", ".$ABONOCONTRALORIA.", ".$PORCETOTAL.", ".$PENDICONTRALORIA.", ".$this->session->userdata('id_usuario').", GETDATE(), GETDATE())");
    }

    function update_precio($a, $b){
        $id_user_Vl = $this->session->userdata('id_usuario');
        $this->db->query("INSERT INTO  historial_comisiones VALUES (0, ".$id_user_Vl.", GETDATE(), 7, 'SE AGREGÓ PRECIO DE LOTE ".$b." ')");
        return $this->db->query("UPDATE lotes SET totalNeto2 = ".$a." WHERE idLote = ".$b."");
    }

    function update_pagada_comision($idLote,$estatus,$comentario,$comentarioPago) {
        $id_user_Vl = $this->session->userdata('id_usuario');
        $this->db->query("INSERT INTO historial_comisiones VALUES (0, ".$id_user_Vl.", GETDATE(), ".$estatus.", '".$comentario." ')");
        $request = $this->db->query("select * from pago_comision_ind where id_comision in (select id_comision from comisiones where id_lote=".$idLote.") ")->result_array();
        if(count($request) > 0){
            for ($i=0; $i <count($request); $i++) { 
                $this->db->query("INSERT INTO historial_comisiones VALUES (".$request[$i]['id_pago_i'].", ".$request[$i]['id_usuario'].", GETDATE(), ".$estatus.", '".$comentarioPago." ')");
            }
        }
        return $this->db->query("UPDATE lotes SET registro_comision = ".$estatus." WHERE idLote IN (".$idLote.")");
    }
 
    function getDatosComisionesDispersarContraloria(){
        return $this->db->query("SELECT l.idLote, l.plan_enganche, l.nombreLote, c.nombre as nombreCondominio, r.nombreResidencial, cl.nombre, cl.apellido_paterno, cl.apellido_materno, l.totalNeto2, vc.id_cliente as uservc, l.registro_comision
        FROM lotes l
        INNER JOIN condominios c ON c.idCondominio = l.idCondominio
        INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
        INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
        LEFT JOIN ventas_compartidas vc ON vc.id_cliente = cl.id_cliente AND vc.estatus = 1
        WHERE l.idStatusContratacion BETWEEN 9 AND 15 AND l.registro_comision IN (854) AND l.status = 1 AND cl.status = 1
        GROUP BY l.idLote, l.nombreLote, c.nombre, r.nombreResidencial, cl.nombre, cl.apellido_paterno, cl.apellido_materno, l.totalNeto2, l.registro_comision, l.plan_enganche, vc.id_cliente");
    }

    function getDirector(){
        return $this->db->query("  SELECT us.id_usuario, CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) as name_user FROM usuarios us INNER JOIN opcs_x_cats opx ON opx.id_opcion = us.id_rol WHERE us.id_rol = 1 AND opx.id_catalogo = 1");
    }

    function getsubDirector(){
        return $this->db->query("  SELECT us.id_usuario, CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) as name_user FROM usuarios us INNER JOIN opcs_x_cats opx ON opx.id_opcion = us.id_rol WHERE us.id_rol = 2 AND opx.id_catalogo = 1");
    }

    function getGerenteT(){
        return $this->db->query("  SELECT us.id_usuario, CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) as name_user FROM usuarios us INNER JOIN opcs_x_cats opx ON opx.id_opcion = us.id_rol WHERE us.id_rol = 3 AND opx.id_catalogo = 1 AND us.id_sede NOT LIKE '%0%' AND us.correo NOT LIKE '%test_%'");
    }

    function getCoordinador(){
        return $this->db->query("  SELECT us.id_usuario, CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) as name_user FROM usuarios us INNER JOIN opcs_x_cats opx ON opx.id_opcion = us.id_rol WHERE us.id_rol IN (9,3,7) AND opx.id_catalogo =  1 AND us.id_sede NOT LIKE '%0%' AND us.correo NOT LIKE '%test_%'");
    }

    function getAsesor(){
        return $this->db->query("  SELECT us.id_usuario, CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) as name_user FROM usuarios us INNER JOIN opcs_x_cats opx ON opx.id_opcion = us.id_rol WHERE us.id_rol IN (3,7,9) AND opx.id_catalogo = 1 AND us.id_sede NOT LIKE '%0%' AND us.correo NOT LIKE '%test_%'");
    } 

    function getMktd(){
        return $this->db->query("  SELECT us.id_usuario, CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) as name_user FROM usuarios us INNER JOIN opcs_x_cats opx ON opx.id_opcion = us.id_rol WHERE us.id_rol IN (38) AND opx.id_catalogo = 1 AND us.id_sede NOT LIKE '%0%' AND us.correo NOT LIKE '%test_%'");
    }

    function getEjectClub(){
        return $this->db->query("  SELECT us.id_usuario, CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) as name_user FROM usuarios us INNER JOIN opcs_x_cats opx ON opx.id_opcion = us.id_rol WHERE us.id_rol IN (22) AND opx.id_catalogo = 1 AND us.id_sede NOT LIKE '%0%' AND us.correo NOT LIKE '%test_%'");
    }

    function getSubClub(){
        return $this->db->query("  SELECT us.id_usuario, CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) as name_user FROM usuarios us INNER JOIN opcs_x_cats opx ON opx.id_opcion = us.id_rol WHERE us.id_rol IN (42) AND opx.id_catalogo = 1 AND us.id_sede NOT LIKE '%0%' AND us.correo NOT LIKE '%test_%'");
    }

    function getGreen(){
        return $this->db->query("  SELECT us.id_usuario, CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) as name_user FROM usuarios us INNER JOIN opcs_x_cats opx ON opx.id_opcion = us.id_rol WHERE us.id_rol IN (7) AND us.id_usuario = 4415 AND opx.id_catalogo = 1 AND us.id_sede NOT LIKE '%0%' AND us.correo NOT LIKE '%test_%'");
    }

    function getsubDirector2(){
        return $this->db->query("  SELECT us.id_usuario, CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) as name_user FROM usuarios us INNER JOIN opcs_x_cats opx ON opx.id_opcion = us.id_rol WHERE us.id_rol = 2 AND opx.id_catalogo = 1");
    }

    function getGerente2T(){
        return $this->db->query("  SELECT us.id_usuario, CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) as name_user FROM usuarios us INNER JOIN opcs_x_cats opx ON opx.id_opcion = us.id_rol WHERE us.id_rol = 3 AND opx.id_catalogo = 1 AND us.id_sede NOT LIKE '%0%' AND us.correo NOT LIKE '%test_%'");
    }

    function getCoordinador2(){
        return $this->db->query("  SELECT us.id_usuario, CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) as name_user FROM usuarios us INNER JOIN opcs_x_cats opx ON opx.id_opcion = us.id_rol WHERE us.id_rol IN (9,3,7) AND opx.id_catalogo =  1 AND us.id_sede NOT LIKE '%0%' AND us.correo NOT LIKE '%test_%'");
    }

    function getAsesor2(){
        return $this->db->query("  SELECT us.id_usuario, CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) as name_user FROM usuarios us INNER JOIN opcs_x_cats opx ON opx.id_opcion = us.id_rol WHERE us.id_rol IN (3,7,9) AND opx.id_catalogo = 1 AND us.id_sede NOT LIKE '%0%' AND us.correo NOT LIKE '%test_%'");
    } 

    function getsubDirector3(){
        return $this->db->query("  SELECT us.id_usuario, CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) as name_user FROM usuarios us INNER JOIN opcs_x_cats opx ON opx.id_opcion = us.id_rol WHERE us.id_rol = 2 AND opx.id_catalogo = 1");
    }

    function getGerente3T(){
        return $this->db->query("  SELECT us.id_usuario, CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) as name_user FROM usuarios us INNER JOIN opcs_x_cats opx ON opx.id_opcion = us.id_rol WHERE us.id_rol = 3 AND opx.id_catalogo = 1 AND us.id_sede NOT LIKE '%0%' AND us.correo NOT LIKE '%test_%'");
    }

    function getCoordinador3(){
        return $this->db->query("  SELECT us.id_usuario, CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) as name_user FROM usuarios us INNER JOIN opcs_x_cats opx ON opx.id_opcion = us.id_rol WHERE us.id_rol IN (9,3,7) AND opx.id_catalogo =  1 AND us.id_sede NOT LIKE '%0%' AND us.correo NOT LIKE '%test_%'");
    }

    function getAsesor3(){
        return $this->db->query("  SELECT us.id_usuario, CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) as name_user FROM usuarios us INNER JOIN opcs_x_cats opx ON opx.id_opcion = us.id_rol WHERE us.id_rol IN (3,7,9) AND opx.id_catalogo = 1 AND us.id_sede NOT LIKE '%0%' AND us.correo NOT LIKE '%test_%'");
    } 

    function getUserMk(){
        return $this->db->query("SELECT us.id_usuario, CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) as name_user, us.id_sede, us.id_rol FROM usuarios us INNER JOIN opcs_x_cats opx ON opx.id_opcion = us.id_rol WHERE(us.id_lider in (SELECT us2.id_usuario FROM usuarios us2 WHERE us2.id_rol IN (18,19)) OR us.id_usuario IN (1980)) AND opx.id_catalogo = 1");
    } 

    function update_comisionesDir($ideLote, $directorSelect, $abonadoDir, $totalDir, $porcentajeDir){
        $this->db->query("INSERT INTO comisiones ([id_lote], [id_usuario], [comision_total], [estatus], [observaciones], [ooam], [loteReubicado], [creado_por], [fecha_creacion], [porcentaje_decimal], [fecha_autorizacion], [rol_generado],[modificado_por]) VALUES (".$ideLote.", ".$directorSelect.", ".$totalDir.", 1, 'IMPORTACION', NULL, NULL, ".$this->session->userdata('id_usuario').", GETDATE(), ".$porcentajeDir.", GETDATE(), 1,'".$this->session->userdata('id_usuario')."')");
        $id = $this->db->insert_id();
        return $this->db->query("INSERT INTO pago_comision_ind ([id_comision], [id_usuario], [abono_neodata], [fecha_abono], [fecha_pago_intmex], [pago_neodata], [estatus], [creado_por], [comentario],[modificado_por]) VALUES (".$id.", ".$directorSelect.", ".$abonadoDir.", GETDATE(), NULL, NULL, 11, ".$this->session->userdata('id_usuario').", 'IMPORTACIÓN CONTRALORIA','".$this->session->userdata('id_usuario')."')");
    }
 
    function update_comisionessubDir($ideLote, $subdirectorSelect, $abonadosubDir, $totalsubDir, $porcentajesubDir){
        $this->db->query("INSERT INTO comisiones ([id_lote], [id_usuario], [comision_total], [estatus], [observaciones], [ooam], [loteReubicado], [creado_por], [fecha_creacion], [porcentaje_decimal], [fecha_autorizacion], [rol_generado],[modificado_por]) VALUES (".$ideLote.", ".$subdirectorSelect.", ".$totalsubDir.", 1, 'IMPORTACION', NULL, NULL, ".$this->session->userdata('id_usuario').", GETDATE(), ".$porcentajesubDir.", GETDATE(), 2,'".$this->session->userdata('id_usuario')."')");
        $id = $this->db->insert_id();
        return $this->db->query("INSERT INTO pago_comision_ind ([id_comision], [id_usuario], [abono_neodata], [fecha_abono], [fecha_pago_intmex], [pago_neodata], [estatus], [creado_por], [comentario],[modificado_por]) VALUES (".$id.", ".$subdirectorSelect.", ".$abonadosubDir.", GETDATE(), NULL, NULL, 11, ".$this->session->userdata('id_usuario').", 'IMPORTACIÓN CONTRALORIA','".$this->session->userdata('id_usuario')."')");
    }

    function update_comisionesGer($ideLote, $gerenteSelect, $abonadoGerente, $totalGerente, $porcentajeGerente){
        $this->db->query("INSERT INTO comisiones ([id_lote], [id_usuario], [comision_total], [estatus], [observaciones], [ooam], [loteReubicado], [creado_por], [fecha_creacion], [porcentaje_decimal], [fecha_autorizacion], [rol_generado],[modificado_por]) VALUES (".$ideLote.", ".$gerenteSelect.", ".$totalGerente.", 1, 'IMPORTACION', NULL, NULL, ".$this->session->userdata('id_usuario').", GETDATE(), ".$porcentajeGerente.", GETDATE(), 3,'".$this->session->userdata('id_usuario')."')");
        $id = $this->db->insert_id();
        return $this->db->query("INSERT INTO pago_comision_ind ([id_comision], [id_usuario], [abono_neodata], [fecha_abono], [fecha_pago_intmex], [pago_neodata], [estatus], [creado_por], [comentario],[modificado_por]) VALUES (".$id.", ".$gerenteSelect.", ".$abonadoGerente.", GETDATE(), NULL, NULL, 11, ".$this->session->userdata('id_usuario').", 'IMPORTACIÓN CONTRALORIA','".$this->session->userdata('id_usuario')."')");
    }
 
    function update_comisionesCoord($ideLote, $coordinadorSelect, $abonadoCoordinador, $totalCoordinador, $porcentajeCoordinador){
        $this->db->query("INSERT INTO comisiones ([id_lote], [id_usuario], [comision_total], [estatus], [observaciones], [ooam], [loteReubicado], [creado_por], [fecha_creacion], [porcentaje_decimal], [fecha_autorizacion], [rol_generado],[modificado_por]) VALUES (".$ideLote.", ".$coordinadorSelect.", ".$totalCoordinador.", 1, 'IMPORTACION', NULL, NULL, ".$this->session->userdata('id_usuario').", GETDATE(), ".$porcentajeCoordinador.", GETDATE(), 9,'".$this->session->userdata('id_usuario')."')");
        $id = $this->db->insert_id();
        return $this->db->query("INSERT INTO pago_comision_ind ([id_comision], [id_usuario], [abono_neodata], [fecha_abono], [fecha_pago_intmex], [pago_neodata], [estatus], [creado_por], [comentario],[modificado_por]) VALUES (".$id.", ".$coordinadorSelect.", ".$abonadoCoordinador.", GETDATE(), NULL, NULL, 11, ".$this->session->userdata('id_usuario').", 'IMPORTACIÓN CONTRALORIA','".$this->session->userdata('id_usuario')."')");
    }
  
    function update_comisionesAse($ideLote, $asesorSelect, $abonadoAsesor, $totalAsesor, $porcentajeAsesor){
        $this->db->query("INSERT INTO comisiones ([id_lote], [id_usuario], [comision_total], [estatus], [observaciones], [ooam], [loteReubicado], [creado_por], [fecha_creacion], [porcentaje_decimal], [fecha_autorizacion], [rol_generado],[modificado_por]) VALUES (".$ideLote.", ".$asesorSelect.", ".$totalAsesor.", 1, 'IMPORTACION', NULL, NULL, ".$this->session->userdata('id_usuario').", GETDATE(), ".$porcentajeAsesor.", GETDATE(), 7,'".$this->session->userdata('id_usuario')."')");
        $id = $this->db->insert_id();
        return $this->db->query("INSERT INTO pago_comision_ind ([id_comision], [id_usuario], [abono_neodata], [fecha_abono], [fecha_pago_intmex], [pago_neodata], [estatus], [creado_por], [comentario],[modificado_por]) VALUES (".$id.", ".$asesorSelect.", ".$abonadoAsesor.", GETDATE(), NULL, NULL, 11, ".$this->session->userdata('id_usuario').", 'IMPORTACIÓN CONTRALORIA',".$this->session->userdata('id_usuario').",'".$this->session->userdata('id_usuario')."')");
    }
  
    function update_comisioneMKTD($ideLote, $MKTDSelect, $abonadoMKTD, $totalMKTD, $porcentajeMKTD){
        $this->db->query("INSERT INTO comisiones ([id_lote], [id_usuario], [comision_total], [estatus], [observaciones], [ooam], [loteReubicado], [creado_por], [fecha_creacion], [porcentaje_decimal], [fecha_autorizacion], [rol_generado]) VALUES (".$ideLote.", ".$MKTDSelect.", ".$totalMKTD.", 1, 'IMPORTACION', NULL, NULL, ".$this->session->userdata('id_usuario').", GETDATE(), ".$porcentajeMKTD.", GETDATE(), 38,'".$this->session->userdata('id_usuario')."')");
        $id = $this->db->insert_id();
        return  $this->db->query("INSERT INTO pago_comision_ind ([id_comision], [id_usuario], [abono_neodata], [fecha_abono], [fecha_pago_intmex], [pago_neodata], [estatus], [creado_por], [comentario],[modificado_por]) VALUES (".$id.", ".$MKTDSelect.", ".$abonadoMKTD.", GETDATE(), NULL, NULL, 11, ".$this->session->userdata('id_usuario').", 'IMPORTACIÓN CONTRALORIA','".$this->session->userdata('id_usuario')."')");
    }
 
    function update_comisionesSUBCLUB($ideLote, $SubClubSelect, $abonadoSubClub, $totalSubClub, $porcentajeSubClub){
        $this->db->query("INSERT INTO comisiones ([id_lote], [id_usuario], [comision_total], [estatus], [observaciones], [ooam], [loteReubicado], [creado_por], [fecha_creacion], [porcentaje_decimal], [fecha_autorizacion], [rol_generado],[modificado_por]) VALUES (".$ideLote.", ".$SubClubSelect.", ".$totalSubClub.", 1, 'IMPORTACION', NULL, NULL, ".$this->session->userdata('id_usuario').", GETDATE(), ".$porcentajeSubClub.", GETDATE(), 42,'".$this->session->userdata('id_usuario')."')");
        $id = $this->db->insert_id();
        return  $this->db->query("INSERT INTO pago_comision_ind ([id_comision], [id_usuario], [abono_neodata], [fecha_abono], [fecha_pago_intmex], [pago_neodata], [estatus], [creado_por], [comentario],[modificado_por]) VALUES (".$id.", ".$SubClubSelect.", ".$abonadoSubClub.", GETDATE(), NULL, NULL, 11, ".$this->session->userdata('id_usuario').", 'IMPORTACIÓN CONTRALORIA','".$this->session->userdata('id_usuario')."')");
    }
 
    function update_comisionesEJECTCLUB($ideLote, $EjectClubSelect, $abonadoEjectClub, $totalEjectClub, $porcentajeEjectClub){
        $this->db->query("INSERT INTO comisiones ([id_lote], [id_usuario], [comision_total], [estatus], [observaciones], [ooam], [loteReubicado], [creado_por], [fecha_creacion], [porcentaje_decimal], [fecha_autorizacion], [rol_generado],[modificado_por]) VALUES (".$ideLote.", ".$EjectClubSelect.", ".$totalEjectClub.", 1, 'IMPORTACION', NULL, NULL, ".$this->session->userdata('id_usuario').", GETDATE(), ".$porcentajeEjectClub.", GETDATE() ,42,'".$this->session->userdata('id_usuario')."')");
        $id = $this->db->insert_id();
        return $this->db->query("INSERT INTO pago_comision_ind ([id_comision], [id_usuario], [abono_neodata], [fecha_abono], [fecha_pago_intmex], [pago_neodata], [estatus], [creado_por], [comentario],[modificado_por]) VALUES (".$id.", ".$EjectClubSelect.", ".$abonadoEjectClub.", GETDATE(), NULL, NULL, 11, ".$this->session->userdata('id_usuario').", 'IMPORTACIÓN CONTRALORIA','".$this->session->userdata('id_usuario')."')");
    }
    
    function update_comisionesGreenham($ideLote, $GreenSelect, $abonadoGreenham, $totalGreenham, $porcentajeGreenham){
        $this->db->query("INSERT INTO comisiones ([id_lote], [id_usuario], [comision_total], [estatus], [observaciones], [ooam], [loteReubicado], [creado_por], [fecha_creacion], [porcentaje_decimal], [fecha_autorizacion], [rol_generado],[modificado_por]) VALUES (".$ideLote.", ".$GreenSelect.", ".$totalGreenham.", 1, 'IMPORTACION', NULL, NULL, ".$this->session->userdata('id_usuario').", GETDATE(), ".$porcentajeGreenham.", GETDATE(), 7,'".$this->session->userdata('id_usuario')."')");
        $id = $this->db->insert_id();
        return  $this->db->query("INSERT INTO pago_comision_ind ([id_comision], [id_usuario], [abono_neodata], [fecha_abono], [fecha_pago_intmex], [pago_neodata], [estatus], [creado_por], [comentario],[modificado_por]) VALUES (".$id.", ".$GreenSelect.", ".$abonadoGreenham.", GETDATE(), NULL, NULL, 11, ".$this->session->userdata('id_usuario').", 'IMPORTACIÓN CONTRALORIA','".$this->session->userdata('id_usuario')."')");
    }
 
    function getComments($pago){
        $this->db->query("SET LANGUAGE Español;");
        return $this->db->query("SELECT DISTINCT(hc.comentario), hc.id_pago_i, hc.id_usuario, convert(nvarchar(20), hc.fecha_movimiento, 113) date_final, hc.fecha_movimiento, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre_usuario
        FROM historial_comisiones hc 
        INNER JOIN pago_comision_ind pci ON pci.id_pago_i = hc.id_pago_i
        INNER JOIN usuarios u ON u.id_usuario = hc.id_usuario 
        WHERE hc.id_pago_i = $pago
        ORDER BY hc.fecha_movimiento DESC");
    }
 
    function getCommentsDU($user){
        return $this->db->query("SELECT pci.abono_neodata as comentario,concat(' - ',pci.comentario) comentario2, pci.id_pago_i, pci.modificado_por, convert(nvarchar(20), pci.fecha_abono, 113) date_final, pci.fecha_abono, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre_usuario
        FROM pago_comision_ind pci  
        INNER JOIN historial_comisiones hc ON hc.id_pago_i = pci.id_pago_i and (hc.comentario like '%motivo%' OR hc.comentario like '%mótivo%' )
        INNER JOIN usuarios u ON u.id_usuario = hc.id_usuario 
        WHERE pci.estatus = 17 AND pci.id_usuario = $user
        ORDER BY pci.fecha_abono DESC");
    }
 
    function getDataMarketing($a, $b){
        return $this->db->query("SELECT ck.comentario, ck.fecha_creacion, ck.enganche, ck.fecha_prospecion_mktd, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) as nombre
        FROM cobranza_mktd ck
        INNER JOIN usuarios u ON u.id_usuario = ck.creado_por
        WHERE ck.id_lote = $a AND ck.id_cliente = $b");
    }

    function update_acepta_contraloria($idsol) {
        return $this->db->query("UPDATE pago_comision_ind SET estatus = 8,modificado_por='".$this->session->userdata('id_usuario')."' WHERE estatus IN (4,13) AND id_pago_i IN (".$idsol.")");
    }

    function update_contraloria_especial($idsol) {
        return $this->db->query("UPDATE pago_comision_ind SET estatus = 11 ,modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_i IN (".$idsol.")");
    }

    function update_mktd_contraloria($idsol) {
        return $this->db->query("UPDATE pago_comision_mktd SET estatus = 8 WHERE estatus = 1");
    }

    function update_acepta_INTMEX($idsol) {
        return $this->db->query("UPDATE pago_comision_ind SET estatus = 11, aply_pago_intmex = GETDATE(),modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_i IN (".$idsol.")");
    }

    function update_mktd_INTMEX($idsol) {
        return $this->db->query("UPDATE pago_comision_mktd SET estatus = 11 WHERE estatus = 8");
    }

    function update_acepta_PAUSADA($idsol) {
        return $this->db->query("UPDATE pago_comision_ind SET estatus = 1, modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_i IN (".$idsol.")");
    }
    
    function getDatosResguardoContraloria($usuario,$proyecto){
        if($proyecto == 0){
            $filtro_00 = ' ';
        } else{
            $filtro_00 = ' AND re.idResidencial = '.$proyecto.' ';
        }
        
        switch ($this->session->userdata('id_rol')) {
            case 1:
            case 2:
            case 3:
                $filtro_02 = ' pci1.estatus IN (3) AND com.id_usuario = '.$this->session->userdata('id_usuario').' '.$filtro_00;
            break;
    
            default:
                $filtro_02 = ' pci1.estatus IN (3) AND pci1.id_usuario = '.$usuario.' '.$filtro_00;
            break;
        }
        
        return $this->db->query("(SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata,pci1.estatus, pci1.fecha_pago_intmex fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario ,pci1.id_usuario, oprol.nombre as puesto, 0, u.forma_pago, 0 as factura, pac.porcentaje_abono, (CASE WHEN com.ooam = 1 THEN  CONCAT(oxcest.nombre,' (OOAM)') ELSE oxcest.nombre END) estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, 0 lugar_prospeccion, co.nombre as condominio, lo.referencia, pci1.abono_neodata impuesto, 0 valimpuesto, 0 dcto
        FROM pago_comision_ind pci1 
        LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE (estatus in (11,3) OR descuento_aplicado = 1) 
        GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
        INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
        INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
        INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
        INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
        INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23
        LEFT JOIN facturas f ON f.id_comision = com.id_comision
        WHERE $filtro_02 and ( (lo.idStatusContratacion < 9 AND com.estatus IN (1,8)) OR (lo.idStatusContratacion > 8 AND com.estatus IN (8)))
        GROUP BY pci1.id_comision,com.ooam, pci1.id_pago_i, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex, u.nombre, u.apellido_paterno, u.apellido_materno, pci1.id_usuario, oprol.nombre, u.forma_pago, pac.porcentaje_abono, oxcest.nombre, oxcest.id_opcion, re.empresa, co.nombre, lo.referencia, pci1.abono_neodata)
        UNION
        (SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario ,pci1.id_usuario, oprol.nombre as puesto, cl.personalidad_juridica, u.forma_pago, 0 as factura, pac.porcentaje_abono, (CASE WHEN com.ooam = 1 THEN  CONCAT(oxcest.nombre,' (OOAM)') ELSE oxcest.nombre END) estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, cl.lugar_prospeccion, co.nombre as condominio, lo.referencia, pci1.abono_neodata impuesto, 0 valimpuesto, 0 dcto
        FROM pago_comision_ind pci1 
        LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE (estatus in (11,3) OR descuento_aplicado = 1) 
        GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
        INNER JOIN comisiones com ON pci1.id_comision = com.id_comision AND com.estatus in (1)
        INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial 
        INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 1
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
        INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
        INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
        INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23
        LEFT JOIN facturas f ON f.id_comision = com.id_comision
        WHERE $filtro_02 and lo.idStatusContratacion > 8 
        GROUP BY pci1.id_pago_i,com.ooam, pci1.id_comision, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata , pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex , u.nombre, u.apellido_paterno, u.apellido_materno,pci1.id_usuario, oprol.nombre , cl.personalidad_juridica, u.forma_pago, pac.porcentaje_abono, oxcest.nombre , oxcest.id_opcion, re.empresa, cl.lugar_prospeccion, co.nombre, lo.referencia, pci1.abono_neodata) 
        ORDER BY lo.nombreLote");
    }

    function getDatosRevisionFactura($proyecto,$condominio){
        if($condominio == 0){
            return $this->db->query("SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, oxc.nombre as lugar_prosp, pci1.estatus, pci1.fecha_abono fecha_creacion, pci1.id_usuario, u.forma_pago, f.id_comision as factura, pac.porcentaje_abono, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) as usuario, oxcrol.nombre AS puesto, re.empresa
            FROM pago_comision_ind pci1 
            LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE (estatus in (11,3) OR descuento_aplicado = 1) GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
            INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
            INNER JOIN lotes lo ON lo.idLote = com.id_lote
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
            INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
            INNER JOIN clientes cl ON cl.idLote = lo.idLote
            INNER JOIN porcentajes_comisiones pc ON pc.relacion_prospeccion = cl.lugar_prospeccion
            INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = pc.medio_comision
            INNER JOIN usuarios u ON u.id_usuario = pci1.id_usuario
            INNER JOIN opcs_x_cats oxcpj ON oxcpj.id_opcion = u.forma_pago
            INNER JOIN opcs_x_cats oxcrol ON oxcrol.id_opcion = u.id_rol
            INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
            LEFT JOIN facturas f ON f.id_comision = com.id_comision
            WHERE cl.status = 1 AND re.idResidencial = $proyecto AND pci1.estatus = 4 AND com.estatus in (1,8) AND u.forma_pago in (2) AND oxcpj.id_catalogo = 16 AND oxc.id_catalogo = 30 AND oxcrol.id_catalogo = 1
            GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, oxc.nombre, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, oxcpj.nombre, cl.personalidad_juridica, u.forma_pago, f.id_comision, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno, u.apellido_materno, oxcrol.nombre, re.empresa"); 
        }else{
            return $this->db->query("SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, oxc.nombre as lugar_prosp, pci1.estatus, pci1.fecha_abono fecha_creacion, pci1.id_usuario, u.forma_pago, f.id_comision as factura, pac.porcentaje_abono, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) as usuario, oxcrol.nombre AS puesto, re.empresa
            FROM pago_comision_ind pci1 
            LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE (estatus in (11,3) OR descuento_aplicado = 1) 
            GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
            INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
            INNER JOIN lotes lo ON lo.idLote = com.id_lote
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
            INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
            INNER JOIN clientes cl ON cl.idLote = lo.idLote
            INNER JOIN porcentajes_comisiones pc ON pc.relacion_prospeccion = cl.lugar_prospeccion
            INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = pc.medio_comision
            INNER JOIN usuarios u ON u.id_usuario = pci1.id_usuario
            INNER JOIN opcs_x_cats oxcpj ON oxcpj.id_opcion = u.forma_pago
            INNER JOIN opcs_x_cats oxcrol ON oxcrol.id_opcion = u.id_rol
            INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
            LEFT JOIN facturas f ON f.id_comision = com.id_comision
            WHERE cl.status = 1 AND co.idCondominio = $condominio AND pci1.estatus = 4 AND com.estatus in (1,8) AND u.forma_pago in (2) AND oxcpj.id_catalogo = 16 AND oxc.id_catalogo = 30 AND oxcrol.id_catalogo = 1
            GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, oxc.nombre, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, oxcpj.nombre, cl.personalidad_juridica, u.forma_pago, f.id_comision, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno, u.apellido_materno, oxcrol.nombre, re.empresa");
        }
    }
    
    function getDatosRevisionAsimilados($proyecto,$condominio){
     if($condominio == 0){
        return $this->db->query("SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, oxc.nombre as lugar_prosp, pci1.estatus, pci1.fecha_abono fecha_creacion, pci1.id_usuario, u.forma_pago, f.id_comision as factura, pac.porcentaje_abono, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) as usuario, oxcrol.nombre AS puesto, re.empresa
        FROM pago_comision_ind pci1 
        LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE (estatus in (11,3) OR descuento_aplicado = 1) 
        GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
        INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
        INNER JOIN lotes lo ON lo.idLote = com.id_lote
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        INNER JOIN clientes cl ON cl.idLote = lo.idLote
        INNER JOIN porcentajes_comisiones pc ON pc.relacion_prospeccion = cl.lugar_prospeccion
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = pc.medio_comision
        INNER JOIN usuarios u ON u.id_usuario = pci1.id_usuario
        INNER JOIN opcs_x_cats oxcpj ON oxcpj.id_opcion = u.forma_pago
        INNER JOIN opcs_x_cats oxcrol ON oxcrol.id_opcion = u.id_rol
        INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
        LEFT JOIN facturas f ON f.id_comision = com.id_comision
        WHERE cl.status = 1 AND re.idResidencial = $proyecto AND pci1.estatus = 4 AND com.estatus in (1,8) AND u.forma_pago in (3) AND oxcpj.id_catalogo = 16 AND oxc.id_catalogo = 30   AND oxcrol.id_catalogo = 1
        GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, oxc.nombre, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, oxcpj.nombre, cl.personalidad_juridica, u.forma_pago, f.id_comision, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno, u.apellido_materno, oxcrol.nombre, re.empresa");
    }else{
        return $this->db->query("SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, oxc.nombre as lugar_prosp, pci1.estatus, pci1.fecha_abono fecha_creacion, pci1.id_usuario, u.forma_pago, f.id_comision as factura, pac.porcentaje_abono, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) as usuario, oxcrol.nombre AS puesto, re.empresa
        FROM pago_comision_ind pci1 
        LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE (estatus in (11,3) OR descuento_aplicado = 1) 
        GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
        INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
        INNER JOIN lotes lo ON lo.idLote = com.id_lote
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        INNER JOIN clientes cl ON cl.idLote = lo.idLote
        INNER JOIN porcentajes_comisiones pc ON pc.relacion_prospeccion = cl.lugar_prospeccion
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = pc.medio_comision
        INNER JOIN usuarios u ON u.id_usuario = pci1.id_usuario
        INNER JOIN opcs_x_cats oxcpj ON oxcpj.id_opcion = u.forma_pago
        INNER JOIN opcs_x_cats oxcrol ON oxcrol.id_opcion = u.id_rol
        INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
        LEFT JOIN facturas f ON f.id_comision = com.id_comision
        WHERE cl.status = 1 AND co.idCondominio = $condominio AND pci1.estatus = 4 AND com.estatus in (1,8) AND u.forma_pago in (3) AND oxcpj.id_catalogo = 16 AND oxc.id_catalogo = 30   AND oxcrol.id_catalogo = 1
        GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, oxc.nombre, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, oxcpj.nombre, cl.personalidad_juridica, u.forma_pago, f.id_comision, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno, u.apellido_materno, oxcrol.nombre, re.empresa");    
        }
    }
   
    function update_estatus_pausa($id_pago_i, $obs, $estatus) {
        $id_user_Vl = $this->session->userdata('id_usuario');
        $this->db->query("INSERT INTO  historial_comisiones VALUES ($id_pago_i, ".$id_user_Vl.", GETDATE(), 1, 'SE PAUSÓ COMISIÓN, MOTIVO: ".$obs."')");
        return $this->db->query("UPDATE pago_comision_ind SET estatus = ".$estatus.", comentario = '".$obs."',modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_i IN (".$id_pago_i.")");
    }

    function update_estatus_despausa($id_pago_i, $obs, $estatus) {
        $id_user_Vl = $this->session->userdata('id_usuario');
        $this->db->query("INSERT INTO  historial_comisiones VALUES ($id_pago_i, ".$id_user_Vl.", GETDATE(), 1, 'SE ACTIVÓ COMISIÓN, MOTIVO: ".$obs."')");
        return $this->db->query("UPDATE pago_comision_ind SET estatus = ".$estatus.", comentario = '".$obs."',modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_i IN (".$id_pago_i.")");
    }

    function update_estatus_refresh($idcom) {
        $id_user_Vl = $this->session->userdata('id_usuario');
        $this->db->query("INSERT INTO  historial_comisiones VALUES ($idcom, $id_user_Vl, GETDATE(), 1, 'SE ACTIVÓ NUEVAMENTE COMISIÓN')");
        return $this->db->query("UPDATE pago_comision_ind SET estatus = 4,modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_i IN (".$idcom.")");
    } 
    
    public function InsertPagoComision($lote,$sumaComi,$sumaDispo,$porcentaje,$resta,$id_user,$pagado,$bonificacion){
        $QUERY_VOBO =  $this->db->query("SELECT id_pagoc FROM pago_comision WHERE id_lote = ".$lote."");
        if($QUERY_VOBO->num_rows() > 0){
            $respuesta =  $this->db->query("UPDATE pago_comision SET total_comision = $sumaComi, abonado = $sumaDispo, porcentaje_abono = $porcentaje, pendiente = $resta, creado_por = $id_user, fecha_modificacion = GETDATE(), ultimo_pago = $pagado, bonificacion = $bonificacion, ultima_dispersion = GETDATE(), numero_dispersion = (numero_dispersion+1) WHERE id_lote = $lote");
        } else{
            $respuesta =  $this->db->query("INSERT INTO pago_comision ([id_lote],[total_comision],[abonado],[porcentaje_abono],[pendiente],[creado_por],[fecha_modificacion],[fecha_abono],[bandera],[ultimo_pago],[bonificacion],[fecha_neodata],[modificado_por],[new_neo],[ultima_dispersion],[numero_dispersion],[monto_anticipo]) VALUES ($lote,$sumaComi,$sumaDispo,$porcentaje,$resta,$id_user,GETDATE(),GETDATE(),1,$pagado,$bonificacion,null,null,null,GETDATE(),1,$sumaDispo)");
        }

        if (! $respuesta ) {
        return 0;
        } else {
        return 1;
        }
    }

    public function UpdateLoteLiquidar($lote){
        $respuesta =  $this->db->query("UPDATE pago_comision_ind SET estatus = 0,modificado_por='".$this->session->userdata('id_usuario')."' WHERE abono_neodata = 0");
        $respuesta =  $this->db->query("UPDATE comisiones SET estatus = 0,modificado_por='".$this->session->userdata('id_usuario')."' WHERE comision_total = 0");
        $respuesta =  $this->db->query("UPDATE pago_comision SET pendiente = 0 WHERE id_lote = $lote");
        $respuesta =  $this->db->query("UPDATE lotes SET registro_comision = 7 WHERE idLote = $lote");
        if (! $respuesta ) {
        return 0;
        } else {
        return 1;
        }
    }

    public function UpdateLoteDisponible($lote){
        $respuesta =  $this->db->query("UPDATE pago_comision SET bandera = 1 WHERE id_lote = $lote");
        $respuesta =  $this->db->query("UPDATE pago_comision_ind SET estatus = 0,modificado_por='".$this->session->userdata('id_usuario')."' WHERE abono_neodata = 0");
        $respuesta =  $this->db->query("UPDATE comisiones SET estatus = 0,modificado_por='".$this->session->userdata('id_usuario')."' WHERE comision_total = 0");
        $respuesta =  $this->db->query("UPDATE lotes SET registro_comision = 1,usuario=".$this->session->userdata('id_usuario')." WHERE idLote = $lote");
        if (! $respuesta ) {
        return 0;
        } else {
        return 1;
        }
    }

    public function getDatosDispersarCompartidas($idlote){
        return $this->db->query("SELECT l.idLote, cl.id_cliente, l.referencia, r.idResidencial, l.nombreLote, c.nombre as nombreCondominio, r.nombreResidencial, cl.nombre, cl.apellido_paterno, cl.apellido_materno, l.totalNeto2, ae.id_usuario as id_asesor, CONCAT(ae.nombre, ' ', ae.apellido_paterno, ' ', ae.apellido_materno) as asesor, co.id_usuario as id_coordinador, CONCAT(co.nombre, ' ', co.apellido_paterno, ' ', co.apellido_materno) as coordinador, ge.id_usuario as id_gerente, CONCAT(ge.nombre, ' ', ge.apellido_paterno, ' ', ge.apellido_materno) as gerente, su.id_usuario as id_subdirector, CONCAT(su.nombre, ' ', su.apellido_paterno, ' ', su.apellido_materno) as subdirector, cl.fechaApartado
        FROM ventas_compartidas vc
        INNER JOIN clientes cl ON vc.id_cliente = cl.id_cliente
        INNER JOIN lotes l ON l.idLote = cl.idLote
        INNER JOIN condominios c ON c.idCondominio = l.idCondominio
        INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
        INNER JOIN  usuarios ae ON ae.id_usuario = vc.id_asesor
        LEFT JOIN  usuarios co ON co.id_usuario = vc.id_coordinador
        LEFT JOIN  usuarios ge ON ge.id_usuario = vc.id_gerente
        LEFT JOIN  usuarios su ON su.id_usuario = vc.id_subdirector
        LEFT JOIN  usuarios di ON di.id_usuario = su.id_lider
        WHERE l.idLote = ".$idlote." AND vc.estatus = 1 AND cl.status = 1");
    }

    function insert_pago_individual($id_comision, $id_usuario, $abono_nuevo){
        $this->db->query("INSERT INTO pago_comision_ind (id_comision, id_usuario, abono_neodata, fecha_abono, fecha_pago_intmex, estatus, pago_neodata, creado_por, comentario,modificado_por) VALUES (".$id_comision.", ".$id_usuario.", ".$abono_nuevo.", GETDATE(), GETDATE(), 11, 0, ".$this->session->userdata('id_usuario').", 'IMPORTACION NUEVO ABONO','".$this->session->userdata('id_usuario')."')");
    }

    function update_pago_general($suma, $ideLote){
        $this->db->query("UPDATE pago_comision SET abonado = (abonado + ".$suma."), pendiente = (total_comision-abonado-".$suma.") WHERE id_lote = ".$ideLote."");
    }

    function insert_dispersion_individual($id_comision, $id_usuario, $abono_nuevo, $pago){

        
        $respuesta = $this->db->query("INSERT INTO pago_comision_ind (id_comision, id_usuario, abono_neodata, fecha_abono, fecha_pago_intmex, estatus, pago_neodata, creado_por, comentario,modificado_por) VALUES (".$id_comision.", ".$id_usuario.", ".$abono_nuevo.", GETDATE(), GETDATE(), 1, ".$pago.", ".$this->session->userdata('id_usuario').", 'NUEVO PAGO','".$this->session->userdata('id_usuario')."')");

        $insert_id_2 = $this->db->insert_id();

        $respuesta = $this->db->query("INSERT INTO historial_comisiones VALUES ($insert_id_2, ".$this->session->userdata('id_usuario').", GETDATE(), 1, 'DISPERSÓ PAGO DE COMISIÓN')");

        $respuesta = $this->db->query("UPDATE comisiones SET liquidada = 1 
        FROM comisiones com
        LEFT JOIN (SELECT SUM(abono_neodata) abonado, id_comision FROM pago_comision_ind GROUP BY id_comision) as pci ON pci.id_comision = com.id_comision
        WHERE com.id_comision = $id_comision AND com.ooam IN (2) AND (com.comision_total-abonado) < 1");

        if (! $respuesta ) {
            return 0;
            } else {   
            return 1;
            }
    }

    function update_pago_dispersion($suma, $ideLote, $pago){
        $respuesta = $this->db->query("UPDATE pago_comision SET abonado = (abonado + ".$suma."), pendiente = (total_comision-abonado-".$suma."), bandera = 1, ultimo_pago = ".$pago." , ultima_dispersion = GETDATE() WHERE id_lote = ".$ideLote."");
        if (! $respuesta ) {
            return 0;
        } else {
            return 1;
        }
    }
    
    public function getDataLiquidadasPago($val = '') {
        ini_set('memory_limit', -1);
     
        $query = $this->db->query("SELECT DISTINCT(l.idLote), l.nombreLote,  res.nombreResidencial, cond.nombre as nombreCondominio,
        CONCAT(cl.nombre,' ',cl.apellido_paterno,' ',cl.apellido_materno) nombreCliente, 
        (CASE WHEN l.tipo_venta = 1 THEN 'Particular' WHEN l.tipo_venta = 2 THEN 'NORMAL' WHEN l.tipo_venta = 7 THEN 'ESPECIAL' ELSE ' SIN DEFINIR' END) tipo_venta,
        (CASE WHEN l.tipo_venta = 1 THEN 'lbl-warning' WHEN l.tipo_venta = 2 THEN 'lbl-green' WHEN l.tipo_venta = 7 THEN 'lbl-violetDeep' ELSE 'lbl-gray' END) claseTipo_venta,
        (CASE WHEN cl.proceso = 0 THEN '' ELSE oxc0.nombre END) procesoCl,
        (CASE WHEN cl.proceso = 0 THEN '' ELSE 'label lbl-violetBoots' END) colorProcesoCl,
        vc.id_cliente AS compartida, l.idStatusContratacion, cl.id_cliente, pc.fecha_modificacion, convert(nvarchar, pc.fecha_modificacion, 6) fecha_sistema, 
        convert(nvarchar, pc.fecha_neodata, 6) fecha_neodata,
        CONCAT(ae.nombre, ' ', ae.apellido_paterno, ' ', ae.apellido_materno) as asesor,
        CONCAT(co.nombre, ' ', co.apellido_paterno, ' ', co.apellido_materno) as coordinador,
        CONCAT(ge.nombre, ' ', ge.apellido_paterno, ' ', ge.apellido_materno) as gerente,
        CONCAT(su.nombre, ' ', su.apellido_paterno, ' ', su.apellido_materno) as subdirector, 
        (CASE WHEN re.id_usuario IN (0) OR re.id_usuario IS NULL THEN 'NA' ELSE CONCAT(re.nombre, ' ', re.apellido_paterno, ' ', re.apellido_materno) END)regional, l.totalNeto2,
        CONCAT(di.nombre, ' ', di.apellido_paterno, ' ', di.apellido_materno) as director,  
        (CASE WHEN cl.plan_comision IN (0) OR cl.plan_comision IS NULL THEN '-' ELSE pl.descripcion END) AS plan_descripcion, cl.plan_comision, cl.id_subdirector, cl.id_prospecto, abono_comisiones, pc.abonado, 
        (CASE WHEN ((abono_comisiones-pc.abonado) BETWEEN -1 AND 1) OR (abono_comisiones-pc.abonado) IS NULL THEN 0 ELSE (abono_comisiones-pc.abonado)END) pendiente, porcentaje_comisiones
        FROM lotes l
        INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
        INNER JOIN condominios cond ON l.idCondominio=cond.idCondominio
        INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
        INNER JOIN usuarios ae ON ae.id_usuario = cl.id_asesor
        LEFT JOIN pago_comision pc ON pc.id_lote = l.idLote
        LEFT JOIN (SELECT SUM(comision_total) abono_comisiones, id_lote FROM comisiones WHERE estatus in (1) AND id_usuario not in (0) GROUP BY id_lote) cm ON cm.id_lote = l.idLote 
        LEFT JOIN (SELECT SUM(porcentaje_decimal) porcentaje_comisiones, id_lote FROM comisiones WHERE estatus in (1) AND id_usuario not in (0) GROUP BY id_lote) pcm ON pcm.id_lote = l.idLote
        LEFT JOIN (SELECT id_cliente FROM ventas_compartidas WHERE estatus = 1) AS vc ON vc.id_cliente = cl.id_cliente
        LEFT JOIN usuarios co ON co.id_usuario = cl.id_coordinador
        LEFT JOIN usuarios ge ON ge.id_usuario = cl.id_gerente
        LEFT JOIN usuarios su ON su.id_usuario = cl.id_subdirector
        LEFT JOIN usuarios re ON re.id_usuario = cl.id_regional
        LEFT JOIN usuarios di ON di.id_usuario = 2
        LEFT JOIN plan_comision pl ON pl.id_plan = cl.plan_comision
        LEFT JOIN sedes se ON se.id_sede = cl.id_sede 
        LEFT JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = cl.proceso AND oxc0.id_catalogo = 97
        WHERE l.idStatusContratacion BETWEEN 11 AND 15 AND cl.status = 1 AND l.status = 1 AND l.registro_comision in (7) AND tipo_venta IS NOT NULL AND tipo_venta IN (1,2,7)
        ORDER BY l.idLote");
        return $query ;
    }
    
    public function validateSettledCommissions($idlote){
        return $this->db->query("SELECT * FROM comisiones WHERE id_lote = $idlote");
    }

    public function validateDispersionCommissions($lote){
        return $this->db->query("SELECT count(*) dispersion, pc.bandera 
        FROM comisiones com
        LEFT JOIN pago_comision pc ON pc.id_lote = com.id_lote and pc.bandera = 0
        WHERE com.id_lote = $lote /*AND com.id_usuario = 2*/ AND com.estatus = 1 AND com.fecha_creacion <= GETDATE() GROUP BY pc.bandera");
    }

    function getDatosNuevasAContraloria($proyecto, $condominio){
        if( $this->session->userdata('id_rol') == 31) { // INTERNOMEX
            $filtro = "pci1.estatus IN (8, 88) AND com.id_usuario = $condominio";
            $where = "";
        } else { // CONTRALORÍA
            $filtro = "pci1.estatus IN (4)";
            if($condominio == 0)
                $where = "AND co.idResidencial  = $proyecto";
            else
            $where = "AND co.idCondominio  = $condominio";
        }
            return $this->db->query("(SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario,cp1.codigo_postal, pci1.id_usuario, CASE WHEN cl.estructura = 1 THEN oprol2.nombre ELSE oprol.nombre END as puesto, 0 personalidad_juridica, u.forma_pago, 0 as factura, pac.porcentaje_abono, (CASE WHEN com.ooam = 1 THEN  CONCAT(oxcest.nombre,' (OOAM)') ELSE oxcest.nombre END) estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, 0 lugar_prospeccion, co.nombre as condominio, lo.referencia, (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, (CASE u.forma_pago WHEN 3 THEN (((sed.impuesto)/100)*pci1.abono_neodata) ELSE 0 END) dcto, sed.impuesto valimpuesto, u.rfc
            FROM pago_comision_ind pci1 
            INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
            INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
            INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
            INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 1
            INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (3)
            INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
            INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
            INNER JOIN cp_usuarios cp1 ON pci1.id_usuario = cp1.id_usuario
            INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
            INNER JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 2 WHEN 4 THEN 5 WHEN 5 THEN 3 WHEN 607 THEN 1 WHEN 7092 THEN 4 WHEN 9629 THEN 2 ELSE u.id_sede END) and sed.estatus = 1
            LEFT JOIN opcs_x_cats oprol2 ON oprol2.id_opcion = com.rol_generado AND oprol2.id_catalogo = 83
            WHERE $filtro $where AND com.estatus in (1) AND lo.idStatusContratacion > 8
            GROUP BY pci1.id_comision,com.ooam, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex, pci1.id_usuario, u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, cp1.codigo_postal, oxcest.id_opcion, re.empresa, co.nombre, lo.referencia, sed.impuesto, u.rfc, oprol2.nombre, cl.estructura)
            UNION
            (SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario, cp1.codigo_postal, pci1.id_usuario, CASE WHEN cl.estructura = 1 THEN oprol2.nombre ELSE oprol.nombre END as puesto, 0 personalidad_juridica, u.forma_pago, 0 as factura, pac.porcentaje_abono, (CASE WHEN com.ooam = 1 THEN  CONCAT(oxcest.nombre,' (OOAM)') ELSE oxcest.nombre END) estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, 0 lugar_prospeccion, co.nombre as condominio, lo.referencia, (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, (CASE u.forma_pago WHEN 3 THEN (((sed.impuesto)/100)*pci1.abono_neodata) ELSE 0 END) dcto, sed.impuesto valimpuesto, u.rfc
            FROM pago_comision_ind pci1 
            INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
            INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
            INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
            INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (3)
            INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
            INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
            INNER JOIN cp_usuarios cp1 ON pci1.id_usuario = cp1.id_usuario
            INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
            INNER JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario 
            WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 2 WHEN 4 THEN 5 WHEN 5 THEN 3 WHEN 607 THEN 1 WHEN 7092 THEN 4 WHEN 9629 THEN 2 ELSE u.id_sede END) and sed.estatus = 1
            LEFT JOIN clientes cl ON cl.idLote = lo.idLote AND cl.id_cliente = com.idCliente
            LEFT JOIN opcs_x_cats oprol2 ON oprol2.id_opcion = com.rol_generado AND oprol2.id_catalogo = 83
            WHERE $filtro $where AND ((lo.idStatusContratacion < 9 AND com.estatus IN (1,8)) OR (lo.idStatusContratacion > 8  AND com.estatus IN (8)))   
            GROUP BY pci1.id_comision,com.ooam, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex, pci1.id_usuario, u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, cp1.codigo_postal, oxcest.nombre, oxcest.id_opcion, re.empresa, co.nombre, lo.referencia,sed.impuesto, u.rfc, oprol2.nombre, cl.estructura)");                
    }

    function getDatosNuevasRContraloria($proyecto,$condominio){
        if($this->session->userdata('id_rol') == 31) { // INTERNOMEX
            $filtro = " pci1.estatus IN (8, 88) AND com.id_usuario = $condominio";
            $where = "";
        } else { // CONTRALORÍA
            $filtro = " pci1.estatus IN (4)";
            if($condominio == 0)
                $where = "AND co.idResidencial  = $proyecto";
            else
                $where = "AND co.idCondominio  = $condominio";
            }

        return $this->db->query("(SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario, pci1.id_usuario, CASE WHEN cl.estructura = 1 THEN oprol2.nombre ELSE oprol.nombre END as puesto, 0 personalidad_juridica, u.forma_pago, 0 as factura, pac.porcentaje_abono, (CASE WHEN com.ooam = 1 THEN  CONCAT(oxcest.nombre,' (OOAM)') ELSE oxcest.nombre END) estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, 0 lugar_prospeccion, co.nombre as condominio, lo.referencia, pci1.abono_neodata impuesto, 0 dcto, u.rfc
        FROM pago_comision_ind pci1 
        INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
        INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio 
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial 
        INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 1
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (4)
        INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
        INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
        INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
        LEFT JOIN opcs_x_cats oprol2 ON oprol2.id_opcion = com.rol_generado AND oprol2.id_catalogo = 83
        WHERE $filtro $where AND com.estatus in (1) AND lo.idStatusContratacion > 8 AND com.id_usuario NOT IN(7689,6019)
        GROUP BY pci1.id_comision,com.ooam, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex, pci1.id_usuario, u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, co.nombre, lo.referencia, u.rfc, oprol2.nombre, cl.estructura)
        UNION
        (SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario, pci1.id_usuario, CASE WHEN cl.estructura = 1 THEN oprol2.nombre ELSE oprol.nombre END as puesto, 0 personalidad_juridica,u.forma_pago, 0 as factura, pac.porcentaje_abono, (CASE WHEN com.ooam = 1 THEN  CONCAT(oxcest.nombre,' (OOAM)') ELSE oxcest.nombre END) estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, 0 lugar_prospeccion, co.nombre as condominio, lo.referencia, pci1.abono_neodata impuesto, 0 dcto, u.rfc
        FROM pago_comision_ind pci1 
        INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
        INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial 
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (4)
        INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
        INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
        INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
        LEFT JOIN clientes cl ON cl.idLote = lo.idLote AND cl.id_cliente = com.idCliente
        LEFT JOIN opcs_x_cats oprol2 ON oprol2.id_opcion = com.rol_generado AND oprol2.id_catalogo = 83
        WHERE $filtro $where AND ( (lo.idStatusContratacion < 9 AND com.estatus IN (1,8)) OR (lo.idStatusContratacion > 8  AND com.estatus IN (8))) AND com.id_usuario NOT IN(7689,6019)   
        GROUP BY pci1.id_comision,com.ooam, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex, pci1.id_usuario, u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, co.nombre, lo.referencia, u.rfc, oprol2.nombre, cl.estructura)");
    }
    
    function getDatosEspecialRContraloria(){

        return $this->db->query("(SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario ,pci1.id_usuario, oprol.nombre as puesto, 0 personalidad_juridica, u.forma_pago, 0 as factura, pac.porcentaje_abono, (CASE WHEN com.ooam = 1 THEN  CONCAT(oxcest.nombre,' (OOAM)') ELSE oxcest.nombre END) estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, 0 lugar_prospeccion, co.nombre as condominio, lo.referencia, pci1.abono_neodata impuesto, 0 dcto, u.rfc
        FROM pago_comision_ind pci1 
        INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
        INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 AND lo.tipo_venta in (7)
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio 
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial 
        INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 1
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (4)
        INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
        INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
        INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
        WHERE pci1.estatus IN (4) AND com.estatus in (1) AND lo.idStatusContratacion > 8 AND com.id_usuario in(7689,6019)
        GROUP BY pci1.id_comision,com.ooam, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex, pci1.id_usuario, u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, co.nombre, lo.referencia, u.rfc)
        UNION
        (SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario ,pci1.id_usuario, oprol.nombre as puesto, 0 personalidad_juridica, u.forma_pago, 0 as factura, pac.porcentaje_abono, (CASE WHEN com.ooam = 1 THEN  CONCAT(oxcest.nombre,' (OOAM)') ELSE oxcest.nombre END) estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, 0 lugar_prospeccion, co.nombre as condominio, lo.referencia, pci1.abono_neodata impuesto, 0 dcto, u.rfc
        FROM pago_comision_ind pci1 
        INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
        INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 AND lo.tipo_venta in (7)
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial 
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (4) 
        INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
        INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
        INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
        WHERE pci1.estatus IN (4) AND ( (lo.idStatusContratacion < 9 AND com.estatus IN (1,8)) OR (lo.idStatusContratacion > 8  AND com.estatus IN (8))) AND com.id_usuario in(7689,6019)
        GROUP BY pci1.id_comision,com.ooam, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex, pci1.id_usuario, u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, co.nombre, lo.referencia, u.rfc)");
    }
 
    function getDatosNuevasFContraloria($proyecto,$condominio) {
        if( $this->session->userdata('id_rol') == 31) { // INTERNOMEX
            $filtro = "pci1.estatus IN (8, 88) AND com.id_usuario = $condominio";
            $where = "";
        } else { // CONTRALORÍA
            $filtro = "pci1.estatus IN (4)";
            if($condominio == 0)
                $where = "AND co.idResidencial  = $proyecto";
            else
                $where = "AND co.idCondominio  = $condominio";
        }
        return $this->db->query("(SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, 
        pci1.estatus, CONVERT(VARCHAR,pci1.fecha_pago_intmex,120) fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario ,pci1.id_usuario, 
        UPPER(CASE WHEN cl.estructura = 1 THEN oprol2.nombre ELSE oprol.nombre END) as puesto, 0 personalidad_juridica, u.forma_pago, 0 as factura, pac.porcentaje_abono, 
        (CASE WHEN com.ooam = 1 THEN  CONCAT(oxcest.nombre,' (OOAM)') ELSE oxcest.nombre END) estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, 0 lugar_prospeccion, co.nombre as condominio, lo.referencia, (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, 
        (CASE u.forma_pago WHEN 3 THEN (((sed.impuesto)/100)*pci1.abono_neodata) ELSE 0 END) dcto, sed.impuesto valimpuesto, u.rfc
        FROM pago_comision_ind pci1 
        INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
        INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio 
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial 
        INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 1
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (2)
        INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
        INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
        INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
        INNER JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario 
        WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 2 WHEN 4 THEN 5 WHEN 5 THEN 3 WHEN 607 THEN 1 WHEN 7092 THEN 4 WHEN 9629 THEN 2 ELSE u.id_sede END) and sed.estatus = 1
        LEFT JOIN opcs_x_cats oprol2 ON oprol2.id_opcion = com.rol_generado AND oprol2.id_catalogo = 83
        WHERE $filtro $where AND com.estatus in (1) AND lo.idStatusContratacion > 8
        GROUP BY pci1.id_comision,com.ooam, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex, pci1.id_usuario, u.forma_pago, pci1.id_pago_i, 
        pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, co.nombre, lo.referencia, sed.impuesto, u.rfc, oprol2.nombre, cl.estructura)
        UNION
        (SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, 
        pci1.fecha_pago_intmex fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario ,pci1.id_usuario, 
        CASE WHEN cl.estructura = 1 THEN oprol2.nombre ELSE oprol.nombre END as puesto, 0 personalidad_juridica, u.forma_pago, 0 as factura, pac.porcentaje_abono, 
        (CASE WHEN com.ooam = 1 THEN  CONCAT(oxcest.nombre,' (OOAM)') ELSE oxcest.nombre END) estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, 0 lugar_prospeccion, co.nombre as condominio, lo.referencia, (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, 
        (CASE u.forma_pago WHEN 3 THEN (((sed.impuesto)/100)*pci1.abono_neodata) ELSE 0 END) dcto, sed.impuesto valimpuesto, u.rfc
        FROM pago_comision_ind pci1 
        INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
        INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial 
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (2)
        INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
        INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
        INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
        INNER JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario 
        WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 2 WHEN 4 THEN 5 WHEN 5 THEN 3 WHEN 607 THEN 1 WHEN 7092 THEN 4 WHEN 9629 THEN 2 ELSE u.id_sede END) and sed.estatus = 1
        LEFT JOIN clientes cl ON cl.idLote = lo.idLote AND cl.id_cliente = com.idCliente
        LEFT JOIN opcs_x_cats oprol2 ON oprol2.id_opcion = com.rol_generado AND oprol2.id_catalogo = 83
        WHERE $filtro $where AND ( (lo.idStatusContratacion < 9 AND com.estatus IN (1,8)) OR (lo.idStatusContratacion > 8  AND com.estatus IN (8)))   
        GROUP BY pci1.id_comision,com.ooam, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex, pci1.id_usuario, u.forma_pago, pci1.id_pago_i, 
        pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, co.nombre, lo.referencia, sed.impuesto, u.rfc, oprol2.nombre, cl.estructura)");
    }
    
    function getDatosNuevasXContraloria($proyecto,$condominio){
        if( $this->session->userdata('id_rol') == 31 ){
            $filtro = "WHERE pci1.estatus IN (8,88) ";
        } else{
            $filtro = "WHERE pci1.estatus IN (4) ";
        }
        $user_data = $this->session->userdata('id_usuario');
        switch($this->session->userdata('id_rol')){
            case 2:
            case 3:
            case 7:
            case 9:
                $filtro02 = $filtro.' AND   fa.id_usuario = '.$user_data .' ';
            break;
            default:
                $filtro02 = $filtro.' ';
                break;
            }
            
            if($condominio == 0){
                return $this->db->query("SELECT SUM(pci1.abono_neodata) total, re.idResidencial, re.nombreResidencial as proyecto, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario, pci1.id_usuario, u.forma_pago, 0 as factura, oxcest.id_opcion id_estatus_actual, re.empresa, opn.estatus estatus_opinion, opn.archivo_name, fa.uuid,fa.nombre_archivo as xmla,fa.bandera, u.rfc
                FROM pago_comision_ind pci1 
                INNER JOIN comisiones com ON pci1.id_comision = com.id_comision AND com.estatus in (1,8)
                INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
                INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                INNER JOIN residenciales re ON re.idResidencial = co.idResidencial AND re.idResidencial = $proyecto
                INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (2)
                INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
                INNER JOIN opinion_cumplimiento opn ON opn.id_usuario = u.id_usuario and opn.estatus IN (2) 
                INNER JOIN facturas fa ON fa.id_comision = pci1.id_pago_i
                $filtro02 
                GROUP BY re.idResidencial, re.nombreResidencial, u.nombre, u.apellido_paterno, u.apellido_materno, pci1.id_usuario, u.forma_pago, oxcest.id_opcion, re.empresa, re.idResidencial, opn.estatus, opn.archivo_name, fa.uuid, fa.nombre_archivo, fa.bandera, u.rfc
                ORDER BY u.nombre");
                }else{
                    return $this->db->query("SELECT SUM(pci1.abono_neodata) total, re.idResidencial, re.nombreResidencial as proyecto, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario, pci1.id_usuario, u.forma_pago, 0 as factura, oxcest.id_opcion id_estatus_actual, re.empresa, opn.estatus estatus_opinion, opn.archivo_name, fa.uuid,fa.nombre_archivo as xmla,fa.bandera , u.rfc
                    FROM pago_comision_ind pci1 
                    INNER JOIN comisiones com ON pci1.id_comision = com.id_comision AND com.estatus in (1,8)
                    INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
                    INNER JOIN condominios co ON co.idCondominio = lo.idCondominio AND co.idCondominio = $condominio
                    INNER JOIN residenciales re ON re.idResidencial = co.idResidencial  
                    INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (2)
                    INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                    INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
                    INNER JOIN opinion_cumplimiento opn ON opn.id_usuario = u.id_usuario  and opn.estatus IN (2) 
                    INNER JOIN facturas fa ON fa.id_comision = pci1.id_pago_i
                    $filtro02
                    GROUP BY re.idResidencial, re.nombreResidencial, u.nombre, u.apellido_paterno, u.apellido_materno, pci1.id_usuario, u.forma_pago, oxcest.id_opcion, re.empresa, re.idResidencial, opn.estatus, opn.archivo_name, fa.uuid,fa.nombre_archivo,fa.bandera, u.rfc
                    ORDER BY u.nombre");
                }
    }
 
    function getDatosInvoice(){
        return $this->db->query("SELECT sum(pci1.abono_neodata) total, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario, pci1.id_usuario, u.forma_pago, opn.estatus estatus_opinion, opn.archivo_name, na.nombre as nacionalidad
        FROM pago_comision_ind pci1 
        INNER JOIN comisiones com ON pci1.id_comision = com.id_comision AND com.estatus in (1,8)
        INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (5)
        INNER JOIN opcs_x_cats na ON na.id_opcion = u.nacionalidad AND na.id_catalogo = 11  
        INNER JOIN opinion_cumplimiento opn ON opn.id_usuario = u.id_usuario and opn.estatus IN (2) 
        INNER JOIN pagos_invoice iv ON iv.id_pago_i = pci1.id_pago_i
        WHERE pci1.estatus in (4,8,88)
        GROUP BY opn.archivo_name, u.nombre, u.apellido_paterno, u.apellido_materno, pci1.id_usuario, u.forma_pago, opn.estatus, na.nombre 
        ORDER BY u.nombre ");
    }
    
    function getDatosInternomexContraloria($proyecto){
        return $this->db->query("SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, pci1.estatus, pci1.fecha_pago_intmex fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario ,pci1.id_usuario, oprol.nombre as puesto, cl.personalidad_juridica, u.forma_pago, 0 as factura, pac.porcentaje_abono, (CASE WHEN com.ooam = 1 THEN  CONCAT(oxcest.nombre,' (OOAM)') ELSE oxcest.nombre END) estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, cl.lugar_prospeccion
        FROM pago_comision_ind pci1 
        LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE (estatus in (11,3) OR descuento_aplicado = 1) 
        GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
        INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
        INNER JOIN lotes lo ON lo.idLote = com.id_lote
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        INNER JOIN clientes cl ON cl.idLote = lo.idLote
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
        INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado
        INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
        INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus  
        WHERE pci1.estatus IN (8) AND re.idResidencial = $proyecto AND com.estatus in (1,8) AND oprol.id_catalogo = 1 AND oxcest.id_catalogo = 23 AND lo.status = 1 AND cl.status = 1 AND u.forma_pago in (3,4)
        GROUP BY pci1.id_comision,com.ooam, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, pci1.estatus, pci1.fecha_pago_intmex, pci1.id_usuario, cl.personalidad_juridica, u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, cl.lugar_prospeccion ORDER BY lo.nombreLote");
    }

    function getDatosNuevasMktd_pre(){
        if( $this->session->userdata('id_usuario') == 2042 ){
            $filtro = " 2,3,4,6 ";
        } else{
            $filtro = " 1,5,8,9 ";
        }
        return $this->db->query("(SELECT pci1.id_comision, pci1.id_pago_i, pci1.id_usuario, lo.nombreLote as lote, re.nombreResidencial as proyecto, sed.nombre, sed.id_sede id_ub_origen, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, pci1.estatus, 0 personalidad_juridica, pac.porcentaje_abono, com.id_lote, 0 fechaApartado, sed2.nombre ubicacion_dos, lo.idLote, mk.idc_mktd,sd1.nombre as sd1,sd2.nombre as sd2, pac.bonificacion
        FROM pago_comision_ind pci1 
        LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE (estatus in (11,3) OR descuento_aplicado = 1) 
        GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
        INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
        INNER JOIN lotes lo ON lo.idLote = com.id_lote
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
        INNER JOIN sedes sed ON sed.id_sede = lo.ubicacion
        LEFT JOIN sedes sed2 ON sed2.id_sede = lo.ubicacion_dos
        LEFT JOIN compartidas_mktd mk on com.id_lote=mk.id_lote
        LEFT JOIN sedes sd1 on sd1.id_sede=mk.sede1
        LEFT JOIN sedes sd2 on sd2.id_sede=mk.sede2
        WHERE pci1.estatus in (1, 41, 42, 51, 52, 61, 62, 12) AND ((lo.idStatusContratacion < 9 AND com.estatus IN (1,8)) OR (lo.idStatusContratacion > 8 AND com.estatus IN (8))) AND com.rol_generado = 38 AND lo.status = 1 AND lo.idLote NOT IN (select id_lote from reportes_marketing WHERE estatus = 1 AND dispersion = 1) AND sed.id_sede IN (".$filtro.")  
        GROUP BY lo.nombreLote, re.nombreResidencial, sed.nombre, sed.id_sede, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, com.comision_total-pci2.abono_pagado, pci1.estatus, sed2.nombre, pac.porcentaje_abono, com.id_lote, pci1.id_pago_i, pci1.id_usuario, pci1.id_comision, lo.idLote, mk.idc_mktd, sd1.nombre, sd2.nombre, pac.bonificacion)
        UNION
        (SELECT pci1.id_comision, pci1.id_pago_i, pci1.id_usuario, lo.nombreLote as lote, re.nombreResidencial as proyecto, sed.nombre, sed.id_sede id_ub_origen, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, pci1.estatus, cl.personalidad_juridica, pac.porcentaje_abono, com.id_lote, cl.fechaApartado, sed2.nombre ubicacion_dos, lo.idLote, mk.idc_mktd,sd1.nombre as sd1,sd2.nombre as sd2 , pac.bonificacion
        FROM pago_comision_ind pci1 
        LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE (estatus in (11,3) OR descuento_aplicado = 1) 
        GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
        INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
        INNER JOIN lotes lo ON lo.idLote = com.id_lote
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente
        INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
        INNER JOIN sedes sed ON sed.id_sede = cl.id_sede
        LEFT JOIN sedes sed2 ON sed2.id_sede = lo.ubicacion_dos
        LEFT JOIN compartidas_mktd mk on com.id_lote=mk.id_lote
        LEFT JOIN sedes sd1 on sd1.id_sede=mk.sede1
        LEFT JOIN sedes sd2 on sd2.id_sede=mk.sede2
        WHERE pci1.estatus in (1, 41, 42, 51, 52, 61, 62, 12) AND com.estatus in (1,8)  AND com.rol_generado = 38 AND lo.status = 1 AND cl.status = 1 AND lo.idLote NOT IN (select id_lote from reportes_marketing WHERE estatus = 1 AND dispersion = 1) AND cl.id_asesor IN (SELECT id_usuario FROM usuarios WHERE id_sede IN (".$filtro.") AND id_rol IN (7,9)) AND com.estatus in (1) AND lo.idStatusContratacion > 8 
        GROUP BY cl.fechaApartado,lo.nombreLote, re.nombreResidencial, sed.nombre, sed.id_sede, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, com.comision_total-pci2.abono_pagado, pci1.estatus, sed2.nombre, cl.personalidad_juridica, pac.porcentaje_abono, com.id_lote, pci1.id_pago_i, pci1.id_usuario, pci1.id_comision, lo.idLote, mk.idc_mktd, sd1.nombre, sd2.nombre, pac.bonificacion)");
    }
    
    function validar_precio_agregado($id_lote){
        $validar_pl = $this->db->query("SELECT * FROM reportes_marketing where id_lote = $id_lote");
        if(empty($validar_pl->row()->id_lote)){
            return 1;
        } else{
            return 2;
        }    
    }
    
    function aprobar_comision($id_pago, $id_comision, $id_lote, $precio_lote, $validate){
        $comparar = $this->db->query("SELECT ubicacion FROM lotes WHERE idLote IN (SELECT id_lote FROM comisiones WHERE id_comision = $id_comision)");
        if($comparar->row()->ubicacion!=3){
            $val_ubi = $comparar->row()->ubicacion;
            $this->db->query("UPDATE lotes SET ubicacion_dos = $val_ubi WHERE idLote = $id_lote");
        }
        $v1_user = $this->session->userdata('id_usuario');

        if($validate == 1) 
            $this->db->query("INSERT INTO reportes_marketing VALUES ($id_lote, $precio_lote, 1, 1, $v1_user, GETDATE())");
        else
            $this->db->query("UPDATE reportes_marketing SET dispersion = 1 WHERE id_lote = $id_lote");

        $this->db->query("INSERT INTO historial_comisiones VALUES (".$id_pago.", ".$v1_user.", GETDATE(), 1, 'MKTD APROBÓ ESTE PAGO')");
        return $this->db->query("UPDATE pago_comision_ind SET estatus = 12,modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_i= $id_pago AND id_comision = $id_comision");
    }
    
    function getDatosNuevasMktd(){
        $filtro = " AND lo.ubicacion_dos IN (1,5,9,8) AND lo.idLote NOT IN (select id_lote from compartidas_mktd) AND lo.idLote NOT IN (select id_lote from compartidas_mktd)";
        return $this->db->query(" SELECT pci.id_usuario, lo.ubicacion_dos, plm.id_plan, s.nombre as sede, us.nombre, us.apellido_paterno, SUM(pci.abono_neodata) total, res.empresa, res.idResidencial, CAST(res.descripcion AS VARCHAR(MAX)) descripcion
        FROM pago_comision_ind pci 
        INNER JOIN comisiones com ON com.id_comision = pci.id_comision
        INNER JOIN lotes lo ON lo.idLote = com.id_lote
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio
        INNER JOIN residenciales res ON res.idResidencial = con.idResidencial
        INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente
        INNER JOIN planes_mktd plm ON plm.fecha_plan <= cl.fechaApartado AND plm.fin_plan >= cl.fechaApartado
        INNER JOIN sedes s ON s.id_sede = lo.ubicacion_dos
        INNER JOIN usuarios us ON us.id_usuario = pci.id_usuario
        WHERE pci.estatus IN (1, 41, 42, 51, 52, 61, 62, 12) AND lo.idLote IN (select id_lote from reportes_marketing WHERE estatus = 1 AND dispersion = 1) AND pci.id_usuario = 4394 AND lo.status = 1 AND cl.status = 1
        $filtro
        GROUP BY plm.id_plan, res.empresa, pci.id_usuario, lo.ubicacion_dos, s.nombre, us.nombre, us.apellido_paterno, res.idResidencial, CAST(res.descripcion AS VARCHAR(MAX))
        ORDER by plm.id_plan");
    }

    function getDatosNuevasMktd2(){
        $filtro = " AND lo.ubicacion_dos IN (2,3,4,6) AND lo.idLote NOT IN (select id_lote from compartidas_mktd) AND lo.idLote NOT IN (select id_lote from compartidas_mktd)";
    
        return $this->db->query("SELECT pci.id_usuario, lo.ubicacion_dos, plm.id_plan, s.nombre as sede, us.nombre, us.apellido_paterno, SUM(pci.abono_neodata) total, res.empresa, res.idResidencial, CAST(res.descripcion AS VARCHAR(MAX)) descripcion
        FROM pago_comision_ind pci 
        INNER JOIN comisiones com ON com.id_comision = pci.id_comision
        INNER JOIN lotes lo ON lo.idLote = com.id_lote
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio
        INNER JOIN residenciales res ON res.idResidencial = con.idResidencial
        INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente
        INNER JOIN planes_mktd plm ON plm.fecha_plan <= cl.fechaApartado AND plm.fin_plan >= cl.fechaApartado
        INNER JOIN sedes s ON s.id_sede = lo.ubicacion_dos
        INNER JOIN usuarios us ON us.id_usuario = pci.id_usuario
        WHERE pci.estatus IN (1, 41, 42, 51, 52, 61, 62, 12) AND lo.idLote IN (select id_lote from reportes_marketing WHERE estatus = 1 AND dispersion = 1) AND pci.id_usuario = 4394 AND lo.status = 1 AND cl.status = 1
        $filtro
        GROUP BY plm.id_plan, res.empresa, pci.id_usuario, lo.ubicacion_dos, s.nombre, us.nombre, us.apellido_paterno, res.idResidencial, CAST(res.descripcion AS VARCHAR(MAX))
        ORDER by plm.id_plan");
    }
 
    public function insert_HCD($data){
        $this->db->insert(' historial_comisiones',$data);
        return true;
    }

    public function insert_HCD_A($data){
        $this->db->insert(' historial_controversia',$data);
        return true;
    }

    function verify_controversia($idCliente){
        $query = $this->db->query("SELECT * FROM  historial_controversia WHERE idCliente = ".$idCliente." ");
        return $query->result_array();
    }

    public function update_HCD_A($idCliente,$data){
        $this->db->where("idCliente",$idCliente);
        $this->db->update(' historial_controversia',$data);
        return true;
    }

    public function getDatosDocumentos($id_comision, $id_pj){
        if ($id_pj == 1){
            return $this->db->query("(SELECT ox.id_opcion, ox.nombre, 'NO EXISTE' as estado, '0' as expediente FROM opcs_x_cats ox 
            WHERE ox.id_opcion NOT IN (SELECT oxc.id_opcion FROM lotes lo 
            INNER JOIN comisiones com ON com.id_lote = lo.idLote 
            INNER JOIN historial_documento hd ON hd.idLote = lo.idLote 
            LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = hd.tipo_doc 
            WHERE com.id_comision = ".$id_comision." AND oxc.id_catalogo = 31) AND ox.id_catalogo = 31 AND ox.estatus = 1)
            UNION (SELECT oxc.id_opcion, oxc.nombre, 'EXISTE' as estado, hd.expediente 
            FROM lotes lO INNER JOIN comisiones com ON com.id_lote = lo.idLote
            INNER JOIN historial_documento hd ON hd.idLote = lo.idLote 
            LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = hd.tipo_doc 
            WHERE com.id_comision = ".$id_comision." AND oxc.id_catalogo = 31 AND oxc.estatus = 1)");
        } else{
            return $this->db->query("(SELECT ox.id_opcion, ox.nombre, 'NO EXISTE' as estado, '0' as expediente FROM opcs_x_cats ox 
            WHERE ox.id_opcion NOT IN (SELECT oxc.id_opcion FROM lotes lo 
            INNER JOIN comisiones com ON com.id_lote = lo.idLote 
            INNER JOIN historial_documento hd ON hd.idLote = lo.idLote 
            LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = hd.tipo_doc 
            WHERE com.id_comision = ".$id_comision." AND oxc.id_catalogo = 32) AND ox.id_catalogo = 32 AND ox.estatus = 1)
            UNION (SELECT oxc.id_opcion, oxc.nombre, 'EXISTE' as estado, hd.expediente 
            FROM lotes lO INNER JOIN comisiones com ON com.id_lote = lo.idLote
            INNER JOIN historial_documento hd ON hd.idLote = lo.idLote 
            LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = hd.tipo_doc 
            WHERE com.id_comision = ".$id_comision." AND oxc.id_catalogo = 32 AND oxc.estatus = 1)");
        }
    }

    public function report_empresa(){
        return $this->db->query("SELECT SUM(pci.abono_neodata) as porc_empresa, res.empresa
        FROM pago_comision_ind pci 
        INNER JOIN comisiones com  ON com.id_comision = pci.id_comision
        INNER JOIN lotes lo  ON lo.idLote = com.id_lote 
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
        INNER JOIN residenciales res ON res.idResidencial = con.idResidencial 
        WHERE pci.estatus in (8) GROUP BY res.empresa");
    }

    function LiquidarLote($user,$idlote) {
        $this->db->query("UPDATE lotes SET registro_comision = 7 WHERE idLote=".$idlote." ");
        $comentario = 'SE LIQUIDÓ COMISIÓN DEL LOTE '.$idlote;
        $respuesta = $this->db->query("INSERT INTO historial_comisiones(id_pago_i,id_usuario,fecha_movimiento,estatus,comentario) VALUES (0,".$this->session->userdata('id_usuario').",GETDATE(),7,'".$comentario."')");
        if (! $respuesta ) {
            return 0;
        } else {
            return 1;
        }
    }

    function updateIndividualCommission($idsol, $estatus) {
        return $this->db->query("UPDATE pago_comision_ind SET estatus = $estatus,modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_i IN (".$idsol.")");
    }

    function updateLotes($idLote, $plaza) {
        return $this->db->query("UPDATE lotes SET ubicacion_dos = ".$plaza." WHERE idLote IN (".$idLote.")");
    }

 

    function ComisionesEnviar($usuario,$recidencial,$opc){
        switch ($opc) {
        case 3:
            $consulta = $this->db->query(" SELECT pci.id_pago_i
            FROM pago_comision_ind pci
            INNER JOIN comisiones com ON com.id_comision = pci.id_comision
            INNER JOIN lotes lo ON lo.idLote = com.id_lote
            INNER JOIN condominios cod ON cod.idCondominio = lo.idCondominio
            INNER JOIN residenciales res ON res.idResidencial = cod.idResidencial
            INNER JOIN clientes cl ON cl.idLote = lo.idLote
            INNER JOIN (SELECT expediente, idCliente FROM historial_documento WHERE tipo_doc in (8)
            AND status = 1 GROUP BY idCliente, expediente) contrato ON contrato.idCliente = cl.id_cliente
            WHERE lo.status = 1 AND lo.registro_comision NOT IN (0) AND pci.estatus IN (1, 2)
            AND contrato.expediente IS NOT NULL AND pci.id_usuario = $usuario AND res.idResidencial = $recidencial")->result_array();
            
            for($i=0;$i < count($consulta); $i++){
                $this->db->query("INSERT INTO historial_comisiones VALUES (".$consulta[$i]['id_pago_i'].", ".$usuario.", GETDATE(), 1, 'COLABORADOR ENVÍO A CONTRALORÍA')");
            }
            
            $respuesta = $this->db->query(" UPDATE pago_comision_ind set estatus = 4,modificado_por='".$this->session->userdata('id_usuario')."'
            FROM pago_comision_ind pci
            INNER JOIN comisiones com ON com.id_comision = pci.id_comision
            INNER JOIN lotes lo ON lo.idLote = com.id_lote
            INNER JOIN condominios cod ON cod.idCondominio = lo.idCondominio
            INNER JOIN residenciales res ON res.idResidencial = cod.idResidencial
            INNER JOIN clientes cl ON cl.idLote = lo.idLote
            INNER JOIN (SELECT expediente, idCliente FROM historial_documento WHERE tipo_doc in (8)
            AND status = 1 GROUP BY idCliente, expediente) contrato ON contrato.idCliente = cl.id_cliente
            WHERE lo.status = 1 AND lo.registro_comision NOT IN (0) AND pci.estatus IN (1, 2)
            AND contrato.expediente IS NOT NULL AND pci.id_usuario = $usuario AND res.idResidencial = $recidencial");

            if (! $respuesta ) {
            return 0;
            } else {
            return 1;
            }
            break;
            case 4:
            $consulta = $this->db->query("  SELECT pci.id_pago_i
            FROM pago_comision_ind pci
            INNER JOIN comisiones com ON com.id_comision = pci.id_comision
            INNER JOIN lotes lo ON lo.idLote = com.id_lote
            INNER JOIN condominios cod ON cod.idCondominio = lo.idCondominio
            INNER JOIN residenciales res ON res.idResidencial = cod.idResidencial
            INNER JOIN clientes cl ON cl.idLote = lo.idLote
            INNER JOIN facturas fac ON fac.id_comision = pci.id_pago_i
            INNER JOIN (SELECT expediente, idCliente FROM historial_documento WHERE tipo_doc in (8)
            AND status = 1 GROUP BY idCliente, expediente) contrato ON contrato.idCliente = cl.id_cliente
            WHERE lo.status = 1 AND lo.registro_comision NOT IN (0) AND pci.estatus IN (1, 2)
            AND contrato.expediente IS NOT NULL AND pci.id_usuario = $usuario AND res.idResidencial = $recidencial")->result_array();
            echo print_r($consulta);
    
            for($i=0;$i < count($consulta); $i++){
                $this->db->query("INSERT INTO historial_comisiones VALUES (".$consulta[$i]['id_pago_i'].", ".$usuario.", GETDATE(), 1, 'COLABORADOR ENVÍO A CONTRALORÍA')");
            }

            $respuesta = $this->db->query(" UPDATE pago_comision_ind set estatus = 4,modificado_por='".$this->session->userdata('id_usuario')."'
            FROM pago_comision_ind pci
            INNER JOIN comisiones com ON com.id_comision = pci.id_comision
            INNER JOIN lotes lo ON lo.idLote = com.id_lote
            INNER JOIN condominios cod ON cod.idCondominio = lo.idCondominio
            INNER JOIN residenciales res ON res.idResidencial = cod.idResidencial
            INNER JOIN clientes cl ON cl.idLote = lo.idLote
            INNER JOIN facturas fac ON fac.id_comision = pci.id_pago_i
            INNER JOIN (SELECT expediente, idCliente FROM historial_documento WHERE tipo_doc in (8)
            AND status = 1 GROUP BY idCliente, expediente) contrato ON contrato.idCliente = cl.id_cliente
            WHERE lo.status = 1 AND lo.registro_comision NOT IN (0) AND pci.estatus IN (1, 2)
            AND contrato.expediente IS NOT NULL AND pci.id_usuario = $usuario AND res.idResidencial = $recidencial");

            if (! $respuesta ) {
            return 0;
            } else {
            return 1;
            }
            break;
            case 1:
            //ASIMILADOS TODAS
            $consulta = $this->db->query("SELECT pci.id_pago_i
            FROM pago_comision_ind pci
            INNER JOIN comisiones com ON com.id_comision = pci.id_comision
            INNER JOIN lotes lo ON lo.idLote = com.id_lote
            INNER JOIN condominios cod ON cod.idCondominio = lo.idCondominio
            INNER JOIN residenciales res ON res.idResidencial = cod.idResidencial
            INNER JOIN clientes cl ON cl.idLote = lo.idLote
            INNER JOIN (SELECT expediente, idCliente FROM historial_documento WHERE tipo_doc in (8)
            AND status = 1 GROUP BY idCliente, expediente) contrato ON contrato.idCliente = cl.id_cliente
            WHERE lo.status = 1 AND lo.registro_comision NOT IN (0) AND pci.estatus IN (1, 2)
            AND contrato.expediente IS NOT NULL AND pci.id_usuario = $usuario  AND res.idResidencial > 0")->result_array();

            for($i=0;$i < count($consulta); $i++){
                $this->db->query("INSERT INTO historial_comisiones VALUES (".$consulta[$i]['id_pago_i'].", ".$usuario.", GETDATE(), 1, 'COLABORADOR ENVÍO A CONTRALORÍA')");
            }

            $respuesta = $this->db->query(" UPDATE pago_comision_ind set estatus = 4,modificado_por='".$this->session->userdata('id_usuario')."'
            FROM pago_comision_ind pci
            INNER JOIN comisiones com ON com.id_comision = pci.id_comision
            INNER JOIN lotes lo ON lo.idLote = com.id_lote
            INNER JOIN condominios cod ON cod.idCondominio = lo.idCondominio
            INNER JOIN residenciales res ON res.idResidencial = cod.idResidencial
            INNER JOIN clientes cl ON cl.idLote = lo.idLote
            INNER JOIN (SELECT expediente, idCliente FROM historial_documento WHERE tipo_doc in (8)
            AND status = 1 GROUP BY idCliente, expediente) contrato ON contrato.idCliente = cl.id_cliente
            WHERE lo.status = 1 AND lo.registro_comision NOT IN (0) AND pci.estatus IN (1, 2)
            AND contrato.expediente IS NOT NULL AND pci.id_usuario = $usuario AND res.idResidencial > 0");

            if (! $respuesta ) {
            return 0;
            } else {
            return 1;
            }
            break;
            case 2:

            $consulta = $this->db->query("SELECT pci.id_pago_i
            FROM pago_comision_ind pci
            INNER JOIN comisiones com ON com.id_comision = pci.id_comision
            INNER JOIN lotes lo ON lo.idLote = com.id_lote
            INNER JOIN condominios cod ON cod.idCondominio = lo.idCondominio
            INNER JOIN residenciales res ON res.idResidencial = cod.idResidencial
            INNER JOIN clientes cl ON cl.idLote = lo.idLote
            INNER JOIN facturas fac ON fac.id_comision = pci.id_pago_i
            INNER JOIN (SELECT expediente, idCliente FROM historial_documento WHERE tipo_doc in (8)
            AND status = 1 GROUP BY idCliente, expediente) contrato ON contrato.idCliente = cl.id_cliente
            WHERE lo.status = 1 AND lo.registro_comision NOT IN (0) AND pci.estatus IN (1, 2)
            AND contrato.expediente IS NOT NULL AND pci.id_usuario = $usuario AND res.idResidencial > 0")->result_array();


            for($i=0;$i < count($consulta); $i++){
                $this->db->query("INSERT INTO historial_comisiones VALUES (".$consulta[$i]['id_pago_i'].", ".$usuario.", GETDATE(), 1, 'COLABORADOR ENVÍO A CONTRALORÍA')");
            }

            $respuesta = $this->db->query("UPDATE pago_comision_ind set estatus = 4,modificado_por='".$this->session->userdata('id_usuario')."'
            FROM pago_comision_ind pci
            INNER JOIN comisiones com ON com.id_comision = pci.id_comision
            INNER JOIN lotes lo ON lo.idLote = com.id_lote
            INNER JOIN condominios cod ON cod.idCondominio = lo.idCondominio
            INNER JOIN residenciales res ON res.idResidencial = cod.idResidencial
            INNER JOIN clientes cl ON cl.idLote = lo.idLote
            INNER JOIN facturas fac ON fac.id_comision = pci.id_pago_i
            INNER JOIN (SELECT expediente, idCliente FROM historial_documento WHERE tipo_doc in (8)
            AND status = 1 GROUP BY idCliente, expediente) contrato ON contrato.idCliente = cl.id_cliente
            WHERE lo.status = 1 AND lo.registro_comision NOT IN (0) AND pci.estatus IN (1, 2)
            AND contrato.expediente IS NOT NULL AND pci.id_usuario = $usuario AND res.idResidencial > 0");

            if (! $respuesta ) {
            return 0;
            } else {
            return 1;
            }
            break;
        }
    }

    function GetFormaPago($id){
        return $this->db->query("SELECT forma_pago FROM usuarios WHERE id_usuario=$id");
    }

    public function borrar_factura($id_comision){
        return $this->db->query("DELETE FROM facturas WHERE id_comision =".$id_comision."");
    }

    function getDatosEnviadasmkContraloria(){
        return $this->db->query("SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario ,pci1.id_usuario, oprol.nombre as puesto, cl.personalidad_juridica, u.forma_pago, 0 as factura, pac.porcentaje_abono, (CASE WHEN com.ooam = 1 THEN  CONCAT(oxcest.nombre,' (OOAM)') ELSE oxcest.nombre END) estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, cl.lugar_prospeccion, co.nombre as condominio, lo.referencia, (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, (CASE u.forma_pago WHEN 3 THEN (((sed.impuesto)/100)*pci1.abono_neodata) ELSE 0 END) dcto, sed.impuesto valimpuesto
        FROM pago_comision_ind pci1 
        INNER JOIN comisiones com ON pci1.id_comision = com.id_comision AND com.estatus in (1,8)
        INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial 
        INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 1
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario 
        INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
        INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
        INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
        INNER JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario 
        WHEN 2 THEN 2 
        WHEN 3 THEN 2 
        WHEN 1980 THEN 2 
        WHEN 1981 THEN 2 
        WHEN 1982 THEN 2 
        WHEN 1988 THEN 2 
        WHEN 4 THEN 5
        WHEN 5 THEN 3
        WHEN 607 THEN 1 
        WHEN 7092 THEN 4
            WHEN 9629 THEN 2
        ELSE u.id_sede END) and sed.estatus = 1
        WHERE pci1.estatus IN (12) and com.rol_generado in (38)
        GROUP BY pci1.id_comision,com.ooam, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex, pci1.id_usuario, cl.personalidad_juridica, u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, cl.lugar_prospeccion, co.nombre, lo.referencia, sed.impuesto ORDER BY lo.nombreLote");
    }
    
    function getDatosEnviadasADirectorMK($filtro){
        ini_set('max_execution_time', 300);
        set_time_limit(300);
        return $this->db->query("(SELECT pci1.id_comision, pci1.id_pago_i, pci1.id_usuario, lo.nombreLote as lote, re.nombreResidencial as proyecto, sed.nombre, sed.id_sede id_ub_origen, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, 0 pagado, com.comision_total-0 restante, '0' as lugar_prosp, pci1.estatus, 0 personalidad_juridica, pac.porcentaje_abono, com.id_lote, 0 fechaApartado, sed2.nombre ubicacion_dos, lo.idLote, mk.idc_mktd,sd1.nombre as sd1,sd2.nombre as sd2, pac.bonificacion, re.empresa, co.nombre as condominio, lo.referencia, pci1.fecha_pago_intmex, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario , lo.idStatusContratacion
        FROM pago_comision_ind pci1 
        INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
        INNER JOIN lotes lo ON lo.idLote = com.id_lote
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
        INNER JOIN sedes sed ON sed.id_sede = lo.ubicacion 
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario 
        INNER JOIN sedes sed2 ON sed2.id_sede = lo.ubicacion_dos AND sed2.id_sede LIKE '%".$filtro."%'
        LEFT JOIN compartidas_mktd mk on com.id_lote=mk.id_lote
        LEFT JOIN sedes sd1 on sd1.id_sede=mk.sede1
        LEFT JOIN sedes sd2 on sd2.id_sede=mk.sede2
        WHERE pci1.estatus in (1, 41, 42, 51, 52, 61, 62, 12) 
        AND com.rol_generado = 38 AND lo.status = 1  
        AND lo.idLote IN (select id_lote from reportes_marketing WHERE estatus = 1 AND dispersion = 1) 
        GROUP BY lo.nombreLote, re.nombreResidencial, sed.nombre, sed.id_sede, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci1.estatus, sed2.nombre, pac.porcentaje_abono, com.id_lote, pci1.id_pago_i, pci1.id_usuario, pci1.id_comision, lo.idLote, mk.idc_mktd, sd1.nombre, sd2.nombre, pac.bonificacion, re.empresa, co.nombre, lo.referencia, pci1.fecha_pago_intmex, u.nombre, u.apellido_paterno, u.apellido_materno, lo.idStatusContratacion)");
    } 

    function getLotesOrigen($user,$valor){

        if($user == 1988){//fernanda
            $cadena = " AND cl.id_asesor in (select id_usuario from usuarios where id_rol in (7,9) and 
            id_sede like '%1%' or id_sede like '%5%')";
            $user_vobo = 4394;
        }else if($user == 1981){//maricela
            $cadena = " AND cl.id_asesor in (select id_usuario from usuarios where id_rol in (7,9) and 
            id_sede like '%2%' or id_sede like '%3%' or id_sede like '%4%' or id_sede like '%6%')";
            $user_vobo = 4394;
        }else{
            $cadena = '';
            $user_vobo = $user;
        }

        if($valor == 1){
            return $this->db->query(" SELECT l.idLote, l.nombreLote, pci.id_pago_i, pci.abono_neodata as comision_total, 0 abono_pagado,pci.pago_neodata 
            FROM comisiones com 
            INNER JOIN lotes l ON l.idLote = com.id_lote
            INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
            INNER JOIN pago_comision_ind pci ON pci.id_comision = com.id_comision
            WHERE com.estatus = 1 AND pci.estatus IN (1, 41, 42, 51, 52, 61, 62, 12) AND pci.id_usuario = $user_vobo $cadena ORDER BY pci.abono_neodata DESC");
            } else if($valor == 2){
                return $this->db->query(" SELECT l.idLote, l.nombreLote, pci.id_pago_i, pci.abono_neodata as comision_total, 0 abono_pagado,pci.pago_neodata 
                FROM comisiones com 
                INNER JOIN lotes l ON l.idLote = com.id_lote
                INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                INNER JOIN pago_comision_ind pci ON pci.id_comision = com.id_comision
                WHERE com.estatus = 1 AND pci.estatus IN (4) AND pci.id_usuario = $user_vobo ORDER BY pci.abono_neodata DESC ");
        }
    }

    function getLotesOrigen2($user,$valor){
        $datos =  $this->db->query(" SELECT l.idLote, l.nombreLote, pci.id_pago_i, pci.abono_neodata as comision_total, 0 abono_pagado,u.id_sede,pci.pago_neodata
        FROM comisiones com 
        INNER JOIN lotes l ON l.idLote = com.id_lote
        INNER JOIN pago_comision_ind pci ON pci.id_comision = com.id_comision
        INNER JOIN usuarios u on u.id_usuario=pci.id_usuario
        WHERE com.estatus = 1 AND pci.estatus IN (1) AND pci.id_usuario = $user order by pci.abono_neodata desc ")->result_array();

        if(!empty($datos)){ 
        $pagos =  $this->db->query(" SELECT sum(abono_neodata) as suma
        FROM comisiones com 
        INNER JOIN lotes l ON l.idLote = com.id_lote
        INNER JOIN pago_comision_ind pci ON pci.id_comision = com.id_comision
        WHERE com.estatus = 1 AND pci.estatus IN (1) AND pci.id_usuario = $user ")->result_array();

        $maximo = 10000;
        if($datos[0]['id_sede'] == 6){
            $maximo = 15000;
        }

        if($pagos[0]['suma'] < $maximo){
            $datosnew[0] = array(
            'abono_pagado'=> null,
            'comision_total'=> null,
            'idLote'=> null,
            'id_pago_i'=> null,
            'nombreLote'=> null,
            'suma'=>$pagos[0]['suma'],
            'id_sede'=>$datos[0]['id_sede'],
            'pago_neodata' => $datos[0]['pago_neodata']);
        }else{
            $suma=0;
            for ($i=0; $i <count($datos); $i++) { 
                if($datos[$i]['comision_total'] > $valor){
                    $datosnew[$i] = array(
                        'abono_pagado'=> $datos[$i]['abono_pagado'],
                        'comision_total'=> $datos[$i]['comision_total'],
                        'idLote'=> $datos[$i]['idLote'],
                        'id_pago_i'=> $datos[$i]['id_pago_i'],
                        'nombreLote'=> $datos[$i]['nombreLote'],
                        'suma'=>$pagos[0]['suma'],
                        'id_sede'=>$datos[0]['id_sede'],
                        'pago_neodata' => $datos[$i]['pago_neodata']);
                        break;
                }else{
                    $suma = $suma + $datos[$i]['comision_total'];
                    $datosnew[$i] = array(
                        'abono_pagado'=> $datos[$i]['abono_pagado'],
                        'comision_total'=> $datos[$i]['comision_total'],
                        'idLote'=> $datos[$i]['idLote'],
                        'id_pago_i'=> $datos[$i]['id_pago_i'],
                        'nombreLote'=> $datos[$i]['nombreLote'],
                        'suma'=>$pagos[0]['suma'],
                        'pago_neodata' => $datos[$i]['pago_neodata']);
                        
                        if( $suma >= $valor){
                            break;
                        }
                    }
                }
            }
        }else{
            $datosnew[0] = array(
                'abono_pagado'=> null,
                'comision_total'=> null,
                'idLote'=> null,
                'id_pago_i'=> null,
                'nombreLote'=> null,
                'suma'=>null,
                'id_sede'=>null,
                'pago_neodata'=>null);
            }
        return $datosnew;
    }
  
    function getLotesOrigenResguardo($user){
        return $this->db->query(" SELECT l.idLote, l.nombreLote, pci.id_pago_i, pci.abono_neodata as comision_total, 0 abono_pagado 
        FROM comisiones com 
        INNER JOIN lotes l ON l.idLote = com.id_lote
        INNER JOIN pago_comision_ind pci ON pci.id_comision = com.id_comision
        WHERE com.estatus = 1 AND pci.estatus IN (3) AND pci.id_usuario = $user");
    }

    function getInformacionData($var,$valor){
        if($valor == 1){
            return $this->db->query("SELECT l.idLote, l.nombreLote, com.id_comision, pci.abono_neodata as comision_total, 0 abono_pagado 
            FROM comisiones com 
            INNER JOIN lotes l ON l.idLote = com.id_lote
            INNER JOIN pago_comision_ind pci ON pci.id_comision = com.id_comision
            WHERE com.estatus = 1 AND pci.estatus IN (1,14,51,52) AND pci.id_pago_i = $var ");
        }else if($valor ==2){
            return $this->db->query("SELECT l.idLote, l.nombreLote, com.id_comision, pci.abono_neodata as comision_total, 0 abono_pagado 
            FROM comisiones com 
            INNER JOIN lotes l ON l.idLote = com.id_lote
            INNER JOIN pago_comision_ind pci ON pci.id_comision = com.id_comision
            WHERE com.estatus = 1 AND pci.estatus IN (4) AND pci.id_pago_i = $var ");
        }
    }

    function getInformacionDataResguardo($var){
        return $this->db->query(" SELECT l.idLote, l.nombreLote, com.id_comision, pci.abono_neodata as comision_total, 0 abono_pagado 
        FROM comisiones com 
        INNER JOIN lotes l ON l.idLote = com.id_lote
        INNER JOIN pago_comision_ind pci ON pci.id_comision = com.id_comision
        WHERE com.estatus = 1 AND pci.estatus IN (3) AND pci.id_pago_i = $var");
    }

    function insertar_descuentoEsp($usuarioid,$monto,$ide_comision,$comentario,$usuario,$pago_neodata,$valor){
        $estatus = 16;
        $respuesta = $this->db->query("INSERT INTO pago_comision_ind(id_comision, id_usuario, abono_neodata, fecha_abono, fecha_pago_intmex, pago_neodata, estatus, modificado_por, comentario, descuento_aplicado,abono_final,aply_pago_intmex) VALUES ($ide_comision, $usuarioid, $monto, GETDATE(), GETDATE(), $pago_neodata, $estatus, $usuario, 'DESCUENTO ', 1 ,null, null)");
        $insert_id = $this->db->insert_id();
        $respuesta = $this->db->query("INSERT INTO historial_comisiones VALUES ($insert_id, $usuario, GETDATE(), 1, 'SE APLICÓ UN DESCUENTO, MOTIVO DESCUENTO: ".$comentario."')");
    
        if (! $respuesta ) {
            return 0;
        } else {
            return 1;
        }
    }

    function update_descuentoEsp($id_pago_i,$monto, $comentario, $usuario,$valor,$user){        
        $estatus = 4;
        if($monto == 0){
            $respuesta = $this->db->query("UPDATE pago_comision_ind SET estatus = 16, modificado_por= $usuario, fecha_pago_intmex = GETDATE(), fecha_abono = GETDATE(), comentario='DESCUENTO',descuento_aplicado=1 WHERE id_pago_i=$id_pago_i");
            $respuesta = $this->db->query("INSERT INTO historial_comisiones VALUES ($id_pago_i, $usuario, GETDATE(), 1, 'MOTIVO DESCUENTO: ".$comentario."')");
        }else{
            $estatus = $monto < 1 ? 0 : 4;
            $respuesta = $this->db->query("UPDATE pago_comision_ind SET estatus = $estatus, modificado_por= $usuario, fecha_pago_intmex = GETDATE(), fecha_abono = GETDATE(), abono_neodata = $monto, comentario='NUEVO PAGO DESCUENTO' WHERE id_pago_i=$id_pago_i");
            $respuesta = $this->db->query("INSERT INTO historial_comisiones VALUES ($id_pago_i, $usuario, GETDATE(), 1, 'SE ACTUALIZÓ NUEVO PAGO. MOTIVO: ".$comentario."')");
        }
        if (! $respuesta ) {
            return 0;
        } else {
            return 1;
        }
    }

    function insertar_descuento($usuarioid,$monto,$ide_comision,$comentario,$usuario,$pago_neodata,$valor){
        $estatus = $monto < 1 ? 0 : 1;
        if($valor == 2){
            $estatus = $monto < 1 ? 0 : 4;
        } else if($valor == 3){
            $estatus = $monto < 1 ? 0 : 1;
        }
        
        $respuesta = $this->db->query("INSERT INTO pago_comision_ind(id_comision, id_usuario, abono_neodata, fecha_abono, fecha_pago_intmex, pago_neodata, estatus, modificado_por, comentario, descuento_aplicado,abono_final,aply_pago_intmex) VALUES ($ide_comision, $usuarioid, $monto, GETDATE(), GETDATE(), $pago_neodata, $estatus, $usuario, 'DESCUENTO NUEVO PAGO', 0 ,null, null)");
        $insert_id = $this->db->insert_id();
        $respuesta = $this->db->query("INSERT INTO historial_comisiones VALUES ($insert_id, $usuario, GETDATE(), 1, 'NUEVO PAGO, DISPONIBLE PARA COBRO')");
        
        if (! $respuesta ) {
            return 0;
        } else {
            return 1;
        }
    }

    function update_descuento($id_pago_i,$monto, $comentario, $saldo_comisiones, $usuario,$valor,$user,$pagos_aplicados){
        $estatus = 0;
        $uni='DESCUENTO';
        if($valor == 2){
            $estatus =16;
        }else if($valor == 3){
            $estatus =17;
            $respuesta = $this->db->query("UPDATE descuentos_universidad SET saldo_comisiones=".$saldo_comisiones.", pagos_activos = (pagos_activos - ".$pagos_aplicados."), estatus = 2 WHERE id_usuario = ".$user." AND estatus IN (1, 0)");
            $uni='SALDO COMISIONES: $'.number_format($saldo_comisiones,2, '.', ',');
        }

        if ($monto == 0) {
            $respuesta = $this->db->query("UPDATE pago_comision_ind SET estatus = $estatus, descuento_aplicado=1, modificado_por='$usuario', fecha_pago_intmex = GETDATE(), fecha_abono = GETDATE(), comentario='$uni' WHERE id_pago_i=$id_pago_i");
        } else {
            $respuesta = $this->db->query("UPDATE pago_comision_ind SET estatus = $estatus, descuento_aplicado=1, modificado_por='$usuario', fecha_pago_intmex = GETDATE(), fecha_abono = GETDATE(), abono_neodata = $monto, comentario='$uni' WHERE id_pago_i=$id_pago_i");
        }
        $respuesta = $this->db->query("INSERT INTO historial_comisiones VALUES ($id_pago_i, $usuario, GETDATE(), 1, 'MOTIVO DESCUENTO: ".$comentario."')");

        if (! $respuesta ) {
            return 0;
            } else {
            return 1;
            }
    }
        
    function update_retiro($id_pago_i,$monto, $comentario, $usuario){
        if($monto == 0){
            $respuesta = $this->db->query("UPDATE pago_comision_ind SET estatus = 100, descuento_aplicado=1, modificado_por='$usuario', fecha_pago_intmex = GETDATE(), fecha_abono = GETDATE(), comentario='DESCUENTO' WHERE id_pago_i=$id_pago_i");
        } else{
            $respuesta = $this->db->query("UPDATE pago_comision_ind SET estatus = 100, descuento_aplicado=1, modificado_por='$usuario', fecha_pago_intmex = GETDATE(), fecha_abono = GETDATE(), abono_neodata = $monto, comentario='DESCUENTO' WHERE id_pago_i=$id_pago_i");
        }
        $respuesta = $this->db->query("INSERT INTO historial_comisiones VALUES ($id_pago_i, $usuario, GETDATE(), 1, 'MOTIVO DESCUENTO: ".$comentario."')");

        if (! $respuesta ) {
            return 0;
        } else {
            return 1;
        }
    }
 
    function obtenerID($id){
        return $this->db->query("SELECT id_comision from pago_comision_ind WHERE id_pago_i=$id");
    }

    function getDescuentos(){
        return $this->db->query("SELECT pci.id_pago_i, CONCAT(us.nombre,' ',us.apellido_paterno,' ',us.apellido_materno) AS usuario, pci.abono_neodata as monto, lo.nombreLote, hc.comentario AS motivo, pci.estatus, CONCAT(us2.nombre,' ',us2.apellido_paterno,' ',us2.apellido_materno) AS modificado_por, CONVERT(VARCHAR,pci.fecha_abono,20) AS fecha_abono
        FROM pago_comision_ind pci
        INNER JOIN usuarios us ON us.id_usuario = pci.id_usuario
        INNER JOIN comisiones co ON co.id_comision = pci.id_comision
        INNER JOIN lotes lo ON lo.idLote = co.id_lote
        LEFT JOIN historial_comisiones hc ON hc.id_pago_i = pci.id_pago_i AND hc.comentario like 'MOTIVO DESCUENTO%'
        INNER JOIN usuarios us2 ON us2.id_usuario = pci.modificado_por
        WHERE (pci.estatus = 0 ) AND pci.descuento_aplicado = 1");
    }

    function getDescuentos2(){
        return $this->db->query("SELECT pci.id_pago_i, CONCAT(us.nombre,' ',us.apellido_paterno,' ',us.apellido_materno) AS usuario, pci.abono_neodata as monto, 
        lo.nombreLote, hc.comentario AS motivo, pci.estatus, CONCAT(us2.nombre,' ',us2.apellido_paterno,' ',us2.apellido_materno) AS modificado_por,
        pci.fecha_abono
        FROM pago_comision_ind pci
        INNER JOIN usuarios us ON us.id_usuario = pci.id_usuario
        INNER JOIN comisiones co ON co.id_comision = pci.id_comision
        INNER JOIN lotes lo ON lo.idLote = co.id_lote
        LEFT JOIN historial_comisiones hc ON hc.id_pago_i = pci.id_pago_i AND hc.comentario like '%MOTIVO DESCUENTO%'
        INNER JOIN usuarios us2 ON us2.id_usuario = pci.modificado_por
        WHERE (pci.estatus = 17) AND pci.descuento_aplicado = 1");
    }

 
    function getDescuentosCapital(){
        return $this->db->query("SELECT us.estatus as status,SUM(du.monto) as monto, du.id_usuario,CONCAT(us.nombre,' ',us.apellido_paterno,' ',us.apellido_materno) nombre, opc.nombre as puesto, se.id_sede, se.nombre as sede, CONCAT(ua.nombre,' ',ua.apellido_paterno,' ',ua.apellido_materno) creado_por, pci2.abono_pagado, pci3.abono_nuevo, du.pagado_caja, du.pago_individual, du.pagos_activos, du.estatus, (pci2.abono_pagado + du.pagado_caja) aply, CONVERT(varchar,du.fecha_modificacion,23) fecha_creacion, du.estatus as estatusDU
        FROM descuentos_universidad du
        INNER JOIN usuarios us ON us.id_usuario = du.id_usuario AND us.estatus = 1
        INNER JOIN usuarios ua ON ua.id_usuario = du.creado_por
        INNER JOIN opcs_x_cats opc ON opc.id_opcion = us.id_rol AND opc.id_catalogo = 1
        LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_usuario FROM pago_comision_ind WHERE estatus in (17) GROUP BY id_usuario) pci2 ON du.id_usuario = pci2.id_usuario
        LEFT JOIN (SELECT SUM(abono_neodata) abono_nuevo, id_usuario FROM pago_comision_ind WHERE estatus in (1) GROUP BY id_usuario) pci3 ON du.id_usuario = pci3.id_usuario
        LEFT JOIN sedes se ON se.id_sede = us.id_sede
        WHERE du.estatus in (0,1,2,5)
        GROUP BY us.estatus,du.id_usuario, us.nombre, us.apellido_paterno, us.apellido_materno, opc.nombre, se.nombre, ua.nombre, ua.apellido_paterno, ua.apellido_materno,pci2.abono_pagado, pci3.abono_nuevo, se.id_sede, du.pagado_caja, du.pago_individual, du.pagos_activos, du.estatus, du.fecha_modificacion");
    }
    
    function getDescuentosCapitalpagos($user){
        return $this->db->query("SELECT du.id_descuento, du.id_usuario, CONCAT(us.nombre,' ',us.apellido_paterno,' ',us.apellido_materno) nombre, opc.nombre as puesto, se.nombre as sede, pci.abono_neodata as monto, du.estatus, CONCAT(ua.nombre,' ',ua.apellido_paterno,' ',ua.apellido_materno) creado_por, pci.fecha_abono, du.detalles, pci.estatus
        FROM descuentos_universidad du
        INNER JOIN pago_comision_ind pci ON pci.id_usuario = du.id_usuario AND pci.estatus = 17
        INNER JOIN usuarios us ON us.id_usuario = du.id_usuario
        INNER JOIN usuarios ua ON ua.id_usuario = du.creado_por
        INNER JOIN opcs_x_cats opc ON opc.id_opcion = us.id_rol AND opc.id_catalogo = 1
        LEFT JOIN sedes se ON se.id_sede = us.id_sede
        WHERE du.id_usuario = $user")->result_array();
    }

    function getHistorialDescuentos($proyecto, $condominio) {
        if($condominio == 0) {
            $whereProyecto = "AND re.idResidencial = $proyecto";
            $whereCondominio = "";
        } else {
            $whereProyecto = "";
            $whereCondominio = "AND con.idCondominio = $condominio";
        }
        return $this->db->query("SELECT pci.id_pago_i, CONCAT(us.nombre,' ',us.apellido_paterno,' ',us.apellido_materno) AS usuario, pci.abono_neodata as monto, lo.nombreLote, hc.comentario AS motivo, CONCAT(us2.nombre,' ',us2.apellido_paterno,' ',us2.apellido_materno) AS modificado_por, pci.fecha_abono, pci.estatus
        FROM pago_comision_ind pci
        INNER JOIN usuarios us ON us.id_usuario = pci.id_usuario
        INNER JOIN comisiones co ON co.id_comision = pci.id_comision
        INNER JOIN lotes lo ON lo.idLote = co.id_lote
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio $whereCondominio
        INNER JOIN residenciales re ON re.idResidencial = con.idResidencial $whereProyecto
        INNER JOIN historial_comisiones hc ON hc.id_pago_i = pci.id_pago_i  
        INNER JOIN usuarios us2 ON us2.id_usuario = hc.id_usuario
        WHERE pci.estatus IN(0,27,16) and pci.comentario='DESCUENTO' AND pci.descuento_aplicado IN (1) AND (hc.comentario like '%MOTIVO DESCUENTO%' OR hc.comentario like 'MÓTIVO DESCUENTO%')
        group by pci.id_pago_i,us.nombre,us.apellido_paterno,us.apellido_materno,pci.abono_neodata,lo.nombreLote, hc.comentario,us2.nombre,us2.apellido_paterno,us2.apellido_materno,pci.fecha_abono, pci.estatus");
    }

    function getHistorialRetiros($proyecto,$condominio){
        if($condominio == 0){
            return $this->db->query("SELECT pci.id_pago_i, CONCAT(us.nombre,' ',us.apellido_paterno,' ',us.apellido_materno) AS usuario, pci.abono_neodata as monto, lo.nombreLote, hc.comentario AS motivo, CONCAT(us2.nombre,' ',us2.apellido_paterno,' ',us2.apellido_materno) AS modificado_por, pci.fecha_abono , pci.estatus
            FROM pago_comision_ind pci 
            INNER JOIN usuarios us ON us.id_usuario = pci.id_usuario 
            INNER JOIN comisiones co ON co.id_comision = pci.id_comision 
            INNER JOIN lotes lo ON lo.idLote = co.id_lote 
            INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
            INNER JOIN residenciales re ON re.idResidencial = con.idResidencial 
            LEFT JOIN historial_comisiones hc ON hc.id_pago_i = pci.id_pago_i AND hc.comentario like '%MOTIVO DESCUENTO%' 
            INNER JOIN usuarios us2 ON us2.id_usuario = pci.modificado_por 
            WHERE pci.estatus IN(100,12) AND pci.descuento_aplicado = 1 AND re.idResidencial = $proyecto");
            } else{
                return $this->db->query("SELECT pci.id_pago_i, CONCAT(us.nombre,' ',us.apellido_paterno,' ',us.apellido_materno) AS usuario, pci.abono_neodata as monto, lo.nombreLote, hc.comentario AS motivo, CONCAT(us2.nombre,' ',us2.apellido_paterno,' ',us2.apellido_materno) AS modificado_por, pci.fecha_abono, pci.estatus 
                FROM pago_comision_ind pci 
                INNER JOIN usuarios us ON us.id_usuario = pci.id_usuario 
                INNER JOIN comisiones co ON co.id_comision = pci.id_comision 
                INNER JOIN lotes lo ON lo.idLote = co.id_lote 
                INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
                INNER JOIN residenciales re ON re.idResidencial = con.idResidencial 
                LEFT JOIN historial_comisiones hc ON hc.id_pago_i = pci.id_pago_i AND hc.comentario like '%MOTIVO DESCUENTO%' 
                INNER JOIN usuarios us2 ON us2.id_usuario = pci.modificado_por 
                WHERE pci.estatus IN(100,12) AND pci.descuento_aplicado = 1 AND con.idCondominio = $condominio");
        }
    }

    function BorrarDescuento($id_bono){
        $respuesta = $this->db->query("UPDATE pago_comision_ind SET comentario = CONCAT(id_comision, '-', 'BAJA BONO'), id_comision = 0,modificado_por='".$this->session->userdata('id_usuario')."' WHERE estatus = 0 AND descuento_aplicado = 1 AND id_pago_i = $id_bono");
        if (! $respuesta ) {
        return 0;
        } else {
        return 1;
        }
    }

    function UpdateDescuento($id_bono){
        $respuesta = $this->db->query("UPDATE pago_comision_ind SET estatus = 27,modificado_por='".$this->session->userdata('id_usuario')."' WHERE estatus = 0 AND descuento_aplicado = 1 AND id_pago_i = $id_bono");
        if (! $respuesta ) {
        return 0;
        } else {
        return 1;
        }
    }
 
    function getDatosComisionesHistorialDescuentos($proyecto,$condominio){
        if($condominio == 0){
            return $this->db->query("SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, pci1.estatus, pci1.fecha_abono fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) user_names ,pci1.id_usuario, oprol.nombre as puesto, cl.personalidad_juridica, u.forma_pago, f.id_comision as factura, pac.porcentaje_abono, (CASE WHEN com.ooam = 1 THEN  CONCAT(oxcest.nombre,' (OOAM)') ELSE oxcest.nombre END) estatus_actual, oxcest.id_opcion id_estatus_actual, pci1.descuento_aplicado
            FROM pago_comision_ind pci1 
            LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE (estatus in (11,3) OR descuento_aplicado = 1) 
            GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
            INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
            INNER JOIN lotes lo ON lo.idLote = com.id_lote
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
            INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
            INNER JOIN clientes cl ON cl.idLote = lo.idLote
            INNER JOIN porcentajes_comisiones pc ON pc.relacion_prospeccion = cl.lugar_prospeccion
            INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
            INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado
            INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
            INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus 
            LEFT JOIN facturas f ON f.id_comision = com.id_comision
            WHERE pci1.estatus IN (0,11) AND re.idResidencial = $proyecto AND pci1.descuento_aplicado = 1
            AND com.estatus in (1,8) AND oprol.id_catalogo = 1 AND oxcest.id_catalogo = 23 AND lo.status = 1 AND cl.status = 1
            GROUP BY pci1.id_comision,com.ooam, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, cl.personalidad_juridica, u.forma_pago, f.id_comision, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, pci1.descuento_aplicado ORDER BY lo.nombreLote");
        }else{
            return $this->db->query("SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, pci1.estatus, pci1.fecha_abono fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) user_names ,pci1.id_usuario, oprol.nombre as puesto, cl.personalidad_juridica, u.forma_pago, f.id_comision as factura, pac.porcentaje_abono, (CASE WHEN com.ooam = 1 THEN  CONCAT(oxcest.nombre,' (OOAM)') ELSE oxcest.nombre END) estatus_actual, oxcest.id_opcion id_estatus_actual, pci1.descuento_aplicado
            FROM pago_comision_ind pci1 
            LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE (estatus in (11,3) OR descuento_aplicado = 1) 
            GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
            INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
            INNER JOIN lotes lo ON lo.idLote = com.id_lote
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
            INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
            INNER JOIN clientes cl ON cl.idLote = lo.idLote
            INNER JOIN porcentajes_comisiones pc ON pc.relacion_prospeccion = cl.lugar_prospeccion
            INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
            INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado
            INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
            INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus 
            LEFT JOIN facturas f ON f.id_comision = com.id_comision
            -- WHERE pci1.estatus IN (1, 3, 4, 5, 6, 7, 8, 9, 10, 11) 
            WHERE pci1.estatus IN (1, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12) AND co.idCondominio = $condominio and com.id_usuario  = ".$this->session->userdata('id_usuario')."  AND pc.id_rol = ".$this->session->userdata('id_rol')." 
            AND com.estatus in (1,8) AND oprol.id_catalogo = 1 AND oxcest.id_catalogo = 23 AND lo.status = 1 AND cl.status = 1
            GROUP BY pci1.id_comision,com.ooam, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, cl.personalidad_juridica, u.forma_pago, f.id_comision, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, pci1.descuento_aplicado ORDER BY lo.nombreLote");
        } 
    }

    function getDatosHistorialPostventa(){
        return $this->db->query("SELECT DISTINCT(lo.idLote),cm1.comision_total, cm2.abono_pagos, cm3.abono_pagos as abonados, pc.total_comision, lo.totalNeto2, cl.fechaApartado, lo.nombreLote, cl.nombre, cl.apellido_paterno, cl.apellido_materno, lo.registro_comision, lo.totalNeto2, lo.referencia, cn.nombre as condominio, rs.nombreResidencial as proyecto
        FROM lotes lo
        INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente
        INNER JOIN condominios cn ON lo.idCondominio=cn.idCondominio
        INNER JOIN residenciales rs ON cn.idResidencial = rs.idResidencial
        INNER JOIN pago_comision pc ON pc.id_lote = lo.idLote
        INNER JOIN comisiones cm ON cm.id_lote = lo.idLote and cm.estatus = 1
        LEFT JOIN (SELECT SUM(c0.comision_total) comision_total, c0.id_lote FROM comisiones c0 WHERE c0.estatus in (1) AND c0.id_usuario NOT IN (0) GROUP BY c0.id_lote ) cm1 ON cm1.id_lote = lo.idLote
        LEFT JOIN (SELECT SUM(p0.abono_neodata) abono_pagos, c0.id_lote FROM comisiones c0 
        LEFT JOIN pago_comision_ind p0 ON p0.id_comision = c0.id_comision WHERE c0.estatus in (1) AND c0.id_usuario NOT IN (0) GROUP BY c0.id_lote ) cm3 ON cm3.id_lote = lo.idLote   
        LEFT JOIN (SELECT SUM(p0.abono_neodata) abono_pagos, c0.id_lote FROM comisiones c0 
        LEFT JOIN pago_comision_ind p0 ON p0.id_comision = c0.id_comision AND (p0.estatus in (11,3,4,88) OR p0.descuento_aplicado = 1) WHERE c0.estatus in (1) AND c0.id_usuario NOT IN (0) GROUP BY c0.id_lote ) cm2 ON cm2.id_lote = lo.idLote
        LEFT JOIN plan_comision pl ON pl.id_plan = cl.plan_comision
        LEFT JOIN sedes se ON se.id_sede = cl.id_sede 
        ORDER BY lo.idLote");  
    }

    function comisionistasPorLote($idLote){
        return $this->db->query("SELECT porcentaje_decimal, CONVERT(VARCHAR,cm.fecha_creacion,20) AS fechaCreacion, CONCAT(nombre,' ',apellido_paterno,' ',apellido_materno) AS nombre  
        FROM lotes lo
        INNER JOIN comisiones cm ON cm.id_lote = lo.idLote and cm.estatus = 1
        INNER JOIN usuarios usu ON usu.id_usuario = cm.id_usuario
        WHERE lo.idLote = $idLote");
    }
    
    function getHistorialAbono($id){
        $this->db->query("SET LANGUAGE Español;");
        return $this->db->query("SELECT b.*,p.*,x.nombre as est, b.comentario as motivo, convert(nvarchar, p.fecha_abono, 6) date_final, CONCAT(us.nombre, ' ',us.apellido_paterno, ' ',us.apellido_materno) AS creado_por
        FROM bonos b 
        INNER JOIN pagos_bonos_ind p on p.id_bono=b.id_bono 
        INNER JOIN opcs_x_cats x on x.id_opcion=p.estado
        INNER JOIN usuarios us on us.id_usuario = p.creado_por
        WHERE p.id_bono=$id and x.id_catalogo=46 ORDER BY p.id_bono DESC");
    }
 
    function getHistorialAbono2($pago){ 
        $this->db->query("SET LANGUAGE Español;");
        return $this->db->query(" SELECT DISTINCT(hc.comentario), hc.id_pago_b, hc.id_usuario, convert(nvarchar(20), hc.fecha_creacion, 113) date_final, hc.fecha_creacion as fecha_movimiento, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre_usuario
        FROM historial_bonos hc 
        INNER JOIN pagos_bonos_ind pci ON pci.id_pago_bono = hc.id_pago_b
        INNER JOIN usuarios u ON u.id_usuario = hc.id_usuario 
        WHERE hc.id_pago_b = $pago
        ORDER BY hc.fecha_creacion DESC");
    }

    function BonoCerrado($id){
        return $this->db->query("SELECT b.monto,b.num_pagos,SUM(p.abono) as suma,p.n_p FROM bonos b INNER JOIN pagos_bonos_ind p on p.id_bono=b.id_bono WHERE p.id_bono=$id GROUP BY b.monto, b.num_pagos,p.n_p");
    }

    function getBonosPorUserContra($estado){
        $filtro = '';
        if($this->session->userdata("id_rol") == 18)
        $filtro = " and u.id_rol in(18, 19, 20, 25, 26, 27, 28, 30, 36)";

        return $this->db->query("SELECT CONCAT(u.nombre, ' ', u.apellido_paterno, ' ' ,u.apellido_materno) as nombre, CASE WHEN u.nueva_estructura = 2 THEN opcx2.nombre ELSE opcx.nombre END as id_rol, p.id_bono, p.id_usuario, p.monto, p.num_pagos, b.abono pago, p.estatus, p.comentario, b.fecha_abono, b.estado, b.id_pago_bono, b.abono, b.n_p, (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*p.pago) ELSE p.pago END) impuesto1, sed.impuesto, u.rfc
        FROM bonos p INNER JOIN usuarios u ON u.id_usuario=p.id_usuario 
        INNER JOIN pagos_bonos_ind b on b.id_bono = p.id_bono 
        INNER JOIN opcs_x_cats opcx on opcx.id_opcion = u.id_rol AND opcx.id_catalogo = 1
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = u.forma_pago AND oxc.id_catalogo = 16
        LEFT JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario 
        WHEN 2 THEN 2 
        WHEN 3 THEN 2 
        WHEN 1980 THEN 2 
        WHEN 1981 THEN 2 
        WHEN 1982 THEN 2 
        WHEN 1988 THEN 2 
        WHEN 4 THEN 5
        WHEN 5 THEN 3
        WHEN 607 THEN 1 
        WHEN 7092 THEN 4
        WHEN 9629 THEN 2
        ELSE u.id_sede END) and sed.estatus = 1
        LEFT JOIN opcs_x_cats opcx2 on opcx2.id_opcion = u.id_rol AND opcx2.id_catalogo = 83
        WHERE b.estado IN ($estado) $filtro");
    }

    function getBonosX_User($usuario){
        return $this->db->query("SELECT CONCAT(u.nombre, ' ', u.apellido_paterno, ' ' ,u.apellido_materno) as nombre, p.id_rol,p.id_bono,p.id_usuario,p.monto,p.num_pagos,p.pago,p.estatus,p.comentario, convert(date,b.fecha_abono) as fecha_abono,b.estado,b.id_pago_bono,b.abono,b.n_p,x.nombre as name, (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*p.pago) ELSE p.pago END) impuesto1,sed.impuesto,opcx.nombre as id_rol
        FROM bonos p 
        INNER JOIN usuarios u ON u.id_usuario = p.id_usuario 
        INNER JOIN pagos_bonos_ind b on b.id_bono = p.id_bono 
        inner join opcs_x_cats opcx on opcx.id_opcion = u.id_rol
        INNER JOIN opcs_x_cats x on x.id_opcion = b.estado
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = u.forma_pago AND oxc.id_catalogo = 16
        LEFT JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario 
        WHEN 2 THEN 2 
        WHEN 3 THEN 2 
        WHEN 1980 THEN 2 
        WHEN 1981 THEN 2 
        WHEN 1982 THEN 2 
        WHEN 1988 THEN 2 
        WHEN 4 THEN 5
        WHEN 5 THEN 3
        WHEN 607 THEN 1 
        WHEN 7092 THEN 4
        WHEN 9629 THEN 2
        ELSE u.id_sede END) and sed.estatus = 1
        WHERE x.id_catalogo = 46 and opcx.id_catalogo = 1 AND b.id_usuario = $usuario");
    }

    function getBonosAllUser($a, $b){
        $cadena = ''; 
        switch($this->session->userdata('id_rol')){
            case 31:
                $cadena = ' WHERE b.estado in (3, 6)';
            break;
            
        case 18:
            $cadena = ' WHERE u.id_rol in (18, 19, 20, 25, 26, 27, 28, 30, 36)';
            break;

        case 1:
        case 2:  
        case 3:  
        case 9:  
        case 7: 
            $cadena = ' WHERE b.id_usuario in ('.$this->session->userdata('id_usuario').')';
            break;

        case 32: 
        case 13: 
        case 17: 
            if($b != 0){
                $cadena = ' WHERE b.id_usuario in ('.$b.') AND u.id_rol in ('.$a.')';
            } else {
                if($a == 20)
                    $cadena = ' WHERE u.id_rol in (18, 19, 20, 25, 26, 27, 28, 30, 36) ';
                else
                    $cadena = ' WHERE u.id_rol in ('.$a.')';
            }
            break;

        default:
            if($a == 20)
                $cadena = ' WHERE u.id_rol in (18, 19, 20, 25, 26, 27, 28, 30, 36) ';
            else
                $cadena = ' WHERE u.id_rol in ('.$a.') ';
            break;
    }

        return $this->db->query("SELECT CONCAT(u.nombre,' ',u.apellido_paterno,' ',u.apellido_materno) as nombre, p.id_rol, p.id_bono, p.id_usuario, p.monto, p.num_pagos, p.pago, p.estatus, p.comentario, convert(date, b.fecha_abono) as fecha_abono, b.estado, b.id_pago_bono, b.abono, b.n_p, x.nombre as name, CASE WHEN u.nueva_estructura = 1 THEN opcx2.nombre ELSE opcx.nombre END AS id_rol, (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*p.pago) ELSE p.pago END) impuesto1, sed.impuesto, x.nombre as est, u.rfc
        FROM bonos p 
        INNER JOIN usuarios u ON u.id_usuario = p.id_usuario 
        INNER JOIN pagos_bonos_ind b on b.id_bono = p.id_bono 
        INNER JOIN opcs_x_cats x on x.id_opcion = b.estado AND x.id_catalogo = 46
        INNER JOIN opcs_x_cats opcx on opcx.id_opcion = u.id_rol AND opcx.id_catalogo = 1
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = u.forma_pago AND oxc.id_catalogo = 16
        LEFT JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario 
        WHEN 2 THEN 2 
        WHEN 3 THEN 2 
        WHEN 1980 THEN 2 
        WHEN 1981 THEN 2 
        WHEN 1982 THEN 2 
        WHEN 1988 THEN 2 
        WHEN 4 THEN 5
        WHEN 5 THEN 3
        WHEN 607 THEN 1 
        WHEN 7092 THEN 4
        WHEN 9629 THEN 2
        ELSE u.id_sede END) and sed.estatus = 1 
        LEFT JOIN opcs_x_cats opcx2 on opcx2.id_opcion = u.id_rol AND opcx2.id_catalogo = 83 $cadena");
    }


    function UpdateINMEX($id_bono,$estatus){
        $fecha = '';
        $id = $id_bono;
        $comentario = 'INTERNOMEX MARCÓ COMO PAGADO';
        if($estatus == 6){
            $comentario = 'CONTRALORÍA ENVIÓ A INTERNOMEX';
        } else if($estatus == 2){
            $fecha = ',fecha_abono_intmex=GETDATE()';
            $comentario = 'COLABORADOR ENVIÓ A REVISIÓN';
        }
        $respuesta = $this->db->query("UPDATE pagos_bonos_ind SET estado=$estatus $fecha WHERE id_pago_bono=$id_bono ");
        $respuesta = $this->db->query("INSERT INTO historial_bonos(id_pago_b,id_usuario,fecha_creacion,estatus,comentario) VALUES($id,".$this->session->userdata('id_usuario').",GETDATE(),1,'$comentario')");
        if (! $respuesta ) {
            return 0;
            } else {
            return 1;
            }
    }
 
    function insertar_bono($usuarioid,$rol,$monto,$numeroP,$pago,$comentario,$usuario){
        $respuesta = $this->db->query("INSERT INTO bonos(id_usuario,id_rol,monto,num_pagos,pago,estatus,comentario,fecha_creacion,creado_por) VALUES(".$usuarioid.",".$rol." ,".$monto.",".$numeroP.",".$pago.",1, '".$comentario."', GETDATE(), ".$usuario.")");
        if (! $respuesta ) {
            return 0;
            } else {
            return 1;
            }
    }

    function UpdateRevision($id_bono){
        $respuesta = $this->db->query("UPDATE pagos_bonos_ind SET estado=2 WHERE id_pago_bono=$id_bono ");
        $id = $id_bono;
        $respuesta = $this->db->query("INSERT INTO historial_bonos(id_pago_b,id_usuario,fecha_creacion,estatus,comentario) VALUES($id,".$this->session->userdata('id_usuario').",GETDATE(),1,'COLABORADOR ENVÍO A CONTRALORÍA')");
        if (! $respuesta ) {
            return 0;
            } else {
            return 1;
            }
    }

    function UpdateAbono($id_bono){
        $respuesta = $this->db->query("UPDATE bonos SET estatus=2 WHERE id_bono=$id_bono ");
        if (! $respuesta ) {
            return 0;
            } else {
            return 1;
            }
    }

    function getBonos(){
        return $this->db->query("SELECT p.id_bono,CONCAT(u.nombre, ' ', u.apellido_paterno, ' ' ,u.apellido_materno) as nombre, CASE WHEN u.nueva_estructura = 1 THEN opcx2.nombre ELSE opcx.nombre END as id_rol,p.id_bono, p.id_usuario,p.monto,p.num_pagos, p.estatus,convert(date,p.fecha_creacion) as fecha_creacion, sum(d.abono) as suma,p.pago, CAST(p.comentario AS NVARCHAR(4000)) as comentario, (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*p.pago) ELSE p.pago END) impuesto1,sed.impuesto
        FROM bonos p 
        LEFT JOIN pagos_bonos_ind d ON d.id_bono = p.id_bono
        INNER JOIN usuarios u ON u.id_usuario = p.id_usuario 
        INNER JOIN opcs_x_cats opcx on opcx.id_opcion = u.id_rol AND opcx.id_catalogo = 1
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = u.forma_pago AND oxc.id_catalogo = 16
        LEFT JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario 
        WHEN 2 THEN 2 
        WHEN 3 THEN 2 
        WHEN 1980 THEN 2 
        WHEN 1981 THEN 2 
        WHEN 1982 THEN 2 
        WHEN 1988 THEN 2 
        WHEN 4 THEN 5
        WHEN 5 THEN 3
        WHEN 607 THEN 1 
        WHEN 7092 THEN 4
        WHEN 9629 THEN 2
        ELSE u.id_sede END) and sed.estatus = 1
        LEFT JOIN opcs_x_cats opcx2 on opcx2.id_opcion = u.id_rol AND opcx2.id_catalogo = 83
        WHERE p.estatus = 1
        GROUP BY CONCAT(u.nombre, ' ', u.apellido_paterno, ' ' ,u.apellido_materno),opcx.nombre, p.id_bono, p.id_usuario, p.monto, p.num_pagos, p.estatus, p.fecha_creacion,p.pago, CAST(p.comentario AS NVARCHAR(4000)), p.id_bono, sed.impuesto, u.forma_pago, u.nueva_estructura, opcx2.nombre");
    }

    function InsertAbono($id_abono,$id_user,$pago,$usuario,$n_p){
        $respuesta = $this->db->query("INSERT INTO pagos_bonos_ind(id_bono,id_usuario,abono,estado,comentario,fecha_abono,fecha_abono_intmex,creado_por,n_p) VALUES(".$id_abono.",".$id_user." ,".$pago.",1,'ABONO', GETDATE(), GETDATE(), ".$usuario." ,$n_p)");
        $id = $this->db->insert_id();
        $respuesta = $this->db->query("INSERT INTO historial_bonos(id_pago_b,id_usuario,fecha_creacion,estatus,comentario) VALUES($id,".$this->session->userdata('id_usuario').",GETDATE(),1,'AGREGÓ UN NUEVO ABONO')");

        if (! $respuesta ) {
            return 0;
            } else {
            return 1;
            }
    }

    function TieneAbonos($id){
        return $this->db->query("SELECT * FROM pagos_bonos_ind WHERE id_bono=$id");    
    }
    
    function BorrarBono($id_bono){
        $respuesta = $this->db->query("UPDATE bonos SET estatus = 0 WHERE id_bono=$id_bono ");
        if (! $respuesta ) {
        return 0;
        } else {
        return 1;
        }
    }
 
    function getPrestamoxUser($id,$tipo){
        return $this->db->query("SELECT id_usuario FROM prestamos_aut WHERE id_usuario=$id AND estatus=1 and tipo=$tipo");
    }

    function TienePago($id){
        return $this->db->query("SELECT * FROM pagos_prestamos_ind WHERE id_prestamo=$id");
    }
    
    public function BorrarPrestamo($id_prestamo){
        $respuesta = $this->db->query("UPDATE prestamos_aut SET estatus=0,modificado_por=".$this->session->userdata('id_usuario')." WHERE id_prestamo=$id_prestamo ");
        $respuesta = $this->db->query("INSERT INTO historial_log VALUES($id_prestamo,".$this->session->userdata('id_usuario').",GETDATE(),1,'SE CANCELÓ EL PRÉSTAMO','prestamos_aut',NULL)");

        if (! $respuesta ) {
            return 0;
        } else {
            return 1;
        }
    }
            

    function insertar_prestamos($insertArray){
        $this->db->insert('prestamos_aut', $insertArray);
        $afftectedRows = $this->db->affected_rows();
        if ($afftectedRows == 0) {
            return 0;
        } else {
            return 1;
        }
    }
    
    function getPrestamos(){
        return $this->db->query("SELECT CONCAT(u.nombre, ' ', u.apellido_paterno, ' ' ,u.apellido_materno) as nombre, p.id_prestamo,p.id_usuario,p.monto,p.num_pagos,p.estatus,p.comentario,p.fecha_creacion,p.pago_individual,pendiente,SUM(pci.abono_neodata) as total_pagado,opc.nombre as tipo,opc.id_opcion, (SELECT TOP 1 rpp2.fecha_creacion FROM relacion_pagos_prestamo rpp2 WHERE rpp2.id_prestamo = rpp.id_prestamo ORDER BY rpp2.id_relacion_pp DESC) AS fecha_creacion_referencia, rpp.id_prestamo as id_prestamo2
        FROM prestamos_aut p 
        INNER JOIN usuarios u ON u.id_usuario=p.id_usuario 
        LEFT JOIN relacion_pagos_prestamo rpp ON rpp.id_prestamo = p.id_prestamo
        LEFT JOIN pago_comision_ind pci ON pci.id_pago_i = rpp.id_pago_i AND pci.estatus in (18,19,20,21,22,23,24,25,26,28,29) AND pci.descuento_aplicado = 1
        LEFT JOIN opcs_x_cats opc on opc.id_opcion=p.tipo and opc.id_catalogo=23
        WHERE p.estatus in(1,2,3,0)
        GROUP BY rpp.id_prestamo, u.nombre,u.apellido_paterno,u.apellido_materno,p.id_prestamo,p.id_usuario,p.monto,p.num_pagos,p.estatus,p.comentario,p.fecha_creacion,p.pago_individual,pendiente,opc.nombre,opc.id_opcion");
    }
    
    function getPrestamosXporUsuario(){
        return $this->db->query("SELECT CONCAT(u.nombre, ' ', u.apellido_paterno, ' ' ,u.apellido_materno) as nombre, p.evidenciaDocs as evidencia, p.id_prestamo,p.id_usuario,p.monto,p.num_pagos,p.estatus,p.comentario,p.fecha_creacion,p.pago_individual,pendiente,SUM(pci.abono_neodata) as total_pagado,opc.nombre as tipo,opc.id_opcion, (SELECT TOP 1 rpp2.fecha_creacion FROM relacion_pagos_prestamo rpp2 WHERE rpp2.id_prestamo = rpp.id_prestamo ORDER BY rpp2.id_relacion_pp DESC) AS fecha_creacion_referencia, rpp.id_prestamo as id_prestamo2
        FROM prestamos_aut p 
        INNER JOIN usuarios u ON u.id_usuario = p.id_usuario and u.id_usuario = ".$this->session->userdata('id_usuario')." 
        LEFT JOIN relacion_pagos_prestamo rpp ON rpp.id_prestamo = p.id_prestamo
        LEFT JOIN pago_comision_ind pci ON pci.id_pago_i = rpp.id_pago_i AND pci.estatus in (18,19,20,21,22,23,24,25,26,28) AND pci.descuento_aplicado = 1
        LEFT JOIN opcs_x_cats opc on opc.id_opcion=p.tipo and opc.id_catalogo=23
        WHERE p.estatus in(1,2,3,0) 
        GROUP BY rpp.id_prestamo, u.nombre,u.apellido_paterno,u.apellido_materno,p.id_prestamo,p.id_usuario,p.monto,p.num_pagos,p.estatus,p.comentario,p.fecha_creacion,p.pago_individual,pendiente,p.evidenciaDocs,opc.nombre,opc.id_opcion");
    }
    
    function InsertPago($id_prestamo,$id_user,$pago,$usuario){
        $respuesta = $this->db->query("INSERT INTO pagos_prestamos_ind(id_prestamo,id_usuario,pago,estado,comentario,fecha_abono,fecha_abono_intmex,creado_por) VALUES(".$id_prestamo.",".$id_user." ,".$pago.",1,'ABONO A PRESTAMO', GETDATE(), GETDATE(), ".$usuario." )");
        if (! $respuesta ) {
            return 0;
        } else {
            return 1;
        }
    }
    
    function PagoCerrado($id){
        return $this->db->query("SELECT b.monto,b.num_pagos,SUM(p.pago) as suma FROM prestamo b INNER JOIN pagos_prestamos_ind p on p.id_prestamo=b.id_prestamo WHERE p.id_prestamo=$id GROUP BY b.monto, b.num_pagos");
    }

    function UpdatePrestamo($id_prestamo){
        $respuesta = $this->db->query("UPDATE prestamo SET estatus=2 WHERE id_prestamo=$id_prestamo ");
        if (! $respuesta ) {
            return 0;
        } else {
            return 1;
        }
    }
    
    function getHistorialPrestamo($id){
        return $this->db->query(" SELECT * FROM prestamo b INNER JOIN pagos_prestamos_ind p on p.id_prestamo=b.id_prestamo WHERE p.id_prestamo=$id ORDER BY p.id_prestamo DESC");
    }

    function getPrestamoPorUser($id,$estado){
        return $this->db->query("SELECT CONCAT(u.nombre, ' ', u.apellido_paterno, ' ' ,u.apellido_materno) as nombre,p.id_prestamo,p.id_usuario,p.monto,p.num_pagos,p.pago,p.estatus,p.comentario,b.fecha_abono,b.estado,b.id_pago_prestamo,b.pago FROM prestamo p INNER JOIN usuarios u ON u.id_usuario=p.id_usuario INNER JOIN pagos_prestamos_ind b on b.id_prestamo=p.id_prestamo WHERE p.id_usuario=$id AND b.estado=$estado");
    }
    
    function UpdateRevisionPagos($id_prestamo){
        $respuesta = $this->db->query("UPDATE pagos_prestamos_ind SET estado=2 WHERE id_pago_prestamo=$id_prestamo ");
        if (! $respuesta ) {
            return 0;
        } else {
            return 1;
        }
    }

    function getPrestamosAllUser($estado){
        return $this->db->query("SELECT CONCAT(u.nombre, ' ', u.apellido_paterno, ' ' ,u.apellido_materno) as nombre,p.id_prestamo,p.id_usuario,p.monto,p.num_pagos,p.pago,p.estatus,p.comentario,b.fecha_abono,b.estado,b.id_pago_prestamo,b.pago FROM prestamo p INNER JOIN usuarios u ON u.id_usuario=p.id_usuario INNER JOIN pagos_prestamos_ind b on b.id_prestamo=p.id_prestamo WHERE  b.estado=$estado");
    }

    function getHistorialPrestamoContra($id){
        return $this->db->query(" SELECT * FROM pagos_prestamos_ind WHERE id_pago_prestamo=$id");
    }

    function AbonosMensuales(){
        return $this->db->query("select p.id_bono,b.id_usuario,b.pago from bonos b inner join pagos_bonos_ind p on b.id_bono=p.id_bono where b.estatus=1 and convert(date,p.fecha_abono)=convert(date,DATEADD(month, -1, GETDATE() ))"); 
    }
    function AbonoHoy($usuario){
        return $this->db->query(" select * from pagos_bonos_ind where id_usuario=".$usuario." and convert(date,fecha_abono) = CONVERT(date,GETDATE())"); 
    }
 
    public function getDataDispersionPagoReport() {
        $query = $this->db-> query("(SELECT DISTINCT(l.idLote), l.idStatusContratacion, l.registro_comision, cl.id_cliente, CONCAT(cl.nombre,' ',cl.apellido_paterno,' ',cl.apellido_materno) nombre_cliente, l.nombreLote, l.idStatusContratacion, res.nombreResidencial, cond.nombre as nombreCondominio, l.tipo_venta, l.referencia, vc.id_cliente AS compartida, l.totalNeto, l.totalNeto2, l.plan_enganche, plane.nombre as enganche_tipo, cl.lugar_prospeccion, ae.id_usuario as id_asesor, CONCAT(ae.nombre, ' ', ae.apellido_paterno, ' ', ae.apellido_materno) as asesor,si.comision_total,SUM(pg.abono_neodata) as abonado
        FROM lotes l
        INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
        INNER JOIN condominios cond ON l.idCondominio = cond.idCondominio
        INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
        LEFT JOIN pago_comision pc ON pc.id_lote = l.idLote AND pc.bandera in (0)
        LEFT JOIN opcs_x_cats plane ON plane.id_opcion = l.plan_enganche AND plane.id_catalogo = 39
        INNER JOIN comisiones si ON si.id_lote = l.idLote
        INNER JOIN pago_comision_ind pg ON pg.id_comision = si.id_comision
        LEFT JOIN (SELECT id_cliente FROM ventas_compartidas WHERE estatus = 1) AS vc ON vc.id_cliente = cl.id_cliente
        INNER JOIN  usuarios ae ON ae.id_usuario = cl.id_asesor
        WHERE l.idStatusContratacion BETWEEN 9 AND 15 AND cl.status = 1 AND l.status = 1 AND cl.lugar_prospeccion!=6 and si.rol_generado = 7 AND l.registro_comision in (1) AND pc.bandera in (0) and pg.id_usuario != 4415 and cl.id_asesor = si.id_usuario AND tipo_venta IS NOT NULL AND tipo_venta IN (1, 2) AND l.idLote NOT in (39813,37064,38929,39813) AND (cl.fechaApartado >= '2020-03-01' OR l.idlote IN (36344, 23250,22078,10191,23047,10207,13782,29654,22183,23150,22967,13621,33564,22115,32343,11278,11279,34773,35682,12068,13125,29413,35531,23088,35484,32441,13969,31907,2990,35488,35487,35627,35670,28435,36491,36596,36497,35635,35738,25796,11622,36544,36492,25655,36503,34938,36500,34789,36430,36431,19361,36713,36712,35279,36690,22708,32669,34515,36743,37047,36991,37046,34104,37045,36397,36832,37052,27875,4579,37063,36854,36855,36856,36280,36281,36348,36349,36346,36323,33919,35930,27252,30841,35260,28910,37055,27880,27359, 36826, 46865, 44684, 40109, 35863,34191,40635,26933 ) )
        GROUP BY l.idLote,l.idStatusContratacion, l.registro_comision, cl.id_cliente, CONCAT(cl.nombre,' ',cl.apellido_paterno,' ',cl.apellido_materno),l.nombreLote, l.idStatusContratacion, res.nombreResidencial, cond.nombre, l.tipo_venta, l.referencia, vc.id_cliente,l.totalNeto, l.totalNeto2, l.plan_enganche, plane.nombre, cl.lugar_prospeccion, ae.id_usuario, CONCAT(ae.nombre, ' ', ae.apellido_paterno, ' ', ae.apellido_materno),si.comision_total)
        UNION
        (SELECT DISTINCT(l.idLote), l.idStatusContratacion, l.registro_comision, cl.id_cliente, CONCAT(cl.nombre,' ',cl.apellido_paterno,' ',cl.apellido_materno) nombre_cliente, l.nombreLote, l.idStatusContratacion, res.nombreResidencial, cond.nombre as nombreCondominio, l.tipo_venta, l.referencia, vc.id_cliente AS compartida, l.totalNeto, l.totalNeto2, l.plan_enganche, plane.nombre as enganche_tipo, cl.lugar_prospeccion, ae.id_usuario as id_asesor, CONCAT(ae.nombre, ' ', ae.apellido_paterno, ' ', ae.apellido_materno) as asesor,si.comision_total,SUM(pg.abono_neodata) as abonado
        FROM lotes l
        INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
        INNER JOIN condominios cond ON l.idCondominio=cond.idCondominio
        INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
        LEFT JOIN pago_comision pc ON pc.id_lote = l.idLote AND pc.bandera in (0)
        LEFT JOIN opcs_x_cats plane ON plane.id_opcion= l.plan_enganche AND plane.id_catalogo = 39
        INNER JOIN comisiones si ON si.id_lote=l.idLote
        INNER JOIN pago_comision_ind pg ON pg.id_comision=si.id_comision
        LEFT JOIN (SELECT id_cliente FROM ventas_compartidas WHERE estatus = 1) AS vc ON vc.id_cliente = cl.id_cliente
        INNER JOIN  usuarios ae ON ae.id_usuario = cl.id_asesor
        WHERE l.idStatusContratacion BETWEEN 9 AND 15 AND cl.status = 1 AND l.status = 1 AND cl.lugar_prospeccion!=6 AND si.rol_generado = 7 AND l.registro_comision in (0) and pg.id_usuario !=4415 and cl.id_asesor = si.id_usuario AND tipo_venta IS NOT NULL AND tipo_venta IN (1, 2) AND l.idLote NOT in (39813, 37064,38929,39813) AND (cl.fechaApartado >= '2020-03-01' OR l.idLote in(31907, 35863, 36603, 36603, 32575,45694,22741, 28434, 24576, 24577,35697,25218,31684,41032,34191,34141, 40635,36483,38927) )
        GROUP BY l.idLote,l.idStatusContratacion, l.registro_comision, cl.id_cliente, CONCAT(cl.nombre,' ',cl.apellido_paterno,' ',cl.apellido_materno),l.nombreLote, l.idStatusContratacion, res.nombreResidencial, cond.nombre, l.tipo_venta, l.referencia, vc.id_cliente,l.totalNeto, l.totalNeto2, l.plan_enganche, plane.nombre, cl.lugar_prospeccion, ae.id_usuario, CONCAT(ae.nombre, ' ', ae.apellido_paterno, ' ', ae.apellido_materno),si.comision_total)");
        return $query->result();
    }

    function listSedes(){
        return $this->db->query("SELECT * FROM sedes WHERE estatus = 1");
    }

    function listGerentes($sede){
        return $this->db->query("SELECT id_usuario, CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) as nombreUser FROM usuarios WHERE estatus = 1 AND id_rol = 3 AND id_sede  = $sede");
    }

    function agregar_comentarios($a, $b, $d, $e) {
        $id_user_Vl = $this->session->userdata('id_usuario');
        return $this->db->query("INSERT INTO  cobranza_mktd VALUES ($b, $a, 'NA', '".$d."', '".$e."', GETDATE(), $id_user_Vl)");
    } 

    function insert_phc($data){
        $this->db->insert_batch('historial_comisiones', $data);
        return true;
    }

    function insert_nuevo_pago($comision,$user,$monto){
        $id_user_Vl = $this->session->userdata('id_usuario');
        $respuesta = $this->db->query("INSERT INTO pago_comision_ind VALUES ($comision, $user, $monto, GETDATE(), GETDATE(), 0, 11, $id_user_Vl, 'IMPORTACIÓN EXTERNA CONTRALORÍA', NULL, NULL, NULL,'".$this->session->userdata('id_usuario')."')");
        $id = $this->db->insert_id();
        $respuesta = $this->db->query("INSERT INTO historial_comisiones VALUES ($id, 1, GETDATE(), 1, 'CONTRALORIA AGREGO UN NUEVO ABONO YA PAGADO')");

        if (! $respuesta ) {
            return false;
        } else {
            return true;
        }
    }

    public function getDirectivos(){
        $query =  $this->db->query("SELECT us.id_usuario, CONCAT(us.nombre, ' ',us.apellido_paterno, ' ',us.apellido_materno) AS nombre FROM usuarios us WHERE us.id_rol in (1,2)");
        return $query->result();
    }

    public function getDirectivos2(){
        $id_user_Vl = $this->session->userdata('id_usuario');
        $query =  $this->db->query("SELECT us.id_usuario, CONCAT(us.nombre, ' ',us.apellido_paterno, ' ',us.apellido_materno) AS nombre FROM usuarios us WHERE us.id_rol in (1,2) AND us.id_usuario = $id_user_Vl ");
        return $query->result();
    }

    public function getMktdCommissionsList() {
        $query = $this->db-> query("(SELECT DISTINCT(l.idLote), l.idStatusContratacion, l.registro_comision, cl.id_cliente, CONCAT(cl.nombre,' ',cl.apellido_paterno,' ',cl.apellido_materno) nombre_cliente, l.nombreLote, l.idStatusContratacion, res.nombreResidencial, cond.nombre as nombreCondominio, l.tipo_venta, l.referencia, vc.id_cliente AS compartida, l.totalNeto, l.totalNeto2, l.plan_enganche, plane.nombre as enganche_tipo, cl.lugar_prospeccion, ae.id_usuario as id_asesor, CONCAT(ae.nombre, ' ', ae.apellido_paterno, ' ', ae.apellido_materno) as asesor, co.id_usuario as id_coordinador, CONCAT(co.nombre, ' ', co.apellido_paterno, ' ', co.apellido_materno) as coordinador, ge.id_usuario as id_gerente, CONCAT(ge.nombre, ' ', ge.apellido_paterno, ' ', ge.apellido_materno) as gerente, su.id_usuario as id_subdirector, CONCAT(su.nombre, ' ', su.apellido_paterno, ' ', su.apellido_materno) as subdirector, di.id_usuario as id_director, CONCAT(di.nombre, ' ', di.apellido_paterno, ' ', di.apellido_materno) as director
        FROM lotes l
        INNER JOIN clientes cl ON cl.id_cliente = l.idCliente AND cl.lugar_prospeccion != 6
        INNER JOIN condominios cond ON l.idCondominio=cond.idCondominio
        INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
        LEFT JOIN pago_comision pc ON pc.id_lote = l.idLote AND pc.bandera in (0, 1, 55)
        LEFT JOIN opcs_x_cats plane ON plane.id_opcion= l.plan_enganche AND plane.id_catalogo = 39
        LEFT JOIN (SELECT id_cliente FROM ventas_compartidas WHERE estatus = 1) AS vc ON vc.id_cliente = cl.id_cliente
        INNER JOIN usuarios ae ON ae.id_usuario = cl.id_asesor
        LEFT JOIN usuarios co ON co.id_usuario = cl.id_coordinador
        LEFT JOIN usuarios ge ON ge.id_usuario = cl.id_gerente
        LEFT JOIN usuarios su ON su.id_usuario = cl.id_subdirector
        LEFT JOIN usuarios di ON di.id_usuario = su.id_lider
        WHERE l.idStatusContratacion BETWEEN 9 AND 15 AND cl.status = 1 AND l.status = 1 AND l.registro_comision in (1) AND pc.bandera in (0, 1, 55) AND tipo_venta IS NOT NULL AND tipo_venta IN (1, 2))              
        UNION
        ( SELECT DISTINCT(l.idLote), l.idStatusContratacion, l.registro_comision, cl.id_cliente, CONCAT(cl.nombre,' ',cl.apellido_paterno,' ',cl.apellido_materno) nombre_cliente, l.nombreLote, l.idStatusContratacion, res.nombreResidencial, cond.nombre as nombreCondominio, l.tipo_venta, l.referencia, vc.id_cliente AS compartida, l.totalNeto, l.totalNeto2, l.plan_enganche, plane.nombre as enganche_tipo, cl.lugar_prospeccion, ae.id_usuario as id_asesor, CONCAT(ae.nombre, ' ', ae.apellido_paterno, ' ', ae.apellido_materno) as asesor, co.id_usuario as id_coordinador, CONCAT(co.nombre, ' ', co.apellido_paterno, ' ', co.apellido_materno) as coordinador, ge.id_usuario as id_gerente, CONCAT(ge.nombre, ' ', ge.apellido_paterno, ' ', ge.apellido_materno) as gerente, su.id_usuario as id_subdirector, CONCAT(su.nombre, ' ', su.apellido_paterno, ' ', su.apellido_materno) as subdirector, di.id_usuario as id_director, CONCAT(di.nombre, ' ', di.apellido_paterno, ' ', di.apellido_materno) as director
        FROM lotes l
        INNER JOIN clientes cl ON cl.id_cliente = l.idCliente AND cl.lugar_prospeccion != 6
        INNER JOIN condominios cond ON l.idCondominio=cond.idCondominio
        INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
        LEFT JOIN pago_comision pc ON pc.id_lote = l.idLote AND pc.bandera in (0)
        LEFT JOIN opcs_x_cats plane ON plane.id_opcion= l.plan_enganche AND plane.id_catalogo = 39
        LEFT JOIN (SELECT id_cliente FROM ventas_compartidas WHERE estatus = 1) AS vc ON vc.id_cliente = cl.id_cliente
        INNER JOIN usuarios ae ON ae.id_usuario = cl.id_asesor
        LEFT JOIN usuarios co ON co.id_usuario = cl.id_coordinador
        LEFT JOIN usuarios ge ON ge.id_usuario = cl.id_gerente
        LEFT JOIN usuarios su ON su.id_usuario = cl.id_subdirector
        LEFT JOIN usuarios di ON di.id_usuario = su.id_lider
        WHERE l.idStatusContratacion BETWEEN 9 AND 15 AND cl.status = 1 AND l.status = 1 AND l.registro_comision in (0, 8) AND tipo_venta IS NOT NULL AND tipo_venta IN (1, 2) AND (cl.fechaApartado >= '2020-03-01' OR l.idLote in(31907, 35863, 36603, 36603, 32575,45694,22741, 28434, 24576, 24577,35697,25218,31684,41032,34191,34141, 40635,36483,38927, 33931, 19523, 32101, 16406, 36617, 36618, 13334, 13615) )) ORDER BY l.idLote");
        return $query->result();
    }

    public function addRecord($table, $data,$flag = '') {
        if ($data != '' && $data != null) {
            if($flag != ''){
                $response = $this->db->query("UPDATE pago_comision set bandera=0 where id_lote=".$data['id_lote'].";");
                $response = $this->db->query("UPDATE lotes set registro_comision=1 where idLote=".$data['id_lote'].";");
            }
           
            $response = $this->db->insert($table, $data);
            if (!$response) {
                return $finalAnswer = 0;
            } else {
                return $finalAnswer = 1;
            }
        } else {
            return 0;
        }
    }
    
    public function getEvidenceInformation($idLote,$idCliente){
        $query =  $this->db->query("SELECT * FROM controversias WHERE id_lote=$idLote and id_cliente=$idCliente ");
        return $query->result_array();
    }
    
    function updateControversia($idLote, $idCliente) {
        return $this->db->query("UPDATE controversias SET estatus = 0 WHERE id_lote=$idLote and id_cliente=$idCliente and estatus=1");
    }

    public function updateRecord($table, $data, $key, $value) // MJ: ACTUALIZA LA INFORMACIÓN DE UN REGISTRO EN PARTICULAR, RECIBE 4 PARÁMETROS. TABLA, DATA A ACTUALIZAR, LLAVE (WHERE) Y EL VALOR DE LA LLAVE
    {
        $response = $this->db->update($table, $data, "$key = '$value'");
        if (!$response) {
            return $finalAnswer = 0;
        } else {
            return $finalAnswer = 1;
        }
    }

    public function deleteRecord($table, $key, $value) {
        $response = $this->db->query("DELETE FROM $table WHERE $key = $value");
        if (!$response) {
            return $finalAnswer = 0;
        } else {
            return $finalAnswer = 1;
        }
    }

    public function getLoteInformation($id_lote){
        return $this->db-> query("SELECT l.idLote, l.nombre_lote, l.totalNeto2, l.idCliente,c.id_prospecto 
        FROM lotes l
        INNER JOIN clientes c ON c.id_cliente = l.idCliente AND c.status = 1
        WHERE l.idLote = $id_lote")->result_array();
    }

    public function getIndividualPaymentInformation($id_lote, $id_usuario){
        return $this->db-> query("SELECT id_comision, SUM(abono_neodata) abonado 
        FROM pago_comision_ind
        WHERE id_comision IN (SELECT id_comision 
        FROM comisiones WHERE id_lote IN ($id_lote)) AND id_usuario = $id_usuario AND estatus IN (8, 11, 13) 
        GROUP BY id_comision;")->result_array();
    }

    public function getIndividualPaymentWPInformation($id_lote, $id_usuario){
        return $this->db-> query("SELECT * FROM pago_comision_ind WHERE id_comision IN (SELECT id_comision 
        FROM comisiones 
        WHERE id_lote IN ($id_lote)) AND id_usuario = $id_usuario AND estatus NOT IN (8, 11, 13);")->result_array();
    }

    public function getComissionformation($id_lote, $id_usuario, $id_rol){
        return $this->db-> query("SELECT * 
        FROM comisiones 
        WHERE id_lote = $id_lote AND id_usuario = $id_usuario AND rol_generado = $id_rol")->result_array();
    }

    public function get_solicitudes_factura( $idResidencial, $id_usuario ){
        if( $this->session->userdata('id_rol') == 31 ){
            $filtro = "WHERE pci1.estatus IN (8,88) ";
        }
        else{
            $filtro = "WHERE pci1.estatus IN (4) ";
        }
 
        return $this->db->query("SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario ,pci1.id_usuario, oprol.nombre as puesto, cl.personalidad_juridica, u.forma_pago, 0 as factura, pac.porcentaje_abono, (CASE WHEN com.ooam = 1 THEN  CONCAT(oxcest.nombre,' (OOAM)') ELSE oxcest.nombre END) estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, cl.lugar_prospeccion, co.nombre as condominio, lo.referencia
        FROM pago_comision_ind pci1 
        INNER JOIN comisiones com ON pci1.id_comision = com.id_comision AND com.estatus in (1,8)
        INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial AND re.idResidencial = $idResidencial
        INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 1
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (2)
        INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
        INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
        INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
        $filtro AND u.id_usuario = $id_usuario
        GROUP BY pci1.id_comision,com.ooam, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex, pci1.id_usuario, cl.personalidad_juridica, u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, cl.lugar_prospeccion, co.nombre, lo.referencia ORDER BY lo.nombreLote")->result_array();
    }

    function update_estatus_edit($id_pago_i, $obs) {
        $id_user_Vl = $this->session->userdata('id_usuario');
        $this->db->query("INSERT INTO historial_comisiones VALUES ($id_pago_i, $id_user_Vl, GETDATE(), 1, 'ACTUALIZÓ CONTRALORIA CON NUEVO MONTO: ".$obs."')");
        return $this->db->query("UPDATE pago_comision_ind SET abono_neodata = '".$obs."',modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_i IN (".$id_pago_i.")");
    }

    function update_estatus_intmex($id_pago_i, $obs) {
        $id_user_Vl = $this->session->userdata('id_usuario');
        $this->db->query("INSERT INTO historial_comisiones VALUES ($id_pago_i, $id_user_Vl, GETDATE(), 1, 'ACTUALIZÓ CONTRALORIA CON NUEVO MONTO: ".$obs."')");
        return $this->db->query("UPDATE pago_comision_ind SET abono_neodata = '".$obs."',modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_i IN (".$id_pago_i.")");
    }
    
    function insertar_codigo_postal($codigo_postal, $nuevoCp){
        $id_user = $this->session->userdata('id_usuario');
        if($nuevoCp == 'true'){
            $this->db->query("INSERT INTO cp_usuarios (id_usuario, codigo_postal, estatus, fecha_creacion, fecha_modificacion, creado_por) VALUES ($id_user,$codigo_postal,1,GETDATE(),GETDATE(),$id_user)");
            echo "Código postal insertado con éxito";
        }else{
            $actualDatosCP= $this->consulta_codigo_postal($id_user)->result_array();
            $actualCP = $actualDatosCP[0]["codigo_postal"];
            $this->db->query("UPDATE cp_usuarios SET estatus = 1, codigo_postal = $codigo_postal, fecha_modificacion = GETDATE() WHERE id_usuario = $id_user");
            $this->db->query("INSERT INTO auditoria (id_parametro, tipo, anterior, nuevo, col_afect, tabla, fecha_creacion, creado_por) VALUES ($id_user,'update',$actualCP, $codigo_postal, 'codigo_postal', 'cp_usuarios', GETDATE(), ".$this->session->userdata('id_usuario').")");
            echo "Datos actualizados correctamente";
        }
    }
    
    function consulta_codigo_postal($id_user){
        return $this->db->query("SELECT estatus, codigo_postal FROM cp_usuarios WHERE id_usuario = $id_user");
    }

    function pagos_codigo_postal($id_user){
        return $this->db->query("SELECT * FROM pago_comision_ind WHERE estatus = 4 AND id_usuario = $id_user");
    }

    function update_estatus_add($id_pago_i, $obs) {
        $id_user_Vl = $this->session->userdata('id_usuario');
        $QUERY_VAL = $this->db->query("SELECT id_usuario, id_comision FROM pago_comision_ind WHERE id_pago_i IN (".$id_pago_i.")");
        $comision = $QUERY_VAL->row()->id_comision;
        $user_com = $QUERY_VAL->row()->id_usuario;
    
        return $this->db->query( "INSERT INTO pago_comision_ind VALUES (".$comision.", ".$user_com.", ".$obs.", GETDATE(), GETDATE(), 0, 11, 1, 'IMPORTACIÓN EXTEMPORANEA', NULL, NULL, NULL,'".$this->session->userdata('id_usuario')."')");
        $insert_id = $this->db->insert_id();
        $this->db->query("INSERT INTO  historial_comisiones VALUES ($insert_id, $id_user_Vl, GETDATE(), 1, 'SE AGREGA POR CONTRALORIA CON MONTO: ".$obs."')");
    }

    public function MKTD_compartida($lote,$p1,$p2,$user){
        $respuesta = $this->db->query("INSERT INTO compartidas_mktd VALUES ($lote,$p1,$p2, GETDATE(),$user)");
        if ($respuesta ) {
            return 1;
        } else {
            return 0;
        }
    }

    public function VerificarMKTD($idlote){
       return $query =  $this->db->query("SELECT * FROM comisiones co inner join pago_comision_ind pci on co.id_comision=pci.id_comision where pci.estatus != 12 and pci.id_usuario=4394 and co.id_lote=".$idlote."");
    }

    function getDatosNuevasCompartidas(){
        return $this->db->query("SELECT pci.id_usuario, lo.ubicacion_dos, plm.id_plan, s.nombre as sede, us.nombre, us.apellido_paterno, SUM(pci.abono_neodata) total, res.empresa, res.idResidencial, CAST(res.descripcion AS VARCHAR(MAX)) descripcion,cmktd.sede1, cmktd.sede2, s1.nombre as s1, s2.nombre as s2
        FROM pago_comision_ind pci 
        INNER JOIN comisiones com ON com.id_comision = pci.id_comision
        INNER JOIN lotes lo ON lo.idLote = com.id_lote
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio
        INNER JOIN residenciales res ON res.idResidencial = con.idResidencial
        INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente
        INNER JOIN planes_mktd plm ON plm.fecha_plan <= cl.fechaApartado AND plm.fin_plan >= cl.fechaApartado
        INNER JOIN sedes s ON s.id_sede = lo.ubicacion_dos
        INNER JOIN usuarios us ON us.id_usuario = pci.id_usuario
        INNER JOIN compartidas_mktd cmktd on com.id_lote=cmktd.id_lote
        INNER JOIN sedes s1 on s1.id_sede=cmktd.sede1 
        INNER JOIN sedes s2 on s2.id_sede=cmktd.sede2
        WHERE pci.estatus IN (1, 41, 42, 51, 52, 61, 62, 12) AND lo.idLote IN (select id_lote from reportes_marketing WHERE estatus = 1 AND dispersion = 1) AND pci.id_usuario = 4394 AND lo.status = 1 AND cl.status = 1 AND cl.id_asesor IN (SELECT id_usuario FROM usuarios WHERE id_sede IN (1,2,3,4,5,6) AND id_rol IN (7,9))
        GROUP BY plm.id_plan, res.empresa, pci.id_usuario, lo.ubicacion_dos, s.nombre, us.nombre, us.apellido_paterno, res.idResidencial, CAST(res.descripcion AS VARCHAR(MAX)), cmktd.sede1, cmktd.sede2, s1.nombre, s2.nombre
        ORDER by plm.id_plan");
    }

    function getRetiros($user,$opc){
       $query = '';
        if($opc == 2){
            $query = 'AND rc.estatus in(67)';
        }
        return $this->db->query("SELECT rc.id_rc,CONCAT(us.nombre,' ',us.apellido_paterno,' ',us.apellido_materno) AS usuario,rc.monto,rc.conceptos,rc.fecha_creacion,rc.estatus,CONCAT(u2.nombre,' ',u2.apellido_paterno,' ',u2.apellido_materno) AS creado_por,rc.estatus from usuarios us inner join resguardo_conceptos rc on rc.id_usuario=us.id_usuario inner join usuarios u2 on u2.id_usuario=rc.creado_por where rc.id_usuario=$user $query");
    }

    function insertar_retiro($usuarioid,$monto,$comentario,$usuario,$opc){
        $estatus = 1;
        $adicional = 'SE INGRESÓ RETIRO ';
        if($opc == 2){
            $adicional = 'SE AGREGÓ UN INGRESO EXTRA ';
            $estatus = 67;
        }

        $respuesta = $this->db->query("INSERT INTO resguardo_conceptos VALUES ($usuarioid, $monto,'$comentario', $usuario,$estatus, GETDATE())");
        $insert_id_2 = $this->db->insert_id();
        $respuesta = $this->db->query("INSERT INTO  historial_retiros VALUES ($insert_id_2, ".$this->session->userdata('id_usuario').", GETDATE(), 1, '$adicional POR MOTIVO DE: $comentario POR LA CANTIDAD DE: $monto')");

        if (! $respuesta ) {
            return 0;
        } else {
            return 1;
        }
    }

    function getHistoriRetiros($id) {
        $query = $this->db->query("SELECT r.*,CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario  from historial_retiros r inner join usuarios u on u.id_usuario=r.id_usuario where id_retiro=$id");
        return $query;
    }

    function getPrecioMKTD($lote) {
        $query = $this->db->query("select * from reportes_marketing where id_lote=$lote");
        return $query;
    }

    public function insert_MKTD_precioL($lote,$precio,$user){
        $respuesta = $this->db->query("INSERT INTO reportes_marketing VALUES ($lote,$precio,0,1,$user,GETDATE())");
        if ($respuesta ) {
            return 1;
        } else {
            return 0;
        }
    }

    public function Update_MKTD_precioL($lote,$precio,$user){
        $respuesta = $this->db->query("UPDATE reportes_marketing SET precio=".$precio.",creado_por=$user,fecha_creacion=GETDATE() WHERE id_lote=".$lote."");
        if ($respuesta ) {
            return 1;
        } else {
            return 0;
        }
    }

    function getDatosColabMktdCompartida($sede, $PLAN,$sede1,$sede2){
        if($PLAN == '9'|| $PLAN == 9 ){
            $filtro_009 = " SELECT pk.id_plan, pk.fecha_plan, getdate() as fin_plan, u.id_usuario, CONCAT(u.nombre,' ' ,u.apellido_paterno,' ',u.apellido_materno) AS colaborador, op1.nombre AS rol, pcm.porcentaje, u.id_sede, op1.id_opcion, (CASE op1.id_opcion WHEN '18' THEN 1 WHEN '10' THEN 2 WHEN '19' THEN 3 WHEN '37' THEN 4 WHEN '25 ' THEN 5 WHEN '29' THEN 6 WHEN '30' THEN 7 WHEN '20' THEN 8  ELSE op1.id_opcion END) as rol_dos,'0' as valor
                FROM planes_mktd pk 
                INNER JOIN porcentajes_mktd pcm ON pcm.numero_plan = pk.id_plan 
                INNER JOIN usuarios u ON u.id_usuario = pcm.id_usuario 
                INNER JOIN opcs_x_cats op1 ON op1.id_opcion = pcm.rol 
                WHERE op1.id_catalogo = 1 AND pcm.rol NOT IN (19, 20, 28)  ";
        } else{
            $filtro_009 = " SELECT pk.id_plan, pk.fecha_plan, getdate() as fin_plan, u.id_usuario, CONCAT(u.nombre,' ' ,u.apellido_paterno,' ',u.apellido_materno) AS colaborador, op1.nombre AS rol, pcm.porcentaje, u.id_sede, op1.id_opcion, (CASE op1.id_opcion WHEN '18' THEN 1 WHEN '10' THEN 2 WHEN '19' THEN 3 WHEN '37' THEN 4 WHEN '25 ' THEN 5 WHEN '29' THEN 6 WHEN '30' THEN 7 WHEN '20' THEN 8 WHEN '28' THEN 9 ELSE op1.id_opcion END) as rol_dos,'0' as valor
            FROM planes_mktd pk 
            INNER JOIN porcentajes_mktd pcm ON pcm.numero_plan = pk.id_plan 
            INNER JOIN usuarios u ON u.id_usuario = pcm.id_usuario 
            INNER JOIN opcs_x_cats op1 ON op1.id_opcion = pcm.rol 
            WHERE op1.id_catalogo = 1 AND pcm.rol NOT IN (19, 20) AND pk.id_plan = $PLAN) ";
        }

        if($PLAN == '7'||$PLAN == 7 ){
            $filtro_003 = " ((pcm.rol IN (19) AND (u.id_sede LIKE '%$sede1%' OR u.id_sede LIKE '%$sede2%') ) OR (pcm.id_usuario = 1981 AND id_plaza = 2))  ";
        }
        else{
            $filtro_003 = " pcm.rol IN (19) AND (u.id_sede LIKE '%$sede1%' OR u.id_sede LIKE '%$sede2%')  ";
        }

        return $this->db->query("( $filtro_009
            UNION 
            (SELECT pk.id_plan, pk.fecha_plan, getdate() as fin_plan, u.id_usuario, CONCAT(u.nombre,' ' ,u.apellido_paterno,' ',u.apellido_materno) AS colaborador, op1.nombre AS rol, pcm.porcentaje, u.id_sede, op1.id_opcion, (CASE op1.id_opcion WHEN '18' THEN 1 WHEN '19' THEN 2 WHEN '20 ' THEN 3 WHEN '25' THEN 4 ELSE op1.id_opcion END) as rol_dos,'0' as valor 
            FROM planes_mktd pk 
            INNER JOIN porcentajes_mktd pcm ON pcm.numero_plan = pk.id_plan 
            INNER JOIN usuarios u ON u.id_usuario = pcm.id_usuario 
            INNER JOIN opcs_x_cats op1 ON op1.id_opcion = pcm.rol
            WHERE op1.id_catalogo = 1 AND pcm.rol IN (20) AND pcm.id_sede IN ($sede1,$sede2) AND pk.id_plan = $PLAN) 

            UNION 

            (SELECT pk.id_plan, pk.fecha_plan, getdate() as fin_plan, u.id_usuario, CONCAT(u.nombre,' ' ,u.apellido_paterno,' ',u.apellido_materno) AS colaborador, op1.nombre AS rol, pcm.porcentaje, u.id_sede, op1.id_opcion, (CASE op1.id_opcion WHEN '18' THEN 1 WHEN '19' THEN 2 WHEN '20 ' THEN 3 WHEN '25' THEN 4 ELSE op1.id_opcion END) as rol_dos,'0' as valor 
            FROM planes_mktd pk 
            INNER JOIN porcentajes_mktd pcm ON pcm.numero_plan = pk.id_plan 
            INNER JOIN usuarios u ON u.id_usuario = pcm.id_usuario 
            INNER JOIN opcs_x_cats op1 ON op1.id_opcion = pcm.rol 
            WHERE op1.id_catalogo = 1 AND  $filtro_003 and pk.id_plan = $PLAN) order by rol_dos");
    }

    function get_lote_lista($condominio){
        return $this->db->query("SELECT * FROM lotes WHERE status = 1 and statuscontratacion BETWEEN 9 AND 15 and regristro_comision=0  AND idCondominio = ".$condominio." AND idCliente in (SELECT idCliente FROM clientes) AND (idCliente <> 0 AND idCliente <>'') ");
    }

    public function Update_lote_reubicacion($idloteNuevo,$idloteAnterior,$precioNuevo,$user,$comentario)
    {
        $respuesta = $this->db->query("UPDATE comisiones set comision_total=((porcentaje_decimal/100)*$precioNuevo),id_lote=$idloteNuevo,modificado_por='".$this->session->userdata('id_usuario')."'  where id_lote=$idloteAnterior");
        $respuesta = $this->db->query("UPDATE lotes set registro_comision=0  where idLote=$idloteAnterior");
        $respuesta = $this->db->query("UPDATE lotes set registro_comision=1  where idLote=$idloteNuevo");

        if ($respuesta ) {
        $respuesta = $this->db->query("UPDATE pago_comision set id_lote=$idloteNuevo  where id_lote=$idloteAnterior");
        $query = $this->db->query("select id_pago_i  from pago_comision_ind where id_comision in(select id_comision from comisiones where id_lote=$idloteNuevo)")->result_array();
        if($respuesta){
            for ($i=0; $i <count($query); $i++) { 
                $this->db->query("INSERT INTO  historial_comisiones VALUES (".$query[$i]['id_pago_i'].",$user, GETDATE(), 1,'$comentario')");
            }
            return 1;
        }else{}
        } else {
            return 0;
        }   
    }

    function getComisionesLoteSelected($idLote){
        return $this->db->query("SELECT * FROM comisiones WHERE id_lote=$idLote");
    }

    function getBonosPorUser($id,$estado){
        $cadena = 'p.id_usuario='.$id.' AND';
        if($this->session->userdata('id_rol') == 32){
            $cadena = 'u.estatus in(0,3) AND';
        }
        return $this->db->query("SELECT CONCAT(u.nombre, ' ', u.apellido_paterno, ' ' ,u.apellido_materno) as nombre, UPPER(opcs.nombre) AS id_rol, p.id_bono, p.id_usuario, p.monto, p.num_pagos, p.pago, p.estatus, p.comentario, CONVERT(VARCHAR, b.fecha_abono,20) AS fecha_abono, b.estado, b.id_pago_bono, b.abono, b.n_p, (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*p.pago) ELSE p.pago END) impuesto1, sed.impuesto
        FROM bonos p INNER JOIN usuarios u ON u.id_usuario=p.id_usuario 
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = u.forma_pago AND oxc.id_catalogo = 16
        LEFT JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario 
        WHEN 2 THEN 2 
        WHEN 3 THEN 2 
        WHEN 1980 THEN 2 
        WHEN 1981 THEN 2 
        WHEN 1982 THEN 2 
        WHEN 1988 THEN 2 
        WHEN 4 THEN 5
        WHEN 5 THEN 3
        WHEN 607 THEN 1 
        WHEN 7092 THEN 4
        WHEN 9629 THEN 2
        ELSE u.id_sede END) and sed.estatus = 1
        INNER JOIN pagos_bonos_ind b on b.id_bono = p.id_bono
        inner join opcs_x_cats opcs on opcs.id_opcion = u.id_rol 
        WHERE $cadena b.estado = $estado and opcs.id_catalogo = 1");
    }

    function getDatosNuevo(){
        return $this->db->query("SELECT u.id_usuario, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) usuario, u.id_rol, u.id_sede, rol.nombre as puesto
        FROM usuarios u INNER JOIN opcs_x_cats rol ON rol.id_opcion = u.id_rol WHERE(u.id_lider in (SELECT us.id_usuario FROM usuarios us WHERE us.id_rol IN (18,19)) OR u.id_usuario IN (1980)) AND rol.id_catalogo = 1 
        ORDER BY u.id_rol");
    }

    function getPlazasMk(){
        return $this->db->query("SELECT id_opcion, nombre FROM opcs_x_cats WHERE id_catalogo = 36");
    } 

    function getSedeMk(){
        return $this->db->query("SELECT id_sede, nombre FROM sedes WHERE estatus = 1");
    } 

    function getMontoDispersado(){
        return $this->db->query("SELECT SUM(abono_neodata) monto FROM pago_comision_ind WHERE id_comision IN (select id_comision from comisiones) AND MONTH(GETDATE()) = MONTH(fecha_abono) AND Day(GetDate()) = Day(fecha_abono)");
    }

    function getPagosDispersado(){
        return $this->db->query("SELECT count(id_pago_i) pagos FROM pago_comision_ind WHERE id_comision IN (select id_comision from comisiones) AND MONTH(GETDATE()) = MONTH(fecha_abono) AND Day(GetDate()) = Day(fecha_abono) AND abono_neodata>0");
    }

    function getLotesDispersado(){
        return $this->db->query("SELECT count(distinct(id_lote)) lotes FROM comisiones WHERE id_comision IN (select id_comision from pago_comision_ind WHERE MONTH(GETDATE()) = MONTH(fecha_abono) AND Day(GetDate()) = Day(fecha_abono) AND id_comision IN (SELECT id_comision FROM comisiones))");
    }
 
    function getMontoDispersadoDates($fecha1, $fecha2){
        return $this->db->query("SELECT SUM(lotes) as lotes, SUM(comisiones) as comisiones, SUM(pagos) as pagos, SUM(monto) monto
        FROM (
        SELECT COUNT(DISTINCT(id_lote)) lotes , 
        COUNT(c.id_comision) comisiones, 
        COUNT(pci.id_pago_i) pagos, 
        SUM(pci.abono_neodata) monto
        FROM pago_comision_ind pci 
        INNER JOIN comisiones c on c.id_comision = pci.id_comision
        INNER JOIN usuarios u ON u.id_usuario = pci.creado_por AND u.id_rol IN (32,13,17) 
        WHERE CAST(pci.fecha_abono as date) >= CAST('$fecha1' AS date)
        AND CAST(pci.fecha_abono as date) <= CAST('$fecha2' AS date) 
        AND pci.estatus NOT IN (0) 
        GROUP BY u.id_usuario) as lotes ; ");
    }

    function getPagosDispersadoDates($fecha1, $fecha2){
        return $this->db->query("SELECT count(id_pago_i) pagos FROM pago_comision_ind WHERE estatus NOT IN (11,0) AND id_comision IN (select id_comision from comisiones) AND CAST(fecha_abono as date) >= CAST('$fecha1' AS date) AND CAST(fecha_abono as date) <= CAST('$fecha2' AS date) AND abono_neodata>0");
    }

    function getLotesDispersadoDates($fecha1, $fecha2){
        return $this->db->query("SELECT count(distinct(id_lote)) lotes FROM comisiones WHERE id_comision IN (select id_comision from pago_comision_ind WHERE CAST(fecha_abono as date) >= CAST('$fecha1' AS date) AND CAST(fecha_abono as date) <= CAST('$fecha2' AS date) AND estatus NOT IN (11,0) AND id_comision IN (SELECT id_comision FROM comisiones))");
    }

    function get_proyectos_comisiones($filtro_post){
        return $this->db->query("SELECT DISTINCT(res.idResidencial), CAST(res.descripcion AS VARCHAR(MAX)) AS descripcion FROM residenciales res WHERE res.status = 1 AND res.active_comission = 1 ORDER BY res.idResidencial");
    }

    public function get_condominios_comisiones($filtro_post){
        return $this->db->query("SELECT DISTINCT(con.idCondominio), CAST(con.nombre AS VARCHAR(MAX)) AS nombre FROM condominios con
        INNER JOIN lotes lot ON lot.idCondominio = con.idCondominio
        INNER JOIN comisiones com ON com.id_lote = lot.idLote
        INNER JOIN pago_comision_ind pci ON pci.id_comision = com.id_comision $filtro_post ORDER BY CAST(con.nombre AS VARCHAR(MAX))");
    }
    
    public function get_lista_roles() {
        return $this->db->query("SELECT id_opcion, nombre, id_catalogo FROM opcs_x_cats WHERE id_catalogo IN (1) and id_opcion IN (3, 9, 7, 2) ORDER BY id_opcion");
    }

    public function get_lista_sedes(){
        return $this->db->query("SELECT id_sede AS idResidencial, nombre AS descripcion FROM sedes ORDER BY nombre");
    }

    public  function get_lista_usuarios($rol, $forma_pago){
        return $this->db->query("SELECT id_usuario AS idCondominio, CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) AS nombre FROM usuarios WHERE id_usuario in (SELECT id_usuario FROM pago_comision_ind WHERE estatus in (8,88)) AND id_rol = $rol AND forma_pago = $forma_pago ORDER BY nombre");
    }

    public function getCommisionInformation($id_lote){
        return $this->db-> query("SELECT * FROM comisiones WHERE id_lote IN ($id_lote) and estatus=1")->result_array();
    }

    public function getCompanyCommissionEntryEmpMktd($id_lote){
        return $this->db-> query("SELECT * FROM comisiones WHERE id_lote = $id_lote AND (id_usuario = 4824 or id_usuario=4394) and estatus=1")->result_array();
    }
    
    function getDatosHistorialPagado($anio,$mes){

        if($mes == 0){
            $filtro = '  AND YEAR(pci1.aply_pago_intmex) = '.$anio.' ';
        }else{
            $filtro = '  AND MONTH(pci1.aply_pago_intmex) = '.$mes.' AND YEAR(pci1.aply_pago_intmex) = '.$anio.'';
        }
        
        return $this->db-> query("(SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote, re.nombreResidencial as proyecto, co.nombre as condominio,lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, pci1.estatus, pci1.fecha_abono fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) user_names, pci1.id_usuario, oprol.nombre as puesto, u.forma_pago, 0 as factura, pac.porcentaje_abono, (CASE WHEN com.ooam = 1 THEN  CONCAT(oxcest.nombre,' (OOAM)') ELSE oxcest.nombre END) estatus_actual, oxcest.id_opcion id_estatus_actual, pci1.descuento_aplicado, 0 lugar_prospeccion, com.estatus estado_comision, pac.bonificacion, u.estatus as activo, pci1.fecha_pago_intmex, pci1.aply_pago_intmex, 0 fechaApartado, 'NA' plaza, lo.idLote
        FROM pago_comision_ind pci1 
        LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE (estatus in (11,3) OR descuento_aplicado = 1) GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
        INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
        INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
        INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
        INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
        INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23
        WHERE pci1.estatus = 11 AND pci1.id_usuario = 4394 $filtro AND ( (lo.idStatusContratacion < 9 AND com.estatus IN (1,8)) OR (lo.idStatusContratacion > 8 AND com.estatus IN (8))) 
        GROUP BY pci1.id_comision,com.oooam, lo.nombreLote, re.nombreResidencial, co.nombre, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, pci1.descuento_aplicado, com.estatus, pac.bonificacion, u.estatus, pci1.fecha_pago_intmex, pci1.aply_pago_intmex, lo.idLote)
        UNION 
        (SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote, re.nombreResidencial as proyecto, co.nombre as condominio,lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, pci1.estatus, pci1.fecha_abono fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) user_names ,pci1.id_usuario, oprol.nombre as puesto, u.forma_pago, 0 as factura, pac.porcentaje_abono, (CASE WHEN com.ooam = 1 THEN  CONCAT(oxcest.nombre,' (OOAM)') ELSE oxcest.nombre END) estatus_actual, oxcest.id_opcion id_estatus_actual, pci1.descuento_aplicado, cl.lugar_prospeccion,com.estatus estado_comision, pac.bonificacion, u.estatus as activo, pci1.fecha_pago_intmex, pci1.aply_pago_intmex, cl.fechaApartado, CAST(se.nombre AS VARCHAR(MAX)) plaza, lo.idLote
        FROM pago_comision_ind pci1 
        LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE (estatus in (11,3) OR descuento_aplicado = 1) GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
        INNER JOIN comisiones com ON pci1.id_comision = com.id_comision AND com.estatus in (1)
        INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial 
        INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 1
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
        INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
        INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
        INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23
        LEFT JOIN usuarios as asesor ON asesor.id_usuario = cl.id_asesor
        LEFT JOIN sedes se ON se.id_sede = asesor.id_sede and asesor.id_sede like cast(asesor.id_sede as varchar(max))
        WHERE pci1.estatus = 11 AND pci1.id_usuario = 4394 $filtro AND lo.idStatusContratacion > 8 
        GROUP BY pci1.id_comision,com.ooam, lo.nombreLote, re.nombreResidencial, co.nombre, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, pci1.descuento_aplicado, cl.lugar_prospeccion, com.estatus, pac.bonificacion, u.estatus, pci1.fecha_pago_intmex, pci1.aply_pago_intmex, cl.fechaApartado, se.nombre , lo.idLote) ORDER BY lo.nombreLote"); 
    }

    function getDatosHistorialDU($anio, $mes) {
        if($mes == 0)
            $filtro = '  AND YEAR(pci1.fecha_pago_intmex) = '.$anio.' ';
        else
             $filtro = '  AND MONTH(pci1.fecha_pago_intmex) = '.$mes.' AND YEAR(pci1.fecha_pago_intmex) = '.$anio.'';
        
        return $this->db-> query("(SELECT pci1.id_pago_i, lo.nombreLote, re.empresa, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) user_names, CONVERT(VARCHAR,pci1.fecha_pago_intmex,20) AS fecha_pago_intmex, pci1.id_usuario, CASE WHEN cl.estructura = 1 THEN oprol2.nombre ELSE oprol.nombre END as puesto, pci1.abono_neodata, UPPER(se.nombre) AS sede, pci1.abono_neodata, CONCAT(cr.nombre, ' ',cr.apellido_paterno, ' ', cr.apellido_materno) creado
        FROM pago_comision_ind pci1
        INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
        INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
        INNER JOIN usuarios cr ON cr.id_usuario = pci1.modificado_por
        INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
        LEFT JOIN sedes se   
        ON se.id_sede = (CASE u.id_usuario 
        WHEN 2 THEN 2 
        WHEN 3 THEN 2 
        WHEN 1980 THEN 2 
        WHEN 1981 THEN 2 
        WHEN 1982 THEN 2 
        WHEN 1988 THEN 2 
        WHEN 4 THEN 5
        WHEN 5 THEN 3
        WHEN 607 THEN 1 
        WHEN 7092 THEN 4
        WHEN 9629 THEN 2
        ELSE u.id_sede END) and se.estatus = 1
        LEFT JOIN clientes cl ON cl.id_cliente = com.idCliente
        LEFT JOIN opcs_x_cats oprol2 ON oprol2.id_opcion = com.rol_generado AND oprol2.id_catalogo = 83
        WHERE pci1.estatus = 17 $filtro AND ((lo.idStatusContratacion < 9 AND com.estatus IN (1,8)) OR (lo.idStatusContratacion > 8 AND com.estatus IN (8))) 
        GROUP BY pci1.id_pago_i, lo.nombreLote, re.empresa, u.nombre, u.apellido_paterno, u.apellido_materno, pci1.id_usuario, oprol.nombre, pci1.abono_neodata, se.nombre, pci1.abono_neodata, cr.nombre, cr.apellido_paterno, cr.apellido_materno, pci1.fecha_pago_intmex, cl.estructura, oprol2.nombre)
        UNION 
        (SELECT pci1.id_pago_i, lo.nombreLote, re.empresa, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) user_names, CONVERT(VARCHAR,pci1.fecha_pago_intmex,20) AS fecha_pago_intmex,pci1.id_usuario, UPPER(CASE WHEN cl.estructura = 1 THEN oprol2.nombre ELSE oprol.nombre END) as puesto, pci1.abono_neodata, UPPER(se.nombre) AS sede, pci1.abono_neodata, UPPER(CONCAT(cr.nombre, ' ',cr.apellido_paterno, ' ', cr.apellido_materno)) AS creado
        FROM pago_comision_ind pci1 
        INNER JOIN comisiones com ON pci1.id_comision = com.id_comision AND com.estatus in (1)
        INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial 
        INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 1
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
        INNER JOIN usuarios cr ON cr.id_usuario = pci1.modificado_por
        INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
        LEFT JOIN sedes se   
        ON se.id_sede = (CASE u.id_usuario 
        WHEN 2 THEN 2 
        WHEN 3 THEN 2 
        WHEN 1980 THEN 2 
        WHEN 1981 THEN 2 
        WHEN 1982 THEN 2 
        WHEN 1988 THEN 2 
        WHEN 4 THEN 5
        WHEN 5 THEN 3
        WHEN 607 THEN 1 
        WHEN 7092 THEN 4
        WHEN 9629 THEN 2
        ELSE u.id_sede END) and se.estatus = 1
        LEFT JOIN opcs_x_cats oprol2 ON oprol2.id_opcion = com.rol_generado AND oprol2.id_catalogo = 83
        WHERE pci1.estatus = 17 $filtro AND lo.idStatusContratacion > 8 
        GROUP BY pci1.id_pago_i, lo.nombreLote, re.empresa, u.nombre, u.apellido_paterno, u.apellido_materno, pci1.id_usuario, oprol.nombre, pci1.abono_neodata, se.nombre, pci1.abono_neodata, cr.nombre, cr.apellido_paterno, cr.apellido_materno, pci1.fecha_pago_intmex, cl.estructura, oprol2.nombre)");
    }
     

    function RegresarFactura($uuid,$motivo){
        $datos =  $this->db->query("select id_factura,total,id_comision from facturas where uuid='$uuid'")->result_array();
        for ($i=0; $i <count($datos); $i++) { 
            $comentario = 'Se regresó esta factura que correspondo al pago con id '.$datos[$i]['id_comision'].' con el monto global de '.$datos[$i]['total'].' por motivo de: '.$motivo.' ';
            $respuesta = $this->db->query("UPDATE facturas set total=0,id_comision=0,bandera=2,descripcion='$comentario' where id_factura=".$datos[$i]['id_factura']."");
            $respuesta = $this->db->query("INSERT INTO  historial_comisiones VALUES (".$datos[$i]['id_comision'].", ".$this->session->userdata('id_usuario').", GETDATE(), 1, '".$comentario."')");
        }
        return $respuesta;
    } 

    public function BanderaPDF($uuid)
    {
        $respuesta = $this->db->query("UPDATE facturas set bandera=3 where uuid='".$uuid."'");
        if ($respuesta ) {
            return 1;
        } else {
            return 0;
        }
    }


    function update_estatus_pausaM($id_pago_i, $obs) {
        $id_user_Vl = $this->session->userdata('id_usuario');
        $this->db->query("INSERT INTO  historial_comisiones VALUES ($id_pago_i, $id_user_Vl, GETDATE(), 1, 'SE PAUSÓ COMISIÓN, MOTIVO: ".$obs."')");
        $respuesta =  $this->db->query("UPDATE pago_comision_ind SET estatus = 6, comentario = '".$obs."',modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_i IN (".$id_pago_i.")");
        $row = $this->db->query("SELECT uuid FROM facturas WHERE id_comision = ".$id_pago_i.";")->result_array();
        if(count($row) > 0){
            $datos =  $this->db->query("select id_factura,total,id_comision,bandera from facturas where uuid='".$row[0]['uuid']."'")->result_array();
   
        for ($i=0; $i <count($datos); $i++) {
            if($datos[$i]['bandera'] == 1){
                $respuesta = 1;
            }else{
                $comentario = 'Se regresó esta factura que correspondo al pago con id '.$datos[$i]['id_comision'].' con el monto global de '.$datos[$i]['total'].' por motivo de: '.$obs.' ';
                $respuesta = $this->db->query("UPDATE facturas set total=0,id_comision=0,bandera=1,descripcion='$comentario'  where id_factura=".$datos[$i]['id_factura']."");
                $respuesta = $this->db->query("INSERT INTO  historial_comisiones VALUES (".$datos[$i]['id_comision'].", ".$this->session->userdata('id_usuario').", GETDATE(), 1, '".$comentario."')");
            }
        }}
        return $respuesta;
    }
  
    function GetPagosFacturas($uuid){
        return $this->db->query("SELECT id_comision,id_factura FROM facturas where uuid='".$uuid."'");
    } 

    function update_refactura( $id_comision, $datos_factura,$id_usuario,$id_factura){
        $VALOR_TEXT = $datos_factura['textoxml'];
        $data = array(
            "fecha_factura"  => $datos_factura['fecha'],
            "folio_factura"  => $datos_factura['folio'],
            "descripcion" => $datos_factura['descripcion'],
            "subtotal" => $datos_factura['subTotal'],
            "total"  => $datos_factura['total'],
            "metodo_pago"  => $datos_factura['metodoPago'],
            "uuid" => $datos_factura['uuidV'],
            "nombre_archivo" => $datos_factura['nombre_xml'],
            "id_usuario" => $id_usuario,
            "id_comision" => $id_comision,
            "regimen" => $datos_factura['regimenFiscal'],
            "forma_pago" => $datos_factura['formaPago'],
            "cfdi" => $datos_factura['usocfdi'],
            "unidad" => $datos_factura['claveUnidad'],
            "claveProd" => $datos_factura['claveProdServ'],
            "bandera" => 2);
            $this->db->update("facturas", $data, " id_comision = $id_comision");
            return $this->db->query("INSERT INTO xmldatos VALUES (".$id_factura.", '".$VALOR_TEXT."', GETDATE())");
    }
 
    function getPuestosDescuentos(){
        return $this->db->query("SELECT id_opcion, nombre FROM opcs_x_cats WHERE id_catalogo = 1 AND id_opcion in (3,7,9)");
    }

    public function getCompanyCommissionEntry($id_lote, $id_usuario){
        return $this->db-> query("SELECT * FROM comisiones WHERE id_lote = $id_lote AND id_usuario = $id_usuario")->result_array();
    }

    function listEmpresa(){
        return $this->db->query("SELECT DISTINCT(empresa) nombreUser FROM residenciales WHERE empresa != ''");
    }

    function listRegimen(){
        return $this->db->query("SELECT id_opcion, nombre as descripcion FROM opcs_x_cats WHERE id_catalogo = 16 AND id_opcion not in (1)");
    }

    function getDatosSaldosIntmex($empresa,$regimen){ 
        $filtro_Intmex = '';

        if(($empresa == null || $empresa == 'null') && $regimen != 0 && $regimen != 'null'){//0 1
            $filtro_Intmex = " WHERE pci1.estatus = 8 AND pci1.id_usuario in (SELECT id_usuario FROM usuarios WHERE forma_pago = $regimen) ";
        }else if($empresa != null && $empresa != 'null' && ($regimen == 0 || $regimen == 'null')){//1 0
            $filtro_Intmex = " WHERE pci1.estatus = 8 AND  re.empresa = '".$empresa."' ";
        }else if($empresa != null && $empresa != 'null' && $regimen != 0 && $regimen != 'null'){//1 0
             $filtro_Intmex = " WHERE pci1.estatus = 8 AND re.empresa = '".$empresa."' AND pci1.id_usuario in (SELECT id_usuario FROM usuarios WHERE forma_pago = $regimen) ";
        }else{
            $filtro_Intmex = " WHERE pci1.estatus = 8 ";
        }

        return $this->db->query("SELECT re.idResidencial, CAST(re.descripcion AS VARCHAR(MAX)) as proyecto, re.empresa, SUM(pci1.abono_neodata) AS dispersado, opc.nombre
        FROM pago_comision_ind pci1 
        INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
        INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        LEFT JOIN opcs_x_cats opc ON opc.id_opcion = ".$regimen." AND opc.id_catalogo = 16 ".$filtro_Intmex."
        GROUP BY re.idResidencial, CAST(re.descripcion AS VARCHAR(MAX)), re.empresa, opc.nombre ORDER by re.idResidencial ");
    }
    
    public function getPagosByComision($id_comision){
        $datos =  $this->db-> query("SELECT pci.id_pago_i,pci.abono_neodata,CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario,cat.nombre,pci.comentario
        FROM pago_comision_ind pci INNER JOIN usuarios u ON u.id_usuario=pci.id_usuario 
        INNER JOIN opcs_x_cats cat ON cat.id_opcion=pci.estatus
        WHERE pci.id_comision=$id_comision AND pci.estatus in(1,6) AND cat.id_catalogo=23")->result_array();
        return $datos;
    }
    
    public function ToparComision($id_comision,$comentario=''){  
        date_default_timezone_set('America/Mexico_City');
        $hoy = date('Y-m-d H:i:s');     
        $complemento = '';
        if($comentario != ''){
            $complemento = ",observaciones='".$comentario."'";
        }
        $sumaxcomision=0;
        $pagos = $this->db->query("SELECT pci.id_usuario,pci.id_pago_i,pci.abono_neodata,CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario,cat.nombre,pci.comentario
        FROM pago_comision_ind pci INNER JOIN usuarios u ON u.id_usuario=pci.id_usuario 
        INNER JOIN opcs_x_cats cat ON cat.id_opcion=pci.estatus
        WHERE pci.id_comision=$id_comision AND pci.estatus in(1,6) AND cat.id_catalogo=23")->result_array();
        $pagos_ind = $this->db->query("select SUM(abono_neodata) as suma from pago_comision_ind where id_comision=".$id_comision." and estatus not in(1,6,5)")->result_array();
        $sumaxcomision = $pagos_ind[0]['suma'];
        
        for ($j=0; $j <count($pagos) ; $j++) { 
            $comentario= 'Se eliminó el pago';
            $pagos =  $this->db->query("UPDATE pago_comision_ind SET estatus=0,abono_neodata=0,modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_i=".$pagos[$j]['id_pago_i']." AND id_usuario=".$pagos[$j]['id_usuario'].";");
            $pagos = $this->db->query("INSERT INTO  historial_comisiones VALUES (".$pagos[$j]['id_pago_i'].", ".$this->session->userdata('id_usuario').", GETDATE(), 1, '".$comentario."')");
        }
            $pagos = $this->db->query("INSERT INTO  historial_log VALUES ($id_comision,".$this->session->userdata('id_usuario').",'".$hoy."',1,'SE TOPO COMISIÓN','comisiones',NULL)");

            if($sumaxcomision == 0  || $sumaxcomision == null || $sumaxcomision == 'null' ){
                $this->db->query("UPDATE comisiones set comision_total=0,descuento=1,modificado_por='".$this->session->userdata('id_usuario')."' $complemento where id_comision=".$id_comision." ");
            }else{
                $this->db->query("UPDATE comisiones set comision_total=$sumaxcomision,descuento=1,modificado_por='".$this->session->userdata('id_usuario')."' $complemento where id_comision=".$id_comision." ");

            }
            return $pagos;
    }
    
    public function SaveAjuste($id_comision,$id_lote,$id_usuario,$porcentaje,$porcentaje_ant,$comision_total,$opc = ''){
        date_default_timezone_set('America/Mexico_City');
        $hoy = date('Y-m-d H:i:s');  
        $q = '';
        if($opc != ''){
            $q=',descuento=0';
        }
        $respuesta =  $this->db->query("UPDATE comisiones set comision_total=$comision_total,observaciones='SE MODIFICÓ PORCENTAJE',creado_por=".$this->session->userdata('id_usuario').",porcentaje_decimal=$porcentaje $q WHERE id_comision=$id_comision AND id_lote=$id_lote and id_usuario=$id_usuario");

        if($opc == ''){
            $Abonado = $this->db-> query("SELECT SUM(pci.abono_neodata) abonado FROM pago_comision_ind pci WHERE pci.id_comision IN  ($id_comision)")->result_array();
            $pagos = $this->db-> query("SELECT * FROM pago_comision_ind WHERE id_comision=$id_comision and estatus in(1,6) and id_usuario=$id_usuario;")->result_array();

            if($porcentaje <= $porcentaje_ant ){
                for ($i=0; $i <count($pagos) ; $i++) { 
                    $comentario2='Se cancelo el pago por cambio de porcentaje';
                    $respuesta =  $this->db->query("UPDATE pago_comision_ind SET abono_neodata=0,estatus=0,modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_i=".$pagos[$i]['id_pago_i']." AND id_usuario=".$id_usuario.";");
                    $respuesta = $this->db->query("INSERT INTO  historial_comisiones VALUES (".$pagos[$i]['id_pago_i'].", ".$this->session->userdata('id_usuario').", GETDATE(), 1, '".$comentario2."')");
                }  
            }
        }
        $respuesta = $this->db->query("INSERT INTO  historial_log VALUES ($id_comision,".$this->session->userdata('id_usuario').",'".$hoy."',1,'SE CAMBIO PORCENTAJE','comisiones',NULL)");
        return $respuesta;
    }
   
    function update_DU_topar($id_usuario, $obs, $monto) {
        $id_user_Vl = $this->session->userdata('id_usuario');
        return $this->db->query("UPDATE descuentos_universidad SET monto = ".$monto.", estatus =3, pagos_activos = 0, comentario = '".$id_user_Vl.' TOPO EL DESCUENTO POR MOTIVO DE: '.$obs."' WHERE id_usuario IN (".$id_usuario.") AND estatus in (1,2)");
    }
  
    function getPagosFacturasBaja(){
        return $this->db->query(" select op.archivo_name,op.estatus,pci.id_usuario,CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) as colaborador,opc.nombre as puesto,s.nombre as sede,SUM(PCI.abono_neodata) as suma from usuarios u  
        inner join pago_comision_ind pci on pci.id_usuario=u.id_usuario 
        inner join opcs_x_cats opc on opc.id_opcion=u.id_rol 
        inner join sedes s on s.id_sede=u.id_sede
        left join opinion_cumplimiento op on op.id_usuario=pci.id_usuario and op.estatus in(1,2)
        where u.forma_pago=2 and u.estatus=0 and pci.estatus=1  and opc.id_catalogo=1  
        GROUP BY op.archivo_name,op.estatus,pci.id_usuario,u.nombre,u.apellido_paterno,u.apellido_paterno,u.apellido_materno,opc.nombre,s.nombre");
    }
 
    function getPagosByProyect($proyect = '',$formap = ''){

        if(!empty($proyect)){
            $id = $proyect;
            $forma = $formap;
        }else{
            $id = 0;
        }
        $datos =array();
        $suma =  $this->db->query("(SELECT sum(pci.abono_neodata) as suma
        FROM residenciales re
        INNER JOIN condominios co ON re.idResidencial = co.idResidencial
        INNER JOIN lotes lo ON lo.idCondominio = co.idCondominio
        INNER JOIN comisiones com ON com.id_lote = lo.idLote AND com.estatus in (1,8)
        INNER JOIN pago_comision_ind pci ON pci.id_comision = com.id_comision
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario 
        WHERE pci.estatus IN (8) and u.forma_pago=$formap and re.idResidencial=$id)")->result_array();
        $ids = $this->db->query("( SELECT pci.id_pago_i
        FROM residenciales re
        INNER JOIN condominios co ON re.idResidencial = co.idResidencial
        INNER JOIN lotes lo ON lo.idCondominio = co.idCondominio
        INNER JOIN comisiones com ON com.id_lote = lo.idLote AND com.estatus in (1,8)
        INNER JOIN pago_comision_ind pci ON pci.id_comision = com.id_comision
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario 
        WHERE pci.estatus IN (8) and u.forma_pago=$forma and re.idResidencial=$id)")->result_array();
        
        $datos[0]=$suma;
        $datos[1]=$ids;
        return $datos;
    }
    
    function getDesarrolloSelectINTMEX($a = ''){
        if($a == ''){
            $forma_p = $this->session->userdata('id_usuario');
        }else{
            $forma_p = $a;
        }
        return $this->db->query("SELECT res.idResidencial id_usuario, res.descripcion  as name_user
        FROM residenciales res WHERE res.idResidencial IN 
        (SELECT re.idResidencial
        FROM residenciales re
        INNER JOIN condominios co ON re.idResidencial = co.idResidencial
        INNER JOIN lotes lo ON lo.idCondominio = co.idCondominio
        INNER JOIN comisiones com ON com.id_lote = lo.idLote AND com.estatus in (1,8)
        INNER JOIN pago_comision_ind pci ON pci.id_comision = com.id_comision
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario 
        WHERE pci.estatus IN (8) and u.forma_pago = $forma_p GROUP BY re.idResidencial)");
    }
 
    function getLideres($lider){
        return $this->db->query("select u.id_usuario as id_usuario1,CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) as name_user,u2.id_usuario as id_usuario2,CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno) as name_user2, u3.id_usuario as id_usuario3,CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno) as name_user3 
        FROM usuarios u 
        INNER JOIN usuarios u2 on u.id_lider=u2.id_usuario 
        INNER JOIN usuarios u3 on u3.id_usuario=u2.id_lider where u.id_usuario=$lider");
    }

    function AddVentaCompartida($id_asesor,$coor,$ger,$sub,$id_cliente,$id_lote){
        date_default_timezone_set('America/Mexico_City');       
        $response = $this->db->query("insert into ventas_compartidas values($id_cliente,$id_asesor,$coor,$ger,1,GETDATE(),".$this->session->userdata('id_usuario').",$sub, GETDATE(),1,0,0);");
        $usuario = 0;
        $rolSelect=0;
        $porcentaje=0;
    
        for($i=0;$i<4;$i++){
            if($i== 0){
                $usuario=$id_asesor;
                $rolSelect =7;
                $porcentaje=1.5;
            } else if($i == 1){
                $usuario=$coor;
                $rolSelect =9;
                $porcentaje=0.5;
            } else if($i == 2){
                $usuario=$ger;
                $rolSelect =3;
                $porcentaje=0.5;
            } else if($i == 3){
                $usuario=$sub;
                $rolSelect =2;
                $porcentaje=0.5;
            }

        $validate = $this->db->query("SELECT id_usuario FROM comisiones WHERE id_lote IN (SELECT idLote FROM lotes WHERE idLote = $id_lote) AND id_usuario = $usuario");
        $data_lote = $this->db->query("SELECT idLote, totalNeto2 FROM lotes WHERE idLote = $id_lote");
        $precio_lote = $data_lote->row()->totalNeto2;
        $comision_total=$precio_lote * ($porcentaje /100);

        if(empty($validate->row()->id_usuario)){
            $response = $this->db->query("UPDATE comisiones set comision_total=$comision_total,porcentaje_decimal=$porcentaje,modificado_por='".$this->session->userdata('id_usuario')."' where id_lote=".$id_lote." and rol_generado=$rolSelect");
            $response = $this->db->query("INSERT INTO comisiones(id_lote,id_usuario,comision_total,estatus,observaciones,evidencia,factura,creado_por,fecha_creacion,porcentaje_decimal,fecha_autorizacion,rol_generado,descuento,idCliente,modificado_por) VALUES (".$id_lote.",$usuario,$comision_total,1,'SE AGREGÓ VENTA COMPARTIDA',NULL,NULL,".$this->session->userdata('id_usuario').",GETDATE(),$porcentaje,GETDATE(),$rolSelect,0,$id_cliente,'".$this->session->userdata('id_usuario')."')");   
        }

    }
        if($response){
            return 1;
        }else{
            return 0;
        }  
    }

    public function CancelarDescuento($id_pago,$motivo) {
        $this->db->query("UPDATE descuentos_universidad
            SET estatus = CASE WHEN (estatus = 4) THEN 1 ELSE estatus END, pagos_activos = CASE WHEN (estatus = 4) THEN pagos_activos + 1 else pagos_activos END
            WHERE id_usuario = (SELECT id_usuario FROM pago_comision_ind WHERE id_pago_i = $id_pago)");
            $respuesta = $this->db->query("UPDATE pago_comision_ind set descuento_aplicado=0,estatus=1,modificado_por='".$this->session->userdata('id_usuario')."' where id_pago_i=".$id_pago."");
            $respuesta = $this->db->query("INSERT INTO  historial_comisiones VALUES (".$id_pago.",".$this->session->userdata('id_usuario').", GETDATE(), 1, 'CAPITAL HUMANO CANCELÓ DESCUENTO, MOTIVO: ".$motivo."')");

        if ($respuesta ) {
            return 1;
        } else {
            return 0;
        }
    }

    function getDatosGralInternomex(){ 
        return $this->db->query("(SELECT pci1.id_pago_i, re.nombreResidencial as proyecto, co.nombre as condominio, lo.nombreLote as lote, lo.referencia, lo.totalNeto2 precio_lote, re.empresa, pci1.abono_neodata pago_cliente, (CASE u.forma_pago WHEN 3 THEN sed.impuesto ELSE 0 END) valimpuesto, (CASE u.forma_pago WHEN 3 THEN (((sed.impuesto)/100)*pci1.abono_neodata) ELSE 0 END) dcto, (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario, CASE WHEN cl.estructura = 1 THEN oprol2.nombre ELSE oprol.nombre END as puesto, pci1.fecha_pago_intmex, oxcfp.nombre forma_pago, sed.nombre, (CASE u.estatus WHEN 0 THEN 'BAJA' ELSE 'ACTIVO' END) estatus_usuario, u.rfc 
        FROM pago_comision_ind pci1 
        INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
        INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio 
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial 
        INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 1
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (2,3,4)
        INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
        INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
        INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
        INNER JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 2 WHEN 4 THEN 5 WHEN 5 THEN 3 WHEN 607 THEN 1 WHEN 7092 THEN 4 WHEN 9629 THEN 2 ELSE u.id_sede END) and sed.estatus = 1
        INNER JOIN opcs_x_cats oxcfp ON oxcfp.id_opcion =  u.forma_pago AND oxcfp.id_catalogo = 16 
        LEFT JOIN opcs_x_cats oprol2 ON oprol2.id_opcion = com.rol_generado AND oprol2.id_catalogo = 83
        WHERE pci1.estatus IN (8)  AND com.estatus in (1) AND lo.idStatusContratacion > 8
        GROUP BY pci1.id_comision, pci1.id_pago_i, re.nombreResidencial, co.nombre, lo.nombreLote, lo.referencia, lo.totalNeto2, re.empresa, pci1.abono_neodata, sed.impuesto, u.nombre, u.apellido_paterno, u.apellido_materno, oprol.nombre, pci1.fecha_pago_intmex, oxcfp.nombre, u.forma_pago, sed.nombre, u.estatus, u.rfc, cl.estructura, oprol2.nombre)
        UNION 
        (SELECT pci1.id_pago_i, re.nombreResidencial as proyecto, co.nombre as condominio, lo.nombreLote as lote, lo.referencia, lo.totalNeto2 precio_lote, re.empresa, pci1.abono_neodata pago_cliente, (CASE u.forma_pago WHEN 3 THEN sed.impuesto ELSE 0 END) valimpuesto, (CASE u.forma_pago WHEN 3 THEN (((sed.impuesto)/100)*pci1.abono_neodata) ELSE 0 END) dcto, (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario, CASE WHEN cl.estructura = 1 THEN oprol2.nombre ELSE oprol.nombre END as puesto, pci1.fecha_pago_intmex, oxcfp.nombre forma_pago, sed.nombre, (CASE u.estatus WHEN 0 THEN 'BAJA' ELSE 'ACTIVO' END) estatus_usuario, u.rfc 
        FROM pago_comision_ind pci1 
        INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
        INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial 
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (2,3,4)
        INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
        INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
        INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
        INNER JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 2 WHEN 4 THEN 5 WHEN 5 THEN 3 WHEN 607 THEN 1 WHEN 7092 THEN 4 WHEN 9629 THEN 2 ELSE u.id_sede END) and sed.estatus = 1
        INNER JOIN opcs_x_cats oxcfp ON oxcfp.id_opcion =  u.forma_pago AND oxcfp.id_catalogo = 16 
        LEFT JOIN clientes cl ON cl.id_cliente = com.idCliente
        LEFT JOIN opcs_x_cats oprol2 ON oprol2.id_opcion = com.rol_generado AND oprol2.id_catalogo = 83
        WHERE pci1.estatus IN (8) AND ( (lo.idStatusContratacion < 9 AND com.estatus IN (1,8)) OR (lo.idStatusContratacion > 8  AND com.estatus  IN (8)))   
        GROUP BY pci1.id_comision, pci1.id_pago_i, re.nombreResidencial, co.nombre, lo.nombreLote, lo.referencia, lo.totalNeto2, re.empresa, pci1.abono_neodata, sed.impuesto, u.nombre, u.apellido_paterno, u.apellido_materno, oprol.nombre, pci1.fecha_pago_intmex, oxcfp.nombre, u.forma_pago, sed.nombre, u.estatus, u.rfc, cl.estructura, oprol2.nombre)");
    }
   
    public function get_lista_estatus(){
        return $this->db->query("SELECT 1 AS idEstatus, 'NUEVAS' as nombre union
        SELECT 2 AS idEstatus, 'REVISION CONTRALORIA' as nombre union
        SELECT 3 AS idEstatus, 'INTERNOMEX' as nombre union
        SELECT 4 AS idEstatus, 'PAUSADAS' as nombre union
        SELECT 5 AS idEstatus, 'DESCUENTOS' as nombre union
        SELECT 6 AS idEstatus, 'RESGUARDOS' as nombre union
        SELECT 7 AS idEstatus, 'PAGADAS' as nombre ");
    }

    function getDatosHistorialPagoEstatus($proyecto, $estado, $usuario) {
        $filtro_00 = ($proyecto === '0') ? '' : " AND re.idResidencial = $proyecto ";
        $userWhereClause = ($usuario != 0) ? "AND com.id_usuario = $usuario" : '';
        switch ($estado) {
            case '1':
                $filtro_estatus = " pci1.estatus IN (1,2,41,42,51,52,61,62)  AND (pci1.descuento_aplicado is null or pci1.descuento_aplicado = '0') ";
                break;
            case '2':
                $filtro_estatus = " pci1.estatus IN (4,13)  AND (pci1.descuento_aplicado is null or pci1.descuento_aplicado = '0') ";
                break;
            case '3':
                $filtro_estatus = " pci1.estatus IN (8,88)  AND (pci1.descuento_aplicado is null or pci1.descuento_aplicado = '0') ";
                break;
            case '4':
                $filtro_estatus = " pci1.estatus IN (6)  AND (pci1.descuento_aplicado is null or pci1.descuento_aplicado = '0') ";
                break;
            case '5':
                $filtro_estatus = " pci1.descuento_aplicado = 1 ";
                break;
            case '6':
                $filtro_estatus = " pci1.estatus IN (3)  AND (pci1.descuento_aplicado is null or pci1.descuento_aplicado = '0') ";
                break;
            case '7':
                $filtro_estatus = " pci1.estatus IN (11,12)  AND (pci1.descuento_aplicado is null or pci1.descuento_aplicado = '0') ";
                break;
            case '8':
                $filtro_estatus = " lo.tipo_venta = 7  AND pci1.estatus IN (1,6) AND (pci1.descuento_aplicado is null or pci1.descuento_aplicado = '0')";
                break;
            case '9':
                $filtro_estatus= " com.estatus IN (8)";
                break;
        }
        return $this->db->query("SELECT pci1.id_pago_i, pci1.id_comision, (CASE WHEN com.ooam = 2 THEN CONCAT(lo.nombreLote,' <i>(',com.loteReubicado,')</i>') ELSE lo.nombreLote END) nombreLote, re.nombreResidencial as proyecto, co.nombre as condominio,lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, pci1.estatus, pci1.fecha_abono fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) user_names ,pci1.id_usuario, CASE WHEN cl.estructura = 1 THEN oprol2.nombre ELSE oprol.nombre END as puesto, u.forma_pago, pac.porcentaje_abono, 
        (CASE WHEN com.ooam = 1 THEN  CONCAT(oxcest.nombre,' (OOAM)') ELSE oxcest.nombre END) estatus_actual, 
        oxcest.id_opcion id_estatus_actual, pci1.descuento_aplicado, (CASE WHEN cl.lugar_prospeccion IS NULL THEN 0 ELSE cl.lugar_prospeccion END) lugar_prospeccion, lo.referencia, com.estatus estado_comision, pac.bonificacion, u.estatus as activo, lo.tipo_venta, oxcest.color, (CASE WHEN pe.id_penalizacion IS NOT NULL THEN 1 ELSE 0 END) penalizacion, (CASE WHEN com.estatus = 8 THEN 1 ELSE 0 END) recision
        FROM pago_comision_ind pci1 
        LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE (estatus in (11,3) OR descuento_aplicado = 1) GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
        INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
        INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial $filtro_00
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
        LEFT JOIN clientes cl ON cl.id_cliente = lo.idCliente AND cl.status = 1 AND lo.idStatusContratacion > 8 AND com.estatus = 1
        INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
        INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
        INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23
        LEFT JOIN penalizaciones pe ON pe.id_lote = lo.idLote AND pe.id_cliente = lo.idCliente
        LEFT JOIN opcs_x_cats oprol2 ON oprol2.id_opcion = com.rol_generado AND oprol2.id_catalogo = 83
        WHERE $filtro_estatus $userWhereClause
        GROUP BY pci1.id_comision,com.ooam,com.loteReubicado, lo.nombreLote, re.nombreResidencial, co.nombre, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, pci1.descuento_aplicado, lo.referencia, com.estatus, pac.bonificacion, u.estatus, lo.tipo_venta, oxcest.color, pe.id_penalizacion, cl.lugar_prospeccion, com.estatus, cl.estructura, oprol2.nombre");
    }

    function getInformacionDataMK($var){
        return $this->db->query("SELECT pci.id_pago_mk as idLote, abono_marketing as nombreLote, pci.id_pago_mk id_comision, pci.abono_marketing as abono_neodata, 0 abono_pagado , pci.abono_marketing as comision_total
        FROM pago_comision_mktd pci
        WHERE pci.estatus IN (1) AND pci.id_pago_mk = $var ORDER BY pci.abono_marketing DESC");
    }

    function obtenerIDMK($id){
        return $this->db->query("SELECT id_pago_mk id_comision, id_list, empresa from pago_comision_mktd WHERE id_pago_mk=$id");
    }
    
    function update_descuentoMK($id_pago_i,$monto, $comentario, $usuario,$valor,$user,$pagos_aplicados){
        $estatus = 11;
        if($monto == 0){
            $respuesta = $this->db->query("UPDATE pago_comision_mktd SET estatus = $estatus, descuento = 1, creado_por= $usuario, fecha_pago_intmex = GETDATE(), fecha_abono = GETDATE(), comentario='DESCUENTO' WHERE id_pago_mk=$id_pago_i");
        }else{
            $respuesta = $this->db->query("UPDATE pago_comision_mktd SET estatus = $estatus, descuento=1, creado_por= $usuario, fecha_pago_intmex = GETDATE(), fecha_abono = GETDATE(), abono_marketing = $monto, comentario='DESCUENTO' WHERE id_pago_mk=$id_pago_i");
        }
        $respuesta = $this->db->query("INSERT INTO historial_comisiones VALUES ($id_pago_i, $usuario, GETDATE(), 1, 'MOTIVO DESCUENTO: ".$comentario."')");

           if (! $respuesta ) {
               return 0;
               } else {
               return 1;
               }
    }
    
    function insertar_descuentoMK($usuarioid,$monto,$ide_comision,$comentario,$usuario,$pago_neodata,$valor, $id_list, $empresa ){
    
        $estatus = 1;
        $respuesta = $this->db->query("INSERT INTO pago_comision_mktd(id_list, id_usuario, abono_marketing, fecha_abono, fecha_pago_intmex, pago_mktd, estatus, creado_por, comentario, descuento, empresa) VALUES ('".$id_list."', $usuarioid, $monto, GETDATE(), GETDATE(), $pago_neodata, $estatus, $usuario, 'DESCUENTO NUEVO PAGO',0, '".$empresa."')");

        if (! $respuesta ) {
            return 0;
            } else {
            return 1;
            }
    } 
    
    public function InsertNeo($idLote, $id_usuario, $TotComision,$user, $porcentaje,$abono,$pago,$rol,$idCliente,$tipo_venta,$ooam, $nombreOtro){
        
        if($porcentaje != 0 && $porcentaje != ''){
            $respuesta =  $this->db->query("INSERT INTO comisiones ([id_lote], [id_usuario], [comision_total], [estatus], [observaciones], [ooam], [loteReubicado], [creado_por], [fecha_creacion], [porcentaje_decimal], [fecha_autorizacion], [rol_generado],[idCliente],[modificado_por]) VALUES (".$idLote.", ".$id_usuario.", ".$TotComision.", 1, 'NUEVA DISPERSIÓN - $tipo_venta ', $ooam, '".$nombreOtro."', ".$user.", GETDATE(), ".$porcentaje.", GETDATE(), ".$rol.",".$idCliente.",'".$this->session->userdata('id_usuario')."')");
            $insert_id = $this->db->insert_id();

            $respuesta = $this->db->query("UPDATE comisiones SET liquidada = 1 
            FROM comisiones com
            LEFT JOIN (SELECT SUM(abono_neodata) abonado, id_comision FROM pago_comision_ind GROUP BY id_comision) as pci ON pci.id_comision = com.id_comision
            WHERE com.id_comision = $insert_id AND com.ooam IN (2) AND (com.comision_total-abonado) < 1");

            $respuesta = $this->db->query("INSERT INTO pago_comision_ind (id_comision, id_usuario, abono_neodata, fecha_abono, fecha_pago_intmex, estatus, pago_neodata, creado_por, comentario, modificado_por) VALUES (".$insert_id.", ".$id_usuario.", ".$abono.", GETDATE(), GETDATE(), 1 , ".$pago.",'$user', 'PAGO 1 - NEDOATA', '$user')");
            $insert_id_2 = $this->db->insert_id();

            $respuesta = $this->db->query("INSERT INTO historial_comisiones VALUES ($insert_id_2, ".$this->session->userdata('id_usuario').", GETDATE(), 1, 'DISPERSÓ PAGO DE COMISIÓN')");
        }
        if (! $respuesta ) {
            return 0;
        } else {
            return 1;
        }
    }

    public function InsertNeoPenalizacion($idLote, $id_usuario, $TotComision,$user,$porcentaje,$abono,$pago,$rol,$idCliente,$tipo_venta, $nombreLote){
        if($porcentaje != 0 && $porcentaje != ''){
            $valInner =  $this->db->query("SELECT COALESCE(pe.id_porcentaje_penalizacion,0) val FROM penalizaciones pe INNER JOIN lotes l ON l.idLote = pe.id_lote INNER JOIN clientes c ON c.id_cliente = l.idCliente INNER JOIN porcentajes_penalizaciones pp ON pp.id_porcentaje_penalizacion = pe.id_porcentaje_penalizacion WHERE bandera = 1 AND l.idLote = ".$idLote."");

            if(!empty($valInner->row()->val)){
                $stringInner = '';
                if(empty($valInner->row()->val) || $valInner->row()->val != '4' || $valInner->row()->val != 4){
                    $stringInner = ' INNER JOIN porcentajes_penalizaciones pp ON pp.id_porcentaje_penalizacion = pe.id_porcentaje_penalizacion ';
                }else{
                    $stringInner = ' INNER JOIN distribucion_penalizaciones pp ON pp.id_penalizacion = pe.id_penalizacion ';
                }
            }

            $evaluarPorcentajes =  $this->db->query("SELECT pe.id_penalizacion, pe.dias_atraso, (pp.asesor*lo.totalNeto2*0.01) asesor, (pp.coordinador*lo.totalNeto2*0.01) coordinador, (pp.gerente*lo.totalNeto2*0.01) gerente, pp.asesor as pAse, pp.coordinador as pCoo, pp.gerente as pGer FROM penalizaciones pe $stringInner INNER JOIN lotes lo ON lo.idLote = pe.id_lote AND lo.idCliente = pe.id_cliente WHERE pe.id_lote = $idLote and pe.id_cliente = $idCliente");

            if($rol == 3){
                $montoPenalizar = ($evaluarPorcentajes->row()->gerente); 
                $descuento90dias = ($montoPenalizar/(1/$porcentaje));
                $porcentajeTomado = $evaluarPorcentajes->row()->pGer;
            }else if($rol == 7){
                $montoPenalizar = ($evaluarPorcentajes->row()->asesor);
                $descuento90dias = ($montoPenalizar/(3/$porcentaje)); 
                $porcentajeTomado = $evaluarPorcentajes->row()->pAse;
            }else if($rol == 9){
                $montoPenalizar = ($evaluarPorcentajes->row()->coordinador);
                $descuento90dias = ($montoPenalizar/(1/$porcentaje));
                $porcentajeTomado = $evaluarPorcentajes->row()->pCoo;
            }

            if($descuento90dias > 0 && $descuento90dias <= $abono){
                $abonoNormal = $abono - $descuento90dias;
                $abonoPenalizacion = $descuento90dias;
                $estatusPrestamo = 3;
            }else if($descuento90dias > 0 && $descuento90dias > $abono ){
                $abonoNormal = 0;
                $abonoPenalizacion = $abono;
                $estatusPrestamo = 1;
            }

            $respuesta = $this->db->query("INSERT INTO comisiones ([id_lote], [id_usuario], [comision_total], [estatus], [observaciones], [ooam], [loteReubicado], [creado_por], [fecha_creacion], [porcentaje_decimal], [fecha_autorizacion], [rol_generado],[idCliente],[modificado_por]) VALUES (".$idLote.", ".$id_usuario.", ".$TotComision.", 1, 'NUEVA DISPERSIÓN - $tipo_venta ', NULL, NULL, ".$user.", GETDATE(), ".$porcentaje.", GETDATE(), ".$rol.",".$idCliente.",'".$this->session->userdata('id_usuario')."')");
            $insert_id = $this->db->insert_id();
                
            $respuesta = $this->db->query("INSERT INTO pago_comision_ind (id_comision, id_usuario, abono_neodata, fecha_abono, fecha_pago_intmex, estatus, pago_neodata, creado_por, comentario, modificado_por, descuento_aplicado ) VALUES (".$insert_id.", ".$id_usuario.", ".$abonoNormal.", GETDATE(), GETDATE(), 1 , ".$pago.",'$user', 'PAGO 1 - NEDOATA', '$user',0) ");
                
            $insert_id_2 = $this->db->insert_id();
            $respuesta = $this->db->query("INSERT INTO  historial_comisiones VALUES ($insert_id_2, ".$this->session->userdata('id_usuario').", GETDATE(), 1, 'DISPERSÓ PAGO DE COMISIÓN CON PENALIZACIÓN')");

            $respuesta = $this->db->query("INSERT INTO pago_comision_ind (id_comision, id_usuario, abono_neodata, fecha_abono, fecha_pago_intmex, estatus, pago_neodata, creado_por, comentario, modificado_por, descuento_aplicado ) VALUES (".$insert_id.", ".$id_usuario.", ".$abonoPenalizacion.", GETDATE(), GETDATE(), 28 , ".$pago.",'$user', 'PAGO 1 - NEDOATA', '$user', 1)");

            $insert_id_3 = $this->db->insert_id();
            $respuesta = $this->db->query("INSERT INTO  historial_comisiones VALUES ($insert_id_3, ".$this->session->userdata('id_usuario').", GETDATE(), 1, 'DESCUENTO ".$nombreLote."PENALIZACIÓN +90 DÍAS')");

            $respuesta = $this->db->query("INSERT INTO prestamos_aut (id_usuario, monto, num_pagos, pago_individual, comentario, estatus, pendiente, creado_por, fecha_creacion, modificado_por, fecha_modificacion, n_p, tipo, id_cliente) VALUES ($id_usuario, $descuento90dias, 1, $abonoPenalizacion, 'PENALIZACIÓN ".$nombreLote." +90 DÍAS (-".$porcentajeTomado."%)', $estatusPrestamo, 0, $user, GETDATE(), $user, GETDATE(), 1, 28, $idCliente)");
            $insert_id_4 = $this->db->insert_id();

            $respuesta = $this->db->query("INSERT INTO relacion_pagos_prestamo (id_prestamo, id_pago_i, estatus, creado_por, fecha_creacion, modificado_por, fecha_modificacion, np) VALUES($insert_id_4, $insert_id_3, 1, $user, GETDATE(), $user, GETDATE(), 1)");
        }
            if (! $respuesta ) {
                return 0;
                } else {
                return 1;
                }
    }
    
    public function porcentajes($clienteData, $totalNeto, $plan_comision){

        if($plan_comision == 66){
            $innerMktd = 'pl.mktd';
            $innerOtro = 'pl.otro';
            $innerOtro2 = 'pl.otro2';
            $innerCoord = 'pl.coordinador';
            $innerReg = 'pl.regional';

            $rol1 = 87;//POSTVENTA
            $rol2 = 88;//TI
            $rol3 = 89;//ADMINISTRACIÓN
            $rol4 = 90;//CONTABILIDAD
            $rol5 = 91;//TITULACIÓN
           
        }else{
            $innerMktd = 4394;
            $innerOtro = 'pl.id_o';
            $innerOtro2 = 'pl.id_o2';
            $innerCoord = 'cA.id_coordinador';
            $innerReg = 'cA.id_regional';

            $rol1 = 'pl.coordinador';//POSTVENTA
            $rol2 = 'pl.regional';//TI
            $rol3 = 'pl.mktd';//ADMINISTRACIÓN
            $rol4 = 'pl.otro';//CONTABILIDAD
            $rol5 = 'pl.otro2';//TITULACIÓN
        }


         if($plan_comision == 64 ||$plan_comision == 65 ||$plan_comision == 66 ){
            $joinLotes = 'INNER JOIN lotes lo ON lo.idLote = cA.idLote';
        }else{
            $joinLotes = 'INNER JOIN lotes lo ON lo.idCliente = cA.id_cliente';
        }

        $addCondition = " UNION  /* DIRECTOR */
        (SELECT DISTINCT(u1.id_usuario) AS id_usuario, pl.comDi porcentaje_decimal, (($totalNeto/100)*(pl.comDi)) comision_total, (pl.neoDi) porcentaje_neodata, CONCAT(u1.nombre,' ',u1.apellido_paterno,' ',u1.apellido_materno) AS nombre, pl.director as id_rol, CASE WHEN cA.estructura = 1 THEN 'Director Comercial General' ELSE 'Director' END detail_rol, 1 as rolVal
        FROM clientes cA 
        $joinLotes  
        INNER JOIN usuarios u1 ON u1.id_usuario = 2
        INNER JOIN plan_comision pl ON pl.id_plan = cA.plan_comision and pl.director not in (0)
        WHERE cA.id_cliente = @idCliente)
        
        UNION  /* MARKETING-ADMINISTRACION */
        (SELECT DISTINCT(u1.id_usuario) AS id_usuario, pl.comMk porcentaje_decimal, (($totalNeto/100)*(pl.comMk)) comision_total, (pl.neoMk) porcentaje_neodata, CONCAT(u1.nombre,' ',u1.apellido_paterno,' ',u1.apellido_materno) AS nombre, $rol3 as id_rol, (CASE WHEN pl.id_plan = 66 THEN 'Administración' ELSE 'Marketing' END) detail_rol, 6 as rolVal
        FROM clientes cA 
        $joinLotes  
        INNER JOIN plan_comision pl ON pl.id_plan = cA.plan_comision and pl.mktd not in (0)
        INNER JOIN usuarios u1 ON u1.id_usuario = $innerMktd
        WHERE cA.id_cliente = @idCliente)

        UNION  /* OTRO PRIMERO - Contabilidad */
        (SELECT DISTINCT(u1.id_usuario) AS id_usuario, pl.comOt porcentaje_decimal, (($totalNeto/100)*(pl.comOt)) comision_total, (pl.neoOt) porcentaje_neodata, CONCAT(u1.nombre,' ',u1.apellido_paterno,' ',u1.apellido_materno) AS nombre, $rol4 as id_rol, (CASE WHEN pl.otro = 45 THEN 'Empresa' WHEN pl.otro = 2 THEN 'Subdirector' WHEN pl.id_o = 11053 THEN 'Internomex' WHEN pl.id_o = 12841 THEN 'Arcus' WHEN pl.id_plan = 66 THEN 'Contabilidad' ELSE 'Influencer' END) detail_rol, (CASE WHEN pl.otro = 2 THEN 2 ELSE 7 END) as rolVal
        FROM clientes cA 
        $joinLotes  
        INNER JOIN plan_comision pl ON pl.id_plan = cA.plan_comision and pl.otro not in (0)
        INNER JOIN usuarios u1 ON u1.id_usuario = $innerOtro
        INNER JOIN opcs_x_cats opc ON opc.id_opcion = u1.id_rol AND opc.id_catalogo = 1
        WHERE cA.id_cliente = @idCliente)
        
        UNION  /* OTRO SEGUNDO - Titulación */
        (SELECT DISTINCT(u1.id_usuario) AS id_usuario, pl.comOt2 porcentaje_decimal, (($totalNeto/100)*(pl.comOt2)) comision_total, (pl.neoOt2) porcentaje_neodata, CONCAT(u1.nombre,' ',u1.apellido_paterno,' ',u1.apellido_materno) AS nombre, $rol5 as id_rol, (CASE WHEN pl.otro2 = 45 THEN 'Empresa' WHEN pl.otro2 = 2 THEN 'Subdirector' WHEN pl.id_o2 = 11054 THEN 'Internomex' WHEN pl.id_o2 = 12841 THEN 'Arcus' WHEN pl.id_plan = 66 THEN 'Titulación' ELSE 'Influencer' END) detail_rol, 8 as rolVal
        FROM clientes cA 
        $joinLotes  
        INNER JOIN plan_comision pl ON pl.id_plan = cA.plan_comision and pl.otro2 not in (0)
        INNER JOIN usuarios u1 ON u1.id_usuario = $innerOtro2
        INNER JOIN opcs_x_cats opc ON opc.id_opcion = u1.id_rol AND opc.id_catalogo = 1
        WHERE cA.id_cliente = @idCliente) ";

        $numAs = $this->db->query("(SELECT (COUNT(distinct(u1.id_usuario))) i FROM clientes cl INNER JOIN ventas_compartidas v1 ON v1.id_cliente = cl.id_cliente AND v1.estatus = 1 AND cl.status = 1 INNER JOIN usuarios u1 ON u1.id_usuario = cl.id_asesor or  u1.id_usuario = v1.id_asesor WHERE cl.id_cliente = $clienteData)");
        $numCo = $this->db->query("(SELECT (COUNT(distinct(u1.id_usuario))) i FROM clientes cl LEFT JOIN ventas_compartidas v1 ON v1.id_cliente = cl.id_cliente AND v1.estatus = 1 AND cl.status = 1 INNER JOIN usuarios u1 ON u1.id_usuario = cl.id_coordinador or  u1.id_usuario = v1.id_coordinador WHERE cl.id_cliente = $clienteData)");
        $numGe = $this->db->query("(SELECT (COUNT(u1.id_usuario)) i FROM clientes cl LEFT JOIN ventas_compartidas v1 ON v1.id_cliente = cl.id_cliente AND v1.estatus = 1 AND cl.status = 1 INNER JOIN usuarios u1 ON u1.id_usuario = cl.id_gerente or  u1.id_usuario = v1.id_gerente WHERE cl.id_cliente = $clienteData)");
        $numSu = $this->db->query("(SELECT distinct(COUNT(u1.id_usuario)) i FROM clientes cl LEFT JOIN ventas_compartidas v1 ON v1.id_cliente = cl.id_cliente AND v1.estatus = 1 AND cl.status = 1 INNER JOIN usuarios u1 ON u1.id_usuario = cl.id_subdirector or  u1.id_usuario = v1.id_subdirector  WHERE cl.id_cliente = $clienteData)");

        $numAsesores = $numAs->row()->i;
        $numCoordinadores = $numCo->row()->i;
        $numGerente = $numGe->row()->i;
        $numSubdir = $numSu->row()->i;
        
        return $this->db->query("DECLARE @idCliente INTEGER, @numAsesores INTEGER, @numCoordinadores INTEGER, @numGerente INTEGER, @numSubdir INTEGER, @numDir INTEGER
  
        SET @idCliente = $clienteData  
        SET @numAsesores = $numAsesores  
        SET @numCoordinadores = $numCoordinadores 
        SET @numGerente = $numGerente 
        SET @numSubdir = $numSubdir 
        SET @numDir =  1
        
        IF @numAsesores > 1
        
            /* ASESORES */
            (SELECT DISTINCT(u1.id_usuario) AS id_usuario, pl.comAs/@numAsesores porcentaje_decimal, (($totalNeto/100)*(pl.comAs/@numAsesores)) comision_total, (pl.neoAs/@numAsesores) porcentaje_neodata, CONCAT(u1.nombre,' ',u1.apellido_paterno,' ',u1.apellido_materno) AS nombre, pl.asesor as id_rol,  CASE WHEN cA.estructura = 1 THEN 'Asesor Financiero' ELSE 'Asesor' END detail_rol, 5 as rolVal
            FROM clientes cA 
            $joinLotes  
            INNER JOIN ventas_compartidas v1 ON v1.id_cliente = cA.id_cliente and v1.estatus = 1 and cA.status = 1
            INNER JOIN usuarios u1 ON u1.id_usuario = v1.id_asesor OR u1.id_usuario = cA.id_asesor
            INNER JOIN plan_comision pl ON pl.id_plan = cA.plan_comision and pl.asesor not in (0) 
            WHERE cA.id_cliente = @idCliente)
        
            UNION  /* COORDINADORES */
            (SELECT DISTINCT(u1.id_usuario) AS id_usuario, 
            (pl.comCo/@numAsesores)*((SELECT COUNT(id_coordinador) FROM clientes cD WHERE cD.status = 1 AND cD.id_coordinador = u1.id_usuario and cD.id_cliente = @idCliente)+(SELECT COUNT(id_coordinador) FROM ventas_compartidas vD WHERE vD.estatus = 1 AND vD.id_coordinador = u1.id_usuario AND vD.id_cliente = @idCliente)) porcentaje_decimal, 
            (($totalNeto/100)*(pl.comCo/@numAsesores))*((SELECT COUNT(id_coordinador) FROM clientes cD WHERE cD.status = 1 AND cD.id_coordinador = u1.id_usuario and cD.id_cliente = @idCliente)+(SELECT COUNT(id_coordinador) FROM ventas_compartidas vD WHERE vD.estatus = 1 AND vD.id_coordinador = u1.id_usuario AND vD.id_cliente = @idCliente)) comision_total, 
            (pl.neoCo/@numAsesores)*((SELECT COUNT(id_coordinador) FROM clientes cD WHERE cD.status = 1 AND cD.id_coordinador = u1.id_usuario and cD.id_cliente = @idCliente)+(SELECT COUNT(id_coordinador) FROM ventas_compartidas vD WHERE vD.estatus = 1 AND vD.id_coordinador = u1.id_usuario AND vD.id_cliente = @idCliente)) porcentaje_neodata, 
            CONCAT(u1.nombre,' ',u1.apellido_paterno,' ',u1.apellido_materno) AS nombre, pl.coordinador as id_rol,  CASE WHEN cA.estructura = 1 THEN 'Líder comercial' ELSE 'Coordinador' END detail_rol, 4 as rolVal
            FROM clientes cA 
            $joinLotes  
            INNER JOIN ventas_compartidas v1 ON v1.id_cliente = cA.id_cliente and v1.estatus = 1 and cA.status = 1
            INNER JOIN usuarios u1 ON u1.id_usuario = v1.id_coordinador OR u1.id_usuario = cA.id_coordinador
            INNER JOIN plan_comision pl ON pl.id_plan = cA.plan_comision and pl.coordinador not in (0) 
            WHERE cA.id_cliente = @idCliente)
            
            UNION  /* GERENTES */
            (SELECT DISTINCT(u1.id_usuario) AS id_usuario, 
            (pl.comGe/@numAsesores)*((SELECT COUNT(id_gerente) FROM clientes cD WHERE cD.status = 1 AND cD.id_gerente = u1.id_usuario and cD.id_cliente = @idCliente)+(SELECT COUNT(id_gerente) FROM ventas_compartidas vD WHERE vD.estatus = 1 AND vD.id_gerente = u1.id_usuario AND vD.id_cliente = @idCliente)) porcentaje_decimal, 
            (($totalNeto/100)*(pl.comGe/@numAsesores))*((SELECT COUNT(id_gerente) FROM clientes cD WHERE cD.status = 1 AND cD.id_gerente = u1.id_usuario and cD.id_cliente = @idCliente)+(SELECT COUNT(id_gerente) FROM ventas_compartidas vD WHERE vD.estatus = 1 AND vD.id_gerente = u1.id_usuario AND vD.id_cliente = @idCliente)) comision_total, 
            (pl.neoGe/@numAsesores)*((SELECT COUNT(id_gerente) FROM clientes cD WHERE cD.status = 1 AND cD.id_gerente = u1.id_usuario and cD.id_cliente = @idCliente)+(SELECT COUNT(id_gerente) FROM ventas_compartidas vD WHERE vD.estatus = 1 AND vD.id_gerente = u1.id_usuario AND vD.id_cliente = @idCliente)) porcentaje_neodata, 
            CONCAT(u1.nombre,' ',u1.apellido_paterno,' ',u1.apellido_materno) AS nombre, pl.gerente as id_rol,  CASE WHEN cA.estructura = 1 THEN 'Embajador' ELSE 'Gerente' END detail_rol, 3 as rolVal  
            FROM clientes cA 
            $joinLotes  
            INNER JOIN ventas_compartidas v1 ON v1.id_cliente = cA.id_cliente and v1.estatus = 1 and cA.status = 1
            INNER JOIN usuarios u1 ON u1.id_usuario = v1.id_gerente OR u1.id_usuario = cA.id_gerente
            INNER JOIN plan_comision pl ON pl.id_plan = cA.plan_comision and pl.gerente not in (0) 
            WHERE cA.id_cliente = @idCliente)
            
            UNION  /* SUBDIRECTORES */
            (SELECT DISTINCT(u1.id_usuario) AS id_usuario, 
            (pl.comSu/@numAsesores)*((SELECT COUNT(id_gerente) FROM clientes cD WHERE cD.status = 1 AND cD.id_subdirector = u1.id_usuario and cD.id_cliente = @idCliente)+(SELECT COUNT(id_gerente) FROM ventas_compartidas vD WHERE vD.estatus = 1 AND vD.id_subdirector = u1.id_usuario AND vD.id_cliente = @idCliente)) porcentaje_decimal, 
            (($totalNeto/100)*(pl.comSu/@numAsesores))*((SELECT COUNT(id_gerente) FROM clientes cD WHERE cD.status = 1 AND cD.id_subdirector = u1.id_usuario and cD.id_cliente = @idCliente)+(SELECT COUNT(id_gerente) FROM ventas_compartidas vD WHERE vD.estatus = 1 AND vD.id_subdirector = u1.id_usuario AND vD.id_cliente = @idCliente)) comision_total, 
            (pl.neoSu/@numAsesores)*((SELECT COUNT(id_gerente) FROM clientes cD WHERE cD.status = 1 AND cD.id_subdirector = u1.id_usuario and cD.id_cliente = @idCliente)+(SELECT COUNT(id_gerente) FROM ventas_compartidas vD WHERE vD.estatus = 1 AND vD.id_subdirector = 
            u1.id_usuario AND vD.id_cliente = @idCliente)) porcentaje_neodata, 
            CONCAT(u1.nombre,' ',u1.apellido_paterno,' ',u1.apellido_materno) AS nombre, pl.subdirector as id_rol, CASE WHEN cA.estructura = 1 THEN 'Subdirector Comercial' ELSE 'Subdirector' END detail_rol, 2 as rolVal  
            FROM clientes cA 
            $joinLotes  
            INNER JOIN ventas_compartidas v1 ON v1.id_cliente = cA.id_cliente and v1.estatus = 1 and cA.status = 1
            INNER JOIN usuarios u1 ON u1.id_usuario = v1.id_subdirector OR u1.id_usuario = cA.id_subdirector
            INNER JOIN plan_comision pl ON pl.id_plan = cA.plan_comision and pl.subdirector not in (0)
            WHERE cA.id_cliente = @idCliente)

            UNION  /* REGIONALES */
            (SELECT DISTINCT(u1.id_usuario) AS id_usuario, 
            (pl.comRe/@numAsesores)*
            ((SELECT COUNT(id_gerente) FROM clientes cD WHERE cD.status = 1 AND cD.id_regional = u1.id_usuario and cD.id_cliente = @idCliente)+(SELECT COUNT(id_gerente) FROM ventas_compartidas vD WHERE vD.estatus = 1 AND vD.id_regional = u1.id_usuario AND vD.id_cliente = @idCliente)) porcentaje_decimal, 
            (($totalNeto/100)*(pl.comRe/@numAsesores))*((SELECT COUNT(id_gerente) FROM clientes cD WHERE cD.status = 1 AND cD.id_regional = u1.id_usuario and cD.id_cliente = @idCliente)+(SELECT COUNT(id_gerente) FROM ventas_compartidas vD WHERE vD.estatus = 1 AND vD.id_regional = u1.id_usuario AND vD.id_cliente = @idCliente)) comision_total, 
            (pl.neoRe/@numAsesores)*((SELECT COUNT(id_gerente) FROM clientes cD WHERE cD.status = 1 AND cD.id_regional = u1.id_usuario and cD.id_cliente = @idCliente)+(SELECT COUNT(id_gerente) FROM ventas_compartidas vD WHERE vD.estatus = 1 AND vD.id_regional = u1.id_usuario AND vD.id_cliente = @idCliente)) porcentaje_neodata, 
            CONCAT(u1.nombre,' ',u1.apellido_paterno,' ',u1.apellido_materno) AS nombre, pl.subdirector as id_rol, 'Director Regional' detail_rol, 2 as rolVal  
            FROM clientes cA 
            $joinLotes  
            INNER JOIN ventas_compartidas v1 ON v1.id_cliente = cA.id_cliente and v1.estatus = 1 and cA.status = 1
            INNER JOIN usuarios u1 ON u1.id_usuario = v1.id_regional OR u1.id_usuario = cA.id_regional
            INNER JOIN plan_comision pl ON pl.id_plan = cA.plan_comision and pl.regional not in (0)
            WHERE cA.id_cliente = @idCliente)
        
            $addCondition
        
            ORDER BY rolVal 
        
        ELSE  
        
            /* ASESOR */
            (SELECT DISTINCT(u1.id_usuario) AS id_usuario, pl.comAs porcentaje_decimal, (($totalNeto/100)*(pl.comAs)) comision_total,
            (pl.neoAs) porcentaje_neodata, CONCAT(u1.nombre,' ',u1.apellido_paterno,' ',u1.apellido_materno) AS nombre, pl.asesor as id_rol, 
            CASE WHEN cA.estructura = 1 THEN 'Asesor Financiero' ELSE 'Asesor' END detail_rol, 5 as rolVal
            FROM clientes cA 
            $joinLotes  
            INNER JOIN usuarios u1 ON u1.id_usuario = cA.id_asesor
            INNER JOIN plan_comision pl ON pl.id_plan = cA.plan_comision and pl.asesor not in (0)
            WHERE cA.id_cliente = @idCliente)
        
            UNION  /* COORDINADOR */
            (SELECT DISTINCT(u1.id_usuario) AS id_usuario, pl.comCo porcentaje_decimal, (($totalNeto/100)*(pl.comCo)) comision_total,
            (pl.neoCo) porcentaje_neodata, CONCAT(u1.nombre,' ',u1.apellido_paterno,' ',u1.apellido_materno) AS nombre, $rol1 as id_rol, CASE WHEN cA.estructura = 1 THEN 'Líder comercial' WHEN pl.id_plan = 66 THEN 'Postventa' ELSE 'Coordinador' END detail_rol, 
            CASE WHEN pl.id_plan = 66 THEN 9 ELSE 4 END rolVal
            FROM clientes cA 
            $joinLotes  
            INNER JOIN plan_comision pl ON pl.id_plan = cA.plan_comision and pl.coordinador not in (0)
            INNER JOIN usuarios u1 ON u1.id_usuario = $innerCoord
            WHERE cA.id_cliente = @idCliente)
            
            UNION  /* GERENTE */
            (SELECT DISTINCT(u1.id_usuario) AS id_usuario, pl.comGe porcentaje_decimal, (($totalNeto/100)*(pl.comGe)) comision_total,
            (pl.neoGe) porcentaje_neodata, CONCAT(u1.nombre,' ',u1.apellido_paterno,' ',u1.apellido_materno) AS nombre, pl.gerente as id_rol, CASE WHEN cA.estructura = 1 THEN 'Embajador' ELSE 'Gerente' END detail_rol, 3 as rolVal  
            FROM clientes cA 
            $joinLotes  
            INNER JOIN usuarios u1 ON u1.id_usuario = cA.id_gerente
            INNER JOIN plan_comision pl ON pl.id_plan = cA.plan_comision and pl.gerente not in (0)
            WHERE cA.id_cliente = @idCliente)
            
            UNION  /* SUBDIRECTOR */
            (SELECT DISTINCT(u1.id_usuario) AS id_usuario, pl.comSu porcentaje_decimal, (($totalNeto/100)*(pl.comSu)) comision_total,
            (pl.neoSu) porcentaje_neodata, CONCAT(u1.nombre,' ',u1.apellido_paterno,' ',u1.apellido_materno) AS nombre, pl.subdirector as id_rol, CASE WHEN cA.estructura = 1 THEN 'Subdirector Comercial' ELSE 'Subdirector' END detail_rol, 2 as rolVal  
            FROM clientes cA 
            $joinLotes  
            INNER JOIN usuarios u1 ON u1.id_usuario = cA.id_subdirector
            INNER JOIN plan_comision pl ON pl.id_plan = cA.plan_comision and pl.subdirector not in (0)
            WHERE cA.id_cliente = @idCliente)

            UNION  /* REGIONAL */
            (SELECT DISTINCT(u1.id_usuario) AS id_usuario, pl.comRe porcentaje_decimal, (($totalNeto/100)*(pl.comRe)) comision_total,
            (pl.neoRe) porcentaje_neodata, CONCAT(u1.nombre,' ',u1.apellido_paterno,' ',u1.apellido_materno) AS nombre, $rol2 as id_rol, CASE WHEN pl.id_plan = 66 THEN 'TI Comisión' ELSE 'Director Regional' END detail_rol, 

            CASE WHEN pl.id_plan = 66 THEN 9 ELSE 2 END rolVal

            FROM clientes cA 
            $joinLotes  
            INNER JOIN plan_comision pl ON pl.id_plan = cA.plan_comision and pl.regional not in (0)
            INNER JOIN usuarios u1 ON u1.id_usuario = $innerReg
            WHERE cA.id_cliente = @idCliente)
            $addCondition
            ORDER BY rolVal");
        
    }
    
    public function GetUserMktd($estatus,$f1,$f2){
        $complemento = '';
        if($f1 != 0){
            $complemento = "AND CAST(pcm.fecha_abono as date) >= CAST('$f1' AS date) AND CAST(pcm.fecha_abono as date) <= CAST('$f2' AS date)";
        }

        return  $respuesta = $this->db->query("select u.id_usuario,CONCAT(u.nombre, ' ', u.apellido_paterno, ' ',  u.apellido_paterno) as nombre,sum(pcm.abono_marketing) as comision
        FROM pago_comision_mktd pcm 
        INNER JOIN usuarios u on u.id_usuario=pcm.id_usuario 
        WHERE pcm.estatus in($estatus) $complemento
        GROUP BY u.id_usuario,u.nombre,u.apellido_paterno,u.apellido_materno");
    }

    public function getComisionesPagadas($user,$f1,$f2){
        $complemento = '';
        if($f1 != 0){
            $complemento = "AND CAST(pcm.fecha_abono as date) >= CAST('$f1' AS date) AND CAST(pcm.fecha_abono as date) <= CAST('$f2' AS date)";
        }
        return  $respuesta = $this->db->query("select sum(abono_marketing) as pagado_mktd
        FROM pago_comision_mktd pcm 
        INNER JOIN usuarios u on u.id_usuario=pcm.id_usuario 
        WHERE pcm.estatus in(11) and pcm.id_usuario=$user $complemento "); 
    }

    public function getBonosPagados($user,$comentario,$f1,$f2){
        return $this->db->query("select sum(abono) as pagado from pagos_bonos_ind pc inner join bonos b on pc.id_bono=b.id_bono where pc.id_usuario=$user and pc.estado=3 and b.comentario like '%$comentario%' "); 
    }

    public function getBonoXUser($user,$comentario,$estatus,$f1,$f2){
        $complemento='';
        if($estatus == 3){
            $complemento = "AND CAST(d.fecha_abono_intmex as date) >= CAST('$f1' AS date) AND CAST(d.fecha_abono_intmex as date) <= CAST('$f2' AS date)";
        }
        
        return  $respuesta = $this->db->query("select sed.id_sede,sed.impuesto,u.forma_pago,p.id_bono,p.id_usuario,p.num_pagos,d.n_p,CAST(p.comentario AS NVARCHAR(4000)),d.abono,(CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*p.pago) ELSE p.pago END) impuesto1,
        (select sum(monto) from bonos where id_usuario=$user and comentario like '%$comentario%') as monto,
        (select sum(abono) from pagos_bonos_ind pc inner join bonos b on pc.id_bono=b.id_bono where pc.id_usuario=$user and pc.estado=3 and b.comentario like '%$comentario%') as pagado
        FROM bonos p 
        LEFT JOIN pagos_bonos_ind d ON d.id_bono=p.id_bono
        INNER JOIN usuarios u ON u.id_usuario=p.id_usuario 
        inner join opcs_x_cats opcx on opcx.id_opcion=u.id_rol
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = u.forma_pago AND oxc.id_catalogo = 16
        LEFT JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario 
        WHEN 2 THEN 2 
        WHEN 3 THEN 2 
        WHEN 1980 THEN 2 
        WHEN 1981 THEN 2 
        WHEN 1982 THEN 2 
        WHEN 1988 THEN 2 
        WHEN 4 THEN 5
        WHEN 5 THEN 3
        WHEN 607 THEN 1 
        WHEN 7092 THEN 4
        WHEN 9629 THEN 2
        ELSE u.id_sede END) and sed.estatus = 1
        WHERE p.estatus in(1,2) and opcx.id_catalogo=1 and p.id_usuario=$user and d.estado in($estatus) and p.comentario like '%$comentario%' $complemento
        GROUP BY sed.id_sede,sed.impuesto,u.forma_pago,p.id_bono,p.id_usuario,p.num_pagos,d.n_p,CAST(p.comentario AS NVARCHAR(4000)),d.abono,u.forma_pago,p.pago,sed.impuesto
        order by d.n_p asc");
    }

    function getDatosNuevasMontos($proyecto,$condominio){
        $filtro = " pci1.estatus IN (1) AND com.id_usuario = $condominio ";
        return $this->db->query("(SELECT pci1.id_pago_i, pci1.id_comision,  (CASE WHEN com.ooam = 2 THEN CONCAT(lo.nombreLote,' <i>(',com.loteReubicado,')</i>') ELSE lo.nombreLote END) lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario, pci1.id_usuario, CASE WHEN cl.estructura = 1 THEN oprol2.nombre ELSE oprol.nombre END as puesto, pac.porcentaje_abono,(CASE WHEN com.ooam = 1 THEN  CONCAT(oxcest.nombre,' (OOAM)') ELSE oxcest.nombre END) estatus_actual, co.nombre as condominio, lo.referencia, (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, (CASE u.forma_pago WHEN 3 THEN (((sed.impuesto)/100)*pci1.abono_neodata) ELSE 0 END) dcto, sed.impuesto valimpuesto
        FROM pago_comision_ind pci1 
        INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
        INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio 
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial 
        INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 1
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario 
        INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
        INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
        INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
        INNER JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario 
        WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 2 WHEN 4 THEN 5 WHEN 5 THEN 3 WHEN 607 THEN 1 WHEN 7092 THEN 4 WHEN 9629 THEN 2 ELSE u.id_sede END) and sed.estatus = 1
        LEFT JOIN opcs_x_cats oprol2 ON oprol2.id_opcion = com.rol_generado AND oprol2.id_catalogo = 83
        WHERE $filtro AND com.estatus in (1) AND lo.idStatusContratacion > 8
        GROUP BY pci1.id_comision,com.ooam,com.loteReubicado, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex, pci1.id_usuario, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno, u.apellido_materno, oprol.nombre, oxcest.nombre, co.nombre, lo.referencia, sed.impuesto, u.forma_pago, cl.estructura, oprol2.nombre)
        UNION
        (SELECT pci1.id_pago_i, pci1.id_comision,  (CASE WHEN com.ooam = 2 THEN CONCAT(lo.nombreLote,' <i>(',com.loteReubicado,')</i>') ELSE lo.nombreLote END) lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario, pci1.id_usuario, CASE WHEN cl.estructura = 1 THEN oprol2.nombre ELSE oprol.nombre END as puesto, pac.porcentaje_abono, (CASE WHEN com.ooam = 1 THEN  CONCAT(oxcest.nombre,' (OOAM)') ELSE oxcest.nombre END) estatus_actual, co.nombre as condominio, lo.referencia, (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, (CASE u.forma_pago WHEN 3 THEN (((sed.impuesto)/100)*pci1.abono_neodata) ELSE 0 END) dcto, sed.impuesto valimpuesto
        FROM pago_comision_ind pci1 
        INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
        INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial 
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario 
        INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
        INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
        INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
        INNER JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario 
        WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 2 WHEN 4 THEN 5 WHEN 5 THEN 3 WHEN 607 THEN 1 WHEN 7092 THEN 4 WHEN 9629 THEN 2 ELSE u.id_sede END) and sed.estatus = 1
        LEFT JOIN clientes cl ON cl.id_cliente = com.idCliente
        LEFT JOIN opcs_x_cats oprol2 ON oprol2.id_opcion = com.rol_generado AND oprol2.id_catalogo = 83
        WHERE $filtro AND ((lo.idStatusContratacion < 9 AND com.estatus IN (1,8)) OR (lo.idStatusContratacion > 8  AND com.estatus IN (8)))   
        GROUP BY pci1.id_comision,com.ooam,com.loteReubicado, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex, pci1.id_usuario, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno, u.apellido_materno, oprol.nombre, oxcest.nombre, co.nombre, lo.referencia, sed.impuesto, u.forma_pago, cl.estructura, oprol2.nombre)");
    } 

    public function usuarios_nuevas($id_rol, $id_catalogo) {
        return $this->db->query("SELECT id_usuario, CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) AS nombre FROM usuarios WHERE id_usuario in (SELECT id_usuario FROM pago_comision_ind WHERE estatus in (1)) AND estatus in (1, 0, 3) AND id_rol = $id_rol ORDER BY nombre");
    }

    function getPagosByUser($user,$mes,$anio){
        return $this->db-> query("SELECT sum(abono_neodata) as suma from pago_comision_ind  WHERE MONTH(fecha_abono) = '".$mes."' AND YEAR(fecha_abono) = '".$anio."' and id_usuario=".$user." ");   
    }

    function getDescuentosLiquidados(){
        return $this->db->query("SELECT us.estatus as status, SUM(du.monto) as monto, du.id_usuario,CONCAT(us.nombre,' ',us.apellido_paterno,' ',us.apellido_materno) nombre, opc.nombre as puesto, se.id_sede, se.nombre as sede, CONCAT(ua.nombre,' ',ua.apellido_paterno,' ',ua.apellido_materno) creado_por, pci2.abono_pagado, pci3.abono_nuevo, du.pagado_caja, du.pago_individual, du.pagos_activos, du.estatus, (pci2.abono_pagado + du.pagado_caja) aply, CONVERT(varchar,du.fecha_modificacion,23) fecha_creacion
        FROM descuentos_universidad du
        INNER JOIN usuarios us ON us.id_usuario = du.id_usuario
        INNER JOIN usuarios ua ON ua.id_usuario = du.creado_por
        INNER JOIN opcs_x_cats opc ON opc.id_opcion = us.id_rol AND opc.id_catalogo = 1
        LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_usuario FROM pago_comision_ind WHERE estatus in (17) GROUP BY id_usuario) pci2 ON du.id_usuario = pci2.id_usuario
        LEFT JOIN (SELECT SUM(abono_neodata) abono_nuevo, id_usuario FROM pago_comision_ind WHERE estatus in (1) GROUP BY id_usuario) pci3 ON du.id_usuario = pci3.id_usuario 
        LEFT JOIN sedes se ON se.id_sede = us.id_sede
        WHERE du.estatus in (3,4) or (du.estatus in (1,2) and us.estatus in (0,3))
        GROUP BY us.estatus,du.id_usuario, us.nombre, us.apellido_paterno, us.apellido_materno, opc.nombre, se.nombre, ua.nombre, ua.apellido_paterno, ua.apellido_materno,pci2.abono_pagado, pci3.abono_nuevo, se.id_sede, du.pagado_caja, du.pago_individual, du.pagos_activos, du.estatus, du.fecha_modificacion");
    }

    public function getTotalPagoFaltanteUsuario($usuarioId) {
        $result = $this->db->query("SELECT du.id_descuento, (SUM(du.monto) - (pci2.abono_pagado + du.pagado_caja)) as faltante, SUM(du.monto) AS monto_total, du.id_usuario
        FROM descuentos_universidad du
        INNER JOIN usuarios us ON us.id_usuario = du.id_usuario
        LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_usuario FROM pago_comision_ind WHERE estatus in (17) GROUP BY id_usuario) pci2 ON du.id_usuario = pci2.id_usuario
        LEFT JOIN (SELECT SUM(abono_neodata) abono_nuevo, id_usuario FROM pago_comision_ind WHERE estatus in (1) GROUP BY id_usuario) pci3 ON du.id_usuario = pci3.id_usuario 
        LEFT JOIN sedes se ON se.id_sede = us.id_sede
        WHERE du.id_usuario = $usuarioId
        GROUP BY du.id_usuario, pci2.abono_pagado, du.pagado_caja, du.id_descuento");
        return $result->row();
    }

    function porcentajesEspecial($idCliente){
        $query = $this->db->query("(SELECT u1.id_usuario,CONCAT(u1.nombre,' ',u1.apellido_paterno,' ',u1.apellido_materno) AS nombre,id_rol, CASE WHEN cl.estructura = 1 THEN opc2.nombre ELSE opc.nombre END detail_rol, id_rol AS rolVal,0 porcentaje_decimal  
        FROM clientes cl 
        INNER JOIN usuarios u1 ON u1.id_usuario = cl.id_asesor  AND cl.status = 1 
        INNER JOIN opcs_x_cats opc ON opc.id_opcion = u1.id_rol AND opc.id_catalogo = 1
        LEFT JOIN opcs_x_cats opc2 ON opc2.id_opcion = u1.id_rol AND opc2.id_catalogo = 83
        WHERE cl.id_cliente = $idCliente)
        union
        (SELECT u1.id_usuario,CONCAT(u1.nombre,' ',u1.apellido_paterno,' ',u1.apellido_materno) AS nombre,id_rol, CASE WHEN cl.estructura = 1 THEN opc2.nombre ELSE opc.nombre END detail_rol, id_rol AS rolVal,0 porcentaje_decimal  
        FROM clientes cl 
        INNER JOIN usuarios u1 ON u1.id_usuario = cl.id_coordinador  AND cl.status = 1 
        INNER JOIN opcs_x_cats opc ON opc.id_opcion = u1.id_rol AND opc.id_catalogo = 1
        LEFT JOIN opcs_x_cats opc2 ON opc2.id_opcion = u1.id_rol AND opc2.id_catalogo = 83
        WHERE cl.id_cliente = $idCliente)
        union
        (SELECT u1.id_usuario,CONCAT(u1.nombre,' ',u1.apellido_paterno,' ',u1.apellido_materno) AS nombre,id_rol, CASE WHEN cl.estructura = 1 THEN opc2.nombre ELSE opc.nombre END detail_rol , id_rol AS rolVal,0 porcentaje_decimal  
        FROM clientes cl 
        INNER JOIN usuarios u1 ON u1.id_usuario = cl.id_gerente  AND cl.status = 1 
        INNER JOIN opcs_x_cats opc ON opc.id_opcion = u1.id_rol AND opc.id_catalogo = 1
        LEFT JOIN opcs_x_cats opc2 ON opc2.id_opcion = u1.id_rol AND opc2.id_catalogo = 83
        WHERE cl.id_cliente = $idCliente)");
        return $query->result();
    }

    public function getDataDispersionPagoEspecial($val = '') {
        $this->db->query("SET LANGUAGE Español;");
        $query = $this->db->query("SELECT DISTINCT(l.idLote), res.nombreResidencial, cond.nombre as nombreCondominio, l.nombreLote,  
        CONCAT(cl.nombre,' ',cl.apellido_paterno,' ',cl.apellido_materno) nombreCliente, l.tipo_venta, vc.id_cliente AS compartida, l.idStatusContratacion, l.totalNeto2, pc.fecha_modificacion, 
        convert(nvarchar, pc.fecha_modificacion, 6) fecha_sistema, 
        convert(nvarchar, pc.fecha_neodata, 6) fecha_neodata, 
        convert(nvarchar, cl.fechaApartado, 6) fechaApartado, se.nombre as sede, l.registro_comision, l.referencia, cl.id_cliente,
        CONCAT(ae.nombre, ' ', ae.apellido_paterno, ' ', ae.apellido_materno) as asesor,
        CONCAT(co.nombre, ' ', co.apellido_paterno, ' ', co.apellido_materno) as coordinador,
        CONCAT(ge.nombre, ' ', ge.apellido_paterno, ' ', ge.apellido_materno) as gerente,
        CONCAT(su.nombre, ' ', su.apellido_paterno, ' ', su.apellido_materno) as subdirector, 
        (CASE WHEN re.id_usuario IN (0) OR re.id_usuario IS NULL THEN 'NA' ELSE CONCAT(re.nombre, ' ', re.apellido_paterno, ' ', re.apellido_materno) END) regional,
        CONCAT(di.nombre, ' ', di.apellido_paterno, ' ', di.apellido_materno) as director,  (CASE WHEN cl.plan_comision IN (0) OR cl.plan_comision IS NULL THEN '-' ELSE pl.descripcion END) AS plan_descripcion, cl.plan_comision,cl.id_subdirector, cl.id_sede, cl.id_prospecto, cl.lugar_prospeccion
        FROM lotes l
        INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
        INNER JOIN condominios cond ON l.idCondominio=cond.idCondominio
        INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
        INNER JOIN usuarios ae ON ae.id_usuario = cl.id_asesor
        LEFT JOIN pago_comision pc ON pc.id_lote = l.idLote
        LEFT JOIN (SELECT id_cliente FROM ventas_compartidas WHERE estatus = 1) AS vc ON vc.id_cliente = cl.id_cliente
        LEFT JOIN usuarios co ON co.id_usuario = cl.id_coordinador
        LEFT JOIN usuarios ge ON ge.id_usuario = cl.id_gerente
        LEFT JOIN usuarios su ON su.id_usuario = cl.id_subdirector
        LEFT JOIN usuarios re ON re.id_usuario = cl.id_regional
        LEFT JOIN usuarios di ON di.id_usuario = 2
        LEFT JOIN plan_comision pl ON pl.id_plan = cl.plan_comision
        LEFT JOIN sedes se ON se.id_sede = cl.id_sede 
        LEFT JOIN (SELECT idLote, idCliente, MAX(modificado) modificado, idStatusContratacion, idMovimiento FROM historial_lotes WHERE idStatusContratacion = 9 AND idMovimiento = 39 
        GROUP BY idLote, idCliente, idStatusContratacion, idMovimiento) hl ON hl.idLote = l.idLote AND hl.idCliente = l.idCliente
        WHERE ((hl.idStatusContratacion = 9 AND hl.idMovimiento = 39) OR l.idLote IN (7167, 7168, 10304, 15178, 17231, 18338, 18549, 23730, 27250)) AND l.idStatusContratacion >= 9 AND cl.status = 1 AND l.status = 1 AND l.registro_comision in (1) AND pc.bandera in (0) AND tipo_venta IS NOT NULL AND tipo_venta IN (7)
        ORDER BY l.idLote");    
        return $query;
    }

    function getByTypeOU($userType){
        $query = $this->db->query("SELECT * FROM descuentos_universidad du
        INNER JOIN usuarios u ON u.id_usuario = du.id_usuario
        WHERE u.id_rol=".$userType."order by nombre ;");
        return $query->result_array();
    }

    function inforReporteAsesor($id_asesor){
        $query = $this->db->query("SELECT * FROM descuentos_universidad du 
        INNER JOIN pago_comision_ind pci ON du.id_usuario = pci.id_usuario
        INNER JOIN comisiones com ON com.id_comision = pci.id_comision
        INNER JOIN lotes l ON com.id_lote = l.idLote
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
        WHERE pci.estatus=17 AND pci.descuento_aplicado=1 AND com.id_usuario=".$id_asesor);
        return $query->result_array();
    }

    function getDatosFlujoComisiones() {
        return $this->db->query("(SELECT l.idLote,l.nombreLote, l.idStatusContratacion, l.idMovimiento, sl.nombreStatus , 
        CONVERT(varchar,c.fechaApartado,23) as fechaApartado, CONVERT(varchar,p.fecha_creacion,23) as fechaProspecto,
        (CASE WHEN s.nombre is null and c.id_sede is not null THEN 'Sede Cliente' WHEN s.nombre is null and c.id_sede is null THEN 'Sede Asesor' ELSE 'ubicacion 2' end) sedeTOMADA,
        (CASE WHEN s.nombre is null and c.id_sede is not null THEN sc.nombre WHEN s.nombre is null and c.id_sede is null THEN sa.nombre ELSE s.nombre end ) sede,
        CASE WHEN ec.estatus=0 THEN 'EVIDENCIA SIN INTEGRAR' WHEN ec.estatus=1 THEN 'ENVIADA A COBRANZA' WHEN ec.estatus=2 THEN 'ENVIADA A CONTRALORÍA' WHEN ec.estatus=3 THEN 'EVIDENCIA ACEPTADA' WHEN ec.estatus=4 THEN 'SIN ESTATUS REGISTRADO' WHEN ec.estatus=5 THEN 'COBRANZA RECHAZÓ LA EVIDENCIA AL GERENTE' WHEN ec.estatus=6 THEN 'CONTRALORÍA RECHAZÓ LA EVIDENCIA' ELSE 'SIN EVIDENCIA' end  estatus_evidencia,
        CASE WHEN (l.ubicacion_dos in (2,3,4,6) or c.id_sede in (2,3,4,6) or  ase.id_sede in (2,3,4,6) ) THEN 'Plaza 2' WHEN (l.ubicacion_dos in (1,5,8,9) or c.id_sede in (1,5,8,9) or  ase.id_sede in (1,5,8,9) ) THEN 'Plaza 1' ELSE 'SIN ASIGNAR' END plaza, co.comision_total,pci.abono_pagado,(co.comision_total-pci.abono_pagado) as pendiente,
        CASE WHEN co.estatus=1 AND (co.descuento not in (1) or co.descuento is null) THEN 'ACTIVA' WHEN co.estatus=8 THEN 'RECISIÓN' WHEN co.estatus=0 THEN 'BORRADA' WHEN co.descuento in (1) THEN 'TOPADA' ELSE 'SIN IDENTIFICAR' END AS estatus_com,
        CASE WHEN pc.bandera IN (1,55,0) THEN 'LOTE ACTIVO' WHEN pc.bandera IN (7) then 'LOTE LIQUIDADO' WHEN pc.bandera in(8) THEN 'LOTE CANCELADO' ELSE 'SIN IDENTIFICAR' END as estatus_comision_lote,
        CASE WHEN (co.comision_total-pci.abono_pagado)<1 THEN 'LIQUIDADA MKTD' WHEN (co.comision_total-pci.abono_pagado)>1 THEN 'ACTIVA MKTD' ELSE '-' END AS ESTATUS_MKTD,
        CASE WHEN rm.id_lote IS NULL THEN 'MANUAL' ELSE 'AUTOMATICA' END dispersion, co.id_comision,co.id_usuario,
        CASE WHEN co.observaciones like '%IMPORTACION%' THEN concat('IMPORTACION ', co.fecha_creacion) else '' END observaciones 
        FROM lotes l 
        LEFT JOIN clientes c on c.id_cliente=l.idCliente
        LEFT JOIN usuarios ase on ase.id_usuario=c.id_asesor
        LEFT JOIN comisiones co on co.id_lote=l.idLote
        LEFT JOIN sedes s on s.id_sede=l.ubicacion_dos 
        LEFT JOIN sedes sc on sc.id_sede= c.id_sede
        LEFT JOIN sedes sa on sa.id_sede= ase.id_sede
        LEFT JOIN pago_comision pc on pc.id_lote=l.idLote
        LEFT JOIN (SELECT idLote, MAX(fecha_creacion) modificado,estatus FROM evidencia_cliente WHERE estatus_particular=1 GROUP BY idLote,estatus ) ec on ec.idLote=l.idLote
        LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado,id_comision FROM pago_comision_ind WHERE (estatus in (11,3) OR descuento_aplicado = 1) GROUP BY id_comision) pci ON co.id_comision = pci.id_comision
        LEFT JOIN (SELECT id_lote, MAX(fecha_creacion) fecha FROM reportes_marketing GROUP BY id_lote ) rm  on rm.id_lote=l.idLote
        LEFT JOIN prospectos p on p.id_prospecto = c.id_prospecto
        LEFT JOIN statuscontratacion sl ON l.idStatusContratacion = sl.idStatusContratacion
        WHERE co.id_usuario = 4394)
        
        UNION
        
        (SELECT l.idLote,l.nombreLote, l.idStatusContratacion, l.idMovimiento, sl.nombreStatus , 
        CONVERT(varchar,c.fechaApartado,23) as fechaApartado,
        CONVERT(varchar,p.fecha_creacion,23) as fechaProspecto,
        (CASE WHEN s.nombre is null and c.id_sede is not null THEN 'Sede Cliente' WHEN s.nombre is null and c.id_sede is null THEN 'Sede Asesor' ELSE 'ubicacion 2' end ) sedeTOMADA,
        (CASE WHEN s.nombre is null and c.id_sede is not null THEN sc.nombre WHEN s.nombre is null and c.id_sede is null THEN sa.nombre ELSE s.nombre end ) sede,
        CASE WHEN ec.estatus=0 THEN 'EVIDENCIA SIN INTEGRAR' WHEN ec.estatus=1 THEN 'ENVIADA A COBRANZA' WHEN ec.estatus=2 THEN 'ENVIADA A CONTRALORÍA' WHEN ec.estatus=3 THEN 'EVIDENCIA ACEPTADA' WHEN ec.estatus=4 THEN 'SIN ESTATUS REGISTRADO' WHEN ec.estatus=5 THEN 'COBRANZA RECHAZÓ LA EVIDENCIA AL GERENTE' WHEN ec.estatus=6 THEN 'CONTRALORÍA RECHAZÓ LA EVIDENCIA' ELSE 'SIN EVIDENCIA' end  estatus_evidencia,
        CASE WHEN (l.ubicacion_dos in (2,3,4,6) or c.id_sede in (2,3,4,6) or  ase.id_sede in (2,3,4,6) ) THEN 'Plaza 2' WHEN (l.ubicacion_dos in (1,5,8,9) or c.id_sede in (1,5,8,9) or  ase.id_sede in (1,5,8,9) ) THEN 'Plaza 1' ELSE 'SIN ASIGNAR' END plaza, co.comision_total,pci.abono_pagado,(co.comision_total-pci.abono_pagado) as pendiente,
        CASE WHEN co.estatus=1 AND (co.descuento not in (1) or co.descuento is null) THEN 'ACTIVA' WHEN co.estatus=8 THEN 'RECISIÓN' WHEN co.estatus=0 THEN 'BORRADA' WHEN co.descuento in (1) THEN 'TOPADA' ELSE 'SIN IDENTIFICAR' END AS estatus_com,
        CASE WHEN pc.bandera IN (1,55,0) THEN 'LOTE ACTIVO' WHEN pc.bandera IN (7) then 'LOTE LIQUIDADO' WHEN pc.bandera in(8) THEN 'LOTE CANCELADO' ELSE 'SIN IDENTIFICAR' END as estatus_comision_lote,
        CASE WHEN (co.comision_total-pci.abono_pagado)<1 THEN 'LIQUIDADA MKTD' WHEN (co.comision_total-pci.abono_pagado)>1 THEN 'ACTIVA MKTD' ELSE '-' END AS ESTATUS_MKTD,
        CASE WHEN rm.id_lote IS NULL THEN 'MANUAL' ELSE 'AUTOMATICA' END dispersion, co.id_comision,co.id_usuario,
        CASE WHEN co.observaciones like '%IMPORTACION%' THEN concat('IMPORTACION ', co.fecha_creacion) else '' END observaciones 
        FROM lotes l 
        inner JOIN clientes c on c.id_cliente=l.idCliente 
        LEFT JOIN usuarios ase on ase.id_usuario=c.id_asesor
        LEFT JOIN sedes s on s.id_sede=l.ubicacion_dos 
        LEFT JOIN sedes sc on sc.id_sede= c.id_sede
        LEFT JOIN sedes sa on sa.id_sede= ase.id_sede
        INNER JOIN comisiones co on co.id_lote=l.idLote and co.id_usuario=4394 
        INNER JOIN pago_comision pc on pc.id_lote=l.idLote
        LEFT JOIN (SELECT idLote, MAX(fecha_creacion) modificado,estatus,idCliente FROM evidencia_cliente WHERE estatus_particular=1 GROUP BY idLote,estatus,idCliente ) ec on ec.idLote=l.idLote -- and ec.idCliente=c.id_cliente  --evidencia_cliente ec on ec.idLote=l.idLote and ec.idCliente=c.id_cliente
        LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado,id_comision FROM pago_comision_ind WHERE (estatus in (11,3) OR descuento_aplicado = 1) GROUP BY id_comision) pci ON co.id_comision = pci.id_comision
        LEFT JOIN (SELECT id_lote, MAX(fecha_creacion) fecha FROM reportes_marketing GROUP BY id_lote ) rm  on rm.id_lote=l.idLote
        LEFT JOIN prospectos p on p.id_prospecto = c.id_prospecto
        LEFT JOIN statuscontratacion sl ON l.idStatusContratacion = sl.idStatusContratacion
        WHERE  c.lugar_prospeccion NOT in(6,29) and c.descuento_mdb != 1)");

    }

    public function getStoppedCommissions()
    {
        $query = $this->db->query("SELECT DISTINCT(l.idLote), res.nombreResidencial, cond.nombre as nombreCondominio, l.nombreLote, l.tipo_venta, vc.id_cliente AS compartida, l.idStatusContratacion, hl.motivo, hl.comentario,l.totalNeto2, l.registro_comision, convert(nvarchar, pc.fecha_modificacion, 6)  fecha_sistema, convert(nvarchar, pc.fecha_neodata, 6) fecha_neodata, (CASE WHEN cl.plan_comision IN (0) OR cl.plan_comision IS NULL THEN '-' ELSE pl.descripcion END) AS plan_descripcion ,oxc.nombre as motivoOpc
        FROM lotes l 
        INNER JOIN clientes cl ON cl.id_cliente = l.idCliente AND cl.status = 1 
        INNER JOIN condominios cond ON l.idCondominio=cond.idCondominio 
        INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
        INNER JOIN historial_log hl ON hl.identificador = l.idLote AND hl.tabla = 'pago_comision' AND hl.estatus = 1
        LEFT JOIN ventas_compartidas vc ON vc.id_cliente = cl.id_cliente AND vc.estatus = 1
        LEFT JOIN plan_comision pl ON pl.id_plan = cl.plan_comision
        LEFT JOIN pago_comision pc ON pc.id_lote = l.idLote AND pc.bandera in (0)
        LEFT JOIN opcs_x_cats oxc ON oxc.id_catalogo = 88 and oxc.id_opcion = TRY_CAST( hl.motivo AS BIGINT)
        WHERE l.idStatusContratacion BETWEEN 9 AND 15 AND l.status = 1 AND l.registro_comision in (10,11,18) AND l.tipo_venta IS NOT NULL AND l.tipo_venta IN (1,2,7)
        ORDER BY l.idLote");
        return $query->result();
    }

    public function massiveUpdateEstatusComisionInd($idPagos, $estatus)
    {
        return $this->db->query("UPDATE pago_comision_ind SET estatus = $estatus WHERE id_pago_i IN ($idPagos)");
    }

    public function getUsersName()
    {
        $result = $this->db->query("SELECT u.id_usuario, CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) as name_user FROM usuarios u");
        return $result->result_array();
    }

    public function getPuestoByIdOpts($idOpciones)
    {
        return $this->db->query("SELECT * FROM opcs_x_cats WHERE id_catalogo = 1 AND id_opcion IN ($idOpciones)")->result_array();
    }

    public function getGeneralDataPrestamo($idPrestamo)
    {
        $result = $this->db->query("SELECT CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u .apellido_materno) AS nombre_completo, pa.monto as monto_prestado, pa.pago_individual, pa.num_pagos, pa.n_p as num_pago_act, SUM(pci.abono_neodata) as total_pagado, (pa.monto - SUM(pci.abono_neodata)) as pendiente
        FROM prestamos_aut pa
        JOIN usuarios u ON u.id_usuario = pa.id_usuario
        JOIN relacion_pagos_prestamo rpp ON rpp.id_prestamo = pa.id_prestamo
        JOIN pago_comision_ind pci ON pci.id_pago_i = rpp.id_pago_i AND pci.estatus IN(18,19,20,21,22,23,24,25,26,28,29) AND pci.descuento_aplicado = 1
        WHERE pa.id_prestamo = $idPrestamo
        GROUP BY u.nombre, u.apellido_paterno, u.apellido_materno, pa.monto, pa.pago_individual, pa.num_pagos, pa.n_p");
        return $result->row();
    }

    public function getDetailPrestamo($idPrestamo)
    {
        $this->db->query("SET LANGUAGE Español;");
        $result = $this->db->query("SELECT pci.id_pago_i,hc.comentario, l.nombreLote, CONVERT(NVARCHAR, rpp.fecha_creacion, 6) as fecha_pago, pci.abono_neodata, rpp.np,pcs.nombre as tipo,re.nombreResidencial,
        CASE WHEN pa.estatus=1 THEN 'Activo' WHEN pa.estatus=2 THEN 'Liquidado' WHEN pa.estatus=3 THEN 'Liquidado' END AS estatus,sed.nombre as sede
        FROM prestamos_aut pa
        INNER JOIN usuarios u ON u.id_usuario = pa.id_usuario
        INNER JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario 
        WHEN 2 THEN 2 
        WHEN 3 THEN 2 
        WHEN 1980 THEN 2 
        WHEN 1981 THEN 2 
        WHEN 1982 THEN 2 
        WHEN 1988 THEN 2 
        WHEN 4 THEN 5
        WHEN 5 THEN 3
        WHEN 607 THEN 1 
        WHEN 7092 THEN 4
        WHEN 9629 THEN 2
        ELSE u.id_sede END) and sed.estatus = 1
        INNER JOIN opcs_x_cats pcs ON pcs.id_opcion=pa.tipo AND pcs.id_catalogo=23
        INNER JOIN relacion_pagos_prestamo rpp ON rpp.id_prestamo = pa.id_prestamo
        INNER JOIN pago_comision_ind pci ON pci.id_pago_i = rpp.id_pago_i AND pci.estatus IN(18,19,20,21,22,23,24,25,26,28,29) AND pci.descuento_aplicado = 1
        INNER JOIN comisiones c ON c.id_comision = pci.id_comision
        INNER JOIN lotes l ON l.idLote = c.id_lote
        INNER JOIN condominios con ON con.idCondominio=l.idCondominio
        INNER JOIN residenciales re ON re.idResidencial=con.idResidencial
        INNER JOIN historial_comisiones hc ON hc.id_pago_i = rpp.id_pago_i 
        and (hc.comentario like 'DESCUENTO POR%' or hc.comentario like '%, POR MOTIVO DE PRESTAMO' or hc.comentario like '%CONFERENCIA%'or hc.comentario like '%PENALIZACIÓN%' or hc.comentario like '%NOMINA%') and hc.estatus=1
        WHERE pa.id_prestamo = $idPrestamo
        ORDER BY np ASC");
        return $result->result_array();
    }

    public function getPrestamosTable($mes=0, $anio=0)
    {
        $result = $this->db->query("SELECT pci.id_pago_i, pa.id_prestamo, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u .apellido_materno) AS nombre_completo, oxc.nombre as puesto, pa.id_usuario, pa.monto as monto_prestado, pci.abono_neodata, pa.pago_individual, convert(nvarchar, pci.fecha_pago_intmex, 3) fecha_creacion, pa.comentario, lo.nombreLote, rpp.id_relacion_pp, oxc2.nombre as tipo, oxc2.id_opcion, pend.pendiente
        FROM prestamos_aut pa
        JOIN usuarios u ON u.id_usuario = pa.id_usuario
        JOIN relacion_pagos_prestamo rpp ON rpp.id_prestamo = pa.id_prestamo
        JOIN pago_comision_ind pci ON pci.id_pago_i = rpp.id_pago_i 
        JOIN comisiones co ON  pci.id_comision = co.id_comision
        JOIN lotes lo ON lo.idCliente = co.idCliente 
        JOIN opcs_x_cats oxc ON oxc.id_opcion = u.id_rol AND oxc.id_catalogo = 1
        JOIN opcs_x_cats oxc2 ON oxc2.id_opcion = pa.tipo AND oxc2.id_catalogo = 23
        JOIN (SELECT (pa1.monto - SUM(pci1.abono_neodata)) as pendiente, pa1.id_usuario
            FROM prestamos_aut pa1
            JOIN relacion_pagos_prestamo rpp1 ON rpp1.id_prestamo = pa1.id_prestamo
            JOIN pago_comision_ind pci1 ON pci1.id_pago_i = rpp1.id_pago_i 
            GROUP BY pa1.monto, pa1.id_usuario) pend ON pend.id_usuario = pa.id_usuario AND pci.estatus in(18,19,20,21,22,23,24,25,26,28,29) AND pci.descuento_aplicado = 1
        WHERE MONTH(pci.fecha_pago_intmex) = $mes AND YEAR(pci.fecha_pago_intmex) = $anio
        GROUP BY pci.id_pago_i, pa.id_prestamo, u.nombre, u.apellido_paterno, u .apellido_materno, lo.nombreLote, oxc.nombre, pa.id_usuario, pa.monto, pci.abono_neodata, pa.pago_individual,pci.fecha_pago_intmex, pa.comentario, rpp.id_relacion_pp,oxc2.nombre, oxc2.id_opcion, pend.pendiente
        ORDER BY pa.id_usuario ASC, pa.id_prestamo ASC");
        return $result->result_array();
    }

    function lista_estatus_descuentos(){
        return $this->db->query(" SELECT * FROM opcs_x_cats where id_catalogo=23 and id_opcion in(18,19,20,21,22,23,24,25,26,29)");
    }

    public function updatePagoReactivadoMismoDiaMes($idDescuento, $fecha){
        return $this->db->query("UPDATE descuentos_universidad SET estatus = 1, fecha_modificacion = '$fecha', pagos_activos = 1 WHERE id_descuento = $idDescuento");
    }

    public function updatePagoReactivadoMismoMes($idDescuento, $fecha){
        return $this->db->query("UPDATE descuentos_universidad SET estatus = 1, fecha_modificacion = '$fecha', pagos_activos = 0 WHERE id_descuento = $idDescuento");
    }

    public function updatePagoReactivadoFechaDiferente($idDescuento, $fecha){
        return $this->db->query("UPDATE descuentos_universidad SET estatus = 5, fecha_modificacion = '$fecha', pagos_activos = 0 WHERE id_descuento = $idDescuento");
    }

    public function getUsuariosByComisionesAsistentes($idUsuarioSelect, $proyecto, $estatus)
    {
        $usuarioWhereClause = "u.id_usuario = $idUsuarioSelect";
        $proyectoWhereClause = '';
        if ($proyecto !== '0') {
            $proyectoWhereClause = "AND re.idResidencial = $proyecto";
        }

        $estatusWhereClause = '';
        switch ($estatus) {
            case '1':
                $estatusWhereClause = "AND pci1.estatus IN (1,2,41,42,51,52,61,62) AND (pci1.descuento_aplicado is null or pci1.descuento_aplicado = 0)";
                break;
            case '2':
                $estatusWhereClause = "AND pci1.estatus IN (4,13) AND (pci1.descuento_aplicado is null or pci1.descuento_aplicado = 0)";
                break;
            case '3':
                $estatusWhereClause = "AND pci1.estatus IN (8,88) AND (pci1.descuento_aplicado is null or pci1.descuento_aplicado = 0)";
                break;
            case '4':
                $estatusWhereClause = "AND pci1.estatus IN (6) AND (pci1.descuento_aplicado is null or pci1.descuento_aplicado = 0)";
                break;
            case '5':
                $estatusWhereClause = "AND pci1.estatus IN (11,16,17,0) AND pci1.descuento_aplicado = 1";
                break;
            case '7':
                $estatusWhereClause = "AND pci1.estatus IN (11,12) AND (pci1.descuento_aplicado is null or pci1.descuento_aplicado = 0)";
                break;
        }

        $query = $this->db->query("(SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote, re.nombreResidencial as proyecto, co.nombre as condominio,lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, pci1.estatus, pci1.fecha_abono fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) user_names ,pci1.id_usuario, oprol.nombre as puesto, (CASE WHEN com.ooam = 1 THEN  CONCAT(oxcest.nombre,' (OOAM)') ELSE oxcest.nombre END) estatus_actual, oxcest.id_opcion id_estatus_actual, pci1.descuento_aplicado, 0 lugar_prospeccion, lo.referencia, pac.bonificacion, u.estatus as activo
            FROM pago_comision_ind pci1 
            LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE (estatus in (11,3) OR descuento_aplicado = 1) GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
            INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
            INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
            INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
            INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
            INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
            INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
            INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23    
            WHERE (((pci1.estatus IN (1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 51, 52, 88, 16, 17, 41, 42)) OR (pci1.estatus = 0 AND pci1.descuento_aplicado = 1) ) AND ( (lo.idStatusContratacion < 9 AND com.estatus IN (1,8)) OR (lo.idStatusContratacion > 8 AND com.estatus IN (8))) AND $usuarioWhereClause $proyectoWhereClause $estatusWhereClause)
            GROUP BY pci1.id_comision,com.ooam, lo.nombreLote, re.nombreResidencial, co.nombre, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, pci1.id_pago_i, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, pci1.descuento_aplicado, lo.referencia, com.estatus, pac.bonificacion, u.estatus)
            UNION 
            (SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote, re.nombreResidencial as proyecto, co.nombre as condominio,lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, pci1.estatus, pci1.fecha_abono fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) user_names ,pci1.id_usuario, oprol.nombre as puesto, (CASE WHEN com.ooam = 1 THEN  CONCAT(oxcest.nombre,' (OOAM)') ELSE oxcest.nombre END) estatus_actual, oxcest.id_opcion id_estatus_actual, pci1.descuento_aplicado, cl.lugar_prospeccion, lo.referencia, pac.bonificacion, u.estatus as activo
            FROM pago_comision_ind pci1 
            LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE (estatus in (11,3) OR descuento_aplicado = 1) 
            GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
            INNER JOIN comisiones com ON pci1.id_comision = com.id_comision AND com.estatus in (1)
            INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
            INNER JOIN residenciales re ON re.idResidencial = co.idResidencial 
            INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 1
            INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
            INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
            INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
            INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23
            WHERE ((pci1.estatus IN (1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 51, 52, 88,16,17, 41,42) OR (pci1.estatus = 0 AND pci1.descuento_aplicado = 1) AND lo.idStatusContratacion > 8) AND $usuarioWhereClause $proyectoWhereClause $estatusWhereClause)
            GROUP BY pci1.id_comision,com.ooam, lo.nombreLote, re.nombreResidencial, co.nombre, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, pci1.id_pago_i, u.nombre, u.apellido_paterno, u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, pci1.descuento_aplicado, cl.lugar_prospeccion, lo.referencia, com.estatus, pac.bonificacion, u.estatus)
            ORDER BY lo.nombreLote");

        return $query->result_array();
    }

    public function findUsuariosByPuestoAsistente($puesto, $id_lider, $id_usuario) {
        if ($id_usuario == 12449)  
            $id_lider .= ", 654";
        else if ($id_usuario == 10270)  
            $id_lider .= ", 113";
        $puestoWhereClause = '';
        if ($puesto === '3') 
            $puestoWhereClause = "id_usuario IN ($id_lider)";
        else if ($puesto === '9') 
            $puestoWhereClause = "id_lider IN ($id_lider) AND id_rol = 9";
        else if ($puesto === '7')  
            $puestoWhereClause = "id_lider IN (SELECT id_usuario FROM usuarios WHERE id_lider IN ($id_lider) AND id_rol IN (7,9)) OR (id_lider IN ($id_lider) AND id_rol IN (7,9))";
        return $this->db->query("SELECT id_usuario, CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) nombre_completo FROM usuarios WHERE $puestoWhereClause ORDER BY nombre_completo")->result_array();
    }

    public function findAllResidenciales() {
        $query = $this->db->query('SELECT idResidencial, nombreResidencial, descripcion 
        FROM residenciales
        WHERE active_comission = 1');
        return $query->result_array();
    }

    public function getOpcionCatByIdCatAndIdOpt($idCatalogo, $idOpciones) {
        $query = $this->db->query("SELECT id_opcion, id_catalogo, nombre 
        FROM opcs_x_cats 
        WHERE id_catalogo = $idCatalogo AND id_opcion IN ($idOpciones)");
        return $query->result_array();
    }

    public function getHistorialPrestamoAut($idRelacion) {
        $result = $this->db->query("SELECT pa.id_prestamo, rpp.id_pago_i, hc.comentario, CONVERT(NVARCHAR(20), hc.fecha_movimiento, 113) fecha, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre_usuario, rpp.id_relacion_pp
        FROM prestamos_aut pa
        JOIN relacion_pagos_prestamo rpp ON pa.id_prestamo = rpp.id_prestamo
        JOIN historial_comisiones hc ON rpp.id_pago_i = hc.id_pago_i
        JOIN usuarios u ON u.id_usuario = hc.id_usuario
        WHERE rpp.id_relacion_pp = $idRelacion
        ORDER BY hc.fecha_movimiento DESC");
        return $result->result_array();
    }

    public function getUserPrestamoByRol($rol) {
        $result = $this->db->query("SELECT u.id_usuario, CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) as name_user 
        FROM usuarios u
        JOIN prestamos_aut pa ON u.id_usuario = pa.id_usuario
        WHERE id_rol = $rol");
        return $result->result_array();
    }
 
    public function getPlanesComisiones() {
        $query = $this->db->query('SELECT id_plan, descripcion FROM plan_comision WHERE estatus = 1');
        return $query->result_array();
    }

    public function getDetallePlanesComisiones($idPlan)
    {
        $query = $this->db->query("SELECT pc.id_plan, pc.descripcion, pc.comDi, pc.neoDi, rolDir.nombre AS director,  pc.comRe, pc.neoRe, 'Regional' AS regional, pc.comSu, pc.neoSu, 'Subdirector' AS subdirector, pc.comGe, pc.neoGe, rolGer.nombre AS gerente, pc.comCo, pc.neoCo, rolCoor.nombre AS coordinador, pc.comAs, pc.neoAs, rolAse.nombre AS asesor, pc.comMk, pc.neoMk, rolMkt.nombre AS mktd, pc.comOt, pc.neoOt, (CASE WHEN pc.id_o IS NOT NULL THEN CONCAT(usOtr.nombre, ' ', usOtr.apellido_paterno, ' ',usOtr.apellido_materno, ' ') ELSE rolOtr.nombre END) AS otro, pc.comOt2, pc.neoOt2, (CASE WHEN pc.id_o2 IS NOT NULL THEN CONCAT(usOtr2.nombre, ' ', usOtr2.apellido_paterno, ' ',usOtr2.apellido_materno, ' ') ELSE rolOtr2.nombre END) AS otro2
            FROM plan_comision pc
            LEFT JOIN opcs_x_cats rolDir ON rolDir.id_opcion = pc.director AND rolDir.id_catalogo = 1
            LEFT JOIN opcs_x_cats rolReg ON rolReg.id_opcion = pc.regional AND rolReg.id_catalogo = 1
            LEFT JOIN opcs_x_cats rolSubdir ON rolSubdir.id_opcion = pc.subdirector AND rolSubdir.id_catalogo = 1
            LEFT JOIN opcs_x_cats rolGer ON rolGer.id_opcion = pc.gerente AND rolGer.id_catalogo = 1
            LEFT JOIN opcs_x_cats rolCoor ON rolCoor.id_opcion = pc.coordinador AND rolCoor.id_catalogo = 1
            LEFT JOIN opcs_x_cats rolAse ON rolAse.id_opcion = pc.asesor AND rolAse.id_catalogo = 1
            LEFT JOIN usuarios usOtr ON usOtr.id_usuario = pc.id_o 
            LEFT JOIN opcs_x_cats rolOtr ON rolOtr.id_opcion = usOtr.id_rol AND rolOtr.id_catalogo = 1
            LEFT JOIN opcs_x_cats rolMkt ON rolMkt.id_opcion = pc.mktd AND rolMkt.id_catalogo = 1
            LEFT JOIN usuarios usOtr2 ON usOtr2.id_usuario = pc.id_o2 
            LEFT JOIN opcs_x_cats rolOtr2 ON rolOtr2.id_opcion = usOtr2.id_rol AND rolOtr2.id_catalogo = 1
            WHERE pc.id_plan = $idPlan");
        return $query->row();
    }

    public function getVentasCanceladas()
    {
        $query = $this->db->query("(SELECT l.idLote, l.nombreLote, SUM(c.comision_total) AS comision_total, CONCAT(cl.nombre,' ',cl.apellido_paterno,' ',cl.apellido_materno) nombre_cliente, (CASE WHEN cl.plan_comision IN (0) OR cl.plan_comision IS NULL THEN '-' ELSE pl.descripcion END)  AS plan_descripcion, 0 AS idCliente, re.nombreResidencial, l.referencia
        FROM comisiones c
        LEFT JOIN clientes cl ON cl.id_cliente = c.idCliente
        LEFT JOIN plan_comision pl ON pl.id_plan = cl.plan_comision
        JOIN lotes l ON l.idLote = c.id_lote
        INNER JOIN condominios cd on cd.idCondominio=l.idCondominio
        INNER JOIN residenciales re on re.idResidencial=cd.idResidencial
        WHERE l.status = 1 AND c.estatus IN (8) AND c.id_usuario NOT IN (0) AND c.idCliente IS NULL
        GROUP BY l.idLote, l.nombreLote, cl.nombre, cl.apellido_paterno, cl.apellido_materno, cl.plan_comision, pl.descripcion,  re.nombreResidencial,l.referencia, c.idCliente
        UNION
        SELECT l.idLote, l.nombreLote, SUM(c.comision_total) AS comision_total, CONCAT(cl.nombre,' ',cl.apellido_paterno,' ',cl.apellido_materno) nombre_cliente, (CASE WHEN cl.plan_comision IN (0) OR cl.plan_comision IS NULL THEN '-' ELSE pl.descripcion END) AS plan_descripcion, c.idCliente, re.nombreResidencial,l.referencia
        FROM comisiones c
        JOIN clientes cl ON cl.id_cliente = c.idCliente
        LEFT JOIN plan_comision pl ON pl.id_plan = cl.plan_comision
        JOIN lotes l ON l.idLote = c.id_lote
        INNER JOIN condominios cd on cd.idCondominio=l.idCondominio
        INNER JOIN residenciales re on re.idResidencial= cd.idResidencial
        WHERE l.status = 1 AND c.estatus IN (8) AND c.id_usuario NOT IN (0) AND c.idCliente IS NOT NULL
        GROUP BY l.idLote, l.nombreLote, cl.nombre, cl.apellido_paterno, cl.apellido_materno, cl.plan_comision, pl.descripcion,  re.nombreResidencial,l.referencia, c.idCliente)
        ORDER BY l.idLote ASC");
        return $query->result_array();
    }

    public function getVentCanceladaSuma($idLote, $idCliente)
    {
        $clienteWhereClause = '';
        if ($idCliente === '0') {
            $clienteWhereClause = 'c1.idCliente IS NULL';
        } else {
            $clienteWhereClause = "c1.idCliente = $idCliente";
        }
        $query = $this->db->query("SELECT SUM(c1.comision_total) comision_total, (SELECT SUM(abono_neodata) FROM pago_comision_ind WHERE id_comision IN (SELECT id_comision FROM comisiones WHERE id_lote = $idLote AND estatus = 8)) AS abonado, lo.nombreLote
        FROM lotes lo
        INNER JOIN comisiones c1 ON lo.idLote = c1.id_lote AND c1.estatus = 8
        WHERE lo.idLote = $idLote AND $clienteWhereClause
        GROUP BY lo.idLote, lo.nombreLote");
        return $query->row();
    }

    public function getVentaCanceladaDetalle($idLote, $idCliente) {
        $clienteWhereClause = '';
        if ($idCliente === '0')
            $clienteWhereClause = 'com.idCliente IS NULL';
        else
            $clienteWhereClause = "com.idCliente = $idCliente";
        
        $query = $this->db->query("SELECT com.id_comision, com.id_usuario, lo.totalNeto2, lo.idLote, res.idResidencial,  lo.referencia, lo.tipo_venta, com.id_lote, lo.nombreLote, com.porcentaje_decimal, CONCAT(us.nombre,' ' , us.apellido_paterno,' ',us.apellido_materno) colaborador, CASE WHEN cl.estructura = 1 THEN oxc2.nombre ELSE oxc.nombre END as rol, com.comision_total,  pci.abono_pagado, com.rol_generado, com.descuento
        FROM comisiones com
        LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE (estatus in (11,3) OR descuento_aplicado = 1) GROUP BY id_comision) pci ON pci.id_comision = com.id_comision
        INNER JOIN lotes lo ON lo.idLote = com.id_lote 
        INNER JOIN usuarios us ON us.id_usuario = com.id_usuario
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = com.rol_generado AND oxc.id_catalogo = 1
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio
        INNER JOIN residenciales res ON res.idResidencial = con.idResidencial
        LEFT JOIN clientes cl ON cl.id_cliente = com.idCliente
        LEFT JOIN opcs_x_cats oxc2 ON oxc2.id_opcion = com.rol_generado AND oxc2.id_catalogo = 83
        WHERE com.id_lote = $idLote AND com.estatus = 8 AND $clienteWhereClause 
        ORDER BY com.rol_generado ASC");
        return $query->result_array();
    }

    function updateBandera($id_pagoc, $param) {
        $response = $this->db->query("UPDATE pago_comision SET bandera = ".$param." WHERE id_lote IN (".$id_pagoc.")");

       if($param == 55){
         $response = $this->db->query("UPDATE lotes SET registro_comision = 1 WHERE idLote IN (".$id_pagoc.")");
       }

       if (! $response ) {
           return $finalAnswer = 0;
       } else {
           return $finalAnswer = 1;
       }
   }

    public function updateBanderaDetenida($idLote, $updateHistorial, $nuevoRegistroComision = FALSE  )
    {

        var_dump($nuevoRegistroComision);
        if($nuevoRegistroComision >= 0 ) {
            if ($updateHistorial) {
                $this->db->query("UPDATE lotes SET registro_comision = $nuevoRegistroComision, modificado=".$this->session->userdata('id_usuario')." WHERE idLote = $idLote");
                return (bool)($this->db->query("UPDATE historial_log SET estatus = 0 WHERE tabla = 'pago_comision' AND estatus = 1 AND identificador = $idLote"));
            } else {
                return (bool)($this->db->query("UPDATE lotes SET registro_comision = $nuevoRegistroComision, modificado=".$this->session->userdata('id_usuario')." WHERE idLote = $idLote"));
            }
        }else {
            return 'error';
        }
    }

    public function insertHistorialLog($idLote, $idUsuario, $estatus, $comentario, $tabla, $motivo){
        $cmd = "INSERT INTO historial_log ". "VALUES ($idLote, $idUsuario, GETDATE(), $estatus, '$comentario', '$tabla', '$motivo')";
        return (bool)($this->db->query($cmd));
    }

    public function getFormasPago() {
        $query = $this->db->query("SELECT id_opcion, nombre, estatus FROM opcs_x_cats WHERE id_catalogo = 16");
        return $query->result_array();
    }

    public function getTotalComisionAsesor($idUsuario) {
        $query = $this->db->query("SELECT SUM(pci.abono_neodata) AS total
        FROM pago_comision_ind pci 
        INNER JOIN comisiones com ON pci.id_comision = com.id_comision 
        where pci.estatus = 1 and com.id_usuario = $idUsuario");
        return $query->row();
    }

    public function changeEstatusOpinion($idUsuario)
    {
        $this->db->query("UPDATE opinion_cumplimiento SET estatus = 2 WHERE estatus = 1 AND id_usuario = $idUsuario");
    }

    public function findOpinionActiveByIdUsuario($idUsuario)
    {
        $query = $this->db->query("SELECT id_opn, id_usuario, archivo_name FROM opinion_cumplimiento WHERE estatus = 1 AND id_usuario = $idUsuario");
        return $query->row();
    }

    public function getListaEstatusHistorialEstatus()
    {
        $query = $this->db->query("SELECT 1 AS idEstatus, 'NUEVAS' as nombre union
        SELECT 2 AS idEstatus, 'REVISION CONTRALORIA' as nombre union
        SELECT 3 AS idEstatus, 'INTERNOMEX' as nombre union
        SELECT 4 AS idEstatus, 'PAUSADAS' as nombre union
        SELECT 5 AS idEstatus, 'DESCUENTOS' as nombre union
        SELECT 6 AS idEstatus, 'RESGUARDOS' as nombre union
        SELECT 7 AS idEstatus, 'PAGADAS' as nombre union
        SELECT 8 AS idEstatus, 'VENTAS ESPECIALES' as nombre union
        SELECT 9 AS idEstatus, 'RECISIONES'");
        return $query->result_array();
    }
    
    public function getComprobantesExtranjero()
    {
        $query = $this->db->query("SELECT sum(pci1.abono_neodata) total, u.id_usuario, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) usuario, fp.nombre as forma_pago, na.nombre as nacionalidad, opn.estatus estatus_archivo, opn.archivo_name, estatus.nombre as estatus_usuario, u.rfc
        FROM pago_comision_ind pci1
        INNER JOIN comisiones com ON pci1.id_comision = com.id_comision AND com.estatus in (1,8)
        INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (5)
        INNER JOIN opcs_x_cats na ON na.id_opcion = u.nacionalidad AND na.id_catalogo = 11
        INNER JOIN opinion_cumplimiento opn ON opn.id_usuario = u.id_usuario and opn.estatus IN (2)
        INNER JOIN opcs_x_cats fp ON fp.id_opcion = u.forma_pago AND fp.id_catalogo = 16
        INNER JOIN opcs_x_cats estatus ON estatus.id_opcion = u.estatus AND estatus.id_catalogo = 3
        INNER JOIN pagos_invoice iv ON iv.id_pago_i = pci1.id_pago_i
        WHERE pci1.estatus in (4,8,88)
        GROUP BY opn.archivo_name, u.nombre, u.apellido_paterno, u.apellido_materno, u.id_usuario, u.forma_pago, opn.estatus, na.nombre, fp.nombre, estatus.nombre, u.rfc
        ORDER BY u.nombre");
        return $query->result_array();
    }

    function getDatosNuevasEContraloria($proyecto,$condominio){
        if( $this->session->userdata('id_rol') == 31 ){
            $filtro = " pci1.estatus IN (8,88) AND com.id_usuario = $condominio ";
            return $this->db->query("(SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto,lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata,pci1.estatus, pci1.fecha_pago_intmex fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario ,pci1.id_usuario, oprol.nombre as puesto, 0 personalidad_juridica, u.forma_pago, 0 as factura, pac.porcentaje_abono, (CASE WHEN com.ooam = 1 THEN  CONCAT(oxcest.nombre,' (OOAM)') ELSE oxcest.nombre END) estatus_actual,oxcest.id_opcion id_estatus_actual, re.empresa, 0 lugar_prospeccion, co.nombre as condominio, lo.referencia, pci1.abono_neodata impuesto, 0 dcto, u.rfc
            FROM pago_comision_ind pci1 
            INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
            INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio 
            INNER JOIN residenciales re ON re.idResidencial = co.idResidencial 
            INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 1
            INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (5)
            INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
            INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
            INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
            WHERE $filtro AND com.estatus in (1) AND lo.idStatusContratacion > 8
            GROUP BY pci1.id_comision,com.ooam, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex, pci1.id_usuario, u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, co.nombre, lo.referencia, u.rfc)
            UNION
            (SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario ,pci1.id_usuario, oprol.nombre as puesto, 0 personalidad_juridica, u.forma_pago, 0 as factura, pac.porcentaje_abono, (CASE WHEN com.ooam = 1 THEN  CONCAT(oxcest.nombre,' (OOAM)') ELSE oxcest.nombre END) estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, 0 lugar_prospeccion, co.nombre as condominio, lo.referencia, pci1.abono_neodata impuesto, 0 dcto, u.rfc
            FROM pago_comision_ind pci1 
            INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
            INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
            INNER JOIN residenciales re ON re.idResidencial = co.idResidencial 
            INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (5)
            INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
            INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
            INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
            WHERE $filtro AND ( (lo.idStatusContratacion < 9 AND com.estatus IN (1,8)) OR (lo.idStatusContratacion > 8  AND com.estatus IN (8)))   
            GROUP BY pci1.id_comision,com.ooam, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex, pci1.id_usuario, u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, co.nombre, lo.referencia, u.rfc)");
        }else{
            $filtro = " pci1.estatus IN (4) ";
            if($condominio == 0){
                return $this->db->query("(SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario ,pci1.id_usuario, oprol.nombre as puesto, 0 personalidad_juridica, u.forma_pago, 0 as factura, pac.porcentaje_abono, (CASE WHEN com.ooam = 1 THEN  CONCAT(oxcest.nombre,' (OOAM)') ELSE oxcest.nombre END) estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, 0 lugar_prospeccion, co.nombre as condominio, lo.referencia, pci1.abono_neodata impuesto, 0 dcto, u.rfc
                FROM pago_comision_ind pci1 
                INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
                INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                INNER JOIN residenciales re ON re.idResidencial = co.idResidencial AND re.idResidencial = $proyecto 
                INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 1
                INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (5)
                INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
                INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
                WHERE  $filtro AND com.estatus in (1) AND lo.idStatusContratacion > 8
                GROUP BY pci1.id_comision,com.ooam, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex, pci1.id_usuario, u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, co.nombre, lo.referencia, u.rfc)
                UNION
                (SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario ,pci1.id_usuario, oprol.nombre as puesto, 0 personalidad_juridica, u.forma_pago, 0 as factura, pac.porcentaje_abono, (CASE WHEN com.ooam = 1 THEN  CONCAT(oxcest.nombre,' (OOAM)') ELSE oxcest.nombre END) estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, 0 lugar_prospeccion, co.nombre as condominio, lo.referencia, pci1.abono_neodata impuesto, 0 dcto, u.rfc
                FROM pago_comision_ind pci1 
                INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
                INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                INNER JOIN residenciales re ON re.idResidencial = co.idResidencial AND re.idResidencial = $proyecto 
                INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (5)
                INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
                INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
                WHERE  $filtro AND ((lo.idStatusContratacion < 9 AND com.estatus IN (1,8)) OR (lo.idStatusContratacion > 8  AND com.estatus IN (8)))   
                GROUP BY pci1.id_comision,com.ooam, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total,
                com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex,
                pci1.id_usuario, u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno,oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, co.nombre, lo.referencia, u.rfc)");
            }else{
                return $this->db->query("(SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto,lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata,pci1.estatus, pci1.fecha_pago_intmex fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario ,pci1.id_usuario, oprol.nombre as puesto, 0 personalidad_juridica, u.forma_pago, 0 as factura, pac.porcentaje_abono, (CASE WHEN com.ooam = 1 THEN  CONCAT(oxcest.nombre,' (OOAM)') ELSE oxcest.nombre END) estatus_actual,oxcest.id_opcion id_estatus_actual, re.empresa, 0 lugar_prospeccion, co.nombre as condominio, lo.referencia, pci1.abono_neodata impuesto, 0 dcto, u.rfc
                FROM pago_comision_ind pci1 
                INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
                INNER JOIN condominios co ON co.idCondominio = lo.idCondominio AND co.idCondominio  = $condominio 
                INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 1
                INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (4)
                INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
                INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
                WHERE  $filtro AND com.estatus in (1) AND lo.idStatusContratacion > 8
                GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex, pci1.id_usuario, u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, co.nombre, lo.referencia, u.rfc)
                UNION
                (SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario ,pci1.id_usuario, oprol.nombre as puesto, 0 personalidad_juridica, u.forma_pago, 0 as factura, pac.porcentaje_abono,(CASE WHEN com.ooam = 1 THEN  CONCAT(oxcest.nombre,' (OOAM)') ELSE oxcest.nombre END) estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, 0 lugar_prospeccion, co.nombre as condominio, lo.referencia, pci1.abono_neodata impuesto, 0 dcto, u.rfc
                FROM pago_comision_ind pci1 
                INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
                INNER JOIN condominios co ON co.idCondominio = lo.idCondominio AND co.idCondominio  = $condominio 
                INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (4)
                INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
                INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
                WHERE  $filtro AND ((lo.idStatusContratacion < 9 AND com.estatus IN (1,8)) OR (lo.idStatusContratacion > 8  AND com.estatus IN (8)))   
                GROUP BY pci1.id_comision,com.ooam, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex, pci1.id_usuario, u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, co.nombre, lo.referencia, u.rfc)");
            }
        }
    }

    function fusionAcLi($estatus='3'){
        switch($estatus) {
            case '1':
                $filtro = ' WHERE du.estatus in (0,1,2,5) AND us.estatus in (1) ';
            break;
            case '2':
                $filtro = ' WHERE du.estatus not in (4,3) AND us.estatus in (0,3) ';
            break;
            case '3':
                $filtro = ' WHERE du.estatus in (4,3) AND us.estatus in (0,1,3) ';
            break;
            case '4':
                $filtro = ' ';
            break;
            default:
                $filtro = '';
        }
        
        $query = $this->db->query("SELECT du.id_descuento, us.estatus as status, SUM(du.monto) as monto, du.id_usuario, UPPER(CONCAT(us.nombre,' ',us.apellido_paterno,' ',us.apellido_materno)) AS nombre, UPPER(opc.nombre) AS puesto,  se.id_sede, UPPER(se.nombre) AS sede, UPPER(CONCAT(ua.nombre,' ',ua.apellido_paterno,' ',ua.apellido_materno)) AS creado_por,  pci2.abono_pagado, pci3.abono_nuevo, du.pagado_caja, du.pago_individual, du.pagos_activos, du.estatus,  opc1.id_opcion as idCertificacion, opc1.nombre as certificacion,  opc1.color as colorCertificacion, (pci2.abono_pagado + du.pagado_caja) aply, CONVERT(varchar,du.fecha_modificacion,23)  fecha_creacion, '1' AS queryType, des.no_descuentos, CONVERT(varchar, mov.fecha_mov, 23) fecha_mov_1
        FROM descuentos_universidad du
        INNER JOIN usuarios us ON us.id_usuario = du.id_usuario
        INNER JOIN usuarios ua ON ua.id_usuario = du.creado_por
        INNER JOIN opcs_x_cats opc ON opc.id_opcion = us.id_rol AND opc.id_catalogo = 1
        LEFT JOIN opcs_x_cats opc1 ON opc1.id_opcion = du.estatus_certificacion AND opc1.id_catalogo = 79
        LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_usuario FROM pago_comision_ind WHERE estatus in (17) GROUP BY id_usuario) pci2 ON du.id_usuario = pci2.id_usuario
        LEFT JOIN (SELECT SUM(abono_neodata) abono_nuevo, id_usuario FROM pago_comision_ind WHERE estatus in (1) GROUP BY id_usuario) pci3 ON du.id_usuario = pci3.id_usuario 
        LEFT JOIN sedes se ON se.id_sede = Try_Cast(us.id_sede  As int)
        LEFT JOIN (SELECT COUNT(DISTINCT(CAST(fecha_abono AS DATE))) no_descuentos, id_usuario FROM pago_comision_ind WHERE estatus = 17 GROUP BY id_usuario) des ON des.id_usuario = du.id_usuario
        LEFT JOIN (SELECT MIN(hc.fecha_movimiento) fecha_mov, pci.id_usuario
        FROM pago_comision_ind pci 
        JOIN historial_comisiones hc ON pci.id_pago_i = hc.id_pago_i AND hc.comentario LIKE '%descuento%'
        WHERE pci.estatus = 17
        GROUP BY pci.id_usuario) mov ON mov.id_usuario = du.id_usuario
        $filtro
        GROUP BY du.id_descuento, us.estatus,du.id_usuario, us.nombre, us.apellido_paterno, us.apellido_materno, opc.nombre,  se.nombre, ua.nombre, ua.apellido_paterno, ua.apellido_materno,pci2.abono_pagado, pci3.abono_nuevo, se.id_sede,  du.pagado_caja, du.pago_individual,opc1.nombre ,opc1.color,opc1.id_opcion ,du.pagos_activos, du.estatus, du.fecha_modificacion, mov.fecha_mov,  des.no_descuentos");
        return $query->result_array();
    }

    function insertar_descuentoch($usuario, $descuento, $comentario, $monto, $userdata){
        $respuesta = $this->db->query("INSERT INTO descuentos_universidad VALUES (".$usuario.", ".$descuento.", 1, 'DESCUENTO UNIVERSIDAD MADERAS', '".$comentario."', ".$userdata.", GETDATE() , 0, ".$monto.", 1, 0, null)");
        $insert_id = $this->db->insert_id();
        $respuesta = $this->db->query("INSERT INTO historial_log VALUES (".$insert_id.", ".$userdata.", GETDATE(), 1, 'MOTIVO DESCUENTO: ".$comentario."', 'descuentos_universidad', null)");
       
        if (! $respuesta ) {
            return 0;
        } else {
            return 1;
        }
    }

    public function eliminarDescuentoUniversidad($idDescuento){
        $this->db->query("DELETE FROM descuentos_universidad WHERE id_descuento = $idDescuento");
    }

    public function obtenerDescuentoUniversidad($idDescuento){
        $query = $this->db->query("SELECT du.id_descuento, du.id_usuario, du.monto, du.pago_individual, CONVERT(INT, (du.monto/du.pago_individual)) AS no_pagos, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) AS usuario
        FROM descuentos_universidad du
        JOIN usuarios u ON du.id_usuario = u.id_usuario
        WHERE id_descuento = $idDescuento");
        return $query->row();
    }

    public function actualizarDescuentoUniversidad($idDescuento, $data) {
        $this->db->query("UPDATE descuentos_universidad SET monto = ".$data['monto'].", pago_individual = ".$data['pago_ind']." WHERE id_descuento = $idDescuento");
    }

    function getInfoReportePagos($query2){
        $cmd = "SELECT pci1.id_pago_i, lo.nombreLote, re.empresa, UPPER(CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno)) AS user_names, 
        pci1.fecha_pago_intmex, pci1.id_usuario, UPPER(oprol.nombre) AS puesto, UPPER(se.nombre) AS sede, 
        his.comentario as creado,   FORMAT(ISNULL(pci1.abono_neodata , '0.00'), 'C') abono
        FROM pago_comision_ind pci1
        INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
        INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario $query2
        INNER JOIN usuarios cr ON cr.id_usuario = pci1.modificado_por
        INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
        INNER JOIN historial_comisiones his ON his.id_pago_i = pci1.id_pago_i AND his.comentario like '%CAPITAL HUMANO CANCELÓ DESCUENTO%'
        LEFT JOIN sedes se ON se.id_sede = (CASE u.id_usuario WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 2 WHEN 4 THEN 5 WHEN 5 THEN 3 WHEN 607 THEN 1 WHEN 7092 THEN 4 WHEN 9629 THEN  ELSE u.id_sede END) and se.estatus = 1";

        $query = $this->db->query($cmd);
        return $query->result_array();
    }

    function descuentos_universidad($clave , $data){
        try {
            $this->db->where('id_descuento', $clave);
            $this->db->update('descuentos_universidad', $data);
            $afftectedRows = $this->db->affected_rows();
            return $afftectedRows > 0 ? TRUE : FALSE ;
        }
        catch(Exception $e) {
            return $e->getMessage();
        }
    }

    public function updatePenalizacion($idLote, $idCliente){
        return (bool)($this->db->query("UPDATE penalizaciones SET bandera = 1 WHERE bandera = 0 AND id_lote = $idLote AND id_cliente = $idCliente"));
    }

    public function updatePenalizacionCancel($idLote, $idCliente) {
        return (bool)($this->db->query("UPDATE penalizaciones SET bandera = 1, estatus = 3 WHERE bandera = 0 AND id_lote = $idLote AND id_cliente = $idCliente"));
    }

    public function updatePenalizacionCuatro($idLote, $idCliente, $a, $c, $g) {
        $penalizacion = $this->db->query("SELECT id_penalizacion FROM penalizaciones WHERE id_lote = $idLote AND id_cliente = $idCliente");
        $this->db->query("INSERT INTO distribucion_penalizaciones values (".$penalizacion->row()->id_penalizacion.",$a,$c,$g,1,($a+$c+$g),1,GETDATE())");
        return (bool)($this->db->query("UPDATE penalizaciones SET bandera = 1 WHERE bandera = 0 AND id_lote = $idLote AND id_cliente = $idCliente"));
    }

    public function insertHistorialComentario($idLote, $idCliente,$comentario) {   
        return (bool)($this->db->query("INSERT INTO historial_log (identificador, id_usuario, fecha_movimiento, estatus, comentario, tabla, motivo) values ($idLote, $idCliente, getdate(), 1, '".$comentario."', 'penalizaciones', '1')"));
    }

    public function insertHistorialCancelado($idLote, $idCliente,$comentario) {   
        return (bool)($this->db->query("INSERT INTO historial_log (identificador, id_usuario, fecha_movimiento, estatus, comentario, tabla, motivo) values ($idLote, $idCliente, getdate(), 1, '".$comentario."', 'penalizaciones', '0')"));
    }

    public function getCertificaciones() {
        $cmd = "SELECT * FROM opcs_x_cats where id_catalogo = 79";
        $query = $this->db->query($cmd);
        return $query->result();
    }

    public function getMotivosControversia() {
        $cmd = "SELECT * FROM opcs_x_cats where id_catalogo = 95  and id_opcion NOT IN (0,1,7)";
        $query = $this->db->query($cmd);
        return $query->result_array();   
    }

    public function updatePrestamosEdit($clave, $data){
        try {
            $this->db->where('id_prestamo', $clave);
            if($this->db->update('prestamos_aut', $data)){
                return TRUE;
            }else{
                return FALSE;
            }
        }
        catch(Exception $e) {
            return $e->getMessage();
        }     
    }

    function UpdateRetiro($datos,$id,$opcion){
        $motivo = '';
        if($opcion == 'Borrar' ||  $opcion == 'Rechazar' ){
            $motivo = $datos['motivodel'];
            $datos = ['estatus' => $datos['estatus']];
        }
     
        $comentario = '';
        $respuesta = $this->db->update("resguardo_conceptos", $datos, " id_rc = $id");
        if($opcion == 'Autorizar'){
            $comentario = 'SE AUTORIZÓ ESTE RETIRO';
        }elseif($opcion == 'Borrar'){
            $comentario = 'SE ELIMINÓ ESTE RETIRO, MOTIVO: '.$motivo;
        }elseif($opcion == 'Rechazar'){
            $comentario = 'SE RECHAZÓ ESTE RETIRO, MOTIVO: '.$motivo;
        }elseif($opcion == 'Actualizar'){
            $comentario = 'SE ACTUALIZÓ RETIRO POR MOTIVO DE: '.$datos["conceptos"].' POR LA CANTIDAD DE: '.$datos["monto"].' ';
        }
        $respuesta = $this->db->query("INSERT INTO  historial_retiros VALUES ($id, ".$this->session->userdata('id_usuario').", GETDATE(), 1, '$comentario')");

        if (! $respuesta ) {
        return 0;
        } else {
        return 1;
        }
    }

    function getDisponbleResguardo($user) {
        $query = $this->db->query("select SUM(abono_neodata) as suma from pago_comision_ind where id_usuario=$user and estatus=3 and id_comision not in(select id_comision from comisiones where estatus=0)");
        return $query;
    }
    function getDisponbleExtras($user) {
        $query = $this->db->query("select SUM(monto) as extras from resguardo_conceptos where id_usuario=$user and estatus in(67)");
        return $query;
    }
    function getAplicadoResguardo($user) {
        $query = $this->db->query("select SUM(monto) as aplicado from resguardo_conceptos where id_usuario=$user and estatus in(1,2)");
        return $query;
    }

    public function getDataDetenidas() {
        $query = $this->db->query("SELECT DISTINCT(l.idLote), res.nombreResidencial, cond.nombre as nombreCondominio, l.nombreLote, l.tipo_venta, vc.id_cliente AS compartida, l.idStatusContratacion, hl.motivo, hl.comentario,l.totalNeto2, l.registro_comision, convert(nvarchar,  hl.fecha_movimiento , 6) fecha_movimiento, (CASE WHEN cl.plan_comision IN (0) OR cl.plan_comision IS NULL THEN '-' ELSE pl.descripcion END) AS plan_descripcion ,oxc.nombre as motivoOpc
        FROM lotes l 
        INNER JOIN clientes cl ON cl.id_cliente = l.idCliente AND cl.status = 1 
        INNER JOIN condominios cond ON l.idCondominio=cond.idCondominio 
        INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
        INNER JOIN historial_log hl ON hl.identificador = l.idLote AND hl.tabla = 'pago_comision' AND hl.estatus = 1 AND hl.fecha_movimiento = (select max(t2.fecha_movimiento) from historial_log t2 Where t2.identificador = hl.identificador)
        LEFT JOIN ventas_compartidas vc ON vc.id_cliente = cl.id_cliente AND vc.estatus = 1
        LEFT JOIN plan_comision pl ON pl.id_plan = cl.plan_comision
        LEFT JOIN pago_comision pc ON pc.id_lote = l.idLote AND pc.bandera in (0)
        LEFT JOIN opcs_x_cats oxc ON oxc.id_catalogo = 95 and oxc.id_opcion = TRY_CAST( hl.motivo AS BIGINT)
        WHERE l.idStatusContratacion BETWEEN 9 AND 15  AND l.status = 1  AND l.registro_comision in (10,11,18,5,3,4,5,6) AND l.tipo_venta IS NOT NULL  AND l.tipo_venta IN (1,2,7)
        ORDER BY l.idLote");
        return $query->result();
    }

    public function lotes(){
        $cmd = "SELECT SUM(lotes) nuevo_general 
        FROM (SELECT COUNT(DISTINCT(id_lote)) lotes 
        FROM pago_comision_ind pci 
        INNER JOIN comisiones c on c.id_comision = pci.id_comision 
        INNER JOIN usuarios u ON u.id_usuario = pci.creado_por AND u.id_rol IN (32,13,17) 
        INNER JOIN lotes l ON l.idLote = c.id_lote 
        WHERE MONTH(GETDATE()) = MONTH(pci.fecha_abono) AND year(GetDate()) = year(pci.fecha_abono) 
        AND Day(GetDate()) = Day(pci.fecha_abono) AND pci.estatus NOT IN (0) AND l.tipo_venta NOT IN (7) 
        GROUP BY u.id_usuario) as nuevo_general";
        $query = $this->db->query($cmd); 
        $query->result();
        return $query->row();
    }

    public function pagos(){
        $cmd = "SELECT SUM(pagos) nuevo_general 
        FROM (SELECT count(id_pago_i) pagos 
        FROM pago_comision_ind pci 
        INNER JOIN comisiones c on c.id_comision = pci.id_comision 
        INNER JOIN usuarios u ON u.id_usuario = pci.creado_por AND u.id_rol IN (32,13,17) 
        INNER JOIN lotes l ON l.idLote = c.id_lote 
        WHERE MONTH(GETDATE()) = MONTH(pci.fecha_abono)  AND year(GetDate()) = year(pci.fecha_abono)  AND Day(GetDate()) = Day(pci.fecha_abono)  AND pci.estatus NOT IN (0) AND l.tipo_venta NOT IN (7) 
        GROUP BY u.id_usuario) as nuevo_general ";
        $query = $this->db->query($cmd);
        $query->result();
        return $query->row();
    }

    public function monto(){
        $cmd = "SELECT ROUND (SUM(monto), 3 ) nuevo_general 
        FROM (SELECT SUM(pci.abono_neodata) monto 
        FROM pago_comision_ind pci 
        INNER JOIN comisiones c on c.id_comision = pci.id_comision 
        INNER JOIN usuarios u ON u.id_usuario = pci.creado_por 
        AND u.id_rol IN (32,13,17) INNER JOIN lotes l ON l.idLote = c.id_lote 
        WHERE MONTH(GETDATE()) = MONTH(pci.fecha_abono)  AND year(GetDate()) = year(pci.fecha_abono) AND Day(GetDate()) = Day(pci.fecha_abono)  AND pci.estatus NOT IN (0)  AND l.tipo_venta NOT IN (7)
        GROUP BY u.id_usuario) as nuevo_general ";
        $query = $this->db->query($cmd);
        $query->result();
        return $query->row();
    }

    public function ultimoRegistro($idLote){
        $cmd = "SELECT TOP 1 * from auditoria 
        WHERE tabla = 'lotes' AND col_afect = 'registro_comision' AND id_parametro = $idLote    
        ORDER BY fecha_creacion DESC ";
        $query = $this->db->query($cmd);
        return $query->row();
    }

    public  function ultimaDispersion($id_lote, $data)
    {
        try {
            $this->db->where('id_lote', $id_lote);
            $this->db->update('pago_comision', $data);
            $afftectedRows = $this->db->affected_rows();
            return $afftectedRows > 0 ? TRUE : FALSE ;
        }
        catch(Exception $e) {
            return $e->getMessage();
        }
    }

    public function ultimoLlenado(){
        $cmd = "SELECT TOP 1 CONVERT(VARCHAR(10), fecha_ejecucion, 103) + ' '  + convert(VARCHAR(8), fecha_ejecucion, 14) fecha_mostrar, * 
        FROM historial_llenado_plan 
        WHERE fecha_reinicio >= GetDate() 
        ORDER BY id_hlp desc";
        $query = $this->db->query($cmd);
        return  $query->num_rows() == 0 ?   FALSE  : $query->result_array()  ; 
    }

    public function nuevoLlenadoPlan(){
        $id_usuario = $this->session->userdata('id_usuario');
        $cmd = "INSERT INTO historial_llenado_plan VALUES(GETDATE(), $id_usuario, DATEADD(HOUR, 4, GETDATE()) )";
        $query = $this->db->query($cmd);
        return $query;
    }


// aqui enmpieza la reubicacación
    public  function porcentajesReubicacion($idCliente) {
        return $this->db->query("SELECT CONCAT(usu.nombre , ' ' , usu.apellido_paterno , ' ', usu.apellido_materno ) AS nombre, cr.id_comision_reubicada, cr.id_usuario, cr.comision_total, cr.porcentaje_decimal, cr.rol_generado AS id_rol, oxc.nombre AS detail_rol, cr.idCliente, cr.idLote, lo.totalNeto2  , cl.plan_comision , pc.descripcion, cr.nombreLote 
        FROM comisionesReubicadas cr
        INNER JOIN usuarios usu ON usu.id_usuario = cr.id_usuario
        INNER JOIN opcs_x_cats oxc ON oxc.id_catalogo = 1 AND oxc.id_opcion = cr.rol_generado
        INNER JOIN lotes lo ON lo.idLote = cr.idLote
        INNER JOIN clientes cl ON cr.idCliente = cl.id_cliente
        INNER JOIN plan_comision pc ON pc.id_plan = cl.plan_comision 
        WHERE cr.idCliente = $idCliente");
    }


// fin de la reubicacion 








    function insert_penalizacion_individual($id_comision, $id_usuario, $rol, $abono_nuevo, $pago, $idCliente){
        $validar = $this->db->query("SELECT pa.id_prestamo, pa.monto, rp.total, (pa.monto-rp.total) pendiente FROM prestamos_aut pa
        LEFT JOIN (SELECT SUM(pci.abono_neodata) total, rp.id_prestamo FROM relacion_pagos_prestamo rp
        INNER JOIN pago_comision_ind pci ON pci.id_pago_i = rp.id_pago_i AND pci.estatus = 28 GROUP BY rp.id_prestamo) rp ON rp.id_prestamo = pa.id_prestamo
        WHERE pa.id_cliente = $idCliente AND pa.id_usuario = $id_usuario
        GROUP BY pa.id_prestamo, pa.monto, rp.total");
    
        $pendiente = $validar->row()->pendiente;

        if($pendiente >= 0 && $pendiente <= $abono_nuevo){//ABONO es mayor a la PENALIZACION
            $abonoNormal = $abono_nuevo - $pendiente;
            $abonoPenalizacion = $pendiente;
            $estatusPrestamo = 3;

        }else if($pendiente > 0 && $pendiente > $abono_nuevo ){//ABONO es menor a la PENALIZACION
            $abonoNormal = 0;
            $abonoPenalizacion = $abono_nuevo;
            $estatusPrestamo = 1;
        }
        $respuesta = $this->db->query("INSERT INTO pago_comision_ind (id_comision, id_usuario, abono_neodata, fecha_abono, fecha_pago_intmex, estatus, pago_neodata, creado_por, comentario, modificado_por) VALUES (".$id_comision.", ".$id_usuario.", ".$abonoNormal.", GETDATE(), GETDATE(), 1, ".$pago.", ".$this->session->userdata('id_usuario').", 'NUEVO PAGO','".$this->session->userdata('id_usuario')."')");
        $insert_id_2 = $this->db->insert_id();
        $respuesta = $this->db->query("INSERT INTO historial_comisiones VALUES ($insert_id_2, ".$this->session->userdata('id_usuario').", GETDATE(), 1, 'DISPERSÓ PAGO DE COMISIÓN')");

        if($abonoPenalizacion!=0){
            $this->db->query("INSERT INTO pago_comision_ind (id_comision, id_usuario, abono_neodata, fecha_abono, fecha_pago_intmex, estatus, pago_neodata, creado_por, comentario, modificado_por, descuento_aplicado ) VALUES (".$id_comision.", ".$id_usuario.", ".$abonoPenalizacion.", GETDATE(), GETDATE(), 28 , ".$pago.",".$this->session->userdata('id_usuario').", 'PENALIZACIÓN N', ".$this->session->userdata('id_usuario').", 1)");
            $insert_id_3 = $this->db->insert_id();
            $this->db->query("INSERT INTO  historial_comisiones VALUES ($insert_id_3, ".$this->session->userdata('id_usuario').", GETDATE(), 1, 'DESCUENTO PENALIZACIÓN +90 DÍAS')");
            $this->db->query("UPDATE prestamos_aut SET estatus = ".$estatusPrestamo.", pago_individual = pago_individual + ".$abonoPenalizacion." WHERE id_prestamo = ".$validar->row()->id_prestamo."");    
            $this->db->query("INSERT INTO relacion_pagos_prestamo (id_prestamo, id_pago_i, estatus, creado_por, fecha_creacion, modificado_por, fecha_modificacion, np)
            VALUES(".$validar->row()->id_prestamo.", $insert_id_3, 1, ".$this->session->userdata('id_usuario').", GETDATE(), ".$this->session->userdata('id_usuario').", GETDATE(), 1)");
        }
    
            if (! $respuesta ) {
                return 0;
                } else {
                return 1;
                }
    }

}