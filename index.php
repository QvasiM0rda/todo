<?php
namespace todo;
include 'function.php';

$_SESSION['is_logged'] = 1;

?>
<!doctype html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Список дел</title>
</head>
<body>
  <form method="post">
    <?php
     if(empty($_SESSION['is_logged'])) { ?>
       <label for="login">Логин</label>
       <input type="text" name="login" id="login">
       <br>
       <label for="password">Пароль</label>
       <input type="password" name="password" id="password">
       <br>
       <input type="submit" name="log_in" value="Войти">
       <input type="submit" name="reg" value="Зарегистрироваться">
     <?php
       die;
     }?>
  </form>
  <form method="post">
    <input type="text" name="task" placeholder="Описание задачи" value="<?= $taskValue; ?>">
    <input type="submit" name="<?= $taskButtonName; ?>"  value="<?= $taskButtonValue; ?>">
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