<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class NeodataCobranza_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->cobranza = $this->load->database('cobranza', TRUE);
    }

    public function getInformation() {
        return $this->cobranza->query("EXEC [crm].[sp_getLotesCobranza]");
    }

}