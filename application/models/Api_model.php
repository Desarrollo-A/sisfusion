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
        return $this->db->query("SELECT us.id_rol, us.id_sede, us.id_lider id_coordinador, us.gerente_id 
        id_gerente, us.subdirector_id id_subdirector, us.regional_id id_regional 
        FROM usuarios us WHERE us.id_usuario = $id_asesor")->row();
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
        if ($this->db->affected_rows() >= 0)
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
            WHERE u.usuario = '$username' AND u.contrasena = '$new_pass' AND u.estatus in (0,1,3)");
            return $query->result_array();
	}

    function getClientsInformation()
    {
        return $this->db->query("SELECT * FROM sisfusion_pruebas.dbo.lotes LCRM 
        INNER JOIN sisfusion_pruebas.dbo.clientes as CLCRM ON LCRM.idLote = CLCRM.idLote AND CLCRM.status = 1
        INNER JOIN sisfusion_pruebas.dbo.tipo_venta TVCRM ON TVCRM.id_tventa = LCRM.tipo_venta
        INNER JOIN sisfusion_pruebas.dbo.statusLote SLCRM ON SLCRM.idStatusLote = LCRM.idStatusLote
        INNER JOIN sisfusion_pruebas.dbo.usuarios ACRM ON ACRM.id_usuario = CLCRM.id_asesor AND ACRM.estatus = 1
        LEFT JOIN sisfusion_pruebas.dbo.usuarios COORDCRM ON COORDCRM.id_usuario = CLCRM.id_coordinador AND COORDCRM.estatus = 1
        LEFT JOIN sisfusion_pruebas.dbo.usuarios GERCRM ON GERCRM.id_usuario = CLCRM.id_gerente AND GERCRM.estatus = 1
        INNER JOIN sisfusion_pruebas.dbo.sedes AS SEDECRMAS ON CAST(SEDECRMAS.id_sede AS VARCHAR(45)) = CAST(ACRM.id_sede AS VARCHAR(45))
        INNER JOIN sisfusion_pruebas.dbo.condominios CCRM ON CCRM.idCondominio = LCRM.idCondominio
        INNER JOIN sisfusion_pruebas.dbo.residenciales RCRM ON RCRM.idResidencial = CCRM.idResidencial
        WHERE LCRM.idStatusContratacion >= 15 AND LCRM.status = 1")->result_array();
    }

    function getInformationOfficesAndResidences(){
        $query["sedes"] = $this->db->query("SELECT id_sede, nombre, abreviacion FROM sedes WHERE estatus = 1")->result_array();
        $query["residenciales"] = $this->db->query("SELECT idResidencial as id_residencial, descripcion AS nombre, nombreResidencial AS abreviacion FROM residenciales WHERE status = 1")->result_array();
        return $query;
    }

    public function getAsesoresList($fecha) {
        $validacionFecha = $fecha != '' ? "AND u0.fecha_creacion >= '$fecha 00:00:00.000'" : "";
        return $this->db->query("SELECT u0.id_usuario, u0.usuario, u0.fecha_creacion, oxc0.nombre estatusAsesor,
        UPPER(CONCAT(u0.nombre, ' ', u0.apellido_paterno, ' ', u0.apellido_materno)) nombreAsesor
        FROM usuarios u0
        INNER JOIN opcs_x_cats oxc0 ON oxc0.id_opcion = u0.estatus AND oxc0.id_catalogo = 3
        WHERE u0.id_rol = 7 $validacionFecha")->result_array(); 
    }

}
