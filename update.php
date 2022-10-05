<?php require_once "start_mysql.php";
StartDB();
	$id = $_POST['id'];
	$tab  = htmlspecialchars($_POST['tab']);
	$siteurl  = htmlspecialchars($_POST['siteurl']);
	$SQL = "UPDATE Закладки SET `Закладка`='$tab', `Адрес`='$siteurl' WHERE `Код закладки`='$id'";

	if (!$result = mysqli_query($db, $SQL)) 
	{
		printf("Ошибка в запросе: %s\n", mysqli_error($db));
	}
EndDB();
header("Location: edit_table.php");	
