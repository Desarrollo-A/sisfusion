<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PagoInvoice_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insertMany($data)
    {
        $this->db->insert_batch('pagos_invoice', $data);
    }
}