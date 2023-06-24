<?php

require_once "common/Page.php";

use common\Page;


class SLAEHistory extends Page
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
          <h5>Система Введена <?=$system['creation_date']?></h5>
        </div>
          <table class="mx-auto">
              
            <?php for ($i = 1; $i <= $n; $i++): ?>
              <tr>
                <?php for ($j = 1; $j <= $n; $j++): ?>
                  <td>
                    <?= $this->dbh->getCoefficient($system['id'],$i,$j)?>
                  </td>
                  <td>X<sub><?php echo $j; ?></sub></td>
                  <?php if ($j < $n): ?>
                    <td>+</td>
                  <?php endif; ?>
                <?php endfor; ?>
                <td>=</td>
                <td>
                    <?= $this->dbh->getCoefficient($system['id'],$i,0)?>
                </td>
              </tr>
            <?php endfor; ?>
          </table>
          <div class="text-center my-3">
          <h7><?=$system['Answer'] ?? "Решения Ещё нет"?></h7>
        </div>
        </div>
        </div>
    </div>
    <?php
  }
}

(new SLAEHistory())->showPage();