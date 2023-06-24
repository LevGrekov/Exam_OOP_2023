<?php

require_once "common/Page.php";

use common\Page;


class index extends Page
{
  public function __construct(){
    parent::__construct();
    }


    protected function showContent()
    {
      if(!isset($_SESSION['user'])){
        ?>
        <div class="d-flex justify-content-center align-items-center" style="height: 85vh; background-color: #f2f2f2;">
          <div class="text-center">
            <h5>Только авторизованные пользователи могут просматривать эту страницу</h5>
            <a href="autorization.php" class="btn btn-primary mt-3">Авторизоваться</a>
          </div>
        </div>
        <?php
      }
      else{
        $this->displayIntegralTable();
      }
    }

    public function displayIntegralTable()
    {
        $integrals = $this->dbh->getAllIntegrals();
    
        // Проверяем, есть ли данные для отображения
        if (empty($integrals)) {
            $html = "<p>Нет доступных данных для отображения.</p>";
            echo $html;
            return;
        }
    
        // Генерируем HTML-код для таблицы с использованием классов Bootstrap
        $html = '<div class="table-responsive m-5">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Lower Limit</th>
                                <th>Upper Limit</th>
                                <th>Interval</th>
                                <th>Answer</th>
                                <th>Function</th>
                            </tr>
                        </thead>
                        <tbody>';
    
        foreach ($integrals as $integral) {
            $html .= '<tr>
                        <td>' . $integral['id'] . '</td>
                        <td>' . $integral['lowerLimit'] . '</td>
                        <td>' . $integral['upperLimit'] . '</td>
                        <td>' . $integral['intervals'] . '</td>
                        <td>' . $integral['answer'] . '</td>
                        <td>' . $integral['func'] . '</td>
                    </tr>';
        }
    
        $html .= '</tbody>
                </table>
            </div>';
    
        echo $html;
    }
    

}

(new index())->showPage();