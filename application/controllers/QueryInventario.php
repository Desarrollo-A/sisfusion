<?php class QueryInventario extends CI_Controller {

	public function __construct() {

		parent::__construct();
		header('Access-Control-Allow-Origin: *');
		$this->load->model('model_queryinventario');
        $this->load->model('asesor/Asesor_model');
		$this->load->library(array('session','form_validation'));
		$this->load->library('phpmailer_lib');
		$this->load->helper(array('url','form'));
		$this->load->database('default');
		date_default_timezone_set('America/Mexico_City');

	}

	function getResidencialDisponible() {
		$recidenciales = $this->model_queryinventario->getResidencialDis();
		if($recidenciales != null) {
			echo json_encode($recidenciales);
		} else {
			echo json_encode(array());
		}
	}

	function getCondominioDisponible() {
		$condominio = $this->model_queryinventario->getCondominioDis($this->input->post('residencial'));
		if($condominio != null) {
			echo json_encode($condominio);
		} else {
			echo json_encode(array());
		}
	}

	function getLoteDisponible() {
		$lotes = $this->model_queryinventario->getLotesDis($this->input->post('condominio'), $this->input->post('residencial'));
		if($lotes != null) {
			echo json_encode($lotes);
		} else {
			echo json_encode(array());
		}
	}

	function asesores_disponibles(){
		$this->db->select("idAsesor, nombreAsesor, nombreGerente");
		$this->db->join('gerente', 'asesor.idGerente = gerente.idGerente');
		$this->db->where("asesor.status", 1);
		$this->db->where("idAsesor !=", 834);
		$this->db->where("nombreAsesor !=", '');
		$this->db->order_by("nombreAsesor", "asc");
		echo json_encode($this->db->get("asesor")->result_array());
	}

	function gerentes_disponibles(){
		$this->db->select("idGerente, nombreGerente");
		$this->db->where("status", 1);
		$this->db->order_by("nombreGerente", "asc");
		echo json_encode($this->db->get("gerente")->result_array());
	}

	function asesores_disponiblesbygen(){
		$this->db->select("idAsesor, nombreAsesor");
		$this->db->where("status", 1);
		$this->db->where("idAsesor !=", 834);
		$this->db->where("nombreAsesor !=", '');
		$this->db->where("idGerente =", $this->input->post("idGerente"));
		$this->db->order_by("nombreAsesor", "asc");
		echo json_encode($this->db->get("asesor")->result_array());
	}

	public function insertarClienteOnline(){

		$array = $this->input->post('idlote');
		$tipolote = $this->input->post('tipolote');
		for($j=0;$j<count($array);$j++){
			$this->load->model("registrolote_modelo");

			$fechaApartado= date('Y-m-d H:i:s');

			$fechaAccion = date("Y-m-d H:i:s");
			$hoy_strtotime2 = strtotime($fechaAccion);
			$sig_fecha_dia2 = date('D', $hoy_strtotime2);
			$sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
			$fecha = $fechaAccion;

			$limite = in_array( $sig_fecha_dia2, array( "Sat", "Sun" ) ) || in_array( $sig_fecha_feriado2, array( "01-01", "06-02", "20-03", "01-05", "16-09", "20-11", "19-11", "25-12" ) ) ? 46 : 45;

			$i = 0;
			while( $i <= $limite ) {
				$hoy_strtotime = strtotime($fecha);
				$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
				$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
				$sig_fecha_dia = date('D', $sig_strtotime);
				$sig_fecha_feriado = date('d-m', $sig_strtotime);

				if( !in_array( $sig_fecha_dia, array( "Sat", "Sun" ) ) && !in_array( $sig_fecha_feriado2, array( "01-01", "06-02", "20-03", "01-05", "16-09", "20-11", "19-11", "25-12" ) ) ) {
					$i++;
				}

				$fecha = $sig_fecha;
			}

			$arreglo = array();

			$arreglo["fechaVencimiento"] = $fecha;
			$arreglo["segundoNombre"]=$this->input->post('segundo_nombre');

			if( $this->input->post('asesor') && !empty( $this->input->post('asesor') ) ){
				if( is_array( $this->input->post('asesor') ) ){
					for( $i = 1; $i <= 5 && ( $i - 1 ) < count( $this->input->post('asesor') ) ; $i++ ){
						$asesor = $i > 1 ? "idAsesor".$i : "idAsesor";
						$arreglo[$asesor] = $this->input->post('asesor')[ $i - 1 ];
					}
				}else{
					$arreglo["idAsesor"] = $this->input->post('asesor');
				}
			}else{
				$arreglo["idAsesor"] = 834;
			}

			$arreglo["fechaEnganche"] = date('Y-m-d H:i:s');
			$arreglo["fechaApartado"] = date('Y-m-d H:i:s');

			if(!empty($arreglo["primerNombre"] = $this->input->post('primer_nombre')) AND
				!empty($arreglo["apellidoPaterno"] = $this->input->post('ap_paterno')) AND
				!empty($arreglo["apellidoMaterno"] = $this->input->post('ap_materno')) AND
				!empty($arreglo["correo"] = $this->input->post('correo')) AND
				!empty($arreglo["telefono1"] = $this->input->post('telefono')) AND
				!empty($arreglo["concepto"] = $this->input->post('concepto'))          AND
				!empty($arreglo["noRecibo"] = $this->input->post('num_operacion'))     AND
				!empty($arreglo["idCondominio"] = $this->input->post('condominio'))  AND
				!empty($arreglo["idLote"] = $array[$j])              AND
				!empty($arreglo["user"] = $this->input->post('user_op'))
			){
				if($tipolote[$j] == 0){
					$arreglo["engancheCliente"] = '10000.00';
				}else{
					$arreglo["engancheCliente"] = '50000.00';
				}


				echo json_encode( $this->model_queryinventario->insertaRegistroCliente( $arreglo, $arreglo["idLote"] ) );
			}else{
				echo json_encode( FALSE );
			}
		}

	}

	function confirmarPago(){
		if($this->input->post('folio')){
			$informacion_comprador = $this->model_queryinventario->getConfirPagoCars( $this->input->post('folio') );
			$foliocompuesto = $this->input->post('folio');
			$referencia = $this->input->post('num_operacion');

			$arreglo = array();
			$iniciar_proceso = array();
			$iniciar_process = array();
			$confirmaci_caja = array();
			$confirm_cliente = array();
			for ($j=0; $j < count($informacion_comprador ); $j++){

				$horaActual = date('H:i:s');
				$horaInicio = date("08:00:00");
				$horaFin = date("16:00:00");

				$fecha_apartado = date("Y-m-d H:i:s");
				$fecha = $fecha_apartado;

				$limite = $horaActual > $horaInicio && $horaActual < $horaFin ? 5 : 6;

				$i = 0;

				while( $i <= $limite ) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);

					if( !in_array( $sig_fecha_dia, array( "Sat", "Sun" ) ) && !in_array( $sig_fecha_feriado, array( "01-01", "06-02", "20-03", "01-05", "16-09", "20-11", "19-11", "25-12" ) ) ) {
						$i++;
					}

					$fecha = $sig_fecha;
				}

				$arreglo[$j]["nombreLote"] = $informacion_comprador[$j]['nombreLote'];
				$arreglo[$j]["idStatusContratacion"] = 1;
				$arreglo[$j]["idMovimiento"] = 31;
				$arreglo[$j]["modificado"] = date("Y-m-d H:i:s");
				$arreglo[$j]["fechaVenc"] = $fecha_apartado;
				$arreglo[$j]["idLote"] = $informacion_comprador[$j]['idLote'];
				$arreglo[$j]["idCondominio"] = $informacion_comprador[$j]['idCondominio'];
				$arreglo[$j]["idCliente"] = $informacion_comprador[$j]['idCliente'];
				$arreglo[$j]["user"] = 'PAGINA DE CIUDAD MADERAS';
				$arreglo[$j]["comentario"] = 'APARTADO DESDE LA PAGINA DE CIUDAD MADERAS';
				$arreglo[$j]["perfil"] = 'caja';
				$arreglo[$j]["status"] = 1;

				$iniciar_proceso[$j]["idStatusContratacion"] = 1;
				$iniciar_proceso[$j]["idMovimiento"] = 31;
				$iniciar_proceso[$j]["comentario"] = "APARTADO DESDE LA PAGINA DE CIUDAD MADERAS";
				$iniciar_proceso[$j]["idStatusLote"] = 3;
				$iniciar_proceso[$j]["idCliente"] = $informacion_comprador[$j]['idCliente'];
				$iniciar_proceso[$j]["user"] = "PAGINA DE CIUDAD MADERAS";
				$iniciar_proceso[$j]["perfil"] = "caja";
				$iniciar_proceso[$j]["modificado"] = $fecha_apartado;
				$iniciar_proceso[$j]["fechaVenc"] = $fecha;

				$iniciar_process[$j]["idLote"] = $informacion_comprador[$j]['idLote'];

				$confirmaci_caja[$j]["Proyecto"] = $informacion_comprador[$j]['descripcion'];
				$confirmaci_caja[$j]["Referencia"] = $referencia;
				$confirmaci_caja[$j]["lote"] = $informacion_comprador[$j]['nombreLote'];
				$confirmaci_caja[$j]["NomCliente"] = $informacion_comprador[$j]['primerNombre']. " " .$informacion_comprador[$j]['segundoNombre']. " " .$informacion_comprador[$j]['apellidoPaterno']. " " .$informacion_comprador[$j]['apellidoMaterno'];
				$confirmaci_caja[$j]["Total"] = $informacion_comprador[$j]['engancheCliente'];
				$confirmaci_caja[$j]["FechaPago"] = $informacion_comprador[$j]['fechaEnganche'];
				$confirmaci_caja[$j]["MontoCantidadLetra"] = ( $informacion_comprador[$j]['engancheCliente'] == "10000.00" ) ? "DIEZ MIL CON 00/100 CENTAVOS M.N." : "CINCUENTA MIL CON 00/100 CENTAVOS M.N." ;
				$confirmaci_caja[$j]["FolioCompuesto"] = $foliocompuesto;

				$confirm_cliente[$j]["noRecibo"] = $referencia;
				$confirm_cliente[$j]["idTipoPago"] = 1;
				$confirm_cliente[$j]["concepto"] = "APARTADO DESDE LA PAGINA DE CIUDAD MADERAS";

			}
			$resultOne = $this->model_queryinventario->insertHistorialoteCars($arreglo);
			$resultTwo = $this->model_queryinventario->updateLoteCars($iniciar_proceso, $iniciar_process );
			$resultFor = $this->model_queryinventario->updateClienteCars($confirm_cliente, $iniciar_process );
			$resultThree = $this->model_queryinventario->registraCajaCars($confirmaci_caja );
			echo json_encode( $confirmaci_caja );

		}else{
			echo json_encode( FALSE );
		}
	}

	function finish_TimeCars(){
		$this->model_queryinventario->getUpdateLotefinishTimeCars();
	}

	function declinadoPago(){
		if($this->input->post('idLote')){

			$idLote = $this->input->post('idLote');
			//OBTENEMOS EL ID DEL CLIENTE;
			$idCliente = $this->db->select('idCliente')->where('idLote', $idLote)->get('lotes')->row();

			//REINICIAMOS EL LOTE LIBERAMOS Y BORRAMOS AL CLIENTE EN CASO QUE LA OPERACION NO SE HAYA CONFIRMADO POR EL BANCO
			$this->db->update('lotes', array( "idStatusLote" => 1, "idCliente" => NULL), "idLote = '$idLote'");
			$this->db->delete('cliente', array('idCliente' => $idCliente->idCliente));
		}
	}

	function check_apartado_lote(){
		echo json_encode( array($this->db->query("SELECT lotes.idLote FROM lotes WHERE lotes.idStatusLote = 1 AND lotes.idLote = '".$this->input->post("idLote")."'")->num_rows() ) );
	}

	public function insertarClienteCaja(){

		$this->load->model("registrolote_modelo");
		$fechaApartado= date('Y-m-d H:i:s');
		$fechaAccion = date("Y-m-d H:i:s");
		$hoy_strtotime2 = strtotime($fechaAccion);
		$sig_fecha_dia2 = date('D', $hoy_strtotime2);
		$sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
		$fecha = $fechaAccion;

		$limite = in_array( $sig_fecha_dia2, array( "Sat", "Sun" ) ) || in_array( $sig_fecha_feriado2, array( "01-01", "06-02", "20-03", "01-05", "16-09", "20-11", "19-11", "25-12" ) ) ? 46 : 45;

		$i = 0;
		while( $i <= $limite ) {
			$hoy_strtotime = strtotime($fecha);
			$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
			$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
			$sig_fecha_dia = date('D', $sig_strtotime);
			$sig_fecha_feriado = date('d-m', $sig_strtotime);

			if( !in_array( $sig_fecha_dia, array( "Sat", "Sun" ) ) && !in_array( $sig_fecha_feriado2, array( "01-01", "06-02", "20-03", "01-05", "16-09", "20-11", "19-11", "25-12" ) ) ) {
				$i++;
			}

			$fecha = $sig_fecha;
		}

		$arreglo = array();
		$arreglo["fechaVencimiento"] = $fecha;
		$arreglo["segundoNombre"]=$this->input->post('segundo_nombre');

		if( $this->input->post('asesor') && !empty( $this->input->post('asesor') ) ){
			if( is_array( $this->input->post('asesor') ) ){
				for( $i = 1; $i <= 5 && ( $i - 1 ) < count( $this->input->post('asesor') ) ; $i++ ){
					$asesor = $i > 1 ? "idAsesor".$i : "idAsesor";
					$arreglo[$asesor] = $this->input->post('asesor')[ $i - 1 ];
				}
			}else{
				$arreglo["idAsesor"] = $this->input->post('asesor');
			}
		}else{
			$arreglo["idAsesor"] = 834;
		}
		$arreglo["fechaEnganche"] = date('Y-m-d H:i:s');
		$arreglo["fechaApartado"] = date('Y-m-d H:i:s');
		$arreglo["idTipoPago"] = 1;
		$arreglo["telefono1"] = $this->input->post('telefono');
		$arreglo["correo"] = $this->input->post('correo');
		$se_puede_apartar = FALSE;
		if(!empty($arreglo["primerNombre"] = $this->input->post('primer_nombre')) AND
			!empty($arreglo["apellidoPaterno"] = $this->input->post('ap_paterno')) AND
			!empty($arreglo["apellidoMaterno"] = $this->input->post('ap_materno')) AND
			!empty($arreglo["idLote"] = $this->input->post('idLote'))              AND
			!empty($arreglo["idCondominio"] = $this->input->post('idCondominio'))  AND
			!empty($arreglo["engancheCliente"] = $this->input->post('monto'))      AND
			!empty($arreglo["concepto"] = $this->input->post('concepto'))          AND
			!empty($arreglo["noRecibo"] = $this->input->post('num_operacion'))     AND
			!empty($arreglo["user"] = $this->input->post('user_op'))
		){
			$se_puede_apartar = TRUE;
		}
		if( $se_puede_apartar ){
			$idcliente = $this->model_queryinventario->insertaRegistroCaja( $arreglo, $arreglo["idLote"] );
			$horaActual = date('H:i:s');
			$horaInicio = date("08:00:00");
			$horaFin = date("16:00:00");
			$fecha = $fechaApartado;
			$limite = $horaActual > $horaInicio && $horaActual < $horaFin ? 5 : 6;

			$i = 0;

			while( $i <= $limite ) {
				$hoy_strtotime = strtotime($fecha);
				$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
				$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
				$sig_fecha_dia = date('D', $sig_strtotime);
				$sig_fecha_feriado = date('d-m', $sig_strtotime);

				if( !in_array( $sig_fecha_dia, array( "Sat", "Sun" ) ) && !in_array( $sig_fecha_feriado, array( "01-01", "06-02", "20-03", "01-05", "16-09", "20-11", "19-11", "25-12" ) ) ) {
					$i++;
				}

				$fecha = $sig_fecha;
			}

			$iniciar_proceso["idStatusContratacion"] = 1;
			$iniciar_proceso["idMovimiento"] = 31;
			$iniciar_proceso["comentario"] = $this->input->post("comentario");
			$iniciar_proceso["idStatusLote"] = 3;
			$iniciar_proceso["idCliente"] = $idCliente;
			$iniciar_proceso["user"] = $this->input->post('nombre_caja');
			$iniciar_proceso["perfil"] = "CAJA";
			$iniciar_proceso["modificado"] = $fechaApartado;
			$iniciar_proceso["fechaVenc"] = $fecha;

			$historial["idStatusContratacion"] = 1;
			$historial["idMovimiento"] = 31;
			$historial["nombreLote"] = $this->input->post("nombre_lote");
			$historial["comentario"] = $this->input->post("comentario");
			$historial["user"] = $this->input->post('nombre_caja');
			$historial["perfil"] = "CAJA";
			$historial["modificado"] = date("Y-m-d H:i:s");
			$historial["fechaVenc"] = $fechaApartado;
			$historial["idLote"] = $this->input->post('idLote');
			$historial["idCondominio"] = $this->input->post('idCondominio');
			$historial["idCliente"] = $idCliente;

			$this->db->where( "idLote", $this->input->post('idLote') );
			$this->db->update( 'lotes', $iniciar_proceso );

			$this->db->insert( 'historial_lotes', $historial );

			echo json_encode( TRUE );
		}else{
			echo json_encode( FALSE );
		}

	}
	public function getAsesorRH() {
		echo json_encode(array( 'data' => $this->model_queryinventario->getAsesoresRH() ));
	}

	public function getLotesOV() {

		$lotesVO = $this->model_queryinventario->getValidationOff($this->input->post('condominio'));
		if($lotesVO != null) {
			echo json_encode($lotesVO);
		} else {
			echo json_encode(array());
		}
	}

	function getCondominioEnganche() {
		$condominio = $this->model_queryinventario->getCondominioEnganche($this->input->post('residencial'));
		if($condominio != null) {
			echo json_encode($condominio);
		} else {
			echo json_encode(array());
		}
	}

	function getCarsApartaLote(){
		echo $idLote = $this->model_queryinventario->getMCarsApartadoLote($this->input->post('idLote'), $this->input->post('type'));
	}

	function getProyectoCarsLote(){
		echo $siglas = $this->model_queryinventario->getMProyectoCarsLote($this->input->post('idLote'));
	}

	function confirmarPagoPrueba(){
		$informacion_comprador = $this->model_queryinventario->getConfirPagoCarsPrueba();

		$foliocompuesto = $this->input->post('folio');
		$referencia = $this->input->post('num_operacion');
		$confirmaci_caja = array();
		for ($j=0; $j < count($informacion_comprador ); $j++){
			$confirmaci_caja[$j]["Proyecto"] = $informacion_comprador[$j]['descripcion'];
			$confirmaci_caja[$j]["Referencia"] = $referencia;
			$confirmaci_caja[$j]["lote"] = $informacion_comprador[$j]['nombreLote'];
			$confirmaci_caja[$j]["NomCliente"] = $informacion_comprador[$j]['primerNombre']. " " .$informacion_comprador[$j]['segundoNombre']. " " .$informacion_comprador[$j]['apellidoPaterno']. " " .$informacion_comprador[$j]['apellidoMaterno'];
			$confirmaci_caja[$j]["Total"] = $informacion_comprador[$j]['engancheCliente'];
			$confirmaci_caja[$j]["FechaPago"] = $informacion_comprador[$j]['fechaEnganche'];
			$confirmaci_caja[$j]["MontoCantidadLetra"] = ( $informacion_comprador[$j]['engancheCliente'] == "10000.00" ) ? "DIEZ MIL CON 00/100 CENTAVOS M.N." : "CINCUENTA MIL CON 00/100 CENTAVOS M.N." ;
			$confirmaci_caja[$j]["FolioCompuesto"] = $foliocompuesto;
		}

		$resultThree = $this->model_queryinventario->registraCajaCars($confirmaci_caja );

		echo json_encode( TRUE );
	}

	function getCondominioDisponibleA() {

		$objDatos = json_decode(file_get_contents("php://input"));

		$condominio = $this->model_queryinventario->getCondominioDis($objDatos->residencial);
		if($condominio != null) {
			echo json_encode($condominio);
		} else {
			echo json_encode(array());
		}
	}
    function getLotesToEdit() {
        $objDatos = json_decode(file_get_contents("php://input"));
        /*print_r($objDatos);
        exit;*/


        $lotes = $this->model_queryinventario->getLoteToEdit($objDatos->id_lote);

//        print_r($lotes);
//        exit;
//        $lotes[0]['total'] += 10000;
        //experimental
        $data = $this->Asesor_model->getLotesInfoCorrida($objDatos->id_lote);
        $data_casa = ($objDatos->tipo_casa==null) ? null : $objDatos->tipo_casa;
//        print_r($data);
//        echo '<br>';
//        print_r($data_casa);
//        exit;
        $cd = json_decode(str_replace("'", '"', $data[0]['casasDetail']));
        $total_construccion = 0; // MJ: AQUÍ VAMOS A GUARDAR EL TOTAL DE LA CONSTRUCCIÓN + LOS EXRTAS
//        print_r($data[0]['casasDetail']);
//        exit;

        if($data[0]['casasDetail']!=null){
            if(count($cd->tipo_casa) >= 1){


                foreach($cd->tipo_casa as $value) {
                    if($data_casa == $value->id){
//                        print_r($value);
                        $total_construccion += $value->total_const; // MJ: SE EXTRAE EL TOTAL DE LA CONSTRUCCIÓN POR TIPO DE CASA
                        foreach($value->extras as $v) {
                            $total_construccion += $v->techado;
                        }
                    }
//                     if($value->nombre === 'Aura') {
//                        print_r($value);
//                        $total_construccion = $value->total_const; // MJ: SE EXTRAE EL TOTAL DE LA CONSTRUCCIÓN POR TIPO DE CASA
//                        foreach($value->extras as $v) {
//                            $total_construccion += $v->techado;
//                        }
//                     }else if($value->nombre === 'Stella'){
//                         echo '<br><br>STELLA';
//                     }
                }
            }
        }
//        exit;

//        print_r($total_construccion);
//        exit;
        $total_nuevo = $total_construccion + $data[0]['total'];
        $data[0]['total'] += $total_construccion;
        $data[0]['enganche'] += $total_construccion*(.10);
        $preciom2 = $total_nuevo/$data[0]['sup'];
        $data[0]['precio'] = $preciom2;
        //termina experimental

        if($data != null) {
            echo json_encode($data, JSON_NUMERIC_CHECK);
        } else {
            echo json_encode(array());
        }
        //original
        /*
        if($lotes != null) {
            echo json_encode($lotes);
        } else {
            echo json_encode(array());
        }*/
    }

	function getLoteDisponibleA() {

		$objDatos = json_decode(file_get_contents("php://input"));


		$lotes = $this->model_queryinventario->getLotesDisCorridaAll($objDatos->condominio);
	

		if($lotes != null) {
			echo json_encode($lotes);
		} else {
			echo json_encode(array());
		}


	}

	function getinfoLoteDisponible() {
		$objDatos = json_decode(file_get_contents("php://input"));
		$data= $this->model_queryinventario->getLotesInfoCorrida($objDatos->lote);
		if($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
	}



}
