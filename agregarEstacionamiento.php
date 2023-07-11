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

// Pasar la ID del arrendatario a la sesión
$_SESSION['arrendatario_id'] = $arrendatario_id;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenidos a MiEstacionamiento</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap');

* {
  margin: 0;
  font-family: 'Poppins', sans-serif;
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

.logo {
  font-size: 2em;
  color: #fff;
  user-select: none;
}

.navigation a {
  position: relative;
  font-size: 1.1em;
  color: #fff;
  text-decoration: none;
  font-weight: 500;
  margin-left: 40px;
}

.navigation a::after {
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

.navigation a:hover::after {
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
  font-size: 1.1em;
  color: #fff;
  font-weight: 500;
  margin-left: 40px;
  transition: .5s;
}

.navigation .btnlogin-popup:hover {
  background: white;
  color: black;
}

.navigation .btnsignup-popup {
  width: 130px;
  height: 50px;
  background: transparent;
  border: 2px solid #fff;
  outline: none;
  border-radius: 6px;
  cursor: pointer;
  font-size: 1.1em;
  color: #fff;
  font-weight: 500;
  margin-left: 20px;
  transition: .5s;
}

.navigation .btnsignup-popup:hover {
  background: white;
  color: black;
}

section {
  display: flex;
}

.form-container {
  background-color: #f8f9fa;
  border-radius: 8px;
  padding: 20px;
  margin-top: 150px;
  width: 50%;
  margin-left: 500px;
}

.form-label {
  font-weight: bold;
}

.form-control {
  border-radius: 6px;
  padding: 10px;
  margin-bottom: 10px;
}

.btn-primary {
  background-color: black;
  border: none;
  border-radius: 6px;
  padding: 10px 20px;
  font-size: 1em;
  color: #fff;
  transition: background-color 0.3s;
}

.btn-primary:hover {
  background-color: #000000cc;
}

.text-center {
  margin-top: 20px;
}

.input-group-prepend .input-group-text {
  background-color: #000;
  color: #fff;
  border: none;
  height: 40px;
}

    </style>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css" rel="stylesheet">
    
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
        <div class="form-container">
            <form action="registrarEstacionamiento.php" method="POST">
                <h3 class="text-center">Agregar estacionamiento</h3>
                <div class="mb-3">
                    <label for="ubicacion" class="form-label">Ubicaci贸n</label>
                    <div class="input-group">
                        <span class="input-group-prepend">
                            <span class="input-group-text"><i class="ri-map-pin-line"></i></span>
                        </span>
                        <input type="text" class="form-control" id="ubicacion" name="ubicacion" placeholder="Ingrese la ubicaci贸n">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <div class="input-group">
                        <span class="input-group-prepend">
                            <span class="input-group-text"><i class="ri-file-text-line"></i></span>
                        </span>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese el nombre">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="espacios" class="form-label">Espacios Disponibles</label>
                    <div class="input-group">
                        <span class="input-group-prepend">
                            <span class="input-group-text"><i class="ri-stack-line"></i></span>
                        </span>
                        <input type="number" class="form-control" id="espacios" name="espacios" placeholder="Ingrese la cantidad de espacios disponibles">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="hora-inicio" class="form-label">Hora Inicio</label>
                    <div class="input-group">
                        <span class="input-group-prepend">
                            <span class="input-group-text"><i class="ri-time-fill"></i></span>
                        </span>
                        <input type="time" class="form-control" name="hora-inicio" id="hora-inicio">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="hora-termino" class="form-label">Hora Termino</label>
                    <div class="input-group">
                        <span class="input-group-prepend">
                            <span class="input-group-text"><i class="ri-time-fill"></i></span>
                        </span>
                        <input type="time" class="form-control" name="hora-termino" id="hora-termino">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="tarifa" class="form-label">Tarifa X minuto</label>
                    <div class="input-group">
                        <span class="input-group-prepend">
                            <span class="input-group-text"><i class="ri-money-dollar-circle-line"></i></span>
                        </span>
                        <input type="number" class="form-control" id="tarifa" name="tarifa" placeholder="Ingrese la tarifa por minuto">
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Agregar Estacionamiento</button>
                    <button type="button" class="btn btn-danger" onclick="redirectToEstacionamientoArrendatario()">Cancelar</button>
                </div>
            </form>
        </div>
        
        
    </section>
    
<script type="text/javascript" src="scripts.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
    function redirectToEstacionamientoArrendatario() {
        window.location.href = "estacionamientoArrendatario.php";
    }
    
    function redirectToMiCuenta() {
        window.location.href = "micuentaArrendatario.php";
    }
    
    function cerrarSesion(){
        alert("Se a Cerrado Sesion Exitosamente!"); window.location.href = "index.html";
    }
</script>
</body>
</html>
