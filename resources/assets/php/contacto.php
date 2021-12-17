<?php
//librerias
require 'PHPMailer/PHPMailerAutoload.php';
 
//Create a new PHPMailer instance
$mail = new PHPMailer();
$mail->IsSMTP();

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
//Configuracion servidor mail
$mail->From = "barrales.josue.1i@gmail.com"; //remitente
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'tls'; //seguridad
$mail->Host = "smtp.gmail.com"; // servidor smtp
$mail->Port = 587; //puerto
$mail->Username ='barrales.josue.1i@gmail.com'; //nombre usuario
$mail->Password = 'josuebg.'; //contraseña
$mail->FromName = 'SoftitlanMx';
//Agregar destinatario
$mail->AddAddress($_POST["correo"]);
$mail->Subject = $_POST["asunto"];
$mail->Body = 'Nombre: '+$_POST['nombre']+'\nTelefono: '+$_POST["telefono"]+ '\nMensaje: '+$_POST["mensaje"];
 
//Avisar si fue enviado o no y dirigir al index
if ($mail->Send()) {
    echo '<script language="javascript">alert("Datos Enviados");window.location.href="https://softitlan.com/"</script>';
} else {
    echo '<script language="javascript">alert("Datos NO Enviados");window.location.href="https://softitlan.com/"</script>';
}
} else {
    //Error en caso de que el captcha no pase
    echo '<script language="javascript">alert("Captcha Invalido, intentelo de nuevo");window.location.href="https://softitlan.com/"</script>';
}
?>