<?php
$cliente_id = $_POST['cliente_id'];
$pais = $_POST['pais'];
$banco = $_POST['banco'];
$tipo_cuenta = $_POST['tipo_cuenta'];
$numero_cuenta = $_POST['numero_cuenta'];
$mes = $_POST['mes'];
$anio = $_POST['anio'];
$host = 'localhost';
$db = 'cus77424_maxgalleg';
$usuario = 'cus77424_user_rcancino';
$contrasena_db = 'cus77424_Rcancino%21';

try {
    $conexion = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $usuario, $contrasena_db);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "INSERT INTO mCBancaria (id_usuario, pais, banco, tipo_cuenta, numero_cuenta, mes, anio) 
              VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($query);
    $stmt->execute([$cliente_id, $pais, $banco, $tipo_cuenta, $numero_cuenta, $mes, $anio]);

    echo "<script>alert('¡Cuenta bancaria agregada con éxito!'); window.location.href = 'micuentaCliente.php';</script>";
    exit;
} catch (PDOException $e) {
    echo "<script>alert('Error al agregar la cuenta bancaria: " . $e->getMessage() . "');</script>";
    exit;
}
?>
