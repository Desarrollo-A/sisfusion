<?php 

namespace application\helpers\email\asesor;

class Elementos_Correos_Asesor
{
    CONST SET_FROM_EMAIL = array('no-reply@ciudadmaderas.com', 'Ciudad Maderas');

    /***************************************************************************************************************************************
    * VARIABLES MANDAN LO SIGUIENTE PARA FUNCION addAutorizacionSbmt:                                                                      *
    * 1.- EMAIL_NUEVA_AUTORIZACION_SBMT: PARTE DEL CUERPO DEL CORREO DANDO UNA INTRODUCCION DEL MISMO.                                           *
    * 2.- ETIQUETAS_ENCABEZADO_TABLA_NUEVA_AUTORIZACION_SBMT: ETIQUETAS PARA COLOCAR LOS ENCABEZADOS DE LA TABLA QUE SE GENERA DINAMICAMENTE     *
    ***************************************************************************************************************************************/
    CONST EMAIL_NUEVA_AUTORIZACION_SBMT = 'SOLICITUD DE AUTORIZACION';
    CONST ETIQUETAS_ENCABEZADO_TABLA_NUEVA_AUTORIZACION_SBMT = array( 'nombreResidencial' => 'Proyecto',
                                                                    'nombreCondominio'  => 'Condominio',
                                                                    'nombreLote'        => 'Lote', 
                                                                    'motivoAut'         => 'Autorización',
                                                                    'fecgaHora'         => 'Fecha/Hora');
    CONST ASUNTO_CORREO_TABLA_NUEVA_AUTORIZACION_SBMT = 'SOLICITUD DE AUTORIZACIÓN-CONTRATACIÓN';
    /*-----------------------------------------------------------------------------------------------------------------------------------*/

    /******************************************************************************************************************************************
    * VARIABLES MANDAN LO SIGUIENTE PARA FUNCION editar_ds:                                                                                   *
    * 1.- EMAIL_DEPOSITO_SERIEDAD_ASESOR: PARTE DEL CUERPO DEL CORREO DANDO UNA INTRODUCCION DEL MISMO.                                       *
    * 2.- ETIQUETAS_ENCABEZADO_TABLA_DEPOSITOS_SERIEDAD_ASESOR: ETIQUETAS PARA COLOCAR LOS ENCABEZADOS DE LA TABLA QUE SE GENERA DINAMICAMENTE*
    ******************************************************************************************************************************************/
    CONST EMAIL_DEPOSITO_SERIEDAD_ASESOR = '<h1>Ciudad Maderas</h1> <p>A continuación se adjunta el archivo correspondiente a Depósito de seriedad.</p>';
    CONST ETIQUETAS_ENCABEZADO_TABLA_DEPOSITOS_SERIEDAD_ASESOR = array('');
    CONST ASUNTO_CORREO_TABLA_DEPOSITOS_SERIEDAD_ASESOR = 'DEPÓSITO DE SERIEDAD-CIUDAD MADERAS';
    /*************************************************************************************************************************************/

    /******************************************************************************************************************************************
    * VARIABLES MANDAN LO SIGUIENTE PARA FUNCION notifyRejEv:                                                                                   *
    * 1.- EMAIL_EVIDENCIAS_RECHAZADAS_ASESOR: PARTE DEL CUERPO DEL CORREO DANDO UNA INTRODUCCION DEL MISMO.                                       *
    * 2.- ETIQUETAS_ENCABEZADO_TABLA_EVIDENCIAS_RECHAZADAS_ASESOR: ETIQUETAS PARA COLOCAR LOS ENCABEZADOS DE LA TABLA QUE SE GENERA DINAMICAMENTE*
    ******************************************************************************************************************************************/
    CONST EMAIL_EVIDENCIAS_RECHAZADAS_ASESOR = 'SISTEMA DE CONTRATACIÓN<br>
                                                <h3>¡ Buenos días estimad@ !</h3>
                                                <p style="text-align: center;">
                                                    ¿Cómo está?, espero que bien, te adjunto el reporte semanal de las evidencias rechazadas por
                                                    <b>cobranza/contraloria</b>, te invito a leer las observaciones. Recuerda que deben ser corregidas a más
                                                    tardar los jueves a las 12:00 PM, con esto ayudas a que el proceso en cobranza sea en tiempo y forma,
                                                    dando como resultado el cobro a tiempo de las comisiones.
                                                </p>';
    CONST ETIQUETAS_ENCABEZADO_TABLA_EVIDENCIAS_RECHAZADAS_ASESOR = array('nombreSolicitante'       =>  'Solicitante',
                                                                          'nombreLote'              =>  'Lote',
                                                                          'comentario_autorizacion' =>  'Comentario',
                                                                          'fecha_creacion'          =>  'Fecha/Hora');

    CONST ASUNTO_CORREO_TABLA_EVIDENCIAS_RECHAZADAS_ASESOR = '[REPORTE] EVIDENCIAS RECHAZADAS PARA: ';
    /*************************************************************************************************************************************/
}
?>