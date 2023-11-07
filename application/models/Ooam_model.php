<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ooam_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }


    function getRevisionAsimiladosOOAM($proyecto, $condominio){
        if($this->session->userdata('id_rol') == 31) { // INTERNOMEX
            $filtro = "pci1.estatus IN (8, 88) AND com.id_usuario = $condominio";
            $where = "";
        } else { // CONTRALORÍA
            $filtro = "pci1.estatus IN (4)";
            if($condominio == 0)
                $where = "AND co.idResidencial  = $proyecto";
            else
                $where = "AND co.idCondominio  = $condominio";       
        }

        $cmd = "SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as nombreLote, re.nombreResidencial as proyecto, lo.nombreLote as lote, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus,  CONVERT(VARCHAR,pci1.fecha_pago_intmex,20) AS fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario, cp1.codigo_postal, pci1.id_usuario, oprol.nombre  puesto, 0 personalidad_juridica, u.forma_pago, 0 as factura, pac.porcentaje_abonado, oxcest.nombre as estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, 0 lugar_prospeccion, co.nombre as condominio, lo.referencia, (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, (CASE u.forma_pago WHEN 3 THEN (((sed.impuesto)/100)*pci1.abono_neodata) ELSE 0 END) dcto, sed.impuesto valimpuesto, u.rfc
        FROM pago_ooam_ind pci1 
        INNER JOIN comisiones_ooam com ON pci1.id_comision = com.id_comision
        INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (3)
        INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
        INNER JOIN pago_ooam pac ON pac.id_lote = com.id_lote
        INNER JOIN cp_usuarios cp1 ON pci1.id_usuario = cp1.id_usuario
        INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
        INNER JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 2 WHEN 4 THEN 5 WHEN 5 THEN 3 WHEN 607 THEN 1 WHEN 7092 THEN 4 WHEN 9629 THEN 2 ELSE u.id_sede END) and sed.estatus = 1
        LEFT JOIN opcs_x_cats oprol2 ON oprol2.id_opcion = com.rol_generado AND oprol2.id_catalogo = 83
        WHERE $filtro $where
        GROUP BY pci1.id_comision,lo.nombreLote,  re.nombreResidencial, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex, pci1.id_usuario, u.forma_pago, pci1.id_pago_i, pac.porcentaje_abonado, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, cp1.codigo_postal, oxcest.nombre, oxcest.id_opcion, re.empresa, co.nombre, lo.referencia,sed.impuesto, u.rfc, oprol2.nombre";

        $query = $this->db->query($cmd); 

        return $query->result_array();
    }


    function getRevisionRemanenteOOAM($proyecto, $condominio){
        if($this->session->userdata('id_rol') == 31) { // INTERNOMEX
            $filtro = "pci1.estatus IN (8, 88) AND com.id_usuario = $condominio";
            $where = "";
        } else { // CONTRALORÍA
            $filtro = "pci1.estatus IN (4)";
            if($condominio == 0)
                $where = "AND co.idResidencial  = $proyecto";
            else
                $where = "AND co.idCondominio  = $condominio";       
        }

        $cmd = "SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as nombreLote, re.nombreResidencial as proyecto, lo.nombreLote as lote, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus,  CONVERT(VARCHAR,pci1.fecha_pago_intmex,20) AS fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario, pci1.id_usuario, oprol.nombre  puesto, 0 personalidad_juridica, u.forma_pago, 0 as factura, pac.porcentaje_abonado, oxcest.nombre as estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, 0 lugar_prospeccion, co.nombre as condominio, lo.referencia, (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, (CASE u.forma_pago WHEN 3 THEN (((sed.impuesto)/100)*pci1.abono_neodata) ELSE 0 END) dcto, sed.impuesto valimpuesto, u.rfc
        FROM pago_ooam_ind pci1 
        INNER JOIN comisiones_ooam com ON pci1.id_comision = com.id_comision
        INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (4)
        INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
        INNER JOIN pago_ooam pac ON pac.id_lote = com.id_lote
        INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
        INNER JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 2 WHEN 4 THEN 5 WHEN 5 THEN 3 WHEN 607 THEN 1 WHEN 7092 THEN 4 WHEN 9629 THEN 2 ELSE u.id_sede END) and sed.estatus = 1
        LEFT JOIN opcs_x_cats oprol2 ON oprol2.id_opcion = com.rol_generado AND oprol2.id_catalogo = 83
        WHERE $filtro $where
        GROUP BY pci1.id_comision,lo.nombreLote,  re.nombreResidencial, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex, pci1.id_usuario, u.forma_pago, pci1.id_pago_i, pac.porcentaje_abonado, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, co.nombre, lo.referencia,sed.impuesto, u.rfc, oprol2.nombre";

        $query = $this->db->query($cmd); 

        return $query->result_array();
    }

    function getRevisionFacturasOOAM($proyecto, $condominio){
        if($this->session->userdata('id_rol') == 31) { // INTERNOMEX
            $filtro = "pci1.estatus IN (8, 88) AND com.id_usuario = $condominio";
            $where = "";
        } else { // CONTRALORÍA
            $filtro = "pci1.estatus IN (4)";
            if($condominio == 0)
                $where = "AND co.idResidencial  = $proyecto";
            else
                $where = "AND co.idCondominio  = $condominio";       
        }

        $cmd = "SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as nombreLote, re.nombreResidencial as proyecto, lo.nombreLote as lote, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus,  CONVERT(VARCHAR,pci1.fecha_pago_intmex,20) AS fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario, pci1.id_usuario, oprol.nombre  puesto, 0 personalidad_juridica, u.forma_pago, 0 as factura, pac.porcentaje_abonado, oxcest.nombre as estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, 0 lugar_prospeccion, co.nombre as condominio, lo.referencia, (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, (CASE u.forma_pago WHEN 3 THEN (((sed.impuesto)/100)*pci1.abono_neodata) ELSE 0 END) dcto, sed.impuesto valimpuesto, u.rfc
        FROM pago_ooam_ind pci1 
        INNER JOIN comisiones_ooam com ON pci1.id_comision = com.id_comision
        INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (2)
        INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
        INNER JOIN pago_ooam pac ON pac.id_lote = com.id_lote
        INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
        INNER JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 2 WHEN 4 THEN 5 WHEN 5 THEN 3 WHEN 607 THEN 1 WHEN 7092 THEN 4 WHEN 9629 THEN 2 ELSE u.id_sede END) and sed.estatus = 1
        LEFT JOIN opcs_x_cats oprol2 ON oprol2.id_opcion = com.rol_generado AND oprol2.id_catalogo = 83
        WHERE $filtro $where
        GROUP BY pci1.id_comision,lo.nombreLote,  re.nombreResidencial, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex, pci1.id_usuario, u.forma_pago, pci1.id_pago_i, pac.porcentaje_abonado, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, co.nombre, lo.referencia,sed.impuesto, u.rfc, oprol2.nombre";

        $query = $this->db->query($cmd); 

        return $query->result_array();
    }


    public function consulta_comisiones($sol){
        $cmd = ("SELECT id_pago_i FROM pago_ooam_ind where id_pago_i IN (".$sol.")");
        $query = $this->db->query($cmd);       
         return  count($query->result_array()) > 0 ? $query->result_array() : FALSE ;

    }


    public function update_acepta_contraloria($data , $clave){
     
        try {

          $id_user_Vl = $this->session->userdata('id_usuario');
            $cmd = "UPDATE pago_ooam_ind SET estatus = 8, modificado_por =  $id_user_Vl  WHERE id_pago_i IN  ($clave) ";
            $query = $this->db->query($cmd);
            
            if($this->db->affected_rows() > 0 )
            {
                return TRUE;
            }else{
                return FALSE;
            }               
          }
          catch(Exception $e) {
              return $e->getMessage();
          }     
          }

    function insert_phc($data){
            $this->db->insert_batch('historial_ooam', $data);
            return true;
    }


    
    function getComments($pago){
        
        $cmd = "SELECT DISTINCT(hc.comentario), hc.id_pago_i, hc.id_usuario, 
        convert(nvarchar(20), hc.fecha_movimiento, 113) date_final,
        hc.fecha_movimiento,
        CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre_usuario
        FROM historial_ooam hc 
        INNER JOIN pago_ooam_ind pci ON pci.id_pago_i = hc.id_pago_i
        INNER JOIN usuarios u ON u.id_usuario = hc.id_usuario 
        WHERE hc.id_pago_i = $pago
        ORDER BY hc.fecha_movimiento DESC";

        $query = $this->db->query($cmd);
        return $query->result();
        
        }


                

function setPausaPagosOOAM($id_pago_i, $obs) {
    $id_user_Vl = $this->session->userdata('id_usuario');
    $respuesta = $this->db->query("INSERT INTO  historial_ooam VALUES ($id_pago_i, $id_user_Vl, GETDATE(), 1, 'SE PAUSÓ COMISIÓN, MOTIVO: ".$obs."')");
    $respuesta = $this->db->query("UPDATE pago_ooam_ind SET estatus = 6, comentario = '".$obs."',modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_i IN (".$id_pago_i.")");
    $row = $this->db->query("SELECT uuid FROM facturas_ooam WHERE id_comision = ".$id_pago_i.";")->result_array();
     
    if(count($row) > 0){
        $datos =  $this->db->query("SELECT id_factura, total, id_comision, bandera FROM facturas_ooam WHERE uuid='".$row[0]['uuid']."'")->result_array();
   
       for ($i=0; $i <count($datos); $i++) { 
               if($datos[$i]['bandera'] == 1){
                   $respuesta = 1;
               }else{
                   $comentario = 'Se regresó esta factura que correspondo al pago con id '.$datos[$i]['id_comision'].' con el monto global de '.$datos[$i]['total'].' por motivo de: '.$obs.' ';
                   $respuesta = $this->db->query("UPDATE facturas_ooam set total = 0, id_comision = 0, bandera = 1,descripcion = '$comentario' where id_factura = ".$datos[$i]['id_factura']."");
                   $respuesta = $this->db->query("INSERT INTO historial_ooam VALUES (".$datos[$i]['id_comision'].", ".$this->session->userdata('id_usuario').", GETDATE(), 1, '".$comentario."')");
               } 
       }
   }

    return $respuesta;

  }


  function validaLoteComision($id_lote, $referencia){
    $query = $this->db->query("SELECT po.id_lote 
    FROM pago_ooam po 
    INNER JOIN lotes lo ON lo.idLote = po.id_lote
    WHERE po.id_lote = $id_lote AND lo.referencia = '".$referencia."'");

    return $query->result_array();
}

    function insertComisionOOAM($tabla, $data) {
        if ($data != '' && $data != null){
            $response = $this->db->insert($tabla, $data);
            if (!$response) {
                return 0;
            } else {
                return 1;
            }
        } else {
            return 0;
        }
    }


function getPlanComision($rol, $planComision){
    $query = $this->db->query("SELECT (CASE 
    WHEN $rol = asesor THEN comAs 
    WHEN $rol = coordinador THEN comCo
    WHEN $rol = gerente THEN comGe 
    WHEN $rol = subdirector THEN comSu 
    WHEN $rol = director THEN comDi 
    END) AS porcentajeComision,
    (CASE 
    WHEN $rol = asesor THEN neoAs 
    WHEN $rol = coordinador THEN neoCo 
    WHEN $rol = gerente THEN neoGe 
    WHEN $rol = subdirector THEN neoSu 
    WHEN $rol = director THEN neoDi 
    END) AS porcentajeNeodata
    
    FROM plan_comision WHERE id_plan = $planComision");
    return $query->row();
}



public function getDataDispersionOOAM() {
    $this->db->query("SET LANGUAGE Español;");
    $query = $this->db->query("SELECT DISTINCT(l.idLote), res.nombreResidencial, cond.nombre as nombreCondominio, l.nombreLote, (CASE WHEN l.tipo_venta = 1 THEN 'Particular' WHEN l.tipo_venta = 2 THEN 'NORMAL' ELSE ' SIN DEFINIR' END) tipo_venta, (CASE WHEN l.tipo_venta = 1 THEN 'lbl-warning' WHEN l.tipo_venta = 2 THEN 'lbl-green' ELSE 'lbl-gray' END) claseTipo_venta, pc.nombreCliente, pc.estatusContratacion idStatusOOAM, l.totalNeto2, (CASE WHEN year(pc.fecha_modificacion) < 2019 THEN NULL ELSE convert(nvarchar,  pc.fecha_modificacion , 6) END) fecha_sistema, l.referencia, pc.numero_dispersion, pc.bandera,
    CONCAT(ae.nombre, ' ', ae.apellido_paterno, ' ', ae.apellido_materno) as asesor, 
    CONCAT(co.nombre, ' ', co.apellido_paterno, ' ', co.apellido_materno) as coordinador,
    CONCAT(ge.nombre, ' ', ge.apellido_paterno, ' ', ge.apellido_materno) as gerente, 
    CONCAT(di.nombre, ' ', di.apellido_paterno, ' ', di.apellido_materno) as director, 
    (CASE WHEN pc.plan_comision IN (0) OR pc.plan_comision IS NULL THEN '-' ELSE pl.descripcion END) AS plan_descripcion, pc.plan_comision, l.registro_comision 
    FROM lotes l
	INNER JOIN pago_ooam pc ON pc.id_lote = l.idLote AND pc.bandera in (0,100)
    INNER JOIN condominios cond ON l.idCondominio = cond.idCondominio
    INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial   
    INNER JOIN usuarios ae ON ae.id_usuario = (SELECT c.id_usuario FROM comisiones c WHERE c.rol_generado = 7 AND c.id_lote = pc.id_lote GROUP BY c.id_usuario) 
    LEFT JOIN usuarios co ON co.id_usuario = (SELECT c.id_usuario FROM comisiones c WHERE c.rol_generado = 9 AND c.id_lote = pc.id_lote GROUP BY c.id_usuario)
    LEFT JOIN usuarios ge ON ge.id_usuario = (SELECT c.id_usuario FROM comisiones c WHERE c.rol_generado = 3 AND c.id_lote = pc.id_lote GROUP BY c.id_usuario)
    LEFT JOIN usuarios su ON su.id_usuario = (SELECT c.id_usuario FROM comisiones c WHERE c.rol_generado = 2 AND c.id_lote = pc.id_lote GROUP BY c.id_usuario)
    LEFT JOIN usuarios di ON di.id_usuario = (SELECT c.id_usuario FROM comisiones c WHERE c.rol_generado = 1 AND c.id_lote = pc.id_lote GROUP BY c.id_usuario)
    LEFT JOIN plan_comision pl ON pl.id_plan = pc.plan_comision
    WHERE pc.bandera in (0,100) ORDER BY l.idLote");
        
    return $query;
}

function getMontoDispersado(){
    return $this->db->query("SELECT SUM(abono_neodata) monto FROM pago_ooam_ind WHERE id_comision IN (select id_comision from comisiones_ooam) AND MONTH(GETDATE()) = MONTH(fecha_abono) AND Day(GetDate()) = Day(fecha_abono)");
}

function getPagosDispersado(){
    return $this->db->query("SELECT count(id_pago_i) pagos FROM pago_ooam_ind WHERE id_comision IN (select id_comision from comisiones_ooam) AND MONTH(GETDATE()) = MONTH(fecha_abono) AND Day(GetDate()) = Day(fecha_abono) AND abono_neodata>0");
}

function getLotesDispersado(){
    return $this->db->query("SELECT count(distinct(id_lote)) lotes FROM comisiones_ooam WHERE id_comision IN (select id_comision from pago_ooam_ind WHERE MONTH(GETDATE()) = MONTH(fecha_abono) AND Day(GetDate()) = Day(fecha_abono) AND id_comision IN (SELECT id_comision FROM comisiones_ooam))");
}

public function getDatosAbonadoSuma11($idlote){
    // validar 
    return $this->db->query("SELECT SUM(pci.abono_neodata) abonado, pac.total_comision, c2.abono_pagado, lo.totalNeto2, cl.lugar_prospeccion
    FROM lotes lo
    INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente
    INNER JOIN comisiones c1 ON lo.idLote = c1.id_lote AND c1.estatus = 1
    LEFT JOIN (SELECT SUM(comision_total) abono_pagado, id_comision FROM comisiones_ooam WHERE descuento in (1) AND estatus = 1 GROUP BY id_comision) c2 ON c1.id_comision = c2.id_comision
    INNER JOIN pago_ooam pac ON pac.id_lote = lo.idLote
    LEFT JOIN pago_ooam_ind pci on pci.id_comision = c1.id_comision
    WHERE lo.status = 1 AND cl.status = 1 AND c1.estatus = 1 AND lo.idLote in ($idlote)
    GROUP BY lo.idLote, lo.referencia, pac.total_comision, lo.totalNeto2, cl.lugar_prospeccion, c2.abono_pagado");
}

public function getDatosAbonadoDispersion($idlote){
       
    return $this->db->query("SELECT com.id_comision, com.id_usuario, lo.totalNeto2, lo.idLote, res.idResidencial, lo.referencia, lo.tipo_venta, com.id_lote, lo.nombreLote, com.porcentaje_decimal, CONCAT(us.nombre,' ' ,us.apellido_paterno,' ',us.apellido_materno) colaborador, oxc.nombre as rol, com.comision_total, pci.abono_pagado, com.rol_generado, com.descuento
    FROM comisiones_ooam com
    LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_ooam_ind 
    GROUP BY id_comision) pci ON pci.id_comision = com.id_comision
    INNER JOIN lotes lo ON lo.idLote = com.id_lote 
    INNER JOIN usuarios us ON us.id_usuario = com.id_usuario
    INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = com.rol_generado AND oxc.id_catalogo = 1
    INNER JOIN condominios con ON con.idCondominio = lo.idCondominio
    INNER JOIN residenciales res ON res.idResidencial = con.idResidencial
    LEFT JOIN opcs_x_cats oxc2 ON oxc2.id_opcion = com.rol_generado AND oxc2.id_catalogo = 83
    WHERE com.id_lote = $idlote AND com.estatus = 1  ORDER BY com.rol_generado asc");
}


function insert_dispersion_individual($id_comision, $id_usuario, $abono_nuevo, $pago){

    $llenarTablaCliente = ("SELECT com.id_comision, com.id_usuario, lo.totalNeto2, lo.idLote, res.idResidencial, lo.referencia, lo.tipo_venta, com.id_lote, lo.nombreLote, com.porcentaje_decimal, CONCAT(us.nombre,' ' ,us.apellido_paterno,' ',us.apellido_materno) colabora");
  
    $respuesta = $this->db->query("INSERT INTO pago_ooam_ind (id_comision, id_usuario, abono_neodata, pago_neodata, estatus, creado_por, comentario, descuento_aplicado, modificado_por, abono_final) 
    VALUES (".$id_comision.", ".$id_usuario.", ".$abono_nuevo.",".$pago.", 1, ".$this->session->userdata('id_usuario').", 'NUEVO PAGO', 0, ".$this->session->userdata('id_usuario').", 0)");


    $insert_id_2 = $this->db->insert_id();
    $respuesta = $this->db->query("INSERT INTO historial_ooam VALUES ($insert_id_2, ".$this->session->userdata('id_usuario').", GETDATE(), 1, 'DISPERSÓ PAGO DE COMISIÓN')");

    if (! $respuesta ) {
        return 0;
        } else {   
        return 1;
        }
    }

    public function UpdateLoteDisponible($lote){
        $respuesta =  $this->db->query("UPDATE pago_ooam SET bandera = 1 WHERE id_lote = $lote");
        $respuesta =  $this->db->query("UPDATE pago_ooam_ind SET estatus = 0,modificado_por='".$this->session->userdata('id_usuario')."' WHERE abono_neodata = 0");
        $respuesta =  $this->db->query("UPDATE comisiones_ooam SET estatus = 0,modificado_por='".$this->session->userdata('id_usuario')."' WHERE comision_total = 0");
        // $respuesta =  $this->db->query("UPDATE lotes SET registro_comision = 1,usuario=".$this->session->userdata('id_usuario')." WHERE idLote = $lote");
        if (! $respuesta ) {
            return 0;
        } else {
            return 1;
        }
    }

        function update_pago_dispersion($suma, $ideLote, $pago){
        $respuesta = $this->db->query("UPDATE pago_ooam SET abonado = (abonado + ".$suma."), pendiente = (total_comision-abonado-".$suma."), bandera = 1, ultimo_pago = ".$pago." , ultima_dispersion = GETDATE() WHERE id_lote = ".$ideLote."");
        if (! $respuesta ) {
            return 0;
        } else {
            return 1;
        }
    }

    public function lotes(){
        $cmd = "SELECT SUM(lotes)  nuevo_general 
        FROM (SELECT  COUNT(DISTINCT(id_lote)) lotes 
        FROM pago_ooam_ind pci 
        INNER JOIN comisiones_ooam c on c.id_comision = pci.id_comision 
        INNER JOIN usuarios u ON u.id_usuario = pci.creado_por 
        AND u.id_rol IN (32,13,17) 
        INNER JOIN lotes l ON l.idLote = c.id_lote 
        WHERE MONTH(GETDATE()) = MONTH(pci.fecha_abono) 
        AND year(GetDate()) = year(pci.fecha_abono) 
        AND Day(GetDate()) = Day(pci.fecha_abono) 
        AND pci.estatus NOT IN (0) 
        AND l.tipo_venta NOT IN (7) 
        GROUP BY u.id_usuario) as nuevo_general";
         $query = $this->db->query($cmd); 
         $query->result();
         return $query->row();
    }

    public function pagos(){
        $cmd = "SELECT SUM(pagos) nuevo_general 
        FROM (SELECT  count(id_pago_i) pagos 
        FROM pago_ooam_ind pci 
        INNER JOIN comisiones_ooam c on c.id_comision = pci.id_comision 
        INNER JOIN usuarios u ON u.id_usuario = pci.creado_por 
        AND u.id_rol IN (32,13,17) 
        INNER JOIN lotes l ON l.idLote = c.id_lote 
        WHERE MONTH(GETDATE()) = MONTH(pci.fecha_abono) 
        AND year(GetDate()) = year(pci.fecha_abono) 
        AND Day(GetDate()) = Day(pci.fecha_abono) 
        AND pci.estatus NOT IN (0)
        AND l.tipo_venta NOT IN (7) 
        GROUP BY u.id_usuario) as nuevo_general ";
        $query = $this->db->query($cmd);
        $query->result();
        return $query->row();
    }

    public function monto(){
        $cmd = "SELECT ROUND (SUM(monto), 3 ) nuevo_general 
        FROM (SELECT SUM(pci.abono_neodata) monto 
        FROM pago_ooam_ind pci 
        INNER JOIN comisiones_ooam c on c.id_comision = pci.id_comision 
        INNER JOIN usuarios u ON u.id_usuario = pci.creado_por 
        AND u.id_rol IN (32,13,17) INNER JOIN lotes l ON l.idLote = c.id_lote 
        WHERE MONTH(GETDATE()) = MONTH(pci.fecha_abono) 
        AND year(GetDate()) = year(pci.fecha_abono)
        AND Day(GetDate()) = Day(pci.fecha_abono) 
        AND pci.estatus NOT IN (0) 
        AND l.tipo_venta NOT IN (7)
        GROUP BY u.id_usuario) as nuevo_general ";
        $query = $this->db->query($cmd);
        $query->result();
        return $query->row();
    }




 
}// llave fin del modal

