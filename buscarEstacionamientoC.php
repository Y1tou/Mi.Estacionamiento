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
    }
    .card-title {
        text-align: center;
        font-size: 1.8em;
        color: blue;
        font-weight: bold;
    }
    .card-content {
        margin-top: 20px;
    }
    .card-content p {
        margin-bottom: 10px;
    }
    .table {
        width: 100%;
        margin-bottom: 1rem;
        color: #212529;
        background-color: transparent;
    }
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0, 0, 0, 0.05);
    }
    .table td, .table th {
        padding: 0.75rem;
        vertical-align: top;
        border-top: 1px solid #dee2e6;
    }
    .table thead th {
        vertical-align: bottom;
        border-bottom: 2px solid #dee2e6;
    }
    .table tbody+tbody {
        border-top: 2px solid #dee2e6;
    }
    .btn {
        display: inline-block;
        font-weight: 400;
        color: #212529;
        text-align: center;
        vertical-align: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        background-color: transparent;
        border: 1px solid transparent;
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        line-height: 1.5;
        border-radius: 0.25rem;
        transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    .btn-success {
        color: #fff;
        background-color: #28a745;
        border-color: #28a745;
    }
    .btn-success:hover {
        color: #fff;
        background-color: #218838;
        border-color: #1e7e34;
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
        <div class="table-container">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th colspan="7" class="title">Estacionamientos disponibles</th>
                    </tr>
                    <tr>
                        <th scope="col"><i class="ri-location-line"></i> Ubicaci贸n</th>
                        <th scope="col"><i class="ri-store-3-line"></i> Nombre</th>
                        <th scope="col"><i class="ri-space-line"></i> Espacios Disponibles</th>
                        <th scope="col"><i class="ri-time-line"></i> Hora de Inicio</th>
                        <th scope="col"><i class="ri-time-line"></i> Hora de Cierre</th>
                        <th scope="col"><i class="ri-currency-line"></i> Tarifa x Minuto</th>
                        <th scope="col"><i class="ri-calendar-check-line"></i> Reservar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $host = 'localhost';
                    $db = 'cus77424_maxgalleg';
                    $usuario = 'cus77424_user_rcancino';
                    $contrasena_db = 'cus77424_Rcancino%21';

                    try {
                        $conexion = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $usuario, $contrasena_db);
                        $query = "SELECT * FROM mEstacionamientos WHERE espacios_disponibles > 0 AND disponible = 'si'";
                        $stmt = $conexion->prepare($query);
                        $stmt->execute();
                        $estacionamientos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($estacionamientos as $estacionamiento) {
                            echo "<tr>";
                            echo "<td>" . $estacionamiento['ubicacion'] . "</td>";
                            echo "<td>" . $estacionamiento['nombre'] . "</td>";
                            echo "<td>" . $estacionamiento['espacios_disponibles'] . "</td>";
                            echo "<td>" . $estacionamiento['hora_inicio'] . "</td>";
                            echo "<td>" . $estacionamiento['hora_termino'] . "</td>";
                            echo "<td>" . $estacionamiento['tarifa_minuto'] . "</td>";
                            echo "<td>";
                            echo "<form action='reservarEstacionamientoC.php' method='POST'>";
                            echo "<input type='hidden' name='estacionamiento_id' value='" . $estacionamiento['id'] . "'>";
                            echo "<button type='submit' class='btn btn-success' value='Reservar'><i class='ri-calendar-check-line'></i> Reservar</button>";
                            echo "</form>";
                            echo "</td>";
                            echo "</tr>";
}

                        
                    } catch (PDOException $e) {
                        echo "<tr><td colspan='7'>Error al obtener los estacionamientos disponibles.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
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
    <script src="https://kit.fontawesome.com/b0ebb4a09c.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> 
<script type="text/javascript" src="scripts.js"></script>
</body>
</html>
