<?php namespace App\Controllers;

use CodeIgniter\Controller;

class Meses extends Controller
{
    public function index()
    {
        echo 'Hello World!';
    }

    public function mes($id = null){

       $this->load->helper('utilidades');
       echo json_encode(obtener_mes($mes));
        
    }
}