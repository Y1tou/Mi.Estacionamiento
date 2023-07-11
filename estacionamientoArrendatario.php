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
    <title>Bienvenidos a MiEstacionamiento</title>
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
        .table {
            max-width: 100%;
            margin-top: 150px;
            background-color: #fff;
            color: #000;

        }
        .table th, .table td {
            vertical-align: middle;
        }
        .btn-habilitar {
            background-color: green;
            color: #fff;
        }
        .btn-editar {
            background-color: yellow;
            color: #000;
        }
        .btn-deshabilitar {
            background-color: red;
            color: #fff;
        }
        .btn-agregar-estacionamiento {
            background-color: blue;
            color: #fff;
        }
        .btn-habilitar:hover {
        background-color: #4CAF50; 
        color: #fff;
    }
    th {
        background-color: black !important;
        color: white;
        text-align: center;
    }

    .btn-editar:hover {
        background-color: #FFEB3B; 
        color: #000;
    }

    .btn-deshabilitar:hover {
        background-color: #EF5350; 
        color: #fff;
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
        <div class="container">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Ubicaci贸n <i class="ri-map-pin-line"></i></th>
                        <th>Nombre <i class="ri-file-text-line"></i></th>
                        <th>Espacios Disponibles <i class="ri-stack-line"></i></th>
                        <th>Hora Inicio <i class="ri-time-line"></i></th>
                        <th>Hora Termino <i class="ri-time-line"></i></th>
                        <th>Tarifa X min <i class="ri-money-dollar-circle-line"></i></th>
                        <th>Disponible</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                 <?php foreach ($estacionamientos as $estacionamiento) : ?>
            <tr>
              <td><?php echo $estacionamiento['ubicacion']; ?></td>
              <td><?php echo $estacionamiento['nombre']; ?></td>
              <td><?php echo $estacionamiento['espacios_disponibles']; ?></td>
              <td><?php echo $estacionamiento['hora_inicio']; ?></td>
              <td><?php echo $estacionamiento['hora_termino']; ?></td>
              <td><?php echo $estacionamiento['tarifa_minuto']; ?></td>
              <td><?php echo $estacionamiento['disponible']; ?></td>
              <td>
                <form method="POST" action="estacionamientoArrendatario.php">
                  <?php if ($estacionamiento['disponible'] == 'si') : ?>
                    <button class="btn btn-habilitar" disabled>Habilitar</button>
                  <?php else : ?>
                    <button class="btn btn-habilitar" name="habilitar" value="<?php echo $estacionamiento['id']; ?>">Habilitar</button>
                  <?php endif; ?>
                  <?php if ($estacionamiento['disponible'] == 'no') : ?>
                    <button class="btn btn-deshabilitar" disabled>Deshabilitar</button>
                  <?php else : ?>
                    <button class="btn btn-deshabilitar" name="deshabilitar" value="<?php echo $estacionamiento['id']; ?>">Deshabilitar</button>
                  <?php endif; ?>
                  
                </form>
                <form action="editarEstacionamiento.php" method="POST">
                <input type="hidden" name="estacionamiento_id" value="<?php echo $estacionamiento['id']; ?>">
                <button type="submit" class="btn btn-editar">Editar</button>
            </form>
              </td>
            </tr>
          <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="text-center">
            <button class="btn btn-primary btn-agregar-estacionamiento" onclick="redirectToAgregarEstacionamiento()">Agregar Estacionamiento</button>
        </div>

    </section>
    
<script type="text/javascript" src="scripts.js"></script>
<script>
    function redirectToMiCuenta() {
        window.location.href = "micuentaArrendatario.php";
    }
    
    function redirectToAgregarEstacionamiento() {
        window.location.href = "agregarEstacionamiento.php";
    }
    
    function cerrarSesion(){
        alert("Se a Cerrado Sesion Exitosamente!"); window.location.href = "index.html";
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
