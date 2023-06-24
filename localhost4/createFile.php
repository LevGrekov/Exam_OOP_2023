<?php
print_r($_GET);
$upperLimit = $_GET['upperLimit'];
$lowerLimit = $_GET['lowerLimit'];
$intervals = $_GET['intervals'];
$answer = $_GET['answer'];

// Формируем содержимое файла
$fileContent = "Upper Limit: $upperLimit" . PHP_EOL;
$fileContent .= "Lower Limit: $lowerLimit" . PHP_EOL;
$fileContent .= "Intervals: $intervals" . PHP_EOL;
$fileContent .= "Answer: $answer" . PHP_EOL;

// Уникальное имя файла
$filename = uniqid() . '.txt';

// Путь, где будут сохраняться файлы
$filepath = 'files/' . $filename;

// Сохраняем содержимое в файл
file_put_contents($filepath, $fileContent);

// Возвращаем имя файла в качестве ответа на запрос
echo $filename;
?>