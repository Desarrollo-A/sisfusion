<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Internomex_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    

    function getDatosNuevasInternomex($proyecto,$condominio){

        if($condominio == 0){
                return $this->db->query("SELECT pci1.id_pago_i, re.nombreResidencial as proyecto, lo.nombreLote, lo.totalNeto2 precio_lote, pci1.abono_neodata a_pagar, pci1.estatus, pci1.fecha_abono fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) comisionista, oprol.nombre as puesto, u.forma_pago, oxcest.nombre as estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, oxformap.nombre AS regimen 
                 FROM pago_comision_ind pci1 
                 INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                 INNER JOIN lotes lo ON lo.idLote = com.id_lote
                 INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                 INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                 INNER JOIN clientes cl ON cl.idLote = lo.idLote
                 INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
                 INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado
                 INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                 INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus 
                 INNER JOIN opcs_x_cats oxformap ON oxformap.id_opcion = u.forma_pago 
                 WHERE pci1.estatus IN (8) AND re.idResidencial = $proyecto AND oxformap.id_catalogo = 16
                 AND com.estatus in (1) AND oprol.id_catalogo = 1 AND oxcest.id_catalogo = 23 AND lo.status = 1 AND cl.status = 1
                 GROUP BY pci1.id_pago_i, re.nombreResidencial, lo.nombreLote, lo.totalNeto2, pci1.abono_neodata, pci1.estatus, pci1.fecha_abono, u.nombre, u.apellido_paterno, u.apellido_materno, oprol.nombre, u.forma_pago, oxcest.nombre, oxcest.id_opcion, re.empresa, oxformap.nombre
                 ORDER BY lo.nombreLote");
    
            }else{
                return $this->db->query("SELECT pci1.id_pago_i, re.nombreResidencial as proyecto, lo.nombreLote, lo.totalNeto2 precio_lote, pci1.abono_neodata a_pagar, pci1.estatus, pci1.fecha_abono fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) comisionista, oprol.nombre as puesto, u.forma_pago, oxcest.nombre as estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, oxformap.nombre AS regimen 
                 FROM pago_comision_ind pci1 
                 INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                 INNER JOIN lotes lo ON lo.idLote = com.id_lote
                 INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                 INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                 INNER JOIN clientes cl ON cl.idLote = lo.idLote
                 INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
                 INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado
                 INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                 INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus 
                 INNER JOIN opcs_x_cats oxformap ON oxformap.id_opcion = u.forma_pago 
                 WHERE pci1.estatus IN (8) AND co.idCondominio = $condominio AND oxformap.id_catalogo = 16
                 AND com.estatus in (1) AND oprol.id_catalogo = 1 AND oxcest.id_catalogo = 23 AND lo.status = 1 AND cl.status = 1
                 GROUP BY pci1.id_pago_i, re.nombreResidencial, lo.nombreLote, lo.totalNeto2, pci1.abono_neodata, pci1.estatus, pci1.fecha_abono, u.nombre, u.apellido_paterno, u.apellido_materno, oprol.nombre, u.forma_pago, oxcest.nombre, oxcest.id_opcion, re.empresa, oxformap.nombre
                 ORDER BY lo.nombreLote");
         }
        }



             function getDatosAplicadosInternomex($proyecto,$condominio){

        if($condominio == 0){
                return $this->db->query("SELECT pci1.id_pago_i, re.nombreResidencial as proyecto, lo.nombreLote, lo.totalNeto2 precio_lote, pci1.abono_neodata a_pagar, pci1.estatus, pci1.fecha_abono fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) comisionista, oprol.nombre as puesto, u.forma_pago, oxcest.nombre as estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, oxformap.nombre AS regimen 
                 FROM pago_comision_ind pci1 
                 INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                 INNER JOIN lotes lo ON lo.idLote = com.id_lote
                 INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                 INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                 INNER JOIN clientes cl ON cl.idLote = lo.idLote
                 INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
                 INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado
                 INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                 INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus 
                 INNER JOIN opcs_x_cats oxformap ON oxformap.id_opcion = u.forma_pago 
                 WHERE pci1.estatus IN (9) AND re.idResidencial = $proyecto AND oxformap.id_catalogo = 16
                 AND com.estatus in (1) AND oprol.id_catalogo = 1 AND oxcest.id_catalogo = 23 AND lo.status = 1 AND cl.status = 1
                 GROUP BY pci1.id_pago_i, re.nombreResidencial, lo.nombreLote, lo.totalNeto2, pci1.abono_neodata, pci1.estatus, pci1.fecha_abono, u.nombre, u.apellido_paterno, u.apellido_materno, oprol.nombre, u.forma_pago, oxcest.nombre, oxcest.id_opcion, re.empresa, oxformap.nombre
                 ORDER BY lo.nombreLote");
    
            }else{
                return $this->db->query("SELECT pci1.id_pago_i, re.nombreResidencial as proyecto, lo.nombreLote, lo.totalNeto2 precio_lote, pci1.abono_neodata a_pagar, pci1.estatus, pci1.fecha_abono fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) comisionista, oprol.nombre as puesto, u.forma_pago, oxcest.nombre as estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, oxformap.nombre AS regimen 
                 FROM pago_comision_ind pci1 
                 INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                 INNER JOIN lotes lo ON lo.idLote = com.id_lote
                 INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                 INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                 INNER JOIN clientes cl ON cl.idLote = lo.idLote
                 INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
                 INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado
                 INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                 INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus 
                 INNER JOIN opcs_x_cats oxformap ON oxformap.id_opcion = u.forma_pago 
                 WHERE pci1.estatus IN (9) AND co.idCondominio = $condominio AND oxformap.id_catalogo = 16
                 AND com.estatus in (1) AND oprol.id_catalogo = 1 AND oxcest.id_catalogo = 23 AND lo.status = 1 AND cl.status = 1
                 GROUP BY pci1.id_pago_i, re.nombreResidencial, lo.nombreLote, lo.totalNeto2, pci1.abono_neodata, pci1.estatus, pci1.fecha_abono, u.nombre, u.apellido_paterno, u.apellido_materno, oprol.nombre, u.forma_pago, oxcest.nombre, oxcest.id_opcion, re.empresa, oxformap.nombre
                 ORDER BY lo.nombreLote");
         }
        }



        function getDatosHistorialInternomex($proyecto,$condominio){

        if($condominio == 0){
                return $this->db->query("SELECT pci1.id_pago_i, re.nombreResidencial as proyecto, lo.nombreLote, lo.totalNeto2 precio_lote, pci1.abono_neodata a_pagar, pci1.estatus, pci1.fecha_abono fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) comisionista, oprol.nombre as puesto, u.forma_pago, oxcest.nombre as estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, oxformap.nombre AS regimen 
                 FROM pago_comision_ind pci1 
                 INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                 INNER JOIN lotes lo ON lo.idLote = com.id_lote
                 INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                 INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                 INNER JOIN clientes cl ON cl.idLote = lo.idLote
                 INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
                 INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado
                 INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                 INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus 
                 INNER JOIN opcs_x_cats oxformap ON oxformap.id_opcion = u.forma_pago 
                 WHERE pci1.estatus IN (8,9,10,11) AND pci1.descuento_aplicado = 0  AND re.idResidencial = $proyecto AND oxformap.id_catalogo = 16
                 AND com.estatus in (1) AND oprol.id_catalogo = 1 AND oxcest.id_catalogo = 23 AND lo.status = 1 AND cl.status = 1
                 GROUP BY pci1.id_pago_i, re.nombreResidencial, lo.nombreLote, lo.totalNeto2, pci1.abono_neodata, pci1.estatus, pci1.fecha_abono, u.nombre, u.apellido_paterno, u.apellido_materno, oprol.nombre, u.forma_pago, oxcest.nombre, oxcest.id_opcion, re.empresa, oxformap.nombre
                 ORDER BY lo.nombreLote");
    
            }else{
                return $this->db->query("SELECT pci1.id_pago_i, re.nombreResidencial as proyecto, lo.nombreLote, lo.totalNeto2 precio_lote, pci1.abono_neodata a_pagar, pci1.estatus, pci1.fecha_abono fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) comisionista, oprol.nombre as puesto, u.forma_pago, oxcest.nombre as estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, oxformap.nombre AS regimen 
                FROM pago_comision_ind pci1 
                INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                INNER JOIN lotes lo ON lo.idLote = com.id_lote
                INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                INNER JOIN clientes cl ON cl.idLote = lo.idLote
                INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
                INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado
                INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus 
                INNER JOIN opcs_x_cats oxformap ON oxformap.id_opcion = u.forma_pago 
                WHERE pci1.estatus IN (8,9,10,11) AND pci1.descuento_aplicado = 0 AND co.idCondominio = $condominio AND oxformap.id_catalogo = 16
                AND com.estatus in (1) AND oprol.id_catalogo = 1 AND oxcest.id_catalogo = 23 AND lo.status = 1 AND cl.status = 1
                GROUP BY pci1.id_pago_i, re.nombreResidencial, lo.nombreLote, lo.totalNeto2, pci1.abono_neodata, pci1.estatus, pci1.fecha_abono, u.nombre, u.apellido_paterno, u.apellido_materno, oprol.nombre, u.forma_pago, oxcest.nombre, oxcest.id_opcion, re.empresa, oxformap.nombre
                ORDER BY lo.nombreLote");
            }
        }


        function update_aplica_intemex($idsol) {
            $this->db->query("INSERT INTO historial_comisiones VALUES ($idsol, ".$this->session->userdata('id_usuario').", GETDATE(), 1, 'SE APLICÓ PAGO DE INTERNOMEX')");
            return $this->db->query("UPDATE pago_comision_ind SET estatus = 9 WHERE id_pago_i IN (".$idsol.")");
    }

    public function getPagosFinal($beginDate, $endDate) {
        $condicion = '';
        if (!in_array($this->session->userdata('id_rol'), array(31, 17, 70, 71, 73))) { // INTERNOMEX & CONTRALORÍA
            $idUsuario = $this->session->userdata('id_usuario');
            $condicion = " AND pt.id_usuario = $idUsuario";
        }
        return $this->db->query("SELECT pt.id_pagoi, pt.id_usuario,
        FORMAT(pt.monto_con_descuento,'C','En-Us') 'monto_con_descuento',
        FORMAT(pt.monto_sin_descuento,'C','En-Us') 'monto_sin_descuento',
        FORMAT(pt.monto_internomex,'C','En-Us') 'monto_internomex',
        UPPER(se.nombre) AS sede, UPPER(oxc0.nombre) AS forma_pago, CONVERT(varchar, pt.fecha_creacion, 20) fecha_creacion,
        CONCAT (u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno) nombre, 
        CASE WHEN (pt.comentario IS NULL OR CAST(pt.comentario AS VARCHAR(250)) = '') THEN 'SIN COMENTARIOS' ELSE pt.comentario END comentario,
        u0.id_rol, UPPER(oxc1.nombre) AS rol 
        FROM  pagos_internomex pt
        INNER JOIN usuarios u0 ON u0.id_usuario = pt.id_usuario
        INNER JOIN sedes se ON CAST(se.id_sede AS VARCHAR(15)) = CAST(u0.id_sede AS VARCHAR(15))
        INNER JOIN opcs_x_cats oxc0 ON oxc0.id_catalogo = 16 AND oxc0.id_opcion = pt.forma_pago
        INNER JOIN opcs_x_cats oxc1 ON oxc1.id_catalogo = 1 AND oxc1.id_opcion = u0.id_rol
        WHERE pt.fecha_creacion BETWEEN '$beginDate 00:00:00.000' AND '$endDate 23:59:00.000' $condicion");
    }

    public function getCommissions($tipo_pago) {
        if($tipo_pago==1){
            return $this->db->query("SELECT u0.id_usuario, UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) nombreUsuario, 
        se.nombre sede, oxc0.nombre tipoUsuario, oxc2.nombre formaPago, u0.rfc,oxc1.nombre nacionalidad, 
        FORMAT(SUM(pci.abono_neodata), 'C') montoSinDescuentos,
        (CASE u0.forma_pago WHEN 3 THEN FORMAT(SUM(pci.abono_neodata) - ((SUM(pci.abono_neodata) * se.impuesto) / 100), 'C') 
        ELSE FORMAT(SUM(pci.abono_neodata), 'C') END) montoConDescuentosSede, '0.00' montoFinal, '' comentario
        FROM pago_comision_ind pci
        INNER JOIN comisiones co ON co.id_comision = pci.id_comision
        INNER JOIN lotes lo ON lo.idLote = co.id_lote
        INNER JOIN usuarios u0 ON u0.id_usuario = pci.id_usuario
        INNER JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = u0.id_rol AND oxc0.id_catalogo = 1
        INNER JOIN opcs_x_cats oxc1 ON oxc1.id_opcion = u0.nacionalidad AND oxc1.id_catalogo = 11
        INNER JOIN opcs_x_cats oxc2 ON oxc2.id_opcion = u0.forma_pago AND oxc2.id_catalogo = 16
        LEFT JOIN sedes se ON CAST(se.id_sede AS VARCHAR(15)) = CAST(u0.id_sede AS VARCHAR(15))
        WHERE pci.estatus = 8 -- AND pci.id_usuario = 3142
        GROUP BY u0.id_usuario, UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)), 
        se.nombre, oxc0.nombre, oxc2.nombre, u0.rfc,oxc1.nombre, u0.forma_pago, se.impuesto, u0.id_rol
        ORDER BY CASE u0.id_rol WHEN 3 THEN 4 WHEN 9 THEN 5 WHEN 7 THEN 6 ELSE u0.id_rol END");
        }elseif($tipo_pago==2){
            return $this->db->query("SELECT u0.id_usuario, UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) nombreUsuario, 
        ISNULL(se.nombre, 'Sin especificar') sede, oxc0.nombre tipoUsuario, oxc2.nombre formaPago, u0.rfc,oxc1.nombre nacionalidad, 
        FORMAT(SUM(ps.total_comision), 'C') montoSinDescuentos,
        (CASE u0.forma_pago WHEN 3 THEN FORMAT(SUM(ps.total_comision) - ((SUM(ps.total_comision) * se.impuesto) / 100), 'C') 
        ELSE FORMAT(SUM(ps.total_comision), 'C') END) montoConDescuentosSede, '0.00' montoFinal, '' comentario
        FROM pagos_suma ps
        INNER JOIN comisiones_suma co ON co.referencia = ps.referencia
        INNER JOIN usuarios u0 ON u0.id_usuario = ps.id_usuario
        INNER JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = u0.id_rol AND oxc0.id_catalogo = 1
        INNER JOIN opcs_x_cats oxc1 ON oxc1.id_opcion = u0.nacionalidad AND oxc1.id_catalogo = 11
        INNER JOIN opcs_x_cats oxc2 ON oxc2.id_opcion = u0.forma_pago AND oxc2.id_catalogo = 16
        LEFT JOIN sedes se ON CAST(se.id_sede AS VARCHAR(15)) = CAST(u0.id_sede AS VARCHAR(15))
        WHERE ps.estatus = 1 -- AND pci.id_usuario = 3142
        GROUP BY u0.id_usuario, UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)), 
        se.nombre, oxc0.nombre, oxc2.nombre, u0.rfc,oxc1.nombre, u0.forma_pago, se.impuesto, u0.id_rol
        ORDER BY CASE u0.id_rol WHEN 3 THEN 4 WHEN 9 THEN 5 WHEN 7 THEN 6 ELSE u0.id_rol END");
        }

    }

        public function verifyData($id_usuario) {
        $month = date("m");
        $year = date("Y");
		$query = $this->db-> query("SELECT id_usuario FROM pagos_internomex 
        WHERE id_usuario IN ($id_usuario) AND YEAR(fecha_creacion) = $year AND MONTH(fecha_creacion) = $month")->result();
		return $query;
	}

    function getBitacora($id_pago){
        return $this->db->query("SELECT au.anterior, au.nuevo, au.col_afect, CONVERT(NVARCHAR, au.fecha_creacion, 6) AS fecha,
        (CASE WHEN u.id_usuario IS NOT null THEN CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) 
        WHEN u2.id_usuario IS NOT null THEN CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno) 
            ELSE au.creado_por END) usuario
        FROM auditoria au
        LEFT JOIN usuarios u ON CAST(au.creado_por AS VARCHAR(45)) = CAST(u.id_usuario AS VARCHAR(45))
        LEFT JOIN usuarios u2 ON SUBSTRING(u2.usuario, 1, 20) = SUBSTRING(au.creado_por, 1, 20)
        WHERE au.col_afect = 'monto_internomex' AND au.id_parametro = $id_pago
        ORDER BY au.fecha_creacion DESC");
    }

    public function getInformacionContratos($rows_number) {
        ini_set('memory_limit', -1);
        $top_statement = $rows_number != '' ? "TOP $rows_number": "";
        return $this->db->query("SELECT $top_statement lo.idLote, op1.nombre tipo_persona, 
        cl.ocupacion actividad_sector,
        UPPER(cl.nombre) nombre_denominacion, ISNULL(cl.apellido_paterno, '') apellido_paterno, ISNULL(cl.apellido_materno, '') apellido_materno, 
        ISNULL(convert(varchar, try_parse(fecha_nacimiento as date), 103), '') fecha_nacimiento_constitucion, 
        ISNULL(curp,'') curp, ISNULL(cl.rfc, '') rfc, 
        op2.nombre nacionalidad, cl.domicilio_particular direccion, 
        CASE WHEN co.tipo_lote = 0 THEN 'Habitacional' ELSE 'Comercial' END tipo_propiedad, 
        lo.nombreLote nombrePropiedad, lo.sup tamanio_terreno, 
        FORMAT(ISNULL(lo.totalNeto2, 0.00), 'C') costo, 
        REPLACE(CONCAT(oxc0.nombre, ',', oxc1.nombre, ',', oxc2.nombre, ',', oxc3.nombre, ',', oxc4.nombre, ',', oxc5.nombre), ',,', '') forma_pago, FORMAT(ISNULL(lo.totalValidado, 0), 'C') monto_enganche, 
        MAX(hc.fecha_movimiento) fecha_pago_comision, FORMAT(ISNULL(pc.total_comision, 0), 'C') monto_comision,
        re.empresa, ISNULL(CONVERT(varchar, hl.modificado, 103), 'SIN ESPECIFICAR') fechaEstatus9, ISNULL(CONVERT(varchar, hl2.modificado, 103), 'SIN ESPECIFICAR') fechaEstatus7
        FROM clientes cl
        INNER JOIN lotes lo ON lo.idCliente = lo.idCliente AND lo.idLote = cl.idLote AND lo.status = 1 --AND lo.idLote IN (73474)
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        LEFT JOIN corridas_financieras cf ON cf.id_lote = lo.idLote AND cf.id_cliente = cl.id_cliente AND cf.status = 1
		LEFT JOIN comisiones cm ON cm.id_lote = lo.idLote AND cm.idCliente = cl.id_cliente
		LEFT JOIN pago_comision pc ON pc.id_lote = cm.id_lote
		INNER JOIN (SELECT * FROM pago_comision_ind WHERE estatus = 8) pci ON pci.id_comision = cm.id_comision
		INNER JOIN historial_comisiones hc ON hc.id_pago_i = pci.id_pago_i AND hc.comentario IN ('CONTRALOÍA ENVIO A INTERNOMEX', 'CONTRALORIA ENVIO A INTERNOMEX', 'CONTRALORIA ENVÍO A INTERNOMEX', 'CONTRALORÍA ENVIO A INTERNOMEX', 'CONTRALORÍA ENVÍO A INTERNOMEX', 'CONTRALORÍA ENVÍO A INTERNOMEX ASIMILADO', 'CONTRALORÍA ENVÍO A INTERNOMEX FACTURA', 'CONTRALORÍA ENVÍO A INTERNOMEX REMANENTE', 'CONTRALORÍA ENVÍO PAGO A INTERNOMEX', 'Se envío a INTERNOMEX', 'SE ENVÍO PAGO A INTERNOMEX')
		INNER JOIN opcs_x_cats op1 ON op1.id_opcion = cl.personalidad_juridica AND op1.id_catalogo = 10
        INNER JOIN opcs_x_cats op2 ON op2.id_opcion = cl.nacionalidad AND op2.id_catalogo = 11
		LEFT JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes WHERE idStatusContratacion = 9 AND idMovimiento = 39 AND status = 1 GROUP BY idLote, idCliente) hl ON hl.idLote = lo.idLote AND hl.idCliente = cl.id_cliente 
        LEFT JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes WHERE idStatusContratacion = 7 AND idMovimiento = 37 AND status = 1 GROUP BY idLote, idCliente) hl2 ON hl2.idLote = lo.idLote AND hl2.idCliente = cl.id_cliente 
		LEFT JOIN usuarios u0 ON u0.id_usuario = cl.id_asesor
		LEFT JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = u0.forma_pago AND oxc0.id_catalogo = 16
        LEFT JOIN usuarios u1 ON u1.id_usuario = cl.id_coordinador
		LEFT JOIN opcs_x_cats oxc1 ON oxc1.id_opcion = u1.forma_pago AND oxc1.id_catalogo = 16
        LEFT JOIN usuarios u2 ON u2.id_usuario = cl.id_gerente
		LEFT JOIN opcs_x_cats oxc2 ON oxc2.id_opcion = u2.forma_pago AND oxc2.id_catalogo = 16
        LEFT JOIN usuarios u3 ON u3.id_usuario = cl.id_subdirector
		LEFT JOIN opcs_x_cats oxc3 ON oxc3.id_opcion = u3.forma_pago AND oxc3.id_catalogo = 16
        LEFT JOIN usuarios u4 ON u4.id_usuario = cl.id_regional
		LEFT JOIN opcs_x_cats oxc4 ON oxc4.id_opcion = u4.forma_pago AND oxc4.id_catalogo = 16
        LEFT JOIN usuarios u5 ON u4.id_usuario = cl.id_regional_2
		LEFT JOIN opcs_x_cats oxc5 ON oxc5.id_opcion = u5.forma_pago AND oxc5.id_catalogo = 16
        WHERE cl.status = 1
		GROUP BY lo.idLote, op1.nombre, cl.ocupacion,
        UPPER(cl.nombre), ISNULL(cl.apellido_paterno, ''), ISNULL(cl.apellido_materno, ''), 
        ISNULL(convert(varchar, try_parse(fecha_nacimiento as date), 103), ''), 
        ISNULL(curp,''), ISNULL(cl.rfc, ''), op2.nombre, cl.domicilio_particular, 
        CASE WHEN co.tipo_lote = 0 THEN 'Habitacional' ELSE 'Comercial' END, 
        lo.nombreLote, lo.sup, 
        FORMAT(ISNULL(lo.totalNeto2, 0.00), 'C'), 
        ISNULL(cf.plan_corrida, 'SIN ESPECIFICAR'), FORMAT(ISNULL(lo.totalValidado, 0), 'C'), pc.total_comision,
        re.empresa, ISNULL(CONVERT(varchar, hl.modificado, 103), 'SIN ESPECIFICAR'), ISNULL(CONVERT(varchar, hl2.modificado, 103), 'SIN ESPECIFICAR'),
		ISNULL(CONVERT(varchar, pc.ultima_dispersion, 103), 'SIN ESPECIFICAR'), oxc0.nombre, oxc1.nombre, oxc2.nombre, oxc3.nombre, oxc4.nombre, oxc5.nombre")->result_array(); 
    }

}
