<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Meses extends CI_Controller {
	
	public function mes($mes = null){

       $this->load->helper('utilidades');
       echo json_encode(obtener_mes($mes));
        
    }
}