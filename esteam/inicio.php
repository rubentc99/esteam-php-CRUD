<?php
    require "modelo/Bd.php";
    require "modelo/funciones.php";
    require "modelo/Usuario.php";

    if(isset($_POST) && !empty($_POST)){

        $mail = addslashes($_POST['mail']); //addslashes contra la inyeccion
        $pass = addslashes($_POST['pass']);

        $usuario = new Usuario();
        if($usuario->login($mail, $pass)){
            header("location:index.php");
        }else{
            lanzarError("El usuario introducido no se encuentra en la base de datos.");
        }
    }
?>
<!doctype html>
<html lang="en">
<head>
    <?php
        include "includes/head.php";
    ?>
    <title>Document</title>
</head>
<body>
    <?php
        include "includes/header.php";
    ?>
    <section>
        <div class="contenedorFormLogin">
            <form id="formLogin" name="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                <ul>
                    <li><label>E-mail</label><input id="mail" type="email" name="mail"></li>
                    <li><label>Password</label><input id="pass" type="password" name="pass"></li>
                    <li><input id="botonLogin" type="submit" value="Entrar"></li>
                </ul>
            </form>
        </div>
    </section>
</body>
</html>
