<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ooam_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }


    function getDatosNuevasAContraloria($proyecto, $condominio){
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




}// llave fin del modal

