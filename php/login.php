<?php 
include('db.php');


//Logout
if (isset($_GET['s']))
	if($_GET['s'] == 1) {
		session_start();
		session_destroy();
		exit(header("location: ../views/index.html"));	
	}

//Salir si no hay POST
if(!$_POST)
	exit(header("location: registro.html"));


if (!isset($_POST['usuario']) || !isset($_POST['pass']))
    exit(header("location: ../views/index.html?e=4"));

$usuario = $_POST['usuario'];
$pass = $_POST['pass'];
login($usuario, $pass);        

function login($u,$p){
	$p = md5($p);
    $query = "SELECT * FROM usuario WHERE nombreUsuario='{$u}' AND password='{$p}' OR correo='{$u}' AND password='{$p}'";
    $resultado = consulta($query);
    if ($resultado->num_rows == 0)
        exit(header("location: ../views/index.html?e=5"));
    else {
        session_start();
        while ($r = mysqli_fetch_array($resultado)) {
            $_SESSION['id'] = $r['idUsuario'];
            $_SESSION['usuario'] = $r['nombreUsuario'];
        }
        exit(header("location: ../views/main.html"));
    }
}

 ?>