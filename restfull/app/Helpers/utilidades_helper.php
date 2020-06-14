<?php

  function obtener_mes($mes){
    $mes -=1;
    $meses = array(
        'enero',
        'febrero', 
        'marzo', 
        'abril', 
        'mayo',
        'junio',
        'julio',
        'agosto', 
        'septiembre',
        'octubre', 
        'noviembre', 
        'diciembre'
    );

    return $meses[$mes];
  }

?>