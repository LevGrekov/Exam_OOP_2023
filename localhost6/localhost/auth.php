<?php

require_once "common/Page.php";
use common\Page;
use common\DbHelper;

class auth extends Page
{
    private $auth;
    public function __construct()
    {
        parent::__construct();
        if (isset($_REQUEST['exit'])){
            unset($_SESSION['login']);
            header("Location: /index.php");
        }
        else {
            $this->auth = $this->auth();
            if ($this->auth){
                header("Location: index.php");
            }
        }
    }

    protected function showContent()
    {
        if ($this->auth === false)
            print "<div class='error'>Введен неверный логин или пароль</div>";
        ?>
        <form method="post" action="auth.php">
            <table class='auth'>
                <tr>
                    <td colspan="2" class="tdhead">Введите свои логин и пароль:</td>
                </tr>
                <tr>
                    <td>Логин:</td>
                    <td><input type="text" size="30" maxlength="50" name="login" placeholder="Ваш уникальный идентификатор"></td>
                </tr>
                <tr>
                    <td>Пароль:</td>
                    <td><input type="password" size="30" maxlength="50" name="password" placeholder="Пароль"> </td>
                </tr>
                <tr><td colspan="2" class="tdhead"><input type="submit" value="Войти"></td></tr>
                <tr><td colspan="2" class="tdhead"><a href="reg.php">Еще не зарегистрированы?</a></td></tr>
            </table>
        </form>
        <?php
    }

    private function auth(): ?bool
    {
        if (!isset($_POST['login']) || !isset($_POST['password']) || mb_strlen($_POST['login']) < 3 || mb_strlen($_POST['password']) < 6)
            return null;
        $login = $_POST['login'];
        $password = $_POST['password'];
        $save_pwd = DbHelper::getInstance()->getUserPassword($login) ?? "";
        $auth = password_verify($password, $save_pwd);
        if ($auth) $_SESSION['login'] = $login;
        else unset($_SESSION['login']);
        return $auth;
    }
}

(new auth())->show();