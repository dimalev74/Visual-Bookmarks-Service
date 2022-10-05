<?php
$APIkey = '457ab4'; // Введите сюда API key с сайта https://www.screenshotmachine.com/
function InitDB()
{
	global $db;

	if (mysqli_query($db, "DROP TABLE IF EXISTS Закладки;") === TRUE)
	{
		print "Таблица Закладки удалена<br>";
	}
	else
	{
		printf("Ошибка: %s\n", mysqli_error($db));
	}
	
	if (mysqli_query($db, "DROP TABLE IF EXISTS Группы;")  === TRUE)
	{
		print "Таблица Группы удалена<br>";
	}
	else
	{
		printf("Ошибка: %s\n", mysqli_error($db));
	}
	
	
	$SQL = "CREATE TABLE Закладки ( 
	`Код закладки` INT NOT NULL  AUTO_INCREMENT PRIMARY KEY, 
	`Закладка` VARCHAR(255) NOT NULL, 
	`Адрес` VARCHAR(2048) NOT NULL, 
	`Скриншот` VARCHAR(255) DEFAULT NULL,
	`Код клиента` INT NOT NULL,
	`Код группы` INT NOT NULL
	);";

	if (mysqli_query($db, $SQL) === TRUE)
	{
		print "Таблица Закладки создана<br>";
	}
	else
	{
		printf("Ошибка: %s\n", mysqli_error($db));
	}
	
	$SQL = "CREATE TABLE Группы ( 
	`Код группы` INT NOT NULL  AUTO_INCREMENT PRIMARY KEY, 
	`Группа` VARCHAR(50) NOT NULL,
	`Код клиента` INT NOT NULL)
	";
	
	if (mysqli_query($db, $SQL) === TRUE)
	{
		print "Таблица Группы создана<br>";
	}
	else
	{
		printf("Ошибка создания таблицы 'Группы': %s\n", mysqli_error($db));
	}
	
	// Добавление группы Общая
		$SQL = "INSERT INTO Группы (`Группа`, `Код клиента` ) VALUES ('Общая', '1')";

	if (mysqli_query($db, $SQL) === TRUE)
	{
		print "Запись 'Общая' в таблицу Группы добавлена.<br>";
	}
	else
	{
		printf("Ошибка: %s\n", mysqli_error($db));
	}
	
	
	// Создание таблицы Клиенты
	if (mysqli_query($db, "DROP TABLE IF EXISTS Клиенты;") === TRUE)
	{
		print "Таблица Клиенты удалена<br>";
	}
	else
	{
		printf("Ошибка: %s\n", mysqli_error($db));
	}
	
	$SQL = "CREATE TABLE Клиенты 
	( 
	`Код клиента` INT NOT NULL  AUTO_INCREMENT PRIMARY KEY, 
	`Логин` VARCHAR(50) NOT NULL, 
	`Пароль` VARCHAR(255) NOT NULL,
	`Доступ` int NOT NULL,
	`Регистрация` TIMESTAMP NOT NULL
	);";

	if (mysqli_query($db, $SQL) === TRUE)
	{
		print "Таблица Клиенты создана<br>";
	}
	else
	{
		printf("Ошибка: %s\n", mysqli_error($db));
	}

	// Добавляем записи администратора и первого клиента
	$hash_pass1 = password_hash('admin100', PASSWORD_DEFAULT);
	$hash_pass2 = password_hash('1', PASSWORD_DEFAULT);
	$SQL = "INSERT INTO Клиенты (`Логин`, `Пароль`, `Доступ`) 
						VALUES 	('admin', '".$hash_pass1."', '10'),
								('1', '".$hash_pass2."', '1')						
		";
		
	if (mysqli_query($db, $SQL) === TRUE)
	{
		print "Запись администратора в таблицу Клиенты добавлена.<br>";
	}
	else
	{
		printf("Ошибка добавления записи администратора: %s\n", mysqli_error($db));
	}

	
}


function Add_group()
{
    global $db;


    // Добавление группы Новая
    $SQL = "INSERT INTO Группы (`Группа`, `Код клиента` ) VALUES ('Новая', '1')";

    if (mysqli_query($db, $SQL) === TRUE)
    {
        print "Запись 'Новая' в таблицу Группы добавлена.<br>";
    }
    else
    {
        printf("Ошибка: %s\n", mysqli_error($db));
    }


}




function GetDB()
{
	global $db;
	$SQL = "
			SELECT Закладки.`Закладка`, Закладки.`Адрес`, Группы.`Группа`
			FROM Закладки JOIN Группы 
			ON Закладки.`Код группы` = Группы.`Код группы`";
	//print $SQL;
	if ($result = mysqli_query($db, $SQL)) 
	{
		//printf ("Число строк в запросе: %d<br>", mysqli_num_rows($result));
		print "<table border=1 cellpadding=5>"; 
		// Выборка результатов запроса 
		while( $row = mysqli_fetch_assoc($result) )
		{ 
			print "<tr>"; 
			printf("<td>%s</td><td>%s</td><td>%s</td>", $row['Закладка'], $row['Адрес'], $row['Группа']); 
			print "</tr>"; 
		} 
		print "</table>"; 
		mysqli_free_result($result);
	}
	else
	{
		printf("Ошибка в запросе: %s\n", mysqli_error($db));
	}
	 
}	

function ShowSites()
{
	global $db;
	$SQL = "SELECT * FROM Закладки WHERE `Код клиента` = ".$_SESSION['iduser'];
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
	 
}


function AddDB()
{
	global $db;
	// Получение списка групп
	$SQL = "SELECT * FROM Группы";
	
	if (!$result = mysqli_query($db, $SQL)) 
	{
		printf("Ошибка в запросе: %s\n", mysqli_error($db));
	}
	// Получение кода первого клиента
	$SQL = "SELECT * FROM Клиенты WHERE `Логин` LIKE '1'";
	
	if (!$result2 = mysqli_query($db, $SQL)) 
	{
		printf("Ошибка в запросе: %s\n", mysqli_error($db));
	}
	$row = mysqli_fetch_assoc($result2);
	$client = $row['Код клиента'];
	mysqli_free_result($result2);

?>
<form action="add.php" method="post">
	    <table>
        <tr><td>Закладка</td><td><input name="tab" maxlength=60 size=100></td></tr>
        <tr><td>Адрес</td><td><input name="siteurl" maxlength=2048 size=100></td></tr>
        <tr><td>Группа</td><td>
        <select name="group" size="1">
<?php			
		// Цикл по группам 
		while( $row = mysqli_fetch_assoc($result) )	
		{		
			print "<option selected value='".$row['Код группы']."'>";
			print $row['Группа']."</option>";
		}
		mysqli_free_result($result);
		print "<input name='client' type='hidden' value='".$client."'>";
?>		
		</select></td>        
		</tr>
        <tr><td colspan=2><input type="submit" value="Добавить"></td></tr>
    </table>
</form>
	
<?php	
	
}

// Вывод таблицы с функциями редактирования
function EditDB()
{
	global $db;
	$SQL = "SELECT * FROM Закладки WHERE `Код клиента` = ".$_SESSION['iduser'];
	if ($result = mysqli_query($db, $SQL)) 
	{
		print "<table border=1 cellpadding=5>";
		while ($row = mysqli_fetch_assoc($result)) 
		{
			print "<tr>"; 
			printf("<td>%s</td><td>%s</td>", $row['Закладка'], $row['Адрес']); 
			print "<td><a href='edit.php?id=".$row['Код закладки']."'>Открыть</a></td>";
			print "<td><a href='delete.php?id=".$row['Код закладки']."'>Удалить</a></td>";
			print "</tr>"; 			
		}	 
		print "</table><br>";
	}
}


// Сохраняет скриншот в файл и возвращает его имя
function SiteScreenshot($url)
{
	global $APIkey;
	// Удаляем протокол из адреса
	$url = str_replace (['http://', 'https://'], '', $url); 
	// Удаляем пробелы и слеш
	$url = trim($url, ' /'); 
	// К имени файла добавляем код клиента
	$file = $url.$_SESSION['iduser'];
	// Получаем хэш для имени файла
	$filename = md5($file) . ".png";
	// Папка, где хранятся скриншоты сайтов
	$dir = "pics/";
	// Если скриншот существует, то выдаем его на экран
	if (is_file($dir.$filename)) 
	{
		return $dir.$filename;
	}
	// Иначе создаем скриншот
	else 
	{
		// Запрос для скриншота
		$geturl = "https://api.screenshotmachine.com?key=" . $APIkey . "&dimension=320x240&format=png&url=" . $url;
		// Получаем скриншот
		$screenshot = file_get_contents($geturl);
		// Создаем файл
		$openfile = fopen($dir.$filename, "w+");
		// Сохраняем изображение
		$write = fwrite($openfile, $screenshot);
		return $dir.$filename;
	}
}
// Возвращает заголовок сайта
function SiteTitle($url)
{
	// Если нет протокола в адресе добавляем его
	if ((strpos($url, 'http://') === false) && (strpos($url, 'https://') === false)) 
	{
		$url = 'http://' . $url;
	}
	$fp = file_get_contents($url);
	if (!$fp) 
	{
		return null;
	}
	$res = preg_match("/<title>(.*)<\/title>/siU", $fp, $title_matches);
	if (!$res) 
	{
		return null;
	}
	// Чистка заголовка
	$title = preg_replace('/\s+/', ' ', $title_matches[1]);
	$title = trim($title);
	return $title;
}

// Проверка авторизации
function CheckLogin()
{
	// Если авторизация есть
	if(isset($_SESSION['iduser']))
	{
		ShowSites();
		return;
	}
	// Проверка логина
	if(isset($_POST['userlogin']))
	{
		$_SESSION['login'] = $_POST['userlogin'];
		$_SESSION['password'] = $_POST['userpass'];
		//print "<br>Логин ".$_SESSION['login'];
		//print "<br>Пароль ".$_SESSION['password'];
		// Проверка пароля
		if(CheckPassword())
		{
			ShowSites();
		}
		else
		{
			print "<br>Доступ запрещен";
			print "<a href='index.php'><br>Введите логин и пароль повторно</a>";
		}
    }
	else
	{
		ShowLogin();
	}
}

function CheckPassword() 
{
	global $db;
    // Составляем строку запроса
    $SQL = "SELECT * FROM `Клиенты` WHERE `Логин` LIKE '".$_SESSION['login']."'";


	if ($result = mysqli_query($db, $SQL)) 
	{
		// Если нет пользователя с таким логином, то завершаем функцию
		if(mysqli_num_rows($result)== 0) 
		{
			print "<br>Пара логин-пароль не совпадает";
			return FALSE;
		}
		// Если логин есть, то проверяем пароль
		$row = mysqli_fetch_assoc($result); 
		if (password_verify($_SESSION['password'], $row['Пароль']))
		{
			//print "<br>Пароль совпадает<br>";
			$_SESSION['iduser']=$row['Код клиента'];
			return TRUE;
		}
	}
	else
	{
		printf("Ошибка: %s\n", mysqli_error($db));
	}
    unset($_SESSION['user']);
    print "Пара логин-пароль не совпадает<br>";
    return FALSE;
}


// Функция регистрации пользователя
function RegUser() 
{
	global $db;
	// Проверка данных
	if(!$_POST['user_login']) 
	{
		print "<br>Не указан логин";
		return FALSE;
	} 
	elseif(!$_POST['user_password']) 
	{
		print "<br>Не указан пароль";
		return FALSE;
	}
	
	// Проверяем не зарегистрирован ли уже пользователь
	$SQL = "SELECT `Логин` FROM `Клиенты` WHERE `Логин` LIKE '".$_POST['user_login']. "'";

	// Делаем запрос к базе
	if ($result = mysqli_query($db, $SQL)) 
	{
		// Если есть пользователь с таким логином, то завершаем функцию
		if(mysqli_num_rows($result) > 0) 
		{
			print "<br>Пользователь с указанным логином уже зарегистрирован.";
			return FALSE;
		}
	}
	else
	{
		printf("Ошибка: %s\n", mysqli_error($db));
	} 
	// Если такого пользователя нет, регистрируем его
	$hash_pass = password_hash($_POST['user_password'], PASSWORD_DEFAULT);
	$SQL = "INSERT INTO `Клиенты` 
			(`Логин`,`Пароль`,`Доступ`) VALUES 
			('".$_POST['user_login']. "','".$hash_pass. "', '1')";

	if (mysqli_query($db, $SQL) === TRUE)
	{
		//print "<br>Пользователь зарегистрирован";
	}
	else
	{
		printf("Ошибка: %s\n", mysqli_error($db));
		return FALSE;
	}
	
	return TRUE;
}


function ShowLogin()
{
	?>
	<form action="index.php" method="post" >

		<p>Логин<br>
		<input name="userlogin"size="20"
		type="text" value=""></p>

		<p>Пароль<br>
		<input name="userpass"size="20"
		type="password" value=""></p> 

		<p><input name="login" type="submit" value="Войти"></p>

		<p> Еще не зарегистрированы?</p> 
		<a href = "register.php">Регистрация</a>
	</form>
	<?php
}

function ShowAddSite()
{
	if(isset($_SESSION['iduser']))
	{
		?>	
		<form action="addsite.php" method="post">
				Введите адрес сайта: <input name="siteurl" maxlength=2048 size=60>
				<input type="submit" value="Добавить сайт">
		</form>
		<br>
        <form action="sitesearch.php" method="post">
            Поиск по названию сайта: <input name="siteurl" maxlength=2048 size=60>
            <input type="submit" value="Искать">
        </form>
		<br>
		<a href="edit_table.php">Правка закладок</a><br>
        <a href="edit_group.php">Правка таблицы “Группы”</a><br>
		<a href="exit.php">Завершить работу</a>
		<?php
	}
}

// Новые функции

function StartPage()
{
?>
<div id="wrapper">
    <div id="header">
    </div>


    <div id="content">
        <?php

        }


        function EndPage()
        {
        ?>
    </div>
    <div id="footer">
    </div>

</div>

<?php

}


// Вывод таблицы Группы c функциями редактирования
function EditGrup()
{
    global $db;
    if ($result = mysqli_query($db, "SELECT * FROM Группы"))
    {
        print "<table border=1 cellpadding=5>";
        while ($row = mysqli_fetch_assoc($result))
        {
            print "<tr>";
            printf("<td>%s</td><td>%s</td>", $row['Группа'], $row['Код клиента']);
            print "<td><a href='edit_Grup.php?id=".$row['Код группы']."'>Открыть</a></td>";
            print "<td><a href='delete_Grup.php?id=".$row['Код группы']."'>Удалить</a></td>";
            print "</tr>";
        }
        print "</table><br>";
    }
}




?>
