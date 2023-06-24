<?php

require_once "common/Page.php";
use common\Page;

class history extends Page
{
    protected function showContent()
    {
        $systems = $this->dbh->getAllSystems($_SESSION['login']);

        for($i=0;$i<Count($systems);$i++){
            $this->generateEquationTable($systems[$i]);
        }
    }

    private function generateEquationTable($system)
  {
    $n = $system['varsAmount'];
    ?>
    <div>
        <div class="container">
        <div>
          <table>
              
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
          <div>
          <h7><?=$system['Answer'] ?? "Решения Ещё нет"?></h7>
        </div>
        <br>
        </div>
        </div>
    </div>
    <?php
  }
}

(new history())->show();