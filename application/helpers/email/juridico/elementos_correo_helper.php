<?php
namespace application\helpers\email\juridico;

class Elementos_Correo_Juridico
{
    
    CONST SET_FROM_EMAIL = array('no-reply@ciudadmaderas.com', 'Ciudad Maderas');

    /**************************************************************************************************************************************
    * VARIABLES MANDAN LO SIGUIENTE PARA FUNCION editar_registro_loteRechazoAstatus2_asistentes_proceceso8:                               *
    * 1.- EMAIL_RECHAZO_ESTATUS_8: PARTE DEL CUERPO DEL CORREO DANDO UNA INTRODUCCION DEL MISMO.                                          *
    * 2.- ETIQUETAS_ENCABEZADO_TABLA_RECHAZO_ESTATUS_8: ETIQUETAS PARA COLOCAR LOS ENCABEZADOS DE LA TABLA QUE SE GENERA DINAMICAMENTE    *
    **************************************************************************************************************************************/
    CONST EMAIL_ENVIO_CORREO_RECHAZO_ESTATUS_3 = 'Se ha rechazado el registro en estatus 7 (Asesor).
                                                  En seguida se podrá visualizar la información del registro junto con los comentarios realizados.';
    CONST ETIQUETAS_ENCABEZADO_TABLA_ENVIO_CORREO_RECHAZO_ESTATUS_3 = array('nombreResidencial' =>  'Proyecto',
                                                                            'nombre'            =>  'Condominio',
                                                                            'nombreLote'        =>  'Lote',
                                                                            'motivoRechazo'     =>  'Motivo de rechazo',
                                                                            'fechaHora'         =>  'Fecha/Hora');
    CONST ASUNTO_CORREO_TABLA_ENVIO_CORREO_RECHAZO_ESTATUS_3 = 'EXPEDIENTE RECHAZADO-JURÍDICO (7. ELABORACIÓN DE CONTRATO)';
}
?>