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

if (isset($_GET['id'])) {
  $vehiculo_id = $_GET['id'];
  $host = 'localhost';
  $db = 'cus77424_maxgalleg';
  $usuario = 'cus77424_user_rcancino';
  $contrasena_db = 'cus77424_Rcancino%21';
  $conexion = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $usuario, $contrasena_db);
  $query_vehiculo = "SELECT * FROM mVehiculo WHERE id = :vehiculo_id";
  $stmt_vehiculo = $conexion->prepare($query_vehiculo);
  $stmt_vehiculo->bindParam(':vehiculo_id', $vehiculo_id);
  $stmt_vehiculo->execute();
  $datos_vehiculo = $stmt_vehiculo->fetch(PDO::FETCH_ASSOC);

  if (!$datos_vehiculo) {
    header("Location: autosCliente.php");
    exit;
  }

} else {
  header("Location: autosCliente.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenidos a MiEstacionamiento</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css" rel="stylesheet">
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
            background: blue;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 99;
        }
        .logo {
            font-size: 2em;
            color: yellow;
            user-select: none;
        }
        .navigation a {
            position: relative;
            font-size: 1.1em;
            color: yellow;
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
            background: yellow;
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
        .navigation .btnlogin-popup:hover {
            background: yellow;
            color: blue;
        }
        .navigation .btnsignup-popup {
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
        .navigation .btnsignup-popup:hover {
            background: yellow;
            color: blue;
        }
        section {
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f2f2f2;
        }
        .form-container {
            max-width: 400px;
            padding: 40px;
            background-color: white;
            border-radius: 6px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-title {
            margin-bottom: 20px;
            text-align: center;
            font-size: 1.8em;
            color: blue;
            font-weight: bold;
        }
        .form-group {
            margin-bottom: 20px;
            width: 90%;
        }
        label {
            color: blue;
            font-weight: bold;
        }
        .input-icon {
            position: relative;
        }
        .input-icon i {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            right: 10px;
            color: blue;
        }
        .btn-register {
            background-color: blue;
            color: yellow;
            font-weight: bold;
            transition: .5s;
            width: 80%;
        }
        .btn-register:hover {
            background-color: yellow;
            color: blue;
        }
        .btn btn-secondary{
            width: 60&;
        }
    </style>
</head>
<body>
    <header>
        <h2 class="logo"><i class="ri-parking-box-line"></i>MiEstacionamiento</h2>
        <nav class="navigation">
            <a href="#"><?php echo $nombre_usuario; ?></a>
            <a href="autosCliente.php">Mis autos</a>
            <a href="buscarEstacionamientoC.php">Buscar Estacionamiento</a>
            <button class="btnlogin-popup" onclick="redirectToLoginPage()">Mi cuenta</button>
            <button class="btnsignup-popup">Cerrar Sesion</button>
        </nav>
    </header>
    <section>
        <div class="form-container">
            <h3 class="form-title">Editar Auto</h3>
            <form action="actualizarAuto.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $vehiculo_id; ?>">
                <input type="hidden" name="cliente_id" value="<?php echo $cliente_id; ?>">
                <div class="form-group">
                    <label for="tipo">
                        Tipo de vehículo
                        <div class="input-icon">
                            <input type="text" class="form-control" id="tipo" name="tipo" required>
                            <i class="ri-car-line"></i>
                        </div>
                    </label>
                </div>
                <div class="form-group">
                    <label for="marca">
                        Marca
                        <div class="input-icon">
                            <input type="text" class="form-control" id="marca"  name="marca"required>
                            <i class="ri-car-fill"></i>
                        </div>
                    </label>
                </div>
                <div class="form-group">
                    <label for="modelo">
                        Modelo
                        <div class="input-icon">
                            <input type="text" class="form-control" id="modelo" name="modelo" required>
                            <i class="ri-steering-2-fill"></i>
                        </div>
                    </label>
                </div>
                <div class="form-group">
                    <label for="patente">
                        Patente
                        <div class="input-icon">
                            <input type="text" id="patente" class="form-control" name="patente" value="<?php echo $datos_vehiculo['patente']; ?>" readonly>

                            <i class="ri-number-plate-2-fill"></i>
                        </div>
                    </label>
                </div>
                <button type="submit" class="btn btn-primary btn-register">Editar Auto</button>
                <a href="autosCliente.php" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
