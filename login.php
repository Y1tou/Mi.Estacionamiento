<?php
session_start(); 
$tipoUsuario = $_POST['tipo-usuario'];
$correo = $_POST['correo'];
$contrasena = $_POST['password'];
$host = 'localhost';
$db = 'cus77424_maxgalleg';
$usuario = 'cus77424_user_rcancino';
$contrasena_db = 'cus77424_Rcancino%21';

$conexion = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $usuario, $contrasena_db);

if ($tipoUsuario === 'cliente') {
  $query = "SELECT * FROM mCliente WHERE email = :correo AND password = :contrasena";
  $stmt = $conexion->prepare($query);
  $stmt->bindParam(':correo', $correo);
  $stmt->bindParam(':contrasena', $contrasena);
  $stmt->execute();
  $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($cliente) {
    $nombre_registrado = $cliente['nombre'];
    $_SESSION['cliente_id'] = $cliente['id']; // 
    echo "<script>alert('Bienvenido Cliente $nombre_registrado'); window.location.href='vistaCliente.php';</script>";
  } else {
    echo "<script>alert('Email o contraseña incorrectos'); window.location.href='index.html';</script>";
  }
} elseif ($tipoUsuario === 'arrendatario') {
  $query = "SELECT * FROM mArrendatario WHERE email = :correo AND password = :contrasena";
  $stmt = $conexion->prepare($query);
  $stmt->bindParam(':correo', $correo);
  $stmt->bindParam(':contrasena', $contrasena);
  $stmt->execute();
  $arrendatario = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($arrendatario) {
    $nombre_registrado = $arrendatario['nombre'];
    $_SESSION['arrendatario_id'] = $arrendatario['id']; 
    echo "<script>alert('Bienvenido Arrendatario $nombre_registrado'); window.location.href='vistaArrendatario.php';</script>";
  } else {
    echo "<script>alert('Email o contraseña incorrectos'); window.location.href='index.html';</script>";
  }
} else {
  echo "<script>alert('Tipo de usuario no válido'); window.location.href='index.html';</script>";
}
?>
