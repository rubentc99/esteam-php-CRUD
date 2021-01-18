<?php


class Bd
{
    private $server = "localhost";
    private $usuario = "root";
    private $pass = "";
    private $basedatos = "CRUDjuegos";
    private $conexion;
    private $resultado; //almacenare la ultima consulta realizada

    public function __construct(){
        //creo el objeto mysqli y le mando los parámetros definidos arriba
        $this->conexion = new mysqli($this->server, $this->usuario, $this->pass, $this->basedatos);
        $this->conexion->select_db($this->basedatos); //esto es redundante pero la documentacion dice que hay que ponerla
        $this->conexion->query("SET NAMES 'utf8'");
    }

    public function insertarElementos($tabla, $datos, $carpeta, $foto){

        //arrays donde voy a guardar todas las claves y todos los valores
        $claves = array();
        $valores = array();

        foreach ($datos as $clave => $valor){
            $claves[] = $clave;
            $valores[] = "'".$valor."'"; //con esas comillas, uno de los valores guardados será '43', con comillas simples
        }

        if($foto['name'] != ""){ //si el nombre de la foto es distinto a "" es que la quiero subir
            $ruta = subirFoto($foto, $carpeta);
            $claves[] = "foto";
            $valores[] = "'".$ruta."'";
        }
        else{

        }

        $sql = "INSERT INTO ".$tabla." (".implode(',',$claves).") VALUES (".implode(',',$valores).")";
        //implode -> array [a],[b],[c],[d] -> implode("-", array) -> string -> a-b-c-d
        //echo $sql; //me ayuda a localizar errores en la inserión
        $this->resultado = $this->conexion->query($sql);
        $res = $this->resultado;
        return $res;
    }

    public function uppdateBDcuandoHayFoto($id, $tabla, $datos, $foto="", $directorio=""){

        $sentencias = array();

        foreach ($datos as $campo => $valor){
            if($campo != "id" && $campo != "x" && $campo != "y"){
                $sentencias[] = $campo . "='".addslashes($valor)."'"; //en cada posicion del array meto el nombre del campo y el valor
                //UPDATE tabla SET nombreCampo='valor1', nombreCampo='valor2', etc
            }
        }

        if(strlen($foto['name'])>0){
            echo "entra en el if";
            $this->borrarFoto($id, $tabla, 'almacenFotos');
            $ruta= subirFoto($foto, $directorio);
            $sentencias[] = "foto='".$ruta."'";
        }

        $campos = implode(",", $sentencias);
        //implode -> array [a],[b],[c],[d] -> implode("-", array) -> string -> a-b-c-d
        $sql = "UPDATE " . $tabla . " SET " . $campos . " WHERE id=" . $id;
        //echo $sql;
        $conexion = new Bd();
        $conexion->consulta($sql);
    }

    public function uppdateBDcuandoNoHayFoto($id, $tabla, $datos, $foto="", $directorio=""){

        $sentencias = array();

        foreach ($datos as $campo => $valor){
            if($campo != "id" && $campo != "x" && $campo != "y"){
                $sentencias[] = $campo . "='".addslashes($valor)."'"; //en cada posicion del array meto el nombre del campo y el valor
                //UPDATE tabla SET nombreCampo='valor1', nombreCampo='valor2', etc
            }
        }

        if(strlen($foto['name'])>0){
            $ruta= subirFoto($foto, $directorio);
            $sentencias[] = "foto='".$ruta."'";
        }

        $campos = implode(",", $sentencias);
        //implode -> array [a],[b],[c],[d] -> implode("-", array) -> string -> a-b-c-d
        $sql = "UPDATE " . $tabla . " SET " . $campos . " WHERE id=" . $id;
        //echo $sql;
        $conexion = new Bd();
        $conexion->consulta($sql);
    }

    public function borrarFoto($id, $tabla, $carpeta){

        $sql = "SELECT foto FROM " . $tabla . " WHERE id = '" . $id . "'";
        //echo $sql;
        $this->resultado = $this->conexion->query($sql);
        if($this->numeroElementos()>0) {
            //echo "supuestamente borra";
            $res = mysqli_fetch_assoc($this->resultado);
            $rutaAborrar = $carpeta."/".$res['foto'];
            if(!unlink($rutaAborrar)){
                lanzaError("Error de escritura en el servidor, contacte con su administrador en el mail ......");
            }
            //echo "entra al primer if";
        }
        else{
            //echo "no entra al primer if";
        }
    }

    public function consulta($consulta){
        $this->resultado = $this->conexion->query($consulta);
        $res = $this->resultado;
        return $res;
    }

    public function numeroElementosConSql($sql){
        $this->resultado = $this->conexion->query($sql);
        $num = $this->numeroElementos();
        return $num;
    }

    public function numeroElementos(){
        $num = $this->resultado->num_rows;
        return $num;
    }

}