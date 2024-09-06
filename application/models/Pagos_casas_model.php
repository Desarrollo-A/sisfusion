

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pagos_casas_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function update_acepta_contraloria($data , $clave){
        try {
            $id_user_Vl = $this->session->userdata('id_usuario');
            $cmd = "UPDATE pago_casas_ind SET estatus = 8, modificado_por =  $id_user_Vl  WHERE id_pago_i IN  ($clave) ";
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

    public function update_acepta_contraloria_Bono($data , $clave){
        try {
            $id_user_Vl = $this->session->userdata('id_usuario');
            $cmd = "UPDATE pago_comision_bono SET estatus = 8, modificado_por =  $id_user_Vl  WHERE id_pago_bono IN  ($clave) ";
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
        $this->db->insert_batch('historial_comision_casas', $data);
        return true;
    }

    function insert_phc_Bono($data){
        $this->db->insert_batch('historial_casas_bono', $data);
        return true;
    }


    function getDatosNuevasAsimiladosSeguros($proyecto, $condominio){

        if( $this->session->userdata('id_rol') == 31) { // INTERNOMEX
            $filtro = "pci2.estatus IN (8,88) AND com.id_usuario = $condominio"; 
            $whereFiltro = "";
                            
        }
        else { // CONTRALORÍA

            $filtro = "pci2.estatus IN (4,6)";

            if($condominio == 0)
                $whereFiltro = "AND co.idResidencial  = $proyecto";
            else
                $whereFiltro = "AND co.idCondominio  = $condominio";       
        }

        $cmd = "SELECT pci2.id_pago_i, pci2.id_comision, lo.nombreLote lote  ,oxcest.nombre  estatus_actual,
        re.nombreResidencial AS proyecto, cl.costo_construccion precio_lote, 
        com.comision_total, com.porcentaje_decimal, 
        pci2.abono_neodata solicitado, pci2.pago_neodata pago_cliente, 
        (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci2.abono_neodata) ELSE pci2.abono_neodata END) impuesto, 
        (CASE u.forma_pago WHEN 3 THEN (((sed.impuesto)/100)*pci2.abono_neodata) ELSE 0 END) dcto, sed.impuesto valimpuesto,
        pci2.estatus, CONVERT(VARCHAR,pci2.fecha_pago_intmex,20) AS fecha_creacion, 
        CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario,
        pci2.id_usuario, CASE WHEN cl.estructura = 1 THEN oprol2.nombre ELSE oprol.nombre END AS puesto, 0 personalidad_juridica, 
        u.forma_pago, 0 AS factura, 
        pac.porcentaje_abono, oxcest.nombre AS estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, 0 lugar_prospeccion, 
        co.nombre AS condominio, lo.referencia,  u.rfc, 
        (CASE WHEN cl.plan_comision_c IN (0) OR cl.plan_comision_c IS NULL THEN '-' ELSE pl.descripcion END) AS plan_descripcion, 
        tv.tipo_venta, CONVERT(VARCHAR,cl.fechaApartado,20) AS fecha_apartado, sed.nombre as sede_nombre, oest.nombre as estatus_usuario, cp.codigo_postal
        FROM pago_casas_ind pci2 
        INNER JOIN comisiones_casas com ON pci2.id_comision = com.id_comision AND com.estatus IN (1,8) 
        INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status IN (1,0) 
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio 
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial 
        LEFT JOIN clientes cl ON cl.id_cliente = com.idCliente
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago IN (3)
        INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
        INNER JOIN pago_comision_casas pac ON pac.id_lote = com.id_lote
        INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci2.estatus AND oxcest.id_catalogo = 23
        INNER JOIN cp_usuarios cp ON cp.id_usuario = u.id_usuario AND cp.estatus = 1
        LEFT JOIN opcs_x_cats oprol2 ON oprol2.id_opcion = com.rol_generado AND oprol2.id_catalogo = 83
        LEFT JOIN plan_comision pl ON pl.id_plan = cl.plan_comision_c
        LEFT JOIN tipo_venta tv ON tv.id_tventa = lo.tipo_venta
        LEFT JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 2 WHEN 4 THEN 5
        WHEN 5 THEN 3 WHEN 607 THEN 1 WHEN 7092 THEN 4 WHEN 9629 THEN 2 ELSE u.id_sede END) AND sed.estatus = 1
        LEFT JOIN opcs_x_cats oest ON oest.id_opcion = u.estatus AND oest.id_catalogo = 3
        WHERE $filtro $whereFiltro AND com.id_usuario NOT IN(7689,6019)
        GROUP BY pci2.id_comision, lo.nombreLote, re.nombreResidencial, cl.costo_construccion, com.comision_total, 
        com.porcentaje_decimal, pci2.abono_neodata, pci2.pago_neodata, pci2.estatus, pci2.fecha_pago_intmex, 
        pci2.id_usuario, u.forma_pago, pci2.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, 
        oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, co.nombre, lo.referencia, u.rfc, oprol2.nombre, cl.estructura,
        pl.descripcion, cl.plan_comision_c, tv.tipo_venta, cl.fechaApartado, sed.nombre, oest.nombre, cp.codigo_postal, sed.impuesto";
        $query = $this->db->query($cmd); 
        return $query->result_array();
    } 

    function update_estatus_pausaM($id_pago_i, $obs) {
        $id_user_Vl = $this->session->userdata('id_usuario');
        $this->db->query("INSERT INTO  historial_comision_casas VALUES ($id_pago_i, $id_user_Vl, GETDATE(), 1, 'SE PAUSÓ COMISIÓN, MOTIVO: ".$obs."')");
        $respuesta =  $this->db->query("UPDATE pago_casas_ind SET estatus = 6, comentario = '".$obs."',modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_i IN (".$id_pago_i.")");
        $row = $this->db->query("SELECT uuid FROM factura_casas WHERE id_comision = ".$id_pago_i.";")->result_array();
        
        if(count($row) > 0){
            $datos =  $this->db->query("select id_factura,total,id_comision,bandera FROM factura_casas WHERE uuid='".$row[0]['uuid']."'")->result_array();
    
            for ($i=0; $i <count($datos); $i++) {
                if($datos[$i]['bandera'] == 1){
                    $respuesta = 1;
                }else{
                    $comentario = 'Se regresó esta factura que correspondo al pago con id '.$datos[$i]['id_comision'].' con el monto global de '.$datos[$i]['total'].' por motivo de: '.$obs.' ';
                    $response = $this->db->query("UPDATE factura_casas set total=0,id_comision=0,bandera=1,descripcion='$comentario'  WHERE id_factura=".$datos[$i]['id_factura']."");
                    $respuesta = $this->db->query("INSERT INTO  historial_comision_casas VALUES (".$datos[$i]['id_comision'].", ".$this->session->userdata('id_usuario').", GETDATE(), 1, '".$comentario."')");
                }
            }
        }
        return $respuesta;
    }


    function getDatosNuevasFacturasSeguros($proyecto,$condominio){

        if( $this->session->userdata('id_rol') == 31) { // INTERNOMEX
            $filtro = "pci2.estatus IN (8,88) AND com.id_usuario = $condominio"; 
            $whereFiltro = "";
        }
        else { // CONTRALORÍA

            $filtro = "pci2.estatus IN (4,6)";

            if($condominio == 0)
                $whereFiltro = "AND co.idResidencial  = $proyecto";
            else
                $whereFiltro = "AND co.idCondominio  = $condominio";       
        }

            $cmd = "SELECT pci2.id_pago_i, pci2.id_comision, lo.nombreLote lote,
            oxcest.nombre estatus_actual, re.nombreResidencial AS proyecto, cl.costo_construccion precio_lote, 
            com.comision_total, com.porcentaje_decimal, 
            pci2.abono_neodata solicitado, pci2.pago_neodata pago_cliente, 
            pci2.abono_neodata impuesto, 
            0 dcto, 0 valimpuesto,
            pci2.estatus, CONVERT(VARCHAR,pci2.fecha_pago_intmex,20) AS fecha_creacion, 
            CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario, pci2.id_usuario, 
            CASE WHEN cl.estructura = 1 THEN oprol2.nombre ELSE oprol.nombre END AS puesto, 0 personalidad_juridica, u.forma_pago, 0 AS factura,
            pac.porcentaje_abono, oxcest.nombre AS estatus_actual, oxcest.id_opcion id_estatus_actual, 
            re.empresa, 0 lugar_prospeccion, co.nombre AS condominio, lo.referencia,  u.rfc, 
            (CASE WHEN cl.plan_comision_c IN (0) OR cl.plan_comision_c IS NULL THEN '-' ELSE pl.descripcion END) AS plan_descripcion, tv.tipo_venta, 
            CONVERT(VARCHAR,cl.fechaApartado,20) AS fecha_apartado, sed.nombre as sede_nombre, oest.nombre as estatus_usuario, 'NA' AS codigo_postal
            FROM pago_casas_ind pci2 
            INNER JOIN comisiones_casas com ON pci2.id_comision = com.id_comision AND com.estatus IN (1,8)
            INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status IN (1,0) 
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio 
            INNER JOIN residenciales re ON re.idResidencial = co.idResidencial 
            LEFT JOIN clientes cl ON cl.id_cliente = com.idCliente
            INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago IN (2)
            INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
            INNER JOIN pago_comision_casas pac ON pac.id_lote = com.id_lote
            INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci2.estatus AND oxcest.id_catalogo = 23
            LEFT JOIN opcs_x_cats oprol2 ON oprol2.id_opcion = com.rol_generado AND oprol2.id_catalogo = 83
            LEFT JOIN plan_comision pl ON pl.id_plan = cl.plan_comision_c
            LEFT JOIN tipo_venta tv ON tv.id_tventa = lo.tipo_venta
            LEFT JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 2 WHEN 4 THEN 5
            WHEN 5 THEN 3 WHEN 607 THEN 1 WHEN 7092 THEN 4 WHEN 9629 THEN 2 ELSE u.id_sede END) AND sed.estatus = 1
            LEFT JOIN opcs_x_cats oest ON oest.id_opcion = u.estatus AND oest.id_catalogo = 3
            WHERE $filtro $whereFiltro AND com.id_usuario NOT IN(7689,6019) 
            GROUP BY pci2.id_comision, lo.nombreLote, re.nombreResidencial, cl.costo_construccion, com.comision_total, 
            com.porcentaje_decimal, pci2.abono_neodata, pci2.pago_neodata, pci2.estatus, pci2.fecha_pago_intmex, 
            pci2.id_usuario, u.forma_pago, pci2.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, 
            oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, co.nombre, lo.referencia, u.rfc, oprol2.nombre, cl.estructura,
            pl.descripcion, cl.plan_comision_c, tv.tipo_venta, cl.fechaApartado, sed.nombre, oest.nombre";

            $query = $this->db->query($cmd);
            return $query->result_array();
    }

    function getDatosNuevasRemanenteSeguros($proyecto,$condominio){

        if( $this->session->userdata('id_rol') == 31) { // INTERNOMEX
            $filtro = "pci2.estatus IN (8, 88) AND com.id_usuario = $condominio";
            $whereFiltro = "";
        }
        else { // CONTRALORÍA

            $filtro = "pci2.estatus IN (4,6)";

            if($condominio == 0)
                $whereFiltro = "AND co.idResidencial  = $proyecto";
            else
                $whereFiltro = "AND co.idCondominio  = $condominio";       
        }

            $cmd = "SELECT pci2.id_pago_i, pci2.id_comision, lo.nombreLote lote,oxcest.nombre estatus_actual, 
            re.nombreResidencial AS proyecto, 
            cl.costo_construccion precio_lote, com.comision_total, com.porcentaje_decimal, pci2.abono_neodata solicitado, 
            pci2.pago_neodata pago_cliente, pci2.abono_neodata impuesto, 0 dcto, 0 valimpuesto, pci2.estatus, 
            CONVERT(VARCHAR,pci2.fecha_pago_intmex,20) AS fecha_creacion, 
            CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario, pci2.id_usuario, 
            CASE WHEN cl.estructura = 1 THEN oprol2.nombre ELSE oprol.nombre END AS puesto,
            0 personalidad_juridica, u.forma_pago, 0 AS factura, pac.porcentaje_abono, oxcest.nombre AS estatus_actual, 
            oxcest.id_opcion id_estatus_actual, re.empresa, 0 lugar_prospeccion, co.nombre AS condominio, lo.referencia, u.rfc, 
            (CASE WHEN cl.plan_comision_c IN (0) OR cl.plan_comision_c IS NULL THEN '-' ELSE pl.descripcion END) AS plan_descripcion,
            CONVERT(VARCHAR,cl.fechaApartado,20) AS fecha_apartado, sed.nombre as sede_nombre, oest.nombre as estatus_usuario, 'NA' AS codigo_postal 
            FROM pago_casas_ind pci2
            INNER JOIN comisiones_casas com ON pci2.id_comision = com.id_comision AND com.estatus IN (1,8) 
            INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status IN (1,0) 
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio 
            INNER JOIN residenciales re ON re.idResidencial = co.idResidencial LEFT JOIN clientes cl ON cl.id_cliente = com.idCliente 
            INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago IN (4) ----------------------
            INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1 
            INNER JOIN pago_comision_casas pac ON pac.id_lote = com.id_lote 
            INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci2.estatus AND oxcest.id_catalogo = 23 LEFT JOIN opcs_x_cats oprol2 ON oprol2.id_opcion = com.rol_generado AND oprol2.id_catalogo = 83 
            LEFT JOIN plan_comision pl ON pl.id_plan = cl.plan_comision_c 
            LEFT JOIN tipo_venta tv ON tv.id_tventa = lo.tipo_venta 
            LEFT JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 2 WHEN 4 THEN 5 WHEN 5 THEN 3 WHEN 607 THEN 1 WHEN 7092 THEN 4 WHEN 9629 THEN 2 WHEN 13546 THEN 2 ELSE u.id_sede END) AND sed.estatus = 1 
            LEFT JOIN opcs_x_cats oest ON oest.id_opcion = u.estatus AND oest.id_catalogo = 3
            WHERE $filtro $whereFiltro AND com.id_usuario NOT IN(7689,6019)
            GROUP BY pci2.id_comision, 
            lo.nombreLote, re.nombreResidencial, cl.costo_construccion, com.comision_total, com.porcentaje_decimal, pci2.abono_neodata, pci2.pago_neodata, pci2.estatus, pci2.fecha_pago_intmex, pci2.id_usuario,
            u.forma_pago, pci2.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, co.nombre, lo.referencia, u.rfc, 
            oprol2.nombre, cl.estructura, pl.descripcion, cl.plan_comision_c, cl.fechaApartado, sed.nombre, oest.nombre";

            $query = $this->db->query($cmd);
            return $query->result_array();
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
                $filtro02 = $filtro.' AND  fa.id_usuario = '.$user_data .' ';
            break;
            default:
                $filtro02 = $filtro.' ';
            break;
        }
        
        if($condominio == 0){
            return $this->db->query("SELECT SUM(pci1.abono_neodata) total, re.idResidencial, re.nombreResidencial AS proyecto, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario, pci1.id_usuario, u.forma_pago, 0 AS factura, oxcest.id_opcion id_estatus_actual, re.empresa, opn.estatus estatus_opinion, opn.archivo_name, fa.uuid,fa.nombre_archivo AS xmla,fa.bandera, u.rfc
            FROM pago_casas_ind pci1 
            INNER JOIN comisiones_casas com ON pci1.id_comision = com.id_comision AND com.estatus IN (1,8)
            INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
            INNER JOIN residenciales re ON re.idResidencial = co.idResidencial AND re.idResidencial = $proyecto
            INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago IN (2)
            INNER JOIN pago_comision_casas pac ON pac.id_lote = com.id_lote
            INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
            INNER JOIN opinion_cumplimiento opn ON opn.id_usuario = u.id_usuario and opn.estatus IN (2) 
            INNER JOIN factura_casas fa ON fa.id_comision = pci1.id_pago_i
            $filtro02 
            GROUP BY re.idResidencial, re.nombreResidencial, u.nombre, u.apellido_paterno, u.apellido_materno, pci1.id_usuario, u.forma_pago, oxcest.id_opcion, re.empresa, re.idResidencial, opn.estatus, opn.archivo_name, fa.uuid, fa.nombre_archivo, fa.bandera, u.rfc
            ORDER BY u.nombre");
        }
        else{
            return $this->db->query("SELECT SUM(pci1.abono_neodata) total, re.idResidencial, re.nombreResidencial AS proyecto, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario, pci1.id_usuario, u.forma_pago, 0 AS factura, oxcest.id_opcion id_estatus_actual, re.empresa, opn.estatus estatus_opinion, opn.archivo_name, fa.uuid,fa.nombre_archivo AS xmla,fa.bandera , u.rfc
            FROM pago_casas_ind pci1 
            INNER JOIN comisiones_casas com ON pci1.id_comision = com.id_comision AND com.estatus IN (1,8)
            INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
            INNER JOIN condominios co ON co.idCondominio = lo.idCondominio 
            INNER JOIN residenciales re ON re.idResidencial = co.idResidencial AND re.idResidencial = $proyecto
            INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago IN (2)
            INNER JOIN pago_comision_casas pac ON pac.id_lote = com.id_lote
            INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
            INNER JOIN opinion_cumplimiento opn ON opn.id_usuario = u.id_usuario and opn.estatus IN (2) 
            INNER JOIN factura_casas fa ON fa.id_comision = pci1.id_pago_i
            $filtro02 AND co.idCondominio = $condominio
            GROUP BY re.idResidencial, re.nombreResidencial, u.nombre, u.apellido_paterno, u.apellido_materno, pci1.id_usuario, u.forma_pago, oxcest.id_opcion, re.empresa, re.idResidencial, opn.estatus, opn.archivo_name, fa.uuid,fa.nombre_archivo,fa.bandera, u.rfc
            ORDER BY u.nombre");
        }
    }

    public function report_empresa(){
        $cmd = "SELECT SUM(pci.abono_neodata) AS porc_empresa, res.empresa
        FROM pago_casas_ind pci 
        INNER JOIN comisiones_casas com  ON com.id_comision = pci.id_comision
        INNER JOIN lotes lo  ON lo.idLote = com.id_lote 
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
        INNER JOIN residenciales res ON res.idResidencial = con.idResidencial 
        WHERE pci.estatus IN (8,88) GROUP BY res.empresa"; // se agrega 88 para traer los pausados
        $query = $this->db->query($cmd);
        return $query->result_array();
    }

    function factura_comision( $uuid, $id_res){
        return $this->db->query("SELECT DISTINCT CAST(uuid AS VARCHAR(MAX)) AS uuid ,
        u.nombre, u.apellido_paterno, u.apellido_materno, res.nombreResidencial AS nombreLote, f.fecha_factura, f.folio_factura, f.metodo_pago, f.regimen, f.forma_pago, f.cfdi, f.unidad, f.claveProd, f.total, f.total AS porcentaje_dinero, f.nombre_archivo, CAST(f.descripcion AS VARCHAR(MAX)) AS descrip,f.fecha_ingreso
        FROM factura_casas f 
        INNER JOIN usuarios u ON u.id_usuario = f.id_usuario
        INNER JOIN pago_casas_ind pci ON pci.id_pago_i = f.id_comision
        INNER JOIN comisiones_casas com ON com.id_comision = pci.id_comision
        INNER JOIN lotes l ON l.idLote = com.id_lote
        INNER JOIN condominios con ON con.idCondominio = l.idCondominio
        INNER JOIN residenciales res ON res.idResidencial = con.idResidencial and res.idResidencial = $id_res
        WHERE /*MONTH(f.fecha_ingreso) >= 4 AND*/ f.uuid = '".$uuid."' ");
    }
    
    public function get_lista_usuarios($rol, $forma_pago){
        $cmd = "SELECT id_usuario AS idCondominio, 
                CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) AS nombre 
                FROM usuarios 
                WHERE id_usuario IN (SELECT id_usuario FROM pago_casas_ind 
                WHERE estatus IN (8,88)) AND id_rol = $rol AND forma_pago = $forma_pago 
                ORDER BY nombre";
        $query = $this->db->query($cmd);
        return $query->result_array();
    }

    function update_acepta_INTMEX($idsol) {
        return $this->db->query("UPDATE pago_casas_ind SET estatus = 11, aply_pago_intmex = GETDATE(),modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_i IN (".$idsol.")");
    }

    function consultaComisiones ($id_pago_is){
        $cmd = "SELECT id_pago_i FROM pago_casas_ind WHERE id_pago_i IN ($id_pago_is)";
        $query = $this->db->query($cmd);

        $resultado = count($query->result()) > 0 ? $query->result_array() : 0 ;
        return $resultado;
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
        INNER JOIN comisiones_casas com ON com.id_lote = lo.idLote AND com.estatus IN (1,8)
        INNER JOIN pago_casas_ind pci ON pci.id_comision = com.id_comision
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario 
        WHERE pci.estatus IN (8) and u.forma_pago=$formap and re.idResidencial=$id")->result_array();
        
        $ids = $this->db->query("SELECT pci.id_pago_i
        FROM residenciales re
        INNER JOIN condominios co ON re.idResidencial = co.idResidencial
        INNER JOIN lotes lo ON lo.idCondominio = co.idCondominio
        INNER JOIN comisiones_casas com ON com.id_lote = lo.idLote AND com.estatus IN (1,8)
        INNER JOIN pago_casas_ind pci ON pci.id_comision = com.id_comision
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario 
        WHERE pci.estatus IN (8) and u.forma_pago=$forma and re.idResidencial=$id")->result_array();
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
        return $this->db->query("SELECT res.idResidencial id_usuario, res.descripcion  AS name_user
        FROM residenciales res WHERE res.idResidencial IN (SELECT re.idResidencial
        FROM residenciales re
        INNER JOIN condominios co ON re.idResidencial = co.idResidencial
        INNER JOIN lotes lo ON lo.idCondominio = co.idCondominio
        INNER JOIN comisiones_casas com ON com.id_lote = lo.idLote AND com.estatus IN (1,8)
        INNER JOIN pago_casas_ind pci ON pci.id_comision = com.id_comision
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario 
        WHERE pci.estatus IN (8) and u.forma_pago=$forma_p GROUP BY re.idResidencial)");
    }


    function update_estatus_despausa($id_pago_i, $obs, $estatus) {
        $id_user_Vl = $this->session->userdata('id_usuario');
        $this->db->query("INSERT INTO  historial_comision_casas VALUES ($id_pago_i, ".$id_user_Vl.", GETDATE(), 1, 'SE ACTIVÓ COMISIÓN, MOTIVO: ".$obs."')");
        return $this->db->query("UPDATE pago_casas_ind SET estatus = ".$estatus.", comentario = '".$obs."',modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_i IN (".$id_pago_i.")");
    }




    public function registroComisionAsimilados($id_pago){
        $cmd = "SELECT registro_comision FROM lotes l WHERE l.idLote IN (select c.id_lote FROM comisiones_casas c WHERE c.id_comision IN (SELECT p.id_comision FROM pago_casas_ind p WHERE p.id_pago_i = $id_pago ";
        $query = $this->db->query($cmd);
        return  $query->result_array();
    }

    function update_estatus_edit($id_pago_i, $obs) {
        $id_user_Vl = $this->session->userdata('id_usuario');
        $this->db->query("INSERT INTO historial_comision_casas VALUES ($id_pago_i, $id_user_Vl, GETDATE(), 1, 'ACTUALIZÓ CONTRALORIA CON NUEVO MONTO: ".$obs."')");
        return $this->db->query("UPDATE pago_casas_ind SET abono_neodata = '".$obs."',modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_i IN (".$id_pago_i.")");
    }
    

    function update_estatus_refresh($idcom) {
        $id_user_Vl = $this->session->userdata('id_usuario');
        $this->db->query("INSERT INTO  historial_comision_casas VALUES ($idcom, $id_user_Vl, GETDATE(), 1, 'SE ACTIVÓ NUEVAMENTE COMISIÓN')");
        return $this->db->query("UPDATE pago_casas_ind SET estatus = 4,modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_i IN (".$idcom.")");
    } 



    function update_estatus_pausa($id_pago_i, $obs, $estatus) {
        $id_user_Vl = $this->session->userdata('id_usuario');
        $this->db->query("INSERT INTO  historial_comision_casas VALUES ($id_pago_i, ".$id_user_Vl.", GETDATE(), 1, 'SE PAUSÓ COMISIÓN, MOTIVO: ".$obs."')");
        return $this->db->query("UPDATE pago_casas_ind SET estatus = ".$estatus.", comentario = '".$obs."',modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_i IN (".$id_pago_i.")");
    }

    function getComments($pago){
        $cmd = "SELECT DISTINCT(hc.comentario), hc.id_pago_i, hc.id_usuario, convert(nvarchar(20), hc.fecha_movimiento, 113) date_final, hc.fecha_movimiento, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre_usuario
        FROM historial_comision_casas hc 
        INNER JOIN pago_casas_ind pci ON pci.id_pago_i = hc.id_pago_i
        INNER JOIN usuarios u ON u.id_usuario = hc.id_usuario 
        WHERE hc.id_pago_i = $pago
        ORDER BY hc.fecha_movimiento DESC";
        $query = $this->db->query($cmd);
        return $query->result();
    }

    function getCommentsBono($pago){
        $cmd = "SELECT hc.comentario, hc.id_pago_i, hc.id_usuario, convert(nvarchar(20), hc.fecha_movimiento, 113) date_final, hc.fecha_movimiento, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre_usuario
        FROM historial_casas_bono hc 
        INNER JOIN pago_comision_bono pcb ON pcb.id_pago_bono = hc.id_pago_i
        INNER JOIN usuarios u ON u.id_usuario = hc.id_usuario 
        WHERE hc.id_pago_i = $pago
        ORDER BY hc.fecha_movimiento DESC";
        $query = $this->db->query($cmd);
        return $query->result();
    }

    public function get_solicitudes_factura( $idResidencial, $id_usuario ){
        if( $this->session->userdata('id_rol') == 31 ){
            $filtro = "WHERE pci1.estatus IN (8,88) ";
        } else{
            $filtro = "WHERE pci1.estatus IN (4) ";
        }
        
        return $this->db->query("SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote AS lote, re.nombreResidencial AS proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata,  pci1.estatus, pci1.fecha_pago_intmex fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario ,pci1.id_usuario, oprol.nombre AS puesto, cl.personalidad_juridica, u.forma_pago, 0 AS factura, pac.porcentaje_abono, oxcest.nombre AS estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, cl.lugar_prospeccion, co.nombre AS condominio, lo.referencia
        FROM pago_casas_ind pci1 
        INNER JOIN comisiones_casas com ON pci1.id_comision = com.id_comision AND com.estatus IN (1,8)
        INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial AND re.idResidencial = $idResidencial
        INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 1
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago IN (2)
        INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
        INNER JOIN pago_comision_casas pac ON pac.id_lote = com.id_lote
        INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
        $filtro AND u.id_usuario = $id_usuario
        GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex, pci1.id_usuario, cl.personalidad_juridica, u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, cl.lugar_prospeccion, co.nombre, lo.referencia ORDER BY lo.nombreLote")->result_array();
    }

    function update_acepta_INTMEX_Bono($idsol) {
        return $this->db->query("UPDATE pago_comision_bono SET estatus = 11, fecha_pago_intmex = GETDATE(),modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_bono IN (".$idsol.")");
    }

    function consultaComisionesBono ($id_pago_is){
        $cmd = "SELECT id_pago_bono FROM pago_comision_bono WHERE id_pago_bono IN ($id_pago_is)";
        $query = $this->db->query($cmd);

        $resultado = count($query->result()) > 0 ? $query->result_array() : 0 ;
        return $resultado;
    }
    

    function getDatosRevisionBonos(){
        if( $this->session->userdata('id_rol') == 31 ){
            $filtro = "WHERE pcbo.estatus in (8,88) AND pcbo.abono_bono > 0 ";
        } else{
            $filtro = "WHERE pcbo.estatus in (4,6) AND pcbo.abono_bono > 0 ";
        }
        return $this->db->query("SELECT pcbo.abono_bono , us.id_usuario, CONCAT(us.nombre,' ', us.apellido_paterno, ' ', us.apellido_materno) colaborador, UPPER(sed.nombre) sede, UPPER(oxc.nombre) forma_pago, pcbo.estatus, pcbo.id_pago_bono,
        (CASE us.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pcbo.abono_bono) ELSE pcbo.abono_bono END) impuesto, sed.impuesto valimpuesto ,us.rfc, lo.nombreLote AS lote 
        FROM pago_comision_bono pcbo
        inner join pago_casas_ind coi on coi.id_pago_i = pcbo.id_pago_i 
        inner join comisiones_casas com on com.id_comision = coi.id_comision
        INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
        INNER JOIN usuarios us ON us.id_usuario = pcbo.id_usuario 
        INNER JOIN sedes sed ON sed.id_sede = (CASE WHEN LEN (us.id_sede) > 1 THEN 2 ELSE us.id_sede END)
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = us.forma_pago AND oxc.id_catalogo = 16
        $filtro");
    }

    function getDatosSumaMktd($sede, $PLAN,$empresa, $res){
        return $this->db->query("SELECT SUM (pci.abono_neodata) suma_f01, STRING_AGG(pci.id_pago_i, ', ') AS valor_obtenido, res.empresa, res.nombreResidencial 
        FROM pago_comision_bono pcb
        INNER JOIN pago_casas_ind pci ON pci.id_comision = pci.id_comision
        INNER JOIN lotes lo ON lo.idLote = com.id_lote
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio
        INNER JOIN residenciales res ON res.idResidencial = con.idResidencial
        INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente
        INNER JOIN usuarios us ON us.id_usuario = pci.id_usuario
        WHERE pci.estatus IN (4) AND lo.idLote IN (select id_lote FROM reportes_marketing WHERE estatus = 1 AND dispersion = 1) AND pci.id_usuario = 4394 AND lo.status = 1 AND lo.idLote NOT IN (select id_lote FROM compartidas_mktd) AND cl.status = 1 AND lo.ubicacion_dos IN (".$sede.") AND res.empresa = '".$empresa."' AND res.idResidencial = '".$res."'
        GROUP BY pci.id_usuario, lo.ubicacion_dos, us.nombre, us.apellido_paterno, res.empresa, res.nombreResidencial");
    }

    function update_estatus_pausa_bono($id_pago_i, $obs) {
        $id_user_Vl = $this->session->userdata('id_usuario');
        $this->db->query("INSERT INTO  historial_casas_bono VALUES ($id_pago_i, $id_user_Vl, GETDATE(), 1, 'SE PAUSÓ COMISIÓN, MOTIVO: ".$obs."')");
        $respuesta =  $this->db->query("UPDATE pago_comision_bono SET estatus = 6, comentario = '".$obs."',modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_bono IN (".$id_pago_i.")");
        $row = $this->db->query("SELECT uuid FROM factura_casas WHERE id_comision = ".$id_pago_i.";")->result_array();
        

        // Pausar las comisiones que tengan fatucras
        // if(count($row) > 0){
        //     $datos =  $this->db->query("select id_factura,total,id_comision,bandera FROM factura_casas WHERE uuid='".$row[0]['uuid']."'")->result_array();
    
        //     for ($i=0; $i <count($datos); $i++) {
        //         if($datos[$i]['bandera'] == 1){
        //             $respuesta = 1;
        //         }else{
        //             $comentario = 'Se regresó esta factura que correspondo al pago con id '.$datos[$i]['id_comision'].' con el monto global de '.$datos[$i]['total'].' por motivo de: '.$obs.' ';
        //             $response = $this->db->query("UPDATE factura_casas set total=0,id_comision=0,bandera=1,descripcion='$comentario'  WHERE id_factura=".$datos[$i]['id_factura']."");
        //             $respuesta = $this->db->query("INSERT INTO  historial_comision_casas VALUES (".$datos[$i]['id_comision'].", ".$this->session->userdata('id_usuario').", GETDATE(), 1, '".$comentario."')");
        //         }
        //     }
        // }
        return $respuesta;
    }


    function pausar_Bono($id_pago_i, $obs, $estatus) {
        $id_user_Vl = $this->session->userdata('id_usuario');
        $this->db->query("INSERT INTO  historial_casas_bono VALUES ($id_pago_i, ".$id_user_Vl.", GETDATE(), 1, 'SE PAUSÓ COMISIÓN, MOTIVO: ".$obs."')");
        return $this->db->query("UPDATE pago_comision_bono SET estatus = ".$estatus.", comentario = '".$obs."',modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_bono IN (".$id_pago_i.")");
    }

    function despausar_Bono($id_pago_i, $obs, $estatus) {
        $id_user_Vl = $this->session->userdata('id_usuario');
        $this->db->query("INSERT INTO  historial_casas_bono VALUES ($id_pago_i, ".$id_user_Vl.", GETDATE(), 1, 'SE ACTIVÓ COMISIÓN, MOTIVO: ".$obs."')");
        return $this->db->query("UPDATE pago_comision_bono SET estatus = ".$estatus.", comentario = '".$obs."',modificado_por='".$this->session->userdata('id_usuario')."' WHERE id_pago_bono IN (".$id_pago_i.")");
    }

    
}