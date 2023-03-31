<?php
namespace application\helpers\email\comisiones;

class Elementos_Correo_Ceder_Comisiones
{
    
    CONST SET_FROM_EMAIL = array('no-reply@ciudadmaderas.com', 'Ciudad Maderas');

    /**************************************************************************************************************************************
    * VARIABLES MANDAN LO SIGUIENTE PARA FUNCION editar_registro_lote_caja:                                                                            *
    * 1.- EMAIL_EDITAR_REGISTRO_LOTE_BLOQUEO_CAJA: PARTE DEL CUERPO DEL CORREO DANDO UNA INTRODUCCIÓN DEL MISMO.                                          *
    * 2.- ETIQUETAS_ENCABEZADO_TABLA_EDITAR_REGISTRO_LOTE_BLOQUEO_CAJA: ETIQUETAS PARA COLOCAR LOS ENCABEZADOS DE LA TABLA QUE SE GENERA DINÁMICAMENTE    *
    **************************************************************************************************************************************/
    CONST EMAIL_CEDER_COMISIONES = 'Ceder comisiones';
    CONST ETIQUETAS_ENCABEZADO_TABLA_CEDER_COMISIONES = array('id_lote'     =>  'ID LOTE',
                                                              'nombreLote'  =>  'LOTE',
                                                              'com_total'   =>  'COMISIÓN TOTAL',
                                                              'tope'        =>  'COMISIÓN TOPADA',
                                                              'resto'       =>  'COMISIÓN TOTAL NUEVO ASESOR');
    CONST ASUNTO_CORREO_TABLA_CEDER_COMISIONES = 'COMISIONES CEDIDAS';
    /*************************************************************************************************************************************/
}
?>