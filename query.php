<?php
include 'function.php';
$pdo = new PDO('mysql:host=localhost;dbname=kerimov', 'kerimov', 'neto0990');
$pdo->exec("SET NAMES utf8");

//Выполнение или удаление задания, в зависимости от нажатой ссылки
if (!empty($_GET)) {
  $edit = editTask($_GET['action']);
  statement($pdo, $edit, $_GET['id']);
}

//Добавление задания
if (!empty($_POST['add'])) {
  $add = 'INSERT INTO tasks (description, is_done, date_added)
          VALUE (?, 0, NOW())';
  statement($pdo, $add, $_POST['task']);
}

//Подгрузка описания задания, выбранного для редактирования
if (!empty($_GET['action']) && $_GET['action'] === 'edit') {
  $taskButtonValue = 'Сохранить'; //Изменение текста кнопки для редактирования
  $taskButtonName = 'save'; //Изменение имени кнопки для редактирования
  $description = 'SELECT * FROM tasks WHERE id = ?';
  $statement = statement($pdo, $description, $_GET['id']);
  foreach ($statement as $row) {
    $taskValue = $row['description']; //Изменение содержимого текстового поля для редактирования
  }
} else {
  $taskValue = ''; //Изменение содержимого текстового поля для добавления
  $taskButtonValue = 'Добавить'; //Изменение текста кнопки для добавления
  $taskButtonName = 'add'; //Изменение имени кнопки для добавления
}

//Редактирование описания задания
if (!empty($_POST['save'])) {
  $edit = 'UPDATE tasks SET description = :description WHERE id = :id';
  $statement = $pdo->prepare($edit);
  $statement->execute([
    "description" => $_POST['task'],
    "id" => $_GET['id']
  ]);
  header('Location: index.php');
  die;
}

//Сортировка по одному из трёх параметров, если они выбраны, или по id
if (!empty($_POST['sort'])) {
  if ($_POST['sort'] === 'description') {
    $select = 'SELECT * FROM tasks ORDER BY description';
  }
  elseif ($_POST['sort'] === 'is_done') {
    $select = 'SELECT * FROM tasks ORDER BY is_done';
  } else {
    $select = 'SELECT * FROM tasks ORDER BY date_added';
  }
} else {
  $select = 'SELECT * FROM tasks ORDER BY id';
}

$statement = statement($pdo, $select, '');