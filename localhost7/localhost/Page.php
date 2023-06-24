<?php

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
                <title>Валиулин Амир</title>
                <link rel="stylesheet" href="main.css">
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
        <header class="custom-header">
            <div class="container">
                <a class="custom-brand" href="index.php">Мой сайт</a>
                <ul class="custom-list">
                    <?php if(isset($_SESSION['login'])): ?>
                        <li>
                            <a class=" custom-link" href="autorization.php?exit=true">Выйти</a>
                        </li>
                    <?php else:?>
                        <li>
                            <a class="custom-link" href="autorization.php">Авторизоваться</a>
                        </li>
                        <li>
                            <a class=" custom-link" href="registration.php">Зарегистрироваться</a>
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
        <footer class="custom-footer">
            <div class="container">
                <span class="">Амир Валиулин</span>
            </div>
        </footer>
        <?php
    }

    protected abstract function showContent();
}