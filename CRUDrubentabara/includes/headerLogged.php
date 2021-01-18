<header>
    <div class="cajaLogoEsteam">
        <a href="../../CRUDrubentabaradam11/index.php"><img src="./img/esteam.png"></a>
    </div>
    <!--
    <div class="usuario">
        <?php// if(isset($_SESSION['idUsuario'])) echo "Hola ".$_SESSION['nombre'] ?>
    </div>-->

    <div class="recuadroSalir">
        <a href="../CRUDrubentabaradam11/logout.php" class="logOut">Salir</a>
    </div>

    <?php
        if($_SESSION['permiso']>2){ //permiso superior a 2
            echo '<div class="recuadroOpciones"><a href="../CRUDrubentabaradam11/listaJuegos.php" class="listar">Lista de juegos</a></div>';
            echo '<div class="recuadroOpciones"><a href="../CRUDrubentabaradam11/ingresarJuego.php" class="insertar">Insertar juego</a></div>';
        }
        else if($_SESSION['permiso']>1){ //permiso superior a 1
            echo '<div class="recuadroOpciones"><a href="../CRUDrubentabaradam11/listaJuegos.php" class="listar">Lista de juegos</a></div>';
        }
        //si tienes permiso 1 no podras hacer nada
    ?>






</header>
