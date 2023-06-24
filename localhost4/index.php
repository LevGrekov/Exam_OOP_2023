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
        $this->displayIntegralTableFromDirectory("files");
      }
    }

    public function displayIntegralTableFromDirectory($directoryPath)
    {
        // Получение списка файлов в указанной директории
        $files = scandir($directoryPath);
    
        // Удаление точек (текущая директория и родительская директория) из списка файлов
        $files = array_diff($files, ['.', '..']);
    
        // Проверяем, есть ли файлы для отображения
        if (empty($files)) {
            $html = "<p>Нет доступных файлов для отображения.</p>";
            echo $html;
            return;
        }
    
        // Генерируем HTML-код для таблицы с использованием классов Bootstrap
        $html = '<div class="table-responsive m-5">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Lower Limit</th>
                                <th>Upper Limit</th>
                                <th>Interval</th>
                                <th>Answer</th>
                                <th>Function</th>
                            </tr>
                        </thead>
                        <tbody>';
    
        // Обработка каждого файла
        foreach ($files as $file) {
            // Чтение содержимого файла
            $filePath = $directoryPath . '/' . $file;
            $fileContent = file_get_contents($filePath);
    
            // Получение значений из файла
            $lowerLimit = '';
            $upperLimit = '';
            $intervals = '';
            $answer = '';
            $func = '';
    
            // Обработка каждой строки файла
            foreach (explode(PHP_EOL, $fileContent) as $line) {
                $parts = explode(': ', $line);
                if (count($parts) === 2) {
                    $key = trim($parts[0]);
                    $value = trim($parts[1]);
                    $func = "Some Function";

                    // Получение нужных значений по ключу
                    switch ($key) {
                        case 'Lower Limit':
                            $lowerLimit = $value;
                            break;
                        case 'Upper Limit':
                            $upperLimit = $value;
                            break;
                        case 'Intervals':
                            $intervals = $value;
                            break;
                        case 'Answer':
                            $answer = $value;
                            break;
                    }
                }
            }
    
            // Добавление строки в таблицу
            $html .= '<tr>
                        <td>' . $lowerLimit . '</td>
                        <td>' . $upperLimit . '</td>
                        <td>' . $intervals . '</td>
                        <td>' . $answer . '</td>
                        <td>' . $func . '</td>
                    </tr>';
        }
    
        $html .= '</tbody>
                </table>
            </div>';
    
        echo $html;
    }
    
    

    

}

(new index())->showPage();