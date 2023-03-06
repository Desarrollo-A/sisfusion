<?php 
    if (!defined('BASEPATH')) exit('No direct script access allowed');
    require_once './dist/js/jwt/JWT.php';

    use Firebase\JWT\JWT;
    use controllers\Api_model;
    class JwtAuth
    {  
        public function signup($usu, $pws, $getToken = null)
        {
            $CI = get_instance();
            $CI->load->model('Api_model');
            //Buscar si existe el usuario con sus credenciales
            $usuario = $CI->Api_model->login_user($usu, $pws);
            //comprobar si son correctas(array)
            $singup = false;
            if(!empty($usuario)){
                $singup = true;
            }
            //Generar el token con los datos del usuario identificado
            if($singup){
                $usuario = (Object) $usuario[0];
                $token = array(
                    'usuario'           =>      $usuario->usuario,
                    'id_usuario'        =>      $usuario->id_usuario,
                    'nom_usuario'       =>      $usuario->nombre.' '.$usuario->apellido_paterno.' '.$usuario->apellido_materno,
                    'email'             =>      $usuario->correo,
                    'iat'               =>      time(),
                    'exp'               =>      time()+(24*60*60)
                );
                $CI->load->library('jwt_key');
                $key = $CI->jwt_key->getSecretKey();
                $jwt_enc = JWT::encode($token, $key, 'HS256'/*Este parametro no es necesario ya que lo tiene poir defeult en la libreria*/ );
                $jwt_dec = JWT::decode($jwt_enc, $key, ['HS256']);
                //Devolver los datos decodificados o el token en funcion a un parametro
                if(is_null($getToken)){
                    $data = $jwt_enc;
                }else{
                    $data = $jwt_dec;
                }
            }else{
                $data = array(
                    'status'    =>      'error',
                    'msg'       =>      'Login incorrecto, verificar Usuario y/o contraseña');
            }
            return $data;
        }
        
    }
    
    
    
    
    

?>