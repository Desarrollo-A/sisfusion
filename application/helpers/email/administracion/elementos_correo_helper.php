<?php 
namespace application\helpers\email\administracion;

class Elementos_Correos_Admin
{
    CONST SET_FROM_EMAIL = array('no-reply@ciudadmaderas.com', 'Ciudad Maderas');

    /**************************************************************************************************************************************
    * VARIABLES MANDAN LO SIGUIENTE PARA FUNCION editar_registro_loteRechazo_administracion_proceceso11:                                  *
    * 1.- EMAIL_RECHAZO_ADMIN_PROC_11: PARTE DEL CUERPO DEL CORREO DANDO UNA INTRODUCCION DEL MISMO.                                      *
    * 2.- ETIQUETAS_ENCABEZADO_TABLA_RECHAZO_STATUS_5: ETIQUETAS PARA COLOCAR LOS ENCABEZADOS DE LA TABLA QUE SE GENERA DINAMICAMENTE     *
    **************************************************************************************************************************************/
    CONST EMAIL_RECHAZO_ADMIN_PROC_11 = 'Hemos registrado un cambio de estatus al tipo "RECHAZADO" de parte de administración,
                                        enseguida puede encontrar los comentarios y la información correspondiente respecto a dicho cambio.';
    CONST ETIQUETAS_ENCABEZADO_TABLA_RECHAZO_ADMIN_PROC_11 = array( 'nombreResidencial' => 'Proyecto',
                                                                    'nombreCondominio'  => 'Condominio',
                                                                    'nombreLote'        => 'Lote', 
                                                                    'nombreCliente'     => 'Cliente',
                                                                    'nombreRechaza'     => 'Usuario',
                                                                    'fechaApartado'     => 'Fecha Apartado',
                                                                    'fechaRechazo'      => 'Fecha Rechazo');
    CONST ASUNTO_CORREO_TABLA_RECHAZO_ADMIN_PROC_11 = '[RECHAZO ADMINISTRACIÓN]';
    /*-----------------------------------------------------------------------------------------------------------------------------------*/
}
?>