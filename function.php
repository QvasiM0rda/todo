<?php

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

//Выполнение или удаление задания, в зависимости от нажатой ссылки
function editTask($action) {
  $sql = '';
  if ($action === 'execute') {
    $sql = 'UPDATE tasks SET is_done = 1 WHERE id = ?';
  }
  if ($action === 'delete') {
    $sql = 'DELETE FROM tasks WHERE id = ?';
  }
  return $sql;
}

//Обработка скрипта
function statement($pdo, $script, $argument) {
  $statement = $pdo->prepare($script);
  $statement->execute([$argument]);
  return $statement;
}