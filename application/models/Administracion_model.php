<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Administracion_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }



	public function get_datos_lote_11 () {
        $query = $this->db-> query("SELECT l.idLote, cl.id_cliente, UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)) nombreCliente,
        l.nombreLote, l.idStatusContratacion, l.idMovimiento, CONVERT(varchar, l.modificado, 20) modificado, cl.rfc, l.totalNeto, l.totalValidado, CONVERT(varchar, l.fechaSolicitudValidacion, 20) fechaSolicitudValidacion,
        CAST(l.comentario AS varchar(MAX)) as comentario, CONVERT(varchar, l.fechaVenc, 20) fechaVenc, l.perfil, cond.nombre as nombreCondominio, res.nombreResidencial, l.ubicacion,
        ISNULL(tv.tipo_venta, 'Sin especificar') tipo_venta, l.observacionContratoUrgente as vl,
        concat(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) as asesor,
        concat(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno) as coordinador,
        concat(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno) as gerente,
        cond.idCondominio, cl.expediente, mo.descripcion, se.nombre nombreSede, hl.modificado ultimaFechaEstatus7,
        ISNULL(oxc0.nombre, 'Normal') tipo_proceso
        FROM lotes l
        INNER JOIN clientes cl ON cl.id_cliente = l.idCliente AND cl.idLote = l.idLote AND cl.status = 1
        INNER JOIN condominios cond ON l.idCondominio=cond.idCondominio
        INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
        INNER JOIN movimientos mo ON mo.idMovimiento = l.idMovimiento
        LEFT JOIN usuarios asesor ON cl.id_asesor = asesor.id_usuario
        LEFT JOIN usuarios coordinador ON cl.id_coordinador = coordinador.id_usuario
        LEFT JOIN usuarios gerente ON cl.id_gerente = gerente.id_usuario
        INNER JOIN sedes se ON se.id_sede = l.ubicacion
        LEFT JOIN tipo_venta tv ON tv.id_tventa = l.tipo_venta
        LEFT JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes 
        WHERE idStatusContratacion IN (7, 8) AND idMovimiento IN (37, 7, 64, 77, 67, 38, 65) AND status = 1 GROUP BY idLote, idCliente) hl ON hl.idLote = l.idLote AND hl.idCliente = l.idCliente
        LEFT JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = cl.proceso AND oxc0.id_catalogo = 97
        WHERE l.status = 1 AND l.idStatusContratacion IN (7, 8) AND  l.idMovimiento IN (38, 65, 37, 7, 64, 77, 67) AND ISNULL(l.validacionEnganche, 'NULL') NOT IN ('VALIDADO')
        GROUP BY l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
        l.nombreLote, l.idStatusContratacion, l.idMovimiento, CONVERT(varchar, l.modificado, 20), cl.rfc, l.totalNeto, l.totalValidado, CONVERT(varchar, l.fechaSolicitudValidacion, 20),
        CAST(l.comentario AS varchar(MAX)), CONVERT(varchar, l.fechaVenc, 20), l.perfil, cond.nombre, res.nombreResidencial, l.ubicacion,
        tv.tipo_venta, l.observacionContratoUrgente,
        concat(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno),
        concat(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno),
        concat(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno),
        cond.idCondominio, cl.expediente, mo.descripcion, se.nombre, hl.modificado, ISNULL(oxc0.nombre, 'Normal')
        ORDER BY l.nombreLote");
        return $query->result();
    }

    public function get_datos_admon($condominio){
    	return $this->db->query("SELECT lot.idCliente, lot.nombreLote, con.nombre as nombreCondominio, res.nombreResidencial, lot.idStatusLote, lot.comentarioLiberacion, lot.fechaLiberacion, 
        con.idCondominio, lot.sup as superficie, lot.saldo, lot.precio, lot.enganche, lot.porcentaje, lot.total, lot.referencia, lot.comentario, lot.comentarioLiberacion, lot.observacionLiberacion, 
        sl.nombre as descripcion_estatus, sl.color FROM [lotes] lot 
        INNER JOIN [condominios] con ON con.idCondominio = lot.idCondominio 
        INNER JOIN [residenciales] res ON res.idResidencial = con.idResidencial 
        INNER JOIN [statuslote] sl ON sl.idStatusLote = lot.idStatusLote WHERE lot.idCondominio = ".$condominio."");
    }

	public function validateSt11($idLote){
      $this->db->where("idLote",$idLote);
      $this->db->where_in('idStatusLote', 3);
      $this->db->where("((idStatusContratacion IN (8, 10) AND idMovimiento IN (40, 10, 67) AND (validacionEnganche = 'NULL' OR validacionEnganche IS NULL)) OR
      (idStatusContratacion = 12 and idMovimiento = 42 AND (validacionEnganche = 'NULL' OR validacionEnganche IS NULL)) OR
      (idStatusContratacion IN (7) AND idMovimiento IN (37, 7, 64, 77) AND (validacionEnganche = 'NULL' OR validacionEnganche IS NULL)) OR
      (idStatusContratacion IN (8) AND idMovimiento IN (38, 65, 67) AND (validacionEnganche = 'NULL' OR validacionEnganche IS NULL)))");
      $query = $this->db->get('lotes');
      $valida = (empty($query->result())) ? 0 : 1;
      return $valida;
    }


    public function updateSt($idLote,$arreglo,$arreglo2){

        $this->db->trans_begin();

        $this->db->where("idLote",$idLote);
        $this->db->update('lotes',$arreglo);

        $this->db->insert('historial_lotes',$arreglo2);

        if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
        }

	}

	 public function getAssisGte($id_cliente){
        $query = $this->db->query("SELECT id_gerente FROM clientes WHERE id_cliente=".$id_cliente);
        $query = $query->row();

        if($query->id_gerente != NULL || $query->id_gerente != ''){
            $query2 = $this->db->query("SELECT * FROM usuarios WHERE id_rol=6 AND estatus=1 AND id_lider=".$query->id_gerente);
            return $query2 = $query2->result_array();
//            print_r($query2 = $query2->result_array());
        }else{
            return $query;
//            print_r($query);

        }
        exit;
     }

     public function getInfoToMail($id_cliente, $id_lote){
        $query = $this->db->query("SELECT res.nombreResidencial, c.nombre as nombreCondominio, l.nombreLote,
        CONCAT(cl.nombre,' ', cl.apellido_paterno, ' ', cl.apellido_materno) as nombreCliente,
        cl.fechaApartado
        FROM clientes cl
        INNER JOIN lotes l ON l.idLote = cl.idLote
        INNER JOIN condominios c ON c.idCondominio=l.idCondominio
        INNER JOIN residenciales res ON res.idResidencial = c.idResidencial
        WHERE cl.id_cliente=".$id_cliente." AND cl.idLote=".$id_lote);
        return $query->row();
     }

    public function getDateStatus11(){
        $query = $this->db->query("SELECT r.descripcion, c.nombre, l.idLote, nombreLote, idStatusContratacion, idMovimiento, idStatusLote, perfil, 
        validacionEnganche, status8Flag, comentario, firmaRL, totalNeto2, l.idCliente, totalNeto, 
        totalValidado, hl.modificado as fecha_status_11,
        CONCAT(cl.nombre,' ', cl.apellido_paterno, ' ', cl.apellido_materno) as nombreCliente
        FROM lotes l
        INNER JOIN clientes cl ON cl.idLote = l.idLote AND l.idCliente = cl.id_cliente AND cl.status = 1
        INNER JOIN condominios c ON c.idCondominio = l.idCondominio
        INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
        INNER JOIN (SELECT idLote, idCliente, MAX(modificado) as modificado FROM historial_lotes WHERE idStatusContratacion = 11 AND idMovimiento = 41 AND status = 1
        GROUP BY idLote, idCliente) hl ON hl.idLote = l.idLote AND hl.idCliente = cl.id_cliente
        WHERE status8Flag = 0 AND validacionEnganche = 'VALIDADO' AND l.status = 1
        ORDER BY l.nombreLote");
        return $query->result_array();
    }
    public function getRepAdmon($idResidencial){
        $query = $this->db->query("SELECT re.descripcion AS Proyecto, cn.nombre as nombre_condominio, 
        lo.nombreLote as nombreLote, lo.idLote as idLote, hlo3.idStatusContratacion,
        UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)) as nombreCliente, 
        hlo.modificado AS fecha11, hl.fechaLiberacion as fechaLiberacion, oxc.nombre as nombre
        FROM clientes cl 
        INNER JOIN lotes lo ON lo.idLote = cl.idLote
        INNER JOIN historial_liberacion hl ON hl.idLote = lo.idLote AND hl.id_cliente = cl.id_cliente
        INNER JOIN opcs_x_cats AS oxc ON hl.tipo = oxc.id_opcion AND oxc.id_catalogo = 48
        INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes WHERE idStatusContratacion = 11 AND idMovimiento = 41 GROUP BY idLote, idCliente) hlo ON hlo.idLote = lo.idLote AND hlo.idCliente = cl.id_cliente
        INNER JOIN (SELECT idLote, idCliente, MAX(modificado) modificado FROM historial_lotes GROUP BY idLote, idCliente) hlo2 ON hlo2.idLote = lo.idLote AND hlo2.idCliente = cl.id_cliente
        INNER JOIN historial_lotes hlo3 ON hlo3.idLote = lo.idLote AND hlo3.idCliente = cl.id_cliente AND hlo2.modificado = hlo3.modificado
        INNER JOIN condominios cn ON cn.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = cn.idResidencial
        WHERE isNULL(noRecibo, '') != 'CANCELADO'  AND isNULL(lo.tipo_venta, 0) IN (0, 1, 2) 
        AND cl.status = 0 AND hl.fechaLiberacion >= '2022-07-22 00:00:00.000' AND re.idResidencial = $idResidencial
        ORDER BY nombreCliente");
        return $query->result_array();
    }

}
