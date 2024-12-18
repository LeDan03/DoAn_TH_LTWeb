<?php
class Db
{
  private $rowCount;
  private $dbh = null;

  public function __construct()
  {
    $dsn = "mysql:host=localhost;dbname=ql_chitieu";
    try {
      $this->dbh = new PDO($dsn, "root", "");
      $this->dbh->query("set names 'utf8'");
    } catch (PDOException $e) {
      echo "Err:" . $e->getMessage();
      exit();
    }
  }
  public function __destruct()
  {
    $this->dbh = null;
  }
  public function getRowCount()
  {
    return $this->rowCount;
  }
  private function query($sql, $arr = array(), $mode = PDO::FETCH_ASSOC)
  {
    $stm = $this->dbh->prepare($sql);
    if (!$stm->execute($arr)) {
      echo "Sql lỗi.";
      exit;
    }
    $this->rowCount = $stm->rowCount();
    return $stm->fetchAll($mode);
  }
  public function select($sql, $arr = array(), $mode = PDO::FETCH_ASSOC)
  {
    return $this->query($sql, $arr, $mode);
  }
  // public function insert($sql, $arr = array(), $mode = PDO::FETCH_ASSOC){
  //   $this->query($sql, $arr, $mode);
  //   return $this->dbh->lastInsertId();
  // }

  public function insert($sql, $arr = array(), $mode = PDO::FETCH_ASSOC)
  {
    try {
      $stmt = $this->dbh->prepare($sql);
      $stmt->execute($arr);

      $insertedId = $this->dbh->lastInsertId();
      if ($insertedId)
        return $insertedId;
      else 
        return false;
    } catch (PDOException $e) {
      return false;
    }
  }
  public function insert_charPK($sql, $arr = array(), $mode = PDO::FETCH_ASSOC) {
    try {
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute($arr);

        if ($stmt->rowCount() > 0) {
            return true; 
        } else {
            return false; 
        }
    } catch (PDOException $e) {
        echo "Error in insert: " . $e->getMessage(); 
        return false;
    }
}


  public function update($sql, $arr = array(), $mode = PDO::FETCH_ASSOC)
  {
    $this->query($sql, $arr, $mode);
    return $this->getRowCount();
  }
  public function delete($sql, $arr = array(), $mode = PDO::FETCH_ASSOC)
  {
    $this->query($sql, $arr, $mode);
    return $this->getRowCount();
  }
}
