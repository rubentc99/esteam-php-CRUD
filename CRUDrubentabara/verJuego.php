<?php
//requires
require "includes/protect.php";
require_once "modelo/Juego.php";
require_once "modelo/Bd.php";
require_once "modelo/funciones.php";

$id = intval($_GET['id']); //intval es por seguridad, para que el programa sepa que tiene que enviar un numero entero

$juego = new Juego();
$juego->obtenerPorId($id);

?>
<!doctype html>
<html lang="en">
<head>
    <?php
        include "./includes/head.php";
    ?>
    <title>Ingresar Juego</title>
</head>
<body>

<?php
    include "./includes/headerLogged.php";
?>

<section>
    <div class="formularioVer">
        <?php
            echo $juego->imprimirEnFicha();
        ?>
    </div>
</section>

</body>
</html>
