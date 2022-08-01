<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 */
class PaquetesCorrida_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function getTipoDescuento()
    {
        return $this->db->query("select * from tipos_condiciones where id_tcondicion in(1,2,5,12,13)")->result_array();
    }
    public  function get_lista_sedes(){
    return $this->db->query("SELECT * FROM sedes where id_sede in(1,2,3,4,5,6,9) ORDER BY nombre");
    }
    
    public function getResidencialesList($id_sede)
    {
        return $this->db->query("SELECT idResidencial, nombreResidencial, UPPER(CAST(descripcion AS VARCHAR(75))) descripcion, empresa FROM residenciales WHERE status = 1 and sede_residencial=$id_sede ORDER BY nombreResidencial ASC")->result_array();
    }
    public function getDescuentosPorTotal($tdescuento,$id_condicion,$eng_top,$apply)
    {
        return $this->db->query("SELECT id_tdescuento,inicio,fin,id_condicion,eng_top,apply,max(id_descuento) AS id_descuento,porcentaje 
        FROM descuentos WHERE id_tdescuento = $tdescuento AND id_condicion = $id_condicion AND eng_top = $eng_top AND apply = $apply and inicio is null 
        group by id_tdescuento,inicio,fin,id_condicion,eng_top,apply,porcentaje 
        order by porcentaje");
    }

    public function UpdateLotes($desarrollos,$cadena_lotes,$query_superdicie,$query_tipo_lote,$usuario){
        $this->db->query("UPDATE  l  
        set l.id_descuento = '$cadena_lotes',usuario='$usuario'
        from lotes l
        inner join condominios c on c.idCondominio=l.idCondominio 
        inner join residenciales r on r.idResidencial=c.idResidencial
        where r.idResidencial in($desarrollos) 
        $query_superdicie
        $query_tipo_lote"); 
    }

    public function insertBatch($table, $data)
    {
      $row = $this->db->insert_batch($table, $data);
        if ($row === FALSE) { 
            return false;
        } else { 
            return true;
        }
    }

    public function getDescuentos($tdescuento,$id_condicion,$eng_top,$apply)
    {
        return $this->db->query("SELECT c.descripcion,d.id_tdescuento,d.inicio,d.fin,d.id_condicion,d.eng_top,d.apply,max(d.id_descuento) AS id_descuento,d.porcentaje 
        FROM descuentos d
		INNER JOIN condiciones c on c.id_condicion=d.id_condicion
		WHERE d.id_tdescuento = $tdescuento 
		AND d.id_condicion = $id_condicion 
		AND d.eng_top = $eng_top 
		AND d.apply = $apply
		and d.inicio is null 
        group by c.descripcion,d.id_tdescuento,d.inicio,d.fin,d.id_condicion,d.eng_top,d.apply,d.porcentaje 
        order by d.porcentaje");
    }
    public function SaveNewDescuento($tdescuento,$id_condicion,$eng_top,$apply,$descuento){
      $response =  $this->db->query("INSERT INTO descuentos VALUES($tdescuento,NULL,NULL,$id_condicion,$descuento,$eng_top,$apply,NULL)"); 
        if (! $response ) {
            return $finalAnswer = 0;
        } else {
            return $finalAnswer = 1;
        }
    }

    public function ValidarDescuento($tdescuento,$id_condicion,$eng_top,$apply,$descuento)
    {
        return $this->db->query("SELECT c.descripcion,d.id_tdescuento,d.inicio,d.fin,d.id_condicion,d.eng_top,d.apply,max(d.id_descuento) AS id_descuento,d.porcentaje 
        FROM descuentos d
		INNER JOIN condiciones c on c.id_condicion=d.id_condicion
		WHERE d.id_tdescuento = $tdescuento 
		AND d.id_condicion = $id_condicion 
		AND d.eng_top = $eng_top 
		AND d.apply = $apply
        AND d.porcentaje=$descuento
		and d.inicio is null 
        group by c.descripcion,d.id_tdescuento,d.inicio,d.fin,d.id_condicion,d.eng_top,d.apply,d.porcentaje 
        order by d.porcentaje");
    }
 

public function getPaquetesByLotes($desarrollos,$query_superdicie,$query_tipo_lote,$superficie,$inicio,$fin){
    date_default_timezone_set('America/Mexico_City');
    $hoy2 = date('Y-d-m H:i:s');
    
    $cuari1 =  $this->db->query("SELECT DISTINCT(l.idCondominio) FROM lotes l
        INNER JOIN condominios c ON c.idCondominio = l.idCondominio 
        INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
        WHERE r.idResidencial IN ($desarrollos)
        $query_superdicie
        $query_tipo_lote 
        GROUP BY l.idCondominio")->result_array();
        
    $imploded = array();
    foreach($cuari1 as $array) {
        $imploded[] = implode(',', $array);
    }
    
    $stack= array();
  
    for ($i=0; $i < sizeof($cuari1); $i++) {
        $arrCondominio= implode(",", $cuari1[$i]);
        $queryRes =  $this->db->query("DECLARE @condominio varchar(200), @tags VARCHAR(MAX); 
        SET @condominio = ($arrCondominio) 
      
        /*INICIO DEL PROCESO*/ 
        SET @tags = (SELECT STRING_AGG(CONVERT(VARCHAR(MAX),(id_descuento) ), ',') 
        FROM lotes l 
        INNER JOIN condominios c ON c.idCondominio = l.idCondominio 
        INNER JOIN residenciales r ON r.idResidencial = c.idResidencial 
        WHERE c.idCondominio IN (@condominio)) 
      
        (SELECT 
        @condominio condominio, STRING_AGG(id_paquete, ',') paquetes, fecha_inicio, fecha_fin, 
        UPPER(CONCAT('PAQUETE ', DATENAME(MONTH, fecha_inicio), ' ', YEAR(fecha_inicio))) descripcion 
        FROM paquetes 
        WHERE id_paquete in (SELECT DISTINCT(value) FROM STRING_SPLIT(@tags, ',') WHERE RTRIM(value) <> '') 
        GROUP BY fecha_inicio, fecha_fin)");
        
        foreach ($queryRes->result() as  $valor) {
  
        array_push($stack, array('condominio' => $valor->condominio, 'paquetes' => $valor->paquetes, 'fecha_inicio' => $valor->fecha_inicio, 'fecha_fin' => $valor->fecha_fin, 'descripcion' => $valor->descripcion));
  
    }
  }
  $getPaquetesByName = $stack;
  
//   print_r( $getPaquetesByName);
  $datosInsertar_x_condominio = array();
  for ($o=0; $o <count($getPaquetesByName) ; $o++) {
    $json = array();
    if(!empty($getPaquetesByName[$o]['paquetes'])){
        array_push($json,array( 
            "paquetes" => $getPaquetesByName[$o]['paquetes'],
            "tipo_superficie" => array("tipo" => $superficie,
            "sup1" => $inicio,
            "sup2" => $fin) ));
            
            $json = json_encode($json);
            $json = ltrim($json,'[');
            $json = rtrim($json,']');
            
            $array_x_condominio =array(
                'id_condominio' => $getPaquetesByName[$o]['condominio'],
                'id_paquete' => $json,
                'nombre' => $getPaquetesByName[$o]['descripcion'],
                'fecha_inicio' =>  $getPaquetesByName[$o]['fecha_inicio'],
                'fecha_fin' =>  $getPaquetesByName[$o]['fecha_fin'],
                'estatus' => 1,
                'creado_por' => $this->session->userdata('id_usuario'),
                'fecha_modificacion' =>  $hoy2,
                'modificado_por' => $this->session->userdata('id_usuario'),
                'list_paquete' => $getPaquetesByName[$o]['paquetes']);
                
                array_push($datosInsertar_x_condominio,$array_x_condominio);
            }
        }
        if(count($datosInsertar_x_condominio) > 0){
            $this->PaquetesCorrida_model->insertBatch('paquetes_x_condominios',$datosInsertar_x_condominio);
        }
    }
    



}
