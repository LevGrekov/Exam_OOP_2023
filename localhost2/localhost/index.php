<?php

require_once "common/Page.php";

use common\Page;


class index extends Page
{
  public function __construct(){
    parent::__construct();
    if(isset($_POST['coefficient_1_1'])){
      $this->sendData();
      header("Location: /SLAEHistory.php");
      exit();
      }
    }
  protected function showContent()
  {
    if(!isset($_POST['amount'])){
    $this->AskAmount();
    }
    else{
    $this->generateEquationTable();
    }
  }

  private function AskAmount(){
    ?>
  
    <div class="container d-flex align-items-center justify-content-center">
        <div class="card m-5">
        
        <div class="card-body m-2">
        <h5>Решение Системы Линейных Уравнений</h5>
            <form action="index.php" method="POST">
            <div class="form-group">
                <label for="amount">Количество переменных:</label>
                <input type="number" class="form-control" id="amount" name="amount" required min="2" max="20">
            </div>
            <button type="submit" class="btn btn-primary my-3">Отправить</button>
            </form>
        </div>
        </div>
    </div>
    <?php
  }

  private function generateEquationTable()
  {
    $n = intval($_POST['amount']); // Получаем значение `amount` из POST и преобразуем в целое число 
    ?>
    <div class="my-4">
      <form action="#" method="POST">
      <input type="hidden" name="amount" value="<?=$n?>">
        <div class="container">
        <div class="text-center my-3">
          <h5>Решение Системы Линейных Уравнений</h5>
        </div>
          <table class="mx-auto">
              
            <?php for ($i = 1; $i <= $n; $i++): ?>
              <tr>
                <?php for ($j = 1; $j <= $n; $j++): ?>
                  <td>
                    <input type="text" name="coefficient_<?=$i?>_<?=$j?>" class="form-control" style="width: 100px;" required>
                  </td>
                  <td>X<sub><?php echo $j; ?></sub></td>
                  <?php if ($j < $n): ?>
                    <td>+</td>
                  <?php endif; ?>
                <?php endfor; ?>
                <td>=</td>
                <td>
                  <input type="text" name="result_<?=$i?>" class="form-control" style="width: 100px;" required>
                </td>
              </tr>
            <?php endfor; ?>
          </table>
        </div>
        <div class="text-center mt-4">
          <button type="submit" class="btn btn-primary">Отправить</button>
        </div>
      </form>
    </div>
    <?php
  }

  private function sendData(){
    $n = $_POST['amount'];
    $system_id = $this->dbh->CreateNewSystem($n);
    
    for($i=1;$i<=$n;$i++){
      for($j=1;$j<=$n;$j++){
        $POST_Coff = "coefficient_".$i."_"."$j";
        $this->dbh->addCoeff($system_id, $i, $j, $_POST[$POST_Coff]);
      }
      $POST_res = "result_".$i;
      $this->dbh->addCoeff($system_id ,$i ,0 ,$_POST[$POST_res]);
    }
  }
}

(new index())->showPage();