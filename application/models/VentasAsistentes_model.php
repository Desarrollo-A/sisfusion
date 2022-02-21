<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class VentasAsistentes_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
     function get_proyecto_lista(){
        return $this->db->query("SELECT * FROM [residenciales] WHERE status = 1");
     }
     function get_condominio_lista($proyecto){
        return $this->db->query("SELECT * FROM [condominios] WHERE status = 1 AND idResidencial = ".$proyecto."");
     }
     function get_lote_lista($condominio){
        return $this->db->query("SELECT * FROM [lotes] WHERE status = 1 AND idCondominio =  ".$condominio." AND idCliente in (SELECT idCliente FROM clientes ) AND (idCliente <> 0 AND idCliente <>'')");
     }
     function get_datos_lote_aut($lote){
        return $this->db->query("SELECT cli.id_cliente, cli.nombre, con.idCondominio,  cli.apellido_paterno, cli.apellido_materno, cli.idLote, lot.nombreLote, con.nombre as condominio, res.nombreResidencial 
                                FROM clientes cli INNER JOIN [lotes] lot ON lot.idLote = cli.idLote 
                                INNER JOIN [condominios] con ON con.idCondominio = lot.idCondominio 
                                INNER JOIN [residenciales] res ON res.idResidencial = con.idResidencial WHERE cli.status = 1 AND cli.idLote = '".$lote."'");
     }
     function get_datos_lote_cont($lote){
        return $this->db->query("SELECT cli.id_cliente, cli.nombre, cli.apellido_paterno, cli.apellido_materno, cli.idLote, lot.nombreLote, con.nombre as condominio, res.nombreResidencial,  lot.contratoArchivo 
                                FROM clientes cli INNER JOIN [lotes] lot ON lot.idLote = cli.idLote 
                                INNER JOIN [condominios] con ON con.idCondominio = lot.idCondominio 
                                INNER JOIN [residenciales] res ON res.idResidencial = con.idResidencial WHERE cli.status = 1 AND cli.idLote = '".$lote."'");
     }

     public function getLegalRejections() {

        $query = $this->db-> query("SELECT l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
        l.nombreLote, l.idStatusContratacion, l.idMovimiento, l.modificado, cl.rfc,
        CAST(l.comentario AS varchar(MAX)) as comentario, l.fechaVenc, l.perfil, cond.nombre as nombreCondominio, res.nombreResidencial, l.ubicacion,
        l.tipo_venta, 
    concat(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) as asesor,
        concat(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno) as coordinador,
        concat(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno) as gerente,
    cond.idCondominio, cl.expediente
      FROM lotes l
        INNER JOIN clientes cl ON l.idLote=cl.idLote
        INNER JOIN condominios cond ON l.idCondominio=cond.idCondominio
        INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
        LEFT JOIN usuarios asesor ON cl.id_asesor = asesor.id_usuario
    LEFT JOIN usuarios coordinador ON asesor.id_lider = coordinador.id_usuario
        LEFT JOIN usuarios gerente ON coordinador.id_lider = gerente.id_usuario
        WHERE  l.idStatusContratacion = '3' and l.idMovimiento  = '82' and cl.status = 1 
      GROUP BY l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
        l.nombreLote, l.idStatusContratacion, l.idMovimiento, l.modificado, cl.rfc,
        CAST(l.comentario AS varchar(MAX)), l.fechaVenc, l.perfil, cond.nombre, res.nombreResidencial, l.ubicacion,
        l.tipo_venta, 
        concat(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno),
        concat(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno),
        concat(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno),
        cond.idCondominio, cl.expediente");
        return $query->result();
    }
   

	public function registroStatusContratacion8 () {
        if ($this->session->userdata('id_rol') == 32 || $this->session->userdata('id_rol') == 17) { // MJ: ES CONTRALORÍA CORPORATIVA
            $where = "(l.idStatusContratacion = '7' and l.idMovimiento  = '37'
            or l.idStatusContratacion = '7' and l.idMovimiento  = '7' and cl.status = 1
            or l.idStatusContratacion = '7' and l.idMovimiento  = '64' and cl.status = 1
            or l.idStatusContratacion = '7' and l.idMovimiento  = '66' and cl.status = 1
            or l.idStatusContratacion = '7' and l.idMovimiento  = '77' and cl.status = 1) AND l.tipo_venta IN (4, 6)";
        } else { // MJ: ES VENTAS
            if ($this->session->userdata('id_sede') == 9)
                $id_sede = "'4', '" . $this->session->userdata('id_sede') . "'";
            else
                $id_sede = "'" . $this->session->userdata('id_sede') . "'";
            $where = "l.idStatusContratacion = '7' and l.idMovimiento  = '37' and l.ubicacion IN($id_sede)
            or l.idStatusContratacion = '7' and l.idMovimiento  = '7' and cl.status = 1 and l.ubicacion IN($id_sede)
            or l.idStatusContratacion = '7' and l.idMovimiento  = '64' and cl.status = 1 and l.ubicacion IN($id_sede)
            or l.idStatusContratacion = '7' and l.idMovimiento  = '66' and cl.status = 1 and l.ubicacion  IN($id_sede)
            or l.idStatusContratacion = '7' and l.idMovimiento  = '77' and cl.status = 1 and l.ubicacion  IN($id_sede)";
        }

		$query = $this->db-> query("SELECT l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
        l.nombreLote, l.idStatusContratacion, l.idMovimiento, l.modificado, cl.rfc,
        CAST(l.comentario AS varchar(MAX)) as comentario, l.fechaVenc, l.perfil, cond.nombre as nombreCondominio, res.nombreResidencial, l.ubicacion,
        l.tipo_venta, l.observacionContratoUrgente as vl,
        concat(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) as asesor,
        concat(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno) as coordinador,
        concat(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno) as gerente,
        cond.idCondominio, cl.expediente
        FROM lotes l
        INNER JOIN clientes cl ON l.idLote=cl.idLote and cl.status = 1
        INNER JOIN condominios cond ON l.idCondominio=cond.idCondominio
        INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
        LEFT JOIN usuarios asesor ON cl.id_asesor = asesor.id_usuario
        LEFT JOIN usuarios coordinador ON cl.id_coordinador = coordinador.id_usuario
        LEFT JOIN usuarios gerente ON cl.id_gerente = gerente.id_usuario
        where $where
        GROUP BY l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
        l.nombreLote, l.idStatusContratacion, l.idMovimiento, l.modificado, cl.rfc,
        CAST(l.comentario AS varchar(MAX)), l.fechaVenc, l.perfil, cond.nombre, res.nombreResidencial, l.ubicacion,
        l.tipo_venta, l.observacionContratoUrgente,   
        concat(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno),
        concat(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno),
        concat(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno),
        cond.idCondominio, cl.expediente");

		return $query->result();

	}




	public function validateSt8($idLote){
      $this->db->where("idLote",$idLote);
    $this->db->where_in('idStatusLote', 3);

    $this->db->where("( idStatusContratacion = 7 AND idMovimiento = 37 
          OR idStatusContratacion = 7 AND idMovimiento = 7 
          OR idStatusContratacion = 7 and idMovimiento = 64
          OR idStatusContratacion = 7 and idMovimiento = 66
          OR idStatusContratacion = 7 and idMovimiento = 77 )");	

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



	public function getCorreoSt ($idCliente) {

		$query = $this->db-> query("SELECT STRING_AGG (correo, ', ') correos FROM (
			/*ASESOR COORDINADOR GERENTE (TITULAR VENTA) */
			SELECT c.id_cliente, CONCAT(u.correo, ', ', uu.correo, ', ', uuu.correo) correo FROM clientes c 
			LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor 
			LEFT JOIN usuarios uu ON uu.id_usuario = c.id_coordinador 
			LEFT JOIN usuarios uuu ON uuu.id_usuario = c.id_gerente 
			WHERE c.id_cliente = ".$idCliente."
			UNION ALL
			/*ASESOR COORDINADOR GERENTE (VENTAS COMPARTIDAS) */
			SELECT vc.id_cliente, CONCAT(u.correo, ', ', uu.correo, ', ', uuu.correo) correo FROM ventas_compartidas vc 
			LEFT JOIN usuarios u ON u.id_usuario = vc.id_asesor 
			LEFT JOIN usuarios uu ON uu.id_usuario = vc.id_coordinador 
			LEFT JOIN usuarios uuu ON uuu.id_usuario = vc.id_gerente 
			WHERE vc.id_cliente = ".$idCliente."
			UNION ALL
			/*ASISTENTE GERENTE (TITULAR VENTA) */
			SELECT c.id_cliente, u.correo FROM clientes c 
			LEFT JOIN usuarios u ON u.id_lider = c.id_gerente
			WHERE c.id_cliente = ".$idCliente." AND u.id_rol = 6
			UNION ALL
			/*ASISTENTE GERENTE (VENTAS COMPARTIDAS) */
			SELECT vc.id_cliente, u.correo FROM ventas_compartidas vc 
			INNER JOIN usuarios u ON u.id_lider = vc.id_gerente
			WHERE vc.id_cliente = ".$idCliente." AND u.id_rol = 6
			UNION ALL
			/*ASISTENTE SUBDIRECTOR (TITULAR VENTA) */
			SELECT c.id_cliente, uuu.correo FROM clientes c 
			LEFT JOIN usuarios u ON u.id_usuario = c.id_gerente
			LEFT JOIN usuarios uu ON uu.id_usuario = u.id_lider
			LEFT JOIN usuarios uuu ON uuu.id_usuario = uu.id_lider
			WHERE c.id_cliente = ".$idCliente." AND uuu.id_rol = 5
			UNION ALL
			/*ASISTENTE SUBDIRECTOR (VENTAS COMPARTIDAS) */
			SELECT vc.id_cliente, uuu.correo FROM ventas_compartidas vc 
			LEFT JOIN usuarios u ON u.id_usuario = vc.id_gerente
			LEFT JOIN usuarios uu ON uu.id_usuario = u.id_lider
			LEFT JOIN usuarios uuu ON uuu.id_lider = uu.id_usuario
			WHERE vc.id_cliente = ".$idCliente." AND uuu.id_rol = 5 GROUP BY vc.id_cliente, uuu.correo) AS correos;");

		return $query->result_array();

	}



	public function getNameLote($idLote){
		$query = $this->db-> query("SELECT l.idLote, l.nombreLote, cond.nombre,
		res.nombreResidencial
        FROM lotes l
        INNER JOIN condominios cond ON l.idCondominio=cond.idCondominio
        INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
		where l.idLote = ".$idLote." "); 
		return $query->row();
	}
	

   public function registroStatusContratacion14 () {
        if ($this->session->userdata('id_rol') == 32 || $this->session->userdata('id_rol') == 17) { // MJ: ES CONTRALORÍA CORPORATIVA
            $where = "l.idStatusContratacion = 13 AND l.idMovimiento  = 43 AND cl.status = 1 AND l.tipo_venta = 4 OR l.idStatusContratacion = 13 AND l.idMovimiento  = 68 AND cl.status = 1 and l.tipo_venta IN (4, 6)";
        } else { // MJ: ES VENTAS
            if ($this->session->userdata('id_sede') == 9)
                $id_sede = "'4', '" . $this->session->userdata('id_sede') . "'";
            else
                $id_sede = "'" . $this->session->userdata('id_sede') . "'";
            $where = "l.idStatusContratacion = 13 AND l.idMovimiento  = 43 AND cl.status = 1 and l.ubicacion IN($id_sede) OR l.idStatusContratacion = 13 AND l.idMovimiento  = 68 AND cl.status = 1 and l.ubicacion IN($id_sede)";
        }
		$query = $this->db-> query("SELECT l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
        l.nombreLote, l.idStatusContratacion, l.idMovimiento, l.modificado, cl.rfc,
        CAST(l.comentario AS varchar(MAX)) as comentario, l.fechaVenc, l.perfil, cond.nombre as nombreCondominio, res.nombreResidencial, l.ubicacion,
        l.tipo_venta, 
        concat(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) as asesor,
        concat(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno) as coordinador,
        concat(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno) as gerente,
        cond.idCondominio, l.observacionContratoUrgente as vl
        FROM lotes l
        INNER JOIN clientes cl ON l.idLote=cl.idLote
        INNER JOIN condominios cond ON l.idCondominio=cond.idCondominio
        INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
        LEFT JOIN usuarios asesor ON cl.id_asesor = asesor.id_usuario
        LEFT JOIN usuarios coordinador ON cl.id_coordinador = coordinador.id_usuario
        LEFT JOIN usuarios gerente ON cl.id_gerente = gerente.id_usuario
        where $where
        GROUP BY l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
        l.nombreLote, l.idStatusContratacion, l.idMovimiento, l.modificado, cl.rfc,
        CAST(l.comentario AS varchar(MAX)), l.fechaVenc, l.perfil, cond.nombre, res.nombreResidencial, l.ubicacion,
        l.tipo_venta, concat(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno),
        concat(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno),
        concat(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno),
        cond.idCondominio, l.observacionContratoUrgente;");
		return $query->result();

	}


	public function validateSt14($idLote){
      $this->db->where("idLote",$idLote);
      $this->db->where_in('idStatusLote', 3);
  
      $this->db->where("(idStatusContratacion = 13 and idMovimiento  = 43
            OR idStatusContratacion = 13 and idMovimiento = 68)");	
  
      $query = $this->db->get('lotes');
      $valida = (empty($query->result())) ? 0 : 1;
      return $valida;
  
    }

	public function get_lp($idLote){
		$query = $this->db-> query("SELECT cl.lugar_prospeccion
        FROM clientes cl where cl.lugar_prospeccion = 6 AND cl.idLote = ".$idLote." "); 
		return $query->row();
	}
 
}
