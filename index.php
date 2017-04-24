<?php
include 'query.php';
error_reporting(E_ALL);
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
      output($statement);
    ?>
  </table>
</body>
</html>