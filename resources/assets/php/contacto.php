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
    $body = new StdClass;
    $body->nombre = $_POST["nombre"];
    $body->correo = $_POST["correo"];
    $body->telefono = $_POST["telefono"];
    $body->asunto = $_POST["asunto"];
    $body->mensaje = $_POST["mensaje"];
    $jsonBody = json_encode($body);

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    //PARA PODER HACER PRUEBAS LOCALES
    $config['useragent'] = 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0';
    $headers = array(
        "Content-Type: application/json",
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    //PARA PODER HACER PRUEBAS LOCAL
    curl_setopt($curl, CURLOPT_USERAGENT, $config['useragent']);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonBody);
    //for debug only!, deshabilita la verificacion SSL del servidor
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $resp = curl_exec($curl);
    curl_close($curl);
    $arrRes = json_decode($resp, true);
    if ($arrRes["message"] == 'Correo enviado correctamente') {
        echo '<script language="javascript">alert("Datos Enviados");window.location.href="https://softitlan.com/"</script>';
    } else {
        echo '<script language="javascript">alert("Datos NO Enviados");window.location.href="https://softitlan.com/"</script>';
    }
} else {
    //Error en caso de que el captcha no pase
    echo '<script language="javascript">alert("Captcha Invalido, intentelo de nuevo");window.location.href="https://softitlan.com/"</script>';
}
?>