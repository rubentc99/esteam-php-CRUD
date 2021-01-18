<?php


class Juego
{
    private $id;
    private $nombre;
    private $desarrollador;
    private $editor;
    private $precio;
    private $fechaLanzamiento;
    private $multijugador;
    private $foto;
    private $tabla;
    private $carpetaFotos;

    /**
     * Constructor de la clase Juego.
     * @param $id
     * @param $nombre
     * @param $desarrollador
     * @param $editor
     * @param $precio
     * @param $fechaLanzamiento
     * @param $multijugador
     * @param $foto
     */
    public function __construct($id="", $nombre="", $desarrollador="", $editor="", $precio="", $fechaLanzamiento="", $multijugador="", $foto="")
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->desarrollador = $desarrollador;
        $this->editor = $editor;
        $this->precio = $precio;
        $this->fechaLanzamiento = $fechaLanzamiento;
        $this->multijugador = $multijugador;
        $this->foto = $foto;
        $this->tabla = "crudjuegos"; //hago esto para que si en algun momento, en la bbdd cambio el nombre de la tabla no se rompa
        $this->carpetaFotos = "almacenFotos/";
    }

    /***
     * Funcion llenar, que funcionará como constructor pero excluyendo algunos atributos del constructor como tabla y carpetaFotos
     * @param $id
     * @param $nombre
     * @param $desarrollador
     * @param $editor
     * @param $precio
     * @param $fechaLanzamiento
     * @param $multijugador
     * @param $foto
     */
    private function llenar($id, $nombre, $desarrollador, $editor, $precio, $fechaLanzamiento, $multijugador, $foto)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->desarrollador = $desarrollador;
        $this->editor = $editor;
        $this->precio = $precio;
        $this->fechaLanzamiento = $fechaLanzamiento;
        $this->multijugador = $multijugador;
        $this->foto = $foto;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return mixed
     */
    public function getdesarrollador()
    {
        return $this->desarrollador;
    }

    /**
     * @param mixed $desarrollador
     */
    public function setdesarrollador($desarrollador)
    {
        $this->desarrollador = $desarrollador;
    }

    /**
     * @return mixed
     */
    public function getEditor()
    {
        return $this->editor;
    }

    /**
     * @param mixed $editor
     */
    public function setEditor($editor)
    {
        $this->editor = $editor;
    }

    /**
     * @return mixed
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * @param mixed $precio
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;
    }

    /**
     * @return mixed
     */
    public function getFechaLanzamiento()
    {
        return $this->fechaLanzamiento;
    }

    /**
     * @param mixed $fechaLanzamiento
     */
    public function setFechaLanzamiento($fechaLanzamiento)
    {
        $this->fechaLanzamiento = $fechaLanzamiento;
    }

    /**
     * @return mixed
     */
    public function getMultijugador()
    {
        if($this->multijugador==1){
            $res = "Si";
        }else{
            $this->multijugador=0;
            $res = "No";
        }
        return $res;
    }

    /**
     * @param mixed $multijugador
     */
    public function setMultijugador($multijugador)
    {
        $this->multijugador = $multijugador;
    }

    /**
     * @return mixed
     */
    public function getFoto()
    {
        return $this->foto;
    }

    /**
     * @param mixed $foto
     */
    public function setFoto($foto)
    {
        $this->foto = $foto;
    }

    /**
     * @return string
     */
    public function getCarpetaFotos()
    {
        return $this->carpetaFotos;
    }

    /**
     * @param string $carpetaFotos
     */
    public function setCarpetaFotos($carpetaFotos)
    {
        $this->carpetaFotos = $carpetaFotos;
    }


    /***
     * función encargada de insertar unos datos, y una foto en la base de datos.
     * @param $datos
     * @param $foto
     */
    public function insertar($datos, $foto){
        if(!isset($datos['multijugador'])){ //si dentro de datos no está instaciado nada llamado multijugador
            $datos['multijugador'] = 0; //si el checkbox de multijugador está vacio, le doy el valor 0
        }
        $conexion = new Bd();
        //le mando el nombre de la tabla, los datos del post, la carpeta donde se van a almacenar las fotos, y la foto que se sube
        $conexion->insertarElementos($this->tabla, $datos, $this->carpetaFotos, $foto);
    }

    /***
     * Funciones de Actualizar los datos de un juego. Necesito 2 funciones distintas de actualizar porque si no, si actualizo un objeto juego
     * sin foto, se intentará borrar una foto que no hay y dará error.
     * @param $id
     * @param $datos
     * @param $foto
     */
    public function actualizarCuandoHayFoto($id, $datos, $foto){
        $conexion = new Bd();
        $conexion->uppdateBDcuandoHayFoto($id, $this->tabla, $datos, $foto, $this->carpetaFotos);
    }
    public function actualizarCuandoNoHayFoto($id, $datos, $foto){
        $conexion = new Bd();
        $conexion->uppdateBDcuandoNoHayFoto($id, $this->tabla, $datos, $foto, $this->carpetaFotos);
    }

    /***
     * Función encargada de crear la query para borar un objeto juego de la bbdd
     * @param $id
     */
    public function borrarJuego($id){
        $conexion = new Bd();
        if(($this->foto)!=""){//si hay foto la borro, si no, no hace falta
            $conexion->borrarFoto($id, $this->tabla,"../".$this->carpetaFotos);
        }
        $sql = "DELETE FROM ".$this->tabla." WHERE id =".$id;
        //echo $sql;
        $conexion->consulta($sql);
    }

    /**
     * Funcion con la que mediante un id que le pase, haré un select para obtener los datos asociados a ese id
     * @param $id id sobre el que quiero hacer la select
     */
    public function obtenerPorId($id){
        $sql = "SELECT id, nombre, desarrollador, editor, precio, fechaLanzamiento, multijugador, foto FROM ".$this->tabla." WHERE id=".$id;
        $conexion = new Bd();
        $res = $conexion->consulta($sql);

        //uso list en vez de while porque me va a devolver una sola fila
        list($id, $nombre, $desarrollador, $editor, $precio, $fechaLanzamiento, $multijugador, $foto) = mysqli_fetch_array($res);
        $this->llenar($id, $nombre, $desarrollador, $editor, $precio, $fechaLanzamiento, $multijugador, $foto);
    }

    public function obtenerPorIdVersionCorta($id){
        $sql = "SELECT id, nombre, desarrollador, editor, precio, fechaLanzamiento, multijugador, foto FROM ".$this->tabla."WHERE id=".$id;

        $conexion = new Bd();
        $res = $conexion->consulta($sql);
    }

    /**
     * Método que retorna una fila para la inserción en una tabla de la clase lista.
     * @return string
     */
    public function imprimeteEnTr(){
        if($this->foto == null){ //si no hay foto, se pone una foto en blanco
            $html = "<tr><td>".$this->id."</td>
                    <td>".$this->nombre."</td>
                    <td>".$this->desarrollador."</td>
                    <td>".$this->editor."</td>
                    <td>".$this->precio."</td>
                    <td>".$this->fechaLanzamiento."</td>
                    <td>".$this->getMultijugador(). "</td>
                    <td><img src='./img/fondo-blanco.jpg' style='width: 100px; height: 100px; padding: 10px;'></td>";
                    if($_SESSION['permiso']>1) {
                        $html .= "<td id='V_E_B'><a href='verJuego.php?id=" . $this->id . "'>Ver</a> </td>";
                    }
                    if($_SESSION['permiso']>2) {
                        $html .= "<td id='V_E_B'><a href='ingresarJuego.php?id=" . $this->id . "'>Editar</a></td>
                        <td id='V_E_B'><a href='javascript:borrarJuego(" . $this->id . ")'>Borrar</a> </td></tr>";
                    }
                }
        else { //si hay foto, se carga la foto
            $html = "<tr><td>" . $this->id . "</td>
                    <td>" . $this->nombre . "</td>
                    <td>" . $this->desarrollador . "</td>
                    <td>" . $this->editor . "</td>
                    <td>" . $this->precio . "</td>
                    <td>" . $this->fechaLanzamiento . "</td>
                    <td>" . $this->getMultijugador() . "</td>
                    <td><img src='".$this->getCarpetaFotos().$this->getFoto()."' style='width: 100px; height: 100px; padding: 10px;'></td>";
                    if($_SESSION['permiso']>1) {
                        $html .= "<td id='V_E_B'><a href='verJuego.php?id=" . $this->id . "'>Ver</a> </td>";
                    }
                    if($_SESSION['permiso']>2) {
                        $html .= "<td id='V_E_B'><a href='ingresarJuego.php?id=".$this->id."'>Editar</a></td>
                        <td id='V_E_B'><a href='javascript:borrarJuego(".$this->id.")'>Borrar</a> </td></tr>";
                    }
            }
        return $html;
    }

    /***
     * Función encargada de imprimir por pantalla 1 unico objeto juego seleccionado por el usuario en la opción "ver"
     * con el if comprobaré si el objeto tiene foto; si no la tiene, le pondré una imagen en blanco.
     * @return string
     */
    public function imprimirEnFicha(){
        if($this->foto == null) { //si no hay foto, se pone una foto en blanco
            $html = "<table style='border-left:2px solid #000000; border-right: 2px solid #000000'>";
            $html .="<tr><th style='width: 100px; border-left:2px solid #000000'>Referencia</th>
                    <th style='width: 200px'>Nombre</th>
                    <th style='width: 200px'>Desarrollador</th>
                    <th style='width: 150px'>Editor</th>
                    <th style='width: 80px'>Precio</th>
                    <th style='width: 250px'>Fecha de Lanzamiento</th>
                    <th style='width: 50px'>Multijugador</th>
                    <th style= 'width: 200px; border-right:2px solid #000000'>Imagen</th>
                    </tr>";

            $html .="<tr><td>".$this->id."</td>
                    <td>".$this->nombre."</td>
                    <td>".$this->desarrollador."</td>
                    <td>".$this->editor."</td>
                    <td>".$this->precio."</td>
                    <td>".$this->fechaLanzamiento."</td>
                    <td>".$this->getMultijugador()."</td>
                    <td><img src='./img/fondo-blanco.jpg' style='width: 100px; height: 100px'>
                    </tr>";
            return $html;
        }else{
            $html = "<table style='border-left:2px solid #000000; border-right: 2px solid #000000;'>";
            $html .="<tr><th style='width: 100px; border-left:2px solid #000000'>Referencia</th>
                    <th style='width: 200px'>Nombre</th>
                    <th style='width: 200px'>Desarrollador</th>
                    <th style='width: 150px'>Editor</th>
                    <th style='width: 80px'>Precio</th>
                    <th style='width: 250px'>Fecha de Lanzamiento</th>
                    <th style='width: 50px'>Multijugador</th>
                    <th style= 'width: 200px; border-right:2px solid #000000'>Imagen</th>
                    </tr>";

            $html .="<tr><td>".$this->id."</td>
                    <td>".$this->nombre."</td>
                    <td>".$this->desarrollador."</td>
                    <td>".$this->editor."</td>
                    <td>".$this->precio."</td>
                    <td>".$this->fechaLanzamiento."</td>
                    <td>".$this->getMultijugador()."</td>
                    <td><img src='".$this->getCarpetaFotos().$this->getFoto()."' style='width: 100px; height: 100px; padding: 10px;'>
                    </tr>";
            return $html;
        }
    }
}