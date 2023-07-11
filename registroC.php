<?php
session_start();

if (isset($_SESSION['cliente_id'])) {
  $cliente_id = $_SESSION['cliente_id'];
  $host = 'localhost';
  $db = 'cus77424_maxgalleg';
  $usuario = 'cus77424_user_rcancino';
  $contrasena_db = 'cus77424_Rcancino%21';
  $conexion = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $usuario, $contrasena_db);
  $tipo_vehiculo = $_POST['tipo'];
  $marca = $_POST['marca'];
  $modelo = $_POST['modelo'];
  $patente = $_POST['patente'];
  $query = "INSERT INTO mVehiculo (id_cliente, tipo_vehiculo, marca, modelo, patente) VALUES (:cliente_id, :tipo_vehiculo, :marca, :modelo, :patente)";
  $stmt = $conexion->prepare($query);
  $stmt->bindParam(':cliente_id', $cliente_id);
  $stmt->bindParam(':tipo_vehiculo', $tipo_vehiculo);
  $stmt->bindParam(':marca', $marca);
  $stmt->bindParam(':modelo', $modelo);
  $stmt->bindParam(':patente', $patente);

  if ($stmt->execute()) {
    echo "<script>alert('El vehículo se registró correctamente');</script>";
    echo "<script>window.location.href = 'autosCliente.php';</script>";
  } else {
    echo "<script>alert('Error al registrar el vehículo');</script>";
    echo "<script>window.location.href = 'autosCliente.php';</script>";
  }
} else {
  echo "<script>alert('Usuario no autenticado');</script>";
  echo "<script>window.location.href = 'autosCliente.php';</script>";
}
?>
