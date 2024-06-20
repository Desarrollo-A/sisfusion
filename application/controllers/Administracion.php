<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
use PhpOffice\PhpSpreadSheet\Spreadsheet;
require_once './dist/js/jwt/JWT.php';
use Firebase\JWT\JWT;
class Administracion extends CI_Controller{
	public function __construct()
	{ 
		parent::__construct();
		$this->load->model('Administracion_model');
		$this->load->model('registrolote_modelo');

		$this->load->library(array('session', 'form_validation'));
		
		$this->load->model('General_model');
		$this->load->model('asesor/Asesor_model'); //EN ESTE MODELO SE ENCUENTRAN LAS CONSULTAS DEL MENU
		$this->load->library(array('session','form_validation', 'get_menu', 'Jwt_actions', 'Formatter','permisos_sidebar'));
		//LIBRERIA PARA LLAMAR OBTENER LAS CONSULTAS DE LAS  DEL MENÚ
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
	


	public function index() {
		if (!in_array($this->session->userdata('id_rol'), array('11', '34' , '23', '35' , '26', '41' , '39', '31' , '49', '50' , '40', '54' , '58', '10', '18', '19', '20', 
		    '21', '28', '33', '25', '25', '27', '30', '36', '22', '53', '8' , '23', '12', '61', '63', '64' , '65', '66' , '69', '68' , '70', '71', '72', '73' , '74', '75' ,
		    '76', '77' , '78', '79' , '80', '81' , '82', '83' , '84', '98', '99', '101'))) {
			redirect(base_url() . 'login');
		}
		$this->load->view('template/header');
		$this->load->view('template/home');
		$this->load->view('template/footer');
	}

	public function lista_cliente_administracion(){
		$this->load->view('template/header');
		$this->load->view("contratacion/datos_cliente_contratacion_view");
	}

	public function datos_estatus_11_datos() {
		$data = $this->Administracion_model->get_datos_lote_11();
	  	$dataPer= array();
	  	for($i=0;$i< count($data);$i++) {
			$dataPer[$i]['idLote']=$data[$i]->idLote;
		  	$dataPer[$i]['idCondominio']=$data[$i]->idCondominio;
		  	$dataPer[$i]['id_cliente']=$data[$i]->id_cliente;
		  	$dataPer[$i]['nombreCliente']=$data[$i]->nombreCliente;
		  	$dataPer[$i]['nombreLote']=$data[$i]->nombreLote;
		  	$dataPer[$i]['idStatusContratacion']=$data[$i]->idStatusContratacion;
		  	$dataPer[$i]['idMovimiento']=$data[$i]->idMovimiento;
		  	$dataPer[$i]['modificado']=$data[$i]->modificado;
		  	$dataPer[$i]['rfc']=$data[$i]->rfc;
		  	$dataPer[$i]['comentario']=$data[$i]->comentario;
		  	$dataPer[$i]['fechaVenc']=$data[$i]->fechaVenc;
		  	$dataPer[$i]['perfil']=$data[$i]->perfil;
		  	$dataPer[$i]['nombreResidencial']=$data[$i]->nombreResidencial;
		  	$dataPer[$i]['nombreCondominio']=$data[$i]->nombreCondominio;
		  	$dataPer[$i]['ubicacion']=$data[$i]->ubicacion;
		  	$dataPer[$i]['gerente']=$data[$i]->gerente;
		  	$dataPer[$i]['asesor']=$data[$i]->asesor;
		  	$dataPer[$i]['coordinador']=$data[$i]->coordinador;
		  	$dataPer[$i]['tipo_venta']=$data[$i]->tipo_venta;
		  	$dataPer[$i]['descripcion']=$data[$i]->descripcion;
		  	$dataPer[$i]['totalNeto']=$data[$i]->totalNeto;
			$dataPer[$i]['totalValidado']=$data[$i]->totalValidado;
		  	$dataPer[$i]['vl']=$data[$i]->vl;
		  	$dataPer[$i]['nombreSede']=$data[$i]->nombreSede;
		  	$dataPer[$i]['tipo_proceso']=$data[$i]->tipo_proceso;
            $dataPer[$i]['proceso']=$data[$i]->proceso;
		  	$horaInicio = date("08:00:00");
		  	$horaFin = date("16:00:00");
		  	$arregloFechas = array();  
		  	$fechaAccion = $data[$i]->fechaSolicitudValidacion;  
		  	$ultimaFechaEstatus7 = $data[$i]->ultimaFechaEstatus7;  
		  	$hoy_strtotime2 = $data[$i]->fechaSolicitudValidacion=='' || empty($data[$i]->fechaSolicitudValidacion) ? '' : strtotime($fechaAccion);
		  	$sig_fecha_dia2 = date('D', intval($hoy_strtotime2));
		  	$sig_fecha_feriado2 = date('d-m', intval($hoy_strtotime2));
		  	$time = date('H:i:s', intval($hoy_strtotime2));
			
			if($data[$i]->fechaSolicitudValidacion=='' || empty($data[$i]->fechaSolicitudValidacion))
                $dataPer[$i]['fechaVenc2'] = 'N/A';
            else {
                if ($time > $horaInicio and $time < $horaFin) {
                    if ($sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" || $sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" || $sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" || $sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" || $sig_fecha_feriado2 == "25-12") {
						$fecha = $ultimaFechaEstatus7; // ANTES fechaAccion
                        $z = 0;
                        while ($z <= 1) {
                            $hoy_strtotime = strtotime($fecha);
                            $sig_strtotime = strtotime('+1 days', $hoy_strtotime);
                            $sig_fecha = date("Y-m-d H:i:s", $sig_strtotime);
                            $sig_fecha_dia = date('D', $sig_strtotime);
                            $sig_fecha_feriado = date('d-m', $sig_strtotime);
                            if ($sig_fecha_dia == "Sat" || $sig_fecha_dia == "Sun" || $sig_fecha_feriado == "01-01" || $sig_fecha_feriado == "06-02" || $sig_fecha_feriado == "20-03" || $sig_fecha_feriado == "01-05" || $sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" || $sig_fecha_feriado == "25-12") {
							} else {
								$arregloFechas[$z] = $sig_fecha;
								$z++;
							}
							$fecha = $sig_fecha;
                        }
                        $d = end($arregloFechas);
                        $dataPer[$i]['fechaVenc2'] = $d;
                    } else {
						$fecha = $ultimaFechaEstatus7; // ANTES fechaAccion
                        $z = 0;
                        while ($z <= 0) {
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
                                $arregloFechas[$z] = $sig_fecha;
                                $z++;
                            }
                            $fecha = $sig_fecha;
                        }
                        $d = end($arregloFechas);
                        $dataPer[$i]['fechaVenc2'] = $d;
                    }
                } 
                elseif ($time < $horaInicio || $time > $horaFin) {
                    if ($sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" ||
                        $sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" ||
                        $sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
                        $sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" ||
                        $sig_fecha_feriado2 == "25-12") {
						$fecha = $ultimaFechaEstatus7; // ANTES fechaAccion
                        $z = 0;
                        while ($z <= 1) {
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
                                $arregloFechas[$z] = $sig_fecha;
                                $z++;
                            }
                            $fecha = $sig_fecha;
                        }
                        $d = end($arregloFechas);
                        $dataPer[$i]['fechaVenc2'] = $d;
                    } else {
                        $fecha = $ultimaFechaEstatus7; // ANTES fechaAccion
                        $z = 0;
                        while ($z <= 1) {
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
                                $arregloFechas[$z] = $sig_fecha;
                                $z++;
                            }
                            $fecha = $sig_fecha;
                        }
                        $d = end($arregloFechas);
                        $dataPer[$i]['fechaVenc2'] = $d;
                    }
                }
            }
	  	}
		if($dataPer != null)
			echo json_encode($dataPer);
		else
		  	echo json_encode(array());
	}

	public function inventario()/*this is the function*/
	{
		$datos["residencial"] = $this->registrolote_modelo->getResidencialQro();
		$this->load->view('template/header');
		$datos["rol"] = $this->session->userdata('id_rol');
		$this->load->view("contratacion/datos_lote_contratacion_view", $datos);
	}

	public function editar_registro_lote_administracion_proceceso11(){
		$idLote=$this->input->post('idLote');	
		$idCondominio=$this->input->post('idCondominio');
		$nombreLote=$this->input->post('nombreLote');
		$idCliente=$this->input->post('idCliente');
		$comentario=$this->input->post('comentario');
		$modificado=date('Y-m-d H:i:s');
		$fechaVenc=$this->input->post('fechaVenc');
		$totalValidado=$this->input->post('totalValidado');
	
	
		$arreglo=array();
		$arreglo["idStatusContratacion"]=11;
		$arreglo["idMovimiento"]=41;
		$arreglo["comentario"]=$comentario;
		$arreglo["usuario"]=$this->session->userdata('id_usuario');
		$arreglo["perfil"]=$this->session->userdata('id_rol');
		$arreglo["modificado"]=date("Y-m-d H:i:s");	
		$arreglo["validacionEnganche"]= "VALIDADO";
		$arreglo["totalValidado"]= str_replace(array('$', ','),'', $totalValidado);
	
		$horaActual = date('H:i:s');
		$horaInicio = date("08:00:00");
		$horaFin = date("16:00:00");

		if ($horaActual > $horaInicio and $horaActual < $horaFin) {

		$fechaAccion = date("Y-m-d H:i:s");
		$hoy_strtotime2 = strtotime($fechaAccion);
		$sig_fecha_dia2 = date('D', $hoy_strtotime2);
		$sig_fecha_feriado2 = date('d-m', $hoy_strtotime2);

		if($sig_fecha_dia2 == "Sat" || $sig_fecha_dia2 == "Sun" || 
			$sig_fecha_feriado2 == "01-01" || $sig_fecha_feriado2 == "06-02" || $sig_fecha_feriado2 == "20-03" || $sig_fecha_feriado2 == "01-05" ||
			$sig_fecha_feriado2 == "16-09" || $sig_fecha_feriado2 == "20-11" || $sig_fecha_feriado2 == "19-11" || $sig_fecha_feriado2 == "25-12"){
			
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
						$sig_fecha_feriado == "16-09" || $sig_fecha_feriado == "20-11" || $sig_fecha_feriado == "19-11" || $sig_fecha_feriado == "25-12") {}
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
					$sig_fecha_feriado == "25-12") {}
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
			$arreglo2["idStatusContratacion"]=11;	
			$arreglo2["idMovimiento"]=41;
			$arreglo2["nombreLote"]=$nombreLote;
			$arreglo2["comentario"]=$comentario;
			$arreglo2["usuario"]=$this->session->userdata('id_usuario');
			$arreglo2["perfil"]=$this->session->userdata('id_rol');
			$arreglo2["modificado"]=date("Y-m-d H:i:s");
			$arreglo2["fechaVenc"]= $fechaVenc;
			$arreglo2["idLote"]= $idLote; 	
			$arreglo2["idCondominio"]= $idCondominio;          
			$arreglo2["idCliente"]= $idCliente;    
		

			$validate = $this->Administracion_model->validateSt11($idLote);


			if($validate == 1){

			if ($this->Administracion_model->updateSt($idLote,$arreglo,$arreglo2) == TRUE){ 
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
	
	public function editar_registro_loteRechazo_administracion_proceceso11() {
		$idLote = $this->input->post('idLote');	 
		$idCondominio = $this->input->post('idCondominio');
		$nombreLote = $this->input->post('nombreLote');
		$idCliente = $this->input->post('idCliente');
		$comentario = $this->input->post('comentario');
		$observaciones = $this->input->post('observaciones');
		$user = $this->input->post('user');
		$perfil = $this->input->post('perfil'); 
		$modificado = date("Y-m-d H:i:s");
		$arreglo = array(); 
		$arreglo["idStatusContratacion"] = 7;
		$arreglo["idMovimiento"] = 66; 
		$arreglo["comentario"] = $comentario . ' - ' . $observaciones;
		$arreglo["usuario"] = $this->session->userdata('id_usuario');
		$arreglo["perfil"] = $this->session->userdata('id_rol');
		$arreglo["modificado"] = date("Y-m-d H:i:s");
		$arreglo["fechaVenc"] = date("Y-m-d H:i:s");
		$arreglo["status8Flag"] = 0;
		$arreglo2=array();
		$arreglo2["idStatusContratacion"] = 7;
		$arreglo2["idMovimiento"] = 66;
		$arreglo2["nombreLote"] = $nombreLote;
		$arreglo2["comentario"] = $comentario . ' - ' . $observaciones;
		$arreglo2["usuario"] = $this->session->userdata('id_usuario');
		$arreglo2["perfil"] = $this->session->userdata('id_rol');
		$arreglo2["modificado"] = date("Y-m-d H:i:s");
		$arreglo2["fechaVenc"] = $modificado;
		$arreglo2["idLote"] = $idLote;  
		$arreglo2["idCondominio"] = $idCondominio;          
		$arreglo2["idCliente"] = $idCliente;   
		$validate = $this->Administracion_model->validateSt11($idLote);
		if($validate == 1) {
			if ($this->Administracion_model->updateSt($idLote, $arreglo, $arreglo2) == TRUE){ 
				$data['message'] = 'OK';
				echo json_encode($data);
			}else {
				$data['message'] = 'ERROR';
				echo json_encode($data);
			}
		} else {
			$data['message'] = 'FALSE';
			echo json_encode($data);
		}
   }

	public function validateSession()
	{
		if($this->session->userdata('id_usuario')=="" || $this->session->userdata('id_rol')=="")
		{
			redirect(base_url() . "index.php/login");
		}
	}
	
    public function status11Validado() {
        $this->load->view('template/header');
        $this->load->view("administracion/validadoStatus11");
    }

	public function clienteRegimen(){
        $this->load->view('template/header');
        $this->load->view("administracion/clienteRegimenView");
    }

    public function getClienteRegimen(){
        $data = $this->Administracion_model->getClienteRegimen()->result_array();
        if ($data != null)
                echo json_encode($data);
            else
                echo json_encode(array());
    }

    public function getDateStatus11(){
	    $data = $this->Administracion_model->getDateStatus11();
	    if($data == TRUE){
            $response['message'] = 'OK';
        }else{
            $response['message'] = 'ERROR';
        }
        echo json_encode($data);
    }

	public function repAdministracion(){
        $this->load->view('template/header');
        $this->load->view("administracion/vista_reporte_admin");
	}

	public function getRepoAdmin($idResidencial){
		$data = $this->Administracion_model->getRepAdmon($idResidencial);
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
	}

	public function reporteClientesFactura(){
        $this->load->view('template/header');
        $this->load->view("administracion/reporteClientesFacturaView");
    }

    public function getReporteClientesFactura(){
        $data = $this->Administracion_model->getReporteClientesFactura()->result_array();
        if ($data != null)
            echo json_encode($data);
        else
            echo json_encode(array());
    }
	
	public function reporteEstatus10(){
        $this->load->view('template/header');
        $this->load->view("administracion/reporteEstatus10");
    }

    public function getReporteEstatus10(){
        if (isset($_POST) && !empty($_POST)) {
            $fechaInicio = explode('/', $this->input->post("beginDate"));
            $fechaFin = explode('/', $this->input->post("endDate"));
            $typeTransaction = $this->input->post("typeTransaction");
            $beginDate = date("Y-m-d", strtotime("{$fechaInicio[2]}-{$fechaInicio[1]}-{$fechaInicio[0]}"));
            $endDate = date("Y-m-d", strtotime("{$fechaFin[2]}-{$fechaFin[1]}-{$fechaFin[0]}"));
            $data = $this->Administracion_model->reporteEstatus10($typeTransaction, $beginDate, $endDate);
            echo json_encode($data);
        } else {
            json_encode(array());
        }
    }
	public function datosMonetarios()
	{
		$this->load->view('template/header');
		$this->load->view("administracion/datosMonetariosView");
	}
	function getregistrosClientesTwo()
    {
        $objDatos = json_decode(file_get_contents("php://input"));
        $index_proyecto = $this->input->post('index_proyecto');
        $index_condominio = $this->input->post('index_condominio');
        $dato = $this->Administracion_model->registroClienteTwo($index_proyecto, $index_condominio);
        if ($dato != null) {
            echo json_encode($dato);
        } else {
            echo json_encode(array());
        }
    }

	public function saveDatosMonetarios(){
		date_default_timezone_set('America/Mexico_City');
        $hoy = date('Y-m-d H:i:s');  
		$datos = $_POST;
		//var_dump($datos);
		$datos['usuario'] = $this->session->userdata('id_usuario');
		$datos['fecha'] = $hoy;
		$respuesta = $this->Administracion_model->saveDatosMonetarios($datos);
		if($respuesta == TRUE){
            echo json_encode(1);
        }else{
			echo json_encode(0);
        }
	}

	public function masterModulo (){
		$this->load->view('template/header');
		$this->load->view('administracion/master_view.php');
	}
	public function getDatosLotes($idLote) {
		$data = $this->Administracion_model->getDatosLotes($idLote);
		if($data != null) {
			echo json_encode($data);
		}else {
			json_encode(array());
		}
	}
	/*public function anyEmpty(...$values) {
		foreach ($values as $value) {
			if ($value == null || $value == ''){
				return true;
			}
		}
		return false;
	}*/
	public function anyEmpty($msg, ...$values) {
    	foreach ($values as $value) {
        	if ($value == null || $value == ''){
            	echo json_encode(array("empty" => true, "msg" => $msg));
            	exit; 
        	}
    	}
    	return false;
	}
	
	public function masterOptions(){
		$accion = $this->input->post('opciones');
		$data = $_POST;
		$idCliente = $data['idCliente'];
		$representante = $data['representante'];
		$idLote = $data['idLote'];
		$tipoVenta = $data['tipoVenta'];
		$idSede = $data['sedes'];
		$impuesto = $data['impuesto'];
		$nombre = $data['nombre_rep'];
		$paterno = $data['paterno_rep'];
		$materno = $data['materno_rep'];
		$estatus =  $data['repEstatus'];
		$idRepresentante = $data['repData'];
		$comentario = $data['comentarioLote'];
		$switchCheckbox = isset($data['switchCheckbox']) && $data['switchCheckbox'] !== '' ? $data['switchCheckbox'] : '';
		$idTipoVenta = $data['idTipoVenta'] != "" ? '': $data['idTipoVenta'];
		$nacionalidad = $data['nacionalidad'];
		$tipoCasa = $data['tipoCasa'];
		
		//ACTUALIZAR RL
		if($accion == 1 && !$this->anyEmpty("Por favor seleccione algún representante",$representante, $idCliente)){
			$response = $this->General_model->updateRecord('clientes', array('rl' => $representante), 'id_cliente', $idCliente);
			echo json_encode(array("status"=> $response, "tabla" => true));
		}	
		else if($accion == 2 && !$this->anyEmpty("Por favor seleccione el tipo de venta",$tipoVenta, $idLote)){
			$response = $this->General_model->updateRecord('lotes', array('tipo_venta' => $tipoVenta), 'idLote', $idLote);
			echo json_encode(array("status"=> $response, "tabla" => true));
		}
		else if($accion == 3 && !$this->anyEmpty("Uno o mas valores están vacios",$impuesto, $idSede)){
			$response = $this->General_model->updateRecord('sedes', array('impuesto' => $impuesto), 'id_sede', $idSede);
			echo json_encode(array("status"=> $response, "tabla" => false));
		}
		else if($accion == 4 && !$this->anyEmpty("Por favor llene todos los campos",$nombre, $paterno, $materno)){
			$last_id = $this->Administracion_model->getLastId('opcs_x_cats', array('id_catalogo' => 77), 'id_opcion');
			$data_insert = array(
				'id_opcion' => $last_id + 1,
				'id_catalogo' => 77,
				'nombre' => $nombre. ' '.$paterno.' '.$materno,
				'estatus' => 1,
				'fecha_creacion' => date('Y-m-d H:i:s'), 
				'creado_por' => 1,
				'color' => null
			);
			$response = $this->General_model->addRecord('opcs_x_cats', $data_insert);
			echo json_encode(array("status"=> $response, "reload" => true));
		}
		else if($accion == 5 && !$this->anyEmpty("Por favor llene todos los campos",$estatus, $idRepresentante)) {
			$response = $this->Administracion_model->updateMultiple('opcs_x_cats', array('id_catalogo' => 77, 'id_opcion' => $idRepresentante), array('estatus' => $estatus));
			echo json_encode(array("status" => $response, "reload" => true));
		}
		else if($accion == 7 && !$this->anyEmpty("Por favor llene todos los campos",$idLote, $comentario, $idCliente)) {
			$response = $this->General_model->updateRecord('lotes', array('comentario' => $comentario), 'idLote', $idLote);
			echo json_encode(array("status" => $response, "tabla" => true));
		}
		else if($accion == 8 && !$this->anyEmpty($idLote, $switchCheckbox)) {
			$switchCheckbox = $data['switchCheckbox'] = 'on' ? '9' : '6';
			$response = $this->General_model->updateRecord('lotes', array('idStatusLote' => $switchCheckbox), 'idLote', $idLote);
			echo json_encode(array("status"=>$response, "tabla" => true));
		}
		else if($accion == 9) {
			$result = $this->Administracion_model->getResultados($idLote, $idCliente);
			$idMovimiento = $result[0]['idMovimiento'];
			$idStatus = $result[0]['idStatusContratacion'];
			$idMovimiento2 = $result[1]['idMovimiento'];
			$idStatus2 = $result[1]['idStatusContratacion'];
			$statusContratacion1 = array("7", "6");
			if(($idStatus == 7 || $idStatus == 6) && ($idMovimiento == 77 || $idMovimiento == 76)) {
				$response = $this->General_model->updateRecord('lotes', array('idMovimiento' => $idMovimiento2, 'idStatusContratacion' => $idStatus2), 'idLote', $idLote);
				echo json_encode(array("status" => $response, "tabla" => true));
			}
			else if(($idStatus == 11 || $idStatus == 7 || $idStatus == 8) && ($idMovimiento == 41 || $idMovimiento == 37 || $idMovimiento == 38)) {
				$response = $this->General_model->updateRecord('lotes', array('idMovimiento'=>$idMovimiento2, 'idStatusContratacion'=> $idStatus2,'totalValidado' => '0.00', 'validacionEnganche' => NULL), 'idLote', $idLote);
				echo json_encode(array("status" => $response, "tabla"=>true));
			}
		}
		else if($accion == 10 && !$this->anyEmpty("Por favor seleccione el dato a actualizar.",$idLote, $idTipoVenta)) {
			$response = $this->General_model->updateRecord('lotes', array('tipo_venta' => 0), 'idLote', $idLote);
			echo json_encode(array("status" => $response, "tabla" => true));
		}
		else if($accion == 11 && !$this->anyEmpty("Por favor llene todos los campos",$nacionalidad)) {
			$last_id = $this->Administracion_model->getLastId('opcs_x_cats', array('id_catalogo' => 11), 'id_opcion');
			$data_insert = array(
				'id_opcion'=> $last_id + 1,
				'id_catalogo' => 11,
				'nombre' => $nacionalidad,
				'estatus' => 1,
				'fecha_creacion' => date('Y-m-d H:i:s'),
				'creado_por' => 1, 
				'color'=> null
			);
			$response = $this->General_model->addRecord('opcs_x_cats', $data_insert);
			echo json_encode(array("status" => $response, "reload" => true));
		}
		else if ($accion == 12 && !$this->anyEmpty("Por favor llene todos los campos",$tipoCasa)) {
			$response = $this->General_model->updateRecord('clientes', array('tipo_casa' => $tipoCasa), 'id_cliente', $idCliente);
			echo json_encode(array("status" => $response, "tabla" => true));
		}
		else if($accion == 13 && !$this->anyEmpty($switchCheckbox)) {
			$datos = $this->Administracion_model->getDatosLotes($idLote);
			$responseLote = $this->General_model->updateRecord('lotes', array('idStatusLote'=>2, 'idStatusContratacion'=>15, 'idMovimiento'=>45, 
			'perfil'=>6, 'usuario'=>1, 'comentario'=>'SE REGRESA EXPEDIENTE AL ESTATUS 2'),'idLote', $idLote) ;
			if($responseLote) {
				$response = $this->General_model->addRecord('historial_lotes', array('nombreLote'=>$datos[0]['nombreLote'], 'idStatusContratacion'=>15,
				'idMovimiento'=>45, 'modificado'=>date("Y-m-d H:i:s"), 'fechaVenc'=>date("Y-m-d H:i:s"), 'idLote'=>$idLote, 'idCondominio'=>$datos[0]['idCondominio'],
				'idCliente'=>$idCliente, 'usuario'=>1, 'comentario'=>'SE REGRESA EXPEDIENTE AL ESTATUS 2', 'perfil'=>'8', 'status'=>1, 'folioContrato'=>null));
				echo json_encode(array("status"=>$response, "tabla" =>true));
			}else {
				echo json_encode(array("status"=>false));
			}
		}
		else if($accion == 14 && !$this->anyEmpty("Por favor llene todos los campos",$comentario)){
			//$responseLotes = $this->General_model->updateRecord('lotes', array('idStatusContratacion'=>$idStatus, 'idMovimiento'=>$idMovimiento), 'idLote', $idLote);
			
			$idStatus = 0;
			$idMovimiento = 0;
			//echo var_dump($data);
			if($data['statusLote'] == '') {
				echo json_encode(array("empty" =>true));
			}else {

			}
			//if($data['statusLote'] == "0") {
				//return json_encode(array("empty" =>true));
			//}
			/*if($data['statusLote'] == "2") {
				$idStatus = 1;
				$idMovimiento = 73;
			}
			else if($data['statusLote' == "5"]) {
				$idStatus = 2;
				$idMovimiento = 74;
			}*/
			/*
			$datos = $this->Administracion_model->getDatosLotes($idLote);
			$insertData = array(
				'nombreLote' => $datos[0]['nombreLote'],
				'idStatusContratacion' => $idStatus,
				'idMovimiento' => $idMovimiento,
				'modificado' => date('Y-m-d H:i:s'),
				'fechaVenc' => date('Y-m-d H:i:s'),
				'idLote' => $datos[0]['idLote'],
				'idCondominio'=>$datos[0]['idCondominio'],
				'idCliente' => $datos[0]['idCliente'],
				'usuario' =>$this->session->userdata('id_usuario'),
				'comentario' =>$data['comentario'],
				'perfil'=> $this->session->userdata('id_rol'),
				'status' => 1,
				'folioContrato'=> null
			);*/
			
			//$responseHistorial = $this->General_model->addRecord('historial_lotes', $insertData);
			/*
			if($responseLotes == true && $responseHistorial == true) {
				echo json_encode(array("status"=> true, "tabla"=>true));
			}*/

		}
		else if($accion == 15) {
		$estatus = $_POST['tipoPago'];
		$dataFile = $_POST['data'];
		$insertArrayData = array();
		$updateArrayData = array();
		try {
			$decodeData = JWT::decode($dataFile, 'thisismysecretkeytest', array('HS256'));
			$decodedData = json_decode($decodeData);
			if(count($decodedData) >  0) {
				$id_pago_i = array();
				$verifiedData = array();
				for($i = 0; $i < count($decodedData); $i++) {
					if(isset($decodedData[$i]->ID_PAGO) && !empty($decodedData[$i]->ID_PAGO)) {
						$id_pago_i[$i] = (int)$decodedData[$i]->ID_PAGO;
					}else {
						unset($decodedData[$i]);
						$decodedData = array_values($decodedData);
					}
				}
				for($i = 0; $i < count( $decodedData); $i++) {
					$dataUpdate = array();
					$dataInsert = array();

					if(count($decodedData) > 0) {

					}

					if (count($decodedData) > 0) {
						$dataUpdate += array("id_pago_i" => (int)$decodedData[$i]->ID_PAGO,
							"estatus" => (int)$estatus,
							"modificado_por" => (int) 1
						);
						array_push($updateArrayData, $dataUpdate);
				
						$dataInsert += array("id_pago_i" => (int)$decodedData[$i]->ID_PAGO,
							'id_usuario'=>(int)$this->session->userdata('id_usuario'),
							'fecha_movimiento' => date("Y-m-d H:i:s"), 
							'estatus' => (int) 1,
							'comentario' => (string) 'CONTRALORÍA ENVÍO PAGO A INTERNOMEX'
						);
						array_push($insertArrayData, $dataInsert);
					}
				}
				if(count($insertArrayData) > 0 && count($updateArrayData) > 0) {
					$updateResponse = $this->General_model->updateBatch("pago_comision_ind", $updateArrayData, "id_pago_i");
					$insertResponse = $this->General_model->insertBatch("historial_comisiones", $insertArrayData);

					if($updateResponse && $insertResponse) {
						echo json_encode(array("status" => true, "reload"=>true));
					}
				}
			}
		} catch(Exception $e) {
			echo 'Error: '.$e->getMessage();
		}
		}
		/*else {
			echo json_encode(array("status" => false));
		}*/
	}
	public function getCatalogoMaster() {
		$data = $this->Administracion_model->getCatalogoMaster()->result_array();
		if($data != null) {
			echo json_encode($data);
		}else {
			json_encode(array());
		}
	}	
}




