<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comisiones_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        // $this->gphsis = $this->load->database('GPHSIS', TRUE);
    }


    public function getActiveCommissions()
    {

        $query = $this->db-> query("SELECT DISTINCT(l.idLote), l.idStatusContratacion, l.registro_comision, cl.id_cliente, l.nombreLote, l.idStatusContratacion, res.nombreResidencial, cond.nombre as nombreCondominio, l.tipo_venta, l.referencia, vc.id_cliente AS compartida, l.totalNeto, l.totalNeto2, l.plan_enganche, plane.nombre as enganche_tipo, cl.lugar_prospeccion, pc.id_pagoc,
        ae.id_usuario as id_asesor, CONCAT(ae.nombre, ' ', ae.apellido_paterno, ' ',  ae.apellido_paterno) as asesor,
        co.id_usuario as id_coordinador, CONCAT(co.nombre, ' ', co.apellido_paterno, ' ',  co.apellido_paterno) as coordinador,
        ge.id_usuario as id_gerente, CONCAT(ge.nombre, ' ', ge.apellido_paterno, ' ',  ge.apellido_paterno) as gerente,
        su.id_usuario as id_subdirector, CONCAT(su.nombre, ' ', su.apellido_paterno, ' ',  su.apellido_paterno) as subdirector,
        di.id_usuario as id_director, CONCAT(di.nombre, ' ', di.apellido_paterno, ' ',  di.apellido_paterno) as director
        FROM lotes l
        INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
        INNER JOIN condominios cond ON l.idCondominio=cond.idCondominio
        INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
        INNER JOIN pago_comision pc ON pc.id_lote = l.idLote
        LEFT JOIN opcs_x_cats plane ON plane.id_opcion= l.plan_enganche AND plane.id_catalogo = 39
        LEFT JOIN ventas_compartidas vc ON vc.id_cliente = cl.id_cliente AND vc.estatus = 1
        INNER JOIN usuarios ae ON ae.id_usuario = cl.id_asesor
        LEFT JOIN usuarios co ON co.id_usuario = ae.id_lider
        LEFT JOIN usuarios ge ON ge.id_usuario = cl.id_gerente
        LEFT JOIN usuarios su ON su.id_usuario = ge.id_lider
        LEFT JOIN usuarios di ON di.id_usuario = su.id_lider
        WHERE l.idStatusContratacion BETWEEN 9 AND 15 AND cl.status = 1 AND l.status = 1 
        AND pc.bandera in (1,5,55)
        AND l.registro_comision in (1) 
        AND l.tipo_venta IS NOT NULL AND l.tipo_venta IN (1, 2)
        /*AND cl.fechaApartado >= '2020-03-01'*/
        ORDER BY l.idLote");
        return $query->result();

    }



    public function getInCommissions($idlote)
    {

        $query = $this->db-> query("(SELECT DISTINCT(l.idLote), l.idStatusContratacion, l.registro_comision, cl.id_cliente, 
 CONCAT(cl.nombre,' ',cl.apellido_paterno,' ',cl.apellido_materno) nombre_cliente, l.nombreLote, l.idStatusContratacion, 
                res.nombreResidencial, cond.nombre as nombreCondominio, l.tipo_venta, l.referencia, vc.id_cliente AS compartida, l.totalNeto, 
                l.totalNeto2, l.plan_enganche, plane.nombre as enganche_tipo, cl.lugar_prospeccion,
                      ae.id_usuario as id_asesor, CONCAT(ae.nombre, ' ', ae.apellido_paterno, ' ',  ae.apellido_paterno) as asesor,
                      co.id_usuario as id_coordinador, CONCAT(co.nombre, ' ', co.apellido_paterno, ' ',  co.apellido_paterno) as coordinador,
                      ge.id_usuario as id_gerente, CONCAT(ge.nombre, ' ', ge.apellido_paterno, ' ',  ge.apellido_paterno) as gerente,
                      su.id_usuario as id_subdirector, CONCAT(su.nombre, ' ', su.apellido_paterno, ' ',  su.apellido_paterno) as subdirector,
                      di.id_usuario as id_director, CONCAT(di.nombre, ' ', di.apellido_paterno, ' ',  di.apellido_paterno) as director, pc.fecha_modificacion,
                      convert(nvarchar, pc.fecha_modificacion, 6) date_final
                      FROM  lotes l
                      INNER JOIN  clientes cl ON cl.id_cliente = l.idCliente
                      INNER JOIN  condominios cond ON l.idCondominio=cond.idCondominio
                      INNER JOIN  residenciales res ON cond.idResidencial = res.idResidencial
                      LEFT JOIN  pago_comision pc ON pc.id_lote = l.idLote AND pc.bandera in (0)
                      LEFT JOIN  opcs_x_cats plane ON plane.id_opcion= l.plan_enganche AND plane.id_catalogo = 39
                      LEFT JOIN (SELECT id_cliente FROM ventas_compartidas WHERE estatus = 1) AS vc ON vc.id_cliente = cl.id_cliente
                      INNER JOIN  usuarios ae ON ae.id_usuario = cl.id_asesor
                      LEFT JOIN  usuarios co ON co.id_usuario = ae.id_lider
                      LEFT JOIN  usuarios ge ON ge.id_usuario = cl.id_gerente
                      LEFT JOIN  usuarios su ON su.id_usuario = ge.id_lider
                      LEFT JOIN  usuarios di ON di.id_usuario = su.id_lider
                      WHERE l.idStatusContratacion BETWEEN 9 AND 15 AND cl.status = 1 AND l.status = 1 AND l.idLote = $idlote)
                      UNION
                      (SELECT DISTINCT(l.idLote), l.idStatusContratacion, l.registro_comision, cl.id_cliente, CONCAT(cl.nombre,' ',cl.apellido_paterno,' ',
                      cl.apellido_materno) nombre_cliente, l.nombreLote, l.idStatusContratacion, 
                      res.nombreResidencial, cond.nombre as nombreCondominio, l.tipo_venta, l.referencia, vc.id_cliente AS compartida, l.totalNeto, 
                      l.totalNeto2, l.plan_enganche, plane.nombre as enganche_tipo, cl.lugar_prospeccion,
                            ae.id_usuario as id_asesor, CONCAT(ae.nombre, ' ', ae.apellido_paterno, ' ',  ae.apellido_paterno) as asesor,
                            co.id_usuario as id_coordinador, CONCAT(co.nombre, ' ', co.apellido_paterno, ' ',  co.apellido_paterno) as coordinador,
                            ge.id_usuario as id_gerente, CONCAT(ge.nombre, ' ', ge.apellido_paterno, ' ',  ge.apellido_paterno) as gerente,
                            su.id_usuario as id_subdirector, CONCAT(su.nombre, ' ', su.apellido_paterno, ' ',  su.apellido_paterno) as subdirector,
                            di.id_usuario as id_director, CONCAT(di.nombre, ' ', di.apellido_paterno, ' ',  di.apellido_paterno) as director, 
                            pc.fecha_modificacion, convert(nvarchar, pc.fecha_modificacion, 6) date_final
                            FROM  lotes l
                            INNER JOIN  clientes cl ON cl.id_cliente = l.idCliente
                            INNER JOIN  condominios cond ON l.idCondominio=cond.idCondominio
                            INNER JOIN  residenciales res ON cond.idResidencial = res.idResidencial
                            LEFT JOIN  pago_comision pc ON pc.id_lote = l.idLote AND pc.bandera in (0)
                            LEFT JOIN  opcs_x_cats plane ON plane.id_opcion= l.plan_enganche AND plane.id_catalogo = 39
                            LEFT JOIN (SELECT id_cliente FROM ventas_compartidas WHERE estatus = 1) AS vc ON vc.id_cliente = cl.id_cliente
                            INNER JOIN  usuarios ae ON ae.id_usuario = cl.id_asesor
                            LEFT JOIN  usuarios co ON co.id_usuario = ae.id_lider
                            LEFT JOIN  usuarios ge ON ge.id_usuario = cl.id_gerente
                            LEFT JOIN  usuarios su ON su.id_usuario = ge.id_lider
                            LEFT JOIN  usuarios di ON di.id_usuario = su.id_lider
                            WHERE l.idStatusContratacion BETWEEN 9 AND 15 AND cl.status = 1 AND l.status = 1 AND l.idLote = $idlote
                            AND l.registro_comision in (0,8))");
        return $query->result();

    }

    public function getAllCommissions()
    {

        $this->db->query("SET LANGUAGE Espa??ol;");
        $query = $this->db->query("(SELECT DISTINCT(l.idLote), l.idStatusContratacion, l.registro_comision, cl.id_cliente, CONCAT(cl.nombre,' ',cl.apellido_paterno,' ',cl.apellido_materno) nombre_cliente, l.nombreLote, l.idStatusContratacion, res.nombreResidencial, cond.nombre as nombreCondominio, l.tipo_venta, l.referencia, vc.id_cliente AS compartida, l.totalNeto, l.totalNeto2, l.plan_enganche, plane.nombre as enganche_tipo, cl.lugar_prospeccion, pc.fecha_modificacion, convert(nvarchar, pc.fecha_modificacion, 6) date_final, pc.bandera FROM  lotes l
            INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
            INNER JOIN condominios cond ON l.idCondominio=cond.idCondominio
            INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
            LEFT JOIN pago_comision pc ON pc.id_lote = l.idLote
            LEFT JOIN opcs_x_cats plane ON plane.id_opcion= l.plan_enganche AND plane.id_catalogo = 39
            LEFT JOIN (SELECT id_cliente FROM ventas_compartidas WHERE estatus = 1) AS vc ON vc.id_cliente = cl.id_cliente
            WHERE l.idStatusContratacion BETWEEN 9 AND 15 
            AND cl.status = 1 
            AND l.status = 1 
            AND pc.bandera in (0,55,7,1,8)
            AND tipo_venta IS NOT NULL 
            AND tipo_venta IN (1, 2))

            UNION

            (SELECT DISTINCT(l.idLote), l.idStatusContratacion, l.registro_comision, cl.id_cliente, CONCAT(cl.nombre,' ',cl.apellido_paterno,' ', cl.apellido_materno) nombre_cliente, l.nombreLote, l.idStatusContratacion, res.nombreResidencial, cond.nombre as nombreCondominio, l.tipo_venta, l.referencia, vc.id_cliente AS compartida, l.totalNeto,  l.totalNeto2, l.plan_enganche, plane.nombre as enganche_tipo, cl.lugar_prospeccion, pc.fecha_modificacion, convert(nvarchar, pc.fecha_modificacion, 6) date_final, CASE WHEN l.registro_comision = '0' THEN 9 WHEN l.registro_comision = '8' THEN 8 ELSE 0 END bandera
            FROM  lotes l
            INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
            INNER JOIN condominios cond ON l.idCondominio=cond.idCondominio
            INNER JOIN residenciales res ON cond.idResidencial = res.idResidencial
            LEFT JOIN pago_comision pc ON pc.id_lote = l.idLote
            LEFT JOIN opcs_x_cats plane ON plane.id_opcion= l.plan_enganche AND plane.id_catalogo = 39
            LEFT JOIN (SELECT id_cliente FROM ventas_compartidas WHERE estatus = 1) AS vc ON vc.id_cliente = cl.id_cliente
            WHERE l.idStatusContratacion BETWEEN 9 AND 15 
            AND cl.status = 1 
            AND l.status = 1
            AND l.registro_comision in (0,8)
            AND tipo_venta IS NOT NULL AND tipo_venta IN (1, 2))
            ORDER BY l.idLote");

        return $query->result();
    }






    function update_acepta_resguardo($idsol) {
        $query = $this->db->query("UPDATE pago_comision_ind SET estatus = 3, fecha_pago_intmex = GETDATE() WHERE id_pago_i IN (".$idsol.")");
        return true;
    }


    function getUsuariosRol($rol){
      if($rol == 38){
        return $this->db->query("SELECT 1988 as id_usuario, 'MKTD Plaza Fernanda (Le??n, San Luis Potos??)' as name_user  union  SELECT 1981 as id_usuario, 'MKTD Plaza Maricela (Quer??taro, CDMX, Peninsula)' as name_user");
      }else{
        return $this->db->query("SELECT id_usuario,CONCAT(nombre, ' ', apellido_paterno, ' ',  apellido_materno) as name_user FROM usuarios WHERE estatus in (0,1) /*and forma_pago != 2*/ AND id_rol=$rol");
      }
    }
    function getUsuariosRol2($rol){
        return $this->db->query("SELECT SUM(d.monto) as monto, u.id_usuario,CONCAT(u.nombre, ' ', u.apellido_paterno, ' ',  u.apellido_materno) as name_user 
        FROM usuarios u inner join descuentos_universidad d on d.id_usuario=u.id_usuario
        WHERE  u.id_rol=$rol AND d.estatus=1
        GROUP BY u.id_usuario, u.nombre, u.apellido_paterno, u.apellido_materno
        order by u.nombre");
    }

  function getUsuariosRolBonos($rol){
    if($rol == 20){
        $cadena = ' in (18, 19, 20, 25, 26, 27, 28, 30, 36) ';
    }
    else{
        $cadena = ' in ('.$rol.') ';
    }

        return $this->db->query("SELECT id_usuario,CONCAT(nombre, ' ', apellido_paterno, ' ',  apellido_materno) as name_user FROM usuarios WHERE id_usuario NOT IN (SELECT id_usuario FROM bonos) AND id_rol  $cadena");
    }



  function getUsuariosRolDU($rol){
 
        return $this->db->query("SELECT id_usuario,CONCAT(nombre, ' ', apellido_paterno, ' ',  apellido_materno) as name_user FROM usuarios WHERE id_usuario NOT IN (SELECT id_usuario FROM descuentos_universidad where  estatus in (1,2) ) AND id_rol = $rol ");
    }




function getDatosComisionesHistorialRigel($proyecto,$condominio){
    $USER_SESSION = $this->session->userdata('id_usuario');


     if($condominio == 0){
                return $this->db->query("SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote, re.nombreResidencial as proyecto, co.nombre as condominio,lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, pci1.estatus, pci1.fecha_abono fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) user_names ,pci1.id_usuario, oprol.nombre as puesto, cl.personalidad_juridica, u.forma_pago, f.id_comision as factura, pac.porcentaje_abono, oxcest.nombre as estatus_actual, oxcest.id_opcion id_estatus_actual, pci1.descuento_aplicado, cl.lugar_prospeccion, lo.referencia, com.estatus
                 FROM pago_comision_ind pci1 
                 LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE estatus in (11) 
                 GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
                 INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                 INNER JOIN lotes lo ON lo.idLote = com.id_lote
                 INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                 INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                 INNER JOIN clientes cl ON cl.idLote = lo.idLote
                 INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
                 INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado
                 INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                 INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus 
                 LEFT JOIN facturas f ON f.id_comision = com.id_comision
                 WHERE pci1.estatus IN (1, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12) AND re.idResidencial = $proyecto AND com.id_usuario = $USER_SESSION
                 AND com.estatus in (1,8) AND oprol.id_catalogo = 1 AND oxcest.id_catalogo = 23 AND lo.status = 1 AND cl.status = 1
                 GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial, co.nombre, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, cl.personalidad_juridica, u.forma_pago, f.id_comision, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion,  pci1.descuento_aplicado, cl.lugar_prospeccion, lo.referencia, com.estatus ORDER BY lo.nombreLote");
            }else{

                return $this->db->query("SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote, re.nombreResidencial as proyecto, co.nombre as condominio,lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, pci1.estatus, pci1.fecha_abono fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) user_names ,pci1.id_usuario, oprol.nombre as puesto, cl.personalidad_juridica, u.forma_pago, f.id_comision as factura, pac.porcentaje_abono, oxcest.nombre as estatus_actual, oxcest.id_opcion id_estatus_actual, pci1.descuento_aplicado, cl.lugar_prospeccion, lo.referencia, com.estatus
                 FROM pago_comision_ind pci1 
                 LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE estatus in (11) 
                 GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
                 INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                 INNER JOIN lotes lo ON lo.idLote = com.id_lote
                 INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                 INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                 INNER JOIN clientes cl ON cl.idLote = lo.idLote
                 INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
                 INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado
                 INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                 INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus 
                 LEFT JOIN facturas f ON f.id_comision = com.id_comision
                 WHERE pci1.estatus IN (1, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12) AND co.idCondominio = $condominio AND com.id_usuario = $USER_SESSION
                 AND com.estatus in (1,8) AND oprol.id_catalogo = 1 AND oxcest.id_catalogo = 23 AND lo.status = 1 AND cl.status = 1
                 GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial, co.nombre, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, cl.personalidad_juridica, u.forma_pago, f.id_comision, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion,  pci1.descuento_aplicado, cl.lugar_prospeccion, lo.referencia, com.estatus ORDER BY lo.nombreLote");
            }
        }






    function getDatosComisionesRigel($proyecto,$condominio,$estado){

        $user_data = $this->session->userdata('id_usuario');
        switch($this->session->userdata('id_usuario')){
            case 2:
            case 3:
            case 1980:
            case 1981:
            case 1982:
                $sede = 2;
                break;
            case 4:
                $sede = 5;
                break;
            case 5:                           
                $sede = 3;
                break;
            case 607:
                $sede = 1;
                break;
           default:
                $sede = $this->session->userdata('id_sede');
                break;
            }

            if($condominio == 0){
                $add_fil = ' AND com.id_usuario = '.$user_data.' AND re.idResidencial = '.$proyecto.'';
            }else{
                $add_fil = ' AND com.id_usuario = '.$user_data.' AND co.idCondominio = '.$condominio.'';
            }


            return $this->db->query("(SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, pci1.fecha_abono fecha_creacion, pci1.id_usuario, oxcpj.nombre as pj_name, u.forma_pago, pac.porcentaje_abono, 0 as factura, 1 expediente, oxcC.nombre as estatus_actual, (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, pac.bonificacion,  0 lugar_prospeccion
                    FROM pago_comision_ind pci1 
                    INNER JOIN comisiones com ON pci1.id_comision = com.id_comision 
                    INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1
                    INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                    INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                    INNER JOIN usuarios u ON u.id_usuario = com.id_usuario  
                    INNER JOIN opcs_x_cats oxcpj ON oxcpj.id_opcion = u.forma_pago AND oxcpj.id_catalogo = 16 
                    INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                    INNER JOIN opcs_x_cats oxcC ON pci1.estatus = oxcC.id_opcion and oxcC.id_catalogo = 23
                    LEFT JOIN sedes sed ON sed.id_sede = $sede and sed.estatus = 1
                    WHERE pci1.estatus IN ($estado) AND ( (lo.idStatusContratacion < 9 AND com.estatus IN (1,8)) OR (lo.idStatusContratacion > 8 AND com.estatus IN (8))) $add_fil
                    GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, 
                    com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata,
                    pci1.estatus, pci1.fecha_abono, pci1.id_usuario,  oxcpj.nombre, 
                    u.forma_pago,pci1.id_pago_i, pac.porcentaje_abono, oxcC.nombre, sed.impuesto, pac.bonificacion)
                    UNION
                    (SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, pci1.fecha_abono fecha_creacion, pci1.id_usuario, oxcpj.nombre as pj_name, u.forma_pago, pac.porcentaje_abono, 0 as factura, 1 expediente, oxcC.nombre as estatus_actual, (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, pac.bonificacion, cl.lugar_prospeccion
                    FROM pago_comision_ind pci1 
                    INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                    INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1
                    INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                    INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                    INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 1
                    INNER JOIN usuarios u ON u.id_usuario = com.id_usuario  
                    INNER JOIN opcs_x_cats oxcpj ON oxcpj.id_opcion = u.forma_pago AND oxcpj.id_catalogo = 16 
                    INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                    INNER JOIN opcs_x_cats oxcC ON pci1.estatus = oxcC.id_opcion and oxcC.id_catalogo = 23
                    INNER JOIN sedes sed ON sed.id_sede = $sede and sed.estatus = 1
                    WHERE pci1.estatus IN ($estado) AND com.estatus in (1) AND lo.idStatusContratacion > 8 $add_fil
                    GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, 
                    com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata,
                    pci1.estatus, pci1.fecha_abono, pci1.id_usuario,  oxcpj.nombre, 
                    u.forma_pago,pci1.id_pago_i, pac.porcentaje_abono, oxcC.nombre, sed.impuesto, pac.bonificacion, cl.lugar_prospeccion)");
         
 
    }



    public function getDataDispersionPago($val = '') {
        //s echo $val;
         $filtro = '';
         if(empty($val)){
            $filtro = 'AND l.registro_comision in (1) AND pc.bandera in (0)';
         }else{
            $filtro = 'AND l.registro_comision in (1,7)';

         }

      //   $BACK = ' AND l.idLote not in  (49598, 49704, 50128, 50279, 53218, 53687, 53721, 53726, 57133, 57389, 57552, 57662, 50614, 54283, 58984, 51984, 56198, 56260, 59870, 59957, 59984, 60059, 60132, 60155, 60165, 60166, 60167, 60176, 60178, 60188, 60246, 32949, 32950, 47806, 55845, 57734, 57768, 57770, 57771, 57785, 57786, 57795, 57796, 57800, 57805, 57820, 57821, 57856, 57863, 57866, 57874, 57884, 57886, 57894, 57903, 57911, 57933, 57962, 57966, 57975, 57994, 58000, 58002, 58030, 58061, 58072, 58082, 58103, 53724, 53761, 53770, 53775, 53812, 57519, 57661, 57668, 57669, 57674, 60452, 50706, 54849, 54898, 59173, 49146, 49170, 52043, 55929, 56075, 56146, 56474, 59926, 59931, 59939, 60070, 60077, 60113, 60371, 4143, 48073, 55701, 55794, 57719, 57732, 57737, 57751, 57754, 57757, 57766, 57769, 57775, 57788, 57817, 57868, 57872, 57881, 57891, 57895, 57896, 57914, 57916, 57922, 57935, 57936, 57948, 57953, 57957, 57967, 57978, 57983, 57993, 58005, 58007, 58009, 58027, 33691, 53250, 53688, 53722, 53723, 53769, 53786, 57325, 57574, 57628, 57673, 60453, 42881, 47491, 50639, 50705, 54901, 55903, 56134, 56364, 56516, 56632, 56652, 59884, 59949, 59954, 60056, 60057, 60079, 60150, 60153, 60179, 35403, 55868, 57713, 57718, 57721, 57722, 57726, 57733, 57740, 57744, 57745, 57762, 57764, 57765, 57776, 57778, 57779, 57793, 57794, 57798, 57801, 57812, 57816, 57831, 57834, 57839, 57844, 57851, 57859, 57864, 57869, 57871, 57875, 57877, 57885, 57889, 57897, 57913, 57917, 57918, 57923, 57924, 57925, 57934, 57937, 57949, 57950, 57955, 57956, 57964, 57969, 57974, 57976, 58004, 58071, 58073, 58079, 58083, 58114, 58124, 58127, 58423, 28798, 39524, 49691, 50281, 53717, 57355, 40117, 50531, 54897, 59401, 59405, 59406, 59482, 33196, 49148, 49150, 52016, 55902, 56397, 59930, 60069, 60082, 60157, 60162, 60164, 60182, 60190, 60421, 1578, 55788, 55866, 57717, 57720, 57723, 57724, 57727, 57736, 57739, 57743, 57763, 57773, 57774, 57782, 57783, 57797, 57803, 57818, 57832, 57833, 57837, 57843, 57849, 57850, 57858, 57865, 57867, 57873, 57876, 57878, 57892, 57899, 57905, 57926, 57941, 57954, 57959, 57968, 57970, 57984, 57985, 57988, 57995, 58003, 58008, 58010, 58014, 58034, 58109, 58110, 58386, 58392, 58409, 58549)';


            $this->db->query("SET LANGUAGE Espa??ol;");
        $query = $this->db->query("(SELECT DISTINCT(l.idLote), l.idStatusContratacion, l.registro_comision, cl.id_cliente, 
 CONCAT(cl.nombre,' ',cl.apellido_paterno,' ',cl.apellido_materno) nombre_cliente, l.nombreLote, l.idStatusContratacion, 
                res.nombreResidencial, cond.nombre as nombreCondominio, l.tipo_venta, l.referencia, vc.id_cliente AS compartida, l.totalNeto, 
                l.totalNeto2, l.plan_enganche, plane.nombre as enganche_tipo, cl.lugar_prospeccion,
                      ae.id_usuario as id_asesor, CONCAT(ae.nombre, ' ', ae.apellido_paterno, ' ',  ae.apellido_paterno) as asesor,
                      co.id_usuario as id_coordinador, CONCAT(co.nombre, ' ', co.apellido_paterno, ' ',  co.apellido_paterno) as coordinador,
                      ge.id_usuario as id_gerente, CONCAT(ge.nombre, ' ', ge.apellido_paterno, ' ',  ge.apellido_paterno) as gerente,
                      su.id_usuario as id_subdirector, CONCAT(su.nombre, ' ', su.apellido_paterno, ' ',  su.apellido_paterno) as subdirector,
                      di.id_usuario as id_director, CONCAT(di.nombre, ' ', di.apellido_paterno, ' ',  di.apellido_paterno) as director, pc.fecha_modificacion,
                      convert(nvarchar, pc.fecha_modificacion, 6) date_final
                      FROM  lotes l

                      INNER JOIN  clientes cl ON cl.id_cliente = l.idCliente
                      INNER JOIN  condominios cond ON l.idCondominio=cond.idCondominio
                      INNER JOIN  residenciales res ON cond.idResidencial = res.idResidencial
                      LEFT JOIN  pago_comision pc ON pc.id_lote = l.idLote AND pc.bandera in (0)
                      LEFT JOIN  opcs_x_cats plane ON plane.id_opcion= l.plan_enganche AND plane.id_catalogo = 39
                      LEFT JOIN (SELECT id_cliente FROM ventas_compartidas WHERE estatus = 1) AS vc ON vc.id_cliente = cl.id_cliente
                      INNER JOIN  usuarios ae ON ae.id_usuario = cl.id_asesor
                      LEFT JOIN  usuarios co ON co.id_usuario = ae.id_lider
                      LEFT JOIN  usuarios ge ON ge.id_usuario = cl.id_gerente
                      LEFT JOIN  usuarios su ON su.id_usuario = ge.id_lider
                      LEFT JOIN  usuarios di ON di.id_usuario = su.id_lider
                      WHERE l.idStatusContratacion BETWEEN 9 AND 15 AND cl.status = 1 AND l.status = 1 
                      $filtro
                      AND tipo_venta IS NOT NULL AND tipo_venta IN (1, 2) 




                      )UNION
                      ( SELECT DISTINCT(l.idLote), l.idStatusContratacion, l.registro_comision, cl.id_cliente, CONCAT(cl.nombre,' ',cl.apellido_paterno,' ',
                      cl.apellido_materno) nombre_cliente, l.nombreLote, l.idStatusContratacion, 
                      res.nombreResidencial, cond.nombre as nombreCondominio, l.tipo_venta, l.referencia, vc.id_cliente AS compartida, l.totalNeto, 
                      l.totalNeto2, l.plan_enganche, plane.nombre as enganche_tipo, cl.lugar_prospeccion,
                            ae.id_usuario as id_asesor, CONCAT(ae.nombre, ' ', ae.apellido_paterno, ' ',  ae.apellido_paterno) as asesor,
                            co.id_usuario as id_coordinador, CONCAT(co.nombre, ' ', co.apellido_paterno, ' ',  co.apellido_paterno) as coordinador,
                            ge.id_usuario as id_gerente, CONCAT(ge.nombre, ' ', ge.apellido_paterno, ' ',  ge.apellido_paterno) as gerente,
                            su.id_usuario as id_subdirector, CONCAT(su.nombre, ' ', su.apellido_paterno, ' ',  su.apellido_paterno) as subdirector,
                            di.id_usuario as id_director, CONCAT(di.nombre, ' ', di.apellido_paterno, ' ',  di.apellido_paterno) as director, 
                            pc.fecha_modificacion, convert(nvarchar, pc.fecha_modificacion, 6) date_final
                            FROM  lotes l
                            INNER JOIN  clientes cl ON cl.id_cliente = l.idCliente
                            INNER JOIN  condominios cond ON l.idCondominio=cond.idCondominio
                            INNER JOIN  residenciales res ON cond.idResidencial = res.idResidencial
                            LEFT JOIN  pago_comision pc ON pc.id_lote = l.idLote AND pc.bandera in (0)
                            LEFT JOIN  opcs_x_cats plane ON plane.id_opcion= l.plan_enganche AND plane.id_catalogo = 39
                            LEFT JOIN (SELECT id_cliente FROM ventas_compartidas WHERE estatus = 1) AS vc ON vc.id_cliente = cl.id_cliente
                            INNER JOIN  usuarios ae ON ae.id_usuario = cl.id_asesor
                            LEFT JOIN  usuarios co ON co.id_usuario = ae.id_lider
                            LEFT JOIN  usuarios ge ON ge.id_usuario = cl.id_gerente
                            LEFT JOIN  usuarios su ON su.id_usuario = ge.id_lider
                            LEFT JOIN  usuarios di ON di.id_usuario = su.id_lider
                            WHERE l.idStatusContratacion BETWEEN 9 AND 15 AND cl.status = 1 AND l.status = 1 
                            AND l.registro_comision in (0,8,2)
                            AND tipo_venta IS NOT NULL AND tipo_venta IN (1, 2) 
                            AND (cl.fechaApartado >= '2020-03-01' OR l.idLote in(31907, 35863, 36603, 36603, 32575,45694,22741, 28434, 24576, 24577,35697,25218,31684,41032,34191,34141, 40635,36483,38927, 33931, 19523, 32101, 16406, 36617, 36618, 13334, 13615, 32793, 28405, 28406) )

                            )

                            

                            ORDER BY l.idLote");
    return $query->result();
    }

    public function getDataDispersionPago2() {
        $this->db->query("SET LANGUAGE Espa??ol;");
    $query = $this->db->query("(SELECT DISTINCT(l.idLote), l.idStatusContratacion, l.registro_comision, cl.id_cliente, 
CONCAT(cl.nombre,' ',cl.apellido_paterno,' ',cl.apellido_materno) nombre_cliente, l.nombreLote, l.idStatusContratacion, 
            res.nombreResidencial, cond.nombre as nombreCondominio, l.tipo_venta, l.referencia, vc.id_cliente AS compartida, l.totalNeto, 
            l.totalNeto2, l.plan_enganche, plane.nombre as enganche_tipo, cl.lugar_prospeccion,
                  ae.id_usuario as id_asesor, CONCAT(ae.nombre, ' ', ae.apellido_paterno, ' ',  ae.apellido_paterno) as asesor,
                  co.id_usuario as id_coordinador, CONCAT(co.nombre, ' ', co.apellido_paterno, ' ',  co.apellido_paterno) as coordinador,
                  ge.id_usuario as id_gerente, CONCAT(ge.nombre, ' ', ge.apellido_paterno, ' ',  ge.apellido_paterno) as gerente,
                  su.id_usuario as id_subdirector, CONCAT(su.nombre, ' ', su.apellido_paterno, ' ',  su.apellido_paterno) as subdirector,
                  di.id_usuario as id_director, CONCAT(di.nombre, ' ', di.apellido_paterno, ' ',  di.apellido_paterno) as director, pc.fecha_modificacion,
                  convert(nvarchar, pc.fecha_modificacion, 6) date_final
                  FROM  lotes l

                  INNER JOIN  clientes cl ON cl.id_cliente = l.idCliente
                  INNER JOIN  condominios cond ON l.idCondominio=cond.idCondominio
                  INNER JOIN  residenciales res ON cond.idResidencial = res.idResidencial
                  LEFT JOIN  pago_comision pc ON pc.id_lote = l.idLote AND pc.bandera in (0)
                  LEFT JOIN  opcs_x_cats plane ON plane.id_opcion= l.plan_enganche AND plane.id_catalogo = 39
                  LEFT JOIN (SELECT id_cliente FROM ventas_compartidas WHERE estatus = 1) AS vc ON vc.id_cliente = cl.id_cliente
                  INNER JOIN  usuarios ae ON ae.id_usuario = cl.id_asesor
                  LEFT JOIN  usuarios co ON co.id_usuario = ae.id_lider
                  LEFT JOIN  usuarios ge ON ge.id_usuario = cl.id_gerente
                  LEFT JOIN  usuarios su ON su.id_usuario = ge.id_lider
                  LEFT JOIN  usuarios di ON di.id_usuario = su.id_lider
                  WHERE l.idStatusContratacion BETWEEN 9 AND 15 AND cl.status = 1 AND l.status = 1 
                  AND l.registro_comision in (1,7) 
                  AND tipo_venta IS NOT NULL AND tipo_venta IN (1, 2) 
                  )UNION
                  ( SELECT DISTINCT(l.idLote), l.idStatusContratacion, l.registro_comision, cl.id_cliente, CONCAT(cl.nombre,' ',cl.apellido_paterno,' ',
                  cl.apellido_materno) nombre_cliente, l.nombreLote, l.idStatusContratacion, 
                  res.nombreResidencial, cond.nombre as nombreCondominio, l.tipo_venta, l.referencia, vc.id_cliente AS compartida, l.totalNeto, 
                  l.totalNeto2, l.plan_enganche, plane.nombre as enganche_tipo, cl.lugar_prospeccion,
                        ae.id_usuario as id_asesor, CONCAT(ae.nombre, ' ', ae.apellido_paterno, ' ',  ae.apellido_paterno) as asesor,
                        co.id_usuario as id_coordinador, CONCAT(co.nombre, ' ', co.apellido_paterno, ' ',  co.apellido_paterno) as coordinador,
                        ge.id_usuario as id_gerente, CONCAT(ge.nombre, ' ', ge.apellido_paterno, ' ',  ge.apellido_paterno) as gerente,
                        su.id_usuario as id_subdirector, CONCAT(su.nombre, ' ', su.apellido_paterno, ' ',  su.apellido_paterno) as subdirector,
                        di.id_usuario as id_director, CONCAT(di.nombre, ' ', di.apellido_paterno, ' ',  di.apellido_paterno) as director, 
                        pc.fecha_modificacion, convert(nvarchar, pc.fecha_modificacion, 6) date_final
                        FROM  lotes l
                        INNER JOIN  clientes cl ON cl.id_cliente = l.idCliente
                        INNER JOIN  condominios cond ON l.idCondominio=cond.idCondominio
                        INNER JOIN  residenciales res ON cond.idResidencial = res.idResidencial
                        LEFT JOIN  pago_comision pc ON pc.id_lote = l.idLote AND pc.bandera in (0)
                        LEFT JOIN  opcs_x_cats plane ON plane.id_opcion= l.plan_enganche AND plane.id_catalogo = 39
                        LEFT JOIN (SELECT id_cliente FROM ventas_compartidas WHERE estatus = 1) AS vc ON vc.id_cliente = cl.id_cliente
                        INNER JOIN  usuarios ae ON ae.id_usuario = cl.id_asesor
                        LEFT JOIN  usuarios co ON co.id_usuario = ae.id_lider
                        LEFT JOIN  usuarios ge ON ge.id_usuario = cl.id_gerente
                        LEFT JOIN  usuarios su ON su.id_usuario = ge.id_lider
                        LEFT JOIN  usuarios di ON di.id_usuario = su.id_lider
                        WHERE l.idStatusContratacion BETWEEN 9 AND 15 AND cl.status = 1 AND l.status = 1 
                        AND l.registro_comision in (0,8)
                        AND tipo_venta IS NOT NULL AND tipo_venta IN (1, 2) 
                        AND (cl.fechaApartado >= '2020-03-01' OR l.idLote in(31907, 35863, 36603, 36603, 32575,45694,22741, 28434, 24576, 24577,35697,25218,31684,41032,34191,34141, 40635,36483,38927, 33931, 19523, 32101, 16406, 36617, 36618, 13334, 13615, 32793, 28405, 28406) ))
                        ORDER BY l.idLote");
return $query->result();
}

    
    
    public function update_enganche_comision($idLote, $opcionSelect) {
        $id_user_Vl = $this->session->userdata('id_usuario');
        $this->db->query("INSERT INTO  historial_comisiones VALUES (0, ".$id_user_Vl.", GETDATE(), 2, 'SE AGREG?? PLAN DE ENGANCHE ".$opcionSelect.' - '.$idLote." ')");
        return $this->db->query("UPDATE  lotes SET plan_enganche = ".$opcionSelect." WHERE idLote IN (".$idLote.")");
    }

    public function getPlanesEnganche($idLote){
        $var_review = $this->db->query("SELECT c.lugar_prospeccion FROM lotes l INNER JOIN clientes c ON c.idLote = l.idLote WHERE c.status = 1 AND l.status = 1 AND l.idLote = $idLote");
        switch($var_review->row()->lugar_prospeccion){
            case '6':
                return $this->db->query("SELECT op1.id_opcion id_usuario, op1.nombre as name_user FROM  opcs_x_cats op1 WHERE op1.id_catalogo = 39 AND op1.id_opcion in (13, 14, 15, 16, 17, 18)");
                break;
            case '12':
                return $this->db->query("SELECT op1.id_opcion id_usuario, op1.nombre as name_user FROM  opcs_x_cats op1 WHERE op1.id_catalogo = 39 AND op1.id_opcion in (2, 4, 6, 9, 10, 12)");
                break;
            default:
            return $this->db->query("SELECT op1.id_opcion id_usuario, op1.nombre as name_user FROM  opcs_x_cats op1 WHERE op1.id_catalogo = 39 AND op1.id_opcion in (1, 3, 5, 7, 8, 11)");
            break;

        }
  
    }



    public function getValNeodata(){
        return $this->db->query("SELECT op1.id_opcion id_usuario, op1.nombre as name_user FROM  opcs_x_cats op1 WHERE op1.id_catalogo = 39 ");
    }


    public function getDatosConfirmarPago(){ 
        $query = $this->db->query("SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote, re.nombreResidencial as proyecto,  lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, pci1.estatus, pci1.fecha_abono fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) user_names ,pci1.id_usuario, oprol.nombre as puesto, cl.personalidad_juridica, u.forma_pago, f.id_comision as factura, pac.porcentaje_abono 
        FROM pago_comision_ind pci1 
        LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE estatus in (11) 
        GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
        INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
        INNER JOIN lotes lo ON lo.idLote = com.id_lote
        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
        INNER JOIN clientes cl ON cl.idLote = lo.idLote
        INNER JOIN porcentajes_comisiones pc ON pc.relacion_prospeccion = cl.lugar_prospeccion
        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
        INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado
        INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
        LEFT JOIN facturas f ON f.id_comision = com.id_comision
        WHERE pci1.estatus = 9 AND com.estatus in (1,8) AND oprol.id_catalogo = 1 
        GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial,  lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, cl.personalidad_juridica, u.forma_pago, f.id_comision, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre ORDER BY lo.nombreLote");
        return $query->result();
    }

    public function setConfirmarPago($idPagoInd) {
        $id_user_Vl = $this->session->userdata('id_usuario');
        $this->db->query("INSERT INTO  historial_comisiones VALUES ($idPagoInd, $id_user_Vl, GETDATE(), 1, 'CONTRALORIA CONFIRM?? EL PAGO')");
        return $this->db->query("UPDATE  pago_comision_ind SET estatus = 12 WHERE id_pago_i IN (".$idPagoInd.")");
    }
 

    function getDatosHistorialPago($proyecto,$condominio){

        if($condominio == 0){
            $filtro_00 = ' AND re.idResidencial = '.$proyecto.' ';
        }
            else{
                $filtro_00 = ' AND co.idCondominio = '.$condominio.' ';
            }
                        $filtro_estatus = ' pci1.estatus IN (1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 51, 52, 88,16,17, 41,42) ';


        switch ($this->session->userdata('id_rol')) {
            case 28:
            case 18:
            $filtro_02 = ' AND com.id_usuario = 4394 '.$filtro_00;
            
            break;

            case 1:
            case 2:
            case 3:
            case 7:
            case 9:
            $filtro_02 = ' AND com.id_usuario = '.$this->session->userdata('id_usuario').' '.$filtro_00;
            break;

            case 31:
            $filtro_02 = ' '.$filtro_00;
            $filtro_estatus = ' pci1.estatus IN (8,11,88) AND pci1.pago_neodata > 0 AND pci1.descuento_aplicado != 1 ';
            break;

            default:
            $filtro_02 = ' '.$filtro_00;
             break;
         }


 
         return $this->db->query("(SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote, re.nombreResidencial as proyecto, co.nombre as condominio,lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, pci1.estatus, pci1.fecha_abono fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) user_names ,pci1.id_usuario, oprol.nombre as puesto, u.forma_pago, f.id_comision as factura, pac.porcentaje_abono, oxcest.nombre as estatus_actual, oxcest.id_opcion id_estatus_actual, pci1.descuento_aplicado, 0 lugar_prospeccion, lo.referencia, com.estatus estado_comision, pac.bonificacion, u.estatus as activo
         FROM pago_comision_ind pci1 
         LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE estatus in (11) 
         GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
         INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
         INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
         INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
         INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
         INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
         INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
         INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
         INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23
         LEFT JOIN facturas f ON f.id_comision = com.id_comision
         
         WHERE (($filtro_estatus) OR (pci1.estatus = 0 AND pci1.descuento_aplicado = 1) ) 

         AND ( (lo.idStatusContratacion < 9 AND com.estatus IN (1,8)) OR (lo.idStatusContratacion > 8 AND com.estatus IN (8))) $filtro_02
         GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial, co.nombre, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, 
         pci2.abono_pagado, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, u.forma_pago, f.id_comision, pci1.id_pago_i, pac.porcentaje_abono, u.nombre,
         u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion,  pci1.descuento_aplicado, lo.referencia, com.estatus, pac.bonificacion, u.estatus)
     UNION 
 
     (SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote, re.nombreResidencial as proyecto, co.nombre as condominio,lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, pci1.estatus, pci1.fecha_abono fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) user_names ,pci1.id_usuario, oprol.nombre as puesto,  u.forma_pago, f.id_comision as factura, pac.porcentaje_abono, oxcest.nombre as estatus_actual, oxcest.id_opcion id_estatus_actual, pci1.descuento_aplicado, cl.lugar_prospeccion, lo.referencia, com.estatus estado_comision, pac.bonificacion, u.estatus as activo
         FROM pago_comision_ind pci1 
         LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE estatus in (11) 
         GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
         INNER JOIN comisiones com ON pci1.id_comision = com.id_comision AND com.estatus in (1)
         INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
         INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
         INNER JOIN residenciales re ON re.idResidencial = co.idResidencial 
         INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 1
         INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
         INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
         INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
         INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23
         LEFT JOIN facturas f ON f.id_comision = com.id_comision
         
         WHERE (($filtro_estatus) OR (pci1.estatus = 0 AND pci1.descuento_aplicado = 1) ) 

         AND lo.idStatusContratacion > 8 
         $filtro_02
         GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial, co.nombre, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, u.forma_pago, f.id_comision, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion,  pci1.descuento_aplicado, cl.lugar_prospeccion, lo.referencia, com.estatus, pac.bonificacion, u.estatus)ORDER BY lo.nombreLote");

         
    }



 
    function getDatosCobranzaRanking($a,$b){ 

        

        $cadena = '';
                if($a == 0){
        $cadena = '';
        }else{
            $cadena = "AND MONTH(cl.fechaApartado)=".$a;
        }


           if( $this->session->userdata('id_usuario') == 2042 ){
        $filtro = " AND (ase.id_sede like '%2%' OR ase.id_sede like '%3%'OR ase.id_sede like '%4%'OR ase.id_sede like '%6%') ";
      }
      else{
         $filtro = "  AND (ase.id_sede like '%1%' OR ase.id_sede like '%5%') ";
      }

           
                
           $this->db->query("SET LANGUAGE Espa??ol;");
            $query = $this->db->query("SELECT cmktd.idc_mktd,l.idLote, res.nombreResidencial, con.nombre AS condominio, l.nombreLote, l.totalNeto2, cl.fechaApartado, convert(nvarchar, cl.fechaApartado, 6) mes, CONCAT(cl.nombre,' ',cl.apellido_paterno,' ',cl.apellido_materno) AS cliente, se.nombre as plaza, CONCAT(ase.nombre,' ',ase.apellido_paterno,' ',ase.apellido_materno) AS asesor, CONCAT(ger.nombre,' ',ger.apellido_paterno,' ',ger.apellido_materno) AS gerente, stl.nombre as estatus,
                CASE WHEN pro.otro_lugar = '0' THEN 'Sin especificar' WHEN pro.otro_lugar IS NULL THEN 'Sin especificar' ELSE pro.otro_lugar END as evidencia, cl.status, cl.id_cliente,l.idStatusContratacion,l.idLote,rm.precio, sd1.nombre as sd1,sd2.nombre as sd2, com.comision_total, pci2.abono_pagado, cmktd.idc_mktd, pc.bandera, pci3.abono_dispersado, convert(nvarchar, pc.fecha_modificacion, 6) date_final
                FROM lotes l
                INNER JOIN clientes cl ON cl.id_cliente = l.idCliente AND cl.status = 1 AND lugar_prospeccion = 6
                INNER JOIN condominios con ON con.idCondominio = l.idCondominio
                INNER JOIN residenciales res ON res.idResidencial = con.idResidencial
                INNER JOIN statuslote stl ON stl.idStatusLote = l.idStatusLote
                INNER JOIN usuarios ase ON ase.id_usuario = cl.id_asesor
                INNER JOIN sedes se ON se.id_sede = ase.id_sede $cadena
                LEFT JOIN comisiones com ON com.id_lote = l.idLote AND com.estatus = 1 AND rol_generado = 38
                LEFT JOIN pago_comision pc ON pc.id_lote = l.idLote
                
                LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE estatus in (11) GROUP BY id_comision) pci2 ON com.id_comision = pci2.id_comision
                LEFT JOIN (SELECT SUM(abono_neodata) abono_dispersado, id_comision FROM pago_comision_ind GROUP BY id_comision) pci3 ON com.id_comision = pci3.id_comision

                LEFT JOIN usuarios ger ON ger.id_usuario = cl.id_gerente
                LEFT JOIN prospectos pro ON pro.id_prospecto = cl.id_prospecto
                LEFT JOIN reportes_marketing rm on rm.id_lote=l.idLote
                LEFT join compartidas_mktd cmktd on l.idLote=cmktd.id_lote
                LEFT join sedes sd1 on sd1.id_sede=cmktd.sede1
                LEFT join sedes sd2 on sd2.id_sede=cmktd.sede2
                WHERE l.status = 1  AND year(cl.fechaApartado) = $b $filtro GROUP BY cmktd.idc_mktd,l.idLote, res.nombreResidencial, con.nombre , l.nombreLote, l.totalNeto2, cl.fechaApartado,
                cl.fechaApartado, cl.nombre, cl.apellido_paterno, cl.apellido_materno , se.nombre , ase.nombre, ase.apellido_paterno,
                ase.apellido_materno , ger.nombre, ger.apellido_paterno, ger.apellido_materno , stl.nombre ,
                 pro.otro_lugar , cl.status, cl.id_cliente,l.idStatusContratacion,l.idLote,rm.precio, sd1.nombre ,sd2.nombre  , com.comision_total, 
                 pci2.abono_pagado, cmktd.idc_mktd, pc.bandera, pci3.abono_dispersado, pc.fecha_modificacion");

            return $query->result();
                
               
            }
        




   
    
    function getDatosCobranzaReporte($a,$b){ 

        
        $filtroPau = '';
        $filtroPau2 = '';
        $cadena = '';
                if($a == 0){
        $cadena = '';
        }else{
            $cadena = "AND MONTH(cl.fechaApartado)=".$a;
        }


           if( $this->session->userdata('id_usuario') == 2042 ){
        $filtro = " AND (ase.id_sede like '%2%' OR ase.id_sede like '%3%'OR ase.id_sede like '%4%'OR ase.id_sede like '%6%') ";
      }
      else{
         $filtro = "  AND (ase.id_sede like '%1%' OR ase.id_sede like '%5%') ";
         $filtroPau = 'CAST(ase.id_sede AS VARCHAR(MAX)) AS id_sede,';
         $filtroPau2 = 'CAST(ase.id_sede AS VARCHAR(MAX)),';
      }

           
                
           $this->db->query("SET LANGUAGE Espa??ol;");
            $query = $this->db->query("SELECT $filtroPau cmktd.idc_mktd,l.idLote, res.nombreResidencial, con.nombre AS condominio, l.nombreLote, l.totalNeto2, cl.fechaApartado, convert(nvarchar, cl.fechaApartado, 6) mes, CONCAT(cl.nombre,' ',cl.apellido_paterno,' ',cl.apellido_materno) AS cliente, se.nombre as plaza, CONCAT(ase.nombre,' ',ase.apellido_paterno,' ',ase.apellido_materno) AS asesor, CONCAT(ger.nombre,' ',ger.apellido_paterno,' ',ger.apellido_materno) AS gerente, stl.nombre as estatus, l.referencia, 
                CASE WHEN pro.otro_lugar = '0' THEN 'Sin especificar' WHEN pro.otro_lugar IS NULL THEN 'Sin especificar' ELSE pro.otro_lugar END as evidencia, cl.status, cl.id_cliente,l.idStatusContratacion,l.idLote,rm.precio, sd1.nombre as sd1,sd2.nombre as sd2, com.comision_total, pci2.abono_pagado, cmktd.idc_mktd, pc.bandera, pci3.abono_dispersado, convert(nvarchar, pc.fecha_modificacion, 6) date_final
                FROM lotes l
                INNER JOIN clientes cl ON cl.id_cliente = l.idCliente AND cl.status = 1 AND lugar_prospeccion = 6
                INNER JOIN condominios con ON con.idCondominio = l.idCondominio
                INNER JOIN residenciales res ON res.idResidencial = con.idResidencial
                INNER JOIN statuslote stl ON stl.idStatusLote = l.idStatusLote
                INNER JOIN usuarios ase ON ase.id_usuario = cl.id_asesor
                INNER JOIN sedes se ON se.id_sede = ase.id_sede $cadena
                LEFT JOIN comisiones com ON com.id_lote = l.idLote AND com.estatus = 1 AND rol_generado = 38
                LEFT JOIN pago_comision pc ON pc.id_lote = l.idLote
                
                LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE estatus in (11) GROUP BY id_comision) pci2 ON com.id_comision = pci2.id_comision
                LEFT JOIN (SELECT SUM(abono_neodata) abono_dispersado, id_comision FROM pago_comision_ind GROUP BY id_comision) pci3 ON com.id_comision = pci3.id_comision

                LEFT JOIN usuarios ger ON ger.id_usuario = cl.id_gerente
                LEFT JOIN prospectos pro ON pro.id_prospecto = cl.id_prospecto
                LEFT JOIN reportes_marketing rm on rm.id_lote=l.idLote
                LEFT join compartidas_mktd cmktd on l.idLote=cmktd.id_lote
                LEFT join sedes sd1 on sd1.id_sede=cmktd.sede1
                LEFT join sedes sd2 on sd2.id_sede=cmktd.sede2
                WHERE l.status = 1  AND year(cl.fechaApartado) = $b $filtro GROUP BY $filtroPau2 cmktd.idc_mktd,l.idLote, res.nombreResidencial, con.nombre , l.nombreLote, l.totalNeto2, cl.fechaApartado,
                cl.fechaApartado, cl.nombre, cl.apellido_paterno, cl.apellido_materno , se.nombre , ase.nombre, ase.apellido_paterno,
                ase.apellido_materno , ger.nombre, ger.apellido_paterno, ger.apellido_materno , stl.nombre ,
                 pro.otro_lugar , cl.status, cl.id_cliente,l.idStatusContratacion,l.idLote,rm.precio, sd1.nombre ,sd2.nombre  , com.comision_total, 
                 pci2.abono_pagado, cmktd.idc_mktd, pc.bandera, pci3.abono_dispersado, pc.fecha_modificacion, l.referencia");

            return $query->result();
                
               
            }
   

        function getDatosCobranzaDimamic($a,$b,$c,$d){ 
 
         if($a != 0 && $b != 0 && $c == 0 && $d == 0){
             $filtro = " AND MONTH(cl.fechaApartado) = $a AND year(cl.fechaApartado) = $b ";
         }else if($a != 0 && $b != 0 && $c != 0 && $d == 0){
             $filtro = " AND MONTH(cl.fechaApartado) = $a AND year(cl.fechaApartado) = $b AND ase.id_sede like '%".$c."'";
         }else if($a != 0 && $b != 0 && $c != 0 && $d != 0){
             $filtro = " AND MONTH(cl.fechaApartado) = $a AND year(cl.fechaApartado) = $b AND ase.id_sede like '%".$c."' AND cl.id_gerente = $d ";
         }else {
             $filtro = " ";
         }
           
             return $this->db->query("(SELECT COUNT(l.idLote) lotes_vendidos, CASE WHEN SUM(l.totalNeto2) = '0' THEN 0 WHEN SUM(l.totalNeto2) IS NULL THEN 0 ELSE  SUM(l.totalNeto2) END as monto_vendido, ase.id_usuario, cl.status,
                CONCAT(ase.nombre,' ',ase.apellido_paterno,' ',ase.apellido_materno) as asesor,
                CONCAT(ger.nombre,' ',ger.apellido_paterno,' ',ger.apellido_materno) as gerente,se.nombre
                FROM lotes l
                INNER JOIN clientes cl ON cl.id_cliente = l.idCliente AND cl.status = 1 AND lugar_prospeccion = 6
                INNER JOIN condominios con ON con.idCondominio = l.idCondominio
                INNER JOIN residenciales res ON res.idResidencial = con.idResidencial
                INNER JOIN statuslote stl ON stl.idStatusLote = l.idStatusLote
                INNER JOIN usuarios ase ON ase.id_usuario = cl.id_asesor
                INNER JOIN sedes se ON se.id_sede = ase.id_sede
                LEFT JOIN usuarios ger ON ger.id_usuario = cl.id_gerente
                LEFT JOIN prospectos pro ON pro.id_prospecto = cl.id_prospecto
                WHERE l.status = 1 $filtro
                GROUP BY ase.id_usuario, ase.nombre, ase.apellido_paterno, ase.apellido_materno, ger.nombre, 
                ger.apellido_paterno, ger.apellido_materno,se.nombre, cl.status
                HAVING COUNT(l.idLote) > 0)

                UNION

                (SELECT COUNT(l.idLote) lotes_vendidos, CASE WHEN SUM(l.totalNeto2) = '0' THEN 0 WHEN SUM(l.totalNeto2) IS NULL THEN 
                0 ELSE  SUM(l.totalNeto2) END as monto_vendido, ase.id_usuario, cl.status,
                CONCAT(ase.nombre,' ',ase.apellido_paterno,' ',ase.apellido_materno) as asesor,
                CONCAT(ger.nombre,' ',ger.apellido_paterno,' ',ger.apellido_materno) as gerente,se.nombre
                FROM lotes l
                INNER JOIN clientes cl ON cl.idLote = l.idLote AND cl.status = 0 AND lugar_prospeccion = 6
                INNER JOIN condominios con ON con.idCondominio = l.idCondominio
                INNER JOIN residenciales res ON res.idResidencial = con.idResidencial
                INNER JOIN statuslote stl ON stl.idStatusLote = l.idStatusLote
                INNER JOIN usuarios ase ON ase.id_usuario = cl.id_asesor
                INNER JOIN sedes se ON se.id_sede = ase.id_sede
                LEFT JOIN usuarios ger ON ger.id_usuario = cl.id_gerente
                LEFT JOIN prospectos pro ON pro.id_prospecto = cl.id_prospecto
                WHERE l.status = 1 $filtro
                GROUP BY ase.id_usuario, ase.nombre, ase.apellido_paterno, ase.apellido_materno, ger.nombre, 
                ger.apellido_paterno, ger.apellido_materno,se.nombre, cl.status
                HAVING COUNT(l.idLote) > 0)");
         }




   function getDatosCobranzaIndicador($a,$b){



        $cadena = '';
        if($a == 0){
            $cadena = ' AND year(cl.fechaApartado) = '.$b.' ';
        }else{
            $cadena = ' AND MONTH(cl.fechaApartado) =  '.$a.' AND year(cl.fechaApartado) = '.$b.' ';
        }


    return $this->db->query("(SELECT COUNT(l.idLote) lotes_vendidos, CASE WHEN SUM(l.totalNeto2) = '0' THEN 0 WHEN SUM(l.totalNeto2) IS NULL THEN 0 ELSE SUM(l.totalNeto2) END as monto_vendido, cl.status, se.nombre
        FROM lotes l
        INNER JOIN clientes cl ON cl.id_cliente = l.idCliente AND cl.status = 1 AND cl.lugar_prospeccion = 6
        INNER JOIN sedes se ON se.id_sede = l.ubicacion
        WHERE l.status = 1 AND MONTH(cl.fechaApartado) = $a AND year(cl.fechaApartado) = $b
        GROUP BY se.nombre, cl.status
        HAVING COUNT(l.idLote) > 0)

        UNION

        (SELECT COUNT(l.idLote) lotes_vendidos, CASE WHEN SUM(l.totalNeto2) = '0' THEN 0 WHEN SUM(l.totalNeto2) IS NULL THEN 0 ELSE SUM(l.totalNeto2) END as monto_vendido, cl.status, se.nombre
        FROM lotes l
        INNER JOIN clientes cl ON cl.idLote = l.idLote AND cl.status = 0 AND cl.lugar_prospeccion = 6
        INNER JOIN sedes se ON se.id_sede = l.ubicacion
        WHERE l.status = 1 $cadena
        GROUP BY se.nombre, cl.status
        HAVING COUNT(l.idLote) > 0)");
}





    



    function getDatosComisionesNuevasNivel2(){
        return $this->db->query("SELECT pcm.id_pago_mk, pcm.fecha_abono, pcm.estatus, pcm.abono_marketing, pcm.pago_mktd,
CONCAT(us.nombre,' ',us.apellido_paterno,' ',us.apellido_materno) AS colaborador, oxc.nombre as puesto, 3 as forma_pago, 1 as expediente
FROM pago_comision_mktd pcm
INNER JOIN usuarios us ON us.id_usuario = pcm.id_usuario
INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = us.id_rol
WHERE oxc.id_catalogo = 1 AND pcm.estatus = 1 AND pcm.id_usuario =  ".$this->session->userdata('id_usuario')."");
    }


    function getDatosComisionesRecibidasNivel2(){
        return $this->db->query("SELECT pcm.id_pago_mk, pcm.fecha_abono, pcm.estatus, pcm.abono_marketing, pcm.pago_mktd,
CONCAT(us.nombre,' ',us.apellido_paterno,' ',us.apellido_materno) AS colaborador, oxc.nombre as puesto, 3 as forma_pago, 1 as expediente
FROM pago_comision_mktd pcm
INNER JOIN usuarios us ON us.id_usuario = pcm.id_usuario
INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = us.id_rol
WHERE oxc.id_catalogo = 1 AND pcm.estatus = 4 AND pcm.id_usuario =  ".$this->session->userdata('id_usuario')."");
    }
        


    function getDatosComisionesHistorialNivel2(){
        $this->db->query("SELECT pcm.id_pago_mk, pcm.fecha_abono, pcm.estatus, pcm.abono_marketing, pcm.pago_mktd,
CONCAT(us.nombre,' ',us.apellido_paterno,' ',us.apellido_materno) AS colaborador,
oxc.nombre as puesto
FROM pago_comision_mktd pcm
INNER JOIN usuarios us ON us.id_usuario = pcm.id_usuario
INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = us.id_rol
WHERE oxc.id_catalogo = 1 AND pcm.estatus = 11 AND pcm.id_usuario =  ".$this->session->userdata('id_usuario')."");
    }





    
    function getDatosComisionesAsesor($estado){
        $user_data = $this->session->userdata('id_usuario');
        $sede = $this->session->userdata('id_sede');
        
        return $this->db->query("(SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, pci1.fecha_abono fecha_creacion, pci1.id_usuario, oxcpj.nombre as pj_name, u.forma_pago, pac.porcentaje_abono, 0 as factura, 1 expediente, oxcC.nombre as estatus_actual, (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, pac.bonificacion,  0 lugar_prospeccion
                    FROM pago_comision_ind pci1 
                    INNER JOIN comisiones com ON pci1.id_comision = com.id_comision 
                    INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1
                    INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                    INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                    INNER JOIN usuarios u ON u.id_usuario = com.id_usuario  
                    INNER JOIN opcs_x_cats oxcpj ON oxcpj.id_opcion = u.forma_pago AND oxcpj.id_catalogo = 16 
                    INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                    INNER JOIN opcs_x_cats oxcC ON pci1.estatus = oxcC.id_opcion and oxcC.id_catalogo = 23
                    LEFT JOIN sedes sed ON sed.id_sede = $sede and sed.estatus = 1
                    WHERE pci1.estatus IN ($estado) AND ( (lo.idStatusContratacion < 9 AND com.estatus IN (1,8)) OR (lo.idStatusContratacion > 8 AND com.estatus IN (8))) AND com.id_usuario = $user_data
                    GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, 
                    com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata,
                    pci1.estatus, pci1.fecha_abono, pci1.id_usuario,  oxcpj.nombre, 
                    u.forma_pago,pci1.id_pago_i, pac.porcentaje_abono, oxcC.nombre, sed.impuesto, pac.bonificacion)
                    UNION
                    (SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, pci1.fecha_abono fecha_creacion, pci1.id_usuario, oxcpj.nombre as pj_name, u.forma_pago, pac.porcentaje_abono, 0 as factura, 1 expediente, oxcC.nombre as estatus_actual, (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, pac.bonificacion, cl.lugar_prospeccion
                    FROM pago_comision_ind pci1 
                    INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                    INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1
                    INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                    INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                    INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 1
                    INNER JOIN usuarios u ON u.id_usuario = com.id_usuario  
                    INNER JOIN opcs_x_cats oxcpj ON oxcpj.id_opcion = u.forma_pago AND oxcpj.id_catalogo = 16 
                    INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                    INNER JOIN opcs_x_cats oxcC ON pci1.estatus = oxcC.id_opcion and oxcC.id_catalogo = 23
                    INNER JOIN sedes sed ON sed.id_sede = $sede and sed.estatus = 1
                    WHERE pci1.estatus IN ($estado) AND com.estatus in (1) AND lo.idStatusContratacion > 8   AND com.id_usuario = $user_data 
                    GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, 
                    com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata,
                    pci1.estatus, pci1.fecha_abono, pci1.id_usuario,  oxcpj.nombre, 
                    u.forma_pago,pci1.id_pago_i, pac.porcentaje_abono, oxcC.nombre, sed.impuesto, pac.bonificacion, cl.lugar_prospeccion)");
        }




    function getDatosComisionesAsesorBaja($estado){
        $filtro = 'AND u.estatus = 0 AND u.id_rol IN (3,9,7,42)';
        $sede = $this->session->userdata('id_sede');
        
        return $this->db->query("(SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, pci1.fecha_abono fecha_creacion, pci1.id_usuario, oxcpj.nombre as pj_name, u.forma_pago, pac.porcentaje_abono, 0 as factura, 1 expediente, oxcC.nombre as estatus_actual, (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, pac.bonificacion,  0 lugar_prospeccion, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) as user_names, oxcrol.nombre as puesto
                    FROM pago_comision_ind pci1 
                    INNER JOIN comisiones com ON pci1.id_comision = com.id_comision 
                    INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1
                    INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                    INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                    INNER JOIN usuarios u ON u.id_usuario = com.id_usuario  
                    INNER JOIN opcs_x_cats oxcrol ON oxcrol.id_opcion = u.id_rol AND oxcrol.id_catalogo = 1 
                    INNER JOIN opcs_x_cats oxcpj ON oxcpj.id_opcion = u.forma_pago AND oxcpj.id_catalogo = 16 
                    INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                    INNER JOIN opcs_x_cats oxcC ON pci1.estatus = oxcC.id_opcion and oxcC.id_catalogo = 23
                    LEFT JOIN sedes sed ON sed.id_sede = $sede and sed.estatus = 1
                    WHERE pci1.estatus IN ($estado) AND ( (lo.idStatusContratacion < 9 AND com.estatus IN (1,8)) OR (lo.idStatusContratacion > 8 AND com.estatus IN (8))) $filtro
                    GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, 
                    com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata,
                    pci1.estatus, pci1.fecha_abono, pci1.id_usuario,  oxcpj.nombre, 
                    u.forma_pago,pci1.id_pago_i, pac.porcentaje_abono, oxcC.nombre, sed.impuesto, pac.bonificacion, u.nombre, u.apellido_paterno, u.apellido_materno, oxcrol.nombre)
                    UNION
                    (SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, pci1.fecha_abono fecha_creacion, pci1.id_usuario, oxcpj.nombre as pj_name, u.forma_pago, pac.porcentaje_abono, 0 as factura, 1 expediente, oxcC.nombre as estatus_actual, (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, pac.bonificacion, cl.lugar_prospeccion, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) as user_names, oxcrol.nombre as puesto
                    FROM pago_comision_ind pci1 
                    INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                    INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1
                    INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                    INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                    INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 1
                    INNER JOIN usuarios u ON u.id_usuario = com.id_usuario  
                    INNER JOIN opcs_x_cats oxcrol ON oxcrol.id_opcion = u.id_rol AND oxcrol.id_catalogo = 1 
                    INNER JOIN opcs_x_cats oxcpj ON oxcpj.id_opcion = u.forma_pago AND oxcpj.id_catalogo = 16 
                    INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                    INNER JOIN opcs_x_cats oxcC ON pci1.estatus = oxcC.id_opcion and oxcC.id_catalogo = 23
                    INNER JOIN sedes sed ON sed.id_sede = $sede and sed.estatus = 1
                    WHERE pci1.estatus IN ($estado) AND com.estatus in (1) AND lo.idStatusContratacion > 8 $filtro 
                    GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total, 
                    com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata,
                    pci1.estatus, pci1.fecha_abono, pci1.id_usuario,  oxcpj.nombre, 
                    u.forma_pago,pci1.id_pago_i, pac.porcentaje_abono, oxcC.nombre, sed.impuesto, pac.bonificacion, cl.lugar_prospeccion, u.nombre, u.apellido_paterno, u.apellido_materno,oxcrol.nombre)");
        }

 



        function factura_comision( $uuid, $id_res){
            return $this->db->query("SELECT DISTINCT CAST(uuid AS VARCHAR(MAX)) AS uuid ,
            u.nombre, u.apellido_paterno, u.apellido_materno, res.nombreResidencial as nombreLote, f.fecha_factura, f.folio_factura, f.metodo_pago, f.regimen, f.forma_pago, f.cfdi, f.unidad, f.claveProd, f.total, f.total as porcentaje_dinero, f.nombre_archivo,  CAST(f.descripcion AS VARCHAR(MAX)) AS descrip
            FROM facturas f 
            INNER JOIN usuarios u ON u.id_usuario = f.id_usuario
            INNER JOIN pago_comision_ind pci ON pci.id_pago_i = f.id_comision
            INNER JOIN comisiones com ON com.id_comision = pci.id_comision
            INNER JOIN lotes l ON l.idLote = com.id_lote
            INNER JOIN condominios con ON con.idCondominio = l.idCondominio
            INNER JOIN residenciales res ON res.idResidencial = con.idResidencial and res.idResidencial = $id_res
            WHERE MONTH(f.fecha_ingreso) >= 4 AND f.uuid = '".$uuid."' ");
            }
        

     
        function update_acepta_solicitante($idsol) {
          $query = $this->db->query("UPDATE pago_comision_ind SET estatus = 4, fecha_pago_intmex = GETDATE() WHERE id_pago_i IN (".$idsol.")");
          return true;
        }


          function update_acepta_solicitante_mk($idsol) {
            return $this->db->query("UPDATE pago_comision_mktd SET estatus = 4 WHERE id_pago_mk IN (".$idsol.")");
          }



          
        
        function update_acepta_solicitante_uno($idsol) {
            return $this->db->query("UPDATE pago_comision_ind SET estatus = 42 WHERE id_pago_i IN (".$idsol.")");
          }
        function update_acepta_solicitante_dos($idsol) {
            return $this->db->query("UPDATE pago_comision_ind SET estatus = 41 WHERE id_pago_i IN (".$idsol.")");
          }


          

          function getDesarrolloSelect($a = ''){

            if($a == ''){

                $usuario = $this->session->userdata('id_usuario');

            }else{
                $usuario = $a;

            }
            return $this->db->query(" SELECT res.idResidencial id_usuario, concat(res.nombreResidencial,' ',res.descripcion)  as name_user FROM residenciales res WHERE res.idResidencial NOT IN 
                 
            (SELECT re.idResidencial 
               FROM residenciales re
               INNER JOIN condominios co ON re.idResidencial = co.idResidencial
               INNER JOIN lotes lo ON lo.idCondominio = co.idCondominio
               INNER JOIN comisiones com ON com.id_lote = lo.idLote AND com.estatus in (1,8)
               INNER JOIN pago_comision_ind pci ON pci.id_comision = com.id_comision
               INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (2) 
               WHERE pci.estatus IN (4) AND u.id_usuario = ".$usuario." GROUP BY re.idResidencial) AND res.status = 1
               AND res.idResidencial IN         
               (SELECT re.idResidencial 
               FROM residenciales re
               INNER JOIN condominios co ON re.idResidencial = co.idResidencial
               INNER JOIN lotes lo ON lo.idCondominio = co.idCondominio
               INNER JOIN comisiones com ON com.id_lote = lo.idLote AND com.estatus in (1,8)
               INNER JOIN pago_comision_ind pci ON pci.id_comision = com.id_comision
               INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (2) 
               WHERE pci.estatus IN (1) AND u.id_usuario = ".$usuario." GROUP BY re.idResidencial)");
           
            // return $this->db->query("SELECT res.idResidencial id_usuario, res.nombreResidencial  as name_user, descripcion FROM residenciales res");
        }

        public function getDatosProyecto($idlote,$id_usuario = ''){

            if($id_usuario == ''){
                $id_user_V3 = $this->session->userdata('id_usuario');

            }else{
                $id_user_V3 = $id_usuario;

            }


                return $this->db->query("SELECT pci.id_pago_i, pci.pago_neodata, pci.abono_neodata  ,res.idResidencial , lot.nombreLote, res.nombreResidencial , res.idResidencial
                FROM pago_comision_ind pci
                INNER JOIN comisiones com ON com.id_comision = pci.id_comision
                INNER JOIN lotes lot ON lot.idLote = com.id_lote
                INNER JOIN condominios con ON con.idCondominio = lot.idCondominio
                INNER JOIN residenciales res ON res.idResidencial = con.idResidencial
                
                WHERE pci.estatus = 1 AND pci.id_usuario = $id_user_V3 AND res.idResidencial = $idlote");
         
        }
    
        function leerxml( $xml_leer, $cargar_xml ){
            $str = '';
            if( $cargar_xml ){
                rename( $xml_leer, "./UPLOADS/XMLS/documento_temporal.txt" );
                $str = file_get_contents( "./UPLOADS/XMLS/documento_temporal.txt" );
            if( substr ( $str, 0, 3 ) == 'o;?' ){
                $str = str_replace( "o;?", "", $str );
                file_put_contents( './UPLOADS/XMLS/documento_temporal.txt', $str );
            }
            rename( "./UPLOADS/XMLS/documento_temporal.txt", $xml_leer );
        }
        libxml_use_internal_errors(true);
        $xml = simplexml_load_file( $xml_leer, null, true );

        $datosxml = array(
            "version" => $xml ->xpath('//cfdi:Comprobante')[0]['Version'],
            "regimenFiscal" => $xml ->xpath('//cfdi:Emisor')[0]['RegimenFiscal'],
            "formaPago" => $xml -> xpath('//cfdi:Comprobante')[0]['FormaPago'],
            "usocfdi" => $xml -> xpath('//cfdi:Receptor')[0]['UsoCFDI'],
            "metodoPago" => $xml -> xpath('//cfdi:Comprobante')[0]['MetodoPago'],
            "claveUnidad" => $xml -> xpath('//cfdi:Concepto')[0]['ClaveUnidad'],
            "unidad" => $xml -> xpath('//cfdi:Concepto')[0]['Unidad'],
            "claveProdServ" => $xml -> xpath('//cfdi:Concepto')[0]['ClaveProdServ'],
            "descripcion" => $xml -> xpath('//cfdi:Concepto')[0]['Descripcion'],
            "subTotal" => $xml -> xpath('//cfdi:Comprobante')[0]['SubTotal'],
            "total" => $xml -> xpath('//cfdi:Comprobante')[0]['Total'],
            "rfcemisor" => $xml -> xpath('//cfdi:Emisor')[0]['Rfc'],
            "nameEmisor" => $xml -> xpath('//cfdi:Emisor')[0]['Nombre'],
            "rfcreceptor" => $xml -> xpath('//cfdi:Receptor')[0]['Rfc'],
            "namereceptor" => $xml -> xpath('//cfdi:Receptor')[0]['Nombre'],
            "TipoRelacion"=> $xml->xpath('//@TipoRelacion'),
            "uuidV" =>$xml->xpath('//@UUID')[0],
            "fecha"=> $xml -> xpath('//cfdi:Comprobante')[0]['Fecha'],
            "folio"=> $xml -> xpath('//cfdi:Comprobante')[0]['Folio'],
        );
        $datosxml["textoxml"] = $str;
        return $datosxml;
    }
    
    
    function verificar_uuid( $uuid ){
        return $this->db->query("SELECT * FROM facturas WHERE uuid = '".$uuid."'");
    }
    
    function insertar_factura( $id_comision, $datos_factura,$usuarioid){
        $VALOR_TEXT = $datos_factura['textoxml'];
        $data = array(
            "fecha_factura"  => $datos_factura['fecha'],
            "folio_factura"  => $datos_factura['folio'],
            "descripcion" => $datos_factura['descripcion'],
            "subtotal" => $datos_factura['subTotal'],
            "total"  => $datos_factura['total'],
            "metodo_pago"  => $datos_factura['metodoPago'],
            "uuid" => $datos_factura['uuidV'],
            "nombre_archivo" => $datos_factura['nombre_xml'],
            "id_usuario" => $usuarioid,
            "id_comision" => $id_comision,
            "regimen" => $datos_factura['regimenFiscal'],
            "forma_pago" => $datos_factura['formaPago'],
            "cfdi" => $datos_factura['usocfdi'],
            "unidad" => $datos_factura['claveUnidad'],
            "claveProd" => $datos_factura['claveProdServ']
        );
        $this->db->insert("facturas", $data);
        $ultimoId = $this->db->insert_id();
        return $this->db->query("INSERT INTO xmldatos VALUES (".$ultimoId.", '".$VALOR_TEXT."', GETDATE())");
    }
 
    function getDatosPlanesMktd(){
    return $this->db->query("SELECT * FROM planes_mktd");
}

function getDatosColabMktd($sede, $plan){

  if($plan == 9 || $plan == 11){
    $filtro_1 = ' , 28';
    $filtro_2 = " UNION (SELECT pk.id_plan, pk.fecha_plan, getdate() as fin_plan, u.id_usuario, CONCAT(u.nombre,' ' ,u.apellido_paterno,' ',u.apellido_materno) AS colaborador, op1.nombre AS rol, pcm.porcentaje, u.id_sede, op1.id_opcion, (CASE op1.id_opcion WHEN '18' THEN 1 WHEN '19' THEN 2 WHEN '20 ' THEN 3 WHEN '25' THEN 4 ELSE op1.id_opcion END) as rol_dos FROM planes_mktd pk INNER JOIN porcentajes_mktd pcm ON pcm.numero_plan = pk.id_plan INNER JOIN usuarios u ON u.id_usuario = pcm.id_usuario INNER JOIN opcs_x_cats op1 ON op1.id_opcion = pcm.rol WHERE op1.id_catalogo = 1 AND pcm.rol IN (28) AND pcm.id_plaza IN (2) AND pk.id_plan = $plan) ";

  }

  else{
 $filtro_1 = ' ';
    $filtro_2 = ' ';
  }

    return $this->db->query("(SELECT pk.id_plan, pk.fecha_plan, getdate() as fin_plan, u.id_usuario, CONCAT(u.nombre,' ' ,u.apellido_paterno,' ',u.apellido_materno) AS colaborador, op1.nombre AS rol, pcm.porcentaje, u.id_sede, op1.id_opcion,  (CASE op1.id_opcion WHEN '18' THEN 1 WHEN '10' THEN 2 WHEN '19' THEN 3 WHEN '37' THEN 4 WHEN '25 ' THEN 5 WHEN '29' THEN 6 WHEN '30' THEN 7 WHEN '20' THEN 8 WHEN '28' THEN 9 ELSE op1.id_opcion END) as rol_dos
    FROM planes_mktd pk INNER JOIN porcentajes_mktd pcm ON pcm.numero_plan = pk.id_plan INNER JOIN usuarios u ON u.id_usuario = pcm.id_usuario INNER JOIN opcs_x_cats op1 ON op1.id_opcion = pcm.rol WHERE op1.id_catalogo = 1 AND pcm.rol NOT IN (19, 20 ".$filtro_1.") AND pk.id_plan = $plan)

     UNION (SELECT pk.id_plan, pk.fecha_plan, getdate() as fin_plan, u.id_usuario, CONCAT(u.nombre,' ' ,u.apellido_paterno,' ',u.apellido_materno) AS colaborador, op1.nombre AS rol, pcm.porcentaje, u.id_sede, op1.id_opcion, (CASE op1.id_opcion WHEN '18' THEN 1 WHEN '19' THEN 2 WHEN '20 ' THEN 3 WHEN '25' THEN 4 ELSE op1.id_opcion END) as rol_dos FROM planes_mktd pk INNER JOIN porcentajes_mktd pcm ON pcm.numero_plan = pk.id_plan INNER JOIN usuarios u ON u.id_usuario = pcm.id_usuario INNER JOIN opcs_x_cats op1 ON op1.id_opcion = pcm.rol WHERE op1.id_catalogo = 1 AND pcm.rol IN (20) AND pcm.id_sede IN ($sede) AND pk.id_plan = $plan) 

     ".$filtro_2."

     UNION (SELECT pk.id_plan, pk.fecha_plan, getdate() as fin_plan, u.id_usuario, CONCAT(u.nombre,' ' ,u.apellido_paterno,' ',u.apellido_materno) AS colaborador, op1.nombre AS rol, pcm.porcentaje, u.id_sede, op1.id_opcion, (CASE op1.id_opcion WHEN '18' THEN 1 WHEN '19' THEN 2 WHEN '20 ' THEN 3 WHEN '25' THEN 4 ELSE op1.id_opcion END) as rol_dos FROM planes_mktd pk INNER JOIN porcentajes_mktd pcm ON pcm.numero_plan = pk.id_plan INNER JOIN usuarios u ON u.id_usuario = pcm.id_usuario INNER JOIN opcs_x_cats op1 ON op1.id_opcion = pcm.rol WHERE op1.id_catalogo = 1 AND pcm.rol IN (19) AND pcm.id_plaza IN (2) AND pk.id_plan = $plan) order by rol_dos");

 }




function getDatosColabMktd2($sede, $plan){

  
  if($plan == 9 || $plan == 11){
    $filtro_1 = ' , 28';
    $filtro_2 = " UNION (SELECT pk.id_plan, pk.fecha_plan, getdate() as fin_plan, u.id_usuario, CONCAT(u.nombre,' ' ,u.apellido_paterno,' ',u.apellido_materno) AS colaborador, op1.nombre AS rol, pcm.porcentaje, u.id_sede, op1.id_opcion, (CASE op1.id_opcion WHEN '18' THEN 1 WHEN '19' THEN 2 WHEN '20 ' THEN 3 WHEN '25' THEN 4 ELSE op1.id_opcion END) as rol_dos FROM planes_mktd pk INNER JOIN porcentajes_mktd pcm ON pcm.numero_plan = pk.id_plan INNER JOIN usuarios u ON u.id_usuario = pcm.id_usuario INNER JOIN opcs_x_cats op1 ON op1.id_opcion = pcm.rol WHERE op1.id_catalogo = 1 AND pcm.rol IN (28) AND pcm.id_plaza IN (3) AND pk.id_plan = $plan) ";

  }

  else{
 $filtro_1 = ' ';
    $filtro_2 = ' ';
  }

    return $this->db->query("(SELECT pk.id_plan, pk.fecha_plan, getdate() as fin_plan, u.id_usuario, CONCAT(u.nombre,' ' ,u.apellido_paterno,' ',u.apellido_materno) AS colaborador, op1.nombre AS rol, pcm.porcentaje, u.id_sede, op1.id_opcion,  (CASE op1.id_opcion WHEN '18' THEN 1 WHEN '10' THEN 2 WHEN '19' THEN 3 WHEN '37' THEN 4 WHEN '25 ' THEN 5 WHEN '29' THEN 6 WHEN '30' THEN 7 WHEN '20' THEN 8 WHEN '28' THEN 9 ELSE op1.id_opcion END) as rol_dos
    FROM planes_mktd pk INNER JOIN porcentajes_mktd pcm ON pcm.numero_plan = pk.id_plan INNER JOIN usuarios u ON u.id_usuario = pcm.id_usuario INNER JOIN opcs_x_cats op1 ON op1.id_opcion = pcm.rol WHERE op1.id_catalogo = 1 AND pcm.rol NOT IN (19, 20 ".$filtro_1.") AND pk.id_plan = $plan)

     UNION (SELECT pk.id_plan, pk.fecha_plan, getdate() as fin_plan, u.id_usuario, CONCAT(u.nombre,' ' ,u.apellido_paterno,' ',u.apellido_materno) AS colaborador, op1.nombre AS rol, pcm.porcentaje, u.id_sede, op1.id_opcion, (CASE op1.id_opcion WHEN '18' THEN 1 WHEN '19' THEN 2 WHEN '20 ' THEN 3 WHEN '25' THEN 4 ELSE op1.id_opcion END) as rol_dos FROM planes_mktd pk INNER JOIN porcentajes_mktd pcm ON pcm.numero_plan = pk.id_plan INNER JOIN usuarios u ON u.id_usuario = pcm.id_usuario INNER JOIN opcs_x_cats op1 ON op1.id_opcion = pcm.rol WHERE op1.id_catalogo = 1 AND pcm.rol IN (20) AND pcm.id_sede IN ($sede) AND pk.id_plan = $plan) 

     ".$filtro_2."

     UNION (SELECT pk.id_plan, pk.fecha_plan, getdate() as fin_plan, u.id_usuario, CONCAT(u.nombre,' ' ,u.apellido_paterno,' ',u.apellido_materno) AS colaborador, op1.nombre AS rol, pcm.porcentaje, u.id_sede, op1.id_opcion, (CASE op1.id_opcion WHEN '18' THEN 1 WHEN '19' THEN 2 WHEN '20 ' THEN 3 WHEN '25' THEN 4 ELSE op1.id_opcion END) as rol_dos FROM planes_mktd pk INNER JOIN porcentajes_mktd pcm ON pcm.numero_plan = pk.id_plan INNER JOIN usuarios u ON u.id_usuario = pcm.id_usuario INNER JOIN opcs_x_cats op1 ON op1.id_opcion = pcm.rol WHERE op1.id_catalogo = 1 AND pcm.rol IN (19) AND pcm.id_plaza IN (3) AND pk.id_plan = $plan) order by rol_dos");

 }

 

 function getDatosSumaMktd($sede, $PLAN,$empresa, $res){

    return $this->db->query("SELECT SUM (pci.abono_neodata) suma_f01, STRING_AGG(pci.id_pago_i, ', ') AS valor_obtenido, res.empresa, res.nombreResidencial
                                FROM pago_comision_ind pci 
                                INNER JOIN comisiones com ON com.id_comision = pci.id_comision
                                INNER JOIN lotes lo ON lo.idLote = com.id_lote
                                INNER JOIN condominios con ON con.idCondominio = lo.idCondominio
                                INNER JOIN residenciales res ON res.idResidencial = con.idResidencial
                                INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente
                                INNER JOIN planes_mktd plm ON plm.fecha_plan <= cl.fechaApartado AND plm.fin_plan >= cl.fechaApartado
                                INNER JOIN sedes s ON s.id_sede = lo.ubicacion_dos
                                INNER JOIN usuarios us ON us.id_usuario = pci.id_usuario
                                WHERE pci.estatus IN (1, 41, 42, 51, 52, 61, 62, 12) AND lo.idLote IN (select id_lote from reportes_marketing WHERE estatus = 1 AND dispersion = 1) AND pci.id_usuario = 4394
                                AND lo.status = 1 AND lo.idLote NOT IN (select id_lote from compartidas_mktd)
                                AND cl.status = 1
                    
                 AND cl.id_asesor IN (SELECT id_usuario FROM usuarios WHERE id_sede LIKE '".$sede."' AND id_rol IN (7,9)) 
                 AND plm.id_plan = ".$PLAN." AND res.empresa = '".$empresa."' AND res.idResidencial = '".$res."'
                                GROUP BY plm.id_plan, pci.id_usuario, lo.ubicacion_dos, s.nombre, us.nombre, us.apellido_paterno, res.empresa, res.nombreResidencial
                                ORDER by plm.id_plan");
    
 }

   


 function getDatosSumaMktdComp($sede, $PLAN,$empresa, $s1, $s2){

    return $this->db->query("SELECT SUM (pci.abono_neodata) suma_f01, STRING_AGG(pci.id_pago_i, ', ') AS valor_obtenido, res.empresa
                                FROM pago_comision_ind pci 
                                INNER JOIN comisiones com ON com.id_comision = pci.id_comision
                                INNER JOIN lotes lo ON lo.idLote = com.id_lote
                                INNER JOIN condominios con ON con.idCondominio = lo.idCondominio
                                INNER JOIN residenciales res ON res.idResidencial = con.idResidencial
                                INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente
                                INNER JOIN planes_mktd plm ON plm.fecha_plan <= cl.fechaApartado AND plm.fin_plan >= cl.fechaApartado
                                INNER JOIN sedes s ON s.id_sede = lo.ubicacion_dos
                                INNER JOIN usuarios us ON us.id_usuario = pci.id_usuario
                                INNER JOIN compartidas_mktd cmktd on com.id_lote=cmktd.id_lote
                                INNER JOIN sedes s1 on s1.id_sede=cmktd.sede1 
                                INNER JOIN sedes s2 on s2.id_sede=cmktd.sede2
                                WHERE pci.estatus IN (1, 41, 42, 51, 52, 61, 62, 12) AND lo.idLote IN  (select id_lote from reportes_marketing WHERE estatus = 1 AND dispersion = 1) 
                                AND pci.id_usuario = 4394
                                AND lo.status = 1 
                                AND cl.status = 1
                                AND plm.id_plan = ".$PLAN." AND res.empresa =  '".$empresa."' AND s1.id_sede = ".$s1." and s2.id_sede = ".$s2." 

                                GROUP BY plm.id_plan, pci.id_usuario, lo.ubicacion_dos, s.nombre, us.nombre, us.apellido_paterno, res.empresa
                                ORDER by plm.id_plan");

    
 }

 

 function getDatosUsersMktd($val){
    return $this->db->query("SELECT pk.id_porcentaje, pk.id_usuario, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) usuario,rol.id_opcion,  rol.nombre as puesto, pk.porcentaje, 
    plaza.nombre as plaza, sede.nombre as sede, pk.numero_plan, pk.rol
    FROM porcentajes_mktd pk 
    LEFT JOIN usuarios u ON u.id_usuario = pk.id_usuario
    LEFT JOIN opcs_x_cats rol ON rol.id_opcion = pk.rol
    LEFT JOIN opcs_x_cats plaza ON plaza.id_opcion = pk.id_plaza
    LEFT JOIN sedes sede ON sede.id_sede = pk.id_sede
    WHERE rol.id_catalogo = 1 AND plaza.id_catalogo = 36 AND pk.numero_plan = ".$val."
    ORDER BY pk.id_plaza");
}

 
function nueva_mktd_comision($values_send,$id_usuario,$abono_mktd,$pago_mktd,$user, $num_plan,$empresa){

    $respuesta = $this->db->query("INSERT INTO pago_comision_mktd (id_list, id_usuario, abono_marketing, fecha_abono, fecha_pago_intmex, pago_mktd, estatus, creado_por, comentario,empresa) VALUES ('$values_send', $id_usuario, $abono_mktd, GETDATE(),  GETDATE(), $pago_mktd,  1, $user, 'DISPERSI??N MKTD $num_plan','$empresa')");

    if (! $respuesta ) {
        return false;
    } else {
        return true;
    }
}

 
function updatePagoInd($pago_id){
      
    $respuesta =  $this->db->query("UPDATE pago_comision_ind SET estatus = 13,fecha_pago_intmex=GETDATE() WHERE id_pago_i = ".$pago_id."");
    if (! $respuesta ) {
     return false;
 } else {
     return true;
 }
   }





    /**--------------------------------------------------------------------------------------- */
    function getDatosNuevasSNL(){
        return $this->db->query("SELECT /*pci1.id_pago_i, */pci1.id_comision, pci1.id_pago_i, pci1.id_usuario,  lo.nombreLote as lote, re.nombreResidencial as proyecto, sed.nombre,  sed.id_sede, 
        lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, 
        pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, oxc.nombre as lugar_prosp, pci1.estatus, 
        /*pci1.fecha_abono fecha_creacion, pci1.id_usuario,*/ cl.personalidad_juridica, /*u.forma_pago,*/ pac.porcentaje_abono 
        ,contrato.expediente, com.id_lote,cl.fechaApartado,
        CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)nombreCliente
                FROM pago_comision_ind pci1 
                LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE estatus in (11) 
                GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
                INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                INNER JOIN lotes lo ON lo.idLote = com.id_lote
                INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                INNER JOIN clientes cl ON cl.idLote = lo.idLote
                INNER JOIN porcentajes_comisiones pc ON pc.relacion_prospeccion = cl.lugar_prospeccion
                INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = pc.medio_comision
                /*INNER JOIN usuarios u ON u.id_usuario = com.id_usuario*/
                INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                INNER JOIN sedes sed ON sed.id_sede = lo.ubicacion
                
                INNER JOIN (SELECT expediente, idCliente FROM historial_documento WHERE tipo_doc in (8) 
                AND status = 1 GROUP BY idCliente, expediente) contrato ON contrato.idCliente = cl.id_cliente
    
                WHERE pci1.estatus = 1 AND com.estatus in (1,8) 
                 AND oxc.id_catalogo = 30   AND com.rol_generado = 42 AND lo.ubicacion in (1) /*AND pci1.comentario IS NULL*/
                GROUP BY /*pci1.id_pago_i,*/ pci1.id_comision, cl.fechaApartado,lo.nombreLote, re.nombreResidencial, sed.nombre,  sed.id_sede, 
        lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, 
        pci2.abono_pagado, com.comision_total-pci2.abono_pagado, oxc.nombre, pci1.estatus, 
        /*pci1.fecha_abono fecha_creacion, pci1.id_usuario,*/ cl.personalidad_juridica, /*u.forma_pago,*/ pac.porcentaje_abono 
        ,contrato.expediente, com.id_lote, pci1.id_pago_i, pci1.id_usuario,CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno) ORDER BY lo.nombreLote");
    }
    function getDatosNuevasQro(){
        return $this->db->query("SELECT /*pci1.id_pago_i,*/ pci1.id_comision, pci1.id_pago_i, pci1.id_usuario,  lo.nombreLote as lote, re.nombreResidencial as proyecto, sed.nombre,  sed.id_sede, 
        lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, 
        pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, oxc.nombre as lugar_prosp, pci1.estatus, 
        /*pci1.fecha_abono fecha_creacion, pci1.id_usuario,*/ cl.personalidad_juridica, /*u.forma_pago,*/ pac.porcentaje_abono 
        ,contrato.expediente, com.id_lote,cl.fechaApartado,
        CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)nombreCliente
                FROM pago_comision_ind pci1 
                LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE estatus in (11) 
                GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
                INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                INNER JOIN lotes lo ON lo.idLote = com.id_lote
                INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                INNER JOIN clientes cl ON cl.idLote = lo.idLote
                INNER JOIN porcentajes_comisiones pc ON pc.relacion_prospeccion = cl.lugar_prospeccion
                INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = pc.medio_comision
                /*INNER JOIN usuarios u ON u.id_usuario = com.id_usuario*/
                INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                INNER JOIN sedes sed ON sed.id_sede = lo.ubicacion
                
                INNER JOIN (SELECT expediente, idCliente FROM historial_documento WHERE tipo_doc in (8) 
                AND status = 1 GROUP BY idCliente, expediente) contrato ON contrato.idCliente = cl.id_cliente
    
                WHERE pci1.estatus = 1 AND com.estatus in (1,8) 
                 AND oxc.id_catalogo = 30   AND com.rol_generado = 42 AND lo.ubicacion in (2) /*AND pci1.comentario IS NULL*/
                GROUP BY /*pci1.id_pago_i,*/ pci1.id_comision, cl.fechaApartado,lo.nombreLote, re.nombreResidencial, sed.nombre,  sed.id_sede, 
        lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, 
        pci2.abono_pagado, com.comision_total-pci2.abono_pagado, oxc.nombre, pci1.estatus, 
        /*pci1.fecha_abono fecha_creacion, pci1.id_usuario,*/ cl.personalidad_juridica, /*u.forma_pago,*/ pac.porcentaje_abono 
        ,contrato.expediente, com.id_lote, pci1.id_pago_i, pci1.id_usuario,CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno) ORDER BY lo.nombreLote");
    }
    function getDatosNuevasPen(){
        return $this->db->query("SELECT /*pci1.id_pago_i,*/ pci1.id_comision, pci1.id_pago_i, pci1.id_usuario,  lo.nombreLote as lote, re.nombreResidencial as proyecto, sed.nombre,  sed.id_sede, 
        lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, 
        pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, oxc.nombre as lugar_prosp, pci1.estatus, 
        /*pci1.fecha_abono fecha_creacion, pci1.id_usuario,*/ cl.personalidad_juridica, /*u.forma_pago,*/ pac.porcentaje_abono 
        ,contrato.expediente, com.id_lote,cl.fechaApartado,
        CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)nombreCliente
                FROM pago_comision_ind pci1 
                LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE estatus in (11) 
                GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
                INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                INNER JOIN lotes lo ON lo.idLote = com.id_lote
                INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                INNER JOIN clientes cl ON cl.idLote = lo.idLote
                INNER JOIN porcentajes_comisiones pc ON pc.relacion_prospeccion = cl.lugar_prospeccion
                INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = pc.medio_comision
                /*INNER JOIN usuarios u ON u.id_usuario = com.id_usuario*/
                INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                INNER JOIN sedes sed ON sed.id_sede = lo.ubicacion
                
                INNER JOIN (SELECT expediente, idCliente FROM historial_documento WHERE tipo_doc in (8) 
                AND status = 1 GROUP BY idCliente, expediente) contrato ON contrato.idCliente = cl.id_cliente
    
                WHERE pci1.estatus = 1 AND com.estatus in (1,8) 
                 AND oxc.id_catalogo = 30   AND com.rol_generado = 42 AND lo.ubicacion in (3) /*AND pci1.comentario IS NULL*/
                GROUP BY /*pci1.id_pago_i,*/ pci1.id_comision, cl.fechaApartado,lo.nombreLote, re.nombreResidencial, sed.nombre,  sed.id_sede, 
        lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, 
        pci2.abono_pagado, com.comision_total-pci2.abono_pagado, oxc.nombre, pci1.estatus, 
        /*pci1.fecha_abono fecha_creacion, pci1.id_usuario,*/ cl.personalidad_juridica, /*u.forma_pago,*/ pac.porcentaje_abono 
        ,contrato.expediente, com.id_lote, pci1.id_pago_i, pci1.id_usuario,CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno) ORDER BY lo.nombreLote");
    }
    function getDatosNuevasCDMX(){
        return $this->db->query("SELECT /*pci1.id_pago_i,*/ pci1.id_comision, pci1.id_pago_i, pci1.id_usuario,  lo.nombreLote as lote, re.nombreResidencial as proyecto, sed.nombre,  sed.id_sede, 
        lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, 
        pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, oxc.nombre as lugar_prosp, pci1.estatus, 
        /*pci1.fecha_abono fecha_creacion, pci1.id_usuario,*/ cl.personalidad_juridica, /*u.forma_pago,*/ pac.porcentaje_abono 
        ,contrato.expediente, com.id_lote,cl.fechaApartado,
        CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)nombreCliente
                FROM pago_comision_ind pci1 
                LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE estatus in (11) 
                GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
                INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                INNER JOIN lotes lo ON lo.idLote = com.id_lote
                INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                INNER JOIN clientes cl ON cl.idLote = lo.idLote
                INNER JOIN porcentajes_comisiones pc ON pc.relacion_prospeccion = cl.lugar_prospeccion
                INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = pc.medio_comision
                /*INNER JOIN usuarios u ON u.id_usuario = com.id_usuario*/
                INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                INNER JOIN sedes sed ON sed.id_sede = lo.ubicacion
                
                INNER JOIN (SELECT expediente, idCliente FROM historial_documento WHERE tipo_doc in (8) 
                AND status = 1 GROUP BY idCliente, expediente) contrato ON contrato.idCliente = cl.id_cliente
    
                WHERE pci1.estatus = 1 AND com.estatus in (1,8) 
                 AND oxc.id_catalogo = 30   AND com.rol_generado = 42 AND lo.ubicacion in (4) /*AND pci1.comentario IS NULL*/
                GROUP BY /*pci1.id_pago_i,*/ pci1.id_comision, cl.fechaApartado,lo.nombreLote, re.nombreResidencial, sed.nombre,  sed.id_sede, 
        lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, 
        pci2.abono_pagado, com.comision_total-pci2.abono_pagado, oxc.nombre, pci1.estatus, 
        /*pci1.fecha_abono fecha_creacion, pci1.id_usuario,*/ cl.personalidad_juridica, /*u.forma_pago,*/ pac.porcentaje_abono 
        ,contrato.expediente, com.id_lote, pci1.id_pago_i, pci1.id_usuario,CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno) ORDER BY lo.nombreLote");
    }
    function getDatosNuevasLeon(){
        return $this->db->query("SELECT /*pci1.id_pago_i,*/ pci1.id_comision, pci1.id_pago_i, pci1.id_usuario,  lo.nombreLote as lote, re.nombreResidencial as proyecto, sed.nombre,  sed.id_sede, 
        lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, 
        pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, oxc.nombre as lugar_prosp, pci1.estatus, 
        /*pci1.fecha_abono fecha_creacion, pci1.id_usuario,*/ cl.personalidad_juridica, /*u.forma_pago,*/ pac.porcentaje_abono 
        ,contrato.expediente, com.id_lote,cl.fechaApartado,
        CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)nombreCliente
                FROM pago_comision_ind pci1 
                LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE estatus in (11) 
                GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
                INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                INNER JOIN lotes lo ON lo.idLote = com.id_lote
                INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                INNER JOIN clientes cl ON cl.idLote = lo.idLote
                INNER JOIN porcentajes_comisiones pc ON pc.relacion_prospeccion = cl.lugar_prospeccion
                INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = pc.medio_comision
                /*INNER JOIN usuarios u ON u.id_usuario = com.id_usuario*/
                INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                INNER JOIN sedes sed ON sed.id_sede = lo.ubicacion
                
                INNER JOIN (SELECT expediente, idCliente FROM historial_documento WHERE tipo_doc in (8) 
                AND status = 1 GROUP BY idCliente, expediente) contrato ON contrato.idCliente = cl.id_cliente
    
                WHERE pci1.estatus = 1 AND com.estatus in (1,8) 
                 AND oxc.id_catalogo = 30   AND com.rol_generado = 42 AND lo.ubicacion in (5) /*AND pci1.comentario IS NULL*/
                GROUP BY /*pci1.id_pago_i, */pci1.id_comision, cl.fechaApartado,lo.nombreLote, re.nombreResidencial, sed.nombre,  sed.id_sede, 
        lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, 
        pci2.abono_pagado, com.comision_total-pci2.abono_pagado, oxc.nombre, pci1.estatus, 
        /*pci1.fecha_abono fecha_creacion, pci1.id_usuario,*/ cl.personalidad_juridica, /*u.forma_pago,*/ pac.porcentaje_abono 
        ,contrato.expediente, com.id_lote, pci1.id_pago_i, pci1.id_usuario,CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno) ORDER BY lo.nombreLote");
    }
    function getDatosNuevasCan(){
        return $this->db->query("SELECT /*pci1.id_pago_i,*/ pci1.id_comision, pci1.id_pago_i, pci1.id_usuario,  lo.nombreLote as lote, re.nombreResidencial as proyecto, sed.nombre,  sed.id_sede, 
        lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, 
        pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, oxc.nombre as lugar_prosp, pci1.estatus, 
        /*pci1.fecha_abono fecha_creacion, pci1.id_usuario,*/ cl.personalidad_juridica, /*u.forma_pago,*/ pac.porcentaje_abono 
        ,contrato.expediente, com.id_lote,cl.fechaApartado,
        CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno)nombreCliente
                FROM pago_comision_ind pci1 
                LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE estatus in (11) 
                GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
                INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                INNER JOIN lotes lo ON lo.idLote = com.id_lote
                INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                INNER JOIN clientes cl ON cl.idLote = lo.idLote
                INNER JOIN porcentajes_comisiones pc ON pc.relacion_prospeccion = cl.lugar_prospeccion
                INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = pc.medio_comision
                /*INNER JOIN usuarios u ON u.id_usuario = com.id_usuario*/
                INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                INNER JOIN sedes sed ON sed.id_sede = lo.ubicacion
                
                INNER JOIN (SELECT expediente, idCliente FROM historial_documento WHERE tipo_doc in (8) 
                AND status = 1 GROUP BY idCliente, expediente) contrato ON contrato.idCliente = cl.id_cliente
    
                WHERE pci1.estatus = 1 AND com.estatus in (1,8) 
                 AND oxc.id_catalogo = 30   AND com.rol_generado = 42 AND lo.ubicacion in (6) /*AND pci1.comentario IS NULL*/
                GROUP BY /*pci1.id_pago_i,*/ pci1.id_comision, cl.fechaApartado,lo.nombreLote, re.nombreResidencial, sed.nombre,  sed.id_sede, 
        lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, 
        pci2.abono_pagado, com.comision_total-pci2.abono_pagado, oxc.nombre, pci1.estatus, 
        /*pci1.fecha_abono fecha_creacion, pci1.id_usuario,*/ cl.personalidad_juridica, /*u.forma_pago,*/ pac.porcentaje_abono 
        ,contrato.expediente, com.id_lote, pci1.id_pago_i, pci1.id_usuario,CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno) ORDER BY lo.nombreLote");
    }
    
    function getDatosPlanesClub(){
        return $this->db->query("SELECT * FROM planes_club");
    }
        
    function getDatosUsersClub($val){
        return $this->db->query("SELECT pk.id_porcentajecl, pk.id_usuario, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) usuario,rol.id_opcion,  rol.nombre as puesto, pk.porcentaje, 
        plaza.nombre as plaza, sede.nombre as sede, pk.numero_plan, pk.rol
        FROM porcentajes_club pk 
        LEFT JOIN usuarios u ON u.id_usuario = pk.id_usuario
        LEFT JOIN opcs_x_cats rol ON rol.id_opcion = pk.rol
        LEFT JOIN opcs_x_cats plaza ON plaza.id_opcion = pk.id_plaza
        LEFT JOIN sedes sede ON sede.id_sede = pk.id_sede
        WHERE rol.id_catalogo = 1 AND plaza.id_catalogo = 36 AND pk.numero_plan = ".$val."
        ORDER BY pk.id_plaza");
    }
    
    
    function getDatosColabClub($sede, $lote){
        $consulta = $this->db->query("SELECT lo.idLote, cl.fechaApartado
        FROM clientes cl
        INNER JOIN lotes lo ON lo.idLote = cl.idLote
        WHERE cl.status in (1) AND lo.idLote = ".$lote."");
    
        $consulta_FINAL = $consulta->row()->fechaApartado;
    
        return $this->db->query("(SELECT pk.id_plancl, pk.fecha_plan, pk.fin_plan, u.id_usuario, CONCAT(u.nombre,' ' ,u.apellido_paterno,' ',u.apellido_materno) AS colaborador, op1.nombre AS rol, pcm.porcentaje, u.id_sede
       FROM planes_club pk
       INNER JOIN porcentajes_club pcm ON pcm.numero_plan = pk.id_plancl
       INNER JOIN usuarios u ON u.id_usuario = pcm.id_usuario
       INNER JOIN opcs_x_cats op1 ON op1.id_opcion = pcm.rol
        WHERE op1.id_catalogo = 1 AND pcm.rol  IN (22) AND (pcm.id_sede IN (".$sede.") OR pcm.id_sede = 0) AND pk.fecha_plan <= '".$consulta_FINAL."' /*AND pk.fin_plan >= '".$consulta_FINAL."'*/)
        UNION
        (SELECT pk.id_plancl, pk.fecha_plan, pk.fin_plan, u.id_usuario, CONCAT(u.nombre,' ' ,u.apellido_paterno,' ',u.apellido_materno) AS colaborador, op1.nombre AS rol, pcm.porcentaje, u.id_sede
       FROM planes_club pk
       INNER JOIN porcentajes_club pcm ON pcm.numero_plan = pk.id_plancl
       INNER JOIN usuarios u ON u.id_usuario = pcm.id_usuario
       INNER JOIN opcs_x_cats op1 ON op1.id_opcion = pcm.rol
        WHERE op1.id_catalogo = 1 AND u.id_rol IN (44) AND pcm.id_sede IN (2) AND pk.fecha_plan <= '".$consulta_FINAL."' /*AND pk.fin_plan >= '".$consulta_FINAL."'*/)
        UNION
        (SELECT pk.id_plancl, pk.fecha_plan, pk.fin_plan, u.id_usuario, CONCAT(u.nombre,' ' ,u.apellido_paterno,' ',u.apellido_materno) AS colaborador, op1.nombre AS rol, pcm.porcentaje, u.id_sede
       FROM planes_club pk
       INNER JOIN porcentajes_club pcm ON pcm.numero_plan = pk.id_plancl
       INNER JOIN usuarios u ON u.id_usuario = pcm.id_usuario
       INNER JOIN opcs_x_cats op1 ON op1.id_opcion = pcm.rol
        WHERE op1.id_catalogo = 1 AND u.id_rol IN (43, /*35,*/ 44) AND pcm.id_sede IN (2) AND pk.fecha_plan <= '".$consulta_FINAL."' /*AND pk.fin_plan >= '".$consulta_FINAL."'*/)
       
        UNION
        (SELECT pk.id_plancl, pk.fecha_plan, pk.fin_plan, u.id_usuario, CONCAT(u.nombre,' ' ,u.apellido_paterno,' ',u.apellido_materno) AS colaborador, op1.nombre AS rol, pcm.porcentaje, u.id_sede
       FROM planes_club pk
       INNER JOIN porcentajes_club pcm ON pcm.numero_plan = pk.id_plancl
       INNER JOIN usuarios u ON u.id_usuario = pcm.id_usuario
       INNER JOIN opcs_x_cats op1 ON op1.id_opcion = pcm.rol
        WHERE op1.id_catalogo = 1 AND u.id_rol IN (23) AND pcm.id_plaza IN (2) AND pk.fecha_plan <= '".$consulta_FINAL."' /*AND pk.fin_plan >= '".$consulta_FINAL."'*/)
        order by rol
    
        
        ");
     }

 function nueva_club_comision($com_value,$id_usuario,$abono_mktd,$pago_mktd,$user){
        $respuesta = $this->db->query("INSERT INTO pago_comision_ind (id_comision, id_usuario, abono_neodata, fecha_abono, fecha_pago_intmex, estatus, pago_neodata, modificado_por, comentario) VALUES (".$com_value.", ".$id_usuario.", ".$abono_mktd.",  GETDATE(),  GETDATE(), 2, ".$pago_mktd.", ".$user.", 'DISPERSION CLUB')");

        $insert_id_2 = $this->db->insert_id();
    $respuesta = $this->db->query("INSERT INTO  historial_comisiones VALUES ($insert_id_2, ".$this->session->userdata('id_usuario').", GETDATE(), 1, 'DISPERS?? CLUB MADERAS')");


        if (! $respuesta ) {
            return false;
        } else {
            return true;
        }
    }
 
 
       function getDatosComisionesNuevas_dos_bonos($proyecto, $condominio){
        if($condominio == 0){
    
            switch($this->session->userdata('id_rol')){
                case '18':
                    case '19':
                    case '20':
                    case '25':
                    case '27':
                    case '28':
                    case '30':
                    case '36':
                    case '22':
                    case '23':
                    case '43':
                    case '44':
    
                        return $this->db->query("SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto,  lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, oxc.nombre as lugar_prosp, pci1.estatus, pci1.fecha_abono fecha_creacion, pci1.id_usuario, oxcpj.nombre as pj_name, cl.personalidad_juridica, u.forma_pago, pac.porcentaje_abono ,f.id_comision as factura, contrato.expediente, oxcC.nombre as estatus_actual
                        FROM pago_comision_ind pci1 
                        LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE estatus in (11) 
                        GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
                        INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                        INNER JOIN lotes lo ON lo.idLote = com.id_lote
                        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                        INNER JOIN clientes cl ON cl.idLote = lo.idLote
                        INNER JOIN porcentajes_comisiones pc ON pc.relacion_prospeccion = cl.lugar_prospeccion
                        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = pc.medio_comision
                        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario  
                        INNER JOIN opcs_x_cats oxcpj ON oxcpj.id_opcion = u.forma_pago
                        INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                        LEFT JOIN facturas f ON f.id_comision = pci1.id_pago_i
                        INNER JOIN (SELECT expediente, idCliente FROM historial_documento WHERE tipo_doc in (8) 
                        AND status = 1 GROUP BY idCliente, expediente) contrato ON contrato.idCliente = cl.id_cliente
                        LEFT JOIN opcs_x_cats oxcC ON pci1.estatus = oxcC.id_opcion and oxcC.id_catalogo = 23
                        WHERE  re.idResidencial = $proyecto AND  pci1.id_usuario = 4688 
                        AND pci1.estatus IN (2,3) AND com.estatus in (1,8) 
                        AND oxcpj.id_catalogo = 16 AND oxc.id_catalogo = 30   
                        GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial,  lo.totalNeto2, com.comision_total, com.porcentaje_decimal, 
                        pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, oxc.nombre, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, 
                        oxcpj.nombre, cl.personalidad_juridica, u.forma_pago,pci1.id_pago_i, pac.porcentaje_abono, f.id_comision, contrato.expediente, oxcC.nombre");
                    # code...
                    break;
    
                    default:
    
                    return $this->db->query("SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto,  lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, oxc.nombre as lugar_prosp, pci1.estatus, pci1.fecha_abono fecha_creacion, pci1.id_usuario, oxcpj.nombre as pj_name, cl.personalidad_juridica, u.forma_pago, pac.porcentaje_abono ,f.id_comision as factura, contrato.expediente, oxcC.nombre as estatus_actual
                    FROM pago_comision_ind pci1 
                    LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE estatus in (11) 
                    GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
                    INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                    INNER JOIN lotes lo ON lo.idLote = com.id_lote
                    INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                    INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                    INNER JOIN clientes cl ON cl.idLote = lo.idLote
                    INNER JOIN porcentajes_comisiones pc ON pc.relacion_prospeccion = cl.lugar_prospeccion
                    INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = pc.medio_comision
                    INNER JOIN usuarios u ON u.id_usuario = com.id_usuario  
                    INNER JOIN opcs_x_cats oxcpj ON oxcpj.id_opcion = u.forma_pago
                    INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                    LEFT JOIN facturas f ON f.id_comision = pci1.id_pago_i
                    INNER JOIN (SELECT expediente, idCliente FROM historial_documento WHERE tipo_doc in (8) 
                    AND status = 1 GROUP BY idCliente, expediente) contrato ON contrato.idCliente = cl.id_cliente
    
                    LEFT JOIN opcs_x_cats oxcC ON pci1.estatus = oxcC.id_opcion and oxcC.id_catalogo = 23
                    WHERE re.idResidencial = $proyecto AND com.id_usuario = 4688 
                    AND pci1.estatus IN (1,3) AND com.estatus in (1,8) 
                    AND oxcpj.id_catalogo = 16 AND oxc.id_catalogo = 30   AND pc.id_rol = 44
                    GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial,  lo.totalNeto2, com.comision_total, com.porcentaje_decimal, 
                    pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, oxc.nombre, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, 
                    oxcpj.nombre, cl.personalidad_juridica, u.forma_pago,pci1.id_pago_i, pac.porcentaje_abono, f.id_comision, contrato.expediente, oxcC.nombre");
    
                break;
    
            }
    
    
        } else {
            switch($this->session->userdata('id_rol')){
                case '18':
                    case '19':
                    case '20':
                    case '25':
                    case '27':
                    case '28':
                    case '30':
                    case '36':
                   case '22':
                   case '23':
                   case '43':
                   case '44':
    
                        return $this->db->query("SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto,  lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, oxc.nombre as lugar_prosp, pci1.estatus, pci1.fecha_abono fecha_creacion, pci1.id_usuario, oxcpj.nombre as pj_name, cl.personalidad_juridica, u.forma_pago, pac.porcentaje_abono ,f.id_comision as factura, contrato.expediente, oxcC.nombre as estatus_actual
                        FROM pago_comision_ind pci1 
                        LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE estatus in (11) 
                        GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
                        INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                        INNER JOIN lotes lo ON lo.idLote = com.id_lote
                        INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                        INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                        INNER JOIN clientes cl ON cl.idLote = lo.idLote
                        INNER JOIN porcentajes_comisiones pc ON pc.relacion_prospeccion = cl.lugar_prospeccion
                        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = pc.medio_comision
                        INNER JOIN usuarios u ON u.id_usuario = com.id_usuario  
                        INNER JOIN opcs_x_cats oxcpj ON oxcpj.id_opcion = u.forma_pago
                        INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                        LEFT JOIN facturas f ON f.id_comision = pci1.id_pago_i
                        INNER JOIN (SELECT expediente, idCliente FROM historial_documento WHERE tipo_doc in (8) 
                        AND status = 1 GROUP BY idCliente, expediente) contrato ON contrato.idCliente = cl.id_cliente
                        LEFT JOIN opcs_x_cats oxcC ON pci1.estatus = oxcC.id_opcion and oxcC.id_catalogo = 23
                        WHERE  co.idCondominio = $condominio AND  pci1.id_usuario = ".$this->session->userdata('id_usuario')." 
                        AND pci1.estatus IN (1,3) AND com.estatus in (1,8) 
                        AND oxcpj.id_catalogo = 16 AND oxc.id_catalogo = 30   
                        GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial,  lo.totalNeto2, com.comision_total, com.porcentaje_decimal, 
                        pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, oxc.nombre, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, 
                        oxcpj.nombre, cl.personalidad_juridica, u.forma_pago,pci1.id_pago_i, pac.porcentaje_abono, f.id_comision, contrato.expediente, oxcC.nombre");
                    # code...
                    break;
    
                    default:
    
                    return $this->db->query("SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto,  lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, oxc.nombre as lugar_prosp, pci1.estatus, pci1.fecha_abono fecha_creacion, pci1.id_usuario, oxcpj.nombre as pj_name, cl.personalidad_juridica, u.forma_pago, pac.porcentaje_abono ,f.id_comision as factura, contrato.expediente, oxcC.nombre as estatus_actual
                    FROM pago_comision_ind pci1 
                    LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE estatus in (11) 
                    GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
                    INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                    INNER JOIN lotes lo ON lo.idLote = com.id_lote
                    INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                    INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                    INNER JOIN clientes cl ON cl.idLote = lo.idLote
                    INNER JOIN porcentajes_comisiones pc ON pc.relacion_prospeccion = cl.lugar_prospeccion
                    INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = pc.medio_comision
                    INNER JOIN usuarios u ON u.id_usuario = com.id_usuario  
                    INNER JOIN opcs_x_cats oxcpj ON oxcpj.id_opcion = u.forma_pago
                    INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                    LEFT JOIN facturas f ON f.id_comision = pci1.id_pago_i
                    INNER JOIN (SELECT expediente, idCliente FROM historial_documento WHERE tipo_doc in (8) 
                    AND status = 1 GROUP BY idCliente, expediente) contrato ON contrato.idCliente = cl.id_cliente
    
                    LEFT JOIN opcs_x_cats oxcC ON pci1.estatus = oxcC.id_opcion and oxcC.id_catalogo = 23
                    WHERE co.idCondominio = $condominio AND com.id_usuario = ".$this->session->userdata('id_usuario')." 
                    AND pci1.estatus IN (1,3) AND com.estatus in (1,8) 
                    AND oxcpj.id_catalogo = 16 AND oxc.id_catalogo = 30   AND pc.id_rol = ".$this->session->userdata('id_rol')."
                    GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial,  lo.totalNeto2, com.comision_total, com.porcentaje_decimal, 
                    pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, oxc.nombre, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, 
                    oxcpj.nombre, cl.personalidad_juridica, u.forma_pago,pci1.id_pago_i, pac.porcentaje_abono, f.id_comision, contrato.expediente, oxcC.nombre");
    
                break;
    
            }
        }
    }
    







    public function getDatosDispersar($idlote){
        // if ($id_pj == 1){
            return $this->db->query("SELECT l.idLote, l.referencia, r.idResidencial, l.nombreLote, c.nombre as nombreCondominio, r.nombreResidencial, cl.nombre, cl.apellido_paterno, cl.apellido_materno, l.totalNeto2,
               ae.id_usuario as id_asesor, CONCAT(ae.nombre, ' ', ae.apellido_paterno, ' ',  ae.apellido_paterno) as asesor,
               co.id_usuario as id_coordinador, CONCAT(co.nombre, ' ', co.apellido_paterno, ' ',  co.apellido_paterno) as coordinador,
               ge.id_usuario as id_gerente, CONCAT(ge.nombre, ' ', ge.apellido_paterno, ' ',  ge.apellido_paterno) as gerente,
               su.id_usuario as id_subdirector, CONCAT(su.nombre, ' ', su.apellido_paterno, ' ',  su.apellido_paterno) as subdirector,
               di.id_usuario as id_director, CONCAT(di.nombre, ' ', di.apellido_paterno, ' ',  di.apellido_paterno) as director,
                cl.fechaApartado
    
                FROM lotes l
                INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                INNER JOIN usuarios ae ON ae.id_usuario = cl.id_asesor
                LEFT JOIN usuarios co ON co.id_usuario = cl.id_coordinador
                LEFT JOIN usuarios ge ON ge.id_usuario = cl.id_gerente
                LEFT JOIN usuarios su ON su.id_usuario = ge.id_lider
                LEFT JOIN usuarios di ON di.id_usuario = su.id_lider
                WHERE l.idStatusContratacion BETWEEN 9 AND 15 
                AND l.idLote = ".$idlote."");
     
    }

    function update_lote_registro_comision($ideLote){

        $this->db->query("DELETE FROM comisiones WHERE comision_total = 0");
        $this->db->query("DELETE FROM pago_comision_ind WHERE abono_neodata = 0");
        
        return $this->db->query("UPDATE lotes SET registro_comision = 1 WHERE idLote =  ".$ideLote."");
    }

    public function getDatosAbonado($idlote){
        // if ($id_pj == 1){
            return $this->db->query("SELECT com.id_comision, com.id_usuario, lo.idLote, res.idResidencial, lo.referencia, com.id_lote, lo.nombreLote, com.porcentaje_decimal, CONCAT(us.nombre,' ' ,us.apellido_paterno,' ',us.apellido_materno) colaborador, oxc.nombre as rol, com.comision_total, pci.abono_pagado, com.rol_generado
            FROM comisiones com
            LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind 
            WHERE estatus in (11) GROUP BY id_comision) pci ON pci.id_comision = com.id_comision
            INNER JOIN lotes lo ON lo.idLote = com.id_lote 
            INNER JOIN usuarios us ON us.id_usuario = com.id_usuario
            INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = com.rol_generado
            INNER JOIN condominios con ON con.idCondominio = lo.idCondominio
            INNER JOIN residenciales res ON res.idResidencial = con.idResidencial
            WHERE oxc.id_catalogo = 1 AND com.id_lote = ".$idlote." ORDER BY com.rol_generado asc");
     
    }

    public function getDatosAbonadoDispersion($idlote){
        // if ($id_pj == 1){
            $request = $this->db->query("SELECT lugar_prospeccion FROM clientes WHERE idLote = $idlote AND status = 1")->row();

            if($request->lugar_prospeccion == 6){
                $rel_final = 6;

            }
            else{
                $rel_final = 11;

            }
            return $this->db->query("SELECT com.id_comision, com.id_usuario, lo.totalNeto2, lo.idLote, res.idResidencial, lo.referencia, com.id_lote, lo.nombreLote, com.porcentaje_decimal, CONCAT(us.nombre,' ' ,us.apellido_paterno,' ',us.apellido_materno) colaborador, oxc.nombre as rol, com.comision_total, pci.abono_pagado, com.rol_generado, pc.porcentaje_saldos, (CASE us.id_usuario WHEN 832 THEN 25  ELSE pc.porcentaje_saldos END) porcentaje_saldos,com.descuento
                        FROM comisiones com
                        LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind 
                        GROUP BY id_comision) pci ON pci.id_comision = com.id_comision
                        INNER JOIN lotes lo ON lo.idLote = com.id_lote 
                        INNER JOIN usuarios us ON us.id_usuario = com.id_usuario
                        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = com.rol_generado
                        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio
                        INNER JOIN residenciales res ON res.idResidencial = con.idResidencial
                        INNER JOIN porcentajes_comisiones pc ON pc.id_rol = com.rol_generado
                        WHERE oxc.id_catalogo = 1 AND com.id_lote = $idlote AND pc.relacion_prospeccion = $rel_final AND com.estatus = 1 ORDER BY com.rol_generado asc");
     
    }


    

    public function getDatosAbonadoSuma1($idlote){
            return $this->db->query("SELECT sum(comision_total) val FROM comisiones where id_lote = ".$idlote." union all
            SELECT sum(abono_neodata) val FROM pago_comision_ind where id_comision in (SELECT id_comision FROM comisiones where id_lote = ".$idlote.")");
    }

    public function getDatosAbonadoSuma11($idlote){
        return $this->db->query("SELECT SUM(pci.abono_neodata) abonado, pac.total_comision, lo.totalNeto2, cl.lugar_prospeccion
        FROM lotes lo
        INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente
        LEFT JOIN comisiones c1  ON lo.idLote = c1.id_lote AND c1.estatus = 1
        LEFT JOIN pago_comision_ind pci on pci.id_comision = c1.id_comision
        LEFT JOIN pago_comision pac ON pac.id_lote = lo.idLote
        WHERE lo.status = 1 AND cl.status = 1 AND c1.estatus = 1 AND lo.idLote in ($idlote)
        GROUP BY lo.idLote, lo.referencia, pac.total_comision, lo.totalNeto2, cl.lugar_prospeccion");
        }

    
  

    function update_pago_comision($ideLote, $TOTALCOMISION, $PORCETOTAL, $ABONOCONTRALORIA, $PENDICONTRALORIA){
        return $this->db->query("INSERT INTO pago_comision
           ([id_lote],[total_comision],[abonado],[porcentaje_abono],[pendiente],[creado_por],[fecha_modificacion],[fecha_abono])
           VALUES (".$ideLote.", ".$TOTALCOMISION.", ".$ABONOCONTRALORIA.", ".$PORCETOTAL.", ".$PENDICONTRALORIA.", ".$this->session->userdata('id_usuario').", GETDATE(), GETDATE())");
    }


    function update_precio($a, $b){
        $id_user_Vl = $this->session->userdata('id_usuario');

    $this->db->query("INSERT INTO  historial_comisiones VALUES (0, ".$id_user_Vl.", GETDATE(), 7, 'SE AGREG?? PRECIO DE LOTE ".$b." ')");
        return $this->db->query("UPDATE lotes SET totalNeto2 = ".$a." WHERE idLote = ".$b."");
    }


  // function update_pagada_comision($idLote) {

  //   $id_user_Vl = $this->session->userdata('id_usuario');

  //   $this->db->query("INSERT INTO  historial_comisiones VALUES (0, ".$id_user_Vl.", GETDATE(), 7, 'SE MARC?? COMO LIQUIDADO ".$idLote." ')");
  //   return $this->db->query("UPDATE lotes SET registro_comision = 7 WHERE idLote IN (".$idLote.")");

  // }

function update_pagada_comision($idLote,$estatus,$comentario,$comentarioPago) {

    $id_user_Vl = $this->session->userdata('id_usuario');

    $this->db->query("INSERT INTO historial_comisiones VALUES (0, ".$id_user_Vl.", GETDATE(), ".$estatus.", '".$comentario." ')");
    $request = $this->db->query("select * from pago_comision_ind where id_comision in (select id_comision from comisiones where id_lote=".$idLote.") ")->result_array();
    if(count($request) > 0){
    for ($i=0; $i <count($request); $i++) { 
        $this->db->query("INSERT INTO historial_comisiones VALUES (".$request[$i]['id_pago_i'].", ".$request[$i]['id_usuario'].", GETDATE(), ".$estatus.", '".$comentarioPago." ')");
    }
}
    return $this->db->query("UPDATE lotes SET registro_comision = ".$estatus." WHERE idLote IN (".$idLote.")");

  }
    // function update_pagada_comision($idLote,$estatus,$comentario) {

    //     $id_user_Vl = $this->session->userdata('id_usuario');

    //     if($estatus == 8){
    //         $this->db->query("UPDATE pago_comision SET bandera = 8 WHERE id_lote IN (".$idLote.")");
    //     }
    //     $this->db->query("INSERT INTO historial_comisiones VALUES (0, ".$id_user_Vl.", GETDATE(), ".$estatus.", '".$comentario." ')");
    //     return $this->db->query("UPDATE lotes SET registro_comision = ".$estatus." WHERE idLote IN (".$idLote.")");
    // }

    function getDatosComisionesDispersarContraloria(){
        // return $this->db->query("SELECT l.idLote, l.plan_enganche, l.nombreLote, c.nombre as nombreCondominio, r.nombreResidencial, cl.nombre, cl.apellido_paterno, cl.apellido_materno, l.totalNeto2, vc.id_asesor as uservc, l.registro_comision
        //     FROM lotes l
        //     INNER JOIN condominios c ON c.idCondominio = l.idCondominio
        //     INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
        //     INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
        //     LEFT JOIN ventas_compartidas vc ON vc.id_cliente = cl.id_cliente
        //     WHERE l.idStatusContratacion BETWEEN 9 AND 15 AND l.registro_comision IN (0,1) AND l.status = 1 AND cl.status = 1 GROUP BY l.idLote, l.nombreLote, c.nombre, r.nombreResidencial, cl.nombre, cl.apellido_paterno, cl.apellido_materno, l.totalNeto2, vc.id_asesor, l.registro_comision, l.plan_enganche ");

return $this->db->query("SELECT l.idLote, l.plan_enganche, l.nombreLote, c.nombre as nombreCondominio, r.nombreResidencial, cl.nombre, cl.apellido_paterno, cl.apellido_materno, l.totalNeto2, vc.id_cliente as uservc, l.registro_comision
           FROM lotes l
           INNER JOIN condominios c ON c.idCondominio = l.idCondominio
           INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
           INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
           LEFT JOIN ventas_compartidas vc ON vc.id_cliente = cl.id_cliente AND vc.estatus = 1
           WHERE l.idStatusContratacion BETWEEN 9 AND 15 
           
           AND l.registro_comision IN (854)
           
           AND l.status = 1 AND cl.status = 1 /*AND l.plan_enganche is null */
           
           
           GROUP BY l.idLote, l.nombreLote, c.nombre, r.nombreResidencial, cl.nombre, cl.apellido_paterno, cl.apellido_materno, l.totalNeto2, l.registro_comision, l.plan_enganche, vc.id_cliente");
    }


    function getDirector(){
        return $this->db->query("  SELECT us.id_usuario, CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) as name_user FROM usuarios us INNER JOIN opcs_x_cats opx ON opx.id_opcion = us.id_rol WHERE us.id_rol = 1 AND opx.id_catalogo = 1");
    }

    function getsubDirector(){
        return $this->db->query("  SELECT us.id_usuario, CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) as name_user FROM usuarios us INNER JOIN opcs_x_cats opx ON opx.id_opcion = us.id_rol WHERE us.id_rol = 2 AND opx.id_catalogo = 1");
    }

    function getGerenteT(){
        return $this->db->query("  SELECT us.id_usuario, CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) as name_user FROM usuarios us INNER JOIN opcs_x_cats opx ON opx.id_opcion = us.id_rol WHERE us.id_rol = 3 AND opx.id_catalogo = 1 AND us.id_sede NOT LIKE '%0%' AND us.correo NOT LIKE '%test_%'");
    }

    function getCoordinador(){
        return $this->db->query("  SELECT us.id_usuario, CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) as name_user FROM usuarios us INNER JOIN opcs_x_cats opx ON opx.id_opcion = us.id_rol WHERE us.id_rol IN (9,3,7) AND opx.id_catalogo =  1 AND us.id_sede NOT LIKE '%0%' AND us.correo NOT LIKE '%test_%'");
    }

    function getAsesor(){
        return $this->db->query("  SELECT us.id_usuario, CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) as name_user FROM usuarios us INNER JOIN opcs_x_cats opx ON opx.id_opcion = us.id_rol WHERE us.id_rol IN (3,7,9) AND opx.id_catalogo = 1 AND us.id_sede NOT LIKE '%0%' AND us.correo NOT LIKE '%test_%'");
    } 


    function getMktd(){
        return $this->db->query("  SELECT us.id_usuario, CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) as name_user FROM usuarios us INNER JOIN opcs_x_cats opx ON opx.id_opcion = us.id_rol WHERE us.id_rol IN (38) AND opx.id_catalogo = 1 AND us.id_sede NOT LIKE '%0%' AND us.correo NOT LIKE '%test_%'");
    }
    function getEjectClub(){
        return $this->db->query("  SELECT us.id_usuario, CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) as name_user FROM usuarios us INNER JOIN opcs_x_cats opx ON opx.id_opcion = us.id_rol WHERE us.id_rol IN (22) AND opx.id_catalogo = 1 AND us.id_sede NOT LIKE '%0%' AND us.correo NOT LIKE '%test_%'");
    }
    function getSubClub(){
        return $this->db->query("  SELECT us.id_usuario, CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) as name_user FROM usuarios us INNER JOIN opcs_x_cats opx ON opx.id_opcion = us.id_rol WHERE us.id_rol IN (42) AND opx.id_catalogo = 1 AND us.id_sede NOT LIKE '%0%' AND us.correo NOT LIKE '%test_%'");
    }


    function getGreen(){
        return $this->db->query("  SELECT us.id_usuario, CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) as name_user FROM usuarios us INNER JOIN opcs_x_cats opx ON opx.id_opcion = us.id_rol WHERE us.id_rol IN (7) AND us.id_usuario = 4415 AND opx.id_catalogo = 1 AND us.id_sede NOT LIKE '%0%' AND us.correo NOT LIKE '%test_%'");
    }



    


////////////////////////

function getsubDirector2(){
    return $this->db->query("  SELECT us.id_usuario, CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) as name_user FROM usuarios us INNER JOIN opcs_x_cats opx ON opx.id_opcion = us.id_rol WHERE us.id_rol = 2 AND opx.id_catalogo = 1");
}

function getGerente2T(){
    return $this->db->query("  SELECT us.id_usuario, CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) as name_user FROM usuarios us INNER JOIN opcs_x_cats opx ON opx.id_opcion = us.id_rol WHERE us.id_rol = 3 AND opx.id_catalogo = 1 AND us.id_sede NOT LIKE '%0%' AND us.correo NOT LIKE '%test_%'");
}

function getCoordinador2(){
    return $this->db->query("  SELECT us.id_usuario, CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) as name_user FROM usuarios us INNER JOIN opcs_x_cats opx ON opx.id_opcion = us.id_rol WHERE us.id_rol IN (9,3,7) AND opx.id_catalogo =  1 AND us.id_sede NOT LIKE '%0%' AND us.correo NOT LIKE '%test_%'");
}

function getAsesor2(){
    return $this->db->query("  SELECT us.id_usuario, CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) as name_user FROM usuarios us INNER JOIN opcs_x_cats opx ON opx.id_opcion = us.id_rol WHERE us.id_rol IN (3,7,9) AND opx.id_catalogo = 1 AND us.id_sede NOT LIKE '%0%' AND us.correo NOT LIKE '%test_%'");
} 


 ////////////////////////

function getsubDirector3(){
    return $this->db->query("  SELECT us.id_usuario, CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) as name_user FROM usuarios us INNER JOIN opcs_x_cats opx ON opx.id_opcion = us.id_rol WHERE us.id_rol = 2 AND opx.id_catalogo = 1");
}

function getGerente3T(){
    return $this->db->query("  SELECT us.id_usuario, CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) as name_user FROM usuarios us INNER JOIN opcs_x_cats opx ON opx.id_opcion = us.id_rol WHERE us.id_rol = 3 AND opx.id_catalogo = 1 AND us.id_sede NOT LIKE '%0%' AND us.correo NOT LIKE '%test_%'");
}

function getCoordinador3(){
    return $this->db->query("  SELECT us.id_usuario, CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) as name_user FROM usuarios us INNER JOIN opcs_x_cats opx ON opx.id_opcion = us.id_rol WHERE us.id_rol IN (9,3,7) AND opx.id_catalogo =  1 AND us.id_sede NOT LIKE '%0%' AND us.correo NOT LIKE '%test_%'");
}

function getAsesor3(){
    return $this->db->query("  SELECT us.id_usuario, CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) as name_user FROM usuarios us INNER JOIN opcs_x_cats opx ON opx.id_opcion = us.id_rol WHERE us.id_rol IN (3,7,9) AND opx.id_catalogo = 1 AND us.id_sede NOT LIKE '%0%' AND us.correo NOT LIKE '%test_%'");
} 



function getUserMk(){
    return $this->db->query("SELECT us.id_usuario, CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) as name_user, us.id_sede, us.id_rol FROM usuarios us INNER JOIN opcs_x_cats opx ON opx.id_opcion = us.id_rol WHERE(us.id_lider in (SELECT us2.id_usuario FROM usuarios us2 WHERE us2.id_rol IN (18,19)) OR us.id_usuario IN (1980)) AND opx.id_catalogo = 1");
} 





function update_comisionesDir($ideLote, $directorSelect, $abonadoDir, $totalDir, $porcentajeDir){

    $this->db->query("INSERT INTO comisiones
   ([id_lote], [id_usuario], [comision_total], [estatus], [observaciones], [evidencia], [factura], [creado_por], [fecha_creacion], [porcentaje_decimal], [fecha_autorizacion], [rol_generado]) VALUES (".$ideLote.", ".$directorSelect.", ".$totalDir.", 1, 'IMPORTACION', NULL, NULL, ".$this->session->userdata('id_usuario').", GETDATE(), ".$porcentajeDir.", GETDATE(), 1)");

    $id = $this->db->insert_id();

    return $this->db->query("INSERT INTO pago_comision_ind
   ([id_comision], [id_usuario], [abono_neodata], [fecha_abono], [fecha_pago_intmex], [pago_neodata], [estatus], [modificado_por], [comentario]) VALUES (".$id.", ".$directorSelect.", ".$abonadoDir.",  GETDATE(), NULL, NULL, 11, ".$this->session->userdata('id_usuario').", 'IMPORTACI??N CONTRALORIA')");
   
 }



 function update_comisionessubDir($ideLote, $subdirectorSelect, $abonadosubDir, $totalsubDir, $porcentajesubDir){

    $this->db->query("INSERT INTO comisiones
   ([id_lote], [id_usuario], [comision_total], [estatus], [observaciones], [evidencia], [factura], [creado_por], [fecha_creacion], [porcentaje_decimal], [fecha_autorizacion], [rol_generado]) VALUES (".$ideLote.", ".$subdirectorSelect.", ".$totalsubDir.", 1, 'IMPORTACION', NULL, NULL, ".$this->session->userdata('id_usuario').", GETDATE(), ".$porcentajesubDir.", GETDATE(), 2)");

    $id = $this->db->insert_id();

    return $this->db->query("INSERT INTO pago_comision_ind
   ([id_comision], [id_usuario], [abono_neodata], [fecha_abono], [fecha_pago_intmex], [pago_neodata], [estatus], [modificado_por], [comentario]) VALUES (".$id.", ".$subdirectorSelect.", ".$abonadosubDir.",  GETDATE(), NULL, NULL, 11, ".$this->session->userdata('id_usuario').", 'IMPORTACI??N CONTRALORIA')");
 }


 function update_comisionesGer($ideLote, $gerenteSelect, $abonadoGerente, $totalGerente, $porcentajeGerente){

    $this->db->query("INSERT INTO comisiones
   ([id_lote], [id_usuario], [comision_total], [estatus], [observaciones], [evidencia], [factura], [creado_por], [fecha_creacion], [porcentaje_decimal], [fecha_autorizacion], [rol_generado]) VALUES (".$ideLote.", ".$gerenteSelect.", ".$totalGerente.", 1, 'IMPORTACION', NULL, NULL, ".$this->session->userdata('id_usuario').", GETDATE(), ".$porcentajeGerente.", GETDATE(), 3)");

    $id = $this->db->insert_id();

    return $this->db->query("INSERT INTO pago_comision_ind
   ([id_comision], [id_usuario], [abono_neodata], [fecha_abono], [fecha_pago_intmex], [pago_neodata], [estatus], [modificado_por], [comentario]) VALUES (".$id.", ".$gerenteSelect.", ".$abonadoGerente.",  GETDATE(), NULL, NULL, 11, ".$this->session->userdata('id_usuario').", 'IMPORTACI??N CONTRALORIA')");
 }


 function update_comisionesCoord($ideLote, $coordinadorSelect, $abonadoCoordinador, $totalCoordinador, $porcentajeCoordinador){

    // if(coordinadorSelect==null || coordinadorSelect=='' || coordinadorSelect==0)

    $this->db->query("INSERT INTO comisiones
   ([id_lote], [id_usuario], [comision_total], [estatus], [observaciones], [evidencia], [factura], [creado_por], [fecha_creacion], [porcentaje_decimal], [fecha_autorizacion], [rol_generado]) VALUES (".$ideLote.", ".$coordinadorSelect.", ".$totalCoordinador.", 1, 'IMPORTACION', NULL, NULL, ".$this->session->userdata('id_usuario').", GETDATE(), ".$porcentajeCoordinador.", GETDATE(), 9)");

    $id = $this->db->insert_id();

    return $this->db->query("INSERT INTO pago_comision_ind
   ([id_comision], [id_usuario], [abono_neodata], [fecha_abono], [fecha_pago_intmex], [pago_neodata], [estatus], [modificado_por], [comentario]) VALUES (".$id.", ".$coordinadorSelect.", ".$abonadoCoordinador.",  GETDATE(), NULL, NULL, 11, ".$this->session->userdata('id_usuario').", 'IMPORTACI??N CONTRALORIA')");
 }


  function update_comisionesAse($ideLote, $asesorSelect, $abonadoAsesor, $totalAsesor, $porcentajeAsesor){


    $this->db->query("INSERT INTO comisiones
   ([id_lote], [id_usuario], [comision_total], [estatus], [observaciones], [evidencia], [factura], [creado_por], [fecha_creacion], [porcentaje_decimal], [fecha_autorizacion], [rol_generado]) VALUES (".$ideLote.", ".$asesorSelect.", ".$totalAsesor.", 1, 'IMPORTACION', NULL, NULL, ".$this->session->userdata('id_usuario').", GETDATE(), ".$porcentajeAsesor.", GETDATE(), 7)");

    $id = $this->db->insert_id();

   return  $this->db->query("INSERT INTO pago_comision_ind
   ([id_comision], [id_usuario], [abono_neodata], [fecha_abono], [fecha_pago_intmex], [pago_neodata], [estatus], [modificado_por], [comentario]) VALUES (".$id.", ".$asesorSelect.", ".$abonadoAsesor.",  GETDATE(), NULL, NULL, 11, ".$this->session->userdata('id_usuario').", 'IMPORTACI??N CONTRALORIA')");
 }


  function update_comisioneMKTD($ideLote, $MKTDSelect, $abonadoMKTD, $totalMKTD, $porcentajeMKTD){


    $this->db->query("INSERT INTO comisiones
   ([id_lote], [id_usuario], [comision_total], [estatus], [observaciones], [evidencia], [factura], [creado_por], [fecha_creacion], [porcentaje_decimal], [fecha_autorizacion], [rol_generado]) VALUES (".$ideLote.", ".$MKTDSelect.", ".$totalMKTD.", 1, 'IMPORTACION', NULL, NULL, ".$this->session->userdata('id_usuario').", GETDATE(), ".$porcentajeMKTD.", GETDATE(), 38)");

    $id = $this->db->insert_id();

   return  $this->db->query("INSERT INTO pago_comision_ind
   ([id_comision], [id_usuario], [abono_neodata], [fecha_abono], [fecha_pago_intmex], [pago_neodata], [estatus], [modificado_por], [comentario]) VALUES (".$id.", ".$MKTDSelect.", ".$abonadoMKTD.",  GETDATE(), NULL, NULL, 11, ".$this->session->userdata('id_usuario').", 'IMPORTACI??N CONTRALORIA')");
 }

 function update_comisionesSUBCLUB($ideLote, $SubClubSelect, $abonadoSubClub, $totalSubClub, $porcentajeSubClub){


    $this->db->query("INSERT INTO comisiones
   ([id_lote], [id_usuario], [comision_total], [estatus], [observaciones], [evidencia], [factura], [creado_por], [fecha_creacion], [porcentaje_decimal], [fecha_autorizacion], [rol_generado]) VALUES (".$ideLote.", ".$SubClubSelect.", ".$totalSubClub.", 1, 'IMPORTACION', NULL, NULL, ".$this->session->userdata('id_usuario').", GETDATE(), ".$porcentajeSubClub.", GETDATE(), 42)");

    $id = $this->db->insert_id();

   return  $this->db->query("INSERT INTO pago_comision_ind
   ([id_comision], [id_usuario], [abono_neodata], [fecha_abono], [fecha_pago_intmex], [pago_neodata], [estatus], [modificado_por], [comentario]) VALUES (".$id.", ".$SubClubSelect.", ".$abonadoSubClub.",  GETDATE(), NULL, NULL, 11, ".$this->session->userdata('id_usuario').", 'IMPORTACI??N CONTRALORIA')");
 }

 function update_comisionesEJECTCLUB($ideLote, $EjectClubSelect, $abonadoEjectClub, $totalEjectClub, $porcentajeEjectClub){


    $this->db->query("INSERT INTO comisiones
   ([id_lote], [id_usuario], [comision_total], [estatus], [observaciones], [evidencia], [factura], [creado_por], [fecha_creacion], [porcentaje_decimal], [fecha_autorizacion], [rol_generado]) VALUES (".$ideLote.", ".$EjectClubSelect.", ".$totalEjectClub.", 1, 'IMPORTACION', NULL, NULL, ".$this->session->userdata('id_usuario').", GETDATE(), ".$porcentajeEjectClub.", GETDATE() ,42)");

    $id = $this->db->insert_id();

   return  $this->db->query("INSERT INTO pago_comision_ind
   ([id_comision], [id_usuario], [abono_neodata], [fecha_abono], [fecha_pago_intmex], [pago_neodata], [estatus], [modificado_por], [comentario]) VALUES (".$id.", ".$EjectClubSelect.", ".$abonadoEjectClub.",  GETDATE(), NULL, NULL, 11, ".$this->session->userdata('id_usuario').", 'IMPORTACI??N CONTRALORIA')");
 }





 function update_comisionesGreenham($ideLote, $GreenSelect, $abonadoGreenham, $totalGreenham, $porcentajeGreenham){


    $this->db->query("INSERT INTO comisiones
   ([id_lote], [id_usuario], [comision_total], [estatus], [observaciones], [evidencia], [factura], [creado_por], [fecha_creacion], [porcentaje_decimal], [fecha_autorizacion], [rol_generado]) VALUES (".$ideLote.", ".$GreenSelect.", ".$totalGreenham.", 1, 'IMPORTACION', NULL, NULL, ".$this->session->userdata('id_usuario').", GETDATE(), ".$porcentajeGreenham.", GETDATE(), 7)");

    $id = $this->db->insert_id();

   return  $this->db->query("INSERT INTO pago_comision_ind
   ([id_comision], [id_usuario], [abono_neodata], [fecha_abono], [fecha_pago_intmex], [pago_neodata], [estatus], [modificado_por], [comentario]) VALUES (".$id.", ".$GreenSelect.", ".$abonadoGreenham.",  GETDATE(), NULL, NULL, 11, ".$this->session->userdata('id_usuario').", 'IMPORTACI??N CONTRALORIA')");
 }



 function getComments($pago){
//     return $this->db->query("SELECT DISTINCT(hc.comentario), hc.id_pago_i, hc.id_usuario, hc.fecha_movimiento,
// CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre_usuario
// FROM historial_comisiones hc 
// INNER JOIN pago_comision_ind pci ON pci.id_pago_i = hc.id_pago_i
// INNER JOIN usuarios u ON u.id_usuario = hc.id_usuario 
// WHERE hc.id_pago_i = $pago  
// ORDER BY hc.fecha_movimiento DESC");
$this->db->query("SET LANGUAGE Espa??ol;");
return $this->db->query("SELECT DISTINCT(hc.comentario), hc.id_pago_i, hc.id_usuario, 
convert(nvarchar(20),  hc.fecha_movimiento, 113) date_final,
hc.fecha_movimiento,
CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre_usuario
FROM historial_comisiones hc 
INNER JOIN pago_comision_ind pci ON pci.id_pago_i = hc.id_pago_i
INNER JOIN usuarios u ON u.id_usuario = hc.id_usuario 
WHERE hc.id_pago_i = $pago
ORDER BY hc.fecha_movimiento DESC");


}

 function getCommentsDU($user){
//     return $this->db->query("SELECT DISTINCT(hc.comentario), hc.id_pago_i, hc.id_usuario, hc.fecha_movimiento,
// CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre_usuario
// FROM historial_comisiones hc 
// INNER JOIN pago_comision_ind pci ON pci.id_pago_i = hc.id_pago_i
// INNER JOIN usuarios u ON u.id_usuario = hc.id_usuario 
// WHERE hc.id_pago_i = $pago  
// ORDER BY hc.fecha_movimiento DESC");
$this->db->query("SET LANGUAGE Espa??ol;");
return $this->db->query("SELECT  pci.abono_neodata comentario, pci.id_pago_i, pci.modificado_por, 
convert(nvarchar(20),  pci.fecha_abono, 113) date_final,
pci.fecha_abono,
CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre_usuario
FROM pago_comision_ind pci  
INNER JOIN usuarios u ON u.id_usuario = pci.modificado_por 
WHERE pci.estatus = 17 AND pci.id_usuario = $user
ORDER BY pci.fecha_abono DESC");


}






 function getDataMarketing($a, $b){
    return $this->db->query("SELECT ck.comentario, ck.fecha_creacion, ck.enganche, ck.fecha_prospecion_mktd,  CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) as nombre
        FROM cobranza_mktd ck
        INNER JOIN usuarios u ON u.id_usuario = ck.creado_por
        WHERE ck.id_lote = $a AND ck.id_cliente = $b");
}


///////////////////////////////  C  O  N  T  R  A  L  O  R  I  A ////////////////////////// 


function update_acepta_contraloria($idsol) {
    return $this->db->query("UPDATE pago_comision_ind SET estatus = 8 WHERE id_pago_i IN (".$idsol.")");
}

function update_mktd_contraloria($idsol) {
    return $this->db->query("UPDATE pago_comision_mktd SET estatus = 8 WHERE estatus = 1");
}

 

function update_acepta_INTMEX($idsol) {
    return $this->db->query("UPDATE pago_comision_ind SET estatus = 11, aply_pago_intmex = GETDATE() WHERE id_pago_i IN (".$idsol.")");
}

function update_mktd_INTMEX($idsol) {
    return $this->db->query("UPDATE pago_comision_mktd SET estatus = 11 WHERE estatus = 8");
}
 

function getDatosResguardoContraloria($usuario,$proyecto){

    //  if( $this->session->userdata('id_rol') == 31 ){
    //         $filtro = " pci1.estatus IN (3) AND pci1.id_usuario = $usuario ";
    //       }
    //       else{
    //         $filtro = " pci1.estatus IN (3) AND pci1.id_usuario = $usuario ";
    //       }
    
    
          if($proyecto == 0){
            $filtro_00 = ' ';
        }
            else{
                $filtro_00 = ' AND re.idResidencial = '.$proyecto.' ';
            }
            
            
     
    
        switch ($this->session->userdata('id_rol')) {
    
    
            case 1:
            case 2:
            case 3:
    
            $filtro_02 = ' pci1.estatus IN (3) AND com.id_usuario = '.$this->session->userdata('id_usuario').' '.$filtro_00;
            break;
    
           
            default:
            $filtro_02 = ' pci1.estatus IN (3) AND pci1.id_usuario = '.$usuario.' '.$filtro_00;
             break;
            }
            
            
            return $this->db->query("(SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto,  lo.totalNeto2 precio_lote,  com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata,pci1.estatus, pci1.fecha_pago_intmex fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario ,pci1.id_usuario, oprol.nombre as puesto, 0, u.forma_pago, 0 as factura, pac.porcentaje_abono, oxcest.nombre as estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, 0 lugar_prospeccion, co.nombre as condominio, lo.referencia, pci1.abono_neodata impuesto, 0 valimpuesto, 0 dcto
                     FROM pago_comision_ind pci1 
                     LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE estatus in (11) 
                     GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
                     INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                     INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
                     INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                     INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                     INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
                     INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
                     INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                     INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23
                     LEFT JOIN facturas f ON f.id_comision = com.id_comision
                     WHERE $filtro_02 and ( (lo.idStatusContratacion < 9 AND com.estatus IN (1,8)) OR (lo.idStatusContratacion > 8 AND com.estatus IN (8)))
                     GROUP BY pci1.id_comision, pci1.id_pago_i, lo.nombreLote, re.nombreResidencial, lo.totalNeto2, com.comision_total,
                     com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex, u.nombre, u.apellido_paterno, u.apellido_materno, pci1.id_usuario, oprol.nombre,  u.forma_pago, pac.porcentaje_abono, oxcest.nombre, oxcest.id_opcion, re.empresa, co.nombre, lo.referencia, pci1.abono_neodata)
         UNION 
     
         (SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto,  lo.totalNeto2 precio_lote, 
         com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno,
         ' ', u.apellido_materno) usuario ,pci1.id_usuario, oprol.nombre as puesto, cl.personalidad_juridica, u.forma_pago, 0 as factura, 
         pac.porcentaje_abono, oxcest.nombre as estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, cl.lugar_prospeccion, 
         co.nombre as condominio, lo.referencia, pci1.abono_neodata impuesto, 0 valimpuesto, 0 dcto
         FROM pago_comision_ind pci1 
             LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE estatus in (11) 
             GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
             INNER JOIN comisiones com ON pci1.id_comision = com.id_comision AND com.estatus in (1)
             INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
             INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
             INNER JOIN residenciales re ON re.idResidencial = co.idResidencial 
             INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 1
             INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
             INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
             INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
             INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23
             LEFT JOIN facturas f ON f.id_comision = com.id_comision
             
             WHERE $filtro_02 and lo.idStatusContratacion > 8 
             GROUP BY pci1.id_pago_i, pci1.id_comision, lo.nombreLote, re.nombreResidencial,  lo.totalNeto2, 
         com.comision_total, com.porcentaje_decimal, pci1.abono_neodata , pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex , u.nombre, u.apellido_paterno,
         u.apellido_materno,pci1.id_usuario, oprol.nombre , cl.personalidad_juridica, u.forma_pago, 
         pac.porcentaje_abono, oxcest.nombre , oxcest.id_opcion, re.empresa, cl.lugar_prospeccion, 
         co.nombre, lo.referencia, pci1.abono_neodata) ORDER BY lo.nombreLote");
             
        
            
    }

function getDatosRevisionFactura($proyecto,$condominio){

    if($condominio == 0){
        return $this->db->query("SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto,  lo.totalNeto2 precio_lote,
        com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado,
        com.comision_total-pci2.abono_pagado restante, oxc.nombre as lugar_prosp, pci1.estatus, pci1.fecha_abono fecha_creacion, pci1.id_usuario, 
        u.forma_pago, f.id_comision as factura, pac.porcentaje_abono, CONCAT(u.nombre, ' ',
        u.apellido_paterno, ' ', u.apellido_materno) as usuario, oxcrol.nombre AS puesto, re.empresa
                   FROM pago_comision_ind pci1 
                   LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE estatus in (11) 
                   GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
                   INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                   INNER JOIN lotes lo ON lo.idLote = com.id_lote
                   INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                   INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                   INNER JOIN clientes cl ON cl.idLote = lo.idLote
                   INNER JOIN porcentajes_comisiones pc ON pc.relacion_prospeccion = cl.lugar_prospeccion
                   INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = pc.medio_comision
                   INNER JOIN usuarios u ON u.id_usuario = pci1.id_usuario
                   INNER JOIN opcs_x_cats oxcpj ON oxcpj.id_opcion = u.forma_pago
                   INNER JOIN opcs_x_cats oxcrol ON oxcrol.id_opcion = u.id_rol
                   INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                   LEFT JOIN facturas f ON f.id_comision = com.id_comision
                   WHERE cl.status = 1 AND re.idResidencial = $proyecto AND pci1.estatus = 4 AND com.estatus in (1,8) AND u.forma_pago in (2)
                   AND oxcpj.id_catalogo = 16 AND oxc.id_catalogo = 30   AND oxcrol.id_catalogo = 1
                   GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial,  lo.totalNeto2, com.comision_total, com.porcentaje_decimal, 
                   pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, oxc.nombre, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, 
                   oxcpj.nombre, cl.personalidad_juridica, u.forma_pago, f.id_comision, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, 
                   u.apellido_paterno, u.apellido_materno, oxcrol.nombre, re.empresa");
    }else{
        return $this->db->query("SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto,  lo.totalNeto2 precio_lote,
        com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado,
        com.comision_total-pci2.abono_pagado restante, oxc.nombre as lugar_prosp, pci1.estatus, pci1.fecha_abono fecha_creacion, pci1.id_usuario, 
        u.forma_pago, f.id_comision as factura, pac.porcentaje_abono, CONCAT(u.nombre, ' ',
        u.apellido_paterno, ' ', u.apellido_materno) as usuario, oxcrol.nombre AS puesto, re.empresa
                   FROM pago_comision_ind pci1 
                   LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE estatus in (11) 
                   GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
                   INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                   INNER JOIN lotes lo ON lo.idLote = com.id_lote
                   INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                   INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                   INNER JOIN clientes cl ON cl.idLote = lo.idLote
                   INNER JOIN porcentajes_comisiones pc ON pc.relacion_prospeccion = cl.lugar_prospeccion
                   INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = pc.medio_comision
                   INNER JOIN usuarios u ON u.id_usuario = pci1.id_usuario
                   INNER JOIN opcs_x_cats oxcpj ON oxcpj.id_opcion = u.forma_pago
                   INNER JOIN opcs_x_cats oxcrol ON oxcrol.id_opcion = u.id_rol
                   INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                   LEFT JOIN facturas f ON f.id_comision = com.id_comision
                   WHERE cl.status = 1 AND co.idCondominio = $condominio AND pci1.estatus = 4 AND com.estatus in (1,8) AND u.forma_pago in (2)
                   AND oxcpj.id_catalogo = 16 AND oxc.id_catalogo = 30   AND oxcrol.id_catalogo = 1
                   GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial,  lo.totalNeto2, com.comision_total, com.porcentaje_decimal, 
                   pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, oxc.nombre, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, 
                   oxcpj.nombre, cl.personalidad_juridica, u.forma_pago, f.id_comision, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, 
                   u.apellido_paterno, u.apellido_materno, oxcrol.nombre, re.empresa");
    }
   
        }
    
    
    
    
     function getDatosRevisionAsimilados($proyecto,$condominio){
     if($condominio == 0){
        return $this->db->query("SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto,  lo.totalNeto2 precio_lote,
        com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado,
        com.comision_total-pci2.abono_pagado restante, oxc.nombre as lugar_prosp, pci1.estatus, pci1.fecha_abono fecha_creacion, pci1.id_usuario, 
        u.forma_pago, f.id_comision as factura, pac.porcentaje_abono, CONCAT(u.nombre, ' ',
        u.apellido_paterno, ' ', u.apellido_materno) as usuario, oxcrol.nombre AS puesto, re.empresa
                   FROM pago_comision_ind pci1 
                   LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE estatus in (11) 
                   GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
                   INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                   INNER JOIN lotes lo ON lo.idLote = com.id_lote
                   INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                   INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                   INNER JOIN clientes cl ON cl.idLote = lo.idLote
                   INNER JOIN porcentajes_comisiones pc ON pc.relacion_prospeccion = cl.lugar_prospeccion
                   INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = pc.medio_comision
                   INNER JOIN usuarios u ON u.id_usuario = pci1.id_usuario
                   INNER JOIN opcs_x_cats oxcpj ON oxcpj.id_opcion = u.forma_pago
                   INNER JOIN opcs_x_cats oxcrol ON oxcrol.id_opcion = u.id_rol
                   INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                   LEFT JOIN facturas f ON f.id_comision = com.id_comision
                   WHERE cl.status = 1 AND re.idResidencial = $proyecto AND pci1.estatus = 4 AND com.estatus in (1,8) AND u.forma_pago in (3)
                   AND oxcpj.id_catalogo = 16 AND oxc.id_catalogo = 30   AND oxcrol.id_catalogo = 1
                   GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial,  lo.totalNeto2, com.comision_total, com.porcentaje_decimal, 
                   pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, oxc.nombre, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, 
                   oxcpj.nombre, cl.personalidad_juridica, u.forma_pago, f.id_comision, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, 
                   u.apellido_paterno, u.apellido_materno, oxcrol.nombre, re.empresa");
    }else{
        return $this->db->query("SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto,  lo.totalNeto2 precio_lote,
        com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado,
        com.comision_total-pci2.abono_pagado restante, oxc.nombre as lugar_prosp, pci1.estatus, pci1.fecha_abono fecha_creacion, pci1.id_usuario, 
        u.forma_pago, f.id_comision as factura, pac.porcentaje_abono, CONCAT(u.nombre, ' ',
        u.apellido_paterno, ' ', u.apellido_materno) as usuario, oxcrol.nombre AS puesto, re.empresa
                   FROM pago_comision_ind pci1 
                   LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE estatus in (11) 
                   GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
                   INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                   INNER JOIN lotes lo ON lo.idLote = com.id_lote
                   INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                   INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                   INNER JOIN clientes cl ON cl.idLote = lo.idLote
                   INNER JOIN porcentajes_comisiones pc ON pc.relacion_prospeccion = cl.lugar_prospeccion
                   INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = pc.medio_comision
                   INNER JOIN usuarios u ON u.id_usuario = pci1.id_usuario
                   INNER JOIN opcs_x_cats oxcpj ON oxcpj.id_opcion = u.forma_pago
                   INNER JOIN opcs_x_cats oxcrol ON oxcrol.id_opcion = u.id_rol
                   INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                   LEFT JOIN facturas f ON f.id_comision = com.id_comision
                   WHERE cl.status = 1 AND co.idCondominio = $condominio AND pci1.estatus = 4 AND com.estatus in (1,8) AND u.forma_pago in (3)
                   AND oxcpj.id_catalogo = 16 AND oxc.id_catalogo = 30   AND oxcrol.id_catalogo = 1
                   GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial,  lo.totalNeto2, com.comision_total, com.porcentaje_decimal, 
                   pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, oxc.nombre, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, 
                   oxcpj.nombre, cl.personalidad_juridica, u.forma_pago, f.id_comision, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, 
                   u.apellido_paterno, u.apellido_materno, oxcrol.nombre, re.empresa");    
    }
    
        }




 function getDatosEnviadasInternomex($proyecto,$condominio){

      $user_data = $this->session->userdata('id_usuario');

         if($condominio == 0){
                return $this->db->query("SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, /*pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, */pci1.estatus, pci1.fecha_pago_intmex fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario ,pci1.id_usuario, oprol.nombre as puesto, cl.personalidad_juridica, u.forma_pago, 0 as factura, pac.porcentaje_abono, oxcest.nombre as estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, cl.lugar_prospeccion, co.nombre as condominio, lo.referencia, (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, (CASE u.forma_pago WHEN 3 THEN (((sed.impuesto)/100)*pci1.abono_neodata) ELSE 0 END) dcto, sed.impuesto valimpuesto, oxcfp.nombre as regimen
                 FROM pago_comision_ind pci1 
                /* LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE estatus in (11) 
                 GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision*/
                 INNER JOIN comisiones com ON pci1.id_comision = com.id_comision AND com.estatus in (1,8)
                 INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
                 INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                 INNER JOIN residenciales re ON re.idResidencial = co.idResidencial AND re.idResidencial = $proyecto 
                 INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 1
                 INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (2, 3, 4)
                 INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
                 INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                 INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
                 INNER JOIN opcs_x_cats oxcfp ON oxcfp.id_opcion = u.forma_pago AND oxcfp.id_catalogo = 16
                 INNER JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario 
                 WHEN 2 THEN 2 
                 WHEN 3 THEN 2 
                 WHEN 1980 THEN 2 
                 WHEN 1981 THEN 2 
                 WHEN 1982 THEN 2 
                 WHEN 1988 THEN 2 
                 WHEN 4 THEN 5
                 WHEN 5 THEN 3
                 WHEN 607 THEN 1 
                 ELSE u.id_sede END) and sed.estatus = 1
                 WHERE pci1.estatus IN (8,88) 
                 GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial,  lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata,  pci1.pago_neodata, /*pci2.abono_pagado, */pci1.estatus, pci1.fecha_pago_intmex, pci1.id_usuario, cl.personalidad_juridica, u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, cl.lugar_prospeccion, co.nombre, lo.referencia, sed.impuesto, oxcfp.nombre ORDER BY lo.nombreLote");
    
            }else{

              return $this->db->query("SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto,  lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, /*pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, */pci1.estatus, pci1.fecha_pago_intmex fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario ,pci1.id_usuario, oprol.nombre as puesto, cl.personalidad_juridica, u.forma_pago, 0 as factura, pac.porcentaje_abono, oxcest.nombre as estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, cl.lugar_prospeccion, co.nombre as condominio, lo.referencia,(CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, (CASE u.forma_pago WHEN 3 THEN (((sed.impuesto)/100)*pci1.abono_neodata) ELSE 0 END) dcto, sed.impuesto valimpuesto, oxcfp.nombre as regimen
                 FROM pago_comision_ind pci1 
                 /*LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE estatus in (11) GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision*/
                 INNER JOIN comisiones com ON pci1.id_comision = com.id_comision AND com.estatus in (1,8)
                 INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
                 INNER JOIN condominios co ON co.idCondominio = lo.idCondominio AND co.idCondominio = $condominio
                 INNER JOIN residenciales re ON re.idResidencial = co.idResidencial 
                 INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 1
                 INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (2, 3, 4)
                 INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
                 INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                 INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
                 INNER JOIN opcs_x_cats oxcfp ON oxcfp.id_opcion = u.forma_pago AND oxcfp.id_catalogo = 16
                 INNER JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario 
                 WHEN 2 THEN 2 
                 WHEN 3 THEN 2 
                 WHEN 1980 THEN 2 
                 WHEN 1981 THEN 2 
                 WHEN 1982 THEN 2 
                 WHEN 1988 THEN 2 
                 WHEN 4 THEN 5
                 WHEN 5 THEN 3
                 WHEN 607 THEN 1 
                 ELSE u.id_sede END) and sed.estatus = 1
                 WHERE pci1.estatus IN (8,88) 
                 GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial,  lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata,  pci1.pago_neodata, /*pci2.abono_pagado, */pci1.estatus, pci1.fecha_pago_intmex, pci1.id_usuario, cl.personalidad_juridica, u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, cl.lugar_prospeccion, co.nombre, lo.referencia, sed.impuesto, oxcfp.nombre ORDER BY lo.nombreLote");

           
            }
        }

  

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77


  function update_estatus_facturas($user, $proyecto) {

    $id_user_Vl = $this->session->userdata('id_usuario');
    $this->db->query("INSERT INTO  historial_comisiones VALUES ($idcom, $id_user_Vl, GETDATE(), 1, 'SE ACTIV?? NUEVAMENTE COMISI??N')");

    $this->db->query("UPDATE pago_comision_ind set estatus = 8 FROM pago_comision_ind pci
    INNER JOIN comisiones com ON com.id_comision = pci.id_comision
    INNER JOIN lotes lo ON lo.idLote = com.id_lote
    INNER JOIN condominios cod ON cod.idCondominio = lo.idCondominio
    INNER JOIN residenciales res ON res.idResidencial = cod.idResidencial
    WHERE pci.estatus IN (4) AND pci.id_usuario = $user AND res.idResidencial = $proyecto)");
  }




   function update_estatus_pausa($id_pago_i, $obs, $estatus) {
    $id_user_Vl = $this->session->userdata('id_usuario');
    $this->db->query("INSERT INTO  historial_comisiones VALUES ($id_pago_i, ".$id_user_Vl.", GETDATE(), 1, 'SE PAUS?? COMISI??N, MOTIVO: ".$obs."')");
    return $this->db->query("UPDATE pago_comision_ind SET estatus = ".$estatus.", comentario = '".$obs."' WHERE id_pago_i IN (".$id_pago_i.")");
  }



 function update_estatus_despausa($id_pago_i, $obs, $estatus) {
    $id_user_Vl = $this->session->userdata('id_usuario');
    $this->db->query("INSERT INTO  historial_comisiones VALUES ($id_pago_i, ".$id_user_Vl.", GETDATE(), 1, 'SE ACTIV?? COMISI??N, MOTIVO: ".$obs."')");
    return $this->db->query("UPDATE pago_comision_ind SET estatus = ".$estatus.", comentario = '".$obs."' WHERE id_pago_i IN (".$id_pago_i.")");
  }




  function update_estatus_refresh($idcom) {
    $id_user_Vl = $this->session->userdata('id_usuario');
    $this->db->query("INSERT INTO  historial_comisiones VALUES ($idcom, $id_user_Vl, GETDATE(), 1, 'SE ACTIV?? NUEVAMENTE COMISI??N')");
    return $this->db->query("UPDATE pago_comision_ind SET estatus = 4 WHERE id_pago_i IN (".$idcom.")");
} 
 

function porcentajes($idLote){

    $req = $this->db->query("SELECT distinct(l.idLote), cl.lugar_prospeccion FROM lotes l INNER JOIN clientes cl ON cl.id_cliente = l.idCliente WHERE l.idLote = $idLote AND l.status = 1 AND cl.status = 1")->row();
   

    switch($req->lugar_prospeccion){
        case '6'://MARKETING
        case 6://MARKETING
        return $this->db->query("SELECT l.idLote,l.totalNeto2, cl.fechaApartado, cl.lugar_prospeccion,
        ae.id_usuario as id_asesor, ae.id_rol as rolAs, pa.porcentaje as p1, pa.porcentaje_saldos as ps1, CONCAT(ae.nombre, ' ', ae.apellido_paterno, ' ',  ae.apellido_materno) as asesor,
        co.id_usuario as id_coordinador, co.id_rol as rolCoor, pc.porcentaje as p2, pc.porcentaje_saldos as ps2, CONCAT(co.nombre, ' ', co.apellido_paterno, ' ',  co.apellido_materno) as coordinador,
        ge.id_usuario as id_gerente, ge.id_rol as rolGe, pg.porcentaje as p3, (CASE  ge.id_usuario WHEN 832 THEN 25  ELSE pg.porcentaje_saldos  END) ps3, CONCAT(ge.nombre, ' ', ge.apellido_paterno, ' ',  ge.apellido_materno) as gerente,


        su.id_usuario as id_subdirector, su.id_rol as rolSub, ps.porcentaje as p4, ps.porcentaje_saldos as ps4, CONCAT(su.nombre, ' ', su.apellido_paterno, ' ',  su.apellido_materno) as subdirector,
        di.id_usuario as id_director, di.id_rol as rolDir, pd.porcentaje as p5, pd.porcentaje_saldos as ps5, CONCAT(di.nombre, ' ', di.apellido_paterno, ' ',  di.apellido_materno) as director, 
        mk.id_usuario as id_mk, mk.id_rol as rolmk, pmk.porcentaje as p6, pmk.porcentaje_saldos as ps6, CONCAT(mk.nombre, ' ', mk.apellido_paterno, ' ',  mk.apellido_materno) as marketing 
        FROM lotes l
                INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                INNER JOIN usuarios ae ON ae.id_usuario = cl.id_asesor
                INNER JOIN porcentajes_comisiones pa ON pa.id_rol = 7
                LEFT JOIN usuarios co ON co.id_usuario = cl.id_coordinador
                LEFT JOIN porcentajes_comisiones pc ON pc.id_rol = 9
                LEFT JOIN usuarios ge ON ge.id_usuario = cl.id_gerente
                LEFT JOIN porcentajes_comisiones pg ON pg.id_rol =3
                LEFT JOIN usuarios su ON su.id_usuario = ge.id_lider
                LEFT JOIN porcentajes_comisiones ps ON ps.id_rol = 2
                LEFT JOIN usuarios di ON di.id_usuario = su.id_lider
                LEFT JOIN porcentajes_comisiones pd ON pd.id_rol = 1
                LEFT JOIN usuarios mk ON mk.id_rol = 38
                LEFT JOIN porcentajes_comisiones pmk ON pmk.id_rol = 38
                WHERE l.idStatusContratacion BETWEEN 9 AND 15 
                AND pa.relacion_prospeccion = 6
                AND pc.relacion_prospeccion = 6
                AND pg.relacion_prospeccion = 6
                AND ps.relacion_prospeccion = 6
                AND pd.relacion_prospeccion = 6
                AND pmk.relacion_prospeccion = 6
                AND cl.lugar_prospeccion IN (6)
                AND l.idLote = $idLote");
            break;
        
        
        
        
        default:
        return $this->db->query("SELECT l.idLote,l.totalNeto2, cl.fechaApartado,cl.lugar_prospeccion,
        ae.id_usuario as id_asesor,ae.id_rol as rolAs, pa.porcentaje as p1, pa.porcentaje_saldos as ps1, CONCAT(ae.nombre, ' ', ae.apellido_paterno, ' ',  ae.apellido_materno) as asesor,
        co.id_usuario as id_coordinador,co.id_rol as rolCoor, pc.porcentaje as p2, pc.porcentaje_saldos as ps2, CONCAT(co.nombre, ' ', co.apellido_paterno, ' ',  co.apellido_materno) as coordinador,
        ge.id_usuario as id_gerente,ge.id_rol as rolGe, pg.porcentaje as p3, (CASE  ge.id_usuario WHEN 832 THEN 25  ELSE pg.porcentaje_saldos  END) ps3,  CONCAT(ge.nombre, ' ', ge.apellido_paterno, ' ',  ge.apellido_materno) as gerente,
        su.id_usuario as id_subdirector,su.id_rol as rolSub, ps.porcentaje as p4, ps.porcentaje_saldos as ps4, CONCAT(su.nombre, ' ', su.apellido_paterno, ' ',  su.apellido_materno) as subdirector,
        di.id_usuario as id_director,di.id_rol as rolDir, pd.porcentaje as p5, pd.porcentaje_saldos as ps5, CONCAT(di.nombre, ' ', di.apellido_paterno, ' ',  di.apellido_materno) as director 
        FROM lotes l
                INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                INNER JOIN usuarios ae ON ae.id_usuario = cl.id_asesor
                INNER JOIN porcentajes_comisiones pa ON pa.id_rol = 7
                LEFT JOIN usuarios co ON co.id_usuario = cl.id_coordinador
                LEFT JOIN porcentajes_comisiones pc ON pc.id_rol = 9
                LEFT JOIN usuarios ge ON ge.id_usuario = cl.id_gerente
                LEFT JOIN porcentajes_comisiones pg ON pg.id_rol =3
                LEFT JOIN usuarios su ON su.id_usuario = ge.id_lider
                LEFT JOIN porcentajes_comisiones ps ON ps.id_rol = 2
                LEFT JOIN usuarios di ON di.id_usuario = su.id_lider
                LEFT JOIN porcentajes_comisiones pd ON pd.id_rol = 1
                WHERE l.idStatusContratacion BETWEEN 9 AND 15 
                AND pa.relacion_prospeccion = 11
                AND pc.relacion_prospeccion = 11
                AND pg.relacion_prospeccion = 11
                AND ps.relacion_prospeccion = 11
                AND pd.relacion_prospeccion = 11
                AND cl.lugar_prospeccion NOT IN (6, 12)
                and l.idLote = $idLote");

        break;

    }
    
    }
    
    public function InsertNeo($idLote, $id_usuario, $TotComision,$user, $porcentaje,$abono,$pago,$rol){
    $this->db->query("INSERT INTO comisiones ([id_lote], [id_usuario], [comision_total], [estatus], [observaciones], [evidencia], [factura], [creado_por], [fecha_creacion], [porcentaje_decimal], [fecha_autorizacion], [rol_generado]) VALUES (".$idLote.", ".$id_usuario.", ".$TotComision.", 1, 'DISPERSION 1 - NEDOATA', NULL, NULL, ".$user.", GETDATE(), ".$porcentaje.", GETDATE(), ".$rol.")");
    $insert_id = $this->db->insert_id();
    
    $this->db->query("INSERT INTO pago_comision_ind (id_comision, id_usuario, abono_neodata, fecha_abono, fecha_pago_intmex, estatus, pago_neodata, comentario, modificado_por) VALUES (".$insert_id.", ".$id_usuario.", ".$abono.",  GETDATE(),  GETDATE(), 1 , ".$pago.", 'PAGO 1 - NEDOATA', $user)");
    
    $insert_id_2 = $this->db->insert_id();
    $this->db->query("INSERT INTO  historial_comisiones VALUES ($insert_id_2, ".$this->session->userdata('id_usuario').", GETDATE(), 1, 'DISPERS?? PAGO DE COMISI??N')");
        
    

}
 

     public function InsertPagoComision($lote,$sumaComi,$sumaDispo,$porcentaje,$resta,$id_user,$pagado,$bonificacion){

        $QUERY_VOBO =  $this->db->query("SELECT id_pagoc FROM pago_comision WHERE id_lote = ".$lote."");


        if( $QUERY_VOBO->num_rows() > 0 ){
            $respuesta =  $this->db->query("UPDATE pago_comision SET total_comision = ".$sumaComi.", abonado = ".$sumaDispo.", porcentaje_abono = ".$porcentaje.", pendiente = ".$resta.", creado_por = ".$id_user.", fecha_modificacion = GETDATE(), ultimo_pago = ".$pagado.", bonificacion = ".$bonificacion." WHERE id_lote = ".$lote."");
        }
        else{
            $respuesta =  $this->db->query("INSERT INTO pago_comision ([id_lote], [total_comision], [abonado], [porcentaje_abono], [pendiente], [creado_por], [fecha_modificacion], [fecha_abono],[bandera],[ultimo_pago],[bonificacion]) VALUES (".$lote.", ".$sumaComi.", ".$sumaDispo.",".$porcentaje.",".$resta.",".$id_user.", GETDATE(), GETDATE(),1,".$pagado.",".$bonificacion.")");

        }
    if (! $respuesta ) {
    return 0;
    } else {
    return 1;
    }



}

public function UpdateLoteLiquidar($lote){
    $respuesta =  $this->db->query("UPDATE pago_comision_ind SET estatus = 0 WHERE abono_neodata = 0");
    $respuesta =  $this->db->query("UPDATE comisiones SET estatus = 0 WHERE comision_total = 0");
    $respuesta =  $this->db->query("UPDATE pago_comision SET pendiente = 0 WHERE id_lote = $lote");
    $respuesta =  $this->db->query("UPDATE lotes SET registro_comision = 7 WHERE idLote = $lote");
    if (! $respuesta ) {
    return 0;
    } else {
    return 1;
    }
}

public function UpdateLoteDisponible($lote){
    $respuesta =  $this->db->query("UPDATE pago_comision SET bandera = 1 WHERE id_lote = $lote");
    $respuesta =  $this->db->query("UPDATE pago_comision_ind SET estatus = 0 WHERE abono_neodata = 0");
    $respuesta =  $this->db->query("UPDATE comisiones SET estatus = 0 WHERE comision_total = 0");
    $respuesta =  $this->db->query("UPDATE lotes SET registro_comision = 1 WHERE idLote = $lote");
    if (! $respuesta ) {
    return 0;
    } else {
    return 1;
    }
}



public function getDatosDispersarCompartidas($idlote){
    return $this->db->query("SELECT l.idLote, cl.id_cliente, l.referencia, r.idResidencial, l.nombreLote, c.nombre as nombreCondominio, r.nombreResidencial, cl.nombre, cl.apellido_paterno, cl.apellido_materno, l.totalNeto2,
               ae.id_usuario as id_asesor, CONCAT(ae.nombre, ' ', ae.apellido_paterno, ' ',  ae.apellido_paterno) as asesor,
               co.id_usuario as id_coordinador, CONCAT(co.nombre, ' ', co.apellido_paterno, ' ',  co.apellido_paterno) as coordinador,
               ge.id_usuario as id_gerente, CONCAT(ge.nombre, ' ', ge.apellido_paterno, ' ',  ge.apellido_paterno) as gerente,
               su.id_usuario as id_subdirector, CONCAT(su.nombre, ' ', su.apellido_paterno, ' ',  su.apellido_paterno) as subdirector,
                cl.fechaApartado
                FROM ventas_compartidas vc
                INNER JOIN clientes cl ON vc.id_cliente = cl.id_cliente
                INNER JOIN lotes l ON l.idLote = cl.idLote
                INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                INNER JOIN usuarios ae ON ae.id_usuario = vc.id_asesor
                LEFT JOIN usuarios co ON co.id_usuario = vc.id_coordinador
                INNER JOIN usuarios ge ON ge.id_usuario = vc.id_gerente
                INNER JOIN usuarios su ON su.id_usuario = ge.id_lider
                WHERE l.idLote = ".$idlote." AND vc.estatus = 1 AND cl.status = 1");

}




function insert_pago_individual($id_comision, $id_usuario, $abono_nuevo){
    $this->db->query("INSERT INTO pago_comision_ind (id_comision, id_usuario, abono_neodata, fecha_abono, fecha_pago_intmex, estatus, pago_neodata, modificado_por, comentario) VALUES (".$id_comision.", ".$id_usuario.", ".$abono_nuevo.",  GETDATE(),  GETDATE(), 11, 0, ".$this->session->userdata('id_usuario').", 'IMPORTACION NUEVO ABONO')");
}


function update_pago_general($suma, $ideLote){
    $this->db->query("UPDATE pago_comision SET abonado = (abonado + ".$suma."), pendiente = (total_comision-abonado-".$suma.") WHERE id_lote = ".$ideLote."");
}


function insert_dispersion_individual($id_comision, $id_usuario, $abono_nuevo, $pago){
    $respuesta = $this->db->query("INSERT INTO pago_comision_ind (id_comision, id_usuario, abono_neodata, fecha_abono, fecha_pago_intmex, estatus, pago_neodata, modificado_por, comentario) VALUES (".$id_comision.", ".$id_usuario.", ".$abono_nuevo.",  GETDATE(),  GETDATE(), 1, ".$pago.", ".$this->session->userdata('id_usuario').", 'NUEVO PAGO')");

    $insert_id_2 = $this->db->insert_id();
    $respuesta = $this->db->query("INSERT INTO  historial_comisiones VALUES ($insert_id_2, ".$this->session->userdata('id_usuario').", GETDATE(), 1, 'DISPERS?? PAGO DE COMISI??N')");


    if (! $respuesta ) {
        return 0;
        } else {
        return 1;
        }
}

function update_pago_dispersion($suma, $ideLote, $pago){
    $respuesta = $this->db->query("UPDATE pago_comision SET abonado = (abonado + ".$suma."), pendiente = (total_comision-abonado-".$suma."), bandera = 1, ultimo_pago = ".$pago." WHERE id_lote = ".$ideLote."");
    if (! $respuesta ) {
        return 0;
        } else {
        return 1;
        }
}


public function getSettledCommissions() {
    $query = $this->db-> query("SELECT DISTINCT(l.idLote), l.registro_comision, cl.id_cliente, l.nombreLote, l.idStatusContratacion, res.nombreResidencial, cond.nombre as nombreCondominio, l.tipo_venta, l.referencia, vc.id_cliente AS compartida, l.totalNeto, l.totalNeto2, l.plan_enganche, plane.nombre as enganche_tipo, cl.lugar_prospeccion,
    ae.id_usuario as id_asesor, CONCAT(ae.nombre, ' ', ae.apellido_paterno, ' ',  ae.apellido_paterno) as asesor,
    co.id_usuario as id_coordinador, CONCAT(co.nombre, ' ', co.apellido_paterno, ' ',  co.apellido_paterno) as coordinador,
    ge.id_usuario as id_gerente, CONCAT(ge.nombre, ' ', ge.apellido_paterno, ' ',  ge.apellido_paterno) as gerente,
    su.id_usuario as id_subdirector, CONCAT(su.nombre, ' ', su.apellido_paterno, ' ',  su.apellido_paterno) as subdirector,
    di.id_usuario as id_director, CONCAT(di.nombre, ' ', di.apellido_paterno, ' ',  di.apellido_paterno) as director
    FROM  lotes l
    INNER JOIN  clientes cl ON l.idLote=cl.idLote
    INNER JOIN  condominios cond ON l.idCondominio=cond.idCondominio
    INNER JOIN  residenciales res ON cond.idResidencial = res.idResidencial
    LEFT JOIN  opcs_x_cats plane ON plane.id_opcion= l.plan_enganche AND plane.id_catalogo = 39
    LEFT JOIN  ventas_compartidas vc ON vc.id_cliente = cl.id_cliente
    INNER JOIN  usuarios ae ON ae.id_usuario = cl.id_asesor
    LEFT JOIN  usuarios co ON co.id_usuario = ae.id_lider
    LEFT JOIN  usuarios ge ON ge.id_usuario = cl.id_gerente
    LEFT JOIN  usuarios su ON su.id_usuario = ge.id_lider
    LEFT JOIN  usuarios di ON di.id_usuario = su.id_lider
    WHERE l.idStatusContratacion BETWEEN 9 AND 15 AND cl.status = 1 AND l.status = 1 AND l.registro_comision in (7) AND tipo_venta IS NOT NULL AND tipo_venta IN (1, 2)
    ORDER BY l.idLote");
    return $query->result();
}
 
public function validateSettledCommissions($idlote){
    return $this->db->query("SELECT * FROM comisiones WHERE id_lote = $idlote");
}
public function validateDispersionCommissions($idlote){
    return $this->db->query("SELECT bandera FROM pago_comision WHERE id_lote = $idlote");
}


 

 
    function porcentajes2($idLote){

        $req = $this->db->query("SELECT distinct(l.idLote), cl.lugar_prospeccion FROM lotes l INNER JOIN clientes cl ON cl.id_cliente = l.idCliente WHERE l.idLote = $idLote AND l.status = 1 AND cl.status = 1")->row();
       
    
        switch($req->lugar_prospeccion){
            case '6'://MARKETING
            case 6://MARKETING
                return $this->db->query("SELECT l.idLote,l.totalNeto2, cl.fechaApartado, cl.lugar_prospeccion,
                ae.id_usuario as id_asesor,ae.id_rol as rolAs, pa.porcentaje as p1, pa.porcentaje_saldos as ps1, CONCAT(ae.nombre, ' ', ae.apellido_paterno, ' ',  ae.apellido_materno) as asesor,
                co.id_usuario as id_coordinador,co.id_rol as rolCoor, pc.porcentaje as p2, pc.porcentaje_saldos as ps2, CONCAT(co.nombre, ' ', co.apellido_paterno, ' ',  co.apellido_materno) as coordinador,
                ge.id_usuario as id_gerente,ge.id_rol as rolGe, pg.porcentaje as p3, (CASE  ge.id_usuario WHEN 832 THEN 25  ELSE pg.porcentaje_saldos  END) ps3, CONCAT(ge.nombre, ' ', ge.apellido_paterno, ' ',  ge.apellido_materno) as gerente,
                su.id_usuario as id_subdirector,su.id_rol as rolSub, ps.porcentaje as p4, ps.porcentaje_saldos as ps4, CONCAT(su.nombre, ' ', su.apellido_paterno, ' ',  su.apellido_materno) as subdirector,
                di.id_usuario as id_director,di.id_rol as rolDir, pd.porcentaje as p5, pd.porcentaje_saldos as ps5, CONCAT(di.nombre, ' ', di.apellido_paterno, ' ',  di.apellido_materno) as director
                ,v.id_asesor as idasesor2,CONCAT(vcu.nombre, ' ', vcu.apellido_paterno, ' ',  vcu.apellido_materno) as asesor2
                ,v.id_coordinador as idcoordinador2, CONCAT(vcucoo.nombre, ' ', vcucoo.apellido_paterno, ' ',  vcucoo.apellido_materno) as coor2
                ,v.id_gerente as idgerente2, CONCAT(vcug.nombre, ' ', vcug.apellido_paterno, ' ',  vcug.apellido_materno) as gerente2
                ,lider.id_usuario as idsubdirector2, CONCAT(lider.nombre, ' ', lider.apellido_paterno, ' ',  lider.apellido_materno) as subdirector2,

                        mk2.id_usuario as id_mk2, mk2.id_rol as rolmk2, pmk2.porcentaje as p62, pmk2.porcentaje_saldos as ps62, 
                        CONCAT(mk2.nombre, ' ', mk2.apellido_paterno, ' ',  mk2.apellido_materno) as marketing2 

                FROM lotes l
                INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                INNER JOIN ventas_compartidas v ON v.id_cliente=l.idCliente
                INNER JOIN usuarios vcu ON v.id_asesor=vcu.id_usuario
                LEFT JOIN usuarios vcucoo ON v.id_coordinador=vcucoo.id_usuario
                INNER JOIN usuarios vcug ON v.id_gerente=vcug.id_usuario
                INNER JOIN usuarios lider ON vcug.id_lider=lider.id_usuario
                INNER JOIN usuarios ae ON ae.id_usuario = cl.id_asesor
                INNER JOIN porcentajes_comisiones pa ON pa.id_rol = 7
                LEFT JOIN usuarios co ON co.id_usuario = cl.id_coordinador
                LEFT JOIN porcentajes_comisiones pc ON pc.id_rol = 9
                LEFT JOIN usuarios ge ON ge.id_usuario = cl.id_gerente
                LEFT JOIN porcentajes_comisiones pg ON pg.id_rol =3
                LEFT JOIN usuarios su ON su.id_usuario = ge.id_lider
                LEFT JOIN porcentajes_comisiones ps ON ps.id_rol = 2
                LEFT JOIN usuarios di ON di.id_usuario = su.id_lider
                LEFT JOIN porcentajes_comisiones pd ON pd.id_rol = 1

                LEFT JOIN usuarios mk2 ON mk2.id_rol = 38
                LEFT JOIN porcentajes_comisiones pmk2 ON pmk2.id_rol = 38

                WHERE l.idStatusContratacion BETWEEN 9 AND 15 
              AND pa.relacion_prospeccion = 6
              AND pc.relacion_prospeccion = 6
              AND pg.relacion_prospeccion = 6
              AND ps.relacion_prospeccion = 6
              AND pd.relacion_prospeccion = 6
              AND l.status = 1 AND cl.status = 1
              AND l.tipo_venta IN(1,2)
              AND v.estatus = 1
              AND l.idLote = $idLote");
                break;
            
            case '12'://club
            case 12://club

                // echo "entra a 12";
                return $this->db->query("SELECT l.idLote,l.totalNeto2, cl.fechaApartado, cl.lugar_prospeccion,
                ae.id_usuario as id_asesor,ae.id_rol as rolAs, pa.porcentaje as p1, pa.porcentaje_saldos as ps1, CONCAT(ae.nombre, ' ', ae.apellido_paterno, ' ',  ae.apellido_materno) as asesor,
                co.id_usuario as id_coordinador,co.id_rol as rolCoor, pc.porcentaje as p2, pc.porcentaje_saldos as ps2, CONCAT(co.nombre, ' ', co.apellido_paterno, ' ',  co.apellido_materno) as coordinador,
                ge.id_usuario as id_gerente,ge.id_rol as rolGe, pg.porcentaje as p3, (CASE  ge.id_usuario WHEN 832 THEN 25  ELSE pg.porcentaje_saldos  END) ps3,  CONCAT(ge.nombre, ' ', ge.apellido_paterno, ' ',  ge.apellido_materno) as gerente,
                su.id_usuario as id_subdirector,su.id_rol as rolSub, ps.porcentaje as p4, ps.porcentaje_saldos as ps4, CONCAT(su.nombre, ' ', su.apellido_paterno, ' ',  su.apellido_materno) as subdirector,
                di.id_usuario as id_director,di.id_rol as rolDir, pd.porcentaje as p5, pd.porcentaje_saldos as ps5, CONCAT(di.nombre, ' ', di.apellido_paterno, ' ',  di.apellido_materno) as director
                ,v.id_asesor as idasesor2,CONCAT(vcu.nombre, ' ', vcu.apellido_paterno, ' ',  vcu.apellido_materno) as asesor2
                ,v.id_coordinador as idcoordinador2, CONCAT(vcucoo.nombre, ' ', vcucoo.apellido_paterno, ' ',  vcucoo.apellido_materno) as coor2
                ,v.id_gerente as idgerente2, CONCAT(vcug.nombre, ' ', vcug.apellido_paterno, ' ',  vcug.apellido_materno) as gerente2
                ,lider.id_usuario as idsubdirector2, CONCAT(lider.nombre, ' ', lider.apellido_paterno, ' ',  lider.apellido_materno) as subdirector2,
                cb2.id_usuario as id_cb2, cb2.id_rol as rolcb2, pcb2.porcentaje as p62, pcb2.porcentaje_saldos as ps62, 
                CONCAT(cb2.nombre, ' ', cb2.apellido_paterno, ' ',  cb2.apellido_materno) as club_maderas2
                FROM lotes l
                INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                INNER JOIN ventas_compartidas v ON v.id_cliente=l.idCliente
                INNER JOIN usuarios vcu ON v.id_asesor=vcu.id_usuario
                LEFT JOIN usuarios vcucoo ON v.id_coordinador=vcucoo.id_usuario
                INNER JOIN usuarios vcug ON v.id_gerente=vcug.id_usuario
                INNER JOIN usuarios lider ON vcug.id_lider=lider.id_usuario
                INNER JOIN usuarios ae ON ae.id_usuario = cl.id_asesor
                INNER JOIN porcentajes_comisiones pa ON pa.id_rol = 7
                LEFT JOIN usuarios co ON co.id_usuario = cl.id_coordinador
                LEFT JOIN porcentajes_comisiones pc ON pc.id_rol = 9
                LEFT JOIN usuarios ge ON ge.id_usuario = cl.id_gerente
                LEFT JOIN porcentajes_comisiones pg ON pg.id_rol =3
                LEFT JOIN usuarios su ON su.id_usuario = ge.id_lider
                LEFT JOIN porcentajes_comisiones ps ON ps.id_rol = 2
                LEFT JOIN usuarios di ON di.id_usuario = su.id_lider
                LEFT JOIN porcentajes_comisiones pd ON pd.id_rol = 1

                LEFT JOIN usuarios cb2 ON cb2.id_rol = 42
                LEFT JOIN porcentajes_comisiones pcb2 ON pcb2.id_rol = 42


                WHERE l.idStatusContratacion BETWEEN 9 AND 15 
              AND pa.relacion_prospeccion = 11
              AND pc.relacion_prospeccion = 11
              AND pg.relacion_prospeccion = 11
              AND ps.relacion_prospeccion = 11
              AND pd.relacion_prospeccion = 11
              AND l.status = 1 AND cl.status  =1
              AND l.tipo_venta IN(1,2)
              AND v.estatus=1
              AND l.idLote=$idLote");
                break;
            
            
            default:
            return $this->db->query("SELECT l.idLote,l.totalNeto2, cl.fechaApartado, cl.lugar_prospeccion,
                ae.id_usuario as id_asesor,ae.id_rol as rolAs, pa.porcentaje as p1, pa.porcentaje_saldos as ps1, CONCAT(ae.nombre, ' ', ae.apellido_paterno, ' ',  ae.apellido_materno) as asesor,
                co.id_usuario as id_coordinador,co.id_rol as rolCoor, pc.porcentaje as p2, pc.porcentaje_saldos as ps2, CONCAT(co.nombre, ' ', co.apellido_paterno, ' ',  co.apellido_materno) as coordinador,
                ge.id_usuario as id_gerente,ge.id_rol as rolGe, pg.porcentaje as p3, (CASE  ge.id_usuario WHEN 832 THEN 25  ELSE pg.porcentaje_saldos  END) ps3,  CONCAT(ge.nombre, ' ', ge.apellido_paterno, ' ',  ge.apellido_materno) as gerente,
                su.id_usuario as id_subdirector,su.id_rol as rolSub, ps.porcentaje as p4, ps.porcentaje_saldos as ps4, CONCAT(su.nombre, ' ', su.apellido_paterno, ' ',  su.apellido_materno) as subdirector,
                di.id_usuario as id_director,di.id_rol as rolDir, pd.porcentaje as p5, pd.porcentaje_saldos as ps5, CONCAT(di.nombre, ' ', di.apellido_paterno, ' ',  di.apellido_materno) as director
                ,v.id_asesor as idasesor2,CONCAT(vcu.nombre, ' ', vcu.apellido_paterno, ' ',  vcu.apellido_materno) as asesor2
                ,v.id_coordinador as idcoordinador2, CONCAT(vcucoo.nombre, ' ', vcucoo.apellido_paterno, ' ',  vcucoo.apellido_materno) as coor2
                ,v.id_gerente as idgerente2, CONCAT(vcug.nombre, ' ', vcug.apellido_paterno, ' ',  vcug.apellido_materno) as gerente2
                ,lider.id_usuario as idsubdirector2, CONCAT(lider.nombre, ' ', lider.apellido_paterno, ' ',  lider.apellido_materno) as subdirector2
                FROM lotes l
                INNER JOIN condominios c ON c.idCondominio = l.idCondominio
                INNER JOIN residenciales r ON r.idResidencial = c.idResidencial
                INNER JOIN clientes cl ON cl.id_cliente = l.idCliente
                INNER JOIN ventas_compartidas v ON v.id_cliente=l.idCliente
                INNER JOIN usuarios vcu ON v.id_asesor=vcu.id_usuario
                LEFT JOIN usuarios vcucoo ON v.id_coordinador=vcucoo.id_usuario
                INNER JOIN usuarios vcug ON v.id_gerente=vcug.id_usuario
                INNER JOIN usuarios lider ON vcug.id_lider=lider.id_usuario
                INNER JOIN usuarios ae ON ae.id_usuario = cl.id_asesor
                INNER JOIN porcentajes_comisiones pa ON pa.id_rol = 7
                LEFT JOIN usuarios co ON co.id_usuario = cl.id_coordinador
                LEFT JOIN porcentajes_comisiones pc ON pc.id_rol = 9
                LEFT JOIN usuarios ge ON ge.id_usuario = cl.id_gerente
                LEFT JOIN porcentajes_comisiones pg ON pg.id_rol =3
                LEFT JOIN usuarios su ON su.id_usuario = ge.id_lider
                LEFT JOIN porcentajes_comisiones ps ON ps.id_rol = 2
                LEFT JOIN usuarios di ON di.id_usuario = su.id_lider
                LEFT JOIN porcentajes_comisiones pd ON pd.id_rol = 1
                WHERE l.idStatusContratacion BETWEEN 9 AND 15 
              AND pa.relacion_prospeccion = 11
              AND pc.relacion_prospeccion = 11
              AND pg.relacion_prospeccion = 11
              AND ps.relacion_prospeccion = 11
              AND pd.relacion_prospeccion = 11
              AND l.status = 1 AND cl.status  =1
              AND l.tipo_venta IN(1,2)
              AND v.estatus=1
              AND l.idLote=$idLote");
    
            break;
    
        }
        
        }

 

     function getDatosNuevasAContraloria($proyecto,$condominio){

      if( $this->session->userdata('id_rol') == 31 ){

        $filtro = " pci1.estatus IN (8,88) AND com.id_usuario = $condominio ";

          return $this->db->query("(SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario ,pci1.id_usuario, oprol.nombre as puesto, 0 personalidad_juridica, u.forma_pago, 0 as factura, pac.porcentaje_abono, oxcest.nombre as estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, 0 lugar_prospeccion, co.nombre as condominio, lo.referencia, (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, (CASE u.forma_pago WHEN 3 THEN (((sed.impuesto)/100)*pci1.abono_neodata) ELSE 0 END) dcto, sed.impuesto valimpuesto
                 FROM pago_comision_ind pci1 
                 INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                 INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
                 INNER JOIN condominios co ON co.idCondominio = lo.idCondominio 
                 INNER JOIN residenciales re ON re.idResidencial = co.idResidencial 
                 INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 1
                 INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (3)
                 INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
                 INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                 INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
                 INNER JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario 
                 WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 2 WHEN 4 THEN 5 WHEN 5 THEN 3 WHEN 607 THEN 1 ELSE u.id_sede END) and sed.estatus = 1
                 WHERE $filtro AND com.estatus in (1) AND lo.idStatusContratacion > 8
                 GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial,  lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata,  pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex, pci1.id_usuario, u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, co.nombre, lo.referencia, sed.impuesto )
                 UNION
                 (SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario ,pci1.id_usuario, oprol.nombre as puesto, 0 personalidad_juridica, u.forma_pago, 0 as factura, pac.porcentaje_abono, oxcest.nombre as estatus_actual,  oxcest.id_opcion id_estatus_actual, re.empresa,  0 lugar_prospeccion, co.nombre as condominio, lo.referencia, (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, (CASE u.forma_pago WHEN 3 THEN (((sed.impuesto)/100)*pci1.abono_neodata) ELSE 0 END) dcto, sed.impuesto valimpuesto
                 FROM pago_comision_ind pci1 
                 INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                 INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
                 INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                 INNER JOIN residenciales re ON re.idResidencial = co.idResidencial 
                 INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (3)
                 INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
                 INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                 INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
                 INNER JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario 
                 WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 2 WHEN 4 THEN 5 WHEN 5 THEN 3 WHEN 607 THEN 1 ELSE u.id_sede END) and sed.estatus = 1
                 WHERE $filtro AND ( (lo.idStatusContratacion < 9 AND com.estatus IN (1,8)) OR (lo.idStatusContratacion > 8  AND com.estatus IN (8)))   
                 GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial,  lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata,  pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex, pci1.id_usuario, u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, co.nombre, lo.referencia, sed.impuesto )");
}else{

    $filtro = " pci1.estatus IN (4) ";

    if($condominio == 0){
        return $this->db->query("(SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario ,pci1.id_usuario, oprol.nombre as puesto, 0 personalidad_juridica, u.forma_pago, 0 as factura, pac.porcentaje_abono, oxcest.nombre as estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, 0 lugar_prospeccion, co.nombre as condominio, lo.referencia, (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, (CASE u.forma_pago WHEN 3 THEN (((sed.impuesto)/100)*pci1.abono_neodata) ELSE 0 END) dcto, sed.impuesto valimpuesto
                 FROM pago_comision_ind pci1 
                 INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                 INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
                 INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                 INNER JOIN residenciales re ON re.idResidencial = co.idResidencial AND re.idResidencial = $proyecto 
                 INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 1
                 INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (3)
                 INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
                 INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                 INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
                 INNER JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario 
                 WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 2 WHEN 4 THEN 5 WHEN 5 THEN 3 WHEN 607 THEN 1 ELSE u.id_sede END) and sed.estatus = 1
                 WHERE  $filtro AND com.estatus in (1) AND lo.idStatusContratacion > 8
                 GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial,  lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata,  pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex, pci1.id_usuario, u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, co.nombre, lo.referencia, sed.impuesto )
                 UNION
                 (SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario ,pci1.id_usuario, oprol.nombre as puesto, 0 personalidad_juridica, u.forma_pago, 0 as factura, pac.porcentaje_abono, oxcest.nombre as estatus_actual,  oxcest.id_opcion id_estatus_actual, re.empresa,  0 lugar_prospeccion, co.nombre as condominio, lo.referencia, (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, (CASE u.forma_pago WHEN 3 THEN (((sed.impuesto)/100)*pci1.abono_neodata) ELSE 0 END) dcto, sed.impuesto valimpuesto
                 FROM pago_comision_ind pci1 
                 INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                 INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
                 INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                 INNER JOIN residenciales re ON re.idResidencial = co.idResidencial AND re.idResidencial = $proyecto 
                 INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (3)
                 INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
                 INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                 INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
                 INNER JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario 
                 WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 2 WHEN 4 THEN 5 WHEN 5 THEN 3 WHEN 607 THEN 1 ELSE u.id_sede END) and sed.estatus = 1
                 WHERE  $filtro AND ((lo.idStatusContratacion < 9 AND com.estatus IN (1,8)) OR (lo.idStatusContratacion > 8  AND com.estatus IN (8)))   
                 GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial,  lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata,  pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex, pci1.id_usuario,  u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, co.nombre, lo.referencia, sed.impuesto )");
}else{
    return $this->db->query("(SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario ,pci1.id_usuario, oprol.nombre as puesto, 0 personalidad_juridica, u.forma_pago, 0 as factura, pac.porcentaje_abono, oxcest.nombre as estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, 0 lugar_prospeccion, co.nombre as condominio, lo.referencia, (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, (CASE u.forma_pago WHEN 3 THEN (((sed.impuesto)/100)*pci1.abono_neodata) ELSE 0 END) dcto, sed.impuesto valimpuesto
                 FROM pago_comision_ind pci1 
                 INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                 INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
                 INNER JOIN condominios co ON co.idCondominio = lo.idCondominio AND co.idCondominio  = $condominio 
                 INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                 INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 1
                 INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (3)
                 INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
                 INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                 INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
                 INNER JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario 
                 WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 2 WHEN 4 THEN 5 WHEN 5 THEN 3 WHEN 607 THEN 1 ELSE u.id_sede END) and sed.estatus = 1
                 WHERE  $filtro AND com.estatus in (1) AND lo.idStatusContratacion > 8
                 GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial,  lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata,  pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex, pci1.id_usuario, u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, co.nombre, lo.referencia, sed.impuesto )
                 UNION
                 (SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario ,pci1.id_usuario, oprol.nombre as puesto, 0 personalidad_juridica, u.forma_pago, 0 as factura, pac.porcentaje_abono, oxcest.nombre as estatus_actual,  oxcest.id_opcion id_estatus_actual, re.empresa,  0 lugar_prospeccion, co.nombre as condominio, lo.referencia, (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, (CASE u.forma_pago WHEN 3 THEN (((sed.impuesto)/100)*pci1.abono_neodata) ELSE 0 END) dcto, sed.impuesto valimpuesto
                 FROM pago_comision_ind pci1 
                 INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                 INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
                 INNER JOIN condominios co ON co.idCondominio = lo.idCondominio AND co.idCondominio  = $condominio 
                 INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                 INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (3)
                 INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
                 INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                 INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
                 INNER JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario 
                 WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 2 WHEN 4 THEN 5 WHEN 5 THEN 3 WHEN 607 THEN 1 ELSE u.id_sede END) and sed.estatus = 1
                 WHERE  $filtro AND ((lo.idStatusContratacion < 9 AND com.estatus IN (1,8)) OR (lo.idStatusContratacion > 8  AND com.estatus IN (8)))   
                 GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial,  lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata,  pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex, pci1.id_usuario,  u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, co.nombre, lo.referencia, sed.impuesto )");
}
}
}
    // sed.impuesto
    





     function getDatosNuevasRContraloria($proyecto,$condominio){

      if( $this->session->userdata('id_rol') == 31 ){

        $filtro = " pci1.estatus IN (8,88) AND com.id_usuario = $condominio ";

          return $this->db->query("(SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario ,pci1.id_usuario, oprol.nombre as puesto, 0 personalidad_juridica, u.forma_pago, 0 as factura, pac.porcentaje_abono, oxcest.nombre as estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, 0 lugar_prospeccion, co.nombre as condominio, lo.referencia, pci1.abono_neodata impuesto, 0 dcto
                 FROM pago_comision_ind pci1 
                 INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                 INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
                 INNER JOIN condominios co ON co.idCondominio = lo.idCondominio 
                 INNER JOIN residenciales re ON re.idResidencial = co.idResidencial 
                 INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 1
                 INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (4)
                 INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
                 INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                 INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
                  
                 WHERE $filtro AND com.estatus in (1) AND lo.idStatusContratacion > 8
                 GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial,  lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata,  pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex, pci1.id_usuario, u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, co.nombre, lo.referencia  )
                 UNION
                 (SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario ,pci1.id_usuario, oprol.nombre as puesto, 0 personalidad_juridica, u.forma_pago, 0 as factura, pac.porcentaje_abono, oxcest.nombre as estatus_actual,  oxcest.id_opcion id_estatus_actual, re.empresa,  0 lugar_prospeccion, co.nombre as condominio, lo.referencia,  pci1.abono_neodata impuesto, 0 dcto
                 FROM pago_comision_ind pci1 
                 INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                 INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
                 INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                 INNER JOIN residenciales re ON re.idResidencial = co.idResidencial 
                 INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (4)
                 INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
                 INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                 INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
                  
                 WHERE $filtro AND ( (lo.idStatusContratacion < 9 AND com.estatus IN (1,8)) OR (lo.idStatusContratacion > 8  AND com.estatus IN (8)))   
                 GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial,  lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata,  pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex, pci1.id_usuario, u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, co.nombre, lo.referencia  )");
}else{

    $filtro = " pci1.estatus IN (4) ";

    if($condominio == 0){
        return $this->db->query("(SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario ,pci1.id_usuario, oprol.nombre as puesto, 0 personalidad_juridica, u.forma_pago, 0 as factura, pac.porcentaje_abono, oxcest.nombre as estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, 0 lugar_prospeccion, co.nombre as condominio, lo.referencia,  pci1.abono_neodata impuesto, 0 dcto
                 FROM pago_comision_ind pci1 
                 INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                 INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
                 INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                 INNER JOIN residenciales re ON re.idResidencial = co.idResidencial AND re.idResidencial = $proyecto 
                 INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 1
                 INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (4)
                 INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
                 INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                 INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
                  
                 WHERE  $filtro AND com.estatus in (1) AND lo.idStatusContratacion > 8
                 GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial,  lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata,  pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex, pci1.id_usuario, u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, co.nombre, lo.referencia  )
                 UNION
                 (SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario ,pci1.id_usuario, oprol.nombre as puesto, 0 personalidad_juridica, u.forma_pago, 0 as factura, pac.porcentaje_abono, oxcest.nombre as estatus_actual,  oxcest.id_opcion id_estatus_actual, re.empresa,  0 lugar_prospeccion, co.nombre as condominio, lo.referencia,  pci1.abono_neodata impuesto, 0 dcto
                 FROM pago_comision_ind pci1 
                 INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                 INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
                 INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                 INNER JOIN residenciales re ON re.idResidencial = co.idResidencial AND re.idResidencial = $proyecto 
                 INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (4)
                 INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
                 INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                 INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
                  
                 WHERE  $filtro AND ((lo.idStatusContratacion < 9 AND com.estatus IN (1,8)) OR (lo.idStatusContratacion > 8  AND com.estatus IN (8)))   
                 GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial,  lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata,  pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex, pci1.id_usuario,  u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, co.nombre, lo.referencia  )");
}else{
    return $this->db->query("(SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario ,pci1.id_usuario, oprol.nombre as puesto, 0 personalidad_juridica, u.forma_pago, 0 as factura, pac.porcentaje_abono, oxcest.nombre as estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, 0 lugar_prospeccion, co.nombre as condominio, lo.referencia,  pci1.abono_neodata impuesto, 0 dcto
                 FROM pago_comision_ind pci1 
                 INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                 INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
                 INNER JOIN condominios co ON co.idCondominio = lo.idCondominio AND co.idCondominio  = $condominio 
                 INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                 INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 1
                 INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (4)
                 INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
                 INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                 INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
                  
                 WHERE  $filtro AND com.estatus in (1) AND lo.idStatusContratacion > 8
                 GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial,  lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata,  pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex, pci1.id_usuario, u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, co.nombre, lo.referencia  )
                 UNION
                 (SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario ,pci1.id_usuario, oprol.nombre as puesto, 0 personalidad_juridica, u.forma_pago, 0 as factura, pac.porcentaje_abono, oxcest.nombre as estatus_actual,  oxcest.id_opcion id_estatus_actual, re.empresa,  0 lugar_prospeccion, co.nombre as condominio, lo.referencia,  pci1.abono_neodata impuesto, 0 dcto
                 FROM pago_comision_ind pci1 
                 INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                 INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
                 INNER JOIN condominios co ON co.idCondominio = lo.idCondominio AND co.idCondominio  = $condominio 
                 INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                 INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (4)
                 INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
                 INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                 INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
                  
                 WHERE  $filtro AND ((lo.idStatusContratacion < 9 AND com.estatus IN (1,8)) OR (lo.idStatusContratacion > 8  AND com.estatus IN (8)))   
                 GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial,  lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata,  pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex, pci1.id_usuario,  u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, co.nombre, lo.referencia  )");
}
}
}

 
 


     function getDatosNuevasFContraloria($proyecto,$condominio){

      if( $this->session->userdata('id_rol') == 31 ){

        $filtro = " pci1.estatus IN (8,88) AND com.id_usuario = $condominio ";

          return $this->db->query("(SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario ,pci1.id_usuario, oprol.nombre as puesto, 0 personalidad_juridica, u.forma_pago, 0 as factura, pac.porcentaje_abono, oxcest.nombre as estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, 0 lugar_prospeccion, co.nombre as condominio, lo.referencia, (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, (CASE u.forma_pago WHEN 3 THEN (((sed.impuesto)/100)*pci1.abono_neodata) ELSE 0 END) dcto, sed.impuesto valimpuesto
                 FROM pago_comision_ind pci1 
                 INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                 INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
                 INNER JOIN condominios co ON co.idCondominio = lo.idCondominio 
                 INNER JOIN residenciales re ON re.idResidencial = co.idResidencial 
                 INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 1
                 INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (2)
                 INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
                 INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                 INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
                 INNER JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario 
                 WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 2 WHEN 4 THEN 5 WHEN 5 THEN 3 WHEN 607 THEN 1 ELSE u.id_sede END) and sed.estatus = 1
                 WHERE $filtro AND com.estatus in (1) AND lo.idStatusContratacion > 8
                 GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial,  lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata,  pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex, pci1.id_usuario, u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, co.nombre, lo.referencia, sed.impuesto )
                 UNION
                 (SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario ,pci1.id_usuario, oprol.nombre as puesto, 0 personalidad_juridica, u.forma_pago, 0 as factura, pac.porcentaje_abono, oxcest.nombre as estatus_actual,  oxcest.id_opcion id_estatus_actual, re.empresa,  0 lugar_prospeccion, co.nombre as condominio, lo.referencia, (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, (CASE u.forma_pago WHEN 3 THEN (((sed.impuesto)/100)*pci1.abono_neodata) ELSE 0 END) dcto, sed.impuesto valimpuesto
                 FROM pago_comision_ind pci1 
                 INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                 INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
                 INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                 INNER JOIN residenciales re ON re.idResidencial = co.idResidencial 
                 INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (2)
                 INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
                 INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                 INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
                 INNER JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario 
                 WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 2 WHEN 4 THEN 5 WHEN 5 THEN 3 WHEN 607 THEN 1 ELSE u.id_sede END) and sed.estatus = 1
                 WHERE $filtro AND ( (lo.idStatusContratacion < 9 AND com.estatus IN (1,8)) OR (lo.idStatusContratacion > 8  AND com.estatus IN (8)))   
                 GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial,  lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata,  pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex, pci1.id_usuario, u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, co.nombre, lo.referencia, sed.impuesto )");
}else{

    $filtro = " pci1.estatus IN (4) ";

    if($condominio == 0){
        return $this->db->query("(SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario ,pci1.id_usuario, oprol.nombre as puesto, 0 personalidad_juridica, u.forma_pago, 0 as factura, pac.porcentaje_abono, oxcest.nombre as estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, 0 lugar_prospeccion, co.nombre as condominio, lo.referencia, (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, (CASE u.forma_pago WHEN 3 THEN (((sed.impuesto)/100)*pci1.abono_neodata) ELSE 0 END) dcto, sed.impuesto valimpuesto
                 FROM pago_comision_ind pci1 
                 INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                 INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
                 INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                 INNER JOIN residenciales re ON re.idResidencial = co.idResidencial AND re.idResidencial = $proyecto 
                 INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 1
                 INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (2)
                 INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
                 INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                 INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
                 INNER JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario 
                 WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 2 WHEN 4 THEN 5 WHEN 5 THEN 3 WHEN 607 THEN 1 ELSE u.id_sede END) and sed.estatus = 1
                 WHERE  $filtro AND com.estatus in (1) AND lo.idStatusContratacion > 8
                 GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial,  lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata,  pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex, pci1.id_usuario, u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, co.nombre, lo.referencia, sed.impuesto )
                 UNION
                 (SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario ,pci1.id_usuario, oprol.nombre as puesto, 0 personalidad_juridica, u.forma_pago, 0 as factura, pac.porcentaje_abono, oxcest.nombre as estatus_actual,  oxcest.id_opcion id_estatus_actual, re.empresa,  0 lugar_prospeccion, co.nombre as condominio, lo.referencia, (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, (CASE u.forma_pago WHEN 3 THEN (((sed.impuesto)/100)*pci1.abono_neodata) ELSE 0 END) dcto, sed.impuesto valimpuesto
                 FROM pago_comision_ind pci1 
                 INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                 INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
                 INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                 INNER JOIN residenciales re ON re.idResidencial = co.idResidencial AND re.idResidencial = $proyecto 
                 INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (2)
                 INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
                 INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                 INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
                 INNER JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario 
                 WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 2 WHEN 4 THEN 5 WHEN 5 THEN 3 WHEN 607 THEN 1 ELSE u.id_sede END) and sed.estatus = 1
                 WHERE  $filtro AND ((lo.idStatusContratacion < 9 AND com.estatus IN (1,8)) OR (lo.idStatusContratacion > 8  AND com.estatus IN (8)))   
                 GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial,  lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata,  pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex, pci1.id_usuario,  u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, co.nombre, lo.referencia, sed.impuesto )");
}else{
    return $this->db->query("(SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario ,pci1.id_usuario, oprol.nombre as puesto, 0 personalidad_juridica, u.forma_pago, 0 as factura, pac.porcentaje_abono, oxcest.nombre as estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, 0 lugar_prospeccion, co.nombre as condominio, lo.referencia, (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, (CASE u.forma_pago WHEN 3 THEN (((sed.impuesto)/100)*pci1.abono_neodata) ELSE 0 END) dcto, sed.impuesto valimpuesto
                 FROM pago_comision_ind pci1 
                 INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                 INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
                 INNER JOIN condominios co ON co.idCondominio = lo.idCondominio AND co.idCondominio  = $condominio 
                 INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                 INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 1
                 INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (2)
                 INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
                 INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                 INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
                 INNER JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario 
                 WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 2 WHEN 4 THEN 5 WHEN 5 THEN 3 WHEN 607 THEN 1 ELSE u.id_sede END) and sed.estatus = 1
                 WHERE  $filtro AND com.estatus in (1) AND lo.idStatusContratacion > 8
                 GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial,  lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata,  pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex, pci1.id_usuario, u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, co.nombre, lo.referencia, sed.impuesto )
                 UNION
                 (SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario ,pci1.id_usuario, oprol.nombre as puesto, 0 personalidad_juridica, u.forma_pago, 0 as factura, pac.porcentaje_abono, oxcest.nombre as estatus_actual,  oxcest.id_opcion id_estatus_actual, re.empresa,  0 lugar_prospeccion, co.nombre as condominio, lo.referencia, (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, (CASE u.forma_pago WHEN 3 THEN (((sed.impuesto)/100)*pci1.abono_neodata) ELSE 0 END) dcto, sed.impuesto valimpuesto
                 FROM pago_comision_ind pci1 
                 INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                 INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
                 INNER JOIN condominios co ON co.idCondominio = lo.idCondominio AND co.idCondominio  = $condominio 
                 INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                 INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (2)
                 INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
                 INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                 INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
                 INNER JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario 
                 WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 2 WHEN 4 THEN 5 WHEN 5 THEN 3 WHEN 607 THEN 1 ELSE u.id_sede END) and sed.estatus = 1
                 WHERE  $filtro AND ((lo.idStatusContratacion < 9 AND com.estatus IN (1,8)) OR (lo.idStatusContratacion > 8  AND com.estatus IN (8)))   
                 GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial,  lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata,  pci1.pago_neodata, pci1.estatus, pci1.fecha_pago_intmex, pci1.id_usuario,  u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, co.nombre, lo.referencia, sed.impuesto )");
}
}
}

 
  
       
        function getDatosNuevasXContraloria($proyecto,$condominio){

            if( $this->session->userdata('id_rol') == 31 ){
                $filtro = "WHERE pci1.estatus IN (8,88) ";
            }
            else{
                $filtro = "WHERE pci1.estatus IN (4) ";
            }



            $user_data = $this->session->userdata('id_usuario');
              switch($this->session->userdata('id_rol')){
                  case 2:
                  case 3:
                  case 7:
                  case 9:
                      $filtro02 = $filtro.' AND   fa.id_usuario = '.$user_data .' ';
                      break;
    
                 default:
                      $filtro02 = $filtro.' ';
                      break;
                  }
      
      
               if($condominio == 0){
                return $this->db->query("SELECT SUM(pci1.abono_neodata) total, re.idResidencial, re.nombreResidencial as proyecto, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario, pci1.id_usuario,  u.forma_pago, 0 as factura, oxcest.id_opcion id_estatus_actual, re.empresa, opn.estatus estatus_opinion, opn.archivo_name, fa.uuid,fa.nombre_archivo as xmla,fa.bandera
                FROM pago_comision_ind pci1 
                       INNER JOIN comisiones com ON pci1.id_comision = com.id_comision AND com.estatus in (1,8)
                       INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
                       INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                       INNER JOIN residenciales re ON re.idResidencial = co.idResidencial AND re.idResidencial = $proyecto
                       INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (2)
                       INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                       INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
                       INNER JOIN opinion_cumplimiento opn ON opn.id_usuario = u.id_usuario and opn.estatus IN (2) 
                       INNER JOIN facturas fa ON fa.id_comision = pci1.id_pago_i
                       $filtro02 
                       GROUP BY re.idResidencial, re.nombreResidencial, u.nombre, u.apellido_paterno, u.apellido_materno, pci1.id_usuario, u.forma_pago, oxcest.id_opcion, re.empresa, re.idResidencial, opn.estatus, opn.archivo_name, fa.uuid,fa.nombre_archivo,fa.bandera
      ORDER BY u.nombre");
          
                  }else{
      
                    return $this->db->query("SELECT SUM(pci1.abono_neodata) total, re.idResidencial, re.nombreResidencial as proyecto, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario, pci1.id_usuario,  u.forma_pago, 0 as factura, oxcest.id_opcion id_estatus_actual, re.empresa, opn.estatus estatus_opinion, opn.archivo_name, fa.uuid,fa.nombre_archivo as xmla,fa.bandera
                       FROM pago_comision_ind pci1 
                       INNER JOIN comisiones com ON pci1.id_comision = com.id_comision AND com.estatus in (1,8)
                       INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
                       INNER JOIN condominios co ON co.idCondominio = lo.idCondominio AND co.idCondominio = $condominio
                       INNER JOIN residenciales re ON re.idResidencial = co.idResidencial  
                       INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (2)
                       INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                       INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
                       INNER JOIN opinion_cumplimiento opn ON opn.id_usuario = u.id_usuario  and opn.estatus IN (2) 
                       INNER JOIN facturas fa ON fa.id_comision = pci1.id_pago_i
                       $filtro02
                       GROUP BY re.idResidencial, re.nombreResidencial, u.nombre, u.apellido_paterno, u.apellido_materno, pci1.id_usuario, u.forma_pago, oxcest.id_opcion, re.empresa, re.idResidencial, opn.estatus, opn.archivo_name, fa.uuid,fa.nombre_archivo,fa.bandera
      ORDER BY u.nombre");
      
                 
                  }
              }
          
          
 
    

        function getDatosInternomexContraloria($proyecto){

             return $this->db->query("SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto,  lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, pci1.estatus, pci1.fecha_pago_intmex fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario ,pci1.id_usuario, oprol.nombre as puesto, cl.personalidad_juridica, u.forma_pago, 0 as factura, pac.porcentaje_abono, oxcest.nombre as estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, cl.lugar_prospeccion
                 FROM pago_comision_ind pci1 
                 LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE estatus in (11) 
                 GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
                 INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                 INNER JOIN lotes lo ON lo.idLote = com.id_lote
                 INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                 INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                 INNER JOIN clientes cl ON cl.idLote = lo.idLote
                 INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
                 INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado
                 INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                 INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus  
                 WHERE pci1.estatus IN (8) AND re.idResidencial = $proyecto AND com.estatus in (1,8) AND oprol.id_catalogo = 1 AND oxcest.id_catalogo = 23 AND lo.status = 1 AND cl.status = 1 AND u.forma_pago in (3,4)
                 GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial,  lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, pci1.estatus, pci1.fecha_pago_intmex, pci1.id_usuario, cl.personalidad_juridica, u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, cl.lugar_prospeccion ORDER BY lo.nombreLote");
        }


    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////


 
    
    function getDatosNuevasMktd_pre(){

//josselu??ine primera validacion
    if( $this->session->userdata('id_usuario') == 2042 ){
        $filtro = " 2,3,4,6 ";
      }
      else{
         $filtro = " 1,5 ";
      }

     return $this->db->query("(SELECT pci1.id_comision, pci1.id_pago_i, pci1.id_usuario,  lo.nombreLote as lote, re.nombreResidencial as proyecto, sed.nombre, sed.id_sede id_ub_origen, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, '0' as lugar_prosp, pci1.estatus, 0 personalidad_juridica, pac.porcentaje_abono, com.id_lote, 0 fechaApartado, sed2.nombre ubicacion_dos, lo.idLote, mk.idc_mktd,sd1.nombre as sd1,sd2.nombre as sd2, pac.bonificacion
                FROM pago_comision_ind pci1 
                LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE estatus in (11) 
                GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
                INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                INNER JOIN lotes lo ON lo.idLote = com.id_lote
                INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                INNER JOIN sedes sed ON sed.id_sede = lo.ubicacion
                LEFT JOIN sedes sed2 ON sed2.id_sede = lo.ubicacion_dos
                LEFT JOIN compartidas_mktd mk on com.id_lote=mk.id_lote
                LEFT JOIN sedes sd1 on sd1.id_sede=mk.sede1
                LEFT JOIN sedes sd2 on sd2.id_sede=mk.sede2
                WHERE pci1.estatus in (1, 41, 42, 51, 52, 61, 62, 12) 
                AND ((lo.idStatusContratacion < 9 AND com.estatus IN (1,8)) OR (lo.idStatusContratacion > 8 AND com.estatus IN (8)))  
                AND com.rol_generado = 38 AND lo.status = 1  
                AND lo.idLote NOT IN (select id_lote from reportes_marketing WHERE estatus = 1 AND dispersion = 1) 
                AND sed.id_sede IN (".$filtro.")  
                GROUP BY lo.nombreLote, re.nombreResidencial, sed.nombre, sed.id_sede, lo.totalNeto2, com.comision_total, com.porcentaje_decimal,  pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, com.comision_total-pci2.abono_pagado, pci1.estatus, sed2.nombre, pac.porcentaje_abono, com.id_lote, pci1.id_pago_i, pci1.id_usuario, pci1.id_comision, lo.idLote, mk.idc_mktd, sd1.nombre, sd2.nombre, pac.bonificacion)
                UNION
                (SELECT pci1.id_comision, pci1.id_pago_i, pci1.id_usuario,  lo.nombreLote as lote, re.nombreResidencial as proyecto, sed.nombre, sed.id_sede id_ub_origen, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, oxc.nombre as lugar_prosp, pci1.estatus, cl.personalidad_juridica, pac.porcentaje_abono, com.id_lote, cl.fechaApartado, sed2.nombre ubicacion_dos, lo.idLote, mk.idc_mktd,sd1.nombre as sd1,sd2.nombre as sd2 , pac.bonificacion
                FROM pago_comision_ind pci1 
                LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE estatus in (11) 
                GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
                INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                INNER JOIN lotes lo ON lo.idLote = com.id_lote
                INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente
                INNER JOIN porcentajes_comisiones pc ON pc.relacion_prospeccion = cl.lugar_prospeccion
                INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = pc.medio_comision AND oxc.id_catalogo = 30
                INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                INNER JOIN sedes sed ON sed.id_sede = lo.ubicacion
                LEFT JOIN sedes sed2 ON sed2.id_sede = lo.ubicacion_dos
                LEFT JOIN compartidas_mktd mk on com.id_lote=mk.id_lote
                LEFT JOIN sedes sd1 on sd1.id_sede=mk.sede1
                LEFT JOIN sedes sd2 on sd2.id_sede=mk.sede2
                WHERE pci1.estatus in (1, 41, 42, 51, 52, 61, 62, 12) AND com.estatus in (1,8)  AND com.rol_generado = 38 AND lo.status = 1 AND cl.status = 1
                AND lo.idLote NOT IN (select id_lote from reportes_marketing WHERE estatus = 1 AND dispersion = 1) 
                AND cl.id_asesor IN (SELECT id_usuario FROM usuarios WHERE id_sede IN (".$filtro.") AND id_rol IN (7,9)) 
                AND com.estatus in (1) AND lo.idStatusContratacion > 8 
                GROUP BY cl.fechaApartado,lo.nombreLote, re.nombreResidencial, sed.nombre, sed.id_sede, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, com.comision_total-pci2.abono_pagado, oxc.nombre, pci1.estatus, sed2.nombre, cl.personalidad_juridica, pac.porcentaje_abono, com.id_lote, pci1.id_pago_i, pci1.id_usuario, pci1.id_comision, lo.idLote, mk.idc_mktd, sd1.nombre, sd2.nombre, pac.bonificacion)");

 


    }
    
 

        function validar_precio_agregado($id_lote){

         $validar_pl = $this->db->query("SELECT * FROM reportes_marketing where id_lote = $id_lote");


        if(empty($validar_pl->row()->id_lote)){

            return 1;
            // NO HAY DATA
        }
        else{
            return 2;
            //SI HAY DATA
        }
        
    }



       function aprobar_comision($id_pago, $id_comision, $id_lote, $precio_lote, $validate){

        $comparar = $this->db->query("SELECT ubicacion FROM lotes WHERE idLote IN (SELECT id_lote FROM comisiones WHERE id_comision = $id_comision)");
        
        if($comparar->row()->ubicacion!=3){
            $val_ubi = $comparar->row()->ubicacion;
            $this->db->query("UPDATE lotes SET ubicacion_dos = $val_ubi WHERE idLote = $id_lote");
        }
        $v1_user = $this->session->userdata('id_usuario');

        if($validate == 1) 
            $this->db->query("INSERT INTO reportes_marketing VALUES ($id_lote, $precio_lote, 1, 1, $v1_user, GETDATE())");
        else
            $this->db->query("UPDATE reportes_marketing SET dispersion = 1 WHERE id_lote = $id_lote");


        $this->db->query("INSERT INTO historial_comisiones VALUES (".$id_pago.", ".$v1_user.", GETDATE(), 1, 'MKTD APROB?? ESTE PAGO')");
        return $this->db->query("UPDATE pago_comision_ind SET estatus = 12 WHERE id_pago_i= $id_pago AND id_comision = $id_comision");
    }
    
    
   
    function getDatosNuevasMktd(){
 
        $filtro = " AND cl.id_asesor IN (SELECT id_usuario FROM usuarios WHERE id_sede IN (1,5) AND id_rol IN (7,9)) AND lo.idLote NOT IN (select id_lote from compartidas_mktd) AND lo.idLote NOT IN (select id_lote from compartidas_mktd)";

        return $this->db->query(" SELECT pci.id_usuario, lo.ubicacion_dos, plm.id_plan, s.nombre as sede, us.nombre, us.apellido_paterno, SUM(pci.abono_neodata) total, res.empresa, res.idResidencial, CAST(res.descripcion AS VARCHAR(MAX)) descripcion
                               FROM pago_comision_ind pci 
                               INNER JOIN comisiones com ON com.id_comision = pci.id_comision
                               INNER JOIN lotes lo ON lo.idLote = com.id_lote
                               INNER JOIN condominios con ON con.idCondominio = lo.idCondominio
                               INNER JOIN residenciales res ON res.idResidencial = con.idResidencial
                               INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente
                               INNER JOIN planes_mktd plm ON plm.fecha_plan <= cl.fechaApartado AND plm.fin_plan >= cl.fechaApartado
                               INNER JOIN sedes s ON s.id_sede = lo.ubicacion_dos
                               INNER JOIN usuarios us ON us.id_usuario = pci.id_usuario
                               WHERE pci.estatus IN (1, 41, 42, 51, 52, 61, 62, 12) AND lo.idLote IN (select id_lote from reportes_marketing WHERE estatus = 1 AND dispersion = 1) AND pci.id_usuario = 4394
                               AND lo.status = 1
                               AND cl.status = 1
                               $filtro

                               GROUP BY plm.id_plan, res.empresa, pci.id_usuario, lo.ubicacion_dos, s.nombre, us.nombre, us.apellido_paterno, res.idResidencial, CAST(res.descripcion AS VARCHAR(MAX))
                               ORDER by plm.id_plan");
                               

   }


   function getDatosNuevasMktd2(){

    $filtro = " AND cl.id_asesor IN (SELECT id_usuario FROM usuarios WHERE id_sede IN (2,3,4,6) AND id_rol IN (7,9)) AND lo.idLote NOT IN (select id_lote from compartidas_mktd) AND lo.idLote NOT IN (select id_lote from compartidas_mktd)";

        return $this->db->query(" SELECT pci.id_usuario, lo.ubicacion_dos, plm.id_plan, s.nombre as sede, us.nombre, us.apellido_paterno, SUM(pci.abono_neodata) total, res.empresa, res.idResidencial, CAST(res.descripcion AS VARCHAR(MAX)) descripcion
                               FROM pago_comision_ind pci 
                               INNER JOIN comisiones com ON com.id_comision = pci.id_comision
                               INNER JOIN lotes lo ON lo.idLote = com.id_lote
                               INNER JOIN condominios con ON con.idCondominio = lo.idCondominio
                               INNER JOIN residenciales res ON res.idResidencial = con.idResidencial
                               INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente
                               INNER JOIN planes_mktd plm ON plm.fecha_plan <= cl.fechaApartado AND plm.fin_plan >= cl.fechaApartado
                               INNER JOIN sedes s ON s.id_sede = lo.ubicacion_dos
                               INNER JOIN usuarios us ON us.id_usuario = pci.id_usuario
                               WHERE pci.estatus IN (1, 41, 42, 51, 52, 61, 62, 12) AND lo.idLote IN (select id_lote from reportes_marketing WHERE estatus = 1 AND dispersion = 1) AND pci.id_usuario = 4394
                               AND lo.status = 1
                               AND cl.status = 1
                               $filtro

                               GROUP BY plm.id_plan, res.empresa, pci.id_usuario, lo.ubicacion_dos, s.nombre, us.nombre, us.apellido_paterno, res.idResidencial, CAST(res.descripcion AS VARCHAR(MAX))
                               ORDER by plm.id_plan");
                               

   }
 

  
    

 


    public function getDataIncidencias() {
        $query = $this->db-> query("SELECT DISTINCT(l.idLote), l.registro_comision, cl.id_cliente, l.nombreLote, l.idStatusContratacion, res.nombreResidencial, cond.nombre as nombreCondominio, l.tipo_venta, l.referencia, vc.id_cliente AS compartida, l.totalNeto, l.totalNeto2, l.plan_enganche, plane.nombre as enganche_tipo, cl.lugar_prospeccion,
        ae.id_usuario as id_asesor, CONCAT(ae.nombre, ' ', ae.apellido_paterno, ' ',  ae.apellido_paterno) as asesor,
        co.id_usuario as id_coordinador, CONCAT(co.nombre, ' ', co.apellido_paterno, ' ',  co.apellido_paterno) as coordinador,
        ge.id_usuario as id_gerente, CONCAT(ge.nombre, ' ', ge.apellido_paterno, ' ',  ge.apellido_paterno) as gerente,
        su.id_usuario as id_subdirector, CONCAT(su.nombre, ' ', su.apellido_paterno, ' ',  su.apellido_paterno) as subdirector,
        di.id_usuario as id_director, CONCAT(di.nombre, ' ', di.apellido_paterno, ' ',  di.apellido_paterno) as director,
        hc.documento, hc.estatus
        FROM  lotes l
        INNER JOIN  clientes cl ON l.idLote=cl.idLote
        INNER JOIN  condominios cond ON l.idCondominio=cond.idCondominio
        INNER JOIN  residenciales res ON cond.idResidencial = res.idResidencial
        LEFT JOIN  opcs_x_cats plane ON plane.id_opcion= l.plan_enganche AND plane.id_catalogo = 39
        LEFT JOIN  ventas_compartidas vc ON vc.id_cliente = cl.id_cliente
        INNER JOIN  usuarios ae ON ae.id_usuario = cl.id_asesor
        LEFT JOIN  usuarios co ON co.id_usuario = ae.id_lider
        LEFT JOIN  usuarios ge ON ge.id_usuario = cl.id_gerente
        LEFT JOIN  usuarios su ON su.id_usuario = ge.id_lider
        LEFT JOIN  usuarios di ON di.id_usuario = su.id_lider
        LEFT JOIN  historial_controversia hc ON hc.idCliente = cl.id_cliente
        WHERE l.idStatusContratacion BETWEEN 9 AND 15 AND cl.status = 1 AND l.status = 1 AND l.registro_comision in (7) AND tipo_venta IS NOT NULL AND tipo_venta IN (1, 2)
        ORDER BY l.idLote");
        return $query->result();
    }

    public function insert_HCD($data){
        $this->db->insert(' historial_comisiones',$data);
        return true;
    }


    public function insert_HCD_A($data){
        $this->db->insert(' historial_controversia',$data);
        return true;
    }



    function verify_controversia($idCliente){
        $query = $this->db->query("SELECT * FROM  historial_controversia WHERE idCliente = ".$idCliente." ");
        return $query->result_array();
    }

 
    public function update_HCD_A($idCliente,$data){
        $this->db->where("idCliente",$idCliente);
        $this->db->update(' historial_controversia',$data);
        return true;
    }


    public function getDatosDocumentos($id_comision, $id_pj){
        if ($id_pj == 1){
            return $this->db->query("(SELECT ox.id_opcion, ox.nombre, 'NO EXISTE' as estado, 
            '0' as expediente FROM opcs_x_cats ox 
            WHERE ox.id_opcion NOT IN (SELECT oxc.id_opcion FROM lotes lo 
            INNER JOIN comisiones com ON com.id_lote = lo.idLote 
            INNER JOIN historial_documento hd ON hd.idLote = lo.idLote 
            LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = hd.tipo_doc 
            WHERE com.id_comision = ".$id_comision." AND oxc.id_catalogo = 31) 
            AND ox.id_catalogo = 31 AND ox.estatus = 1)
            UNION (SELECT oxc.id_opcion, oxc.nombre, 'EXISTE' as estado, hd.expediente 
            FROM lotes lO INNER JOIN comisiones com ON com.id_lote = lo.idLote
            INNER JOIN historial_documento hd ON hd.idLote = lo.idLote 
            LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = hd.tipo_doc 
            WHERE com.id_comision = ".$id_comision." AND oxc.id_catalogo = 31 AND oxc.estatus = 1)");
        }
        else{
            return $this->db->query("(SELECT ox.id_opcion, ox.nombre, 'NO EXISTE' as estado, 
            '0' as expediente FROM opcs_x_cats ox 
            WHERE ox.id_opcion NOT IN (SELECT oxc.id_opcion FROM lotes lo 
            INNER JOIN comisiones com ON com.id_lote = lo.idLote 
            INNER JOIN historial_documento hd ON hd.idLote = lo.idLote 
            LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = hd.tipo_doc 
            WHERE com.id_comision = ".$id_comision." AND oxc.id_catalogo = 32) 
            AND ox.id_catalogo = 32 AND ox.estatus = 1)
            UNION (SELECT oxc.id_opcion, oxc.nombre, 'EXISTE' as estado, hd.expediente 
            FROM lotes lO INNER JOIN comisiones com ON com.id_lote = lo.idLote
            INNER JOIN historial_documento hd ON hd.idLote = lo.idLote 
            LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = hd.tipo_doc 
            WHERE com.id_comision = ".$id_comision." AND oxc.id_catalogo = 32 AND oxc.estatus = 1)");
    
        }
    }


    public function report_empresa(){
        return $this->db->query("SELECT SUM(pci.abono_neodata) as porc_empresa, res.empresa
            FROM pago_comision_ind pci 
            INNER JOIN comisiones com  ON com.id_comision = pci.id_comision
            INNER JOIN lotes lo  ON lo.idLote = com.id_lote 
            INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
            INNER JOIN residenciales res ON res.idResidencial = con.idResidencial 
            WHERE pci.estatus in (8) GROUP BY res.empresa");
        }
    

        function LiquidarLote($user,$idlote) {
            $this->db->query("UPDATE lotes SET registro_comision = 7 WHERE idLote=".$idlote." ");
   
            $comentario = 'SE LIQUID?? COMISI??N DEL LOTE '.$idlote;
            $respuesta = $this->db->query("INSERT INTO historial_comisiones(id_pago_i,id_usuario,fecha_movimiento,estatus,comentario) VALUES (0,".$this->session->userdata('id_usuario').",GETDATE(),7,'".$comentario."')");
   
            if (! $respuesta ) {
               return 0;
               } else {
               return 1;
               }
         
           }

 

    function getCommissionsToValidate($id_usuario){
        if($id_usuario == 1981) { // ES MARICELA
            return $this->db->query("SELECT pci1.id_comision, pci1.id_pago_i, pci1.id_usuario, lo.nombreLote as lote, re.nombreResidencial as proyecto, sed.nombre, sed.id_sede,
                                lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata,
                                pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, oxc.nombre as lugar_prosp, pci1.estatus,
                                cl.personalidad_juridica, pac.porcentaje_abono
                                ,contrato.expediente, com.id_lote,cl.fechaApartado, sed2.nombre ubicacion_dos
                                FROM pago_comision_ind pci1
                                LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE estatus in (11)
                                GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
                                INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                                INNER JOIN lotes lo ON lo.idLote = com.id_lote
                                INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                                INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                                INNER JOIN clientes cl ON cl.idLote = lo.idLote
                                INNER JOIN porcentajes_comisiones pc ON pc.relacion_prospeccion = cl.lugar_prospeccion
                                INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = pc.medio_comision
                                INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                                INNER JOIN sedes sed ON sed.id_sede = lo.ubicacion
                                LEFT JOIN sedes sed2 ON sed2.id_sede = lo.ubicacion_dos
                                INNER JOIN (SELECT expediente, idCliente FROM historial_documento WHERE tipo_doc in (8)
                                AND status = 1 GROUP BY idCliente, expediente) contrato ON contrato.idCliente = cl.id_cliente
                                WHERE pci1.estatus IN (41, 51, 61) AND com.estatus IN (1,8)
                                AND oxc.id_catalogo = 30 AND com.rol_generado = 38
                                GROUP BY cl.fechaApartado,lo.nombreLote, re.nombreResidencial, sed.nombre, sed.id_sede,
                                lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata,
                                pci2.abono_pagado, com.comision_total-pci2.abono_pagado, oxc.nombre, pci1.estatus,
                                cl.personalidad_juridica, pac.porcentaje_abono, sed2.nombre
                                ,contrato.expediente, com.id_lote, pci1.id_pago_i, pci1.id_usuario, pci1.id_comision ORDER BY lo.nombreLote");
        } else if($id_usuario == 1988) { // ES FERNANDA
            return $this->db->query("SELECT pci1.id_comision, pci1.id_pago_i, pci1.id_usuario, lo.nombreLote as lote, re.nombreResidencial as proyecto, sed.nombre, sed.id_sede,
                                lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata,
                                pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, oxc.nombre as lugar_prosp, pci1.estatus,
                                cl.personalidad_juridica, pac.porcentaje_abono
                                ,contrato.expediente, com.id_lote,cl.fechaApartado, sed2.nombre ubicacion_dos
                                FROM pago_comision_ind pci1
                                LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE estatus in (11)
                                GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
                                INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                                INNER JOIN lotes lo ON lo.idLote = com.id_lote
                                INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                                INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                                INNER JOIN clientes cl ON cl.idLote = lo.idLote
                                INNER JOIN porcentajes_comisiones pc ON pc.relacion_prospeccion = cl.lugar_prospeccion
                                INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = pc.medio_comision
                                INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                                INNER JOIN sedes sed ON sed.id_sede = lo.ubicacion
                                LEFT JOIN sedes sed2 ON sed2.id_sede = lo.ubicacion_dos
                                INNER JOIN (SELECT expediente, idCliente FROM historial_documento WHERE tipo_doc in (8)
                                AND status = 1 GROUP BY idCliente, expediente) contrato ON contrato.idCliente = cl.id_cliente
                                WHERE pci1.estatus IN (42, 52, 62) AND com.estatus in (1,8)
                                AND oxc.id_catalogo = 30 AND com.rol_generado = 38
                                GROUP BY cl.fechaApartado,lo.nombreLote, re.nombreResidencial, sed.nombre, sed.id_sede,
                                lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata,
                                pci2.abono_pagado, com.comision_total-pci2.abono_pagado, oxc.nombre, pci1.estatus,
                                cl.personalidad_juridica, pac.porcentaje_abono, sed2.nombre
                                ,contrato.expediente, com.id_lote, pci1.id_pago_i, pci1.id_usuario, pci1.id_comision ORDER BY lo.nombreLote");
        }
    }

    function updateIndividualCommission($idsol, $estatus) {
        return $this->db->query("UPDATE pago_comision_ind SET estatus = $estatus WHERE id_pago_i IN (".$idsol.")");
    }

    function updateLotes($idLote, $plaza) {
        return $this->db->query("UPDATE lotes SET ubicacion_dos = ".$plaza." WHERE idLote IN (".$idLote.")");
    }

        function updateBandera($id_pagoc) {
        // $response = $this->db->update("pago_comision", $data, "id_pagoc = $id_pagoc");
        $response = $this->db->query("UPDATE pago_comision SET bandera = 0, fecha_modificacion = GETDATE() WHERE id_lote IN (".$id_pagoc.")");
        $response = $this->db->query("UPDATE lotes SET registro_comision = 1 WHERE idLote IN (".$id_pagoc.")");
        if (! $response ) {
            return $finalAnswer = 0;
        } else {
            return $finalAnswer = 1;
        }
    }

 


    function ComisionesEnviar($usuario,$recidencial,$opc){
switch ($opc) {
case 3:

    $consulta = $this->db->query(" SELECT pci.id_pago_i
    FROM pago_comision_ind pci
    INNER JOIN comisiones com ON com.id_comision = pci.id_comision
    INNER JOIN lotes lo ON lo.idLote = com.id_lote
    INNER JOIN condominios cod ON cod.idCondominio = lo.idCondominio
    INNER JOIN residenciales res ON res.idResidencial = cod.idResidencial
    INNER JOIN clientes cl ON cl.idLote = lo.idLote
    INNER JOIN (SELECT expediente, idCliente FROM historial_documento WHERE tipo_doc in (8)
    AND status = 1 GROUP BY idCliente, expediente) contrato ON contrato.idCliente = cl.id_cliente
    WHERE lo.status = 1 AND lo.registro_comision NOT IN (0) AND pci.estatus IN (1, 2)
    AND contrato.expediente IS NOT NULL AND pci.id_usuario = $usuario AND res.idResidencial = $recidencial")->result_array();

//echo print_r($consulta);
for($i=0;$i < count($consulta); $i++){
    // $id_user_Vl = $this->session->userdata('id_usuario');
 $this->db->query("INSERT INTO historial_comisiones VALUES (".$consulta[$i]['id_pago_i'].", ".$usuario.", GETDATE(), 1, 'COLABORADOR ENV??O A CONTRALOR??A')");
 
 }

$respuesta = $this->db->query(" UPDATE pago_comision_ind set estatus = 4
FROM pago_comision_ind pci
INNER JOIN comisiones com ON com.id_comision = pci.id_comision
INNER JOIN lotes lo ON lo.idLote = com.id_lote
INNER JOIN condominios cod ON cod.idCondominio = lo.idCondominio
INNER JOIN residenciales res ON res.idResidencial = cod.idResidencial
INNER JOIN clientes cl ON cl.idLote = lo.idLote
INNER JOIN (SELECT expediente, idCliente FROM historial_documento WHERE tipo_doc in (8)
AND status = 1 GROUP BY idCliente, expediente) contrato ON contrato.idCliente = cl.id_cliente
WHERE lo.status = 1 AND lo.registro_comision NOT IN (0) AND pci.estatus IN (1, 2)
AND contrato.expediente IS NOT NULL AND pci.id_usuario = $usuario AND res.idResidencial = $recidencial");

if (! $respuesta ) {
return 0;
} else {
return 1;
}
break;
case 4:

    $consulta = $this->db->query("  SELECT pci.id_pago_i
FROM pago_comision_ind pci
INNER JOIN comisiones com ON com.id_comision = pci.id_comision
INNER JOIN lotes lo ON lo.idLote = com.id_lote
INNER JOIN condominios cod ON cod.idCondominio = lo.idCondominio
INNER JOIN residenciales res ON res.idResidencial = cod.idResidencial
INNER JOIN clientes cl ON cl.idLote = lo.idLote
INNER JOIN facturas fac ON fac.id_comision = pci.id_pago_i
INNER JOIN (SELECT expediente, idCliente FROM historial_documento WHERE tipo_doc in (8)
AND status = 1 GROUP BY idCliente, expediente) contrato ON contrato.idCliente = cl.id_cliente
WHERE lo.status = 1 AND lo.registro_comision NOT IN (0) AND pci.estatus IN (1, 2)
AND contrato.expediente IS NOT NULL AND pci.id_usuario = $usuario AND res.idResidencial = $recidencial")->result_array();
echo print_r($consulta);

    for($i=0;$i < count($consulta); $i++){
        // $id_user_Vl = $this->session->userdata('id_usuario');
     $this->db->query("INSERT INTO historial_comisiones VALUES (".$consulta[$i]['id_pago_i'].", ".$usuario.", GETDATE(), 1, 'COLABORADOR ENV??O A CONTRALOR??A')");
     
     }


$respuesta = $this->db->query(" UPDATE pago_comision_ind set estatus = 4
FROM pago_comision_ind pci
INNER JOIN comisiones com ON com.id_comision = pci.id_comision
INNER JOIN lotes lo ON lo.idLote = com.id_lote
INNER JOIN condominios cod ON cod.idCondominio = lo.idCondominio
INNER JOIN residenciales res ON res.idResidencial = cod.idResidencial
INNER JOIN clientes cl ON cl.idLote = lo.idLote
INNER JOIN facturas fac ON fac.id_comision = pci.id_pago_i
INNER JOIN (SELECT expediente, idCliente FROM historial_documento WHERE tipo_doc in (8)
AND status = 1 GROUP BY idCliente, expediente) contrato ON contrato.idCliente = cl.id_cliente
WHERE lo.status = 1 AND lo.registro_comision NOT IN (0) AND pci.estatus IN (1, 2)
AND contrato.expediente IS NOT NULL AND pci.id_usuario = $usuario AND res.idResidencial = $recidencial");

if (! $respuesta ) {
return 0;
} else {
return 1;
}
break;
case 1:
//ASIMILADOS TODAS
$consulta = $this->db->query("SELECT pci.id_pago_i
FROM pago_comision_ind pci
INNER JOIN comisiones com ON com.id_comision = pci.id_comision
INNER JOIN lotes lo ON lo.idLote = com.id_lote
INNER JOIN condominios cod ON cod.idCondominio = lo.idCondominio
INNER JOIN residenciales res ON res.idResidencial = cod.idResidencial
INNER JOIN clientes cl ON cl.idLote = lo.idLote
INNER JOIN (SELECT expediente, idCliente FROM historial_documento WHERE tipo_doc in (8)
AND status = 1 GROUP BY idCliente, expediente) contrato ON contrato.idCliente = cl.id_cliente
WHERE lo.status = 1 AND lo.registro_comision NOT IN (0) AND pci.estatus IN (1, 2)
AND contrato.expediente IS NOT NULL AND pci.id_usuario = $usuario  AND res.idResidencial > 0")->result_array();

for($i=0;$i < count($consulta); $i++){
   // $id_user_Vl = $this->session->userdata('id_usuario');
$this->db->query("INSERT INTO historial_comisiones VALUES (".$consulta[$i]['id_pago_i'].", ".$usuario.", GETDATE(), 1, 'COLABORADOR ENV??O A CONTRALOR??A')");

}


$respuesta = $this->db->query(" UPDATE pago_comision_ind set estatus = 4
FROM pago_comision_ind pci
INNER JOIN comisiones com ON com.id_comision = pci.id_comision
INNER JOIN lotes lo ON lo.idLote = com.id_lote
INNER JOIN condominios cod ON cod.idCondominio = lo.idCondominio
INNER JOIN residenciales res ON res.idResidencial = cod.idResidencial
INNER JOIN clientes cl ON cl.idLote = lo.idLote
INNER JOIN (SELECT expediente, idCliente FROM historial_documento WHERE tipo_doc in (8)
AND status = 1 GROUP BY idCliente, expediente) contrato ON contrato.idCliente = cl.id_cliente
WHERE lo.status = 1 AND lo.registro_comision NOT IN (0) AND pci.estatus IN (1, 2)
AND contrato.expediente IS NOT NULL AND pci.id_usuario = $usuario AND res.idResidencial > 0");

if (! $respuesta ) {
return 0;
} else {
return 1;
}
break;
case 2:
//FACTURAS TODAS

$consulta = $this->db->query("SELECT pci.id_pago_i
FROM pago_comision_ind pci
INNER JOIN comisiones com ON com.id_comision = pci.id_comision
INNER JOIN lotes lo ON lo.idLote = com.id_lote
INNER JOIN condominios cod ON cod.idCondominio = lo.idCondominio
INNER JOIN residenciales res ON res.idResidencial = cod.idResidencial
INNER JOIN clientes cl ON cl.idLote = lo.idLote
INNER JOIN facturas fac ON fac.id_comision = pci.id_pago_i
INNER JOIN (SELECT expediente, idCliente FROM historial_documento WHERE tipo_doc in (8)
AND status = 1 GROUP BY idCliente, expediente) contrato ON contrato.idCliente = cl.id_cliente
WHERE lo.status = 1 AND lo.registro_comision NOT IN (0) AND pci.estatus IN (1, 2)
AND contrato.expediente IS NOT NULL AND pci.id_usuario = $usuario AND res.idResidencial > 0")->result_array();


for($i=0;$i < count($consulta); $i++){
    // $id_user_Vl = $this->session->userdata('id_usuario');
 $this->db->query("INSERT INTO historial_comisiones VALUES (".$consulta[$i]['id_pago_i'].", ".$usuario.", GETDATE(), 1, 'COLABORADOR ENV??O A CONTRALOR??A')");
 
 }



$respuesta = $this->db->query("UPDATE pago_comision_ind set estatus = 4
FROM pago_comision_ind pci
INNER JOIN comisiones com ON com.id_comision = pci.id_comision
INNER JOIN lotes lo ON lo.idLote = com.id_lote
INNER JOIN condominios cod ON cod.idCondominio = lo.idCondominio
INNER JOIN residenciales res ON res.idResidencial = cod.idResidencial
INNER JOIN clientes cl ON cl.idLote = lo.idLote
INNER JOIN facturas fac ON fac.id_comision = pci.id_pago_i
INNER JOIN (SELECT expediente, idCliente FROM historial_documento WHERE tipo_doc in (8)
AND status = 1 GROUP BY idCliente, expediente) contrato ON contrato.idCliente = cl.id_cliente
WHERE lo.status = 1 AND lo.registro_comision NOT IN (0) AND pci.estatus IN (1, 2)
AND contrato.expediente IS NOT NULL AND pci.id_usuario = $usuario AND res.idResidencial > 0");

if (! $respuesta ) {
return 0;
} else {
return 1;
}
break;
}
}

  function GetFormaPago($id){
        return $this->db->query("SELECT forma_pago FROM usuarios WHERE id_usuario=$id");
  }

  public function borrar_factura($id_comision){
return $this->db->query("DELETE FROM facturas WHERE id_comision =".$id_comision."");
}


  
  function getDatosRevisionMktd(){
    // return $this->db->query("SELECT pcmk.id_pago_mk, pcmk.abono_marketing, pcmk.pago_mktd, pcmk.fecha_abono, CONCAT(us.nombre,' ', us.apellido_paterno, ' ', us.apellido_materno) colaborador, pcmk.fecha_pago_intmex
    // FROM pago_comision_mktd pcmk INNER JOIN usuarios us ON us.id_usuario = pcmk.id_usuario WHERE pcmk.estatus = 4 ORDER BY pcmk.id_usuario");


      if( $this->session->userdata('id_rol') == 31 ){
        $filtro = "WHERE pcmk.estatus = 8 AND pcmk.abono_marketing > 0 ";
      }
      else{
        $filtro = "WHERE pcmk.estatus = 1 AND pcmk.abono_marketing > 0 ";
      }


return $this->db->query("SELECT SUM(pcmk.abono_marketing) sum_abono_marketing, us.id_usuario,
CONCAT(us.nombre,' ', us.apellido_paterno, ' ', us.apellido_materno) colaborador, 
sed.nombre sede, oxc.nombre forma_pago,
(CASE us.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*SUM(pcmk.abono_marketing)) ELSE SUM(pcmk.abono_marketing) END) impuesto, 
(CASE us.forma_pago WHEN 3 THEN (((sed.impuesto)/100)*SUM(pcmk.abono_marketing)) ELSE 0 END) dcto, sed.impuesto valimpuesto , pcmk.empresa
FROM pago_comision_mktd pcmk
INNER JOIN usuarios us ON us.id_usuario = pcmk.id_usuario 
INNER JOIN sedes sed ON sed.id_sede = (CASE WHEN LEN (us.id_sede) > 1 THEN 2 ELSE us.id_sede END)
INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = us.forma_pago AND oxc.id_catalogo = 16
$filtro
GROUP BY pcmk.id_usuario, pcmk.empresa, us.nombre, us.apellido_paterno, us.apellido_materno, us.id_usuario, 
sed.nombre, oxc.nombre, us.forma_pago, sed.impuesto");
}

// getDatosEnviadasInternomex
// getDatosNuevasmkContraloria
function getDatosNuevasmkContraloria(){


           if( $this->session->userdata('id_rol') == 31 ){
                $filtro = "WHERE pci1.estatus IN (8) ";
            }
            else{
                $filtro = "WHERE pci1.estatus IN (13) ";
            }


 
   return $this->db->query("SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, /*pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, */pci1.estatus, pci1.fecha_pago_intmex fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario ,pci1.id_usuario, oprol.nombre as puesto, cl.personalidad_juridica, u.forma_pago, 0 as factura, pac.porcentaje_abono, oxcest.nombre as estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, cl.lugar_prospeccion, co.nombre as condominio, lo.referencia, (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, (CASE u.forma_pago WHEN 3 THEN (((sed.impuesto)/100)*pci1.abono_neodata) ELSE 0 END) dcto, sed.impuesto valimpuesto,com.id_lote
                 FROM pago_comision_ind pci1 
                /* LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE estatus in (11) 
                 GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision*/
                 INNER JOIN comisiones com ON pci1.id_comision = com.id_comision AND com.estatus in (1,8)
                 INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
                 INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                 INNER JOIN residenciales re ON re.idResidencial = co.idResidencial 
                 INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 1
                 INNER JOIN usuarios u ON u.id_usuario = com.id_usuario /*AND u.forma_pago in (3)*/
                 INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
                 INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                 INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
                 INNER JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario 
                 WHEN 2 THEN 2 
                 WHEN 3 THEN 2 
                 WHEN 1980 THEN 2 
                 WHEN 1981 THEN 2 
                 WHEN 1982 THEN 2 
                 WHEN 1988 THEN 2 
                 WHEN 4 THEN 5
                 WHEN 5 THEN 3
                 WHEN 607 THEN 1 
                 ELSE u.id_sede END) and sed.estatus = 1
                 $filtro  and com.rol_generado in (38)
                 GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial,  lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata,  pci1.pago_neodata, /*pci2.abono_pagado, */pci1.estatus, pci1.fecha_pago_intmex, pci1.id_usuario, cl.personalidad_juridica, u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, cl.lugar_prospeccion, co.nombre, lo.referencia, sed.impuesto,com.id_lote ORDER BY lo.nombreLote");

} 



function getDatosEnviadasmkContraloria(){
 
   return $this->db->query("SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, /*pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, */pci1.estatus, pci1.fecha_pago_intmex fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario ,pci1.id_usuario, oprol.nombre as puesto, cl.personalidad_juridica, u.forma_pago, 0 as factura, pac.porcentaje_abono, oxcest.nombre as estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, cl.lugar_prospeccion, co.nombre as condominio, lo.referencia, (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, (CASE u.forma_pago WHEN 3 THEN (((sed.impuesto)/100)*pci1.abono_neodata) ELSE 0 END) dcto, sed.impuesto valimpuesto
                 FROM pago_comision_ind pci1 
                /* LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE estatus in (11) 
                 GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision*/
                 INNER JOIN comisiones com ON pci1.id_comision = com.id_comision AND com.estatus in (1,8)
                 INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
                 INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                 INNER JOIN residenciales re ON re.idResidencial = co.idResidencial 
                 INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 1
                 INNER JOIN usuarios u ON u.id_usuario = com.id_usuario /*AND u.forma_pago in (3)*/
                 INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
                 INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                 INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
                 INNER JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario 
                 WHEN 2 THEN 2 
                 WHEN 3 THEN 2 
                 WHEN 1980 THEN 2 
                 WHEN 1981 THEN 2 
                 WHEN 1982 THEN 2 
                 WHEN 1988 THEN 2 
                 WHEN 4 THEN 5
                 WHEN 5 THEN 3
                 WHEN 607 THEN 1 
                 ELSE u.id_sede END) and sed.estatus = 1
                 WHERE pci1.estatus IN (12) and com.rol_generado in (38)
                 GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial,  lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata,  pci1.pago_neodata, /*pci2.abono_pagado, */pci1.estatus, pci1.fecha_pago_intmex, pci1.id_usuario, cl.personalidad_juridica, u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, cl.lugar_prospeccion, co.nombre, lo.referencia, sed.impuesto ORDER BY lo.nombreLote");

} 



function getDatosEnviadasADirectorMK($filtro){

    // if( $this->session->userdata('id_usuario') == 2042 ){
    //     $filtro = " 2,3,4,6 ";
    //   }
    //   else{
    //      $filtro = " 1,5 ";
    //   }
    ini_set('max_execution_time', 300);
    set_time_limit(300);

      return $this->db->query("(SELECT pci1.id_comision, pci1.id_pago_i, pci1.id_usuario,  lo.nombreLote as lote, re.nombreResidencial as proyecto, sed.nombre, sed.id_sede id_ub_origen, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, 0 pagado, com.comision_total-0 restante, '0' as lugar_prosp, pci1.estatus, 0 personalidad_juridica, pac.porcentaje_abono, com.id_lote, 0 fechaApartado, sed2.nombre ubicacion_dos, lo.idLote, mk.idc_mktd,sd1.nombre as sd1,sd2.nombre as sd2, pac.bonificacion, re.empresa, co.nombre as condominio, lo.referencia, pci1.fecha_pago_intmex, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario 
                FROM pago_comision_ind pci1 
               
                INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                INNER JOIN lotes lo ON lo.idLote = com.id_lote
                INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                INNER JOIN sedes sed ON sed.id_sede = lo.ubicacion
                INNER JOIN usuarios u ON u.id_usuario = com.id_usuario /*AND u.forma_pago in (3)*/
                LEFT JOIN sedes sed2 ON sed2.id_sede = lo.ubicacion_dos
                LEFT JOIN compartidas_mktd mk on com.id_lote=mk.id_lote
                LEFT JOIN sedes sd1 on sd1.id_sede=mk.sede1
                LEFT JOIN sedes sd2 on sd2.id_sede=mk.sede2
                WHERE pci1.estatus in (1, 41, 42, 51, 52, 61, 62, 12) 
                AND ((lo.idStatusContratacion < 9 AND com.estatus IN (1,8)) OR (lo.idStatusContratacion > 8 AND com.estatus IN (8)))  
                AND com.rol_generado = 38 AND lo.status = 1  
                AND lo.idLote IN (select id_lote from reportes_marketing WHERE estatus = 1 AND dispersion = 1) 
                AND sed.id_sede IN (".$filtro.")  
                GROUP BY lo.nombreLote, re.nombreResidencial, sed.nombre, sed.id_sede, lo.totalNeto2, com.comision_total, com.porcentaje_decimal,  pci1.abono_neodata, pci1.pago_neodata, pci1.estatus, sed2.nombre, pac.porcentaje_abono, com.id_lote, pci1.id_pago_i, pci1.id_usuario, pci1.id_comision, lo.idLote, mk.idc_mktd, sd1.nombre, sd2.nombre, pac.bonificacion, re.empresa, co.nombre, lo.referencia, pci1.fecha_pago_intmex, u.nombre, u.apellido_paterno, u.apellido_materno)
                UNION
                (SELECT pci1.id_comision, pci1.id_pago_i, pci1.id_usuario,  lo.nombreLote as lote, re.nombreResidencial as proyecto, sed.nombre, sed.id_sede id_ub_origen, lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, 0 pagado, 0 restante, oxc.nombre as lugar_prosp, pci1.estatus, cl.personalidad_juridica, pac.porcentaje_abono, com.id_lote, cl.fechaApartado, sed2.nombre ubicacion_dos, lo.idLote, mk.idc_mktd,sd1.nombre as sd1,sd2.nombre as sd2, pac.bonificacion, re.empresa, co.nombre as condominio, lo.referencia, pci1.fecha_pago_intmex,CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario 
                FROM pago_comision_ind pci1 
               
                INNER JOIN comisiones com ON pci1.id_comision = com.id_comision AND com.estatus in (1,8) AND com.rol_generado = 38
                INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.idStatusContratacion > 8 AND lo.status = 1 AND lo.idLote IN (select id_lote from reportes_marketing WHERE estatus = 1 AND dispersion = 1) 
                INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente AND cl.status = 1 AND cl.id_asesor IN (SELECT id_usuario FROM usuarios WHERE id_sede IN (".$filtro.") AND id_rol IN (7,9)) 
                INNER JOIN porcentajes_comisiones pc ON pc.relacion_prospeccion = cl.lugar_prospeccion
                INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = pc.medio_comision AND oxc.id_catalogo = 30
                INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                INNER JOIN sedes sed ON sed.id_sede = lo.ubicacion
                INNER JOIN usuarios u ON u.id_usuario = com.id_usuario /*AND u.forma_pago in (3)*/
                LEFT JOIN sedes sed2 ON sed2.id_sede = lo.ubicacion_dos
                LEFT JOIN compartidas_mktd mk on com.id_lote=mk.id_lote
                LEFT JOIN sedes sd1 on sd1.id_sede=mk.sede1
                LEFT JOIN sedes sd2 on sd2.id_sede=mk.sede2
                WHERE pci1.estatus in (1, 41, 42, 51, 52, 61, 62, 12) /*AND com.estatus in (1,8)*/    
                GROUP BY cl.fechaApartado,lo.nombreLote, re.nombreResidencial, sed.nombre, sed.id_sede, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, oxc.nombre, pci1.estatus, sed2.nombre, cl.personalidad_juridica, pac.porcentaje_abono, com.id_lote, pci1.id_pago_i, pci1.id_usuario, pci1.id_comision, lo.idLote, mk.idc_mktd, sd1.nombre, sd2.nombre, pac.bonificacion, re.empresa, co.nombre, lo.referencia, pci1.fecha_pago_intmex, u.nombre, u.apellido_paterno, u.apellido_materno)

                ");





} 



 

function getLotesOrigen($user,$valor){

  if($user == 1988){//fernanda
    $cadena = " AND cl.id_asesor in (select id_usuario from usuarios where id_rol in (7,9) and 
    id_sede like '%1%' or id_sede like '%5%')";
    $user_vobo = 4394;

  }else if($user == 1981){//maricela
    $cadena = " AND cl.id_asesor in (select id_usuario from usuarios where id_rol in (7,9) and 
    id_sede like '%2%' or id_sede like '%3%' or id_sede like '%4%' or id_sede like '%6%')";
    $user_vobo = 4394;


  }else{
    $cadena = '';
    $user_vobo = $user;

  }

    if($valor == 1){
        return $this->db->query(" SELECT l.idLote, l.nombreLote, pci.id_pago_i, pci.abono_neodata as comision_total, 0 abono_pagado,pci.pago_neodata 
        FROM comisiones com 
        INNER JOIN lotes l ON l.idLote = com.id_lote
        INNER JOIN clientes cl ON cl.id_cliente = l.idCliente

        INNER JOIN pago_comision_ind pci ON pci.id_comision = com.id_comision
        WHERE com.estatus = 1 AND pci.estatus IN (1, 41, 42, 51, 52, 61, 62, 12) AND pci.id_usuario = $user_vobo $cadena ORDER BY pci.abono_neodata DESC");

    }else if($valor == 2){
        return $this->db->query(" SELECT l.idLote, l.nombreLote, pci.id_pago_i, pci.abono_neodata as comision_total, 0 abono_pagado,pci.pago_neodata 
        FROM comisiones com 
        INNER JOIN lotes l ON l.idLote = com.id_lote
        INNER JOIN clientes cl ON cl.id_cliente = l.idCliente

        INNER JOIN pago_comision_ind pci ON pci.id_comision = com.id_comision
        WHERE com.estatus = 1 AND pci.estatus IN (4) AND pci.id_usuario = $user_vobo ORDER BY pci.abono_neodata DESC ");
    }
   
}

// function getLotesOrigen($user,$valor){


//     if($valor == 1){
//         return $this->db->query(" SELECT l.idLote, l.nombreLote, pci.id_pago_i, pci.abono_neodata as comision_total, 0 abono_pagado,pci.pago_neodata 
//         FROM comisiones com 
//         INNER JOIN lotes l ON l.idLote = com.id_lote
//         INNER JOIN pago_comision_ind pci ON pci.id_comision = com.id_comision
//         WHERE com.estatus = 1 AND pci.estatus IN (1,14,51,52) AND pci.id_usuario = $user ");
//     }else if($valor == 2){
//         return $this->db->query(" SELECT l.idLote, l.nombreLote, pci.id_pago_i, pci.abono_neodata as comision_total, 0 abono_pagado,pci.pago_neodata 
//         FROM comisiones com 
//         INNER JOIN lotes l ON l.idLote = com.id_lote
//         INNER JOIN pago_comision_ind pci ON pci.id_comision = com.id_comision
//         WHERE com.estatus = 1 AND pci.estatus IN (4) AND pci.id_usuario = $user ");
//     }
   
// }

function getLotesOrigen2($user,$valor){
  
    $datos =  $this->db->query(" SELECT l.idLote, l.nombreLote, pci.id_pago_i, pci.abono_neodata as comision_total, 0 abono_pagado,u.id_sede,pci.pago_neodata
    FROM comisiones com 
    INNER JOIN lotes l ON l.idLote = com.id_lote
    INNER JOIN pago_comision_ind pci ON pci.id_comision = com.id_comision
    INNER JOIN usuarios u on u.id_usuario=pci.id_usuario
    WHERE com.estatus = 1 AND pci.estatus IN (1) AND pci.id_usuario = $user order by pci.abono_neodata desc ")->result_array();

if(!empty($datos)){ 
$pagos =  $this->db->query(" SELECT sum(abono_neodata) as suma
FROM comisiones com 
INNER JOIN lotes l ON l.idLote = com.id_lote
INNER JOIN pago_comision_ind pci ON pci.id_comision = com.id_comision
WHERE com.estatus = 1 AND pci.estatus IN (1) AND pci.id_usuario = $user ")->result_array();

$maximo = 10000;
if($datos[0]['id_sede'] == 6){
    $maximo = 15000;
}
if($pagos[0]['suma'] < $maximo){
$datosnew[0] = array(
    'abono_pagado'=> null,
'comision_total'=> null,
'idLote'=> null,
'id_pago_i'=> null,
'nombreLote'=> null,
'suma'=>$pagos[0]['suma'],
'id_sede'=>$datos[0]['id_sede'],
'pago_neodata' => $datos[0]['pago_neodata']
);
}else{
$suma=0;
for ($i=0; $i <count($datos); $i++) { 
if( $datos[$i]['comision_total'] > $valor){
    $datosnew[$i] = array(
        'abono_pagado'=> $datos[$i]['abono_pagado'],
'comision_total'=> $datos[$i]['comision_total'],
'idLote'=> $datos[$i]['idLote'],
'id_pago_i'=> $datos[$i]['id_pago_i'],
'nombreLote'=> $datos[$i]['nombreLote'],
'suma'=>$pagos[0]['suma'],
'id_sede'=>$datos[0]['id_sede'],
'pago_neodata' => $datos[$i]['pago_neodata']
    );
    break;
}else{
    //echo $i;
    $suma = $suma + $datos[$i]['comision_total'];
    $datosnew[$i] = array(
        'abono_pagado'=> $datos[$i]['abono_pagado'],
'comision_total'=> $datos[$i]['comision_total'],
'idLote'=> $datos[$i]['idLote'],
'id_pago_i'=> $datos[$i]['id_pago_i'],
'nombreLote'=> $datos[$i]['nombreLote'],
'suma'=>$pagos[0]['suma'],
'pago_neodata' => $datos[$i]['pago_neodata']

    );
    if( $suma >= $valor){
        
        break;
    }
}
}
}
}else{
    $datosnew[0] = array(
        'abono_pagado'=> null,
    'comision_total'=> null,
    'idLote'=> null,
    'id_pago_i'=> null,
    'nombreLote'=> null,
    'suma'=>null,
    'id_sede'=>null,
    'pago_neodata'=>null
    );
}
//echo var_dump($datos);
return $datosnew;
}

 



function getLotesOrigenResguardo($user){
    return $this->db->query(" SELECT l.idLote, l.nombreLote, pci.id_pago_i, pci.abono_neodata as comision_total, 0 abono_pagado 
        FROM comisiones com 
        INNER JOIN lotes l ON l.idLote = com.id_lote
        INNER JOIN pago_comision_ind pci ON pci.id_comision = com.id_comision
        WHERE com.estatus = 1 AND pci.estatus IN (3) AND pci.id_usuario = $user ");
}


function getInformacionData($var,$valor){
    if($valor == 1){
        return $this->db->query(" SELECT l.idLote, l.nombreLote, com.id_comision, pci.abono_neodata as comision_total, 0 abono_pagado 
        FROM comisiones com 
        INNER JOIN lotes l ON l.idLote = com.id_lote
        INNER JOIN pago_comision_ind pci ON pci.id_comision = com.id_comision
        WHERE com.estatus = 1 AND pci.estatus IN (1,14,51,52) AND pci.id_pago_i = $var ");
    }else if($valor ==2){
        return $this->db->query(" SELECT l.idLote, l.nombreLote, com.id_comision, pci.abono_neodata as comision_total, 0 abono_pagado 
        FROM comisiones com 
        INNER JOIN lotes l ON l.idLote = com.id_lote
        INNER JOIN pago_comision_ind pci ON pci.id_comision = com.id_comision
        WHERE com.estatus = 1 AND pci.estatus IN (4) AND pci.id_pago_i = $var ");
    }
   
}


function getInformacionDataResguardo($var){
    return $this->db->query(" SELECT l.idLote, l.nombreLote, com.id_comision, pci.abono_neodata as comision_total, 0 abono_pagado 
        FROM comisiones com 
        INNER JOIN lotes l ON l.idLote = com.id_lote
        INNER JOIN pago_comision_ind pci ON pci.id_comision = com.id_comision
        WHERE com.estatus = 1 AND pci.estatus IN (3) AND pci.id_pago_i = $var");
}

 
function insertar_descuentoEsp($usuarioid,$monto,$ide_comision,$comentario,$usuario,$pago_neodata,$valor){
    
    $estatus = 16;
    
        $respuesta = $this->db->query("INSERT INTO pago_comision_ind(id_comision, id_usuario, abono_neodata, fecha_abono, fecha_pago_intmex, pago_neodata, estatus, modificado_por, comentario, descuento_aplicado,abono_final,aply_pago_intmex) VALUES ($ide_comision, $usuarioid, $monto, GETDATE(), GETDATE(), $pago_neodata, $estatus, $usuario, 'DESCUENTO ', 1 ,null, null)");
        $insert_id = $this->db->insert_id();
    
        $respuesta = $this->db->query("INSERT INTO historial_comisiones VALUES ($insert_id, $usuario, GETDATE(), 1, 'A ESTA COMISION SE LE APLICO UN DESCUENTO QUEDANDO ESTA CANTIDAD RESTANTE, M??TIVO DESCUENTO: ".$comentario."')");
    
    
        if (! $respuesta ) {
            return 0;
            } else {
            return 1;
            }
    }
    function update_descuentoEsp($id_pago_i,$monto, $comentario, $usuario,$valor,$user){
    
        $estatus =4;
            
            if($monto == 0){
                $respuesta = $this->db->query("UPDATE pago_comision_ind SET estatus = 16, modificado_por= $usuario, fecha_pago_intmex = GETDATE(), fecha_abono = GETDATE(), comentario='DESCUENTO' WHERE id_pago_i=$id_pago_i");
                $respuesta = $this->db->query("INSERT INTO historial_comisiones VALUES ($id_pago_i, $usuario, GETDATE(), 1, 'M??TIVO DESCUENTO: ".$comentario."')");
    
            }else{
                $respuesta = $this->db->query("UPDATE pago_comision_ind SET estatus = $estatus, modificado_por= $usuario, fecha_pago_intmex = GETDATE(), fecha_abono = GETDATE(), abono_neodata = $monto, comentario='NUEVO PAGO DESCUENTO' WHERE id_pago_i=$id_pago_i");
                $respuesta = $this->db->query("INSERT INTO historial_comisiones VALUES ($id_pago_i, $usuario, GETDATE(), 1, 'SE ACTUALIZ?? NUEVO PAGO. M??TIVO: ".$comentario."')");
    
            }
        
        
        
            if (! $respuesta ) {
                return 0;
                } else {
                return 1;
                }
        }
function insertar_descuento($usuarioid,$monto,$ide_comision,$comentario,$usuario,$pago_neodata,$valor){
    
    $estatus = 1;
    if($valor == 2){
    
        $estatus = 4;
    }
    else if($valor == 3){
    
        $estatus = 1;
    }


        $respuesta = $this->db->query("INSERT INTO pago_comision_ind(id_comision, id_usuario, abono_neodata, fecha_abono, fecha_pago_intmex, pago_neodata, estatus, modificado_por, comentario, descuento_aplicado,abono_final,aply_pago_intmex) VALUES ($ide_comision, $usuarioid, $monto, GETDATE(), GETDATE(), $pago_neodata, $estatus, $usuario, 'DESCUENTO NUEVO PAGO', 0 ,null, null)");
        $insert_id = $this->db->insert_id();
    
        $respuesta = $this->db->query("INSERT INTO historial_comisiones VALUES ($insert_id, $usuario, GETDATE(), 1, 'A ESTA COMISION SE LE APLICO UN DESCUENTO QUEDANDO ESTA CANTIDAD RESTANTE, M??TIVO DESCUENTO: ".$comentario."')");
    
    
        if (! $respuesta ) {
            return 0;
            } else {
            return 1;
            }
    } 


    function insertar_descuentoch($usuario, $descuento, $comentario,  $monto, $userdata){

    //      echo $usuario.'<br>';
    // echo $descuento.'<br>';

   
        $respuesta = $this->db->query("INSERT INTO descuentos_universidad VALUES (".$usuario.", ".$descuento.", 1, 'DESCUENTO UNIVERSIDAD MADERAS', '".$comentario."', ".$userdata.", GETDATE() , 0, ".$monto.", 1)");
           $insert_id = $this->db->insert_id();
        $respuesta = $this->db->query("INSERT INTO historial_log VALUES (".$insert_id.", ".$userdata.", GETDATE(), 1, 'M??TIVO DESCUENTO: ".$comentario."', 'descuentos_universidad')");
       
       
    if (! $respuesta ) {
               return 0;
               } else {
               return 1;
               }
       }
   
    
   
   
   
       function update_descuento($id_pago_i,$monto, $comentario, $usuario,$valor,$user,$pagos_aplicados){
           $estatus = 0;
           if($valor == 2){
       $estatus =16;
           }else if($valor == 3){
               $estatus =17;
               // -- $respuesta = $this->db->query("UPDATE descuentos_universidad SET estatus = 2 where id_usuario=$user");
               $respuesta = $this->db->query("UPDATE descuentos_universidad SET pagos_activos = (pagos_activos - ".$pagos_aplicados."), estatus = 2 WHERE id_usuario = ".$user." AND estatus = 1");
       
           }
           if($monto == 0){
               $respuesta = $this->db->query("UPDATE pago_comision_ind SET estatus = $estatus, descuento_aplicado=1, modificado_por= $usuario, fecha_pago_intmex = GETDATE(), fecha_abono = GETDATE(), comentario='DESCUENTO' WHERE id_pago_i=$id_pago_i");
           }else{
               $respuesta = $this->db->query("UPDATE pago_comision_ind SET estatus = $estatus, descuento_aplicado=1, modificado_por= $usuario, fecha_pago_intmex = GETDATE(), fecha_abono = GETDATE(), abono_neodata = $monto, comentario='DESCUENTO' WHERE id_pago_i=$id_pago_i");
           }
       
               $respuesta = $this->db->query("INSERT INTO historial_comisiones VALUES ($id_pago_i, $usuario, GETDATE(), 1, 'M??TIVO DESCUENTO: ".$comentario."')");
       
       
           if (! $respuesta ) {
               return 0;
               } else {
               return 1;
               }
       }


    
function update_retiro($id_pago_i,$monto, $comentario, $usuario){
    
    if($monto == 0){
        $respuesta = $this->db->query("UPDATE pago_comision_ind SET estatus = 100, descuento_aplicado=1, modificado_por= $usuario, fecha_pago_intmex = GETDATE(), fecha_abono = GETDATE(), comentario='DESCUENTO' WHERE id_pago_i=$id_pago_i");
    }else{
        $respuesta = $this->db->query("UPDATE pago_comision_ind SET estatus = 100, descuento_aplicado=1, modificado_por= $usuario, fecha_pago_intmex = GETDATE(), fecha_abono = GETDATE(), abono_neodata = $monto, comentario='DESCUENTO' WHERE id_pago_i=$id_pago_i");
    }

        $respuesta = $this->db->query("INSERT INTO historial_comisiones VALUES ($id_pago_i, $usuario, GETDATE(), 1, 'M??TIVO DESCUENTO: ".$comentario."')");


    if (! $respuesta ) {
        return 0;
        } else {
        return 1;
        }
}
 

function obtenerID($id){
    return $this->db->query("SELECT id_comision from pago_comision_ind WHERE id_pago_i=$id");
}


function getDescuentos(){
    return $this->db->query("SELECT pci.id_pago_i, CONCAT(us.nombre,' ',us.apellido_paterno,' ',us.apellido_materno) AS usuario, pci.abono_neodata as monto, 
    lo.nombreLote, hc.comentario AS motivo, pci.estatus, CONCAT(us2.nombre,' ',us2.apellido_paterno,' ',us2.apellido_materno) AS modificado_por,
    pci.fecha_abono
    FROM pago_comision_ind pci
    INNER JOIN usuarios us ON us.id_usuario = pci.id_usuario
    INNER JOIN comisiones co ON co.id_comision = pci.id_comision
    INNER JOIN lotes lo ON lo.idLote = co.id_lote
    LEFT JOIN historial_comisiones hc ON hc.id_pago_i = pci.id_pago_i AND hc.comentario like '%M??TIVO DESCUENTO%'
    INNER JOIN usuarios us2 ON us2.id_usuario = pci.modificado_por
    WHERE (pci.estatus = 0) AND pci.descuento_aplicado = 1");
}
function getDescuentos2(){
    return $this->db->query("SELECT pci.id_pago_i, CONCAT(us.nombre,' ',us.apellido_paterno,' ',us.apellido_materno) AS usuario, pci.abono_neodata as monto, 
    lo.nombreLote, hc.comentario AS motivo, pci.estatus, CONCAT(us2.nombre,' ',us2.apellido_paterno,' ',us2.apellido_materno) AS modificado_por,
    pci.fecha_abono
    FROM pago_comision_ind pci
    INNER JOIN usuarios us ON us.id_usuario = pci.id_usuario
    INNER JOIN comisiones co ON co.id_comision = pci.id_comision
    INNER JOIN lotes lo ON lo.idLote = co.id_lote
    LEFT JOIN historial_comisiones hc ON hc.id_pago_i = pci.id_pago_i AND hc.comentario like '%M??TIVO DESCUENTO%'
    INNER JOIN usuarios us2 ON us2.id_usuario = pci.modificado_por
    WHERE (pci.estatus = 17) AND pci.descuento_aplicado = 1");
}




function getDescuentosCapital(){
    return $this->db->query("SELECT us.estatus as status,SUM(du.monto) as monto, du.id_usuario,CONCAT(us.nombre,' ',us.apellido_paterno,' ',us.apellido_materno) nombre, opc.nombre as puesto, se.id_sede, se.nombre as sede, CONCAT(ua.nombre,' ',ua.apellido_paterno,' ',ua.apellido_materno) creado_por, pci2.abono_pagado, pci3.abono_nuevo, du.pagado_caja, du.pago_individual, du.pagos_activos, du.estatus, (pci2.abono_pagado + du.pagado_caja) aply
        FROM descuentos_universidad du
        INNER JOIN usuarios us ON us.id_usuario = du.id_usuario
        INNER JOIN usuarios ua ON ua.id_usuario = du.creado_por
        INNER JOIN opcs_x_cats opc ON opc.id_opcion = us.id_rol AND opc.id_catalogo = 1
        LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_usuario FROM pago_comision_ind WHERE estatus in (17) GROUP BY id_usuario) pci2 ON du.id_usuario = pci2.id_usuario
        LEFT JOIN (SELECT SUM(abono_neodata) abono_nuevo, id_usuario FROM pago_comision_ind WHERE estatus in (1) GROUP BY id_usuario) pci3 ON du.id_usuario = pci3.id_usuario
        LEFT JOIN sedes se ON se.id_sede = us.id_sede
        WHERE du.estatus in (1,2)
        GROUP BY us.estatus,du.id_usuario, us.nombre, us.apellido_paterno, us.apellido_materno, opc.nombre, se.nombre, ua.nombre, ua.apellido_paterno, ua.apellido_materno,pci2.abono_pagado, pci3.abono_nuevo, se.id_sede, du.pagado_caja, du.pago_individual, du.pagos_activos, du.estatus");
}

function getDescuentosCapitalpagos($user){
    return $this->db->query("SELECT du.id_descuento, du.id_usuario, CONCAT(us.nombre,' ',us.apellido_paterno,' ',us.apellido_materno) nombre, opc.nombre as puesto, se.nombre as sede, pci.abono_neodata as monto, du.estatus, 
                             CONCAT(ua.nombre,' ',ua.apellido_paterno,' ',ua.apellido_materno) creado_por,  pci.fecha_abono, du.detalles, pci.estatus
                             FROM descuentos_universidad du
                             INNER JOIN pago_comision_ind pci ON pci.id_usuario = du.id_usuario AND pci.estatus = 17
                             INNER JOIN usuarios us ON us.id_usuario = du.id_usuario
                             INNER JOIN usuarios ua ON ua.id_usuario = du.creado_por
                             INNER JOIN opcs_x_cats opc ON opc.id_opcion = us.id_rol AND opc.id_catalogo = 1
                             LEFT JOIN sedes se ON se.id_sede = us.id_sede
                             WHERE du.id_usuario = $user")->result_array();
}

 


function getHistorialDescuentos($proyecto,$condominio){

    if($condominio == 0){
    return $this->db->query("SELECT pci.id_pago_i, CONCAT(us.nombre,' ',us.apellido_paterno,' ',us.apellido_materno) AS usuario, pci.abono_neodata as monto, lo.nombreLote, hc.comentario AS motivo, CONCAT(us2.nombre,' ',us2.apellido_paterno,' ',us2.apellido_materno) AS modificado_por, pci.fecha_abono, pci.estatus
    FROM pago_comision_ind pci
    INNER JOIN usuarios us ON us.id_usuario = pci.id_usuario
    INNER JOIN comisiones co ON co.id_comision = pci.id_comision
    INNER JOIN lotes lo ON lo.idLote = co.id_lote
    INNER JOIN condominios con ON con.idCondominio = lo.idCondominio
    INNER JOIN residenciales re ON re.idResidencial = con.idResidencial
    INNER JOIN historial_comisiones hc ON hc.id_pago_i = pci.id_pago_i AND hc.comentario like '%M??TIVO DESCUENTO%'
    INNER JOIN usuarios us2 ON us2.id_usuario = pci.modificado_por
    WHERE pci.estatus IN(0,11,16) AND pci.descuento_aplicado = 1 AND re.idResidencial = $proyecto");
}
else{
    return $this->db->query("SELECT pci.id_pago_i, CONCAT(us.nombre,' ',us.apellido_paterno,' ',us.apellido_materno) AS usuario, pci.abono_neodata as monto, lo.nombreLote, hc.comentario AS motivo, CONCAT(us2.nombre,' ',us2.apellido_paterno,' ',us2.apellido_materno) AS modificado_por, pci.fecha_abono, pci.estatus
    FROM pago_comision_ind pci
    INNER JOIN usuarios us ON us.id_usuario = pci.id_usuario
    INNER JOIN comisiones co ON co.id_comision = pci.id_comision
    INNER JOIN lotes lo ON lo.idLote = co.id_lote
    INNER JOIN condominios con ON con.idCondominio = lo.idCondominio
    INNER JOIN residenciales re ON re.idResidencial = con.idResidencial
    INNER JOIN historial_comisiones hc ON hc.id_pago_i = pci.id_pago_i AND hc.comentario like '%M??TIVO DESCUENTO%'
    INNER JOIN usuarios us2 ON us2.id_usuario = pci.modificado_por
    WHERE pci.estatus IN(0,11,16,17) AND pci.descuento_aplicado = 1 AND con.idCondominio = $condominio");

}
}


function getHistorialRetiros($proyecto,$condominio){
    if($condominio == 0){
        return $this->db->query("SELECT pci.id_pago_i, CONCAT(us.nombre,' ',us.apellido_paterno,' ',us.apellido_materno) AS usuario, pci.abono_neodata as monto, lo.nombreLote, hc.comentario AS motivo, CONCAT(us2.nombre,' ',us2.apellido_paterno,' ',us2.apellido_materno) AS modificado_por, pci.fecha_abono , pci.estatus
        FROM pago_comision_ind pci 
        INNER JOIN usuarios us ON us.id_usuario = pci.id_usuario 
        INNER JOIN comisiones co ON co.id_comision = pci.id_comision 
        INNER JOIN lotes lo ON lo.idLote = co.id_lote 
        INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
        INNER JOIN residenciales re ON re.idResidencial = con.idResidencial 
        LEFT JOIN historial_comisiones hc ON hc.id_pago_i = pci.id_pago_i AND hc.comentario like '%M??TIVO DESCUENTO%' 
        INNER JOIN usuarios us2 ON us2.id_usuario = pci.modificado_por 
        WHERE pci.estatus IN(100,12) AND pci.descuento_aplicado = 1 AND re.idResidencial = $proyecto");
        }
        else{
            return $this->db->query("SELECT pci.id_pago_i, CONCAT(us.nombre,' ',us.apellido_paterno,' ',us.apellido_materno) AS usuario, pci.abono_neodata as monto, lo.nombreLote, hc.comentario AS motivo, CONCAT(us2.nombre,' ',us2.apellido_paterno,' ',us2.apellido_materno) AS modificado_por, pci.fecha_abono, pci.estatus 
            FROM pago_comision_ind pci 
            INNER JOIN usuarios us ON us.id_usuario = pci.id_usuario 
            INNER JOIN comisiones co ON co.id_comision = pci.id_comision 
            INNER JOIN lotes lo ON lo.idLote = co.id_lote 
            INNER JOIN condominios con ON con.idCondominio = lo.idCondominio 
            INNER JOIN residenciales re ON re.idResidencial = con.idResidencial 
            LEFT JOIN historial_comisiones hc ON hc.id_pago_i = pci.id_pago_i AND hc.comentario like '%M??TIVO DESCUENTO%' 
            INNER JOIN usuarios us2 ON us2.id_usuario = pci.modificado_por 
            WHERE pci.estatus IN(100,12) AND pci.descuento_aplicado = 1 AND con.idCondominio = $condominio");
            }
        }

 
function BorrarDescuento($id_bono){
$respuesta = $this->db->query("UPDATE pago_comision_ind SET comentario = CONCAT(id_comision, '-', 'BAJA BONO'), id_comision = 0 WHERE estatus = 0 AND descuento_aplicado = 1 AND id_pago_i = $id_bono");
if (! $respuesta ) {
return 0;
} else {
return 1;
}
}

function UpdateDescuento($id_bono){
$respuesta = $this->db->query("UPDATE pago_comision_ind SET estatus = 11 WHERE estatus = 0 AND descuento_aplicado = 1 AND id_pago_i = $id_bono");
if (! $respuesta ) {
return 0;
} else {
return 1;
}
}

 
    function getDatosComisionesHistorialDescuentos($proyecto,$condominio){

           if($condominio == 0){
            return $this->db->query("SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote, re.nombreResidencial as proyecto,  lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, pci1.estatus, pci1.fecha_abono fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) user_names ,pci1.id_usuario, oprol.nombre as puesto, cl.personalidad_juridica, u.forma_pago, f.id_comision as factura, pac.porcentaje_abono, oxcest.nombre as estatus_actual, oxcest.id_opcion id_estatus_actual, pci1.descuento_aplicado
             FROM pago_comision_ind pci1 
             LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE estatus in (11) 
             GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
             INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
             INNER JOIN lotes lo ON lo.idLote = com.id_lote
             INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
             INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
             INNER JOIN clientes cl ON cl.idLote = lo.idLote
             INNER JOIN porcentajes_comisiones pc ON pc.relacion_prospeccion = cl.lugar_prospeccion
             INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
             INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado
             INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
             INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus 
             LEFT JOIN facturas f ON f.id_comision = com.id_comision
             -- WHERE pci1.estatus IN (1, 3, 4, 5, 6, 7, 8, 9, 10, 11) 
             WHERE pci1.estatus IN (0,11) AND re.idResidencial = $proyecto AND pci1.descuento_aplicado = 1
             AND com.estatus in (1,8) AND oprol.id_catalogo = 1 AND oxcest.id_catalogo = 23 AND lo.status = 1 AND cl.status = 1
             GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial,  lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, cl.personalidad_juridica, u.forma_pago, f.id_comision, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, pci1.descuento_aplicado ORDER BY lo.nombreLote");

        }else{
 
         return $this->db->query("SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote, re.nombreResidencial as proyecto,  lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, pci1.estatus, pci1.fecha_abono fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) user_names ,pci1.id_usuario, oprol.nombre as puesto, cl.personalidad_juridica, u.forma_pago, f.id_comision as factura, pac.porcentaje_abono, oxcest.nombre as estatus_actual, oxcest.id_opcion id_estatus_actual, pci1.descuento_aplicado
             FROM pago_comision_ind pci1 
             LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE estatus in (11) 
             GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
             INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
             INNER JOIN lotes lo ON lo.idLote = com.id_lote
             INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
             INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
             INNER JOIN clientes cl ON cl.idLote = lo.idLote
             INNER JOIN porcentajes_comisiones pc ON pc.relacion_prospeccion = cl.lugar_prospeccion
             INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
             INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado
             INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
             INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus 
             LEFT JOIN facturas f ON f.id_comision = com.id_comision
             -- WHERE pci1.estatus IN (1, 3, 4, 5, 6, 7, 8, 9, 10, 11) 
             WHERE pci1.estatus IN (1, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12) AND co.idCondominio = $condominio and com.id_usuario  = ".$this->session->userdata('id_usuario')."  AND pc.id_rol = ".$this->session->userdata('id_rol')." 
             AND com.estatus in (1,8) AND oprol.id_catalogo = 1 AND oxcest.id_catalogo = 23 AND lo.status = 1 AND cl.status = 1
             GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial,  lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, cl.personalidad_juridica, u.forma_pago, f.id_comision, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, pci1.descuento_aplicado ORDER BY lo.nombreLote");
        }
 
       
        }

        function getDatosHistorialPostventa(){
            return $this->db->query("SELECT SUM(pci.abono_neodata) abonado, lo.idLote, pac.total_comision, lo.totalNeto2, cl.fechaApartado, lo.nombreLote, 
cl.nombre, cl.apellido_paterno, cl.apellido_materno, lo.registro_comision, lo.totalNeto2, lo.referencia, con.nombre as condominio, res.nombreResidencial as proyecto
                FROM lotes lo
                INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente
                INNER JOIN condominios con ON con.idCondominio = lo.idCondominio
                INNER JOIN residenciales res ON res.idResidencial = con.idResidencial
                LEFT JOIN comisiones c1 ON lo.idLote = c1.id_lote
                LEFT JOIN pago_comision_ind pci on pci.id_comision = c1.id_comision
                LEFT JOIN pago_comision pac ON pac.id_lote = lo.idLote
                WHERE lo.status = 1 AND cl.status = 1 AND c1.estatus = 1 AND lo.registro_comision in (1,7)
                GROUP BY lo.idLote, pac.total_comision, lo.totalNeto2, cl.fechaApartado, lo.nombreLote, cl.nombre,
                cl.apellido_paterno, cl.apellido_materno, lo.totalNeto2, lo.registro_comision , lo.referencia, con.nombre, res.nombreResidencial");  
        }

 

        /**----------------------------------------BONOS Y PRESTAMOS------------------------------- */

        function getHistorialAbono($id){
             $this->db->query("SET LANGUAGE Espa??ol;");
            return $this->db->query("SELECT b.*,p.*,x.nombre as est, b.comentario as motivo, convert(nvarchar, p.fecha_abono, 6) date_final, CONCAT(us.nombre, ' ',us.apellido_paterno, ' ',us.apellido_materno) AS creado_por
            FROM bonos b 
            INNER JOIN pagos_bonos_ind p on p.id_bono=b.id_bono 
            INNER JOIN opcs_x_cats x on x.id_opcion=p.estado
            INNER JOIN usuarios us on us.id_usuario = p.creado_por
            WHERE p.id_bono=$id and x.id_catalogo=46 ORDER BY p.id_bono DESC");
        }
 


         function getHistorialAbono2($pago){
 
$this->db->query("SET LANGUAGE Espa??ol;");
return $this->db->query(" SELECT DISTINCT(hc.comentario), hc.id_pago_b, hc.id_usuario, 
convert(nvarchar(20),  hc.fecha_creacion, 113) date_final,
hc.fecha_creacion as fecha_movimiento,
CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre_usuario
FROM historial_bonos hc 
INNER JOIN pagos_bonos_ind pci ON pci.id_pago_bono = hc.id_pago_b
INNER JOIN usuarios u ON u.id_usuario = hc.id_usuario 
WHERE hc.id_pago_b = $pago
ORDER BY hc.fecha_creacion DESC");


}





function BonoCerrado($id){
    return $this->db->query("SELECT b.monto,b.num_pagos,SUM(p.abono) as suma,p.n_p FROM bonos b INNER JOIN pagos_bonos_ind p on p.id_bono=b.id_bono WHERE p.id_bono=$id GROUP BY b.monto, b.num_pagos,p.n_p");
}
 
function getBonosPorUserContra($estado){
    $filtro = '';
    if($this->session->userdata("id_rol") == 18){
$filtro = "and u.id_rol in(18, 19, 20, 25, 26, 27, 28, 30, 36)  ";
    }
    return $this->db->query("SELECT CONCAT(u.nombre, ' ', u.apellido_paterno, ' ' ,u.apellido_materno) as nombre,opcx.nombre as id_rol,p.id_bono,
    p.id_usuario,p.monto,p.num_pagos,p.pago,p.estatus,p.comentario,b.fecha_abono,b.estado,b.id_pago_bono,b.abono,b.n_p,
    (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*p.pago) ELSE p.pago END) impuesto1,sed.impuesto
        FROM bonos p INNER JOIN usuarios u ON u.id_usuario=p.id_usuario 
        INNER JOIN pagos_bonos_ind b on b.id_bono=p.id_bono 
        INNER JOIN opcs_x_cats opcx on opcx.id_opcion=u.id_rol
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = u.forma_pago AND oxc.id_catalogo = 16
         LEFT JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario 
                     WHEN 2 THEN 2 
                     WHEN 3 THEN 2 
                     WHEN 1980 THEN 2 
                     WHEN 1981 THEN 2 
                     WHEN 1982 THEN 2 
                     WHEN 1988 THEN 2 
                     WHEN 4 THEN 5
                     WHEN 5 THEN 3
                     WHEN 607 THEN 1 
                     ELSE u.id_sede END) and sed.estatus = 1
        WHERE opcx.id_catalogo=1 and b.estado IN ($estado) $filtro ");
}

function getBonosX_User($usuario){
    return $this->db->query("SELECT CONCAT(u.nombre, ' ', u.apellido_paterno, ' ' ,u.apellido_materno) as nombre,
    p.id_rol,p.id_bono,p.id_usuario,p.monto,p.num_pagos,p.pago,p.estatus,p.comentario,
    convert(date,b.fecha_abono) as fecha_abono,b.estado,b.id_pago_bono,b.abono,b.n_p,x.nombre as name,
        (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*p.pago) ELSE p.pago END) impuesto1,sed.impuesto,opcx.nombre as id_rol
    FROM bonos p INNER JOIN usuarios u ON u.id_usuario=p.id_usuario 
    INNER JOIN pagos_bonos_ind b on b.id_bono=p.id_bono 
    inner join opcs_x_cats opcx on opcx.id_opcion=u.id_rol
    INNER JOIN opcs_x_cats x on x.id_opcion=b.estado
        INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = u.forma_pago AND oxc.id_catalogo = 16
     left JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario 
                 WHEN 2 THEN 2 
                 WHEN 3 THEN 2 
                 WHEN 1980 THEN 2 
                 WHEN 1981 THEN 2 
                 WHEN 1982 THEN 2 
                 WHEN 1988 THEN 2 
                 WHEN 4 THEN 5
                 WHEN 5 THEN 3
                 WHEN 607 THEN 1 
                 ELSE u.id_sede END) and sed.estatus = 1
    WHERE x.id_catalogo=46  and opcx.id_catalogo=1 AND b.id_usuario=$usuario");
}
/**--------------------------------------------------- */

function getBonosAllUser($a,$b){
    
    $cadena = '';   
    switch($this->session->userdata('id_rol')){
        case 31://INTERNOMEX
            $cadena = ' WHERE b.estado in (3, 6)';
            break;
        case 18://MKTD
            $cadena = ' WHERE u.id_rol in (18, 19, 20, 25, 26, 27, 28, 30, 36)';
            break;
        case 1://ventas
        case 2://ventas
        case 3://ventas
        case 9://ventas
        case 7://ventas
            $cadena = ' WHERE b.id_usuario in ('.$this->session->userdata('id_usuario').')';
            break;
        
        case 32://CONTRA
        case 13://CONTRA
        case 17://CONTRA

        if($b != 0){
            $cadena = ' WHERE b.id_usuario in ('.$b.') AND u.id_rol in ('.$a.')';
        }else{
            if($a == 20){
                $cadena = ' WHERE u.id_rol in (18, 19, 20, 25, 26, 27, 28, 30, 36) ';
            }else{
                $cadena = ' WHERE u.id_rol in ('.$a.')';
            }
        }
        break;


        default:
            if($a == 20){
                 $cadena = ' WHERE u.id_rol in (18, 19, 20, 25, 26, 27, 28, 30, 36) ';
            }else{
                  $cadena = ' WHERE u.id_rol in ('.$a.') ';
            }
            break;
    }
 
    return $this->db->query("SELECT CONCAT(u.nombre,' ',u.apellido_paterno,' ',u.apellido_materno) as nombre, p.id_rol, p.id_bono, p.id_usuario, p.monto, p.num_pagos, p.pago, p.estatus, p.comentario, 
    convert(date, b.fecha_abono) as fecha_abono, b.estado, b.id_pago_bono, b.abono, b.n_p, x.nombre as name, opcx.nombre AS id_rol, (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*p.pago) ELSE p.pago END) impuesto1, sed.impuesto, x.nombre as est
    FROM bonos p 
    INNER JOIN usuarios u ON u.id_usuario=p.id_usuario 
    INNER JOIN pagos_bonos_ind b on b.id_bono=p.id_bono 
    INNER JOIN opcs_x_cats x on x.id_opcion=b.estado AND x.id_catalogo = 46
    INNER JOIN opcs_x_cats opcx on opcx.id_opcion=u.id_rol AND opcx.id_catalogo = 1
    INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = u.forma_pago AND oxc.id_catalogo = 16
    LEFT JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario 
    WHEN 2 THEN 2 
    WHEN 3 THEN 2 
    WHEN 1980 THEN 2 
    WHEN 1981 THEN 2 
    WHEN 1982 THEN 2 
    WHEN 1988 THEN 2 
    WHEN 4 THEN 5
    WHEN 5 THEN 3
    WHEN 607 THEN 1 
    ELSE u.id_sede END) and sed.estatus = 1 $cadena");
 
}


function UpdateINMEX($id_bono,$estatus){
    $respuesta = $this->db->query("UPDATE pagos_bonos_ind SET estado=$estatus WHERE id_pago_bono=$id_bono ");
    $id = $id_bono;
    $comentario = 'INTERNOMEX MARC?? COMO PAGADO';
    if($estatus == 6){
        $comentario = 'CONTRALOR??A ENVI?? A INTERNOMEX';
    }else if($estatus ==2){
        $comentario = 'COLABORADOR ENVI?? A REVISI??N';
    }
    $respuesta = $this->db->query("INSERT INTO historial_bonos(id_pago_b,id_usuario,fecha_creacion,estatus,comentario) VALUES($id,".$this->session->userdata('id_usuario').",GETDATE(),1,'$comentario')");
    if (! $respuesta ) {
        return 0;
        } else {
        return 1;
        }
}
/**--------------------------------------------- */


function insertar_bono($usuarioid,$rol,$monto,$numeroP,$pago,$comentario,$usuario){
   
    $respuesta = $this->db->query("INSERT INTO bonos(id_usuario,id_rol,monto,num_pagos,pago,estatus,comentario,fecha_creacion,creado_por) VALUES(".$usuarioid.",".$rol." ,".$monto.",".$numeroP.",".$pago.",1, '".$comentario."', GETDATE(), ".$usuario.")");
    if (! $respuesta ) {
        return 0;
        } else {
        return 1;
        }
}
function UpdateRevision($id_bono){
    $respuesta = $this->db->query("UPDATE pagos_bonos_ind SET estado=2 WHERE id_pago_bono=$id_bono ");
    $id = $id_bono;
    $respuesta = $this->db->query("INSERT INTO historial_bonos(id_pago_b,id_usuario,fecha_creacion,estatus,comentario) VALUES($id,".$this->session->userdata('id_usuario').",GETDATE(),1,'COLABORADOR ENV??O A CONTRALOR??A')");
    if (! $respuesta ) {
        return 0;
        } else {
        return 1;
        }
}
function UpdateAbono($id_bono){
    $respuesta = $this->db->query("UPDATE bonos SET estatus=2 WHERE id_bono=$id_bono ");
    if (! $respuesta ) {
        return 0;
        } else {
        return 1;
        }
}

function getBonos(){
    return $this->db->query("SELECT p.id_bono,CONCAT(u.nombre, ' ', u.apellido_paterno, ' ' ,u.apellido_materno) as nombre,opcx.nombre as id_rol,p.id_bono,
    p.id_usuario,p.monto,p.num_pagos, p.estatus,convert(date,p.fecha_creacion) as fecha_creacion, sum(d.abono) as suma,p.pago, CAST(p.comentario AS NVARCHAR(4000)) as comentario,
    (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*p.pago) ELSE p.pago END) impuesto1,sed.impuesto
    FROM bonos p 
    LEFT JOIN pagos_bonos_ind d ON d.id_bono=p.id_bono
    INNER JOIN usuarios u ON u.id_usuario=p.id_usuario 
    inner join opcs_x_cats opcx on opcx.id_opcion=u.id_rol
    INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = u.forma_pago AND oxc.id_catalogo = 16
     left JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario 
                 WHEN 2 THEN 2 
                 WHEN 3 THEN 2 
                 WHEN 1980 THEN 2 
                 WHEN 1981 THEN 2 
                 WHEN 1982 THEN 2 
                 WHEN 1988 THEN 2 
                 WHEN 4 THEN 5
                 WHEN 5 THEN 3
                 WHEN 607 THEN 1 
                 ELSE u.id_sede END) and sed.estatus = 1
    WHERE p.estatus=1 and opcx.id_catalogo=1
    GROUP BY CONCAT(u.nombre, ' ', u.apellido_paterno, ' ' ,u.apellido_materno),opcx.nombre ,
    p.id_bono, p.id_usuario, p.monto, p.num_pagos, p.estatus, p.fecha_creacion,p.pago, CAST(p.comentario AS NVARCHAR(4000)),p.id_bono,sed.impuesto,u.forma_pago");
}



function InsertAbono($id_abono,$id_user,$pago,$usuario,$n_p){
    $respuesta = $this->db->query("INSERT INTO pagos_bonos_ind(id_bono,id_usuario,abono,estado,comentario,fecha_abono,fecha_abono_intmex,creado_por,n_p) VALUES(".$id_abono.",".$id_user." ,".$pago.",1,'ABONO', GETDATE(), GETDATE(), ".$usuario." ,$n_p)");
    $id = $this->db->insert_id();
    $respuesta = $this->db->query("INSERT INTO historial_bonos(id_pago_b,id_usuario,fecha_creacion,estatus,comentario) VALUES($id,".$this->session->userdata('id_usuario').",GETDATE(),1,'AGREG?? UN NUEVO ABONO')");

    if (! $respuesta ) {
        return 0;
        } else {
        return 1;
        }
}


function TieneAbonos($id){
    return $this->db->query("SELECT * FROM pagos_bonos_ind WHERE id_bono=$id");
    
    
    }
    
    function BorrarBono($id_bono){
    $respuesta = $this->db->query("UPDATE bonos SET estatus = 0 WHERE id_bono=$id_bono ");
    if (! $respuesta ) {
    return 0;
    } else {
    return 1;
    }
    }



        function TienePago($id){
            return $this->db->query("SELECT * FROM pagos_prestamo_ind WHERE id_prestamo=$id");
            
            
            }
            function BorrarPrestamo($id_prestamo){
                $respuesta = $this->db->query("UPDATE prestamo SET estatus = 0 WHERE id_prestamo=$id_prestamo ");
                if (! $respuesta ) {
                return 0;
                } else {
                return 1;
                }
                }
            
                function getPrestamoxUser($id){
                    return $this->db->query("SELECT id_usuario FROM prestamo WHERE id_usuario=$id AND estatus=1");
                }

                function insertar_prestamos($usuarioid,$monto,$numeroP,$comentario,$pago){
                    $respuesta = $this->db->query("INSERT INTO prestamo(id_usuario,monto,num_pagos,estatus,comentario,fecha_creacion,pago) VALUES (".$usuarioid.", ".$monto.",".$numeroP.",1, '".$comentario."', GETDATE(),".$pago.")");
                    if (! $respuesta ) {
                        return 0;
                        } else {
                        return 1;
                        }
                }
                function getPrestamos(){
                    return $this->db->query("SELECT CONCAT(u.nombre, ' ', u.apellido_paterno, ' ' ,u.apellido_materno) as nombre,p.id_prestamo,p.id_usuario,p.monto,p.num_pagos,p.estatus,p.comentario,p.fecha_creacion,p.pago FROM prestamo p INNER JOIN usuarios u ON u.id_usuario=p.id_usuario WHERE p.estatus=1");
                }
                function InsertPago($id_prestamo,$id_user,$pago,$usuario){
                    $respuesta = $this->db->query("INSERT INTO pagos_prestamo_ind(id_prestamo,id_usuario,pago_p,estado,comentario,fecha_abono,fecha_pago_intmex,creado_por) VALUES(".$id_prestamo.",".$id_user." ,".$pago.",1,'ABONO A PRESTAMO', GETDATE(), GETDATE(), ".$usuario." )");
                    if (! $respuesta ) {
                        return 0;
                        } else {
                        return 1;
                        }
                }

                function PagoCerrado($id){
                    return $this->db->query("SELECT b.monto,b.num_pagos,SUM(p.pago_p) as suma FROM prestamo b INNER JOIN pagos_prestamo_ind p on p.id_prestamo=b.id_prestamo WHERE p.id_prestamo=$id GROUP BY b.monto, b.num_pagos");
                }

                function UpdatePrestamo($id_prestamo){
                    $respuesta = $this->db->query("UPDATE prestamo SET estatus=2 WHERE id_prestamo=$id_prestamo ");
                    if (! $respuesta ) {
                        return 0;
                        } else {
                        return 1;
                        }
                }
                function getHistorialPrestamo($id){
                    return $this->db->query(" SELECT * FROM prestamo b INNER JOIN pagos_prestamo_ind p on p.id_prestamo=b.id_prestamo WHERE p.id_prestamo=$id ORDER BY p.id_prestamo DESC");
                }

                function getPrestamoPorUser($id,$estado){
                    return $this->db->query("SELECT CONCAT(u.nombre, ' ', u.apellido_paterno, ' ' ,u.apellido_materno) as nombre,p.id_prestamo,p.id_usuario,p.monto,p.num_pagos,p.pago,p.estatus,p.comentario,b.fecha_abono,b.estado,b.id_pago_prestamo,b.pago_p FROM prestamo p INNER JOIN usuarios u ON u.id_usuario=p.id_usuario INNER JOIN pagos_prestamo_ind b on b.id_prestamo=p.id_prestamo WHERE p.id_usuario=$id AND b.estado=$estado");
                }
                

                function UpdateRevisionPagos($id_prestamo){
                    $respuesta = $this->db->query("UPDATE pagos_prestamo_ind SET estado=2 WHERE id_pago_prestamo=$id_prestamo ");
                    if (! $respuesta ) {
                        return 0;
                        } else {
                        return 1;
                        }
                }

                function getPrestamosAllUser($estado){
                    return $this->db->query("SELECT CONCAT(u.nombre, ' ', u.apellido_paterno, ' ' ,u.apellido_materno) as nombre,p.id_prestamo,p.id_usuario,p.monto,p.num_pagos,p.pago,p.estatus,p.comentario,b.fecha_abono,b.estado,b.id_pago_prestamo,b.pago_p FROM prestamo p INNER JOIN usuarios u ON u.id_usuario=p.id_usuario INNER JOIN pagos_prestamo_ind b on b.id_prestamo=p.id_prestamo WHERE  b.estado=$estado");
                }

                function getHistorialPrestamoContra($id){
                    return $this->db->query(" SELECT * FROM pagos_prestamo_ind WHERE id_pago_prestamo=$id");
                }

                function AbonosMensuales(){
                    return $this->db->query("select p.id_bono,b.id_usuario,b.pago from bonos b inner join pagos_bonos_ind p on b.id_bono=p.id_bono where b.estatus=1 and convert(date,p.fecha_abono)=convert(date,DATEADD(month, -1, GETDATE() ))"); 
                }
                function AbonoHoy($usuario){
                    return $this->db->query(" select * from pagos_bonos_ind where id_usuario=".$usuario." and convert(date,fecha_abono) = CONVERT(date,GETDATE())"); 
                }


    /**----------------------------------------FIN BONOS Y PRESTAMOS------------------------------- */
    public function getCommissionsByMktdUserReport($fecha1,$fecha2,$estatus)
    {
        if($fecha1 == 0 && $fecha2 == 0 && $estatus == 0){
            $query = $this->db-> query("SELECT pci.id_usuario, (CASE op.nombre WHEN 'Nueva, sin solicitar' THEN 'En revisi??n contralor??a' ELSE op.nombre END) nombre, lo.ubicacion_dos, plm.id_plan, s.nombre as sede, SUM(pci.abono_neodata) total
            FROM pago_comision_ind pci 
            INNER JOIN comisiones com ON com.id_comision = pci.id_comision
            INNER JOIN lotes lo ON lo.idLote = com.id_lote
            INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente
            INNER JOIN planes_mktd plm ON plm.fecha_plan <= cl.fechaApartado AND plm.fin_plan >= cl.fechaApartado
            INNER JOIN sedes s ON s.id_sede = lo.ubicacion_dos
            INNER JOIN usuarios us ON us.id_usuario = pci.id_usuario
            INNER JOIN opcs_x_cats op ON op.id_opcion=pci.estatus 
            WHERE pci.id_usuario = 4394
            and pci.estatus in (1,8,11)
           and op.id_catalogo= 23
            AND lo.status = 1
            AND cl.status = 1
            /*AND lo.ubicacion_dos IN(3, 4, 6) */
            GROUP BY plm.id_plan, pci.id_usuario, op.nombre, lo.ubicacion_dos, s.nombre
            ORDER by plm.id_plan");        
            return $query;
        }

        else if($fecha2 != 0 && $fecha1 != 0 && $estatus != 0){
            $query = $this->db-> query("SELECT pci.id_usuario, (CASE op.nombre WHEN 'Nueva, sin solicitar' THEN 'En revisi??n contralor??a' ELSE op.nombre END) nombre , lo.ubicacion_dos, plm.id_plan, s.nombre as sede, SUM(pci.abono_neodata) total
            FROM pago_comision_ind pci 
            INNER JOIN comisiones com ON com.id_comision = pci.id_comision
            INNER JOIN lotes lo ON lo.idLote = com.id_lote
            INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente
            INNER JOIN planes_mktd plm ON plm.fecha_plan <= cl.fechaApartado AND plm.fin_plan >= cl.fechaApartado
            INNER JOIN sedes s ON s.id_sede = lo.ubicacion_dos
            INNER JOIN usuarios us ON us.id_usuario = pci.id_usuario
            INNER JOIN opcs_x_cats op ON op.id_opcion=pci.estatus 
            WHERE pci.estatus = $estatus AND pci.id_usuario = 4394
            AND CAST(pci.fecha_abono as date) >= CAST('$fecha1' AS date) AND CAST(pci.fecha_abono as date) <= CAST('$fecha2' AS date)
            AND op.id_catalogo= 23
            AND lo.status = 1
            AND cl.status = 1
            /*AND lo.ubicacion_dos IN(3, 4, 6) */
            GROUP BY plm.id_plan, pci.id_usuario, op.nombre, lo.ubicacion_dos, s.nombre
            ORDER by plm.id_plan");
            
            return $query;

        }


    }
    public function getCommissionsByMktdUser($fecha1,$fecha2,$estatus)
    {
        if($fecha1 == 0 && $fecha2 == 0 && $estatus == 0){
            $query = $this->db-> query("SELECT op.nombre,pcm.id_usuario, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre_comisionista, SUM(abono_marketing) total_dispersado, 
            CONVERT(char(10), pcm.fecha_abono , 111) fecha, oxc.nombre rol FROM pago_comision_mktd pcm 
            LEFT JOIN usuarios u ON u.id_usuario = pcm.id_usuario
            LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = u.id_rol AND oxc.id_catalogo = 1
            INNER JOIN opcs_x_cats op ON op.id_opcion=pcm.estatus 
            WHERE op.id_catalogo= 23/*  pcm.fecha_abono >= '$fecha1'*/ GROUP BY op.nombre,pcm.id_usuario, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno),
            CONVERT(char(10), pcm.fecha_abono , 111), oxc.nombre ORDER BY nombre_comisionista;");        
            return $query;
        }
 
        else if($fecha2 != 0 && $fecha1 != 0 && $estatus != 0){
            $query = $this->db-> query("SELECT op.nombre,pcm.id_usuario, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre_comisionista, SUM(abono_marketing) total_dispersado, 
            CONVERT(char(10), pcm.fecha_abono , 111) fecha, oxc.nombre rol FROM pago_comision_mktd pcm 
            LEFT JOIN usuarios u ON u.id_usuario = pcm.id_usuario
            LEFT JOIN opcs_x_cats oxc ON oxc.id_opcion = u.id_rol AND oxc.id_catalogo = 1
            INNER JOIN opcs_x_cats op ON op.id_opcion=pcm.estatus
            WHERE  op.id_catalogo= 23 AND pcm.estatus = $estatus AND CAST(pcm.fecha_abono as date) >= CAST('$fecha1' AS date) AND CAST(pcm.fecha_abono as date) <= CAST('$fecha2' AS date) GROUP BY op.nombre,pcm.id_usuario, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno),
            CONVERT(char(10), pcm.fecha_abono , 111), oxc.nombre ORDER BY nombre_comisionista;");
            
            return $query;

        }
  

    }
 

    /**---------------------------REPORTE JOSH------------------- */
    public function getDataDispersionPagoReport() {
        $query = $this->db-> query("

        (SELECT DISTINCT(l.idLote), l.idStatusContratacion, l.registro_comision, cl.id_cliente, CONCAT(cl.nombre,' ',cl.apellido_paterno,' ',cl.apellido_materno) nombre_cliente, l.nombreLote, l.idStatusContratacion, 
                res.nombreResidencial, cond.nombre as nombreCondominio, l.tipo_venta, l.referencia, vc.id_cliente AS compartida, l.totalNeto, 
                l.totalNeto2, l.plan_enganche, plane.nombre as enganche_tipo, cl.lugar_prospeccion,
                      ae.id_usuario as id_asesor, CONCAT(ae.nombre, ' ', ae.apellido_paterno, ' ',  ae.apellido_materno) as asesor,si.comision_total,SUM(pg.abono_neodata) as abonado
                    FROM  lotes l
                      INNER JOIN  clientes cl ON cl.id_cliente = l.idCliente
                      INNER JOIN  condominios cond ON l.idCondominio=cond.idCondominio
                      INNER JOIN  residenciales res ON cond.idResidencial = res.idResidencial
                      LEFT JOIN  pago_comision pc ON pc.id_lote = l.idLote AND pc.bandera in (0)
                      LEFT JOIN  opcs_x_cats plane ON plane.id_opcion= l.plan_enganche AND plane.id_catalogo = 39

                     INNER JOIN comisiones si ON si.id_lote=l.idLote 
                --  inner join clientes cl2 ON cl2.id_asesor=si.id_usuario
                     INNER JOIN pago_comision_ind pg ON pg.id_comision=si.id_comision

                      --LEFT JOIN  ventas_compartidas vc ON vc.id_cliente = cl.id_cliente
                      LEFT JOIN (SELECT id_cliente FROM ventas_compartidas WHERE estatus = 1) AS vc ON vc.id_cliente = cl.id_cliente
                      INNER JOIN  usuarios ae ON ae.id_usuario = cl.id_asesor
                     
                      WHERE l.idStatusContratacion BETWEEN 9 AND 15 AND cl.status = 1 AND l.status = 1 AND cl.lugar_prospeccion!=6 and si.rol_generado=7
                      
                      AND l.registro_comision in (1) AND pc.bandera in (0) and pg.id_usuario !=4415 and cl.id_asesor=si.id_usuario
                      AND tipo_venta IS NOT NULL AND tipo_venta IN (1, 2) AND l.idLote NOT in (39813,37064,38929,39813) 
                      AND ( cl.fechaApartado >= '2020-03-01' OR l.idlote IN (36344, 23250,22078,10191,23047,10207,13782,29654,22183,23150,22967,13621,33564,22115,32343,11278,11279,34773,35682,12068,13125,29413,35531,23088,35484,32441,13969,31907,2990,35488,35487,35627,35670,28435,36491,36596,36497,35635,35738,25796,11622,36544,36492,25655,36503,34938,36500,34789,36430,36431,19361,36713,36712,35279,36690,22708,32669,34515,36743,37047,36991,37046,34104,37045,36397,36832,37052,27875,4579,37063,36854,36855,36856,36280,36281,36348,36349,36346,36323,33919,35930,27252,30841,35260,28910,37055,27880,27359, 36826, 46865, 44684, 40109, 35863,34191,40635,26933 ) )
                      GROUP BY l.idLote,l.idStatusContratacion, l.registro_comision, cl.id_cliente, CONCAT(cl.nombre,' ',cl.apellido_paterno,' ',cl.apellido_materno),l.nombreLote, l.idStatusContratacion, 
                res.nombreResidencial, cond.nombre, l.tipo_venta, l.referencia, vc.id_cliente,l.totalNeto, 
                l.totalNeto2, l.plan_enganche, plane.nombre, cl.lugar_prospeccion,
                      ae.id_usuario, CONCAT(ae.nombre, ' ', ae.apellido_paterno, ' ',  ae.apellido_materno),si.comision_total
                      )
                      UNION
                      ( SELECT DISTINCT(l.idLote), l.idStatusContratacion, l.registro_comision, cl.id_cliente, CONCAT(cl.nombre,' ',cl.apellido_paterno,' ',cl.apellido_materno) nombre_cliente, l.nombreLote, l.idStatusContratacion, 
                      res.nombreResidencial, cond.nombre as nombreCondominio, l.tipo_venta, l.referencia, vc.id_cliente AS compartida, l.totalNeto, 
                      l.totalNeto2, l.plan_enganche, plane.nombre as enganche_tipo, cl.lugar_prospeccion,
                            ae.id_usuario as id_asesor, CONCAT(ae.nombre, ' ', ae.apellido_paterno, ' ',  ae.apellido_materno) as asesor,si.comision_total,SUM(pg.abono_neodata) as abonado
                           FROM  lotes l
                            INNER JOIN  clientes cl ON cl.id_cliente = l.idCliente
                            INNER JOIN  condominios cond ON l.idCondominio=cond.idCondominio
                            INNER JOIN  residenciales res ON cond.idResidencial = res.idResidencial
                            LEFT JOIN  pago_comision pc ON pc.id_lote = l.idLote AND pc.bandera in (0)
                            LEFT JOIN  opcs_x_cats plane ON plane.id_opcion= l.plan_enganche AND plane.id_catalogo = 39
                            
                            
                             INNER JOIN comisiones si ON si.id_lote=l.idLote
                            --inner join clientes cl2 ON cl2.id_asesor=si.id_usuario
                     INNER JOIN pago_comision_ind pg ON pg.id_comision=si.id_comision

                            LEFT JOIN (SELECT id_cliente FROM ventas_compartidas WHERE estatus = 1) AS vc ON vc.id_cliente = cl.id_cliente
                            INNER JOIN  usuarios ae ON ae.id_usuario = cl.id_asesor
                           
                            WHERE l.idStatusContratacion BETWEEN 9 AND 15 AND cl.status = 1 AND l.status = 1 AND cl.lugar_prospeccion!=6  AND si.rol_generado=7                         
                            AND l.registro_comision in (0) and pg.id_usuario !=4415 and cl.id_asesor=si.id_usuario
                            AND tipo_venta IS NOT NULL AND tipo_venta IN (1, 2) AND l.idLote NOT in (39813, 37064,38929,39813) 
                            AND (cl.fechaApartado >= '2020-03-01' OR l.idLote in(31907, 35863, 36603, 36603, 32575,45694,22741, 28434, 24576, 24577,35697,25218,31684,41032,34191,34141, 40635,36483,38927) )
                            GROUP BY l.idLote,l.idStatusContratacion, l.registro_comision, cl.id_cliente, CONCAT(cl.nombre,' ',cl.apellido_paterno,' ',cl.apellido_materno),l.nombreLote, l.idStatusContratacion, 
                res.nombreResidencial, cond.nombre, l.tipo_venta, l.referencia, vc.id_cliente,l.totalNeto, 
                l.totalNeto2, l.plan_enganche, plane.nombre, cl.lugar_prospeccion,
                      ae.id_usuario, CONCAT(ae.nombre, ' ', ae.apellido_paterno, ' ',  ae.apellido_materno),si.comision_total) --ORDER BY l.idLote
    ");
    return $query->result();
    }
    /**---------------------------------------- */
    public function getEstatusPagosMktd() {
        $query = $this->db-> query("select id_opcion,(CASE nombre WHEN 'Nueva, sin solicitar' THEN 'En revisi??n contralor??a' ELSE nombre END) nombre from opcs_x_cats where id_catalogo = 23 and estatus=1 AND id_opcion IN (1, 8, 11)");
        return $query->result_array();
    }



      function listSedes(){
        return $this->db->query("SELECT * FROM sedes WHERE estatus = 1");
     }

     function listGerentes($sede){
        return $this->db->query("SELECT id_usuario, CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) as nombreUser FROM usuarios WHERE estatus = 1 AND id_rol = 3 AND id_sede  = $sede");
     }


     function agregar_comentarios($a, $b, $c, $d, $e) {
    $id_user_Vl = $this->session->userdata('id_usuario');
    return $this->db->query("INSERT INTO  cobranza_mktd VALUES ($b, $a, 'NA', '".$d."', '".$e."', GETDATE(), $id_user_Vl)");

} 

    function insert_phc($data){
        $this->db->insert_batch('historial_comisiones', $data);
        return true;
    }


    function insert_nuevo_pago($comision,$user,$monto){
    $id_user_Vl = $this->session->userdata('id_usuario');

    $respuesta = $this->db->query("INSERT INTO pago_comision_ind VALUES ($comision, $user, $monto, GETDATE(),  GETDATE(), 0,  11, $id_user_Vl, 'IMPORTACI??N EXTERNA CONTRALOR??A', NULL, NULL, NULL)");
    
    $id = $this->db->insert_id();
    $respuesta = $this->db->query("INSERT INTO historial_comisiones VALUES ($id, 1, GETDATE(), 1, 'CONTRALORIA AGREGO UN NUEVO ABONO YA PAGADO')");

    if (! $respuesta ) {
        return false;
    } else {
        return true;
    }
}



    public function getDirectivos(){
        $query =  $this->db->query("SELECT us.id_usuario, CONCAT(us.nombre, ' ',us.apellido_paterno, ' ',us.apellido_materno) AS nombre FROM usuarios us WHERE us.id_rol in (1,2)");
        return $query->result();

    }


    public function getDirectivos2(){
         $id_user_Vl = $this->session->userdata('id_usuario');
        $query =  $this->db->query("SELECT us.id_usuario, CONCAT(us.nombre, ' ',us.apellido_paterno, ' ',us.apellido_materno) AS nombre FROM usuarios us WHERE us.id_rol in (1,2) AND us.id_usuario = $id_user_Vl ");
        return $query->result();

    }




    public function getMktdCommissionsList() {
        $query = $this->db-> query("(SELECT DISTINCT(l.idLote), l.idStatusContratacion, l.registro_comision, cl.id_cliente, CONCAT(cl.nombre,' ',cl.apellido_paterno,' ',cl.apellido_materno) nombre_cliente, l.nombreLote, l.idStatusContratacion, 
                res.nombreResidencial, cond.nombre as nombreCondominio, l.tipo_venta, l.referencia, vc.id_cliente AS compartida, l.totalNeto, 
                l.totalNeto2, l.plan_enganche, plane.nombre as enganche_tipo, cl.lugar_prospeccion,
                      ae.id_usuario as id_asesor, CONCAT(ae.nombre, ' ', ae.apellido_paterno, ' ',  ae.apellido_paterno) as asesor,
                      co.id_usuario as id_coordinador, CONCAT(co.nombre, ' ', co.apellido_paterno, ' ',  co.apellido_paterno) as coordinador,
                      ge.id_usuario as id_gerente, CONCAT(ge.nombre, ' ', ge.apellido_paterno, ' ',  ge.apellido_paterno) as gerente,
                      su.id_usuario as id_subdirector, CONCAT(su.nombre, ' ', su.apellido_paterno, ' ',  su.apellido_paterno) as subdirector,
                      di.id_usuario as id_director, CONCAT(di.nombre, ' ', di.apellido_paterno, ' ',  di.apellido_paterno) as director
                      FROM  lotes l
                      INNER JOIN  clientes cl ON cl.id_cliente = l.idCliente AND cl.lugar_prospeccion != 6
                      INNER JOIN  condominios cond ON l.idCondominio=cond.idCondominio
                      INNER JOIN  residenciales res ON cond.idResidencial = res.idResidencial
                      LEFT JOIN  pago_comision pc ON pc.id_lote = l.idLote AND pc.bandera in (0, 1, 55)
                      LEFT JOIN  opcs_x_cats plane ON plane.id_opcion= l.plan_enganche AND plane.id_catalogo = 39
                      LEFT JOIN (SELECT id_cliente FROM ventas_compartidas WHERE estatus = 1) AS vc ON vc.id_cliente = cl.id_cliente
                      INNER JOIN  usuarios ae ON ae.id_usuario = cl.id_asesor
                      LEFT JOIN  usuarios co ON co.id_usuario = ae.id_lider
                      LEFT JOIN  usuarios ge ON ge.id_usuario = cl.id_gerente
                      LEFT JOIN  usuarios su ON su.id_usuario = ge.id_lider
                      LEFT JOIN  usuarios di ON di.id_usuario = su.id_lider
                      WHERE l.idStatusContratacion BETWEEN 9 AND 15 AND cl.status = 1 AND l.status = 1 
                      --AND cl.lugar_prospeccion = 6
                      AND l.registro_comision in (1) AND pc.bandera in (0, 1, 55)
                      AND tipo_venta IS NOT NULL AND tipo_venta IN (1, 2))
                      
                      UNION
                      ( SELECT DISTINCT(l.idLote), l.idStatusContratacion, l.registro_comision, cl.id_cliente, 
                      CONCAT(cl.nombre,' ',cl.apellido_paterno,' ',cl.apellido_materno) nombre_cliente, l.nombreLote, l.idStatusContratacion, 
                      res.nombreResidencial, cond.nombre as nombreCondominio, l.tipo_venta, l.referencia, 
                      vc.id_cliente AS compartida, l.totalNeto, 
                      l.totalNeto2, l.plan_enganche, plane.nombre as enganche_tipo, cl.lugar_prospeccion,
                            ae.id_usuario as id_asesor, CONCAT(ae.nombre, ' ', ae.apellido_paterno, ' ',  ae.apellido_paterno) as asesor,
                            co.id_usuario as id_coordinador, CONCAT(co.nombre, ' ', co.apellido_paterno, ' ',  co.apellido_paterno) as coordinador,
                            ge.id_usuario as id_gerente, CONCAT(ge.nombre, ' ', ge.apellido_paterno, ' ',  ge.apellido_paterno) as gerente,
                            su.id_usuario as id_subdirector, CONCAT(su.nombre, ' ', su.apellido_paterno, ' ',  su.apellido_paterno) as subdirector,
                            di.id_usuario as id_director, CONCAT(di.nombre, ' ', di.apellido_paterno, ' ',  di.apellido_paterno) as director
                            FROM  lotes l
                            INNER JOIN  clientes cl ON cl.id_cliente = l.idCliente AND cl.lugar_prospeccion != 6
                            INNER JOIN  condominios cond ON l.idCondominio=cond.idCondominio
                            INNER JOIN  residenciales res ON cond.idResidencial = res.idResidencial
                            LEFT JOIN  pago_comision pc ON pc.id_lote = l.idLote AND pc.bandera in (0)
                            LEFT JOIN  opcs_x_cats plane ON plane.id_opcion= l.plan_enganche AND plane.id_catalogo = 39
                            LEFT JOIN (SELECT id_cliente FROM ventas_compartidas WHERE estatus = 1) AS vc ON vc.id_cliente = cl.id_cliente
                            INNER JOIN  usuarios ae ON ae.id_usuario = cl.id_asesor
                            LEFT JOIN  usuarios co ON co.id_usuario = ae.id_lider
                            LEFT JOIN  usuarios ge ON ge.id_usuario = cl.id_gerente
                            LEFT JOIN  usuarios su ON su.id_usuario = ge.id_lider
                            LEFT JOIN  usuarios di ON di.id_usuario = su.id_lider
                            WHERE l.idStatusContratacion BETWEEN 9 AND 15 AND cl.status = 1 AND l.status = 1 
                            --AND cl.lugar_prospeccion = 6
                            AND l.registro_comision in (0, 8) 
                            AND tipo_venta IS NOT NULL AND tipo_venta IN (1, 2) 
                            AND (cl.fechaApartado >= '2020-03-01' OR l.idLote in(31907, 35863, 36603, 36603, 32575,45694,22741, 28434, 
                            24576, 24577,35697,25218,31684,41032,34191,34141, 40635,36483,38927, 33931, 19523, 32101, 16406, 36617, 
                            36618, 13334, 13615) )) ORDER BY l.idLote");
        return $query->result();
    }

    public function addRecord($table, $data) // MJ: AGREGA UN REGISTRO A UNA TABLA EN PARTICULAR, RECIBE 2 PAR??METROS. LA TABLA Y LA DATA A INSERTAR
    {
        if ($data != '' && $data != null) {
            $response = $this->db->insert($table, $data);
            if (!$response) {
                return $finalAnswer = 0;
            } else {
                return $finalAnswer = 1;
            }
        } else {
            return 0;
        }
    }

    public function updateRecord($table, $data, $key, $value) // MJ: ACTUALIZA LA INFORMACI??N DE UN REGISTRO EN PARTICULAR, RECIBE 4 PAR??METROS. TABLA, DATA A ACTUALIZAR, LLAVE (WHERE) Y EL VALOR DE LA LLAVE
    {
        $response = $this->db->update($table, $data, "$key = '$value'");
        if (!$response) {
            return $finalAnswer = 0;
        } else {
            return $finalAnswer = 1;
        }
    }

    public function deleteRecord($table, $key, $value) // MJ: ELIMINA UN REGISTRO EN PARTICULAR, RECIBE 2 PAR??METROS. TABLA, LLAVE (WHERE) Y EL VALOR DE LA LLAVE
    {
        $response = $this->db->query("DELETE FROM $table WHERE $key = $value");
        if (!$response) {
            return $finalAnswer = 0;
        } else {
            return $finalAnswer = 1;
        }
    }

    public function getLoteInformation($id_lote){
        return $this->db-> query("SELECT l.idLote, l.nombre_lote, l.totalNeto2, l.idCliente FROM lotes l
        INNER JOIN clientes c ON c.id_cliente = l.idCliente AND c.status = 1
        WHERE l.idLote = $id_lote")->result_array();
    }

    public function getIndividualPaymentInformation($id_lote, $id_usuario){
        return $this->db-> query("SELECT id_comision, SUM(abono_neodata) abonado FROM pago_comision_ind WHERE id_comision IN (SELECT id_comision 
        FROM comisiones WHERE id_lote IN ($id_lote)) AND id_usuario = $id_usuario AND estatus IN (8, 11, 13) GROUP BY id_comision;")->result_array();
    }

    public function getIndividualPaymentWPInformation($id_lote, $id_usuario){
        return $this->db-> query("SELECT * FROM pago_comision_ind WHERE id_comision IN (SELECT id_comision FROM comisiones 
        WHERE id_lote IN ($id_lote)) AND id_usuario = $id_usuario AND estatus NOT IN (8, 11, 13);")->result_array();
    }

    public function getComissionformation($id_lote, $id_usuario, $id_rol){
        return $this->db-> query("SELECT * FROM comisiones WHERE id_lote = $id_lote AND id_usuario = $id_usuario AND rol_generado = $id_rol")->result_array();
    }


    
    public function get_solicitudes_factura( $idResidencial, $id_usuario ){

            if( $this->session->userdata('id_rol') == 31 ){
        $filtro = "WHERE pci1.estatus IN (8,88) ";
      }
      else{
        $filtro = "WHERE pci1.estatus IN (4) ";
      }


        // echo $idResidencial;
        // echo $id_usuario;
        return $this->db->query("SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote as lote, re.nombreResidencial as proyecto,  lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, 
        pci1.abono_neodata pago_cliente, pci1.pago_neodata, /*pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, */pci1.estatus, pci1.fecha_pago_intmex fecha_creacion,
        CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario ,pci1.id_usuario, oprol.nombre as puesto, cl.personalidad_juridica, u.forma_pago, 0 as factura, pac.porcentaje_abono, 
        oxcest.nombre as estatus_actual, oxcest.id_opcion id_estatus_actual, re.empresa, cl.lugar_prospeccion, co.nombre as condominio, lo.referencia
                         FROM pago_comision_ind pci1 
                        /* LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE estatus in (11) 
                         GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision*/
                         INNER JOIN comisiones com ON pci1.id_comision = com.id_comision AND com.estatus in (1,8)
                         INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
                         INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                         INNER JOIN residenciales re ON re.idResidencial = co.idResidencial AND re.idResidencial = $idResidencial
                         INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 1
                         INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (2)
                         INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
                         INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                         INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
                         $filtro AND u.id_usuario = $id_usuario
                         GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial,  lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata,  
                         pci1.pago_neodata, /*pci2.abono_pagado, */pci1.estatus, pci1.fecha_pago_intmex, pci1.id_usuario, cl.personalidad_juridica, u.forma_pago, pci1.id_pago_i,
                         pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion, re.empresa, cl.lugar_prospeccion,
                         co.nombre, lo.referencia ORDER BY lo.nombreLote")->result_array();
    }

    function update_estatus_edit($id_pago_i, $obs) {

        $id_user_Vl = $this->session->userdata('id_usuario');
        $this->db->query("INSERT INTO historial_comisiones VALUES ($id_pago_i, $id_user_Vl, GETDATE(), 1, 'ACTUALIZ?? CONTRALORIA CON NUEVO MONTO: ".$obs."')");
        return $this->db->query("UPDATE pago_comision_ind SET abono_neodata = '".$obs."' WHERE id_pago_i IN (".$id_pago_i.")");
      }
    

    function update_estatus_intmex($id_pago_i, $obs) {

        $id_user_Vl = $this->session->userdata('id_usuario');
        $this->db->query("INSERT INTO historial_comisiones VALUES ($id_pago_i, $id_user_Vl, GETDATE(), 1, 'ACTUALIZ?? CONTRALORIA CON NUEVO MONTO: ".$obs."')");
        return $this->db->query("UPDATE pago_comision_ind SET abono_neodata = '".$obs."' WHERE id_pago_i IN (".$id_pago_i.")");
      }
    



    
    
     // $this->db->query("INSERT INTO pago_comision_ind (id_comision, id_usuario, abono_neodata, fecha_abono, fecha_pago_intmex, estatus, pago_neodata, comentario, modificado_por) VALUES (".$insert_id.", ".$id_usuario.", ".$abono.",  GETDATE(),  GETDATE(), 1 , ".$pago.", 'PAGO 1 - NEDOATA', $user)");
    
       function update_estatus_add($id_pago_i, $obs) {
    
        $id_user_Vl = $this->session->userdata('id_usuario');
        $QUERY_VAL = $this->db->query("SELECT id_usuario, id_comision FROM pago_comision_ind WHERE id_pago_i IN (".$id_pago_i.")");
        $comision = $QUERY_VAL->row()->id_comision;
        $user_com = $QUERY_VAL->row()->id_usuario;
    
        // echo $comision.'<br>';
        return $this->db->query( "INSERT INTO pago_comision_ind VALUES (".$comision.", ".$user_com.", ".$obs.",  GETDATE(), GETDATE(), 0, 11, 1, 'IMPORTACI??N EXTEMPORANEA', NULL, NULL, NULL)");
    
        $insert_id = $this->db->insert_id();
    
        $this->db->query("INSERT INTO  historial_comisiones VALUES ($insert_id, $id_user_Vl, GETDATE(), 1, 'SE AGREGA POR CONTRALORIA CON MONTO: ".$obs."')");
    
      }


      // update_estatus_intmex


      /**-----------------------MKTD COMPARTIDAS---------------------- */
    public function MKTD_compartida($lote,$p1,$p2,$user)
    {
        $respuesta = $this->db->query("INSERT INTO compartidas_mktd VALUES ($lote,$p1,$p2, GETDATE(),$user)");


        if ($respuesta ) {
            return 1;
        } else {
            return 0;
        }
    }
    public function VerificarMKTD($idlote)
        {
       return $query =  $this->db->query("SELECT * FROM comisiones co inner join pago_comision_ind pci on co.id_comision=pci.id_comision where pci.estatus != 12 and pci.id_usuario=4394 and co.id_lote=".$idlote."
         ");
        }





   function getDatosNuevasCompartidas(){

    $filtro = " AND cl.id_asesor IN (SELECT id_usuario FROM usuarios WHERE id_sede IN (1,2,3,4,5,6) AND id_rol IN (7,9))  ";

    return $this->db->query(" SELECT pci.id_usuario, lo.ubicacion_dos, plm.id_plan, s.nombre as sede, us.nombre, us.apellido_paterno, SUM(pci.abono_neodata) total, res.empresa, res.idResidencial, CAST(res.descripcion AS VARCHAR(MAX)) descripcion, 
 cmktd.sede1, cmktd.sede2, s1.nombre as s1, s2.nombre as s2
                               FROM pago_comision_ind pci 
                               INNER JOIN comisiones com ON com.id_comision = pci.id_comision
                               INNER JOIN lotes lo ON lo.idLote = com.id_lote
                               INNER JOIN condominios con ON con.idCondominio = lo.idCondominio
                               INNER JOIN residenciales res ON res.idResidencial = con.idResidencial
                               INNER JOIN clientes cl ON cl.id_cliente = lo.idCliente
                               INNER JOIN planes_mktd plm ON plm.fecha_plan <= cl.fechaApartado AND plm.fin_plan >= cl.fechaApartado
                               INNER JOIN sedes s ON s.id_sede = lo.ubicacion_dos
                               INNER JOIN usuarios us ON us.id_usuario = pci.id_usuario
                               INNER JOIN compartidas_mktd cmktd on com.id_lote=cmktd.id_lote
                               INNER JOIN sedes s1 on s1.id_sede=cmktd.sede1 
                               INNER JOIN sedes s2 on s2.id_sede=cmktd.sede2
                               WHERE pci.estatus IN (1, 41, 42, 51, 52, 61, 62, 12) AND lo.idLote IN (select id_lote from reportes_marketing WHERE estatus = 1 AND dispersion = 1) AND pci.id_usuario = 4394
                               AND lo.status = 1
                               AND cl.status = 1
                               AND cl.id_asesor IN (SELECT id_usuario FROM usuarios WHERE id_sede IN (1,2,3,4,5,6) AND id_rol IN (7,9))

                               GROUP BY plm.id_plan, res.empresa, pci.id_usuario, lo.ubicacion_dos, s.nombre, us.nombre, us.apellido_paterno, res.idResidencial, CAST(res.descripcion AS VARCHAR(MAX)),
                                cmktd.sede1, cmktd.sede2, s1.nombre, s2.nombre
                               ORDER by plm.id_plan");
                               

   }

 
    /**--------------------------------------------------------- */
      /**----------resguardos-------------------------------------- */
      function getDisponbleResguardo($user) {
        $query = $this->db->query("select SUM(abono_neodata) as suma from pago_comision_ind where id_usuario=$user and estatus=3");
        return $query;
    }
    function getDisponbleExtras($user) {
        $query = $this->db->query("select SUM(monto) as extras from resguardo_conceptos where id_usuario=$user and estatus in(67)");
        return $query;
    }
    function getAplicadoResguardo($user) {
        $query = $this->db->query("select SUM(monto) as aplicado from resguardo_conceptos where id_usuario=$user and estatus in(1,2)");
        return $query;
    }
    function getRetiros($user,$opc){
       $query = '';
        if($opc == 2){
            $query = 'AND rc.estatus in(67)';
        }

        return $this->db->query("SELECT rc.id_rc,CONCAT(us.nombre,' ',us.apellido_paterno,' ',us.apellido_materno) AS usuario,rc.monto,rc.conceptos,rc.fecha_creacion,rc.estatus,CONCAT(u2.nombre,' ',u2.apellido_paterno,' ',u2.apellido_materno) AS creado_por,rc.estatus from usuarios us inner join resguardo_conceptos rc on rc.id_usuario=us.id_usuario inner join usuarios u2 on u2.id_usuario=rc.creado_por where rc.id_usuario=$user $query");
       
   }
   function insertar_retiro($usuarioid,$monto,$comentario,$usuario,$opc){
 $estatus = 1;
 $adicional = 'SE INGRES?? RETIRO ';
if($opc == 2){
    $adicional = 'SE AGREG?? UN INGRESO EXTRA ';
$estatus = 67;
}
    $respuesta = $this->db->query("INSERT INTO resguardo_conceptos VALUES ($usuarioid, $monto,'$comentario', $usuario,$estatus, GETDATE())");
    $insert_id_2 = $this->db->insert_id();
    $respuesta = $this->db->query("INSERT INTO  historial_retiros VALUES ($insert_id_2, ".$this->session->userdata('id_usuario').", GETDATE(), 1, '$adicional POR MOTIVO DE: $comentario POR LA CANTIDAD DE: $monto')");

    if (! $respuesta ) {
        return 0;
        } else {
        return 1;
        }
}
function UpdateRetiro($datos,$id,$opcion){

    $motivo = '';
    if($opcion == 'Borrar' ||  $opcion == 'Rechazar' ){
$motivo = $datos['motivodel'];
        $datos = ['estatus' => $datos['estatus']];
    }

    //echo $datos['monto'];
    $comentario = '';
    $respuesta = $this->db->update("resguardo_conceptos", $datos, " id_rc = $id");
    if($opcion == 'Autorizar'){
        $comentario = 'SE AUTORIZ?? ESTE RETIRO';
       
      }elseif($opcion == 'Borrar'){
        $comentario = 'SE ELIMIN?? ESTE RETIRO, MOTIVO: '.$motivo;

      }elseif($opcion == 'Rechazar'){
        $comentario = 'SE RECHAZ?? ESTE RETIRO, MOTIVO: '.$motivo;

      }elseif($opcion == 'Actualizar'){
        $comentario = 'SE ACTUALIZ?? RETIRO POR MOTIVO DE: '.$datos["conceptos"].' POR LA CANTIDAD DE: '.$datos["monto"].' ';

      }
   // $respuesta = $this->db->query("UPDATE pago_comision_ind SET estatus = 12 WHERE estatus = 100 AND descuento_aplicado = 1 AND id_pago_i = $id_bono");
    $respuesta = $this->db->query("INSERT INTO  historial_retiros VALUES ($id, ".$this->session->userdata('id_usuario').", GETDATE(), 1, '$comentario')");

    if (! $respuesta ) {
    return 0;
    } else {
    return 1;
    }
    }


    function getHistoriRetiros($id) {
        $query = $this->db->query("SELECT r.*,CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario  from historial_retiros r inner join usuarios u on u.id_usuario=r.id_usuario where id_retiro=$id");
        return $query;
    }
    /*--------------------------------------*/
/**--------------PRECIO LOTE MKTD------------------------------------- */
function getPrecioMKTD($lote) {
    $query = $this->db->query("select * from reportes_marketing where id_lote=$lote");
    return $query;
}
public function insert_MKTD_precioL($lote,$precio,$user)
{
    $respuesta = $this->db->query("INSERT INTO reportes_marketing VALUES ($lote,$precio,0,1,$user,GETDATE())");

    if ($respuesta ) {
        return 1;
    } else {
        return 0;
    }
}
public function Update_MKTD_precioL($lote,$precio,$user)
{
    $respuesta = $this->db->query("UPDATE reportes_marketing SET precio=".$precio.",creado_por=$user,fecha_creacion=GETDATE() WHERE id_lote=".$lote."");

    if ($respuesta ) {
        return 1;
    } else {
        return 0;
    }
}






 function getDatosColabMktdCompartida($sede, $PLAN,$sede1,$sede2){
 

    if($PLAN == '9'|| $PLAN == 9 ){

 
        $filtro_009 = " SELECT pk.id_plan, pk.fecha_plan, getdate() as fin_plan, u.id_usuario, CONCAT(u.nombre,' ' ,u.apellido_paterno,' ',u.apellido_materno) AS colaborador, op1.nombre AS rol, pcm.porcentaje, u.id_sede, op1.id_opcion, 
             (CASE op1.id_opcion WHEN '18' THEN 1 WHEN '10' THEN 2 WHEN '19' THEN 3 WHEN '37' THEN 4 WHEN '25 ' THEN 5 WHEN '29' THEN 6 WHEN '30' THEN 7 WHEN '20' THEN 8  ELSE op1.id_opcion END) as rol_dos,'0' as valor
            FROM planes_mktd pk 
            INNER JOIN porcentajes_mktd pcm ON pcm.numero_plan = pk.id_plan 
            INNER JOIN usuarios u ON u.id_usuario = pcm.id_usuario 
            INNER JOIN opcs_x_cats op1 ON op1.id_opcion = pcm.rol 
            WHERE op1.id_catalogo = 1 AND pcm.rol NOT IN (19, 20, 28)  ";

    }
    else{
         $filtro_009 = " SELECT pk.id_plan, pk.fecha_plan, getdate() as fin_plan, u.id_usuario, CONCAT(u.nombre,' ' ,u.apellido_paterno,' ',u.apellido_materno) AS colaborador, op1.nombre AS rol, pcm.porcentaje, u.id_sede, op1.id_opcion, (CASE op1.id_opcion WHEN '18' THEN 1 WHEN '10' THEN 2 WHEN '19' THEN 3 WHEN '37' THEN 4 WHEN '25 ' THEN 5 WHEN '29' THEN 6 WHEN '30' THEN 7 WHEN '20' THEN 8 WHEN '28' THEN 9 ELSE op1.id_opcion END) as rol_dos,'0' as valor
            FROM planes_mktd pk 
            INNER JOIN porcentajes_mktd pcm ON pcm.numero_plan = pk.id_plan 
            INNER JOIN usuarios u ON u.id_usuario = pcm.id_usuario 
            INNER JOIN opcs_x_cats op1 ON op1.id_opcion = pcm.rol 
            WHERE op1.id_catalogo = 1 AND pcm.rol NOT IN (19, 20) AND pk.id_plan = $PLAN) ";
    }


     if($PLAN == '7'||$PLAN == 7){

        $filtro_003 = " ((pcm.rol IN (19) AND (u.id_sede LIKE '%$sede1%' OR u.id_sede LIKE '%$sede2%') ) OR (pcm.id_usuario = 1981 AND id_plaza = 2))  ";

    }
    else{
         $filtro_003 = " pcm.rol IN (19) AND (u.id_sede LIKE '%$sede1%' OR u.id_sede LIKE '%$sede2%')  ";
    }

     return $this->db->query("( $filtro_009

            UNION 

            (SELECT pk.id_plan, pk.fecha_plan, getdate() as fin_plan, u.id_usuario, CONCAT(u.nombre,' ' ,u.apellido_paterno,' ',u.apellido_materno) AS colaborador, op1.nombre AS rol, pcm.porcentaje, u.id_sede, op1.id_opcion, (CASE op1.id_opcion WHEN '18' THEN 1 WHEN '19' THEN 2 WHEN '20 ' THEN 3 WHEN '25' THEN 4 ELSE op1.id_opcion END) as rol_dos,'0' as valor 
            FROM planes_mktd pk 
            INNER JOIN porcentajes_mktd pcm ON pcm.numero_plan = pk.id_plan 
            INNER JOIN usuarios u ON u.id_usuario = pcm.id_usuario 
            INNER JOIN opcs_x_cats op1 ON op1.id_opcion = pcm.rol
            WHERE op1.id_catalogo = 1 AND pcm.rol IN (20) AND pcm.id_sede IN ($sede1,$sede2) AND pk.id_plan = $PLAN) 

            UNION 

            (SELECT pk.id_plan, pk.fecha_plan, getdate() as fin_plan, u.id_usuario, CONCAT(u.nombre,' ' ,u.apellido_paterno,' ',u.apellido_materno) AS colaborador, op1.nombre AS rol, pcm.porcentaje, u.id_sede, op1.id_opcion, (CASE op1.id_opcion WHEN '18' THEN 1 WHEN '19' THEN 2 WHEN '20 ' THEN 3 WHEN '25' THEN 4 ELSE op1.id_opcion END) as rol_dos,'0' as valor 
            FROM planes_mktd pk 
            INNER JOIN porcentajes_mktd pcm ON pcm.numero_plan = pk.id_plan 
            INNER JOIN usuarios u ON u.id_usuario = pcm.id_usuario 
            INNER JOIN opcs_x_cats op1 ON op1.id_opcion = pcm.rol 
            WHERE op1.id_catalogo = 1 AND  $filtro_003 and pk.id_plan = $PLAN) order by rol_dos");
    
     }


 

/**---------------------------------------------------------- */
 /**----------------------------RESGUARDO------------------------------ */
 function get_lote_lista($condominio){
    return $this->db->query("SELECT * FROM lotes WHERE status = 1 and statuscontratacion BETWEEN 9 AND 15 and regristro_comision=0  AND idCondominio = ".$condominio." AND idCliente in (SELECT idCliente FROM clientes) AND (idCliente <> 0 AND idCliente <>'') ");
}

public function Update_lote_reubicacion($idloteNuevo,$idloteAnterior,$precioNuevo,$user,$comentario)
{
    $respuesta = $this->db->query("UPDATE comisiones set comision_total=((porcentaje_decimal/100)*$precioNuevo),id_lote=$idloteNuevo  where id_lote=$idloteAnterior");
    $respuesta = $this->db->query("UPDATE lotes set registro_comision=0  where idLote=$idloteAnterior");
    $respuesta = $this->db->query("UPDATE lotes set registro_comision=1  where idLote=$idloteNuevo");


    if ($respuesta ) {
       // return 1;
       $respuesta = $this->db->query("UPDATE pago_comision set id_lote=$idloteNuevo  where id_lote=$idloteAnterior");
       $query = $this->db->query("select id_pago_i  from pago_comision_ind where id_comision in(select id_comision from comisiones where id_lote=$idloteNuevo)")->result_array();
       if($respuesta){

        for ($i=0; $i <count($query); $i++) { 
            $this->db->query("INSERT INTO  historial_comisiones VALUES (".$query[$i]['id_pago_i'].",$user, GETDATE(), 1,'$comentario')");

        }
        return 1;
       }else{

       }

    } else {
        return 0;
    }   
}
function getComisionesLoteSelected($idLote){
    return $this->db->query("SELECT * FROM comisiones where id_lote=$idLote");
}
function getBonosPorUser($id,$estado){

    $cadena = 'p.id_usuario='.$id.' AND';
    if($this->session->userdata('id_rol') == 32){
$cadena = 'u.estatus=0 AND';
    }
    return $this->db->query("SELECT CONCAT(u.nombre, ' ', u.apellido_paterno, ' ' ,u.apellido_materno) as nombre,
    opcs.nombre as id_rol,p.id_bono,p.id_usuario,p.monto,p.num_pagos,p.pago,p.estatus,p.comentario,
    b.fecha_abono,b.estado,b.id_pago_bono,b.abono,b.n_p,
    (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*p.pago) ELSE p.pago END) impuesto1,sed.impuesto
    FROM bonos p INNER JOIN usuarios u ON u.id_usuario=p.id_usuario 
    INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = u.forma_pago AND oxc.id_catalogo = 16
     LEFT JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario 
                 WHEN 2 THEN 2 
                 WHEN 3 THEN 2 
                 WHEN 1980 THEN 2 
                 WHEN 1981 THEN 2 
                 WHEN 1982 THEN 2 
                 WHEN 1988 THEN 2 
                 WHEN 4 THEN 5
                 WHEN 5 THEN 3
                 WHEN 607 THEN 1 
                 ELSE u.id_sede END) and sed.estatus = 1
    INNER JOIN pagos_bonos_ind b on b.id_bono=p.id_bono
    inner join opcs_x_cats opcs on opcs.id_opcion=u.id_rol WHERE $cadena b.estado=$estado and opcs.id_catalogo=1");
}

/*--------------planes-----------*/

function getDatosNuevo(){

    $consult =  $this->db->query("SELECT max(id_plan) as last_id FROM planes_mktd");

    return $this->db->query("SELECT u.id_usuario, CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) usuario, u.id_rol, u.id_sede,  rol.nombre as puesto
    FROM usuarios u INNER JOIN opcs_x_cats rol ON rol.id_opcion = u.id_rol WHERE(u.id_lider in (SELECT us.id_usuario FROM usuarios us WHERE us.id_rol IN (18,19)) OR u.id_usuario IN (1980)) AND rol.id_catalogo = 1 
    ORDER BY u.id_rol");
}
function getPlazasMk(){
    return $this->db->query("SELECT id_opcion, nombre FROM opcs_x_cats WHERE id_catalogo = 36");
} 

function getSedeMk(){
    return $this->db->query("SELECT id_sede, nombre FROM sedes WHERE estatus = 1");
} 
/**----------------------------- */



function getMontoDispersado(){
    return $this->db->query("SELECT SUM(abono_neodata) monto FROM pago_comision_ind WHERE id_comision IN (select id_comision from comisiones) AND MONTH(GETDATE()) = MONTH(fecha_abono) AND Day(GetDate()) = Day(fecha_abono)");
}


function getPagosDispersado(){
    return $this->db->query("SELECT count(id_pago_i) pagos FROM pago_comision_ind WHERE id_comision IN (select id_comision from comisiones) AND MONTH(GETDATE()) = MONTH(fecha_abono) AND Day(GetDate()) = Day(fecha_abono) AND abono_neodata>0");
}

function getLotesDispersado(){
    return $this->db->query("SELECT count(distinct(id_lote)) lotes FROM comisiones WHERE id_comision IN (select id_comision from pago_comision_ind WHERE MONTH(GETDATE()) = MONTH(fecha_abono) AND Day(GetDate()) = Day(fecha_abono) AND id_comision IN (SELECT id_comision FROM comisiones))");
  }



function getMontoDispersadoDates($fecha1, $fecha2){
    return $this->db->query("SELECT SUM(abono_neodata) monto FROM pago_comision_ind WHERE id_comision IN (select id_comision from comisiones) AND CAST(fecha_abono as date) >= CAST('$fecha1' AS date) AND CAST(fecha_abono as date) <= CAST('$fecha2' AS date) ");
}


function getPagosDispersadoDates($fecha1, $fecha2){
    return $this->db->query("SELECT count(id_pago_i) pagos FROM pago_comision_ind WHERE id_comision IN (select id_comision from comisiones) AND CAST(fecha_abono as date) >= CAST('$fecha1' AS date) AND CAST(fecha_abono as date) <= CAST('$fecha2' AS date) AND abono_neodata>0");
}

function getLotesDispersadoDates($fecha1, $fecha2){
    return $this->db->query("SELECT count(distinct(id_lote)) lotes FROM comisiones WHERE id_comision IN (select id_comision from pago_comision_ind WHERE CAST(fecha_abono as date) >= CAST('$fecha1' AS date) AND CAST(fecha_abono as date) <= CAST('$fecha2' AS date) AND id_comision IN (SELECT id_comision FROM comisiones))");
  }


  function get_proyectos_comisiones($filtro_post){

    return $this->db->query("SELECT DISTINCT(res.idResidencial), CAST(res.descripcion AS VARCHAR(MAX)) AS descripcion FROM residenciales res WHERE res.status = 1 AND res.active_comission = 1 ORDER BY res.idResidencial");
     }


    public function get_condominios_comisiones($filtro_post){

        return $this->db->query("SELECT DISTINCT(con.idCondominio), CAST(con.nombre AS VARCHAR(MAX)) AS nombre FROM condominios con
        INNER JOIN lotes lot ON lot.idCondominio = con.idCondominio
        INNER JOIN comisiones com ON com.id_lote = lot.idLote
        INNER JOIN pago_comision_ind pci ON pci.id_comision = com.id_comision $filtro_post ORDER BY CAST(con.nombre AS VARCHAR(MAX))");
         }
    

   public  function get_lista_roles(){

    return $this->db->query("SELECT id_opcion AS idResidencial, nombre AS descripcion FROM opcs_x_cats WHERE id_catalogo = 1 and id_opcion in (3,9,7) ORDER BY nombre");
     }


     public  function get_lista_sedes(){

     if( $this->session->userdata('id_usuario') == 2042 ){
        $filtro = " 2,3,4,6 ";
      }
      else{
         $filtro = " 1,5 ";
      }

    return $this->db->query("SELECT id_sede AS idResidencial, nombre AS descripcion FROM sedes WHERE id_sede in ($filtro) ORDER BY nombre");
     }


   public  function get_lista_usuarios($rol, $forma_pago){

    return $this->db->query("SELECT id_usuario AS idCondominio, CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_paterno) AS nombre FROM usuarios WHERE id_usuario in (SELECT id_usuario FROM pago_comision_ind WHERE estatus in (8,88)) AND id_rol = $rol AND forma_pago = $forma_pago ORDER BY nombre");
     }

     public function getCommisionInformation($id_lote){
        return $this->db-> query("SELECT * FROM comisiones WHERE id_lote IN ($id_lote)")->result_array();
    }


    
    

function getDatosHistorialPagado($anio,$mes){

 if($mes == 0){
            $filtro = '  AND YEAR(pci1.aply_pago_intmex) = '.$anio.' ';
        }else{
             $filtro = '  AND MONTH(pci1.aply_pago_intmex) = '.$mes.' AND YEAR(pci1.aply_pago_intmex) = '.$anio.'';
        }

return $this->db-> query("
(SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote, re.nombreResidencial as proyecto, co.nombre as condominio,lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, 
pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, pci1.estatus, pci1.fecha_abono fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) user_names ,
pci1.id_usuario, oprol.nombre as puesto, u.forma_pago, 0 as factura, pac.porcentaje_abono, oxcest.nombre as estatus_actual, oxcest.id_opcion id_estatus_actual, pci1.descuento_aplicado, 0 lugar_prospeccion,
com.estatus estado_comision, pac.bonificacion, u.estatus as activo, pci1.fecha_pago_intmex, pci1.aply_pago_intmex

, 0 fechaApartado, 'NA' plaza, lo.idLote

                     FROM pago_comision_ind pci1 
                     LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE estatus in (11) 
                     GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
                     INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                     INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
                     INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                     INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
                     INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
                     INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
                     INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                     INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23
                     WHERE pci1.estatus = 11 AND pci1.id_usuario = 4394 $filtro
                     AND ( (lo.idStatusContratacion < 9 AND com.estatus IN (1,8)) OR (lo.idStatusContratacion > 8 AND com.estatus IN (8))) 
                     GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial, co.nombre, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, 
                     pci2.abono_pagado, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre,
                     u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion,  pci1.descuento_aplicado, com.estatus, pac.bonificacion, u.estatus, 
                     pci1.fecha_pago_intmex, pci1.aply_pago_intmex, lo.idLote)
                 UNION 
         
                 (SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote, re.nombreResidencial as proyecto, co.nombre as condominio,lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal,
                 pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, pci1.estatus, pci1.fecha_abono fecha_creacion,
                 CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) user_names ,pci1.id_usuario, oprol.nombre as puesto,  u.forma_pago, 0 as factura, pac.porcentaje_abono, 
                 oxcest.nombre as estatus_actual, oxcest.id_opcion id_estatus_actual, pci1.descuento_aplicado, cl.lugar_prospeccion,com.estatus estado_comision, 
                 pac.bonificacion, u.estatus as activo, pci1.fecha_pago_intmex, pci1.aply_pago_intmex, cl.fechaApartado, CAST(se.nombre AS VARCHAR(MAX)) plaza, lo.idLote
                     FROM pago_comision_ind pci1 
                     LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE estatus in (11) 
                     GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
                     INNER JOIN comisiones com ON pci1.id_comision = com.id_comision AND com.estatus in (1)
                     INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
                     INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                     INNER JOIN residenciales re ON re.idResidencial = co.idResidencial 
                     INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 1
                     INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
                     INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
                     INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                     INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23
                     LEFT JOIN usuarios as asesor ON asesor.id_usuario = cl.id_asesor
                     LEFT JOIN sedes se ON se.id_sede = asesor.id_sede and asesor.id_sede like cast(asesor.id_sede as varchar(max))
                     WHERE pci1.estatus = 11 AND pci1.id_usuario = 4394 $filtro 
                     AND lo.idStatusContratacion > 8 

                     GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial, co.nombre, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, 
                     pci1.estatus, pci1.fecha_abono, pci1.id_usuario, u.forma_pago, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, 
                     oxcest.id_opcion,  pci1.descuento_aplicado, cl.lugar_prospeccion, com.estatus, pac.bonificacion, u.estatus, pci1.fecha_pago_intmex, pci1.aply_pago_intmex,
                     cl.fechaApartado, se.nombre , lo.idLote) ORDER BY lo.nombreLote");
     
     }




function getDatosHistorialDU($anio,$mes){

 if($mes == 0){
            $filtro = '  AND YEAR(pci1.fecha_pago_intmex) = '.$anio.' ';
        }else{
             $filtro = '  AND MONTH(pci1.fecha_pago_intmex) = '.$mes.' AND YEAR(pci1.fecha_pago_intmex) = '.$anio.'';
        }

return $this->db-> query("(SELECT pci1.id_pago_i, lo.nombreLote, re.empresa, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) user_names, 
pci1.fecha_pago_intmex, pci1.id_usuario, oprol.nombre as puesto, pci1.abono_neodata, se.nombre, pci1.abono_neodata, 
CONCAT(cr.nombre, ' ',cr.apellido_paterno, ' ', cr.apellido_materno) creado
FROM pago_comision_ind pci1
INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
INNER JOIN usuarios cr ON cr.id_usuario = pci1.modificado_por
INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
LEFT JOIN sedes se ON se.id_sede = u.id_sede AND se.estatus = 1
WHERE pci1.estatus = 17 $filtro
AND ((lo.idStatusContratacion < 9 AND com.estatus IN (1,8)) OR (lo.idStatusContratacion > 8 AND com.estatus IN (8))) 
GROUP BY pci1.id_pago_i, lo.nombreLote, re.empresa, u.nombre, u.apellido_paterno, u.apellido_materno, pci1.id_usuario, oprol.nombre, 
pci1.abono_neodata, se.nombre, pci1.abono_neodata, cr.nombre,  cr.apellido_paterno, cr.apellido_materno, pci1.fecha_pago_intmex )

UNION 
(SELECT pci1.id_pago_i, lo.nombreLote, re.empresa, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) user_names, 
pci1.fecha_pago_intmex,pci1.id_usuario, oprol.nombre as puesto, pci1.abono_neodata, se.nombre, pci1.abono_neodata, 
CONCAT(cr.nombre, ' ',cr.apellido_paterno, ' ', cr.apellido_materno) creado
FROM pago_comision_ind pci1 
INNER JOIN comisiones com ON pci1.id_comision = com.id_comision AND com.estatus in (1)
INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1
INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
INNER JOIN residenciales re ON re.idResidencial = co.idResidencial 
INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 1
INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
INNER JOIN usuarios cr ON cr.id_usuario = pci1.modificado_por
INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
LEFT JOIN sedes se ON se.id_sede = u.id_sede AND se.estatus = 1
WHERE pci1.estatus = 17 $filtro
AND lo.idStatusContratacion > 8 
GROUP BY pci1.id_pago_i, lo.nombreLote, re.empresa, u.nombre, u.apellido_paterno, u.apellido_materno, pci1.id_usuario, oprol.nombre, 
pci1.abono_neodata, se.nombre, pci1.abono_neodata, cr.nombre, cr.apellido_paterno, cr.apellido_materno, pci1.fecha_pago_intmex ) ");
     
     }

     

     

     
     /**---------------------FACTURAS------------------------------- */

     

function RegresarFactura($uuid,$motivo){
    $datos =  $this->db->query("select id_factura,total,id_comision from facturas where uuid='$uuid'")->result_array();

    for ($i=0; $i <count($datos); $i++) { 
        $comentario = 'Se regres?? esta factura que correspondo al pago con id '.$datos[$i]['id_comision'].' con el monto global de '.$datos[$i]['total'].' por motivo de: '.$motivo.' ';
        $response = $this->db->query("UPDATE facturas set total=0,id_comision=0,bandera=2,descripcion='$comentario'  where id_factura=".$datos[$i]['id_factura']."");
       $respuesta = $this->db->query("INSERT INTO  historial_comisiones VALUES (".$datos[$i]['id_comision'].", ".$this->session->userdata('id_usuario').", GETDATE(), 1, '".$comentario."')");
    }

    return $respuesta;
} 

public function BanderaPDF($uuid)
{
    $respuesta = $this->db->query("UPDATE facturas set bandera=3 where uuid='".$uuid."'");

    if ($respuesta ) {
        return 1;
    } else {
        return 0;
    }
}


function update_estatus_pausaM($id_pago_i, $obs) {

    $id_user_Vl = $this->session->userdata('id_usuario');
    $this->db->query("INSERT INTO  historial_comisiones VALUES ($id_pago_i, $id_user_Vl, GETDATE(), 1, 'SE PAUS?? COMISI??N, MOTIVO: ".$obs."')");
    $respuesta =  $this->db->query("UPDATE pago_comision_ind SET estatus = 6, comentario = '".$obs."' WHERE id_pago_i IN (".$id_pago_i.")");

     $row = $this->db->query("SELECT uuid FROM facturas WHERE id_comision = ".$id_pago_i.";")->result_array();
     if(count($row) > 0){

     
        $datos =  $this->db->query("select id_factura,total,id_comision,bandera from facturas where uuid='".$row[0]['uuid']."'")->result_array();
   
       for ($i=0; $i <count($datos); $i++) { 
               if($datos[$i]['bandera'] == 1){
                   $respuesta = 1;
               }else{
                   $comentario = 'Se regres?? esta factura que correspondo al pago con id '.$datos[$i]['id_comision'].' con el monto global de '.$datos[$i]['total'].' por motivo de: '.$obs.' ';
                   $response = $this->db->query("UPDATE facturas set total=0,bandera=1,descripcion='$comentario'  where id_factura=".$datos[$i]['id_factura']."");
                  $respuesta = $this->db->query("INSERT INTO  historial_comisiones VALUES (".$datos[$i]['id_comision'].", ".$this->session->userdata('id_usuario').", GETDATE(), 1, '".$comentario."')");
               }
   
         
       }
   }

    return $respuesta;

  }



  function GetPagosFacturas($uuid){
    return $this->db->query("SELECT id_comision,id_factura FROM facturas where uuid='".$uuid."'");
} 
function update_refactura( $id_comision, $datos_factura,$id_usuario,$id_factura){
    $VALOR_TEXT = $datos_factura['textoxml'];
    $data = array(
        "fecha_factura"  => $datos_factura['fecha'],
        "folio_factura"  => $datos_factura['folio'],
        "descripcion" => $datos_factura['descripcion'],
        "subtotal" => $datos_factura['subTotal'],
        "total"  => $datos_factura['total'],
        "metodo_pago"  => $datos_factura['metodoPago'],
        "uuid" => $datos_factura['uuidV'],
        "nombre_archivo" => $datos_factura['nombre_xml'],
        "id_usuario" => $id_usuario,
        "id_comision" => $id_comision,
        "regimen" => $datos_factura['regimenFiscal'],
        "forma_pago" => $datos_factura['formaPago'],
        "cfdi" => $datos_factura['usocfdi'],
        "unidad" => $datos_factura['claveUnidad'],
        "claveProd" => $datos_factura['claveProdServ'],
        "bandera" => 2
    );
    $this->db->update("facturas", $data, " id_comision = $id_comision");

//        $this->db->insert("facturas", $data);
    $ultimoId = $this->db->insert_id();
    return $this->db->query("INSERT INTO xmldatos VALUES (".$id_factura.", '".$VALOR_TEXT."', GETDATE())");
}
 /**----------------------------------------------------- */    

  function getPuestosDescuentos(){
    return $this->db->query("SELECT id_opcion, nombre FROM opcs_x_cats WHERE id_catalogo = 1 AND id_opcion in (3,7,9)");
}


    public function getCompanyCommissionEntry($id_lote, $id_usuario){
        return $this->db-> query("SELECT * FROM comisiones WHERE id_lote = $id_lote AND id_usuario = $id_usuario")->result_array();
    }



    function listEmpresa(){
        return $this->db->query("SELECT DISTINCT(empresa) nombreUser FROM residenciales WHERE empresa != ''");
     }


   function listRegimen(){
         return $this->db->query("SELECT id_opcion, nombre as descripcion FROM opcs_x_cats WHERE id_catalogo = 16 AND id_opcion not in (1)");
     }



  
    function getDatosSaldosIntmex($empresa,$regimen){ 
        $filtro_Intmex = '';

        if(($empresa == null || $empresa == 'null') && $regimen != 0 && $regimen != 'null'){//0 1
            $filtro_Intmex = " WHERE pci1.estatus = 8 AND pci1.id_usuario in (SELECT id_usuario FROM usuarios WHERE forma_pago = $regimen) ";
             //echo $empresa.' <- empresa (1) regimen ->'.$regimen;

        }else if($empresa != null && $empresa != 'null' && ($regimen == 0 || $regimen == 'null')){//1 0
            $filtro_Intmex = " WHERE pci1.estatus = 8 AND  re.empresa = '".$empresa."' ";
             //echo $empresa.' <- empresa (2) regimen ->'.$regimen;

        }else if($empresa != null && $empresa != 'null' && $regimen != 0 && $regimen != 'null'){//1 0
             $filtro_Intmex = " WHERE pci1.estatus = 8 AND re.empresa = '".$empresa."' AND pci1.id_usuario in (SELECT id_usuario FROM usuarios WHERE forma_pago = $regimen) ";
              //echo $empresa.' <- empresa (3) regimen ->'.$regimen;
        }else{
            $filtro_Intmex = " WHERE pci1.estatus = 8 ";
             //echo $empresa.' <- empresa (default) regimen ->'.$regimen;
        }

        return $this->db->query("SELECT re.idResidencial, CAST(re.descripcion AS VARCHAR(MAX)) as proyecto, re.empresa, SUM(pci1.abono_neodata) AS dispersado, opc.nombre
         FROM pago_comision_ind pci1 
         INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
         INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
         INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
         INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
         LEFT JOIN opcs_x_cats opc ON opc.id_opcion = ".$regimen." AND opc.id_catalogo = 16
         ".$filtro_Intmex."
         GROUP BY re.idResidencial, CAST(re.descripcion AS VARCHAR(MAX)), re.empresa, opc.nombre ORDER by re.idResidencial ");
        }

        public function CambiarPrecioLote($idLote,$precio,$comentario){

            $comisiones = $this->db-> query("SELECT * FROM comisiones WHERE id_lote=$idLote and id_usuario !=0 and estatus not in(8,2)")->result_array();
            if(count($comisiones) == 0){
               $respuesta =  $this->db->query("UPDATE lotes set totalNeto2=".$precio." WHERE idLote=".$idLote.";");
               $respuesta = $this->db->query("INSERT INTO historial_log VALUES($idLote,".$this->session->userdata('id_usuario').",GETDATE(),1,'$comentario','lotes')");
             
            }else{
                $respuesta =  $this->db->query("UPDATE lotes set totalNeto2=".$precio." WHERE idLote=".$idLote.";");
               $respuesta = $this->db->query("INSERT INTO historial_log VALUES($idLote,".$this->session->userdata('id_usuario').",GETDATE(),1,'$comentario','lotes')");
                for ($i=0; $i <count($comisiones) ; $i++) { 
                    $comisionTotal =$precio *($comisiones[$i]['porcentaje_decimal']/100);
                    $comentario2='Se actualiz?? la comision total por cambio de precio del lote de'.$comisiones[$i]['comision_total'].' a '.$comisionTotal;
                    $respuesta =  $this->db->query("UPDATE comisiones SET comision_total=$comisionTotal WHERE id_comision=".$comisiones[$i]['id_comision']." AND id_lote=".$idLote.";");
                    $respuesta = $this->db->query("INSERT INTO historial_log VALUES(".$comisiones[$i]['id_comision'].",".$this->session->userdata('id_usuario').",GETDATE(),1,'$comentario2','comisiones')");   
                }
            }
                    if($respuesta){
                        return 1;
                }else{
                        return 0;
                }
       
           }
    
    
           public function getPagosByComision($id_comision){
            $datos =  $this->db-> query("SELECT pci.id_pago_i,pci.abono_neodata,CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario,cat.nombre,pci.comentario
             FROM pago_comision_ind pci INNER JOIN usuarios u ON u.id_usuario=pci.id_usuario 
             INNER JOIN opcs_x_cats cat ON cat.id_opcion=pci.estatus
              WHERE pci.id_comision=$id_comision AND pci.estatus in(1,6,3) AND cat.id_catalogo=23")->result_array();
            return $datos;
           }
           public function ToparComision($id_comision){    
            $sumaxcomision=0;
            $pagos = $this->db->query("SELECT pci.id_usuario,pci.id_pago_i,pci.abono_neodata,CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario,cat.nombre,pci.comentario
            FROM pago_comision_ind pci INNER JOIN usuarios u ON u.id_usuario=pci.id_usuario 
            INNER JOIN opcs_x_cats cat ON cat.id_opcion=pci.estatus
             WHERE pci.id_comision=$id_comision AND pci.estatus in(1,6,3) AND cat.id_catalogo=23")->result_array();
            $pagos_ind = $this->db->query("select SUM(abono_neodata) as suma from pago_comision_ind where id_comision=".$id_comision." and estatus not in(1,6,5,3)")->result_array();
            $sumaxcomision = $pagos_ind[0]['suma'];
            for ($j=0; $j <count($pagos) ; $j++) { 
                $comentario= 'Se elimin?? el pago';
                $respuesta =  $this->db->query("UPDATE pago_comision_ind SET estatus=0,abono_neodata=0 WHERE id_pago_i=".$pagos[$j]['id_pago_i']." AND id_usuario=".$pagos[$j]['id_usuario'].";");
                $respuesta = $this->db->query("INSERT INTO  historial_comisiones VALUES (".$pagos[$j]['id_pago_i'].", ".$this->session->userdata('id_usuario').", GETDATE(), 1, '".$comentario."')");
            
            }
            if($sumaxcomision == 0  || $sumaxcomision == null || $sumaxcomision == 'null' ){
                $this->db->query("UPDATE comisiones set comision_total=0,descuento=1 where id_comision=".$id_comision." ");

            }else{
                $this->db->query("UPDATE comisiones set comision_total=$sumaxcomision,descuento=1 where id_comision=".$id_comision." ");

            }
    return $pagos;
        }
 

public function GuardarPago($id_comision, $comentario_topa, $monotAdd){    
            
            $sumaxcomision=0;

            $pagos = $this->db->query("SELECT id_usuario FROM comisiones com WHERE id_comision = $id_comision");
            $user = $pagos->row()->id_usuario;
            
                $respuesta =  $this->db->query("INSERT INTO pago_comision_ind VALUES ($id_comision, $user, $monotAdd , GETDATE(), GETDATE(), 0, 11, ".$this->session->userdata('id_usuario').", 'IMPORTACION EXTEMPORANEA', NULL, NULL, NULL )");
                $insert_id = $this->db->insert_id();
               $this->db->query("INSERT INTO historial_comisiones VALUES (".$insert_id.", ".$this->session->userdata('id_usuario').", GETDATE(), 1, '".$comentario_topa."')");


                if($respuesta){
                        return 1;
                }else{
                        return 0;
                }
            
            
        }
           


           
     
        public function SaveAjuste($id_comision,$id_lote,$id_usuario,$porcentaje,$comision_total,$opc = ''){
            $q = '';
            if($opc != ''){
                     $q=',descuento=0';
            }

         $respuesta =  $this->db->query("UPDATE comisiones set comision_total=$comision_total,porcentaje_decimal=$porcentaje $q WHERE id_comision=$id_comision AND id_lote=$id_lote and id_usuario=$id_usuario");
         //$respuesta =  $this->db->query("UPDATE pago_comision_ind set estatus=5 WHERE id_comision=$id_comision AND estatus in(1,6,3) and id_usuario=$usuario");
        
        if($opc == ''){
         $pagos = $this->db-> query("SELECT * FROM pago_comision_ind WHERE id_comision=$id_comision and estatus in(1,6,3) and id_usuario=$id_usuario;")->result_array();
         for ($i=0; $i <count($pagos) ; $i++) { 
             $comentario2='Se cancelo el pago por cambio de porcentaje';
             $respuesta =  $this->db->query("UPDATE pago_comision_ind SET abono_neodata=0,estatus=0 WHERE id_pago_i=".$pagos[$i]['id_pago_i']." AND id_usuario=".$id_usuario.";");
             $respuesta = $this->db->query("INSERT INTO  historial_comisiones VALUES (".$pagos[$i]['id_pago_i'].", ".$this->session->userdata('id_usuario').", GETDATE(), 1, '".$comentario2."')");
         }
        }
         
         return $respuesta;
 
        }







   function update_DU_topar($id_usuario, $obs, $monto) {
    $id_user_Vl = $this->session->userdata('id_usuario');
     return $this->db->query("UPDATE descuentos_universidad SET monto = ".$monto.", estatus =3, pagos_activos = 0, comentario = '".$id_user_Vl.' TOPO EL DESCUENTO POR MOTIVO DE: '.$obs."' WHERE id_usuario IN (".$id_usuario.") AND estatus in (1,2)");
  }


  function getPagosFacturasBaja(){
    return $this->db->query(" select op.archivo_name,op.estatus,pci.id_usuario,CONCAT(u.nombre, ' ', u.apellido_paterno, ' ',  u.apellido_materno) as colaborador,opc.nombre as puesto,s.nombre as sede,SUM(PCI.abono_neodata) as suma from usuarios u  
    inner join pago_comision_ind pci on pci.id_usuario=u.id_usuario 
    inner join opcs_x_cats opc on opc.id_opcion=u.id_rol 
    inner join sedes s on s.id_sede=u.id_sede
    left join opinion_cumplimiento op on op.id_usuario=pci.id_usuario and op.estatus in(1,2)
    where u.forma_pago=2 and u.estatus=0 and pci.estatus=1  and opc.id_catalogo=1  
    GROUP BY op.archivo_name,op.estatus,pci.id_usuario,u.nombre,u.apellido_paterno,u.apellido_paterno,u.apellido_materno,opc.nombre,s.nombre");
   
    // return $this->db->query("SELECT res.idResidencial id_usuario, res.nombreResidencial  as name_user, descripcion FROM residenciales res");
}
function getPagosByProyect($proyect = '',$formap = ''){

    if(!empty($proyect)){

        $id = $proyect;
        $forma = $formap;

    }else{
        $id = 0;

    }
    $datos =array();
    $suma =  $this->db->query("(SELECT sum(pci.abono_neodata) as suma
  FROM residenciales re
  INNER JOIN condominios co ON re.idResidencial = co.idResidencial
  INNER JOIN lotes lo ON lo.idCondominio = co.idCondominio
  INNER JOIN comisiones com ON com.id_lote = lo.idLote AND com.estatus in (1,8)
  INNER JOIN pago_comision_ind pci ON pci.id_comision = com.id_comision
  INNER JOIN usuarios u ON u.id_usuario = com.id_usuario 
  WHERE pci.estatus IN (8) and u.forma_pago=$formap and re.idResidencial=$id)")->result_array();
  $ids = $this->db->query("( SELECT pci.id_pago_i
  FROM residenciales re
  INNER JOIN condominios co ON re.idResidencial = co.idResidencial
  INNER JOIN lotes lo ON lo.idCondominio = co.idCondominio
  INNER JOIN comisiones com ON com.id_lote = lo.idLote AND com.estatus in (1,8)
  INNER JOIN pago_comision_ind pci ON pci.id_comision = com.id_comision
  INNER JOIN usuarios u ON u.id_usuario = com.id_usuario 
  WHERE pci.estatus IN (8) and u.forma_pago=$forma and re.idResidencial=$id)")->result_array();
   
   $datos[0]=$suma;
   $datos[1]=$ids;
   return $datos;
    // return $this->db->query("SELECT res.idResidencial id_usuario, res.nombreResidencial  as name_user, descripcion FROM residenciales res");
}
function getDesarrolloSelectINTMEX($a = ''){

    if($a == ''){

        $forma_p = $this->session->userdata('id_usuario');

    }else{
        $forma_p = $a;

    }
    return $this->db->query("SELECT res.idResidencial id_usuario, res.descripcion  as name_user
    FROM residenciales res WHERE res.idResidencial IN 
                    
               (SELECT re.idResidencial
                  FROM residenciales re
                  INNER JOIN condominios co ON re.idResidencial = co.idResidencial
                  INNER JOIN lotes lo ON lo.idCondominio = co.idCondominio
                  INNER JOIN comisiones com ON com.id_lote = lo.idLote AND com.estatus in (1,8)
                  INNER JOIN pago_comision_ind pci ON pci.id_comision = com.id_comision
                  INNER JOIN usuarios u ON u.id_usuario = com.id_usuario 
                  WHERE pci.estatus IN (8) and u.forma_pago=$forma_p GROUP BY re.idResidencial)");
   
    // return $this->db->query("SELECT res.idResidencial id_usuario, res.nombreResidencial  as name_user, descripcion FROM residenciales res");
}

/**----------------------------------------------------------------------- */
function getUsuariosRol3($rol){
    return $this->db->query("SELECT id_usuario,CONCAT(nombre, ' ', apellido_paterno, ' ',  apellido_materno) as name_user,id_lider FROM usuarios WHERE estatus in (0,1) /*and forma_pago != 2*/ AND id_rol=$rol");
}


public function getAsesoresBaja(){
    // $query =  $this->db->query("
    // SELECT us.id_usuario, CONCAT(us.nombre, ' ',us.apellido_paterno, ' ',us.apellido_materno) AS nombre 
    // FROM usuarios us inner join comisiones com on com.id_usuario=us.id_usuario inner join pago_comision pc on pc.id_lote=com.id_lote  WHERE pc.bandera=0 and us.id_rol in (7) AND us.estatus=0 AND us.rfc NOT LIKE '%TSTDD%' AND us.correo NOT LIKE '%test_%'
    // group by us.id_usuario, CONCAT(us.nombre, ' ',us.apellido_paterno, ' ',us.apellido_materno)");

     $query =  $this->db->query("SELECT us.id_usuario, CONCAT(us.nombre, ' ',us.apellido_paterno, ' ',us.apellido_materno) AS nombre 
      FROM usuarios us 
      inner join comisiones com on com.id_usuario=us.id_usuario 
      WHERE us.id_rol in (7) AND us.estatus=0 
      AND us.rfc NOT LIKE '%TSTDD%' AND us.correo NOT LIKE '%test_%' 
      group by us.id_usuario, CONCAT(us.nombre, ' ',us.apellido_paterno, ' ',us.apellido_materno)");
    return $query->result();

}

public function CederComisiones($usuarioold,$newUser,$rol){
    ini_set('max_execution_time', 0);
    $comisiones =  $this->db->query("select com.id_comision,com.id_lote,com.id_usuario,l.totalNeto2,l.nombreLote,com.comision_total,com.porcentaje_decimal 
    from comisiones com 
    inner join lotes l on l.idLote=com.id_lote 
    where com.id_usuario=".$usuarioold."")->result_array();
$infoCedida = array();
$respuesta=true;
$cc=0;
    for ($i=0; $i <count($comisiones) ; $i++) { 

        $sumaxcomision=0;
        $Restante=0;
            $pagosElimnar = $this->db->query("SELECT pci.id_usuario,pci.id_pago_i,pci.abono_neodata,CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario,pci.comentario
            FROM pago_comision_ind pci INNER JOIN usuarios u ON u.id_usuario=pci.id_usuario 
             WHERE pci.id_comision=".$comisiones[$i]['id_comision']." AND pci.estatus in(1,6,3)")->result_array();

            $SumaTopar = $this->db->query("select SUM(abono_neodata) as suma from pago_comision_ind where id_comision=".$comisiones[$i]['id_comision']." and estatus not in(1,6,3)")->result_array();
            if( $SumaTopar[0]['suma'] == 'NULL' ||  $SumaTopar[0]['suma'] == null ||  $SumaTopar[0]['suma'] == 0 || $SumaTopar[0]['suma'] == '' ){
                $sumaxcomision = 0;
            }else{
                $sumaxcomision = $SumaTopar[0]['suma'];
            }
            
            $Restante=0;
        if(count($pagosElimnar) > 0 || $sumaxcomision < ($comisiones[$i]['comision_total'] - 0.5)){

            if(count($pagosElimnar) > 0){
                for ($j=0; $j <count($pagosElimnar) ; $j++) { 
                    $comentario= 'Se elimin?? pago';
                    $respuesta =  $this->db->query("UPDATE pago_comision_ind SET estatus=0,abono_neodata=0 WHERE id_pago_i=".$pagosElimnar[$j]['id_pago_i']." AND id_usuario=".$pagosElimnar[$j]['id_usuario'].";");
                    $respuesta = $this->db->query("INSERT INTO  historial_comisiones VALUES (".$pagosElimnar[$j]['id_pago_i'].", ".$this->session->userdata('id_usuario').", GETDATE(), 1, '".$comentario."')");
                
                }
            }

            if($sumaxcomision < ($comisiones[$i]['comision_total'] - 0.5)){
                $Restante = $comisiones[$i]['comision_total'] - $sumaxcomision;
                $this->db->query("UPDATE comisiones set comision_total=$sumaxcomision,descuento=$newUser where id_comision=".$comisiones[$i]['id_comision']." ");
                $this->db->query("INSERT INTO comisiones VALUES (".$comisiones[$i]['id_lote'].",".$newUser.",".$Restante.",1,'COMISI??N CEDIDA',NULL,NULL,".$this->session->userdata('id_usuario').",GETDATE(),".$comisiones[$i]['porcentaje_decimal'].",GETDATE(),".$rol.",$usuarioold)");
              
              $infoCedida[$cc] = array(
                "id_lote" => $comisiones[$i]['id_lote'],
                "nombreLote" => $comisiones[$i]['nombreLote'],
                "com_total" => $comisiones[$i]['comision_total'],
                "tope" => $sumaxcomision,
                "resto" => $Restante
              );
              $cc=$cc+1;


            }
        }
        
    }

    /**-------------------------ENVIO DE CORREO----------------------- */
    $datosUsuarioOld = $this->db->query("SELECT CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre,o.nombre as rol FROM usuarios u inner join opcs_x_cats o on o.id_opcion=u.id_rol WHERE u.id_usuario=".$usuarioold." and o.id_catalogo=1")->result_array();
    $datosUsuarioNew = $this->db->query("SELECT CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno) nombre,o.nombre as rol FROM usuarios u inner join opcs_x_cats o on o.id_opcion=u.id_rol WHERE u.id_usuario=".$newUser." and o.id_catalogo=1")->result_array();
//echo var_dump($datosUsuarioOld);
//echo var_dump($datosUsuarioNew);
    //echo var_dump($infoCedida);
//echo $infoCedida[0]['id_lote'];
    $mail = $this->phpmailer_lib->load();




  $mail->setFrom('noreply@ciudadmaderas.com', 'Ciudad Maderas');
  $mail->AddAddress('programador.analista16@ciudadmaderas.com');
  
 $mail->Subject = utf8_decode('COMISIONES CEDIDAS');
 // Set email format to HTML
 $mail->isHTML(true);

 $mailContent = utf8_decode( "<html><head>
 <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
 <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'>
 <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css' integrity='sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO' crossorigin='anonymous'>
 <title>COMISIONES CEDIDAS</title>
 <style media='all' type='text/css'>
   .encabezados{
     text-align: center;
     padding-top:  1.5%;
     padding-bottom: 1.5%;
     font-size: 25px;
   }
   .encabezados a{
     color: #234e7f;
     font-weight: bold;
   }
   .fondo{
     background-color: #234e7f;
     color: #fff;
   }

   h4{
     text-align: center;
   }
   p{
     text-align: right;
   }
   strong{
     color: #234e7f;
   }
   b {
     color: white;
   }
 </style>
 </head>
 <body>
 <table align='center' cellspacing='0' cellpadding='0' border='0' width='100%'>

   <tr colspan='3'>
       <td class='navbar navbar-inverse' align='center'>
             <table width='90%' cellspacing='0' cellpadding='3' class='container'>
                 <tr class='navbar navbar-inverse encabezados'>
                     <th style='text-align:left; width:30%;'>
                     
                     </th>
                     <th style='text-align:right; width:70%;'>
                     <a href='#'>CIUDAD MADERAS</a>
                     </th>
                 </tr>
                 <tr class='navbar navbar-inverse'>
                    <b> &nbsp </b>
                 </tr>
             </table>
       </td>
   </tr>

   <tr><td border=1 bgcolor='#FFFFFF' align='center'>
   <h4>El ".$datosUsuarioOld[0]['rol']." ".$datosUsuarioOld[0]['nombre']." cedi?? sus comisiones al  ".$datosUsuarioNew[0]['rol']." ".$datosUsuarioNew[0]['nombre']."  </h4>
   <center>
       <table id='email' cellpadding='0' cellspacing='0' border='1' width ='90%' style class='darkheader'>

                   <tr class='active'>
                   <th>ID LOTE</th>
                   <th>LOTE</th>
                   <th>COMISI??N TOTAL</th>
                   <th>COMISI??N TOPADA</th>
                    <th>COMISI??N TOTAL NUEVO ASESOR</th>
                   </tr>");    
                   
                  for ($m=0; $m <count($infoCedida) ; $m++) { 
                   $mailContent .= utf8_decode("<tr>
                   <td><center>".$infoCedida[$m]['id_lote']."</center></td>
                   <td><center>".$infoCedida[$m]['nombreLote']."</center></td>
                   <td><center>".number_format($infoCedida[$m]['com_total'], 2, '.', '')."</center></td>
                   <td><center>".number_format($infoCedida[$m]['tope'], 2, '.', '')."</center></td>
                   <td><center>".number_format($infoCedida[$m]['resto'], 2, '.', '')."</center></td>

               </tr>");
                  } 
                   

$mailContent .= utf8_decode("</table>
   </center>

   </td></tr>
 </table>

 </body></html>");

   $mail->Body = $mailContent;
   $mail->send();


    /**--------------------------------------------------------------- */
    if($respuesta){
        return 1;
        }else{
          return 0;
            }

}
/**---------------------------------------------------------- */
public function datosLotesaCeder($id_usuario){
    ini_set('max_execution_time', 0);
    $comisiones =  $this->db->query("select com.id_comision,com.id_lote,com.id_usuario,l.totalNeto2,l.nombreLote,com.comision_total,com.porcentaje_decimal 
    from comisiones com 
    inner join lotes l on l.idLote=com.id_lote 
    where com.id_usuario=".$id_usuario."")->result_array();
$infoCedida = array();
$cc=0;
    for ($i=0; $i <count($comisiones) ; $i++) { 

        $sumaxcomision=0;
        $Restante=0;

            $SumaTopar = $this->db->query("select SUM(abono_neodata) as suma from pago_comision_ind where id_comision=".$comisiones[$i]['id_comision']." and estatus not in(1,6,3)")->result_array();
            if( $SumaTopar[0]['suma'] == 'NULL' ||  $SumaTopar[0]['suma'] == null ||  $SumaTopar[0]['suma'] == 0 || $SumaTopar[0]['suma'] == '' ){
                $sumaxcomision = 0;
            }else{
                $sumaxcomision = $SumaTopar[0]['suma'];
            }
            
            $Restante=0;

            if($sumaxcomision < ($comisiones[$i]['comision_total'] - 0.5)){
                $Restante = $comisiones[$i]['comision_total'] - $sumaxcomision;
              
              $infoCedida[$cc] = array(
                "id_lote" => $comisiones[$i]['id_lote'],
                "nombreLote" => $comisiones[$i]['nombreLote'],
                "com_total" => $comisiones[$i]['comision_total'],
                "tope" => $sumaxcomision,
                "resto" => $Restante
              );
              $cc=$cc+1;
            }    
    }

    return $infoCedida;
}


public function getUserInventario($id_cliente){

  return  $this->db->query("
    select cl.id_cliente,ase.id_usuario as id_asesor, CONCAT(ase.nombre, ' ', ase.apellido_paterno, ' ',  ase.apellido_paterno) as asesor,
               coor.id_usuario as id_coordinador, CONCAT(coor.nombre, ' ', coor.apellido_paterno, ' ',  coor.apellido_paterno) as coordinador,
               ger.id_usuario as id_gerente, CONCAT(ger.nombre, ' ', ger.apellido_paterno, ' ',  ger.apellido_paterno) as gerente
			   from clientes cl 
inner join usuarios ase on ase.id_usuario=cl.id_asesor 
inner join usuarios ger on ger.id_usuario=cl.id_gerente 
LEFT join usuarios coor on coor.id_usuario=cl.id_coordinador
where cl.id_cliente=$id_cliente
    ");
}
public function getUserVC($id_cliente){

    return  $this->db->query("
    SELECT vc.id_vcompartida,cl.id_cliente,cl.nombre, cl.apellido_paterno, cl.apellido_materno,
    ae.id_usuario as id_asesor, CONCAT(ae.nombre, ' ', ae.apellido_paterno, ' ',  ae.apellido_materno) as asesor,
    co.id_usuario as id_coordinador, CONCAT(co.nombre, ' ', co.apellido_paterno, ' ',  co.apellido_materno) as coordinador,
    ge.id_usuario as id_gerente, CONCAT(ge.nombre, ' ', ge.apellido_paterno, ' ',  ge.apellido_materno) as gerente
     FROM ventas_compartidas vc
     INNER JOIN clientes cl ON vc.id_cliente = cl.id_cliente
     INNER JOIN usuarios ae ON ae.id_usuario = vc.id_asesor
     LEFT JOIN usuarios co ON co.id_usuario = vc.id_coordinador
     INNER JOIN usuarios ge ON ge.id_usuario = vc.id_gerente
        WHERE cl.id_cliente=$id_cliente AND vc.estatus = 1 AND cl.status = 1
      ");
  
  }

public function getDatosAbonadoDispersion3($idlote){
    // if ($id_pj == 1){
        $request = $this->db->query("SELECT lugar_prospeccion FROM clientes WHERE idLote = $idlote AND status = 1")->row();

        if($request->lugar_prospeccion == 6){
            $rel_final = 6;
        }
        else{
            $rel_final = 11;
        }
        return $this->db->query("SELECT com.observaciones,com.id_comision, com.id_usuario, lo.totalNeto2, lo.idLote, res.idResidencial, lo.referencia, com.id_lote, lo.nombreLote, com.porcentaje_decimal, CONCAT(us.nombre,' ' ,us.apellido_paterno,' ',us.apellido_materno) colaborador, oxc.nombre as rol, com.comision_total, pci.abono_pagado, com.rol_generado, pc.porcentaje_saldos, (CASE us.id_usuario WHEN 832 THEN 25  ELSE pc.porcentaje_saldos END) porcentaje_saldos,com.descuento                       
         FROM comisiones com
                    LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind 
                    GROUP BY id_comision) pci ON pci.id_comision = com.id_comision
                    INNER JOIN lotes lo ON lo.idLote = com.id_lote 
                    INNER JOIN usuarios us ON us.id_usuario = com.id_usuario
                    INNER JOIN opcs_x_cats oxc ON oxc.id_opcion = com.rol_generado
                    INNER JOIN condominios con ON con.idCondominio = lo.idCondominio
                    INNER JOIN residenciales res ON res.idResidencial = con.idResidencial
                    INNER JOIN porcentajes_comisiones pc ON pc.id_rol = com.rol_generado
                    WHERE oxc.id_catalogo = 1 AND com.id_lote = $idlote AND pc.relacion_prospeccion = $rel_final AND com.estatus = 1 and com.rol_generado in(7,9,3) group by com.observaciones,com.id_comision, com.id_usuario, lo.totalNeto2, lo.idLote, res.idResidencial, lo.referencia, com.id_lote, lo.nombreLote,
com.porcentaje_decimal, CONCAT(us.nombre,' ' ,us.apellido_paterno,' ',us.apellido_materno), oxc.nombre, 
com.comision_total, pci.abono_pagado, com.rol_generado, pc.porcentaje_saldos, (CASE us.id_usuario WHEN 832 THEN 25  ELSE pc.porcentaje_saldos END) ,com.descuento
order by pc.porcentaje_saldos desc");
 
}

function getUsuariosByrol($rol,$user){
  if($rol == 7 || $rol == 9){
    $list_rol = '7,9';
  }else{
     $list_rol =  $rol;
  }

    return $this->db->query("SELECT id_usuario,CONCAT(nombre, ' ', apellido_paterno, ' ',  apellido_materno) as name_user FROM usuarios WHERE estatus in (1) AND id_rol in ($list_rol) and id_usuario not in($user) ");
   }


function UpdateInventarioClient($usuarioOld,$newColab,$rolSelect,$idLote,$idCliente,$comentario){
    ini_set('max_execution_time', 0);

//1-- se topa la comision del usuario a modificar de la tabla clientes
if($rolSelect == 7){
    $this->db->query("UPDATE clientes set id_asesor=$newColab where id_cliente=$idCliente;");
    $respuesta = $this->db->query("INSERT INTO historial_log VALUES (".$idCliente.", ".$this->session->userdata('id_usuario').", GETDATE(), 1, 'M??TIVO ACTUALIZACI??N: ".$comentario."', 'ventas_compartidas')");

}else if($rolSelect == 9){
    $this->db->query("UPDATE clientes set id_coordinador=$newColab where id_cliente=$idCliente;");
    $respuesta = $this->db->query("INSERT INTO historial_log VALUES (".$idCliente.", ".$this->session->userdata('id_usuario').", GETDATE(), 1, 'M??TIVO ACTUALIZACI??N: ".$comentario."', 'ventas_compartidas')");


}else if($rolSelect == 3){
    $this->db->query("UPDATE clientes set id_gerente=$newColab where id_cliente=$idCliente;");
    $respuesta = $this->db->query("INSERT INTO historial_log VALUES (".$idCliente.", ".$this->session->userdata('id_usuario').", GETDATE(), 1, 'M??TIVO ACTUALIZACI??N: ".$comentario."', 'ventas_compartidas')");


}

$comision = $this->db->query("SELECT id_comision,comision_total,rol_generado from comisiones where id_usuario=$usuarioOld and id_lote=$idLote;")->result_array();
 if(count($comision) > 0){

$sumaxcomision=0;
            $pagos = $this->db->query("SELECT pci.id_usuario,pci.id_pago_i,pci.abono_neodata,CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario,cat.nombre,pci.comentario
            FROM pago_comision_ind pci INNER JOIN usuarios u ON u.id_usuario=pci.id_usuario 
            INNER JOIN opcs_x_cats cat ON cat.id_opcion=pci.estatus
             WHERE pci.id_comision=".$comision[0]['id_comision']." AND pci.estatus in(1,6,3) AND cat.id_catalogo=23")->result_array();
            $pagos_ind = $this->db->query("select SUM(abono_neodata) as suma from pago_comision_ind where id_comision=".$comision[0]['id_comision']." and estatus not in(1,6,3)")->result_array();
            $sumaxcomision = $pagos_ind[0]['suma'];
            if(count($pagos) > 0){
                for ($j=0; $j <count($pagos) ; $j++){
                    $comentario= 'Se elimin?? el pago';
                    $respuesta =  $this->db->query("UPDATE pago_comision_ind SET estatus=0,abono_neodata=0 WHERE id_pago_i=".$pagos[$j]['id_pago_i']." AND id_usuario=".$pagos[$j]['id_usuario'].";");
                    $respuesta = $this->db->query("INSERT INTO  historial_comisiones VALUES (".$pagos[$j]['id_pago_i'].", ".$this->session->userdata('id_usuario').", GETDATE(), 1, '".$comentario."')");
                }
            }    
            if($sumaxcomision == 0 || $sumaxcomision == '' || $sumaxcomision == null){
                $sumaxcomision = 0;
                //$this->db->query("delete from comisiones where id_comision=".$comision[0]['id_comision']." and id_usuario=".$usuarioOld." ");
                //si la suma de sis pagos pagados es igual a 0 solo cambiar el usuario
                $respuesta =   $this->db->query("UPDATE comisiones set comision_total=$sumaxcomision,descuento=1 where id_comision=".$comision[0]['id_comision']." ");

            }else{
                $respuesta =   $this->db->query("UPDATE comisiones set comision_total=$sumaxcomision,descuento=1 where id_comision=".$comision[0]['id_comision']." ");
            }  

        }
            $validate = $this->db->query("SELECT id_usuario FROM comisiones WHERE id_lote IN (SELECT idLote FROM lotes WHERE idCliente = $idCliente) AND id_usuario = $newColab");
            $data_lote = $this->db->query("SELECT idLote, totalNeto2 FROM lotes WHERE idCliente = $idCliente");
            $count_com = $this->db->query("SELECT COUNT(id_usuario) val_total FROM comisiones WHERE id_lote IN (SELECT idLote FROM lotes WHERE idCliente = $idCliente) AND rol_generado = $rolSelect and descuento=0");

            $var_lote = $data_lote->row()->idLote;
        $precio_lote = $data_lote->row()->totalNeto2;

        $por=0;
        if($rolSelect == 7){
            //ASESOR
            if($count_com->row()->val_total == 0){
                $por=3;
            }
            elseif($count_com->row()->val_total == 1){
                $por=1.5;
            }else if($count_com->row()->val_total == 2){
                $por=1;
            }elseif($count_com->row()->val_total == 3){
                $por=1;
            }

        }else if($rolSelect == 9){
            //COORDINADOR
            if($count_com->row()->val_total == 0){
                $por=1;
            }
            elseif($count_com->row()->val_total == 1){
                $por=0.5;
            }else if($count_com->row()->val_total == 2){
                $por=0.33333;
            }elseif($count_com->row()->val_total == 3){
                $por=0.33333;
            }
        }elseif($rolSelect == 3){
            //GERENTE
            if($count_com->row()->val_total == 0){
                $por=1;
            }
            elseif($count_com->row()->val_total == 1){
                $por=0.5;
            }else if($count_com->row()->val_total == 2){
                $por=0.33333;
            }elseif($count_com->row()->val_total == 3){
                $por=0.33333;
            }
        }
        $comision_total=$precio_lote * ($por /100);

        if(empty($validate->row()->id_usuario)){
        $response = $this->db->query("INSERT INTO comisiones VALUES (".$idLote.",$newColab,$comision_total,1,'SE MODIFIC?? INVENTARIO',NULL,NULL,1,GETDATE(),$por,GETDATE(),$rolSelect,0)");
        if($response){
            return 1;
        }else{
            return 0;
        }    
    }else{
        return 1;
    }


    if($respuesta){
        return 1;
    }else{
        return 0;
    } 

}


function UpdateVcUser($usuarioOld,$newColab,$rolSelect,$idLote,$idCliente,$comentario,$cuantos){
    //1-- se topa la comision del usuario a modificar de la tabla clientes
    ini_set('max_execution_time', 0);
    if($cuantos == 1){
        if($rolSelect == 7){
            $this->db->query("UPDATE ventas_compartidas set id_asesor=$newColab where id_cliente=$idCliente and estatus=1;");
        }else if($rolSelect == 9){
            $this->db->query("UPDATE ventas_compartidas set id_coordinador=$newColab where id_cliente=$idCliente and estatus=1;");
        }else if($rolSelect == 3){
            $this->db->query("UPDATE ventas_compartidas set id_gerente=$newColab where id_cliente=$idCliente and estatus=1;");
        }
        $respuesta = $this->db->query("INSERT INTO historial_log VALUES (".$idCliente.", ".$this->session->userdata('id_usuario').", GETDATE(), 1, 'M??TIVO ACTUALIZACI??N: ".$comentario."', 'ventas_compartidas')");

    }
  
    
    if($usuarioOld != 0 && $usuarioOld != '' && $usuarioOld != null && $usuarioOld != 'null'){

    
    $comision = $this->db->query("SELECT id_comision,comision_total,rol_generado from comisiones where id_usuario=$usuarioOld and id_lote=$idLote;")->result_array();
     if(count($comision) > 0){
    
    $sumaxcomision=0;
                $pagos = $this->db->query("SELECT pci.id_usuario,pci.id_pago_i,pci.abono_neodata,CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario,cat.nombre,pci.comentario
                FROM pago_comision_ind pci INNER JOIN usuarios u ON u.id_usuario=pci.id_usuario 
                INNER JOIN opcs_x_cats cat ON cat.id_opcion=pci.estatus
                 WHERE pci.id_comision=".$comision[0]['id_comision']." AND pci.estatus in(1,6,3) AND cat.id_catalogo=23")->result_array();
                $pagos_ind = $this->db->query("select SUM(abono_neodata) as suma from pago_comision_ind where id_comision=".$comision[0]['id_comision']." and estatus not in(1,6,3)")->result_array();
                $sumaxcomision = $pagos_ind[0]['suma'];
                if(count($pagos) > 0){
                    for ($j=0; $j <count($pagos) ; $j++){
                        $comentario= 'Se elimin?? el pago';
                        $respuesta =  $this->db->query("UPDATE pago_comision_ind SET estatus=0,abono_neodata=0 WHERE id_pago_i=".$pagos[$j]['id_pago_i']." AND id_usuario=".$pagos[$j]['id_usuario'].";");
                        $respuesta = $this->db->query("INSERT INTO  historial_comisiones VALUES (".$pagos[$j]['id_pago_i'].", ".$this->session->userdata('id_usuario').", GETDATE(), 1, '".$comentario."')");
                    }
                }    
                if($sumaxcomision == 0 || $sumaxcomision == '' || $sumaxcomision == null){
                    $sumaxcomision = 0;
                    //$this->db->query("delete from comisiones where id_comision=".$comision[0]['id_comision']." and id_usuario=".$usuarioOld." ");
                    //si la suma de sis pagos pagados es igual a 0 solo cambiar el usuario
                    $respuesta = $this->db->query("UPDATE comisiones set comision_total=$sumaxcomision,descuento=1 where id_comision=".$comision[0]['id_comision']." ");
    
                }else{
                    $respuesta = $this->db->query("UPDATE comisiones set comision_total=$sumaxcomision,descuento=1 where id_comision=".$comision[0]['id_comision']." ");
                }  
    
            }

        }
                $validate = $this->db->query("SELECT id_usuario FROM comisiones WHERE id_lote IN (SELECT idLote FROM lotes WHERE idCliente = $idCliente) AND id_usuario = $newColab");
                $data_lote = $this->db->query("SELECT idLote, totalNeto2 FROM lotes WHERE idCliente = $idCliente");
                $count_com = $this->db->query("SELECT COUNT(id_usuario) val_total FROM comisiones WHERE id_lote IN (SELECT idLote FROM lotes WHERE idCliente = $idCliente) AND rol_generado = $rolSelect and descuento=0");
    
                $var_lote = $data_lote->row()->idLote;
            $precio_lote = $data_lote->row()->totalNeto2;
    
            $por=0;
            if($rolSelect == 7){
                //ASESOR
                if($count_com->row()->val_total == 0){
                    $por=3;
                }
                elseif($count_com->row()->val_total == 1){
                    $por=1.5;
                }else if($count_com->row()->val_total == 2){
                    $por=1;
                }elseif($count_com->row()->val_total == 3){
                    $por=1;
                }
    
            }else if($rolSelect == 9){
                //COORDINADOR
                if($count_com->row()->val_total == 0){
                    $por=1;
                }
                elseif($count_com->row()->val_total == 1){
                    $por=0.5;
                }else if($count_com->row()->val_total == 2){
                    $por=0.33333;
                }elseif($count_com->row()->val_total == 3){
                    $por=0.33333;
                }
            }elseif($rolSelect == 3){
                //GERENTE
                if($count_com->row()->val_total == 0){
                    $por=1;
                }
                elseif($count_com->row()->val_total == 1){
                    $por=0.5;
                }else if($count_com->row()->val_total == 2){
                    $por=0.33333;
                }elseif($count_com->row()->val_total == 3){
                    $por=0.33333;
                }
            }
            $comision_total=$precio_lote * ($por /100);
    
            if(empty($validate->row()->id_usuario)){
            $response = $this->db->query("INSERT INTO comisiones VALUES (".$idLote.",$newColab,$comision_total,1,'SE MODIFIC?? VENTA COMPARTIDA',NULL,NULL,1,GETDATE(),$por,GETDATE(),$rolSelect,0)");
            if($response){
                return 1;
            }else{
                return 0;
            }    
        }else{
            return 1;
        }
    
        
        if($respuesta){
            return 1;
        }else{
            return 0;
        }
            
    
    }

    function getLideres($lider){
        return $this->db->query("select u.id_usuario as id_usuario1,CONCAT(u.nombre, ' ', u.apellido_paterno, ' ',  u.apellido_materno) as name_user,u2.id_usuario as id_usuario2,CONCAT(u2.nombre, ' ', u2.apellido_paterno, ' ',  u2.apellido_materno) as name_user2,
        u3.id_usuario as id_usuario3,CONCAT(u3.nombre, ' ', u3.apellido_paterno, ' ',  u3.apellido_materno) as name_user3 from usuarios u inner join usuarios u2 on u.id_lider=u2.id_usuario inner join usuarios u3 on u3.id_usuario=u2.id_lider where u.id_usuario=$lider");
    }

    function AddVentaCompartida($id_asesor,$coor,$ger,$sub,$id_cliente,$id_lote){

            $response = $this->db->query("insert into ventas_compartidas values($id_cliente,$id_asesor,$coor,$ger,1,GETDATE(),".$this->session->userdata('id_usuario').");");
            $response = $this->db->query("UPDATE pago_comision_ind SET abono_neodata = 0, estatus = 0 WHERE id_comision IN (select id_comision from comisiones where id_lote = $id_lote) AND estatus  = 1");

        $usuario = 0;
        $rolSelect=0;
        $porcentaje=0;
        for($i=0;$i<4;$i++){
            if($i== 0){
                //Asesor
                $usuario=$id_asesor;
                $rolSelect =7;
                $porcentaje=1.5;

            }
           else if($i == 1){
                //Asesor
                $usuario=$coor;
                $rolSelect =9;
                $porcentaje=0.5;

            }
            else if($i == 2){
                //Asesor
                $usuario=$ger;
                $rolSelect =3;
                $porcentaje=0.5;

            }
            else if($i == 3){
                //Asesor
                $usuario=$sub;
                $rolSelect =2;
                $porcentaje=0.5;

            }
            $validate = $this->db->query("SELECT id_usuario FROM comisiones WHERE id_lote IN (SELECT idLote FROM lotes WHERE idCliente = $id_cliente) AND id_usuario = $usuario");
            $data_lote = $this->db->query("SELECT idLote, totalNeto2 FROM lotes WHERE idCliente = $id_cliente");
            $count_com = $this->db->query("SELECT COUNT(id_usuario) val_total FROM comisiones WHERE id_lote IN (SELECT idLote FROM lotes WHERE idCliente = $id_cliente) AND rol_generado = $rolSelect and descuento=0");


            $var_lote = $data_lote->row()->idLote;
            $precio_lote = $data_lote->row()->totalNeto2;
            $comision_total=$precio_lote * ($porcentaje /100);

            if(empty($validate->row()->id_usuario)){
                $response = $this->db->query("UPDATE comisiones set comision_total=$comision_total,porcentaje_decimal=$porcentaje where id_lote=".$id_lote." and rol_generado=$rolSelect");
                $response = $this->db->query("INSERT INTO comisiones VALUES (".$id_lote.",$usuario,$comision_total,1,'SE AGREGO VENTA COMPARTIDA',NULL,NULL,".$this->session->userdata('id_usuario').",GETDATE(),$porcentaje,GETDATE(),$rolSelect,0)");
                  
            }

        }

        if($response){
            return 1;
        }else{
            return 0;
        }  


    }
/**----------------------------------------------------------------------- */ 
public function CancelarDescuento($id_pago,$motivo)
{
    $respuesta = $this->db->query("UPDATE pago_comision_ind set descuento_aplicado=0,estatus=1 where id_pago_i=".$id_pago."");
    $this->db->query("INSERT INTO  historial_comisiones VALUES (".$id_pago.",".$this->session->userdata('id_usuario').", GETDATE(), 1, 'CAPITAL HUMANO CANCEL?? DESCUENTO, MOTIVO: ".$motivo."')");

    if ($respuesta ) {
        return 1;
    } else {
        return 0;
    }
}


public function saveTipoVenta($idLote,$tipo){
    $respuesta =  $this->db->query("UPDATE lotes set tipo_venta=$tipo WHERE idLote=$idLote");
    if($respuesta){
return 1;
    }else{
        return 0;

    }

   }




   



     function getDatosGralInternomex(){

       
    return $this->db->query("(SELECT pci1.id_pago_i, re.nombreResidencial as proyecto, co.nombre as condominio,  lo.nombreLote as lote, lo.referencia, lo.totalNeto2 precio_lote, re.empresa, /*com.comision_total, pci1.pago_neodata, */pci1.abono_neodata pago_cliente,  
      (CASE u.forma_pago WHEN 3 THEN sed.impuesto ELSE 0 END) valimpuesto,
      (CASE u.forma_pago WHEN 3 THEN (((sed.impuesto)/100)*pci1.abono_neodata) ELSE 0 END) dcto, 
      (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, 
      CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario, oprol.nombre as puesto, pci1.fecha_pago_intmex, oxcfp.nombre forma_pago, sed.nombre, (CASE u.estatus WHEN 0 THEN 'BAJA' ELSE 'ACTIVO' END) estatus_usuario 
                 FROM pago_comision_ind pci1 
                 INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                 INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
                 INNER JOIN condominios co ON co.idCondominio = lo.idCondominio 
                 INNER JOIN residenciales re ON re.idResidencial = co.idResidencial 
                 INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 1
                 INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (2,3,4)
                 INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
                 INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                 INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
                 INNER JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario 
                 WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 2 WHEN 4 THEN 5 WHEN 5 THEN 3 WHEN 607 THEN 1 ELSE u.id_sede END) and sed.estatus = 1
                 INNER JOIN opcs_x_cats oxcfp ON oxcfp.id_opcion =  u.forma_pago AND oxcfp.id_catalogo = 16 
                 WHERE pci1.estatus IN (8)  AND com.estatus in (1) AND lo.idStatusContratacion > 8
                 GROUP BY pci1.id_comision, pci1.id_pago_i, re.nombreResidencial, co.nombre,  lo.nombreLote, lo.referencia, lo.totalNeto2, re.empresa,  /* com.comision_total,  pci1.pago_neodata,*/ pci1.abono_neodata, sed.impuesto, u.nombre, u.apellido_paterno, u.apellido_materno, oprol.nombre, pci1.fecha_pago_intmex, oxcfp.nombre, u.forma_pago, sed.nombre, u.estatus)
                 
                 UNION 

                 (SELECT pci1.id_pago_i, re.nombreResidencial as proyecto, co.nombre as condominio,  lo.nombreLote as lote, lo.referencia, lo.totalNeto2 precio_lote, re.empresa, /*com.comision_total, pci1.pago_neodata, */pci1.abono_neodata pago_cliente, 
                  (CASE u.forma_pago WHEN 3 THEN sed.impuesto ELSE 0 END) valimpuesto, 
                 (CASE u.forma_pago WHEN 3 THEN (((sed.impuesto)/100)*pci1.abono_neodata) ELSE 0 END) dcto, (CASE u.forma_pago WHEN 3 THEN (((100-sed.impuesto)/100)*pci1.abono_neodata) ELSE pci1.abono_neodata END) impuesto, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) usuario, oprol.nombre as puesto, pci1.fecha_pago_intmex, oxcfp.nombre forma_pago, sed.nombre, (CASE u.estatus WHEN 0 THEN 'BAJA' ELSE 'ACTIVO' END) estatus_usuario 
                 FROM pago_comision_ind pci1 
                 INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
                 INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
                 INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
                 INNER JOIN residenciales re ON re.idResidencial = co.idResidencial 
                 INNER JOIN usuarios u ON u.id_usuario = com.id_usuario AND u.forma_pago in (2,3,4)
                 INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
                 INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
                 INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23 
                 INNER JOIN sedes sed ON sed.id_sede = (CASE u.id_usuario WHEN 2 THEN 2 WHEN 3 THEN 2 WHEN 1980 THEN 2 WHEN 1981 THEN 2 WHEN 1982 THEN 2 WHEN 1988 THEN 2 WHEN 4 THEN 5 WHEN 5 THEN 3 WHEN 607 THEN 1 ELSE u.id_sede END) and sed.estatus = 1
                 INNER JOIN opcs_x_cats oxcfp ON oxcfp.id_opcion =  u.forma_pago AND oxcfp.id_catalogo = 16 
                 WHERE pci1.estatus IN (8) AND ( (lo.idStatusContratacion < 9 AND com.estatus IN (1,8)) OR (lo.idStatusContratacion > 8  AND com.estatus  IN (8)))   
                 GROUP BY pci1.id_comision, pci1.id_pago_i, re.nombreResidencial, co.nombre,  lo.nombreLote, lo.referencia,  lo.totalNeto2, re.empresa,  /* com.comision_total,  pci1.pago_neodata,*/ pci1.abono_neodata, sed.impuesto, u.nombre, u.apellido_paterno, u.apellido_materno, oprol.nombre, pci1.fecha_pago_intmex, oxcfp.nombre, u.forma_pago, sed.nombre, u.estatus )");
}
    // sed.impuesto







// nuevas actualizaciones


   public  function get_lista_estatus(){

    return $this->db->query("SELECT 1 AS idEstatus, 'NUEVAS' as nombre union
SELECT 2 AS idEstatus, 'REVISION CONTRALORIA' as nombre union
SELECT 3 AS idEstatus, 'INTERNOMEX' as nombre union
SELECT 4 AS idEstatus, 'PAUSADAS' as nombre union
SELECT 5 AS idEstatus, 'DESCUENTOS' as nombre union
SELECT 6 AS idEstatus, 'RESGUARDOS' as nombre union
SELECT 7 AS idEstatus, 'PAGADAS' as nombre ");
     }



      function getDatosHistorialPagoEstatus($proyecto,$estado){

 
         switch ( $estado) {
          
            case '1':
            $filtro_estatus = ' pci1.estatus IN (1,2,41,42,51,52,61,62) AND pci1.descuento_aplicado != 1 ';
            break;

            case '2':
            $filtro_estatus = ' pci1.estatus IN (4,13) AND pci1.descuento_aplicado != 1 ';
            break;

            case '3':
            $filtro_estatus = ' pci1.estatus IN (8,88) AND pci1.descuento_aplicado != 1 ';
            break;

            case '4':
            $filtro_estatus = ' pci1.estatus IN (6) AND pci1.descuento_aplicado != 1 ';
            break;

            case '5':
            $filtro_estatus = ' pci1.estatus IN (11,16,17,0) AND pci1.descuento_aplicado = 1 ';
            break;

            case '6':
            $filtro_estatus = ' pci1.estatus IN (3) AND pci1.descuento_aplicado != 1 ';
            break;

            case '7':
            $filtro_estatus = ' pci1.estatus IN (11,12) AND pci1.descuento_aplicado != 1 ';
            break;
 
         }
 
 
         return $this->db->query("(SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote, re.nombreResidencial as proyecto, co.nombre as condominio,lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, pci1.estatus, pci1.fecha_abono fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) user_names ,pci1.id_usuario, oprol.nombre as puesto, u.forma_pago, f.id_comision as factura, pac.porcentaje_abono, oxcest.nombre as estatus_actual, oxcest.id_opcion id_estatus_actual, pci1.descuento_aplicado, 0 lugar_prospeccion, lo.referencia, com.estatus estado_comision, pac.bonificacion, u.estatus as activo
         FROM pago_comision_ind pci1 
         LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE estatus in (11) 
         GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
         INNER JOIN comisiones com ON pci1.id_comision = com.id_comision
         INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
         INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
         INNER JOIN residenciales re ON re.idResidencial = co.idResidencial
         INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
         INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
         INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
         INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23
         LEFT JOIN facturas f ON f.id_comision = com.id_comision
         
         WHERE $filtro_estatus 

         AND ( (lo.idStatusContratacion < 9 AND com.estatus IN (1,8)) OR (lo.idStatusContratacion > 8 AND com.estatus IN (8)))


         GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial, co.nombre, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, 
         pci2.abono_pagado, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, u.forma_pago, f.id_comision, pci1.id_pago_i, pac.porcentaje_abono, u.nombre,
         u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion,  pci1.descuento_aplicado, lo.referencia, com.estatus, pac.bonificacion, u.estatus)
     UNION 
 
     (SELECT pci1.id_pago_i, pci1.id_comision, lo.nombreLote, re.nombreResidencial as proyecto, co.nombre as condominio,lo.totalNeto2 precio_lote, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata pago_cliente, pci1.pago_neodata, pci2.abono_pagado pagado, com.comision_total-pci2.abono_pagado restante, pci1.estatus, pci1.fecha_abono fecha_creacion, CONCAT(u.nombre, ' ',u.apellido_paterno, ' ', u.apellido_materno) user_names ,pci1.id_usuario, oprol.nombre as puesto,  u.forma_pago, f.id_comision as factura, pac.porcentaje_abono, oxcest.nombre as estatus_actual, oxcest.id_opcion id_estatus_actual, pci1.descuento_aplicado, cl.lugar_prospeccion, lo.referencia, com.estatus estado_comision, pac.bonificacion, u.estatus as activo
         FROM pago_comision_ind pci1 
         LEFT JOIN (SELECT SUM(abono_neodata) abono_pagado, id_comision FROM pago_comision_ind WHERE estatus in (11) 
         GROUP BY id_comision) pci2 ON pci1.id_comision = pci2.id_comision
         INNER JOIN comisiones com ON pci1.id_comision = com.id_comision AND com.estatus in (1)
         INNER JOIN lotes lo ON lo.idLote = com.id_lote AND lo.status = 1 
         INNER JOIN condominios co ON co.idCondominio = lo.idCondominio
         INNER JOIN residenciales re ON re.idResidencial = co.idResidencial 
         INNER JOIN clientes cl ON cl.idLote = lo.idLote AND cl.status = 1
         INNER JOIN usuarios u ON u.id_usuario = com.id_usuario
         INNER JOIN opcs_x_cats oprol ON oprol.id_opcion = com.rol_generado AND oprol.id_catalogo = 1
         INNER JOIN pago_comision pac ON pac.id_lote = com.id_lote
         INNER JOIN opcs_x_cats oxcest ON oxcest.id_opcion = pci1.estatus AND oxcest.id_catalogo = 23
         LEFT JOIN facturas f ON f.id_comision = com.id_comision
         
         WHERE $filtro_estatus 

         AND lo.idStatusContratacion > 8 
          GROUP BY pci1.id_comision, lo.nombreLote, re.nombreResidencial, co.nombre, lo.totalNeto2, com.comision_total, com.porcentaje_decimal, pci1.abono_neodata, pci1.pago_neodata, pci2.abono_pagado, pci1.estatus, pci1.fecha_abono, pci1.id_usuario, u.forma_pago, f.id_comision, pci1.id_pago_i, pac.porcentaje_abono, u.nombre, u.apellido_paterno,u.apellido_materno, oprol.nombre, oxcest.nombre, oxcest.id_opcion,  pci1.descuento_aplicado, cl.lugar_prospeccion, lo.referencia, com.estatus, pac.bonificacion, u.estatus)ORDER BY lo.nombreLote");

         
    }

 

    function getMktdRol(){
        return $this->db->query("SELECT * FROM usuarios WHERE id_rol in (18, 19, 20, 25, 26, 27, 28, 29, 30, 36, 50)");
    }




function getLotesOrigenmk($user){

  return $this->db->query("SELECT pci.id_pago_mk as idLote, abono_marketing as nombreLote, pci.id_pago_mk id_pago_i, pci.abono_marketing as comision_total, 0 abono_pagado, pci.pago_mktd pago_neodata 
    FROM pago_comision_mktd pci
    WHERE pci.estatus IN (1)  AND pci.id_usuario = $user ORDER BY pci.abono_marketing DESC");  
}


function getInformacionDataMK($var){

  return $this->db->query("SELECT pci.id_pago_mk as idLote, abono_marketing as nombreLote, pci.id_pago_mk id_comision, pci.abono_marketing as abono_neodata, 0 abono_pagado , pci.abono_marketing as comision_total
    FROM pago_comision_mktd pci
    WHERE pci.estatus IN (1)  AND pci.id_pago_mk = $var ORDER BY pci.abono_marketing DESC");
 
}

function obtenerIDMK($id){
    return $this->db->query("SELECT id_pago_mk id_comision, id_list, empresa from pago_comision_mktd WHERE id_pago_mk=$id");
}




   
       function update_descuentoMK($id_pago_i,$monto, $comentario, $usuario,$valor,$user,$pagos_aplicados){
           $estatus = 11;
 
           if($monto == 0){
               $respuesta = $this->db->query("UPDATE pago_comision_mktd SET estatus = $estatus, descuento = 1, creado_por= $usuario, fecha_pago_intmex = GETDATE(), fecha_abono = GETDATE(), comentario='DESCUENTO' WHERE id_pago_mk=$id_pago_i");
           }else{
               $respuesta = $this->db->query("UPDATE pago_comision_mktd SET estatus = $estatus, descuento=1, creado_por= $usuario, fecha_pago_intmex = GETDATE(), fecha_abono = GETDATE(), abono_marketing = $monto, comentario='DESCUENTO' WHERE id_pago_mk=$id_pago_i");
           }
       
               $respuesta = $this->db->query("INSERT INTO historial_comisiones VALUES ($id_pago_i, $usuario, GETDATE(), 1, 'M??TIVO DESCUENTO: ".$comentario."')");
       
       
           if (! $respuesta ) {
               return 0;
               } else {
               return 1;
               }
       }



       function insertar_descuentoMK($usuarioid,$monto,$ide_comision,$comentario,$usuario,$pago_neodata,$valor, $id_list, $empresa ){
    
    $estatus = 1;
 

        $respuesta = $this->db->query("INSERT INTO pago_comision_mktd(id_list, id_usuario, abono_marketing, fecha_abono, fecha_pago_intmex, pago_mktd, estatus, creado_por, comentario, descuento, empresa) 
          VALUES ('".$id_list."', $usuarioid, $monto, GETDATE(), GETDATE(), $pago_neodata, $estatus, $usuario, 'DESCUENTO NUEVO PAGO',0, '".$empresa."')");
        $insert_id = $this->db->insert_id();
     
        // $respuesta = $this->db->query("INSERT INTO historial_comisiones VALUES ($insert_id, $usuario, GETDATE(), 1, 'A ESTA COMISION SE LE APLICO UN DESCUENTO QUEDANDO ESTA CANTIDAD RESTANTE, M??TIVO DESCUENTO: ".$comentario."')");
    
    
        if (! $respuesta ) {
            return 0;
            } else {
            return 1;
            }
    } 





   
}