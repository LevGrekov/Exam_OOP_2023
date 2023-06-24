<?php
require_once 'Page.php';

class autorization extends Page
{

   public function __construct(){
      parent::__construct();
      if(isset($_REQUEST['exit'])){
         unset($_SESSION['login']);
         header("Location: /index.php");
         exit;
      }
   }
   
    protected function showContent(){
      if($this->auth() === true){
         header("Location: /index.php");
         exit;
      };
      ?>
      
      <h2>Авторизация</h2>
    <form action="autorization.php" method="POST">
        <label for="login">login:</label>
        <input type="text" id="login" name="login" required>

        <label for="password">Пароль:</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" value="Войти">
    </form>
      <?php
    }
    
   private function auth() : bool
   {
      if (!isset($_POST['login']) || !isset($_POST['password'] )){
         return false;
      }

      $login = $_POST['login'];
      $password = $_POST['password'];
      $save_pwd = DbHelper::getInstance()->getUserPassword($login) ?? "";

      $auth = password_verify($password, $save_pwd);

      if ($auth) $_SESSION['login'] = $login;
      else unset($_SESSION['login']);
      return $auth;
   }
}

(new autorization)->showPage();