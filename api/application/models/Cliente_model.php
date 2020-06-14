<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente_model extends CI_Model{
    
    public $id;
    public $nombre;
    public $activo;
    public $correo;
    public $zip;
    public $telefono1;
    public $telefono2;
    public $pais;
    public $direccion;

    public function get_cliente($id){


        $this->db->where(array('id'=>$id, 'status'=>'activo'));
        $query = $this->db->get('clientes');

        $row = $query->custom_row_object(0, 'Cliente_model');
        
        if(isset($row)){
            $row->id = intval($row->id);
            $row->activo = intval($row->activo);

        }
        return $row;
    }

    public function set_datos($data_cruda){

        foreach($data_cruda as $nombre_campo => $valor_campo){
            if(property_exists('Cliente_model', $nombre_campo)){
                 $this->$nombre_campo = $valor_campo;
            }
        }

        if($this->activo == null){
            $this->activo = 1;
        }

        $this->nombre = strtoupper($this->nombre);

        return $this;
    }

    public function insert(){

        $query = $this->db->get_where('clientes', array('correo'=>$this->correo));
        $cliente_correo = $query->row();

        if(isset($cliente_correo)){
            $respuesta = array(
                'err' => true,
                'mensaje' => 'El correo electronico ya esta registrado',
            );

            return $respuesta;
        }

        $hecho = $this->db->insert('clientes',$this);

        if($hecho){

            $respuesta = array(
                'err' => false,
                'mensaje' => 'Registro insertado correctamente',
                'cliente_id' => $this->db->insert_id()
            );


         }else{
            $respuesta = array(
                'err' => true,
                'mensaje' => 'Error al insertar',
                'error' => $this->db->_error_message(),
                'error_num' => $this->db->error_number
            );

        }

        return $respuesta;
    }

    public function update(){

        $this->db->where('correo=', $this->correo);
        $this->db->where('id !=', $this->id);

        $query = $this->db->get_where('clientes');
        $cliente_correo = $query->row();

        if(isset($cliente_correo)){
            $respuesta = array(
                'err' => true,
                'mensaje' => 'El correo electronico ya esta registrado por otro usuario',
            );

            return $respuesta;
        }

        $this->db->reset_query();
        $this->db->where('id', $this->id);
        $hecho = $this->db->update('clientes',$this);

        if($hecho){

            $respuesta = array(
                'err' => false,
                'mensaje' => 'Registro actualizado correctamente',
                'cliente_id' => $this->id
            );


         }else{
            $respuesta = array(
                'err' => true,
                'mensaje' => 'Error al actualizar',
                'error' => $this->db->_error_message(),
                'error_num' => $this->db->error_number
            );

        }

        return $respuesta;
    }

    public function delete($cliente_id){
        
        $this->db->set('status','borrado');
        $this->db->where('id',$cliente_id);

        $hecho = $this->db->update('clientes');

        if($hecho){

            $respuesta = array(
                'err' => false,
                'mensaje' => 'Registro eliminado correctamente',
                'cliente_id' => $cliente_id
            );


         }else{
            $respuesta = array(
                'err' => true,
                'mensaje' => 'Error al borrar',
                'error' => $this->db->_error_message(),
                'error_num' => $this->db->error_number
            );

        }

        return $respuesta;
    }
}
