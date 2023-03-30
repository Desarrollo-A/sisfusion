<?php
namespace application\helpers\email\asistenete_gerente;

class Elementos_Correo_Asistenete_Gerente
{
    
    CONST SET_FROM_EMAIL = array('no-reply@ciudadmaderas.com', 'Ciudad Maderas');

    /**************************************************************************************************************************************
    * VARIABLES MANDAN LO SIGUIENTE PARA FUNCION editar_registro_loteRechazoAstatus2_asistentes_proceceso8:                               *
    * 1.- EMAIL_RECHAZO_ESTATUS_8: PARTE DEL CUERPO DEL CORREO DANDO UNA INTRODUCCIÓN DEL MISMO.                                          *
    * 2.- ETIQUETAS_ENCABEZADO_TABLA_RECHAZO_ESTATUS_8: ETIQUETAS PARA COLOCAR LOS ENCABEZADOS DE LA TABLA QUE SE GENERA DINÁMICAMENTE    *
    **************************************************************************************************************************************/
    CONST EMAIL_RECHAZO_ESTATUS_8 = 'Se ha rechazado el registro en estatus 8 (Contrato entregado al asesor para firma del cliente).
                                    En seguida se podrá visualizar la información del registro junto con los comentarios realizados.';
    CONST ETIQUETAS_ENCABEZADO_TABLA_RECHAZO_ESTATUS_8 = array( 'nombreResidencial' =>  'Proyecto',
                                                                'nombre'            =>  'Condominio',
                                                                'nombreLote'        =>  'Lote',
                                                                'motivoRechazo'     =>  'Motivo de rechazo',
                                                                'fechaHora'         =>  'Fecha/Hora');
    CONST ASUNTO_CORREO_TABLA_RECHAZO_ESTATUS_8 = 'EXPEDIENTE RECHAZADO-VENTAS (8. CONTRATO ENTREGADO AL ASESOR PARA FIRMA DEL CLIENTE)';
}


?>