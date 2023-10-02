<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Reestructura extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
        $this->load->model(array('Reestructura_model','General_model', 'caja_model_outside'));
        $this->load->library(array('session','form_validation', 'get_menu','permisos_sidebar'));
		$this->load->helper(array('url', 'form'));
		$this->load->database('default');
        date_default_timezone_set('America/Mexico_City');
		$this->validateSession();

        $val =  $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        $_SESSION['rutaController'] = str_replace('' . base_url() . '', '', $val);
		$rutaUrl = explode($_SESSION['rutaActual'], $_SERVER["REQUEST_URI"]);
        $this->permisos_sidebar->validarPermiso($this->session->userdata('datos'),$rutaUrl[1],$this->session->userdata('opcionesMenu'));
    }

    public function validateSession() {
		if($this->session->userdata('id_usuario') == "" || $this->session->userdata('id_rol') == "")
			redirect(base_url() . "index.php/login");
	}

	public function index(){
		$this->load->view('template/header');
		$this->load->view("template/home");
		$this->load->view('template/footer');
	}

	public function reubicarCliente(){
		$this->load->view('template/header');
        $this->load->view("reestructura/reubicarCliente_view");
	}	

    public function getListaClientesReubicar(){
        $data = $this->Reestructura_model->getListaClientesReubicar();
        echo json_encode($data);
    }

	public function getProyectosDisponibles(){
		$idProyecto = $this->input->post('idProyecto');
		$superficie = $this->input->post('superficie');
		$tipoLote = $this->input->post('tipoLote');

		$data = $this->Reestructura_model->getProyectosDisponibles($idProyecto, $superficie, $tipoLote);
        echo json_encode($data);
    }

	public function getCondominiosDisponibles(){
		$idProyecto = $this->input->post('idProyecto');
		$superficie = $this->input->post('superficie');
		$tipoLote = $this->input->post('tipoLote');

		$data = $this->Reestructura_model->getCondominiosDisponibles($idProyecto, $superficie, $tipoLote);
        if ($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

	public function getLotesDisponibles(){
		$idCondominio = $this->input->post('idCondominio');
        $superficie = $this->input->post('superficie');

		$data = $this->Reestructura_model->getLotesDisponibles($idCondominio, $superficie);
        if ($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
	}

	public function reestructura(){
		$this->load->view('template/header');
        $this->load->view("reestructura/reestructura_view");
    }

    public function lista_proyecto(){
        $bandera = $this->input->post('bandera');
		if($this->session->userdata('id_rol') == 2 || $this->session->userdata('id_usuario') == 10878)
			echo json_encode($this->Reestructura_model->get_proyecto_listaCancelaciones()->result_array());
		else if($this->session->userdata('id_usuario') == 5107 && $bandera == 1) // MJ: SELECT DE LA VISTA LIBERAR
          echo json_encode($this->Reestructura_model->get_proyecto_lista_yola()->result_array());
        else // MJ: SELECT DE LA VISTA reestructura
            echo json_encode($this->Reestructura_model->get_proyecto_lista(1)->result_array());
    }

	public function lista_catalogo_opciones(){
		echo json_encode($this->Reestructura_model->get_catalogo_resstructura()->result_array());
	}

	public function insertarOpcionN (){
		$idOpcion = $this->Reestructura_model->insertOpcion();
		$idOpcion = $idOpcion->lastId;
		$dataPost = $_POST;
		$datos["id"] = $idOpcion;
		$datos["nombre"] = $dataPost['nombre'];
		$datos["fecha_creacion"] = date('Y-m-d H:i:s');

		$insert = $this->Reestructura_model->nuevaOpcion($datos);

		if ($insert == TRUE) {
			$response['message'] = 'SUCCESS';
			echo json_encode(1);
		} else {
			$response['message'] = 'ERROR';
			echo json_encode(0);
		}
	}

	public function borrarOpcion(){

		$dataPost = $_POST;
		$datos["idOpcion"] = $dataPost['idOpcion'];
		$update = $this->Reestructura_model->borrarOpcionModel($datos);

		if ($update == TRUE) {
			$response['message'] = 'SUCCESS';
			echo json_encode(1);
		} else {
			$response['message'] = 'ERROR';
			echo json_encode(0);
		}
	}

	public function getHistorial($id_prospecto){
        echo json_encode($this->Reestructura_model->historialModel($id_prospecto)->result_array());
    }

	public function editarOpcion(){
		$dataPost = $_POST;
		$datos["idOpcionEdit"] = $dataPost['idOpcionEdit'];
		$datos["editarCatalogo"] = $dataPost['editarCatalogo'];
		$update = $this->Reestructura_model->editarOpcionModel($datos);

		if ($update == TRUE) {
			$response['message'] = 'SUCCESS';
			echo json_encode(1);
		} else {
			$response['message'] = 'ERROR';
			echo json_encode(0);
		}
	}

	public function validarLote(){

		$dataPost = $_POST;
		$datos["idLote"] = $dataPost['idLote'];
		$datos["opcionReestructura"] = $dataPost['opcionReestructura'];
		$datos["comentario"] = $dataPost['comentario'];
		$datos["userLiberacion"] = $this->session->userdata('id_usuario');
		$update = $this->Reestructura_model->actualizarValidacion($datos);

		if ($update == TRUE) {
			$response['message'] = 'SUCCESS';
			echo json_encode(1);
		} else {
			$response['message'] = 'ERROR';
			echo json_encode(0);
		} 
	}

	public function getRegistros(){
        $index_proyecto = $this->input->post('index_proyecto');
        $dato = $this->Reestructura_model->get_valor_lote($index_proyecto);
        if ($dato != null) {
            echo json_encode($dato);
        }else{
            echo json_encode(array());
        }
    }

	public function aplicarLiberacion(){
		$dataPost = $_POST;
        $update = $this->Reestructura_model->aplicaLiberacion($dataPost);
        if ($update == TRUE) {
            echo json_encode(1);
        } else {
            echo json_encode(0);
        }
	}

    public function setReestructura(){
        $this->db->trans_begin();
        $idCliente = $this->input->post('idCliente');
        $idAsesor = $this->session->userdata('id_usuario');
        $nombreAsesor = $this->session->userdata('nombre') . ' ' . $this->session->userdata('apellido_paterno') . ' ' . $this->session->userdata('apellido_materno');
        $idLider = $this->session->userdata('id_lider');
		$clienteAnterior = $this->General_model->getClienteNLote($idCliente)->row();
        $idClienteAnterior = $clienteAnterior->id_cliente;
        $loteAOcupar = $clienteAnterior->idLote;
		$lineaVenta = $this->General_model->getLider($idLider)->row();
        $proceso = 3;
        $tipo_venta = $clienteAnterior->tipo_venta;
        $ubicacion = $clienteAnterior->ubicacion;

        $expediente = $this->Reestructura_model->obtenerDocumentacionPorReestructura();
        $loteNuevoInfo = $this->Reestructura_model->obtenerLotePorId($loteAOcupar);
        $documentacionActiva = $this->Reestructura_model->obtenerDocumentacionActiva($clienteAnterior->idLote, $idClienteAnterior);

        $clienteNuevo = $this->copiarClienteANuevo($clienteAnterior, $idAsesor, $idLider, $lineaVenta, $proceso);
        $idClienteInsert = $clienteNuevo[0]['lastId'];

        if (!$idClienteInsert) {
            $this->db->trans_rollback();

            echo json_encode([
                'titulo' => 'ERROR',
                'resultado' => FALSE,
                'message' => 'Error al dar de alta el cliente, por favor verificar la transacción.',
                'color' => 'danger'
            ]);
            return;
        }

        $dataInsertHistorialLote = array(
			'nombreLote' => $clienteAnterior->nombreLote,
			'idStatusContratacion' => 1,
			'idMovimiento' => 31,
			'modificado' => date('Y-m-d h:i:s'),
			'fechaVenc' => date('Y-m-d h:i:s'),
			'idLote' => $loteAOcupar,
			'idCondominio' => $clienteAnterior->idCondominio,
			'idCliente' => $idClienteInsert,
			'usuario' => $idAsesor,
			'perfil' => 'ooam',
			'comentario' => 'OK',
			'status' => 1
        );
        
        if (!$this->General_model->addRecord('historial_lotes', $dataInsertHistorialLote)) {
            $this->db->trans_rollback();

            echo json_encode([
                'titulo' => 'ERROR',
                'resultado' => FALSE,
                'message' => 'Error al dar de alta el cliente, por favor verificar la transacción.',
                'color' => 'danger'
            ]);
            return;
        }

        if (!$this->copiarDSAnteriorAlNuevo($idClienteAnterior, $idClienteInsert)) {
            $this->db->trans_rollback();

            echo json_encode([
                'titulo' => 'ERROR',
                'resultado' => FALSE,
                'message' => 'Error al dar de alta el cliente, por favor verificar la transacción.',
                'color' => 'danger'
            ]);
            return;
        }

        $dataUpdateCliente = array(
            'proceso' => $proceso
        );

        if (!$this->General_model->updateRecord("clientes", $dataUpdateCliente, "id_cliente", $idClienteAnterior)){
            $this->db->trans_rollback();

            echo json_encode([
                'titulo' => 'ERROR',
                'resultado' => FALSE,
                'message' => 'Error al dar de alta el cliente, por favor verificar la transacción.',
                'color' => 'danger'
            ]);
            return;
        }

        $dataLiberacion = [
            'tipoLiberacion' => 8,
            'idLote' => $loteAOcupar,
            'idClienteNuevo' => $idClienteInsert
        ];

        if (!$this->Reestructura_model->aplicaLiberacion($dataLiberacion)){
            $data['message'] = 'ERROR';
            echo json_encode($data);
            return;
        }

        if (!$this->moverExpediente(
            $clienteAnterior->idLote, $loteAOcupar, $idClienteAnterior, $idClienteInsert, $expediente, $loteNuevoInfo, $documentacionActiva
        )) {
            $this->db->trans_rollback();

            echo json_encode([
                'titulo' => 'ERROR',
                'resultado' => FALSE,
                'message' => 'Error al dar de alta el cliente, por favor verificar la transacción.',
                'color' => 'danger'
            ]);
            return;
        }

        if (!$this->updateLote($idClienteInsert, $nombreAsesor, $loteAOcupar, $tipo_venta, $ubicacion)) {
            $this->db->trans_rollback();

            echo json_encode([
                'titulo' => 'ERROR',
                'resultado' => FALSE,
                'message' => 'Error al dar de alta el cliente, por favor verificar la transacción.',
                'color' => 'danger'
            ]);
            return;
        }
        

        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();

            echo json_encode([
                'titulo' => 'ERROR',
                'resultado' => FALSE,
                'message' => 'Error al dar de alta el cliente, por favor verificar la transacción.',
                'color' => 'danger'
            ]);
            return;
        }

        $this->db->trans_commit();
		echo json_encode([
            'titulo' => 'OK',
            'resultado' => TRUE,
            'message' => 'Proceso realizado correctamente.',
            'color' => 'success'
        ]);
    }

    public function setReubicacion(){
        $this->db->trans_begin();

        $idClienteAnterior = $this->input->post('idCliente');
        $loteAOcupar = $this->input->post('loteAOcupar');
        $idCondominio = $this->input->post('condominioAOcupar');
        $idAsesor = $this->session->userdata('id_usuario');
		$nombreAsesor = $this->session->userdata('nombre') . ' ' . $this->session->userdata('apellido_paterno') . ' ' . $this->session->userdata('apellido_materno');
        $idLider = $this->session->userdata('id_lider');
		$clienteAnterior = $this->General_model->getClienteNLote($idClienteAnterior)->row();
        $loteSelected = $this->Reestructura_model->getSelectedSup($loteAOcupar)->row();
        $lineaVenta = $this->General_model->getLider($idLider)->row();
		$nuevaSup = floatval($loteSelected->sup);
		$anteriorSup = floatval($clienteAnterior->sup);
		$proceso = ( $anteriorSup == $nuevaSup || (($nuevaSup - $anteriorSup) <= 2)) ? 2 : 4;
        $tipo_venta = $clienteAnterior->tipo_venta;
        $ubicacion = $clienteAnterior->ubicacion;

		$validateLote = $this->caja_model_outside->validate($loteAOcupar);
        if ($validateLote == 0) {
            echo json_encode([
                'titulo' => 'FALSE',
                'resultado' => FALSE,
                'message' => 'Error, el lote no esta disponible',
                'color' => 'danger'
            ]);
            return;
        }

        $clienteNuevo = $this->copiarClienteANuevo($clienteAnterior, $idAsesor, $idLider, $lineaVenta, $proceso, $loteSelected, $idCondominio);
        $idClienteInsert = $clienteNuevo[0]['lastId'];

        if (!$idClienteInsert) {
            $this->db->trans_rollback();

            echo json_encode([
                'titulo' => 'ERROR',
                'resultado' => FALSE,
                'message' => 'Error al dar de alta el cliente, por favor verificar la transacción.',
                'color' => 'danger'
            ]);
            return;
        }

        if (!$this->updateLote($idClienteInsert, $nombreAsesor, $loteAOcupar, $tipo_venta, $ubicacion)) {
            $this->db->trans_rollback();

            echo json_encode([
                'titulo' => 'ERROR',
                'resultado' => FALSE,
                'message' => 'Error al dar de alta el cliente, por favor verificar la transacción.',
                'color' => 'danger'
            ]);
            return;
        }

        $dataUpdateCliente = array(
            'proceso' => $proceso
        );

        if (!$this->General_model->updateRecord("clientes", $dataUpdateCliente, "id_cliente", $idClienteAnterior)){
            $this->db->trans_rollback();

            echo json_encode([
                'titulo' => 'ERROR',
                'resultado' => FALSE,
                'message' => 'Error al dar de alta el cliente, por favor verificar la transacción.',
                'color' => 'danger'
            ]);
            return;
        }

        $dataInsertHistorialLote = array(
			'nombreLote' => $loteSelected->nombreLote,
			'idStatusContratacion' => 1,
			'idMovimiento' => 31,
			'modificado' => date('Y-m-d h:i:s'),
			'fechaVenc' => date('Y-m-d h:i:s'),
			'idLote' => $loteAOcupar,
			'idCondominio' => $idCondominio,
			'idCliente' => $idClienteInsert,
			'usuario' => $idAsesor,
			'perfil' => 'ooam',
			'comentario' => 'OK',
			'status' => 1
        );

        if (!$this->General_model->addRecord('historial_lotes', $dataInsertHistorialLote)) {
            $this->db->trans_rollback();

            echo json_encode([
                'titulo' => 'ERROR',
                'resultado' => FALSE,
                'message' => 'Error al dar de alta el cliente, por favor verificar la transacción.',
                'color' => 'danger'
            ]);
            return;
        }

        if (!$this->copiarDSAnteriorAlNuevo($idClienteAnterior, $idClienteInsert)) {
            $this->db->trans_rollback();

            echo json_encode([
                'titulo' => 'ERROR',
                'resultado' => FALSE,
                'message' => 'Error al dar de alta el cliente, por favor verificar la transacción.',
                'color' => 'danger'
            ]);
            return;
        }

        $expediente = $this->Reestructura_model->obtenerDocumentacionPorReubicacion($clienteAnterior->personalidad_juridica);
        if (!$this->moverExpediente($clienteAnterior->idLote, $loteAOcupar, $idClienteAnterior, $idClienteInsert, $expediente)) {
            $this->db->trans_rollback();

            echo json_encode([
                'titulo' => 'ERROR',
                'resultado' => FALSE,
                'message' => 'Error al dar de alta el cliente, por favor verificar la transacción.',
                'color' => 'danger'
            ]);
            return;
        }

        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();

            echo json_encode([
                'titulo' => 'ERROR',
                'resultado' => FALSE,
                'message' => 'Error al dar de alta el cliente, por favor verificar la transacción.',
                'color' => 'danger'
            ]);
            return;
        }

        $this->db->trans_commit();
		echo json_encode([
            'titulo' => 'OK',
            'resultado' => TRUE,
            'message' => 'Proceso realizado correctamente.',
            'color' => 'success'
        ]);
	}

    public function copiarClienteANuevo($clienteAnterior, $idAsesor, $idLider, $lineaVenta, $proceso, $loteSelected = null, $idCondominio = null) {
        $dataCliente = [];
        $camposOmitir = ['id_cliente','nombreLote', 'sup', 'tipo_venta', 'ubicacion'];

        foreach ($clienteAnterior as $clave => $valor) {
            if(in_array($clave, $camposOmitir)) {
                continue;
            } else if ($clave == 'id_asesor') {
                $dataCliente = array_merge([$clave => $idAsesor], $dataCliente);
                continue;
            } else if ($clave == 'id_coordinador') {
                $dataCliente = array_merge([$clave => 0], $dataCliente);
                continue;
            } else if ($clave == 'id_gerente') {
                $dataCliente = array_merge([$clave => $idLider], $dataCliente);
                continue;
            } else if ($clave == 'idLote' && $proceso != 3) {
                $dataCliente = array_merge([$clave => $loteSelected->idLote], $dataCliente);
                continue;
            } else if ($clave == 'idCondominio' && $proceso != 3) {
                $dataCliente = array_merge([$clave =>  $idCondominio], $dataCliente);
                continue;
            } else if ($clave == 'id_subdirector') {
                $dataCliente = array_merge([$clave => $lineaVenta->id_subdirector], $dataCliente);
                continue;
            } else if ($clave == 'id_regional') {
                $dataCliente = array_merge([$clave =>  $lineaVenta->id_regional], $dataCliente);
                continue;
            } else if ($clave == 'plan_comision') {
                $dataCliente = array_merge([$clave =>  $proceso == 3 ? 64 : ($proceso == 2 ? 65 : 66) ], $dataCliente);
                continue;
            } else if ($clave == 'proceso') {
                $dataCliente = array_merge([$clave =>  $proceso], $dataCliente);
                continue;
            } else if ($clave == 'totalNeto2Cl') {
                $dataCliente = array_merge([$clave =>  0], $dataCliente);
                continue;
            } else if ($clave == 'id_cliente_reubicacion_2') {
                $dataCliente = array_merge([$clave =>  $clienteAnterior->id_cliente], $dataCliente);
                continue;
            }

            $dataCliente = array_merge([$clave => $valor], $dataCliente);
        }

        return $this->caja_model_outside->insertClient($dataCliente);
    }

    function updateLote($idClienteInsert, $nombreAsesor, $loteAOcupar, $tipo_venta, $ubicacion){
        date_default_timezone_set('America/Mexico_City');
        $horaActual = date('H:i:s');
        $horaInicio = date("08:00:00");
        $horaFin = date("16:00:00");
        if ($horaActual > $horaInicio and $horaActual < $horaFin) {
            $fechaAccion = date("Y-m-d H:i:s");
            $hoy_strtotime2 = strtotime($fechaAccion);
            $sig_fecha_dia2 = date('D', $hoy_strtotime2);
            $sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
            if ($sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
                $sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
                $sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
                $sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
                $sig_fecha_feriado2 == "25-12") {
                $fecha = $fechaAccion;
                $i = 0;
                while ($i <= 6) {
                    $hoy_strtotime = strtotime($fecha);
                    $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
                    $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
                    $sig_fecha_dia = date('D', $sig_strtotime);
                    $sig_fecha_feriado = date('d-m', $sig_strtotime);
                    if ($sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
                        $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
                        $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
                        $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
                        $sig_fecha_feriado == "25-12") {
                    } else {
                        $fecha = $sig_fecha;
                        $i++;
                    }
                    $fecha = $sig_fecha;
                }
                $fechaFull = $fecha;
            } else {
                $fecha = $fechaAccion;
                $i = 0;
                while ($i <= 5) {
                    $hoy_strtotime = strtotime($fecha);
                    $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
                    $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
                    $sig_fecha_dia = date('D', $sig_strtotime);
                    $sig_fecha_feriado = date('d-m', $sig_strtotime);
                    if ($sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
                        $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
                        $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
                        $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
                        $sig_fecha_feriado == "25-12") {
                    } else {
                        $fecha = $sig_fecha;
                        $i++;
                    }
                    $fecha = $sig_fecha;
                }
                $fechaFull = $fecha;
            }
        } elseif ($horaActual < $horaInicio || $horaActual > $horaFin) {
            $fechaAccion = date("Y-m-d H:i:s");
            $hoy_strtotime2 = strtotime($fechaAccion);
            $sig_fecha_dia2 = date('D', $hoy_strtotime2);
            $sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
            if ($sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
                $sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
                $sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
                $sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
                $sig_fecha_feriado2 == "25-12") {
                $fecha = $fechaAccion;
                $i = 0;
                while ($i <= 6) {
                    $hoy_strtotime = strtotime($fecha);
                    $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
                    $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
                    $sig_fecha_dia = date('D', $sig_strtotime);
                    $sig_fecha_feriado = date('d-m', $sig_strtotime);
                    if ($sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
                        $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
                        $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
                        $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
                        $sig_fecha_feriado == "25-12") {
                    } else {
                        $fecha = $sig_fecha;
                        $i++;
                    }
                    $fecha = $sig_fecha;
                }
                $fechaFull = $fecha;
            } else {
                $fecha = $fechaAccion;
                $i = 0;
                while ($i <= 6) {
                    $hoy_strtotime = strtotime($fecha);
                    $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
                    $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
                    $sig_fecha_dia = date('D', $sig_strtotime);
                    $sig_fecha_feriado = date('d-m', $sig_strtotime);
                    if ($sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
                        $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
                        $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
                        $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
                        $sig_fecha_feriado == "25-12") {
                    } else {
                        $fecha = $sig_fecha;
                        $i++;
                    }
                    $fecha = $sig_fecha;
                }
                $fechaFull = $fecha;
            }
        }

		$dataUpdateLote = array(
            'idCliente' => $idClienteInsert,
            'idStatusContratacion' => 1,
            'idMovimiento' => 31,
            'comentario' => 'OK',
            'usuario' => $nombreAsesor,
            'perfil' => 'ooam',
            'modificado' => date('Y-m-d h:i:s'),
            'fechaVenc' => $fechaFull,
            'IdStatusLote' => 3,
            'tipo_venta' => $tipo_venta,
            'ubicacion' =>$ubicacion
        );

        $resultLote = $this->General_model->updateRecord("lotes", $dataUpdateLote, "idLote", $loteAOcupar);
        return $resultLote;
    }

    function moverExpediente(
        $idLoteAnterior, $idLoteNuevo, $idClienteAnterior, $idClienteNuevo, $expediente, $loteInfo = null, $docInfo = null): bool
    {
        $loteNuevoInfo = (is_null($loteInfo))
            ? $this->Reestructura_model->obtenerLotePorId($idLoteNuevo)
            : $loteInfo;
        $docAnterior = (is_null($docInfo))
            ? $this->Reestructura_model->obtenerDocumentacionActiva($idLoteAnterior, $idClienteAnterior)
            : $docInfo;
        $documentacion = [];
        $modificado = date('Y-m-d H:i:s');
        $documentosSinPasar = (is_null($docInfo)) ? [7,8] : [];

        foreach ($docAnterior as $doc) {
            $expedienteAnterior = in_array($doc['tipo_doc'], $documentosSinPasar) ? null : $doc['expediente'];

            $documentacion[] = [
                'movimiento' => $doc['movimiento'],
                'expediente' => $expedienteAnterior,
                'modificado' => $modificado,
                'status' => 1,
                'idCliente' => $idClienteNuevo,
                'idCondominio' => $loteNuevoInfo->idCondominio,
                'idLote' => $idLoteNuevo,
                'idUser' => NULL,
                'tipo_documento' => 0,
                'id_autorizacion' => 0,
                'tipo_doc' => $doc['tipo_doc'],
                'estatus_validacion' => 0
            ];
        }

        foreach ($expediente as $doc) {
            if (is_null($docInfo)) {
                $indexExpedienteAnterior = null;

                if ($doc['id_opcion'] == 39) {
                    $indexExpedienteAnterior = array_search(7, array_column($docAnterior, 'tipo_doc'));
                }

                if ($doc['id_opcion'] == 40) {
                    $indexExpedienteAnterior = array_search(8, array_column($docAnterior, 'tipo_doc'));
                }

                if (!is_null($indexExpedienteAnterior)) {
                    $documentacion[] = [
                        'movimiento' => $doc['nombre'],
                        'expediente' => $docAnterior[$indexExpedienteAnterior]['expediente'],
                        'modificado' => $modificado,
                        'status' => 1,
                        'idCliente' => $idClienteNuevo,
                        'idCondominio' => $loteNuevoInfo->idCondominio,
                        'idLote' => $idLoteNuevo,
                        'idUser' => NULL,
                        'tipo_documento' => 0,
                        'id_autorizacion' => 0,
                        'tipo_doc' => $doc['id_opcion'],
                        'estatus_validacion' => 0
                    ];
                    continue;
                }
            }

            $documentacion[] = [
                'movimiento' => $doc['nombre'],
                'expediente' => NULL,
                'modificado' => $modificado,
                'status' => 1,
                'idCliente' => $idClienteNuevo,
                'idCondominio' => $loteNuevoInfo->idCondominio,
                'idLote' => $idLoteNuevo,
                'idUser' => NULL,
                'tipo_documento' => 0,
                'id_autorizacion' => 0,
                'tipo_doc' => $doc['id_opcion'],
                'estatus_validacion' => 0
            ];
        }

        if (!file_exists("static/documentos/contratacion-reubicacion/$loteNuevoInfo->nombreLote/")) {
            $result = mkdir("static/documentos/contratacion-reubicacion/$loteNuevoInfo->nombreLote", 0777, TRUE);
            if (!$result) {
                return false;
            }
        }

        return $this->General_model->insertBatch('historial_documento', $documentacion);
    }

    public function copiarDSAnteriorAlNuevo($idClienteAnterior, $idClienteNuevo): bool
    {
        $dsAnterior = $this->Reestructura_model->obtenerDSPorIdCliente($idClienteAnterior);
        $residencial = $this->Reestructura_model->obtenerResidencialPorIdCliente($idClienteNuevo);
        $coopropietarios = $this->Reestructura_model->obtenerCopropietariosPorIdCliente($idClienteAnterior);
        $dsData = [];
        $coopropietariosData = [];

        foreach ($dsAnterior as $clave => $valor) {
            if(in_array($clave, ['id', 'id_cliente', 'clave'])) {
                continue;
            }

            if ($clave == 'proyecto') {
                $dsData = array_merge([$clave => $residencial->nombreResidencial], $dsData);
                continue;
            }

            $dsData = array_merge([$clave => $valor], $dsData);
        }

        foreach ($coopropietarios as $coopropietario) {
            $dataTmp = [];

            foreach ($coopropietario as $clave => $valor) {
                if (in_array($clave, ['id_copropietario'])) {
                    continue;
                }

                if ($clave == 'id_cliente') {
                    $dataTmp = array_merge([$clave => $idClienteNuevo], $dataTmp);
                    continue;
                }

                $dataTmp = array_merge([$clave => $valor], $dataTmp);
            }

            $coopropietariosData[] = $dataTmp;
        }

        $resultDs = $this->General_model->updateRecord('deposito_seriedad', $dsData, 'id_cliente', $idClienteNuevo);
        $resultCop = (empty($coopropietariosData)) ? true : $this->General_model->insertBatch('copropietarios', $coopropietariosData);

        return $resultDs && $resultCop;
    }

    public function imprimirCartaReubicacion($idCliente)
    {
        $this->load->library('Pdf');
        $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

        $info = $this->Reestructura_model->informacionCartaReubicacionPdf($idCliente);

        $html = $this->load->view('pdf/reestructura/carta-reubicacion', [
            'dia' => date('d'),
            'mes' => $meses[date('n') - 1],
            'anio' => date('Y'),
            'nombreCliente' => $info->nombreCliente,
            'loteAnterior' => $info->loteAnterior,
            'condAnterior' => $info->condAnterior,
            'desarrolloAnterior' => $info->desarrolloAnterior,
            'loteNuevo' => $info->loteNuevo,
            'condNuevo' => $info->condNuevo,
            'desarrolloNuevo' => $info->desarrolloNuevo
        ], true);

        $pdf = new TCPDF('P', 'mm', 'LETTER', 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('CARTA SOLICITUD REUBICACIÓN');
        $pdf->SetSubject('CARTA');
        $pdf->SetKeywords('CRM');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetAutoPageBreak(TRUE);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setPrintHeader(false);
        $pdf->SetFont('Helvetica', '', 9, '', true);
        $pdf->SetMargins(30, 15, 30);
        $pdf->AddPage('P', 'LETTER');
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->getBreakMargin();
        $pdf->Image('dist/img/ar4c.png', 120, 0, 300, 0, 'PNG', '', '', false, 150, '', false, false, 0, false, false, false);
        $pdf->setPageMark();

        $pdf->writeHTML($html);
        ob_end_clean();

        $pdf->Output(utf8_decode("Carta.pdf"));
    }

    public function imprimirCartaReestructura($idCliente)
    {
        $this->load->library('Pdf');
        $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

        $info = $this->Reestructura_model->informacionCartaReestructuraPdf($idCliente);

        $html = $this->load->view('pdf/reestructura/carta-reestructura', [
            'dia' => date('d'),
            'mes' => $meses[date('n') - 1],
            'anio' => date('Y'),
            'nombreCliente' => $info->nombreCliente,
            'lote' => $info->lote,
            'cond' => $info->cond,
            'desarrollo' => $info->desarrollo
        ], true);

        $pdf = new TCPDF('P', 'mm', 'LETTER', 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('CARTA SOLICITUD REESTRUCTURA');
        $pdf->SetSubject('CARTA');
        $pdf->SetKeywords('CRM');
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetAutoPageBreak(TRUE);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setPrintHeader(false);
        $pdf->SetFont('Helvetica', '', 9, '', true);
        $pdf->SetMargins(30, 15, 30);
        $pdf->AddPage('P', 'LETTER');
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->getBreakMargin();
        $pdf->Image('dist/img/ar4c.png', 120, 0, 300, 0, 'PNG', '', '', false, 150, '', false, false, 0, false, false, false);
        $pdf->setPageMark();

        $pdf->writeHTML($html);
        ob_end_clean();

        $pdf->Output(utf8_decode("Carta.pdf"));
    }
	public function cancelarLotes(){
		$this->load->view('template/header');
        $this->load->view("reestructura/cancelacion_view");
    }

	public function getregistrosLotes(){
        $index_proyecto = $this->input->post('index_proyecto');
        $dato = $this->Reestructura_model->getLotes($index_proyecto);
        if ($dato != null) {
            echo json_encode($dato);
        }else{
            echo json_encode(array());
        }
    }

    public function obtenerClientePorId($idCliente)
    {
        $cliente = $this->Reestructura_model->obtenerClientePorId($idCliente);
        echo json_encode($cliente);
    }

    public function lotesEstatusSeisSinTraspaso(){
        $this->validateSession();
        $this->load->view('template/header');
        $this->load->view("reestructura/lotesEstatusSeisSinTraspaso_view");
    }

    public function getLotesEstatusSeisSinTraspaso(){
        $data = $this->Reestructura_model->getLotesEstatusSeisSinTraspaso()->result_array();
        if($data != null)
            echo json_encode($data);
        else
            echo json_encode(array());
    }

    public function asignacionCartera(){
		$this->load->view('template/header');
        $this->load->view("reestructura/asignacionCartera_view");
	}	

    public function getListaAsignacionCartera(){
        $data = $this->Reestructura_model->getListaAsignacionCartera();
        echo json_encode($data);
    }

    public function getListaUsuariosParaAsignacion() {
        echo json_encode($this->Reestructura_model->getListaUsuariosParaAsignacion());
    }

    public function setAsesor() {
        $updateData = array("id_usuario_asignado" => $this->input->post('idAsesor'), "usuario" => $this->session->userdata('id_usuario'));
        echo json_encode($this->General_model->updateRecord("lotes", $updateData, "idLote", $this->input->post('idLote')));
    }
    
    public function cambiarBandera  ()
    {
        $bandera   =  $this->input->post('bandera');
        $idLote    =  $this->input->post('idLoteBandera');
           $arr_update = array( 
                            "liberaBandera"   => $bandera,
                            );
      $update = $this->Reestructura_model->banderaLiberada($idLote,$arr_update);                           
      if($update){
        $respuesta =  array(
          "response_code" => 200, 
          "response_type" => 'success',
          "message" => "Se ha liberado  satisfactoriamente");
      }else{
        $respuesta =  array(
          "response_code" => 400, 
          "response_type" => 'warning',
          "message" => "Lote no actualizado, inténtalo más tarde ");
      }
      echo json_encode ($respuesta);             
  
    }
}
