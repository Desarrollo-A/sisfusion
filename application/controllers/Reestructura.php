<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Reestructura extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
        $this->load->model(array('Reestructura_model','General_model'));
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
        echo json_encode($this->Reestructura_model->get_proyecto_lista()->result_array());
    }

	public function getregistros(){
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
		$comentarioLiberacion = $dataPost['tipoLiberacion'] == 7 ? 'LIBERADO POR REUBICACIÓN' : ( $dataPost['tipoLiberacion'] == 9 ? 'LIBERACIÓN JURÍDICA' : ($dataPost['tipoLiberacion'] == 8 ? 'LIBERADO POR REESTRUCTURA' : '') );
		$observacionLiberacion = $dataPost['tipoLiberacion'] == 7 ? 'LIBERADO POR REUBICACIÓN' : ( $dataPost['tipoLiberacion'] == 9 ? 'LIBERACIÓN JURÍDICA' : ($dataPost['tipoLiberacion'] == 8 ? 'LIBERADO POR REESTRUCTURA' : '') );
		$datos["nombreLote"] = $dataPost['nombreLote'];
		$datos["precio"] = $dataPost['precio'];
		$datos["comentarioLiberacion"] = $comentarioLiberacion;
		$datos["observacionLiberacion"] = $observacionLiberacion;
		$datos["fechaLiberacion"] = date('Y-m-d H:i:s');
		$datos["modificado"] = date('Y-m-d H:i:s');
		$datos["status"] = 1;
		$datos["userLiberacion"] = $this->session->userdata('id_usuario');
		$dataPost['tipoLiberacion'] == 7 ? $datos['idLoteNuevo'] = $dataPost['idLoteNuevo'] : '' ;
		$datos["tipo"] = $dataPost['tipoLiberacion'];
		$datos["idLote"] = $dataPost['idLote'];
		$update = $this->Reestructura_model->aplicaLiberacion($datos);

		if ($update == TRUE) {
			echo json_encode(1);
		} else {
			echo json_encode(0);
		}		
	}

	public function setReestructura(){
		$dataPost = $_POST;
		$insert = $this->Reestructura_model->setReestructura($dataPost);
		if ($insert == TRUE) {
			echo json_encode(1);
		} else {
			echo json_encode(0);
		}
	}

	public function setReubicacion(){
        $dataNew = array();
        $idClienteAnterior = $this->input->post('idCliente');
        $loteAOcupar = $this->input->post('loteAOcupar');
        $idCondominio = $this->input->post('condominioAOcupar');
        $idAsesor = $this->session->userdata('id_usuario');
        $idLider = $this->session->userdata('id_lider');
		
		$clienteAnterior = $this->General_model->getCliente($idClienteAnterior)->result();
		$lineaVenta = $this->General_model->getLider($idLider)->result();
		$nuevaSup = $this->Reestructura_model->getSelectedSup($loteAOcupar)->result();
		$nuevaSup = intval($nuevaSup[0]->sup);
		$anteriorSup = intval($clienteAnterior[0]->sup);

		$proceso = ( $anteriorSup == $nuevaSup || (($anteriorSup + 2) == $nuevaSup)) ? 2 : 5;

		// foreach($clienteAnterior[0] as $clave => $valor){
		// 	if(in_array($clave, ['id_cliente'])){
		// 		continue;
		// 	}

		// 	if( $clave == 'id_asesor'){
		// 		$dataNew = array_merge([$clave => $idAsesor, $dataNew]);
		// 	}
		// 	else if( $clave == 'id_coordinador'){
		// 		$dataNew = array_merge([$clave => 0, $dataNew]);
		// 	}
		// 	else if( $clave == 'id_gerente'){
		// 		$dataNew = array_merge([$clave => $idLider, $dataNew]);
		// 	}
		// 	else if( $clave == 'idLote'){
		// 		$dataNew = array_merge([$clave => $loteAOcupar, $dataNew]);
		// 	}
		// 	else if( $clave == 'idCondominio'){
		// 		$dataNew = array_merge([$clave => $idCondominio, $dataNew]);
		// 	}
		// 	else if( $clave == 'plan_comision'){
		// 		$dataNew = array_merge([$clave => $planComision, $dataNew]);
		// 	}
		// 	else if( $clave == 'id_cliente_reubicacion'){
		// 		$dataNew = array_merge([$clave => $idClienteAnterior, $dataNew]);
		// 	}

		// 	$dataNew = array_merge([$clave => $valor], $dataNew);
		// }

		
		$data['id_asesor'] = $idAsesor->id_asesor;
		$data['id_coordinador'] = 0;
		$data['id_gerente'] = $idLider;
		$data['id_sede'] = $cliente[0]->id_sede;
		$data['nombre'] = $cliente[0]->nombre;
		$data['apellido_paterno'] = $cliente[0]->apellido_paterno;
		$data['apellido_materno'] = $cliente[0]->apellido_materno;
		$data['personalidad_juridica'] = $cliente[0]->personalidad_juridica;
		$data['nacionalidad'] = $cliente[0]->nacionalidad;
		$data['rfc'] = $cliente[0]->rfc;
		$data['curp'] = $cliente[0]->curp;
		$data['correo'] = $cliente[0]->correo;
		$data['telefono1'] = $cliente[0]->telefono1;
		$data['telefono2'] = $cliente[0]->telefono2;
		$data['telefono3'] = $cliente[0]->telefono3;
		$data['fecha_nacimiento'] = $cliente[0]->fecha_nacimiento;
		$data['lugar_prospeccion'] = $cliente[0]->lugar_prospeccion;
		$data['medio_publicitario'] = $cliente[0]->medio_publicitario;
		$data['otro_lugar'] = $cliente[0]->otro_lugar;
		$data['plaza_venta'] = $cliente[0]->plaza_venta;
		$data['tipo'] = $cliente[0]->tipo;
		$data['estado_civil'] = $cliente[0]->estado_civil;
		$data['regimen_matrimonial'] = $cliente[0]->regimen_matrimonial;
		$data['nombre_conyuge'] = $cliente[0]->nombre_conyuge;
		$data['domicilio_particular'] = $cliente[0]->domicilio_particular;
		$data['originario_de'] = $cliente[0]->originario_de;
		$data['tipo_vivienda'] = $cliente[0]->tipo_vivienda;
		$data['ocupacion'] = $cliente[0]->ocupacion;
		$data['empresa'] = $cliente[0]->empresa;
		$data['puesto'] = $cliente[0]->puesto;
		$data['edadFirma'] = $cliente[0]->edadFirma;
		$data['antiguedad'] = $cliente[0]->antiguedad;
		$data['domicilio_empresa'] = $cliente[0]->domicilio_empresa;
		$data['telefono_empresa'] = $cliente[0]->telefono_empresa;
		$data['noRecibo'] = $cliente[0]->noRecibo;
		$data['engancheCliente'] = $cliente[0]->engancheCliente;
		$data['concepto'] = $cliente[0]->concepto;
		$data['fechaEnganche'] = $cliente[0]->fechaEnganche;
		$data['idTipoPago'] = $cliente[0]->idTipoPago;
		$data['expediente'] = $cliente[0]->expediente;
		$data['status'] = $cliente[0]->status;
		$data['idLote'] = $loteAOcupar; 
		$data['fechaApartado'] = $cliente[0]->fechaApartado;
		$data['fechaVencimiento'] = $cliente[0]->fechaVencimiento;
		$data['usuario'] = $cliente[0]->usuario;
		$data['idCondominio'] = $idCondominio;
		$data['fecha_creacion'] = $cliente[0]->fecha_creacion;
		$data['creado_por'] = $cliente[0]->creado_por;
		$data['fecha_modificacion'] = $cliente[0]->fecha_modificacion;
		$data['modificado_por'] = $cliente[0]->modificado_por;
		$data['autorizacion'] = $cliente[0]->autorizacion;
		$data['idAut'] = $cliente[0]->idAut;
		$data['motivoAut'] = $cliente[0]->motivoAut;
		$data['id_prospecto'] = $cliente[0]->id_prospecto;
		$data['idReferido'] = $cliente[0]->idReferido;
		$data['descuento_mdb'] = $cliente[0]->descuento_mdb;
		$data['id_subdirector'] = $lineaVenta[0]->id_subdirector;
		$data['id_regional'] = $clielineaVentante[0]->id_regional;
		$data['plan_comision'] = 0;
		$data['flag_compartida'] = $cliente[0]->flag_compartida;
		$data['precio_cl'] = $cliente[0]->precio_cl;
		$data['total_cl'] = $cliente[0]->total_cl;
		$data['ubicacion_cl'] = $cliente[0]->ubicacion_cl;
		$data['totalNeto_cl'] = $cliente[0]->totalNeto_cl;
		$data['totalNeto2_cl'] = $cliente[0]->totalNeto2_cl;
		$data['registro_comision_cl'] = $cliente[0]->registro_comision_cl;
		$data['totalValidado_cl'] = $cliente[0]->totalValidado_cl;
		$data['tipo_venta_cl'] = $cliente[0]->tipo_venta_cl;
		$data['id_regional_2'] = $cliente[0]->id_regional_2;
		$data['rl'] = $cliente[0]->rl;
		$data['tipo_nc'] = $cliente[0]->tipo_nc;
		$data['printPagare'] = $cliente[0]->printPagare;
		$data['estructura'] = $cliente[0]->estructura;
		$data['tipo_casa'] = $cliente[0]->tipo_casa;
		$data['apartadoXReubicacion'] = $cliente[0]->apartadoXReubicacion;
		$data['id_cliente_reubicacion'] = $cliente[0]->id_cliente_reubicacion;
		$data['fechaAlta'] = $cliente[0]->fechaAlta;
		$data['tipo_comprobanteD'] = $cliente[0]->tipo_comprobanteD;
		$data['regimen_fac'] = $cliente[0]->regimen_fac;
		$data['cp_fac'] = $cliente[0]->cp_fac;
		$data['cancelacion_proceso'] = $cliente[0]->cancelacion_proceso;
		$data['banderaComisionCl'] = $cliente[0]->banderaComisionCl;
		$data['proceso'] = $proceso;
		$data['totalNeto2Cl'] = 0;
	}
} 
