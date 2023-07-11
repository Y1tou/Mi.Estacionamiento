<?php
session_start();

if (isset($_SESSION['cliente_id'])) {
  $cliente_id = $_SESSION['cliente_id'];
  $host = 'localhost';
  $db = 'cus77424_maxgalleg';
  $usuario = 'cus77424_user_rcancino';
  $contrasena_db = 'cus77424_Rcancino%21';

  $conexion = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $usuario, $contrasena_db);

  if (isset($_POST['id']) && isset($_POST['tipo']) && isset($_POST['marca']) && isset($_POST['modelo']) && isset($_POST['patente'])) {
    $vehiculo_id = $_POST['id'];
    $tipo_vehiculo = $_POST['tipo'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $patente = $_POST['patente'];
    $query_actualizar = "UPDATE mVehiculo SET tipo_vehiculo = :tipo, marca = :marca, modelo = :modelo WHERE id = :vehiculo_id";
    $stmt_actualizar = $conexion->prepare($query_actualizar);
    $stmt_actualizar->bindParam(':tipo', $tipo_vehiculo);
    $stmt_actualizar->bindParam(':marca', $marca);
    $stmt_actualizar->bindParam(':modelo', $modelo);
    $stmt_actualizar->bindParam(':vehiculo_id', $vehiculo_id);

    if ($stmt_actualizar->execute()) {
      header("Location: autosCliente.php?msg=success");
      exit;
    } else {
      header("Location: autosCliente.php?msg=error");
      exit;
    }
  } else {
    header("Location: autosCliente.php");
    exit;
  }
} else {
 
  header("Location: login.php");
  exit;
}
?>

<script>
  <?php if (isset($_GET['msg']) && $_GET['msg'] === 'success'): ?>
    alert("El vehículo se ha editado correctamente.");
  <?php elseif (isset($_GET['msg']) && $_GET['msg'] === 'error'): ?>
    alert("No se pudo editar el vehículo.");
  <?php endif; ?>
  window.location.href = "autosCliente.php";
</script>
