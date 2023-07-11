<?php

$servername = "localhost";
$username = "cus77424_user_rcancino";
$password = "cus77424_Rcancino%21";
$dbname = "cus77424_maxgalleg";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Error de conexi贸n: " . $conn->connect_error);
}

$tipoUsuario = $_POST['tipo-usuario'];
$nombre = $_POST['nombre'];
$rut = $_POST['rut'];
$telefono = $_POST['telefono'];
$direccion = $_POST['direccion'];
$ncasa = $_POST['numero'];
$email = $_POST['email'];
$password = $_POST['contrasena'];


if ($tipoUsuario == 'cliente') {
    $sql = "INSERT INTO mCliente (nombre, rut, telefono, direccion, ncasa, email, password) VALUES ('$nombre', '$rut', '$telefono', '$direccion', '$ncasa', '$email', '$password')";
} elseif ($tipoUsuario == 'arrendatario') {
    $sql = "INSERT INTO mArrendatario (nombre, rut, telefono, direccion, ncasa, email, password) VALUES ('$nombre', '$rut', '$telefono', '$direccion', '$ncasa', '$email', '$password')";
} else {
    echo '<script>alert("Tipo de usuario inv谩lido"); window.location.href = "login.html";</script>';
    exit;
}

if ($conn->query($sql) === TRUE) {
    
    echo '<script>alert("El ' . $tipoUsuario . ' con nombre ' . $nombre . ' se ha registrado correctamente en la base de datos"); window.location.href = "login.html";</script>';
} else {
   
    echo '<script>alert("Error al registrar en la base de datos"); window.location.href = "index.html";</script>';
}

// Cerrar la conexi贸n
$conn->close();

?>

