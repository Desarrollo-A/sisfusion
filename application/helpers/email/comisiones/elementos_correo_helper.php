<?php

namespace application\helpers\email\contraloria;

class Elementos_Correos_Contraloria
{

    CONST SET_FROM_EMAIL = array('no-reply@ciudadmaderas.com', 'Ciudad Maderas');

    /**************************************************************************************************************************************
     * VARIABLES MANDAN LO SIGUIENTE PARA FUNCION sendMailRecepExp:                                                                        *
     * 1.- EMAIL_SEND_MAIL_RECEP_EXP: PARTE DEL CUERPO DEL CORREO DANDO UNA INTRODUCCIÓN DEL MISMO.                                        *
     * 2.- ETIQUETAS_ENCABEZADO_TABLA_SEND_MAIL_RECEP_EXP: ETIQUETAS PARA COLOCAR LOS ENCABEZADOS DE LA TABLA QUE SE GENERA DINÁMICAMENTE  *
     **************************************************************************************************************************************/
    CONST EMAIL_SEND_MAIL_RECEP_EXP = 'ESTO ES UNA PRUEBA PARA EL MÓDULO DE CONTRALORÍA EN VISTA "Registros estatus 2.0 (recepción de expediente)"';
    CONST ETIQUETAS_ENCABEZADO_TABLA_SEND_MAIL_RECEP_EXP = array('nombreResidencial'    => 'Proyecto',
        'nombreCondominio'     => 'Condominio',
        'nombreLote'           => 'Lote',
        'fechaHora'            => 'Fecha/Hora');
    CONST ASUNTO_CORREO_TABLA_SEND_MAIL_RECEP_EXP = 'EXPEDIENTE INGRESADO-CIUDAD MADERAS';
    /*-----------------------------------------------------------------------------------------------------------------------------------*/

    /**************************************************************************************************************************************
     * VARIABLES MANDAN LO SIGUIENTE PARA FUNCION sendMailRechazoEst2_0:                                                                   *
     * 1.- EMAIL_SEND_MAIL_RECHAZO_ESTATUS_2_0: PARTE DEL CUERPO DEL CORREO DANDO UNA INTRODUCCIÓN DEL MISMO.                              *
     * 2.- ETIQUETAS_ENCABEZADO_TABLA_SEND_MAIL_RECHAZO_ESTATUS_2_0: ETIQUETAS PARA COLOCAR LOS ENCABEZADOS DE LA TABLA QUE SE GENERA DINÁMICAMENTE*
     **************************************************************************************************************************************/
    CONST EMAIL_SEND_MAIL_RECHAZO_ESTATUS_2_0 = 'ESTO ES UNA PRUEBA PARA EL MÓDULO DE CONTRALORÍA EN VISTA "Registro estatus 2 (integración de expediente)';
    CONST ETIQUETAS_ENCABEZADO_TABLA_SEND_MAIL_RECHAZO_ESTATUS_2_0 = array( 'nombreResidencial' => 'Proyecto',
        'nombreCondominio'  => 'Condominio',
        'nombreLote'        => 'Lote',
        'motivoRechazo'     => 'Motivo de rechazo',
        'fechaHora'         => 'Fecha/Hora');
    CONST ASUNTO_CORREO_TABLA_SEND_MAIL_RECHAZO_ESTATUS_2_0 = 'EXPEDIENTE RECHAZADO-CONTRALORÍA (2. Integración de Expediente)';
    /*-----------------------------------------------------------------------------------------------------------------------------------*/

    /*************************************************************************************************************************************
     * VARIABLES MANDAN LO SIGUIENTE PARA FUNCION editar_registro_loteRechazo_contraloria_proceceso5:                                     *
     *   1.- EMAIL_RECHAZO_STATUS_5: PARTE DEL CUERPO DEL CORREO DANDO UNA INTRODUCCIÓN DEL MISMO.                                        *
     *   2.-ETIQUETAS_ENCABEZADO_TABLA_RECHAZO_STATUS_5: ETIQUETAS PARA COLOCAR LOS ENCABEZADOS DE LA TABLA QUE SE GENERA DINÁMICAMENTE   *
     **************************************************************************************************************************************/
    CONST EMAIL_RECHAZO_STATUS_5 = 'Se le informa que el estatus del lote mencionado a continuación, ha cambiado a un estatus de tipo 
                                    "RECHAZADO", enseguida puede encontrar los comentarios y la información del lote afectado.';
    CONST ETIQUETAS_ENCABEZADO_TABLA_RECHAZO_STATUS_5 = array('nombreResidencial' => 'Proyecto',
        'nombre' => 'Condominio',
        'nombreLote' => 'Lote',
        'motivoRechazo' => 'Motivo de rechazo',
        'fechaHora' => 'Fecha/Hora');
    CONST ASUNTO_CORREO_TABLA_RECHAZO_STATUS_5 = 'EXPEDIENTE RECHAZADO-CONTRALORÍA (5. REVISIÓN 100%)';
    /*-----------------------------------------------------------------------------------------------------------------------------------*/

    /*************************************************************************************************************************************
     * VARIABLES MANDAN LO SIGUIENTE PARA FUNCION editar_registro_loteRechazo_contraloria_proceceso5_2:                                     *
     *   1.- EMAIL_RECHAZO_STATUS_5: PARTE DEL CUERPO DEL CORREO DANDO UNA INTRODUCCIÓN DEL MISMO.                                        *
     *   2.-ETIQUETAS_ENCABEZADO_TABLA_RECHAZO_STATUS_5: ETIQUETAS PARA COLOCAR LOS ENCABEZADOS DE LA TABLA QUE SE GENERA DINÁMICAMENTE   *
     **************************************************************************************************************************************/
    CONST EMAIL_RECHAZO_STATUS_5_2 = 'Se le informa que el estatus del lote mencionado a continuación, ha cambiado a un estatus de tipo 
                                    "RECHAZADO", enseguida puede encontrar los comentarios y la información del lote afectado.';
    CONST ETIQUETAS_ENCABEZADO_TABLA_RECHAZO_STATUS_5_2 = array('nombreResidencial' => 'Proyecto',
        'nombre'            => 'Condominio',
        'nombreLote'        => 'Lote',
        'motivoRechazo'     => 'Motivo de rechazo',
        'fechaHora'         => 'Fecha/Hora');
    CONST ASUNTO_CORREO_TABLA_RECHAZO_STATUS_5_2 = 'EXPEDIENTE RECHAZADO-CONTRALORÍA (5. REVISIÓN 100%)';
    /*----------------------------------------------------------------------------------------------------------------------------------*/

    /*************************************************************************************************************************************
     * VARIABLES MANDAN LO SIGUIENTE PARA FUNCION editar_registro_loteRechazo_contraloria_proceceso6:                                     *
     *   1.- EMAIL_RECHAZO_STATUS_5: PARTE DEL CUERPO DEL CORREO DANDO UNA INTRODUCCIÓN DEL MISMO.                                        *
     *   2.-ETIQUETAS_ENCABEZADO_TABLA_RECHAZO_STATUS_5: ETIQUETAS PARA COLOCAR LOS ENCABEZADOS DE LA TABLA QUE SE GENERA DINÁMICAMENTE   *
     *************************************************************************************************************************************/
    CONST EMAIL_RECHAZO_STATUS_6 = 'Se le informa que el estatus del lote mencionado a continuación, ha cambiado a un estatus de tipo 
                                    "RECHAZADO", enseguida puede encontrar los comentarios y la información del lote afectado.';
    CONST ETIQUETAS_ENCABEZADO_TABLA_RECHAZO_STATUS_6 = array('nombreResidencial'   => 'Proyecto',
        'nombre'              => 'Condominio',
        'nombreLote'          => 'Lote',
        'motivoRechazo'       => 'Motivo de rechazo',
        'fechaHora'           => 'Fecha/Hora');
    CONST ASUNTO_CORREO_TABLA_RECHAZO_STATUS_6 = 'EXPEDIENTE RECHAZADO-CONTRALORÍA (6. CORRIDA ELABORADA)';
    /*-----------------------------------------------------------------------------------------------------------------------------------*/
}
