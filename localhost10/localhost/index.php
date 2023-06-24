
<?php

require_once "DbHelper.php";
session_start();
$dbh = DbHelper::getInstance("localhost", 3306, "root", "");


if(isset($_POST['login'])){
    $_SESSION['user'] = $_POST['login'];
}
if(isset($_REQUEST['exit'])){
    unset($_SESSION['user']);
    header("Location: index.php");
    exit;
}
 
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Булат</title>
</head>
<body>
    <header>
        <nav>
            <ul class="navigation">
                <li><a href="index.php">Главная</a></li>
                <?php if (isset($_SESSION['user'])):?>
                    <li><a href="index.php?exit=true">Выход</a></li>
                <?php endif;?>
            </ul>
        </nav>
    </header>
    <main>
        <?php if(isset($_SESSION['user'])):?>
            <h1>Здравствуйте, <?php echo $_SESSION['user']?></h1>
            <h2>Выберете период времени за который нужно вывести графики</h2>
            <form class="date-form" action="index.php" method="POST">
                <input type="datetime-local" class="input" placeholder="Выберите начальную дату и время" name='startdate' required>
                <input type="datetime-local" class="input" placeholder="Выберите конечную дату и время" name='enddate' required>
                <button type="submit" class="submit-button">Отправить</button>
            </form>
            <?php if(isset($_POST['startdate']) and isset($_POST['enddate'])):?>
                <?php
                    $startdate = $_POST['startdate'];
                    $enddate = $_POST['enddate'];
                    $graps = $dbh->getIntegralsByDateTimeRange($startdate,$enddate);
                ?>
                <?php foreach($graps as $graph): ?>
                    <?php
                    $data = base64_encode($graph['data']);
                    ?>
                <h4><?php echo $graph['dateOfCreation']; ?></h4>
                <img src="data:image/png;base64,<?php echo $data; ?>"> 
                 <?php endforeach; ?>
            <?php endif;?>
        <?php else:?>
            <h2>Авторизуйтесь</h2>
            <form class="login-form" action="index.php" method="POST">
                <input type="text" class="login-input" name="login" placeholder="Введите логин" required>
                <button type="submit" class="submit-button">Войти</button>
            </form>
        <?php endif;?>
    </main>
    <footer>
        <p>&copy; 2023 Булат Файрушин. Все права защищены.</p>
    </footer>
</body>
</html>