<?php
//requires
require  "../includes/protect.php";
require_once "../modelo/ListaJuegos.php";
require_once "../modelo/Juego.php";
require_once "../modelo/Bd.php";

$id = intval($_GET['id']); //intval para la inyeccion

//borro el elemento de la BD y su foto
$juego = new Juego();
$juego->borrarJuego($id);


//Pido de nuevo la lista de elementos y la envio a AJAX

$lista = new ListaJuegos();
$lista->obtenerElementos();

echo $lista->imprimirJuegosEnBack();
