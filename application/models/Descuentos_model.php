
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Descuentos_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    function lista_estatus_descuentos(){
        return $this->db->query(" SELECT * FROM opcs_x_cats WHERE id_catalogo=23 AND id_opcion in(18,19,20,21,22,23,24,25,26,29,30)");
    }


    function getUsuariosRol($rol,$opc = ''){
        if($rol == 38){
            return $this->db->query("SELECT 1988 AS id_usuario, 'MKTD Plaza Fernanda (León, San Luis Potosí)' AS name_user UNION SELECT 1981 AS id_usuario, 'MKTD Plaza Maricela (Querétaro, CDMX, Peninsula)' AS name_user");
        }
        else{
            $complemento = 'AND forma_pago != 2';
            if($opc != ''){
                $complemento = '';
            }
            return $this->db->query("SELECT id_usuario, CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) AS name_user 
            FROM usuarios 
            WHERE estatus IN (0,1,3) $complemento AND id_rol = $rol");
        }
    }
        /**-----------NUEVO PROCESO DE PRESTAMOS AUTOMATICOS---------------------- */
        function getPrestamoxUser($id,$tipo){
            return $this->db->query("SELECT id_usuario FROM prestamos_aut WHERE id_usuario=$id AND estatus=1 AND tipo=$tipo");
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
    


        
    function getLotesOrigen($user,$valor){
        if($user == 1988){//fernanda
            $cadena = " AND cl.id_asesor IN (SELECT id_usuario FROM usuarios WHERE id_rol IN (7,9) AND 
            id_sede like '%1%' OR id_sede like '%5%')";
            $user_vobo = 4394;
        }
        else if($user == 1981){//maricela
            $cadena = " AND cl.id_asesor IN (SELECT id_usuario FROM usuarios WHERE id_rol IN (7,9) AND 
            id_sede like '%2%' OR id_sede like '%3%' OR id_sede like '%4%' OR id_sede like '%6%')";
            $user_vobo = 4394;
        }else{
            $cadena = '';
            $user_vobo = $user;
        }

        if($valor == 1){
            return $this->db->query(" SELECT l.idLote, l.nombreLote, pci.id_pago_i, pci.abono_neodata AS comision_total, 0 abono_pagado,pci.pago_neodata 
            FROM comisiones com 
            INNER JOIN lotes l ON l.idLote = com.id_lote
            INNER JOIN clientes cl ON cl.id_cliente = l.idCliente

            INNER JOIN pago_comision_ind pci ON pci.id_comision = com.id_comision
            WHERE com.estatus IN (1,8) AND pci.estatus IN (1, 41, 42, 51, 52, 61, 62, 12) AND pci.id_usuario = $user_vobo $cadena ORDER BY pci.abono_neodata DESC");
        }else if($valor == 2){
            return $this->db->query(" SELECT l.idLote, l.nombreLote, pci.id_pago_i, pci.abono_neodata AS comision_total, 0 abono_pagado,pci.pago_neodata 
            FROM comisiones com 
            INNER JOIN lotes l ON l.idLote = com.id_lote
            INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
            INNER JOIN pago_comision_ind pci ON pci.id_comision = com.id_comision
            WHERE com.estatus IN (1,8) AND pci.estatus IN (4) AND pci.id_usuario = $user_vobo ORDER BY pci.abono_neodata DESC ");
        }
    }


    function getInformacionData($var,$valor){
        if($valor == 1){
            return $this->db->query("SELECT l.idLote, l.nombreLote, com.id_comision, pci.abono_neodata AS comision_total, 0 abono_pagado 
            FROM comisiones com 
            INNER JOIN lotes l ON l.idLote = com.id_lote
            INNER JOIN pago_comision_ind pci ON pci.id_comision = com.id_comision
            WHERE com.estatus = 1 AND pci.estatus IN (1,14,51,52) AND pci.id_pago_i = $var ");
        }else if($valor ==2){
            return $this->db->query("SELECT l.idLote, l.nombreLote, com.id_comision, pci.abono_neodata AS comision_total, 0 abono_pagado 
            FROM comisiones com 
            INNER JOIN lotes l ON l.idLote = com.id_lote
            INNER JOIN pago_comision_ind pci ON pci.id_comision = com.id_comision
            WHERE com.estatus = 1 AND pci.estatus IN (4) AND pci.id_pago_i = $var ");
        }
    }

    function obtenerID($id){
        return $this->db->query("SELECT id_comision FROM pago_comision_ind WHERE id_pago_i=$id");
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


    function update_descuento($id_pago_i,$monto, $comentario, $saldo_comisiones, $usuario,$valor,$user){
        $estatus = 0;
        $uni='DESCUENTO';
        if($valor == 2){
            $estatus =16;
        }else if($valor == 3){
            $estatus =17;
            $respuesta = $this->db->query("UPDATE descuentos_universidad SET saldo_comisiones=".$saldo_comisiones.", estatus = 2, primer_descuento = (CASE WHEN primer_descuento IS NULL THEN GETDATE() ELSE primer_descuento END) WHERE id_usuario = ".$user." AND estatus IN (1, 0)");
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


}