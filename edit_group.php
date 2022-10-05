<?php $title = "Правка таблицы “Группы”"; require_once "header.php"; ?>

<div id="wrapper">
    <div id="header">
        <h2>Правка таблицы “Группы”</h2>
    </div>

    <div id="content">

        <?php
        StartDB();
        EditGrup();
        EndDB();
        ?>
        <a href="add_group.php">Добавить новую группу</a>
    </div>
    <div id="footer">
        <br><br>
        <a href="index.php">Вернуться на главную</a>
    </div>
</div>

<?php require_once "footer.php"; ?>
