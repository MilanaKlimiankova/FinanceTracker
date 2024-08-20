<?php
 if(session_status()!=PHP_SESSION_ACTIVE) session_start();
?>



<html>
<head>
	 <meta http-equiv="content-type" content="text/html; charset=utf-8">
	 <title>Вход Finance tracker</title>
	 <link rel="stylesheet" href="../assets/css/reg_auth.css">
</head>

<body>
	<div class = 'title'>Вход в существующий аккаунт</div>

	<form class = 'form' action="auth_in.php" method="post">
		<input name="login" id='login' class='field' placeholder="Логин">
		<div name = 'errornlogin' id = 'errornlogin' class = 'message'><?=@$e1;?></div>
		<input name="password" class='field' placeholder="Пароль">
		<div id = 'errorpassword' class = 'message'><?=@$e2;?></div>
		<input type = 'submit' value = 'Войти' class = 'button'>
	</form>

    <div class = 'nav'>
		<div>Нет аккаунта? <a href="../reg/reg.php" class = 'link'>Регистрация</a> </div>	
		<div><a href="../home.html" class = 'link'>На главную</a></div>
	</div>
</body>


</html>