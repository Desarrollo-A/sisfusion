<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by JetBrains PhpStorm.
 * User: isra
 * Date: 19/01/13
 * Time: 18:51
 * To change this template use File | Settings | File Templates.
 */
class Login extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('login/login_model');
		$this->load->model('Usuarios_modelo');
		$this->load->model('Chat_modelo');
		$this->load->library(array('session','form_validation'));
		$this->load->helper(array('url','form'));
		$this->load->database('default');
//        $this->load->helper('language'); // cargo la libreria language
//        $this->lang->load('generales'); // cargo los archivos del lenguaje
	}

	public function index()
	{

     switch ($this->session->userdata('id_rol')) {
		case '':
			$data['token'] = $this->token();
			$data['titulo'] = 'Login con roles de usuario en codeigniter';
			$this->load->view('login/login_view',$data);
			//  $this->load->view('login/maintenance',$data);
			// $this->load->view('errors/404not-found');
			break;
		case '1': // DIRECTOR
		case '2': // SUBDIRECTOR
		case '3': // GERENTE
		case '4': // ASISTENTE DIRECCIÓN
		case '5': // ASISTENTE SUBDIRECCIÓN
		case '6': // ASISTENTE GERENCIA
		case '7': // ASESOR
		case '9': // COORDINADOR
		case '18': // DIRECTOR MKTD
		case '63': // CI AUDITORIA
			redirect(base_url().'Ventas');
        break;

		case '11': // ADMINISTRACIÓN
		case '12': // CAJA
		case '23': // SUBDIRECTOR CLUB MADERAS
		case '34': // FACTURACIÓN
		case '35': // ATENCIÓN A CLIENTES
		case '26': // MERCADÓLOGO
		case '41': // GENERALISTA
		case '39': // CONTABILIDAD
		case '31': // INTERNOMEX
		case '49': // CAPITAL HUMANO
		case '50': // GENERALISTA MKTD
		case '40': // COBRANZA
		case '54': // SUBDIRECCIÓN CONSULTA
		case '58': // ANALISTA DE DATOS CI
		case '8': // SOPORTE
		case '10': // EJECTUTIVO ADMINISTRATIVO MKTD
		case '19': // SUBDIRECTOR MKTD
		case '20': // GERENTE MKTD
		case '21': // CLIENTE
		case '23': // SUBDIRECTOR CLUB MADERAS
		case '28': // EJECUTIVO ADMINISTRATIVO
		case '33': // CONSULTA
		case '25': // MKTD
		case '27': // MKTD
		case '30': // MKTD
		case '36': // MKTD
		case '22': // MKTD
		case '53': // ANALISTA COMISIONES
		case '61': // ANSESOR CONSULTA
		case '64': // ASISTENTE DIRECCIÓN ADMINISTRACIÓN
		case '65': // CONTABILIDAD (EXTERNO)
		case '66': // OPERATIVO
		case '67': // LEXINTEL
		case '68': // DIRECTOR SUMA
		case '69': // DIRECTOR GENERAL
            redirect(base_url().'Administracion');
        break;

        case '12':
            redirect(base_url().'Caja');
        break;

		case '13': // CONTRALORÍA
		case '17': // SUBDIRECTOR CONTRALORÍA
		case '32': // CONTRALORÍA CORPORATIVA
		case '47': // SUBDIRECCIÓN FINANZAS
         	redirect(base_url().'Contraloria');
        break;

        case '14':
            redirect(base_url().'Direccion_administracion');
        break;

        case '15':
            redirect(base_url().'Juridico');
        break;

        case '16':
            redirect(base_url().'Contratacion');
        break;

        case '31':
            redirect(base_url().'Internomex');
        break;
		case '55': // POSTVENTA
		case '56': // COMITÉ TÉCNICO
		case '57': // TITULACIÓN
		case '62': //PROYECTOS
			redirect(base_url() . 'Postventa');
		break;
        default:
            $data['titulo'] = 'Login con roles de usuario en codeigniter';
    	    $this->load->view('login/login_view',$data);
            //  $this->load->view('login/maintenance',$data);
        break;
     }
}

	public function token()
	{
		$token = md5(uniqid(rand(),true));
		$this->session->set_userdata('token',$token);
		return $token;
	}


	public function new_user()
	{

		if($this->input->post('token') && $this->input->post('token') == $this->session->userdata('token'))
		{
			$this->form_validation->set_rules('username', 'nombre de usuario', 'required|trim|min_length[2]|max_length[150]|xss_clean');
			$this->form_validation->set_rules('password', 'password', 'required|trim|min_length[5]|max_length[150]|xss_clean');
			$this->form_validation->set_message('required', 'El %s es requerido');
			$this->form_validation->set_message('max_length', 'El %s debe tener al menos %s carácteres');

				$usuario = $this->input->post('usuario');
				$contrasena = $this->input->post('contrasena');
				$nombre = $this->input->post('nombre');
				$apellido_paterno = $this->input->post('apellido_paterno');
				$apellido_materno = $this->input->post('apellido_materno');
				$id_sede = $this->input->post('id_sede');
				$id_rol = $this->input->post('id_rol');
				$id_usuario = $this->input->post('id_usuario');
				$imagen_perfil = $this->input->post('imagen_perfil');
				// $idAsesor = $this->input->post('idAsesor');

				$check_user = $this->login_model->login_user($usuario,$contrasena);
				if(empty($check_user))
				{
					$this->session->set_userdata('errorLogin', 33);
					redirect(base_url());
				}
				else{
					if($check_user[0]->id_lider != 0)
					{
						$dataGr = $this->login_model->checkGerente($check_user[0]->id_lider);
						if(empty($dataGr))
						{
							$idGerente = "";
							$nombreGerente = "";
						}
						else{
							$idGerente = $dataGr[0]->id_usuario;
							$nombreGerente = $dataGr[0]->nombre." ".$dataGr[0]->apellido_paterno." ".$dataGr[0]->apellido_materno;
						}
					}
					else{
						$idGerente	= "";
						$nombreGerente	= "";
					}
					if($check_user[0]->id_rol != 0)
					{
						$dataRol = $this->login_model->getRolByUser($check_user[0]->id_rol);
						if($dataRol[0]->nombre=="Asistente gerente")
						{
							$perfil = ($dataRol[0]->nombre=="Asistente gerente") ? "asistentesGerentes" : $dataRol[0]->nombre;
						}
						elseif($dataRol[0]->nombre=="Contraloría corporativa")
                        {
                            $perfil = ($dataRol[0]->nombre=="Contraloría corporativa") ? "contraloriaCorporativa" : $dataRol[0]->nombre;
                        }
                        elseif($dataRol[0]->nombre=="Subdirector contraloría")
                        {
                            $perfil = ($dataRol[0]->nombre=="Subdirector contraloría") ? "subdirectorContraloria" : $dataRol[0]->nombre;
                        }
                        elseif ($dataRol[0]->nombre=="Caja")
                        {
                            $perfil = ($dataRol[0]->nombre=="Caja") ? "caja" : $dataRol[0]->nombre;
                        }
						elseif ($dataRol[0]->nombre=="Jurídico")
						{
							$perfil = ($dataRol[0]->nombre=="Jurídico") ? "juridico" : $dataRol[0]->nombre;
						}
						elseif ($dataRol[0]->nombre=="Contraloría")
						{
							$perfil = ($dataRol[0]->nombre=="Contraloría") ? "contraloria" : $dataRol[0]->nombre;
						}
						elseif ($dataRol[0]->nombre=="Administración")
						{
							$perfil = ($dataRol[0]->nombre=="Administración") ? "administracion" : $dataRol[0]->nombre;
						}
						elseif ($dataRol[0]->nombre=="Facturación")
						{
							$perfil = ($dataRol[0]->nombre=="Facturación") ? "facturacion" : $dataRol[0]->nombre;
						}
						elseif ($dataRol[0]->nombre=="Asesor")
						{
							$perfil = ($dataRol[0]->nombre=="Asesor") ? "asesor" : $dataRol[0]->nombre;
						}
						elseif ($dataRol[0]->nombre=="Asesor de contenido RRSS")
						{
							$perfil = ($dataRol[0]->nombre=="Asesor de contenido RRSS") ? "AsesorContenidoRRSS" : $dataRol[0]->nombre;
						}
						elseif ($dataRol[0]->nombre=="Ejecutivo Administrativo")
						{
							$perfil = ($dataRol[0]->nombre=="Ejecutivo Administrativo") ? "ejecutivoAdministrativo" : $dataRol[0]->nombre;
						}
						elseif ($dataRol[0]->nombre=="Dirección finanzas")
						{
							$perfil = ($dataRol[0]->nombre=="Dirección finanzas") ? "direccionFinanzas" : $dataRol[0]->nombre;
						}
						elseif ($dataRol[0]->nombre=="Contabilidad")
						{
							$perfil = ($dataRol[0]->nombre=="Contabilidad") ? "contabilidad" : $dataRol[0]->nombre;
						}
						elseif ($dataRol[0]->nombre=="Internomex")
						{
							$perfil = ($dataRol[0]->nombre=="Internomex") ? "internomex" : $dataRol[0]->nombre;
						}
						elseif ($dataRol[0]->nombre=="Cobranza")
						{
							$perfil = ($dataRol[0]->nombre=="Cobranza") ? "cobranza" : $dataRol[0]->nombre;
						}
						elseif ($dataRol[0]->nombre=="Analista de comisiones")
						{
							$perfil = ($dataRol[0]->nombre=="Analista de comisiones") ? "analistaComisiones" : $dataRol[0]->nombre;
						}
						elseif ($dataRol[0]->nombre=="Subdirección consulta")
						{
							$perfil = ($dataRol[0]->nombre=="Subdirección consulta") ? "subdireccionConsulta" : $dataRol[0]->nombre;
						}
						elseif ($dataRol[0]->nombre=="Director SUMA")
						{
							$perfil = ($dataRol[0]->nombre=="Director SUMA") ? "directorSUMA" : $dataRol[0]->nombre;
						}

					}
					/*get ubicacion*/
					$dataUbicacion = $this->login_model->getLocation($check_user[0]->id_sede);


					if($check_user == TRUE)
					{
						echo '
						<script>
						document.write(localStorage.setItem("id_usuario", "'.$check_user[0]->id_usuario.'"));
						document.write(localStorage.setItem("id_sede", "'.$check_user[0]->id_sede.'"));
						document.write(localStorage.setItem("id_rol", "'.$check_user[0]->id_rol.'"));
						document.write(localStorage.setItem("nombreUsuario", "'.$check_user[0]->nombre.' '.$check_user[0]->apellido_paterno.' '.$check_user[0]->apellido_materno.'"));
						</script>';
						

						$data = array(
							'is_logued_in' 	        => 		TRUE,
							'id_usuario' 	        => 		$check_user[0]->id_usuario,
							'estatus'               =>      $check_user[0]->estatus,
							'nombre' 		        => 		$check_user[0]->nombre,
							'apellido_paterno' 		=> 		$check_user[0]->apellido_paterno,
							'apellido_materno' 		=> 		$check_user[0]->apellido_materno,
							'id_sede' 		        => 		$check_user[0]->id_sede,
							'id_rol' 		        => 		$check_user[0]->id_rol,
							'id_lider' 		        => 		$check_user[0]->id_lider,
							'usuario' 		        => 		$check_user[0]->usuario,
							'perfil' 		        => 		$perfil,
							'id_lider_2' 		    => 		$check_user[0]->id_lider_2,
							'id_lider_3' 		    => 		$check_user[0]->id_lider_3,
							'id_lider_4' 		    => 		$check_user[0]->id_lider_4,
							'id_lider_5' 		    => 		$check_user[0]->id_lider_5,
							'id_regional_2' 		=> 		$check_user[0]->id_regional_2,
							'imagen_perfil' 		=> 		$check_user[0]->imagen_perfil,
							'jerarquia_user' 		=> 		$check_user[0]->jerarquia_user,
							'ubicacion'			    =>	    $dataUbicacion[0]->abreviacion,
							'idGerente'		        =>	    $idGerente,
							'nombreGerente'	        =>	    $nombreGerente,
							'forma_pago'	        =>	    $check_user[0]->forma_pago,
						);
						$this->session->set_userdata($data);
						$this->index();
					}
				}
		}
		else{
			redirect(base_url().'login');
		}
	}
	public function logout_ci()
	{
		if ($this->session->userdata('id_rol') == 7 || $this->session->userdata('id_rol') == 19 || $this->session->userdata('id_rol') == 20) {
			$datos = ['estatus' => 3,
					'chat_activos' => 0,
					'bloqueado' => 0];
			$estado2 = ['estatus' => 0];
			$estado3 = ['visto' => 1,'recibido' => 0];
	// 		$this->Chat_modelo->CambioSesion($datos,$this->session->userdata('id_usuario'));
	// 		$response = $this->Chat_modelo->FinalizarSesionChat($estado2,$this->session->userdata('id_usuario'));
    //   $response = $this->Chat_modelo->FinalizarSesionMsj($estado3,$this->session->userdata('id_usuario'));	
			$this->session->sess_destroy();
			//		$this->index();
					redirect(base_url());	
		}else{
			$this->session->sess_destroy();
//		$this->index();
			echo '<script>localStorage.clear()</script>';
		redirect(base_url());
		}
	}

	
	public function noShowModalSession()
    {
        $this->session->set_userdata('no_show_modal_info', 1);
    }

    public function getAES128(){
        $password = $this->input->post('contrasena');
        $passwordEnc = encriptar($password);
        $check_user['AES128'] = $passwordEnc;

        if ($check_user != null) {
            echo json_encode($check_user);
        } else {
            echo json_encode(array());
        }
    }

}
