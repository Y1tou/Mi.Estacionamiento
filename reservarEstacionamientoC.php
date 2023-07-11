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

  $query_vehiculos = "SELECT patente FROM mVehiculo WHERE id_cliente = :cliente_id";
  $stmt_vehiculos = $conexion->prepare($query_vehiculos);
  $stmt_vehiculos->bindParam(':cliente_id', $cliente_id);
  $stmt_vehiculos->execute();
  $vehiculos = $stmt_vehiculos->fetchAll(PDO::FETCH_ASSOC);
} else {
  $nombre_usuario = "Usuario"; 
}

$estacionamiento_id = $_POST['estacionamiento_id'];
$query_tarifa = "SELECT tarifa_minuto FROM mEstacionamientos WHERE id = :estacionamiento_id";
$stmt_tarifa = $conexion->prepare($query_tarifa);
$stmt_tarifa->bindParam(':estacionamiento_id', $estacionamiento_id);
$stmt_tarifa->execute();
$tarifa = $stmt_tarifa->fetch(PDO::FETCH_ASSOC);
$tarifa_minuto = $tarifa['tarifa_minuto'];

$_SESSION['cliente_id'] = $cliente_id;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenidos a MiEstacionamiento</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
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
            background: white;
        }
        .form-container {
            background-color: blue;
            border-radius: 8px;
            padding: 30px;
            max-width: 400px;
            margin-top: 150px;
            width: 400px;
        }
        .form-container h3 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 20px;
            text-align: center;
            color: yellow;
        }
        .form-container .form-group {
            margin-bottom: 20px;
        }
        .form-container .form-group label {
            font-weight: 500;
            color: yellow;
        }
        .form-container .form-group input {
            width: 100%;
            height: 40px;
            padding: 8px;
            font-size: 1rem;
            border: none;
            border-radius: 6px;
            background-color: rgba(255, 255, 255, 0.8);
            color: blue;
            transition: background-color 0.3s ease;
        }
        .form-container .form-group input:focus {
            background-color: rgba(255, 255, 255, 1);
            outline: none;
        }
        .form-container .form-group .input-icon {
            position: relative;
        }
        .form-container .form-group .input-icon i {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            color: blue;
        }
        .form-container .form-group .input-icon input {
            padding-right: 30px;
        }
        .form-container .form-group .form-text {
            color: blue;
            font-size: 0.9rem;
            margin-top: 5px;
        }
        .form-container .form-group .btn-submit {
            width: 100%;
            height: 40px;
            background-color: yellow;
            border: none;
            border-radius: 6px;
            font-size: 1.1rem;
            font-weight: 500;
            color: blue;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .form-container .form-group .btn-submit:hover {
            background-color: white;
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
<section>
    <div class="form-container">
            <h3>Ticket de reserva de Estacionamiento</h3>
            <form action="procesar_reserva.php" method="POST">
                <input type="hidden" name="id_cliente" value="<?php echo $cliente_id; ?>">
                <input type="hidden" name="id_estacionamiento" value="<?php echo $estacionamiento_id; ?>">
                <div class="form-group">
                    <label for="vehiculo">
                        <i class="ri-car-line"></i> Vehículo
                    </label>
                    <select class="form-select" id="vehiculo" name="vehiculo" required>
                        <?php
                        foreach ($vehiculos as $vehiculo) {
                            echo "<option value='" . $vehiculo['patente'] . "'>" . $vehiculo['patente'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tiempo_reserva">
                     <i class="ri-time-line"></i> Tiempo de reserva
                    </label>
                     <select class="form-select" id="tiempo_reserva" name="tiempo_reserva" required>
                        <?php
                        for ($i = 5; $i <= 90; $i += 5) {
                            echo "<option value='$i'>$i minutos</option>";
                        }
                        ?>
                    </select>
                    </div>

               <div class="form-group">
                    <label for="total">
                        <i class="ri-money-dollar-circle-line"></i> Total
                    </label>
                    <input type="text" id="total" name="total" readonly>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn-submit">
                        <i class="ri-check-line"></i> Reservar
                    </button>
                </div>
            </form>
        </div>
</section>
<script type="text/javascript" src="scripts.js"></script>
<script>
        document.getElementById('tiempo_reserva').addEventListener('change', function() {
            var tiempoReserva = parseInt(this.value);
            var tarifaMinuto = <?php echo $tarifa_minuto; ?>;
            var total = tiempoReserva * tarifaMinuto;
            document.getElementById('total').value = total;
        });
    </script>
    <script>
        function redirectToMiCuenta() {
            window.location.href = "micuentaCliente.php";
        }
        function cerrarSesion(){
            alert("Se a Cerrado Sesion Exitosamente!"); window.location.href = "index.html";
        }
    </script>
<script src="https://kit.fontawesome.com/b0ebb4a09c.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>
</html>
