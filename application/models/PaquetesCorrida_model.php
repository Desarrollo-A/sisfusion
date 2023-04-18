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
        return $this->db->query("SELECT * FROM condiciones WHERE estatus = 1")->result_array();
    }
    public  function get_lista_sedes(){
    return $this->db->query("SELECT * FROM sedes where id_sede in(1,2,3,4,5,6,9) ORDER BY nombre");
    }
    
    public function getResidencialesList($id_sede)
    {
        return $this->db->query("SELECT idResidencial, nombreResidencial, UPPER(CAST(descripcion AS VARCHAR(75))) descripcion, empresa FROM residenciales WHERE status = 1 and sede_residencial=$id_sede ORDER BY nombreResidencial ASC")->result_array();
    }
    public function getDescuentosPorTotal($id_condicion)
    {
        //Modificar
        return $this->db->query("SELECT de.inicio, de.fin, de.id_condicion,max(de.id_descuento) AS de.id_descuento, de.porcentaje 
        FROM descuentos de
        INNER JOIN condiciones co ON co.id_condicion = de.id_condicion
        WHERE de.id_condicion = $id_condicion AND de.inicio is null 
        group by de.inicio, de.fin, de.id_condicion, de.porcentaje 
        order by de.porcentaje");
    }
 
    public function UpdateLotes($desarrollos,$cadena_lotes,$query_superdicie,$query_tipo_lote,$usuario,$inicio,$fin){
        $this->db->query("UPDATE  l 
        set l.id_descuento = '$cadena_lotes',usuario='$usuario'
        from lotes l
        inner join condominios c on c.idCondominio=l.idCondominio 
        inner join residenciales r on r.idResidencial=c.idResidencial
        where r.idResidencial in($desarrollos)  and l.idStatusLote = 1 
        $query_superdicie
        $query_tipo_lote");

        $this->db->query("UPDATE  l 
        SET l.id_descuento = '$cadena_lotes',usuario='$usuario'
        FROM lotes l
        INNER JOIN condominios c ON c.idCondominio=l.idCondominio 
        INNER JOIN residenciales r ON r.idResidencial=c.idResidencial
        INNER JOIN clientes cl ON cl.id_cliente=l.idCliente
        WHERE r.idResidencial IN($desarrollos) AND l.idStatusLote IN (3, 2)
        AND cl.fechaApartado BETWEEN '$inicio 00:00:00.000' AND '$fin 23:59:59.999'
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

    public function getDescuentos($primeraCarga, $tipoCondicion){
        $queryFinal = ''; $condiciones = '';

        if($primeraCarga == 1)
            $condiciones = $this->db->query("SELECT * FROM condiciones WHERE estatus = 1")->result_array();
        else
            $condiciones = $this->db->query("SELECT * FROM condiciones WHERE estatus = 1 AND id_condicion = $tipoCondicion")->result_array();

        foreach ($condiciones as $index => $valor) {
            $id_condicion = $valor['id_condicion'];
            $queryFinal .= "SELECT c.descripcion, d.inicio, d.fin, d.id_condicion,
            MAX(d.id_descuento) AS id_descuento, d.porcentaje 
            FROM descuentos d
            INNER JOIN condiciones c ON c.id_condicion = d.id_condicion
            WHERE d.id_condicion = $id_condicion 
            AND d.inicio IS NULL
            GROUP BY c.descripcion, d.inicio, d.fin, d.id_condicion, d.porcentaje";
            if( ($index+1) != count($condiciones)) {
                $queryFinal .= " UNION ALL ";
            }
        }
        
        $data = $this->db->query("$queryFinal ORDER BY id_condicion, d.porcentaje")->result_array();
        $allArray = array();
        foreach ($condiciones as $indexC => $condicion) {
            $arrayXCondicion = array();
            foreach ($data as $indexD => $valor) {
                if( $condicion['id_condicion'] == $valor['id_condicion'])
                    $arrayXCondicion[] = $valor;
            }

            $allArray[] = array("condicion" => $condicion, "data" => $arrayXCondicion, );
        }
        
        return $allArray;
    }

    public function SaveNewDescuento($id_condicion,$descuento){
      $response =  $this->db->query("INSERT INTO descuentos VALUES(NULL,NULL,$id_condicion,$descuento,NULL)"); 
      
        if (! $response ) {
            return $finalAnswer = 0;
        } else {
            $finalAnswer = $this->db->query("SELECT IDENT_CURRENT('descuentos') as lastId")->result_array();
            return $finalAnswer;
        }
    }

    public function ValidarDescuento($id_condicion,$descuento)
    {
        return $this->db->query("SELECT c.descripcion,d.inicio,d.fin,d.id_condicion,max(d.id_descuento) AS id_descuento,d.porcentaje 
        FROM descuentos d
		INNER JOIN condiciones c on c.id_condicion=d.id_condicion
		AND d.id_condicion = $id_condicion
        AND d.porcentaje=$descuento
		and d.inicio is null 
        group by c.descripcion,d.inicio,d.fin,d.id_condicion,d.porcentaje 
        order by d.porcentaje");
    }
 

public function getPaquetesByLotes($desarrollos,$query_superdicie,$query_tipo_lote,$superficie,$inicio,$fin){
    date_default_timezone_set('America/Mexico_City');
    $hoy2 = date('Y-m-d H:i:s');
    
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
     
    public function getPaquetes($query_tipo_lote,$query_superdicie,$desarrollos, $fechaInicio, $fechaFin){
        return  $this->db->query("SELECT STRING_AGG(t.descuentos, ',') id_descuento FROM (
        SELECT DISTINCT(id_descuento) descuentos
        FROM lotes l
        INNER JOIN condominios c ON c.idCondominio = l.idCondominio 
        INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
        where l.idStatusLote = 1 AND r.idResidencial IN ($desarrollos) AND id_descuento IS NOT NULL
        $query_superdicie
        $query_tipo_lote
        UNION ALL
        SELECT DISTINCT(id_descuento) descuentos
        FROM lotes l
        INNER JOIN clientes cl ON cl.id_cliente = l.idCliente AND cl.status = 1 AND cl.fechaApartado BETWEEN '$fechaInicio 00:00:00.000' AND '$fechaFin 23:59:59.999'
        INNER JOIN condominios c ON c.idCondominio = l.idCondominio 
        INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
        where l.idStatusLote = 3 AND r.idResidencial IN ($desarrollos) AND id_descuento IS NOT NULL
        $query_superdicie
        $query_tipo_lote
        ) t")->result_array();
    }

    public function getPaquetesById($id_paquete){
        return  $this->db->query("SELECT * FROM paquetes WHERE id_paquete in($id_paquete)")->result_array();
    }

    public function getDescuentosByPlan($id_paquete,$id_tcondicion){
        return  $this->db->query("SELECT r.*,d.*,c.descripcion FROM relaciones r 
        INNER JOIN descuentos d ON d.id_descuento=r.id_descuento
        INNER JOIN condiciones c ON c.id_condicion = d.id_condicion
        WHERE r.id_paquete IN ($id_paquete) AND c.id_condicion=$id_tcondicion ORDER BY r.prioridad ASC")->result_array();
    }
}
