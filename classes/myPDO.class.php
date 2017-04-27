<?php
namespace todo\classes;

class myPDO extends \PDO
{
  protected $statement;

  //Выполнение скриптов
  public function executeStatement($script, $argument_1, $argument_2)
  {
    $statement = $this->prepare($script);
    if (!empty($argument_2)) {
      $statement->execute([
        'description' => $argument_1,
        'id' => $argument_2
      ]);
    } else {
      $statement->execute([$argument_1]);
    }
    return $statement;
  }

  //Выбор данных и сортировка
  public function select($description)
  {
    $query = 'SELECT * FROM tasks ORDER BY id';
    if ($description === 'description') {
      $query = 'SELECT * FROM tasks ORDER BY description';
    }
    if ($description === 'is_done') {
      $query = 'SELECT * FROM tasks ORDER BY is_done';
    }
    if ($description === 'date_added') {
      $query = 'SELECT * FROM tasks ORDER BY date_added';
    }
    return $this->executeStatement($query, '', '');
  }

  //Добавление задачи
  public function insert($description)
  {
    $query = 'INSERT INTO tasks (description, is_done, date_added) VALUE (?, 0, NOW())';
    $this->executeStatement($query, $description, '');
  }

  //Редактирование статуса задачи
  public function updateIsDone($id)
  {
    $query = 'UPDATE tasks SET is_done = 1 WHERE id = ?';
    $this->executeStatement($query, $id, '');
  }

  //Возвращает описание задачи по id
  public function selectTaskById($id)
  {
    $query = 'SELECT * FROM tasks WHERE id = ?';
    $statement = $this->executeStatement($query, $id, '');
    foreach ($statement as $row) {
      return $row['description'];
    }
  }

  //Редактирование описания задачи
  public function updateDescription($description, $id)
  {
    $query = 'UPDATE tasks SET description = :description WHERE id = :id';
    $this->executeStatement($query, $description, $id);
  }

  //Удаление задачи
  public function delete($id)
  {
    $query = 'DELETE FROM tasks WHERE id = ?';
    $this->executeStatement($query, $id, '');
  }
}