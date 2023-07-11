<?php
session_start(); 

if (isset($_SESSION['cliente_id'])) {
  $cliente_id = $_SESSION['cliente_id'];
  $host = 'localhost';
  $db = 'cus77424_maxgalleg';
  $usuario = 'cus77424_user_rcancino';
  $contrasena_db = 'cus77424_Rcancino%21';

  $conexion = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $usuario, $contrasena_db);
  $query = "SELECT nombre FROM mCliente WHERE id = :cliente_id";
  $stmt = $conexion->prepare($query);
  $stmt->bindParam(':cliente_id', $cliente_id);
  $stmt->execute();
  $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($cliente) {
    $nombre_usuario = $cliente['nombre'];
  } else {
    $nombre_usuario = "Usuario"; 
  }
} else {
  $nombre_usuario = "Usuario"; 
}


$_SESSION['cliente_id'] = $cliente_id;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenidos a MiEstacionamiento</title>
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
    background: blue;
    display: flex;
    justify-content: space-between;
    align-items: center;
    z-index: 99;
}
.logo{
    font-size: 2em;
    color: yellow;
    user-select: none;
}
.navigation a{
    position: relative;
    font-size: 1.1em;
    color: yellow;
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
    background: yellow;
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
    border: 2px solid yellow;
    outline: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 1.1em ;
    color: yellow;
    font-weight: 500;
    margin-left: 40px;
    transition: .5s;
}
.navigation .btnlogin-popup:hover{
    background: yellow;
    color: blue;
}
.navigation .btnsignup-popup{
    width: 130px;
    height: 50px;
    background: transparent;
    border: 2px solid yellow;
    outline: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 1.1em ;
    color: yellow;
    font-weight: 500;
    margin-left: 20px;
    transition: .5s;
}
.navigation .btnsignup-popup:hover{
    background: yellow;
    color: blue;
}

    </style>
</head>
<body>
    <header>
        <h2 class="logo"><i class="ri-parking-box-line"></i></i>MiEstacionamiento</h2>
        <nav class="navigation">
            <a href="vistaCliente.php"><?php echo $nombre_usuario; ?></a>
            <a href="autosCliente.php">Mis autos</a>
            <a href="buscarEstacionamientoC.php">Buscar Estacionamiento</a>
            <button class="btnlogin-popup" onclick="redirectToMiCuenta()">Mi cuenta</button>
            <button class="btnsignup-popup" onclick="cerrarSesion()">Cerrar Sesion</button>

        </nav>
    </header>
    
    <section id="map-section">
        <iframe id="map-iframe" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2839.767428184005!2d-71.21464599715011!3d-33.69483130300826!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x966255eae610cb2f%3A0xc3fdb55ead51065b!2sDuoc%20UC%3A%20Sede%20Melipilla!5e1!3m2!1ses!2scl!4v1689017734107!5m2!1ses!2scl" frameborder="0" style="border: 0; width: 100%; height: 100vh;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </section>
    
    <script>
        function redirectToMiCuenta() {
            window.location.href = "micuentaCliente.php";
        }
        function cerrarSesion(){
            alert("Se a Cerrado Sesion Exitosamente!"); window.location.href = "index.html";
        }
    </script>
    
<script type="text/javascript" src="scripts.js"></script>
</body>
</html>
