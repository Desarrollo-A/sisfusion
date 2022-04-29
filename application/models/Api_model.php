<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 */
class Api_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function verifyUser($username, $password)
    {
        $query = $this->db->query("SELECT * FROM external_users WHERE usuario = '$username' AND contrasena = '$password' AND estatus = 1");
        if($query->num_rows() > 0)
            return $query->row();
        else
            return false;
    }

    function getAdviserLeaderInformation($id_asesor)
    {
        return $this->db->query("SELECT u.id_sede, u.id_lider id_coordinador, uu.id_lider id_gerente FROM usuarios u 
        INNER JOIN usuarios uu ON uu.id_usuario = u.id_lider WHERE u.id_usuario = $id_asesor")->row();
    }

    function generateFilename($idLote, $idDocumento)
    {
        return $this->db->query("SELECT CONCAT(r.nombreResidencial, '_', SUBSTRING(cn.nombre, 1, 4), '_', l.idLote, 
        '_', c.id_cliente,'_TDOC', hd.tipo_doc, SUBSTRING(hd.movimiento, 1, 4),
        '_', UPPER(REPLACE(REPLACE(CONVERT(varchar, GETDATE(),109), ' ', ''), ':', ''))) fileName FROM lotes l 
        INNER JOIN clientes c ON c.idLote = l.idLote
        INNER JOIN condominios cn ON cn.idCondominio = l.idCondominio
        INNER JOIN residenciales r ON r.idResidencial = cn.idResidencial
        INNER JOIN historial_documento hd ON hd.idLote = l.idLote AND hd. idDocumento = $idDocumento
        WHERE l.idLote = $idLote");
    }

    function updateDocumentBranch($updateDocumentData, $idDocumento)
    {
        $response = $this->db->update("historial_documento", $updateDocumentData, "idDocumento = $idDocumento");
        if (!$response) {
            return 0;
        } else {
            return 1;
        }
    }

    function updateUserContratacion($datos, $id_usuario)
    {
         $this->db->update("usuarios", $datos, "id_usuario = $id_usuario");
        if ($this->db->affected_rows() > 0)
        {
          return 1;
        }
        else
        {
          return 0;
        }
    }


    public function login_user($username,$password)
	{
		$new_pass = encriptar($password);
 
			$query = $this->db->query("SELECT u.id_usuario, u.id_lider, u.estatus,(CASE u.id_lider WHEN 832 THEN 832 ELSE us.id_lider END) id_lider_2, ge.id_usuario id_lider_3, sb.id_usuario id_lider_4, u.id_rol, u.id_sede, u.nombre, u.apellido_paterno, u.apellido_materno,
            u.correo, u.usuario, u.contrasena, u.telefono, u.tiene_hijos, u.estatus, u.sesion_activa, u.imagen_perfil, u.fecha_creacion, u.creado_por, u.modificado_por, u.forma_pago, u.jerarquia_user
            FROM usuarios u
            LEFT JOIN usuarios us ON us.id_usuario = u.id_lider
            LEFT JOIN usuarios ge ON ge.id_usuario = us.id_lider
            LEFT JOIN usuarios sb ON sb.id_usuario = ge.id_lider
            WHERE u.usuario = '$username' AND u.contrasena = '$new_pass' AND u.estatus in (1,3)");
            return $query->result_array();
	}

}
