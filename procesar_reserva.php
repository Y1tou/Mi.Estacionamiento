<?php
var_dump($_POST);
$host = 'localhost';
$db = 'cus77424_maxgalleg';
$usuario = 'cus77424_user_rcancino';
$contrasena_db = 'cus77424_Rcancino%21';

$conexion = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $usuario, $contrasena_db);

$id_cliente = $_POST['id_cliente'];
$id_estacionamiento = $_POST['id_estacionamiento'];

$query_estacionamiento = "SELECT ubicacion, nombre, tarifa_minuto, espacios_disponibles FROM mEstacionamientos WHERE id = :id_estacionamiento";
$stmt_estacionamiento = $conexion->prepare($query_estacionamiento);
$stmt_estacionamiento->bindParam(':id_estacionamiento', $id_estacionamiento);
$stmt_estacionamiento->execute();
$estacionamiento = $stmt_estacionamiento->fetch(PDO::FETCH_ASSOC);

if ($estacionamiento) {
  $ubicacion_estacionamiento = $estacionamiento['ubicacion'];
  $nombre_estacionamiento = $estacionamiento['nombre'];
  $tarifa_por_minuto = $estacionamiento['tarifa_minuto'];
  $espacios_disponibles = $estacionamiento['espacios_disponibles'];
} else {
  
}

$patente_vehiculo = $_POST['vehiculo'];
$query_vehiculo = "SELECT tipo_vehiculo, marca FROM mVehiculo WHERE patente = :patente_vehiculo";
$stmt_vehiculo = $conexion->prepare($query_vehiculo);
$stmt_vehiculo->bindParam(':patente_vehiculo', $patente_vehiculo);
$stmt_vehiculo->execute();
$vehiculo = $stmt_vehiculo->fetch(PDO::FETCH_ASSOC);

if ($vehiculo) {
  $tipo_vehiculo = $vehiculo['tipo_vehiculo'];
  $marca_vehiculo = $vehiculo['marca'];
} else {
  
}

$query_cliente = "SELECT nombre, rut FROM mCliente WHERE id = :id_cliente";
$stmt_cliente = $conexion->prepare($query_cliente);
$stmt_cliente->bindParam(':id_cliente', $id_cliente);
$stmt_cliente->execute();
$cliente = $stmt_cliente->fetch(PDO::FETCH_ASSOC);

if ($cliente) {
  $nombre_cliente = $cliente['nombre'];
  $rut_cliente = $cliente['rut'];
} else {

}

$tiempo_reserva = $_POST['tiempo_reserva'];
$total = $_POST['total'];
$query_insert_ticket = "INSERT INTO mTicket (ubicacion, nombre_estacionamiento, tarifa_por_minuto, nombre_cliente, rut_cliente, tipo_vehiculo, marca_vehiculo, patente_vehiculo, tiempo_reserva, total) VALUES (:ubicacion, :nombre_estacionamiento, :tarifa_por_minuto, :nombre_cliente, :rut_cliente, :tipo_vehiculo, :marca_vehiculo, :patente_vehiculo, :tiempo_reserva, :total)";
$stmt_insert_ticket = $conexion->prepare($query_insert_ticket);
$stmt_insert_ticket->bindParam(':ubicacion', $ubicacion_estacionamiento);
$stmt_insert_ticket->bindParam(':nombre_estacionamiento', $nombre_estacionamiento);
$stmt_insert_ticket->bindParam(':tarifa_por_minuto', $tarifa_por_minuto);
$stmt_insert_ticket->bindParam(':nombre_cliente', $nombre_cliente);
$stmt_insert_ticket->bindParam(':rut_cliente', $rut_cliente);
$stmt_insert_ticket->bindParam(':tipo_vehiculo', $tipo_vehiculo);
$stmt_insert_ticket->bindParam(':marca_vehiculo', $marca_vehiculo);
$stmt_insert_ticket->bindParam(':patente_vehiculo', $patente_vehiculo);
$stmt_insert_ticket->bindParam(':tiempo_reserva', $tiempo_reserva);
$stmt_insert_ticket->bindParam(':total', $total);
$insercion_exitosa = $stmt_insert_ticket->execute();
$espacios_disponibles -= 1;
$query_update_estacionamiento = "UPDATE mEstacionamientos SET espacios_disponibles = :espacios_disponibles WHERE id = :id_estacionamiento";
$stmt_update_estacionamiento = $conexion->prepare($query_update_estacionamiento);
$stmt_update_estacionamiento->bindParam(':espacios_disponibles', $espacios_disponibles);
$stmt_update_estacionamiento->bindParam(':id_estacionamiento', $id_estacionamiento);
$stmt_update_estacionamiento->execute();
if ($insercion_exitosa) {
  echo '<script>alert("Reserva procesada exitosamente."); window.location.href = "buscarEstacionamientoC.php";</script>';
} else {
  echo '<script>alert("Hubo un error al procesar la reserva."); window.location.href = "buscarEstacionamientoC.php";</script>';
}
?>

?>
