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
    $url = "https://cuponealo.com.mx:8081/notifier/sendMail";
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $asunto =  $_POST['asunto'];
    $mensaje = $_POST['mensaje'];
    // Los datos de formulario
    $datos = [
        "nombre" => $nombre,
        "correo" => $correo,
        "telefono" => $telefono,
        "asunto" => $asunto,
        "mensaje" => $asunto
    ];
    // Crear opciones de la petición HTTP
    $opciones = array(
        "http" => array(
            "header" => "Content-type: application/x-www-form-urlencoded\r\n",
            "method" => "POST",
            "content" => http_build_query($datos), // Agregar el contenido definido antes
        ),
    );
    //Preparar petición
    $contexto = stream_context_create($opciones);
    //Hacer peticion
    $resultado = file_get_contents($url, false, $contexto);
    if ($resultado === false) {
        echo "Error haciendo petición";
        //echo '<script language="javascript">alert("Datos NO enviados");window.location.href="https://softitlan.com/"</script>';
        exit;
    } else {
        echo '<script language="javascript">alert("Datos enviados");window.location.href="https://softitlan.com/"</script>';
    }
    //imprimir el resultado solo para las pruebas
    var_dump($resultado);
} else {
    //Error en caso de que el captcha no pase
    echo '<script language="javascript">alert("Captcha Invalido, intentelo de nuevo");window.location.href="https://softitlan.com/"</script>';
}
?>