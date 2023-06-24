<?php

namespace common;
require_once "DbHelper.php";
abstract class Page
{
    protected $dbh;

    public function __construct()
    {
        session_start();
        $this->dbh = DbHelper::getInstance("localhost", 3306, "root", "");
    }

    public function showPage(): void
    {
        print "<!DOCTYPE html>";
        print "<html lang='ru'>";
        $this->createHeading();
        $this->createBody();
        print "</html>";
    }

    private function createHeading(){
        ?>

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
            <title>Мой Сайт</title>
        </head>
        <?php
    }

    private function createBody()
    {
        print "<body>";
        print "<div class='main'>";
        $this->showHeader();
        $this->showContent();
        $this->showFooter();
        print "</div>";
        print "</body>";
    }

    private function showHeader()
    {
        ?>
        <header class="navbar navbar-expand-lg" style="background-color: pink;">
            <div class="container">
                <a class="navbar-brand text-dark" href="index.php">Мой сайт</a>
                <ul class="navbar-nav ml-auto">
                    <?php if(isset($_SESSION['user'])): ?>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="history.php">История</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="autorization.php?exit=true">Выйти</a>
                    </li>
                    <?php else:?>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="autorization.php">Авторизоваться</a>
                    </li>
                    <?php endif;?>
                </ul>
            </div>
        </header>
        <?php
    }

    private function showFooter()
    {
        ?>
        <footer class="footer text-white text-right " style="background-color: pink;">
            <div class="container">
                <span class="text-muted">&copy; <?php echo date('Y'); ?>. Сайт Амили Велитовой</span>
            </div>
        </footer>
        <?php
    }

    protected abstract function showContent();
}