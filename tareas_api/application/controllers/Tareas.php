<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tareas extends CI_Controller {


    public function alumnos_conteo(){

        $this->load->database();

        $query = $this->db->query('SELECT * FROM alumnos');

        echo json_encode($query->num_rows());
    }

    public function alumnos_listado(){

        $this->load->database();

        $query = $this->db->query('SELECT a.*, (parcial1*parcial2*parcial3)/3 as promedio  FROM alumnos a');

        echo json_encode($query->result());
    }



    public function index()
	{
		echo "Hello Tareas";
	}

}