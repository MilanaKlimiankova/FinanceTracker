<?php
if(session_status()!=PHP_SESSION_ACTIVE) session_start();

//получить id и login пользователя
$id = $_SESSION['id'];

//подключение к базе данных
include '../connect/db.php';

$amount = $_POST['amount'];
$categ = $_POST['categ'];	
$date = $_POST['date'];

$query_add="INSERT INTO `record` (`user_id`,`categ_id`, `amount`, `date`, `note`) 
					VALUES ('$id','$categ', '$amount', '$date', NULL);";
$result_add=mysqli_query($link, $query_add) or die("Ошибка " .
		mysqli_error($link));

if ($result_add){
				/*выводим уведомление об успехе операции и
				перезагружаем страничку*/
				//echo "<script language='Javascript' type='text/javascript'> alert('Запись добавлена!')</script>";
				echo "<script language='Javascript'
				type='text/javascript'>
				 function reload(){
				 	top.location = \"dashboard.php\"};
				 setTimeout('reload()', 0)
				 </script>";
		} else {
				 echo "<script language='Javascript'
				type='text/javascript'>
				 alert ('Ошибка!');
				</script>";
			}

mysqli_close($link);
?>
