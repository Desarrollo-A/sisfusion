<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contraloria_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
 

	 function get_proyecto_lista(){
        return $this->db->query("SELECT * FROM residenciales WHERE status = 1");
     }
     function get_condominio_lista($proyecto){
        return $this->db->query("SELECT * FROM condominios WHERE status = 1 AND idResidencial = ".$proyecto."");
     }
     function get_lote_lista($condominio){
        return $this->db->query("SELECT * FROM lotes WHERE status = 1 AND idCondominio =  ".$condominio." AND idCliente in (SELECT idCliente FROM clientes ) AND (idCliente <> 0 AND idCliente <>'')");
     }
     function get_datos_lote_exp($lote){
         return $this->db->query("SELECT cli.id_cliente, cli.nombre, cli.apellido_paterno, cli.apellido_materno, cli.idLote, 
				lot.nombreLote, con.nombre as condominio, res.nombreResidencial,  lot.contratoArchivo,
				concat(us.nombre,' ', us.apellido_paterno,' ', us.apellido_paterno) as asesor,  
	 			concat(ge.nombre,' ', ge.apellido_paterno,' ', ge.apellido_paterno) as gerente,
	 			con.idCondominio
				FROM clientes cli 
				INNER JOIN lotes lot ON lot.idLote = cli.idLote 
				INNER JOIN condominios con ON con.idCondominio = lot.idCondominio 
				INNER JOIN residenciales res ON res.idResidencial = con.idResidencial 
				INNER JOIN usuarios us ON cli.id_asesor = us.id_usuario
				INNER JOIN usuarios ge ON ge.id_usuario=us.id_lider
				WHERE cli.status = 1 AND cli.idLote = ".$lote);
     }
     function get_datos_lote_pagos($lote){
        /* return $this->db->query('SELECT cli.id_cliente, cli.nombre, cli.apellido_paterno, cli.apellido_materno,
		cli.idLote, lot.nombreLote, con.nombre as condominio, res.nombreResidencial,  lot.contratoArchivo 
		FROM clientes cli
		INNER JOIN lotes lot ON lot.idLote = cli.idLote
		INNER JOIN condominios con ON con.idCondominio = lot.idCondominio
		INNER JOIN residenciales res ON res.idResidencial = con.idResidencial
		WHERE cli.status = 1 AND cli.idLote = '.$lote);*/

		 return $this->db-> query("SELECT idEnganche, historial_enganche.noRecibo, historial_enganche.engancheCliente,
 		historial_enganche.fechaEnganche, lotes.nombreLote, historial_enganche.usuario,

	 	tipopago.tipo, cliente.nombre, cliente.apellido_paterno, 
	 	cliente.apellido_materno, cliente.rfc, historial_enganche.concepto 
	 	from historial_enganche 
	 	inner join lotes on historial_enganche.idLote = lotes.idLote 
	 	inner join tipopago on historial_enganche.idTipoPago = tipopago.idTipoPago 
	 	inner join clientes as cliente on historial_enganche.idCliente = cliente.id_cliente 
	 	where historial_enganche.status = 1 and cliente.status = 1 and historial_enganche.idLote = '".$lote." '");



//		 return $query->result_array();
     }



 	public function registroStatusContratacion5 () {

		$query = $this->db-> query("SELECT l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
        l.nombreLote, l.idStatusContratacion, l.idMovimiento, l.modificado, cl.rfc,
        CAST(l.comentario AS varchar(MAX)) as comentario, l.fechaVenc, l.perfil, cond.nombre as nombreCondominio, res.nombreResidencial, l.ubicacion,
        l.tipo_venta, l.observacionContratoUrgente as vl,
		concat(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) as asesor,
        concat(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno) as coordinador,
        concat(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno) as gerente,
		cond.idCondominio
		
		
			,(SELECT concat(usuarios.nombre,' ', usuarios.apellido_paterno, ' ', usuarios.apellido_materno)
			from historial_lotes left join usuarios on historial_lotes.usuario = usuarios.id_usuario
			where idHistorialLote =(SELECT MAX(idHistorialLote) FROM historial_lotes WHERE idLote in (l.idLote) and (perfil = '13' or perfil = '32' 
			or perfil = 'contraloria') and status = 1)) as lastUc


        FROM lotes l
        INNER JOIN clientes cl ON l.idLote=cl.idLote
        INNER JOIN condominios cond ON l.idCondominio=cond.idCondominio
        INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial

		
		LEFT JOIN usuarios asesor ON cl.id_asesor = asesor.id_usuario
		LEFT JOIN usuarios coordinador ON cl.id_coordinador = coordinador.id_usuario
		LEFT JOIN usuarios gerente ON cl.id_gerente = gerente.id_usuario
		

		where l.idStatusContratacion = 2 AND l.idMovimiento  = 4 AND cl.status = 1
			  OR l.idStatusContratacion = 2 AND l.idMovimiento  = 74 AND cl.status = 1
			  OR l.idStatusContratacion = 2 AND l.idMovimiento  = 84 AND cl.status = 1
			  OR l.idStatusContratacion = 2 AND l.idMovimiento  = 93 AND cl.status = 1

			  
        GROUP BY l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
        l.nombreLote, l.idStatusContratacion, l.idMovimiento, l.modificado, cl.rfc,
        CAST(l.comentario AS varchar(MAX)), l.fechaVenc, l.perfil, cond.nombre, res.nombreResidencial, l.ubicacion,
        l.tipo_venta, l.observacionContratoUrgente,
		
		
		concat(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno),
        concat(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno),
        concat(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno),
		cond.idCondominio;");
		return $query->result();

	}





	public function validateSt5($idLote){
        $this->db->where("idLote",$idLote);
		$this->db->where_in('idStatusLote', 3);

		$this->db->where("(idStatusContratacion = 2 AND idMovimiento  = 4 
		OR idStatusContratacion = 2 AND idMovimiento  = 74
		OR idStatusContratacion = 2 AND idMovimiento  = 84
		OR idStatusContratacion = 2 AND idMovimiento  = 93)");	

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


	function get_sede(){
        return $this->db->query("SELECT * FROM sedes WHERE id_sede NOT IN (7) AND estatus = 1");
     }


	function get_tventa(){
        return $this->db->query("SELECT * FROM tipo_venta WHERE status = 1");
    }




	public function registroStatusContratacion6 () {

		$query = $this->db-> query("SELECT l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
        l.nombreLote, l.idStatusContratacion, l.idMovimiento, l.modificado, cl.rfc,
        CAST(l.comentario AS varchar(MAX)) as comentario, l.fechaVenc, l.perfil, cond.nombre as nombreCondominio, res.nombreResidencial, l.ubicacion,
        l.tipo_venta, l.observacionContratoUrgente as vl,
		concat(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) as asesor,
        concat(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno) as coordinador,
        concat(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno) as gerente,
		cond.idCondominio, cl.expediente 

			,(SELECT concat(usuarios.nombre,' ', usuarios.apellido_paterno, ' ', usuarios.apellido_materno)
			from historial_lotes left join usuarios on historial_lotes.usuario = usuarios.id_usuario
			where idHistorialLote =(SELECT MAX(idHistorialLote) FROM historial_lotes WHERE idLote in (l.idLote) and (perfil = '13' or perfil = '32' 
			or perfil = 'contraloria') and status = 1)) as lastUc


	    FROM lotes l
        INNER JOIN clientes cl ON l.idLote=cl.idLote
        INNER JOIN condominios cond ON l.idCondominio=cond.idCondominio
        INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial

		LEFT JOIN usuarios asesor ON cl.id_asesor = asesor.id_usuario
		LEFT JOIN usuarios coordinador ON cl.id_coordinador = coordinador.id_usuario
		LEFT JOIN usuarios gerente ON cl.id_gerente = gerente.id_usuario

	
		where  l.idStatusContratacion = '5' and l.idMovimiento  = '35' and cl.status = 1
		or l.idStatusContratacion = '5' and l.idMovimiento  = '22' and cl.status = 1
		or l.idStatusContratacion = '2' and l.idMovimiento  = '62' and cl.status = 1
		or l.idStatusContratacion = '5' and l.idMovimiento  = '75' and cl.status = 1
		or l.idStatusContratacion = '5' and l.idMovimiento  = '94' and cl.status = 1

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




	public function validateSt6($idLote){
        $this->db->where("idLote",$idLote);
		$this->db->where_in('idStatusLote', 3);

		$this->db->where("(idStatusContratacion = 5 AND idMovimiento  = 35 
		OR idStatusContratacion = 5 AND idMovimiento  = 22
		OR idStatusContratacion = 2 AND idMovimiento  = 62
		OR idStatusContratacion = 5 AND idMovimiento  = 75
		OR idStatusContratacion = 5 AND idMovimiento  = 94)");	

		$query = $this->db->get('lotes');
		$valida = (empty($query->result())) ? 0 : 1;
		return $valida;

	}


	public function getCorreoSt ($idCliente) {

		$query = $this->db-> query("SELECT STRING_AGG (correo, ', ') correos FROM (
			/*ASESOR COORDINADOR GERENTE (TITULAR VENTA) */
			SELECT c.id_cliente, CONCAT(u.correo, ', ', uu.correo, ', ', uuu.correo) correo FROM clientes c 
			LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor AND u.estatus = 1
			LEFT JOIN usuarios uu ON uu.id_usuario = c.id_coordinador  AND uu.estatus = 1
			LEFT JOIN usuarios uuu ON uuu.id_usuario = c.id_gerente  AND uuu.estatus = 1
			WHERE c.id_cliente = ".$idCliente."
			UNION ALL
			/*ASESOR COORDINADOR GERENTE (VENTAS COMPARTIDAS) */
			SELECT vc.id_cliente, CONCAT(u.correo, ', ', uu.correo, ', ', uuu.correo) correo FROM ventas_compartidas vc 
			LEFT JOIN usuarios u ON u.id_usuario = vc.id_asesor AND u.estatus = 1
			LEFT JOIN usuarios uu ON uu.id_usuario = vc.id_coordinador AND uu.estatus = 1 
			LEFT JOIN usuarios uuu ON uuu.id_usuario = vc.id_gerente AND uuu.estatus = 1
			WHERE vc.id_cliente = ".$idCliente."
			UNION ALL
			/*ASISTENTE GERENTE (TITULAR VENTA) */
			SELECT c.id_cliente, u.correo FROM clientes c 
			LEFT JOIN usuarios u ON u.id_lider = c.id_gerente
			WHERE c.id_cliente = ".$idCliente." AND u.id_rol = 6 AND u.estatus = 1
			UNION ALL
			/*ASISTENTE GERENTE (VENTAS COMPARTIDAS) */
			SELECT vc.id_cliente, u.correo FROM ventas_compartidas vc 
			INNER JOIN usuarios u ON u.id_lider = vc.id_gerente
			WHERE vc.id_cliente = ".$idCliente." AND u.id_rol = 6 AND u.estatus = 1
			UNION ALL
			/*ASISTENTE SUBDIRECTOR (TITULAR VENTA) */
			SELECT c.id_cliente, uuu.correo FROM clientes c 
			LEFT JOIN usuarios u ON u.id_usuario = c.id_gerente
			LEFT JOIN usuarios uu ON uu.id_usuario = u.id_lider
			LEFT JOIN usuarios uuu ON uuu.id_usuario = uu.id_lider
			WHERE c.id_cliente = ".$idCliente." AND uuu.id_rol = 5 AND u.estatus = 1
			UNION ALL
			/*ASISTENTE SUBDIRECTOR (VENTAS COMPARTIDAS) */
			SELECT vc.id_cliente, uuu.correo FROM ventas_compartidas vc 
			LEFT JOIN usuarios u ON u.id_usuario = vc.id_gerente
			LEFT JOIN usuarios uu ON uu.id_usuario = u.id_lider
			LEFT JOIN usuarios uuu ON uuu.id_lider = uu.id_usuario
			WHERE vc.id_cliente = ".$idCliente." AND uuu.id_rol = 5 AND u.estatus = 1 GROUP BY vc.id_cliente, uuu.correo) AS correos;");

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




	public function registroStatusContratacion9 () {
		
	    if($this->session->userdata('id_usuario') == 2749 || $this->session->userdata('id_usuario') == 2752){
		

		$query = $this->db-> query("SELECT l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
        l.nombreLote, l.idStatusContratacion, l.idMovimiento, l.modificado, cl.rfc,
        CAST(l.comentario AS varchar(MAX)) as comentario, l.fechaVenc, l.perfil, res.nombreResidencial, cond.nombre as nombreCondominio,
        l.ubicacion, l.tipo_venta, l.observacionContratoUrgente as vl,
		concat(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) as asesor,
        concat(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno) as coordinador,
        concat(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno) as gerente,
		cond.idCondominio

        FROM lotes l
        INNER JOIN clientes cl ON l.idLote=cl.idLote
        INNER JOIN condominios cond ON l.idCondominio=cond.idCondominio
        INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial

		LEFT JOIN usuarios asesor ON cl.id_asesor = asesor.id_usuario
		LEFT JOIN usuarios coordinador ON cl.id_coordinador = coordinador.id_usuario
		LEFT JOIN usuarios gerente ON cl.id_gerente = gerente.id_usuario

        WHERE l.idStatusContratacion = 8 AND l.idMovimiento = 38 AND cl.status=1
		OR l.idStatusContratacion = 8 AND l.idMovimiento=65 AND cl.status = 1

	    GROUP BY l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
        l.nombreLote, l.idStatusContratacion, l.idMovimiento, l.modificado, cl.rfc,
        CAST(l.comentario AS varchar(MAX)), l.fechaVenc, l.perfil, cond.nombre, res.nombreResidencial, l.ubicacion,
        l.tipo_venta, l.observacionContratoUrgente,
	
		concat(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno),
        concat(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno),
        concat(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno),
		cond.idCondominio");
		
		} else {

			if ($this->session->userdata('id_usuario') == 2751 || $this->session->userdata('id_usuario') == 5696)
				$id_sede = "'".$this->session->userdata('id_sede')."', '6'";
			else
				$id_sede = "'".$this->session->userdata('id_sede')."'";
		
		$query = $this->db-> query("SELECT l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
        l.nombreLote, l.idStatusContratacion, l.idMovimiento, l.modificado, cl.rfc,
        CAST(l.comentario AS varchar(MAX)) as comentario, l.fechaVenc, l.perfil, res.nombreResidencial, cond.nombre as nombreCondominio,
        l.ubicacion, l.tipo_venta, l.observacionContratoUrgente as vl,
		concat(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) as asesor,
        concat(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno) as coordinador,
        concat(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno) as gerente,
		cond.idCondominio

        FROM lotes l
        INNER JOIN clientes cl ON l.idLote=cl.idLote
        INNER JOIN condominios cond ON l.idCondominio=cond.idCondominio
        INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial

		LEFT JOIN usuarios asesor ON cl.id_asesor = asesor.id_usuario
		LEFT JOIN usuarios coordinador ON cl.id_coordinador = coordinador.id_usuario
		LEFT JOIN usuarios gerente ON cl.id_gerente = gerente.id_usuario

        WHERE l.idStatusContratacion = 8 AND l.idMovimiento = 38 AND cl.status=1 and l.ubicacion IN ($id_sede)
		OR l.idStatusContratacion = 8 AND l.idMovimiento=65 AND cl.status = 1 and l.ubicacion IN ($id_sede)

	    GROUP BY l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
        l.nombreLote, l.idStatusContratacion, l.idMovimiento, l.modificado, cl.rfc,
        CAST(l.comentario AS varchar(MAX)), l.fechaVenc, l.perfil, cond.nombre, res.nombreResidencial, l.ubicacion,
        l.tipo_venta, l.observacionContratoUrgente,
	
		concat(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno),
        concat(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno),
        concat(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno),
		cond.idCondominio");
		
		}
		
		return $query->result();

	}



	public function validateSt9($idLote){
        $this->db->where("idLote",$idLote);
		$this->db->where_in('idStatusLote', 3);

		$this->db->where("(idStatusContratacion = 8 AND idMovimiento  = 38 
		OR idStatusContratacion = 8 AND idMovimiento  = 65)");	

		$query = $this->db->get('lotes');
		$valida = (empty($query->result())) ? 0 : 1;
		return $valida;

	}

	public function findCount(){

		$this->db->select('contador');
		$this->db->from('variables');
		$query = $this->db->get();
		return $query->row();

	}


	public function selectRegistroPorContrato($numContrato){

		$this->db->select("cl.id_cliente, l.nombreLote, l.idLote, l.usuario, l.perfil, l.fechaVenc, l.idCondominio,
		l.modificado, l.fechaSolicitudValidacion, cl.nombre, cl.apellido_paterno, cl.apellido_materno, 
		cl.rfc, l.contratoUrgente, l.observacionContratoUrgente, l.observacionContratoUrgente as vl,
		l.fechaRL, l.idStatusContratacion, l.idMovimiento");
		$this->db->join('clientes cl', 'cl.idLote = l.idLote');
		$this->db->where("l.numContrato",$numContrato);
		

		$this->db->where("(cl.status=1 AND l.idStatusContratacion=9 AND l.idMovimiento=39)");
		$this->db->where('l.status', 1);
		$query = $this->db->get('lotes l');
		return $query->row();

	}


	public function updateSt10($contrato,$arreglo,$arreglo2,$data3,$id,$folioUp){

        $this->db->trans_begin();

        $this->db->where("numContrato", $contrato);
        $this->db->update('lotes',$arreglo);
        $this->db->insert('historial_lotes',$arreglo2);
		$this->db->insert('controlcontrato',$data3);

		$this->db->where("idVariable",$id);
		$this->db->update('variables',$folioUp);

        if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
        }

	}


	public function registroStatusContratacion10v2 () {
		
		
	    if($this->session->userdata('id_usuario') == 2749 || $this->session->userdata('id_usuario') == 2752){


			$query = $this->db-> query("SELECT l.idLote, cl.id_cliente, l.validacionEnganche, l.firmaRL,
		l.nombreLote, l.idStatusContratacion, l.idMovimiento, l.perfil, cond.nombre as nombreCondominio,
		res.nombreResidencial, l.ubicacion, l.tipo_venta, l.numContrato, l.observacionContratoUrgente as vl,
		CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno) nombreCliente
		FROM lotes l
		INNER JOIN clientes cl ON cl.idLote = l.idLote
		INNER JOIN condominios cond ON l.idCondominio = cond.idCondominio
		INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
		WHERE
		l.idStatusContratacion=9 AND l.idMovimiento=39 AND cl.status=1
		OR l.idStatusContratacion=9 AND l.idMovimiento=26 AND cl.status=1
		GROUP BY l.idLote, cl.id_cliente, l.validacionEnganche, l.firmaRL,
		l.nombreLote, l.idStatusContratacion, l.idMovimiento, l.perfil, cond.nombre,
		res.nombreResidencial, l.ubicacion, l.tipo_venta, l.numContrato, l.observacionContratoUrgente,
		CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)");
		
		} else {
			if ($this->session->userdata('id_usuario') == 2751 || $this->session->userdata('id_usuario') == 5696)
				$id_sede = "'".$this->session->userdata('id_sede')."', '6'";
			else
				$id_sede = "'".$this->session->userdata('id_sede')."'";
			
			$query = $this->db-> query("SELECT l.idLote, cl.id_cliente, l.validacionEnganche, l.firmaRL,
		l.nombreLote, l.idStatusContratacion, l.idMovimiento, l.perfil, cond.nombre as nombreCondominio,
		res.nombreResidencial, l.ubicacion, l.tipo_venta, l.numContrato, l.observacionContratoUrgente as vl,
		CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno) nombreCliente
		FROM lotes l
		INNER JOIN clientes cl ON cl.idLote = l.idLote
		INNER JOIN condominios cond ON l.idCondominio = cond.idCondominio
		INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
		WHERE
		l.idStatusContratacion=9 AND l.idMovimiento=39 AND cl.status=1 and l.ubicacion IN ($id_sede)
		OR l.idStatusContratacion=9 AND l.idMovimiento=26 AND cl.status=1 and l.ubicacion IN ($id_sede)
		GROUP BY l.idLote, cl.id_cliente, l.validacionEnganche, l.firmaRL,
		l.nombreLote, l.idStatusContratacion, l.idMovimiento, l.perfil, cond.nombre,
		res.nombreResidencial, l.ubicacion, l.tipo_venta, l.numContrato, l.observacionContratoUrgente,
		CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)");
		
		
		}
	
			return $query->result();
		}
	
	
		public function registroStatusContratacion12 () {
			
	    if($this->session->userdata('id_usuario') == 2749 || $this->session->userdata('id_usuario') == 2752){


			$query = $this->db-> query("SELECT l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, l.fechaSolicitudValidacion, l.nombreLote, l.idStatusContratacion,
			l.idMovimiento, l.modificado, cl.rfc, CAST(l.comentario AS varchar(MAX)) as comentario, l.fechaVenc, l.perfil, cond.nombre as nombreCondominio, 
			res.nombreResidencial, l.numContrato, l.ubicacion, l.totalValidado, l.totalNeto, l.tipo_venta, l.observacionContratoUrgente as vl
			FROM lotes l
			INNER JOIN clientes cl ON cl.idLote = l.idLote
			INNER JOIN condominios cond ON l.idCondominio = cond.idCondominio
			INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
			WHERE l.idStatusContratacion = 11 AND l.idMovimiento = 41 AND (l.firmaRL = 'NULL' OR l.firmaRL=' ' OR l.firmaRL IS NULL) AND cl.status = 1
			OR l.idStatusContratacion = 10 AND l.idMovimiento = 40 AND (l.firmaRL = 'NULL' OR l.firmaRL = ' ' OR l.firmaRL IS NULL) AND cl.status = 1
			OR l.idStatusContratacion = 7 AND l.idMovimiento = 66 AND (l.firmaRL = 'NULL' OR l.firmaRL = ' ' OR l.firmaRL IS NULL) AND cl.status = 1
			OR l.idStatusContratacion = 8 AND l.idMovimiento = 67 AND (l.firmaRL = 'NULL' OR l.firmaRL = ' ' OR l.firmaRL IS NULL) AND cl.status = 1
			GROUP BY l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, l.fechaSolicitudValidacion, l.nombreLote, l.idStatusContratacion,
			l.idMovimiento, l.modificado, cl.rfc, CAST(l.comentario AS varchar(MAX)), l.fechaVenc, l.perfil, cond.nombre, 
			res.nombreResidencial, l.numContrato, l.ubicacion, l.totalValidado, l.totalNeto, l.tipo_venta, l.observacionContratoUrgente;");
			
			
		} else {
			if ($this->session->userdata('id_usuario') == 2751 || $this->session->userdata('id_usuario') == 5696)
				$id_sede = "'".$this->session->userdata('id_sede')."', '6'";
			else
				$id_sede = "'".$this->session->userdata('id_sede')."'";
		
			$query = $this->db-> query("SELECT l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, l.fechaSolicitudValidacion, l.nombreLote, l.idStatusContratacion,
			l.idMovimiento, l.modificado, cl.rfc, CAST(l.comentario AS varchar(MAX)) as comentario, l.fechaVenc, l.perfil, cond.nombre as nombreCondominio, 
			res.nombreResidencial, l.numContrato, l.ubicacion, l.totalValidado, l.totalNeto, l.tipo_venta, l.observacionContratoUrgente as vl
			FROM lotes l
			INNER JOIN clientes cl ON cl.idLote = l.idLote
			INNER JOIN condominios cond ON l.idCondominio = cond.idCondominio
			INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
			WHERE l.idStatusContratacion = 11 AND l.idMovimiento = 41 AND (l.firmaRL = 'NULL' OR l.firmaRL=' ' OR l.firmaRL IS NULL) AND cl.status = 1 and l.ubicacion IN ($id_sede)
			OR l.idStatusContratacion = 10 AND l.idMovimiento = 40 AND (l.firmaRL = 'NULL' OR l.firmaRL = ' ' OR l.firmaRL IS NULL) AND cl.status = 1 and l.ubicacion IN ($id_sede)
			OR l.idStatusContratacion = 7 AND l.idMovimiento = 66 AND (l.firmaRL = 'NULL' OR l.firmaRL = ' ' OR l.firmaRL IS NULL) AND cl.status = 1 and l.ubicacion IN ($id_sede)
			OR l.idStatusContratacion = 8 AND l.idMovimiento = 67 AND (l.firmaRL = 'NULL' OR l.firmaRL = ' ' OR l.firmaRL IS NULL) AND cl.status = 1 and l.ubicacion IN ($id_sede)
			GROUP BY l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, l.fechaSolicitudValidacion, l.nombreLote, l.idStatusContratacion,
			l.idMovimiento, l.modificado, cl.rfc, CAST(l.comentario AS varchar(MAX)), l.fechaVenc, l.perfil, cond.nombre, 
			res.nombreResidencial, l.numContrato, l.ubicacion, l.totalValidado, l.totalNeto, l.tipo_venta, l.observacionContratoUrgente;");
		
		}
			return $query->result();
	
		}


		public function selectRegistroPorContratoStatus12($numContrato){

			$this->db->select("cl.id_cliente, l.nombreLote, l.idLote, l.usuario, l.perfil, l.fechaVenc, l.idCondominio, l.modificado, l.fechaSolicitudValidacion, l.fechaRecepcionContrato,
			cl.nombre, cl.apellido_paterno, cl.apellido_materno, cl.rfc, l.contratoUrgente, l.observacionContratoUrgente as vl,
			l.fechaRL, l.idStatusContratacion, l.idMovimiento, l.firmaRL, cl.status, l.validacionEnganche");
			$this->db->join('clientes cl', 'cl.idLote = l.idLote ');
	
			$this->db->where("l.numContrato",$numContrato);

			$this->db->where("( (l.idStatusContratacion=11 AND l.idMovimiento=41 AND (l.firmaRL='NULL' OR l.firmaRL IS NULL)) OR
                    		   (l.idStatusContratacion=10 AND l.idMovimiento=40 AND (l.firmaRL='NULL' OR l.firmaRL IS NULL) ) )");
	

			$query = $this->db->get('lotes l');
			return $query->row();
	
		}



		public function updateSt12($contrato,$arreglo,$arreglo2,$data3){

			$this->db->trans_begin();
	
			$this->db->where("numContrato", $contrato);
			$this->db->update('lotes',$arreglo);

			$this->db->insert('historial_lotes',$arreglo2);

			$this->db->where("numContrato",$contrato);
			$this->db->update('controlcontrato',$data3);

			if ($this->db->trans_status() === FALSE){
					$this->db->trans_rollback();
					return false;
				} else {
					$this->db->trans_commit();
					return true;
			}
	
		}


		public function registroStatusContratacion13 () {
			
		    if($this->session->userdata('id_usuario') == 2749 || $this->session->userdata('id_usuario') == 2752){


			$query = $this->db-> query("SELECT l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
			l.nombreLote, l.idStatusContratacion, l.idMovimiento, l.modificado, cl.rfc,
			CAST(l.comentario AS varchar(MAX)) as comentario, l.fechaVenc, l.perfil, res.nombreResidencial, cond.nombre as nombreCondominio,
			l.ubicacion, l.tipo_venta, l.firmaRL, l.validacionEnganche, 
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
	
			WHERE l.idStatusContratacion=12 AND l.idMovimiento=42 AND cl.status=1
			OR l.idStatusContratacion=11 AND l.idMovimiento=41 AND cl.status=1
	
			GROUP BY l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
			l.nombreLote, l.idStatusContratacion, l.idMovimiento, l.modificado, cl.rfc,
			CAST(l.comentario AS varchar(MAX)), l.fechaVenc, l.perfil, cond.nombre, res.nombreResidencial, l.ubicacion,
			l.tipo_venta, l.firmaRL, l.validacionEnganche,
		
			concat(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno),
			concat(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno),
			concat(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno),
			cond.idCondominio, l.observacionContratoUrgente");
			
			} else {
				if ($this->session->userdata('id_usuario') == 2751 || $this->session->userdata('id_usuario') == 5696)
					$id_sede = "'".$this->session->userdata('id_sede')."', '6'";
				else
					$id_sede = "'".$this->session->userdata('id_sede')."'";
			
			$query = $this->db-> query("SELECT l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
			l.nombreLote, l.idStatusContratacion, l.idMovimiento, l.modificado, cl.rfc,
			CAST(l.comentario AS varchar(MAX)) as comentario, l.fechaVenc, l.perfil, res.nombreResidencial, cond.nombre as nombreCondominio,
			l.ubicacion, l.tipo_venta, l.firmaRL, l.validacionEnganche,
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
	
			WHERE l.idStatusContratacion=12 AND l.idMovimiento=42 AND cl.status=1 and l.ubicacion IN ($id_sede)
			OR l.idStatusContratacion=11 AND l.idMovimiento=41 AND cl.status=1 and l.ubicacion IN ($id_sede)
	
			GROUP BY l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
			l.nombreLote, l.idStatusContratacion, l.idMovimiento, l.modificado, cl.rfc,
			CAST(l.comentario AS varchar(MAX)), l.fechaVenc, l.perfil, cond.nombre, res.nombreResidencial, l.ubicacion,
			l.tipo_venta, l.firmaRL, l.validacionEnganche,
		
			concat(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno),
			concat(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno),
			concat(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno),
			cond.idCondominio, l.observacionContratoUrgente");
			
			}
			
			return $query->result();
	
		}


		public function validateSt13($idLote){
			$this->db->where("idLote",$idLote);
			$this->db->where_in('idStatusLote', 3);
	
			$this->db->where("(idStatusContratacion = 12 AND idMovimiento  = 42 
			OR idStatusContratacion = 11 AND idMovimiento  = 41)");	
	
			$query = $this->db->get('lotes');
			$valida = (empty($query->result())) ? 0 : 1;
			return $valida;
	
		}
	
		
		public function registroStatusContratacion15 () {
			
		    if($this->session->userdata('id_usuario') == 2749 || $this->session->userdata('id_usuario') == 2752){


			$query = $this->db-> query("SELECT l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
			l.nombreLote, l.idStatusContratacion, l.idMovimiento, l.modificado, cl.rfc,
			CAST(l.comentario AS varchar(MAX)) as comentario, l.fechaVenc, l.perfil, res.nombreResidencial, cond.nombre as nombreCondominio,
			l.ubicacion, l.tipo_venta, l.firmaRL, l.validacionEnganche,
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
			
			WHERE 
			l.idStatusContratacion=14 AND l.idMovimiento=44 AND cl.status=1
			OR l.idStatusContratacion=14 AND l.idMovimiento=69 AND cl.status=1
			OR l.idStatusContratacion=14 AND l.idMovimiento=80 AND cl.status=1
	
			GROUP BY l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
			l.nombreLote, l.idStatusContratacion, l.idMovimiento, l.modificado, cl.rfc,
			CAST(l.comentario AS varchar(MAX)), l.fechaVenc, l.perfil, cond.nombre, res.nombreResidencial, l.ubicacion,
			l.tipo_venta, l.firmaRL, l.validacionEnganche,
		
			concat(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno),
			concat(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno),
			concat(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno),
			cond.idCondominio, l.observacionContratoUrgente");
			
			} else {
				if ($this->session->userdata('id_usuario') == 2751 || $this->session->userdata('id_usuario') == 5696)
					$id_sede = "'".$this->session->userdata('id_sede')."', '6'";
				else
					$id_sede = "'".$this->session->userdata('id_sede')."'";
				
			$query = $this->db-> query("SELECT l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
			l.nombreLote, l.idStatusContratacion, l.idMovimiento, l.modificado, cl.rfc,
			CAST(l.comentario AS varchar(MAX)) as comentario, l.fechaVenc, l.perfil, res.nombreResidencial, cond.nombre as nombreCondominio,
			l.ubicacion, l.tipo_venta, l.firmaRL, l.validacionEnganche,
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
			
			WHERE 
			l.idStatusContratacion=14 AND l.idMovimiento=44 AND cl.status=1 and l.ubicacion IN ($id_sede)
			OR l.idStatusContratacion=14 AND l.idMovimiento=69 AND cl.status=1 and l.ubicacion IN ($id_sede)
			OR l.idStatusContratacion=14 AND l.idMovimiento=80 AND cl.status=1 and l.ubicacion IN ($id_sede)
	
			GROUP BY l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
			l.nombreLote, l.idStatusContratacion, l.idMovimiento, l.modificado, cl.rfc,
			CAST(l.comentario AS varchar(MAX)), l.fechaVenc, l.perfil, cond.nombre, res.nombreResidencial, l.ubicacion,
			l.tipo_venta, l.firmaRL, l.validacionEnganche,
		
			concat(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno),
			concat(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno),
			concat(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno),
			cond.idCondominio, l.observacionContratoUrgente");
			
			
			}
			
			return $query->result();
	
		}



		public function validateSt15($idLote){
			$this->db->where("idLote",$idLote);
			$this->db->where_in('idStatusLote', 3);
	
			$this->db->where("(idStatusContratacion = 14 AND idMovimiento  = 44 
			OR idStatusContratacion = 14 AND idMovimiento  = 69
			OR idStatusContratacion = 14 AND idMovimiento  = 80)");	
	
			$query = $this->db->get('lotes');
			$valida = (empty($query->result())) ? 0 : 1;
			return $valida;
	
		}


		public function getAllDsByLote($idLote)
		{
			$query = $this->db-> query("SELECT cl.id_cliente, id_asesor, id_coordinador, id_gerente, cl.id_sede, cl.nombre, cl.apellido_paterno, 
	        cl.apellido_materno, cl.status ,cl.idLote, fechaApartado ,fechaVencimiento , cl.usuario, cond.idCondominio, cl.fecha_creacion, 
	        cl.creado_por, cl.fecha_modificacion, cl.modificado_por, cond.nombre as nombreCondominio, residencial.nombreResidencial as nombreResidencial,
	        cl.status, nombreLote, lotes.comentario, lotes.idMovimiento, lotes.fechaVenc, lotes.modificado
			FROM deposito_seriedad as ds
			INNER JOIN clientes as cl ON ds.id_cliente = cl.id_cliente
			INNER JOIN lotes as lotes on lotes.idLote=cl.idLote and lotes.idCliente = cl.id_cliente and cl.status = 1


			LEFT JOIN condominios as cond on lotes.idCondominio=cond.idCondominio
	        LEFT JOIN residenciales as residencial on cond.idResidencial=residencial.idResidencial
			
			WHERE  

			    idStatusContratacion = 1 AND idMovimiento = 31 and cl.status = 1 AND cl.idLote = ".$idLote."
				OR idStatusContratacion = 2 AND idMovimiento = 85 and cl.status = 1 AND cl.idLote = ".$idLote."
				OR idStatusContratacion = 1 and idMovimiento = 20 and cl.status = 1 AND cl.idLote = ".$idLote."
				OR idStatusContratacion = 1 and idMovimiento = 63 and cl.status = 1 AND cl.idLote = ".$idLote."
				OR idStatusContratacion = 1 and idMovimiento = 73 and cl.status = 1 AND cl.idLote = ".$idLote."
				OR idStatusContratacion = 3 and idMovimiento = 82 and cl.status = 1 AND cl.idLote = ".$idLote."
				OR idStatusContratacion = 1 and idMovimiento = 92 and cl.status = 1 AND cl.idLote = ".$idLote."
				OR idStatusContratacion = 1 and idMovimiento = 96 and cl.status = 1 AND cl.idLote = ".$idLote."

					
					
			ORDER BY cl.id_Cliente ASC");
			return $query->result_array();
		}


		public function getLotes($idCondominio)
		{
			$query = $this->db-> query("SELECT * FROM lotes WHERE status = 1 and idCondominio=".$idCondominio);
			return $query->result_array();
		}



		public function aplicaLiberaciones($idResidencial) {
			$count=0;
			$datos='';
			$fp = fopen($_FILES['expediente']['tmp_name'],'r') or die("can't open file");
			while($csv_line = fgetcsv($fp,1024)) {
				$count++;
				if($count == 1)
				{
					continue;
				}
				for($i = 0, $j = count($csv_line); $i < $j; $i++)
				{
					$insert_csv = array();
					$insert_csv['condominio'] = $csv_line[0];
					$insert_csv['nombreLote'] = $csv_line[1];
		
				}
				$i++;
			  
				  $query = $this->db->query("SELECT idLote from lotes
											INNER JOIN condominios ON condominios.idCondominio = lotes.idCondominio 
											INNER JOIN residenciales ON residenciales.idResidencial = condominios.idResidencial 
											WHERE residenciales.idResidencial = ".$idResidencial." 
											and condominios.nombre = '".$insert_csv['condominio']."'
											and lotes.nombreLote = '".$insert_csv['nombreLote']."' and lotes.status = 1")->result_array();
					if (!empty($query)){

							foreach ($query as $row) {
								$datos.= $row['idLote'].',';
							}		


							$datos = trim($datos, ',');
					
							$this->db->trans_begin();
								 $this->db->query("UPDATE lotes SET observacionContratoUrgente = 1 WHERE status = 1 and idLote IN (".$datos.") ");		
				
							 if ($this->db->trans_status() === FALSE) {
								$this->db->trans_rollback();
								return false;
							   }
							 else {
								$this->db->trans_commit();
								return true;
							}
		


					} else{
						return false;
					}
			}



			fclose($fp) or die("can't close file");
			$data['success']="success";
			$countData = $count-1;

		
		}


	public function update_sede($idLote,$ubicacion){

        $this->db->trans_begin();

		$this->db->query("UPDATE lotes SET ubicacion = ".$ubicacion." WHERE idLote = ".$idLote." ");		


        if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
        }

	}

	function getCommissionPlans(){
        return $this->db->query("SELECT id_opcion, nombre FROM opcs_x_cats WHERE id_catalogo = 39 AND estatus = 1 ORDER BY id_opcion, nombre");
    }
		
	public function getMsni($idProyecto){
		$query = $this->db-> query("SELECT * FROM condominios WHERE status = 1 AND idResidencial =".$idProyecto);
		return $query->result_array();
	}


	public function update_msni($idResidencial) {
		$count=0;
		$datos='';
		$fp = fopen($_FILES['file_msni']['tmp_name'],'r') or die("can't open file");
		while($csv_line = fgetcsv($fp,1024)) {
			$count++;
			if($count == 1)
			{
				continue;
			}
			for($i = 0, $j = count($csv_line); $i < $j; $i++)
			{
				$insert_csv = array();
				$insert_csv['PROYECTO'] = $csv_line[0];
				$insert_csv['MSNI'] = $csv_line[1];
			}
		  
			  $query = $this->db->query("SELECT * FROM condominios WHERE status = 1 AND nombre = '".$insert_csv['PROYECTO']."' AND idResidencial =".$idResidencial)->result_array();
				if (!empty($query)){
					foreach ($query as $row) {
						$this->db->query("UPDATE condominios SET msni = ".$insert_csv['MSNI']." WHERE status = 1 AND idCondominio = ".$row['idCondominio']." ");		
					}		
				}
		}
		fclose($fp) or die("can't close file");
		$data['success']="success";
		$countData = $count-1;
	}

	function getGeneralClientsReport(){
        return $this->db->query("SELECT CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno) nombreCliente,
                                r.nombreResidencial, cn.nombre nombreCondominio, l.nombreLote, l.sup, l.precio, l.totalNeto2, 
                                l.referencia, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor,
                                CONCAT(uu.nombre, ' ', uu.apellido_paterno, ' ', uu.apellido_materno) coordinador,
                                CONCAT(uuu.nombre, ' ', uuu.apellido_paterno, ' ', uuu.apellido_materno) gerente
                                FROM lotes l 
                                INNER JOIN clientes cl ON cl.idLote = l.idLote
                                INNER JOIN condominios cn ON cn.idCondominio = l.idCondominio
                                INNER JOIN residenciales r ON r.idResidencial = cn.idResidencial
                                LEFT JOIN usuarios u ON u.id_usuario = cl.id_asesor
                                LEFT JOIN usuarios uu ON uu.id_usuario = cl.id_coordinador
                                LEFT JOIN usuarios uuu ON uuu.id_usuario = cl.id_gerente
                                WHERE cl.status = 1 AND l.status = 1 AND l.idStatusLote IN (2, 3) ORDER BY r.nombreResidencial, cn.nombre, l.nombreLote");
    }

    function getClientsInStatusFifteen($idCondominio)
    {
        return $this->db->query("SELECT idLote, nombreLote, idStatusContratacion, idMovimiento, condominios.nombre as 
                                nombreCondominio, residenciales.nombreResidencial FROM lotes
                                INNER JOIN condominios ON condominios.idCondominio = lotes.idCondominio
                                INNER JOIN residenciales ON residenciales.idResidencial = condominios.idResidencial
                                WHERE lotes.idCondominio = $idCondominio AND lotes.idStatusContratacion = 15
                                AND lotes.idMovimiento = 45 ORDER BY condominios.nombre");
    }

    function selectRegistroLoteCaja($id)
    {
        $this->db->select('clientes.id_cliente, lotes.nombreLote, lotes.idLote, lotes.usuario user, lotes.perfil, lotes.fechaVenc, 
        lotes.idCondominio, lotes.modificado, lotes.fechaSolicitudValidacion, condominios.nombre, residenciales.nombreResidencial, 
        lotes.contratoArchivo, lotes.fechaRL, lotes.totalNeto, lotes.totalValidado, lotes.totalNeto2');
        $this->db->join('clientes', 'clientes.idLote = lotes.idLote');
        $this->db->join('condominios', 'condominios.idCondominio = lotes.idCondominio');
        $this->db->join('residenciales', 'residenciales.idResidencial = condominios.idResidencial');
        $this->db->where("lotes.idLote", $id);
        $this->db->where("clientes.status", 1);
        $this->db->where("lotes.status", 1);
        $query = $this->db->get('lotes');
        return $query->row();
    }

    function editaRegistroLoteCaja($id, $dato)
    {
        $this->db->where("idLote", $id);
        $this->db->update('lotes', $dato);
        $this->db->join('clientes', 'lotes.idLote = clientes.idLote');
        return true;
    }

    function insertHistorialLotes($dato){
        $this->db->insert('historial_lotes',$dato);
        return true;
    }
	
	
	
	public function val_ub($idLote){
		$this->db->select('ubicacion');
        $this->db->where("idLote",$idLote);
		$this->db->where_in('ubicacion', array('2', '4'));
		$query = $this->db->get('lotes');
		$valida = (empty($query->result())) ? 0 : $query->result_array();
		return $valida;
	}
	
	public function get_id_asig($id){
		$query = $this->db-> query("SELECT contador FROM variables where identificador = $id"); 
		return $query->row();
	}
	
	public function update_asig_jur($id, $id_sede){
		$this->db->query("UPDATE variables SET contador = $id WHERE identificador = $id_sede");		
        return true;
	}
	
	public function get_lp($idLote){
		$query = $this->db-> query("SELECT cl.lugar_prospeccion
        FROM clientes cl where cl.lugar_prospeccion = 6 AND cl.idLote = ".$idLote." "); 
		return $query->row();
	}

	public function getLotesAllAssistant($idCondominio)
		{
			$query = $this->db-> query("SELECT l.* FROM lotes l 
			INNER JOIN clientes c ON c.id_cliente = l.idCliente
			INNER JOIN usuarios u ON u.id_usuario = c.id_asesor AND u.estatus = 0
			WHERE l.status = 1 AND (l.idStatusContratacion = 1 OR l.idMovimiento = 82) AND c.status = 1 AND c.id_gerente = ". $this->session->userdata('id_lider') ." AND l.idCondominio = $idCondominio");
			return $query->result_array();
		}

	public function getLotesTwo($idCondominio)
	{
		$query = $this->db-> query("SELECT * FROM lotes WHERE status = 1 and idCondominio = $idCondominio AND idStatusContratacion IN (1, 2, 3)");
		return $query->result_array();
	}

	public function getLiberacionesInformation($idCondominio) {
        return $this->db->query("SELECT l.idLote, UPPER(l.nombreLote) nombreLote, l.referencia, 
        UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)) nombreCliente,
        cl.fechaApartado, sl.nombre estatusContratacion, sl.color colorEstatusContratacion,
        (CASE l.observacionContratoUrgente WHEN '1' THEN 'En proceso de liberación' ELSE 'Sin definir estatus' END) estatusLiberacion,
        (CASE l.observacionContratoUrgente WHEN '1' THEN '28B463' ELSE '566573' END) colorEstatusLiberacion
        FROM lotes l
        INNER JOIN clientes cl ON cl.id_cliente = l.idCliente AND cl.status = 1
        INNER JOIN statuslote sl ON sl.idStatusLote = l.idStatusLote
		INNER JOIN condominios con ON con.idCondominio=l.idCondominio
        WHERE l.status = 1 AND con.idResidencial = $idCondominio
        UNION ALL
        SELECT l.idLote, UPPER(l.nombreLote) nombreLote, l.referencia, 
        'N/A' nombreCliente,
        '1900-01-01 00:00:00.000' fechaApartado, sl.nombre estatusContratacion, sl.color colorEstatusContratacion,
        (CASE l.observacionContratoUrgente WHEN '1' THEN 'En proceso de liberación' ELSE 'Sin definir estatus' END) estatusLiberacion,
        (CASE l.observacionContratoUrgente WHEN '1' THEN '28B463' ELSE '566573' END) colorEstatusLiberacion
        FROM lotes l
        INNER JOIN statuslote sl ON sl.idStatusLote = l.idStatusLote
		INNER JOIN condominios con ON con.idCondominio=l.idCondominio
		WHERE l.status = 1 AND (l.idCliente IS NULL OR l.idCliente = 0) AND con.idResidencial = $idCondominio ORDER BY l.idLote");
    }

    public function getInformation($beginDate, $endDate) {
        
        $filter = " AND cl.fechaApartado BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59'";

        return $this->db->query("SELECT lotes.referencia, res.nombreResidencial, cond.nombre nombreCondominio, lotes.nombreLote,
		CONCAT(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno) nombreGerente,
		FORMAT(lotes.totalNeto, 'C') enganche, FORMAT(lotes.totalNeto2, 'C') total, cl.fechaApartado, hd.modificado,
		UPPER(CASE CONCAT(u.nombre,' ', u.apellido_paterno, ' ', u.apellido_materno) WHEN '' THEN hd.usuario ELSE 
		CONCAT(u.nombre,' ', u.apellido_paterno, ' ', u.apellido_materno) END) nombreUsuario
		FROM historial_lotes hd
		INNER JOIN clientes cl ON hd.idCliente = cl.id_cliente $filter
		INNER JOIN lotes lotes ON hd.idLote = lotes.idLote AND lotes.status = 1
		INNER JOIN condominios cond ON cond.idCondominio = lotes.idCondominio
		INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
		LEFT JOIN usuarios asesor ON cl.id_asesor = asesor.id_usuario
		LEFT JOIN usuarios coordinador ON cl.id_coordinador = coordinador.id_usuario
		LEFT JOIN usuarios gerente ON cl.id_gerente = gerente.id_usuario
		LEFT JOIN usuarios u ON CAST(u.id_usuario AS VARCHAR(45)) = CAST(hd.usuario AS VARCHAR(45))
		WHERE (hd.idStatusContratacion = 9 and hd.idMovimiento = 39 and cl.status = 1)
		AND hd.status = 1 ORDER BY res.nombreResidencial, cond.nombre, lotes.nombreLote");
    }

    public function updateRecord($table, $data, $key, $value) // MJ: ACTUALIZA LA INFORMACIÓN DE UN REGISTRO EN PARTICULAR, RECIBE 4 PARÁMETROS. TABLA, DATA A ACTUALIZAR, LLAVE (WHERE) Y EL VALOR DE LA LLAVE
	{
		$response = $this->db->update($table, $data, "$key = '$value'");
		if (!$response) {
			return $finalAnswer = 0;
		} else {
			return $finalAnswer = 1;
		}
	}

	public function addRecord($table, $data) // MJ: AGREGA UN REGISTRO A UNA TABLA EN PARTICULAR, RECIBE 2 PARÁMETROS. LA TABLA Y LA DATA A INSERTAR
	{
		if ($data != '' && $data != null) {
			$response = $this->db->insert($table, $data);
			if (!$response) {
				return $finalAnswer = 0;
			} else {
				return $finalAnswer = 1;
			}
		} else {
			return 0;
		}
	}
	

}
