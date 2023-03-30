<?php
namespace application\helpers\email\registro_cliente;

class Elementos_Correo_Registro_Cliente
{
    
    CONST SET_FROM_EMAIL = array('no-reply@ciudadmaderas.com', 'Ciudad Maderas');

    /**************************************************************************************************************************************
    * VARIABLES MANDAN LO SIGUIENTE PARA FUNCION editar_ds_ea:                                                                            *
    * 1.- EMAIL_DEPOSITO_SERIEDAD: PARTE DEL CUERPO DEL CORREO DANDO UNA INTRODUCCION DEL MISMO.                                          *
    * 2.- ETIQUETAS_ENCABEZADO_TABLA_DEPOSITOS_SERIEDAD: ETIQUETAS PARA COLOCAR LOS ENCABEZADOS DE LA TABLA QUE SE GENERA DINAMICAMENTE    *
    **************************************************************************************************************************************/
    CONST EMAIL_DEPOSITO_SERIEDAD = '<h1>Ciudad Maderas</h1>
                                    <p>Se adjunta el archivo Depósito de seriedad correspondiente.</p>';
    CONST ETIQUETAS_ENCABEZADO_TABLA_DEPOSITOS_SERIEDAD = array('');
    CONST ASUNTO_CORREO_TABLA_DEPOSITOS_SERIEDAD = 'DEPÓSITO DE SERIEDAD-CIUDAD MADERAS';
    /*************************************************************************************************************************************/

    /**************************************************************************************************************************************
    * VARIABLES MANDAN LO SIGUIENTE PARA FUNCION sendAut:                                                                                 *
    * 1.- EMAIL_SOLICITUD_AUTORIZACION_CONTRATACION: PARTE DEL CUERPO DEL CORREO DANDO UNA INTRODUCCION DEL MISMO.                        *
    * 2.- ETIQUETAS_ENCABEZADO_TABLA_SOLICITUD_AUTORIZACION_CONTRATACION: ETIQUETAS PARA COLOCAR LOS ENCABEZADOS DE LA TABLA QUE SE       *
    *     GENERA DINAMICAMENTE                                                                                                            *
    **************************************************************************************************************************************/
    CONST EMAIL_SOLICITUD_AUTORIZACION_CONTRATACION = 'PRUEBA PARA SOLICITUD DE CONTRATACION';
    CONST ETIQUETAS_ENCABEZADO_TABLA_SOLICITUD_AUTORIZACION_CONTRATACION = array("nombreResidencial"=> "Proyecto",
                                                                                "nombreCondominio"  =>  "Condominio",
                                                                                "nombreLote"        =>  "Lote",
                                                                                "motivoAut"         =>  "Autorización",
                                                                                "fechaHora"         =>  "Fecha/Hora");
    CONST ASUNTO_CORREO_TABLA_SOLICITUD_AUTORIZACION_CONTRATACION = 'SOLICITUD DE AUTORIZACIÓN-CONTRATACIÓN';
    /*************************************************************************************************************************************/

    /**************************************************************************************************************************************
    * VARIABLES MANDAN LO SIGUIENTE PARA FUNCION notifyUsers:                                                                                 *
    * 1.- EMAIL_SOLICITUD_ASESOR_AUTORIZACIONES: PARTE DEL CUERPO DEL CORREO DANDO UNA INTRODUCCION DEL MISMO.                        *
    * 2.- ETIQUETAS_ENCABEZADO_TABLA_SOLICITUD_ASESOR_AUTORIZACIONES: ETIQUETAS PARA COLOCAR LOS ENCABEZADOS DE LA TABLA QUE SE       *
    *     GENERA DINAMICAMENTE                                                                                                            *
    **************************************************************************************************************************************/
    CONST EMAIL_SOLICITUD_ASESOR_AUTORIZACIONES = 'Solicitud asesor';
    CONST ETIQUETAS_ENCABEZADO_TABLA_SOLICITUD_ASESOR_AUTORIZACIONES = array("nombreResidencial"=> "Proyecto",
                                                                             "nombreCondominio"  =>  "Condominio",
                                                                             "nombreLote"        =>  "Lote",
                                                                             "motivoAut"         =>  "Autorización",
                                                                             "fechaHora"         =>  "Fecha/Hora");
    CONST ASUNTO_CORREO_TABLA_SOLICITUD_ASESOR_AUTORIZACIONES = 'SOLICITUD DE AUTORIZACIÓN-CONTRATACIÓN';
    /*************************************************************************************************************************************/

    /**************************************************************************************************************************************
    * VARIABLES MANDAN LO SIGUIENTE PARA FUNCION deleteCorrida:                                                                           *
    * 1.- EMAIL_ELIMINAR_ARCHIVO_CORRIDA: PARTE DEL CUERPO DEL CORREO DANDO UNA INTRODUCCION DEL MISMO.                                   *
    * 2.- ETIQUETAS_ENCABEZADO_TABLA_ELIMINAR_ARCHIVO_CORRIDA: ETIQUETAS PARA COLOCAR LOS ENCABEZADOS DE LA TABLA QUE SE                  *
    *     GENERA DINAMICAMENTE                                                                                                            *
    **************************************************************************************************************************************/
    CONST EMAIL_ELIMINAR_ARCHIVO_CORRIDA = 'Se elimino definivamente el archivo (CORRIDA) del registro que se menciona acontinuacion.';
    CONST ETIQUETAS_ENCABEZADO_TABLA_ELIMINAR_ARCHIVO_CORRIDA = array(  "nombreResidencial" =>  "Proyecto",
                                                                        "nombre"            =>  "Condominio",
                                                                        "nombreLote"        =>  "Lote",
                                                                        "observacion"       =>  "Observación",
                                                                        "fechaHora"         =>  "Fecha/Hora");
    CONST ASUNTO_CORREO_TABLA_ELIMINAR_ARCHIVO_CORRIDA = 'MODIFICACIÓN DE CORRIDA FINANCIERA';

}
?>