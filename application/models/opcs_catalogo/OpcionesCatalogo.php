<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class OpcionesCatalogo extends CI_Model
{
    // TODO: revisar en PRUEBAS Y PRODUCCIÓN SI ESTÁ ESTE NÚMERO Y CAMBIARLO EN CASO DE EXISTIR
    const AUTORIZACION_CORREO_CLIENTE_ASESOR = 93; // Estatus de autorizaciones del correo que envía el asesor al cliente
    const TIPO_AUTORIZACION_CLIENTE = 94; // Tipo de autorización si es correo o SMS
}