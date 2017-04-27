<?php
namespace todo;
use todo\classes\myPDO;
include 'function.php';
error_reporting(E_ALL);

$pdo = new myPDO('mysql:host=localhost;dbname=kerimov;charset=utf8', 'kerimov', 'neto0990');

//Добавление задания
if (!empty($_POST['add'])) {
  $pdo->insert($_POST['task']);
}

//Выполнение или удаление задания, в зависимости от нажатой ссылки
if (!empty($_GET)) {
  if ($_GET['action'] === 'execute') {
    $pdo->updateIsDone($_GET['id']);
  }
  if ($_GET['action'] === 'delete') {
    $pdo->delete($_GET['id']);
  }
}

//Подгрузка описания задания, выбранного для редактирования
if (!empty($_GET['action']) && $_GET['action'] === 'edit') {
  $taskValue = $pdo->selectTaskById($_GET['id']);
  $taskButtonValue = 'Сохранить'; //Изменение текста кнопки для редактирования
  $taskButtonName = 'save'; //Изменение имени кнопки для редактирования
} else {
  $taskValue = ''; //Изменение содержимого текстового поля для добавления
  $taskButtonValue = 'Добавить'; //Изменение текста кнопки для добавления
  $taskButtonName = 'add'; //Изменение имени кнопки для добавления
}

//Редактирование описания задания
if (!empty($_POST['save'])) {
  $pdo->updateDescription($_POST['task'], $_GET['id']);
  header('Location: index.php');
  die;
}

//Сортировка по одному из трёх параметров, если они выбраны, или по id
if (!empty($_POST['sort'])) {
  $statement = $pdo->select($_POST['sort']);
} else {
  $statement = $pdo->select('id');
}

?>

<!doctype html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Список дел</title>
</head>
<body>
  <form method="post">
    <input type="text" name="task" placeholder="Описание задачи" value="<?= $taskValue ?>">
    <input type="submit" name="<?= $taskButtonName ?>"  value="<?= $taskButtonValue ?>">
  </form>
  <br>
  <form method="post">
    <label for="sort">Сортировать по</label>
    <select name="sort" id="sort">
      <option value="description">Описанию</option>
      <option value="is_done">Статусу</option>
      <option value="date_added">Дате добавления</option>
    </select>
    <input type="submit" name="sort_button" value="Сортировать">
  </form>
  <table>
    <tr>
      <th>Описание</th>
      <th>Статус</th>
      <th>Дата добавления</th>
      <th></th>
    </tr>
    <?php
     functions\output($statement);
    ?>
  </table>
</body>
</html>