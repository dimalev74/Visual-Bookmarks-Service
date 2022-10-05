<?php session_start(); $title = "Пример p74"; require_once "header.php"; ?>	
		<div id="wrapper">

			<div id="header">
				<h2>Сервис визуальных закладок</h2>
			</div> 
			
			<div id="content">
			<?php	
				StartDB();
				//InitDB(); // Первоначальное создание таблиц
				CheckLogin();
				EndDB();
			?>
                <h2>Администрирование сайта</h2>
                <a href="./admin/index.php">Войти</a>
			</div>
			<div id="footer">
				<br>	
				<?php ShowAddSite(); ?>
			</div>
		</div> 	
	</body>
</html>
