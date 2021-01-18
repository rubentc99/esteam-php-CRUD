<?php
    //requires
    require "includes/protect.php";
    require_once "modelo/ListaJuegos.php";
    require_once "modelo/Juego.php";
    require_once "modelo/Bd.php";
    require_once "modelo/funciones.php";

    if($_SESSION['permiso']<2){ //si tienes permiso 1 no puedes ni ver la lista
        header("location:index.php");
    }

    $lista = new ListaJuegos();

    if(isset($_GET['buscar']) && !empty($_GET['buscar'])){

        $lista->obtenerElementos(addslashes($_GET['buscar'])); //addslashes me protege de la inyeccion sql

    }else{
        $lista->obtenerElementos();
    }

?>
<!doctype html>
<html lang="en">
<head>
    <?php
        include "./includes/head.php";
    ?>
    <title>Lista juegos</title>
</head>
<body>
    <?php
        include "./includes/headerLogged.php";
    ?>
    <section>
        <form name="buscador" id="formBuscador" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get">
            <input name="buscar" type="text" placeholder="Busca por nombre, desarrollador, editor..." id="buscador">
            <input id="botonBuscador" type="submit" value="Buscar">
        </form>
        <div class="lista">
            <?php
                echo $lista->imprimirJuegosEnBack();
            ?>
        </div>
    </section>

    <?php
        include "./includes/footer.php";
    ?>
</body>
</html>