<?php
session_start();

if (isset($_SESSION['cliente_id'])) {
  $cliente_id = $_SESSION['cliente_id'];
  $host = 'localhost';
  $db = 'cus77424_maxgalleg';
  $usuario = 'cus77424_user_rcancino';
  $contrasena_db = 'cus77424_Rcancino%21';

  $conexion = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $usuario, $contrasena_db);

  $query_cliente = "SELECT * FROM mCliente WHERE id = :cliente_id";
  $stmt_cliente = $conexion->prepare($query_cliente);
  $stmt_cliente->bindParam(':cliente_id', $cliente_id);
  $stmt_cliente->execute();
  $cliente = $stmt_cliente->fetch(PDO::FETCH_ASSOC);

  $query_cbancaria = "SELECT * FROM mCBancaria WHERE id_usuario = :cliente_id";
  $stmt_cbancaria = $conexion->prepare($query_cbancaria);
  $stmt_cbancaria->bindParam(':cliente_id', $cliente_id);
  $stmt_cbancaria->execute();
  $cbancaria = $stmt_cbancaria->fetch(PDO::FETCH_ASSOC);

  $query_movimientos = "SELECT * FROM mTicket WHERE rut_cliente = :rut_cliente";
  $stmt_movimientos = $conexion->prepare($query_movimientos);
  $stmt_movimientos->bindParam(':rut_cliente', $cliente['rut']);
  $stmt_movimientos->execute();
  $movimientos = $stmt_movimientos->fetchAll(PDO::FETCH_ASSOC);
} else {
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
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: #f2f2f2;
            padding-top: 20px; 
        }
        
        .card1{
            margin-top: 100px;
            width: 600px;
            padding: 20px;
            background-color: white;
            border-radius: 6px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px; 
        .card1-title {
            text-align: center;
            font-size: 1.8em;
            color: blue;
            font-weight: bold;
        }
        .card1-content {
            margin-top: 20px;
        }
        .card1-content p {
            margin-bottom: 10px;
        }
        .card2{
            width: 600px;
            padding: 20px;
            background-color: white;
            border-radius: 6px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px; 
            .card2-title {
            text-align: center;
            font-size: 1.8em;
            color: blue;
            font-weight: bold;
        }
        .card2-content {
            margin-top: 20px;
        }
        .card2-content p {
            margin-bottom: 10px;
        }
            
        }
        .card3{
            width: 1000px;
            padding: 20px;
            background-color: white;
            border-radius: 6px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px; 
            .card3-title {
            text-align: center;
            font-size: 1.8em;
            color: blue;
            font-weight: bold;
            
        }
        .card3-content {
            margin-top: 20px;
        }
        .card3-content p {
            margin-bottom: 10px;
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
        <div class="card1">
            <h3 class="card-title">Datos del Cliente</h3>
            <div class="card-content">
                <p><strong>Nombre:</strong> <?php echo $cliente['nombre']; ?></p>
                <p><strong>RUT:</strong> <?php echo $cliente['rut']; ?></p>
                <p><strong>Correo electrónico:</strong> <?php echo $cliente['email']; ?></p>
                <p><strong>Teléfono:</strong> <?php echo $cliente['telefono']; ?></p>
                <p><strong>Dirección:</strong> <?php echo $cliente['direccion']; ?></p>
                <p><strong>Numero de casa:</strong> <?php echo $cliente['ncasa']; ?></p>
            </div>
        </div>
        <div class="card2">
            <h3 class="card-title">Cuenta Bancaria</h3>
            <div class="card-content">
                <?php if ($cbancaria): ?>
                    <p><strong>Pais:</strong> <?php echo $cbancaria['pais']; ?></p>
                    <p><strong>Banco:</strong> <?php echo $cbancaria['banco']; ?></p>
                    <p><strong>Tipo de cuenta:</strong> <?php echo $cbancaria['tipo_cuenta']; ?></p>
                    <p><strong>Número de cuenta:</strong> <?php echo $cbancaria['numero_cuenta']; ?></p>
                    <p><strong>Fecha de Vencimiento:</strong> <?php echo $cbancaria['mes']; ?> <strong> / </strong> <?php echo $cbancaria['anio']; ?> </p>
                    <p><strong>Año:</strong> <?php echo $cbancaria['anio']; ?></p>
                <?php else: ?>
                    <p>El cliente <?php echo $cliente['nombre']; ?> no tiene datos de cuenta bancaria.</p>
                        <button class="add-account-btn btn btn-success" OnClick="agregarCuenta()">Agregar cuenta bancaria</button>
                <?php endif; ?>
            </div>
        </div>
        <div class="card3">
            <h3 class="card-title">Movimientos</h3>
            <div class="card-content">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Ubicación</th>
                            <th>Nombre Estacionamiento</th>
                            <th>Tarifa por Minuto</th>
                            <th>Nombre Cliente</th>
                            <th>RUT Cliente</th>
                            <th>Tipo de Vehículo</th>
                            <th>Marca Vehículo</th>
                            <th>Patente Vehículo</th>
                            <th>Tiempo de Reserva</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($movimientos as $movimiento): ?>
                            <tr>
                                <td><?php echo $movimiento['ubicacion']; ?></td>
                                <td><?php echo $movimiento['nombre_estacionamiento']; ?></td>
                                <td><?php echo $movimiento['tarifa_por_minuto']; ?></td>
                                <td><?php echo $movimiento['nombre_cliente']; ?></td>
                                <td><?php echo $movimiento['rut_cliente']; ?></td>
                                <td><?php echo $movimiento['tipo_vehiculo']; ?></td>
                                <td><?php echo $movimiento['marca_vehiculo']; ?></td>
                                <td><?php echo $movimiento['patente_vehiculo']; ?></td>
                                <td><?php echo $movimiento['tiempo_reserva']; ?></td>
                                <td><?php echo $movimiento['total']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </section>
    
    <script>
        function redirectToMiCuenta() {
            window.location.href = "micuentaCliente.php";
        }
        function cerrarSesion(){
            alert("Se a Cerrado Sesion Exitosamente!"); window.location.href = "index.html";
        }
        function agregarCuenta(){
            window.location.href = "agregarCuentaC.php"
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
