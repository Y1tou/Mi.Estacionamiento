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


$_SESSION['arrendatario_id'] = $arrendatario_id;
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
section{
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 150px;
}
.card {
            width: 400px;
            padding: 20px;
            background-color: white;
            border-radius: 6px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            text-align: center;
            font-size: 1.8em;
            color: blue;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-control {
            width: 100%;
            height: 40px;
            padding: 10px;
            padding-left: 30px;
            font-size: 1em;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .form-control:focus {
            border-color: blue;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 0, 255, 0.3);
        }

        .input-icon {
            position: relative;
        }

        .input-icon i {
            position: absolute;
            top: 12px;
            left: 10px;
            color: #888;
        }

        .btn-submit {
            width: 100%;
            height: 40px;
            background-color: green;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .btn-submit:hover {
            background-color: darkgreen;
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
        <div class="card">
        <h3 class="card-title">Ingresar datos de cuenta bancaria</h3>
        <form action="agregarCuentaBancariaMethod.php" method="POST">
            <input type="hidden" name="cliente_id" value="<?php echo $cliente_id; ?>">

            <div class="form-group">
                <label for="pais"><i class="fas fa-globe"></i> País</label>
                <div class="input-icon">
                    <input type="text" class="form-control" id="pais" name="pais" required>
                    <i class="fas fa-flag"></i>
                </div>
            </div>
            <div class="form-group">
                <label for="banco"><i class="fas fa-building"></i> Banco</label>
                <div class="input-icon">
                    <input type="text" class="form-control" id="banco" name="banco" required>
                    <i class="fas fa-university"></i>
                </div>
            </div>
            <div class="form-group">
                <label for="tipo_cuenta"><i class="fas fa-credit-card"></i> Tipo de cuenta</label>
                <div class="input-icon">
                    <input type="text" class="form-control" id="tipo_cuenta" name="tipo_cuenta" required>
                    <i class="fas fa-file-alt"></i>
                </div>
            </div>
            <div class="form-group">
                <label for="numero_cuenta"><i class="fas fa-barcode"></i> Número de cuenta</label>
                <div class="input-icon">
                    <input type="text" class="form-control" id="numero_cuenta" name="numero_cuenta" required>
                    <i class="fas fa-hashtag"></i>
                </div>
            </div>
             <div class="form-group">
                <label for="mes"><i class="fas fa-calendar"></i> Mes</label>
                <div class="input-icon">
                    <select class="form-control" id="mes" name="mes" required>
                        <option value="" selected disabled>Seleccionar mes</option>
                        <option value="01">01</option>
                        <option value="02">02</option>
                        <option value="03">03</option>
                        <option value="04">04</option>
                        <option value="05">05</option>
                        <option value="06">06</option>
                        <option value="07">07</option>
                        <option value="08">08</option>
                        <option value="09">09</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </div>
            <div class="form-group">
                <label for="anio"><i class="fas fa-calendar"></i> Año</label>
                <div class="input-icon">
                    <select class="form-control" id="anio" name="anio" required>
                        <option value="" selected disabled>Selecionar Año</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                        <option value="2027">2027</option>
                        <option value="2028">2028</option>
                        <option value="2029">2029</option>
                        
                    </select>
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </div>
            <button type="submit" class="btn btn-submit">Agregar cuenta bancaria</button>
        </form>
    
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
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/b0ebb4a09c.js" crossorigin="anonymous"></script>

<script type="text/javascript" src="scripts.js"></script>
</body>
</html>
