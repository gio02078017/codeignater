<?php namespace App\Controllers;

use CodeIgniter\Controller;

class Blog extends Controller
{
    public function index()
    {
        echo 'Hello World!';
    }

    public function comentarios($id = null){

        if($id == null or !is_numeric($id)){
            $respuesta = array('err' => true, 'mensaje'=> 'El id tiene que ser un numero');
            echo json_encode($respuesta);
            return;
        }

        $comentarios = array(
           array('id'=> 1, 'mensaje'=>'Veniam dolore commodo cillum fugiat sit dolor sunt ex minim consequat. Magna aliquip reprehenderit esse labore quis elit eu magna. Commodo nulla proident est sint. Cillum labore ad duis incididunt veniam anim aliqua exercitation laborum est fugiat officia velit. Voluptate non incididunt ad cillum nostrud nostrud. Velit aliqua cupidatat sit mollit laboris duis laboris elit deserunt.'),
           array('id'=> 2, 'mensaje'=>'Veniam dolore commodo cillum fugiat sit dolor sunt ex minim consequat. Magna aliquip reprehenderit esse labore quis elit eu magna. Commodo nulla proident est sint. Cillum labore ad duis incididunt veniam anim aliqua exercitation laborum est fugiat officia velit. Voluptate non incididunt  mollit laboris duis laboris elit deserunt.'),
           array('id'=> 3, 'mensaje'=>'Veniam dolore commodo cillum fugiat sit dolor sunt ex minim consequat. Magna aliquip reprehenderit esse labore quis elit eu magna. Commodo nulla proident est sint. Cillum labore ad duis incididunt veniam anim aliqua exercitation laborum est fugiat  non incididunt ad cillum nostrud nostrud. Velit aliqua cupidatat sit mollit laboris duis laboris elit deserunt.')
        );

        if($id >= count($comentarios) or $id < 0){
            $respuesta = array('err' => true, 'mensaje'=> 'El id no existe');
            echo json_encode($respuesta);
            return;
        }
        
        if($id != null){
            echo json_encode($comentarios[$id]);
        }else{
            echo json_encode($comentarios);
        }
        
    }
}