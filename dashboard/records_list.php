<?php
if(session_status()!=PHP_SESSION_ACTIVE) session_start();

$id = $_GET['user_id'];

include '../connect/db.php';
$query="SELECT * FROM user WHERE id='$id'";
$rez = mysqli_query($link, $query) or die("Ошибка " .
mysqli_error($link));
$row = mysqli_fetch_assoc($rez);

mysqli_close($link);

?>

<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="../assets/css/dashboard.css">
	<script src="diagram.js"></script>
</head>
<body>
	<header>
		<div class='name'>Finance tracker</div>
		<div class='menu'>			
			<div class = 'menu-item'>
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12,12A6,6,0,1,0,6,6,6.006,6.006,0,0,0,12,12ZM12,2A4,4,0,1,1,8,6,4,4,0,0,1,12,2Z"/><path d="M12,14a9.01,9.01,0,0,0-9,9,1,1,0,0,0,2,0,7,7,0,0,1,14,0,1,1,0,0,0,2,0A9.01,9.01,0,0,0,12,14Z"/></svg>
				<div><?=@$row['login'];?></div>
			</div>
			<div class = 'menu-item'>
				<svg xmlns="http://www.w3.org/2000/svg" id='exit-icon' viewBox="0 0 24 24"><path d="M22.829,9.172,18.95,5.293a1,1,0,0,0-1.414,1.414l3.879,3.879a2.057,2.057,0,0,1,.3.39c-.015,0-.027-.008-.042-.008h0L5.989,11a1,1,0,0,0,0,2h0l15.678-.032c.028,0,.051-.014.078-.016a2,2,0,0,1-.334.462l-3.879,3.879a1,1,0,1,0,1.414,1.414l3.879-3.879a4,4,0,0,0,0-5.656Z"/><path d="M7,22H5a3,3,0,0,1-3-3V5A3,3,0,0,1,5,2H7A1,1,0,0,0,7,0H5A5.006,5.006,0,0,0,0,5V19a5.006,5.006,0,0,0,5,5H7a1,1,0,0,0,0-2Z"/></svg>
				<a href="../auth/auth_out.php">Выйти</a>
			</div>
		</div>
	</header>

	<main>
		<div class = 'wrap' style = "width: 100%;">
			<div class = 'title' style = "margin-bottom: 20px;">Список расходов</div>

			<div class = 'wrap'>
				<?php 
							if(session_status()!=PHP_SESSION_ACTIVE) session_start();

							include '../connect/db.php'; /*подключаемся к БД*/
							$query="SELECT * 
											FROM record JOIN category ON record.categ_id = category.id  
											WHERE user_id='$id' 
											ORDER BY date DESC";
							$rez = mysqli_query($link, $query) or die("Ошибка " .
							mysqli_error($link));

							while($row = mysqli_fetch_assoc($rez)) { 
								echo"<div class = 'record'>
													<div>
														<div>".$row['name']."</div>
														<div style = \"font-size: 16px; margin-top: 15px;\">".$row['date']."</div>
													</div>					
													<div style = \"font-weight: 600; font-size: 25px; align-self: center;\">".$row['amount']." BYN</div>					
											</div>";
							};

				?>			
		</div>
		
	</main>

</body>

</html>