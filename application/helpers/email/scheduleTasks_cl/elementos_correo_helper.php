<?php
namespace application\helpers\email\scheduleTasks_cl;

class Elementos_Correo_ScheduleTasks_Cl
{
    
    CONST SET_FROM_EMAIL = array('no-reply@ciudadmaderas.com', 'Ciudad Maderas');

    /**************************************************************************************************************************************
    * VARIABLES MANDAN LO SIGUIENTE PARA FUNCION sendRv5:                                                                            *
    * 1.- EMAIL_LOTES_SIN_INTEGRAR_EXPEDIENTE: PARTE DEL CUERPO DEL CORREO DANDO UNA INTRODUCCION DEL MISMO.                                          *
    * 2.- ETIQUETAS_ENCABEZADO_TABLA_LOTES_SIN_INTEGRAR_EXPEDIENTE: ETIQUETAS PARA COLOCAR LOS ENCABEZADOS DE LA TABLA QUE SE GENERA DINAMICAMENTE    *
    **************************************************************************************************************************************/
    CONST EMAIL_LOTES_SIN_INTEGRAR_EXPEDIENTE = 'Acumulado de lotes sin integrar Expediente';
    CONST ETIQUETAS_ENCABEZADO_TABLA_LOTES_SIN_INTEGRAR_EXPEDIENTE = array( 'nombreResidencial' =>  'Plaza',
                                                                            'nombreCondominio'  =>  'Condominio',
                                                                            'nombreLote'        =>  'Lote',
                                                                            'fechaApartado'     =>  'Fecha Apartado',
                                                                            'nomCliente'        =>  'Cliente',
                                                                            'gerente'           =>  'Gerente',
                                                                            'coordinador'       =>  'Coordinador',
                                                                            'asesor'            =>  'Asesor',
                                                                            'diasAcumulados'    =>  'Días acumulados sin integrar Expediente');
    CONST ASUNTO_CORREO_TABLA_LOTES_SIN_INTEGRAR_EXPEDIENTE = 'Acumulado de lotes sin integrar Expediente al: ';
    /*************************************************************************************************************************************/

    /**************************************************************************************************************************************
    * VARIABLES MANDAN LO SIGUIENTE PARA FUNCION mailBloqueosAfter45:                                                                     *
    * 1.- EMAIL_LOTES_BLOQUEADOS_45_DIAS: PARTE DEL CUERPO DEL CORREO DANDO UNA INTRODUCCION DEL MISMO.                                          *
    * 2.- ETIQUETAS_ENCABEZADO_TABLA_LOTES_BLOQUEADOS_45_DIAS: ETIQUETAS PARA COLOCAR LOS ENCABEZADOS DE LA TABLA QUE SE GENERA DINAMICAMENTE    *
    **************************************************************************************************************************************/
    CONST EMAIL_LOTES_BLOQUEADOS_45_DIAS = 'Lotes Bloqueados al: ';
    CONST ETIQUETAS_ENCABEZADO_TABLA_LOTES_BLOQUEADOS_45_DIAS = array('nombreResidencial' =>  'Proyecto',
                                                                      'nombreCondominio'  =>  'Condominio',
                                                                      'nombreLote'        =>  'Lote',
                                                                      'sup'               =>  'Superficie',
                                                                      'gerente'           =>  'Gerente',
                                                                      'coordinador'       =>  'Coordinador',
                                                                      'asesor'            =>  'Asesor',
                                                                      'create_at'         =>  'Fecha Bloqueo',
                                                                      'countDias'         =>  'Días acumulados con estatus Bloqueado');
    CONST ASUNTO_CORREO_TABLA_LOTES_BLOQUEADOS_45_DIAS = 'LOTES BLOQUEADOS-CIUDAD MADERAS';
    /*************************************************************************************************************************************/

    /**************************************************************************************************************************************
    * VARIABLES MANDAN LO SIGUIENTE PARA FUNCION sendMailReportER --> notifyRejEv:                                                        *
    * 1.- EMAIL_REPORTE_EVIDENCIAS_RECHAZADAS_CONTRALORÍA: PARTE DEL CUERPO DEL CORREO DANDO UNA INTRODUCCION DEL MISMO.                              *
    * 2.- ETIQUETAS_ENCABEZADO_TABLA_REPORTE_EVIDENCIAS_RECHAZADAS_CONTRALORÍA: ETIQUETAS PARA COLOCAR LOS ENCABEZADOS DE LA TABLA QUE SE             *
    *     GENERA DINAMICAMENTE.                                                                                                           *
    * 3.- NO EXISTE ASUNTO COMO CONSTANTE YA QUE DENTRO DE ESTA FUNCION (sendMailReportER) VARIA DEPENDIENTO EL ROL DEL USUARIO           *
    **************************************************************************************************************************************/
    CONST EMAIL_REPORTE_EVIDENCIAS_RECHAZADAS_CONTRALORÍA = '<h3>¡Buenos días estimad@!</h3>
                                                            <p style="padding: 10px 90px;text-align: justify;">
                                                                ¿Cómo estás?, espero que bien, te adjunto el reporte semanal de las
                                                                evidencias donde se removió <b>marketing digital</b> de la venta, 
                                                                te invito a leer las observaciones.
                                                            </p>';

    CONST ETIQUETAS_ENCABEZADO_TABLA_REPORTE_EVIDENCIAS_RECHAZADAS_CONTRALORÍA = array( 'idLote'            =>  'ID lote',
                                                                                        'nombreLote'        =>  'Lote',
                                                                                        'observacion'       =>  'Comentario',
                                                                                        'nombreCliente'     =>  'Cliente',
                                                                                        'nombreSolicitante' =>  'Usuario',
                                                                                        'fecha_creacion'    =>  'Fecha');
    
    CONST EMAIL_REPORTE_EVIDENCIAS_RECHAZADAS_MKTD =   '<h3>¡ Buenos días estimad@ !</h3>
                                                        <p style="padding: 10px 90px;text-align: justify;">
                                                            ¿Cómo estás?, espero que bien, te adjunto el reporte semanal de las 
                                                            evidencias rechazadas por <b>cobranza/contraloría</b>, te invito a leer las 
                                                            observaciones. Recuerda que deben ser corregidas a más tardar los jueves a las
                                                            12:00 PM, con esto ayudas a que el proceso en cobranza sea en tiempo y forma, 
                                                            dando como resultado el cobro a tiempo de las comisiones.
                                                        </p>';
    CONST ETIQUETAS_ENCABEZADO_TABLA_REPORTE_EVIDENCIAS_RECHAZADAS_MKTD = array('weekNumber'    =>  'Número semana',
                                                                                'plaza'         =>  'Plaza',
                                                                                'nombreSolicitante' =>  'Solicitante',
                                                                                'nombreLote'    =>  'Lote',
                                                                                'comentario_autorizacion'   =>  'Comentario',
                                                                                'fecha_creacion'=>  'Fecha creación',
                                                                                'fechaRechazo'  =>  'Fecha rechazo');
    /*************************************************************************************************************************************/

    /**************************************************************************************************************************************
    * VARIABLES MANDAN LO SIGUIENTE PARA FUNCION mailContentComptrollerNotification --> sendComptrollerNotification:                      *
    * 1.- EMAIL_REPORTE_ESTATUS_10: PARTE DEL CUERPO DEL CORREO DANDO UNA INTRODUCCION DEL MISMO.                              *
    * 2.- ETIQUETAS_ENCABEZADO_TABLA_REPORTE_ESTATUS_10: ETIQUETAS PARA COLOCAR LOS ENCABEZADOS DE LA TABLA QUE SE             *
    *     GENERA DINAMICAMENTE.                                                                                                           *
    * 3.- NO EXISTE ASUNTO COMO CONSTANTE YA QUE DENTRO DE ESTA FUNCION (sendMailReportER) VARIA DEPENDIENTO EL ROL DEL USUARIO           *
    **************************************************************************************************************************************/
    CONST EMAIL_REPORTE_ESTATUS_10 ='<h3>¡ Buenos días estimad@ !</h3>
                                     <p style="padding: 10px 90px;text-align: center;">
                                        ¿Cómo estás?, espero que bien. Este es el listado de todos los registros de 
                                        lotes cuyo contrato se envió a firma de RL.
                                     </p>';

    CONST ETIQUETAS_ENCABEZADO_TABLA_REPORTE_ESTATUS_10 =  array('nombreSede'       => 'SEDE',
                                                                 'nombreResidencial' => 'PROYECTO',
                                                                 'nombreCondominio'  => 'CONDOMINIO',
                                                                 'nombreLote'        => 'LOTE',
                                                                 'nombreCliente'     => 'CLIENTE',
                                                                 'sup'               => 'SUPERFICIE',
                                                                 'referencia'        => 'REFERENCIA',
                                                                 'nombreGerente'     => 'GERENTE',
                                                                 'nombreAsesor'      => 'ASESOR',
                                                                 'estatusLote'       => 'ESTATUS',
                                                                 'fechaApartado'     => 'FECHA APARTADO');
    CONST ASUNTO_CORREO_TABLA_REPORTE_ESTATUS_10 = 'REPORTE_ESTATUS_10 ';
    
    CONST EMAIL_REPORTE_LOTES_LIBERAR = '<h3>¡ Buenos días estimad@ !</h3>
                                         <p style="padding: 10px 90px;text-align: center;">
                                            ¿Cómo estás?, espero que bien. Este es el listado de todos los registros de 
                                            lotes que se marcaron para liberación.
                                         </p>';
    CONST ETIQUETAS_ENCABEZADO_TABLA_REPORTE_LOTES_LIBERAR = array( 'nombreResidencial' =>  'PROYECTO',
                                                                    'nombreCondominio'  =>  'CONDOMINIO',
                                                                    'nombreLote'        =>  'LOTE',
                                                                    'sup'               =>  'SUPERFICIE',
                                                                    'referencia'        =>  'REFERENCIA',
                                                                    'nombreGerente'     =>  'GERENTE',
                                                                    'nombreAsesor'      =>  'ASESOR',
                                                                    'estatusLote'       =>  'ESTATUS',
                                                                    'fechaApartado'     =>  'FECHA APARTADO',
                                                                    'fechaLiberacion'   =>  'FECHA LIBERACIÓN');
    CONST ASUNTO_CORREO_TABLA_REPORTE_LOTES_LIBERAR = 'REPORTE LOTES PARA LIBERAR ';

    CONST EMAIL_REPORTE_ESTATUS_10_NOTIFICACION_SIN_REGISTRO = '<h3>¡ Buenos días estimad@ !</h3>
                                                                <p style="padding: 10px 90px;text-align: center;">
                                                                    ¿Cómo estás?, espero que bien. El día de hoy no hay
                                                                    registros de lotes cuyo contrato se envió a firma de RL.
                                                                </p>';
    /*************************************************************************************************************************************/

    /**************************************************************************************************************************************
    * VARIABLES MANDAN LO SIGUIENTE PARA FUNCION sendRv5:                                                                            *
    * 1.- EMAIL_LOTES_SIN_INTEGRAR_EXPEDIENTE: PARTE DEL CUERPO DEL CORREO DANDO UNA INTRODUCCION DEL MISMO.                                          *
    * 2.- ETIQUETAS_ENCABEZADO_TABLA_LOTES_SIN_INTEGRAR_EXPEDIENTE: ETIQUETAS PARA COLOCAR LOS ENCABEZADOS DE LA TABLA QUE SE GENERA DINAMICAMENTE    *
    **************************************************************************************************************************************/
    CONST EMAIL_CAMBIO_CONTRASEÑA = '<h3>¡ Buenos días estimad@ !</h3>
                                     <p style="padding: 10px 90px;text-align: center;">
                                        A continuacion se muestra usuario, nueva contraseña y tiempo de validez para la informacion dada.
                                     </p>';
    CONST ETIQUETAS_ENCABEZADO_TABLA_CAMBIO_CONTRASEÑA = array( 'usuario'       =>  'USUARIO',
                                                                'contraseña'    =>  'CONTRASEÑA NUEVA',
                                                                'diasVencer'    =>  'DÍAS VALIDOS',
                                                                'fechaAccion'   =>  'FECHA CREACION');
    CONST ASUNTO_CORREO_TABLA_CAMBIO_CONTRASEÑA = 'Cambio de contraseña ASESOR COMODÍN.';
    /*************************************************************************************************************************************/
}
?>