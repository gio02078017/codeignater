<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require( APPPATH.'/libraries/REST_Controller.php');
//use Restserver\Libraries\REST_Controller;

class Clientes extends REST_Controller/*CI_Controller*/ {

    public function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->model('Cliente_model');
    }
    
    public function index_get()
    {
            
        $this->load->helper('utilidades');
        $data = array(
            'nombre' => 'fernando herrera',
            'contacto' => 'melissa flores',
            'direccion' => 'recidencial villa de las modas'
        );

        //$data['nombre'] = strtoupper($data['nombre']);
        //$data['contacto'] = strtoupper($data['contacto']);

        $campos_capitalizar = array('nombre','contacto');

        $data = capitalizar_arreglo($data, $campos_capitalizar);

        echo json_encode($data);
    }

    public function cliente_old($id){
        $this->load->model('Cliente_model');
        $cliente = $this->Cliente_model->get_cliente($id);
        echo json_encode($cliente);
    }

    public function cliente_get(){
       
        $cliente_id = $this->uri->segment(3);

        /*echo $cliente_id;
        return; */

        if(!isset($cliente_id)){
            $respuesta = array(
                "err" => true,
                'mensaje' => 'Es necesario el Id del cliente'
            );

            $this->response($respuesta, REST_Controller::HTTP_BAD_REQUEST);
            return;
        }
        

        $cliente = $this->Cliente_model->get_cliente($cliente_id);

        if(isset($cliente)){
            $respuesta = array(
                "err" => true,
                'mensaje' => 'Registro cargado correctamente',
                'cliente' => $cliente
            );

            $this->response($respuesta);
            return;
        }else{
            $respuesta = array(
                "err" => true,
                'mensaje' => 'El registro con el id '.$cliente_id.', no existe'
            );

            $this->response($respuesta, REST_Controller::HTTP_NOT_FOUND);
            return;
        }

    }

    public function paginar_get(){

        $this->load->helper('paginacion');

        $pagina = $this->uri->segment(3);
        $por_pagina = $this->uri->segment(4);
        
        $campos = array('id', 'nombre', 'telefono1');

        $respuesta = paginar_todo('clientes', $pagina, $por_pagina, $campos);

        $this->response($respuesta);

    }

    public function cliente_messy_post(){

        $data = $this->post();

        $this->load->library('form_validation');

        $this->form_validation->set_data($data);

        //$this->form_validation->set_rules('correo','correo electronico', 'required|valid_email');
        //$this->form_validation->set_rules('nombre','nombre', 'required|min_length[2]');

        if($this->form_validation->run('cliente_post')){
            //$this->response('Todo bien!');

            $query = $this->db->get_where('clientes', array('correo'=>$data['correo']));
            $cliente_correo = $query->row();

            if(isset($cliente_correo)){
                $respuesta = array(
                    'err' => true,
                    'mensaje' => 'El correo electronico ya esta registrado',
                );
                $this->response($respuesta, REST_Controller::HTTP_BAD_REQUEST);
                return;
            }

            $cliente = $this->Cliente_model->set_datos($data);

            $hecho = $this->db->insert('clientes',$cliente);

            if($hecho){

                $respuesta = array(
                    'err' => false,
                    'mensaje' => 'Registro insertado correctamente',
                    'cliente_id' => $this->db->insert_id()
                );

                $this-> response($respuesta);

             }else{
                $respuesta = array(
                    'err' => true,
                    'mensaje' => 'Error al insertar',
                    'error' => $this->db->_error_message(),
                    'error_num' => $this->db->error_number
                );
                $this->response($respuesta, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
            }

        }else{
            $respuesta = array(
                'err' => true,
                'mensaje' => 'Hay errores en el envio de información',
                'errores' => $this->form_validation->get_errores_arreglo()
            );
            $this->response($respuesta, REST_Controller::HTTP_BAD_REQUEST);
        }        
        
        $this->response($data);
    }

    public function cliente_post(){

        $data = $this->post();

        $this->load->library('form_validation');

        $this->form_validation->set_data($data);

        //$this->form_validation->set_rules('correo','correo electronico', 'required|valid_email');
        //$this->form_validation->set_rules('nombre','nombre', 'required|min_length[2]');

        if($this->form_validation->run('cliente_post')){
            
            $cliente = $this->Cliente_model->set_datos($data);

            $respuesta = $cliente->insert();

            if($respuesta['err']){
                $this->response($respuesta, REST_Controller::HTTP_BAD_REQUEST);
            }else{
                $this->response($respuesta);
            }


        }else{
            $respuesta = array(
                'err' => true,
                'mensaje' => 'Hay errores en el envio de información',
                'errores' => $this->form_validation->get_errores_arreglo()
            );
            $this->response($respuesta, REST_Controller::HTTP_BAD_REQUEST);
        }        
        
        $this->response($data);
    }

    public function cliente_put(){

        $data = $this->put();

        $cliente_id = $this->uri->segment(3);
        $data['id'] = $cliente_id;

        $this->load->library('form_validation');

        $this->form_validation->set_data($data);

        if($this->form_validation->run('cliente_put')){
            
            $cliente = $this->Cliente_model->set_datos($data);

            $respuesta = $cliente->update();

            if($respuesta['err']){
                $this->response($respuesta, REST_Controller::HTTP_BAD_REQUEST);
            }else{
                $this->response($respuesta);
            }


        }else{
            $respuesta = array(
                'err' => true,
                'mensaje' => 'Hay errores en el envio de información',
                'errores' => $this->form_validation->get_errores_arreglo()
            );
            $this->response($respuesta, REST_Controller::HTTP_BAD_REQUEST);
        }        
        
        $this->response($data);
    }

    public function cliente_delete(){

        $cliente_id = $this->uri->segment(3);

        $respuesta = $this->Cliente_model->delete($cliente_id);

        $this->response($respuesta);
    }



}