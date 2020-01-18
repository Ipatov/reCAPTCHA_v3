<!DOCTYPE html>
<html lang="ru"> 
<head>
    <meta charset="UTF-8">
    <title>Тест reCAPTCHA v3 от Google</title>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

	<!-- подключение библиотеки для работы recaptcha -->
	<script src="https://www.google.com/recaptcha/api.js?render=КЛЮЧ_САЙТА"></script>	
	
	<script>
		$(document).ready(function(){
			// при отправке формы
			$('#test_form').submit(function(event) {
				// остановка стандартной отправки данных
				event.preventDefault();
				// получение данных из полей формы
				var email = $('#email').val();
				var comment = $("#comment").val();
				// после загрузки рекапчи
				grecaptcha.ready(function() {
					// запрос к рекапче для формирования проверочного токена
					grecaptcha.execute('КЛЮЧ_САЙТА', {
						action: 'create_comment'
					}).then(function(token) {
						// добавляем в форму скрытое поле с полученым токеном
						$('#test_form').prepend('<input type="hidden" name="g-recaptcha-response" value="' + token + '">');
						// делаем отправку данных из формы
						$.post("form.php",{
							email: email, 
							comment: comment, 
							token: token
						}, function(result) {	
							console.log(result) 
							if(result.success) {
								alert('Комментарий успешно добавлен!')
							} else {
								alert('Попался спамер!')
							}
						});
					});;
				});
			});
		});
  </script>

</head>
 
<body>
	<h1>Добавление комментария</h1>
    <form id="test_form" action="form.php" method="post" >
		<input type="email" name="email" placeholder="Введите ваш email" size="40"><br><br>
		<textarea name="comment" ></textarea><br><br>
		<input type="submit" name="submit" value="Отправить"><br><br>
    </form>
</body>
 
</html>