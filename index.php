<?php 
 header("Access-Control-Allow-Origin: *");
 header("Access-Control-Allow-Header: access");
 header("Access-Control-Allow-Methods: GET, POST");
 header("Content-Type: application/json; charset=UTF-8");
 header("Access-Control_Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

 // Conexion BD y parametros
$servidor = "localhost:8889";
$usuario = "root";
$contrasenia = "root";
$nombreBaseDatos = "alumnos";

$conexionDB = new mysqli ($servidor, $usuario, $contrasenia, $nombreBaseDatos);

//Consultar alumnos por ID
if(isset($_GET["consultar"])){
    $sqlConsultar= mysqli_query($conexionDB, "SELECT * FROM alumnos WHERE id=".$_GET["consultar"]);
    if(mysqli_num_rows($sqlConsultar)> 0){
        $alumno = mysqli_fetch_all($sqlConsultar, MYSQLI_ASSOC);
        echo json_decode($alumno);
        exit();
    } else{
        echo json_decode(["success"==0]);
    }
}

//Borrar un alumno en especifico
if(isset($_GET["borrar"])){
    $sqlBorrar= mysqli_query($conexionDB, "DELETE  FROM alumnos WHERE id=".$_GET["borrar"]);
    if($sqlBorrar){
        echo json_encode(["success"==1]);
        exit();
    }else{
        echo json_encode(["success"==0]);
    }
}

if(isset($_GET["insertar"])){
    $data = json_decode(file_get_contents("php://input"));
    $nombre = $data->nombre;
    $correo = $data->correo;

    if($nombre != "" && $correo != ""){
        $sqlInsertar = mysqli_query($conexionDB, "INSERT into alumnos(nombre,correo) VALUES ('$nombre', '$correo')");
        echo json_encode(["success"==1]);
    }
}

if(isset($_GET["actualizar"])){
    $data = json_decode(file_get_contents("php://input"));
    $id = (isset($data->id))?$data->id:$_GET(["actualizar"]);
    $nombre = $data->nombre;
    $correo = $data->correo;

    if($nombre != "" && $correo != ""){
        $sqlActualizar = mysqli_query($conexionDB, "UPDATE alumnos SET nombre='$nombre', correo='$correo' WHERE id='$id'");
            echo json_encode(["success"==1]);
        exit();
    }
}

//Mostrar todos los datos del alumno
$sqlTodos = mysqli_query($conexionDB, "SELECT * FROM alumnos");
if(mysqli_num_rows($sqlTodos) > 0){
    $alumnos = mysqli_fetch_all($sqlTodos, MYSQLI_ASSOC);
    echo json_encode($alumnos);
}else{
    echo json_encode(["success"==0]);
}

?>