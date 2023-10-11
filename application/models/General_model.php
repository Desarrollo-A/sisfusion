<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class General_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function get_menu($id_rol,$id_usuario,$estatus)
    {
        $idUsuario = $id_usuario;
        if ($this->existeUsuarioMenuEspecial($idUsuario)) {
            return $this->getMenuPadreEspecial($idUsuario);
        }
        if ($estatus == 3){ // USUARIOS BAJA COMISIONANDO 
        $complemento='';
            return $this->db->query("SELECT * FROM Menu2 WHERE rol=" . $id_rol . " AND nombre IN ('Inicio', 'Comisiones'  ".$complemento.") AND estatus = 1 order by orden asc");
         } else { 
                        return $this->db->query("SELECT * FROM Menu2 WHERE rol=" . $id_rol . " AND estatus = 1 ORDER BY orden ASC");   
        }
    }
    
    public function get_children_menu($id_rol,$id_usuario,$estatus)
    {
        $idUsuario = $id_usuario;
        if ($this->existeUsuarioMenuEspecial($idUsuario)) {
            return $this->getMenuHijoEspecial($idUsuario);
        }   
        return $this->db->query("SELECT * FROM Menu2 WHERE rol = " . $id_rol . " AND padre > 0 AND estatus = 1 ORDER BY orden ASC");     
    }

    public function get_active_buttons($var, $id_rol)
    {
        return $this->db->query("SELECT padre FROM Menu2 WHERE pagina = '" . $var . "' AND rol = " . $id_rol . " ");
    }

    public function getMenuPadreEspecial($idUsuario)
    {
        return $this->db->query("SELECT * FROM Menu2 WHERE idmenu IN 
            (SELECT value FROM menu_usuario CROSS APPLY STRING_SPLIT(menu, ',') 
                    WHERE id_usuario = $idUsuario AND es_padre = 1) AND estatus=1 ORDER BY orden");
    }

    public function getMenuHijoEspecial($idUsuario)
    {
        return $this->db->query("SELECT * FROM Menu2 WHERE idmenu IN 
            (SELECT value FROM menu_usuario CROSS APPLY STRING_SPLIT(menu, ',') 
                    WHERE id_usuario = $idUsuario AND es_padre = 0) AND estatus IN(1,3) ORDER BY orden");
    }

    public function getResidencialesList()
    {
        return $this->db->query("SELECT idResidencial, CONCAT (nombreResidencial, ' - ', UPPER(CAST(descripcion AS VARCHAR(75)))) descripcion, empresa FROM residenciales WHERE status = 1 ORDER BY nombreResidencial ASC")->result_array();
    }

    public function getCondominiosList($idResidencial)
    {
        return $this->db->query("SELECT idCondominio, UPPER(nombre) nombre FROM condominios WHERE status = 1 AND idResidencial = $idResidencial ORDER BY nombre ASC")->result_array();
    }

    public function getLotesList($idCondominio)
    {
        return $this->db->query("SELECT idLote, UPPER(nombreLote) nombreLote, idStatusLote, msi FROM lotes WHERE status = 1 AND idCondominio IN( $idCondominio)")->result_array();
    }


    public function addRecord($table, $data) { // MJ: AGREGA UN REGISTRO A UNA TABLA EN PARTICULAR, RECIBE 2 PARÁMETROS. LA TABLA Y LA DATA A INSERTAR
        if ($data != '' && $data != null) {
            $response = $this->db->insert($table, $data);
            if ($response)
                return true;
            else
                return false;
        } else
            return false;
    } 

    public function updateRecord($table, $data, $key, $value) { // MJ: ACTUALIZA LA INFORMACIÓN DE UN REGISTRO EN PARTICULAR, RECIBE 4 PARÁMETROS. TABLA, DATA A ACTUALIZAR, LLAVE (WHERE) Y EL VALOR DE LA LLAVE
        if ($data != '' && $data != null) {
            $response = $this->db->update($table, $data, "$key = '$value'");
            if ($response)
                return true;
            else
                return false;
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

    public function getMultirol($usuario){
        return $this->db->query("SELECT * FROM roles_x_usuario WHERE idUsuario = $usuario");
    }

    public function getUsersByLeader($rol, $secondRol) {
        $idrol = $this->session->userdata('id_rol');
        $extraSelect = "";
        if($idrol == 5)
            $idUsuario = $this->session->userdata('id_lider');
        else
            $idUsuario = $this->session->userdata('id_usuario');


        if (in_array($this->session->userdata('id_usuario'), array(3, 28)))
            $extraSelect = "UNION 
            SELECT DISTINCT(u.id_usuario), u.* FROM roles_x_usuario rxu
            INNER JOIN usuarios u  ON u.id_usuario = rxu.idUsuario  
            WHERE rxu.idUsuario = 692";
        
        return $this->db->query("SELECT DISTINCT(u.id_usuario),u.* FROM roles_x_usuario rxu
        INNER JOIN usuarios u  ON u.id_lider = rxu.idUsuario  
        WHERE rxu.idRol = $rol AND rxu.idUsuario =  $idUsuario AND u.id_rol = $secondRol
        UNION 
        SELECT DISTINCT(u.id_usuario), u.* FROM roles_x_usuario rxu
        INNER JOIN usuarios u  ON u.id_usuario = rxu.idUsuario  
        WHERE rxu.idRol = $rol AND rxu.idUsuario =  $idUsuario AND u.id_rol = $secondRol
        $extraSelect");
    }
    
    function getCatalogOptions($id_catalogo)
    {
        return $this->db->query("SELECT id_opcion, id_catalogo, nombre FROM opcs_x_cats WHERE id_catalogo = $id_catalogo AND estatus = 1");
    }

    public function getAsesoresList()
    {
        $idrol = $this->session->userdata('id_rol');
        if($idrol == 84){
            return $this->db->query("SELECT id_usuario id, CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) nombre, id_sede sede, id_rol rol 
            FROM usuarios 
            WHERE id_rol IN (9,1) AND estatus = 1 AND (rfc NOT LIKE '%TSTDD%' AND ISNULL(correo, '' ) NOT LIKE '%test_%')
            ORDER BY nombre")->result_array();
        }
        else{
            return $this->db->query("SELECT id_usuario id, CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) nombre, id_sede sede, id_rol rol
            FROM usuarios WHERE id_lider = " . $this->session->userdata('id_usuario') . " AND id_rol = 9 AND estatus = 1
            UNION ALL
            SELECT id_usuario id, CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) nombre, id_sede sede, id_rol rol
            FROM usuarios 
            WHERE id_lider IN (SELECT id_usuario FROM usuarios WHERE id_lider = " . $this->session->userdata('id_usuario') . " AND id_rol = 9 AND estatus = 1) AND estatus = 1
            ORDER BY nombre")->result_array();
        }
    }

    public function existeUsuarioMenuEspecial($idUsuario)
    {
        $query = $this->db->query("SELECT id_menu_u FROM menu_usuario WHERE id_usuario = $idUsuario");
        $result = $query->result_array();
        return count($result) > 0;
    }

    public function get_submenu_data($id_rol, $id_usuario){
        return $this->db->query("SELECT * FROm sub_menu WHERE id_rol = $id_rol OR id_usuario = $id_usuario");
    }

    public function deleteRecord($table, $data) // AGREGA UN REGISTRO A UNA TABLA EN PARTICULAR, RECIBE 2 PARÁMETROS. LA TABLA Y LA LLAVE array('id' => $id)
    {
        if ($data != '' && $data != null) {
            $this->db->trans_begin();
            $this->db->delete($table, $data);
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
    
    function permisosMenu($val){
        if($val == 1){
            $this->session->set_flashdata('error_usuario', '<div id="ele" class="col-md-11" role="alert"><center><b>¡NO TIENES ACCESO AL PANEL SOLICITADO!</b><br><span style="font-size:12px;">Verificar los datos o ponerse en contacto con un administrador.</span></center></div>');
            redirect(base_url() .$this->session->userdata('controlador'),'location');
        }
    }

    public function get_menu_opciones(){
        return $this->db->query("SELECT LOWER(pagina) pagina FROM Menu2 WHERE pagina != '' AND estatus=1 AND nombre !='Aparta en línea' AND rol in(SELECT id_opcion FROM opcs_x_cats where id_catalogo=1 and estatus=1) GROUP BY pagina");
    }
    public function getResidenciales()
    {
        return $this->db->query("SELECT idResidencial, nombreResidencial, CAST(descripcion AS VARCHAR(75)) descripcion, empresa FROM residenciales WHERE status = 1 ORDER BY nombreResidencial ASC")->result_array();
    }

    public function getOfficeAddressesAll(){
        $response = $this->db->query("SELECT di.id_direccion, se.nombre sede, di.nombre, di.tipo_oficina, di.hora_inicio, di.hora_fin, di.estatus
        FROM direcciones di
        INNER JOIN sedes se on se.id_sede = di.id_sede
        WHERE di.tipo_oficina = 1 ORDER BY se.nombre");

        return $response;
    }

    public function getActiveOfficeAddresses(){
        $response = $this->db->query("SELECT di.id_direccion, se.nombre sede, di.nombre, di.tipo_oficina, di.hora_inicio, di.hora_fin, di.estatus
        FROM direcciones di
        INNER JOIN sedes se on se.id_sede = di.id_sede
        WHERE di.estatus = 1 AND di.tipo_oficina = 1 ORDER BY se.nombre");

        return $response;
    }

    function listSedes(){
        return $this->db->query("SELECT * FROM sedes WHERE estatus = 1");
    }

    function getClienteNLote($cliente){
        return $this->db->query("SELECT cl.*, lo.sup, lo.idCondominio, lo.nombreLote, lo.tipo_venta, lo.ubicacion
        FROM clientes cl
        INNER JOIN lotes lo ON lo.idLote = cl.idLote
        WHERE cl.id_cliente = $cliente");
    }

    public function getLider($id_gerente) {
        return $this->db->query("SELECT us.id_lider as id_subdirector, 
		(CASE 
        WHEN us.id_lider = 7092 THEN 3 
        WHEN us.id_lider IN (9471, 681, 609, 690, 2411) THEN 607 
		WHEN us.id_lider = 692 THEN u0.id_lider
        WHEN us.id_lider = 703 THEN 4
        WHEN us.id_lider = 7886 THEN 5
        ELSE 0 END) id_regional,
		CASE 
		WHEN (us.id_sede = '13' AND u0.id_lider = 7092) THEN 3
		WHEN (us.id_sede = '13' AND u0.id_lider = 3) THEN 7092
		ELSE 0 END id_regional_2
        FROM usuarios us
        INNER JOIN usuarios u0 ON u0.id_usuario = us.id_lider
        WHERE us.id_usuario IN ($id_gerente)");
    }
}
