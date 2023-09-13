<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Reestructura_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_proyecto_lista(){
        return $this->db->query("SELECT idResidencial,CONCAT(nombreResidencial ,' - ', descripcion) as descripcion FROM residenciales WHERE status = 1 and idResidencial in (30,21,25,13)");
    }

    public function get_valor_lote($id_proyecto)
    {
        return $this->db->query("SELECT res.nombreResidencial,con.nombre AS condominio, lot.nombreLote, lot.idLote ,lot.sup AS superficie, lot.precio, CONCAT(cli.nombre,' ',cli.apellido_paterno,' ',cli.apellido_materno) nombreCliente,lot.observacionLiberacion AS observacion 
        FROM lotes lot
        INNER JOIN condominios con ON con.idCondominio = lot.idCondominio
        INNER JOIN residenciales res on res.idResidencial = con.idResidencial
        INNER JOIN loteXReubicacion lotx ON lotx.proyectoReubicacion = con.idResidencial and lotx.idProyecto in ($id_proyecto)
        LEFT JOIN clientes cli ON cli.id_cliente = lot.idCliente and cli.status in (1,0) and lot.idStatusLote in (15,2,3)")->result();
    }


    public function aplicaLiberacion($datos){

        $comentarioLiberacion = $datos['tipoLiberacion'] == 7 ? 'LIBERADO POR REUBICACIÓN' : ( $datos['tipoLiberacion'] == 9 ? 'LIBERACIÓN JURÍDICA' : ($datos['tipoLiberacion'] == 8 ? 'LIBERADO POR REESTRUCTURA' : '') );
        $observacionLiberacion = $datos['tipoLiberacion'] == 7 ? 'LIBERADO POR REUBICACIÓN' : ( $datos['tipoLiberacion'] == 9 ? 'LIBERACIÓN JURÍDICA' : ($datos['tipoLiberacion'] == 8 ? 'LIBERADO POR REESTRUCTURA' : '') );
        $datos["comentarioLiberacion"] = $comentarioLiberacion;
        $datos["observacionLiberacion"] = $observacionLiberacion;
        $datos["fechaLiberacion"] = date('Y-m-d H:i:s');
        $datos["modificado"] = date('Y-m-d H:i:s');
        $datos["status"] = 1;
        $datos["userLiberacion"] = $this->session->userdata('id_usuario');
        $datos["tipo"] = $datos['tipoLiberacion'];


        $row = $this->db->query("SELECT idLote, nombreLote, status, sup,precio,ubicacion,
        (CASE WHEN totalNeto2 IS NULL THEN 0.00 ELSE totalNeto2 END) totalNeto2,
        (CASE WHEN idCliente = 0  OR idCliente IS NULL THEN 0 ELSE idCliente END) idCliente,registro_comision,
        (CASE WHEN tipo_venta IS NULL THEN 0 ELSE tipo_venta END) tipo_venta FROM lotes WHERE idLote=".$datos['idLote']." AND status = 1")->result_array();
        $registro_comision = ($datos['tipo'] == 7 || $datos['tipo'] == 8) ? 9 : 8;
        $idStatusLote = $datos['tipo'] == 9 ? 15 :($datos['tipo'] == 8  ? 3 : 1);
        $this->db->trans_begin();
        //($datos['tipo'] == 7 || $datos['tipo'] == 8) ? $this->db->query("UPDATE lotes SET tipo_venta=".$row[0]['tipo_venta'].",usuario='".$datos['userLiberacion']."' WHERE idLote=".$datos['idLoteNuevo']." ") : '';
            $banderaComisionCl = ($datos['tipo'] == 7 || $datos['tipo'] == 8) ? ' ,banderaComisionCl ='.$row[0]['registro_comision'] : '';
            $id_cliente = $this->db->query("SELECT id_cliente FROM clientes WHERE status = 1 AND idLote IN (" . $row[0]['idLote'] . ") ")->result_array();
            $this->db->query("UPDATE historial_documento SET status = 0 WHERE status = 1 AND idLote IN (".$row[0]['idLote'].") ");
            $this->db->query("UPDATE prospectos SET tipo = 0, estatus_particular = 4, modificado_por = 1, fecha_modificacion = GETDATE() WHERE id_prospecto IN (SELECT id_prospecto FROM clientes WHERE status = 1 AND idLote = ".$row[0]['idLote'].")");
            $this->db->query("UPDATE clientes SET status = 0, tipoLiberacion= ".$datos['tipo'].",totalNeto2Cl=".$row[0]['totalNeto2']." $banderaComisionCl WHERE status = 1 AND idLote IN (".$row[0]['idLote'].") ");
            $this->db->query("UPDATE historial_enganche SET status = 0, comentarioCancelacion = 'LOTE LIBERADO' WHERE status = 1 AND idLote IN (".$row[0]['idLote'].") ");
            $this->db->query("UPDATE historial_lotes SET status = 0 WHERE status = 1 AND idLote IN (".$row[0]['idLote'].") ");

            $datos['tipo'] == 8 ? $this->db->query("UPDATE clientes SET idLote=".$datos['idLote']." WHERE id_cliente=".$datos['idClienteNuevo'].";")  : '' ;
            $comisiones = $this->db->query("SELECT id_comision,id_lote,comision_total,id_usuario,rol_generado,porcentaje_decimal FROM comisiones where id_lote=".$row[0]['idLote']." AND estatus=1")->result_array();
            for ($i=0; $i <count($comisiones) ; $i++) {
            $sumaxcomision=0;
            $pagos_ind = $this->db->query("SELECT * FROM pago_comision_ind WHERE id_comision=".$comisiones[$i]['id_comision']."")->result_array();
            for ($j=0; $j <count($pagos_ind) ; $j++) { 
                $sumaxcomision = $sumaxcomision + $pagos_ind[$j]['abono_neodata'];
            } 
            if(($datos['tipo'] == 7 || $datos['tipo'] == 8) && $row[0]['registro_comision'] == 1){
                    $nuevaComision = $comisiones[$i]['comision_total'] - $sumaxcomision;
                    $this->db->query("INSERT INTO comisionesReubicadas VALUES(".$comisiones[$i]['id_usuario'].",".$nuevaComision.",".$comisiones[$i]['porcentaje_decimal'].",".$comisiones[$i]['rol_generado'].",".$row[0]['idCliente'].",".$row[0]['idLote'].",'".$datos['userLiberacion']."','".date("Y-m-d H:i:s")."')");
            }
            $this->db->query("UPDATE comisiones SET modificado_por='" . $datos['userLiberacion'] . "',comision_total=$sumaxcomision,estatus=8 where id_comision=".$comisiones[$i]['id_comision']." ");
            }
            $this->db->query("UPDATE pago_comision SET bandera=0,total_comision=0,abonado=0,pendiente=0,ultimo_pago=0  WHERE id_lote=".$row[0]['idLote']." ");


            if($row[0]['tipo_venta'] == 1){
                if($datos['tipo'] == 7 || $datos['tipo'] == 8){
                    $clausula = $this->db->query("SELECT TOP 1 id_clausula,nombre FROM clausulas WHERE id_lote = ".$datos['idLote']." ORDER BY id_clausula DESC")->result_array();
                    $this->db->query("INSERT INTO clausulas VALUES(".$datos['idLoteNuevo'].",'".$clausula['nombre']."',1,GETDATE(),'".$datos['userLiberacion']."');");
                }
                $this->db->query("UPDATE clausulas SET estatus = 0 WHERE id_lote=".$datos['idLote']." AND estatus = 1");
            }


                $data_l = array(
                    'nombreLote'=> $row[0]['nombreLote'],
                    'comentarioLiberacion'=> $datos['comentarioLiberacion'],
                    'observacionLiberacion'=> $datos['observacionLiberacion'],
                    'precio'=> $row[0]['precio'],
                    'fechaLiberacion'=> $datos['fechaLiberacion'],
                    'modificado'=> $datos['modificado'],
                    'status'=> $datos['status'],
                    'idLote'=> $row[0]['idLote'],
                    'tipo'=> $datos['tipo'],
                    'userLiberacion'=> $datos['userLiberacion'],
                    'id_cliente' => (count($id_cliente)>=1 ) ? $id_cliente[0]['id_cliente'] : 0
                    );

                    $this->db->insert('historial_liberacion',$data_l);

                    $idStatusContratacion = $datos["tipo"] == 8 ? 1 : 0;
                    $idClienteNuevo = $datos["tipo"] == 8 ? $datos['idClienteNuevo'] : 0 ;
                    $idMovimiento = $datos["tipo"] == 8 ? 31 : 0;
                    $tipo_venta = $datos["tipo"] == 8 ? $row[0]['tipo_venta'] : 0;
                    $ubicacion = $datos["tipo"] == 8 ? $row[0]['ubicacion'] : 0;
                    $this->db->query("UPDATE lotes SET idStatusContratacion = $idStatusContratacion,
                    idMovimiento = $idMovimiento, comentario = 'NULL', idCliente = $idClienteNuevo, usuario = 'NULL', perfil = 'NULL ', 
                    fechaVenc = null, modificado = null, status8Flag = 0, 
                    ubicacion = 0, totalNeto = 0, totalNeto2 = 0,
                    casa = (CASE WHEN idCondominio IN (759, 639) THEN 1 ELSE 0 END),
                    totalValidado = 0, validacionEnganche = 'NULL', 
                    fechaSolicitudValidacion = null, 
                    fechaRL = null, 
                    registro_comision = $registro_comision,
                    tipo_venta = $tipo_venta, 
                    observacionContratoUrgente = null,
                    firmaRL = 'NULL', comentarioLiberacion = '".$datos['comentarioLiberacion']."', 
                    observacionLiberacion = '".$datos['observacionLiberacion']."', idStatusLote = $idStatusLote, 
                    fechaLiberacion = GETDATE(), 
                    userLiberacion = '".$datos['userLiberacion']."',
                    precio = ".$row[0]['precio'].", total = ((".$row[0]['sup'].") * ".$row[0]['precio']."),
                    enganche = (((".$row[0]['sup'].") * ".$row[0]['precio'].") * 0.1), 
                    saldo = (((".$row[0]['sup'].") * ".$row[0]['precio'].") - (((".$row[0]['sup'].") * ".$row[0]['precio'].") * 0.1)),
                    asig_jur = 0
                    WHERE idLote IN (".$datos['idLote'].") and status = 1");

        if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
        }
        
    }
}