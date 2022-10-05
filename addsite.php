<?php session_start(); require_once "main.php"; require_once "start_mysql.php";
$url = htmlspecialchars($_POST['siteurl']);
// Удаляем протокол из адреса
$url = str_replace (['http://', 'https://'], '', $url); 
// Удаляем пробелы и слеш
$url = trim($url, ' /'); 
StartDB();
// Получение заголовка сайта
$tab = SiteTitle($url);

//Записываем заголовок в сессию
$_SESSION["site_title"] = SiteTitle($url);

$_SESSION["title"]= SiteScreenshot($url);

// Получение скриншота сайта
$shot = SiteScreenshot($url);
// Код группы Общие
$group = 1;
// Получение кода клиента
$client = $_SESSION['iduser'];

$SQL = "INSERT INTO Закладки
					(`Закладка`, `Адрес`, `Скриншот`, `Код группы`, `Код клиента`) 
			VALUES 	('$tab', '$url', '$shot', '$group', '$client')";		
	//print $SQL."<br>";
mysqli_query($db, $SQL);
EndDB();
header("Location: index.php");
