<?php
if(session_status()!=PHP_SESSION_ACTIVE) session_start();


if (isset($_POST['login'])) { $login = $_POST['login']; if ($login ==
'') { unset($login);} } /*заносим введенный пользователем логин в
переменную $login, если он пустой, то уничтожаем переменную*/
if (isset($_POST['password'])) { $password=$_POST['password']; if
($password =='') { unset($password);} }/*заносим введенный
пользователем пароль в переменную $password, если он пустой, то
уничтожаем переменную*/
if (isset($_POST['password2'])) { $password2=$_POST['password2']; if
($password2 =='') { unset($password2);} }
if (isset($_POST['email'])) { $email=$_POST['email']; if ($email =='')
{ unset($email);} }


if(isset($_POST["go"])):

	 $e1=null;
	 $login=trim($_POST["login"]);
	 $login=strip_tags($login);
	 $login=stripslashes($login);
	 if(strlen($login)=="0"):
	 	$e1.="Заполните поле 'Логин'<br>";
	 endif;

	include '../connect/db.php'; /*подключаемся к БД*/
	$query="SELECT id FROM user WHERE login='$login'";
	$result = mysqli_query($link, $query) or die("Ошибка выполнения
	запроса" . mysqli_error($link));
	if ($result){
	 	 $row = mysqli_fetch_row($result);
	 	 if (!empty($row[0])) $e1.="Данный логин занят"; /*проверка
	 	на существование в БД такого же логина*/
	}
	

	 $e2=null;
	 $email=trim($_POST["email"]);
	 $email=strip_tags($email);
	 $email=htmlspecialchars($email,ENT_QUOTES);
	 $email=stripslashes($email);
	  if(strlen($email)=="0"){
	  	$e2.="Заполните поле 'E-mail'<br>";
	  } else if (!preg_match('/^[a-z\.\-]{3,}@\w((\.\w)*\w+)*\.\w{2,3}$/i',$email)){
	 $e2.="Введённый текст не соответствует формату эл. почты<br>";
	 }


	 $e3=null;
	 $password=trim($_POST["password"]);
	 $password=strip_tags($password);
	 $password=htmlspecialchars($password,ENT_QUOTES);
	 $password=stripslashes($password);
	  if(strlen($password)=="0"){
	 	$e3.="Заполните поле 'Пароль'<br>";
	 } else if (!preg_match('/^\w{8,}$/',$password)){
	 $e3.="Пароль должен содержать не менее 8 символов<br>";
	 }

	 $e4=null;
	 $password2=trim($_POST["password2"]);
	 $password2=strip_tags($password2);
	 $password2=htmlspecialchars($password2,ENT_QUOTES);
	 $password2=stripslashes($password2);
	 if(strlen($password2)=="0"){
	 	$e4.="Заполните поле 'Подтверждение пароля'<br>";
	 } else if ($password!=$password2){
	 	$e4.="Пароли не совпадают<br>";
	 }
	 


	 $eEn=$e1.$e2.$e3.$e4;
	 if($eEn==""):
		 $salt = mt_rand(100, 999);
		 $tm = date("Y-m-d H:i:s",time());
		 $password = md5(md5($password).$salt);
		 $query="INSERT INTO user (login, email, password, salt) VALUES
		('$login','$email','$password','$salt')";
		$result=mysqli_query($link, $query) or die("Ошибка " .
		mysqli_error($link));

		if ($result) /*пишем данные в БД и авторизовываем
		пользователя*/
		{
			 $query="SELECT * FROM user WHERE login='$login'";
			 $rez = mysqli_query($link, $query);
			 if ($rez)
			 {
				$row = mysqli_fetch_assoc($rez);
				$_SESSION['id'] = $row['id'];
				$_SESSION['login'] = $row['login'];
					$_SESSION['email']=$row['email'];
				mysqli_close($link);
				/*выводим уведомление об успехе операции и
				перезагружаем страничку*/
				echo "<script language='Javascript' type='text/javascript'> alert('Вы успешно зарегистрировались и авторизировались! Спасибо!')</script>";
				 echo "<script language='Javascript'
					type='text/javascript'>
					 function reload(){
					 	top.location = \"../dashboard/dashboard.php\"};
					 setTimeout('reload()', 0)
					 </script>";
			} else {
				 echo "<script language='Javascript'
				type='text/javascript'>
				 alert ('Ваши данные не были снесены в БД!');
				</script>";
}
}
endif;
endif;

?>

<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="../assets/css/reg_auth.css">
	<title>Регистрация в Finance tracker</title>
</head>

<body>
	<div class = 'title'>Регистрация нового аккаунта</div>

	<form class = 'form' method="post" action="reg.php">
		<input name = 'login' class='field' placeholder="Логин" value="<?=@$login;?>">
		<div name = 'errornlogin' class = 'message'><?=@$e1;?></div>
		<input name = 'email' class='field' placeholder="E-mail" value="<?=@$email;?>">
		<div id = 'erroremail' class = 'message'><?=@$e2;?></div>
		<input name = 'password' class='field' type='password' placeholder="Пароль" value="<?=@$password;?>">
		<div id = 'errorpassword' class = 'message'><?=@$e3;?></div>
		<input name = 'password2' class='field' placeholder="Повторите пароль"  type='password'value="<?=@$password2;?>">
		<div id = 'errorpassword2' class = 'message'><?=@$e4;?></div>
		<p><input type="hidden" name="go" value="5"></p>
		
		<input type = 'submit' value = 'Регистрация' class = 'button'>
	</form>

	<div class = 'nav'>
		<div>Уже есть аккаунт? <a href="../auth/auth.php" class = 'link'>Войти</a> </div>	
		<div><a href="../home.html" class = 'link'>На главную</a></div>
	</div>
</body>
</html>