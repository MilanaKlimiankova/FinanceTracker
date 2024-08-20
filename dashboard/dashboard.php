<?php

if(session_status()!=PHP_SESSION_ACTIVE) session_start();

//получить id и login пользователя
$id = $_SESSION['id'];
$login = $_SESSION['login'];

//задать дату начала и конца периода отбора данных по умолчанию для диаграммы
$end_date = new DateTime();
$end_date_formatted = date_format($end_date,'Y-m-d');
$start_date = clone $end_date;
$start_date->modify('-1 month');
$start_date_formatted = date_format($start_date,'Y-m-d');	

//получить заданные дату начала и конца периода отбора данных для диаграммы
if (isset($_GET['end_date'])) { 
	$end_date_formatted = $_GET['end_date']; 
} 
if (isset($_GET['start_date'])) { 
	$start_date_formatted = $_GET['start_date']; 
} 

//подключение к базе данных
include '../connect/db.php';

//получить данные для диараммы
$query_diagram="SELECT name, SUM(amount) AS amount
								FROM record JOIN category ON record.categ_id = category.id
								WHERE record.user_id ='$id'
								AND record.date >= '$start_date_formatted'
								AND record.date <= '$end_date_formatted'
								GROUP BY category.name;";
$rez_diagram = mysqli_query($link, $query_diagram) or die("Ошибка " .
mysqli_error($link));

$categories = array();
$sums = array();

while ($row_diagram = mysqli_fetch_assoc($rez_diagram)){
    $categories[] = $row_diagram['name'];
    $sums[] = $row_diagram['amount'];
}

//получить список категорий
$query="SELECT *FROM category;";
$rez = mysqli_query($link, $query) or die("Ошибка " .
mysqli_error($link));
$row = mysqli_fetch_assoc($rez);

mysqli_close($link);
?>

<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="../assets/css/dashboard.css">
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<script src="diagram.js"></script>
</head>
<body>
	<header>
		<div class='name'>Finance tracker</div>
		<div class='menu'>			
			<div class = 'menu-item'>
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12,12A6,6,0,1,0,6,6,6.006,6.006,0,0,0,12,12ZM12,2A4,4,0,1,1,8,6,4,4,0,0,1,12,2Z"/><path d="M12,14a9.01,9.01,0,0,0-9,9,1,1,0,0,0,2,0,7,7,0,0,1,14,0,1,1,0,0,0,2,0A9.01,9.01,0,0,0,12,14Z"/></svg>
				<div><?=@$login;?></div>
			</div>
			<div class = 'menu-item'>
				<svg xmlns="http://www.w3.org/2000/svg" id='exit-icon' viewBox="0 0 24 24"><path d="M22.829,9.172,18.95,5.293a1,1,0,0,0-1.414,1.414l3.879,3.879a2.057,2.057,0,0,1,.3.39c-.015,0-.027-.008-.042-.008h0L5.989,11a1,1,0,0,0,0,2h0l15.678-.032c.028,0,.051-.014.078-.016a2,2,0,0,1-.334.462l-3.879,3.879a1,1,0,1,0,1.414,1.414l3.879-3.879a4,4,0,0,0,0-5.656Z"/><path d="M7,22H5a3,3,0,0,1-3-3V5A3,3,0,0,1,5,2H7A1,1,0,0,0,7,0H5A5.006,5.006,0,0,0,0,5V19a5.006,5.006,0,0,0,5,5H7a1,1,0,0,0,0-2Z"/></svg>
				<a href="../auth/auth_out.php">Выйти</a>
			</div>
		</div>
	</header>

	<main>
		<div class = 'wrap' style = "width: 48%;">
			<div class = 'title'>Диаграмма расходов</div>

			<div class="wrap">
				<?php 
				$empty_chart = true;

				if (count($categories) > 0) $empty_chart = false;

				if ($empty_chart){
					echo"<div>Пока нет статистики</div>";
				} else echo"<div>
			  		<canvas id=\"myChart\" style = \"width: 100%; max-height: 400px;\"></canvas>
				</div>";
										
				?>
					
			</div>

			<div class = 'wrap'>
					<form class ='diagram-params' method="get" action="dashboard.php">
						<label>Расходы в период с:</label>
						<input type="date" id="period-start" name="start_date" value="<?=@$start_date_formatted?>" max="<?=$end_date_formatted?>"/>
						<label>по:</label>
						<input type="date" id="period-end" name="end_date" value="<?=@$end_date_formatted?>" max="<?=$end_date_formatted?>"/>
						<br><br>
						<input type="submit" name="" value ="Обновить" class = 'button'>
					</form>
			</div>

		</div>

		<div class = 'wrap' style = "width: 48%;">
			<div class = 'title'>Добавить запись</div>

			<form method="post" action="add_record.php" class = 'add-form'>
				<div class = 'record' style ="padding: 15px 25px 15px 25px;">
					<div>
		    			<select name="categ" class="add-categ">
							    <?php
							    //подключение к базе данных
									include '../connect/db.php';

									//получить список категорий
									$query_categ="SELECT *FROM category;";
									$rez_categ = mysqli_query($link, $query_categ) or die("Ошибка " .
									mysqli_error($link));

							    while ($row_categ = mysqli_fetch_assoc($rez_categ)){
							    		if ($row_categ['id'] == '21'){
							    			echo"<option selected value=\"" . $row_categ['id'] . "\">" . $row_categ['name'] . "</option>";
							    		} else echo"<option value=\"" . $row_categ['id'] . "\">" . $row_categ['name'] . "</option>";
									};

									mysqli_close($link);
							    ?>
		  				</select>
		    			<br>
		    			<input type="date" name = 'date' value="<?=@$end_date_formatted?>" max="<?=$end_date_formatted?>" class = "add-date"/>
		    			<br>
    		  </div>

    			<div class = 'add-amount'><input type="number" name ='amount' value="0"><label>BYN</label></div>
    	</div>

    			<input type="submit" name="" value ="Подтвердить" class = 'button' style="align-self: flex-end;">
    		
    		</form>

				<div class = 'title'>Последнее</div>

			<div class = 'wrap'>
				<?php 
				if(session_status()!=PHP_SESSION_ACTIVE) session_start();

				include '../connect/db.php'; /*подключаемся к БД*/
				$query="SELECT * 
								FROM record JOIN category ON record.categ_id = category.id  
								WHERE user_id='$id' 
								ORDER BY date DESC LIMIT 3";
				$rez = mysqli_query($link, $query) or die("Ошибка " .
				mysqli_error($link));

				if($rez){
					$empty = true;

					while($row = mysqli_fetch_assoc($rez)) { 
						$empty = false;
						echo"<div class = 'record'>
										<div>
											<div>".$row['name']."</div>
											<div style = \"font-size: 16px; margin-top: 15px;\">".$row['date']."</div>
										</div>					
										<div style = \"font-weight: 600; font-size: 25px;\">".$row['amount']." BYN</div>					
								</div>";
					};

					if ($empty){
						echo"<div>Пока нет записей</div>";
					} else echo"<a href=\"records_list.php?user_id=".$_SESSION['id']."\" target=\"_blank\" class='link'>Все записи</a>";
				} 						
				?>			
			
		</div>
		
	</main>

<?php 
	echo"<script>
				drawDiagram([".implode(", ", $sums)."], ['".implode("', '", $categories)."'])
			</script>";
?>	

</html>