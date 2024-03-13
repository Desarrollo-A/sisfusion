

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pagos_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    //MODELO DEDICADO A EL PROCESO DE REVISION CONTRALORIA Y REVISION INTERNOMEX, VALIDAR Y ENVIAR PAGOS QUE SOLICITA VENTAS CADA CORTE
    
    function getBonosPorUserContra($estado){
        $filtro = '';
        if($this->session->userdata("id_rol") == 18){
            $filtro = "and u.id_rol IN (18, 19, 20, 25, 26, 27, 28, 30, 36)  ";
        }
        
        $cmd = "SELECT CONCAT(u.nombre, ' ', u.apellido_paterno, ' ' ,u.apellido_materno) AS nombre,
        CASE WHEN u.nueva_estructura = 2 THEN opcx2.nombre ELSE opcx.nombre END AS id_rol, p.id_bono, p.id_usuario,p.monto,p.num_pagos,b.abono pago,p.estatus,p.comentario,b.fecha_abono,b.estado,b.id_pago_bono,b.abono,b.n_p,
        (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*p.pago) ELSE p.pago END) impuesto1,sed.impuesto, u.rfc
        FROM bonos p 
        INNER JOIN usuarios u ON u.id_usuario=p.id_usuario 
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
        WHERE b.estado IN ($estado) $filtro";
        
        $query = $this->db->query($cmd);
        return $query->result_array();
    }

    function UpdateINMEX($id_bono,$estatus){
        $fecha='';
        $id = $id_bono;
        $comentario = 'INTERNOMEX MARCÓ COMO PAGADO';
        
        if($estatus == 6){
            $comentario = 'CONTRALORÍA ENVIÓ A INTERNOMEX';
        }else if($estatus ==2){
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
    
    public function update_acepta_contraloria($data , $clave){
        try {
            $id_user_Vl = $this->session->userdata('id_usuario');
            $cmd = "UPDATE pago_comision_ind SET estatus = 8, modificado_por =  $id_user_Vl  WHERE id_pago_i IN  ($clave) ";
            $query = $this->db->query($cmd);

            if($this->db->affected_rows() > 0 ){
                return TRUE;
            }else{
                return FALSE;
            }               
        }
        catch(Exception $e) {
            return $e->getMessage();
        }     
    }

    public function consulta_comisiones($sol){
        $cmd = ("SELECT id_pago_i FROM pago_comision_ind WHERE id_pago_i IN (".$sol.")");
        $query = $this->db->query($cmd);
        return  count($query->result_array()) > 0 ? $query->result_array() : FALSE ;
    }

    function insert_phc($data){
        $this->db->insert_batch('historial_comisiones', $data);
        return true;
    }

    function getDatosNuevasAsimiladosContraloria($proyecto, $condominio, $modoSubida=3){

        if( $this->session->userdata('id_rol') == 31) { // INTERNOMEX
            $filtro = "pci1.estatus IN (8, 88) AND com.id_usuario = $condominio";
            $whereFiltro = "";
            
            $ooam ='';
            $tipo='';
                
        }
        else { // CONTRALORÍA

            if($modoSubida != 0){ //Reestructura
                //$ooam = "AND com.ooam IN (0)";
                $tipo = "AND u.tipo = 2";
            }else{ //Comercialización
                //$ooam = "AND com.ooam NOT IN (0)";
                $tipo = "AND u.tipo = 1";
            }
            
            $filtro = "pci1.estatus IN (4)";

            if($condominio == 0)
                $whereFiltro = "AND co.idResidencial  = $proyecto";
            else
                $whereFiltro = "AND co.idCondominio  = $condominio";       
        }

        $cmd = "SELECT pci1.id_pago_i, pci1.id_comision, (CASE WHEN com.ooam = 2 THEN CONCAT(lo.nombreLote,'</b> <i>(',com.loteReubicado,')</i><b>') ELSE lo.nombreLote END) lote,(CASE WHEN com.ooam = 1 THEN ' (OOAM)' ELSE oxcest.nombre END) estatus_actual, re.nombreResidencial AS proyecto, lo.totalNeto2 precio_lote, 
        
        com.comision_total, com.porcentaje_decimal, 
        pci1.abono_neodata solicitado, pci1.pago_neodata pago_cliente, 
        (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, 
        (CASE u.forma_pago WHEN 3 THEN (((sed.impuesto)/100)*pci1.abono_neodata) ELSE 0 END) dcto, sed.impuesto valimpuesto,

        pci1.estatus, CONVERT(VARCHAR,pci1.fecha_pago_intmex,20) AS fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario, pci1.id_usuario, CASE WHEN cl.estructura = 1 THEN oprol2.nombre ELSE oprol.nombre END AS puesto, 0 personalidad_juridica, u.forma_pago, 0 AS factura, pac.porcentaje_abono, oxcest.nombre AS estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, 0 lugar_prospeccion, co.nombre AS condominio, lo.referencia,  u.rfc, (CASE WHEN cl.plan_comision IN (0) OR cl.plan_comision IS NULL THEN '-' ELSE pl.descripcion END) AS plan_descripcion, tv.tipo_venta, CONVERT(VARCHAR,cl.fechaApartado,20) AS fecha_apartado, sed.nombre as sede_nombre, oest.nombre as estatus_usuario, cp.codigo_postal
            FROM pago_comision_ind pci1 
            INNER JOIN comisiones com ON pci1.id_comision = com.id_comision AND com.estatus IN (1,8) 
            INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status IN (1,0) 
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio 
            INNER JOIN residenciales re ON re.idResidencial = co.idResidencial 
            LEFT JOIN clientes cl ON cl.id_cliente = com.idCliente
            INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago IN (3) $tipo
            INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
            INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
            INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23
            INNER JOIN cp_usuarios cp ON cp.id_usuario = u.id_usuario AND cp.estatus = 1
            LEFT JOIN opcs_x_cats oprol2 ON oprol2.id_opcion = com.rol_generado AND oprol2.id_catalogo = 83
            LEFT JOIN plan_comision pl ON pl.id_plan = cl.plan_comision
            LEFT JOIN tipo_venta tv ON tv.id_tventa = lo.tipo_venta
            LEFT JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 2 WHEN 4 THEN 5
            WHEN 5 THEN 3 WHEN 607 THEN 1 WHEN 7092 THEN 4 WHEN 9629 THEN 2 ELSE u.id_sede END) AND sed.estatus = 1
            LEFT JOIN opcs_x_cats oest ON oest.id_opcion = u.estatus AND oest.id_catalogo = 3
            WHERE $filtro $whereFiltro AND com.id_usuario NOT IN(7689,6019)
            GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, 
            com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex, 
            pci1.id_usuario, u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, 
            oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, co.nombre, lo.referencia, u.rfc, oprol2.nombre, cl.estructura,
            com.loteReubicado,com.ooam, pl.descripcion, cl.plan_comision, tv.tipo_venta, cl.fechaApartado, sed.nombre, oest.nombre, cp.codigo_postal, sed.impuesto";
        
        $query = $this->db->query($cmd); 
        return $query->result_array();
    }

    public function registroComisionAsimilados($id_pago){
        $cmd = "SELECT registro_comision FROM lotes l WHERE l.idLote IN (select c.id_lote FROM comisiones c WHERE c.id_comision IN (SELECT p.id_comision FROM pago_comision_ind p WHERE p.id_pago_i = $id_pago ";
        $query = $this->db->query($cmd);
        return  $query->result_array();
    }

    function getComments($pago){
        $cmd = "SELECT DISTINCT(hc.comentario), hc.id_pago_i, hc.id_usuario, convert(nvarchar(20), hc.fecha_movimiento, 113) date_final, hc.fecha_movimiento, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre_usuario
        FROM historial_comisiones hc 
        INNER JOIN pago_comision_ind pci ON pci.id_pago_i = hc.id_pago_i
        INNER JOIN usuarios u ON u.id_usuario = hc.id_usuario 
        WHERE hc.id_pago_i = $pago
        ORDER BY hc.fecha_movimiento DESC";
        $query = $this->db->query($cmd);
        return $query->result();
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

    function update_estatus_edit($id_pago_i, $obs) {
        $id_user_Vl = $this->session->userdata('id_usuario');
        $this->db->query("INSERT INTO historial_comisiones VALUES ($id_pago_i, $id_user_Vl, GETDATE(), 1, 'ACTUALIZÓ CONTRALORIA CON NUEVO MONTO: ".$obs."')");
        return $this->db->query("UPDATE pago_comision_ind SET abono_neodata = '".$obs."',modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_i IN (".$id_pago_i.")");
    }

    public function get_lista_usuarios($rol, $forma_pago){
        $cmd = "SELECT id_usuario AS idCondominio, CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) AS nombre FROM usuarios WHERE id_usuario IN (SELECT id_usuario FROM pago_comision_ind WHERE estatus IN (8,88)) AND id_rol = $rol AND forma_pago = $forma_pago ORDER BY nombre";
        $query = $this->db->query($cmd);
        return $query->result_array();
    }

    function update_acepta_INTMEX($idsol) {
        return $this->db->query("UPDATE pago_comision_ind SET estatus = 11, aply_pago_intmex = GETDATE(),modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_i IN (".$idsol.")");
    }
    
    function getPagosByProyect($proyect = '',$formap = ''){
        if(!empty($proyect)){
            $id = $proyect;
            $forma = $formap;
        }else{
            $id = 0;
        }
        
        $datos =array();
        $suma =  $this->db->query("SELECT sum(pci.abono_neodata) AS suma
        FROM residenciales re
        INNER JOIN condominios co ON re.idResidencial = co.idResidencial
        INNER JOIN lotes lo ON lo.idCondominio = co.idCondominio
        INNER JOIN comisiones com ON com.id_lote = lo.idLote AND com.estatus IN (1,8)
        INNER JOIN pago_comision_ind pci ON pci.id_comision = com.id_comision
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario 
        WHERE pci.estatus IN (8) and u.forma_pago=$formap and re.idResidencial=$id")->result_array();
        
        $ids = $this->db->query("SELECT pci.id_pago_i
        FROM residenciales re
        INNER JOIN condominios co ON re.idResidencial = co.idResidencial
        INNER JOIN lotes lo ON lo.idCondominio = co.idCondominio
        INNER JOIN comisiones com ON com.id_lote = lo.idLote AND com.estatus IN (1,8)
        INNER JOIN pago_comision_ind pci ON pci.id_comision = com.id_comision
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario 
        WHERE pci.estatus IN (8) and u.forma_pago=$forma and re.idResidencial=$id")->result_array();
        $datos[0]=$suma;
        $datos[1]=$ids;
        return $datos;
    }

    function update_estatus_refresh($idcom) {
        $id_user_Vl = $this->session->userdata('id_usuario');
        $this->db->query("INSERT INTO  historial_comisiones VALUES ($idcom, $id_user_Vl, GETDATE(), 1, 'SE ACTIVÓ NUEVAMENTE COMISIÓN')");
        return $this->db->query("UPDATE pago_comision_ind SET estatus = 4,modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_i IN (".$idcom.")");
    } 
    
    function consultaComisiones ($id_pago_is){
        $cmd = "SELECT id_pago_i FROM pago_comision_ind WHERE id_pago_i IN ($id_pago_is)";
        $query = $this->db->query($cmd);
        return count($query->result()) > 0 ? $query->result_array() : 0 ; 
    }

    public function report_empresa(){
        $cmd = "SELECT SUM(pci.abono_neodata) AS porc_empresa, res.empresa
        FROM pago_comision_ind pci 
        INNER JOIN comisiones com  ON com.id_comision = pci.id_comision
        INNER JOIN lotes lo  ON lo.idLote = com.id_lote 
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
        INNER JOIN residenciales res ON res.idResidencial = con.idResidencial 
        WHERE pci.estatus IN (8) GROUP BY res.empresa";
        $query = $this->db->query($cmd);
        return $query->result_array();
    }
    
    function getDatosNuevasRemanenteContraloria($proyecto,$condominio,$modoSubida=3){
        if( $this->session->userdata('id_rol') == 31) { // INTERNOMEX
            $filtro = "pci1.estatus IN (8, 88) AND com.id_usuario = $condominio";
            $whereFiltro = "";
            
            $ooam = '';
            $tipo = '';
            
        }
        else { // CONTRALORÍA

            if($modoSubida != 0){ //Reestructura
                $ooam = "AND com.ooam IN (0)";
                $tipo = "AND u.tipo = 2";
            }else{ //Comercialización
                $ooam = "AND com.ooam NOT IN (0)";
                $tipo = "AND u.tipo = 1";
            }
            
            $filtro = "pci1.estatus IN (4)";

            if($condominio == 0)
                $whereFiltro = "AND co.idResidencial  = $proyecto";
            else
                $whereFiltro = "AND co.idCondominio  = $condominio";       
        }

            $cmd = "SELECT pci1.id_pago_i, pci1.id_comision, (CASE WHEN com.ooam = 2 THEN CONCAT(lo.nombreLote,'</b> <i>(',com.loteReubicado,')</i><b>') ELSE lo.nombreLote END) lote,(CASE WHEN com.ooam = 1 THEN ' (OOAM)' ELSE oxcest.nombre END) estatus_actual, re.nombreResidencial AS proyecto, lo.totalNeto2 precio_lote, 
            com.comision_total, com.porcentaje_decimal, 
            pci1.abono_neodata solicitado, pci1.pago_neodata pago_cliente, 
            pci1.abono_neodata impuesto, 
            0 dcto, 0 valimpuesto,
            pci1.estatus, CONVERT(VARCHAR,pci1.fecha_pago_intmex,20) AS fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario, pci1.id_usuario, CASE WHEN cl.estructura = 1 THEN oprol2.nombre ELSE oprol.nombre END AS puesto, 0 personalidad_juridica, u.forma_pago, 0 AS factura, pac.porcentaje_abono, oxcest.nombre AS estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, 0 lugar_prospeccion, co.nombre AS condominio, lo.referencia,  u.rfc, (CASE WHEN cl.plan_comision IN (0) OR cl.plan_comision IS NULL THEN '-' ELSE pl.descripcion END) AS plan_descripcion, tv.tipo_venta, CONVERT(VARCHAR,cl.fechaApartado,20) AS fecha_apartado, sed.nombre as sede_nombre, oest.nombre as estatus_usuario, 'NA' AS codigo_postal
            FROM pago_comision_ind pci1 
            INNER JOIN comisiones com ON pci1.id_comision = com.id_comision AND com.estatus IN (1,8)
            INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status IN (1,0) 
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio 
            INNER JOIN residenciales re ON re.idResidencial = co.idResidencial 
            LEFT JOIN clientes cl ON cl.id_cliente = com.idCliente
            INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago IN (4) $tipo
            INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
            INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
            INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23
            LEFT JOIN opcs_x_cats oprol2 ON oprol2.id_opcion = com.rol_generado AND oprol2.id_catalogo = 83
            LEFT JOIN plan_comision pl ON pl.id_plan = cl.plan_comision
            LEFT JOIN tipo_venta tv ON tv.id_tventa = lo.tipo_venta
            LEFT JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 2 WHEN 4 THEN 5
            WHEN 5 THEN 3 WHEN 607 THEN 1 WHEN 7092 THEN 4 WHEN 9629 THEN 2 WHEN 13546 THEN 2 ELSE u.id_sede END) AND sed.estatus = 1
            LEFT JOIN opcs_x_cats oest ON oest.id_opcion = u.estatus AND oest.id_catalogo = 3
            WHERE $filtro $whereFiltro AND com.id_usuario NOT IN(7689,6019)
            GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, 
            com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex, 
            pci1.id_usuario, u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, 
            oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, co.nombre, lo.referencia, u.rfc, oprol2.nombre, cl.estructura,
            com.loteReubicado,com.ooam, pl.descripcion, cl.plan_comision, tv.tipo_venta, cl.fechaApartado, sed.nombre, oest.nombre";

            $query = $this->db->query($cmd);
            return $query->result_array();
    }

    public  function get_lista_roles() {
        $cmd = "SELECT id_opcion, nombre, id_catalogo FROM opcs_x_cats WHERE id_catalogo IN (1) and id_opcion IN (3, 9, 7, 2) ORDER BY id_opcion";
        $query =  $this->db->query($cmd);
        return $query->result_array();
    }
    
    function getDesarrolloSelectINTMEX($a = ''){
        if($a == ''){
            $forma_p = $this->session->userdata('id_usuario');
        }else{
            $forma_p = $a;
        }
        return $this->db->query("SELECT res.idResidencial id_usuario, res.descripcion  AS name_user
        FROM residenciales res WHERE res.idResidencial IN (SELECT re.idResidencial
        FROM residenciales re
        INNER JOIN condominios co ON re.idResidencial = co.idResidencial
        INNER JOIN lotes lo ON lo.idCondominio = co.idCondominio
        INNER JOIN comisiones com ON com.id_lote = lo.idLote AND com.estatus IN (1,8)
        INNER JOIN pago_comision_ind pci ON pci.id_comision = com.id_comision
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario 
        WHERE pci.estatus IN (8) and u.forma_pago=$forma_p GROUP BY re.idResidencial)");
    }
    
    public function getDatosDocumentos($id_comision, $id_pj){
        if ($id_pj == 1){
            return $this->db->query("(SELECT ox.id_opcion, ox.nombre, 'NO EXISTE' AS estado, 
            '0' AS expediente FROM opcs_x_cats ox 
            WHERE ox.id_opcion NOT IN (SELECT oxc.id_opcion FROM lotes lo 
            INNER JOIN comisiones com ON com.id_lote = lo.idLote 
            INNER JOIN historial_documento hd ON hd.idLote = lo.idLote 
            LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = hd.tipo_doc 
            WHERE com.id_comision = ".$id_comision." AND oxc.id_catalogo = 31) 
            AND ox.id_catalogo = 31 AND ox.estatus = 1)
            UNION (SELECT oxc.id_opcion, oxc.nombre, 'EXISTE' AS estado, hd.expediente 
            FROM lotes lO INNER JOIN comisiones com ON com.id_lote = lo.idLote
            INNER JOIN historial_documento hd ON hd.idLote = lo.idLote 
            LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = hd.tipo_doc 
            WHERE com.id_comision = ".$id_comision." AND oxc.id_catalogo = 31 AND oxc.estatus = 1)");
        }
        else{
            return $this->db->query("(SELECT ox.id_opcion, ox.nombre, 'NO EXISTE' AS estado, 
            '0' AS expediente FROM opcs_x_cats ox 
            WHERE ox.id_opcion NOT IN (SELECT oxc.id_opcion FROM lotes lo 
            INNER JOIN comisiones com ON com.id_lote = lo.idLote 
            INNER JOIN historial_documento hd ON hd.idLote = lo.idLote 
            LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = hd.tipo_doc 
            WHERE com.id_comision = ".$id_comision." AND oxc.id_catalogo = 32) 
            AND ox.id_catalogo = 32 AND ox.estatus = 1)
            UNION (SELECT oxc.id_opcion, oxc.nombre, 'EXISTE' AS estado, hd.expediente 
            FROM lotes lO INNER JOIN comisiones com ON com.id_lote = lo.idLote
            INNER JOIN historial_documento hd ON hd.idLote = lo.idLote 
            LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = hd.tipo_doc 
            WHERE com.id_comision = ".$id_comision." AND oxc.id_catalogo = 32 AND oxc.estatus = 1)");
        }
    }

    function factura_comision( $uuid, $id_res){
        return $this->db->query("SELECT DISTINCT CAST(uuid AS VARCHAR(MAX)) AS uuid ,
        u.nombre, u.apellido_paterno, u.apellido_materno, res.nombreResidencial AS nombreLote, f.fecha_factura, f.folio_factura, f.metodo_pago, f.regimen, f.forma_pago, f.cfdi, f.unidad, f.claveProd, f.total, f.total AS porcentaje_dinero, f.nombre_archivo, CAST(f.descripcion AS VARCHAR(MAX)) AS descrip,f.fecha_ingreso
        FROM facturas f 
        INNER JOIN usuarios u ON u.id_usuario = f.id_usuario
        INNER JOIN pago_comision_ind pci ON pci.id_pago_i = f.id_comision
        INNER JOIN comisiones com ON com.id_comision = pci.id_comision
        INNER JOIN lotes l ON l.idLote = com.id_lote
        INNER JOIN condominios con ON con.idCondominio = l.idCondominio
        INNER JOIN residenciales res ON res.idResidencial = con.idResidencial and res.idResidencial = $id_res
        WHERE /*MONTH(f.fecha_ingreso) >= 4 AND*/ f.uuid = '".$uuid."' ");
    }
    
    function getDatosNuevasFacturasContraloria($proyecto,$condominio,$modoSubida){
        if( $this->session->userdata('id_rol') == 31) { // INTERNOMEX
            $filtro = "pci1.estatus IN (8, 88) AND com.id_usuario = $condominio";
            $whereFiltro = "";
        }
        else { // CONTRALORÍA

            if($modoSubida != 0){ //Reestructura
                $ooam = "AND com.ooam IN (0)";
                $tipo = "AND u.tipo = 2";
            }else{ //Comercialización
                $ooam = "AND com.ooam NOT IN (0)";
                $tipo = "AND u.tipo = 1";
            }
            
            $filtro = "pci1.estatus IN (4)";

            if($condominio == 0)
                $whereFiltro = "AND co.idResidencial  = $proyecto";
            else
                $whereFiltro = "AND co.idCondominio  = $condominio";       
        }

            $cmd = "SELECT pci1.id_pago_i, pci1.id_comision, (CASE WHEN com.ooam = 2 THEN CONCAT(lo.nombreLote,'</b> <i>(',com.loteReubicado,')</i><b>') ELSE lo.nombreLote END) lote,(CASE WHEN com.ooam = 1 THEN ' (OOAM)' ELSE oxcest.nombre END) estatus_actual, re.nombreResidencial AS proyecto, lo.totalNeto2 precio_lote, 
            com.comision_total, com.porcentaje_decimal, 
            pci1.abono_neodata solicitado, pci1.pago_neodata pago_cliente, 
            pci1.abono_neodata impuesto, 
            0 dcto, 0 valimpuesto,
            pci1.estatus, CONVERT(VARCHAR,pci1.fecha_pago_intmex,20) AS fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario, pci1.id_usuario, CASE WHEN cl.estructura = 1 THEN oprol2.nombre ELSE oprol.nombre END AS puesto, 0 personalidad_juridica, u.forma_pago, 0 AS factura, pac.porcentaje_abono, oxcest.nombre AS estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, 0 lugar_prospeccion, co.nombre AS condominio, lo.referencia,  u.rfc, (CASE WHEN cl.plan_comision IN (0) OR cl.plan_comision IS NULL THEN '-' ELSE pl.descripcion END) AS plan_descripcion, tv.tipo_venta, CONVERT(VARCHAR,cl.fechaApartado,20) AS fecha_apartado, sed.nombre as sede_nombre, oest.nombre as estatus_usuario, 'NA' AS codigo_postal
            FROM pago_comision_ind pci1 
            INNER JOIN comisiones com ON pci1.id_comision = com.id_comision AND com.estatus IN (1,8)
            INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status IN (1,0) 
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio 
            INNER JOIN residenciales re ON re.idResidencial = co.idResidencial 
            LEFT JOIN clientes cl ON cl.id_cliente = com.idCliente
            INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago IN (2) $tipo
            INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
            INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
            INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23
            LEFT JOIN opcs_x_cats oprol2 ON oprol2.id_opcion = com.rol_generado AND oprol2.id_catalogo = 83
            LEFT JOIN plan_comision pl ON pl.id_plan = cl.plan_comision
            LEFT JOIN tipo_venta tv ON tv.id_tventa = lo.tipo_venta
            LEFT JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 2 WHEN 4 THEN 5
            WHEN 5 THEN 3 WHEN 607 THEN 1 WHEN 7092 THEN 4 WHEN 9629 THEN 2 ELSE u.id_sede END) AND sed.estatus = 1
            LEFT JOIN opcs_x_cats oest ON oest.id_opcion = u.estatus AND oest.id_catalogo = 3
            WHERE $filtro $whereFiltro AND com.id_usuario NOT IN(7689,6019)
            GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, 
            com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex, 
            pci1.id_usuario, u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, 
            oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, co.nombre, lo.referencia, u.rfc, oprol2.nombre, cl.estructura,
            com.loteReubicado,com.ooam, pl.descripcion, cl.plan_comision, tv.tipo_venta, cl.fechaApartado, sed.nombre, oest.nombre";

            $query = $this->db->query($cmd);
            return $query->result_array();
    }

    function update_estatus_pausaM($id_pago_i, $obs) {
        $id_user_Vl = $this->session->userdata('id_usuario');
        $this->db->query("INSERT INTO  historial_comisiones VALUES ($id_pago_i, $id_user_Vl, GETDATE(), 1, 'SE PAUSÓ COMISIÓN, MOTIVO: ".$obs."')");
        $respuesta =  $this->db->query("UPDATE pago_comision_ind SET estatus = 6, comentario = '".$obs."',modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_i IN (".$id_pago_i.")");
        $row = $this->db->query("SELECT uuid FROM facturas WHERE id_comision = ".$id_pago_i.";")->result_array();
        
        if(count($row) > 0){
            $datos =  $this->db->query("select id_factura,total,id_comision,bandera FROM facturas WHERE uuid='".$row[0]['uuid']."'")->result_array();
    
            for ($i=0; $i <count($datos); $i++) {
                if($datos[$i]['bandera'] == 1){
                    $respuesta = 1;
                }else{
                    $comentario = 'Se regresó esta factura que correspondo al pago con id '.$datos[$i]['id_comision'].' con el monto global de '.$datos[$i]['total'].' por motivo de: '.$obs.' ';
                    $response = $this->db->query("UPDATE facturas set total=0,id_comision=0,bandera=1,descripcion='$comentario'  WHERE id_factura=".$datos[$i]['id_factura']."");
                    $respuesta = $this->db->query("INSERT INTO  historial_comisiones VALUES (".$datos[$i]['id_comision'].", ".$this->session->userdata('id_usuario').", GETDATE(), 1, '".$comentario."')");
                }
            }
        }
        return $respuesta;
    }

    function RegresarFactura($uuid,$motivo){
        $datos =  $this->db->query("select id_factura,total,id_comision FROM facturas WHERE uuid='$uuid'")->result_array();
        for ($i=0; $i <count($datos); $i++) {
            $comentario = 'Se regresó esta factura que correspondo al pago con id '.$datos[$i]['id_comision'].' con el monto global de '.$datos[$i]['total'].' por motivo de: '.$motivo.' ';
            $response = $this->db->query("UPDATE facturas set total=0,id_comision=0,bandera=2,descripcion='$comentario'  WHERE id_factura=".$datos[$i]['id_factura']."");
            $respuesta = $this->db->query("INSERT INTO  historial_comisiones VALUES (".$datos[$i]['id_comision'].", ".$this->session->userdata('id_usuario').", GETDATE(), 1, '".$comentario."')");
        }
        return $respuesta;
    } 

    public function BanderaPDF($uuid){
        $respuesta = $this->db->query("UPDATE facturas set bandera=3 WHERE uuid='".$uuid."'");
        if ($respuesta ) {
            return 1;
        } else {
            return 0;
        }
    }

    function GetPagosFacturas($uuid){
        return $this->db->query("SELECT id_comision,id_factura FROM facturas WHERE uuid='".$uuid."'");
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
            "bandera" => 2
        );
        $this->db->update("facturas", $data, " id_comision = $id_comision");
        return $this->db->query("INSERT INTO xmldatos VALUES (".$id_factura.", '".$VALOR_TEXT."', GETDATE())");
    }

    function getDatosNuevasXContraloria($proyecto,$condominio = 0){
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
                $filtro02 = $filtro.' AND  fa.id_usuario = '.$user_data .' ';
            break;
            default:
                $filtro02 = $filtro.' ';
            break;
        }
        
        if($condominio == 0){
            return $this->db->query("SELECT SUM(pci1.abono_neodata) total, re.idResidencial, re.nombreResidencial AS proyecto, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario, pci1.id_usuario, u.forma_pago, 0 AS factura, oxcest.id_opcion id_estatus_actual, re.empresa, opn.estatus estatus_opinion, opn.archivo_name, fa.uuid,fa.nombre_archivo AS xmla,fa.bandera, u.rfc
            FROM pago_comision_ind pci1 
            INNER JOIN comisiones com ON pci1.id_comision = com.id_comision AND com.estatus IN (1,8)
            INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
            INNER JOIN residenciales re ON re.idResidencial = co.idResidencial AND re.idResidencial = $proyecto
            INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago IN (2)
            INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
            INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
            INNER JOIN opinion_cumplimiento opn ON opn.id_usuario = u.id_usuario and opn.estatus IN (2) 
            INNER JOIN facturas fa ON fa.id_comision = pci1.id_pago_i
            $filtro02 
            GROUP BY re.idResidencial, re.nombreResidencial, u.nombre, u.apellido_paterno, u.apellido_materno, pci1.id_usuario, u.forma_pago, oxcest.id_opcion, re.empresa, re.idResidencial, opn.estatus, opn.archivo_name, fa.uuid, fa.nombre_archivo, fa.bandera, u.rfc
            ORDER BY u.nombre");
        }
        else{
            return $this->db->query("SELECT SUM(pci1.abono_neodata) total, re.idResidencial, re.nombreResidencial AS proyecto, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario, pci1.id_usuario, u.forma_pago, 0 AS factura, oxcest.id_opcion id_estatus_actual, re.empresa, opn.estatus estatus_opinion, opn.archivo_name, fa.uuid,fa.nombre_archivo AS xmla,fa.bandera , u.rfc
            FROM pago_comision_ind pci1 
            INNER JOIN comisiones com ON pci1.id_comision = com.id_comision AND com.estatus IN (1,8)
            INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio 
            INNER JOIN residenciales re ON re.idResidencial = co.idResidencial AND re.idResidencial = $proyecto
            INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago IN (2)
            INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
            INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
            INNER JOIN opinion_cumplimiento opn ON opn.id_usuario = u.id_usuario and opn.estatus IN (2) 
            INNER JOIN facturas fa ON fa.id_comision = pci1.id_pago_i
            $filtro02
            GROUP BY re.idResidencial, re.nombreResidencial, u.nombre, u.apellido_paterno, u.apellido_materno, pci1.id_usuario, u.forma_pago, oxcest.id_opcion, re.empresa, re.idResidencial, opn.estatus, opn.archivo_name, fa.uuid,fa.nombre_archivo,fa.bandera, u.rfc
            ORDER BY u.nombre");
        }
    }

    function verificar_uuid( $uuid ){
        return $this->db->query("SELECT * FROM facturas WHERE uuid = '".$uuid."'");
    }

    public function get_solicitudes_factura( $idResidencial, $id_usuario ){
        if( $this->session->userdata('id_rol') == 31 ){
            $filtro = "WHERE pci1.estatus IN (8,88) ";
        } else{
            $filtro = "WHERE pci1.estatus IN (4) ";
        }
        
        return $this->db->query("SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote AS lote, re.nombreResidencial AS proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata,  pci1.estatus, pci1.fecha_pago_intmex fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario ,pci1.id_usuario, oprol.nombre AS puesto, cl.personalidad_juridica, u.forma_pago, 0 AS factura, pac.porcentaje_abono, oxcest.nombre AS estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, cl.lugar_prospeccion, co.nombre AS condominio, lo.referencia
        FROM pago_comision_ind pci1 
        INNER JOIN comisiones com ON pci1.id_comision = com.id_comision AND com.estatus IN (1,8)
        INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial AND re.idResidencial = $idResidencial
        INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 1
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago IN (2)
        INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
        INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
        INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
        $filtro AND u.id_usuario = $id_usuario
        GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex, pci1.id_usuario, cl.personalidad_juridica, u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, cl.lugar_prospeccion, co.nombre, lo.referencia ORDER BY lo.nombreLote")->result_array();
    }

    function getDatosNuevasExContraloria($proyecto,$condominio){
        if($this->session->userdata('id_rol') == 31) { // INTERNOMEX
            $filtro = " pci1.estatus IN (8, 88) AND com.id_usuario = $condominio";
            $whereFiltro = "";
        } else { // CONTRALORÍA
            $filtro = " pci1.estatus IN (4)";
            if($condominio == 0)
                $whereFiltro = "AND co.idResidencial  = $proyecto";
                else
                    $whereFiltro = "AND co.idCondominio  = $condominio";
            }

            $cmd = "SELECT pci1.id_pago_i, pci1.id_comision, (CASE WHEN com.ooam = 2 THEN CONCAT(lo.nombreLote,'</b> <i>(',com.loteReubicado,')</i><b>') ELSE lo.nombreLote END) lote,(CASE WHEN com.ooam = 1 THEN ' (OOAM)' ELSE oxcest.nombre END) estatus_actual, re.nombreResidencial AS proyecto, lo.totalNeto2 precio_lote, 
            com.comision_total, com.porcentaje_decimal, 
            pci1.abono_neodata solicitado, pci1.pago_neodata pago_cliente, 
            pci1.abono_neodata impuesto, 
            0 dcto, 0 valimpuesto,
            pci1.estatus, CONVERT(VARCHAR,pci1.fecha_pago_intmex,20) AS fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario, pci1.id_usuario, CASE WHEN cl.estructura = 1 THEN oprol2.nombre ELSE oprol.nombre END AS puesto, 0 personalidad_juridica, u.forma_pago, 0 AS factura, pac.porcentaje_abono, oxcest.nombre AS estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, 0 lugar_prospeccion, co.nombre AS condominio, lo.referencia,  u.rfc, (CASE WHEN cl.plan_comision IN (0) OR cl.plan_comision IS NULL THEN '-' ELSE pl.descripcion END) AS plan_descripcion, tv.tipo_venta, CONVERT(VARCHAR,cl.fechaApartado,20) AS fecha_apartado, sed.nombre as sede_nombre, oest.nombre as estatus_usuario, 'NA' AS codigo_postal
            FROM pago_comision_ind pci1 
            INNER JOIN comisiones com ON pci1.id_comision = com.id_comision AND com.estatus IN (1,8)
            INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status IN (1,0) 
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio 
            INNER JOIN residenciales re ON re.idResidencial = co.idResidencial 
            LEFT JOIN clientes cl ON cl.id_cliente = com.idCliente
            INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago IN (5)
            INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
            INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
            INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23
            LEFT JOIN opcs_x_cats oprol2 ON oprol2.id_opcion = com.rol_generado AND oprol2.id_catalogo = 83
            LEFT JOIN plan_comision pl ON pl.id_plan = cl.plan_comision
            LEFT JOIN tipo_venta tv ON tv.id_tventa = lo.tipo_venta
            LEFT JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 2 WHEN 4 THEN 5
            WHEN 5 THEN 3 WHEN 607 THEN 1 WHEN 7092 THEN 4 WHEN 9629 THEN 2 ELSE u.id_sede END) AND sed.estatus = 1
            LEFT JOIN opcs_x_cats oest ON oest.id_opcion = u.estatus AND oest.id_catalogo = 3
            WHERE $filtro $whereFiltro AND com.id_usuario NOT IN(7689,6019)
            GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, 
            com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex, 
            pci1.id_usuario, u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, 
            oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, co.nombre, lo.referencia, u.rfc, oprol2.nombre, cl.estructura,
            com.loteReubicado,com.ooam, pl.descripcion, cl.plan_comision, tv.tipo_venta, cl.fechaApartado, sed.nombre, oest.nombre";

            $query = $this->db->query($cmd);
            return $query->result_array();
    }

    public function getComprobantesExtranjero() {
        $query = $this->db->query("SELECT sum(pci1.abono_neodata) total, u.id_usuario, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) usuario, fp.nombre AS forma_pago, na.nombre AS nacionalidad, opn.estatus estatus_archivo, opn.archivo_name, estatus.nombre AS estatus_usuario, u.rfc
        FROM pago_comision_ind pci1
        INNER JOIN comisiones com ON pci1.id_comision = com.id_comision AND com.estatus IN (1,8)
        INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago IN (5)
        INNER JOIN opcs_x_cats na ON na.id_opcion = u.nacionalidad AND na.id_catalogo = 11
        INNER JOIN opinion_cumplimiento opn ON opn.id_usuario = u.id_usuario and opn.estatus IN (2)
        INNER JOIN opcs_x_cats fp ON fp.id_opcion = u.forma_pago AND fp.id_catalogo = 16
        INNER JOIN opcs_x_cats estatus ON estatus.id_opcion = u.estatus AND estatus.id_catalogo = 3
        INNER JOIN pagos_invoice iv ON iv.id_pago_i = pci1.id_pago_i
        WHERE pci1.estatus IN (4,8,88)
        GROUP BY opn.archivo_name, u.nombre, u.apellido_paterno, u.apellido_materno, u.id_usuario, u.forma_pago, opn.estatus, na.nombre, fp.nombre, estatus.nombre, u.rfc
        ORDER BY u.nombre");
        return $query->result_array();
    }

    function nueva_mktd_comision($values_send,$id_usuario,$abono_mktd,$pago_mktd,$user, $num_plan,$empresa){
        $respuesta = $this->db->query("INSERT INTO pago_comision_mktd (id_list, id_usuario, abono_marketing, fecha_abono, fecha_pago_intmex, pago_mktd, estatus, creado_por, comentario,empresa) VALUES ('$values_send', $id_usuario, $abono_mktd, GETDATE(), GETDATE(), $pago_mktd, 1, $user, 'DISPERSIÓN MKTD $num_plan','$empresa')");
        if (! $respuesta ) {
            return false;
        } else {
            return true;
        }
    }

    function update_contraloria_especial($idsol) {
        return $this->db->query("UPDATE pago_comision_ind SET estatus = 11 ,modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_i IN (".$idsol.")");
    }

    function getDatosEspecialesContraloria(){    

        $cmd = "SELECT pci1.id_pago_i, pci1.id_comision, (CASE WHEN com.ooam = 2 THEN CONCAT(lo.nombreLote,'</b> <i>(',com.loteReubicado,')</i><b>') ELSE lo.nombreLote END) lote,(CASE WHEN com.ooam = 1 THEN ' (OOAM)' ELSE oxcest.nombre END) estatus_actual, re.nombreResidencial AS proyecto, lo.totalNeto2 precio_lote, 
        com.comision_total, com.porcentaje_decimal, 
        pci1.abono_neodata solicitado, pci1.pago_neodata pago_cliente, 
        pci1.abono_neodata impuesto, 
        0 dcto, 0 valimpuesto,
        pci1.estatus, CONVERT(VARCHAR,pci1.fecha_pago_intmex,20) AS fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario, pci1.id_usuario, CASE WHEN cl.estructura = 1 THEN oprol2.nombre ELSE oprol.nombre END AS puesto, 0 personalidad_juridica, u.forma_pago, 0 AS factura, pac.porcentaje_abono, oxcest.nombre AS estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, 0 lugar_prospeccion, co.nombre AS condominio, lo.referencia,  u.rfc, (CASE WHEN cl.plan_comision IN (0) OR cl.plan_comision IS NULL THEN '-' ELSE pl.descripcion END) AS plan_descripcion, tv.tipo_venta, CONVERT(VARCHAR,cl.fechaApartado,20) AS fecha_apartado, sed.nombre as sede_nombre, oest.nombre as estatus_usuario, 'NA' AS codigo_postal
            FROM pago_comision_ind pci1 
            INNER JOIN comisiones com ON pci1.id_comision = com.id_comision AND com.estatus IN (1,8)
            INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status IN (1,0) 
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio 
            INNER JOIN residenciales re ON re.idResidencial = co.idResidencial 
            LEFT JOIN clientes cl ON cl.id_cliente = com.idCliente
            INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
            INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
            INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
            INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23
            LEFT JOIN opcs_x_cats oprol2 ON oprol2.id_opcion = com.rol_generado AND oprol2.id_catalogo = 83
            LEFT JOIN plan_comision pl ON pl.id_plan = cl.plan_comision
            LEFT JOIN tipo_venta tv ON tv.id_tventa = lo.tipo_venta
            LEFT JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 2 WHEN 4 THEN 5
            WHEN 5 THEN 3 WHEN 607 THEN 1 WHEN 7092 THEN 4 WHEN 9629 THEN 2 ELSE u.id_sede END) AND sed.estatus = 1
            LEFT JOIN opcs_x_cats oest ON oest.id_opcion = u.estatus AND oest.id_catalogo = 3
            WHERE pci1.estatus IN (4) AND com.id_usuario IN(7689,6019)
            GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, 
            com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex, 
            pci1.id_usuario, u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, 
            oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, co.nombre, lo.referencia, u.rfc, oprol2.nombre, cl.estructura,
            com.loteReubicado,com.ooam, pl.descripcion, cl.plan_comision, tv.tipo_venta, cl.fechaApartado, sed.nombre, oest.nombre";

            $query = $this->db->query($cmd);
            return $query->result_array();
    }
    
    function getHistorialAbono2($pago){
        $this->db->query("SET LANGUAGE Español;");
        
        return $this->db->query("SELECT DISTINCT(hc.comentario), hc.id_pago_b, hc.id_usuario, convert(nvarchar(20), hc.fecha_creacion, 113) date_final, hc.fecha_creacion AS fecha_movimiento, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre_usuario
        FROM historial_bonos hc 
        INNER JOIN pagos_bonos_ind pci ON pci.id_pago_bono = hc.id_pago_b
        INNER JOIN usuarios u ON u.id_usuario = hc.id_usuario 
        WHERE hc.id_pago_b = $pago
        ORDER BY hc.fecha_creacion DESC");
    }
    
    public function getFormasPago(){
        $query = $this->db->query("SELECT id_opcion, nombre, estatus FROM opcs_x_cats WHERE id_catalogo = 16");
        return $query->result_array();
    }
    
    public function getCommissionsByMktdUser($estatus,$typeTransaction, $beginDate, $endDate, $whereFiltro){
        if ($typeTransaction == 1 || $typeTransaction == 3) {  // FIRST LOAD || SEARCH BY DATE RANGE
            $filter = " AND pcm.fecha_abono BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59'";
            $filterTwo = "";
        } else if($typeTransaction == 2) { // SEARCH BY LOTE
            $filter = "";
            $filterTwo = " AND l.idLote = $whereFiltro";
        }
        
        if($beginDate != '' && $endDate != '' && $estatus == 0){
            $query = $this->db-> query("SELECT op.nombre,pcm.id_usuario, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre_comisionista, SUM(abono_marketing) total_dispersado, CONVERT(char(10), pcm.fecha_abono , 111) fecha, oxc.nombre rol, u.rfc 
            FROM pago_comision_mktd pcm 
            LEFT JOIN usuarios u ON u.id_usuario = pcm.id_usuario
            LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = u.id_rol AND oxc.id_catalogo = 1
            INNER JOIN opcs_x_cats op ON op.id_opcion=pcm.estatus 
            WHERE op.id_catalogo= 23 $filter
            GROUP BY op.nombre,pcm.id_usuario, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno), CONVERT(char(10), pcm.fecha_abono , 111), oxc.nombre, u.rfc ORDER BY nombre_comisionista;");
            return $query;
        } else if($beginDate != '' && $endDate != '' && $estatus != 0){
            $query = $this->db-> query("SELECT op.nombre,pcm.id_usuario, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre_comisionista, SUM(abono_marketing) total_dispersado, CONVERT(char(10), pcm.fecha_abono , 111) fecha, oxc.nombre rol, us.rfc FROM pago_comision_mktd pcm 
            LEFT JOIN usuarios u ON u.id_usuario = pcm.id_usuario
            LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = u.id_rol AND oxc.id_catalogo = 1
            INNER JOIN opcs_x_cats op ON op.id_opcion= pcm.estatus
            INNER JOIN usuarios us ON us.id_usuario = pcm.id_usuario
            WHERE  op.id_catalogo= 23 AND pcm.estatus = $estatus $filter
            GROUP BY op.nombre,pcm.id_usuario, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno), CONVERT(char(10), pcm.fecha_abono , 111), oxc.nombre, us.rfc ORDER BY nombre_comisionista;");
            return $query;
        }
    }
    
    public function getEstatusPagosMktd() {
        $query = $this->db-> query("select id_opcion,(CASE nombre WHEN 'Nueva, sin solicitar' THEN 'En revisión contraloría' ELSE nombre END) nombre FROM opcs_x_cats WHERE id_catalogo = 23 and estatus=1 AND id_opcion IN (1, 8, 11)");
        return $query->result_array();
    }
    
    function getDatosRevisionMktd2($mes=0,$anio=0,$estatus=0){
        if( $this->session->userdata('id_rol') == 31 ){
            $filtro = "WHERE pcmk.estatus = 8 AND pcmk.abono_marketing > 0 ";
        } else{
            if($mes != 0){
                $fecha = $anio.'-'.$mes.'-01';
                $fecha2 = $anio.'-'.$mes.'-28';
                $filtro = "WHERE pcmk.estatus = $estatus AND pcmk.fecha_pago_intmex BETWEEN '$fecha 00:00:00' AND '$fecha2 23:59:59' AND pcmk.abono_marketing > 0 ";
            } else{
                $filtro = "WHERE pcmk.estatus = 1 AND pcmk.abono_marketing > 0 ";
            }
        }
        return $this->db->query("SELECT SUM(pcmk.abono_marketing) sum_abono_marketing, us.id_usuario, CONCAT(us.nombre,' ', us.apellido_paterno, ' ', us.apellido_materno) colaborador, sed.nombre sede, oxc.nombre forma_pago,
        (CASE us.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*SUM(pcmk.abono_marketing)) ELSE SUM(pcmk.abono_marketing) END) impuesto, 
        (CASE us.forma_pago WHEN 3 THEN (((sed.impuesto)/100)*SUM(pcmk.abono_marketing)) ELSE 0 END) dcto, sed.impuesto valimpuesto 
        FROM pago_comision_mktd pcmk
        INNER JOIN usuarios us ON us.id_usuario = pcmk.id_usuario 
        INNER JOIN sedes sed ON sed.id_sede = (CASE WHEN LEN (us.id_sede) > 1 THEN 2 ELSE us.id_sede END)
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = us.forma_pago AND oxc.id_catalogo = 16
        $filtro
        GROUP BY pcmk.id_usuario, us.nombre, us.apellido_paterno, us.apellido_materno, us.id_usuario, sed.nombre, oxc.nombre, us.forma_pago, sed.impuesto");
    }
            
    public function getBonoXUser2($user,$comentario,$mes=0,$anio=0,$estatus=0){    
        $filtro='';
        if($mes != 0){
            $fecha = $anio.'-'.$mes.'-01';
            $fecha2 = $anio.'-'.$mes.'-28';
            $e='2';
            
            if($estatus == 11){
                $e=3;
            } else if($estatus == 8){
                $e=6;
            }
            $filtro = "and d.estado IN($e) and d.fecha_abono_intmex BETWEEN '$fecha 00:00:00' AND '$fecha2 23:59:59'";
        } else{
            $filtro="and d.estado IN(2,6)";
        }
        
        return  $respuesta = $this->db->query("SELECT SUM( (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)* d.abono) ELSE d.abono END) ) AS impuesto1
        FROM bonos p 
        LEFT JOIN pagos_bonos_ind d ON d.id_bono=p.id_bono
        INNER JOIN usuarios u ON u.id_usuario=p.id_usuario 
        INNER JOIN opcs_x_cats opcx on opcx.id_opcion=u.id_rol
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = u.forma_pago AND oxc.id_catalogo = 16
        LEFT JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario  WHEN 2 THEN 2  WHEN 3 THEN 2  WHEN 1980 THEN 2  WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 2 WHEN 4 THEN 5 WHEN 5 THEN 3 WHEN 607 THEN 1 ELSE u.id_sede END) and sed.estatus = 1
        WHERE p.estatus IN(1,2) and opcx.id_catalogo=1 and p.id_usuario=$user $filtro and p.comentario like '%$comentario%'
        group by u.forma_pago,sed.impuesto,p.pago");
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
        WHERE pci.estatus IN (1, 41, 42, 51, 52, 61, 62, 12) AND lo.idLote IN (select id_lote FROM reportes_marketing WHERE estatus = 1 AND dispersion = 1) AND pci.id_usuario = 4394 AND lo.status = 1 AND lo.idLote NOT IN (select id_lote FROM compartidas_mktd) AND cl.status = 1 AND lo.ubicacion_dos IN (".$sede.") AND plm.id_plan = ".$PLAN." AND res.empresa = '".$empresa."' AND res.idResidencial = '".$res."'
        GROUP BY plm.id_plan, pci.id_usuario, lo.ubicacion_dos, s.nombre, us.nombre, us.apellido_paterno, res.empresa, res.nombreResidencial
        ORDER by plm.id_plan");
    }

    function getDatosRevisionMktd(){
        if( $this->session->userdata('id_rol') == 31 ){
            $filtro = "WHERE pcmk.estatus = 8 AND pcmk.abono_marketing > 0 ";
        } else{
            $filtro = "WHERE pcmk.estatus = 1 AND pcmk.abono_marketing > 0 ";
        }
        return $this->db->query("SELECT SUM(pcmk.abono_marketing) sum_abono_marketing, us.id_usuario, CONCAT(us.nombre,' ', us.apellido_paterno, ' ', us.apellido_materno) colaborador, UPPER(sed.nombre) sede, UPPER(oxc.nombre) forma_pago,
        (CASE us.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*SUM(pcmk.abono_marketing)) ELSE SUM(pcmk.abono_marketing) END) impuesto, 
        (CASE us.forma_pago WHEN 3 THEN (((sed.impuesto)/100)*SUM(pcmk.abono_marketing)) ELSE 0 END) dcto, sed.impuesto valimpuesto , pcmk.empresa,us.rfc
        FROM pago_comision_mktd pcmk
        INNER JOIN usuarios us ON us.id_usuario = pcmk.id_usuario 
        INNER JOIN sedes sed ON sed.id_sede = (CASE WHEN LEN (us.id_sede) > 1 THEN 2 ELSE us.id_sede END)
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = us.forma_pago AND oxc.id_catalogo = 16
        $filtro
        GROUP BY pcmk.id_usuario, pcmk.empresa, us.nombre, us.apellido_paterno, us.apellido_materno, us.id_usuario, sed.nombre, oxc.nombre, us.forma_pago, sed.impuesto,us.rfc");
    }

    function getDatosColabMktd($sede, $plan){
        if($plan == 9 || $plan == 11  || $plan == 12 || $plan == 13){
            $filtro_1 = ' , 28';
            $filtro_2 = " UNION (SELECT pk.id_plan, pk.fecha_plan, getdate() AS fin_plan, u.id_usuario, CONCAT(u.nombre,' ' ,u.apellido_paterno,' ',u.apellido_materno) AS colaborador, op1.nombre AS rol, pcm.porcentaje, u.id_sede, op1.id_opcion, (CASE op1.id_opcion WHEN '18' THEN 1 WHEN '19' THEN 2 WHEN '20 ' THEN 3 WHEN '25' THEN 4 ELSE op1.id_opcion END) AS rol_dos FROM planes_mktd pk INNER JOIN porcentajes_mktd pcm ON pcm.numero_plan = pk.id_plan INNER JOIN usuarios u ON u.id_usuario = pcm.id_usuario INNER JOIN opcs_x_cats op1 ON op1.id_opcion = pcm.rol WHERE op1.id_catalogo = 1 AND pcm.rol IN (28) AND pcm.id_plaza IN (2) AND pk.id_plan = $plan) ";
        } else{
            $filtro_1 = ' ';
            $filtro_2 = ' ';
        }
        
        return $this->db->query("(SELECT pk.id_plan, pk.fecha_plan, getdate() AS fin_plan, u.id_usuario, CONCAT(u.nombre,' ' ,u.apellido_paterno,' ',u.apellido_materno) AS colaborador, op1.nombre AS rol, pcm.porcentaje, u.id_sede, op1.id_opcion, (CASE op1.id_opcion WHEN '18' THEN 1 WHEN '10' THEN 2 WHEN '19' THEN 3 WHEN '37' THEN 4 WHEN '25 ' THEN 5 WHEN '29' THEN 6 WHEN '30' THEN 7 WHEN '20' THEN 8 WHEN '28' THEN 9 ELSE op1.id_opcion END) AS rol_dos
        FROM planes_mktd pk INNER JOIN porcentajes_mktd pcm ON pcm.numero_plan = pk.id_plan INNER JOIN usuarios u ON u.id_usuario = pcm.id_usuario INNER JOIN opcs_x_cats op1 ON op1.id_opcion = pcm.rol WHERE op1.id_catalogo = 1 AND pcm.rol NOT IN (19, 20 ".$filtro_1.") AND pk.id_plan = $plan)
        UNION (SELECT pk.id_plan, pk.fecha_plan, getdate() AS fin_plan, u.id_usuario, CONCAT(u.nombre,' ' ,u.apellido_paterno,' ',u.apellido_materno) AS colaborador, op1.nombre AS rol, pcm.porcentaje, u.id_sede, op1.id_opcion, (CASE op1.id_opcion WHEN '18' THEN 1 WHEN '19' THEN 2 WHEN '20 ' THEN 3 WHEN '25' THEN 4 ELSE op1.id_opcion END) AS rol_dos FROM planes_mktd pk INNER JOIN porcentajes_mktd pcm ON pcm.numero_plan = pk.id_plan INNER JOIN usuarios u ON u.id_usuario = pcm.id_usuario INNER JOIN opcs_x_cats op1 ON op1.id_opcion = pcm.rol WHERE op1.id_catalogo = 1 AND pcm.rol IN (20) AND pcm.id_sede IN ($sede) AND pk.id_plan = $plan) 
        ".$filtro_2."
        UNION (SELECT pk.id_plan, pk.fecha_plan, getdate() AS fin_plan, u.id_usuario, CONCAT(u.nombre,' ' ,u.apellido_paterno,' ',u.apellido_materno) AS colaborador, op1.nombre AS rol, pcm.porcentaje, u.id_sede, op1.id_opcion, (CASE op1.id_opcion WHEN '18' THEN 1 WHEN '19' THEN 2 WHEN '20 ' THEN 3 WHEN '25' THEN 4 ELSE op1.id_opcion END) AS rol_dos FROM planes_mktd pk INNER JOIN porcentajes_mktd pcm ON pcm.numero_plan = pk.id_plan INNER JOIN usuarios u ON u.id_usuario = pcm.id_usuario INNER JOIN opcs_x_cats op1 ON op1.id_opcion = pcm.rol WHERE op1.id_catalogo = 1 AND pcm.rol IN (19) AND pcm.id_plaza IN (2) AND pk.id_plan = $plan) order by rol_dos");
    }

    function getDatosNuevasmkContraloria(){
        if( $this->session->userdata('id_rol') == 31 ){
            $filtro = "WHERE pci1.estatus IN (8) ";
        }
        else{
            $filtro = "WHERE pci1.estatus IN (13) ";
        }
        return $this->db->query("SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote AS lote, re.nombreResidencial AS proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, CONVERT(VARCHAR,pci1.fecha_pago_intmex,20) AS fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario ,pci1.id_usuario, oprol.nombre AS puesto, cl.personalidad_juridica, u.forma_pago, 0 AS factura, pac.porcentaje_abono, oxcest.nombre AS estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, cl.lugar_prospeccion, co.nombre AS condominio, lo.referencia, (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, (CASE u.forma_pago WHEN 3 THEN (((sed.impuesto)/100)*pci1.abono_neodata) ELSE 0 END) dcto, sed.impuesto valimpuesto,com.id_lote,sed2.nombre AS sede, u.rfc
        FROM pago_comision_ind pci1 
        INNER JOIN comisiones com ON pci1.id_comision = com.id_comision AND com.estatus IN (1,8)
        INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial 
        INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 1
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario  
        INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
        INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
        INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
        INNER JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 2 WHEN 4 THEN 5 WHEN 5 THEN 3 WHEN 607 THEN 1 WHEN 7092 THEN 4 WHEN 9629 THEN 2 ELSE u.id_sede END) and sed.estatus = 1
        LEFT JOIN sedes sed2 ON sed2.id_sede = lo.ubicacion_dos
        $filtro  and com.rol_generado IN (38)
        GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, /*pci2.abono_pagado, */pci1.estatus, pci1.fecha_pago_intmex, pci1.id_usuario, cl.personalidad_juridica, u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, cl.lugar_prospeccion, co.nombre, lo.referencia, sed.impuesto,com.id_lote, sed2.nombre, u.rfc ORDER BY lo.nombreLote");
    } 

public function getCommissionsByMktdUserReport($estatus,$typeTransaction, $beginDate, $endDate, $whereFiltro)
{
    if ($typeTransaction == 1 || $typeTransaction == 3) {  // FIRST LOAD || SEARCH BY DATE RANGE
        $filter = " AND pci.fecha_abono BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59'";
        $filterTwo = "";
    } else if($typeTransaction == 2) { // SEARCH BY LOTE
        $filter = "";
        $filterTwo = " AND l.idLote = $whereFiltro";
    }
    if($beginDate != '' && $endDate != '' && $estatus == 0){
        $query = $this->db-> query("SELECT pci.id_usuario, (CASE op.nombre WHEN 'Nueva, sin solicitar' THEN 'En revisión contraloría' 
        ELSE op.nombre END) nombre, lo.ubicacion_dos, plm.id_plan, s.nombre AS sede, SUM(pci.abono_neodata) total, us.rfc
        FROM pago_comision_ind pci 
        INNER JOIN comisiones com ON com.id_comision = pci.id_comision
        INNER JOIN lotes lo ON lo.idLote = com.id_lote
        INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente
        INNER JOIN planes_mktd plm ON plm.fecha_plan <= cl.fechaApartado AND plm.fin_plan >= cl.fechaApartado
        INNER JOIN sedes s ON s.id_sede = lo.ubicacion_dos
        INNER JOIN usuarios us ON us.id_usuario = pci.id_usuario
        INNER JOIN opcs_x_cats op ON op.id_opcion=pci.estatus 
        WHERE pci.id_usuario = 4394 and pci.estatus IN (1,8,11) and op.id_catalogo = 23 AND lo.status = 1 AND cl.status = 1 ".$filter."
        GROUP BY plm.id_plan, pci.id_usuario, op.nombre, lo.ubicacion_dos, s.nombre, us.rfc
        ORDER by plm.id_plan");
        return $query;
        } else if($beginDate != '' && $endDate != '' && $estatus != 0){
            $query = $this->db-> query("SELECT pci.id_usuario, (CASE op.nombre WHEN 'Nueva, sin solicitar' THEN 'En revisión contraloría' ELSE op.nombre END) nombre , lo.ubicacion_dos, plm.id_plan, s.nombre AS sede, SUM(pci.abono_neodata) total, us.rfc
            FROM pago_comision_ind pci 
            INNER JOIN comisiones com ON com.id_comision = pci.id_comision
            INNER JOIN lotes lo ON lo.idLote = com.id_lote
            INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente
            INNER JOIN planes_mktd plm ON plm.fecha_plan <= cl.fechaApartado AND plm.fin_plan >= cl.fechaApartado
            INNER JOIN sedes s ON s.id_sede = lo.ubicacion_dos
            INNER JOIN usuarios us ON us.id_usuario = pci.id_usuario
            INNER JOIN opcs_x_cats op ON op.id_opcion=pci.estatus 
            WHERE pci.estatus = $estatus AND pci.id_usuario = 4394 AND op.id_catalogo = 23 AND lo.status = 1 AND cl.status = 1 ".$filter."
            GROUP BY plm.id_plan, pci.id_usuario, op.nombre, lo.ubicacion_dos, s.nombre, us.rfc
            ORDER by plm.id_plan");
            return $query;
        }
    }

    function getMktdRol(){
        return $this->db->query("SELECT * FROM usuarios WHERE id_rol IN (18, 19, 20, 25, 26, 27, 28, 29, 30, 36, 50)");
    }

    function getLotesOrigenmk($user){
        return $this->db->query("SELECT pci.id_pago_mk AS idLote, abono_marketing AS nombreLote, pci.id_pago_mk id_pago_i, pci.abono_marketing AS comision_total, 0 abono_pagado, pci.pago_mktd pago_neodata 
        FROM pago_comision_mktd pci
        WHERE pci.estatus IN (1)  AND pci.id_usuario = $user ORDER BY pci.abono_marketing DESC");  
    }

    function getInformacionDataMK($var){
        return $this->db->query("SELECT pci.id_pago_mk AS idLote, abono_marketing AS nombreLote, pci.id_pago_mk id_comision, pci.abono_marketing AS abono_neodata, 0 abono_pagado , pci.abono_marketing AS comision_total
        FROM pago_comision_mktd pci
        WHERE pci.estatus IN (1)  AND pci.id_pago_mk = $var ORDER BY pci.abono_marketing DESC");
    }

    function obtenerIDMK($id){
        return $this->db->query("SELECT id_pago_mk id_comision, id_list, empresa FROM pago_comision_mktd WHERE id_pago_mk=$id");
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
        $insert_id = $this->db->insert_id();
        if (! $respuesta ) {
            return 0;
        } else {
            return 1;
        }
    } 

    function update_mktd_INTMEX($idsol) {
        return $this->db->query("UPDATE pago_comision_mktd SET estatus = 11 WHERE estatus = 8");
    }

    function getDatosEnviadasInternomex($proyecto, $condominio, $formaPago) {
        $formaPagoWhereClause = '';
        if ($formaPago != '0')
            $formaPagoWhereClause = "AND oxcfp.id_opcion = $formaPago";
        if($condominio == 0) {
            $whereProyecto = "AND re.idResidencial = $proyecto";
            $whereCondominio = "";
        } else {
            $whereProyecto = "";
            $whereCondominio = "AND co.idCondominio = $condominio";
        }
    
        return $this->db->query("SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote AS lote, re.nombreResidencial AS proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, 
        pci1.estatus, pci1.fecha_pago_intmex fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario ,pci1.id_usuario, CASE WHEN cl.estructura = 1 THEN oprol2.nombre ELSE oprol.nombre END AS puesto, 
        cl.personalidad_juridica, u.forma_pago, 0 AS factura, pac.porcentaje_abono, oxcest.nombre AS estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, cl.lugar_prospeccion, co.nombre AS condominio, lo.referencia,
        (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, 
        (CASE u.forma_pago WHEN 3 THEN (((sed.impuesto)/100)*pci1.abono_neodata) ELSE 0 END) dcto, sed.impuesto valimpuesto, oxcfp.nombre AS regimen
        FROM pago_comision_ind pci1 
        INNER JOIN comisiones com ON pci1.id_comision = com.id_comision AND com.estatus IN (1,8)
        INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio $whereCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial $whereProyecto
        INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 1
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago IN (2, 3, 4)
        INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
        INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
        INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
        INNER JOIN opcs_x_cats oxcfp ON oxcfp.id_opcion = u.forma_pago AND oxcfp.id_catalogo = 16
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
        LEFT JOIN opcs_x_cats oprol2 ON oprol2.id_opcion = com.rol_generado AND oprol2.id_catalogo = 83
        WHERE pci1.estatus IN (8,88) $formaPagoWhereClause
        GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex, pci1.id_usuario, 
        cl.personalidad_juridica, u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, cl.lugar_prospeccion, co.nombre, 
        lo.referencia, sed.impuesto, oxcfp.nombre, cl.estructura, oprol2.nombre ORDER BY lo.nombreLote");
    }
    public function getCondominioDesc($residencial)
    {
        $query = $this->db->query("SELECT con.idCondominio, con.nombre, res.idResidencial, res.nombreResidencial, CAST(res.descripcion AS NVARCHAR(100)) descripcion   
            FROM residenciales res
            JOIN condominios con ON con.idResidencial = res.idResidencial
            WHERE con.status in(1) AND con.idResidencial =" . $residencial . " ORDER BY con.nombre");
        return $query->result();
    }

function getDatosGralInternomex(){ 
        return $this->db->query("SELECT pci1.id_pago_i, re.nombreResidencial AS proyecto, co.nombre AS condominio, lo.nombreLote AS lote, lo.referencia, lo.totalNeto2 precio_lote, re.empresa, pci1.abono_neodata pago_cliente, 
        (CASE u.forma_pago WHEN 3 THEN sed.impuesto ELSE 0 END) valimpuesto, 
        (CASE u.forma_pago WHEN 3 THEN (((sed.impuesto)/100)*pci1.abono_neodata) ELSE 0 END) dcto, (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, 
        CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario, CASE WHEN cl.estructura = 1 THEN oprol2.nombre ELSE oprol.nombre END AS puesto, pci1.fecha_pago_intmex, oxcfp.nombre forma_pago, sed.nombre, (CASE u.estatus WHEN 0 THEN 'BAJA' ELSE 'ACTIVO' END) estatus_usuario, u.rfc 
        FROM pago_comision_ind pci1 
        INNER JOIN comisiones com ON pci1.id_comision = com.id_comision AND com.estatus IN (1,8)
        INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status IN (0,1) 
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial 
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago IN (2,3,4)
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
        INNER JOIN opcs_x_cats oxcfp ON oxcfp.id_opcion =  u.forma_pago AND oxcfp.id_catalogo = 16 
        LEFT JOIN clientes cl ON cl.id_cliente = lo.idCliente
        LEFT JOIN opcs_x_cats oprol2 ON oprol2.id_opcion = com.rol_generado AND oprol2.id_catalogo = 83
        WHERE pci1.estatus IN (8)
        GROUP BY pci1.id_comision, pci1.id_pago_i, re.nombreResidencial, 
        co.nombre, lo.nombreLote, lo.referencia, lo.totalNeto2, re.empresa, 
        pci1.abono_neodata, sed.impuesto, u.nombre, u.apellido_paterno, u.apellido_materno, 
        oprol.nombre, pci1.fecha_pago_intmex, oxcfp.nombre, u.forma_pago, sed.nombre, u.estatus, 
        u.rfc, cl.estructura, oprol2.nombre");
    }



}