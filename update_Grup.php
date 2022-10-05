<?php require_once "start_mysql.php";
StartDB();
$id = $_POST['id'];
$tab  = htmlspecialchars($_POST['tab']);
$client  = htmlspecialchars($_POST['client']);
//$SQL = "UPDATE Закладки SET `Закладка`='$tab', `Адрес`='$siteurl' WHERE `Код закладки`='$id'";
$SQL = "UPDATE Группы SET `Группа`='$tab', `Код клиента`='$client' WHERE `Код группы`='$id'";
//$SQL = "UPDATE Группы SET `Группа`='$tab' WHERE `Код группы`='$id'";

if (!$result = mysqli_query($db, $SQL))
{
    printf("Ошибка в запросе: %s\n", mysqli_error($db));
}
EndDB();
//header("Location: edit_table.php");
header("Location: edit_group.php");
