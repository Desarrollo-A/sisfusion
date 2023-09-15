<?php

class RegistroLote extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('registrolote_modelo');
		$this->load->model('asesor/Asesor_model'); //EN ESTE MODELO SE ENCUENTRAN LAS CONSULTAS DEL MENU
		$this->load->model('model_queryinventario');
		$this->load->library(array('session', 'form_validation'));
		//LIBRERIA PARA LLAMAR OBTENER LAS CONSULTAS DE LAS  DEL MENÚ
		$this->load->library(array('session', 'form_validation', 'get_menu','permisos_sidebar'));
		$this->load->helper(array('url', 'form'));
		$this->load->database('default');
		$this->validateSession();
		date_default_timezone_set('America/Mexico_City');

        $val =  $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        $_SESSION['rutaController'] = str_replace('' . base_url() . '', '', $val);
		$rutaUrl = explode($_SESSION['rutaActual'], $_SERVER["REQUEST_URI"]);
        $this->permisos_sidebar->validarPermiso($this->session->userdata('datos'),$rutaUrl[1],$this->session->userdata('opcionesMenu'));
    }
	function getClusterGrupo($residencial, $condominio, $grupo)
	{
		$data['data'] = $this->registrolote_modelo->getClusterGrupo($residencial, $condominio, $grupo);
		echo json_encode($data);
	}
	public function index()
	{
		$this->load->helper("url");
		$datos = array();
		$datos["residenciales"] = $this->registrolote_modelo->getResidencial();
		$datos["gerentes"] = $this->registrolote_modelo->getGerente();
		$datos["asesores"] = $this->registrolote_modelo->getAsesor();
		$datos["condominios"] = $this->registrolote_modelo->getCondominio();
		$datos["statuslote"] = $this->registrolote_modelo->getStatusLote();
		$this->load->view("registro_lote_view", $datos);
	}
	public function selectDS_ds($idCliente)
	{
		$query = $this->db->query("SELECT cc.idCliente, primerNombre, segundoNombre, apellidoPaterno, apellidoMaterno, cc.rfc, razonSocial,  
		cc.fechaNacimiento, telefono1, telefono2, calle, numero, colonia, cc.municipio, estado, cc.correo, referencia1, telreferencia1,
		referencia2, telreferencia2, nombreLote, lotes_consulta.nombreLote, lotes_consulta.idLote, nombreResidencial, condominios.nombre as nombreCondominio, lotes_consulta.sup,
		lotes_consulta.precio,  dsc.nombreConyuge, id, clave, desarrollo,camp_desarrollo, tipoLote, idOficial_pf, idDomicilio_pf, actaMatrimonio_pf, 
		actaConstitutiva_pm, poder_pm, idOficialApoderado_pm, idDomicilio_pm, dsc.rfc as rfcDS, nombre, 
		nacionalidad, originario, estadoCivil, nombreConyuge, regimen, ocupacion, empresaLabora, puesto, antigueda, edadFirma, domicilioEmpresa,
		ladaTelEmpresa, telefonoEmp, casa, noLote, cluster, super, noRefPago, costoM2, proyecto, dsc.municipio as municipioDS,
		importOferta, letraImport, cantidad, letraCantidad, saldoDeposito, aportMensualOfer, fecha1erAport, plazo, fechaLiquidaDepo, fecha2daAport,
		municipio2, dia, mes, año, nombreFirOfertante, observacion, parentescoReferen, parentescoReferen2, nombreFirmaasesor, email2, nombreFirmaAutoriza,
		precioFianza, montoFianza, preMenlSegVida, montoSegVida, acepto, acepto2, fechaCrate, dsc.idCliente, dsc.clave,
		lotes_consulta.referencia, dsc.domicilio_particular, costom2f,dsc.nombrecliente,dsc.espectacular,dsc.volante,dsc.radio,dsc.periodico,dsc.revista,dsc.redes,dsc.punto,dsc.invitacion,dsc.emailing,dsc.pagina,dsc.recomendacion,dsc.convenio,dsc.marketing,dsc.otro1,dsc.especificar,dsc.pase,dsc.modulo,dsc.paseevento,dsc.pasedesarrollo,dsc.call,dsc.pasedirecto,dsc.casaCheck,dsc.oficina,dsc.whatsapp,dsc.email,dsc.otro2,
		gerente1.nombreGerente as gerente1, gerente2.nombreGerente as gerente2, gerente3.nombreGerente as gerente3, asesor_consulta1.nombreasesor as asesor, 
		asesor_consulta2.nombreasesor as asesor2, asesor_consulta3.nombreasesor as asesor3,
		residenciales.idResidencial, condominios.tipo_lote, CONCAT(primerNombre, '', segundoNombre, ' ', apellidoPaterno, ' ', apellidoMaterno) nombreCliente FROM cliente_consulta as cc
		INNER JOIN lotes_consulta ON cc.idLote = lotes_consulta.idLote
		INNER JOIN condominios ON lotes_consulta.idcondominio = condominios.idcondominio
		INNER JOIN residenciales ON condominios.idresidencial = residenciales.idresidencial
		INNER JOIN asesor_consulta ON cc.idasesor= asesor_consulta.idasesor
		LEFT JOIN asesor_consulta as asesor_consulta1 ON asesor_consulta1.idasesor = cc.idasesor
		LEFT JOIN asesor_consulta as asesor_consulta2 ON asesor_consulta2.idasesor = cc.idasesor2
		LEFT JOIN asesor_consulta as asesor_consulta3 ON asesor_consulta3.idasesor = cc.idasesor3
		INNER JOIN gerente_consulta ON cc.idGerente = gerente_consulta.idGerente
		LEFT JOIN gerente_consulta as gerente1 ON gerente1.idGerente = cc.idGerente
		LEFT JOIN gerente_consulta as gerente2 ON gerente2.idGerente = cc.idGerente2
		LEFT JOIN gerente_consulta as gerente3 ON gerente3.idGerente = cc.idGerente3
		INNER JOIN deposito_seriedad_consulta as dsc  ON cc.idcliente = dsc.idcliente
		WHERE cc.idcliente = " . $idCliente);
		return $query->row();
	}
	public function getdp_DS($lotes)
	{
		$query = $this->db->query("SELECT TOP(1)  'Depósito de seriedad' expediente, 'DEPÓSITO DE SERIEDAD' movimiento,
		'VENTAS-ASESOR' primerNom, 'VENTAS' ubic, l.nombreLote, CONCAT(cl.primerNombre, ' ', cl.segundoNombre) nomCliente, cl.apellidoPaterno apellido_paterno, cl.apellidoMaterno apellido_materno, cl.rfc,
		cond.nombre, res.nombreResidencial, cl.fechaApartado, cl.idCliente id_cliente, cl.idCliente idDocumento, ds.fechaCrate modificado
		FROM cliente_consulta cl
		INNER JOIN lotes_consulta l ON l.idLote = cl.idLote
		INNER JOIN deposito_seriedad_consulta ds ON ds.idCliente = cl.idCliente
		INNER JOIN condominios cond ON cond.idCondominio = l.idCondominio
		INNER JOIN residenciales res ON res.idResidencial = cond.idResidencial
		WHERE cl.status=1 AND l.status=1 AND cl.idLote=" . $lotes);
		return $query->result_array();
	}
	public function getLotesGral_DS($condominio)
	{
		$query = $this->db->query("SELECT lc.idLote, nombreLote, idStatusLote FROM deposito_seriedad_consulta ds
                                INNER JOIN cliente_consulta cc ON cc.idCliente = ds.idCliente 
                                INNER JOIN lotes_consulta lc ON lc.idCliente = cc.idCliente 
                                WHERE lc.status = 1 AND lc.idCondominio = " . $condominio . "");
		if ($query) {
			$query = $query->result_array();
			return $query;
		}
	}
	///////////////////////////////////PANEL LOTES TODAS LAS AREAS///////////////////////////////////////
	public function registrosLoteCaja()
	{
		$datos = array();
		$datos["registrosLoteCaja"] = $this->registrolote_modelo->registroLote();
		$datos["residencial"] = $this->registrolote_modelo->getResidencialQro();
		$this->load->view("datos_lote_caja_view", $datos);
	}
	public function registrosLoteAdministracion()
	{
		$datos = array();
		$datos["residencial"] = $this->registrolote_modelo->getResidencialQro();
		$this->load->view('template/header');
		$this->load->view("administracion/datos_lote_administracion_view", $datos);
	}
	public function registrosLotePostventa()
	{
		$datos = array();
		$datos["registrosLotePostventa"] = $this->registrolote_modelo->registroLote();
		$datos["residencial"] = $this->registrolote_modelo->getResidencialQro();
		$this->load->view("datos_lote_postventa_view", $datos);
	}
	public function registrosLoteContraloria()
	{
		$datos = array();
		$datos["registrosLoteContraloria"] = $this->registrolote_modelo->registroLote();
		$datos["residencial"] = $this->registrolote_modelo->getResidencialQro();
		$this->load->view("datos_lote_contraloria_view", $datos);
	}
	public function registrosLoteJuridico()
	{
		$datos["residencial"] = $this->registrolote_modelo->getResidencialQro();
		$this->load->view('template/header');
		$this->load->view("contratacion/datos_lote_contratacion_view", $datos);
	}
	public function registrosLoteRepresentanteLegal()
	{
		$datos = array();
		$datos["registrosLoteRepresentanteLegal"] = $this->registrolote_modelo->registroLote();
		$datos["residencial"] = $this->registrolote_modelo->getResidencialQro();
		$this->load->view("datos_lote_representanteLegal_view", $datos);
	}
	public function registrosLoteVentasAsistentes()
	{
		$datos = array();
		$datos["registrosLoteVentasAsistentes"] = $this->registrolote_modelo->registroLote();
		$datos["residencial"] = $this->registrolote_modelo->getResidencialQro();
		$this->load->view("datos_lote_ventasAsistentes_view", $datos);
	}
	public function registrosLoteAsistentes()
	{
		$datos = array();
		$datos["registrosLoteAsistentes"] = $this->registrolote_modelo->registroLote();
		$datos["residencial"] = $this->registrolote_modelo->getResidencialQro();
		$this->load->view("datos_lote_asistentes_view", $datos);
	}
	public function registrosLoteContratacion()
	{
		$this->validateSession();
		$datos["residencial"] = $this->registrolote_modelo->getResidencialQro();
		$this->load->view('template/header');
		$this->load->view("contratacion/datos_lote_contratacion_view", $datos);
	}
	/////////////////////////////////// FIN PANEL LOTES TODAS LAS AREAS///////////////////////////////////////
	public function editarLoteCaja($idLote)
	{
		$datos = array();
		$datos["lotes"] = $this->registrolote_modelo->selectRegistroLoteCaja2($idLote);
		$datos["statusLoteCaja"] = $this->registrolote_modelo->getStatusLotecaja();
		$datos["statusLoteCajaDisp"] = $this->registrolote_modelo->getStatusLoteDis();
		$datos["gerentes"] = $this->registrolote_modelo->getGerente();
		$this->load->view('editar_lote_caja_view', $datos);
	}

	function registrosLoteLiberacion()
	{
		$datos = array();
		$datos["residencial"] = $this->registrolote_modelo->getResidencialQro();
		$this->load->view('datos_lote_liberacion_view', $datos);
	}
	public function editarLoteLiberacionCaja($idLote)
	{
		$datos = array();
		$datos["lotes"] = $this->registrolote_modelo->selectRegistroLoteCaja2($idLote);
		$this->load->view('editar_lote_liberacion_caja_view', $datos);
	}
	public function editar_registro_lote_liberacion_caja()
	{
		$idLote = $this->input->post('idLote');
		$comentarioLiberacion = $this->input->post('comentarioLiberacion');
		$observacionLiberacion = $this->input->post('observacionLiberacion');
		$fechaLiberacion = $this->input->post('fechaLiberacion');
		$idStatusLote = $this->input->post('idStatusLote');
		$precio = $this->input->post('precio');
		$total = $this->input->post('total');
		$enganche = $this->input->post('enganche');
		$saldo = $this->input->post('saldo');
		$sup = $this->input->post('sup');
		$userLiberacion = $this->input->post('user');
		$arreglo = array();
		$arreglo["comentarioLiberacion"] = $comentarioLiberacion;
		$arreglo["observacionLiberacion"] = $observacionLiberacion;
		$arreglo["fechaLiberacion"] = $fechaLiberacion;
		$arreglo["idStatusLote"] = 1;
		$arreglo["precio"] = $precio;
		$precioFin = $precio * $sup;
		$arreglo["total"] = $precioFin;
		$nuevoEng = ($precioFin * 10) / 100;
		$arreglo["enganche"] = $nuevoEng;
		$nuevoSaldo = $precioFin - $nuevoEng;
		$arreglo["saldo"] = $nuevoSaldo;
		$arreglo["userLiberacion"] = $userLiberacion;
		if ($this->registrolote_modelo->liberacion($idLote, $arreglo)) {
			redirect(base_url() . "index.php/registroLote/registrosLoteLiberacion");
		} else {
			die("ERROR");
		}
	}
	public function status()
	{
		$this->load->helper("url");
		$datos = array();
		$datos["residenciales"] = $this->registrolote_modelo->getResidencial();
		$this->load->view("registro_status_caja_view", $datos);
	}
	function getCondominio($residencial)
	{
		$data = $this->registrolote_modelo->getCondominio($residencial);
		if ($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
		exit;
	}
	function getLotesInventario($condominio, $residencial)
	{
		$data['lotes'] = $this->registrolote_modelo->getInventario($condominio, $residencial);
		echo '<table id="tabla_inventario" width ="100%" class="table table-bordered table-hover" style="text-align:center;">';
		echo '<thead>';
		echo '<tr>';
		echo '<th class="text-center">Nombre</th>';
		echo '<th class="text-center">Superficie</th>';
		echo '<th class="text-center">Precio</th>';
		echo '<th class="text-center">Total</th>';
		echo '<th class="text-center">Porcentaje</th>';
		echo '<th class="text-center">Enganche</th>';
		echo '<th class="text-center">Saldo</th>';
		echo '<th class="text-center">Al 0% </th>';
		echo '<th class="text-center">Al 1%</th>';
		echo '<th class="text-center">Referencia</th>';
		echo '<th class="text-center">Status</th>';
		echo '<th class="text-center">Liberación</th>';
		echo '<th class="text-center">Fecha Liberación</th>';
		echo '<th class="text-center">Acciones</th>';
		echo '</tr>';
		echo '</thead>';
		echo '<tfoot>';
		echo '<tr>';
		echo '<th class="text-center">Nombre</th>';
		echo '<th class="text-center">Superficie</th>';
		echo '<th class="text-center">Precio</th>';
		echo '<th class="text-center">Total</th>';
		echo '<th class="text-center">Porcentaje</th>';
		echo '<th class="text-center">Enganche</th>';
		echo '<th class="text-center">Saldo</th>';
		echo '<th class="text-center">Al 0% </th>';
		echo '<th class="text-center">Al 1%</th>';
		echo '<th class="text-center">Referencia</th>';
		echo '<th class="text-center">Status</th>';
		echo '<th class="text-center">Liberación</th>';
		echo '<th class="text-center">Fecha Liberación</th>';
		echo '<th class="text-center">Acciones</th>';
		echo '</tfoot>';
		echo '</tr>';
		echo '<tbody class="lotes">';
		setlocale(LC_MONETARY, 'en_US');
		$i = 0;
		while ($i < count($data['lotes'])) {
			echo "<tr id='" . $data['lotes'][$i]['idLote'] . "' class='resaltar'>";
			echo "<td style=text-align:center>" . $data['lotes'][$i]['nombreLote'] . "</td>";
			echo "<td style=text-align:center>" . $data['lotes'][$i]['sup'] . "</td>";
			echo "<td style=text-align:center>" . "$" . number_format($data['lotes'][$i]['precio'], 2, ".", ",") . "</td>";
			echo "<td style=text-align:center>" . "$" . number_format($data['lotes'][$i]['total'], 2, ".", ",") . "</td>";
			echo "<td style=text-align:center>" . $data['lotes'][$i]['porcentaje'] . "%" . "</td>";
			echo "<td style=text-align:center>" . "$" . number_format($data['lotes'][$i]['enganche'], 2, ".", ",") . "</td>";
			echo "<td style=text-align:center>" . "$" . number_format($data['lotes'][$i]['saldo'], 2, ".", ",") . "</td>";
			echo "<td style=text-align:center>" . "$" . number_format($data['lotes'][$i]['modalidad_1'], 2, ".", ",") . "</td>";
			echo "<td style=text-align:center>" . "$" . number_format($data['lotes'][$i]['modalidad_2'], 2, ".", ",") . "</td>";
			echo "<td style=text-align:center>" . $data['lotes'][$i]['referencia'] . "</td>";
			echo "<td style=text-align:center>" . $data['lotes'][$i]['nombre'] . "</td>";
			echo "<td style=text-align:center>" . $data['lotes'][$i]['comentarioLiberacion'] . "</td>";
			echo "<td style=text-align:center>" . $data['lotes'][$i]['fechaLiberacion'] . "</td>";
			echo "<td style=text-align:center>
 			<a href='" . 'editarLoteCaja/' . $data['lotes'][$i]['idLote'] . "' ><img src='http://contratacion.sisgph.com/contratacion/static/images/historialNombre.png' width='28' height='25' title= 'Edita Status'/></a>
			<a href='" . 'historial_liberacion/' . $data['lotes'][$i]['idLote'] . "' rel='shadowbox[Vacation];width=700;height=440'>  <img src='http://contratacion.sisgph.com/contratacion/static/images/historialLiberacion.png' width='25' height='23' title= 'Historial Liberación'/></a>
 			<a href='" . 'historialProcesoLote/' . $data['lotes'][$i]['idLote'] . "' rel='shadowbox[Vacation];width=700;height=440'><img src='http://contratacion.sisgph.com/contratacion/static/images/registrarStatus.png' width='25' height='23' title= 'Historial Proceso de Contratación'>  </a>
			 </td>";
			$i++;
		}
		echo '</tbody>';
		echo '</table>';
		?>
				<script type="text/javascript">
					$(document).ready(function () {
						$('#tabla_inventario').dataTable({
							initComplete: function () {
								this.api().columns().every(function () {
									var column = this;
									var select = $('<select><option value=""></option></select>')
										.appendTo($(column.footer()).empty())
										.on('change', function () {
											var val = $.fn.dataTable.util.escapeRegex(
												$(this).val()
											);
											column
												.search(val ? '^' + val + '$' : '', true, false)
												.draw();
										});
									column.data().unique().sort().each(function (d, j) {
										select.append('<option value="' + d + '">' + d + '</option>')
									});
								});
							},
							"scrollX": true,
							"pageLength": 10,
							"language": {
								"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
							},
							dom: 'Bfrtip',
							buttons: [
								{
									extend: 'copyHtml5',
									text: '<i class="fa fa-files-o"></i>',
									titleAttr: 'Copy'
								},
								{
									extend: 'excelHtml5',
									text: '<i class="fa fa-file-excel-o"></i>',
									titleAttr: 'Excel'
								},
								{
									extend: 'csvHtml5',
									text: '<i class="fa fa-file-text-o"></i>',
									titleAttr: 'CSV'
								},
								{
									extend: 'pdfHtml5',
									text: '<i class="fa fa-file-pdf-o"></i>',
									titleAttr: 'PDF'
								}
							]
						});
					});
				</script>
				<link rel="stylesheet" type="text/css" href="<?= base_url() ?>dist/css/shadowbox.css">
				<script type="text/javascript" src="<?= base_url() ?>dist/js/shadowbox.js"></script>
				<script type="text/javascript">
					Shadowbox.init();
				</script>
				<link rel="stylesheet" type="text/css" href="<?= base_url() ?>dist/css/shadowbox.css">
				<script type="text/javascript" src="<?= base_url() ?>dist/js/shadowbox.js"></script>
				<script type="text/javascript">
					Shadowbox.init();
				</script>
				<?php
	}
	/////////////////////INICIA PANEL PARA REGISTRAR EL STATUS POR AREA/////////////////////////////////////////////7
	public function registroStatusContratacionCaja()
	{
		$datos = array();
		$datos["registroStatusContratacionCaja"] = $this->registrolote_modelo->registroStatusContratacion();
		$this->load->view("datos_statusContratacion_caja_view", $datos);
	}
	public function editarLoteCajaStatusContratacion1($idLote)
	{
		$datos = array();
		$datos["lotes"] = $this->registrolote_modelo->selectRegistroLoteCaja($idLote);
		$datos["cajastatus1"] = $this->registrolote_modelo->getCajaStatus1();
		$this->load->view('editar_lote_caja_proceso1_view', $datos);
	}
	public function editar_registro_lote_caja_proceceso1()
	{
		$idLote = $this->input->post('idLote');
		$idCondominio = $this->input->post('idCondominio');
		$idStatusContratacion = $this->input->post('idStatusContratacion');
		$idStatusLote = $this->input->post('idStatusLote');
		$idMovimiento = $this->input->post('idMovimiento');
		$nombreLote = $this->input->post('nombreLote');
		$idCliente = $this->input->post('idCliente');
		$comentario = $this->input->post('comentario');
		$user = $this->input->post('user');
		$perfil = $this->input->post('perfil');
		$modificado = date('Y-m-d H:i:s');
		$fechaVenc = $this->input->post('fechaVenc');
		$arreglo = array();
		$arreglo["idStatusContratacion"] = $idStatusContratacion;
		$arreglo["idStatusLote"] = 3;
		$arreglo["idMovimiento"] = 31;
		$arreglo["idCliente"] = $idCliente;
		$arreglo["comentario"] = $comentario;
		$arreglo["user"] = $this->session->userdata('username');
		$arreglo["perfil"] = $this->session->userdata('perfil');
		$arreglo["modificado"] = date("Y-m-d H:i:s");
		date_default_timezone_set('America/Mexico_City');
		$horaActual = date('H:i:s');
		$horaInicio = date("08:00:00");
		$horaFin = date("16:00:00");
		if ($horaActual > $horaInicio and $horaActual < $horaFin) {
			$fechaAccion = date("Y-m-d H:i:s");
			$hoy_strtotime2 = strtotime($fechaAccion);
			$sig_fecha_dia2 = date('D', $hoy_strtotime2);
			$sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
			if (
				$sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
				$sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
				$sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
				$sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
				$sig_fecha_feriado2 == "25-12"
			) {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 6) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				for ($i = 0; $i < count($fecha); $i++) {
					$arreglo["fechaVenc"] = $fecha;
				}
			} else {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 5) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				for ($i = 0; $i < count($fecha); $i++) {
					$arreglo["fechaVenc"] = $fecha;
				}
			}
		} elseif ($horaActual < $horaInicio || $horaActual > $horaFin) {
			$fechaAccion = date("Y-m-d H:i:s");
			$hoy_strtotime2 = strtotime($fechaAccion);
			$sig_fecha_dia2 = date('D', $hoy_strtotime2);
			$sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
			if (
				$sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
				$sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
				$sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
				$sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
				$sig_fecha_feriado2 == "25-12"
			) {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 6) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				for ($i = 0; $i < count($fecha); $i++) {
					$arreglo["fechaVenc"] = $fecha;
				}
			} else {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 6) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				for ($i = 0; $i < count($fecha); $i++) {
					$arreglo["fechaVenc"] = $fecha;
				}
			}
		}
		$arreglo2 = array();
		$arreglo2["idStatusContratacion"] = $idStatusContratacion;
		$arreglo2["idMovimiento"] = 31;
		$arreglo2["nombreLote"] = $nombreLote;
		$arreglo2["comentario"] = $comentario;
		$arreglo2["user"] = $this->session->userdata('username');
		$arreglo2["perfil"] = $this->session->userdata('perfil');
		$arreglo2["modificado"] = date("Y-m-d H:i:s");
		$arreglo2["fechaVenc"] = $modificado;
		$arreglo2["idLote"] = $idLote;
		$arreglo2["idCondominio"] = $idCondominio;
		$arreglo2["idCliente"] = $idCliente;
		if ($this->registrolote_modelo->editaRegistroLoteCaja($idLote, $arreglo)) {
			$this->registrolote_modelo->insertHistorialLotes($arreglo2);
			redirect(base_url() . "index.php/registroLote/registroStatusContratacionCaja");
		} else {
			die("ERROR");
		}
	}
	public function editarLoteAsistentesStatusContratacion2($idLote)
	{
		$datos = array();
		$datos["lotes"] = $this->registrolote_modelo->selectRegistroLoteCaja($idLote);
		$datos["asistentesStatus2"] = $this->registrolote_modelo->getAsistentesStatus2();
		$datos["tipoVenta"] = $this->registrolote_modelo->get_tventa();
		$this->load->view('editar_lote_asistentes_proceso2_view', $datos);
	}
	public function editar_registro_lote_asistentes_proceceso2()
	{
		$idLote = $this->input->post('idLote');
		$idCondominio = $this->input->post('idCondominio');
		$nombreLote = $this->input->post('nombreLote');
		$idStatusContratacion = $this->input->post('idStatusContratacion');
		$idMovimiento = $this->input->post('idMovimiento');
		$idCliente = $this->input->post('idCliente');
		$comentario = $this->input->post('comentario');
		$user = $this->input->post('user');
		$perfil = $this->input->post('perfil');
		$modificado = date('Y-m-d H:i:s');
		$fechaVenc = $this->input->post('fechaVenc');
		$ubicacion = $this->input->post('ubicacion');
		$tipo_venta = $this->input->post('tipo_venta');
		$arreglo = array();
		$arreglo["idStatusContratacion"] = $idStatusContratacion;
		$arreglo["idMovimiento"] = 32;
		$arreglo["comentario"] = $comentario;
		$arreglo["usuario"] = $this->session->userdata('usuario');
		$arreglo["perfil"] = $this->session->userdata('perfil');
		$arreglo["modificado"] = date("Y-m-d H:i:s");
		$arreglo["fechaVenc"] = $modificado;
		$arreglo["ubicacion"] = $ubicacion;
		$arreglo["tipo_venta"] = $tipo_venta;
		$arreglo2 = array();
		$arreglo2["idStatusContratacion"] = $idStatusContratacion;
		$arreglo2["idMovimiento"] = 32;
		$arreglo2["nombreLote"] = $nombreLote;
		$arreglo2["comentario"] = $comentario;
		$arreglo2["usuario"] = $this->session->userdata('usuario');
		$arreglo2["perfil"] = $this->session->userdata('perfil');
		$arreglo2["modificado"] = date("Y-m-d H:i:s");
		$arreglo2["fechaVenc"] = $fechaVenc;
		$arreglo2["idLote"] = $idLote;
		$arreglo2["idCondominio"] = $idCondominio;
		$arreglo2["idCliente"] = $idCliente;
		if ($this->registrolote_modelo->editaRegistroLoteCaja($idLote, $arreglo)) {
			$this->registrolote_modelo->insertHistorialLotes($arreglo2);
			echo 1;
		} else {
			die("ERROR");
		}
	}
	public function registroStatus3ContratacionJuridico()
	{
		$datos = array();
		$datos["registroStatus3ContratacionJuridico"] = $this->registrolote_modelo->registroStatusContratacion3();
		$this->load->view('template/header');
		$this->load->view("juridico/datos_status3Contratacion_juridico_view", $datos);
	}
	public function getStatus3Docs()
	{
		$data = $this->registrolote_modelo->registroStatusContratacion3();
		if ($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
		exit;
	}
	public function editarLoteJuridicoStatusContratacion3($idLote)
	{
		$data["lotes"] = $this->registrolote_modelo->selectRegistroLoteCaja($idLote);
		$data["juridicoStatus3"] = $this->registrolote_modelo->getJuridicoStatus3();
		if ($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
		exit;
	}
	public function editar_registro_lote_juridico_proceceso3()
	{
		$idLote = $this->input->post('idLote');
		$idCondominio = $this->input->post('idCondominio');
		$nombreLote = $this->input->post('nombreLote');
		$idStatusContratacion = $this->input->post('idStatusContratacion');
		$idMovimiento = $this->input->post('idMovimiento');
		$idCliente = $this->input->post('idCliente');
		$comentario = $this->input->post('comentario');
		$user = $this->session->userdata('username');
		$perfil = $this->session->userdata('perfil');
		$modificado = date('Y-m-d H:i:s');
		$fechaVenc = $this->input->post('fechaVenc');
		$arreglo = array();
		$arreglo["idStatusContratacion"] = $idStatusContratacion;
		$arreglo["idMovimiento"] = 33;
		$arreglo["comentario"] = $comentario;
		$arreglo["user"] = $this->session->userdata('username');
		$arreglo["perfil"] = $this->session->userdata('perfil');
		$arreglo["modificado"] = date("Y-m-d H:i:s");
		date_default_timezone_set('America/Mexico_City');
		$horaActual = date('H:i:s');
		$horaInicio = date("08:00:00");
		$horaFin = date("16:00:00");
		if ($horaActual > $horaInicio and $horaActual < $horaFin) {
			$fechaAccion = date("Y-m-d H:i:s");
			$hoy_strtotime2 = strtotime($fechaAccion);
			$sig_fecha_dia2 = date('D', $hoy_strtotime2);
			$sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
			if (
				$sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
				$sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
				$sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
				$sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
				$sig_fecha_feriado2 == "25-12"
			) {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 0) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				for ($i = 0; $i < count($fecha); $i++) {
					$arreglo["fechaVenc"] = $fecha;
				}
			} else {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= -1) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				for ($i = 0; $i < count($fecha); $i++) {
					$arreglo["fechaVenc"] = $fecha;
				}
			}
		} elseif ($horaActual < $horaInicio || $horaActual > $horaFin) {
			$fechaAccion = date("Y-m-d H:i:s");
			$hoy_strtotime2 = strtotime($fechaAccion);
			$sig_fecha_dia2 = date('D', $hoy_strtotime2);
			$sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
			if (
				$sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
				$sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
				$sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
				$sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
				$sig_fecha_feriado2 == "25-12"
			) {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 0) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				for ($i = 0; $i < count($fecha); $i++) {
					$arreglo["fechaVenc"] = $fecha;
				}
			} else {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 0) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				for ($i = 0; $i < count($fecha); $i++) {
					$arreglo["fechaVenc"] = $fecha;
				}
			}
		}
		$arreglo2 = array();
		$arreglo2["idStatusContratacion"] = $idStatusContratacion;
		$arreglo2["idMovimiento"] = 33;
		$arreglo2["nombreLote"] = $nombreLote;
		$arreglo2["comentario"] = $comentario;
		$arreglo2["user"] = $this->session->userdata('username');
		$arreglo2["perfil"] = $this->session->userdata('perfil');
		$arreglo2["modificado"] = date("Y-m-d H:i:s");
		$arreglo2["fechaVenc"] = $fechaVenc;
		$arreglo2["idLote"] = $idLote;
		$arreglo2["idCondominio"] = $idCondominio;
		$arreglo2["idCliente"] = $idCliente;
		if ($this->registrolote_modelo->editaRegistroLoteCaja($idLote, $arreglo)) {
			$this->registrolote_modelo->insertHistorialLotes($arreglo2);
			redirect(base_url() . "index.php/registroLote/registroStatus3ContratacionJuridico");
		} else {
			die("ERROR");
		}
	}
	public function registroStatus4ContratacionPostventa()
	{
		$datos = array();
		$datos["registroStatus4ContratacionPostventa"] = $this->registrolote_modelo->registroStatusContratacion4();
		$this->load->view("datos_status4Contratacion_postventa_view", $datos);
	}
	public function editarLotePostventaStatusContratacion4($idLote)
	{
		$datos = array();
		$datos["lotes"] = $this->registrolote_modelo->selectRegistroLoteCaja($idLote);
		$datos["postventaStatus4"] = $this->registrolote_modelo->getPostventaStatus4();
		$this->load->view('editar_lote_postventa_proceso4_view', $datos);
	}
	public function editar_registro_lote_postventa_proceceso4()
	{
		$idLote = $this->input->post('idLote');
		$idCondominio = $this->input->post('idCondominio');
		$nombreLote = $this->input->post('nombreLote');
		$idStatusContratacion = $this->input->post('idStatusContratacion');
		$idMovimiento = $this->input->post('idMovimiento');
		$idCliente = $this->input->post('idCliente');
		$comentario = $this->input->post('comentario');
		$user = $this->input->post('user');
		$perfil = $this->input->post('perfil');
		$modificado = date('Y-m-d H:i:s');
		$idPertenece = $this->input->post('idPertenece');
		$fechaVenc = $this->input->post('fechaVenc');
		$arreglo = array();
		$arreglo["idStatusContratacion"] = $idStatusContratacion;
		$arreglo["idMovimiento"] = 34;
		$arreglo["comentario"] = $comentario;
		$arreglo["user"] = $this->session->userdata('username');
		$arreglo["perfil"] = $this->session->userdata('perfil');
		$arreglo["modificado"] = date("Y-m-d H:i:s");
		date_default_timezone_set('America/Mexico_City');
		$horaActual = date('H:i:s');
		$horaInicio = date("08:00:00");
		$horaFin = date("16:00:00");
		if ($horaActual > $horaInicio and $horaActual < $horaFin) {
			$fechaAccion = date("Y-m-d H:i:s");
			$hoy_strtotime2 = strtotime($fechaAccion);
			$sig_fecha_dia2 = date('D', $hoy_strtotime2);
			$sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
			if (
				$sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
				$sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
				$sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
				$sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
				$sig_fecha_feriado2 == "25-12"
			) {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 0) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				for ($i = 0; $i < count($fecha); $i++) {
					$arreglo["fechaVenc"] = $fecha;
				}
			} else {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= -1) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				for ($i = 0; $i < count($fecha); $i++) {
					$arreglo["fechaVenc"] = $fecha;
				}
			}
		} elseif ($horaActual < $horaInicio || $horaActual > $horaFin) {
			$fechaAccion = date("Y-m-d H:i:s");
			$hoy_strtotime2 = strtotime($fechaAccion);
			$sig_fecha_dia2 = date('D', $hoy_strtotime2);
			$sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
			if (
				$sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
				$sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
				$sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
				$sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
				$sig_fecha_feriado2 == "25-12"
			) {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 0) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				for ($i = 0; $i < count($fecha); $i++) {
					$arreglo["fechaVenc"] = $fecha;
				}
			} else {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 0) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				for ($i = 0; $i < count($fecha); $i++) {
					$arreglo["fechaVenc"] = $fecha;
				}
			}
		}
		$arreglo2 = array();
		$arreglo2["idStatusContratacion"] = $idStatusContratacion;
		$arreglo2["idMovimiento"] = 34;
		$arreglo2["nombreLote"] = $nombreLote;
		$arreglo2["comentario"] = $comentario;
		$arreglo2["user"] = $this->session->userdata('username');
		$arreglo2["perfil"] = $this->session->userdata('perfil');
		$arreglo2["modificado"] = date("Y-m-d H:i:s");
		$arreglo2["fechaVenc"] = $fechaVenc;
		$arreglo2["idLote"] = $idLote;
		$arreglo2["idCondominio"] = $idCondominio;
		$arreglo2["idCliente"] = $idCliente;
		if ($this->registrolote_modelo->editaRegistroLoteCaja($idLote, $arreglo)) {
			$this->registrolote_modelo->insertHistorialLotes($arreglo2);
			redirect(base_url() . "index.php/registroLote/registroStatus4ContratacionPostventa");
		} else {
			die("ERROR");
		}
	}
	public function registroStatus5ContratacionContraloria()
	{
		$datos = array();
		$datos["registroStatus5ContratacionContraloria"] = $this->registrolote_modelo->registroStatusContratacion5();
		$this->load->view("datos_status5Contratacion_contraloria_view", $datos);
	}
	public function editarLoteContraloriaStatusContratacion5($idLote)
	{
		$datos = array();
		$datos["lotes"] = $this->registrolote_modelo->selectRegistroLoteCaja($idLote);
		$datos["contraloriaStatus5"] = $this->registrolote_modelo->getContraloriaStatus5();
		$this->load->view('editar_lote_contraloria_proceso5_view', $datos);
	}
	public function editar_registro_lote_contraloria_proceceso5()
	{
		$idLote = $this->input->post('idLote');
		$idCondominio = $this->input->post('idCondominio');
		$nombreLote = $this->input->post('nombreLote');
		$idStatusContratacion = $this->input->post('idStatusContratacion');
		$idMovimiento = $this->input->post('idMovimiento');
		$idCliente = $this->input->post('idCliente');
		$comentario = $this->input->post('comentario');
		$user = $this->input->post('user');
		$perfil = $this->input->post('perfil');
		$modificado = date('Y-m-d H:i:s');
		$idPertenece = $this->input->post('idPertenece');
		$fechaVenc = $this->input->post('fechaVenc');
		$arreglo = array();
		$arreglo["idStatusContratacion"] = $idStatusContratacion;
		$arreglo["idMovimiento"] = 35;
		$arreglo["comentario"] = $comentario;
		$arreglo["usuario"] = $this->session->userdata('usuario');
		$arreglo["perfil"] = $this->session->userdata('perfil');
		$arreglo["modificado"] = date("Y-m-d H:i:s");
		date_default_timezone_set('America/Mexico_City');
		$horaActual = date('H:i:s');
		$horaInicio = date("08:00:00");
		$horaFin = date("16:00:00");
		if ($horaActual > $horaInicio and $horaActual < $horaFin) {
			$fechaAccion = date("Y-m-d H:i:s");
			$hoy_strtotime2 = strtotime($fechaAccion);
			$sig_fecha_dia2 = date('D', $hoy_strtotime2);
			$sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
			if (
				$sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
				$sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
				$sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
				$sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
				$sig_fecha_feriado2 == "25-12"
			) {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 1) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				$arreglo["fechaVenc"] = $fecha;
			} else {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 0) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				$arreglo["fechaVenc"] = $fecha;
			}
		} elseif ($horaActual < $horaInicio || $horaActual > $horaFin) {
			$fechaAccion = date("Y-m-d H:i:s");
			$hoy_strtotime2 = strtotime($fechaAccion);
			$sig_fecha_dia2 = date('D', $hoy_strtotime2);
			$sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
			if (
				$sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
				$sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
				$sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
				$sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
				$sig_fecha_feriado2 == "25-12"
			) {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 1) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				$arreglo["fechaVenc"] = $fecha;
			} else {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 1) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				$arreglo["fechaVenc"] = $fecha;
			}
		}
		$arreglo2 = array();
		$arreglo2["idStatusContratacion"] = $idStatusContratacion;
		$arreglo2["idMovimiento"] = 35;
		$arreglo2["nombreLote"] = $nombreLote;
		$arreglo2["comentario"] = $comentario;
		$arreglo2["usuario"] = $this->session->userdata('usuario');
		$arreglo2["perfil"] = $this->session->userdata('perfil');
		$arreglo2["modificado"] = date("Y-m-d H:i:s");
		$arreglo2["fechaVenc"] = $fechaVenc;
		$arreglo2["idLote"] = $idLote;
		$arreglo2["idCondominio"] = $idCondominio;
		$arreglo2["idCliente"] = $idCliente;
		if ($this->registrolote_modelo->editaRegistroLoteCaja($idLote, $arreglo)) {
			$this->registrolote_modelo->insertHistorialLotes($arreglo2);
			echo 1;
		} else {
			echo 0;
			die("ERROR");
		}
	}
	public function registroStatus6ContratacionContraloria()
	{
		$datos = array();
		$datos["registroStatus6ContratacionContraloria"] = $this->registrolote_modelo->registroStatusContratacion6();
	}
	public function editarLoteContraloriaStatusContratacion6($idLote)
	{
		$datos = array();
		$datos["lotes"] = $this->registrolote_modelo->selectRegistroLoteCaja($idLote);
		$datos["contraloriaStatus6"] = $this->registrolote_modelo->getContraloriaStatus6();
		$this->load->view('editar_lote_contraloria_proceso6_view', $datos);
	}
	public function editar_registro_lote_contraloria_proceceso6()
	{
		$idLote = $this->input->post('idLote');
		$idCondominio = $this->input->post('idCondominio');
		$nombreLote = $this->input->post('nombreLote');
		$idStatusContratacion = $this->input->post('idStatusContratacion');
		$idMovimiento = $this->input->post('idMovimiento');
		$idCliente = $this->input->post('idCliente');
		$comentario = $this->input->post('comentario');
		$user = $this->input->post('user');
		$perfil = $this->input->post('perfil');
		$modificado = date('Y-m-d H:i:s');
		$idPertenece = $this->input->post('idPertenece');
		$fechaVenc = $this->input->post('fechaVenc');
		$fechaVenStatus = $this->input->post('fechaVenStatus');
		$arreglo = array();
		$arreglo["idStatusContratacion"] = $idStatusContratacion;
		$arreglo["idMovimiento"] = 36;
		$arreglo["comentario"] = $comentario;
		$arreglo["usuario"] = $this->session->userdata('username');
		$arreglo["perfil"] = $this->session->userdata('perfil');
		$arreglo["modificado"] = date("Y-m-d H:i:s");
		date_default_timezone_set('America/Mexico_City');
		$horaActual = date('H:i:s');
		$horaInicio = date("08:00:00");
		$horaFin = date("16:00:00");
		if ($horaActual > $horaInicio and $horaActual < $horaFin) {
			$fechaAccion = date("Y-m-d H:i:s");
			$hoy_strtotime2 = strtotime($fechaAccion);
			$sig_fecha_dia2 = date('D', $hoy_strtotime2);
			$sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
			if (
				$sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
				$sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
				$sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
				$sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
				$sig_fecha_feriado2 == "25-12"
			) {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 1) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				$arreglo["fechaVenc"] = $fecha;
			} else {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 0) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				$arreglo["fechaVenc"] = $fecha;
			}
		} elseif ($horaActual < $horaInicio || $horaActual > $horaFin) {
			$fechaAccion = date("Y-m-d H:i:s");
			$hoy_strtotime2 = strtotime($fechaAccion);
			$sig_fecha_dia2 = date('D', $hoy_strtotime2);
			$sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
			if (
				$sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
				$sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
				$sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
				$sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
				$sig_fecha_feriado2 == "25-12"
			) {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 1) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				$arreglo["fechaVenc"] = $fecha;
			} else {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 1) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				$arreglo["fechaVenc"] = $fecha;
			}
		}
		$arreglo2 = array();
		$arreglo2["idStatusContratacion"] = $idStatusContratacion;
		$arreglo2["idMovimiento"] = 36;
		$arreglo2["nombreLote"] = $nombreLote;
		$arreglo2["comentario"] = $comentario;
		$arreglo2["usuario"] = $this->session->userdata('usuario');
		$arreglo2["perfil"] = $this->session->userdata('perfil');
		$arreglo2["modificado"] = date("Y-m-d H:i:s");
		$arreglo2["fechaVenc"] = $fechaVenc;
		$arreglo2["idLote"] = $idLote;
		$arreglo2["idCondominio"] = $idCondominio;
		$arreglo2["idCliente"] = $idCliente;
		if ($this->registrolote_modelo->editaRegistroLoteCaja($idLote, $arreglo)) {
			$this->registrolote_modelo->insertHistorialLotes($arreglo2);
			echo 1;
		} else {
			echo 0;
			die("ERROR");
		}
	}
	public function registroStatus7ContratacionJuridico()
	{
		$this->validateSession();
		$this->load->view("template/header");
		if ($this->session->userdata('id_usuario') == 2762 || $this->session->userdata('id_usuario') == 6096)
			$this->load->view("juridico/datos_status7Contratacion_juridico_view_two");
		else
			$this->load->view("juridico/datos_status7Contratacion_juridico_view");
	}
	public function getStatus7ContratacionJuridico()
	{
		$data = $this->registrolote_modelo->registroStatusContratacion7();
		$dataPer = array();
		for ($i = 0; $i < count($data); $i++) {
			$dataPer[$i]['idLote'] = $data[$i]->idLote;
			$dataPer[$i]['id_cliente'] = $data[$i]->id_cliente;
			$dataPer[$i]['fechaApartado'] = $data[$i]->fechaApartado;
			$dataPer[$i]['nombre'] = $data[$i]->nombre;
			$dataPer[$i]['apellido_paterno'] = $data[$i]->apellido_paterno;
			$dataPer[$i]['apellido_materno'] = $data[$i]->apellido_materno;
			$dataPer[$i]['nombreLote'] = $data[$i]->nombreLote;
			$dataPer[$i]['idStatusContratacion'] = $data[$i]->idStatusContratacion;
			$dataPer[$i]['idMovimiento'] = $data[$i]->idMovimiento;
			$dataPer[$i]['modificado'] = $data[$i]->modificado;
			$dataPer[$i]['rfc'] = $data[$i]->rfc;
			$dataPer[$i]['comentario'] = $data[$i]->comentario;
			$dataPer[$i]['fechaVenc'] = $data[$i]->fechaVenc;
			$dataPer[$i]['perfil'] = $data[$i]->perfil;
			$dataPer[$i]['nombreResidencial'] = $data[$i]->nombreResidencial;
			$dataPer[$i]['nombreCondominio'] = $data[$i]->nombreCondominio;
			$dataPer[$i]['ubicacion'] = $data[$i]->ubicacion;
			$dataPer[$i]['gerente'] = $data[$i]->gerente;
			$dataPer[$i]['asesor'] = $data[$i]->asesor;
			$dataPer[$i]['tipo_venta'] = $data[$i]->tipo_venta;
			$proyecto = str_replace(' ', '', $data[$i]->nombreResidencial);
			$cluster = strtoupper($data[$i]->nombreCondominio);
			$string = str_replace("ñ", "N", $cluster);
			$arr = explode("_", $string);
			$clusterClean = implode("", $arr);
			$lote = str_replace(' ', '', $clusterClean);
			$numeroLote = preg_replace('/[^0-9]/', '', $data[$i]->nombreLote);
			$dataPer[$i]['cbbtton'] = $proyecto . $lote . $numeroLote;
		}
		if ($dataPer != null) {
			echo json_encode($dataPer);
		} else {
			echo json_encode(array());
		}
		exit;
	}
	public function editarLoteJuridicoStatusContratacion7($idLote)
	{
		$datos = array();
		$data["lotes"] = $this->registrolote_modelo->selectRegistroLoteCaja($idLote);
		$datos["juridicoStatus7"] = $this->registrolote_modelo->getJuridicoStatus7();
		$datos["lotes"]['idCliente'] = $data["lotes"]->idCliente;
		$datos["lotes"]['nombreLote'] = $data["lotes"]->nombreLote;
		$datos["lotes"]['idLote'] = $data["lotes"]->idLote;
		$datos["lotes"]['user'] = $data["lotes"]->user;
		$datos["lotes"]['perfil'] = $data["lotes"]->perfil;
		$datos["lotes"]['fechaVenc'] = $data["lotes"]->fechaVenc;
		$datos["lotes"]['idCondominio'] = $data["lotes"]->idCondominio;
		$datos["lotes"]['modificado'] = $data["lotes"]->modificado;
		$datos["lotes"]['fechaSolicitudValidacion'] = $data["lotes"]->fechaSolicitudValidacion;
		$datos["lotes"]['nombre'] = $data["lotes"]->nombre;
		$datos["lotes"]['nombreResidencial'] = $data["lotes"]->nombreResidencial;
		$datos["lotes"]['contratoArchivo'] = $data["lotes"]->contratoArchivo;
		$datos["lotes"]['fechaRL'] = $data["lotes"]->fechaRL;
		$datos["lotes"]['totalNeto'] = $data["lotes"]->totalNeto;
		$datos["lotes"]['totalValidado'] = $data["lotes"]->totalValidado;
		$datos["lotes"]['totalNeto2'] = $data["lotes"]->totalNeto2;
		$proyecto = str_replace(' ', '', $data["lotes"]->nombreResidencial);
		$cluster = strtoupper($data["lotes"]->nombre);
		$string = str_replace("ñ", "N", $cluster);
		$clusterSE = str_replace(" ", "", $string);
		$arr = explode("_", $clusterSE);
		$lote = implode("", $arr);
		$numeroLote = preg_replace('/[^0-9]/', '', $data["lotes"]->nombreLote);
		$datos["lotes"]['composicion'] = $proyecto . $lote . $numeroLote;
		if ($datos != null) {
			echo json_encode($datos);
		} else {
			echo json_encode(array());
		}
		exit;
	}
	public function editar_registro_lote_juridico_proceceso7()
	{
		$idLote = $this->input->post('idLote');
		$idCondominio = $this->input->post('idCondominio');
		$nombreLote = $this->input->post('nombreLote');
		$idStatusContratacion = $this->input->post('idStatusContratacion');
		$idMovimiento = $this->input->post('idMovimiento');
		$idCliente = $this->input->post('idCliente');
		$comentario = $this->input->post('comentario');
		$user = $this->input->post('user');
		$perfil = $this->input->post('perfil');
		$modificado = date('Y-m-d H:i:s');
		$fechaVenc = $this->input->post('fechaVenc');
		$numContrato = $this->input->post('numContrato');
		$aleatorio = rand();
		$contratoArchivo = $idCliente . '_' . $aleatorio . '_' . $_FILES["contratoArchivo"]["name"];
		$arreglo = array();
		$arreglo["idStatusContratacion"] = $idStatusContratacion;
		$arreglo["idMovimiento"] = 37;
		$arreglo["comentario"] = $comentario;
		$arreglo["user"] = $this->session->userdata('username');
		$arreglo["perfil"] = $this->session->userdata('perfil');
		$arreglo["modificado"] = date("Y-m-d H:i:s");
		$arreglo["numContrato"] = $numContrato;
		$arreglo["contratoArchivo"] = $idCliente . '_' . $aleatorio . '_' . $_FILES["contratoArchivo"]["name"];
		date_default_timezone_set('America/Mexico_City');
		$horaActual = date('H:i:s');
		$horaInicio = date("08:00:00");
		$horaFin = date("16:00:00");
		if ($horaActual > $horaInicio and $horaActual < $horaFin) {
			$fechaAccion = date("Y-m-d H:i:s");
			$hoy_strtotime2 = strtotime($fechaAccion);
			$sig_fecha_dia2 = date('D', $hoy_strtotime2);
			$sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
			if (
				$sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
				$sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
				$sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
				$sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
				$sig_fecha_feriado2 == "25-12"
			) {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 16) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				for ($i = 0; $i < count($fecha); $i++) {
					$arreglo["fechaVenc"] = $fecha;
				}
			} else {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 15) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				for ($i = 0; $i < count($fecha); $i++) {
					$arreglo["fechaVenc"] = $fecha;
				}
			}
		} elseif ($horaActual < $horaInicio || $horaActual > $horaFin) {
			$fechaAccion = date("Y-m-d H:i:s");
			$hoy_strtotime2 = strtotime($fechaAccion);
			$sig_fecha_dia2 = date('D', $hoy_strtotime2);
			$sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
			if (
				$sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
				$sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
				$sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
				$sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
				$sig_fecha_feriado2 == "25-12"
			) {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 16) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				for ($i = 0; $i < count($fecha); $i++) {
					$arreglo["fechaVenc"] = $fecha;
				}
			} else {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 16) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				for ($i = 0; $i < count($fecha); $i++) {
					$arreglo["fechaVenc"] = $fecha;
				}
			}
		}
		$arreglo2 = array();
		$arreglo2["idStatusContratacion"] = $idStatusContratacion;
		$arreglo2["idMovimiento"] = 37;
		$arreglo2["nombreLote"] = $nombreLote;
		$arreglo2["comentario"] = $comentario;
		$arreglo2["user"] = $this->session->userdata('username');
		$arreglo2["perfil"] = $this->session->userdata('perfil');
		$arreglo2["modificado"] = date("Y-m-d H:i:s");
		$arreglo2["fechaVenc"] = $fechaVenc;
		$arreglo2["idLote"] = $idLote;
		$arreglo2["idCondominio"] = $idCondominio;
		$arreglo2["idCliente"] = $idCliente;
		if ($this->registrolote_modelo->editaRegistroLoteCaja($idLote, $arreglo)) {
			$this->registrolote_modelo->insertHistorialLotes($arreglo2);
			if (move_uploaded_file($_FILES["contratoArchivo"]["tmp_name"], "static/documentos/cliente/contrato/" . $idCliente . '_' . $aleatorio . '_' . $_FILES["contratoArchivo"]["name"])) {
				redirect(base_url() . "index.php/registroLote/registroStatus7ContratacionJuridico");
			}
		} else {
			die("ERROR");
		}
	}
	public function registroStatus8ContratacionAsistentes()
	{
		$this->validateSession();
		$this->load->view('template/header');
		$this->load->view("contratacion/datos_status8Contratacion_asistentes_view");
	}
	public function getStatus8ContratacionAsistentes()
	{
		$this->validateSession();
		$datos = array();
		$dato = array();
		$userUbicacion = $this->session->userdata('ubicacion');
		$data = $this->registrolote_modelo->registroStatusContratacion8();
		for ($i = 0; $i < count($data); $i++) {
			$ubicacionVenta = $data[$i]->ubicacion;
			if ($userUbicacion != "CDMX") {
				if ($ubicacionVenta == $userUbicacion) {
					$datos[$i]['idLote'] = $data[$i]->idLote;
					$datos[$i]['id_cliente'] = $data[$i]->id_cliente;
					$datos[$i]['nombre'] = $data[$i]->nombre;
					$datos[$i]['apellido_paterno'] = $data[$i]->apellido_paterno;
					$datos[$i]['apellido_materno'] = $data[$i]->apellido_materno;
					$datos[$i]['nombreLote'] = $data[$i]->nombreLote;
					$datos[$i]['idStatusContratacion'] = $data[$i]->idStatusContratacion;
					$datos[$i]['idMovimiento'] = $data[$i]->idMovimiento;
					$datos[$i]['modificado'] = $data[$i]->modificado;
					$datos[$i]['comentario'] = $data[$i]->comentario;
					$datos[$i]['fechaVenc'] = $data[$i]->fechaVenc;
					$datos[$i]['perfil'] = $data[$i]->perfil;
					$datos[$i]['nombreResidencial'] = $data[$i]->nombreResidencial;
					$datos[$i]['nombreCondominio'] = $data[$i]->nombreCondominio;
					$datos[$i]['ubicacion'] = $data[$i]->ubicacion;
					$datos[$i]['gerente'] = $data[$i]->gerente;
					$datos[$i]['asesor'] = $data[$i]->asesor;
					$datos[$i]['tipo_venta'] = $data[$i]->tipo_venta;
					$datos[$i]['comentario'] = $data[$i]->comentario;
					if (
						$data[$i]->idStatusContratacion == 7 and $data[$i]->idMovimiento = 37
						or $data[$i]->idStatusContratacion == 7 and $data[$i]->idMovimiento == 7
						or $data[$i]->idStatusContratacion == 7 and $data[$i]->idMovimiento == 64
						or $data[$i]->idStatusContratacion == 7 and $data[$i]->idMovimiento == 77
					) {
						$datos[$i]['fechaVenc'] = $data[$i]->fechaVenc;
					}
					if ($data[$i]->idStatusContratacion == 7 and $data[$i]->idMovimiento = 66) {
						$datos[$i]['fechaVenc'] = "Vencido";
					}
					/*status contratacion*/
					if ($data[$i]->idStatusContratacion == 7 and $data[$i]->idMovimiento = 37) {
						$datos[$i]['status'] = "Status 7 listo (Jurídico)";
					}
					if ($data[$i]->idStatusContratacion == 7 and $data[$i]->idMovimiento = 7) {
						$datos[$i]['status'] = "Status 7 listo con Modificaciones (Jurídico)";
					}
					if ($data[$i]->idStatusContratacion == 7 and $data[$i]->idMovimiento = 64) {
						$datos[$i]['status'] = "Status 8 Rechazado (Contraloria)";
					}
					if ($data[$i]->idStatusContratacion == 7 and $data[$i]->idMovimiento = 66) {
						$datos[$i]['status'] = "Status 8 Rechazado (Administración)";
					}
					if ($data[$i]->idStatusContratacion == 7 and $data[$i]->idMovimiento = 77) {
						$datos[$i]['status'] = "Status 7 Enviado a Revisión (Jurídico)";
					}
				}
			} else if ($userUbicacion == "CDMX") {
				$datos[$i]['idLote'] = $data[$i]->idLote;
				$datos[$i]['id_cliente'] = $data[$i]->id_cliente;
				$datos[$i]['nombre'] = $data[$i]->nombre;
				$datos[$i]['apellido_paterno'] = $data[$i]->apellido_paterno;
				$datos[$i]['apellido_materno'] = $data[$i]->apellido_materno;
				$datos[$i]['nombreLote'] = $data[$i]->nombreLote;
				$datos[$i]['idStatusContratacion'] = $data[$i]->idStatusContratacion;
				$datos[$i]['idMovimiento'] = $data[$i]->idMovimiento;
				$datos[$i]['modificado'] = $data[$i]->modificado;
				$datos[$i]['razonSocial'] = $data[$i]->razonSocial;
				$datos[$i]['comentario'] = $data[$i]->comentario;
				$datos[$i]['perfil'] = $data[$i]->perfil;
				$datos[$i]['nombreResidencial'] = $data[$i]->nombreResidencial;
				$datos[$i]['nombreCondominio'] = $data[$i]->nombreCondominio;
				$datos[$i]['ubicacion'] = $data[$i]->ubicacion;
				$datos[$i]['gerente1'] = $data[$i]->gerente;
				$datos[$i]['asesor'] = $data[$i]->asesor;
				$datos[$i]['tipo_venta'] = $data[$i]->tipo_venta;
				$datos[$i]['comentario'] = $data[$i]->comentario;
				/*fecha vencimiento*/
				if (
					$data[$i]->idStatusContratacion == 7 and $data[$i]->idMovimiento = 37
					or $data[$i]->idStatusContratacion == 7 and $data[$i]->idMovimiento == 7
					or $data[$i]->idStatusContratacion == 7 and $data[$i]->idMovimiento == 64
					or $data[$i]->idStatusContratacion == 7 and $data[$i]->idMovimiento == 77
				) {
					$datos[$i]['fechaVenc'] = $data[$i]->fechaVenc;
				}
				if ($data[$i]->idStatusContratacion == 7 and $data[$i]->idMovimiento = 66) {
					$datos[$i]['fechaVenc'] = "Vencido";
				}
				/*status contratacion*/
				if ($data[$i]->idStatusContratacion == 7 and $data[$i]->idMovimiento = 37) {
					$datos[$i]['status'] = "Status 7 listo (Jurídico)";
				}
				if ($data[$i]->idStatusContratacion == 7 and $data[$i]->idMovimiento = 7) {
					$datos[$i]['status'] = "Status 7 listo con Modificaciones (Jurídico)";
				}
				if ($data[$i]->idStatusContratacion == 7 and $data[$i]->idMovimiento = 64) {
					$datos[$i]['status'] = "Status 8 Rechazado (Contraloria)";
				}
				if ($data[$i]->idStatusContratacion == 7 and $data[$i]->idMovimiento = 66) {
					$datos[$i]['status'] = "Status 8 Rechazado (Administración)";
				}
				if ($data[$i]->idStatusContratacion == 7 and $data[$i]->idMovimiento = 77) {
					$datos[$i]['status'] = "Status 7 Enviado a Revisión (Jurídico)";
				}
			}
		}
		$datos = array_values($datos); //resetea los keys de los arrays para que sean consecutivos
		if ($datos != null) {
			echo json_encode($datos);
		} else {
			echo json_encode(array());
		}
	}
	public function editarLoteAsistentesStatusContratacion8($idLote)
	{
		$datos = array();
		$datos["lotes"] = $this->registrolote_modelo->selectRegistroLoteCaja($idLote);
		$datos["asistentesStatus8"] = $this->registrolote_modelo->getAsistentesStatus8();
		$this->load->view('editar_lote_asistentes_proceso8_view', $datos);
	}

	public function editarLoteContraloriaStatusContratacion9($idLote)
	{
		$datos = array();
		$datos["lotes"] = $this->registrolote_modelo->selectRegistroLoteCaja($idLote);
		$datos["contraloriaStatus9"] = $this->registrolote_modelo->getContraloriaStatus9();
		$this->load->view('editar_lote_contraloria_proceso9_view', $datos);
	}
	public function editar_registro_lote_contraloria_proceceso9()
	{
		$idLote = $this->input->post('idLote');
		$idCondominio = $this->input->post('idCondominio');
		$nombreLote = $this->input->post('nombreLote');
		$idStatusContratacion = $this->input->post('idStatusContratacion');
		$idMovimiento = $this->input->post('idMovimiento');
		$idCliente = $this->input->post('idCliente');
		$comentario = $this->input->post('comentario');
		$user = $this->input->post('user');
		$perfil = $this->input->post('perfil');
		$modificado = date("Y-m-d H:i:s");
		$fechaVenc = $this->input->post('fechaVenc');
		$totalNeto = $this->input->post('totalNeto');
		$totalNeto2 = $this->input->post('totalNeto2');
		$arreglo = array();
		$arreglo["idStatusContratacion"] = $idStatusContratacion;
		$arreglo["idMovimiento"] = 39;
		$arreglo["comentario"] = $comentario;
		$arreglo["usuario"] = $this->session->userdata('usuario');
		$arreglo["perfil"] = $this->session->userdata('perfil');
		$arreglo["modificado"] = date("Y-m-d H:i:s");
		$arreglo["fechaVenc"] = $modificado;
		$arreglo["totalNeto"] = $totalNeto;
		$arreglo["totalNeto2"] = $totalNeto2;
		$arreglo2 = array();
		$arreglo2["idStatusContratacion"] = $idStatusContratacion;
		$arreglo2["idMovimiento"] = 39;
		$arreglo2["nombreLote"] = $nombreLote;
		$arreglo2["comentario"] = $comentario;
		$arreglo2["usuario"] = $this->session->userdata('usuario');
		$arreglo2["perfil"] = $this->session->userdata('perfil');
		$arreglo2["modificado"] = date("Y-m-d H:i:s");
		$arreglo2["fechaVenc"] = $fechaVenc;
		$arreglo2["idLote"] = $idLote;
		$arreglo2["idCondominio"] = $idCondominio;
		$arreglo2["idCliente"] = $idCliente;
		if ($this->registrolote_modelo->editaRegistroLoteCaja($idLote, $arreglo)) {
			$this->registrolote_modelo->insertHistorialLotes($arreglo2);
			echo 1;
		} else {
			die("ERROR");
			echo 0;
		}
	}
	public function editarLoteContraloriaStatusContratacion10($idLote)
	{
		$datos = array();
		$datos["lotes"] = $this->registrolote_modelo->selectRegistroLoteCaja($idLote);
		$datos["contraloriaStatus10"] = $this->registrolote_modelo->getContraloriaStatus10();
		$this->load->view('editar_lote_contraloria_proceso10_view', $datos);
	}
	public function editar_registro_lote_contraloria_proceceso10()
	{
		$idLote = $this->input->post('idLote');
		$idCondominio = $this->input->post('idCondominio');
		$nombreLote = $this->input->post('nombreLote');
		$idStatusContratacion = $this->input->post('idStatusContratacion');
		$idMovimiento = $this->input->post('idMovimiento');
		$idCliente = $this->input->post('idCliente');
		$comentario = $this->input->post('comentario');
		$user = $this->input->post('user');
		$perfil = $this->input->post('perfil');
		$modificado = date('Y-m-d H:i:s');
		$fechaVenc = $this->input->post('fechaVenc');
		$arreglo = array();
		$arreglo["idStatusContratacion"] = $idStatusContratacion;
		$arreglo["idMovimiento"] = 40;
		$arreglo["comentario"] = $comentario;
		$arreglo["usuario"] = $this->session->userdata('usuario');
		$arreglo["perfil"] = $this->session->userdata('perfil');
		$arreglo["modificado"] = date("Y-m-d H:i:s");
		$arreglo["fechaSolicitudValidacion"] = $modificado;
		$arreglo["fechaRL"] = $modificado;
		$arreglo2 = array();
		$arreglo2["idStatusContratacion"] = $idStatusContratacion;
		$arreglo2["idMovimiento"] = 40;
		$arreglo2["nombreLote"] = $nombreLote;
		$arreglo2["comentario"] = $comentario;
		$arreglo2["usuario"] = $this->session->userdata('usuario');
		$arreglo2["perfil"] = $this->session->userdata('perfil');
		$arreglo2["modificado"] = date("Y-m-d H:i:s");
		$arreglo2["fechaVenc"] = $fechaVenc;
		$arreglo2["idLote"] = $idLote;
		$arreglo2["idCondominio"] = $idCondominio;
		$arreglo2["idCliente"] = $idCliente;
		if ($this->registrolote_modelo->editaRegistroLoteCaja($idLote, $arreglo)) {
			$this->registrolote_modelo->insertHistorialLotes($arreglo2);
			echo 1;
		} else {
			echo 0;
			die("ERROR");
		}
	}
	public function registroStatus11ContratacionAdministracion()
	{
		$this->load->view('template/header');
		$this->load->view('administracion/estatus11_view');
	}
	public function getStatus11ContrAdmin()
	{
		$datos = array();
		$data = $this->registrolote_modelo->registroStatusContratacion11();
		for ($i = 0; $i < count($data); $i++) {
			$datos[$i]['idLote'] = $data[$i]->idLote;
			$datos[$i]['idCliente'] = $data[$i]->idCliente;
			$datos[$i]['primerNombre'] = $data[$i]->primerNombre;
			$datos[$i]['segundoNombre'] = $data[$i]->segundoNombre;
			$datos[$i]['apellidoPaterno'] = $data[$i]->apellidoPaterno;
			$datos[$i]['apellidoMaterno'] = $data[$i]->apellidoMaterno;
			$datos[$i]['nombreLote'] = $data[$i]->nombreLote;
			$datos[$i]['idStatusContratacion'] = $data[$i]->idStatusContratacion;
			$datos[$i]['idMovimiento'] = $data[$i]->idMovimiento;
			$datos[$i]['modificado'] = $data[$i]->modificado;
			$datos[$i]['razonSocial'] = $data[$i]->razonSocial;
			$datos[$i]['nombreCondominio'] = $data[$i]->nombreCondominio;
			$datos[$i]['nombreResidencial'] = $data[$i]->nombreResidencial;
			$datos[$i]['fechaVenc'] = $data[$i]->fechaVenc;
			$datos[$i]['perfil'] = $data[$i]->perfil;
			$datos[$i]['ubicacion'] = $data[$i]->ubicacion;
			$datos[$i]['fechaSolicitudValidacion'] = $data[$i]->fechaSolicitudValidacion;
			$datos[$i]['totalNeto'] = $data[$i]->totalNeto;
			$datos[$i]['tipo_venta'] = $data[$i]->tipo_venta;
		}
		if ($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
		exit;
	}
	public function editarLoteAdministracionStatusContratacion11($idLote)
	{
		$data["lotes"] = $this->registrolote_modelo->selectRegistroLoteCaja($idLote);
		$data["administracionStatus11"] = $this->registrolote_modelo->getAdministracionStatus11();
		if ($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
		exit;
	}
	public function registroStatus12ContratacionRepresentante()
	{
		$datos = array();
		$datos = $this->registrolote_modelo->registroStatusContratacion12();
		if ($datos != null) {
			echo json_encode($datos);
		} else {
			echo json_encode(array());
		}
		exit;
	}
	public function editarLoteRepresentanteStatusContratacion12($idLote)
	{
		$datos = array();
		$datos["lotes"] = $this->registrolote_modelo->selectRegistroLoteCaja($idLote);
		$datos["representanteStatus12"] = $this->registrolote_modelo->getRepresentanteStatus12();
		$this->load->view('editar_lote_representante_proceso12_view', $datos);
	}
	public function editar_registro_lote_representante_proceceso12()
	{
		$idLote = $this->input->post('idLote');
		$idCondominio = $this->input->post('idCondominio');
		$nombreLote = $this->input->post('nombreLote');
		$idStatusContratacion = $this->input->post('idStatusContratacion');
		$idMovimiento = $this->input->post('idMovimiento');
		$idCliente = $this->input->post('idCliente');
		$comentario = $this->input->post('comentario');
		$user = $this->input->post('user');
		$perfil = $this->input->post('perfil');
		$modificado = date('Y-m-d H:i:s');
		$fechaVenc = $this->input->post('fechaRL');
		$firmaRL = $this->input->post('firmaRL');
		$arreglo = array();
		$arreglo["idStatusContratacion"] = $idStatusContratacion;
		$arreglo["idMovimiento"] = 42;
		$arreglo["comentario"] = $comentario;
		$arreglo["user"] = $this->session->userdata('username');
		$arreglo["perfil"] = $this->session->userdata('perfil');
		$arreglo["modificado"] = date("Y-m-d H:i:s");
		$arreglo["firmaRL"] = "FIRMADO";
		date_default_timezone_set('America/Mexico_City');
		$horaActual = date('H:i:s');
		$horaInicio = date("08:00:00");
		$horaFin = date("16:00:00");
		if ($horaActual > $horaInicio and $horaActual < $horaFin) {
			$fechaAccion = date("Y-m-d H:i:s");
			$hoy_strtotime2 = strtotime($fechaAccion);
			$sig_fecha_dia2 = date('D', $hoy_strtotime2);
			$sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
			if (
				$sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
				$sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
				$sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
				$sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
				$sig_fecha_feriado2 == "25-12"
			) {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 0) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				for ($i = 0; $i < count($fecha); $i++) {
					$arreglo["fechaVenc"] = $fecha;
				}
			} else {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= -1) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				for ($i = 0; $i < count($fecha); $i++) {
					$arreglo["fechaVenc"] = $fecha;
				}
			}
		} elseif ($horaActual < $horaInicio || $horaActual > $horaFin) {
			$fechaAccion = date("Y-m-d H:i:s");
			$hoy_strtotime2 = strtotime($fechaAccion);
			$sig_fecha_dia2 = date('D', $hoy_strtotime2);
			$sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
			if (
				$sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
				$sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
				$sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
				$sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
				$sig_fecha_feriado2 == "25-12"
			) {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 0) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				for ($i = 0; $i < count($fecha); $i++) {
					$arreglo["fechaVenc"] = $fecha;
				}
			} else {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 0) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				for ($i = 0; $i < count($fecha); $i++) {
					$arreglo["fechaVenc"] = $fecha;
				}
			}
		}
		$arreglo2 = array();
		$arreglo2["idStatusContratacion"] = $idStatusContratacion;
		$arreglo2["idMovimiento"] = 42;
		$arreglo2["nombreLote"] = $nombreLote;
		$arreglo2["comentario"] = $comentario;
		$arreglo2["user"] = $this->session->userdata('username');
		$arreglo2["perfil"] = $this->session->userdata('perfil');
		$arreglo2["modificado"] = date("Y-m-d H:i:s");
		date_default_timezone_set('America/Mexico_City');
		$horaActual = date('H:i:s');
		$horaInicio = date("08:00:00");
		$horaFin = date("16:00:00");
		if ($horaActual > $horaInicio and $horaActual < $horaFin) {
			$fechaAccion = $fechaVenc;
			$hoy_strtotime2 = strtotime($fechaAccion);
			$sig_fecha_dia2 = date('D', $hoy_strtotime2);
			$sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
			if (
				$sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
				$sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
				$sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
				$sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
				$sig_fecha_feriado2 == "25-12"
			) {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 4) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				for ($i = 0; $i < count($fecha); $i++) {
					$arreglo2["fechaVenc"] = $fecha;
				}
			} else {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 3) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				for ($i = 0; $i < count($fecha); $i++) {
					$arreglo2["fechaVenc"] = $fecha;
				}
			}
		} elseif ($horaActual < $horaInicio || $horaActual > $horaFin) {
			$fechaAccion = $fechaVenc;
			$hoy_strtotime2 = strtotime($fechaAccion);
			$sig_fecha_dia2 = date('D', $hoy_strtotime2);
			$sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
			if (
				$sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
				$sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
				$sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
				$sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
				$sig_fecha_feriado2 == "25-12"
			) {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 4) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				for ($i = 0; $i < count($fecha); $i++) {
					$arreglo2["fechaVenc"] = $fecha;
				}
			} else {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 4) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				for ($i = 0; $i < count($fecha); $i++) {
					$arreglo2["fechaVenc"] = $fecha;
				}
			}
		}
		$arreglo2["idLote"] = $idLote;
		$arreglo2["idCondominio"] = $idCondominio;
		$arreglo2["idCliente"] = $idCliente;
		if ($this->registrolote_modelo->editaRegistroLoteCaja($idLote, $arreglo)) {
			$this->registrolote_modelo->insertHistorialLotes($arreglo2);
			redirect(base_url() . "index.php/registroLote/registroStatus12ContratacionRepresentante");
		} else {
			die("ERROR");
		}
	}
	public function editarLoteContraloriaStatusContratacion13($idLote)
	{
		$datos = array();
		$datos["lotes"] = $this->registrolote_modelo->selectRegistroLoteCaja($idLote);
		$datos["contraloriaStatus13"] = $this->registrolote_modelo->getContraloriaStatus13();
		$this->load->view('editar_lote_contraloria_proceso13_view', $datos);
	}
	public function editar_registro_lote_contraloria_proceceso13()
	{
		$idLote = $this->input->post('idLote');
		$idCondominio = $this->input->post('idCondominio');
		$nombreLote = $this->input->post('nombreLote');
		$idStatusContratacion = $this->input->post('idStatusContratacion');
		$idMovimiento = $this->input->post('idMovimiento');
		$idCliente = $this->input->post('idCliente');
		$comentario = $this->input->post('comentario');
		$user = $this->input->post('user');
		$perfil = $this->input->post('perfil');
		$modificado = date('Y-m-d H:i:s');
		$fechaVenc = $this->input->post('fechaVenc');
		$arreglo = array();
		$arreglo["idStatusContratacion"] = $idStatusContratacion;
		$arreglo["idMovimiento"] = 43;
		$arreglo["comentario"] = $comentario;
		$arreglo["usuario"] = $this->session->userdata('usuario');
		$arreglo["perfil"] = $this->session->userdata('perfil');
		$arreglo["modificado"] = date("Y-m-d H:i:s");
		date_default_timezone_set('America/Mexico_City');
		$horaActual = date('H:i:s');
		$horaInicio = date("08:00:00");
		$horaFin = date("16:00:00");
		if ($horaActual > $horaInicio and $horaActual < $horaFin) {
			$fechaAccion = date("Y-m-d H:i:s");
			$hoy_strtotime2 = strtotime($fechaAccion);
			$sig_fecha_dia2 = date('D', $hoy_strtotime2);
			$sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
			if (
				$sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
				$sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
				$sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
				$sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
				$sig_fecha_feriado2 == "25-12"
			) {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 1) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				$arreglo["fechaVenc"] = $fecha;
			} else {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 0) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				$arreglo["fechaVenc"] = $fecha;
			}
		} elseif ($horaActual < $horaInicio || $horaActual > $horaFin) {
			$fechaAccion = date("Y-m-d H:i:s");
			$hoy_strtotime2 = strtotime($fechaAccion);
			$sig_fecha_dia2 = date('D', $hoy_strtotime2);
			$sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
			if (
				$sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
				$sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
				$sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
				$sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
				$sig_fecha_feriado2 == "25-12"
			) {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 1) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				$arreglo["fechaVenc"] = $fecha;
			} else {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 1) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				$arreglo["fechaVenc"] = $fecha;
			}
		}
		$arreglo2 = array();
		$arreglo2["idStatusContratacion"] = $idStatusContratacion;
		$arreglo2["idMovimiento"] = 43;
		$arreglo2["nombreLote"] = $nombreLote;
		$arreglo2["comentario"] = $comentario;
		$arreglo2["usuario"] = $this->session->userdata('usuario');
		$arreglo2["perfil"] = $this->session->userdata('perfil');
		$arreglo2["modificado"] = date("Y-m-d H:i:s");
		$arreglo2["fechaVenc"] = $fechaVenc;
		$arreglo2["idLote"] = $idLote;
		$arreglo2["idCondominio"] = $idCondominio;
		$arreglo2["idCliente"] = $idCliente;
		if ($this->registrolote_modelo->editaRegistroLoteCaja($idLote, $arreglo)) {
			$this->registrolote_modelo->insertHistorialLotes($arreglo2);
			echo 1;
		} else {
			echo 0;
			die("ERROR");
		}
	}
	public function registroStatus14ContratacionAsistentes()
	{
		$this->load->view('template/header');
		$this->load->view("contratacion/datos_status14Contratacion_asistentes_view");
	}
	public function getStatCont14()
	{
		$dato = array();
		$data = $this->registrolote_modelo->registroStatusContratacion14();
		$userUbicacion = $this->session->userdata('ubicacion');
		for ($i = 0; $i < count($data); $i++) {
			$ubicacionVenta = $data[$i]->ubicacion;
			if ($userUbicacion != "CDMX") {
				if ($ubicacionVenta == $userUbicacion) {
					$dato[$i]['idLote'] = $data[$i]->idLote;
					$dato[$i]['id_cliente'] = $data[$i]->id_cliente;
					$dato[$i]['nombre'] = $data[$i]->nombre;
					$dato[$i]['apellido_paterno'] = $data[$i]->apellido_paterno;
					$dato[$i]['apellido_materno'] = $data[$i]->apellido_materno;
					$dato[$i]['nombreLote'] = $data[$i]->nombreLote;
					$dato[$i]['idStatusContratacion'] = $data[$i]->idStatusContratacion;
					$dato[$i]['idMovimiento'] = $data[$i]->idMovimiento;
					$dato[$i]['modificado'] = $data[$i]->modificado;
					$dato[$i]['comentario'] = $data[$i]->comentario;
					$dato[$i]['fechaVenc'] = $data[$i]->fechaVenc;
					$dato[$i]['perfil'] = $data[$i]->perfil;
					$dato[$i]['nombreResidencial'] = $data[$i]->nombreResidencial;
					$dato[$i]['nombreCondominio'] = $data[$i]->nombreCondominio;
					$dato[$i]['ubicacion'] = $data[$i]->ubicacion;
					$dato[$i]['gerente'] = $data[$i]->gerente;
					$dato[$i]['asesor'] = $data[$i]->asesor;
					$dato[$i]['tipo_venta'] = $data[$i]->tipo_venta;
				}
			}
			if ($userUbicacion == "CDMX") {
				$dato[$i]['idLote'] = $data[$i]->idLote;
				$dato[$i]['idCliente'] = $data[$i]->idCliente;
				$dato[$i]['primerNombre'] = $data[$i]->primerNombre;
				$dato[$i]['segundoNombre'] = $data[$i]->segundoNombre;
				$dato[$i]['apellidoPaterno'] = $data[$i]->apellidoPaterno;
				$dato[$i]['apellidoMaterno'] = $data[$i]->apellidoMaterno;
				$dato[$i]['nombreLote'] = $data[$i]->nombreLote;
				$dato[$i]['idStatusContratacion'] = $data[$i]->idStatusContratacion;
				$dato[$i]['idMovimiento'] = $data[$i]->idMovimiento;
				$dato[$i]['modificado'] = $data[$i]->modificado;
				$dato[$i]['razonSocial'] = $data[$i]->razonSocial;
				$dato[$i]['comentario'] = $data[$i]->comentario;
				$dato[$i]['fechaVenc'] = $data[$i]->fechaVenc;
				$dato[$i]['perfil'] = $data[$i]->perfil;
				$dato[$i]['nombreResidencial'] = $data[$i]->nombreResidencial;
				$dato[$i]['nombreCondominio'] = $data[$i]->nombreCondominio;
				$dato[$i]['ubicacion'] = $data[$i]->ubicacion;
				$dato[$i]['gerente1'] = $data[$i]->gerente1;
				$dato[$i]['gerente2'] = $data[$i]->gerente2;
				$dato[$i]['gerente3'] = $data[$i]->gerente3;
				$dato[$i]['gerente4'] = $data[$i]->gerente4;
				$dato[$i]['gerente5'] = $data[$i]->gerente5;
				$dato[$i]['asesor'] = $data[$i]->asesor;
				$dato[$i]['asesor2'] = $data[$i]->asesor2;
				$dato[$i]['asesor3'] = $data[$i]->asesor3;
				$dato[$i]['asesor4'] = $data[$i]->asesor4;
				$dato[$i]['asesor5'] = $data[$i]->asesor5;
				$dato[$i]['tipo_venta'] = $data[$i]->tipo_venta;
			}
		}
		$dato = array_values($dato);
		if ($dato != null) {
			echo json_encode($dato);
		} else {
			echo json_encode(array());
		}
		exit;
	}
	public function editarLoteAsistentesStatusContratacion14($idLote)
	{
		$datos = array();
		$datos["lotes"] = $this->registrolote_modelo->selectRegistroLoteCaja($idLote);
		$datos["asistentesStatus14"] = $this->registrolote_modelo->getAsistentesStatus14();
		$this->load->view('editar_lote_asistentes_proceso14_view', $datos);
	}
	public function getJurStats7ToVentas3()
	{
		//rechazosJuridicoStatus7aVentas3
		$this->validateSession();
		$datos = array();
		$dato = array();
		$userUbicacion = $this->session->userdata('ubicacion');
		$data = $this->registrolote_modelo->registroRechazosStatus3Contratacion();
		for ($i = 0; $i < count($data); $i++) {
			$ubicacionVenta = $data[$i]->ubicacion;
			if ($userUbicacion != "CDMX") {
				if ($ubicacionVenta == $userUbicacion) {
					$datos[$i]['idLote'] = $data[$i]->idLote;
					$datos[$i]['id_cliente'] = $data[$i]->id_cliente;
					$datos[$i]['idCondominio'] = $data[$i]->idCondominio;
					$datos[$i]['nombre'] = $data[$i]->nombre;
					$datos[$i]['apellido_paterno'] = $data[$i]->apellido_paterno;
					$datos[$i]['apellido_materno'] = $data[$i]->apellido_materno;
					$datos[$i]['nombreLote'] = $data[$i]->nombreLote;
					$datos[$i]['idStatusContratacion'] = $data[$i]->idStatusContratacion;
					$datos[$i]['idMovimiento'] = $data[$i]->idMovimiento;
					$datos[$i]['modificado'] = $data[$i]->modificado;
					$datos[$i]['comentario'] = $data[$i]->comentario;
					$datos[$i]['fechaVenc'] = $data[$i]->fechaVenc;
					$datos[$i]['perfil'] = $data[$i]->perfil;
					$datos[$i]['nombreResidencial'] = $data[$i]->nombreResidencial;
					$datos[$i]['nombreCondominio'] = $data[$i]->nombreCondominio;
					$datos[$i]['ubicacion'] = $data[$i]->ubicacion;
					$datos[$i]['gerente'] = $data[$i]->gerente;
					$datos[$i]['asesor'] = $data[$i]->asesor;
					$datos[$i]['tipo_venta'] = $data[$i]->tipo_venta;
					$datos[$i]['comentario'] = $data[$i]->comentario;
					/*fecha vencimiento*/
					if ($data[$i]->idStatusContratacion == 3 and $data[$i]->idMovimiento = 82) {
						$datos[$i]['fechaVenc'] = $data[$i]->fechaVenc;
					} else {
						$datos[$i]['fechaVenc'] = "Vencido";
					}
					/*status contratacion*/
					if ($data[$i]->idStatusContratacion == 3 and $data[$i]->idMovimiento = 82) {
						$datos[$i]['status'] = "Status 7 Rechazado (Jurídico) ";
					}
				}
			} else if ($userUbicacion == "CDMX") {
				$datos[$i]['idLote'] = $data[$i]->idLote;
				$datos[$i]['id_cliente'] = $data[$i]->id_cliente;
				$datos[$i]['idCondominio'] = $data[$i]->idCondominio;
				$datos[$i]['nombre'] = $data[$i]->nombre;
				$datos[$i]['apellido_paterno'] = $data[$i]->apellido_paterno;
				$datos[$i]['apellido_materno'] = $data[$i]->apellido_materno;
				$datos[$i]['nombreLote'] = $data[$i]->nombreLote;
				$datos[$i]['idStatusContratacion'] = $data[$i]->idStatusContratacion;
				$datos[$i]['idMovimiento'] = $data[$i]->idMovimiento;
				$datos[$i]['modificado'] = $data[$i]->modificado;
				$datos[$i]['razonSocial'] = $data[$i]->razonSocial;
				$datos[$i]['comentario'] = $data[$i]->comentario;
				$datos[$i]['perfil'] = $data[$i]->perfil;
				$datos[$i]['nombreResidencial'] = $data[$i]->nombreResidencial;
				$datos[$i]['nombreCondominio'] = $data[$i]->nombreCondominio;
				$datos[$i]['ubicacion'] = $data[$i]->ubicacion;
				$datos[$i]['gerente1'] = $data[$i]->gerente;
				$datos[$i]['asesor'] = $data[$i]->asesor;
				$datos[$i]['tipo_venta'] = $data[$i]->tipo_venta;
				$datos[$i]['comentario'] = $data[$i]->comentario;
				/*fecha vencimiento*/
				if ($data[$i]->idStatusContratacion == 3 and $data[$i]->idMovimiento = 82) {
					$datos[$i]['fechaVenc'] = $data[$i]->fechaVenc;
				} else {
					$datos[$i]['fechaVenc'] = "Vencido";
				}
				/*status contratacion*/
				if ($data[$i]->idStatusContratacion == 3 and $data[$i]->idMovimiento = 82) {
					$datos[$i]['status'] = "Status 7 Rechazado (Jurídico) ";
				}
			}
		}
		$datos = array_values($datos); //resetea los keys de los arrays para que sean consecutivos
		if ($datos != null) {
			echo json_encode($datos);
		} else {
			echo json_encode(array());
		}
	}
	public function editar_registro_lote_asistentes_proceceso14()
	{
		$idLote = $this->input->post('idLote');
		$idCondominio = $this->input->post('idCondominio');
		$nombreLote = $this->input->post('nombreLote');
		$idStatusContratacion = $this->input->post('idStatusContratacion');
		$idCliente = $this->input->post('id_cliente');
		$comentario = $this->input->post('comentario');
		$fechaVenc = $this->input->post('fechaVenc');
		$arreglo = array();
		$arreglo["idStatusContratacion"] = $idStatusContratacion;
		$arreglo["idMovimiento"] = 44;
		$arreglo["comentario"] = $comentario;
		$arreglo["usuario"] = $this->session->userdata('usuario');
		$arreglo["perfil"] = $this->session->userdata('perfil');
		$arreglo["modificado"] = date("Y-m-d H:i:s");
		date_default_timezone_set('America/Mexico_City');
		$horaActual = date('H:i:s');
		$horaInicio = date("08:00:00");
		$horaFin = date("16:00:00");
		if ($horaActual > $horaInicio and $horaActual < $horaFin) {
			$fechaAccion = date("Y-m-d H:i:s");
			$hoy_strtotime2 = strtotime($fechaAccion);
			$sig_fecha_dia2 = date('D', $hoy_strtotime2);
			$sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
			if (
				$sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
				$sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
				$sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
				$sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
				$sig_fecha_feriado2 == "25-12"
			) {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 0) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				for ($i = 0; $i < count($fecha); $i++) {
					$arreglo["fechaVenc"] = $fecha;
				}
			} else {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= -1) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				for ($i = 0; $i < count($fecha); $i++) {
					$arreglo["fechaVenc"] = $fecha;
				}
			}
		} elseif ($horaActual < $horaInicio || $horaActual > $horaFin) {
			$fechaAccion = date("Y-m-d H:i:s");
			$hoy_strtotime2 = strtotime($fechaAccion);
			$sig_fecha_dia2 = date('D', $hoy_strtotime2);
			$sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
			if (
				$sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
				$sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
				$sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
				$sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
				$sig_fecha_feriado2 == "25-12"
			) {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 0) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				for ($i = 0; $i < count($fecha); $i++) {
					$arreglo["fechaVenc"] = $fecha;
				}
			} else {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 0) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				for ($i = 0; $i < count($fecha); $i++) {
					$arreglo["fechaVenc"] = $fecha;
				}
			}
		}
		$arreglo2 = array();
		$arreglo2["idStatusContratacion"] = $idStatusContratacion;
		$arreglo2["idMovimiento"] = 44;
		$arreglo2["nombreLote"] = $nombreLote;
		$arreglo2["comentario"] = $comentario;
		$arreglo2["usuario"] = $this->session->userdata('usuario');
		$arreglo2["perfil"] = $this->session->userdata('perfil');
		$arreglo2["modificado"] = date("Y-m-d H:i:s");
		$arreglo2["fechaVenc"] = $fechaVenc;
		$arreglo2["idLote"] = $idLote;
		$arreglo2["idCondominio"] = $idCondominio;
		$arreglo2["idCliente"] = $idCliente;
		if ($this->registrolote_modelo->editaRegistroLoteCaja($idLote, $arreglo)) {
			$this->registrolote_modelo->insertHistorialLotes($arreglo2);
			$this->session->set_userdata('succesChangeStatus14', 1);
			redirect(base_url() . "index.php/registroLote/registroStatus14ContratacionAsistentes");
		} else {
			$this->session->set_userdata('succesChangeStatus14', 33);
			die("ERROR");
		}
	}
	public function editarLoteContraloriaStatusContratacion15($idLote)
	{
		$datos = array();
		$datos["lotes"] = $this->registrolote_modelo->selectRegistroLoteCaja($idLote);
		$datos["contraloriaStatus15"] = $this->registrolote_modelo->getContraloriaStatus15();
		$this->load->view('editar_lote_contraloria_proceso15_view', $datos);
	}
	public function editar_registro_lote_contraloria_proceceso15()
	{
		$idLote = $this->input->post('idLote');
		$idCondominio = $this->input->post('idCondominio');
		$nombreLote = $this->input->post('nombreLote');
		$idStatusContratacion = $this->input->post('idStatusContratacion');
		$idMovimiento = $this->input->post('idMovimiento');
		$idCliente = $this->input->post('idCliente');
		$comentario = $this->input->post('comentario');
		$idStatusLote = $this->input->post('idStatusLote');
		$user = $this->input->post('user');
		$perfil = $this->input->post('perfil');
		$modificado = date('Y-m-d H:i:s');
		$fechaVenc = $this->input->post('fechaVenc');
		$arreglo = array();
		$arreglo["idStatusContratacion"] = $idStatusContratacion;
		$arreglo["idMovimiento"] = 45;
		$arreglo["comentario"] = $comentario;
		$arreglo["idStatusLote"] = 2;
		$arreglo["usuario"] = $this->session->userdata('usuario');
		$arreglo["perfil"] = $this->session->userdata('perfil');
		$arreglo["modificado"] = date("Y-m-d H:i:s");
		$arreglo["fechaVenc"] = $modificado;
		$arreglo2 = array();
		$arreglo2["idStatusContratacion"] = $idStatusContratacion;
		$arreglo2["idMovimiento"] = 45;
		$arreglo2["nombreLote"] = $nombreLote;
		$arreglo2["comentario"] = $comentario;
		$arreglo2["usuario"] = $this->session->userdata('usuario');
		$arreglo2["perfil"] = $this->session->userdata('perfil');
		$arreglo2["modificado"] = date("Y-m-d H:i:s");
		$arreglo2["fechaVenc"] = $fechaVenc;
		$arreglo2["idLote"] = $idLote;
		$arreglo2["idCondominio"] = $idCondominio;
		$arreglo2["idCliente"] = $idCliente;
		if ($this->registrolote_modelo->editaRegistroLoteCaja($idLote, $arreglo)) {
			$this->registrolote_modelo->insertHistorialLotes($arreglo2);
			echo 1;
		} else {
			die("ERROR");
			echo 0;
		}
	}
	///////////////////// FIN PANEL PARA REGISTRAR EL STATUS POR AREA/////////////////////////////////////////////
	public function registrosLoteYola()
	{
		$datos = array();
		$datos["registrosLoteYola"] = $this->registrolote_modelo->registroLote();
		$this->load->view('datos_lote_yola_view', $datos);
	}
	public function reporteContratacion()
	{
		$datos = array();
		$datos["reporteContratacion"] = $this->registrolote_modelo->reporteContratacion();
		$this->load->view("reporte_contratacion_view", $datos);
	}
	public function finalStatus()
	{
		$this->load->view('template/header');
		$this->load->view("contratacion/datos_finalStatus_view");
	}
	public function Procesos_Status($idStatus, $idMov)
	{
		$Control_Pro = array(
			"IdStatusContratacion" => array(
				'1,2,3',
				'1,2',
				'2',
				'3,2',
				'2',
				'5,2,1',
				'6,7',
				'6,7',
				'8,11',
				'9',
				'10',
				'12,11,10',
				'13',
				'14',
				'15',
				'711',
				'700',
				'011'
			),
			"IdMovimineto" => array(
				'31,85,82,92',
				'18,20,84,19,63,73',
				'2,32',
				'33,3',
				'4,74,84,93',
				'35,22,62,75,94,96',
				'36,6,76,83,95,97',
				'23',
				'38,65,41',
				'39',
				'40',
				'42,41,40',
				'43,68',
				'44,69,80',
				'45',
				'37,7,64,66,77,41,40,10,67,38,65,42',
				'37,7,64,66,77,41',
				'40,10,37,7,38,65,67,42'
			),
			"ProcContra" => array(
				'2. Recepción de Expediente (ventas-asesor)',
				'2. Integración de Expediente (Contraloría)',
				'3. Revisión Jurídico (Jurídico)',
				'4. Datos Verificados (Postventa)',
				'5.Revisión100%(Contraloria)',
				'6.Corridaelaborada(Contraloría)',
				'7.Contratoelaborado(Jurídico)',
				'7.ElaboracióndeContrato(Jurídico)',
				'9.Contratorecibidoconfirmadecliente(Contraloría)',
				'10.SolicituddevalidacióndeengancheyenviodecontratoaRL(Contraloría)',
				'12.Contratofirmado(RepresentanteLegal)//vista8y11',
				'13.Contratolistoyentregadoasesores(Contraloría)',
				'14.FirmaAcusecliente(AsistentesGerentes)',
				'15.Acuseentregado(Contraloría)',
				'LOTE CONTRATADO',
				'8. Contrato entregado al asesor para firma del cliente (Asistentes de Gerentes) <br> 11. Validación de enganche (Administración)',
				'8.Contratoentregadoalasesorparafirmadelcliente(AsistentesdeGerentes)',
				'11.Validacióndeenganche(Administración)'
			)
		);
		for ($i = 0; $i < count($Control_Pro["IdStatusContratacion"]); $i++) {
			if (preg_match("/\b" . (string) $idStatus . "\b/", $Control_Pro["IdStatusContratacion"][$i])) {
				if (preg_match("/\b" . (string) $idMov . "\b/", $Control_Pro["IdMovimineto"][$i])) {
					return $Control_Pro["ProcContra"][$i];
				}
			}
		}
		return ('Not Set: ' . $idMov);
	}
	public function getFinalStatus()
	{
		$datos = array();
		$data = $this->registrolote_modelo->finalStatus($this->input->post("id_sede"), $this->input->post("residencial"));
		for ($i = 0; $i < count($data); $i++) {
			$datos[$i]['referencia'] = $data[$i]->referencia;
			$datos[$i]['idLote'] = $data[$i]->idLote;
			$datos[$i]['nombreSede'] = $data[$i]->nombreSede;
			$datos[$i]['id_cliente'] = $data[$i]->id_cliente;
			$datos[$i]['nombreLote'] = $data[$i]->nombreLote;
			$datos[$i]['idStatusContratacion'] = $data[$i]->idStatusContratacion;
			$datos[$i]['idMovimiento'] = $data[$i]->idMovimiento;
			$datos[$i]['modificado'] = $data[$i]->modificado;
			$datos[$i]['perfil'] = $data[$i]->perfil;
			$datos[$i]['nombreCondominio'] = $data[$i]->nombreCondominio;
			$datos[$i]['nombreResidencial'] = $data[$i]->nombreResidencial;
			$datos[$i]['fechaVenc'] = $data[$i]->fechaVenc;
			$datos[$i]['nombreCliente'] = $data[$i]->nombreCliente;
			$datos[$i]['comentario'] = $data[$i]->comentario;
			$datos[$i]['fechaSolicitudValidacion'] = $data[$i]->fechaSolicitudValidacion;
			$datos[$i]['gerente'] = ($data[$i]->gerente == " ") ? "NO APLICA" : $data[$i]->gerente;
			$datos[$i]['asesor'] = $data[$i]->asesor;
			$datos[$i]['observacionContratoUrgente'] = $data[$i]->observacionContratoUrgente;
			$datos[$i]['modificado_historial'] = $data[$i]->modificado_historial;
			$datos[$i]['estatus_lote'] = $data[$i]->estatus_lote;
			$datos[$i]['tipo_venta'] = $data[$i]->tipo_venta;
			$datos[$i]['color'] = $data[$i]->color;
			$datos[$i]['firmaRL'] = $data[$i]->firmaRL;
			$datos[$i]['validacionEnganche'] = $data[$i]->validacionEnganche;
			$datos[$i]['sup'] = $data[$i]->sup;
			$datos[$i]['fechaApartado'] = $data[$i]->fechaApartado;
			$procesoContratacion = $this->getProcesoContratacion($data[$i]->idStatusContratacion, $data[$i]->idMovimiento, $data[$i]->validacionEnganche, $data[$i]->status8Flag);
			$status = $this->getStatusContratacion($data[$i]->idStatusContratacion, $data[$i]->idMovimiento, $data[$i]->firmaRL, $data[$i]->validacionEnganche, $data[$i]->perfil);
			list($fechaVencimiento, $fechaVenc2) = $this->getFechaVencimiento($data[$i]->idStatusContratacion, $data[$i]->idMovimiento, $data[$i]->fechaVenc, $data[$i]->fechaSolicitudValidacion, $data[$i]->fechaEstatus7, $data[$i]->validacionEnganche, $data[$i]->status8Flag, $data[$i]->modificado_historial, $data[$i]->fechaEstatus8);
			list($diasRest, $arrayFechas, $diasRest2) = $this->getDiasRestantes($data[$i]->idStatusContratacion, $data[$i]->idMovimiento, $data[$i]->fechaVenc, $data[$i]->fechaSolicitudValidacion, $data[$i]->validacionEnganche, $data[$i]->status8Flag, $fechaVenc2, $fechaVencimiento);
			list($diasVenc, $arrayFechas2, $diasVenc2) = $this->getDiasVencidos($data[$i]->idStatusContratacion, $data[$i]->idMovimiento, $data[$i]->fechaVenc, $data[$i]->fechaSolicitudValidacion, $data[$i]->validacionEnganche, $data[$i]->status8Flag, $fechaVenc2, $fechaVencimiento);
			$statusFecha = $this->getStatusFecha($data[$i]->idStatusContratacion, $data[$i]->idMovimiento, $arrayFechas, $arrayFechas2);
			$datos[$i]['procesoContratacion'] = strtoupper($procesoContratacion);
			$datos[$i]['status'] = strtoupper ($status);
			$datos[$i]['fechaVencimiento'] = strtoupper($fechaVencimiento);
			$datos[$i]['fechaVencimiento2'] =$fechaVenc2;
			$datos[$i]['diasRest'] = $diasRest;
			$datos[$i]['diasRest2'] = $diasRest2;
			$datos[$i]['diasVenc'] = $diasVenc;
			$datos[$i]['diasVenc2'] = $diasVenc2;
			$datos[$i]['statusFecha'] = strtoupper($statusFecha);
			$datos[$i]['status8Flag'] = $data[$i]->status8Flag;
			$datos[$i]['id_cliente_reubicacion'] = $data[$i]->id_cliente_reubicacion;
			$datos[$i]['fechaAlta'] = $data[$i]->fechaAlta;
		}
		if ($datos != null) {
			$result['data'] = $datos;
			echo json_encode($result);
		} else {
			$result['data'] = array();
			echo json_encode($result);
		}
	}
	public function getProcesoContratacion($idStatusContratacion, $idMovimiento, $validacionEnganche, $status8Flag)
	{
		if ($idStatusContratacion == 1 && $idMovimiento == 31)
			$procesoContratacion = "2. Recepción de Expediente (ventas-asesor)";
		else if ($idStatusContratacion == 2 && $idMovimiento == 85)
			$procesoContratacion = "2. Recepción de Expediente (ventas-asesor)";
		else if ($idStatusContratacion == 3 && $idMovimiento == 82)
			$procesoContratacion = "2. Recepción de Expediente (ventas-asesor)";
		else if ($idStatusContratacion == 7 && $idMovimiento == 83)
			$procesoContratacion = "7. Contrato elaborado (Jurídico)";
		else if (in_array($idStatusContratacion, array(1, 2)) && in_array($idMovimiento, array(18, 19, 20, 63, 84)))
			$procesoContratacion = "2. Integración de Expediente (Contraloría)";
		else if ($idStatusContratacion == 2 && in_array($idMovimiento, array(2, 32)))
			$procesoContratacion = "3. Revisión Jurídico (Jurídico)";
		else if (in_array($idStatusContratacion, array(3, 2)) && in_array($idMovimiento, array(33, 3)))
			$procesoContratacion = "4. Datos Verificados (Postventa)";
		else if (in_array($idStatusContratacion, array(4, 2)) && in_Array($idMovimiento, array(34, 4)))
			$procesoContratacion = "5. Revisión 100% (Contraloria)";
		else if (in_array($idStatusContratacion, array(5, 2)) && in_array($idMovimiento, array(35, 22, 62, 75)))
			$procesoContratacion = "6. Corrida elaborada (Contraloría)";
		else if (in_array($idStatusContratacion, array(6)) && in_array($idMovimiento, array(36, 6, 76)))
			$procesoContratacion = "7. Contrato elaborado (Jurídico)";
		else if ($idStatusContratacion == 6 && $idMovimiento == 23)
			$procesoContratacion = "7. Elaboración de Contrato (Jurídico)";
		else if ($idStatusContratacion == 7 && in_array($idMovimiento, array(37, 7, 77)) && $validacionEnganche != 'VALIDADO')
			$procesoContratacion = "8. Contrato entregado al asesor para firma del cliente (Asistentes de Gerentes) / 11. Validación de enganche (Administración)";
		else if ($idStatusContratacion == 7 && in_array($idMovimiento, array(37, 7, 77)) && $validacionEnganche == 'VALIDADO')
			$procesoContratacion = "8. Contrato entregado al asesor para firma del cliente (Asistentes de Gerentes)";
		else if ($idStatusContratacion == 8 && in_array($idMovimiento, array(38, 65)) && $validacionEnganche != 'VALIDADO')
			$procesoContratacion = "11. Validación de enganche (Administración))";
		else if ($idStatusContratacion == 8 && in_array($idMovimiento, array(38, 65)) && $validacionEnganche == 'VALIDADO')
			$procesoContratacion = "9. Contrato recibido con firma de cliente (Contraloría)";
		else if ($idStatusContratacion == 9 && in_array($idMovimiento, array(39, 26)))
			$procesoContratacion = "10. Solicitud de validación de enganche y envio de contrato a RL (Contraloría)";
		else if ($idStatusContratacion == 10 && in_array($idMovimiento, array(40, 10)))
			$procesoContratacion = "13. Contrato listo y entregado asesores (Contraloría)";
		else if ($idStatusContratacion == 11 && $idMovimiento == 41 && $status8Flag != 1)
			$procesoContratacion = "8. Contrato entregado al asesor para firma del cliente (Asistentes de Gerentes)";
		else if ($idStatusContratacion == 11 && $idMovimiento == 41 && $status8Flag == 1)
			$procesoContratacion = "9. Contrato recibido con firma de cliente (Contraloría)";
		else if ($idStatusContratacion == 12 && $idMovimiento == 42)
			$procesoContratacion = "13. Contrato listo y entregado asesores (Contraloría)";
		else if ($idStatusContratacion == 13 && $idMovimiento == 43)
			$procesoContratacion = "14. Firma Acuse cliente (Asistentes Gerentes)";
		else if ($idStatusContratacion == 14 && in_array($idMovimiento, array(44, 69)))
			$procesoContratacion = "15. Acuse entregado (Contraloría)";
		else if ($idStatusContratacion == 15)
			$procesoContratacion = "LOTE CONTRATADO";
		else if ($idStatusContratacion == 7 && in_array($idMovimiento, array(64, 66)))
			$procesoContratacion = "8. Contrato entregado al asesor para firma del cliente (Asistentes de Gerentes)";
		else if ($idStatusContratacion == 1 && $idMovimiento == 73)
			$procesoContratacion = "2. Integración de Expediente (Contraloría)";
		else if ($idStatusContratacion == 8 && $idMovimiento == 67)
			$procesoContratacion = "11. Validación de enganche (Administración)";
		else if ($idStatusContratacion == 13 && $idMovimiento == 68)
			$procesoContratacion = "14. Firma Acuse cliente (Asistentes Gerentes)";
		else
			$procesoContratacion = "Sin especificar";
		return $procesoContratacion;
	}
	public function getStatusContratacion($idStatusContratacion, $idMovimiento, $firmaRL, $validacionEnganche, $perfil)
	{
		if ($idStatusContratacion == 1 && $idMovimiento == 31)
			$status = "Estatus 1 listo (Caja)";
		else if ($idStatusContratacion == 1 && $idMovimiento == 18)
			$status = "Estatus 2 Rechazado (Jurídico)";
		else if ($idStatusContratacion == 1 && $idMovimiento == 19)
			$status = "Estatus 2 Rechazado (Postventa)";
		else if ($idStatusContratacion == 1 && $idMovimiento == 20)
			$status = "Estatus 2 Rechazado (Contraloría)";
		else if ($idStatusContratacion == 2 && $idMovimiento == 32)
			$status = "Estatus 2 listo (Asistentes Gerentes)";
		else if ($idStatusContratacion == 2 && $idMovimiento == 2)
			$status = "Estatus 2 enviado a Revisión (Asistentes Gerentes)";
		else if ($idStatusContratacion == 3 && $idMovimiento == 33)
			$status = "Estatus 3 listo (Jurídico)";
		else if ($idStatusContratacion == 2 && $idMovimiento == 3)
			$status = "Estatus 2 enviado a Revisión (Asistentes Gerentes) a Postventa";
		else if ($idStatusContratacion == 4 && $idMovimiento == 34)
			$status = "Estatus 4 listo (Postventa)";
		else if ($idStatusContratacion == 2 && in_array($idMovimiento, array(4, 62)))
			$status = "Estatus 2 enviado a Revisión (Elite)";
		else if ($idStatusContratacion == 5 && $idMovimiento == 35)
			$status = "Estatus 5 listo (Contraloría)";
		else if ($idStatusContratacion == 5 && $idMovimiento == 75)
			$status = "Estatus 5 enviado a Revisión (Contraloría)";
		else if ($idStatusContratacion == 5 && $idMovimiento == 22)
			$status = "Estatus 6 Rechazado (Juridico)";
		else if ($idStatusContratacion == 6 && $idMovimiento == 36)
			$status = "Estatus 6 listo (Contraloría)";
		else if ($idStatusContratacion == 6 && in_array($idMovimiento, array(6, 76)))
			$status = "Estatus 6 enviado a Revisión (Contraloría) a Juridico";
		else if ($idStatusContratacion == 6 && $idMovimiento == 23)
			$status = "Estatus 7 Enviado a Modificación (Asistentes Gerentes)";
		else if ($idStatusContratacion == 7 && $idMovimiento == 37)
			$status = "Estatus 7 listo (Jurídico)";
		else if ($idStatusContratacion == 7 && in_array($idMovimiento, array(7, 77)))
			$status = "Contrato con modificaciones entregado";
		else if ($idStatusContratacion == 8 && $idMovimiento == 38)
			$status = "Estatus 8 listo (Asistentes de Gerentes)";
		else if ($idStatusContratacion == 9 && $idMovimiento == 39)
			$status = "Estatus 9 listo (Asistentes de Gerentes)";
		else if ($idStatusContratacion == 9 && $idMovimiento == 26)
			$status = "Rechazo estatus 10 (Administración)";
		else if ($idStatusContratacion == 10 && $idMovimiento == 40)
			$status = "Estatus 10 listo (Contraloría)";
		else if ($idStatusContratacion == 10 && $idMovimiento == 10)
			$status = "Estatus 10 enviado a Revisión (Contraloría)";
		else if ($idStatusContratacion == 11 && $idMovimiento == 41 && $validacionEnganche == "VALIDADO")
			$status = "Estatus 11 (Administración)";
		else if ($idStatusContratacion == 13 && $idMovimiento == 43)
			$status = "Estatus 13 listo (Contraloría)";
		else if ($idStatusContratacion == 14 && $idMovimiento == 44)
			$status = "Estatus 14 listo (Asistentes Gerentes)";
		else if ($idStatusContratacion == 15 && $idMovimiento == 45)
			$status = "Lote Contratado";
		else if ($idStatusContratacion == 7 && $idMovimiento == 64)
			$status = "Estatus 8 Rechazado (Por Contraloría)";
		else if ($idStatusContratacion == 1 && $idMovimiento == 63)
			$status = "Estatus 2 Rechazado (Por Contraloría)";
		else if ($idStatusContratacion == 1 && $idMovimiento == 73)
			$status = "Estatus 2 Rechazado (Asistentes Gerentes)";
		else if ($idStatusContratacion == 7 && $idMovimiento == 66)
			$status = "Estatus 8 Rechazado (Administración)";
		else if ($idStatusContratacion == 8 && $idMovimiento == 67)
			$status = "Estatus 8 enviado a revisión (Asistentes Gerentes)";
		else if ($idStatusContratacion == 13 && $idMovimiento == 68)
			$status = "Estatus 14 Rechazado (Contraloría)";
		else if ($idStatusContratacion == 2 && $idMovimiento == 84)
			$status = "Listo contraloria 2.0 (Recepción de expediente )";
		else if ($idStatusContratacion == 2 && $idMovimiento == 85)
			$status = "Rechazo Contraloria 2 a 2.0";
		else if ($idStatusContratacion == 3 && $idMovimiento == 82)
			$status = "Regreso a ventas 3 de (Status 7 jurídico)";
		else if ($idStatusContratacion == 7 && $idMovimiento == 83)
			$status = "Revisión de ventas 3 a (Status 7 jurídico)";
		else
			$status = "Sin especificar";
		return $status;
	}
	public function getFechaVencimiento($idStatusContratacion, $idMovimiento, $fechaVenc, $fechaSolicitudValidacion, $fechaEstatus7, $validacionEnganche, $status8Flag, $fechaUltimoEstatus, $fechaEstatus8)
	{
		$fechaVencimiento = "";
		$fechaVencimiento2 = "";
		if (in_array($idStatusContratacion, array(9, 6, 5, 1, 7, 13, 2)) && in_array($idMovimiento, array(26, 23, 22, 18, 19, 20, 75, 76, 73, 66, 16, 85)))
			$fechaVencimiento = "Vencido";
		else if (in_array($idStatusContratacion, array(1, 2, 6, 7, 8, 10, 3, 4, 5, 9, 13, 14)) && in_array($idMovimiento, array(31, 32, 2, 33, 3, 34, 4, 35, 36, 6, 39, 10, 43, 44, 84, 83, 82)))
			$fechaVencimiento = date("d-m-Y", strtotime($fechaVenc));
		else if (in_array($idStatusContratacion, array(7, 8)) && in_array($idMovimiento, array(7, 37, 64, 77, 65, 38, 67, 66))) {
			$admon = 1;
			$asige = 1;
			if ($admon == 1) {
				$fecha = $idMovimiento == 67 ? $fechaEstatus8 : $fechaEstatus7;
				$arregloFechas = array();
				$p = 0;
				while ($p < 1) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$arregloFechas[$p] = $sig_fecha;
						$p++;
					}
					$fecha = $sig_fecha;
				}
				$d = end($arregloFechas);
				$fechaVencimientoAdmon = date("d-m-Y", strtotime($d));
			}
			if ($asige == 1) {
				$fecha = $fechaEstatus7;
				$arregloFechas = array();
				$p = 0;
				while ($p <= 14) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$arregloFechas[$p] = $sig_fecha;
						$p++;
					}
					$fecha = $sig_fecha;
				}
				$d = end($arregloFechas);
				$fechaVencimientoAsige = date("d-m-Y", strtotime($d));
			}
			$fechaVencimiento = $fechaVencimientoAsige;
			$fechaVencimiento2 = $fechaVencimientoAdmon;
		} else if ($idStatusContratacion == 11 and $idMovimiento == 41) {
			$fecha = $fechaEstatus7;
			$arregloFechas = array();
			$p = 0;
			while ($p <= 14) {
				$hoy_strtotime = strtotime($fecha);
				$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
				$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
				$sig_fecha_dia = date('D', $sig_strtotime);
				$sig_fecha_feriado = date('d-m', $sig_strtotime);
				if (
					$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
					$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
					$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
					$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" ||
					$sig_fecha_feriado == "25-12"
				) {
				} else {
					$arregloFechas[$p] = $sig_fecha;
					$p++;
				}
				$fecha = $sig_fecha;
			}
			$d = end($arregloFechas);
			$fechaVencimiento = date("d-m-Y", strtotime($d));
		} else if (in_array($idStatusContratacion, array(10, 12)) && in_array($idMovimiento, array(40, 42))) {
			date_default_timezone_set('America/Mexico_City');
			$horaInicio = date("08:00:00");
			$horaFin = date("16:00:00");
			$arregloFechas = array();
			$fechaAccion = $fechaSolicitudValidacion;
			$hoy_strtotime2 = strtotime($fechaAccion);
			$sig_fecha_dia2 = date('D', $hoy_strtotime2);
			$sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
			$time = date('H:i:s', $hoy_strtotime2);
			if ($time > $horaInicio and $time < $horaFin) {
				if (
					$sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
					$sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
					$sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
					$sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
					$sig_fecha_feriado2 == "25-12"
				) {
					$fecha = $fechaAccion;
					$x = 0;
					while ($x <= 1) {
						$hoy_strtotime = strtotime($fecha);
						$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
						$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
						$sig_fecha_dia = date('D', $sig_strtotime);
						$sig_fecha_feriado = date('d-m', $sig_strtotime);
						if (
							$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
							$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
							$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
							$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
							$sig_fecha_feriado == "25-12"
						) {
						} else {
							$arregloFechas[$x] = $sig_fecha;
							$x++;
						}
						$fecha = $sig_fecha;
					}
					$dato = end($arregloFechas);
					$fechaVencimiento = date("d-m-Y", strtotime($dato));
				} else {
					$fecha = $fechaAccion;
					$x = 0;
					while ($x <= 0) {
						$hoy_strtotime = strtotime($fecha);
						$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
						$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
						$sig_fecha_dia = date('D', $sig_strtotime);
						$sig_fecha_feriado = date('d-m', $sig_strtotime);
						if (
							$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
							$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
							$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
							$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
							$sig_fecha_feriado == "25-12"
						) {
						} else {
							$arregloFechas[$x] = $sig_fecha;
							$x++;
						}
						$fecha = $sig_fecha;
					}
					$dato = end($arregloFechas);
					$fechaVencimiento = date("d-m-Y", strtotime($dato));
				}
			} elseif ($time < $horaInicio || $time > $horaFin) {
				if (
					$sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
					$sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
					$sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
					$sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
					$sig_fecha_feriado2 == "25-12"
				) {
					$fecha = $fechaAccion;
					$x = 0;
					while ($x <= 1) {
						$hoy_strtotime = strtotime($fecha);
						$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
						$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
						$sig_fecha_dia = date('D', $sig_strtotime);
						$sig_fecha_feriado = date('d-m', $sig_strtotime);
						if (
							$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
							$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
							$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
							$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
							$sig_fecha_feriado == "25-12"
						) {
						} else {
							$arregloFechas[$x] = $sig_fecha;
							$x++;
						}
						$fecha = $sig_fecha;
					}
					$dato = end($arregloFechas);
					$fechaVencimiento = date("d-m-Y", strtotime($dato));
				} else {
					$fecha = $fechaAccion;
					$x = 0;
					while ($x <= 1) {
						$hoy_strtotime = strtotime($fecha);
						$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
						$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
						$sig_fecha_dia = date('D', $sig_strtotime);
						$sig_fecha_feriado = date('d-m', $sig_strtotime);
						if (
							$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
							$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
							$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
							$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
							$sig_fecha_feriado == "25-12"
						) {
						} else {
							$arregloFechas[$x] = $sig_fecha;
							$x++;
						}
						$fecha = $sig_fecha;
					}
					$dato = end($arregloFechas);
					$fechaVencimiento = date("d-m-Y", strtotime($dato));
				}
			}
		}
		return [$fechaVencimiento, $fechaVencimiento2];
	}
	public function getDiasRestantes($idStatusContratacion, $idMovimiento, $fechaVenc, $fechaSolicitudValidacion, $validacionEnganche, $status8Flag, $fechaVenc2, $fechaVencimiento)
	{
		$arregloFechas = array();
		$diasRest = 0;
		$diasRest2 = 0;
		if (in_array($idStatusContratacion, array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 13, 14)) && in_array($idMovimiento, array(31, 32, 2, 33, 3, 34, 4, 35, 36, 6, 39, 10, 43, 44, 82, 83, 84))) {
			$fechaHoy = date('Y-m-d');
			$fechaDes = $fechaVenc;
			$arregloFechas = array();
			$a = 0;
			while ($fechaHoy <= $fechaDes) {
				$hoy_strtotime = strtotime($fechaHoy);
				$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
				$sig_fecha = date("Y-m-d", $sig_strtotime);
				$excluir_dia = date('D', $sig_strtotime);
				$excluir_feriado = date('d-m', $sig_strtotime);
				if (
					$excluir_dia == "Sat" || $excluir_dia == "Sun" || $excluir_feriado == "01-01" || $excluir_feriado == "06-02" ||
					$excluir_feriado == "20-03" || $excluir_feriado == "01-05" ||
					$excluir_feriado == "16-09" || $excluir_feriado == "20-11" ||
					$excluir_feriado == "25-12"
				) {
				} else {
					$arregloFechas[$a] = $sig_fecha;
					$a++;
				}
				$fechaHoy = $sig_fecha;
			}
			$diasRest = count($arregloFechas);
		} else if (in_array($idStatusContratacion, array(7, 8)) && in_array($idMovimiento, array(7, 37, 64, 77, 65, 38, 67, 66))) {
			$admon = 1;
			$asige = 1;
			if ($admon == 1) {
				$fechaHoy = date('Y-m-d');
				$fechaDes = date("Y-m-d", strtotime($fechaVenc2));
				$arregloFechas = array();
				$a = 0;
				while ($fechaHoy < $fechaDes) {
					$hoy_strtotime = strtotime($fechaHoy);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d", $sig_strtotime);
					$excluir_dia = date('D', $sig_strtotime);
					$excluir_feriado = date('d-m', $sig_strtotime);
					if (
						$excluir_dia == "Sat" || $excluir_dia == "Sun" || $excluir_feriado == "01-01" || $excluir_feriado == "06-02" ||
						$excluir_feriado == "20-03" || $excluir_feriado == "01-05" ||
						$excluir_feriado == "16-09" || $excluir_feriado == "20-11" ||
						$excluir_feriado == "25-12"
					) {
					} else {
						$arregloFechas[$a] = $sig_fecha;
						$a++;
					}
					$fechaHoy = $sig_fecha;
				}
				$diasRestAdmon = count($arregloFechas);
			}
			if ($asige == 1) {
				$fechaHoy = date('Y-m-d');
				$fechaDes = date("Y-m-d", strtotime($fechaVenc));
				$arregloFechas = array();
				$a = 0;
				while ($fechaHoy < $fechaDes) {
					$hoy_strtotime = strtotime($fechaHoy);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d", $sig_strtotime);
					$excluir_dia = date('D', $sig_strtotime);
					$excluir_feriado = date('d-m', $sig_strtotime);
					if (
						$excluir_dia == "Sat" || $excluir_dia == "Sun" || $excluir_feriado == "01-01" || $excluir_feriado == "06-02" ||
						$excluir_feriado == "20-03" || $excluir_feriado == "01-05" ||
						$excluir_feriado == "16-09" || $excluir_feriado == "20-11" ||
						$excluir_feriado == "25-12"
					) {
					} else {
						$arregloFechas[$a] = $sig_fecha;
						$a++;
					}
					$fechaHoy = $sig_fecha;
				}
				$diasRestAsige = count($arregloFechas);
			}
			$diasRest = $diasRestAsige;
			$diasRest2 = $diasRestAdmon;
		} else if ($idStatusContratacion == 11 and $idMovimiento == 41) {
			$fecha = $fechaVencimiento;
			$arregloFechasA = array();
			$u = 0;
			while ($u <= 14) {
				$hoy_strtotime = strtotime($fecha);
				$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
				$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
				$sig_fecha_dia = date('D', $sig_strtotime);
				$sig_fecha_feriado = date('d-m', $sig_strtotime);
				if (
					$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
					$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
					$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
					$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" ||
					$sig_fecha_feriado == "25-12"
				) {
				} else {
					$arregloFechasA[$u] = $sig_fecha;
					$u++;
				}
				$fecha = $sig_fecha;
			}
			$d = end($arregloFechasA);
			$finDate = date("Y-m-d", strtotime($d));
			$fechaHoy = date('Y-m-d');
			$fechaDes = $finDate;
			$arregloFechas = array();
			$a = 0;
			while ($fechaHoy <= $fechaDes) {
				$hoy_strtotime = strtotime($fechaHoy);
				$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
				$sig_fecha = date("Y-m-d", $sig_strtotime);
				$excluir_dia = date('D', $sig_strtotime);
				$excluir_feriado = date('d-m', $sig_strtotime);
				if (
					$excluir_dia == "Sat" || $excluir_dia == "Sun" || $excluir_feriado == "01-01" || $excluir_feriado == "06-02" ||
					$excluir_feriado == "20-03" || $excluir_feriado == "01-05" ||
					$excluir_feriado == "16-09" || $excluir_feriado == "20-11" ||
					$excluir_feriado == "25-12"
				) {
				} else {
					$arregloFechas[$a] = $sig_fecha;
					$a++;
				}
				$fechaHoy = $sig_fecha;
			}
			$diasRest = count($arregloFechas);
		} else if (in_array($idStatusContratacion, array(10, 12)) && in_array($idMovimiento, array(40, 42))) {
			$fechaHoy = date('Y-m-d');
			$fechaDes = $fechaSolicitudValidacion;
			$arregloFechas = array();
			$a = 0;
			while ($fechaHoy <= $fechaDes) {
				$hoy_strtotime = strtotime($fechaHoy);
				$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
				$sig_fecha = date("Y-m-d", $sig_strtotime);
				$excluir_dia = date('D', $sig_strtotime);
				$excluir_feriado = date('d-m', $sig_strtotime);
				if (
					$excluir_dia == "Sat" || $excluir_dia == "Sun" || $excluir_feriado == "01-01" || $excluir_feriado == "06-02" ||
					$excluir_feriado == "20-03" || $excluir_feriado == "01-05" ||
					$excluir_feriado == "16-09" || $excluir_feriado == "20-11" ||
					$excluir_feriado == "25-12"
				) {
				} else {
					$arregloFechas[$a] = $sig_fecha;
					$a++;
				}
				$fechaHoy = $sig_fecha;
			}
			$diasRest = count($arregloFechas);
		}
		return [$diasRest, $arregloFechas, $diasRest2];
	}
	public function getDiasVencidos($idStatusContratacion, $idMovimiento, $fechaVenc, $fechaSolicitudValidacion, $validacionEnganche, $status8Flag, $fechaVenc2, $fechaVencimiento)
	{
		$arregloFechas2 = array();
		$diasVenc = 0;
		$diasVenc2 = 0;
		if (in_array($idStatusContratacion, array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 13, 14)) && in_array($idMovimiento, array(31, 32, 2, 33, 3, 34, 4, 35, 36, 6, 37, 7, 39, 10, 43, 44, 82, 83, 84))) {
			$fechaHoy = $fechaVenc;
			$fechaDes = date('Y-m-d');
			$arregloFechas2 = array();
			$a = 0;
			while ($fechaHoy <= $fechaDes) {
				$hoy_strtotime = strtotime($fechaHoy);
				$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
				$sig_fecha = date("Y-m-d", $sig_strtotime);
				$excluir_dia = date('D', $sig_strtotime);
				$excluir_feriado = date('d-m', $sig_strtotime);
				if (
					$excluir_dia == "Sat" || $excluir_dia == "Sun" || $excluir_feriado == "01-01" || $excluir_feriado == "06-02" ||
					$excluir_feriado == "20-03" || $excluir_feriado == "01-05" ||
					$excluir_feriado == "16-09" || $excluir_feriado == "20-11" ||
					$excluir_feriado == "25-12"
				) {
				} else {
					$arregloFechas2[$a] = $sig_fecha;
					$a++;
				}
				$fechaHoy = $sig_fecha;
			}
			$diasVenc = count($arregloFechas2);
		} else if (in_array($idStatusContratacion, array(7, 8)) && in_array($idMovimiento, array(7, 37, 64, 77, 65, 38, 67))) {
			$admon = 1;
			$asige = 1;
			if ($admon == 1) {
				$fechaHoy = $fechaVenc2;
				$fechaDes = date('Y-m-d');
				$arregloFechas2 = array();
				$a = 0;
				while (date("Y-m-d", strtotime($fechaHoy)) <= $fechaDes) {
					$hoy_strtotime = strtotime($fechaHoy);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d", $sig_strtotime);
					$excluir_dia = date('D', $sig_strtotime);
					$excluir_feriado = date('d-m', $sig_strtotime);
					if (
						$excluir_dia == "Sat" || $excluir_dia == "Sun" || $excluir_feriado == "01-01" || $excluir_feriado == "06-02" ||
						$excluir_feriado == "20-03" || $excluir_feriado == "01-05" ||
						$excluir_feriado == "16-09" || $excluir_feriado == "20-11" ||
						$excluir_feriado == "25-12"
					) {
					} else {
						$arregloFechas2[$a] = $sig_fecha;
						$a++;
					}
					$fechaHoy = $sig_fecha;
				}
				$diasVencAdmon = count($arregloFechas2);
			}
			if ($asige == 1) {
				$fechaHoy = $fechaVencimiento;
				$fechaDes = date('Y-m-d');
				$arregloFechas2 = array();
				$a = 0;
				while (date("Y-m-d", strtotime($fechaHoy)) <= $fechaDes) {
					$hoy_strtotime = strtotime($fechaHoy);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d", $sig_strtotime);
					$excluir_dia = date('D', $sig_strtotime);
					$excluir_feriado = date('d-m', $sig_strtotime);
					if (
						$excluir_dia == "Sat" || $excluir_dia == "Sun" || $excluir_feriado == "01-01" || $excluir_feriado == "06-02" ||
						$excluir_feriado == "20-03" || $excluir_feriado == "01-05" ||
						$excluir_feriado == "16-09" || $excluir_feriado == "20-11" ||
						$excluir_feriado == "25-12"
					) {
					} else {
						$arregloFechas2[$a] = $sig_fecha;
						$a++;
					}
					$fechaHoy = $sig_fecha;
				}
				$diasVencAsigue = count($arregloFechas2);
			}
			$diasVenc = $diasVencAsigue;
			$diasVenc2 = $diasVencAdmon;
		} else if ($idStatusContratacion == 11 and $idMovimiento == 41) {
			$fecha = $fechaVencimiento;
			$arregloFechasA = array();
			$t = 0;
			$days = ($validacionEnganche == '' && $status8Flag == 1) ? 14 : 0;
			while ($t <= $days) {
				$hoy_strtotime = strtotime($fecha);
				$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
				$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
				$sig_fecha_dia = date('D', $sig_strtotime);
				$sig_fecha_feriado = date('d-m', $sig_strtotime);
				if (
					$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
					$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
					$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
					$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" ||
					$sig_fecha_feriado == "25-12"
				) {
				} else {
					$arregloFechasA[$t] = $sig_fecha;
					$t++;
				}
				$fecha = $sig_fecha;
			}
			$d = end($arregloFechasA);
			$finDate = date("Y-m-d", strtotime($d));
			$fechaHoy = $finDate;
			$fechaDes = date('Y-m-d');
			$arregloFechas2 = array();
			$a = 0;
			while ($fechaHoy <= $fechaDes) {
				$hoy_strtotime = strtotime($fechaHoy);
				$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
				$sig_fecha = date("Y-m-d", $sig_strtotime);
				$excluir_dia = date('D', $sig_strtotime);
				$excluir_feriado = date('d-m', $sig_strtotime);
				if (
					$excluir_dia == "Sat" || $excluir_dia == "Sun" || $excluir_feriado == "01-01" || $excluir_feriado == "06-02" ||
					$excluir_feriado == "20-03" || $excluir_feriado == "01-05" ||
					$excluir_feriado == "16-09" || $excluir_feriado == "20-11" ||
					$excluir_feriado == "25-12"
				) {
				} else {
					$arregloFechas2[$a] = $sig_fecha;
					$a++;
				}
				$fechaHoy = $sig_fecha;
			}
			$diasVenc = count($arregloFechas2);
		} else if (in_array($idStatusContratacion, array(10, 12)) && in_array($idMovimiento, array(40, 42))) {
			$fechaHoy = $fechaSolicitudValidacion;
			$fechaDes = date('Y-m-d');
			$arregloFechas2 = array();
			$a = 0;
			while ($fechaHoy <= $fechaDes) {
				$hoy_strtotime = strtotime($fechaHoy);
				$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
				$sig_fecha = date("Y-m-d", $sig_strtotime);
				$excluir_dia = date('D', $sig_strtotime);
				$excluir_feriado = date('d-m', $sig_strtotime);
				if (
					$excluir_dia == "Sat" || $excluir_dia == "Sun" || $excluir_feriado == "01-01" || $excluir_feriado == "06-02" ||
					$excluir_feriado == "20-03" || $excluir_feriado == "01-05" ||
					$excluir_feriado == "16-09" || $excluir_feriado == "20-11" ||
					$excluir_feriado == "25-12"
				) {
				} else {
					$arregloFechas2[$a] = $sig_fecha;
					$a++;
				}
				$fechaHoy = $sig_fecha;
			}
			$diasVenc = count($arregloFechas2);
		}
		return [$diasVenc, $arregloFechas2, $diasVenc2];
	}
	public function getStatusFecha($idStatusContratacion, $idMovimiento, $arregloFechas, $arregloFechas2)
	{
		if (count($arregloFechas2) > 0 and count($arregloFechas) == 0 and $idStatusContratacion != 15 and $idMovimiento != 45)
			$statusFecha = "Vencido";
		else if (count($arregloFechas) > 0 and count($arregloFechas2) == 0 and $idStatusContratacion != 15 and $idMovimiento != 45)
			$statusFecha = "En Tiempo";
		else if ($idStatusContratacion == 15 and $idMovimiento == 45)
			$statusFecha = "Contratado";
		else
			$statusFecha = "Sin especificar";
		return $statusFecha;
	}
	public function historial_liberacion()
	{
		$idLote = $this->input->post("idLote");
		$datos = $this->registrolote_modelo->historialLiberacion($idLote);
		if ($datos != null) {
			echo json_encode($datos);
		} else {
			echo json_encode(array());
		}
	}
	public function listado($idLote)
	{
		$datos["listado"] = $this->registrolote_modelo->getLista($idLote);
		$this->load->view("datos_lote_lista_view", $datos);
	}
	public function historialProcesoLote()
	{
		$dataPer = array();
		$idLote = $this->input->post("idLote");
		$data = $this->registrolote_modelo->historialProceso($idLote);
		for ($i = 0; $i < count($data); $i++) {
			$dataPer[$i]['idHistorialLote'] = ($data[$i]->idHistorialLote != "") ? $data[$i]->idHistorialLote : "";
			$dataPer[$i]['nombreLote'] = ($data[$i]->nombreLote != "") ? $data[$i]->nombreLote : "";
			$dataPer[$i]['idStatusContratacion'] = ($data[$i]->idStatusContratacion != "") ? $data[$i]->idStatusContratacion : "";
			$dataPer[$i]['idMovimiento'] = ($data[$i]->idMovimiento != "") ? $data[$i]->idMovimiento : "";
			$dataPer[$i]['modificado'] = ($data[$i]->modificado != "") ? $data[$i]->modificado : "";
			$dataPer[$i]['fechaVenc'] = ($data[$i]->fechaVenc != "") ? $data[$i]->fechaVenc : "";
			$dataPer[$i]['idLote'] = ($data[$i]->idLote != "") ? $data[$i]->idLote : "";
			$dataPer[$i]['idCondominio'] = ($data[$i]->idCondominio != "") ? $data[$i]->idCondominio : "";
			$dataPer[$i]['idCliente'] = ($data[$i]->idCliente != "") ? $data[$i]->idCliente : "";
			$dataPer[$i]['user'] = ($data[$i]->user != "") ? $data[$i]->user : "";
			$dataPer[$i]['comentario'] = ($data[$i]->comentario != "") ? $data[$i]->comentario : "";
			$dataPer[$i]['perfil'] = ($data[$i]->perfil != "") ? $data[$i]->perfil : "";
			$dataPer[$i]['status'] = ($data[$i]->status != "") ? $data[$i]->status : "";
			$dataPer[$i]['folioContrato'] = ($data[$i]->folioContrato != "") ? $data[$i]->folioContrato : "";
			if ($dataPer[$i]['idStatusContratacion'] == 1 && $dataPer[$i]['idMovimiento'] == 31) {
				$dataPer[$i]['nombreStatus'] = "1. Lote Apartado (Caja) ";
			}
			if ($dataPer[$i]['idStatusContratacion'] == 1 && $dataPer[$i]['idMovimiento'] == 20) {
				$dataPer[$i]['nombreStatus'] = "Status 2 Rechazado (Contraloría)  ";
			}
			if ($dataPer[$i]['idStatusContratacion'] == 2) {
				$dataPer[$i]['nombreStatus'] = "2. Integración de Expediente (Asistentes de Gerentes)    ";
			}
			if ($dataPer[$i]['idStatusContratacion'] == 3) {
				$dataPer[$i]['nombreStatus'] = "3. Revisión Jurídico (Jurídico)   ";
			}
			if ($dataPer[$i]['idStatusContratacion'] == 4) {
				$dataPer[$i]['nombreStatus'] = "4. Datos Verificados (Postventa) ";
			}
			if ($dataPer[$i]['idStatusContratacion'] == 5) {
				$dataPer[$i]['nombreStatus'] = "5. Revisión 100% (Contraloria)     ";
			}
			if ($dataPer[$i]['idStatusContratacion'] == 6) {
				$dataPer[$i]['nombreStatus'] = "6. Corrida elaborada (Contraloria)   ";
			}
			if ($dataPer[$i]['idStatusContratacion'] == 7 && $dataPer[$i]['idMovimiento'] != 64) {
				$dataPer[$i]['nombreStatus'] = "7. Contrato elaborado (Jurídico)    ";
			}
			if ($dataPer[$i]['idStatusContratacion'] == 8) {
				$dataPer[$i]['nombreStatus'] = "8. Contrato entregado al asesor para firma del cliente (Asistentes de Gerentes)";
			}
			if ($dataPer[$i]['idStatusContratacion'] == 9) {
				$dataPer[$i]['nombreStatus'] = "9. Contrato recibido con firma de cliente (Contraloría)";
			}
			if ($dataPer[$i]['idStatusContratacion'] == 10) {
				$dataPer[$i]['nombreStatus'] = "10. Solicitud de validación de enganche y envio de contrato a RL (Contraloria)";
			}
			if ($dataPer[$i]['idStatusContratacion'] == 11) {
				$dataPer[$i]['nombreStatus'] = "11. Validación de engache (Administracion)";
			}
			if ($dataPer[$i]['idStatusContratacion'] == 12) {
				$dataPer[$i]['nombreStatus'] = "12. Contrato firmado (Representante Legal) ";
			}
			if ($dataPer[$i]['idStatusContratacion'] == 13) {
				$dataPer[$i]['nombreStatus'] = "13. Contrato listo y entregado a asesores (Contraloria) ";
			}
			if ($dataPer[$i]['idStatusContratacion'] == 14) {
				$dataPer[$i]['nombreStatus'] = "14. Firma Acuse cliente (Asistentes Gerentes)";
			}
			if ($dataPer[$i]['idStatusContratacion'] == 15) {
				$dataPer[$i]['nombreStatus'] = "15. Acuse entregado (Contraloria) ";
			}
			if ($dataPer[$i]['idStatusContratacion'] == 7 && $dataPer[$i]['idMovimiento'] == 64) {
				$dataPer[$i]['nombreStatus'] = "8. Contrato entregado al asesor para firma del cliente (Asistentes de Gerentes) ";
			}
			if ($dataPer[$i]['idStatusContratacion'] == 1 && $dataPer[$i]['idMovimiento'] == 31) {
				$dataPer[$i]['detalles'] = "Status 1 listo (Caja)";
			}
			if ($dataPer[$i]['idStatusContratacion'] == 1 && $dataPer[$i]['idMovimiento'] == 18) {
				$dataPer[$i]['detalles'] = "Status 2 Rechazado (Jurídico)";
			}
			if ($dataPer[$i]['idStatusContratacion'] == 1 && $dataPer[$i]['idMovimiento'] == 19) {
				$dataPer[$i]['detalles'] = "Status 2 Rechazado (Postventa)";
			}
			if ($dataPer[$i]['idStatusContratacion'] == 1 && $dataPer[$i]['idMovimiento'] == 20) {
				$dataPer[$i]['detalles'] = "Status 2 Rechazado (Contraloría)";
			}
			if ($dataPer[$i]['idStatusContratacion'] == 2 && $dataPer[$i]['idMovimiento'] == 32) {
				$dataPer[$i]['detalles'] = "Status 2 listo (Asistentes Gerentes)";
			}
			if ($dataPer[$i]['idStatusContratacion'] == 2 && $dataPer[$i]['idMovimiento'] == 2) {
				$dataPer[$i]['detalles'] = "Status 2 enviado a Revisión (Asistentes Gerentes)";
			}
			if ($dataPer[$i]['idStatusContratacion'] == 3 && $dataPer[$i]['idMovimiento'] == 33) {
				$dataPer[$i]['detalles'] = "Status 3 listo (Jurídico) ";
			}
			if ($dataPer[$i]['idStatusContratacion'] == 2 && $dataPer[$i]['idMovimiento'] == 3) {
				$dataPer[$i]['detalles'] = "Status 2 enviado a Revisión (Asistentes Gerentes)";
			}
			if ($dataPer[$i]['idStatusContratacion'] == 4 && $dataPer[$i]['idMovimiento'] == 34) {
				$dataPer[$i]['detalles'] = "Status 4 listo (Postventa)";
			}
			if ($dataPer[$i]['idStatusContratacion'] == 2 && $dataPer[$i]['idMovimiento'] == 4) {
				$dataPer[$i]['detalles'] = "Status 2 enviado a Revisión (Asistentes Gerentes)";
			}
			if ($dataPer[$i]['idStatusContratacion'] == 5 && $dataPer[$i]['idMovimiento'] == 35) {
				$dataPer[$i]['detalles'] = "Status 5 listo (Contraloría)";
			}
			if ($dataPer[$i]['idStatusContratacion'] == 5 && $dataPer[$i]['idMovimiento'] == 22) {
				$dataPer[$i]['detalles'] = "Status 6 Rechazado (Juridico) ";
			}
			if ($dataPer[$i]['idStatusContratacion'] == 6 && $dataPer[$i]['idMovimiento'] == 36) {
				$dataPer[$i]['detalles'] = "Status 6 listo (Contraloría) ";
			}
			if ($dataPer[$i]['idStatusContratacion'] == 6 && $dataPer[$i]['idMovimiento'] == 6) {
				$dataPer[$i]['detalles'] = "Status 6 enviado a Revisión (Contraloría)";
			}
			if ($dataPer[$i]['idStatusContratacion'] == 7 && $dataPer[$i]['idMovimiento'] == 37) {
				$dataPer[$i]['detalles'] = "Status 7 listo (Jurídico)";
			}
			if ($dataPer[$i]['idStatusContratacion'] == 8 && $dataPer[$i]['idMovimiento'] == 38) {
				$dataPer[$i]['detalles'] = "Status 8 listo (Asistentes de Gerentes)";
			}
			if ($dataPer[$i]['idStatusContratacion'] == 9 && $dataPer[$i]['idMovimiento'] == 39) {
				$dataPer[$i]['detalles'] = "Status 9 listo (Contraloría)";
			}
			if ($dataPer[$i]['idStatusContratacion'] == 9 && $dataPer[$i]['idMovimiento'] == 26) {
				$dataPer[$i]['detalles'] = "Rechazo Status 10 (Administración)";
			}
			if ($dataPer[$i]['idStatusContratacion'] == 10 && $dataPer[$i]['idMovimiento'] == 40) {
				$dataPer[$i]['detalles'] = "Status 10 listo (Contraloría)";
			}
			if ($dataPer[$i]['idStatusContratacion'] == 10 && $dataPer[$i]['idMovimiento'] == 10) {
				$dataPer[$i]['detalles'] = "Status 10 enviado a Revisión (Contraloría)";
			}
			if ($dataPer[$i]['idStatusContratacion'] == 11 && $dataPer[$i]['idMovimiento'] == 41) {
				$dataPer[$i]['detalles'] = "Status 10 listo (Administración)";
			}
			if ($dataPer[$i]['idStatusContratacion'] == 12 && $dataPer[$i]['idMovimiento'] == 42) {
				$dataPer[$i]['detalles'] = "Status 12 listo (Representante Legal)";
			}
			if ($dataPer[$i]['idStatusContratacion'] == 13 && $dataPer[$i]['idMovimiento'] == 43) {
				$dataPer[$i]['detalles'] = "Status 13 listo (Contraloría))";
			}
			if ($dataPer[$i]['idStatusContratacion'] == 14 && $dataPer[$i]['idMovimiento'] == 44) {
				$dataPer[$i]['detalles'] = "Status 14 listo (Asistentes Gerentes)   ";
			}
			if ($dataPer[$i]['idStatusContratacion'] == 15 && $dataPer[$i]['idMovimiento'] == 45) {
				$dataPer[$i]['detalles'] = "Lote Contratado";
			}
			if ($dataPer[$i]['idStatusContratacion'] == 7 && $dataPer[$i]['idMovimiento'] == 64) {
				$dataPer[$i]['detalles'] = "Rechazo Status 8 (Contraloría)";
			}
		}
		if ($dataPer != null) {
			echo json_encode($dataPer);
		} else {
			echo json_encode(array());
		}
	}
	public function listado2()
	{
		$datos = array();
		$datos["listado2"] = $this->registrolote_modelo->planeacion();
		$this->load->view("datos_lote_lista2_view", $datos);
	}
	public function historial_enganche($idEnganche)
	{
		$datos["listado"] = $this->registrolote_modelo->getLista($idLote);
		$this->load->view("datos_lote_lista_view", $datos);
	}
	//////////////////////////////////////INICIO REVICIONES//////////////////////////////////////////////////////////
	public function editarLoteRevisionAsistentesStatusContratacion2($idLote)
	{
		$datos = array();
		$datos["lotes"] = $this->registrolote_modelo->selectRegistroLoteCaja($idLote);
		$datos["asistentesStatus2"] = $this->registrolote_modelo->getAsistentesStatus2();
		$this->load->view('editar_loteRevision_asistentes_proceso2_view', $datos);
	}
	public function editar_registro_loteRevision_asistentes_proceceso2()
	{
		$idLote = $this->input->post('idLote');
		$idCondominio = $this->input->post('idCondominio');
		$nombreLote = $this->input->post('nombreLote');
		$idStatusContratacion = $this->input->post('idStatusContratacion');
		$idMovimiento = $this->input->post('idMovimiento');
		$idCliente = $this->input->post('idCliente');
		$comentario = $this->input->post('comentario');
		$user = $this->input->post('usuario');
		$perfil = $this->input->post('perfil');
		$modificado = date('Y-m-d H:i:s');
		$fechaVenc = $this->input->post('fechaVenc');
		$arreglo = array();
		$arreglo["idStatusContratacion"] = $idStatusContratacion;
		$arreglo["idMovimiento"] = 2;
		$arreglo["comentario"] = $comentario;
		$arreglo["usuario"] = $this->session->userdata('usuario');
		$arreglo["perfil"] = $this->session->userdata('perfil');
		$arreglo["modificado"] = date("Y-m-d H:i:s");
		$arreglo["fechaVenc"] = $modificado;
		$arreglo2 = array();
		$arreglo2["idStatusContratacion"] = $idStatusContratacion;
		$arreglo2["idMovimiento"] = 2;
		$arreglo2["nombreLote"] = $nombreLote;
		$arreglo2["comentario"] = $comentario;
		$arreglo2["usuario"] = $this->session->userdata('usuario');
		$arreglo2["perfil"] = $this->session->userdata('perfil');
		$arreglo2["modificado"] = date("Y-m-d H:i:s");
		$arreglo2["fechaVenc"] = $fechaVenc;
		$arreglo2["idLote"] = $idLote;
		$arreglo2["idCondominio"] = $idCondominio;
		$arreglo2["idCliente"] = $idCliente;
		if ($this->registrolote_modelo->editaRegistroLoteCaja($idLote, $arreglo)) {
			$this->registrolote_modelo->insertHistorialLotes($arreglo2);
			echo 1;
		} else {
			echo 0;
			die("ERROR");
		}
	}
	public function editarLoteRevisionAsistentesAPostventaStatusContratacion2($idLote)
	{
		$datos = array();
		$datos["lotes"] = $this->registrolote_modelo->selectRegistroLoteCaja($idLote);
		$datos["asistentesStatus2"] = $this->registrolote_modelo->getAsistentesStatus2();
		$this->load->view('editar_loteRevision_asistentesAPostventa_proceso2_view', $datos);
	}
	public function editar_registro_loteRevision_asistentesAPostventa_proceceso2()
	{
		$idLote = $this->input->post('idLote');
		$idCondominio = $this->input->post('idCondominio');
		$nombreLote = $this->input->post('nombreLote');
		$idStatusContratacion = $this->input->post('idStatusContratacion');
		$idMovimiento = $this->input->post('idMovimiento');
		$idCliente = $this->input->post('idCliente');
		$comentario = $this->input->post('comentario');
		$user = $this->input->post('user');
		$perfil = $this->input->post('perfil');
		$modificado = date('Y-m-d H:i:s');
		$fechaVenc = $this->input->post('fechaVenc');
		$arreglo = array();
		$arreglo["idStatusContratacion"] = $idStatusContratacion;
		$arreglo["idMovimiento"] = 3;
		$arreglo["comentario"] = $comentario;
		$arreglo["user"] = $this->session->userdata('username');
		$arreglo["perfil"] = $this->session->userdata('perfil');
		$arreglo["modificado"] = $modificado;
		date_default_timezone_set('America/Mexico_City');
		$horaActual = date('H:i:s');
		$horaInicio = date("08:00:00");
		$horaFin = date("16:00:00");
		if ($horaActual > $horaInicio and $horaActual < $horaFin) {
			$fechaAccion = date("Y-m-d H:i:s");
			$hoy_strtotime2 = strtotime($fechaAccion);
			$sig_fecha_dia2 = date('D', $hoy_strtotime2);
			$sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
			if (
				$sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
				$sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
				$sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
				$sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
				$sig_fecha_feriado2 == "25-12"
			) {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 1) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				for ($i = 0; $i < count($fecha); $i++) {
					$arreglo["fechaVenc"] = $fecha;
				}
			} else {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 0) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				for ($i = 0; $i < count($fecha); $i++) {
					$arreglo["fechaVenc"] = $fecha;
				}
			}
		} elseif ($horaActual < $horaInicio || $horaActual > $horaFin) {
			$fechaAccion = date("Y-m-d H:i:s");
			$hoy_strtotime2 = strtotime($fechaAccion);
			$sig_fecha_dia2 = date('D', $hoy_strtotime2);
			$sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
			if (
				$sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
				$sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
				$sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
				$sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
				$sig_fecha_feriado2 == "25-12"
			) {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 1) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				for ($i = 0; $i < count($fecha); $i++) {
					$arreglo["fechaVenc"] = $fecha;
				}
			} else {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 1) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				for ($i = 0; $i < count($fecha); $i++) {
					$arreglo["fechaVenc"] = $fecha;
				}
			}
		}
		$arreglo2 = array();
		$arreglo2["idStatusContratacion"] = $idStatusContratacion;
		$arreglo2["idMovimiento"] = 3;
		$arreglo2["nombreLote"] = $nombreLote;
		$arreglo2["comentario"] = $comentario;
		$arreglo2["user"] = $this->session->userdata('username');
		$arreglo2["perfil"] = $this->session->userdata('perfil');
		$arreglo2["modificado"] = date("Y-m-d H:i:s");
		$arreglo2["fechaVenc"] = $fechaVenc;
		$arreglo2["idLote"] = $idLote;
		$arreglo2["idCondominio"] = $idCondominio;
		$arreglo2["idCliente"] = $idCliente;
		if ($this->registrolote_modelo->editaRegistroLoteCaja($idLote, $arreglo)) {
			$this->registrolote_modelo->insertHistorialLotes($arreglo2);
			redirect(base_url() . "index.php/registroLote/registroStatusContratacionAsistentes2");
		} else {
			die("ERROR");
		}
	}
	public function editarLoteRevisionAsistentesAContraloriaStatusContratacion2($idLote)
	{
		$datos = array();
		$datos["lotes"] = $this->registrolote_modelo->selectRegistroLoteCaja($idLote);
		$datos["asistentesStatus2"] = $this->registrolote_modelo->getAsistentesStatus2();
		$this->load->view('editar_loteRevision_asistentesAContraloria_proceso2_view', $datos);
	}
	public function editar_registro_loteRevision_asistentesAContraloria_proceceso2()
	{
		$idLote = $this->input->post('idLote');
		$idCondominio = $this->input->post('idCondominio');
		$nombreLote = $this->input->post('nombreLote');
		$idStatusContratacion = $this->input->post('idStatusContratacion');
		$idMovimiento = $this->input->post('idMovimiento');
		$idCliente = $this->input->post('idCliente');
		$comentario = $this->input->post('comentario');
		$user = $this->input->post('usuario');
		$perfil = $this->input->post('perfil');
		$modificado = date('Y-m-d H:i:s');
		$fechaVenc = $this->input->post('fechaVenc');
		$arreglo = array();
		$arreglo["idStatusContratacion"] = $idStatusContratacion;
		$arreglo["idMovimiento"] = 4;
		$arreglo["comentario"] = $comentario;
		$arreglo["usuario"] = $this->session->userdata('usuario');
		$arreglo["perfil"] = $this->session->userdata('perfil');
		$arreglo["modificado"] = date("Y-m-d H:i:s");
		date_default_timezone_set('America/Mexico_City');
		$horaActual = date('H:i:s');
		$horaInicio = date("08:00:00");
		$horaFin = date("16:00:00");
		if ($horaActual > $horaInicio and $horaActual < $horaFin) {
			$fechaAccion = date("Y-m-d H:i:s");
			$hoy_strtotime2 = strtotime($fechaAccion);
			$sig_fecha_dia2 = date('D', $hoy_strtotime2);
			$sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
			if (
				$sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
				$sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
				$sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
				$sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
				$sig_fecha_feriado2 == "25-12"
			) {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 1) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				$arreglo["fechaVenc"] = $fecha;
			} else {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 0) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				$arreglo["fechaVenc"] = $fecha;
			}
		} elseif ($horaActual < $horaInicio || $horaActual > $horaFin) {
			$fechaAccion = date("Y-m-d H:i:s");
			$hoy_strtotime2 = strtotime($fechaAccion);
			$sig_fecha_dia2 = date('D', $hoy_strtotime2);
			$sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
			if (
				$sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
				$sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
				$sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
				$sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
				$sig_fecha_feriado2 == "25-12"
			) {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 1) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				$arreglo["fechaVenc"] = $fecha;
			} else {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 1) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				$arreglo["fechaVenc"] = $fecha;
			}
		}
		$arreglo2 = array();
		$arreglo2["idStatusContratacion"] = $idStatusContratacion;
		$arreglo2["idMovimiento"] = 4;
		$arreglo2["nombreLote"] = $nombreLote;
		$arreglo2["comentario"] = $comentario;
		$arreglo2["usuario"] = $this->session->userdata('usuario');
		$arreglo2["perfil"] = $this->session->userdata('perfil');
		$arreglo2["modificado"] = date("Y-m-d H:i:s");
		$arreglo2["fechaVenc"] = $fechaVenc;
		$arreglo2["idLote"] = $idLote;
		$arreglo2["idCondominio"] = $idCondominio;
		$arreglo2["idCliente"] = $idCliente;
		if ($this->registrolote_modelo->editaRegistroLoteCaja($idLote, $arreglo)) {
			$this->registrolote_modelo->insertHistorialLotes($arreglo2);
			echo 1;
		} else {
			echo 0;
			die("ERROR");
		}
	}
	public function editarLoteRevisionAsistentesAContraloria6StatusContratacion2($idLote)
	{
		$datos = array();
		$datos["lotes"] = $this->registrolote_modelo->selectRegistroLoteCaja($idLote);
		$datos["asistentesStatus2"] = $this->registrolote_modelo->getAsistentesStatus2();
		$this->load->view('editar_loteRevision_asistentesAContraloria6_proceso2_view', $datos);
	}
	public function editar_registro_loteRevision_asistentesAContraloria6_proceceso2()
	{
		$idLote = $this->input->post('idLote');
		$idCondominio = $this->input->post('idCondominio');
		$nombreLote = $this->input->post('nombreLote');
		$idStatusContratacion = $this->input->post('idStatusContratacion');
		$idMovimiento = $this->input->post('idMovimiento');
		$idCliente = $this->input->post('idCliente');
		$comentario = $this->input->post('comentario');
		$user = $this->input->post('user');
		$perfil = $this->input->post('perfil');
		$modificado = date("Y-m-d H:i:s");
		$fechaVenc = $this->input->post('fechaVenc');
		$arreglo = array();
		$arreglo["idStatusContratacion"] = $idStatusContratacion;
		$arreglo["idMovimiento"] = 62;
		$arreglo["comentario"] = $comentario;
		$arreglo["usuario"] = $this->session->userdata('usuario');
		$arreglo["perfil"] = $this->session->userdata('perfil');
		$arreglo["modificado"] = date("Y-m-d H:i:s");
		date_default_timezone_set('America/Mexico_City');
		$horaActual = date('H:i:s');
		$horaInicio = date("08:00:00");
		$horaFin = date("16:00:00");
		$arreglo2 = array();
		$arreglo2["idStatusContratacion"] = $idStatusContratacion;
		$arreglo2["idMovimiento"] = 62;
		$arreglo2["nombreLote"] = $nombreLote;
		$arreglo2["comentario"] = $comentario;
		$arreglo2["usuario"] = $this->session->userdata('usuario');
		$arreglo2["perfil"] = $this->session->userdata('perfil');
		$arreglo2["modificado"] = date("Y-m-d H:i:s");
		$arreglo2["fechaVenc"] = $fechaVenc;
		$arreglo2["idLote"] = $idLote;
		$arreglo2["idCondominio"] = $idCondominio;
		$arreglo2["idCliente"] = $idCliente;
		if ($this->registrolote_modelo->editaRegistroLoteCaja($idLote, $arreglo)) {
			$this->registrolote_modelo->insertHistorialLotes($arreglo2);
			echo 1;
		} else {
			echo 0;
			die("ERROR");
		}
	}
	public function editarLoteRevisionContraloriaStatusContratacion6($idLote)
	{
		$datos = array();
		$datos["lotes"] = $this->registrolote_modelo->selectRegistroLoteCaja($idLote);
		$datos["contraloriaStatus6"] = $this->registrolote_modelo->getContraloriaStatus6();
		$this->load->view('editar_loteRevision_contraloria_proceso6_view', $datos);
	}
	public function editar_registro_loteRevision_contraloria_proceceso6()
	{
		$idLote = $this->input->post('idLote');
		$idCondominio = $this->input->post('idCondominio');
		$nombreLote = $this->input->post('nombreLote');
		$idStatusContratacion = $this->input->post('idStatusContratacion');
		$idMovimiento = $this->input->post('idMovimiento');
		$idCliente = $this->input->post('idCliente');
		$comentario = $this->input->post('comentario');
		$user = $this->input->post('usuario');
		$perfil = $this->input->post('perfil');
		$modificado = date('Y-m-d H:i:s');
		$fechaVenc = $this->input->post('fechaVenc');
		$arreglo = array();
		$arreglo["idStatusContratacion"] = $idStatusContratacion;
		$arreglo["idMovimiento"] = 6;
		$arreglo["comentario"] = $comentario;
		$arreglo["usuario"] = $this->session->userdata('usuario');
		$arreglo["perfil"] = $this->session->userdata('perfil');
		$arreglo["modificado"] = date("Y-m-d H:i:s");
		date_default_timezone_set('America/Mexico_City');
		$horaActual = date('H:i:s');
		$horaInicio = date("08:00:00");
		$horaFin = date("16:00:00");
		if ($horaActual > $horaInicio and $horaActual < $horaFin) {
			$fechaAccion = date("Y-m-d H:i:s");
			$hoy_strtotime2 = strtotime($fechaAccion);
			$sig_fecha_dia2 = date('D', $hoy_strtotime2);
			$sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
			if (
				$sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
				$sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
				$sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
				$sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
				$sig_fecha_feriado2 == "25-12"
			) {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 1) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				$arreglo["fechaVenc"] = $fecha;
			} else {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 0) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				$arreglo["fechaVenc"] = $fecha;
			}
		} elseif ($horaActual < $horaInicio || $horaActual > $horaFin) {
			$fechaAccion = date("Y-m-d H:i:s");
			$hoy_strtotime2 = strtotime($fechaAccion);
			$sig_fecha_dia2 = date('D', $hoy_strtotime2);
			$sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
			if (
				$sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
				$sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
				$sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
				$sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
				$sig_fecha_feriado2 == "25-12"
			) {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 1) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				$arreglo["fechaVenc"] = $fecha;
			} else {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 1) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				$arreglo["fechaVenc"] = $fecha;
			}
		}
		$arreglo2 = array();
		$arreglo2["idStatusContratacion"] = $idStatusContratacion;
		$arreglo2["idMovimiento"] = 6;
		$arreglo2["nombreLote"] = $nombreLote;
		$arreglo2["comentario"] = $comentario;
		$arreglo2["usuario"] = $this->session->userdata('usuario');
		$arreglo2["perfil"] = $this->session->userdata('perfil');
		$arreglo2["modificado"] = date("Y-m-d H:i:s");
		$arreglo2["fechaVenc"] = $fechaVenc;
		$arreglo2["idLote"] = $idLote;
		$arreglo2["idCondominio"] = $idCondominio;
		$arreglo2["idCliente"] = $idCliente;
		if ($this->registrolote_modelo->editaRegistroLoteCaja($idLote, $arreglo)) {
			$this->registrolote_modelo->insertHistorialLotes($arreglo2);
			echo 1;
		} else {
			echo 0;
			die("ERROR");
		}
	}
	public function editarLoteRevisionJuridicoStatusContratacion7($idLote)
	{
		$datos["lotes"] = $this->registrolote_modelo->selectRegistroLoteCaja($idLote);
		$datos["juridicoStatus7"] = $this->registrolote_modelo->getJuridicoStatus7();
		if ($datos != null) {
			echo json_encode($datos);
		} else {
			echo json_encode(array());
		}
	}
	public function editar_registro_loteRevision_juridico_proceceso7()
	{
		$idLote = $this->input->post('idLote');
		$idCondominio = $this->input->post('idCondominio');
		$nombreLote = $this->input->post('nombreLote');
		$idStatusContratacion = $this->input->post('idStatusContratacion');
		$idMovimiento = $this->input->post('idMovimiento');
		$idCliente = $this->input->post('idCliente');
		$comentario = $this->input->post('comentario');
		$user = $this->input->post('user');
		$perfil = $this->input->post('perfil');
		$modificado = date("Y-m-d H:i:s");
		$fechaVenc = $this->input->post('fechaVenc');
		$aleatorio = rand();
		$contratoArchivo = $idCliente . '_' . $aleatorio . '_' . $_FILES["contratoArchivo"]["name"];
		$arreglo = array();
		$arreglo["idStatusContratacion"] = $idStatusContratacion;
		$arreglo["idMovimiento"] = 7;
		$arreglo["comentario"] = $comentario;
		$arreglo["user"] = $this->session->userdata('username');
		$arreglo["perfil"] = $this->session->userdata('perfil');
		$arreglo["modificado"] = date("Y-m-d H:i:s");
		$arreglo["contratoArchivo"] = $idCliente . '_' . $aleatorio . '_' . $_FILES["contratoArchivo"]["name"];
		$arreglo2 = array();
		$arreglo2["idStatusContratacion"] = $idStatusContratacion;
		$arreglo2["idMovimiento"] = 7;
		$arreglo2["nombreLote"] = $nombreLote;
		$arreglo2["comentario"] = $comentario;
		$arreglo2["user"] = $this->session->userdata('username');
		$arreglo2["perfil"] = $this->session->userdata('perfil');
		$arreglo2["modificado"] = date("Y-m-d H:i:s");
		$arreglo2["fechaVenc"] = $fechaVenc;
		$arreglo2["idLote"] = $idLote;
		$arreglo2["idCondominio"] = $idCondominio;
		$arreglo2["idCliente"] = $idCliente;
		if ($this->registrolote_modelo->editaRegistroLoteCaja($idLote, $arreglo)) {
			$this->registrolote_modelo->insertHistorialLotes($arreglo2);
			if (move_uploaded_file($_FILES["contratoArchivo"]["tmp_name"], "static/documentos/cliente/contrato/" . $idCliente . '_' . $aleatorio . '_' . $_FILES["contratoArchivo"]["name"])) {
				redirect(base_url() . "index.php/registroLote/registroStatus7ContratacionJuridico");
			}
		} else {
			die("ERROR");
		}
	}
	public function editarLoteRevisionAsistentesAContraloria9StatuContratacion8($idLote)
	{
		$datos = array();
		$datos["lotes"] = $this->registrolote_modelo->selectRegistroLoteCaja($idLote);
		$datos["asistentesStatus8"] = $this->registrolote_modelo->getAsistentesStatus8();
		$this->load->view('editar_loteRevision_asistentes_proceso8_view', $datos);
	}

	public function editarLoteRevisionAsistentesAAdministracion11StatuContratacion8($idLote)
	{
		$datos = array();
		$datos["lotes"] = $this->registrolote_modelo->selectRegistroLoteCaja($idLote);
		$datos["asistentesStatus8"] = $this->registrolote_modelo->getAsistentesStatus8();
		$this->load->view('editar_loteRevision_asistentesAadministracion11_proceso8_view', $datos);
	}

	public function editarLoteRevisionContraloriaStatusContratacion10($idLote)
	{
		$datos = array();
		$datos["lotes"] = $this->registrolote_modelo->selectRegistroLoteCaja($idLote);
		$datos["contraloriaStatus10"] = $this->registrolote_modelo->getContraloriaStatus10();
		$this->load->view('editar_loteRevision_contraloria_proceso10_view', $datos);
	}
	public function editar_registro_loteRevision_contraloria_proceceso10()
	{
		$idLote = $this->input->post('idLote');
		$idStatusContratacion = $this->input->post('idStatusContratacion');
		$idMovimiento = $this->input->post('idMovimiento');
		$comentario = $this->input->post('comentario');
		$user = $this->input->post('user');
		$perfil = $this->input->post('perfil');
		$modificado = date('Y-m-d H:i:s');
		$idPertenece = $this->input->post('idPertenece');
		$fechaVenc = $this->input->post('fechaVenc');
		$fechaVenStatus = $this->input->post('fechaVenStatus');
		$arreglo = array();
		$arreglo["idStatusContratacion"] = $idStatusContratacion;
		$arreglo["idMovimiento"] = 10;
		$arreglo["comentario"] = $comentario;
		$arreglo["usuario"] = $this->session->userdata('usuario');
		$arreglo["perfil"] = $this->session->userdata('perfil');
		$arreglo["modificado"] = date("Y-m-d H:i:s");
		$arreglo["idPertenece"] = 11;
		date_default_timezone_set('America/Mexico_City');
		$horaActual = date('H:i:s');
		$horaInicio = date("08:00:00");
		$horaFin = date("16:00:00");
		if ($horaActual > $horaInicio and $horaActual < $horaFin) {
			$fechaAccion = date("Y-m-d H:i:s");
			$hoy_strtotime2 = strtotime($fechaAccion);
			$sig_fecha_dia2 = date('D', $hoy_strtotime2);
			$sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
			if (
				$sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
				$sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
				$sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
				$sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
				$sig_fecha_feriado2 == "25-12"
			) {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 1) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				$arreglo["fechaVenc"] = $fecha;
			} else {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 0) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				$arreglo["fechaVenc"] = $fecha;
			}
		} elseif ($horaActual < $horaInicio || $horaActual > $horaFin) {
			$fechaAccion = date("Y-m-d H:i:s");
			$hoy_strtotime2 = strtotime($fechaAccion);
			$sig_fecha_dia2 = date('D', $hoy_strtotime2);
			$sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
			if (
				$sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
				$sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
				$sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
				$sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
				$sig_fecha_feriado2 == "25-12"
			) {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 1) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				$arreglo["fechaVenc"] = $fecha;
			} else {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 1) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				$arreglo["fechaVenc"] = $fecha;
			}
		}
		if ($this->registrolote_modelo->editaRegistroLoteCaja($idLote, $arreglo)) {
			echo 1;
		} else {
			echo 0;
			die("ERROR");
		}
	}
	public function editarLoteRevisionAsistentesStatusContratacion14($idLote)
	{
		$datos = array();
		$datos["lotes"] = $this->registrolote_modelo->selectRegistroLoteCaja($idLote);
		$datos["asistentesStatus14"] = $this->registrolote_modelo->getAsistentesStatus14();
		$this->load->view('editar_loteRevision_asistentes_proceso14_view', $datos);
	}
	public function editar_registro_loteRevision_asistentes_proceceso14()
	{
		$idLote = $this->input->post('idLote');
		$idCondominio = $this->input->post('idCondominio');
		$nombreLote = $this->input->post('nombreLote');
		$idStatusContratacion = $this->input->post('idStatusContratacion');
		$idMovimiento = $this->input->post('idMovimiento');
		$idCliente = $this->input->post('idCliente');
		$comentario = $this->input->post('comentario');
		$user = $this->input->post('user');
		$perfil = $this->input->post('perfil');
		$modificado = date("Y-m-d H:i:s");
		$fechaVenc = $this->input->post('fechaVenc');
		$arreglo = array();
		$arreglo["idStatusContratacion"] = $idStatusContratacion;
		$arreglo["idMovimiento"] = 69;
		$arreglo["comentario"] = $comentario;
		$arreglo["user"] = $this->session->userdata('username');
		$arreglo["perfil"] = $this->session->userdata('perfil');
		$arreglo["modificado"] = date("Y-m-d H:i:s");
		date_default_timezone_set('America/Mexico_City');
		$horaActual = date('H:i:s');
		$horaInicio = date("08:00:00");
		$horaFin = date("16:00:00");
		if ($horaActual > $horaInicio and $horaActual < $horaFin) {
			$fechaAccion = date("Y-m-d H:i:s");
			$hoy_strtotime2 = strtotime($fechaAccion);
			$sig_fecha_dia2 = date('D', $hoy_strtotime2);
			$sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
			if (
				$sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
				$sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
				$sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
				$sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
				$sig_fecha_feriado2 == "25-12"
			) {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 0) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				for ($i = 0; $i < count($fecha); $i++) {
					$arreglo["fechaVenc"] = $fecha;
				}
			} else {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= -1) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				for ($i = 0; $i < count($fecha); $i++) {
					$arreglo["fechaVenc"] = $fecha;
				}
			}
		} elseif ($horaActual < $horaInicio || $horaActual > $horaFin) {
			$fechaAccion = date("Y-m-d H:i:s");
			$hoy_strtotime2 = strtotime($fechaAccion);
			$sig_fecha_dia2 = date('D', $hoy_strtotime2);
			$sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
			if (
				$sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
				$sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
				$sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
				$sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
				$sig_fecha_feriado2 == "25-12"
			) {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 0) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				for ($i = 0; $i < count($fecha); $i++) {
					$arreglo["fechaVenc"] = $fecha;
				}
			} else {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 0) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				for ($i = 0; $i < count($fecha); $i++) {
					$arreglo["fechaVenc"] = $fecha;
				}
			}
		}
		$arreglo2 = array();
		$arreglo2["idStatusContratacion"] = $idStatusContratacion;
		$arreglo2["idMovimiento"] = 68;
		$arreglo2["nombreLote"] = $nombreLote;
		$arreglo2["comentario"] = $comentario;
		$arreglo2["user"] = $this->session->userdata('username');
		$arreglo2["perfil"] = $this->session->userdata('perfil');
		$arreglo2["modificado"] = date("Y-m-d H:i:s");
		$arreglo2["fechaVenc"] = $fechaVenc;
		$arreglo2["idLote"] = $idLote;
		$arreglo2["idCondominio"] = $idCondominio;
		$arreglo2["idCliente"] = $idCliente;
		if ($this->registrolote_modelo->editaRegistroLoteCaja($idLote, $arreglo)) {
			$this->registrolote_modelo->insertHistorialLotes($arreglo2);
			redirect(base_url() . "index.php/registroLote/registroStatus14ContratacionAsistentes");
		} else {
			die("ERROR");
		}
	}
	public function editarLoteRechazoJuridicoStatusContratacion3($idLote)
	{
		$lotes = $this->registrolote_modelo->selectRegistroLoteCaja($idLote);
		if ($lotes != null) {
			echo json_encode($lotes);
		} else {
			echo json_encode(array());
		}
	}
	public function editar_registro_loteRechazo_juridico_proceceso3()
	{
		$idLote = $this->input->post('idLote');
		$idCondominio = $this->input->post('idCondominio');
		$nombreLote = $this->input->post('nombreLote');
		$idStatusContratacion = $this->input->post('idStatusContratacion');
		$idMovimiento = $this->input->post('idMovimiento');
		$idCliente = $this->input->post('idCliente');
		$comentario = $this->input->post('comentario');
		$user = $this->input->post('user');
		$perfil = $this->input->post('perfil');
		$modificado = date("Y-m-d H:i:s");
		$arreglo = array();
		$arreglo["idStatusContratacion"] = 1;
		$arreglo["idMovimiento"] = 18;
		$arreglo["comentario"] = $comentario;
		$arreglo["user"] = $this->session->userdata('username');
		$arreglo["perfil"] = $this->session->userdata('perfil');
		$arreglo["modificado"] = date("Y-m-d H:i:s");
		$arreglo["fechaVenc"] = $modificado;
		$arreglo2 = array();
		$arreglo2["idStatusContratacion"] = 1;
		$arreglo2["idMovimiento"] = 18;
		$arreglo2["nombreLote"] = $nombreLote;
		$arreglo2["comentario"] = $comentario;
		$arreglo2["user"] = $this->session->userdata('username');
		$arreglo2["perfil"] = $this->session->userdata('perfil');
		$arreglo2["modificado"] = date("Y-m-d H:i:s");
		$arreglo2["fechaVenc"] = $modificado;
		$arreglo2["idLote"] = $idLote;
		$arreglo2["idCondominio"] = $idCondominio;
		$arreglo2["idCliente"] = $idCliente;
		if ($this->registrolote_modelo->editaRegistroLoteCaja($idLote, $arreglo)) {
			$this->registrolote_modelo->insertHistorialLotes($arreglo2);
			redirect(base_url() . "index.php/registroLote/registroStatus3ContratacionJuridico");
		} else {
			die("ERROR");
		}
	}
	public function editarLoteRechazoPostventaStatusContratacion4($idLote)
	{
		$datos = array();
		$datos["lotes"] = $this->registrolote_modelo->selectRegistroLoteCaja($idLote);
		$this->load->view('editar_loteRechazo_postventa_proceso4_view', $datos);
	}
	public function editar_registro_loteRechazo_postventa_proceceso4()
	{
		$idLote = $this->input->post('idLote');
		$idCondominio = $this->input->post('idCondominio');
		$nombreLote = $this->input->post('nombreLote');
		$idStatusContratacion = $this->input->post('idStatusContratacion');
		$idMovimiento = $this->input->post('idMovimiento');
		$idCliente = $this->input->post('idCliente');
		$comentario = $this->input->post('comentario');
		$user = $this->input->post('user');
		$perfil = $this->input->post('perfil');
		$modificado = date("Y-m-d H:i:s");
		$arreglo = array();
		$arreglo["idStatusContratacion"] = 1;
		$arreglo["idMovimiento"] = 19;
		$arreglo["comentario"] = $comentario;
		$arreglo["user"] = $this->session->userdata('username');
		$arreglo["perfil"] = $this->session->userdata('perfil');
		$arreglo["modificado"] = date("Y-m-d H:i:s");
		$arreglo2["fechaVenc"] = $modificado;
		$arreglo2 = array();
		$arreglo2["idStatusContratacion"] = 1;
		$arreglo2["idMovimiento"] = 19;
		$arreglo2["nombreLote"] = $nombreLote;
		$arreglo2["comentario"] = $comentario;
		$arreglo2["user"] = $this->session->userdata('username');
		$arreglo2["perfil"] = $this->session->userdata('perfil');
		$arreglo2["modificado"] = date("Y-m-d H:i:s");
		$arreglo2["fechaVenc"] = $modificado;
		$arreglo2["idLote"] = $idLote;
		$arreglo2["idCondominio"] = $idCondominio;
		$arreglo2["idCliente"] = $idCliente;
		if ($this->registrolote_modelo->editaRegistroLoteCaja($idLote, $arreglo)) {
			$this->registrolote_modelo->insertHistorialLotes($arreglo2);
			redirect(base_url() . "index.php/registroLote/registroStatus4ContratacionPostventa");
		} else {
			die("ERROR");
		}
	}
	public function editarLoteRechazoContraloriaStatusContratacion5($idLote)
	{
		$datos = array();
		$datos["lotes"] = $this->registrolote_modelo->selectRegistroLoteCaja($idLote);
		$this->load->view('editar_loteRechazo_contraloria_proceso5_view', $datos);
	}
	public function editar_registro_loteRechazo_contraloria_proceceso5()
	{
		$idLote = $this->input->post('idLote');
		$idCondominio = $this->input->post('idCondominio');
		$nombreLote = $this->input->post('nombreLote');
		$idStatusContratacion = $this->input->post('idStatusContratacion');
		$idMovimiento = $this->input->post('idMovimiento');
		$idCliente = $this->input->post('idCliente');
		$comentario = $this->input->post('comentario');
		$user = $this->input->post('user');
		$perfil = $this->input->post('perfil');
		$modificado = date("Y-m-d H:i:s");
		$arreglo = array();
		$arreglo["idStatusContratacion"] = 1;
		$arreglo["idMovimiento"] = 20;
		$arreglo["comentario"] = $comentario;
		$arreglo["usuario"] = $this->session->userdata('usuario');
		$arreglo["perfil"] = $this->session->userdata('perfil');
		$arreglo["modificado"] = date("Y-m-d H:i:s");
		$arreglo2["fechaVenc"] = $modificado;
		$arreglo2 = array();
		$arreglo2["idStatusContratacion"] = 1;
		$arreglo2["idMovimiento"] = 20;
		$arreglo2["nombreLote"] = $nombreLote;
		$arreglo2["comentario"] = $comentario;
		$arreglo2["usuario"] = $this->session->userdata('usuario');
		$arreglo2["perfil"] = $this->session->userdata('perfil');
		$arreglo2["modificado"] = date("Y-m-d H:i:s");
		$arreglo2["fechaVenc"] = $modificado;
		$arreglo2["idLote"] = $idLote;
		$arreglo2["idCondominio"] = $idCondominio;
		$arreglo2["idCliente"] = $idCliente;
		if ($this->registrolote_modelo->editaRegistroLoteCaja($idLote, $arreglo)) {
			$this->registrolote_modelo->insertHistorialLotes($arreglo2);
			echo 1;
		} else {
			echo 0;
			die("ERROR");
		}
	}
	public function editarLoteRechazoContraloriaStatusContratacion6($idLote)
	{
		$datos = array();
		$datos["lotes"] = $this->registrolote_modelo->selectRegistroLoteCaja($idLote);
		$this->load->view('editar_loteRechazo_contraloria_proceso6_view', $datos);
	}
	public function editar_registro_loteRechazo_contraloria_proceceso6()
	{
		$idLote = $this->input->post('idLote');
		$idCondominio = $this->input->post('idCondominio');
		$nombreLote = $this->input->post('nombreLote');
		$idStatusContratacion = $this->input->post('idStatusContratacion');
		$idMovimiento = $this->input->post('idMovimiento');
		$idCliente = $this->input->post('idCliente');
		$comentario = $this->input->post('motivoRechazo');
		$user = $this->input->post('user');
		$perfil = $this->input->post('perfil');
		$modificado = date("Y-m-d H:i:s");
		$arreglo = array();
		$arreglo["idStatusContratacion"] = 1;
		$arreglo["idMovimiento"] = 63;
		$arreglo["comentario"] = $comentario;
		$arreglo["usuario"] = $this->session->userdata('usuario');
		$arreglo["perfil"] = $this->session->userdata('perfil');
		$arreglo["modificado"] = date("Y-m-d H:i:s");
		$arreglo["fechaVenc"] = $modificado;
		$arreglo2 = array();
		$arreglo2["idStatusContratacion"] = 1;
		$arreglo2["idMovimiento"] = 63;
		$arreglo2["nombreLote"] = $nombreLote;
		$arreglo2["comentario"] = $comentario;
		$arreglo2["usuario"] = $this->session->userdata('usuario');
		$arreglo2["perfil"] = $this->session->userdata('perfil');
		$arreglo2["modificado"] = date("Y-m-d H:i:s");
		$arreglo2["fechaVenc"] = $modificado;
		$arreglo2["idLote"] = $idLote;
		$arreglo2["idCondominio"] = $idCondominio;
		$arreglo2["idCliente"] = $idCliente;
		if ($this->registrolote_modelo->editaRegistroLoteCaja($idLote, $arreglo)) {
			$this->registrolote_modelo->insertHistorialLotes($arreglo2);
			echo 1;
		} else {
			echo 0;
			die("ERROR");
		}
	}
	public function editarLoteRechazoJuridicoStatusContratacion7($idLote)
	{
		$datos["lotes"] = $this->registrolote_modelo->selectRegistroLoteCaja($idLote);
		if ($datos["lotes"] != null) {
			echo json_encode($datos["lotes"]);
		} else {
			echo json_encode(array());
		}
	}
	public function editar_registro_loteRechazo_juridico_proceceso7()
	{
		$idLote = $this->input->post('idLote');
		$idCondominio = $this->input->post('idCondominio');
		$nombreLote = $this->input->post('nombreLote');
		$idStatusContratacion = $this->input->post('idStatusContratacion');
		$idMovimiento = $this->input->post('idMovimiento');
		$idCliente = $this->input->post('idCliente');
		$comentario = $this->input->post('comentario');
		$user = $this->input->post('user');
		$perfil = $this->input->post('perfil');
		$modificado = date("Y-m-d H:i:s");
		$arreglo = array();
		$arreglo["idStatusContratacion"] = 5;
		$arreglo["idMovimiento"] = 22;
		$arreglo["comentario"] = $comentario;
		$arreglo["user"] = $this->session->userdata('username');
		$arreglo["perfil"] = $this->session->userdata('perfil');
		$arreglo["modificado"] = date("Y-m-d H:i:s");
		$arreglo["fechaVenc"] = $modificado;
		$arreglo2 = array();
		$arreglo2["idStatusContratacion"] = 5;
		$arreglo2["idMovimiento"] = 22;
		$arreglo2["nombreLote"] = $nombreLote;
		$arreglo2["comentario"] = $comentario;
		$arreglo2["user"] = $this->session->userdata('username');
		$arreglo2["perfil"] = $this->session->userdata('perfil');
		$arreglo2["modificado"] = date("Y-m-d H:i:s");
		$arreglo2["fechaVenc"] = $modificado;
		$arreglo2["idLote"] = $idLote;
		$arreglo2["idCondominio"] = $idCondominio;
		$arreglo2["idCliente"] = $idCliente;
		if ($this->registrolote_modelo->editaRegistroLoteCaja($idLote, $arreglo)) {
			$this->registrolote_modelo->insertHistorialLotes($arreglo2);
			redirect(base_url() . "index.php/registroLote/registroStatus7ContratacionJuridico");
		} else {
			die("ERROR");
		}
	}
	public function editarLoteRechazoAsistentesStatusContratacion8($idLote)
	{
		$datos = array();
		$datos["lotes"] = $this->registrolote_modelo->selectRegistroLoteCaja($idLote);
		$this->load->view('editar_loteRechazo_asistentes_proceso8_view', $datos);
	}
	public function editar_registro_loteRechazo_asistentes_proceceso8()
	{
		$idLote = $this->input->post('idLote');
		$idCondominio = $this->input->post('idCondominio');
		$nombreLote = $this->input->post('nombreLote');
		$idStatusContratacion = $this->input->post('idStatusContratacion');
		$idMovimiento = $this->input->post('idMovimiento');
		$idCliente = $this->input->post('idCliente');
		$comentario = $this->input->post('comentario');
		$user = $this->input->post('user');
		$perfil = $this->input->post('perfil');
		$modificado = date("Y-m-d H:i:s");
		$arreglo = array();
		$arreglo["idStatusContratacion"] = 6;
		$arreglo["idMovimiento"] = 23;
		$arreglo["comentario"] = $comentario;
		$arreglo["user"] = $this->session->userdata('username');
		$arreglo["perfil"] = $this->session->userdata('perfil');
		$arreglo["modificado"] = date("Y-m-d H:i:s");
		$arreglo2 = array();
		$arreglo2["idStatusContratacion"] = 6;
		$arreglo2["idMovimiento"] = 23;
		$arreglo2["nombreLote"] = $nombreLote;
		$arreglo2["comentario"] = $comentario;
		$arreglo2["user"] = $this->session->userdata('username');
		$arreglo2["perfil"] = $this->session->userdata('perfil');
		$arreglo2["modificado"] = date("Y-m-d H:i:s");
		$arreglo2["fechaVenc"] = $modificado;
		$arreglo2["idLote"] = $idLote;
		$arreglo2["idCondominio"] = $idCondominio;
		$arreglo2["idCliente"] = $idCliente;
		if ($this->registrolote_modelo->editaRegistroLoteCaja($idLote, $arreglo)) {
			$this->registrolote_modelo->insertHistorialLotes($arreglo2);
			redirect(base_url() . "index.php/registroLote/registroStatus8ContratacionAsistentes");
		} else {
			die("ERROR");
		}
	}
	public function editarLoteRechazoContraloriaStatusContratacion9($idLote)
	{
		$datos = array();
		$datos["lotes"] = $this->registrolote_modelo->selectRegistroLoteCaja($idLote);
		$this->load->view('editar_loteRechazo_contraloria_proceso9_view', $datos);
	}
	public function editar_registro_loteRechazo_contraloria_proceceso9()
	{
		$idLote = $this->input->post('idLote');
		$idCondominio = $this->input->post('idCondominio');
		$nombreLote = $this->input->post('nombreLote');
		$idStatusContratacion = $this->input->post('idStatusContratacion');
		$idMovimiento = $this->input->post('idMovimiento');
		$idCliente = $this->input->post('idCliente');
		$comentario = $this->input->post('motivoRechazo');
		$user = $this->input->post('user');
		$perfil = $this->input->post('perfil');
		$modificado = date("Y-m-d H:i:s");
		$arreglo = array();
		$arreglo["idStatusContratacion"] = 7;
		$arreglo["idMovimiento"] = 64;
		$arreglo["comentario"] = $comentario;
		$arreglo["usuario"] = $this->session->userdata('usuario');
		$arreglo["perfil"] = $this->session->userdata('perfil');
		$arreglo["modificado"] = date("Y-m-d H:i:s");
		$arreglo2 = array();
		$arreglo2["idStatusContratacion"] = 7;
		$arreglo2["idMovimiento"] = 64;
		$arreglo2["nombreLote"] = $nombreLote;
		$arreglo2["comentario"] = $comentario;
		$arreglo2["usuario"] = $this->session->userdata('usuario');
		$arreglo2["perfil"] = $this->session->userdata('perfil');
		$arreglo2["modificado"] = date("Y-m-d H:i:s");
		$arreglo2["fechaVenc"] = $modificado;
		$arreglo2["idLote"] = $idLote;
		$arreglo2["idCondominio"] = $idCondominio;
		$arreglo2["idCliente"] = $idCliente;
		if ($this->registrolote_modelo->editaRegistroLoteCaja($idLote, $arreglo)) {
			$this->registrolote_modelo->insertHistorialLotes($arreglo2);
			echo 1;
		} else {
			echo 0;
			die("ERROR");
		}
	}
	public function editarLoteRechazoContraloriaStatusContratacion10($idLote)
	{
		$datos = array();
		$datos["lotes"] = $this->registrolote_modelo->selectRegistroLoteCaja($idLote);
		$this->load->view('editar_loteRechazo_contraloria_proceso10_view', $datos);
	}
	public function editar_registro_loteRechazo_contraloria_proceceso10()
	{
		$idLote = $this->input->post('idLote');
		$idStatusContratacion = $this->input->post('idStatusContratacion');
		$idMovimiento = $this->input->post('idMovimiento');
		$comentario = $this->input->post('comentario');
		$user = $this->input->post('user');
		$perfil = $this->input->post('perfil');
		$modificado = $this->input->post('modificado');
		$idPertenece = $this->input->post('idPertenece');
		$arreglo = array();
		$arreglo["idStatusContratacion"] = 8;
		$arreglo["idMovimiento"] = 2;
		$arreglo["comentario"] = $comentario;
		$arreglo["user"] = $this->session->userdata('username');
		$arreglo["perfil"] = $this->session->userdata('perfil');
		$arreglo["modificado"] = date("Y-m-d H:i:s");
		$arreglo["idPertenece"] = 9;
		if ($this->registrolote_modelo->editaRegistroLoteCaja($idLote, $arreglo)) {
			redirect(base_url() . "index.php/registroLote/registroStatus10ContratacionContraloria");
		} else {
			die("ERROR");
		}
	}
	public function editarLoteRechazoAdministracionStatusContratacion11($idLote)
	{
		$datos = $this->registrolote_modelo->selectRegistroLoteCaja($idLote);
		if ($datos != null) {
			echo json_encode($datos);
		} else {
			echo json_encode(array());
		}
		exit;
	}
	public function editarLoteRechazoContraloriaStatusContratacion15($idLote)
	{
		$datos = array();
		$datos["lotes"] = $this->registrolote_modelo->selectRegistroLoteCaja($idLote);
		$this->load->view('editar_loteRechazo_contraloria_proceso15_view', $datos);
	}
	public function editar_registro_loteRechazo_contraloria_proceceso15()
	{
		$idLote = $this->input->post('idLote');
		$idCondominio = $this->input->post('idCondominio');
		$nombreLote = $this->input->post('nombreLote');
		$idStatusContratacion = $this->input->post('idStatusContratacion');
		$idMovimiento = $this->input->post('idMovimiento');
		$idCliente = $this->input->post('idCliente');
		$comentario = $this->input->post('motivoRechazo');
		$user = $this->input->post('user');
		$perfil = $this->input->post('perfil');
		$modificado = date("Y-m-d H:i:s");
		$arreglo = array();
		$arreglo["idStatusContratacion"] = 13;
		$arreglo["idMovimiento"] = 68;
		$arreglo["comentario"] = $comentario;
		$arreglo["usuario"] = $this->session->userdata('usuario');
		$arreglo["perfil"] = $this->session->userdata('perfil');
		$arreglo["modificado"] = date("Y-m-d H:i:s");
		$arreglo["fechaVenc"] = date("Y-m-d H:i:s");
		$arreglo2 = array();
		$arreglo2["idStatusContratacion"] = 13;
		$arreglo2["idMovimiento"] = 68;
		$arreglo2["nombreLote"] = $nombreLote;
		$arreglo2["comentario"] = $comentario;
		$arreglo2["usuario"] = $this->session->userdata('usuario');
		$arreglo2["perfil"] = $this->session->userdata('perfil');
		$arreglo2["modificado"] = date("Y-m-d H:i:s");
		$arreglo2["fechaVenc"] = $modificado;
		$arreglo2["idLote"] = $idLote;
		$arreglo2["idCondominio"] = $idCondominio;
		$arreglo2["idCliente"] = $idCliente;
		if ($this->registrolote_modelo->editaRegistroLoteCaja($idLote, $arreglo)) {
			$this->registrolote_modelo->insertHistorialLotes($arreglo2);
			echo 1;
		} else {
			die("ERROR");
			echo 0;
		}
	}
	function getLotesInventarioLiberaciones($condominio, $residencial)
	{
		$data['lotes'] = $this->registrolote_modelo->getInventarioLiberacion($condominio, $residencial);
		echo '<table id="tabla_inventario_liberacion"class="table table-bordered table-hover" width="100%" style="text-align:center;">';
		echo '<thead>';
		echo '<tr>';
		echo '<th class="text-center">Nombre</th>';
		echo '<th class="text-center">Superficie</th>';
		echo '<th class="text-center">Precio</th>';
		echo '<th class="text-center">Total</th>';
		echo '<th class="text-center">Porcentaje</th>';
		echo '<th class="text-center">Enganche</th>';
		echo '<th class="text-center">Saldo</th>';
		echo '<th class="text-center">Al 0% </th>';
		echo '<th class="text-center">Al 1%</th>';
		echo '<th class="text-center">Referencia</th>';
		echo '<th class="text-center">Status</th>';
		echo '<th class="text-center">Liberación</th>';
		echo '<th class="text-center">Fecha Liberación</th>';
		echo '<th class="text-center">Acciones</th>';
		echo '</tr>';
		echo '<tfoot>';
		echo '<tr>';
		echo '<th class="text-center">Nombre</th>';
		echo '<th class="text-center">Superficie</th>';
		echo '<th class="text-center">Precio</th>';
		echo '<th class="text-center">Total</th>';
		echo '<th class="text-center">Porcentaje</th>';
		echo '<th class="text-center">Enganche</th>';
		echo '<th class="text-center">Saldo</th>';
		echo '<th class="text-center">Al 0% </th>';
		echo '<th class="text-center">Al 1%</th>';
		echo '<th class="text-center">Referencia</th>';
		echo '<th class="text-center">Status</th>';
		echo '<th class="text-center">Liberación</th>';
		echo '<th class="text-center">Fecha Liberación</th>';
		echo '<th class="text-center">Acciones</th>';
		echo '</tfoot>';
		echo '</tr>';
		echo '</thead>';
		echo '<tbody class="lotes">';
		setlocale(LC_MONETARY, 'en_US');
		$i = 0;
		while ($i < count($data['lotes'])) {
			echo "<tr id='" . $data['lotes'][$i]['idLote'] . "' class='resaltar'>";
			echo "<td style=text-align:center>" . $data['lotes'][$i]['nombreLote'] . "</td>";
			echo "<td style=text-align:center>" . $data['lotes'][$i]['sup'] . "</td>";
			echo "<td style=text-align:center>" . "$" . number_format($data['lotes'][$i]['precio'], 2, ".", ",") . "</td>";
			echo "<td style=text-align:center>" . "$" . number_format($data['lotes'][$i]['total'], 2, ".", ",") . "</td>";
			echo "<td style=text-align:center>" . $data['lotes'][$i]['porcentaje'] . "%" . "</td>";
			echo "<td style=text-align:center>" . "$" . number_format($data['lotes'][$i]['enganche'], 2, ".", ",") . "</td>";
			echo "<td style=text-align:center>" . "$" . number_format($data['lotes'][$i]['saldo'], 2, ".", ",") . "</td>";
			echo "<td style=text-align:center>" . "$" . number_format($data['lotes'][$i]['modalidad_1'], 2, ".", ",") . "</td>";
			echo "<td style=text-align:center>" . "$" . number_format($data['lotes'][$i]['modalidad_2'], 2, ".", ",") . "</td>";
			echo "<td style=text-align:center>" . $data['lotes'][$i]['referencia'] . "</td>";
			echo "<td style=text-align:center>" . $data['lotes'][$i]['nombre'] . "</td>";
			echo "<td style=text-align:center>" . $data['lotes'][$i]['comentarioLiberacion'] . "</td>";
			echo "<td style=text-align:center>" . $data['lotes'][$i]['fechaLiberacion'] . "</td>";
			echo "<td style=text-align:center>
 <a href='" . 'editarLoteLiberacionCaja/' . $data['lotes'][$i]['idLote'] . "'> 
<img src= 'http://contratacion.sisgph.com/contratacion/static/images/liberacion.png' width='25' height='23' title= 'Registra Liberación'/>  
                  </a>
 </td>";
			$i++;
		}
		echo '</tbody>';
		echo '</table>';
		?>
		<script type="text/javascript">
			$(document).ready(function () {
				$('#tabla_inventario_liberacion').dataTable({
					initComplete: function () {
						this.api().columns().every(function () {
							var column = this;
							var select = $('<select><option value=""></option></select>')
								.appendTo($(column.footer()).empty())
								.on('change', function () {
									var val = $.fn.dataTable.util.escapeRegex(
										$(this).val()
									);
									column
										.search(val ? '^' + val + '$' : '', true, false)
										.draw();
								});
							column.data().unique().sort().each(function (d, j) {
								select.append('<option value="' + d + '">' + d + '</option>')
							});
						});
					},
					"scrollX": true,
					"pageLength": 10,
					"language": {
						"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
					},
					dom: 'Bfrtip',
					buttons: [
						{
							extend: 'copyHtml5',
							text: '<i class="fa fa-files-o"></i>',
							titleAttr: 'Copy'
						},
						{
							extend: 'excelHtml5',
							text: '<i class="fa fa-file-excel-o"></i>',
							titleAttr: 'Excel'
						},
						{
							extend: 'csvHtml5',
							text: '<i class="fa fa-file-text-o"></i>',
							titleAttr: 'CSV'
						},
						{
							extend: 'pdfHtml5',
							text: '<i class="fa fa-file-pdf-o"></i>',
							titleAttr: 'PDF'
						}
					]
				});
			});
		</script>
		<link rel="stylesheet" type="text/css" href="<?= base_url() ?>dist/css/shadowbox.css">
		<script type="text/javascript" src="<?= base_url() ?>dist/js/shadowbox.js"></script>
		<script type="text/javascript">
			Shadowbox.init();
		</script>
		<link rel="stylesheet" type="text/css" href="<?= base_url() ?>dist/css/shadowbox.css">
		<script type="text/javascript" src="<?= base_url() ?>dist/js/shadowbox.js"></script>
		<script type="text/javascript">
			Shadowbox.init();
		</script>
		<?php
	}
	function getLotesInventarioGral($condominio, $residencial)
	{
		$data = $this->registrolote_modelo->getInventario($condominio, $residencial);
		$dataPer = array();
		for ($i = 0; $i < count($data); $i++) {
			$dataPer[$i]['idLote'] = ($data[$i]['idLote'] != "") ? $data[$i]['idLote'] : "";
			$dataPer[$i]['nombreLote'] = ($data[$i]['nombreLote'] != "") ? $data[$i]['nombreLote'] : "";
			$dataPer[$i]['sup'] = ($data[$i]['sup'] != "") ? $data[$i]['sup'] : "";
			$dataPer[$i]['precio'] = ($data[$i]['precio'] != "") ? $data[$i]['precio'] : "";
			$dataPer[$i]['total'] = ($data[$i]['total'] != "") ? $data[$i]['total'] : "";
			$dataPer[$i]['porcentaje'] = ($data[$i]['porcentaje'] != "") ? $data[$i]['porcentaje'] : "";
			$dataPer[$i]['enganche'] = ($data[$i]['enganche'] != "") ? $data[$i]['enganche'] : "";
			$dataPer[$i]['saldo'] = ($data[$i]['saldo'] != "") ? $data[$i]['saldo'] : "";
			$dataPer[$i]['modalidad_1'] = ($data[$i]['modalidad_1'] != "") ? $data[$i]['modalidad_1'] : "";
			$dataPer[$i]['modalidad_2'] = ($data[$i]['modalidad_2'] != "") ? $data[$i]['modalidad_2'] : "";
			$dataPer[$i]['referencia'] = ($data[$i]['referencia'] != "") ? $data[$i]['referencia'] : "";
			$dataPer[$i]['nombre'] = ($data[$i]['nombre'] != "") ? $data[$i]['nombre'] : "";
			$dataPer[$i]['comentarioLiberacion'] = ($data[$i]['comentarioLiberacion'] != "") ? $data[$i]['comentarioLiberacion'] : "";
			$dataPer[$i]['fechaLiberacion'] = ($data[$i]['fechaLiberacion'] != "") ? $data[$i]['fechaLiberacion'] : "";
			$dataPer[$i]['nombreCondominio'] = ($data[$i]['nombreCondominio'] != "") ? $data[$i]['nombreCondominio'] : "";
			$dataPer[$i]['nombreResidencial'] = ($data[$i]['nombreResidencial'] != "") ? $data[$i]['nombreResidencial'] : "";
			$dataPer[$i]['gerente1'] = ($data[$i]['gerente1'] != "") ? $data[$i]['gerente1'] : "";
			$dataPer[$i]['gerente2'] = ($data[$i]['gerente2'] != "") ? $data[$i]['gerente2'] : "";
			$dataPer[$i]['gerente3'] = ($data[$i]['gerente3'] != "") ? $data[$i]['gerente3'] : "";
			$dataPer[$i]['asesor'] = ($data[$i]['asesor'] != "") ? $data[$i]['asesor'] : "";
			$dataPer[$i]['asesor2'] = ($data[$i]['asesor2'] != "") ? $data[$i]['asesor2'] : "";
			$dataPer[$i]['asesor3'] = ($data[$i]['asesor3'] != "") ? $data[$i]['asesor3'] : "";
			$dataPer[$i]['fechaApartado'] = ($data[$i]['fechaApartado'] != "") ? $data[$i]['fechaApartado'] : "";
			$dataPer[$i]['idstatuslote'] = ($data[$i]['idstatuslote'] != "") ? $data[$i]['idstatuslote'] : "";
			$dataPer[$i]['gerenteL'] = ($data[$i]['gerenteL'] != "") ? $data[$i]['gerenteL'] : "";
			$dataPer[$i]['gerenteL2'] = ($data[$i]['gerenteL2'] != "") ? $data[$i]['gerenteL2'] : "";
			$dataPer[$i]['asesorL'] = ($data[$i]['asesorL'] != "") ? $data[$i]['asesorL'] : "";
			$dataPer[$i]['asesorL2'] = ($data[$i]['asesorL2'] != "") ? $data[$i]['asesorL2'] : "";
			$dataPer[$i]['fecha_modst'] = ($data[$i]['fecha_modst'] != "") ? $data[$i]['fecha_modst'] : "";
			$dataPer[$i]['userApartado'] = ($data[$i]['userApartado'] != "") ? $data[$i]['userApartado'] : "";
			$dataPer[$i]['userLote'] = ($data[$i]['userLote'] != "") ? $data[$i]['userLote'] : "";
			$dataPer[$i]['motivo_change_status'] = ($data[$i]['motivo_change_status'] != "") ? $data[$i]['motivo_change_status'] : "";
			$proyecto = str_replace(' ', '', $data[$i]['nombreResidencial']);
			$cluster = strtoupper($data[$i]['nombreCondominio']);
			$string = str_replace("ñ", "N", $cluster);
			$arr = explode("_", $string);
			$clusterClean = implode("", $arr);
			$lote = str_replace(' ', '', $clusterClean);
			$numeroLote = preg_replace('/[^0-9]/', '', $data[$i]['nombreLote']);
			$dataPer[$i]['cbbtton'] = $proyecto . $lote . $numeroLote;
		}
		if ($dataPer != null) {
			echo json_encode($dataPer);
		} else {
			echo json_encode(array());
		}
		exit;
		$data['lotes'] = $this->registrolote_modelo->getInventario($condominio, $residencial);
		$status_color = array(
			'Apartado' => '#C5A805',
			'Bloqueo' => '#9A087D',
			'Disponible' => '#000000',
			'Contratado' => '#000000',
			'Enganche' => '#000000',
			'Intercambio' => '#000000',
			'Dirección' => '#000000',
			'Contratado por Intercambio' => '#000000',
			'Apartado casas' => '#000000',
		);
		echo '<table id="tabla_inventario_gral" width ="100%" class="table table-bordered table-hover" >';
		echo '<thead>';
		echo '<tr>';
		echo '<th style=display:none class="text-center">ID</th>';
		echo '<th class="text-center">Nombre</th>';
		echo '<th class="text-center">Superficie</th>';
		echo '<th class="text-center">Precio</th>';
		echo '<th class="text-center">Total</th>';
		echo '<th class="text-center">Porcentaje</th>';
		echo '<th class="text-center">Enganche</th>';
		echo '<th class="text-center">Saldo</th>';
		echo '<th class="text-center">Al 0% </th>';
		echo '<th class="text-center">Al 1%</th>';
		echo '<th class="text-center">Referencia</th>';
		echo '<th class="text-center">Status</th>';
		echo '<th class="text-center">Liberación</th>';
		echo '<th class="text-center">Fecha Liberación</th>';
		echo '<th class="text-center">Gerente(s)</th>';
		echo '<th class="text-center">Aseseor</th>';
		echo '<th class="text-center">Aseseor</th>';
		echo '<th class="text-center">Aseseor</th>';
		echo '<th class="text-center">Código de Barras</th>';
		echo '<th class="text-center">Acciones</th>';
		echo '</tr>';
		echo '<tfoot>';
		echo '<tr>';
		echo '<th style=display:none class="text-center">ID</th>';
		echo '<th class="text-center">Nombre</th>';
		echo '<th class="text-center">Superficie</th>';
		echo '<th class="text-center">Precio</th>';
		echo '<th class="text-center">Total</th>';
		echo '<th class="text-center">Porcentaje</th>';
		echo '<th class="text-center">Enganche</th>';
		echo '<th class="text-center">Saldo</th>';
		echo '<th class="text-center">Al 0% </th>';
		echo '<th class="text-center">Al 1%</th>';
		echo '<th class="text-center">Referencia</th>';
		echo '<th class="text-center">Status</th>';
		echo '<th class="text-center">Liberación</th>';
		echo '<th class="text-center">Fecha Liberación</th>';
		echo '<th class="text-center">Gerente(s)</th>';
		echo '<th class="text-center">Aseseor</th>';
		echo '<th class="text-center">Aseseor</th>';
		echo '<th class="text-center">Aseseor</th>';
		echo '<th class="text-center">Código de Barras</th>';
		echo '<th class="text-center">Acciones</th>';
		echo '</tfoot>';
		echo '</tr>';
		echo '</thead>';
		echo '<tbody class="lotes">';
		setlocale(LC_MONETARY, 'en_US');
		$i = 0;
		while ($i < count($data['lotes'])) {
			echo "<tr style=text-align:center id='" . $data['lotes'][$i]['idLote'] . "' class='resaltar'>";
			echo "<td style=display:none>" . $data['lotes'][$i]['idLote'] . "</td>";
			echo "<td style='color:" . $status_color[$data['lotes'][$i]['nombre']] . "'>" . $data['lotes'][$i]['nombreLote'] . "</td>";
			echo "<td style='color:" . $status_color[$data['lotes'][$i]['nombre']] . "'>" . $data['lotes'][$i]['sup'] . "</td>";
			echo "<td style='color:" . $status_color[$data['lotes'][$i]['nombre']] . "'>" . "$" . number_format($data['lotes'][$i]['precio'], 2, ".", ",") . "</td>";
			echo "<td style='color:" . $status_color[$data['lotes'][$i]['nombre']] . "'>" . "$" . number_format($data['lotes'][$i]['total'], 2, ".", ",") . "</td>";
			echo "<td style='color:" . $status_color[$data['lotes'][$i]['nombre']] . "'>" . $data['lotes'][$i]['porcentaje'] . "%" . "</td>";
			echo "<td style='color:" . $status_color[$data['lotes'][$i]['nombre']] . "'>" . "$" . number_format($data['lotes'][$i]['enganche'], 2, ".", ",") . "</td>";
			echo "<td style='color:" . $status_color[$data['lotes'][$i]['nombre']] . "'>" . "$" . number_format($data['lotes'][$i]['saldo'], 2, ".", ",") . "</td>";
			echo "<td style='color:" . $status_color[$data['lotes'][$i]['nombre']] . "'>" . "$" . number_format($data['lotes'][$i]['modalidad_1'], 2, ".", ",") . "</td>";
			echo "<td style='color:" . $status_color[$data['lotes'][$i]['nombre']] . "'" . "$" . number_format($data['lotes'][$i]['modalidad_2'], 2, ".", ",") . "</td>";
			echo "<td style='color:" . $status_color[$data['lotes'][$i]['nombre']] . "'>" . $data['lotes'][$i]['referencia'] . "</td>";
			echo "<td style='color:" . $status_color[$data['lotes'][$i]['nombre']] . "'>" . $data['lotes'][$i]['nombre'] . "</td>";
			echo "<td style='color:" . $status_color[$data['lotes'][$i]['nombre']] . "'>" . $data['lotes'][$i]['comentarioLiberacion'] . "</td>";
			echo "<td style='color:" . $status_color[$data['lotes'][$i]['nombre']] . "'>" . $data['lotes'][$i]['fechaLiberacion'] . "</td>";
			echo "<td>";
			if (!empty($data['lotes'][$i]['gerente1'])) {
				echo "<i class='glyphicon glyphicon-user'></i>" . $data['lotes'][$i]['gerente1'] . "<br>";
			}
			if (!empty($data['lotes'][$i]['gerente2'])) {
				echo "<i class='glyphicon glyphicon-user'></i>" . $data['lotes'][$i]['gerente2'] . "<br>";
			}
			if (!empty($data['lotes'][$i]['gerente3'])) {
				echo "<i class='glyphicon glyphicon-user'></i>" . $data['lotes'][$i]['gerente3'] . "<br>";
			}
			echo "</td>";
			echo "<td>";
			if (!empty($data['lotes'][$i]['asesor'])) {
				echo "<i class='glyphicon glyphicon-user'></i>" . $data['lotes'][$i]['asesor'];
			}
			echo "</td>";
			echo "<td>";
			if (!empty($data['lotes'][$i]['asesor2'])) {
				echo "<i class='glyphicon glyphicon-user'></i>" . $data['lotes'][$i]['asesor2'];
			}
			echo "</td>";
			echo "<td>";
			if (!empty($data['lotes'][$i]['asesor3'])) {
				echo "<i class='glyphicon glyphicon-user'></i>" . $data['lotes'][$i]['asesor3'];
			}
			echo "</td>";
			$proyecto = str_replace(' ', '', $data['lotes'][$i]['nombreResidencial']);
			$cluster = strtoupper($data['lotes'][$i]['nombreCondominio']);
			$string = str_replace("ñ", "N", $cluster);
			$clusterSE = str_replace(" ", "", $string);
			$arr = explode("_", $clusterSE);
			$lote = implode("", $arr);
			$numeroLote = preg_replace('/[^0-9]/', '', $data['lotes'][$i]['nombreLote']);
			$composicion = $proyecto . $lote . $numeroLote;
			echo "<td style=text-align:center>
			<img src='" . site_url() . '/main/bikin_barcode/' . $composicion . "'>
			</td>";
						echo "<td style=text-align:center>
			<a href='" . 'historial_liberacion/' . $data['lotes'][$i]['idLote'] . "' rel='shadowbox[Vacation];width=700;height=440'> 
			<img src='http://contratacion.sisgph.com/contratacion/static/images/historialLiberacion.png' width='25' height='23' title = 'Historial Liberación'/>
			</a>
			<a href='" . 'historialProcesoLote/' . $data['lotes'][$i]['idLote'] . "' rel='shadowbox[Vacation];width=700;height=440'><img src='http://contratacion.sisgph.com/contratacion/static/images/registrarStatus.png' width='25' height='23' title = 'Historial Proceso de contratación'>  
			</a>
			</td>";
			$i++;
		}
		echo '</tbody>';
		echo '</table>';
		?>
				<style>
					th, td {
						white-space: nowrap;
					}
					tr {
						height: 50px;
					}
				</style>
				<script type="text/javascript">
					$(document).ready(function () {
						$('#tabla_inventario_gral').dataTable({
							initComplete: function () {
								this.api().columns().every(function () {
									var column = this;
									var select = $('<select><option value=""></option></select>')
										.appendTo($(column.footer()).empty())
										.on('change', function () {
											var val = $.fn.dataTable.util.escapeRegex(
												$(this).val()
											);
											column
												.search(val ? '^' + val + '$' : '', true, false)
												.draw();
										});
									column.data().unique().sort().each(function (d, j) {
										select.append('<option value="' + d + '">' + d + '</option>')
									});
								});
							},
							"scrollX": true,
							"pageLength": 10,
							"order": [[0, "asc"]],
							"language": {
								"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
							},
							dom: 'Bfrtip',
							buttons: [
								{
									extend: 'copyHtml5',
									text: '<i class="fa fa-files-o"></i>',
									titleAttr: 'Copy'
								},
								{
									extend: 'excelHtml5',
									text: '<i class="fa fa-file-excel-o"></i>',
									titleAttr: 'Excel'
								},
								{
									extend: 'csvHtml5',
									text: '<i class="fa fa-file-text-o"></i>',
									titleAttr: 'CSV'
								},
								{
									extend: 'pdfHtml5',
									text: '<i class="fa fa-file-pdf-o"></i>',
									titleAttr: 'PDF'
								}
							]
						});
					});
				</script>
				<link rel="stylesheet" type="text/css" href="<?= base_url() ?>dist/css/shadowbox.css">
				<script type="text/javascript" src="<?= base_url() ?>dist/js/shadowbox.js"></script>
				<script type="text/javascript">
					Shadowbox.init();
				</script>
				<?php
	}
	public function registro_lote_contraloria_proceceso10()
	{
		$folio = array();
		$folio["variable"] = $this->registrolote_modelo->findCount();
		if ($folio <> NULL) {
			foreach ($folio as $folioUpd) {
				$folioUp = array();
				$folioUp["contador"] = $folioUpd->contador + 1;
				if ($_POST <> NULL) {
					$misDatosJSON = json_decode($_POST['datos']);
					echo '<div class="container">';
					echo '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-copy"></span> Ver Acuse</button>';
					echo '<div class="modal fade" id="myModal" role="dialog">';
					echo '<div class="modal-dialog">';
					echo '<div class="modal-content">';
					echo '<div class="modal-header">';
					echo '<button type="button" class="close" data-dismiss="modal">&times;</button>';
					echo '</div>';
					echo '<div id="seleccion">';
					echo '<div class="modal-body">';
					echo '<br>';
					echo '<span><center><strong>Contratos enviados a firma de Representante Legal</strong></span ></center>';
					echo '<span><center><strong>Acuse de Contratos</strong></span></center>';
					echo '<br>';
					echo '<br>';
					echo '<div class="modal-body"><img src="http://contratacion.gphsis.com/contratacion/static/images/CMOF.png" style="display:block;margin:auto;" width="250" height="80" />   </div>';
					echo '<br>';
					echo '<div style="text-align:right;">' . "Folio: " . ($folioUpd->contador + 1) . "<br>" . '</div>';
					echo '<div style="text-align:right;">' . "<br>" . '</div>';
					echo '<br>';
					echo '<table width="100%" border="1px" align="center" margin: 15px; padding: 15px; style = "border-collapse:collapse">';
					echo '<tr align="center">';
					echo '<th style = "border:1px solid black"><center>Cod. Lote</center></th>';
					echo '<th style = "border:1px solid black"><center>Cliente</center></th>';
					echo '<th style = "border:1px solid black"><center>Fecha de Envio</center></th>';
					echo '<th style = "border:1px solid black"><center>Gerente</center></th>';
					echo '<th style = "border:1px solid black"><center>Asesor</center></th>';
					echo '<th style = "border:1px solid black"><center>Prioridad</center></th>';
					echo '<th style = "border:1px solid black"><center>Observaciones</center></th>';
					foreach ($misDatosJSON as list($b)) {
						echo ' </tr>';
						echo ' <tr>';
						$info = array();
						$info["lotes"] = $this->registrolote_modelo->selectRegistroPorContrato($b);
						if ($info["lotes"] <> NULL) {
							foreach ($info as $fila) {
								$updateStatus10 = array();
								$updateStatus10["idStatusContratacion"] = 10;
								$updateStatus10["idMovimiento"] = 40;
								$updateStatus10["comentario"] = "Solicitud de validación de enganche y envio de contrato a RL";
								$updateStatus10["usuario"] = $this->session->userdata('usuario');
								$updateStatus10["perfil"] = $this->session->userdata('perfil');
								$updateStatus10["modificado"] = date("Y-m-d H:i:s");
								$updateStatus10["fechaSolicitudValidacion"] = date('Y-m-d H:i:s');
								$updateStatus10["fechaRL"] = date('Y-m-d H:i:s');
								$histStatus10 = array();
								$histStatus10["idStatusContratacion"] = 10;
								$histStatus10["idMovimiento"] = 40;
								$histStatus10["nombreLote"] = $fila->nombreLote;
								$histStatus10["comentario"] = "Solicitud de validación de enganche y envio de contrato a RL";
								$histStatus10["usuario"] = $this->session->userdata('usuario');
								$histStatus10["perfil"] = $this->session->userdata('perfil');
								$histStatus10["modificado"] = date("Y-m-d H:i:s");
								$histStatus10["fechaVenc"] = $fila->fechaVenc;
								$histStatus10["idLote"] = $fila->idLote;
								$histStatus10["idCondominio"] = $fila->idCondominio;
								$histStatus10["idCliente"] = $fila->id_cliente;
								$histStatus10["folioContrato"] = $folioUpd->contador + 1;
								$arrayAacuse = array();
								$arrayAacuse["primerNombre"] = $fila->nombre;
								$arrayAacuse["apellidoPaterno"] = $fila->apellido_paterno;
								$arrayAacuse["apellidoMaterno"] = $fila->apellido_materno;
								$arrayAacuse["razonSocial"] = $fila->rfc;
								$arrayAacuse["code"] = $b;
								$arrayAacuse["mod"] = date("Y-m-d H:i:s");
								$arrayAacuse["contratoUrgente"] = $fila->contratoUrgente;
								$arrayAacuse["nombreGerente"] = $fila->gerente;
								$arrayAacuse["nombreAsesor"] = $fila->asesor;
								$arrayAacuse["observacionContratoUrgente"] = $fila->observacionContratoUrgente;
								$dato3 = array();
								$dato3["numContrato"] = $b;
								$dato3["fechaRecepcion"] = date('Y-m-d H:i:s');
								if ($this->registrolote_modelo->registroStatus10($b, $updateStatus10)) {
									$this->registrolote_modelo->insertHistorialLotesContraloria($histStatus10);
									$this->registrolote_modelo->insertControlContrato($dato3);
									$this->registrolote_modelo->updateTblvariables(1, $folioUp);
								} else {
									die("ERROR");
								}
								$acuse = array();
								$i = 0;
								foreach ($arrayAacuse as $nombre) {
									$acuse[] = $nombre;
									$i++;
								}
								echo '<td style = "border:1px solid black"><center>' . $acuse[4] . "<br>" . '</center></td>';
								echo '<td style = "border:1px solid black"><center>' . $acuse[0] . " " . $acuse[1] . " " . $acuse[2] . " " . $acuse[3] . "<br>" . '</center></td>';
								echo '<td style = "border:1px solid black"><center>' . $acuse[5] . "<br>" . '</center></td>';
								echo '<td style = "border:1px solid black"><center>' . $acuse[7] . "<br>" . '</center></td>';
								echo '<td style = "border:1px solid black"><center>' . $acuse[8] . "<br>" . '</center></td>';
								if (empty($acuse[6])) {
									echo '<td style = "border:1px solid black"><center>' . "NORMAL" . "<br>" . '</center></td>';
								} else {
									echo '<td style = "border:1px solid black"><center>' . $acuse[6] . "<br>" . '</center></td>';
								}
								echo '<td style = "border:1px solid black"><center>' . $acuse[9] . "<br>" . '</center></td>';
							}
						}
					}
				} else {
					echo "No recibí datos por POST";
				}
				echo ' </tr>';
				echo '</table>';
				echo '<br>';
				echo '<br>';
				echo '<br>';
				echo '<div><h4><center>_____________________________</center></h4></div>';
				echo '<div><h4><center> Nombre, fecha y firma de quien recibe </center></h4></div>';
				echo '</div>';
				echo '</div>';
				echo '<div class="modal-footer">';
				?>
				<button onclick="javascript:imprSelec('seleccion')">Imprimir Acuse</button>
				<?php
				echo '</div>';
				echo '</div>';
				echo '</div>';
				echo '</div>';
				echo '</div>';
				?>
				<script language="Javascript">
					function imprSelec(nombre) {
						var ficha = document.getElementById(nombre);
						var ventimp = window.open(' ', 'popimpr');
						ventimp.document.write(ficha.innerHTML);
						ventimp.document.close();
						ventimp.print();
						ventimp.close();
					}
				</script>
				<?php
			}
		}
	}
	public function acuseContratosRecepcion()
	{
		$datos = array();
		$datos["acuseContratosRecepcion"] = $this->registrolote_modelo->datosControlContratos();
		if ($datos != null) {
			echo json_encode($datos);
		} else {
			echo json_encode(array());
		}
	}
	public function insertContratosFirmados()
	{
		if ($_POST <> NULL) {
			$misDatosJSON = json_decode($_POST['datos']);
			foreach ($misDatosJSON as list($b)) {
				$data = array();
				$data["lotes"] = $this->registrolote_modelo->selectRegistroPorContratoStatus12($b);
				if ($data["lotes"] <> NULL) {
					$arreglo = array();
					$arreglo["idStatusContratacion"] = 12;
					$arreglo["idMovimiento"] = 42;
					$arreglo["comentario"] = "Contrato Recibido con firma de RL";
					$arreglo["usuario"] = $this->session->userdata('usuario');
					$arreglo["perfil"] = $this->session->userdata('perfil');
					$arreglo["modificado"] = date("Y-m-d H:i:s");
					$arreglo["firmaRL"] = "FIRMADO";
					date_default_timezone_set('America/Mexico_City');
					$horaActual = date('H:i:s');
					$horaInicio = date("08:00:00");
					$horaFin = date("16:00:00");
					if ($horaActual > $horaInicio and $horaActual < $horaFin) {
						$fechaAccion = date("Y-m-d H:i:s");
						$hoy_strtotime2 = strtotime($fechaAccion);
						$sig_fecha_dia2 = date('D', $hoy_strtotime2);
						$sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
						if (
							$sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
							$sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
							$sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
							$sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
							$sig_fecha_feriado2 == "25-12"
						){
							$fecha = $fechaAccion;
							$i = 0;
							while ($i <= 0) {
								$hoy_strtotime = strtotime($fecha);
								$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
								$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
								$sig_fecha_dia = date('D', $sig_strtotime);
								$sig_fecha_feriado = date('d-m', $sig_strtotime);
								if (
									$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
									$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
									$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
									$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
									$sig_fecha_feriado == "25-12"
								) {
								} else {
									$fecha = $sig_fecha;
									$i++;
								}
								$fecha = $sig_fecha;
							}
							$arreglo["fechaVenc"] = $fecha;
						} else {
							$fecha = $fechaAccion;
							$i = 0;
							while ($i <= -1) {
								$hoy_strtotime = strtotime($fecha);
								$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
								$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
								$sig_fecha_dia = date('D', $sig_strtotime);
								$sig_fecha_feriado = date('d-m', $sig_strtotime);
								if (
									$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
									$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
									$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
									$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
									$sig_fecha_feriado == "25-12"
								) {
								} else {
									$fecha = $sig_fecha;
									$i++;
								}
								$fecha = $sig_fecha;
							}
							$arreglo["fechaVenc"] = $fecha;
						}
					} elseif ($horaActual < $horaInicio || $horaActual > $horaFin) {
						$fechaAccion = date("Y-m-d H:i:s");
						$hoy_strtotime2 = strtotime($fechaAccion);
						$sig_fecha_dia2 = date('D', $hoy_strtotime2);
						$sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
						if (
							$sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
							$sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
							$sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
							$sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
							$sig_fecha_feriado2 == "25-12"
						) {
							$fecha = $fechaAccion;
							$i = 0;
							while ($i <= 0) {
								$hoy_strtotime = strtotime($fecha);
								$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
								$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
								$sig_fecha_dia = date('D', $sig_strtotime);
								$sig_fecha_feriado = date('d-m', $sig_strtotime);
								if (
									$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
									$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
									$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
									$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
									$sig_fecha_feriado == "25-12"
								) {
								} else {
									$fecha = $sig_fecha;
									$i++;
								}
								$fecha = $sig_fecha;
							}
							$arreglo["fechaVenc"] = $fecha;
						} else {
							$fecha = $fechaAccion;
							$i = 0;
							while ($i <= 0) {
								$hoy_strtotime = strtotime($fecha);
								$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
								$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
								$sig_fecha_dia = date('D', $sig_strtotime);
								$sig_fecha_feriado = date('d-m', $sig_strtotime);
								if (
									$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
									$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
									$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
									$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
									$sig_fecha_feriado == "25-12"
								) {
								} else {
									$fecha = $sig_fecha;
									$i++;
								}
								$fecha = $sig_fecha;
							}
							$arreglo["fechaVenc"] = $fecha;
						}
					}
					$dato3 = array();
					$dato3["numContrato"] = $b;
					$dato3["fechaFirma"] = date('Y-m-d H:i:s');
					foreach ($data as $fila) {
						$dato = array();
						$dato["idStatusContratacion"] = 12;
						$dato["idMovimiento"] = 42;
						$dato["nombreLote"] = $fila->nombreLote;
						$dato["comentario"] = "Contrato Recibido con firma de RL";
						$dato["usuario"] = $this->session->userdata('usuario');
						$dato["perfil"] = $this->session->userdata('perfil');
						$dato["modificado"] = date("Y-m-d H:i:s");
						date_default_timezone_set('America/Mexico_City');
						$horaInicio = date("08:00:00");
						$horaFin = date("16:00:00");
						$arregloFechas = array();
						$fechaAccion = $fila->fechaRL;
						$hoy_strtotime2 = strtotime($fechaAccion);
						$sig_fecha_dia2 = date('D', $hoy_strtotime2);
						$sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
						$time = date('H:i:s', $hoy_strtotime2);
						if ($time > $horaInicio and $time < $horaFin) {
							if (
								$sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
								$sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
								$sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
								$sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
								$sig_fecha_feriado2 == "25-12"
							) {
								$fecha = $fechaAccion;
								$i = 0;
								while ($i <= 4) {
									$hoy_strtotime = strtotime($fecha);
									$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
									$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
									$sig_fecha_dia = date('D', $sig_strtotime);
									$sig_fecha_feriado = date('d-m', $sig_strtotime);
									if (
										$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
										$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
										$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
										$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
										$sig_fecha_feriado == "25-12"
									) {
									} else {
										$arregloFechas[$i] = $sig_fecha;
										$i++;
									}
									$fecha = $sig_fecha;
								}
								$dato["fechaVenc"] = end($arregloFechas);
							} else {
								$fecha = $fechaAccion;
								$i = 0;
								while ($i <= 3) {
									$hoy_strtotime = strtotime($fecha);
									$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
									$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
									$sig_fecha_dia = date('D', $sig_strtotime);
									$sig_fecha_feriado = date('d-m', $sig_strtotime);
									if (
										$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
										$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
										$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
										$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
										$sig_fecha_feriado == "25-12"
									) {
									} else {
										$arregloFechas[$i] = $sig_fecha;
										$i++;
									}
									$fecha = $sig_fecha;
								}
								$dato["fechaVenc"] = end($arregloFechas);
							}
						} elseif ($time < $horaInicio || $time > $horaFin) {
							if (
								$sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
								$sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
								$sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
								$sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
								$sig_fecha_feriado2 == "25-12"
							) {
								$fecha = $fechaAccion;
								$i = 0;
								while ($i <= 4) {
									$hoy_strtotime = strtotime($fecha);
									$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
									$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
									$sig_fecha_dia = date('D', $sig_strtotime);
									$sig_fecha_feriado = date('d-m', $sig_strtotime);
									if (
										$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
										$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
										$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
										$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
										$sig_fecha_feriado == "25-12"
									) {
									} else {
										$arregloFechas[$i] = $sig_fecha;
										$i++;
									}
									$fecha = $sig_fecha;
								}
								$dato["fechaVenc"] = end($arregloFechas);
							} else {
								$fecha = $fechaAccion;
								$i = 0;
								while ($i <= 4) {
									$hoy_strtotime = strtotime($fecha);
									$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
									$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
									$sig_fecha_dia = date('D', $sig_strtotime);
									$sig_fecha_feriado = date('d-m', $sig_strtotime);
									if (
										$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
										$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
										$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
										$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
										$sig_fecha_feriado == "25-12"
									) {
									} else {
										$arregloFechas[$i] = $sig_fecha;
										$i++;
									}
									$fecha = $sig_fecha;
								}
								$dato["fechaVenc"] = end($arregloFechas);
							}
						}
						$dato["idLote"] = $fila->idLote;
						$dato["idCondominio"] = $fila->idCondominio;
						$dato["idCliente"] = $fila->id_cliente;
						if ($this->registrolote_modelo->editaLoteStatus12PorNumContrato($b, $arreglo)) {
							$this->registrolote_modelo->insertHistorialLotesContraloria($dato);
							$this->registrolote_modelo->updateContratosFirmados($b, $dato3);
							echo 1;
						} else {
							die("ERROR");
							echo 0;
						}
					}
				}
			}
		} else {
			echo "No recibí datos por POST";
		}
	}
	public function editarContratoUrgente($idLote)
	{
		$datos["lotes"] = $this->registrolote_modelo->selectRegistroLoteCaja2($idLote);
		$this->load->view('editaContratoUrgente_view', $datos);
	}
	public function editar_registro_lote_contratoUrgente()
	{
		$idLote = $this->input->post('idLote');
		$contratoUrgente = $this->input->post('contratoUrgente');
		$observacionContratoUrgente = $this->input->post('observacionContratoUrgente');
		$arreglo = array();
		$arreglo["contratoUrgente"] = $contratoUrgente;
		$arreglo["observacionContratoUrgente"] = $observacionContratoUrgente;
		if ($this->registrolote_modelo->liberacion($idLote, $arreglo)) {
			redirect(base_url() . "index.php/registroLote/registrosLoteContratacion");
		} else {
			die("ERROR");
		}
	}
	function getLotesInventarioContratacion($condominio, $residencial)
	{
		$data['lotes'] = $this->registrolote_modelo->getInventario($condominio, $residencial);
		echo '<table id="tabla_inventario_gral" width ="100%" class="table table-bordered table-hover" >';
		echo '<thead>';
		echo '<tr>';
		echo '<th class="text-center">Nombre</th>';
		echo '<th class="text-center">Superficie</th>';
		echo '<th class="text-center">Precio</th>';
		echo '<th class="text-center">Total</th>';
		echo '<th class="text-center">Porcentaje</th>';
		echo '<th class="text-center">Enganche</th>';
		echo '<th class="text-center">Saldo</th>';
		echo '<th class="text-center">Al 0% </th>';
		echo '<th class="text-center">Al 1%</th>';
		echo '<th class="text-center">Referencia</th>';
		echo '<th class="text-center">Status</th>';
		echo '<th class="text-center">Liberación</th>';
		echo '<th class="text-center">Fecha Liberación</th>';
		echo '<th class="text-center">Acciones</th>';
		echo '</tr>';
		echo '<tfoot>';
		echo '<tr>';
		echo '<th class="text-center">Nombre</th>';
		echo '<th class="text-center">Superficie</th>';
		echo '<th class="text-center">Precio</th>';
		echo '<th class="text-center">Total</th>';
		echo '<th class="text-center">Porcentaje</th>';
		echo '<th class="text-center">Enganche</th>';
		echo '<th class="text-center">Saldo</th>';
		echo '<th class="text-center">Al 0% </th>';
		echo '<th class="text-center">Al 1%</th>';
		echo '<th class="text-center">Referencia</th>';
		echo '<th class="text-center">Status</th>';
		echo '<th class="text-center">Liberación</th>';
		echo '<th class="text-center">Fecha Liberación</th>';
		echo '<th class="text-center">Acciones</th>';
		echo '</tfoot>';
		echo '</tr>';
		echo '</thead>';
		echo '<tbody class="lotes">';
		setlocale(LC_MONETARY, 'en_US');
		$i = 0;
		while ($i < count($data['lotes'])) {
			echo "<tr id='" . $data['lotes'][$i]['idLote'] . "' class='resaltar'>";
			echo "<td style=text-align:center>" . $data['lotes'][$i]['nombreLote'] . "</td>";
			echo "<td style=text-align:center>" . $data['lotes'][$i]['sup'] . "</td>";
			echo "<td style=text-align:center>" . "$" . number_format($data['lotes'][$i]['precio'], 2, ".", ",") . "</td>";
			echo "<td style=text-align:center>" . "$" . number_format($data['lotes'][$i]['total'], 2, ".", ",") . "</td>";
			echo "<td style=text-align:center>" . $data['lotes'][$i]['porcentaje'] . "%" . "</td>";
			echo "<td style=text-align:center>" . "$" . number_format($data['lotes'][$i]['enganche'], 2, ".", ",") . "</td>";
			echo "<td style=text-align:center>" . "$" . number_format($data['lotes'][$i]['saldo'], 2, ".", ",") . "</td>";
			echo "<td style=text-align:center>" . "$" . number_format($data['lotes'][$i]['modalidad_1'], 2, ".", ",") . "</td>";
			echo "<td style=text-align:center>" . "$" . number_format($data['lotes'][$i]['modalidad_2'], 2, ".", ",") . "</td>";
			echo "<td style=text-align:center>" . $data['lotes'][$i]['referencia'] . "</td>";
			echo "<td style=text-align:center>" . $data['lotes'][$i]['nombre'] . "</td>";
			echo "<td style=text-align:center>" . $data['lotes'][$i]['comentarioLiberacion'] . "</td>";
			echo "<td style=text-align:center>" . $data['lotes'][$i]['fechaLiberacion'] . "</td>";
			echo "<td style=text-align:center>
			<a href='" . 'historial_liberacion/' . $data['lotes'][$i]['idLote'] . "' rel='shadowbox[Vacation];width=700;height=440'> 
			<img src='http://contratacion.sisgph.com/contratacion/static/images/historialLiberacion.png' width='25' height='23' title = 'Historial Liberación'/>
			</a>
			<a href='" . 'historialProcesoLote/' . $data['lotes'][$i]['idLote'] . "' rel='shadowbox[Vacation];width=700;height=440'><img src='http://contratacion.sisgph.com/contratacion/static/images/registrarStatus.png' width='25' height='23' title = 'Historial Proceso de contratación'>  
			</a>
			<a href='" . 'editarContratoUrgente/' . $data['lotes'][$i]['idLote'] . "'><img src='http://contratacion.sisgph.com/contratacion/static/images/confir.png' width='25' height='23' title = 'Contrato Urgente'>  
			</a>
			</td>";
			$i++;
		}
		echo '</tbody>';
		echo '</table>';
		?>
			<style>
				th, td {
					white-space: nowrap;
				}
				tr {
					height: 50px;
				}
			</style>
			<script type="text/javascript">
				$(document).ready(function () {
					$('#tabla_inventario_gral').dataTable({
						initComplete: function () {
							this.api().columns().every(function () {
								var column = this;
								var select = $('<select><option value=""></option></select>')
									.appendTo($(column.footer()).empty())
									.on('change', function () {
										var val = $.fn.dataTable.util.escapeRegex(
											$(this).val()
										);
										column
											.search(val ? '^' + val + '$' : '', true, false)
											.draw();
									});
								column.data().unique().sort().each(function (d, j) {
									select.append('<option value="' + d + '">' + d + '</option>')
								});
							});
						},
						"scrollX": true,
						"pageLength": 10,
						"order": [[0, "asc"]],
						"language": {
							"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
						},
						dom: 'Bfrtip',
						buttons: [
							{
								extend: 'copyHtml5',
								text: '<i class="fa fa-files-o"></i>',
								titleAttr: 'Copy'
							},
							{
								extend: 'excelHtml5',
								text: '<i class="fa fa-file-excel-o"></i>',
								titleAttr: 'Excel'
							},
							{
								extend: 'csvHtml5',
								text: '<i class="fa fa-file-text-o"></i>',
								titleAttr: 'CSV'
							},
							{
								extend: 'pdfHtml5',
								text: '<i class="fa fa-file-pdf-o"></i>',
								titleAttr: 'PDF'
							}
						]
					});
				});
			</script>
			<link rel="stylesheet" type="text/css" href="<?= base_url() ?>dist/css/shadowbox.css">
			<script type="text/javascript" src="<?= base_url() ?>dist/js/shadowbox.js"></script>
			<script type="text/javascript">
				Shadowbox.init();
			</script>
			<?php
	}
	public function editarLoteRechazoAstatus2StatusContratacion8($idLote)
	{
		$datos = array();
		$datos["lotes"] = $this->registrolote_modelo->selectRegistroLoteCaja($idLote);
		$this->load->view('editar_loteRechazoAstatus2_asistentes_proceso8_view', $datos);
	}
	public function editar_registro_loteRechazoAstatus2_asistentes_proceceso8()
	{
		$idLote = $this->input->post('idLote');
		$idCondominio = $this->input->post('idCondominio');
		$nombreLote = $this->input->post('nombreLote');
		$idStatusContratacion = $this->input->post('idStatusContratacion');
		$idMovimiento = $this->input->post('idMovimiento');
		$idCliente = $this->input->post('idCliente');
		$comentario = $this->input->post('comentario');
		$user = $this->input->post('user');
		$perfil = $this->input->post('perfil');
		$modificado = date("Y-m-d H:i:s");
		$arreglo = array();
		$arreglo["idStatusContratacion"] = 1;
		$arreglo["idMovimiento"] = 73;
		$arreglo["comentario"] = $comentario;
		$arreglo["user"] = $this->session->userdata('username');
		$arreglo["perfil"] = $this->session->userdata('perfil');
		$arreglo["modificado"] = date("Y-m-d H:i:s");
		$arreglo2 = array();
		$arreglo2["idStatusContratacion"] = 1;
		$arreglo2["idMovimiento"] = 73;
		$arreglo2["nombreLote"] = $nombreLote;
		$arreglo2["comentario"] = $comentario;
		$arreglo2["user"] = $this->session->userdata('username');
		$arreglo2["perfil"] = $this->session->userdata('perfil');
		$arreglo2["modificado"] = date("Y-m-d H:i:s");
		$arreglo2["fechaVenc"] = $modificado;
		$arreglo2["idLote"] = $idLote;
		$arreglo2["idCondominio"] = $idCondominio;
		$arreglo2["idCliente"] = $idCliente;
		if ($this->registrolote_modelo->editaRegistroLoteCaja($idLote, $arreglo)) {
			$this->registrolote_modelo->insertHistorialLotes($arreglo2);
			redirect(base_url() . "index.php/registroLote/registroStatus8ContratacionAsistentes");
		} else {
			die("ERROR");
		}
	}
	public function editarLoteRevisionEliteStatus2aContraloria5($idLote)
	{
		$datos = array();
		$datos["lotes"] = $this->registrolote_modelo->selectRegistroLoteCaja($idLote);
		$datos["asistentesStatus2"] = $this->registrolote_modelo->getAsistentesStatus2();
		$this->load->view('editar_loteRevision_elite_proceso2aContraloria5_view', $datos);
	}
	public function editar_registro_loteRevision_eliteAcontraloria5_proceceso2()
	{
		$idLote = $this->input->post('idLote');
		$idCondominio = $this->input->post('idCondominio');
		$nombreLote = $this->input->post('nombreLote');
		$idStatusContratacion = $this->input->post('idStatusContratacion');
		$idMovimiento = $this->input->post('idMovimiento');
		$idCliente = $this->input->post('idCliente');
		$comentario = $this->input->post('comentario');
		$user = $this->input->post('user');
		$perfil = $this->input->post('perfil');
		$modificado = date('Y-m-d H:i:s');
		$fechaVenc = $this->input->post('fechaVenc');
		$arreglo = array();
		$arreglo["idStatusContratacion"] = $idStatusContratacion;
		$arreglo["idMovimiento"] = 74;
		$arreglo["comentario"] = $comentario;
		$arreglo["user"] = $this->session->userdata('username');
		$arreglo["perfil"] = $this->session->userdata('perfil');
		$arreglo["modificado"] = date("Y-m-d H:i:s");
		$arreglo2 = array();
		$arreglo2["idStatusContratacion"] = $idStatusContratacion;
		$arreglo2["idMovimiento"] = 74;
		$arreglo2["nombreLote"] = $nombreLote;
		$arreglo2["comentario"] = $comentario;
		$arreglo2["user"] = $this->session->userdata('username');
		$arreglo2["perfil"] = $this->session->userdata('perfil');
		$arreglo2["modificado"] = date("Y-m-d H:i:s");
		$arreglo2["fechaVenc"] = $fechaVenc;
		$arreglo2["idLote"] = $idLote;
		$arreglo2["idCondominio"] = $idCondominio;
		$arreglo2["idCliente"] = $idCliente;
		if ($this->registrolote_modelo->editaRegistroLoteCaja($idLote, $arreglo)) {
			$this->registrolote_modelo->insertHistorialLotes($arreglo2);
			redirect(base_url() . "index.php/registroLote/registroStatusContratacionAsistentes2");
		} else {
			die("ERROR");
		}
	}
	public function editarLoteRevisionContraloriaStatus5aContraloria6($idLote)
	{
		$datos = array();
		$datos["lotes"] = $this->registrolote_modelo->selectRegistroLoteCaja($idLote);
		$datos["contraloriaStatus5"] = $this->registrolote_modelo->getContraloriaStatus5();
		$this->load->view('editar_loteRevision_contraloria_proceso5aContraloria6_view', $datos);
	}
	public function editar_registro_loteRevision_contraloria5_Acontraloria6()
	{
		$idLote = $this->input->post('idLote');
		$idCondominio = $this->input->post('idCondominio');
		$nombreLote = $this->input->post('nombreLote');
		$idStatusContratacion = $this->input->post('idStatusContratacion');
		$idMovimiento = $this->input->post('idMovimiento');
		$idCliente = $this->input->post('idCliente');
		$comentario = $this->input->post('comentario');
		$user = $this->input->post('user');
		$perfil = $this->input->post('perfil');
		$modificado = date('Y-m-d H:i:s');
		$fechaVenc = $this->input->post('fechaVenc');
		$arreglo = array();
		$arreglo["idStatusContratacion"] = $idStatusContratacion;
		$arreglo["idMovimiento"] = 75;
		$arreglo["comentario"] = $comentario;
		$arreglo["usuario"] = $this->session->userdata('usuario');
		$arreglo["perfil"] = $this->session->userdata('perfil');
		$arreglo["modificado"] = date("Y-m-d H:i:s");
		$arreglo2 = array();
		$arreglo2["idStatusContratacion"] = $idStatusContratacion;
		$arreglo2["idMovimiento"] = 75;
		$arreglo2["nombreLote"] = $nombreLote;
		$arreglo2["comentario"] = $comentario;
		$arreglo2["usuario"] = $this->session->userdata('usuario');
		$arreglo2["perfil"] = $this->session->userdata('perfil');
		$arreglo2["modificado"] = date("Y-m-d H:i:s");
		$arreglo2["fechaVenc"] = $fechaVenc;
		$arreglo2["idLote"] = $idLote;
		$arreglo2["idCondominio"] = $idCondominio;
		$arreglo2["idCliente"] = $idCliente;
		if ($this->registrolote_modelo->editaRegistroLoteCaja($idLote, $arreglo)) {
			$this->registrolote_modelo->insertHistorialLotes($arreglo2);
			echo 1;
		} else {
			echo 0;
			die("ERROR");
		}
	}
	public function editarLoteRevisionContraloriaStatus6aJuridico7($idLote)
	{
		$datos = array();
		$datos["lotes"] = $this->registrolote_modelo->selectRegistroLoteCaja($idLote);
		$datos["contraloriaStatus6"] = $this->registrolote_modelo->getContraloriaStatus6();
		$this->load->view('editar_loteRevision_contraloria_proceso6aJuridico7_view', $datos);
	}
	public function editar_registro_loteRevision_contraloria6_AJuridico7()
	{
		$idLote = $this->input->post('idLote');
		$idCondominio = $this->input->post('idCondominio');
		$nombreLote = $this->input->post('nombreLote');
		$idStatusContratacion = $this->input->post('idStatusContratacion');
		$idMovimiento = $this->input->post('idMovimiento');
		$idCliente = $this->input->post('idCliente');
		$comentario = $this->input->post('comentario');
		$user = $this->input->post('user');
		$perfil = $this->input->post('perfil');
		$modificado = date('Y-m-d H:i:s');
		$fechaVenc = $this->input->post('fechaVenc');
		$arreglo = array();
		$arreglo["idStatusContratacion"] = $idStatusContratacion;
		$arreglo["idMovimiento"] = 76;
		$arreglo["comentario"] = $comentario;
		$arreglo["usuario"] = $this->session->userdata('usuario');
		$arreglo["perfil"] = $this->session->userdata('perfil');
		$arreglo["modificado"] = date("Y-m-d H:i:s");
		$arreglo2 = array();
		$arreglo2["idStatusContratacion"] = $idStatusContratacion;
		$arreglo2["idMovimiento"] = 76;
		$arreglo2["nombreLote"] = $nombreLote;
		$arreglo2["comentario"] = $comentario;
		$arreglo2["usuario"] = $this->session->userdata('usuario');
		$arreglo2["perfil"] = $this->session->userdata('perfil');
		$arreglo2["modificado"] = date("Y-m-d H:i:s");
		$arreglo2["fechaVenc"] = $fechaVenc;
		$arreglo2["idLote"] = $idLote;
		$arreglo2["idCondominio"] = $idCondominio;
		$arreglo2["idCliente"] = $idCliente;
		if ($this->registrolote_modelo->editaRegistroLoteCaja($idLote, $arreglo)) {
			$this->registrolote_modelo->insertHistorialLotes($arreglo2);
			echo 1;
		} else {
			echo 0;
			die("ERROR");
		}
	}
	public function editarLoteRevisionJuridicoStatus7aStatus8($idLote)
	{
		$datos = array();
		$datos["lotes"] = $this->registrolote_modelo->selectRegistroLoteCaja($idLote);
		$datos["juridicoStatus7"] = $this->registrolote_modelo->getJuridicoStatus7();
		if ($datos != null) {
			echo json_encode($datos);
		} else {
			echo json_encode(array());
		}
	}
	public function editar_registro_loteRevision_juridico7_Asistentes8()
	{
		$idLote = $this->input->post('idLote');
		$idCondominio = $this->input->post('idCondominio');
		$nombreLote = $this->input->post('nombreLote');
		$idStatusContratacion = $this->input->post('idStatusContratacion');
		$idMovimiento = $this->input->post('idMovimiento');
		$idCliente = $this->input->post('idCliente');
		$comentario = $this->input->post('comentario');
		$user = $this->input->post('user');
		$perfil = $this->input->post('perfil');
		$modificado = date('Y-m-d H:i:s');
		$fechaVenc = $this->input->post('fechaVenc');
		$aleatorio = rand();
		$contratoArchivo = $idCliente . '_' . $aleatorio . '_' . $_FILES["contratoArchivo"]["name"];
		$arreglo = array();
		$arreglo["idStatusContratacion"] = $idStatusContratacion;
		$arreglo["idMovimiento"] = 77;
		$arreglo["comentario"] = $comentario;
		$arreglo["user"] = $this->session->userdata('username');
		$arreglo["perfil"] = $this->session->userdata('perfil');
		$arreglo["modificado"] = date("Y-m-d H:i:s");
		$arreglo["contratoArchivo"] = $idCliente . '_' . $aleatorio . '_' . $_FILES["contratoArchivo"]["name"];
		$arreglo2 = array();
		$arreglo2["idStatusContratacion"] = $idStatusContratacion;
		$arreglo2["idMovimiento"] = 77;
		$arreglo2["nombreLote"] = $nombreLote;
		$arreglo2["comentario"] = $comentario;
		$arreglo2["user"] = $this->session->userdata('username');
		$arreglo2["perfil"] = $this->session->userdata('perfil');
		$arreglo2["modificado"] = date("Y-m-d H:i:s");
		$arreglo2["fechaVenc"] = $fechaVenc;
		$arreglo2["idLote"] = $idLote;
		$arreglo2["idCondominio"] = $idCondominio;
		$arreglo2["idCliente"] = $idCliente;
		if ($this->registrolote_modelo->editaRegistroLoteCaja($idLote, $arreglo)) {
			$this->registrolote_modelo->insertHistorialLotes($arreglo2);
			if (move_uploaded_file($_FILES["contratoArchivo"]["tmp_name"], "static/documentos/cliente/contrato/" . $idCliente . '_' . $aleatorio . '_' . $_FILES["contratoArchivo"]["name"])) {
				redirect(base_url() . "index.php/registroLote/registroStatus7ContratacionJuridico");
			}
		} else {
			die("ERROR");
		}
	}
	public function getHistorialProceso()
	{
		$this->load->view('template/header');
		$this->load->view('contratacion/report_historial_view');
	}
	public function getHistProcData()
	{
		if (isset($_POST) && !empty($_POST)) {
			$typeTransaction = $this->input->post("typeTransaction");
            $fechaInicio = explode('/', $this->input->post("beginDate"));
            $fechaFin = explode('/', $this->input->post("endDate"));
            $beginDate = date("Y-m-d", strtotime("{$fechaInicio[2]}-{$fechaInicio[1]}-{$fechaInicio[0]}"));
            $endDate = date("Y-m-d", strtotime("{$fechaFin[2]}-{$fechaFin[1]}-{$fechaFin[0]}"));
            $where = $this->input->post("where");
			$data['data'] = $this->registrolote_modelo->report($typeTransaction, $beginDate, $endDate, $where)->result_array();
			echo json_encode($data);
		} else {
			json_encode(array());
		}
	}
	public function generarCorrida()
	{
		$datos = array();
		$datos["residencial"] = $this->registrolote_modelo->getResidencialQro();
		$this->load->view("corrida_view", $datos);
	}
	function getLotesCorrida($condominio, $residencial)
	{
		$data['lotes'] = $this->registrolote_modelo->getInventarioDis($condominio, $residencial);
		echo '<table id="tabla_lotes_corrida" width ="100%" class="table table-bordered table-hover" >';
		echo '<thead>';
		echo '<tr>';
		echo '<th class="text-center">Nombre</th>';
		echo '<th class="text-center">Superficie</th>';
		echo '<th class="text-center">Precio</th>';
		echo '<th class="text-center">Total</th>';
		echo '<th class="text-center">Porcentaje</th>';
		echo '<th class="text-center">Enganche</th>';
		echo '<th class="text-center">Saldo</th>';
		echo '<th class="text-center">Al 0% </th>';
		echo '<th class="text-center">Al 1%</th>';
		echo '<th class="text-center">Referencia</th>';
		echo '<th class="text-center">Status</th>';
		echo '<th class="text-center">Liberación</th>';
		echo '<th class="text-center">Fecha Liberación</th>';
		echo '<th class="text-center">Acciones</th>';
		echo '</tr>';
		echo '<tfoot>';
		echo '<tr>';
		echo '<th class="text-center">Nombre</th>';
		echo '<th class="text-center">Superficie</th>';
		echo '<th class="text-center">Precio</th>';
		echo '<th class="text-center">Total</th>';
		echo '<th class="text-center">Porcentaje</th>';
		echo '<th class="text-center">Enganche</th>';
		echo '<th class="text-center">Saldo</th>';
		echo '<th class="text-center">Al 0% </th>';
		echo '<th class="text-center">Al 1%</th>';
		echo '<th class="text-center">Referencia</th>';
		echo '<th class="text-center">Status</th>';
		echo '<th class="text-center">Liberación</th>';
		echo '<th class="text-center">Fecha Liberación</th>';
		echo '<th class="text-center">Acciones</th>';
		echo '</tfoot>';
		echo '</tr>';
		echo '</thead>';
		echo '<tbody class="lotes">';
		setlocale(LC_MONETARY, 'en_US');
		$i = 0;
		while ($i < count($data['lotes'])) {
			echo "<tr id='" . $data['lotes'][$i]['idLote'] . "' class='resaltar'>";
			echo "<td style=text-align:center>" . $data['lotes'][$i]['nombreLote'] . "</td>";
			echo "<td style=text-align:center>" . $data['lotes'][$i]['sup'] . "</td>";
			echo "<td style=text-align:center>" . "$" . number_format($data['lotes'][$i]['precio'], 2, ".", ",") . "</td>";
			echo "<td style=text-align:center>" . "$" . number_format($data['lotes'][$i]['total'], 2, ".", ",") . "</td>";
			echo "<td style=text-align:center>" . $data['lotes'][$i]['porcentaje'] . "%" . "</td>";
			echo "<td style=text-align:center>" . "$" . number_format($data['lotes'][$i]['enganche'], 2, ".", ",") . "</td>";
			echo "<td style=text-align:center>" . "$" . number_format($data['lotes'][$i]['saldo'], 2, ".", ",") . "</td>";
			echo "<td style=text-align:center>" . "$" . number_format($data['lotes'][$i]['modalidad_1'], 2, ".", ",") . "</td>";
			echo "<td style=text-align:center>" . "$" . number_format($data['lotes'][$i]['modalidad_2'], 2, ".", ",") . "</td>";
			echo "<td style=text-align:center>" . $data['lotes'][$i]['referencia'] . "</td>";
			echo "<td style=text-align:center>" . $data['lotes'][$i]['nombre'] . "</td>";
			echo "<td style=text-align:center>" . $data['lotes'][$i]['comentarioLiberacion'] . "</td>";
			echo "<td style=text-align:center>" . $data['lotes'][$i]['fechaLiberacion'] . "</td>";
			echo "<td style=text-align:center>
			<a href='" . 'make_corrida/' . $data['lotes'][$i]['idLote'] . "''> 
			<img src='http://contratacion.sisgph.com/contratacion/static/images/solicitud.png' width='25' height='23' title = 'Corrida Financiera'/;
			</a>
			</td>";
			$i++;
		}
		echo '</tbody>';
		echo '</table>';
		?>
		<style>
			th, td {
				white-space: nowrap;
			}
			tr {
				height: 50px;
			}
		</style>
		<script type="text/javascript">
			$(document).ready(function () {
				$('#tabla_lotes_corrida').dataTable({
					initComplete: function () {
						this.api().columns().every(function () {
							var column = this;
							var select = $('<select><option value=""></option></select>')
								.appendTo($(column.footer()).empty())
								.on('change', function () {
									var val = $.fn.dataTable.util.escapeRegex(
										$(this).val()
									);
									column
										.search(val ? '^' + val + '$' : '', true, false)
										.draw();
								});
							column.data().unique().sort().each(function (d, j) {
								select.append('<option value="' + d + '">' + d + '</option>')
							});
						});
					},
					"scrollX": true,
					"pageLength": 10,
					"language": {
						"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
					},
					dom: 'Bfrtip',
					buttons: [
						{
							extend: 'copyHtml5',
							text: '<i class="fa fa-files-o"></i>',
							titleAttr: 'Copy'
						},
						{
							extend: 'excelHtml5',
							text: '<i class="fa fa-file-excel-o"></i>',
							titleAttr: 'Excel'
						},
						{
							extend: 'csvHtml5',
							text: '<i class="fa fa-file-text-o"></i>',
							titleAttr: 'CSV'
						},
						{
							extend: 'pdfHtml5',
							text: '<i class="fa fa-file-pdf-o"></i>',
							titleAttr: 'PDF'
						}
					]
				});
			});
		</script>
		<link rel="stylesheet" type="text/css" href="<?= base_url() ?>dist/css/shadowbox.css">
		<script type="text/javascript" src="<?= base_url() ?>dist/js/shadowbox.js"></script>
		<script type="text/javascript">
			Shadowbox.init();
		</script>
		<?php
	}
	public function make_corrida($idLote)
	{
		$datos["gerentes"] = $this->registrolote_modelo->getGerente();
		$datos["lotes"] = $this->registrolote_modelo->selectLoteCorrida($idLote);
		$datos["descuentos"] = $this->registrolote_modelo->registroDesc($idLote);
		$this->load->view('edit_corrida', $datos);
	}
	public function genera_corrida()
	{
		$plan = $this->input->post('plan');
		if ($plan == 1) {
			$años = $this->input->post('años');
			$sup = $this->input->post('sup');
			$precio = $this->input->post('precio');
			$total = $this->input->post('total');
			$diasEnganche = $this->input->post('diasEnganche');
			$ahorro = $this->input->post('ahorro');
			$nombreLote = $this->input->post('nombreLoteLabel');
			$cliente = $this->input->post('cliente');
			$tel = $this->input->post('tel');
			$edad = $this->input->post('edadVal');
			$email = $this->input->post('email');
			$asesor = $this->input->post('filtro2');
			$sup = $this->input->post('sup');
			$idLote = $this->input->post('idLote');
			$msni = $this->input->post('msni');
			$referencia = $this->input->post('referencia');
			$prontoPagoOk = 7;
			$prontoPagoNo = 25;
			$empresa = $this->input->post('empresa');
			$banco = $this->input->post('banco');
			$cuenta = $this->input->post('cuenta');
			$clabe = $this->input->post('clabe');
			$idDescuentoAd = $this->input->post('idDescuentoAd');
			$idDescuentopp = $this->input->post('idDescuentopp');
			$idDescuentoAd2 = $this->input->post('idDescuentoAd2');
			$descSup1 = $this->input->post('descSup1');
			$descSup2 = $this->input->post('descSup2');
			$cantidadEnganche = $this->input->post('cantidadEnganche');
			$engancheOne = $this->input->post('engancheOne');
			$bonoOpcion1 = $this->input->post('bonoOpcion1');
			$heyys = array();
			if (isset($_POST['idDescuentoAd'])) {
				$heyys["descuentosAdicionales"] = $this->registrolote_modelo->getDescuentosAdicionales($idDescuentoAd);
			} elseif (!isset($_POST['idDescuentoAd'])) {
				$heyys["descuentosAdicionales"] = NULL;
			}
			if (isset($_POST['idDescuentopp'])) {
				$heyys["descuentosPP"] = $this->registrolote_modelo->getDescuentosPP($idDescuentopp);
				$heyys["prontopagodias"] = $prontoPagoOk;
			} elseif (!isset($_POST['idDescuentopp'])) {
				$heyys["prontopagodias"] = $prontoPagoNo;
				$heyys["descuentosPP"] = NULL;
			}
			if (isset($_POST['idDescuentoAd2'])) {
				$heyys["descuentosPP2"] = $this->registrolote_modelo->getDescuentosAdicionales($idDescuentoAd2);
			} elseif (!isset($_POST['idDescuentoAd2'])) {
				$heyys["descuentosPP2"] = NULL;
			}
			$heyys["años"] = $años;
			$heyys["sup"] = $sup;
			$heyys["precio"] = $precio;
			$heyys["total"] = $total;
			$heyys["sup"] = $sup;
			$heyys["nombreLote"] = $nombreLote;
			$heyys["cliente"] = $cliente;
			$heyys["tel"] = $tel;
			$heyys["edad"] = $edad;
			$heyys["email"] = $email;
			$heyys["asesor"] = $asesor;
			$heyys["msni"] = $msni;
			$heyys["referencia"] = $referencia;
			$heyys["empresa"] = $empresa;
			$heyys["banco"] = $banco;
			$heyys["cuenta"] = $cuenta;
			$heyys["clabe"] = $clabe;
			$heyys["engancheOne"] = $engancheOne;
			if (isset($_POST['cantidadEnganche'])) {
				$heyys["cantidadEnganche"] = $cantidadEnganche;
			} else {
				$heyys["cantidadEnganche"] = NULL;
			}
			if (isset($_POST['descSup1'])) {
				$heyys["descSup1"] = $descSup1;
			} else {
				$heyys["descSup1"] = NULL;
			}
			if (isset($_POST['descSup2'])) {
				$heyys["descSup2"] = $descSup2;
			} else {
				$heyys["descSup2"] = NULL;
			}
			if (isset($_POST['bonoOpcion1'])) {
				$heyys["bonoOpcion1"] = $bonoOpcion1;
			} else {
				$heyys["bonoOpcion1"] = 0;
			}
			$heyys["plan"] = $plan;
			$this->load->view('corridaCM_view', $heyys);
		} else if ($plan == 2) {
			$años = 0;
			$sup = $this->input->post('sup');
			$precio = $this->input->post('precio');
			$total = $this->input->post('total');
			$diasEnganche = $this->input->post('diasEnganche');
			$ahorro = $this->input->post('ahorro');
			$nombreLote = $this->input->post('nombreLoteLabel');
			$cliente = $this->input->post('cliente');
			$tel = $this->input->post('tel');
			$edad = $this->input->post('edadVal');
			$email = $this->input->post('email');
			$asesor = $this->input->post('filtro2');
			$sup = $this->input->post('sup');
			$idLote = $this->input->post('idLote');
			$msni = $this->input->post('msni');
			$referencia = $this->input->post('referencia');
			$empresa = $this->input->post('empresa');
			$banco = $this->input->post('banco');
			$cuenta = $this->input->post('cuenta');
			$clabe = $this->input->post('clabe');
			$idDescuentoAd = $this->input->post('idDescuentoAd');
			$idDescuentopp = $this->input->post('idDescuentopp');
			$idDescuentoAd2 = $this->input->post('idDescuentoAd2');
			$descSup1 = $this->input->post('descSup1');
			$descSup2 = $this->input->post('descSup2');
			$cantidadEnganche = $this->input->post('cantidadEnganche');
			$engancheOne = $this->input->post('engancheOne');
			$bonoOpcion1 = $this->input->post('bonoOpcion1');
			$heyys = array();
			if (isset($_POST['idDescuentoAd'])) {
				$heyys["descuentosAdicionales"] = $this->registrolote_modelo->getDescuentosAdicionales($idDescuentoAd);
			} elseif (!isset($_POST['idDescuentoAd'])) {
				$heyys["descuentosAdicionales"] = NULL;
			}
			if (isset($_POST['idDescuentopp'])) {
				$heyys["descuentosPP"] = $this->registrolote_modelo->getDescuentosPP($idDescuentopp);
				$heyys["prontopagodias"] = 'N/A';
			} elseif (!isset($_POST['idDescuentopp'])) {
				$heyys["prontopagodias"] = 'N/A';
				$heyys["descuentosPP"] = NULL;
			}
			if (isset($_POST['idDescuentoAd2'])) {
				$heyys["descuentosPP2"] = $this->registrolote_modelo->getDescuentosAdicionales($idDescuentoAd2);
			} elseif (!isset($_POST['idDescuentoAd2'])) {
				$heyys["descuentosPP2"] = NULL;
			}
			$heyys["años"] = $años;
			$heyys["sup"] = $sup;
			$heyys["precio"] = $precio;
			$heyys["total"] = $total;
			$heyys["sup"] = $sup;
			$heyys["nombreLote"] = $nombreLote;
			$heyys["cliente"] = $cliente;
			$heyys["tel"] = $tel;
			$heyys["edad"] = $edad;
			$heyys["email"] = $email;
			$heyys["asesor"] = $asesor;
			$heyys["msni"] = $msni;
			$heyys["referencia"] = $referencia;
			$heyys["empresa"] = $empresa;
			$heyys["banco"] = $banco;
			$heyys["cuenta"] = $cuenta;
			$heyys["clabe"] = $clabe;
			$heyys["engancheOne"] = $engancheOne;
			if (isset($_POST['cantidadEnganche'])) {
				$heyys["cantidadEnganche"] = $cantidadEnganche;
			} else {
				$heyys["cantidadEnganche"] = NULL;
			}
			if (isset($_POST['descSup1'])) {
				$heyys["descSup1"] = $descSup1;
			} else {
				$heyys["descSup1"] = NULL;
			}
			if (isset($_POST['descSup2'])) {
				$heyys["descSup2"] = $descSup2;
			} else {
				$heyys["descSup2"] = NULL;
			}
			if (isset($_POST['bonoOpcion1'])) {
				$heyys["bonoOpcion1"] = $bonoOpcion1;
			} else {
				$heyys["bonoOpcion1"] = 0;
			}
			$heyys["plan"] = $plan;
			$this->load->view('corridaCM_view', $heyys);
		}
	}
	public function create_descuento()
	{
		$datos["descuentosadicionales"] = $this->registrolote_modelo->arrayDescad();
		$datos["descuentospp"] = $this->registrolote_modelo->arrayDescpp();
		$datos["descuentosPack"] = $this->registrolote_modelo->arrayPackDesc();
		$datos["tbldescuentopp"] = $this->registrolote_modelo->tblDescpp();
		$datos["tbldescuentops"] = $this->registrolote_modelo->tblDescps();
		$datos["residencial"] = $this->registrolote_modelo->getResidencial();
		$datos["tbldescuentoAd"] = $this->registrolote_modelo->tblDescAd();
		$this->load->view("descuentos_view", $datos);
	}
	public function editar_registro_desc()
	{
		$id_descuento = $this->input->post('id_descuento');
		$residencial = $this->input->post('residencial');
		$motivo = $this->input->post('motivo');
		$motivo_otro = $this->input->post('motivo_otro');
		$porcentaje = $this->input->post('porcentaje');
		$sup1 = $this->input->post('sup1');
		$sup2 = $this->input->post('sup2');
		$fecha_inicio = $this->input->post('fecha_inicio');
		$fecha_fin = $this->input->post('fecha_fin');
		$arreglo = array();
		$arreglo["residencial"] = $residencial;
		$arreglo["motivo"] = $motivo;
		$arreglo["motivo_otro"] = $motivo_otro;
		$arreglo["porcentaje"] = $porcentaje;
		$arreglo["sup1"] = $sup1;
		$arreglo["sup2"] = $sup2;
		$arreglo["fecha_inicio"] = $fecha_inicio;
		$arreglo["fecha_fin"] = $fecha_fin;
		if ($this->registrolote_modelo->editaDesc($id_descuento, $arreglo)) {
			redirect(base_url() . "index.php/registroLote/create_descuento");
		} else {
			die("ERROR");
		}
	}
	public function editarDesc($id_descuento)
	{
		$datos = array();
		$datos["descuentos"] = $this->registrolote_modelo->selectDesc($id_descuento);
		$this->load->view('editar_descuento', $datos);
	}
	public function eliminarDesc()
	{
		$id_descuento = $this->input->post('id_descuento');
		if ($this->registrolote_modelo->eliminaDesc($id_descuento)) {
			redirect(base_url() . "index.php/registroLote/create_descuento");
		}
	}
	public function getReportContratados()
	{
		$this->load->view('template/header');
		$this->load->view('juridico/historialContratadorReporte_view');
	}
	public function getReportData(){

		if (isset($_POST) && !empty($_POST)) {
			$typeTransaction = $this->input->post("typeTransaction");
			$fechaInicio = explode('/', $this->input->post("beginDate"));
            $fechaFin = explode('/', $this->input->post("endDate"));
            $beginDate = date("Y-m-d", strtotime("{$fechaInicio[2]}-{$fechaInicio[1]}-{$fechaInicio[0]}"));
            $endDate = date("Y-m-d", strtotime("{$fechaFin[2]}-{$fechaFin[1]}-{$fechaFin[0]}"));
			$where = $this->input->post("where");
			$data['data'] = $this->registrolote_modelo->reportContratados($typeTransaction, $beginDate, $endDate, $where)->result_array();
			echo json_encode($data);
		} else {
			json_encode(array());
		}
	}
	public function getDateToday()
	{
		date_default_timezone_set("America/Mexico_City");
		$dias = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado");
		$meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
		$fechaHoy = $dias[date('w')] . " " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y');
		echo $fechaHoy;
	}
	public function sendApartados_old()
	{
		$datos["sendApartados_old"] = $this->registrolote_modelo->sendMailApartadosOld15();
		$para = "rigel.silva@prohabitacion.com";
		$asunto = "Lotes con mas de 15 días" . " " . date("Y-m-d H:i:s");
		$proyecto = "";
		$condominio = "";
		$lote = "";
		$cabeceras = "MIME-Version: 1.0 \r\n";
		$cabeceras = "CC: delia.cdmaderas@gmail.com\r\n";
		$cabeceras .= "Content-type: text/html; charset=utf-8 \r\n";
		$mensaje = "
		<style type='text/css'>
		table {  color: #333; border-collapse: collapse;}
		td, th { border: 20px solid transparent; height: 30px; }
		th { background: #D3D3D3; font-weight: bold; }
		td { background: #FAFAFA; text-align: center; }
		tr:nth-child(even) td { background: #F1F1F1; }  
		tr:nth-child(odd) td { background: #FEFEFE; } 
		tr td:hover { background: #666; color: #FFF; }
		</style>
		<h4><center>Lotes con 15 días en Integración de Expediente:</center></h4>
		<center><table id='reporyt' cellpadding='0' cellspacing='0' border='1' width ='50%' style class='darkheader'>
		<tr class='active'>
			<th >Proyecto</th>
			<th>Condominio</th> 
			<th>Lote</th>
			<th>Cliente</th>
		</tr>";
				foreach ($datos["sendApartados_old"] as $row_cliente) {
					$mensaje .= "
		<tr>   
				<td> " . $row_cliente->nombreResidencial . " </td>
				<td> " . $row_cliente->nombre . " </td>
				<td> " . $row_cliente->nombreLote . " </td>
				<td> " . $row_cliente->primerNombre . " " . $row_cliente->segundoNombre . " " . $row_cliente->apellidoPaterno . " " . $row_cliente->apellidoMaterno . " " . $row_cliente->razonSocial . " </td>
		</tr>
		";
		}
		$mensaje .= "
 		 </table></center>";
		mail($para, $asunto, utf8_decode($mensaje), $cabeceras);
	}
	public function sendApartados_old7()
	{
		$datos["sendApartados_old"] = $this->registrolote_modelo->sendMailApartadosOld7();
		$para = "rigel.silva@prohabitacion.com";
		$asunto = "Lotes con mas de 7 días" . " " . date("Y-m-d H:i:s");
		$proyecto = "";
		$condominio = "";
		$lote = "";
		$cabeceras = "MIME-Version: 1.0 \r\n";
		$cabeceras = "CC: delia.cdmaderas@gmail.com\r\n";
		$cabeceras .= "Content-type: text/html; charset=utf-8 \r\n";
		$mensaje = "
		<style type='text/css'>
		table {  color: #333; border-collapse: collapse;}
		td, th { border: 20px solid transparent; height: 30px; }
		th { background: #D3D3D3; font-weight: bold; }
		td { background: #FAFAFA; text-align: center; }
		tr:nth-child(even) td { background: #F1F1F1; }  
		tr:nth-child(odd) td { background: #FEFEFE; } 
		tr td:hover { background: #666; color: #FFF; }
		</style>
		<h4><center>Lotes con 7 días en Integración de Expediente:</center></h4>
		<center><table id='reporyt' cellpadding='0' cellspacing='0' border='1' width ='50%' style class='darkheader'>
		<tr class='active'>
			<th >Proyecto</th>
			<th>Condominio</th> 
			<th>Lote</th>
			<th>Cliente</th>
		</tr>";
				foreach ($datos["sendApartados_old"] as $row_cliente) {
			$mensaje .= "
  		<tr>   
         <td> " . $row_cliente->nombreResidencial . " </td>
         <td> " . $row_cliente->nombre . " </td>
         <td> " . $row_cliente->nombreLote . " </td>
         <td> " . $row_cliente->primerNombre . " " . $row_cliente->segundoNombre . " " . $row_cliente->apellidoPaterno . " " . $row_cliente->apellidoMaterno . " " . $row_cliente->razonSocial . " </td>
		</tr>
		";
		}
		$mensaje .= "
  		</table></center>";
		mail($para, $asunto, utf8_decode($mensaje), $cabeceras);
	}
	public function historialDocumentos()
	{
		$idLote = $this->input->post("idLote");
		$response['data'] = $this->registrolote_modelo->getExp($idLote);
		echo json_encode($response);
	}
	function getLotesQuery()
	{
		$lotes = $this->registrolote_modelo->queryLotes();
		if ($lotes != null) {
			echo json_encode($lotes);
		} else {
			echo json_encode(array());
		}
	}
	public function sendMailVentasRetrasos()
	{
		$datos["sendApartados_old"] = $this->registrolote_modelo->sendMailVentasRetrasos();
		$para = "rigel.silva@prohabitacion.com";
		$asunto = "Acumulado de lotes sin ingresar Expediente" . " " . date("Y-m-d H:i:s");
		$proyecto = "";
		$condominio = "";
		$lote = "";
		$cabeceras = "MIME-Version: 1.0 \r\n";
		$cabeceras = "CC: delia.cdmaderas@gmail.com, lucero.velazquez@ciudadmaderas.com, programador.analista1@ciudadmaderas.com, coord.contraloria2@ciudadmaderas.com\r\n";
		$cabeceras .= "Content-type: text/html; charset=utf-8 \r\n";
		$mensaje = "
		<style type='text/css'>
		table {  color: #333; border-collapse: collapse;}
		td, th { border: 20px solid transparent; height: 30px; }
		th { background: #D3D3D3; font-weight: bold; }
		td { background: #FAFAFA; text-align: center; }
		tr:nth-child(even) td { background: #F1F1F1; }  
		tr:nth-child(odd) td { background: #FEFEFE; } 
		tr td:hover { background: #666; color: #FFF; }
		</style>
		<h4><center>Acumulado de lotes sin ingresar Expediente:</center></h4>
	<center><table id='reporyt' cellpadding='0' cellspacing='0' border='1' width ='90%' style='text-align:center;' class='darkheader'>
		<tr class='active'>
			<th >Plaza</th>
			<th>Condominio</th> 
			<th>Lote</th>
			<th>Fecha Apartado</th>
			<th>Cliente</th>
			<th>Gerente</th>
			<th>Asesor</th>
			<th>Días acumulados sin ingresar Expediente</th>
		</tr>";
		foreach ($datos["sendApartados_old"] as $row_cliente) {
			$fechaHoy = $row_cliente->fechaApartado;
			$fechaDes = date('Y-m-d');
			$arregloFechas2 = array();
			$a = 0;
			while ($fechaHoy <= $fechaDes) {
				$hoy_strtotime = strtotime($fechaHoy);
				$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
				$sig_fecha = date("Y-m-d", $sig_strtotime);
				$excluir_dia = date('D', $sig_strtotime);
				$excluir_feriado = date('d-m', $sig_strtotime);
				if (
					$excluir_dia == "Sat" || $excluir_dia == "Sun" || $excluir_feriado == "01-01" || $excluir_feriado == "06-02" ||
					$excluir_feriado == "20-03" || $excluir_feriado == "01-05" || $excluir_feriado == "16-09" || $excluir_feriado == "20-11" ||
					$excluir_feriado == "25-12"
				) {
				} else {
					$arregloFechas2[$a] = $sig_fecha;
					$a++;
				}
				$fechaHoy = $sig_fecha;
			}
			if (count($arregloFechas2) >= 7) {
				$mensaje .= "
  		<tr>   
         <td> " . $row_cliente->nombreResidencial . " </td>
         <td> " . $row_cliente->nombreCondominio . " </td>
         <td> " . $row_cliente->nombreLote . " </td>
         <td> " . $row_cliente->fechaApartado . " </td>
         <td> " . $row_cliente->primerNombre . " " . $row_cliente->segundoNombre . " " . $row_cliente->apellidoPaterno . " " . $row_cliente->apellidoMaterno . " " . $row_cliente->razonSocial . " </td>
         <td> " . $row_cliente->nombreGerente . " </td>
         <td> " . $row_cliente->nombreAsesor . " </td>
         <td> " . count($arregloFechas2) . " </td>
		</tr>
		";
			}
		}
		$mensaje .= "
  	</table></center>";
		mail($para, $asunto, utf8_decode($mensaje), $cabeceras);
	}
	public function reportLotesContratados()
	{
		$this->load->view('template/header');
		$this->load->view("contratacion/datos_lotesContratados_view");
	}
	public function getLotesContratados()
	{
		ini_set('max_execution_time', 0);
		set_time_limit(0);
		ini_set('memory_limit', '2048M');
		$datos = $this->registrolote_modelo->lotesContratados();
		if ($datos != null)
			echo json_encode($datos);
		else
			echo json_encode(array());
		exit;
	}
	public function reportLotesPost45()
	{
		$this->load->view('template/header');
		$this->load->view("contratacion/datos_lotespost_view");
	}
	public function getReportPost45()
	{
		$datos = array();
		$data = $this->registrolote_modelo->reportLotesPost45();
		for ($i = 0; $i < count($data); $i++) {
			$date1 = new DateTime($data[$i]->fechaApartado);
			$date2 = new DateTime(date('Y-m-d'));
			$diff = $date1->diff($date2);
			if ($diff->days >= 45) {
				$datos[$i]['referencia'] = $data[$i]->referencia;
				$datos[$i]['idLote'] = $data[$i]->idLote;
				$datos[$i]['nombreSede'] = $data[$i]->nombreSede;
				$datos[$i]['id_cliente'] = $data[$i]->id_cliente;
				$datos[$i]['fechaApartado'] = ($data[$i]->fechaApartado != null || $data[$i]->fechaApartado != "") ? $data[$i]->fechaApartado : "N/A";
				$datos[$i]['nombreLote'] = $data[$i]->nombreLote;
				$datos[$i]['idStatusContratacion'] = $data[$i]->idStatusContratacion;
				$datos[$i]['idMovimiento'] = $data[$i]->idMovimiento;
				$datos[$i]['modificado'] = $data[$i]->modificado;
				$datos[$i]['nombreCondominio'] = $data[$i]->nombreCondominio;
				$datos[$i]['nombreResidencial'] = $data[$i]->nombreResidencial;
				$datos[$i]['fechaVenc'] = $data[$i]->fechaVenc;
				$datos[$i]['comentario'] = $data[$i]->comentario;
				$datos[$i]['fechaSolicitudValidacion'] = $data[$i]->fechaSolicitudValidacion;
				$datos[$i]['gerente'] = $data[$i]->gerente;
				$datos[$i]['asesor'] = $data[$i]->asesor;
				$datos[$i]['diasVencidos'] = $diff->days;
				$datos[$i]['id_cliente_reubicacion'] = $data[$i]->id_cliente_reubicacion;
				$datos[$i]['fechaAlta'] = $data[$i]->fechaAlta;
				/**procesoContratacion**/
				if ($data[$i]->idStatusContratacion == 1 and $data[$i]->idMovimiento == 18 or $data[$i]->idStatusContratacion == 1 and $data[$i]->idMovimiento == 31 or $data[$i]->idStatusContratacion == 1 and $data[$i]->idMovimiento == 19 or $data[$i]->idStatusContratacion == 1 and $data[$i]->idMovimiento == 20 or $data[$i]->idStatusContratacion == 1 and $data[$i]->idMovimiento == 63) {
					$datos[$i]['procesoContratacion'] = "2. INTEGRACIÓN DE EXPEDIENTE (ASISTENTES ELITE)";
				}
				if ($data[$i]->idStatusContratacion == 2 and $data[$i]->idMovimiento == 2 or $data[$i]->idStatusContratacion == 2 and $data[$i]->idMovimiento == 32) {
					$datos[$i]['procesoContratacion'] = "3. REVISIÓN JURÍDICO (JURÍDICO)";
				}
				if ($data[$i]->idStatusContratacion == 3 and $data[$i]->idMovimiento == 33 or $data[$i]->idStatusContratacion == 2 and $data[$i]->idMovimiento == 3) {
					$datos[$i]['procesoContratacion'] = "4. DATOS VERIFICADOS (POSTVENTA)";
				}
				if ($data[$i]->idStatusContratacion == 4 and $data[$i]->idMovimiento == 34 or $data[$i]->idStatusContratacion == 2 and $data[$i]->idMovimiento == 4) {
					$datos[$i]['procesoContratacion'] = "5. REVISIÓN 100% (CONTRALORÍA)";
				}
				if ($data[$i]->idStatusContratacion == 5 and $data[$i]->idMovimiento == 35 or $data[$i]->idStatusContratacion == 5 and $data[$i]->idMovimiento == 22 or $data[$i]->idStatusContratacion == 2 and $data[$i]->idMovimiento == 62) {
					$datos[$i]['procesoContratacion'] = "6. CORRIDA ELABORADA (CONTRALORÍA)";
				}
				if ($data[$i]->idStatusContratacion == 6 and $data[$i]->idMovimiento == 36 or $data[$i]->idStatusContratacion == 6 and $data[$i]->idMovimiento == 6) {
					$datos[$i]['procesoContratacion'] = "7. CONTRATO ELABORADO (JURÍDICO)";
				}
				if ($data[$i]->idStatusContratacion == 6 and $data[$i]->idMovimiento == 23) {
					$datos[$i]['procesoContratacion'] = "7. ELABORACIÓN DE CONTRATO (JURÍDICO)";
				}
				if ($data[$i]->idStatusContratacion == 7 and $data[$i]->idMovimiento == 37 or $data[$i]->idStatusContratacion == 7 and $data[$i]->idMovimiento == 7 or $data[$i]->idStatusContratacion == 7 and $data[$i]->idMovimiento == 77) {
					$datos[$i]['procesoContratacion'] = "8. CONTRATO ENTREGADO AL ASESOR PARA FIRMA DEL CLIENTE (ASISTENTES DE GERENTES)";
				}
				if ($data[$i]->idStatusContratacion == 8 and $data[$i]->idMovimiento == 38) {
					$datos[$i]['procesoContratacion'] = "9. CONTRATO RECIBIDO CON FIRMA DE CLIENTE (CONTRALORÍA)";
				}
				if ($data[$i]->idStatusContratacion == 9 and $data[$i]->idMovimiento == 39 or $data[$i]->idStatusContratacion == 9 and $data[$i]->idMovimiento = 26) {
					$datos[$i]['procesoContratacion'] = "10. SOLICITUD DE VALIDACIÓN DE ENGANCHE Y ENVIO DE CONTRATO A RL (CONTRALORÍA)";
				}
				if ($data[$i]->idStatusContratacion == 10 and $data[$i]->idMovimiento == 40 or $data[$i]->idStatusContratacion == 10 and $data[$i]->idMovimiento = 10) {
					$datos[$i]['procesoContratacion'] = "11. VALIDACIÓN DE ENGANCHE (ADMINISTRACIÓN)";
				}
				if ($data[$i]->idStatusContratacion == 11 and $data[$i]->idMovimiento == 41) {
					$datos[$i]['procesoContratacion'] = "12. CONTRATO FIRMADO (REPRESENTANTE LEGAL)";
				}
				if ($data[$i]->idStatusContratacion == 12 and $data[$i]->idMovimiento == 42) {
					$datos[$i]['procesoContratacion'] = "13. CONTRATO LISTO Y ENTREGADO ASESORES (CONTRALORÍA)";
				}
				if ($data[$i]->idStatusContratacion == 13 and $data[$i]->idMovimiento == 43) {
					$datos[$i]['procesoContratacion'] = "14. FIRMA ACUSE CLIENTE (ASISTENTES GERENTES)";
				}
				if ($data[$i]->idStatusContratacion == 14 and $data[$i]->idMovimiento == 44) {
					$datos[$i]['procesoContratacion'] = "15. ACUSE ENTREGADO (CONTRALORÍA)";
				}
				if ($data[$i]->idStatusContratacion == 15) {
					$datos[$i]['procesoContratacion'] = "LOTE CONTRATADO";
				}
				if ($data[$i]->idStatusContratacion == 7 and $data[$i]->idMovimiento == 64) {
					$datos[$i]['procesoContratacion'] = "8. CONTRATO ENTREGADO AL ASESOR PARA FIRMA DEL CLIENTE (ASISTENTES DE GERENTES)";
				}
				/**procesoContratacion**/
				if ($data[$i]->idStatusContratacion == 1 and $data[$i]->idMovimiento == 31) {
					$datos[$i]['status'] = "8. CONTRATO ENTREGADO AL ASESOR PARA FIRMA DEL CLIENTE (ASISTENTES DE GERENTES)";
				}
				if ($data[$i]->idStatusContratacion == 1 and $data[$i]->idMovimiento == 18) {
					$datos[$i]['status'] = "STATUS 2 RECHAZADO (JURÍDICO)";
				}
				if ($data[$i]->idStatusContratacion == 1 and $data[$i]->idMovimiento == 19) {
					$datos[$i]['status'] = "STATUS 2 RECHAZADO (POSTVENTA)";
				}
				if ($data[$i]->idStatusContratacion == 1 and $data[$i]->idMovimiento == 20) {
					$datos[$i]['status'] = "STATUS 2 RECHAZADO (CONTRALORÍRA)";
				}
				if ($data[$i]->idStatusContratacion == 2 and $data[$i]->idMovimiento == 32) {
					$datos[$i]['status'] = "STATUS 2 LISTO (ASISTENTES GERENTES)";
				}
				if ($data[$i]->idStatusContratacion == 2 and $data[$i]->idMovimiento == 2) {
					$datos[$i]['status'] = "STATUS 2 ENVIDADO A REVISIÓN (ASISTENTES GERENTES)";
				}
				if ($data[$i]->idStatusContratacion == 3 and $data[$i]->idMovimiento == 33) {
					$datos[$i]['status'] = "STATUS 3 LISTO (JURÍDICO)";
				}
				if ($data[$i]->idStatusContratacion == 2 and $data[$i]->idMovimiento == 3) {
					$datos[$i]['status'] = "STATUS 2 ENVIADO A REVISIÓN (ASISTENTES GERENTES) A POSTVENTA";
				}
				if ($data[$i]->idStatusContratacion == 4 and $data[$i]->idMovimiento == 34) {
					$datos[$i]['status'] = "STATUS 4 LISTO (POSTVENTA)";
				}
				if ($data[$i]->idStatusContratacion == 2 and $data[$i]->idMovimiento == 4 or $data[$i]->idStatusContratacion == 2 and $data[$i]->idMovimiento == 62) {
					$datos[$i]['status'] = "STATUS 2 ENVIADO A REVISIÓN (ELITE)";
				}
				if ($data[$i]->idStatusContratacion == 5 and $data[$i]->idMovimiento == 35) {
					$datos[$i]['status'] = "STATUS 5 LISTO (CONTRALORÍA) ";
				}
				if ($data[$i]->idStatusContratacion == 5 and $data[$i]->idMovimiento == 22) {
					$datos[$i]['status'] = "STATUS 6 RECHAZADO (JURIDICO)";
				}
				if ($data[$i]->idStatusContratacion == 6 and $data[$i]->idMovimiento == 36) {
					$datos[$i]['status'] = "STATUS 6 LISTO (CONTRALORÍA) ";
				}
				if ($data[$i]->idStatusContratacion == 6 and $data[$i]->idMovimiento == 6) {
					$datos[$i]['status'] = "STATUS 6 ENVIADO A REVISIÓN (CONTRALORÍA)";
				}
				if ($data[$i]->idStatusContratacion == 6 and $data[$i]->idMovimiento == 23) {
					$datos[$i]['status'] = "STATUS 7 ENVIADO A MODIFICACIÓN (ASISTENTES GERENTES)";
				}
				if ($data[$i]->idStatusContratacion == 7 and $data[$i]->idMovimiento == 37) {
					$datos[$i]['status'] = "STATUS 7 LISTO (JURÍDICO) ";
				}
				if ($data[$i]->idStatusContratacion == 7 and $data[$i]->idMovimiento == 7 or $data[$i]->idStatusContratacion == 7 and $data[$i]->idMovimiento == 77) {
					$datos[$i]['status'] = "CONTRATO CON MODIFIACIONES ENTREGADO";
				}
				if ($data[$i]->idStatusContratacion == 8 and $data[$i]->idMovimiento == 38) {
					$datos[$i]['status'] = "STATUS 8 LISTO (ASISTENTES DE GERENTES)";
				}
				if ($data[$i]->idStatusContratacion == 9 and $data[$i]->idMovimiento == 39) {
					$datos[$i]['status'] = "STATUS 9 LISTO (ASISTENTES DE GERENTES)";
				}
				if ($data[$i]->idStatusContratacion == 9 and $data[$i]->idMovimiento == 26) {
					$datos[$i]['status'] = "RECHAZO STATUS 10 (ADMINISTRACIÓN)";
				}
				if ($data[$i]->idStatusContratacion == 10 and $data[$i]->idMovimiento == 40) {
					$datos[$i]['status'] = "STATUS 10 LISTO (CONTRALORÍA)";
				}
				if ($data[$i]->idStatusContratacion == 10 and $data[$i]->idMovimiento == 10) {
					$datos[$i]['status'] = "STATUS 10 ENVIADO A REVISIÓN (CONTRALORÍA)";
				}
				if ($data[$i]->idStatusContratacion == 11 and $data[$i]->idMovimiento == 41) {
					$datos[$i]['status'] = "STATUS 11 LISTO (ADMINISTRACIÓN)";
				}
				if ($data[$i]->idStatusContratacion == 12 and $data[$i]->idMovimiento == 42) {
					$datos[$i]['status'] = "STATUS 12 LISTO (REPRESENTANTE LEGAL) ";
				}
				if ($data[$i]->idStatusContratacion == 13 and $data[$i]->idMovimiento == 43) {
					$datos[$i]['status'] = "STATUS 13 LISTO (CONTRALORÍA)";
				}
				if ($data[$i]->idStatusContratacion == 14 and $data[$i]->idMovimiento == 44) {
					$datos[$i]['status'] = "STATUS 14 LISTO (ASISTENTES GERENTES)";
				}
				if ($data[$i]->idStatusContratacion == 15 and $data[$i]->idMovimiento == 45) {
					$datos[$i]['status'] = "LOTE CONTRATADO ";
				}
				if ($data[$i]->idStatusContratacion == 7 and $data[$i]->idMovimiento == 64) {
					$datos[$i]['status'] = "STATUS 8 RECHAZADO (POR CONTRALORÍA)";
				}
				if ($data[$i]->idStatusContratacion == 1 and $data[$i]->idMovimiento == 63) {
					$datos[$i]['status'] = "STATUS 2 RECHAZADO (POR CONTRALORÍA)";
				}
			}
		}
		$datos = array_values($datos);
		if ($datos != null)
			echo json_encode($datos);
		else
			echo json_encode(array());
		exit;
	}
	public function registrosInventario()
	{
		$datos = array();
		$datos["residencial"] = $this->registrolote_modelo->getResidencialQro();
		$this->load->view("datos_inventarioDAd_view", $datos);
	}
	function getLotesDad($condominio, $residencial)
	{
		$data['lotes'] = $this->registrolote_modelo->getInventarioAd($condominio, $residencial);
		echo '<table id="tabla_lotes_corrida" cellpadding="0" cellspacing="0" border="0" width ="100%" class="table table-vcenter table-striped" >';
		echo '<thead>';
		echo '<tr>';
		echo '<th class="text-center">Proyecto</th>';
		echo '<th class="text-center">Condominio</th>';
		echo '<th class="text-center">Lote</th>';
		echo '<th class="text-center">Superficie</th>';
		echo '<th class="text-center">Total (Pesos)</th>';
		echo '<th class="text-center">Total (Dólares)</th>';
		echo '<th class="text-center">Engache (Dólares)</th>';
		echo '<th class="text-center">A financiar (Dólares)</th>';
		echo '<th class="text-center">Meses S/N</th>';
		echo '</tr>';
		echo '<tfoot>';
		echo '<tr>';
		echo '<th class="text-center">Proyecto</th>';
		echo '<th class="text-center">Condominio</th>';
		echo '<th class="text-center">Lote</th>';
		echo '<th class="text-center">Superficie</th>';
		echo '<th class="text-center">Total (Pesos)</th>';
		echo '<th class="text-center">Total (Dólares)</th>';
		echo '<th class="text-center">Engache (Dólares)</th>';
		echo '<th class="text-center">A financiar (Dólares)</th>';
		echo '<th class="text-center">Meses S/N</th>';
		echo '</tfoot>';
		echo '</tr>';
		echo '</thead>';
		echo '<tbody class="lotes">';
		setlocale(LC_MONETARY, 'en_US');
		$i = 0;
		while ($i < count($data['lotes'])) {
			echo "<tr id='" . $data['lotes'][$i]['idLote'] . "' class='resaltar'>";
			echo "<td style=text-align:center>" . $data['lotes'][$i]['nombreResidencial'] . "</td>";
			echo "<td style=text-align:center>" . $data['lotes'][$i]['nombreCondominio'] . "</td>";
			echo "<td style=text-align:center>" . $data['lotes'][$i]['nombreLote'] . "</td>";
			echo "<td style=text-align:center>" . $data['lotes'][$i]['sup'] . "</td>";
			echo "<td style=text-align:center>" . "$" . number_format($data['lotes'][$i]['total'], 2, ".", ",") . "</td>";
			$totalInicial = $data['lotes'][$i]['total'];
			$porcentajeAd = $totalInicial * 0.1;
			$totalFinal = $totalInicial + $porcentajeAd;
			$dolares = $totalFinal / 20;
			echo "<td style=text-align:center>" . "$" . number_format($dolares, 2, ".", ",") . "</td>";
			$totalInicial = $data['lotes'][$i]['total'];
			$porcentajeAd = $totalInicial * 0.1;
			$totalFinal = $totalInicial + $porcentajeAd;
			$dolares = $totalFinal / 20;
			$dolaresEng = $dolares * 0.1;
			echo "<td style=text-align:center>" . "$" . number_format($dolaresEng, 2, ".", ",") . "</td>";
			$totalInicial = $data['lotes'][$i]['total'];
			$porcentajeAd = $totalInicial * 0.1;
			$totalFinal = $totalInicial + $porcentajeAd;
			$dolares = $totalFinal / 20;
			$dolaresEng = $dolares * 0.1;
			$saldoDolares = $dolares - $dolaresEng;
			echo "<td style=text-align:center>" . "$" . number_format($saldoDolares, 2, ".", ",") . "</td>";
			echo "<td style=text-align:center>" . $data['lotes'][$i]['msni'] . "</td>";
			$i++;
		}
		echo '</tbody>';
		echo '</table>';
		?>
				<script type="text/javascript">
					$(document).ready(function () {
						$('#tabla_lotes_corrida').dataTable({
							initComplete: function () {
								this.api().columns().every(function () {
									var column = this;
									var select = $('<select><option value=""></option></select>')
										.appendTo($(column.footer()).empty())
										.on('change', function () {
											var val = $.fn.dataTable.util.escapeRegex(
												$(this).val()
											);
											column
												.search(val ? '^' + val + '$' : '', true, false)
												.draw();
										});
									column.data().unique().sort().each(function (d, j) {
										select.append('<option value="' + d + '">' + d + '</option>')
									});
								});
							},
							"scrollX": true,
							"pageLength": 10,
							"language": {
								"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
							},
							dom: 'Bfrtip',
							buttons: [
								{
									extend: 'copyHtml5',
									text: '<i class="fa fa-files-o"></i>',
									titleAttr: 'Copy'
								},
								{
									extend: 'excelHtml5',
									text: '<i class="fa fa-file-excel-o"></i>',
									titleAttr: 'Excel'
								},
								{
									extend: 'csvHtml5',
									text: '<i class="fa fa-file-text-o"></i>',
									titleAttr: 'CSV'
								},
								{
									extend: 'pdfHtml5',
									text: '<i class="fa fa-file-pdf-o"></i>',
									titleAttr: 'PDF'
								}
							]
						});
					});
				</script>
				<link rel="stylesheet" type="text/css" href="<?= base_url() ?>dist/css/shadowbox.css">
				<script type="text/javascript" src="<?= base_url() ?>dist/js/shadowbox.js"></script>
				<script type="text/javascript">
					Shadowbox.init();
				</script>
				<?php
	}
	function getLotesDadAll()
	{
		$data['lotes'] = $this->registrolote_modelo->getInventarioAllAd();
		echo '<table id="tabla_lotes_corrida" cellpadding="0" cellspacing="0" border="0" width ="100%" class="table table-vcenter table-striped" >';
		echo '<thead>';
		echo '<tr>';
		echo '<th class="text-center">Proyecto</th>';
		echo '<th class="text-center">Condominio</th>';
		echo '<th class="text-center">Lote</th>';
		echo '<th class="text-center">Superficie</th>';
		echo '<th class="text-center">Total (Pesos)</th>';
		echo '<th class="text-center">Total (Dólares)</th>';
		echo '<th class="text-center">Engache (Dólares)</th>';
		echo '<th class="text-center">A financiar (Dólares)</th>';
		echo '<th class="text-center">Meses S/N</th>';
		echo '</tr>';
		echo '<tfoot>';
		echo '<tr>';
		echo '<th class="text-center">Proyecto</th>';
		echo '<th class="text-center">Condominio</th>';
		echo '<th class="text-center">Lote</th>';
		echo '<th class="text-center">Superficie</th>';
		echo '<th class="text-center">Total (Pesos)</th>';
		echo '<th class="text-center">Total (Dólares)</th>';
		echo '<th class="text-center">Engache (Dólares)</th>';
		echo '<th class="text-center">A financiar (Dólares)</th>';
		echo '<th class="text-center">Meses S/N</th>';
		echo '</tfoot>';
		echo '</tr>';
		echo '</thead>';
		echo '<tbody class="lotes">';
		setlocale(LC_MONETARY, 'en_US');
		$i = 0;
		while ($i < count($data['lotes'])) {
			echo "<tr id='" . $data['lotes'][$i]['idLote'] . "' class='resaltar'>";
			echo "<td style=text-align:center>" . $data['lotes'][$i]['nombreResidencial'] . "</td>";
			echo "<td style=text-align:center>" . $data['lotes'][$i]['nombreCondominio'] . "</td>";
			echo "<td style=text-align:center>" . $data['lotes'][$i]['nombreLote'] . "</td>";
			echo "<td style=text-align:center>" . $data['lotes'][$i]['sup'] . "</td>";
			echo "<td style=text-align:center>" . "$" . number_format($data['lotes'][$i]['total'], 2, ".", ",") . "</td>";
			$totalInicial = $data['lotes'][$i]['total'];
			$porcentajeAd = $totalInicial * 0.1;
			$totalFinal = $totalInicial + $porcentajeAd;
			$dolares = $totalFinal / 20;
			echo "<td style=text-align:center>" . "$" . number_format($dolares, 2, ".", ",") . "</td>";
			$totalInicial = $data['lotes'][$i]['total'];
			$porcentajeAd = $totalInicial * 0.1;
			$totalFinal = $totalInicial + $porcentajeAd;
			$dolares = $totalFinal / 20;
			$dolaresEng = $dolares * 0.1;
			echo "<td style=text-align:center>" . "$" . number_format($dolaresEng, 2, ".", ",") . "</td>";
			$totalInicial = $data['lotes'][$i]['total'];
			$porcentajeAd = $totalInicial * 0.1;
			$totalFinal = $totalInicial + $porcentajeAd;
			$dolares = $totalFinal / 20;
			$dolaresEng = $dolares * 0.1;
			$saldoDolares = $dolares - $dolaresEng;
			echo "<td style=text-align:center>" . "$" . number_format($saldoDolares, 2, ".", ",") . "</td>";
			echo "<td style=text-align:center>" . $data['lotes'][$i]['msni'] . "</td>";
			$i++;
		}
		echo '</tbody>';
		echo '</table>';
		?>
				<script type="text/javascript">
					$(document).ready(function () {
						$('#tabla_lotes_corrida').dataTable({
							initComplete: function () {
								this.api().columns().every(function () {
									var column = this;
									var select = $('<select><option value=""></option></select>')
										.appendTo($(column.footer()).empty())
										.on('change', function () {
											var val = $.fn.dataTable.util.escapeRegex(
												$(this).val()
											);
											column
												.search(val ? '^' + val + '$' : '', true, false)
												.draw();
										});
									column.data().unique().sort().each(function (d, j) {
										select.append('<option value="' + d + '">' + d + '</option>')
									});
								});
							},
							"scrollX": true,
							"pageLength": 10,
							"language": {
								"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
							},
							dom: 'Bfrtip',
							buttons: [
								{
									extend: 'copyHtml5',
									text: '<i class="fa fa-files-o"></i>',
									titleAttr: 'Copy'
								},
								{
									extend: 'excelHtml5',
									text: '<i class="fa fa-file-excel-o"></i>',
									titleAttr: 'Excel'
								},
								{
									extend: 'csvHtml5',
									text: '<i class="fa fa-file-text-o"></i>',
									titleAttr: 'CSV'
								},
								{
									extend: 'pdfHtml5',
									text: '<i class="fa fa-file-pdf-o"></i>',
									titleAttr: 'PDF'
								}
							]
						});
					});
				</script>
				<link rel="stylesheet" type="text/css" href="<?= base_url() ?>dist/css/shadowbox.css">
				<script type="text/javascript" src="<?= base_url() ?>dist/js/shadowbox.js"></script>
				<script type="text/javascript">
					Shadowbox.init();
				</script>
				<?php
	}
	public function registrosInvDis()
	{
		$datos = array();
		$datos["residencial"] = $this->registrolote_modelo->getResidencialQro();
		$this->load->view('template/header');
		$this->load->view("contratacion/datos_inventarioDventas_view", $datos);
	}
	function getLotesDventas($condominio, $residencial)
	{
		$data = $this->registrolote_modelo->getInventarioAd($condominio, $residencial);
		
		if ($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
		exit;
		echo '<table id="tabla_lotes_corrida" cellpadding="0" cellspacing="0" border="0" width ="100%" class="table table-vcenter table-striped" >';
		echo '<thead>';
		echo '<tr>';
		echo '<th class="text-center">Proyecto</th>';
		echo '<th class="text-center">Condominio</th>';
		echo '<th class="text-center">Lote</th>';
		echo '<th class="text-center">Superficie</th>';
		echo '<th class="text-center">Total</th>';
		echo '<th class="text-center">Engache</th>';
		echo '<th class="text-center">A financiar</th>';
		echo '<th class="text-center">Meses S/N</th>';
		echo '</tr>';
		echo '<tfoot>';
		echo '<tr>';
		echo '<th class="text-center">Proyecto</th>';
		echo '<th class="text-center">Condominio</th>';
		echo '<th class="text-center">Lote</th>';
		echo '<th class="text-center">Superficie</th>';
		echo '<th class="text-center">Total</th>';
		echo '<th class="text-center">Engache</th>';
		echo '<th class="text-center">A financiar</th>';
		echo '<th class="text-center">Meses S/N</th>';
		echo '</tfoot>';
		echo '</tr>';
		echo '</thead>';
		echo '<tbody class="lotes">';
		setlocale(LC_MONETARY, 'en_US');
		$i = 0;
		while ($i < count($data['lotes'])) {
			echo "<tr id='" . $data['lotes'][$i]['idLote'] . "' class='resaltar'>";
			echo "<td style=text-align:center>" . $data['lotes'][$i]['nombreResidencial'] . "</td>";
			echo "<td style=text-align:center>" . $data['lotes'][$i]['nombreCondominio'] . "</td>";
			echo "<td style=text-align:center>" . $data['lotes'][$i]['nombreLote'] . "</td>";
			echo "<td style=text-align:center>" . $data['lotes'][$i]['sup'] . "</td>";
			echo "<td style=text-align:center>" . "$" . number_format($data['lotes'][$i]['total'], 2, ".", ",") . "</td>";
			echo "<td style=text-align:center>" . "$" . number_format($data['lotes'][$i]['enganche'], 2, ".", ",") . "</td>";
			echo "<td style=text-align:center>" . "$" . number_format($data['lotes'][$i]['saldo'], 2, ".", ",") . "</td>";
			echo "<td style=text-align:center>" . $data['lotes'][$i]['msni'] . "</td>";
			$i++;
		}
		echo '</tbody>';
		echo '</table>';
		?>
				<script type="text/javascript">
					$(document).ready(function () {
						$('#tabla_lotes_corrida').dataTable({
							initComplete: function () {
								this.api().columns().every(function () {
									var column = this;
									var select = $('<select><option value=""></option></select>')
										.appendTo($(column.footer()).empty())
										.on('change', function () {
											var val = $.fn.dataTable.util.escapeRegex(
												$(this).val()
											);
											column
												.search(val ? '^' + val + '$' : '', true, false)
												.draw();
										});
									column.data().unique().sort().each(function (d, j) {
										select.append('<option value="' + d + '">' + d + '</option>')
									});
								});
							},
							"scrollX": true,
							"pageLength": 10,
							"language": {
								"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
							},
							dom: 'Bfrtip',
							buttons: [
								{
									extend: 'copyHtml5',
									text: '<i class="fa fa-files-o"></i>',
									titleAttr: 'Copy'
								},
								{
									extend: 'excelHtml5',
									text: '<i class="fa fa-file-excel-o"></i>',
									titleAttr: 'Excel'
								},
								{
									extend: 'csvHtml5',
									text: '<i class="fa fa-file-text-o"></i>',
									titleAttr: 'CSV'
								},
								{
									extend: 'pdfHtml5',
									text: '<i class="fa fa-file-pdf-o"></i>',
									titleAttr: 'PDF'
								}
							]
						});
					});
				</script>
				<link rel="stylesheet" type="text/css" href="<?= base_url() ?>dist/css/shadowbox.css">
				<script type="text/javascript" src="<?= base_url() ?>dist/js/shadowbox.js"></script>
				<script type="text/javascript">
					Shadowbox.init();
				</script>
				<?php
	}
	function getLotesDventasAll()
	{
		$data = $this->registrolote_modelo->getInventarioAllAd();
		if ($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
		exit;
		echo '<table id="tabla_lotes_corrida" cellpadding="0" cellspacing="0" border="0" width ="100%" class="table table-vcenter table-striped" >';
		echo '<thead>';
		echo '<tr>';
		echo '<th class="text-center">Proyecto</th>';
		echo '<th class="text-center">Condominio</th>';
		echo '<th class="text-center">Lote</th>';
		echo '<th class="text-center">Superficie</th>';
		echo '<th class="text-center">Total</th>';
		echo '<th class="text-center">Engache</th>';
		echo '<th class="text-center">A financiar</th>';
		echo '<th class="text-center">Meses S/N</th>';
		echo '</tr>';
		echo '<tfoot>';
		echo '<tr>';
		echo '<th class="text-center">Proyecto</th>';
		echo '<th class="text-center">Condominio</th>';
		echo '<th class="text-center">Lote</th>';
		echo '<th class="text-center">Superficie</th>';
		echo '<th class="text-center">Total</th>';
		echo '<th class="text-center">Engache</th>';
		echo '<th class="text-center">A financiar</th>';
		echo '<th class="text-center">Meses S/N</th>';
		echo '</tfoot>';
		echo '</tr>';
		echo '</thead>';
		echo '<tbody class="lotes">';
		setlocale(LC_MONETARY, 'en_US');
		$i = 0;
		while ($i < count($data['lotes'])) {
			echo "<tr id='" . $data['lotes'][$i]['idLote'] . "' class='resaltar'>";
			echo "<td style=text-align:center>" . $data['lotes'][$i]['nombreResidencial'] . "</td>";
			echo "<td style=text-align:center>" . $data['lotes'][$i]['nombreCondominio'] . "</td>";
			echo "<td style=text-align:center>" . $data['lotes'][$i]['nombreLote'] . "</td>";
			echo "<td style=text-align:center>" . $data['lotes'][$i]['sup'] . "</td>";
			echo "<td style=text-align:center>" . "$" . number_format($data['lotes'][$i]['total'], 2, ".", ",") . "</td>";
			echo "<td style=text-align:center>" . "$" . number_format($data['lotes'][$i]['enganche'], 2, ".", ",") . "</td>";
			echo "<td style=text-align:center>" . "$" . number_format($data['lotes'][$i]['saldo'], 2, ".", ",") . "</td>";
			echo "<td style=text-align:center>" . $data['lotes'][$i]['msni'] . "</td>";
			$i++;
		}
		echo '</tbody>';
		echo '</table>';
		?>
				<script type="text/javascript">
					$(document).ready(function () {
						$('#tabla_lotes_corrida').dataTable({
							initComplete: function () {
								this.api().columns().every(function () {
									var column = this;
									var select = $('<select><option value=""></option></select>')
										.appendTo($(column.footer()).empty())
										.on('change', function () {
											var val = $.fn.dataTable.util.escapeRegex(
												$(this).val()
											);
											column
												.search(val ? '^' + val + '$' : '', true, false)
												.draw();
										});
									column.data().unique().sort().each(function (d, j) {
										select.append('<option value="' + d + '">' + d + '</option>')
									});
								});
							},
							"scrollX": true,
							"pageLength": 10,
							"language": {
								"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
							},
							dom: 'Bfrtip',
							buttons: [
								{
									extend: 'copyHtml5',
									text: '<i class="fa fa-files-o"></i>',
									titleAttr: 'Copy'
								},
								{
									extend: 'excelHtml5',
									text: '<i class="fa fa-file-excel-o"></i>',
									titleAttr: 'Excel'
								},
								{
									extend: 'csvHtml5',
									text: '<i class="fa fa-file-text-o"></i>',
									titleAttr: 'CSV'
								},
								{
									extend: 'pdfHtml5',
									text: '<i class="fa fa-file-pdf-o"></i>',
									titleAttr: 'PDF'
								}
							]
						});
					});
				</script>
				<link rel="stylesheet" type="text/css" href="<?= base_url() ?>dist/css/shadowbox.css">
				<script type="text/javascript" src="<?= base_url() ?>dist/js/shadowbox.js"></script>
				<script type="text/javascript">
					Shadowbox.init();
				</script>
				<?php
	}
	public function generarCorridaDad()
	{
		$datos = array();
		$datos["residencial"] = $this->registrolote_modelo->getResidencialQro();
		$this->load->view("corridaDad_view", $datos);
	}
	public function updatedescSup()
	{
		$desc1_1 = $this->input->post('desc1_1');
		$supIni = $this->input->post('supIni');
		$supFin = $this->input->post('supFin');
		$nombredescSup = $this->input->post('nombredescSup');
		$bonoOpcion1 = $this->input->post('bonoOpcion1');
		$bonoOpcion2 = $this->input->post('bonoOpcion2');
		$bonoOpcion3 = $this->input->post('bonoOpcion3');
		$dato = array();
		$dato["desc1_1"] = $desc1_1;
		$dato["supIni"] = $supIni;
		$dato["supFin"] = $supFin;
		$dato["motivo"] = $nombredescSup;
		$dato["bonoOpcion1"] = $bonoOpcion1;
		$dato["bonoOpcion2"] = $bonoOpcion2;
		$dato["bonoOpcion3"] = $bonoOpcion3;
		if ($this->registrolote_modelo->descSup($dato)) {
			redirect(base_url() . "index.php/registroLote/create_descuento");
		} else {
			die("ERROR");
		}
	}
	public function listarProducto()
	{
		$data["data"] = $this->registrolote_modelo->table_condominio();
		echo json_encode($data);
	}
	public function create_cluster()
	{
		$datos["residencial"] = $this->registrolote_modelo->getResidencial();
		$datos["banco"] = $this->registrolote_modelo->table_datosBancarios();
		$datos["etapa"] = $this->registrolote_modelo->table_etapa();
		$this->load->view("createCluster_view", $datos);
	}
	function uploadCluster()
	{
		$datos = array();
		$datos["residencial"] = $this->registrolote_modelo->getResidencialQro();
		$this->load->view('cluster', $datos);
	}
	function uploadData()
	{
		$this->input->post('filtro4');
		$this->registrolote_modelo->uploadData($this->input->post('filtro4'));
	}
	public function create_asesor()
	{
		$this->load->view('template/header');
		$this->load->view("contratacion/cat_asesor_view");
	}
	public function getGerentsAll()
	{
		$datos = array();
		$datos = $this->registrolote_modelo->getGerente();
		if ($datos != null) {
			echo json_encode($datos);
		} else {
			echo json_encode(array());
		}
	}
	public function getGerentsBySede($id_sede)
	{
		$datos = array();
		$datos = $this->registrolote_modelo->getGerenteBySede($id_sede);
		if ($datos != null) {
			echo json_encode($datos);
		} else {
			echo json_encode(array());
		}
	}
	public function getCoordByGerente($id_gerente)
	{
		$datos = array();
		$datos = $this->registrolote_modelo->getCoordinadoresByGerente($id_gerente);
		if ($datos != null) {
			echo json_encode($datos);
		} else {
			echo json_encode(array());
		}
	}
	public function catAsesor()
	{
		$data = array();
		$dataLocation = array();
		$datos = $this->registrolote_modelo->table_asesor();
		for ($i = 0; $i < count($datos); $i++) {
			$data[$i]['id_usuario'] = $datos[$i]->id_usuario;
			$data[$i]['asesor'] = $datos[$i]->asesor;
			$data[$i]['lider'] = $datos[$i]->lider;
			$data[$i]['correo'] = $datos[$i]->correo;
			$data[$i]['telefono'] = $datos[$i]->telefono;
			$data[$i]['rfc'] = $datos[$i]->rfc;
			$data[$i]['usuario'] = $datos[$i]->usuario;
			$data[$i]['estatus'] = $datos[$i]->estatus;
			$data[$i]['id_sede'] = $datos[$i]->id_sede;
			$porciones = explode(",", $datos[$i]->id_sede);
			if (count($porciones) == 1) {
				$dataLocation = $this->registrolote_modelo->getLocation($datos[$i]->id_sede);
				$data[$i]['ubicacion'] = $dataLocation[0]->abreviacion;
			} else {
				for ($n = 1; $n < count($porciones); $n++) {
					$dataLocation = $this->registrolote_modelo->getLocation($n);
					$data[$i]['ubicacion'] = $dataLocation[0]->abreviacion;
				}
			}
		}
		echo json_encode($data);
	}
	public function insertAsesor()
	{
		$pNombre = $this->input->post('pNombre');
		$sNombre = $this->input->post('sNombre');
		$aPaterno = $this->input->post('aPaterno');
		$aMaterno = $this->input->post('aMaterno');
		$hijos = $this->input->post('hijos');
		$sede = $this->input->post('sede');
		$user = $this->input->post('user');
		$pass = $this->input->post('pass');
		$pNombre2 = $pNombre == NULL ? "" : $pNombre;
		$sNombre2 = $sNombre == NULL ? "" : $sNombre;
		$aPaterno2 = $aPaterno == NULL ? "" : $aPaterno;
		$aMaterno2 = $aMaterno == NULL ? "" : $aMaterno;
		$correo = $this->input->post('correo');
		$telefono = $this->input->post('telefono');
		$rfc = $this->input->post('rfc');
		$idGerente = $this->input->post('idGerente');
		$coordinador = $this->input->post('nameCoordinador');
		$tipo_rol = $this->input->post('tipoUser');
		$id_lider = ($tipo_rol == 7) ? $id_lider = $coordinador : $id_lider = $idGerente;
		$arreglo = array();
		$arreglo["id_rol"] = $tipo_rol;
		$arreglo["id_sede"] = $sede;
		$arreglo["nombre"] = $pNombre2 . " " . $sNombre2;
		$arreglo["apellido_paterno"] = $aPaterno2;
		$arreglo["apellido_materno"] = $aMaterno2;
		$arreglo["correo"] = $correo;
		$arreglo["telefono"] = $telefono;
		$arreglo['rfc'] = $rfc;
		$arreglo["id_lider"] = $id_lider;
		$arreglo["usuario"] = $user;
		$arreglo["contrasena"] = encriptar($pass);
		$arreglo["tiene_hijos"] = $hijos;
		$arreglo["fecha_creacion"] = date('Y-m-d H:i:s');
		$arreglo["creado_por"] = $this->session->userdata('id_usuario');
		$arreglo["forma_pago"] = 1;
		$arreglo["estatus"] = 1;
		$arreglo["sesion_activa"] = 1;
		$checkUsername = $this->registrolote_modelo->getUserAsesor($user);
		if ($checkUsername == 0) {
			$insert = $this->registrolote_modelo->insert_asesor($arreglo);
			if ($insert) {
				echo 1;
			}
		} else {
			echo 0;
		}
	}
	public function cambiarEstatusAsesor()
	{
		$response = array(
			'status' => 'error',
			'message' => 'empty'
		);
		$idAsesor = $this->input->post('idAsesor');
		$data = ['estatus' => ($this->input->post('action') == 'Deshabilitar' ? 0 : 1)];
		$updated = $this->registrolote_modelo->changeStatusUser($idAsesor, $data);
		$updatedUsers = $this->registrolote_modelo->changeStatusUserAsesor($idAsesor, $data);
		if ($updated and $updatedUsers) {
			$response['status'] = 'ok';
			$response['message'] = 'Estus modificado';
			$response['id_asesor'] = $idAsesor;
		} else {
			$response['id_asesor'] = '0';
			$response['message'] = 'Error al editar usuario.';
		}
		echo json_encode($response);
	}
	public function editarLoteRevisionEliteStatus2Juridico3($idLote)
	{
		$datos = array();
		$datos["lotes"] = $this->registrolote_modelo->selectRegistroLoteCaja($idLote);
		$datos["asistentesStatus2"] = $this->registrolote_modelo->getAsistentesStatus2();
		$this->load->view('editar_loteRevision_elite_proceso2aJuridico3_view', $datos);
	}
	public function editar_registro_loteRevision_eliteAJuridico3_proceceso2()
	{
		$idLote = $this->input->post('idLote');
		$idCondominio = $this->input->post('idCondominio');
		$nombreLote = $this->input->post('nombreLote');
		$idStatusContratacion = $this->input->post('idStatusContratacion');
		$idMovimiento = $this->input->post('idMovimiento');
		$idCliente = $this->input->post('idCliente');
		$comentario = $this->input->post('comentario');
		$user = $this->input->post('user');
		$perfil = $this->input->post('perfil');
		$modificado = date('Y-m-d H:i:s');
		$fechaVenc = $this->input->post('fechaVenc');
		$arreglo = array();
		$arreglo["idStatusContratacion"] = $idStatusContratacion;
		$arreglo["idMovimiento"] = 78;
		$arreglo["comentario"] = $comentario;
		$arreglo["user"] = $this->session->userdata('username');
		$arreglo["perfil"] = $this->session->userdata('perfil');
		$arreglo["modificado"] = date("Y-m-d H:i:s");
		$arreglo2 = array();
		$arreglo2["idStatusContratacion"] = $idStatusContratacion;
		$arreglo2["idMovimiento"] = 78;
		$arreglo2["nombreLote"] = $nombreLote;
		$arreglo2["comentario"] = $comentario;
		$arreglo2["user"] = $this->session->userdata('username');
		$arreglo2["perfil"] = $this->session->userdata('perfil');
		$arreglo2["modificado"] = date("Y-m-d H:i:s");
		$arreglo2["fechaVenc"] = $fechaVenc;
		$arreglo2["idLote"] = $idLote;
		$arreglo2["idCondominio"] = $idCondominio;
		$arreglo2["idCliente"] = $idCliente;
		if ($this->registrolote_modelo->editaRegistroLoteCaja($idLote, $arreglo)) {
			$this->registrolote_modelo->insertHistorialLotes($arreglo2);
			redirect(base_url() . "index.php/registroLote/registroStatusContratacionAsistentes2");
		} else {
			die("ERROR");
		}
	}
	public function editarLoteRevisionJuridicoStatus3aContraloria5($idLote)
	{
		$datos = array();
		$datos["lotes"] = $this->registrolote_modelo->selectRegistroLoteCaja($idLote);
		$datos["juridicoStatus3"] = $this->registrolote_modelo->getJuridicoStatus3();
		$this->load->view('editar_loteRevision_juridico_proceso3aContraloria5_view', $datos);
	}
	public function editar_registro_loteRevision_JuridicoaContraloria5_proceceso3()
	{
		$idLote = $this->input->post('idLote');
		$idCondominio = $this->input->post('idCondominio');
		$nombreLote = $this->input->post('nombreLote');
		$idStatusContratacion = $this->input->post('idStatusContratacion');
		$idMovimiento = $this->input->post('idMovimiento');
		$idCliente = $this->input->post('idCliente');
		$comentario = $this->input->post('comentario');
		$user = $this->input->post('user');
		$perfil = $this->input->post('perfil');
		$modificado = date('Y-m-d H:i:s');
		$fechaVenc = $this->input->post('fechaVenc');
		$arreglo = array();
		$arreglo["idStatusContratacion"] = $idStatusContratacion;
		$arreglo["idMovimiento"] = 79;
		$arreglo["comentario"] = $comentario;
		$arreglo["user"] = $this->session->userdata('username');
		$arreglo["perfil"] = $this->session->userdata('perfil');
		$arreglo["modificado"] = date("Y-m-d H:i:s");
		$arreglo2 = array();
		$arreglo2["idStatusContratacion"] = $idStatusContratacion;
		$arreglo2["idMovimiento"] = 79;
		$arreglo2["nombreLote"] = $nombreLote;
		$arreglo2["comentario"] = $comentario;
		$arreglo2["user"] = $this->session->userdata('username');
		$arreglo2["perfil"] = $this->session->userdata('perfil');
		$arreglo2["modificado"] = date("Y-m-d H:i:s");
		$arreglo2["fechaVenc"] = $fechaVenc;
		$arreglo2["idLote"] = $idLote;
		$arreglo2["idCondominio"] = $idCondominio;
		$arreglo2["idCliente"] = $idCliente;
		if ($this->registrolote_modelo->editaRegistroLoteCaja($idLote, $arreglo)) {
			$this->registrolote_modelo->insertHistorialLotes($arreglo2);
			redirect(base_url() . "index.php/registroLote/registroStatus3ContratacionJuridico");
		} else {
			die("ERROR");
		}
	}
	public function editLoteStatus14()
	{
		$datos = array();
		$datos["asistentesStatus14"] = $this->registrolote_modelo->getAsistentesStatus14();
		$idLote = $this->input->post('idLote');
		$response = array(
			'status' => 'error',
			'message' => 'Empty'
		);
		$datos['lotes'] = $this->registrolote_modelo->selectRegistroLoteCaja($idLote);
		if ($datos['lotes'] != null) {
			$response['status'] = 'ok';
			$response['message'] = 'Lote encontrado';
			$response['dataLote'] = $datos['lotes'];
			$response['dataStatus14'] = $datos['asistentesStatus14'];
		} else {
			$response['message'] = 'No fue posible encontrar encontrar el lote';
		}
		echo json_encode($response);
	}
	public function editaAsesor()
	{
		$response = array(
			'status' => 'error',
			'message' => 'Empty'
		);
		$idAsesor = $this->input->post('idAsesor');
		$data = $this->registrolote_modelo->getDataAsesor($idAsesor);
		$loteCancela = array();
		$loteCancela['apellido_materno'] = $data->apellido_materno;
		$loteCancela['apellido_paterno'] = $data->apellido_paterno;
		$loteCancela['contrasena'] = desencriptar($data->contrasena);
		$loteCancela['correo'] = $data->correo;
		$loteCancela['estatus'] = $data->estatus;
		$loteCancela['nombre'] = $data->nombre;
		$loteCancela['rfc'] = $data->rfc;
		$loteCancela['telefono'] = $data->telefono;
		$loteCancela['tiene_hijos'] = $data->tiene_hijos;
		if ($loteCancela != null) {
			$response['status'] = 'ok';
			$response['message'] = 'usuario encontrado';
			$response['loteCancela'] = $loteCancela;
		} else {
			$response['message'] = 'usuario no encontrado';
		}
		echo json_encode($response);
	}
	public function updateAsesor()
	{
		$response = array(
			'status' => 'error',
			'message' => 'empty'
		);
		$idAsesor = $this->input->post('idAsesor');
		$primerNombre = $this->input->post('primerNombre');
		$segundoNombre = $this->input->post('segundoNombre');
		$apellidoPaterno = $this->input->post('apellidoPaterno');
		$apellidoMaterno = $this->input->post('apellidoMaterno');
		$password = $this->input->post('password');
		$hijos = $this->input->post('hijos');
		$rfc = $this->input->post('rfc');
		$primerNombre2 = $primerNombre == NULL ? "" : $primerNombre;
		$segundoNombre2 = $segundoNombre == NULL ? "" : $segundoNombre;
		$apellidoPaterno2 = $apellidoPaterno == NULL ? "" : $apellidoPaterno;
		$apellidoMaterno2 = $apellidoMaterno == NULL ? "" : $apellidoMaterno;
		$nombreAsesor = $primerNombre2 . ' ' . $segundoNombre2 . ' ' . $apellidoPaterno2 . ' ' . $apellidoMaterno2;
		$arregloUser = array();
		$arregloUser["nombre"] = $primerNombre;
		$arregloUser["apellido_paterno"] = $apellidoPaterno;
		$arregloUser["apellido_materno"] = $apellidoMaterno;
		$arregloUser["contrasena"] = encriptar($password);
		$arregloUser["tiene_hijos"] = $hijos;
		$arregloUser["rfc"] = $rfc;
		$data = array(
			'nombre' => $nombreAsesor,
			'correo' => $this->input->post('correo'),
			'telefono' => $this->input->post('telefono')
		);
		$updated = $this->registrolote_modelo->updateAsesor($idAsesor, $data);
		$updatedUsers = $this->registrolote_modelo->updateAsesorUser($idAsesor, $arregloUser);
		if ($updated and $updatedUsers) {
			$response['status'] = 'ok';
			$response['message'] = 'Asesor editado exitosamente';
			$response['$idAsesor'] = $idAsesor;
		} else {
			$response['message'] = 'Asesor no editado';
		}
		echo json_encode($response);
	}
	public function generarCorrida2()
	{
		$datos = array();
		$datos["residencial"] = $this->registrolote_modelo->getResidencialQro();
		$datos["gerentes"] = $this->registrolote_modelo->getGerente();
		$this->load->view("edit_corrida2", $datos);
	}
	function getLotesDisCorrida($condominio, $residencial)
	{
		$data['lotes'] = $this->model_queryinventario->getLotesDis($condominio, $residencial);
		echo "<option>ELIJA LOTE</option>";
		$i = 0;
		while ($i < count($data['lotes'])) {
			echo "<option idLote='" . $data['lotes'][$i]['idLote'] . "' value='" . $data['lotes'][$i]['idLote'] . "'>" . $data['lotes'][$i]['nombreLote'] . "</option>";
			$i++;
		}
	}
	function getDescuetosCorrida($lote)
	{
		$data['lotes'] = $this->registrolote_modelo->registroDesc($lote);
		$data['lotesGet'] = $this->registrolote_modelo->getDescSup($lote);
		if ($data['lotes'] != NULL):
			foreach ($data['lotes'] as $fila):
				echo '<div class="col-md-4 text-center">';
				echo '<div class="panel panel-success panel-pricing">';
				echo '<div class="panel-heading">';
				echo '<h4><input type="radio" id="check1_1" name="check1_1" required="required" /> Paquete: ' . $fila->nombreDescuento . ' <span><center></center></span></h4>';
				echo '</div>';
				echo '<ul style="position: relative; display: block; padding: 10px 15px; margin-bottom: -1px; border: 1px solid #ddd;">';
				if ($fila->idDescFinAd == NULL) {
					echo '<li class="list-group-item"> &nbsp </li>';
				} elseif ($fila->idDescFinAd != NULL) {
					echo '<li class="list-group-item"><input type="checkbox" class="durazno" name="idDescuentoAd" value="' . $fila->idDescuentoAd . '" disabled> ' . $fila->motivoDescuentoAd . ' (' . $fila->descuentoAd . '%)</li>';
				}
				if ($fila->idDescFinPp == NULL) {
					echo '<li class="list-group-item"> &nbsp </li>';
				} elseif ($fila->idDescFinPp != NULL) {
					echo '<li class="list-group-item"><input type="checkbox" name="idDescuentopp" value="' . $fila->idDescuentopp . '" disabled> ' . $fila->motivoDescuentoPp . ' (' . $fila->descuentopp . '%)</li>';
				}
				if ($fila->idDescFinAd2 == NULL) {
					echo '<li class="list-group-item"> &nbsp </li>';
				} elseif ($fila->idDescFinAd2 != NULL) {
					echo '<li class="list-group-item"><input type="checkbox" name="idDescuentoAd2" value="' . $fila->idDescuentoAd2 . '" disabled> ' . $fila->motivoDescuentoAd2 . ' (' . $fila->descuentoAd2 . '%)</li>';
				}
				echo '<li class="list-group-item">';
				echo '<div>';
				$i = 0;
				while ($i < count($data['lotesGet'])) {
					if ($data['lotesGet'][$i]['desc1_1'] != 0) {
						echo '<div id="descSup1_1" class="descSup1_1" style="display: none;">';
						echo '<input id="engSup1" type="checkbox" name="descSup1" value="' . $data['lotesGet'][$i]['desc1_1'] . '" disabled> Enganche del 10% : Descuento del: ' . $data['lotesGet'][$i]['desc1_1'] . '%';
						echo '</div>';
					}
					///////////AQUI LE MOVI///////////////////////
					if ($data['lotesGet'][$i]['desc1_2'] != 0) {
						echo '<div id="descSup1_2" class="descSup1_2" style="display: none;">';
						echo '<input id="engSup2" type="checkbox" name="descSup2" value="' . $data['lotesGet'][$i]['desc1_2'] . '" disabled> Enganche del 15% : Descuento del: ' . $data['lotesGet'][$i]['desc1_2'] . '%';
						echo '</div>';
					}
					///////////AQUI LE MOVI///////////////////////
					echo ' <div id="descSup2_1" class="descSup2_1" style="display: none;">';
					echo '<input id="engSup1" type="checkbox"  name="descSup1" value="' . $data['lotesGet'][$i]['desc2_1'] . '" disabled> Enganche del 10% : Descuento del: ' . $data['lotesGet'][$i]['desc2_1'] . '%';
					echo ' </div>';
					echo ' <div id="descSup2_2" class="descSup2_2" style="display: none;">';
					echo '<input id="engSup2" type="checkbox"  name="descSup2" value="' . $data['lotesGet'][$i]['desc2_2'] . '" disabled> Enganche del 15% : Descuento del: ' . $data['lotesGet'][$i]['desc2_2'] . '%';
					echo ' </div>';
					echo '</div>';
					echo '</li>';
					///////////// INICIO BONOS ///////////////////////////
					echo '<li class="list-group-item">';
					echo '<div>';
					echo ' <div id="bonoOpcion1" class="bonoOpcion1" style="display: none;">';
					echo '<input id="bonoOpcion1" type="checkbox"  name="bonoOpcion1" value="' . $data['lotesGet'][$i]['bonoOpcion1'] . '" class="only-one" disabled> Enganche del 10% : Descuento de: ' . '$' . $data['lotesGet'][$i]['bonoOpcion1'];
					echo ' </div>';
					echo ' <div id="bonoOpcion2" class="bonoOpcion2" style="display: none;">';
					echo '<input id="bonoOpcion1" type="checkbox"  name="bonoOpcion1" value="' . $data['lotesGet'][$i]['bonoOpcion2'] . '" class="only-one" disabled> Enganche del 10% : Descuento de: ' . '$' . $data['lotesGet'][$i]['bonoOpcion2'];
					echo ' </div>';
					echo ' <div id="bonoOpcion3" class="bonoOpcion3" style="display: none;">';
					echo '<input id="bonoOpcion1" type="checkbox"  name="bonoOpcion1" value="' . $data['lotesGet'][$i]['bonoOpcion3'] . '" class="only-one" disabled> Enganche del 10% : Descuento de: ' . '$' . $data['lotesGet'][$i]['bonoOpcion3'];
					echo ' </div>';
					// FIN BONOS  ///////////////////////////
					$i++;
				}
				echo '</div>';
				echo '</li>';
				echo '<input type="button" class="btn btn-lg btn-block btn-success" value="Generar Corrida" onclick="return foo();" disabled>';
				echo '</ul>';
				echo '</div>';
				echo '</div>';
			endforeach;
		endif;
		?>
				<script type="text/javascript">
					$("input[name='check1_1']").click(function () {
						$('.panel-pricing input[type=checkbox]').prop('disabled', true).prop('checked', false);
						$('.panel-pricing input[type=button]').prop('disabled', true);
						$('ul').css("background-color", "white");
						$(this).closest('.panel-pricing').find('input[type=checkbox]').prop('disabled', false);
						$(this).closest('.panel-pricing').find('input[type=button]').prop('disabled', false);
						$(this).closest('.panel-pricing').find('ul').css("background-color", "#d2d6de");
					});
					let Checked = null;
					for (let CheckBox of document.getElementsByClassName('only-one')) {
						CheckBox.onclick = function () {
							if (Checked != null) {
								Checked.checked = false;
								Checked = CheckBox;
							}
							Checked = CheckBox;
						}
					}
				</script>
				<?php
	}
	function getLotesupDis($lote)
	{
		$data['lotes'] = $this->model_queryinventario->getLotesInfoCorrida($lote);
		$i = 0;
		while ($i < count($data['lotes'])) {
			echo "<input type='text' name='idLote' id='idLote' value='" . $data['lotes'][$i]['idLote'] . "'/>";
			echo "<input type='text' name='sup' id='sup' value='" . $data['lotes'][$i]['sup'] . "'/>";
			echo "<input type='text' name='precio' id='precio' value='" . $data['lotes'][$i]['precio'] . "'/>";
			echo "<input type='text' name='total' id='total' value='" . $data['lotes'][$i]['total'] . "'/>";
			echo "<input type='text' name='porcentaje' id='porcentaje' value='" . $data['lotes'][$i]['porcentaje'] . "'/>";
			echo "<input type='text' name='enganche' id='enganche' value='" . $data['lotes'][$i]['enganche'] . "'/>";
			echo "<input type='text' name='total1' id='total1' value='" . $data['lotes'][$i]['total'] . "'/>";
			echo "<input type='text' name='msni' id='msni' value='" . $data['lotes'][$i]['msni'] . "'/>";
			echo "<input type='text' name='msni' id='msni' value='" . $data['lotes'][$i]['msni'] . "'/>";
			echo "<input type='text' name='referencia' id='referencia' value='" . $data['lotes'][$i]['referencia'] . "'/>";
			echo "<input type='text' name='empresa' id='empresa' value='" . $data['lotes'][$i]['empresa'] . "'/>";
			echo "<input type='text' name='banco' id='banco' value='" . $data['lotes'][$i]['banco'] . "'/>";
			echo "<input type='text' name='cuenta' id='cuenta' value='" . $data['lotes'][$i]['cuenta'] . "'/>";
			echo "<input type='text' name='clabe' id='clabe' value='" . $data['lotes'][$i]['clabe'] . "'/>";
			?>
						<script language='javascript'>
							$(document).ready(function () {
								$('#idLote').val(<?= $data['lotes'][$i]['idLote']; ?>);
								$('#sup').val(<?= $data['lotes'][$i]['sup']; ?>);
								$('#precio').val(<?= $data['lotes'][$i]['precio']; ?>);
								$('#total').val(<?= $data['lotes'][$i]['total']; ?>);
								$('#porcentaje').val(<?= $data['lotes'][$i]['porcentaje']; ?>);
								$('#enganche').val(<?= $data['lotes'][$i]['enganche']; ?>);
								$('#total1').val(<?= $data['lotes'][$i]['total']; ?>);
								$('#msni').val(<?= $data['lotes'][$i]['msni']; ?>);
								$('#msni').val(<?= $data['lotes'][$i]['msni']; ?>);
								$('#referencia').val(<?= $data['lotes'][$i]['referencia']; ?>);
								$('#empresa').val("<?= $data['lotes'][$i]['empresa']; ?>");
								$('#banco').val("<?= $data['lotes'][$i]['banco']; ?>");
								$('#cuenta').val("<?= $data['lotes'][$i]['cuenta']; ?>");
								$('#clabe').val("<?= $data['lotes'][$i]['clabe']; ?>");
							});
						</script>
						<?php
						$i++;
		}
	}
	public function updateLoteDescSup()
	{
		$cluster = $_POST['filtro4_sup'];
		$pack = $_POST['idDescuentoSup'];
		if ($this->registrolote_modelo->updateDescPackSup($cluster, $pack)) {
			redirect(base_url() . "index.php/registroLote/create_descuento");
		} else {
			die("ERROR");
		}
	}
	public function insertProntoPago()
	{
		$motivopp = $this->input->post('motivopp');
		$descuentopp = $this->input->post('descuentopp');
		$aplicapp = $this->input->post('aplicapp');
		$arreglo = array();
		$arreglo["motivo"] = $motivopp;
		$arreglo["descuento"] = $descuentopp;
		$arreglo["aplica"] = $aplicapp;
		if ($this->registrolote_modelo->insertProntoPago($arreglo)) {
			redirect(base_url() . "index.php/registroLote/create_descuento");
		} else {
			die("ERROR");
		}
	}
	public function insertDescAd()
	{
		$motivoad = $this->input->post('motivoad');
		$descuentoad = $this->input->post('descuentoad');
		$aplicaad = $this->input->post('aplicaad');
		$arreglo = array();
		$arreglo["motivo"] = $motivoad;
		$arreglo["porcentaje"] = $descuentoad;
		$arreglo["aplica"] = $aplicaad;
		if ($this->registrolote_modelo->insertDescAd($arreglo)) {
			redirect(base_url() . "index.php/registroLote/create_descuento");
		} else {
			die("ERROR");
		}
	}
	public function insertDescFin()
	{
		$idDescuentoAd = $this->input->post('idDescuentoAd');
		$idDescuentopp = $this->input->post('idDescuentopp');
		$nombreDescuento = $this->input->post('nombreDescuento');
		$fecha = $this->input->post('reservation');
		list($fechaInicio, $fechaFin) = explode('|', $fecha);
		$idDescuentoAd2 = $this->input->post('idDescuentoAd2');
		$arreglo = array();
		$arreglo["idDescuentoAd"] = $idDescuentoAd;
		$arreglo["idDescuentopp"] = $idDescuentopp;
		$arreglo["nombreDescuento"] = $nombreDescuento;
		$arreglo["fechaInicio"] = $fechaInicio;
		$arreglo["fechaFin"] = $fechaFin;
		$arreglo["idDescuentoAd2"] = $idDescuentoAd2;
		if ($this->registrolote_modelo->insertDescFin($arreglo)) {
			redirect(base_url() . "index.php/registroLote/create_descuento");
		} else {
			die("ERROR");
		}
	}
	public function insertPackDesc()
	{
		///TREAEMOS DATOS
		$cluster = $_POST['filtro4'];
		$pack = $_POST['id_descuento'];
		///CONSULTAMOS LOS DESCUENTOS ACTUALES Y ACTIVOS DE ACUERDO AL CLUSTER
		$descAct = array();
		$descAct = $this->registrolote_modelo->descuentosActuales($cluster);
		///// EL RESULTADO LO CONVERTIMOS A STRING
		$sep = ',';
		$str = '';
		foreach ($descAct as $val) {
			$str .= implode($sep, $val);
			$str .= $sep;
		}
		$str = rtrim($str, $sep);
		//CONVERTIMOS A ARREGLO TANTO LOS DESCUENTOS ACTUALES COMO EL NUEVO A AGREGAR
		$anexaDesc = explode(",", $pack);
		$anexaDesc2 = explode(",", $str);
		//// CHECAMOS SI EN EL ARREGLO NO HAY POSICIONES VACIAS Y LAS ELIMINAMOS
		$listCheckVacio = array_filter($anexaDesc, "strlen");
		$listCheckVacio2 = array_filter($anexaDesc2, "strlen");
		////////LOS UNIMOS EN UN SOLO ARREGLO
		$resultado = array_merge_recursive($listCheckVacio, $listCheckVacio2);
		////VERIFICAMOS QUE NUESTRO ARREGLO NO TENGA DATOS REPETIDOS
		$arrayNotRepeat = array_unique($resultado);
		////EL ARREGLO FINAL LO CONVERTIMOS A STRING
		$res = implode(",", $arrayNotRepeat);
		//////// Y FIN LO ENVIAMos//////////
		if ($this->registrolote_modelo->updateDescPack($cluster, $res)) {
			redirect(base_url() . "index.php/registroLote/create_descuento");
		} else {
			die("ERROR");
		}
	}
	public function eventBloqueos()
	{
		$datos = array();
		$datos = $this->registrolote_modelo->getBloqueos();
		foreach ($datos as $bloqueosAct) {
			if ($bloqueosAct[0]['idStatusLote'] <> 8) {
				$data = array();
				$data["idLote"] = $bloqueosAct[0]['idLote'];
				$descAct = $this->registrolote_modelo->updateStatusBloqueo($data);
			}
		}
	}

	public function getDatosClientesChangeAsesor()
	{
		$datos = array();
		$datos["residencial"] = $this->registrolote_modelo->getResidencialQro();
		$datos["gerentes"] = $this->registrolote_modelo->getGerente();
		$this->load->view('changeAsesorVenta_view', $datos);
	}
	function tableClienteChange()
	{
		$data['data'] = $this->registrolote_modelo->getClienteChangeAsesor($idCondominio = $this->input->post('idCondominio'));
		echo json_encode($data);
	}
	public function updateClienteAsesor()
	{
		if (isset($_POST) && !empty($_POST)) {
			$idLote = $this->input->post('idLote');
			$idAsesor = $this->input->post('idAsesor');
			$asesor = $this->input->post('asesor');
			if ($this->registrolote_modelo->updateChangeAsesor($idLote, $idAsesor, $asesor)) {
			} else {
				die("ERROR");
			}
		}
	}
	public function datosStatus15()
	{
		$datos = array();
		$datos["residencial"] = $this->registrolote_modelo->getResidencialQro();
		$this->load->view('datos_regresoStatus15_view', $datos);
	}
	function tableStatus15()
	{
		$data['data'] = $this->registrolote_modelo->getStatus15($idCondominio = $this->input->post('idCondominio'));
		echo json_encode($data);
	}
	public function getInfoReturnStatus15()
	{
		$idLote = $this->input->post("idLote");
		$datos = $this->registrolote_modelo->selectRegistroLoteCaja($idLote);
		echo json_encode($datos);
	}
	public function updateReturnStatus15()
	{
		if (isset($_POST) && !empty($_POST)) {
			$idLote = $this->input->post('idLote');
			$idCondominio = $this->input->post('idCondominio');
			$nombreLote = $this->input->post('nombreLote');
			$idCliente = $this->input->post('idCliente');
			$comentario = $this->input->post('comentario');
			$user = $this->input->post('user');
			$perfil = $this->input->post('perfil');
			$arreglo = array();
			$arreglo["idStatusContratacion"] = 14;
			$arreglo["idMovimiento"] = 80;
			$arreglo["comentario"] = $comentario;
			$arreglo["user"] = $this->session->userdata('username');
			$arreglo["perfil"] = $this->session->userdata('perfil');
			$arreglo["idStatusLote"] = 3;
			$arreglo["modificado"] = date("Y-m-d H:i:s");
			$arreglo["fechaVenc"] = date("Y-m-d H:i:s");
			$arreglo2 = array();
			$arreglo2["idStatusContratacion"] = 14;
			$arreglo2["idMovimiento"] = 80;
			$arreglo2["comentario"] = $comentario;
			$arreglo2["user"] = $this->session->userdata('username');
			$arreglo2["perfil"] = $this->session->userdata('perfil');
			$arreglo2["modificado"] = date("Y-m-d H:i:s");
			$arreglo2["fechaVenc"] = date("Y-m-d H:i:s");
			$arreglo2["idLote"] = $idLote;
			$arreglo2["nombreLote"] = $nombreLote;
			$arreglo2["idCondominio"] = $idCondominio;
			$arreglo2["idCliente"] = $idCliente;
			if ($this->registrolote_modelo->editaRegistroLoteCaja($idLote, $arreglo)) {
				$this->registrolote_modelo->insertHistorialLotes($arreglo2);
			} else {
				die("ERROR");
			}
		}
	}
	public function registrosLoteVentasAsesor()
	{
		$datos = array();
		$datos["registrosLoteVentasAsistentes"] = $this->registrolote_modelo->registroLote();
		$datos["residencial"] = $this->registrolote_modelo->getResidencialQro();
		if ($this->session->userdata('perfil') == FALSE || $this->session->userdata('perfil') != 'asesor') {
			redirect(base_url() . 'login');
		}
		$this->load->view("template/header");
		$this->load->view("asesor/datos_lote_ventasAsesor_view", $datos);
	}
	public function insertdmc()
	{
		$desc1_1 = $this->input->post('desc1_1');
		$nombredescSup = $this->input->post('nombredescSup');
		$bonoOpcion1 = $this->input->post('bonoOpcion1');
		$bonoOpcion2 = $this->input->post('bonoOpcion2');
		$bonoOpcion3 = $this->input->post('bonoOpcion3');
		$preciomc = $this->input->post('preciomc');
		$preciomc2 = $this->input->post('preciomc2');
		$dato = array();
		if (!empty($preciomc)) {
			$dato["desc1_1"] = $desc1_1;
			$dato["preciomc"] = $preciomc;
			$dato["motivo"] = $nombredescSup;
			$dato["bonoOpcion1"] = $bonoOpcion1;
			$dato["bonoOpcion2"] = $bonoOpcion2;
			$dato["bonoOpcion3"] = $bonoOpcion3;
			$dato["options"] = '1';
		} else if (!empty($preciomc2)) {
			$dato["desc1_1"] = $desc1_1;
			$dato["preciomc"] = $preciomc2;
			$dato["motivo"] = $nombredescSup;
			$dato["bonoOpcion1"] = $bonoOpcion1;
			$dato["bonoOpcion2"] = $bonoOpcion2;
			$dato["bonoOpcion3"] = $bonoOpcion3;
			$dato["options"] = '0';
		}
		if ($this->registrolote_modelo->descmc($dato)) {
			redirect(base_url() . "index.php/registroLote/create_descuento");
		} else {
			die("ERROR");
		}
	}
	public function updateLoteDescMC()
	{
		$cluster = $_POST['filtro4_mc'];
		$pack = $_POST['idDescuentoSup'];
		if ($this->registrolote_modelo->updateDescPackMC($cluster, $pack)) {
			redirect(base_url() . "index.php/registroLote/create_descuento");
		} else {
			die("ERROR");
		}
	}
	public function registrosLoteReferencia()
	{
		$datos = array();
		$datos["residencial"] = $this->registrolote_modelo->getResidencialQro();
		$this->load->view('datos_lote_referencia_view', $datos);
	}
	function getLotesInventarioGralCM($condominio, $residencial)
	{
		$data['data'] = $this->registrolote_modelo->getInventario($condominio, $residencial);
		echo json_encode($data);
	}
	// Consulta todos los lotes por proyecto
	function getLotesInventarioXproyecto($residencial)
	{
		$data['data'] = $this->registrolote_modelo->getInventarioXproyecto($residencial);
		echo json_encode($data);
	}
	// Finaliza consulta de lotes por proyecto
	// Consulta todos los lotes por proyecto todos por status
	function getLotesInventarioXproyectoTodosStatus($status)
	{
		$data['data'] = $this->registrolote_modelo->getInventarioXproyectoTodosStatus($status);
		echo json_encode($data);
	}
	// Finaliza consulta de lotes por proyecto
	// Consulta todos los lotes por proyecto con condominio y status
	function getLotesInventarioGralproyectoYcondominioXstatus($residencial, $condominio, $status)
	{
		$data['data'] = $this->registrolote_modelo->getInventarioXproyectoCondominioStatus($residencial, $condominio, $status);
		echo json_encode($data);
	}
	// Consulta todos los lotes por proyecto por status
	function getLotesInventarioXproyectoStatus($residencial, $status)
	{
		$data['data'] = $this->registrolote_modelo->getInventarioXproyectoStatus($residencial, $status);
		echo json_encode($data);
	}
	// Finaliza consulta de lotes por proyecto
	// Tabla de Consulta todos
	function getLotesInventarioGralTodos()
	{
		$data['data'] = $this->registrolote_modelo->getInventarioTodos();
		echo json_encode($data);
	}
	// Fin de consulta tabla todos
	function getStatus()
	{
		$data = $this->registrolote_modelo->getStatus();
		if ($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
		exit;
	}
	function getMeses($residencial)
	{
		$data = $this->registrolote_modelo->getMeses($residencial);
		if ($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
		exit;
	}
	function getLotesInventarioXproyectoc($residencial)
	{
		$data = $this->registrolote_modelo->getInventarioXproyectoc($residencial);
		if ($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
		exit;
	}
	function getLotesInventarioGralc($residencial, $condominio)
	{
		$data = $this->registrolote_modelo->getInventarioc($residencial, $condominio);
		if ($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
		exit;
	}
	function getThreeGroup($grupo)
	{
		$data = $this->registrolote_modelo->getThreeGroup($grupo);
		if ($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
		exit;
	}
	function getTwoGroup($residencial, $grupo)
	{
		$data = $this->registrolote_modelo->getTwoGroup($residencial, $grupo);
		if ($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
		exit;
	}
	function getFourGroup($residencial, $grupo)
	{
		$data = $this->registrolote_modelo->getFourGroup($residencial, $grupo);
		if ($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
		exit;
	}
	function getOneGroup($condominio, $grupo)
	{
		$data = $this->registrolote_modelo->getOneGroup($condominio, $grupo);
		if ($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
		exit;
	}
	function getLotesInventarioGralTodosc()
	{
		$data = $this->registrolote_modelo->getInventarioTodosc();
		if ($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
		exit;
	}
	function getSup($residencial, $sup)
	{
		$data = $this->registrolote_modelo->getSup($residencial, $sup);
		if ($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
		exit;
	}
	function getSupOne($residencial)
	{
		$data = $this->registrolote_modelo->getSupOne($residencial);
		if ($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
		exit;
	}
	function getPrecio($residencial)
	{
		$data = $this->registrolote_modelo->getPrecio($residencial);
		if ($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
		exit;
	}
	function getTotal($residencial)
	{
		$data = $this->registrolote_modelo->getTotal($residencial);
		if ($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
		exit;
	}
	function getSupTwo($residencial, $condominio, $sup)
	{
		$data = $this->registrolote_modelo->getSupTwo($residencial, $condominio, $sup);
		if ($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
		exit;
	}
	function getPreciomResidencial($residencial, $preciom)
	{
		$data = $this->registrolote_modelo->getPreciomResidencial($residencial, $preciom);
		if ($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
		exit;
	}
	function getPreciomCluster($residencial, $condominio, $preciom)
	{
		$data = $this->registrolote_modelo->getPreciomCluster($residencial, $condominio, $preciom);
		if ($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
		exit;
	}
	function getPreciotResidencial($residencial, $preciot)
	{
		$data = $this->registrolote_modelo->getPreciotResidencial($residencial, $preciot);
		if ($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
		exit;
	}
	function getPreciotCluster($residencial, $condominio, $preciot)
	{
		$data = $this->registrolote_modelo->getPreciotCluster($residencial, $condominio, $preciot);
		if ($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
		exit;
	}
	function getMesesResidencial($residencial, $meses)
	{
		$data = $this->registrolote_modelo->getMesesResidencial($residencial, $meses);
		if ($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
		exit;
	}
	function getMesesCluster($residencial, $condominio, $meses)
	{
		$data = $this->registrolote_modelo->getMesesCluster($residencial, $condominio, $meses);
		if ($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
		exit;
	}
	function getEmpy()
	{
		$data = [];
		echo json_encode($data);
	}
	function getLotesInventarioGralAll()
	{
		$data['data'] = $this->registrolote_modelo->getInventarioTodos();
		echo json_encode($data);
	}
	// Fin de consulta tabla todos  LOS LOTES SIN FILTRO
	public function historialProcesoLoteOp()
	{
		$idLote = $this->input->post("idLote");
		$response['data'] = $this->registrolote_modelo->historialProcesoFin($idLote);
		echo json_encode($response);
	}
	public function registrosLoteUpdatePrecio()
	{
		$datos = array();
		$datos["residencial"] = $this->registrolote_modelo->getResidencialQro();
		$this->load->view('datos_lote_updatePrecio_view', $datos);
	}
	public function historialBloqueos()
	{
		$idLote = $this->input->post("idLote");
		$response['data'] = $this->registrolote_modelo->historialBloqueo($idLote);
		echo json_encode($response);
	}
	public function envioRevisionVentas3aJuridico7()
	{
		$aleatorio = rand(100, 1000);
		$idLote = $this->input->post('idLote');
		$nombreLote = $this->input->post('nombreLote');
		$observaciones = $this->input->post('observaciones');
		$fechaVenc = $this->input->post('fechaVenc');
		$idCliente = $this->input->post('idCliente');
		$idCondominio = $this->input->post('idCondominio');
		$expedienteNombre = $_FILES["expediente"]["name"];
		$datos["getInfoAsRechazoEst3"] = $this->registrolote_modelo->getInfoAsRechazoEst3($idLote);
		$nombreResidencial = $datos["getInfoAsRechazoEst3"]["nombreResidencial"];
		$nombreCondominio = $datos["getInfoAsRechazoEst3"]["nombreCondominio"];
		$proyecto = str_replace(' ', '', $nombreResidencial);
		$condominio = str_replace(' ', '', $nombreCondominio);
		$condom = substr($condominio, 0, 3);
		$cond = strtoupper($condom);
		$numeroLote = preg_replace('/[^0-9]/', '', $nombreLote);
		$date = date('dmY');
		$composicion = $proyecto . "_" . $cond . $numeroLote . "_" . $date;
		$nombArchivo = $composicion;
		$expediente = $nombArchivo . '_' . $idCliente . '_' . $aleatorio . '_' . $expedienteNombre;
		$arreglo2 = array();
		$arreglo2["movimiento"] = "Se adjunto Expediente (Ventas)";
		$arreglo2["idCliente"] = $idCliente;
		$arreglo2["idLote"] = $idLote;
		$arreglo2["expediente"] = $expediente;
		$arreglo2["idUser"] = $this->session->userdata('id');
		$arreglo2["idCondominio"] = $idCondominio;
		$datos = $this->registrolote_modelo->getInfoAsRechazoEst3($idLote);
		$arreglo = array();
		$arreglo["idStatusContratacion"] = 7;
		$arreglo["idMovimiento"] = 83;
		$arreglo["comentario"] = $observaciones;
		$arreglo["usuario"] = $this->session->userdata('usuario');
		$arreglo["perfil"] = $this->session->userdata('perfil');
		$arreglo["modificado"] = date("Y-m-d H:i:s");
		date_default_timezone_set('America/Mexico_City');
		$horaActual = date('H:i:s');
		$horaInicio = date("08:00:00");
		$horaFin = date("16:00:00");
		if ($horaActual > $horaInicio and $horaActual < $horaFin) {
			$fechaAccion = date("Y-m-d H:i:s");
			$hoy_strtotime2 = strtotime($fechaAccion);
			$sig_fecha_dia2 = date('D', $hoy_strtotime2);
			$sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
			if (
				$sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
				$sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
				$sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
				$sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
				$sig_fecha_feriado2 == "25-12"
			) {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 2) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				$arreglo["fechaVenc"] = $fecha;
			} else {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 1) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				$arreglo["fechaVenc"] = $fecha;
			}
		} elseif ($horaActual < $horaInicio || $horaActual > $horaFin) {
			$fechaAccion = date("Y-m-d H:i:s");
			$hoy_strtotime2 = strtotime($fechaAccion);
			$sig_fecha_dia2 = date('D', $hoy_strtotime2);
			$sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
			if (
				$sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
				$sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
				$sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
				$sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
				$sig_fecha_feriado2 == "25-12"
			) {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 2) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				$arreglo["fechaVenc"] = $fecha;
			} else {
				$fecha = $fechaAccion;
				$i = 0;
				while ($i <= 2) {
					$hoy_strtotime = strtotime($fecha);
					$sig_strtotime = strtotime('+1 days', $hoy_strtotime);
					$sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
					$sig_fecha_dia = date('D', $sig_strtotime);
					$sig_fecha_feriado = date('d-m', $sig_strtotime);
					if (
						$sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
						$sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
						$sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
						$sig_fecha_feriado == "25-12"
					) {
					} else {
						$fecha = $sig_fecha;
						$i++;
					}
					$fecha = $sig_fecha;
				}
				$arreglo["fechaVenc"] = $fecha;
			}
		}
		$arreglo2 = array();
		$arreglo2["idStatusContratacion"] = 7;
		$arreglo2["idMovimiento"] = 83;
		$arreglo2["nombreLote"] = $nombreLote;
		$arreglo2["comentario"] = $observaciones;
		$arreglo2["usuario"] = $this->session->userdata('usuario');
		$arreglo2["perfil"] = $this->session->userdata('perfil');
		$arreglo2["modificado"] = date("Y-m-d H:i:s");
		$arreglo2["fechaVenc"] = $fechaVenc;
		$arreglo2["idLote"] = $idLote;
		$arreglo2["idCondominio"] = $datos["idCondominio"];
		$arreglo2["idCliente"] = $datos["idCliente"];
		$arreglov = array();
		$arreglov["expediente"] = $nombArchivo . '_' . $idCliente . '_' . $aleatorio . '_' . $expedienteNombre;
		$arregloD = array();
		$arregloD["movimiento"] = "Se adjunto Expediente (Ventas)";
		$arregloD["idCliente"] = $datos["idCliente"];
		$arregloD["idLote"] = $idLote;
		$arregloD["expediente"] = $nombArchivo . '_' . $idCliente . '_' . $aleatorio . '_' . $expedienteNombre;
		$arregloD["idUser"] = $this->session->userdata('id');
		$arregloD["idCondominio"] = $this->input->post('idCondominio');
		if (move_uploaded_file($_FILES["expediente"]["tmp_name"], "static/documentos/cliente/expediente/" . $nombArchivo . '_' . $idCliente . '_' . $aleatorio . '_' . $expedienteNombre)) {
			$this->registrolote_modelo->editaRegistroLoteCaja($idLote, $arreglo);
			$this->registrolote_modelo->editaRegistroCliente($idCliente, $arreglov);
			$this->registrolote_modelo->insert_historial_documento($arregloD);
			$this->registrolote_modelo->insertHistorialLotes($arreglo2);
		}
	}
	public function getResidencialesGeneral()
	{
		$datos = $this->registrolote_modelo->getResidencial();
		if ($datos != null) {
			echo json_encode($datos);
		} else {
			echo json_encode(array());
		}
	}
	public function validateSession()
	{
		if ($this->session->userdata('id_usuario') == "" || $this->session->userdata('id_rol') == "") {
			redirect(base_url() . "index.php/login");
		}
	}
	/////////////////////// NEW MAJO /////////////////////
	public function getdbanco()
	{
		$datos["banco"] = $this->registrolote_modelo->table_datosBancarios();
		echo json_encode($datos);
	}
	public function getEtapa()
	{
		$datos["etapa"] = $this->registrolote_modelo->table_etapa();
		echo json_encode($datos);
	}
	public function insertCluster()
	{
		$nombre = $this->input->post('nombre');
		$residencial = $this->input->post('residencial');
		$tipo_lote = $this->input->post('tipo_lote');
		$etapa = $this->input->post('etapa');
		$banco = $this->input->post('banco');
		$arreglo = array();
		$arreglo["nombre"] = $nombre;
		$arreglo["idResidencial"] = $residencial;
		$arreglo["msni"] = 36;
		$arreglo["tipo_lote"] = $tipo_lote;
		$arreglo["idEtapa"] = $etapa;
		$arreglo["idDBanco"] = $banco;
		$this->registrolote_modelo->insert_cluster($arreglo);
	}
	function uploadLotes()
	{
		$this->registrolote_modelo->uploadLotes($this->input->post('idCondominio'));
	}
	public function uploadPrecio()
	{
		$this->registrolote_modelo->uploadPrecio($this->input->post('idCondominio'));
	}
	public function uploadReferencia()
	{
		$this->registrolote_modelo->uploadReferencias($this->input->post('idCondominio'));
	}
	function aplicaLiberacion()
	{
		$valida = ($this->input->post('checkls') == NULL) ? 0 : 1;
		$this->registrolote_modelo->aplicaLiberaciones($this->input->post('filtro4'), $valida);
	}
	public function get_auts_by_lote_directivos($idLote)
	{
		$data = $this->registrolote_modelo->get_auts_by_lote_directivos($idLote);
		if ($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
	}
	function get_auts_by_lote($idLote)
	{
		$data = $this->registrolote_modelo->get_auts_by_lote($idLote);
		if ($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
	}
	public function reporteStatus11()
	{
		$this->load->view('template/header');
		$this->load->view('administracion/vista_rechazos_estatus_11');
	}
	public function getReporteStatus11()
	{
		$data = $this->registrolote_modelo->getReporteStatus11();
		$dataPer = array();
		for ($i = 0; $i < count($data); $i++) {
			$dataPer[$i]['nombreResidencial'] = $data[$i]->nombreResidencial;
			$dataPer[$i]['nombreCondominio'] = $data[$i]->nombreCondominio;
			$dataPer[$i]['nombreLote'] = $data[$i]->nombreLote;
			$dataPer[$i]['idLote'] = $data[$i]->idLote;
			$dataPer[$i]['nombreCliente'] = $data[$i]->nombreCliente;
			$dataPer[$i]['fechaApartado'] = $data[$i]->fechaApartado;
			$dataPer[$i]['estatusActual'] = $data[$i]->estatusActual;
			$dataPer[$i]['estatusLote'] = $data[$i]->estatusLote;
			$dataPer[$i]['usuario'] = $data[$i]->usuario;
			$dataPer[$i]['fechaRechazo'] = $data[$i]->fechaRechazo;
			$dataPer[$i]['motivoRechazo'] = $data[$i]->motivoRechazo;
		}
		if ($dataPer != null) {
			echo json_encode($dataPer);
		} else {
			echo json_encode(array());
		}
	}
	//Reporte lotes apartados
	public function reporteLotesApartados()
	{
		$this->load->view('template/header');
		$this->load->view('administracion/vista_reportes_gerencial');
	}
	public function getReporteLotesApartados()
	{
		$data = $this->registrolote_modelo->getLotesApartados();
		$dataPer = array();
		for ($i = 0; $i < count($data); $i++) {
			$dataPer[$i]['nombreResidencial'] = $data[$i]->nombreResidencial;
			$dataPer[$i]['nombreCondominio'] = $data[$i]->nombreCondominio;
			$dataPer[$i]['nombreLote'] = $data[$i]->nombreLote;
			$dataPer[$i]['idLote'] = $data[$i]->idLote;
			$dataPer[$i]['nombreCliente'] = $data[$i]->nombreCliente;
			$dataPer[$i]['fechaApartado'] = $data[$i]->fechaApartado;
			$dataPer[$i]['estatusLote'] = $data[$i]->estatusLote;
			$dataPer[$i]['estatusContratacion'] = $data[$i]->estatusContratacion;
			$dataPer[$i]['movimiento'] = $data[$i]->movimiento;
			$dataPer[$i]['asesor'] = $data[$i]->asesor;
			$dataPer[$i]['coordinador'] = $data[$i]->coordinador;
			$dataPer[$i]['gerente'] = $data[$i]->gerente;
			$dataPer[$i]['subdirector'] = $data[$i]->subdirector;
			$dataPer[$i]['regional'] = $data[$i]->regional;
		}
		if ($dataPer != null) {
			echo json_encode($dataPer);
		} else {
			echo json_encode(array());
		}
	}
	public function reporteRechazos()
	{
		$this->load->view('template/header');
		$this->load->view('administracion/vista_rechazos');
	}
	public function getReporteRechazos()
	{
		$data = $this->registrolote_modelo->getReporteRechazos();
		$dataPer = array();
		for ($i = 0; $i < count($data); $i++) {
			$dataPer[$i]['nombreResidencial'] = $data[$i]->nombreResidencial;
			$dataPer[$i]['nombreCondominio'] = $data[$i]->nombreCondominio;
			$dataPer[$i]['nombreLote'] = $data[$i]->nombreLote;
			$dataPer[$i]['idLote'] = $data[$i]->idLote;
			$dataPer[$i]['nombreCliente'] = $data[$i]->nombreCliente;
			$dataPer[$i]['fechaApartado'] = $data[$i]->fechaApartado;
			$dataPer[$i]['estatusActual'] = $data[$i]->estatusActual;
			$dataPer[$i]['estatusLote'] = $data[$i]->estatusLote;
			$dataPer[$i]['usuario'] = $data[$i]->usuario;
			$dataPer[$i]['fechaRechazo'] = $data[$i]->fechaRechazo;
			$dataPer[$i]['motivoRechazo'] = $data[$i]->motivoRechazo;
			$dataPer[$i]['movimiento'] = $data[$i]->movimiento;
		}
		if ($dataPer != null) {
			echo json_encode($dataPer);
		} else {
			echo json_encode(array());
		}
	}


    public function getAutorizacionesClientePorLote($idLote)
    {
        $data = $this->registrolote_modelo->getAutorizacionesClientePorLote($idLote);
        echo json_encode($data);
    }
}
