<?php

require_once "common/Page.php";

use common\Page;


class historyPage extends Page
{
    protected function showContent()
    {
        $systems = $this->dbh->getAllSystems();

        for($i=0;$i<Count($systems);$i++){
            $this->generateEquationTable($systems[$i]);
        }
    }

    private function generateEquationTable($system)
  {
    $n = $system['varsAmount'];
    ?>
    <div class="my-4">
        <div class="container">
        <div class="card m-5">
        <div class="text-center my-3">
          <h5>Матрица Создана <?=$system['creation_date']?></h5>
        </div>
          <table class="mx-auto">
              
            <?php for ($i = 0; $i < $n; $i++): ?>
              <tr>
                <?php for ($j = 0; $j < $n; $j++): ?>
                  <td>
                    <?= $this->dbh->getCoefficient($system['id'],$i,$j)?>
                  </td>
                <?php endfor; ?>
              </tr>
            <?php endfor; ?>
          </table>
          <div class="text-center my-3">
          <h7>Определитель: <?=$system['Answer'] ?? "Определитель Ещё не известен"?></h7>
        </div>
        </div>
        </div>
    </div>
    <?php
  }
}

(new historyPage())->showPage();