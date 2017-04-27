<?php
namespace todo;
use todo\classes\myPDO;

$pdo = new myPDO('mysql:host=localhost;dbname=kerimov;charset=utf8', 'kerimov', 'neto0990');

$drop = "DROP TABLE IF EXISTS tasks";
$statement = $pdo->prepareStatement($drop, '');
if ($statement->execute()) {
  echo 'Таблица tasks успешно удалена<br>';
} else {
  echo 'Ошибка при удалении таблицы tasks <br>';
}

$create = "CREATE TABLE tasks (
  id int(11) NOT NULL AUTO_INCREMENT,
  description text NOT NULL,
  is_done tinyint(4) NOT NULL DEFAULT '0',
  date_added datetime NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

$statement = $pdo->prepareStatement($create, '');
if ($statement->execute()) {
  echo 'Таблица tasks успешно создана<br>';
  echo '<a href="index.php">Перейти к списку дел</a>';
} else {
  echo 'Ошибка при создании таблицы tasks <br>';
}