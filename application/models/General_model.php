<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class General_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function get_menu($id_rol)
    {
        if ($this->session->userdata('id_usuario') == 4415) // ES GREENHAM
            return $this->db->query("SELECT * FROM Menu2 WHERE rol=" . $id_rol . " AND nombre IN ('Inicio', 'Comisiones') AND estatus = 1 order by orden asc");
        else {
            if ($id_rol == 33) { // ES UN USUARIO DE CONSULTA
                if ($this->session->userdata('id_usuario') == 2896) // ES PATRICIA MAYA
                    return $this->db->query("SELECT * FROM Menu2 WHERE rol=" . $id_rol . " AND estatus = 1 ORDER BY orden ASC");
                else // ES OTRO USUARIO DE CONSULTA Y NO VE COMISIONES
                    return $this->db->query("SELECT * FROM Menu2 WHERE rol=" . $id_rol . " AND nombre NOT IN ('Inicio', 'Comisiones') AND estatus = 1 ORDER BY orden ASC");
            } else {
                if ($this->session->userdata('id_usuario') == 2762)
                    return $this->db->query("SELECT * FROM Menu2 WHERE rol=" . $id_rol . " AND estatus = 1 ORDER BY orden ASC");
                else
                    return $this->db->query("SELECT * FROM Menu2 WHERE rol=" . $id_rol . " AND estatus = 1 AND nombre NOT IN ('Reemplazo contrato') ORDER BY orden ASC");
            }
        }
        //  return $this->db->query("SELECT * FROM Menu2 WHERE rol=".$id_rol." AND estatus = 1 ORDER BY orden ASC");
    }

    public function get_children_menu($id_rol)
    {
        if ($this->session->userdata('id_usuario') == 2762) {
            return $this->db->query("SELECT * FROM Menu2 WHERE rol = " . $id_rol . " AND padre > 0 AND estatus = 1 ORDER BY orden ASC");
        } else {
            return $this->db->query("SELECT * FROM Menu2 WHERE rol = " . $id_rol . " AND padre > 0 AND estatus = 1 AND nombre NOT IN ('Reemplazo contrato') ORDER BY orden ASC");
        }
    }

    public function get_active_buttons($var, $id_rol)
    {
        return $this->db->query("SELECT padre FROM Menu2 WHERE pagina = '" . $var . "' AND rol = " . $id_rol . " ");
    }

    public function getResidencialesList()
    {
        return $this->db->query("SELECT idResidencial, nombreResidencial, UPPER(CAST(descripcion AS VARCHAR(75))) descripcion, empresa FROM residenciales WHERE status = 1 ORDER BY nombreResidencial ASC")->result_array();
    }

    public function getCondominiosList($idResidencial)
    {
        return $this->db->query("SELECT idCondominio, UPPER(nombre) nombre FROM condominios WHERE status = 1 AND idResidencial = $idResidencial ORDER BY nombre ASC")->result_array();
    }

    public function getLotesList($idCondominio)
    {
        $a = 0;
        return $this->db->query("SELECT idLote, UPPER(nombreLote) nombreLote, idStatusLote FROM lotes WHERE status = 1 AND idCondominio IN( $idCondominio)")->result_array();
    }

    public function addRecord($table, $data) // MJ: AGREGA UN REGISTRO A UNA TABLA EN PARTICULAR, RECIBE 2 PARÁMETROS. LA TABLA Y LA DATA A INSERTAR
    {
        if ($data != '' && $data != null) {
            $this->db->trans_begin();
            $this->db->insert($table, $data);
            if ($this->db->trans_status() === FALSE) { // Hubo errores en la consulta, entonces se cancela la transacción.
                $this->db->trans_rollback();
                return false;
            } else { // Todas las consultas se hicieron correctamente.
                $this->db->trans_commit();
                return true;
            }
        } else
            return false;
    }

    public function updateRecord($table, $data, $key, $value) // MJ: ACTUALIZA LA INFORMACIÓN DE UN REGISTRO EN PARTICULAR, RECIBE 4 PARÁMETROS. TABLA, DATA A ACTUALIZAR, LLAVE (WHERE) Y EL VALOR DE LA LLAVE
    {
        if ($data != '' && $data != null) {
            $this->db->trans_begin();
            $this->db->update($table, $data, "$key = '$value'");
            if ($this->db->trans_status() === FALSE) { // Hubo errores en la consulta, entonces se cancela la transacción.
                $this->db->trans_rollback();
                return false;
            } else { // Todas las consultas se hicieron correctamente.
                $this->db->trans_commit();
                return true;
            }
        } else
            return false;
    }

    public function insertBatch($table, $data)
    {
        $this->db->trans_begin();
        $this->db->insert_batch($table, $data);
        if ($this->db->trans_status() === FALSE) { // Hubo errores en la consulta, entonces se cancela la transacción.
            $this->db->trans_rollback();
            return false;
        } else { // Todas las consultas se hicieron correctamente.
            $this->db->trans_commit();
            return true;
        }
    }

    public function updateBatch($table, $data, $key)
    {
        $this->db->trans_begin();
        $this->db->update_batch($table, $data, $key);
        if ($this->db->trans_status() === FALSE) { // Hubo errores en la consulta, entonces se cancela la transacción.
            $this->db->trans_rollback();
            return false;
        } else { // Todas las consultas se hicieron correctamente.
            $this->db->trans_commit();
            return true;
        }
    }

    public function getInformationSchemaByTable($table) // MJ: RECIBE el nombre de la tabla que se desea consultar column y data_type
    {
        return $this->db->query("SELECT COLUMN_NAME column_name, DATA_TYPE data_type FROM Information_Schema.Columns WHERE TABLE_NAME = '$table';")->result_array();
    }

}
