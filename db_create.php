<?php

$pdo = new PDO('mysql:host=localhost;dbname=kerimov', 'kerimov', 'neto0990');
$pdo->exec("SET NAMES utf8");

$drop = "DROP TABLE IF EXISTS `tasks`";
$statement = $pdo->prepare($drop);
if ($statement->execute()) {
  echo 'Таблица tasks успешно удалена';
} else {
  echo 'Ошибка при удалении Таблица tasks ';
}

$create = "CREATE TABLE tasks (
  id int(11) NOT NULL AUTO_INCREMENT,
  description text NOT NULL,
  is_done tinyint(4) NOT NULL DEFAULT '0',
  date_added datetime NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

$statement = $pdo->prepare($create);
if ($statement->execute()) {
  echo 'Таблица tasks успешно создана';
  echo '<a href="index.php">Перейти к списку дел</a>';
} else {
  echo 'Ошибка при создании Таблица tasks ';
}