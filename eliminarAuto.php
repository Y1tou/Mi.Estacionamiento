<?php
session_start();

if (isset($_SESSION['cliente_id']) && isset($_GET['id'])) {
  $cliente_id = $_SESSION['cliente_id'];
  $auto_id = $_GET['id'];
  $host = 'localhost';
  $db = 'cus77424_maxgalleg';
  $usuario = 'cus77424_user_rcancino';
  $contrasena_db = 'cus77424_Rcancino%21';

  $conexion = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $usuario, $contrasena_db);
  $query_verificar = "SELECT * FROM mVehiculo WHERE id = :auto_id AND id_cliente = :cliente_id";
  $stmt_verificar = $conexion->prepare($query_verificar);
  $stmt_verificar->bindParam(':auto_id', $auto_id);
  $stmt_verificar->bindParam(':cliente_id', $cliente_id);
  $stmt_verificar->execute();
  $vehiculo = $stmt_verificar->fetch(PDO::FETCH_ASSOC);

  if ($vehiculo) {

    $query_eliminar = "DELETE FROM mVehiculo WHERE id = :auto_id";
    $stmt_eliminar = $conexion->prepare($query_eliminar);
    $stmt_eliminar->bindParam(':auto_id', $auto_id);
    $stmt_eliminar->execute();
    echo "<script>alert('El auto ha sido eliminado correctamente.'); window.location.href = 'autosCliente.php';</script>";
    exit;
  } else {
    echo "<script>alert('No se pudo eliminar el auto.'); window.location.href = 'autosCliente.php';</script>";
    exit;
  }
} else {
  header("Location: login.php");
  exit;
}
?>
