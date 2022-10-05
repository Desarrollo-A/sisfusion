<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Internomex_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    

    function getDatosNuevasInternomex($proyecto,$condominio){

        if($condominio == 0){
                return $this->db->query("SELECT pci1.id_pago_i, re.nombreResidencial as proyecto, lo.nombreLote, lo.totalNeto2 precio_lote, pci1.abono_neodata a_pagar, pci1.estatus, pci1.fecha_abono fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) comisionista, oprol.nombre as puesto, u.forma_pago, oxcest.nombre as estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, oxformap.nombre AS regimen 
                 FROM pago_comision_ind pci1 
                 INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                 INNER JOIN lotes lo ON lo.idLote = com.id_lote
                 INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                 INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                 INNER JOIN clientes cl ON cl.idLote = lo.idLote
                 INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
                 INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado
                 INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                 INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus 
                 INNER JOIN opcs_x_cats oxformap ON oxformap.id_opcion = u.forma_pago 
                 WHERE pci1.estatus IN (8) AND re.idResidencial = $proyecto AND oxformap.id_catalogo = 16
                 AND com.estatus in (1) AND oprol.id_catalogo = 1 AND oxcest.id_catalogo = 23 AND lo.status = 1 AND cl.status = 1
                 GROUP BY pci1.id_pago_i, re.nombreResidencial, lo.nombreLote, lo.totalNeto2, pci1.abono_neodata, pci1.estatus, pci1.fecha_abono, u.nombre, u.apellido_paterno, u.apellido_materno, oprol.nombre, u.forma_pago, oxcest.nombre, oxcest.id_opcion, re.empresa, oxformap.nombre
                 ORDER BY lo.nombreLote");
    
            }else{
                return $this->db->query("SELECT pci1.id_pago_i, re.nombreResidencial as proyecto, lo.nombreLote, lo.totalNeto2 precio_lote, pci1.abono_neodata a_pagar, pci1.estatus, pci1.fecha_abono fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) comisionista, oprol.nombre as puesto, u.forma_pago, oxcest.nombre as estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, oxformap.nombre AS regimen 
                 FROM pago_comision_ind pci1 
                 INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                 INNER JOIN lotes lo ON lo.idLote = com.id_lote
                 INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                 INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                 INNER JOIN clientes cl ON cl.idLote = lo.idLote
                 INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
                 INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado
                 INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                 INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus 
                 INNER JOIN opcs_x_cats oxformap ON oxformap.id_opcion = u.forma_pago 
                 WHERE pci1.estatus IN (8) AND co.idCondominio = $condominio AND oxformap.id_catalogo = 16
                 AND com.estatus in (1) AND oprol.id_catalogo = 1 AND oxcest.id_catalogo = 23 AND lo.status = 1 AND cl.status = 1
                 GROUP BY pci1.id_pago_i, re.nombreResidencial, lo.nombreLote, lo.totalNeto2, pci1.abono_neodata, pci1.estatus, pci1.fecha_abono, u.nombre, u.apellido_paterno, u.apellido_materno, oprol.nombre, u.forma_pago, oxcest.nombre, oxcest.id_opcion, re.empresa, oxformap.nombre
                 ORDER BY lo.nombreLote");
         }
        }



             function getDatosAplicadosInternomex($proyecto,$condominio){

        if($condominio == 0){
                return $this->db->query("SELECT pci1.id_pago_i, re.nombreResidencial as proyecto, lo.nombreLote, lo.totalNeto2 precio_lote, pci1.abono_neodata a_pagar, pci1.estatus, pci1.fecha_abono fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) comisionista, oprol.nombre as puesto, u.forma_pago, oxcest.nombre as estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, oxformap.nombre AS regimen 
                 FROM pago_comision_ind pci1 
                 INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                 INNER JOIN lotes lo ON lo.idLote = com.id_lote
                 INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                 INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                 INNER JOIN clientes cl ON cl.idLote = lo.idLote
                 INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
                 INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado
                 INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                 INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus 
                 INNER JOIN opcs_x_cats oxformap ON oxformap.id_opcion = u.forma_pago 
                 WHERE pci1.estatus IN (9) AND re.idResidencial = $proyecto AND oxformap.id_catalogo = 16
                 AND com.estatus in (1) AND oprol.id_catalogo = 1 AND oxcest.id_catalogo = 23 AND lo.status = 1 AND cl.status = 1
                 GROUP BY pci1.id_pago_i, re.nombreResidencial, lo.nombreLote, lo.totalNeto2, pci1.abono_neodata, pci1.estatus, pci1.fecha_abono, u.nombre, u.apellido_paterno, u.apellido_materno, oprol.nombre, u.forma_pago, oxcest.nombre, oxcest.id_opcion, re.empresa, oxformap.nombre
                 ORDER BY lo.nombreLote");
    
            }else{
                return $this->db->query("SELECT pci1.id_pago_i, re.nombreResidencial as proyecto, lo.nombreLote, lo.totalNeto2 precio_lote, pci1.abono_neodata a_pagar, pci1.estatus, pci1.fecha_abono fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) comisionista, oprol.nombre as puesto, u.forma_pago, oxcest.nombre as estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, oxformap.nombre AS regimen 
                 FROM pago_comision_ind pci1 
                 INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                 INNER JOIN lotes lo ON lo.idLote = com.id_lote
                 INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                 INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                 INNER JOIN clientes cl ON cl.idLote = lo.idLote
                 INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
                 INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado
                 INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                 INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus 
                 INNER JOIN opcs_x_cats oxformap ON oxformap.id_opcion = u.forma_pago 
                 WHERE pci1.estatus IN (9) AND co.idCondominio = $condominio AND oxformap.id_catalogo = 16
                 AND com.estatus in (1) AND oprol.id_catalogo = 1 AND oxcest.id_catalogo = 23 AND lo.status = 1 AND cl.status = 1
                 GROUP BY pci1.id_pago_i, re.nombreResidencial, lo.nombreLote, lo.totalNeto2, pci1.abono_neodata, pci1.estatus, pci1.fecha_abono, u.nombre, u.apellido_paterno, u.apellido_materno, oprol.nombre, u.forma_pago, oxcest.nombre, oxcest.id_opcion, re.empresa, oxformap.nombre
                 ORDER BY lo.nombreLote");
         }
        }



        function getDatosHistorialInternomex($proyecto,$condominio){

        if($condominio == 0){
                return $this->db->query("SELECT pci1.id_pago_i, re.nombreResidencial as proyecto, lo.nombreLote, lo.totalNeto2 precio_lote, pci1.abono_neodata a_pagar, pci1.estatus, pci1.fecha_abono fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) comisionista, oprol.nombre as puesto, u.forma_pago, oxcest.nombre as estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, oxformap.nombre AS regimen 
                 FROM pago_comision_ind pci1 
                 INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                 INNER JOIN lotes lo ON lo.idLote = com.id_lote
                 INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                 INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                 INNER JOIN clientes cl ON cl.idLote = lo.idLote
                 INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
                 INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado
                 INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                 INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus 
                 INNER JOIN opcs_x_cats oxformap ON oxformap.id_opcion = u.forma_pago 
                 WHERE pci1.estatus IN (8,9,10,11) AND pci1.descuento_aplicado = 0  AND re.idResidencial = $proyecto AND oxformap.id_catalogo = 16
                 AND com.estatus in (1) AND oprol.id_catalogo = 1 AND oxcest.id_catalogo = 23 AND lo.status = 1 AND cl.status = 1
                 GROUP BY pci1.id_pago_i, re.nombreResidencial, lo.nombreLote, lo.totalNeto2, pci1.abono_neodata, pci1.estatus, pci1.fecha_abono, u.nombre, u.apellido_paterno, u.apellido_materno, oprol.nombre, u.forma_pago, oxcest.nombre, oxcest.id_opcion, re.empresa, oxformap.nombre
                 ORDER BY lo.nombreLote");
    
            }else{
                return $this->db->query("SELECT pci1.id_pago_i, re.nombreResidencial as proyecto, lo.nombreLote, lo.totalNeto2 precio_lote, pci1.abono_neodata a_pagar, pci1.estatus, pci1.fecha_abono fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) comisionista, oprol.nombre as puesto, u.forma_pago, oxcest.nombre as estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, oxformap.nombre AS regimen 
                 FROM pago_comision_ind pci1 
                 INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                 INNER JOIN lotes lo ON lo.idLote = com.id_lote
                 INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                 INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                 INNER JOIN clientes cl ON cl.idLote = lo.idLote
                 INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
                 INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado
                 INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                 INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus 
                 INNER JOIN opcs_x_cats oxformap ON oxformap.id_opcion = u.forma_pago 
                 WHERE pci1.estatus IN (8,9,10,11) AND pci1.descuento_aplicado = 0 AND co.idCondominio = $condominio AND oxformap.id_catalogo = 16
                 AND com.estatus in (1) AND oprol.id_catalogo = 1 AND oxcest.id_catalogo = 23 AND lo.status = 1 AND cl.status = 1
                 GROUP BY pci1.id_pago_i, re.nombreResidencial, lo.nombreLote, lo.totalNeto2, pci1.abono_neodata, pci1.estatus, pci1.fecha_abono, u.nombre, u.apellido_paterno, u.apellido_materno, oprol.nombre, u.forma_pago, oxcest.nombre, oxcest.id_opcion, re.empresa, oxformap.nombre
                 ORDER BY lo.nombreLote");
         }
        }


        function update_aplica_intemex($idsol) {
            $this->db->query("INSERT INTO historial_comisiones VALUES ($idsol, ".$this->session->userdata('id_usuario').", GETDATE(), 1, 'SE APLICÓ PAGO DE INTERNOMEX')");
            return $this->db->query("UPDATE pago_comision_ind SET estatus = 9 WHERE id_pago_i IN (".$idsol.")");
    }

    public function getCommissions()
    {
        return $this->db->query("SELECT u0.id_usuario, UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) nombreUsuario, 
        se.nombre sede, oxc0.nombre tipoUsuario, oxc2.nombre formaPago, u0.rfc,oxc1.nombre nacionalidad, 
        FORMAT(SUM(pci.abono_neodata), 'C') montoSinDescuentos,
        (CASE u0.forma_pago WHEN 3 THEN FORMAT(SUM(pci.abono_neodata) - ((SUM(pci.abono_neodata) * se.impuesto) / 100), 'C') 
        ELSE FORMAT(SUM(pci.abono_neodata), 'C') END) montoConDescuentosSede, 0.00 montoFinal
        FROM pago_comision_ind pci
        INNER JOIN comisiones co ON co.id_comision = pci.id_comision
        INNER JOIN lotes lo ON lo.idLote = co.id_lote
        INNER JOIN usuarios u0 ON u0.id_usuario = pci.id_usuario
        INNER JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = u0.id_rol AND oxc0.id_catalogo = 1
        INNER JOIN opcs_x_cats oxc1 ON oxc1.id_opcion = u0.nacionalidad AND oxc1.id_catalogo = 11
        INNER JOIN opcs_x_cats oxc2 ON oxc2.id_opcion = u0.forma_pago AND oxc2.id_catalogo = 16
        LEFT JOIN sedes se ON CAST(se.id_sede AS VARCHAR(15)) = CAST(u0.id_sede AS VARCHAR(15))
        WHERE pci.estatus = 8 -- AND pci.id_usuario = 3142
        GROUP BY u0.id_usuario, UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)), 
        se.nombre, oxc0.nombre, oxc2.nombre, u0.rfc,oxc1.nombre, u0.forma_pago, se.impuesto, u0.id_rol
        ORDER BY CASE u0.id_rol WHEN 3 THEN 4 WHEN 9 THEN 5 WHEN 7 THEN 6 ELSE u0.id_rol END");
    }

    public function verifyData($id_usuario) {
        $month = date("m");
        $year = date("Y");
		$query = $this->db-> query("SELECT id_usuario/*, FORMAT(monto_sin_descuento, 'C') monto_sin_descuento, FORMAT(monto_con_descuento, 'C') monto_con_descuento, 
        FORMAT(monto_internomex, 'C') monto_internomex, fecha_creacion*/ FROM pagos_internomex 
        WHERE id_usuario IN ($id_usuario) AND YEAR(fecha_creacion) = $year AND MONTH(fecha_creacion) = $month")->result();
		return $query;
	}

    
        //return $this->db->count_all_results() > 0;

        // 
        //return $query->result() !== [];
        
    }
    public function getMFPagos( $year,$mes){
        $cmd = "SELECT p.id_usuario,p.monto_con_descuento,p.monto_sin_descuento,p.monto_internomex,CONCAT (u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre
        FROM  pagos_internomex p  INNER JOIN usuarios u on u.id_usuario = p.id_usuario
        WHERE YEAR(p.fecha_creacion) = $year and MONTH(p.fecha_creacion) = $mes";
       $query = $this->db->query($cmd);
        return $query  ;
    }
    public function insertMontoFinalPago($data){

         $this->db->insert('dbo.pagos_internomex', $data);    
        return $this->db->affected_rows();

        //  $this->db->where('id_comida', $id_comida);
      //  $this->db->set("status", 2);
      //  $this->db->update('menu');
      //  return $this->db->affected_rows();
    }
    public function getuser($claves,$mes,$fecha){
        //claves es necesario para barrer todos los numeros
        $cmd("SELECT * FROM auditoria WHERE id_parametro IN $claves AND YEAR(fecha_creacion) = $mes AND MONTH(fecha_creacion) = $fecha");
        $query = $this->db->query($cmd);


    }
    public function formaDePago($filtro){
        $cmd = ("SELECT * FROM opcs_x_cats WHERE id_catalogo = 16 and opcs_x_cats.nombre =  '$filtro' ");
        $query = $this->db->query($cmd);
        return $query->num_rows() > 0 ? $query->row() : false; 
    }

}
