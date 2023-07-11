<?php
session_start();

if (isset($_SESSION['cliente_id'])) {
  $cliente_id = $_SESSION['cliente_id'];
  $host = 'localhost';
  $db = 'cus77424_maxgalleg';
  $usuario = 'cus77424_user_rcancino';
  $contrasena_db = 'cus77424_Rcancino%21';

  $conexion = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $usuario, $contrasena_db);

  // Consulta para obtener el nombre del cliente
  $query_cliente = "SELECT nombre FROM mCliente WHERE id = :cliente_id";
  $stmt_cliente = $conexion->prepare($query_cliente);
  $stmt_cliente->bindParam(':cliente_id', $cliente_id);
  $stmt_cliente->execute();
  $cliente = $stmt_cliente->fetch(PDO::FETCH_ASSOC);

  if ($cliente) {
    $nombre_usuario = $cliente['nombre'];
  } else {
    $nombre_usuario = "Usuario"; 
  }

  // Consulta para obtener los vehículos asociados al cliente
  $query_vehiculos = "SELECT * FROM mVehiculo WHERE id_cliente = :cliente_id";
  $stmt_vehiculos = $conexion->prepare($query_vehiculos);
  $stmt_vehiculos->bindParam(':cliente_id', $cliente_id);
  $stmt_vehiculos->execute();
  $vehiculos = $stmt_vehiculos->fetchAll(PDO::FETCH_ASSOC);
} else {
  // Redireccionar al inicio de sesión si no hay un cliente_id en la sesión
  header("Location: login.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenidos a MiEstacionamiento</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
        section {
            display: flex;
            justify-content: center;
            align-items: center;
           flex-direction: column;
        }
        .table-container {
            margin-top: 150px;
            max-width: 1400px;
        }
        .table {
            background-color: white;
            border-radius: 8px;
        }
        .table th {
            background-color: blue;
            color: yellow;
            font-weight: 500;
            vertical-align: middle;
            text-align: center;
        }
        .table th i {
            margin-right: 5px;
        }
        .table th.title {
            text-align: center;
            font-size: 1.2em;
            padding: 20px;
        }
        .table td {
            font-weight: 500;
            vertical-align: middle;
            text-align: center;
        }
        .table .btn {
            width: 100%;
        }
        .table .btn i {
            margin-right: 5px;
        }
        #boton {
          margin-top: 20px;
        }
    </style>
</head>
<body>
    <header>
        <h2 class="logo"><i class="ri-parking-box-line"></i>MiEstacionamiento</h2>
        <nav class="navigation">
            <a href="vistaCliente.php"><?php echo $nombre_usuario; ?></a>
            <a href="autosCliente.php">Mis autos</a>
            <a href="buscarEstacionamientoC.php">Buscar Estacionamiento</a>
            <button class="btnlogin-popup" onclick="redirectToMiCuenta()">Mi cuenta</button>
            <button class="btnsignup-popup" onclick="cerrarSesion()">Cerrar Sesion</button>
        </nav>
    </header>
    <section>
        <div class="table-container">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th colspan="7" class="title">Mis Autos</th>
                </tr>
                <tr>
                    <th scope="col">Tipo de vehículo <i class="ri-car-line"></i></th>
                    <th scope="col">Marca de vehículo <i class="ri-car-fill"></i></th>
                    <th scope="col">Modelo de vehículo <i class="ri-steering-2-fill"></i></th>
                    <th scope="col">Patente <i class="ri-number-plate-2-fill"></i></th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
               <?php foreach ($vehiculos as $vehiculo): ?>
                <tr>
                    <td><?php echo $vehiculo['tipo_vehiculo']; ?></td>
                    <td><?php echo $vehiculo['marca']; ?></td>
                    <td><?php echo $vehiculo['modelo']; ?></td>
                    <td><?php echo $vehiculo['patente']; ?></td>
                    <td>
                        <a class="btn btn-primary" href="editarAuto.php?id=<?php echo $vehiculo['id']; ?>">Editar</a>
                        <a class="btn btn-danger" href="eliminarAuto.php?id=<?php echo $vehiculo['id']; ?>">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>
        <div id="boton">
            <a class="btn btn-success" href="registrarAuto.php">Registrar Vehículo</a>
        </div>
        
    </section>
    
    <script>
        function redirectToMiCuenta() {
            window.location.href = "micuentaCliente.php";
        }
        function cerrarSesion(){
            alert("Se a Cerrado Sesion Exitosamente!"); window.location.href = "index.html";
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="scripts.js"></script>
</body>
</html>
