<?php
session_start();

if (isset($_SESSION['arrendatario_id'])) {
  $arrendatario_id = $_SESSION['arrendatario_id'];
  $host = 'localhost';
  $db = 'cus77424_maxgalleg';
  $usuario = 'cus77424_user_rcancino';
  $contrasena_db = 'cus77424_Rcancino%21';

  $conexion = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $usuario, $contrasena_db);
  $query = "SELECT * FROM mArrendatario WHERE id = :arrendatario_id";
  $stmt = $conexion->prepare($query);
  $stmt->bindParam(':arrendatario_id', $arrendatario_id);
  $stmt->execute();
  $arrendatario = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($arrendatario) {
    $nombre_usuario = $arrendatario['nombre'];
  } else {
    $nombre_usuario = "Usuario";
  }

  // Obtener los estacionamientos del arrendatario
  $query_estacionamientos = "SELECT * FROM mEstacionamientos WHERE arrendatario_id = :arrendatario_id";
  $stmt_estacionamientos = $conexion->prepare($query_estacionamientos);
  $stmt_estacionamientos->bindParam(':arrendatario_id', $arrendatario_id);
  $stmt_estacionamientos->execute();
  $estacionamientos = $stmt_estacionamientos->fetchAll(PDO::FETCH_ASSOC);

  // Verificar si se hizo clic en los botones de Habilitar o Deshabilitar
  if (isset($_POST['habilitar'])) {
    $estacionamiento_id = $_POST['habilitar'];
    habilitarEstacionamiento($estacionamiento_id, $conexion);
    header("Location: estacionamientoArrendatario.php"); // Redirigir a la página para mostrar los cambios actualizados
    exit();
  }

  if (isset($_POST['deshabilitar'])) {
    $estacionamiento_id = $_POST['deshabilitar'];
    deshabilitarEstacionamiento($estacionamiento_id, $conexion);
    header("Location: estacionamientoArrendatario.php"); // Redirigir a la página para mostrar los cambios actualizados
    exit();
  }
} else {
  $nombre_usuario = "Usuario";
}

$_SESSION['arrendatario_id'] = $arrendatario_id;

function habilitarEstacionamiento($estacionamiento_id, $conexion) {
  $query = "UPDATE mEstacionamientos SET disponible = 'si' WHERE id = :estacionamiento_id";
  $stmt = $conexion->prepare($query);
  $stmt->bindParam(':estacionamiento_id', $estacionamiento_id);
  $stmt->execute();
}

function deshabilitarEstacionamiento($estacionamiento_id, $conexion) {
  $query = "UPDATE mEstacionamientos SET disponible = 'no' WHERE id = :estacionamiento_id";
  $stmt = $conexion->prepare($query);
  $stmt->bindParam(':estacionamiento_id', $estacionamiento_id);
  $stmt->execute();
}

$_SESSION['arrendatario_id'] = $arrendatario_id;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Cuenta</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap');
*{
    margin: 0;
    font-family: 'Poppins',sans-serif;
    padding: 0;
    box-sizing: border-box;
}
header {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    padding: 20px 100px;
    background: black;
    display: flex;
    justify-content: space-between;
    align-items: center;
    z-index: 99;
}
.logo{
    font-size: 2em;
    color: #fff;
    user-select: none;
}
.navigation a{
    position: relative;
    font-size: 1.1em;
    color: #fff;
    text-decoration: none;
    font-weight: 500;
    margin-left: 40px;
}
.navigation a::after{
    content: '';
    position: absolute;
    width: 100%;
    left: 0;
    bottom: -6px;
    height: 3px;
    background: #fff;
    border-radius: 5px;
    transform: scaleX(0);
    transform-origin: right;
    transition: transform .5s;

}
.navigation a:hover::after{
    transform: scaleX(1);
    transform-origin: left;
}

.navigation .btnlogin-popup {
    width: 130px;
    height: 50px;
    background: transparent;
    border: 2px solid #fff;
    outline: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 1.1em ;
    color: #fff;
    font-weight: 500;
    margin-left: 40px;
    transition: .5s;
}
.navigation .btnlogin-popup:hover{
    background: white;
    color: black;
}
.navigation .btnsignup-popup{
    width: 130px;
    height: 50px;
    background: transparent;
    border: 2px solid #fff;
    outline: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 1.1em ;
    color: #fff;
    font-weight: 500;
    margin-left: 20px;
    transition: .5s;
}
.navigation .btnsignup-popup:hover{
    background: white;
    color: black;
}
        section {
            width: 100%;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: #f2f2f2;
            padding-top: 20px; 
        }
        .card {
            width: 600px;
            padding: 20px;
            background-color: white;
            border-radius: 6px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px; 
        .card-title {
            text-align: center;
            font-size: 1.8em;
            color: black;
            font-weight: bold;
        }
        .card-content {
            margin-top: 20px;
        }
        .card-content p {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <header>
        <h2 class="logo"><i class="ri-parking-box-line"></i></i>MiEstacionamiento</h2>
        <nav class="navigation">
            <a href="vistaArrendatario.php"><?php echo $nombre_usuario; ?></a>
            <a href="estacionamientoArrendatario.php">Mis Estacionamientos </a>
            <button class="btnlogin-popup" onclick="redirectToMiCuenta()">Mi cuenta</button>
            <button class="btnsignup-popup" onclick="cerrarSesion()">Cerrar Sesion</button>

        </nav>
    </header>
    <section>
        <div class="card">
            <h3 class="card-title">Datos del Arrendatario</h3>
            <div class="card-content">
                <p><strong>Nombre:</strong> <?php echo $arrendatario['nombre']; ?></p>
                <p><strong>RUT:</strong> <?php echo $arrendatario['rut']; ?></p>
                <p><strong>Correo electrónico:</strong> <?php echo $arrendatario['email']; ?></p>
                <p><strong>Teléfono:</strong> <?php echo $arrendatario['telefono']; ?></p>
                <p><strong>Dirección:</strong> <?php echo $arrendatario['direccion']; ?></p>
                <p><strong>Numero de casa:</strong> <?php echo $arrendatario['ncasa']; ?></p>
            </div>
        </div>

    </section>
    
<script type="text/javascript" src="scripts.js"></script>
<script>
    function redirectToMiCuenta() {
        window.location.href = "micuentaArrendatario.php";
    }
    
    function cerrarSesion(){
        alert("Se a Cerrado Sesion Exitosamente!"); window.location.href = "index.html";
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
