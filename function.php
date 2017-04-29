<?php
namespace todo\functions;
use todo\classes\tasks;
use todo\classes\user;
error_reporting(E_ALL);
session_start();

//Автозагрузка классов
function autoloadClass($className)
{
  $className = str_replace('\\',DIRECTORY_SEPARATOR, $className);
  $namespace = 'todo' . DIRECTORY_SEPARATOR;
  $fileName = str_replace($namespace, '', $className) . '.class.php';
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
    echo '    <tr>'. "\n";
    echo '      <td>' . htmlspecialchars($row['description']) . '</td>' . "\n";
    echo '      <td>' . $status . '</td>'. "\n";
    echo '      <td>' . htmlspecialchars($row['date_added']) . '</td>'. "\n";
    echo '      <td>'. "\n" .
         '        <a href="?id=' . $id . '&action=edit">Редактировать </a>'. "\n" .
         '        <a href="?id=' . $id . '&action=execute">Выполнить </a>'. "\n" .
         '        <a href="?id=' . $id . '&action=delete">Удалить </a>'. "\n" .
         '      </td>'. "\n";
    echo '    </tr>'. "\n";
  }
}

$pdo = new \PDO('mysql:host=localhost;dbname=kerimov;charset=utf8', 'kerimov', 'neto0990');
$tasks = new tasks($pdo);
$user = new user($pdo);

//Добавление задания
if (!empty($_POST['add'])) {
  $tasks->insert($_POST['task']);
}

//Выполнение или удаление задания, в зависимости от нажатой ссылки
if (!empty($_GET)) {
  if ($_GET['action'] === 'execute') {
    $tasks->updateIsDone($_GET['id']);
  }
  if ($_GET['action'] === 'delete') {
    $tasks->delete($_GET['id']);
  }
}

//Подгрузка описания задания, выбранного для редактирования
if (!empty($_GET['action']) && $_GET['action'] === 'edit') {
  $taskValue = $tasks->selectTaskById($_GET['id']);
  $taskButtonValue = 'Сохранить'; //Изменение текста кнопки для редактирования
  $taskButtonName = 'save'; //Изменение имени кнопки для редактирования
} else {
  $taskValue = ''; //Изменение содержимого текстового поля для добавления
  $taskButtonValue = 'Добавить'; //Изменение текста кнопки для добавления
  $taskButtonName = 'add'; //Изменение имени кнопки для добавления
}

//Редактирование описания задания
if (!empty($_POST['save'])) {
  $tasks->updateDescription($_POST['task'], $_GET['id']);
  header('Location: index.php');
  die;
}

//Сортировка по одному из трёх параметров, если они выбраны, или по id
if (!empty($_POST['sort'])) {
  $statement = $tasks->select($_POST['sort']);
} else {
  $statement = $tasks->select('id');
}