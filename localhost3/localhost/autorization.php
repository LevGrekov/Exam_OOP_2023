<?php

require_once "common/Page.php";
use common\Page;
use common\DbHelper;



class auth extends Page
{
  public function __construct(){
    parent::__construct();
        if(isset($_REQUEST['exit'])){
            unset($_SESSION['user']);
            header("Location: /index.php");
            exit;
        }
    }


    protected function showContent()
    {
        if(isset($_REQUEST['reg'])){
            $this->ShowRegistration();
        }
        else{
            $this->ShowAuth();
        }

        if($this->auth()===true){
            header("Location: /index.php");
            exit;
        }
    }

    private function ShowAuth()
    {
        ?>
        <div class="container py-5">
        <div class="card mx-auto" style="max-width: 400px;">
            <div class="card-body">
            <h2 class="card-title text-center">Авторизация</h2>
            <form method="POST">
                <div class="form-group">
                <label for="username">Имя пользователя</label>
                <input type="text" class="form-control" id="loginauth" name="loginauth" placeholder="Введите имя пользователя" required pattern="[a-zA-Z0-9]{3,}" minlength="3" maxlength="20" >
                </div>
                <div class="form-group">
                <label for="password">Пароль</label>
                <input type="password" class="form-control" id="passwordauth" name="passwordauth" placeholder="Введите пароль" required minlength="6" maxlength="30">
                </div>
                <button type="submit" class="btn btn-primary btn-block my-2">Войти</button>
            </form>
            <p class="text-center">Ещё не зарегистрированы? <a href="autorization.php?reg=true">Зарегистрироваться</a></p>
            </div>
        </div>
        </div>
        <?php
    }

    private function auth(): ?bool
    {
        if (!isset($_POST['loginauth']) || !isset($_POST['passwordauth'] ))
            return null;

        $login = $_POST['loginauth'];
        $password = $_POST['passwordauth'];
        $save_pwd = DbHelper::getInstance()->getUserPassword($login) ?? "";
        $auth = password_verify($password, $save_pwd);
        if ($auth) $_SESSION['user'] = $login;
        else unset($_SESSION['user']);
        return $auth;
    }

    private function ShowRegistration()
    {
        ?><div class="container py-5"><?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirmPassword'];

            if ($password === $confirmPassword) {
                if($this->RegUser()){
                    echo '<div class="alert alert-success">Вы успешно зарегистрировались!</div>';
                }
                else{
                    echo '<div class="alert alert-danger">Ошибка Регистрации. Возможно такой пользователь уже существует</div>';
                }
            } else {
                // Пароли не совпадают, выведите сообщение об ошибке
                echo '<div class="alert alert-danger">Пароли не совпадают. Пожалуйста, повторите ввод.</div>';
            }
        }

        // Остальной код шаблона регистрации
        ?>
        
            <div class="card mx-auto" style="max-width: 400px;">
                <div class="card-body">
                    <h2 class="card-title text-center">Регистрация</h2>
                    <form method="POST">
                        <div class="form-group">
                            <label for="username">Имя пользователя</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Введите имя пользователя" required pattern="[a-zA-Z0-9]{3,}" minlength="3" maxlength="20" >
                        </div>
                        <div class="form-group">
                            <label for="password">Пароль</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Введите пароль" required minlength="6" maxlength="30">
                        </div>
                        <div class="form-group">
                            <label for="confirmPassword">Повторите пароль</label>
                            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Повторите пароль" required minlength="6" maxlength="30">
                        </div>
                        <button type="submit" class="btn btn-primary btn-block my-2">Зарегистрироваться</button>
                    </form>
                    <p class="text-center">Уже зарегистрированы? <a href="autorization.php">Войти</a></p>
                </div>
            </div>
        </div>
        <?php
    }
    

    private function regUser() : bool
    {
        
        if (
            isset($_POST['username'])
            and isset($_POST['password'])
            and isset($_POST['confirmPassword'])
        ){
            $login = htmlspecialchars($_POST['username']);
            $password = htmlspecialchars($_POST['password']);
        }
        $dbh = DbHelper::getInstance();
        $hash = password_hash($password, PASSWORD_DEFAULT);
        if (!$dbh->saveUser($login, $hash)){
            return false;
        }
        else return true;

    }

}

(new auth())->showPage();