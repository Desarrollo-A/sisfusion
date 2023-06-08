<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class EstatusAutorizacionesOpcs extends CI_Model
{
    const AUTORIZADA = 0;
    const PENDIENTE = 1;
    const RECHAZADA = 2;
    const DC = 3;
}