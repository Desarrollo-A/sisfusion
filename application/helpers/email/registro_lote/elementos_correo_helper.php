<?php
namespace application\helpers\email\registro_lote;

class Elementos_Correo_Registro_Lote
{
    
    CONST SET_FROM_EMAIL = array('no-reply@ciudadmaderas.com', 'Ciudad Maderas');

    /**************************************************************************************************************************************
    * VARIABLES MANDAN LO SIGUIENTE PARA FUNCION editar_registro_lote_caja:                                                                            *
    * 1.- EMAIL_EDITAR_REGISTRO_LOTE_BLOQUEO_CAJA: PARTE DEL CUERPO DEL CORREO DANDO UNA INTRODUCCIÓN DEL MISMO.                                          *
    * 2.- ETIQUETAS_ENCABEZADO_TABLA_EDITAR_REGISTRO_LOTE_BLOQUEO_CAJA: ETIQUETAS PARA COLOCAR LOS ENCABEZADOS DE LA TABLA QUE SE GENERA DINÁMICAMENTE    *
    **************************************************************************************************************************************/
    CONST EMAIL_EDITAR_REGISTRO_LOTE_BLOQUEO_CAJA = '<h4><center>Lote Bloqueado:</center></h4>';
    CONST ETIQUETAS_ENCABEZADO_TABLA_EDITAR_REGISTRO_LOTE_BLOQUEO_CAJA = array( 'nombreResidencial' =>  'Proyecto',
                                                                                'nombreCondominio'  =>  'Condominio',
                                                                                'nombreLote'        =>  'Lote',
                                                                                'create_at'         =>  'Fecha/Hora');
    CONST ASUNTO_CORREO_TABLA_EDITAR_REGISTRO_LOTE_BLOQUEO_CAJA = 'LOTE BLOQUEADO-CIUDAD MADERAS';
    /*************************************************************************************************************************************/

    /**************************************************************************************************************************************
    * VARIABLES MANDAN LO SIGUIENTE PARA FUNCION mailBloqueosAfter45:                                                                            *
    * 1.- EMAIL_LOTES_BLOQUEADOS_A_FECHA: PARTE DEL CUERPO DEL CORREO DANDO UNA INTRODUCCIÓN DEL MISMO.                                          *
    * 2.- ETIQUETAS_ENCABEZADO_TABLA_LOTES_BLOQUEADOS_A_FECHA: ETIQUETAS PARA COLOCAR LOS ENCABEZADOS DE LA TABLA QUE SE GENERA DINÁMICAMENTE    *
    **************************************************************************************************************************************/
    CONST EMAIL_LOTES_BLOQUEADOS_A_FECHA = 'Lotes Bloqueados al: ';
    CONST ETIQUETAS_ENCABEZADO_TABLA_LOTES_BLOQUEADOS_A_FECHA = array(  'nombreResidencial' =>  'Proyecto',
                                                                        'nombreCondominio'  =>  'Condominio',
                                                                        'nombreLote'        =>  'Lote',
                                                                        'create_at'         =>  'Fecha Bloqueo',
                                                                        'diasDiferencia'    =>  'Días acumulados con estatus Bloqueado');
    CONST ASUNTO_CORREO_TABLA_LOTES_BLOQUEADOS_A_FECHA = 'LOTES BLOQUEADOS-CIUDAD MADERAS';
    /*************************************************************************************************************************************/
}
?>