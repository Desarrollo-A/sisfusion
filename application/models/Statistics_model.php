<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 */
class Statistics_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

    function getProspectsNumber(){
        switch ($this->session->userdata('id_rol')) {
            case '2': // SUBDIRECTOR
            case '5': // ASISTENTE SUBDIRECTOR
                return $this->db->query("SELECT COUNT (p.id_prospecto) prospects_number FROM prospectos p WHERE p.id_sede IN (".$this->session->userdata('id_sede').") AND p.tipo = 0");
            break;
            case '3': // GERENTE
                return $this->db->query("SELECT COUNT (p.id_prospecto) prospects_number FROM prospectos p WHERE p.tipo = 0 AND (p.id_gerente = ".$this->session->userdata('id_usuario')." OR p.id_coordinador = ".$this->session->userdata('id_usuario')." OR p.id_asesor = ".$this->session->userdata('id_usuario').")");
            break;
            case '6': // ASISTENTE GERENTE
                return $this->db->query("SELECT COUNT (p.id_prospecto) prospects_number FROM prospectos p WHERE p.id_gerente = ".$this->session->userdata('id_lider')." AND p.tipo = 0");
            break;
            case '9': // COORDINADOR
                return $this->db->query("SELECT COUNT (p.id_prospecto) prospects_number FROM prospectos p WHERE (p.id_asesor = ".$this->session->userdata('id_usuario')." OR id_coordinador = ".$this->session->userdata('id_usuario').") AND p.tipo = 0");
            break;
            case '7': // ASESOR
                return $this->db->query("SELECT COUNT (p.id_prospecto) prospects_number FROM prospectos p WHERE (p.id_asesor = ".$this->session->userdata('id_usuario')." OR id_coordinador = ".$this->session->userdata('id_usuario').") AND p.tipo = 0");
            break;
            case '1': // DIRECTOR
            case '4': // ASISTENTE DIRECTOR
            default: // VE TODOS LOS REGISTROS
                return $this->db->query("SELECT COUNT (p.id_prospecto) prospects_number FROM prospectos p WHERE p.tipo = 0");
            break;
        }
    }

    function getCurrentProspectsNumber(){
        switch ($this->session->userdata('id_rol')) {
            case '2': // SUBDIRECTOR
            case '5': // ASISTENTE SUBDIRECTOR
                return $this->db->query("SELECT COUNT (p.id_prospecto) prospects_number FROM prospectos p WHERE p.id_sede IN (".$this->session->userdata('id_sede').") AND p.tipo = 0 AND p.estatus = 1");
            break;
            case '3': // GERENTE
                return $this->db->query("SELECT COUNT (p.id_prospecto) prospects_number FROM prospectos p WHERE p.tipo = 0 AND p.estatus = 1 AND (p.id_gerente = ".$this->session->userdata('id_usuario')." OR p.id_coordinador = ".$this->session->userdata('id_usuario')." OR p.id_asesor = ".$this->session->userdata('id_usuario').")");
            break;
            case '6': // ASISTENTE GERENTE
                return $this->db->query("SELECT COUNT (p.id_prospecto) prospects_number FROM prospectos p WHERE p.id_gerente = ".$this->session->userdata('id_lider')." AND p.tipo = 0 AND p.estatus = 1");
            break;
            case '9': // COORDINADOR
                return $this->db->query("SELECT COUNT (p.id_prospecto) prospects_number FROM prospectos p WHERE (p.id_asesor = ".$this->session->userdata('id_usuario')." OR id_coordinador = ".$this->session->userdata('id_usuario').") AND p.tipo = 0 AND p.estatus = 1");
            break;
            case '7': // ASESOR
                return $this->db->query("SELECT COUNT (p.id_prospecto) prospects_number FROM prospectos p WHERE (p.id_asesor = ".$this->session->userdata('id_usuario')." OR id_coordinador = ".$this->session->userdata('id_usuario').") AND p.tipo = 0 AND p.estatus = 1");
            break;
            case '1': // DIRECTOR
            case '4': // ASISTENTE DIRECTOR
            default: // VE TODOS LOS REGISTROS
                return $this->db->query("SELECT COUNT (p.id_prospecto) prospects_number FROM prospectos p WHERE p.tipo = 0 AND p.estatus = 1");
            break;
        }
    }

    function getNonCurrentProspectsNumber(){
        switch ($this->session->userdata('id_rol')) {
            case '2': // SUBDIRECTOR
            case '5': // ASISTENTE SUBDIRECTOR
                return $this->db->query("SELECT COUNT (p.id_prospecto) prospects_number FROM prospectos p WHERE p.id_sede IN (".$this->session->userdata('id_sede').") AND p.tipo = 0 AND p.estatus = 0");
            break;
            case '3': // GERENTE
                return $this->db->query("SELECT COUNT (p.id_prospecto) prospects_number FROM prospectos p WHERE p.tipo = 0 AND p.estatus = 0 AND (p.id_gerente = ".$this->session->userdata('id_usuario')." OR p.id_coordinador = ".$this->session->userdata('id_usuario')." OR p.id_asesor = ".$this->session->userdata('id_usuario').")");
            break;
            case '6': // ASISTENTE GERENTE
                return $this->db->query("SELECT COUNT (p.id_prospecto) prospects_number FROM prospectos p WHERE p.id_gerente = ".$this->session->userdata('id_lider')." AND p.tipo = 0 AND p.estatus = 0");
            break;
            case '9': // COORDINADOR
                return $this->db->query("SELECT COUNT (p.id_prospecto) prospects_number FROM prospectos p WHERE (p.id_asesor = ".$this->session->userdata('id_usuario')." OR id_coordinador = ".$this->session->userdata('id_usuario').") AND p.tipo = 0 AND p.estatus = 0");
            break;
            case '7': // ASESOR
                return $this->db->query("SELECT COUNT (p.id_prospecto) prospects_number FROM prospectos p WHERE (p.id_asesor = ".$this->session->userdata('id_usuario')." OR id_coordinador = ".$this->session->userdata('id_usuario').") AND p.tipo = 0 AND p.estatus = 0");
            break;
            case '1': // DIRECTOR
            case '4': // ASISTENTE DIRECTOR
            default: // VE TODOS LOS REGISTROS
                return $this->db->query("SELECT COUNT (p.id_prospecto) prospects_number FROM prospectos p WHERE p.tipo = 0 AND p.estatus = 0");
            break;
        }
    }

    function getClientsNumber(){
        switch ($this->session->userdata('id_rol')) {
            case '2': // SUBDIRECTOR
            case '5': // ASISTENTE SUBDIRECTOR
                return $this->db->query("SELECT COUNT (c.id_cliente) clients_number FROM clientes c 
                                        INNER JOIN lotes l ON l.idCliente = c.id_cliente WHERE l.ubicacion IN (".$this->session->userdata('id_sede').")
                                        AND c.status = 1");
            break;
            case '3': // GERENTE
                return $this->db->query("SELECT COUNT (c.id_cliente) clients_number FROM clientes c WHERE c.id_gerente = ".$this->session->userdata('id_usuario')." 
                                        AND c.status = 1");
            break;
            case '6': // ASISTENTE GERENTE
                return $this->db->query("SELECT COUNT (c.id_cliente) clients_number FROM clientes c WHERE c.id_gerente = ".$this->session->userdata('id_lider')." 
                                        AND c.status = 1");
            break;
            case '7': // ASESOR
            case '9': // COORDINADOR
                return $this->db->query("SELECT COUNT (c.id_cliente) clients_number FROM clientes c WHERE c.id_asesor = ".$this->session->userdata('id_usuario')." 
                                        AND c.status = 1");
            break;
            case '1': // DIRECTOR
            case '4': // ASISTENTE DIRECTOR
            default: // VE TODOS LOS REGISTROS
                return $this->db->query("SELECT COUNT (c.id_cliente) clients_number FROM clientes c WHERE c.status = 1");
            break;
        }
    }

    function getMonthlyProspects(){
        $currentYear = date("Y");
        switch ($this->session->userdata('id_rol')) {
            case '2': // SUBDIRECTOR
            case '5': // ASISTENTE SUBDIRECTOR
                return $this->db->query("SELECT CASE WHEN MONTH(fecha_creacion) = 1 THEN 'Enero' WHEN MONTH(fecha_creacion) = 2 THEN 'Febrero' WHEN MONTH(fecha_creacion) = 3 THEN 'Marzo'
                                        WHEN MONTH(fecha_creacion) = 4 THEN 'Abril' WHEN MONTH(fecha_creacion) = 5 THEN 'Mayo' WHEN MONTH(fecha_creacion) = 6 THEN 'Junio'
                                        WHEN MONTH(fecha_creacion) = 7 THEN 'Julio' WHEN MONTH(fecha_creacion) = 8 THEN 'Agosto' WHEN MONTH(fecha_creacion) = 9 THEN 'Septiembre'
                                        WHEN MONTH(fecha_creacion) = 10 THEN 'Octubre' WHEN MONTH(fecha_creacion) = 11 THEN 'Noviembre' WHEN MONTH(fecha_creacion) = 12 THEN 'Diciembre'
                                        END month_name, COUNT(id_prospecto) prospects_number FROM prospectos 
                                        WHERE tipo = 0 AND id_sede IN(".$this->session->userdata('id_sede').") AND (fecha_creacion BETWEEN '$currentYear/01/01 00:00:00' AND '$currentYear/12/31 23:59:59') 
                                        GROUP BY MONTH(fecha_creacion) ORDER BY MONTH(fecha_creacion)");
            break;
            case '3': // GERENTE
                return $this->db->query("SELECT CASE WHEN MONTH(fecha_creacion) = 1 THEN 'Enero' WHEN MONTH(fecha_creacion) = 2 THEN 'Febrero' WHEN MONTH(fecha_creacion) = 3 THEN 'Marzo'
                                        WHEN MONTH(fecha_creacion) = 4 THEN 'Abril' WHEN MONTH(fecha_creacion) = 5 THEN 'Mayo' WHEN MONTH(fecha_creacion) = 6 THEN 'Junio'
                                        WHEN MONTH(fecha_creacion) = 7 THEN 'Julio' WHEN MONTH(fecha_creacion) = 8 THEN 'Agosto' WHEN MONTH(fecha_creacion) = 9 THEN 'Septiembre'
                                        WHEN MONTH(fecha_creacion) = 10 THEN 'Octubre' WHEN MONTH(fecha_creacion) = 11 THEN 'Noviembre' WHEN MONTH(fecha_creacion) = 12 THEN 'Diciembre'
                                        END month_name, COUNT(id_prospecto) prospects_number FROM prospectos 
                                        WHERE tipo = 0 AND id_gerente = ".$this->session->userdata('id_usuario')." AND (fecha_creacion BETWEEN '$currentYear/01/01 00:00:00' AND '$currentYear/12/31 23:59:59') 
                                        GROUP BY MONTH(fecha_creacion) ORDER BY MONTH(fecha_creacion)");
            break;
            case '6': // ASISTENTE GERENTE
                return $this->db->query("SELECT CASE WHEN MONTH(fecha_creacion) = 1 THEN 'Enero' WHEN MONTH(fecha_creacion) = 2 THEN 'Febrero' WHEN MONTH(fecha_creacion) = 3 THEN 'Marzo'
                                        WHEN MONTH(fecha_creacion) = 4 THEN 'Abril' WHEN MONTH(fecha_creacion) = 5 THEN 'Mayo' WHEN MONTH(fecha_creacion) = 6 THEN 'Junio'
                                        WHEN MONTH(fecha_creacion) = 7 THEN 'Julio' WHEN MONTH(fecha_creacion) = 8 THEN 'Agosto' WHEN MONTH(fecha_creacion) = 9 THEN 'Septiembre'
                                        WHEN MONTH(fecha_creacion) = 10 THEN 'Octubre' WHEN MONTH(fecha_creacion) = 11 THEN 'Noviembre' WHEN MONTH(fecha_creacion) = 12 THEN 'Diciembre'
                                        END month_name, COUNT(id_prospecto) prospects_number FROM prospectos 
                                        WHERE tipo = 0 AND id_gerente = ".$this->session->userdata('id_lider')." AND (fecha_creacion BETWEEN '$currentYear/01/01 00:00:00' AND '$currentYear/12/31 23:59:59') 
                                        GROUP BY MONTH(fecha_creacion) ORDER BY MONTH(fecha_creacion)");
            break;
            case '9': // COORDINADOR
                return $this->db->query("SELECT CASE WHEN MONTH(fecha_creacion) = 1 THEN 'Enero' WHEN MONTH(fecha_creacion) = 2 THEN 'Febrero' WHEN MONTH(fecha_creacion) = 3 THEN 'Marzo'
                                        WHEN MONTH(fecha_creacion) = 4 THEN 'Abril' WHEN MONTH(fecha_creacion) = 5 THEN 'Mayo' WHEN MONTH(fecha_creacion) = 6 THEN 'Junio'
                                        WHEN MONTH(fecha_creacion) = 7 THEN 'Julio' WHEN MONTH(fecha_creacion) = 8 THEN 'Agosto' WHEN MONTH(fecha_creacion) = 9 THEN 'Septiembre'
                                        WHEN MONTH(fecha_creacion) = 10 THEN 'Octubre' WHEN MONTH(fecha_creacion) = 11 THEN 'Noviembre' WHEN MONTH(fecha_creacion) = 12 THEN 'Diciembre'
                                        END month_name, COUNT(id_prospecto) prospects_number FROM prospectos 
                                        WHERE tipo = 0 AND (id_asesor = ".$this->session->userdata('id_usuario')." OR id_coordinador = ".$this->session->userdata('id_usuario').") AND (fecha_creacion BETWEEN '$currentYear/01/01 00:00:00' AND '$currentYear/12/31 23:59:59') 
                                        GROUP BY MONTH(fecha_creacion) ORDER BY MONTH(fecha_creacion)");
            break;
            case '7': // ASESOR
                return $this->db->query("SELECT CASE WHEN MONTH(fecha_creacion) = 1 THEN 'Enero' WHEN MONTH(fecha_creacion) = 2 THEN 'Febrero' WHEN MONTH(fecha_creacion) = 3 THEN 'Marzo'
                                        WHEN MONTH(fecha_creacion) = 4 THEN 'Abril' WHEN MONTH(fecha_creacion) = 5 THEN 'Mayo' WHEN MONTH(fecha_creacion) = 6 THEN 'Junio'
                                        WHEN MONTH(fecha_creacion) = 7 THEN 'Julio' WHEN MONTH(fecha_creacion) = 8 THEN 'Agosto' WHEN MONTH(fecha_creacion) = 9 THEN 'Septiembre'
                                        WHEN MONTH(fecha_creacion) = 10 THEN 'Octubre' WHEN MONTH(fecha_creacion) = 11 THEN 'Noviembre' WHEN MONTH(fecha_creacion) = 12 THEN 'Diciembre'
                                        END month_name, COUNT(id_prospecto) prospects_number FROM prospectos 
                                        WHERE tipo = 0 AND (id_asesor = ".$this->session->userdata('id_usuario')." OR id_coordinador = ".$this->session->userdata('id_usuario').") AND (fecha_creacion BETWEEN '$currentYear/01/01 00:00:00' AND '$currentYear/12/31 23:59:59') 
                                        GROUP BY MONTH(fecha_creacion) ORDER BY MONTH(fecha_creacion)");
            break;
            case '1': // DIRECTOR
            case '4': // ASISTENTE DIRECTOR
            default: // VE TODOS LOS REGISTROS
                return $this->db->query("SELECT CASE WHEN MONTH(fecha_creacion) = 1 THEN 'Enero' WHEN MONTH(fecha_creacion) = 2 THEN 'Febrero' WHEN MONTH(fecha_creacion) = 3 THEN 'Marzo'
                                        WHEN MONTH(fecha_creacion) = 4 THEN 'Abril' WHEN MONTH(fecha_creacion) = 5 THEN 'Mayo' WHEN MONTH(fecha_creacion) = 6 THEN 'Junio'
                                        WHEN MONTH(fecha_creacion) = 7 THEN 'Julio' WHEN MONTH(fecha_creacion) = 8 THEN 'Agosto' WHEN MONTH(fecha_creacion) = 9 THEN 'Septiembre'
                                        WHEN MONTH(fecha_creacion) = 10 THEN 'Octubre' WHEN MONTH(fecha_creacion) = 11 THEN 'Noviembre' WHEN MONTH(fecha_creacion) = 12 THEN 'Diciembre'
                                        END month_name, COUNT(id_prospecto) prospects_number FROM prospectos 
                                        WHERE tipo = 0 AND (fecha_creacion BETWEEN '$currentYear/01/01 00:00:00' AND '$currentYear/12/31 23:59:59') 
                                        GROUP BY MONTH(fecha_creacion) ORDER BY MONTH(fecha_creacion)");
            break;
        }
    }


    function getDataPerSede($id_sede){
        $currentYear = date("Y");
        switch ($id_sede) {
            case '1': // SAN LUIS POTOSÍ
                return $this->db->query("SELECT CASE WHEN MONTH(fecha_creacion) = 1 THEN 'Enero' WHEN MONTH(fecha_creacion) = 2 THEN 'Febrero' WHEN MONTH(fecha_creacion) = 3 THEN 'Marzo'
                                        WHEN MONTH(fecha_creacion) = 4 THEN 'Abril' WHEN MONTH(fecha_creacion) = 5 THEN 'Mayo' WHEN MONTH(fecha_creacion) = 6 THEN 'Junio'
                                        WHEN MONTH(fecha_creacion) = 7 THEN 'Julio' WHEN MONTH(fecha_creacion) = 8 THEN 'Agosto' WHEN MONTH(fecha_creacion) = 9 THEN 'Septiembre'
                                        WHEN MONTH(fecha_creacion) = 10 THEN 'Octubre' WHEN MONTH(fecha_creacion) = 11 THEN 'Noviembre' WHEN MONTH(fecha_creacion) = 12 THEN 'Diciembre'
                                        END month_name, COUNT(id_prospecto) prospects_number FROM prospectos 
                                        WHERE tipo = 0 AND id_sede = $id_sede AND (fecha_creacion BETWEEN '$currentYear/01/01 00:00:00' AND '$currentYear/12/31 23:59:59') 
                                        GROUP BY MONTH(fecha_creacion) ORDER BY MONTH(fecha_creacion)");
            break;
            case '2': // QUERÉTARO
                return $this->db->query("SELECT CASE WHEN MONTH(fecha_creacion) = 1 THEN 'Enero' WHEN MONTH(fecha_creacion) = 2 THEN 'Febrero' WHEN MONTH(fecha_creacion) = 3 THEN 'Marzo'
                                        WHEN MONTH(fecha_creacion) = 4 THEN 'Abril' WHEN MONTH(fecha_creacion) = 5 THEN 'Mayo' WHEN MONTH(fecha_creacion) = 6 THEN 'Junio'
                                        WHEN MONTH(fecha_creacion) = 7 THEN 'Julio' WHEN MONTH(fecha_creacion) = 8 THEN 'Agosto' WHEN MONTH(fecha_creacion) = 9 THEN 'Septiembre'
                                        WHEN MONTH(fecha_creacion) = 10 THEN 'Octubre' WHEN MONTH(fecha_creacion) = 11 THEN 'Noviembre' WHEN MONTH(fecha_creacion) = 12 THEN 'Diciembre'
                                        END month_name, COUNT(id_prospecto) prospects_number FROM prospectos 
                                        WHERE tipo = 0 AND id_sede = $id_sede AND (fecha_creacion BETWEEN '$currentYear/01/01 00:00:00' AND '$currentYear/12/31 23:59:59') 
                                        GROUP BY MONTH(fecha_creacion) ORDER BY MONTH(fecha_creacion)");
            break;
            case '3': // PENÍNSULA
                return $this->db->query("SELECT CASE WHEN MONTH(fecha_creacion) = 1 THEN 'Enero' WHEN MONTH(fecha_creacion) = 2 THEN 'Febrero' WHEN MONTH(fecha_creacion) = 3 THEN 'Marzo'
                                        WHEN MONTH(fecha_creacion) = 4 THEN 'Abril' WHEN MONTH(fecha_creacion) = 5 THEN 'Mayo' WHEN MONTH(fecha_creacion) = 6 THEN 'Junio'
                                        WHEN MONTH(fecha_creacion) = 7 THEN 'Julio' WHEN MONTH(fecha_creacion) = 8 THEN 'Agosto' WHEN MONTH(fecha_creacion) = 9 THEN 'Septiembre'
                                        WHEN MONTH(fecha_creacion) = 10 THEN 'Octubre' WHEN MONTH(fecha_creacion) = 11 THEN 'Noviembre' WHEN MONTH(fecha_creacion) = 12 THEN 'Diciembre'
                                        END month_name, COUNT(id_prospecto) prospects_number FROM prospectos 
                                        WHERE tipo = 0 AND id_sede = $id_sede AND (fecha_creacion BETWEEN '$currentYear/01/01 00:00:00' AND '$currentYear/12/31 23:59:59') 
                                        GROUP BY MONTH(fecha_creacion) ORDER BY MONTH(fecha_creacion)");
            break;
            case '4': // CIUDAD DE MÉXICO
                return $this->db->query("SELECT CASE WHEN MONTH(fecha_creacion) = 1 THEN 'Enero' WHEN MONTH(fecha_creacion) = 2 THEN 'Febrero' WHEN MONTH(fecha_creacion) = 3 THEN 'Marzo'
                                        WHEN MONTH(fecha_creacion) = 4 THEN 'Abril' WHEN MONTH(fecha_creacion) = 5 THEN 'Mayo' WHEN MONTH(fecha_creacion) = 6 THEN 'Junio'
                                        WHEN MONTH(fecha_creacion) = 7 THEN 'Julio' WHEN MONTH(fecha_creacion) = 8 THEN 'Agosto' WHEN MONTH(fecha_creacion) = 9 THEN 'Septiembre'
                                        WHEN MONTH(fecha_creacion) = 10 THEN 'Octubre' WHEN MONTH(fecha_creacion) = 11 THEN 'Noviembre' WHEN MONTH(fecha_creacion) = 12 THEN 'Diciembre'
                                        END month_name, COUNT(id_prospecto) prospects_number FROM prospectos 
                                        WHERE tipo = 0 AND id_sede = $id_sede AND (fecha_creacion BETWEEN '$currentYear/01/01 00:00:00' AND '$currentYear/12/31 23:59:59') 
                                        GROUP BY MONTH(fecha_creacion) ORDER BY MONTH(fecha_creacion)");
            break;
            case '5': // LEÓN
                return $this->db->query("SELECT CASE WHEN MONTH(fecha_creacion) = 1 THEN 'Enero' WHEN MONTH(fecha_creacion) = 2 THEN 'Febrero' WHEN MONTH(fecha_creacion) = 3 THEN 'Marzo'
                                        WHEN MONTH(fecha_creacion) = 4 THEN 'Abril' WHEN MONTH(fecha_creacion) = 5 THEN 'Mayo' WHEN MONTH(fecha_creacion) = 6 THEN 'Junio'
                                        WHEN MONTH(fecha_creacion) = 7 THEN 'Julio' WHEN MONTH(fecha_creacion) = 8 THEN 'Agosto' WHEN MONTH(fecha_creacion) = 9 THEN 'Septiembre'
                                        WHEN MONTH(fecha_creacion) = 10 THEN 'Octubre' WHEN MONTH(fecha_creacion) = 11 THEN 'Noviembre' WHEN MONTH(fecha_creacion) = 12 THEN 'Diciembre'
                                        END month_name, COUNT(id_prospecto) prospects_number FROM prospectos 
                                        WHERE tipo = 0 AND id_sede = $id_sede AND (fecha_creacion BETWEEN '$currentYear/01/01 00:00:00' AND '$currentYear/12/31 23:59:59') 
                                        GROUP BY MONTH(fecha_creacion) ORDER BY MONTH(fecha_creacion)");
            break;
            case '6': // CANCÚN
                return $this->db->query("SELECT CASE WHEN MONTH(fecha_creacion) = 1 THEN 'Enero' WHEN MONTH(fecha_creacion) = 2 THEN 'Febrero' WHEN MONTH(fecha_creacion) = 3 THEN 'Marzo'
                                        WHEN MONTH(fecha_creacion) = 4 THEN 'Abril' WHEN MONTH(fecha_creacion) = 5 THEN 'Mayo' WHEN MONTH(fecha_creacion) = 6 THEN 'Junio'
                                        WHEN MONTH(fecha_creacion) = 7 THEN 'Julio' WHEN MONTH(fecha_creacion) = 8 THEN 'Agosto' WHEN MONTH(fecha_creacion) = 9 THEN 'Septiembre'
                                        WHEN MONTH(fecha_creacion) = 10 THEN 'Octubre' WHEN MONTH(fecha_creacion) = 11 THEN 'Noviembre' WHEN MONTH(fecha_creacion) = 12 THEN 'Diciembre'
                                        END month_name, COUNT(id_prospecto) prospects_number FROM prospectos 
                                        WHERE tipo = 0 AND id_sede = $id_sede AND (fecha_creacion BETWEEN '$currentYear/01/01 00:00:00' AND '$currentYear/12/31 23:59:59') 
                                        GROUP BY MONTH(fecha_creacion) ORDER BY MONTH(fecha_creacion)");
            break;
        }
	}

    function get_clientes($user){
        $currentYear = date("Y");
        return $this->db->query("SELECT CASE WHEN MONTH(fecha_creacion) = 1 THEN 'Enero' WHEN MONTH(fecha_creacion) = 2 THEN 'Febrero' WHEN MONTH(fecha_creacion) = 3 THEN 'Marzo'
                                WHEN MONTH(fecha_creacion) = 4 THEN 'Abril' WHEN MONTH(fecha_creacion) = 5 THEN 'Mayo' WHEN MONTH(fecha_creacion) = 6 THEN 'Junio'
                                WHEN MONTH(fecha_creacion) = 7 THEN 'Julio' WHEN MONTH(fecha_creacion) = 8 THEN 'Agosto' WHEN MONTH(fecha_creacion) = 9 THEN 'Septiembre'
                                WHEN MONTH(fecha_creacion) = 10 THEN 'Octubre' WHEN MONTH(fecha_creacion) = 11 THEN 'Noviembre' WHEN MONTH(fecha_creacion) = 12 THEN 'Diciembre'
                                END mes, COUNT(*) clientes FROM prospectos 
                                WHERE tipo = 0 AND id_asesor = $user AND (fecha_creacion BETWEEN '$currentYear/01/01 00:00:00' AND '$currentYear/12/31 23:59:59') 
                                GROUP BY MONTH(fecha_creacion) ORDER BY MONTH(fecha_creacion)");
    }

    function getManagersBySubdirector($id_subdir){
        return $this->db->query("SELECT id_usuario, CONCAT(nombre, ' ', apellido_paterno, ' ', ISNULL(apellido_materno, '')) nombre, id_sede FROM usuarios WHERE 
                                id_rol = 3 AND id_lider = ".$id_subdir." AND estatus = 1 ORDER BY nombre");
    }

    function getManagersBySubdirector_assist($id_subdir){
        return $this->db->query("SELECT id_usuario, CONCAT(nombre, ' ', apellido_paterno, ' ', ISNULL(apellido_materno, '')) nombre, id_sede FROM usuarios WHERE 
                                id_rol = 3 AND id_lider = (SELECT id_lider FROM usuarios WHERE id_usuario = '$id_subdir') AND estatus = 1 ORDER BY nombre");
    }

    function getCoordinatorsByManager($id_gerente){
        return $this->db->query("SELECT id_usuario, CONCAT(nombre, ' ', apellido_paterno, ' ', ISNULL(apellido_materno, '')) nombre, id_sede FROM usuarios WHERE 
                                id_rol = 9 AND (id_lider = ".$id_gerente." OR id_lider = ".$this->session->userdata('id_lider').") AND estatus = 1 ORDER BY nombre");
    }

    function getAdvisersByCoordinator($id_coordinador){
        return $this->db->query("SELECT id_usuario, CONCAT(nombre, ' ', apellido_paterno, ' ', ISNULL(apellido_materno, '')) nombre, id_sede FROM usuarios WHERE 
                                id_rol = 7 AND id_lider = ".$id_coordinador." AND estatus = 1 ORDER BY nombre");
    }

    function get_chart($user, $tipo, $fecha_ini, $fecha_fin, $currentuser){
        return $this->db->query("SELECT CASE 
        WHEN MONTH(fecha_creacion) = 1
            THEN CONCAT('Enero ', YEAR(fecha_creacion))
        WHEN MONTH(fecha_creacion) = 2 
            THEN CONCAT('Febrero ', YEAR(fecha_creacion)) 
        WHEN MONTH(fecha_creacion) = 3 
            THEN CONCAT('Marzo ', YEAR(fecha_creacion)) 
        WHEN MONTH(fecha_creacion) = 4 
            THEN CONCAT('Abril ', YEAR(fecha_creacion)) 
        WHEN MONTH(fecha_creacion) = 5 
            THEN CONCAT('Mayo ', YEAR(fecha_creacion)) 
        WHEN MONTH(fecha_creacion) = 6 
            THEN CONCAT('Junio ', YEAR(fecha_creacion)) 
        WHEN MONTH(fecha_creacion) = 7 
            THEN CONCAT('Julio ', YEAR(fecha_creacion)) 
        WHEN MONTH(fecha_creacion) = 8 
            THEN CONCAT('Agosto ', YEAR(fecha_creacion)) 
        WHEN MONTH(fecha_creacion) = 9 
            THEN CONCAT('Septiembre ', YEAR(fecha_creacion)) 
        WHEN MONTH(fecha_creacion) = 10 
            THEN CONCAT('Octubre ', YEAR(fecha_creacion)) 
        WHEN MONTH(fecha_creacion) = 11 
            THEN CONCAT('Noviembre ', YEAR(fecha_creacion)) 
        WHEN MONTH(fecha_creacion) = 12 
            THEN CONCAT('Diciembre ', YEAR(fecha_creacion)) 
    END mes, COUNT(*) AS clientes
                                FROM prospectos WHERE tipo = $tipo AND id_asesor = '$user' AND id_gerente = '$currentuser' AND (fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
                                GROUP BY MONTH(fecha_creacion), YEAR(fecha_creacion)
                                ORDER BY YEAR(fecha_creacion), MONTH(fecha_creacion) ASC");
    }

    function get_chartuser($user, $tipo, $fecha_ini, $fecha_fin){
        return $this->db->query("SELECT CASE WHEN MONTH(fecha_creacion) = 1 THEN 'Enero' WHEN MONTH(fecha_creacion) = 2 THEN 'Febrero' WHEN MONTH(fecha_creacion) = 3 THEN 'Marzo'
                                WHEN MONTH(fecha_creacion) = 4 THEN 'Abril' WHEN MONTH(fecha_creacion) = 5 THEN 'Mayo' WHEN MONTH(fecha_creacion) = 6 THEN 'Junio'
                                WHEN MONTH(fecha_creacion) = 7 THEN 'Julio' WHEN MONTH(fecha_creacion) = 8 THEN 'Agosto' WHEN MONTH(fecha_creacion) = 9 THEN 'Septiembre'
                                WHEN MONTH(fecha_creacion) = 10 THEN 'Octubre' WHEN MONTH(fecha_creacion) = 11 THEN 'Noviembre' WHEN MONTH(fecha_creacion) = 12 THEN 'Diciembre'
                                END mes, COUNT(*) AS clientes
                                FROM prospectos WHERE tipo = $tipo AND id_asesor = '$user'
                                AND (fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
                                GROUP BY MONTH(fecha_creacion)
                                ORDER BY MONTH(fecha_creacion) ASC");
    }

    function get_chartmkt($asesor, $sede, $lugar, $fecha_ini, $fecha_fin){ // todos los filtros
        return $this->db->query("SELECT CONCAT(UCASE(LEFT(MONTHNAME(p.fecha_creacion),1)),SUBSTRING(MONTHNAME(p.fecha_creacion),2)) AS mes, 
        COUNT(p.id_cliente) AS clientes FROM prospectos p WHERE (p.id_asesor = '$asesor' AND p.id_sede = '$sede' AND p.otro_lugar = '$lugar') 
        AND p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59'  GROUP BY mes ORDER BY MONTH(p.fecha_creacion)");
    }

    function get_repomkt($asesor, $sede, $lugar, $fecha_ini, $fecha_fin){ // todos los filtros
        return $this->db->query("SELECT p.id_cliente AS Folio, IF(p.tipo = 0, 'Prospecto', 'Cliente') AS Tipo, 
        DATEDIFF(CURDATE(), p.fecha_creacion) 
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(p.fecha_creacion),1)),SUBSTRING(MONTHNAME(p.fecha_creacion),2)) 
        AS Mes,  CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente, 
        IF(p.correo IS NULL, 'No especificado', p.correo) AS Correo, 
        p.telefono AS Telefono, 
        IF(p.telefono_2 IS NULL, 'No especificado', p.telefono_2) AS Telefono_2, 
        IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
        IF(p.otro_lugar IS NULL OR p.otro_lugar = '0', 'Sin especificar', p.otro_lugar)AS DetalleProspeccion,
        IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
        CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno) as Asesor,
        IF(t2.id_rol = 3, CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno), CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno))
        AS Gerencia, se.nombre AS Sede, p.fecha_creacion as Fecha,
        IFNULL(GROUP_CONCAT(o.observacion ORDER BY o.fecha_creacion SEPARATOR '   |   '), 'Sin comentarios') AS comentarios
        FROM prospectos p INNER JOIN usuarios s ON p.id_asesor = s.id_usuario
        INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
        INNER JOIN sedes se ON se.id_sede = p.id_sede 
        LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
        LEFT JOIN sedes ot ON p.territorio_venta = ot.id_opcion AND ot.id_sede
        LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
        LEFT JOIN observaciones o ON (p.id_cliente = o.id_cliente)
        WHERE (p.id_asesor = '$asesor' AND p.id_sede = '$sede' AND p.otro_lugar = '$lugar')
        AND (p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
        AND oc.id_opcion = 6
        GROUP BY p.id_cliente ORDER BY p.fecha_creacion");
    }

    function get_chartmkt3($asesor, $sede, $fecha_ini, $fecha_fin){ // todos los filtros, lugar prosp. todos
        return $this->db->query("SELECT CONCAT(UCASE(LEFT(MONTHNAME(p.fecha_creacion),1)),SUBSTRING(MONTHNAME(p.fecha_creacion),2)) AS mes, 
        COUNT(p.id_cliente) AS clientes FROM prospectos p WHERE (p.id_asesor = '$asesor' AND p.id_sede = '$sede' AND lugar_prospeccion = 6) 
        AND p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59'  GROUP BY mes ORDER BY MONTH(p.fecha_creacion)");
    }

    function get_repomkt3($asesor, $sede, $fecha_ini, $fecha_fin){ // todos los filtros, lugar prosp. todos
        return $this->db->query("SELECT p.id_cliente AS Folio, IF(p.tipo = 0, 'Prospecto', 'Cliente') AS Tipo, 
        DATEDIFF(CURDATE(), p.fecha_creacion) 
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(p.fecha_creacion),1)),SUBSTRING(MONTHNAME(p.fecha_creacion),2)) 
        AS Mes,  CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente, 
        IF(p.correo IS NULL, 'No especificado', p.correo) AS Correo, 
        p.telefono AS Telefono, 
        IF(p.telefono_2 IS NULL, 'No especificado', p.telefono_2) AS Telefono_2, 
        IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
        IF(p.otro_lugar IS NULL OR p.otro_lugar = '0', 'Sin especificar', p.otro_lugar)AS DetalleProspeccion,
        IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
        CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno) as Asesor,
        IF(t2.id_rol = 3, CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno), CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno))
        AS Gerencia, se.nombre AS Sede, p.fecha_creacion as Fecha,
        IFNULL(GROUP_CONCAT(o.observacion ORDER BY o.fecha_creacion SEPARATOR '   |   '), 'Sin comentarios') AS comentarios
        FROM prospectos p INNER JOIN usuarios s ON p.id_asesor = s.id_usuario
        INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
        INNER JOIN sedes se ON se.id_sede = p.id_sede 
        LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
        LEFT JOIN sedes ot ON p.territorio_venta = ot.id_opcion AND ot.id_sede
        LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
        LEFT JOIN observaciones o ON (p.id_cliente = o.id_cliente)
        WHERE (p.id_asesor = '$asesor' AND p.id_sede = '$sede' AND p.lugar_prospeccion = 6)
        AND (p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
        GROUP BY p.id_cliente ORDER BY p.fecha_creacion");
    }

    function get_chartmkt5($fecha_ini, $fecha_fin){ // lugar prosp. todos, sedes todas
        return $this->db->query("SELECT CONCAT(UCASE(LEFT(MONTHNAME(p.fecha_creacion),1)),SUBSTRING(MONTHNAME(p.fecha_creacion),2)) AS mes, 
        COUNT(p.id_cliente) AS clientes FROM prospectos p WHERE (lugar_prospeccion = 6) 
        AND p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59'  GROUP BY mes ORDER BY MONTH(p.fecha_creacion)");
    }

    function get_repomkt5($fecha_ini, $fecha_fin){ // lugar prosp. todos, sedes todas
        return $this->db->query("SELECT p.id_cliente AS Folio, IF(p.tipo = 0, 'Prospecto', 'Cliente') AS Tipo, 
        DATEDIFF(CURDATE(), p.fecha_creacion) 
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(p.fecha_creacion),1)),SUBSTRING(MONTHNAME(p.fecha_creacion),2)) 
        AS Mes,  CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente, 
        IF(p.correo IS NULL, 'No especificado', p.correo) AS Correo, 
        p.telefono AS Telefono, 
        IF(p.telefono_2 IS NULL, 'No especificado', p.telefono_2) AS Telefono_2, 
        IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
        IF(p.otro_lugar IS NULL OR p.otro_lugar = '0', 'Sin especificar', p.otro_lugar)AS DetalleProspeccion,
        IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
        CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno) as Asesor,
        IF(t2.id_rol = 3, CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno), CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno))
        AS Gerencia, se.nombre AS Sede, p.fecha_creacion as Fecha,
        IFNULL(GROUP_CONCAT(o.observacion ORDER BY o.fecha_creacion SEPARATOR '   |   '), 'Sin comentarios') AS comentarios
        FROM prospectos p INNER JOIN usuarios s ON p.id_asesor = s.id_usuario
        INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
        INNER JOIN sedes se ON se.id_sede = p.id_sede 
        LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
        LEFT JOIN sedes ot ON p.territorio_venta = ot.id_opcion AND ot.id_sede
        LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
        LEFT JOIN observaciones o ON (p.id_cliente = o.id_cliente)
        WHERE (lugar_prospeccion = 6)
        AND (p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
        GROUP BY p.id_cliente ORDER BY p.fecha_creacion");
    }

    function get_repomkt1($sede, $lugar, $fecha_ini, $fecha_fin){ //reporte con lugar y sede especificos
        return $this->db->query("SELECT p.id_cliente AS Folio, IF(p.tipo = 0, 'Prospecto', 'Cliente') AS Tipo, 
        DATEDIFF(CURDATE(), p.fecha_creacion) 
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(p.fecha_creacion),1)),SUBSTRING(MONTHNAME(p.fecha_creacion),2)) 
        AS Mes,  CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente, 
        IF(p.correo IS NULL, 'No especificado', p.correo) AS Correo, 
        p.telefono AS Telefono, 
        IF(p.telefono_2 IS NULL, 'No especificado', p.telefono_2) AS Telefono_2, 
        IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
        IF(p.otro_lugar IS NULL OR p.otro_lugar = '0', 'Sin especificar', p.otro_lugar)AS DetalleProspeccion,
        IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
        CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno) as Asesor,
        IF(t2.id_rol = 3, CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno), CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno))
        AS Gerencia, se.nombre AS Sede, p.fecha_creacion as Fecha,
        IFNULL(GROUP_CONCAT(o.observacion ORDER BY o.fecha_creacion SEPARATOR '   |   '), 'Sin comentarios') AS comentarios
        FROM prospectos p INNER JOIN usuarios s ON p.id_asesor = s.id_usuario
        INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
        INNER JOIN sedes se ON se.id_sede = p.id_sede 
        LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
        LEFT JOIN sedes ot ON p.territorio_venta = ot.id_opcion AND ot.id_sede
        LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
        LEFT JOIN observaciones o ON (p.id_cliente = o.id_cliente)
        WHERE (p.id_sede = '$sede' AND otro_lugar = '$lugar')
        AND (p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
        GROUP BY p.id_cliente ORDER BY p.fecha_creacion");
    }

    function get_chartmkt1($sede, $lugar, $fecha_ini, $fecha_fin){
        return $this->db->query("SELECT CONCAT(UCASE(LEFT(MONTHNAME(p.fecha_creacion),1)),SUBSTRING(MONTHNAME(p.fecha_creacion),2)) AS mes, 
        COUNT(p.id_cliente) AS clientes FROM prospectos p WHERE (p.id_sede = '$sede' AND otro_lugar = '$lugar') 
        AND p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59'  GROUP BY mes ORDER BY MONTH(p.fecha_creacion)");
    }

    function get_chartmkt4($lugar, $fecha_ini, $fecha_fin){ //sede = todos, lugar prosp. específico
        return $this->db->query("SELECT CONCAT(UCASE(LEFT(MONTHNAME(p.fecha_creacion),1)),SUBSTRING(MONTHNAME(p.fecha_creacion),2)) AS mes, 
        COUNT(p.id_cliente) AS clientes FROM prospectos p WHERE (p.otro_lugar = '$lugar') 
        AND p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59'  GROUP BY mes ORDER BY MONTH(p.fecha_creacion)");
    }

    function get_chartmkt6($sede, $fecha_ini, $fecha_fin){ //sede especifica, lugar prosp. todos
        return $this->db->query("SELECT CONCAT(UCASE(LEFT(MONTHNAME(p.fecha_creacion),1)),SUBSTRING(MONTHNAME(p.fecha_creacion),2)) AS mes, 
        COUNT(p.id_cliente) AS clientes FROM prospectos p WHERE (p.id_sede = '$sede' AND lugar_prospeccion = 6) 
        AND p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59'  
        GROUP BY mes ORDER BY MONTH(p.fecha_creacion)");
    }

    function get_repomkt6($sede, $fecha_ini, $fecha_fin){ //sede especifica, lugar prosp. todos
        return $this->db->query("SELECT p.id_cliente AS Folio, IF(p.tipo = 0, 'Prospecto', 'Cliente') AS Tipo, 
        DATEDIFF(CURDATE(), p.fecha_creacion) 
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(p.fecha_creacion),1)),SUBSTRING(MONTHNAME(p.fecha_creacion),2)) 
        AS Mes,  CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente, 
        IF(p.correo IS NULL, 'No especificado', p.correo) AS Correo, 
        p.telefono AS Telefono, 
        IF(p.telefono_2 IS NULL, 'No especificado', p.telefono_2) AS Telefono_2, 
        IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
        IF(p.otro_lugar IS NULL OR p.otro_lugar = '0', 'Sin especificar', p.otro_lugar)AS DetalleProspeccion,
        IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
        CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno) as Asesor,
        IF(t2.id_rol = 3, CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno), CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno))
        AS Gerencia, se.nombre AS Sede, p.fecha_creacion as Fecha,
        IFNULL(GROUP_CONCAT(o.observacion ORDER BY o.fecha_creacion SEPARATOR '   |   '), 'Sin comentarios') AS comentarios
        FROM prospectos p INNER JOIN usuarios s ON p.id_asesor = s.id_usuario
        INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
        INNER JOIN sedes se ON se.id_sede = p.id_sede 
        LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
        LEFT JOIN sedes ot ON p.territorio_venta = ot.id_opcion AND ot.id_sede
        LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
        LEFT JOIN observaciones o ON (p.id_cliente = o.id_cliente)
        WHERE (p.id_sede = '$sede' AND lugar_prospeccion = 6)
        AND (p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
        GROUP BY p.id_cliente ORDER BY p.fecha_creacion");
    }

    function get_repomkt4($lugar, $fecha_ini, $fecha_fin){ //sede = todos, lugar prosp. específico
        return $this->db->query("SELECT p.id_cliente AS Folio, IF(p.tipo = 0, 'Prospecto', 'Cliente') AS Tipo, 
        DATEDIFF(CURDATE(), p.fecha_creacion) 
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(p.fecha_creacion),1)),SUBSTRING(MONTHNAME(p.fecha_creacion),2)) 
        AS Mes,  CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente, 
        IF(p.correo IS NULL, 'No especificado', p.correo) AS Correo, 
        p.telefono AS Telefono, 
        IF(p.telefono_2 IS NULL, 'No especificado', p.telefono_2) AS Telefono_2, 
        IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
        IF(p.otro_lugar IS NULL OR p.otro_lugar = '0', 'Sin especificar', p.otro_lugar)AS DetalleProspeccion,
        IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
        CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno) as Asesor,
        IF(t2.id_rol = 3, CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno), CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno))
        AS Gerencia, se.nombre AS Sede, p.fecha_creacion as Fecha,
        IFNULL(GROUP_CONCAT(o.observacion ORDER BY o.fecha_creacion SEPARATOR '   |   '), 'Sin comentarios') AS comentarios
        FROM prospectos p INNER JOIN usuarios s ON p.id_asesor = s.id_usuario
        INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
        INNER JOIN sedes se ON se.id_sede = p.id_sede 
        LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
        LEFT JOIN sedes ot ON p.territorio_venta = ot.id_opcion AND ot.id_sede
        LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
        LEFT JOIN observaciones o ON (p.id_cliente = o.id_cliente)
        WHERE (p.otro_lugar = '$lugar')
        AND (p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
        GROUP BY p.id_cliente ORDER BY p.fecha_creacion");
    }

    function get_chartuser2($user, $tipo, $fecha_ini, $fecha_fin){
        return $this->db->query("SELECT CASE WHEN MONTH(fecha_creacion) = 1 THEN 'Enero' WHEN MONTH(fecha_creacion) = 2 THEN 'Febrero' WHEN MONTH(fecha_creacion) = 3 THEN 'Marzo'
                                WHEN MONTH(fecha_creacion) = 4 THEN 'Abril' WHEN MONTH(fecha_creacion) = 5 THEN 'Mayo' WHEN MONTH(fecha_creacion) = 6 THEN 'Junio'
                                WHEN MONTH(fecha_creacion) = 7 THEN 'Julio' WHEN MONTH(fecha_creacion) = 8 THEN 'Agosto' WHEN MONTH(fecha_creacion) = 9 THEN 'Septiembre'
                                WHEN MONTH(fecha_creacion) = 10 THEN 'Octubre' WHEN MONTH(fecha_creacion) = 11 THEN 'Noviembre' WHEN MONTH(fecha_creacion) = 12 THEN 'Diciembre'
                                END mes, COUNT(CASE WHEN tipo = '0' THEN 1 END) AS prospectos, COUNT(CASE WHEN tipo = '1' THEN 1 END) AS clientes
                                FROM prospectos WHERE id_asesor = '$user'
                                AND (fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
                                GROUP BY MONTH(fecha_creacion)
                                ORDER BY MONTH(fecha_creacion) ASC");
    }

    function get_chart2($user, $tipo, $fecha_ini, $fecha_fin, $currentuser, $coordinador){
        return $this->db->query("SELECT CASE WHEN MONTH(fecha_creacion) = 1 THEN 'Enero' WHEN MONTH(fecha_creacion) = 2 THEN 'Febrero' WHEN MONTH(fecha_creacion) = 3 THEN 'Marzo'
                                WHEN MONTH(fecha_creacion) = 4 THEN 'Abril' WHEN MONTH(fecha_creacion) = 5 THEN 'Mayo' WHEN MONTH(fecha_creacion) = 6 THEN 'Junio'
                                WHEN MONTH(fecha_creacion) = 7 THEN 'Julio' WHEN MONTH(fecha_creacion) = 8 THEN 'Agosto' WHEN MONTH(fecha_creacion) = 9 THEN 'Septiembre'
                                WHEN MONTH(fecha_creacion) = 10 THEN 'Octubre' WHEN MONTH(fecha_creacion) = 11 THEN 'Noviembre' WHEN MONTH(fecha_creacion) = 12 THEN 'Diciembre'
                                END mes, COUNT(CASE WHEN tipo = 0 THEN 1 END) AS prospectos, COUNT(CASE WHEN tipo = 1 THEN 1 END) AS clientes
                                FROM prospectos WHERE id_asesor = '$user' AND id_gerente = '$currentuser' AND (id_coordinador = '$coordinador' OR id_coordinador = '$user' OR id_coordinador = '$currentuser' )
                                AND (fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
                                GROUP BY MONTH(fecha_creacion)
                                ORDER BY MONTH(fecha_creacion) ASC");
    }

    function get_chart_subdir($user, $tipo, $fecha_ini, $fecha_fin, $gerente, $currentuser){
        return $this->db->query("SELECT CASE WHEN MONTH(fecha_creacion) = 1 THEN 'Enero' WHEN MONTH(fecha_creacion) = 2 THEN 'Febrero' WHEN MONTH(fecha_creacion) = 3 THEN 'Marzo'
                                WHEN MONTH(fecha_creacion) = 4 THEN 'Abril' WHEN MONTH(fecha_creacion) = 5 THEN 'Mayo' WHEN MONTH(fecha_creacion) = 6 THEN 'Junio'
                                WHEN MONTH(fecha_creacion) = 7 THEN 'Julio' WHEN MONTH(fecha_creacion) = 8 THEN 'Agosto' WHEN MONTH(fecha_creacion) = 9 THEN 'Septiembre'
                                WHEN MONTH(fecha_creacion) = 10 THEN 'Octubre' WHEN MONTH(fecha_creacion) = 11 THEN 'Noviembre' WHEN MONTH(fecha_creacion) = 12 THEN 'Diciembre'
                                END mes, COUNT(*) AS clientes
                                FROM prospectos WHERE tipo = $tipo AND id_asesor = '$user' AND id_gerente = '$gerente'
                                AND id_sede IN (SELECT value FROM usuarios CROSS APPLY STRING_SPLIT(id_sede, ',') WHERE id_usuario = $currentuser)
                                AND (fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
                                GROUP BY MONTH(fecha_creacion)
                                ORDER BY MONTH(fecha_creacion) ASC");
    }

    function get_chart_subdir2($user, $tipo, $fecha_ini, $fecha_fin, $gerente, $currentuser){
        return $this->db->query("SELECT CASE WHEN MONTH(fecha_creacion) = 1 THEN 'Enero' WHEN MONTH(fecha_creacion) = 2 THEN 'Febrero' WHEN MONTH(fecha_creacion) = 3 THEN 'Marzo'
                                WHEN MONTH(fecha_creacion) = 4 THEN 'Abril' WHEN MONTH(fecha_creacion) = 5 THEN 'Mayo' WHEN MONTH(fecha_creacion) = 6 THEN 'Junio'
                                WHEN MONTH(fecha_creacion) = 7 THEN 'Julio' WHEN MONTH(fecha_creacion) = 8 THEN 'Agosto' WHEN MONTH(fecha_creacion) = 9 THEN 'Septiembre'
                                WHEN MONTH(fecha_creacion) = 10 THEN 'Octubre' WHEN MONTH(fecha_creacion) = 11 THEN 'Noviembre' WHEN MONTH(fecha_creacion) = 12 THEN 'Diciembre'
                                END mes, COUNT(CASE WHEN tipo = 0 THEN 1 END) AS prospectos, COUNT(CASE WHEN tipo = 1 THEN 1 END) AS clientes
                                FROM prospectos WHERE id_asesor = '$user' AND id_gerente = '$gerente' AND id_sede IN (SELECT value FROM usuarios CROSS APPLY STRING_SPLIT(id_sede, ',') WHERE id_usuario = $currentuser)
                                AND (fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
                                GROUP BY MONTH(fecha_creacion)
                                ORDER BY MONTH(fecha_creacion) ASC");
    }

    function get_chart_subdir_asis($user, $tipo, $fecha_ini, $fecha_fin, $gerente, $currentuser){
        return $this->db->query("SELECT CASE WHEN MONTH(fecha_creacion) = 1 THEN 'Enero' WHEN MONTH(fecha_creacion) = 2 THEN 'Febrero' WHEN MONTH(fecha_creacion) = 3 THEN 'Marzo'
                                WHEN MONTH(fecha_creacion) = 4 THEN 'Abril' WHEN MONTH(fecha_creacion) = 5 THEN 'Mayo' WHEN MONTH(fecha_creacion) = 6 THEN 'Junio'
                                WHEN MONTH(fecha_creacion) = 7 THEN 'Julio' WHEN MONTH(fecha_creacion) = 8 THEN 'Agosto' WHEN MONTH(fecha_creacion) = 9 THEN 'Septiembre'
                                WHEN MONTH(fecha_creacion) = 10 THEN 'Octubre' WHEN MONTH(fecha_creacion) = 11 THEN 'Noviembre' WHEN MONTH(fecha_creacion) = 12 THEN 'Diciembre'
                                END mes, COUNT(*) AS clientes
                                FROM prospectos WHERE tipo = '$tipo' AND id_asesor = '$user' AND id_gerente = '$gerente'
                                AND id_sede IN (SELECT value FROM usuarios CROSS APPLY STRING_SPLIT(id_sede, ',') WHERE id_usuario = $currentuser)
                                AND (fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
                                GROUP BY MONTH(fecha_creacion)
                                ORDER BY MONTH(fecha_creacion) ASC");
    }

    function get_chart_subdir_asis2($user, $tipo, $fecha_ini, $fecha_fin, $gerente, $currentuser){
        return $this->db->query("SELECT CASE WHEN MONTH(fecha_creacion) = 1 THEN 'Enero' WHEN MONTH(fecha_creacion) = 2 THEN 'Febrero' WHEN MONTH(fecha_creacion) = 3 THEN 'Marzo'
                                WHEN MONTH(fecha_creacion) = 4 THEN 'Abril' WHEN MONTH(fecha_creacion) = 5 THEN 'Mayo' WHEN MONTH(fecha_creacion) = 6 THEN 'Junio'
                                WHEN MONTH(fecha_creacion) = 7 THEN 'Julio' WHEN MONTH(fecha_creacion) = 8 THEN 'Agosto' WHEN MONTH(fecha_creacion) = 9 THEN 'Septiembre'
                                WHEN MONTH(fecha_creacion) = 10 THEN 'Octubre' WHEN MONTH(fecha_creacion) = 11 THEN 'Noviembre' WHEN MONTH(fecha_creacion) = 12 THEN 'Diciembre'
                                END mes, COUNT(CASE WHEN tipo = '0' THEN 1 END) AS prospectos, COUNT(CASE WHEN tipo = '1' THEN 1 END) AS clientes
                                FROM prospectos WHERE id_asesor = '$user' AND id_gerente = '$gerente'
                                AND id_sede IN (SELECT value FROM usuarios CROSS APPLY STRING_SPLIT(id_sede, ',') WHERE id_usuario = $currentuser)
                                AND (fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
                                GROUP BY MONTH(fecha_creacion)
                                ORDER BY MONTH(fecha_creacion) ASC");
    }

    function get_chart_asisger($user, $tipo, $fecha_ini, $fecha_fin, $currentuser){
        return $this->db->query("SELECT CASE WHEN MONTH(fecha_creacion) = 1 THEN 'Enero' WHEN MONTH(fecha_creacion) = 2 THEN 'Febrero' WHEN MONTH(fecha_creacion) = 3 THEN 'Marzo'
                                WHEN MONTH(fecha_creacion) = 4 THEN 'Abril' WHEN MONTH(fecha_creacion) = 5 THEN 'Mayo' WHEN MONTH(fecha_creacion) = 6 THEN 'Junio'
                                WHEN MONTH(fecha_creacion) = 7 THEN 'Julio' WHEN MONTH(fecha_creacion) = 8 THEN 'Agosto' WHEN MONTH(fecha_creacion) = 9 THEN 'Septiembre'
                                WHEN MONTH(fecha_creacion) = 10 THEN 'Octubre' WHEN MONTH(fecha_creacion) = 11 THEN 'Noviembre' WHEN MONTH(fecha_creacion) = 12 THEN 'Diciembre'
                                END mes, COUNT(*) AS clientes
                                FROM prospectos WHERE id_asesor = '$user' AND tipo = '$tipo' AND id_gerente = ". $this->session->userdata('id_lider') ."
                                AND (fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
                                GROUP BY MONTH(fecha_creacion)
                                ORDER BY MONTH(fecha_creacion) ASC ");
    }

    function get_chart_coord($user, $tipo, $fecha_ini, $fecha_fin, $currentuser){
        return $this->db->query("SELECT CASE WHEN MONTH(fecha_creacion) = 1 THEN 'Enero' WHEN MONTH(fecha_creacion) = 2 THEN 'Febrero' WHEN MONTH(fecha_creacion) = 3 THEN 'Marzo'
                                WHEN MONTH(fecha_creacion) = 4 THEN 'Abril' WHEN MONTH(fecha_creacion) = 5 THEN 'Mayo' WHEN MONTH(fecha_creacion) = 6 THEN 'Junio'
                                WHEN MONTH(fecha_creacion) = 7 THEN 'Julio' WHEN MONTH(fecha_creacion) = 8 THEN 'Agosto' WHEN MONTH(fecha_creacion) = 9 THEN 'Septiembre'
                                WHEN MONTH(fecha_creacion) = 10 THEN 'Octubre' WHEN MONTH(fecha_creacion) = 11 THEN 'Noviembre' WHEN MONTH(fecha_creacion) = 12 THEN 'Diciembre'
                                END mes, COUNT(*) AS clientes
                                FROM prospectos WHERE tipo = '$tipo' AND id_asesor = '$user' AND id_coordinador = '$currentuser'
                                AND (fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
                                GROUP BY MONTH(fecha_creacion)
                                ORDER BY MONTH(fecha_creacion) ASC ");
    }

    function get_chart_coord2($user, $fecha_ini, $fecha_fin, $currentuser){
        return $this->db->query("SELECT CASE WHEN MONTH(fecha_creacion) = 1 THEN 'Enero' WHEN MONTH(fecha_creacion) = 2 THEN 'Febrero' WHEN MONTH(fecha_creacion) = 3 THEN 'Marzo'
                                WHEN MONTH(fecha_creacion) = 4 THEN 'Abril' WHEN MONTH(fecha_creacion) = 5 THEN 'Mayo' WHEN MONTH(fecha_creacion) = 6 THEN 'Junio'
                                WHEN MONTH(fecha_creacion) = 7 THEN 'Julio' WHEN MONTH(fecha_creacion) = 8 THEN 'Agosto' WHEN MONTH(fecha_creacion) = 9 THEN 'Septiembre'
                                WHEN MONTH(fecha_creacion) = 10 THEN 'Octubre' WHEN MONTH(fecha_creacion) = 11 THEN 'Noviembre' WHEN MONTH(fecha_creacion) = 12 THEN 'Diciembre'
                                END mes, COUNT(CASE WHEN tipo = 0 THEN 1 END) AS prospectos, COUNT(CASE WHEN tipo = 1 THEN 1 END) AS clientes
                                FROM prospectos WHERE id_asesor = '$user' AND id_coordinador = '$currentuser'
                                AND (fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
                                GROUP BY MONTH(fecha_creacion)
                                ORDER BY MONTH(fecha_creacion) ASC");
    }

    function get_chart_asisger2($user, $tipo, $fecha_ini, $fecha_fin, $currentuser){
        return $this->db->query("SELECT CASE WHEN MONTH(fecha_creacion) = 1 THEN 'Enero' WHEN MONTH(fecha_creacion) = 2 THEN 'Febrero' WHEN MONTH(fecha_creacion) = 3 THEN 'Marzo'
                                WHEN MONTH(fecha_creacion) = 4 THEN 'Abril' WHEN MONTH(fecha_creacion) = 5 THEN 'Mayo' WHEN MONTH(fecha_creacion) = 6 THEN 'Junio'
                                WHEN MONTH(fecha_creacion) = 7 THEN 'Julio' WHEN MONTH(fecha_creacion) = 8 THEN 'Agosto' WHEN MONTH(fecha_creacion) = 9 THEN 'Septiembre'
                                WHEN MONTH(fecha_creacion) = 10 THEN 'Octubre' WHEN MONTH(fecha_creacion) = 11 THEN 'Noviembre' WHEN MONTH(fecha_creacion) = 12 THEN 'Diciembre'
                                END mes, COUNT(CASE WHEN tipo = 0 THEN 1 END) AS prospectos, COUNT(CASE WHEN tipo = 1 THEN 1 END) AS clientes
                                FROM prospectos WHERE id_asesor = '$user' AND id_gerente = $this->session->userdata('id_lider')
                                AND (fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
                                GROUP BY MONTH(fecha_creacion)
                                ORDER BY MONTH(fecha_creacion) ASC");
    }

    function get_total_gerente($user, $tipo){
        $current_year = date("Y");
        return $this->db->query("SELECT CASE WHEN MONTH(fecha_creacion) = 1 THEN 'Enero' WHEN MONTH(fecha_creacion) = 2 THEN 'Febrero' WHEN MONTH(fecha_creacion) = 3 THEN 'Marzo'
                                WHEN MONTH(fecha_creacion) = 4 THEN 'Abril' WHEN MONTH(fecha_creacion) = 5 THEN 'Mayo' WHEN MONTH(fecha_creacion) = 6 THEN 'Junio'
                                WHEN MONTH(fecha_creacion) = 7 THEN 'Julio' WHEN MONTH(fecha_creacion) = 8 THEN 'Agosto' WHEN MONTH(fecha_creacion) = 9 THEN 'Septiembre'
                                WHEN MONTH(fecha_creacion) = 10 THEN 'Octubre' WHEN MONTH(fecha_creacion) = 11 THEN 'Noviembre' WHEN MONTH(fecha_creacion) = 12 THEN 'Diciembre'
                                END mes, COUNT(*) AS clientes
                                FROM prospectos WHERE tipo = '$tipo' AND id_gerente = '$user'
                                AND (fecha_creacion BETWEEN '$current_year/01/01 00:00:00' AND '$current_year/12/31 23:59:59')
                                GROUP BY MONTH(fecha_creacion)
                                ORDER BY MONTH(fecha_creacion) ASC");
    }

    function get_total_mkt(){
        $current_year = date("Y");
        return $this->db->query("SELECT CONCAT(UCASE(LEFT(MONTHNAME(p.fecha_creacion),1)),SUBSTRING(MONTHNAME(p.fecha_creacion),2)) AS mes,
        COUNT(p.id_cliente) AS clientes FROM prospectos c WHERE lugar_prospeccion = 6 AND (p.fecha_creacion BETWEEN '$current_year/01/01 00:00:00' 
        AND '$current_year/12/31 23:59:59') GROUP BY mes ORDER BY MONTH(p.fecha_creacion);");
    }

    function get_total_coordinador($user, $tipo){
        $current_year = date("Y");
        return $this->db->query("SELECT CASE WHEN MONTH(fecha_creacion) = 1 THEN 'Enero' WHEN MONTH(fecha_creacion) = 2 THEN 'Febrero' WHEN MONTH(fecha_creacion) = 3 THEN 'Marzo'
                                WHEN MONTH(fecha_creacion) = 4 THEN 'Abril' WHEN MONTH(fecha_creacion) = 5 THEN 'Mayo' WHEN MONTH(fecha_creacion) = 6 THEN 'Junio'
                                WHEN MONTH(fecha_creacion) = 7 THEN 'Julio' WHEN MONTH(fecha_creacion) = 8 THEN 'Agosto' WHEN MONTH(fecha_creacion) = 9 THEN 'Septiembre'
                                WHEN MONTH(fecha_creacion) = 10 THEN 'Octubre' WHEN MONTH(fecha_creacion) = 11 THEN 'Noviembre' WHEN MONTH(fecha_creacion) = 12 THEN 'Diciembre'
                                END mes, COUNT(*) AS clientes
                                FROM prospectos WHERE tipo = '$tipo' AND id_coordinador = '$user'
                                AND (fecha_creacion BETWEEN '$current_year/01/01 00:00:00' AND '$current_year/12/31 23:59:59')
                                GROUP BY MONTH(fecha_creacion)
                                ORDER BY MONTH(fecha_creacion) ASC");
    }

    function get_total_gerente1($gerente, $tipo, $fecha_ini, $fecha_fin){ //get clientes o prospectos por gerente
        return $this->db->query("SELECT CASE WHEN MONTH(fecha_creacion) = 1 THEN 'Enero' WHEN MONTH(fecha_creacion) = 2 THEN 'Febrero' WHEN MONTH(fecha_creacion) = 3 THEN 'Marzo'
                                WHEN MONTH(fecha_creacion) = 4 THEN 'Abril' WHEN MONTH(fecha_creacion) = 5 THEN 'Mayo' WHEN MONTH(fecha_creacion) = 6 THEN 'Junio'
                                WHEN MONTH(fecha_creacion) = 7 THEN 'Julio' WHEN MONTH(fecha_creacion) = 8 THEN 'Agosto' WHEN MONTH(fecha_creacion) = 9 THEN 'Septiembre'
                                WHEN MONTH(fecha_creacion) = 10 THEN 'Octubre' WHEN MONTH(fecha_creacion) = 11 THEN 'Noviembre' WHEN MONTH(fecha_creacion) = 12 THEN 'Diciembre'
                                END mes, COUNT (*) clientes
                                FROM prospectos
                                WHERE (tipo = '$tipo' AND id_gerente = '$gerente') AND (fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
                                GROUP BY MONTH(fecha_creacion)
                                ORDER BY MONTH(fecha_creacion) ASC");
    }

    function get_total_coordinador1($gerente, $coordinador, $tipo, $fecha_ini, $fecha_fin){ //get clientes o prospectos por coordinador
        return $this->db->query("SELECT CASE WHEN MONTH(fecha_creacion) = 1 THEN 'Enero' WHEN MONTH(fecha_creacion) = 2 THEN 'Febrero' WHEN MONTH(fecha_creacion) = 3 THEN 'Marzo'
                                WHEN MONTH(fecha_creacion) = 4 THEN 'Abril' WHEN MONTH(fecha_creacion) = 5 THEN 'Mayo' WHEN MONTH(fecha_creacion) = 6 THEN 'Junio'
                                WHEN MONTH(fecha_creacion) = 7 THEN 'Julio' WHEN MONTH(fecha_creacion) = 8 THEN 'Agosto' WHEN MONTH(fecha_creacion) = 9 THEN 'Septiembre'
                                WHEN MONTH(fecha_creacion) = 10 THEN 'Octubre' WHEN MONTH(fecha_creacion) = 11 THEN 'Noviembre' WHEN MONTH(fecha_creacion) = 12 THEN 'Diciembre'
                                END mes, COUNT (*) clientes
                                FROM prospectos
                                WHERE (tipo = '$tipo' AND id_gerente = '$gerente' AND id_coordinador = '$coordinador') AND (fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
                                GROUP BY MONTH(fecha_creacion)
                                ORDER BY MONTH(fecha_creacion) ASC");
    }

    function get_total_coordinador_asis1($user, $coordinador, $tipo, $fecha_ini, $fecha_fin, $leader){ //get clientes o prospectos por coordinador siendo asistente
        return $this->db->query("SELECT CASE WHEN MONTH(fecha_creacion) = 1 THEN 'Enero' WHEN MONTH(fecha_creacion) = 2 THEN 'Febrero' WHEN MONTH(fecha_creacion) = 3 THEN 'Marzo'
                                WHEN MONTH(fecha_creacion) = 4 THEN 'Abril' WHEN MONTH(fecha_creacion) = 5 THEN 'Mayo' WHEN MONTH(fecha_creacion) = 6 THEN 'Junio'
                                WHEN MONTH(fecha_creacion) = 7 THEN 'Julio' WHEN MONTH(fecha_creacion) = 8 THEN 'Agosto' WHEN MONTH(fecha_creacion) = 9 THEN 'Septiembre'
                                WHEN MONTH(fecha_creacion) = 10 THEN 'Octubre' WHEN MONTH(fecha_creacion) = 11 THEN 'Noviembre' WHEN MONTH(fecha_creacion) = 12 THEN 'Diciembre'
                                END mes, COUNT(*) AS clientes
                                FROM prospectos WHERE tipo = '$tipo' AND id_coordinador = '$coordinador' AND id_gerente = '$leader'
                                AND (fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
                                GROUP BY MONTH(fecha_creacion)
                                ORDER BY MONTH(fecha_creacion) ASC");
    }

    function get_total_coordinador2($gerente, $coordinador, $fecha_ini, $fecha_fin){ //get clientes y prospectos por coordinador
        return $this->db->query("SELECT CASE WHEN MONTH(p.fecha_creacion) = 1 THEN 'Enero' WHEN MONTH(p.fecha_creacion) = 2 THEN 'Febrero' WHEN MONTH(p.fecha_creacion) = 3 THEN 'Marzo'
                                WHEN MONTH(p.fecha_creacion) = 4 THEN 'Abril' WHEN MONTH(p.fecha_creacion) = 5 THEN 'Mayo' WHEN MONTH(p.fecha_creacion) = 6 THEN 'Junio'
                                WHEN MONTH(p.fecha_creacion) = 7 THEN 'Julio' WHEN MONTH(p.fecha_creacion) = 8 THEN 'Agosto' WHEN MONTH(p.fecha_creacion) = 9 THEN 'Septiembre'
                                WHEN MONTH(p.fecha_creacion) = 10 THEN 'Octubre' WHEN MONTH(p.fecha_creacion) = 11 THEN 'Noviembre' WHEN MONTH(p.fecha_creacion) = 12 THEN 'Diciembre'
                                END mes, 
                                COUNT(CASE WHEN p.tipo = 0 THEN 1 END) AS prospectos, COUNT(CASE WHEN p.tipo = 1 THEN 1 END) AS clientes FROM prospectos p 
                                INNER JOIN usuarios s ON p.id_asesor = s.id_usuario
                                WHERE (p.id_gerente = '$gerente' AND p.id_coordinador = '$coordinador') AND (p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
                                GROUP BY MONTH(p.fecha_creacion)
                                ORDER BY MONTH(p.fecha_creacion) ASC");
    }

    function get_total_coordinadorasis2($user, $coordinador, $fecha_ini, $fecha_fin, $leader){ //get clientes y prospectos por coordinador siendo asistente
        return $this->db->query("SELECT CASE WHEN MONTH(fecha_creacion) = 1 THEN 'Enero' WHEN MONTH(fecha_creacion) = 2 THEN 'Febrero' WHEN MONTH(fecha_creacion) = 3 THEN 'Marzo'
                                WHEN MONTH(fecha_creacion) = 4 THEN 'Abril' WHEN MONTH(fecha_creacion) = 5 THEN 'Mayo' WHEN MONTH(fecha_creacion) = 6 THEN 'Junio'
                                WHEN MONTH(fecha_creacion) = 7 THEN 'Julio' WHEN MONTH(fecha_creacion) = 8 THEN 'Agosto' WHEN MONTH(fecha_creacion) = 9 THEN 'Septiembre'
                                WHEN MONTH(fecha_creacion) = 10 THEN 'Octubre' WHEN MONTH(fecha_creacion) = 11 THEN 'Noviembre' WHEN MONTH(fecha_creacion) = 12 THEN 'Diciembre'
                                END mes, COUNT(*) AS clientes
                                FROM prospectos WHERE id_coordinador = '$coordinador' 
                                AND id_gerente = $leader
                                AND (fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
                                GROUP BY MONTH(fecha_creacion)
                                ORDER BY MONTH(fecha_creacion) ASC");
    }

    function get_total_gerente2($gerente, $fecha_ini, $fecha_fin){ //get clientes y prospectos por gerente
        return $this->db->query("SELECT CASE WHEN MONTH(p.fecha_creacion) = 1 THEN 'Enero' WHEN MONTH(p.fecha_creacion) = 2 THEN 'Febrero' WHEN MONTH(p.fecha_creacion) = 3 THEN 'Marzo'
                                WHEN MONTH(p.fecha_creacion) = 4 THEN 'Abril' WHEN MONTH(p.fecha_creacion) = 5 THEN 'Mayo' WHEN MONTH(p.fecha_creacion) = 6 THEN 'Junio'
                                WHEN MONTH(p.fecha_creacion) = 7 THEN 'Julio' WHEN MONTH(p.fecha_creacion) = 8 THEN 'Agosto' WHEN MONTH(p.fecha_creacion) = 9 THEN 'Septiembre'
                                WHEN MONTH(p.fecha_creacion) = 10 THEN 'Octubre' WHEN MONTH(p.fecha_creacion) = 11 THEN 'Noviembre' WHEN MONTH(p.fecha_creacion) = 12 THEN 'Diciembre'
                                END mes, 
                                COUNT(CASE WHEN p.tipo = 0 THEN 1 END) AS prospectos, COUNT(CASE WHEN p.tipo = 1 THEN 1 END) AS clientes FROM prospectos p 
                                INNER JOIN usuarios s ON p.id_asesor = s.id_usuario
                                WHERE (p.id_gerente = '$gerente') AND (p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
                                GROUP BY MONTH(p.fecha_creacion)
                                ORDER BY MONTH(p.fecha_creacion) ASC");
    }

    function get_chart_gerente($user, $tipo, $fecha_ini, $fecha_fin){
        return $this->db->query("SELECT CONCAT(UCASE(LEFT(MONTHNAME(fecha_creacion),1)),SUBSTRING(MONTHNAME(fecha_creacion),2)) AS mes, COUNT(id_cliente) AS clientes FROM prospectos WHERE (tipo = '$tipo' AND id_asesor = '$user') AND
        fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59'  GROUP BY mes ORDER BY MONTH(fecha_creacion)");
    }

    function get_chart_dirbyase($user, $tipo, $fecha_ini, $fecha_fin){
        return $this->db->query("SELECT CASE WHEN MONTH(fecha_creacion) = 1 THEN 'Enero' WHEN MONTH(fecha_creacion) = 2 THEN 'Febrero' WHEN MONTH(fecha_creacion) = 3 THEN 'Marzo'
                                WHEN MONTH(fecha_creacion) = 4 THEN 'Abril' WHEN MONTH(fecha_creacion) = 5 THEN 'Mayo' WHEN MONTH(fecha_creacion) = 6 THEN 'Junio'
                                WHEN MONTH(fecha_creacion) = 7 THEN 'Julio' WHEN MONTH(fecha_creacion) = 8 THEN 'Agosto' WHEN MONTH(fecha_creacion) = 9 THEN 'Septiembre'
                                WHEN MONTH(fecha_creacion) = 10 THEN 'Octubre' WHEN MONTH(fecha_creacion) = 11 THEN 'Noviembre' WHEN MONTH(fecha_creacion) = 12 THEN 'Diciembre'
                                END mes, COUNT (*) clientes
                                FROM prospectos
                                WHERE (tipo = '$tipo' AND id_asesor = '$user') AND (fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
                                GROUP BY MONTH(fecha_creacion)
                                ORDER BY MONTH(fecha_creacion) ASC");
    }

    function get_all_dir($tipo, $fecha_ini, $fecha_fin){
        return $this->db->query("SELECT CASE WHEN MONTH(fecha_creacion) = 1 THEN 'Enero' WHEN MONTH(fecha_creacion) = 2 THEN 'Febrero' WHEN MONTH(fecha_creacion) = 3 THEN 'Marzo'
                                WHEN MONTH(fecha_creacion) = 4 THEN 'Abril' WHEN MONTH(fecha_creacion) = 5 THEN 'Mayo' WHEN MONTH(fecha_creacion) = 6 THEN 'Junio'
                                WHEN MONTH(fecha_creacion) = 7 THEN 'Julio' WHEN MONTH(fecha_creacion) = 8 THEN 'Agosto' WHEN MONTH(fecha_creacion) = 9 THEN 'Septiembre'
                                WHEN MONTH(fecha_creacion) = 10 THEN 'Octubre' WHEN MONTH(fecha_creacion) = 11 THEN 'Noviembre' WHEN MONTH(fecha_creacion) = 12 THEN 'Diciembre'
                                END mes, COUNT (*) clientes
                                FROM prospectos
                                WHERE (fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59') AND tipo = $tipo
                                GROUP BY MONTH(fecha_creacion)
                                ORDER BY MONTH(fecha_creacion) ASC");
    }

    function get_alldir($fecha_ini, $fecha_fin){
        return $this->db->query("SELECT CASE WHEN MONTH(fecha_creacion) = 1 THEN 'Enero' WHEN MONTH(fecha_creacion) = 2 THEN 'Febrero' WHEN MONTH(fecha_creacion) = 3 THEN 'Marzo'
                                WHEN MONTH(fecha_creacion) = 4 THEN 'Abril' WHEN MONTH(fecha_creacion) = 5 THEN 'Mayo' WHEN MONTH(fecha_creacion) = 6 THEN 'Junio'
                                WHEN MONTH(fecha_creacion) = 7 THEN 'Julio' WHEN MONTH(fecha_creacion) = 8 THEN 'Agosto' WHEN MONTH(fecha_creacion) = 9 THEN 'Septiembre'
                                WHEN MONTH(fecha_creacion) = 10 THEN 'Octubre' WHEN MONTH(fecha_creacion) = 11 THEN 'Noviembre' WHEN MONTH(fecha_creacion) = 12 THEN 'Diciembre'
                                END mes,COUNT(CASE WHEN tipo = 0 THEN 1 END) AS prospectos, COUNT(CASE WHEN tipo = 1 THEN 1 END) AS clientes
                                FROM prospectos WHERE fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59'
                                GROUP BY MONTH(fecha_creacion)
                                ORDER BY MONTH(fecha_creacion) ASC");
    }

    function get_chart_dirbyase1($user, $fecha_ini, $fecha_fin){
        return $this->db->query("SELECT CASE WHEN MONTH(fecha_creacion) = 1 THEN 'Enero' WHEN MONTH(fecha_creacion) = 2 THEN 'Febrero' WHEN MONTH(fecha_creacion) = 3 THEN 'Marzo'
                                WHEN MONTH(fecha_creacion) = 4 THEN 'Abril' WHEN MONTH(fecha_creacion) = 5 THEN 'Mayo' WHEN MONTH(fecha_creacion) = 6 THEN 'Junio'
                                WHEN MONTH(fecha_creacion) = 7 THEN 'Julio' WHEN MONTH(fecha_creacion) = 8 THEN 'Agosto' WHEN MONTH(fecha_creacion) = 9 THEN 'Septiembre'
                                WHEN MONTH(fecha_creacion) = 10 THEN 'Octubre' WHEN MONTH(fecha_creacion) = 11 THEN 'Noviembre' WHEN MONTH(fecha_creacion) = 12 THEN 'Diciembre'
                                END mes, COUNT(CASE WHEN tipo = 0 THEN 1 END) AS prospectos, COUNT(CASE WHEN tipo = 1 THEN 1 END) AS clientes
                                FROM prospectos WHERE (id_asesor = '$user') AND (fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
                                GROUP BY MONTH(fecha_creacion)
                                ORDER BY MONTH(fecha_creacion) ASC");
    }

    function get_total_director(){
        $current_year = date("Y");
        return $this->db->query("SELECT CASE WHEN MONTH(fecha_creacion) = 1 THEN 'Enero' WHEN MONTH(fecha_creacion) = 2 THEN 'Febrero' WHEN MONTH(fecha_creacion) = 3 THEN 'Marzo'
                                WHEN MONTH(fecha_creacion) = 4 THEN 'Abril' WHEN MONTH(fecha_creacion) = 5 THEN 'Mayo' WHEN MONTH(fecha_creacion) = 6 THEN 'Junio'
                                WHEN MONTH(fecha_creacion) = 7 THEN 'Julio' WHEN MONTH(fecha_creacion) = 8 THEN 'Agosto' WHEN MONTH(fecha_creacion) = 9 THEN 'Septiembre'
                                WHEN MONTH(fecha_creacion) = 10 THEN 'Octubre' WHEN MONTH(fecha_creacion) = 11 THEN 'Noviembre' WHEN MONTH(fecha_creacion) = 12 THEN 'Diciembre'
                                END mes, COUNT (*) clientes
                                FROM prospectos
                                WHERE (fecha_creacion BETWEEN '$current_year/01/01 00:00:00' AND '$current_year/12/31 23:59:59') AND tipo = 0
                                GROUP BY MONTH(fecha_creacion)
                                ORDER BY MONTH(fecha_creacion) ASC");
    }

    function get_lider($user){
        return $this->db->query("SELECT id_lider FROM usuarios WHERE id_usuario = '$user'");
    }

    function get_mkt_dig(){
        return $this->db->query("SELECT  otro_lugar, IF(otro_lugar = '0', 'Sin especificar', otro_lugar) AS lugares FROM prospectos WHERE lugar_prospeccion = 6  GROUP BY otro_lugar ORDER BY otro_lugar");
    }

    function get_sedes(){
        return $this->db->query("SELECT id_sede AS id_sede, nombre AS sede FROM sisgphco_crm.sedes ORDER BY nombre");
    }

    function get_reporte_asesor($user, $fecha_ini, $fecha_fin, $tipo){
        return $this->db->query("SELECT p.id_prospecto AS Folio, (CASE WHEN p.tipo = 0 THEN 'Prospecto' ELSE 'Cliente' END) AS Tipo, YEAR(p.fecha_creacion) AS Año, 
                                (DATEPART(wk, p.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(DAY, p.fecha_creacion, GETDATE()) AS DiasEnProceso, 
                                DATENAME(MONTH, p.fecha_creacion) AS Mes,  
                                CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente,
                                (CASE WHEN p.correo IS NULL THEN 'N/D' ELSE p.correo END)AS Correo, p.telefono AS Telefono,
                                (CASE WHEN oc.nombre IS NULL THEN 'N/D' ELSE oc.nombre END)AS LugarProspeccion,
                                (CASE WHEN p.otro_lugar IS NULL THEN 'N/A' WHEN p.otro_lugar = '0' THEN 'N/A' ELSE p.otro_lugar END)AS DetalleProspeccion,
                                (CASE WHEN ot.nombre IS NULL THEN 'N/D' ELSE ot.nombre END)AS PlazaVenta,
                                (CASE WHEN om.nombre IS NULL THEN 'N/D' ELSE om.nombre END)AS MedioPublicitario,
                                CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) as Asesor,
                                (CASE WHEN t2.id_rol = 3 THEN CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno) 
                                ELSE CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) END)as Gerencia, se.nombre AS Sede,
                                p.fecha_creacion as Fecha
                                FROM usuarios t1
                                INNER JOIN prospectos p ON t1.id_usuario = p.id_asesor
                                INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
                                INNER JOIN sedes se ON se.id_sede = p.id_sede 
                                LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                                LEFT JOIN sedes ot ON p.plaza_venta = ot.id_sede
                                LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                                WHERE (p.id_asesor = '$user' AND p.tipo = '$tipo') AND p.fecha_creacion 
                                BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59'  ORDER BY MONTH(p.fecha_creacion)");
    }

    function get_reporte_asesor_general($user, $tipo){
        $current_year = date("Y");
        return $this->db->query("SELECT p.id_prospecto AS Folio, (CASE WHEN p.tipo = 0 THEN 'Prospecto' ELSE 'Cliente' END) AS Tipo, YEAR(p.fecha_creacion) AS Año, 
                                (DATEPART(wk, p.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(DAY, p.fecha_creacion, GETDATE()) AS DiasEnProceso, 
                                DATENAME(MONTH, p.fecha_creacion) AS Mes,  
                                CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente,
                                (CASE WHEN p.correo IS NULL THEN 'N/D' ELSE p.correo END)AS Correo, p.telefono AS Telefono,
                                (CASE WHEN oc.nombre IS NULL THEN 'N/D' ELSE oc.nombre END)AS LugarProspeccion,
                                (CASE WHEN p.otro_lugar IS NULL THEN 'N/A' WHEN p.otro_lugar = '0' THEN 'N/A' ELSE p.otro_lugar END)AS DetalleProspeccion,
                                (CASE WHEN ot.nombre IS NULL THEN 'N/D' ELSE ot.nombre END)AS PlazaVenta,
                                (CASE WHEN om.nombre IS NULL THEN 'N/D' ELSE om.nombre END)AS MedioPublicitario,
                                CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) as Asesor,
                                (CASE WHEN t2.id_rol = 3 THEN CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno) 
                                ELSE CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) END)as Gerencia, se.nombre AS Sede,
                                p.fecha_creacion as Fecha
                                FROM usuarios t1
                                INNER JOIN prospectos p ON t1.id_usuario = p.id_asesor
                                INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
                                INNER JOIN sedes se ON se.id_sede = p.id_sede 
                                LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                                LEFT JOIN sedes ot ON p.plaza_venta = ot.id_sede
                                LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                                WHERE (p.id_asesor = '$user' AND p.tipo = '$tipo')
                                AND p.fecha_creacion BETWEEN '$current_year/01/01 00:00:00' AND '$current_year/12/31 23:59:59'  ORDER BY MONTH(p.fecha_creacion)");
    }

    function get_reporte_asesor_1($user, $fecha_ini, $fecha_fin){
        return $this->db->query("SELECT p.id_prospecto AS Folio, (CASE WHEN p.tipo = 0 THEN 'Prospecto' ELSE 'Cliente' END) AS Tipo, YEAR(p.fecha_creacion) AS Año, 
                                (DATEPART(wk, p.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(DAY, p.fecha_creacion, GETDATE()) AS DiasEnProceso, 
                                DATENAME(MONTH, p.fecha_creacion) AS Mes,  
                                CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente,
                                (CASE WHEN p.correo IS NULL THEN 'N/D' ELSE p.correo END)AS Correo, p.telefono AS Telefono,
                                (CASE WHEN oc.nombre IS NULL THEN 'N/D' ELSE oc.nombre END)AS LugarProspeccion,
                                (CASE WHEN p.otro_lugar IS NULL THEN 'N/A' WHEN p.otro_lugar = '0' THEN 'N/A' ELSE p.otro_lugar END)AS DetalleProspeccion,
                                (CASE WHEN ot.nombre IS NULL THEN 'N/D' ELSE ot.nombre END)AS PlazaVenta,
                                (CASE WHEN om.nombre IS NULL THEN 'N/D' ELSE om.nombre END)AS MedioPublicitario,
                                CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) as Asesor,
                                (CASE WHEN t2.id_rol = 3 THEN CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno) 
                                ELSE CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) END)as Gerencia, se.nombre AS Sede,
                                p.fecha_creacion as Fecha
                                FROM usuarios t1
                                INNER JOIN prospectos p ON t1.id_usuario = p.id_asesor
                                INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
                                INNER JOIN sedes se ON se.id_sede = p.id_sede 
                                LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                                LEFT JOIN sedes ot ON p.plaza_venta = ot.id_sede
                                LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                                WHERE (p.id_asesor = '$user') AND p.fecha_creacion 
                                BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59'  ORDER BY MONTH(p.fecha_creacion)");
    }

    function get_reporte_gerente($user){
        $current_year = date("Y");
        return $this->db->query("SELECT p.id_prospecto AS Folio, (CASE WHEN p.tipo = 0 THEN 'Prospecto' ELSE 'Cliente' END) AS Tipo, YEAR(p.fecha_creacion) AS Año, 
                                (DATEPART(wk, p.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(DAY, p.fecha_creacion, GETDATE()) AS DiasEnProceso, 
                                DATENAME(MONTH, p.fecha_creacion) AS Mes,  
                                CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente,
                                (CASE WHEN p.correo IS NULL THEN 'N/D' ELSE p.correo END)AS Correo, p.telefono AS Telefono,
                                (CASE WHEN oc.nombre IS NULL THEN 'N/D' ELSE oc.nombre END)AS LugarProspeccion,
                                (CASE WHEN p.otro_lugar IS NULL THEN 'N/A' WHEN p.otro_lugar = '0' THEN 'N/A' ELSE p.otro_lugar END)AS DetalleProspeccion,
                                (CASE WHEN ot.nombre IS NULL THEN 'N/D' ELSE ot.nombre END)AS PlazaVenta,
                                (CASE WHEN om.nombre IS NULL THEN 'N/D' ELSE om.nombre END)AS MedioPublicitario,
                                CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) as Asesor,
                                (CASE WHEN t2.id_rol = 3 THEN CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno) 
                                ELSE CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) END)as Gerencia, se.nombre AS Sede,
                                p.fecha_creacion as Fecha
                                FROM usuarios t1
                                INNER JOIN prospectos p ON t1.id_usuario = p.id_asesor
                                INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
                                INNER JOIN sedes se ON se.id_sede = p.id_sede 
                                LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                                LEFT JOIN sedes ot ON p.plaza_venta = ot.id_sede
                                LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                                WHERE (p.id_gerente = '$user' ) AND (p.fecha_creacion BETWEEN '$current_year/01/01 00:00:00' AND '$current_year/12/31 23:59:59')
                                ORDER BY p.fecha_creacion");
    }

    function get_reporte_gerente_general($user, $tipo){
        $current_year = date("Y");
        return $this->db->query("SELECT p.id_prospecto AS Folio, (CASE WHEN p.tipo = 0 THEN 'Prospecto' ELSE 'Cliente' END) AS Tipo, YEAR(p.fecha_creacion) AS Año, 
                                (DATEPART(wk, p.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(DAY, p.fecha_creacion, GETDATE()) AS DiasEnProceso, 
                                DATENAME(MONTH, p.fecha_creacion) AS Mes,  
                                CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente,
                                (CASE WHEN p.correo IS NULL THEN 'N/D' ELSE p.correo END)AS Correo, p.telefono AS Telefono,
                                (CASE WHEN oc.nombre IS NULL THEN 'N/D' ELSE oc.nombre END)AS LugarProspeccion,
                                (CASE WHEN p.otro_lugar IS NULL THEN 'N/A' WHEN p.otro_lugar = '0' THEN 'N/A' ELSE p.otro_lugar END)AS DetalleProspeccion,
                                (CASE WHEN ot.nombre IS NULL THEN 'N/D' ELSE ot.nombre END)AS PlazaVenta,
                                (CASE WHEN om.nombre IS NULL THEN 'N/D' ELSE om.nombre END)AS MedioPublicitario,
                                CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) as Asesor,
                                (CASE WHEN t2.id_rol = 3 THEN CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno) 
                                ELSE CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) END)as Gerencia, se.nombre AS Sede,
                                p.fecha_creacion as Fecha
                                FROM usuarios t1
                                INNER JOIN prospectos p ON t1.id_usuario = p.id_asesor
                                INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
                                INNER JOIN sedes se ON se.id_sede = p.id_sede 
                                LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                                LEFT JOIN sedes ot ON p.plaza_venta = ot.id_sede
                                LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                                WHERE (p.id_gerente = '$user' and p.tipo = '$tipo') AND (p.fecha_creacion BETWEEN '$current_year/01/01 00:00:00' AND '$current_year/12/31 23:59:59')
                                ORDER BY p.fecha_creacion");
    }

    function get_reporte_coordinador($user){
        $current_year = date("Y");
        return $this->db->query("SELECT p.id_prospecto AS Folio, (CASE WHEN p.tipo = 0 THEN 'Prospecto' ELSE 'Cliente' END) AS Tipo, YEAR(p.fecha_creacion) AS Año, 
                                (DATEPART(wk, p.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(DAY, p.fecha_creacion, GETDATE()) AS DiasEnProceso, 
                                DATENAME(MONTH, p.fecha_creacion) AS Mes,  
                                CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente,
                                (CASE WHEN p.correo IS NULL THEN 'N/D' ELSE p.correo END)AS Correo, p.telefono AS Telefono,
                                (CASE WHEN oc.nombre IS NULL THEN 'N/D' ELSE oc.nombre END)AS LugarProspeccion,
                                (CASE WHEN p.otro_lugar IS NULL THEN 'N/A' WHEN p.otro_lugar = '0' THEN 'N/A' ELSE p.otro_lugar END)AS DetalleProspeccion,
                                (CASE WHEN ot.nombre IS NULL THEN 'N/D' ELSE ot.nombre END)AS PlazaVenta,
                                (CASE WHEN om.nombre IS NULL THEN 'N/D' ELSE om.nombre END)AS MedioPublicitario,
                                CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) as Asesor,
                                (CASE WHEN t2.id_rol = 3 THEN CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno) 
                                ELSE CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) END)as Gerencia, se.nombre AS Sede,
                                p.fecha_creacion as Fecha
                                FROM usuarios t1
                                INNER JOIN prospectos p ON t1.id_usuario = p.id_asesor
                                INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
                                INNER JOIN sedes se ON se.id_sede = p.id_sede 
                                LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                                LEFT JOIN sedes ot ON p.plaza_venta = ot.id_sede
                                LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                                WHERE (p.id_coordinador = '$user' ) AND (p.fecha_creacion BETWEEN '$current_year/01/01 00:00:00' AND '$current_year/12/31 23:59:59')
                                ORDER BY p.fecha_creacion");
    }

    function get_repo_dir_byger($gerente, $fecha_ini, $fecha_fin){
        return $this->db->query("SELECT p.id_prospecto AS Folio, (CASE WHEN p.tipo = 0 THEN 'Prospecto' ELSE 'Cliente' END) AS Tipo, YEAR(p.fecha_creacion) AS Año, 
                                (DATEPART(wk, p.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(DAY, p.fecha_creacion, GETDATE()) AS DiasEnProceso, 
                                DATENAME(MONTH, p.fecha_creacion) AS Mes,  
                                CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente,
                                (CASE WHEN p.correo IS NULL THEN 'N/D' ELSE p.correo END)AS Correo, p.telefono AS Telefono,
                                (CASE WHEN oc.nombre IS NULL THEN 'N/D' ELSE oc.nombre END)AS LugarProspeccion,
                                (CASE WHEN p.otro_lugar IS NULL THEN 'N/A' WHEN p.otro_lugar = '0' THEN 'N/A' ELSE p.otro_lugar END)AS DetalleProspeccion,
                                (CASE WHEN ot.nombre IS NULL THEN 'N/D' ELSE ot.nombre END)AS PlazaVenta,
                                (CASE WHEN om.nombre IS NULL THEN 'N/D' ELSE om.nombre END)AS MedioPublicitario,
                                CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) as Asesor,
                                (CASE WHEN t2.id_rol = 3 THEN CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno) 
                                ELSE CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) END)as Gerencia, se.nombre AS Sede,
                                p.fecha_creacion as Fecha
                                FROM usuarios t1
                                INNER JOIN prospectos p ON t1.id_usuario = p.id_asesor
                                INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
                                INNER JOIN sedes se ON se.id_sede = p.id_sede 
                                LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                                LEFT JOIN sedes ot ON p.plaza_venta = ot.id_sede
                                LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                                WHERE (p.id_gerente = '$gerente') AND
                                (p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59') ORDER BY p.fecha_creacion");
    }

    function get_repo_dir_bycoord1($gerente, $coordinador, $fecha_ini, $fecha_fin, $tipo){ //reporte por coordinador
        return $this->db->query("SELECT p.id_prospecto AS Folio, (CASE WHEN p.tipo = 0 THEN 'Prospecto' ELSE 'Cliente' END) AS Tipo, YEAR(p.fecha_creacion) AS Año, 
                                (DATEPART(wk, p.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(DAY, p.fecha_creacion, GETDATE()) AS DiasEnProceso, 
                                DATENAME(MONTH, p.fecha_creacion) AS Mes,  
                                CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente,
                                (CASE WHEN p.correo IS NULL THEN 'N/D' ELSE p.correo END)AS Correo, p.telefono AS Telefono,
                                (CASE WHEN oc.nombre IS NULL THEN 'N/D' ELSE oc.nombre END)AS LugarProspeccion,
                                (CASE WHEN p.otro_lugar IS NULL THEN 'N/A' WHEN p.otro_lugar = '0' THEN 'N/A' ELSE p.otro_lugar END)AS DetalleProspeccion,
                                (CASE WHEN ot.nombre IS NULL THEN 'N/D' ELSE ot.nombre END)AS PlazaVenta,
                                (CASE WHEN om.nombre IS NULL THEN 'N/D' ELSE om.nombre END)AS MedioPublicitario,
                                CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) as Asesor,
                                (CASE WHEN t2.id_rol = 3 THEN CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno) 
                                ELSE CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) END)as Gerencia, se.nombre AS Sede,
                                p.fecha_creacion as Fecha
                                FROM usuarios t1
                                INNER JOIN prospectos p ON t1.id_usuario = p.id_asesor
                                INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
                                INNER JOIN sedes se ON se.id_sede = p.id_sede 
                                LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                                LEFT JOIN sedes ot ON p.plaza_venta = ot.id_sede
                                LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                                WHERE (p.id_gerente = '$gerente' AND p.tipo = '$tipo' AND p.id_coordinador = '$coordinador') AND
                                (p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59') ORDER BY p.fecha_creacion");
    }

    function get_repo_dir_bycoord2($gerente, $coordinador, $fecha_ini, $fecha_fin){ //reporte por coordinador
        return $this->db->query("SELECT p.id_prospecto AS Folio, (CASE WHEN p.tipo = 0 THEN 'Prospecto' ELSE 'Cliente' END) AS Tipo, YEAR(p.fecha_creacion) AS Año, 
                                (DATEPART(wk, p.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(DAY, p.fecha_creacion, GETDATE()) AS DiasEnProceso, 
                                DATENAME(MONTH, p.fecha_creacion) AS Mes,  
                                CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente,
                                (CASE WHEN p.correo IS NULL THEN 'N/D' ELSE p.correo END)AS Correo, p.telefono AS Telefono,
                                (CASE WHEN oc.nombre IS NULL THEN 'N/D' ELSE oc.nombre END)AS LugarProspeccion,
                                (CASE WHEN p.otro_lugar IS NULL THEN 'N/A' WHEN p.otro_lugar = '0' THEN 'N/A' ELSE p.otro_lugar END)AS DetalleProspeccion,
                                (CASE WHEN ot.nombre IS NULL THEN 'N/D' ELSE ot.nombre END)AS PlazaVenta,
                                (CASE WHEN om.nombre IS NULL THEN 'N/D' ELSE om.nombre END)AS MedioPublicitario,
                                CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) as Asesor,
                                (CASE WHEN t2.id_rol = 3 THEN CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno) 
                                ELSE CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) END)as Gerencia, se.nombre AS Sede,
                                p.fecha_creacion as Fecha
                                FROM usuarios t1
                                INNER JOIN prospectos p ON t1.id_usuario = p.id_asesor
                                INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
                                INNER JOIN sedes se ON se.id_sede = p.id_sede 
                                LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                                LEFT JOIN sedes ot ON p.plaza_venta = ot.id_sede
                                LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                                WHERE (p.id_gerente = '$gerente' AND p.id_coordinador = '$coordinador') AND
                                (p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59') ORDER BY p.fecha_creacion");
    }

    function get_repo_dir_byger1($gerente, $fecha_ini, $fecha_fin, $tipo){
        return $this->db->query("SELECT p.id_prospecto AS Folio, (CASE WHEN p.tipo = 0 THEN 'Prospecto' ELSE 'Cliente' END) AS Tipo, YEAR(p.fecha_creacion) AS Año, 
                                (DATEPART(wk, p.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(DAY, p.fecha_creacion, GETDATE()) AS DiasEnProceso, 
                                DATENAME(MONTH, p.fecha_creacion) AS Mes,  
                                CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente,
                                (CASE WHEN p.correo IS NULL THEN 'N/D' ELSE p.correo END)AS Correo, p.telefono AS Telefono,
                                (CASE WHEN oc.nombre IS NULL THEN 'N/D' ELSE oc.nombre END)AS LugarProspeccion,
                                (CASE WHEN p.otro_lugar IS NULL THEN 'N/A' WHEN p.otro_lugar = '0' THEN 'N/A' ELSE p.otro_lugar END)AS DetalleProspeccion,
                                (CASE WHEN ot.nombre IS NULL THEN 'N/D' ELSE ot.nombre END)AS PlazaVenta,
                                (CASE WHEN om.nombre IS NULL THEN 'N/D' ELSE om.nombre END)AS MedioPublicitario,
                                CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) as Asesor,
                                (CASE WHEN t2.id_rol = 3 THEN CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno) 
                                ELSE CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) END)as Gerencia, se.nombre AS Sede,
                                p.fecha_creacion as Fecha
                                FROM usuarios t1
                                INNER JOIN prospectos p ON t1.id_usuario = p.id_asesor
                                INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
                                INNER JOIN sedes se ON se.id_sede = p.id_sede 
                                LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                                LEFT JOIN sedes ot ON p.plaza_venta = ot.id_sede
                                LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                                WHERE (p.id_gerente = '$gerente' AND p.tipo = $tipo) AND
                                (p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59') ORDER BY p.fecha_creacion");
    }

    function get_reporte_gerente1($user, $fecha_ini, $fecha_fin, $tipo, $asesor){
        return $this->db->query("SELECT p.id_prospecto AS Folio, (CASE WHEN p.tipo = 0 THEN 'Prospecto' ELSE 'Cliente' END) AS Tipo, YEAR(p.fecha_creacion) AS Año, 
                                (DATEPART(wk, p.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(DAY, p.fecha_creacion, GETDATE()) AS DiasEnProceso, 
                                DATENAME(MONTH, p.fecha_creacion) AS Mes,  
                                CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente,
                                (CASE WHEN p.correo IS NULL THEN 'N/D' ELSE p.correo END)AS Correo, p.telefono AS Telefono,
                                (CASE WHEN oc.nombre IS NULL THEN 'N/D' ELSE oc.nombre END)AS LugarProspeccion,
                                (CASE WHEN p.otro_lugar IS NULL THEN 'N/A' WHEN p.otro_lugar = '0' THEN 'N/A' ELSE p.otro_lugar END)AS DetalleProspeccion,
                                (CASE WHEN ot.nombre IS NULL THEN 'N/D' ELSE ot.nombre END)AS PlazaVenta,
                                (CASE WHEN om.nombre IS NULL THEN 'N/D' ELSE om.nombre END)AS MedioPublicitario,
                                CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) as Asesor,
                                (CASE WHEN t2.id_rol = 3 THEN CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno) 
                                ELSE CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) END)as Gerencia, se.nombre AS Sede,
                                p.fecha_creacion as Fecha
                                FROM usuarios t1
                                INNER JOIN prospectos p ON t1.id_usuario = p.id_asesor
                                INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
                                INNER JOIN sedes se ON se.id_sede = p.id_sede 
                                LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                                LEFT JOIN sedes ot ON p.plaza_venta = ot.id_sede
                                LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                                WHERE (p.id_gerente = '$user' AND p.tipo = '$tipo' AND p.id_asesor = '$asesor') AND
                                (p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59') ORDER BY p.fecha_creacion");
    }

    function get_reporte_coordinador1($user, $fecha_ini, $fecha_fin, $tipo, $asesor){
        return $this->db->query("SELECT p.id_prospecto AS Folio, (CASE WHEN p.tipo = 0 THEN 'Prospecto' ELSE 'Cliente' END) AS Tipo, YEAR(p.fecha_creacion) AS Año, 
                                (DATEPART(wk, p.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(DAY, p.fecha_creacion, GETDATE()) AS DiasEnProceso, 
                                DATENAME(MONTH, p.fecha_creacion) AS Mes,  
                                CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente,
                                (CASE WHEN p.correo IS NULL THEN 'N/D' ELSE p.correo END)AS Correo, p.telefono AS Telefono,
                                (CASE WHEN oc.nombre IS NULL THEN 'N/D' ELSE oc.nombre END)AS LugarProspeccion,
                                (CASE WHEN p.otro_lugar IS NULL THEN 'N/A' WHEN p.otro_lugar = '0' THEN 'N/A' ELSE p.otro_lugar END)AS DetalleProspeccion,
                                (CASE WHEN ot.nombre IS NULL THEN 'N/D' ELSE ot.nombre END)AS PlazaVenta,
                                (CASE WHEN om.nombre IS NULL THEN 'N/D' ELSE om.nombre END)AS MedioPublicitario,
                                CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) as Asesor,
                                (CASE WHEN t2.id_rol = 3 THEN CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno) 
                                ELSE CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) END)as Gerencia, se.nombre AS Sede,
                                p.fecha_creacion as Fecha
                                FROM usuarios t1
                                INNER JOIN prospectos p ON t1.id_usuario = p.id_asesor
                                INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
                                INNER JOIN sedes se ON se.id_sede = p.id_sede 
                                LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                                LEFT JOIN sedes ot ON p.plaza_venta = ot.id_sede
                                LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                                 WHERE (p.id_coordinador = '$user' AND p.tipo = '$tipo' AND p.id_asesor = '$asesor') AND
                                 (p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59') ORDER BY p.fecha_creacion");
    }

    function get_reporte_coordinadorgeneral1($user, $tipo){
        $current_year = date("Y");
        return $this->db->query("SELECT p.id_prospecto AS Folio, (CASE WHEN p.tipo = 0 THEN 'Prospecto' ELSE 'Cliente' END) AS Tipo, YEAR(p.fecha_creacion) AS Año, 
                                (DATEPART(wk, p.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(DAY, p.fecha_creacion, GETDATE()) AS DiasEnProceso, 
                                DATENAME(MONTH, p.fecha_creacion) AS Mes,  
                                CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente,
                                (CASE WHEN p.correo IS NULL THEN 'N/D' ELSE p.correo END)AS Correo, p.telefono AS Telefono,
                                (CASE WHEN oc.nombre IS NULL THEN 'N/D' ELSE oc.nombre END)AS LugarProspeccion,
                                (CASE WHEN p.otro_lugar IS NULL THEN 'N/A' WHEN p.otro_lugar = '0' THEN 'N/A' ELSE p.otro_lugar END)AS DetalleProspeccion,
                                (CASE WHEN ot.nombre IS NULL THEN 'N/D' ELSE ot.nombre END)AS PlazaVenta,
                                (CASE WHEN om.nombre IS NULL THEN 'N/D' ELSE om.nombre END)AS MedioPublicitario,
                                CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) as Asesor,
                                (CASE WHEN t2.id_rol = 3 THEN CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno) 
                                ELSE CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) END)as Gerencia, se.nombre AS Sede,
                                p.fecha_creacion as Fecha
                                FROM usuarios t1
                                INNER JOIN prospectos p ON t1.id_usuario = p.id_asesor
                                INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
                                INNER JOIN sedes se ON se.id_sede = p.id_sede 
                                LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                                LEFT JOIN sedes ot ON p.plaza_venta = ot.id_sede
                                LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                                WHERE (p.id_coordinador = '$user' AND p.tipo = '$tipo') AND
                                (p.fecha_creacion BETWEEN '$current_year/01/01 00:00:00' AND '$current_year/12/31 23:59:59') ORDER BY p.fecha_creacion");
    }

    function get_reporte_coordinador2($user, $fecha_ini, $fecha_fin, $asesor){
        return $this->db->query("SELECT p.id_prospecto AS Folio, (CASE WHEN p.tipo = 0 THEN 'Prospecto' ELSE 'Cliente' END) AS Tipo, YEAR(p.fecha_creacion) AS Año, 
                                (DATEPART(wk, p.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(DAY, p.fecha_creacion, GETDATE()) AS DiasEnProceso, 
                                DATENAME(MONTH, p.fecha_creacion) AS Mes,  
                                CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente,
                                (CASE WHEN oc.nombre IS NULL THEN 'N/D' ELSE oc.nombre END)AS LugarProspeccion,
                                (CASE WHEN p.otro_lugar IS NULL THEN 'N/A' WHEN p.otro_lugar = '0' THEN 'N/A' ELSE p.otro_lugar END)AS DetalleProspeccion,
                                (CASE WHEN ot.nombre IS NULL THEN 'N/D' ELSE ot.nombre END)AS PlazaVenta,
                                (CASE WHEN om.nombre IS NULL THEN 'N/D' ELSE om.nombre END)AS MedioPublicitario,
                                CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) as Asesor,
                                (CASE WHEN t2.id_rol = 3 THEN CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno) 
                                ELSE CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) END)as Gerencia, se.nombre AS Sede,
                                p.fecha_creacion as Fecha
                                FROM usuarios t1
                                INNER JOIN prospectos p ON t1.id_usuario = p.id_asesor
                                INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
                                INNER JOIN sedes se ON se.id_sede = p.id_sede 
                                LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                                LEFT JOIN sedes ot ON p.plaza_venta = ot.id_sede
                                LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                                WHERE (p.id_coordinador = '$user' AND p.id_asesor = '$asesor') AND
                                (p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59') ORDER BY p.fecha_creacion");
    }

    function get_reporte_asisgerente($user){
        $current_year = date("Y");
        return $this->db->query("SELECT p.id_prospecto AS Folio, (CASE WHEN p.tipo = 0 THEN 'Prospecto' ELSE 'Cliente' END) AS Tipo, YEAR(p.fecha_creacion) AS Año, 
                                (DATEPART(wk, p.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(DAY, p.fecha_creacion, GETDATE()) AS DiasEnProceso, 
                                DATENAME(MONTH, p.fecha_creacion) AS Mes,  
                                CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente,
                                (CASE WHEN p.correo IS NULL THEN 'N/D' ELSE p.correo END)AS Correo, p.telefono AS Telefono,
                                (CASE WHEN oc.nombre IS NULL THEN 'N/D' ELSE oc.nombre END)AS LugarProspeccion,
                                (CASE WHEN p.otro_lugar IS NULL THEN 'N/A' WHEN p.otro_lugar = '0' THEN 'N/A' ELSE p.otro_lugar END)AS DetalleProspeccion,
                                (CASE WHEN ot.nombre IS NULL THEN 'N/D' ELSE ot.nombre END)AS PlazaVenta,
                                (CASE WHEN om.nombre IS NULL THEN 'N/D' ELSE om.nombre END)AS MedioPublicitario,
                                CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) as Asesor,
                                (CASE WHEN t2.id_rol = 3 THEN CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno) 
                                ELSE CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) END)as Gerencia, se.nombre AS Sede,
                                p.fecha_creacion as Fecha
                                FROM usuarios t1
                                INNER JOIN prospectos p ON t1.id_usuario = p.id_asesor
                                INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
                                INNER JOIN sedes se ON se.id_sede = p.id_sede 
                                LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                                LEFT JOIN sedes ot ON p.plaza_venta = ot.id_sede
                                LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                                WHERE p.id_gerente IN (SELECT id_lider FROM usuarios WHERE id_usuario = '$user') 
                                AND (p.fecha_creacion BETWEEN '$current_year/01/01 00:00:00' AND '$current_year/12/31 23:59:59')
                                ORDER BY p.fecha_creacion");
    }

    function get_reporte_asisgeneralgerente($user, $tipo){
        $current_year = date("Y");
        return $this->db->query("SELECT p.id_prospecto AS Folio, (CASE WHEN p.tipo = 0 THEN 'Prospecto' ELSE 'Cliente' END) AS Tipo, YEAR(p.fecha_creacion) AS Año, 
                                (DATEPART(wk, p.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(DAY, p.fecha_creacion, GETDATE()) AS DiasEnProceso, 
                                DATENAME(MONTH, p.fecha_creacion) AS Mes,  
                                CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente,
                                (CASE WHEN p.correo IS NULL THEN 'N/D' ELSE p.correo END)AS Correo, p.telefono AS Telefono,
                                (CASE WHEN oc.nombre IS NULL THEN 'N/D' ELSE oc.nombre END)AS LugarProspeccion,
                                (CASE WHEN p.otro_lugar IS NULL THEN 'N/A' WHEN p.otro_lugar = '0' THEN 'N/A' ELSE p.otro_lugar END)AS DetalleProspeccion,
                                (CASE WHEN ot.nombre IS NULL THEN 'N/D' ELSE ot.nombre END)AS PlazaVenta,
                                (CASE WHEN om.nombre IS NULL THEN 'N/D' ELSE om.nombre END)AS MedioPublicitario,
                                CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) as Asesor,
                                (CASE WHEN t2.id_rol = 3 THEN CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno) 
                                ELSE CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) END)as Gerencia, se.nombre AS Sede,
                                p.fecha_creacion as Fecha
                                FROM usuarios t1
                                INNER JOIN prospectos p ON t1.id_usuario = p.id_asesor
                                INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
                                INNER JOIN sedes se ON se.id_sede = p.id_sede 
                                LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                                LEFT JOIN sedes ot ON p.plaza_venta = ot.id_sede
                                LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                                WHERE p.id_gerente IN (SELECT id_lider FROM usuarios WHERE id_usuario = '$user') 
                                AND (p.fecha_creacion BETWEEN '$current_year/01/01 00:00:00' AND '$current_year/12/31 23:59:59')
                                AND p.tipo = '$tipo' ORDER BY p.fecha_creacion");
    }

    function get_reporte_asisgerente1($user, $fecha_ini, $fecha_fin, $tipo, $asesor){
        return $this->db->query("SELECT p.id_prospecto AS Folio, (CASE WHEN p.tipo = 0 THEN 'Prospecto' ELSE 'Cliente' END) AS Tipo, YEAR(p.fecha_creacion) AS Año, 
                                (DATEPART(wk, p.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(DAY, p.fecha_creacion, GETDATE()) AS DiasEnProceso, 
                                DATENAME(MONTH, p.fecha_creacion) AS Mes,  
                                CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente,
                                (CASE WHEN p.correo IS NULL THEN 'N/D' ELSE p.correo END)AS Correo, p.telefono AS Telefono,
                                (CASE WHEN oc.nombre IS NULL THEN 'N/D' ELSE oc.nombre END)AS LugarProspeccion,
                                (CASE WHEN p.otro_lugar IS NULL THEN 'N/A' WHEN p.otro_lugar = '0' THEN 'N/A' ELSE p.otro_lugar END)AS DetalleProspeccion,
                                (CASE WHEN ot.nombre IS NULL THEN 'N/D' ELSE ot.nombre END)AS PlazaVenta,
                                (CASE WHEN om.nombre IS NULL THEN 'N/D' ELSE om.nombre END)AS MedioPublicitario,
                                CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) as Asesor,
                                (CASE WHEN t2.id_rol = 3 THEN CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno) 
                                ELSE CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) END)as Gerencia, se.nombre AS Sede,
                                p.fecha_creacion as Fecha
                                FROM usuarios t1
                                INNER JOIN prospectos p ON t1.id_usuario = p.id_asesor
                                INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
                                INNER JOIN sedes se ON se.id_sede = p.id_sede 
                                LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                                LEFT JOIN sedes ot ON p.plaza_venta = ot.id_sede
                                LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                                WHERE p.id_gerente IN (SELECT id_lider FROM usuarios WHERE id_usuario = '$user') AND (p.tipo = '$tipo' AND p.id_asesor = '$asesor')
                                AND (p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
                                ORDER BY p.fecha_creacion");
    }

    function get_reporte_asisgerente2($user, $fecha_ini, $fecha_fin, $tipo, $asesor){
        return $this->db->query("SELECT p.id_prospecto AS Folio, (CASE WHEN p.tipo = 0 THEN 'Prospecto' ELSE 'Cliente' END) AS Tipo, YEAR(p.fecha_creacion) AS Año, 
                                (DATEPART(wk, p.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(DAY, p.fecha_creacion, GETDATE()) AS DiasEnProceso, 
                                DATENAME(MONTH, p.fecha_creacion) AS Mes,  
                                CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente,
                                (CASE WHEN p.correo IS NULL THEN 'N/D' ELSE p.correo END)AS Correo, p.telefono AS Telefono,
                                (CASE WHEN oc.nombre IS NULL THEN 'N/D' ELSE oc.nombre END)AS LugarProspeccion,
                                (CASE WHEN p.otro_lugar IS NULL THEN 'N/A' WHEN p.otro_lugar = '0' THEN 'N/A' ELSE p.otro_lugar END)AS DetalleProspeccion,
                                (CASE WHEN ot.nombre IS NULL THEN 'N/D' ELSE ot.nombre END)AS PlazaVenta,
                                (CASE WHEN om.nombre IS NULL THEN 'N/D' ELSE om.nombre END)AS MedioPublicitario,
                                CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) as Asesor,
                                (CASE WHEN t2.id_rol = 3 THEN CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno) 
                                ELSE CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) END)as Gerencia, se.nombre AS Sede,
                                p.fecha_creacion as Fecha
                                FROM usuarios t1
                                INNER JOIN prospectos p ON t1.id_usuario = p.id_asesor
                                INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
                                INNER JOIN sedes se ON se.id_sede = p.id_sede 
                                LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                                LEFT JOIN sedes ot ON p.plaza_venta = ot.id_sede
                                LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                                WHERE p.id_gerente IN (SELECT id_lider FROM usuarios WHERE id_usuario = '$user') AND (p.id_asesor = '$asesor')
                                AND (p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
                                ORDER BY p.fecha_creacion");
    }

    function get_reporte_gerente2($user, $fecha_ini, $fecha_fin, $tipo, $asesor){
        return $this->db->query("SELECT p.id_prospecto AS Folio, (CASE WHEN p.tipo = 0 THEN 'Prospecto' ELSE 'Cliente' END) AS Tipo, YEAR(p.fecha_creacion) AS Año, 
                                (DATEPART(wk, p.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(DAY, p.fecha_creacion, GETDATE()) AS DiasEnProceso, 
                                DATENAME(MONTH, p.fecha_creacion) AS Mes,  
                                CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente,
                                (CASE WHEN p.correo IS NULL THEN 'N/D' ELSE p.correo END)AS Correo, p.telefono AS Telefono,
                                (CASE WHEN oc.nombre IS NULL THEN 'N/D' ELSE oc.nombre END)AS LugarProspeccion,
                                (CASE WHEN p.otro_lugar IS NULL THEN 'N/A' WHEN p.otro_lugar = '0' THEN 'N/A' ELSE p.otro_lugar END)AS DetalleProspeccion,
                                (CASE WHEN ot.nombre IS NULL THEN 'N/D' ELSE ot.nombre END)AS PlazaVenta,
                                (CASE WHEN om.nombre IS NULL THEN 'N/D' ELSE om.nombre END)AS MedioPublicitario,
                                CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) as Asesor,
                                (CASE WHEN t2.id_rol = 3 THEN CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno) 
                                ELSE CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) END)as Gerencia, se.nombre AS Sede,
                                p.fecha_creacion as Fecha
                                FROM usuarios t1
                                INNER JOIN prospectos p ON t1.id_usuario = p.id_asesor
                                INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
                                INNER JOIN sedes se ON se.id_sede = p.id_sede 
                                LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                                LEFT JOIN sedes ot ON p.plaza_venta = ot.id_sede
                                LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                                WHERE p.id_gerente = '$user' AND (p.id_asesor = '$asesor')
                                AND (p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
                                ORDER BY p.fecha_creacion");
    }

    function get_reporte_gerente_coord2($user, $fecha_ini, $fecha_fin, $coordinador){
        return $this->db->query("SELECT p.id_prospecto AS Folio, (CASE WHEN p.tipo = 0 THEN 'Prospecto' ELSE 'Cliente' END) AS Tipo, YEAR(p.fecha_creacion) AS Año, 
                                (DATEPART(wk, p.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(DAY, p.fecha_creacion, GETDATE()) AS DiasEnProceso, 
                                DATENAME(MONTH, p.fecha_creacion) AS Mes,  
                                CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente,
                                (CASE WHEN p.correo IS NULL THEN 'N/D' ELSE p.correo END)AS Correo, p.telefono AS Telefono,
                                (CASE WHEN oc.nombre IS NULL THEN 'N/D' ELSE oc.nombre END)AS LugarProspeccion,
                                (CASE WHEN p.otro_lugar IS NULL THEN 'N/A' WHEN p.otro_lugar = '0' THEN 'N/A' ELSE p.otro_lugar END)AS DetalleProspeccion,
                                (CASE WHEN ot.nombre IS NULL THEN 'N/D' ELSE ot.nombre END)AS PlazaVenta,
                                (CASE WHEN om.nombre IS NULL THEN 'N/D' ELSE om.nombre END)AS MedioPublicitario,
                                CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) as Asesor,
                                (CASE WHEN t2.id_rol = 3 THEN CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno) 
                                ELSE CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) END)as Gerencia, se.nombre AS Sede,
                                p.fecha_creacion as Fecha
                                FROM usuarios t1
                                INNER JOIN prospectos p ON t1.id_usuario = p.id_asesor
                                INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
                                INNER JOIN sedes se ON se.id_sede = p.id_sede 
                                LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                                LEFT JOIN sedes ot ON p.plaza_venta = ot.id_sede
                                LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                                WHERE p.id_gerente = '$user' AND (p.id_coordinador = '$coordinador')
                                AND (p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
                                ORDER BY p.fecha_creacion");
    }

    function get_reporte_asisgerente_coord2($user, $fecha_ini, $fecha_fin, $coordinador){
        return $this->db->query("SELECT p.id_prospecto AS Folio, (CASE WHEN p.tipo = 0 THEN 'Prospecto' ELSE 'Cliente' END) AS Tipo, YEAR(p.fecha_creacion) AS Año, 
                                (DATEPART(wk, p.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(DAY, p.fecha_creacion, GETDATE()) AS DiasEnProceso, 
                                DATENAME(MONTH, p.fecha_creacion) AS Mes,  
                                CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente,
                                (CASE WHEN p.correo IS NULL THEN 'N/D' ELSE p.correo END)AS Correo, p.telefono AS Telefono,
                                (CASE WHEN oc.nombre IS NULL THEN 'N/D' ELSE oc.nombre END)AS LugarProspeccion,
                                (CASE WHEN p.otro_lugar IS NULL THEN 'N/A' WHEN p.otro_lugar = '0' THEN 'N/A' ELSE p.otro_lugar END)AS DetalleProspeccion,
                                (CASE WHEN ot.nombre IS NULL THEN 'N/D' ELSE ot.nombre END)AS PlazaVenta,
                                (CASE WHEN om.nombre IS NULL THEN 'N/D' ELSE om.nombre END)AS MedioPublicitario,
                                CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) as Asesor,
                                (CASE WHEN t2.id_rol = 3 THEN CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno) 
                                ELSE CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) END)as Gerencia, se.nombre AS Sede,
                                p.fecha_creacion as Fecha
                                FROM usuarios t1
                                INNER JOIN prospectos p ON t1.id_usuario = p.id_asesor
                                INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
                                INNER JOIN sedes se ON se.id_sede = p.id_sede 
                                LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                                LEFT JOIN sedes ot ON p.plaza_venta = ot.id_sede
                                LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                                WHERE p.id_gerente IN(SELECT id_lider FROM usuarios WHERE id_usuario = '$user' AND id_rol = 6) AND (p.id_coordinador = '$coordinador')
                                AND (p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
                                ORDER BY p.fecha_creacion");
    }

    function get_reporte_gerente_coord1($user, $fecha_ini, $fecha_fin, $tipo, $coordinador){
        return $this->db->query("SELECT p.id_prospecto AS Folio, (CASE WHEN p.tipo = 0 THEN 'Prospecto' ELSE 'Cliente' END) AS Tipo, YEAR(p.fecha_creacion) AS Año, 
                                (DATEPART(wk, p.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(DAY, p.fecha_creacion, GETDATE()) AS DiasEnProceso, 
                                DATENAME(MONTH, p.fecha_creacion) AS Mes,  
                                CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente,
                                (CASE WHEN p.correo IS NULL THEN 'N/D' ELSE p.correo END)AS Correo, p.telefono AS Telefono,
                                (CASE WHEN oc.nombre IS NULL THEN 'N/D' ELSE oc.nombre END)AS LugarProspeccion,
                                (CASE WHEN p.otro_lugar IS NULL THEN 'N/A' WHEN p.otro_lugar = '0' THEN 'N/A' ELSE p.otro_lugar END)AS DetalleProspeccion,
                                (CASE WHEN ot.nombre IS NULL THEN 'N/D' ELSE ot.nombre END)AS PlazaVenta,
                                (CASE WHEN om.nombre IS NULL THEN 'N/D' ELSE om.nombre END)AS MedioPublicitario,
                                CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) as Asesor,
                                (CASE WHEN t2.id_rol = 3 THEN CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno) 
                                ELSE CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) END)as Gerencia, se.nombre AS Sede,
                                p.fecha_creacion as Fecha
                                FROM usuarios t1
                                INNER JOIN prospectos p ON t1.id_usuario = p.id_asesor
                                INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
                                INNER JOIN sedes se ON se.id_sede = p.id_sede 
                                LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                                LEFT JOIN sedes ot ON p.plaza_venta = ot.id_sede
                                LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                                WHERE p.id_gerente = '$user' AND p.tipo = '$tipo' AND (p.id_coordinador = '$coordinador')
                                AND (p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
                                ORDER BY p.fecha_creacion");
    }

    function get_reporte_asisgerente_coord1($user, $fecha_ini, $fecha_fin, $tipo, $coordinador){
        return $this->db->query("SELECT p.id_prospecto AS Folio, (CASE WHEN p.tipo = 0 THEN 'Prospecto' ELSE 'Cliente' END) AS Tipo, YEAR(p.fecha_creacion) AS Año, 
                                (DATEPART(wk, p.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(DAY, p.fecha_creacion, GETDATE()) AS DiasEnProceso, 
                                DATENAME(MONTH, p.fecha_creacion) AS Mes,  
                                CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente,
                                (CASE WHEN p.correo IS NULL THEN 'N/D' ELSE p.correo END)AS Correo, p.telefono AS Telefono,
                                (CASE WHEN oc.nombre IS NULL THEN 'N/D' ELSE oc.nombre END)AS LugarProspeccion,
                                (CASE WHEN p.otro_lugar IS NULL THEN 'N/A' WHEN p.otro_lugar = '0' THEN 'N/A' ELSE p.otro_lugar END)AS DetalleProspeccion,
                                (CASE WHEN ot.nombre IS NULL THEN 'N/D' ELSE ot.nombre END)AS PlazaVenta,
                                (CASE WHEN om.nombre IS NULL THEN 'N/D' ELSE om.nombre END)AS MedioPublicitario,
                                CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) as Asesor,
                                (CASE WHEN t2.id_rol = 3 THEN CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno) 
                                ELSE CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) END)as Gerencia, se.nombre AS Sede,
                                p.fecha_creacion as Fecha
                                FROM usuarios t1
                                INNER JOIN prospectos p ON t1.id_usuario = p.id_asesor
                                INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
                                INNER JOIN sedes se ON se.id_sede = p.id_sede 
                                LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                                LEFT JOIN sedes ot ON p.plaza_venta = ot.id_sede
                                LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                                WHERE p.id_gerente IN(SELECT id_lider FROM usuarios WHERE id_usuario = '$user' AND id_rol = 6) AND p.tipo = '$tipo' AND (p.id_coordinador = '$coordinador')
                                AND (p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
                                ORDER BY p.fecha_creacion");
    }

    function get_total_gerente_asis($user, $tipo){
        $current_year = date("Y");
        return $this->db->query("SELECT CASE WHEN MONTH(fecha_creacion) = 1 THEN 'Enero' WHEN MONTH(fecha_creacion) = 2 THEN 'Febrero' WHEN MONTH(fecha_creacion) = 3 THEN 'Marzo'
                                WHEN MONTH(fecha_creacion) = 4 THEN 'Abril' WHEN MONTH(fecha_creacion) = 5 THEN 'Mayo' WHEN MONTH(fecha_creacion) = 6 THEN 'Junio'
                                WHEN MONTH(fecha_creacion) = 7 THEN 'Julio' WHEN MONTH(fecha_creacion) = 8 THEN 'Agosto' WHEN MONTH(fecha_creacion) = 9 THEN 'Septiembre'
                                WHEN MONTH(fecha_creacion) = 10 THEN 'Octubre' WHEN MONTH(fecha_creacion) = 11 THEN 'Noviembre' WHEN MONTH(fecha_creacion) = 12 THEN 'Diciembre'
                                END mes, COUNT(*) AS clientes
                                FROM prospectos WHERE tipo = '$tipo' AND id_gerente IN (SELECT id_lider FROM usuarios WHERE id_usuario = '$user')
                                AND (fecha_creacion BETWEEN '$current_year/01/01 00:00:00' AND '$current_year/12/31 23:59:59')
                                GROUP BY MONTH(fecha_creacion)
                                ORDER BY MONTH(fecha_creacion) ASC");
    }


    function get_reporte_dir(){
        $current_year = date("Y");
        return $this->db->query("SELECT p.id_prospecto AS Folio, (CASE WHEN p.tipo = 0 THEN 'Prospecto' ELSE 'Cliente' END) AS Tipo, YEAR(p.fecha_creacion) AS Año, 
                                (DATEPART(wk, p.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(DAY, p.fecha_creacion, GETDATE()) AS DiasEnProceso, 
                                DATENAME(MONTH, p.fecha_creacion) AS Mes,  
                                CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente,
                                (CASE WHEN p.correo IS NULL THEN 'N/D' ELSE p.correo END)AS Correo, p.telefono AS Telefono,
                                (CASE WHEN oc.nombre IS NULL THEN 'N/D' ELSE oc.nombre END)AS LugarProspeccion,
                                (CASE WHEN p.otro_lugar IS NULL THEN 'N/A' WHEN p.otro_lugar = '0' THEN 'N/A' ELSE p.otro_lugar END)AS DetalleProspeccion,
                                (CASE WHEN ot.nombre IS NULL THEN 'N/D' ELSE ot.nombre END)AS PlazaVenta,
                                (CASE WHEN om.nombre IS NULL THEN 'N/D' ELSE om.nombre END)AS MedioPublicitario,
                                CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) as Asesor,
                                (CASE WHEN t2.id_rol = 3 THEN CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno) 
                                ELSE CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) END)as Gerencia, se.nombre AS Sede,
                                p.fecha_creacion as Fecha
                                FROM usuarios t1
                                INNER JOIN prospectos p ON t1.id_usuario = p.id_asesor
                                INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
                                INNER JOIN sedes se ON se.id_sede = p.id_sede 
                                LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                                LEFT JOIN sedes ot ON p.plaza_venta = ot.id_sede
                                LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                                WHERE (p.fecha_creacion BETWEEN '$current_year/01/01 00:00:00' AND '$current_year/12/31 23:59:59')
                                ORDER BY p.fecha_creacion");
    }

    function get_reporte_dir_general($tipo){
        $current_year = date("Y");
        return $this->db->query("SELECT p.id_prospecto AS Folio, (CASE WHEN p.tipo = 0 THEN 'Prospecto' ELSE 'Cliente' END) AS Tipo, YEAR(p.fecha_creacion) AS Año, 
                                (DATEPART(wk, p.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(DAY, p.fecha_creacion, GETDATE()) AS DiasEnProceso, 
                                DATENAME(MONTH, p.fecha_creacion) AS Mes,  
                                CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente,
                                (CASE WHEN p.correo IS NULL THEN 'N/D' ELSE p.correo END)AS Correo, p.telefono AS Telefono,
                                (CASE WHEN oc.nombre IS NULL THEN 'N/D' ELSE oc.nombre END)AS LugarProspeccion,
                                (CASE WHEN p.otro_lugar IS NULL THEN 'N/A' WHEN p.otro_lugar = '0' THEN 'N/A' ELSE p.otro_lugar END)AS DetalleProspeccion,
                                (CASE WHEN ot.nombre IS NULL THEN 'N/D' ELSE ot.nombre END)AS PlazaVenta,
                                (CASE WHEN om.nombre IS NULL THEN 'N/D' ELSE om.nombre END)AS MedioPublicitario,
                                CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) as Asesor,
                                (CASE WHEN t2.id_rol = 3 THEN CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno) 
                                ELSE CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) END)as Gerencia, se.nombre AS Sede,
                                p.fecha_creacion as Fecha
                                FROM usuarios t1
                                INNER JOIN prospectos p ON t1.id_usuario = p.id_asesor
                                INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
                                INNER JOIN sedes se ON se.id_sede = p.id_sede 
                                LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                                LEFT JOIN sedes ot ON p.plaza_venta = ot.id_sede
                                LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                                WHERE (p.fecha_creacion BETWEEN '$current_year/01/01 00:00:00' AND '$current_year/12/31 23:59:59') AND p.tipo = '$tipo'");
    }

    function get_reporte_dir1($fecha_ini, $fecha_fin, $tipo, $asesor){
        return $this->db->query("SELECT p.id_prospecto AS Folio, (CASE WHEN p.tipo = 0 THEN 'Prospecto' ELSE 'Cliente' END) AS Tipo, YEAR(p.fecha_creacion) AS Año, 
                                (DATEPART(wk, p.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(DAY, p.fecha_creacion, GETDATE()) AS DiasEnProceso, 
                                DATENAME(MONTH, p.fecha_creacion) AS Mes,  
                                CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente,
                                (CASE WHEN p.correo IS NULL THEN 'N/D' ELSE p.correo END)AS Correo, p.telefono AS Telefono,
                                (CASE WHEN oc.nombre IS NULL THEN 'N/D' ELSE oc.nombre END)AS LugarProspeccion,
                                (CASE WHEN p.otro_lugar IS NULL THEN 'N/A' WHEN p.otro_lugar = '0' THEN 'N/A' ELSE p.otro_lugar END)AS DetalleProspeccion,
                                (CASE WHEN ot.nombre IS NULL THEN 'N/D' ELSE ot.nombre END)AS PlazaVenta,
                                (CASE WHEN om.nombre IS NULL THEN 'N/D' ELSE om.nombre END)AS MedioPublicitario,
                                CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) as Asesor,
                                (CASE WHEN t2.id_rol = 3 THEN CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno) 
                                ELSE CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) END)as Gerencia, se.nombre AS Sede,
                                p.fecha_creacion as Fecha
                                FROM usuarios t1
                                INNER JOIN prospectos p ON t1.id_usuario = p.id_asesor
                                INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
                                INNER JOIN sedes se ON se.id_sede = p.id_sede 
                                LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                                LEFT JOIN sedes ot ON p.plaza_venta = ot.id_sede
                                LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                                WHERE t1.id_rol = 7 AND (p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59') AND (p.tipo = '$tipo' AND p.id_asesor = '$asesor')
                                ORDER BY p.fecha_creacion");
    }

    function get_reporte_dir2($fecha_ini, $fecha_fin, $tipo, $asesor){
        return $this->db->query("SELECT p.id_prospecto AS Folio, (CASE WHEN p.tipo = 0 THEN 'Prospecto' ELSE 'Cliente' END) AS Tipo, YEAR(p.fecha_creacion) AS Año, 
                                (DATEPART(wk, p.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(DAY, p.fecha_creacion, GETDATE()) AS DiasEnProceso, 
                                DATENAME(MONTH, p.fecha_creacion) AS Mes,  
                                CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente,
                                (CASE WHEN p.correo IS NULL THEN 'N/D' ELSE p.correo END)AS Correo, p.telefono AS Telefono,
                                (CASE WHEN oc.nombre IS NULL THEN 'N/D' ELSE oc.nombre END)AS LugarProspeccion,
                                (CASE WHEN p.otro_lugar IS NULL THEN 'N/A' WHEN p.otro_lugar = '0' THEN 'N/A' ELSE p.otro_lugar END)AS DetalleProspeccion,
                                (CASE WHEN ot.nombre IS NULL THEN 'N/D' ELSE ot.nombre END)AS PlazaVenta,
                                (CASE WHEN om.nombre IS NULL THEN 'N/D' ELSE om.nombre END)AS MedioPublicitario,
                                CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) as Asesor,
                                (CASE WHEN t2.id_rol = 3 THEN CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno) 
                                ELSE CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) END)as Gerencia, se.nombre AS Sede,
                                p.fecha_creacion as Fecha
                                FROM usuarios t1
                                INNER JOIN prospectos p ON t1.id_usuario = p.id_asesor
                                INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
                                INNER JOIN sedes se ON se.id_sede = p.id_sede 
                                LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                                LEFT JOIN sedes ot ON p.plaza_venta = ot.id_sede
                                LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                                WHERE t1.id_rol = 7 AND (p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59') AND (p.id_asesor = '$asesor')
                                ORDER BY p.fecha_creacion");
    }

    function get_total_subdir_byasis($user){
        $current_year = date("Y");
        $sedes = $this->session->userdata('id_sede');
        return $this->db->query("SELECT CASE WHEN MONTH(p.fecha_creacion) = 1 THEN 'Enero' WHEN MONTH(p.fecha_creacion) = 2 THEN 'Febrero' WHEN MONTH(p.fecha_creacion) = 3 THEN 'Marzo'
                                WHEN MONTH(p.fecha_creacion) = 4 THEN 'Abril' WHEN MONTH(p.fecha_creacion) = 5 THEN 'Mayo' WHEN MONTH(p.fecha_creacion) = 6 THEN 'Junio'
                                WHEN MONTH(p.fecha_creacion) = 7 THEN 'Julio' WHEN MONTH(p.fecha_creacion) = 8 THEN 'Agosto' WHEN MONTH(p.fecha_creacion) = 9 THEN 'Septiembre'
                                WHEN MONTH(p.fecha_creacion) = 10 THEN 'Octubre' WHEN MONTH(p.fecha_creacion) = 11 THEN 'Noviembre' WHEN MONTH(p.fecha_creacion) = 12 THEN 'Diciembre'
                                END mes, COUNT(p.id_prospecto) AS clientes FROM prospectos p
                                INNER JOIN usuarios s ON p.id_asesor = s.id_usuario
                                WHERE p.id_sede IN (SELECT value FROM usuarios CROSS APPLY STRING_SPLIT(id_sede, ',') WHERE id_usuario = $user) AND
                                (p.fecha_creacion BETWEEN '$current_year/01/01 00:00:00' AND '$current_year/12/31 23:59:59') AND tipo = 0  
                                GROUP BY MONTH(p.fecha_creacion)
                                ORDER BY MONTH(p.fecha_creacion) ASC");
    }

    function get_total_subdir($user){
        $current_year = date("Y");
//        $sedes = $this->session->userdata('id_sede');
        return $this->db->query("SELECT CASE WHEN MONTH(p.fecha_creacion) = 1 THEN 'Enero' WHEN MONTH(p.fecha_creacion) = 2 THEN 'Febrero' WHEN MONTH(p.fecha_creacion) = 3 THEN 'Marzo'
                                WHEN MONTH(p.fecha_creacion) = 4 THEN 'Abril' WHEN MONTH(p.fecha_creacion) = 5 THEN 'Mayo' WHEN MONTH(p.fecha_creacion) = 6 THEN 'Junio'
                                WHEN MONTH(p.fecha_creacion) = 7 THEN 'Julio' WHEN MONTH(p.fecha_creacion) = 8 THEN 'Agosto' WHEN MONTH(p.fecha_creacion) = 9 THEN 'Septiembre'
                                WHEN MONTH(p.fecha_creacion) = 10 THEN 'Octubre' WHEN MONTH(p.fecha_creacion) = 11 THEN 'Noviembre' WHEN MONTH(p.fecha_creacion) = 12 THEN 'Diciembre'
                                END mes, COUNT(p.id_prospecto) AS clientes FROM prospectos p
                                INNER JOIN usuarios s ON p.id_asesor = s.id_usuario
                                WHERE p.id_sede IN (SELECT value FROM usuarios CROSS APPLY STRING_SPLIT(id_sede, ',') WHERE id_usuario = $user) AND
                                (p.fecha_creacion BETWEEN '$current_year/01/01 00:00:00' AND '$current_year/12/31 23:59:59') AND tipo = 0  
                                GROUP BY MONTH(p.fecha_creacion)
                                ORDER BY MONTH(p.fecha_creacion) ASC");
    }

    function get_total_subdir1($subdir, $fecha_ini, $fecha_fin, $tipo){
        return $this->db->query("SELECT CASE WHEN MONTH(p.fecha_creacion) = 1 THEN 'Enero' WHEN MONTH(p.fecha_creacion) = 2 THEN 'Febrero' WHEN MONTH(p.fecha_creacion) = 3 THEN 'Marzo'
                                WHEN MONTH(p.fecha_creacion) = 4 THEN 'Abril' WHEN MONTH(p.fecha_creacion) = 5 THEN 'Mayo' WHEN MONTH(p.fecha_creacion) = 6 THEN 'Junio'
                                WHEN MONTH(p.fecha_creacion) = 7 THEN 'Julio' WHEN MONTH(p.fecha_creacion) = 8 THEN 'Agosto' WHEN MONTH(p.fecha_creacion) = 9 THEN 'Septiembre'
                                WHEN MONTH(p.fecha_creacion) = 10 THEN 'Octubre' WHEN MONTH(p.fecha_creacion) = 11 THEN 'Noviembre' WHEN MONTH(p.fecha_creacion) = 12 THEN 'Diciembre'
                                END mes, COUNT(*) AS clientes FROM prospectos p
                                INNER JOIN usuarios s ON p.id_asesor = s.id_usuario WHERE p.id_sede IN
                                (SELECT value FROM usuarios CROSS APPLY STRING_SPLIT(id_sede, ',') WHERE id_usuario = $subdir) AND
                                (p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59') AND tipo = $tipo
                                GROUP BY MONTH(p.fecha_creacion)
                                ORDER BY MONTH(p.fecha_creacion) ASC");
    }

    function get_total_subdir2($subdir, $fecha_ini, $fecha_fin){
        return $this->db->query("SELECT CASE WHEN MONTH(p.fecha_creacion) = 1 THEN 'Enero' WHEN MONTH(p.fecha_creacion) = 2 THEN 'Febrero' WHEN MONTH(p.fecha_creacion) = 3 THEN 'Marzo'
                                WHEN MONTH(p.fecha_creacion) = 4 THEN 'Abril' WHEN MONTH(p.fecha_creacion) = 5 THEN 'Mayo' WHEN MONTH(p.fecha_creacion) = 6 THEN 'Junio'
                                WHEN MONTH(p.fecha_creacion) = 7 THEN 'Julio' WHEN MONTH(p.fecha_creacion) = 8 THEN 'Agosto' WHEN MONTH(p.fecha_creacion) = 9 THEN 'Septiembre'
                                WHEN MONTH(p.fecha_creacion) = 10 THEN 'Octubre' WHEN MONTH(p.fecha_creacion) = 11 THEN 'Noviembre' WHEN MONTH(p.fecha_creacion) = 12 THEN 'Diciembre'
                                END mes, COUNT(*) AS clientes FROM prospectos p
                                INNER JOIN usuarios s ON p.id_asesor = s.id_usuario WHERE p.id_sede IN
                                (SELECT value FROM usuarios CROSS APPLY STRING_SPLIT(id_sede, ',') WHERE id_usuario = $subdir) AND
                                (p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
                                GROUP BY MONTH(p.fecha_creacion)
                                ORDER BY MONTH(p.fecha_creacion) ASC");
    }

    function get_reporte_subdir_byasis($user){
        $current_year = date("Y");
        return $this->db->query("SELECT p.id_prospecto AS Folio, (CASE WHEN p.tipo = 0 THEN 'Prospecto' ELSE 'Cliente' END) AS Tipo, YEAR(p.fecha_creacion) AS Año, 
                                (DATEPART(wk, p.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(DAY, p.fecha_creacion, GETDATE()) AS DiasEnProceso, 
                                DATENAME(MONTH, p.fecha_creacion) AS Mes,  
                                CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente,
                                (CASE WHEN p.correo IS NULL THEN 'N/D' ELSE p.correo END)AS Correo, p.telefono AS Telefono,
                                (CASE WHEN oc.nombre IS NULL THEN 'N/D' ELSE oc.nombre END)AS LugarProspeccion,
                                (CASE WHEN p.otro_lugar IS NULL THEN 'N/A' WHEN p.otro_lugar = '0' THEN 'N/A' ELSE p.otro_lugar END)AS DetalleProspeccion,
                                (CASE WHEN ot.nombre IS NULL THEN 'N/D' ELSE ot.nombre END)AS PlazaVenta,
                                (CASE WHEN om.nombre IS NULL THEN 'N/D' ELSE om.nombre END)AS MedioPublicitario,
                                CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) as Asesor,
                                (CASE WHEN t2.id_rol = 3 THEN CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno) 
                                ELSE CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) END)as Gerencia, se.nombre AS Sede,
                                p.fecha_creacion as Fecha
                                FROM usuarios t1
                                INNER JOIN prospectos p ON t1.id_usuario = p.id_asesor
                                INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
                                INNER JOIN sedes se ON se.id_sede = p.id_sede 
                                LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                                LEFT JOIN sedes ot ON p.plaza_venta = ot.id_sede
                                LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                                WHERE p.id_sede IN (SELECT value FROM usuarios CROSS APPLY STRING_SPLIT(id_sede, ',') WHERE id_usuario = $user) 
                                AND (p.fecha_creacion BETWEEN '$current_year/01/01 00:00:00' AND '$current_year/12/31 23:59:59')
                                ORDER BY p.fecha_creacion");
    }

    function get_reporte_subdir_byasisgeneral($user, $tipo){
        $current_year = date("Y");
        $sedes = $this->session->userdata('id_sede');
        return $this->db->query("SELECT p.id_prospecto AS Folio, (CASE WHEN p.tipo = 0 THEN 'Prospecto' ELSE 'Cliente' END) AS Tipo, YEAR(p.fecha_creacion) AS Año, 
                                (DATEPART(wk, p.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(DAY, p.fecha_creacion, GETDATE()) AS DiasEnProceso, 
                                DATENAME(MONTH, p.fecha_creacion) AS Mes,  
                                CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente,
                                (CASE WHEN p.correo IS NULL THEN 'N/D' ELSE p.correo END)AS Correo, p.telefono AS Telefono,
                                (CASE WHEN oc.nombre IS NULL THEN 'N/D' ELSE oc.nombre END)AS LugarProspeccion,
                                (CASE WHEN p.otro_lugar IS NULL THEN 'N/A' WHEN p.otro_lugar = '0' THEN 'N/A' ELSE p.otro_lugar END)AS DetalleProspeccion,
                                (CASE WHEN ot.nombre IS NULL THEN 'N/D' ELSE ot.nombre END)AS PlazaVenta,
                                (CASE WHEN om.nombre IS NULL THEN 'N/D' ELSE om.nombre END)AS MedioPublicitario,
                                CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) as Asesor,
                                (CASE WHEN t2.id_rol = 3 THEN CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno) 
                                ELSE CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) END)as Gerencia, se.nombre AS Sede,
                                p.fecha_creacion as Fecha
                                FROM usuarios t1
                                INNER JOIN prospectos p ON t1.id_usuario = p.id_asesor
                                INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
                                INNER JOIN sedes se ON se.id_sede = p.id_sede 
                                LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                                LEFT JOIN sedes ot ON p.plaza_venta = ot.id_sede
                                LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                                WHERE p.id_sede IN ($sedes) AND p.tipo = $tipo AND (p.fecha_creacion BETWEEN '$current_year/01/01 00:00:00' AND '$current_year/12/31 23:59:59')
                                ORDER BY p.fecha_creacion");
    }

    function get_reporte_subdir1($user, $fecha_ini, $fecha_fin, $tipo, $asesor){
        return $this->db->query("SELECT p.id_prospecto AS Folio, (CASE WHEN p.tipo = 0 THEN 'Prospecto' ELSE 'Cliente' END) AS Tipo, YEAR(p.fecha_creacion) AS Año, 
                                (DATEPART(wk, p.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(DAY, p.fecha_creacion, GETDATE()) AS DiasEnProceso, 
                                DATENAME(MONTH, p.fecha_creacion) AS Mes,  
                                CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente,
                                (CASE WHEN p.correo IS NULL THEN 'N/D' ELSE p.correo END)AS Correo, p.telefono AS Telefono,
                                (CASE WHEN oc.nombre IS NULL THEN 'N/D' ELSE oc.nombre END)AS LugarProspeccion,
                                (CASE WHEN p.otro_lugar IS NULL THEN 'N/A' WHEN p.otro_lugar = '0' THEN 'N/A' ELSE p.otro_lugar END)AS DetalleProspeccion,
                                (CASE WHEN ot.nombre IS NULL THEN 'N/D' ELSE ot.nombre END)AS PlazaVenta,
                                (CASE WHEN om.nombre IS NULL THEN 'N/D' ELSE om.nombre END)AS MedioPublicitario,
                                CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) as Asesor,
                                (CASE WHEN t2.id_rol = 3 THEN CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno) 
                                ELSE CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) END)as Gerencia, se.nombre AS Sede,
                                p.fecha_creacion as Fecha
                                FROM usuarios t1
                                INNER JOIN prospectos p ON t1.id_usuario = p.id_asesor
                                INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
                                INNER JOIN sedes se ON se.id_sede = p.id_sede 
                                LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                                LEFT JOIN sedes ot ON p.plaza_venta = ot.id_sede
                                LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                                WHERE (p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59') AND (p.tipo = '$tipo' AND p.id_asesor = '$asesor')
                                AND p.id_sede IN (SELECT value FROM usuarios CROSS APPLY STRING_SPLIT(id_sede, ',') WHERE id_usuario = $user)
                                ORDER BY p.fecha_creacion");
    }

    function get_reporte_subdir_byasis2($user, $fecha_ini, $fecha_fin, $tipo, $asesor){
        return $this->db->query("SELECT p.id_prospecto AS Folio, (CASE WHEN p.tipo = 0 THEN 'Prospecto' ELSE 'Cliente' END) AS Tipo, YEAR(p.fecha_creacion) AS Año, 
                                (DATEPART(wk, p.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(DAY, p.fecha_creacion, GETDATE()) AS DiasEnProceso, 
                                DATENAME(MONTH, p.fecha_creacion) AS Mes,  
                                CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente,
                                (CASE WHEN p.correo IS NULL THEN 'N/D' ELSE p.correo END)AS Correo, p.telefono AS Telefono,
                                (CASE WHEN oc.nombre IS NULL THEN 'N/D' ELSE oc.nombre END)AS LugarProspeccion,
                                (CASE WHEN p.otro_lugar IS NULL THEN 'N/A' WHEN p.otro_lugar = '0' THEN 'N/A' ELSE p.otro_lugar END)AS DetalleProspeccion,
                                (CASE WHEN ot.nombre IS NULL THEN 'N/D' ELSE ot.nombre END)AS PlazaVenta,
                                (CASE WHEN om.nombre IS NULL THEN 'N/D' ELSE om.nombre END)AS MedioPublicitario,
                                CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) as Asesor,
                                (CASE WHEN t2.id_rol = 3 THEN CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno) 
                                ELSE CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) END)as Gerencia, se.nombre AS Sede,
                                p.fecha_creacion as Fecha
                                FROM usuarios t1
                                INNER JOIN prospectos p ON t1.id_usuario = p.id_asesor
                                INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
                                INNER JOIN sedes se ON se.id_sede = p.id_sede 
                                LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                                LEFT JOIN sedes ot ON p.plaza_venta = ot.id_sede
                                LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                                WHERE p.id_sede IN (SELECT value FROM usuarios CROSS APPLY STRING_SPLIT(id_sede, ',') WHERE id_usuario = '$user')
                                AND (p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59') AND (p.id_asesor = '$asesor') ORDER BY p.fecha_creacion");
    }

    function get_reporte_subdir($user){
        $current_year = date("Y");
        return $this->db->query("SELECT p.id_prospecto AS Folio, (CASE WHEN p.tipo = 0 THEN 'Prospecto' ELSE 'Cliente' END) AS Tipo, YEAR(p.fecha_creacion) AS Año, 
                                (DATEPART(wk, p.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(DAY, p.fecha_creacion, GETDATE()) AS DiasEnProceso, 
                                DATENAME(MONTH, p.fecha_creacion) AS Mes,  
                                CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente,
                                (CASE WHEN p.correo IS NULL THEN 'N/D' ELSE p.correo END)AS Correo, p.telefono AS Telefono,
                                (CASE WHEN oc.nombre IS NULL THEN 'N/D' ELSE oc.nombre END)AS LugarProspeccion,
                                (CASE WHEN p.otro_lugar IS NULL THEN 'N/A' WHEN p.otro_lugar = '0' THEN 'N/A' ELSE p.otro_lugar END)AS DetalleProspeccion,
                                (CASE WHEN ot.nombre IS NULL THEN 'N/D' ELSE ot.nombre END)AS PlazaVenta,
                                (CASE WHEN om.nombre IS NULL THEN 'N/D' ELSE om.nombre END)AS MedioPublicitario,
                                CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) as Asesor,
                                (CASE WHEN t2.id_rol = 3 THEN CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno) 
                                ELSE CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) END)as Gerencia, se.nombre AS Sede,
                                p.fecha_creacion as Fecha
                                FROM usuarios t1
                                INNER JOIN prospectos p ON t1.id_usuario = p.id_asesor
                                INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
                                INNER JOIN sedes se ON se.id_sede = p.id_sede 
                                LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                                LEFT JOIN sedes ot ON p.plaza_venta = ot.id_sede
                                LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                                WHERE p.id_sede IN (SELECT value FROM usuarios CROSS APPLY STRING_SPLIT(id_sede, ',') WHERE id_usuario = $user) 
                                AND (p.fecha_creacion BETWEEN '$current_year/01/01 00:00:00' AND '$current_year/12/31 23:59:59')
                                ORDER BY p.fecha_creacion");
    }

    function get_reporte_subdir_general($user, $tipo){
        $current_year = date("Y");
        $sedes = $this->session->userdata('id_sede') ;
        return $this->db->query("SELECT p.id_prospecto AS Folio, (CASE WHEN p.tipo = 0 THEN 'Prospecto' ELSE 'Cliente' END) AS Tipo, YEAR(p.fecha_creacion) AS Año, 
                                (DATEPART(wk, p.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(DAY, p.fecha_creacion, GETDATE()) AS DiasEnProceso, 
                                DATENAME(MONTH, p.fecha_creacion) AS Mes,  
                                CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente,
                                (CASE WHEN p.correo IS NULL THEN 'N/D' ELSE p.correo END)AS Correo, p.telefono AS Telefono,
                                (CASE WHEN oc.nombre IS NULL THEN 'N/D' ELSE oc.nombre END)AS LugarProspeccion,
                                (CASE WHEN p.otro_lugar IS NULL THEN 'N/A' WHEN p.otro_lugar = '0' THEN 'N/A' ELSE p.otro_lugar END)AS DetalleProspeccion,
                                (CASE WHEN ot.nombre IS NULL THEN 'N/D' ELSE ot.nombre END)AS PlazaVenta,
                                (CASE WHEN om.nombre IS NULL THEN 'N/D' ELSE om.nombre END)AS MedioPublicitario,
                                CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) as Asesor,
                                (CASE WHEN t2.id_rol = 3 THEN CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno) 
                                ELSE CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) END)as Gerencia, se.nombre AS Sede,
                                p.fecha_creacion as Fecha
                                FROM usuarios t1
                                INNER JOIN prospectos p ON t1.id_usuario = p.id_asesor
                                INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
                                INNER JOIN sedes se ON se.id_sede = p.id_sede 
                                LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                                LEFT JOIN sedes ot ON p.plaza_venta = ot.id_sede
                                LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                                WHERE p.id_sede IN ($sedes) AND p.tipo = '$tipo' AND (p.fecha_creacion BETWEEN '$current_year/01/01 00:00:00' AND '$current_year/12/31 23:59:59')
                                ORDER BY p.fecha_creacion");
    }

    function get_repo_dir_bysub($subdir, $fecha_ini, $fecha_fin){
        $current_year = date("Y");
        return $this->db->query("SELECT p.id_prospecto AS Folio, (CASE WHEN p.tipo = 0 THEN 'Prospecto' ELSE 'Cliente' END) AS Tipo, YEAR(p.fecha_creacion) AS Año, 
                                (DATEPART(wk, p.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(DAY, p.fecha_creacion, GETDATE()) AS DiasEnProceso, 
                                DATENAME(MONTH, p.fecha_creacion) AS Mes,  
                                CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente,
                                (CASE WHEN p.correo IS NULL THEN 'N/D' ELSE p.correo END)AS Correo, p.telefono AS Telefono,
                                (CASE WHEN oc.nombre IS NULL THEN 'N/D' ELSE oc.nombre END)AS LugarProspeccion,
                                (CASE WHEN p.otro_lugar IS NULL THEN 'N/A' WHEN p.otro_lugar = '0' THEN 'N/A' ELSE p.otro_lugar END)AS DetalleProspeccion,
                                (CASE WHEN ot.nombre IS NULL THEN 'N/D' ELSE ot.nombre END)AS PlazaVenta,
                                (CASE WHEN om.nombre IS NULL THEN 'N/D' ELSE om.nombre END)AS MedioPublicitario,
                                CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) as Asesor,
                                (CASE WHEN t2.id_rol = 3 THEN CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno) 
                                ELSE CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) END)as Gerencia, se.nombre AS Sede,
                                p.fecha_creacion as Fecha
                                FROM usuarios t1
                                INNER JOIN prospectos p ON t1.id_usuario = p.id_asesor
                                INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
                                INNER JOIN sedes se ON se.id_sede = p.id_sede 
                                LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                                LEFT JOIN sedes ot ON p.plaza_venta = ot.id_sede
                                LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                                WHERE p.id_sede IN (SELECT id_sede FROM usuarios WHERE id_usuario = '$subdir')
                                AND (p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
                                ORDER BY p.fecha_creacion");
    }

    function get_repo_dir_bysub1($subdir, $fecha_ini, $fecha_fin, $tipo){
        $current_year = date("Y");
        return $this->db->query("SELECT p.id_prospecto AS Folio, (CASE WHEN p.tipo = 0 THEN 'Prospecto' ELSE 'Cliente' END) AS Tipo, YEAR(p.fecha_creacion) AS Año, 
                                (DATEPART(wk, p.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(DAY, p.fecha_creacion, GETDATE()) AS DiasEnProceso, 
                                DATENAME(MONTH, p.fecha_creacion) AS Mes,  
                                CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente,
                                (CASE WHEN p.correo IS NULL THEN 'N/D' ELSE p.correo END)AS Correo, p.telefono AS Telefono,
                                (CASE WHEN oc.nombre IS NULL THEN 'N/D' ELSE oc.nombre END)AS LugarProspeccion,
                                (CASE WHEN p.otro_lugar IS NULL THEN 'N/A' WHEN p.otro_lugar = '0' THEN 'N/A' ELSE p.otro_lugar END)AS DetalleProspeccion,
                                (CASE WHEN ot.nombre IS NULL THEN 'N/D' ELSE ot.nombre END)AS PlazaVenta,
                                (CASE WHEN om.nombre IS NULL THEN 'N/D' ELSE om.nombre END)AS MedioPublicitario,
                                CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) as Asesor,
                                (CASE WHEN t2.id_rol = 3 THEN CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno) 
                                ELSE CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) END)as Gerencia, se.nombre AS Sede,
                                p.fecha_creacion as Fecha
                                FROM usuarios t1
                                INNER JOIN prospectos p ON t1.id_usuario = p.id_asesor
                                INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
                                INNER JOIN sedes se ON se.id_sede = p.id_sede 
                                LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                                LEFT JOIN sedes ot ON p.plaza_venta = ot.id_sede
                                LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                                WHERE p.id_sede IN (SELECT id_sede FROM usuarios WHERE id_usuario = '$subdir')
                                AND (p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
                                AND p.tipo = '$tipo' ORDER BY p.fecha_creacion");
    }

    function get_repo_dir_all($tipo, $fecha_ini, $fecha_fin){
        return $this->db->query("SELECT p.id_prospecto AS Folio, (CASE WHEN p.tipo = 0 THEN 'Prospecto' ELSE 'Cliente' END) AS Tipo, YEAR(p.fecha_creacion) AS Año, 
                                (DATEPART(wk, p.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(DAY, p.fecha_creacion, GETDATE()) AS DiasEnProceso, 
                                DATENAME(MONTH, p.fecha_creacion) AS Mes,  
                                CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente,
                                (CASE WHEN p.correo IS NULL THEN 'N/D' ELSE p.correo END)AS Correo, p.telefono AS Telefono,
                                (CASE WHEN oc.nombre IS NULL THEN 'N/D' ELSE oc.nombre END)AS LugarProspeccion,
                                (CASE WHEN p.otro_lugar IS NULL THEN 'N/A' WHEN p.otro_lugar = '0' THEN 'N/A' ELSE p.otro_lugar END)AS DetalleProspeccion,
                                (CASE WHEN ot.nombre IS NULL THEN 'N/D' ELSE ot.nombre END)AS PlazaVenta,
                                (CASE WHEN om.nombre IS NULL THEN 'N/D' ELSE om.nombre END)AS MedioPublicitario,
                                CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) as Asesor,
                                (CASE WHEN t2.id_rol = 3 THEN CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno) 
                                ELSE CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) END)as Gerencia, se.nombre AS Sede,
                                p.fecha_creacion as Fecha
                                FROM usuarios t1
                                INNER JOIN prospectos p ON t1.id_usuario = p.id_asesor
                                INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
                                INNER JOIN sedes se ON se.id_sede = p.id_sede 
                                LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                                LEFT JOIN sedes ot ON p.plaza_venta = ot.id_sede
                                LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                                WHERE p.tipo = '$tipo' AND (p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
                                ORDER BY p.fecha_creacion");
    }

    function get_repo_dirall($fecha_ini, $fecha_fin){

        return $this->db->query("SELECT p.id_prospecto AS Folio, (CASE WHEN p.tipo = 0 THEN 'Prospecto' ELSE 'Cliente' END) AS Tipo, YEAR(p.fecha_creacion) AS Año, 
                                (DATEPART(wk, p.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(DAY, p.fecha_creacion, GETDATE()) AS DiasEnProceso, 
                                DATENAME(MONTH, p.fecha_creacion) AS Mes,  
                                CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente,
                                (CASE WHEN p.correo IS NULL THEN 'N/D' ELSE p.correo END)AS Correo, p.telefono AS Telefono,
                                (CASE WHEN oc.nombre IS NULL THEN 'N/D' ELSE oc.nombre END)AS LugarProspeccion,
                                (CASE WHEN p.otro_lugar IS NULL THEN 'N/A' WHEN p.otro_lugar = '0' THEN 'N/A' ELSE p.otro_lugar END)AS DetalleProspeccion,
                                (CASE WHEN ot.nombre IS NULL THEN 'N/D' ELSE ot.nombre END)AS PlazaVenta,
                                (CASE WHEN om.nombre IS NULL THEN 'N/D' ELSE om.nombre END)AS MedioPublicitario,
                                CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) as Asesor,
                                (CASE WHEN t2.id_rol = 3 THEN CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno) 
                                ELSE CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) END)as Gerencia, se.nombre AS Sede,
                                p.fecha_creacion as Fecha
                                FROM usuarios t1
                                INNER JOIN prospectos p ON t1.id_usuario = p.id_asesor
                                INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
                                INNER JOIN sedes se ON se.id_sede = p.id_sede 
                                LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                                LEFT JOIN sedes ot ON p.plaza_venta = ot.id_sede
                                LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                                WHERE (p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
                                ORDER BY p.fecha_creacion");
    }

    function get_reporte_subdir_byasis1($user, $fecha_ini, $fecha_fin, $tipo, $asesor){
        return $this->db->query("SELECT p.id_prospecto AS Folio, (CASE WHEN p.tipo = 0 THEN 'Prospecto' ELSE 'Cliente' END) AS Tipo, YEAR(p.fecha_creacion) AS Año, 
                                (DATEPART(wk, p.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(DAY, p.fecha_creacion, GETDATE()) AS DiasEnProceso, 
                                DATENAME(MONTH, p.fecha_creacion) AS Mes,  
                                CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente,
                                (CASE WHEN p.correo IS NULL THEN 'N/D' ELSE p.correo END)AS Correo, p.telefono AS Telefono,
                                (CASE WHEN oc.nombre IS NULL THEN 'N/D' ELSE oc.nombre END)AS LugarProspeccion,
                                (CASE WHEN p.otro_lugar IS NULL THEN 'N/A' WHEN p.otro_lugar = '0' THEN 'N/A' ELSE p.otro_lugar END)AS DetalleProspeccion,
                                (CASE WHEN ot.nombre IS NULL THEN 'N/D' ELSE ot.nombre END)AS PlazaVenta,
                                (CASE WHEN om.nombre IS NULL THEN 'N/D' ELSE om.nombre END)AS MedioPublicitario,
                                CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) as Asesor,
                                (CASE WHEN t2.id_rol = 3 THEN CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno) 
                                ELSE CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) END)as Gerencia, se.nombre AS Sede,
                                p.fecha_creacion as Fecha
                                FROM usuarios t1
                                INNER JOIN prospectos p ON t1.id_usuario = p.id_asesor
                                INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
                                INNER JOIN sedes se ON se.id_sede = p.id_sede 
                                LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                                LEFT JOIN sedes ot ON p.plaza_venta = ot.id_sede
                                LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                                WHERE (p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59') AND (p.tipo = '$tipo' AND p.id_asesor = '$asesor')
                                AND p.id_sede IN (SELECT value FROM usuarios CROSS APPLY STRING_SPLIT(id_sede, ',') WHERE id_usuario = $user)
                                ORDER BY p.fecha_creacion");
    }

    function get_reporte_subdir2($user, $fecha_ini, $fecha_fin, $tipo, $asesor){
        return $this->db->query("SELECT p.id_prospecto AS Folio, (CASE WHEN p.tipo = 0 THEN 'Prospecto' ELSE 'Cliente' END) AS Tipo, YEAR(p.fecha_creacion) AS Año, 
                                (DATEPART(wk, p.fecha_creacion) + 1) AS SemanaCalendario, DATEDIFF(DAY, p.fecha_creacion, GETDATE()) AS DiasEnProceso, 
                                DATENAME(MONTH, p.fecha_creacion) AS Mes,  
                                CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente,
                                (CASE WHEN p.correo IS NULL THEN 'N/D' ELSE p.correo END)AS Correo, p.telefono AS Telefono,
                                (CASE WHEN oc.nombre IS NULL THEN 'N/D' ELSE oc.nombre END)AS LugarProspeccion,
                                (CASE WHEN p.otro_lugar IS NULL THEN 'N/A' WHEN p.otro_lugar = '0' THEN 'N/A' ELSE p.otro_lugar END)AS DetalleProspeccion,
                                (CASE WHEN ot.nombre IS NULL THEN 'N/D' ELSE ot.nombre END)AS PlazaVenta,
                                (CASE WHEN om.nombre IS NULL THEN 'N/D' ELSE om.nombre END)AS MedioPublicitario,
                                CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) as Asesor,
                                (CASE WHEN t2.id_rol = 3 THEN CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno) 
                                ELSE CONCAT(t1.nombre, ' ', t1.apellido_paterno, ' ', t1.apellido_materno) END)as Gerencia, se.nombre AS Sede,
                                p.fecha_creacion as Fecha
                                FROM usuarios t1
                                INNER JOIN prospectos p ON t1.id_usuario = p.id_asesor
                                INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
                                INNER JOIN sedes se ON se.id_sede = p.id_sede 
                                LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
                                LEFT JOIN sedes ot ON p.plaza_venta = ot.id_sede
                                LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
                                WHERE (p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59') AND (p.id_asesor = '$asesor') 
                                AND p.id_sede IN (SELECT id_sede FROM usuarios WHERE id_usuario = $user)
                                ORDER BY MONTH(p.fecha_creacion)");
    }

    function getSubdirectories(){
        return $this->db->query("SELECT id_usuario, CONCAT(nombre, ' ', apellido_paterno, ' ', ISNULL(apellido_materno, '')) nombre, id_sede FROM usuarios WHERE 
                                id_rol = 2 AND estatus = 1 ORDER BY nombre");
    }

    function get_all_places(){
        return $this->db->query("SELECT  lugar_prospeccion, (CASE WHEN lugar_prospeccion = 1 THEN 'Call Picker' WHEN lugar_prospeccion = 2 THEN 'Correo electrónico' WHEN lugar_prospeccion = 3 THEN 'Evento (especificar)' WHEN lugar_prospeccion = 5 THEN 'Facebook (chat)' WHEN lugar_prospeccion = 6 THEN 'MKT digital (especificar)' WHEN lugar_prospeccion = 7 THEN 'Otro (especificar)' WHEN lugar_prospeccion = 8 THEN 'Página web (chat)' WHEN lugar_prospeccion = 9 THEN 'Pase (especificar)' WHEN lugar_prospeccion = 10 THEN 'Visita a empresas (especificar)' END) AS lugares FROM prospectos  GROUP BY lugar_prospeccion ORDER BY lugares;");
    }

    function get_total_lp(){
        $current_year = date("Y");
        return $this->db->query("SELECT CONCAT(UCASE(LEFT(MONTHNAME(p.fecha_creacion),1)),SUBSTRING(MONTHNAME(p.fecha_creacion),2)) AS mes,
        COUNT(p.id_cliente) AS clientes FROM prospectos c WHERE (p.fecha_creacion BETWEEN '$current_year/01/01 00:00:00' 
        AND '$current_year/12/31 23:59:59') GROUP BY mes ORDER BY MONTH(p.fecha_creacion);");
    }

    function get_chartlp($sede, $lugar, $fecha_ini, $fecha_fin){ // todos los filtros
        return $this->db->query("SELECT CONCAT(UCASE(LEFT(MONTHNAME(p.fecha_creacion),1)),SUBSTRING(MONTHNAME(p.fecha_creacion),2)) AS mes, 
        COUNT(p.id_cliente) AS clientes FROM prospectos p WHERE (p.id_sede = '$sede' AND p.lugar_prospeccion = '$lugar') 
        AND p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59'  GROUP BY mes ORDER BY MONTH(p.fecha_creacion)");
    }

    function get_chartlp5($fecha_ini, $fecha_fin){ // lugar prosp. todos, sedes todas
        return $this->db->query("SELECT CONCAT(UCASE(LEFT(MONTHNAME(p.fecha_creacion),1)),SUBSTRING(MONTHNAME(p.fecha_creacion),2)) AS mes, 
        COUNT(p.id_cliente) AS clientes FROM prospectos p WHERE 
        p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59'  GROUP BY mes ORDER BY MONTH(p.fecha_creacion)");
    }

    function get_chartlp4($lugar, $fecha_ini, $fecha_fin){ //sede = todos, lugar prosp. específico
        return $this->db->query("SELECT CONCAT(UCASE(LEFT(MONTHNAME(p.fecha_creacion),1)),SUBSTRING(MONTHNAME(p.fecha_creacion),2)) AS mes, 
        COUNT(p.id_cliente) AS clientes FROM prospectos p WHERE (p.lugar_prospeccion = '$lugar') 
        AND p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59'  GROUP BY mes ORDER BY MONTH(p.fecha_creacion)");
    }

    function get_chartlp1($sede, $lugar, $fecha_ini, $fecha_fin){
        return $this->db->query("SELECT CONCAT(UCASE(LEFT(MONTHNAME(p.fecha_creacion),1)),SUBSTRING(MONTHNAME(p.fecha_creacion),2)) AS mes, 
        COUNT(p.id_cliente) AS clientes FROM prospectos p WHERE (p.id_sede = '$sede' AND lugar_prospeccion = '$lugar') 
        AND p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59'  GROUP BY mes ORDER BY MONTH(p.fecha_creacion)");
    }

    function get_chartlp6($sede, $fecha_ini, $fecha_fin){ //sede especifica, lugar prosp. todos
        return $this->db->query("SELECT CONCAT(UCASE(LEFT(MONTHNAME(p.fecha_creacion),1)),SUBSTRING(MONTHNAME(p.fecha_creacion),2)) AS mes, 
        COUNT(p.id_cliente) AS clientes FROM prospectos p WHERE (p.id_sede = '$sede') 
        AND p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59'  
        GROUP BY mes ORDER BY MONTH(p.fecha_creacion)");
    }

    function get_chartlp3($sede, $fecha_ini, $fecha_fin){ // todos los filtros, lugar prosp. todos
        return $this->db->query("SELECT CONCAT(UCASE(LEFT(MONTHNAME(p.fecha_creacion),1)),SUBSTRING(MONTHNAME(p.fecha_creacion),2)) AS mes, 
        COUNT(p.id_cliente) AS clientes FROM prospectos p WHERE (p.id_sede = '$sede') 
        AND p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59'  GROUP BY mes ORDER BY MONTH(p.fecha_creacion)");
    }

    function get_report_lp($sede, $lugar, $fecha_ini, $fecha_fin){ // todos los filtros
        return $this->db->query("SELECT p.id_cliente AS Folio, IF(p.tipo = 0, 'Prospecto', 'Cliente') AS Tipo, 
        DATEDIFF(CURDATE(), p.fecha_creacion) 
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(p.fecha_creacion),1)),SUBSTRING(MONTHNAME(p.fecha_creacion),2)) 
        AS Mes,  CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente, 
        IF(p.correo IS NULL, 'No especificado', p.correo) AS Correo, 
        p.telefono AS Telefono, 
        IF(p.telefono_2 IS NULL, 'No especificado', p.telefono_2) AS Telefono_2, 
        IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
        IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
        CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno) as Asesor,
        IF(t2.id_rol = 3, CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno), CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno))
        AS Gerencia, se.nombre AS Sede, p.fecha_creacion as Fecha,
        IFNULL(GROUP_CONCAT(o.observacion ORDER BY o.fecha_creacion SEPARATOR '   |   '), 'Sin comentarios') AS comentarios
        FROM prospectos p INNER JOIN usuarios s ON p.id_asesor = s.id_usuario
        INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
        INNER JOIN sedes se ON se.id_sede = p.id_sede 
        LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
        LEFT JOIN sedes ot ON p.territorio_venta = ot.id_opcion AND ot.id_sede
        LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
        LEFT JOIN observaciones o ON (p.id_cliente = o.id_cliente)
        WHERE (p.id_sede = '$sede' AND p.lugar_prospeccion = '$lugar')
        AND (p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
        AND oc.id_opcion = 6
        GROUP BY p.id_cliente ORDER BY p.fecha_creacion");
    }

    function get_report_lp1($sede, $lugar, $fecha_ini, $fecha_fin){ //reporte con lugar y sede especificos
        return $this->db->query("SELECT p.id_cliente AS Folio, IF(p.tipo = 0, 'Prospecto', 'Cliente') AS Tipo, 
        DATEDIFF(CURDATE(), p.fecha_creacion) 
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(p.fecha_creacion),1)),SUBSTRING(MONTHNAME(p.fecha_creacion),2)) 
        AS Mes,  CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente, 
        IF(p.correo IS NULL, 'No especificado', p.correo) AS Correo, 
        p.telefono AS Telefono, 
        IF(p.telefono_2 IS NULL, 'No especificado', p.telefono_2) AS Telefono_2, 
        IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
        IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
        CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno) as Asesor,
        IF(t2.id_rol = 3, CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno), CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno))
        AS Gerencia, se.nombre AS Sede, p.fecha_creacion as Fecha,
        IFNULL(GROUP_CONCAT(o.observacion ORDER BY o.fecha_creacion SEPARATOR '   |   '), 'Sin comentarios') AS comentarios
        FROM prospectos p INNER JOIN usuarios s ON p.id_asesor = s.id_usuario
        INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
        INNER JOIN sedes se ON se.id_sede = p.id_sede 
        LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
        LEFT JOIN sedes ot ON p.territorio_venta = ot.id_opcion AND ot.id_sede
        LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
        LEFT JOIN observaciones o ON (p.id_cliente = o.id_cliente)
        WHERE (p.id_sede = '$sede' AND lugar_prospeccion = '$lugar')
        AND (p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
        GROUP BY p.id_cliente ORDER BY p.fecha_creacion");
    }

    function get_report_lp3($sede, $fecha_ini, $fecha_fin){ // todos los filtros, lugar prosp. todos
        return $this->db->query("SELECT p.id_cliente AS Folio, IF(p.tipo = 0, 'Prospecto', 'Cliente') AS Tipo, 
        DATEDIFF(CURDATE(), p.fecha_creacion) 
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(p.fecha_creacion),1)),SUBSTRING(MONTHNAME(p.fecha_creacion),2)) 
        AS Mes,  CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente, 
        IF(p.correo IS NULL, 'No especificado', p.correo) AS Correo, 
        p.telefono AS Telefono, 
        IF(p.telefono_2 IS NULL, 'No especificado', p.telefono_2) AS Telefono_2, 
        IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
        IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
        CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno) as Asesor,
        IF(t2.id_rol = 3, CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno), CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno))
        AS Gerencia, se.nombre AS Sede, p.fecha_creacion as Fecha,
        IFNULL(GROUP_CONCAT(o.observacion ORDER BY o.fecha_creacion SEPARATOR '   |   '), 'Sin comentarios') AS comentarios
        FROM prospectos p INNER JOIN usuarios s ON p.id_asesor = s.id_usuario
        INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
        INNER JOIN sedes se ON se.id_sede = p.id_sede 
        LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
        LEFT JOIN sedes ot ON p.territorio_venta = ot.id_opcion AND ot.id_sede
        LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
        LEFT JOIN observaciones o ON (p.id_cliente = o.id_cliente)
        WHERE (p.id_sede = '$sede')
        AND (p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
        GROUP BY p.id_cliente ORDER BY p.fecha_creacion");
    }

    function get_report_lp4($lugar, $fecha_ini, $fecha_fin){ //sede = todos, lugar prosp. específico
        return $this->db->query("SELECT p.id_cliente AS Folio, IF(p.tipo = 0, 'Prospecto', 'Cliente') AS Tipo, 
        DATEDIFF(CURDATE(), p.fecha_creacion) 
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(p.fecha_creacion),1)),SUBSTRING(MONTHNAME(p.fecha_creacion),2)) 
        AS Mes,  CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente, 
        IF(p.correo IS NULL, 'No especificado', p.correo) AS Correo, 
        p.telefono AS Telefono, 
        IF(p.telefono_2 IS NULL, 'No especificado', p.telefono_2) AS Telefono_2, 
        IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
        IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
        CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno) as Asesor,
        IF(t2.id_rol = 3, CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno), CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno))
        AS Gerencia, se.nombre AS Sede, p.fecha_creacion as Fecha,
        IFNULL(GROUP_CONCAT(o.observacion ORDER BY o.fecha_creacion SEPARATOR '   |   '), 'Sin comentarios') AS comentarios
        FROM prospectos p INNER JOIN usuarios s ON p.id_asesor = s.id_usuario
        INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
        INNER JOIN sedes se ON se.id_sede = p.id_sede 
        LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
        LEFT JOIN sedes ot ON p.territorio_venta = ot.id_opcion AND ot.id_sede
        LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
        LEFT JOIN observaciones o ON (p.id_cliente = o.id_cliente)
        WHERE (p.lugar_prospeccion = '$lugar')
        AND (p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
        GROUP BY p.id_cliente ORDER BY p.fecha_creacion");
    }

    function get_report_lp5($fecha_ini, $fecha_fin){ // lugar prosp. todos, sedes todas
        return $this->db->query("SELECT p.id_cliente AS Folio, IF(p.tipo = 0, 'Prospecto', 'Cliente') AS Tipo, 
        DATEDIFF(CURDATE(), p.fecha_creacion) 
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(p.fecha_creacion),1)),SUBSTRING(MONTHNAME(p.fecha_creacion),2)) 
        AS Mes,  CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente, 
        IF(p.correo IS NULL, 'No especificado', p.correo) AS Correo, 
        p.telefono AS Telefono, 
        IF(p.telefono_2 IS NULL, 'No especificado', p.telefono_2) AS Telefono_2, 
        IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
        IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
        CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno) as Asesor,
        IF(t2.id_rol = 3, CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno), CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno))
        AS Gerencia, se.nombre AS Sede, p.fecha_creacion as Fecha,
        IFNULL(GROUP_CONCAT(o.observacion ORDER BY o.fecha_creacion SEPARATOR '   |   '), 'Sin comentarios') AS comentarios
        FROM prospectos p INNER JOIN usuarios s ON p.id_asesor = s.id_usuario
        INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
        INNER JOIN sedes se ON se.id_sede = p.id_sede 
        LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
        LEFT JOIN sedes ot ON p.territorio_venta = ot.id_opcion AND ot.id_sede
        LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
        LEFT JOIN observaciones o ON (p.id_cliente = o.id_cliente)
        WHERE (p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
        GROUP BY p.id_cliente ORDER BY p.fecha_creacion");
    }

    function get_report_lp6($sede, $fecha_ini, $fecha_fin){ //sede especifica, lugar prosp. todos
        return $this->db->query("SELECT p.id_cliente AS Folio, IF(p.tipo = 0, 'Prospecto', 'Cliente') AS Tipo, 
        DATEDIFF(CURDATE(), p.fecha_creacion) 
        AS DiasEnProceso, CONCAT(UCASE(LEFT(MONTHNAME(p.fecha_creacion),1)),SUBSTRING(MONTHNAME(p.fecha_creacion),2)) 
        AS Mes,  CONCAT(p.nombre, ' ', p.apellido_paterno, ' ', p.apellido_materno) AS Cliente, 
        IF(p.correo IS NULL, 'No especificado', p.correo) AS Correo, 
        p.telefono AS Telefono, 
        IF(p.telefono_2 IS NULL, 'No especificado', p.telefono_2) AS Telefono_2, 
        IF(oc.nombre IS NULL, 'N/D', oc.nombre  )AS LugarProspeccion,
        IF(om.nombre IS NULL, 'N/D', om.nombre  )AS MedioPublicitario,
        CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno) as Asesor,
        IF(t2.id_rol = 3, CONCAT(t2.nombre, ' ', t2.apellido_paterno, ' ', t2.apellido_materno), CONCAT(s.nombre, ' ', s.apellido_paterno, ' ', s.apellido_materno))
        AS Gerencia, se.nombre AS Sede, p.fecha_creacion as Fecha,
        IFNULL(GROUP_CONCAT(o.observacion ORDER BY o.fecha_creacion SEPARATOR '   |   '), 'Sin comentarios') AS comentarios
        FROM prospectos p INNER JOIN usuarios s ON p.id_asesor = s.id_usuario
        INNER JOIN usuarios t2 ON p.id_gerente = t2.id_usuario
        INNER JOIN sedes se ON se.id_sede = p.id_sede 
        LEFT JOIN opcs_x_cats oc ON (p.lugar_prospeccion = oc.id_opcion AND oc.id_catalogo = 9)
        LEFT JOIN sedes ot ON p.territorio_venta = ot.id_opcion AND ot.id_sede
        LEFT JOIN opcs_x_cats om ON (p.medio_publicitario = om.id_opcion AND om.id_catalogo = 7)
        LEFT JOIN observaciones o ON (p.id_cliente = o.id_cliente)
        WHERE (p.id_sede = '$sede')
        AND (p.fecha_creacion BETWEEN '$fecha_ini 00:00:00' AND '$fecha_fin 23:59:59')
        GROUP BY p.id_cliente ORDER BY p.fecha_creacion");
    }

    function get_asesores_bycoord($coordinador,$user){
		return $this->db->query("SELECT DISTINCT u.id_usuario AS id_asesores, UPPER(CONCAT(u.nombre, ' ', u.apellido_paterno, ' ',
        u.apellido_materno)) 
        AS nombre_asesores FROM usuarios u WHERE u.estatus = 1 AND ( (u.id_lider = '$coordinador' AND u.id_rol = 7)  OR (u.id_usuario IN (SELECT id_usuario FROM usuarios WHERE id_lider = $user AND id_rol = 6)) 
         OR (u.id_usuario = '$user'))");
    }
    
    function get_coordinadoresbyasis($user){

		return $this->db->query("SELECT id_usuario AS id_coordinadores,  UPPER(CONCAT(nombre, ' ', apellido_paterno, ' ',
        apellido_materno)) 
        AS nombre_coordinadores FROM usuarios WHERE id_lider ='$user' AND id_rol = 9 AND estatus = 1;");

	}

    function getGeneralData(){
        switch ($this->session->userdata('id_rol')) {
            case '2': // SUBDIRECTOR
            case '5': // ASISTENTE SUBDIRECTOR
                return $this->db->query("SELECT FORMAT(COUNT (p.id_prospecto), 'N0') prospects_number FROM prospectos p WHERE p.id_sede IN (".$this->session->userdata('id_sede').") AND p.tipo = 0
                UNION ALL
                SELECT FORMAT(COUNT (p.id_prospecto), 'N0') prospects_number FROM prospectos p WHERE p.id_sede IN (".$this->session->userdata('id_sede').") AND p.tipo = 0 AND p.estatus = 1
                UNION ALL
                SELECT FORMAT(COUNT (p.id_prospecto), 'N0') prospects_number FROM prospectos p WHERE p.id_sede IN (".$this->session->userdata('id_sede').") AND p.tipo = 0 AND p.estatus = 0
                UNION ALL
                SELECT FORMAT(COUNT (c.id_cliente), 'N0') clients_number FROM clientes c 
                INNER JOIN lotes l ON l.idCliente = c.id_cliente WHERE l.ubicacion IN (".$this->session->userdata('id_sede').") AND c.status = 1");
            break;
            case '3': // GERENTE
                return $this->db->query("SELECT FORMAT(COUNT (p.id_prospecto), 'N0') prospects_number FROM prospectos p WHERE p.tipo = 0 AND (p.id_gerente = ".$this->session->userdata('id_usuario')." OR p.id_coordinador = ".$this->session->userdata('id_usuario')." OR p.id_asesor = ".$this->session->userdata('id_usuario').")
                UNION ALL
                SELECT FORMAT(COUNT (p.id_prospecto), 'N0') prospects_number FROM prospectos p WHERE p.tipo = 0 AND p.estatus = 1 AND (p.id_gerente = ".$this->session->userdata('id_usuario')." OR p.id_coordinador = ".$this->session->userdata('id_usuario')." OR p.id_asesor = ".$this->session->userdata('id_usuario').")
                UNION ALL
                SELECT FORMAT(COUNT (p.id_prospecto), 'N0') prospects_number FROM prospectos p WHERE p.tipo = 0 AND p.estatus = 0 AND (p.id_gerente = ".$this->session->userdata('id_usuario')." OR p.id_coordinador = ".$this->session->userdata('id_usuario')." OR p.id_asesor = ".$this->session->userdata('id_usuario').")
                UNION ALL
                SELECT FORMAT(COUNT (c.id_cliente), 'N0') clients_number FROM clientes c WHERE c.id_gerente = ".$this->session->userdata('id_usuario')." AND c.status = 1");
                break;
            case '6': // ASISTENTE GERENTE
                return $this->db->query("SELECT FORMAT(COUNT (p.id_prospecto), 'N0') prospects_number FROM prospectos p WHERE p.id_gerente = ".$this->session->userdata('id_lider')." AND p.tipo = 0
                UNION ALL
                SELECT FORMAT(COUNT (p.id_prospecto), 'N0') prospects_number FROM prospectos p WHERE p.id_gerente = ".$this->session->userdata('id_lider')." AND p.tipo = 0 AND p.estatus = 1
                UNION ALL
                SELECT FORMAT(COUNT (p.id_prospecto), 'N0') prospects_number FROM prospectos p WHERE p.id_gerente = ".$this->session->userdata('id_lider')." AND p.tipo = 0 AND p.estatus = 0
                UNION ALL
                SELECT FORMAT(COUNT (c.id_cliente), 'N0') clients_number FROM clientes c WHERE c.id_gerente = ".$this->session->userdata('id_lider')." AND c.status = 1");
                break;
            case '9': // COORDINADOR
                return $this->db->query("SELECT FORMAT(COUNT (p.id_prospecto), 'N0') prospects_number FROM prospectos p WHERE (p.id_asesor = ".$this->session->userdata('id_usuario')." OR id_coordinador = ".$this->session->userdata('id_usuario').") AND p.tipo = 0
                UNION ALL
                SELECT FORMAT(COUNT (p.id_prospecto), 'N0') prospects_number FROM prospectos p WHERE (p.id_asesor = ".$this->session->userdata('id_usuario')." OR id_coordinador = ".$this->session->userdata('id_usuario').") AND p.tipo = 0 AND p.estatus = 1
                UNION ALL
                SELECT FORMAT(COUNT (p.id_prospecto), 'N0') prospects_number FROM prospectos p WHERE (p.id_asesor = ".$this->session->userdata('id_usuario')." OR id_coordinador = ".$this->session->userdata('id_usuario').") AND p.tipo = 0 AND p.estatus = 0
                UNION ALL
                SELECT FORMAT(COUNT (c.id_cliente), 'N0') clients_number FROM clientes c WHERE c.id_asesor = ".$this->session->userdata('id_usuario')." AND c.status = 1");
                break;
            case '7': // ASESOR
                return $this->db->query("SELECT FORMAT(COUNT (p.id_prospecto), 'N0') prospects_number FROM prospectos p WHERE (p.id_asesor = ".$this->session->userdata('id_usuario')." OR id_coordinador = ".$this->session->userdata('id_usuario').") AND p.tipo = 0
                UNION ALL
                SELECT FORMAT(COUNT (p.id_prospecto), 'N0') prospects_number FROM prospectos p WHERE (p.id_asesor = ".$this->session->userdata('id_usuario')." OR id_coordinador = ".$this->session->userdata('id_usuario').") AND p.tipo = 0 AND p.estatus = 1
                UNION ALL
                SELECT FORMAT(COUNT (p.id_prospecto), 'N0') prospects_number FROM prospectos p WHERE (p.id_asesor = ".$this->session->userdata('id_usuario')." OR id_coordinador = ".$this->session->userdata('id_usuario').") AND p.tipo = 0 AND p.estatus = 0
                UNION ALL
                SELECT FORMAT(COUNT (c.id_cliente), 'N0') clients_number FROM clientes c WHERE c.id_asesor = ".$this->session->userdata('id_usuario')." AND c.status = 1");
                break;
            case '1': // DIRECTOR
            case '4': // ASISTENTE DIRECTOR
            default: // VE TODOS LOS REGISTROS
                return $this->db->query("SELECT FORMAT(COUNT (p.id_prospecto), 'N0') prospects_number FROM prospectos p WHERE p.tipo = 0
                UNION ALL
                SELECT FORMAT(COUNT (p.id_prospecto), 'N0') prospects_number FROM prospectos p WHERE p.tipo = 0 AND p.estatus = 1
                UNION ALL
                SELECT FORMAT(COUNT (p.id_prospecto), 'N0') prospects_number FROM prospectos p WHERE p.tipo = 0 AND p.estatus = 0
                UNION ALL
                SELECT FORMAT(COUNT (c.id_cliente), 'N0') clients_number FROM clientes c WHERE c.status = 1");
            break;
        }

    }

    function getDataPerSedeV2(){
        $currentYear = date("Y");
        $query = array();
        for ($i = 0; $i < 6; $i++) {
            $query[$i] = $this->db->query("SELECT CASE WHEN MONTH(fecha_creacion) = 1 THEN 'Enero' WHEN MONTH(fecha_creacion) = 2 THEN 'Febrero' WHEN MONTH(fecha_creacion) = 3 THEN 'Marzo'
            WHEN MONTH(fecha_creacion) = 4 THEN 'Abril' WHEN MONTH(fecha_creacion) = 5 THEN 'Mayo' WHEN MONTH(fecha_creacion) = 6 THEN 'Junio'
            WHEN MONTH(fecha_creacion) = 7 THEN 'Julio' WHEN MONTH(fecha_creacion) = 8 THEN 'Agosto' WHEN MONTH(fecha_creacion) = 9 THEN 'Septiembre'
            WHEN MONTH(fecha_creacion) = 10 THEN 'Octubre' WHEN MONTH(fecha_creacion) = 11 THEN 'Noviembre' WHEN MONTH(fecha_creacion) = 12 THEN 'Diciembre'
            END month_name, FORMAT(COUNT(id_prospecto), 'N0') prospects_number FROM prospectos 
            WHERE tipo = 0 AND id_sede = $i + 1 AND (fecha_creacion BETWEEN '$currentYear/01/01 00:00:00' AND '$currentYear/12/31 23:59:59') 
            GROUP BY MONTH(fecha_creacion) ORDER BY MONTH(fecha_creacion)")->result();
        }
        return $query;
    }

    public function getDataGraficaAnual($anio)
    {
        $result = $this->db->query("SELECT COUNT(DISTINCT(id_lote)) lotes, COUNT(DISTINCT(c.id_comision)) comisiones, 
            COUNT(DISTINCT(pci.id_pago_i)) pagos, MONTH(c.fecha_creacion)mes
            FROM comisiones c
            LEFT JOIN usuarios u on u.id_usuario = c.creado_por and u.id_rol in (32,13,17) 
            LEFT JOIN pago_comision_ind pci on pci.id_comision = c.id_comision 
            and year(pci.fecha_abono) = $anio
            WHERE year(c.fecha_creacion) = $anio
            and u.id_usuario is not null
            GROUP BY YEAR(c.fecha_creacion), MONTH(c.fecha_creacion)");

        return $result->result_array();
    }
    public function getDataGraficaTopUsuarios($anio, $mes)
    {
        $result = $this->db->query("SELECT TOP 5 COUNT(DISTINCT(id_lote)) lotes, COUNT(DISTINCT(c.id_comision)) comisiones, 
            COUNT(DISTINCT(pci.id_pago_i)) pagos,
            CONCAT( u.nombre, ' ', u.apellido_paterno) nombre
            FROM comisiones c
            INNER JOIN usuarios u ON u.id_usuario = c.creado_por AND u.id_rol IN (32,13,17) 
            INNER JOIN pago_comision_ind pci ON pci.id_comision = c.id_comision 
            AND YEAR(pci.fecha_abono) = $anio AND MONTH(pci.fecha_abono) = $mes
            WHERE YEAR(c.fecha_creacion) = $anio AND MONTH(c.fecha_creacion) = $mes
            GROUP BY c.creado_por, YEAR(c.fecha_creacion), u.id_rol, u.nombre, u.apellido_paterno, MONTH(c.fecha_creacion)
            ORDER BY COUNT(distinct(id_lote)) DESC, count(distinct(c.id_comision)) DESC, count(distinct(pci.id_pago_i)) DESC");

        return $result->result_array();
    }

    public function getDataAsesorGraficaTabla($anio, $mes)
    {
        $monthSelectClause = '';
        $monthCreacionWhereClause = '';
        $monthGroupByClause = '';

        if (trim($mes) !== '' && $mes != 0) {
            $monthSelectClause = ', MONTH(pci.fecha_abono) mes';
            $monthCreacionWhereClause = "AND MONTH(pci.fecha_abono) = $mes";
            $monthGroupByClause = ', MONTH(pci.fecha_abono)';
        }
        
        $result = $this->db->query("SELECT
        COUNT(DISTINCT(id_lote)) lotes, 
        COUNT(c.id_comision) comisiones, 
        COUNT(pci.id_pago_i) pagos, 
        SUM(pci.abono_neodata) monto, u.id_usuario, $anio as anio,  
        CONCAT( u.nombre, ' ', u.apellido_paterno, ' ',  u.apellido_materno) nombre_completo $monthSelectClause
        FROM pago_comision_ind pci 
        INNER JOIN comisiones c on c.id_comision = pci.id_comision
        INNER JOIN usuarios u ON u.id_usuario = pci.creado_por AND u.id_rol IN (32,13,17,70) 
        WHERE YEAR(pci.fecha_abono) = $anio $monthCreacionWhereClause
        AND pci.estatus NOT IN (0) 
        GROUP BY u.id_usuario, u.nombre, u.apellido_paterno, u.apellido_materno $monthGroupByClause
        ORDER by COUNT(DISTINCT(id_lote)) DESC");
 
        return $result->result_array();
    }
}
