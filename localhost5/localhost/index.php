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
            <a href="autorization.php" class="btn  mt-3" style="background-color: pink;">Авторизоваться</a>
          </div>
        </div>
        <?php
      }
      else{
        $this->addNewCalculationWindow();
      }
    }  

    private function addNewCalculationWindow(){
      if(!isset($_GET['addnew'])){
        ?>
        <div class="container d-flex align-items-center justify-content-center">
            <div class="card m-5">
            
            <div class="card-body m-2">
            <h5>Считать из csv-файла новую матрицу</h5>
                <a class="btn my-3" style="background-color: pink;"href="index.php?addnew=true">Считать</a>
            </div>
            </div>
        </div>
        <?php 
      }
      else{
        $this->addNewCalculation();  
      }
    }

    private function addNewCalculation()
    {
        $filename = 'newMatrix.csv'; // Укажите путь к файлу CSV
        $file = fopen($filename, 'r');
    
        if (!$file) {
            echo 'Ошибка открытия файла';
            return;
        }
    
        // Читаем первое число для получения размерности матрицы
        $dimension = fgets($file);
        $numRows = intval(trim($dimension));
        $numCols = $numRows;
    
        $systemId = $this->dbh->CreateNewSystem($numRows); // Создаем новую систему и получаем ее ID
    
        if ($systemId === 0) {
            echo 'Ошибка создания новой системы';
            fclose($file);
            return;
        }
    
        for ($rowId = 0; $rowId < $numRows; $rowId++) {
            $line = fgets($file);
            $row = explode(' ', trim($line));
    
            if (count($row) !== $numCols) {
                echo 'Неверное количество коэффициентов в строке';
                fclose($file);
                return;
            }
    
            for ($colId = 0; $colId < $numCols; $colId++) {
                $value = $row[$colId];
                $success = $this->dbh->addCoeff($systemId, $rowId, $colId, $value);
                if (!$success) {
                    echo 'Ошибка добавления коэффициента в базу данных';
                    fclose($file);
                    return;
                }
            }
        }
    
        fclose($file);
        echo '<div class="container my-5"><div class="alert alert-success">Матрица Добавлена в базу Данных</div></div>';
        echo '<div class="container my-5"><a href="history.php" class="btn" style="background-color: pink;">Перейти к истории</a></div>';
    }
}

(new index())->showPage();