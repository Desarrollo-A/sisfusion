<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
class Administracion extends CI_Controller{
	public function __construct()
	{ 
		parent::__construct();
		$this->load->model('Administracion_model');
		$this->load->model('registrolote_modelo');

		$this->load->library(array('session', 'form_validation'));
		$this->load->model('asesor/Asesor_model'); //EN ESTE MODELO SE ENCUENTRAN LAS CONSULTAS DEL MENU
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
		    '76', '77' , '78', '79' , '80', '81' , '82', '83' , '84'))) {
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
}




