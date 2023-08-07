<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 */
class Cobranza_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    
    public function getInformation($typeTransaction, $beginDate, $endDate, $where) {
        if ($typeTransaction == 1 || $typeTransaction == 3) {  // FIRST LOAD || SEARCH BY DATE RANGE
            $filter = " AND cl.fechaApartado BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59'";
            $filterTwo = "";
        } else if($typeTransaction == 2) { // SEARCH BY LOTE
            $filter = "";
            $filterTwo = " AND l.idLote = $where";
        }

        if ($this->session->userdata('id_rol') == 19 || $this->session->userdata('id_rol') == 63) { // SUBDIRECTOR MKTD
            $id_sede = explode(", ", $this->session->userdata('id_sede'));
            $result = "'" . implode("', '", $id_sede) . "'";
        } else { // COBRANZA
            if ($this->session->userdata('id_usuario') == 2042)
                $result = "'2', '3', '4', '6'";
            else if ($this->session->userdata('id_usuario') == 5363)
                $result = "'1', '5', '8', '9'";
        }
        $query="SELECT r.nombreResidencial, UPPER(cn.nombre) nombreCondominio, UPPER(l.nombreLote) nombreLote, l.idLote,
        FORMAT(ISNULL(l.totalNeto2, '0.00'), 'C') precioTotalLote, FORMAT(l.total, 'C') total_sindesc, CONVERT( VARCHAR,cl.fechaApartado ,20) AS fechaApartado, UPPER(s.nombre) plaza,
        ISNULL(ec.estatus, 0) estatusEvidencia, 
        (CASE l.idStatusContratacion WHEN '1' THEN '01' WHEN '2' THEN '02' WHEN '3' THEN '03' WHEN '4' THEN '04' WHEN '5' THEN '05' WHEN '6' THEN '06' 
		WHEN '7' THEN '07' WHEN '8' THEN '08' WHEN '9' THEN '09' WHEN '10' THEN '10' WHEN '11' THEN '11' WHEN '12' THEN '12' 
		WHEN '13' THEN '13' WHEN '14' THEN '14' WHEN '15' THEN '15' END) 
        idStatusContratacion, idStatusLote, pc.bandera estatusComision,
        FORMAT(ISNULL(cm.comision_total, '0.00'), 'C') comisionTotal, 
        FORMAT(ISNULL(pci3.abonoDispersado, '0.00'), 'C') abonoDispersado, 
        FORMAT(ISNULL(pci2.abonoPagado, '0.00'), 'C') abonoPagado, l.registro_comision registroComision, cm.estatus as rec, cl.descuento_mdb,
        REPLACE(oxc.nombre, ' (especificar)', '') lugar_prospeccion
        FROM lotes l
        INNER JOIN condominios cn ON cn.idCondominio = l.idCondominio
        INNER JOIN residenciales r ON r.idResidencial = cn.idResidencial
        LEFT JOIN evidencia_cliente ec ON ec.idLote = l.idLote AND ec.idCliente = l.idCliente
        INNER JOIN clientes cl ON cl.id_cliente = l.idCliente AND cl.status = 1 AND (cl.lugar_prospeccion IN(6,29) OR cl.descuento_mdb = 1 OR (ec.estatus = 3 and cl.lugar_prospeccion not IN(6,29)) ) $filter
        INNER JOIN prospectos pr ON pr.id_prospecto = cl.id_prospecto AND pr.fecha_creacion <= '2022-01-20 00:00:00.000'
        INNER JOIN usuarios u ON u.id_usuario = cl.id_asesor AND u.id_sede IN ($result) 
        INNER JOIN sedes s ON s.id_sede = (CASE WHEN l.ubicacion_dos != 0 THEN l.ubicacion_dos WHEN l.ubicacion != 0 and l.ubicacion_dos = 0 THEN l.ubicacion WHEN u.id_sede != 0 and l.ubicacion_dos = 0 and l.ubicacion  = 0 THEN u.id_sede END)
        LEFT JOIN comisiones cm ON cm.id_lote = l.idLote AND cm.rol_generado = 38
        LEFT JOIN pago_comision pc ON pc.id_lote = l.idLote    
        LEFT JOIN (SELECT SUM(abono_neodata) abonoPagado, id_comision FROM pago_comision_ind WHERE estatus IN (11) GROUP BY id_comision) pci2 ON cm.id_comision = pci2.id_comision
        LEFT JOIN (SELECT SUM(abono_neodata) abonoDispersado, id_comision FROM pago_comision_ind GROUP BY id_comision) pci3 ON cm.id_comision = pci3.id_comision
        LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = cl.lugar_prospeccion AND oxc.id_catalogo = 9
        WHERE l.status = 1 $filterTwo
        UNION ALL
        SELECT r.nombreResidencial, UPPER(cn.nombre) nombreCondominio, UPPER(l.nombreLote) nombreLote, l.idLote,
        FORMAT(ISNULL(l.totalNeto2, '0.00'), 'C') precioTotalLote, FORMAT(l.total, 'C') total_sindesc, CONVERT( VARCHAR,cl.fechaApartado ,20) AS fechaApartado, UPPER(s.nombre) plaza,
        ISNULL(ec.estatus, 0) estatusEvidencia, 
        (CASE l.idStatusContratacion WHEN '1' THEN '01' WHEN '2' THEN '02' WHEN '3' THEN '03' WHEN '4' THEN '04' WHEN '5' THEN '05' WHEN '6' THEN '06' 
        WHEN '7' THEN '07' WHEN '8' THEN '08' WHEN '9' THEN '09' WHEN '10' THEN '10' WHEN '11' THEN '11' WHEN '12' THEN '12' 
        WHEN '13' THEN '13' WHEN '14' THEN '14' WHEN '15' THEN '15' END) 
        idStatusContratacion, idStatusLote, pc.bandera estatusComision,
        FORMAT(ISNULL(cm.comision_total, '0.00'), 'C') comisionTotal, 
        FORMAT(ISNULL(pci3.abonoDispersado, '0.00'), 'C') abonoDispersado, 
        FORMAT(ISNULL(pci2.abonoPagado, '0.00'), 'C') abonoPagado, l.registro_comision registroComision, cm.estatus as rec, cl.descuento_mdb,
        REPLACE(oxc.nombre, ' (especificar)', '') lugar_prospeccion
        FROM lotes l
        INNER JOIN condominios cn ON cn.idCondominio = l.idCondominio
        INNER JOIN residenciales r ON r.idResidencial = cn.idResidencial
        INNER JOIN evidencia_cliente ec ON ec.idLote = l.idLote AND ec.idCliente = l.idCliente AND ec.estatus = 3
        INNER JOIN controversias co ON co.id_lote = ec.idLote AND co.id_cliente = ec.idCliente AND co.estatus = 1
        INNER JOIN clientes cl ON cl.id_cliente = l.idCliente AND cl.status = 1 AND (cl.descuento_mdb = 0 OR cl.descuento_mdb IS NULL) $filter
        INNER JOIN prospectos pr ON pr.id_prospecto = cl.id_prospecto AND pr.fecha_creacion > '2022-01-20 00:00:00.000'
        INNER JOIN usuarios u ON u.id_usuario = cl.id_asesor AND u.id_sede IN ($result) 
        --INNER JOIN sedes s ON CAST(s.id_sede AS VARCHAR(15)) = CAST(u.id_sede AS VARCHAR(15))
        INNER JOIN sedes s ON s.id_sede = (CASE WHEN l.ubicacion_dos != 0 THEN l.ubicacion_dos WHEN l.ubicacion != 0 and l.ubicacion_dos = 0 THEN l.ubicacion WHEN u.id_sede != 0 and l.ubicacion_dos = 0 and l.ubicacion  = 0 THEN u.id_sede END)
        LEFT JOIN comisiones cm ON cm.id_lote = l.idLote AND cm.rol_generado = 38
        LEFT JOIN pago_comision pc ON pc.id_lote = l.idLote    
        LEFT JOIN (SELECT SUM(abono_neodata) abonoPagado, id_comision FROM pago_comision_ind WHERE estatus IN (11) GROUP BY id_comision) pci2 ON cm.id_comision = pci2.id_comision
        LEFT JOIN (SELECT SUM(abono_neodata) abonoDispersado, id_comision FROM pago_comision_ind GROUP BY id_comision) pci3 ON cm.id_comision = pci3.id_comision
        LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = cl.lugar_prospeccion AND oxc.id_catalogo = 9
        WHERE l.status = 1 $filterTwo";
       // var_dump($query);
        return $this->db->query($query);
        
    }

    public function updateRecord($table, $data, $key, $value) // MJ: ACTUALIZA LA INFORMACIÓN DE UN REGISTRO EN PARTICULAR, RECIBE 4 PARÁMETROS. TABLA, DATA A ACTUALIZAR, LLAVE (WHERE) Y EL VALOR DE LA LLAVE
    {
        $response = $this->db->update($table, $data, "$key = '$value'");
        if (!$response) {
            return 0; // MJ: SOMETHING HAPPENDS
        } else {
            return 1; // MJ: EVERYTHING RUNS FINE
        }
    }

        /*********************/
    function getClientsByAsesor($asesor){
        return $this->db->query("SELECT c.id_cliente, CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre, c.telefono1, c.correo, l.nombreLote, CONVERT(VARCHAR,c.fechaApartado,20) AS fechaApartado, 
        c.idLote, CONCAT(u.nombre,  ' ', u.apellido_paterno, ' ', u.apellido_materno) gerente, c.lugar_prospeccion, 
        ISNULL (oxc.nombre, 'Sin especificar') nombre_lp, oxc2.id_opcion tipo_controversia
        FROM clientes c
                INNER JOIN lotes l ON l.idLote=c.idLote
                INNER JOIN usuarios u ON u.id_usuario = c.id_gerente
                LEFT JOIN opcs_x_cats oxc ON c.lugar_prospeccion = oxc.id_opcion AND oxc.id_catalogo = 9
                LEFT JOIN controversias con ON con.id_lote = l.idLote AND con.id_cliente = l.idCliente
                LEFT JOIN opcs_x_cats oxc2 ON oxc2.id_opcion = con.tipo AND oxc2.id_catalogo = 58
                LEFT JOIN evidencia_cliente ec ON ec.idLote = l.idLote
                WHERE c.id_asesor = $asesor AND ec.id_evidencia IS NULL AND c.status = 1");
    }
    function getDetails($id, $checks, $beginDate, $endDate, $sede){
        ini_set('max_execution_time', 900);
        set_time_limit(900);
        ini_set('memory_limit','8192M');
        $query["data"] = $this->db->query("SELECT * FROM clientes WHERE id_cliente = $id")->row();
        $name = str_replace(array(' ', '.'),'',$query["data"]->nombre);
        $correo = $query["data"]->correo;
        $telefono = $query["data"]->telefono1;
        $string = "";
        foreach($checks as $check){
            if( $check["value"] == "on" && $check["key"] == 'nombre'){
                $string .= " AND REPLACE(REPLACE(p.nombre, ' ', ''),'.', '') LIKE '%$name%'";
            } else if( $check["value"] == "on" && $check["key"] == 'telefono'){
                $string .= " AND p.telefono LIKE '%$telefono%'";
            } else if( $check["value"] == "on" && $check["key"] == 'correo'){
                $string .= " AND p.correo LIKE '%$correo%'";
            } else if( $check["value"] == "on" && $check["key"] == 'sedes'){
                $string .= " AND p.id_sede =  $sede";
            } else if ( $check["value"] == "on" && $check["key"] == 'date'){
                $string .= " AND p.fecha_creacion BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59'";
            }
        }
        $WHERE = substr($string, 4);
        $query2["data"] = $this->db->query("SELECT CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) nombre, UPPER(oxc.nombre) AS namePros, UPPER(p.correo) AS correo, p.telefono, p.fecha_creacion, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreAsesor, 
        CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) nombreGerente
        FROM prospectos p 
        INNER JOIN usuarios u ON u.id_usuario = p.id_asesor
        INNER JOIN usuarios us ON us.id_usuario = p.id_gerente
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = p.lugar_prospeccion WHERE $WHERE AND oxc.id_catalogo = 9");
        return $query2["data"];
    }

    function getAsesores(){
        return $this->db->query("SELECT id_usuario, CONCAT(nombre, ' ', apellido_paterno, ' ', ISNULL(apellido_materno, '')) nombre, id_sede FROM usuarios WHERE 
                                id_rol = 7 AND estatus = 1 ORDER BY nombre");
    }

    function getSedes(){
        return $this->db->query("SELECT * FROM sedes WHERE estatus != 0 ORDER BY nombre ");
    }
    //Se verifica si el lote ya tiene una controversia
    public function verificarControversia($idLote){
        $query = $this->db->query("SELECT * FROM controversias WHERE id_lote = $idLote");
        return $query->result_array();
    }

    public function insertControversia($data){
        $a = 0;
        $this->db->insert('controversias',$data);
        return $this->db->affected_rows();
    }

    public function insertEvidencia($data)
    {
        $this->db->insert('evidencia_cliente',$data);
        return $this->db->affected_rows();
    }

    public function insertHistorialEvidencia($data)
    {
        $this->db->insert('historial_evidencias',$data);
        return $this->db->affected_rows();
    }

    public function getReporteLiberaciones() {
        return $this->db->query("SELECT lo.idLote, lo.nombreLote, cl.id_cliente, hl.modificado fecha_liberacion, oxc.nombre motivo_liberacion,
        CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno) nombre_cliente_old, cl.fechaApartado fechaApartadoOld,
        CASE WHEN oxc2.nombre LIKE '%(especificar)%' THEN ISNULL(CONCAT(REPLACE(oxc2.nombre, ' (especificar)', ''), ' - ', cl.otro_lugar), 'Sin especificar') ELSE ISNULL(REPLACE(oxc2.nombre, ' (especificar)', ''), 'Sin especificar') END lugar_prospeccion_old,
        CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) nombre_asesor_old, ISNULL(se.nombre, se2.nombre) sede_old,
        sc.nombreStatus ultimoEstatusContratacion, sc2.nombreStatus estatusActualContratacion, sl.nombre estatusActualLote,
        CONCAT(cl2.nombre, ' ', cl2.apellido_paterno, ' ', cl2.apellido_materno) nombre_cliente_new, cl2.fechaApartado fechaApartadoNew,
        CASE WHEN oxc3.nombre LIKE '%(especificar)%' THEN ISNULL(CONCAT(REPLACE(oxc3.nombre, ' (especificar)', ''), ' - ', cl2.otro_lugar), 'Sin especificar') ELSE ISNULL(REPLACE(oxc3.nombre, ' (especificar)', ''), 'Sin especificar') END lugar_prospeccion_new,
        CONCAT(us2.nombre, ' ', us2.apellido_paterno, ' ', us2.apellido_materno) nombre_asesor_new, ISNULL(se3.nombre, se4.nombre) sede_new
        FROM lotes lo
        INNER JOIN (SELECT idLote, MAX(modificado) modificado FROM historial_liberacion GROUP BY idLote) hl ON hl.idLote = lo.idLote
        INNER JOIN historial_liberacion hll ON hll.idLote =  hl.idLote AND hll.modificado = hl.modificado
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = hll.tipo AND oxc.id_catalogo = 48
        INNER JOIN clientes cl ON cl.idLote = hl.idLote AND cl.status = 0 AND cl.lugar_prospeccion = 6
        INNER JOIN usuarios us ON us.id_usuario = cl.id_asesor
        LEFT JOIN opcs_x_cats oxc2 ON oxc2.id_opcion = cl.lugar_prospeccion AND oxc2.id_catalogo = 9
        LEFT JOIN sedes se ON se.id_sede = cl.id_sede
        LEFT JOIN sedes se2 ON se2.id_sede = us.id_sede
        INNER JOIN (SELECT idLote, idCliente, status, MAX(modificado) modificado FROM historial_lotes GROUP BY idLote, idCliente, status) hlo ON hlo.idLote = hl.idLote AND hlo.idCliente = cl.id_cliente AND hlo.status = 0
        INNER JOIN historial_lotes hlo2 ON hlo2.idLote = hlo.idLote AND hlo2.idCliente = hlo.idCliente AND hlo2.modificado = hlo.modificado
        INNER JOIN statuscontratacion sc ON sc.idStatusContratacion = hlo2.idStatusContratacion
        LEFT JOIN statuscontratacion sc2 ON sc2.idStatusContratacion = lo.idStatusContratacion
        INNER JOIN statuslote sl ON sl.idStatusLote = lo.idStatusLote
        LEFT JOIN clientes cl2 ON cl2.id_cliente = lo.idCliente
        LEFT JOIN opcs_x_cats oxc3 ON oxc3.id_opcion = cl2.lugar_prospeccion AND oxc3.id_catalogo = 9
        LEFT JOIN usuarios us2 ON us2.id_usuario = cl2.id_asesor
        LEFT JOIN sedes se3 ON se3.id_sede = cl2.id_sede
        LEFT JOIN sedes se4 ON se4.id_sede = us2.id_sede
        WHERE lo.status = 1 AND cl2.lugar_prospeccion NOT IN (6, 29) --AND lo.idLote IN (65874)");
    }

    public function informationMasterCobranzaHistorial($idLote , $beginDate, $endDate) {
        ini_set('max_execution_time', 9000);
        set_time_limit(9000);
        ini_set('memory_limit','12288M');
        if ($idLote == '' || $idLote ==  0)
            $query = '';
        else
            $query = "AND lo.idLote = $idLote";
        if( $beginDate != '') {
            $query2  = " WHERE cl.fechaApartado BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59'";
            $query3  =  " ";
        } else {
            $query2 = '';
            $query3  =  '';
        }

        $cmd = "SELECT pci1.id_pago_i, pci1.id_comision, lo.idLote ,lo.nombreLote , lo.referencia,  co.nombre as condominio,com.estatus as rec,
        FORMAT(ISNULL(lo.totalNeto2 , '0.00'), 'C') precio_lote,
        FORMAT(ISNULL(com.comision_total , '0.00'), 'C') comision_total, 
        FORMAT(ISNULL(pci1.abono_neodata ,'0.00'),'C') pago_cliente , 
        FORMAT(ISNULL(pci1.pago_neodata, '0.00'), 'C') pago_neodata , 
        FORMAT(ISNULL( pci2.abono_pagado , '0.00'), 'C') pagado ,
        FORMAT(ISNULL( pci3.abono_neodata , '0.00'), 'C') pagado3 ,
        FORMAT(ISNULL( pc14.abono_pagado2  , '0.00'), 'C') pago_neodata4,
        FORMAT(ISNULL( pci3.pago_neodata , '0.00'), 'C') pago_neodata3,
        FORMAT(ISNULL(com.comision_total-pc14.abono_pagado2, '0.00'),'C') restantes3, 
        FORMAT(ISNULL(com.comision_total-pci2.abono_pagado , '0.00'),'C') restantes,
        ISNULL(ec.estatus, 0) estatusEvidencia, 
        com.porcentaje_decimal,  UPPER(s.nombre) plaza, UPPER(s3.nombre) plazaB,
        pci1.estatus, CONVERT(VARCHAR, cl.fechaApartado,20) AS fecha_apartado, pci1.fecha_abono fecha_abono,
        (CASE WHEN pe.id_penalizacion IS NOT NULL THEN 1 ELSE 0 END) penalizacion,
        CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) user_names ,pci1.id_usuario, UPPER(oprol.nombre) as puesto, u.estatus as estatus_usuario, 
        oxcest.nombre as estatus_actual_comision,slo.nombre as estatus_lote,slo.color as color_lote , oxcest.id_opcion id_estatus_actual,  pr.source as source,
        pci1.descuento_aplicado,lo.registro_comision registroComision,
        lo.idStatusContratacion , pac.total_comision as totalComision,
        FORMAT(ISNULL( pac.total_comision , '0.00'),'C') allComision,
        UPPER(REPLACE(oxc.nombre, ' (especificar)', '')) AS lugar_prospeccion, oxcest.color   ,
        (CASE lo.idStatusContratacion WHEN '1' THEN '01' WHEN '2' THEN '02' WHEN '3' THEN '03' WHEN '4' THEN '04' WHEN '5' THEN '05' WHEN '6' THEN '06' 
        WHEN '7' THEN '07' WHEN '8' THEN '08' WHEN '9' THEN '09' WHEN '10' THEN '10' WHEN '11' THEN '11' WHEN '12' THEN '12' 
        WHEN '13' THEN '13' WHEN '14' THEN '14' WHEN '15' THEN '15' END)  contratacion , pac.bandera estatusComision   ,
        oxcest.color                  
        FROM pago_comision_ind pci1 
        LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision 
        FROM pago_comision_ind WHERE (estatus in (11,3) OR descuento_aplicado = 1) 
        GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
        LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado2, id_usuario ,id_comision
        FROM pago_comision_ind   WHERE estatus = (11)
        GROUP BY id_usuario,id_comision) pc14 ON pci1.id_usuario = pc14.id_usuario AND pc14.id_comision =  pci1.id_comision  and estatus = (11)
		INNER JOIN pago_comision_ind pci3 on pci1.id_pago_i = pci3.id_pago_i
        INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
        INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 $query
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
        LEFT JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 1 AND lo.idStatusContratacion > 8 AND com.estatus = 1
        INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
        LEFT JOIN pago_comision pac ON pac.id_lote = com.id_lote
        LEFT JOIN evidencia_cliente ec ON ec.idLote = lo.idLote AND ec.idCliente = lo.idCliente
        INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23
        LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = cl.lugar_prospeccion AND oxc.id_catalogo = 9
        LEFT JOIN sedes s ON lo.ubicacion  = s.id_sede 
        LEFT JOIN prospectos pr ON  pr.id_prospecto = cl.id_prospecto 
        LEFT JOIN sedes s3 ON lo.ubicacion = s3.id_sede 
        LEFT JOIN statuslote slo ON slo.idStatusLote = lo.idStatusLote
        LEFT JOIN penalizaciones pe ON pe.id_lote = lo.idLote AND pe.id_cliente = lo.idCliente
        $query2 
        GROUP BY pci1.id_comision, lo.idLote ,lo.nombreLote, co.nombre, lo.totalNeto2, com.comision_total,pac.bandera , pac.bonificacion ,
        com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado,pc14.abono_pagado2,pci3.abono_neodata,pci3.pago_neodata,  pci1.estatus,cl.fechaApartado, pci1.fecha_abono,  pci1.fecha_abono,
        pci1.id_usuario, pci1.id_pago_i, u.nombre, u.apellido_paterno, u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, 
        pci1.descuento_aplicado, lo.idStatusContratacion,oxc.nombre , com.estatus, lo.referencia, com.estatus, u.estatus,pac.total_comision, oxcest.color
		,slo.nombre ,slo.color,s.nombre, s3.nombre ,registro_comision ,ec.estatus,   pr.source ,pe.id_penalizacion ORDER BY lo.nombreLote";

        return $this->db->query($cmd);
    }
    
    function getComments($pago){
        $this->db->query("SET LANGUAGE Español;");
        return $this->db->query("SELECT DISTINCT(hc.comentario), hc.id_pago_i, hc.id_usuario, 
        convert(nvarchar(20), hc.fecha_movimiento, 113) date_final,
        hc.fecha_movimiento,
        CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre_usuario
        FROM historial_comisiones hc 
        INNER JOIN pago_comision_ind pci ON pci.id_pago_i = hc.id_pago_i
        INNER JOIN usuarios u ON u.id_usuario = hc.id_usuario 
        WHERE hc.id_pago_i = $pago
        ORDER BY hc.fecha_movimiento DESC");
    }

    public function getReporteLotesPorComisionista($beginDate, $endDate, $comisionista, $tipoUsuario) {
        $filtroFecha = " AND cl.fechaApartado BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59'";
        if($tipoUsuario == 7) // SE BUSCA COMO ASESOR
            $filtroComisionista = "AND cl.id_asesor = $comisionista";   
        else if($tipoUsuario == 9) // SE BUSCA COMO COORDINADOR
            $filtroComisionista = "AND cl.id_coordinador = $comisionista";
        else if($tipoUsuario == 3) // SE BUSCA COMO GERENTE
            $filtroComisionista = "AND cl.id_gerente = $comisionista";
        else if($tipoUsuario == 2) // SE BUSCA COMO SUBDIRECOR
            $filtroComisionista = "AND cl.id_subdirector = $comisionista";
        else if($tipoUsuario == 59) // SE BUSCA COMO DIRECTOR REGIONAL
            $filtroComisionista = "AND cl.id_regional = $comisionista";
        else // SE BUSCA COMO DIRECTOR COMERCIAL
            $filtroComisionista = "";
        
        $query="SELECT UPPER(CAST(re.descripcion AS VARCHAR(74))) nombreResidencial, UPPER(cn.nombre) nombreCondominio, UPPER(lo.nombreLote) nombreLote, lo.idLote,
        FORMAT(ISNULL(lo.totalNeto2, '0.00'), 'C') precioTotalLote, CONVERT(varchar, cl.fechaApartado, 20) fechaApartado, UPPER(ISNULL(se.nombre, 'SIN ESPECIFICAR')) plaza,
        lo.idStatusContratacion, sl.nombre nombreEstatusLote, sl.color, sl.background_sl, lo.registro_comision registroComision, 
        0 estatusComision, 0.00 porcentaje_decimal,
        '0.00' comisionTotal, '0.00' abonoDispersado, '0.00' abonoPagado, 0 rec,
        UPPER(REPLACE(ISNULL(oxc.nombre, 'SIN ESPECIFICAR'), ' (especificar)', '')) AS lugar_prospeccion,
        UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)) nombreCliente,
        UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) nombreAsesor,
        ISNULL(UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)), 'SIN ESPECIFICAR') nombreCoordinador,
        ISNULL(UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)), 'SIN ESPECIFICAR') nombreGerente,
        ISNULL(UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)), 'SIN ESPECIFICAR') nombreSubdirector,
        ISNULL(UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)), 'SIN ESPECIFICAR') nombreRegional,
		0 as ultimoEstatusCanceladas, pc.abonado pagoCliente
        FROM lotes lo
        INNER JOIN condominios cn ON cn.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = cn.idResidencial
        INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente AND cl.status = 1 $filtroComisionista $filtroFecha
        INNER JOIN usuarios u0 ON u0.id_usuario = cl.id_asesor
        LEFT JOIN usuarios u1 ON u1.id_usuario = cl.id_coordinador
        LEFT JOIN usuarios u2 ON u2.id_usuario = cl.id_gerente
        LEFT JOIN usuarios u3 ON u3.id_usuario = cl.id_subdirector
        LEFT JOIN usuarios u4 ON u4.id_usuario = cl.id_regional
        LEFT JOIN sedes se ON se.id_sede = cl.id_sede
		INNER JOIN statuslote sl ON sl.idStatusLote = lo.idStatusLote
        LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = cl.lugar_prospeccion AND oxc.id_catalogo = 9
        LEFT JOIN pago_comision pc ON pc.id_lote = lo.idLote
        WHERE lo.status = 1 AND lo.registro_comision NOT IN (1, 7)
        -- TRAE TODAS LAS VENTAS NUEVAS ACTIVAS SIN COMISIÓN
        UNION ALL
        -- TRAE TODAS LAS VENTAS ACTIVAS CON COMISIÓN
        SELECT UPPER(CAST(re.descripcion AS VARCHAR(74))) nombreResidencial, UPPER(cn.nombre) nombreCondominio, UPPER(lo.nombreLote) nombreLote, lo.idLote,
        FORMAT(ISNULL(lo.totalNeto2, '0.00'), 'C') precioTotalLote, CONVERT(varchar, cl.fechaApartado, 20) fechaApartado, UPPER(ISNULL(se.nombre, 'SIN ESPECIFICAR')) plaza,
        lo.idStatusContratacion, sl.nombre nombreEstatusLote, sl.color, sl.background_sl, lo.registro_comision registroComision, 
        pc.bandera estatusComision, ISNULL(cm.porcentaje_decimal, 0.00) porcentaje_decimal,
        ISNULL(cm.comision_total, '0.00') comisionTotal, 
        ISNULL(pci3.abonoDispersado, '0.00') abonoDispersado, 
        ISNULL(pci2.abonoPagado, '0.00') abonoPagado, cm.estatus rec,
        UPPER(REPLACE(ISNULL(oxc.nombre, 'SIN ESPECIFICAR'), ' (especificar)', '')) AS lugar_prospeccion,
        ISNULL(UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)), 'SIN ESPECIFICAR') nombreCliente,
        UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) nombreAsesor,
        ISNULL(UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)), 'SIN ESPECIFICAR') nombreCoordinador,
        ISNULL(UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)), 'SIN ESPECIFICAR') nombreGerente,
        ISNULL(UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)), 'SIN ESPECIFICAR') nombreSubdirector,
        ISNULL(UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)), 'SIN ESPECIFICAR') nombreRegional,
		0 as ultimoEstatusCanceladas, pc.abonado pagoCliente
        FROM lotes lo
        INNER JOIN condominios cn ON cn.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = cn.idResidencial
		INNER JOIN statuslote sl ON sl.idStatusLote = lo.idStatusLote
        INNER JOIN comisiones cm ON cm.id_lote = lo.idLote AND cm.id_usuario = $comisionista AND cm.estatus != 8
        INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente AND cl.status = 1 $filtroComisionista $filtroFecha
        INNER JOIN usuarios u0 ON u0.id_usuario = cl.id_asesor
        LEFT JOIN usuarios u1 ON u1.id_usuario = cl.id_coordinador
        LEFT JOIN usuarios u2 ON u2.id_usuario = cl.id_gerente
        LEFT JOIN usuarios u3 ON u3.id_usuario = cl.id_subdirector
        LEFT JOIN usuarios u4 ON u4.id_usuario = cl.id_regional
        LEFT JOIN sedes se ON se.id_sede = cl.id_sede
        LEFT JOIN pago_comision pc ON pc.id_lote = lo.idLote    
        LEFT JOIN (SELECT SUM(abono_neodata) abonoPagado, id_comision FROM pago_comision_ind WHERE estatus IN (11) GROUP BY id_comision) pci2 ON cm.id_comision = pci2.id_comision
        LEFT JOIN (SELECT SUM(abono_neodata) abonoDispersado, id_comision FROM pago_comision_ind GROUP BY id_comision) pci3 ON cm.id_comision = pci3.id_comision
        LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = cl.lugar_prospeccion AND oxc.id_catalogo = 9
        WHERE lo.status = 1
        GROUP BY 
		UPPER(CAST(re.descripcion AS VARCHAR(74))), UPPER(cn.nombre), UPPER(lo.nombreLote), lo.idLote,
        FORMAT(ISNULL(lo.totalNeto2, '0.00'), 'C'), CONVERT(varchar, cl.fechaApartado, 20), UPPER(ISNULL(se.nombre, 'SIN ESPECIFICAR')) ,
        lo.idStatusContratacion, sl.nombre, sl.color, sl.background_sl, lo.registro_comision, 
        pc.bandera, ISNULL(cm.porcentaje_decimal, 0.00),
        ISNULL(cm.comision_total, '0.00'), 
        ISNULL(pci3.abonoDispersado, '0.00'), 
        ISNULL(pci2.abonoPagado, '0.00'), cm.estatus,
        UPPER(REPLACE(ISNULL(oxc.nombre, 'SIN ESPECIFICAR'), ' (especificar)', '')),
        ISNULL(UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)), 'SIN ESPECIFICAR'),
        UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)),
        ISNULL(UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)), 'SIN ESPECIFICAR'),
        ISNULL(UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)), 'SIN ESPECIFICAR'),
        ISNULL(UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)), 'SIN ESPECIFICAR'),
        ISNULL(UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)), 'SIN ESPECIFICAR'), pc.abonado
        UNION ALL
        -- TRAE TODOAS LAS VENTAS DONDE EXISTE REGISTRO DE COMISIÓN PERO PUEDE O NO ESTAR RELACIONADO AL CLIENTE Y ES UNA RECISIÓN
        SELECT UPPER(CAST(re.descripcion AS VARCHAR(74))) nombreResidencial, UPPER(cn.nombre) nombreCondominio, UPPER(lo.nombreLote) nombreLote, lo.idLote,
        FORMAT(ISNULL(lo.totalNeto2, '0.00'), 'C') precioTotalLote, CONVERT(varchar, cl.fechaApartado, 20) fechaApartado, UPPER(ISNULL(se.nombre, 'SIN ESPECIFICAR')) plaza,
        lo.idStatusContratacion, sl.nombre nombreEstatusLote, sl.color, sl.background_sl, lo.registro_comision registroComision, 
        pc.bandera estatusComision, ISNULL(cm.porcentaje_decimal, 0.00) porcentaje_decimal,
        ISNULL(cm.comision_total, '0.00') comisionTotal, 
        ISNULL(pci3.abonoDispersado, '0.00') abonoDispersado, 
        ISNULL(pci2.abonoPagado, '0.00') abonoPagado, cm.estatus rec,
        UPPER(REPLACE(ISNULL(oxc.nombre, 'SIN ESPECIFICAR'), ' (especificar)', '')) lugar_prospeccion,
        ISNULL(UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)), 'SIN ESPECIFICAR') nombreCliente,
        UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) nombreAsesor,
        ISNULL(UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)), 'SIN ESPECIFICAR') nombreCoordinador,
        ISNULL(UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)), 'SIN ESPECIFICAR') nombreGerente,
        ISNULL(UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)), 'SIN ESPECIFICAR') nombreSubdirector,
        ISNULL(UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)), 'SIN ESPECIFICAR') nombreRegional,
		0 as ultimoEstatusCanceladas, pc.abonado pagoCliente
        FROM lotes lo
        INNER JOIN condominios cn ON cn.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = cn.idResidencial
		INNER JOIN statuslote sl ON sl.idStatusLote = lo.idStatusLote
        INNER JOIN comisiones cm ON cm.id_lote = lo.idLote AND cm.id_usuario = $comisionista AND cm.estatus = 8
        LEFT JOIN clientes cl ON cl.id_cliente = cm.idCliente $filtroComisionista $filtroFecha
        INNER JOIN usuarios u0 ON u0.id_usuario = cl.id_asesor
        LEFT JOIN usuarios u1 ON u1.id_usuario = cl.id_coordinador
        LEFT JOIN usuarios u2 ON u2.id_usuario = cl.id_gerente
        LEFT JOIN usuarios u3 ON u3.id_usuario = cl.id_subdirector
        LEFT JOIN usuarios u4 ON u4.id_usuario = cl.id_regional
        LEFT JOIN sedes se ON se.id_sede = cl.id_sede
        LEFT JOIN pago_comision pc ON pc.id_lote = lo.idLote    
        LEFT JOIN (SELECT SUM(abono_neodata) abonoPagado, id_comision FROM pago_comision_ind WHERE estatus IN (11) GROUP BY id_comision) pci2 ON cm.id_comision = pci2.id_comision
        LEFT JOIN (SELECT SUM(abono_neodata) abonoDispersado, id_comision FROM pago_comision_ind GROUP BY id_comision) pci3 ON cm.id_comision = pci3.id_comision
        LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = cl.lugar_prospeccion AND oxc.id_catalogo = 9
        WHERE lo.status = 1 
        UNION ALL
        -- SE TRAE TODAS LAS VENTAS LIQUIDADAS
        SELECT UPPER(CAST(re.descripcion AS VARCHAR(74))) nombreResidencial, UPPER(cn.nombre) nombreCondominio, UPPER(lo.nombreLote) nombreLote, lo.idLote,
        FORMAT(ISNULL(lo.totalNeto2, '0.00'), 'C') precioTotalLote, CONVERT(varchar, cl.fechaApartado, 20) fechaApartado, UPPER(ISNULL(se.nombre, 'SIN ESPECIFICAR')) plaza,
        lo.idStatusContratacion, sl.nombre nombreEstatusLote, sl.color, sl.background_sl, lo.registro_comision registroComision, 
        pc.bandera estatusComision, ISNULL(cm.porcentaje_decimal, 0.00) porcentaje_decimal,
        ISNULL(cm.comision_total, '0.00') comisionTotal, 
        ISNULL(pci3.abonoDispersado, '0.00') abonoDispersado, 
        ISNULL(pci2.abonoPagado, '0.00') abonoPagado, cm.estatus rec,
        UPPER(REPLACE(ISNULL(oxc.nombre, 'SIN ESPECIFICAR'), ' (especificar)', '')) lugar_prospeccion,
        ISNULL(UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)), 'SIN ESPECIFICAR') nombreCliente,
        UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) nombreAsesor,
        ISNULL(UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)), 'SIN ESPECIFICAR') nombreCoordinador,
        ISNULL(UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)), 'SIN ESPECIFICAR') nombreGerente,
        ISNULL(UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)), 'SIN ESPECIFICAR') nombreSubdirector,
        ISNULL(UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)), 'SIN ESPECIFICAR') nombreRegional,
		0 as ultimoEstatusCanceladas, pc.abonado pagoCliente
        FROM lotes lo
        INNER JOIN condominios cn ON cn.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = cn.idResidencial
		INNER JOIN statuslote sl ON sl.idStatusLote = lo.idStatusLote
        LEFT JOIN comisiones cm ON cm.id_lote = lo.idLote AND cm.id_usuario = $comisionista
        INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente AND cl.status = 1 $filtroComisionista $filtroFecha
        INNER JOIN usuarios u0 ON u0.id_usuario = cl.id_asesor
        LEFT JOIN usuarios u1 ON u1.id_usuario = cl.id_coordinador
        LEFT JOIN usuarios u2 ON u2.id_usuario = cl.id_gerente
        LEFT JOIN usuarios u3 ON u3.id_usuario = cl.id_subdirector
        LEFT JOIN usuarios u4 ON u4.id_usuario = cl.id_regional
        LEFT JOIN sedes se ON se.id_sede = cl.id_sede
        LEFT JOIN pago_comision pc ON pc.id_lote = lo.idLote    
        LEFT JOIN (SELECT SUM(abono_neodata) abonoPagado, id_comision FROM pago_comision_ind WHERE estatus IN (11) GROUP BY id_comision) pci2 ON cm.id_comision = pci2.id_comision
        LEFT JOIN (SELECT SUM(abono_neodata) abonoDispersado, id_comision FROM pago_comision_ind GROUP BY id_comision) pci3 ON cm.id_comision = pci3.id_comision
        LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = cl.lugar_prospeccion AND oxc.id_catalogo = 9
        WHERE lo.status = 1 AND lo.registro_comision = 7 AND cm.id_lote IS NULL
        UNION ALL
        -- TRAE LAS VENTAS CANCELADAS
        SELECT UPPER(CAST(re.descripcion AS VARCHAR(74))) nombreResidencial, UPPER(cn.nombre) nombreCondominio, UPPER(lo.nombreLote) nombreLote, lo.idLote,
        FORMAT(ISNULL(lo.totalNeto2, '0.00'), 'C') precioTotalLote, CONVERT(varchar, cl.fechaApartado, 20) fechaApartado, UPPER(ISNULL(se.nombre, 'SIN ESPECIFICAR')) plaza,
        lo.idStatusContratacion, sl.nombre nombreEstatusLote, sl.color, sl.background_sl, lo.registro_comision registroComision, 
        pc.bandera estatusComision, ISNULL(cm.porcentaje_decimal, 0.00) porcentaje_decimal,
        ISNULL(cm.comision_total, '0.00') comisionTotal, 
        ISNULL(pci3.abonoDispersado, '0.00') abonoDispersado, 
        ISNULL(pci2.abonoPagado, '0.00') abonoPagado, 8 rec,
        UPPER(REPLACE(ISNULL(oxc.nombre, 'SIN ESPECIFICAR'), ' (especificar)', '')) lugar_prospeccion,
        ISNULL(UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)), 'SIN ESPECIFICAR') nombreCliente,
        UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) nombreAsesor,
        ISNULL(UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)), 'SIN ESPECIFICAR') nombreCoordinador,
        ISNULL(UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)), 'SIN ESPECIFICAR') nombreGerente,
        ISNULL(UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)), 'SIN ESPECIFICAR') nombreSubdirector,
        ISNULL(UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)), 'SIN ESPECIFICAR') nombreRegional,
		hlo2.idStatusContratacion as ultimoEstatusCanceladas, pc.abonado pagoCliente
        FROM lotes lo
        INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 0 AND isNULL(cl.noRecibo, '') != 'CANCELADO' $filtroComisionista $filtroFecha
        INNER JOIN condominios cn ON cn.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = cn.idResidencial
		INNER JOIN statuslote sl ON sl.idStatusLote = lo.idStatusLote
		INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes GROUP BY idLote, idCliente) hlo ON hlo.idLote = lo.idLote AND hlo.idCliente = cl.id_cliente
        INNER JOIN historial_lotes hlo2 ON hlo2.idLote = hlo.idLote AND hlo2.idCliente = hlo.idCliente AND hlo2.modificado = hlo.modificado
        LEFT JOIN comisiones cm ON cm.id_lote = lo.idLote AND cm.id_usuario = $comisionista AND cm.estatus = 8 --AND cm.idCliente = cl.id_cliente
        INNER JOIN usuarios u0 ON u0.id_usuario = cl.id_asesor
        LEFT JOIN usuarios u1 ON u1.id_usuario = cl.id_coordinador
        LEFT JOIN usuarios u2 ON u2.id_usuario = cl.id_gerente
        LEFT JOIN usuarios u3 ON u3.id_usuario = cl.id_subdirector
        LEFT JOIN usuarios u4 ON u4.id_usuario = cl.id_regional
        LEFT JOIN sedes se ON se.id_sede = cl.id_sede
        LEFT JOIN pago_comision pc ON pc.id_lote = lo.idLote    
        LEFT JOIN (SELECT SUM(abono_neodata) abonoPagado, id_comision FROM pago_comision_ind WHERE estatus IN (11) GROUP BY id_comision) pci2 ON cm.id_comision = pci2.id_comision
        LEFT JOIN (SELECT SUM(abono_neodata) abonoDispersado, id_comision FROM pago_comision_ind GROUP BY id_comision) pci3 ON cm.id_comision = pci3.id_comision
        LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = cl.lugar_prospeccion AND oxc.id_catalogo = 9
        WHERE lo.status = 1 AND cm.id_comision IS NULL
        UNION ALL
        SELECT UPPER(CAST(re.descripcion AS VARCHAR(74))) nombreResidencial, UPPER(cn.nombre) nombreCondominio, UPPER(lo.nombreLote) nombreLote, lo.idLote,
        FORMAT(ISNULL(lo.totalNeto2, '0.00'), 'C') precioTotalLote, CONVERT(varchar, cl.fechaApartado, 20) fechaApartado, UPPER(ISNULL(se.nombre, 'SIN ESPECIFICAR')) plaza,
        lo.idStatusContratacion, sl.nombre nombreEstatusLote, sl.color, sl.background_sl, lo.registro_comision registroComision, 
        pc.bandera estatusComision, ISNULL(cm.porcentaje_decimal, 0.00) porcentaje_decimal,
        ISNULL(cm.comision_total, '0.00') comisionTotal, 
        ISNULL(pci3.abonoDispersado, '0.00') abonoDispersado, 
        ISNULL(pci2.abonoPagado, '0.00') abonoPagado, 8 rec,
        UPPER(REPLACE(ISNULL(oxc.nombre, 'SIN ESPECIFICAR'), ' (especificar)', '')) lugar_prospeccion,
        ISNULL(UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)), 'SIN ESPECIFICAR') nombreCliente,
        UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) nombreAsesor,
        ISNULL(UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)), 'SIN ESPECIFICAR') nombreCoordinador,
        ISNULL(UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)), 'SIN ESPECIFICAR') nombreGerente,
        ISNULL(UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)), 'SIN ESPECIFICAR') nombreSubdirector,
        ISNULL(UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)), 'SIN ESPECIFICAR') nombreRegional,
		hlo2.idStatusContratacion as ultimoEstatusCanceladas, pc.abonado pagoCliente
        FROM lotes lo
        INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 0 AND isNULL(cl.noRecibo, '') != 'CANCELADO' $filtroComisionista $filtroFecha
        INNER JOIN condominios cn ON cn.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = cn.idResidencial
		INNER JOIN statuslote sl ON sl.idStatusLote = lo.idStatusLote
		INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes GROUP BY idLote, idCliente) hlo ON hlo.idLote = lo.idLote AND hlo.idCliente = cl.id_cliente
        INNER JOIN historial_lotes hlo2 ON hlo2.idLote = hlo.idLote AND hlo2.idCliente = hlo.idCliente AND hlo2.modificado = hlo.modificado
        LEFT JOIN comisiones cm ON cm.id_lote = lo.idLote AND cm.id_usuario = $comisionista AND cm.estatus = 8 --AND cm.idCliente = cl.id_cliente
        INNER JOIN usuarios u0 ON u0.id_usuario = cl.id_asesor
        LEFT JOIN usuarios u1 ON u1.id_usuario = cl.id_coordinador
        LEFT JOIN usuarios u2 ON u2.id_usuario = cl.id_gerente
        LEFT JOIN usuarios u3 ON u3.id_usuario = cl.id_subdirector
        LEFT JOIN usuarios u4 ON u4.id_usuario = cl.id_regional
        LEFT JOIN sedes se ON se.id_sede = cl.id_sede
        LEFT JOIN pago_comision pc ON pc.id_lote = lo.idLote
        LEFT JOIN (SELECT SUM(abono_neodata) abonoPagado, id_comision FROM pago_comision_ind WHERE estatus IN (11) GROUP BY id_comision) pci2 ON cm.id_comision = pci2.id_comision
        LEFT JOIN (SELECT SUM(abono_neodata) abonoDispersado, id_comision FROM pago_comision_ind GROUP BY id_comision) pci3 ON cm.id_comision = pci3.id_comision
        LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = cl.lugar_prospeccion AND oxc.id_catalogo = 9
        WHERE lo.status = 1 AND cm.id_comision IS NOT NULL
        ORDER BY nombreLote";
        return $this->db->query($query);
    }
    
    public function getOpcionesParaReporteComisionistas($condicionXUsuario) {
        return $this->db->query("SELECT us.id_usuario id_opcion, UPPER(CONCAT(us.id_usuario, ' - ', us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno)) nombre, 
        us.estatus atributo_extra, 1 id_catalogo, oxc.nombre atributo_extra2
		FROM usuarios us
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = us.id_rol AND oxc.id_catalogo = 1
		WHERE us.id_rol IN (1, 2, 3, 9, 7) AND us.estatus != 0 AND (us.rfc NOT LIKE '%TSTDD%' AND ISNULL(us.correo, '' ) NOT LIKE '%test_%' AND ISNULL(us.correo, '' ) NOT LIKE '%OOAM%' AND ISNULL(us.correo, '') NOT LIKE '%CASA%') $condicionXUsuario
		UNION ALL
		SELECT id_opcion, UPPER(nombre) nombre, id_catalogo atributo_extra, 2 id_catalogo,'0' atributo_extra2
        FROM opcs_x_cats WHERE id_catalogo = 1 AND id_opcion IN (1, 2, 3, 9, 7, 59)
		ORDER BY id_catalogo, UPPER(CONCAT(us.id_usuario, ' - ', us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno))");
    }
    
    public function getVentasActivasPorRol($comisionista) {
        return $this->db->query("SELECT COUNT(*) totalVentas, 'id_asesor' columna FROM clientes WHERE id_asesor = $comisionista AND status = 1 UNION ALL
        SELECT COUNT(*) totalVentas, 'id_coordinador' columna FROM clientes WHERE id_coordinador = $comisionista AND status = 1 UNION ALL
        SELECT COUNT(*) totalVentas, 'id_gerente' columna FROM clientes WHERE id_gerente = $comisionista AND status = 1 UNION ALL
        SELECT COUNT(*) totalVentas, 'id_subdirector' columna FROM clientes WHERE id_subdirector = $comisionista AND status = 1 UNION ALL
        SELECT COUNT(*) totalVentas, 'id_regional' columna FROM clientes WHERE id_regional = $comisionista AND status = 1");
    }

    public function getVentasPorRolPorAnio($comisionista, $columna) {
        return $this->db->query("SELECT tbl1.anio, ISNULL(tbl1.total, 0) activas, ISNULL(tbl2.total, 0) canceladas, (ISNULL(tbl1.total, 0) + ISNULL(tbl2.total, 0)) total FROM (
        SELECT YEAR(cl.fechaApartado) anio, COUNT(*) total
        FROM clientes cl 
        INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.status = 1
        INNER JOIN usuarios u0 ON u0.id_usuario = cl.id_asesor
        WHERE cl.$columna = $comisionista AND cl.status = 1 GROUP BY YEAR(cl.fechaApartado)) tbl1
        LEFT JOIN (
        SELECT YEAR(cl.fechaApartado) anio, COUNT(*) total
        FROM clientes cl 
        INNER JOIN lotes lo ON lo.idLote = cl.idLote AND lo.status = 1
        INNER JOIN usuarios u0 ON u0.id_usuario = cl.id_asesor
        WHERE cl.$columna = $comisionista AND cl.status = 0 AND isNULL(noRecibo, '') != 'CANCELADO' GROUP BY YEAR(cl.fechaApartado)) tbl2 ON tbl2.anio = tbl1.anio
        ORDER BY tbl1.anio");
    }
}
