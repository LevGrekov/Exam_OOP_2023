<?php
namespace common;
require_once "DbHelper.php";
abstract class Page
{

    protected $dbh;

    public function __construct(){
        session_start();
        $this->dbh = DbHelper::getInstance("localhost", 3306, "root", "");
    }
    public function show(): void{
        print "<html lang='ru'>";
        $this->createHeading();
        $this->createBody();
        print "</html>";
    }

    private function createHeading(){
        ?>
        <head>
            <link rel="stylesheet" type="text/css" href="/css/main.css">
            <meta charset="utf-8"/>
            <title>Сайт Чекашова Данила</title>
        </head>
        <?php
    }

    private function createBody()
    {
        print "<body>";
        print "<div class='main'>";
        $this->showHeader();
        $this->showMenu();
        print "<div class='content'>";
        $this->showContent();
        print "</div>";
        $this->showFooter();
        print "</div>";
        print "</body>";
    }

    protected abstract function showContent();

    private function showHeader()
    {
        ?>
        <div class='header'>
            <?php print "Сайт Чекашова Данила"; ?>
        </div>
        <?php
    }

    private function showMenu()
    {
        print "<div class='menu'>";
        
        print "<div class='menuitem'>";
        print "<a class='l_menuitem' href='index.php'>Главная</a>";
        print "</div>";
        
        print "<div class='menuitem'>";
        print "<a class='l_menuitem' href='auth.php'>Авторизация</a>";
        print "</div>";
        
        print "<div class='menuitem'>";
        print "<a class='l_menuitem' href='reg.php'>Регистрация</a>";
        print "</div>";

        if(isset($_SESSION['login'])){
            print "<div class='menuitem'>";
            print "<a class='l_menuitem' href='history.php'>История</a>";
            print "</div>";
        }

        
        // Добавьте дополнительные элементы меню по необходимости
        
        print "</div>";
    }


    private function showFooter()
    {
        print "<div class='footer'>";
        if (isset($_SESSION['login'])){
            print "<a href='/auth.php?exit=1'>Выход</a>";
        }
        print "<div>© Данил Чекашов, 2023, все права защищены</div>";
        print "</div>";
    }

}