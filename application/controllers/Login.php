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
		$this->load->library(array('session','form_validation','get_menu'));
		$this->load->helper(array('url','form'));
		$this->load->database('default');
        $val =  $this->session->userdata('certificado'). $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        $_SESSION['rutaController'] = str_replace('' . base_url() . '', '', $val);
    }
		
	public function index()
	{

		if($this->session->userdata('id_rol') == ''){
			$data['token'] = $this->token();
			$data['titulo'] = 'Login con roles de usuario en codeigniter';
			$this->load->view('login/login_view',$data);
		}else{
			if($this->session->userdata('controlador') == ''){
				$data['token'] = $this->token();
				$data['titulo'] = 'Login con roles de usuario en codeigniter';
				$this->load->view('login/login_view',$data);
			}else{
				redirect(base_url().$this->session->userdata('controlador'));
			}
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
						elseif ($dataRol[0]->nombre=="Asesor OOAM")
						{
							$perfil = ($dataRol[0]->nombre=="Asesor OOAM") ? "asesorOOAM" : $dataRol[0]->nombre;
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
							'controlador'			=>		$check_user[0]->controlador,
							'tipo'       			=>		$check_user[0]->tipo
						);
						session_start();
						$_SESSION['rutaController'] = '';
						$_SESSION['datos4'] = [];
						$data['certificado'] = $_SERVER["HTTP_HOST"] == 'localhost' ? 'http://' : 'https://';
						$id_rol = $check_user[0]->tipo == 2 ? 86 :( in_array($check_user[0]->id_usuario,array(13400,13399,13398,13397,13395)) ? 7 : $check_user[0]->id_rol);
						$datos = $this->get_menu->get_menu_data($id_rol,$check_user[0]->id_usuario,$check_user[0]->estatus);
						$opcionesMenu = $this->get_menu->get_menu_opciones();
						$_SESSION['rutaActual'] = $_SERVER["HTTP_HOST"] == 'prueba.gphsis.com' || $_SERVER["HTTP_HOST"] == 'localhost' ? '/sisfusion/' : '/';
						$data['datos'] = $datos;
						$data['opcionesMenu'] = array_column($opcionesMenu, 'pagina');
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
