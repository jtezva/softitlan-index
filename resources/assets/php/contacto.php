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
    //Aqui va todo lo chido cuando si vale al captcha

    
	
	$url = "https://cuponealo.com.mx:8081/notifier/sendMail";
	$body = new StdClass;
	$body -> nombre = $_POST["nombre"];
	$body -> correo = $_POST["correo"];
	$body -> telefono = $_POST["telefono"];
	$body -> asunto = $_POST["asunto"];
	$body -> mensaje = $_POST["mensaje"];

    $jsonBody = json_encode($body);
	echo $jsonBody;
    
	
    $ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://cuponealo.com.mx:8081/notifier/sendMail");
	curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonBody);
    //obtenemos la respuesta
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($ch);
	curl_close($ch);
    if(!$response) {
        
        //aqui va el error en caso de que no se manden 
		echo '<script language="javascript">alert("Datos NO enviados")</script>';
    }else{
        return $response;
		echo '<script language="javascript">alert("Datos enviados");window.location.href="http://localhost:3000/index.html"</script>';
    }


} else {
    //Error en caso de que el captcha no pase
    echo '<script language="javascript">alert("captcha invalido, intentelo de nuevo");window.location.href="https://softitlan.com/"</script>';
}



/*

	//Metodo 1
	
	
	//datos a enviar
    $data = "un array o como? aqui no se como mandarlo";
    //url contra la que atacamos
    $ch = curl_init("https://cuponealo.com.mx:8081/notifier/sendMail");
    //a true, obtendremos una respuesta de la url, en otro caso, 
    //true si es correcto, false si no lo es
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //establecemos el verbo http que queremos utilizar para la petición
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    //enviamos el array data
    curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
    //obtenemos la respuesta
    $response = curl_exec($chh);
    // Se cierra el recurso CURL y se liberan los recursos del sistema
    curl_close($ch);
    if(!$response) {
        return false;
        //aqui va el error en caso de que no se manden 
    }else{
        return $response;
    }




	//metodo 2

	$url = "https://cuponealo.com.mx:8081/notifier/sendMail";
	$body = new StdClass;
	$body -> nombre = $_POST["nombre"];
	$body -> correo = $_POST["correo"];
	$body -> telefono = $_POST["telefono"];
	$body -> asunto = $_POST["asunto"];
	$body -> mensaje = $_POST["mensaje"];

    $jsonBody = json_encode($body);
	echo $jsonBody;
	

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonBody);
	$result = curl_exec($chh);

	echo json_decode($result);

	print_r($result);
	curl_close($ch);





*/



/*

esto va dentro del if segun toscuento
//recuperando los datos
    
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $mensaje = $_POST['mensaje'];    
    $asunto =  $_POST['asunto']; 

$header = 'From: ' . $correo . "\r\n" .
    $header = "X-Mailer: PHP/" . phpversion() . "\r\n";
    $header = "Miner-Version: 1.0 \r\n" .
    $header = "Content-Type: text/plain" .
    
    $mensaje = "Este mensaje fue enviado por: " . $Nombre . "\r\n";
    $mensaje .= "Su e-mail es: " . $correo . "\r\n";
    $mensaje .= "Su telefono es: " . $telefono . "\r\n";
    $mensaje .= "Mensaje: " . $Mensaje . "\r\n";
    $mensaje .= "Enviado el " . date('d/m/Y', time());
*/
?>