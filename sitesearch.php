<?php session_start(); require_once "main.php"; require_once "start_mysql.php";
$url = htmlspecialchars($_POST['siteurl']);
// Удаляем протокол из адреса
//$url = str_replace (['http://', 'https://'], '', $url);
// Удаляем пробелы и слеш
$url = trim($url, ' /');
StartDB();
// Получение заголовка сайта
$tab = SiteTitle($url);

//Записываем заголовок в сессию
$_SESSION["site_title"] = SiteTitle($url);

//$_SESSION["title"]= SiteScreenshot($url);

// Получение скриншота сайта
//$shot = SiteScreenshot($url);
// Код группы Общие
$group = 1;
// Получение кода клиента
$client = $_SESSION['iduser'];

//$SQL = "INSERT INTO Закладки
//					(`Закладка`, `Адрес`, `Скриншот`, `Код группы`, `Код клиента`)
//			VALUES 	('$tab', '$url', '$shot', '$group', '$client')";

////$SQL = "SELECT * FROM Закладки WHERE `Код клиента` = ".$_SESSION['iduser'];

//$SQL = "SELECT * FROM `Закладки` WHERE (`Код клиента` = `".$_SESSION['iduser']."`" AND `Закладка` LIKE `".$_POST['siteurl']."`")";

//$SQL = "SELECT `Логин` FROM `Клиенты` WHERE `Логин` LIKE '".$_POST['user_login']. "'";



global $db;
////$SQL = "SELECT * FROM Закладки WHERE `Код клиента` = ".$_SESSION['iduser'];
//

$SQL = "SELECT * FROM `Закладки` WHERE (`Код клиента` = `".$_SESSION['iduser']."`" AND `Закладка` LIKE '".$_POST['siteurl']."'")";

//print $SQL;
if ($result = mysqli_query($db, $SQL))
{
    //printf ("Число строк в запросе: %d<br>", mysqli_num_rows($result));
    // Выборка результатов запроса
    print "<div class='flexshot'>";
    while( $row = mysqli_fetch_assoc($result) )
    {
        $url = 'http://'.$row['Адрес'];
        //выводим заголовок с картинкой
        //print "<h3>".$_SESSION["site_title"]."</h3>";
        //print "<div class='shot'><h3>".$_SESSION["site_title"]."</h3><br></div>";
        //print "<div class='shot'><a href='".$url."'><img src='".$row['Скриншот']."'></a></div>";
        //print "<div class='shot'><h3>".$_SESSION["site_title"]."</h3><a href='".$url."'><img src='".$row['Скриншот']."'></a></div>";
        print "<div class='shot'><h3>".$row['Закладка']."</h3><a href='".$url."'><img src='".$row['Скриншот']."'></a></div>";
    }
    mysqli_free_result($result);
    print "</div>";
}
else
{
    printf("Ошибка в запросе: %s\n", mysqli_error($db));
}


//print $SQL."<br>";
//mysqli_query($db, $SQL);

EndDB();
header("Location: index.php");