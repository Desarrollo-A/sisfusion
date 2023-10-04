<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Asistente_gerente extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model(['VentasAsistentes_model', 'registrolote_modelo', 'asesor/Asesor_model', 'Reestructura_model']);
        $this->load->library(array('session','form_validation'));
       //LIBRERIA PARA LLAMAR OBTENER LAS CONSULTAS DE LAS  DEL MENÚ
        $this->load->library(array('session','form_validation', 'get_menu','permisos_sidebar'));
        $this->load->helper(array('url','form'));
        $this->load->database('default');
        $this->load->library('email');
        $this->validateSession();

        date_default_timezone_set('America/Mexico_City');

        $val =  $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        $_SESSION['rutaController'] = str_replace('' . base_url() . '', '', $val);
        $rutaUrl = explode($_SESSION['rutaActual'], $_SERVER["REQUEST_URI"]);
        $this->permisos_sidebar->validarPermiso($this->session->userdata('datos'),$rutaUrl[1],$this->session->userdata('opcionesMenu'));
    }


	public function index()
	{
		if ($this->session->userdata('id_rol') == FALSE || $this->session->userdata('id_rol') != '6') {
			redirect(base_url() . 'login');
		}
		$this->load->view('template/header');
		$this->load->view('ventasAsistentes/ventasAsistentes_view');
		$this->load->view('template/footer');
	}

	public function registrosClienteVentasAsistentes(){
		$this->load->view('template/header');
		$this->load->view("contratacion/datos_cliente_contratacion_view");
	}
	public function registroEstatus8VentasAsistentes()
	{
		$this->validateSession();

	 	$this->load->view('template/header');
		$this->load->view("contratacion/datos_status8Contratacion_asistentes_view");
	}
	public function registroEstatus14VentasAsistentes(){
		$this->validateSession();
		$this->load->view('template/header');
		$this->load->view("contratacion/datos_status14Contratacion_asistentes_view");
	}
	public function registroEstatus7VentasAsistentes(){
		/*menu function*/           
	   	$this->load->view('template/header');
		$this->load->view("ventasAsistentes/datos_7_ventasAsistentes_view");
	}

	public function registroEstatus9VentasAsistentes(){
		/*menu function*/                    
   		$this->load->view('template/header');
		$this->load->view('contratacion/report_historial_view');
	}

	public function inventario()
	{
		$datos["residencial"] = $this->registrolote_modelo->getResidencialQro();
		$this->load->view('template/header');
		$this->load->view("contratacion/datos_lote_contratacion_view", $datos);
	}

	public function inventarioDisponible()
	{
		$datos["residencial"] = $this->registrolote_modelo->getResidencialQro();
		$this->load->view('template/header');
		$this->load->view("contratacion/datos_inventarioDventas_view", $datos);
	}

	public function legalRejections()
    {
        $this->load->view('template/header');
        $this->load->view("contratacion/legal_rejections");
    }
    
    public function getLegalRejections() {
        $data=array();
        $data = $this->VentasAsistentes_model->getLegalRejections();
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
    }

	public function registrosClienteAutorizacionAsistentes(){
		$this->load->view('template/header');
		$this->load->view("ventasAsistentes/datos_cliente_autorizacion_ventasAsistentes_view");
	}
	public function catalogoAsesores()
	{
		$this->load->view('template/header');
		$this->load->view("contratacion/cat_asesor_view");
	}
	public function registroContratoVentasAsistentes(){
 		$this->load->view('template/header');
		$this->load->view("ventasAsistentes/datos_cliente_contrato_ventasAsistentes_view");
	}
	public function nueva_Solicitud(){
		$this->load->view('template/header');
		$this->load->view("ventasAsistentes/vista_solicitud_comision");
	}
	public function hitorial_Comisiones(){
		$this->load->view('template/header');
		$this->load->view("ventasAsistentes/vista_historial_comisiones");
	}
	public function lista_proyecto(){
      echo json_encode($this->VentasAsistentes_model->get_proyecto_lista()->result_array());
	}
	public function lista_condominio($proyecto){
      echo json_encode($this->VentasAsistentes_model->get_condominio_lista($proyecto)->result_array());
	}
	public function lista_lote($condominio){
      echo json_encode($this->VentasAsistentes_model->get_lote_lista($condominio)->result_array());
	}

    public function lista_proyecto_usu(){
        echo json_encode($this->VentasAsistentes_model->get_proyecto_lista_usu()->result_array());
    }

    public function lista_condominio_usu($proyecto){
        echo json_encode($this->VentasAsistentes_model->get_condominio_lista_usu($proyecto)->result_array());
    }

    public function lista_lote_usu($condominio){
        echo json_encode($this->VentasAsistentes_model->get_lote_lista_usu($condominio)->result_array());
    }

	public function get_lote_autorizacion($lote){
      echo json_encode($this->VentasAsistentes_model->get_datos_lote_aut($lote)->result_array());
	}
	public function get_lote_contrato($lote){
      echo json_encode($this->VentasAsistentes_model->get_datos_lote_cont($lote)->result_array());
	}

	public function invDispAsesor()
	{
	 	$datos["residencial"] = $this->registrolote_modelo->getResidencialQro();
      	$this->load->view('template/header');
        $this->load->view("asesor/inventario_disponible",$datos);
	}

	public function validateSession()
	{
		if($this->session->userdata('id_usuario')=="" || $this->session->userdata('id_rol')=="")
		{
			redirect(base_url() . "index.php/login");
		}
	}

	public function getStatus8ContratacionAsistentes() {
		$data=array();
		$data = $this->VentasAsistentes_model->registroStatusContratacion8();

			if($data != null) {
				echo json_encode($data);
			} else {
				echo json_encode(array());
			}

	}

	public function editar_registro_lote_asistentes_proceceso8(){
		$idLote=$this->input->post('idLote');	
		$idCondominio=$this->input->post('idCondominio');
		$nombreLote=$this->input->post('nombreLote');
		$idCliente=$this->input->post('idCliente');
		$comentario=$this->input->post('comentario');
		$modificado=date('Y-m-d H:i:s');
		$fechaVenc=$this->input->post('fechaVenc');
		$arreglo=array();	
		$arreglo["idStatusContratacion"]=8;
		$arreglo["idMovimiento"]=38;
		$arreglo["comentario"]=$comentario;
		$arreglo["usuario"]=$this->session->userdata('id_usuario');
		$arreglo["perfil"]=$this->session->userdata('id_rol');
		$arreglo["modificado"]=date("Y-m-d H:i:s");
		$arreglo["status8Flag"] = 1;
	
		$arreglo2=array();
		$arreglo2["idStatusContratacion"]=8;
		$arreglo2["idMovimiento"]=38;
		$arreglo2["nombreLote"]=$nombreLote;
		$arreglo2["comentario"]=$comentario;	
		$arreglo2["usuario"]=$this->session->userdata('id_usuario');
		$arreglo2["perfil"]=$this->session->userdata('id_rol');
		$arreglo2["modificado"]=date("Y-m-d H:i:s");
		$arreglo2["fechaVenc"]= $fechaVenc;
		$arreglo2["idLote"]= $idLote;  
		$arreglo2["idCondominio"]= $idCondominio;          	
		$arreglo2["idCliente"]= $idCliente;

        $validaSinLiquidar = $this->VentasAsistentes_model->validaSinliquidar($idLote);
        if ($validaSinLiquidar == 1) {
                //se valida si existe complemento de enganche en el árbol de documentos
                $ComplementoEnganche = $this->VentasAsistentes_model->validaComplementoEnganche($idLote);

                if (empty($ComplementoEnganche->expediente) || $ComplementoEnganche->expediente == NULL) {
                    $data['message'] = 'MISSING_COMPLEMENTO_DE_ENGANCHE';
                    echo json_encode($data);
                }else{

                $valida_rama = $this->VentasAsistentes_model->check_carta($idCliente);
                if($valida_rama[0]['tipo_nc']==1){
                    $validacionCarta = $this->VentasAsistentes_model->validaCartaCM($idCliente);
                    if($validacionCarta[0]['tipo_comprobanteD']==1) {
                        if(count($validacionCarta)<=0){
                            $data['message'] = 'MISSING_CARTA_RAMA';
                            echo json_encode($data);
                            exit;
                        }else{
                            if($validacionCarta[0]['tipo_comprobanteD']==1) {
                                if ($validacionCarta[0]['expediente'] == '' || $validacionCarta[0]['expediente'] == NULL) {
                                    $data['message'] = 'MISSING_CARTA_UPLOAD';
                                    echo json_encode($data);
                                    exit;
                                }
                            }
                        }
                    }
                }  

                $validate = $this->VentasAsistentes_model->validateSt8($idLote);
                if ($validate != 1) {
                    $data['message'] = 'FALSE';
                    echo json_encode($data);
                    return;
                }

                if (!$this->VentasAsistentes_model->updateSt($idLote,$arreglo,$arreglo2)){
                    $data['message'] = 'ERROR';
                    echo json_encode($data);
                    return;
                }

                $cliente = $this->Reestructura_model->obtenerClientePorId($idCliente);

                if (!in_array($cliente->proceso, [2,4])) {
                    $data['message'] = 'OK';
                    echo json_encode($data);
                    return;
                }

                $loteAnterior = $this->Reestructura_model->buscarLoteAnteriorPorIdClienteNuevo($idCliente);
                if (!$this->Reestructura_model->loteLiberadoPorReubicacion($loteAnterior->idLote)) {
                    $data = [
                        'tipoLiberacion' => 7,
                        'idLote' => $loteAnterior->idLote,
                        'idLoteNuevo' => $idLote
                    ];

                    if (!$this->Reestructura_model->aplicaLiberacion($data)) {
                        $data['message'] = 'ERROR';
                        echo json_encode($data);
                        return;
                    }
                }
            } 

        } else {
                $valida_rama = $this->VentasAsistentes_model->check_carta($idCliente);
                if($valida_rama[0]['tipo_nc']==1){
                    $validacionCarta = $this->VentasAsistentes_model->validaCartaCM($idCliente);
                    if($validacionCarta[0]['tipo_comprobanteD']==1) {
                        if(count($validacionCarta)<=0){
                            $data['message'] = 'MISSING_CARTA_RAMA';
                            echo json_encode($data);
                            exit;
                        }else{
                            if($validacionCarta[0]['tipo_comprobanteD']==1) {
                                if ($validacionCarta[0]['expediente'] == '' || $validacionCarta[0]['expediente'] == NULL) {
                                    $data['message'] = 'MISSING_CARTA_UPLOAD';
                                    echo json_encode($data);
                                    exit;
                                }
                            }
                        }
                    }
                }  

                $validate = $this->VentasAsistentes_model->validateSt8($idLote);
                if ($validate != 1) {
                    $data['message'] = 'FALSE';
                    echo json_encode($data);
                    return;
                }

                if (!$this->VentasAsistentes_model->updateSt($idLote,$arreglo,$arreglo2)){
                    $data['message'] = 'ERROR';
                    echo json_encode($data);
                    return;
                }

                $cliente = $this->Reestructura_model->obtenerClientePorId($idCliente);

                if (!in_array($cliente->proceso, [2,4])) {
                    $data['message'] = 'OK';
                    echo json_encode($data);
                    return;
                }

                $loteAnterior = $this->Reestructura_model->buscarLoteAnteriorPorIdClienteNuevo($idCliente);
                if (!$this->Reestructura_model->loteLiberadoPorReubicacion($loteAnterior->idLote)) {
                    $data = [
                        'tipoLiberacion' => 7,
                        'idLote' => $loteAnterior->idLote,
                        'idLoteNuevo' => $idLote
                    ];

                    if (!$this->Reestructura_model->aplicaLiberacion($data)) {
                        $data['message'] = 'ERROR';
                        echo json_encode($data);
                        return;
                    }
                }

                $data['message'] = 'OK';
                echo json_encode($data);
        }
    }
	
    public function editar_registro_loteRechazo_asistentes_proceceso8(){
        $idLote=$this->input->post('idLote');
        $idCondominio=$this->input->post('idCondominio');
        $nombreLote=$this->input->post('nombreLote');
        $idCliente=$this->input->post('idCliente');
        $comentario=$this->input->post('comentario');
        $modificado=date("Y-m-d H:i:s");

        $arreglo=array();
        $arreglo["idStatusContratacion"]= 6;
        $arreglo["idMovimiento"]=23;
        $arreglo["comentario"]=$comentario;
        $arreglo["usuario"]=$this->session->userdata('id_usuario');
        $arreglo["perfil"]=$this->session->userdata('id_rol');
        $arreglo["modificado"]=date("Y-m-d H:i:s");
        $arreglo["status8Flag"] = 0;

        $arreglo2=array();
        $arreglo2["idStatusContratacion"]=6;
        $arreglo2["idMovimiento"]=23;
        $arreglo2["nombreLote"]=$nombreLote;
        $arreglo2["comentario"]=$comentario;
        $arreglo2["usuario"]=$this->session->userdata('id_usuario');
        $arreglo2["perfil"]=$this->session->userdata('id_rol');
        $arreglo2["modificado"]=date("Y-m-d H:i:s");
        $arreglo2["fechaVenc"]= $modificado;
        $arreglo2["idLote"]= $idLote;
        $arreglo2["idCondominio"]= $idCondominio;
        $arreglo2["idCliente"]= $idCliente;

        $validate = $this->VentasAsistentes_model->validateSt8($idLote);

        if($validate == 1) {
        if ($this->VentasAsistentes_model->updateSt($idLote,$arreglo,$arreglo2) == TRUE) {
          $data['message'] = 'OK';
          echo json_encode($data);
        } else {
          $data['message'] = 'ERROR';
          echo json_encode($data);
        }
        } else {
            $data['message'] = 'FALSE';
            echo json_encode($data);
        }
    }

    public function editar_registro_loteRechazoAstatus2_asistentes_proceceso8() {
        $idLote=$this->input->post('idLote');
        $idCondominio=$this->input->post('idCondominio');
        $nombreLote=$this->input->post('nombreLote');
        $idCliente=$this->input->post('idCliente');
        $comentario=$this->input->post('comentario');
        $modificado=date("Y-m-d H:i:s");

        $arreglo=array();
        $arreglo["idStatusContratacion"]= 1;
        $arreglo["idMovimiento"]=73;
        $arreglo["comentario"]=$comentario;
        $arreglo["usuario"]=$this->session->userdata('id_usuario');
        $arreglo["perfil"]=$this->session->userdata('id_rol');
        $arreglo["modificado"]=date("Y-m-d H:i:s");
        $arreglo["status8Flag"] = 0;
        $arreglo["totalValidado"] = NULL;
        $arreglo["validacionEnganche"] = NULL;

        $arreglo2=array();
        $arreglo2["idStatusContratacion"]=1;
        $arreglo2["idMovimiento"]=73;
        $arreglo2["nombreLote"]=$nombreLote;
        $arreglo2["comentario"]=$comentario;
        $arreglo2["usuario"]=$this->session->userdata('id_usuario');
        $arreglo2["perfil"]=$this->session->userdata('id_rol');
        $arreglo2["modificado"]=date("Y-m-d H:i:s");
        $arreglo2["fechaVenc"]= $modificado;
        $arreglo2["idLote"]= $idLote;
        $arreglo2["idCondominio"]= $idCondominio;
        $arreglo2["idCliente"]= $idCliente;

        $infoLote = (array)$this->VentasAsistentes_model->getNameLote($idLote);

        $encabezados = [
            'nombreResidencial' =>  'PROYECTO',
            'nombre'            =>  'CONDOMINIO',
            'nombreLote'        =>  'LOTE',
            'motivoRechazo'     =>  'MOTIVO DE RECHAZO',
            'fechaHora'         =>  'FECHA/HORA'
        ];

        $data[] = array_merge($infoLote, [
            "motivoRechazo" =>  $comentario,
            "fechaHora"     =>  $modificado
        ]);

        $this->email
            ->initialize()
            ->from('Ciudad Maderas')
            ->to('tester.ti2@ciudadmaderas.com')
            // ->to($correosEntregar)
            ->subject('EXPEDIENTE RECHAZADO-VENTAS (8. CONTRATO ENTREGADO AL ASESOR PARA FIRMA DEL CLIENTE)')
            ->view($this->load->view('mail/asistente-gerente/editar-registro-lote-rechazo-status2-asistentes-proceso8', [
                'encabezados' => $encabezados,
                'contenido' => $data
            ], true));

        $validate = $this->VentasAsistentes_model->validateSt8($idLote);

        if($validate == 1){

          if ($this->VentasAsistentes_model->updateSt($idLote,$arreglo,$arreglo2) == TRUE){
            if ($this->email->send()) {
              $data['status_msg'] = 'Correo enviado correctamente';
            } else {
              $data['status_msg'] = 'Correo no enviado';
            }
            $data['message'] = 'OK';
            echo json_encode($data);

            }else{
              $data['message'] = 'ERROR';
              echo json_encode($data);
            }
        }else {
          $data['message'] = 'FALSE';
          echo json_encode($data);
        }
    }

    public function editar_registro_loteRevision_asistentesAadministracion11_proceceso8(){
        $idLote=$this->input->post('idLote');
        $idCondominio=$this->input->post('idCondominio');
        $nombreLote=$this->input->post('nombreLote');
        $idCliente=$this->input->post('idCliente');
        $comentario=$this->input->post('comentario');
        $modificado=date("Y-m-d H:i:s");
        $fechaVenc=$this->input->post('fechaVenc');

        $arreglo=array();
        $arreglo["idStatusContratacion"]=8;
        $arreglo["idMovimiento"]=67;
        $arreglo["comentario"]=$comentario;
        $arreglo["usuario"]=$this->session->userdata('id_usuario');
        $arreglo["perfil"]=$this->session->userdata('id_rol');
        $arreglo["modificado"]=date("Y-m-d H:i:s");
        $arreglo["fechaSolicitudValidacion"]=$modificado;
        $arreglo["status8Flag"] = 1;

        $valida_rama = $this->VentasAsistentes_model->check_carta($idCliente);
        if($valida_rama[0]['tipo_nc']==1){
          $validacionCarta = $this->VentasAsistentes_model->validaCartaCM($idCliente);
          if($validacionCarta[0]['tipo_comprobanteD']==1) {
              if(count($validacionCarta)<=0){
                  $data['message'] = 'MISSING_CARTA_RAMA';
                  echo json_encode($data);
                  exit;
              }else{
                  if($validacionCarta[0]['tipo_comprobanteD']==1) {
                      if ($validacionCarta[0]['expediente'] == '' || $validacionCarta[0]['expediente'] == NULL) {
                          $data['message'] = 'MISSING_CARTA_UPLOAD';
                          echo json_encode($data);
                          exit;
                      }
                  }
              }
          }
        }

        $horaActual = date('H:i:s');
        $horaInicio = date("08:00:00");
        $horaFin = date("16:00:00");

        if ($horaActual > $horaInicio and $horaActual < $horaFin) {

            $fechaAccion = date("Y-m-d H:i:s");
            $hoy_strtotime2 = strtotime($fechaAccion);
            $sig_fecha_dia2 = date('D', $hoy_strtotime2);
            $sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);

            if($sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
                 $sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
                 $sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
                 $sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
                 $sig_fecha_feriado2 == "25-12") {

                $fecha = $fechaAccion;

                $i = 0;

                while($i <= 1) {
                    $hoy_strtotime = strtotime($fecha);
                    $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
                    $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
                    $sig_fecha_dia = date('D', $sig_strtotime);
                    $sig_fecha_feriado = date('d-m', $sig_strtotime);
                    if( $sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
                        $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
                        $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
                        $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
                        $sig_fecha_feriado == "25-12") {
                        //
                    }else {
                        $fecha= $sig_fecha;
                        $i++;
                    }

                    $fecha = $sig_fecha;
               }

               $arreglo["fechaVenc"]= $fecha;
            } else {
                $fecha = $fechaAccion;
                $i = 0;

                while($i <= 0) {
                    $hoy_strtotime = strtotime($fecha);
                    $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
                    $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
                    $sig_fecha_dia = date('D', $sig_strtotime);

                    $sig_fecha_feriado = date('d-m', $sig_strtotime);

                    if( $sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
                        $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
                        $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
                        $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
                        $sig_fecha_feriado == "25-12") {
                        //
                    } else {
                        $fecha= $sig_fecha;
                        $i++;
                    }

                    $fecha = $sig_fecha;
                }
               $arreglo["fechaVenc"]= $fecha;
            }

        } elseif ($horaActual < $horaInicio || $horaActual > $horaFin) {

            $fechaAccion = date("Y-m-d H:i:s");
            $hoy_strtotime2 = strtotime($fechaAccion);
            $sig_fecha_dia2 = date('D', $hoy_strtotime2);
            $sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);
            if($sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
                $sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
                $sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
                $sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
                $sig_fecha_feriado2 == "25-12") {

                $fecha = $fechaAccion;
                $i = 0;

                while($i <= 1) {
                    $hoy_strtotime = strtotime($fecha);
                    $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
                    $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
                    $sig_fecha_dia = date('D', $sig_strtotime);
                    $sig_fecha_feriado = date('d-m', $sig_strtotime);

                    if($sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
                        $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
                        $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
                        $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
                        $sig_fecha_feriado == "25-12") {
                        //
                    } else {
                        $fecha= $sig_fecha;
                        $i++;
                    }

                    $fecha = $sig_fecha;
                }

                $arreglo["fechaVenc"]= $fecha;

            } else {

                $fecha = $fechaAccion;

                $i = 0;
                while($i <= 1) {
                    $hoy_strtotime = strtotime($fecha);
                    $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
                    $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
                    $sig_fecha_dia = date('D', $sig_strtotime);
                    $sig_fecha_feriado = date('d-m', $sig_strtotime);

                    if($sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
                        $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
                        $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
                        $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
                        $sig_fecha_feriado == "25-12") {
                        //
                    } else {
                        $fecha= $sig_fecha;
                        $i++;
                    }
                    $fecha = $sig_fecha;
                }
                $arreglo["fechaVenc"]= $fecha;
            }
        }

        $arreglo2=array();
        $arreglo2["idStatusContratacion"]=8;
        $arreglo2["idMovimiento"]=67;
        $arreglo2["nombreLote"]=$nombreLote;
        $arreglo2["comentario"]=$comentario;
        $arreglo2["usuario"]=$this->session->userdata('id_usuario');
        $arreglo2["perfil"]=$this->session->userdata('id_rol');
        $arreglo2["modificado"]=date("Y-m-d H:i:s");
        $arreglo2["fechaVenc"]= $fechaVenc;
        $arreglo2["idLote"]= $idLote;
        $arreglo2["idCondominio"]= $idCondominio;
        $arreglo2["idCliente"]= $idCliente;

        $validate = $this->VentasAsistentes_model->validateSt8($idLote);
        if ($validate != 1) {
            $data['message'] = 'FALSE';
            echo json_encode($data);
            return;
        }

        if (!$this->VentasAsistentes_model->updateSt($idLote,$arreglo,$arreglo2)){
            $data['message'] = 'ERROR';
            echo json_encode($data);
            return;
        }

        $cliente = $this->Reestructura_model->obtenerClientePorId($idCliente);

        if (!in_array($cliente->proceso, [2,4])) {
            $data['message'] = 'OK';
            echo json_encode($data);
            return;
        }

        $loteAnterior = $this->Reestructura_model->buscarLoteAnteriorPorIdClienteNuevo($idCliente);
        if (!$this->Reestructura_model->loteLiberadoPorReubicacion($loteAnterior->idLote)) {
            $data = [
                'tipoLiberacion' => 7,
                'idLote' => $loteAnterior->idLote,
                'idLoteNuevo' => $idLote
            ];

            if (!$this->Reestructura_model->aplicaLiberacion($data)) {
                $data['message'] = 'ERROR';
                echo json_encode($data);
                return;
            }
        }

        $data['message'] = 'OK';
        echo json_encode($data);
    }

    public function getStatCont14() {
      $data=array();
      $data = $this->VentasAsistentes_model->registroStatusContratacion14();

      if($data != null) {
          echo json_encode($data);
      } else {
          echo json_encode(array());
      }
    }

    public function editar_registro_lote_asistentes_proceceso14(){

        $idLote=$this->input->post('idLote');
        $idCondominio=$this->input->post('idCondominio');
        $nombreLote=$this->input->post('nombreLote');
        $idCliente=$this->input->post('idCliente');
        $comentario=$this->input->post('comentario');
        $modificado=date('Y-m-d H:i:s');
        $fechaVenc=$this->input->post('fechaVenc');


        $arreglo=array();
        $arreglo["idStatusContratacion"]=14;
        $arreglo["idMovimiento"]=44;
        $arreglo["comentario"]=$comentario;
        $arreglo["usuario"]= $this->session->userdata('id_usuario');
        $arreglo["perfil"]=$this->session->userdata('id_rol');
        $arreglo["modificado"]=date("Y-m-d H:i:s");

        $horaActual = date('H:i:s');
        $horaInicio = date("08:00:00");
        $horaFin = date("16:00:00");

        if ($horaActual > $horaInicio and $horaActual < $horaFin) {

        $fechaAccion = date("Y-m-d H:i:s");
        $hoy_strtotime2 = strtotime($fechaAccion);
        $sig_fecha_dia2 = date('D', $hoy_strtotime2);
          $sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);

        if($sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
             $sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
             $sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
             $sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
             $sig_fecha_feriado2 == "25-12") {

        $fecha = $fechaAccion;
        $i = 0;

            while($i <= 0) {
          $hoy_strtotime = strtotime($fecha);
          $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
          $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
          $sig_fecha_dia = date('D', $sig_strtotime);
            $sig_fecha_feriado = date('d-m', $sig_strtotime);

          if( $sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
             $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
             $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
             $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
             $sig_fecha_feriado == "25-12") {
               }
                 else {
                        $fecha= $sig_fecha;
                         $i++;
                      }
            $fecha = $sig_fecha;
                   }
               $arreglo["fechaVenc"]= $fecha;
               }else{
        $fecha = $fechaAccion;
        $i = 0;
            while($i <= -1) {
          $hoy_strtotime = strtotime($fecha);
          $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
          $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
          $sig_fecha_dia = date('D', $sig_strtotime);
            $sig_fecha_feriado = date('d-m', $sig_strtotime);

          if( $sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
             $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
             $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
             $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
             $sig_fecha_feriado == "25-12") {
               }
                 else {
                        $fecha= $sig_fecha;
                         $i++;
                      }
            $fecha = $sig_fecha;
                   }
               $arreglo["fechaVenc"]= $fecha;
               }
        } elseif ($horaActual < $horaInicio || $horaActual > $horaFin) {

        $fechaAccion = date("Y-m-d H:i:s");
        $hoy_strtotime2 = strtotime($fechaAccion);
        $sig_fecha_dia2 = date('D', $hoy_strtotime2);
          $sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);

        if($sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
             $sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
             $sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
             $sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
             $sig_fecha_feriado2 == "25-12") {

        $fecha = $fechaAccion;

        $i = 0;
            while($i <= 0) {
          $hoy_strtotime = strtotime($fecha);
          $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
          $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
          $sig_fecha_dia = date('D', $sig_strtotime);
            $sig_fecha_feriado = date('d-m', $sig_strtotime);

          if($sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
             $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
             $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
             $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
             $sig_fecha_feriado == "25-12") {
               }
                 else {
                        $fecha= $sig_fecha;
                         $i++;
                      }
            $fecha = $sig_fecha;
                   }
               $arreglo["fechaVenc"]= $fecha;
               }else{
        $fecha = $fechaAccion;
        $i = 0;
            while($i <= 0) {
          $hoy_strtotime = strtotime($fecha);
          $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
          $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
          $sig_fecha_dia = date('D', $sig_strtotime);
            $sig_fecha_feriado = date('d-m', $sig_strtotime);

          if($sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
             $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
             $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
             $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
             $sig_fecha_feriado == "25-12") {
               }
                 else {
                        $fecha= $sig_fecha;
                         $i++;
                      }
            $fecha = $sig_fecha;
                   }
             $arreglo["fechaVenc"]= $fecha;
               }
        }

        $arreglo2=array();
        $arreglo2["idStatusContratacion"]=14;
        $arreglo2["idMovimiento"]=44;
        $arreglo2["nombreLote"]=$nombreLote;
        $arreglo2["comentario"]=$comentario;
        $arreglo2["usuario"]=$this->session->userdata('id_usuario');
        $arreglo2["perfil"]=$this->session->userdata('id_rol');
        $arreglo2["modificado"]=date("Y-m-d H:i:s");
        $arreglo2["fechaVenc"]= $fechaVenc;
        $arreglo2["idLote"]= $idLote;
        $arreglo2["idCondominio"]= $idCondominio;
        $arreglo2["idCliente"]= $idCliente;
	

		$validate = $this->VentasAsistentes_model->validateSt14($idLote);

		if($validate == 1){

		if ($this->VentasAsistentes_model->updateSt($idLote,$arreglo,$arreglo2) == TRUE){ 
			$data['message'] = 'OK';
			echo json_encode($data);

			}else{
				$data['message'] = 'ERROR';
				echo json_encode($data);
			}

		}else {
			$data['message'] = 'FALSE';
			echo json_encode($data);
		}

    }


    public function editar_registro_loteRevision_asistentes_proceceso14(){
  
        $idLote=$this->input->post('idLote');
        $idCondominio=$this->input->post('idCondominio');
        $nombreLote=$this->input->post('nombreLote');
        $idCliente=$this->input->post('idCliente');
        $comentario=$this->input->post('comentario');
        $modificado=date("Y-m-d H:i:s");
        $fechaVenc=$this->input->post('fechaVenc');

        $arreglo=array();
        $arreglo["idStatusContratacion"]=14;
        $arreglo["idMovimiento"]=69;
        $arreglo["comentario"]=$comentario;
        $arreglo["usuario"]= $this->session->userdata('id_usuario');
        $arreglo["perfil"]=$this->session->userdata('id_rol');


        $arreglo["modificado"]=date("Y-m-d H:i:s");

        $horaActual = date('H:i:s');
        $horaInicio = date("08:00:00");
        $horaFin = date("16:00:00");

        if ($horaActual > $horaInicio and $horaActual < $horaFin) {

        $fechaAccion = date("Y-m-d H:i:s");
        $hoy_strtotime2 = strtotime($fechaAccion);
        $sig_fecha_dia2 = date('D', $hoy_strtotime2);
          $sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);

        if($sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
             $sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
             $sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
             $sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
             $sig_fecha_feriado2 == "25-12") {

        $fecha = $fechaAccion;

        $i = 0;
            while($i <= 0) {
          $hoy_strtotime = strtotime($fecha);
          $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
          $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
          $sig_fecha_dia = date('D', $sig_strtotime);
            $sig_fecha_feriado = date('d-m', $sig_strtotime);

          if( $sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
             $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
             $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
             $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
             $sig_fecha_feriado == "25-12") {
               }
                 else {
                        $fecha= $sig_fecha;
                         $i++;
                      }
            $fecha = $sig_fecha;
                   }
               $arreglo["fechaVenc"]= $fecha;
               }else{

        $fecha = $fechaAccion;
        $i = 0;

            while($i <= -1) {
          $hoy_strtotime = strtotime($fecha);
          $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
          $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
          $sig_fecha_dia = date('D', $sig_strtotime);
            $sig_fecha_feriado = date('d-m', $sig_strtotime);

          if( $sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
             $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
             $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
             $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
             $sig_fecha_feriado == "25-12") {
               }
                 else {
                        $fecha= $sig_fecha;
                         $i++;
                      }
            $fecha = $sig_fecha;
                   }
               $arreglo["fechaVenc"]= $fecha;
               }

        } elseif ($horaActual < $horaInicio || $horaActual > $horaFin) {

        $fechaAccion = date("Y-m-d H:i:s");
        $hoy_strtotime2 = strtotime($fechaAccion);
        $sig_fecha_dia2 = date('D', $hoy_strtotime2);
          $sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);

        if($sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
             $sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
             $sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
             $sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
             $sig_fecha_feriado2 == "25-12") {

        $fecha = $fechaAccion;
        $i = 0;

            while($i <= 0) {
          $hoy_strtotime = strtotime($fecha);
          $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
          $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
          $sig_fecha_dia = date('D', $sig_strtotime);
            $sig_fecha_feriado = date('d-m', $sig_strtotime);

          if($sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
             $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
             $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
             $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
             $sig_fecha_feriado == "25-12") {
               }
                 else {
                        $fecha= $sig_fecha;
                         $i++;
                      }
            $fecha = $sig_fecha;
                   }
               $arreglo["fechaVenc"]= $fecha;
               }else{
        $fecha = $fechaAccion;
        $i = 0;
            while($i <= 0) {
          $hoy_strtotime = strtotime($fecha);
          $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
          $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
          $sig_fecha_dia = date('D', $sig_strtotime);
            $sig_fecha_feriado = date('d-m', $sig_strtotime);

          if($sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" ||
             $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" ||
             $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" ||
             $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" ||
             $sig_fecha_feriado == "25-12") {
               }
                 else {
                        $fecha= $sig_fecha;
                         $i++;
                      }
            $fecha = $sig_fecha;
                   }
             $arreglo["fechaVenc"]= $fecha;
               }
        }

        $arreglo2=array();
        $arreglo2["idStatusContratacion"]=14;
        $arreglo2["idMovimiento"]=69;
        $arreglo2["nombreLote"]=$nombreLote;
        $arreglo2["comentario"]=$comentario;
        $arreglo2["usuario"]=$this->session->userdata('id_usuario');
        $arreglo2["perfil"]=$this->session->userdata('id_rol');
        $arreglo2["modificado"]=date("Y-m-d H:i:s");
        $arreglo2["fechaVenc"]= $fechaVenc;
        $arreglo2["idLote"]= $idLote;
        $arreglo2["idCondominio"]= $idCondominio;
        $arreglo2["idCliente"]= $idCliente;


        $validate = $this->VentasAsistentes_model->validateSt14($idLote);

        if($validate == 1){

        if ($this->VentasAsistentes_model->updateSt($idLote,$arreglo,$arreglo2) == TRUE){
            $data['message'] = 'OK';
            echo json_encode($data);

            }else{
                $data['message'] = 'ERROR';
                echo json_encode($data);
            }

        }else {
            $data['message'] = 'FALSE';
            echo json_encode($data);
        }
   }

    public function editar_registro_loteRevision_asistentes_proceceso8(){
        $idLote=$this->input->post('idLote');
        $idCondominio=$this->input->post('idCondominio');
        $nombreLote=$this->input->post('nombreLote');
        $idCliente=$this->input->post('idCliente');
        $comentario=$this->input->post('comentario');
        $modificado=date("Y-m-d H:i:s");
        $fechaVenc=$this->input->post('fechaVenc');

        $arreglo=array();
        $arreglo["idStatusContratacion"]=8;
        $arreglo["idMovimiento"]=65;
        $arreglo["comentario"]=$comentario;
        $arreglo["usuario"]=$this->session->userdata('id_usuario');
        $arreglo["perfil"]=$this->session->userdata('id_rol');
        $arreglo["modificado"]=date("Y-m-d H:i:s");
        $arreglo["status8Flag"] = 1;

        $arreglo2=array();
        $arreglo2["idStatusContratacion"]=8;
        $arreglo2["idMovimiento"]=65;
        $arreglo2["nombreLote"]=$nombreLote;
        $arreglo2["comentario"]=$comentario;
        $arreglo2["usuario"]=$this->session->userdata('id_usuario');
        $arreglo2["perfil"]=$this->session->userdata('id_rol');
        $arreglo2["modificado"]=date("Y-m-d H:i:s");
        $arreglo2["fechaVenc"]= $fechaVenc;
        $arreglo2["idLote"]= $idLote;
        $arreglo2["idCondominio"]= $idCondominio;
        $arreglo2["idCliente"]= $idCliente;

        $validate = $this->VentasAsistentes_model->validateSt8($idLote);
        if ($validate != 1) {
            $data['message'] = 'FALSE';
            echo json_encode($data);
            return;
        }

        if (!$this->VentasAsistentes_model->updateSt($idLote,$arreglo,$arreglo2)){
            $data['message'] = 'ERROR';
            echo json_encode($data);
            return;
        }

        $cliente = $this->Reestructura_model->obtenerClientePorId($idCliente);

        if (!in_array($cliente->proceso, [2,4])) {
            $data['message'] = 'OK';
            echo json_encode($data);
            return;
        }

        $loteAnterior = $this->Reestructura_model->buscarLoteAnteriorPorIdClienteNuevo($idCliente);
        if (!$this->Reestructura_model->loteLiberadoPorReubicacion($loteAnterior->idLote)) {
            $data = [
                'tipoLiberacion' => 7,
                'idLote' => $loteAnterior->idLote,
                'idLoteNuevo' => $idLote
            ];

            if (!$this->Reestructura_model->aplicaLiberacion($data)) {
                $data['message'] = 'ERROR';
                echo json_encode($data);
                return;
            }
        }

        $data['message'] = 'OK';
        echo json_encode($data);
    }


    public function setVar($var)
    {
        $this->session->set_userdata('datauserjava', $var);
        echo $this->session->userdata('datauserjava');
    }

    public function alta_autorizacionVentas(){
      $nombreResidencial=$this->input->post('nombreResidencial');
      $nombreCondominio=$this->input->post('nombreCondominio');
      $nombreLote=$this->input->post('nombreLote');

      $proyecto = str_replace(' ', '', $nombreResidencial);
      $condominio = str_replace(' ', '', $nombreCondominio);
      $condom = substr($condominio, 0, 3);
      $cond = strtoupper($condom);
      $numeroLote = preg_replace('/[^0-9]/', '', $nombreLote);
      $date = date('dmY');
      $composicion = $proyecto . "_" . $cond . $numeroLote . "_" . $date;


      $aleatorio = rand(100,1000);
      $idCliente=$this->input->post('idCliente');
      $nombArchivo=$composicion;
      $expediente=  $nombArchivo.'_'.$idCliente.'_'.$aleatorio.'_'.$_FILES["expediente"]["name"];
      $idCondominio=$this->input->post('idCondominio');


      $arreglo2=array();
      $arreglo2["movimiento"]="Se adjunto Autorización";
      $arreglo2["idCliente"]=$this->input->post('idClienteHistorial');
      $arreglo2["idLote"]=$this->input->post('idLoteHistorial');
      $arreglo2["expediente"]= $expediente;
      $arreglo2["idUser"]=$this->input->post('idUser');
      $arreglo2["idCondominio"]=$this->input->post('idCondominio');


      $arreglo=array();
      $arreglo["expediente"] = $nombArchivo.'_'.$idCliente.'_'.$aleatorio.'_'.$_FILES["expediente"]["name"];
      if ($this->registrolote_modelo->editaRegistroCliente($idCliente,$arreglo)){
        $this->registrolote_modelo->insert_historial_documento($arreglo2);
        if (move_uploaded_file($_FILES["expediente"]["tmp_name"],"static/documentos/cliente/expediente/".$nombArchivo.'_'.$idCliente.'_'.$aleatorio.'_'.$_FILES["expediente"]["name"])) {
          $data['message'] = 'OK';
              echo json_encode($data);
        }
        else{
          $data['message'] = 'FALSE';
              echo json_encode($data);
        }
      }
    }
}
