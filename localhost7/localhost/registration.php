<?php
require_once 'page.php';

class registration extends Page
{

    protected function showContent(){
      if(isset($_POST['login']) and isset($_POST['password'])){
         $this->regUser();
      }
      ?>
      
      <h2>Регистрация</h2>
         <form action="registration.php" method="POST">
            <label for="login">login:</label>
            <input type="text" id="login" name="login" required>

            <label for="password">Пароль:</label>
            <input type="password" id="password" name="password" required>

            <input type="submit" value="Зарегистрироваться">
         </form>
      <?php
    }

    private function regUser() : bool
    {        
        if (
            isset($_POST['login'])
            and isset($_POST['password'])
        ){
            $login = htmlspecialchars($_POST['login']);
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

(new registration)->showPage();