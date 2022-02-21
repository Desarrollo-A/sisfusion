<?php class Corrida_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

		public function getPaquetes($idLote){

		$query = $this->db-> query('SELECT id_descuento from [lotes] where idLote = '.$idLote.'');

		foreach ($query->result_array() as $desc)
		{
		}
		$query = $this->db-> query('SELECT id_paquete, descripcion from [paquetes] WHERE estatus = 1 and id_paquete IN ('.$desc['id_descuento'].')');

		return $query->result_array();
	}
 

	public function getGerente(){
		$query = $this->db-> query("SELECT u.id_rol, u.estatus, u.id_usuario idGerente, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreGerente 
                                FROM usuarios u WHERE u.id_rol = 3 AND u.estatus = 1 ORDER BY nombreGerente");
		return $query->result_array();
	}

		public function getCoordinador($gerent){
		$query = $this->db->query("SELECT u.id_lider, u.id_rol, u.estatus, u.id_usuario idCoordinador, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreCoordinador 
                                FROM usuarios u WHERE u.id_rol = 9 AND u.estatus = 1 AND u.id_lider IN (".$gerent.")
                                UNION ALL
                                SELECT u.id_lider, u.id_rol, u.estatus, u.id_usuario idCoordinador, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreCoordinador 
                                FROM usuarios u WHERE u.id_rol = 3 AND u.estatus = 1 AND u.id_usuario IN (".$gerent.") ORDER BY nombreCoordinador");
		return $query->result_array();
	}

	public function getAsesores($coordinador){
		$query = $this->db->query("SELECT u.id_lider, u.id_rol, u.estatus, u.id_usuario idAsesor, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreAsesor 
                                FROM usuarios u WHERE u.id_rol = 7 AND u.estatus = 1 AND u.id_lider IN (".$coordinador.")
                                UNION SELECT u.id_lider, u.id_rol, u.estatus, u.id_usuario idAsesor, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreAsesor 
								FROM usuarios u WHERE u.id_rol = 9 AND u.estatus = 1 AND u.id_usuario IN (".$coordinador.")
								UNION SELECT u.id_lider, u.id_rol, u.estatus, u.id_usuario idAsesor, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreAsesor 
								FROM usuarios u WHERE u.id_rol = 3 AND u.estatus = 1 AND u.id_usuario IN (".$coordinador.") ORDER BY nombreAsesor");
		return $query->result_array();
	}


 
 	public function insertCorrida($dato, $id_corrida){

		for($i=0;$i<count($dato);$i++) {
			$data = array(
				'fecha'=> $dato[$i]->fecha,
				'pago'=> $dato[$i]->pago,
				'capital'=> $dato[$i]->capital,
				'interes'=> $dato[$i]->interes,
				'total'=> $dato[$i]->total,
				'saldo'=> $dato[$i]->saldo,
				'id_corrida'=> $id_corrida
			);

			$this->db->insert('corrida_dump',$data);
		}

	}




	public function getinfoCorrida_mala($id_corrida) {
		return $this->db->query("SELECT id_lote, nombre, edad, telefono, correo, id_asesor, id_gerente, plan_corrida, anio, dias_pagar_enganche, porcentaje_enganche, cantidad_enganche, 
                            meses_diferir, apartado, paquete, opcion_paquete, precio_m2_final, saldo, precio_final, fecha_limite, pago_enganche, msi_1p, msi_2p, msi_3p, primer_mensualidad, observaciones, 
                            finalMesesp1, finalMesesp2, finalMesesp3 FROM corridas_financieras WHERE id_corrida = ".$id_corrida." AND status = 1");
 
	}
	public function getinfoCorrida($id_corrida) {
		$query = $this->db->query("SELECT id_lote, nombre, edad, telefono, correo, id_asesor, id_gerente, plan_corrida, anio, dias_pagar_enganche, porcentaje_enganche, cantidad_enganche, 
                            meses_diferir, apartado, paquete, opcion_paquete, precio_m2_final, saldo, precio_final, fecha_limite, pago_enganche, msi_1p, msi_2p, msi_3p, primer_mensualidad, observaciones, 
                            finalMesesp1, finalMesesp2, finalMesesp3 FROM corridas_financieras WHERE id_corrida = ".$id_corrida." AND status = 1");
              return $query->row();
 
	}

	public function getinfoLoteCorrida_mala($id_lote) {
		return $this->db->query("SELECT idLote, nombreLote, referencia, con.nombre as nombreCondominio, res.nombreResidencial, sup, precio, total, porcentaje, enganche, dbc.empresa, 
                            dbc.banco, dbc.cuenta, dbc.clabe FROM [lotes] lot INNER JOIN [condominios] con ON con.idCondominio = lot.idCondominio 
                            INNER JOIN [residenciales] res ON res.idResidencial = con.idResidencial 
                            INNER JOIN [datosbancarios] dbc ON con.idDBanco = dbc.idDBanco WHERE lot.status = 1 AND lot.idLote = ".$id_lote."");
	}
	public function getinfoLoteCorrida($id_lote) {
		$query = $this->db->query("SELECT idLote, nombreLote, referencia, con.nombre as nombreCondominio, res.nombreResidencial, sup, precio, total, porcentaje, enganche, dbc.empresa, 
                            dbc.banco, dbc.cuenta, dbc.clabe FROM [lotes] lot INNER JOIN [condominios] con ON con.idCondominio = lot.idCondominio 
                            INNER JOIN [residenciales] res ON res.idResidencial = con.idResidencial 
                            INNER JOIN [datosbancarios] dbc ON con.idDBanco = dbc.idDBanco WHERE lot.status = 1 AND lot.idLote = ".$id_lote."");
		 return $query->row();
	}

	public function getinfoDescLoteCorrida_mala($idLote, $id_corrida) {
		return $this->db-> query("SELECT id_pf, precio_t as pt, precio_m as pm, ahorro, idLote, id_corrida FROM [precios_finales] WHERE idLote = ".$idLote." AND id_corrida = ".$id_corrida."");
	}
	public function getinfoDescLoteCorrida($idLote, $id_corrida) {
		$query = $this->db-> query("SELECT id_pf, porcentaje, precio_t as pt, precio_m as pm, ahorro, idLote, id_corrida, id_condicion FROM [precios_finales] WHERE idLote = ".$idLote." AND id_corrida = ".$id_corrida."");
		return $query->result_array();
	}

	public function getAsesorCorrida_mala($id_asesor, $id_gerente) {
		return $this->db->query("SELECT u.id_usuario idAsesor, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreAsesor, uu.id_usuario idCoordinador, 
                                CONCAT(uu.nombre, ' ', uu.apellido_paterno, ' ', uu.apellido_materno) nombreCoordinador, uuu.id_usuario idGerente, CONCAT(uuu.nombre, ' ', uuu.apellido_paterno, ' ', uuu.apellido_materno) nombreGerente 
                                FROM [usuarios] u INNER JOIN [usuarios] uu ON uu.id_usuario = u.id_lider 
                                INNER JOIN [usuarios] uuu ON uuu.id_usuario = uu.id_lider WHERE u.id_rol = 7 AND u.estatus = 1 AND u.id_usuario = ".$id_asesor." AND uuu.id_usuario =  ".$id_gerente."");
	}

	public function getAsesorCorrida($id_asesor, $id_gerente) {
		$query = $this->db->query("SELECT u.id_usuario idAsesor, uu.id_usuario idCoordinador, uuu.id_usuario idGerente, 
		                           CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreAsesor,
                                   CONCAT(uu.nombre, ' ', uu.apellido_paterno, ' ', uu.apellido_materno) nombreCoordinador,
								   CONCAT(uuu.nombre, ' ', uuu.apellido_paterno, ' ', uuu.apellido_materno) nombreGerente 
                                   FROM [usuarios] u 
								   INNER JOIN [usuarios] uu ON uu.id_usuario = u.id_lider 
                                   INNER JOIN [usuarios] uuu ON uuu.id_usuario = uu.id_lider 
								   
								   WHERE u.id_rol = 7 AND u.estatus = 1 AND u.id_usuario = ".$id_asesor." AND uuu.id_usuario =  ".$id_gerente."");
		return $query->row();
	}

	public function getCoordCorrida($id_asesor, $id_gerente) {
		$query = $this->db->query("SELECT u.id_usuario idAsesor, uu.id_usuario idCoordinador,  
		                           CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreAsesor,
                                   CONCAT(uu.nombre, ' ', uu.apellido_paterno, ' ', uu.apellido_materno) nombreGerente
                                   FROM [usuarios] u 
								   INNER JOIN [usuarios] uu ON uu.id_usuario = u.id_lider 
								   WHERE u.id_rol = 9 AND u.estatus = 1 AND u.id_usuario = ".$id_asesor." AND uu.id_usuario =  ".$id_gerente."");
		return $query->row();
	}

	public function getGerenteCorrida($id_asesor, $id_gerente) {
		$query = $this->db->query("SELECT u.id_usuario idAsesor, uu.id_usuario idCoordinador,  
		                           CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreAsesor,
                                   CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombreGerente
                                   FROM [usuarios] u 
								   INNER JOIN [usuarios] uu ON uu.id_usuario = u.id_lider 
								   WHERE u.id_rol = 3 AND u.estatus = 1 AND u.id_usuario = ".$id_asesor."");
		return $query->row();
	}

	public function getPlanCorrida_mala($id_corrida) {
		return $this->db->query("SELECT id_cd, fecha, pago, capital, interes, total, saldo, id_corrida FROM corrida_dump WHERE id_corrida = ".$id_corrida."");
	}
	public function getPlanCorrida($id_corrida) {
		$query = $this->db->query("SELECT id_cd, fecha, pago, capital, interes, total, saldo, id_corrida FROM corrida_dump WHERE id_corrida = ".$id_corrida."");
		return $query->result_array();
	}

	

		public function getDescuentos(){
			$query = $this->db-> query('SELECT descuentos.porcentaje, relaciones.id_paquete, relaciones.prioridad, descuentos.apply, descuentos.id_condicion, relaciones.id_descuento, relaciones.msi_descuento FROM [relaciones] inner join [descuentos] on relaciones.id_descuento = descuentos.id_descuento order by prioridad');

		return $query->result_array();
	}


		public function insertCf($dato){
		$this->db->insert('corridas_financieras',$dato);
		$id_c = $this->db->query("SELECT IDENT_CURRENT('corridas_financieras') as lastId")->result_array();
		
		$query = $this->db-> query("SELECT id_corrida from corridas_financieras where id_corrida = ".$id_c[0]['lastId']."");
		return $query->result_array();
	}



	public function insertPreciosAll($dato, $idLote, $idCorrida){
		
		

		for($i=0;$i<count($dato);$i++) {
			$data = array(
			    'porcentaje'=> $dato[$i]->porcentaje,
				'precio_t'=> $dato[$i]->pt,
				'precio_m'=> $dato[$i]->pm,
				'ahorro'=> $dato[$i]->ahorro,
				'idLote'=> $idLote,
				'id_condicion'=> $dato[$i]->id_condicion,
				'id_corrida'=> $idCorrida
			);

// var_dump($data);
			$this->db->insert('precios_finales',$data);
		}

	}



	public function getResidencialDis() {
		$query = $this->db->query("SELECT res.idResidencial, res.nombreResidencial,  CAST(res.descripcion AS NVARCHAR(100)) as descripcion 
                                FROM [residenciales] res INNER JOIN [condominios] con ON con.idResidencial = res.idResidencial 
                                INNER JOIN [lotes] lot ON lot.idCondominio = con.idCondominio WHERE lot.idStatusLote = 1 GROUP BY res.idResidencial,res.nombreResidencial,  CAST(res.descripcion AS NVARCHAR(100)) ORDER BY res.idResidencial");
		return $query->result_array();
	}


		public function getCondominioDis($residencial) {
			
		    if($this->session->userdata('id_rol') == 6){

			$query = $this->db->query("SELECT con.idCondominio, con.nombre FROM [condominios] con JOIN [lotes] ON con.idCondominio = lotes.idCondominio 
                                    WHERE lotes.idStatusLote in ('1', '3') AND con.status = '1' AND idResidencial = ".$residencial." GROUP BY con.idCondominio, con.nombre ORDER BY con.nombre ASC");
			} else {
				
			$query = $this->db->query("SELECT con.idCondominio, con.nombre FROM [condominios] con JOIN [lotes] ON con.idCondominio = lotes.idCondominio 
                                    WHERE lotes.idStatusLote = '1' AND con.status = '1' AND idResidencial = ".$residencial." GROUP BY con.idCondominio, con.nombre ORDER BY con.nombre ASC");

				
			}						
									
		return $query->result_array();

		// $this->db->select('condominio.idCondominio, condominio.nombre');
		// $this->db->from('condominio');
		// $this->db->join('lotes', 'condominio.idCondominio = lotes.idCondominio');
		// $this->db->where('lotes.idStatusLote','1');
		// $this->db->where('condominio.status','1');
		// $this->db->order_by('nombre','asc');
		// $this->db->where("idResidencial",$residencial);
		// $this->db->group_by('condominio.idCondominio');
		// $query = $this->db->get();
		// return $query->result_array();
	}


	public function getRol($id_asesor) {
		$query = $this->db->query("SELECT u.id_usuario idAsesor, u.id_rol FROM [usuarios] u WHERE u.id_usuario = ".$id_asesor." ");
		return $query->row();
	}


	


}