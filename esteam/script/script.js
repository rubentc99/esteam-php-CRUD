//borrar juego
function ajax() {
    try {
        req = new XMLHttpRequest();
    } catch(err1) {
        try {
            req = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (err2) {
            try {
                req = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (err3) {
                req = false;
            }
        }
    }
    return req;
}

var borrar = new ajax();
function borrarJuego(id) {
    if(confirm("¿Seguro que deseas eliminar el juego de la BD?")) {
        var myurl = 'llamadas/borrarJuego.php';
        myRand = parseInt(Math.random() * 999999999999999);
        modurl = myurl + '?rand=' + myRand + '&id=' + id;
        borrar.open("GET", modurl, true);
        borrar.onreadystatechange = borrarJuegoResponse;
        borrar.send(null);
    }

}

function borrarJuegoResponse() {

    if (borrar.readyState == 4) {
        if(borrar.status == 200) {

            var listaJuegos = borrar.responseText;
            //window.location.reload();
            document.getElementsByClassName('lista')[0].innerHTML = listaJuegos;
            //document.getElementById('lista').innerHTML =  listaJuegos;
        }
    }
}




//slider
{
    var fotos = ["./img/juego1.jpg", "./img/juego2.jpg", "./img/juego3.jpg", "./img/juego4.jpg", "./img/juego5.jpg", "./img/juego6.jpg", "./img/juego7.jpg", "./img/juego8.jpg", "./img/juego9.jpg", "./img/juego10.jpg"];
    inicioFoto = 0;
    function adelante() {
        inicioFoto++;
        if (inicioFoto == fotos.length) {
            inicioFoto = 0;
        }
        document.getElementById("foto").src = fotos[inicioFoto];
    }
    function atras(){
        inicioFoto--;
        if(inicioFoto < 0){
            inicioFoto = fotos.length-1;
        }
        document.getElementById("foto").src = fotos[inicioFoto];
    }
}


//cookies
function getCookie(c_name){
    var c_value = document.cookie;
    var c_start = c_value.indexOf(" " + c_name + "=");
    if (c_start == -1){
        c_start = c_value.indexOf(c_name + "=");
    }
    if (c_start == -1){
        c_value = null;
    }else{
        c_start = c_value.indexOf("=", c_start) + 1;
        var c_end = c_value.indexOf(";", c_start);
        if (c_end == -1){
            c_end = c_value.length;
        }
        c_value = unescape(c_value.substring(c_start,c_end));
    }
    return c_value;
}

function setCookie(c_name,value,exdays){
    var exdate=new Date();
    exdate.setDate(exdate.getDate() + exdays);
    var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
    document.cookie=c_name + "=" + c_value;
}
function PonerCookie(){
    setCookie('cookies','1',365);
    document.getElementById("barraCookies").style.display="none";
}
if(getCookie('cookies') != 1){
    document.getElementById("barraCookies").style.display="block";
}
