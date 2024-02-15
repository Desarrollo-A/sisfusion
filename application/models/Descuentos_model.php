
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Descuentos_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    function lista_estatus_descuentos(){
        return $this->db->query(" SELECT * FROM opcs_x_cats WHERE id_catalogo=23 AND id_opcion NOT IN (0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,27,28,41,42,51,52,88)");
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
        $user = $this->session->userdata('id_usuario');
        $respuesta = $this->db->query("INSERT INTO pago_comision_ind(id_comision, id_usuario, abono_neodata, fecha_abono, fecha_pago_intmex, pago_neodata, estatus, modificado_por, comentario, descuento_aplicado,abono_final,aply_pago_intmex) VALUES ($ide_comision, $usuarioid, $monto, GETDATE(), GETDATE(), $pago_neodata, $estatus, $usuario, 'DESCUENTO ', 1 ,null, null)");
        $insert_id = $this->db->insert_id();

        $respuesta = $this->db->query("INSERT INTO prestamos_aut (id_usuario, monto, num_pagos, pago_individual, comentario, estatus, pendiente, creado_por, fecha_creacion, modificado_por, fecha_modificacion, n_p, tipo, id_cliente) VALUES ($usuarioid, $monto, 1, $monto, 'DESCUENTO REVISIÓN2', 2, 0, $user, GETDATE(), $user, GETDATE(), 1,  $estatus, 0)");
        $insert_id_4 = $this->db->insert_id(); //REPLICAR EN AMBOS TIPOS DE DESCUENTO

        $respuesta = $this->db->query("INSERT INTO relacion_pagos_prestamo (id_prestamo, id_pago_i, estatus, creado_por, fecha_creacion, modificado_por, fecha_modificacion, np) VALUES($insert_id_4, $insert_id, 1, $user, GETDATE(), $user, GETDATE(), 1)"); //REPLICAR EN AMBOS TIPOS DE DESCUENTO

        $respuesta = $this->db->query("INSERT INTO historial_comisiones VALUES ($insert_id, $usuario, GETDATE(), 1, 'DESCUENTO: ".$comentario."')");
    
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

        $comentarios = 'DESCUENTO EN REVISIÓN '+$comentario;

        $user = $this->session->userdata('id_usuario');

        $respuesta = $this->db->query("INSERT INTO pago_comision_ind(id_comision, id_usuario, abono_neodata, fecha_abono, fecha_pago_intmex, pago_neodata, estatus, modificado_por, comentario, descuento_aplicado,abono_final,aply_pago_intmex) VALUES ($ide_comision, $usuarioid, $monto, GETDATE(), GETDATE(), $pago_neodata, $estatus, $usuario, 'DESCUENTO NUEVO PAGO', 0 ,null, null)");
        $insert_id = $this->db->insert_id();


        $respuesta = $this->db->query("INSERT INTO prestamos_aut (id_usuario, monto, num_pagos, pago_individual, comentario, estatus, pendiente, creado_por, fecha_creacion, modificado_por, fecha_modificacion, n_p, tipo, id_cliente) VALUES ($usuarioid, $monto, 1, $monto,  $comentarios, 1, 0, $usuario, GETDATE(), $usuario, GETDATE(), 1,  $estatus, 0)");
        $insert_id_4 = $this->db->insert_id(); //REPLICAR EN AMBOS TIPOS DE DESCUENTO


        $respuesta = $this->db->query("INSERT INTO relacion_pagos_prestamo (id_prestamo, id_pago_i, estatus, creado_por, fecha_creacion, modificado_por, fecha_modificacion, np) VALUES($insert_id_4, $insert_id, 1, $usuario, GETDATE(), $user, GETDATE(), 1)"); //REPLICAR EN AMBOS TIPOS DE DESCUENTO


        $respuesta = $this->db->query("INSERT INTO historial_comisiones VALUES ($insert_id, $usuario, GETDATE(), 1, 'NUEVO PAGO, DISPONIBLE PARA COBRO')");

        if (! $respuesta ) {
            return 0;
        } else {
            return 1;
        }
    }
    public function getGeneralDataPrestamo($idPrestamo)
    {
        $result = $this->db->query("SELECT CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u .apellido_materno) AS nombre_completo, 
            pa.monto AS monto_prestado, pa.pago_individual, pa.num_pagos, pa.n_p AS num_pago_act, SUM(pci.abono_neodata) AS total_pagado, 
            (pa.monto - SUM(pci.abono_neodata)) AS pendiente
            FROM prestamos_aut pa
            JOIN usuarios u ON u.id_usuario = pa.id_usuario
            JOIN relacion_pagos_prestamo rpp ON rpp.id_prestamo = pa.id_prestamo
            JOIN pago_comision_ind pci ON pci.id_pago_i = rpp.id_pago_i AND pci.descuento_aplicado = 1
            WHERE pa.id_prestamo = $idPrestamo
            GROUP BY u.nombre, u.apellido_paterno, u.apellido_materno, pa.monto, pa.pago_individual, pa.num_pagos, pa.n_p");
        return $result->row();
    }

    public function getDetailPrestamo($idPrestamo)
    {
        $this->db->query("SET LANGUAGE Español;");
        $result = $this->db->query("SELECT pci.id_pago_i, hl.comentario , l.nombreLote, CONVERT(NVARCHAR, rpp.fecha_creacion, 6) AS fecha_pago, pci.abono_neodata, rpp.np,pcs.nombre AS tipo,re.nombreResidencial,
        CASE WHEN pa.estatus=1 THEN 'Activo' WHEN pa.estatus=2 THEN 'Liquidado' WHEN pa.estatus=3 THEN 'Liquidado' END AS estatus,sed.nombre AS sede
        FROM prestamos_aut pa
        INNER JOIN usuarios u ON u.id_usuario = pa.id_usuario
        INNER JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 2 WHEN 4 THEN 5 WHEN 5 THEN 3 WHEN 607 THEN 1 WHEN 7092 THEN 4 WHEN 9629 THEN 2 ELSE u.id_sede END) AND sed.estatus = 1
        INNER JOIN opcs_x_cats pcs ON pcs.id_opcion=pa.tipo AND pcs.id_catalogo=23
        INNER JOIN relacion_pagos_prestamo rpp ON rpp.id_prestamo = pa.id_prestamo
        INNER JOIN pago_comision_ind pci ON pci.id_pago_i = rpp.id_pago_i AND pci.descuento_aplicado = 1
        INNER JOIN comisiones c ON c.id_comision = pci.id_comision
        INNER JOIN lotes l ON l.idLote = c.id_lote
        INNER JOIN condominios con ON con.idCondominio=l.idCondominio
        INNER JOIN residenciales re ON re.idResidencial=con.idResidencial
        INNER JOIN historial_comisiones hl ON hl.id_pago_i = rpp.id_pago_i AND hl.estatus = 1 
        AND hl.fecha_movimiento = (SELECT max(t2.fecha_movimiento) FROM historial_comisiones t2 Where t2.id_pago_i = hl.id_pago_i)
        WHERE pa.id_prestamo = $idPrestamo
        ORDER BY np ASC");
        return $result->result_array();
    }

    function getHistorialPrestamo(){ 
        return $this->db->query("SELECT CONCAT(u.nombre, ' ', u.apellido_paterno, ' ' ,u.apellido_materno) AS nombre, p.id_prestamo,p.id_usuario, p.monto,p.num_pagos,p.estatus,p.comentario,p.fecha_creacion,p.pago_individual,pendiente,SUM(pci.abono_neodata) AS total_pagado, opc.nombre AS tipo,opc.id_opcion, (SELECT TOP 1 rpp2.fecha_creacion FROM relacion_pagos_prestamo rpp2 WHERE rpp2.id_prestamo = rpp.id_prestamo ORDER BY rpp2.id_relacion_pp DESC) AS fecha_creacion_referencia, rpp.id_prestamo AS id_prestamo2
        FROM prestamos_aut p 
        INNER JOIN usuarios u ON u.id_usuario = p.id_usuario 
        LEFT JOIN relacion_pagos_prestamo rpp ON rpp.id_prestamo = p.id_prestamo
        LEFT JOIN pago_comision_ind pci ON pci.id_pago_i = rpp.id_pago_i AND pci.descuento_aplicado = 1
        LEFT JOIN opcs_x_cats opc ON opc.id_opcion = p.tipo AND opc.id_catalogo = 23
        WHERE p.estatus in(0,2,3)
        GROUP BY rpp.id_prestamo, u.nombre,u.apellido_paterno,u.apellido_materno,p.id_prestamo,p.id_usuario,p.monto,p.num_pagos,p.estatus,p.comentario,p.fecha_creacion,p.pago_individual,pendiente,opc.nombre,opc.id_opcion");
    }

    function getPrestamos(){ 
        return $this->db->query("SELECT 
        CONCAT(u.nombre, ' ', u.apellido_paterno, ' ' ,u.apellido_materno) AS nombre, 
        p.id_prestamo,p.id_usuario, p.monto,p.num_pagos,p.estatus,p.comentario,
        p.fecha_creacion,p.pago_individual,pendiente,
        SUM(pci.abono_neodata) AS total_pagado, opc.nombre AS tipo,
        opc.id_opcion, mrp.evidencia as relacion_evidencia,
        p.evidenciaDocs as evidencia ,
        (SELECT TOP 1 rpp2.fecha_creacion 
        FROM relacion_pagos_prestamo rpp2 
        WHERE rpp2.id_prestamo = rpp.id_prestamo 
        ORDER BY rpp2.id_relacion_pp DESC) AS fecha_creacion_referencia, 
        rpp.id_prestamo AS id_prestamo2,
        opcol.color AS colorP, opcol.nombre AS estatusPrestamo
        FROM prestamos_aut p 
        INNER JOIN usuarios u ON u.id_usuario = p.id_usuario 
        LEFT JOIN relacion_pagos_prestamo rpp ON rpp.id_prestamo = p.id_prestamo
        LEFT JOIN pago_comision_ind pci ON pci.id_pago_i = rpp.id_pago_i AND pci.descuento_aplicado = 1
        LEFT JOIN opcs_x_cats opc ON opc.id_opcion = p.tipo AND opc.id_catalogo = 23
        LEFT JOIN opcs_x_cats opcol ON opcol.id_opcion = p.estatus AND opcol.id_catalogo = 118
        LEFT JOIN motivosRelacionPrestamos mrp ON mrp.id_opcion =  opc.id_opcion 
        GROUP BY rpp.id_prestamo, 
        mrp.evidencia,
        u.nombre,u.apellido_paterno,
        u.apellido_materno,p.id_prestamo,p.id_usuario,p.monto,
        p.num_pagos,p.estatus,p.comentario,p.fecha_creacion,p.pago_individual,
        pendiente,opc.nombre,opc.id_opcion,p.evidenciaDocs,opcol.color,opcol.nombre
        ORDER BY p.id_prestamo DESC");
    }
    public function updatePrestamosEdit($clave, $data){
        try {
            $this->db->WHERE('id_prestamo', $clave);
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

        public function BorrarPrestamo($id_prestamo){
            $respuesta = $this->db->query("UPDATE prestamos_aut SET estatus=0,modificado_por=".$this->session->userdata('id_usuario')." WHERE id_prestamo=$id_prestamo ");
            $respuesta = $this->db->query("INSERT INTO historial_log VALUES($id_prestamo,".$this->session->userdata('id_usuario').",GETDATE(),1,'SE CANCELÓ EL PRÉSTAMO','prestamos_aut',NULL,NULL,NULL,NULL)");
    
            if (! $respuesta ) {
                return 0;
            } else {
                return 1;
            }
        }       
        public function traerElUltimo(){
            $cmd = "SELECT TOP 1 id_opcion FROM opcs_x_cats 
                    WHERE id_catalogo = 23 ORDER BY id_opcion DESC ";
            $resultado = $this->db->query($cmd);  
            return $resultado->row();
        }

        public function  insertarMotivo($insert){
            try {
            $resultado = $this->db->insert( "opcs_x_cats",$insert);
            
            return $resultado;
            }
            catch(Exception $e) {
                return $e->getMessage();
            }    
        }
        public function  insertarMotivoRelacion($insert){
            $respuesta = $this->db->insert('motivosRelacionPrestamos ',$insert);
            return  $this->db->insert_id();
        }

        
        public function getRelacionPrestamos($id_opcion){
            $cmd = "SELECT evidencia  
            FROM motivosRelacionPrestamos 
            WHERE id_opcion = $id_opcion ";
            
            $resultado = $this->db->query($cmd);  

            return $resultado->row();
        }

        function getDescuentos(){
            return $this->db->query("SELECT pci.id_pago_i, CONCAT(us.nombre,' ',us.apellido_paterno,' ',us.apellido_materno) AS usuario,
            pci.abono_neodata AS monto, lo.nombreLote, pci.estatus, 
            CONCAT(us2.nombre,' ',us2.apellido_paterno,' ',us2.apellido_materno) AS modificado_por, 
            (CASE WHEN hc.comentario IS NULL THEN 'Sin comentario' ELSE hc.comentario END) as motivo,
            CONVERT(VARCHAR,pci.fecha_abono,20) AS fecha_abono
            FROM pago_comision_ind pci
            INNER JOIN usuarios us ON us.id_usuario = pci.id_usuario
            INNER JOIN comisiones co ON co.id_comision = pci.id_comision
            INNER JOIN lotes lo ON lo.idLote = co.id_lote
            LEFT JOIN historial_comisiones hc ON hc.id_pago_i = pci.id_pago_i AND hc.comentario like 'MOTIVO DESCUENTO%'
            INNER JOIN usuarios us2 ON us2.id_usuario = pci.modificado_por
            WHERE (pci.estatus = 0 ) AND pci.descuento_aplicado = 1");
        }
        public function toparPrestamo($id_prestamo,$total_pagado,$usuario){
            $respuesta = $this->db->query("UPDATE prestamos_aut SET estatus=4,pendiente=0,monto=$total_pagado,modificado_por=$usuario WHERE id_prestamo=$id_prestamo");
            if(!$respuesta) {
                $respuesta =  array(
                    "response_code" => 500, 
                    "response_type" => 'error',
                    "message" => "Ocurrio un error");
            } else {
                $respuesta =  array(
                    "response_code" => 200, 
                    "response_type" => 'success',
                    "message" => "Préstamo topado correctamente.");
                }
                return $respuesta;

            }

        
    
}