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
        return $this->db->query("SELECT res.nombreResidencial,con.nombre AS condominio, lot.nombreLote, lot.idLote ,lot.sup AS superficie, lot.precio, lot.observacionLiberacion AS observacion 
        FROM lotes lot
        INNER JOIN condominios con ON con.idCondominio = lot.idCondominio
        INNER JOIN residenciales res on res.idResidencial = con.idResidencial
        INNER JOIN loteXReubicacion lotx ON lotx.proyectoReubicacion = con.idResidencial and lotx.idProyecto in ($id_proyecto)
        INNER JOIN clientes cli ON cli.id_cliente = lot.idCliente and cli.status = 1")->result();
    }


    public function aplicaLiberacion($datos){
        $row = $this->db-> query("SELECT idLote, nombreLote, status, sup,totalNeto2,idCliente,registro_comision,tipo_venta FROM lotes WHERE idLote=".$datos['idLote']." AND status = 1")->result_array();
        $registro_comision = $datos['tipo'] == 7 ? 9 : 8;
        $idStatusLote = $datos['tipo'] == 9 ? 13 : 1;
        $datos['tipo'] == 7 ? $this->db->query("UPDATE lotes SET tipo_venta=".$row['tipo_venta'].",usuario='".$datos['userLiberacion']."' WHERE idLote=".$datos['idLoteNuevo']." ") : '';
        $this->db->trans_begin();
            $banderaComisionCl = $datos['tipo'] == 7 ? ' ,banderaComisionCl ='.$row['registro_comision'] : '';
            $id_cliente = $this->db->query("SELECT id_cliente FROM clientes WHERE status = 1 AND idLote IN (" . $row['idLote'] . ") ")->result_array();
            $this->db->query("UPDATE historial_documento SET status = 0 WHERE status = 1 AND idLote IN (".$row['idLote'].") ");
            $this->db->query("UPDATE prospectos SET tipo = 0, estatus_particular = 4, modificado_por = 1, fecha_modificacion = GETDATE() WHERE id_prospecto IN (SELECT id_prospecto FROM clientes WHERE status = 1 AND idLote = ".$row['idLote'].")");
            $this->db->query("UPDATE clientes SET status = 0,proceso=".$datos['tipo'].",totalNeto2Cl=".$row['totalNeto2']." $banderaComisionCl WHERE status = 1 AND idLote IN (".$row['idLote'].") ");
            $this->db->query("UPDATE historial_enganche SET status = 0, comentarioCancelacion = 'LOTE LIBERADO' WHERE status = 1 AND idLote IN (".$row['idLote'].") ");
            $this->db->query("UPDATE historial_lotes SET status = 0 WHERE status = 1 AND idLote IN (".$row['idLote'].") ");


            $comisiones = $this->db->query("SELECT id_comision,id_lote,comision_total,id_usuario,rol_generado,porcentaje_decimal FROM comisiones where id_lote=".$row['idLote']." AND estatus=1")->result_array();
            for ($i=0; $i <count($comisiones) ; $i++) {
            $sumaxcomision=0;
            $pagos_ind = $this->db->query("SELECT * FROM pago_comision_ind WHERE id_comision=".$comisiones[$i]['id_comision']."")->result_array();
            for ($j=0; $j <count($pagos_ind) ; $j++) { 
                $sumaxcomision = $sumaxcomision + $pagos_ind[$j]['abono_neodata'];
            }
            if($datos['tipo'] == 7 && $row['registro_comision'] == 1){
                    $nuevaComision = $comisiones[$i]['comision_total'] - $sumaxcomision;
                    $this->db->query("INSERT INTO comisionesReubicadas VALUES(".$comisiones[$i]['id_usuario'].",".$nuevaComision.",".$comisiones[$i]['porcentaje_decimal'].",".$comisiones[$i]['rol_generado'].",".$row['idCliente'].",".$row['idLote'].",'".$datos['userLiberacion']."','".date("Y-m-d H:i:s")."')");
            }
            $this->db->query("UPDATE comisiones SET modificado_por='" . $datos['userLiberacion'] . "',comision_total=$sumaxcomision,estatus=8 where id_comision=".$comisiones[$i]['id_comision']." ");
            }
            $this->db->query("UPDATE pago_comision SET bandera=0,total_comision=0,abonado=0,pendiente=0,ultimo_pago=0  WHERE id_lote=".$row['idLote']." ");


            if($row['tipo_venta'] == 1){
                if($datos['tipo'] == 7){
                    $clausula = $this->db->query("SELECT TOP 1 id_clausula,nombre FROM clausulas WHERE id_lote = ".$datos['idLote']." ORDER BY id_clausula DESC")->result_array();
                    $this->db->query("INSERT INTO clausulas VALUES(".$datos['idLoteNuevo'].",'".$clausula['nombre']."',1,GETDATE(),'".$datos['userLiberacion']."');");
                }
                $this->db->query("UPDATE clausulas SET estatus = 0 WHERE id_lote=".$datos['idLote']." AND estatus = 1");
            }


                $data_l = array(
                    'nombreLote'=> $datos['nombreLote'],
                    'comentarioLiberacion'=> $datos['comentarioLiberacion'],
                    'observacionLiberacion'=> $datos['observacionLiberacion'],
                    'precio'=> $datos['precio'],
                    'fechaLiberacion'=> $datos['fechaLiberacion'],
                    'modificado'=> $datos['modificado'],
                    'status'=> $datos['status'],
                    'idLote'=> $row['idLote'],
                    'tipo'=> $datos['tipo'],
                    'userLiberacion'=> $datos['userLiberacion'],
                    'id_cliente' => (count($id_cliente)>=1 ) ? $id_cliente[0]['id_cliente'] : 0

                    );

                    $this->db->insert('historial_liberacion',$data_l);

                    $this->db->query("UPDATE lotes SET idStatusContratacion = 0,
                    idMovimiento = 0, comentario = 'NULL', idCliente = 0, usuario = 'NULL', perfil = 'NULL ', 
                    fechaVenc = null, modificado = null, status8Flag = 0, 
                    ubicacion = 0, totalNeto = 0, totalNeto2 = 0,
                    casa = (CASE WHEN idCondominio IN (759, 639) THEN 1 ELSE 0 END),
                    totalValidado = 0, validacionEnganche = 'NULL', 
                    fechaSolicitudValidacion = null, 
                    fechaRL = null, 
                    registro_comision = $registro_comision,
                    tipo_venta = 0, 
                    observacionContratoUrgente = null,
                    firmaRL = 'NULL', comentarioLiberacion = '".$datos['comentarioLiberacion']."', 
                    observacionLiberacion = '".$datos['observacionLiberacion']."', idStatusLote = $idStatusLote, 
                    fechaLiberacion = GETDATE(), 
                    userLiberacion = '".$datos['userLiberacion']."',
                    precio = ".$datos['precio'].", total = ((".$datos['sub'].") * ".$datos['precio']."),
                    enganche = (((".$row['sub'].") * ".$datos['precio'].") * 0.1), 
                    saldo = (((".$row['sub'].") * ".$datos['precio'].") - (((".$row['sub'].") * ".$datos['precio'].") * 0.1)),
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