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
        return $this->db-> query("SELECT idEnganche, historial_enganche.noRecibo, historial_enganche.engancheCliente,
 		historial_enganche.fechaEnganche, lotes.nombreLote, historial_enganche.usuario,
	 	tipopago.tipo, cliente.nombre, cliente.apellido_paterno, 
	 	cliente.apellido_materno, cliente.rfc, historial_enganche.concepto 
	 	from historial_enganche 
	 	inner join lotes on historial_enganche.idLote = lotes.idLote 
	 	inner join tipopago on historial_enganche.idTipoPago = tipopago.idTipoPago 
	 	inner join clientes as cliente on historial_enganche.idCliente = cliente.id_cliente 
	 	where historial_enganche.status = 1 and cliente.status = 1 and historial_enganche.idLote = '".$lote." '");



    }



    public function registroStatusContratacion5 () {
        $query = $this->db-> query("SELECT l.idLote, l.referencia, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
        l.nombreLote, l.idStatusContratacion, l.idMovimiento, CONVERT(varchar,l.modificado,120) as modificado, cl.rfc,
        CAST(l.comentario AS varchar(MAX)) as comentario, CONVERT(VARCHAR,l.fechaVenc,120)as fechaVenc, l.perfil, cond.nombre as nombreCondominio, res.nombreResidencial, l.ubicacion,s.nombre  as sede,
        l.tipo_venta, l.observacionContratoUrgente as vl,
		concat(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) as asesor,
        concat(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno) as coordinador,
        concat(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno) as gerente,
		cond.idCondominio,
		(SELECT UPPER(concat(usuarios.nombre,' ', usuarios.apellido_paterno, ' ', usuarios.apellido_materno))
		FROM historial_lotes left join usuarios on historial_lotes.usuario = CAST(usuarios.id_usuario AS varchar)
		WHERE idHistorialLote =(SELECT MAX(idHistorialLote) FROM historial_lotes WHERE idLote IN (l.idLote) 
		AND (perfil IN ('13', '32', 'contraloria', '17', '70')) AND status = 1)) as lastUc, ISNULL(oxc0.nombre, 'Normal') tipo_proceso,
        cl.proceso, l.ubicacion
        FROM lotes l
        INNER JOIN clientes cl ON cl.id_cliente = l.idCliente AND cl.idLote = l.idLote
        INNER JOIN condominios cond ON l.idCondominio=cond.idCondominio
        INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
		LEFT JOIN usuarios asesor ON cl.id_asesor = asesor.id_usuario
		LEFT JOIN usuarios coordinador ON cl.id_coordinador = coordinador.id_usuario
		LEFT JOIN usuarios gerente ON cl.id_gerente = gerente.id_usuario
		LEFT JOIN sedes s ON cl.id_sede = s.id_sede 
        LEFT JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = cl.proceso AND oxc0.id_catalogo = 97
		WHERE l.status = 1 AND l.idStatusContratacion IN (2) AND l.idMovimiento IN (4, 74, 84, 93, 101, 103) AND cl.status = 1
        GROUP BY l.idLote, l.referencia, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
        l.nombreLote, l.idStatusContratacion, l.idMovimiento, l.modificado, cl.rfc,
        CAST(l.comentario AS varchar(MAX)), l.fechaVenc, l.perfil, cond.nombre, res.nombreResidencial, l.ubicacion,
        l.tipo_venta, l.observacionContratoUrgente,
		concat(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno),
        concat(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno),
        concat(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno),
		cond.idCondominio, s.nombre, ISNULL(oxc0.nombre, 'Normal'), cl.proceso
		ORDER BY l.nombreLote");
        return $query->result_array();
    }

    public function validateSt5($idLote){
        $this->db->where("idLote",$idLote);
        $this->db->where_in('idStatusLote', 3);
        $this->db->where("(idStatusContratacion IN (2, 3) AND idMovimiento IN (4, 74, 84, 93, 101, 103))");
        $query = $this->db->get('lotes');
        $valida = (empty($query->result())) ? 0 : 1;
        return $valida;
    }

    public function updateSt($idLote, $arreglo, $arreglo2){
        $this->db->trans_begin();
        $this->db->where("idLote",$idLote);
        $this->db->update('lotes',$arreglo);

        $this->db->insert('historial_lotes',$arreglo2);

        if ($this->db->trans_status() === FALSE) {
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

    function get_enganches(){
        return $this->db->query("SELECT id_catalogo, id_opcion, nombre FROM opcs_x_cats WHERE id_catalogo IN (104, 103) AND estatus = 1 ORDER BY id_catalogo");
    }

    public function registroStatusContratacion6 () {
        $query = $this->db-> query("SELECT l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
        l.nombreLote, l.idStatusContratacion, l.idMovimiento, convert(varchar,l.modificado,120) as modificado, cl.rfc,
        CAST(l.comentario AS varchar(MAX)) as comentario, convert(varchar,l.fechaVenc,120) as fechaVenc, l.perfil, cond.nombre as nombreCondominio, res.nombreResidencial, l.ubicacion,
        ISNULL(tv.tipo_venta, 'Sin especificar') tipo_venta, l.observacionContratoUrgente as vl,
		concat(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) as asesor,
        concat(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno) as coordinador,
        concat(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno) as gerente,
		cond.idCondominio, cl.expediente, sd.nombre as nombreSede,
		(SELECT concat(usuarios.nombre,' ', usuarios.apellido_paterno, ' ', usuarios.apellido_materno)
		FROM historial_lotes left join usuarios on historial_lotes.usuario = usuarios.id_usuario
		WHERE idHistorialLote = (SELECT MAX(idHistorialLote) FROM historial_lotes WHERE idLote IN (l.idLote) AND (perfil IN ('13', '32', 'contraloria', '17', '70')) AND status = 1)) as lastUc,
        ISNULL(oxc0.nombre, 'Normal') tipo_proceso, l.totalNeto
	    FROM lotes l
        INNER JOIN clientes cl ON cl.id_cliente = l.idCliente AND cl.idLote = l.idLote
        INNER JOIN condominios cond ON l.idCondominio=cond.idCondominio
        INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
		LEFT JOIN usuarios asesor ON cl.id_asesor = asesor.id_usuario
		LEFT JOIN usuarios coordinador ON cl.id_coordinador = coordinador.id_usuario
		LEFT JOIN usuarios gerente ON cl.id_gerente = gerente.id_usuario
		LEFT JOIN sedes sd ON sd.id_sede = l.ubicacion
		LEFT JOIN tipo_venta tv ON tv.id_tventa = l.tipo_venta
        LEFT JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = cl.proceso AND oxc0.id_catalogo = 97
		WHERE l.status = 1 AND l.idStatusContratacion IN ('5', '2') AND l.idMovimiento IN ('35', '22', '62', '75', '94', '106', '108') and cl.status = 1
	    GROUP BY l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
        l.nombreLote, l.idStatusContratacion, l.idMovimiento, l.modificado, cl.rfc,
        CAST(l.comentario AS varchar(MAX)), l.fechaVenc, l.perfil, cond.nombre, res.nombreResidencial, l.ubicacion,
        tv.tipo_venta, l.observacionContratoUrgente,
		concat(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno),
        concat(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno),
        concat(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno),
		cond.idCondominio, cl.expediente, sd.nombre, ISNULL(oxc0.nombre, 'Normal'), l.totalNeto
		ORDER BY l.nombreLote");
        return $query->result();
    }

    public function validateSt6($idLote){
        $this->db->where("idLote",$idLote);
        $this->db->where_in('idStatusLote', 3);
        $this->db->where("(idStatusContratacion IN (5, 2) AND idMovimiento IN (35, 22, 62, 75, 94, 106))");
        $query = $this->db->get('lotes');
        $valida = (empty($query->result())) ? 0 : 1;
        return $valida;
    }

    public function getCorreoSt ($idCliente) {
        $query = $this->db-> query("SELECT STRING_AGG (correo, ',') correos FROM (
			/*ASESOR COORDINADOR GERENTE (TITULAR VENTA) */
			SELECT c.id_cliente, CONCAT(u.correo, ',', uu.correo, ',', uuu.correo) correo FROM clientes c 
			LEFT JOIN usuarios u ON u.id_usuario = c.id_asesor AND u.estatus = 1
			LEFT JOIN usuarios uu ON uu.id_usuario = c.id_coordinador  AND uu.estatus = 1
			LEFT JOIN usuarios uuu ON uuu.id_usuario = c.id_gerente  AND uuu.estatus = 1
			WHERE c.id_cliente = ".$idCliente."
			UNION ALL
			/*ASESOR COORDINADOR GERENTE (VENTAS COMPARTIDAS) */
			SELECT vc.id_cliente, CONCAT(u.correo, ',', uu.correo, ',', uuu.correo) correo FROM ventas_compartidas vc 
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
		$id_sede = $this->session->userdata('id_sede');
		$id_usuario = $this->session->userdata('id_usuario');
	    if(in_array($id_usuario, array(2749, 2807, 2754, 6390, 9775, 2815, 12377, 2799, 10088, 2827, 6012, 12931, 13053)) || $this->session->userdata('id_rol') == 63) // MJ: VE TODO: CI - ARIADNA MARTINEZ MARTINEZ - MARIELA SANCHEZ SANCHEZ
			$filtroSede = "";
		else  if($id_usuario == 9453) // MJ: JARENI HERNANDEZ CASTILLO VE MÉRIDA, SLP, MONTERREY y TEXAS USA
			$filtroSede = "AND l.ubicacion IN ('$id_sede', '1', '3', '11', '10')";
        else  if($id_usuario == 12554) // MJ: MINERVA GARCIA MEDIANA VE MONTERREY Y TEXAS USA
            $filtroSede = "AND l.ubicacion IN ('$id_sede', '10')";
		else if ($id_sede == 3) // CONTRALORÍA PENÍNSULA TAMBIÉN VE EXPEDIENTES DE CANCÚN
			$filtroSede = "AND l.ubicacion IN ('$id_sede', '6')";
		else if ($id_sede == 5) // CONTRALORÍA LEÓN TAMBIÉN VE EXPEDIENTES DE GUADALAJARA
			$filtroSede = "AND l.ubicacion IN ('$id_sede', '12','16')";
       else if ($id_sede == 2) // CONTRALORÍA QUERÉTARO TAMBIÉN VE EXPEDIENTES DE PUEBLA
			$filtroSede = "AND l.ubicacion IN ('$id_sede', '15')";
		else
			$filtroSede = "AND l.ubicacion IN ('$id_sede')";
		
		$query = $this->db-> query("SELECT l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
		l.nombreLote, l.idStatusContratacion, l.idMovimiento, convert(varchar,l.modificado,120) as modificado, cl.rfc, sd.nombre as nombreSede,
		CAST(l.comentario AS varchar(MAX)) as comentario, convert(varchar,l.fechaVenc,120) as fechaVenc, l.perfil, res.nombreResidencial, cond.nombre as nombreCondominio,
		l.ubicacion, ISNULL(tv.tipo_venta, 'Sin especificar') tipo_venta, l.observacionContratoUrgente as vl, cl.tipo_nc residencia,
		concat(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) as asesor,
		concat(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno) as coordinador,
		concat(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno) as gerente,
		cond.idCondominio, ISNULL(oxc0.nombre, 'Normal') tipo_proceso
		FROM lotes l
		INNER JOIN clientes cl ON cl.id_cliente = l.idCliente AND cl.idLote = l.idLote
		INNER JOIN condominios cond ON l.idCondominio=cond.idCondominio
		INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
		LEFT JOIN usuarios asesor ON cl.id_asesor = asesor.id_usuario
		LEFT JOIN usuarios coordinador ON cl.id_coordinador = coordinador.id_usuario
		LEFT JOIN usuarios gerente ON cl.id_gerente = gerente.id_usuario
		LEFT JOIN sedes sd ON sd.id_sede = l.ubicacion
		LEFT JOIN tipo_venta tv ON tv.id_tventa = l.tipo_venta
        LEFT JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = cl.proceso AND oxc0.id_catalogo = 97
		WHERE l.status = 1 AND l.idStatusContratacion IN (8, 11) AND l.idMovimiento IN (38, 65, 41) 
		AND l.status8Flag = 1 AND l.validacionEnganche != 'NULL' AND l.validacionEnganche IS NOT NULL
		AND (l.totalNeto2 = 0.00 OR l.totalNeto2 = '0.00' OR l.totalNeto2 <= 0.00 OR l.totalNeto2 IS NULL)
		AND cl.status = 1 $filtroSede
		GROUP BY l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
		l.nombreLote, l.idStatusContratacion, l.idMovimiento, l.modificado, cl.rfc, cl.tipo_nc,sd.nombre,
		CAST(l.comentario AS varchar(MAX)), l.fechaVenc, l.perfil, cond.nombre, res.nombreResidencial, l.ubicacion,
		tv.tipo_venta, l.observacionContratoUrgente,
		concat(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno),
		concat(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno),
		concat(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno),
		cond.idCondominio, ISNULL(oxc0.nombre, 'Normal')
		ORDER BY l.nombreLote");
        return $query->result();
    }

    public function validateSt9($idLote){
        $this->db->where("idLote",$idLote);
        $this->db->where_in('idStatusLote', 3);
        $this->db->where("(idStatusContratacion IN (8, 11) AND idMovimiento IN (38, 65, 41))");
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
/**---------------------------------------------------------- */
public function selectRegistroPorContrato_2($numContrato){

	$this->db->select("cl.id_cliente, l.nombreLote, l.idLote, l.usuario, l.perfil, l.fechaVenc, l.idCondominio,
	l.modificado, l.fechaSolicitudValidacion, cl.nombre, cl.apellido_paterno, cl.apellido_materno, 
	cl.rfc, l.contratoUrgente, l.observacionContratoUrgente, l.observacionContratoUrgente as vl,
	l.fechaRL, l.idStatusContratacion, l.idMovimiento,l.numContrato");
	$this->db->join('clientes cl', 'cl.idLote = l.idLote');
	$this->db->where("l.idLote",$numContrato);
	

	$this->db->where("(idStatusContratacion IN (8, 11) AND idMovimiento IN (38, 65, 41) AND status8Flag = 1 AND (validacionEnganche != 'NULL' OR validacionEnganche IS NOT NULL))");
	$this->db->where('l.status', 1);
	$query = $this->db->get('lotes l');
	return $query->row();

}
public function updateSt10_2($contrato,$arreglo,$arreglo2,$data3,$id,$folioUp){

	$this->db->trans_begin();

	$this->db->where("idLote", $contrato);
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

/**---------------------------------------------------------- */
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
        $id_sede = $this->session->userdata('id_sede');
        $id_usuario = $this->session->userdata('id_usuario');
        if(in_array($id_usuario, array(2749, 2807, 2754, 6390, 9775, 2815, 12377, 2799, 10088, 2827, 6012, 12931, 13053)) || $this->session->userdata('id_rol') == 63) // MJ: VE TODO: CI - ARIADNA MARTINEZ MARTINEZ - MARIELA SANCHEZ SANCHEZ
            $filtroSede = "";
        else  if($id_usuario == 9453) // MJ: JARENI HERNANDEZ CASTILLO VE MÉRIDA, SLP, MONTERRE Y TEXAS USA
            $filtroSede = "AND l.ubicacion IN ('$id_sede', '1', '3', '11', '10')";
        else if ($id_sede == 3) // CONTRALORÍA PENÍNSULA TAMBIÉN VE EXPEDIENTES DE CANCÚN
            $filtroSede = "AND l.ubicacion IN ('$id_sede', '6')";
        else if ($id_sede == 5) // CONTRALORÍA LEÓN TAMBIÉN VE EXPEDIENTES DE GUADALAJARA
            $filtroSede = "AND l.ubicacion IN ('$id_sede', '12','16')";
        else if ($id_sede == 4) // CONTRALORÍA CIUDAD DE MÉXICO TAMBIÉN VE EXPEDIENTES DE PUEBLA
			$filtroSede = "AND l.ubicacion IN ('$id_sede', '15')";
        else
            $filtroSede = "AND l.ubicacion IN ('$id_sede')";

        $query = $this->db-> query("SELECT l.idLote, cl.id_cliente, l.validacionEnganche, l.firmaRL,
		l.nombreLote, l.idStatusContratacion, l.idMovimiento, l.perfil, cond.nombre as nombreCondominio, se.nombre as nombreSede,
		res.nombreResidencial, l.ubicacion, ISNULL(tv.tipo_venta, 'Sin especificar') tipo_venta, l.numContrato, l.observacionContratoUrgente as vl,
		CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno) nombreCliente,opx.nombre RL, ISNULL(oxc0.nombre, 'Normal') tipo_proceso
		FROM lotes l
		INNER JOIN clientes cl ON cl.idLote = l.idLote
		INNER JOIN condominios cond ON l.idCondominio = cond.idCondominio
		INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
		LEFT JOIN opcs_x_cats opx ON cl.rl  = opx.id_opcion AND opx.id_catalogo = 77
		LEFT JOIN sedes se ON se.id_sede = l.ubicacion
		LEFT JOIN tipo_venta tv ON tv.id_tventa = l.tipo_venta
        LEFT JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = cl.proceso AND oxc0.id_catalogo = 97
		WHERE l.status = 1 AND l.idStatusContratacion IN (9) AND l.idMovimiento IN (39, 26) AND cl.status = 1 $filtroSede
		GROUP BY l.idLote, cl.id_cliente, l.validacionEnganche, l.firmaRL,
		l.nombreLote, l.idStatusContratacion, l.idMovimiento, l.perfil, cond.nombre, se.nombre,
		res.nombreResidencial, l.ubicacion, tv.tipo_venta, l.numContrato, l.observacionContratoUrgente,
		CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno), opx.nombre, ISNULL(oxc0.nombre, 'Normal')
		ORDER BY l.nombreLote");
        return $query->result();
    }

    public function registroStatusContratacion13 () {
		$id_sede = $this->session->userdata('id_sede');
		$id_usuario = $this->session->userdata('id_usuario');
		if(in_array($id_usuario, array(2749, 2807, 2754, 6390, 9775, 2815, 2826, 2799, 12377, 10088, 2827, 6012, 12931, 13053)) || $this->session->userdata('id_rol') == 63) // MJ: VE TODO: CI - ARIADNA MARTINEZ MARTINEZ - MARIELA SANCHEZ SANCHEZ
			$filtroSede = "";
		else  if($id_usuario == 9453) // MJ: JARENI HERNANDEZ CASTILLO VE MÉRIDA, SLP, MONTERREY Y TEXAS USA
			$filtroSede = "AND l.ubicacion IN ('$id_sede', '1', '3', '11', '10')";
		else if ($id_sede == 3) // CONTRALORÍA PENÍNSULA TAMBIÉN VE EXPEDIENTES DE CANCÚN
			$filtroSede = "AND l.ubicacion IN ('$id_sede', '6')";
		else if ($id_sede == 5) // CONTRALORÍA LEÓN TAMBIÉN VE EXPEDIENTES DE GUADALAJARA
			$filtroSede = "AND l.ubicacion IN ('$id_sede', '12','16')";
        else if ($id_sede == 4) // CONTRALORÍA CIUDAD DE MÉXICO TAMBIÉN VE EXPEDIENTES DE PUEBLA
			$filtroSede = "AND l.ubicacion IN ('$id_sede', '15')";
		else
			$filtroSede = "AND l.ubicacion IN ('$id_sede')";

        $query = $this->db-> query("SELECT l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
		l.nombreLote, l.idStatusContratacion, l.idMovimiento, CONVERT(VARCHAR,l.modificado,120) as modificado, cl.rfc,
		UPPER(CAST(l.comentario AS varchar(MAX))) as comentario, CONVERT(VARCHAR,l.fechaVenc,120) as fechaVenc, l.perfil, res.nombreResidencial, cond.nombre as nombreCondominio,
		l.ubicacion, ISNULL(tv.tipo_venta, 'Sin especificar') tipo_venta, l.firmaRL, l.validacionEnganche, 
		concat(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) as asesor,
		concat(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno) as coordinador,
		concat(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno) as gerente,opx.nombre as RL,
		cond.idCondominio, l.observacionContratoUrgente as vl, se.nombre as nombreSede, ISNULL(oxc0.nombre, 'Normal') tipo_proceso
		FROM lotes l
		INNER JOIN clientes cl ON cl.id_cliente = l.idCliente AND cl.idLote = l.idLote
		INNER JOIN condominios cond ON l.idCondominio=cond.idCondominio
		INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
		LEFT JOIN usuarios asesor ON cl.id_asesor = asesor.id_usuario
		LEFT JOIN usuarios coordinador ON cl.id_coordinador = coordinador.id_usuario
		LEFT JOIN usuarios gerente ON cl.id_gerente = gerente.id_usuario
		LEFT JOIN opcs_x_cats opx ON cl.rl  = opx.id_opcion AND opx.id_catalogo = 77
		LEFT JOIN sedes se ON se.id_sede = l.ubicacion
		LEFT JOIN tipo_venta tv ON tv.id_tventa = l.tipo_venta
        LEFT JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = cl.proceso AND oxc0.id_catalogo = 97
		WHERE l.status = 1 AND l.idStatusContratacion IN (12, 11, 10) AND l.idMovimiento IN (42, 41, 40) 
		AND l.status8Flag = 1 AND l.validacionEnganche != 'NULL' AND l.validacionEnganche IS NOT NULL
		AND l.totalNeto2 != 0.00 AND l.totalNeto2 != '0.00' AND l.totalNeto2 > 0.00
		AND cl.status = 1 $filtroSede
		GROUP BY l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
		l.nombreLote, l.idStatusContratacion, l.idMovimiento, l.modificado, cl.rfc,
		CAST(l.comentario AS varchar(MAX)), l.fechaVenc, l.perfil, cond.nombre, res.nombreResidencial, l.ubicacion,
		tv.tipo_venta, l.firmaRL, l.validacionEnganche,
		concat(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno),
		concat(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno),
		concat(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno),  opx.nombre ,
		cond.idCondominio, l.observacionContratoUrgente, se.nombre, ISNULL(oxc0.nombre, 'Normal')
		ORDER BY l.nombreLote");
        return $query->result();
    }

    public function validateSt13($idLote){
        $this->db->where("idLote",$idLote);
        $this->db->where_in('idStatusLote', 3);
        $this->db->where("(idStatusContratacion IN (12, 11, 10) AND idMovimiento IN (42, 41, 40))");
        $query = $this->db->get('lotes');
        $valida = (empty($query->result())) ? 0 : 1;
        return $valida;
    }

    public function registroStatusContratacion15 () {
        $id_sede = $this->session->userdata('id_sede');
        $id_usuario = $this->session->userdata('id_usuario');
        if(in_array($id_usuario, array(2749, 2807, 2754, 6390, 9775, 2815, 12377, 2799, 10088, 2827, 6012, 12931, 13053)) || $this->session->userdata('id_rol') == 63) // MJ: VE TODO: CI - ARIADNA MARTINEZ MARTINEZ - MARIELA SANCHEZ SANCHEZ
            $filtroSede = "";
        else  if($id_usuario == 9453) // MJ: JARENI HERNANDEZ CASTILLO VE MÉRIDA, SLP, MONTERREY Y TEXAS USA
            $filtroSede = "AND l.ubicacion IN ('$id_sede', '1', '3', '11', '10')";
        else  if($id_usuario == 12554) // MJ: MINERVA GARCIA MEDIANA VE MONTERREY Y TEXAS USA
            $filtroSede = "AND l.ubicacion IN ('$id_sede', '10')";
        else if ($id_sede == 3) // CONTRALORÍA PENÍNSULA TAMBIÉN VE EXPEDIENTES DE CANCÚN
            $filtroSede = "AND l.ubicacion IN ('$id_sede', '6')";
        else if ($id_sede == 5) // CONTRALORÍA LEÓN TAMBIÉN VE EXPEDIENTES DE GUADALAJARA
            $filtroSede = "AND l.ubicacion IN ('$id_sede', '12','16')";
        else if ($id_sede == 4) // CONTRALORÍA CIUDAD DE MÉXICO TAMBIÉN VE EXPEDIENTES DE PUEBLA
			$filtroSede = "AND l.ubicacion IN ('$id_sede', '15')";
        else
            $filtroSede = "AND l.ubicacion IN ('$id_sede')";
        $query = $this->db-> query("SELECT l.idLote, cl.id_cliente, cl.nombre, ISNULL(cl.apellido_paterno, '') apellido_paterno, ISNULL(cl.apellido_materno, '') apellido_materno,
		l.nombreLote, l.idStatusContratacion, l.idMovimiento, CONVERT(VARCHAR,l.modificado,120) as modificado, cl.rfc,
		UPPER(CAST(l.comentario AS varchar(MAX))) as comentario, CONVERT(VARCHAR,l.fechaVenc,120) as fechaVenc, l.perfil, res.nombreResidencial, cond.nombre as nombreCondominio,
		l.ubicacion, ISNULL(tv.tipo_venta, 'Sin especificar') tipo_venta, l.firmaRL, l.validacionEnganche,
		concat(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) as asesor,
		concat(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno) as coordinador,
		concat(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno) as gerente,
		cond.idCondominio, l.observacionContratoUrgente as vl, se.nombre as nombreSede,
        CONVERT(VARCHAR(23), GETDATE(), 23) as fecha_arcus, cl.id_prospecto, l.totalNeto2, pro.id_arcus,
        ISNULL(oxc0.nombre, 'Normal') tipo_proceso
		FROM lotes l
		INNER JOIN clientes cl ON cl.id_cliente = l.idCliente AND cl.idLote = l.idLote
		INNER JOIN condominios cond ON l.idCondominio=cond.idCondominio
		INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
		LEFT JOIN usuarios asesor ON cl.id_asesor = asesor.id_usuario
		LEFT JOIN usuarios coordinador ON cl.id_coordinador = coordinador.id_usuario
		LEFT JOIN usuarios gerente ON cl.id_gerente = gerente.id_usuario
		LEFT JOIN sedes se ON se.id_sede = l.ubicacion
		LEFT JOIN tipo_venta tv ON tv.id_tventa = l.tipo_venta
        LEFT JOIN prospectos pro ON cl.id_prospecto = pro.id_prospecto
        LEFT JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = cl.proceso AND oxc0.id_catalogo = 97
		WHERE l.status = 1 AND l.idStatusContratacion IN (14) AND l.idMovimiento IN (44, 69, 80) AND cl.status = 1 $filtroSede
		GROUP BY l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
		l.nombreLote, l.idStatusContratacion, l.idMovimiento, l.modificado, cl.rfc,
		CAST(l.comentario AS varchar(MAX)), l.fechaVenc, l.perfil, cond.nombre, res.nombreResidencial, l.ubicacion,
		tv.tipo_venta, l.firmaRL, l.validacionEnganche,
		concat(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno),
		concat(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno),
		concat(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno),
		cond.idCondominio, l.observacionContratoUrgente, se.nombre, cl.id_prospecto, l.totalNeto2, pro.id_arcus, ISNULL(oxc0.nombre, 'Normal')
		ORDER BY l.nombreLote");
        return $query->result();
    }

    public function validateSt15($idLote) {
        $this->db->where("idLote",$idLote);
        $this->db->where_in('idStatusLote', 3);
        $this->db->where("(idStatusContratacion IN (14) AND idMovimiento IN (44, 69, 80))");
        $query = $this->db->get('lotes');
        $valida = (empty($query->result())) ? 0 : 1;
        return $valida;
    }


    public function getAllDsByLote($idLote) {
        $query = $this->db->query("	SELECT cl.id_cliente, id_asesor, id_coordinador, id_gerente, cl.id_sede, cl.nombre, cl.apellido_paterno,
			cl.apellido_materno, cl.status, cl.idLote, fechaApartado, fechaVencimiento, cl.usuario, cond.idCondominio, cl.fecha_creacion,
			cl.creado_por, cl.fecha_modificacion, cl.modificado_por, cond.nombre AS nombreCondominio, residencial.nombreResidencial AS nombreResidencial,
			cl.status, nombreLote, lotes.comentario, lotes.idMovimiento, lotes.fechaVenc, lotes.modificado
			FROM deposito_seriedad AS ds
			INNER JOIN clientes AS cl ON ds.id_cliente = cl.id_cliente
			INNER JOIN lotes AS lotes ON lotes.idLote=cl.idLote AND lotes.idCliente = cl.id_cliente AND cl.status = 1
			LEFT JOIN condominios AS cond ON lotes.idCondominio=cond.idCondominio
			LEFT JOIN residenciales AS residencial ON cond.idResidencial=residencial.idResidencial
			WHERE idStatusContratacion IN (1, 2, 3) AND idMovimiento IN (31, 85, 20, 63, 73, 82, 92, 96) AND cl.status = 1 AND cl.idLote = $idLote
			ORDER BY cl.id_Cliente ASC");
        return $query->result_array();
    }

    public function getLotes($idCondominio)
    {
        $query = $this->db-> query("SELECT * FROM lotes WHERE status = 1 and idCondominio=".$idCondominio);
        return $query->result_array();
    }

    public function aplicaLiberaciones($idResidencial) {

        $this->db->trans_begin();
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

            $query = $this->db->query("SELECT idLote FROM lotes
											INNER JOIN condominios ON condominios.idCondominio = lotes.idCondominio 
											INNER JOIN residenciales ON residenciales.idResidencial = condominios.idResidencial 
											WHERE residenciales.idResidencial = ".$idResidencial." 
											AND condominios.nombre = '".$insert_csv['condominio']."'
											AND lotes.nombreLote = '".$insert_csv['nombreLote']."' AND lotes.status = 1")->result_array();
            if (!empty($query)){

                foreach ($query as $row) {
                    $datos.= $row['idLote'].',';
                }


                $datos = trim($datos, ',');

                $this->db->trans_begin();
                $this->db->query("UPDATE lotes SET observacionContratoUrgente = 1 WHERE status = 1 AND idLote IN (".$datos.") ");

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

    public function getMsni($typeTransaction, $key) {
        if($typeTransaction == 1) {
            $query = $this->db-> query("SELECT co.idCondominio ID, co.nombre, lo.msi msni FROM condominios co 
			INNER JOIN lotes lo ON lo.idCondominio = co.idCondominio AND lo.status = 1
			WHERE co.status = 1 AND co.idResidencial = $key
			GROUP BY co.idCondominio, co.nombre, lo.msi ORDER BY co.idCondominio");
        } else if($typeTransaction == 2) {
            $query = $this->db-> query("SELECT *, idLote as ID, nombreLote as nombre, msi as msni FROM lotes WHERE status = 1 AND idCondominio =".$key);
        }
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
		l.referencia, 
		CASE WHEN u.nombre IS NULL THEN 'SIN ESPECIFICAR' ELSE CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) END asesor,
		CASE WHEN uu.nombre IS NULL THEN 'SIN ESPECIFICAR' ELSE CONCAT(uu.nombre, ' ', uu.apellido_paterno, ' ', uu.apellido_materno) END  coordinador,
		CASE WHEN uuu.nombre IS NULL THEN 'SIN ESPECIFICAR' ELSE CONCAT(uuu.nombre, ' ', uuu.apellido_paterno, ' ', uuu.apellido_materno) END gerente,
		CASE WHEN sb.nombre IS NULL THEN 'SIN ESPECIFICAR' ELSE CONCAT(sb.nombre, ' ', sb.apellido_paterno, ' ', sb.apellido_materno)END subdirector,
        CASE WHEN dr.nombre IS NULL THEN 'SIN ESPECIFICAR' ELSE CONCAT(dr.nombre, ' ', dr.apellido_paterno, ' ', dr.apellido_materno) END dRegional,
        CASE WHEN dr2.nombre IS NULL THEN 'SIN ESPECIFICAR' ELSE CONCAT(dr2.nombre, ' ', dr2.apellido_paterno, ' ', dr2.apellido_materno) END dRegional2
		FROM lotes l 
		INNER JOIN clientes cl ON cl.idLote = l.idLote
		INNER JOIN condominios cn ON cn.idCondominio = l.idCondominio
		INNER JOIN residenciales r ON r.idResidencial = cn.idResidencial
		LEFT JOIN usuarios u ON u.id_usuario = cl.id_asesor
		LEFT JOIN usuarios uu ON uu.id_usuario = cl.id_coordinador
		LEFT JOIN usuarios uuu ON uuu.id_usuario = cl.id_gerente
		LEFT JOIN usuarios sb ON sb.id_usuario = cl.id_subdirector
        LEFT JOIN usuarios dr ON dr.id_usuario = cl.id_regional
        LEFT JOIN usuarios dr2 ON dr2.id_usuario = cl.id_regional_2
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
        $this->db->where_in('ubicacion', array('1', '2', '4', '5', '3'));
        $query = $this->db->get('lotes');
        $valida = (empty($query->result())) ? array(0 => array('ubicacion' => 0)) : $query->result_array();
        return $valida;
    }

    public function get_id_asig($id){
        $query = $this->db->query("SELECT contador FROM variables where identificador = $id");
        return $query->row();
    }

    public function update_asig_jur($id, $id_sede){
        $this->db->query("UPDATE variables SET contador = $id WHERE identificador = $id_sede");
        return true;
    }

    public function get_lp($idLote){
        $query = $this->db-> query("SELECT cl.lugar_prospeccion
        FROM clientes cl 
        INNER JOIN prospectos pr ON pr.id_prospecto = cl.id_prospecto AND pr.fecha_creacion <= '2022-01-20 00:00:00.000'
        WHERE cl.lugar_prospeccion = 6 AND cl.idLote = $idLote AND cl.status = 1");
        return $query->row();
    }

    public function getLotesAllAssistant($idCondominio) {
        $id_lider = $this->session->userdata('id_lider');
        $query = $this->db-> query("SELECT l.* FROM lotes l 
		INNER JOIN clientes c ON c.id_cliente = l.idCliente
		INNER JOIN usuarios u ON u.id_usuario = c.id_asesor AND u.estatus IN (0, 1, 3)
		WHERE l.status = 1 AND l.idStatusContratacion IN (1, 2, 3) AND l.idMovimiento IN (31, 85, 20, 63, 73, 82, 92, 96) 
		AND c.status = 1 AND c.id_gerente = $id_lider AND l.idCondominio = $idCondominio
		UNION ALL
        SELECT l.* FROM lotes l 
		INNER JOIN clientes c ON c.id_cliente = l.idCliente AND c.id_coordinador IN (2562, 2541) AND c.id_asesor != 1908
		INNER JOIN usuarios u ON u.id_usuario = c.id_asesor
		INNER JOIN usuarios uu ON uu.id_usuario = u.id_lider AND (uu.id_lider = $id_lider OR u.id_lider = $id_lider)
        WHERE l.status = 1 AND l.idStatusContratacion IN (1, 2, 3) AND l.idMovimiento IN (31, 85, 20, 63, 73, 82, 92, 96) AND c.status = 1 AND l.idCondominio = $idCondominio");
        return $query->result_array();
    }

    public function getLotesTwo($idCondominio) {
        $query = $this->db-> query("SELECT * FROM lotes lo
		INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente AND cl.idLote = lo.idLote AND cl.status = 1 AND cl.id_asesor IN (2541, 2562, 2583, 2551, 2572, 2593, 2591, 2570, 2549)
		WHERE lo.status = 1 AND lo.idCondominio = $idCondominio AND lo.idStatusContratacion IN (1, 2, 3) 
		AND lo.idMovimiento IN (31, 85, 20, 63, 73, 82, 92, 96)");
        return $query->result_array();
    }

    public function getLiberacionesInformation($idCondominio) {
        return $this->db->query(" SELECT l.idLote, UPPER(l.nombreLote) nombreLote, l.referencia, 
        UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)) nombreCliente,
        cl.fechaApartado, sl.nombre estatusContratacion, sl.color colorEstatusContratacion, 
        (CASE l.observacionContratoUrgente WHEN '1' THEN 'En proceso de liberación' ELSE 'Sin definir estatus' END) estatusLiberacion, 
        (CASE l.observacionContratoUrgente WHEN '1' THEN '28B463' ELSE '566573' END) colorEstatusLiberacion, con.idResidencial, con.idCondominio, con.nombre, res.nombreResidencial, cl.id_cliente
        FROM lotes l
		
        INNER JOIN clientes cl ON cl.id_cliente = l.idCliente AND cl.status = 1
        INNER JOIN statuslote sl ON sl.idStatusLote = l.idStatusLote
        INNER JOIN condominios con ON con.idCondominio = l.idCondominio AND con.idCondominio = 164
		INNER JOIN residenciales AS res ON con.idResidencial = res.idResidencial
        WHERE l.status = 1
        AND l.idLote NOT IN (
            SELECT idLote
			FROM historial_liberacion_lotes AS hl
			WHERE id_proceso <> 0 AND fecha_modificacion = (SELECT MAX(fecha_modificacion) FROM historial_liberacion_lotes WHERE idLote = hl.idLote)
        )
        UNION ALL
        SELECT l.idLote, UPPER(l.nombreLote) nombreLote, l.referencia, 
                'N/A' nombreCliente,
                '1900-01-01 00:00:00.000' fechaApartado, sl.nombre estatusContratacion, sl.color colorEstatusContratacion,
                (CASE l.observacionContratoUrgente WHEN '1' THEN 'En proceso de liberación' ELSE 'Sin definir estatus' END) estatusLiberacion,
                (CASE l.observacionContratoUrgente WHEN '1' THEN '28B463' ELSE '566573' END) colorEstatusLiberacion, con.idResidencial, con.idCondominio, con.nombre, res.nombreResidencial, cl.id_cliente
        FROM lotes l
		
		 INNER JOIN clientes cl ON cl.id_cliente = l.idCliente AND cl.status = 1
        INNER JOIN statuslote sl ON sl.idStatusLote = l.idStatusLote
        INNER JOIN condominios con ON con.idCondominio = l.idCondominio AND con.idCondominio = 164
		INNER JOIN residenciales AS res ON con.idResidencial = res.idResidencial
        WHERE l.status = 1
        AND (l.idCliente IS NULL OR l.idCliente = 0)
        AND l.idLote NOT IN (
            SELECT idLote
			FROM historial_liberacion_lotes AS hl
			WHERE id_proceso <> 0 AND fecha_modificacion = (SELECT MAX(fecha_modificacion) FROM historial_liberacion_lotes WHERE idLote = hl.idLote)
        )
        ORDER BY l.idLote");
    }

    public function getInformation($beginDate, $endDate) {
        $filter = " AND cl.fechaApartado BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59'";
        return $this->db->query("SELECT lotes.referencia, res.nombreResidencial, cond.nombre nombreCondominio, lotes.nombreLote,
		CONCAT(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno) nombreGerente,
		FORMAT(lotes.totalNeto, 'C') enganche, FORMAT(lotes.totalNeto2, 'C') total, CONVERT(VARCHAR,cl.fechaApartado,120) AS fechaApartado, CONVERT(VARCHAR,hd.modificado,120) AS modificado,
		UPPER(CASE CONCAT(u.nombre,' ', u.apellido_paterno, ' ', u.apellido_materno) WHEN '' THEN hd.usuario ELSE 
		CONCAT(u.nombre,' ', u.apellido_paterno, ' ', u.apellido_materno) END) nombreUsuario, hd.comentario, UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno )) nombreCliente,
        cl.id_cliente_reubicacion, ISNULL(CONVERT(varchar, cl.fechaAlta, 20), '') fechaAlta
		FROM historial_lotes hd
		INNER JOIN clientes cl ON hd.idCliente = cl.id_cliente $filter
		INNER JOIN lotes lotes ON hd.idLote = lotes.idLote AND lotes.status = 1
		INNER JOIN condominios cond ON cond.idCondominio = lotes.idCondominio
		INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
		LEFT JOIN usuarios asesor ON cl.id_asesor = asesor.id_usuario
		LEFT JOIN usuarios coordinador ON cl.id_coordinador = coordinador.id_usuario
		LEFT JOIN usuarios gerente ON cl.id_gerente = gerente.id_usuario
		LEFT JOIN usuarios u ON CAST(u.id_usuario AS VARCHAR(45)) = CAST(hd.usuario AS VARCHAR(45))
        LEFT JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = cl.proceso AND oxc0.id_catalogo = 97
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

    function get_datos_lotes($lote){
        return $this->db->query("SELECT res.nombreResidencial as desarrollo, con.nombre as condominio, lot.idLote, lot.nombreLote,
		    	CONCAT(cli.nombre,' ',cli.apellido_paterno,' ',cli.apellido_materno) as cliente, cli.fechaApartado,
		    	CONCAT(asesor.nombre,' ',asesor.apellido_paterno,' ',asesor.apellido_materno) as asesor,
		    	CONCAT(coordinador.nombre,' ',coordinador.apellido_paterno,' ',coordinador.apellido_materno) as coordinador,
		    	CONCAT(gerente.nombre,' ',gerente.apellido_paterno,' ',gerente.apellido_materno) as gerente,
                CASE WHEN u3.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)) END subdirector,
                CASE WHEN u4.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)) END regional,
                CASE WHEN u5.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u5.nombre, ' ', u5.apellido_paterno, ' ', u5.apellido_materno)) END regional2,
		    	FORMAT(ISNULL(lot.totalValidado, 0), 'C') as enganche,FORMAT(ISNULL(lot.totalNeto, 0), 'C') as engancheContra, lot.ubicacion, CONCAT('', FORMAT(lot.totalNeto2, 'C', 'en-US')) as saldo, s.id_sede, s.nombre as nombre_ubicacion,
		    	sl.nombre as lote, sc.nombreStatus as contratacion,
		    	(CASE WHEN hl.idLote IS NULL THEN 0 ELSE 1 END) validacion_estatus_9,lot.registro_comision
		    FROM clientes cli
		    	INNER JOIN lotes lot ON lot.idLote = cli.idLote
		    	LEFT JOIN sedes s ON s.id_sede = lot.ubicacion
		    	LEFT JOIN statuslote sl ON sl.idStatusLote = lot.idStatusLote
		    	LEFT JOIN statuscontratacion sc ON sc.idStatusContratacion = lot.idStatusContratacion
		    	INNER JOIN condominios con ON con.idCondominio = lot.idCondominio
		    	INNER JOIN residenciales res ON res.idResidencial = con.idResidencial
                LEFT JOIN usuarios u3 ON u3.id_usuario = cli.id_subdirector
                LEFT JOIN usuarios u4 ON u4.id_usuario = cli.id_regional
                LEFT JOIN usuarios u5 ON u5.id_usuario = cli.id_regional_2
		    	LEFT JOIN usuarios asesor ON cli.id_asesor = asesor.id_usuario
		    	LEFT JOIN usuarios coordinador ON cli.id_coordinador = coordinador.id_usuario
		    	LEFT JOIN usuarios gerente ON cli.id_gerente = gerente.id_usuario
		    	LEFT JOIN (SELECT idLote, idCliente, MAX(modificado) modificado 
		    				FROM historial_lotes WHERE idStatusContratacion = 9 AND idMovimiento = 39 GROUP BY idLote, idCliente) hl 
		    				ON hl.idLote = lot.idLote AND hl.idCliente = cli.id_cliente
        
		    WHERE cli.status = 1 AND cli.idLote = ".$lote."");
    }

    public function get_archivos_lote($lote) {
        $this->db->select('*');
        $this->db->from('archivos_liberacion');
        $this->db->where('idLote', $lote);

        $query = $this->db->get();

        return $query->result(); // Devuelve los resultados como un arreglo de objetos
    }

    public function subir_archivo_lote()
    {
        $config['upload_path']          = './uploads/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 100;
        $config['max_width']            = 1024;
        $config['max_height']           = 768;

        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('userfile'))
        {
                $error = array('error' => $this->upload->display_errors());
                $this->load->view('upload_form', $error);
        }
        else
        {
                $data = array('upload_data' => $this->upload->data());
                $this->load->view('upload_success', $data);
        }
    }

    public function get_tipo_liberaciones() {
        $this->db->select('
            cats.id_catalogo, 
            cats.nombre as nombre_cat, 
            cats.estatus as status_cat, 
            cats.fecha_creacion as fecha_creacion_cat, 
            opcs.id_opcion, 
            opcs.nombre as nombre_opc, 
            opcs.estatus as status_opc, 
            opcs.fecha_creacion as fecha_creacion_opc'
        );
        $this->db->from('catalogos as cats');
        $this->db->join('opcs_x_cats as opcs', 'cats.id_catalogo = opcs.id_catalogo');
        $this->db->where('cats.id_catalogo', 107);
        $this->db->where('cats.estatus', 1);
        $this->db->where('opcs.estatus', 1);
        $this->db->order_by('cats.id_catalogo', 'ASC');

        $query = $this->db->get();
        return $result = $query->result();
    }   

    public function get_catalogo($id_catalogo){
        
        $query = $this->db->query("SELECT * FROM opcs_x_cats WHERE id_catalogo = $id_catalogo AND estatus = 1");
        
        return $query->result_array();
    }

    function get_sedes_lista(){
        return $this->db->query("SELECT * FROM sedes WHERE estatus = 1");
    }

    public function getDetalleCamposHistorialDS($idCliente, $columna)
    {
        $query = $this->db->query("SELECT au.anterior, au.nuevo, au.col_afect, CONVERT(NVARCHAR, au.fecha_creacion, 6) AS fecha,
            (CASE WHEN u.id_usuario IS NOT null THEN CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) 
            WHEN u2.id_usuario IS NOT null THEN CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno) 
                ELSE au.creado_por END) usuario
            FROM auditoria au
            LEFT JOIN usuarios u ON CAST(au.creado_por AS VARCHAR(45)) = CAST(u.id_usuario AS VARCHAR(45))
            LEFT JOIN usuarios u2 ON SUBSTRING(u2.usuario, 1, 20) = SUBSTRING(au.creado_por, 1, 20)
            WHERE au.col_afect = '$columna' AND au.id_parametro = $idCliente
            ORDER BY au.fecha_creacion DESC");
        return $query->result_array();
    }

    public function registroDiario () {
        $id_currentUser = $this->session->userdata('id_usuario');
        $lider_currentUser = $this->session->userdata('id_usuario');
        switch ($this->session->userdata('id_rol')) {
            case 1:
            { #DIRECTOR   - RIGEL
                $filter = '';
                break;
            }
            case 4:
            { #ASISTENTE DIRECTOR RIGEL
                $filter = '';
                break;
            }
            case 3:
            { #GERENTE
                $filter = ' AND cl.id_gerente=' . $id_currentUser;
                break;
            }
            case 6:
            { #ASISTENTE GERENTE
                $filter = ' AND cl.id_gerente=' . $lider_currentUser;
                break;
            }
            case 2:
            { #SUBDIRECCIÓN
                $filter = ' AND cl.id_subdirector=' . $id_currentUser;
                break;
            }
            case 5:
            { #ASISTENTE SUBDIRECCIÓN
                $filter = ' AND cl.id_subdirector=' . $lider_currentUser;
                break;
            }
            case 9:
            { #COORDINADOR
                $filter = ' AND cl.id_coordinador=' . $id_currentUser;
                break;
            }
            case 59:
            { #DIRECTOR REGIONAL
                $filter = ' AND cl.id_regional=' . $id_currentUser;
                break;
            }
            case 60:
            { #ASISTENTE DIRECTOR REGIONAL
                $filter = ' AND cl.id_regional=' . $lider_currentUser;
                break;
            }
            default:
            {
                $filter = '';
                break;
            }
        }

        $query = $this->db-> query("SELECT l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
        l.nombreLote, l.idStatusContratacion, l.idMovimiento, l.modificado, cl.rfc,
        CAST(l.comentario AS VARCHAR(MAX)) AS comentario, l.fechaVenc, l.perfil, cond.nombre AS nombreCondominio, res.nombreResidencial, l.ubicacion,
        l.tipo_venta, l.observacionContratoUrgente AS vl,
		CONCAT(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) AS asesor,
        CONCAT(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno) AS coordinador,
        CONCAT(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno) AS gerente,
		cond.idCondominio, cl.expediente,
		(SELECT CONCAT(usuarios.nombre,' ', usuarios.apellido_paterno, ' ', usuarios.apellido_materno)
		FROM historial_lotes LEFT JOIN usuarios ON historial_lotes.usuario = usuarios.id_usuario
		WHERE idHistorialLote =(SELECT MAX(idHistorialLote) FROM historial_lotes WHERE idLote IN (l.idLote) 
		AND (perfil IN ('13', '32', 'contraloria', '17') AND status = 1))) AS lastUc
	    FROM lotes l
        INNER JOIN clientes cl ON cl.id_cliente = l.idCliente AND cl.idLote = l.idLote
        INNER JOIN condominios cond ON l.idCondominio=cond.idCondominio
        INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
		LEFT JOIN usuarios asesor ON cl.id_asesor = asesor.id_usuario
		LEFT JOIN usuarios coordinador ON cl.id_coordinador = coordinador.id_usuario
		LEFT JOIN usuarios gerente ON cl.id_gerente = gerente.id_usuario
		WHERE CONVERT(nvarchar, l.modificado, 6) = CONVERT(nvarchar, GETDATE(), 6) $filter
		AND l.idStatusContratacion IN ('5', '2') AND l.idMovimiento IN ('35', '22', '62', '75', '94') AND cl.status = 1
		GROUP BY l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
        l.nombreLote, l.idStatusContratacion, l.idMovimiento, l.modificado, cl.rfc,
        CAST(l.comentario AS VARCHAR(MAX)), l.fechaVenc, l.perfil, cond.nombre, res.nombreResidencial, l.ubicacion,
        l.tipo_venta, l.observacionContratoUrgente,
		CONCAT(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno),
        CONCAT(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno),
        CONCAT(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno),
		cond.idCondominio, cl.expediente");
        return $query->result();
    }

    public function registroDiarioPorFecha($fecha_inicio){
        $id_currentUser = $this->session->userdata('id_usuario');
        $lider_currentUser = $this->session->userdata('id_usuario');
        switch ($this->session->userdata('id_rol')) {
            case 1:
            { #DIRECTOR   - RIGEL
                $filter = '';
                break;
            }
            case 4:
            { #ASISTENTE DIRECTOR RIGEL
                $filter = '';
                break;
            }
            case 3:
            { #GERENTE
                $filter = ' AND cl.id_gerente=' . $id_currentUser;
                break;
            }
            case 6:
            { #ASISTENTE GERENTE
                $filter = ' AND cl.id_gerente=' . $lider_currentUser;
                break;
            }
            case 2:
            { #SUBDIRECCIÓN
                $filter = ' AND cl.id_subdirector=' . $id_currentUser;
                break;
            }
            case 5:
            { #ASISTENTE SUBDIRECCIÓN
                $filter = ' AND cl.id_subdirector=' . $lider_currentUser;
                break;
            }
            case 9:
            { #COORDINADOR
                $filter = ' AND cl.id_coordinador=' . $id_currentUser;
                break;
            }
            case 59:
            { #DIRECTOR REGIONAL
                $filter = ' AND cl.id_regional=' . $id_currentUser;
                break;
            }
            case 60:
            { #ASISTENTE DIRECTOR REGIONAL
                $filter = ' AND cl.id_regional=' . $lider_currentUser;
                break;
            }
            default:
            {
                $filter = '';
                break;
            }
        }

        $query = $this->db->query("SELECT l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
		l.nombreLote, l.idStatusContratacion, l.idMovimiento, CONVERT(VARCHAR,l.modificado,20) AS modificado, cl.rfc,
		CAST(l.comentario AS VARCHAR(MAX)) AS comentario, CONVERT(VARCHAR,l.fechaVenc,20) AS fechaVenc, l.perfil, cond.nombre AS nombreCondominio, res.nombreResidencial, l.ubicacion,
		l.tipo_venta, l.observacionContratoUrgente AS vl,
		CONCAT(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) AS asesor,
		CONCAT(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno) AS coordinador,
		CONCAT(gerente.nombre, ' ', gerente.apellido_paterno, ' ', gerente.apellido_materno) AS gerente,
		cond.idCondominio, cl.expediente,
		(SELECT CONCAT(usuarios.nombre,' ', usuarios.apellido_paterno, ' ', usuarios.apellido_materno)
		FROM historial_lotes LEFT JOIN usuarios ON historial_lotes.usuario = usuarios.id_usuario
		WHERE idHistorialLote =(SELECT MAX(idHistorialLote) FROM historial_lotes WHERE idLote IN (idLote) 
		AND (perfil IN ('13', '32', 'contraloria', '17')) AND status = 1)) AS lastUc
		FROM lotes l
		INNER JOIN clientes cl ON l.idLote = cl.idLote
		INNER JOIN condominios cond ON l.idCondominio = cond.idCondominio
		INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
		LEFT JOIN usuarios asesor ON cl.id_asesor = asesor.id_usuario
		LEFT JOIN usuarios coordinador ON cl.id_coordinador = coordinador.id_usuario
		LEFT JOIN usuarios gerente ON cl.id_gerente = gerente.id_usuario
		WHERE l.modificado BETWEEN '$fecha_inicio 00:00:00.000' AND '$fecha_inicio 23:59:59.000' 
		AND l.idStatusContratacion IN ('5', '2') AND l.idMovimiento IN ('35', '22', '62', '75', '94') AND cl.status = 1
		GROUP BY l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
		l.nombreLote, l.idStatusContratacion, l.idMovimiento, l.modificado, cl.rfc,
		CAST(l.comentario AS VARCHAR(MAX)), l.fechaVenc, l.perfil, cond.nombre, res.nombreResidencial, l.ubicacion,
		l.tipo_venta, l.observacionContratoUrgente,
		CONCAT(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno),
		CONCAT(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno),
		CONCAT(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno),
		cond.idCondominio, cl.expediente");

        return $query->result();
    }

    public function getRL () {
		$cmd = "SELECT * FROM opcs_x_cats WHERE id_catalogo = 77 AND estatus = 1 ";
		$query  = $this->db->query($cmd);
		return $query->result();
	}

    public function getCamposHistorialDS($idCliente)
    {
        $query = $this->db->query("SELECT DISTINCT(col_afect) AS columna FROM auditoria WHERE id_parametro = $idCliente 
            AND col_afect IN ('Nombre', 'Apellido paterno', 'Apellido materno', 'Correo electrónico', 'Celular', 
                              'Estado civil', 'Ocupación', 'Puesto', 'Fecha 1° Aportación')");
        return $query->result_array();
    }
    
    public function validate90Dias($idLote,$idCliente,$usuario){
        $validation90 = $this->db->query("SELECT c.fechaApartado,DATEDIFF(DAY, c.fechaApartado, GETDATE()) AS dias, c.tipo_nc  
		FROM clientes c 
		INNER JOIN lotes l on l.idCliente=c.id_cliente 
		WHERE c.id_cliente=$idCliente AND l.idLote=$idLote")->result_array();
        if(count($validation90) > 0){
            if($validation90[0]['dias'] > 89 && ($validation90[0]['tipo_nc'] == 0 || $validation90[0]['tipo_nc'] == NULL)){
				$dias = $validation90[0]['dias'];
				$tipo_nc0 = $validation90[0]['tipo_nc']== NULL ? 0 : $validation90[0]['tipo_nc'];
                $validationPorcentage = $this->db->query("SELECT * FROM porcentajes_penalizaciones WHERE inicio <= $dias AND fin >= $dias AND estatus = 1 AND tipo_cliente = $tipo_nc0")->result_array();
                $estatus= $validationPorcentage[0]['id_porcentaje_penalizacion'] == 4 ? 4 : 1;
                $datos = array(
                    'id_lote' => $idLote,
                    'id_cliente' => $idCliente,
                    'dias_atraso' => $dias,
                    'estatus' => $estatus,
                    'fecha_aprobacion' => date('Y-m-d H:i:s'),
                    'id_porcentaje_penalizacion' => $validationPorcentage[0]['id_porcentaje_penalizacion'],
                    'creado_por' => $usuario,
                    'fecha_creacion' => date('Y-m-d H:i:s'),
                    'modificado_por' => $usuario,
                );
                $this->db->insert('penalizaciones',$datos);
            }else if ($validation90[0]['dias'] > 119 && $validation90[0]['tipo_nc'] == 1){
                $dias = $validation90[0]['dias'];
                $tipo_nc1 = $validation90[0]['tipo_nc'];
                $validationPorcentage = $this->db->query("SELECT * FROM porcentajes_penalizaciones WHERE inicio <= $dias AND fin >= $dias AND estatus = 1 AND tipo_cliente = $tipo_nc1")->result_array();
                $estatus = $validationPorcentage[0]['id_porcentaje_penalizacion'] == 4 ? 4 : 1;
                $datos = array(
                    'id_lote' => $idLote,
                    'id_cliente' => $idCliente,
                    'dias_atraso' => $dias,
                    'estatus' => $estatus,
                    'fecha_aprobacion' => date('Y-m-d H:i:s'),
                    'id_porcentaje_penalizacion' => $validationPorcentage[0]['id_porcentaje_penalizacion'],
                    'creado_por' => $usuario,
                    'fecha_creacion' => date('Y-m-d H:i:s'),
                    'modificado_por' => $usuario,
                );
                $this->db->insert('penalizaciones',$datos);
            }
        }

    }

    function getCatalogs() {
        return $this->db->query("SELECT id_catalogo, id_opcion, UPPER(nombre) nombre FROM opcs_x_cats WHERE id_catalogo IN (77, 78) AND estatus = 1 ORDER BY id_catalogo, nombre");
    }

    function validaCorrida($idLote){
        $query = $this->db->query("SELECT * FROM historial_documento WHERE idLote=".$idLote." AND tipo_doc=7 AND status=1;");
        return $query->row();
    }

    function checkTipoVenta($idLote){
        $query = $this->db->query("SELECT * FROM lotes WHERE idLote=".$idLote);
        return $query->result_array();
    }



    //modelos autorizacion MSI
    function todasAutorizacionesMSI(){
        $estatus_permitido = '';
        $rol_actual = $this->session->userdata('id_rol');

        switch($rol_actual){
            case 5:
                $estatus_permitido='1, 3, 4';
                break;
            case 17:
                $estatus_permitido='2,3';
                break;
            case 70:
                $estatus_permitido='2,3';

        }
        $query = $this->db->query("SELECT STRING_AGG(au.id_autorizacion, ', ') id_autorizacion, au.idResidencial, STRING_AGG(au.idCondominio, ', ') idCondominio, ISNULL(CAST(au.lote AS VARCHAR(MAX)), '0') lote, 
        CAST(au.comentario AS VARCHAR(MAX)) comentario, op.nombre as estatus_autorizacion,  
        au.estatus, au.fecha_creacion, au.creado_por, au.fecha_modificacion, au.modificado_por,
        op.id_opcion, op.id_catalogo, op.nombre, op.estatus, op.fecha_creacion, op.creado_por,--, op.color
        au.estatus_autorizacion as estatus_id
        FROM autorizaciones_msi au 
        INNER JOIN opcs_x_cats op ON op.id_opcion = au.estatus_autorizacion 
        WHERE op.id_catalogo=90 AND au.estatus_autorizacion IN (".$estatus_permitido.")
        GROUP BY au.idResidencial, ISNULL(CAST(au.lote AS VARCHAR(MAX)), '0'), CAST(au.comentario AS VARCHAR(MAX)), au.estatus_autorizacion, 
        au.estatus, au.fecha_creacion, au.creado_por, au.fecha_modificacion, au.modificado_por,
        op.id_opcion, op.id_catalogo, op.nombre, op.estatus, op.fecha_creacion, op.creado_por, ISNULL(op.color, '0')");


        return $query->result_array();
    }
    function getAutVis($id_autorizacion){
        $query = $this->db->query("SELECT * FROM autorizaciones_msi au 
                                INNER JOIN condominios c ON au.idCondominio=c.idCondominio WHERE id_autorizacion=".$id_autorizacion);
        return $query->result_array();
    }
    function getHistorialAutorizacionMSI($id_autorizacion){
        $query = $this->db->query("SELECT hamsi.*, CONCAT(u.nombre,' ', u.apellido_paterno,' ', u.apellido_materno) as creadoPor, 
        hamsi.estatus_autorizacion, cond.nombre
        FROM historial_autorizacionesPMSI hamsi
        INNER JOIN autorizaciones_msi au ON au.id_autorizacion = hamsi.idAutorizacion
        INNER JOIN usuarios u ON u.id_usuario = hamsi.id_usuario
        INNER JOIN condominios cond ON cond.idCondominio = au.idCondominio
        WHERE idAutorizacion=".$id_autorizacion);
        return $query->result_array();
    }
    function getLotesByResCond($idCondominio){
        $query = $this->db->query("SELECT * FROM lotes WHERE idCondominio=$idCondominio");
        return $query->result_array();
    }

    function getInvientarioComisionista($estatus, $condominio, $proyecto) {
        $filtroProyecto = "";
        $filtroCondominio = "";
        $filtroEstatus = "";
        if ($proyecto != 0)
            $filtroProyecto = "AND re.idResidencial = $proyecto";
        if ($condominio != 0)
            $filtroCondominio = "AND co.idCondominio = $condominio";
        if ($estatus != 0)
            $filtroEstatus = "AND lo.idStatusLote = $estatus";

        return $this->db->query("SELECT re.nombreResidencial, co.nombre nombreCondominio, lo.nombreLote, lo.idLote, lo.referencia,
        CASE WHEN a.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(a.nombre, ' ', a.apellido_paterno, ' ', a.apellido_materno)) END nombreAsesor1,
        CASE WHEN c.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno)) END nombreCoordinador1,
        CASE WHEN g.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(g.nombre, ' ', g.apellido_paterno, ' ', g.apellido_materno)) END nombreGerente1,
        CASE WHEN a1.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(a1.nombre, ' ', a1.apellido_paterno, ' ', a1.apellido_materno)) END nombreAsesor2,
        CASE WHEN c1.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(c1.nombre, ' ', c1.apellido_paterno, ' ', c1.apellido_materno)) END nombreCoordinador2,
        CASE WHEN g1.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(g1.nombre, ' ', g1.apellido_paterno, ' ', g1.apellido_materno)) END nombreGerente2,
        CASE WHEN a2.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(a2.nombre, ' ', a2.apellido_paterno, ' ', a2.apellido_materno)) END nombreAsesor3,
        CASE WHEN c2.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(c2.nombre, ' ', c2.apellido_paterno, ' ', c2.apellido_materno)) END nombreCoordinador3,
        CASE WHEN g2.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(g2.nombre, ' ', g2.apellido_paterno, ' ', g2.apellido_materno)) END nombreGerente3,
        CASE WHEN lo.casa = 1 THEN CONCAT(sl.nombre, ' casa') ELSE sl.nombre end as descripcion_estatus, sl.color, sl.background_sl, tv.tipo_venta tipo_venta,
        ISNULL(CONVERT(varchar, cl.fechaApartado, 20), '') AS fechaApartado, ISNULL(cl.tipo_casa, 0) tipo_casa, ISNULL(oxc2.nombre, 'SIN ESPECIFICAR') nombre_tipo_casa, lo.casa
        FROM lotes lo
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio $filtroCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial $filtroProyecto
        INNER JOIN statuslote sl ON sl.idStatusLote = lo.idStatusLote 
        LEFT JOIN tipo_venta tv ON tv.id_tventa = lo.tipo_venta 
        LEFT JOIN clientes cl ON cl.id_cliente = lo.idCliente AND cl.idLote = lo.idLote
        LEFT JOIN (SELECT MIN(id_vcompartida) idVentaUno, id_cliente FROM ventas_compartidas WHERE estatus = 1
        GROUP BY id_cliente) ventaUno ON ventaUno.id_cliente = cl.id_cliente
        LEFT JOIN (SELECT MAX(id_vcompartida) idVentaDos, id_cliente FROM ventas_compartidas WHERE estatus = 1
        GROUP BY id_cliente ) ventaDos ON ventaDos.id_cliente = cl.id_cliente
        LEFT JOIN usuarios a on a.id_usuario = cl.id_asesor
        LEFT JOIN usuarios c on c.id_usuario = cl.id_coordinador
        LEFT JOIN usuarios g on g.id_usuario = cl.id_gerente
        LEFT JOIN ventas_compartidas vc1 on vc1.id_vcompartida = ventaUno.idVentaUno
        LEFT JOIN usuarios a1 on a1.id_usuario = vc1.id_asesor
        LEFT JOIN usuarios c1 on c1.id_usuario = vc1.id_coordinador
        LEFT JOIN usuarios g1 on g1.id_usuario = vc1.id_gerente
        LEFT JOIN ventas_compartidas vc2 on vc2.id_vcompartida = ventaDos.idVentaDos AND vc2.id_vcompartida != ventaUno.idVentaUno
        LEFT JOIN usuarios a2 on a2.id_usuario = vc2.id_asesor
        LEFT JOIN usuarios c2 on c2.id_usuario = vc2.id_coordinador
        LEFT JOIN usuarios g2 on g2.id_usuario = vc2.id_gerente
        LEFT JOIN opcs_x_cats oxc2 ON oxc2.id_opcion = cl.tipo_casa AND oxc2.id_catalogo = 35
        WHERE lo.status = 1 $filtroEstatus --AND lo.idLote IN (83994, 66922, 53696, 53697, 81203, 55668, 63149, 51878, 58803)
        ORDER BY lo.nombreLote")->result_array();
    }

    function getReporteEscaneos($typeTransaction, $beginDate, $endDate, $where) {
        $filter = "AND cl.fechaApartado BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59'";
        return $this->db->query("SELECT re.nombreResidencial, re.descripcion, co.nombre nombreCondominio, lo.nombreLote, lo.referencia,
        CASE WHEN u0.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) END nombreUsuario,
        UPPER(CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)) nombreCliente, ISNULL(se.nombre, 'SIN ESPECIFICAR') nombreSede, 
        CONVERT(varchar, hd.modificado, 105) fechaCargaContratoFirmado, CASE WHEN hd.expediente IS NULL THEN 'NO SE HA CARGADO CONTRATO' ELSE 'CONTRATO CARGADO' END estatusDocumento
        FROM lotes lo
        INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente AND cl.idLote = lo.idLote AND cl.status = 1 $filter
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        LEFT JOIN sedes se ON se.id_sede = cl.id_sede
        LEFT JOIN (SELECT * FROM historial_documento WHERE status = 1 AND tipo_doc = 30) hd ON hd.idLote = lo.idLote AND hd.idCliente = lo.idCliente
        LEFT JOIN usuarios u0 ON u0.id_usuario = hd.idUser
        WHERE lo.status = 1 AND lo.idStatusContratacion = 15 AND lo.idMovimiento = 45 AND lo.idStatusLote = 2")->result();
	}

    function getInventarioData($fechaInicio, $fechaFin) {
        $filter = " AND cl.fechaApartado BETWEEN '$fechaInicio 00:00:00' AND '$fechaFin 23:59:59'";
  
        $query = $this->db->query("SELECT  lot.idLote,cl.id_asesor, lot.nombreLote, con.nombre as nombreCondominio, res.nombreResidencial, lot.idStatusLote, con.idCondominio, lot.totalNeto2,
        lot.total, lot.referencia, ISNULL(lot.comentario, 'SIN ESPECIFICAR') comentario, lot.comentarioLiberacion, lot.observacionLiberacion, 
        CASE WHEN lot.casa = 1 THEN CONCAT(sl.nombre, ' casa') ELSE sl.nombre end as descripcion_estatus, sl.color, tv.tipo_venta,
        CASE WHEN u0.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) END asesor,
        CASE WHEN u1.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)) END coordinador,
        CASE WHEN u2.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)) END gerente,
        CASE WHEN u3.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)) END subdirector,
        CASE WHEN u4.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)) END regional,
        CASE WHEN u5.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u5.nombre, ' ', u5.apellido_paterno, ' ', u5.apellido_materno)) END regional2,
        lot.precio, ISNULL(CONVERT(varchar, lot.fecha_modst, 20), '') fecha_modst,  ISNULL(CONVERT(varchar, cl.fechaApartado, 20), '') AS fechaApartado, ISNULL (cl.apartadoXReubicacion, 0) AS apartadoXReubicacion, ISNULL(CONVERT(varchar, cl.fechaAlta, 21), '') AS fechaAlta, lot.observacionContratoUrgente,
        CASE WHEN cl.id_cliente IS NULL THEN 'SIN ESPECIFICAR' ELSE CONCAT(cl.nombre,' ', cl.apellido_paterno, ' ', cl.apellido_materno) END as nombreCliente, lot.motivo_change_status,opx.nombre registro,
        lot.fecha_creacion,
        lot.idStatusContratacion,
        sl.background_sl,sed.nombre as ubicacion,com.idCliente comision,lot.idCliente,vc.id_cliente as banderaVC
        FROM lotes lot
        INNER JOIN condominios con ON con.idCondominio = lot.idCondominio 
        INNER JOIN residenciales res ON res.idResidencial = con.idResidencial
        LEFT JOIN opcs_x_cats opx ON opx.id_opcion=lot.registro_comision AND opx.id_catalogo=95 
        INNER JOIN statuslote sl ON sl.idStatusLote = lot.idStatusLote 
        LEFT JOIN tipo_venta tv ON tv.id_tventa = lot.tipo_venta 
        LEFT JOIN clientes cl ON cl.id_cliente = lot.idCliente 
        LEFT JOIN (SELECT id_cliente FROM ventas_compartidas WHERE estatus=1 GROUP BY id_cliente) vc ON vc.id_cliente=cl.id_cliente
        LEFT JOIN usuarios u0 ON u0.id_usuario = cl.id_asesor
        LEFT JOIN usuarios u1 ON u1.id_usuario = cl.id_coordinador
        LEFT JOIN usuarios u2 ON u2.id_usuario = cl.id_gerente
        LEFT JOIN usuarios u3 ON u3.id_usuario = cl.id_subdirector
        LEFT JOIN usuarios u4 ON u4.id_usuario = cl.id_regional
        LEFT JOIN usuarios u5 ON u5.id_usuario = cl.id_regional_2
        LEFT JOIN sedes sed ON sed.id_sede = lot.ubicacion
        LEFT JOIN (SELECT idCliente FROM comisiones GROUP BY idCliente) com ON com.idCliente=cl.id_cliente
        WHERE lot.status = 1 $filter
        ORDER BY lot.nombreLote");
        return $query->result_array();
     }
     public function getProspectingPlaceDetail() {
           $lpReturn = "CONCAT(REPLACE(ISNULL(oxc.nombre, 'Sin especificar'), ' (especificar)', ''), (CASE pr.source WHEN '0' THEN '' ELSE CONCAT(' - ', pr.source) END))"; 
        return $lpReturn;
     }

     public function getLineaVenta($idCliente,$banderaVC){
      $clientes =   $this->db->query("SELECT cl.id_cliente,cl.id_asesor,cl.id_coordinador,cl.id_gerente,cl.id_subdirector,cl.id_regional,cl.id_regional_2, 
      CASE WHEN u0.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) END asesor,
      CASE WHEN u1.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)) END coordinador,
      CASE WHEN u2.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)) END gerente,
      CASE WHEN u3.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)) END subdirector,
      CASE WHEN u4.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)) END regional,
      CASE WHEN u5.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u5.nombre, ' ', u5.apellido_paterno, ' ', u5.apellido_materno)) END regional2
      FROM clientes cl
      LEFT JOIN usuarios u0 ON u0.id_usuario = cl.id_asesor
      LEFT JOIN usuarios u1 ON u1.id_usuario = cl.id_coordinador
      LEFT JOIN usuarios u2 ON u2.id_usuario = cl.id_gerente
      LEFT JOIN usuarios u3 ON u3.id_usuario = cl.id_subdirector
      LEFT JOIN usuarios u4 ON u4.id_usuario = cl.id_regional
      LEFT JOIN usuarios u5 ON u5.id_usuario = cl.id_regional_2 WHERE cl.id_cliente=$idCliente")->result_array();
      $compartidas = $banderaVC = 0 ? [] : $this->db->query("SELECT vc.id_vcompartida,vc.id_cliente,vc.id_asesor,vc.id_coordinador,vc.id_gerente,vc.id_subdirector,vc.id_regional,vc.id_regional_2,
      		CASE WHEN u0.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) END asesor,
        CASE WHEN u1.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u1.nombre, ' ', u1.apellido_paterno, ' ', u1.apellido_materno)) END coordinador,
        CASE WHEN u2.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ', u2.apellido_materno)) END gerente,
        CASE WHEN u3.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ', u3.apellido_materno)) END subdirector,
        CASE WHEN u4.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u4.nombre, ' ', u4.apellido_paterno, ' ', u4.apellido_materno)) END regional,
        CASE WHEN u5.id_usuario IS NULL THEN 'SIN ESPECIFICAR' ELSE UPPER(CONCAT(u5.nombre, ' ', u5.apellido_paterno, ' ', u5.apellido_materno)) END regional2 
      FROM ventas_compartidas vc
      LEFT JOIN usuarios u0 ON u0.id_usuario = vc.id_asesor
      LEFT JOIN usuarios u1 ON u1.id_usuario = vc.id_coordinador
      LEFT JOIN usuarios u2 ON u2.id_usuario = vc.id_gerente
      LEFT JOIN usuarios u3 ON u3.id_usuario = vc.id_subdirector
      LEFT JOIN usuarios u4 ON u4.id_usuario = vc.id_regional
      LEFT JOIN usuarios u5 ON u5.id_usuario = vc.id_regional_2 WHERE vc.id_cliente=$idCliente AND vc.estatus=1")->result_array();

        return array("clientes" => $clientes,
                     "compartidas" => $compartidas);
     }

     public function allUserVentas()
     {
        return $this->db->query("(SELECT id_usuario, CONCAT(id_usuario,' - ',nombre, ' ', apellido_paterno, ' ', apellido_materno) nombre,
		(CASE WHEN id_rol = 7 THEN id_sede ELSE 0 END) id_sede,
        (CASE WHEN id_usuario IN(6482, 5, 7092) THEN 3 ELSE id_rol END) id_rol
        FROM usuarios 
        WHERE id_rol in(2,3,7,9) AND estatus = 1   AND ISNULL(correo, '') NOT LIKE '%SINCO%' AND ISNULL(correo, '') NOT LIKE '%test_%')
        UNION 
        (SELECT id_usuario, CONCAT(id_usuario,' - ',nombre, ' ', apellido_paterno, ' ', apellido_materno) nombre,
		(CASE WHEN id_rol = 7 THEN id_sede ELSE 0 END) id_sede,
		id_rol
        FROM usuarios 
        WHERE id_usuario in(6482, 5, 7092) AND estatus = 1   AND ISNULL(correo, '') NOT LIKE '%SINCO%' AND ISNULL(correo, '') NOT LIKE '%test_%')")->result();
     }
     public function EditarInventario($datos){
        $query = $this->db->query("SELECT * FROM comisiones WHERE idCliente=".$datos['id_cliente'])->result_array();
        if(count($query) > 0){
            echo json_encode(2);
            exit;
        }
        $this->db->trans_begin();
        $id_cliente = $datos['id_cliente'];
        $id_asesor = $datos['id_asesor'];
        $id_coordinador = $datos['id_coordinador'];
        $id_gerente = $datos['id_gerente'];
        $id_subdirector = $datos['id_subdirector'];
        $id_regional = $datos['id_regional'];
        $id_regional_2 = $datos['id_regional_2'];
        $modificado_por = $this->session->userdata('id_usuario');
        $this->db->query("UPDATE clientes SET id_asesor=$id_asesor,id_coordinador=$id_coordinador,id_gerente=$id_gerente,id_subdirector=$id_subdirector,id_regional=$id_regional,id_regional_2=$id_regional_2,modificado_por='$modificado_por'  WHERE id_cliente=$id_cliente;");

        for($m=0; $m < $datos['indexVC'] ; $m++) {
            $id_vcompartida = $datos['id_vcompartida_'.$m];
            $id_asesor = $datos['id_asesor_'.$m];
            $id_coordinador = $datos['id_coordinador_'.$m];
            $id_gerente = $datos['id_gerente_'.$m];
            $id_subdirector = $datos['id_subdirector_'.$m];
            $id_regional = $datos['id_regional_'.$m];
            $id_regional_2 = $datos['id_regional_2_'.$m];
            $this->db->query("UPDATE ventas_compartidas SET id_asesor=$id_asesor,id_coordinador=$id_coordinador,id_gerente=$id_gerente,id_subdirector=$id_subdirector,id_regional=$id_regional,id_regional_2=$id_regional_2,modificado_por='$modificado_por'  WHERE id_vcompartida=$id_vcompartida;");
        }

        if ($this->db->trans_status() === FALSE) { // Hubo errores en la consulta, entonces se cancela la transacción.
            $this->db->trans_rollback();
            return false;
        } else { // Todas las consultas se hicieron correctamente.
            $this->db->trans_commit();
            return true;
        }
    }


    public function getCambioRL ($idLote) {
		$query = $this->db-> query("SELECT l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
		l.nombreLote, l.idStatusContratacion, l.idMovimiento, convert(varchar,l.modificado,120) as modificado, cl.rfc, sd.nombre as nombreSede,
		CAST(l.comentario AS varchar(MAX)) as comentario, convert(varchar,l.fechaVenc,120) as fechaVenc, l.perfil, res.nombreResidencial, cond.nombre as nombreCondominio,
		l.ubicacion, ISNULL(tv.tipo_venta, 'Sin especificar') tipo_venta, l.observacionContratoUrgente as vl, cl.tipo_nc residencia,
		concat(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno) as asesor,
		concat(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno) as coordinador,
		concat(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno) as gerente,
		cond.idCondominio, ISNULL(oxc0.nombre, 'Normal') tipo_proceso, ISNULL(rl.nombre, 'Normal') representanteLegal, ISNULL(rl.id_opcion, 0) id_rl,
        sl.nombre estatusLote, l.idStatusLote idEstatusLote
		FROM lotes l
		INNER JOIN clientes cl ON cl.id_cliente = l.idCliente AND cl.idLote = l.idLote
		INNER JOIN condominios cond ON l.idCondominio=cond.idCondominio
		INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
		LEFT JOIN usuarios asesor ON cl.id_asesor = asesor.id_usuario
		LEFT JOIN usuarios coordinador ON cl.id_coordinador = coordinador.id_usuario
		LEFT JOIN usuarios gerente ON cl.id_gerente = gerente.id_usuario
		LEFT JOIN sedes sd ON sd.id_sede = l.ubicacion
		LEFT JOIN tipo_venta tv ON tv.id_tventa = l.tipo_venta
        LEFT JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = cl.proceso AND oxc0.id_catalogo = 97
		LEFT JOIN opcs_x_cats rl ON rl.id_opcion = cl.rl 
        LEFT JOIN statuslote sl ON sl.idStatusLote = l.idStatusLote
		WHERE l.idLote = $idLote AND rl.id_catalogo IN (77)
		GROUP BY l.idLote, cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno,
		l.nombreLote, l.idStatusContratacion, l.idMovimiento, l.modificado, cl.rfc, cl.tipo_nc,sd.nombre,
		CAST(l.comentario AS varchar(MAX)), l.fechaVenc, l.perfil, cond.nombre, res.nombreResidencial, l.ubicacion,
		tv.tipo_venta, l.observacionContratoUrgente,
		concat(asesor.nombre,' ', asesor.apellido_paterno, ' ', asesor.apellido_materno),
		concat(coordinador.nombre,' ', coordinador.apellido_paterno, ' ', coordinador.apellido_materno),
		concat(gerente.nombre,' ', gerente.apellido_paterno, ' ', gerente.apellido_materno),
		cond.idCondominio, ISNULL(oxc0.nombre, 'Normal'), ISNULL(rl.nombre, 'Normal'), ISNULL(rl.id_opcion, 0), sl.nombre, l.idStatusLote
		ORDER BY l.nombreLote");
        return $query->result();
    }

    function getCatalogsRL() {
        return $this->db->query("SELECT id_catalogo, id_opcion, UPPER(nombre) nombre FROM opcs_x_cats WHERE id_catalogo IN (77) AND estatus = 1 ORDER BY id_catalogo, nombre");
    }

    function getSedeRl() {
        return $this->db->query("SELECT id_sede, UPPER(nombre) nombre FROM sedes");
    }

    function getStatusLoteRl(){
        return $this->db->query("SELECT idStatusLote, nombre FROM statuslote WHERE idStatusLote IN (6,9)");
    }

    public function get_historial_liberaciones()
    {   
        $rol = $this->session->userdata('id_rol');
        $id_usuario = $this->session->userdata('id_usuario');

		if ($rol == 17) {
            $qry = "SELECT h.*, hsd.idDocumento,l.nombreLote ,hsd.idDocumento, hsd.expediente, l.idCliente, l.precio, op.nombre AS estatus_proceso, 
            CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreUsuario, 
            CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombreCliente, cond.idResidencial, cond.idCondominio, cond.nombre, res.nombreResidencial, cond.tipo_lote, cl.nombre AS clausulas
            FROM historial_liberacion_lotes h
            INNER JOIN Lotes as l ON l.idLote = h.idLote 
            INNER JOIN usuarios AS u ON u.id_usuario = h.modificado_por
            INNER JOIN opcs_x_cats AS op on op.id_opcion = h.id_proceso 
            LEFT JOIN clientes AS c ON c.id_cliente = l.idCliente
            LEFT JOIN historial_documento hsd on hsd.idLote = l.idLote and hsd.tipo_doc = 51
            INNER JOIN condominios AS cond ON l.idCondominio = cond.idCondominio
            INNER JOIN residenciales AS res ON cond.idResidencial = res.idResidencial
            LEFT JOIN clausulas AS cl ON cl.id_lote = l.idLote AND cl.estatus = 1
            WHERE h.fecha_modificacion = (SELECT MAX(fecha_modificacion) FROM historial_liberacion_lotes WHERE idLote = h.idLote)
            AND op.id_catalogo = 109;";
        }

        if ($rol == 33) {
            $qry = "SELECT h.*, hsd.idDocumento,l.nombreLote ,hsd.idDocumento, hsd.expediente, l.idCliente, l.precio, op.nombre AS estatus_proceso, 
            CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreUsuario, 
            CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombreCliente, cond.idResidencial, cond.idCondominio, cond.nombre, res.nombreResidencial, cond.tipo_lote, cl.nombre AS clausulas
            FROM historial_liberacion_lotes h
            INNER JOIN Lotes as l ON l.idLote = h.idLote 
            INNER JOIN usuarios AS u ON u.id_usuario = h.modificado_por
            INNER JOIN opcs_x_cats AS op on op.id_opcion = h.id_proceso 
            LEFT JOIN clientes AS c ON c.id_cliente = l.idCliente
            LEFT JOIN historial_documento hsd on hsd.idLote = l.idLote and hsd.tipo_doc = 51
            INNER JOIN condominios AS cond ON l.idCondominio = cond.idCondominio
            INNER JOIN residenciales AS res ON cond.idResidencial = res.idResidencial
            LEFT JOIN clausulas AS cl ON cl.id_lote = l.idLote AND cl.estatus = 1
            WHERE h.fecha_modificacion = (SELECT MAX(fecha_modificacion) FROM historial_liberacion_lotes WHERE idLote = h.idLote)
            AND op.id_catalogo = 109 AND (h.id_proceso = 1);";
        }

        if ($rol == 2) {
            $qry = "SELECT h.*, hsd.idDocumento,l.nombreLote ,hsd.idDocumento, hsd.expediente, l.idCliente, l.precio, op.nombre AS estatus_proceso, 
            CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreUsuario, 
            CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombreCliente, cond.idResidencial, cond.idCondominio, cond.nombre, res.nombreResidencial, cond.tipo_lote, cl.nombre AS clausulas
            FROM historial_liberacion_lotes h
            INNER JOIN Lotes as l ON l.idLote = h.idLote 
            INNER JOIN usuarios AS u ON u.id_usuario = h.modificado_por
            INNER JOIN opcs_x_cats AS op on op.id_opcion = h.id_proceso 
            LEFT JOIN clientes AS c ON c.id_cliente = l.idCliente
            LEFT JOIN historial_documento hsd on hsd.idLote = l.idLote and hsd.tipo_doc = 51
            INNER JOIN condominios AS cond ON l.idCondominio = cond.idCondominio
            INNER JOIN residenciales AS res ON cond.idResidencial = res.idResidencial
            LEFT JOIN clausulas AS cl ON cl.id_lote = l.idLote AND cl.estatus = 1
            WHERE h.fecha_modificacion = (SELECT MAX(fecha_modificacion) FROM historial_liberacion_lotes WHERE idLote = h.idLote)
            AND op.id_catalogo = 109 AND (h.id_proceso = 2)
            AND res.id_subdirector = $id_usuario;";
        }

        if ($rol == 12) {
            $qry = "SELECT h.*, hsd.idDocumento,l.nombreLote ,hsd.idDocumento, hsd.expediente, l.idCliente, l.precio, op.nombre AS estatus_proceso, 
            CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreUsuario, 
            CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombreCliente, cond.idResidencial, cond.idCondominio, cond.nombre, res.nombreResidencial, cond.tipo_lote, cl.nombre AS clausulas
            FROM historial_liberacion_lotes h
            INNER JOIN Lotes as l ON l.idLote = h.idLote 
            INNER JOIN usuarios AS u ON u.id_usuario = h.modificado_por
            INNER JOIN opcs_x_cats AS op on op.id_opcion = h.id_proceso 
            LEFT JOIN clientes AS c ON c.id_cliente = l.idCliente
            LEFT JOIN historial_documento hsd on hsd.idLote = l.idLote and hsd.tipo_doc = 51
            INNER JOIN condominios AS cond ON l.idCondominio = cond.idCondominio
            INNER JOIN residenciales AS res ON cond.idResidencial = res.idResidencial
            LEFT JOIN clausulas AS cl ON cl.id_lote = l.idLote AND cl.estatus = 1
            WHERE h.fecha_modificacion = (SELECT MAX(fecha_modificacion) FROM historial_liberacion_lotes WHERE idLote = h.idLote)
            AND op.id_catalogo = 109 AND (h.id_proceso = 3);";
        }
        return $this->db->query($qry);
    }

    public function get_historial_liberaciones_por_lote($idLote)
    {
        $qry = "SELECT L.[idLote], L.[nombreLote], L.[idCliente], L.[nombre_lote],
        COALESCE(H.[id_proceso], 0) AS id_proceso,
        H.[id_hist_lib_lote], H.[id_cat_tipo_liberacion], H.[id_tipo_liberacion], H.[id_cat_proceso], H.[proceso_realizado],
        H.[justificacion_liberacion], H.[estatus], H.[modificado_por], H.[fecha_modificacion],
        ISNULL(
        (
            SELECT TOP 1 [nombre]
            FROM [sisfusion].[dbo].[opcs_x_cats] 
            WHERE [id_catalogo] = H.[id_cat_proceso] AND [id_opcion] = H.[id_proceso]
        ), 'Comienzo'
        ) AS nombre_proceso,
        U.[nombre] AS nombre_u,
        U.[apellido_paterno] AS ap_u,
        U.[apellido_materno] AS am_u
        FROM [sisfusion].[dbo].[lotes] AS L
        LEFT JOIN (
                    SELECT [id_hist_lib_lote], [idLote], [id_cat_tipo_liberacion], [id_tipo_liberacion], [id_cat_proceso], [proceso_realizado],
                        [justificacion_liberacion], [estatus], [modificado_por], [fecha_modificacion],
                        MAX([id_proceso]) AS id_proceso
                    FROM [sisfusion].[dbo].[historial_liberacion_lotes]
                    GROUP BY [id_hist_lib_lote], [idLote], [id_cat_tipo_liberacion], [id_tipo_liberacion], [id_cat_proceso], [proceso_realizado], [justificacion_liberacion], [estatus], [modificado_por], [fecha_modificacion]
                ) AS H
        ON L.[idLote] = H.[idLote]
        LEFT JOIN [sisfusion].[dbo].[usuarios] AS U
        ON H.[modificado_por] = U.[id_usuario]
        WHERE L.[idLote] = $idLote;
        ";
        return $this->db->query($qry);
    }

    public function uploadSup($datos) {

        $query = $this->db-> query("SELECT idLote, nombreLote, precio, status FROM lotes where idCondominio = ".$datos['idCondominio']." and nombreLote = '".$datos['nombreLote']."' and status = 1");

        foreach ($query->result_array() as $row) {
            $this->db->query("UPDATE lotes SET 
            sup = ".$datos['sup'].",
            total = (".$datos['sup'] * $row['precio']."), 
            enganche = (".$datos['sup'] * $row['precio']." * 0.1), 
            saldo = (".$datos['sup'] * $row['precio']." - (".$datos['sup'] * $row['precio']." * 0.1))
            WHERE idLote IN (".$row['idLote'].") and nombreLote IN ('".$row['nombreLote']."') and status = 1 ");
            
            return true;
        }

    }

    public function aplicaLiberacion($datos){
        $query = $this->db-> query("SELECT idLote, nombreLote, status, sup FROM lotes where idCondominio = ".$datos['idCondominio']." and nombreLote = '".$datos['nombreLote']."' and status = 1");

        foreach ($query->result_array() as $row) {
            $this->db->trans_begin();
            
            $id_cliente = $this->db->query("SELECT id_cliente FROM clientes WHERE status = 1 and idLote IN (" . $row['idLote'] . ") ")->result_array();
            $this->db->query("UPDATE historial_documento SET status = 0 WHERE status = 1 and idLote IN (".$row['idLote'].") ");
            $this->db->query("UPDATE prospectos SET tipo = 0, estatus_particular = 4, modificado_por = 1, fecha_modificacion = GETDATE() WHERE id_prospecto IN (SELECT id_prospecto FROM clientes WHERE status = 1 AND idLote = ".$row['idLote'].")");
            $this->db->query("UPDATE clientes SET status = 0 WHERE status = 1 and idLote IN (".$row['idLote'].") ");
            $this->db->query("UPDATE historial_enganche SET status = 0, comentarioCancelacion = 'LOTE LIBERADO' WHERE status = 1 and idLote IN (".$row['idLote'].") ");
            $this->db->query("UPDATE historial_lotes SET status = 0 WHERE status = 1 and idLote IN (".$row['idLote'].") ");
            
            $comisiones = $this->db->query("SELECT id_comision,id_lote,comision_total FROM comisiones where id_lote=".$row['idLote']."")->result_array();
            
            for ($i=0; $i <count($comisiones) ; $i++) {
                $sumaxcomision=0;
                $pagos_ind = $this->db->query("select * from pago_comision_ind where id_comision=".$comisiones[$i]['id_comision']."")->result_array();
                
                for ($j=0; $j <count($pagos_ind) ; $j++) { 
                    $sumaxcomision = $sumaxcomision + $pagos_ind[$j]['abono_neodata'];
                }
                $this->db->query("UPDATE comisiones set  modificado_por='" . $datos['userLiberacion'] . "',comision_total=$sumaxcomision,estatus=8 where id_comision=".$comisiones[$i]['id_comision']." ");
            }
            //$this->db->query("UPDATE lotes set registro_comision=8  where idLote=".$row['idLote']." ");
            $this->db->query("UPDATE pago_comision set bandera=0,total_comision=0,abonado=0,pendiente=0,ultimo_pago=0  where id_lote=".$row['idLote']." ");
            
            $data_l = array(
                'nombreLote'=> $datos['nombreLote'],
                'comentarioLiberacion'=> $datos['comentarioLiberacion'],
                'observacionLiberacion'=> $datos['observacionLiberacion'],
                'precio'=> $datos['precio'],
                'fechaLiberacion'=> $datos['fechaLiberacion'],
                'modificado'=> $datos['modificado'],
                'status'=> $datos['status'],
                'idLote'=> $row['idLote'],
                'userLiberacion'=> $datos['userLiberacion'],
                'tipo'=> $datos['tipo'],
                'id_cliente' => (count($id_cliente)>=1 ) ? $id_cliente[0]['id_cliente'] : 0
            );
            
            $this->db->insert('historial_liberacion',$data_l);
            
            if ($datos['activeLE'] == 0){
                $st = ($datos['activeLP'] == 1) ? 1 : 1;
                $tv = ($datos['activeLP'] == 1) ? 1 : 0;
                
                if ($tv == 1) { // LIBERACIÓN VENTA DE PARTICULAES
                    $data_lp = array(
                        'id_lote'=> $row['idLote'],
                        'nombre'=> $datos['clausulas'],
                        'estatus'=> 1,
                        "fecha_creacion" => date("Y-m-d H:i:s"),
                        "creado_por" => $datos['userLiberacion']
                    );
                    
                    $clauses_data =  $this->db->query("SELECT * FROM clausulas WHERE id_lote = ". $row['idLote'] ." AND estatus = 1")->result_array();
                    
                    if (COUNT($clauses_data) > 0) {
                        for ($i = 0; $i < COUNT($clauses_data); $i++) {
                            $this->db->query("UPDATE clausulas SET estatus = 0 WHERE id_clausula = ". $clauses_data[$i]['id_clausula'] ." AND estatus = 1");
                        }
                    }
                    
                    $this->db->insert('clausulas', $data_lp);
                } else {
                    $clauses_data =  $this->db->query("SELECT * FROM clausulas WHERE id_lote = ". $row['idLote'] ." AND estatus = 1")->result_array();
                    
                    if (COUNT($clauses_data) > 0) {
                        for ($i = 0; $i < COUNT($clauses_data); $i++) {
                            $this->db->query("UPDATE clausulas SET estatus = 0 WHERE id_clausula = ". $clauses_data[$i]['id_clausula'] ." AND estatus = 1");
                        }
                    }
                }
                
                $this->db->query("UPDATE lotes SET idStatusContratacion = 0, nombreLote = REPLACE(REPLACE(nombreLote, ' AURA', ''), ' STELLA', ''),
                    idMovimiento = 0, comentario = 'NULL', idCliente = 0, usuario = 'NULL', perfil = 'NULL ', 
                    fechaVenc = null, modificado = null, status8Flag = 0, 
                    ubicacion = 0, totalNeto = 0, totalNeto2 = 0,
                    casa = (CASE WHEN idCondominio IN (759, 639) THEN 1 ELSE 0 END),
                    totalValidado = 0, validacionEnganche = 'NULL', 
                    fechaSolicitudValidacion = null, 
                    fechaRL = null, 
                    registro_comision = 8,
                    tipo_venta = ".$tv.", 
                    observacionContratoUrgente = NULL,
                    firmaRL = 'NULL', comentarioLiberacion = 'LIBERADO', 
                    observacionLiberacion = 'LIBERADO POR CORREO', idStatusLote = ".$st.", 
                    fechaLiberacion = '".date("Y-m-d H:i:s")."', 
                    userLiberacion = '".$this->session->userdata('id_usuario')."',
                    precio = ".$datos['precio'].", total = ((".$row['sup'].") * ".$datos['precio']."),
                    enganche = (((".$row['sup'].") * ".$datos['precio'].") * 0.1), 
                    saldo = (((".$row['sup'].") * ".$datos['precio'].") - (((".$row['sup'].") * ".$datos['precio'].") * 0.1)),
                    asig_jur = 0
                    WHERE idLote IN (".$row['idLote'].") and status = 1 ");

            } else if ($datos['activeLE'] == 1){
                $this->db->query("UPDATE lotes SET idStatusContratacion = 0, 
                idMovimiento = 0, comentario = 'NULL', idCliente = 0, usuario = 'NULL', perfil = 'NULL ', 
                fechaVenc = null, modificado = null, status8Flag = 0,
                ubicacion = 0, totalNeto = 0, totalNeto2 = 0,
                totalValidado = 0, validacionEnganche = 'NULL', 
                casa = (CASE WHEN idCondominio IN (759, 639) THEN 1 ELSE 0 END),
                fechaSolicitudValidacion = null,
                fechaRL = null, 
                registro_comision = 8,
                tipo_venta = null, 
                observacionContratoUrgente = NULL,
                firmaRL = 'NULL', comentarioLiberacion = 'LIBERADO', 
                observacionLiberacion = 'LIBERADO POR CORREO', idStatusLote = 101, 
                fechaLiberacion = '".date("Y-m-d H:i:s")."', 
                userLiberacion = '".$this->session->userdata('id_usuario')."',
                precio = ".$datos['precio'].", total = ((".$row['sup'].") * ".$datos['precio']."),
                enganche = (((".$row['sup'].") * ".$datos['precio'].") * 0.1), 
                saldo = (((".$row['sup'].") * ".$datos['precio'].") - (((".$row['sup'].") * ".$datos['precio'].") * 0.1)),
                asig_jur = 0
                WHERE idLote IN (".$row['idLote'].") and status = 1 ");
            }
                
            if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }            
        }
    }

    public function get_lotes_contratados() 
    {   
        $id_usuario = $this->session->userdata('id_usuario');

        if($id_usuario == 2){
            $qry ="	SELECT h.*, l.idLote, l.nombreLote, l.idCliente, l.prorroga,
            CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS nombreCliente, cond.idResidencial, cond.idCondominio, cond.nombre, res.nombreResidencial, 
            DATEDIFF(DAY, hl.fechaEstatus9, GETDATE()) - (DATEDIFF(WEEK, hl.fechaEstatus9, GETDATE()) * 2) AS dias_transcurridos, l.idStatusLote
            FROM historial_liberacion h
            INNER JOIN lotes AS l ON l.idLote = h.idLote
            LEFT JOIN clientes AS c ON c.id_cliente = l.idCliente 
            INNER JOIN condominios AS cond ON l.idCondominio = cond.idCondominio
            INNER JOIN residenciales AS res ON cond.idResidencial = res.idResidencial
            LEFT JOIN (SELECT idLote, idCliente, MAX(modificado) AS fechaEstatus9 FROM lotes WHERE idLote IN (SELECT idLote FROM lotes WHERE idStatusLote IN (1,3) AND idStatusContratacion = 9) 
            AND status = 1 AND idStatusContratacion = 9 AND idMovimiento = 39 GROUP BY idLote, idCliente) hl ON l.idLote = hl.idLote AND l.idCliente = hl.idCliente
            WHERE l.idStatusLote IN (1,3) AND l.idStatusContratacion = 9";
        }else{
            $qry ="	SELECT h.*, l.idLote, l.nombreLote, l.idCliente, l.prorroga,
            CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS nombreCliente, cond.idResidencial, cond.idCondominio, cond.nombre, res.nombreResidencial, 
            DATEDIFF(DAY, hl.fechaEstatus9, GETDATE()) - (DATEDIFF(WEEK, hl.fechaEstatus9, GETDATE()) * 2) AS dias_transcurridos, l.idStatusLote
            FROM historial_liberacion h
            INNER JOIN lotes AS l ON l.idLote = h.idLote
            LEFT JOIN clientes AS c ON c.id_cliente = l.idCliente 
            INNER JOIN condominios AS cond ON l.idCondominio = cond.idCondominio
            INNER JOIN residenciales AS res ON cond.idResidencial = res.idResidencial
            LEFT JOIN (SELECT idLote, idCliente, MAX(modificado) AS fechaEstatus9 FROM lotes WHERE idLote IN (SELECT idLote FROM lotes WHERE idStatusLote IN (1,3) AND idStatusContratacion = 9) 
            AND status = 1 AND idStatusContratacion = 9 AND idMovimiento = 39 GROUP BY idLote, idCliente) hl ON l.idLote = hl.idLote AND l.idCliente = hl.idCliente
            WHERE l.idStatusLote IN (1,3) AND l.idStatusContratacion = 9 AND res.id_subdirector = $id_usuario;";
        }

        return $this->db->query($qry);
    }

    public function actualiza_lotes_apartados($idLote, $isProrroga)
    {
        $stl = $isProrroga == 1 ? 1 : 3; 

        $qry= "UPDATE lotes SET prorroga = $isProrroga, idStatusLote = $stl WHERE idLote = $idLote";

        return $this->db->query($qry);
    }

    public function getFilename($idDocumento) {
        return $this->db->query("SELECT * FROM historial_documento WHERE idDocumento = $idDocumento");
    }
}