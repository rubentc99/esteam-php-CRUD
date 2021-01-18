<?php
    //requires
    require "includes/protect.php";
    require_once "modelo/Juego.php";
    require_once "modelo/Bd.php";
    require_once "modelo/funciones.php";

    $juego = new Juego();

    if(isset($_GET['id']) && !empty($_GET['id'])){ //si hay algo instaciado en el post llamado id, y si no está vacío

        $id = intval($_GET['id']); //capturo el id del objeto //el intval es para seguridad
        $juego->obtenerPorId($id);
    }

    if(isset($_POST) && !empty($_POST)){ //si está instanciado el post, y es diferente a empty
        if(!empty($_POST['id'])){ //si por el post está viniendo un id, lo que significa es que he pulsado el boton en el formulario de actualizar
            //actualizo
            $id = intval($_POST['id']);
            var_dump($juego->getFoto()); //esto devuelve ""

            if($juego->getFoto()!="string(0)''"){ //hay foto
                //echo "entro al if";
                $juego->actualizarCuandoHayFoto($id, $_POST, $_FILES['foto']);
            }
            else{ //no hay foto
                //echo("entro en el else");
                $juego->actualizarCuandoNoHayFoto($id, $_POST, $_FILES['foto']);
            }
        }else {
            //inserto
            $juego->insertar($_POST, $_FILES['foto']); //inserto los datos del post + la foto
        }
        header('location:listaJuegos.php');
    }
?>
<!doctype html>
<html lang="en">
<head>
    <?php
        include "includes/head.php";
    ?>
    <title>Ingresar Juego</title>
</head>
<body>

<?php
    include "./includes/headerLogged.php";
?>

<section id="footerForm">
    <div class="formulario">
        <h1>Formulario de juegos</h1>
        <form name="juegos" action="<?php echo $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
            <ul>
                <input type="hidden" name="id" value="<?php echo $juego->getId()?>">
                <!--con lo value y los echo, lo que hago es meter la info en los textbox-->
                <li id="formNombre"><label>Nombre: </label><input id="cajaCampos" type="text" name="nombre" placeholder="Nombre" value="<?php echo $juego->getNombre()?>"></li>
                <li><label>Desarrollador: </label><input id="cajaCampos" type="text" name="desarrollador" placeholder="Desarrollador" value="<?php echo $juego->getdesarrollador()?>"></li>
                <li><label>Editor: </label><input id="cajaCampos" type="text" name="editor" placeholder="Editor" value="<?php echo $juego->getEditor()?>"></li>
                <li><label>Precio: </label><input id="cajaCampos" type="text" name="precio" placeholder="Precio" value="<?php echo $juego->getPrecio()?>"></li>
                <li><label>Fecha lanzamiento: </label><input id="cajaCampos" type="date" name="fechaLanzamiento" value="<?php echo $juego->getFechaLanzamiento()?>"></li>
                <?php
                $check = "";
                if($juego->getMultijugador() == "Si"){ //en mi caso la condición es "Si" porque tengo modificado el getter
                    $check = "checked";
                }
                //var_dump($check);
                ?>
                <li><label>Multijugador: </label><input id="cajaCampos" type="checkbox" name="multijugador" value="1" <?php echo $check ?>></li>
                <li><label>Foto: </label><input id="cajaCampos" type="file" name="foto"></li>
                <?php
                    if(strlen($juego->getFoto())>0){ //hay foto
                        echo "<li><img src='".$juego->getCarpetaFotos().$juego->getFoto()."' width='50px' </li>"; //muestro la foto
                    }
                ?>
                <button class="btn btn-primary" type="submit" value="Guardar">Guardar</button>
            </ul>
        </form>
    </div>
</section>

<?php
include "./includes/footer.php";
?>

</body>
</html>
