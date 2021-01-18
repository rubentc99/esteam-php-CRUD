<?php


class ListaJuegos
{
    private $lista;
    private $tabla;

    /**
     * ListaJuegos constructor, que cada vez que se llame al la funcion creará un array, y generará la variable tabla que almacena el nombre de la tabla.
     * @param $lista
     * @param $tabla
     */
    public function __construct()
    {
        $this->lista = array();
        $this->tabla = "crudjuegos";
    }

    /***
     * Funcion del buscador, lo que hará es, según un texto introducido por el usuario, un select con "LIKE" para encontrar similitudes con la bbdd
     * @param string $texto
     */
    public function obtenerElementos($texto=""){ //al tener un valor = cadena vacía, si a esta funcion no le mando parámetro también va a funcionar

        $sqlBusca="";

        if(strlen($texto)>0){ //funcion strlen cuenta el numero de caracteres de un string
            //el like y el % lo que hacen es que al buscar, si hay algo que contenga (x)tu palabra(x), te lo muestre, para que las busquedas seas mas generales
            $sqlBusca = " WHERE nombre LIKE '%".$texto."%' OR desarrollador LIKE '%".$texto."%' OR editor LIKE '%".$texto."%'";
        }

        //si sqlBusca está vacío, la query no se va a ver alterada, y si tiene algo me va a buscar respecto a ese algo
        $sql = "SELECT * FROM ".$this->tabla." ".$sqlBusca.";";
        $conexion = new Bd();
        $res = $conexion->consulta($sql);
        while(list($id, $nombre, $desarrollador, $editor, $precio, $fechaLanzamiento, $multijugador, $foto) = mysqli_fetch_array($res)) {
            //el mysqli lo que hace es coge el array entre parentesis de formato sql y lo devuelve de forma que php pueda trabajar con el
            $fila = new Juego($id, $nombre, $desarrollador, $editor, $precio, $fechaLanzamiento, $multijugador, $foto);
            array_push($this->lista, $fila); //cada vez que este while actue, inserta las variables en la lista
        }
    }

    /***
     * Función encargada de imprimir la tabla donde se mostrarán los juegos. Para ello, la primera fila se creará manualmente mientras que las demás mediante bucle for.
     * @return string
     */
    public function imprimirJuegosEnBack(){
        $html = "<table>";
        //esto será la fila 1 de la tabla que servirá como referencia
        $html .= "<tr><th style='width: 100px; border-left:2px solid #000000'>Referencia</th>
                    <th style='width: 200px'>Nombre</th>
                    <th style='width: 200px'>Desarrollador</th>
                    <th style='width: 150px'>Editor</th>
                    <th style='width: 80px'>Precio</th>
                    <th style='width: 250px'>Fecha de Lanzamiento</th>
                    <th style='width: 50px'>Multijugador</th>
                    <th style= 'width: 200px; border-right:2px solid #000000'>Imagen</th></tr>";
        for($i = 0; $i<sizeof($this->lista);$i++){
            $html .= $this->lista[$i] -> imprimeteEnTr();
        }
        $html .= "</table>";
        return $html;
    }
}