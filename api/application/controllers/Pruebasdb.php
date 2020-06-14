<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pruebasdb extends CI_Controller {

   public function __construct(){
      parent::__construct();

      $this->load->database();
      $this->load->helper('utilidades');

   }

   public function insertar(){

      $data = array(
         'nombre' => 'giovanny',
         'apellido' => 'ospina'
      );

      $data = capitalizar_todo($data);

      $this->db->insert('test', $data);

      $respuesta = array(
         'err' => false,
         'id_insertado' => $this->db->insert_id()
      );

      echo json_encode($respuesta);

   }

   public function insertar_multiple(){

      $data = array(
         array(
            'nombre' => 'rosa 5',
            'apellido' => 'alzate'
         ),
         array(
            'nombre' => 'hector 5',
            'apellido' => 'ospina'
         )
      );

      $this->db->insert_batch('test', $data);

      echo $this->db->affected_rows();

   }

   public function actualizar(){
      $data = array(
         'nombre' => 'rosa 0',
         'apellido' => 'alzate'
      );

      $data = capitalizar_todo($data);

      $this->db->where('id',1);
      $this->db->update('test', $data);

      echo "todo ok!";
   }

   public function eliminar(){

      $this->db->where('id',1);
      $this->db->delete('test');

      echo "registro eliminado";
   }

   public function tabla_example1(){

      $this->db->select_max('id');
      $query = $this->db->get('clientes', array('id' => 1));
      
      echo json_encode($query->row());

   } 

   public function tabla_example2(){

      //$query = $this->db->get('clientes');
      $query = $this->db->get('clientes',10,20);

      foreach ($query->result() as $row)
      {
            echo $row->nombre.'<br/>';
      }

   }
   
   public function tabla_example3(){

      $this->db->select('id, nombre, correo');
      
      $query = $this->db->get_where('clientes', array('id' => 1));

      echo json_encode($query->row());

   } 

   public function tabla_example4(){

      $this->db->select('id, nombre, correo');
      $this->db->from('clientes');
      $this->db->where('id',1);
      
      $query = $this->db->get();

      echo json_encode($query->row());

   } 

   public function tabla_example5(){

      $this->db->select('id, nombre, correo');
      $this->db->from('clientes');
      
      $ids= array(1,2,3,4,5);

      $this->db->where_in('id',$ids);
      
      $query = $this->db->get();

      echo json_encode($query->result());

   } 

   public function tabla_example6(){

      $this->db->select('id, nombre, correo');
      $this->db->from('clientes');
      
      $this->db->like('nombre','COLTON');
      
      $query = $this->db->get();

      echo json_encode($query->result());

   } 

   public function tabla_example7(){

      $this->db->select('pais, count(*) as clientes');
      $this->db->from('clientes');
      
      $this->db->group_by('pais');
      
      $query = $this->db->get();

      echo json_encode($query->result());

   } 

   public function tabla_example8(){

      $this->db->distinct();
      $this->db->select('pais');
      $this->db->from('clientes');
      $this->db->order_by('pais ASC');
      $this->db->limit(10,10);
      
      $query = $this->db->get();

      foreach($query->result() as $fila ){
         echo $fila->pais .'<br/>';
      }

   } 

   public function clientes_beta(){

        //$this->load->database();

        $query = $this->db->query('SELECT id, nombre,correo FROM clientes limit 10');

        /*foreach ($query->result() as $row)
        {
                echo $row->id;
                echo $row->nombre;
                echo $row->correo;
        }

        echo 'Total registros: ' . $query->num_rows();*/

        $respuesta = array(
           'err' => false,
           'mensaje' => 'Registros cargados correctamente',
           'total_registros' => $query->num_rows(),
           'clientes' => $query->result()
        );

        echo json_encode($respuesta);
   }

   public function cliente ($id){

        //$this->load->database();

        $query = $this->db->query('SELECT * FROM clientes where id ='.$id);
        
        $fila = $query->row();

        if(isset($fila)){
            $respuesta = array(
                'err' => false,
                'mensaje' => 'Registro cargados correctamente',
                'total_registros' => 1,
                'cliente' => $fila
             );
        }else {
            $respuesta = array(
                'err' => false,
                'mensaje' => 'El registro con el id '.$id.' no existe',
                'total_registros' => 0,
                'cliente' => $fila
             );
        }

        echo json_encode($respuesta);

   }

}