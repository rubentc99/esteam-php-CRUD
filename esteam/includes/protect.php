<?php
@session_start();
if(!isset($_SESSION['idUsuario'])){ //para no poder hacer la trampa de entrar al index del tiron
    header("location:inicio.php");
}
