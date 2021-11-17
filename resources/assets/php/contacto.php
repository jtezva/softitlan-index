<?php

define("RECAPTCHA_V3_SECRET_KEY", '6LdO6vYcAAAAAMBkoJMs96byiAe4pEBwIZblEFNB');

$token = $_POST['token'];
$action = $_POST['action'];

// call curl to POST request
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('secret' => RECAPTCHA_V3_SECRET_KEY, 'response' => $token)));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
$arrResponse = json_decode($response, true);

// verificar la respuesta
if ($arrResponse["success"] == '1' && $arrResponse["action"] == $action && $arrResponse["score"] >= 0.5) {
    //envio de correo electronico 
    $Nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $Mensaje = $_POST['mensaje'];    
    
    $header = 'From: ' . $correo . "\r\n" .
    $header = "X-Mailer: PHP/" . phpversion() . "\r\n";
    $header = "Miner-Version: 1.0 \r\n" .
    $header = "Content-Type: text/plain" .
    
    $mensaje = "Este mensaje fue enviado por: " . $Nombre . "\r\n";
    $mensaje .= "Su e-mail es: " . $correo . "\r\n";
    $mensaje .= "Su telefono es: " . $telefono . "\r\n";
    $mensaje .= "Mensaje: " . $Mensaje . "\r\n";
    $mensaje .= "Enviado el " . date('d/m/Y', time());
    
    $para = "tozcuento.2829@gmail.com";
    $asunto =  $_POST['asunto'];
    
    mail($para, $asunto, utf8_decode($mensaje), $header);
    // header("Location: http://localhost:3000/index.html");
    print_r($mensaje);
    // echo '<script language="javascript">alert("Datos enviados");window.location.href="http://localhost:3000/index.html"</script>';
} else {
    echo '<script language="javascript">alert("Datos no enviados, intentelo de nuevo");window.location.href="https://softitlan.com/"</script>';
}


?>