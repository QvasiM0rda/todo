<?php
namespace todo\functions;

//Автозагрузка классов
function autoloadClass($className)
{
  $className = __DIR__ . str_replace('\\', DIRECTORY_SEPARATOR, $className);
  $dir = 'wwwtodo';
  $fileName  = str_replace($dir, 'www', $className) . '.class.php';

  if (file_exists($fileName)) {
    require $fileName;
  } else {
    echo 'Файл не найден ' . $fileName .'<br>';
  }
}

spl_autoload_register('todo\functions\autoloadClass');

//Вывод данных из БД
function output($array){
  foreach ($array as $row) {
    if(htmlspecialchars($row['is_done']) == 0){
      $status = 'Не выполнено';
    } else {
      $status = 'Выполнено';
    }
    $id = $row['id'];
    echo '<tr>';
    echo '<td>' . htmlspecialchars($row['description']) . '</td>';
    echo '<td>' . $status . '</td>';
    echo '<td>' . htmlspecialchars($row['date_added']) . '</td>';
    echo '<td>
            <a href="?id=' . $id . '&action=edit">Редактировать</a>
            <a href="?id=' . $id . '&action=execute">Выполнить</a>
            <a href="?id=' . $id . '&action=delete">Удалить</a>
          </td>';
    echo '</tr>';
  }
}