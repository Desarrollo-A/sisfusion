<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Juridico_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
 
	
	public function registroStatusContratacion7 ($typeTransaction = "", $beginDate = "", $endDate = "", $idResidencial = "",$idCondominio = '') {

	    if($this->session->userdata('id_usuario') == 2762 || $this->session->userdata('id_usuario') == 6096){
	    	$whereOne = "";
        	$whereTwo = "";

        	if($typeTransaction == 0) { // SE CORRE FILTRO POR FECHA
	           $whereOne = "AND cl.fechaApartado BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59'";;
	           $whereTwo = "";
	           $number = 150;
            } else if ($typeTransaction == 1) { // VA A CORRER FILTRO POR DESARROLLO
				$complemento = '';
				if($idCondominio != 0 && $idCondominio != ''){
					$complemento = ' AND cond.idCondominio='.$idCondominio; 

				}

                $whereOne = "";
                $whereTwo = "AND res.idResidencial = $idResidencial $complemento";
                $number = 1000;
            }

		$query = $this->db-> query("SELECT TOP($number) l.idLote, cl.id_cliente, cl.fechaApartado, cl.nombre, cl.apellido_paterno, cl.apellido_materno, l.nombreLote, l.idStatusContratacion,
        l.idMovimiento, l.modificado, cl.rfc, CAST(l.comentario AS varchar(MAX)) as comentario, l.fechaVenc, l.perfil, cond.nombre as nombreCondominio, res.nombreResidencial, l.ubicacion,
        l.tipo_venta, cond.idCondominio, l.observacionContratoUrgente as vl, et.descripcion as etapa,
		concat(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) as asesor,
        concat(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno) as coordinador,
        concat(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno) as gerente,
        concat(juridico.nombre,' ', juridico.apellido_paterno, ' ', juridico.apellido_materno) as juridico
		
		FROM lotes l
        INNER JOIN clientes cl ON cl.idLote=l.idLote $whereOne
        INNER JOIN condominios cond ON l.idCondominio=cond.idCondominio
        INNER JOIN residenciales res ON cond.idResidencial=res.idResidencial $whereTwo

		LEFT JOIN etapas et ON et.idEtapa = cond.idEtapa


		LEFT JOIN usuarios asesor ON cl.id_asesor = asesor.id_usuario
		LEFT JOIN usuarios coordinador ON cl.id_coordinador = coordinador.id_usuario
		LEFT JOIN usuarios gerente ON cl.id_gerente = gerente.id_usuario
		LEFT JOIN usuarios juridico ON l.asig_jur = juridico.id_usuario

        WHERE l.idStatusContratacion=6 AND l.idMovimiento=36 AND cl.status=1
        OR l.idStatusContratacion=6 AND l.idMovimiento=6 AND cl.status=1
        OR l.idStatusContratacion=6 AND l.idMovimiento=23 AND cl.status=1
        OR l.idStatusContratacion=6 AND l.idMovimiento=76 AND cl.status=1
        OR l.idStatusContratacion=7 AND l.idMovimiento=83 AND cl.status=1
        OR l.idStatusContratacion=6 AND l.idMovimiento=95 AND cl.status=1
        OR l.idStatusContratacion=6 AND l.idMovimiento=97 AND cl.status=1
        group by 
        l.idLote, cl.id_cliente, cl.fechaApartado, cl.nombre, cl.apellido_paterno, cl.apellido_materno, l.nombreLote, l.idStatusContratacion,
        l.idMovimiento, l.modificado, cl.rfget_users_reassingc, CAST(l.comentario AS varchar(MAX)), l.fechaVenc, l.perfil, cond.nombre, res.nombreResidencial, l.ubicacion,
        l.tipo_venta, cond.idCondominio, l.observacionContratoUrgente, et.descripcion,
		concat(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno),
        concat(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno),
        concat(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno),
		concat(juridico.nombre,' ', juridico.apellido_paterno, ' ', juridico.apellido_materno)
        ORDER BY l.modificado DESC");
		
		} else if(in_array($this->session->userdata('id_usuario'), array("2765", "2776", "10463", "2820", "2876", "10437"))){


			$query = $this->db-> query("SELECT l.idLote, cl.id_cliente, cl.fechaApartado, cl.nombre, cl.apellido_paterno, cl.apellido_materno, l.nombreLote, l.idStatusContratacion,
			l.idMovimiento, l.modificado, cl.rfc, CAST(l.comentario AS varchar(MAX)) as comentario, l.fechaVenc, l.perfil, cond.nombre as nombreCondominio, res.nombreResidencial, l.ubicacion,
			l.tipo_venta, cond.idCondominio, l.observacionContratoUrgente as vl, et.descripcion as etapa,
			concat(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) as asesor,
			concat(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno) as coordinador,
			concat(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno) as gerente,
	        concat(juridico.nombre,' ', juridico.apellido_paterno, ' ', juridico.apellido_materno) as juridico
			FROM lotes l
			INNER JOIN clientes cl ON cl.idLote=l.idLote
			INNER JOIN condominios cond ON l.idCondominio=cond.idCondominio
			INNER JOIN residenciales res ON cond.idResidencial=res.idResidencial
			
			LEFT JOIN etapas et ON et.idEtapa = cond.idEtapa
	
	
			LEFT JOIN usuarios asesor ON cl.id_asesor = asesor.id_usuario
			LEFT JOIN usuarios coordinador ON cl.id_coordinador = coordinador.id_usuario
			LEFT JOIN usuarios gerente ON cl.id_gerente = gerente.id_usuario
			LEFT JOIN usuarios juridico ON l.asig_jur = juridico.id_usuario

			WHERE 
			   l.idStatusContratacion=6 AND l.idMovimiento=36 AND cl.status=1 and l.ubicacion = ".$this->session->userdata('id_sede')." and l.asig_jur = ".$this->session->userdata('id_usuario')."
			OR l.idStatusContratacion=6 AND l.idMovimiento=6 AND cl.status=1 and l.ubicacion = ".$this->session->userdata('id_sede')." and l.asig_jur = ".$this->session->userdata('id_usuario')."
			OR l.idStatusContratacion=6 AND l.idMovimiento=23 AND cl.status=1 and l.ubicacion = ".$this->session->userdata('id_sede')." and l.asig_jur = ".$this->session->userdata('id_usuario')."
			OR l.idStatusContratacion=6 AND l.idMovimiento=76 AND cl.status=1 and l.ubicacion = ".$this->session->userdata('id_sede')." and l.asig_jur = ".$this->session->userdata('id_usuario')."
			OR l.idStatusContratacion=7 AND l.idMovimiento=83 AND cl.status=1 and l.ubicacion = ".$this->session->userdata('id_sede')." and l.asig_jur = ".$this->session->userdata('id_usuario')."
			OR l.idStatusContratacion=6 AND l.idMovimiento=95 AND cl.status=1 and l.ubicacion = ".$this->session->userdata('id_sede')." and l.asig_jur = ".$this->session->userdata('id_usuario')."
			OR l.idStatusContratacion=6 AND l.idMovimiento=97 AND cl.status=1 and l.ubicacion = ".$this->session->userdata('id_sede')." and l.asig_jur = ".$this->session->userdata('id_usuario')."
	
			group by 
			l.idLote, cl.id_cliente, cl.fechaApartado, cl.nombre, cl.apellido_paterno, cl.apellido_materno, l.nombreLote, l.idStatusContratacion,
			l.idMovimiento, l.modificado, cl.rfc, CAST(l.comentario AS varchar(MAX)), l.fechaVenc, l.perfil, cond.nombre, res.nombreResidencial, l.ubicacion,
			l.tipo_venta, cond.idCondominio, l.observacionContratoUrgente, et.descripcion,
			concat(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno),
			concat(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno),
			concat(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno),
			concat(juridico.nombre,' ', juridico.apellido_paterno, ' ', juridico.apellido_materno)
			ORDER BY l.modificado DESC");
			
		} else {

			// if ($this->session->userdata('id_usuario') == 2764) // MJ: JESUS ALFREDO MONTEJANO VER?? LO DE SLP + TIJUANA
			// 	$id_sede = "'".$this->session->userdata('id_sede')."', '8'";
			// else
			$id_sede = "'".$this->session->userdata('id_sede')."'";
		
			$query = $this->db-> query("SELECT l.idLote, cl.id_cliente, cl.fechaApartado, cl.nombre, cl.apellido_paterno, cl.apellido_materno, l.nombreLote, l.idStatusContratacion,
			l.idMovimiento, l.modificado, cl.rfc, CAST(l.comentario AS varchar(MAX)) as comentario, l.fechaVenc, l.perfil, cond.nombre as nombreCondominio, res.nombreResidencial, l.ubicacion,
			l.tipo_venta, cond.idCondominio, l.observacionContratoUrgente as vl, et.descripcion as etapa,
			concat(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) as asesor,
			concat(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno) as coordinador,
			concat(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno) as gerente,
			concat(juridico.nombre,' ', juridico.apellido_paterno, ' ', juridico.apellido_materno) as juridico
			
			FROM lotes l
			INNER JOIN clientes cl ON cl.idLote=l.idLote
			INNER JOIN condominios cond ON l.idCondominio=cond.idCondominio
			INNER JOIN residenciales res ON cond.idResidencial=res.idResidencial
			
			LEFT JOIN etapas et ON et.idEtapa = cond.idEtapa


			LEFT JOIN usuarios asesor ON cl.id_asesor = asesor.id_usuario
			LEFT JOIN usuarios coordinador ON cl.id_coordinador = coordinador.id_usuario
			LEFT JOIN usuarios gerente ON cl.id_gerente = gerente.id_usuario
			LEFT JOIN usuarios juridico ON l.asig_jur = juridico.id_usuario

			WHERE l.idStatusContratacion=6 AND l.idMovimiento=36 AND cl.status=1 and l.ubicacion IN ($id_sede)
			OR l.idStatusContratacion=6 AND l.idMovimiento=6 AND cl.status=1 and l.ubicacion IN ($id_sede)
			OR l.idStatusContratacion=6 AND l.idMovimiento=23 AND cl.status=1 and l.ubicacion IN ($id_sede)
			OR l.idStatusContratacion=6 AND l.idMovimiento=76 AND cl.status=1 and l.ubicacion IN ($id_sede)
			OR l.idStatusContratacion=7 AND l.idMovimiento=83 AND cl.status=1 and l.ubicacion IN ($id_sede)
			OR l.idStatusContratacion=6 AND l.idMovimiento=95 AND cl.status=1 and l.ubicacion IN ($id_sede)
			OR l.idStatusContratacion=6 AND l.idMovimiento=97 AND cl.status=1 and l.ubicacion IN ($id_sede)

			group by 
			l.idLote, cl.id_cliente, cl.fechaApartado, cl.nombre, cl.apellido_paterno, cl.apellido_materno, l.nombreLote, l.idStatusContratacion,
			l.idMovimiento, l.modificado, cl.rfc, CAST(l.comentario AS varchar(MAX)), l.fechaVenc, l.perfil, cond.nombre, res.nombreResidencial, l.ubicacion,
			l.tipo_venta, cond.idCondominio, l.observacionContratoUrgente, et.descripcion,
			concat(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno),
			concat(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno),
			concat(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno),
			concat(juridico.nombre,' ', juridico.apellido_paterno, ' ', juridico.apellido_materno)
			ORDER BY l.modificado DESC");
		
		}
		
		return $query->result();

    }
    

    public function validateSt7($idLote){
        $this->db->where("idLote",$idLote);
		$this->db->where_in('idStatusLote', 3);

		$this->db->where("(idStatusContratacion=6 AND idMovimiento=36
        OR idStatusContratacion=6 AND idMovimiento=6
        OR idStatusContratacion=6 AND idMovimiento=23
        OR idStatusContratacion=6 AND idMovimiento=76
        OR idStatusContratacion=7 AND idMovimiento=83
		OR idStatusContratacion=6 AND idMovimiento=95
		OR idStatusContratacion=6 AND idMovimiento=97)");	

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



	public function getCop($id_cliente){
		$query = $this->db-> query("SELECT id_cliente, nombre, apellido_paterno, apellido_materno
        FROM copropietarios where estatus = 1 and id_cliente = ".$id_cliente." "); 
		return $query->result_array();
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
	
	
	public function get_users_reassing(){
		$query = $this->db->query("SELECT * FROM usuarios WHERE id_usuario IN (2776, 10463, 2765, 2820, 2876, 10437);");
		return $query->result_array();
	}

	public function changeUs($iduser, $idLote){
		$this->db->trans_begin();

		$this->db->query("UPDATE lotes SET asig_jur = ".$iduser." WHERE idLote = ".$idLote." ");		


        if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
        }
	}
	
	public function get_lp($idLote){
		$query = $this->db-> query("SELECT cl.lugar_prospeccion
        FROM clientes cl where cl.lugar_prospeccion = 6 AND cl.idLote = ".$idLote." "); 
		return $query->row();
	}

}
