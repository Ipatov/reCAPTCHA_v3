<?php
	// получение данных с формы
	$email = $_POST["email"];
	$comment = $_POST["comment"];
	// токен	
	$token = $_POST["token"];
	
	// секретный ключ
	$secretKey = "СЕКРЕТНЫЙ_КЛЮЧ";

	// отправка токена и ключа для проверки
	$url = 'https://www.google.com/recaptcha/api/siteverify';
	$data = array(
		'secret' => $secretKey, 
		'response' => $token
	);
	$options = array(
		'http' => array(
		  'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
		  'method'  => 'POST',
		  'content' => http_build_query($data)
		)
	);
	$context  = stream_context_create($options);
	$response = file_get_contents($url, false, $context);
	// разбираем ответ рекапчи
	$responseKeys = json_decode($response,true);
	
	// заголовки для ответа в формате json
	header('Content-type: application/json');
	// проверка ответа recaptcha и ответ на фронт
	if($responseKeys["success"]) {
		// если все хорошо
		echo json_encode(array('success' => 'true'));
	} else {
		// что-то пошло не так, попался спамер
		echo json_encode(array('success' => 'false'));
	}
  