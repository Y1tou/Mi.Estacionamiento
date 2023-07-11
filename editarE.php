<?php
session_start();

if (isset($_SESSION['arrendatario_id'])) {
  $arrendatario_id = $_SESSION['arrendatario_id'];
  $host = 'localhost';
  $db = 'cus77424_maxgalleg';
  $usuario = 'cus77424_user_rcancino';
  $contrasena_db = 'cus77424_Rcancino%21';

  $conexion = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $usuario, $contrasena_db);
  $query = "SELECT nombre FROM mArrendatario WHERE id = :arrendatario_id";
  $stmt = $conexion->prepare($query);
  $stmt->bindParam(':arrendatario_id', $arrendatario_id);
  $stmt->execute();
  $arrendatario = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($arrendatario) {
    $nombre_usuario = $arrendatario['nombre'];
  } else {
    $nombre_usuario = "Usuario";
  }
} else {
  $nombre_usuario = "Usuario";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $estacionamiento_id = $_POST['estacionamiento_id'];
  $ubicacion = $_POST['ubicacion'];
  $nombre = $_POST['nombre'];
  $espacios = $_POST['espacios'];
  $hora_inicio = $_POST['hora-inicio'];
  $hora_termino = $_POST['hora-termino'];
  $tarifa = $_POST['tarifa'];

  $query = "UPDATE mEstacionamientos SET ubicacion = :ubicacion, nombre = :nombre, espacios_disponibles = :espacios, hora_inicio = :hora_inicio, hora_termino = :hora_termino, tarifa_minuto = :tarifa WHERE id = :estacionamiento_id";
  $stmt = $conexion->prepare($query);
  $stmt->bindParam(':ubicacion', $ubicacion);
  $stmt->bindParam(':nombre', $nombre);
  $stmt->bindParam(':espacios', $espacios);
  $stmt->bindParam(':hora_inicio', $hora_inicio);
  $stmt->bindParam(':hora_termino', $hora_termino);
  $stmt->bindParam(':tarifa', $tarifa);
  $stmt->bindParam(':estacionamiento_id', $estacionamiento_id);

  if ($stmt->execute()) {
    echo "El estacionamiento ha sido editado";
    echo '<script>window.location.href = "estacionamientoArrendatario.php";</script>';
    exit;
  } else {
    echo "Error al editar el estacionamiento";
  }
}
?>
