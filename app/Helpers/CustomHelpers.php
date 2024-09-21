<?php

if (!function_exists('formatarFecha')) {
    function formatarFecha($fecha, $formato = 'd/m/Y') {
        return date($formato, strtotime($fecha));
    }
}

if (!function_exists('calcularEdad')) {
    function calcularEdad($fechaNacimiento) {
        return date_diff(date_create($fechaNacimiento), date_create('today'))->y;
    }
}

if (!function_exists('generoDescripcion')) {
    function generoDescripcion($descripcion) {
      switch ($descripcion) {
         case 'M':
            $genero = "Mascolino";
            break;         
         case 'F':
            $genero = "Femenino";
            break;
      }
        return $genero;
    }
}