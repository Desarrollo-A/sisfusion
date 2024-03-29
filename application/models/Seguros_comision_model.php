<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Seguros_comision_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    //asimilados

    function getDatosNuevasAsimiladosSeguros($proyecto, $condominio){

        if( $this->session->userdata('id_rol') == 31) { // INTERNOMEX
            $filtro = "pci2.estatus IN (8, 88) AND com.id_usuario = $condominio";
            $whereFiltro = "";
                            
        }
        else { // CONTRALORÍA

            $filtro = "pci2.estatus IN (4)";

            if($condominio == 0)
                $whereFiltro = "AND co.idResidencial  = $proyecto";
            else
                $whereFiltro = "AND co.idCondominio  = $condominio";       
        }

        $cmd = "SELECT pci2.id_pago_i, pci2.id_comision, lo.nombreLote lote  ,oxcest.nombre  estatus_actual,
        re.nombreResidencial AS proyecto, lo.totalNeto2 precio_lote, 
        com.comision_total, com.porcentaje_decimal, 
        pci2.abono_neodata solicitado, pci2.pago_neodata pago_cliente, 
        (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci2.abono_neodata) ELSE pci2.abono_neodata END) impuesto, 
        (CASE u.forma_pago WHEN 3 THEN (((sed.impuesto)/100)*pci2.abono_neodata) ELSE 0 END) dcto, sed.impuesto valimpuesto,
        pci2.estatus, CONVERT(VARCHAR,pci2.fecha_pago_intmex,20) AS fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario, pci2.id_usuario, CASE WHEN cl.estructura = 1 THEN oprol2.nombre ELSE oprol.nombre END AS puesto, 0 personalidad_juridica, u.forma_pago, 0 AS factura, 
        pac.porcentaje_abono, oxcest.nombre AS estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, 0 lugar_prospeccion, co.nombre AS condominio, lo.referencia,  u.rfc, (CASE WHEN cl.plan_comision IN (0) OR cl.plan_comision IS NULL THEN '-' ELSE pl.descripcion END) AS plan_descripcion, tv.tipo_venta, CONVERT(VARCHAR,cl.fechaApartado,20) AS fecha_apartado, sed.nombre as sede_nombre, oest.nombre as estatus_usuario, cp.codigo_postal
        FROM pago_seguro_ind pci2 
        INNER JOIN comisiones_seguro com ON pci2.id_comision = com.id_comision AND com.estatus IN (1,8) 
        INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status IN (1,0) 
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio 
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial 
        LEFT JOIN clientes cl ON cl.id_cliente = com.idCliente
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago IN (3)
        INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
        INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
        INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci2.estatus AND oxcest.id_catalogo = 23
        INNER JOIN cp_usuarios cp ON cp.id_usuario = u.id_usuario AND cp.estatus = 1
        LEFT JOIN opcs_x_cats oprol2 ON oprol2.id_opcion = com.rol_generado AND oprol2.id_catalogo = 83
        LEFT JOIN plan_comision pl ON pl.id_plan = cl.plan_comision
        LEFT JOIN tipo_venta tv ON tv.id_tventa = lo.tipo_venta
        LEFT JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 2 WHEN 4 THEN 5
        WHEN 5 THEN 3 WHEN 607 THEN 1 WHEN 7092 THEN 4 WHEN 9629 THEN 2 ELSE u.id_sede END) AND sed.estatus = 1
        LEFT JOIN opcs_x_cats oest ON oest.id_opcion = u.estatus AND oest.id_catalogo = 3
        WHERE $filtro $whereFiltro AND com.id_usuario NOT IN(7689,6019)
        GROUP BY pci2.id_comision, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, 
        com.porcentaje_decimal, pci2.abono_neodata, pci2.pago_neodata, pci2.estatus, pci2.fecha_pago_intmex, 
        pci2.id_usuario, u.forma_pago, pci2.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, 
        oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, co.nombre, lo.referencia, u.rfc, oprol2.nombre, cl.estructura,
        pl.descripcion, cl.plan_comision, tv.tipo_venta, cl.fechaApartado, sed.nombre, oest.nombre, cp.codigo_postal, sed.impuesto";
        $query = $this->db->query($cmd); 
        return $query->result_array();
    } 

    //remanentes

    function getDatosNuevasRemanenteSeguros($proyecto,$condominio){

        if( $this->session->userdata('id_rol') == 31) { // INTERNOMEX
            $filtro = "pci2.estatus IN (8, 88) AND com.id_usuario = $condominio";
            $whereFiltro = "";
        }
        else { // CONTRALORÍA

            $filtro = "pci2.estatus IN (4)";

            if($condominio == 0)
                $whereFiltro = "AND co.idResidencial  = $proyecto";
            else
                $whereFiltro = "AND co.idCondominio  = $condominio";       
        }

            $cmd = "SELECT pci2.id_pago_i, pci2.id_comision, lo.nombreLote lote,oxcest.nombre estatus_actual, re.nombreResidencial AS proyecto, 
            lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci2.abono_neodata solicitado, pci2.pago_neodata pago_cliente, pci2.abono_neodata impuesto, 0 dcto, 0 valimpuesto, pci2.estatus, 
            CONVERT(VARCHAR,pci2.fecha_pago_intmex,20) AS fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario, pci2.id_usuario, CASE WHEN cl.estructura = 1 THEN oprol2.nombre ELSE oprol.nombre END AS puesto,
            0 personalidad_juridica, u.forma_pago, 0 AS factura, pac.porcentaje_abono, oxcest.nombre AS estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, 0 lugar_prospeccion, co.nombre AS condominio, lo.referencia, u.rfc, 
            (CASE WHEN cl.plan_comision IN (0) OR cl.plan_comision IS NULL THEN '-' ELSE pl.descripcion END) AS plan_descripcion,
            CONVERT(VARCHAR,cl.fechaApartado,20) AS fecha_apartado, sed.nombre as sede_nombre, oest.nombre as estatus_usuario, 'NA' AS codigo_postal 
            FROM pago_seguro_ind pci2
            INNER JOIN comisiones_seguro com ON pci2.id_comision = com.id_comision AND com.estatus IN (1,8) 
            INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status IN (1,0) 
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio 
            INNER JOIN residenciales re ON re.idResidencial = co.idResidencial LEFT JOIN clientes cl ON cl.id_cliente = com.idCliente 
            INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago IN (4) 
            INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1 
            INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote 
            INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci2.estatus AND oxcest.id_catalogo = 23 LEFT JOIN opcs_x_cats oprol2 ON oprol2.id_opcion = com.rol_generado AND oprol2.id_catalogo = 83 
            LEFT JOIN plan_comision pl ON pl.id_plan = cl.plan_comision 
            LEFT JOIN tipo_venta tv ON tv.id_tventa = lo.tipo_venta 
            LEFT JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 2 WHEN 4 THEN 5 WHEN 5 THEN 3 WHEN 607 THEN 1 WHEN 7092 THEN 4 WHEN 9629 THEN 2 WHEN 13546 THEN 2 ELSE u.id_sede END) AND sed.estatus = 1 
            LEFT JOIN opcs_x_cats oest ON oest.id_opcion = u.estatus AND oest.id_catalogo = 3
            WHERE $filtro $whereFiltro AND com.id_usuario NOT IN(7689,6019)
            GROUP BY pci2.id_comision, 
            lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci2.abono_neodata, pci2.pago_neodata, pci2.estatus, pci2.fecha_pago_intmex, pci2.id_usuario,
            u.forma_pago, pci2.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, co.nombre, lo.referencia, u.rfc, 
            oprol2.nombre, cl.estructura, pl.descripcion, cl.plan_comision, cl.fechaApartado, sed.nombre, oest.nombre";

            $query = $this->db->query($cmd);
            return $query->result_array();
    }

    //facturas

    function getDatosNuevasFacturasSeguros($proyecto,$condominio){

        if( $this->session->userdata('id_rol') == 31) { // INTERNOMEX
            $filtro = "pci2.estatus IN (8, 88) AND com.id_usuario = $condominio";
            $whereFiltro = "";
        }
        else { // CONTRALORÍA

            $filtro = "pci2.estatus IN (4)";

            if($condominio == 0)
                $whereFiltro = "AND co.idResidencial  = $proyecto";
            else
                $whereFiltro = "AND co.idCondominio  = $condominio";       
        }

            $cmd = "SELECT pci2.id_pago_i, pci2.id_comision, lo.nombreLote lote, oxcest.nombre estatus_actual, re.nombreResidencial AS proyecto, lo.totalNeto2 precio_lote, 
            com.comision_total, com.porcentaje_decimal, 
            pci2.abono_neodata solicitado, pci2.pago_neodata pago_cliente, 
            pci2.abono_neodata impuesto, 
            0 dcto, 0 valimpuesto,
            pci2.estatus, CONVERT(VARCHAR,pci2.fecha_pago_intmex,20) AS fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario, pci2.id_usuario, CASE WHEN cl.estructura = 1 THEN oprol2.nombre ELSE oprol.nombre END AS puesto, 0 personalidad_juridica, u.forma_pago, 0 AS factura, pac.porcentaje_abono, oxcest.nombre AS estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, 0 lugar_prospeccion, co.nombre AS condominio, lo.referencia,  u.rfc, (CASE WHEN cl.plan_comision IN (0) OR cl.plan_comision IS NULL THEN '-' ELSE pl.descripcion END) AS plan_descripcion, tv.tipo_venta, CONVERT(VARCHAR,cl.fechaApartado,20) AS fecha_apartado, sed.nombre as sede_nombre, oest.nombre as estatus_usuario, 'NA' AS codigo_postal
            FROM pago_seguro_ind pci2 
            INNER JOIN comisiones_seguro com ON pci2.id_comision = com.id_comision AND com.estatus IN (1,8)
            INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status IN (1,0) 
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio 
            INNER JOIN residenciales re ON re.idResidencial = co.idResidencial 
            LEFT JOIN clientes cl ON cl.id_cliente = com.idCliente
            INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago IN (2)
            INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
            INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
            INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci2.estatus AND oxcest.id_catalogo = 23
            LEFT JOIN opcs_x_cats oprol2 ON oprol2.id_opcion = com.rol_generado AND oprol2.id_catalogo = 83
            LEFT JOIN plan_comision pl ON pl.id_plan = cl.plan_comision
            LEFT JOIN tipo_venta tv ON tv.id_tventa = lo.tipo_venta
            LEFT JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 2 WHEN 4 THEN 5
            WHEN 5 THEN 3 WHEN 607 THEN 1 WHEN 7092 THEN 4 WHEN 9629 THEN 2 ELSE u.id_sede END) AND sed.estatus = 1
            LEFT JOIN opcs_x_cats oest ON oest.id_opcion = u.estatus AND oest.id_catalogo = 3
            WHERE $filtro $whereFiltro AND com.id_usuario NOT IN(7689,6019) 
            GROUP BY pci2.id_comision, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, 
            com.porcentaje_decimal, pci2.abono_neodata, pci2.pago_neodata, pci2.estatus, pci2.fecha_pago_intmex, 
            pci2.id_usuario, u.forma_pago, pci2.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, 
            oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, co.nombre, lo.referencia, u.rfc, oprol2.nombre, cl.estructura,
            com.loteReubicado,com.ooam, pl.descripcion, cl.plan_comision, tv.tipo_venta, cl.fechaApartado, sed.nombre, oest.nombre";

            $query = $this->db->query($cmd);
            return $query->result_array();
    }

    public function update_acepta_contraloria($data , $clave){
        try {
            $id_user_Vl = $this->session->userdata('id_usuario');
            $cmd = "UPDATE pago_seguro_ind SET estatus = 8, modificado_por =  $id_user_Vl  WHERE id_pago_i IN  ($clave) ";
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

    function insert_phc($data){
        $this->db->insert_batch('historial_seguro', $data);
        return true;
    }

    function consultaComisiones ($id_pago_is){
        $cmd = "SELECT id_pago_i FROM pago_seguro_ind WHERE id_pago_i IN ($id_pago_is)";
        $query = $this->db->query($cmd);
        return count($query->result()) > 0 ? $query->result_array() : 0 ; 
    }

    function update_acepta_INTMEX($idsol) {
        return $this->db->query("UPDATE pago_seguro_ind SET estatus = 11, aply_pago_intmex = GETDATE(),modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_i IN (".$idsol.")");
    }

    public function get_lista_usuarios($rol, $forma_pago){
        $cmd = "SELECT id_usuario AS idCondominio, CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) AS nombre FROM usuarios WHERE id_usuario IN (SELECT id_usuario FROM pago_seguro_ind WHERE estatus IN (8,88)) AND id_rol = $rol AND forma_pago = $forma_pago ORDER BY nombre";
        $query = $this->db->query($cmd);
        return $query->result_array();
    }

    public function report_empresa(){
        $cmd = "SELECT SUM(pci.abono_neodata) AS porc_empresa, res.empresa
        FROM pago_seguro_ind pci 
        INNER JOIN comisiones_seguro com  ON com.id_comision = pci.id_comision
        INNER JOIN lotes lo  ON lo.idLote = com.id_lote 
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
        INNER JOIN residenciales res ON res.idResidencial = con.idResidencial 
        WHERE pci.estatus IN (8) GROUP BY res.empresa";
        $query = $this->db->query($cmd);
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
        INNER JOIN comisiones_seguro com ON com.id_lote = lo.idLote AND com.estatus IN (1,8)
        INNER JOIN pago_seguro_ind pci ON pci.id_comision = com.id_comision
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario 
        WHERE pci.estatus IN (8) and u.forma_pago=$forma_p GROUP BY re.idResidencial)");
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
        INNER JOIN comisiones_seguro com ON com.id_lote = lo.idLote AND com.estatus IN (1,8)
        INNER JOIN pago_seguro_ind pci ON pci.id_comision = com.id_comision
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario 
        WHERE pci.estatus IN (8) and u.forma_pago=$formap and re.idResidencial=$id")->result_array();
        
        $ids = $this->db->query("SELECT pci.id_pago_i
        FROM residenciales re
        INNER JOIN condominios co ON re.idResidencial = co.idResidencial
        INNER JOIN lotes lo ON lo.idCondominio = co.idCondominio
        INNER JOIN comisiones_seguro com ON com.id_lote = lo.idLote AND com.estatus IN (1,8)
        INNER JOIN pago_seguro_ind pci ON pci.id_comision = com.id_comision
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario 
        WHERE pci.estatus IN (8) and u.forma_pago=$forma and re.idResidencial=$id")->result_array();
        $datos[0]=$suma;
        $datos[1]=$ids;
        return $datos;
    }

    function update_estatus_pausa($id_pago_i, $obs, $estatus) {
        $id_user_Vl = $this->session->userdata('id_usuario');
        $this->db->query("INSERT INTO  historial_seguro VALUES ($id_pago_i, ".$id_user_Vl.", GETDATE(), 1, 'SE PAUSÓ COMISIÓN, MOTIVO: ".$obs."')");
        return $this->db->query("UPDATE pago_seguro_ind SET estatus = ".$estatus.", comentario = '".$obs."',modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_i IN (".$id_pago_i.")");
    }

    function update_estatus_despausa($id_pago_i, $obs, $estatus) {
        $id_user_Vl = $this->session->userdata('id_usuario');
        $this->db->query("INSERT INTO  historial_seguro VALUES ($id_pago_i, ".$id_user_Vl.", GETDATE(), 1, 'SE ACTIVÓ COMISIÓN, MOTIVO: ".$obs."')");
        return $this->db->query("UPDATE pago_seguro_ind SET estatus = ".$estatus.", comentario = '".$obs."',modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_i IN (".$id_pago_i.")");
    }

    function update_estatus_edit($id_pago_i, $obs) {
        $id_user_Vl = $this->session->userdata('id_usuario');
        $this->db->query("INSERT INTO historial_seguro VALUES ($id_pago_i, $id_user_Vl, GETDATE(), 1, 'ACTUALIZÓ CONTRALORIA CON NUEVO MONTO: ".$obs."')");
        return $this->db->query("UPDATE pago_seguro_ind SET abono_neodata = '".$obs."',modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_i IN (".$id_pago_i.")");
    }
    
    public function registroComisionAsimilados($id_pago){
        $cmd = "SELECT registro_comision FROM lotes l WHERE l.idLote IN (select c.id_lote FROM comisiones c WHERE c.id_comision IN (SELECT p.id_comision FROM pago_seguro_ind p WHERE p.id_pago_i = $id_pago ";
        $query = $this->db->query($cmd);
        return  $query->result_array();
    }


}