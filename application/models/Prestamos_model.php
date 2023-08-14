<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Prestamos_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    function getPrestamos(){
        $query = $this->db->query("SELECT CONCAT(u.nombre, ' ', u.apellido_paterno, ' ' ,u.apellido_materno) as nombre, p.id_prestamo,p.id_usuario,p.monto,p.num_pagos,p.estatus,p.comentario,p.fecha_creacion,p.pago_individual,pendiente,SUM(pci.abono_neodata) as total_pagado,opc.nombre as tipo,opc.id_opcion, (SELECT TOP 1 rpp2.fecha_creacion FROM relacion_pagos_prestamo rpp2 WHERE rpp2.id_prestamo = rpp.id_prestamo ORDER BY rpp2.id_relacion_pp DESC) AS fecha_creacion_referencia, rpp.id_prestamo as id_prestamo2
        FROM prestamos_aut p 
        INNER JOIN usuarios u ON u.id_usuario=p.id_usuario 
        LEFT JOIN relacion_pagos_prestamo rpp ON rpp.id_prestamo = p.id_prestamo
        LEFT JOIN pago_comision_ind pci ON pci.id_pago_i = rpp.id_pago_i AND pci.estatus in (18,19,20,21,22,23,24,25,26,28,29) AND pci.descuento_aplicado = 1
        left join opcs_x_cats opc on opc.id_opcion=p.tipo and opc.id_catalogo=23
        WHERE p.estatus in(1,2,3)
        GROUP BY rpp.id_prestamo, u.nombre,u.apellido_paterno,u.apellido_materno,p.id_prestamo,p.id_usuario,p.monto,p.num_pagos,p.estatus,p.comentario,p.fecha_creacion,p.pago_individual,pendiente,opc.nombre,opc.id_opcion");
        return $query;
    }

    function getPrestamosXporUsuario(){
        $query = $this->db->query("SELECT CONCAT(u.nombre, ' ', u.apellido_paterno, ' ' ,u.apellido_materno) as nombre, p.id_prestamo,p.id_usuario,p.monto,p.num_pagos,p.estatus,p.comentario,p.fecha_creacion,p.pago_individual,pendiente,SUM(pci.abono_neodata) as total_pagado,opc.nombre as tipo,opc.id_opcion, (SELECT TOP 1 rpp2.fecha_creacion FROM relacion_pagos_prestamo rpp2 WHERE rpp2.id_prestamo = rpp.id_prestamo ORDER BY rpp2.id_relacion_pp DESC) AS fecha_creacion_referencia, rpp.id_prestamo as id_prestamo2
        FROM prestamos_aut p 
        INNER JOIN usuarios u ON u.id_usuario = p.id_usuario and u.id_usuario = ".$this->session->userdata('id_usuario')." 
        LEFT JOIN relacion_pagos_prestamo rpp ON rpp.id_prestamo = p.id_prestamo
        LEFT JOIN pago_comision_ind pci ON pci.id_pago_i = rpp.id_pago_i AND pci.estatus in (18,19,20,21,22,23,24,25,26) AND pci.descuento_aplicado = 1
        left join opcs_x_cats opc on opc.id_opcion = p.tipo and opc.id_catalogo = 23
        WHERE p.estatus in(1,2,3,0) 
        GROUP BY rpp.id_prestamo, u.nombre,u.apellido_paterno,u.apellido_materno,p.id_prestamo,p.id_usuario,p.monto,p.num_pagos,p.estatus,p.comentario,p.fecha_creacion,p.pago_individual,pendiente,opc.nombre,opc.id_opcion");
        return $query;
    }

    public function getGeneralDataPrestamo($idPrestamo)
    {
        $query = $this->db->query("SELECT CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u .apellido_materno) AS nombre_completo, 
            pa.monto as monto_prestado, pa.pago_individual, pa.num_pagos, pa.n_p as num_pago_act, SUM(pci.abono_neodata) as total_pagado, 
            (pa.monto - SUM(pci.abono_neodata)) as pendiente
            FROM prestamos_aut pa
            JOIN usuarios u ON u.id_usuario = pa.id_usuario
            JOIN relacion_pagos_prestamo rpp ON rpp.id_prestamo = pa.id_prestamo
            JOIN pago_comision_ind pci ON pci.id_pago_i = rpp.id_pago_i 
            AND pci.estatus IN(18,19,20,21,22,23,24,25,26,28,29) AND pci.descuento_aplicado = 1
            WHERE pa.id_prestamo = $idPrestamo
            GROUP BY u.nombre, u.apellido_paterno, u.apellido_materno, pa.monto, pa.pago_individual, pa.num_pagos, pa.n_p");
        return $query;
    }
    public function getDetailPrestamo($idPrestamo)
    {
        $this->db->query("SET LANGUAGE Español;");
        $query = ("SELECT pci.id_pago_i,hc.comentario, l.nombreLote, CONVERT(NVARCHAR, rpp.fecha_creacion, 6) as fecha_pago, pci.abono_neodata, rpp.np,pcs.nombre as tipo,re.nombreResidencial,
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
                and (hc.comentario like 'DESCUENTO POR%' or hc.comentario like '%, POR MOTIVO DE PRESTAMO' or hc.comentario like '%CONFERENCIA%' or hc.comentario like '%NOMINA%' or hc.comentario like '%PENALIZA%') and hc.estatus=1
                WHERE pa.id_prestamo = $idPrestamo
                ORDER BY np ASC");
        return $query;
    }

    function lista_estatus_descuentos(){
        return $this->db->query(" SELECT * FROM opcs_x_cats where id_catalogo=23 and id_opcion in(18,19,20,21,22,23,24,25,26,29)");
    }

    function getUsuariosRol($rol,$opc = ''){
        if($rol == 38){
          return $this->db->query("SELECT 1988 as id_usuario, 'MKTD Plaza Fernanda (León, San Luis Potosí)' as name_user  union  SELECT 1981 as id_usuario, 'MKTD Plaza Maricela (Querétaro, CDMX, Peninsula)' as name_user");
        }else{
          $complemento = 'and forma_pago != 2';
            if($opc != ''){
              $complemento = '';
            }
          return $this->db->query("SELECT id_usuario,CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) as name_user FROM usuarios WHERE estatus in (0,1,3) $complemento AND id_rol=$rol");
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
        
        if ( $afftectedRows == 0  ) {
            return 0;
        } else {
            return 1;
        }
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
  
      }else if($valor == 2){
          return $this->db->query(" SELECT l.idLote, l.nombreLote, pci.id_pago_i, pci.abono_neodata as comision_total, 0 abono_pagado,pci.pago_neodata 
          FROM comisiones com 
          INNER JOIN lotes l ON l.idLote = com.id_lote
          INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
  
          INNER JOIN pago_comision_ind pci ON pci.id_comision = com.id_comision
          WHERE com.estatus = 1 AND pci.estatus IN (4) AND pci.id_usuario = $user_vobo ORDER BY pci.abono_neodata DESC ");
      }
     
  }

  function getRoles($catalogo,$roles){
    return $this->db->query("SELECT id_opcion, nombre FROM opcs_x_cats WHERE id_catalogo = $catalogo AND id_opcion in ($roles)");
}



public function editarPrestamo($clave, $data){
    try {
        $this->db->where('id_prestamo', $clave);
        if($this->db->update('prestamos_aut', $data))
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
 
function getInformacionData($var,$valor){
    if($valor == 1){
        return $this->db->query(" SELECT l.idLote, l.nombreLote, com.id_comision, pci.abono_neodata as comision_total, 0 abono_pagado 
        FROM comisiones com 
        INNER JOIN lotes l ON l.idLote = com.id_lote
        INNER JOIN pago_comision_ind pci ON pci.id_comision = com.id_comision
        WHERE com.estatus = 1 AND pci.estatus IN (1,14,51,52) AND pci.id_pago_i = $var ");
    }else if($valor ==2){
        return $this->db->query(" SELECT l.idLote, l.nombreLote, com.id_comision, pci.abono_neodata as comision_total, 0 abono_pagado 
        FROM comisiones com 
        INNER JOIN lotes l ON l.idLote = com.id_lote
        INNER JOIN pago_comision_ind pci ON pci.id_comision = com.id_comision
        WHERE com.estatus = 1 AND pci.estatus IN (4) AND pci.id_pago_i = $var ");
    }
   
}

function obtenerID($id){
    return $this->db->query("SELECT id_comision from pago_comision_ind WHERE id_pago_i=$id");
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


    function update_descuento($id_pago_i,$monto, $comentario, $saldo_comisiones, $usuario,$valor,$user,$pagos_aplicados){
        $estatus = 0;
        $uni='DESCUENTO';
        if($valor == 2){
    $estatus =16;
        }else if($valor == 3){
            $estatus =17;
            // -- $respuesta = $this->db->query("UPDATE descuentos_universidad SET estatus = 2 where id_usuario=$user");
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


    function insertar_descuento($usuarioid,$monto,$ide_comision,$comentario,$usuario,$pago_neodata,$valor){

        $estatus = $monto < 1 ? 0 : 1;
        if($valor == 2){
            $estatus = $monto < 1 ? 0 : 4;
        }
        else if($valor == 3){
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
      
      

}