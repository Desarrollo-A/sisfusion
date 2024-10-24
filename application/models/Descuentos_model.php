
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Descuentos_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    function lista_estatus_descuentos(){
        return $this->db->query(" SELECT * FROM opcs_x_cats WHERE id_catalogo=23 AND id_opcion NOT IN (0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,27,28,41,42,51,52,88) and estatus = 1");
    }
    function lista_estatus_descuentosEspecificos(){
        return $this->db->query("SELECT * FROM opcs_x_cats oxc
        INNER JOIN motivosRelacionPrestamos mrp on  oxc.id_opcion = mrp.id_opcion AND mrp.evidencia = 'true'
        WHERE oxc.id_catalogo=23 
        AND oxc.id_opcion NOT IN (0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,27,28,41,42,51,52,88) 
        AND oxc.estatus = 1");
    }

    function lista_descuentosEspecificos(){ /*  ffffff*/
        return $this->db->query("SELECT * FROM opcs_x_cats oxc
        INNER JOIN motivosRelacionPrestamos mrp on  oxc.id_opcion = mrp.id_opcion
        WHERE oxc.id_catalogo=23 
        AND oxc.id_opcion NOT IN (0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,27,28,41,42,51,52,88) 
        AND oxc.estatus = 1");
    }

    function busqueda_true($id_opcion){

        return $this->db->query("SELECT evidencia FROM motivosRelacionPrestamos WHERE id_opcion = $id_opcion")->row()->evidencia;
 
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
                return FALSE;
            } else {
                return TRUE;
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
            $cmdPagos="SELECT l.idLote, l.nombreLote, pci.id_pago_i, pci.abono_neodata as comision_total, 0 abono_pagado,pci.pago_neodata 
            FROM comisiones com 
            INNER JOIN lotes l ON l.idLote = com.id_lote
            INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
            INNER JOIN pago_comision_ind pci ON pci.id_comision = com.id_comision
            WHERE com.estatus IN (1, 8) AND pci.estatus IN (1, 41, 42, 51, 52, 61, 62, 12) AND pci.id_usuario = $user_vobo $cadena ORDER BY pci.abono_neodata DESC";
            $arrayDeDatos['PAGOS'] =  $this->db->query($cmdPagos)->result_array();

            $cmdPrestamos="SELECT pres.id_prestamo,pres.id_usuario, pres.tipo,pres.estatus,
            oxc.id_opcion, oxc.nombre
            FROM prestamos_aut pres
            INNER JOIN opcs_x_cats  oxc ON oxc.id_catalogo = 23 and oxc.id_opcion = pres.tipo  
            where pres.id_usuario = $user_vobo and pres.estatus = 1 "; 
            $arrayDeDatos['PRESTAMOS'] =  $this->db->query($cmdPrestamos)->result_array();

            return $arrayDeDatos;
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


    function update_descuento($id_pago_i,$monto, $comentario, $saldo_comisiones, $usuario,$valor,$user,$pagos_aplicados,$motivo,$prestamo,$tipo_descuento,$archivo,$descuento,$bandera){
       
        
        if($motivo==2 && $bandera == 0){
            
                    
            $nombre= $this->db->query("SELECT nombre FROM opcs_x_cats where id_catalogo = 23 and id_opcion= $tipo_descuento")->row()->nombre;
            if($archivo != NULL)
            {
                $insert_prestamo =$this->db->query("INSERT INTO prestamos_aut VALUES ($usuario, $descuento, 1, $descuento, '$nombre', 25, 0, $user, GETDATE(), $user, GETDATE(), 1, $tipo_descuento, NULL, '$archivo')");
                
            }else{
                $insert_prestamo =$this->db->query("INSERT INTO prestamos_aut VALUES ($usuario, $descuento, 1, $descuento, '$nombre', 25, 0, $user, GETDATE(), $user, GETDATE(), 1, $tipo_descuento, NULL, NULL)");
            }
            $insert_id_prestamo = $this->db->insert_id();
        }

        if($motivo==2 && $bandera == -1){
            
                    
            $nombre= $this->db->query("SELECT nombre FROM opcs_x_cats where id_catalogo = 23 and id_opcion= $tipo_descuento")->row()->nombre;
            if($archivo != NULL)
            {
                $insert_prestamo =$this->db->query("INSERT INTO prestamos_aut VALUES ($usuario, $monto, 1, $monto, '$nombre', 25, 0, $user, GETDATE(), $user, GETDATE(), 1, $tipo_descuento, NULL, '$archivo')");
                
            }else{
                $insert_prestamo =$this->db->query("INSERT INTO prestamos_aut VALUES ($usuario, $monto, 1, $monto, '$nombre', 25, 0, $user, GETDATE(), $user, GETDATE(), 1, $tipo_descuento, NULL, NULL)");
            }
            $insert_id_prestamo = $this->db->insert_id();

        }
       
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
            
            if($estatus == 0){
                $respuesta = $this->db->query("UPDATE pago_comision_ind SET estatus = $estatus, descuento_aplicado=1, modificado_por='$usuario', fecha_pago_intmex = GETDATE(), fecha_abono = GETDATE(), comentario='$uni' WHERE id_pago_i=$id_pago_i");
                if($motivo==1){
                    $tipo =$this->db->query("SELECT tipo FROM prestamos_aut WHERE id_prestamo = $prestamo")->row()->tipo;
                    $respuesta1 = $this->db->query("INSERT INTO relacion_motivo_pago VALUES ($id_pago_i, $prestamo, $tipo, $estatus)");                    
                }else{

                    // $nombre= $this->db->query("SELECT nombre FROM opcs_x_cats where id_catalogo = 23 and id_opcion= $tipo_descuento")->row()->nombre;
                    // if($archivo != NULL)
                    // {
                    //     $insert_prestamo =$this->db->query("INSERT INTO prestamos_aut VALUES ($usuario, $monto, 1, $monto, '$nombre', 5, 0, $user, GETDATE(), $user, GETDATE(), 1, $tipo_descuento, NULL, '$archivo')");
                        
                    // }else{
                    //     $insert_prestamo =$this->db->query("INSERT INTO prestamos_aut VALUES ($usuario, $monto, 1, $monto, '$nombre', 5, 0, $user, GETDATE(), $user, GETDATE(), 1, $tipo_descuento, NULL, NULL)");
                    // }
                  
                    // $insert_id_prestamo = $this->db->insert_id();
                    // $respuesta = $this->db->query("INSERT INTO relacion_motivo_pago VALUES ($id_pago_i, $insert_id_prestamo, $tipo_descuento, $estatus)");

                        $prestamo_id = $this->db->query("SELECT id_prestamo FROM prestamos_aut WHERE estatus = 25")->row()->id_prestamo;
                      
                        $respuesta3 = $this->db->query("INSERT INTO relacion_motivo_pago VALUES ($id_pago_i, $prestamo_id, $tipo_descuento, $estatus)");
                        
                

                }
            }
        } else {
            
             $respuesta = $this->db->query("UPDATE pago_comision_ind SET estatus = $estatus, descuento_aplicado=1, modificado_por='$usuario', fecha_pago_intmex = GETDATE(), fecha_abono = GETDATE(), abono_neodata = $monto, comentario='$uni' WHERE id_pago_i=$id_pago_i");
             if($estatus == 0){
                if($motivo==1){
                    $tipo =$this->db->query("SELECT tipo FROM prestamos_aut WHERE id_prestamo = $prestamo")->row()->tipo;
                    $respuesta = $this->db->query("INSERT INTO relacion_motivo_pago VALUES ($id_pago_i, $prestamo, $tipo, $estatus)");                    
                }else{

                    // $respuesta = $this->db->query("INSERT INTO relacion_motivo_pago VALUES ($id_pago_i, $insert_id_prestamo, $tipo_descuento, $estatus)");
                    $prestamo_id = $this->db->query("SELECT id_prestamo FROM prestamos_aut WHERE estatus = 25")->row()->id_prestamo;
                   
                        $respuesta2 = $this->db->query("INSERT INTO relacion_motivo_pago VALUES ($id_pago_i, $prestamo_id, $tipo_descuento, $estatus)");

                    
                }
            }
        }
     
        $respuesta = $this->db->query("INSERT INTO historial_comisiones VALUES ($id_pago_i, $usuario, GETDATE(), 1, 'MOTIVO DESCUENTO: ".$comentario."')");

        if (! $respuesta ) {
            return 0;
            } else {
            return 1;
            }
    }

    Public function update_estatus_prestamo(){
     $cambio_estatus = $this->db->query("UPDATE prestamos_aut SET estatus = 5 WHERE estatus =25");
     if (! $cambio_estatus ) {
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

    function getPrestamos($beginDate,$endDate){
        $queryFecha = $beginDate != '0' ? "WHERE p.fecha_creacion BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59'": ""; 
        return $this->db->query("SELECT 
        CONCAT(u.nombre, ' ', u.apellido_paterno, ' ' ,u.apellido_materno) AS nombre, 
        p.id_prestamo,p.id_usuario, p.monto,p.num_pagos,p.estatus,p.comentario,
        p.fecha_creacion,p.pago_individual,pendiente,
        SUM(pci.abono_neodata) AS total_pagado, opc.nombre AS tipo,
        opc.id_opcion, mrp.evidencia as relacion_evidencia,
        p.evidenciaDocs as evidencia ,mrp.estatus AS mrpEstatus,
        (SELECT TOP 1 rpp2.fecha_creacion 
        FROM relacion_pagos_prestamo rpp2 
        WHERE rpp2.id_prestamo = rpp.id_prestamo 
        ORDER BY rpp2.id_relacion_pp DESC) AS fecha_creacion_referencia, 
        rpp.id_prestamo AS id_prestamo2,
        opcol.color AS colorP, opcol.nombre AS estatusPrestamo
        FROM prestamos_aut p 
        INNER JOIN usuarios u ON u.id_usuario = p.id_usuario AND u.estatus IN(1,3,0)
        LEFT JOIN relacion_pagos_prestamo rpp ON rpp.id_prestamo = p.id_prestamo
        LEFT JOIN pago_comision_ind pci ON pci.id_pago_i = rpp.id_pago_i AND pci.descuento_aplicado = 1
        LEFT JOIN opcs_x_cats opc ON opc.id_opcion = p.tipo AND opc.id_catalogo = 23
        LEFT JOIN opcs_x_cats opcol ON opcol.id_opcion = p.estatus AND opcol.id_catalogo = 118
        LEFT JOIN motivosRelacionPrestamos mrp ON mrp.id_opcion =  opc.id_opcion  AND mrp.estatus = 1
        $queryFecha
        GROUP BY rpp.id_prestamo, 
        mrp.evidencia,mrp.estatus ,
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
            $respuesta = $this->db->query("UPDATE prestamos_aut SET estatus=5,modificado_por=".$this->session->userdata('id_usuario')." WHERE id_prestamo=$id_prestamo ");
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

        function motivosOpc(){
            $crm = "SELECT 
            oxc0.id_opcion, oxc0.id_catalogo, mrp.id_motivo,
            oxc0.nombre, oxc0.estatus, oxc0.color,
            mrp.evidencia, mrp.descripcion,mrp.estatus,
            (CASE 
            WHEN mrp.evidencia != ('') THEN 'UPLOADS/EvidenciaGenericas'  
            ELSE 'NA'  
            END) as ruta,
            mrp.modificado_por
            FROM opcs_x_cats oxc0  
            LEFT JOIN motivosRelacionPrestamos mrp ON mrp.id_opcion = oxc0.id_opcion 
            WHERE id_catalogo=23 
            AND mrp.evidencia != 'true'
            AND mrp.id_opcion NOT IN (0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,27,28,41,42,51,52,88)
            AND oxc0.estatus = 1
            AND mrp.estatus = 1
            ";

            return $this->db->query($crm)->result_array();
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



        public function updateMotivo($clave, $data){
            try {
                $this->db->WHERE('id_opcion', $clave);
                if($this->db->update('motivosRelacionPrestamos', $data))
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
    
        public function validar($id_opcion){
            $cmd = "SELECT * FROM prestamos_aut pa
			LEFT JOIN  opcs_x_cats opc ON opc.id_opcion = pa.tipo AND id_catalogo = 23
			LEFT JOIN motivosRelacionPrestamos  mrp ON opc.id_opcion = mrp.id_opcion
			WHERE pa.estatus = 1 AND opc.id_opcion  =  $id_opcion";

            $respuesta = $this->db->query($cmd)->num_rows();
            
            if (!$respuesta > 0) {
                return TRUE;
            }else{
                return FALSE;
            }
        }
                
        public function dadoDeBajaMotivo($id_opcion , $catalgo , $data){
            try {
                $this->db->WHERE('id_opcion', $id_opcion);
                $this->db->where('id_catalogo', $catalgo);
                if($this->db->update('opcs_x_cats', $data))
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

            function historial_evidencia_general($id_opcion){
                $crm = "SELECT * FROM 
                    motivosRelacionPrestamos WHERE id_opcion = $id_opcion
                ";
    
                return $this->db->query($crm)->result_array();
            }


            function UpdateDescuento($id_bono){

                $motivo_descuento= $this->db->query("SELECT pres.tipo , rmp.id_prestamo, pres.n_p, rmp.motivo_prestamo, pres.id_usuario
                FROM 
                relacion_motivo_pago rmp INNER JOIN prestamos_aut pres ON pres.id_prestamo = rmp.id_prestamo
                WHERE rmp.id_pago_i = $id_bono");

                $motivo_prestamo = $motivo_descuento->row()->motivo_prestamo;
                $id_prestamo = $motivo_descuento->row()->id_prestamo;
                $np= $motivo_descuento->row()->n_p;
                $id_usuario= $motivo_descuento->row()->id_usuario;

               
                $respuesta = $this->db->query("UPDATE pago_comision_ind SET estatus = $motivo_prestamo, modificado_por='".$this->session->userdata('id_usuario')."' WHERE estatus = 0 AND descuento_aplicado = 1 AND id_pago_i = $id_bono");

                $respuesta2 = $this->db->query("INSERT INTO relacion_pagos_prestamo VALUES ($id_prestamo,$id_bono,1,1,GETDATE(),1,GETDATE(),$np)");
                $respuesta3 = $this->db->query("INSERT INTO historial_comisiones VALUES ($id_bono, $id_usuario, GETDATE(), 1, 'POR MOTIVO DE PRESTAMO')");

                if (! $respuesta ) {
                return 0;
                } else {
                return 1;
                }
            }

            public function  insertAdelanto($insert){
                $respuesta = $this->db->insert('anticipo',$insert);
                return  $this->db->insert_id();
            }
            
            public function  insertAdelantoGenerico($insert,$tabla){
                $respuesta = $this->db->insert($tabla,$insert);
                if($respuesta)
                {
                    return TRUE;
                }else{
                    return FALSE;
                }    
            }
            public function update_generico_aticipo($clave,$llave,$tabla,$data){
                try {
                    $this->db->WHERE($llave, $clave);
                    if($this->db->update($tabla, $data))
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

            public function  historial_anticipo_avance($insert){
                $cmd = "SELECT * FROM opcs_x_cats  WHERE id_catalogo = 128 AND estatus = 1";
                $query = $this->db->query($cmd );
                return  $query->result_array();
            }
            public function  todos_los_pasos(){
                
                $usuario =  $this->session->userdata('id_usuario');
                $cmd = "SELECT * FROM opcs_x_cats  WHERE id_catalogo = 128 AND estatus = 1";
                $query = $this->db->query($cmd );   
                $datos["TODOS"] = $query->result_array();
                $cmd2 = "SELECT opcx.id_opcion , ha.id_usuario,ha.id_anticipo,opcx.nombre,opcx.estatus  ,opcx.id_catalogo,
                ha.comentario as comentario_ha
                FROM  opcs_x_cats opcx 
                INNER  JOIN historial_anticipo ha ON ha.proceso = opcx.id_opcion  and opcx.id_catalogo = 128
                where ha.id_usuario = $usuario";
                $datos["USUARIO"]  = $this->db->query($cmd2  )->result_array();   
                
                $CMD_anticipos="SELECT ant.id_anticipo,ant.id_usuario,ant.monto ,us.forma_pago,
                ant.comentario,ant.estatus,ant.proceso,ant.impuesto,ant.fecha_registro,

                pra.mensualidades,pra.monto_parcialidad,pra.id_parcialidad,

                ant.prioridad,ant.evidencia, CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) AS nombre_usuario
                FROM anticipo ant
                INNER JOIN usuarios us  ON us.id_usuario = ant.id_usuario
                LEFT JOIN parcialidad_relacion_anticipo pra ON pra.id_anticipo = ant.id_anticipo

                WHERE ant.id_usuario = $usuario";
                $datos["ANTICIPOS"] = $this->db->query($CMD_anticipos)->result_array();   

                
                return  $datos;


            }


            public function solicitudes_por_aticipo ($bandera = ''){


                $idUsu = intval($this->session->userdata('id_usuario')); 
                $rol   = intval($this->session->userdata('id_rol')); 
                if($rol == 4 and $rol == 5 ){
                    $idUsu = intval($this->session->userdata('id_lider'));
                }
                
                
                $cmd = "DECLARE @user INT 
                SELECT @user = $idUsu 
                SELECT u.id_usuario, u.id_rol,
                FORMAT(ant.monto, 'C', 'es-MX') AS monto_formateado,  u.forma_pago  as formaNomal ,
                UPPER(opcs_x_cats.nombre) AS puesto, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno)
                AS nombre, CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) AS jefe_directo, u.telefono,
                UPPER(u.correo) AS correo, u.estatus, ant.proceso as id_proceso,
                CASE WHEN ant.prioridad  = 0 THEN 'Normal' ELSE 'URGENTE' END as prioridad_nombre ,
                ant.id_anticipo,ant.id_usuario, ant.monto,ant.comentario,
                pra.mensualidades,pra.monto_parcialidad,pra.id_parcialidad,
                ant.estatus, ant.proceso, ant.prioridad,oxc.nombre AS puesto,oxc1.nombre as proceso,
                u.id_lider, 0 nuevo, u.fecha_creacion, UPPER(s.nombre) AS sede 
                FROM usuarios u
                INNER JOIN anticipo ant ON u.id_usuario =ant.id_usuario 
                INNER JOIN opcs_x_cats ON u.id_rol = opcs_x_cats.id_opcion and id_catalogo = 1
                INNER JOIN sedes s ON CAST(s.id_sede AS VARCHAR(45)) = CAST(u.id_sede AS VARCHAR(45))
                INNER JOIN usuarios us ON us.id_usuario= u.id_lider
                INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = u.id_rol AND oxc.id_catalogo = 1
                INNER JOIN opcs_x_cats oxc1 ON oxc1.id_opcion = ant.proceso and oxc1.id_catalogo = 128
                LEFT JOIN parcialidad_relacion_anticipo pra ON pra.id_anticipo = ant.id_anticipo
                where u.id_rol in(1,2,3,7,9) 
                AND ant.proceso in (1,2,3,4)
                AND (u.id_lider = @user  
                OR u.id_lider in (select u2.id_usuario from usuarios u2 where id_lider = @user )
                OR (u.id_lider in (select u2.id_usuario from usuarios u2 where id_lider in (select u2.id_usuario from usuarios u2 where id_lider = @user ))) and u.id_rol = 7 )
				OR (u.id_lider in (select u2.id_usuario from usuarios u2 where id_lider in (@user )) and u.id_rol = 9 )
                ORDER BY u.id_rol"; 
                $query = $this->db->query($cmd );   
                return $query->result_array();
                
            }
            public function solicitudes_generales_reporte(){

                $usuario =  $this->session->userdata('id_usuario');
                
                $cmd = "SELECT u.id_usuario, u.id_rol,forma.nombre as nombre_forma_pago, u.forma_pago ,
				UPPER(opcs_x_cats.nombre) AS puesto, ha.fecha_movimiento,
				CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno)
                AS nombre,  FORMAT(ant.monto, 'C', 'es-MX') AS monto_formateado,
				CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) AS jefe_directo, u.telefono,
                UPPER(u.correo) AS correo, u.estatus, ant.proceso as id_proceso,
                CASE WHEN ant.prioridad  = 0 THEN 'Normal' ELSE 'URGENTE' END as prioridad_nombre ,
                ant.id_anticipo,ant.id_usuario, ant.monto,ant.comentario,
                ant.estatus, ant.proceso, ant.prioridad,oxc.nombre AS puesto,oxc1.nombre as proceso,
                u.id_lider, 0 nuevo, u.fecha_creacion, UPPER(s.nombre) AS sede 
                FROM usuarios u
                INNER JOIN anticipo ant ON u.id_usuario =ant.id_usuario 
                INNER JOIN opcs_x_cats ON u.id_rol = opcs_x_cats.id_opcion and id_catalogo = 1
                INNER JOIN sedes s ON CAST(s.id_sede AS VARCHAR(45)) = CAST(u.id_sede AS VARCHAR(45))
                INNER JOIN usuarios us ON us.id_usuario= u.id_lider
                INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = us.id_rol AND oxc.id_catalogo = 1
                INNER JOIN opcs_x_cats oxc1 ON oxc1.id_opcion = ant.proceso and oxc1.id_catalogo = 128
				INNER JOIN opcs_x_cats forma ON forma.id_catalogo  = 16 and forma.id_opcion = u.forma_pago 
                LEFT  JOIN historial_anticipo ha ON ha.id_anticipo = ant.id_anticipo and ha.proceso = 3 
				where u.id_rol in(1,2,3,7,9) 
				order by ha.fecha_movimiento
                ";

                $query = $this->db->query($cmd);
                return $query->result_array();
            }           

            public function solicitudes_generales_dc(){

                $usuario =  $this->session->userdata('id_usuario');
                
                $cmd = "SELECT u.id_usuario, u.id_rol, 
				UPPER(opcs_x_cats.nombre) AS puesto, us.forma_pago,
				CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno)
                AS nombre,  FORMAT(ant.monto, 'C', 'es-MX') AS monto_formateado,
				CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) AS jefe_directo, u.telefono,
                UPPER(u.correo) AS correo, u.estatus, ant.proceso as id_proceso,
                CASE WHEN ant.prioridad  = 0 THEN 'Normal' ELSE 'URGENTE' END as prioridad_nombre ,
                ant.id_anticipo,ant.id_usuario, ant.monto,ant.comentario,
                pra.mensualidades,pra.monto_parcialidad,pra.id_parcialidad,
                ant.estatus, ant.proceso, ant.prioridad,oxc.nombre AS puesto,oxc1.nombre as proceso,
                u.id_lider, 0 nuevo, u.fecha_creacion, UPPER(s.nombre) AS sede 
                FROM usuarios u
                INNER JOIN anticipo ant ON u.id_usuario =ant.id_usuario 
                INNER JOIN opcs_x_cats ON u.id_rol = opcs_x_cats.id_opcion and id_catalogo = 1
                INNER JOIN sedes s ON CAST(s.id_sede AS VARCHAR(45)) = CAST(u.id_sede AS VARCHAR(45))
                INNER JOIN usuarios us ON us.id_usuario= u.id_lider
                INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = us.id_rol AND oxc.id_catalogo = 1
                INNER JOIN opcs_x_cats oxc1 ON oxc1.id_opcion = ant.proceso and oxc1.id_catalogo = 128
                LEFT JOIN parcialidad_relacion_anticipo pra ON pra.id_anticipo = ant.id_anticipo

                where u.id_rol in(1,2,3,7,9) 
                AND ant.proceso in (3)
                ";

                $query = $this->db->query($cmd);
                return $query->result_array();
            } 

    function getComments($id){
        $cmd = "SELECT DISTINCT(hc.comentario) as comentario_general , hc.id_ha,hc.proceso ,
		opcx.nombre, pci.comentario as comentario_anticipo,hc.fecha_movimiento as  fechaAnticipo,
		hc.id_anticipo, hc.id_usuario
        FROM historial_anticipo hc 
        INNER JOIN anticipo pci ON pci.id_anticipo = hc.id_anticipo
		INNER JOIN opcs_x_cats opcx ON opcx.id_opcion = hc.proceso and opcx.id_catalogo = 128
        INNER JOIN usuarios u ON u.id_usuario = hc.id_usuario 
        WHERE hc.id_anticipo = $id
        ORDER BY hc.proceso DESC";
        $query = $this->db->query($cmd);
        return $query->result();
    }





        function leerxml( $xml_leer, $cargar_xml ){
            $str = '';
            if( $cargar_xml ){
                rename( $xml_leer, "./UPLOADS/XML_Anticipo/documento_temporal.txt" );
                $str = file_get_contents( "./UPLOADS/XML_Anticipo/documento_temporal.txt" );
                if( substr ( $str, 0, 3 ) == 'o;?' ){
                    $str = str_replace( "o;?", "", $str );
                    file_put_contents( './UPLOADS/XML_Anticipo/documento_temporal.txt', $str );
                }
                rename( "./UPLOADS/XML_Anticipo/documento_temporal.txt", $xml_leer );
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
            return $this->db->query("SELECT * FROM facturas_anticipos WHERE uuid = '".$uuid."'");
        }



        function insertar_factura( $id_anticipo, $datos_factura,$usuarioid){
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
                "id_anticipo" => $id_anticipo,
                "forma_pago" => $datos_factura['formaPago'],
                "cfdi" => $datos_factura['usocfdi'],
                "unidad" => $datos_factura['claveUnidad'],
                "claveProd" => $datos_factura['claveProdServ'],
                "fecha_creacion"  => date("Y-m-d H:i:s"),
                "fecha_ingreso"  => date("Y-m-d H:i:s"),
                "regimen" => $datos_factura['regimenFiscal'],
                "bandera" => 0
                
                
            );
            return $this->db->insert("facturas_anticipos", $data);
        }

    public function pausar_prestamo($arrayUpdate, $clave){
        try {
            $this->db->WHERE('id_prestamo', $clave);
            
            if($this->db->update('prestamos_aut', $arrayUpdate))
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
    
    

    function  todos_los_tipos(){
        
        $cmd = "SELECT * FROM opcs_x_cats 
                WHERE id_catalogo=23 
                AND id_opcion NOT IN (0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,27,28,41,42,51,52,88) 
                and estatus = 1";

        return $this->db->query($cmd)->result();
    }


}


    
    


