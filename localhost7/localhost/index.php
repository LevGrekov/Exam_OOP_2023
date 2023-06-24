<?php
require_once 'page.php';

class index extends Page
{
    protected function showContent(){
        
        if(isset($_SESSION['login'])):
        ?>
         <form method="POST" action="index.php">
            <label for="start">Начальная дата и время:</label>
            <input type="datetime-local" id="start" name="start" required><br><br>
            <label for="end">Конечная дата и время:</label>
            <input type="datetime-local" id="end" name="end" required><br><br>
            <input type="submit" value="Получить записи">
        </form>
        <?php

        if(isset($_POST['start']) && isset($_POST['end'])){
            $this->displayIntegralTable();
        }
        ?>
        <?php else:?>
            <div><p>Требуется Авторизация</p><div>
        <?php endif;
    }

    public function displayIntegralTable()
    {
        $startDateTime = $_POST['start'];
        $endDateTime = $_POST['end'];

        // Запрос к базе данных для получения записей в выбранном диапазоне
        $integrals = $this->dbh->getIntegralsByDateTimeRange($startDateTime,$endDateTime);
    
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

(new index)->showPage();