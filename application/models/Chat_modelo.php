<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 */
class Chat_modelo extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}



    /*------CONSULTAS PARA EL CHAT-----------------------*/

    public function usuarios_online($sede){
       return $this->db->query("SELECT us.*, p.*, se.nombre AS 'sede'
       FROM usuarios us
       inner join perfilAsesor p on p.id_usuario=us.id_usuario 
       INNER JOIN sedes se on se.id_sede = (CASE us.id_usuario WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 5 ELSE (CASE WHEN LEN (us.id_sede) > 1 THEN 0 ELSE us.id_sede END)  END ) 
       WHERE us.id_sede=$sede AND p.estatus=1 AND us.id_rol=7;");
    }
    public function usuarios_onlineBusqueda($sede,$nombre){
       return $this->db->query("SELECT us.*, p.*, se.nombre AS 'sede'
       FROM usuarios us
       inner join perfilAsesor p on p.id_usuario=us.id_usuario 
       INNER JOIN sedes se on se.id_sede = (CASE us.id_usuario WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 5 ELSE (CASE WHEN LEN (us.id_sede) > 1 THEN 0 ELSE us.id_sede END)  END ) 
       WHERE us.id_sede=$sede and us.nombre like '%$nombre%' AND p.estatus=1 AND us.id_rol=7;");
    }

    public function Online($sede)
    {
       return $this->db->query("SELECT  * FROM usuarios u inner join perfilAsesor p on p.id_usuario=u.id_usuario WHERE u.id_sede=$sede AND p.estatus=1 AND p.id_usuario != 1982 AND p.id_usuario !=1981 and u.id_rol in(7);");
    }
   
    public function Consulta($sede){
       return $this->db->query("SELECT us.*, p.*, se.nombre AS 'sede'
       FROM usuarios us 
       inner join perfilAsesor p on p.id_usuario= us.id_usuario 
       INNER JOIN sedes se on se.id_sede = (CASE us.id_usuario WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 5 ELSE (CASE WHEN LEN (us.id_sede) > 1 THEN 0 ELSE us.id_sede END)  END ) 
       WHERE us.id_sede= '$sede' AND p.estatus=2 AND p.id_usuario != 1982 AND p.id_usuario !=1981  and us.id_rol in(7);");
    }

    public function ConsultaBusqueda($sede,$nombre)
    {
       return $this->db->query("SELECT  * FROM usuarios u inner join perfilAsesor p on p.id_usuario=u.id_usuario WHERE u.id_sede=$sede AND p.estatus=2 AND p.id_usuario != 1982 AND p.id_usuario !=1981 and u.nombre like '%$nombre%';");
    }
    public function Offline($sede){
       return $this->db->query("SELECT us.*, p.*, se.nombre AS 'sede'
       FROM usuarios us
       inner join perfilAsesor p on p.id_usuario=us.id_usuario 
       INNER JOIN sedes se on se.id_sede = (CASE us.id_usuario WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 5 ELSE (CASE WHEN LEN (us.id_sede) > 1 THEN 0 ELSE us.id_sede END)  END ) 
       WHERE us.id_sede='$sede' AND p.estatus=3 AND p.id_usuario != 1982 AND p.id_usuario !=1981  and us.id_rol in(7);");
    }
    public function OfflineBusqueda($sede,$nombre){
       return $this->db->query("SELECT us.*, p.*, se.nombre AS 'sede'
       FROM usuarios us
       inner join perfilAsesor p on p.id_usuario=us.id_usuario 
       INNER JOIN sedes se on se.id_sede = (CASE us.id_usuario WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 5 ELSE (CASE WHEN LEN (us.id_sede) > 1 THEN 0 ELSE us.id_sede END)  END ) 
       WHERE us.id_sede='$sede' and us.nombre like '%$nombre%' AND p.estatus=3 AND p.id_usuario != 1982 AND p.id_usuario !=1981;");
    }
      function Tiene_permisos($id){
        return $this->db->query("SELECT * FROM perfilAsesor WHERE id_usuario=$id;");
    }


/*----------------------ROL 28------------------------*/
public function usuarios_onlineAdmin(){
       return $this->db->query("SELECT  us.*, p.*, se.nombre as 'sede' FROM usuarios us 
       INNER JOIN perfilAsesor p on p.id_usuario=us.id_usuario 
       INNER JOIN sedes se on se.id_sede = (CASE us.id_usuario WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 5 ELSE (CASE WHEN LEN (us.id_sede) > 1 THEN 0 ELSE us.id_sede END)  END ) 
       WHERE p.estatus=1");
    }
    public function usuarios_onlineAdminBusqueda($nombre){    
       return $this->db->query("SELECT us.*, p.*, se.nombre AS 'sede' FROM usuarios us 
       INNER JOIN perfilAsesor p on p.id_usuario=us.id_usuario
       INNER JOIN sedes se on se.id_sede = (CASE us.id_usuario WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 5 ELSE (CASE WHEN LEN (us.id_sede) > 1 THEN 0 ELSE us.id_sede END)  END ) 
       WHERE p.estatus=1 and us.nombre like '%$nombre%' ;");
    }
    public function OnlineAdmin(){
       return $this->db->query("SELECT  * FROM usuarios u inner join perfilAsesor p on p.id_usuario=u.id_usuario WHERE p.estatus=1;");
    }
    public function ConsultaAdmin(){
       return $this->db->query("SELECT  us.*, p.*, se.nombre as 'sede' FROM usuarios us 
       INNER JOIN perfilAsesor p on p.id_usuario=us.id_usuario 
       INNER JOIN sedes se on se.id_sede = (CASE us.id_usuario WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 5 ELSE (CASE WHEN LEN (us.id_sede) > 1 THEN 0 ELSE us.id_sede END)  END ) 
       WHERE p.estatus=2");
    }

    public function ConsultaAdminBusqueda($nombre){
       return $this->db->query("SELECT us.*, p.*, se.nombre AS 'sede' FROM usuarios us 
       INNER JOIN perfilAsesor p on p.id_usuario=us.id_usuario
       INNER JOIN sedes se on se.id_sede = (CASE us.id_usuario WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 5 ELSE (CASE WHEN LEN (us.id_sede) > 1 THEN 0 ELSE us.id_sede END)  END ) 
       WHERE p.estatus= 2 and us.nombre like '%$nombre%' ;");
    }

    public function OfflineAdmin(){
       return $this->db->query("SELECT  us.*, p.*, se.nombre as 'sede' FROM usuarios us 
       INNER JOIN perfilAsesor p on p.id_usuario=us.id_usuario 
       INNER JOIN sedes se on se.id_sede = (CASE us.id_usuario WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 5 ELSE (CASE WHEN LEN (us.id_sede) > 1 THEN 0 ELSE us.id_sede END)  END ) 
       WHERE p.estatus=3");
    }
    public function OfflineAdminBusqueda($nombre){
       return $this->db->query("SELECT us.*, p.*, se.nombre AS 'sede' FROM usuarios us 
       INNER JOIN perfilAsesor p on p.id_usuario=us.id_usuario
       INNER JOIN sedes se on se.id_sede = (CASE us.id_usuario WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 5 ELSE (CASE WHEN LEN (us.id_sede) > 1 THEN 0 ELSE us.id_sede END)  END ) 
       WHERE p.estatus=3 and us.nombre like '%$nombre%';");
    }
/*-----------------ROL 19-----------------------------*/

    public function usuarios_onlineSG($sede){
        return $this->db->query("SELECT us.*, p.*, se.nombre AS 'sede' 
        FROM usuarios us 
        inner join perfilAsesor p on p.id_usuario=us.id_usuario 
        INNER JOIN sedes se on se.id_sede = (CASE us.id_usuario WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 5 ELSE (CASE WHEN LEN (us.id_sede) > 1 THEN 0 ELSE us.id_sede END)  END ) 
        WHERE p.id_usuario != 1982 AND p.id_usuario !=1981 AND us.id_sede IN($sede) AND p.estatus=1;");
    }

    public function usuarios_onlineSGBusqueda($sede,$nombre){
        return $this->db->query("SELECT us.*, p.*, se.nombre AS 'sede' 
        FROM usuarios us 
        inner join perfilAsesor p on p.id_usuario=us.id_usuario 
        INNER JOIN sedes se on se.id_sede = (CASE us.id_usuario WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 5 ELSE (CASE WHEN LEN (us.id_sede) > 1 THEN 0 ELSE us.id_sede END)  END ) 
        WHERE p.id_usuario != 1982 AND p.id_usuario !=1981 AND us.nombre like '%$nombre%' AND us.id_sede IN($sede) AND p.estatus=1;");
    }

    public function OnlineSG($sede){
        return $this->db->query("SELECT  * FROM usuarios u inner join perfilAsesor p on p.id_usuario=u.id_usuario WHERE p.id_usuario != 1982 AND p.id_usuario !=1981 and u.id_rol in(7,3,20) AND u.id_sede IN($sede) AND p.estatus=1;");
    }

    public function ConsultaSG($sede){
        $id_sede = explode(", ", $sede);
        $result = "'" . implode("', '", $id_sede) . "'";
        return $this->db->query("SELECT us.*, p.*, se.nombre AS 'sede' 
        FROM usuarios us
        inner join perfilAsesor p on p.id_usuario=us.id_usuario
        INNER JOIN sedes se on se.id_sede = (CASE us.id_usuario WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 5 ELSE (CASE WHEN LEN (us.id_sede) > 1 THEN 0 ELSE us.id_sede END)  END ) 
        WHERE p.id_usuario != 1982 AND p.id_usuario !=1981 and us.id_rol in(7,3,20) AND us.id_sede IN($result) AND p.estatus=2;");
    }

    public function ConsultaSGBusqueda($sede,$nombre){
       return $this->db->query("SELECT us.*, p.*, se.nombre AS 'sede' 
       FROM usuarios us
       inner join perfilAsesor p on p.id_usuario=us.id_usuario 
       INNER JOIN sedes se on se.id_sede = (CASE us.id_usuario WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 5 ELSE (CASE WHEN LEN (us.id_sede) > 1 THEN 0 ELSE us.id_sede END)  END ) 
       WHERE p.id_usuario != 1982 AND p.id_usuario !=1981 AND us.id_sede IN($sede) and us.nombre like '%$nombre%' AND p.estatus=2;");
    }

    public function OfflineSG($sede){
       return $this->db->query("SELECT us.*, p.*, se.nombre AS 'sede'  
       FROM usuarios us 
       inner join perfilAsesor p on p.id_usuario=us.id_usuario 
       INNER JOIN sedes se on CAST(se.id_sede AS VARCHAR(45)) = (CASE us.id_usuario WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 5 ELSE (CASE WHEN LEN (CAST(us.id_sede AS VARCHAR(45))) > 1 THEN 0 ELSE CAST(us.id_sede AS VARCHAR(45)) END)  END ) 
       WHERE p.id_usuario != 1982 AND p.id_usuario !=1981 and us.id_rol in(7,3,20) AND CAST(us.id_sede AS VARCHAR(45)) IN($sede) AND p.estatus=3;");
       /*
        return $this->db->query("SELECT us.*, p.*, se.nombre AS 'sede'  
       FROM usuarios us 
       inner join perfilAsesor p on p.id_usuario=us.id_usuario 
       INNER JOIN sedes se on se.id_sede = (CASE us.id_usuario WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 5 ELSE (CASE WHEN LEN (us.id_sede) > 1 THEN 0 ELSE us.id_sede END)  END ) 
       WHERE p.id_usuario != 1982 AND p.id_usuario !=1981 and us.id_rol in(7,3,20) AND us.id_sede IN($sede) AND p.estatus=3;");
       */
    }

    public function OfflineSGBusqueda($sede,$nombre){
       return $this->db->query("SELECT us.*, p.*, se.nombre AS 'sede'
       FROM usuarios us
       inner join perfilAsesor p on p.id_usuario=us.id_usuario
       INNER JOIN sedes se on se.id_sede = (CASE us.id_usuario WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 5 ELSE (CASE WHEN LEN (us.id_sede) > 1 THEN 0 ELSE us.id_sede END)  END ) 
       WHERE p.id_usuario != 1982 AND p.id_usuario !=1981 AND us.id_sede IN($sede) and us.nombre like '%$nombre%' AND p.estatus=3;");
    }
/*-------------------------FIN ROL 19--------------------------------*/

function UserChats($sede){
    switch ($this->session->userdata('id_rol')) {
       case '20':
        return $this->db->query("SELECT p.estado,p.estatus,u.id_usuario, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre,u.id_rol,
        u.telefono, p.num_chat, CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) jefe_directo, u.id_sede as sede,
                                           CONCAT(us2.nombre, ' ', us2.apellido_paterno, ' ', us2.apellido_materno) jefe_directo2 FROM usuarios u 
                                   INNER JOIN sedes s ON CAST(s.id_sede as VARCHAR(45)) = u.id_sede
                                   LEFT JOIN usuarios us ON us.id_usuario = u.id_lider
                                   LEFT JOIN usuarios us2 ON us2.id_usuario = us.id_lider
                                   INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = u.id_rol
                                   LEFT JOIN perfilAsesor p ON p.id_usuario=u.id_usuario
                                   WHERE u.estatus = 1 AND u.id_rol IN (7) AND u.rfc NOT LIKE '%TSTDD%' AND ISNULL(u.correo, '') NOT LIKE '%test_%' AND oxc.id_catalogo = 1 AND s.id_sede='$sede' ORDER BY s.nombre, nombre;");
       break;
       case '28':
        case '18':
        return $this->db->query("SELECT p.estado,p.estatus,u.id_usuario, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre,u.id_rol,
        u.telefono, p.num_chat, CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) jefe_directo, u.id_sede as sede,
                                           CONCAT(us2.nombre, ' ', us2.apellido_paterno, ' ', us2.apellido_materno) jefe_directo2 FROM usuarios u 
                                           LEFT JOIN usuarios us ON us.id_usuario = u.id_lider
                                          LEFT JOIN usuarios us2 ON us2.id_usuario = us.id_lider
                                          INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = u.id_rol
                                           LEFT JOIN perfilAsesor p ON p.id_usuario=u.id_usuario
                                          WHERE u.estatus = 1 AND u.id_rol IN (7,20,19,3) AND u.rfc NOT LIKE '%TSTDD%' AND ISNULL(u.correo, '') NOT LIKE '%test_%' AND oxc.id_catalogo = 1  ORDER BY nombre;");
       break;
        case '19':
                           return $this->db->query("SELECT p.estado,p.estatus,u.id_usuario, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre,u.id_rol,
                           u.telefono, p.num_chat, CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) jefe_directo, u.id_sede as sede,
                            CONCAT(us2.nombre, ' ', us2.apellido_paterno, ' ', us2.apellido_materno) jefe_directo2 FROM usuarios u  
                                   INNER JOIN sedes s ON s.id_sede = u.id_sede
                                   LEFT JOIN usuarios us ON us.id_usuario = u.id_lider
                                   LEFT JOIN usuarios us2 ON us2.id_usuario = us.id_lider
                                   INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = u.id_rol
                                   LEFT JOIN perfilAsesor p ON p.id_usuario=u.id_usuario
                                   WHERE u.estatus = 1 AND s.id_sede IN(".$sede.") AND u.id_rol IN (7,20) AND u.rfc NOT LIKE '%TSTDD%' AND ISNULL(u.correo, '') NOT LIKE '%test_%' AND oxc.id_catalogo = 1  ORDER BY s.nombre, nombre;");
       break;
    }
}

    function saveProspectChat($data) {
        /*echo json_encode($data);
        if ($data.nacionalidad != '' && $data.nombre != '' && $data.personalidad_juridica != '' && $data.correo != '' && $data.telefono != ''
            && $data.lugar_prospeccion != '' && $data.medio_publicitario != '' && $data.plaza_venta != '') {*/
            $response = $this->db->insert("prospectos", $data);
            if (! $response ) {
                return $finalAnswer = 0;
            } else {
                return $finalAnswer = 1;
            }
    }
    function VerificarProspecto($idChat,$id_usuario){
      return $this->db->query("SELECT * FROM evidencias WHERE id_Chat='".$idChat."' AND id_usuario=$id_usuario; "); 
    }

    function UpdateProspectoChat($data, $id_prospecto) {
        $response = $this->db->update("prospectos", $data, "id_prospecto = $id_prospecto");
        if (! $response ) {
            return $finalAnswer = 0;
        } else {
            return $finalAnswer = 4;
        }
    }
    function saveEvidencia($data) {
        
            $response = $this->db->insert("evidencias", $data);
            if (! $response ) {
                return $finalAnswer = 0;
            } else {
                return $finalAnswer = 1;
            }
    }
      public function getNationality(){
        echo json_encode($this->Clientes_model->getNationality()->result_array());
    }
    public function getEstados(){
        echo json_encode($this->Clientes_model->getEstados()->result_array());
    }
    function MisChatsConsulta($id_usuario, $typeTransaction, $beginDate, $endDate, $where)
    {
        if ($typeTransaction == 1 || $typeTransaction == 3) {  // FIRST LOAD || SEARCH BY DATE RANGE
            $filter = " AND c.fecha_creacion BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59'";
            //$this->db->where("hd.modificado BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59'");
        }

        return $query = $this->db->query("SELECT idchat,id_sede, id_usuario, estatus, idgenerado, c.fecha_creacion, 
        fecha_modificacion, STRING_AGG(msn.mensaje, ' ') conversacion  FROM 
        chat  c
        INNER JOIN mensajes msn ON msn.id_chat=c.idgenerado
        WHERE id_usuario=".$id_usuario." ".$filter."
        GROUP BY idchat,id_sede, id_usuario, estatus, idgenerado, c.fecha_creacion, fecha_modificacion
        order by fecha_modificacion desc;");

       /*return $query = $this->db->query("SELECT idchat,id_sede, id_usuario, estatus, idgenerado, c.fecha_creacion,
        fecha_modificacion, STRING_AGG(msn.mensaje, ' ') conversacion  FROM
        chat  c
        INNER JOIN mensajes msn ON msn.id_chat=c.idgenerado
        WHERE id_usuario=$id_usuario AND CAST(c.fecha_creacion as date) >= CAST('$fecha1' AS date) AND CAST(c.fecha_creacion as date) <= CAST('$fecha2' AS date) 
        GROUP BY idchat,id_sede, id_usuario, estatus, idgenerado, c.fecha_creacion, fecha_modificacion
        order by fecha_modificacion desc;");*/
    }
     /*function MisChatsConsulta($id_usuario, $fecha1, $fecha2)
    {
      //return $this->db->query("SELECT * FROM chat WHERE id_usuario=$id_usuario AND estatus=1 order by fecha_modificacion desc;"); 
       return $query = $this->db->query("SELECT idchat,id_sede, id_usuario, estatus, idgenerado, c.fecha_creacion, fecha_modificacion, STRING_AGG(msn.mensaje, ' ') conversacion  FROM 
        chat  c
        INNER JOIN mensajes msn ON msn.id_chat=c.idgenerado
        WHERE id_usuario=$id_usuario AND CAST(c.fecha_creacion as date) >= CAST('$fecha1' AS date) AND CAST(c.fecha_creacion as date) <= CAST('$fecha2' AS date) 
        GROUP BY idchat,id_sede, id_usuario, estatus, idgenerado, c.fecha_creacion, fecha_modificacion
        order by fecha_modificacion desc;");

        // return $query->result_array();
    }*/
    function MisChatsConsultaAS($sedes)
    {
      return $this->db->query("SELECT * FROM chat c INNER JOIN usuarios u ON u.id_usuario=c.id_usuario INNER JOIN perfilAsesor p ON p.id_usuario=c.id_usuario  WHERE u.id_sede IN($sedes) AND u.id_usuario !=1981 AND u.id_usuario !=1982 order by c.fecha_modificacion desc;"); 
    }
    function HistorialChatAdmin($fecha1,$fecha2,$sede)
    {
        switch ($this->session->userdata('id_rol')) {
            case 19:
            case 20:
                if($fecha2 == 0 ){
                    //SELECT c.idchat,c.id_sede,u.nombre,u.apellido_paterno,c.fecha_creacion Fcreacion,c.id_usuario,p.foto,c.idgenerado FROM chat c INNER JOIN usuarios u ON u.id_usuario=c.id_usuario inner join perfilAsesor p on p.id_usuario=c.id_usuario  WHERE c.estatus=1 and CAST(c.fecha_creacion as date) >= CAST('$fecha1' AS date) order by c.fecha_modificacion desc;
                    return $this->db->query("WITH CTE AS(
                        SELECT c.idchat,c.id_sede,u.nombre,u.apellido_paterno,c.fecha_creacion Fcreacion,c.id_usuario,p.foto,c.idgenerado, 
                        STRING_AGG(CAST(msn.mensaje AS NVARCHAR(MAX)), ' ') conversacion
                        , RN = ROW_NUMBER()OVER(PARTITION BY c.idgenerado ORDER BY c.id_sede)
                         FROM chat c 
                         INNER JOIN usuarios u ON u.id_usuario=c.id_usuario 
                         inner join perfilAsesor p on p.id_usuario=c.id_usuario  
                         INNER JOIN mensajes msn ON msn.id_chat=c.idgenerado
                         WHERE CAST(c.fecha_creacion as date) >= CAST('$fecha1' AS date)
                         and c.id_sede = '$sede'
                         GROUP BY c.idchat, c.id_sede,u.nombre,u.apellido_paterno,c.fecha_creacion,c.id_usuario,p.foto,c.idgenerado
                     )
                     SELECT * FROM CTE
                     WHERE RN = 1
                 ");

                }else{

                    //SELECT c.idchat,c.id_sede,u.nombre,u.apellido_paterno,c.fecha_creacion Fcreacion,c.id_usuario,p.foto,c.idgenerado FROM chat c INNER JOIN usuarios u ON u.id_usuario=c.id_usuario inner join perfilAsesor p on p.id_usuario=c.id_usuario  WHERE c.estatus=1 and  CAST(c.fecha_creacion as date) >= CAST('$fecha1' AS date) AND CAST(c.fecha_creacion as date) <= CAST('$fecha2' AS date) order by c.fecha_creacion desc;
                    return $this->db->query("SELECT DISTINCT(c.idgenerado), c.id_sede,u.nombre,u.apellido_paterno, CONCAT( Day(c.fecha_creacion), '-', MONTH(c.fecha_creacion), '-',  Year(c.fecha_creacion)) Fcreacion,c.id_usuario,p.foto,c.idgenerado, STRING_AGG(CAST(msn.mensaje AS NVARCHAR(MAX)), ' ') conversacion
                    FROM chat c 
                    INNER JOIN usuarios u ON u.id_usuario=c.id_usuario 
                    inner join perfilAsesor p on p.id_usuario=c.id_usuario  
                    INNER JOIN mensajes msn ON msn.id_chat=c.idgenerado
                    WHERE  CAST(c.fecha_creacion as date) >= CAST('$fecha1' AS date) AND CAST(c.fecha_creacion as date) <= CAST('$fecha2' AS date) 
                    and c.id_sede = $sede
                    GROUP BY c.idgenerado, c.id_sede,u.nombre,u.apellido_paterno,MONTH(c.fecha_creacion), Day(c.fecha_creacion), Year(c.fecha_creacion),c.id_usuario,p.foto 
                    ORDER BY c.idgenerado DESC
                 ");

                }
                
                break;
            case 28:
                case 18:
                if($fecha2 == 0 ){
                    //SELECT c.idchat,c.id_sede,u.nombre,u.apellido_paterno,c.fecha_creacion Fcreacion,c.id_usuario,p.foto,c.idgenerado FROM chat c INNER JOIN usuarios u ON u.id_usuario=c.id_usuario inner join perfilAsesor p on p.id_usuario=c.id_usuario  WHERE c.estatus=1 and CAST(c.fecha_creacion as date) >= CAST('$fecha1' AS date) order by c.fecha_modificacion desc;
                    return $this->db->query("WITH CTE AS(
                        SELECT c.idchat,c.id_sede,u.nombre,u.apellido_paterno,c.fecha_creacion Fcreacion,c.id_usuario,p.foto,c.idgenerado, STRING_AGG(CAST(msn.mensaje AS NVARCHAR(MAX)), ' ') conversacion
                        , RN = ROW_NUMBER()OVER(PARTITION BY c.idgenerado ORDER BY c.id_sede)
                         FROM chat c 
                         INNER JOIN usuarios u ON u.id_usuario=c.id_usuario 
                         inner join perfilAsesor p on p.id_usuario=c.id_usuario  
                         INNER JOIN mensajes msn ON msn.id_chat=c.idgenerado
                         WHERE CAST(c.fecha_creacion as date) >= CAST('$fecha1' AS date)
                         and c.id_sede = '$sede'
                         GROUP BY c.idchat, c.id_sede,u.nombre,u.apellido_paterno,c.fecha_creacion,c.id_usuario,p.foto,c.idgenerado
                     )
                     SELECT * FROM CTE
                     WHERE RN = 1
                 ");

                }else{

                    //SELECT c.idchat,c.id_sede,u.nombre,u.apellido_paterno,c.fecha_creacion Fcreacion,c.id_usuario,p.foto,c.idgenerado FROM chat c INNER JOIN usuarios u ON u.id_usuario=c.id_usuario inner join perfilAsesor p on p.id_usuario=c.id_usuario  WHERE c.estatus=1 and  CAST(c.fecha_creacion as date) >= CAST('$fecha1' AS date) AND CAST(c.fecha_creacion as date) <= CAST('$fecha2' AS date) order by c.fecha_creacion desc;
                    return $this->db->query("SELECT DISTINCT(c.idgenerado), c.id_sede,u.nombre,u.apellido_paterno, CONCAT( Day(c.fecha_creacion), '-', MONTH(c.fecha_creacion), '-',  Year(c.fecha_creacion)) Fcreacion,c.id_usuario,p.foto,c.idgenerado, STRING_AGG(CAST(msn.mensaje AS NVARCHAR(MAX)), ' ') conversacion
                        
                    FROM chat c 
                    INNER JOIN usuarios u ON u.id_usuario=c.id_usuario 
                    inner join perfilAsesor p on p.id_usuario=c.id_usuario  
                    INNER JOIN mensajes msn ON msn.id_chat=c.idgenerado
                    WHERE  CAST(c.fecha_creacion as date) >= CAST('$fecha1' AS date) AND CAST(c.fecha_creacion as date) <= CAST('$fecha2' AS date) 
                    and c.id_sede = $sede
                    GROUP BY c.idgenerado, c.id_sede,u.nombre,u.apellido_paterno,MONTH(c.fecha_creacion), Day(c.fecha_creacion), Year(c.fecha_creacion),c.id_usuario,p.foto 
                    ORDER BY c.idgenerado DESC
                 ");

                }
                
                break;

        }


        //return $this->db->query("SELECT * FROM chat c INNER JOIN usuarios u ON u.id_usuario=c.id_usuario  WHERE c.estatus=0 order by c.fecha_modificacion desc;");
    }
    function historialGere($sede)
    {
      return $this->db->query("SELECT * FROM chat c INNER JOIN usuarios u ON u.id_usuario=c.id_usuario INNER JOIN perfilAsesor p ON p.id_usuario=c.id_usuario inner join entradachat e on e.id_usuario=p.id_usuario  WHERE u.id_sede='".$sede."' order by c.fecha_modificacion desc;"); 
    }
    function ConfiguracionAdmin()
    {
      return $this->db->query("SELECT * FROM chatxsede"); 
    }
    function ConfiguracionGte($sede)
    {
      return $this->db->query("SELECT * FROM chatxsede WHERE id_sede in($sede)"); 
    }
    function ConfiguracionSuper($sedes)
    {
        //function ConfiguracionSuper($uno,$dos,$tres)
      //return $this->db->query("SELECT * FROM chatxsede WHERE id_sede=$uno or id_sede=$dos or id_sede=$tres"); 
      return $this->db->query("SELECT * FROM chatxsede WHERE id_sede in($sedes)");
    }
    function CuantosOnline($sede){
      return $this->db->query("select count(*) as cuantos from perfilAsesor p inner join usuarios u on u.id_usuario=p.id_usuario where u.id_sede='$sede' and u.id_rol=7 and p.estatus=1"); 
    }

    function historialAdminPros($fecha1,$fecha2,$sede)
    {
    if($this->session->userdata('id_rol') == 28 || $this->session->userdata('id_rol') == 18 ){
    $sedes = '1,2,3,4,5,6';
    return $this->db->query("WITH CTE AS(
        SELECT c.idgenerado,c.id_sede,CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor,e.nombre,c.fecha_creacion,p.foto,c.id_usuario,c.idchat
        , RN = ROW_NUMBER()OVER(PARTITION BY c.idgenerado ORDER BY c.id_sede)
        FROM chat c
        inner join usuarios u on u.id_usuario=c.id_usuario 
        inner join evidencias e on e.id_Chat=c.idgenerado 
        inner join perfilAsesor p on p.id_usuario=c.id_usuario
        where CAST(c.fecha_creacion as date) >= CAST('$fecha1' AS date) AND CAST(c.fecha_creacion as date) <= CAST('$fecha2' AS date) and c.id_sede in($sede)
    )
    SELECT * FROM CTE
    WHERE RN = 1");
    }else{
    return $this->db->query(" select c.idgenerado,c.id_sede,CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) asesor,e.nombre,c.fecha_creacion from chat c inner join usuarios u on u.id_usuario=c.id_usuario inner join evidencias e on e.id_Chat=c.idgenerado inner join perfilAsesor p on p.id_usuario=c.id_usuario where CAST(c.fecha_creacion as date) >= CAST('$fecha1' AS date) AND CAST(c.fecha_creacion as date) <= CAST('$fecha2' AS date) and c.id_sede in(".$this->session->userdata('id_sede').");");
    }
    }
    function historialSup($uno,$dos,$tres)
    {
      return $this->db->query("SELECT * FROM chat c INNER JOIN usuarios u ON u.id_usuario=c.id_usuario INNER JOIN perfilAsesor p ON p.id_usuario=c.id_usuario inner join entradachat e on e.id_usuario=p.id_usuario  WHERE  u.id_sede='$uno' or u.id_sede='$dos' or u.id_sede='$tres' order by c.fecha_modificacion desc;"); 
    }

    function MisChats($id_usuario)
    {
      return $this->db->query("SELECT * FROM chat WHERE id_usuario=$id_usuario order by idchat desc;"); 
    }
    function NotificacionChat($id,$idAsesor){
        return $query = $this->db->query("select para,recibido from mensajes where id_chat=".$id." and visto=0 and para='".$idAsesor."'");
        //return $query->result_array();
    }
    function NotificacionChatSide($id){
        return $query = $this->db->query("select * from mensajes where visto=0 and para='".$id."' order by fecha_creacion desc;");
        //return $query->result_array();
    }
    function getMischats($idchat){
        return $query = $this->db->query("SELECT mensaje, de, para, visto, recibido, liga, id_chat, fecha_creacion, id_asesor FROM mensajes 
        WHERE id_chat = '$idchat' GROUP BY mensaje, de, para, visto, recibido, liga, id_chat, fecha_creacion, id_asesor ORDER BY fecha_creacion ASC");
        //return $query->result_array();
    }
    function getMischatsActual($mensaje,$idchat){
        return $query = $this->db->query("select * from mensajes where id_chat=$idchat and idmensaje > $mensaje order by fecha_creacion asc;");
        //return $query->result_array();
    }
    function SaveNumeroChat($datos,$id)
    {
        $response = $this->db->update("chatxsede", $datos, " idchatsede = $id");
        if (! $response ) {
            return $finalAnswer = 0;
        } else {
            return $finalAnswer = 1;
        }
    }
    function EstadoPerfil($estado,$id)
    {
        $response = $this->db->update("perfilAsesor", $estado, " id_usuario = ".$id."");
        if (! $response ) {
            return $finalAnswer = 0;
        } else {
            return $finalAnswer = 1;
        }
    }
    function CerrarSesionChat($estado,$id)
    {
        $response = $this->db->update("perfilAsesor", $estado, " id_usuario = ".$id."");
        if (! $response ) {
            return $finalAnswer = 0;
        } else {
            return $finalAnswer = 1;
        }
    }
    function BloquearUsuario($estado,$id)
    {
        $response = $this->db->update("perfilAsesor", $estado, " id_usuario = $id");
        if (! $response ) {
            return $finalAnswer = 0;
        } else {
            return $finalAnswer = 1;
        }
    }

    function ActualizarFechaChat($estado,$id)
    {
        $response = $this->db->update("chat", $estado, " idchat = $id");
        if (! $response ) {
            return $finalAnswer = 0;
        } else {
            return $finalAnswer = 1;
        }
    }

    function CambioSesion($datos,$id)
    {
        $response = $this->db->update("perfilAsesor", $datos, " id_usuario = $id");
        if (! $response ) {
            return $finalAnswer = 0;
        } else {
            return $finalAnswer = 1;
        }
    }

        function saveMsj($data) {
        if ($data != '' && $data != null) {
            $response = $this->db->insert("Mensajes", $data);
            if (!$response) {
                return 0;
            } else {
                return 1;
            }
        } else {
            return 0;
        }
    }
    function InsertEntrada($data) {
        if ($data != '' && $data != null) {
            $response = $this->db->insert("entradachat", $data);
            if (!$response) {
                return 0;
            } else {
                return 1;
            }
        } else {
            return 0;
        }
    }
    function updateEntrada($estado,$id,$fecha)
    {
        $response = $this->db->update("entradachat", $estado, " id_usuario = $id and fecha_entrada = '$fecha'");
        if (! $response ) {
            return $finalAnswer = 0;
        } else {
            return $finalAnswer = 1;
        }
    }
    function saveMsjArch($data) {
        if ($data != '' && $data != null) {
            $response = $this->db->insert("Mensajes", $data);
            if (!$response) {
                return 0;
            } else {
                return 1;
            }
        } else {
            return 0;
        }
    }

    function savePerfil($data) {
        if ($data != '' && $data != null) {
            $response = $this->db->insert("perfilAsesor", $data);
            if (!$response) {
                return 0;
            } else {
                return 1;
            }
        } else {
            return 0;
        }
    }

 function UpdateVisto($data,$id) {
        $response = $this->db->update("mensajes", $data, " id_chat= $id");
        if (! $response ) {
            return 0;
        } else {
            return 1;
        }
    }
     function FinalizarChat($data,$id) {
        $response = $this->db->update("chat", $data, " idchat= $id");
        if (! $response ) {
            return 0;
        } else {
            return 1;
        }
    }
    function DisminuirActivo($id) {
        $response = $this->db->query("UPDATE perfilAsesor SET chat_activos=chat_activos-1 WHERE id_usuario=$id");
        if (! $response ) {
            return 0;
        } else {
            return 1;
        }
    }

    function FinalizarSesionPerfil($data,$id) {
        $response = $this->db->update("perfilAsesor", $data, " id_usuario= $id");
        if (! $response ) {
            return 0;
        } else {
            return 1;
        }
    }
//     public function ultimahora($id)
//     {
//     return $this->db->query(";WITH x AS (SELECT fecha_entrada, r = RANK() OVER (ORDER BY fecha_entrada DESC)
//     FROM dbo.entradachat WHERE id_usuario = $id)
//  SELECT * FROM x WHERE r = 1;");
//     }
    public function ultimoProspecto($tipo,$id)
    {
    return $this->db->query(";WITH x AS (SELECT id_prospecto, r = RANK() OVER (ORDER BY fecha_creacion DESC)
    FROM dbo.prospectos WHERE origen = $tipo and creado_por=$id)
 SELECT * FROM x WHERE r = 1;");
    }
    function FinalizarSesionChat($data,$id) {
        date_default_timezone_set('America/Mexico_City');
$hoy = date("Y-m-d 00:00:00");
        $response = $this->db->update("chat", $data, " id_usuario= $id AND fecha_creacion >= '".$hoy."' ");
        if (! $response ) {
            return 0;
        } else {
            return 1;
        }
    }

    function FinalizarSesionMsj($data,$id) {
        date_default_timezone_set('America/Mexico_City');
        $hoy = date("Y-m-d 00:00:00");
        $response = $this->db->update("mensajes", $data, " para='$id' AND fecha_creacion >= '".$hoy."' ");
        if (! $response ) {
            return 0;
        } else {
            return 1;
        }
    }



 function AutPerfil($data,$id) {
        $response = $this->db->update("perfilAsesor", $data, " id_usuario= $id");
        if (! $response ) {
            return 0;
        } else {
            return 1;
        }
    }
     function UpdateRecibido($data,$id) {
        $response = $this->db->update("mensajes", $data, " id_chat= $id");
        if (! $response ) {
            return 0;
        } else {
            return 1;
        }
    }

    function UpdateRecibidoSide($data,$id) {
        $response = $this->db->update("mensajes", $data, " para='$id'");
        if (! $response ) {
            return 0;
        } else {
            return 1;
        }
    }


    function updatePerfil($data, $id_asesor) {
        $response = $this->db->update("perfilAsesor", $data, " id_usuario = $id_asesor");
        if (! $response ) {
            return 0;
        } else {
            return 1;
        }
    }
    
    function updatePerfilAs($data, $id_asesor) {
        $response = $this->db->update("perfilAsesor", $data, " id_usuario = $id_asesor");
        if (! $response ) {
            return 0;
        } else {
            return 1;
        }
    }

    function getInfoPerfilGte($id_asesor){
        $query = $this->db->query("SELECT * FROM perfilAsesor WHERE id_usuario = ".$id_asesor."");
        return $query->result_array();
    }
function getInfoPerfil($id_asesor){
        $query = $this->db->query("SELECT pa.*, u.id_sede,CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre, u.id_rol FROM perfilAsesor pa 
        INNER JOIN usuarios u ON u.id_usuario=pa.id_usuario WHERE pa.id_usuario =".$id_asesor."");
        return $query->result_array();
    }
  
    function getAllFoldersPDF()
    {
        $this->db->select("*");
        $this->db->where('estatus', 1);
        $query = $this->db->get('archivos_carpetas');
        return $query;
    }
    /*---------------------------------------*/

    function getMemberType(){
        switch ($this->session->userdata('id_rol')) {
            case '5': // ASISTENTE SUBDIRECCIÓN
                return $this->db->query("SELECT id_opcion, nombre FROM opcs_x_cats WHERE id_catalogo = 1 AND estatus = 1 AND id_opcion IN (3, 7, 9) ORDER BY nombre");
                break;
            case '4': // ASISTENTE DIRECCIÓN
            case '6': // ASISTENTE GERENCIA
                return $this->db->query("SELECT id_opcion, nombre FROM opcs_x_cats WHERE id_catalogo = 1 AND estatus = 1 AND id_opcion IN (7, 9) ORDER BY nombre");
                break;
            default: // VE TODOS LOS REGISTROS (SOPORTE)
                return $this->db->query("SELECT id_opcion, nombre FROM opcs_x_cats WHERE id_catalogo = 1 AND estatus = 1 ORDER BY nombre");
                break;
        }
    }

    function getHeadquarter(){
        return $this->db->query("SELECT id_sede id_opcion, nombre FROM sedes WHERE estatus = 1 ORDER BY nombre");
    }

    function getLeadersList($headquarter, $type){
        switch ($type) {
            case '2':// SUBDIRECTOR
                return $this->db->query("SELECT id_usuario, CONCAT(nombre, ' ', apellido_paterno, ' ', ISNULL(apellido_materno, '')) nombre, id_sede FROM usuarios WHERE 
                                        id_rol = 1 AND estatus = 1 ORDER BY nombre");
                break;
            case '3':// GERENTE
                return $this->db->query("SELECT id_usuario, CONCAT(nombre, ' ', apellido_paterno, ' ', ISNULL(apellido_materno, '')) nombre, id_sede FROM usuarios WHERE 
                                        id_rol = 2 AND id_sede LIKE '%".$headquarter."%' AND estatus = 1 ORDER BY nombre");
                break;
            case '4':// ASISTENTE DIRECTOR
                return $this->db->query("SELECT id_usuario, CONCAT(nombre, ' ', apellido_paterno, ' ', ISNULL(apellido_materno, '')) nombre, id_sede FROM usuarios WHERE 
                                        id_rol = 1 AND estatus = 1 ORDER BY nombre");
                break;
            case '5':// ASISTENTE SUBDIRECTOR
                return $this->db->query("SELECT id_usuario, CONCAT(nombre, ' ', apellido_paterno, ' ', ISNULL(apellido_materno, '')) nombre, id_sede FROM usuarios WHERE 
                                        id_rol = 2 AND id_sede LIKE '%".$headquarter."%' AND estatus = 1 ORDER BY nombre");
                break;
            case '6':// ASISTENTE GERENTE
                return $this->db->query("SELECT id_usuario, CONCAT(nombre, ' ', apellido_paterno, ' ', ISNULL(apellido_materno, '')) nombre, id_sede FROM usuarios WHERE 
                                        id_rol = 3 AND id_sede LIKE '%".$headquarter."%' AND estatus = 1 ORDER BY nombre");
                break;
            case '7':// ASESOR
                return $this->db->query("SELECT id_usuario, CONCAT(nombre, ' ', apellido_paterno, ' ', ISNULL(apellido_materno, '')) nombre, id_sede FROM usuarios WHERE 
                                        id_rol = 9 AND id_sede LIKE '%".$headquarter."%' AND estatus = 1 ORDER BY nombre");
                break;
            case '9':// COORDINADOR DE VENTAS
                return $this->db->query("SELECT id_usuario, CONCAT(nombre, ' ', apellido_paterno, ' ', ISNULL(apellido_materno, '')) nombre, id_sede FROM usuarios WHERE 
                                        id_rol = 3 AND id_sede LIKE '%".$headquarter."%' AND estatus = 1 ORDER BY nombre");
                break;
            case '10':// EJECUTIVO ADMINISTRATIVO DE MKTD
            case '19':// SUBDIRECTOR MKTD
            case '25':// ASESOR DE CONTENIDO RRSS
            case '26':// MERCADÓLOGO
            case '27':// COMUNITY MANAGER
            case '28':// EJECUTIVO ADMINISTRATIVO
            case '29':// ASESOR COBRANZA
            case '30':// DESARROLLO WEB
            return $this->db->query("SELECT id_usuario, CONCAT(nombre, ' ', apellido_paterno, ' ', ISNULL(apellido_materno, '')) nombre, id_sede FROM usuarios WHERE 
                                        id_rol = 18 AND estatus = 1 ORDER BY nombre");
                break;
            case '20':// GERENTE MKTD
                return $this->db->query("SELECT id_usuario, CONCAT(nombre, ' ', apellido_paterno, ' ', ISNULL(apellido_materno, '')) nombre, id_sede FROM usuarios WHERE 
                                        id_rol = 19 AND id_sede LIKE '%".$headquarter."%' AND estatus = 1 ORDER BY nombre");
                break;
            case '1':// DIRECTOR
            case '8':// SOPORTE
            case '11':// ADMINISTRACIÓN
            case '12':// CAJA
            case '13':// CONTRALORÍA
            case '14':// DIRECCIÓN ADMINISTACIÓN
            case '15':// JURÍDICO
            case '16':// CONTRATACIÓN
            case '17':// SUBDIRECTOR CONTRALORÍA
            case '18':// DIRECTOR MKTD
            case '21':// CLIENTE
            case '22':// EJECUTIVO CLUB MADERAS
            case '23':// SUBDIRECTOR CLUB MADERAS
            case '24':// ASESOR USA
            case '31': // INTERNOMEX
            default:
                return $this->db->query("SELECT id_usuario, CONCAT(nombre, ' ', apellido_paterno, ' ', ISNULL(apellido_materno, '')) nombre, id_sede FROM usuarios WHERE 
                                        id_rol = 100 AND estatus = 1 ORDER BY nombre");
                break;
        }
    }

    function saveUser($data) {
        if ($data != '' && $data != null) {
            $response = $this->db->insert("usuarios", $data);
            if (!$response) {
                return $finalAnswer = 0;
            } else {
                return $finalAnswer = 1;
            }
        } else {
            return 0;
        }
    }

    function changeUserStatus($data, $id_usuario) {
        $response = $this->db->update("usuarios", $data, "id_usuario = $id_usuario");
        if (! $response ) {
            return $finalAnswer = 0;
        } else {
            return $finalAnswer = 1;
        }
    }

    function getUserInformation($id_usuario){
        $query = $this->db->query("SELECT * FROM usuarios WHERE id_usuario = ".$id_usuario."");
        return $query->result_array();
    }

    function updateUser($data, $id_usuario) {
        $response = $this->db->update("usuarios", $data, "id_usuario = $id_usuario");
        if (! $response ) {
            return $finalAnswer = 0;
        } else {
            return $finalAnswer = 1;
        }
    }

    function getSedes($id_sede){
        $query =$this->db->query("SELECT * FROM sedes WHERE id_sede = $id_sede");
        return $query->row();
    }

    function getSedesByUser($usuario,$rol){
        if($rol == '19'){
            $query2 = $this->db->query("SELECT id_sede FROM usuarios WHERE id_usuario = '$usuario'");
            $res = $query2->result_array();
            $sedes = $res[0]['id_sede'];
            $query =$this->db->query("SELECT s.id_sede, s.nombre FROM sedes s WHERE id_sede IN ($sedes)");
        }else{
            $query =$this->db->query("SELECT u.id_sede, s.nombre FROM usuarios u
            INNER JOIN sedes s ON s.id_sede = u.id_sede WHERE id_usuario = $usuario");
        }
        
        return $query->result_array();
    }

    function getSedesList(){
        $query =$this->db->query("SELECT id_sede, nombre FROM sedes");
        return $query->result_array();
    }
    function checkIfIsGuarrior($id_usuario){
      $query = $this->db->query("SELECT * FROM perfilAsesor WHERE estatus=1 AND id_usuario = ".$id_usuario);
      return $query->result_array();
    }

    function getCorreos($sede){
        $query = $this->db->query("SELECT u.id_usuario, u.correo, u.id_rol
        FROM usuarios u WHERE u.id_sede LIKE '%$sede%' AND u.id_rol = 19 AND u.estatus = 1");
        return $query->result_array();
    }
     
    function insertRegistroLp($data){
        $response = $this->db->insert('registros_lp', $data);
        if (!$response) {
            return $finalAnswer = 0;
        } else {
            return $finalAnswer = 1;
        }
    }

}
