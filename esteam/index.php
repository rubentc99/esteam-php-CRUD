<?php
    require "includes/protect.php";
?>
<!doctype html>
<html lang="en">
<head>
    <?php
        include "./includes/head.php";
    ?>
    <title>CRUD</title>
</head>
<body>

<?php
    include "./includes/headerLogged.php";
?>

<section id="sectionIndex">
    <video id="videoPortada" src="video/videoPortada.webm" autoplay loop></video>
    <div class="juegosDestacados">
        <h1>Juegos destacados:</h1>
        <div class="sliderJuegos">
            <div class="backArrow">
                <img src="img/backArrow.png" onclick="atras()">
            </div>
            <div class="imagenJuego">
                <img id="foto" src="img/juego1.JPG">
            </div>
            <div class="nextArrow">
                <img src="img/nextArrow.png" onclick="adelante()">
            </div>
        </div>
    </div>
</section>

<?php
    include "./includes/footer.php";
?>

</body>
</html>
