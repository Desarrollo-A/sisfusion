<?php class Model_queryinventario extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

	public function getResidencialDis() {
		$this->db->select('residencial.idResidencial, residencial.nombreResidencial, residencial.descripcion');
		$this->db->from('residenciales');
		$this->db->join('condominios', 'residencial.idResidencial = condominio.idResidencial');
		$this->db->join('lotes', 'condominio.idCondominio = lotes.idCondominio');
		$this->db->where('lotes.idStatusLote','1');
		$this->db->group_by('residencial.idResidencial');
		$query = $this->db->get();
		return $query->result_array();
	}



	public function getCondominioDis($residencial) {

		$this->db->select('condominio.idCondominio, condominio.nombre');
		$this->db->from('condominios');
		$this->db->join('lotes', 'condominio.idCondominio = lotes.idCondominio');
		$this->db->where('lotes.idStatusLote','1');
		$this->db->where('condominio.status','1');
		$this->db->order_by('nombre','asc');
		$this->db->where("idResidencial",$residencial);
		$this->db->group_by('condominio.idCondominio');
		$query = $this->db->get();
		return $query->result_array();
	}






	public function getLotesDis($condominio,$residencial) {

		$this->db->select('lotes.idLote, lotes.nombreLote, lotes.precio, lotes.total, lotes.sup, condominio.tipo_lote');
		$this->db->join('condominio', 'lotes.idCondominio = condominio.idCondominio');
		$this->db->where('lotes.idCondominio', $condominio);
		$this->db->where('lotes.status','1');
		$this->db->where_in('idStatusLote', array('1'));
		$query = $this->db->get('lotes');
		if($query){
			$query = $query->result_array();
			return $query;
		}
	}



	public function getLotesDisCorrida($condominio) {

		$this->db->select('idLote,nombreLote, total, sup');
		$this->db->where('idCondominio', $condominio);
		$this->db->where('lotes.status','1');
		$this->db->where_in('idStatusLote', array('1'));
		$query = $this->db->get('lotes');
		if($query){
			$query = $query->result_array();
			return $query;
		}
	}

	/*ALL LOTES*/
    public function getLoteToEdit($lote){
        $this->db->select('idLote,nombreLote, total, sup');
        $this->db->where('idLote', $lote);
        //$this->db->where('lotes.status','1');
        $query = $this->db->get('lotes');
        if($query){
            $query = $query->result_array();
            return $query;
        }
    }


    public function getLotesDisCorridaAll($condominio) {
        $statusLoteVar = '';
        $idAsesor = '';
        $validacionStatusMov = '';
        if ($this->session->userdata('id_rol') == 6)
            $statusLoteVar = '1, 3';
        else if ($this->session->userdata('id_rol') == 7) {
            $statusLoteVar = '1, 3';
            $idAsesor = " AND id_asesor = ".$this->session->userdata('id_usuario');
        	$validacionStatusMov = ' AND idStatusContratacion= 1 AND (idMovimiento = 31 OR idMovimiento = 0)';
        }
		else if (in_array($this->session->userdata('id_rol'), [33, 17, 70, 71, 73])) {
            $statusLoteVar = '2, 3';
            $idAsesor = "";
        } else if (in_array($this->session->userdata('id_rol'), [11, 32]) || $this->session->userdata('id_usuario') == 2755) {
            $statusLoteVar = '1, 2, 3';
            $idAsesor = "";
        }
        else
            $statusLoteVar = '1';
        return $this->db->query(
			"SELECT
				lo.idLote, 
				lo.nombreLote, 
				lo.total, 
				lo.sup, 
				lo.idStatusContratacion, 
				lo.idMovimiento 
			FROM 
				lotes lo 
				INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.id_cliente = lo.idCliente AND cl.status = 1 AND YEAR(cl.fechaApartado) >= 2024 AND cl.banderaEscrituracion != 1 AND cl.proceso <= 1 $idAsesor 
			WHERE 
				lo.status = 1 
				AND idStatusLote IN ($statusLoteVar) 
				AND lo.idCondominio IN ($condominio)
					
			UNION ALL 
			SELECT 
				lo.idLote, 
				lo.nombreLote, 
				lo.total, 
				lo.sup, 
				lo.idStatusContratacion, 
				lo.idMovimiento 
			FROM 
				lotes lo 
			WHERE 
				lo.status = 1 
				AND idStatusLote IN (1) 
				AND lo.idCondominio IN ($condominio)"
		)->result();
    }


    public function getLotesDisCorridaAll_anterior($condominio) {

        // $this->db->select('idLote,nombreLote, total, sup');
        // $this->db->where('idCondominio', $condominio);
        // $this->db->where('lotes.status','1');
        $statusLoteVar = '';
        $idAsesor = '';
        $statuscl = '';
        $statuslt = '';

        if($this->session->userdata('id_rol') == 6){

            // $this->db->where_in('idStatusLote', array('1', '3'));
            $statusLoteVar = '1, 3';
            $statuscl = ' AND cl.status = 1';
            $statuslt = ' lo.status = 1 AND ';


        } else if($this->session->userdata('id_rol') == 7){
            $statusLoteVar = '1, 3';
            $idAsesor = " AND id_asesor=".$this->session->userdata('id_usuario');
            $statuscl = ' AND cl.status = 1';
            $statuslt = ' lo.status = 1 AND ';


        }else if( $this->session->userdata('id_rol')==33) {
            $statusLoteVar = '2, 3';
            $idAsesor = "";
            $statuscl = '';
            $statuslt = 'lo.status IN (0,1,2,3) AND';


        }else if($this->session->userdata('id_rol')==11 || $this->session->userdata('id_usuario') == 2755 || $this->session->userdata('id_rol') == 32 || $this->session->userdata('id_rol') == 17){
            $statusLoteVar = '1, 2, 3';
            $idAsesor = "";
            $statuscl = '';
            $statuslt = 'lo.status IN (0,1,2,3) AND';
        }
        else{

            // $this->db->where_in('idStatusLote', array('1'));
            $statusLoteVar = '1';
            $statuscl = '  AND cl.status = 1';
            $statuslt = ' lo.status = 1 AND ';


        }

        // $query = $this->db->get('lotes');


        $query = $this->db->query("SELECT lo.idLote, lo.nombreLote, lo.total, lo.sup FROM lotes lo
			LEFT JOIN clientes cl ON cl.idLote = lo.idLote AND cl.id_cliente = lo.idCliente ".$statuscl." ".$idAsesor."
			WHERE ".$statuslt." idStatusLote IN (".$statusLoteVar.") AND lo.idCondominio IN (".$condominio.")");
        return $query->result();
        // if($query){
        // $query = $query->result_array();
        // return $query;
        // }
    }





	public function insertaRegistroCliente($dato, $idLote){
		$this->db->insert('clientes',$dato);

		$idCliente = $this->db->insert_id();

		$this->db->where('idLote= "'.$idLote. '"');
		$this->db->update('lotes', array( "idStatusLote" => 8, "idCliente" => $idCliente));

		return true;


	}




	public function getLotesInfoCorrida($lote) {

		$this->db->select('idLote,nombreLote, total, sup, precio, porcentaje, enganche, condominios.msni, descSup1, descSup2, referencia, datosbancarios.banco, datosbancarios.cuenta, datosbancarios.empresa, datosbancarios.clabe');
		$this->db->join('condominios', 'lotes.idCondominio = condominios.idCondominio', 'left');
		$this->db->join('residenciales', 'condominios.idResidencial = residenciales.idResidencial', 'left');
		$this->db->join('datosbancarios', 'condominios.idDBanco = datosbancarios.idDBanco', 'left');


		$this->db->where('idLote', $lote);
		$this->db->where_in('idStatusLote', array('1'));
		$query = $this->db->get('lotes');
		if($query){
			$query = $query->result_array();
			return $query;
		}
	}








	public function getAsesoresRH(){

		$this->db->select('idAsesor, nombreAsesor, paternidad, maternidad, sede, create_at, gerente.nombreGerente');
		$this->db->join('gerente', 'asesor.idGerente = gerente.idGerente');
		$this->db->where('asesor.status','1');
		$this->db->order_by('nombreAsesor','asc');
		$query = $this->db->get('asesor');
		if($query){
			$query = $query->result_array();
			return $query;
		}
	}







	public function getValidationOff($idCondominio){


		$query = $this->db-> query('SELECT lotes.idLote, lotes.nombreLote, lotes.total, lotes.sup,
	cliente.primerNombre, cliente.segundoNombre, cliente.apellidoPaterno, cliente.apellidoMaterno, condominio.tipo_lote

	from [lotes] inner join cliente on cliente.idLote = lotes.idLote
	INNER JOIN [condominio] ON lotes.idCondominio = condominio.idCondominio
    INNER JOIN [residencial] ON condominio.idResidencial = residencial.idResidencial
	
 	where  (lotes.validacionEnganche != "VALIDADO" or lotes.validacionEnganche is null) and lotes.idStatusLote = 3 and lotes.idCondominio = "'.$idCondominio.'"

    		');


		return $query->result();


	}



	public function getCondominioEnganche($residencial) {

		$this->db->select('condominio.idCondominio, condominio.nombre');
		$this->db->from('[condominio]');
		$this->db->join('[lotes]', 'condominio.idCondominio = lotes.idCondominio');
		$this->db->join('[cliente]', 'cliente.idCliente = lotes.idCliente');

		$this->db->where('
			                  lotes.idStatusContratacion = "10" and lotes.idMovimiento  = "40" and cliente.status = "1" AND lotes.idStatusLote = "3" AND condominio.status = "1" AND condominio.idResidencial = "'.$residencial.'"
							  OR lotes.idStatusContratacion = "10" and lotes.idMovimiento  = "10" and cliente.status = "1" AND lotes.idStatusLote = "3" and condominio.status = "1" AND condominio.idResidencial = "'.$residencial.'"
			                  OR lotes.idStatusContratacion = "8" and lotes.idMovimiento  = "67" and cliente.status = "1" AND lotes.idStatusLote = "3" and condominio.status = "1" AND condominio.idResidencial = "'.$residencial.'"
							  OR lotes.idStatusContratacion = "12" and lotes.idMovimiento  = "42"  and lotes.validacionEnganche = "NULL" and cliente.status = "1" AND lotes.idStatusLote = "3" and condominio.status = "1" AND condominio.idResidencial = "'.$residencial.'"
							  OR lotes.idStatusContratacion = "12" and lotes.idMovimiento  = "42"  and lotes.validacionEnganche IS NULL and cliente.status = "1" AND lotes.idStatusLote = "3" and condominio.status = "1" AND condominio.idResidencial = "'.$residencial.'"
							  ');

		$this->db->order_by('nombre','asc');
		$this->db->group_by('condominio.idCondominio');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function getMCarsApartadoLote($idLote, $type){

		$resultado = "";
		switch ($type){
			case 'PNP':
				$this->db->where("idLote",$idLote);
				$this->db->where('idStatusLote', 1);
				$query= $this->db->get("[lotes]");

				if( $query->num_rows() > 0 ){
					$dato = array(
						'idStatusLote' => 99,
						'modificado' => date('Y-m-d H:i:s')
					);
					$this->db->update('[lotes]', $dato, "idLote = $idLote");
					$resultado = 'false';
				}else{
					$resultado ='true';
				}
				break;
			case 'NPN':
				$dato = array(
					'idStatusLote' => 1,
					'modificado' => date('0000-00-00 00:00:00')
				);
				$query= $this->db->update('[lotes]', $dato, "idLote = $idLote");
				$resultado ='true';
				break;
			default:
		}

		return $resultado;


	}

	public function getMProyectoCarsLote($idLote){
		$this->db->select('nombreResidencial');
		$this->db->join('[condominio]', 'lotes.idCondominio = condominio.idCondominio');
		$this->db->join('[residencial]', 'condominio.idResidencial = residencial.idResidencial');
		$this->db->where('lotes.idLote', $idLote);
		$query = $this->db->get('[lotes]');
		return $query;
	}

	public function getConfirPagoCars($folio){
		$this->db->select('cliente.noRecibo, cliente.idCliente, lotes.idCondominio, cliente.idLote, cliente.primerNombre, cliente.segundoNombre, cliente.apellidoPaterno, cliente.apellidoMaterno, lotes.nombreLote, condominio.nombre, residencial.idResidencial, residencial.descripcion, cliente.engancheCliente, cliente.fechaEnganche');
		$this->db->join('[lotes]', 'cliente.idLote = lotes.idLote');
		$this->db->join('[condominio]', 'lotes.idCondominio = condominio.idCondominio');
		$this->db->join('[residencial]', 'condominio.idResidencial = residencial.idResidencial');
		$this->db->where('cliente.noRecibo', $folio);
		$query = $this->db->get('[clientes]');

		return $query->result_array();
	}

	public function insertHistorialoteCars($arreglo){
		//$this->db->insert( 'historial_lotes', $arreglo );

		for ($j=0; $j < count($arreglo ); $j++){
			$this->db->insert('[historial_lotes]', $arreglo[$j] );
		}
		return true;
	}

	public function updateLoteCars($iniciar_proceso, $iniciar_process){
		for ($j=0; $j < count($iniciar_proceso ); $j++){
			$this->db->where( "idLote", $iniciar_process[$j]['idLote'] );
			$this->db->update( '[lotes]', $iniciar_proceso[$j] );
		}
		return true;
	}

	public function updateClienteCars($confirm_cliente, $iniciar_process){
		for ($j=0; $j < count($iniciar_process ); $j++){
			$this->db->where( "idLote", $iniciar_process[$j]['idLote'] );
			$this->db->update( '[clientes]', $confirm_cliente[$j] );
		}
		return true;
	}

	public function getUpdateLotefinishTimeCars(){
		$this->db->where("idLote",$idLote);
		$this->db->update('[lotes]', $dato);
	}

	public function getConfirPagoCarsPrueba(){
		$this->db->select('cliente.noRecibo, cliente.idCliente, lotes.idCondominio, cliente.idLote, cliente.primerNombre, cliente.segundoNombre, cliente.apellidoPaterno, cliente.apellidoMaterno, lotes.nombreLote, condominio.nombre, residencial.idResidencial, residencial.descripcion, cliente.engancheCliente, cliente.fechaEnganche');
		$this->db->join('[lotes]', 'cliente.idLote = lotes.idLote');
		$this->db->join('[condominio]', 'lotes.idCondominio = condominio.idCondominio');
		$this->db->join('[residencial]', 'condominio.idResidencial = residencial.idResidencial');
		$this->db->where('cliente.noRecibo', 'CONFPAGO11072019094159');
		$query = $this->db->get('[cliente]');
		return $query->result_array();
	}

	public function registraCajaCars($confirmaci_caja){
		for ($j=0; $j < count($confirmaci_caja ); $j++){

			$url = 'https://test.gphsis.com/Proyecto/DatosONLINE';

			$data = array(
				'Proyecto' => $confirmaci_caja[$j]['Proyecto'],
				'Referencia' => $confirmaci_caja[$j]['Referencia'],
				'lote' => $confirmaci_caja[$j]['lote'],
				'NomCliente' => $confirmaci_caja[$j]['NomCliente'],
				'Total' =>  $confirmaci_caja[$j]['Total'],
				'FechaPago' => $confirmaci_caja[$j]['FechaPago'],
				'MontoCantidadLetra' => $confirmaci_caja[$j]['MontoCantidadLetra'],
				'FolioCompuesto' => $confirmaci_caja[$j]['FolioCompuesto']
			);

			$options = array(
				'http' => array(
					'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
					'method'  => 'POST',
					'content' => http_build_query($data)
				)
			);

			$context  = stream_context_create($options);
			$result = file_get_contents($url, false, $context);


			$mail = $this->phpmailer_lib->load();
	
			$mail->setFrom('noreply@ciudadmaderas.com', 'Ciudad Maderas');
			$mail->addAddress("programador.analista2@ciudadmaderas.com");
			$mail->Subject = utf8_decode('Apartado desde la página Ciudad Maderas');
			$mail->isHTML(true);


			$mailContent = utf8_decode("
	<center><img src='https://www.ciudadmaderas.com/assets/img/logo.png' width='900' height='120'/></center>
	<br> 
    <br>
	Se ha realizado un apartado online. A continuación se muestra la información de la transacción: 
	<br>
	");

			foreach($data as $info=>$dato) {
				$mailContent.= utf8_decode("
			".'<b>'.$info.': '.'</b>'.$dato.'<br>'."
		");
			}
			$mail->Body = $mailContent;
			$mail->send();
		}
		return true;
	}





	public function getPaquetes($idLote){

		$query = $this->db-> query('SELECT id_descuento from lotes where idLote = "'.$idLote.'" ');

		foreach ($query->result_array() as $desc)
		{
		}
		$query = $this->db-> query('SELECT id_paquete, descripcion from paquetes WHERE id_paquete IN ('.$desc['id_descuento'].')');

		return $query->result_array();
	}



	public function getDescuentos(){

		$query = $this->db-> query('SELECT de.porcentaje, re.id_paquete, re.prioridad, co.apply, de.id_condicion, re.id_descuento 
		FROM relaciones re
		INNER JOIN descuentos de ON re.id_descuento = de.id_descuento
		INNER JOIN condiciones co ON co.id_condicion = de.id_condicion 
		ORDER BY prioridad');

		return $query->result_array();
	}






	public function insertCf($dato){
		$this->db->insert('corridas_financieras',$dato);
		$id_corrida = $this->db->insert_id();
		$query = $this->db-> query("SELECT id_corrida from corridas_financieras where id_corrida = $id_corrida");
		return $query->result_array();
	}





	public function insertPreciosAll($dato, $idLote, $idCorrida){

		for($i=0;$i<count($dato);$i++) {
			$data = array(
				'ahorro'=> $dato[$i]->ahorro,
				'pt'=> $dato[$i]->pt,
				'pm'=> $dato[$i]->pm,
				'idLote'=> $idLote,
				'id_corrida'=> $idCorrida
			);

			$this->db->insert('precios_finales',$data);
		}

	}



	public function getinfoCorrida($id_corrida) {
		$this->db->select('id_lote, nombre, edad, telefono, correo, id_asesor, id_gerente, plan, anio, dias_pagar_enganche, porcentaje_enganche, cantidad_enganche, meses_diferir, apartado, paquete, opcion_paquete, 
            precio_m2_final, saldo, precio_final, fecha_limite, pago_enganche, msi_1p, msi_2p, msi_3p, primer_mensualidad, observaciones, finalMesesp1, finalMesesp2, finalMesesp3');

		$this->db->where('id_corrida', $id_corrida);
		$this->db->where('status', '1');

		$query= $this->db->get("corridas_financieras");
		return $query->row();

	}





	public function getinfoLoteCorrida($id_lote) {

		$this->db->select('idLote, nombreLote, referencia, condominio.nombre as nombreCondominio, residencial.nombreResidencial, sup, precio, total, porcentaje, enganche, datosbancarios.empresa,
	        datosbancarios.banco, datosbancarios.cuenta, datosbancarios.clabe');
		$this->db->from('lotes');
		$this->db->join('condominio', 'lotes.idCondominio = condominio.idCondominio');
		$this->db->join('residencial', 'condominio.idResidencial = residencial.idResidencial');
		$this->db->join('datosbancarios', 'condominio.idDBanco = datosbancarios.idDBanco');

		$this->db->where('idLote', $id_lote);
		$this->db->where('lotes.status', '1');

		$query = $this->db->get();
		return $query->row();
	}



	public function getinfoDescLoteCorrida($idLote, $id_corrida) {
		$this->db->select('id_pf, pt, pm, ahorro, idLote, id_corrida');

		$this->db->where('idLote', $idLote);
		$this->db->where('id_corrida', $id_corrida);

		$query= $this->db->get("precios_finales");
		return $query->result_array();

	}






	public function getAsesorCorrida($id_asesor, $id_gerente) {

		$this->db->select('asesor.idAsesor, asesor.nombreAsesor, asesor.idGerente, gerente.nombreGerente');
		$this->db->from('[asesor]');
		$this->db->join('gerente', 'asesor.idGerente = gerente.idGerente');
		$this->db->where('asesor.idAsesor', $id_asesor);
		$this->db->where('asesor.idGerente', $id_gerente);
		$this->db->where('asesor.status', '1');
		$query = $this->db->get();
		return $query->row();
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





	public function getPlanCorrida($id_corrida) {
		$this->db->select('id_cd, fecha, pago, capital, interes, total, saldo, id_corrida');

		$this->db->where('id_corrida', $id_corrida);

		$query= $this->db->get("corrida_dump");
		return $query->result_array();

	}


}


