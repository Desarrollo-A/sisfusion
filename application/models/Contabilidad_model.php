<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Contabilidad_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function getTotalSalesByMonth()
    {
        return $this->db->query("");
    }

    public function getInformation($idLote)
    {
        return $this->db->query("SELECT l.idLote, UPPER(CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno)) nombreCliente, l.nombreLote,
        l.sup superficie, FORMAT(precio, 'C') preciom2, FORMAT(l.totalNeto2, 'C') total, hl.modificado, dxl.id_dxl,
		dxl.fecha_firma, dxl.adendum, dxl.superficie_postventa, dxl.costo_m2, dxl.parcela, dxl.superficie_proyectos, 
		dxl.presupuesto_m2, dxl.deduccion, dxl.m2_terreno, dxl.costo_terreno, dxl.comentario, dxl.unidad, dxl.calle_exacta, 
		dxl.num_ext, dxl.codigo_postal, dxl.colonia , dxl.folio_real
        FROM lotes l 
        INNER JOIN clientes c ON c.idLote = l.idLote AND c.status = 1
        INNER JOIN (SELECT idLote, MAX(modificado) modificado FROM historial_lotes WHERE status = 1 AND idStatusContratacion = 9 AND idMovimiento = 39 
        GROUP BY idLote, idStatusContratacion, idMovimiento) hl ON hl.idLote = l.idLote
		LEFT JOIN detalles_x_lotes dxl ON dxl.id_lote = l.idLote AND dxl.id_cliente = c.id_cliente AND dxl.estatus = 1
        WHERE l.idLote IN ($idLote) AND l.idStatusContratacion = 15 AND l.idMovimiento = 45 AND l.idStatusLote = 2");
    }

    public function getTypeTransaction($idLote)
    {
        // MJ: typeTransaction == 0 NO EXISTE REGISTRO EN detalles_x_lotes | typeTransaction == 1 EXISTE REGISTRO EN detalles_x_lotes
        return $this->db->query("SELECT l.idLote, c.id_cliente, (CASE WHEN dxl.id_dxl IS NULL THEN 0 ELSE 1 END) typeTransaction,
        dxl.id_dxl FROM lotes l 
        INNER JOIN clientes c ON c.idLote = l.idLote AND c.status = 1
		LEFT JOIN detalles_x_lotes dxl ON dxl.id_lote = l.idLote AND dxl.id_cliente = c.id_cliente AND dxl.estatus = 1
        WHERE l.idLote IN ($idLote) ORDER BY l.idLote");
    }

    public function insertData($insertArrayData)
    {
        $this->db->trans_begin();
        $this->db->insert_batch('detalles_x_lotes', $insertArrayData);
        if ($this->db->trans_status() === FALSE) { // Hubo errores en la consulta, entonces se cancela la transacción.
            $this->db->trans_rollback();
            return false;
        } else { // Todas las consultas se hicieron correctamente.
            $this->db->trans_commit();
            return true;
        }
    }

    public function updateData($updateArrayData)
    {
        $this->db->trans_begin();
        $this->db->update_batch('detalles_x_lotes', $updateArrayData, 'id_dxl');
        if ($this->db->trans_status() === FALSE) { // Hubo errores en la consulta, entonces se cancela la transacción.
            $this->db->trans_rollback();
            return false;
        } else { // Todas las consultas se hicieron correctamente.
            $this->db->trans_commit();
            return true;
        }
    }

    public function getClientLote($idLote)
    {
        return $this->db->query("SELECT l.idLote, l.nombreLote, c.id_cliente, UPPER(CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno)) nombreCliente 
        FROM lotes l
        INNER JOIN clientes c ON c.idLote = l.idLote AND c.status = 1 
        WHERE l.idLote IN ($idLote) ORDER BY l.idLote");
    }

    public function getInformationFromNeoData($empresa, $idProyecto, $idCliente, $fechaIni, $fechaFin, $dates)
    {   
        return $this->programacion->query("EXEC [programacion].[dbo].[CDM025Lotificacion]
        @empresa = '$empresa', --Empresa a consultar, el cual es obligatorio
        @IdProyecto = ".($idProyecto == NULL ? 'NULL' : $idProyecto).", -- Proyecto a consultar en específico de valor entero, opcional (null)
        @IdCliente = ".($idCliente == NULL ? 'NULL' : $idCliente).", -- Cliente a consultar en específico de valor entero, opcional (null)
        @fechaini = ".($dates == 0 ? 'NULL' : "'".$fechaIni."'").", -- Rango de fechas de contratos de valor string (YYYY-MM-DD), opcional (null)
        @fechafin = ".($dates == 0 ? 'NULL' : "'".$fechaFin."'")." -- Misma estructura, si uno de los dos campos de fecha va nulo, se ignora el filtro por completo");
    }

    public function getEmpresasList()
    {
        return $this->programacion->query("EXEC [programacion].[dbo].[CDM024GetEmpresas] -- Este no necesita parámetros y devuelve de manera dinámica las empresas existentes en NeoData")->result_array();
    }

    public function getProyectosList($empresa)
    {
        return $this->programacion->query("EXEC [programacion].[dbo].[CDM026GetProyectosXEmpresa] 
		@empresa = '$empresa', -- Obligatorio
		@ooam = NULL -- Opcional, con cualquier valor mayor a cero 0 devuelve los proyectos de OOAM también")->result_array();
    }

    public function getClientesList($empresa, $proyecto)
    {
        return $this->programacion->query("EXEC [programacion].[dbo].[CDM027GetClientesXProy]
		@empresa = '$empresa', -- Obligatorio
		@IdProyecto = $proyecto -- Obligatorio de valor entero")->result_array();
    }

    public function getColumns()
    {
        return $this->db->query("SELECT t1.nombre_columna,
        t2.id_opcion,
        t2.nombre
        FROM
            (SELECT COLUMN_NAME nombre_columna,
                       CASE COLUMN_NAME
                           WHEN 'fecha_firma' THEN 1
                           WHEN 'adendum' THEN 2
                           WHEN 'superficie_postventa' THEN 3
                           WHEN 'costo_m2' THEN 4
                           WHEN 'parcela' THEN 5
                           WHEN 'superficie_proyectos' THEN 6
                           WHEN 'presupuesto_m2' THEN 7
                           WHEN 'deduccion' THEN 8
                           WHEN 'm2_terreno' THEN 9
                           WHEN 'costo_terreno' THEN 10
                           WHEN 'comentario' THEN 11
                           WHEN 'unidad' THEN 12
                           WHEN 'calle_exacta' THEN 13
                           WHEN 'num_ext' THEN 14
                           WHEN 'codigo_postal' THEN 15
                           WHEN 'colonia' THEN 16
                           WHEN 'folio_real' THEN 17
                       END id_opcion
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_NAME = 'detalles_x_lotes'
            AND COLUMN_NAME NOT IN ('id_dxl',
                                    'id_lote',
                                    'id_cliente',
                                    'estatus',
                                    'fecha_creacion',
                                    'creado_por',
                                    'fecha_modificacion',
                                    'modificado_por')) t1
            LEFT JOIN
            (SELECT id_opcion,
           UPPER(CAST(nombre AS VARCHAR(75))) nombre
        FROM opcs_x_cats
        WHERE id_catalogo = 64) t2 ON (t1.id_opcion = t2.id_opcion);")->result_array();
    }

    
    public function getLotesListC($idCondominio)
    {
        $a = 0;
        return $this->db->query("SELECT l.idLote, UPPER(l.nombreLote) nombreLote, l.idStatusLote, cl.id_cliente
        FROM lotes l 
        INNER JOIN clientes cl ON cl.idLote = l.idLote
        WHERE l.status = 1 AND l.idCondominio IN($idCondominio) AND cl.status = 1")->result_array();
    }


}
