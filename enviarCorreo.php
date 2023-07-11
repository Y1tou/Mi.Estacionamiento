<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nombre = $_POST["nombre"];
  $telefono = $_POST["telefono"];
  $correo = $_POST["correo"];
  $mensaje = $_POST["mensaje"];
  $destinatario = "matias.17t@gmail.com";
  $cuerpoCorreo = "Nombre: " . $nombre . "\n";
  $cuerpoCorreo .= "Teléfono: " . $telefono . "\n";
  $cuerpoCorreo .= "Correo electrónico: " . $correo . "\n";
  $cuerpoCorreo .= "Mensaje: " . $mensaje . "\n";
  $enviado = mail($destinatario, "Mensaje de contacto desde el formulario", $cuerpoCorreo);
  if ($enviado) {
    echo "¡Gracias! Tu mensaje ha sido enviado.";
  } else {
    echo "Lo siento, ha ocurrido un error al enviar el mensaje.";
  }
}
?>
