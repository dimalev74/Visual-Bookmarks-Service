<?php $title = "Правка закладки"; require_once "header.php"; ?>

<div id="wrapper">
    <div id="header">
        <h2>Правка Группы</h2>
    </div>

    <div id="content">
        <?php
        StartDB();
        // Получение списка групп
        $SQL = "SELECT * FROM Группы";

        if (!$result = mysqli_query($db, $SQL))
        {
            printf("Ошибка в запросе: %s\n", mysqli_error($db));
        }

        // Получение записи
        $id = $_GET['id'];
        $SQL = "SELECT * FROM Группы WHERE `Код группы`=".$id;

        if ($result_item = mysqli_query($db, $SQL))
        {
//            $row = mysqli_fetch_assoc($result_item);
//            $tab  = $row['Закладка'];
//            $siteurl = $row['Адрес'];
//            $shot = $row['Скриншот'];
//            $group = $row['Код группы'];
            $row = mysqli_fetch_assoc($result_item);
            //$tab_  = $row['Код группы'];
            $tab  = $row['Группа'];
            $client  = $row['Код клиента'];


        }
        else
        {
            printf("Ошибка в запросе: %s\n", mysqli_error($db));
        }

        ?>
        <form action="update_Grup.php" method="post">
            <table>
                <?php
                print "<tr><td>Группа</td><td><input name='tab' value='".$row['Группа']."' maxlength=255 size=60></td></tr>";
                print "<tr><td>Код клиента</td><td><input name='client' value='".$row['Код клиента']."'maxlength=2048 size=60></td></tr>";
                print "<input name='id' type='hidden' value='".$id."'>";
                //print "<tr><td>Группа</td><td>";
                //print "<select name='group' size='1'>";

                // Цикл по группам
                //                while( $row = mysqli_fetch_assoc($result) )
                //                {
                //                    if ($row['Код группы'] == $group)
                //                    {
                //                        print "<option selected value='".$row['Код группы']."'>";
                //                    }
                //                    else
                //                    {
                //                        print "<option value='".$row['Код группы']."'>";
                //                    }
                //                    print $row['Группа']."</option>";
                //                }
                mysqli_free_result($result);
                ?>
                </select></td>
                </tr>
                <tr><td colspan=2><input type="submit" value="Изменить"></td></tr>
            </table>
        </form>
        <a href="index.php">Вернуться на главную</a>

    </div>
    <div id="footer">
    </div>

</div>

<?php require_once "footer.php"; ?>

